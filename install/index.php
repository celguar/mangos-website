<?php
// =======================================
// MangosWeb installer 1.0 Beta by Modimus
// =======================================

// Let's start with some protection
if (file_exists("DISABLE_INSTALLER.php")) die("Function disabled. To enable delete file DISABLE_INSTALLER.php from /install folder. Readd this file if you're done!");
?>
<html><head><title>MangosWeb Installer</title>
<?php

?>
<!-- Some basic style -->
<style type="text/css">
body {background-color: black; margin: 0px;}
div.content {background: url('bg.jpg') repeat-y; width: 775px; position: relative; left: 50%; margin-left: -387px; height: 120%; }
div.innercont {padding: 30px 30px 0px 60px;}
div.conttop {width: 659px; height: 29px; background: url('../templates/WotLK/images/content-parting.jpg') no-repeat;}
div.title {font-family: 'Times New Roman', Times, serif; color: #640909; font-weight: bold; font-size: larger; padding:3px 0px 0px 20px;}
div.contmiddle {background: url('../templates/WotLK/images/light.jpg') repeat; border-width: 1px; border-color: #000000; border-bottom-style: solid; width: 659px;}
div.center {padding: 15px 0px 15px 15px; font-size: larger;}
</style>
<head>

<body>
<!-- Build page style -->
<div class="content">
<div class="innercont">
<div class="conttop">
<div class="title">
<?php
// Print title for current step
if (!isset($_GET['s']) or $_GET['s'] == 1) {echo "MangosWeb Installer: Step 1/3";} // Step 1
elseif ($_GET['s'] == 2) {echo "MangosWeb Installer: Step 2/3";} // Step 2
elseif ($_GET['s'] == 3) {echo "MangosWeb Installer: Step 3/3";} // Step 3
?>
</div>
</div>
<div class="contmiddle">
<div class="center">
<?php
// Step one
if (!isset($_GET['s']) or $_GET['s'] == 1) { ?>
	<br />Welcome to the MangosWeb installer!<br /><br />Please follow these few steps to set up your new site.<br /><br /><br /><br />
    <form action="index.php?s=2" method="post">
    <b>Database details:</b><br /><br />
    <table>
	    <tr>
            <td>Host:</td><td><input type='text' name='db_host' value='<?php echo "127.0.0.1"; ?>'></td>
			<td>Host address, without port number.</td>
        </tr>
		<tr>
            <td>Port:</td><td><input type='text' name='db_port' value='<?php echo "3306"; ?>'></td>
			<td>Database port. By default it's 3306, should be fine in most cases if you don't know it.</td>
        </tr>
		<tr>
            <td>Type:</td><td><input type='text' name='db_type' value='<?php echo "mysql"; ?>'></td>
			<td>Database type. By default it's mysql, should be fine in most cases if you don't know it.</td>
        </tr>
        <tr>
            <td>Username:</td><td><input type='text' name='db_username' value='<?php echo "root"; ?>'></td>
			<td>Database username.</td>
        </tr>
        <tr>
            <td>Password:</td><td><input type='password' name='db_password'></td>
			<td>Database password.</td>
        </tr>
    </table>
    <br /><br />
    <b>Database names:</b><br /><br />
    <table>
        <tr>
            <td>Realm db:</td><td><input type='text' name='db_name' value='<?php echo "realmd"; ?>'></td>
        </tr>
        <tr>
            <td>World db:</td><td><input type='text' name='world_db_name' value='<?php echo "mangos"; ?>'></td>
        </tr>
        <tr>
            <td>Characters db:</td><td><input type='text' name='character_db_name' value='<?php echo "characters"; ?>'></td>
        </tr>
    </table>
    <p>Please check your details if they are correct before proceeding.</p>
    <input type='submit' value='Go to the next step!'>
    </form>
<?php
}

// Step two
elseif ($_GET['s'] == 2) {
// Check if everything is given
if (!$_POST['db_host'] | !$_POST['db_port'] | !$_POST['db_type'] | !$_POST['db_username'] | !$_POST['db_password'] | !$_POST['db_name'] | !$_POST['world_db_name'] | !$_POST['character_db_name']) {
	die('Error!<br /><br />One or more fileds were left empty. Please <a href="javascript: history.go(-1)">go back</a> and correct it.');
	}
// Check if provided info is correct
$dbcon = @mysqli_connect($_POST['db_host'].":".$_POST['db_port'], $_POST['db_username'], $_POST['db_password']) or die ('Error!<br /><br />Couldn\'t connect to the MySql server, most likely the given information is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br />'.mysqli_error());
@mysqli_select_db($dbcon, $_POST['world_db_name']) or die('Error!<br /><br />Couldn\'t select World db, most likely the given name is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br />'.mysqli_error());
@mysqli_select_db($dbcon, $_POST['character_db_name']) or die('Error!<br /><br />Couldn\'t select Characters db, most likely the given name is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br />'.mysqli_error());
@mysqli_select_db($dbcon, $_POST['db_name']) or die('Error!<br /><br />Couldn\'t select Realmd db, most likely the given name is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br />'.mysqli_error());
// Check if "account" table exsists, so we make (almost) sure mangos is actually installed (which is necesarry for this whole thing to work)
@mysqli_query($dbcon, "SELECT * FROM `account` LIMIT 1") or die('Error!<br /><br />Account table not found, seems like mangos isn\'t installed.<br /><br />MySql error log:<br />'.mysqli_error());
// Everthing should be fine, so first insert info into protected config file
		$conffile = "../config/config-protected.php";
        $build = '';
        $build .= "<?php\n";
        $build .= "\$realmd = array(\n";
        $build .= "'db_type'         => '".$_POST['db_type']."',\n";
        $build .= "'db_host'         => '".$_POST['db_host']."',\n";
        $build .= "'db_port'         => '".$_POST['db_port']."',\n";
        $build .= "'db_username'     => '".$_POST['db_username']."',\n";
        $build .= "'db_password'     => '".$_POST['db_password']."',\n";
        $build .= "'db_name'         => '".$_POST['db_name']."',\n";
        $build .= "'db_encoding'     => 'utf8',\n";
        $build .= ");\n";
		$build .= "?>";
		
		if (is_writeable($conffile)){
                $openconf = fopen($conffile, 'wb');
                fwrite($openconf, $build);
                fclose($openconf);
				}
		else { die('Error!<br /><br />Couldn\'t open config-protected.php for editing, it must be writable by webserver! <br /><a href="javascript: history.go(-1)">Go back, and try again.</a>');
		}

$checker = @mysqli_query($dbcon, "SELECT * FROM `account_extend` LIMIT 1");
if (isset($_GET['task'])) {$task=$_GET['task'];} else {$task="none";}
if (!$checker || $task == "force1")
{
// Dealing with the full install sql file
$sqlopen = @fopen("sql/full_install.sql", "r");
if ($sqlopen) {
    while (!feof($sqlopen)) {
		$queries[] = fgets($sqlopen);
    }
    fclose($sqlopen);
			}
			else {
			echo "Error!<br /><br />Couldn\'t open file full_install.sql. Check if it\'s presented in wwwroot/sql/ and if it\'s readable by webserver!";
			$errmsg = error_get_last();
			echo "<br /><br />PHP error log:<br />".$errmsg['message'];
			exit();}
foreach ($queries as $key => $aquery) {
		if (trim($aquery) == "" || strpos ($aquery, "--") === 0 || strpos ($aquery, "#") === 0) {unset($queries[$key]);}
		}
unset($key, $aquery);

foreach ($queries as $key => $aquery) {
$aquery = rtrim($aquery);
$compare = rtrim($aquery, ";");
if ($compare != $aquery) {$queries[$key] = $compare . "|br3ak|";}
}
unset($key, $aquery);

$queries = implode($queries);
$queries = explode("|br3ak|", $queries);

// Sql injection
foreach ($queries as $query) {
mysqli_query($dbcon, $query);
}
// Extra sql query with db settings
$query = mysqli_query($dbcon,"SELECT * FROM realmlist");
while($row = mysqli_fetch_array($query)) {
mysqli_query($dbcon,"INSERT INTO realm_settings(id_realm,dbhost,dbport,dbuser,dbpass,dbname,chardbname) VALUES('".$row['id']."','".$_POST['db_host']."','".$_POST['db_port']."','".$_POST['db_username']."','".$_POST['db_password']."','".$_POST['world_db_name']."','".$_POST['character_db_name']."')");
}
}
elseif ($task == "force2") {
?>
SQL-injection skipped. Now please give an account name which should be the first superadmin.
With this you'll be able to administrate the site from the admin panel. The account can be both exsisting or new. If the the account doesn't exsit it'll be created, with the given password.
(If the given account already exsist the give password won't take any effect.)
<br /><br />
<form action="index.php?s=3" method="post">
	<table>
		<tr>
			<td>Account name:</td>
			<td><input type='text' name='account'></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type='password' name='passw'></td>
		</tr>
		<tr>
			<td>Confirm password:</td>
			<td><input type='password' name='passw2'></td>
		</tr>
	</table>
	<?php
	foreach ($_POST as $field=>$value) {
	echo "<input type=\"hidden\" name=\"" . $field . "\" value=\"" . $value . "\" />";
	}
	?>
	<p>Please check your details if they are correct before proceeding.</p>
	<br />
	<input type='submit' value='Go to the next step!'>
</form>
<?php
exit();
}
else {echo "Warning!<br /><br />The installer has detected that you already have an installed version of MangosWeb in your database.";
      echo " You can either proceed, but note that in this case old tables will be dropped and all of your current MangosWeb database data will be irrecoverably lost.";
	  echo "<br /><b>OR</b> you can skip sql-injection part.<br /><br /><br />";
	echo "<form action=\"index.php?s=2&task=force1\" method=\"post\">";
	foreach ($_POST as $field=>$value) {
		echo "<input type=\"hidden\" name=\"" . $field . "\" value=\"" . $value . "\" />";
		}
	echo "<input type='submit' value='Proceed with SQL reinstall'></form>";
	echo "<form action=\"index.php?s=2&task=force2\" method=\"post\">";
	foreach ($_POST as $field2=>$value2) {
		echo "<input type=\"hidden\" name=\"" . $field2 . "\" value=\"" . $value2 . "\" />";
		}
	echo "<br /><input type='submit' value='Skip SQL injection'></form><br /><br />";
	// This can be added here too, if someone using the installer only to reconfigure MW
    $query = mysqli_query($dbcon,"SELECT * FROM realmlist");
    while($row = mysqli_fetch_array($query)) {
        mysqli_query($dbcon,"INSERT INTO realm_settings(id_realm,dbhost,dbport,dbuser,dbpass,dbname,chardbname) VALUES('".$row['id']."','".$_POST['db_host']."','".$_POST['db_port']."','".$_POST['db_username']."','".$_POST['db_password']."','".$_POST['world_db_name']."','".$_POST['character_db_name']."')");
    }
    exit();
	}
// Now some text if we actually managed to get here :)
?>
Database config file and table structure successfully installed! Now please give an account name which should be the first superadmin.
With this you'll be able to administrate the site from the admin panel. The account can be both exsisting or new. If the the account doesn't exsit it'll be created, with the given password.
(If the given account already exsist the give password won't take any effect.)
<br /><br />
<form action="index.php?s=3" method="post">
	<table>
		<tr>
			<td>Account name:</td>
			<td><input type='text' name='account'></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type='password' name='passw'></td>
		</tr>
		<tr>
			<td>Confirm password:</td>
			<td><input type='password' name='passw2'></td>
		</tr>
	</table>
	<?php
	foreach ($_POST as $field=>$value) {
	echo "<input type=\"hidden\" name=\"" . $field . "\" value=\"" . $value . "\" />";
	}
	?>
	<p>Please check your details if they are correct before proceeding.</p>
	<br />
	<input type='submit' value='Go to the next step!'>
</form>
<?php
}

//Step three
elseif ($_GET['s'] == 3) {
if (!$_POST['account']) {
	die('Error!<br /><br />No account name was given. Please <a href="javascript: history.go(-1)">go back</a> and correct it.');
	}
//Password hash generator
function sha_password($user,$pass){
    $user = strtoupper($user);
    $pass = strtoupper($pass);
    return SHA1($user.':'.$pass);
}
function calculateSRP6Verifier($username, $password, $salt)
{
    // algorithm constants
    $g = gmp_init(7);
    $N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);

    // calculate first hash
    $h1 = sha1(strtoupper($username . ':' . $password), TRUE);

    // calculate second hash
    $h2 = sha1(strrev($salt) . $h1, TRUE);  // From haukw
    //if(get_config('server_core') == 5)
    //{
    //    $h2 = sha1(strrev($salt) . $h1, TRUE);  // From haukw
    //} else {
    //    $h2 = sha1($salt . $h1, TRUE);
    //}

    // convert to integer (little-endian)
    $h2 = gmp_import($h2, 1, GMP_LSW_FIRST);

    // g^h2 mod N
    $verifier = gmp_powm($g, $h2, $N);

    // convert back to a byte array (little-endian)
    $verifier = gmp_export($verifier, 1, GMP_LSW_FIRST);

    // pad to 32 bytes, remember that zeros go on the end in little-endian!
    $verifier = str_pad($verifier, 32, chr(0), STR_PAD_RIGHT);

    // done!
    return strrev($verifier);  // From haukw
    //if(get_config('server_core') == 5)
    //{
    //    return strrev($verifier);  // From haukw
    //} else {
    //    return $verifier;
    //}
}
function getRegistrationData($username, $password)
{
    // generate a random salt
    $salt = random_bytes(32);

    // calculate verifier using this salt
    $verifier = calculateSRP6Verifier($username, $password, $salt);

    // done - this is what you put in the account table!
    $salt = strtoupper(bin2hex($salt));         	// From haukw
    $verifier = strtoupper(bin2hex($verifier));     // From haukw
    //if(get_config('server_core') == 5)
    //{
    //    $salt = strtoupper(bin2hex($salt));         	// From haukw
    //    $verifier = strtoupper(bin2hex($verifier));     // From haukw
    //}

    return array($salt, $verifier);
}
function verifySRP6($user, $pass, $salt, $verifier)
{
    $verified = calculateSRP6Verifier($user, $pass, hex2bin($salt));
    $verified = strtoupper(bin2hex($verified));
    return $verifier === $verified;
}
//mysqli_connect($_POST['db_host'].":".$_POST['db_port'], $_POST['db_username'], $_POST['db_password']);
//mysqli_select_db($_POST['db_name']);
//Giving root admin rights to the given account
$dbcon = @mysqli_connect($_POST['db_host'].":".$_POST['db_port'], $_POST['db_username'], $_POST['db_password']);
mysqli_select_db($dbcon, $_POST['db_name']);
$accountid = mysqli_query($dbcon, "SELECT `id` FROM `account` WHERE `username` LIKE '".$_POST['account']."'");
$checkacc = mysqli_num_rows($accountid);
if ($checkacc == 1) {
// Account exists
$accountid = mysqli_fetch_row($accountid);
mysqli_query($dbcon, "UPDATE `account_extend` SET `g_id` = '4' WHERE `account_id` = ".$accountid[0]." LIMIT 1 ;");
echo "Congratulations, your MangosWeb is now installed!<br /><br />Installation finished successfully, now you can login with your administrator account on the <a href=\"../index.php\">site index</a>,  ".$_POST['account'].", and do the further configurations!";
}
else {
// No such account, creating one, in this case pwd is needed, so checking whether it's provided...
if (!$_POST['passw'] || !$_POST['passw2']) {die('Error!<br /><br />One or more fields were left empty. Please <a href="javascript: history.go(-1)">go back</a> and correct it.');}
if ($_POST['passw'] != $_POST['passw2']) {die('Error!<br /><br />Passwords didn\'t match. Please <a href="javascript: history.go(-1)">go back</a> and correct it.');}
list($salt, $verifier) = getRegistrationData(strtoupper($_POST['account']), $_POST['passw']);
//$password = sha_password($_POST['account'], $_POST['passw']);
mysqli_query($dbcon, "INSERT INTO `account` (`username`, `s`, `v`, `gmlevel`) VALUES ('".$_POST['account']."', '".$salt."', '".$verifier."', '3' );");
$accountid = mysqli_query($dbcon, "SELECT `id`, `username` FROM `account` WHERE `username` LIKE '".$_POST['account']."'");
$accountid = mysqli_fetch_row($accountid);
mysqli_query($dbcon, "INSERT INTO `forum_accounts` (id_account, displayname) VALUES ('$accountid[0]', '$accountid[1]')");
mysqli_query($dbcon, "INSERT INTO `account_extend` (`account_id`, `g_id`) VALUES ('$accountid[0]', '4');");

// Make forum post
mysqli_query($dbcon, "INSERT INTO `forum_topics` (`id_topic`,`viewlevel`,`postlevel`,`title`,`image`,`views`,`issticked`,`category`,`id_forum_moved`,`poll_question`,`poll_lasts`,`id_forum`) VALUES 
												 (1,'-1','1','How to connect to our Server?','',0,1,2,0,'',0,1),
												 (2,'-1','1','Welcome!','news-alert.gif ',0,1,1,0,'',0,1);");
mysqli_query($dbcon, "INSERT INTO `forum_posts` (`id_post`,`id_topic`,`text`,`isbbcode`,`issignature`,`id_account`,`date`,`hour`,`isreply`,`id_account_edit`,`date_edit`,`hour_edit`) VALUES 
												(1,1,'First make an account on our website then, set your realmlist.wtf (edit it with Notepad), located in your World of Warcraft root folder, to:\r\n\r\n[community]set realmlist 0.0.0.0[/community]\r\n[p]Login and have fun.\r\n\r\nThank You.[/p]',1,1,'".$WEBOW_OWNER."','".date('Y-m-d')."','".date('H:i:s')."',0,0,'0000-00-00','00:00:00'),
												(2,2,'Welcome to %SITENAME%!\r\nWe hope you enjoy playing here.\r\nFeel free to explore our Website.',1,1,'".$accountid[0]."','".date('Y-m-d')."','".date('H:i:s')."',0,0,'0000-00-00','00:00:00');");

mysqli_query($dbcon, "INSERT INTO web_misc(`id_misc`, title, `text`, urls, image) VALUES(1,'Pictures', 'Enjoy our Picture Galleries. Share yours with us aswell.', '[url=?n=media.screenshots]Screenshots[/url]\r\n[url=?n=media.wallpapers]Wallpapers[/url]\r\n[url=?n=community.fanart]Fan Art[/url]', 'misc-image-bc.gif');");
mysqli_query($dbcon, "INSERT INTO web_misc(`id_misc`, title, `text`, urls, image) VALUES(2,'Challenges', 'Two different types where you must use your strategy or creativity.', '[url=?n=community.contests]Contests[/url]\r\n[url=?n=workshop.eventscalendar]Events Calendar[/url]', 'misc-icon-insider.gif');");
mysqli_query($dbcon, "INSERT INTO `forums` (`id_forum`,`title`,`description`,`group`,`image`,`viewlevel`,`postlevel`,`ordenation`,`categorized`) VALUES 
												 (1,'Welcome to WoW- A Beginner\'s Forum','New to the World of Warcraft? Ask questions from experienced players and learn more about the adventures that await you!',0,'newplayers.gif','-1','0',0,0),
												 (2,'Realm Status','Collection of important messages regarding the status of the Realms.',3,'serverstatus.gif','-1','0',1,0),
												 (3,'Customer Service Forum','Keeps us informed about spammers or any other abusive manners. And post bugs/problems here.',6,'cs.gif','-1','0',2,0),
												 (4,'General Discussion','Discuss World of Warcraft.',0,'general.gif','-1','0',3,0),
												 (5,'UI & Macros Forum','Work with other players to create your own special custom interfaces and macros.',0,'uicustomizations.gif','-1','0',5,0),
												 (7,'Druid','',1,'druid.gif','-1','0',7,1),
												 (8,'Suggestions','Have a suggestion for ".$_SESSION['IN_SETTINGS_WEB_NAME']."? Please post it here. ',3,'suggestions.gif','-1','0',6,0),
												 (9,'Proffesions','Discuss professions in detail.',0,'professions.gif','-1','0',8,0),
												 (10,'PvP Discussion','Discuss player versus player combat.',5,'pvp.gif','-1','0',9,0),
												 (11,'Realm Forums','Discuss topics related to World of Warcraft with players on your specific Realm.',3,'realms.gif','-1','0',10,0),
												 (12,'Quests','Talk about and get help with the countless quests in World of Warcraft.',3,'quests.gif','-1','0',11,0),
												 (13,'Off-topic Discussion','Off-topic posts of interest to the ".$_SESSION['IN_SETTINGS_WEB_NAME']." community.',0,'offtopic.gif','-1','0',12,0),
												 (14,'".$_SESSION['IN_SETTINGS_WEB_NAME']." Archive','A collection of important messages and announcements, including the extended forum guidelines.',6,'blizzard.gif','-1','0',13,0),
												 (15,'Guild Recruitment','Searching for a guild, or do you want to advertise your guild?',4,'guilds.gif','-1','0',14,0),
												 (16,'Role-Playing','Pull up a chair, drink a mug of ale, meet new friends, tell stories, and role-play in this forum.',3,'roleplaying.gif','-1','0',15,0),
												 (17,'Guild Relations','Step in and share ideas and experiences on in-guild and inter-guild relationships.',4,'guildrelations.gif','-1','0',16,0),
												 (18,'Raids & Dungeons','Share your victories and discuss tactics, encounters and group composition, and look to future challenges for your band of heroes.',4,'dungeons.gif','-1','0',17,0),
												 (20,'Battlegroup Forums','Discuss your latest victories with your Battlegroup and show off your realm pride!',5,'battlegroup.gif','-1','0',20,0),
												 (21,'Realm Status','Collection of important messages regarding the status of the Realms.!',5,'serverstatus.gif','-1','0',20,0),
												 (22,'Guide Forum','Share your guides for classes, professions, leveling and more.',5,'guides.gif','-1','0',20,0),
												 (23,'Bug Report Forum','Found a bug in the game or on our website? Help us squash it by reporting it here!',5,'bugs.gif','-1','0',20,0),
												 (24,'Rogue','',1,'rogue.gif','-1','0',21,1),
												 (25,'Priest','',1,'priest.gif','-1','0',22,1),
												 (26,'Hunter','',1,'hunter.gif','-1','0',23,1),
												 (27,'Shaman','',1,'shaman.gif','-1','0',24,1),
												 (28,'Warrior','',1,'warrior.gif','-1','0',25,1),
												 (29,'Mage','',1,'mage.gif','-1','0',26,1),
												 (30,'Paladin','',1,'paladin.gif','-1','0',27,1),
												 (31,'Warlock','',1,'warlock.gif','-1','0',28,1);");

echo "Congratulations, your MangosWeb is now installed!<br /><br />Installation finished successfully, now you can login with your administrator account,  ".$_POST['account'].", on the <a href=\"../index.php\">site index</a> and do the further configurations!";
echo "<br/><br/><strong><font color=\"red\">To disable this function and avoid misuse add a file named DISABLE_INSTALLER.php to your install folder to disable the installer!</font></strong>";
}
}
?>
</div>
</div>
<br /><br />
</div>
</div>
</body></html>
