<?php
$com_content['account'] = array(
    'index' => array(
        '', // g_ option require for view 
        'account', // loc name
        'index.php?n=account', // Link to
        '', // main menu name/id ('' - not show)
        0 // show in context menu (1-yes,0-no)
    ),
    'pms' => array(
        'g_use_pm', 
        'personal_messages', 
        'index.php?n=account&sub=pms',
        '',
        1
    ),
    'manage' => array(
        '', 
        'account_manage', 
        'index.php?n=account&sub=manage',
        '2-menuAccount',
        0
    ),
    'view' => array(
        'g_view_profile', 
        '', 
        'index.php?n=account&sub=view',
        '',
        0
    ),
    'register' => array(
        '', 
        'account_create', 
        'index.php?n=account&sub=register',
        '2-menuAccount',
        0
    ),
    'activate' => array(
        '', 
        'activation', 
        'index.php?n=account&sub=activate',
        '2-menuAccount',
        0
    ),
    'restore' => array(
        '', 
        'retrieve_pass', 
        'index.php?n=account&sub=restore',
        '2-menuAccount',
        0
    ),
    'userlist' => array(
        '',
        'userlist',
        'index.php?n=account&sub=userlist',
        '4-menuInteractive',
        0
    ),
    'login' => array(
        '', 
        'login', 
        'index.php?n=account&sub=login',
        '',
        0
    ),
	'chartools' => array(
        '', 
        'chartools', 
        'index.php?n=account&sub=chartools',
        '',
        0
    ),
    'charcreate' => array(
        '',
        'charcreate',
        'index.php?n=account&sub=charcreate',
        '',
        0
    )
);
?>
