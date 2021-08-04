<?php
if(INCLUDED!==true)exit;

  $chk = $auth->isavailableemail($_GET['q']);
  if($chk===true){$res='true';}else{$res='false';}
  echo $res;
?>