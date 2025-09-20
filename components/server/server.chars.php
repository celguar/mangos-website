<?php
if(INCLUDED!==true)exit;

// ==================== //
$pathway_info[] = array('title'=>$lang['chars'],'link'=>'');

	//===== Calc pages1 =====//
	$items_per_pages = (int)$MW->getConfig->generic->users_per_page;
 	$limit_start = ($p-1)*$items_per_pages;

// ==================== //



$MANG = new Mangos;
$query = array();
$realm_info_new = get_realm_byid($user['cur_selected_realmd']);

$cc = 0;
if(!check_port_status($realm_info_new['address'], $realm_info_new['port'])===true)
{
    output_message('alert','Realm <b>'.$realm_info_new['name'].'</b> is offline <img src="images/downarrow2.gif" border="0" align="top">');
}

// array�s
$query1 = array();

//===== Filter ==========//
$filter = 'WHERE `guid` > 0';
if($_GET['char'] && preg_match("/[a-z]/",$_GET['char'])){
   $filter .= " AND `name` LIKE '".$_GET['char']."%'";}
if($_GET['char']==1){
   $filter .= " AND `name` REGEXP '^[^A-Za-z]'";
}if($_GET['race']){
    $filter .= " AND `race` IN (".$_GET['race'].")";
}if($_GET['class']){
    $filter .= " AND `class` IN (".$_GET['class'].")";
}

if ($_GET['lvl']) {
    $filter .= " AND `level` = '".$_GET['lvl']."'";
}
else
{
    if ($_GET['minlvl']) {
        $filter .= " AND `level` >= '".$_GET['minlvl']."'";
    }
    if ($_GET['maxlvl']) {
        $filter .= " AND `level` <= '".$_GET['maxlvl']."'";
    }
}

$filter_string = " ORDER BY `name`";
if ($_GET['sort']) {
    if ($_GET['sort'] == 'lvlasc') { $filter_string = " ORDER BY `level` ASC";}
    if ($_GET['sort'] == 'lvldesc') { $filter_string = " ORDER BY `level` DESC";}
}

## output_message('alert',$filter);

$query1 =  $CHDB->select("SELECT `guid`, `name`, `race`, `class`, `zone`, `level`, `gender` FROM `characters` $filter $filter_string LIMIT
$limit_start,$items_per_pages");

$cc1 = 0;
$item_res = array();

if (count($query1) > 0){
foreach ($query1 as $result1) {

    if($res_color==1) {
      $res_color=2;
    }
    else
      $res_color=1;
    $cc1++;
    $res_pos=$MANG->get_zone_name($result1['zone']);

    //$char_gender = $result1['gender'];
    //$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);

    $item_res[$cc1]["number"] = $cc1;
    $item_res[$cc1]["name"] = $result1['name'];
    $item_res[$cc1]["res_color"] = $res_color;
    $item_res[$cc1]["race"] = $result1['race'];
    $item_res[$cc1]["class"] = $result1['class'];
    $item_res[$cc1]["gender"] = $result1['gender'];
    $item_res[$cc1]["level"] = $result1['level'];
    $item_res[$cc1]["pos"] = $res_pos;
    $item_res[$cc1]["guid"]=$result1['guid'];
    }
}
unset($query1, $result1);

//Find total number of characters in database -- used to calculate total number of pages
$cc2 =  $CHDB->selectCell("SELECT count(*) FROM `characters` $filter");

	//===== Calc pages2 =====//
	$pnum = ceil($cc2/$items_per_pages);
    $urlstring = "index.php?n=server&sub=chars&char=".$_GET['char'];
    if ($_GET['lvl']) {
        $urlstring .= "&lvl=".$_GET['lvl'];
    }
    else
    {
        if ($_GET['minlvl']) {
            $urlstring .= "&minlvl=".$_GET['minlvl'];
        }
        if ($_GET['maxlvl']) {
            $urlstring .= "&maxlvl=".$_GET['maxlvl'];
        }
    }
    if ($_GET['class']) {
        $urlstring .= "&class=".$_GET['class'];
    }
    if ($_GET['race']) {
        $urlstring .= "&race=".$_GET['race'];
    }
	$pages_str = default_paginate($pnum, $p, $urlstring);


?>




