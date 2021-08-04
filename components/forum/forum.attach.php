<?php
if(INCLUDED!==true)exit;
$_GET['nobody'] = 1;

if($user['g_use_attach']==1){  
    $all_attachs_size = 0;
    $all_attachs_count = 0;
    $attachs = array();
    $user_attach_dir = (string)$MW->getConfig->generic->attachs_path.$user['id'].'/';
    if(!file_exists($user_attach_dir))mkdir($user_attach_dir);
    
    $attachs = $DB->select("SELECT * FROM f_attachs WHERE attach_member_id=?d ORDER BY attach_date DESC",$user['id']);
    foreach($attachs as $i=>$attach){
        $attachs[$i]['ext'] = strtolower(substr(strrchr($attach['attach_file'],'.'), 1));
        $attachs[$i]['goodsize'] = return_good_size($attach['attach_filesize']);
        $all_attachs_size += $attach['attach_filesize'];
        $all_attachs_count++;
    }
    
    if($all_attachs_size <= (int)$MW->getConfig->generic->max_attachs_size)$this['allowupload'] = true;else $this['allowupload'] = false;
    $this['goodsize'] = return_good_size($all_attachs_size);
    $this['maxfilesize'] = return_good_size((int)$MW->getConfig->generic->max_attachs_size-$all_attachs_size);
    
    if($_GET['action']=='upload' && $this['allowupload']===true){
        $params = array();
        $tmpattach = $_FILES['attach'];
        $allowed_ext = explode('|',(string)$MW->getConfig->generic->allowed_attachs);
        if(is_uploaded_file($tmpattach['tmp_name'])){
            if($tmpattach['size'] <= (int)$MW->getConfig->generic->max_attachs_size-$all_attachs_size){
                $ext = strtolower(substr(strrchr($tmpattach['name'],'.'), 1));
                if(in_array($ext,$allowed_ext)){
                    if(@move_uploaded_file($tmpattach['tmp_name'], $user_attach_dir.$tmpattach['name'])){
                        $params['attach_file'] = $tmpattach['name'];
                        $params['attach_location'] = $user_attach_dir;
                        $params['attach_date'] = time();
                        if($_GET['tid'])$params['attach_tid'] = $_GET['tid'];
                        $params['attach_member_id'] = $user['id'];
                        $params['attach_filesize'] = $tmpattach['size'];
                        $DB->query("INSERT INTO f_attachs SET ?a",$params);
                        redirect($MW->getConfig->temp->base_href.'index.php?n=forum&sub=attach&tid='.$_GET['tid'],1);
                    }
                }
            }
        }
    }elseif($_GET['action']=='download' && $_GET['attid']){
        $thisattach = $DB->selectRow("SELECT * FROM f_attachs WHERE attach_id=?d",$_GET['attid']);
        if($thisattach['attach_id'])$DB->query("UPDATE f_attachs SET attach_hits=attach_hits+1 WHERE attach_id=?d",$thisattach['attach_id']);
        redirect($thisattach['attach_location'].$thisattach['attach_file'],1);
    }elseif($_GET['action']=='delete' && $_GET['attid']){
        $thisattach = $DB->selectRow("SELECT * FROM f_attachs WHERE attach_id=?d",$_GET['attid']);
        if($user['id']==$thisattach['attach_member_id'] && $thisattach['attach_id']){
            @unlink($thisattach['attach_location'].$thisattach['attach_file']);
            $DB->query("DELETE FROM f_attachs WHERE attach_id=?d LIMIT 1",$thisattach['attach_id']);
        }
        redirect($MW->getConfig->temp->base_href.'index.php?n=forum&sub=attach&tid='.$_GET['tid'],1);
    }
}
?>