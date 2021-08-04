<?php if($user['id']>0 && isset($profile)){ ?>
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


<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
<tr>

	<td width = "100%" align = "center">
		<table width = "100%" cellspacing = "0" cellpadding = "0" border="0" background="<?php echo $currtmp; ?>/images/account/tbc-background.jpg">
		<tr>
			<td>
			 <div id="wrapper"><div id="icon"><img src="<?php echo $currtmp; ?>/images/account/draenei-top.gif"></div></div>
      </td>
      <td ><div id = "wrapper"><div id = "text"><img src="<?php echo $currtmp; ?>/images/account/title_acc_man.gif"></div></div>
      </td>

      <td valign = "top"><a href = "/account/"><img src ="<?php echo $currtmp; ?>/images/pixel.gif" width="90" height = "161" border="0" ></a></td>
			<td><img src="<?php echo $currtmp; ?>/images/pixel.gif" border="0" height="161" width="90"></td>
	</tr>
  </table>
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
	<tr>
	 <td background = "<?php echo $currtmp; ?>/images/account/bottom.gif" width = "100%" ><img src ="<?php echo $currtmp; ?>/images/pixel.gif" height = "18" width = "200"></td>
	</tr>
	</table>
	</td>
	<td width = "10%"></td>
</tr>
<tr>
	  <td colspan="3">
		  <table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
	  		<tr>
				  <td background = "images/bottom.gif" width = "100%" ><img src ="<?php echo $currtmp; ?>/images/pixel.gif" height = "18" width = "200"></td>
	  		</tr>
		  </table>
	  </td>
  </tr>
</table>

<?php builddiv_start() ?>

<center>
<!--Shadow Top-->
<table cellspacing = "0" cellpadding = "0" border = "0"><tr><td><img src = "<?php echo $currtmp; ?>/images/shadow-top-left.gif" width = "5" height = "4"></td><td background = "<?php echo $currtmp; ?>/images/shadow-top.gif">
<img src = "<?php echo $currtmp; ?>/images/shadow-top-left-left.gif" width = "12" height = "4"></td><td align = "right" background = "<?php echo $currtmp; ?>/images/shadow-top.gif">
<img src = "<?php echo $currtmp; ?>/images/shadow-top-right-right.gif" width = "12" height = "4"></td><td><img src = "<?php echo $currtmp; ?>/images/shadow-top-right.gif" width = "9" height = "4"></td></tr><tr>
<td valign = "top" background = "<?php echo $currtmp; ?>/images/shadow-left.gif"><img src = "<?php echo $currtmp; ?>/images/shadow-left-top.gif" width = "5" height = "12"></td>
<td colspan = "2" rowspan = "2" style="background-image:url('<?php echo $currtmp; ?>/images/header-left2.jpg'); background-repeat: no-repeat;">
<!--Shadow Top-->
<table cellspacing = "0" cellpadding = "4" border = "0">
<tr>
	<td>
<h3 class="title"><font color="white"><?php echo $lang['change_your_info'];?></font></h3>
<p>

<center>


<form name="mainform" method="post" action="index.php?n=account&sub=manage&action=change" enctype="multipart/form-data" onsubmit="return validateforms(this)">
<table width = "510" cellspacing = "0" cellpadding = "0" border = "0">
<tr>

	<td>
	<span>
   <?php echo add_pictureletter("$lang[accountmanange_intro]"); ?>
	</span>
	</td>

</tr>
</table>
</center>
<br />
<?php write_subheader($lang['general_info']); ?>

<table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td><table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/light3.jpg');"><tr><td>

<table border=0 cellspacing=0 cellpadding=4>
<tr>
      <td align=right valign = "top">
      <font face="arial,helvetica" size=-1><span><b>
      <?php echo $lang['username'];?><br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
      <input type='text' size='40' disabled="disabled" style="background-color:#FFFFFF" value='&nbsp;&nbsp;<?php echo $profile['username'];?>' readonly>
			</td><td valign = "top">

	   </td></tr></table>
      </td>
</tr>
<tr>
      <td width=200 align=right>
      <font face="arial,helvetica" size=-1><span><b>
      <?php echo $lang['hideemail'];?>&#058;<br />
      </b></span></font>
      </td>

   	  <td><table border=0 cellspacing=0 cellpadding=0><tr><td>
			             <select name="profile[hideemail]" style="margin:1px;">
            <option value="0"<?php if($profile['hideemail']==0)echo' selected';?>><?php echo $lang['no'];?> </option>
            <option value="1"<?php if($profile['hideemail']==1)echo' selected';?>><?php echo $lang['yes'];?> </option>
            </select>
			 </td><td valign = "top">
	   </td></tr></table></td>
</tr>
<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
      <?php echo $lang['hideprofile'];?>&#058;<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<select name="profile[hideprofile]" style="margin:1px;">
            <option value="0"<?php if($profile['hideprofile']==0)echo' selected';?>><?php echo $lang['no'];?> </option>
            <option value="1"<?php if($profile['hideprofile']==1)echo' selected';?>><?php echo $lang['yes'];?> </option>
      </select>
			</td><td valign = "top">
	   </td></tr></table></td>
</tr>

<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
      <?php echo $lang['gender'];?>&#058;<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<select name="profile[gender]">
            <option value="0"<?php if($profile['gender']==0)echo' selected';?>><?php echo $lang['notselected'];?> </option>
            <option value="1"<?php if($profile['gender']==1)echo' selected';?>><?php echo $lang['male'];?> </option>
            <option value="2"<?php if($profile['gender']==2)echo' selected';?>><?php echo $lang['female'];?> </option>
      </select>
			</td><td valign = "top">
	   </td></tr></table></td>
</tr>

<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
      <?php echo $lang['homepage'];?>&#058;<br />
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="profile[homepage]" type="text" size="36" style="margin:1px;" value="<?php echo$profile['homepage'];?>" />
	   </td></tr></table></td>
      <br />
      </td>
</tr>

<tr>
      <td align=right NOWRAP>

      <font face="arial,helvetica" size=-1><span><b>
      <?php echo $lang['icq'];?>
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="profile[icq]" type="text" size="36" style="margin:1px;" value="<?php echo$profile['icq'];?>" /></td><td valign = "top">
	   </td></tr></table></td>
</tr>

<tr>
      <td align=right valign = "top">

      <font face="arial,helvetica" size=-1><span><b>
      <?php echo $lang['msn'];?>
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="profile[msn]" type="text" size="36" style="margin:1px;" value="<?php echo$profile['msn'];?>" /><span></span></td><td valign = "top">
	   </td></tr></table></td>
      </td>

</tr>

<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
      <?php echo $lang['wherefrom'];?>
			<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<input name="profile[location]" type="text" size="36" style="margin:1px;" value="<?php echo$profile['location'];?>" />
</td><td valign = "top">
	   </td></tr></table>
      </td>

</tr>
<?php if((int)$MW->getConfig->generic->change_template) { ?>
<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
     	<?php echo$lang['theme'];?>
			<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<select name="profile[theme]" style="margin:1px;">
            <?php
            $i = 0;
            foreach($MW->getConfig->templates->template as $template){ ?>
            <option value="<?php echo$i;?>"<?php if($profile['theme']==$i)echo' selected';?>><?php echo (string)$template;?>
            <?php $i++; } ?>
            </option>
          </select>
</td><td valign = "top">
	   </td></tr></table>
      </td>

</tr>
<?php } ?>

<?php if($profile['avatar']) { ?>
<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
     	<?php echo $lang['avatar'];?>
			<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
          <img src="<?php echo (string)$MW->getConfig->generic->avatar_path;?><?php echo$profile['avatar'];?>" style="margin:1px;"> <br/>
          <input type="hidden" name="avatarfile" value="<?php echo$profile['avatar'];?>">
          <b><?php echo $lang['delavatar'];?></b>
          <input type="checkbox" size="36" name="deleteavatar" style="margin:1px;" value="1">
</td><td valign = "top">
	   </td></tr></table>
      </td>

</tr>
<?php }else{ ?>
<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
			<?php echo $lang['avatar'];?>
			<img src="<?php echo $currtmp; ?>/images/icons2/warning.gif" width="15" height="15"
			 onmouseover="ddrivetip('<?php echo $lang['maxavatarsize'];?>: <?php echo (int)$MW->getConfig->generic->max_avatar_file;?> bytes, <?php echo $lang['maxavatarres'];?> <?php echo (string)$MW->getConfig->generic->max_avatar_size;?> px.<br/>','#ffffff')";
			 onmouseout="hideddrivetip()">
			<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
<input type="file" size="36" name="avatar" style="margin:1px;">
</td><td valign = "top">
	   </td></tr></table>
      </td>

</tr>
<?php } ?>

<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
			<?php echo $lang['signature'];?>
			<img src="<?php echo $currtmp; ?>/images/icons2/info.gif" width="16" height="16"
			 onmouseover="ddrivetip('You may use normal BBcode tags in signature.','#ffffff')";
			 onmouseout="hideddrivetip()">
			<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
<textarea name="profile[signature]" maxlength="255" rows="3" cols="40"><?php echo my_previewreverse($profile['signature']);?></textarea>
</td><td valign = "top">
	   </td></tr></table>
      </td>

</tr>
<tr>
    <td align=left colspan="2">
        <font color="#FF0000">*</font><input type="checkbox" name="legal" value="yes">&nbsp;
      <font face="arial,helvetica" size=-1 ><span><b>
      <span><small><font color="black"><?php echo $lang['agreeement_detailschange']; ?></font></small></span><br/>
      </b></span></font></td>

       <td valign = "top">


      </td>
</tr>



</table>
<div align="center">
	<input type="image" src="<?php echo $currtmp; ?>/images/button-cancel.gif" size="16" class="button" style="font-size:12px;" value="<?php echo $lang['reset'];?>">
	<input type="image" src="<?php echo $currtmp; ?>/images/button-update.gif" class="button" style="font-size:12px;" value="<?php echo $lang['dochange'];?>">
</div>
</td></tr></table>
</td></tr></table>

</form>


<br /><br />
<table width = "510" cellspacing = "0" cellpadding = "0" border = "0">
<tr>

	<td>
	<span>
  <?php echo add_pictureletter($lang['accountmanage_important']); ?>
	</span>
	</td>

</tr>
</table>
</center>
<br />
<?php write_subheader($lang['other_info']); ?>


<table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
<table style = "width:100%; border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $currtmp; ?>/images/light3.jpg');"><tr><td>

<table border=0 cellspacing=0 cellpadding=4>
    <?php if((int)$MW->getConfig->generic->change_pass) { ?>

		<tr>
		<form method="post" action="index.php?n=account&sub=manage&action=changepass">
      <td align=right valign = "top">

      <font face="arial,helvetica" size=-1><span><b>
      <?php if (isset($lang['newpass']))echo $lang['newpass'];?>
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input type="password" size="22" name="new_pass">
			<input type="submit" value="Change password" class="button" style="font-size:11px;"><span></span></td><td valign = "top">
	   </td></tr></table></td>
      </td>
    </form>
		</tr>

    <?php } ?>
   <?php if((int)$MW->getConfig->generic->change_email) { ?>

		<tr>
		<form method="post" action="index.php?n=account&sub=manage&action=changeemail">
      <td align=right valign = "top">

      <font face="arial,helvetica" size=-1><span><b>
     <?php if (isset($lang['newemail']))echo $lang['newemail'];?>
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<input type='text' name='new_email' size='36' value='&nbsp;&nbsp;<?php echo $profile['email'];?>'>
                <input type="submit" value="<?php echo $lang['change_email_button'] ?>" class="button" style="font-size:11px;"><span></span></td><td valign = "top">
	   </td></tr></table></td>
      </td>
    </form>
		</tr>

    <?php }else{ ?>
				<tr>
      <td align=right valign = "top">

      <font face="arial,helvetica" size=-1><span><b>
     <?php echo $lang['email'];?>
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<input type="text" size="36" value="&nbsp;&nbsp;<?php echo $profile['email'];?>" readonly>
               <span></span></td><td valign = "top">
	   </td></tr></table></td>
      </td>
		</tr>
		<?php } ?>




<!--Secret QUESTION-->
<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
			<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
        <?php
        if ($profile['secretq1'] == '0'){
        echo '<span style="color: red">'.$lang['not_have_secretq'].'</span>';
        }else{
        echo '<span style="color: green">'.$lang['have_secretq'].'</span>';
        }
?>
</td><td valign = "top">
	   </td></tr></table>
      </td>
</tr>
		<form method="post" action="index.php?n=account&sub=manage&action=changesecretq">
<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
			<?php echo $lang['secretq'];?> 1
			<img src="<?php echo $currtmp; ?>/images/icons2/warning.gif" width="15" height="15"
			 onmouseover="ddrivetip('<?php echo $lang['secretq_info']; ?>: <ul><li><?php echo $lang['secretq_info_mincharacters']; ?>.</li><li><?php echo $lang['secretq_info_nosymbols']; ?>.</li><li><?php echo $lang['secretq_info_bothfields']; ?>.</li></ul>','#ffffff')";
			 onmouseout="hideddrivetip()">
			<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
        <select name="secretq1">
          <option <?php if($profile['secretq1'] == 0)echo "selected"; ?> value="0">None</option>
          <?php
          foreach ($MW->getConfig->secret_questions->question as $question){
          ?>
          <option value="<?php echo htmlspecialchars($question); ?>" <?php if ($profile['secretq1'] == htmlspecialchars($question)){ echo "selected"; } ?>><?php echo $question; ?></option>
          <?php
          }
          ?>
        </select>
        <input type="name" name="secreta1" style="margin:1px;">
     </td><td valign = "top">
	   </td></tr></table>
     </td>
</tr>

<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
			<?php echo $lang['secretq'];?> 2
			<img src="<?php echo $currtmp; ?>/images/icons2/warning.gif" width="15" height="15"
			 onmouseover="ddrivetip('<?php echo $lang['secretq_info']; ?>: <ul><li><?php echo $lang['secretq_info_mincharacters']; ?>.</li><li><?php echo $lang['secretq_info_nosymbols']; ?>.</li><li><?php echo $lang['secretq_info_bothfields']; ?>.</li></ul>','#ffffff')";
			 onmouseout="hideddrivetip()">
			<br />
      </b></span></font>
      </td>
      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
        <select name="secretq2">
          <option <?php if($profile['secretq2'] == 0)echo "selected"; ?> value="0">None</option>
          <?php
          foreach ($MW->getConfig->secret_questions->question as $question){
          ?>
          <option value="<?php echo htmlspecialchars($question); ?>" <?php if ($profile['secretq2'] == htmlspecialchars($question)){ echo "selected"; } ?>><?php echo $question; ?></option>
          <?php
          }
          ?>
          </select>
          <input type="name" name="secreta2" style="margin:1px;">
      </td><td valign = "top">
	    </td></tr></table>
      </td>
</tr>

<tr>
      <td align=right>
      <font face="arial,helvetica" size=-1><span><b>
			<br />
      </b></span></font>
      </td>
      <td align=center><table border=0 cellspacing=0 cellpadding=0><tr><td>
        <input type="submit" value="Change Secret questions" class="button"></form>
      </td><td valign = "top">
        <form method="post" action="index.php?n=account&sub=manage&action=resetsecretq" style="{MARGIN-LEFT: 0pt; MARGIN-RIGHT: 0pt; MARGIN-TOP: 0pt; MARGIN-BOTTOM: 0pt;}">
        <input type="hidden" name="reset_secretq" value="reset_secretq">
        <input type="submit" value="Reset Secret questions" name="reset_secretq">
        </form>
	    </td></tr></table>
      </td>
</tr>

<!--Secret QUESTION END-->
<!-- Gameplay option start -->
<tr>
		<td>
		<form method="POST" action="<?php echo$_SERVER['PHP_SELF'];?>?n=account&sub=manage&action=change_gameplay">
		  <input type="hidden" name="switch_wow_type" value="wotlk" />
		  <input type='image' class="button"  src='<?php echo $currtmp; ?>/images/wotlk.gif' />
	      </td>
		<td>
                  <b><font size="2"><?php echo $lang['make_acct_wotlk'];?></font></b>
				</form>
		</td>
</tr>
<tr>
		<td>
		<form method="POST" action="<?php echo$_SERVER['PHP_SELF'];?>?n=account&sub=manage&action=change_gameplay">
		  <input type="hidden" name="switch_wow_type" value="tbc" />
		  <input type='image' class="button"  src='<?php echo $currtmp; ?>/images/tbc.gif' />
	      </td>
		<td>
                  <b><font size="2"><?php echo $lang['make_acct_tbc'];?></font></b>
				</form>
		</td>
</tr>
<tr>
		<form method="POST" action="<?php echo$_SERVER['PHP_SELF'];?>?n=account&sub=manage&action=change_gameplay">
		<td>
		  <input type="hidden" name="switch_wow_type" value="classic" />
		  <input type='image' class="button" src='<?php echo $currtmp; ?>/images/nontbc.gif' />
	  </td>
		<td>
                  <b><font size="2"><?php echo $lang['make_acct_classic'];?></font></b>

		</td>
    </form>
</tr>
<!-- Gameplay option STOP -->

</table>
</td></tr></table>
</td></tr></table>
</center>



</td></tr></table>
</center>
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

<?php builddiv_end() ?>

<?php
}
 ?>
