<?php
$com_content['forum'] = array(
    'index' => array(
        '', // g_ option require for view     [0]
        'forums', // loc name (key)                [1]
        'index.php?n=forum', // Link to                 [2]
        '6-menuForums', // main menu name/id ('' - not show)        [3]
        0 // show in context menu (1-yes,0-no)          [4]
    ),
    'post' => array(
        '', 
        'post', 
        'index.php?n=forum&sub=post',
        '',
        0
    ),
    'viewforum' => array(
        '', 
        'viewforum', 
        'index.php?n=forum&sub=viewforum',
        '',
        0
    ),
    'viewtopic' => array(
        '', 
        'viewtopic', 
        'index.php?n=forum&sub=viewtopic',
        '',
        1
    ),
    'attach' => array(
        '', 
        'attachs', 
        'index.php?n=forum&sub=attach',
        '',
        0
    )
);
?>