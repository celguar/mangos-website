<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>$lang['forums_manage'],'link'=>'index.php?n=admin&sub=forum');
if(!$_GET['action']){
    if($_GET['cat_id']){
        $items = $DB->select("
            SELECT * FROM f_forums 
            JOIN f_categories ON f_forums.cat_id=f_categories.cat_id 
            WHERE f_forums.cat_id=?d ORDER BY disp_position,forum_name",$_GET['cat_id']);
        $pathway_info[] = array('title'=>$items[0]['cat_name'],'link'=>'');
    }elseif($_GET['forum_id']){
        
    }else{
        $pathway_info[] = array('title'=>$lang['categories'],'link'=>'');
        $items = $DB->select("SELECT * FROM f_categories ORDER BY cat_disp_position,cat_name");
    }
}elseif($_GET['action']=='moveup'){
    moveup($_GET['cat_id'],$_GET['forum_id']);
    redirect($MW->getConfig->temp->site_href."index.php?n=admin&sub=forum",1);
    // redirect($MW->getConfig->temp->site_href."index.php?n=admin&sub=forum&cat_id=".$_GET['cat_id']."&forum_id=".$_GET['forum_id'],1);
}elseif($_GET['action']=='movedown'){
    movedown($_GET['cat_id'],$_GET['forum_id']);
    redirect($MW->getConfig->temp->site_href."index.php?n=admin&sub=forum",1);
   // redirect($MW->getConfig->temp->site_href."index.php?n=admin&sub=forum&cat_id=".$_GET['cat_id']."&forum_id=".$_GET['forum_id'],1);
}elseif($_GET['action']=='open'){
    $DB->query("UPDATE f_forums SET closed=0 WHERE forum_id=?d LIMIT 1",$_GET['forum_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='close'){
    $DB->query("UPDATE f_forums SET closed=1 WHERE forum_id=?d LIMIT 1",$_GET['forum_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='show'){
    $DB->query("UPDATE f_forums SET hidden=0 WHERE forum_id=?d LIMIT 1",$_GET['forum_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='hide'){
    $DB->query("UPDATE f_forums SET hidden=1 WHERE forum_id=?d LIMIT 1",$_GET['forum_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='updforumsorder'){
    foreach($_POST['forumorder'] as $fid=>$order){
        $DB->query("UPDATE f_forums SET disp_position=?d WHERE forum_id=?d LIMIT 1",$order,$fid);
    }
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='newcat'){
    $DB->query("INSERT INTO f_categories SET ?a",$_POST);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='newforum'){
    $DB->query("INSERT INTO f_forums SET ?a",$_POST);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='recount'){
    recount($_GET['forum_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='deleteforum'){
    delete_forum($_GET['forum_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='deletecat'){
    delete_cat($_GET['cat_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}


function recount($fid){
    global $DB;
    $c_topics = $DB->selectCell("SELECT count(*) FROM f_topics WHERE forum_id=?d",$fid);
    $c_posts = $DB->selectCell("SELECT count(*) FROM f_topics RIGHT JOIN f_posts ON f_topics.topic_id=f_posts.topic_id WHERE forum_id=?d",$fid);
    $last_topic_id = $DB->selectCell("SELECT topic_id FROM f_topics WHERE forum_id=?d ORDER BY last_post DESC LIMIT 1",$fid);
    $DB->query("UPDATE f_forums SET num_topics=?d,num_posts=?d,last_topic_id=?d WHERE forum_id=?d LIMIT 1",
    $c_topics,$c_posts,$last_topic_id,$fid);
}
function move_topic($topic_id,$from_fid,$to_fid){
    global $DB;
    $this_topic = $DB->selectRow("SELECT * FROM f_topics WHERE topic_id=?d",$topic_id);
    $DB->query("UPDATE f_topics SET forum_id=?d WHERE topic_id=?d LIMIT 1",$to_fid,$topic_id);
    $DB->query("UPDATE f_forums SET num_topics=num_topics-1,num_posts=num_posts-?d WHERE forum_id=?d LIMIT 1",$this_topic['num_replies'],$from_fid);
    $DB->query("UPDATE f_forums SET num_topics=num_topics+1,num_posts=num_posts+?d WHERE forum_id=?d LIMIT 1",$this_topic['num_replies'],$from_fid);
}
function moveup($cat_id,$forum_id=0){
    global $DB;
    if($forum_id>0){
        $cur_pos = $DB->selectCell("SELECT disp_position FROM f_forums WHERE forum_id=?d",$forum_id);
        $target_pos = $DB->selectRow("SELECT * FROM f_forums WHERE disp_position<?d AND forum_id=?d ORDER BY disp_position DESC LIMIT 1",$cur_pos,$forum_id);
        $DB->query("UPDATE f_forums SET disp_position=?d WHERE forum_id=?d LIMIT 1",$target_pos['disp_position'],$forum_id);
        $DB->query("UPDATE f_forums SET disp_position=?d WHERE forum_id=?d LIMIT 1",$cur_pos,$target_pos['forum_id']);
    }else{
        $cur_pos = $DB->selectCell("SELECT cat_disp_position FROM f_categories WHERE cat_id=?d",$cat_id);
        $target_pos = $DB->selectRow("SELECT * FROM f_categories WHERE cat_disp_position<?d ORDER BY cat_disp_position DESC LIMIT 1",$cur_pos);
        $DB->query("UPDATE f_categories SET cat_disp_position=?d WHERE cat_id=?d LIMIT 1",$target_pos['cat_disp_position'],$cat_id);
        $DB->query("UPDATE f_categories SET cat_disp_position=?d WHERE cat_id=?d LIMIT 1",$cur_pos,$target_pos['cat_id']);
    }
}
function movedown($cat_id,$forum_id=0){
    global $DB;
    if($forum_id>0){
        $cur_pos = $DB->selectCell("SELECT disp_position FROM f_forums WHERE forum_id=?d",$forum_id);
        $target_pos = $DB->selectRow("SELECT * FROM f_forums WHERE disp_position>?d AND forum_id=?d ORDER BY disp_position ASC LIMIT 1",$cur_pos,$forum_id);
        $DB->query("UPDATE f_forums SET disp_position=?d WHERE forum_id=?d LIMIT 1",$target_pos['disp_position'],$forum_id);
        $DB->query("UPDATE f_forums SET disp_position=?d WHERE forum_id=?d LIMIT 1",$cur_pos,$target_pos['forum_id']);
    }else{
        $cur_pos = $DB->selectCell("SELECT cat_disp_position FROM f_categories WHERE cat_id=?d",$cat_id);
        $target_pos = $DB->selectRow("SELECT * FROM f_categories WHERE cat_disp_position>?d ORDER BY cat_disp_position ASC LIMIT 1",$cur_pos);
        $DB->query("UPDATE f_categories SET cat_disp_position=?d WHERE cat_id=?d LIMIT 1",$target_pos['cat_disp_position'],$cat_id);
        $DB->query("UPDATE f_categories SET cat_disp_position=?d WHERE cat_id=?d LIMIT 1",$cur_pos,$target_pos['cat_id']);
    }
}
function delete_cat($cat_id){
    global $DB;
    $cat_forums = $DB->selectCol("SELECT forum_id FROM f_forums WHERE cat_id=?d",$cat_id);
    foreach ($cat_forums as $forum_id) {
        delete_forum($forum_id);
    }
    $DB->query("DELETE FROM f_categories WHERE cat_id=?d",$cat_id);
}
function delete_forum($forum_id){
    global $DB;
    $forum_topics = $DB->selectCol("SELECT topic_id FROM f_topics WHERE forum_id=?d",$forum_id);
    $DB->query("DELETE FROM f_posts WHERE topic_id IN (?a)",$forum_topics);
    $DB->query("DELETE FROM f_topics WHERE forum_id=?d",$forum_id);
    $DB->query("DELETE FROM f_forums WHERE forum_id=?d",$forum_id);
}
?>
