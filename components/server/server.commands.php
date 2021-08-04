<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>$lang['commands'],'link'=>'');
$items_per_page = 20;	// Output items limit
$defaultOpen    =  0;	// First N items that are "opened" by default.
$hl             = '';   // High lighted item
$startpage      = (isset($_GET['sp']) ? quote_smart($_GET['sp']) : 1 );
$userlevel = ($user['gmlevel'] != '' ? $user['gmlevel'] : 0);


if($WSDB) {
	$maxtopics  = $WSDB->selectCell("
		SELECT COUNT(*)
		FROM command
		WHERE security <= $userlevel");

	$maxpages   = round($maxtopics / $items_per_page);
	if ( ($maxpages * $items_per_page) < $maxtopics ) {
		$maxpages   += 1;
	}
	if ($startpage < 1) {
		$startpage   = 1;
	}
	if ($startpage > $maxpages) {
		$startpage   = $maxpages;
	}
	$sp   = ($startpage * $items_per_page ) - $items_per_page;
	$alltopics = $WSDB->select("
	    SELECT *
	    FROM command
	    WHERE security <= $userlevel
	    ORDER BY `security` ASC, `name` ASC
	    LIMIT $sp , $items_per_page");
}

?>
