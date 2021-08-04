<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['components_manage'],'link'=>$com_links['sub_components']);
// ==================== //

if($_GET['action']=='doupdate'){
    chmod('core/cache/',0777);
    chmod('lang/',0777);
    if ($handle = opendir('components/')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.html") {
                $exist_comp[] = $file;
            }
        }
        closedir($handle);
    }
    $com_content = array();
    $tmp_allowed_ext = array();
    $tmp_mainnav_links = array();
    foreach($exist_comp as $tmp_comp){
        @include('components/'.$tmp_comp.'/main.php');
        // search install lang files
        foreach($languages as $lang_s=>$lang_name){
            if(file_exists('components/'.$tmp_comp.'/'.$lang_s.'.'.$lang_name.'.lang')){
                $langfile = @file_get_contents('lang/'.$lang_s.'.'.$lang_name.'.lang');
                $langfile = str_replace("\n",'',$langfile);
                $langfile = str_replace("\r",'',$langfile);
                $langfile = explode('|=|',$langfile);
                foreach($langfile as $langstr){
                    $langstra = explode(' :=: ',$langstr);
                    if(isset($langstra[1]))$thislang[$langstra[0]] = $langstra[1];
                }
                $langfile = @file_get_contents('components/'.$tmp_comp.'/'.$lang_s.'.'.$lang_name.'.lang');
                $langfile = str_replace("\n",'',$langfile);
                $langfile = str_replace("\r",'',$langfile);
                $langfile = explode('|=|',$langfile);
                foreach($langfile as $langstr){
                    $langstra = explode(' :=: ',$langstr);
                    if(isset($langstra[1]))$thislang[$langstra[0]] = $langstra[1];
                }
                $newlangfile = '';
                $thislang = array_unique($thislang);
                foreach($thislang as $key => $val){
                    $newlangfile .= '|=|'.$key.' :=: '.$val."\n";
                }
                file_put_contents('lang/'.$lang_s.'.'.$lang_name.'.lang',$newlangfile);
                unset($newlangfile);
            }
        }
    }
    foreach ($com_content as $comp_name=>$comp_array){
        foreach ($comp_array as $comp_members){
            if($comp_members[3]){
                $tmp_mainnav_links[$comp_members[3]][] = array($comp_members[1],$comp_members[2],$comp_members[0]);
            }
        }
        $tmp_allowed_ext[] = $comp_name;
    }
    ksort($tmp_mainnav_links);
    
    $cache_str  = "<?php\n";
    $cache_str .= '$mainnav_links = '.var_export($tmp_mainnav_links,true).';';
    $cache_str .= "\n\n";
    $cache_str .= '$allowed_ext = '.var_export($tmp_allowed_ext,true).';';
    $cache_str .= "?>";
    file_put_contents('core/cache/comp_cache.php',$cache_str);
    
    redirect($com_content['admin']['components'][2],1);
}
?>