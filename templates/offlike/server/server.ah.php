<br>
<?php builddiv_start(0, $lang['module_ah']) ?>
<style type = "text/css">

  a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
  td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>

<style media="screen" title="currentStyle" type="text/css">
/*item quality CSS */
a.iqual0:link, a.iqual0:visited { background-color: transparent; color: #9e9e9e; }
a.iqual1:link, a.iqual1:visited { background-color: transparent; color: #eee; }
a.iqual2:link, a.iqual2:visited { background-color: transparent; color: #00ff10; }
a.iqual3:link, a.iqual3:visited { background-color: transparent; color: #0010ff; }
a.iqual4:link, a.iqual4:visited { background-color: transparent; color: #cc00dd; }
a.iqual5:link, a.iqual5:visited { background-color: transparent; color: #ff8810; }
a.iqual6:link, a.iqual6:visited { background-color: transparent; color: #e60000; }

a.iqual0:hover { color: #fff; }
a.iqual1:hover { color: #ff0000; }
a.iqual2:hover { color: #f00; }
a.iqual3:hover { color: #fff; }
a.iqual4:hover { color: #fff; }
a.iqual5:hover { color: #fff; }
a.iqual6:hover { color: #fff; }
/*End item qual CSS*/

/*Fixes/Defns for various table parts*/
td.rankingHeader {background-color: #0e0e0e;}
td.rankingHeader a:link,a:visited {color: #006677;}

tr.ahrow td {border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px; font-size: 0.8em; color: rgb(180, 180, 180);}

font.expired {font-weight:bold; font-size: 0.96em;color: rgb(170, 20, 20);}
/*End fixes/defns*/
  tr.ahrow {background: url('<?php echo $currtmp . "/images/ah_system/ah_tr_bg.jpg"; ?>') }
</style>

<?php 
global $use_itemsite_url;
$use_itemsite_url = "http://www.wowhead.com/?item=";

global $current_time;
$current_time = time();

function item_manage_class($iclass) {
    
    //Two-ish-letter Names
    $iclass_names = array(
        'Cbl',
        'Cnt',
        'Weap',
        'Gem',
        'Armr',
        'Rgt',
        'Prj',
        'TG',
        '',
        'Rcp',
        '',
        'Amo',
        'Ques',
        'Key',
        'MR',
        'Misc',
    );

    return $iclass_names[$iclass];
}
        

function parse_gold($number) {

	$gold = array();
	$gold['gold'] = intval($number/10000);
	$gold['silver'] = intval(($number % 10000)/100);
	$gold['copper'] = (($number % 10000) % 100);

	return $gold;
}

function print_gold($gold_array) {
	global $currtmp;
	if($gold_array['gold'] > 0) {
		echo $gold_array['gold'];
		echo "<img src='".$currtmp."/images/ah_system/gold.GIF'>";
	}
	if($gold_array['silver'] > 0) {
		echo $gold_array['silver'];
		echo "<img src='".$currtmp."/images/ah_system/silver.GIF'>";
	}
	if($gold_array['copper'] > 0) {
		echo $gold_array['copper'];
		echo "<img src='".$currtmp."/images/ah_system/copper.GIF'>";
	}
}

function ah_print_gold($var) {
	if($var == '---') {
		echo $var;
	}
	else {
		print_gold(parse_gold($var));
	}
}


function parse_time($number) {

	$time = array();
	$time['h'] = intval($number/3600);
	$time['m'] = intval(($number % 3600)/60);
	$time['s'] = (($number % 3600) % 60);

	return $time;
}

function print_time($time_array) {
	global $lang;
	$count = 0;
	if($time_array['h'] > 0) {
		echo $time_array['h'];
		echo $lang['ah_hours'];
		$count++;
	}
	if($time_array['m'] > 0) {
		if ($count > 0) echo ',';
		echo $time_array['m'];
		echo $lang['ah_minutes'];
		$count++;
	}
	if($time_array['s'] > 0) {
		if ($count > 0) echo ',';
		echo $time_array['s'];
		echo $lang['ah_seconds'];
	}
}

function ah_time_left($exp_time) {
	global $current_time;
	global $lang;

	$time_left = $exp_time - $current_time;

	if($time_left > 0) {
		print_time(parse_time($time_left));
	}
	else echo "<font class='expired'>" . $lang['ah_expired'] . "</font>";
}

function AHsortlink($clicked) {
	$link = "index.php";
	
	$cf = 0;

	foreach($_GET as $key => $value) {
		if ($key != 'd' && $key != 'sort') {
			if($cf == 0) {
				$link .= '?';
				$cf = 1;
			}
			else {$link .= '&';}
			$link .= $key . '=' . $value;
		}
		elseif ($key == 'sort') {
			if($clicked != null) {
				if($cf == 0) {
					$link .= '?';
					$cf = 1;
				}
				else {$link .= '&';}

				$link .= 'sort=' . $clicked;
				if($_GET['d']!='1' && $value == $clicked) {
					$link .= '&d=1';
				}
			}
		}
	}
	if(!$_GET['sort'] && $clicked != null) $link .= '&sort=' . $clicked;
	return $link;
}

function tableAH($ah_entry) { 
	$current_time = time();
	$time_subtract = 312497;
	$current_time -= $time_subtract;
	global $lang;
	global $use_itemsite_url;
?>
      <table cellpadding='3' cellspacing='0' width='100%' border = '1'>
        <tbody>   
         <tr> 
          <td class='rankingHeader' align='center' colspan='8' nowrap='nowrap'><?php echo $lang['ah_auctionhouse']; ?> <a href="index.php?n=server&sub=ah"><?php echo $lang['ah_reset']; ?></a><br/>
          <a href="<?php echo AHsortlink('quality'); ?>"><?php echo $lang['ah_sortbyquality']; ?></a></td></tr>
		 <tr><td class="rankingHeader" align="center" colspan="8" nowrap="nowrap">
<?php
//if (isset($_GET['filter'])){
//$rmvthis = '&filter='.$_GET["filter"];
//$finalurl = str_replace ($rmvthis, "", $_SERVER['REQUEST_URI']);
//if ($_GET['filter'] == "ally") {echo '['.$lang["ah_alliance"].']&nbsp;&nbsp;-&nbsp;&nbsp;';} else {echo '<a href="'.$finalurl.'&filter=ally">'.$lang["ah_alliance"].'</a>&nbsp;&nbsp;-&nbsp;&nbsp;';}
//if ($_GET['filter'] == "horde") {echo '['.$lang["ah_horde"].']&nbsp;&nbsp;-&nbsp;&nbsp;';} else {echo '<a href="'.$finalurl.'&filter=horde">'.$lang["ah_horde"].'</a>&nbsp;&nbsp;-&nbsp;&nbsp;';}
//if ($_GET['filter'] == "black") {echo '['.$lang["ah_blackwater"].']&nbsp;&nbsp;-&nbsp;&nbsp;';} else {echo '<a href="'.$finalurl.'&filter=black">'.$lang["ah_blackwater"].'</a>&nbsp;&nbsp;-&nbsp;&nbsp;';}
//echo '<a href="'.$finalurl.'">'.$lang["all"].'</a>';
//}
//else {
//echo '<a href="'.$_SERVER['REQUEST_URI'].'&filter=ally">'.$lang["ah_alliance"].'</a>&nbsp;&nbsp;-&nbsp;&nbsp;';
//echo '<a href="'.$_SERVER['REQUEST_URI'].'&filter=horde">'.$lang["ah_horde"].'</a>&nbsp;&nbsp;-&nbsp;&nbsp;';
//echo '<a href="'.$_SERVER['REQUEST_URI'].'&filter=black">'.$lang["ah_blackwater"].'</a>&nbsp;&nbsp;-&nbsp;&nbsp;';
//echo '['.$lang["all"].']';
//}
//
//?>
</td></tr>
<?php
global $numofpgs;
if ($numofpgs > 1) { ?> 
		<tr>
            <td class="rankingHeader" align="center" colspan="8" nowrap="nowrap"><?php echo $lang['page']; ?>:&nbsp;
		<?php
			for ($pnum = 1; $pnum <= $numofpgs; $pnum++) {
			if (isset($_GET["pid"])) {
			if ($_GET["pid"] == $pnum) {
			echo '['.$pnum.']&nbsp;';
			}
			else {
			$rmvthis = '&pid='.$_GET["pid"];
			$finalurl = str_replace ($rmvthis, "", $_SERVER['REQUEST_URI']);
			if (abs($_GET["pid"] - $pnum) < 5) {			
			
			echo '<a href="'.$finalurl.'&pid='.$pnum.'">'.$pnum.'</a>&nbsp;';
			}
			elseif (abs($_GET["pid"] - $pnum) >= 5 && $pnum % 10 == 0) {echo '&nbsp;&nbsp;<a href="'.$finalurl.'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>&nbsp;&nbsp;';}
			elseif ($pnum == 1) {echo '<a href="'.$finalurl.'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>&nbsp;&nbsp;&nbsp;&nbsp;';}
			elseif ($pnum == $numofpgs) {echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$finalurl.'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>';}
			}
			
			}
			else {
			if ($pnum == 1) {echo '['.$pnum.']&nbsp;';}
			else {
			if (abs(1 - $pnum) < 5) {
			echo '<a href="'.$_SERVER['REQUEST_URI'].'&pid='.$pnum.'">'.$pnum.'</a>&nbsp;';}
			elseif (abs($_GET["pid"] - $pnum) >= 5 && $pnum % 10 == 0) {echo '&nbsp;&nbsp;<a href="'.$_SERVER['REQUEST_URI'].'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>&nbsp;&nbsp;';}
			elseif ($pnum == $numofpgs) {echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$_SERVER['REQUEST_URI'].'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>';}
			}
			}
			}
			?>
			</td>
        </tr>
		<?php } ?>
        <tr>
          <td class='rankingHeader' align='center' nowrap='nowrap'><a href="<?php echo AHsortlink('class'); ?>"><?php echo $lang['ah_itemclass']; ?></a></td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><a href="<?php echo AHsortlink('itemname'); ?>"><?php echo $lang['ah_itemname']; ?></a></td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><a href="<?php echo AHsortlink('quantity'); ?>"><?php echo $lang['ah_quantity']; ?></a></td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><a href="<?php echo AHsortlink('seller'); ?>"><?php echo $lang['ah_seller']; ?></a></td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><a href="<?php echo AHsortlink('time'); ?>"><?php echo $lang['ah_time']; ?></a></td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><a href="<?php echo AHsortlink('buyer'); ?>"><?php echo $lang['ah_buyer']; ?></a></td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><a href="<?php echo AHsortlink('currentbid'); ?>"><?php echo $lang['ah_currentbid']; ?></a></td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><a href="<?php echo AHsortlink('buyout'); ?>"><?php echo $lang['ah_buyout']; ?></a></td>
        </tr>
        <?php foreach($ah_entry as $row){ ?>
        <tr class="ahrow">
          <td><?php echo item_manage_class($row['class']);?></td>
          <td><a class="iqual<?php echo $row['quality'];?>" href="<?php echo $use_itemsite_url; echo $row['item_entry'] ; ?>"target="_blank"><?php echo $row['itemname']; ?></a></td>
          <td align='right'><?php echo $row['quantity']; ?></td>
          <td><?php echo $row['seller']; ?></td>
          <td align='right'><?php ah_time_left($row['time']); ?></td>
          <td><?php echo $row['buyer'] ?></td>
          <td align='right'><?php ah_print_gold($row['currentbid']);?></td>
          <td align='right'><?php ah_print_gold($row['buyout']); ?></td>
        </tr>
	<?php }  ?>
	<?php
if ($numofpgs > 1) { ?> 
		<tr>
            <td class="rankingHeader" align="center" colspan="8" nowrap="nowrap"><?php echo $lang['page']; ?>:&nbsp;
		<?php
			for ($pnum = 1; $pnum <= $numofpgs; $pnum++) {
			if (isset($_GET["pid"])) {
			if ($_GET["pid"] == $pnum) {
			echo '['.$pnum.']&nbsp;';
			}
			else {
			$rmvthis = '&pid='.$_GET["pid"];
			$finalurl = str_replace ($rmvthis, "", $_SERVER['REQUEST_URI']);
			if (abs($_GET["pid"] - $pnum) < 5) {			
			
			echo '<a href="'.$finalurl.'&pid='.$pnum.'">'.$pnum.'</a>&nbsp;';
			}
			elseif (abs($_GET["pid"] - $pnum) >= 5 && $pnum % 10 == 0) {echo '&nbsp;&nbsp;<a href="'.$finalurl.'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>&nbsp;&nbsp;';}
			elseif ($pnum == 1) {echo '<a href="'.$finalurl.'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>&nbsp;&nbsp;&nbsp;&nbsp;';}
			elseif ($pnum == $numofpgs) {echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$finalurl.'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>';}
			}
			
			}
			else {
			if ($pnum == 1) {echo '['.$pnum.']&nbsp;';}
			else {
			if (abs(1 - $pnum) < 5) {
			echo '<a href="'.$_SERVER['REQUEST_URI'].'&pid='.$pnum.'">'.$pnum.'</a>&nbsp;';}
			elseif (abs($_GET["pid"] - $pnum) >= 5 && $pnum % 10 == 0) {echo '&nbsp;&nbsp;<a href="'.$_SERVER['REQUEST_URI'].'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>&nbsp;&nbsp;';}
			elseif ($pnum == $numofpgs) {echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$_SERVER['REQUEST_URI'].'&pid='.$pnum.'" style="color: gray">'.$pnum.'</a>';}
			}
			}
			}
			?>
			</td>
        </tr>
		<?php } ?>
        </tbody>
      </table>

<?php
}

?>
<?php write_metalborder_header(); ?>
	<?php tableAH($ah_entry); ?>
<?php write_metalborder_footer(); ?>
<?php builddiv_end() ?>