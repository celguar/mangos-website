<?php
if(INCLUDED!==true)exit;
$screensize = (string)$MW->getConfig->components->left_section->Screenshotsize;
$pathway_info[] = array('title'=>$lang['GallScreen'],'link'=>'');
	//===== Calc pages1 =====//
	$items_per_pages = (int)$MW->getConfig->generic->images_per_page;
 	$limit_start = ($p-1)*$items_per_pages;
    $cc= $DB->selectCell("SELECT count(*) FROM `gallery` WHERE cat='screenshot'");
	//===== Calc pages2 =====//
	$pnum = ceil($cc/$items_per_pages);
	$pages_str = default_paginate($pnum, $p, "index.php?n=media&sub=screen");
?>
