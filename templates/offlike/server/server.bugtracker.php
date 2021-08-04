<br>
<?php builddiv_start(1, $lang['bugs']) ?>
<style media="screen" title="currentStyle" type="text/css">
    .postContainerPlain {
        font-family:arial,palatino, georgia, verdana, arial, sans-serif;
        color:#000000;
        padding:5px;
        margin-bottom: 4px;
        font-size: x-small;
        font-weight: normal;
        background-color: #E7CFA3;
        background-image: url('<?php echo $currtmp; ?>/images/light.jpg');
        border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px;
        line-height:140%;
  }
    .postBody {
        padding:10px;
        line-height:140%;
        font-size: small;
  }
    .title {
        font-family: palatino, georgia, times new roman, serif;
        font-size: 14pt;
        color: #640909;
    }
</style>
<table align="center" width="100%"><tr><td align="center">
<h3><a href="index.php?n=forum&sub=viewforum&fid=<?php echo (int)$MW->getConfig->generic_values->forum->bugs_forum_id;?>"> --- Bugtracker forum --- </a></h3>
<?php foreach($alltopics as $topic){ ?>
<div style="margin-right: 0pt;" class="postContainerPlain" align="left">
    <h3 class="title"><?php echo $topic['topic_name'];?><br/><small style="color: #000;"><?php echo $topic['poster'];?>, <?php echo date('d/m/Y, H:i',$topic['topic_posted']);?></small></h3>
    <div class="postBody"><?php echo $topic['message'];?></div>
</div>
<?php } ?>
</td></tr></table>   
<?php builddiv_end() ?> 
