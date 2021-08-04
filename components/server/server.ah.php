<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>$lang['module_ah'],'link'=>'');

global $CHDB;

if (isset($_GET['filter'])){
	if ($_GET['filter'] == "ally") {$ah_where = " WHERE `location` = 2";}
	elseif ($_GET['filter'] == "horde") {$ah_where = " WHERE `location` = 6";}
	elseif ($_GET['filter'] == "black") {$ah_where = " WHERE `location` = 7";}
}
else {$ah_where = "";}

$query = "SELECT ah.item_template AS item_entry, IF(ah.buyoutprice>0,CAST(ah.buyoutprice AS UNSIGNED),'---') AS buyout, ah.time, IF(ah.buyguid>0,buy.name,'---') AS buyer, IF(ah.lastbid>0, ah.lastbid, ah.startbid) AS currentbid, itm.name AS itemname, itm.class AS `class`, itm.quality, sell.name AS seller, CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(iins.data , ' ',  15), ' ', -1) AS UNSIGNED) AS quantity";
$query_part2 = " from `auctionhouse` AS `ah` LEFT JOIN ".$mangos['db_name'].".item_template AS itm ON (ah.item_template = itm.entry) LEFT JOIN `characters` as `sell` ON (ah.itemowner = sell.guid) LEFT JOIN `item_instance` AS `iins` ON (ah.itemguid = iins.guid) LEFT JOIN `characters` AS `buy` ON (ah.buyguid = buy.guid)".$ah_where;
if($_GET['sort']!=null) {
	$allowed_sort_types = array(
		'quality',
		'class',
		'itemname',
		'quantity',
		'seller',
		'time',
		'buyer',
		'currentbid',
		'buyout',
		);
	
	$query_part2 .= " ORDER BY ";
	
	$sort_by = $_GET['sort'];
	
	if(!in_array($sort_by, $allowed_sort_types)) {
		$sort_by = 'time';
	}
	
	if($sort_by=='buyer') {
		$query .= ", IF(ah.buyguid>0,1,0) AS `isbuyerpres`";
		$query_part2 .= "isbuyerpres DESC, ";
		$query_part2 .= $sort_by;
	}
	elseif($sort_by=='buyout') {
		$query .= ", IF(ah.buyoutprice>0,1,0) AS `isbuyout`";
		$query_part2 .= "isbuyout DESC, ah.buyoutprice";
	}
	elseif($sort_by!='class' && $sort_by!='quantity' && $sort_by!='currentbid') {
		$query_part2 .= "FIELD(".$sort_by.", '---'), ";
		$query_part2 .= $sort_by;
	}
	else {
		$query_part2 .= $sort_by;
	}
	
	if($_GET['d']==1) {
		$query_part2 .= ' DESC';
	}
}

if (isset($_GET["pid"])) {$pid = $_GET["pid"];} else {$pid = 1;}
$limit = (int)$MW->getConfig->generic->ahitems_per_page;
$limitstart = ($pid - 1) * $limit;

$query .= $query_part2;
$query .= ' LIMIT ' . $limitstart . ', ' . $limit;
$ah_entry = $CHDB->select($query);
$query2 = $CHDB->query("SELECT `id` from `auctionhouse`".$ah_where);
$numofpgs = ((int)(count($query2) / (int)$MW->getConfig->generic->ahitems_per_page));
if (gettype(count($query2) / (int)$MW->getConfig->generic->ahitems_per_page) != "integer") {
settype($numofpgs, "integer");
$numofpgs++;
}
?>