<br>
<?php builddiv_start(1, $lang['talents']) ?>
<style media="screen" title="currentStyle" type="text/css">
    .classimages
    {
        text-align: center;
    }
    .classimages img {
        margin: 10px 20px;
    }
</style>
<div class="classimages">
<?php foreach($classes as $class): ?>
    <a href="<?php echo $classlinkpath.$class; ?>.php" onclick="window.open(this.href);return false;"><img src="<?php echo $classimagespath.$class; ?>.jpg" width="250" height="234" border="0" alt="<?php echo ucfirst($class); ?>"/></a>
<?php endforeach; ?>
</div>
<br/>
<?php builddiv_end() ?>