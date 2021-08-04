<?php
if(INCLUDED!==true)exit;

  $chk = $auth->isavailableusername($_GET['q']);
  if($chk===true){$res='true';}else{$res='false';}
  echo $res;
?>