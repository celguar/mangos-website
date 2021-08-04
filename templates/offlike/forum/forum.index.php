<?php if((int)$MW->getConfig->generic_values->forum->externalforum): ?>
<?php if((int)$MW->getConfig->generic_values->forum->frame_forum): ?>
    <center>
    <br/>
    <iframe src="<?php echo (string)$MW->getConfig->generic_values->forum->forum_external_link; ?>" height="1050" width="640" frameborder="0" scrolling="yes">
        <?php lang('not_support_inline_frames') ?>
    </iframe>
    </center>
<?php else: ?>
    <meta http-equiv=refresh content="0;url='<?php echo (string)$MW->getConfig->generic_values->forum->forum_external_link; ?>'"/>
<?php endif; ?>
<?php else: ?>
<style type="text/css">
.forum_category .col2 { vertical-align: top; }
.forum_category .col3, .forum_category .col4 { color:#333333; font-size:12px; }
.forum_category .newmessages { color:#ff0000; }
.forum_category .hidden { font-weight: bold; }
.forum_category .lastreplyin, .forum_category .lastreplyfrom { color:#666666; }
.forum_forum { height: 6em; }
.forum_seperator { background-image:url(<?php echo $currtmp; ?>/images/metalborder-top.gif); background-repeat:repeat-x; height: 7px; }
</style>
<img src="<?php echo $currtmp; ?>/images/forum_top.png" border="0" width="100%" alt=""/>
<?php write_metalborder_header(); ?>
<?php foreach($items as $catitem): ?>
    <table cellspacing="0" cellpadding="2" border="0" width="100%" class="forum_category">
    <thead style="background-image:url(<?php echo $currtmp; ?>/images/light2.jpg); background-repeat:repeat-x;">
        <tr><td colspan="4"><h3><img src="<?php echo $currtmp; ?>/images/nav_m.gif" alt=""/> <?php echo $catitem[0]['cat_name'];?></h3></td></tr>
    </thead>
    <tbody>
<?php foreach($catitem as $forumitem): ?>
        <tr class="forum_forum">
            <td class="col1">
<?php if($forumitem['isnew']): ?>
                <img src="<?php echo $currtmp; ?>/images/<?php echo ($forumitem['closed']==1?'lock-icon.gif':'news-community.gif');?>" alt=""/>
<?php else:?>
                <img src="<?php echo $currtmp; ?>/images/<?php echo ($forumitem['closed']==1?'lock-icon.gif':'no-news-community.gif');?>" alt=""/>
<?php endif; ?>
            </td>
            <td class="col2">
                <a class="title" href="<?php echo $forumitem['linktothis'];?>"><?php echo $forumitem['forum_name'];?></a>
<?php if($forumitem['hidden']==1): ?>
                <span class="hidden"><?php lang('hidden'); ?></span>
<?php endif; ?>
<?php if($forumitem['isnew']): ?>
                <span class="newmessages"><?php lang('newmessages');?></span>
<?php endif; ?>
                <div class="desc"><?php echo $forumitem['forum_desc'];?></div>
<?php if($forumitem['num_posts'] > 0): ?>
                <div class="lastreplyin"><?php lang('lastreplyin');?> <a href="<?php echo $forumitem['linktolastpost'];?>"> <?php echo $forumitem['topic_name'];?></a></div>
                <div class="lastreplyfrom"><?php lang('from');?> <a href="<?php echo $forumitem['linktoprofile'];?>"> <?php echo $forumitem['last_poster'];?></a> <?php echo $forumitem['last_post'];?></div>
<?php endif; ?>
            </td>
            <td class="col3"><?php echo $forumitem['num_topics'];?> <?php echo declension($forumitem['num_topics'],array($lang['l_theme1'],$lang['l_theme2'],$lang['l_theme3'])); ?></td>
            <td class="col4"><?php echo $forumitem['num_posts'];?> <?php echo declension($forumitem['num_posts'],array($lang['l_post1'],$lang['l_post2'],$lang['l_post3'])); ?></td>
        </tr>
        <tr class="forum_seperator">
            <td colspan="4"></td>
        </tr>
<?php endforeach; ?>
    </tbody>
    </table>
<?php endforeach; ?>
<?php write_metalborder_footer(); ?>

<br/>
<table id="iconLegend" border="1" cellpadding="0" cellspacing="0" width="60%" align="center"><tbody><tr><td>
<table class="tb2" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-image:url(<?php echo $currtmp; ?>//images/light2.jpg); background-repeat:repeat-x;"><tbody><tr>
    <td><img src="<?php echo $currtmp; ?>/images/news-community.gif" style="margin: 0pt 3px 0pt 2px;" alt="Unviewed Post" border="0"/><small style="color:#333333">&nbsp;<?php echo $lang['newpost'] ?>&nbsp;</small></td>
    <td><img src="<?php echo $currtmp; ?>/images/no-news-community.gif" alt="Viewed Post" border="0"/><small style="color:#333333">&nbsp;<?php echo $lang['nonewpost'] ?>&nbsp;</small></td>
    <td><img src="<?php echo $currtmp; ?>/images/lock-icon.gif" style="margin: 0pt 3px 0pt 2px;" alt="New Post" border="0"/><small style="color:#333333">&nbsp;<?php echo $lang['postclose'] ?>&nbsp;</small></td>
</tr></tbody></table>
</td></tr></tbody></table>
<br/><br/>
<?php endif; ?>
