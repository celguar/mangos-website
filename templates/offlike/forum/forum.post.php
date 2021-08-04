<style media="screen" title="currentStyle" type="text/css">
    @import "<?php echo $currtmp; ?>/css/master.css";
    @import "<?php echo $currtmp; ?>/css/forums.css";
    body {
	color: #666666;
	font-weight: bold;
}
</style>
<div class="sections single_col">
  <div align="center">
    <?php if($user['id']>0 && ($_GET['action']=='newtopic' || $_GET['action']=='newpost' || $_GET['action']=='edittopic' || $_GET['action']=='editpost')){ ?>
    <script type="text/javascript" src="./js/compressed/behaviour.js"></script>
    <script type="text/javascript" src="./js/core.js"></script>
    <script type="text/javascript" src="<?php echo $currtmp; ?>/js/template_rules.js"></script>
    <script language='JavaScript' src='core/ajax_lib/Js.js'></script>
  </div>
  <script language='Javascript'><div align="center">
  <!--
  var toarea;
  function mypreview(el1, el2){
    var query = document.getElementById(el2).value;
    var req = new JsHttpRequest();
      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          document.getElementById(el1).innerHTML = req.responseText;
        }
      }
    req.caching = false;
    req.open('POST', '<?php echo $MW->getConfig->temp->site_href;?>index.php?n=ajax&sub=preview&nobody=1&ajaxon=1', true);
    req.send({ text: query });
  }
  // -->
  </div></script>
<hr class="hidden" /><br />
<div id="write_form" class="subsections">
<table cellspacing="0" cellpadding="1" border="0" width="100%" class="board-clear" >
<tr>
<td class="tableoutline">
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="tableoutline">
    <tr>
    <td>
	
	<table cellspacing="0" cellpadding="0" border="0" width="100%" height="22" style="background-image:url(<?php echo $currtmp; ?>/images/forumliner-bg2.gif)"><tr><td></td></tr></table>
<h2 style="font-size:17px" align="center"><?php echo current(end($pathway_info));?></h2>

<form class="clearfix" method="post" action="index.php?n=forum&sub=post&action=do<?php echo $_GET['action'];?>&f=<?php echo $_GETVARS['f'];?>&t=<?php echo $_GETVARS['t'];?>&post=<?php echo isset($_GETVARS['post']) ? $_GETVARS['post'] : '';?>"
enctype="multipart/form-data">
        
        <div align="center">
          <?php if($_GET['action']=='newtopic' || ($_GET['action']=='edittopic' && $user['g_forum_moderate']==1)){ ?>
            </div>
        <p>
        <label for="title"><b><?php echo $lang['l_subject'];?> (max 80):</b><br/></label>
        <input name="subject" type="text" id="title" size="35" maxlength="80" value="<?php if (isset($content['subject'])) echo $content['subject'];?>" />
      </p>
	  <br />
    <?php } ?>
    <?php write_form_tool(); ?><br />
      <div id="input_block">
            <label for="input_comment">
            <textarea id="input_comment" name="text"><?php if (isset($content['text'])) echo $content['text'];?></textarea>
            </label>
          <div align="center">
            <input name="submit" type="submit" value="<?php echo $lang['editor_send'];?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input value="<?php echo $lang['editor_preview'];?>" type="button" id="preview_do">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="reset" value="<?php echo $lang['editor_clear'];?>">
            </div>
        </div>
        <div id="preview_block" style="display: none;background:none;">
            <div class="editor" id="input_preview"></div>
            <input id="preview_back" value="<?php echo $lang['editor_backtoedit'];?>" type="button">
        </div>
      <div align="center"></div>
</form>
</div></div><table cellspacing="0" cellpadding="0" border="0" width="100%" height="22" style="background-image:url(<?php echo $currtmp; ?>/images/forumliner-bg2.gif)"><tr><td></td></tr></table>
</td></tr></table></td></tr></table>
<?php }elseif($_GET['action']=='movetopic' && $user['group']>=1){ ?>
  
<?php } ?>
</div>
