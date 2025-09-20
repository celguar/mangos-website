<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
$error = "";
$data = false;
$stat = false;
if(!isset($_GET["entry"]))
	$error = "If you are seeing this error message, you must have followed a bad link to this page.";
else
{
	if(!($request = validate_string($_GET["entry"])))
		$error = "You have entered ".$_GET["entry"]." which is invalid npc id.";
	else
	{
		//switchConnection("characters", REALM_NAME);
        $StatQuery = execute_query("world", "SELECT * FROM `creature_template` WHERE `entry` = '".$request."'".exclude_GMs()." LIMIT 1", 1);
		if(!$StatQuery)
			$error = "Creature ".$request." does not exist on realm ".REALM_NAME;
		else
		    $data = $StatQuery;
	}
}
if($error || $data == false)
{
?>
<div class="parchment-top">
<div class="parchment-content">
<?php
	showerror("entry", $error);
}
else
{
    $stat = GetCreatureInfo($data);

	$PagesCharArray = array(
	"sheet" => "npc-sheet.php",
	//"reputation" => "character-reputation.php",
	//"skills" => "character-skills.php",
	//"arenateams" => "character-arenateams.php",
	//"talents" => "character-talents.php",
	//"achievements" => "character-achievements.php",
	//"calendar" => "character-calendar.php",
	);
	if(isset($_GET["charPage"]) && isset($PagesCharArray[$_GET["charPage"]]))
		$requested_char_action = $_GET["charPage"];
	else
		$requested_char_action = "sheet";
?>
<script type="text/javascript">

var theClassId = <?php echo $data["CreatureType"] ?>;
var theRaceId = <?php echo $data["Family"] ?>;
var theClassName = "<?php echo "SomeMobs" ?>";
var theLevel = <?php echo $data["MinLevel"] ?>;

var theRealmName = "<?php echo REALM_NAME ?>";
var theCharName = "<?php echo $data["Name"] ?>";

</script>
<div class="sub-head">
<div id="divCharTabs">
<div class="tabs">
<div class="hide">
<div class="select<?php echo $requested_char_action == "sheet"? 1 : 0 ?>">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" href="index.php?searchType=profile&charPage=sheet&character=<?php echo $stat["name"],"&realm=",REALM_NAME ?>"><?php echo $lang["char_sheet"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<div class="select<?php echo $requested_char_action == "reputation" ? 1 : 0 ?>">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" href="index.php?searchType=profile&charPage=reputation&character=<?php echo $stat["name"],"&realm=",REALM_NAME ?>"><?php echo $lang["reputation"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<div class="select<?php echo $requested_char_action == "skills" ? 1 : 0 ?>">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" href="index.php?searchType=profile&charPage=skills&character=<?php echo $stat["name"],"&realm=",REALM_NAME ?>"><?php echo $lang["skills"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<?php if (CLIENT/* && $stat["level"] >= 70*/) { ?>
<div class="select<?php echo $requested_char_action == "arenateams" ? 1 : 0 ?>">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" href="index.php?searchType=profile&charPage=arenateams&character=<?php echo $stat["name"],"&realm=",REALM_NAME ?>"><?php echo $lang["arena_teams"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<?php } ?>
<div class="select<?php echo $requested_char_action == "talents" ? 1 : 0 ?>" onMouseOut="hideTip();" onMouseOver="showTip('Not yet implemented :(');">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" <?php //echo "href=\"index.php?searchType=profile&charPage=talents&character=",$stat["name"],"&realm=",REALM_NAME,"\"" ?>><?php echo $lang["talents"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<?php
	if(CLIENT > 1)
	{
?>
<div class="select<?php echo $requested_char_action == "achievements" ? 1 : 0 ?>">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" href="index.php?searchType=profile&charPage=achievements&character=<?php echo $stat["name"],"&realm=",REALM_NAME ?>" ><?php echo $lang["achievements"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<?php
	}
?>
<?php
if(CLIENT > 1)
{
?>
<div class="select<?php echo $requested_char_action == "calendar" ? 1 : 0 ?>" style="
				display:block
				">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" href="#"<?php //echo "href=\"index.php?searchType=profile&charPage=calendar&character=",$stat["name"],"&realm=",REALM_NAME,"\"" ?>>
<div style="display: block; float: left; vertical-align: baseline; margin-top: -3px;  width: 21px; height: 21px; background: url('images/tab-key-2.gif') no-repeat top left; margin-right: 4px;"></div><?php echo $lang["calendar"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<?php
}
?>
<?php
	if($stat["guild"])
	{
?>
<div class="select2" onMouseOut="hideTip();" onMouseOver="showTip('<?php echo $lang["guild_link"] ?>');">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" href="index.php?searchType=guildinfo&guildid=<?php echo $stat["guild"],"&realm=",REALM_NAME ?>"><?php echo $lang["guild"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<?php
	}
?>
</div>
</div>
</div>
</div>
<div class="parchment-top">
<div class="parchment-content">
<div class="mini-search-start-state" id="results-side-switch">
<?php
	startcontenttable("player-side");
?>
<div class="profile-wrapper">
<div class="profile">
<div class="faction-<?php echo GetFaction($stat["race"]) ?>">
<div class="profile-left">
<div class="profile-right">
<div class="profile-content">
<script type="text/javascript">
	rightSideImage = "character";
	changeRightSideImage(rightSideImage);
</script>
<div class="profile-header">
<div class="profile-avatar">
<div class="profile-placeholder">
<a class="avatar-position"><img src="images/portraits/<?php echo GetCharacterPortrait($stat["level"], $stat["gender"], $stat["race"], $stat["class"]) ?>" onmouseover="showTip('<?php echo $race," ",$class ?>')" onmouseout="hideTip()" ></a>
<p>
<div class="level-noflash"><?php echo $stat["level"],"<em>",$stat["level"] ?></em></div>
    <?php if ($achievementPoints) { ?>
        <a style="text-decoration: none!important;" onmouseover="showTip('<?php echo $lang["achievements"]; ?>')" onmouseout="hideTip()" href="index.php?searchType=profile&charPage=achievements&character=<?php echo $stat["name"]."&realm=".REALM_NAME ?>"><div class="level-noflash" style="position:relative;top:-30px;left:420px;margin-top:20px;width:67px;margin-left:-15px;padding-bottom:50px;background:url('images/achievements/point_shield.png') center no-repeat;"><?php echo $achievementPoints;?><em style="padding:14px;margin-top:-15px;"><?php echo $achievementPoints;?></em></div></a>
<?php } ?>
</p>
</div>
</div>
<div class="flash-profile" id="profile">
<div class="character-details">
<div class="character-outer">
<table>
<tr>
<td>
<h1>
<span style="font-size: 16px;"><?php if ($stat["rank"]){?><img style="height: 22px;margin-top:-5px;margin-right: 4px;" src="images/icons/pvpranks/rank<?php echo $stat["rank"]?>.gif"><span style="margin:2px;"><?php echo $stat["rank_name"]; }?></span></span>
</h1>
<h2><?php if($stat["title_name"] && !$stat["title_place"]){echo $stat["title_name"]; echo " ";} echo $stat["name"]; if($stat["title_name"] && $stat["title_place"]){echo " "; echo $stat["title_name"];}?><span style="font-size: 16px; font-weight: normal"><!--, Guardian of Cenarius--></span></h2>
<?php
	if($stat["subname"])
	{
		//switchConnection("characters", REALM_NAME);
        //$GuildName = execute_query("char", "SELECT `name` FROM `guild` WHERE `guildid` = ".$stat["guild"], 2);
		//$GuildName = $CHDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid` = ".$stat["guild"]);
		echo "<h3>",$stat["subname"],"</h3>";
	}
?>
<h4>
<span class=""><?php echo $lang["level"] ?>&nbsp;</span><span class=""><?php echo $stat["level"] ?>&nbsp;</span><span class=""><?php echo $race ?>&nbsp;</span><span class=""><?php echo $class ?></span>
</h4>
</td>
</tr>
</table>
</div>
<div class="character-clone">
<table>
<tr>
<td>
<h1>
    <span style="font-size: 16px; color: #fff7d2; margin-left:22px;"><?php if ($stat["rank"]){?><span style="margin:5px;margin-bottom:15px;"><?php echo $stat["rank_name"]; }?></span></span>
</h1>
<h2><?php if($stat["title_name"] && !$stat["title_place"]){echo $stat["title_name"]; echo " ";} echo $stat["name"]; if($stat["title_name"] && $stat["title_place"]){echo " "; echo $stat["title_name"];} ?><span style="font-size: 16px; font-weight: normal;  color: #fff7d2"><!--, Guardian of Cenarius--></span>
</h2>
<h3>
<?php
	if($stat["subname"])
		echo "<a href=\"\">".$stat["subname"]."</a>";
?>
</h3>
<h4>
<span class=""><?php echo $lang["level"] ?>&nbsp;</span><span class=""><?php echo $stat["level"] ?>&nbsp;</span><span class=""><?php echo $race ?>&nbsp;</span><span class=""><?php echo $class ?></span>
</h4>
</td>
</tr>
</table>
</div>
<div style="reldiv">
<div style="position: absolute; margin: 0px 0 0 0px; width: 700px;">
<div class="smallframe-a"></div>
<div class="smallframe-b"><?php echo REALM_NAME ?></div>
<div class="smallframe-icon">
<div class="reldiv">
<div class="smallframe-realm"></div>
</div>
</div>
<div class="smallframe-c"></div>
</div>
</div>
</div>
</div>
</div>
<?php
require $PagesCharArray[$requested_char_action];
endcontenttable();
?>
</div>
<div class="rinfo">
</div>
<?php
}
?>