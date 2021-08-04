<?php
$com_content['community'] = array(
    'index' => array(
        '', // g_ option require for view     [0]
        'community', // loc name (key)                [1] 
        'index.php?n=community', // Link to                 [2]
        '', // main menu name/id ('' - not show)        [3]
        0 // show in context menu (1-yes,0-no)          [4]
    ),

    'teamspeak' => array(
        '', 
        'teamspeak', 
        'index.php?n=community&sub=teamspeak',
        '7-menuCommunity',
        0
    ),
    'donate' => array(
        '',
        'donate',
        'index.php?n=community&sub=donate',
        '7-menuCommunity',
        0
    ),
	'chat' => array(
        '', 
        'chat', 
        'index.php?n=community&sub=chat',
        '7-menuCommunity',
        0
    ),
	'vote' => array(
        '',
        'vote',
        'index.php?n=community&sub=vote',
        '7-menuCommunity',
        0
    ),
	'login' => array(
        '',
        'login',
        'index.php?n=community&sub=login',
        '7-menuCommunity',
        0
    ),
	'vote_sites' => array(
        '',
        'vote_sites',
        'index.php?n=community&sub=vote?sites',
        '7-menuCommunity',
        0
    ),
);
?>
