<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>'GM list','link'=>'');

$gmlevel_w = array('Users','Moderators','Game Masters','Administrators');

$result = $DB->select("
    SELECT username, gmlevel 
    FROM account 
    WHERE gmlevel>0
    ORDER BY gmlevel,username 
");
$gm_groups = array();
foreach($result as $r){
    $gm_groups[$r['gmlevel']][] = $r['username'];
}
$gm_groups = array_reverse($gm_groups,true);
unset($result);
?>