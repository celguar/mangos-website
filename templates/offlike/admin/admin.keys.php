<br>
<?php builddiv_start(1, $lang['regkeys_manage']) ?>
<p>
<a href="index.php?n=admin&sub=keys&action=deleteall" onclick="return confirm('Are you sure?');"><b>[ <font color="red">Delete all keys</font> ]</b></a><br/>
<form method="post" action="index.php?n=admin&sub=keys&action=create">
    <?php echo $lang['l_newkeys'];?>:<input type="text" name="num" size="4"> 
    <input type="submit" value="<?php echo $lang['docreate'];?>"> 
</form>
<!--
<form method="post" action="index.php?n=admin&sub=keys&action=delete">
    <?php echo $lang['l_delkey'];?>: <?php echo $lang['l_delkey_id'];?>:<input type="text" name="keyid" size="4"> 
    <?php echo $lang['l_delkey_name'];?>:<input type="text" name="keyname" size="38"> 
    <input type="submit" value="<?php echo $lang['dodelete'];?>"> 
</form>
-->
</p>
<ul style="font-weight:bold;list-style:none;">
    <?php foreach($allkeys as $key){
        if($key['used']==0)echo'<li><a href="index.php?n=admin&sub=keys&action=delete&keyid='.$key['id'].'" title="Delete"><img src="'.$currtmp.'/images/icons2/delete.png" alt="[delete]" align="absmiddle"></a>&nbsp; <a href="index.php?n=admin&sub=keys&action=setused&keyid='.$key['id'].'" title="Mark as used">'.$key['id'].') '.$key['key'].'</a></li>'."\n";
        else echo'<li><a href="index.php?n=admin&sub=keys&action=delete&keyid='.$key['id'].'" title="Delete"><img src="'.$currtmp.'/images/icons2/delete.png" alt="[delete]" align="absmiddle"></a>&nbsp; <s>'.$key['id'].') '.$key['key'].'</s></li>'."\n";
    } ?>
</ul>
<?php builddiv_end() ?>