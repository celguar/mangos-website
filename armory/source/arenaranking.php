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
	if($orderField <> "arenapoints" && $orderField <> "personal_rating")
		$orderField = "personal_rating";
}
else
	$orderField = "personal_rating";
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
<a href="index.php?searchType=arena">Arena Rankings</a>
</h4>
<h3><?php echo "Arena ",$type,"v",$type," Top ",$config["ArenaTop"],": ",REALM_NAME ?></h3>
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
<option <?php if ($_GET["type"] == 2) {?>selected <?php } ?> value="index.php?searchType=arena&type=2&realm=<?php echo REALM_NAME,"&sortBy=",$orderField ?>">2v2</option>
<option <?php if ($_GET["type"] == 3) {?>selected <?php } ?> value="index.php?searchType=arena&type=3&realm=<?php echo REALM_NAME,"&sortBy=",$orderField ?>">3v3</option>
<option <?php if ($_GET["type"] == 5) {?>selected <?php } ?> value="index.php?searchType=arena&type=5&realm=<?php echo REALM_NAME,"&sortBy=",$orderField ?>">5v5</option>
</select></em><em class="d-rlm">
<h3>
<img src="images/icons/icon-realm.gif"><span><?php echo $lang["realms"] ?>:</span>
</h3>
<select id="filter" onchange="javascript: { if (this.value) arenaLadderPageInstance.followLink(this.value); }">
<?php
foreach($realms as $key => $data)
    if ($data[0] > 1)
    {
        if (isset($_GET["realm"]) && $_GET["realm"] == $key)
            echo "<option selected value=\"index.php?searchType=arena&type=",$type,"&realm=",$key,"&sortBy=",$orderField,"\">",$key,"</option>";
        else
            echo "<option value=\"index.php?searchType=arena&type=",$type,"&realm=",$key,"&sortBy=",$orderField,"\">",$key,"</option>";
    }
?>
</select></em><em class="d-srt">
<h3>
<img src="images/icons/icon-sort.gif"><span>Sort:</span>
</h3>
<select id="sort" onchange="javascript: { if (this.value) arenaLadderPageInstance.followLink(this.value); }">
<!--<option selected value="#"></option>-->
<option <?php if ($_GET["sortBy"] == "personal_rating") {?>selected <?php } ?> value="index.php?searchType=arena&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=personal_rating"><?php echo $lang["rating"] ?></option>
<option <?php if ($_GET["sortBy"] == "arenapoints") {?>selected <?php } ?> value="index.php?searchType=arena&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=arenapoints"><?php echo $lang["points"] ?></option>
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
</td><td width="5%"><a class="noLink"><?php echo $lang["pos"] ?></a></td>
<td width="25%"><a class="noLink"><?php echo $lang["char_name"] ?></a></td>
<td width="9%" align="center"><a class="noLink"><?php echo $lang["level"] ?></a></td>
<td width="6%" align="right"><a class="noLink"><?php echo $lang["race"] ?></a></td>
<td width="6%" align="left"><a class="noLink"><?php echo $lang["class"] ?></a></td>
<td width="9%" align="center"><a class="noLink"><?php echo $lang["faction"] ?></a></td>
<td width="20%"><a class="noLink"><?php echo $lang["arena_team"] ?></a></td>
<td width="10%" align="center"><a href="index.php?searchType=arena&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=personal_rating"><?php echo $lang["rating"] ?></a></td>
<td width="10%" align="center"><a href="index.php?searchType=arena&type=<?php echo $type,"&realm=",REALM_NAME ?>&sortBy=arenapoints"><?php echo $lang["points"] ?></a></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
// Query //
if($orderField == "arenapoints")
	$tablefield = "`arenaPoints`";
else//if($orderField == "personal_rating")
	$tablefield = "`personal_rating`";
//switchConnection("characters", REALM_NAME);
if (!isset($_GET["realm"]))
    initialize_realm("Burning Crusade");
$pvpquery = execute_query("char", "SELECT c.`guid`, c.`name`, `race`, `class`, `level`, `gender`, `arenaPoints`, atm.`arenateamid`, `personal_rating`, at.`name` AS arena_team_name, `captainguid`
FROM `characters` AS c, `arena_team_member` AS atm, `arena_team` AS at
WHERE c.`guid` = atm.`guid` AND atm.`arenateamid` = at.`arenateamid` AND `type` = ".$type.exclude_GMs().
" ORDER BY ".$tablefield." DESC LIMIT ".$config["ArenaTop"]);
$counter = 0;
foreach ($pvpquery as $char)
{
    $counter++;
    $char["arenapoints"] = $char["arenaPoints"];
    $char["faction"] = GetFaction($char["race"]);
    if(!isset($arenateamInfoTooltip[$char["arenateamid"]]))
    {
        //switchConnection("characters", REALM_NAME);
        if($teamCaptain = execute_query("char", "SELECT `name` FROM `characters` WHERE `guid` = ".$char["captainguid"]." LIMIT 1", 1))
            $teamCaptainName = $teamCaptain["name"];
        else
            $teamCaptainName = $lang["unknown"];
        $teamMembers = execute_query("char", "SELECT COUNT(*) FROM `arena_team_member` WHERE `arenateamid` = ".$char["arenateamid"], 2);
        $arenateamInfoTooltip[$char["arenateamid"]] = guild_arenateam_tooltip_frame("team", $char["arenateamid"], $char["arena_team_name"], $teamCaptainName, $teamMembers);
    }
    $char["arenateam_tooltip"] = $arenateamInfoTooltip[$char["arenateamid"]];
?>
<tr>
<td>
<div>
<p></p>
</div>
</td><td><q><i><span class="veryplain"><?php echo $counter ?></span></i></q></td>
<td><q><a href="index.php?searchType=profile&character=<?php echo $char["name"]."&realm=".REALM_NAME ?>" onmouseover="showTip('<?php echo $lang["char_link"] ?>')" onmouseout="hideTip()"><?php echo $char["name"] ?></a></q></td>
<td align="center"><q><i><span class="veryplain"><?php echo $char["level"] ?></span></i></q></td>
<td align="right"><q><img src="images/icons/race/<?php echo $char["race"],"-",$char["gender"] ?>.gif" onmouseover="showTip('<?php echo GetNameFromDB($char["race"], "dbc_chrraces") ?>')" onmouseout="hideTip()"></q></td>
<td align="left"><q><img src="images/icons/class/<?php echo $char["class"] ?>.gif" onmouseover="showTip('<?php echo GetNameFromDB($char["class"], "dbc_chrclasses") ?>')" onmouseout="hideTip()"></q></td>
<td align="center"><q><img width="20" height="20" src="images/icon-<?php echo $char["faction"] ?>.gif" onMouseOver="showTip('<?php echo $lang[$char["faction"]] ?>')" onmouseout="hideTip()"></q></td>
<td><q><?php echo $char["arenateam_tooltip"] ?></q></td>
<td align="center"><q><i><span class="veryplain"><?php echo $char["personal_rating"] ?></span></i></q></td>
<td align="center"><q><i><span class="veryplain"><?php echo $char["arenapoints"] ?></span></i></q></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
}
?>
</table></div>
<?php
endcontenttable();
?>