<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>'GM Logs', 'link'=>'index.php?n=admin&sub=viewlogs');
// ==================== //
?>

<?php
if ((int)$MW->getConfig->core_work->enable = 0){
    die("\XML core_work->enable is not set to 1, remember that mangos host needs to be on the same machine as the website.");
}
else{ $showform = true;
}

if ($_GET['accountid']){
    $showform = true;
    $mangos_core_logs = new mangoslogsparse($DB, $_GET['accountid'], $MW->getConfig->core_work);
}else{
    $showform = false;
}

class mangoslogsparse{
    var $username=false;
    var $mangos_core_work_config=false;
    var $db = false;
    var $uid = false;

    function mangoslogsparse(&$DB, &$user, &$mangos_core_work_config){
        $this->username = & $user;
        $this->db = & $DB;
        $this->mangos_core_work_config = & $mangos_core_work_config;
        
        $this->username_to_id();
    }
    
    function username_to_id(){
        $this->uid = $this->db->selectCell("SELECT id FROM `account` WHERE username='".$this->username."'");
    }
    
    function parse_gmlog(){
        $file = file($this->mangos_core_work_config->path->gmlog);
        $output = '<ul>';
        foreach($file as $data){

            // My preg_replace skills is _NOT_ good. Someone manage to kill all the explodes ?
            // Example from gm.log, we must parse.
            //2008-02-03 14:34:16 Command: additem  |cffffffff|Hitem:3661:0:0:0:0:0:0:0|h[Handcrafted Staff]|h|r [Player: Druids (Account: 1) X: -9150.110352 Y: 326.182007 Z: 89.890800 Map: 0 Selected: none (GUID: 0)]
            $exp = explode(' ', $data);
            $exp_aid = explode("(", $data);
            $exp_aid = explode(")", $exp_aid[1]);
            $exp_aid = explode(" ", $exp_aid[0]);
            $user_id = (int)$exp_aid[1];
            //echo $user_id."<br /><br />";
            if ($user_id == $this->uid){
                $output .= "<li>".$data."</li>";
            }
        }
        $output .= "</ul>";
        return $output;
    }
    
}


?>
