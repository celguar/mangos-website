<?php
include('forum.func.php');
// ==================== //
if($user['id']>0)$queryparts = "
    SELECT f_categories.*,f_forums.*,f_topics.topic_name,f_topics.last_poster,f_topics.last_post,f_markread.* FROM f_categories 
    JOIN f_forums ON f_categories.cat_id=f_forums.cat_id 
    LEFT JOIN f_topics ON f_forums.last_topic_id=f_topics.topic_id 
    LEFT JOIN f_markread ON (f_markread.marker_forum_id=f_forums.forum_id AND f_markread.marker_member_id=".$user['id'].") 
";else$queryparts = "
    SELECT f_categories.*,f_forums.*,f_topics.topic_name,f_topics.last_poster,f_topics.last_post FROM f_categories 
    JOIN f_forums ON f_categories.cat_id=f_forums.cat_id 
    LEFT JOIN f_topics ON f_forums.last_topic_id=f_topics.topic_id 
";
if($user['g_forum_moderate']!=1)$queryparts .= "
    WHERE hidden!=1 
";
$queryparts .= "
    ORDER BY cat_disp_position,cat_name,disp_position,forum_name
";

$result = $DB->select($queryparts);

$items = array();

foreach($result as $item)
{
    if($user['id']>0){
        if($item['last_post'] > $item['marker_last_cleared']){
            $item['isnew']=true;
        }else{
            if($item['marker_unread']>0){
                $item['isnew']=true;
            }else{
                $item['isnew']=false;
            }
        }
    }else{
        $item['isnew']=false;
    }
    if(date('d',$item['last_post'])==date('d') && $_SERVER['REQUEST_TIME']-$item['last_post']<86400)$item['last_post'] = $lang['today_at'].' '.date('H:i:s',$item['last_post']);
    elseif(date('d',$item['last_post'])==date('d',$yesterday_ts) && $_SERVER['REQUEST_TIME']-$item['last_post']<2*86400)$item['last_post'] = $lang['yesterday_at'].' '.date('H:i:s',$item['last_post']);
    else $item['last_post'] = date('d-m-Y, H:i:s',$item['last_post']);
    
    $item['linktothis'] = mw_url("forum", "viewforum", array("fid"=>$item['forum_id']));
    $item['linktolastpost'] = mw_url("forum", "viewtopic", array("tid"=>$item['last_topic_id'], "to"=>"lastpost")); 
    $item['linktoprofile'] = mw_url("account", "view", array("action"=>"find", "name"=>$item['last_poster'])); 
    
    $items[$item['cat_id']][] = $item;
}
unset($result);
?>
