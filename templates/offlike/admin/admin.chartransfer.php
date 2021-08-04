<br />
<?php builddiv_start(1, "Character Transfer Manager") ?>
<style>
div.errorMsg { width: 80%; height: 30px; line-height: 30px; font-size: 10pt; border: 2px solid #e03131; background: #ff9090;}
</style>
<center>
<form action='index.php?n=admin&sub=chartransfer' method='post'>
<table width="300" border="0" cellpadding="2px">
<tr>
    <td>Character Name</td>
    <td><input type='text' name='name' maxlength='20' size='20'/></td>
  </tr>
<tr>
    <td>Current Realm</td>
    <td><select name='realm'>
				<?php foreach ($DBS as $realm){
					echo "<option value='".$realm['id']."'>".$realm['name']."</option>";
				}?>
			</select>
    </td>
  </tr>
  <tr>
    <td>Target Realm</td>
    <td><select name='newrealm'>
				<?php foreach ($DBS as $realm){
					echo "<option value='".$realm['id']."'>".$realm['name']."</option>";
				}?>
			</select>
    </td>
  </tr>
  <td colspan='2' align='center'>
<?php $disabled = ""; echo "<input type='submit' name='move_char' ".$disabled." value='".$transfer."'/>
				<input type='submit' name='clean_db' ".$disabled." value='".$cleandb."'/>";
?></td></table></form>
</center>
<?php
if(check_online($DBS)){
    echo "<p align='center'><font color='red'>" . $serveron_1 . "</font></p>";
}
if(isset($_POST['realm'])){
	$db1=$DBS[$_POST['realm']];
	$db2=$DBS[$_POST['newrealm']];
}
if(isset($_POST['rename']))
{
	if(($_POST['name'])=='' or ($_POST['newname'])=='')
	{
		echo "<p align='center'><font color='red'>".$empty_field."</font></p>";
		exit();
	}
	$name=$_POST['name'];
	$newname=ucfirst(strtolower(trim($_POST['name'])));
	$status = check_if_online($name,$db1);
	$newname_exist = check_if_name_exist($newname,$db1);
	if($status == -1)
	{
		echo "<p align='center'><font color='red'>".$character.$name.$doesntexist."</font></p>";
		exit();
	}
	if($newname_exist == 1)
	{
		echo "<p align='center'><font color='red'>".$alreadyexist.$newname."!</font></p>";
		exit();
	}
	if($status == 1)
		echo "<p align='center'><font color='red'>".$character.$name.$isonline."</font></p>";
	else
	{
		change_name($name,$newname,$db1);
		echo "<p align='center'><font color='blue'>".$character.$name.$renamesuccess.$newname."!</font></p>";
	}
}
else if(isset($_POST['move_char']))
{
	if(($_POST['name'])=='')
	{
		echo "<p align='center'><font color='red'>".$mustentername."</font></p>";
		exit();
	}
	$name=$_POST['name'];
	$newname=ucfirst(strtolower(trim($_POST['name'])));
	if($newname <> "")
	{
		$newname_exist = check_if_name_exist($newname,$db2);
		if($newname_exist == 1)
		{
			echo "<p align='center'><font color='red'>".$alreadyexist.$newname."!</font></p>";
			exit();
		}
	}
	if(($newname <> "") or (check_if_name_exist($name,$db2) == 0))
	{
		$char_guid = select_char($name,$db1);
		if($char_guid>0)
		{
			truncate_db($temp_db);
			move($char_guid,$db1,$temp_db);
			if(($newname <> "") and ($newname_exist <> 1))
				change_name($name,$newname,$temp_db);
			cleanup($temp_db);
			foreach($tab_guid_change as $value)
			{
				$max_guid = select_max_guid($db2,$value[0],$value[1]);
				change_guid($temp_db,$max_guid,$value[2],$value[0],$value[1]);
				if($value[0]=='characters')
					$max_char_guid=$max_guid;
			}
			move($max_char_guid+1,$temp_db,$db2);
			truncate_db($temp_db);
			del_char($char_guid,$db1);
			echo "<p align='center'><font color='blue'>".$character.$name.$transfersuccess."</font></p>";
			if(($newname <> "") and ($newname_exist <> 1))
				echo "<p align='center'><font color='blue'>".$character.$name.$renamesuccess.$newname."!</font></p>";
		}
		else
			echo "<p align='center'><font color='red'>".$character.$name.$doesntexist."</font></p>";
	}
	else
		echo "<p align='center'><font color='red'>".$character.$name.$alreadytransfered."</font></p>";
}
else if(isset($_POST['clean_db']))
{
	$db1=$DBS[$_POST['realm']];
	clean_after_delete($db1);
	echo "<p align='center'><font color='blue'>".$clearDBsuccess."</font></p>";
}

builddiv_end() ?>