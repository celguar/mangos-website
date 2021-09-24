<?php
require "ajax-shared-functions.php";
require "../../configuration/defines.php";
if(!isset($_GET["searchQuery"]))
	$do_query = 0;
else
{
	$SearchQuery = validate_string($_GET["searchQuery"]);
	if(strlen($SearchQuery) >= $config["min_arenateam_search"])
		$do_query = 1;
	else
		$do_query = 0;
}
if($do_query)
{
	$arenateams = array();
	//switchConnection("characters", REALM_NAME);
	$gquery = execute_query("char", "SELECT `arena_team`.`arenateamid`, `name`, `captainguid`, `type`, `rating` FROM `arena_team`, `arena_team_stats` WHERE `arena_team`.`arenateamid` = `arena_team_stats`.`arenateamid` AND `arena_team`.`name` LIKE '%".change_whitespace($SearchQuery)."%'");
	$totalResults = $gquery ? count($gquery) : 0;
	foreach ($gquery as $gresults)
    {
        $theGuid = $gresults["arenateamid"];
        $theName = $gresults["name"];
        $theType = $gresults["type"];
        $theRating = $gresults["rating"];
        $theCaptain = $gresults["captainguid"];
        $theMembers = execute_query("char", "SELECT COUNT(*) FROM `arena_team_member` WHERE `arenateamid` = ".$gresults["arenateamid"], 2);
        $captaindata = execute_query("char", "SELECT `name`, `race` FROM `characters` WHERE `guid` = ".$theCaptain." LIMIT 1", 1);
        $theCaptainName = $captaindata["name"];
        $theCaptainRace = $captaindata["race"];
        $theFaction = GetFaction($theCaptainRace);
        $arenateams[] = array($theGuid, $theName, $theCaptainName, $theMembers, $theFaction, $theType, $theRating);
    }

	if($totalResults)
	{
		// Now output arenateam data //
		$orders = array("name", "captain", "members", "faction", "type", "rating");
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
			if($orderBy == "name" || $orderBy == "captain" || $orderBy == "members" || $orderBy == "faction" || $orderBy == "type" || $orderBy == "rating")
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
		$pages = ceil($totalResults / $config["results_per_page_arenateam"]);
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
</td><td width="30%"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=name&orderSort=",$orderOppositeSort["name"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-teamlist-getresults.php')"><?php echo $lang["team_name"]," ",$orderSymbol["name"] ?></a></td>
<td width="10%" align="center"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=faction&orderSort=",$orderOppositeSort["faction"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-teamlist-getresults.php')"><?php echo $lang["faction"]," ",$orderSymbol["faction"] ?></a></td>
<td width="10%" align="center"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=type&orderSort=",$orderOppositeSort["type"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-teamlist-getresults.php')"><?php echo $lang["type"]," ",$orderSymbol["type"] ?></a></td>
<td width="30%"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=captain&orderSort=",$orderOppositeSort["captain"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-teamlist-getresults.php')"><?php echo $lang["captain"]," ",$orderSymbol["captain"] ?></a></td>
<td width="10%" align="center"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=members&orderSort=",$orderOppositeSort["members"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-teamlist-getresults.php')"><?php echo $lang["members"]," ",$orderSymbol["members"] ?></a></td>
<td width="10%" align="center"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=rating&orderSort=",$orderOppositeSort["rating"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-teamlist-getresults.php')"><?php echo $lang["rating"]," ",$orderSymbol["rating"] ?></a></td></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
		// Any ordering of the array $arenateams can occur here //
		if(!isset($orderSort))
		{
			$theSortId = 6;
			$theSortType = 1;
		}
		else
		{
			switch($orderBy)
			{
				case "name": $theSortId = 1; break;
				case "captain": $theSortId = 2; break;
				case "members": $theSortId = 3; break;
				case "faction": $theSortId = 4; break;
				case "type": $theSortId = 5; break;
				default: $theSortId = 6; // rating
			}
			$theSortType = $orderSort == "DESC" ? 1 : 0;
		}
		$arenateams = asort2d($arenateams, $theSortId, $theSortType, 6);
		$chunks = array_chunk($arenateams, $config["results_per_page_arenateam"], 1);
		$arenateams = $chunks[($pageNo - 1)];
		foreach($arenateams as $key => $data)
		{
?>
<tr>
<td>
<div>
<p></p>
</div>
</td><td class="<?php echo $orderClassSuffix["name"] ?>"><q><a href="index.php?searchType=teaminfo&arenateamid=<?php echo $data[0] ?>&realm=<?php echo REALM_NAME ?>"><?php echo $data[1] ?></a></q></td>
<td align="center" class="<?php echo $orderClassSuffix["faction"] ?>"><q><img src="images/icon-<?php echo $data[4] ?>.gif" height="20" onmouseover="showTip('<?php echo $lang[$data[4]] ?>')" onmouseout="hideTip()"></q></td>
<td align="center" class="<?php echo $orderClassSuffix["type"] ?>"><q><?php echo $data[5],"v",$data[5]?></q></td>
<td class="<?php echo $orderClassSuffix["captain"] ?>"><q><a href="index.php?searchType=profile&character=<?php echo $data[2] ?>&realm=<?php echo REALM_NAME ?>" onmouseover="showTip('<?php echo $lang["char_link"] ?>')" onmouseout="hideTip()"><?php echo $data[2] ?></a></q></td>
<td align="center" class="<?php echo $orderClassSuffix["members"] ?>"><q><?php echo $data[3] ?></q></td>
<td align="center" class="<?php echo $orderClassSuffix["rating"] ?>"><q><?php echo $data[6] ?></q></td><td align="right">
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
		echo BuildPageButtons($pageNo, $pages, "?searchQuery=".$SearchQuery."&realm=".addslashes(REALM_NAME), "source/ajax/ajax-teamlist-getresults.php")
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
</td><td width="30%"><a class="noLink"><?php echo $lang["team_name"] ?></a></td>
<td width="10%" align="center"><a class="noLink"><?php echo $lang["faction"] ?></a></td>
<td width="10%" align="center"><a class="noLink"><?php echo $lang["type"] ?></a></td>
<td width="30%"><a class="noLink"><?php echo $lang["captain"] ?></a></td>
<td width="10%" align="center"><a class="noLink"><?php echo $lang["members"] ?></a></td>
<td width="10%" align="center"><a class="noLink"><?php echo $lang["rating"] ?></a></td><td align="right">
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
	echo "<span class=\"csearch-results-info\">Error, you either failed to provide a arena team name or your search string was too short (&lt; ",$config["min_arenateam_search"]," characters) or you used invalid symbols (only alphabetic characters, digits and whitespace are allowed - whitespace can be used as any symbol)</span>";
?>