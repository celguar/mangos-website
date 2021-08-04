<?php
include('forum.func.php');

$this_forum = get_forum_byid($_GET['fid']);
if($this_forum['forum_id']<=0)exit('This forum does not exist.');
$this_forum['linktonewtopic'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=post&action=newtopic&f='.$this_forum['forum_id'].'';
$this_forum['linktomarkread'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=viewforum&fid='.$this_forum['forum_id'].'&markread=1';
// ==================== //
$pathway_info[] = array('title'=>$this_forum['forum_name'],'link'=>'');
// ==================== //
// MARKREAD //
if($user['id']>0){
    $topicsmark = array();
    if($_GETVARS['markread']==1){
        $DB->query("
            UPDATE f_markread 
            SET marker_topics_read=?,marker_last_update=?d,marker_unread=0,marker_last_cleared=?d 
            WHERE marker_member_id=?d AND marker_forum_id=?d
            ",serialize($topicsmark),$_SERVER['REQUEST_TIME'],$_SERVER['REQUEST_TIME'],$user['id'],$this_forum['forum_id']);
        redirect($MW->getConfig->temp->site_href.'index.php?n=forum&sub=viewforum&fid='.$this_forum['forum_id'],1);
    }
    $mark = $DB->selectRow("
        SELECT * FROM f_markread 
        WHERE marker_member_id=?d AND marker_forum_id=?d
        ",$user['id'],$this_forum['forum_id']);
    if(!$mark)$DB->query("
        INSERT INTO f_markread 
        SET marker_member_id=?d,marker_forum_id=?d,marker_topics_read=?"
        ,$user['id'],$this_forum['forum_id'],serialize(array()));
    if($mark['marker_topics_read'])$topicsmark = unserialize($mark['marker_topics_read']);
}
//===== Calc pages =====//
$items_per_pages = (int)$MW->getConfig->generic->topics_per_page;
$itemnum = $this_forum['num_topics'];
$pnum = ceil($itemnum/$items_per_pages);
$limit_start = ($p-1)*$items_per_pages;
$this_forum['pnum'] = $pnum;

$topics = array();
$alltopics = $DB->select("
    SELECT f_topics.*,account.username 
    FROM f_topics 
    LEFT JOIN account ON f_topics.topic_poster_id=account.id 
    WHERE forum_id=?d 
    ORDER BY sticky DESC,last_post DESC 
    LIMIT ?d,?d",$this_forum['forum_id'],$limit_start,$items_per_pages);
foreach($alltopics as $cur_topic)
{
    if($user['id']>0 && $cur_topic['last_post'] > $mark['marker_last_cleared']){
        $cur_topic['isnew']=true;
        if($cur_topic['last_post'] > $topicsmark[$cur_topic['topic_id']]){
            $cur_topic['isnew']=true;
        }else{
            $cur_topic['isnew']=false;
        }
    }else{
        $cur_topic['isnew']=false;
    }
    
    $pnum = ceil($cur_topic['num_replies']/(int)$MW->getConfig->generic->posts_per_page);
    if($pnum>1){
        $cur_topic['pages_str'] = '&laquo; ';
        for($pi=1;$pi<=$pnum;$pi++){ $cur_topic['pages_str'].='<a href="index.php?n=forum&sub=viewtopic&tid='.$cur_topic['topic_id'].'&p='.$pi.'">'.$pi.'</a> '; }
        $cur_topic['pages_str'] .= ' &raquo;';
    }
    $cur_topic['pnum'] = $pnum;
    if(date('d',$cur_topic['topic_posted'])==date('d') && $_SERVER['REQUEST_TIME']-$cur_topic['topic_posted']<86400)$cur_topic['topic_posted'] = $lang['today_at'].date('H:i',$cur_topic['topic_posted']);
    elseif(date('d',$cur_topic['topic_posted'])==date('d',$yesterday_ts) && $_SERVER['REQUEST_TIME']-$cur_topic['topic_posted']<2*86400)$cur_topic['topic_posted'] = $lang['yesterday_at'].date('H:i',$cur_topic['topic_posted']);
    else $cur_topic['topic_posted'] = date('d-m-Y, H:i',$cur_topic['topic_posted']);
    
    if(date('d',$cur_topic['last_post'])==date('d') && $_SERVER['REQUEST_TIME']-$cur_topic['last_post']<86400)$cur_topic['last_post'] = $lang['today_at'].date('H:i',$cur_topic['last_post']);
    elseif(date('d',$cur_topic['last_post'])==date('d',$yesterday_ts) && $_SERVER['REQUEST_TIME']-$cur_topic['last_post']<2*86400)$cur_topic['last_post'] = $lang['yesterday_at'].date('H:i',$cur_topic['last_post']);
    else $cur_topic['last_post'] = date('d-m-Y, H:i',$cur_topic['last_post']);
    
    $cur_topic['linktothis'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=viewtopic&tid='.$cur_topic['topic_id'].'';
    $cur_topic['linktolastpost'] = $MW->getConfig->temp->site_href.'index.php?n=forum&sub=viewtopic&tid='.$cur_topic['topic_id'].'&to=lastpost';
    $cur_topic['linktoprofile1'] = $MW->getConfig->temp->site_href.'index.php?n=account&sub=view&action=find&name='.$cur_topic['username'].'';
    $cur_topic['linktoprofile2'] = $MW->getConfig->temp->site_href.'index.php?n=account&sub=view&action=find&name='.$cur_topic['last_poster'].'';
    
    $topics[] = $cur_topic;
}
unset($alltopics);
?>
