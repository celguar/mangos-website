<br>
<?php builddiv_start(1, $lang['chat']) ?>
<style>
div.errorMsg { width: 60%; height: 30px; line-height: 30px; font-size: 10pt; border: 2px solid #e03131; background: #ff9090;}
</style>
<?php
if ($showchat == true){
?>
<center>
  <iframe src="./components/chat/index.php"; height="500" width="620" frameborder="0" scrolling="no"> </iframe>
</center>
<?php
}else{
?>
<center>
<div class="errorMsg"><b><?php echo $lang['chat_disable'] ?></b></div>
</center>
<?php
}
?>
<?php builddiv_end ?>