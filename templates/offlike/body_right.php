<?php if ((int)$MW->getConfig->components->right_section->quicklinks): ?>

<!-- QuickLinks -->
<div id="q-links">
<h3><?php echo $lang['quicklinks'];?></h3>
<ul>
<li>
<a href="<?php echo mw_url('account', 'manage'); ?>"><?php echo $lang['quicklink2']; ?></a>
</li>
<li class="e">
<a href="<?php echo mw_url('account', 'register'); ?>"><?php echo $lang['quicklink1']; ?></a>
</li>
<li>
<a href="<?php echo mw_url('server', 'realmstatus'); ?>"><?php echo $lang['quicklink3']; ?></a>
</li>
<li class="e">
<a href="<?php if((int)$MW->getConfig->generic_values->forum->faqsite_external_use) { echo (string)$MW->getConfig->generic_values->forum->faqsite_external_link; } else { echo mw_url('forum', 'viewforum', array('fid'=>(int)$MW->getConfig->generic_values->forum->ql4_forum_id)); } ?>"><?php echo $lang['quicklink4']; ?></a>
</li>
<li>
<a href="<?php echo mw_url('server', 'howtoplay'); ?>"><?php echo $lang['howtoplay']; ?></a>
</li>
<li class="e">
<a href="<?php echo mw_url('server', 'commands'); ?>"><?php echo $lang['quicklink7']; ?></a>
</li>
</ul></div>
<span class="gfxhook"></span>
<hr>
<?php endif; ?>

<!-- VoteLinks  -->

<?php if(count($MW->getConfig->votelinks->vote) > 0): ?>

<div id="box3">
<h3><?php echo $lang['vote_system'];?></h3>
<ul>
<li><div>
<center>
  <a href="index.php?n=community&sub=vote"><img src="<?php echo $currtmp; ?>/images/vote.png" width="264" height="247" /></a>
</center>
<?php echo $lang['vote_desc'];?><br />
</div></li>
</ul></div>
<span class="gfxhook"></span>
<hr>

<?php endif; ?>


<?php  if ((int)$MW->getConfig->components->right_section->media){ ?>

<!-- Screenshot of the day -->
<?php
$date_ssotd = $DB->selectCell("SELECT `date` FROM `gallery_ssotd` LIMIT 1");
$today_ssotd = date("y.m.d");
if ($date_ssotd != $today_ssotd) {
$rand_ssotd = $DB->selectCell("SELECT `img` FROM `gallery` WHERE cat ='screenshot' ORDER BY RAND() LIMIT 1");
$DB->query("UPDATE gallery_ssotd SET image = '$rand_ssotd', date = '$today_ssotd'");
}
$screen_otd = $DB->selectCell("SELECT `img` FROM `gallery` WHERE cat ='screenshot' ORDER BY RAND() LIMIT 1");
?>
<div id="rightbox">
<h3 style="height: 20px; color: #eff0ef; font-size: 12px; letter-spacing: 1px; font-weight: bold; width: 308px; padding: 1px 0 0 8px; font-family: 'Trebuchet MS', Verdana, Arial, sans-serif;"><?php echo $lang['random_screen']; ?></h3>
<div id="innerrightbox">
<?php

if ($screen_otd):
?>
        <a href="images/screenshots/<?php echo $screen_otd; ?>" target="_blank"><img src="show_picture.php?filename=<?php echo $screen_otd; ?>&amp;gallery=screen&amp;width=282" width="282" alt="" style="border: 1px solid #333333"/></a>
		<select onchange="window.location = options[this.selectedIndex].value" style="width: 284px;">
		<option value=""><?php echo $lang['galleries']; ?> -&gt;</option>
		<option value="index.php?n=media&sub=screen"><?php echo $lang['GallScreen']; ?></option>
		<option value="index.php?n=media&sub=wallp"><?php echo $lang['GallWalp']; ?></option>
		</select>
<?php
else:
?>
        No Screenshots in database;
<?php
endif;
unset($screen_otd); // Free up memory.
?>
</div></div>
<?php } ?>


<!-- Newcomers section -->
<?php if ((int)$MW->getConfig->components->right_section->newbguide): ?>

<div id="rightbox">
<div class="newcommer">
<h4><?php echo $lang['newcomers']; ?></h4>
<p style="margin-bottom: -1px;">
<?php echo $lang['newcomers2']; ?>
</p>
<ul>
<li>&nbsp; <a href="index.php?n=server&sub=howtoplay"><?php echo $lang['byj_1']; ?></a>
</li>
<li>&nbsp; <a href="<?php if((int)$MW->getConfig->generic_values->forum->faqsite_external_use) { echo (string)$MW->getConfig->generic_values->forum->faqsite_external_link; } else { echo mw_url('forum', 'viewforum', array('fid'=>(int)$MW->getConfig->generic_values->forum->ql4_forum_id)); } ?>"><?php echo $lang['byj_2']; ?></a>
</li>
</ul>
</div>
</div>
<?php endif; ?>

<?php if (isset($usersonhomepage) || isset($hits)): ?>

<!-- usersonhomepage -->


<div id="box2">
<h3><?php echo $lang['useronhp'];?></h3>
<ul>
<li>&nbsp;</li>

<?php if (isset($usersonhomepage)): ?>
<li>
<a href="index.php?n=whoisonline">&nbsp;<?php echo $usersonhomepage;?>&nbsp;</a>
 <?php echo ($usersonhomepage == 1) ? $lang['isonline'] : $lang['areonline']; ?>
            
</li>
<?php endif; ?>

<li>&nbsp;</li>
<?php if (isset($hits)): ?>
<li><p  style="padding-left:19px; margin-top:-8px"><?php echo $lang['hits']; ?>: <?php echo $hits; ?></p></li>
<?php endif; ?>
</ul></div>
<span class="gfxhook"></span>
<hr>
<?php endif; ?>

<?php if (count($servers) > 0): ?>

<!-- serverinformation -->

<?php foreach($servers as $server): ?>
<div id="box3">
<h3><?php echo $lang['serverinfo'];?></h3>
<ul>

<li><div>
&nbsp;
</div></li>

<li><div>
<?php echo $lang['si_name']; ?>:&nbsp;<b><?php echo $server['name'];?></b>
</div></li>

<?php if (isset($server['realm_status'])): ?>
<li><div>
<?php echo $lang['si_status']; ?>:&nbsp;<?php if ($server['realm_status']): ?>
                <img src="images/uparrow2.gif" height="15" alt="Online" /> <b style="color: rgb(35, 67, 3);">Online</b>
<?php else: ?>
                <img src="images/downarrow2.gif" height="15" alt="Offline" /> <b style="color: rgb(102, 13, 2);">Offline</b>
<?php endif; ?>
</div></li>

<?php endif; if (isset($server['onlineurl'])): ?>

<li><div>
<?php echo $lang['si_on']; ?>:&nbsp;
<a href="<?php echo $server['onlineurl'] ?>"><?php echo $server['playersonline']; ?></a>
<?php if (isset($server['playermapurl'])): ?>
(<a href="index.php?n=server&sub=playermap"><?php echo $lang['playermap'] ?></a>)
<?php endif; ?>
</div></li>

<?php endif; if (isset($server['server_ip'])): ?>

<li><div>
<?php echo $lang['si_ip']; ?>:&nbsp;<b><?php echo $server['server_ip']; ?></b>
</div></li>

<?php endif; if (isset($server['type'])): ?>

<li><div>
<?php echo $lang['si_type']; ?>:&nbsp;<b><?php echo $server['type'];?></b>
</div></li>

<?php endif; if (isset($server['language'])): ?>

<li><div>
<?php echo $lang['si_lang']; ?>:&nbsp;<b><?php echo $server['language']; ?></b>
</div></li>

<?php endif; if (isset($server['population'])): ?>

<li><div><?php echo $lang['si_pop']; ?>:&nbsp;<b><?php echo population_view($server['population']);?></b>
</div></li>

<?php endif; if (isset($server['accounts'])): ?>

<li><div>
<?php echo $lang['si_acc']; ?>:&nbsp;<b><?php echo $server['accounts']; ?><?php if (isset($server['active_accounts'])): ?> <?php echo sprintf($lang['si_active_acc'], $server['active_accounts']); ?><?php endif; ?></b>
</div></li>

<?php endif; if (isset($server['characters'])): ?>

<li><div>
<?php echo $lang['si_chars']; ?>:&nbsp;<b><?php echo $server['characters'];?></b>
</div></li>

<?php endif; if (isset($server['rates'])): ?>

<li><div>
<?php echo $lang['level_cap']; ?>:&nbsp;<b><?php echo $server['rates']['MaxPlayerLevel'];?></b>
</div></li>
            
<li><div>
<dl>
<dt><?php echo $lang['si_droprate']; ?>:&nbsp;</dt>
<dd><?php echo $lang['si_droprate_items_poor']; ?> = <?php echo $server['rates']['Rate.Drop.Item.Poor'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_droprate_items_normal']; ?> = <?php echo $server['rates']['Rate.Drop.Item.Normal'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_droprate_items_uncommon']; ?> = <?php echo $server['rates']['Rate.Drop.Item.Uncommon'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_droprate_items_rare']; ?> = <?php echo $server['rates']['Rate.Drop.Item.Rare'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_droprate_items_epic']; ?> = <?php echo $server['rates']['Rate.Drop.Item.Epic'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_droprate_items_legendary']; ?> = <?php echo $server['rates']['Rate.Drop.Item.Legendary'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_droprate_items_artifact']; ?> = <?php echo $server['rates']['Rate.Drop.Item.Artifact'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_droprate_items_referenced']; ?> = <?php echo $server['rates']['Rate.Drop.Item.Referenced'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_droprate_money']; ?> = <?php echo $server['rates']['Rate.Drop.Money'];?> x Blizzlike</dd>
</dl>
</div></li>

<li><div>
<dl>
<dt><?php echo $lang['si_exprate']; ?>:&nbsp;</dt>
<dd><?php echo $lang['si_exprate_kill']; ?> = <?php echo $server['rates']['Rate.XP.Kill'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_exprate_quest']; ?> = <?php echo $server['rates']['Rate.XP.Quest'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_exprate_explore']; ?> = <?php echo $server['rates']['Rate.XP.Explore'];?> x Blizzlike</dd>
</dl>
</div></li>
            
<li><div>
<dl>
<dt><?php echo $lang['si_restrate']; ?>:&nbsp;</dt>
<dd><?php echo $lang['si_restrate_city']; ?> = <?php echo $server['rates']['Rate.Rest.Offline.InTavernOrCity'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_restrate_ingame']; ?> = <?php echo $server['rates']['Rate.Rest.InGame'];?> x Blizzlike</dd>
<dd><?php echo $lang['si_restrate_wild']; ?> = <?php echo $server['rates']['Rate.Rest.Offline.InWilderness'];?> x Blizzlike</dd>
</dl>
</div></li>

<?php endif; if ($server['moreinfo']): ?>

<li><div>
<a href="<?php echo mw_url('server', 'info'); ?>"><?php echo $lang['more_info']; ?></a>
</div></li>

<?php endif; ?>

<li><div>
&nbsp;
</div></li>

</ul></div>
<span class="gfxhook"></span>
<hr>
<?php endforeach; ?>
<?php endif; ?>
