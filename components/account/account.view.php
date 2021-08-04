<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['view_profile'],'link'=>'');
// ==================== //
if($user['id']<=0){
  redirect('index.php?n=account&sub=login',1);
}else{
  if($_GET['action']=='find' && $_GET['name']){
    $uid = $auth->getid($_GET['name']);
    $profile = $auth->getprofile($uid);
    
        if($profile['hideprofile']==1){
            unset($profile);
            $pathway_info[] = array('title'=>$lang['forbiden'],'link'=>'');
        }else{
            $pathway_info[] = array('title'=>$profile['username'],'link'=>'');
        }
  }
}
?>