<br>
<?php builddiv_start(1, "Language admin") ?>
<?php if(empty($_GET['action'])){ ?>
<p>
 <u>Choose language to edit :</u>
  <ul>
    <?php foreach($languages as $lang_s=>$lang_name){ 
        echo "<li><a href=\"index.php?n=admin&sub=langs&action=edit&lang={$lang_s}\">{$lang_name}</a>";
        if($lang_s!=(string)$MW->getConfig->generic->default_lang) echo ' &nbsp;<a title="'.$lang['dodelete'].'" href="index.php?n=admin&sub=langs&action=delete&lang='.$lang_s.'" onclick="return confirm(\'Are you sure?\');"><img src="'.$currtmp.'/images/icons/bin_closed.gif" align="absmiddle"></a>';
        echo "</li>";
    } ?>
  </ul>
 <u>Install (add) new lang :</u> <br />
   > Uploaded file name must be: shortname.Fullname.lang, for example: fr.French.lang <br />
   <form action="index.php?n=admin&sub=langs&action=upload" method="post" enctype="multipart/form-data">
   <input type="file" name="upllang" />
   <input type="submit" value="Upload&Install" />
   </form>
</p>

<?php }elseif($_GET['action'] == 'edit' && isset($_GET['lang'])){ ?>
<p>
 <form action="index.php?n=admin&sub=langs&action=doedit&lang=<?php echo $_GET['lang'];?>" method="post">
 <table cellpadding="1" cellspacing="1" id="langtable">
 <thead>
 <td>Key</td>
 <td>Value</td>
 <td> </td>
 </thead>
 <?php foreach($elangArray as $lang_key=>$lang_value){ $vic++; ?>
 <tr id="langvar_<?php echo $vic;?>">
 <td valign="top"><input type="text" value="<?php echo $lang_key;?>" name="elang[<?php echo $vic;?>][key]" size="20" /></td>
 <td valign="top"><textarea cols="56" rows="1" name="elang[<?php echo $vic;?>][val]"><?php echo $lang_value;?></textarea>  <br /></td>
 <td><a href="#" onclick="removerow(<?php echo $vic;?>);return false;"><img src="<?php echo $currtmp; ?>/images/icons/bin_closed.gif" align="absmiddle"></a></td>
 </tr>
 <?php } ?>
 </table>
 <script type="text/javascript">
 var vic = <?php echo $vic;?>;
 function removerow(rid){
     $('langvar_'+rid).remove(0);
 }
 function add_pair(){
     vic++;
     text  = '<tr id="langvar_'+vic+'"><td valign="top"><input type="text" name="elang['+vic+'][key]" size="20" /></td>';
     text += '<td valign="top"><textarea cols="56" rows="1" name="elang['+vic+'][val]"></textarea>  <br /></td>';
     text += '<td><a href="#" onclick="removerow('+vic+');return false;"><img src="<?php echo $currtmp; ?>/images/icons/bin_closed.gif" align="absmiddle"></a></td></tr>';
     $('langtable').innerHTML += text;
 }
 </script>
 <br />
 <input type="button" value="Add lang variable" onclick="add_pair();" style="font-weight:bold;color:green;" />
 <br /> <br />
<input type="submit" value="Save changes" style="font-weight:bold;color:red;" />
 </form>
</p>
<?php } ?>
<?php builddiv_end() ?>