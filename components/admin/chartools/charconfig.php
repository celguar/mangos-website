<?php
foreach ($DB->select("SELECT ID FROM `realmlist`") as $IDS) {
	$ID = $IDS['ID'];
	$DBS[$ID]['id'] = $ID;
	$DBS[$ID]['name'] = $DB->selectCell("SELECT name FROM `realmlist` WHERE id=".$ID,1);
	$DBS[$ID]['port'] = $DB->selectCell("SELECT port FROM `realmlist` WHERE id=".$ID,1);
	$DBS[$ID]['server'] = $DB->selectCell("SELECT address FROM `realmlist` WHERE id=".$ID,1);
	$DBS[$ID]['dbinfo'] = $DB->selectCell("SELECT dbinfo FROM `realmlist` WHERE id=".$ID,1);
	$temp = explode(';',$DBS[$ID]['dbinfo']);
	$DBS[$ID]['db'] = $temp['5'];
	$DBS[$ID]['mysql_host'] = $temp['3'];
	$DBS[$ID]['mysql_user'] = $temp['0'];
	$DBS[$ID]['mysql_pass'] = $temp['1'];
	unset($temp);
	$DBS[$ID]['dbinfo'] = 0;
}
?>
<?php
$temp_db="characters_temp";
?>