<?php
if(INCLUDED!==true)exit;

$content = $DB->selectRow("SELECT * FROM f_posts WHERE post_id=?d",$_REQUEST['postid']);
echo '[blockquote="'.$content['poster'].' | '.date('d-m-Y, H:i:s',$content['posted']).'"] '.my_previewreverse($content['message']).'[/blockquote]';

?>