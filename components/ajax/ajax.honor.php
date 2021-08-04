<?php
if(INCLUDED!==true)exit;
$MANG = new Mangos;
$realm = $DB->selectRow("SELECT * FROM realmlist WHERE id=?d LIMIT 1",$user['cur_selected_realmd']);
$honor = $CHDB->select("SELECT * FROM character_kill ORDER BY guid");
foreach($honor as $res_row)
{
    if($res_row['type']==1){
        $honor_arr[$res_row['guid']] += $res_row['honor'];
    }elseif($res_row['type']==2){
        $honor_arr[$res_row['guid']] -= $res_row['honor'];
    }
}
unset($honor);
$honor_arr = array_filter($honor_arr,"zerohonorfilter");
arsort($honor_arr);
$honor_arr = array_slice($honor_arr,0,40,true);
$charinfo_arr = array();
$allhonor = array();
$charinfo_arr = $CHDB->select("SELECT characters.guid,characters.data,characters.name,characters.race,characters.class FROM `characters` WHERE guid IN(?a)",array_keys($honor_arr));
// Prepair for sending data ...
foreach($charinfo_arr as $charinfo_item){
    $char_data = explode(' ',$charinfo_item['data']);
    $char_gender = dechex($char_data[36]);
    $char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
    $char_gender = $char_gender{3};
    $char_rank_id = calc_character_rank($honor_arr[$charinfo_item['guid']]);
    if($charinfo_item['race']==1 || $charinfo_item['race']==3 || $charinfo_item['race']==4 || $charinfo_item['race']==7)$faction = 'alliance';
    else$faction = 'horde';
    $character = array(
        'name'   => $charinfo_item['name'],
        'race'   => $MANG->characterInfoByID['character_race'][$charinfo_item['race']],
        'class'  => $MANG->characterInfoByID['character_class'][$charinfo_item['class']],
        'gender' => $MANG->characterInfoByID['character_gender'][$char_gender],
        'rank'   => $MANG->characterInfoByID['character_gender'][$faction][$char_rank_id],
        'level'  => $char_data[53],
        'lifetime_honorable_kills'    => $char_data[1602],
        'lifetime_dishonorable_kills' => $char_data[1194],
        'race_icon'   => $MW->getConfig->temp->template_href.'images/icon/race/'.$charinfo_item['race'].'-'.$char_gender.'.gif',
        'class_icon'   => $MW->getConfig->temp->template_href.'images/icon/class/'.$charinfo_item['class'].'.gif',
        'rank_icon'   => $MW->getConfig->temp->template_href.'images/icon/pvpranks/'.$charinfo_item['class'].'.gif',
    );
    $allhonor[$faction][] = $character;
}    
//echo'<table>';
//foreach($allhonor[$_GET['faction']]){
    
//}
//echo'</table>';
// Output(send) data
// echo'<pre>';
// print_r($allhonor);
// echo'</pre>';
unset($honor_arr);
unset($charinfo_arr);
unset($MANG);
function calc_character_rank($honor_points){
    $rank = 0;
    if($honor_points <= 0){
        $rank = 0; 
    }else{
        if($honor_points < 2000) $rank = 1;
        else $rank = ($honor_points / 5000) + 1;
    }
    return $rank;
}
function zerohonorfilter($var){
    return ($var>0);
}
?>
