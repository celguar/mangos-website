<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
?>
<p style="height: 30px; font-size: 1px; margin:0; padding:0; width: 1px;"></p>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
$arenatypes = array(2, 3, 5);
foreach($arenatypes as $type)
{
	//switchConnection("characters", REALM_NAME);
    $team = execute_query("char", "SELECT atm.`arenateamid`, `played_season`, `wons_season`, `personal_rating`, `games_season` as `played` ,`wins_season` as `wins2`, `rating`, `rank`, at.`name`, `BackgroundColor`, `EmblemStyle`, `EmblemColor`, `BorderColor`, c.`name` AS cap_name, `race`, `class`, `level`, `gender`
	 FROM `arena_team_member` AS atm, `arena_team` AS at, `arena_team_stats` AS ats, `characters` AS c
	 WHERE atm.`arenateamid` = at.`arenateamid` AND atm.`arenateamid` = ats.`arenateamid` AND `captainguid` = c.`guid`
	 AND atm.`guid` = ".$stat["guid"]." AND `type` = ".$type." LIMIT 1", 1);
	if($team)
	{
		if($team["wins2"])
		{
			$team["win_loss"] = $team["wins2"]." - ".($team["played"] - $team["wins2"]);
			$team["win_percent"] = round(($team["wins2"] / $team["played"]) * 100);
		}
		else
		{
			$team["win_loss"] = "0 - 0";
			$team["win_percent"] = 0;
		}
		if($team["wons_season"])
		{
			$team["personal_win_loss"] = $team["wons_season"]." - ".($team["played_season"] - $team["wons_season"]);
			$team["personal_win_percent"] = round(($team["wons_season"] / $team["played_season"]) * 100);
		}
		else
		{
			$team["personal_win_loss"] = "0 - 0";
			$team["personal_win_percent"] = 0;
		}
		$team["link"] = "index.php?searchType=teaminfo&arenateamid=".$team["arenateamid"]."&realm=".REALM_NAME;
		// Captain
		// Faction Info //
		$team["faction_name"] = GetFaction($team["race"]);
		$team["faction"] = $team["faction_name"] == "alliance" ? 0 : 1;
		$team["members"] = "";
		//switchConnection("characters", REALM_NAME);
		$membersquery = execute_query("char", "SELECT `name` FROM `characters`, `arena_team_member`
		 WHERE `characters`.`guid` = `arena_team_member`.`guid` AND `arenateamid` = ".$team["arenateamid"]);
		foreach ($membersquery as $member)
        {
            $memberLink = "<a href=\"index.php?searchType=profile&character=".$member["name"]."&realm=".REALM_NAME."\">".$member["name"]."</a>";
            $team["members"] .= $team["members"] ? ", ".$memberLink : $memberLink;
        }
?>
</td><td class="tip-right"></td>
</tr>
<tr>
<td class="tip-bot-left"></td><td class="tip-bot"></td><td class="tip-bot-right"></td>
</tr>
</table>
</div>
<div class="tip" style="clear: both;">
<table>
<tr>
<td class="tip-top-left"></td><td class="tip-top"></td><td class="tip-top-right"></td>
</tr>
<tr>
<td class="tip-left"></td><td class="tip-bg">
<div class="profile-wrapper">
<blockquote>
<b class="iarenateams-sm">
<h2><?php echo $type,"v",$type," ",$lang["arena_team"] ?></h2>
</b>
</blockquote>
<div class="arenaTeam-wrapper">
<div class="arenaTeam-right">
<div class="arenaHeader">
<div class="
	  team-icon<?php echo $type ?>">
    <?php if ($team["EmblemStyle"] > 0) { ?>
        <img style="margin: 14px 0px 0px 4px;border:5px;border-style: outset;border-color: #<?php echo emblem_color_convert($team['BorderColor']) ?>;background-color: #<?php echo emblem_color_convert($team['BackgroundColor']) ?>;" src="images/icons/team/pvp-banner-emblem-<?php echo $team["EmblemStyle"] ?>.png">
    <?php } ?>
<div class="team-icon-flash" id="teamicon<?php echo $type ?>">
<div id="teamicon<?php echo $type ?>" style="display:none;"></div>
<script type="text/javascript">
printFlash("teamicon<?php echo $type ?>", "images/icons/team/pvpemblems.swf", "transparent", "", "#000000", "78", "78", "high", "", "totalIcons=1&totalIcons=1&startPointX=4&initScale=100&overScale=100&largeIcon=1&iconColor1=<?php echo emblem_color_convert($team['EmblemColor']) ?>&iconName1=images/icons/team/pvp-banner-emblem-<?php echo $team["EmblemStyle"] ?>.png&bgColor1=<?php echo emblem_color_convert($team['BackgroundColor']) ?>&borderColor1=<?php echo emblem_color_convert($team['BorderColor']) ?>&teamUrl1=", "")
</script>
</div>
</div>
<div class="arenaTeam-name">
<h3><?php echo $team["name"] ?></h3>
<h4>
<a href="<?php echo $team["link"] ?>"><?php echo $team["name"] ?></a>
</h4>
<div class="arenaRealm-info">
<div class="team-members"><?php echo $lang["team_members"],": ",$team["members"] ?>
</div>
</div>
<em></em>
</div>
<div class="arenaTeam-badge">
<div class="teamSide<?php echo $team["faction"] ?>"></div>
<div class="teamRank">
<span><?php echo $lang["current"] ?></span>
<p><?php echo $lang["rank"] ?></p>
</div>
<div class="rank-num" id="arenarank<?php echo $type ?>" style="padding-top: 5px; ">
<div id="arenarank<?php echo $type ?>" style="display:none;"></div>
<script type="text/javascript">
		var flashId="arenarank<?php echo $type ?>";
		if ((is_safari && flashId=="flashback") || (is_linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("arenarank<?php echo $type ?>", "images/rank.swf", "transparent", "", "", "100", "50", "best", "", "rankNum=<?php echo ordinal_suffix($team["rank"]) ?>", "<div class=teamstanding-noflash><?php echo ordinal_suffix($team["rank"]) ?></div>")
		
		</script>
</div>
<div class="arenaBadge-icon" id="icon<?php echo $type,"v",$type ?>team" style="background-image:url(images/pixel.gif);">
<img border="0" class="p" id="badgeBorder<?php echo $type,"v",$type ?>team" src="images/pixel.gif"></div>
</div>
<script type="text/javascript">
getArenaIcon(<?php echo $team["rank"],", ",$type ?>);
</script>
<a class="standing-link" href="index.php?searchType=team&type=<?php echo $type,"&realm=",REALM_NAME ?>"><img src="images/pixel.gif"></a>
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
<td></td><td align="center" width="25%"><?php echo $lang["games"] ?></td><td align="center" width="25%"><?php echo $lang["win_loss"] ?></td><td align="center" width="25%"><?php echo $lang["win"] ?></td><td align="center" width="25%"><?php echo $lang["rating"] ?></td>
</tr>
<tr class="hl">
<td>
<p><?php echo $type,"v",$type," ",$lang["team_stats"] ?></p>
</td><td align="center">
<p><?php echo $team["played"] ?></p>
</td><td align="center">
<p><?php echo $team["win_loss"] ?></p>
</td><td align="center">
<p><?php echo $team["win_percent"] ?>%</p>
</td><td align="center">
<p><?php echo $team["rating"] ?></p>
</td>
</tr>
<tr>
<td>
<p><?php echo $stat["name"],$lang["own_stats"] ?>:</p>
</td><td align="center">
<p><?php echo $team["played_season"] ?></p>
</td><td align="center">
<p><?php echo $team["personal_win_loss"] ?></p>
</td><td align="center">
<p><?php echo $team["personal_win_percent"] ?>%</p>
</td><td align="center">
<p><?php echo $team["personal_rating"] ?></p>
</td>
</tr>
</table>
<table class="dataRepop">
<tr class="team-header">
<td></td><td align="center" width="25%"><span><?php echo $lang["games"] ?></span></td><td align="center" width="25%"><span><?php echo $lang["win_loss"] ?></span></td><td align="center" width="25%"><span><?php echo $lang["win"] ?></span></td><td align="center" width="25%"><span><?php echo $lang["rating"] ?></span></td>
</tr>
<tr class="hl">
<td>
<p><?php echo $type,"v",$type," ",$lang["team_stats"] ?></p>
</td><td align="center">
<p><?php echo $team["played"] ?></p>
</td><td align="center">
<p><?php echo $team["win_loss"] ?></p>
</td><td align="center">
<p><?php echo $team["win_percent"] ?>%</p>
</td><td align="center">
<p class="rating"><?php echo $team["rating"] ?></p>
</td>
</tr>
<tr>
<td>
<p><?php echo $stat["name"],$lang["own_stats"] ?>:</p>
</td><td align="center">
<p><?php echo $team["played_season"] ?></p>
</td><td align="center">
<p><?php echo $team["personal_win_loss"] ?></p>
</td><td align="center">
<p><?php echo $team["personal_win_percent"] ?>%</p>
</td><td align="center">
<p class="rating"><?php echo $team["personal_rating"] ?></p>
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
</div>
<?php
	}
}
?>