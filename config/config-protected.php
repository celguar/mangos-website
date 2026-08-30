<?php
$realmd = array(
'db_type'         => 'mysql',
'db_host'         => getenv('DB_HOST'),
'db_port'         => getenv('DB_PORT'),
'db_username'     => getenv('DB_USERNAME'),
'db_password'     => getenv('DB_PASSWORD'),
'db_name'         => getenv('DB_NAME'),
'db_encoding'     => getenv('DB_ENCODING'),
);
if (file_exists("tbc.spp"))
    $realmd["db_name"] = 'tbcrealmd';
if (file_exists("wotlk.spp"))
    $realmd["db_name"] = 'wotlkrealmd';
?>
