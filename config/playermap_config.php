<?php

// Player map configuration
$db_type          = 'MySQL';

$realm_db['addr']     = '127.0.0.1:3306';         // SQL server IP:port this realmd located on
$realm_db['user']     = 'root';                   // SQL server login this realmd located on
$realm_db['pass']     = 'ascent';                      // SQL server pass this realmd located on
$realm_db['name']     = 'realmd';                 // realmd DB name
$realm_db['encoding'] = 'utf8';                   // SQL connection encoding

//==== For each realm, you must have $world_db and $characters_db and $server filled in, label each with the realm id: ex: $world_db[REALMID]['addr'] === //

// position in array must represent realmd ID
$world_db[1]['addr']          = '127.0.0.1:3306'; // SQL server IP:port this DB located on
$world_db[1]['user']          = 'root';           // SQL server login this DB located on
$world_db[1]['pass']          = 'ascent';              // SQL server pass this DB located on
$world_db[1]['name']          = 'world';         // World Database name, by default "mangos" for MaNGOS, "world" for Trinity
$world_db[1]['encoding']      = 'utf8';           // SQL connection encoding

// position in array must represent realmd ID
$characters_db[1]['addr']     = '127.0.0.1:3306'; // SQL server IP:port this DB located on
$characters_db[1]['user']     = 'root';           // SQL server login this DB located on
$characters_db[1]['pass']     = 'ascent';              // SQL server pass this DB located on
$characters_db[1]['name']     = 'characters';     // Character Database name
$characters_db[1]['encoding'] = 'utf8';           // SQL connection encoding

//---- Game Server Configuration ----

$server_type        =  1;           // 0=MaNGOS, 1=Trinity

// position in array must represent realmd ID, same as in $world_db
$server[1]['addr']          = '127.0.0.1'; // Game Server IP, as seen by MiniManager, from your webhost
$server[1]['addr_wan']      = '127.0.0.1'; // Game Server IP, as seen by clients - Must be external address
$server[1]['game_port']     =  8085;       // Game Server port
$server[1]['rev']           = 'rev. ';     // MaNGOS rev. used (Trinity does not need this)
$server[1]['both_factions'] =  true;       // Allow to see opponent faction characters. Affects only players.


// === Player Map configuration === //

// GM online options
$map_gm_show_online_only_gmoff     = 1; // show GM point only if in '.gm off' [1/0]
$map_gm_show_online_only_gmvisible = 1; // show GM point only if in '.gm visible on' [1/0]
$map_gm_add_suffix                 = 1; // add '{GM}' to name [1/0]
$map_status_gm_include_all         = 1; // include 'all GMs in game'/'who on map' [1/0]

// status window options:
$map_show_status =  1;                  // show server status window [1/0]
$map_show_time   =  1;                  // Show autoupdate timer 1 - on, 0 - off
$map_time        = 10;                  // Map autoupdate time (seconds), 0 - not update.

// all times set in msec (do not set time < 1500 for show), 0 to disable.
$map_time_to_show_uptime    = 3000;     // time to show uptime string
$map_time_to_show_maxonline = 3000;     // time to show max online
$map_time_to_show_gmonline  = 3000;     // time to show GM online

$developer_test_mode =  false;

$multi_realm_mode    =  true;


?>
