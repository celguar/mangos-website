<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>$lang['teamspeak'],'link'=>'');

// Load the Teamspeak Display:
require(dirname(__FILE__)."/teamspeakdisplay/teamspeakdisplay.php");

// Get the settings
$settings = $teamspeakDisplay->getDefaultSettings();
$settings["serveraddress"] = (string)$MW->getConfig->generic->ts_ip;
$settings["serverudpport"] = (int)$MW->getConfig->generic->ts_port_udp;
$settings["echoresult"] = false;

// Get the display
$display = $teamspeakDisplay->displayTeamspeakEx($settings);
$display = str_replace("teamspeakdisplay/", "components/community/teamspeakdisplay/", $display);
$display = utf8_encode($display);
?>