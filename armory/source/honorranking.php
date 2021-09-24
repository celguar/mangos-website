<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
if(isset($_GET["sortBy"]))
{
	$orderField = $_GET["sortBy"];
	if($orderField <> "honor" && $orderField <> "kills")
		CLIENT ? $orderField = "kills" : $orderField = "honor";
}
else
    CLIENT ? $orderField = "kills" : $orderField = "honor";

if (!CLIENT) {
    if (isset($_GET["faction"])) {
        $orderFaction = $_GET["faction"];
        if ($orderFaction <> "1" && $orderFaction <> "0")
            $orderFaction = "0";
    } else
        $orderFaction = "0";
}
?>
<script src="js/arena-ladder-ajax.js" type="text/javascript"></script>
<?php
startcontenttable();
?>
<div class="profile-wrapper">
<blockquote>
<b class="iarenateams">
<h4>
<a href="index.php?searchType=honor">Honor Rankings</a>
</h4>
<h3><?php echo "Honor Top ",(CLIENT ? config["PvPTop"] : "500"),": ",REALM_NAME ?></h3>
</b>
</blockquote>
<div class="generic-wrapper">
<div class="generic-right">
<div class="genericHeader ath">
<div class="arena-list">
    <em class="d-rlm">
        <h3>
            <img src="images/icons/icon-realm.gif"><span><?php echo $lang["realms"] ?>:</span>
        </h3>
        <select id="filter" onchange="javascript: { if (this.value) arenaLadderPageInstance.followLink(this.value); }">
            <!--<option selected value="#"></option>-->
            <?php
            foreach($realms as $key => $data) {
                if (isset($_GET["realm"]) && $_GET["realm"] == $key)
                    echo "<option selected value=\"index.php?searchType=honor&realm=", $key, "&sortBy=", ($data[0] == 1 ? "honor" : "kills"), "\">", $key, "</option>";
                else
                    echo "<option value=\"index.php?searchType=honor&realm=", $key, "&sortBy=", ($data[0] == 1 ? "honor" : "kills"), "\">", $key, "</option>";
            }
            ?>
        </select></em>
    <?php
    if (!CLIENT) {
        ?>
        <em class="d-rlm">
            <h3>
                <img src="images/icons/realm.gif"><span><?php echo $lang["faction"] ?>:</span>
            </h3>
            <select id="filter" onchange="javascript: { if (this.value) arenaLadderPageInstance.followLink(this.value); }">
                <!--<option selected value="#"></option>-->
                <?php
                $query = $_GET;
                $query['faction'] = "0";
                $query_alliance = http_build_query($query);
                $query['faction'] = "1";
                $query_horde = http_build_query($query);
                ?>
                <option <?php if ($orderFaction == "0") {?>selected <?php } ?> value="index.php?<?php echo $query_alliance ?>"><?php echo $lang["alliance"] ?></option>;
                <option <?php if ($orderFaction == "1") {?>selected <?php } ?> value="index.php?<?php echo $query_horde ?>"><?php echo $lang["horde"] ?></option>;

            </select></em>
        <img style="margin-top:12px;border-radius: 5px;width:163px!important;height: 36px!important;" src="images/pin-profile-<?php echo ($orderFaction == "0" ? "alliance" :  "horde"); ?>.gif">
    <?php } ?>
<em class="d-srt">
<h3>
<img src="images/icons/icon-sort.gif"><span>Sort:</span>
</h3>
<select id="sort" onchange="javascript: { if (this.value) arenaLadderPageInstance.followLink(this.value); }">
<!--<option selected value="#"></option>-->
<option <?php if ($orderField == "honor") {?>selected <?php } ?> value="index.php?searchType=honor&realm=<?php echo REALM_NAME ?>&sortBy=honor"><?php echo $lang["honor"] ?></option>
<option <?php if ($orderField == "kills") {?>selected <?php } ?> value="index.php?searchType=honor&realm=<?php echo REALM_NAME ?>&sortBy=kills"><?php echo $lang["kills"] ?></option>
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
<?php if (CLIENT) { ?>
</td><td width="5%"><a class="noLink"><?php echo $lang["pos"] ?></a></td>
<td width="25%"><a class="noLink"><?php echo $lang["char_name"] ?></a></td>
<td width="9%" align="center"><a class="noLink"><?php echo $lang["level"] ?></a></td>
<td width="6%" align="right"><a class="noLink"><?php echo $lang["race"] ?></a></td>
<td width="6%" align="left"><a class="noLink"><?php echo $lang["class"] ?></a></td>
<td width="9%" align="center"><a class="noLink"><?php echo $lang["faction"] ?></a></td>
<td width="20%"><a class="noLink"><?php echo $lang["guild"] ?></a></td>
<td width="10%" align="center"><a href="index.php?searchType=honor&realm=<?php echo REALM_NAME ?>&sortBy=kills"><?php echo $lang["kills"] ?></a></td>
<td width="10%" align="center"><a href="index.php?searchType=honor&realm=<?php echo REALM_NAME ?>&sortBy=honor"><?php echo $lang["honor"] ?></a></td><td align="right">
<?php } else { ?>
    </td><td align="center" width="13%"><a class="noLink"><?php echo $lang["standing"] ?></a></td>
    <td align="center" width="22%"><a class="noLink"><?php echo $lang["char_name"] ?></a></td>
    <td align="center" width="22%"><a class="noLink"><?php echo $lang["guild"] ?></a></td>
    <td width="4%" align="center"><a class="noLink"><?php echo $lang["level"] ?></a></td>
    <td width="13%" align="center"><a class="noLink"><?php echo $lang["race"],"/",$lang["class"] ?></a></td>
    <td width="34%" align="center"><a href="index.php?searchType=honor&realm=<?php echo REALM_NAME ?>&sortBy=kills"><?php echo $lang["honorable_kills"] ?></a></td>
    <td width="8%" align="center"><a href="index.php?searchType=honor&realm=<?php echo REALM_NAME ?>&sortBy=honor"><?php echo $lang["rating"] ?></a></td><td align="right">

<?php } ?>
<div>
<b></b>
</div>
</td>
</tr>
<?php
// Query //
if (CLIENT)
{
    if($orderField == "kills")
        $tablefield = "totalKills";
    else//if($orderField == "honor")
        $tablefield = "totalHonorPoints";
}
else
{
    if($orderField == "kills")
        $tablefield = "stored_honorable_kills";
    else//if($orderField == "honor")
        $tablefield = "stored_honor_rating";
}
if($orderField == "kills")
	$tablefield = "totalKills";
else//if($orderField == "honor")
	$tablefield = "totalHonorPoints";
//switchConnection("characters", REALM_NAME);
$pvpquery = false;
if (!CLIENT) // Classic
{
    $pvpquery = execute_query("char", "SELECT `guid`, `level`, `gender`, `name`, `race`, `class`, `stored_honorable_kills` as `totalKills`, `stored_honor_rating` as `totalHonorPoints`, `honor_highest_rank` as `rank`, `honor_standing`, `stored_dishonorable_kills` as `dishonor_kills` FROM `characters`
WHERE `stored_honor_rating` > 0 AND `race` IN (".($orderFaction == "0" ? "1,3,4,7" : "2,5,6,8").")".exclude_GMs().
        " ORDER BY ".$tablefield." DESC LIMIT 500");
}
else // tbc / wotlk
{
    $pvpquery = execute_query("char", "SELECT `guid`, `totalHonorPoints`, `totalKills`, `name`, `race`, `level`, `gender`, `class` FROM `characters`
WHERE ".$tablefield." > 0".exclude_GMs().
        " ORDER BY ".$tablefield." DESC LIMIT ".$config['PvPTop']);

}
if (CLIENT)
{
    $counter = 0;
foreach ($pvpquery as $char)
{
    $counter++;
    $char["kills"] = $char["totalKills"];
    $char["honor"] = $char["totalHonorPoints"];
    //switchConnection("characters", REALM_NAME);
    $gquery = execute_query("char", "SELECT `guildid` FROM `guild_member` WHERE `guid` = ".$char["guid"]." LIMIT 1", 1);
    $char["guildid"] = $gquery ? $gquery["guildid"] : 0;
    $char["faction"] = GetFaction($char["race"]);
?>
<tr>
<td>
<div>
<p></p>
</div>
</td><td><q><i><span class="veryplain"><?php echo $counter ?><sup><?php if ($counter == 1){echo $lang["st"];}elseif($counter == 2){echo $lang["nd"];}elseif($counter == 3){echo $lang["rd"];}else{echo $lang["th"];} ?></sup></span></i></q></td>
<td><q><a href="index.php?searchType=profile&character=<?php echo $char["name"]."&realm=".REALM_NAME ?>" onmouseover="showTip('<?php echo $lang["char_link"] ?>')" onmouseout="hideTip()"><?php echo $char["name"] ?></a></q></td>
<td align="center"><q><i><span class="veryplain"><?php echo $char["level"] ?></span></i></q></td>
<td align="right"><q><img src="images/icons/race/<?php echo $char["race"],"-",$char["gender"] ?>.gif" onmouseover="showTip('<?php echo GetNameFromDB($char["race"], "dbc_chrraces") ?>')" onmouseout="hideTip()"></q></td>
<td align="left"><q><img src="images/icons/class/<?php echo $char["class"] ?>.gif" onmouseover="showTip('<?php echo GetNameFromDB($char["class"], "dbc_chrclasses") ?>')" onmouseout="hideTip()"></q></td>
<td align="center"><q><img width="20" height="20" src="images/icon-<?php echo $char["faction"] ?>.gif" onMouseOver="showTip('<?php echo $lang[$char["faction"]] ?>')" onmouseout="hideTip()"></q></td>
<td><q><?php echo guild_tooltip($char["guildid"]) ?></q></td>
<td align="center"><q><i><span class="veryplain"><?php echo $char["kills"] ?></span></i></q></td>
<td align="center"><q><i><span class="veryplain"><?php echo $char["honor"] ?></span></i></q></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
}
}
else
{
    $counter = 0;
    foreach ($pvpquery as $char)
    {
        $counter++;
        $char["kills"] = $char["totalKills"];
        $char["honor"] = $char["totalHonorPoints"];
        $char["honor"] = round($char["honor"]);
        //switchConnection("characters", REALM_NAME);
        $gquery = execute_query("char", "SELECT `guildid` FROM `guild_member` WHERE `guid` = ".$char["guid"]." LIMIT 1", 1);
        $char["guildid"] = $gquery ? $gquery["guildid"] : 0;
        $char["faction"] = GetFaction($char["race"]);
        // calculate total kills
        if (!$char["kills"])
            $char["kills"] = 0;
        // new kills
        $temp_kills = execute_query("char", "SELECT COUNT(*) FROM `character_honor_cp` WHERE `guid`=".$char["guid"]." AND `victim_type` > '0' AND `type` = '1'", 2);
        // new + old kills
        $char["kills"] += $temp_kills;
        // calculate total dishonor kills
        if (!$char['dishonor_kills'])
            $char['dishonor_kills'] = 0;
        $temp_dishonor_kills = execute_query("char", "SELECT COUNT(*) FROM `character_honor_cp` WHERE `guid`=".$char["guid"]." AND `type` = '2'", 2);
        $char["dishonor_kills"] += $temp_dishonor_kills;
        $current_rank = execute_query("char", "SELECT `pvpRank` FROM `character_stats` WHERE `guid`=".$char["guid"], 2);
        if ($current_rank > 0)
            $char["rank"] = $current_rank;
        else
            $char["rank"] = $char["rank"] - 4;
        if ($char["rank"] < 0)
            $char["rank"] = 0;

        if ($char["rank"] == 0)
            continue;
        ?>
        <tr>
            <td>
                <div>
                    <p></p>
                </div>
            </td><td style="text-align: center;"><q><i><span class="veryplain"><?php echo $counter ?><sup><?php if ($counter == 1){echo $lang["st"];}elseif($counter == 2){echo $lang["nd"];}elseif($counter == 3){echo $lang["rd"];}else{echo $lang["th"];} ?></sup></span></i></q></td>
            <td><q><img onmouseover="showTip('<?php echo $lang["rank"], " ", $char["rank"] ?>')" onmouseout="hideTip()" style="height: 22px;margin-top: -10px;margin-bottom:-7px;margin-right:5px;padding-bottom: -20px;" src="images/icons/pvpranks/rank<?php echo $char["rank"]?>.gif"><a style="text-align: center;" href="index.php?searchType=profile&character=<?php echo $char["name"]."&realm=".REALM_NAME ?>" onmouseover="showTip('<?php echo $lang["char_link"] ?>')" onmouseout="hideTip()"><strong><?php echo $char["name"] ?></strong></a></q></td>
            <td><q><?php echo guild_tooltip($char["guildid"]) ?></q></td>
            <td align="center"><q><i><span class="veryplain"><?php echo $char["level"] ?></span></i></q></td>
            <td align="center"><img class="ci" onmouseout="hideTip()" onMouseOver="showTip('<?php echo GetNameFromDB($char["race"], "dbc_chrraces") ?>')" src="images/icons/race/<?php echo $char["race"],"-",$char["gender"] ?>.gif"><img src="shared/wow-com/images/layout/pixel.gif" width="2">
            <img class="ci" onmouseout="hideTip()" onMouseOver="showTip('<?php echo GetNameFromDB($char["class"], "dbc_chrclasses") ?>')" src="images/icons/class/<?php echo $char["class"] ?>.gif"></td>
            <td align="center"><q><i><span class="veryplain"><span class="g"><?php echo $char["kills"] ?></span><span> - </span><span class="r"><?php echo $char["dishonor_kills"] ?></span></span></i></q></td>
            <td align="center"><q><i><span class="veryplain"><span class="b"><?php echo $char["honor"] ?></span></span></i></q></td><td align="right">
                <div>
                    <b></b>
                </div>
            </td>
        </tr>
        <?php
    }
}
?>
</table></div>
<?php
endcontenttable();
?>