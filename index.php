<?php

/****************************************************************************/
/*    < MangosWeb is a Web-Fonted for Mangos (mangosproject.org) >          */
/*    Copyright (C) <2007>  <Sasha,TGM,Peec,Nafe>                           */
/*																			*/
/*		MangosWeb Enhanced made by <Wilson212,Ionstorm66> <2009-2010>		*/
/*				   < http://code.google.com/p/mwenhanced/ >					*/	
/*                                                                          */
/*    This program is free software: you can redistribute it and/or modify  */
/*    it under the terms of the GNU General Public License as published by  */
/*    the Free Software Foundation, either version 2 of the License, or     */
/*    (at your option) any later version.                                   */
/*                                                                          */
/*    This program is distributed in the hope that it will be useful,       */
/*    but WITHOUT ANY WARRANTY; without even the implied warranty of        */
/*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         */
/*    GNU General Public License for more details.                          */
/*                                                                          */
/*    You should have received a copy of the GNU General Public License     */
/*    along with this program.  If not, see <http://www.gnu.org/licenses/>. */
/*                                                                          */
/*                                $Rev$                                     */
/****************************************************************************/

// Current Revision
$rev = "56";
session_start();

// Set error reporting to only a few things.
ini_set('error_reporting', E_ERROR ^ E_NOTICE ^ E_WARNING);
error_reporting( E_ERROR | E_PARSE | E_WARNING ) ;
ini_set('log_errors',TRUE);
ini_set('html_errors',FALSE);
//ini_set('error_log','core/logs/error_log.txt');
ini_set( 'display_errors', '0' ) ;
// Define INCLUDED so that we can check other pages if they are included by this file
define( 'INCLUDED', true ) ;

// Start a variable that shows how fast page loaded.
$time_start = microtime( 1 ) ;
$_SERVER['REQUEST_TIME'] = time() ;

// Initialize config's.
include ( 'core/class.mangosweb.php' ) ;
$MW = new mangosweb ; // Super global.

// Site functions & classes ...
include ( 'core/common.php' ) ;
include ( 'core/mangos.class.php' ) ;
include ( 'core/class.auth.php' ) ;
require_once ( 'core/dbsimple/Generic.php' ) ;
require ( 'core/class.captcha.php' ) ;
include ( 'core/cache_class/safeIO.php' ) ;
include ( 'core/cache_class/gCache.php' ) ;


//Site notice cookie
if ( file_exists( "ToS.html" ) && ! isset( $_COOKIE['agreement_accepted'] ) )
{
	include ( 'notice.php' ) ;
	exit() ;
}


// Inizialize difrent variables.
global $MW, $mangos ;
// Super-Global variables.
$GLOBALS['users_online'] = array() ;
$GLOBALS['guests_online'] = 0 ;
$GLOBALS['messages'] = '' ;
$GLOBALS['redirect'] = '' ;
$GLOBALS['sidebarmessages'] = '' ;
$GLOBALS['context_menu'] = array() ;
$GLOBALS['user_cur_lang'] = ( string )$MW->getConfig->generic->default_lang ;

// Inzizalize Cache class
$cache = new gCache ;
$cache->folder = './core/cache/sites' ;
$cache->timeout = $MW->getConfig->generic->cache_expiretime ;

// Assign a connect variable to class call.
// DB layer documentation at http://en.dklab.ru/lib/DbSimple/
$DB = dbsimple_Generic::connect( "" . $MW->getDbInfo['db_type'] . "://" . $MW->getDbInfo['db_username'] .
	":" . $MW->getDbInfo['db_password'] . "@" . $MW->getDbInfo['db_host'] . ":" . $MW->getDbInfo['db_port'] .
	"/" . $MW->getDbInfo['db_name'] . "" ) ;
// Set error handler for $DB.
$DB->setErrorHandler( 'databaseErrorHandler' ) ;
// Also set to default encoding for $DB
$DB->query( "SET NAMES " . $MW->getDbInfo['db_encoding'] ) ;

// Play arround for IIS lake on $_SERVER['REQUEST_URI']
if ( $_SERVER['REQUEST_URI'] == "" )
{
	if ( $_SERVER['QUERY_STRING'] != "" )
	{
		$__SERVER['REQUEST_URI'] = $_SERVER["SCRIPT_NAME"] . "?" . $_SERVER['QUERY_STRING'] ;
	} else
	{
		$__SERVER['REQUEST_URI'] = $_SERVER["SCRIPT_NAME"] ;
	}
} else
{
	$__SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ;
}


// Build path vars //
$MW->add_temp_confs( array( 'site_href' => str_replace( '//', '/', str_replace( '\\',
	'/', dirname( $_SERVER['SCRIPT_NAME'] ) . '/' ) ) ) ) ;
$MW->add_temp_confs( array( 'site_domain' => $_SERVER['HTTP_HOST'], 'email_href' =>
	$_SERVER['HTTP_HOST'] ) ) ;
$MW->add_temp_confs( array( 'base_href' => 'http://' . $MW->getConfig->temp->email_href .
	'' . $MW->getConfig->temp->site_href, ) ) ;


// Check lang ======================================
if ( isset( $_COOKIE['Language'] ) )
	$GLOBALS['user_cur_lang'] = $_COOKIE['Language'] ;
loadLanguages() ;
// ================================================

// Load auth system //
$auth = new AUTH( $DB, $MW->getConfig ) ;
$user = $auth->user ;
// ================== //

//Determine Current Template
if ( $user['id'] == -1 )
{
	$currtmp = "templates/".( string ) $MW->getConfig->generic->default_template ;
} else
{
	$currtmp = $DB->selectCell( "SELECT theme FROM `website_accounts` WHERE account_id=?d",
		$user['id'] ) ;
	foreach ( $MW->getConfig->templates->template as $template )
	{
		$currtmp2[] = $template ;
	}
	$currtmp = "templates/" . $currtmp2[$currtmp] ;
}

// Load Permissions and aviable sites.
include ( 'core/default_components.php' ) ;

// Start of context menu. ( Only make an array for later output )
$GLOBALS['context_menu'][] = array( 'title' => $lang['mainpage'], 'link' =>
	'index.php' ) ;

if ( $user['id'] <= 0 )
{
	$GLOBALS['context_menu'][] = array( 'title' => $lang['register'], 'link' =>
		mw_url( 'account', 'register' ) ) ;
}
$GLOBALS['context_menu'][] = array( 'title' => 'Forum', 'link' =>
	'index.php?n=forum' ) ;
$GLOBALS['context_menu'][] = array( 'title' => $lang['players_online'], 'link' =>
	mw_url( 'server', 'playersonline' ) ) ;
if ( ( isset( $user['g_is_admin'] ) || isset( $user['g_is_supadmin'] ) ) && ( $user['g_is_admin'] ==
	1 || $user['g_is_supadmin'] == 1 ) )
{
	$allowed_ext[] = 'admin' ;
	$GLOBALS['context_menu'][] = array( 'title' => '------------------', 'link' =>
		'#' ) ;
	$GLOBALS['context_menu'][] = array( 'title' => $lang['admin_panel'], 'link' =>
		'index.php?n=admin' ) ;
}

// for mod_rewrite query_string fix //
global $_GETVARS ;

$req_vars = parse_url( $__SERVER['REQUEST_URI'] ) ;
if ( isset( $req_vars['query'] ) )
{
	parse_str( $req_vars['query'], $req_arr ) ;
	$_GETVARS = $req_arr ;
}
unset( $req_arr, $req_vars ) ;
// ======================================================= //

// Finds out what realm we are viewing.
if ( ( int )$MW->getConfig->generic_values->realm_info->multirealm && isset( $_REQUEST['changerealm_to'] ) )
{
	setcookie( "cur_selected_realmd", intval( $_REQUEST['changerealm_to'] ), time() +
		( 3600 * 24 ) ) ; // expire in 24 hour
	$user['cur_selected_realmd'] = intval( $_REQUEST['changerealm_to'] ) ;
} elseif ( ( int )$MW->getConfig->generic_values->realm_info->multirealm && isset
( $_COOKIE['cur_selected_realmd'] ) )
{
	$user['cur_selected_realmd'] = intval( $_COOKIE['cur_selected_realmd'] ) ;
} else
{
	$user['cur_selected_realmd'] = ( int )$MW->getConfig->generic_values->realm_info->default_realm_id ;
	setcookie( "cur_selected_realmd", $user['cur_selected_realmd'], time() + ( 3600 *
		24 ) ) ;
}

// Make an array from `dbinfo` column for the selected realm..
$dbinfo_mangos = $DB->selectRow( "SELECT * FROM `website_realm_settings` WHERE id_realm=?d", $user['cur_selected_realmd'] ) ;
//$dbinfo_mangos = explode( ';', $mangos_info ) ;
if ( ( int )$MW->getConfig->generic->use_archaeic_dbinfo_format )
{
	//alternate config - for users upgrading from Modded MaNGOS Web
	//DBinfo column:  host;port;username;password;WorldDBname;CharDBname
	$mangos = array(
		'db_type' => 'mysql',
		'db_host' => $dbinfo_mangos['dbhost'], //ip of db world
		'db_port' => $dbinfo_mangos['dbport'], //port
		'db_username' => $dbinfo_mangos['dbuser'], //world user
		'db_password' => $dbinfo_mangos['dbpass'], //world password
		'db_name' => $dbinfo_mangos['dbname'], //world db name
		'db_char' => $dbinfo_mangos['chardbname'], //character db name
		'db_encoding' => 'utf8', // don't change
		) ;
} else
{
	//normal config, as outlined in how-to
	//DBinfo column:  username;password;port;host;WorldDBname;CharDBname
	$mangos = array( 'db_type' => 'mysql', 'db_host' => $dbinfo_mangos['dbhost'],
		//ip of db world
		'db_port' => $dbinfo_mangos['dbport'], //port
		'db_username' => $dbinfo_mangos['dbuser'], //world user
		'db_password' => $dbinfo_mangos['dbpass'], //world password
		'db_name' => $dbinfo_mangos['dbname'], //world db name
		'db_char' => $dbinfo_mangos['chardbname'], //character db name
		'db_encoding' => 'utf8', // don't change
		) ;
}
// read template
if ($dbinfo_mangos["template"])
	$currtmp = "templates/".( string ) $dbinfo_mangos["template"] ;
unset( $dbinfo_mangos ) ; // Free up memory.

if ( ( int )$MW->getConfig->generic->use_alternate_mangosdb_port )
{
	$mangos['db_port'] = ( int )$MW->getConfig->generic->use_alternate_mangosdb_port ;
}

// Output error message and die if user has not changed info in realmd.realmlist.`dbinfo` .
if ( $mangos['db_host'] == '127.0.0.1' && $mangos['db_port'] == '3306' && $mangos['db_username'] ==
	'username' && $mangos['db_password'] == 'password' && $mangos['db_name'] ==
	'DBName' )
{
	echo "Please read README_HOWTO.txt, This is a error message btw. You must remember to setup the WORLD database information in the realm.realmlist database! :)<br />Edit the `dbinfo` to: World database info: username;password;3306;127.0.0.1;DBName" ;
	die ;
}

//Connects to WORLD DB
$WSDB = DbSimple_Generic::connect( "" . $mangos['db_type'] . "://" . $mangos['db_username'] .
	":" . $mangos['db_password'] . "@" . $mangos['db_host'] . ":" . $mangos['db_port'] .
	"/" . $mangos['db_name'] . "" ) ;
if ( $WSDB )
	$WSDB->setErrorHandler( 'databaseErrorHandler' ) ;
if ( $WSDB )
	$WSDB->query( "SET NAMES " . $mangos['db_encoding'] ) ;

$CHDB = DbSimple_Generic::connect( "" . $mangos['db_type'] . "://" . $mangos['db_username'] .
	":" . $mangos['db_password'] . "@" . $mangos['db_host'] . ":" . $mangos['db_port'] .
	"/" . $mangos['db_char'] . "" ) ;
if ( $CHDB )
	$CHDB->setErrorHandler( 'databaseErrorHandler' ) ;
if ( $CHDB )
	$CHDB->query( "SET NAMES " . $mangos['db_encoding'] ) ;

//Load characters list
if ( isset( $user['id'] ) && $user['id'] > 0 )
{
	$characters = $CHDB->select( 'SELECT guid,name FROM `characters` WHERE account=?d',
		$user['id'] ) ;
	if ( isset( $_COOKIE['cur_selected_character'] ) )
	{
		foreach ( $characters as $character )
		{
			if ( $character['guid'] == $_COOKIE['cur_selected_character'] )
			{
				$DB->query( 'UPDATE website_accounts SET character_id=?d,character_name=? WHERE account_id=?d',
					$character['guid'], $character['name'], $user['id'] ) ;
			}
		}
	}
} else
{
	$characters = array() ;
}

if ( empty( $_GET['p'] ) or $_GET['p'] < 1 )
	$p = 1 ;
else
	$p = $_GET['p'] ;
$ext = ( isset( $_REQUEST['n'] ) ? $_REQUEST['n'] : ( string )$MW->getConfig->generic->default_component ) ;
if ( strpos( $ext, '/' ) !== false )
	list( $ext, $sub ) = explode( '/', $ext ) ;
else
	$sub = ( isset( $_REQUEST['sub'] ) ? $_REQUEST['sub'] : 'index' ) ;
$req_tpl = false ;

//initialize modules
//if installing a new module, please delete the cache file
include ( 'components/modules/initialize.php' ) ;


if ( in_array( $ext, $allowed_ext ) )
{

	// load component

	//set defaults here to be loaded -- these can be changed via the main.php or whatnot
	//this is used especially in the case of the module system
	$script_file = 'components/' . $ext . '/' . $ext . '.' . $sub . '.php' ;
	$template_file = 'templates/' . ( string )$MW->getConfig->generic->template .
		'/' . $ext . '/' . $ext . '.' . $sub . '.php' ;

	require ( 'components/' . $ext . '/' . 'main.php' ) ;
	$group_privilege = $com_content[$ext][$sub][0] ;
	$expectation = ( substr( $group_privilege, 0, 1 ) == '!' ) ? 0 : 1 ;
	if ( $expectation == 0 )
		$group_privilege = substr( $group_privilege, 1 ) ;
	if ( $group_privilege && $user[$group_privilege] != $expectation )
		exit( '<h2>Forbidden</h2><meta http-equiv=refresh content="3;url=\'./\'">' ) ;
	// ==================== //
	if ( isset( $_REQUEST['n'] ) && isset( $lang[$com_content[$ext]['index'][1]] ) )
		$pathway_info[] = array( 'title' => $lang[$com_content[$ext]['index'][1]],
			'link' => $com_content[$ext]['index'][2] ) ;
	// ==================== //
	foreach ( $com_content[( string )$ext] as $sub_name => $sub_conf )
	{
		if ( $sub_conf[4] == 1 )
		{
			if ( $sub_conf[0] )
			{
				if ( $user[$sub_conf[0]] == 1 )
				{
					$GLOBALS['context_menu'][] = array( 'title' => ( isset( $lang[$sub_conf[1]] ) ?
						$lang[$sub_conf[1]] : '??title??' ), 'link' => ( isset( $sub_conf[2] ) ? $sub_conf[2] :
						'?link?' ) ) ;
				}
			} else
			{
				if ( isset( $lang[$sub_conf[1]] ) )
					$GLOBALS['context_menu'][] = array( 'title' => $lang[$sub_conf[1]], 'link' => $sub_conf[2] ) ;
			}
		}
	}
	if ( $sub )
	{
		if ( $com_content[$ext][$sub] )
		{
			if ( $com_content[$ext][$sub][0] )
			{
				if ( $user[$com_content[$ext][$sub][0]] == 1 )
				{
					$req_tpl = true ;
					@include ( $script_file ) ;
				}
			} else
			{
				$req_tpl = true ;
				@include ( $script_file ) ;

			}
		}
	}
	if ( empty( $_GET['nobody'] ) )
	{
		// DEBUG //
		if ( ( int )$MW->getConfig->generic->debuginfo )
		{
			output_message( 'debug', 'DEBUG://' . $DB->_statistics['count'] ) ;
			output_message( 'debug', '<pre>' . print_r( $_SERVER, true ) . '</pre>' ) ;
		}
		// =======//

		include ( 'templates/' . ( string )$MW->getConfig->generic->template .
			'/body_functions.php' ) ;
		ob_start() ;
		include ( 'templates/' . ( string )$MW->getConfig->generic->template .
			'/body_header.php' ) ;
		ob_end_flush() ;

		if ( $req_tpl )
		{
			if ( file_exists( $template_file ) )
			{
				// Only cache if user is not logged in.
				if ( $user['id'] < 0 && ( int )$MW->getConfig->generic->cache_expiretime != 0 )
				{

					// Start caching process But we want to exclude some cases.
					if ( isset( $_REQUEST['n'] ) && $_REQUEST['n'] != 'account' )
					{
						$cache->contentId = md5( 'CONTENT' . $_SERVER['REQUEST_URI'] ) ;
						if ( $cache->Valid() )
						{
							echo $cache->content ;
						} else
						{
							$cache->capture() ;
							include ( $template_file ) ;
							$cache->endcapture() ;
						}
					} else
					{
						include ( $template_file ) ;
					}

				} else
				{
					// Create output buffer
					ob_start() ;
					include ( $template_file ) ;
					ob_end_flush() ;
				}
			}
		}
		$time_end = microtime( 1 ) ;
		$exec_time = $time_end - $time_start ;
		include ( 'templates/' . ( string )$MW->getConfig->generic->template .
			'/body_footer.php' ) ;
	} else
	{
		if ( file_exists( $template_file ) )
		{

			include ( $template_file ) ;

		}
	}
} else
{
	echo '<h2>Forbidden</h2><meta http-equiv=refresh content="3;url=\'./\'">' ;
}

?>
