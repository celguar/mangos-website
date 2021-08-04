<?php
class Mangos{
    public $zoneByID;
    public $characterInfoByID;
    public $charDataField;

    public function Mangos(){
        $this->construct_zoneByID();
        $this->construct_characterinfo();
        $this->construct_charDataField();

    }


    public function construct_charDataField(){
        include('./core/cache/mangos_scripts/UpdateFields.php');
        $this->charDataField = $mangos_field;
        unset($mangos_field);
    }
	
public function construct_zoneByID(){
		$this->zoneByID = array(
			36 => 'Alterac Mountains',
			2597 => 'Alterac Valley',
			3358 => 'Arathi Basin',
			45 => 'Arathi Highlands',
			331 => 'Ashenvale',
			3790 => 'Auchindoun: Auchenai Crypts',
			3792 => 'Auchindoun: Mana-Tombs',
			3791 => 'Auchindoun: Sethekk Halls',
			3789 => 'Auchindoun: Shadow Labyrinth',
			4494 => 'Azjol-Nerub: Ahn`kahet: The Old Kingdom',
			3477 => 'Azjol-Nerub: Azjol-Nerub',
			16 => 'Azshara',
			3524 => 'Azuremyst Isle',
			3 => 'Badlands',
			3959 => 'Black Temple',
			719 => 'Blackfathom Deeps',
			1584 => 'Blackrock Depths',
			25 => 'Blackrock Mountain',
			1583 => 'Blackrock Spire',
			2677 => 'Blackwing Lair',
			3522 => 'Blade`s Edge Mountains',
			4 => 'Blasted Lands',
			3525 => 'Bloodmyst Isle',
			3537 => 'Borean Tundra',
			46 => 'Burning Steppes',
			3606 => 'Caverns of Time: Hyjal Summit',
			2367 => 'Caverns of Time: Old Hillsbrad Foothills',
			2366 => 'Caverns of Time: The Black Morass',
			4100 => 'Caverns of Time: The Culling of Stratholme',
			3607 => 'Coilfang Reservoir: Serpentshrine Cavern',
			3717 => 'Coilfang Reservoir: The Slave Pens',
			3715 => 'Coilfang Reservoir: The Steamvault',
			3716 => 'Coilfang Reservoir: The Underbog',
			2817 => 'Crystalsong Forest',
			4395 => 'Dalaran',
			4378 => 'Dalaran Sewers',
			148 => 'Darkshore',
			1657 => 'Darnassus',
			41 => 'Deadwind Pass',
			2257 => 'Deeprun Tram',
			405 => 'Desolace',
			2557 => 'Dire Maul',
			65 => 'Dragonblight',
			4196 => 'Drak`Tharon Keep',
			1 => 'Dun Morogh',
			14 => 'Durotar',
			10 => 'Duskwood',
			15 => 'Dustwallow Marsh',
			139 => 'Eastern Plaguelands',
			12 => 'Elwynn Forest',
			3430 => 'Eversong Woods',
			3820 => 'Eye of the Storm',
			361 => 'Felwood',
			357 => 'Feralas',
			3433 => 'Ghostlands',
			133 => 'Gnomeregan',
			394 => 'Grizzly Hills',
			3618 => 'Gruul`s Lair',
			4375 => 'Gundrak',
			3562 => 'Hellfire Citadel: Hellfire Ramparts',
			3836 => 'Hellfire Citadel: Magtheridon`s Lair',
			3713 => 'Hellfire Citadel: The Blood Furnace',
			3714 => 'Hellfire Citadel: The Shattered Halls',
			3483 => 'Hellfire Peninsula',
			267 => 'Hillsbrad Foothills',
			495 => 'Howling Fjord',
			210 => 'Icecrown',
			1537 => 'Ironforge',
			4080 => 'Isle of Quel`Danas',
			2562 => 'Karazhan',
			38 => 'Loch Modan',
			4095 => 'Magisters` Terrace',
			2100 => 'Maraudon',
			2717 => 'Molten Core',
			493 => 'Moonglade',
			215 => 'Mulgore',
			3518 => 'Nagrand',
			3456 => 'Naxxramas',
			3523 => 'Netherstorm',
			2159 => 'Onyxia`s Lair',
			1637 => 'Orgrimmar',
			2437 => 'Ragefire Chasm',
			722 => 'Razorfen Downs',
			491 => 'Razorfen Kraul',
			44 => 'Redridge Mountains',
			3429 => 'Ruins of Ahn`Qiraj',
			3968 => 'Ruins of Lordaeron (Undercity)',
			796 => 'Scarlet Monastery',
			2057 => 'Scholomance',
			51 => 'Searing Gorge',
			209 => 'Shadowfang Keep',
			3520 => 'Shadowmoon Valley',
			3703 => 'Shattrath City',
			3711 => 'Sholazar Basin',
			1377 => 'Silithus',
			3487 => 'Silvermoon City',
			130 => 'Silverpine Forest',
			406 => 'Stonetalon Mountains',
			1519 => 'Stormwind City',
			4384 => 'Strand of the Ancients',
			33 => 'Stranglethorn Vale',
			2017 => 'Stratholme',
			1417 => 'Sunken Temple',
			4075 => 'Sunwell Plateau',
			8 => 'Swamp of Sorrows',
			440 => 'Tanaris',
			141 => 'Teldrassil',
			3846 => 'Tempest Keep: The Arcatraz',
			3847 => 'Tempest Keep: The Botanica',
			3842 => 'Tempest Keep: The Eye',
			3849 => 'Tempest Keep: The Mechanar',
			3428 => 'Temple of Ahn`Qiraj',
			3519 => 'Terokkar Forest',
			17 => 'The Barrens',
			3702 => 'The Circle of Blood (Blade`s Edge)',
			1581 => 'The Deadmines',
			3557 => 'The Exodar',
			47 => 'The Hinterlands',
			4500 => 'The Nexus: The Eye of Eternity',
			4120 => 'The Nexus: The Nexus',
			4228 => 'The Nexus: The Oculus',
			4493 => 'The Obsidian Sanctum',
			3698 => 'The Ring of Trials (Nagrand)',
			4406 => 'The Ring of Valor (Orgrimmar)',
			4298 => 'The Scarlet Enclave',
			717 => 'The Stockade',
			67 => 'The Storm Peaks',
			457 => 'The Veiled Sea',
			4415 => 'The Violet Hold',
			400 => 'Thousand Needles',
			1638 => 'Thunder Bluff',
			85 => 'Tirisfal Glades',
			1337 => 'Uldaman',
			4272 => 'Ulduar: Halls of Lightning',
			4264 => 'Ulduar: Halls of Stone',
			490 => 'Un`Goro Crater',
			1497 => 'Undercity',
			206 => 'Utgarde Keep: Utgarde Keep',
			1196 => 'Utgarde Keep: Utgarde Pinnacle',
			4603 => 'Vault of Archavon',
			718 => 'Wailing Caverns',
			3277 => 'Warsong Gulch',
			28 => 'Western Plaguelands',
			40 => 'Westfall',
			11 => 'Wetlands',
			4197 => 'Wintergrasp',
			618 => 'Winterspring',
			3521 => 'Zangarmarsh',
			3805 => 'Zul`Aman',
			66 => 'Zul`Drak',
			978 => 'Zul`Farrak',
			19 => 'Zul`Gurub',
);
}

    public function construct_characterinfo(){
        global $lang;
        $this->characterInfoByID = array(
            'character_race' => array(
                1 => $lang['Human'],
                2 => $lang['Orc'],
                3 => $lang['Dwarf'],
                4 => $lang['Nightelf'],
                5 => $lang['Undead'],
                6 => $lang['Tauren'],
                7 => $lang['Gnome'],
                8 => $lang['Troll'],
                9 => $lang['Goblin'],
                10 => $lang['Bloodelf'],
                11 => $lang['Dranei'],
            ),
            'character_class' => array(
                1 => $lang['Warrior'],
                2 => $lang['Paladin'],
                3 => $lang['Hunter'],
                4 => $lang['Rogue'],
                5 => $lang['Priest'],
				6 => $lang['Death_Knight'],
                7 => $lang['Shaman'],
                8 => $lang['Mage'],
                9 => $lang['Warlock'],
                11 => $lang['Druid'],
            ),

            'character_gender' => array(
                0 => $lang['male'],
                1 => $lang['female'],
                2 => 'None',
            ),
            'character_rank' => array(
                'alliance' => array(
                    1 => $lang['ar1'],
                    2 => $lang['ar2'],
                    3 => $lang['ar3'],
                    4 => $lang['ar4'],
                    5 => $lang['ar5'],
                    6 => $lang['ar6'],
                    7 => $lang['ar7'],
                    8 => $lang['ar8'],
                    9 => $lang['ar9'],
                    10 => $lang['ar10'],
                    11 => $lang['ar11'],
                    12 => $lang['ar12'],
                    13 => $lang['ar13'],
                    14 => $lang['ar14']
                ),
                'horde' => array(
                    1 => $lang['hr1'],
                    2 => $lang['hr2'],
                    3 => $lang['hr3'],
                    4 => $lang['hr4'],
                    5 => $lang['hr5'],
                    6 => $lang['hr6'],
                    7 => $lang['hr7'],
                    8 => $lang['hr8'],
                    9 => $lang['hr9'],
                    10 => $lang['hr10'],
                    11 => $lang['hr11'],
                    12 => $lang['hr12'],
                    13 => $lang['hr13'],
                    14 => $lang['hr14']
                )
            )
        );
    }

    public function get_zone_name($zoneid){
        if (isset($this->zoneByID[$zoneid])){
            $zonename=$this->zoneByID[$zoneid];
        }else{
            $zonename='Unknown zone';
        }
        return $zonename;
    }

    /* Function: Mail item to player with donation ID and who to deliver item too
     * Vars: $donate_item_id = ID defined in realmd.donation_template
     *       $character_item_id = Character ID from world.character that the item is beeing sent too.
     *       $txnid = The ID of the donation.
     *       $admin_send = If admin is true paypal is not involved and you can use this as a send function.
     */
    public function mail_item_donation($donate_item_id, $character_item_id, $txnid=false,$admin_send = false){
        global $WSDB;
        global $DB;
        global $CHDB;

        #Constants
        $error_output = 0; // Inizializer for error outputing
        $donateid = $donate_item_id; // The donation ID in table donation_template
        $guid = $character_item_id; // The character that is getting the item(s)
        $offset_mail_guid = 30000; // Offset guid to start at. This is recommanded to be as high! Also to high may cause problems , around 10000 to 40000 is nice. It really depends on your server if it has like 1000 users on all the time its recommanded to have it to 500000. Notice, to high will cause mangos server to crash.
        $donation_template = $DB->selectRow("SELECT * FROM `donations_template` WHERE id='".$donateid."'");
        $ROUNDS = 0; // Rounds is to check how many times loop goes. NOT CHANGE THIS!
        $items = explode(",", $donation_template['items']);

        // Generate item's from item-sets if find any item sets of course. :)
        $items_itemset = explode(",", $donation_template['itemset']);
        if ($items_itemset[0] != ''){
            foreach($items_itemset as $itemset_id){
                $qray = $WSDB->select("SELECT entry FROM `item_template` WHERE itemset='".$itemset_id."'");
                foreach($qray as $d){
                    $items[] = $d['entry'];
                }
            }
        }
        foreach($items as $self => $item){
            if ($item == '' || !is_numeric($item)){
                unset($items[$self]);
            }
        }

        foreach ($items as $item_id){


            $data = $WSDB->selectRow("SELECT * FROM `item_template` WHERE entry='".$item_id."'");

            // We need to get a unquie guid for char_inv. Problem is that mangos is caching and not updated on sql.
            // Therefor we need to create a offset guid.


            $ROUNDS++;
            // If this is the first loop we must check if we MUST increment with offset or if we can just apply id +1
            $new_guid = $this->mangos_newguid('item_instance');
            $item = $new_guid['new_guid'];
            $WE_DID_OFFSET_ID = $new_guid['incr'];



            ## array FOR ITEM_INSTANCE, THERE ARE $this->charDataField['ITEM_END'] Fields if not a bag.
            ## IF BAG its $this->charDataField['CONTAINER_END'] fields.
            $item_instance_value = array();
            for($i=0;$i<$this->charDataField['ITEM_END'];$i++)$item_instance_value[$i]=0;



            ## Defines
            $item_instance_value[$this->charDataField['OBJECT_FIELD_GUID']] = $item;    //Guid
            $item_instance_value[$this->charDataField['OBJECT_FIELD_TYPE']] = 1073741936;  //defaultvalue
            $item_instance_value[$this->charDataField['OBJECT_FIELD_ENTRY']] = $data['entry'];//entry
            $item_instance_value[$this->charDataField['OBJECT_FIELD_SCALE_X']] = 1065353216; //defaultvalue
            $item_instance_value[$this->charDataField['ITEM_FIELD_OWNER']] = 1;  //owner_guid
            $item_instance_value[$this->charDataField['ITEM_FIELD_STACK_COUNT']] = 1; // Stacks. Amount
            $item_instance_value[$this->charDataField['ITEM_FIELD_FLAGS']] = $data['Flags']; //Flags
            $item_instance_value[$this->charDataField['ITEM_FIELD_DURABILITY']] = $data['MaxDurability']; // Min Durability
            $item_instance_value[$this->charDataField['ITEM_FIELD_MAXDURABILITY']] = $data['MaxDurability'] ; // Max Durability

            if ($data['InventoryType'] == 18){  // If this is A Bag.
               // X fields to Bag slot.
                for($i=$this->charDataField['ITEM_END'];$i<$this->charDataField['CONTAINER_END'];$i++)$item_instance_value[$i]=0;
                $item_instance_value[$this->charDataField['OBJECT_FIELD_TYPE']]= "7";
                $item_instance_value[$this->charDataField['CONTAINER_FIELD_NUM_SLOTS']]= $data['ContainerSlots'];   // Slots on bag
                $item_instance_value[$this->charDataField['CONTAINER_ALIGN_PAD']]= "0";  // CONTAINER_ALIGN_PAD

            }else{ $item_instance_value[$this->charDataField['OBJECT_FIELD_TYPE']] = 3;}
            if ($data['spellid_1'] != 0){ $item_instance_value['16'] = 4294967295; }else{ $item_instance_value['16'] = 0; }


            ## // ## Main operation ## \\ ##
				
            $additem_code = implode($item_instance_value, ' ');
            $data_field = $additem_code;
				
			// Here we count how many of the current item the user has
			$count_insert1 = $CHDB->select("SELECT data FROM `item_instance` WHERE guid='$item' AND owner_guid='$guid'");
			$count1 = count($count_insert1);
			$insert1 = $CHDB->query("INSERT INTO `item_instance` (guid, owner_guid, data) VALUES('".$item."', '".$guid."', '".$data_field."')");
				
			// Lets check to see if our query was successful
			$check_insert1 = $CHDB->select("SELECT data FROM `item_instance` WHERE guid='$item' AND owner_guid='$guid'");
			$check_finalcount = count($check_insert1);
				
			// If the user has more of the item he selected, then when we started, then success!
            if ($check_finalcount > $count1){

                $new_guid = $this->mangos_newguid('mail');
                $mail_id = $new_guid['new_guid'];
                $WE_DID_OFFSET_ID = $new_guid['incr'];

				// case active. We need to add slash if its Some other in db who has ' "
				## Constants
				$insertitem = str_replace("'","\'", $data['name']);
				$timestampplus_start = date('YmdHis', time());
				$startitemnow_unix = strtotime($timestampplus_start);
					
				// Here we create the mail message for the item, and check to see if the query was successfull. If the mail message exists, then we move on
				$insert2 = $CHDB->query("INSERT INTO mail (id, messageType, stationery, sender, receiver, subject, body, has_items, expire_time, deliver_time, money, cod, checked)
                    VALUES('".$mail_id."','0','41','1','".$guid."','".$insertitem."','Thank you for your donation!','1','32495688732','".$startitemnow_unix."','0','0','0')");
				$check_insert2 = $CHDB->select("SELECT id FROM mail WHERE id='$mail_id' AND receiver='$guid'");
				if (count($check_insert2) > 0){
				
					// Lets check to see if the placing of the item, in the mail message was successfull
					$insert3 = $CHDB->query("INSERT INTO mail_items (mail_id, item_guid, item_template, receiver) VALUES ('".$mail_id."','".$item."','".$data['entry']."','".$guid."')");
					$check_insert3 = $CHDB->select("SELECT mail_id FROM mail_items WHERE mail_id='$mail_id' AND receiver='$guid'");
					if (count($check_insert3) > 0){
					echo "<font color='blue'><br />Success!&nbsp</font>";
					}else{ $error_output++; echo "<br /><font color='red'>MySQL Error: Problem inserting item into mail.</font><br />"; }
				}else{ $error_output++; echo "<br /><font color='red'>MySQL Error: Problem creating mail message.</font><br />"; }
			}else{ $error_output++; echo "<br /><font color='red'>MySQL Error: Problem inserting data into \"Item Instance\" table.</font><br />"; }

        }
		// Return true if all query's where successful. Else return false
        if ($error_output == 0){
            if ($admin_send == true){
                return TRUE;
            }else{
                return TRUE;
            }
        }else{
        return FALSE;
      }
    }



    /*   Function used to increase guids to any database in mangos. ( Must be in switch beneath and in database world_entrys ).
     *   Return type array,
     *   Return values, [New_guid], [(bool) If we did increment or not]
     *   $database defined in World database and table world_entrys in REALM database
     */
    public function mangos_newguid($database){
        global $WSDB,$DB, $CHDB;
        // We check here for processtimes and checks with mangos.
        $highest_mangostime = $DB->selectCell("SELECT `starttime` FROM `uptime` ORDER BY starttime DESC LIMIT 0,1");

        // We store timestamps and incre info in database.
        $last_increment = $DB->selectCell("SELECT last_inc FROM `world_entrys` WHERE db_name='".$database."'");

        // We find the max guid of the wanted table.
        // Maybe some tables have other name of "guid" example: "id". Also define the Id we want to increase with.
        switch($database){
            case 'character':
                $last_id_cell_maxguid = $CHDB->selectCell("SELECT MAX(guid) FROM `".$database."s`");
                $offset_incre_guid = 0;
            break;
            case 'item_instance':
                $last_id_cell_maxguid = $CHDB->selectCell("SELECT MAX(guid) FROM `".$database."`");
                $offset_incre_guid = 20000;
            break;
            case 'mail':
                $last_id_cell_maxguid = $CHDB->selectCell("SELECT MAX(id) FROM `".$database."`");
                $offset_incre_guid = 5000;
            break;
        }
        // Die if we didnt find the databases properties.
        if ($last_id_cell_maxguid == '' && $offset_incre_guid == ''){
            die("Database you tried to Increase ID is not in switch in common.php also proberly not in database relamd.world_entrys");
        }

        // Now we need to find out Whenever we want to create new High ids or not.
        // If mangos START stamp is higher then lastest transfer we must increase ID with offset. Else we can just go on.
        if ($last_increment < $highest_mangostime || $last_increment == ''){
            $DB->query("UPDATE `world_entrys` SET last_inc='".time()."',last_id='".$last_id_cell_maxguid."' WHERE db_name='".$database."'");
            $last_id_cell = $last_id_cell_maxguid + $offset_incre_guid+1;
            $WE_DID_OFFSET_ID = TRUE;
        }else{
            $last_id_cell = $last_id_cell_maxguid+1;
            $WE_DID_OFFSET_ID = FALSE;
        }
        $array = array(
            'new_guid' => $last_id_cell,
            'incr' => $WE_DID_OFFSET_ID,
        );
        return $array;

    }

}

?>
