<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['donate'],'link'=>'index.php?n=community&sub=donate');
// ==================== //


if($user['id']<=0){
    redirect('index.php?n=account&sub=login',1);
}
else
{
if(!$_GET['action'])
{
        $profile = $auth->getprofile($user['id']);
        $profile['signature'] = str_replace('<br />','',$profile['signature']);
}
}
?>
