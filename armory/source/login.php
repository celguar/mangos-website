<?php
if(!defined("Armory") || !$config["Login"])
{
	header("Location: ../error.php");
	exit();
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

// Returns SRP6 parameters to register this username/password combination with
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

$banned = 0;
$wrong = 0;
if(isset($_POST["name"]) && isset($_POST["pass"]) && isset($_POST["realm"]) && isset($realms[$realm_name = urldecode($_POST["realm"])]))
{
	//switchConnection("realmd", $realm_name);
    $check_ban = execute_query("realm", "SELECT `ip` from `ip_banned` WHERE `ip` = '".$_SERVER["REMOTE_ADDR"]."' LIMIT 1", 2);
	if($check_ban)
		$banned = 1;
	else
	{
		$user_name = stripslashes($_POST["name"]);
		$user_pass = stripslashes($_POST["pass"]);
        // SRP6 support
        //list($salt, $verifier) = getRegistrationData($user_name, $user_pass);

        $row = execute_query("realm", "SELECT `id`, `username`, `gmlevel`, `s`, `v` FROM `account` WHERE `username` = '".$user_name."' LIMIT 1", 1);
		if($row && verifySRP6($user_name, $user_pass, $row['s'], $row['v']))
		{
			$_SESSION["user_id"] = $row["id"];
			$_SESSION["user_name"] = $row["username"];
			$_SESSION["logged_MBA"] = 1;
			$_SESSION["realm"] = $realm_name;
			if($row["gmlevel"])
				$_SESSION["GM"] = 1;
			echo "<script type=\"text/javascript\">setTimeout(window.open('?searchType=login', '_self'),0);</script>";
			exit();
		}
		else
			$wrong = 1;
	}
}
if(!isset($_SESSION["logged_MBA"]))
{
	startcontenttable();
?>
<div class="profile-wrapper">
<blockquote>
<b class="icharacters">
<h4>
<a href="character-search.php"><?php echo $lang["log_in"] ?></a>
</h4>
<h3><?php echo $lang["login"] ?></h3>
</b>
</blockquote>
<div class="login-box">
<div class="login-contents">
<div class="login-text">
<form action="?searchType=login" method="post" name="login">
<div class="reldiv">
<a class="login-x" href="index.php"></a>
<div class="login-title"><?php echo $lang["login_required"] ?></div>
<div class="login-intromsg"><?php echo $lang["message"] ?></div>
<div class="login-inputcontainer1">
<div class="reldiv">
<div class="login-inputitem1"><?php echo $lang["acc_name"] ?></div>
<div class="login-inputitem2">
<input class="login-accountname" id="accountName" name="name" onkeypress="submitViaEnter(event)" tabindex="1" type="text" value="">
</div>
<div class="login-inputitem3">
<?php echo $lang["realm"] ?>
<select class="login-accountname" id="realm" name="realm" onkeypress="submitViaEnter(event)" tabindex="1" type="text" value="">
<?php
	foreach($realms as $key => $data)
		echo "<option value=\"",urlencode($key),"\">",$key,"</option>";
?>
</select>
<!--<a href="account-name.html">Forgot your Account Name?</a>-->
</div>
</div>
</div>
<div class="login-inputcontainer2">
<div class="reldiv">
<div class="login-inputitem1"><?php echo $lang["acc_password"] ?></div>
<div class="login-inputitem2">
<input class="login-accountname" name="pass" onkeypress="submitViaEnter(event)" tabindex="2" type="password" value="">
</div>
<div class="login-inputitem3">
<?php
	if($banned)
		echo "<center>",$lang["ip"]," ",$_SERVER["REMOTE_ADDR"]," ",$lang["banned"],".</center>";
	else if($wrong)
		echo "<center>",$lang["wrong_user_pass"],"</center>";
?>
<!--<a href="password.html">Forgot your Password?</a> -->
</div>
</div>
</div>
<div class="login-buttons">
<a class="bluebutton" href="javascript:document.login.submit();" id="loginsubmitbutton">
<div class="bluebutton-a"></div>
<div class="bluebutton-b">
<div class="reldiv">
<div class="bluebutton-color"><?php echo $lang["login"] ?></div>
</div><?php echo $lang["login"] ?></div>
<div class="bluebutton-key"></div>
<div class="bluebutton-c"></div>
</a><a class="bluebutton" href="index.php" id="logincancelbutton">
<div class="bluebutton-a"></div>
<div class="bluebutton-b">
<div class="reldiv">
<div class="bluebutton-color"><?php echo $lang["cancel"] ?></div>
</div><?php echo $lang["cancel"] ?></div>
<div class="bluebutton-c"></div>
</a>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
<?php
	endcontenttable();
}
else
{
	$exp_changed = 0;
	//switchConnection("realmd", $_SESSION["realm"]);
	if(isset($_POST["expansion"]))
	{
		//execute_query("realm", "UPDATE `account` SET `expansion` = '".$_POST["expansion"]."' WHERE `id` = ".$_SESSION["user_id"]." LIMIT 1");
		$exp_changed = 1;
		$expansion = $_POST["expansion"];
	}
	else
		$expansion = execute_query("realm", "SELECT `expansion` FROM `account` WHERE `id` = ".$_SESSION["user_id"]." LIMIT 1", 2);
	$selected_0 = "";
	$selected_1 = "";
	$selected_2 = "";
	switch($expansion)
	{
		case 0: $selected_0 = "selected"; break;
		case 1: $selected_1 = "selected"; break;
		case 2: $selected_2 = "selected"; break;
	}
?>
<br /><br /><br /><center><span class="csearch-results-header"><?php echo $lang["realm"],": ",$_SESSION["realm"]?></span></center>
<br /><center><span class="csearch-results-header"><?php echo $lang["logged_as"]," ",$_SESSION["user_name"]?></span></center>
<center><form method="post" action="?searchType=login"><input name="logout" style="border: 1px solid; font-weight: bold; background-color: rgb(0, 0, 0); color: rgb(255, 172, 4);" value="<?php echo $lang["log_out"] ?>" type="submit"></form></center>
<form method="post" action="?searchType=login">
<br /><center><span class="csearch-results-header"><?php echo $lang["acc_expansion"] ?>:</span>
<select class="reg" name="expansion">
<option value="0" <?php echo $selected_0 ?>><?php echo $lang["classic"] ?></option>
<option value="1" <?php echo $selected_1 ?>><?php echo $lang["tbc"] ?></option>
<option value="2" <?php echo $selected_2 ?>><?php echo $lang["wotlk"] ?></option>
</select>
<input name="change_exp" style="border: 1px solid; font-weight: bold; background-color: rgb(0, 0, 0); color: rgb(255, 172, 4);" value="<?php echo $lang["change"] ?>" type="submit">
</form>
</center>
<?php
	if($exp_changed)
		echo "<center>",$lang["acc_expansion_changed"],"</center>";
?>
<br />
<script type="text/javascript">
function validate_form(thisform)
{
	with (thisform)
	{
		if (old_pass.value.length < 5 || old_pass.value.length > 30)
			{alert("<?php echo $lang["length_pass"] ?>");old_pass.focus();return false;}
		if (new_pass.value.length < 5 || new_pass.value.length > 30)
			{alert("<?php echo $lang["length_newpass"] ?>");new_pass.focus();return false;}
		if (new_pass.value!=rep_newpass.value)
			{alert("<?php echo $lang["new_rep_newpass"] ?>");rep_newpass.focus();return false;}
	}
}
</script>
<center><span class="csearch-results-header"><?php echo $lang["change_pass"] ?></span><br /><br />
<form method="post" action="?searchType=login" onsubmit="return validate_form(this)">
<table border="0">
<tr>
<td><span class="csearch-results-header"><?php echo $lang["old_pass"] ?>:</span></td>
<td><input class="reg" maxlength="30" type="password" name="old_pass" size="30"></td>
</tr>
<tr>
<td><span class="csearch-results-header"><?php echo $lang["new_pass"] ?>:</span></td>
<td><input class="reg" maxlength="30" type="password" name="new_pass" size="30"></td>
</tr>
<tr>
<td><span class="csearch-results-header"><?php echo $lang["rep_newpass"] ?>:</span></td>
<td><input class="reg" maxlength="30" type="password" name="rep_newpass" size="30"></td>
</tr>
</table>
<center><input name="change" style="border: 1px solid; font-weight: bold; background-color: rgb(0, 0, 0); color: rgb(255, 172, 4);" value="<?php echo $lang["change_pass"] ?>" type="submit"></center>
</form>
</center>
<?php
    // TODO pass restore or remove it
	/*if(isset($_POST["old_pass"]) && isset($_POST["new_pass"]) && isset($_POST["rep_newpass"]))
	{
		$old_pass_len = strlen($_POST["old_pass"]);
		$new_pass_len = strlen($_POST["new_pass"]);
		if($old_pass_len >= 5 && $old_pass_len <= 30 && $new_pass_len >= 5 && $new_pass_len <= 30 && $_POST["new_pass"] == $_POST["rep_newpass"])
		{
			$sha_pass_hash = mysql_result(execute_query("SELECT `sha_pass_hash` FROM `account` WHERE `id` = ".$_SESSION["user_id"]." LIMIT 1"), 0);
			$old_password = sha1(strtoupper($_SESSION["user_name"].":".stripslashes($_POST["old_pass"])));
			if($old_password == $sha_pass_hash)
			{
				$new_password = sha1(strtoupper($_SESSION["user_name"].":".stripslashes($_POST["new_pass"])));
				execute_query("UPDATE `account` SET `sha_pass_hash` = '".$new_password."' WHERE `id` = ".$_SESSION["user_id"]." LIMIT 1");
				echo "<center>",$lang["pass_changed"],"</center>";
			}
			else
				echo "<center>",$lang["wrong_old_pass"],"</center>";
		}
	}*/
	//switchConnection("characters", $_SESSION["realm"]);
	$squery = execute_query("char", "SELECT `name` FROM `characters` WHERE `account` = ".$_SESSION["user_id"]);
	$snumresults = $squery ? count($squery) : 0;
	echo "<br /><center><span class=\"csearch-results-header\">",$lang["acc_char"]," - ",$snumresults,":</span>";
	foreach ($squery as $sresults)
    {
        $theName = $sresults["name"];
        echo "<br /><a href=\"index.php?searchType=profile&character=",$theName,"&realm=",$_SESSION["realm"],"\" class=\"csearch-results-header\" onmouseover=\"showTip('",$lang["char_link"],"')\" onmouseout=\"hideTip()\">",$theName,"</a>";
    }
	echo "</center>";
}
?>