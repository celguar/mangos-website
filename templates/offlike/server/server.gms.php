<img src="<?php echo $currtmp; ?>/images/gms.jpg" border="0" width="659" />
<br>
<?php foreach($gm_groups as $gm_group_id=>$gm_group){ ?>
<br>
<?php builddiv_start(1, $gmlevel_w[$gm_group_id]) ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="postContainerPlain"	>
  <tr>
    <td width="20%"><div align="center"><img src="<?php echo $currtmp; ?>/images/GM-gnome.gif" width="86" height="133" /></div></td>
    <td width="80%"><div style="margin-right: 0pt;"  align="left">
      <div class="postBody" style="list-style:square;">
        <?php foreach($gm_group as $gm_name){ ?>
        <li>Account ID: <?php echo $gm_name;?></li>
        <?php } ?>
      </div>
    </div></td>
  </tr>
</table>
<?php builddiv_end() ?>
<?php } ?>
