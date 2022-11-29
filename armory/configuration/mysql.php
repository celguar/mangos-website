<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$realms = array(
// "Realm name" => array(realmd_DB, characters_DB, mangos_DB, armory_DB, playerbots_DB)
"Vanilla Realm" => array(1, 1, 1, 1, 1),
"Burning Crusade Realm" => array(2, 2, 2, 2, 2),
"Wrath of the Lich King" => array(3, 3, 3, 3, 3),
);
// Default Realm Name (use one chosen upper in $realms)
//define("DefaultRealmName", "Vanilla Realm");
if (file_exists("../vanilla.spp"))
{
    define("DefaultRealmName", "Vanilla Realm");
    unset($realms["Burning Crusade Realm"]);
    unset($realms["Wrath of the Lich King"]);
}
if (file_exists("../tbc.spp"))
{
    define("DefaultRealmName", "Burning Crusade Realm");
    unset($realms["Vanilla Realm"]);
    unset($realms["Wrath of the Lich King"]);
}
if (file_exists("../wotlk.spp"))
{
    define("DefaultRealmName", "Wrath of the Lich King");
    unset($realms["Burning Crusade Realm"]);
    unset($realms["Vanilla Realm"]);
}
$realmd_DB = array(
// Connection to realmd DBs
1 => array("127.0.0.1:3310", "root", "123456", "classicrealmd"),
2 => array("127.0.0.1:3310", "root", "123456", "tbcrealmd"),
3 => array("127.0.0.1:3310", "root", "123456", "wotlkrealmd"),
);
$characters_DB = array(
// Connection to characters DBs
1 => array("127.0.0.1:3310", "root", "123456", "classiccharacters"),
2 => array("127.0.0.1:3310", "root", "123456", "tbccharacters"),
3 => array("127.0.0.1:3310", "root", "123456", "wotlkcharacters"),
);
$mangosd_DB = array(
// Connection to mangos DBs
1 => array("127.0.0.1:3310", "root", "123456", "classicmangos"),
2 => array("127.0.0.1:3310", "root", "123456", "tbcmangos"),
3 => array("127.0.0.1:3310", "root", "123456", "wotlkmangos"),
);
$armory_DB = array(
// Connection to armory DBs
1 => array("127.0.0.1:3310", "root", "123456", "classicarmory"),
2 => array("127.0.0.1:3310", "root", "123456", "tbcarmory"),
3 => array("127.0.0.1:3310", "root", "123456", "wotlkarmory"),
);
$playerbot_DB = array(
// Connection to bots DBs
1 => array("127.0.0.1:3310", "root", "123456", "classicplayerbots"),
2 => array("127.0.0.1:3310", "root", "123456", "tbcplayerbots"),
3 => array("127.0.0.1:3310", "root", "123456", "wotlkplayerbots"),
);
/* Don't touch anything beyond this point. */
set_time_limit(0);
ini_set("default_charset", "UTF-8");
//set_magic_quotes_runtime(false);
function execute_query($db_name, $query, $method = 0, $error = "")
{
    global $DB, $WSDB, $CHDB, $ARDB, $PBDB;
    $query_result = false;
    if ($method == 0) // query (array of assoc arrays)
    {
        if ($db_name == "realm")
            $query_result = $DB->query($query);
        elseif ($db_name == "armory")
            $query_result = $ARDB->query($query);
        elseif($db_name == "char")
            $query_result = $CHDB->query($query);
        elseif($db_name == "world")
            $query_result = $WSDB->query($query);
        elseif($db_name == "bots")
            $query_result = $PBDB->query($query);
    }
    elseif ($method == 1) // row (single associated array)
    {
        if ($db_name == "realm")
            $query_result = $DB->selectRow($query);
        elseif ($db_name == "armory")
            $query_result = $ARDB->selectRow($query);
        elseif($db_name == "char")
            $query_result = $CHDB->selectRow($query);
        elseif($db_name == "world")
            $query_result = $WSDB->selectRow($query);
        elseif($db_name == "bots")
            $query_result = $PBDB->selectRow($query);
    }
    elseif ($method == 2) // cell (no array)
    {
        if ($db_name == "realm")
            $query_result = $DB->selectCell($query);
        elseif ($db_name == "armory")
            $query_result = $ARDB->selectCell($query);
        elseif($db_name == "char")
            $query_result = $CHDB->selectCell($query);
        elseif($db_name == "world")
            $query_result = $WSDB->selectCell($query);
        elseif($db_name == "bots")
            $query_result = $PBDB->selectCell($query);
    }
    if (!$db_name)
        die($error."Database not chosen");

	if($query_result)
		return $query_result;
	elseif (!$query_result && $error)
	{
		die($error);
        return false;
	}
    return false;
}
function switchConnection($db_type, $realm_name)
{
	global $realms, $realmd_DB, $characters_DB, $mangosd_DB, $armory_DB;
	switch($db_type)
	{
		case "realmd": $needed_db = $realmd_DB[$realms[$realm_name][0]]; break;
		case "characters": $needed_db = $characters_DB[$realms[$realm_name][1]]; break;
		case "mangos": $needed_db = $mangosd_DB[$realms[$realm_name][2]]; break;
		/* armory */default: $needed_db = $armory_DB[$realms[$realm_name][3]];
	}
	//mysql_connect($needed_db[0], $needed_db[1], $needed_db[2]) or die("Unable to connect to SQL host of ".$db_type." DB of realm ".$realm_name.": ".mysqli_error());
	//mysqli_select_db($needed_db[3]) or die("Unable to connect to ".$db_type." DB of realm ".$realm_name.": ".mysqli_error());
	//execute_query("SET NAMES 'utf8'");
}
?>