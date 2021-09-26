<?php
$com_content['gameguide'] = array(
    'index' => array(
        '', // g_ option require for view     [0]
        'game_guide', // loc name (key)                [1]
        'index.php?n=gameguide', // Link to                 [2]
        '', // main menu name/id ('' - not show)        [3]
        0 // show in context menu (1-yes,0-no)          [4]
    ),
    'connect' => array(
        '', 
        'howtoplay', 
        mw_url('gameguide', 'connect'),
        '3-menuGameGuide',
        0
    ),
);
?>
