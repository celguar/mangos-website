<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
if(isset($_GET["type"]))
{
	$type = (int) $_GET["type"];
	if($type <> 2 && $type <> 3 && $type <> 5)
		$type = 2;
}
else
	$type = 2;
if(isset($_GET["sortBy"]))
{
	$orderField = $_GET["sortBy"];
	if($orderField <> "wins2" && $orderField <> "losses" && $orderField <> "rating")
		$orderField = "rating";
}
else
	$orderField = "rating";
?>
<script type="text/javascript">
	rightSideImage = "arena";
	changeRightSideImage(rightSideImage);
</script>
<script src="js/arena-ladder-ajax.js" type="text/javascript"></script>
<?php
startcontenttable();
?>
<div class="profile-wrapper">
<blockquote>
<b class="iarenateams">
<h4>
<a href="index.php?searchType=team">Team Rankings</a>
</h4>
<h3><?php echo "Team ",$type,"v",$type," Top ",$config["TeamTop"],": ",REALM_NAME ?></h3>
</b>
</blockquote>
<div class="generic-wrapper">
<div class="generic-right">
<div class="genericHeader ath">
<div class="arena-list">
<em class="d-bg">
<h3>
<img src="images/icons/icon-bg.gif"><span><?php echo $lang["types"] ?>:</span>
</h3>
<select class="battlegroupName" id="battlegroupName" onchange="javascript: { if (this.value) arenaLadderPageInstance.followLink(this.value); }">
<!--<option selected value="#"></option>-->
<option <?php if ($_GET["type"] == 2) {?>selected <?php } ?> value="index.php?searchType=team&type=2&realm=<?php echo REALM_NAME,"&sortBy=",$orderField ?>">2v2</option>
<option <?php if ($_GET["type"] == 3) {?>selected <?php } ?>value="index.php?searchType=team&type=3&realm=<?php echo REALM_NAME,"&sortBy=",$orderField ?>">3v3</option>
<option <?php if ($_GET["type"] == 5) {?>selected <?php } ?>value="index.php?searchType=team&type=5&realm=<?php echo REALM_NAME,"&sortBy=",$orderField ?>">5v5</option>
</select></em><em class="d-rlm">
<h3>
<img src="images/icons/icon-realm.gif"><span><?php echo $lang["realms"] ?>:</span>
</h3>
<select id="filter" onchange="javascript: { if (this.value) arenaLadderPageInstance.followLink(this.value); }">
<!--<option selected value="#"></option>-->
<?php
foreach($realms as $key => $data)
    if ($data[0] > 1)
    {
        if (isset($_GET["realm"]) && $_GET["realm"] == $key)
            echo "<option selected value=\"index.php?searchType=team&type=", $type, "&realm=", $key, "&sortBy=", $orderField, "\">", $key, "</option>";
        else
            echo "<option value=\"index.php?searchType=team&type=", $type, "&realm=", $key, "&sortBy=", $orderField, "\">", $key, "</option>";
    }
?>
</select></em><em class="d-srt">
<h3>
<img src="images/icons/icon-sort.gif"><span>Sort:</span>
</h3>
<select id="sort" onchange="javascript: { if (this.value) arenaLadderPageInstance.followLink(this.value); }">
<!--<option selected value="#"></option>-->
<option <?php if ($_GET["sortBy"] == "wins2") {?>selected <?php } ?>value="index.php?searchType=team&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=wins2"><?php echo $lang["wins"] ?></option>
<option <?php if ($_GET["sortBy"] == "losses") {?>selected <?php } ?> value="index.php?searchType=team&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=losses"><?php echo $lang["losses"] ?></option>
<option <?php if ($_GET["sortBy"] == "rating") {?>selected <?php } ?> value="index.php?searchType=team&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=rating"><?php echo $lang["rating"] ?></option>
</select></em>
</div>
</div>
</div>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td>
<div>
<p></p>
</div>
</td><td width="8%"><a class="noLink"><?php echo $lang["rank"] ?></a></td>
<td width="10%"><a class="noLink"><?php echo $lang["emblem"] ?></a></td>
<td width="40%"><a class="noLink"><?php echo $lang["team_name"] ?></a></td>
<td width="10%" align="center"><a class="noLink"><?php echo $lang["faction"] ?></a></td>
<td width="10%" align="center"><a href="index.php?searchType=team&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=wins2"><?php echo $lang["wins"] ?></a></td>
<td width="10%" align="center"><a href="index.php?searchType=team&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=losses"><?php echo $lang["losses"] ?></a></td>
<td width="12%" align="center"><a href="index.php?searchType=team&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=rating"><?php echo $lang["rating"] ?></a></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
// Query //
//switchConnection("characters", REALM_NAME);
$pvpquery = execute_query("char", "SELECT at.`arenateamid`, at.`name`, `BackgroundColor`, `EmblemStyle`, `EmblemColor`, `BorderColor`, `rating`, `wins_season` as `wins2`, `games_season` - `wins_season` AS `losses`, `rank`, c.`name` AS captain_name, `race`
FROM `arena_team` AS at, `arena_team_stats` AS atm, `characters` AS c
WHERE at.`arenateamid` = atm.`arenateamid` AND `games_season` <> 0 AND `type` = ".$type." AND `captainguid` = c.`guid`".exclude_GMs().
" ORDER BY `".$orderField."` DESC LIMIT ".$config["TeamTop"]);
$i = 0;
foreach ($pvpquery as $team)
{
    $i ++;
    $team["faction"] = GetFaction($team["race"]);
    $team["captain_name"] = $team["captain_name"] ? $team["captain_name"] : $lang["unknown"];
    $teamMembers = execute_query("char", "SELECT COUNT(*) FROM `arena_team_member` WHERE `arenateamid` = ".$team["arenateamid"], 2);
?>
<tr>
<td>
<div>
<p></p>
</div>
</td><td><q><i><span class="veryplain"><?php echo ordinal_suffix($team["rank"]) ?></span></i></q></td>
<td><q><span id="emblem_<?php echo $i ?>"></span></q></td>
<td><q><?php echo guild_arenateam_tooltip_frame("team", $team["arenateamid"], $team["name"], $team["captain_name"], $teamMembers) ?></q></td>
<td align="center"><q><img width="20" height="20" src="images/icon-<?php echo $team["faction"] ?>.gif" onMouseOver="showTip('<?php echo $lang[$team["faction"]] ?>')" onmouseout="hideTip()"></q></td>
<td align="center"><q><i><span class="g"><?php echo $team["wins2"] ?></span></i></q></td>
<td align="center"><q><i><span class="r"><?php echo $team["losses"] ?></span></i></q></td>
<td align="center"><q><i><span class="veryplain"><?php echo $team["rating"] ?></span></i></q></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<script type="text/javascript">
printFlash("emblem_<?php echo $i ?>", "images/icons/team/pvpemblems.swf", "transparent", "", "#000000", "76", "100", "high", "", "totalIcons=1&initScale=25&overScale=75&overModifierX=40&overModifierY=0&startPointX=3&iconColor1=<?php echo emblem_color_convert($team['EmblemColor']) ?>&iconName1=images/icons/team/pvp-banner-emblem-<?php echo $team["EmblemStyle"] ?>.png&bgColor1=<?php echo emblem_color_convert($team['BackgroundColor']) ?>&borderColor1=<?php echo emblem_color_convert($team['BorderColor']) ?>&teamUrl1=", "")
</script>
<?php
}
?>
</table></div>
<?php
endcontenttable();
?>