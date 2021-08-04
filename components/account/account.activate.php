<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['activation'],'link'=>'');
// ==================== //

	$get_lock_on_accid = $DB->select("SELECT locked FROM account WHERE id=?d",$user['id']);

  foreach($get_lock_on_accid as $fetch){
   $lock = $fetch['locked'];
  }

if($user['id']>0 && $lock == 0){
    redirect('index.php?n=account&sub=manage',1);
}

$key = $_REQUEST['key'];
if($key){
  if($user['id'] = $auth->isvalidactkey($key)){
    $DB->query("UPDATE account SET locked=0 WHERE id=? LIMIT 1",$user['id']);
        $DB->query("UPDATE account_extend SET activation_code=NULL WHERE account_id=? LIMIT 1",$user['id']);
        if($realmd['req_reg_invite'] > 0 && $realmd['req_reg_invite'] < 10){
            $keys_arr = $auth->generate_keys($realmd['req_reg_invite']);
            $email_text  = '';
            foreach ($keys_arr as $invkey){
                $DB->query('INSERT INTO site_regkeys (`key`,`used`) VALUES(?,1)', $invkey);
                $email_text .= ' - '.$invkey."\n";
            }
            $email_text = sprintf($lang['emailtext_inv_keys'],$email_text);
            $accinfo = $auth->getprofile($act_accid);
            send_email($accinfo['email'],$accinfo['username'],'== '.(string)$MW->getConfig->generic->site_title.' invitation keys ==',$email_text);
            output_message('notice',sprintf($lang['email_sent_keys'],(int)$MW->getConfig->generic->req_reg_invite));
        }
    output_message('notice','<b>'.$lang['act_succ'].'.</b>');
  }else{

	$result = $DB->select("SELECT locked FROM account WHERE id=?", $user['id']);
	
  foreach($result as $fetch){
   $lock = $fetch['locked'];
  }
	
	if($lock == 1)
	{
	    output_message('alert',$lang['bad_act_key']);
	    redirect('index.php?n=account&sub=activate',0,2);
	}
  }
}

?>
