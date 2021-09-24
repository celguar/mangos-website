<?php
if(!defined("Armory") || !$config["Registration"] || $config["ExternalRegistrationPage"])
{
	header("Location: ../error.php");
	exit();
}
?>
<br /><br /><br />
<script type="text/javascript">
function validate_form(thisform)
{
	with (thisform)
	{
		if (name.value.length < 4 || name.value.length > 25)
			{alert("<?php echo $lang["length_name"] ?>");name.focus();return false;}
		if (pass.value.length < 5 || pass.value.length > 30)
			{alert("<?php echo $lang["length_pass"] ?>");pass.focus();return false;}
		if (pass2.value!=pass.value)
			{alert("<?php echo $lang["pass_verifipass"] ?>");pass2.focus();return false;}
		var pattern=/^[0-9a-z_.]+@[0-9a-z_^\.]+\.[a-z]{2,10}$/i;
		if (!pattern.test(email.value))
			{alert("<?php echo $lang["invalid_email"] ?>");email.focus();return false;}
	}
}
</script>
<center><span class="csearch-results-header"><?php echo $lang["create_acc"] ?></span><br /><br />
<form method="post" action="?searchType=registration" onsubmit="return validate_form(this)">
<table border="0">
<tr>
<td></td>
</tr>
<tr>
<td><span class="csearch-results-header"><?php echo $lang["realm"] ?>:</span></td>
<td><select class="reg" name="realm">
<?php
foreach($realms as $key => $data)
	echo "<option value=\"",urlencode($key),"\">",$key,"</option>";
?>
</select></td>
</tr>
<tr>
<td><span class="csearch-results-header"><?php echo $lang["acc_expansion"] ?></span></td>
<td><input type="radio" class="reg" name="expansion" value="0"><span class="reg"><?php echo $lang["classic"] ?></span>
<input type="radio" class="reg" name="expansion" value="1" checked><span class="reg"><?php echo $lang["tbc"] ?></span>
<input type="radio" class="reg" name="expansion" value="2"><span class="reg"><?php echo $lang["wotlk"] ?></span></td>
</tr>
<tr>
<td><span class="csearch-results-header"><?php echo $lang["acc_name"] ?>:</span></td>
<td><input class="reg" maxlength="25" type="text" name="name" size="30"></td>
</tr>
<tr>
<td><span class="csearch-results-header"><?php echo $lang["acc_password"] ?>:</span></td>
<td><input class="reg" maxlength="30" type="password" name="pass" size="30"></td>
</tr>
<tr>
<td><span class="csearch-results-header"><?php echo $lang["verify_pass"] ?>:</span></td>
<td><input class="reg" maxlength="30" type="password" name="pass2" size="30"></td>
</tr>
<tr>
<td><span class="csearch-results-header"><?php echo $lang["email"] ?>:</span></td>
<td><input class="reg" maxlength="60" type="text" name="email" size="30"></td>
</tr>
</table>
<br />
<center><input name="reg" value="<?php echo $lang["create"] ?>" style="border: 1px solid; font-weight: bold; background-color: rgb(0, 0, 0); color: rgb(255, 172, 4);" type="submit"></center>
</form>
</center>
<?php
if(isset($_POST["reg"]) && isset($_POST["name"]) && isset($_POST["pass"]) && isset($_POST["email"]))
{
	switchConnection("realmd", urldecode($_POST["realm"]));
	if(mysql_num_rows(execute_query("SELECT `ip` from `ip_banned` WHERE `ip` = '".$_SERVER["REMOTE_ADDR"]."' LIMIT 1")))
		echo "<center>",$lang["ip"]," ",$_SERVER["REMOTE_ADDR"]," ",$lang["banned"],"</center>";
	else if($config["LockReg"] && mysql_num_rows(execute_query("SELECT `last_ip` from `account` WHERE `last_ip` = '".$_SERVER["REMOTE_ADDR"]."'")) >= $config["LockReg"])
		echo "<center>",$lang["max_ip"]," (",$config["LockReg"],")</center>";
	else
	{
		$username = strtoupper(trim(stripslashes($_POST["name"])));
		$pass = trim(stripslashes($_POST["pass"]));
		$email = trim(stripslashes($_POST["email"]));
		$name_len = strlen($username);
		$pass_len = strlen($pass);
		if($name_len > 4 && $name_len < 25 && $pass_len > 5 && $pass_len < 30 && preg_match("|^[0-9a-z_.]+@[0-9a-z_^\.]+\.[a-z]{2,10}$|i", $email))
		{
			if(mysql_num_rows(execute_query("SELECT `username` FROM `account` WHERE `username` = '".mysql_real_escape_string($username)."' LIMIT 1")))
				echo "<center>",$lang["name_exist"],".<center>";
			else
			{
				$sha_pass_hash = sha1(strtoupper($username.':'.$pass));
				execute_query("INSERT INTO `account` (`username`, `sha_pass_hash`, `gmlevel`, `email`, `locked`, `last_ip`, `expansion`)
					VALUES ('".mysql_real_escape_string($username)."', '".$sha_pass_hash."', ".$config["GmLevel"].", '".mysql_real_escape_string($email)."', ".$config["LockAcc"].", '".$_SERVER["REMOTE_ADDR"]."', ".$_POST["expansion"].")");
				echo "<center>",$lang["acc_created"]," ",$username," ",$lang["complete"],".</center>";
			}
		}
	}
}
?>