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

      if ($_POST['step']=="save")
      {
            if($allow_reg === true)
            {
                  $query=$DB->select("SELECT id, username FROM account WHERE LOWER(username)=LOWER('".$_SESSION['CA_u']."')");
                  $queryb=$DB->select("SELECT id FROM account WHERE LOWER(email)=LOWER('".$_SESSION['CA_em']."')");

                  if (!$query and !$queryb and $_SESSION['CA_accountset']!="" and $_SESSION['CA_userset']!="" and $_SESSION['CA_valcode']!="" and !$err_array[1])
                  {
                        if ($auth->register(
                                array(
                                    'username'=>strtoupper($_SESSION['CA_u']),
                                    'sha_pass_hash'=>sha_password($_SESSION['CA_u'],$_SESSION['CA_p']),
                                    'email'=>$_SESSION['CA_em'],
                                    'expansion' =>$_SESSION['CA_tbc'],
                                    'password'=>$_SESSION['CA_p']),
                                array(
                                    'fname'=>$_SESSION['CA_fname'],
                                    'lname'=>$_SESSION['CA_lname'],
                                    'city'=>$_SESSION['CA_city'],
                                    'location'=>$_SESSION['CA_lo'],
                                    'hidelocation'=>($_SESSION['CA_shlo']==1 ? '0' : '1'),
                                    'gmt'=>$_SESSION['CA_gmt'],
                                    'icq'=>$_SESSION['CA_icq'],
                                    'aim'=>$_SESSION['CA_aim'],
                                    'yahoo'=>$_SESSION['CA_yahoo'],
                                    'skype'=>$_SESSION['CA_skype'],
                                    'homepage'=>$_SESSION['CA_weburl'],
                                    'display_name'=>$_SESSION['CA_nick'],
                                    //'gender'=>$_SESSION['CA_gender'],
                                    'hideemail'=>($_SESSION['CA_shem']==1 ? '0' : '1'),
                                    'hideprofile'=>($_SESSION['CA_shbd']==1 ? '0' : '1'),
                                    'msn'=>$_SESSION['CA_msn'],
                                    'secretq1'=>strip_if_magic_quotes($_SESSION['CA_ask']),
                                    'secreta1'=>strip_if_magic_quotes($_SESSION['CA_ans'])
                                )
                            )===true)
                        {
                              if((int)$MW->getConfig->generic->req_reg_key)
                              {
                                    $auth->delete_key($_POST['r_key']);
                              }
                              if((int)$MW->getConfig->generic->req_reg_act == 0)
                              {
                                    $auth->login(array('username'=>$_SESSION['CA_u'],'password'=>$_SESSION['CA_p']));
                              }
                              $reg_succ = true;
                              // clear session data
                              unset($_POST['step']);
                              cleanCA('');
                              echo '<META HTTP-EQUIV=REFRESH CONTENT="0; URL=index.php">';
                        } else
                        {
                              $reg_succ = false;
                              $err_array[] = "Account Creation [FATAL ERROR]: User cannot be created, likely due to incorrect database configuration.  Contact the administrator.";
                        }
                        //Error message
                        if($reg_succ == false)
                        {
                              if(!$err_array[1]) {
                                    $err_array[1] = $lang['ref_fail'].": Unknown Reason";
                              }
                              $output_error = implode("<br>\n",$err_array);
                              output_message('alert',$output_error);
                              $_POST['step']="verifyaccount";
                        }
                  }
                  else
                  {
                        if(!$err_array[1]) {
                              $err_array[1] = $lang['ref_fail'].": Unknown Reason";
                        }
                        $output_error = implode("<br>\n",$err_array);
                        output_message('alert',$output_error);
                        $_POST['step']="verifyaccount";
                  }
            }
      }

if ($_POST['update']=="valcode" and $_POST['save']=="true") {

      if ((int)$MW->getConfig->generic_values->account_registrer->enable_image_verfication){
            $image_key = $_POST['image_key'];
            $filename=quote_smart($_POST['filename_image']);
            $correctkey = $DB->selectCell("SELECT `filekey` FROM `website_captcha` WHERE `filename`=".$filename);
            if (strtolower($correctkey) != strtolower($image_key) || $image_key == ''){
                  //$notreturn = TRUE;
                  $err_array[] = "Inputted text for Image Verification was incorrect.";
                  log_error("Account Creation: Image verfication error, user didn't type the image right.In DB: ".$correctkey." , user input: ".strtolower($image_key).".");
                  if(!$err_array[1]) {
                        $err_array[1] = $lang['ref_fail'].": Unknown Reason";
                  }
                  $output_error = implode("<br>\n",$err_array);
                  output_message('alert',$output_error);
                  $_SESSION['CA_valcode'] = false;
                  $_POST['step']="valcode";
            }
            else
            {
                  $_SESSION['CA_valcode'] = true;
                  $_POST['step']="userinfo";
            }
            unset($image_key);
      }
} else if (strstr($_POST['update'],"userinfo")!=false and $_POST['save']=="true") {

      if (strlen($_POST['fname']) < 1 or strlen($_POST['fname']) > 45) {
            $err_array[] = "Invalid length on First Name field.<br>";
      } else {
            if (alphanum($_POST['fname'], false) == false) {
                  $err_array[] = "Invalid chars on First Name field.<br>";
            }
      }
      if (strlen($_POST['lname']) < 1 or strlen($_POST['lname']) > 45) {
            $err_array[] = "Invalid length on Last Name field.<br>";
      } else {
            if (alphanum($_POST['lname'], false) == false) {
                  $err_array[] = "Invalid chars on Last Name field.<br>";
            }
      }
      if (strlen($_POST['city']) < 1 or strlen($_POST['city']) > 45) {
            $err_array[] = "Invalid length on City field.<br>";
      }
      if (strlen($_POST['lo']) < 1) {
            $err_array[] = "Invalid selected option on Country field.<br>";
      }
      if (strlen($_POST['em']) < 1 or strlen($_POST['em']) > 255) {
            $err_array[] = "Invalid length on E-mail field.<br>";
      } else {
            if (valemail($_POST['em']) == false) {
                  $err_array[] = "Invalid E-mail.<br>";
            } else {
                  $query = $DB->selectCell("SELECT email FROM account WHERE LOWER(email)=LOWER('" . $_POST['em'] . "')");
                  if ($query) {
                        $err_array[] = "E-mail already exists.<br>";
                  }
            }
      }
      if (strlen($_POST['nick']) < 3 or strlen($_POST['nick']) > 16) {
            $err_array[] = "Invalid length on Display Name field.<br>";
      } else {
            if (alphanum($_POST['Display Name'], true, true, '_') == false) {
                  $err_array[] = "Invalid chars on Display Name field.<br>";
            } else {
                  $query = $DB->selectCell("SELECT display_name FROM website_accounts WHERE LOWER(display_name)=LOWER('" . $_POST['nick'] . "')");
                  if ($query) {
                        $err_array[] = "Display Name already exists.<br>";
                  }
            }
      }
      if (strlen($_POST['bd']) > 1) {
            if (valdate($_POST['bd']) == false) {
                  $err_array[] = "Invalid date on Birthday field.<br>";
            }
      } else {
            $_POST['shbd'] = '0';
      }

      if (!$err_array[1]) {
            $_SESSION['CA_fname'] = $_POST['fname'];
            $_SESSION['CA_lname'] = $_POST['lname'];
            $_SESSION['CA_city'] = $_POST['city'];
            $_SESSION['CA_lo'] = $_POST['lo'];
            $_SESSION['CA_shlo'] = $_POST['shlo'];
            $_SESSION['CA_em'] = $_POST['em'];
            $_SESSION['CA_shem'] = $_POST['shem'];
            $_SESSION['CA_bd'] = $_POST['bd'];
            $_SESSION['CA_shbd'] = $_POST['shbd'];
            $_SESSION['CA_gmt'] = $_POST['gmt'];
            $_SESSION['CA_shpm'] = $_POST['shpm'];
            $_SESSION['CA_msn'] = $_POST['msn'];
            $_SESSION['CA_icq'] = $_POST['icq'];
            $_SESSION['CA_aim'] = $_POST['aim'];
            $_SESSION['CA_yahoo'] = $_POST['yahoo'];
            $_SESSION['CA_skype'] = $_POST['skype'];
            $_SESSION['CA_sig'] = $_POST['sig'];
            $_SESSION['CA_weburl'] = $_POST['weburl'];
            //$_SESSION['CA_skin'] = $_POST['skin'];
            $_SESSION['CA_nick'] = $_POST['nick'];
            $_SESSION['CA_gender'] = $_POST['gender'];
            $_SESSION['CA_userset'] = true;
      } else {
            $_SESSION['CA_userset'] = false;
            $_POST['step'] = 'userinfo';
            $output_error = implode("<br>\n",$err_array);
            output_message('alert',$output_error);
      }
} else if (strstr($_POST['update'],"accountinfo")!=false and $_POST['save']=="true") {

      if (strlen($_POST['u'])<3 or strlen($_POST['u'])>16) {
            $err_array[] = "Invalid length on Account Name field.<br>";
      } else {
            if (alphanum($_POST['u'],true,true,'_')==false) {
                  $err_array[] = "Invalid chars on Account Name field.<br>";
            } else {
                  $query=$DB->selectCell("SELECT username FROM account WHERE LOWER(username)=LOWER('".$_POST['u']."')");
                  if ($query) {
                        $err_array[] = "Account Name already exists.<br>";
                  }
            }
      }
      if (strlen($_POST['p'])<6 or strlen($_POST['p'])>16) {
            $err_array[] = "Invalid length on Account Password field.<br>";
      } else {
            if (alphanum($_POST['p'],true,true,'_')==false) {
                  $err_array[] = "Invalid chars on Account Password field.<br>";
            } else {
                  if ($_POST['p']!=$_POST['cp']) {
                        $err_array[] = "Account and Verification Password fields must match.<br>";
                  } else {
                        if ($_POST['u']==$_POST['p']) {
                              $err_array[] = "Account Name and Password fields must differ.<br>";
                        }
                  }
            }
      }
      if ($_POST['ask']<1) {
            $err_array[] = "Invalid selected option on Password Hint field.<br>";
      } else {
            if (strlen($_POST['ans'])<1 OR strlen($_POST['ans'])>255) {
                  $err_array[] = "Invalid length on Answer field.<br>";
            }
      }

      if (!$err_array[1]) {
            $_SESSION['CA_u'] = $_POST['u'];
            $_SESSION['CA_p'] = $_POST['p'];
            $_SESSION['CA_ask'] = $_POST['ask'];
            $_SESSION['CA_ans'] = $_POST['ans'];
            $_SESSION['CA_tbc'] = $_POST['uptbc'];
            $_SESSION['CA_accountset'] = true;
      } else {
            $_SESSION['CA_accountset'] = false;
            $_POST['step']='accountinfo';
            $output_error = implode("<br>\n",$err_array);
            output_message('alert',$output_error);
      }

}
      cleanCA($_POST['step']);
      if($_POST['step']==5){
            if($allow_reg === true){
                  $notreturn = FALSE; // Inizialize variable, we use this after. Use this to add extensions.
	  
                  // Extensions
                  // Each extention you see down-under will check for specific user input,
                  // In this step we set "requirements" for what user may input.
	  
                  // Ext 1.
                  if ((int)$MW->getConfig->generic_values->account_registrer->enable_image_verfication){
                        $image_key =& $_POST['image_key'];
                        $filename=quote_smart($_POST['filename_image']);
                        
                        $correctkey = $DB->selectCell("SELECT website_captcha.key FROM website_captcha WHERE filename=".$filename);
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
                              if((int)$MW->getConfig->generic->req_reg_act == 0)
                              {
                                    $auth->login(array('username'=>$_POST['r_login'],'sha_pass_hash'=>sha_password($_POST['r_login'],$_POST['r_pass'])));
                              }
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
