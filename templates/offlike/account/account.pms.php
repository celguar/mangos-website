<br>
<?php builddiv_start(0, $lang['personal_messages']) ?>
<?php if($user['id']>0){ ?>
<div>
    <ul class="mybulleted_list">
        <li <?php if($_GET['action']=='add')echo'class="selected"';?>><a href="index.php?n=account&sub=pms&action=add"><?php echo $lang['write'];?></a></li>
        <li <?php if($_GET['action']=='view' && $_GET['dir']=='in')echo'class="selected"';?>><a href="index.php?n=account&sub=pms&action=view&dir=in"><?php echo $lang['inbox'] ?></a></li>
        <li <?php if($_GET['action']=='view' && $_GET['dir']=='out')echo'class="selected"';?>><a href="index.php?n=account&sub=pms&action=view&dir=out"><?php echo $lang['outbox']?></a></li>
    </ul>
<?php if($_GET['action']=='view'){ ?>
    <script type="text/javascript">
    function Check(type)
    {
        var fmobj = document.mutliact;
        for (var i=0;i<fmobj.elements.length;i++)
        {
            var e = fmobj.elements[i];
            if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled))
            {
                if(type=='all')e.checked = 'checked';
                if(type=='none')e.checked = '';
                if(type=='read')if(e.className=='read')e.checked = 'checked';
                if(type=='unread')if(e.className=='unread')e.checked = 'checked';
            }
        }
        return false;
    }
    </script>
    <form method="post" action="index.php?n=account&sub=pms&action=delete&dir=<?php echo $_GET['dir']; ?>" name="mutliact">
    <input type="hidden" name="deletem" value="deletem">
        <table id="notification_body" class="forum_category" width="100%">
            <thead>
                <tr>
                    <td colspan="5">
                        <div class="header_info">
                            <p id="notification_select" class="light">
                                <?php echo $lang['mark']; ?>
                                <a href="#" onclick="return Check('all');"><?php echo $lang['post_all'];?>(<?php echo count($items); ?>)</a>,
                                <a href="#" onclick="return Check('none');"><?php echo $lang['post_none'];?></a>,
                                <a href="#" onclick="return Check('read');"><?php echo $lang['post_read'];?></a>
                                &nbsp;
                                | &nbsp; <a href="#" onclick="document.forms.mutliact.submit();return false;">[<?php echo $lang['delete_marked'];?>]</a>
                            </p>
                        </div>
                        <b><?php echo $lang['post_pages'];?>:</b> <?php echo $pages_str = paginate($pnum, $p, 'index.php?n=account&sub=pms'); ?>
                    </td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <b><?php echo $lang['post_pages'];?>:</b> <?php echo $pages_str; ?>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr class="normal">
                    <td class="n_checkbox" width="22">&nbsp;</td>
<?php if ($_GET['dir'] == 'in'){ ?>
                    <td class="n_sender" width="130"><?php Lang('post_from');?></td>
<?php }elseif ($_GET['dir'] == 'out'){ ?>
                    <td class="n_for" width="130"><?php Lang('post_for');?></td>
<?php } ?>
                    <td class="n_title"><?php Lang('post_subj');?></td>
                    <td class="n_time" width="140"><?php Lang('time');?></td>
                </tr>
<?php foreach($items as $item){ ?>
                <tr class="normal <?php echo ($item['showed']=='1'?'read':'unread')?>">
                    <td class="n_checkbox" width="22"><input name="checkpm[]" type="checkbox" value="<?php echo $item['id']; ?>" class="<?php echo ($item['showed']=='1'?'read':'unread')?>" /></td>
<?php if ($_GET['dir'] == 'in'){ ?>
                    <td class="n_sender" width="130"><a href="index.php?n=account&sub=view&action=find&name=<?php echo $item['sender'];?>"><?php echo $item['sender']; ?></a></td>
<?php }elseif ($_GET['dir'] == 'out'){ ?>
                    <td class="n_for" width="130"><a href="index.php?n=account&sub=view&action=find&name=<?php echo $item['for'];?>"><?php echo $item['for']; ?></a></td>
<?php } ?>
                    <td class="n_title"><a href="index.php?n=account&sub=pms&action=viewpm&dir=<?php echo $_GET['dir']; ?>&iid=<?php echo $item['id']; ?>"><?php echo $item['subject']; ?></a></td>
                    <td class="n_time" width="140"><a href="index.php?n=account&sub=pms&action=viewpm&dir=<?php echo $_GET['dir']; ?>&iid=<?php echo $item['id']; ?>"><?php echo date('d-m-Y, H:i',$item['posted']);?></a></td>
                </tr>
<?php } ?>
            </tbody>
        </table>
    </form>

<?php }elseif($_GET['action']=='viewpm' && $_GET['iid']){ ?>
    <table id="notification_body" class="forum_category" width="100%">
        <thead>
            <tr>
                <td colspan="2">
                    <?php echo $lang['post_from'];?>: <a href="index.php?n=account&sub=view&action=find&name=<?php echo $senderinfo['username'];?>"><?php echo $senderinfo['username'];?></a>,
                    <?php echo $lang['post_for'];?>: <?php echo $user['username']; ?></font>
                </td>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td align="center" valign="center" class="n_sender">
                    <a href="index.php?n=account&sub=pms&action=add&reply=<?php echo $item['id']; ?>"><b><?php echo $lang['post_reply'];?></b></a>
                </td>
                <td>
                    <?php echo $senderinfo['signature'];?>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td width="120" rowspan="2" valign="top" align="center">
                    <img src="<?php echo (string)$MW->getConfig->generic->avatar_path;?><?php echo $senderinfo['avatar'];?>" border="0"/><br/>
                    <b><?php echo $senderinfo['g_title'];?></b><br/>
                    <u><?php echo date('d F Y, H:i',$item['posted']);?></u><br/>
                </td>
                <td class="message-format" valign="top">
                    <?php echo $item['message']; ?>
                </td>
            </tr>
        </tbody>
    </table>
<?php }elseif($_GET['action']=='add'){ ?>
      <script language="Javascript">
      function loaduserlist(){
            var request = new Ajax.Request(
                SITE_HREF+'index.php?n=ajax&sub=userlist&nobody=1&ajaxon=1',
                {
                    method: 'get',
                    onSuccess: function(reply){
                        $('ulist_cont').innerHTML = reply.responseText;
                    }
                }
            );
      }
      function selectClick(uname){
        document.getElementById('owner').value = uname;
      }
      // -->
      </script>
<hr class="hidden" />
<div id="write_form" class="subsections">
<form method="post" action="index.php?n=account&sub=pms&action=add" name="mutliact" class="clearfix" OnSubmit="if(!this.owner.value || !this.title.value)return false;">
    <a name="ulist" href="#ulist" onclick="loaduserlist();return false;" class="mediumsize"><b><?php echo $lang['list_users']?></b></a>
        <div id="ulist_cont"></div>
    <p>
        <label for="owner"><?php echo $lang['post_for'];?> (max 20):</label><br/>
        <input type="text" name="owner" id="owner" value="<?php echo$content['sender'];?>" size="50" maxlength="80" class="input_text input_large" />
        </p>
    <p>
        <label for="title"><?php echo $lang['post_subj'];?> (max 80):</label><br/>
        <input type="text" name="title" id="title" value="<?php echo $content['subject'];?>" size="50" maxlength="80" class="input_text input_large" />
        </p>
    <?php write_form_tool(); ?>
        <div id="input_block">
            <textarea id="input_comment" name="message"><?php echo $content['message'];?></textarea><br/>
            <input value="<?php echo $lang['editor_preview'];?>" type="button" id="preview_do">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="reset" value="<?php echo $lang['editor_clear'];?>">
        </div>
        <div id="preview_block" style="display: none;background:none;">
            <div class="editor" id="input_preview"></div>
            <input class="button" id="preview_back" value="<?php echo $lang['editor_backtoedit']?>" type="button">
        </div>
        <input type="submit" value="<?php echo $lang['editor_send'];?>" class="input_btn_big" />
</form>
</div>
<?php } ?>

</div>
<?php } ?>
<?php builddiv_end() ?>