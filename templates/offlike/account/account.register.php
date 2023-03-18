<div align="right" style="z-index:2;position:relative;"><img src="<?php echo $currtmp; ?>/images/wowlogo2.gif" style="margin-top:-82px;padding-right:8px;"></div>
<div align="right" style="z-index:1;position:relative;"><img src="<?php echo $currtmp; ?>/images/account-creation.gif" style="margin-top:-30px;"></div>
<form name="createaccount" method="post" action="index.php?n=account&amp;sub=register" onsubmit="javascript:ca_valid();">
    <input type=hidden name="update" value="">
    <input type=hidden name="save" value="">
    <input type=hidden name="step" value="">
<?php
    if(isset($_POST['step']) && $_POST['step'] == 5 && $allow_reg === true)
    {
      if($reg_succ === true){
        if((int)$MW->getConfig->generic->req_reg_act){
          echo $lang['email_sent_act'];
        }else{
          echo $lang['reg_succ'].'<meta http-equiv=refresh content="3;url='.$MW->getConfig->temp->site_href.'">';
        }
      }
    }
    elseif(isset($_POST['step']) && $_POST['step'] == 4 && $allow_reg === true)
    {
?>
<script type="text/javascript">
<!--
var MIN_LOGIN_L = <?php echo $regparams['MIN_LOGIN_L']; ?>;
var MAX_LOGIN_L = <?php echo $regparams['MAX_LOGIN_L']; ?>;
var MIN_PASS_L  = <?php echo $regparams['MIN_PASS_L']; ?>;
var MAX_PASS_L  = <?php echo $regparams['MAX_PASS_L']; ?>;
var SUCCESS = false;
function check_login(){
    if (!document.regform.r_login.value || document.regform.r_login.value.length > MAX_LOGIN_L || document.regform.r_login.value.length < MIN_LOGIN_L || !document.regform.r_login.value.match(/^[A-Za-z0-9_]+$/)) {
        $('t_login').innerHTML ='<?php echo sprintf($lang['reg_checklogin'],$regparams['MIN_LOGIN_L'],$regparams['MAX_LOGIN_L']) ?>!';
        $('t_login').show();
        SUCCESS = false;
    } else {
        $('t_login').hide();
        try
        {
            var request = new Ajax.Request(
                SITE_HREF+'index.php?n=ajax&sub=checklogin&nobody=1&ajaxon=1',
                {
                    method: 'get',
                    parameters: 'q=' + encodeURIComponent($F('r_login')),
                    onSuccess: function(reply){
                        if (reply.responseText == 'false') {
                            $('t_login').innerHTML ='<?php Lang('reg_checkloginex');?>!';
                            $('t_login').show();
                            SUCCESS = false;
                        } else {
                            SUCCESS = true;
                        }
                    }
                }
            );
        }
        catch (e)
        {
            alert('Error: ' + e.toString());
        }
    }
}
function check_pass(){
    if (!document.regform.r_pass.value || document.regform.r_pass.value.length > MAX_PASS_L || document.regform.r_pass.value.length < MIN_PASS_L) {
        $('t_pass').innerHTML = '<?php echo sprintf($lang['reg_checkpass'],$regparams['MIN_PASS_L'],$regparams['MAX_PASS_L']) ?>!';
        $('t_pass').show();
        SUCCESS = false;
    } else {
        $('t_pass').hide();
        SUCCESS = true;
    }
}
function check_cpass(){
    if (!document.regform.r_cpass.value || document.regform.r_pass.value!=document.regform.r_cpass.value) {
        $('t_cpass').innerHTML ='<?php Lang('reg_checkcpass');?>!';
        $('t_cpass').show();
        SUCCESS = false;
    } else {
        $('t_cpass').hide();
        SUCCESS = true;
    }
}
function check_email(){
    if (document.regform.r_email.value.length < 1 || !document.regform.r_email.value.match(/^[A-Za-z0-9_\-\.]+\@[A-Za-z0-9_\-\.]+\.\w+$/)) {
        $('t_email').innerHTML ='<?php Lang('reg_checkemail');?>!';
        $('t_email').show();
        SUCCESS = false;
    } else {
        $('t_email').hide();
        try
        {
            var request = new Ajax.Request(
                SITE_HREF+'index.php?n=ajax&sub=checkemail&nobody=1&ajaxon=1',
                {
                    method: 'get',
                    parameters: 'q=' + encodeURIComponent($F('r_email')),
                    onComplete: function(reply){
                        if (reply.responseText == 'false') {
                            $('t_email').innerHTML ='<?php Lang('reg_checkemailex');?>!';
                            $('t_email').show();
                            SUCCESS = false;
                        } else {
                            SUCCESS = true;
                        }
                    }
                }
            );
        }
        catch (e)
        {
            alert('Error: ' + e.toString());
        }
    }
}
function check_all(){
    check_login();
    check_pass();
    check_cpass();
    check_email();
    return SUCCESS;
}
// -->
</script>
<style media="screen" title="currentStyle" type="text/css">
p.nm, p.wm { 
        margin: 0.5em 0 0.5em 0; 
        padding: 3px; }
        
    p.nm { 
        background-color: #FEF5DA; 
        border-right: 1px solid #D0CBAF;
        border-bottom: 1px solid #D0CBAF; 
        color: #605033; }
    
    p.wm { 
        background-color: #FBD8D7; 
        border-right: 1px solid #DCBFB4;
        border-bottom: 1px solid #DCBFB4; 
        color: #6A0D0B; }
#regform label {
    display: block;
    margin-top: 1em;
    font-weight: bold;
}
p.nm, p.wm { 
    margin: 0px;
    margin-top: 3px;
}
</style>
    <div style="padding-left:8px; padding-right: 14px">
      <form method="post" action="index.php?n=account&amp;sub=register" name="regform" id="regform" onsubmit="return check_all();">
        <input type="hidden" name="r_key" value="<?php echo $_POST['r_key'];?>"/>
        <input type="hidden" name="step" value="3"/>

        <label for="r_login"><?php echo $lang['username'];?>:</label>
        <input type="text" id="r_login" name="r_login" size="40" maxlength="16" onblur="check_login();"/>
        <p id="t_login" style="display:none;" class="wm"></p>

        <label for="r_pass"><?php echo $lang['pass'];?>:</label>
        <input type="password" id="r_pass" name="r_pass" size="40" maxlength="16" onblur="check_pass();"/>
        <p id="t_pass" style="display:none;" class="wm"></p>

        <label for="r_cpass"><?php echo $lang['cpass'];?>:</label>
        <input type="password" id="r_cpass" name="r_cpass" size="40" maxlength="16" onblur="check_cpass();"/>
        <p id="t_cpass" style="display:none;" class="wm"></p>

        <label for="r_email"><?php echo $lang['email'];?>:</label>
        <input type="text" id="r_email" name="r_email" size="40" maxlength="50" onblur="check_email();"/>
        <p id="t_email" style="display:none;" class="wm"></p>

		<?php if ((int)$MW->getConfig->generic_values->account_registrer->secret_questions_input == 0): ?>

		<label for="secretq1"><?php echo $lang['secretq']; ?> 1:</label>
        Q: <select id="secretq1" name="secretq1">
            <option value="Disabled">Disabled</option>
            <?php foreach ($MW->getConfig->secret_questions->question as $question): ?>
            <option value="<?php echo htmlspecialchars($question); ?>"><?php echo $question; ?></option>
            <?php endforeach; ?>
        </select><br />
        A: <input type="hidden" id="secreta1" name="secreta1" size="40" maxlength="50"/>

        <label for="secretq2"><?php echo $lang['secretq']; ?> 2:</label>
        Q: <select id="secretq2" name="secretq2">
            <option value="Disabled">Disable</option>
            <?php foreach ($MW->getConfig->secret_questions->question as $question): ?>
            <option value="<?php echo htmlspecialchars($question); ?>"><?php echo $question; ?></option>
            <?php endforeach; ?>
        </select><br />
        A: <input type="hidden" id="secreta2" name="secreta2" size="40" maxlength="50"/>
        
        <?php endif; ?>

        <?php if ((int)$MW->getConfig->generic_values->account_registrer->secret_questions_input): ?>
        <label for="secretq1"><?php echo $lang['secretq']; ?> 1:</label>
        Q: <select id="secretq1" name="secretq1">
            <option value="0">None</option>
            <?php foreach ($MW->getConfig->secret_questions->question as $question): ?>
            <option value="<?php echo htmlspecialchars($question); ?>"><?php echo $question; ?></option>
            <?php endforeach; ?>
        </select><br />
        A: <input type="text" id="secreta1" name="secreta1" size="40" maxlength="50"/>

        <label for="secretq2"><?php echo $lang['secretq']; ?> 2:</label>
        Q: <select id="secretq2" name="secretq2">
            <option value="0">None</option>
            <?php foreach ($MW->getConfig->secret_questions->question as $question): ?>
            <option value="<?php echo htmlspecialchars($question); ?>"><?php echo $question; ?></option>
            <?php endforeach; ?>
        </select><br />
        A: <input type="text" id="secreta2" name="secreta2" size="40" maxlength="50"/>
        <?php endif; ?>

        <label for="r_account_type"><?php echo $lang['exp_select']; ?>:</label>
        <select id="r_account_type" name="r_account_type">
        <option selected="selected" value="2"><?php echo $lang['wotlk'];?></option>
		<option value="1"><?php echo $lang['tbc'];?></option>
        <option value="0"><?php echo $lang['classic'];?></option>
        </select><br /><br />

        <?php
        if ((int)$MW->getConfig->generic_values->account_registrer->enable_image_verfication):
        
        // Initialize random image:
        $captcha=new Captcha;
        $captcha->load_ttf();
        $captcha->make_captcha();
        $captcha->delold();
        $filename=$captcha->filename;
        $privkey=$captcha->privkey;
        $DB->query("INSERT INTO `website_captcha`(filename, acc_creation_captcha.key) VALUES('$filename','$privkey')");
        ?>
        <img src="<?php echo $filename; ?>" alt=""/><br />
        <input type="hidden" name="filename_image" value="<?php echo $filename; ?>"/>
        <b>Type letters above (6 characters)</b>
        <br />
        <input type="text" name="image_key"/><br />
        <?php endif; ?>
        
        <br />
        <input type="submit" class="button" value="<?php lang('register');?>"/>
      </form>
    </div>
<?php
}
elseif(isset($_POST['step']) && $_POST['step'] == "verifyaccount" && $allow_reg === true)
{
?>
        <script type="text/javascript">
            function ca_valid() {
                document.createaccount.step.value="save";
                document.createaccount.update.value="";
                document.createaccount.save.value="";
                return true;
            }
        </script>
        <table align="center" cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
            <tr>

                <td width = "60%" style = "background-image: url('<?php echo $currtmp; ?>/images/frame-left-bg.gif'); background-repeat: repeat-y;" bgcolor = "#E0BC7E">

                    <table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('new-hp/images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
                        <tr>
                            <td width = "100%" rowspan = "2">
                                <div style = "position: relative;">

                                    <div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('<?php echo $currtmp; ?>/images/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
                                        <div style = "padding:5px; background-image: url('<?php echo $currtmp; ?>/images/header-gradiant.jpg'); background-repeat: no-repeat;">
                                            <h3 class="title">Step 5 - Account Verification</h3>
                                            <p>
                                                    <table align="center" border=0 cellspacing=0 cellpadding=0><tr><td><img src="<?php echo $currtmp; ?>/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"><td><td><img src="<?php echo $currtmp; ?>/images/navbar/step1b.gif" width="74" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step2b.gif" width="73" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step3b.gif" width="73" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step4b.gif" width="74" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step5c.gif" width="74" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/right-end.gif" width="13" height="45" alt="" border="0"></td></tr></table>

                                            <p>
                                            <table width = "520">
                                                <tr>
                                                    <td>
			<span>
			<img src = "<?php echo $currtmp; ?>/images/twoheaded-ogre.jpg" width = "180" height = "138" align = "right">

			<img src = "<?php echo $currtmp; ?>/images/letters/P.gif" width = "40" height = "38" align = "left">lease take a moment to verify that all of the information below is accurate. If you need to make changes, click the Update Information link below to do so. Once the information below is accurate, click Create Account to proceed.<br><br>


                                                </tr></td></table>

                                            <img src = "<?php echo $currtmp; ?>/images/hr.gif" width = "450" height = "1">

                                            <p>

                                                <table><tr><td>
                                                            <table border=0 cellspacing=0 cellpadding=0 width = "100%"><tr><td valign = "top">
                                                                        <table width = "100%"><tr><td><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
                                                                                        <tr>
                                                                                            <td width = "24"><img src = "<?php echo $currtmp; ?>/images/subheader-left-sword.gif" width = "24" height = "20"></td>

                                                                                            <td width = "100%" bgcolor = "#05374A"><b class = "white">Account Details:</b></td>
                                                                                            <td width = "10"><img src = "<?php echo $currtmp; ?>/images/subheader-right.gif" width = "10" height = "20"></td>
                                                                                        </tr>
                                                                                    </table></td></table>
                                                                        <table width = "260" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
                                                                                    <table width = "100%" style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/parch-light2.jpg');"><tr><td align = "right">
                                                                                                <table border=0 cellspacing=1 cellpadding=2 width = "100%">
                                                                                                    <tr>
                                                                                                        <td width=125 align=right  class = "bevel" NOWRAP><span>Account Name:</span></td>
                                                                                                        <td width = "145" align=left  bgcolor = "#E5CDA1" NOWRAP><b><span><?php echo $_SESSION['CA_u']; ?></span><b></td>

                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td width=125 align=right  class = "bevel" NOWRAP><span>Account Password:</span></td>
                                                                                                        <td width = "120" align=left  bgcolor = "#E5CDA1" NOWRAP><span><?php
                                                                                                                for ($i=0;$i<strlen($_SESSION['CA_p']);$i++){
                                                                                                                    echo "*";
                                                                                                                }
                                                                                                                ?></span></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td width=125 align=right  class = "bevel" NOWRAP><span>Password Question:</span></td>
                                                                                                        <td width = "120" align=left  bgcolor = "#E5CDA1" NOWRAP>
                                                                                                                <span>
                                                                                                                <?php $num = 1; foreach ($MW->getConfig->secret_questions->question as $question):
                                                                                                                if ($num == $_SESSION['CA_ask']) {echo $question; break;} ++$num;
                                                                                                                endforeach; ?>
                                                                                                    </span></td>
                                                                                                    </tr>

                                                                                                    <tr>
                                                                                                        <td width=125 align=right  class = "bevel" NOWRAP><span>Password Answer:</span></td>
                                                                                                        <td width = "120" align=left  bgcolor = "#E5CDA1" NOWRAP><span><?php echo $_SESSION['CA_ans']; ?></span></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td width=125 align=right  class = "bevel" NOWRAP><span>Expansion:</span></td>
                                                                                                        <td width = "120" align=left  bgcolor = "#E5CDA1" NOWRAP><span><?php if ($_SESSION['CA_tbc']=='32') { echo 'Wrath of the Lich King'; } if ($_SESSION['CA_tbc']=='1') { echo 'Burning Crusade'; } else { echo 'None'; } ?></span></td>
                                                                                                    </tr>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td align = "right" colspan="2">

                                                                                                            <table border=0 cellspacing=0 cellpadding=0>
                                                                                                                <tr>
                                                                                                                    <td><img src = "<?php echo $currtmp; ?>/images/pixel.gif" width = "231" height = "1"></td>

                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td align = "right">
                                                                                                                        <table border=0 cellspacing=0 cellpadding=0>
                                                                                                                            <tr>
                                                                                                                                <td><small class = "tiny"><a href="#" onclick="javascript:document.createaccount.step.value='accountinfo'; javascript:document.createaccount.update.value='accountinfo2'; javascript:createaccount.submit()"><img src = "<?php echo $currtmp; ?>/images/edit-button.gif" width = "16" height = "18" border = "0"></a></td>
                                                                                                                                <td><small class = "tiny">&nbsp;</span></td><td><small class = "tiny"><a href="#" onclick="javascript:document.createaccount.step.value='accountinfo'; javascript:document.createaccount.update.value='accountinfo2'; javascript:createaccount.submit()">Update Information</a></span></td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>

                                                                                                                </tr>
                                                                                                            </table>


                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>


                                                                                            </td></tr></table>
                                                                                </td></tr></table>

                                                                    </td>
                                                                    <td width = "5"><img src = "<?php echo $currtmp; ?>/images/pixel.gif" width = "5" height = "1"></td>
                                                                    <td valign = "top">
                                                                        <table width = "100%"><tr><td><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
                                                                                        <tr>

                                                                                            <td width = "24"><img src = "<?php echo $currtmp; ?>/images/subheader-left-sword.gif" width = "24" height = "20"></td>
                                                                                            <td width = "100%" bgcolor = "#05374A"><b class = "white">Contact Info:</b></td>
                                                                                            <td width = "10"><img src = "<?php echo $currtmp; ?>/images/subheader-right.gif" width = "10" height = "20"></td>
                                                                                        </tr>
                                                                                    </table></td></table>

                                                                        <table width = "100%" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
                                                                                    <table width = "100%" style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/parch-light2.jpg');"><tr><td>
                                                                                                <table border=0 cellspacing=1 cellpadding=2 width = "100%">
                                                                                                    <tr>

                                                                                                        <td align=left valign=top bgcolor = "#E5CDA1">
                                                                                                            <img src = "<?php echo $currtmp; ?>/images/pixel.gif" width = "1" height = "83" align = "right">
                                                                                                            <span>
					<b class = "smallBold">
<?php echo $_SESSION['CA_fname']; ?> <?php echo $_SESSION['CA_lname']; ?>
					</b><br>
<?php echo $_SESSION['CA_city']; ?>, <?php echo $COUNTRY[$_SESSION['CA_lo']]; ?><br>

<?php if ($_SESSION['CA_bd']!='0000-00-00') { echo $_SESSION['CA_bd']; } ?><br>

<a href = "mailto:<?php echo $_SESSION['CA_em']; ?>"><?php echo $_SESSION['CA_em']; ?></a>
					</span>

                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td align = "right">

                                                                                                            <table border=0 cellspacing=0 cellpadding=0>

                                                                                                                <tr>
                                                                                                                    <td><img src = "<?php echo $currtmp; ?>/images/pixel.gif" width = "200" height = "1"></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td align = "right">
                                                                                                                        <table border=0 cellspacing=0 cellpadding=0>
                                                                                                                            <tr>
                                                                                                                                <td><a href="#" onclick="javascript:document.createaccount.step.value='userinfo'; javascript:document.createaccount.update.value='userinfo2'; javascript:createaccount.submit()"><img src = "<?php echo $currtmp; ?>/images/edit-button.gif" width = "16" height = "18" border = "0"></a></td>
                                                                                                                                <td><small class = "tiny">&nbsp;</span></td><td><small class = "tiny"><a href="#" onclick="javascript:document.createaccount.step.value='userinfo'; javascript:document.createaccount.update.value='userinfo2'; javascript:createaccount.submit()">Update Information</a></span></td>

                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>


                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>

                                                                                            </td></tr></table>
                                                                                </td></tr></table>


                                                                    </td></tr></table>


                                            </center>
                                            <p>

                                                <center>

                                            <p>

                                                </center>

                            </td></tr></table>
                    <center>

                        <table cellspacing = "0" cellpadding = "0" border = "0">
                            <tr>
                                <td width="174">
                                    <!-- CREATE ACCOUNT--><input TYPE="image" SRC="<?php echo $currtmp; ?>/images/createaccount-button.gif" NAME="submit" alt="Create Account" Width="174" Height="46" Border=0 class="button"   taborder=5>
                                </td>
                            </tr>
                        </table>


                    </center>

                    <img src = "<?php echo $currtmp; ?>/images/pixel.gif" width = "500" height = "1">
                    </div>
                    </div>

                </td>
            </tr>
        </table>

        </td>
        </tr>
        </table>
<?php
}
elseif(isset($_POST['step']) && $_POST['step'] == "accountinfo" && $allow_reg === true)
{
?>
    <script type="text/javascript">
        function ca_valid() {

            if (document.createaccount.update.value=="accountinfo") {
                document.createaccount.step.value="verifyaccount";
            } else if (document.createaccount.update.value=="accountinfo2") {
                document.createaccount.step.value="verifyaccount";
            } else {
                document.createaccount.step.value="verifyaccount";
                document.createaccount.update.value="accountinfo";
            }
            document.createaccount.save.value="true";

            return true;
        }
    </script>
    <table align="center" cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
        <tr>

            <td width = "60%" style = "background-image: url('<?php echo $currtmp; ?>/images/frame-left-bg.gif'); background-repeat: repeat-y;" bgcolor = "#E0BC7E">

                <table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('new-hp/images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
                    <tr>
                        <td width = "100%" rowspan = "2">


                            <div style = "position: relative;">

                                <div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('<?php echo $currtmp; ?>/images/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
                                    <div style = "padding:5px; background-image: url('<?php echo $currtmp; ?>/images/header-gradiant.jpg'); background-repeat: no-repeat;">


                                        <h3 class="title">Step 4 - Account Creation</h3>
                                        <p>
                                                <table align="center" border=0 cellspacing=0 cellpadding=0><tr><td><img src="<?php echo $currtmp; ?>/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"><td><td><img src="<?php echo $currtmp; ?>/images/navbar/step1b.gif" width="74" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step2b.gif" width="73" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step3b.gif" width="73" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step4c.gif" width="74" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step5a.gif" width="74" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/right-end.gif" width="13" height="45" alt="" border="0">
                                                        </td></tr></table>

                                        <p>

                                            <table width = "520">
                                                <tr>
                                                    <td>

				<span>
					<img src = "<?php echo $currtmp; ?>/images/orc2.jpg" width = "170" height = "280" align = "right">

					<img src = "<?php echo $currtmp; ?>/images/letters/I.gif" width = "40" height = "38" align = "left">n this step you will choose a unique <b>Name</b> and <b>Password</b> for your World of Warcraft Account.
                                        <p>

                                            <img src = "<?php echo $currtmp; ?>/images/pixel.gif" width = "10" height = "200" align = "left">

                                        <table cellspacing = "0" cellpadding = "0" border = "0" width = "305">
                                            <tr>
                                                <td width = "24"><img src = "<?php echo $currtmp; ?>/images/subheader-left-sword.gif" width = "24" height = "20"></td>
                                                <td width = "100%" bgcolor = "#05374A"><b class = "white">Account Name Rules:</b></td>
                                                <td width = "10"><img src = "<?php echo $currtmp; ?>/images/subheader-right.gif" width = "10" height = "20"></td>
                                            </tr>
                                        </table>

                                        <!--PlainBox Top-->
                                        <table cellspacing = "0" cellpadding = "0" border = "0" width = "305">
                                            <tr>
                                                <td><img src = "<?php echo $currtmp; ?>/images/plainbox-top-left.gif" width = "3" height = "3" border = "0"></td><td background = "<?php echo $currtmp; ?>/images/plainbox-top.gif"></td><td><img src = "<?php echo $currtmp; ?>/images/plainbox-top-right.gif" width = "3" height = "3" border = "0"></td></tr><tr><td background = "<?php echo $currtmp; ?>/images/plainbox-left.gif"></td><td bgcolor = "#CDB68E">
                                                    <!--PlainBox Top-->
                                                    <span>

								<ul><li>May only contain alphanumeric characters, such as A-Z, 0-9.<li>Must be between two and sixteen characters in length.
								</span>
                                                    <!--PlainBox Bottom-->
                                                </td><td background = "<?php echo $currtmp; ?>/images/plainbox-right.gif"></td></tr><tr><td><img src = "<?php echo $currtmp; ?>/images/plainbox-bot-left.gif" width = "3" height = "3" border = "0"></td><td background = "<?php echo $currtmp; ?>/images/plainbox-bot.gif"></td><td><img src = "<?php echo $currtmp; ?>/images/plainbox-bot-right.gif" width = "3" height = "3" border = "0"></td></tr></table>
                                        <!--PlainBox Bottom-->
                                        <br>
                                        <table cellspacing = "0" cellpadding = "0" border = "0" width = "305">
                                            <tr>
                                                <td width = "24"><img src = "<?php echo $currtmp; ?>/images/subheader-left-sword.gif" width = "24" height = "20"></td>
                                                <td width = "100%" bgcolor = "#05374A"><b class = "white">Password Rules:</b></td>
                                                <td width = "10"><img src = "<?php echo $currtmp; ?>/images/subheader-right.gif" width = "10" height = "20"></td>
                                            </tr>

                                        </table>


                                        <!--PlainBox Top-->
                                        <table cellspacing = "0" cellpadding = "0" border = "0" width = "305"><tr><td><img src = "<?php echo $currtmp; ?>/images/plainbox-top-left.gif" width = "3" height = "3" border = "0"></td><td background = "<?php echo $currtmp; ?>/images/plainbox-top.gif"></td><td><img src = "<?php echo $currtmp; ?>/images/plainbox-top-right.gif" width = "3" height = "3" border = "0"></td></tr><tr><td background = "<?php echo $currtmp; ?>/images/plainbox-left.gif"></td><td bgcolor = "#CDB68E">
                                                    <!--PlainBox Top-->
                                                    <span>
										<ul><li>Must be between two and sixteen characters in length.<li>May only contain alphanumeric characters and punctuation, such as A-Z, 0-9.</li><li>Must differ from your Account Name.
										</span>
                                                    <!--PlainBox Bottom-->
                                                </td><td background = "<?php echo $currtmp; ?>/images/plainbox-right.gif"></td></tr><tr><td><img src = "<?php echo $currtmp; ?>/images/plainbox-bot-left.gif" width = "3" height = "3" border = "0"></td><td background = "<?php echo $currtmp; ?>/images/plainbox-bot.gif"></td><td><img src = "<?php echo $currtmp; ?>/images/plainbox-bot-right.gif" width = "3" height = "3" border = "0"></td></tr></table>
                                        <!--PlainBox Bottom-->
                                        <p>
                                            After creating an Account Name, please choose a Password Hint from the drop-down menu, and type the appropriate answer in the Answer box. This will be used to recover your account if you forget your password.

                                            </span>
                        </td>
                    </tr>
                </table>
                <p>

                    <br>
                        <table align="center" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
                            <tr>
                                <td>
                                    <table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/parch-light2.jpg');">
                                        <tr>
                                            <td>
                                                <table border=0 cellspacing=0 cellpadding=4 width = "510">
                                                    <tr>
                                                        <td colspan = "3">
																<span>

															<center><img src = "<?php echo $currtmp; ?>/images/hr.gif" width = "450" height = "1"></center>
															<br>
																</span>
                                                        </td>

                                                    </tr>
                                                    <tr>

                                                        <td align=right NOWRAP><span><b>Account Name:</b></span></td>

                                                        <td align=left NOWRAP>
                                                            <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="u" MaxLength=16 width=150 taborder="1" value="" taborder=1/></td><td valign = "top">


                                                                    </td></tr></table>
                                                        </td>


                                                    </tr>
                                                    <tr>
                                                        <td align=right NOWRAP><span><b>Account Password:</b></span></td>

                                                        <td align=left>
                                                            <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="p" MaxLength=16 width=150 type=Password taborder="2" taborder=2 /></td><td valign = "top">

                                                                    </td></tr></table>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td align=right><span><b>Verify Password:</b></span></td>

                                                        <td align=left>
                                                            <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="cp" MaxLength=16 width=150 type=Password taborder="3" /></td><td valign = "top">


                                                                    </td></tr></table>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan = "3">
																<span>
															<br>
															<center><img src = "<?php echo $currtmp; ?>/images/hr.gif" width = "450" height = "1"></center>

																</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan = "3">
																<span>
															<center><img src = "<?php echo $currtmp; ?>/images/hr.gif" width = "450" height = "1"></center>
															<br>
																</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td align=right NOWRAP><span><b>Password Hint:</b></span><br></td>


                                                        <td align=left NOWRAP>
                                                            <table border=0 cellspacing=0 cellpadding=0><tr><td>
                                                                        <select name="ask" taborder=4>
                                                                            <option value="" selected disabled hidden>Please Select A Secret Question</option>
                                                                            <?php $num = 1; foreach ($MW->getConfig->secret_questions->question as $question): ?>
                                                                                <option value="<?php echo $num; ++$num;?>"><?php echo $question; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>

                                                                    </td><td valign = "top">

                                                                    </td></tr></table>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=right NOWRAP><span><b>Answer:</b></span></td>

                                                        <td align=left NOWRAP>
                                                            <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="ans" MaxLength=32 width=150 taborder="5" value="" taborder=5/></td><td valign = "top">
                                                                    </td></tr></table>
                                                    </tr>
                                                    <tr>
                                                        <td colspan = "3">
																	<span>

																	<span>
																	<b>Note:</b> This answer to your Secret Question is the ONLY way you can receive an automated password reset.  Please ensure you use an answer that you will remember-- if you are unable to match this answer exactly in the future, you may be unable to recover your account password if it becomes lost or stolen!
																	</span>

                <P>
                <center><img src = "<?php echo $currtmp; ?>/images/hr.gif" width = "450" height = "1"></center>

                </span>
            </td>

        </tr>
        <tr>
            <td colspan = "3">
																			<span>
																		<center><img src = "<?php echo $currtmp; ?>/images/hr.gif" width = "450" height = "1"></center>
																		<br>
																			</span>
            </td>

        </tr>
        <tr>
            <td align=right NOWRAP><span><b>Expansion:</b></span></td>

            <td align=left NOWRAP>
                <table border=0 cellspacing=0 cellpadding=0><tr><td><lable for='upgtbc2'><input type=radio value='0' id="upgtbc2" name="uptbc" CHECKED> World of Warcraft</label></td><td valign = "top">
                        </td></tr></table></td>
        </tr>
        <?php
        if ((int)$GLOBALS['expansion'] > 0) { ?>
        <tr>
            <td align=right NOWRAP><span><b>Expansion:</b></span></td>

            <td align=left NOWRAP>
                <table border=0 cellspacing=0 cellpadding=0><tr><td><lable for='upgtbc1'><input type=radio value='1' id="upgtbc1" name="uptbc" CHECKED> The Burning Crudades</label></td><td valign = "top">
                        </td></tr></table></td>
        </tr>
        <?php } ?>
        <?php
        if ((int)$GLOBALS['expansion'] > 1) { ?>
        <tr>
            <td align=right NOWRAP><span><b>Expansion:</b></span></td>

            <td align=left NOWRAP>
                <table border=0 cellspacing=0 cellpadding=0><tr><td><label for='upgtbc'><input type=radio value='32' id="upgtbc" name="uptbc" CHECKED> Wrath of the Lich King</label></td><td valign = "top">
                        </td></tr></table></td>
        </tr>
        <?php } ?>

        <tr>

            <td colspan = "3">
                <p><span>

																				<center><img src = "<?php echo $currtmp; ?>/images/hr.gif" width = "450" height = "1"></center>
																				<br>
																			</span>
            </td>

        </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>

    <p>

    <table width = "520">
        <tr>
            <td><span><b class = "error">You will be asked for this Account Name and Password each time you login to play the game, so please write them down, keep them safe, and don&#39;t share them with anyone.</b> Please note that your Account Name is NOT your Character Name. You will create your Character Name when you log into the game with your Account and begin the character creation process.</span></td>
        </tr>
    </table>
    </center>
    <P>
    <center>
        <table cellspacing = "0" cellpadding = "0" border = "0">
            <tr>
                <td Width="91">
                    <?php if ($_POST['update']=="accountinfo2") { ?>
                    <!-- UPDATE --><input onclick='javascript:document.createaccount.update.value="accountinfo2";' src="<?php echo $currtmp; ?>/images/button-update.gif" name="submit" alt="Update" class="button" taborder="6" border="0" height="46" type="image" width="174"><br>
                    <!-- CANCEL -->	<a href="javascript:document.createaccount.step.value='verifyaccount'; javascript:document.createaccount.update.value='';  javascript:createaccount.submit()"><img src="<?php echo $currtmp; ?>/images/button-cancel.gif" alt="Cancel" class="button" taborder="7" border="0" height="46" width="174">
                        <?php } else { ?>
                        <!-- BACK-->		<a href="javascript:document.createaccount.save.value='false'; javascript:document.createaccount.step.value='userinfo'; javascript:document.createaccount.update.value='';  javascript:createaccount.submit()"><img src="<?php echo $currtmp; ?>/images/button-back.gif" alt="Back" Width="91" Height="46" Border=0 CSSclass="button" taborder=7></a>
                        <!-- CONTINUE --><td width="174"><input type="image" SRC="<?php echo $currtmp; ?>/images/continue-button.gif" NAME="submit" alt="Continue" Width="174" Height="46" Border=0 class="button"  taborder=6 >
                    <?php } ?>
                </td>
            </tr>
        </table>
    </center>
    <img src = "<?php echo $currtmp; ?>/images/pixel.gif" width = "500" height = "1">
    </div>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    <?php if ($err_array[1]) { ?>
    <script>
        document.createaccount.u.value='<?php echo $_POST['u']; ?>';
        document.createaccount.ask.value='<?php echo $_POST['ask']; ?>';
        document.createaccount.ans.value='<?php echo $_POST['ans']; ?>';
        document.createaccount.uptbc.checked=<?php echo $_POST['uptbc']; ?>;
    </script>

    <?php } else /*if ($_POST['update']=="accountinfo2")*/ { ?>
    <script>
        document.createaccount.u.value='<?php echo $_SESSION['CA_u']; ?>';
        document.createaccount.ask.value='<?php echo $_SESSION['CA_ask']; ?>';
        document.createaccount.ans.value='<?php echo $_SESSION['CA_ans']; ?>';
        document.createaccount.uptbc.checked=1<?php echo $_SESSION['CA_tbc']; ?>;
    </script>
    <?php } ?>

<?php
}
elseif(isset($_POST['step']) && $_POST['step'] == "userinfo" && $allow_reg === true)
{
?>
    <script type="text/javascript">
        function ca_valid() {

            if (document.createaccount.update.value=="userinfo") {
                document.createaccount.step.value="verifyaccount";
            } else if (document.createaccount.update.value=="userinfo2") {
                document.createaccount.step.value="verifyaccount";
            } else {
                document.createaccount.step.value="accountinfo";
                document.createaccount.update.value="userinfo";
            }
            <?php if ($_POST['update']=="userinfo2") { ?>
            document.createaccount.step.value="verifyaccount";
            <?php } ?>

            document.createaccount.save.value="true";

            return true;
        }
    </script>
    <table align="center" cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
        <tr>

            <td width = "60%" style = "background-image: url('<?php echo $currtmp; ?>/images/frame-left-bg.gif'); background-repeat: repeat-y;" bgcolor = "#E0BC7E">

                <table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('<?php echo $currtmp; ?>/images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
                    <tr>
                        <td width = "100%" rowspan = "2">


                            <div style = "position: relative;">

                                <div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('<?php echo $currtmp; ?>/images/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
                                    <div style = "padding:5px; background-image: url('<?php echo $currtmp; ?>/images/header-gradiant.jpg'); background-repeat: no-repeat;">


                                        <h3 class="title">Step 3 - Contact Information</h3>
                                        <p>
                                                <table align="center" border=0 cellspacing=0 cellpadding=0><tr><td><img src="<?php echo $currtmp; ?>/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"><td><td><img src="<?php echo $currtmp; ?>/images/navbar/step1b.gif" width="74" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step2b.gif" width="73" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step3c.gif" width="73" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step4a.gif" width="74" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/step5a.gif" width="74" height="45" alt="" border="0"></td><td><img src="<?php echo $currtmp; ?>/images/navbar/right-end.gif" width="13" height="45" alt="" border="0"></td></tr></table>

                                        <p>

                                            <table width = "520">
                                                <tr>
                                                    <td>

			<span>
                <img src = "<?php echo $currtmp; ?>/images/letters/P.gif" width = "40" height = "38" align = "left">lease enter your legal name and email address where you can be reached.  Please ensure that the name entered is an exact match to your legal identification.  For security purposes, we may require you to provide legal documentation verifying your identity.

                                        <p>

                                            <b>Fields marked with an <font color="#FF0000">*</font> are required.</b>

                                        <p>

                                            <a name = "address"></a>

                                            <table align="center" cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
                                                <tr>
                                                    <td width = "24"><img src = "<?php echo $currtmp; ?>/images/subheader-left-sword.gif" width = "24" height = "20"></td>
                                                    <td width = "100%" bgcolor = "#05374A"><b class = "white">Contact Address:</b></td>
                                                    <td width = "10"><img src = "<?php echo $currtmp; ?>/images/subheader-right.gif" width = "10" height = "20"></td>
                                                </tr>
                                            </table>

                                            <table align="center" width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
                                                        <table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/parch-light2.jpg');"><tr><td>
                                                                    <table border=0 cellspacing=0 cellpadding=4>

                                                                        <tr>
                                                                            <td width=200 align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
			      First Name:
			      </span></b></font>
                                                                            </td>
                                                                            <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="fname" MaxLength="32" style = "Width:200" taborder=1 /></td><td valign = "top">

                                                                                        </td></tr></table></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
			      Last Name:
			      </span></b></font>
                                                                            </td>

                                                                            <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="lname" MaxLength="32" style = "Width:200" taborder=2 /></td><td valign = "top">

                                                                                        </td></tr></table></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
			      City:
			      </span></b></font>
                                                                            </td>
                                                                            <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="city" MaxLength="32" style = "Width:150" taborder=5/ ></td><td valign = "top">

                                                                                        </td></tr></table></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>

			      Country:

			      </span></b></font>
                                                                            </td>
                                                                            <td align=left colspan = "2">
                                                                                <table border=0 cellspacing=0 cellpadding=2><tr>
                                                                                        <td><select name="lo" style="width: 150;" OnChange="javascript:document.createaccount.cflag.src = '<?php echo $currtmp; ?>/images/flags/' + this.value + '.gif';">
                                                                                                <?php
                                                                                                foreach ($COUNTRY as $key=>$value) {
                                                                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                                                                }
                                                                                                ?></selected>
                                                                                        </td>
                                                                                        <td><img name="cflag" src="<?php echo $currtmp; ?>/images/flags/00.gif"></td>
                                                                                    </tr></table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
				Show Location:<br>
				</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><select name="shlo"><option value=1 SELECTED>To Everyone<option value=0>Only To Administrators</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                </td></tr></table>
                                                    </td></tr></table>

                                        </>

                                        <p>

                                        <table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
                                            <tr>
                                                <td width = "24"><img src = "<?php echo $currtmp; ?>/images/subheader-left-sword.gif" width = "24" height = "20"></td>
                                                <td width = "100%" bgcolor = "#05374A"><b class = "white">Email Address:</b></td>
                                                <td width = "10"><img src = "<?php echo $currtmp; ?>/images/subheader-right.gif" width = "10" height = "20"></td>
                                            </tr>
                                        </table>

                                            <a align="center" name = "phone"></a>
                                            <table align="center" width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
                                                        <table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/parch-light2.jpg');"><tr><td>

                                                                    <table border=0 cellspacing=0 cellpadding=4 width = "100%">
                                                                        <tr>
                                                                            <td width=200 align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
			      Email:<br>
			      </span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><input name="em" MaxLength="250" Width=130 taborder=9 /></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
					Enable Email:<br>
					</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><select name="shem"><option value=1>For Everyone<option value=0 SELECTED>Only For Administrators</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                </td></tr></table>
                                                    </td></tr></table>
                                        <p>

                                        <table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
                                            <tr>
                                                <td width = "24"><img src = "<?php echo $currtmp; ?>/images/subheader-left-sword.gif" width = "24" height = "20"></td>
                                                <td width = "100%" bgcolor = "#05374A"><b class = "white">Forum Settings:</b></td>
                                                <td width = "10"><img src = "<?php echo $currtmp; ?>/images/subheader-right.gif" width = "10" height = "20"></td>
                                            </tr>
                                        </table>

                                            <a name = "phone"></a>
                                            <table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
                                                <tr>
                                                    <td>
                                                        <table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/parch-light2.jpg');">
                                                            <tr>
                                                                <td>
                                                                    <table border=0 cellspacing=0 cellpadding=4 width = "100%">
                                                                        <tr>
                                                                            <td width=200 align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												 <font color="#FF0000">*</font> Account Display-Name:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><input type=text name="nick" maxlength="16"></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												Birthday:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><input type=text name="bd" maxlength="10"></td><td>&nbsp;<span>(dd/mm/aaaa)</span></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												Show Birthday:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><select name="shbd"><option value=3>Date (dd/mm/yyyy), Age (X years)<option value=1>Date (dd/mm/yyyy)<option value=2 SELECTED>Age (X years)<option value=0>No</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												Gender:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><select name="gender"><option value="0">Female<option value="1" SELECTED>Male
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												Time Zone (GMT):<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left width=60%>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><select name="gmt" style="width: 250;">
                                                                                                <?php
                                                                                                for($i=-12;$i<count($GMT)-12;$i++) {
                                                                                                    echo '<option value="'.$i.'">(GMT '.$GMT[$i][0].') '.$GMT[$i][1].'</option>';
                                                                                                }
                                                                                                ?>
                                                                                            </select></td>
                                                                                        <script type="text/javascript">
                                                                                            document.createaccount.gmt.value='0';
                                                                                        </script>
                                                                                        </selected>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												Enable Private Messages:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><select name="shpm"><option value=1 SELECTED>For Everyone<option value=0>Only From Administrators
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												MSN:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><input type=text name="msn"></td><td>&nbsp;<img src="<?php echo $currtmp; ?>/images/im/im_msn.gif"></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												Skype:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><input type=text name="skype"></td><td>&nbsp;<img src="<?php echo $currtmp; ?>/images/im/im_skype.gif"></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												ICQ:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><input type=text name="icq"></td><td>&nbsp;<img src="<?php echo $currtmp; ?>/images/im/im_icq.gif"></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												AIM:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><input type=text name="aim"></td><td>&nbsp;<img src="<?php echo $currtmp; ?>/images/im/im_aim.gif"></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												Yahoo:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left width=60%>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><input type=text name="yahoo"></td><td>&nbsp;<img src="<?php echo $currtmp; ?>/images/im/im_yahoo.gif"></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=left>
                                                                                <font face="arial,helvetica" size=-1><span><b>
											  </span></b></font> </td>
                                                                            <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
                                                                                        </td><td valign = "top">
                                                                                        </td></tr></table></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right valign=top width=40%>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												Signature:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left width=60%>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><textarea rows=4 name="sig" cols=40></textarea></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align=right width=40%>
                                                                                <font face="arial,helvetica" size=-1><span><b>
												Home Page URL:<br>
												</span></b></font>
                                                                            </td>
                                                                            <td align=left width=60%>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><input type=text size=40 name="weburl"></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <!--<tr>
                                                                            <td width=40% align=right>
                                                                                <font face="arial,helvetica" size=-1><span><b>
										  <?php /*echo $_LANG['ACCOUNT']['SKIN']; */?>:<br>
										  </span></b></font>
                                                                            </td>
                                                                            <td 60% align=left>
                                                                                <table border=0 cellspacing=0 cellpadding=0>
                                                                                    <tr>
                                                                                        <td><select name="skin" OnChange="javascript:changelayout(this.value);">
                                                                                                <option value="" SELECTED><?php /*echo $_LANG['ACCOUNT']['DEFAULT']; */?>
                                                                                                    <?php
/*                                                                                                    foreach (glob('new-hp/templates/*', GLOB_ONLYDIR) as $tempname) {
                                                                                                        if (file_exists($tempname.'/layout.css') and (stristr($tempname, 'forum')==false)) {
                                                                                                            $tempname = str_replace(dirname($tempname).'/','',$tempname);
                                                                                                            echo '<option value="'.$tempname.'">'.$tempname;
                                                                                                        }
                                                                                                    }
                                                                                                    */?>
                                                                                            </select>

                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>-->
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        <p>

                                            <table align="center" cellspacing = "0" cellpadding = "0" border = "0">
                                                <tr>
                                                    <td Width="91">
                                                        <?php if ($_POST['update']=="userinfo2") { ?>
                                                        <!-- UPDATE --><input onclick='javascript:document.createaccount.update.value='userinfo2');" src="<?php echo $currtmp; ?>/images/button-update.gif" name="submit" alt="Update" class="button" taborder="6" border="0" height="46" type="image" width="174"><br>
                                                        <!-- CANCEL -->	<a href="javascript:document.createaccount.step.value='verifyaccount'; javascript:document.createaccount.update.value='';  javascript:createaccount.submit()"><img src="<?php echo $currtmp; ?>/images/button-cancel.gif" alt="Cancel" class="button" taborder="7" border="0" height="46" width="174">
                                                            <?php } else { ?>
                                                            <!-- BACK-->		<a href="javascript:document.createaccount.save.value='false'; javascript:document.createaccount.step.value='valcode'; javascript:document.createaccount.update.value=''; javascript:createaccount.submit()"><img src="<?php echo $currtmp; ?>/images/button-back.gif" alt="Back" Width="91" Height="46" Border=0 CSSclass="button" taborder=7></a>
                                                            <!-- CONTINUE --><td width="174"><input type="image" SRC="<?php echo $currtmp; ?>/images/continue-button.gif" NAME="submit" alt="Continue" Width="174" Height="46" Border=0 class="button"  taborder=6 >
                                                        <?php } ?></td>

                                                    </td>
                                                </tr>
                                            </table>

                                        </span>
                        </td>
                    </tr>
                </table>

                <img src = "images/pixel.gif" width = "500" height = "1">
                </div>
                </div>
        </tr>
    </table>


    </tr>
    </table>
    <?php if ($err_array[1]) { ?>
    <script type="text/javascript">
        document.createaccount.lname.value='<?php echo $_POST['lname']; ?>';
        document.createaccount.fname.value='<?php echo $_POST['fname']; ?>';
        document.createaccount.city.value='<?php echo $_POST['city']; ?>';
        document.createaccount.lo.value='<?php echo $_POST['lo']; ?>';
        document.createaccount.shbd.value='<?php echo $_POST['shbd']; ?>';
        document.createaccount.cflag.src = '<?php echo $currtmp; ?>/images/flags/' + document.createaccount.lo.value + '.gif';
        document.createaccount.gmt.value='<?php echo $_POST['gmt']; ?>';
        document.createaccount.shlo.value='<?php echo $_POST['shlo']; ?>';
        document.createaccount.em.value='<?php echo $_POST['em']; ?>';
        document.createaccount.shem.value='<?php echo $_POST['shem']; ?>';
        document.createaccount.shpm.value='<?php echo $_POST['shpm']; ?>';
        document.createaccount.nick.value='<?php echo $_POST['nick']; ?>';
        document.createaccount.bd.value='<?php echo $_POST['bd']; ?>';
        document.createaccount.msn.value='<?php echo $_POST['msn']; ?>';
        document.createaccount.skype.value='<?php echo $_POST['skype']; ?>';
        document.createaccount.aim.value='<?php echo $_POST['aim']; ?>';
        document.createaccount.icq.value='<?php echo $_POST['icq']; ?>';
        document.createaccount.yahoo.value='<?php echo $_POST['yahoo']; ?>';
        document.createaccount.sig.value='<?php echo $_POST['sig']; ?>';
        document.createaccount.weburl.value='<?php echo $_POST['weburl']; ?>';
        //document.createaccount.skin.value='<?php echo $_POST['skin']; ?>';
        document.createaccount.gender.value='<?php echo $_POST['gender']; ?>';
    </script>
    <?php } else /*if ($_POST['update']=="userinfo2")*/ { ?>
    <script type="text/javascript">
        document.createaccount.lname.value='<?php echo $_SESSION['CA_lname']; ?>';
        document.createaccount.fname.value='<?php echo $_SESSION['CA_fname']; ?>';
        document.createaccount.city.value='<?php echo $_SESSION['CA_city']; ?>';
        document.createaccount.lo.value='<?php echo $_SESSION['CA_lo']; ?>';
        document.createaccount.shbd.value='<?php echo $_SESSION['CA_shbd']; ?>';
        document.createaccount.cflag.src = '<?php echo $currtmp; ?>/images/flags/' + document.createaccount.lo.value + '.gif';
        document.createaccount.gmt.value='<?php echo $_SESSION['CA_gmt']; ?>';
        document.createaccount.shlo.value='<?php echo $_SESSION['CA_shlo']; ?>';
        document.createaccount.em.value='<?php echo $_SESSION['CA_em']; ?>';
        document.createaccount.shem.value='<?php echo $_SESSION['CA_shem']; ?>';
        document.createaccount.shpm.value='<?php echo $_SESSION['CA_shpm']; ?>';
        document.createaccount.nick.value='<?php echo $_SESSION['CA_nick']; ?>';
        document.createaccount.bd.value='<?php echo $_SESSION['CA_bd']; ?>';
        document.createaccount.msn.value='<?php echo $_SESSION['msn']; ?>';
        document.createaccount.skype.value='<?php echo $_SESSION['CA_skype']; ?>';
        document.createaccount.aim.value='<?php echo $_SESSION['CA_aim']; ?>';
        document.createaccount.icq.value='<?php echo $_SESSION['CA_icq']; ?>';
        document.createaccount.yahoo.value='<?php echo $_SESSION['CA_yahoo']; ?>';
        document.createaccount.sig.value='<?php echo $_SESSION['CA_sig']; ?>';
        document.createaccount.weburl.value='<?php echo $_SESSION['CA_weburl']; ?>';
        //document.createaccount.skin.value='<?php echo $_SESSION['CA_skin']; ?>';
        document.createaccount.gender.value='<?php echo $_SESSION['CA_gender']; ?>';
    </script>
    <?php } ?>
<?php
    }
    elseif(isset($_POST['step']) && $_POST['step'] == "valcode" && $allow_reg === true)
    {
?>
        <script type="text/javascript">
            function ca_valid() {

                //document.createaccount.step.value="valcode";
                document.createaccount.update.value="valcode";
                document.createaccount.save.value="true";

                return true;
            }
        </script>
        <table align="center" cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
            <tr>
                <td width = "78" valign = "top"></td>
                <td width = "100%" rowspan = "2">
                    <div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('<?php echo $currtmp; ?>/images/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
                        <div style = "padding:5px; background-image: url('<?php echo $currtmp; ?>/images/header-gradiant.jpg'); background-repeat: no-repeat;">
                            <h3 class="title">Step 2 - Security Check</h3>
                            <p>
                                    <table align="center" border=0 cellspacing=0 cellpadding=0>
                                        <tr>
                                            <td><img src="<?php echo $currtmp; ?>/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"></td>
                                            <td><img src="<?php echo $currtmp; ?>/images/navbar/step1b.gif" width="74" height="45" alt="" border="0"></td>
                                            <td><img src="<?php echo $currtmp; ?>/images/navbar/step2c.gif" width="73" height="45" alt="" border="0"></td>
                                            <td><img src="<?php echo $currtmp; ?>/images/navbar/step3a.gif" width="73" height="45" alt="" border="0"></td>
                                            <td><img src="<?php echo $currtmp; ?>/images/navbar/step4a.gif" width="74" height="45" alt="" border="0"></td>
                                            <td><img src="<?php echo $currtmp; ?>/images/navbar/step5a.gif" width="74" height="45" alt="" border="0"></td>
                                            <td><img src="<?php echo $currtmp; ?>/images/navbar/right-end.gif" width="13" height="45" alt="" border="0"></td>
                                        </tr>
                                    </table>
                            <p>
                                <table align="center" width = "520">
                                    <tr>
                                        <td>
									<span>
									<table width = "520">
										<tr>
										  <td>
											<span>
											<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
											<tr>
												<td width = "24"><img src = "<?php echo $currtmp; ?>/images/subheader-left-sword.gif" width = "24" height = "20"></td>
												<td width = "100%" bgcolor = "#05374A" height = "20"><b class = "white"><?php echo $_LANG['ACCOUNT']['SECURITY_CHECK']; ?></b></td>
												<td width = "10"><img src = "<?php echo $currtmp; ?>/images/subheader-right.gif" width = "10" height = "20"></td>
											</tr>
											</table>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/parch-light2.jpg');"><tr><td>
											<table border=0 cellspacing=0 cellpadding=4 width = "510">
												<tr>
													<td colspan = "2">
													<span>
													<?php echo $_LANG['ACCOUNT']['SECURITY_CODE_INFO']; ?>
													</span>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
													<span>

												<img align="center" src = "<?php echo $currtmp; ?>/images/hr.gif" width = "450" height = "1">
													</span>
													</td>
												</tr>
												<tr>
													<td colspan = "2" align = "center">
													<table cellspacing = "0" cellpadding = "0" border = "0">
													<tr>
														<td colspan = "3"  background= "<?php echo $currtmp; ?>/images/security-border-top.gif"><img src="new-hp/images/pixel.gif" width=300 height=4></td>
													</tr>
													<tr>
														<td background= "<?php echo $currtmp; ?>/images/security-border-left.gif"><img src="new-hp/images/pixel.gif" width=3 height=70></td>
														<td align=center>
                                                            <?php
                                                            if ((int)$MW->getConfig->generic_values->account_registrer->enable_image_verfication):

                                                                // Initialize random image:
                                                                $captcha=new Captcha;
                                                                $captcha->random_bg = 1;
                                                                //$captcha->noise = 1;
                                                                $captcha->load_ttf();
                                                                $captcha->make_captcha();
                                                                $captcha->delold();
                                                                $filename=$captcha->filename;
                                                                $privkey=$captcha->privkey;
                                                                $DB->query("INSERT INTO `website_captcha`(filename, filekey) VALUES('$filename','$privkey')");
                                                                ?>
                                                                <img src="<?php echo $filename; ?>" alt=""/><br />
                                                                <input type="hidden" name="filename_image" value="<?php echo $filename; ?>"/>
                                                                <b>Type letters above (6 characters)</b>
                                                                <br />
                                                            <?php endif; ?>
															<img src="<?php echo $currtmp; ?>/images/pixel.gif" width=293 height=1>
														</td>
														<td background = "<?php echo $currtmp; ?>/images/security-border-right.gif"><img src="<?php echo $currtmp; ?>/images/pixel.gif" width=4 height=70></td>
													</tr>
													<tr>
														<td colspan = "3" background= "<?php echo $currtmp; ?>/images/security-border-bot.gif"><img src="<?php echo $currtmp; ?>/images/pixel.gif" width=300 height=3></td>
													</tr>
													</table>
														<table border=0 cellspacing=0 cellpadding=4>
														<tr>
															  <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['SECURITY_INPUT']; ?>:</b></span></td>

															  <td NOWRAP align = "center">

																	<table border=0 cellspacing=0 cellpadding=0><tr><td><input type="text" name="image_key" MaxLength="8" Width="300" taborder=6 /></td><td valign = "top">
													   </td></tr></table>
															  </td>
														</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
													<span>
                                                        <img align="center" src = "<?php echo $currtmp; ?>/images/hr.gif" width = "450" height = "1">
													</span>
													</td>
												</tr>
											</table>
										</td></tr></table>
									</td></tr></table>
									</span>

								</td>
										</tr></table>
                            <P>
                                <table align="center" cellspacing = "0" cellpadding = "0" border = "0">
                                    <tr>
                                        <!-- BACK-->		<td Width="91"><a href="javascript:document.createaccount.step.value='agreement'; javascript:createaccount.submit()"><img src="<?php echo $currtmp; ?>/images/back-button.gif" alt="<?php echo $_LANG['ACCOUNT']['BACK']; ?>" Width="91" Height="46" taborder=8></a></td>
                                        <!-- CONTINUE-->	<td width="174"><input type=image SRC="<?php echo $currtmp; ?>/images/continue-button.gif" name="Submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=7 ></td>
                                    </tr>
                                </table>
                            <img src = "<?php echo $currtmp; ?>/images/pixel.gif" width = "500" height = "1">
                            <span></td>
                <td width = "76" valign = "top"></td>
            </tr>
            <tr>
                <td valign = "bottom"></td>
                <td valign = "bottom"></td>
            </tr>
        </table>
        </td>
        </tr>
        </table>
<?php
    }
    elseif((isset($_POST['step']) && $_POST['step']=="agreement" || (int)$MW->getConfig->generic->req_reg_key == 0) && $allow_reg === true)
    {
?>
        <script type="text/javascript"> ////////////////AGREEMENT -1
            function ca_valid() {
                document.createaccount.step.value="userinfo";
                document.createaccount.update.value="";
                document.createaccount.save.value="true";
                return true;
            }
        </script>
        <table align="center" cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
            <tr>
                <td width = "60%">
                    <table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('<?php echo $currtmp; ?>/images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
                        <tr>
                            <td width = "78" valign = "top"></td>
                            <td width = "100%" rowspan = "2">
                                <div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('<?php echo $currtmp; ?>/images/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
                                    <div style = "padding:5px; background-image: url('<?php echo $currtmp; ?>/images/header-gradiant.jpg'); background-repeat: no-repeat;">
                                        <h3 class="title">
                                            <?php echo $lang['rules_agreement'] ?></h3>
                                        <p>
                                        <table align="center" border=0 cellspacing=0 cellpadding=0>
                                            <tr>
                                                <td><img src="<?php echo $currtmp; ?>/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"></td>
                                                <td><img src="<?php echo $currtmp; ?>/images/navbar/step1c.gif" width="74" height="45" alt="" border="0"></td>
                                                <td><img src="<?php echo $currtmp; ?>/images/navbar/step2a.gif" width="73" height="45" alt="" border="0"></td>
                                                <td><img src="<?php echo $currtmp; ?>/images/navbar/step3a.gif" width="73" height="45" alt="" border="0"></td>
                                                <td><img src="<?php echo $currtmp; ?>/images/navbar/step4a.gif" width="74" height="45" alt="" border="0"></td>
                                                <td><img src="<?php echo $currtmp; ?>/images/navbar/step5a.gif" width="74" height="45" alt="" border="0"></td>
                                                <td><img src="<?php echo $currtmp; ?>/images/navbar/right-end.gif" width="13" height="45" alt="" border="0"></td>
                                            </tr>
                                        </table>
                                        <p>
                                        <p>
                                        <table border=0 cellspacing=0 cellpadding=4 width = "80%">
                                            <tr>
                                                <td align=left>
                                                    <center>
                                                        <img src = "<?php echo $currtmp; ?>/images/hr.gif" width = "520" height = "1">
                                                    </center>
                                                    <span>
                                                        <?php if ((int)$MW->getConfig->generic->req_reg_key != 0){ ?>
                                                <div style="color: red"><?php echo $lang['warn_email'] ?></div><?php } ?>
                                                    </br><?php echo lang_resource('acc_create_rules.html'); ?>
												</span>
                                                </td>
                                            </tr>
                                        </table>
                                        <p>
                                            <table align="center">
                                                <input type="hidden" name="step" value="accountinfo"/>
                                                <input type="hidden" name="r_key" value="<?php echo $_POST['r_key'];?>"/>
                                                <!-- I AGREE-->	<tr><td><input TYPE="image" SRC="<?php echo $currtmp; ?>/images/agree-button.gif" NAME="submit" alt="<?php echo $lang['agree']; ?>" class="button" ></td></tr>
                                                <!-- I DISAGREE--><tr><td><a href = "index.php"><img src = "<?php echo $currtmp; ?>/images/disagree-button.gif" alt = "<?php echo $lang['disagree']; ?>" border = "0"></a></td></tr>
                                        </table>
                                        <img src = "new-hp/images/pixel.gif" width = "500" height = "1">
                                        <span>
                                    </div>
                                </div>
                            </td>
                            <td width = "76" valign = "top"></td>
                        </tr>
                        <tr>
                            <td valign = "bottom"></td>
                            <td valign = "bottom"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
<?php
    }
    elseif(empty($_POST['step']) && (int)$MW->getConfig->generic->req_reg_key == 1 && $allow_reg === true)
    {
?>
      <form method="post" action="index.php?n=account&amp;sub=register">
        <input type="hidden" name="step" value="agreement"/>
        <div style="margin:4px;padding:6px 9px 6px 9px;text-align:left;">
        <b><?php /*echo $lang['reg_key'];*/?>:</b> <input type="text" name="r_key" size="45" maxlength="50"/>
        </div>
        <div style="background:none;margin:4px;padding:6px 9px 0px 9px;text-align:left;">
        <input type="submit" class="button" value="<?php /*echo $lang['next'];*/?>"/>
        </div>
      </form>
<?php
    }
?>
</form>
<br/>
