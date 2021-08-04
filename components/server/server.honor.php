<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['honor'],'link'=>'index.php?n=server&sub=honor');
// ==================== //
// some config //
$max_display_chars = 40; // Only top 40 in stats
$MANG = new Mangos;


//Functions
function realm_list()
{
  global $DB;
  $res = $DB->selectCol("SELECT id AS ARRAY_KEY,name FROM realmlist ORDER BY name");
  return $res;
}
function get_rank_numending($n)
{
  $n = substr("$n", -1);
  if($n==1)return 'st';
  elseif($n==2)return 'nd';
  elseif($n==3)return 'rd';
  elseif($n>=4)return 'th';
}
function calc_character_rank($honor_points){
    $rank = 0;
    if($honor_points <= 0){
        $rank = 0;
    }else{
        if($honor_points < 100) $rank = 1;
        else $rank = ceil($honor_points / 1000) + 1;
    }
    if($rank > 14) $rank = 14;
    return $rank;
}
function zerohonorfilter($var){
    return ($var>0);
}

    $pos = 0;
    $realm_list = realm_list();
    $realm = $DB->selectRow("SELECT * FROM realmlist WHERE id=?d LIMIT 1",$user['cur_selected_realmd']);
	$kills = $CHDB->Selectcell("SELECT totalkills FROM characters WHERE name=?d",$charinfo_item['name']);

    $pathway_info[] = array('title'=>$realm['name'],'');

      if($CHDB)$honor = $CHDB->select("SELECT guid, CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(`totalkills`, ' ', ".($MANG->charDataField['PLAYER_FIELD_HONOR_CURRENCY']+0)."), ' ', -1) AS UNSIGNED) AS honor FROM `characters`;");

        foreach($honor as $res_row)
    {
         if($res_row['type']==0){
            $honor_arr[$res_row['guid']] += $res_row['honor'];
        }elseif($res_row['type']==2){
            $honor_arr[$res_row['guid']] -= $res_row['honor'];
        }
    }
    unset($honor);
    if(!is_array($honor_arr))$honor_arr = array();
    $honor_arr = array_filter($honor_arr,"zerohonorfilter");
    arsort($honor_arr);
    $honor_arr = array_slice($honor_arr,0,$max_display_chars,true);
    $allhonor['alliance'] = array();
    $allhonor['horde'] = array();
    $charinfo_arr = array();
    $precharinfo_arr = array();
    if(count($honor_arr)>0)$precharinfo_arr = $CHDB->select("SELECT characters.guid AS ARRAY_KEY,characters.guid,characters.name,characters.race,characters.class,characters.level,characters.gender FROM `characters` WHERE guid IN(?a)",array_keys($honor_arr));
    foreach ($honor_arr as $honor_uid=>$honor_val){
        $charinfo_arr[$honor_uid] = $precharinfo_arr[$honor_uid];
        unset($honor_uid, $honor_val);
    }
    unset($precharinfo_arr);
    // Prepair data ...
    foreach($charinfo_arr as $charinfo_item){
        $char_rank_id = calc_character_rank($honor_arr[$charinfo_item['guid']]);
        if($charinfo_item['race']==1 || $charinfo_item['race']==3 || $charinfo_item['race']==4 || $charinfo_item['race']==7 || $charinfo_item['race']==11)$faction = 'alliance';
        else $faction = 'horde';
        $character = array(
            'name'   => $charinfo_item['name'],
            'race'   => $MANG->characterInfoByID['character_race'][$charinfo_item['race']],
            'class'  => $MANG->characterInfoByID['character_class'][$charinfo_item['class']],
            'gender' => $MANG->characterInfoByID['character_gender'][$charinfo_item['gender']],
            'rank'   => $MANG->characterInfoByID['character_rank'][$faction][$char_rank_id],
            'level'  => $charinfo_item['level'],
            'honorable_kills'    =>  $honor_arr[$charinfo_item['guid']],
            'race_icon'   => $currtmp.'/images/icon/race/'.$charinfo_item['race'].'-'.$charinfo_item['gender'].'.gif',
            'class_icon'   => $currtmp.'/images/icon/class/'.$charinfo_item['class'].'.gif',
            'rank_icon'   => $currtmp.'/images/icon/pvpranks/rank'.$char_rank_id.'.gif',
        );
        $allhonor[$faction][] = $character;
        unset($charinfo_item, $char_gender, $char_rank_id, $faction, $character);
    }

    unset($honor_arr, $charinfo_arr);
    unset($MANG);

?>

