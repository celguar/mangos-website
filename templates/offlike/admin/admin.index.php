<br>
<?php builddiv_start(1, $lang['admin_panel']) ?>
Welcome to the MangosWeb Enhanced Admin Panel. Current MangosWeb Revision: <?php echo $rev ?>.
<ul style="font-weight:bold;"><h2>Site Managment</h2>
      <li><a href="index.php?n=admin&amp;sub=members"><?php echo $lang['users_manage'];?></a></li>
      <li><a href="index.php?n=admin&amp;sub=config"><?php echo $lang['site_config'];?></a></li>
	  <li><a href="index.php?n=admin&sub=realms"><?php echo $lang['realms_manage'];?></a></li>
      <li><a href="index.php?n=admin&sub=keys"><?php echo $lang['regkeys_manage'];?></a></li>
      <li><a href="index.php?n=admin&sub=donate"><?php echo $lang['donate'];?> Admin</a></li>
	  <li><a href="index.php?n=admin&sub=vote"><?php echo $lang['vote'];?> Admin</a></li>
        <li><a href="index.php?n=admin&sub=updatefields">Update Data Fields</a></li>
	  <li><a href="index.php?n=admin&sub=langs"><?php echo $lang['langs_manage'];?></a></li>
</ul>

<ul style="font-weight:bold;"><h2>Character Tools</h2>
	  <li><a href="index.php?n=admin&sub=chartools">Character Rename</a></li>
	  <li><a href="index.php?n=admin&sub=chartransfer">Character Transfer</a></li>
</ul>

<ul style="font-weight:bold;"><h2>Server Managment</h2>
	  <li><a href="index.php?n=admin&sub=tickets">GM Ticket Manager</a></li>    
  <?php
  if ((int)$MW->getConfig->core_work->enable){
  ?>
  <li><a href="index.php?n=admin&amp;sub=viewlogs">View GM Logs</a></li>
  <?php } ?>
  <li><a href="index.php?n=admin&sub=backup">Backup management</a></li>
</ul>

<ul style="font-weight:bold;"><h2>Forum Manager</h2>
	<li><a href="index.php?n=admin&sub=forum"><?php echo $lang['admin_forum'];?> Admin</a></li>
	<li><a href="index.php?n=forum&sub=post&action=newtopic&f=<?php echo (int)$MW->getConfig->generic_values->forum->news_forum_id;?>"><?php echo $lang['news_add'];?></a></li>
	<li><a href="index.php?n=forum&sub=viewforum&fid=<?php echo (int)$MW->getConfig->generic_values->forum->news_forum_id;?>"><?php echo $lang['news_manage'];?></a></li>
</ul>
<?php builddiv_end() ?>
