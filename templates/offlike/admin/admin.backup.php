<br>
<?php builddiv_start(1, "Backup") ?>
<?php
if (is_writable("core/cache/sql_backups/") == FALSE)die(' core/cache/sql_backups/ Must be writeable to use this function! Chmod the folder to so webserver can write to this folder! ( All permissions! ).');

if ($_GET['backup'] == TRUE){

  switch($_GET['backup']) {
      case copy_chars:
          $File = "core/cache/sql_backups/copy_chars_".date('S_F_Y_h_i_s_A').".php";
          $DATA = '';
          $START_GUID = $_POST['starting_char_id'];

          // Characters looping
          $sql_character = $CHDB->select("SELECT * FROM `characters` WHERE account='".(int)$MW->getConfig->character_copy_config->accounts->horde."' OR account='".(int)$MW->getConfig->character_copy_config->accounts->alliance."'");
          if (count($sql_character) == 0)die('<p>No characters backup because in config file we dont find the IDs of the characters accounts.</p>');
          
          // Create file!.
          $Handle = fopen($File, 'w');

          // Headers:
          $DATA = "<?php\n";
          $DATA .= "<<<EOF\n\n";

          foreach($sql_character as $COPY_character){
            $query_character_id = $COPY_character['guid'];
            // Filter data , make new ID's.
            $COPY_character['guid'] = $START_GUID;
            $COPY_character['data'] = explode(' ', $COPY_character['data']);
            $COPY_character['data']['0'] = $START_GUID;
            $COPY_character['data'] = implode(' ', $COPY_character['data']);
            // Characters
            $DATA .= "INSERT INTO `characters` (
            `guid`,
            `account`,
            `data`,
            `name`,
            `race`,
            `class`,
            `position_x`,
            `position_y`,
            `position_z`,
            `map`,
            `orientation`,
            `taximask`,
            `online`,
            `cinematic`,
            `totaltime`,
            `leveltime`,
            `logout_time`,
            `is_logout_resting`,
            `rest_bonus`,
            `resettalents_cost`,
            `resettalents_time`,
            `trans_x`,
            `trans_y`,
            `trans_z`,
            `trans_o`,
            `transguid`,
            `gmstate`,
            `stable_slots`,
            `rename`)
             VALUES \n
            ('".$COPY_character['guid']."', '".$COPY_character['account']."', '".$COPY_character['data']."', '".$COPY_character['name']."', '".$COPY_character['race']."', '".$COPY_character['class']."', '".$COPY_character['position_x']."',
            '".$COPY_character['position_y']."', '".$COPY_character['position_z']."', '".$COPY_character['map']."', '".$COPY_character['orientation']."', '".$COPY_character['taximask']."', '".$COPY_character['online']."',
            '".$COPY_character['cinematic']."', '".$COPY_character['totaltime']."', '".$COPY_character['leveltime']."', '".$COPY_character['logout_time']."', '".$COPY_character['is_logout_resting']."',
            '".$COPY_character['rest_bonus']."', '".$COPY_character['resettalents_cost']."', '".$COPY_character['resettalents_time']."', '".$COPY_character['trans_x']."', '".$COPY_character['trans_y']."',
            '".$COPY_character['trans_z']."', '".$COPY_character['trans_o']."', '".$COPY_character['transguid']."', '".$COPY_character['gmstate']."', '".$COPY_character['stable_slots']."', '".$COPY_character['rename']."');\n";
            
            $guid = $COPY_character['guid'];
        $COPY_character_action = $CHDB->select("SELECT * FROM `character_action` WHERE guid='".$query_character_id."'");
        /* Character_action */
        foreach($COPY_character_action as $COPY_SUB_character_action){
            $DATA .="INSERT INTO `character_action` (
            `guid`,
            `button`,
            `action`,
            `type`,
            `misc`)
             VALUES\n
            ('".$guid."' , '".$COPY_SUB_character_action['button']."', '".$COPY_SUB_character_action['action']."', '".$COPY_SUB_character_action['type']."', '".$COPY_SUB_character_action['misc']."');\n";
        }
        /* Character_homebind */
        $COPY_character_homebind = $CHDB->select("SELECT * FROM `character_homebind` WHERE guid='".$query_character_id."'");
        foreach($COPY_character_homebind as $COPY_SUB_character_homebind){
            $DATA .= "INSERT INTO `character_homebind` (
            `guid`,
            `map`,
            `zone`,
            `position_x`,
            `position_y`,
            `position_z`)
             VALUES\n
            ('".$guid."' , '".$COPY_SUB_character_homebind['map']."', '".$COPY_SUB_character_homebind['zone']."',
            '".$COPY_SUB_character_homebind['position_x']."', '".$COPY_SUB_character_homebind['position_y']."', '".$COPY_SUB_character_homebind['position_z']."');\n";
        }

        /* Character_reputation */
        $COPY_character_reputation = $CHDB->select("SELECT * FROM `character_reputation` WHERE guid='".$query_character_id."'");
        foreach($COPY_character_reputation as $COPY_SUB_character_reputation){
            $DATA .= "INSERT INTO `character_reputation` (
            `guid`,
            `faction`,
            `standing`,
            `flags`)
             VALUES\n
            ('".$guid."', '".$COPY_SUB_character_reputation['faction']."', '".$COPY_SUB_character_reputation['standing'].", '".$COPY_SUB_character_reputation['flags']."');\n";
        }
        /*  Character_spell  */
        $COPY_character_spell = $CHDB->select("SELECT * FROM `character_spell` WHERE guid='".$query_character_id."'");
        foreach($COPY_character_spell as $COPY_SUB_character_spell){
            $DATA .= "INSERT INTO `character_spell` (
            `guid`,
            `spell`,
            `slot`,
            `active`)
             VALUES\n
            ('".$guid."', '".$COPY_SUB_character_spell['spell']."', '".$COPY_SUB_character_spell['slot']."', '".$COPY_SUB_character_spell['active']."');\n";
        }
        /* Character_tutorail  */
        $COPY_character_tutorial = $CHDB->select("SELECT * FROM `character_tutorial` WHERE guid='".$query_character_id."'");
        foreach($COPY_character_tutorial as $COPY_SUB_character_tutorial){
            $DATA .= "INSERT INTO `character_tutorial` (
            `guid`,
            `tut0`,
            `tut1`,
            `tut2`,
            `tut3`,
            `tut4`,
            `tut5`,
            `tut6`,
            `tut7`)
             VALUES\n
            ('".$guid."', '".$COPY_SUB_character_tutorial['tut0']."', '".$COPY_SUB_character_tutorial['tut1']."', '".$COPY_SUB_character_tutorial['tut2']."',
            '".$COPY_SUB_character_tutorial['tut3']."', '".$COPY_SUB_character_tutorial['tut4']."', '".$COPY_SUB_character_tutorial['tut5']."',
            '".$COPY_SUB_character_tutorial['tut6']."', '".$COPY_SUB_character_tutorial['tut7']."');\n";
        }

        /* item_instance  */

        $COPY_item_instance = $CHDB->select("SELECT * FROM `item_instance` WHERE owner_guid='".$query_character_id."'");
            foreach($COPY_item_instance as $COPY_SUB_item_instance){
                //Filter guids
                $COPY_SUB_item_instance['data'] = explode(' ', $COPY_SUB_item_instance['data']);
                $COPY_SUB_item_instance['data']['6'] = $guid;
                $COPY_SUB_item_instance['data']['8'] = $guid;
                $COPY_SUB_item_instance['data'] = implode(' ', $COPY_SUB_item_instance['data']);
            $DATA .= "INSERT INTO `item_instance` (
            `guid`,
            `owner_guid`,
            `data`)
             VALUES\n
            ('".$COPY_SUB_item_instance['guid']."', '".$guid."', '".$COPY_SUB_item_instance['data']."');\n";
            }
        /* character_inventory  */
        $COPY_character_inventory = $CHDB->select("SELECT * FROM `character_inventory` WHERE guid='".$query_character_id."'");
            foreach($COPY_character_inventory as $COPY_SUB_character_inventory){
            $DATA .= "INSERT INTO `character_inventory` (
            `guid`,
            `bag`,
            `slot`,
            `item`,
            `item_template`)
            VALUES\n
            ('".$guid."', '".$COPY_SUB_character_inventory['bag']."', '".$COPY_SUB_character_inventory['slot']."', '".$COPY_SUB_character_inventory['item']."', '".$COPY_SUB_character_inventory['item_template']."');\n";
            }

          $START_GUID++;
          }
          // Footers
          $DATA .= "\n\nEOF;\n";
          $DATA .= "?>";
          fwrite($Handle, $DATA);
          echo "Character_backup copy was wrote to <br /><b>".$File."</b>.<br />To import these in mysql table: You must open the file in an editor and copy the code between the \"EOF's\" at the bottom and upper of the file to export it to World database-";
      break;
  }

}else{
?>
<ul>
<li><form action='index.php?n=admin&sub=backup&backup=copy_chars' method='POST'>Copy chars backup - <b>Starting ID of characters: </b><input type='text' style='width:40px;' name='starting_char_id' value='10'><input type='submit' value='Create backup'></form></li>
</ul>
<?php
}
?>
<?php builddiv_end() ?>