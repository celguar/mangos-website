<?php
define("Armory", 1);
// Set error reporting to only a few things.
ini_set('error_reporting', E_ERROR ^ E_NOTICE ^ E_WARNING);
error_reporting( E_ERROR | E_PARSE | E_WARNING ) ;
ini_set('log_errors',TRUE);
ini_set('html_errors',FALSE);
ini_set( 'display_errors', '0' ) ;
ini_set('error_log','../core/logs/error_log.txt');
// TEST
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once ( '../core/dbsimple/Generic.php' ) ;
require "configuration/settings.php";
require "configuration/mysql.php";
require "configuration/defines.php";
require "configuration/functions.php";
$script_start = microtime_float();
// Security Check //
$PagesArray = array(
"idx" => "main.php",
"characters" => "charlist.php",
"profile" => "character.php",
"creature" => "npc.php",
"guilds" => "guildlist.php",
"guildinfo" => "guild-info.php",
"items" => "itemlist.php",
"upgrades" => "itemlist.php",
"iteminfo" => "item-info.php",
"arenateams" => "teamlist.php",
"teaminfo" => "team-info.php",
"arena" => "arenaranking.php",
"team" => "teamranking.php",
"honor" => "honorranking.php",
"login" => "login.php",
"registration" => "registration.php",
);

if(isset($_GET["searchType"]) && isset($PagesArray[$_GET["searchType"]]))
	define("REQUESTED_ACTION", $_GET["searchType"]);
else
	define("REQUESTED_ACTION", "idx");

if(isset($_GET["searchType"]) && isset($PagesArray[$_GET["searchType"]]))
{
    if ($_GET["searchType"] == "arena" || $_GET["searchType"] == "team")
    {
        if (!isset($_GET["realm"]))
        {
            foreach($realms as $key => $data)
                if ($data[0] > 1)
                {
                    $_GET["realm"] = $key;
                    break;
                }
        }
    }
}
session_start();
initialize_realm();
require "configuration/".LANGUAGE."/languagearray.php";
function session_security($fingerprint = "fingerprint001")
{
	if(isset($_SESSION["HTTP_USER_AGENT"]))
	{
		if($_SESSION["HTTP_USER_AGENT"] != md5($_SERVER["HTTP_USER_AGENT"].$fingerprint))
		{
			echo "Session Terminated. This has been recorded as a possible session hijack attempt and the session has been terminated for security reasons. If this is an inconvenience, please contact the administrator.<br /><b>What this means:</b> You have been logged out.";
			session_destroy();
			$_SESSION = array();
		}
	}
	else
		$_SESSION["HTTP_USER_AGENT"] = md5($_SERVER["HTTP_USER_AGENT"].$fingerprint);
}
if(isset($_POST["logout"]))
{
	session_destroy();
	$_SESSION = array();
}
else
	session_security(); // Make sure the session is secure...
//HEAD
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="favicon.ico" rel="shortcut icon">
<title><?php echo $config["Title"] ?></title>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<meta content="Mangos Blizzlike Armory" name="description">
<script src="shared/global/third-party/detection.js" type="text/javascript"></script>
<style media="screen, projection" type="text/css">
	@import "css/master.css";
	@import "css/<?php echo LANGUAGE ?>/language.css";
</style>
<script type="text/javascript">
//
if (is_moz) {
} else if (is_ie7) {
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/ie7.css" />');
}
else if (is_ie6) {
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/ie.css" />');

	try {
	  document.execCommand("BackgroundImageCache", false, true);
	} catch(err) {}
}
else if (is_opera) {
    document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/opera.css" />');
}
if (is_mac && !is_moz) {
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/opera-mac.css" />');
}

if (is_safari && is_mac) {
	if (is_safari3)
		document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/safari3.css" />');
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/safari.css" />');
} else if (is_safari) {
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/safari-pc.css" />');
}

//
</script>
<!-- From the old armory - Start -->
<link rel="stylesheet" type="text/css" href="css/armory-css.css" />
<link rel="stylesheet" type="text/css" href="css/armory-tooltips.css" />
<script src="source/ajax/coreajax.js" type="text/javascript"></script>
<script src="source/ajax/tooltipajax.js" type="text/javascript"></script>
<!-- From the old armory - End -->
<div id="containerJavascript"></div>
</head>
<body>
<style> @import "shared/global/menu/topnav/topnav.css"; </style>
<script>var global_nav_lang = '<?php echo LANGUAGE ?>';
var site_name = '<?php echo $config["Site_Name"] ?>';
var site_link = '<?php echo $config["Site_Link"] ?>';
var forum_link = '<?php echo $config["Forum_Link"] ?>';</script>
<div class="tn_armory" id="shared_topnav">
<script src="shared/global/menu/topnav/buildtopnav.js"></script>
</div>
<form id="historyStorageForm" method="GET">
<textarea id="historyStorageField" name="historyStorageField"></textarea>
</form>
<script src="js/armory.js" type="text/javascript"></script>
<script src="js/paging/items.js" type="text/javascript"></script>
<script src="js/dhtmlHistory.js" type="text/javascript"></script>
<script src="js/<?php echo LANGUAGE ?>/strings.js" type="text/javascript"></script>
<script src="js/<?php echo LANGUAGE ?>/items.js" type="text/javascript"></script>
<div id="loadingDiv">
<div id="loadingDivInner">
<div id="loadingDivAni">
<div style="display:none;" id="loader"></div>
<script type="text/javascript">
		var flashId="loader";
		if ((is_safari && flashId=="flashback") || (is_linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("loader", "images/loading-ani2.swf", "transparent", "", "", "43", "43", "best", "", "", "<img src=images/loading-ani.gif />")
		
		</script>
</div>
<div id="loadingDivInnerText"><?php echo $lang["loading_box"] ?><em><?php echo $lang["loading_box"] ?></em>
</div>
</div>
</div>
<table id="armory">
<tr>
<td width="50%"></td><td>
<div class="deco">
    <?php
    if ($realms[REALM_NAME][0] == 1)
        echo "<a class=\"logo\" href=\"index.php\"><span>Mangos Blizzlike Armory</span></a>";
    else if ($realms[REALM_NAME][0] == 2)
        echo "<a class=\"logo-tbc\" href=\"index.php\"><span>Mangos Blizzlike Armory</span></a>";
    else
        echo "<a class=\"logo-wotlk\" href=\"index.php\"><span>Mangos Blizzlike Armory</span></a>";
    ?>
</div>
<div class="top-anchor-int" id="divChains">
<em></em><em class="rc"></em>
</div>
<script type="text/javascript">
	var theLang = "<?php echo LANGUAGE ?>";
	var searchQueryValue = "";
	var searchRealm = "";
<?php
if(isset($_GET["searchQuery"]))
{
?>
	searchQueryValue = "<?php echo $_GET["searchQuery"] ?>";
	setcookie("armory.cookieSearch", searchQueryValue);
	searchRealm = "<?php echo REALM_NAME ?>";
	setcookie("cookieRealm", searchRealm);
<?php
}
else
{
?>
	if (getcookie2("armory.cookieSearch")) {
		searchQueryValue = getcookie2("armory.cookieSearch");
	} else {
		searchQueryValue = textSearchTheArmory;
	}
	
	if (getcookie2("cookieRealm")) {
        searchRealm = "<?php echo DefaultRealmName ?>";//searchRealm = getcookie2("cookieRealm");
	} else {
		searchRealm = "<?php echo DefaultRealmName ?>";
	}

	/*if(region != "KR" && region != "TW"){
		searchQueryValue = unescape(searchQueryValue);
	}*/
<?php
}
?>
	var globalSearch = "1";
	setcookie("cookieLangId", theLang); // fixed a bug (when the page used a function 'document(url)')
</script>
<div class="other" id="indexChange1">
<div class="search-container" id="indexChange2">
<div class="search">
<div class="adv-search">
<em></em>
<div class ="realmsearch">
<script type="text/javascript">

    var varOverRealm = 0;


</script>
<div class="dropdown1" onMouseOut="javascript: varOverRealm = 0;" onMouseOver="javascript: varOverRealm = 1;">
<a class="profile-stats" href="javascript: document.formDropdownRealm.dummyLang.focus();" id="displayRealm"><?php echo DefaultRealmName ?></a>
</div>
<div style="position: relative;">
<div style="position: absolute;">
<form id="formDropdownRealm" name="formDropdownRealm" style="height: 0px;">
<input id="dummyLang" onBlur="javascript: if(!varOverRealm) document.getElementById('dropdownHiddenRealm').style.display='none';" onFocus="javascript: dropdownMenuToggle('dropdownHiddenRealm');" size="2" style="position: relative; left: -5000px;" type="button">
</form>
</div>
</div>
<div class="drop-stats" id="dropdownHiddenRealm" onMouseOut="javascript: varOverRealm = 0;" onMouseOver="javascript: varOverRealm = 1;" style="display: none; z-index: 50;">
<div class="tooltip">
<table>
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"><q></q></td><td class="bg">
<?php
foreach($realms as $key => $data)
{
    $query = $_GET;
    $query['realm'] = str_replace(" ", "%20", $key);
    $query_result = http_build_query($query);
    if (isset($_GET["searchQuery"]))
        echo "<a href=\"javascript: selectRealm('",addslashes($key),"'); window.location.href='index.php?".addslashes($query_result)."';\">",$key,"</a>";
    else
        echo "<a href=\"javascript: selectRealm('",addslashes($key),"');\">",$key,"</a>";
}
?>
<?php
if (isset($_GET["realm"]))
    echo "<script type=\"text/javascript\"> searchRealm = '",addslashes($_GET["realm"]),"';</script>";
?>
</td><td class="r"><q></q></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
</div>
<div class="lrs"></div>
</div>
</div>
<div class="search-right">
<a class="title-search"><span>Search the Armory</span></a>
<div class="input">
<div class="dd">
<div class="dropDowner">
<a class="dropTrigger" href="javascript:void(0);" id="replaceSearchOption" onmouseout="javascript: getElementById('searchCat').style.display='none';" onmouseover="javascript: getElementById('searchCat').style.display='block';"><?php echo $lang["characters"] ?></a>
<div class="searchMenu" id="searchCat" onmouseout="javascript: getElementById('searchCat').style.display='none';" onmouseover="javascript: getElementById('searchCat').style.display='block';">
<del></del>
<div class="sm-content">
<a href="#" onClick="javascript: menuSelect('<?php echo $lang["characters"] ?>', 'characters'); return false;"><?php echo $lang["characters"] ?></a><a href="#" onClick="javascript: menuSelect('<?php echo $lang["guilds"] ?>', 'guilds'); return false;"><?php echo $lang["guilds"] ?></a><?php if (CLIENT){ ?><a href="#" onClick="javascript: menuSelect('<?php echo $lang["arena_teams"] ?>', 'arenateams'); return false;"><?php echo $lang["arena_teams"] ?></a><?php } ?><a href="#" onClick="javascript: menuSelect('<?php echo $lang["items"] ?>', 'items'); return false;"><?php echo $lang["items"] ?></a>
</div>
<q></q>
</div>
</div>
</div>
<div class="arrow"></div>
<form action="index.php" method="get" name="formSearch" onSubmit="javascript: return menuCheckLength(document.formSearch);">
<div class="ipl">
<div style="position: relative; z-index: 90; left: -160px;">
<input id="armorySearch" maxlength="72" name="searchQuery" onBlur="javascript: checkBlur();" onFocus="javascript: checkClear();" size="16" type="text" value="<?php echo $lang["armory_search"] ?>">
</div>
<div id="errorSearchType"></div>
<div id="formSearch_errorSearchLength" onMouseOver="javascript: this.innerHTML = '';"></div>
<input name="searchType" type="hidden" value= "characters">
<input name="realm" type="hidden" value= "<?php echo DefaultRealmName ?>">
</div>
<script type="text/javascript">
	var searchTypeValue = "";
<?php
if(isset($_GET["searchQuery"]))
{
?>
	if ("<?php echo REQUESTED_ACTION ?>" != "characters" && "<?php echo REQUESTED_ACTION ?>" != "guilds" && "<?php echo REQUESTED_ACTION ?>" != "arenateams" && "<?php echo REQUESTED_ACTION ?>" != "items")
		searchTypeValue = "characters";
	else
		searchTypeValue = "<?php echo REQUESTED_ACTION ?>";
	setcookie("cookieMenu", searchTypeValue);
<?php
}
else
{
?>
	searchTypeValue = getcookie2("cookieMenu");
	/*searchTypeValue = searchTypeValue.replace("ext=", "");
	if (searchTypeValue == "Characters")
		searchTypeValue = "characters";*/
<?php
}
?>
	var searchTypeText = getcookie2("cookieMenuText");
	if (!searchTypeValue) {
		searchTypeValue	= "characters";
		setcookie('cookieMenu', "characters");
	} else {
		if (searchTypeValue != 'characters')
			document.getElementById('replaceSearchOption').innerHTML = searchTypeText;
	}

document.formSearch.searchQuery.value = searchQueryValue;
document.formSearch.searchType.value = searchTypeValue;
document.formSearch.realm.value = searchRealm;
document.getElementById('displayRealm').innerHTML = searchRealm;

</script>
<div class="ip" id="flashback">
<div id="searchFlash"></div>
<div id="flashback" style="display:none;"></div>
<script type="text/javascript">
		var flashId="flashback";
		if ((is_safari && flashId=="flashback") || (is_linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("flashback", "images/searchbox.swf", "transparent", "", "", "211", "33", "high", "", "", "<div class=fb></div>")
		
		</script>
</div>
<div class="submit" style="position:relative; z-index: 100;">
<a class="submit" onClick="javascript: return menuCheckLength(document.formSearch);"></a>
</div>
<div class="searchTrick">
<input id="dummy" onBlur="javascript: hideDropBox();" size="2" type="button">
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<div class="backplate">
    <?php
    if (!isset($_GET["realm"]) || $realms[$_GET["realm"]][0] == 1)
        echo "<div class=\"bp2\">";
    else if ($realms[$_GET["realm"]][0] == 2)
        echo "<div class=\"bp2-tbc\">";
    else
        echo "<div class=\"bp2-wotlk\">";
    ?>
<span class="general-image" id="imageLeft"></span>
<div class="ab-container">
<h3 class="banner">
<span class="armory-left"></span><a class="armory-title" href="index.php"><span id="armoryTitleRef">The Armory</span></a>
</h3>
<!--<p class="beta"></p>
<a class="betaLink" href="index.xml"><img src="images/pixel.gif"></a>-->
</div>
<div class="pin-container">
<?php
if($config["Login"] && !isset($_SESSION["logged_MBA"]))
{
?>
<div class="loginBox">
<div class="loginContents">
<div class="toplogincontainer">
<div class="toploginright"></div>
<div style="height: 23px; background: url('images/login-armory-bg.gif') repeat-x top left; float: right; padding: 3px 7px 0;">
<form id="loginRedirect" method="post" name="loginRedirect">
<input id="passThrough" name="passThrough" type="hidden" value="1"><input id="redirectUrl" name="redirectUrl" type="hidden"><a alt="" href="javascript: document.loginRedirect.submit()">
<div style="display: block; float: left; vertical-align: baseline; margin-top: -2px;  width: 25px; height: 23px; background: url('images/tab-key-3.gif') no-repeat top left; margin-right: 4px;"></div><?php echo $lang["log_in"] ?></a>
</form>
<script type="text/javascript">
		  document.getElementById('loginRedirect').action = "index.php?searchType=login";
		  </script>
</div>
<div class="toploginleft"></div>
</div>
<script type="text/javascript">document.getElementById('redirectUrl').value = window.location.pathname + window.location.search;</script>
</div>
</div>
<?php
}
?>
<script type="text/javascript">
	var registrationLink = "<?php echo $config["ExternalRegistrationPage"] ? $config["ExternalRegistrationPage"] : "index.php?searchType=registration" ?>";
</script>
<div class="pinProfile" id="showHidePin">
<div class="pin-back">
<div class="hord" id="changeClassFaction">
<h1></h1>
<div class="pin-base">
<strong id="replacePinCharName1"></strong>
<p id="replacePinGuildName1"></p>
</div>
<div class="pin-clone">
<strong id="replacePinCharName2"></strong>
<p id="replacePinGuildName2"></p>
</div>
<div class="pinArena">
<div id="replaceTeam2"></div>
<div id="replaceTeam3"></div>
<div id="replaceTeam5"></div>
</div>
<div class="pinNav">
<a class="pdown0" href="javascript: ;" id="idPinNavArrow" onMouseOut="javascript: document.getElementById('pinprofile').style.visibility = 'hidden';" onMouseOver="javascript: hoverPinOption();"></a>
</div>
</div>
</div>
<div class="tooltip" id="pinprofile" onMouseOut="javascript: document.getElementById('pinprofile').style.visibility='hidden';" onMouseOver="javascript: document.getElementById('pinprofile').style.visibility='visible';">
</div>
</div>
</div>
<div class="global-nav">
<a class="wowcom" href="index.php"></a>
<div id="arenaMenu"></div>
</div>
</div>
<script type="text/javascript">
//
/*if (getcookie2("armory.cookieCharProfileUrl") !=0) {
	showPin();
if (getcookie2("armory.cookieDualTooltip") == 1)
	document.getElementById('checkboxDualTooltip').checked = 1;
} */
<?php
if(isset($_SESSION["logged_MBA"]))
	echo "	showPin2(\"",addslashes($_SESSION["user_name"]),"\");\n";
else if($config["Registration"])
	echo "	hidePin(1);\n";
else
	echo "	hidePin(0);\n";
?>
//
</script>
<div id="replaceMain">
<div id="dataElement">
<?php
if(REQUESTED_ACTION <> "profile" && REQUESTED_ACTION <> "guildinfo")
{
?>
<div class="parchment-top">
<div class="parchment-content">
<?php
}
?>
<?php
require "source/".$PagesArray[REQUESTED_ACTION];
//FOOT
?>
</div>
</div>
</div>
</div>
</div>
<div class="tooltip" id="tooltipcontainer" onmouseout="hideTip();">
<div id="tool1container">
<table>
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"><q></q></td><td class="bg">
<div id="toolBox">TEST</div>
</td><td class="r"><q></q></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
<table id="tool2container" style="float:left; display:none; margin-top: 10px;">
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"><q></q></td><td class="bg">
<div id="toolBox_two">TEST</div>
</td><td class="r"><q></q></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
<table id="tool3container" style="float:left; display:none; margin-top: 10px;">
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"><q></q></td><td class="bg">
<div id="toolBox_three">TEST</div>
</td><td class="r"><q></q></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
</div>
<div class="footerplate">
<a href="index.php"></a>
</div>
<div class="copyright"><?php echo "Page generated in ",round(microtime_float() - $script_start, 4)," sec. Used amount of memory: ",memory_get_peak_usage()," Bytes" ?>
<br />MBA project leader - SUPERGADGET<br />2008-2010</div>
</td><td class="section-general" id="imageRight" width="50%"></td>
</tr>
</table>
<div id="output"></div>
<script type="text/javascript">
  rightSideImageReady=1;
  if(rightSideImage)
	changeRightSideImage(rightSideImage);


	var elemt1c = document.getElementById("tool1container");
	var elemttc = document.getElementById("tooltipcontainer");
	var elemt2c = document.getElementById("tool2container");
	var elemt3c = document.getElementById("tool3container");
	var elemtb1 = document.getElementById("toolBox");
	var elemtb2 = document.getElementById("toolBox_two");
	var elemtb3 = document.getElementById("toolBox_three");
	var elemDoc = document.documentElement;

  <?php
          $exp = "vanilla";
  if ($realms[REALM_NAME][0] == 1)
      $exp = "vanilla";
  else if ($realms[REALM_NAME][0] == 2)
      $exp = "tbc";
  else
      $exp = "wotlk";
  ?>

</script><script src="shared/global/menu/<?php echo LANGUAGE ?>/menutree_<?php echo $exp ?>.js" type="text/javascript"></script><script src="shared/global/menu/menu132_com.js" type="text/javascript"></script><script src="js/<?php echo LANGUAGE ?>/menus.js" type="text/javascript"></script><script src="shared/global/third-party/sarissa/0.9.7.6/sarissa.js" type="text/javascript"></script><script src="shared/global/third-party/sarissa/0.9.7.6/sarissa_dhtml.js" type="text/javascript"></script><script src="js/ajaxtooltip.js" type="text/javascript"></script>
</body>
</html>