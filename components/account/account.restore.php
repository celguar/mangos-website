<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['retrieve_pass'],'link'=>'');
// ==================== //
if($_POST['retr_login'] && $_POST['retr_email'] && $_POST['secretq1'] && $_POST['secretq2'] && $_POST['secreta1'] && $_POST['secreta2']) {
  //set return as true - we will make false if something is wrong
  $return = TRUE;
  
  /*Check 1*/
  $username = strip_if_magic_quotes($_POST['retr_login']);
  if (check_for_symbols($username,1) == TRUE){
    $return = FALSE;
  }
  else if ($DB->query("SELECT id FROM `account` WHERE username=?",$username)==false){
    $username == FALSE;
    $return = FALSE;
  }else{
    $d = $DB->selectRow("SELECT * FROM `account` WHERE username=?",$username);
    $username =& $d['id'];
    $username_name =& $d['username'];
    $email =& $d['email'];
    
    $posted_email =& $_POST['retr_email'];
    
    /*Check 2*/
    if($email != $posted_email)
      $return = FALSE;
  }

  $secreta1 =& $_POST['secreta1'];
  $secreta2 =& $_POST['secreta2'];  
  /*Check 3*/
  if (check_for_symbols($_POST['secreta1']) || check_for_symbols($_POST['secreta2'])) {
    $return = FALSE;
  }
  
  if ($return == FALSE){
    output_message('alert','<b>'.$lang['fail_restore_pass'].'</b><meta http-equiv=refresh content="3;url=index.php?n=account&sub=restore">');
  }
  elseif ($return == TRUE) {
    $we = $DB->selectRow("SELECT account_id FROM `account_extend` WHERE account_id=? AND secretq1=? AND secretq2=? AND secreta1=? AND secreta2=?", $username,strip_if_magic_quotes($_POST['secretq1']),strip_if_magic_quotes($_POST['secretq2']),strip_if_magic_quotes($_POST['secreta1']),strip_if_magic_quotes($_POST['secreta2']));
    if ($we == false){
      $we = $DB->selectRow("SELECT account_id FROM `account_extend` WHERE account_id=? AND secretq1=? AND secretq2=? AND secreta1=? AND secreta2=?", $username,strip_if_magic_quotes($_POST['secretq2']),strip_if_magic_quotes($_POST['secretq1']),strip_if_magic_quotes($_POST['secreta2']),strip_if_magic_quotes($_POST['secreta1']));
    }
    if($we == true){
      $pas = random_string(7);
      $c_pas = sha_password($username_name,$pas);
      $DB->query("UPDATE `account` SET sha_pass_hash=? WHERE id=?d",$c_pas,$username);
      $DB->query("UPDATE `account` SET sessionkey=NULL WHERE id=?d",$username);
      output_message('notice','<b>'.$lang['restore_pass_ok'].'<br /> New password: '.$pas.'</b>');
    }
    else{
      output_message('alert','<b>'.$lang['fail_restore_pass'].'</b><meta http-equiv=refresh content="3;url=index.php?n=account&sub=restore">');
    }
  }
}
?>
