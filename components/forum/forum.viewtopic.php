<?php
include('forum.func.php');

$this_topic = get_topic_byid($_GET['tid']);
$this_forum = get_forum_byid($this_topic['forum_id']);
$this_topic['show_qr'] = $this_forum['quick_reply']==1?true:false;
if($this_forum['forum_id']<=0 || $this_topic['topic_id']<=0)exit('This forum or topic does not exist.');
// ================================================= //
$this_forum['linktothis'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=viewforum&fid='.$this_forum['forum_id'].'';
$this_forum['linktonewtopic'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=newtopic&f='.$this_forum['forum_id'].'';

$this_topic['linktothis'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=viewtopic&tid='.$this_topic['topic_id'].'';
$this_topic['linktoreply'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=newpost&t='.$this_topic['topic_id'];
$this_topic['linktopostreply'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=donewpost&t='.$this_topic['topic_id'];
$this_topic['linktodelete'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=dodeletetopic&t='.$this_topic['topic_id'];
$this_topic['linktoclose'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=closetopic&t='.$this_topic['topic_id'];
$this_topic['linktoopen'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=opentopic&t='.$this_topic['topic_id'];
$this_topic['linktostick'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=sticktopic&t='.$this_topic['topic_id'];
$this_topic['linktounstick'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=unsticktopic&t='.$this_topic['topic_id'];
$pathway_info[] = array('title'=>$this_forum['forum_name'],'link'=>$this_forum['linktothis']);
$pathway_info[] = array('title'=>$this_topic['topic_name'],'link'=>'');
// ================================================= //

$dtmp = "templates/".( string ) $MW->getConfig->generic->template;
$bgswitch = '2';
  //===== Calc pages =====//
  $items_per_pages = (int)$MW->getConfig->generic->posts_per_page;
  $itemnum = $this_topic['num_replies'];
  $pnum = ceil($itemnum/$items_per_pages);
  $limit_start = ($p-1)*$items_per_pages;

if($_GETVARS['to']=='lastpost'){
  redirect($this_topic['linktothis']."&p=".$pnum."#post".$this_topic['last_post_id'],1);
}elseif(is_numeric($_GETVARS['to'])){
  $f_post_pos = get_post_pos($this_topic['topic_id'],$_GETVARS['to']);
  $f_post_page = floor($f_post_pos/$items_per_pages)+1;
  redirect($this_topic['linktothis']."&p=".$f_post_page."#post".$_GETVARS['to'],1);
}else{
    // MARKREAD //
    if($user['id']>0){
        $topicsmark = array();
        $mark = $DB->selectRow("
            SELECT * FROM f_markread
            WHERE marker_member_id=?d AND marker_forum_id=?d
            ",$user['id'],$this_forum['forum_id']);
        if(!$mark)$DB->query("
            INSERT INTO f_markread
            SET marker_member_id=?d,marker_forum_id=?d,marker_topics_read=?
            ",$user['id'],$this_forum['forum_id'],serialize(array()));
        if($mark['marker_topics_read'])$topicsmark = unserialize($mark['marker_topics_read']);
        //  output_message('debug','<pre>'.print_r($topicsmark,true).'</pre>');
        $time_check = $topicsmark[$this_topic['topic_id']]>$mark['marker_last_cleared']?$topicsmark[$this_topic['topic_id']]:$mark['marker_last_cleared'];
        $read_topics_tid = array( 0 => $this_topic['topic_id'] );
        foreach($topicsmark as $tid => $date){
            if ( $date > $mark['marker_last_cleared'] )
            {
        $read_topics_tid[] = $tid;
            }
        }

        if($this_topic['last_post'] >= $time_check){
            // Count unread themes...
            $unread = $mark['marker_unread'] - 1;
            $topicsmark[$this_topic['topic_id']] = $_SERVER['REQUEST_TIME'];
            if($unread <= 0){
                $count = $DB->selectRow("
                SELECT count(*) as count,MIN(last_post) as min_last_post FROM f_topics
                WHERE last_post>?d AND topic_id NOT IN (?a) AND forum_id=?d
                ",$mark['marker_last_cleared'],$read_topics_tid,$this_forum['forum_id']);
                $unread = $count['count'];
                if( $unread > 0 AND ( is_array( $topicsmark ) and count( $topicsmark ) ) ){
                    $read_cutoff = $count['min_last_post'] - 1;
                    $topicsmark = array_filter($topicsmark,"clean_read_topics");
                    $save_markers = serialize($topicsmark);
                }else{
                    $save_markers = serialize(array());
                    $mark['marker_last_cleared'] = $_SERVER['REQUEST_TIME'];
                    $unread = 0;
                }
            }else{
                $save_markers = serialize($topicsmark);
            }

            $DB->query("
                UPDATE f_markread
                SET marker_topics_read=?,marker_last_update=?d,marker_unread=?d,marker_last_cleared=?d
                WHERE marker_member_id=?d AND marker_forum_id=?d
            ",$save_markers,$_SERVER['REQUEST_TIME'],$unread,$mark['marker_last_cleared'],$user['id'],$this_forum['forum_id']);
        }
    }
  $DB->query("UPDATE f_topics SET num_views=num_views+1 WHERE topic_id=?d LIMIT 1",$this_topic['topic_id']);
}

$result = $DB->select("
    SELECT * FROM f_posts
    LEFT JOIN account ON f_posts.poster_id=account.id
    LEFT JOIN website_accounts ON f_posts.poster_id=website_accounts.account_id
    LEFT JOIN website_account_groups ON website_accounts.g_id = website_account_groups.g_id
    WHERE topic_id=?d ORDER BY posted LIMIT ?d,?d",$this_topic['topic_id'],$limit_start,$items_per_pages);
foreach($result as $cur_post)
{
    unset($result['password']);
    // ================================================= //
    $cur_post['linktoprofile'] = $MW->getConfig->temp->site_href.'index.php?n=account&sub=view&action=find&name='.$cur_post['username'].'';
    $cur_post['linktopms'] = $MW->getConfig->temp->site_href.'index.php?n=account&sub=pms&action=add&to='.$cur_post['username'];
    $cur_post['linktothis'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=viewtopic&tid='.$this_topic['topic_id'].'&to='.$cur_post['post_id'];
    $cur_post['linktoquote'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=newpost&t='.$this_topic['topic_id'].'&quote='.$cur_post['post_id'];
    $cur_post['linktoedit'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=editpost&post='.$cur_post['post_id'];
    $cur_post['linktodelete'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=dodeletepost&post='.$cur_post['post_id'];
    // ================================================= //
    $charinfo = $CHDB->selectRow("SELECT c.race,c.class,c.level,c.gender,g.name as guild FROM characters c LEFT JOIN guild_member gm ON c.guid=gm.guid LEFT JOIN guild g ON gm.guildid=g.guildid WHERE c.guid=?d", $cur_post["poster_character_id"]);
    $cur_post['avatar'] = "$charinfo[gender]-$charinfo[race]-$charinfo[class].gif";//gender race class
	$cur_post['mini_race'] = "$charinfo[race]-$charinfo[gender].gif";
	$cur_post['mini_class'] = "$charinfo[class].gif";
    $cur_post['level'] = $charinfo['level'];
	if($charinfo['race']==1 || $charinfo['race']==3 || $charinfo['race']==4 || $charinfo['race']==7 || $charinfo['race']==11)$faction = 'alliance';
        else $faction = 'horde';
	$cur_post['faction'] = "$faction.gif";
    if (!empty($charinfo['guild'])) {
        $cur_post['guild'] = $charinfo['guild'];
    }
    $pnc++;
    if($bgswitch=='2')$bgswitch = '1';else $bgswitch = '2';
    $cur_post['bg'] = $bgswitch;
    $cur_post['pos_num'] = $pnc+(($p-1)*$items_per_pages);
    if(date('d',$cur_post['posted'])==date('d') && $_SERVER['REQUEST_TIME']-$cur_post['posted']<86400)$cur_post['posted'] = $lang['today_at'].date('H:i:s',$cur_post['posted']);
    elseif(date('d',$cur_post['posted'])==date('d',$yesterday_ts) && $_SERVER['REQUEST_TIME']-$cur_post['posted']<2*86400)$cur_post['posted'] = $lang['yesterday_at'].date('H:i:s',$cur_post['posted']);
    else $cur_post['posted'] = date('d-m-Y, H:i:s',$cur_post['posted']);
    $posts[] = $cur_post;
}
unset($result);

function clean_read_topics($var)
{
    global $read_cutoff;
    return $var > $read_cutoff;
}
?>
