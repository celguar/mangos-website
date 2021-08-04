<br/>
<?php builddiv_start(1, "Config") ?>
Below are the settings from the MangosWeb configuration file. If you want to change
these, you need to edit the <?php echo $configfilepath; ?> file manually.<br/>


<div style="border: 2px dotted #1E4378; margin: 8px 2px; padding:6px 9px;">
<table>
<?php foreach($config as $key=>$value): ?>
    <tr>
        <td style="font-size: 80%"><?php echo $key; ?> =</td>
        <td style="font-size: 80%"><?php echo $value; ?></td>
    </tr>
<?php endforeach; ?>
</table>
</div>
<?php builddiv_end() ?>
