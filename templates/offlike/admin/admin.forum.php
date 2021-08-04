<br>
<?php builddiv_start(0, $lang['forums']) ?>
<style type="text/css">
dt.page_label { background: transparent url(<?php echo $currtmp; ?>/images/icons/page_copy.gif) no-repeat 0 50%; }
dt.topic_started_label, dt.last_activity_label { background: transparent url(<?php echo $currtmp; ?>/images/icons/time.gif) no-repeat 0 50%; }
dt.last_reply_label, dt.by_label { background: transparent url(<?php echo $currtmp; ?>/images/icons/user_comment.gif) no-repeat 0 50%; }

dd.topic_content { background: transparent url(<?php echo $currtmp; ?>/images/icons/resultset_next.gif) no-repeat 0 50%; }
dd.t_closed { background: transparent url(<?php echo $currtmp; ?>/images/icons/stop.gif) no-repeat 0 50%; }

dl.topic_view, 
dl.topic_view dt, 
dl.topic_view dd { margin: 0; }
dl.topic_view dt.topic_label,
dl.topic_view dt.desc_label,
dl.topic_view dt.reply_label,
dl.topic_view dt.topics_label,
dl.topic_view dt.posts_label { display: none }

dl.topic_view { 
    position: relative;
    background-color: #FEF5DA;
    padding: 10px 80px 11px 10px;
  margin: 0;
    margin-top: -0.1em; /* fix for 1px rouding error problem */
    border-top: 1px solid #DDD;
    border-bottom: 1px solid #DDD;
    line-height: 1.8em; }
    
dl.topic_index {
    background-color: #E8EEFA;
  margin: 0;
   /* padding-right: 155px;*/ }

dl.sticky_topic {
    background-color: #FCE3E2; }

    dl.topic_view dt { 
        position: relative;
        float: left;
        padding-right: .5em;
        padding-left: 20px; }
        
    dl.topic_view dd {
        display: block; }

    dl.topic_view dd.topic_content {
        display: block;
        padding-left: 20px;
        font-size: 1.2em;
        font-weight: bold; }

    dl.topic_view dd.desc_content {
        display: block;
        padding-left: 20px;
        margin-bottom: 1em;
        line-height: 1.5em; }

    dl.topic_view dd.reply_content, dl.topic_view dd.topics_content,
    dl.topic_view dd.posts_content {
        position: relative;
        top: 5px;
        width: 50px;
        margin: 0;
        padding: 5px;
        text-align: center;
        font-weight: bold;
        color: #8BBD17; }
        
    dl.topic_view dd.topics_content { color: #698E11; }
    
        dl.topic_view dd.reply_content span, dl.topic_view dd.topics_content span,
        dl.topic_view dd.posts_content span { display: block; }
        
        dl.topic_view dd.reply_content span { font-size: 1.5em; }
        
        dl.topic_view dd.topics_content span, 
        dl.topic_view dd.posts_content span { font-size: 1.3em; }

    dl.topic_view dd.reply_content, dl.topic_view dd.posts_content { right: 25px; line-height: 1.5em; }
*html    dl.topic_view dd.reply_content, dl.topic_view dd.posts_content { right: 5px; line-height: 1.5em; }
    
    dl.topic_view dd.topics_content { right: 75px; line-height: 1.5em; }
</style>
<div class="sections subsections" style="font-size:0.8em;">
<?php if(empty($_GET['action'])){ ?>
<?php if(isset($_GET['cat_id'])){ ?>
<form method="post" action="index.php?n=admin&sub=forum&action=updforumsorder">
<?php foreach($items as $item_c => $item){ ?>
    <hr class="hidden" />
    <dl class="topic_view" style="padding:1px;padding-left:5px;">
        <dt class="topic_label">aa</dt>
        <dd class="" style="font-size:11px;">
            <?php if($item['closed']==0){ ?><a title="<?php echo $lang['close'];?>" href="index.php?n=admin&sub=forum&action=close&forum_id=<?php echo $item['forum_id'];?>"><img src="<?php echo $currtmp; ?>/images/icons2/normal_post.gif" align="absmiddle"></a><?php } ?>
            <?php if($item['closed']==1){ ?><a title="<?php echo $lang['open'];?>" href="index.php?n=admin&sub=forum&action=open&forum_id=<?php echo $item['forum_id'];?>"><img src="<?php echo $currtmp; ?>/images/icons2/normal_post_locked.gif" align="absmiddle"></a><?php } ?>
            <?php if($item['hidden']==0){ ?><a title="<?php echo $lang['hide'];?>" href="index.php?n=admin&sub=forum&action=hide&forum_id=<?php echo $item['forum_id'];?>"><img src="<?php echo $currtmp; ?>/images/icons2/normal_post_sticky.gif" align="absmiddle"></a><?php } ?>
            <?php if($item['hidden']==1){ ?><a title="<?php echo $lang['show'];?>" href="index.php?n=admin&sub=forum&action=show&forum_id=<?php echo $item['forum_id'];?>"><img src="<?php echo $currtmp; ?>/images/icons2/my_normal_post.gif" align="absmiddle"></a><?php } ?>
            <a title="<?php echo $lang['recount'];?>" href="index.php?n=admin&sub=forum&action=recount&forum_id=<?php echo $item['forum_id'];?>"><img src="<?php echo $currtmp; ?>/images/icons2/normal_poll.gif" align="absmiddle"></a>
            <b><?php echo $item['forum_name'];?></b> / <?php echo $item['forum_desc'];?>
            <span style="position:relative; float:right;">
            <a title="<?php echo $lang['dodelete'];?>" href="index.php?n=admin&sub=forum&action=deleteforum&forum_id=<?php echo $item['forum_id'];?>" onclick="return confirm('Are you sure?');"><img src="<?php echo $currtmp; ?>/images/icons/bin_closed.gif" align="absmiddle"></a> &nbsp; 
            </span>
      </dd>
        <dt class="topic_started_label"></dt>
        <dd class="topic_started_content">
            &nbsp;&nbsp;<?php echo $lang['order'];?>: <input type="text" size="1" name="forumorder[<?php echo $item['forum_id'];?>]" value="<?php echo $item['disp_position'];?>">
            <?php if($item_c > 0){ ?><a href="index.php?n=admin&sub=forum&action=moveup&cat_id=<?php echo $item['cat_id'];?>&forum_id=<?php echo $item['forum_id'];?>"><img src="<?php echo $currtmp; ?>/images/icons/resultset_up.gif" align="absmiddle"></a><?php } ?>
            <?php if($item_c < count($items)-1){ ?><a href="index.php?n=admin&sub=forum&action=movedown&cat_id=<?php echo $item['cat_id'];?>&forum_id=<?php echo $item['forum_id'];?>"><img src="<?php echo $currtmp; ?>/images/icons/resultset_down.gif" align="absmiddle"></a><?php } ?>
        </dd>
    </dl>
<?php } ?>
    <input type="submit" value="<?php echo $lang['doupdate'];?>">
</form>
<hr />
<form method="post" action="index.php?n=admin&sub=forum&action=newforum">
    <input type="hidden" name="cat_id" value="<?php echo $_GET['cat_id'];?>"> 
    <?php echo $lang['l_name'];?>:<input type="text" name="forum_name"> 
    <?php echo $lang['l_desc'];?>:<input type="text" name="forum_desc"> 
    <?php echo $lang['order'];?>:<input type="text" name="disp_position" size="1" value="<?php echo count($items)+1;?>"> 
    <input type="submit" value="<?php echo $lang['donewforum'];?>"> 
</form>
<?php }else{ ?>
<form method="post" action="index.php?n=admin&sub=forum&action=updcategories">
<?php foreach($items as $item_c => $item){ ?>
    <hr class="hidden" />
    <dl class="topic_view" style="padding:1px;padding-left:5px;">
        <dt class="topic_label">item</dt>
        <dd class="topic_content" style="font-size:11px;">
            <a href="index.php?n=admin&sub=forum&cat_id=<?php echo $item['cat_id'];?>"><b><?php echo $item['cat_name'];?></b></a> 
            <span style="position:relative; float:right;">
            <a title="<?php echo $lang['dodelete'];?>" href="index.php?n=admin&sub=forum&action=deletecat&cat_id=<?php echo $item['cat_id'];?>" onclick="return confirm('Are you sure?');"><img src="<?php echo $currtmp; ?>/images/icons/bin_closed.gif" align="absmiddle"></a> &nbsp; 
            </span>
        </dd>
        <dt class="topic_started_label"></dt>
        <dd class="topic_started_content">&nbsp;&nbsp;<?php echo $lang['order'];?>: <?php echo $item['cat_disp_position'];?>&nbsp;
            <?php if($item_c > 0){ ?><a href="index.php?n=admin&sub=forum&action=moveup&cat_id=<?php echo $item['cat_id'];?>"><img src="<?php echo $currtmp; ?>/images/icons/resultset_up.gif"></a><?php } ?>
            <?php if($item_c < count($items)-1){ ?><a href="index.php?n=admin&sub=forum&action=movedown&cat_id=<?php echo $item['cat_id'];?>"><img src="<?php echo $currtmp; ?>/images/icons/resultset_down.gif"></a><?php } ?>
            <input type="text" size="1" name="catorder[<?php echo $item['cat_id'];?>]" value="<?php echo $item['cat_disp_position'];?>">
        </dd>
    </dl>
<?php } ?>
    <input type="submit" value="<?php echo $lang['doupdate'];?>" style="float:right;clear:both;">
</form>
<br /><hr style="clear:both;" />
<form method="post" action="index.php?n=admin&sub=forum&action=newcat">
    <?php echo $lang['l_name'];?>: <input type="text" name="cat_name"> 
    <?php echo $lang['order'];?>: <input type="text" name="cat_disp_position" size="1" value="<?php echo count($items)+1;?>">
    <input type="submit" value="<?php echo $lang['donewcat'];?>">
</form>
<?php } ?>

<?php } ?>
<?php builddiv_end() ?>
</div>