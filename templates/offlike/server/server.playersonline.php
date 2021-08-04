<br>
<?php builddiv_start(0, $lang['players_online']) ?>
<?php $MANG = new Mangos; ?>

<style type = "text/css">
  a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
  td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>
<?php write_metalborder_header(); ?>
    <table cellpadding="3" cellspacing="0" width='100%'>
    <tbody>
        <tr>
            <td class="rankingHeader" align="center" colspan="6" nowrap="nowrap"><?php echo $realm_info['name']; ?></td>
        </tr>
		<?php if ($numofpgs > 1) { ?> 
		<tr>
            <td class="rankingHeader" align="center" colspan="6" nowrap="nowrap"><?php echo $lang['page']; ?>:&nbsp;
			<?php
			for ($pnum = 1; $pnum <= $numofpgs; $pnum++) {
			if (isset($_GET["pid"])) {
			if ($_GET["pid"] == $pnum) {
			echo '['.$pnum.']&nbsp;';
			}
			else {
			echo '<a href="index.php?n=server&sub=playersonline&pid='.$pnum.'">'.$pnum.'</a>&nbsp;';
			}
			}
			else {
			if ($pnum == 1) {echo '['.$pnum.']&nbsp;';}
			else {echo '<a href="index.php?n=server&sub=playersonline&pid='.$pnum.'">'.$pnum.'</a>&nbsp;';}
			}
			}
			?>
			</td>
        </tr>
		<?php } ?>
        <tr>
            <td class="rankingHeader" align="center" nowrap="nowrap">#</td>
            <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['name'];?>&nbsp;</td> 
            <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['race'];?>&nbsp;</td>
            <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['class'];?>&nbsp;</td>
            <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['level_short'];?>&nbsp;</td>
            <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['location'];?>&nbsp;</td>
        </tr>
<?php foreach($res_info as $res){ ?>
        <tr>
            <td class="serverStatus<?php echo $res['res_color'] ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $res['number']; ?></b></td>
            <td class="serverStatus<?php echo $res['res_color'] ?>" align="center"><a href="armory/index.php?searchType=profile&character=<?php echo $res['name']; ?>&realm=<?php echo $realm_info['name']; ?>"><b style="color: rgb(35, 67, 3);"><?php echo $res['name']; ?></b></a></td>
            <td class="serverStatus<?php echo $res['res_color'] ?>" align="center"><small style="color: rgb(102, 13, 2);"><img onmouseover="ddrivetip('<?php echo $MANG->characterInfoByID['character_race'][$res['race']]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?php echo $currtmp; ?>/images/icon/race/<?php echo $res['race'];?>-<?php echo $res['gender'];?>.gif" height="18" width="18"></small></td>
            <td class="serverStatus<?php echo $res['res_color'] ?>" align="center"><small style="color: (35, 67, 3);"><img onmouseover="ddrivetip('<?php echo $MANG->characterInfoByID['character_class'][$res['class']]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?php echo $currtmp; ?>/images/icon/class/<?php echo $res['class'];?>.gif" height="18" width="18"></small></td>
            <td class="serverStatus<?php echo $res['res_color'] ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $res['level']; ?></b></td>
            <td class="serverStatus<?php echo $res['res_color'] ?>" align="center"><b style="color: rgb(35, 67, 3);"><?php echo $res['pos'];?></b></td>
        </tr>
<?php } unset($res_info, $res) ?>
<?php if ($numofpgs > 1) { ?> 
		<tr>
            <td class="rankingHeader" align="center" colspan="6" nowrap="nowrap"><?php echo $lang['page']; ?>:&nbsp;
			<?php
			for ($pnum = 1; $pnum <= $numofpgs; $pnum++) {
			if (isset($_GET["pid"])) {
			if ($_GET["pid"] == $pnum) {
			echo '['.$pnum.']&nbsp;';
			}
			else {
			echo '<a href="index.php?n=server&sub=playersonline&pid='.$pnum.'">'.$pnum.'</a>&nbsp;';
			}
			}
			else {
			if ($pnum == 1) {echo '['.$pnum.']&nbsp;';}
			else {echo '<a href="index.php?n=server&sub=playersonline&pid='.$pnum.'">'.$pnum.'</a>&nbsp;';}
			}
			}
			?>
			</td>
        </tr>
		<?php } ?>
    </tbody>
    </table>
<?php write_metalborder_footer(); ?>

<?php unset($MANG); ?>
<?php builddiv_end() ?>