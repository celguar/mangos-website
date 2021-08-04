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
@mysql_connect($_POST['db_host'].":".$_POST['db_port'], $_POST['db_username'], $_POST['db_password']) or die ('Error!<br /><br />Couldn\'t connect to the MySql server, most likely the given information is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br />'.mysql_error());
@mysql_select_db($_POST['world_db_name']) or die('Error!<br /><br />Couldn\'t select World db, most likely the given name is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br />'.mysql_error());
@mysql_select_db($_POST['character_db_name']) or die('Error!<br /><br />Couldn\'t select Characters db, most likely the given name is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br />'.mysql_error());
@mysql_select_db($_POST['db_name']) or die('Error!<br /><br />Couldn\'t select Realmd db, most likely the given name is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br />'.mysql_error());
// Check if "account" table exsists, so we make (almost) sure mangos is actually installed (which is necesarry for this whole thing to work)
@mysql_query("SELECT * FROM `account` LIMIT 1") or die('Error!<br /><br />Account table not found, seems like mangos isn\'t installed.<br /><br />MySql error log:<br />'.mysql_error());
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
		else { die('Error!<br /><br />Couldn\'t open config-protected.php for editing, it must be writable by webserver! <br /><a href="javascript: history.go(-1)">Go back, and try again.</a>');}
				
	
// Preparing for sql injection... (prashing, etc...)
$checker = @mysql_query("SELECT * FROM `account_extend` LIMIT 1");
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
mysql_query($query);
}
// Extra sql query with db settings
$dbinfo = $_POST['db_username'].";".$_POST['db_password'].";".$_POST['db_port'].";".$_POST['db_host'].";".$_POST['world_db_name'].";".$_POST['character_db_name'];
mysql_query("UPDATE `realmlist` SET `dbinfo` = '".$dbinfo."' WHERE `id` = 1 LIMIT 1") or die(mysql_error());
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
	$dbinfo = $_POST['db_username'].";".$_POST['db_password'].";".$_POST['db_port'].";".$_POST['db_host'].";".$_POST['world_db_name'].";".$_POST['character_db_name'];
	mysql_query("UPDATE `realmlist` SET `dbinfo` = '".$dbinfo."' WHERE `id` = 1 LIMIT 1") or die(mysql_error());
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
mysql_connect($_POST['db_host'].":".$_POST['db_port'], $_POST['db_username'], $_POST['db_password']);
mysql_select_db($_POST['db_name']);
//Giving root admin rights to the given account
$accountid = mysql_query("SELECT `id` FROM `account` WHERE `username` LIKE '".$_POST['account']."'");
$checkacc = mysql_num_rows($accountid);
if ($checkacc == 1) {
// Account exsist
$accountid = mysql_fetch_row($accountid);
mysql_query("UPDATE `account_extend` SET `g_id` = '4' WHERE `account_id` = ".$accountid[0]." LIMIT 1 ;");
echo "Congratulations, your MangosWeb is now installed!<br /><br />Installation finished successfully, now you can login with your administrator account on the <a href=\"../index.php\">site index</a>,  ".$_POST['account'].", and do the further configurations!";
}
else {
// No such account, creating one, in this case pwd is needed, so checking whether it's provided...
if (!$_POST['passw'] || !$_POST['passw2']) {die('Error!<br /><br />One or more fileds were left empty. Please <a href="javascript: history.go(-1)">go back</a> and correct it.');}
if ($_POST['passw'] != $_POST['passw2']) {die('Error!<br /><br />Passwords didn\'t match. Please <a href="javascript: history.go(-1)">go back</a> and correct it.');}
$password = sha_password($_POST['account'], $_POST['passw']);
mysql_query("INSERT INTO `account` (`username`, `sha_pass_hash`, `gmlevel`) VALUES ('".$_POST['account']."', '$password', '3' );");
$accountid = mysql_query("SELECT `id` FROM `account` WHERE `username` LIKE '".$_POST['account']."'");
$accountid = mysql_fetch_row($accountid);
mysql_query("INSERT INTO `account_extend` (`account_id`, `g_id`) VALUES ('$accountid[0]', '4');");
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
