<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['regkeys_manage'],'link'=>'');
// ==================== //

if(!$_GET['action']){
    $allkeys = $DB->select("SELECT * FROM site_regkeys");
    $num_keys = count($allkeys);
}elseif($_GET['action']=='create'){
    if($_POST['num']<300){
        $keys_arr = $auth->generate_keys($_POST['num']);
        foreach ($keys_arr as $key) {
            $DB->query('INSERT INTO site_regkeys (`key`) VALUES(?)', $key);
        }
    }
    redirect('index.php?n=admin&sub=keys',1);
}elseif($_GET['action']=='delete'){
    if($_POST['keyid'] || $_GET['keyid']){
        $_GET['keyid']?$keyid=$_GET['keyid']:$keyid=$_POST['keyid'];
        $DB->query("DELETE FROM site_regkeys WHERE `id`=?d",$keyid);
    }elseif($_POST['keyname']){
        $DB->query("DELETE FROM site_regkeys WHERE `key`=?",$_POST['keyname']);
    }
    redirect('index.php?n=admin&sub=keys',1);
}elseif($_GET['action']=='setused'){
    $DB->query("UPDATE site_regkeys SET used=1 WHERE `id`=?d",$_GET['keyid']);
    redirect('index.php?n=admin&sub=keys',1);
}elseif($_GET['action']=='deleteall'){
    $DB->query("TRUNCATE TABLE site_regkeys");
    redirect('index.php?n=admin&sub=keys',1);
}
?>