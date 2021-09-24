<div style="margin-left: -29px">
<style media="screen" title="currentStyle" type="text/css">
@import url("<?php echo $currtmp; ?>/css/additional_fp.css");
</style>
<div id="module-container">
<!--[if gte IE 8]>
<div style="width:490px;"></div>
<![endif]-->
<!--[if IE]>
<div style="width:470px;"></div>
<![endif]-->
<![if !IE]>
<div style="width:470px;"></div>
<![endif]>
<?php 
$banner = (int)$MW->getConfig->generic->display_banner_flash ? 1 : 0;
if ($banner):
?>
<div id="flashcontainer">
<embed type="application/x-shockwave-flash" src="./flash/loader2.swf" id="flashbanner" name="flashbanner" quality="high" wmode="transparent" base="./flash/<?php echo $GLOBALS['user_cur_lang']; ?>" flashvars="xmlname=news.xmls" height="340" width="500">
</div>
    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<?php else: ?>
    <img style="margin-top: -55px;margin-bottom: 30px;" src="<?php echo $currtmp; ?>/images/banner_top.png" alt="" width="470"/><br/>
<?php endif; ?>
</div>
<div class="module-container" <?php if ($banner==1) echo 'style="position: relative;"';?>>
<?php foreach($alltopics as $postnum => $topic){
    $postnum++;
    if($hl=='alt')$hl='';else $hl='alt';
?>                                                              
    <script type="text/javascript">
        var postId<?php echo$postnum;?>="<?php echo $topic['topic_id'];?>";
    </script>
    <div class="news-expand" id="news<?php echo $topic['topic_id'];?>">
      <div class="news-border-left"></div>
      <div class="news-border-right"></div>
      <div class="news-listing">
        <div onclick="javascript:toggleEntry('<?php echo $topic['topic_id'];?>','<?php echo$hl;?>')" onmouseout="javascript:this.style.background='none'" onmouseover="javascript:this.style.background='#EEDB99'" class="hoverContainer">
          <div>
            <div class="news-top">
              <ul>
                <li class="item-icon">
                  <img border="0" alt="new-post" src="<?php echo $currtmp; ?>/images/news-contests.gif"/></li>
                <li class="news-entry">
                  <h1>
                    <a href="javascript:dummyFunction();"><?php echo $topic['topic_name'];?></a>
                  </h1>
                  <span class="user">Posted by: <b><?php echo $topic['topic_poster'];?></b>|</span>&nbsp;<span class="posted-date"><?php echo date('d-m-Y',$topic['topic_posted']);?></span>
                </li>
                <li class="news-entry-date">
                  <span><strong><?php echo date('d-m-Y',$topic['topic_posted']);?> </strong></span>
                </li>
                <li class="news-toggle">
                  <a href="javascript:toggleEntry('<?php echo $topic['topic_id'];?>','<?php echo$hl;?>')"><img src="<?php echo $currtmp; ?>/images/pixel001.gif" alt=""/></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="news-item">
        <blockquote>
          <dl>
            <dd>
              <ul>
                <li>
                  <div class="letter-box0"></div>
                  <div class="blog-post">
                    <?php echo $topic['message'];?>
                    <div align="right">
                      <a href="<?php echo mw_url('forum', 'viewtopic', array('tid'=>$topic['topic_id'], 'to'=>'lastpost'));?>"><?php echo $lang['lastcomment'];?></a>
                      <?php echo $lang['from'];?> <a href="<?php echo mw_url('account', 'view', array('action'=>'find', 'name'=>$topic['last_poster'])); ?>"><?php echo $topic['last_poster']; ?></a>
                    </div>                
                  </div>                
                </li>
              </ul>
            </dd>
          </dl>
        </blockquote>
      </div>
    </div>

    <script type="text/javascript"><!--
    var position = <?php echo$postnum;?>;
    var localId = postId<?php echo$postnum;?>;
    var cookieState = getcookie("news"+localId);
    var defaultOpen = "<?php echo($postnum > (int)$MW->getConfig->generic_values->news->defaultOpen?'0':'1');?>";
    if ((cookieState == 1) || (position==1 && cookieState!='0') || (defaultOpen == 1 && cookieState!='0')) {
    } else {
        document.getElementById("news"+localId).className = "news-collapse"+"<?php echo$hl;?>";       
    }
    --></script>
<?php }
unset($alltopics, $hl, $postnum);
?>                                                                
</div>

<div class="news-archive-link" <?php if ($banner==1) echo 'style="position: relative;"';?>>
    <div class="news-archive-button">
      <a href="<?php echo mw_url('forum', 'viewforum', array('fid'=>(int)$MW->getConfig->generic_values->forum->news_forum_id)); ?>"><span><?php echo $lang['news_archives'];?></span></a>
    </div>
    </div>
<!--<div id="container-community">
<div class="phatlootbox-top">
<h2 class="community">
<span class="hide">General</span>
</h2>
    <iframe style="margin-top:10px;margin-left: 5px;position: absolute" src="https://discord.com/widget?id=836244549751668807&theme=dark" width="458" height="220" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
<span class="phatlootbox-visual comm"></span>
</div>
<div class="phatlootbox-wrapper">
<div style="background: url(<?php /*echo $currtmp; */?>/images/phatlootbox-top-parchment.jpg) repeat-y top right; height: 7px; width: 456px; margin-left: 6px; font-size: 1px;"></div>
<div class="community-cnt" style="height: 200px;visibility: hidden;"></div>
<div class="phatlootbox-bottom">
</div>
</div>
</div>-->
<!--<div id="container-community">
		<div class="phatlootbox-top2">
			<div align="center">
				<div align="center" style="position:relative; top:-16px; left:-100px">
					<img src="<?php /*echo $currtmp; */?>/images/chains-long.gif" />
				</div>
				<div align="center" style="position:relative; top:-32px; left:100px">
					<img src="<?php /*echo $currtmp; */?>/images/chains-long.gif" />
				</div>
				<div style="position:relative; top:-38px; left:0px">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="postContainerPlain"	>
						<tr>
							<td width="50%"><div align="center" style="position:relative; top:1px; left:0px;"><a href="./index.php?n=forum"><img src="<?php /*echo $currtmp; */?>/images/box-support.gif" width="226" height="93" /></a></div></td>
							<td width="50%"><div align="center"><a href="./index.php?n=forum"><img src="<?php /*echo $currtmp; */?>/images/box-jobs.gif" width="226" height="93" /></a></div></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>