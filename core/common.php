<?php

$realm_type_def = array(
    0 => 'Normal',
    1 => 'PVP',
    4 => 'Normal',
    6 => 'RP',
    8 => 'RPPVP',
    16 => 'FFA_PVP'
);

$realm_timezone_def = array(
     0 => 'Unknown',
     1 => 'Development',
     2 => 'United States',
     3 => 'Oceanic',
     4 => 'Latin America',
     5 => 'Tournament',
     6 => 'Korea',
     7 => 'Tournament',
     8 => 'English',
     9 => 'German',
    10 => 'French',
    11 => 'Spanish',
    12 => 'Russian',
    13 => 'Tournament',
    14 => 'Taiwan',
    15 => 'Tournament',
    16 => 'China',
    17 => 'CN1',
    18 => 'CN2',
    19 => 'CN3',
    20 => 'CN4',
    21 => 'CN5',
    22 => 'CN6',
    23 => 'CN7',
    24 => 'CN8',
    25 => 'Tournament',
    26 => 'Test Server',
    27 => 'Tournament',
    28 => 'QA Server',
    29 => 'CN9',
);

function escape_string($string)
{
    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }

    return mysql_real_escape_string($string);
}

// quote smart function to do MySQL Escaping properly //
function quote_smart($value)
{
    if( is_array($value) ) {
        return array_map("quote_smart", $value);
    } else {
        if( get_magic_quotes_gpc() ) {
            $value = stripslashes($value);
        }
        if( $value == '' ) {
            $value = 'NULL';
        } if( !is_numeric($value) || $value[0] == '0' ) {
            $value = "'".mysql_real_escape_string($value)."'";
        }
        return $value;
    }
}

function get_from_mangosconf($configvalue,$id){ // Get Config values FROM mangos conf file. $configvalue should be name of config. $id is ID of realm ( config array value )
    global $MW;
    $init = 'id_'.$id;
    $mangosconf = file((string)$MW->getConfig->mangos_conf_external->$init->mangos_world_conf);
    foreach ($mangosconf as $line_num){
        $line_num = (string)$line_num;
        if (strstr($line_num,$configvalue) == TRUE){
            $arr = explode(' = ', $line_num);
            return str_replace("\r","",str_replace("\n","",$arr['1']));
        }
    }
}

function sha_password($user,$pass){
    $user = strtoupper($user);
    $pass = strtoupper($pass);
    return SHA1($user.':'.$pass);
}

function check_for_symbols($string, $space_check = 0){
    //$space_check=1 means space is not allowed
    $len=strlen($string);
    $allowed_chars="abcdefghijklmnopqrstuvwxyzÊ¯ÂABCDEFGHIJKLMNOPQRSTUVWXYZ∆ÿ≈0123456789";
    if(!$space_check) {
        $allowed_chars .= " ";
    }
    for($i=0;$i<$len;$i++)
        if(strstr($allowed_chars,$string[$i]) == FALSE)
            return TRUE;
    return FALSE;
}

function get_banned($account_id,$returncont){
    global $DB;

    $get_last_ip = $DB->selectCell("SELECT last_ip FROM account WHERE id='".$account_id."'");
    $db_IP = $get_last_ip;

    $ip_check = $DB->selectCell("SELECT ip FROM `ip_banned` WHERE ip='".$db_IP."'");
    if ($ip_check == FALSE){
        if ($returncont == "1"){
            return FALSE;
        }
    }
    else{
        if ($returncont == "1"){
            return TRUE;
        }
        else{
            return $db_IP;
        }
    }
}

/**
 * Replaces the first character of a text by a left-aligned picture of this character (html img tag)
 *
 * Remark: this function is limited to alphabetical characters. If a known
 * character with accent is found, the image of this letter without accent
 * will be used. If the character is completely unknown, the text is returned
 * without changes.
 *
 * @param $text string Text for which the first character should be replaced by an image letter
 * @return string Text with image letter
 */
function add_pictureletter($text){
    $letter = substr($text, 0, 1);
    $imageletter = strtr(strtolower($letter),"äåéöúûü•µ¿¡¬√ƒ≈∆«»… ÀÃÕŒœ–—“”‘’÷ÿŸ⁄€‹›ﬂ‡·‚„‰ÂÊÁËÈÍÎÏÌÓÔÒÚÛÙıˆ¯˘˙˚¸˝ˇ",
                                             "sozsozyyuaaaaaaaceeeeiiiidnoooooouuuuysaaaaaaaceeeeiiiionoooooouuuuyy");
    if (strpos("abcdefghijklmnopqrstuvwxyz", $imageletter) === false)
        return $text;
    $img = '<img src="templates/WotLK/images/letters/'.$imageletter.'.gif" alt="'.$letter.'" align="left"/>';
    $output = $img . substr($text, 1);
    return $output;
}

function random_string($counts){
    $str = "abcdefghijklmnopqrstuvwxyz";//Count 0-25
    $o = 0;
    for($i=0;$i<$counts;$i++){
        if ($o == 1){
            $output .= rand(0,9);
            $o = 0;
        }else{
            $o++;
            $output .= $str[rand(0,25)];
        }
    }
    return $output;
}

function output_message($type,$text,$file='',$line=''){
    if($file)$text .= "\n<br>in file: $file";
    if($line)$text .= "\n<br>on line: $line";
    $GLOBALS['messages'] .= "\n<div class=\"".$type."_box\">$text</div> \n";
}


function redirect($linkto,$type=0,$wait_sec=0){
    if($linkto){
        if($type==0){
            $GLOBALS['redirect'] = '<meta http-equiv=refresh content="'.$wait_sec.';url='.$linkto.'">';
        }else{
            // Header not works for some(?) computers. Add hax to it.
            header("Location: ".$linkto);
        }
    }
}

function loadLanguages(){
    global $realmd;
    global $mangos;
    global $languages;
    global $lang;
    global $MW;
    $languages = array();
    $lang = array();
    if ($handle = opendir('lang/')) {
        $available_languages = explode(",", $MW->getConfig->generic->available_languages);
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.html") {
                $tmp = explode('.',$file);
                if(isset($tmp[2]) && $tmp[2]=='lang' && in_array($tmp[0], $available_languages))$languages[$tmp[0]] = $tmp[1];
            }
        }
        closedir($handle);
        if (!in_array($MW->getConfig->generic->default_lang, $available_languages)) {
            array_unshift($available_languages, $MW->getConfig->generic->default_lang);
        }
        if (!in_array($GLOBALS['user_cur_lang'], $available_languages)) {
            $GLOBALS['user_cur_lang'] = $MW->getConfig->generic->default_lang;
        }
        if(file_exists('core/cache/lang/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.php')) {
            if((filemtime('core/cache/lang/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.php') >= filemtime('lang/'.$GLOBALS['user_cur_lang'].'.'.
            $languages[$GLOBALS['user_cur_lang']].'.lang')) && (filemtime('core/cache/lang/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.php') >=
            filemtime('lang/'.(string)$MW->getConfig->generic->default_lang.'.'.$languages[(string)$MW->getConfig->generic->default_lang].'.lang'))) {
                include_once('core/cache/lang/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.php');
                return;
            }
        }
        $langfile = @file_get_contents('lang/'.(string)$MW->getConfig->generic->default_lang.'.'.$languages[(string)$MW->getConfig->generic->default_lang].'.lang');
        $langfile = str_replace("\n",'',$langfile);
        $langfile = str_replace("\r",'',$langfile);
        $langfile = explode('|=|',$langfile);
        foreach($langfile as $langstr){
            $langstra = explode(' :=: ',$langstr);
            if(isset($langstra[1]))$lang[$langstra[0]] = $langstra[1];
        }
        if ($GLOBALS['user_cur_lang'] != (string)$MW->getConfig->generic->default_lang) {
            $langfile = @file_get_contents('lang/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.lang');
            $langfile = str_replace("\n",'',$langfile);
            $langfile = str_replace("\r",'',$langfile);
            $langfile = explode('|=|',$langfile);
            foreach($langfile as $langstr){
                $langstra = explode(' :=: ',$langstr);
                if(isset($langstra[1]) && trim($langstra[1])!='')$lang[$langstra[0]] = $langstra[1];
            }
        }

        $fhlang = fopen ('core/cache/lang/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.php', "w");
        fwrite($fhlang, '<?php'."\n".'$lang = '.var_export($lang,1).";\n".'?>');
        fclose($fhlang);
    }

}

/**
 * Translates a variable into the current user language
 *
 * This translation function uses the language file as cached by the
 * loadLanguages() function. If a requested translation is not found in the
 * default language file as well as the current users language's file, this
 * function will convert the given text by replacing underscores with spaces
 * and capitalizing the first character.
 *
 * @param $var string The variable/name to be translated. This should be available in the language file
 * @param $dontecho boolean Should this text be echoed (default) or not? This parameter can be valuable if you just want the translation to be returned, but not sent to the browser immediately.
 * @return string Translated text.
 */
function lang($var, $dontecho=false){
    global $lang;
    if (isset($lang[$var]))
        $result = $lang[$var];
    else
        $result = ucfirst(str_replace('_', ' ', $var));
    if (!$dontecho)
        echo $result;
    return $result;
}


/**
 * Returns a translated resource file
 *
 * This function can be called to retrieve a translated resource using simply a
 * filename like "howtoplay.html". It then expects the translated resource to
 * be available under /lang/howtoplay/en.html. It first looks for the
 * document in the current user's language and if not found it tries to use the
 * default_lang configured language.
 *
 * Note: To prevent backwards compatibility issues, this function also finds
 * your document when it's stored as /lang/en.howtoplay.html or
 * /lang/howtoplay/howtoplay_en.html. This format will be deprecated soon
 * however.
 *
 * @param $name string The resource name in "filename.ext" format
 * @return string Translated resource content.
 */
function lang_resource($name){
    global $MW;
    $resourceinfo = pathinfo($name);
    $resourcename = $resourceinfo["filename"];
    $resourceext = $resourceinfo["extension"];
    
    $languages[] = isset($GLOBALS['user_cur_lang']) ? $GLOBALS['user_cur_lang'] : '';
    $languages[] = (string)$MW->getConfig->generic->default_lang;
    $result = '';
    foreach($languages as $language)
    {
        $sourcefiles[] = "lang/$resourcename/$language.$resourceext";
        $sourcefiles[] = "lang/$resourcename/{$resourcename}_$language.$resourceext";
        $sourcefiles[] = "lang/$language.$resourcename.$resourceext";
        foreach($sourcefiles as $sourcefile)
        {
            if (file_exists($sourcefile))
                $result = file_get_contents($sourcefile);
            if (trim($result) != '')
                return $result;
        }
    }
    return '';
}


/**
 * Returns a list of available smilies
 *
 * @param $dir string Path on local filesystem of server to the smilies (defaults to images/smiles/)
 * @return array List of found files in the given directory (.svn, Thumbs.db and index.html are exluded)
 */
function load_smiles($dir='images/smiles/'){
    $allfiles = scandir($dir);
    $smiles = array_diff($allfiles, array(".", "..", ".svn", "Thumbs.db", "index.html"));
    return $smiles;
}


function send_email($to_email,$to_name,$theme,$text_text,$text_html=''){
    global $MW;
    if(!(string)$MW->getConfig->generic->smtp_adress){
        output_message('alert','Set SMTP settings in config !');
        return false;
    }
    if(!$to_email){
        output_message('alert','Field "to" is empty.');
        return false;
    }
    set_time_limit(300);
    include('core/mail/smtp.php');
    $mail = new SMTP;
    $mail->Delivery('relay');
    $mail->Relay((string)$MW->getConfig->generic->smtp_adress,(string)$MW->getConfig->generic->smtp_username,(string)$MW->getConfig->generic->smtp_password);
    $mail->From((string)$MW->getConfig->generic->site_email, (string)$MW->getConfig->generic->site_title);
    $mail->AddTo($to_email, $to_name);
    $mail->Text($text_text);
    if($text_html)$mail->Html($text_html);
    $sent = $mail->Send($theme);
    return $sent;
}

function strip_if_magic_quotes($value){
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    return $value;
}

function my_preview($text,$userlevel=0){
    if($userlevel<1){$text = htmlspecialchars($text);if (get_magic_quotes_gpc()){$text = stripslashes($text);} }
    $text = nl2br($text);
    $text = preg_replace("/\\[b\\](.*?)\\[\\/b\\]/s","<b>$1</b>",$text);
    $text = preg_replace("/\\[i\\](.*?)\\[\\/i\\]/s","<i>$1</i>",$text);
    $text = preg_replace("/\\[u\\](.*?)\\[\\/u\\]/s","<u>$1</u>",$text);
    $text = preg_replace("/\\[s\\](.*?)\\[\\/s\\]/s","<s>$1</s>",$text);
    $text = preg_replace("/\\[hr\\]/s","<hr>",$text);
    $text = preg_replace("/\\[code\\](.*?)\\[\\/code\\]/s","<code>$1</code>",$text);
    //$text = preg_replace("/\[blockquote\](.*?)\[\/blockquote\]/s","<blockquote>$1</blockquote>",$text);
    if (strpos($text, 'blockquote') !== false)
    {
        if(substr_count($text, '[blockquote') == substr_count($text, '[/blockquote]')){
            $text = str_replace('[blockquote]', '<blockquote><div>', $text);
            $text = preg_replace('#\[blockquote=(&quot;|"|\'|)(.*)\\1\]#sU', '<blockquote><span class="bhead">Quote: $2</span><div>', $text);
            $text = preg_replace('#\[\/blockquote\]\s*#', '</div></blockquote>', $text);
        }
    }
    // Blizz quote <small><hr color="#9e9e9e" noshade="noshade" size="1"><small class="white">Q u o t e:</small><br>Text<hr color="#9e9e9e" noshade="noshade" size="1"></small>
    $text = preg_replace("/\\[img\\](.*?)\\[\\/img\\]/s","<img src=\"$1\" align=\"absmiddle\">",$text);
    $text = preg_replace("/\\[attach=(\\d+)\\]/se","check_attach('\\1')",$text);
    $text = preg_replace("/\\[url=(.*?)\\](.*?)\\[\\/url\\]/s","<a href=\"$1\" target=\"_blank\">$2</a>",$text);
    $text = preg_replace("/\\[size=(.*?)\\](.*?)\\[\\/size\\]/s","<font class='$1'>$2</font>",$text);
    $text = preg_replace("/\\[align=(.*?)\\](.*?)\\[\\/align\\]/s","<p align='$1'>$2</p>",$text);
    $text = preg_replace("/\\[color=(.*?)\\](.*?)\\[\\/color\\]/s","<font color=\"$1\">$2</font>",$text);
    $text = preg_replace("/[^\\'\"\\=\\]\\[<>\\w]([\\w]+:\\/\\/[^\n\r\t\\s\\[\\]\\>\\<\\'\"]+)/s"," <a href=\"$1\" target=\"_blank\">$1</a>",$text);
    return $text;
}

function my_previewreverse($text){
    $text = str_replace('<br />','',$text);
    $text = preg_replace("/<b>(.*?)<\\/b>/s","[b]$1[/b]",$text);
    $text = preg_replace("/<i>(.*?)<\\/i>/s","[i]$1[/i]",$text);
    $text = preg_replace("/<u>(.*?)<\\/u>/s","[u]$1[/u]",$text);
    $text = preg_replace("/<s>(.*?)<\\/s>/s","[s]$1[/s]",$text);
    $text = preg_replace("/<hr>/s","[hr]",$text);
    $text = preg_replace("/<code>(.*?)<\\/code>/s","[code]$1[/code]",$text);
    //$text = preg_replace("/<blockquote>(.*?)<\/blockquote>/s","[blockquote]$1[/blockquote]",$text);
    if (strpos($text, 'blockquote') !== false)
    {
        if(substr_count($text, '<blockquote>') == substr_count($text, '</blockquote>')){
            $text = str_replace('<blockquote><div>', '[blockquote]', $text);
            $text = preg_replace('#\<blockquote><span class="bhead">\w+: (&quot;|"|\'|)(.*)\\1\<\/span><div>#sU', '[blockquote="$2"]', $text);
            $text = preg_replace('#<\/div><\/blockquote>\s*#', '[/blockquote]', $text);
        }
    }
    $text = preg_replace("/<img src=.([^'\"<>]+). align=.absmiddle.>/s","[img]$1[/img]",$text);
    $text = preg_replace("/(<a href=.*?<\\/a>)/se","check_url_reverse('\\1')",$text);
    $text = preg_replace("/<font color=.([^'\"<>]+).>([^<>]*?)<\\/font>/s","[color=$1]$2[/color]",$text);
    $text = preg_replace("/<font class=.([^'\"<>]+).>([^<>]*?)<\\/font>/s","[size=$1]$2[/size]",$text);
    $text = preg_replace("/<p align=.([^'\"<>]+).>([^<>]*?)<\\/p>/s","[align=$1]$2[/align]",$text);
    return $text;
}

function check_url_reverse($url){
    $url = stripslashes($url);
    if(eregi('attach',$url) && eregi('attid',$url)){
        $result = preg_replace("/<a href=\"[^\\'\"]*attid=(\\d+)[^\\'\"]*\" target=\"_blank\">.*?<\\/a>/s","[attach=$1]",$url);
    }else{
        $result = preg_replace("/<a href=\"([^'\"<>]+)\" target=\"_blank\">(.*?)<\\/a>/s","[url=$1]$2[/url]",$url);
    }
    return $result;
}

function check_attach($attid){
    global $DB, $MW;
    $thisattach = $DB->selectRow("SELECT * FROM f_attachs WHERE attach_id=?d",$attid);
    $ext = strtolower(substr(strrchr($thisattach['attach_file'],'.'), 1));
    if($thisattach['attach_id']){
        $res  = '<a href="'.$MW->getConfig->temp->site_href.'index.php?n=forum&sub=attach&nobody=1&action=download&attid='.$thisattach['attach_id'].'">';
        $res .= '<img src="'.$MW->getConfig->temp->site_href.'images/mime/'.$ext.'.png" alt="" align="absmiddle">';
        $res .= ' Download: [ '.$thisattach['attach_file'].' ] '.return_good_size($thisattach['attach_filesize']).' </a>';
    }
    return $res;
}

function check_image($img_file){
    global $MW;
    $maximgsize = explode('x',(string)$MW->getConfig->generic->imageautoresize);
    $path_parts = pathinfo($img_file);
    $max_width = (int)$maximgsize[0];
    $max_height = (int)$maximgsize[1];
    $fil_scr_res = getimagesize(rawurldecode($img_file));
    if($fil_scr_res[0]>$max_width || $fil_scr_res[1]>$max_height){
        $n_img_file = $path_parts['dirname'].'/resized_'.$path_parts['basename'];
        if(!file_exists($n_img_file)){
            include('core/class.image.php');
            $img = new IMAGE;
            ob_start();
            $res = $img->send_thumbnail($img_file,$max_width,$max_height,true);
            $imgcontent = ob_get_contents();
            @ob_end_clean();
            if ($res && (@$fp = fopen($n_img_file,'w+')))
            {
                fwrite($fp,$imgcontent);
                fclose($fp);
            }else{
                output_message('alert','Could not create preview!');
            }
        }
        $image = $n_img_file;
    }else{
        $image = $img_file;
    }
    return $image;
}

function return_good_size($n){
    $kb_divide = 1024;
    $mb_divide = 1024*1024;
    $gb_divide = 1024*1024*1024;

    if($n < $mb_divide){$res = round(($n/$kb_divide),2).' Kb';}
    elseif($n < $gb_divide){$res = round(($n/$mb_divide),2).' Mb';}
    elseif($n >= $gb_divide){$res = round(($n/$gb_divide),2).' Gb';}

    return $res;
}

function default_paginate($num_pages, $cur_page, $link_to){
    $pages = array();
    $link_to_all = false;
    if ($cur_page == -1)
    {
        $cur_page = 1;
        $link_to_all = true;
    }
    if ($num_pages <= 1)
        $pages = array('');
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
            if ($current < 1 || $current > $num_pages) {
                continue;
            } elseif ($current != $cur_page || $link_to_all) {
                $pages[$current] = "<a href='$link_to&p=$current'>$current</a>";
            } else {
                $pages[$current] = '['.$current.']';
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
    return $pp;
}

// ACCOUNT KEY FUNCTIONS //
function matchAccountKey($id, $key) {
    clearOldAccountKeys();
    global $DB;
    $count = $DB->selectcell("SELECT count(*) FROM `account_keys` where id = ?", $id);
    if($count == 0) {
        return false;
    }
    $account_key = $DB->selectcell("SELECT `key` FROM `account_keys` where id = ?", $id);
    if($key == $account_key) {
        return true;
    }
    else {
        return false;
    }
}

function clearOldAccountKeys() {
    global $DB;
    global $MW;

    $cookie_expire_time = (int)$MW->getConfig->generic->account_key_retain_length;
    if(!$cookie_expire_time) {
        $cookie_expire_time = (60*60*24*365);   //default is 1 year
    }

    $expire_time = time() - $cookie_expire_time;

    $DB->query("DELETE FROM `account_keys` WHERE `assign_time` < ?", $expire_time);
}

function addOrUpdateAccountKeys($id, $key) {
    global $DB;

    $current_time = time();

    $count = $DB->selectcell("SELECT count(*) FROM account_keys where id = ?", $id);
    if($count == 0) {   //need to INSERT
        $DB->query("INSERT INTO `account_keys` SET `id` = ?, `key` = ?, `assign_time` = ?", $id, $key, $current_time);
    }
    else {              //need to UPDATE
        $DB->query("UPDATE `account_keys` SET `key` = ?, `assign_time` = ? WHERE `id` = ?", $key, $current_time, $id);
    }
}

function removeAccountKeyForUser($id) {
    global $DB;

    $count = $DB->selectcell("SELECT count(*) FROM account_keys where id = ?", $id);
    if($count == 0) {
        //do nothing
    }
    else {
        $DB->query("DELETE FROM `account_keys` WHERE `id` = ?", $id);
    }
}

function localizedImage($filename)
{
    $alang=$GLOBALS['user_cur_lang'];
    if (file_exists("images/localized/$alang/$filename"))
    {
        $path="images/localized/$alang/$filename";
    }
    else
    {
        $path="images/localized/en/$filename";
    }

    return $path;
}

// Function: Logs an message to log file.
function log_error($string, $choise=1){

  if($choise == 1){
    $fh = fopen("core/logs/core_error_log.log", 'a');
    fwrite($fh, "Error ".date('Y m d h: s: m')."  --  >  ".$string." \n");
    fclose($fh);
  }
}

function RemoveXSS($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

      // &#x0040 @ search for the hex values
      $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // &#00064 @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
               $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
               $pattern .= ')?';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }
   return $val;
}

function get_realm_byid($id){
    global $DB, $MW;
    $search_q = $DB->selectRow("SELECT * FROM `realmlist` WHERE `id`=?d",$id);
    if((int)$MW->getConfig->generic->use_local_ip_port_test) {
        $search_q['address'] = "127.0.0.1";
    }

    return $search_q;
}

function check_port_status($ip, $port){
    $ERROR_NO = null;
    $ERROR_STR = null;
    if($fp1=fsockopen($ip, $port, $ERROR_NO, $ERROR_STR,(float)1.0)){
        fclose($fp1);return true;
    }else{
        return false;
    }
}

function databaseErrorHandler($message, $info)
{
    if (!error_reporting()) return;
    output_message('alert',"SQL Error: $message<br><pre>".print_r($info, true)."</pre>");
}

function getMangosConfig($mangos_config_file) {
    $file_contents = file_get_contents($mangos_config_file);
    $explode_array = explode("\n",$file_contents);
    $config_details = array();
    foreach($explode_array as $explode_entry) {
        $new = explode('#', $explode_entry);
        $new[0] = trim($new[0]);
        if($new[0]) {
            $this_line_array = explode('=', $new[0]);
            $this_line_array[0] = trim($this_line_array[0]);
            $this_line_array[1] = trim($this_line_array[1]);
            $this_line_array[1] = trim($this_line_array[1],';');
            //$config_details[$this_line_array[0]] = $this_line_array[1];
            $config_details[$this_line_array[0]] = $this_line_array[1];
        }
    }
    unset($config_details['LoginDatabaseInfo']);
    unset($config_details['WorldDatabaseInfo']);
    return $config_details;
}

/**
 * Composes a mangosweb url which can be used in templates for example.
 *
 * Using this function instead of handcrafted index.php?n=..&sub=.. allows
 * for easier transparent url rewriting. It also implementes encoding the
 * entities in the url so you can echo the result of this result directly
 * in your html code without causing it fail W3C validation.
 *
 * @param $page string The page to be targeted by this url
 * @param $subpage string The subpage to be targeted by this url
 * @param $params array An optional array containing additional arguments to be passed when requesting the url (default empty)
 * @param $encodentities boolean Encode the entities (like replacing & by &amp;) so it can be used in html templates directly? (defaults to true)
 * @result string The url containing all the given parameters
 * @todo Make a config option for url rewriting and implement an if switch
 *       here to make urls like /account/manage instead of 
 *       index.php?n=account&sub=manage possible.
 */
function mw_url($page, $subpage, $params=null, $encodeentities=true) {
    $url = "index.php?n=$page&sub=$subpage";
    if (is_array($params)) {
        foreach($params as $key=>$value) {
            $url .= "&$key=$value";
        }
    }
    return $encodeentities ? htmlentities($url) : $url;
}
