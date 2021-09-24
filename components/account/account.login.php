<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['login'],'link'=>'');
// ==================== //
if($_REQUEST['action']=='login'){
  $login = $_REQUEST['login'];
  $pass = $_REQUEST['pass'];
  if($auth->login(array('username'=>$login,'password'=>$pass)))
  {
    redirect($_SERVER['HTTP_REFERER'],1);
  }
}elseif($_REQUEST['action']=='logout'){
  $auth->logout();
  redirect($_SERVER['HTTP_REFERER'],1);
}
?>
