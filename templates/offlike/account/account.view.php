<br>
<?php builddiv_start(1, $lang['si_acc']) ?>
<?php if($user['id']>0 && $profile){ ?>
<table align="center" width="100%" style="font-size:0.8em;"><tr><td align="center">
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <b><?php echo $lang['username'];?></b> <input type="text" size="36" style="margin:1px;" value="<?php echo$profile['username'];?>" readonly> <br/>
    </div>
    <?php if($profile['hideemail']!=1){ ?>
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <b>Email</b> <input type="text" size="36" style="margin:1px;" value="<?php echo$profile['email'];?>" readonly> <br/>
    </div>
    <?php } ?>
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <b><?php echo $lang['gender'];?></b> <img src="<?php echo $templategenderimage[$profile['gender']];?>"> <br/>
        <b>WWW</b> <input type="text" size="36" style="margin:1px;" value="<?php echo$profile['homepage'];?>" readonly> <br/>
        <b>ICQ</b> <input type="text" size="36" style="margin:1px;" value="<?php echo$profile['icq'];?>" readonly> <br/>
        <b>MSN</b> <input type="text" size="36" style="margin:1px;" value="<?php echo$profile['msn'];?>" readonly> <br/>
        <b><?php echo $lang['wherefrom'];?></b> <input type="text" size="36" style="margin:1px;" value="<?php echo$profile['location'];?>" readonly> <br/>
    </div>
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <?php if($profile['avatar']) { ?>
        <b><?php echo $lang['avatar'];?></b> &nbsp;<br/> <img src="images/avatars/<?php echo$profile['avatar'];?>" style="margin:1px;">
        <?php } ?>
    </div>
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <b><?php echo $lang['signature'];?></b> <br/>
        <div style="width:70%; text-align: left;"><?php echo my_preview($profile['signature']);?></div>
    </div>
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <li><a href="index.php?n=account&sub=pms&action=add&to=<?php echo$profile['username'];?>"><?php echo $lang['personal_message'];?></a>
    </div>
</td></tr></table>
<?php } ?>
<?php builddiv_end() ?>