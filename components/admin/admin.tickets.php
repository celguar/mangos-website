<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>'GM Ticket Manager', 'link'=>'index.php?n=admin&sub=tickets');
// ==================== //
?>

<?php
$MANG = new Mangos;
$query = array();
$realm_info_new = get_realm_byid($user['cur_selected_realmd']);
 
$cc = 0;
if(!check_port_status($realm_info_new['address'], $realm_info_new['port'])===true)
{
    output_message('alert','Realm <b>'.$realm_info_new['name'].'</b> is offline <img src="images/downarrow2.gif" border="0" align="top">');
}

$action = array();

$action = $CHDB->select("SELECT `ticket_id`, `guid`, `ticket_text`, `response_text`, `ticket_lastchange` FROM `character_ticket` ORDER BY `ticket_id` ");
$ticket = array();
$cc1 = 0;
$result1 = array();
if (count($action) > 0){
foreach ($action as $result1) {
	    if($color==1) {
      $color=2;
    }
    else
      $color=1;
    $cc1++;

	$ticket[$cc1]["id"] = $cc1;
	$ticket[$cc1]["ticket_id"] = $result1['ticket_id'];
	$ticket[$cc1]["player_id"] = $result1['guid'];
	$ticket[$cc1]["message"] = $result1['ticket_text'];
	$ticket[$cc1]["response"] = $result1['response_text'];
	$ticket[$cc1]["stamp"] = $result1['ticket_lastchange'];
	$ticket[$cc1]["color"] = $color;
	}
}
unset($action, $result1);
?>