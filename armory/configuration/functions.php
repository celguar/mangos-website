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
function GetCharacterAchievementPoints($charGuid)
{
    if (CLIENT == 1) // todo tbc achiev
        return 0;

    $points = 0;
    $achievIds = "";
    $query = execute_query("char", "SELECT * FROM `character_achievement` WHERE `guid` = ".$charGuid." ORDER BY `date` DESC", 0);
    if ($query)
    {
        $achievements = array();
        foreach ($query as $achiev)
        {
            $achievements[] = $achiev['achievement'];
            //echo $achiev['achievement'];
        }
        $achievIds = implode(",", $achievements);
        //echo $achievIds;
        //print $achievements[0];
        if (CLIENT < 2) // TODO add tbc
        {
            $points = execute_query("world", "SELECT SUM(`Points`) FROM `achievement_dbc` WHERE `ID` IN (".$achievIds.")", 2);
        }
        else
        {
            $points = execute_query("armory", "SELECT SUM(`points`) FROM `dbc_achievement` WHERE `id` IN (".$achievIds.")", 2);
        }
    }

    return $points;
}
function GetFaction($CharacterRace)
{
	if($CharacterRace == 1 || $CharacterRace == 3 || $CharacterRace == 4 || $CharacterRace == 7 || $CharacterRace == 11)
		return "alliance";
	else
		return "horde";
}
function isAlliance($race) {
    if ($race == 1 || $race == 3 || $race == 4 || $race == 7 || $race == 11) {
        return true;
    }
    return false;
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
function GetPlayerSpecId($class, $topTree)
{
    switch($class)
    {
        case 11:
        {
            if ($topTree == 0)
                return 29;
            if ($topTree == 1)
                return 32;
            if ($topTree == 2)
                return 31;
        }
        case 6:
        {
            if ($topTree == 0)
                return 16;
            if ($topTree == 1)
                return 18;
            if ($topTree == 2)
                return 19;
        }
        default:
        {
            if ($class < 6)
            {
                return ($class - 1) * 3 + 1 + $topTree;
            }
            else
            {
                return ($class - 1) * 3 + 2 + $topTree;
            }
        }
    }
    return 0;
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
function PrintItemDropChance($chance)
{
    global $lang;
    $dropChance = " ";
    if ($chance <= 2)
        $dropChance .= $lang["textDR1"];
    else if ($chance < 15)
        $dropChance .= $lang["textDR2"];
    else if ($chance < 25)
        $dropChance .= $lang["textDR3"];
    else if ($chance < 51)
        $dropChance .= $lang["textDR4"];
    else if (chance > 50)
        $dropChance .= $lang["textDR5"];
    else
        $dropChance = "";

    return $dropChance;
}
function GetItemSource($item_id, $pvpreward = 0)
{
	global $lang;
	//switchConnection("mangos", REALM_NAME);
	if(execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `quest_template` WHERE `SrcItemId` = ".$item_id." LIMIT 1", 1))
		return $lang["quest_item"];
	else if(execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `npc_vendor` WHERE `item` = ".$item_id." LIMIT 1", 1))
		return $pvpreward ? $lang["pvp_reward"]." (".$lang["vendor"].")" : $lang["vendor"];
    else if(execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `npc_vendor_template` WHERE `item` = ".$item_id." LIMIT 1", 1))
        return $pvpreward ? $lang["pvp_reward"]." (".$lang["vendor"].")" : $lang["vendor"];
	else if($object = execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `gameobject_loot_template` WHERE `item` = ".$item_id." LIMIT 1", 2))
    {
        // check Boss Loot
        if ($instance_loot = execute_query("armory", "SELECT SQL_NO_CACHE * FROM `armory_instance_data` WHERE `id`=".$object." OR `lootid_1`=".$object." OR `lootid_2`=".$object." OR `lootid_3`=".$object." OR `lootid_4`=".$object." OR `name_id`=".$object." AND `type` = 'object' LIMIT 1", 1))
        {
            $instanceId = $instance_loot["instance_id"];
            $bossname = $instance_loot["name_en_gb"];
            $instance_info = execute_query("armory", "SELECT SQL_NO_CACHE * FROM `armory_instance_template` WHERE `id`=".$instanceId." LIMIT 1", 1);
            if ($instance_info)
            {
                $instance_name = $instance_info["name_en_gb"];
                $heroic = $instance_info["is_heroic"];
                $instance_size = $instance_info["partySize"];
                $expansion = $instance_info["expansion"];
                $israid = $instance_info["raid"];
                if ($expansion < 2 || !$israid)
                    return $bossname . " -" . $instance_name . "";
                //return $instance_name;
                return $bossname . " - " . $instance_name . ($heroic ? " (H)" : "");
            }
        }
        return $lang["chest_drop"];
    }
	else if($creature = execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `creature_loot_template` WHERE `item` = ".$item_id." LIMIT 1", 2))
    {
        // check Boss Loot
        if ($instance_loot = execute_query("armory", "SELECT SQL_NO_CACHE * FROM `armory_instance_data` WHERE `id`=".$creature." OR `lootid_1`=".$creature." OR `lootid_2`=".$creature." OR `lootid_3`=".$creature." OR `lootid_4`=".$creature." OR `name_id`=".$creature." AND `type` = 'npc' LIMIT 1", 1))
        {
            $instanceId = $instance_loot["instance_id"];
            $bossname = $instance_loot["name_en_gb"];
            $instance_info = execute_query("armory", "SELECT SQL_NO_CACHE * FROM `armory_instance_template` WHERE `id`=".$instanceId." LIMIT 1", 1);
            if ($instance_info)
            {
                $instance_name = $instance_info["name_en_gb"];
                $heroic = $instance_info["is_heroic"];
                $instance_size = $instance_info["partySize"];
                $expansion = $instance_info["expansion"];
                $israid = $instance_info["raid"];
                if ($expansion < 2 || !$israid)
                    return $bossname . " - " . $instance_name . "";
                //return $instance_name;
                return $bossname . " - " . $instance_name . ($heroic ? " (H)" : "". "");
            }
        }
//        else if ($creature_name = execute_query("world", "SELECT `Name` FROM `creature_template` WHERE `entry`=".$creature))
//        {
//            if (count($creature_name) == 1)
//                return $creature_name[0]["Name"];
//        }
        return $lang["drop"];
    }
    else if($refLoot = execute_query("world", "SELECT SQL_NO_CACHE `entry`, `groupid` FROM `reference_loot_template` WHERE `item` = ".$item_id))
    {
        $refLootList = execute_query("world", "SELECT COUNT(*) SQL_NO_CACHE FROM `reference_loot_template` WHERE `entry` = ".$refLoot[0]["entry"]." AND `groupid` = ".$refLoot[0]["groupid"], 2);
        $dropChance = round(100 / $refLootList);
        if (count($refLoot) > 1)
        {
            return "World Drop " . ($dropChance ? " <span class='tooltipContentSpecial'>".$lang["textDropRate"]." <span class='myWhite'>".PrintItemDropChance($dropChance)."</span></span>": "");
        }
        $bossId = execute_query("world", "SELECT SQL_NO_CACHE `entry` FROM `creature_loot_template` WHERE `mincountOrRef` = -".$refLoot[0]["entry"]);
        if ($bossId && (count($bossId) == 1 || count($bossId) == 2))
        {
            $creature = $bossId[0]["entry"];
            if ($instance_loot = execute_query("armory", "SELECT SQL_NO_CACHE * FROM `armory_instance_data` WHERE `id`=".$creature." OR `lootid_1`=".$creature." OR `lootid_2`=".$creature." OR `lootid_3`=".$creature." OR `lootid_4`=".$creature." OR `name_id`=".$creature." AND `type` = 'npc' LIMIT 1", 1))
            {
                $instanceId = $instance_loot["instance_id"];
                $bossname = $instance_loot["name_en_gb"];
                $instance_info = execute_query("armory", "SELECT SQL_NO_CACHE * FROM `armory_instance_template` WHERE `id`=".$instanceId." LIMIT 1", 1);
                if ($instance_info)
                {
                    $instance_name = $instance_info["name_en_gb"];
                    $heroic = $instance_info["is_heroic"];
                    $instance_size = $instance_info["partySize"];
                    $expansion = $instance_info["expansion"];
                    $israid = $instance_info["raid"];
                    if ($expansion < 2 || !$israid)
                        return /*"bossID: " . $creature . ", refId:" . $refLoot["entry"] . " " . */$bossname . " - " . $instance_name . ($dropChance ? " <span id ='dropRate' class='tooltipContentSpecial'>".$lang["textDropRate"]." <span class='myWhite'>".PrintItemDropChance($dropChance)."</span></span>": "");
                    //return $instance_name;
                    return $bossname . " - " . $instance_name . ($heroic ? " (H)" : "") . ($dropChance ? " <span id ='dropRate' class='tooltipContentSpecial'>".$lang["textDropRate"]." <span class='myWhite'>".PrintItemDropChance($dropChance)."</span></span>": "");
                }
            }
            else if ($creature_name = execute_query("world", "SELECT `Name` FROM `creature_template` WHERE `entry`=".$creature, 2))
            {
                return $creature_name;
            }
        }
        else if ($bossId && count($bossId) > 2)
        {
            return "World Drop " . ($dropChance ? " <span class='tooltipContentSpecial'>".$lang["textDropRate"]." <span class='myWhite'>".PrintItemDropChance($dropChance)."</span></span>": "");
        }
        // TODO CHEST NAMES
        else
            return "World Drop " . ($dropChance ? " <span class='tooltipContentSpecial'>".$lang["textDropRate"]." <span class='myWhite'>".PrintItemDropChance($dropChance)."</span></span>": "");
    }
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
	global $realms, $realmd_DB, $mangosd_DB, $characters_DB, $armory_DB, $playerbot_DB, $DB, $WSDB, $CHDB, $ARDB, $PBDB;
	//if(isset($_SESSION["realm"]))
	//	define("REALM_NAME", $_SESSION["realm"]);
	if(isset($_GET["realm"]) && isset($realms[$realm_name = stripslashes($_GET["realm"])]))
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

    unset($needed_db);
    $needed_db = $playerbot_DB[$realms[REALM_NAME][4]];
    $PBDB = dbsimple_Generic::connect( "mysql://" . $needed_db[1] .
        ":" . $needed_db[2] . "@" . $needed_db[0] .
        "/" . $needed_db[3] . "" ) ;
    if ( $PBDB )
        $PBDB->setErrorHandler( 'databaseErrorHandler' ) ;
    if ( $PBDB )
        $PBDB->query( "SET NAMES UTF8;" ) ;

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

function GetCreatureInfo($data)
{
    $stat = array();
    $stat["name"] = $data["Name"];
    $stat["level"] = $data["MinLevel"];
    $stat["model1"] = $data["DisplayId1"];
    $stat["model2"] = $data["DisplayId2"];
    $stat["model3"] = $data["DisplayId3"];
    $stat["model4"] = $data["DisplayId4"];
    $stat["subname"] = $data["SubName"];
    $stat["equip_template"] = $data["EquipmentTemplateId"];

    for ($i = 1; $i < 5; $i++) {
        $model_info = array();

        //echo $i;
        //echo $stat["model".$i];
        $model_extra_id = execute_query("armory", "SELECT `ExtendedDisplayInfoID` FROM `dbc_creaturedisplayinfo` WHERE `ID`=".$stat["model".$i]." LIMIT 1", 2);
        if ($model_extra_id)
        {
            $model_info_raw = execute_query("armory", "SELECT * FROM `dbc_creaturedisplayinfoextra` WHERE `ID`=".$model_extra_id." LIMIT 1", 1);
            if ($model_info_raw)
            {
                //echo $stat["model1"];
                //echo " ";
                //echo $model_extra_id;
                //print_r($model_info_raw);
                for ($j = 1; $j < 11; $j++) {
                    if (!CLIENT)
                    {
                        if ($j == 10)
                            $model_info["item" . $j] = $model_info_raw["Flags"];
                        else
                            $model_info["item" . $j] = $model_info_raw["NPCItemDisplayID_" . $j];
                    }
                    else
                    {
                        if ($j == 1)
                            $model_info["item" . $j] = $model_info_raw["FacialHairID"];
                        else
                            $model_info["item" . $j] = $model_info_raw["Equipment_" . ($j - 1)];
                    }
                    $model_info["icon".$j] = GetIcon("item", $model_info["item".$j]);
                    $possible_items = execute_query("world", "SELECT `entry` FROM `item_template` WHERE `displayid`=".$model_info["item".$j], 0);

                    $items_with_display = array();
                    if ($possible_items)
                    {
                        foreach ($possible_items as $item)
                        {
                            $items_with_display[] = $item["entry"];
                        }
                    }
                    $model_info["items_with_display"][$j] = $items_with_display;

                    // display IDs with same texture
                    $itemDisplayInfo = execute_query("armory", "SELECT * FROM `dbc_itemdisplayinfo_full` WHERE `ID`=".$model_info["item".$j]." LIMIT 1", 1);
                    if ($itemDisplayInfo)
                    {
                        $item_display = array();
                        $item_display["model_name1"] = $itemDisplayInfo["ModelName1"];
                        $item_display["model_name2"] = $itemDisplayInfo["ModelName2"];
                        $item_display["model_texture1"] = $itemDisplayInfo["ModelTexture1"];
                        $item_display["model_texture2"] = $itemDisplayInfo["ModelTexture2"];
                        for ($k = 1; $k < 9; $k++) {
                            $item_display["texture".$k] = $itemDisplayInfo["Texture".$k];
                        }

                        $should_search = !empty($item_display["model_name1"]) || !empty($item_display["model_name2"]) || !empty($item_display["model_texture1"]) || !empty($item_display["model_texture2"]);
                        if (!$should_search) {
                            for ($k = 1; $k < 9; $k++) {
                                if (!empty($item_display["texture".$k]))
                                    $should_search = true;
                            }
                        }

                        $search_same = execute_query("armory", "SELECT `ID` FROM `dbc_itemdisplayinfo_full` WHERE `ID` <> ".$model_info["item".$j]." AND `ModelName1`='".$item_display["model_name1"]."' AND `ModelName2`='".$item_display["model_name2"]."' AND `ModelTexture1`='".$item_display["model_texture1"]."' AND `ModelTexture2`='".$item_display["model_texture2"]."' AND `Texture7` = '".$item_display["texture7"]."' AND `Texture8` = '".$item_display["texture8"]."'AND `Texture1` = '".$item_display["texture1"]."' AND `Texture2` = '".$item_display["texture2"]."' AND `Texture3` = '".$item_display["texture3"]."' AND `Texture4` = '".$item_display["texture4"]."' AND `Texture5` = '".$item_display["texture5"]."' AND `Texture6` = '".$item_display["texture6"]."'", 0);
                        if ($should_search && $search_same)
                        {
                            $same_display_ids = array();
//                            echo "</br> Same Display IDs found as ";
//                            echo $model_info["item".$j];
//                            echo " :";
//                            echo sizeof($search_same);
//                            echo "</br> ";
                            foreach ($search_same as $item)
                            {
//                                echo " ";
//                                echo $item["ID"];
                                $same_display_ids[] = $item["ID"];
                            }
                            $model_info["same_display_ids"][$j] = $same_display_ids;
                        }
                    }
                }
            }
            else
            {
                for ($j = 1; $j < 10; $j++) {
                    $model_info["item".$j] = 0;
                    $model_info["icon".$j] = GetIcon("item", 0);
                }
            }
        }
        else
        {
            for ($j = 1; $j < 10; $j++) {
                $model_info["item".$j] = 0;
                $model_info["icon".$j] = GetIcon("item", 0);
            }
        }

        $stat["model".$i."_info"] = $model_info;
    }

    if ($stat["equip_template"])
    {
        $equip_data = execute_query("world", "SELECT * FROM `creature_equip_template` WHERE `entry`=".$stat["equip_template"], 1);
        if ($equip_data)
        {
            $stat["equip1"] = $equip_data["equipentry1"];
            $stat["equip2"] = $equip_data["equipentry2"];
            $stat["equip3"] = $equip_data["equipentry3"];

            if ($stat["equip1"]) $stat["equip1_display"] = execute_query("world", "SELECT `displayid` FROM `item_template` WHERE `entry`=".$stat["equip1"], 2);
            if ($stat["equip2"]) $stat["equip2_display"] = execute_query("world", "SELECT `displayid` FROM `item_template` WHERE `entry`=".$stat["equip2"], 2);
            if ($stat["equip3"]) $stat["equip3_display"] = execute_query("world", "SELECT `displayid` FROM `item_template` WHERE `entry`=".$stat["equip3"], 2);

            if ($stat["equip1_display"]) $stat["equip1_icon"] = GetIcon("item", $stat["equip1_display"]);
            if ($stat["equip2_display"]) $stat["equip2_icon"] = GetIcon("item", $stat["equip2_display"]);
            if ($stat["equip3_display"]) $stat["equip3_icon"] = GetIcon("item", $stat["equip3_display"]);
        }
    }

    return $stat;
}

function GetCreatureItemSlotName($slotId)
{
    switch ($slotId)
    {
        case 1: return "Head";
        case 2: return "Shoulders";
        case 3: return "Body";
        case 4: return "Chest";
        case 5: return "Waist";
        case 6: return "Legs";
        case 7: return "Feet";
        case 8: return "Wrist";
        case 9: return "Hands";
        case 10: return "Tabard";
        default: return "Unk";
    }
}
?>