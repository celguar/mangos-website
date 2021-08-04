<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo(string)$MW->getConfig->generic->site_title;?><?php echo $title_str;?></title>
<base href="<?php echo$MW->getConfig->temp->base_href;?>" /> 
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo(string)$MW->getConfig->generic->site_encoding;?>" />
<style media="screen" title="currentStyle" type="text/css">
@import "<?php echo $currtmp; ?>/css/main.css";
@import "<?php echo $currtmp; ?>/css/adding.css";
</style>
<script type="text/javascript">
var SITE_HREF = '<?php echo $MW->getConfig->temp->site_href;?>';
var DOMAIN_PATH = '<?php echo $MW->getConfig->temp->site_domain;?>';
var SITE_PATH = '<?php echo $MW->getConfig->temp->site_href;?>';
function selectattach(id){
    opener.document.getElementById('input_comment').value += '[attach='+id+']';
    window.close();
}
</script>
<script type="text/javascript" src="js/core.js"></script>
<body id="docbody" class="regular">

<?php if($user['g_use_attach']==1){ ?>
<style media="screen" title="currentStyle" type="text/css">
    img {
        border: none;
    }
    .windowbg{
        background: #fff; padding: 1px;
    }
    .windowbg2{
        background: #ecc; padding: 1px;
    }
    .windowbg2 a{
        display: block;
    }
    tr.tabletop td{
        border-bottom: 1px solid #aaa;
    }
    tr.tablebottom td{
        border-top: 1px solid #aaa;
    }
</style>
<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%" class="bordercolor">
	<tbody>
        <tr>
			<td colspan="8" class="titlebg">
            <?php if($this['allowupload']===true){ ?>
            <form method="post" action="index.php?n=forum&sub=attach&action=upload&tid=<?php echo$_GET['tid'];?>" enctype="multipart/form-data">
            <div style="border: 2px dotted #cdcdcd;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:93%;">
                <img onclick="window.close();" src="<?php echo $currtmp; ?>/images/cancel_f2.png" style="float:left;cursor:pointer;" alt="<?php lang('close');?>" title="<?php lang('close');?>" align="absmiddle">
                <?php Lang('max_file_size');?>: <?php echo $this['maxfilesize'];?> <br />
                <?php Lang('allowed_ext');?>: <?php echo (string)$MW->getConfig->generic->allowed_attachs;?> <br />
                <b><?php Lang('file');?></b> <input type="file" size="36" name="attach" style="margin:1px;"> 
                <input type="submit" class="button" style="font-weight:bold;margin:1px;" value="<?php Lang('upload');?>">
            </div>
            </form>
            <?php } ?>
            </td>
        </tr>
		<tr class="tabletop">
			<td width="20">&nbsp;</td>
			<td style="width: auto;" nowrap="nowrap"><?php Lang('file');?></td>
			<td width="85" align="center"><?php Lang('size');?></td>
			<td width="35" align="center"><?php Lang('download_times');?></td>
			<td width="95" align="center"><?php Lang('time');?></td>
			<td width="25" align="center">*</td>
		</tr>
		<?php foreach($attachs as $attach){ ?>
		<tr style="text-align: center;">
			<td class="windowbg"><img src="images/mime/<?php echo $attach['ext']; ?>.png" alt="" align="absmiddle"></td>
			<td class="windowbg2" align="left"><a href="javascript:selectattach('<?php echo $attach['attach_id']; ?>');"><?php echo $attach['attach_file']; ?></a></td>
			<td class="windowbg"><?php echo $attach['goodsize']; ?></td>
			<td class="windowbg2"><?php echo $attach['attach_hits']; ?></td>
			<td class="windowbg"><?php echo date('d-m-Y, H:i',$attach['attach_date']); ?></td>
			<td class="windowbg" align="center"><a href="index.php?n=forum&sub=attach&action=delete&attid=<?php echo $attach['attach_id']; ?>&tid=<?php echo$_GET['tid'];?>" title="<?php echo $lang['delete'];?>">
      <img src="<?php echo $currtmp; ?>/images/trash.png" alt="[del]" align="absmiddle"></a></td>
		</tr>
		<?php } ?>
        <tr class="tablebottom">
			<td colspan="8"><?php echo $lang['files_summary'];?>: <?php echo $all_attachs_count; ?> | <?php echo $lang['size_summary'];?>: <?php echo $this['goodsize']; ?> </td>
		</tr>
	</tbody>
</table>
<?php } ?>

</body>
</html>
