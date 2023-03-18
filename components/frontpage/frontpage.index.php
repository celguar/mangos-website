<?php
if(INCLUDED !== true)
    exit();

$postnum = 0;
$hl = '';

if((int)$MW->getConfig->generic_values->forum->news_forum_id == 0)
    output_message('alert', 'Please define forum id for news (in config/config.xml)');

$alltopics = $DB->select("
    SELECT f_topics.*,(SELECT message FROM f_posts WHERE f_topics.topic_id=f_posts.topic_id ORDER BY f_posts.posted LIMIT 1) as message
    FROM f_topics
    WHERE f_topics.forum_id=?d
    ORDER BY topic_posted DESC
    LIMIT ?d,?d", (int)$MW->getConfig->generic_values->forum->news_forum_id, 0, (int)$MW->getConfig->generic_values->news->items_per_page);

if ((int)$MW->getConfig->components->right_section->hitcounter){
    $count_my_page = "templates/offlike/hitcounter.txt";
    $hits = (int)file_get_contents($count_my_page);
    $hits++;
    file_put_contents($count_my_page, $hits);
}

$servers = array();
$multirealms = $DB->select("SELECT * FROM `realmlist` ORDER BY id ASC");
foreach ($multirealms as $realmnow_arr){
    if((int)$MW->getConfig->components->right_section->server_information){
        $data = $DB->selectRow("SELECT address, port, timezone, icon, name FROM realmlist WHERE id = ? LIMIT 1", $realmnow_arr['id']);

        //$realm_data_explode = explode(';', $data['dbinfo']);
        $realm_data = $DB->selectRow( "SELECT * FROM `website_realm_settings` WHERE id_realm=?d", $realmnow_arr['id'] ) ;

        // skip nonexistent realms
        if (!$realm_data)
            continue;

        $mangosALL = array();
        if((int)$MW->getConfig->generic->use_archaeic_dbinfo_format){
            //alternate config - for users upgrading from Modded MaNGOS Web
            //DBinfo column:  host;port;username;password;WorldDBname;CharDBname
            $mangosALL = array(
                'db_type' => 'mysql',
                'db_host' => $realm_data['dbhost'],  //ip of db world
                'db_port' => $realm_data['dbport'], //port
                'db_username' => $realm_data['dbuser'], //world user
                'db_password' => $realm_data['dbpass'], //world password
                'db_name' => $realm_data['dbname'],  //world db name
                'db_char' => $realm_data['chardbname'], //character db name
                'db_encoding' => 'utf8'
            );
        }else{
            //normal config, as outlined in how-to
            //DBinfo column:  username;password;port;host;WorldDBname;CharDBname
            $mangosALL = array(
                'db_type' => 'mysql',
                'db_host' => $realm_data['dbhost'],  //ip of db world
                'db_port' => $realm_data['dbport'], //port
                'db_username' => $realm_data['dbuser'], //world user
                'db_password' => $realm_data['dbpass'], //world password
                'db_name' => $realm_data['dbname'],  //world db name
                'db_char' => $realm_data['chardbname'], //character db name
                'db_encoding' => 'utf8'
            );
        }
        unset($realm_data_explode);

        if((int)$MW->getConfig->generic->use_alternate_mangosdb_port){
            $mangosALL['db_port'] = (int)$MW->getConfig->generic->use_alternate_mangosdb_port;
        }

        $CHDB_EXTRA = DbSimple_Generic::connect("" . $mangosALL['db_type'] . "://" . $mangosALL['db_username'] . ":" . $mangosALL['db_password'] . "@" . $mangosALL['db_host'] . ":" . $mangosALL['db_port'] . "/" . $mangosALL['db_char'] . "");
        if($CHDB_EXTRA)
            $CHDB_EXTRA->query("SET NAMES " . $mangosALL['db_encoding']);
        unset($mangosALL); // Free up memory.

        $server = array();
        $server['name'] = $data['name'];
        if((int)$MW->getConfig->components->server_information->realm_status){
            $checkaddress = (int)$MW->getConfig->generic->use_local_ip_port_test ? '127.0.0.1' : $data['address'];
            $server['realm_status'] = (check_port_status($checkaddress, $data['port']) === true) ? true : false;
        }
        $changerealmtoparam = array("changerealm_to" => $realmnow_arr['id']);
        if((int)$MW->getConfig->components->server_information->online){
            $server['playersonline'] = $CHDB_EXTRA->selectCell("SELECT count(1) FROM `characters` WHERE online=1");
            $server['onlineurl'] = mw_url('server', 'playersonline', $changerealmtoparam);
        }
        if((int)$MW->getConfig->components->left_section->Playermap){
            $server['playermapurl'] = mw_url('server', 'playermap', $changerealmtoparam);
        }
        if((int)$MW->getConfig->components->server_information->server_ip){
            $server['server_ip'] = $data['address'];
        }
        if((int)$MW->getConfig->components->server_information->type){
            $server['type'] = $realm_type_def[$data['icon']];
        }
        if((int)$MW->getConfig->components->server_information->language){
            $server['language'] = $realm_timezone_def[$data['timezone']];
        }
        if((int)$MW->getConfig->components->server_information->population){
            $server['population'] = $CHDB_EXTRA->selectCell("SELECT count(1) FROM `characters` WHERE online=1");
        }
        if((int)$MW->getConfig->components->server_information->accounts){
            $server['accounts'] = $DB->selectCell("SELECT count(*) FROM `account`");
        }
        if((int)$MW->getConfig->components->server_information->active_accounts){
            $server['active_accounts'] = $DB->selectCell("SELECT count(1) FROM `account` WHERE `last_login` > ?", date("Y-m-d", strtotime("-2 week")) . " 00:00:00");
        }
        if((int)$MW->getConfig->components->server_information->characters){
            $server['characters'] = $CHDB_EXTRA->selectCell("SELECT count(1) FROM `characters`");
        }
        unset($CHDB_EXTRA, $data); // Free up memory.
        $init = 'id_' . $realmnow_arr['id'];
        if((int)$MW->getConfig->components->right_section->server_rates && (string)$MW->getConfig->mangos_conf_external->$init->mangos_world_conf != ''){

            $server['rates'] = getMangosConfig($MW->getConfig->mangos_conf_external->$init->mangos_world_conf);
        }
        $server['moreinfo'] = (int)$MW->getConfig->components->server_information->more_info && (string)$MW->getConfig->mangos_conf_external->$init->mangos_world_conf != '';
        $servers[] = $server;
    }
}
unset($multirealms);

if((int)$MW->getConfig->components->right_section->users_on_homepage){
    $usersonhomepage = $DB->selectCell("SELECT count(1) FROM `online`");
}
