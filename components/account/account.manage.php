<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['accediting'],'link'=>'');
// ==================== //
if($user['id']<=0){
    redirect('index.php?n=account&sub=login',1);
}else{
    if(!$_GET['action']){
        $profile = $auth->getprofile($user['id']);
        $profile['signature'] = str_replace('<br />','',$profile['signature']);
    }elseif($_GET['action']=='changeemail'){
        $newemail = trim($_POST['new_email']);
        if($auth->isvalidemail($newemail)){
            if($auth->isavailableemail($newemail)){
                if($DB->query("UPDATE account SET email=? WHERE id=?d LIMIT 1",$newemail,$user['id'])===true){
                    if((int)$MW->getConfig->generic->use_purepass_table) {
                        $count_occur = $DB->selectCell("SELECT count(*) FROM account_pass WHERE id=?d", $user['id']);
                        if($count_occur) {
                            $DB->query("UPDATE account_pass SET email=? WHERE id=?d LIMIT 1",$newemail,$user['id']);
                        }
                    }
                    output_message('notice','<b>'.$lang['change_mail'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
                }
            }else{
                output_message('alert','<b>'.$lang['reg_checkemailex'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
            }
        }else{
            output_message('alert','<b>'.$lang['bad_mail'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
        }
    }elseif($_GET['action']=='changepass'){
        $newpass = trim($_POST['new_pass']);
        if(strlen($newpass)>3){
            $DB->query("UPDATE account SET sessionkey = NULL WHERE id=?",$user['id']);
			$DB->query("UPDATE account SET s = NULL WHERE id=?",$user['id']);
			$DB->query("UPDATE account SET v = NULL WHERE id=?",$user['id']);
            $sha_pass = sha_password($user['username'],$newpass);
            $DB->query("UPDATE account SET sha_pass_hash=? WHERE id=?",strtoupper($sha_pass),$user['id']);

            
            if((int)$MW->getConfig->generic->use_purepass_table) {
                $count_occur = $DB->selectCell("SELECT count(*) FROM account_pass WHERE id=?d", $user['id']);
                if($count_occur) {
                    $DB->query("UPDATE account_pass SET password=? WHERE id=?d LIMIT 1",$newpass,$user['id']);
                }
                else {
                    $DB->query("INSERT INTO account_pass SET id=?d, username=?, password=?, email=?",$user['id'],$user['username'],$newpass,$user['email']);
                }
            }
            
            //$uservars_hash_new = serialize(array($user['id'], sha1(base64_encode(md5(utf8_encode($sha_pass))))));
            //setcookie((string)$MW->getConfig->generic->site_cookie, $uservars_hash_new, time()+(60*60*24*365),$MW->getConfig->temp->site_href,$MW->getConfig->temp->site_domain); // expires in 365 days
            
            
            output_message('notice','<b>'.$lang['change_pass_succ'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
            
        }else{
            output_message('alert','<b>'.$lang['change_pass_short'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
        }
    }elseif($_GET['action']=='change'){
        if(is_uploaded_file($_FILES['avatar']['tmp_name'])){
            if($_FILES['avatar']['size'] <= (int)$MW->getConfig->generic->max_avatar_file){
                $ext = strtolower(substr(strrchr($_FILES['avatar']['name'],'.'), 1));
                if(in_array($ext,array('gif','jpg','png'))){
                    if(@move_uploaded_file($_FILES['avatar']['tmp_name'], (string)$MW->getConfig->generic->avatar_path.$user['id'].'.'.$ext)){
                        list($width, $height, ,) = getimagesize((string)$MW->getConfig->generic->avatar_path.$user['id'].'.'.$ext);
                        $max_avatar_size = explode('x',(string)$MW->getConfig->generic->max_avatar_size);
                        if($width <= $max_avatar_size[0] || $height <= $max_avatar_size[1]){
                            $DB->query("UPDATE account_extend SET avatar='".$user['id'].'.'.$ext."' WHERE account_id=?d LIMIT 1",$user['id']);
                        }else{
                            @unlink((string)$MW->getConfig->generic->avatar_path.$user['id'].'.'.$ext);
                        }
                    }
                }
            }
        }elseif($_POST['deleteavatar']==1 && preg_match("/\d+\.\w+/i",$_POST['avatarfile'])){
            if(@unlink((string)$MW->getConfig->generic->avatar_path.$_POST['avatarfile'])){
                $DB->query("UPDATE account_extend SET avatar=NULL WHERE account_id=?d LIMIT 1",$user['id']);
            }
        }
        if(isset($_POST['profile']['g_id']))unset($_POST['profile']['g_id']);
        $_POST['profile']['signature'] = htmlspecialchars($_POST['profile']['signature']);
        
		$DB->query("UPDATE account_extend SET ?a WHERE account_id=?d LIMIT 1",RemoveXSS($_POST['profile']),$user['id']);
        
        redirect('index.php?n=account&sub=manage',1);
    }elseif($_GET['action']=='changesecretq'){
        if(check_for_symbols($_POST['secreta1']) == FALSE && check_for_symbols($_POST['secreta2']) == FALSE && $_POST[secretq1] != '0' && $_POST[secretq2]!= '0' && isset($_POST[secreta1]) &&
        isset($_POST[secreta2]) && strlen($_POST[secreta1])>4 && strlen($_POST[secreta2])>4 && $_POST['secreta1'] != $_POST['secreta2'] && $_POST['secretq1'] != $_POST['secretq2']){
            $DB->query("UPDATE account_extend SET secretq1=?,secretq2=?,secreta1=?,secreta2=? WHERE account_id=?d", strip_if_magic_quotes($_POST['secretq1']), strip_if_magic_quotes($_POST['secretq2']), strip_if_magic_quotes($_POST['secreta1']), strip_if_magic_quotes($_POST['secreta2']), $user['id']);
            output_message('notice','<b>'.$lang['changed_secretq'].'</b><meta http-equiv=refresh content="4;url=index.php?n=account&sub=manage">');

        }else{
            output_message('alert','<b>'.$lang['fail_change_secretq'].'</b><meta http-equiv=refresh content="3;url=index.php?n=account&sub=manage">');
        }
    }elseif($_GET['action']=='resetsecretq'){
        if ($_POST['reset_secretq']){
          $DB->query("UPDATE account_extend SET secretq1='0',secretq2='0',secreta1='0',secreta2='0' WHERE account_id=?d", $user['id']);
          output_message('notice','<b>'.$lang['reset_succ_secretq'].'</b><meta http-equiv=refresh content="4;url=index.php?n=account&sub=manage">');
        }
    }elseif($_GET['action'] == 'change_gameplay'){
       if($_POST['switch_wow_type']=='wotlk'){
		       $DB->query("UPDATE `account` SET expansion='2' WHERE `id`=?d",$user['id']);
           output_message('notice','<b>'.$lang['exp_set'].'</b><meta http-equiv=refresh content="4;url=index.php?n=account&sub=manage">');
	     }
	     elseif($_POST['switch_wow_type']=='tbc'){
	          $DB->query("UPDATE `account` SET expansion='1' WHERE `id`=?d",$user['id']);
           output_message('notice','<b>'.$lang['exp_set'].'</b><meta http-equiv=refresh content="4;url=index.php?n=account&sub=manage">');
       }
	   elseif($_POST['switch_wow_type']=='classic'){
	          $DB->query("UPDATE `account` SET expansion='0' WHERE `id`=?d",$user['id']);
           output_message('notice','<b>'.$lang['exp_set'].'</b><meta http-equiv=refresh content="4;url=index.php?n=account&sub=manage">');
       }
   }
}
?>