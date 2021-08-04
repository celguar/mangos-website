<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>$lang['langs_manage'],'link'=>'index.php?n=admin&sub=langs');

if(empty($_GET['action'])){
    
} elseif ($_GET['action'] == 'edit' && isset($_GET['lang'])) {
    $pathway_info[] = array('title'=>$lang['editing'].' : '.$languages[$_GET['lang']],'link'=>'index.php?n=admin&sub=langs');
        $vic = 0;
        $elangArray = array();
        $elangfile = @file_get_contents('lang/'.$_GET['lang'].'.'.$languages[$_GET['lang']].'.lang');
        $elangfile = str_replace("\n",'',$elangfile);
        $elangfile = str_replace("\r",'',$elangfile);
        $elangfile = explode('|=|',$elangfile);
        foreach($elangfile as $langstr){
            $elangStr = explode(' :=: ',$langstr);
            if($elangStr[0])$elangArray[$elangStr[0]] = $elangStr[1];
        }
} elseif ($_GET['action'] == 'upload' && isset($_FILES['upllang'])) {
    $ext = strtolower(substr(strrchr($_FILES['upllang']['name'],'.'), 1));
    if($ext == 'lang' && !file_exists('lang/'.$_FILES['upllang']['name'])){
        @move_uploaded_file($_FILES['upllang']['tmp_name'], 'lang/'.$_FILES['upllang']['name']);
        redirect('index.php?n=admin&sub=langs',1);
    }
} elseif ($_GET['action'] == 'delete' && isset($_GET['lang'])) {
    unlink('lang/'.$_GET['lang'].'.'.$languages[$_GET['lang']].'.lang');
    redirect('index.php?n=admin&sub=langs',1);
    
} elseif ($_GET['action'] == 'doedit' && isset($_GET['lang'])) {
    chmod('lang/',0777);
    $newlangfile = '';
    $bigLangArray = $_POST['elang'];
    foreach ($bigLangArray as $lvars) {
        if($lvars['key'])$thislang[$lvars['key']] = $lvars['val'];
    }
    foreach($thislang as $key => $val){
        $newlangfile .= '|=|'.$key.' :=: '.$val."\n";
    }
    file_put_contents('lang/'.$_GET['lang'].'.'.$languages[$_GET['lang']].'.lang',$newlangfile);
    redirect('index.php?n=admin&sub=langs',1);

}