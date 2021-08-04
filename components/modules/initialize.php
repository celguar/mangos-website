<?php
if(INCLUDED!==true)exit;

if(file_exists('core/cache/modules/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.php')) {
    require('core/cache/modules/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.php');
}
else {
    //special module load function definitions//
    function module_loadLanguages($modulename){
        global $MW;
        global $languages;
        
        $module_lang = array();
    
        if ($handle = @opendir('components/modules/'.$modulename.'/lang/')) { 
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.html") {
                    $tmp = explode('.',$file);
                    if($tmp[2]=='lang')$languages[$tmp[0]] = $tmp[1];
                }
            }
            closedir($handle);
            $langfile = @file_get_contents('components/modules/'.$modulename.'/lang/'.(string)$MW->getConfig->generic->default_lang.'.'.$languages[(string)$MW->getConfig->generic->default_lang].'.lang');
            $langfile = str_replace("\n",'',$langfile);
            $langfile = str_replace("\r",'',$langfile);
            $langfile = explode('|=|',$langfile);
            foreach($langfile as $langstr){
                $langstra = explode(' :=: ',$langstr);
                if(isset($langstra[1]))$module_lang[$langstra[0]] = $langstra[1];
            }
            if ($GLOBALS['user_cur_lang'] != (string)$MW->getConfig->generic->default_lang) {
                $langfile = @file_get_contents('components/modules/'.$modulename.'/lang/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.lang');
                $langfile = str_replace("\n",'',$langfile);
                $langfile = str_replace("\r",'',$langfile);
                $langfile = explode('|=|',$langfile);
                foreach($langfile as $langstr){
                    $langstra = explode(' :=: ',$langstr);
                    if(isset($langstra[1]))$module_lang[$langstra[0]] = $langstra[1];
                }
            }
        }
        
        return $module_lang;
    }

function php4_scandir($dir,$listDirectories=false, $skipDots=true) {
    $dirArray = array();
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if (($file != "." && $file != "..") || $skipDots == true) {
                if($listDirectories == false) { if(is_dir($file)) { continue; } }
                array_push($dirArray,basename($file));
            }
        }
        closedir($handle);
    }
    return $dirArray;
}
    
    function returnmodules() {
        $modules_directories = array();
    
        $modules_files = php4_scandir('components/modules/');
        foreach($modules_files as $file){
            if(is_dir('components/modules/'.$file) && $file != '.' && $file != '..') {
                 $modules_directories[] = $file;
            }
        }
    
        return $modules_directories;
    }
    
    /*
    function modules_loadcontextmenu() {
        global $user;
        $module_context_menu = array();
        global $modules_installed;
        global $lang;
        foreach($modules_installed as $module){
            @include('components/modules/'.$module.'/menuconfig.php');
    
            if($module_menu['contextmenu']){
                if($module_menu['view']){
                    if($user[$module_menu['view']]==1) {
                        if(isset($lang['module_'.$module])) $module_contextmenuarray = array(
                            'title' => $lang['module_'.$module],
                            'link' => 'index.php?n=modules&sub='.$module,
                        );
                    }
                }
                else {
                    if(isset($lang['module_'.$module])) $module_contextmenuarray = array(
                        'title' => $lang['module_'.$module],
                        'link' => 'index.php?n=modules&sub='.$module,
                    );
                }
                $module_context_menu[] = $module_contextmenuarray;
            }
        }
        return $module_context_menu;
    }
    */
    //End special module functions//
    
    $modules_installed = returnmodules();
    
    $module_mainnav_links = array();
    $module_lang = array();
    
    foreach($modules_installed as $module){
        $module_menu = null;
        $module_sidebararray = null;
        @include('components/modules/'.$module.'/menuconfig.php');
    
        if($module_menu['sidebarmenu']) {
            $module_sidebararray = array(
                'module_'.$module,
                'index.php?n=modules&sub='.$module,
                $module_menu['view'],
            );
            $module_mainnav_links[$module_menu['sidebarmenu']][] = $module_sidebararray;
        }
    
        if($module_menu['contextmenu']) {
            $module_contextmenuarray = array(
                'title' => 'module_'.$module,
                'link' => 'index.php?n=modules&sub='.$module,
            );
        }
        
        $module_lang = array_merge($module_lang, module_loadLanguages($module));
        if(isset($lang['module_'.$module]) == 0) {
            $lang['module_'.$module] = $module.' Module';
        }
    }
    
    $module_cache = array(
        'module_lang' => &$module_lang,
        'module_mainnav_links' => &$module_mainnav_links,
    );
    
    
    
    //cache this -- there is no need to parse on each page load
    //user can delete the cache file if new modules are installed.
    $fhmodules = fopen ('core/cache/modules/'.$GLOBALS['user_cur_lang'].'.'.$languages[$GLOBALS['user_cur_lang']].'.php', "w");
    fwrite($fhmodules, '<?php');
    foreach($module_cache as $name => $variable) {
        fwrite($fhmodules, "\n$".$name.' = '.var_export($variable,1).";\n");
    }
    fwrite($fhmodules, '?>');
    fclose($fhmodules);
}

$lang = array_merge($lang, $module_lang);
$mainnav_links = array_merge_recursive($mainnav_links, $module_mainnav_links);

$allowed_ext[] = 'modules';
?>
