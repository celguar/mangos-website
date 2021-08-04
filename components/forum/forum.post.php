<?php
include('forum.func.php');

if($_GETVARS['post']>0)$this_post = get_post_byid($_GETVARS['post']);
$this_post['topic_id']>0?$_GETVARS['t']=$this_post['topic_id']:0;
if($_GETVARS['t']>0)$this_topic = get_topic_byid($_GETVARS['t']);
$this_topic['forum_id']>0?$_GETVARS['f']=$this_topic['forum_id']:0;
if($_GETVARS['f']>0)$this_forum = get_forum_byid($_GETVARS['f']);
// ==================== //
$pathway_info[] = array('title'=>$this_forum['forum_name'],'link'=>'index.php?n=forum&sub=viewforum&fid='.$this_forum['forum_id'].'');
if($_GETVARS['t'])$pathway_info[] = array('title'=>$this_topic['topic_name'],'link'=>'index.php?n=forum&sub=viewtopic&tid='.$this_topic['topic_id'].'');
if($_GET['action']=='newtopic')$pathway_info[] = array('title'=>$lang['newtopic'],'link'=>'');
elseif($_GET['action']=='newpost')$pathway_info[] = array('title'=>$lang['newpost'],'link'=>'');
elseif($_GET['action']=='edittopic')$pathway_info[] = array('title'=>$lang['edittopic'],'link'=>'');
elseif($_GET['action']=='editpost')$pathway_info[] = array('title'=>$lang['editpost'],'link'=>'');
// ==================== //
$post_time = time();

if(!isValidChar($user)){
    output_message('alert', 'You must select a character before you can post');
}elseif($user['id']>0){

if($_GET['action']=='donewtopic' && $this_forum['forum_id']>0){
    if(($user['g_post_new_topics']==1 && $this_forum['closed']!=1) || $user['g_forum_moderate']==1){
        if($_POST['subject'] && $_POST['text']){
            $message = my_preview($_POST['text']);
            
            $new_topic_id = $DB->query("INSERT INTO f_topics (topic_poster_id,topic_poster,topic_name,topic_posted,forum_id) VALUES (?,?,?,?d,?d)",
                $user['id'],$user['character_name'],htmlspecialchars($_POST['subject']),$post_time,$this_forum['forum_id']);
            
            $new_post_id = $DB->query("INSERT INTO f_posts (poster,poster_id,poster_character_id,poster_ip,message,posted,topic_id) VALUES (?,?d,?d,?,?,?d,?d)",
                $user['character_name'],$user['id'],$user['character_id'],$user['ip'],$message,$post_time,$new_topic_id);
            
            $DB->query("UPDATE account_extend SET forum_posts=forum_posts+1 WHERE account_id=?d",$user['id']);
                    
            $DB->query("UPDATE f_topics SET last_post=?d, last_post_id=?d, last_poster=? WHERE topic_id=?d",
                $post_time,$new_post_id,$user['character_name'],$new_topic_id);
            
            $DB->query("UPDATE f_forums SET num_topics=num_topics+1, num_posts=num_posts+1,last_topic_id=?d WHERE forum_id=?d",
                $new_topic_id,$this_forum['forum_id']);
            
            redirect($MW->getConfig->temp->site_href."index.php?n=forum&sub=viewtopic&tid=".$new_topic_id."",1);
        }
    }
}elseif($_GET['action']=='newtopic' && $this_forum['forum_id']>0){
    if(($user['g_post_new_topics']==1 && $this_forum['closed']!=1) || $user['g_forum_moderate']==1){
        $content['text'] = '';
        $content['subject'] = '';
    }else{
        output_message('alert',$lang['youhavenorights']);
        $req_tpl = false;
    }
}elseif($_GET['action']=='newpost'){
    if(!$user['g_reply_other_topics']) {
        exit("You are not authorized to reply to this topic.  Nice try hacking");
    }

    $content['text'] = '';
    if($_GET['quote']){
    $q_post = get_post_byid($_GET['quote']);
    $content['text'] = '[blockquote="'.$q_post['poster'].' | '.date('d-m-Y, H:i:s',$q_post['posted']).'"] '.my_previewreverse($q_post['message']).' [/blockquote]';
    }
}elseif($_GET['action']=='editpost' && $this_post['post_id']>0){
    if(!(($user['id']==$this_post['poster_id'] && $user['g_edit_own_posts']) || ($user['g_forum_moderate']))) {
        exit("You are not authorized to edit this post.  Nice try hacking");
    }
    
    $content['text'] = my_previewreverse($this_post['message']);
}elseif($_GET['action']=='movetopic' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0){
    if($user['group']>=1){
        
    }
}elseif($_GET['action']=='doeditpost' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0 && $this_post['post_id']>0){
    if(!(($user['id']==$this_post['poster_id'] && $user['g_edit_own_posts']) || ($user['g_forum_moderate']))) {
        exit("You are not authorized to edit this post.  Nice try hacking");
    }
    
    $message = my_preview($_POST['text']);
    $DB->query("UPDATE f_posts SET message=?, edited=?d, edited_by=? WHERE post_id=?d",
        $message,$post_time,$user['character_name'],$this_post['post_id']);
    
    redirect($MW->getConfig->temp->site_href."index.php?n=forum&sub=viewtopic&tid=".$this_topic['topic_id']."&to=".$this_post['post_id'],1);
}elseif($_GET['action']=='donewpost' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0){
    if(!$user['g_reply_other_topics']) {
        exit("You are not authorized to write new posts.  Nice try hacking");
    }
    
    $db_topic_count = $DB->selectCell("SELECT count(*) from `f_topics` where topic_id = ?", $this_topic['topic_id']);
        
    if($db_topic_count == 0) {
        if(!$user['g_post_new_topics']) {
            exit("You are not authorized to post new topics.  Nice try hacking");
        }
    }
    else {
        if(!$user['g_reply_other_topics']) {
            exit("You are not authorized to post replies to this post.  Nice try hacking");
        }
    }
    
    $message = my_preview($_POST['text']);
    if($_POST['text']){
        $new_post_id = $DB->query("INSERT INTO f_posts (poster,poster_id,poster_character_id,poster_ip,message,posted,topic_id) VALUES (?,?d,?d,?,?,?d,?d)",
            $user['character_name'],$user['id'],$user['character_id'],$user['ip'],$message,$post_time,$this_topic['topic_id']);
        
        $DB->query("UPDATE account_extend SET forum_posts=forum_posts+1 WHERE account_id=?d",$user['id']);
                
        $DB->query("UPDATE f_topics SET last_post=?d, last_post_id=?d, last_poster=?, num_replies=num_replies+1 WHERE topic_id=?d",
            $post_time,$new_post_id,$user['character_name'],$this_topic['topic_id']);
        
        $DB->query("UPDATE f_forums SET num_posts=num_posts+1,last_topic_id=?d WHERE forum_id=?d",
            $this_topic['topic_id'],$this_forum['forum_id']);
    }    
    redirect($MW->getConfig->temp->site_href."index.php?n=forum&sub=viewtopic&tid=".$this_topic['topic_id']."&to=lastpost",1);
}elseif($_GET['action']=='dodeletepost' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0 && $this_post['post_id']>0){
    if(($this_post['poster_id']==$user['id'] && $user['g_delete_own_posts']==1) || $user['g_forum_moderate']==1){
        $DB->query("DELETE FROM f_posts WHERE post_id=?d LIMIT 1",$this_post['post_id']);
        if($this_post['poster_id']==$user['id']){
            $DB->query("UPDATE account_extend SET forum_posts=forum_posts-1 WHERE account_id=?d",$user['id']);
        }
        $new_last_post = get_last_topic_post($this_topic['topic_id']);
        $DB->query("UPDATE f_topics SET last_post=?d, last_post_id=?d, last_poster=?, num_replies=num_replies-1 WHERE topic_id=?d",
            $new_last_post['posted'],$new_last_post['post_id'],$new_last_post['poster'],$this_topic['topic_id']);
        $new_last_topic = get_last_forum_topic($this_forum['forum_id']);
        $DB->query("UPDATE f_forums SET num_posts=num_posts-1, last_topic_id=?d WHERE forum_id=?d",
            $new_last_topic['topic_id'],$this_forum['forum_id']);
    }
    redirect($MW->getConfig->temp->site_href."index.php?n=forum&sub=viewtopic&tid=".$this_topic['topic_id']."&to=lastpost",1);
}elseif($_GET['action']=='dodeletetopic' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0){
    if(($this_topic['topic_poster_id']==$user['id'] && $user['g_delete_own_topics']==1) || $user['g_forum_moderate']==1){
        $DB->query("DELETE FROM f_posts WHERE topic_id=?d",$this_topic['topic_id']);
        $DB->query("DELETE FROM f_topics WHERE topic_id=?d LIMIT 1",$this_topic['topic_id']);
        $new_last_topic = get_last_forum_topic($this_forum['forum_id']);
        $DB->query("UPDATE f_forums SET num_topics=num_topics-1, num_posts=num_posts-?d, last_topic_id=?d WHERE forum_id=?d",
            $this_topic['num_replies'],$new_last_topic['topic_id'],$this_topic['forum_id']);
    }
    redirect($MW->getConfig->temp->site_href."index.php?n=forum&sub=viewforum&fid=".$this_forum['forum_id'].'',1);
}elseif($_GET['action']=='opentopic' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0 && $user['g_forum_moderate']==1){
    $DB->query("UPDATE f_topics SET closed=0 WHERE topic_id=?d LIMIT 1",$this_topic['topic_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='closetopic' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0 && $user['g_forum_moderate']==1){
    $DB->query("UPDATE f_topics SET closed=1 WHERE topic_id=?d LIMIT 1",$this_topic['topic_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='sticktopic' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0 && $user['g_forum_moderate']==1){
    $DB->query("UPDATE f_topics SET sticky=1 WHERE topic_id=?d LIMIT 1",$this_topic['topic_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='unsticktopic' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0 && $user['g_forum_moderate']==1){
    $DB->query("UPDATE f_topics SET sticky=0 WHERE topic_id=?d LIMIT 1",$this_topic['topic_id']);
    redirect($_SERVER['HTTP_REFERER'],1);
}elseif($_GET['action']=='domovetopic' && $this_forum['forum_id']>0 && $this_topic['topic_id']>0 && $_GET['to']>0){
    /*
    if($user['group']>=1){
        $DB->query("DELETE FROM `f_markread` WHERE `topic_id`='".$this_topic['topic_id']."'");
        $new_last_topic_1 = get_last_forum_topic($this_forum['forum_id']);
        $new_last_topic_2 = get_last_forum_topic($_GET['to']);
        $DB->query("UPDATE `f_forums` SET 
        `num_topics`=num_topics-1, `num_posts`=num_posts-".$this_topic['num_replies'].", 
        `last_topic_time`='".$new_last_topic_1['last_post']."', `last_topic_id`='".$new_last_topic_1['id']."', 
        `last_poster`='".$DB->escape($new_last_topic_1['last_poster'])."', `last_topic_name`='".$DB->escape($new_last_topic_1['topic_name'])."' 
        WHERE `id`='".$this_topic['forum_id']."'");
        $DB->query("UPDATE `f_forums` SET 
        `num_topics`=num_topics+1, `num_posts`=num_posts+".$this_topic['num_replies'].", 
        `last_topic_time`='".$new_last_topic_2['last_post']."', `last_topic_id`='".$new_last_topic_2['id']."', 
        `last_poster`='".$DB->escape($new_last_topic_2['last_poster'])."', `last_topic_name`='".$DB->escape($new_last_topic_2['topic_name'])."' 
        WHERE `id`='".$DB->escape($_GET['to'])."'");
        $DB->query("UPDATE `f_topics` SET `forum_id`='".$DB->escape($_GET['to'])."' WHERE `id`='".$this_topic['topic_id']."'");
        
    }
    header("location:index.php?n=forum/viewforum&fid=".$_GET['to']);
    */
}

}
?>
