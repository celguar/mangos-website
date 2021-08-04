<br>
<?php builddiv_start(1, $lang['whoisonline']) ?>
<table border="0" width="100%">
<tr>
    <td width="20%" style="border-bottom:1px solid #cccccc;"><?php echo $lang['who'];?></td>
    <td style="border-bottom:1px solid #cccccc;"><?php echo $lang['where'];?></td>
    <td style="border-bottom:1px solid #cccccc;"><?php echo $lang['when'];?></td>
    <?php if($user['g_is_admin']==1 || $user['g_is_supadmin']==1){ ?><td style="border-bottom:1px solid #cccccc;">Ip</td><?php } ?>
</tr>
<?php foreach($items as $item){ ?>
<tr>
    <td><?php echo $item['user_name']; ?></td>
    <td><a href="<?php echo $item['currenturl']; ?>"><?php echo $item['currenturl_name']; ?></a></td>
    <td><?php echo date('d F Y, H:i',$item['logged']);?></td>
    <?php if($user['g_is_admin']==1 || $user['g_is_supadmin']==1){ ?><td><?php echo $item['user_ip']; ?></td><?php } ?>
</tr>
<?php } ?>
</table>
<?php builddiv_end() ?>