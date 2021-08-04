<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>'Character Transfer', 'link'=>'index.php?n=admin&sub=chartransfer');
// ==================== //
?>
<?php
include "chartools/charconfig.php";
include "chartools/add.php";
include "chartools/functionstransfer.php";
include "chartools/functionsrename.php";
include "chartools/tabs.php";
?>