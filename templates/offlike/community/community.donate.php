<br>
<?php builddiv_start(1, $lang['donate']) ?>
<?php if($user['id']>0){ ?>
<style media="screen" title="currentStyle" type="text/css">
    .postContainerPlain {
        font-family:arial,palatino, georgia, verdana, arial, sans-serif;
        color:#000000;
        padding:5px;
        margin-bottom: 4px;
        font-size: x-small;
        font-weight: normal;
        background-color: #E7CFA3;
        background-image: url('<?php echo $currtmp; ?>/images/light.jpg');
        border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px;
        line-height:140%;
  }
    .postBody {
        padding:10px;
        line-height:140%;
        font-size: small;
  }
    .title {
        font-family: palatino, georgia, times new roman, serif;
        font-size: 13pt;
        color: #640909;
    }
</style>

<style type="text/css">
	small 	{font-family: verdana, arial, sans-serif; font-size:8pt; font-weight:normal;}

	.smallBold {font-family:verdana, arial, sans-serif; font-size:11px; font-weight:bold;}

   	   #text { position: absolute;
			top: 128px;
			left: 0px;

       }

		#char { position: absolute;
			top: -103px;
			left: -20px;

       }

		#wrapper { position: relative;
			z-index: 100;
       }

		#wrapper99 { position: relative;
			z-index: 99;
       }
	   
	a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
    td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
    td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
    td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; 
	border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>

<table cellspacing="0" cellpadding="0" border="0" width = "100%" background = "<?php echo $currtmp; ?>/images/donation/bg.jpg">
<tr>
	<td width = "80%" align = "center">
		<table width = "100%" cellspacing="0" cellpadding="0" border="0">

		<tr>
			<td><div id = "wrapper"><div id = "char"><img src="<?php echo $currtmp; ?>/images/donation/body.gif" width="83" height="177" alt=""></div></div></td>
			<td valign = "top"><img src="<?php echo $currtmp; ?>/images/donation/left.jpg" width="343" height="179" alt=""></td>
<!-------Box Start--->
<td align="right" style="padding-right: 15px; padding-bottom: 15px">
		<!--PlainBox Top-->
		<table cellspacing="0" cellpadding="0" border="0"  border="1"><tr><td width = "3"><img src = "<?php echo $currtmp; ?>/images/donation/plainbox-top-left.gif" width = "3" height = "3" border = "0"></td>
		<td background = "<?php echo $currtmp; ?>/images/donation/plainbox-top.gif"></td><td width = "3"><img src = "<?php echo $currtmp; ?>/images/plainbox/plainbox-top-right.gif" width = "3" height = "3" border = "0"></td>
		</tr><tr><td background = "<?php echo $currtmp; ?>/images/donation/plainbox-left.gif"></td><td style = "background-image: url('<?php echo $currtmp; ?>/images/parchment/plain/light3.jpg');" NOWRAP>
		<!--PlainBox Top-->
		<!--PlainBox Bottom-->
		</td><td background = "<?php echo $currtmp; ?>/images/donation/plainbox-right.gif"></td></tr><tr><td><img src = "<?php echo $currtmp; ?>/images/donation/plainbox-bot-left.gif" width = "3"
		height = "3" border = "0"></td><td background = "<?php echo $currtmp; ?>/images/donation/plainbox-bot.gif"></td><td>
		<img src = "<?php echo $currtmp; ?>/images/donation/plainbox-bot-right.gif" width = "3" height = "3" border = "0"></td></tr></table>
		<!--PlainBox Bottom-->

	</td>
  </tr>
</table>

	</td>
</tr>
</table>
<?php
//          End Templates  Start Content         //
if (isset($_GET['pay']) && $_GET['pay'] == 'finish'){
    $MANG = new Mangos;
    $ep = $CHDB->select("SELECT * FROM `characters` WHERE account='".$user['id']."'");
    foreach($ep as $ap){
        $charid = $ap["guid"];
	      $q = $DB->select("SELECT * FROM `paypal_payment_info` WHERE itemname='".$charid."' AND 	item_given != '1'");

        if(count($q) > 0){
            foreach($q as $data){
                echo 'Payment Done.<br />';
                if ($data['item_given'] != 1){

                    // Aditional payment checks can be done here.
                    $donations_template = $DB->selectRow("SELECT * FROM `donations_template` WHERE id='".$data['itemnumber']."'");
                    // Ok, we must check if we actually got the money that we asked for.
                    if ($donations_template['donation'] > $data['mc_gross']){
                    	$NOT_MAIL = TRUE;
                    }else{
                        $NOT_MAIL = FALSE;
                    }

                    if ($NOT_MAIL == FALSE){
                        if ($MANG->mail_item_donation($data['itemnumber'], $ap['guid'],$ap['txnid']) == TRUE){
							$DB->query("UPDATE `paypal_payment_info` SET item_given='1' WHERE txnid='".$data[txnid]."'");
                            echo $lang['items_sent']."<br /><ul><li>".$lang['username'].": ".$user['username']."</li><li>".$lang['charname'].": ".$ap['name']."</li><li>".$lang['donate']." ".$lang['l_delkey_id'].": ".$data['itemnumber']."</li><li>".$lang['paymentstatus'].": ".$data['paymentstatus']."</li></ul>";
	                    }else{
												echo $lang['items_could_not_be_sent'];
					    }
                    }else{
                    	echo "<ul><li>".$lang['donation_not_face_value']."</li></ul>";
                    }
                }
			}
		}else{
            $no_chars++;
        }
	}
    // Add message if we dont find any donation.
    if ($no_chars){
        echo "<p>".$lang['no_donations_found_for']." <b>".$user['username']."</b>!</p>";
    }
    unset($MANG);
}elseif (isset($_GET["pay"]) && $_GET["pay"] == 'dublicate'){
	output_message('alert',$lang['donation_dup_error'].'<meta http-equiv=refresh content="3;url=index.php?n=community&sub=donate">');
}
else{

?>
<?php
// Check to see what realm we are using
$realm_info_new = get_realm_byid($user['cur_selected_realmd']);
$rid = $realm_info_new['id'];
$rnm = $realm_info_new['name'];
?>
<table align="center" width="100%"><tr><td align="center">
<div style="margin-right: 0pt;" class="postContainerPlain" align="left">
    <h3 class="title"></h3>
    <ul>
        <li><a href='index.php?n=community&amp;sub=donate&amp;pay=finish'>Send items in-game to mailbox.</a> ( You need to buy an item below first. )</li>
    </ul>
    <div class="postBody" style="list-style:square;">
<?php echo $lang['donation_page_desc'];?><br /><br /><center>Packages for your chosen realm: <?php echo $rnm ?><center>
<br />
<?php
$q = $DB->select("SELECT * FROM `donations_template` WHERE realm='$rid' OR realm=0 ORDER BY id");
foreach($q as $data){
	  $id = $data['id'];
?>
<?php write_metalborder_header(); ?>
    <table cellpadding='3' cellspacing='0' width='100%'>
    <tbody>
    <tr> 
      <td class="rankingHeader" align="center" colspan='2' nowrap="nowrap">
	  <?php echo $lang['donation_num']; echo $data['id']; if ($data['description'] == TRUE){ echo " :: <font size=2 color=green>".$data['description']."</font> ::"; } ?>
	  </td>          
    </tr>
    <tr>
      <td class="rankingHeader" align="center" nowrap="nowrap">Item Description&nbsp;</td>
      <td class="rankingHeader" align="center" nowrap="nowrap">Choose&nbsp;</td>
    </tr>
	<tr>
      <td class="serverStatus1"><font size="-1"><center>
	  <?php
		echo "Item(s) included in this donation package:";
		$items = explode(',',$data['items']);
		foreach($items as $item){ 
        $qray = $WSDB->select("SELECT name FROM `item_template` WHERE entry='".$item."'");
        foreach($qray as $d){
			      echo "<li><a href='http://www.wowhead.com/?item=".$item."' target='_blank'>".$d['name']."</a></li>";
        }
    }
		// item sets
		$items_itemset = explode(",", $data['itemset']);
		if ($items_itemset[0] != ''){
		foreach($items_itemset as $itemset_id){
        $qray = $WSDB->select("SELECT name,entry FROM `item_template` WHERE itemset='".$itemset_id."'");
        foreach($qray as $d){
            echo "<li><a href='http://www.wowhead.com/?item=".$d['entry']."' target='_blank'>".$d['name']."</a></li>";
            }
        }
    }
?>  
	  </center></font></a></td>
      <td class="serverStatus1" align="center" width="30%">
	    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="<?php echo $MW->getConfig->donation->PayPal_Email; ?>">
		<input type="hidden" name="notify_url" value="<?php echo $MW->getConfig->temp->base_href;?>donate.php">
		<input type="hidden" name="return" value="<?php echo $MW->getConfig->temp->base_href;?>index.php?n=community&amp;sub=donate&amp;pay=finish">
		<input type="hidden" name="rm" value="2">
		<?php echo $lang['donation_pick_character'];?>&nbsp;&nbsp;&nbsp;
		<select name="item_name">
		<?php
		$qray = $CHDB->select("SELECT * FROM `characters` WHERE account='$user[id]'");
		foreach($qray as $d){
			echo "<option value='".$d['guid']."'>".$d['name']."</option>";
		} ?>
		</select>
		<br /><br /><font size="-2">Cost: <?php echo $data['donation']." ".$data['currency']; ?></font><br />
		<input type="hidden" name="item_number" value="<?php echo $data['id']; ?>" />
		<input type="hidden" name="amount" value="<?php echo $data['donation']; ?>" />
		<input type="hidden" name="no_shipping" value="1" />
		<input type="hidden" name="no_note" value="1" />
		<input type="hidden" name="url_notify" value="http://<?php echo str_replace('index.php','donate.php',($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'])); ?>" />
		<input type="hidden" name="currency_code" value="<?php echo $data['currency']; ?>" />
		<input type="hidden" name="lc" value="<?php echo (string)$MW->getConfig->donation->paypallang;?>" />
		<input type="hidden" name="bn" value="PP-BuyNowBF" />
		<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!" />
		<br />
		<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
	  </td>
    </tr>
	</tbody>
    </table>
<?php write_metalborder_footer(); ?>
<br />
<?php
// 4_-C7Ge33t9lmUYJlAfz3gzAPwjh_H1V5JQqfn-QAt0Vm5cowQLpvHZeIK4
}
?>
</div></div>
</td>
</tr></table>
<?php
	}
}
?>
<?php builddiv_end() ?>