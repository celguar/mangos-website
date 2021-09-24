<?php
$realmd = array(
'db_type'         => 'mysql',
'db_host'         => '127.0.0.1',
'db_port'         => '3310',
'db_username'     => 'root',
'db_password'     => '123456',
'db_name'         => 'classicrealmd',
'db_encoding'     => 'utf8',
);
if (file_exists("tbc.spp"))
    $realmd["db_name"] = 'tbcrealmd';
if (file_exists("wotlk.spp"))
    $realmd["db_name"] = 'wotlkrealmd';
?>