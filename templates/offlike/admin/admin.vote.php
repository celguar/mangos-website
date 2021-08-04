<br>
<?php builddiv_start(1, "Vote Site Admin") ?>
<?php
$realmz = $DB->select("SELECT id,name FROM realmlist ORDER BY name");
foreach($realmz as $aaa) {
$realmzlist .= "<option value='".$aaa['id']."'>".$aaa['name']."</option>";
}
if(isset($_POST['votesite_edit'])){
    if ($_POST['edit_id']){
        $DB->query("UPDATE `voting_sites` SET `hostname`='".$_POST['edit_hostname']."',`votelink`='".$_POST['edit_votelink']."',`image_url`='".$_POST['edit_image']."',
        `points`='".$_POST['edit_points']."' WHERE `id`='".$_POST['edit_id']."'");
        echo "Vote Site with id ".$_POST['edit_id']." edited.";
    }else{
        $row = $DB->selectRow("SELECT * FROM `voting_sites` WHERE `id`='".$_POST['votesite_edit']."'");
        echo "<p>You are now editing a Vote Site with id ".$row['id']."</p>";
        echo "<form action='index.php?n=admin&sub=vote' method='POST'>
              Hostname: <input type='text' name='edit_hostname' value='".$row['hostname']."'> (Name Of the Website)<br />
              votelink: <input type='text' name='edit_votelink' value='".$row['votelink']."'> (What is the Votelink, So users are voting for you)<br />
              Image URL: <input type='text' name='edit_image' value='".$row['image_url']."'> (What is the votesites Image Url? If you dont know, Leave empty)<br />
              Points: <input type='text' name='edit_points' value='".$row['points']."'> (How many points is this site worth?)<br />
              <input type='hidden' name='edit_id' value='".$row['id']."'>
              <input type='hidden' name='votesite_edit' value='".$row['id']."'>
              <input type='submit' value='Submit'>
              </form>";
    }
}elseif(isset($_POST['add_votelink']) || isset($_POST['add_hostname'])){
    if ($_POST['add_hostname'] != '' && $_POST['add_votelink'] != '' && $_POST['add_points'] != ''){
		$host = $_POST['add_hostname'];
		$vote = $_POST['add_votelink'];
		$image = $_POST['add_image'];
		$points = $_POST['add_points'];
		$select = $DB->select("SELECT * FROM voting_sites WHERE id > 0");
		if(count($select) == 0){
			$newid = 1;
		}else{
			$new = $DB->selectCell("SELECT MAX(id) FROM `voting_sites`");
			$newid = $new * 2;
		}
        $DB->query("INSERT INTO voting_sites VALUES ('$newid','$host','$vote','$image','$points')");
        echo "New Vote Site Added.";
    }
}elseif(isset($_POST['site_delete'])){
    $DB->query("DELETE FROM `voting_sites` WHERE id='".$_POST['site_delete']."'");
    echo "Vote Site with ID: ".$_POST['site_delete']." deleted.";
}
$gethackers = $DB->query("SELECT * FROM voting_points WHERE `points_spent` > `points_earned`");
?>
<br /><br />
<p><b>Edit Voting Sites</b><br />
<form action="index.php?n=admin&sub=vote" method="POST">
        <?php
        $rows = $DB->select("SELECT `id`,`hostname` FROM `voting_sites`");
        if (count($rows) > 0){
            echo "<select name='votesite_edit'>";
            foreach($rows as $row){
                echo "<option value='".$row['id']."'>".$row['hostname']."</option>";
            }
            echo "</select>";
        }else{
            echo "NO VOTING SITES FOUND";
        }
        ?>
        <input type="submit" value="EDIT">
</form>
</p>
<p><b>Add Voting Site</b><br />
<form action='index.php?n=admin&sub=vote' method='POST'>
<b>Hostname:</b> <input type='text' name='add_hostname'> (Name Of the Website)<br />
<b>Vote Link:</b> <input type='text' name='add_votelink'> (What is the Votelink, So users are voting for you)<br />
<b>Image URL:</b> <input type='text' name='add_image'> (What is the votesites Image Url? If you dont know, Leave empty)<br />
<b>Points:</b> <input type='text' name='add_points' value='1'> (How many points is this site worth?)<br />
<input type='submit' value='Submit'>
</form>
</p>
<p><b>Delete Voting Site</b><br />
<form action="index.php?n=admin&sub=vote" method="POST">
        <?php
        $rows = $DB->select("SELECT * FROM `voting_sites`");
        if (count($rows) > 0){
            echo "<select name='site_delete'>";
            foreach($rows as $row){
                echo "<option value='".$row['id']."'>".$row['hostname']."</option>";
            }
            echo "</select>";
        }else{
            echo "NO VOTING SITES FOUND";
        }
        ?>
        <input type="submit" value="DELETE">
</form>
</p>
</form>
<?php builddiv_end() ?>
<?php builddiv_start(0, "Vote Reward Admin") ?>
<?php
if(isset($_POST['votereward_edit'])){
    if ($_POST['edit_rewardid']){
        $DB->query("UPDATE `voting_rewards` SET `item_id`='".$_POST['edit_itemid']."',`quanity`='".$_POST['edit_qty']."',`cost`='".$_POST['edit_cost']."',
        `quality`='".$_POST['edit_quality']."',`reward_text`='".$_POST['edit_text']."',`realmid`='".$_POST['edit_rid']."' WHERE `id`='".$_POST['edit_rewardid']."'");
        echo "Reward template with id ".$_POST['edit_rewardid']." edited.";
    }else{
        $row = $DB->selectRow("SELECT * FROM `voting_rewards` WHERE `id`='".$_POST['votereward_edit']."'");
        echo "<p>You are now editing a Vote Site with id ".$row['id']."</p>";
        echo "<form action='index.php?n=admin&sub=vote' method='POST'>
              Item ID: <input type='text' name='edit_itemid' value='".$row['item_id']."'> (Item ID. Put \"0\" for Gold)<br />
              Quanity: <input type='text' name='edit_qty' value='".$row['quanity']."'> (How Many? If using Gold, put in Copper. 10000 = 1G)<br />
              Cost: <input type='text' name='edit_cost' value='".$row['cost']."'> (How Many Vote Points Does This Cost)<br />
              Quality: <input type='text' name='edit_quality' value='".$row['quality']."'> (-1 To Disable, What Is the quality? ex: 3 = Rare(blue), 4 = Epic(Purple))<br /><br />
			  Reward Text: <input type='text' name='edit_text' value='".$row['reward_text']."'> (A brief description)<br />
			  Realm: <select name='edit_rid'><option value=\"0\">All Realms</option>". $realmzlist ."</select> (Which realm is this available for?)<br />
              <input type='hidden' name='edit_rewardid' value='".$row['id']."'>
              <input type='hidden' name='votereward_edit' value='".$row['id']."'>
              <input type='submit' value='Submit'>
              </form>";
    }
}elseif(isset($_POST['add_itemid']) || isset($_POST['add_cost'])){
    if ($_POST['add_itemid'] != '' && $_POST['add_qty'] != '' && $_POST['add_cost'] != ''){
		$item = $_POST['add_itemid'];
		$qty = $_POST['add_qty'];
		$cost = $_POST['add_cost'];
		$qual = $_POST['add_quality'];
		$rt = $_POST['add_text'];
		$r = $_POST['add_rid'];
		$new = $DB->selectCell("SELECT MAX(id) FROM `voting_rewards`");
		$newid = $new+1;
        $DB->query("INSERT INTO voting_rewards VALUES ('$newid','$item','$qty','$cost','$qual','$rt','$r')");
        echo "New Vote Reward Added.";
    }
}elseif(isset($_POST['reward_delete'])){
    $DB->query("DELETE FROM `voting_reward` WHERE id='".$_POST['reward_delete']."'");
    echo "Vote Reward with ID: ".$_POST['reward_delete']." deleted.";
}
?>
<br />
<p><b>Edit Vote Rewads</b><br />
<form action="index.php?n=admin&sub=vote" method="POST">
        <?php
        $rows = $DB->select("SELECT `id`,`reward_text` FROM `voting_rewards`");
        if (count($rows) > 0){
            echo "<select name='votereward_edit'>";
            foreach($rows as $row){
                echo "<option value='".$row['id']."'>".$row['id']." - ".$row['reward_text']."</option>";
            }
            echo "</select>";
        }else{
            echo "NO VOTING REWARDS FOUND";
        }
        ?>
        <input type="submit" value="EDIT">
</form>
</p>
<p><b>Add A Voting Reward</b><br />
<form action='index.php?n=admin&sub=vote' method='POST'>
<b>Item ID:</b> <input type='text' name='add_itemid'> (Item ID. Put "0" for Gold)<br />
<b>Quanity:</b> <input type='text' name='add_qty'> (How Many? If using Gold, put in Copper. 10000 = 1G)<br />
<b>Cost:</b> <input type='text' name='add_cost'> (How Many Vote Points Does This Cost)<br />
<b>Quality:</b> <input type='text' name='add_quality' value='1'> (-1 To Disable, What Is the quality? ex: 3 = Rare(blue), 4 = Epic(Purple))<br /><br />
<b>Reward Text:</b> <input type='text' name='add_text'> (A brief description)<br />
<b>Realm:</b> <select name="add_rid"><option value="0">All Realms</option><?php echo $realmzlist ?></select> (Which realm is this available for?)<br />
<input type='submit' value='Submit'>
</form>
</p>
<p><b>Delete Voting Reward</b><br />
<form action="index.php?n=admin&sub=vote" method="POST">
        <?php
        $rows = $DB->select("SELECT * FROM `voting_rewards`");
        if (count($rows) > 0){
            echo "<select name='reward_delete'>";
            foreach($rows as $row){
                echo "<option value='".$row['id']."'>".$row['id']." - ".$row['reward_text']."</option>";
            }
            echo "</select>";
        }else{
            echo "NO VOTING REWARDS FOUND";
        }
        ?>
        <input type="submit" value="DELETE">
</form>
</p>
</form>
<?php builddiv_end() ?>
<?php builddiv_start(1, "Vote System Issues") ?>
Here is a list of members who have more vote points spent then earned. This can be due to system errors, or Members trying to hack the vote system.
Click a username to go to there profile for ban / messaging options.
<br /><br />
<center>
<table id="notification_body" class="forum_category" width="85%">
    <thead>
        <tr>
            <td align="center" width="20">Account ID</td>
            <td align="center">Account Name</td>
			<td align="center">Times Voted</td>
			<td align="center">Current Points</td>
			<td align="center">Points Earned</td>
			<td align="center">Points Spent</td>
        </tr>
    </thead>
	<tbody>
	<?php foreach($gethackers as $item){ 
	$accountname = $DB->selectCell("SELECT username FROM account WHERE `id`=?d",$item['id']);
	?>
      <tr class="normal">
		<td align="center" width="20"><b><?php echo $item['id']; ?></b></td>
		<td align="center"><b><a href="index.php?n=admin&sub=members&id=<?php echo $item['id']; ?>"><?php echo $accountname; ?></a></b></td>
		<td align="center"><b><?php echo $item['times_voted']; ?></b></td>
		<td align="center"><b><?php echo $item['points']; ?></b></td>
		<td align="center"><b><?php echo $item['points_earned']; ?></b></td>
		<td align="center"><b><?php echo $item['points_spent']; ?></b></td>
	<?php } ?>
	</tbody>
</table>
<?php if (count($gethackers) == 0)
			echo "<br /><font color=\"blue\">Vote system reports no errors!</font>";
	?>
</center>
<?php builddiv_end() ?>