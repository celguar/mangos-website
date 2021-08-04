<?php
function test_realm($server, $port)
{
    $s = @fsockopen("$server", $port, $ERROR_NO, $ERROR_STR, (float)0.5);
    if ($s) {
        @fclose($s);
        return true;
    } else
        return false;
}
function check_online($db)
{
    foreach ($db as $realm) {
        if (test_realm($realm['server'], $realm['port'])) {
            $online = true;
        }
    }
    if ($online) {
        return $online;
    }
}

function change_db($db)
{
    //connection to server
    $mysql_link = mysql_connect($db['mysql_host'], $db['mysql_user'], $db['mysql_pass']) or
        die("Could not connect.");
    mysql_select_db($db['db'], $mysql_link) or die(mysql_error());
}
function check_if_name_exist($name, $db)
{
    change_db($db);
    $check_exist = "SELECT * FROM `characters` WHERE `name` LIKE '$name'";
    $check = mysql_query($check_exist) or die(mysql_error());
    if (mysql_num_rows($check) == 0) {
        return 0;
    }
    return 1;
}
function select_char($char_name, $db)
{
    change_db($db);
    $select_char = "SELECT `GUID` FROM `characters` WHERE `name` LIKE '$char_name'";
    $results = mysql_query($select_char) or die(mysql_error());
    $row = mysql_fetch_array($results);
    $char_guid = $row['GUID'];
    return $char_guid;
}
function move($char_guid, $fist_db, $second_db)
{
    include "tabs.php";
    change_db($second_db);
    foreach ($tab_characters as $value) {
        $move = "INSERT INTO $value[0] SELECT * FROM " . $fist_db['db'] . ".$value[0] WHERE $value[1] = $char_guid";
        mysql_query($move) or die(mysql_error());
    }
    $move = "INSERT INTO pet_spell SELECT * FROM" . $fist_db['db'] .
        ".pet_spell WHERE
	`guid` in (SELECT `id` FROM " . $fist_db['db'] .
        ".`character_pet` WHERE `owner`= $char_guid)";
    mysql_query($move);
    $move = "INSERT INTO item_text SELECT * FROM " . $fist_db['db'] .
        ".item_text WHERE
	`id` in (SELECT `itemTextId` FROM " . $fist_db['db'] .
        ".`mail` WHERE `receiver`= $char_guid)";
    mysql_query($move);
}
function cleanup($db)
{
    change_db($db);
    $clean = "DELETE FROM `mail_items` WHERE (mail_id ) NOT IN ( SELECT id FROM `mail` );";
    $results = mysql_query($clean) or die(mysql_error());
}
function select_max_guid($db, $table, $field)
{
    change_db($db);
    $select_max = "SELECT MAX($field) as max_guid FROM $table";
    $results = mysql_query($select_max) or die(mysql_error());
    $row = mysql_fetch_array($results);
    $max_guid = $row['max_guid'];
    return $max_guid;
}
function change_guid($db, $max_guid, $tab, $table, $field)
{
    include "tabs.php";
    change_db($db);
    $change_guid = "ALTER TABLE $table ADD `guid_temp` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    mysql_query($change_guid) or die(mysql_error());
    $change_guid = "ALTER TABLE $table ADD `guid_new` INT( 11 ) UNSIGNED NOT NULL FIRST";
    mysql_query($change_guid) or die(mysql_error());
    $change_guid = "UPDATE $table SET `guid_new` = `guid_temp`";
    mysql_query($change_guid) or die(mysql_error());
    $change_guid = "ALTER TABLE $table DROP `guid_temp`";
    mysql_query($change_guid) or die(mysql_error());
    if (!($max_guid > 0))
        $max_guid = 0;
    $change_guid = "UPDATE $table SET `guid_new` = `guid_new` + $max_guid";
    mysql_query($change_guid) or die(mysql_error());
    if (($table == 'characters') or ($table == 'item_instance')) {
        $change_guid = "UPDATE $table SET `data`=CONCAT(`guid_new`,' ',right(data,length(data)-length(substring_index(data,' ',1))-1));";
        mysql_query($change_guid) or die(mysql_error());
    }
    foreach ($tab as $value) {
        if (strcmp($value[0], 'characters') != 0) {
            $change_guid = "UPDATE $value[0], $table SET $value[0].$value[1] = $table.`guid_new` WHERE $value[0].$value[1] = $table.$field";
            mysql_query($change_guid) or die(mysql_error());
        }
    }
    if ($table == 'characters') {
        $change_guid = "UPDATE mail SET `sender` = `receiver`,`stationery` = '61'";
        mysql_query($change_guid) or die(mysql_error());
    }
    $change_guid = "ALTER TABLE $table DROP $field";
    mysql_query($change_guid) or die(mysql_error());
    $change_guid = "ALTER TABLE $table CHANGE `guid_new` $field INT( 11 ) UNSIGNED NOT NULL default '0'";
    mysql_query($change_guid) or die(mysql_error());
}
function truncate_db($db)
{
    include "tabs.php";
    change_db($db);
    foreach ($tab_characters as $value) {
        $truncate = "TRUNCATE $value[0]";
        mysql_query($truncate);
    }
    $truncate = "TRUNCATE pet_spell";
    mysql_query($truncate);
    $truncate = "TRUNCATE item_text";
    mysql_query($truncate);
}
function del_char($char_guid, $db)
{
    change_db($db);
    $delete_char = "DELETE FROM `characters` WHERE `guid`=$char_guid";
    mysql_query($delete_char) or die(mysql_error());
}
function clean_after_delete($db)
{
    change_db($db);
    set_time_limit(200);
    $file = fopen("clean_after_delete.sql", 'r');
    while (!feof($file)) {
        $getquery = trim(fgets($file));
        $clean = "$getquery";
        mysql_query($clean);
    }
}
?>