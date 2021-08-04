<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['register'],'link'=>'');

if ((int)$MW->getConfig->generic->site_register == 0)
{
      output_message('alert','Registration: Locked');
}
else
{
      $regparams = array(
                  'MIN_LOGIN_L' => 3,
                  'MAX_LOGIN_L' => 16,
                  'MIN_PASS_L'  => 4,
                  'MAX_PASS_L'  => 16
                  );
      // ==================== //
      if($user['id']>0){
            redirect('index.php?n=account&sub=manage',1);
      }
      $allow_reg = true;
      $err_array = array();
      $err_array[0] = $lang['ref_fail'];
      if($_POST['step'] && (int)$MW->getConfig->generic->req_reg_key){
            if($auth->isvalidregkey($_POST['r_key'])!==true){
                  output_message('alert',$lang['bad_reg_key']);
                  $allow_reg = false;
                  $err_array[] = "Your registration key was invalid. Please check it for typos.";
		  log_error("Account creation: On account registrer the key ".$_POST['r_key']." was not valid.");
            }
      }
      if((int)$MW->getConfig->generic->max_accounts_per_ip>0){
            $count_ip = $DB->selectCell("SELECT count(*) FROM account_extend WHERE registration_ip=?",$_SERVER['REMOTE_ADDR']);
            if($count_ip>=(int)$MW->getConfig->generic->max_accounts_per_ip){
                  output_message('alert',$lang['reg_acclimit']);
                  $allow_reg = false;
                  $err_array[] = "You are not allowed to create any more accounts. If you feel this is in error, please contact the administrator.";
                  $err_array[] = "If you are registering through a shared connection, it is advised that you use a private connection for registration.";
		  log_error("Account Creation: User with ip ".$_SERVER['REMOTE_ADDR']." is not allowed to create more than ".(int)$MW->getConfig->generic->max_accounts_per_ip." per IP.");
            }
      }
      if($_POST['step']==3){
            if($allow_reg === true){
                  $notreturn = FALSE; // Inizialize variable, we use this after. Use this to add extensions.
	  
                  // Extensions
                  // Each extention you see down-under will check for specific user input,
                  // In this step we set "requirements" for what user may input.
	  
                  // Ext 1.
                  if ((int)$MW->getConfig->generic_values->account_registrer->enable_image_verfication){
                        $image_key =& $_POST['image_key'];
                        $filename=quote_smart($_POST['filename_image']);
                        
                        $correctkey = $DB->selectCell("SELECT acc_creation_captcha.key FROM acc_creation_captcha WHERE filename=".$filename);
                        if (strtolower($correctkey) != strtolower($image_key) || $image_key == ''){
                              $notreturn = TRUE;
                              $err_array[] = "Inputted text for Image Verification was incorrect.";
                              log_error("Account Creation: Image verfication error, user didn't type the image right.In DB: ".$correctkey." , user input: ".strtolower($image_key).".");
                        }
                  }
                  // Ext 2 check
                  /* Check 3 - secret questions*/
                  if ((int)$MW->getConfig->generic_values->account_registrer->secret_questions_input){
                        if ($_POST['secretq1'] && $_POST['secretq2'] && $_POST['secreta1'] && $_POST['secreta2']) {
                              if(check_for_symbols($_POST['secreta1']) || check_for_symbols($_POST['secreta2'])){
                                    $notreturn = TRUE;
                                    $err_array[] = "Answers to Secret Questions contain unallowed symbols.";
                              }
                              if($_POST['secretq1'] == $_POST['secretq2']) {
                                    $notreturn = TRUE;
                                    $err_array[] = "Secret Questions cannot be the same.";
                              }
                              if($_POST['secreta1'] == $_POST['secreta2']) {
                                    $notreturn = TRUE;
                                    $err_array[] = "Answers to Secret Questions cannot be the same.";
                              }
                              if(strlen($_POST['secreta1']) < 4 || strlen($_POST['secreta2']) < 4) {
                                    $notreturn = TRUE;
                                    $err_array[] = "Answers to Secret Questions must be at least 4 characters in length.";
                              }
                        }
                        else {
                              $notreturn = TRUE;
                              $err_array[] = "User didn't type any answers to the secret questions.";
                        }
		  }
      
                  // Ext 3 - make sure password is not username
                  if($_POST['r_login'] == $_POST['r_pass']) {
                        $notreturn = TRUE;
			$err_array[] = "Password cannot be the same as username.";
                  }
      
                  // Main add.
                  if ($notreturn === FALSE){
                        if($auth->register(array('username'=>$_POST['r_login'],'sha_pass_hash'=>sha_password($_POST['r_login'],$_POST['r_pass']),'sha_pass_hash2'=>sha_password($_POST['r_login'],$_POST['r_cpass']),'email'=>$_POST['r_email'],'expansion' =>$_POST['r_account_type'],'password' =>
                              $_POST['r_pass']), array('secretq1'=>strip_if_magic_quotes($_POST['secretq1']),'secreta1'=>strip_if_magic_quotes($_POST['secreta1']),'secretq2'=>strip_if_magic_quotes($_POST['secretq2']), 'secreta2'=>strip_if_magic_quotes($_POST['secreta2'])))===true){
                              if((int)$MW->getConfig->generic->req_reg_key)$auth->delete_key($_POST['r_key']);
                              if((int)$MW->getConfig->generic->req_reg_act == 0)$auth->login(array('username'=>$_POST['r_login'],'sha_pass_hash'=>sha_password($_POST['r_login'],$_POST['r_pass'])));
                              $reg_succ = true;
                        }else{
			      $reg_succ = false;
                              $err_array[] = "Account Creation [FATAL ERROR]: User cannot be created, likely due to incorrect database configuration.  Contact the administrator.";
                        }
                  }
                  else{
                        $reg_succ = false;
                  }
                  
                  //Error message
                  if($reg_succ == false) {
                        if(!$err_array[1]) {
                              $err_array[1] = $lang['ref_fail'].": Unknown Reason";
                        }
                        $output_error = implode("<br>\n",$err_array);
                        output_message('alert',$output_error);
                  }
            }
      }
}
?>
