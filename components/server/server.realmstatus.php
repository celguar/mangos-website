<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['realms_status'],'link'=>'');
// ==================== //

$items = array();
$items = $DB->select("SELECT * FROM `realmlist` ORDER BY `name`");
$i = 0;
foreach($items as $i => $result)
{
    if((int)$MW->getConfig->generic->use_local_ip_port_test) {
        $result['address'] = "127.0.0.1";
    }
    /*Extra: Add because realms is not going to be affected by anything*/
    //$dbinfo_mangos = explode(';', $result['dbinfo']);  // username;password;port;host;DBName
    $dbinfo_mangos = $DB->selectRow( "SELECT * FROM `realm_settings` WHERE id_realm=?d", $result['id'] ) ;
    if((int)$MW->getConfig->generic->use_archaeic_dbinfo_format) {
        //alternate config - for users upgrading from Modded MaNGOS Web
	//DBinfo column:  host;port;username;password;WorldDBname;CharDBname
        $mangosALL = array(
            'db_type'     => 'mysql',
            'db_host'     => $dbinfo_mangos['0'], //ip of db world
            'db_port'     => $dbinfo_mangos['1'], //port
            'db_username' => $dbinfo_mangos['2'], //world user
            'db_password' => $dbinfo_mangos['3'], //world password
            'db_name'     => $dbinfo_mangos['4'], //world db name
            'db_char'     => $dbinfo_mangos['5'], //character db name
            'db_encoding' => 'utf8',              // don't change
        );
    }
    else {
        //normal config, as outlined in how-to
	//DBinfo column:  username;password;port;host;WorldDBname;CharDBname
        $mangosALL = array(
            'db_type'     => 'mysql',
            'db_host'     => $dbinfo_mangos['dbhost'], //ip of db world
            'db_port'     => $dbinfo_mangos['dbport'], //port
            'db_username' => $dbinfo_mangos['dbuser'], //world user
            'db_password' => $dbinfo_mangos['dbpass'], //world password
            'db_name'     => $dbinfo_mangos['dbname'], //world db name
            'db_char'     => $dbinfo_mangos['chardbname'], //character db name
            'db_encoding' => 'utf8',              // don't change
        );
    }

    if((int)$MW->getConfig->generic->use_alternate_mangosdb_port) {
        $mangosALL['db_port'] = (int)$MW->getConfig->generic->use_alternate_mangosdb_port;
    }

    // Important! This assigns a connection to the spesific connection we have.. NOT remove this!
    $WSDB_EXTRA = DbSimple_Generic::connect("".$mangosALL['db_type']."://".$mangosALL['db_username'].":".$mangosALL['db_password']."@".$mangosALL['db_host'].":".$mangosALL['db_port']."/".$mangosALL['db_name']."");
    if($WSDB_EXTRA)$WSDB_EXTRA->query("SET NAMES ".$mangosALL['db_encoding']);
    $CHDB_EXTRA = DbSimple_Generic::connect("".$mangosALL['db_type']."://".$mangosALL['db_username'].":".$mangosALL['db_password']."@".$mangosALL['db_host'].":".$mangosALL['db_port']."/".$mangosALL['db_char']."");
    if($CHDB_EXTRA)$CHDB_EXTRA->query("SET NAMES ".$mangosALL['db_encoding']);

    $population=0;
    if($res_color==1)$res_color=2;else$res_color=1;
    $realm_type = $realm_type_def[$result['icon']];
	$realm_num = $result['id'];
    if(check_port_status($result['address'], $result['port'])===true)
    {
        $res_img = './templates/WotLK/images/uparrow2.gif';
        if($WSDB_EXTRA&&$CHDB_EXTRA) {
            $population = $CHDB_EXTRA->selectCell("SELECT count(*) FROM `characters` WHERE online=1");
            $uptime = time () - $DB->selectCell("SELECT starttime FROM uptime WHERE `realmid`='$realm_num' ORDER BY `starttime` DESC LIMIT 1");
        }
    }
    else
    {
        $res_img = './templates/WotLK/images/downarrow2.gif';
        $population_str = 'n/a';
        $uptime = 0;
    }
    $items[$i]['res_color'] = $res_color;
    $items[$i]['img'] = $res_img;
    $items[$i]['name'] = $result['name'];
    $items[$i]['type'] = $realm_type;
    $items[$i]['pop'] = $population;
    $items[$i]['uptime'] = $uptime;
    unset($WSDB_EXTRA);
    unset($CHDB_EXTRA);
}
?>
