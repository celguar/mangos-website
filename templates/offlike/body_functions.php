<?php
$templategenderimage = array(
    0 => $currtmp.'/images/pixel.gif',
    1 => $currtmp.'/images/icons/male.gif',
    2 => $currtmp.'/images/icons/female.gif'
);
/**
There are 8 menu blocks:
    1-menuNews
    2-menuAccount
    3-menuGameGuide
    4-menuInteractive
    5-menuMedia
    6-menuForums
    7-menuCommunity
    8-menuSupport

    adding custom link, for example:
    $mainnav_links['1-menuNews'][] = array(
        'lang_variable',
        'link',
        ''
    );
*/

function population_view($n) {
    global $lang;
    $maxlow = 200;
    $maxmedium = 700;
    $maxhigh = 1000;
    if($n <= $maxlow){
        return '<font color="green">' . $lang['low'] . '</font>';
    }elseif($n > $maxlow && $n <= $maxmedium){
        return '<font color="orange">' . $lang['medium'] . '</font>';
    }elseif($n > $maxmedium && $n <= $maxhigh){
        return '<font color="red">' . $lang['high'] . '</font>';
    }
    else
        return '<font color="red">' . $lang['full'] . '</font>';
}

function build_menu_items($links_arr){
    global $user;
    global $lang;
    $r = "\n";
    foreach($links_arr as $menu_item){
        $ignore_item = 0;
        if($menu_item[2]) {


            $do_menu_excl = explode('!',$menu_item[2]);
            if(count($do_menu_excl) == 2) {
                if($user[$do_menu_excl[1]]) {
                    $ignore_item = 1;
                }
            }
            else {
                if(!$user[$do_menu_excl[0]]) {
                    $ignore_item = 1;
                }
            }
        }
        if(!$ignore_item && isset($menu_item[0]) && isset($lang[$menu_item[0]]))
            $r .='                                                <div><a class="menufiller" href="'.$menu_item[1].'">'.$lang[$menu_item[0]].'</a></div>'."\n";
    }
    return $r;
}

function build_main_menu(){

    global $mainnav_links;
    foreach($mainnav_links as $menuname=>$menuitems){
        $menunamev = explode('-',strtolower($menuname));
        if(count($menuitems)>0)// && $menuitems[0][0])
        {
            static $index = 0;
            $index++;
            echo '
                                    <div id="'.$menunamev[1].'">
                                      <div onclick="javascript:toggleNewMenu('.$menunamev[0].'-1);" class="menu-button-off" id="'.$menunamev[1].'-button">
                                        <span class="'.$menunamev[1].'-icon-off" id="'.$menunamev[1].'-icon">&nbsp;</span><a class="'.$menunamev[1].'-header-off" id="'.$menunamev[1].'-header"><em>Menu item</em></a><a id="'.$menunamev[1].'-collapse"></a><span class="menuentry-rightborder"></span>
                                      </div>
                                      <div id="'.$menunamev[1].'-inner">
                                        <script type="text/javascript">
                                            if (menuCookie['.$menunamev[0].'-1] == 0) {
                                                document.getElementById("'.$menunamev[1].'-inner").style.display = "none";
                                                document.getElementById("'.$menunamev[1].'-button").className = "menu-button-off";
                                                document.getElementById("'.$menunamev[1].'-collapse").className = "leftmenu-pluslink";
                                                document.getElementById("'.$menunamev[1].'-icon").className = "'.$menunamev[1].'-icon-off";
                                                document.getElementById("'.$menunamev[1].'-header").className = "'.$menunamev[1].'-header-off";
                                            } else {
                                                document.getElementById("'.$menunamev[1].'-inner").style.display = "block";
                                                document.getElementById("'.$menunamev[1].'-button").className = "menu-button-on";
                                                document.getElementById("'.$menunamev[1].'-collapse").className = "leftmenu-minuslink";
                                                document.getElementById("'.$menunamev[1].'-icon").className = "'.$menunamev[1].'-icon-on";
                                                document.getElementById("'.$menunamev[1].'-header").className = "'.$menunamev[1].'-header-on";
                                            }
                                        </script>
                                        <div class="leftmenu-cont-top"></div>
                                        <div class="leftmenu-cont-mid">
                                          <div class="m-left">
                                            <div class="m-right">
                                              <div class="leftmenu-cnt" id="menucontainer'.$index.'">
                                                <ul class="mainnav">
                                                  <li style="position:relative;" id="menufiller'.$index.'">
                                                    '.build_menu_items($menuitems).'
                                                  </li>
                                                </ul>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="leftmenu-cont-bot"></div>
                                      </div>
                                    </div>';
        }
    }
}

function write_subheader($subheader){
    global $MW;
	global $currtmp;
    echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
    <td width="24"><img src="'.$currtmp.'/images/subheader-left-sword.gif" height="20" width="24" alt=""/></td>
    <td bgcolor="#05374a" width="100%"><b style="color:white;">'.$subheader.':</b></td>
    <td width="10"><img src="'.$currtmp.'/images/subheader-right.gif" height="20" width="10" alt=""/></td>
</tr>
</tbody></table>';
}
function write_metalborder_header(){
    global $MW;
	global $currtmp;
    echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
    <td width="12"><img src="'.$currtmp.'/images/metalborder-top-left.gif" height="12" width="12" alt=""/></td>
    <td style="background:url(\''.$currtmp.'/images/metalborder-top.gif\');"></td>
    <td width="12"><img src="'.$currtmp.'/images/metalborder-top-right.gif" height="12" width="12" alt=""/></td>
</tr>
<tr>
    <td style="background:url(\''.$currtmp.'/images/metalborder-left.gif\');"></td>
    <td>
';
}

function write_metalborder_footer(){
    global $MW;
	global $currtmp;
    echo '        </td>
        <td style="background:url(\''.$currtmp.'/images/metalborder-right.gif\');"></td>
    </tr>
    <tr>
        <td><img src="'.$currtmp.'/images/metalborder-bot-left.gif" height="11" width="12" alt=""/></td>
        <td style="background:url(\''.$currtmp.'/images/metalborder-bot.gif\');"></td>
        <td><img src="'.$currtmp.'/images/metalborder-bot-right.gif" height="11" width="12" alt=""/></td>
    </tr>
    </tbody>
</table>
';
}

function write_form_tool(){
    global $MW;
	global $currtmp;
    $template_href = $currtmp . "/";
?>
        <div id="form_tool">
            <ul id="bbcode_tool">
                <li id="bbcode_b"><a href="#"><img src="<?php echo $template_href;?>images/button-bold.gif" alt="<?php lang('editor_bold'); ?>" title="<?php lang('editor_bold'); ?>"></a></li>
                <li id="bbcode_i"><a href="#"><img src="<?php echo $template_href;?>images/button-italic.gif" alt="<?php lang('editor_italic'); ?>" title="<?php lang('editor_italic'); ?>"></a></li>
                <li id="bbcode_u"><a href="#"><img src="<?php echo $template_href;?>images/button-underline.gif" alt="<?php lang('editor_underline'); ?>" title="<?php lang('editor_underline'); ?>"></a></li>
                <li id="bbcode_url"><a href="#"><img src="<?php echo $template_href;?>images/button-url.gif" alt="<?php lang('editor_link'); ?>" title="<?php lang('editor_link'); ?>"></a></li>
                <li id="bbcode_img"><a href="#"><img src="<?php echo $template_href;?>images/button-img.gif" alt="<?php lang('editor_image'); ?>" title="<?php lang('editor_image'); ?>"></a></li>
                <li id="bbcode_blockquote"><a href="#"><img src="<?php echo $template_href;?>images/button-quote.gif" alt="<?php lang('editor_quote'); ?>" title="<?php lang('editor_quote'); ?>"></a></li>
            </ul>
            <ul id="text_tool">
                <li id="text_size"><a href="#"><img src="<?php echo $template_href;?>images/button-size.gif" alt="<?php lang('editor_size'); ?>" title="<?php lang('editor_size'); ?>"></a>
                    <ul>
                        <li id="text_size-hugesize"><a href="#">Huge</a></li>
                        <li id="text_size-largesize"><a href="#">Large</a></li>
                        <li id="text_size-mediumsize"><a href="#">Medium</a></li>
                    </ul>
                </li>
                <li id="text_color"><a href="#"><img src="<?php echo $template_href;?>images/button-color.gif" alt="<?php lang('editor_color'); ?>" title="<?php lang('editor_color'); ?>"></a>
                    <ul>
                        <li id="text_color-red"><a href="#"><?php lang('editor_color_red'); ?></a></li>
                        <li id="text_color-green"><a href="#"><?php lang('editor_color_green'); ?></a></li>
                        <li id="text_color-blue"><a href="#"><?php lang('editor_color_blue'); ?></a></li>
                        <li id="text_color-custom"><a href="#"><?php lang('editor_color_custom'); ?></a></li>
                    </ul>
                </li>
                <li id="text_align"><a href="#"><img src="<?php echo $template_href;?>images/button-list.gif" alt="<?php lang('editor_align'); ?>" title="<?php lang('editor_align'); ?>"></a>
                    <ul>
                        <li id="text_align-left"><a href="#"><?php lang('editor_align_left'); ?></a></li>
                        <li id="text_align-right"><a href="#"><?php lang('editor_align_right'); ?></a></li>
                        <li id="text_align-center"><a href="#"><?php lang('editor_align_center'); ?></a></li>
                        <li id="text_align-justify"><a href="#"><?php lang('editor_align_justify'); ?></a></li>
                    </ul>
                </li>
                <li id="text_smile"><a href="#"><img src="<?php echo $template_href;?>images/button-emote.gif" alt="<?php lang('editor_smile'); ?>" title="<?php lang('editor_smile'); ?>"></a>
                    <ul>
<?php
$smiles = load_smiles();
$smilepath = (string)$MW->getConfig->generic->smiles_path;
foreach($smiles as $smile):
    $smilename = ucfirst(str_replace('.gif','',str_replace('.png','',$smile)));
?>
                        <li id="text_smile-<?php echo $smilepath.$smile;?>"><a href="#" title="<?php echo $smilename;?>"><img src="<?php echo $smilepath.$smile;?>" alt="<?php echo $smilename;?>"></a></li>
<?php
endforeach;
?>
                    </ul>
                </li>
            </ul>
        </div>
<?php
}

function random_screenshot(){
  $fa = array();
  if ($handle = opendir('images/screenshots/thumbs/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.html") {
            $fa[] = $file;
        }
    }
    closedir($handle);
  }
  $fnum = count($fa);
  $fpos = rand(0, $fnum-1);
  return $fa[$fpos];
}
function build_pathway(){
    global $lang;
    global $pathway_info;
    global $title_str,$pathway_str;
    $path_info2 = array($pathway_info);
    $path_c = count($path_info2);
    $pathway_info[$path_c-1]['link'] = '';
    $pathway_str = '';
    if(empty($_REQUEST['n']) || !is_array($pathway_info))$pathway_str .= ' <b><u>'.$lang['mainpage'].'</u></b>';
    else $pathway_str .= '<a href="./">'.$lang['mainpage'].'</a>';
    if(is_array($pathway_info)){
        foreach($pathway_info as $newpath){
            if(isset($newpath['title'])){
                if(empty($newpath['link'])) $pathway_str .= ' &raquo; '.$newpath['title'].'';
                else $pathway_str .= ' &raquo; <a href="'.$newpath['link'].'">'.$newpath['title'].'</a>';
                $title_str .= ' &raquo; '.$newpath['title'];
            }
        }
    }
    $pathway_str .= '';
}
// !!!!!!!!!!!!!!!! //
build_pathway();

function load_banners($type){
    global $DB;
    $result = $DB->select("SELECT * FROM banners WHERE type=?d ORDER BY num_click DESC",$type);
    return $result;
}

function paginate($num_pages, $cur_page, $link_to){
  $pages = array();
  $link_to_all = false;
  if ($cur_page == -1)
  {
    $cur_page = 1;
    $link_to_all = true;
  }
  if ($num_pages <= 1)
    $pages = array('1');
  else
  {
    $tens = floor($num_pages/10);
    for ($i=1;$i<=$tens;$i++)
    {
      $tp = $i*10;
      $pages[$tp] = "<a href='$link_to&p=$tp'>$tp</a>";
    }
    if ($cur_page > 3)
    {
      $pages[1] = "<a href='$link_to&p=1'>1</a>";
    }
    for ($current = $cur_page - 2, $stop = $cur_page + 3; $current < $stop; ++$current)
    {
      if ($current < 1 || $current > $num_pages){
        continue;
      }elseif ($current != $cur_page || $link_to_all){
        $pages[$current] = "<a href='$link_to&p=$current'>$current</a>";
      }else{
        $pages[$current] = '[ '.$current.' ]';
      }
    }
    if ($cur_page <= ($num_pages-3))
    {
      $pages[$num_pages] = "<a href='$link_to&p=$num_pages'>$num_pages</a>";
    }
  }
  $pages = array_unique($pages);
  ksort($pages);
  $pp = implode(' ', $pages);
  return str_replace('//','/',$pp);
}

function builddiv_start($type = 0, $title = "No title set") {
global $currtmp;
if ($type == 1) {
echo '<div style="width: 659px; height: 29px; background: url(\''.$currtmp.'/images/content-parting.jpg\') no-repeat;"><div style="padding: 2px 0px 0px 23px;"><font style="font-family: \'Times New Roman\', Times, serif; color: #640909;"><h2>'.$title.'</h2></font></div></div>';
echo '<div style="background: url(\''.$currtmp.'/images/light.jpg\') repeat; border-width: 1px; border-color: #000000; border-bottom-style: solid; margin: 0px 0px 5px 0px">';
echo '<div class="contentdiv">';
}
else {
if ($title != "No title set") {
echo '<div style="width: 659px; height: 29px; background: url(\''.$currtmp.'/images/content-parting2.jpg\') no-repeat;"><div style="padding: 2px 0px 0px 23px;"><font style="font-family: \'Times New Roman\', Times, serif; color: #640909;"><h2>'.$title.'</h2></font></div></div>';
echo '<div style="background: url(\''.$currtmp.'/images/light.jpg\') repeat; border-width: 1px; border-color: #000000; border-bottom-style: solid; margin: 0px 0px 5px 0px">';
echo '<div class="contentdiv">';
}
else {
echo '<div style="background: url(\''.$currtmp.'/images/light.jpg\') repeat; border-width: 1px; border-color: #000000; border-top-style: solid; border-bottom-style: solid; margin: 4px 0px 5px 0px">';
echo '<div class="contentdiv">';
}
}
}


function builddiv_end() {
echo '</div></div>';
}
?>
