<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
?>
<script type="text/javascript">
	rightSideImage = "arena";
	changeRightSideImage(rightSideImage);
</script>
<?php
if(!isset($_GET["arenateamid"]))
{
	showerror("If you are seeing this error message,", "you must have followed a bad link to this page.");
	$do_query = 0;
}
else
{
	//switchConnection("characters", REALM_NAME);
	// The arenateam ID was set.. Now, get information on the arenateam //
	$arenateamId = (int) $_GET["arenateamid"];
    $arenateam = execute_query("char", "SELECT * FROM `arena_team`,`arena_team_stats` WHERE `arena_team`.`arenateamid` = `arena_team_stats`.`arenateamid` AND `arena_team_stats`.`arenateamid` = ".$arenateamId." LIMIT 1", 1);
	// If there were no results, the arenateam did not exist //
	if(!$arenateam)
	{
		showerror("Arena does not exist", "The arenateam with ID &quot;".$arenateamId."&quot; does not exist.");
		$do_query = 0;
	}
	else
	{
		// The arenateam exists //
		// Basic Information on Arena Team //
		// Get the arenateam captain if it exists //
		if(!$arenateam["captainguid"])
		{
			// Arena Team has no master? err //
			showerror("&lt;Arena Team has no captain&gt;", "The arenateam with the ID &quot;".$arenateamId."&quot; has no captain.");
			$do_query = 0;
		}
		else
			$do_query = 1;
	}
}
if($do_query)
{
	// Return the captain of the arenateam //
	$captaindata = execute_query("char", "SELECT `name`, `race`, `class`, `level`, `gender` FROM `characters` WHERE `guid` = ".$arenateam["captainguid"]." LIMIT 1", 1);
	// Faction Info //
	$faction_name = GetFaction($captaindata["race"]);
	$faction_number = $faction_name == "alliance" ? 0 : 1;
	$mlquery = execute_query("char", "SELECT * FROM `characters`, `arena_team_member` WHERE `characters`.`guid`=`arena_team_member`.`guid` and `arenateamid` = ".$arenateam["arenateamid"].exclude_GMs()." ORDER BY `personal_rating` DESC");
	// Get number of members in arenateam //
	$arenateam_members = $mlquery ? count($mlquery) : 0;
	// Statistics //
	if($arenateam["wins_week"])
		$arenateam["win_percent_week"] = round(($arenateam["wins_week"] / $arenateam["games_week"]) * 100);
	else
		$arenateam["win_percent_week"] = 0;
	if($arenateam["wins_season"])
		$arenateam["win_percent_season"] = round(($arenateam["wins_season"] / $arenateam["games_season"]) * 100);
	else
		$arenateam["win_percent_season"] = 0;
	$arenateam["losses_week"] = $arenateam["games_week"] - $arenateam["wins_week"];
	$arenateam["losses_season"] = $arenateam["games_season"] - $arenateam["wins_season"];
	startcontenttable("team-side");
?>
<div class="profile-wrapper">
<blockquote>
<b class="iarenateams">
<h4>
<a href="index.php?searchType=arenateams"><?php echo $lang["team_profile"] ?></a>
</h4>
<h3><?php echo $arenateam["type"],"v",$arenateam["type"]," ",$lang["team_statistics"] ?></h3>
</b>
</blockquote>
</div>
<div class="arenaTeam-wrapper">
<div class="arenaTeam-right">
<div class="arenaHeader">
<div class="team-icon<?php echo $arenateam["type"] ?>">
    <?php if ($arenateam["EmblemStyle"] > 0) { ?>
    <img style="margin: 14px 0px 0px 4px;border:5px;border-style: outset;border-color: #<?php echo emblem_color_convert($arenateam['BorderColor']) ?>;background-color: #<?php echo emblem_color_convert($arenateam['BackgroundColor']) ?>;" src="images/icons/team/pvp-banner-emblem-<?php echo $arenateam["EmblemStyle"] ?>.png">
<?php } ?>
<div class="team-icon-flash" id="teamicon<?php echo $arenateam["type"] ?>">
<div id="teamicon<?php echo $arenateam["type"] ?>" style="display:none;">
</div>
<script type="text/javascript">
printFlash("teamicon<?php echo $arenateam["type"] ?>", "images/icons/team/pvpemblems.swf", "transparent", "", "#000000", "78", "78", "high", "", "totalIcons=1&totalIcons=1&startPointX=4&initScale=100&overScale=100&largeIcon=1&iconColor1=<?php echo emblem_color_convert($arenateam['EmblemColor']) ?>&iconName1=images/icons/team/pvp-banner-emblem-<?php echo $arenateam["EmblemStyle"] ?>.png&bgColor1=<?php echo emblem_color_convert($arenateam['BackgroundColor']) ?>&borderColor1=<?php echo emblem_color_convert($arenateam['BorderColor']) ?>&teamUrl1=", "")
</script>
</div>
</div>
<div class="arenaTeam-name">
<h3><?php echo $arenateam["name"] ?></h3>
<h4>
<a><?php echo $arenateam["name"] ?></a>
</h4>
<div class="arenaRealm-info">
<a class="realm-icon" onMouseOut="hideTip();" onMouseOver="javascript: showTip(&quot;Realm&quot;);"></a>
<p>
<a class="name"><?php echo REALM_NAME ?></a>
</p>
</div>
<em></em>
</div>
<div class="arenaTeam-badge">
<div class="teamSide<?php echo $faction_number ?>"></div>
<div class="teamRank">
<span><?php echo $lang["current"] ?></span>
<p><?php echo $lang["rank"] ?></p>
</div>
<div class="rank-num" id="arenarank<?php echo $arenateam["type"] ?>" style="padding-top: 5px; ">
<div id="arenarank<?php echo $arenateam["type"] ?>" style="display:none;"></div>
<script type="text/javascript">
		var flashId="arenarank<?php echo $arenateam["type"] ?>";
		if ((is_safari && flashId=="flashback") || (is_linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("arenarank<?php echo $arenateam["type"] ?>", "images/rank.swf", "transparent", "", "", "100", "50", "best", "", "rankNum=<?php echo ordinal_suffix($arenateam["rank"]) ?>", "<div class=teamstanding-noflash><?php echo ordinal_suffix($arenateam["rank"]) ?></div>")
		
		</script>
</div>
<div class="arenaBadge-icon" id="icon<?php echo $arenateam["type"],"v",$arenateam["type"] ?>team" style="background-image:url(images/pixel.gif);">
<img border="0" class="p" id="badgeBorder<?php echo $arenateam["type"],"v",$arenateam["type"] ?>team" src="images/pixel.gif"></div>
</div>
<script type="text/javascript">
getArenaIcon(<?php echo $arenateam["rank"],", ",$arenateam["type"] ?>);
</script>
<a class="standing-link" href="index.php?searchType=team&type=<?php echo $arenateam["type"],"&realm=".REALM_NAME ?>"></a>
<div class="arenaTeam-data">
<div class="arenaData">
<table class="arenaData">
<thead>
<tr>
<td class="sl"></td><td class="ct st"></td><td class="sr"></td>
</tr>
</thead>
<tbody>
<tr>
<td class="sl"><q></q></td><td class="ct">
<div class="innerData">
<table>
<tr class="team-header">
<td></td><td align="center"><?php echo $lang["games"] ?></td><td align="center"><?php echo $lang["win_loss"] ?></td><td align="center"><?php echo $lang["win"] ?></td><td align="center"><?php echo $lang["team_rating"] ?></td>
</tr>
<tr class="hl">
<td>
<p><?php echo $lang["this_week"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["games_week"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["wins_week"]," - ",$arenateam["losses_week"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["win_percent_week"] ?>%</p>
</td><td align="center">
<p><?php echo $arenateam["rating"] ?></p>
</td>
</tr>
<tr>
<td>
<p><?php echo $lang["season"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["games_season"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["wins_season"]," - ",$arenateam["losses_season"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["win_percent_season"] ?>%</p>
</td><td align="center">
<p><?php echo $arenateam["rating"] ?></p>
</td>
</tr>
</table>
<table class="dataRepop">
<tr class="team-header">
<td></td><td align="center"><span><?php echo $lang["games"] ?></span></td><td align="center"><span><?php echo $lang["win_loss"] ?></span></td><td align="center"><span><?php echo $lang["win"] ?></span></td><td align="center"><span><?php echo $lang["team_rating"] ?></span></td>
</tr>
<tr class="hl">
<td>
<p><?php echo $lang["this_week"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["games_week"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["wins_week"]," - ",$arenateam["losses_week"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["win_percent_week"] ?>%</p>
</td><td align="center">
<p class="rating"><?php echo $arenateam["rating"] ?></p>
</td>
</tr>
<tr>
<td>
<p><?php echo $lang["season"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["games_season"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["wins_season"]," - ",$arenateam["losses_season"] ?></p>
</td><td align="center">
<p><?php echo $arenateam["win_percent_season"] ?>%</p>
</td><td align="center">
<p class="rating"><?php echo $arenateam["rating"] ?></p>
</td>
</tr>
</table>
</div>
</td><td class="sr"><q></q></td>
</tr>
</tbody>
<tfoot>
<tr>
<td class="sl"></td><td class="ct sb"></td><td class="sr"></td>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
<div class="arenaBody"></div>
</div>
</div>
</td><td class="tip-right"></td>
</tr>
<tr>
<td class="tip-bot-left"></td><td class="tip-bot"></td><td class="tip-bot-right"></td>
</tr>
</table>
</div>
<div class="tip" style="clear: left">
<table>
<tr>
<td class="tip-top-left"></td><td class="tip-top"></td><td class="tip-top-right"></td>
</tr>
<tr>
<td class="tip-left"></td><td class="tip-bg">
<div class="data">
<table class="data-table">
<tr class="masthead">
<td>
<div>
<p></p>
</div>
</td><td><a class="noLink"><?php echo $lang["team_member"] ?>: </a></td><td><a class="noLink"><?php echo $lang["guild"] ?></a></td><td align="center"><a class="noLink"><?php echo $lang["race"],"/",$lang["class"] ?></a></td><td align="center"><a class="noLink"><?php echo $lang["all_games"] ?></a></td><td align="center"><a class="noLink"><?php echo $lang["wins"] ?></a></td><td align="center"><a class="noLink"><?php echo $lang["losses"] ?></a></td><td align="center"><a class="noLink"><?php echo $lang["win"] ?></a></td><td align="center"><a class="noLink"><?php echo $lang["personal_rating"] ?></a></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
foreach ($mlquery as $cdata)
{
    echo "<tr class=\"";
    if($arenateam["captainguid"] == $cdata["guid"])
        echo "data3";
    echo "\">
		<td>
		<div>
		<p></p>
		</div>
		</td><td><q><span class=\"";
    if($arenateam["captainguid"] == $cdata["guid"])
        echo "gm";
    echo "\"><a href=\"index.php?searchType=profile&character=",$cdata["name"],"&realm=",REALM_NAME,"\">",$cdata["name"],"</a></span></q></td>";
    //switchConnection("characters", REALM_NAME);
    $gquery = execute_query("char", "SELECT `guildid` FROM `guild_member` WHERE `guid` = ".$cdata["guid"]." LIMIT 1", 1);
    $guildid = $gquery ? $gquery["guildid"] : 0;
    echo "<td class=\"\"><q><strong>",guild_tooltip($guildid),"</strong></q></td>";
    if($cdata["played_season"])
        $win_percent = round(($cdata["wons_season"]/$cdata["played_season"])*100);
    else
        $win_percent = 0;
?>
<td align="center"><img class="ci" onmouseout="hideTip()" onMouseOver="showTip('<?php echo GetNameFromDB($cdata["race"], "dbc_chrraces") ?>')" src="images/icons/race/<?php echo $cdata["race"],"-",$cdata["gender"] ?>.gif"><img src="shared/wow-com/images/layout/pixel.gif" width="2">
<img class="ci" onmouseout="hideTip()" onMouseOver="showTip('<?php echo GetNameFromDB($cdata["class"], "dbc_chrclasses") ?>')" src="images/icons/class/<?php echo $cdata["class"] ?>.gif"></td>
<td align="center"><q><i><span class="veryplain"><?php echo $cdata["played_season"] ?></span></i></q></td>
<td align="center"><q><i><span class="g"><?php echo $cdata["wons_season"] ?></span></i></q></td>
<td align="center"><q><i><span class="r"><?php echo $cdata["played_season"]-$cdata["wons_season"] ?></span></i></q></td>
<td align="center"><q><i><span class="veryplain"><?php echo $win_percent ?>%</span></i></q></td>
<td align="center"><q><i><span class="veryplain"><?php echo $cdata["personal_rating"] ?></span></i></q></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
	}
?>
</table>
</div>
<?php
	endcontenttable();
}
?>