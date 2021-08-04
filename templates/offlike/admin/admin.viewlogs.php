<br>
<?php builddiv_start(0, "GM Logs") ?>

<div>
    In this section you can check a gms or a earlyer gms logs of what that GM does.
</div>
<div>
    Search for username:
    <form action="index.php" method="GET">
        <input type="hidden" name="n" value="admin">
        <input type="hidden" name="sub" value="viewlogs">
        <input type="text" name="accountid"><input type="submit" value="Search">
    </form>
</div>
<?php
if ($showform == true){
?>
<div>
<h2>Logged GM events:</h2><br />
<?php echo $mangos_core_logs->parse_gmlog(); ?>
</div>

<?php
}else{
?>
Please enter a username to view the GM log for the specific account.
<?php
}
?>
<?php builddiv_end() ?>
