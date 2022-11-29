<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
$error = "";
if(!isset($_GET["item"]))
	$error = "If you are seeing this error message, you must have followed a bad link to this page.";
else
{
	$item_ID = (int) $_GET["item"];
	//switchConnection("mangos", REALM_NAME);
    if (CLIENT)
    {
        $itemData = execute_query("world", "SELECT `ItemLevel`, `BuyPrice`, `SellPrice`, `RequiredDisenchantSkill`, `RandomProperty`, `RandomSuffix`, `ItemLevel`, `InventoryType`, `DisenchantID`
FROM `item_template` WHERE `entry` = ".$item_ID." LIMIT 1", 1);
    }
    else
    {
        $itemData = execute_query("world", "SELECT `ItemLevel`, `BuyPrice`, `SellPrice`, `RandomProperty`, `ItemLevel`, `InventoryType`, `DisenchantID`
FROM `item_template` WHERE `entry` = ".$item_ID." LIMIT 1", 1);
    }
	if(!$itemData)
		$error = "Item with ID ".$item_ID." does not exist!";
}
if($error)
	showerror("item", $error);
else
{
	require "configuration/tooltipmgr.php";
	// START Functions
	function ShowPrice($Price, $buyorsell)
	{
	    global $lang;
		echo "<p><span>",$buyorsell ? $lang["cost"] : $lang["sells"],":</span>
		<br />
		<strong>";
		$Gold = floor($Price/10000);
		$Silver = floor(($Price-$Gold*10000)/100);
		$Copper = floor($Price-$Gold*10000-$Silver*100);
		if($Gold)
			echo $Gold,"<img class=\"pMoney\" src=\"images/icons/money-gold.gif\">";
		if($Silver)
			echo $Silver,"<img class=\"pMoney\" src=\"images/icons/money-silver.gif\">";
		if($Copper)
			echo $Copper,"<img class=\"pMoney\" src=\"images/icons/money-copper.gif\">";
		echo "&nbsp;</strong>
		</p>";
	}
	// END Functions
	//switchConnection("armory", REALM_NAME);
    $item_info = execute_query("armory", "SELECT `item_icon`, `item_quality` FROM `cache_item` WHERE `item_id` = ".$item_ID." AND `mangosdbkey` = ".$realms[REALM_NAME][2]." LIMIT 1", 1);
	if(!$item_info)
	{
		$item_cache = cache_item($item_ID);
		$itemData["icon"] = $item_cache["item_icon"];
		$itemData["quality"] = $item_cache["item_quality"];
	}
	else
	{
		$itemData["icon"] = $item_info["item_icon"];
		$itemData["quality"] = $item_info["item_quality"];
	}
	//switchConnection("armory", REALM_NAME);
    unset($item_info);
    $item_info = execute_query("armory", "SELECT `item_info_html` FROM `cache_item_tooltip` WHERE `item_id` = ".$item_ID." AND `mangosdbkey` = ".$realms[REALM_NAME][2]." LIMIT 1", 1);
	if(!$item_info)
	{
		$item_tooltip_cache = cache_item_tooltip($item_ID);
		$itemData["info_html"] = $item_tooltip_cache["item_info_html"];
	}
	else
		$itemData["info_html"] = $item_info["item_info_html"];
?>
<span style="display:none;">start</span><script type="text/javascript">
	rightSideImage = "item";
	changeRightSideImage(rightSideImage);
</script>
<div class="results-side-collapsed" id="results-side-switch">
<?php
	startcontenttable("team-side");
?>
<div class="profile-wrapper">
<style type="text/css">
.genericHeader { padding: 33px 0 0 0; }
.shadow-tip .myItemName, .item-double .myItemName	{ font-size:18px; font-family: Arial, Helvetica, sans-serif; }
.shadow-tip .myGold 		{ color: black;}
.shadow-tip .myOrange		{ color: black;}
.shadow-tip .myPurple		{ color: black;}
.shadow-tip .myBlue			{ color: black;}
.shadow-tip .myGray			{ color: black;}
.shadow-tip .myGreen		{ color: black;}
.shadow-tip .myYellow		{ color: black;}
.shadow-tip .myRed			{ color: black;}
.shadow-tip .myWhite		{ color: black;}
.shadow-tip .myTable		{ color: black;}
.shadow-tip .bonusGreen		{ color: black; }
.shadow-tip .myTable		{ color: black; }
.shadow-tip .bonusGreen		{ color: black; }
.shadow-tip .setNameYellow	{ color: black; font-size:11px; }
.shadow-tip .setItemYellow	{ color: black; }
.shadow-tip .setItemGray	{ color: black; }
.shadow-tip .tooltipContentSpecial	{ color: black; }
.item-double .myTable, .shadow-tip .myTable		{ font-size: 13px; line-height: 23px; }
</style>
<blockquote>
<b class="iitems">
<h4>
<a href="index.php?searchType=items"><?php echo $lang["items"] ?></a>
</h4>
<h3><?php echo $lang["item_search_result"] ?></h3>
</b>
</blockquote>
<div class="generic-wrapper">
<div class="generic-right">
<div class="genericHeader">
<div class="scroll" style="width: 100%;">
<div class="scroll-bot">
<div class="scroll-top">
<div class="scroll-right">
<div class="scroll-left">
<div class="scroll-bot-right">
<div class="scroll-bot-left">
<div class="scroll-top-right">
<div class="scroll-top-left">
<div class="item-padding">
<div class="displayTable">
<img height="250" src="images/pixel.gif" style="float: left;" width="1"><div class="icon-container">
<p></p>
<img class="p" src="<?php echo $itemData["icon"] ?>"></div>
<div class="alt-stats">
<div class="as-top">
<div class="as-bot">
<em></em>
<p>
<span><?php echo $lang["item_level"] ?>:</span>
<br />
<strong><?php echo $itemData["ItemLevel"] ?></strong>
</p>
<?php
	if($itemData["BuyPrice"])
	{
		$BuyPrice = $itemData["BuyPrice"];
		ShowPrice($BuyPrice, 1);
	}
	if($itemData["SellPrice"])
	{
		$SellPrice = $itemData["SellPrice"];
		ShowPrice($SellPrice, 0);
	}
	if (CLIENT)
	{
	    if($itemData["RequiredDisenchantSkill"] > -1)
	    {
	        $width = ($itemData["RequiredDisenchantSkill"]/375)*100;
?>
    <p><span><?php echo $lang["disenchantable"] ?>:</span>
        <br />
    <div class="skill-bar">
        <b style="width: <?php echo $width ?>%"></b>
        <img onMouseOut="javascript: hideTip();" onMouseOver="javascript: showTip('<?php echo $lang["requires"] ?> <strong><?php echo $itemData["RequiredDisenchantSkill"] ?></strong> <?php echo $lang["enchanting_to_disenchant"] ?>');" src="images/icons/icon-disenchant-sm.gif"><strong onMouseOut="javascript: hideTip();" onMouseOver="javascript: showTip('<?php echo $lang["requires"] ?> <strong><?php echo $itemData["RequiredDisenchantSkill"] ?></strong> <?php echo $lang["enchanting_to_disenchant"] ?>');"><?php echo $itemData["RequiredDisenchantSkill"] ?></strong>
        <?php
	    }
	}
?>

</div>
</p>
</div>
</div>
</div>
<div class="item-info">
<div class="item-bound">
<div class="item-double">
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td>
<?php
	echo $itemData["info_html"];
?>
</td>
</tr>
</tbody>
</table>
</div>
<div class="id">
<table>
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"><q></q></td><td class="bg">
<div class="id-pad">
<div class="shadow-tip">
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td>
<?php
	echo $itemData["info_html"];
?>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</td><td class="r"><q></q></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="item-related">
<?php
/******************************************************************************************************************************************************************/
// Random Enchantment
	if($config["ShowRandomEnch"] && ($itemData["RandomProperty"] || (CLIENT && $itemData["RandomSuffix"])))
	{
		if($itemData["RandomProperty"])
		{
			$randomtable = "dbc_itemrandomproperties";
			$randomentry = $itemData["RandomProperty"];
		}
		else //if($itemData["RandomSuffix"])
		{
			$randomtable = "dbc_itemrandomsuffix";
			$randomentry = $itemData["RandomSuffix"];
		}
		//switchConnection("mangos", REALM_NAME);
		$RandomQuery = execute_query("world", "SELECT * FROM `item_enchantment_template` WHERE `entry` = ".$randomentry);
		if($RandomQuery && count($RandomQuery))
		{
?>
<div class="scroll-padding"></div>
<div class="rel-tab">
<p class="rel-randomchant"></p>
<h3><?php echo $lang["random_enchantment"] ?></h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td>
<div>
<p></p>
</div>
</td><td width="25%"><a class="noLink"><?php echo $lang["enchantment"] ?></a></td><td width="60%"><a class="noLink"><?php echo $lang["effects"] ?></a></td><td width="15%" align="center"><a class="noLink"><?php echo $lang["chance"] ?></a></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
			//switchConnection("armory", REALM_NAME);
foreach ($RandomQuery as $Random)
    {
        $enchantment = execute_query("armory", "SELECT * FROM `".$randomtable."` where `id` = ".$Random["ench"]." LIMIT 1", 1);
        $enchantmentbonus="";
        for($i = 1; $i <= 3; $i ++)
        {
            if($enchantment["ref_spellitemenchantment_".$i])
            {
                $enchantmentbonus_name = execute_query("armory", "SELECT `name` FROM `dbc_spellitemenchantment` where `id` = ".$enchantment["ref_spellitemenchantment_".$i]." LIMIT 1", 2);
                if($enchantmentbonus)
                    $enchantmentbonus .=", ";
                if($itemData["RandomSuffix"])
                {
                    $suffixFactor = GenerateEnchSuffixFactor($itemData["ItemLevel"], $itemData["InventoryType"], $itemData["quality"]);
                    $enchantvalue = round($suffixFactor*($enchantment["enchvalue_".$i]/10000));
                    $enchantmentbonus_name = str_replace("\$i", $enchantvalue, $enchantmentbonus_name);
                }
                $enchantmentbonus .= $enchantmentbonus_name;
            }
        }
?>
<tr>
<td>
<div>
<p></p>
</div>
</td><td valign="top"><q>
<div class="enchantName">
<?php echo $enchantment["name"] ?><div class="enchantNameClone">
<?php echo $enchantment["name"] ?></div>
</div>
</q></td><td valign="top"><q><?php echo $enchantmentbonus ?></q></td><td align="center"><q><?php echo $Random["chance"] ?>%</q></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
			}
			echo "</table></div>";
		}
	}
/******************************************************************************************************************************************************************/
// Disenchant
	if($config["ShowDisenchant"])
	{
		if(((CLIENT && ($itemData["RequiredDisenchantSkill"] > -1)) || !CLIENT) && $itemData["DisenchantID"])
		{
			//switchConnection("mangos", REALM_NAME);
			$DisenchantLootQuery = execute_query("world", "SELECT * FROM `disenchant_loot_template` WHERE `entry` = ".$itemData["DisenchantID"]);
			if($DisenchantLootQuery && count($DisenchantLootQuery))
			{
?>
<div class="scroll-padding"></div>
<div class="rel-tab">
<p class="rel-de"></p>
<h3><?php echo $lang["disenchants_into"] ?></h3>
</div>
<div id="big-results" style="clear: both;">
<div class="data">
<table class="data-table">
<tr class="masthead">
<td>
<div>
<p></p>
</div>
</td><td colspan="2" style="width: 50%;"><a class="noLink"><?php echo $lang["name"] ?></a></td><td align="center"><a class="noLink"><?php echo $lang["drop_chance"] ?></a></td><td align="center"><a class="noLink"><?php echo $lang["count"] ?></a></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
foreach ($DisenchantLootQuery as $DisenchantLootDetail)
    {
        //switchConnection("armory", REALM_NAME);
        $DisenchantItemsDisplay = execute_query("armory", "SELECT `item_name`, `item_quality`, `item_icon` FROM `cache_item` WHERE `item_id` = ".$DisenchantLootDetail["item"]." AND `mangosdbkey` = ".$realms[REALM_NAME][2]." LIMIT 1", 1);
        if(!$DisenchantItemsDisplay)
        {
            $item_cache[$DisenchantLootDetail["item"]] = cache_item($DisenchantLootDetail["item"]);
            $DisenchantItemsDisplay["item_name"] = $item_cache[$DisenchantLootDetail["item"]]["item_name"];
            $DisenchantItemsDisplay["item_quality"] = $item_cache[$DisenchantLootDetail["item"]]["item_quality"];
            $DisenchantItemsDisplay["item_icon"] = $item_cache[$DisenchantLootDetail["item"]]["item_icon"];
        }
        //switchConnection("armory", REALM_NAME);
        if(!execute_query("armory", "SELECT `item_id` FROM `cache_item_tooltip` WHERE `item_id` = ".$DisenchantLootDetail["item"]." AND `mangosdbkey` = ".$realms[REALM_NAME][2]." LIMIT 1", 2))
            cache_item_tooltip($DisenchantLootDetail["item"]);
?>
<tr>
<td>
<div>
<p></p>
</div>
</td>
<td width="55"><img class="p43" onMouseOut="hideTip();" onmouseover="showTip('<?php echo $lang["loading"] ?>'); showTooltip(<?php echo $DisenchantLootDetail["item"],",",$realms[REALM_NAME][2] ?>)" src="<?php echo $DisenchantItemsDisplay["item_icon"] ?>"></td>
<td class="item-icon" width="50%"><q><a class="rarity<?php echo $DisenchantItemsDisplay["item_quality"] ?>" href="index.php?searchType=iteminfo&item=<?php echo $DisenchantLootDetail["item"],"&realm=",REALM_NAME ?>" onMouseOut="hideTip();" onmouseover="showTip('<?php echo $lang["loading"] ?>'); showTooltip(<?php echo $DisenchantLootDetail["item"],",",$realms[REALM_NAME][2] ?>)"><?php echo $DisenchantItemsDisplay["item_name"] ?></a><strong class="rarityShadow<?php echo $DisenchantItemsDisplay["item_quality"] ?>"><?php echo $DisenchantItemsDisplay["item_name"] ?></strong></q></td>
<td align="center"><q><?php echo GetChance($DisenchantLootDetail["ChanceOrQuestChance"]) ?></q></td>
<?php
					if($DisenchantLootDetail["mincountOrRef"] != $DisenchantLootDetail["maxcount"])
						echo "<td align=\"center\"><q>",$DisenchantLootDetail["mincountOrRef"]," - ",$DisenchantLootDetail["maxcount"],"</q></td>";
					else
						echo "<td align=\"center\"><q>",$DisenchantLootDetail["mincountOrRef"],"</q></td>";
?>
<td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
				}
				echo "</table></div>";
			}
			else if(((CLIENT && ($itemData["RequiredDisenchantSkill"] > -1)) || (!CLIENT && $itemData["DisenchantID"])) && $config["ShowError"])
				showerror("Disenchanting (DB error)", "Item <b>".$item_ID."</b> have RequiredDisenchantSkill <b>".$itemData["RequiredDisenchantSkill"]."</b> and DisenchantID <b>".$itemData["DisenchantID"]."</b> but have no records in <b>disenchant_loot_template</b> for entry <b>".$itemData["DisenchantID"]."</b> , please <b>report to GM</b>");
		}
		else if(((CLIENT && ($itemData["RequiredDisenchantSkill"] > -1)) || (!CLIENT && $itemData["DisenchantID"])) && $config["ShowError"])
			showerror("Disenchanting (DB error)", "Item <b>".$item_ID."</b> have RequiredDisenchantSkill <b>".$itemData["RequiredDisenchantSkill"]."</b> but DisenchantID  <b>0</b>, please <b>report to GM</b>");
	}
/******************************************************************************************************************************************************************/
// Owned by players
/******************************************************************************************************************************************************************/
// Sold By
$invq = execute_query("char", "SELECT `guid` as `guid` FROM `character_inventory` WHERE `item_template` = ".$item_ID." LIMIT 100");
	if($invq)
	{
        //$StatQuery = execute_query("char", "SELECT `guid`, `name`, `race`, `class`, `level`, `gender`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `stored_honorable_kills` as `totalKills`, `stored_honor_rating` as `totalHonor`, `honor_highest_rank` as `rank` FROM `characters` WHERE `name` = '".$request."'".exclude_GMs()." LIMIT 1", 1);
?>
</div>
</div>
<div class="scroll-padding"></div>
<div class="rel-tab">
<p class="rel-provided"></p>
<h3>Owned by <? echo count($invq) ?> players</h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td>
<div>
<p></p>
</div>
</td>
    <td width="30%"><a class="noLink"><?php echo $lang["char_name"] ?></a></td>
    <td width="12%" align="center"><a class="noLink"><?php echo $lang["level"] ?></a></td>
    <td width="8%" align="right"><a class="noLink"><?php echo $lang["race"] ?></a></td>
    <td width="8%" align="left"><a class="noLink"><?php echo $lang["class"] ?></a></td>
    <td width="12%" align="center"><a class="noLink"><?php echo $lang["faction"] ?></a></td>
    <td width="30%"><a class="noLink"><?php echo $lang["guild"] ?></a></td>
    <td>
<div>
<b></b>
</div>
</td>
</tr>
    <?php
    foreach ($invq as $charguid)
    {
    $char = execute_query("char", "SELECT `guid`, `level`, `gender`, `name`, `race`, `class` FROM `characters`
WHERE `guid` = ".$charguid["guid"]." LIMIT 1", 1);
    $char["guid"] = $charguid["guid"];
    $gquery = execute_query("char", "SELECT `guildid` FROM `guild_member` WHERE `guid` = ".$char["guid"]." LIMIT 1", 1);
    $char["guildid"] = $gquery ? $gquery["guildid"] : 0;
    $char["faction"] = GetFaction($char["race"]);
    ?>
        <tr>
            <td>
                <div>
                    <p></p>
                </div>
            </td><td><q><a style="text-align: center;" href="index.php?searchType=profile&character=<?php echo $char["name"]."&realm=".REALM_NAME ?>" onmouseover="showTip('<?php echo $lang["char_link"] ?>')" onmouseout="hideTip()"><strong><?php echo $char["name"] ?></strong></a></q></td>
            <td><q><?php echo guild_tooltip($char["guildid"]) ?></q></td>
            <td align="center"><q><i><span class="veryplain"><?php echo $char["level"] ?></span></i></q></td>
            <td align="center"><img class="ci" onmouseout="hideTip()" onMouseOver="showTip('<?php echo GetNameFromDB($char["race"], "dbc_chrraces") ?>')" src="images/icons/race/<?php echo $char["race"],"-",$char["gender"] ?>.gif"><img src="shared/wow-com/images/layout/pixel.gif" width="2">
                <img class="ci" onmouseout="hideTip()" onMouseOver="showTip('<?php echo GetNameFromDB($char["class"], "dbc_chrclasses") ?>')" src="images/icons/class/<?php echo $char["class"] ?>.gif"></td>
            <td align="center"><q><img width="20" height="20" src="images/icon-<?php echo $char["faction"] ?>.gif" onMouseOver="showTip('<?php echo $lang[$char["faction"]] ?>')" onmouseout="hideTip()"></q></td>
            <td><q><?php echo guild_tooltip($char["guildid"]) ?></q></td>
            <td>
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
	}
/******************************************************************************************************************************************************************/
// Sold By
if(false)
{
?>
        <div class="scroll-padding"></div>
        <div class="rel-tab">
            <p class="rel-provided"></p>
            <h3>Owned by</h3>
        </div>
        <div id="big-results" style="clear: both;">
            <div class="data" style="clear: both;">
                <table class="data-table">
                    <tr class="masthead">
                        <td>
                            <div>
                                <p></p>
                            </div>
                        </td><td><a class="noLink">Name</a></td><td align="center"><a class="noLink">Level</a></td><td><a class="noLink">Location</a></td><td align="right">
                            <div>
                                <b></b>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <p></p>
                            </div>
                        </td><td><q><span><i>Name</i></span></q></td><td align="center"><q>Level</q></td><td><q>Location</q></td><td align="right">
                            <div>
                                <b></b>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
            }
            /******************************************************************************************************************************************************************/
?>
</div>
<?php
	endcontenttable();
?>
<div class="rinfo">
</div>
</div>
<?php
}
?>