<br>
<?php builddiv_start(1, "Donate admin") ?>
<?php
if(INCLUDED!==true)exit;
function check_item_id_donation($field){
  /*  $arr = explode(',', $field);
    foreach($arr as $item){
        if (is_numeric($item) == FALSE){
            $false = TRUE;
        }
    }
    if ($false == TRUE){
        return FALSE;
    }else{
        return TRUE;
    } */
    return TRUE;
}
$realmz = $DB->select("SELECT id,name FROM realmlist ORDER BY name");
foreach($realmz as $aaa) {
$realmzlist .= "<option value='".$aaa['id']."'>".$aaa['name']."</option>";
}
if (isset($_POST['donate_username']) && isset($_POST['donate_items'])){
    $character_item_id = $CHDB->selectCell("SELECT guid FROM `characters` WHERE name='".mysql_real_escape_string($_POST['donate_username'])."'");
    if ($character_item_id != '' && $_POST['donate_username'] != '' && $_POST['donate_items'] != ''){
        $MANG = new Mangos;
        if($MANG->mail_item_donation($_POST['donate_items'], $character_item_id,false,true) == TRUE){
            echo "<p><h1>ITEMS SENT TO \"".$_POST['donate_username']."\"</h1></p>";
        }else{
            echo "<p>Error: Error in mail system! Contact administrator!</p>";
        }
        unset($MANG);
    }else{
        echo "<p><b>Character not found</b></p>";
    }
}elseif(isset($_POST['donation_edit'])){
    if ($_POST['edit_id']){
        if (check_item_id_donation($_POST['edit_items']) == FALSE){
           die('Error in item field! You must have items IDS separated with ","');
        }
        $DB->query("UPDATE `donations_template` SET itemset='".$_POST['edit_itemset']."',items='".$_POST['edit_items']."',description='".$_POST['edit_description']."',
        donation='".$_POST['edit_donation']."',currency='".$_POST['edit_currency']."',realm='".$_POST['rid']."' WHERE id='".$_POST['edit_id']."'");
        echo "Donation template with id ".$_POST['edit_id']." edited.";
    }else{
        $row = $DB->selectRow("SELECT * FROM `donations_template` WHERE id='".$_POST['donation_edit']."'");
        echo "<p>You are now editing donation template with id ".$row['id']."</p>";
        echo "<form action='index.php?n=admin&sub=donate' method='POST'>
              Item(s): <input type='text' name='edit_items' value='".$row['items']."'>(Id's separated with \",\")<br />
              Itemset(s): <input type='text' name='edit_itemset' value='".$row['itemset']."'>(Id's separated with \",\")<br />
              Description: <input type='text' name='edit_description' value='".$row['description']."'><br />
              Cost: <input type='text' name='edit_donation' value='".$row['donation']."'><br />
              Currency: <input type='text' name='edit_currency' value='".$row['currency']."'><br />
			  Realm: <select name='rid'><option value=\"0\">All Realms</option>". $realmzlist ."</select><br />
              <input type='hidden' name='edit_id' value='".$row['id']."'>
              <input type='hidden' name='donation_edit' value='".$row['id']."'>
              <input type='submit' value='Submit'>
              </form>";
    }
}elseif(isset($_POST['add_items']) || isset($_POST['add_itemset'])){
        if (check_item_id_donation($_POST['edit_items']) == FALSE){
           die('Error in item field! You must have items IDS separated with ","');
        }
    if ($_POST['add_description'] != '' && $_POST['add_donation'] != '' && $_POST['add_currency'] != ''){
        $DB->query("INSERT INTO `donations_template`
        (items,description,donation,currency,itemset,realm) VALUES
        (
        '".$_POST['add_items']."',
        '".$_POST['add_description']."',
        '".$_POST['add_donation']."',
        '".$_POST['add_currency']."',
        '".$_POST['add_itemset']."',
		'".$_POST['rid']."'
        )
        ");
        echo "New donation template added.";
    }
}elseif(isset($_POST['donation_delete'])){
    $DB->query("DELETE FROM `donations_template` WHERE id='".$_POST['donation_delete']."'");
    echo "Donation pack with ID: ".$_POST['donation_delete']." deleted.";
}elseif(isset($_POST['donation_send_payment_requested'])){
     $txnid = $_POST['donation_send_payment_requested'];
     if (empty($txnid))die("_POST is empty, some error happened.!");
     $p_info = $DB->selectRow("SELECT * FROM `paypal_payment_info` WHERE txnid='".$txnid."'");
     $MANG = new Mangos;
     if($MANG->mail_item_donation($p_info['itemnumber'], $p_info['itemname'],$p_info['txnid']) == TRUE){
         echo "<p><h1>ITEMPACK: \"".$p_info['itemnumber']."\" SENT TO \"".$p_info['firstname'].' '.$p_info['lastname']."\".</h1></p>";
     }else{
         echo "<p>Error: Error in mail system! Contact administrator!</p>";
     }
     unset($MANG);
}
?>
<br /><br />
<p><b>Send item(s) to players</b></p>
<form action="index.php?n=admin&sub=donate" method="POST">
<table>
    <tr>
        <td><b>Character name:</b></td>
        <td><input type="text" name="donate_username"></td>
    </tr>

    <tr>
        <td><b>Item Pack</b></td>
        <td>

        <?php
        $rows = $DB->select("SELECT * FROM `donations_template`");
        if (count($rows) > 0){
            echo "<select name='donate_items'>";
            foreach($rows as $row){
                echo "<option value='".$row['id']."'>".$row['id']." - ".$row['description']."</option>";
            }
            echo "</select>";
        }else{
            echo " NO DONATION TEMPLATES IN `donations_template` database.";
        }
        ?>

        </td>
    </tr>
    <tr>
        <td><b>Send items?</b></td>
        <td><input type="submit" value="SEND"></td>
    </tr>
</table>
</form>

<br /><br />
<p><b>Edit donation packs</b><br />
<form action="index.php?n=admin&sub=donate" method="POST">
        <?php
        $rows = $DB->select("SELECT * FROM `donations_template`");
        if (count($rows) > 0){
            echo "<select name='donation_edit'>";
            foreach($rows as $row){
                echo "<option value='".$row['id']."'>".$row['id']." - ".$row['description']."</option>";
            }
            echo "</select>";
        }else{
            echo "NO DONATION TEMPLATES FOUND";
        }
        ?>
        <input type="submit" value="EDIT">
</form>
</p>
<p><b>Add donation pack</b><br />
<form action='index.php?n=admin&sub=donate' method='POST'>
<b>Item(s):</b> <input type='text' name='add_items'> (Item id(s) separated with ",")<br />
<b>Itemset(s):</b> <input type='text' name='add_itemset'> (Itemset(s) id(s) separated with ",")<br />
<b>Description:</b> <input type='text' name='add_description'> (Little description or title)<br />
<b>Cost:</b> <input type='text' name='add_donation' value='0'> (How much they must pay ?)<br />
<b>Currency:</b> <input type='text' name='add_currency' value='USD'> (USD currency is default.)<br />
<b>Realm:</b> <select name="rid"><option value="0">All Realms</option><?php echo $realmzlist ?></select> (Which realm is this available for?)<br />
<input type='submit' value='Submit'>
</form>
</p>
<p><b>Delete donation packs</b><br />
<form action="index.php?n=admin&sub=donate" method="POST">
        <?php
        $rows = $DB->select("SELECT * FROM `donations_template`");
        if (count($rows) > 0){
            echo "<select name='donation_delete'>";
            foreach($rows as $row){
                echo "<option value='".$row['id']."'>".$row['id']." - ".$row['description']."</option>";
            }
            echo "</select>";
        }else{
            echo "NO DONATION TEMPLATES FOUND";
        }
        ?>
        <input type="submit" value="DELETE">
</form>
</p>
<p>
<b>Send "not sent" items ( From donates! ):</b><br />
<form action="index.php?n=admin&sub=donate" method="POST">

<?php
    $rows = $DB->select("SELECT * FROM `paypal_payment_info` WHERE item_given != '1'");
    if (count($rows) > 0){
        echo '<select name="donation_send_payment_requested">';
        foreach($rows as $row){
            echo "<option value='".$row['txnid']."'>".$row['firstname']." ".$row['lastname']." - (Item pack: ".$row['itemnumber'].")  ( Donated: ".$row['mc_gross']." )</option>";
        }
        echo '</select><input type="submit" value="SEND ITEM PACK!">';
    }
?>
</form>
</p>
<?php builddiv_end() ?>
