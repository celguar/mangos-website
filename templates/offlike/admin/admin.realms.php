<br>
<?php builddiv_start(1, "Realms") ?>
<table id="notification_body" class="forum_category" width="100%">
    <thead>
        <tr>
            <td width="12" align="center">#</td>
            <td>Name</td>
            <td width="80">Address</td>
            <td width="40" align="center">Port</td>
            <td align="center">Type</td>
            <td width="70">Timezone</td>
			<td align="center">RA address</td>
			<td align="center">RA Port</td>
			<td align="center">RA user</td>
			<td align="center">RA pass</td>
            <td width="70">DbInfo</td>
        </tr>
    </thead>
<?php if(empty($_GET['action'])){ ?>
    <tfoot>
    <form action="index.php?n=admin&sub=realms&action=create" method="post" onSubmit="return popup_ask('<?php echo $lang['sure_q'];?>');">
        <tr>
            <td colspan="11" style="background:#a7a7a7;height:8px;border:2px solid #000;"><img src="<?php echo $currtmp; ?>/images/pixel.gif"></td>
        </tr>
        <tr>
            <td  colspan="1">#</td>
            <td colspan="2">Name: <input type="text" name="name" style="width:100%;font-size:0.7em;"></td>
            <td colspan="2">Address: <input type="text" name="address" style="width:100%;font-size:0.7em;"></td>
            <td colspan="2" align="center">Port: <input type="text" name="port" style="width:100%;font-size:0.7em;"></td>
            <td align="center" colspan="2">Type: <select style="width:100%;font-size:0.7em;" name="icon"><?php foreach($realm_type_def as $tmp_id=>$tmp_name){ echo'<option value="'.$tmp_id.'">'.$tmp_name.'</option>'; } ?></select></td>
            <td colspan="3">Timezone: <select style="width:100%;font-size:0.7em;" name="timezone"><?php foreach($realm_timezone_def as $tmp_id=>$tmp_name){ echo'<option value="'.$tmp_id.'">'.$tmp_name.'</option>'; } ?></select></td>
		</tr>
		<tr>
			<td align="center" colspan="2">RA Address: <input type="text" name="ra_address" style="width:100%;font-size:0.7em;"></td>
			<td align="center" colspan="2">RA Port: <input type="text" name="ra_port" style="width:100%;font-size:0.7em;"></td>
			<td align="center" colspan="2">RA Username: <input type="text" name="ra_user" style="width:100%;font-size:0.7em;"></td>
			<td align="center" colspan="2">RA Pass: <input type="text" name="ra_pass" style="width:100%;font-size:0.7em;"></td>
            <td width="35" align="center" colspan="2">DB Info: <input type="text" name="dbinfo" value="<?php echo isset($item['dbinfo']) ? $item['dbinfo'] : ''; ?>" style="width:100%;font-size:0.7em;"></td>
        </tr>
        <tr>
            <td colspan="11" style="background:#a7a7a7;height:8px;border:2px solid #000;">
                <input type="submit" value="Create new realm">
            </td>
        </tr>
    </form>
    </tfoot>
    <tbody>
<?php foreach($items as $item){ ?>
        <tr class="normal">
            <td align="center"><b><?php echo $item['id']; ?></b></td>
            <td class="n_title"><a href="index.php?n=admin&sub=realms&action=edit&id=<?php echo $item['id']; ?>" title="EDIT"><?php echo $item['name']; ?></a></td>
            <td><?php echo $item['address']; ?></td>
            <td align="center"><?php echo $item['port']; ?></td>
            <td align="center"><?php echo $realm_type_def[$item['icon']]; ?></td>
            <td><?php echo $realm_timezone_def[$item['timezone']]; ?></td>
			<td align="center"><?php echo $item['ra_address']; ?></td>
			<td align="center"><?php echo $item['ra_port']; ?></td>
			<td align="center"><?php echo $item['ra_user']; ?></td>
			<td align="center">***</td>
            <td align="center">***</td>
        </tr>
<?php } ?>
    </tbody>
<?php }elseif($_GET['action']=='edit'){ ?>
<script language="javascript">
    function select_and_go(url){
        if(url != 0){
            conf = popup_ask('<?php echo $lang['sure_q'];?>');
            if(conf==true)window.location.href = url;
            else return false;
        }else{
            return false;
        }
    }
</script>
    <tbody>
    <form action="index.php?n=admin&sub=realms&action=update&id=<?php echo $item['id']; ?>" method="post" onSubmit="return confirm('<?php echo $lang['sure_q'];?>');">
        <tr>
            <td align="center" colspan="11"><br />Editing Realm ID: <b><?php echo $item['id']; ?></b></td>
		</tr>
		<tr>
            <td colspan="4" >Realm Name: <input type="text" name="name" value="<?php echo $item['name']; ?>" style="width:100%;"></td>
		</tr>
		<tr>
            <td colspan="4">Realm IP: <input type="text" name="address" value="<?php echo $item['address']; ?>" style="width:100%;"></td>
		</tr>
		<tr>
            <td colspan="2">Port: <input type="text" name="port" value="<?php echo $item['port']; ?>" style="width:100%;"></td>
		</tr>
		<tr>
            <td colspan="4">Realm Type: <select style="width:100%;" name="icon"><?php foreach($realm_type_def as $tmp_id=>$tmp_name){ echo'<option value="'.$tmp_id.'" '.($item['icon']==$tmp_id?'selected':'').'>'.$tmp_name.'</option>'; } ?></select></td>
		</tr>
		<tr>
            <td colspan="4">Realm Zone: <select style="width:100%;" name="timezone"><?php foreach($realm_timezone_def as $tmp_id=>$tmp_name){ echo'<option value="'.$tmp_id.'" '.($item['timezone']==$tmp_id?'selected':'').'>'.$tmp_name.'</option>'; } ?></select></td>
		</tr>
		<tr>
			<td colspan="4">Remote Access Address: <input type="text" name="ra_port" value="<?php echo $item['ra_address']; ?>" style="width:100%;"></td>
		</tr>
		<tr>
			<td colspan="4">Remote Access Port: <input type="text" name="ra_port" value="<?php echo $item['ra_port']; ?>" style="width:100%;"></td>
		</tr>
		<tr>
			<td colspan="4">Remote Access Account Username: <input type="text" name="ra_user" value="<?php echo $item['ra_user']; ?>" style="width:100%;"></td>
		</tr>
		<tr>
			<td colspan="4">Remote Access Account Password: <input type="password" name="ra_pass" value="<?php echo $item['ra_pass']; ?>" style="width:100%;"></td>
		</tr>
		<tr>
            <td colspan="4">Database Info: <input type="text" name="dbinfo" value="<?php echo $item['dbinfo']; ?>" style="width:100%;"></td>
        </tr>
		<tr><br /></tr>
        <tr>
            <td colspan="11" style="background:#a7a7a7;height:8px;border:2px solid #000;">
                <input type="submit" value="Update realm" style="float:left;">
                <input type="button" value="Delete realm" style="float:right;font-size:0.9em;" onclick="select_and_go('index.php?n=admin&sub=realms&action=delete&id=<?php echo $item['id']; ?>')">
            </td>
        </tr>
    </form>
    </tbody>
<?php } ?>
</table>
<?php builddiv_end() ?>