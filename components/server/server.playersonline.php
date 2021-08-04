<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['players_online'],'link'=>'');
if (isset($_GET["pid"])) {$pid = $_GET["pid"];} else {$pid = 1;}
$limit = (int)$MW->getConfig->generic->users_per_page;
$limitstart = ($pid - 1) * $limit;
// ==================== //
 

  $MANG = new Mangos;
  $res_info = array();
  $query = array();
  $realm_info = get_realm_byid($user['cur_selected_realmd']);
  $cc = 0;
    if(check_port_status($realm_info['address'], $realm_info['port'])===true)
    {


        if($CHDB)$query = $CHDB->query("SELECT guid, name, race, class, gender, level, zone  FROM `characters` WHERE `online`='1' AND (NOT `extra_flags` & 1 AND NOT `extra_flags` & 16) ORDER BY `name`");
		$numofpgs = ((int)(count($query) / (int)$MW->getConfig->generic->users_per_page));
		if (gettype(count($query) / (int)$MW->getConfig->generic->users_per_page) != "integer") {
		settype($numofpgs, "integer");
		$numofpgs++;
		}
		if($CHDB)$query = $CHDB->select("SELECT guid, name, race, class, gender, level, zone  FROM `characters` WHERE `online`='1' AND (NOT `extra_flags` & 1 AND NOT `extra_flags` & 16) ORDER BY `name` LIMIT $limitstart,$limit");
    }else{
        output_message('alert','Realm <b>'.$realm_info['name'].'</b> is offline <img src="./templates/WotLK/images/downarrow2.gif" border="0" align="top">');
    }

    foreach ($query as $result) {
        if($res_color==1)$res_color=2;else$res_color=1;
        $cc++;     
        $res_race = $MANG->characterInfoByID['character_race'][$result['race']];
        $res_class = $MANG->characterInfoByID['character_class'][$result['class']];
        $res_pos=$MANG->get_zone_name($result['zone']);

        $res_info[$cc]["number"] = $cc;
        $res_info[$cc]["res_color"] = $res_color;
        $res_info[$cc]["name"] = $result['name'];
        $res_info[$cc]["race"] = $result['race'];
        $res_info[$cc]["class"] = $result['class'];
        $res_info[$cc]["gender"] = $result['gender'];
        $res_info[$cc]["level"] = $result['level'];
        $res_info[$cc]["pos"] = $res_pos;
        $res_info[$cc]["guid"]=$result['guid'];
    }
    unset($query); // Free up memory.
    unset($MANG);

?>
