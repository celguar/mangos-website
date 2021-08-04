<br>
<?php builddiv_start(1, "GM Ticket Manager") ?>
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
       <td class="rankingHeader" align='left' colspan='5'><center>Current Open Tickets</center></td>
       </tr>
       <tr> 
      <td class="rankingHeader" align="center" colspan='5' nowrap="nowrap"><?php echo $realm_info_new['name']; unset($realm_info_new) ?></td>          
    </tr>
    <tr>
      <td class="rankingHeader" align="center" nowrap="nowrap">#</td>
	  <td class="rankingHeader" align="center" nowrap="nowrap">ID</td>
      <td class="rankingHeader" align="center" nowrap="nowrap">Name&nbsp;</td>
      <td class="rankingHeader" align="center" nowrap="nowrap">Message&nbsp;</td>
	  <td class="rankingHeader" align="center" nowrap="nowrap">Gm Comments&nbsp;</td>
    </tr>
<?php foreach($ticket as $item): ?>
    <tr>
      <td class="serverStatus<?php echo $item['color'] ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $item['id']; ?></b></td>
	  <td class="serverStatus<?php echo $item['color'] ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $item['ticket_id']; ?></b></td>
      <td class="serverStatus<?php echo $item['color'] ?>"><a href="armory/index.php?searchType=profile&character=<?php echo $item['player_name']; ?>"><b style="color: rgb(35, 67, 3);"><center><?php echo $item['player_name']; ?></center></b></a></td>
      <td class="serverStatus<?php echo $item['color'] ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $item['message']; ?></b></td>
	  <td class="serverStatus<?php echo $item['color'] ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $item['comment']; ?></b></td>
    </tr>
<?php endforeach; unset($ticket, $item); ?>
    </tbody>
    </table>
<?php write_metalborder_footer(); ?>

<?php unset($MANG); ?>
<?php builddiv_end() ?>