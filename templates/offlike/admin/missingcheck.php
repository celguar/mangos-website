<?php
include "index.php";
?>
<center><a href="index.php"><?php echo $hidemissingchars; ?></a></center>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<h1 align='center'><?php echo $missingchars; ?></h1>
<table border="1" width="30%" align="center">
<?php
function miss_chars($db,$realm_name)
{
	echo "<tr>
	<th>Realm: ".$realm_name."</th>
	</tr>";
	change_db($db);
	$missed_chars="SELECT DISTINCT `guid` FROM `character_inventory`
						WHERE `guid` NOT IN (SELECT `guid` FROM `characters`)
						ORDER BY `guid`";
	$results=mysql_query($missed_chars)
		or die(mysql_error());
	$number = mysql_numrows($results);
	if ($number<> 0){
		while ($row=mysql_fetch_array($results))
		{
			$guid = $row['guid'];
			echo "<tr>
				<td>$guid</td>
			</tr>";
		}
	} else echo "<tr>
				<td>---</td>
			</tr>";
}

miss_chars($realm1_db,$realmname_1);
miss_chars($realm2_db,$realmname_2);
?>
</table>