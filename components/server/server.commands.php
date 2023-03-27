<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>$lang['commands'],'link'=>'');
$userlevel = ($user['gmlevel'] != '' ? $user['gmlevel'] : 0);


if($WSDB) {
	$alltopics = $WSDB->select("
	    SELECT *
	    FROM command
	    WHERE security <= $userlevel
	    ORDER BY `name` ASC");
}

?>
