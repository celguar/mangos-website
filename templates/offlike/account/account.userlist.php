<br>
<?php builddiv_start(1, $lang['userlist']) ?>
<?php if($user['id']<=0){ ?>
<center><div style="background-color:#FF0033;border:groove 4px;margin:4px;padding:6px 9px 6px 9px;"><strong>
<?php
echo $lang['access_denied'];
}else{ ?>
<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%" class="bordercolor" style="font-size:0.8em;">
  <tbody>
    <tr>
      <td colspan="8" class="titlebg">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="bordercolor"style="font-size:1em;">
          <tbody><tr>
            <td><?php echo $lang['post_pages'];?>: <?php echo $pages_str; ?></td>
            <td align="right">
              <b>
              <a href="index.php?n=account&sub=userlist"><?php echo $lang['all'];?></a> |
              <a href="index.php?n=account&sub=userlist&char=1">#</a>
              <a href="index.php?n=account&sub=userlist&char=a">A</a>
              <a href="index.php?n=account&sub=userlist&char=b">B</a>
              <a href="index.php?n=account&sub=userlist&char=c">C</a>
              <a href="index.php?n=account&sub=userlist&char=d">D</a>
              <a href="index.php?n=account&sub=userlist&char=e">E</a>
              <a href="index.php?n=account&sub=userlist&char=f">F</a>
              <a href="index.php?n=account&sub=userlist&char=g">G</a>
              <a href="index.php?n=account&sub=userlist&char=h">H</a>
              <a href="index.php?n=account&sub=userlist&char=i">I</a>
              <a href="index.php?n=account&sub=userlist&char=j">J</a>
              <a href="index.php?n=account&sub=userlist&char=k">K</a>
              <a href="index.php?n=account&sub=userlist&char=l">L</a>
              <a href="index.php?n=account&sub=userlist&char=m">M</a>
              <a href="index.php?n=account&sub=userlist&char=n">N</a>
              <a href="index.php?n=account&sub=userlist&char=o">O</a>
              <a href="index.php?n=account&sub=userlist&char=p">P</a>
              <a href="index.php?n=account&sub=userlist&char=q">Q</a>
              <a href="index.php?n=account&sub=userlist&char=r">R</a>
              <a href="index.php?n=account&sub=userlist&char=s">S</a>
              <a href="index.php?n=account&sub=userlist&char=t">T</a>
              <a href="index.php?n=account&sub=userlist&char=u">U</a>
              <a href="index.php?n=account&sub=userlist&char=v">V</a>
              <a href="index.php?n=account&sub=userlist&char=w">W</a>
              <a href="index.php?n=account&sub=userlist&char=x">X</a>
              <a href="index.php?n=account&sub=userlist&char=y">Y</a>
              <a href="index.php?n=account&sub=userlist&char=z">Z</a>
              </b>
            </td>
          </tr>
        </tbody></table>
      </td>
    </tr>
    <tr class="catbg3">
      <td width="20"> </td>
      <td style="width: auto;" nowrap="nowrap"><?php echo $lang['user_name'];?></td>
      <td width="25" align="center">Email</td>
      <td width="25" align="center"><?php echo $lang['homepage'];?></td>
      <td width="25" align="center">ICQ</td>
      <td width="25" align="center">MSN</td>
    </tr>
    <?php ##foreach($items as $item){
        ##if(isset($items) && is_array($items))

    if (is_array($items))
    {
       foreach ($items as $item) {
            ?>
        
    <tr style="text-align: center;">
      <td class="windowbg2">
        <a href="index.php?n=account&sub=pms&action=add&to=<?php echo $item['username']; ?>" title="<?php echo $lang['personal_message'];?>"><img src="<?php echo $currtmp; ?>/images/icons/email.gif" alt="<?php echo $lang['pers_mess'];?>" align="middle"></a>
      </td>
      <td class="windowbg" align="left"><a href="index.php?n=account&sub=view&action=find&name=<?php echo $item['username']; ?>" title="<?php echo $lang['view_profile'];?> <?php echo $item['username']; ?>"><?php echo $item['username']; ?></a></td>
      <td class="windowbg2"><?php if($item['hideemail']!=1){ ?><a href="mailto:<?php echo $item['email']; ?>"><img src="./<?php echo $currtmp; ?>/images/icons/email_open.gif" alt="[Email]" title="Email" border="0" /></a><?php } ?></td>
      <td class="windowbg"><?php if($item['homepage'] && $item['homepage']!='http://'){ ?><a href="<?php echo $item['homepage']; ?>" target="_blank"><img src="<?php echo $currtmp; ?>/images/icons2/www.gif" alt="WWW" border="0" /></a><?php } ?></td>
      <td class="windowbg2"><?php echo isset($item['icq']) ? $item['icq'] : ''; ?></td>
      <td class="windowbg2"><?php echo isset($item['msn']) ? $item['msn'] : ''; ?></td>
      <td class="windowbg" align="left"><?php echo isset($item['registered']) ? $item['registered'] : ''; ?></td>
      <td class="windowbg2" width="35"><?php echo isset($item['forums_posts']) ? $item['forums_posts'] : ''; ?></td>
    </tr>
    <?php  }
    }
    else if ($items)
        {
            $item = $items;
            ?>

            <tr style="text-align: center;">
                <td class="windowbg2">
                    <a href="index.php?n=account&sub=pms&action=add&to=<?php echo $item['username']; ?>" title="<?php echo $lang['personal_message'];?>"><img src="<?php echo $currtmp; ?>/images/icons/email.gif" alt="<?php echo $lang['pers_mess'];?>" align="middle"></a>
                </td>
                <td class="windowbg" align="left"><a href="index.php?n=account&sub=view&action=find&name=<?php echo $item['username']; ?>" title="<?php echo $lang['view_profile'];?> <?php echo $item['username']; ?>"><?php echo $item['username']; ?></a></td>
                <td class="windowbg2"><?php if($item['hideemail']!=1){ ?><a href="mailto:<?php echo $item['email']; ?>"><img src="./<?php echo $currtmp; ?>/images/icons/email_open.gif" alt="[Email]" title="Email" border="0" /></a><?php } ?></td>
                <td class="windowbg"><?php if($item['homepage'] && $item['homepage']!='http://'){ ?><a href="<?php echo $item['homepage']; ?>" target="_blank"><img src="<?php echo $currtmp; ?>/images/icons2/www.gif" alt="WWW" border="0" /></a><?php } ?></td>
                <td class="windowbg2"><?php echo isset($item['icq']) ? $item['icq'] : ''; ?></td>
                <td class="windowbg2"><?php echo isset($item['msn']) ? $item['msn'] : ''; ?></td>
                <td class="windowbg" align="left"><?php echo isset($item['registered']) ? $item['registered'] : ''; ?></td>
                <td class="windowbg2" width="35"><?php echo isset($item['forums_posts']) ? $item['forums_posts'] : ''; ?></td>
            </tr>
            <?php
        }
    ?>
    <tr>
      <td class="titlebg" colspan="8"><?php echo $lang['post_pages'];?>: <?php echo $pages_str; ?> </td>
    </tr>
  </tbody>
</table>
<?php } ?>
<?php builddiv_end() ?>
