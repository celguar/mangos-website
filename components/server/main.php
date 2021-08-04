<?php
$com_content['server'] = array(
    'index' => array(
        '', // g_ option require for view     [0]
        'server', // loc name (key)                [1]
        'index.php?n=server', // Link to                 [2]
        '', // main menu name/id ('' - not show)        [3]
        0 // show in context menu (1-yes,0-no)          [4]
    ),
    'commands' => array(
        '', 
        'Availaible Commands(InGame)', 
        mw_url('server', 'commands'),
        '8-menuSupport',
        0
    ),
	'gmonline' => array(
        '', 
        'gm_online', 
        mw_url('server', 'gmonline'),
        '8-menuSupport',
        0
    ),
    'chars' => array(
        '', 
        'Characters on the server', 
        mw_url('server', 'chars'),
        '4-menuInteractive',
        0
    ),
    'realmstatus' => array(
        '', 
        'realms_status', 
        mw_url('server', 'realmstatus'),
        '4-menuInteractive',
        0
    ),
    'honor' => array(
        '', 
        'honor', 
        mw_url('server', 'honor'),
        '4-menuInteractive',
        0
    ),
    'playersonline' => array(
        '', 
        'players_online', 
        mw_url('server', 'playersonline'),
        '4-menuInteractive',
        0
    ),
    'bugtracker' => array(
        '', 
        'bugs', 
        mw_url('server', 'bugtracker'),
        '4-menuInteractive',
        0
    ),
    'playermap' => array(
        '', 
        'Player Map', 
        mw_url('server', 'playermap'),
        '4-menuInteractive',
        0
    ),
    'talents' => array(
        '', 
        'Talents', 
        mw_url('server', 'talents'),
        '4-menuInteractive',
        0
    ),
    'gms' => array(
        '', 
        'gmlist', 
        mw_url('server', 'gms'),
        '8-menuSupport',
        0
    ),
    'statistic' => array(
        '', 
        'statistic', 
        mw_url('server', 'statistic'),
        '4-menuInteractive',
        0
    ),
    'howtoplay' => array(
        '', 
        'howtoplay', 
        mw_url('server', 'howtoplay'),
        '3-menuGameGuide',
        0
    ),
    'ah' => array(
        '',
        'ah',
        mw_url('server', 'ah'),
        '4-menuGameGuide',
        0
    ),
    'info' => array(
        '',
        'info',
        mw_url('server', 'info'),
        '4-menuGameGuide',
        0
    ),
    'armorsets' => array(
        '', 
        'armorsets', 
        mw_url('server', 'armorsets'),
        '4-menuGameGuide',
        0
    ),
    'rules' => array(
        '', 
        'rules', 
        mw_url('server', 'rules'),
        '4-menuGameGuide',
        0
    ),
);
?>
