
<img src="templates/wotlk/images/header-charcopy.jpg" width="660" height="121" /><br />
<img src="templates/wotlk/images/banner-bottom2.jpg" width="660" height="18" /><br /><br />
<div id = "wrapper"><div id = "heads"><img src = "templates/wotlk/images/header-charcopy-top.gif" width="642" /></div></div>
<?php builddiv_start(0, $lang['charcreate']) ?>
<?php if($user['id'] > 0){ ?>
<?php
    // We do only want to show this if user is on the right realm connection.
    foreach($MW->getConfig->character_copy_config->work_on_realms->realm as $check){
        $i = 0;
        if ($user['cur_selected_realmd'] != $check){
            $exit = TRUE;
            $usable_realm[$i] = $check;
            $i++;
        }
    }
    if ($exit == TRUE){
       echo "<p><b>".$lang['not_copy_realm_choose_other']."</b><ul>";
       foreach($usable_realm as $rm){
           $realmname = $DB->selectCell("SELECT name FROM `realmlist` WHERE id='".$rm."'");
           echo "<li><a href='index.php?n=account&sub=charcreate&changerealm_to=".$rm."'>".$realmname."</a></li>";
       }
       echo "</ul></p>";
       die;
    }
?>
<style type = "text/css">
  tr.serverStatus1 { border-style: solid; border-width: 1px 0px 0px 1px; border-color: #D8BF95; }
  tr.serverStatus2 { border-style: solid; border-width: 1px 0px 0px 1px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
	input.name_input{ background-color: black; color:white;};
</style>
<style type = "text/css">



   	   #heads { position: absolute;
			top: -185px;
			left: -25px;
			z-index: 500;
       }

   	   #text { position: absolute;
			top: 61px;
			left: 165px;
			z-index: 100;
       }



		#wrapper { position: relative;
			z-index: 100;
       }

		#wrapper99 { position: relative;
			z-index: 99;
       }

</style>

<?php
if ((int)$MW->getConfig->character_copy_config->enable == 1){
?>
<table>
  <tr>
  <td>
  <img align="left" src="<?php echo $currtmp; ?>/images/letters/t.gif"><?php echo $lang['copy_page_desc'];?>
	<?php echo $lang['copy_instructions'];?><br /><br />
	<center>To copy a character, it will cost you <font color="blue"><?php echo $char_points; ?></font> voting points. Your current balance is: <font color="blue"><u>
	<?php echo $your_points; ?></u></font></center><br />
	</td><td align="left"><img src="<?php echo $currtmp; ?>/images/worlds-copy.jpg"></td>
  </tr>
</table>
<div style="cursor: auto;" id="dataElement">
<span>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td width="12"><img src="<?php echo $currtmp; ?>/images/metalborder-top-left.gif" height="12" width="12"></td>
        <td background="<?php echo $currtmp; ?>/images/metalborder-top.gif"></td>
        <td width="12"><img src="<?php echo $currtmp; ?>/images/metalborder-top-right.gif" height="12" width="12"></td>
    </tr>
    <tr>
        <td background='<?php echo $currtmp; ?>/images/metalborder-left.gif'></td>
        <td>
            <table cellpadding="3" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td class="rankingHeader" align="left" nowrap="nowrap" width="100"><?php echo $lang['class'];?></td>
                    <td class="rankingHeader" align="left" nowrap="nowrap"><?php echo $lang['faction']?></td>
                    <td class="rankingHeader" align="center" nowrap="nowrap" width="100"><?php echo $lang['race'];?></td>
                    <td class="rankingHeader" align="center" nowrap="nowrap" width="20"><?php echo $lang['level'];?></td>
                    <td class="rankingHeader" align="center" nowrap="nowrap" width="120"><?php echo $lang['desired_name'];?></td>
                		<td class="rankingHeader" align="center" nowrap="nowrap" width="120"><?php echo $lang['create_char'];?></td>
								</tr>
                <tr>
                    <td colspan="6" background="<?php echo $currtmp; ?>/images/shadow.gif">
                     <img src="<?php echo $currtmp; ?>/images/pixel.gif" height="1" width="1">
                    </td>
                </tr>
<?php
    //Declares
	  $userid=$user['id'];
    $MANG = new Mangos;

		// Main Get and assign values to inputs.
		$available_points = $DB->selectCell("SELECT `points` FROM `voting_points` WHERE id=?d",$userid);
		if($char_points > $available_points){
			$disabled = disabled;
			echo "<font color=\"red\"><center>You do not have enough points to copy a character!!</center></font>";
		}else{
			$disabled = enabled;
			
		}
    $alliance_cop = (int)$MW->getConfig->character_copy_config->accounts->alliance;
    $horde_cop = (int)$MW->getConfig->character_copy_config->accounts->horde;
    $query = $CHDB->select("SELECT * FROM `characters` WHERE account='$alliance_cop' or account='$horde_cop'  ORDER BY account");

    if ($query == FALSE){
      echo $lang[no_char_create];
    }else{
    foreach($query as $data)
		{
			$char_data = explode(' ',$data['data']);
			$pre_level = $char_data[$MANG->charDataField['UNIT_FIELD_LEVEL']];
			$race = $data['race'];
			$class = $data['class'];
			$char_guid = $data['guid'];
      if ($race == 1 || $race == 3 || $race == 4 || $race == 7 || $race == 11){ $output_race = 'alliance';}else{ $output_race = 'horde';}
      $output_class = $MANG->characterInfoByID['character_class'][$class];
	  $level = $pre_level;
      $classe = $MANG->characterInfoByID['character_class'][$class];
      $race = $MANG->characterInfoByID['character_race'][$race];
      /*****DECLARE RACE AND CLASS ******/
echo<<<EOT
	<form action="index.php?n=account&sub=charcreate&action=createchar" method="POST">
	<input type="hidden" name="createchar_id" value="$userid">
	<input type="hidden" name="createchar_faction" value="$output_race">
	<input type="hidden" name="createchar_class" value="$output_class">
	<input type="hidden" name="character_copy_char" value="$char_guid">
EOT;
				if ($i == 1)
				{
         	echo"<tr class='serverStatus2'>";
					$i++;
				}
				else
				{
					echo"<tr class='serverStatus1'>";
				}
echo<<<EOT
	<td><b>$classe</b></td>
	<td><center>$output_race</center></td>
	<td><center>$race</center></td>
	<td><center>$level</center></td>
	<td><input class="name_input" type="text" maxlength="12" name="createchar_name"></td>
	<td><center><input type="image" src="$currtmp/images/button-copy-character.gif" name="createchar" value="[GET NOW] disabled="$disabled""></center></td>
	</tr>
	</form>
EOT;
					if ($i == 2)
					{
						$i = 0;
					}
					else
					{
						$i++;
					}
		}
		unset($MANG);
}
echo<<<EOT
                </tbody>
            </table>
        </td>
        <td background="$currtmp/images/metalborder-right.gif"></td>
    </tr>
    <tr>
        <td><img src="$currtmp/images/metalborder-bot-left.gif" height="11" width="12"></td>
        <td background="$currtmp/images/metalborder-bot.gif"></td>
        <td><img src="$currtmp/images/metalborder-bot-right.gif" height="11" width="12"></td>
    </tr>
    </tbody>
</table>
</span>
</div>
EOT;
?>
<?php
	}
}else{
	$createlink = '<a href="index.php?n=account&amp;sub=register">'.$lang['logon_message_createlink_text'].'</a>';
	$loginlink = '<a href="index.php?n=account&amp;sub=login">'.$lang['logon_message_loginlink_text'].'</a>';
	$logonmessage = $lang['logon_message'];
	$logonmessage = str_replace('[createlink]', $createlink, $logonmessage);
	$logonmessage = str_replace('[loginlink]', $loginlink, $logonmessage);
    echo "<p><b>".$logonmessage."</b></p>";
}
?>
<?php builddiv_end() ?>
