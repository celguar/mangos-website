<br>
<?php builddiv_start(0, $lang['characters']) ?>
<?php $MANG = new Mangos; ?>

<style type="text/css">
  a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
  td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>

<?php write_metalborder_header(); ?>
    <table cellpadding='3' cellspacing='0' width='100%'>
    <tbody>
       <tr> 
       <td class="rankingHeader" align='left' colspan='6'><?php echo  $lang['post_pages'];?>: <?php echo  $pages_str; ?></td>
       </tr>
       <tr> 
      <td class="rankingHeader" align="center" colspan='6' nowrap="nowrap"><?php echo $realm_info_new['name']; unset($realm_info_new) ?></td>          
    </tr>
    <tr>
      <td class="rankingHeader" align="center" nowrap="nowrap">#</td>
      <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['name'];?>&nbsp;</td>
      <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['race'];?>&nbsp;</td>
      <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['class'];?>&nbsp;</td>
      <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['level_short'];?>&nbsp;</td>
      <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['location'];?>&nbsp;</td>
    </tr>
<?php foreach($item_res as $item): ?>
    <tr>
      <td class="serverStatus<?php echo $item['res_color'] ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $item['number']; ?></b></td>
      <td class="serverStatus<?php echo $item['res_color'] ?>"><a href="<?php echo mw_url("armory", "viewchar", array("char"=>$item['guid'])); ?>"><b class="smallBold" style="color: rgb(35, 67, 3);"><?php echo $item['name']; ?></b></a></td>
      <td class="serverStatus<?php echo $item['res_color'] ?>" align="center"><small style="color: rgb(102, 13, 2);"><img onmouseover="ddrivetip('<?php echo $MANG->characterInfoByID['character_race'][$item['race']]; ?>','#ffffff')" onmouseout="hideddrivetip()"
      src="<?php echo $currtmp; ?>/images/icon/race/<?php echo $item['race'];?>-<?php echo $item['gender'];?>.gif" height="18" width="18" alt=""/></small></td>
      <td class="serverStatus<?php echo $item['res_color'] ?>" align="center"><small style="color: (35, 67, 3);"><img onmouseover="ddrivetip('<?php echo $MANG->characterInfoByID['character_class'][$item['class']]; ?>','#ffffff')" onmouseout="hideddrivetip()"
      src="<?php echo $currtmp; ?>/images/icon/class/<?php echo $item['class'];?>.gif" height="18" width="18" alt=""/></small></td>
      <td class="serverStatus<?php echo $item['res_color'] ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $item['level']; ?></b></td>
      <td class="serverStatus<?php echo $item['res_color'] ?>" align="center"><b style="color: rgb(35, 67, 3);"><?php echo $item['pos']; ?></b></td>
    </tr>
<?php endforeach; unset($item_res, $item); ?>
    </tbody>
    </table>
<?php write_metalborder_footer(); ?>

<?php unset($MANG); ?>
<?php builddiv_end() ?>