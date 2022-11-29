<?php
class AUTH {
    var $DB;
    var $user = array(
     'id'    => -1,
     'username'  => 'Guest',
     'g_id' => 1
    );

    function AUTH($DB,$confs)
    {
        global $MW;
        $this->DB = $DB;
        $this->check();
        $this->user['ip'] = $_SERVER['REMOTE_ADDR'];
        if((int)$MW->getConfig->generic->onlinelist_on){
            if($this->user['id']<1)$this->onlinelist_addguest();
            else $this->onlinelist_add();
            $this->onlinelist_update();
        }
        //$this->lastvisit_update($this->user);
    }

    function check()
    {
        global $MW;
        if(isset($_COOKIE[((string)$MW->getConfig->generic->site_cookie)])){
            list($cookie['user_id'], $cookie['account_key']) = @unserialize(stripslashes($_COOKIE[((string)$MW->getConfig->generic->site_cookie)]));
            if($cookie['user_id'] < 1)return false;
            $res = $this->DB->selectRow("
                SELECT * FROM account
                LEFT JOIN website_accounts ON account.id=website_accounts.account_id
                LEFT JOIN website_account_groups ON website_accounts.g_id=website_account_groups.g_id
                WHERE id = ?d", $cookie['user_id']);
            if(get_banned($res['id'], 1)== TRUE){
                $this->setgroup();
                $this->logout();
                output_message('alert','Your account is currently banned');
                return false;
            }
            if($res['activation_code'] != null){
                $this->setgroup();
                output_message('alert','Your account is not active');
                return false;
            }
            if(matchAccountKey($cookie['user_id'], $cookie['account_key'])){
                unset($res['sha_pass_hash']);
                $this->user = $res;
                return true;
            }else{
                $this->setgroup();
                return false;
            }
        }else{
            $this->setgroup();
            return false;
        }
    }

    function setgroup($gid=1) // 1 - guest, 5- banned
    {
        $guest_g = array($this->getgroup($gid));
        $this->user = array_merge($this->user,$guest_g);
    }

    function login($params)
    {
        global $MW;
        $success = 1;
        if (empty($params)) return false;
        if (empty($params['username'])){
            output_message('alert','You did not provide your username');
            $success = 0;
        }
        if (empty($params['password'])){
            output_message('alert','You did not provide your password');
            $success = 0;
        }
        $res = $this->DB->selectRow("
            SELECT `id`,`username`,`s`,`v`,`locked` FROM `account`
            WHERE `username` = ?", strtoupper($params['username']));
		$res2 = $this->DB->selectCell("SELECT gmlevel WHERE id= ?", $res['id']);
        if($res['id'] < 1){$success = 0;output_message('alert','Bad username');}
        if(get_banned($res[id], 1)== TRUE){
            output_message('alert','Your account is currently banned');
            $success = 0;
        }
        if($res['activation_code'] != null){
            output_message('alert','Your account is not active');
            $success = 0;
        }
        if($success!=1) return false;
        if(verifySRP6($params['username'], $params['password'], $res['s'], $res['v'])){
            $this->user['id'] = $res['id'];
            $this->user['name'] = $res['username'];
            $this->user['level'] = $res2;
            $generated_key = $this->generate_key();
            addOrUpdateAccountKeys($res['id'],$generated_key);
            $uservars_hash = serialize(array($res['id'], $generated_key));
            $cookie_expire_time = intval($MW->getConfig->generic->account_key_retain_length);
            if(!$cookie_expire_time) {
                $cookie_expire_time = (60*60*24*365);   //default is 1 year
            }
            (string)$cookie_name = $MW->getConfig->generic->site_cookie;
            (string)$cookie_href = $MW->getConfig->temp->site_href;
            (int)$cookie_delay = (time()+$cookie_expire_time);
            setcookie($cookie_name, $uservars_hash, $cookie_delay,$cookie_href);
            if((int)$MW->getConfig->generic->onlinelist_on)$this->onlinelist_delguest(); // !!
            return true;
        }else{
            output_message('alert','Your password is incorrect');
            return false;
        }
    }

    function logout()
    {
        global $MW;
        setcookie((string)$MW->getConfig->generic->site_cookie, '', time()-3600,(string)$MW->getConfig->temp->site_href);
        removeAccountKeyForUser($this->user['id']);
        if((int)$MW->getConfig->generic->onlinelist_on)$this->onlinelist_del(); // !!
    }

    function check_pm()
    {
        $result = $this->DB->selectCell("SELECT count(*) FROM website_pms WHERE owner_id=? AND showed=0",$this->user['id']);
        return $result;
    }
    /*
    function lastvisit_update($uservars)
    {
        if($uservars['id']>0){
            if(time() - $uservars['last_visit'] > 60*10){
                $this->DB->query("UPDATE members SET last_visit=?d WHERE id=?d LIMIT 1",time(),$uservars['id']);
            }
        }
    }
    */
    function register($params, $account_extend = false)
    {
        global $MW;
        $success = 1;
        if(empty($params)) return false;
        if(empty($params['username'])){
            output_message('alert','You did not provide your username');
            $success = 0;
        }
        //if(empty($params['sha_pass_hash']) || $params['sha_pass_hash']!=$params['sha_pass_hash2']){
        //    output_message('alert','You did not provide your password or confirm pass');
        //    $success = 0;
        //}
        if(empty($params['email'])){
            //output_message('alert','You did not provide your email');
            //$success = 0;
            $params['email'] = "";
        }

        if($success!=1) return false;
        //unset($params['sha_pass_hash2']);
        $password = $params['password'];
        unset($params['password']);

        // SRP6 support
        list($salt, $verifier) = getRegistrationData(strtoupper($params['username']), $password);
        unset($params['sha_pass_hash']);
        $params['s'] = $salt;
        $params['v'] = $verifier;

        if ($params['expansion'] == '32')
            $params['expansion'] = '2';
        elseif ($params['expansion'] != '0')
            $params['expansion'] = '1';

		//$params['sha_pass_hash'] = strtoup($this->gethash($params['password']));
        //$params['sha_pass_hash'] = $this->gethash($params['password']);
        if((int)$MW->getConfig->generic->req_reg_act){
            $tmp_act_key = $this->generate_key();
            $params['locked'] = 1;
            if($acc_id = $this->DB->query("INSERT INTO account SET ?a",$params)){
                // If we dont want to insert special stuff in account_extend...
                if ($account_extend == NULL){
                    $this->DB->query("INSERT INTO website_accounts SET account_id=?d, registration_ip=?, activation_code=?",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key);
                }
                else {
                    $this->DB->query("INSERT INTO website_accounts SET account_id=?d, registration_ip=?, activation_code=?",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key);
                    //$account_extend['account_id'] = $acc_id;
                    //$account_extend['registration_ip'] = $_SERVER['REMOTE_ADDR'];
                    //$account_extend['activation_code'] = $tmp_act_key;
                    //$account_extend['theme'] = $params['expansion'];

                    //$this->DB->query("INSERT INTO website_accounts SET ?a", $account_extend);
//                    $this->DB->query("INSERT INTO account_extend SET account_id=?d, registration_ip=?, activation_code=?, secretq1='".mysql_real_escape_string($account_extend['secretq1'])."',secreta1='".mysql_real_escape_string($account_extend['secreta1'])."',secretq2='".mysql_real_escape_string($account_extend['secretq2'])."',secreta2='".mysql_real_escape_string($account_extend['secreta2'])."'",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key);
                    //$this->DB->query("INSERT INTO account_extend SET account_id=?d, registration_ip=?, activation_code=?, secretq1=?s, secreta1=?s, secretq2=?s, secreta2=?s",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key,$account_extend['secretq1'], $account_extend['secreta1']);
                }
                if((int)$MW->getConfig->generic->use_purepass_table) $this->DB->query("INSERT INTO account_pass SET id=?d, username=?, password=?, email=?",$acc_id,$params['username'],$password,$params['email']);
                $act_link = (string)$MW->getConfig->temp->base_href.'index.php?n=account&sub=activate&id='.$acc_id.'&key='.$tmp_act_key;
                $email_text  = '== Account activation =='."\n\n";
                $email_text .= 'Username: '.$params['username']."\n";
                $email_text .= 'Password: '.$password."\n";
                $email_text .= 'This is your activation key: '.$tmp_act_key."\n";
                $email_text .= 'CLICK HERE : '.$act_link."\n";
                send_email($params['email'],$params['username'],'== '.(string)$MW->getConfig->generic->site_title.' account activation ==',$email_text);
                return true;
            }else{
                return false;
            }
        }else{
            if($acc_id = $this->DB->query("INSERT INTO account SET ?a",$params)){
                if ($account_extend == false){
                    $this->DB->query("INSERT INTO website_accounts SET account_id=?d, registration_ip=?, activation_code=?",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key);
                }else{
                    //$test_acc[account_id] = $acc_id;
                    //$account_extend['account_id'] = $acc_id;
                    //$account_extend['registration_ip'] = $_SERVER['REMOTE_ADDR'];
                    //$account_extend['theme'] = $params['expansion'];
                    //$this->DB->query("INSERT INTO website_accounts SET ?a", $account_extend);
                    $this->DB->query("INSERT INTO website_accounts SET account_id=?d, registration_ip=?, activation_code=?",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key);
//                    $this->DB->query("INSERT INTO account_extend SET account_id=?d, registration_ip=?, activation_code=?, secretq1='".$account_extend['secretq1']."',secreta1='".$account_extend['secreta1']."',secretq2='".$account_extend['secretq2']."',secreta2='".$account_extend['secreta2']."'",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key);
                    //$this->DB->query("INSERT INTO account_extend SET account_id=?d, registration_ip=?, activation_code=?, secretq1=?s, secreta1=?s, secretq2=?s, secreta2=?s",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key,$account_extend['secretq1'], $account_extend['secreta1'], $account_extend['secretq2'], $account_extend['secreta2']);
                }
                if((int)$MW->getConfig->generic->use_purepass_table)
                    $this->DB->query("INSERT INTO account_pass SET id=?d, username=?, password=?, email=?",$acc_id,$params['username'],$password,$params['email']);
   	          //$this->DB->query("UPDATE account SET `tbc` = '1' WHERE `id`=$acc_id");
                return true;
            }
            else{
                return false;
            }
        }
    }

    function isavailableusername($username){
        $res = $this->DB->selectCell("SELECT count(*) FROM account WHERE username=?",$username);
        if($res < 1) return true; // username is available
        return false; // username is not available
    }

    function isavailableemail($email){
        $res = $this->DB->selectCell("SELECT count(*) FROM account WHERE email=?",$email);
        if($res < 1) return true; // email is available
        return false; // email is not available
    }
    function isvalidemail($email){
        if(preg_match('#^.{1,}@.{2,}\..{2,}$#', $email)==1){
            return true; // email is valid
        }else{
            return false; // email is not valid
        }
    }
    function isvalidregkey($key){
        $res = $this->DB->selectCell("SELECT count(*) FROM site_regkeys WHERE `key`=?",$key);
        if($res > 0) return true; // key is valid
        return false; // key is not valid
    }
    function isvalidactkey($key){
        $res = $this->DB->selectCell("SELECT account_id FROM website_accounts WHERE activation_code=?",$key);
        if($res > 0) return $res; // key is valid
        return false; // key is not valid
    }
    function generate_key()
    {
        $str = microtime(1);
        return sha1(base64_encode(pack("H*", md5(utf8_encode($str)))));
    }
    function generate_keys($n)
    {
        set_time_limit(600);
        for($i=1;$i<=$n;$i++)
        {
            if($i>1000)exit;
            $keys[] = $this->generate_key();
            $slt = rand(15000, 500000);
            usleep($slt);
            //sleep(1);
        }
        return $keys;
    }
    function delete_key($key){
        $this->DB->query("DELETE FROM website_regkeys WHERE `key`=?",$key);
    }
    function getprofile($acct_id=false){
        $res = $this->DB->selectRow("
            SELECT * FROM account
            LEFT JOIN website_accounts ON account.id=website_accounts.account_id
            LEFT JOIN website_account_groups ON website_accounts.g_id=website_account_groups.g_id
            WHERE id=?d",$acct_id);
        return RemoveXSS($res);
    }
    function getgroup($g_id=false){
        $res = $this->DB->selectRow("SELECT * FROM website_account_groups WHERE g_id=?d",$g_id);
        return $res;
    }
    function parsesettings($str){
        $set_pre = explode("\n",$str);
        foreach($set_pre as $set_str){$set_str_arr = explode('=',$set_str); $set[$set_str_arr[0]] = $set_str_arr[1]; }
        return $set;
    }
    function getlogin($acct_id=false){
        $res = $this->DB->selectCell("SELECT username FROM account WHERE id=?d",$acct_id);
        if($res == null) return false;  // no such account
        return $res;
    }
    function getid($acct_name=false){
        $res = $this->DB->selectCell("SELECT id FROM account WHERE username=?",$acct_name);
        if($res == null) return false;  // no such account
        return $res;
    }
    function gethash($str=false){
        if($str)return sha1(base64_encode(md5(utf8_encode($str)))); // Returns 40 char hash.
        else return false;
    }

    // ONLINE FUNCTIONS //
    function onlinelist_update()  // Updates list & delete old
    {
        $GLOBALS['guests_online']=0;
        $rows = $this->DB->select("SELECT * FROM `website_online`");
        if ($rows->num)
        foreach($rows as $result_row)
        {
            if(time()-$result_row['logged'] <= 60*10)
            {
                if($result_row['user_id']>0){
                  $GLOBALS['users_online'][] = $result_row['user_name'];
                }else{
                  $GLOBALS['guests_online']++;
                }
            }
            else
            {
                $this->DB->query("DELETE FROM `website_online` WHERE `id`=? LIMIT 1",$result_row['id']);
            }
        }
        //db_query("UPDATE `acm_config` SET `val`='".time()."' WHERE `key`='last_onlinelist_update' LIMIT 1");
        // update_settings('last_onlinelist_update',time());
    }

    function onlinelist_add() // Add or update list with new user
    {
        global $user;
        global $__SERVER;

        $cur_time = time();
        $result = $this->DB->selectCell("SELECT count(*) FROM `website_online` WHERE `user_id`=?",$this->user['id']);
        if($result>0)
        {
            $this->DB->query("UPDATE `website_online` SET `user_ip`=?,`logged`=?,`currenturl`=? WHERE `user_id`=? LIMIT 1",$this->user['ip'],$cur_time,$__SERVER['REQUEST_URI'],$this->user['id']);
        }
        else
        {
            $this->DB->query("INSERT INTO `website_online` (`user_id`,`user_name`,`user_ip`,`logged`,`currenturl`) VALUES (?,?,?,?,?)",$this->user['id'],$this->user['username'],$this->user['ip'],$cur_time,$__SERVER['REQUEST_URI']);
        }
    }

    function onlinelist_del() // Delete user from list
    {
        global $user;
        $this->DB->query("DELETE FROM `website_online` WHERE `user_id`=? LIMIT 1",$this->user['id']);
    }

    function onlinelist_addguest() // Add or update list with new guest
    {
        global $user;
        global $__SERVER;

        $cur_time = time();
        $result = $this->DB->selectCell("SELECT  count(*) FROM `website_online` WHERE `user_id`='0' AND `user_ip`=?",$this->user['ip']);
        if($result>0)
        {
            $this->DB->query("UPDATE `website_online` SET `user_ip`=?,`logged`=?,`currenturl`=? WHERE `user_id`='0' AND `user_ip`=? LIMIT 1",$this->user['ip'],$cur_time,$__SERVER['REQUEST_URI'],$this->user['ip']);
        }
        else
        {
            $this->DB->query("INSERT INTO `website_online` (`user_ip`,`logged`,`currenturl`) VALUES (?,?,?)",$this->user['ip'],$cur_time,$__SERVER['REQUEST_URI']);
        }
    }

    function onlinelist_delguest() // Delete guest from list
    {
        global $user;
        $this->DB->query("DELETE FROM `website_online` WHERE `user_id`='0' AND `user_ip`=? LIMIT 1",$this->user['ip']);
    }
}
?>
