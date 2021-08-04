<br />
<?php builddiv_start(1, "Character Rename System") ?>
Here you can change character names on your server. Please take note that members can change there characters name as well through there account managment!<br /><br />
<form action="index.php?n=admin&sub=chartools" method="post">
<center>
<table width="300" border="0" cellpadding="2px">
  <tr>
    <td>Realm Name</td>
    <td><select name='realm'>
				<?php foreach ($DBS as $realm) {
    echo "<option value='" . $realm['id'] . "'>" . $realm['name'] . "</option>";
} ?>
			</select>
    </td>
  </tr>
  <tr>
    <td>Character Name</td>
    <td><input type='text' name='name' maxlength='20' size='20'/></td>
  </tr>
  <tr>
    <td>New Name</td>
    <td><input type='text' name='newname' maxlength='20' size='20'/></td>
  </tr>
  <td colspan='2' align='center'>
			<input type='submit' name='rename' value='Rename'/>
  </td>
</table>
</center>
</form>
<?php
if(check_online($DBS)){

}

if (isset($_POST['realm'])) {
    $db1 = $DBS[$_POST['realm']];
    if (isset($_POST['rename'])) {
        if (($_POST['name']) == '' or ($_POST['newname']) == '') {
            echo "<p align='center'><font color='red'>" . $empty_field . "</font></p>";
            exit();
        }
        $name = $_POST['name'];
        $newname = ucfirst(strtolower(trim($_POST['newname'])));
        $status = check_if_online($name, $db1);
        $newname_exist = check_if_name_exist($newname, $db1);
        if ($status == -1) {
            echo "<p align='center'><font color='red'>" . $character_1 . $name . $doesntexist .
                "</font></p>";
            exit();
        }
        if ($newname_exist == 1) {
            echo "<p align='center'><font color='red'>" . $alreadyexist . $newname .
                "!</font></p>";
            exit();
        }
        if ($status == 1)
            echo "<p align='center'><font color='red'>" . $character_1 . $name . $isonline .
                "</font></p>";
        else {
            change_name($name, $newname, $db1);
            echo "<p align='center'><font color='blue'>" . $character_1 . $name . $renamesuccess .
                $newname . "!</font></p>";
        }
    }
}
?>
<br />
<?php builddiv_end() ?>