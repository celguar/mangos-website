<?php

$script_file = 'components/modules/'.$sub.'/'.$sub.'.php';
$template_file = 'components/modules/'.$sub.'/template.php';


$module =& $sub;

$com_content['modules'] = array();
include('components/modules/'.$module.'/menuconfig.php');
$module_comarray = array(
    $module_menu['view'],
    'module_'.$module,
    'index.php?n=modules&sub='.$module,
    $module_menu['sidebarmenu'],
    $module_menu['contextmenu'],
);
$com_content['modules'][$module] = $module_comarray;

//Functions to be used by modules go here

function m_require_once($path, $folder = null) {
	$folder = $folder ? $folder : $_GET['sub'];
	$fullpath = 'components/modules/'.$folder.'/'.$path;
	include($fullpath);
}

function m_require($path, $folder = null) {
	$folder = $folder ? $folder : $_GET['sub'];
	$fullpath = 'components/modules/'.$_GET['sub'].'/'.$path;
	require($fullpath);
}

function m_path($path, $folder = null) {
	$folder = $folder ? $folder : $_GET['sub'];
	$fullpath = 'components/modules/'.$_GET['sub'].'/'.$path;
	return $fullpath;
}

function m_echoInTemplate($string) {
	global $m_echo_string;
	$m_echo_string .= $string;
}

function m_echoInTemplateNow() {
	global $m_echo_string;
	echo $m_echo_string;
}

function m_echoArrayInTemplate($array) {
	$arrayview = str_replace("\n","<br>",print_r($array, 1));
	$arrayview = str_replace("  ","&nbsp",$arrayview);

	m_echoInTemplate($arrayview);
}

function m_echoDebugArrayInTemplate($array, $arrayname = null) {
        $arrayview = str_replace("\n","<br>",var_export($array, 1));
	$arrayview = str_replace("  ","&nbsp&nbsp ",$arrayview);
        //$arrayview = str_replace("\t","&nbsp",$arrayview);
        
        $arrayview .= "<br>";
        if($arrayname) {
            $arrayview = $arrayname . ' = ' . $arrayview;
        }
	m_echoInTemplate($arrayview);
}
?>
