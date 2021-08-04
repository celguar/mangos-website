<br>
<?php builddiv_start(1, $lang['account_activate']) ?>
<table align="center" width="100%" style="font-size:0.8em;"><tr><td align="center">
<?php
if(empty($_REQUEST['key'])){
?>
    <form action="index.php?n=account&sub=activate" method="post">
        <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
            <b>Key:</b> <input type="text" size="45" maxlength='50' class="addbutton2" style="font-size:11px;" name="key"> 
        </div>
        <div style="background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
            <input type="submit" size="16" class="button" style="font-size:12px;" value="<?php echo $lang['account_activate'] ?>">
        </div>
    </form>
<?php
} 
?>                          
</td></tr></table>
<?php builddiv_end() ?>