<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['realms_manage'],'link'=>'index.php?n=admin&sub=realms');
// ==================== //
$realm_type_def = array(
    0 => 'Normal',
    1 => 'PVP',
    4 => 'Normal',
    6 => 'RP',
    8 => 'RPPVP',
    16 => 'FFA_PVP'
);
$realm_timezone_def = array(
     0 => 'Unknown',
     1 => 'Development',
     2 => 'United States',
     3 => 'Oceanic',
     4 => 'Latin America',
     5 => 'Tournament',
     6 => 'Korea',
     7 => 'Tournament',
     8 => 'English',
     9 => 'German',
    10 => 'French',
    11 => 'Spanish',
    12 => 'Russian',
    13 => 'Tournament',
    14 => 'Taiwan',
    15 => 'Tournament',
    16 => 'China',
    17 => 'CN1',
    18 => 'CN2',
    19 => 'CN3',
    20 => 'CN4',
    21 => 'CN5',
    22 => 'CN6',
    23 => 'CN7',
    24 => 'CN8',
    25 => 'Tournament',
    26 => 'Test Server',
    27 => 'Tournament',
    28 => 'QA Server',
    29 => 'CN9',
);

if(!$_GET['action']){

    $items = $DB->select("SELECT * FROM realmlist ORDER BY `name`");

}elseif($_GET['action']=='edit' && $_GET['id']){
    $pathway_info[] = array('title'=>$lang['editing'],'link'=>'');
    $item = $DB->selectRow("SELECT * FROM realmlist WHERE `id`=?d",$_GET['id']);
}elseif($_GET['action']=='update' && $_GET['id']){
    $DB->query("UPDATE realmlist SET ?a WHERE id=?d LIMIT 1",$_POST,$_GET['id']);
    redirect('index.php?n=admin&sub=realms',1);
}elseif($_GET['action']=='create'){
    $DB->query("INSERT INTO realmlist SET ?a",$_POST);
    redirect('index.php?n=admin&sub=realms',1);
}elseif($_GET['action']=='delete' && $_GET['id']){
    $DB->query("DELETE FROM realmlist WHERE id=?d LIMIT 1",$_GET['id']);
    redirect('index.php?n=admin&sub=realms',1);
}

?>