<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>$lang['chat'],'link'=>'');
?>
<?php
if($user['id']<=0){
    redirect('index.php?n=account&sub=login',1);
}else{
}
?>
<?php
if ((int)$MW->getConfig->chat->enable){
    $showchat = true;
}
else{ $showchat = false;
}
?>