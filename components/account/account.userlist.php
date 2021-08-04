<?php
if(INCLUDED!==true)exit;
// ==================== //
$oldInactiveTime = 3600*24*7;
// ==================== //
if($_GET['id'] > 0){
    if(!$_GET['action']){
        $profile = $auth->getprofile($_GET['id']);
        $allgroups = $DB->selectCol("SELECT g_id AS ARRAY_KEY, g_title FROM account_groups");

        $pathway_info[] = array('title'=>$lang['users_manage'],'link'=>$com_links['sub_members']);
        $pathway_info[] = array('title'=>$profile['username'],'link'=>'');

        $txt['yearlist'] = "\n";
            $txt['monthlist'] = "\n";
            $txt['daylist'] = "\n";
            for($i=1;$i<=31;$i++){
                $txt['daylist'] .= "<option value='$i'".($i==$profile['bd_day']?' selected':'')."> $i </option>\n";
            }
            for($i=1;$i<=12;$i++){
                $txt['monthlist'] .= "<option value='$i'".($i==$profile['bd_month']?' selected':'')."> $i </option>\n";
            }
            for($i=1950;$i<=date('Y');$i++){
                $txt['yearlist'] .= "<option value='$i'".($i==$profile['bd_year']?' selected':'')."> $i </option>\n";
            }
            $profile['signature'] = str_replace('<br />','',$profile['signature']);
    }
}else{
    $pathway_info[] = array('title'=>$lang['userlist'],'link'=>'');
	//===== Filter ==========//
    if($_GET['char'] && preg_match("/[a-z]/",$_GET['char'])){
        $filter = "WHERE `username` LIKE '".escape_string($_GET['char'])."%'";
    }elseif($_GET['char']==1){
        $filter = "WHERE `username` REGEXP '^[^A-Za-z]'";
    }else{
        $filter = '';
      }
	//===== Calc pages =====//
    $items_per_pages = (int)$MW->getConfig->generic->users_per_page;
    $itemnum = $DB->selectCell("SELECT count(*) FROM account $filter");
    $pnum = ceil($itemnum/$items_per_pages);
    $pages_str = default_paginate($pnum, $p, "index.php?n=account&sub=userlist&char=".$_GET['char']);
    $limit_start = ($p-1)*$items_per_pages;

    $items = $DB->select("
        SELECT * FROM account
        LEFT JOIN account_extend ON account.id=account_extend.account_id
        $filter
        ORDER BY username
        LIMIT $limit_start,$items_per_pages");
}
##   output_message('alert',$itemnum);
?>
