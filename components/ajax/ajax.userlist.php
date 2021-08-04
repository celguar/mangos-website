<?php
if(INCLUDED!==true)exit;

    $q = $DB->selectCol('SELECT id AS ARRAY_KEY, username FROM account ORDER BY username');
  $res = "<select onchange=\"selectClick(this.value)\" style=\"margin:1px;font-size:1.2em;\"> \n <option value=''>$lang[select_name]</option> \n";
  foreach($q as $uid => $uname){
    if($_REQUEST['insid']) $res .= "<option value=\"".$uid."\">$uname</option> \n";
    else $res .= "<option value=\"".htmlspecialchars($uname)."\">$uname</option> \n";
  }
  $res .= "</select>";
  echo $res;
?>