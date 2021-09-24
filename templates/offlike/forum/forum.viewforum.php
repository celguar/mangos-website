<?php
//Check For External Or Framed Bugs Tracker
if( (int)$_REQUEST['fid'] == (int)$MW->getConfig->generic_values->forum->bugs_forum_id && (int)$MW->getConfig->generic_values->forum->externalbugstracker)
{
    if ((int)$MW->getConfig->generic_values->forum->frame_bugstracker)
    {
        echo "<center>";
        echo "</br>";
		echo "<iframe src=\"".(string)$MW->getConfig->generic_values->forum->bugstracker_external_link."\" style=\"height:1050;\" width=\"680\" frameborder=\"0\" scrolling=\"yes\">".$lang['not_support_inline_frames']."</iframe>";
    }
    else
        echo'<meta http-equiv=refresh content="0;url=\''.(string)$MW->getConfig->generic_values->forum->bugstracker_external_link.'\'">';
}
else
{
?>
<style media="screen" title="currentStyle" type="text/css">
    @import "<?php echo $currtmp; ?>/css/forums.css";
    @import "<?php echo $currtmp; ?>/css/master.css";
.Style1 {
	color: #666666;
	font-weight: bold;
}
</style>
<img src="<?php echo $currtmp; ?>/images/forum_head.jpg" border="0" width="100%" /><!--
<div><a href="board.html?forumId=11212&sid=2"><img src="http://forums.wow-europe.com/images/wow-base-general.gif" width="85" height="89" border="0" /></a></div><div style="position: absolute; margin: 95px 0 0 209px; http://forums.wow-europe.com/images/fr_FR/header-blank.gif); background-repeat:no-repeat; font-size:12px; left: -120px; top: 1150px; width: 320px; height: 60px;">
								<div class="list"><ul>
			<li class="title"><h1 class="ftitle"></h1></li>
			<li class="title"><br /><br />
			<div style="white-space:nowrap" class="text"><span class="text" style="white-space:nowrap"><span><small class="nav"> <?php echo $this_forum['forum_name'] ?></small></span></span></div>
			</li></ul></div>
	</div>
<br/>-->
<br/>
<div id="search">   
    <?php if($user['id']>0){ ?>
    <ul>
        <li class="a"></li>
        <?php if(($user['g_post_new_topics']==1 && $this_forum['closed']!=1) || $user['g_forum_moderate']==1){ ?>
        <li>
            <a href="<?php echo $this_forum['linktonewtopic'];?>"><img src="<?php echo $currtmp; ?>/images/forum-menu-newtopic.gif" alt="[New Topic]" title="<?php echo $lang['newtopic'];?>" border="0" /></a>
            <a href="<?php echo $this_forum['linktonewtopic'];?>"><img src="<?php echo $currtmp; ?>/images/newpost-icon-quill.gif" alt="[New Topic]" width="33" height="35" border="0" style="position: absolute; top: -7px; left: 49px;" /></a>
        </li>
        <?php } ?>
        <li>
            <a href="<?php echo $this_forum['linktomarkread'];?>"><img src="<?php echo $currtmp; ?>/images/forum-menu-markread.gif" alt="[Mark Read]" title="<?php echo $lang['markread'];?>" border="0" /></a>
        </li>
    </ul>
    <?php } ?>
</div>
<table cellspacing="0" cellpadding="1" border="0" width="100%" class="board-clear" >
<tr>
<td class="tableoutline">
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="tableoutline">
    <tr>
    <td>
        <div class="theader">
        <div class="lpage">
        <span>
        <table cellpadding="0" cellspacing="0" border="0" >
        <tr>
            <td style="padding-left:5px;padding-top:3px;">
                <small><b><?php echo $lang['post_pages'];?>: <?php echo $pages_str = paginate($this_forum['pnum'], $p, "index.php?n=forum&sub=viewforum&fid=".$this_forum['forum_id']); ?></b></small>
            </td>
        </tr>
        </table>
        </span>
        </div>
        </div>
        
        <div id="postbackground">
        <div class="right"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableoutline" style="margin: 1 auto;">
            <tr>
                <td width="40" height class="tableheader" style="text-align: center;"><img src="<?php echo $currtmp; ?>/images/flag.gif" border="0" width="18" height="13"alt="forum-flag" title="Flags" /></td>
                <td width="326" class="tableheader"> <img src="<?php echo $currtmp; ?>/images/pixel.gif" border="0" width="1" height="22" alt="" align="absmiddle" /> <span class="afilter"><?php echo $lang['subject'];?></span></td>
                <td width="69" align="center" class="tableheader"><span class="afilter"><?php echo $lang['author'];?></span></td>
                <td width="69" align="center" class="tableheader"><span class="afilter"><?php echo $lang['replies'];?></span></td>
                <td width="48" align="center" class="tableheader"><div align="center"><span class="afilter"><?php echo $lang['views'];?></span></div></td>
                <td width="216" align="center" class="tableheader"><span class="afilter"><?php echo $lang['lastpost'];?></span></td>
            </tr>
            <?php foreach($topics as $topic){ ?>
            <tr class="rows">
                <td style="width:40px;" class="na1">
                    <?php if($topic['sticky']==1){ ?><img src="<?php echo $currtmp; ?>/images/sticky.gif" border="0" title="<?php echo $lang['sticky'];?>" align="absmiddle" /><?php } ?>
                    <?php if($topic['closed']==1){ ?><img src="<?php echo $currtmp; ?>/images/lock-icon.gif" border="0" title="<?php echo $lang['closed'];?>" align="absmiddle" /><?php } ?>
                </td>
                <td class="ta2" style="vertical-align:middle;">
                    <a href="<?php echo $topic['linktothis']; ?>"><img src="<?php echo $currtmp; ?>/images/square<?php echo($topic['isnew']?'-new':''); ?>.gif" width="15" height="15" style="vertical-align:middle;" border="0" alt="square" /></a>
                    <a href="<?php echo $topic['linktothis']; ?>" class="active" title="<?php echo $lang['topic_created'].' '; echo $topic['topic_posted'];?>"><?php echo $topic['topic_name'];?></a> <?php if($topic['isnew']){ ?><font color="red">[<?php Lang('newmessages'); ?>]</font><?php } ?>
                    <?php if($topic['pnum']>1){ ?>
                    <br /> <img src="<?php echo $currtmp; ?>/images/pixel.gif" width="15" height="12" />
                    <small>[<?php Lang('post_pages');?>: <small><?php echo $topic['pages_str']; ?></small>]
                    <?php } ?>
                </td>
                <td class="ta3"><span class="blue"><?php echo $topic['topic_poster'];?></span></td>
                <td class="ta4"><?php echo $topic['num_replies']; ?></td>
                <td class="ta5"><?php echo $topic['num_views']; ?></td>
                <td class="ta6"><a href="<?php echo $topic['linktolastpost']; ?>"><?php echo $lang['lastpostby'];?>&nbsp;<?php echo $topic['last_poster']; ?>, <?php echo $topic['last_post'];?></a></td>
            </tr>
            <?php } ?>
            </table>
        </div>
        </div>    
        
        <div class="theader">
        <div class="lpage">
        <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding-left:5px;padding-top:3px;">
                <small><b><?php echo $lang['post_pages'];?>: <?php echo $pages_str; ?></b></small>
            </td>
        </tr>
        </table>
		
        </div>
        </div>
        <div class="tbottom"></div>
        <div style="position: relative; width: 100%;">
        <div style="position: absolute; right: 20px; top: -38px;"></div></div>
<!-- 
        <span><small class="nav">Forum Nav :</small></span>
        <small>
            <select id="selectnav-footer" style="display:inline; width: 185px; margin-left: 10px;">             
            <option value="11124">WoW Guild Relations</option>
            <option value="11125">WoW Role-Playing</option>
            <option value="10001" onchange="">WoW General</option>
            <option value="11126">WoW Raids & Dungeons</option>
            </select>
        </small>  
        <a href="#" class="index"><img src="<?php echo $currtmp; ?>/images/jump-button.gif" alt="Jump To This Forum" width="21" height="19" border="0" style="margin-bottom: 3px;" align="top" title="Jump To This Forum"/></a>

        </div>
        </div>-->
    </td>
    </tr>
    </table>
</td>
</tr>
</table>

<div style="padding: 10px;" align="center">
<table id="iconLegend" cellpadding="0" cellspacing="0" width="50%">
<tbody>
<tr>
<td>
<table class="tb2" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td>
<small><div align="center">Legend :</div></small>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
  <table id="iconLegend" cellpadding="0" cellspacing="0" width="50%">
  <tbody><tr>
    <td>
  <table class="tb2" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>	<tr>
    <td><img src="<?php echo $currtmp; ?>/images/square-new.gif" style="margin: 0pt 3px 0pt 2px;" alt="New Post" border="0"><small>&nbsp;<?php echo $lang['newsubject'] ?>&nbsp;</small></td>
    <td><img src="<?php echo $currtmp; ?>/images/square.gif" style="margin: 0pt 3px 0pt 2px;" alt="Unviewed Post" border="0"><small>&nbsp;<?php echo $lang['readsubject'] ?>&nbsp;</small></td>
    <td><img src="<?php echo $currtmp; ?>/images/square-grey.gif" alt="Viewed Post" border="0"><small>&nbsp;<?php echo $lang['notreadsubject'] ?>&nbsp;</small></td>
      </tr>
  </tbody></table>

</tbody></table>
</div>
<?php } ?>
