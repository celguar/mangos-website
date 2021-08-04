<?php
if(INCLUDED!==true)exit;

  $res =  my_preview(@$_REQUEST['text'],$user['group']);
  echo $res;
?>