<?php
function GetCharacterPortrait($CharacterLevel, $CharacterGender, $CharacterRace, $CharacterClass)
{
	if($CharacterLevel <= 59)
		return "wow-default/".$CharacterGender."-".$CharacterRace."-".$CharacterClass.".gif";
	else if($CharacterLevel >= 60 && $CharacterLevel <= 69)
		return "wow/".$CharacterGender."-".$CharacterRace."-".$CharacterClass.".gif";
	else if($CharacterLevel >= 70 && $CharacterLevel <= 79)
		return "wow-70/".$CharacterGender."-".$CharacterRace."-".$CharacterClass.".gif";
	else if($CharacterLevel >= 80)
		return "wow-80/".$CharacterGender."-".$CharacterRace."-".$CharacterClass.".gif";
}
function GetFaction($CharacterRace)
{
	if($CharacterRace == 1 || $CharacterRace == 3 || $CharacterRace == 4 || $CharacterRace == 7 || $CharacterRace == 11)
		return "alliance";
	else
		return "horde";
}
function GetNameFromDB($Id, $Table)
{
    global $ARDB;
	//switchConnection("armory", REALM_NAME);
    //$Query = execute_query("armory", "SELECT `name` FROM `".$Table."` WHERE `id`=".$Id." LIMIT 1", 0, true);
	//$Query = $ARDB->selectCell("SELECT `name` FROM `".$Table."` WHERE `id`=".$Id." LIMIT 1");
    $Query = execute_query("armory", "SELECT `name` FROM `".$Table."` WHERE `id`=".$Id." LIMIT 1", 2);
	if($Query)
		return $Query;
	else
		return "";
}
function GetIcon($Type, $DisplayIconId)
{
	if($Type == "item")
		$Table = "dbc_itemdisplayinfo";
	else //$Type == "spell"
		$Table = "dbc_spellicon";
	if($DisplayIconId && $icon = GetNameFromDB($DisplayIconId, $Table))
		return "images/icons/64x64/".$icon.".png";
	else
		return "images/icons/64x64/404.png";
}
function GetItemSource($item_id, $pvpreward = 0)
{
	global $lang;
	//switchConnection("mangos", REALM_NAME);
	if(execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `quest_template` WHERE `SrcItemId` = ".$item_id." LIMIT 1", 1))
		return $lang["quest_item"];
	else if(execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `npc_vendor` WHERE `item` = ".$item_id." LIMIT 1", 1))
		return $pvpreward ? $lang["pvp_reward"] : $lang["vendor"];
	else if(execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `gameobject_loot_template` WHERE `item` = ".$item_id." LIMIT 1", 1))
		return $lang["chest_drop"];
	else if(execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `creature_loot_template` WHERE `item` = ".$item_id." LIMIT 1", 1))
		return $lang["drop"];
	else if(execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `quest_template` WHERE `RewChoiceItemId1` = ".$item_id." OR `RewChoiceItemId2` = ".$item_id."
	OR `RewChoiceItemId3` = ".$item_id." OR `RewChoiceItemId4` = ".$item_id." OR `RewChoiceItemId5` = ".$item_id." OR `RewChoiceItemId6` = ".$item_id."
	OR `RewItemId1` = ".$item_id." OR `RewItemId2` = ".$item_id." OR `RewItemId3` = ".$item_id." OR `RewItemId4` = ".$item_id." LIMIT 1", 1))
		return $lang["quest_reward"];
	else
		return $lang["created"];
}
function cache_item($itemid)
{
	global $config, $realms;
	//Get item data
	//switchConnection("mangos", REALM_NAME);
	if($config["locales"])
	{
		$nameloc = "name_loc".$config["locales"];
		$itemData = execute_query("world", "SELECT `name`, `".$nameloc."`, `Quality`, `displayid` FROM `item_template` LEFT JOIN `locales_item` ON `item_template`.`entry` = `locales_item`.`entry` WHERE `item_template`.`entry` = ".$itemid." LIMIT 1",1);
		if($itemData[$nameloc])
			$itemData["name"] = $itemData[$nameloc];
	}
	else
		$itemData = execute_query("world","SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry` = ".$itemid, 1);
	$db_fields = array(
	"item_id" => $itemid,
	"mangosdbkey" => $realms[REALM_NAME][2],
	"item_name" => $itemData["name"],
	"item_quality" => $itemData["Quality"],
	"item_icon" => GetIcon("item",$itemData["displayid"]),
	);
	return InsertCache($db_fields , "cache_item");
}
function cache_item_tooltip($itemid)
{
	global $realms;
	require_once "tooltipmgr.php";
	$item_tooltip = outputTooltip($itemid);
	$db_fields = array(
	"item_id" => $itemid,
	"mangosdbkey" => $realms[REALM_NAME][2],
	"item_html" => $item_tooltip[0],
	"item_info_html" => $item_tooltip[1],
	);
	return InsertCache($db_fields , "cache_item_tooltip");
}
function cache_item_char($itemid, $owner, $slot, $itemguid, $itemlist)
{
	global $realms;
	require_once "tooltipmgr.php";
	$db_fields = array(
	"item_guid" => $itemguid,
	"chardbkey" => $realms[REALM_NAME][1],
	"item_owner" => $owner,
	"item_slot" => $slot,
	"item_html" => outputTooltip($itemid, $itemguid, $itemlist),
	);
	return InsertCache($db_fields , "cache_item_char");
}
function cache_item_search($itemid)
{
	global $config, $realms;
	//switchConnection("mangos", REALM_NAME);
	if($config["locales"])
	{
		$nameloc="name_loc".$config["locales"];
		$itemData = execute_query("world", "SELECT `name`, `".$nameloc."`, `ItemLevel`, `Quality`, `Flags` FROM `item_template` LEFT JOIN `locales_item` ON `item_template`.`entry` = `locales_item`.`entry` WHERE `item_template`.`entry` = ".$itemid." LIMIT 1", 1, "Error in item cache process for item ".$itemid);
		if($itemData[$nameloc])
			$itemData["name"] = $itemData[$nameloc];
	}
	else
		$itemData = execute_query("world", "SELECT `name`, `ItemLevel`, `Quality`, `Flags` FROM `item_template` WHERE `entry` = ".$itemid." LIMIT 1", 1, "Error in item cache process for item ".$itemid);
	if(($itemData["Flags"] & 32768) == 32768)
		$pvpreward = 1;
	else
		$pvpreward = 0;
	$db_fields = array(
	"item_id" => $itemid,
	"mangosdbkey" => $realms[REALM_NAME][2],
	"item_name" => $itemData["name"],
	"item_level" => $itemData["ItemLevel"],
	"item_source" => GetItemSource($itemid, $pvpreward),
	"item_relevance" => $itemData["Quality"]*25+$itemData["ItemLevel"],
	);
	return InsertCache($db_fields, "cache_item_search");
}
function InsertCache($db_fields, $db)
{
	// Insert
	//switchConnection("armory", REALM_NAME);
	$querystring = "INSERT INTO `".$db."` (";
	foreach($db_fields as $field => $value)
		$querystring .= "`".$field."`,";
	// Chop the end of $querystring off
	$querystring = substr($querystring, 0, -1);
	$querystring .= ") VALUES (";
	foreach($db_fields as $field => $value)
		$querystring .= "'".str_replace("'", "\'", $value)."',";
	// Chop the end off again
	$querystring = substr($querystring, 0, -1);
	$querystring .= ")";
	execute_query("armory", $querystring);
	return $db_fields; //return an associative array
}
// validate input - preventing SQL injection
function validate_string($string)
{
	$string = trim($string);
	// strips excess whitespace
	$string = preg_replace('/\s\s+/', " ", $string);
	if(preg_match('/[^[:alnum:]\sА-ПР-Яа-пр-я]/', $string))
		$string = "";
	return $string;
}
function exclude_GMs()
{
	global $config;
	$excludeGMs = "";
	if($config["ExcludeGMs"])
		$excludeGMs = " AND (`extra_flags` & 1) = 0";
	if(isset($_SESSION["GM"]))
		$excludeGMs = "";
	return $excludeGMs;
}
function microtime_float()
{
	list($utime, $time) = explode(" ", microtime());
	return ((float)$utime + (float)$time);
}
function ordinal_suffix($number)
{
	global $lang;
	if(!$number)
		return $lang["none"];
	switch($number % 10)
	{
		case 1: return $number.$lang["st"];
		case 2: return $number.$lang["nd"];
		case 3: return $number.$lang["rd"];
		default: return $number.$lang["th"];
	}
}
function startcontenttable($class="full-list")
{
	echo "<div class=\"list\">
	<div class=\"",$class,"\">
	<div class=\"tip\" style=\"clear: left;\">
	<table width=\"100\">
	<tr>
	<td class=\"tip-top-left\"></td><td class=\"tip-top\"></td><td class=\"tip-top-right\"></td>
	</tr>
	<tr>
	<td class=\"tip-left\"></td><td class=\"tip-bg\">";
}
function endcontenttable()
{
	echo "</td>
	<td class=\"tip-right\"></td>
	</tr>
	<tr>
	<td class=\"tip-bot-left\"></td><td class=\"tip-bot\"></td><td class=\"tip-bot-right\"></td>
	</tr>
	</table>
	</div>
	</div>
	</div>";
}
function showerror($errTitle, $errMessage)
{
	startcontenttable("team-side");
	echo "Error - ",$errTitle,"<br />",$errMessage;
	endcontenttable();
}
function guild_arenateam_tooltip_frame($type, $id, $name, $leader_name, $num_members)
{
	global $lang;
	if($type == "guild")
	{
		$type_name = $lang["guild"];
		$id_field = "guildid";
		$leader = $lang["leader"];
	}
	else//if($type == "team")
	{
		$type_name = $lang["arena_team"];
		$id_field = "arenateamid";
		$leader = $lang["captain"];
	}
	$guild_arenateam_tooltip = "<a href=\"index.php?searchType=".$type."info&".$id_field."=".$id."&realm=".REALM_NAME."\" onmouseover=\"showTip('";
	$guild_arenateam_tooltip .= "<span class=\'profile-tooltip-header\'>".$type_name." - ".addslashes($name)."</span><br />";
	$guild_arenateam_tooltip .= "<span class=\'profile-tooltip-description\'>".$leader.": ".$leader_name."<br />".$lang["members"].": ".$num_members."</span>";
	$guild_arenateam_tooltip .= "')\" onmouseout=\"hideTip()\">".$name."</a>";
	return $guild_arenateam_tooltip;
}
function guild_tooltip($guildid)
{
	global $lang, $guildInfoTooltip;
	if(!$guildid)
		return $lang["none"];
	if(!isset($guildInfoTooltip[$guildid]))
	{
		//switchConnection("characters", REALM_NAME);
		//$glinkresults = $CHDB->selectRow("SELECT `name`, `leaderguid` FROM `guild` WHERE `guildid` = ".$guildid);
        $glinkresults = execute_query("char", "SELECT `name`, `leaderguid` FROM `guild` WHERE `guildid` = ".$guildid, true);
		if($guildLeader = execute_query("char", "SELECT `name` FROM `characters` WHERE `guid` = ".$glinkresults["leaderguid"], true))
			$guildLeaderName = $guildLeader["name"];
		else
			$guildLeaderName = $lang["unknown"];
		$guildMembers = execute_query("char", "SELECT COUNT(*) FROM `guild_member` WHERE `guildid` = ".$guildid, 2);
		$guildInfoTooltip[$guildid] = guild_arenateam_tooltip_frame("guild", $guildid, $glinkresults["name"], $guildLeaderName, $guildMembers);
	}
	return $guildInfoTooltip[$guildid];
}
function GetArenaTeamEmblem($teamId = 0) {
    if($teamId == 0) {
        return 0;
    }
    $arenaTeamEmblem = execute_query("char", "SELECT `BackgroundColor` AS `background`, `BorderColor` AS `borderColor`, `BorderStyle` AS `borderStyle`, `EmblemColor` AS `iconColor`, `EmblemStyle` AS `iconStyle` FROM `arena_team` WHERE `arenateamid`=".$teamId, 1);

    // Displaying correct Team Emblem
    // We have DECIMAL value here in DB (4294106805 e.g.)
    // We need to reduce it to 255 (4294106550)
    // Then convert it to HEX (FFF2DDB6)
    // Remove 2 first symbols FF (F2DDB6)
    // And somehow add '0x' substring to our HEX value (0xF2DDB6).
    // If I'm doing it wrong (and I'm totally sure that I'm doing it in wrong way),
    // please report on GitHub.com/Shadez/wowarmory/issues/

    $arenaTeamEmblem['background'] = '0x' . substr(dechex($arenaTeamEmblem['background']-255), 2);
    $arenaTeamEmblem['borderColor'] = '0x' . substr(dechex($arenaTeamEmblem['borderColor']-255), 2);
    $arenaTeamEmblem['iconColor'] = '0x' . substr(dechex($arenaTeamEmblem['iconColor']-255), 2);
    return $arenaTeamEmblem;
}
function initialize_realm($realm_force = 0)
{
	global $realms, $realmd_DB, $mangosd_DB, $characters_DB, $armory_DB, $DB, $WSDB, $CHDB, $ARDB;
	if(isset($_SESSION["realm"]))
		define("REALM_NAME", $_SESSION["realm"]);
	else if(isset($_GET["realm"]) && isset($realms[$realm_name = stripslashes($_GET["realm"])]))
		define("REALM_NAME", $realm_name);
	else if ($realm_force)
	    define("REALM_NAME", $realm_force);
	else
		define("REALM_NAME", DefaultRealmName);
	//switchConnection("armory", REALM_NAME);

    $needed_db = $realmd_DB[$realms[REALM_NAME][0]];
// DB layer documentation at http://en.dklab.ru/lib/DbSimple/
    $DB = dbsimple_Generic::connect( "mysql://" . $needed_db[1] .
        ":" . $needed_db[2] . "@" . $needed_db[0] .
        "/" . $needed_db[3] . "" ) ;
// Set error handler for $DB.
    $DB->setErrorHandler( 'databaseErrorHandler' ) ;
// Also set to default encoding for $DB
    $DB->query( "SET NAMES UTF8;" ) ;

//Connects to WORLD DB
    unset($needed_db);
    $needed_db = $mangosd_DB[$realms[REALM_NAME][2]];
    $WSDB = dbsimple_Generic::connect( "mysql://" . $needed_db[1] .
        ":" . $needed_db[2] . "@" . $needed_db[0] .
        "/" . $needed_db[3] . "" ) ;
    if ( $WSDB )
        $WSDB->setErrorHandler( 'databaseErrorHandler' ) ;
    if ( $WSDB )
        $WSDB->query( "SET NAMES UTF8;" ) ;

    unset($needed_db);
    $needed_db = $characters_DB[$realms[REALM_NAME][1]];
    $CHDB = dbsimple_Generic::connect( "mysql://" . $needed_db[1] .
        ":" . $needed_db[2] . "@" . $needed_db[0] .
        "/" . $needed_db[3] . "" ) ;
    if ( $CHDB )
        $CHDB->setErrorHandler( 'databaseErrorHandler' ) ;
    if ( $CHDB )
        $CHDB->query( "SET NAMES UTF8;" ) ;

    unset($needed_db);
    $needed_db = $armory_DB[$realms[REALM_NAME][3]];
    $ARDB = dbsimple_Generic::connect( "mysql://" . $needed_db[1] .
        ":" . $needed_db[2] . "@" . $needed_db[0] .
        "/" . $needed_db[3] . "" ) ;
    if ( $ARDB )
        $ARDB->setErrorHandler( 'databaseErrorHandler' ) ;
    if ( $ARDB )
        $ARDB->query( "SET NAMES UTF8;" ) ;

    define("CLIENT", $ARDB->selectCell("SELECT `value` FROM `conf_client` LIMIT 1"));
    define("LANGUAGE", $ARDB->selectCell("SELECT `value` FROM `conf_lang` LIMIT 1"));
}
function emblem_color_convert($color)
{
	return str_pad(base_convert($color, 10, 16), 8, 0, STR_PAD_LEFT);
}

function databaseErrorHandler($message, $info)
{
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; print_r($info); echo "</pre>";
    exit();
}
?>