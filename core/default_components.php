<?php

$mainnav_links = array (
  '1-menuNews' => 
  array (
    0 => 
    array (
      0 => 'forum_news',
      1 => 'index.php',
      2 => '',
    ),
    1 => 
    array (
      0 => 'forum_archive',
      1 => 'index.php?n=forum&sub=viewforum&fid=1',
      2 => '',
    ),
  ),
  '2-menuAccount' => 
  array (
    0 => 
    array (
      0 => 'account_manage',
      1 => mw_url('account', 'manage'),
      2 => 'g_is_supadmin',
    ),
    1 => 
    array (
      0 => 'personal_messages',
      1 => mw_url('account', 'pms'),
      2 => 'g_view_profile',
    ),
    2 => 
    array (
      0 => 'account_create',
      1 => mw_url('account', 'register'),
      2 => '!g_view_profile',
    ),
    3 => 
    array (
      0 => 'retrieve_pass',
      1 => mw_url('account', 'restore'),
      2 => '!g_view_profile',
    ),
    4 => 
    array (
      0 => 'account_activate',
      1 => mw_url('account', 'activate'),
      2 => '!g_view_profile',
    ),
    5 =>
    array (
      0 => 'charcreate',
      1 => mw_url('account', 'charcreate'),
      2 => '',
    ),
	6 => 
    array (
      0 => 'char_manage',
      1 => mw_url('account', 'chartools'),
      2 => '',    
    ),
    7 => 
    array (
      0 => 'userlist',
      1 => mw_url('account', 'userlist'),
      2 => 'g_is_admin',
    ),
    8 => 
    array (
      0 => 'rules',
      1 => mw_url('server', 'rules'),
      2 => 'g_is_admin',
    ),
	9 => 
    array (
      0 => 'admin_panel',
      1 => 'index.php?n=admin',
      2 => 'g_is_supadmin',
    ),
  ),
  '3-menuGameGuide' => 
  array (
    0 => 
    array (
      0 => 'howtoplay',
      1 => mw_url('gameguide', 'connect'),
      2 => '',
    ),
	3 =>
    array (
      0 => 'bc',
      1 => 'http://www.worldofwarcraft.com/burningcrusade/',
      2 => '',
    ),
    4 => 
    array (
      0 => 'wrath',
      1 => 'http://www.worldofwarcraft.com/wrath/',
      2 => '',
    ),
    5 => 
    array (
      0 => 'cata',
      1 => 'http://www.worldofwarcraft.com/cataclysm/',
      2 => '',
    ),
  ),
  '4-menuInteractive' => 
  array (
    0 => 
    array (
      0 => 'realms_status',
      1 => mw_url('server', 'realmstatus'),
      2 => '',
    ),
    1 => 
    array (
      0 => 'honor',
      1 => 'armory/index.php?searchType=honor', //mw_url('server', 'honor'),
      2 => '',
    ),
    2 => 
    array (
      0 => 'players_online',
      1 => mw_url('server', 'playersonline'),
      2 => '',
    ),
    3 => 
    array (
      0 => 'chars',
      1 => mw_url('server', 'chars'),
      2 => '',
    ),
    4 => 
    array (
      0 => 'playermap',
      1 => mw_url('server', 'playermap'),
      2 => '',
    ),
    5 => 
    array (
      0 => 'statistic',
      1 => mw_url('server', 'statistic'),
      2 => '',    
    ),
    6 =>
    array (
      0 => 'module_ah',
      1 => mw_url('server', 'ah'),
      2 => '',
    ),
    7 =>
    array (
      0 => 'armory',
      1 => './armory/',
      2 => '',
    ),
    8 =>
    array (
      0 => 'flashmap',
      1 => './components/tools/maps/flashmap/',
      2 => '',
    ),
    9 =>
    array (
      0 => 'armorsets',
      1 => 'index.php?n=server&sub=armorsets',
      2 => '',
    ),
  ),
  '5-menuMedia' => 
  array (
    0 => 
    array (
      0 => 'wallp',
      1 => mw_url('media', 'wallp'),
      2 => '',
    ),
    1 =>
    array (
      0 => 'screen',
      1 => mw_url('media', 'screen'),
      2 => '',
    ),
    2 =>
    array (
      0 => 'UScreen',
      1 => mw_url('media', 'addgalscreen'),
      2 => 'g_view_profile',
    ),
    3 =>
    array (
      0 => 'UWallp',
      1 => mw_url('media', 'addgalwallp'),
      2 => 'g_view_profile',
    ),
  ),
  '6-menuForums' => 
  array (
    0 => 
    array (
      0 => 'spp_forum',
      1 => 'index.php?n=forum',
      2 => '',
    ),
	/*1 =>
    array (
      0 => 'forum_general',
      1 => 'index.php?n=forum&sub=viewforum&fid=7',
      2 => '',
    ),
	2 => 
    array (
      0 => 'forum_help',
      1 => 'index.php?n=forum&sub=viewforum&fid=10',
      2 => '',
    ),*/
  ),
'7-menuCommunity' =>
  array ( 
	0 => 
    array (
      0 => 'teamspeak',
      1 => mw_url('community', 'teamspeak'),
      2 => '',
   ),
	1 =>
    array (
      0 => 'donate',
      1 => mw_url('community', 'donate'),
      2 => '',
   ),
   array (
      0 => 'vote',
      1 => mw_url('community', 'vote'),
      2 => '',
   ),
   array (
      0 => 'chat',
      1 => mw_url('community', 'chat'),
      2 => '',
   ),
      array (
          0 => 'spp_discord',
          1 => 'https://discord.gg/TpxqWWT',
          2 => '',
      ),
      array (
          0 => 'bots_discord',
          1 => 'https://discord.gg/s4JGKG2BUW',
          2 => '',
      ),
  ),	 	   

  '8-menuSupport' => 
  array (
    0 =>
    array (
      0 => 'commands',
      1 => mw_url('server', 'commands'),
      2 => '',
    ),
    1 => 
    array (
      0 => 'bugs',
      1 => 'index.php?n=forum&sub=viewforum&fid=2',
      2 => '',
    ),
    2 => 
    array (
      0 => 'gmlist',
      1 => mw_url('server', 'gms'),
      2 => '',
    ),
    3 => 
	array (
      0 => 'gm_online',
      1 => mw_url('server', 'gmonline'),
      2 => '',
    ),
  ),
);

$allowed_ext = array (
  0 => 'account',
  1 => 'admin',
  2 => 'ajax',
  3 => 'forum',
  4 => 'frontpage',
  5 => 'html',
  6 => 'server',
  7 => 'whoisonline',
  8 => 'community',
  9 => 'media',
  10 => 'armory',
  11 => 'gameguide',
);

// Main Forum Navigation Link
if ((int)$MW->getConfig->generic_values->forum->frame_forum || (int)$MW->getConfig->generic_values->forum->externalforum){
    $mainnav_links['6-menuForums'][0][1] = (string)$MW->getConfig->generic_values->forum->forum_external_link;
}

//Bugs Tracker Navigation Link
$mainnav_links['8-menuSupport'][1][1] = mw_url('forum', 'viewforum', array('fid'=>(int)$MW->getConfig->generic_values->forum->bugs_forum_id));
if ((int)$MW->getConfig->generic_values->forum->frame_bugstracker || (int)$MW->getConfig->generic_values->forum->externalbugstracker == 0)
{
}
else
{
    $mainnav_links['8-menuSupport'][1][1] = (string)$MW->getConfig->generic_values->forum->bugstracker_external_link;
}


/*Media*/
if ((int)$MW->getConfig->components->left_section->Screenshots==0)
{
	unset($mainnav_links['5-menuMedia'][1]);
}
if ((int)$MW->getConfig->components->left_section->Wallpapers==0)
{
	unset($mainnav_links['5-menuMedia'][0]);
}
if ((int)$MW->getConfig->components->left_section->Upload_Screenshot==0)
{
	unset($mainnav_links['5-menuMedia'][2]);
}
if ((int)$MW->getConfig->components->left_section->Upload_Wallpaper==0)
{
	unset($mainnav_links['5-menuMedia'][3]);
}

/*Community*/
if ((int)$MW->getConfig->components->left_section->Teamspeak==0)
{
    unset($mainnav_links['7-menuCommunity'][0]);
}
if ((int)$MW->getConfig->components->left_section->donate==0)
{
    unset($mainnav_links['7-menuCommunity'][1]);
}
if ((int)$MW->getConfig->components->left_section->vote==0)
{
    unset($mainnav_links['7-menuCommunity'][2]);
}
if ((int)$MW->getConfig->components->left_section->chat==0)
{
    unset($mainnav_links['7-menuCommunity'][3]);
}


/*Workshop*/
if ((int)$MW->getConfig->components->left_section->Realms_status==0)
{
    unset($mainnav_links['4-menuInteractive'][0]);
}
if ((int)$MW->getConfig->components->left_section->Honor==0)
{
    unset($mainnav_links['4-menuInteractive'][1]);
}
if ((int)$MW->getConfig->components->left_section->Players_online==0)
{
    unset($mainnav_links['4-menuInteractive'][2]);
}
if ((int)$MW->getConfig->components->left_section->Characters==0)
{
    unset($mainnav_links['4-menuInteractive'][3]);
}
if ((int)$MW->getConfig->components->left_section->Playermap==0)
{
    unset($mainnav_links['4-menuInteractive'][4]);
}

if ((int)$MW->getConfig->components->left_section->Statistic==0)
{
    unset($mainnav_links['4-menuInteractive'][5]);
}

if ((int)$MW->getConfig->components->left_section->ah_system==0)
{
    unset($mainnav_links['4-menuInteractive'][6]);
}

if ((int)$MW->getConfig->components->left_section->Armory==0)
{
    unset($mainnav_links['4-menuInteractive'][7]);
}
if ((int)$MW->getConfig->components->left_section->Interactive_world_atlas==0)
{
    unset($mainnav_links['4-menuInteractive'][8]);
}
if ((int)$MW->getConfig->components->left_section->Armor_sets==0)
{
    unset($mainnav_links['4-menuInteractive'][9]);
}

/*Support*/
if ((int)$MW->getConfig->components->left_section->Commands==0)
{
    unset($mainnav_links['8-menuSupport'][0]);
}
if ((int)$MW->getConfig->components->left_section->Bug_tracker==0)
{
    unset($mainnav_links['8-menuSupport'][1]);
}
if ((int)$MW->getConfig->components->left_section->In_Game_Support==0)
{
    unset($mainnav_links['8-menuSupport'][2]);
}
if ((int)$MW->getConfig->components->left_section->Online_GMs==0)
{
    unset($mainnav_links['8-menuSupport'][3]);
}
/*Game Guide*/
if ((int)$MW->getConfig->components->left_section->wow_bc==0)
{
    unset($mainnav_links['3-menuGameGuide'][3]);
}
if ((int)$MW->getConfig->components->left_section->wow_wrath==0)
{
    unset($mainnav_links['3-menuGameGuide'][4]);
}
if ((int)$MW->getConfig->components->left_section->wow_cata==0)
{
    unset($mainnav_links['3-menuGameGuide'][5]);
}
/*Account*/
if ((int)$MW->getConfig->components->left_section->retrieve_pass==0)
{
    unset($mainnav_links['2-menuAccount'][3]);
}
if ((int)$MW->getConfig->components->left_section->Activate_account==0)
{
    unset($mainnav_links['2-menuAccount'][4]);
}
if ((int)$MW->getConfig->components->left_section->Character_copy==0)
{
    unset($mainnav_links['2-menuAccount'][5]);
}
if ((int)$MW->getConfig->components->left_section->Character_tools==0)
{
    unset($mainnav_links['2-menuAccount'][6]);
}

?>
