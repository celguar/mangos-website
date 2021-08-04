<br>
<?php builddiv_start(0, $lang['retrieve_pass']) ?>
<?php if($user['id'] < 1){ ?>
<style type="text/css">
    .attribute { font-family: "Arial", "Helvetica", "Sans-Serif"; color: #000000; font-weight: bold; font-size: 12;}
    #icon { position: absolute;	top: -145px; left: 47px; z-index: 99; _top: -145px}
    #text { position: relative;	top: 52px;	left: 10px;	z-index: 99; }
    #wrapper { position: relative; z-index: 99; }
	  #wrapper99 { position: relative; z-index: 98; }
		.title	{
			font-family: palatino, georgia, times new roman, serif;
			font-size: 13pt;
			color: #640909;
		}
</style>
<br />
<center>
<!--Shadow Top-->
<table cellspacing = "0" cellpadding = "0" border = "0" ><tr><td>
<img src = "<?php echo $currtmp; ?>/images/shadow-top-left.gif" width = "5" height = "4"></td><td background = "<?php echo $currtmp; ?>/images/shadow-top.gif">
<img src = "<?php echo $currtmp; ?>/images/shadow-top-left-left.gif" width = "12" height = "4"></td><td align = "right" background = "<?php echo $currtmp; ?>/images/shadow-top.gif">
<img src = "<?php echo $currtmp; ?>/images/shadow-top-right-right.gif" width = "12" height = "4"></td><td><img src = "<?php echo $currtmp; ?>/images/shadow-top-right.gif" width = "9" height = "4"></td></tr><tr>
<td valign = "top" background = "<?php echo $currtmp; ?>/images/shadow-left.gif"><img src = "<?php echo $currtmp; ?>/images/shadow-left-top.gif" width = "5" height = "12"></td>
<td colspan = "2" rowspan = "2" style="background-image:url('<?php echo $currtmp; ?>/images/header-left2.jpg'); background-repeat: no-repeat;">
<!--Shadow Top-->
  <table cellspacing = "0" cellpadding = "4" border = "0">
  <tr>
	 <td>
    <h3 class="title"><font color="white"><?php echo $lang['have_you_forgot_pass'];?></font></h3>
    <p>
      <table width = "510" cellspacing = "0" cellpadding = "0" border = "0">
	    <tr>
	     <td>
		    <img align="right" src="<?php echo $currtmp; ?>/images/confusedorc.jpg">
		    <?php  echo add_pictureletter($lang['intro_account_restore']);?>
	     </td>
	    </tr>
      <form action="index.php?n=account&sub=restore" method="post">
      <tr><td>
        <form action="index.php?n=account&sub=restore" method="post">
        <table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
        <table width = "100%" style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/light3.jpg');">
        <tr>
          <td align = "center">
			     <table border=0 cellspacing=0 cellpadding=4>
           <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:center;width:70%;">
            <?php echo $lang['username'];?>:<br /> <input type="text" name="retr_login" size="26" maxlength="16" style="font-size:11px;"  style="width:120px;">
            <br />
            <?php echo $lang['email']?>:<br /> <input type="text" name="retr_email" size="26" maxlength="80" style="font-size:11px;"  style="width:120px;">
            <br /><br />
            <?php echo $lang['secretq'];?> 1:<br />
            <select name="secretq1" style="width:120px;">
              <option <?php if(isset($profile['secretq2']) && $profile['secretq2'] == 0)echo "selected"; ?> value="0">None</option>
              <?php
              foreach ($MW->getConfig->secret_questions->question as $question){
              ?>
              <option value="<?php echo htmlspecialchars($question); ?>"><?php echo $question; ?></option>
              <?php
              }
              ?>
            </select><br />
            <input type="text" name="secreta1" size="26" maxlength="80" style="font-size:11px;"  style="width:120px;">
            <br /><br />
            <?php echo $lang['secretq'];?> 2:<br />
            <select name="secretq2" style="width:120px;">
              <option <?php if(isset($profile['secretq2']) && $profile['secretq2'] == 0)echo "selected"; ?> value="0">None</option>
              <?php
              foreach ($MW->getConfig->secret_questions->question as $question){
              ?>
              <option value="<?php echo htmlspecialchars($question); ?>"><?php echo $question; ?></option>
              <?php
              }
              ?>
              </select><br />
              <input type="text" name="secreta2" size="26" maxlength="80" style="font-size:11px;"  style="width:120px;">
              <br />
            </div>
			      </table>
        </td></tr></table>
        </td></tr></table>
        <center>
          <input type="image" src="<?php echo $currtmp; ?>/images/continue-button.gif" size="16" class="button" style="font-size:12px;" value="<?php echo $lang['doretrieve_pass'] ?>">
        </center>
        </form>
        </td></tr>
      </td>
      </tr>
      </table>
      </form>
</td></tr></table>
<!--Shadow Bottom-->
</td><td valign = "top" background = "<?php echo $currtmp; ?>/images/shadow-right.gif">
<img src = "<?php echo $currtmp; ?>/images/shadow-right-top.gif" width = "9" height = "12"></td></tr>
<tr><td valign = "bottom" background = "<?php echo $currtmp; ?>/images/shadow-left.gif">
<img src = "<?php echo $currtmp; ?>/images/shadow-left-bot.gif" width = "5" height = "12"></td>
<td valign = "bottom" background = "<?php echo $currtmp; ?>/images/shadow-right.gif">
<img src = "<?php echo $currtmp; ?>/images/shadow-right-bot.gif" width = "9" height = "12"></td></tr>
<tr><td><img src = "<?php echo $currtmp; ?>/images/shadow-bot-left.gif" width = "5" height = "10"></td>
<td background = "<?php echo $currtmp; ?>/images/shadow-bot.gif">
<img src = "<?php echo $currtmp; ?>/images/shadow-bot-left-left.gif" width = "12" height = "10"></td>
<td align = "right" background = "<?php echo $currtmp; ?>/images/shadow-bot.gif">
<img src = "<?php echo $currtmp; ?>/images/shadow-bot-right-right.gif" width = "12" height = "10"></td>
<td><img src = "<?php echo $currtmp; ?>/images/shadow-bot-right.gif" width = "9" height = "10"></td></tr></table>
<!--Shadow Bottom-->
</center>
<?php
}else{
  echo $lang['not_require_loggedin'];
}
?>
<?php builddiv_end() ?>