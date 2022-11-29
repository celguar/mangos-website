<?php
require "ajax-shared-functions.php";
require "../../configuration/defines.php";
// Check if any input is set //
if(!isset($_GET["searchQuery"]))
	$do_query = 0;
else
{
	$SearchQuery = validate_string($_GET["searchQuery"]);
	if(strlen($SearchQuery) >= $config["min_char_search"])
		$do_query = 1;
	else
		$do_query = 0;
}
if($do_query)
{
	$characters = array();
	session_start();
	//switchConnection("characters", REALM_NAME);
	$squery = execute_query("char", "SELECT `guid`, `level`, `gender`, `name`, `race`, `class` FROM `characters` WHERE `name` LIKE '%".change_whitespace($SearchQuery)."%'".exclude_GMs());
	$totalResults = $squery ? count($squery) : 0;
    if ($totalResults > 0)
    {
        foreach ($squery as $sresults)
        {
            $theGuid = $sresults["guid"];
            $theName = $sresults["name"];
            //$char_data = explode(" ",$sresults["data"]);
            $theLevel = $sresults["level"];
            $theRace = $sresults["race"];
            //$char_gender = $sresults["gender"];
            unset($char_data);
            //$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
            //$theGender = $char_gender{3};
            $theGender = $sresults["gender"];
            $theClass = $sresults["class"];
            $gquery = execute_query("char", "SELECT `guildid` FROM `guild_member` WHERE `guid` = ".$sresults["guid"]." LIMIT 1", 2);
            $theGuildId = $gquery ? $gquery : 0;
            $theFaction = GetFaction($theRace);
            $thePoints = GetCharacterAchievementPoints($theGuid);
            $characters[] = array($theGuid, $theName, $theLevel, $theRace, $theGender, $theClass, $theGuildId, $theFaction, $thePoints);
        }
	}
	if($totalResults > 0)
	{
		// Now output character data //
		$orders = array("name", "level", "guild", "race", "class", "faction", "achiev");
		$orderOppositeSort = array();
		$orderSymbol = array();
		$orderClassSuffix = array();
		foreach($orders as $val)
		{
			$orderOppositeSort[$val] = "DESC";
			$orderSymbol[$val] = "";
			$orderClassSuffix[$val] = "";
		}
		if(isset($_GET["orderBy"]))
		{
			// client is using an order by //
			$orderBy = addslashes($_GET["orderBy"]);
			$orderSort = addslashes($_GET["orderSort"]);
			if($orderBy == "name" || $orderBy == "level" || $orderBy == "guild" || $orderBy == "race" || $orderBy == "class" || $orderBy == "faction" || $orderBy == "achiev")
			{
				if($orderSort == "ASC")
				{
					$orderOppositeSort[$orderBy] = "DESC";
					$arrow = "down";
				}
				else
				{
					$orderOppositeSort[$orderBy] = "ASC";
					$arrow = "up";
				}
				$orderSymbol[$orderBy] = "<span class=\"sort ".$arrow."\"></span>";
				$orderClassSuffix[$orderBy] = "rating";
			}
		}
		else
			$orderBy = 2;
		$pages = ceil($totalResults / $config["results_per_page_char"]);
		if(isset($_GET["page"]))
			$pageNo = ValidatePageNumber((int) $_GET["page"], $pages);
		else
			$pageNo = 1;
?>
<span class="csearch-results-info"><?php echo $totalResults," ",$lang["results_for"] ?> <em><?php echo stripslashes($SearchQuery) ?></em> <?php echo $lang["in_realm"]," ",REALM_NAME ?>:</span><br />
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td>
<div>
<p></p>
</div>
</td>
<td width="20%"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=name&orderSort=",$orderOppositeSort["name"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-search-getresults.php')"><?php echo $lang["char_name"]," ",$orderSymbol["name"] ?></a></td>
<td width="12%" align="center"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=level&orderSort=",$orderOppositeSort["level"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-search-getresults.php')"><?php echo $lang["level"]," ",$orderSymbol["level"] ?></a></td>
<td width="8%" align="right"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=race&orderSort=",$orderOppositeSort["race"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-search-getresults.php')"><?php echo $lang["race"]," ",$orderSymbol["race"] ?></a></td>
<td width="8%" align="left"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=class&orderSort=",$orderOppositeSort["class"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-search-getresults.php')"><?php echo $lang["class"]," ",$orderSymbol["class"] ?></a></td>
<td width="12%" align="center"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=faction&orderSort=",$orderOppositeSort["faction"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-search-getresults.php')"><?php echo $lang["faction"]," ",$orderSymbol["faction"] ?></a></td>
<td width="30%"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=guild&orderSort=",$orderOppositeSort["guild"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-search-getresults.php')"><?php echo $lang["guild"]," ",$orderSymbol["guild"] ?></a></td>
<td width="10%"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=achiev&orderSort=",$orderOppositeSort["achiev"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-search-getresults.php')"><?php echo $lang["achievements"]," ",$orderSymbol["achiev"] ?></a></td>
<td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
		// Any ordering of the array $characters can occur here //
		if(!isset($orderSort))
		{
			$theSortId = 2;
			$theSortType = 1;
		}
		else
		{
			switch($orderBy)
			{
				case "name": $theSortId = 1; break;
				case "race": $theSortId = 3; break;
				case "class": $theSortId = 5; break;
				case "guild": $theSortId = 6; break;
				case "faction": $theSortId = 7; break;
				default: $theSortId = 2; // level
			}
			$theSortType = $orderSort == "DESC" ? 1 : 0;
		}
		$characters = asort2d($characters, $theSortId, $theSortType, 2);
		$chunks = array_chunk($characters, $config["results_per_page_char"], 1);
		$characters = $chunks[($pageNo - 1)];
		foreach($characters as $key => $data)
		{
?>
<tr>
<td>
<div>
<p></p>
</div>
</td><td class="<?php echo $orderClassSuffix["name"] ?>"><q><a href="index.php?searchType=profile&character=<?php echo $data[1]."&realm=".REALM_NAME ?>"><?php echo $data[1] ?></a></q></td>
<td align="center" class="<?php echo $orderClassSuffix["level"] ?>"><q><?php echo $data[2] ?></q></td>
<td align="right" class="<?php echo $orderClassSuffix["race"] ?>"><q><img src="images/icons/race/<?php echo $data[3]."-".$data[4] ?>.gif" onmouseover="showTip('<?php echo GetNameFromDB($data[3], "dbc_chrraces") ?>')" onmouseout="hideTip()"></q></td>
<td align="left" class="<?php echo $orderClassSuffix["class"] ?>"><q><img src="images/icons/class/<?php echo $data[5] ?>.gif" onmouseover="showTip('<?php echo GetNameFromDB($data[5], "dbc_chrclasses") ?>')" onmouseout="hideTip()"></q></td>
<td align="center" class="<?php echo $orderClassSuffix["faction"] ?>"><q><img src="images/icon-<?php echo $data[7] ?>.gif" width="20" height="20" onmouseover="showTip('<?php echo $lang[$data[7]] ?>')" onmouseout="hideTip()"></q></td>
<td class="<?php echo $orderClassSuffix["guild"] ?>"><q><?php echo guild_tooltip($data[6]) ?></q></td>
<td align="center" class="<?php echo $orderClassSuffix["achiev"] ?>"><q><span class="character-achievement"><a onmouseover="showTip('<?php echo $lang["achievements"]; ?>')" onmouseout="hideTip()" href="index.php?searchType=profile&charPage=achievements&character=<?php echo $data[1]."&realm=".REALM_NAME ?>"><?php echo $data[8] ?></a></span></q></td>
<td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
		}
?>
</table></div>
<div class="paging">
<div class="returned">
<span><span class=""><?php echo $lang["page"] ?>&nbsp;</span><span class="bold"><?php echo $pageNo ?></span><span class="">&nbsp;<?php echo $lang["of"] ?>&nbsp;</span><span class=""><?php echo $pages ?></span></span>
</div>
<?php
		echo BuildPageButtons($pageNo, $pages, "?searchQuery=".$SearchQuery."&realm=".addslashes(REALM_NAME), "source/ajax/ajax-search-getresults.php")
?>
</div>
<?php
	}
	else
	{
		// No Results for search //
?>
<span class="csearch-results-info">0 <?php echo $lang["results_for"] ?> <em><?php echo stripslashes($SearchQuery) ?></em> <?php echo $lang["in_realm"]," ",REALM_NAME ?>:</span><br />
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td>
<div>
<p></p>
</div>
</td><td width="30%"><a class="noLink"><?php echo $lang["char_name"] ?></a></td>
<td width="12%" align="center"><a class="noLink"><?php echo $lang["level"] ?></a></td>
<td width="8%" align="right"><a class="noLink"><?php echo $lang["race"] ?></a></td>
<td width="8%" align="left"><a class="noLink"><?php echo $lang["class"] ?></a></td>
<td width="12%" align="center"><a class="noLink"><?php echo $lang["faction"] ?></a></td>
<td width="30%"><a class="noLink"><?php echo $lang["guild"] ?></a></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<tr>
<td align="center" colspan="8"><?php echo $lang["no_results"] ?></td>
</tr>
</table></div>
<?php
	}
	print_exec_time_and_memory($script_start);
}
else
	echo "<span class=\"csearch-results-info\">Error, you either failed to provide a character name or your search string was too short (&lt;",$config["min_char_search"],"characters) or you used invalid symbols (only alphabetic characters, digits and whitespace are allowed - whitespace can be used as any symbol)</span>";
?>