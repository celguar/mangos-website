<?php
if(INCLUDED!==true)exit;

// ==================== //
$pathway_info[] = array('title'=>$lang['gm_online'],'link'=>'');
// ==================== //

  $MANG = new Mangos;
  $res_info = array();
  $query = array();
  $realm_info = get_realm_byid($user['cur_selected_realmd']);
  $cc = 0;
    if(check_port_status($realm_info['address'], $realm_info['port'])===true)
    {
        if($CHDB)$query = $CHDB->select("SELECT name, race, class, level, zone  FROM `characters` WHERE `online`='1'  AND (`extra_flags` & 1 AND NOT `extra_flags` & 16) ORDER BY `name`");
    }else{
        output_message('alert','Realm <b>'.$realm_info['name'].'</b> is offline <img src="./templates/offlike/images/downarrow2.gif" border="0" align="top">');
    }

    foreach ($query as $result) {
        if($res_color==1)$res_color=2;else$res_color=1;
        $cc++;     
        $res_race = $MANG->characterInfoByID['character_race'][$result['race']];
        $res_class = $MANG->characterInfoByID['character_class'][$result['class']];
        //      $res_pos = "<b>x:</b>$result[position_x] <b>y:</b>$result[position_y] <b>z:</b>$result[position_z]";
        $res_pos=$MANG->get_zone_name($result['zone']);
        $char_data = $result['level'];

        $char_gender = dechex($char_data[$MANG->charDataField['UNIT_FIELD_BYTES_0']]);
        $char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
        $char_gender = $char_gender{3};

        $res_info[$cc]["number"] = $cc;
        $res_info[$cc]["res_color"] = $res_color;
        $res_info[$cc]["name"] = $result['name'];
        $res_info[$cc]["race"] = $result['race'];
        $res_info[$cc]["class"] = $result['class'];
        $res_info[$cc]["gender"] = $char_gender;
        $res_info[$cc]["level"] = $char_data;
        $res_info[$cc]["pos"] = $res_pos;
    }
    unset($WSDB);
    unset($CHDB);
    unset($MANG);

?>
