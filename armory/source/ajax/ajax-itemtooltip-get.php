<?php
if(isset($_GET["item"]) && isset($_GET["dbkey"]) && isset($_GET["owned"]))
{
    require "ajax-shared-functions.php";
	//require "../../configuration/mysql.php";
	$itemidorguid = (int) $_GET["item"];
	$dbkey = (int) $_GET["dbkey"];
	$owned = (int) $_GET["owned"];
	$realm = DefaultRealmName;
	foreach($realms as $key => $value)
		if($dbkey == $value[$owned])
			$realm = $key;
	//switchConnection("armory", $realm);
	if($owned == 2)
		$query = execute_query("armory", "SELECT `item_html` FROM `cache_item_tooltip` WHERE `item_id` = ".$itemidorguid."  AND `mangosdbkey` = ".$dbkey." LIMIT 1", 2);
	else // if($owned == 1)
		$query = execute_query("armory", "SELECT `item_html` FROM `cache_item_char` WHERE `item_guid` = ".$itemidorguid." AND `chardbkey` = ".$dbkey." LIMIT 1", 2);
	if($query)
		echo $query;
	else
		echo "<span class=\"profile-tooltip-description\">Error: Not Found</span>";
}
else
	echo "<span class=\"profile-tooltip-description\">Error: Get lost</span>";
?>