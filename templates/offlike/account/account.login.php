<br>
<?php builddiv_start(1, $lang['login']) ?>
<?php
if($user['id']<=0){
?>
        <table align="center" width="100%"><tr><td align="center" width="100%">
      <form method="post" action="index.php?n=account&sub=login">
            <input type="hidden" name="action" value="login">
        <div style="border:background:none;margin:1px;padding:6px 9px 6px 9px;text-align:center;width:70%;">
          <b><?php echo $lang['username'] ?></b> <input type="text" size="26" style="font-size:11px;" name="login">
        </div>
        <div style="border:background:none;margin:1px;padding:6px 9px 6px 9px;text-align:center;width:70%;">
          <b><?php echo $lang['pass'] ?></b> <input type="password" size="26" style="font-size:11px;" name="pass">
        </div>
        <div style="background:none;margin:1px;padding:6px 9px 0px 9px;text-align:center;width:70%;">
          <input type="submit" size="16" class="button" style="font-size:12px;" value="<?php echo $lang['login'] ?>">
        </div>
      </form>
        </td></tr></table>
<?php
}else{
    echo "<br /><br /><center><b>Welcome ".$user['username']."</b><br />".$lang['now_logged_in']."</center><br /><br />";
}
?>
<?php builddiv_end() ?>