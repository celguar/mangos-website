<?php
function check_if_online($name,$db)
{
	change_db($db);
	$check_status = "SELECT `online` FROM `characters` WHERE `name` LIKE '$name'";
	$check=mysql_query($check_status) or die (mysql_error());
	if (mysql_num_rows($check)<>0)
	{
		$row=mysql_fetch_array($check);
		$status=$row['online'];
		if ($status == 1)
			return 1;
		else
			return 0;
	}else
		return -1;
}
function change_name($name,$newname,$db)
{
	change_db($db);
	$change_name = "UPDATE `characters` SET `name`= '$newname' WHERE `name` LIKE '$name'";
	mysql_query($change_name) or die (mysql_error());
}
?>