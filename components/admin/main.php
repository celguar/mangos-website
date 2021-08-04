<?php

$fa = "index.php?n=forum&sub=post&action=newtopic&f=".(int)$MW->getConfig->generic_values->forum->news_forum_id;
$fn = "index.php?n=forum&sub=viewforum&fid=".(int)$MW->getConfig->generic_values->forum->news_forum_id;
if (!isset($commands_forum_id))$commands_forum_id='';
$fc = "index.php?n=forum&sub=viewforum&fid=".$commands_forum_id;

$com_content['admin'] = array(
    'index' => array(
        'g_is_admin', // g_ option require for view     [0]
        'admin_panel', // loc name (key)                [1]
        'index.php?n=admin', // Link to                 [2]
        '', // main menu name/id ('' - not show)        [3]
        0 // show in context menu (1-yes,0-no)          [4]
    ),
    'members' => array(
        'g_is_supadmin', 
        'users_manage', 
        'index.php?n=admin&sub=members',
        '',
        1
    ),
    'config' => array(
        'g_is_supadmin', 
        'site_config', 
        'index.php?n=admin&sub=config',
        '',
        1
    ),
    'realms' => array(
        'g_is_supadmin', 
        'realms_manage', 
        'index.php?n=admin&sub=realms',
        '',
        1
    ),
    'forum' => array(
        'g_is_admin', 
        'forums_manage', 
        'index.php?n=admin&sub=forum',
        '',
        1
    ),
    'keys' => array(
        'g_is_admin', 
        'regkeys_manage', 
        'index.php?n=admin&sub=keys',
        '',
        1
    ),
    'langs' => array(
        'g_is_admin', 
        'langs_manage', 
        'index.php?n=admin&sub=langs',
        '',
        1
    ),
     'news_add' => array(
        'g_is_admin', 
        'news_add', 
        $fa,
        '',
        1
    ),
    'news' => array(
        'g_is_admin', 
        'news_manage', 
        $fn,
        '',
        1
    ),
    'commands' => array(
        'g_is_admin', 
        'commands_manage', 
        $fc,
        '',
        1
    ),
    'chat' => array(
        'g_is_admin', 
        'chat_manage', 
        'index.php?n=admin&sub=chat',
        '',
        0
    ),
    'donate' => array(
        'g_is_admin',
        'donate',
        'index.php?n=admin&sub=donate',
        '',
        1
    ),
    'backup' => array(
        'g_is_admin',
        'backup',
        'index.php?n=admin&sub=backup',
        '',
        1
    ),
    'viewlogs' => array(
        'g_is_admin',
        'viewlogs',
        'index.php?n=admin&sub=viewlogs',
        '',
        0
    ),
    'chartools' => array(
        'g_is_admin',
        'chartransfer',
        'index.php?n=admin&sub=chartools',
        '',
        0
    ),
	'tickets' => array(
        'g_is_admin',
        'tickets',
        'index.php?n=admin&sub=tickets',
        '',
        0
    ),
		'chartransfer' => array(
        'g_is_admin',
        'chartransfer',
        'index.php?n=admin&sub=chartransfer',
        '',
        0
    ),
		'vote' => array(
        'g_is_admin',
        'vote',
        'index.php?n=admin&sub=vote',
        '',
        0
    ),
	'updatefields' => array(
        'g_is_admin',
        'updatefields',
        'index.php?n=admin&sub=updatefields',
        '',
        0
    ),
);
?>
