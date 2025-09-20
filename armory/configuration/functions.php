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
	global $realms, $realmd_DB, $mangosd_DB, $characters_DB, $armory_DB, $DB, $WSDB, $CHDB, $ARDB, $PBDB;
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

/* -------------------- tooltip builder -------------------- */
// Build a clean tooltip description for one spell row

function build_tooltip_desc(array $sp): string {
    $desc = (string)($sp['description'] ?? '');

    $trimNum = static function($v): string {
        $s = number_format((float)$v, 1, '.', '');
        $s = rtrim(rtrim($s, '0'), '.');
        return ($s === '') ? '0' : $s;
    };

    $rangeText = static function(int $min, int $max): string {
        return ($max > $min) ? ($min . ' to ' . $max) : (string)$min; // en dash
    };

// Produces min/max/text for $sN.  If $div==1000 and bp<0, treat as negative ms.
    $formatS = static function (int $bp, int $dieSides, int $div = 1): array {
        // Special case: cast-time reductions stored as negative milliseconds
        if ($div === 1000 && $bp < 0) {
            $min = abs($bp) / 1000.0;
            $max = $min + ($dieSides > 0 ? $dieSides / 1000.0 : 0.0);
            // collapse if no range
            $txt = ($max > $min) ? rtrim(rtrim(number_format($min,1,'.',''), '0'),'.')
                .' to '.
                rtrim(rtrim(number_format($max,1,'.',''), '0'),'.')
                : rtrim(rtrim(number_format($min,1,'.',''), '0'),'.');
            return [$min, $max, $txt];
        }

        // Normal scalar (damage/heal/etc.)
        $min = $bp + 1;
        if ($dieSides <= 1) {
            $txt = (string)abs($min);
            return [$min, $min, $txt];
        }
        $max = $bp + $dieSides;
        if ($max < $min) { [$min, $max] = [$max, $min]; }
        return [$min, $max, $min . ' to ' . $max];
    };

    // $/1000;12345S1 → "0.5 sec", "1 sec", etc
    $desc = preg_replace_callback('/\$\s*\/1000;(\d+)S1\b/', function($m) {
        $sid = (int)$m[1];
        $row = get_spell_row($sid);
        if (!$row) return '0 sec';
        $bp = (int)($row['effect_basepoints_1'] ?? 0);
        $val = abs($bp + 1) / 1000.0;
        // format like Blizzard: trim .0, always "sec"
        $s = number_format($val, 1, '.', '');
        $s = rtrim(rtrim($s, '0'), '.');
        return $s . ' sec';
    }, $desc);

    // $12345sN
    $desc = preg_replace_callback('/\$(\d+)s([1-3])/', function ($m) use ($formatS) {
        $sid = (int)$m[1]; $idx = (int)$m[2];
        $row = _cache("spell:$sid", function() use ($sid){ return get_spell_row($sid); });
        if (!$row) return '0';
        $bp  = (int)($row["effect_basepoints_{$idx}"] ?? 0);
        $die = _cache("die:$sid:$idx", function() use ($sid,$idx){ return get_die_sides_n($sid,$idx); });
        [, , $text] = $formatS($bp, $die);
        return $text;
    }, $desc);

    // $12345d
    $desc = preg_replace_callback('/\$(\d+)d\b/', function ($m) {
        $sid   = (int)$m[1];
        $durId = _cache("durid:$sid", function() use ($sid){ return get_spell_duration_id($sid); });
        $secs  = _cache("dursec:$durId", function() use ($durId){ return duration_secs_from_id($durId); });
        return fmt_secs($secs);
    }, $desc);

    // $12345a1
    $desc = preg_replace_callback('/\$(\d+)a1\b/', function ($m) {
        $sid = (int)$m[1];
        $row = _cache("spell:$sid", function() use ($sid){ return get_spell_row($sid); });
        if (!$row) return '0';
        $val = _cache("radiusYds:$sid", function() use ($row){ return getRadiusYdsForSpellRow($row); });
        $s = number_format((float)$val, 1, '.', '');
        $s = rtrim(rtrim($s, '0'), '.');
        return ($s === '') ? '0' : $s;
    }, $desc);

    // $12345oN
    $desc = preg_replace_callback('/\$(\d+)o([1-3])\b/', function ($m) {
        $sid = (int)$m[1]; $idx = (int)$m[2];
        $row = _cache("spellO:$sid", function() use ($sid){ return get_spell_o_row($sid); });
        if (!$row) return '0';
        $bp   = abs((int)($row["effect_basepoints_{$idx}"] ?? 0) + 1);
        $amp  = (int)($row["effect_amplitude_{$idx}"] ?? 0);
        $dsec = _cache("dursecBySpell:$sid", function() use ($row){
            return duration_secs_from_id((int)($row['ref_spellduration'] ?? 0));
        });
        $ticks = ($amp > 0) ? (int)floor(($dsec * 1000) / $amp) : 0;
        return (string)($ticks > 0 ? $bp * $ticks : $bp);
    }, $desc);

    // $12345tN
    $desc = preg_replace_callback('/\$(\d+)t([1-3])\b/', function ($m) {
        $sid = (int)$m[1]; $idx = (int)$m[2];
        $row = _cache("spellO:$sid", function() use ($sid){ return get_spell_o_row($sid); });
        if (!$row) return '0';
        $amp = (int)($row["effect_amplitude_{$idx}"] ?? 0);
        $sec = $amp > 0 ? ($amp / 1000.0) : 0.0;
        $s = number_format($sec, 1, '.', '');
        return rtrim(rtrim($s, '0'), '.') ?: '0';
    }, $desc);


    // $12345u  (max stacks from another spell id; common fallback via S1+1)
    $desc = preg_replace_callback('/\$(\d+)u\b/', function ($m) {
        $sid = (int)$m[1];

        // prefer explicit stack column if present
        $n = _stack_amount_for_spell($sid);

        // fallback: some DBs encode as S1 (+1)
        if ($n <= 0) {
            $row = _cache("spell:$sid", function() use ($sid){ return get_spell_row($sid); });
            if ($row) {
                $bp = (int)($row['effect_basepoints_1'] ?? 0);
                $n  = abs($bp + 1);
            }
        }

        if ($n < 1) $n = 1;
        return (string)$n;
    }, $desc);


    // $12345n  (proc charges of another spell id; smart fallbacks)
    $desc = preg_replace_callback('/\$(\d+)n\b/', function ($m) {
        $sid = (int)$m[1];

        // main source: proc_charges (cached)
        $n = _cache("procchg:$sid", function() use ($sid) {
            return get_spell_proc_charges($sid);
        });

        // fallback 1: some auras encode "stacks up to N"
        if ($n <= 0) $n = _stack_amount_for_spell($sid);

        // fallback 2: a few tooltips store N as S1 (+1)
        if ($n <= 0) {
            $row = _cache("spell:$sid", function() use ($sid) {
                return get_spell_row($sid);
            });
            if ($row) {
                $bp = (int)($row['effect_basepoints_1'] ?? 0);
                $n  = abs($bp + 1);
            }
        }

        $n = (int)$n;
        if ($n < 1) $n = 1;
        return (string)$n;
    }, $desc);

    // $12345xN (total chain targets from another spell's EffectN)
    $desc = preg_replace_callback('/\$(\d+)x([1-3])\b/', function($m){
        $sid = (int)$m[1]; $i = (int)$m[2];
        $row = execute_query('armory',
            "SELECT `effect_chaintarget_{$i}` AS x FROM `dbc_spell` WHERE `id`={$sid} LIMIT 1", 1);
        $val = $row ? (int)$row['x'] : 0;
        if ($val <= 0) $val = 1;
        return (string)$val;
    }, $desc);

    /* ${$*K;sN%}  →  (K * sNmin)%   e.g., ${$*5;s1%} -> 5 * $s1 = 15% */
    $desc = preg_replace_callback(
        '/\{\$\s*\*\s*([0-9]+)\s*;\s*\$s([1-3])\s*%\s*\}/i',
        function($m) use ($s1min,$s2min,$s3min){
            $k   = (int)$m[1];
            $idx = (int)$m[2];
            $map = array(1=>$s1min, 2=>$s2min, 3=>$s3min);
            $base = isset($map[$idx]) ? abs($map[$idx]) : 0;
            $val  = $k * $base;
            return (string)$val . '%';
        },
        $desc
    );



    // ---- Current spell values
    $currId = isset($sp['id']) ? (int)$sp['id'] : 0;

    $die1 = _cache("die:$currId:1", function() use ($currId){ return $currId?get_die_sides_n($currId,1):0; });
    $die2 = _cache("die:$currId:2", function() use ($currId){ return $currId?get_die_sides_n($currId,2):0; });
    $die3 = _cache("die:$currId:3", function() use ($currId){ return $currId?get_die_sides_n($currId,3):0; });

    $formatSLocal = $formatS;
    list($s1min,$s1max,$s1txt) = $formatSLocal((int)($sp['effect_basepoints_1'] ?? 0), $die1);
    list($s2min,$s2max,$s2txt) = $formatSLocal((int)($sp['effect_basepoints_2'] ?? 0), $die2);
    list($s3min,$s3max,$s3txt) = $formatSLocal((int)($sp['effect_basepoints_3'] ?? 0), $die3);

    // $/N; $sN   or   $/N; $<id>sN   (also supports ...oN)
    $desc = preg_replace_callback(
        '/\$\s*\/\s*(\d+)\s*;\s*\$?(\d+)?(s|o)([1-3])/i',
        function ($m) use ($s1min, $s1max, $s2min, $s2max, $s3min, $s3max, $formatSLocal) {
            $div     = (float)$m[1];
            $spellId = $m[2] ? (int)$m[2] : 0;
            $type    = strtolower($m[3]);  // 's' or 'o'
            $idx     = (int)$m[4];

            // helper: trim like the rest of the tooltip numbers
            $fmt = static function ($v) {
                $s = number_format((float)$v, 1, '.', '');
                return rtrim(rtrim($s, '0'), '.') ?: '0';
            };

            if ($type === 's') {
                // ---- scalar-with-range path
                if ($spellId === 0) {
                    // current spell's sN (we already have min/max)
                    $mapMin = [1 => $s1min, 2 => $s2min, 3 => $s3min];
                    $mapMax = [1 => $s1max, 2 => $s2max, 3 => $s3max];
                    $min = abs((float)($mapMin[$idx] ?? 0.0));
                    $max = abs((float)($mapMax[$idx] ?? $min));
                } else {
                    // external spell: compute sN min/max via formatSLocal
                    $row = _cache("spell:$spellId", function () use ($spellId) { return get_spell_row($spellId); });
                    if (!$row) return '0';
                    $bp  = (int)($row["effect_basepoints_{$idx}"] ?? 0);
                    $die = _cache("die:$spellId:$idx", function () use ($spellId, $idx) { return get_die_sides_n($spellId, $idx); });
                    list($min, $max) = $formatSLocal($bp, $die);
                }

                if ($div > 0) { $min /= $div; $max /= $div; }

                if ($max > $min) {
                    // Blizzard-style rounding for ranges:
                    // - lower bound rounds down
                    // - upper bound rounds up
                    $lo = (int)floor($min);
                    $hi = (int)ceil($max);
                    return $lo . ' to ' . $hi;
                }

// single number (no range): keep normal formatting (e.g., 0.5 sec)
                return $fmt($min);

            }

            // ---- over-time totals (oN) are scalars: just divide
            if ($spellId === 0) {
                $map = [1 => $s1min, 2 => $s2min, 3 => $s3min]; // keep as fallback
                $val = abs((float)($map[$idx] ?? 0.0));
            } else {
                $row = _cache("spellO:$spellId", function () use ($spellId) { return get_spell_o_row($spellId); });
                if (!$row) return '0';
                $bp    = abs((int)($row["effect_basepoints_{$idx}"] ?? 0) + 1);
                $amp   = (int)($row["effect_amplitude_{$idx}"] ?? 0);
                $dur   = duration_secs_from_id((int)($row['ref_spellduration'] ?? 0));
                $ticks = ($amp > 0) ? (int)floor(($dur * 1000) / $amp) : 0;
                $val   = $ticks > 0 ? $bp * $ticks : $bp;
            }
            if ($div > 0) $val /= $div;
            return $fmt($val);
        },
        $desc
    );



    /* -------- Duration / totals for current spell (forward + reverse trigger hops) -------- */
    $getDurSecBySpellId = function($sid){
        if ($sid <= 0) return 0;
        $durId = _cache("durid:$sid", function() use ($sid){ return get_spell_duration_id($sid); });
        return _cache("dursec:$durId", function() use ($durId){ return duration_secs_from_id($durId); });
    };

    $currId  = isset($sp['id']) ? (int)$sp['id'] : 0;
    $durSecs = $getDurSecBySpellId($currId);

// Evaluate ${$d-1} sec  → "<durSecs - 1> sec"
    $desc = preg_replace_callback(
        '/\$\{\s*\$d\s*([+-])\s*(\d+)\s*\}\s*sec\b/i',
        function ($m) use ($durSecs) {
            $delta = (int)$m[2];
            $v = $durSecs + ($m[1] === '-' ? -$delta : $delta);
            if ($v < 0) $v = 0;
            return $v . ' sec';
        },
        $desc
    );

// Also support ${$d-1} (without trailing " sec")
    $desc = preg_replace_callback(
        '/\$\{\s*\$d\s*([+-])\s*(\d+)\s*\}/i',
        function ($m) use ($durSecs) {
            $delta = (int)$m[2];
            $v = $durSecs + ($m[1] === '-' ? -$delta : $delta);
            if ($v < 0) $v = 0;
            return (string)$v;
        },
        $desc
    );


    if (strpos($desc, '$d') !== false) {
        /* ---- forward: follow children triggered by this spell ---- */
        $seen  = array();
        $queue = array($currId);
        $depth = 0;

        while (!empty($queue) && $depth < 2) {
            $next = array();
            foreach ($queue as $sid) {
                if ($sid <= 0 || isset($seen[$sid])) continue;
                $seen[$sid] = true;

                $ds = $getDurSecBySpellId($sid);
                if ($ds > $durSecs) $durSecs = $ds;

                // effect_trigger_* family (or effect_trigger_spell_* if that’s what the DBC has)
                $base = _trigger_col_base();
                $col1 = $base.'1'; $col2 = $base.'2'; $col3 = $base.'3';
                $row = execute_query('armory',
                    "SELECT `$col1` AS t1, `$col2` AS t2, `$col3` AS t3
           FROM `dbc_spell` WHERE `id`=".(int)$sid." LIMIT 1", 1);

                if ($row) {
                    for ($i = 1; $i <= 3; $i++) {
                        $tid = isset($row["t{$i}"]) ? (int)$row["t{$i}"] : 0;
                        if ($tid > 0 && !isset($seen[$tid])) $next[] = $tid;
                    }
                }
            }
            $queue = $next;
            $depth++;
        }

        /* ---- reverse: if still suspiciously short (<=2 sec), find parents that trigger THIS spell ---- */
        if ($durSecs <= 2) {
            $base = _trigger_col_base();
            $col1 = $base.'1'; $col2 = $base.'2'; $col3 = $base.'3';

            $parents = execute_query(
                'armory',
                "SELECT `id` FROM `dbc_spell`
         WHERE `$col1`=".(int)$currId."
            OR `$col2`=".(int)$currId."
            OR `$col3`=".(int)$currId."
         LIMIT 20",
                0
            );

            if (is_array($parents)) {
                foreach ($parents as $pr) {
                    $pid = (int)$pr['id'];
                    $pds = $getDurSecBySpellId($pid);
                    if ($pds > $durSecs) $durSecs = $pds;
                }
            }
        }
    }

    $durMs = $durSecs * 1000;
    $d     = fmt_secs($durSecs);

    $o1 = (function() use ($sp, $durMs) {
        $bp  = abs((int)($sp['effect_basepoints_1'] ?? 0) + 1);
        $amp = (int)($sp['effect_amplitude_1'] ?? 0);
        $ticks = ($amp > 0) ? (int)floor($durMs / $amp) : 0;
        return (string)($ticks > 0 ? $bp * $ticks : $bp);
    })();
    $o2 = (function() use ($sp, $durMs) {
        $bp  = abs((int)($sp['effect_basepoints_2'] ?? 0) + 1);
        $amp = (int)($sp['effect_amplitude_2'] ?? 0);
        $ticks = ($amp > 0) ? (int)floor($durMs / $amp) : 0;
        return (string)($ticks > 0 ? $bp * $ticks : $bp);
    })();
    $o3 = (function() use ($sp, $durMs) {
        $bp  = abs((int)($sp['effect_basepoints_3'] ?? 0) + 1);
        $amp = (int)($sp['effect_amplitude_3'] ?? 0);
        $ticks = ($amp > 0) ? (int)floor($durMs / $amp) : 0;
        return (string)($ticks > 0 ? $bp * $ticks : $bp);
    })();

    // headline value
    $h  = (int)($sp['proc_chance'] ?? 0);
    if ($h <= 0) $h = $s1min;

    // radius & tick times
    $a1 = $trimNum(getRadiusYdsForSpellRow($sp));
    $t1 = $trimNum(((int)($sp['effect_amplitude_1'] ?? 0)) / 1000.0);
    $t2 = $trimNum(((int)($sp['effect_amplitude_2'] ?? 0)) / 1000.0);
    $t3 = $trimNum(((int)($sp['effect_amplitude_3'] ?? 0)) / 1000.0);


// ${AP*$mN/100} → "(Attack Power * N / 100)"
    $desc = preg_replace_callback(
        '/\{\$\s*(AP|RAP|SP)\s*\*\s*\$m([1-3])\s*\/\s*100\s*\}/i',
        function ($m) use ($s1min, $s2min, $s3min) {
            $idx  = (int)$m[2];
            $map  = [1 => $s1min, 2 => $s2min, 3 => $s3min];
            $pct  = (int)abs($map[$idx] ?? 0);
            $stat = strtoupper($m[1]); // AP, RAP, SP
            $labels = [
                'AP'  => 'Attack Power',
                'RAP' => 'Ranged Attack Power',
                'SP'  => 'Spell Power',
            ];
            $label = $labels[$stat] ?? $stat;
            // return Blizzard-style formula
            return '(' . $label . ' * ' . $pct . ' / 100)';
        },
        $desc
    );



    // $m1/$m2/$m3
    $desc = preg_replace_callback('/\$(m[1-3])\b/', function($m) use ($s1min,$s2min,$s3min){
        switch ($m[1]) { case 'm1': return (string)$s1min; case 'm2': return (string)$s2min; case 'm3': return (string)$s3min; }
        return $m[0];
    }, $desc);

    // $n (proc charges) – fallback to cached lookup
    $procN = (int)($sp['proc_charges'] ?? 0);
    if ($procN <= 0 && isset($sp['id'])) $procN = (int)get_spell_proc_charges((int)$sp['id']);
    if ($procN > 0) $desc = preg_replace('/\$n\b/i', (string)$procN, $desc);

    // $xN  (total chain targets from current spell's EffectN)
    $desc = preg_replace_callback('/\$x([1-3])\b/', function($m) use ($sp){
        $i   = (int)$m[1];
        $val = (int)($sp["effect_chaintarget_{$i}"] ?? 0);
        if ($val <= 0) $val = 1; // safe fallback: at least 1 target
        return (string)$val;
    }, $desc);



// $u (max stacks for CURRENT spell)
    $u = 1;
    if (!empty($sp['id'])) {
        $u = _stack_amount_for_spell((int)$sp['id']); // prefer stack column
        if ($u <= 0) {
            // fallback: S1 (+1) pattern
            $bp = (int)($sp['effect_basepoints_1'] ?? 0);
            $u  = abs($bp + 1);
        }
        if ($u < 1) $u = 1;
    }

    /* ---------- Grammar: $l<singular>:<plural>; picks based on the number before it ---------- */
    while (preg_match('/\$l([^:;]+):([^;]+);/', $desc, $m, PREG_OFFSET_CAPTURE)) {
        $full     = $m[0][0];
        $offset   = $m[0][1];
        $singular = $m[1][0];
        $plural   = $m[2][0];

        // Look left of the token for the nearest number (already-substituted at this stage)
        $before = substr($desc, 0, $offset);
        $val = 2; // default to plural
        if (preg_match('/(\d+(?:\.\d+)?)(?!.*\d)/', $before, $nm)) {
            $val = (float)$nm[1];
        }

        $word = (abs($val - 1.0) < 0.000001) ? $singular : $plural;

        // Replace this one occurrence and continue (handles multiple $l…; tokens)
        $desc = substr($desc, 0, $offset) . $word . substr($desc, $offset + strlen($full));
    }
    /* ---------- $*<factor>;<token>  (multiply a numeric token) ---------- */
    /* supports s1..s3, o1..o3, m1..m3; extend map if you need more */
    $__mulMap = array(
        's1' => (float)$s1min, 's2' => (float)$s2min, 's3' => (float)$s3min,
        'o1' => (float)$o1,    'o2' => (float)$o2,    'o3' => (float)$o3,
        'm1' => (float)$s1min, 'm2' => (float)$s2min, 'm3' => (float)$s3min
    );

    $desc = preg_replace_callback('/\$\*\s*([0-9]+(?:\.[0-9]+)?)\s*;\s*(s[1-3]|o[1-3]|m[1-3])/i',
        function($m) use ($__mulMap) {
            $factor = (float)$m[1];
            $key    = strtolower($m[2]);
            $base   = isset($__mulMap[$key]) ? (float)$__mulMap[$key] : 0.0;
            $val    = $factor * $base;

            // format like the rest of the tooltips: trim trailing .0
            $s = number_format($val, 1, '.', '');
            $s = rtrim(rtrim($s, '0'), '.');
            return ($s === '') ? '0' : $s;
        },
        $desc);


    /* -------- ${min-max/divisor} style tokens -------- */
    $desc = preg_replace_callback('/\$\{([0-9]+)\s*-\s*([0-9]+)\/([0-9]+)\}/',
        function($m) use ($cur,$max) {
            $min = (int)$m[1];
            $maxVal = (int)$m[2];
            $div = (int)$m[3];
            if ($div <= 0) $div = 1;

            // linear scale based on current rank (1..max)
            $steps = max(1, $max-1);
            $progress = ($max > 1) ? ($cur-1)/$steps : 0;
            $val = $min + ($maxVal - $min) * $progress;
            $val = $val / $div;

            // clean formatting
            $s = number_format($val, 1, '.', '');
            $s = rtrim(rtrim($s, '0'), '.');
            return ($s === '') ? '0' : $s;
        }, $desc);


    /*  // Cleanup
     $desc = preg_replace('/\bby\s*[\-\x{2212}]\s*([0-9]+(?:\.[0-9]+)?)%/iu', 'by $1%', $desc);
     $desc = preg_replace('/\b(?:by\s*)?[\-\x{2212}]\s*([0-9]+(?:\.[0-9]+)?)\s*sec\b/iu', ' $1 sec', $desc); */

// Alias: $D should behave same as $d
    $desc = str_replace('$D', $d, $desc);

// Final substitution
    $desc = strtr($desc, [
        '$s1' => $s1txt, '$s2' => $s2txt, '$s3' => $s3txt,
        '$o1' => $o1,    '$o2' => $o2,    '$o3' => $o3,
        '$t1' => $t1,    '$t2' => $t2,    '$t3' => $t3,
        '$a1' => $a1,
        '$d'  => $d,
        '$h'  => (string)$h,
        '$u'  => (string)$u,
    ]);

// --- post substitutions cleanup ---

    $desc = preg_replace('/(\d+)1%/', '$1%', $desc);		  // collapse mistaken "601%" -> "60%"
    $desc = preg_replace('/\$\(/', '(', $desc);
    $desc = preg_replace('/\$\w*sec:secs;/', ' sec', $desc);  // "$lsec:secs;" -> " sec"
    $desc = preg_replace('/\s+%/', '%', $desc);               // tidy space before '%'

    return $desc;

}

/* ---- time helpers ---- */
function fmt_secs($sec) {
    $sec = (int)round($sec); // integer seconds

    // Auras/buffs with duration 0 in DBC
    if ($sec <= 0) return 'until cancelled';

    if ($sec < 60) return $sec . ' sec';

    $m = floor($sec / 60);
    $s = $sec % 60;

    return $s === 0 ? ($m . ' min') : ($m . ' min ' . $s . ' sec');
}

/* ---- memoized simple lookups ---- */
// note: static cache is per-request; safe for PHP-FPM
function _cache($key, callable $fn) {
    static $C = [];
    if (isset($C[$key])) return $C[$key];
    $C[$key] = $fn();
    return $C[$key];
}

function get_spell_row($id) {
    return _cache("spell:$id", function() use ($id) {
        return execute_query('armory',
            "SELECT `effect_basepoints_1`,`effect_basepoints_2`,`effect_basepoints_3`,`ref_spellradius_1`
       FROM `dbc_spell` WHERE `id`=".(int)$id." LIMIT 1", 1);
    });
}

function get_spell_o_row($id) {
    return _cache("spellO:$id", function() use ($id) {
        return execute_query('armory',
            "SELECT `ref_spellduration`,
              `effect_basepoints_1`,`effect_basepoints_2`,`effect_basepoints_3`,
              `effect_amplitude_1`,`effect_amplitude_2`,`effect_amplitude_3`
       FROM `dbc_spell` WHERE `id`=".(int)$id." LIMIT 1", 1);
    });
}

function get_spell_duration_id($id) {
    return _cache("durid:$id", function() use ($id) {
        $row = execute_query('armory',
            "SELECT `ref_spellduration` FROM `dbc_spell` WHERE `id`=".(int)$id." LIMIT 1", 1);
        return $row ? (int)$row['ref_spellduration'] : 0;
    });
}

function duration_secs_from_id($id) {
    if (!$id) return 0;
    $row = execute_query(
        'armory',
        "SELECT `durationValue` FROM `dbc_spellduration` WHERE `id`=".(int)$id." LIMIT 1",
        1
    );
    if (!$row) return 0;

    $ms = (int)$row['durationValue'];   // always ms in your DB
    return ($ms > 0) ? ($ms / 1000) : 0; // → return pure seconds as float
}

function get_radius_yds_by_id($rid) {
    return _cache("radius:$rid", function() use ($rid){
        $row = execute_query('armory',
            "SELECT `yards_base` FROM `dbc_spellradius` WHERE `id`=".(int)$rid." LIMIT 1", 1);
        return $row ? (float)$row['yards_base'] : 0.0;
    });
}

function get_die_sides_n(int $spellId, int $n): int {
    if ($n < 1 || $n > 3) return 0;
    if (!_has_die_sides_cols()) return 0;
    return _cache("die:$spellId:$n", function() use ($spellId,$n){
        $col = "effect_die_sides_{$n}";
        $row = execute_query('armory', "SELECT `$col` FROM `dbc_spell` WHERE `id`=".(int)$spellId." LIMIT 1", 1);
        return $row ? (int)$row[$col] : 0;
    });
}

function get_spell_proc_charges($id) {
    return _cache("procchg:$id", function() use ($id){
        $row = execute_query('armory',
            "SELECT `proc_charges` FROM `dbc_spell` WHERE `id`=".(int)$id." LIMIT 1", 1);
        return $row ? (int)$row['proc_charges'] : 0;
    });
}

/* cache whether effect_die_sides_* columns exist */
function _has_die_sides_cols(): bool {
    static $has = null;
    if ($has !== null) return $has;
    $rows = execute_query(
        'armory',
        "SELECT COLUMN_NAME
       FROM INFORMATION_SCHEMA.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME   = 'dbc_spell'
        AND COLUMN_NAME IN ('effect_die_sides_1','effect_die_sides_2','effect_die_sides_3')",
        0
    );
    $has = !empty($rows);
    return $has;
}

function get_spell_radius_id($id) {
    $row = execute_query(
        'armory',
        "SELECT `ref_spellradius_1` FROM `dbc_spell`
      WHERE `id` = " . (int)$id . " LIMIT 1",
        1
    );
    return $row ? (int)$row['ref_spellradius_1'] : 0;
}

function getRadiusYdsForSpellRow(array $sp) {
    $rid = (int)($sp['ref_spellradius_1'] ?? 0);
    if ($rid <= 0) return 0.0;
    return get_radius_yds_by_id($rid);
}

// pick the column name that exists for stacks
function _stack_col_name(): ?string {
    static $col = null, $checked = false;
    if ($checked) return $col;
    $checked = true;
    $row = execute_query(
        'armory',
        "SELECT COLUMN_NAME
       FROM INFORMATION_SCHEMA.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME   = 'dbc_spell'
        AND COLUMN_NAME IN ('stack_amount','StackAmount','max_stack','MaxStack') LIMIT 1",
        1
    );
    $col = $row ? $row['COLUMN_NAME'] : null;
    return $col;
}

function _stack_amount_for_spell(int $id): int {
    $col = _stack_col_name();
    if (!$col) return 0;
    $r = execute_query('armory', "SELECT `$col` AS st FROM `dbc_spell` WHERE `id`=".(int)$id." LIMIT 1", 1);
    return $r ? (int)$r['st'] : 0;
}

// Which trigger column family exists?  effect_trigger_*  or  effect_trigger_spell_* ?
function _trigger_col_base(){
    static $base = null, $checked = false;
    if ($checked) return $base;
    $checked = true;

    $row = execute_query(
        'armory',
        "SELECT COLUMN_NAME
       FROM INFORMATION_SCHEMA.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME   = 'dbc_spell'
        AND COLUMN_NAME IN ('effect_trigger_1','effect_trigger_spell_1')
      LIMIT 1",
        1
    );

    if ($row && isset($row['COLUMN_NAME'])) {
        $base = (strpos($row['COLUMN_NAME'], 'effect_trigger_spell_') === 0)
            ? 'effect_trigger_spell_'
            : 'effect_trigger_';
    } else {
        // safe default for classic/TBC DBCs
        $base = 'effect_trigger_';
    }
    return $base;
}
?>