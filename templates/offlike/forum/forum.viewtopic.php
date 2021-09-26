<style media="screen" title="currentStyle" type="text/css">
    @import "<?php echo $currtmp; ?>/css/master.css";
    @import "<?php echo $currtmp; ?>/css/forums.css";
</style>
<img src="<?php echo $currtmp; ?>/images/forum_head.jpg" border="0" width="100%" />
<script language="javascript">
    function select_and_go(url){
        if(url != 0){
            conf = popup_ask('<?php echo $lang['are_you_sure'];?>');
            if(conf==true)window.location.href = url;
            else return false;
        }else{
            return false;
        }
    }
</script>

<div id="search">
    <ul>
        <li class="a"></li>
        <?php if(($user['g_post_new_topics']==1 && $this_forum['closed']!=1) || $user['g_forum_moderate']==1){ ?>
        <li>
            <a href="<?php echo $this_forum['linktonewtopic']; ?>"><img src="<?php echo $currtmp; ?>/images/forum-menu-newtopic.gif" alt="[New Topic]" title="<?php echo $lang['newtopic'];?>" border="0" /></a>
            <a href="<?php echo $this_forum['linktonewtopic']; ?>"><img src="<?php echo $currtmp; ?>/images/newpost-icon-quill.gif" alt="[New Topic]" width="33" height="35" border="0" style="position: absolute; top: -7px; left: 49px;" /></a>
        </li>
        <?php } ?>
        <li><img src="<?php echo $currtmp; ?>/images/forum-menu-search-right.gif" alt="" width="83" height="39" border="0" /></li>
    </ul>
    <div class="forum-index" id="forum-index">
    <a href="<?php echo $this_forum['linktothis']; ?>">
        <img src="<?php echo $currtmp; ?>/images/forum-index.gif" width="104" height="41" border="0" alt="Forum Index" title="Forum Index" />
    </a>
    </div>
</div>
<table cellspacing="0" cellpadding="1" border="0" width="100%" class="board-clear">
<tr>
<td class="tableoutline">
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="tableoutline">
    <tr>
    <td>
        <div class="theader">
        <div class="lpage-thread">
        <div id="topicview" style="font-weight: normal;">
            <ul>
                <li><span title="General Thread"><img src="<?php echo $currtmp; ?>/images/index-icon.gif" width="14" height="15" border="0" alt="General Thread" /></span></li>
                <li><span title="<?php echo $this_topic['topic_name']; ?>" class="white"><b>&nbsp;<?php echo $lang['topic'];?>&nbsp;<a href="<?php echo $this_topic['linktothis']; ?>" class="active"><?php echo $this_topic['topic_name']; ?></a></b></span></li>
                <li><span title="Current Time" class="white"><small>&nbsp; | &nbsp;<?php echo date('d/m/Y, H:i:s',$this_topic['topic_posted']);?>&nbsp;</small></span></li>
            </ul>
        </div><!-- end topicview -->
        </div><!-- end lpage-thread -->
        <div class="rpage-thread">
        <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding-left:5px;padding-top:3px;">
                <small><b><?php echo $lang['post_pages'];?>: <?php echo $pages_str=paginate($pnum, $p, $this_topic['linktothis']); ?></b></small>
            </td>
        </tr>
        </table>
        </div><!-- end rpage-thread -->
        </div><!-- end theader -->

        <div id="postbackground">
        <div class="right">
        <!-- Main Post Body -->
<?php foreach($posts as $post){ ?>
        <a name="post<?php echo $post['post_id']; ?>"></a>
        <div id="postshell<?php echo $post['bg']; ?>1">
            <div class="resultbox">
                <div class="postdisplay">
                    <div class="border">
                        <div class="postingcontainer<?php echo $post['bg']; ?>1">
                            <div class="insert">
                                <table id="posttable<?php echo $post['bg']; ?>1" cellpadding="0" cellspacing="0" border="0">
                                  <!--DWLayoutTable-->
                                    <tr>
                                        <td width="200" rowspan="2" class="id<?php echo $post['bg']; ?>1">
                                        <!-- Begin Avatar Panel -->
                                        <div>
                                            <div id="avatar<?php echo $post['bg']; ?>1">
											<div class="shell">

                                                    <table cellspacing="0" cellpadding="0" border="0">
													    
                                                        <tr>
															<?php if($post['level'] >= 80) { ?>
                                                            <td style="background: url('<?php echo $dtmp."/images/portraits/wow-80/".$post['avatar']; ?>'); width: 64px; height: 64px;">
															<?php }elseif($post['level'] >= 70) { ?>
															<td style="background: url('<?php echo $dtmp."/images/portraits/wow-70/".$post['avatar']; ?>'); width: 64px; height: 64px;">
															<?php }elseif($post['level'] >= 60) { ?>
															<td style="background: url('<?php echo $dtmp."/images/portraits/wow/".$post['avatar']; ?>'); width: 64px; height: 64px;">
															<?php }else{ ?>
															<td style="background: url('<?php echo $dtmp."/images/portraits/wow-default/".$post['avatar']; ?>'); width: 64px; height: 64px;">
															<?php } ?>
															</td>
                                                        </tr>
                                                    </table>
                                                    <div class="frame">
                                                        <img src="<?php echo $currtmp; ?>/images/pixel.gif" width="82" height="83" border="0" alt="" />                                                    </div>
                                                </div><!-- end shell -->
                                                <div style="position: relative;">
                                                    <div class="iconposition">
                                                        <!--<img src="<?php echo $currtmp; ?>/images/blizz.gif"/>-->
                                                        <b><small><?php echo empty($post['g_prefix']) ? $post['level'] : $post['g_prefix']; ?></small></b>                                                    </div>
                                        <!-- //Begin Character Control Panel// -->
											<div id="iconpanel">
											</div>
											<div id="default-icon-panel">
											    <div class="player-icons-race">
												<table cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td style="background: url('<?php echo $dtmp."/images/icons/race/".$post['mini_race']; ?>'); width: 18px; height: 18px;">
															</td>
                                                        </tr>
                                                    </table>
											    </div>
												<div class="player-icons-class">
												<table cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td style="background: url('<?php echo $currtmp."/images/icon/class/".$post['mini_class']; ?>'); width: 18px; height: 18px;">
															</td>
                                                        </tr>
                                                    </table>
												</div>
												<div class="player-icons-pvprank">
												<table cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td style="background: url('<?php echo $currtmp."/images/icon/faction/".$post['faction']; ?>'); width: 18px; height: 18px;">
															</td>
                                                        </tr>
                                                    </table>
												</div>
												</div>


                                        <div style="position: relative; width: 200px;">
                                            <div class="userpanel">
<?php if ($user["g_view_profile"]): ?>
<a href="index.php?n=account&sub=view&action=find&name=<?php echo $post['username']; ?>"><img class="icon-search" src="<?php echo $currtmp; ?>/images/search.gif"
onmouseover="ddrivetip('View <?php echo "$post[poster]\'s"; ?> profile','#ffffff')"; onmouseout="hideddrivetip()" alt="View <?php echo "$post[poster]\'s"; ?> profile" /></a>
<?php endif; ?>
<?php if ($user["g_use_pm"]): ?>
<a href="<?php echo $post['linktopms']; ?>"><img class="icon-ignore" src="<?php echo $currtmp; ?>/images/editor/mail.gif" onmouseover="ddrivetip('<?php echo $lang['send_pm_to'].' '; echo "$post[poster]"; ?> ','#ffffff')"; onmouseout="hideddrivetip()" alt="ignore" /></a>
<?php endif; ?>
<!--<a href="#"><img class="icon-ignore" src="<?php echo $currtmp; ?>/images/ignore-user.gif" onmouseover="ddrivetip('Toggle Ignore / Unignore This User','#ffffff')"; onmouseout="hideddrivetip()" alt="ignore" /></a> -->
                                            </div>
                                        </div>
                                        <!-- End Character Control Panel -->
                                        <!-- Begin Character Information Display -->
                                        <!--
                                        <div style="position: relative; width: 200px;">
                                            <div class="userpanel">
                                                <a href="/search.html?forumId=10001&amp;characterId=677607770&amp;sid=1"><img class="icon-search" src="<?php echo $currtmp; ?>/images/search.gif" onmouseover="ddrivetip('View All Posts by This User','#ffffff')"; onmouseout="hideddrivetip()" alt="view posts by this user" /></a>
                                                <a href="#"><img class="icon-ignore" src="<?php echo $currtmp; ?>/images/ignore-user.gif" onmouseover="ddrivetip('Toggle Ignore / Unignore This User','#ffffff')"; onmouseout="hideddrivetip()" alt="ignore" /></a>
                                            </div>
                                        </div>
                                        -->
                                        <!-- End Character Control Panel -->
                                        <!-- Begin Character Information Display -->
                                        <div style="clear: left;"></div>
                                        <div style="position: relative; width: 200px;">
                                            <div class="pinfo">
                                                <div class="pinfobackground">
                                                    <span><b style="color:#ffac04;"><?php echo $post['poster']; ?></b></span>
                                                    <div>
                                                    <?php
                                                    // Get posts
                                                    $posts = $DB->selectCell("SELECT forum_posts FROM `website_accounts` WHERE account_id='$post[id]'");
                                                    ?>
                                                        <ul class="listinfo" style="clear: both;">
<?php if (isset($post['guild'])): ?>
                                                            <li class="icon-guild"><small><b>&lt; <?php echo $post['guild']; ?> &gt;</b></small></li>
<?php endif; ?>
                                                            <li class="icon-realm"><small>Posts: <?php echo $posts; ?></small></li>
                                                        </ul>
                                                    </div>
                                                </div><!-- end pinfobackground -->
                                            </div><!-- end pinfo -->
                                            <div>
                                                <div class="pinfobottom">
                                                    <div class="pifooter"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- //End Character Display// -->
                                        <!-- //grabs character info -->                                        </td>
                                        <td width="239" class="tools<?php echo $post['bg']; ?>1">
                                        <!-- Begin Post Info -->
                                        <div id="postid<?php echo $post['bg']; ?>1">
                                            <ul>
                                                <li style="display:table-cell;"><span class="white"><b>Reply #<?php echo $post['pos_num']; ?></b>&nbsp; | &nbsp;<small><?php echo $post['posted']; ?></small></span></li>
                                            </ul>
                                        </div>
                                        <!-- End Post Info --><!-- //grabs post title info -->
                                        <!-- Begin Post Control Panel -->
                                        <div class="miniadmin" id="post<?php echo $post['post_id']; ?>">
                                            <ul>
                                            <!-- Post Admin -->
                                                <?php if(($user['id']==$post['poster_id'] && $user['g_edit_own_posts']) || $user['g_forum_moderate']==1){ ?>
                                                <li><a href="<?php echo $post['linktoedit']; ?>" onclick="return popup_ask('<?php echo $lang['edit'];?> ?');"><img src="<?php echo $currtmp; ?>/images/edit-button.gif" border="0" alt="[edit]" align="top" /></a></li>
                                                <?php } if(($user['id']==$post['poster_id'] && $user['g_delete_own_posts']) || $user['g_forum_moderate']==1){ ?>
                                                <li><a href="<?php echo $post['linktodelete']; ?>" onclick="return popup_ask('<?php echo $lang['delete'];?> ?');"><img src="<?php echo $currtmp; ?>/images/delete-icon.gif" border="0" alt="[delete]" align="top" /></a></li>
                                                <?php } ?>
                                                <?php if($user['g_reply_other_topics']==1 && $this_topic['closed']!=1){ ?>
                                                <a href="<?php echo $post['linktoquote']; ?>" class="quote"><img src="<?php echo $currtmp; ?>/images/quote-button.gif" width="63" height="18" border="0" title="<?php echo $lang['quote'];?>" alt="[quote]" /></a>
                                                <a href="<?php echo $this_topic['linktoreply']; ?>#write_form" class="scroller"><img src="<?php echo $currtmp; ?>/images/reply-button.gif" width="63" height="18" border="0" title="<?php echo $lang['reply'];?>" alt="[reply]" /></a>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <!-- End Post control Panel -->
                                        <!-- //grabs moderator tools -->                                        </td>
                                        <td width="507"></td>
                                    </tr>
                                    <tr>
                                        <td class="message<?php echo $post['bg']; ?>1">
                                            <table id="postbody<?php echo $post['bg']; ?>1" cellspacing="0" border="0">
                                                <tr>
                                                    <td>
                                                        <div class="breakWord">
                                                            <div class="message-format">
                                                            <span class="" style="font-size:0.8em;">
<?php
$post_col = ($post['g_is_admin']||$post['g_is_supadmin']) ? '#66FFFF' : '#FFFFFF';

echo "<font color='$post_col'> ".$post['message']."</font>";
?>
<?php if($post['edited']){ ?><p><small><font color="red">[</font><font color="white"> <?php echo $lang['post_editted_by'].' '; echo $post['edited_by'].' &nbsp;'; echo date('d-m-Y H:i:s',$post['edited']);?> </font><font color="red">]<br /></font></small></p><?php } ?>
																														<?php
																														$sig = $DB->selectCell("SELECT signature FROM `website_accounts` WHERE account_id='$post[id]'");
																														if ($sig == NULL){
        																										}
																														else
																														{
																																$sig = my_preview($sig);
                             																		echo "<br />- - - - - - - - <br />".$sig."";
																														}
																														?>
                                                            </span>                                                            </div>
                                                        </div>                                                    </td>
                                                </tr>
                                            </table>                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                                <!-- End table posttable -->
                            </div><!-- end insert -->
                        </div><!-- end innercontainer -->
                    </div><!-- end border -->
                </div><!-- end postdisplay -->
            </div><!-- end resultbox -->
        </div><!-- End div postshell -->
<?php } ?>
        <!-- End Posts -->
        </div>
        </div>
        <!-- end postbackground -->
    </td>
    </tr>
  </table>
</td>
</tr>
</table>

<div id="topicfooter">
  <div class="rpage">
    <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="padding-left:5px;padding-top:3px;">
                    <small><b><?php echo $lang['post_pages'];?>: <?php echo $pages_str;?></b></small>
                </td>
            </tr>
        </table>
  </div>
</div>
<div class="forum-index">
  <div class="findex">
    <a href="<?php echo $this_forum['linktothis']; ?>"><img src="<?php echo $currtmp; ?>/images/forum-index.gif" width="104" height="41" border="0" title="" alt="" /></a>
  </div>
</div>
<div style="width: 100%; height: 20px;"></div>
<div style="position: relative; width: 100%;">
    <div style="position: absolute; left: 20px; top: -78px;_top: -85px;">
        <span><small class="nav"><?php echo $lang['forum_nav'];?>:</small></span>
        <small>
        <select onChange="select_and_go(this.value);" id="selectnav-footer" style="display:inline; margin-left: 10px;">
            <option value="0">Select</option>
            <?php if($this_topic['sticky']==0 && $user['g_forum_moderate']==1){ ?>
                <option value="<?php echo $this_topic['linktostick']; ?>"><?php echo $lang['dostick'];?> <?php echo $lang['l_theme4'];?></option>
            <?php } ?>
            <?php if($this_topic['sticky']==1 && $user['g_forum_moderate']==1){ ?>
                <option value="<?php echo $this_topic['linktounstick']; ?>"><?php echo $lang['dounstick'];?>" <?php echo $lang['l_theme4'];?></option>
            <?php } ?>
            <?php if($this_topic['closed']==0 && $user['g_forum_moderate']==1){ ?>
                <option value="<?php echo $this_topic['linktoclose']; ?>"><?php echo $lang['doclose'];?> <?php echo $lang['l_theme4'];?></option>
            <?php } ?>
            <?php if($this_topic['closed']==1 && $user['g_forum_moderate']==1){ ?>
                <option value="<?php echo $this_topic['linktoopen']; ?>"><?php echo $lang['doopen'];?> <?php echo $lang['l_theme4'];?></option>
            <?php } ?>
            <?php if(($user['id']==$this_topic['topic_poster_id'] && $user['g_delete_own_topics']) || $user['g_forum_moderate']==1){ ?>
                <option value="<?php echo $this_topic['linktodelete']; ?>"><?php echo $lang['delete'];?> <?php echo $lang['l_theme4'];?></option>
            <?php } ?>
        </select>
        </small>
        <a href="<?php echo $this_forum['linktothis']; ?>" class="index"><img src="<?php echo $currtmp; ?>/images/jump-button.gif" alt="Jump To This Forum" width="21" height="19" border="0" style="margin-bottom: 3px;" align="top" title="Jump To This Forum"/></a>
    </div>
</div>
<br clear="all" />
<?php if($user['id']>0 && $this_topic['show_qr']===true && $user['g_reply_other_topics']==1 && $this_topic['closed']!=1){ ?>
    <div id="write_form" class="subsections">
    <h3 style="color: #fff;padding-left: 10px;"> <?php echo $lang['smtgtosay'];?></h3>
    <form class="clearfix" method="post" action="<?php echo $this_topic['linktopostreply']; ?>" enctype="multipart/form-data">
        <?php write_form_tool(); ?>
        <div id="input_block">
            <label for="input_comment">
            <textarea id="input_comment" name="text"></textarea>
            </label>
            <input class="input_btn_big" value="<?php echo $lang['editor_preview'];?>" type="button" id="preview_do">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input class="intput_btn_medium" type="reset" value="<?php echo $lang['editor_clear'];?>">
        </div>
        <div id="preview_block" style="display: none;background:none;">
            <div class="editor" id="input_preview"></div>
            <input class="input_btn_big" id="preview_back" value="<?php echo $lang['editor_backtoedit'];?>" type="button">
        </div>
        <input type="submit" value="<?php echo $lang['editor_send'];?>" class="input_btn_big" />
    </form>
    </div>
<?php } ?>
