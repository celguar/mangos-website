<?php
require "ajax-shared-functions.php";
require "../../configuration/defines.php";
if(!isset($_GET["searchQuery"]))
	$do_query = 0;
else
{
	$SearchQuery = validate_string($_GET["searchQuery"]);
	if(strlen($SearchQuery) >= $config["min_guild_search"])
		$do_query = 1;
	else
		$do_query = 0;
}
if($do_query)
{
	$guilds = array();
	//switchConnection("characters", REALM_NAME);
	$gquery = execute_query("char", "SELECT `guildid`, `name`, `leaderguid` FROM `guild` WHERE `name` LIKE '%".change_whitespace($SearchQuery)."%'");
	$totalResults = $gquery ? count($gquery) : 0;
	if ($gquery)
    {
        foreach ($gquery as $gresults)
        {
            $theGuid = $gresults["guildid"];
            $theName = $gresults["name"];
            $theLeader = $gresults["leaderguid"];
            $theMembers = execute_query("char", "SELECT COUNT(*) FROM `guild_member` WHERE `guildid` = ".$gresults["guildid"], 2);
            $leaderdata = execute_query("char", "SELECT `name`, `race` FROM `characters` WHERE `guid` = ".$theLeader." LIMIT 1", 1);
            $theLeaderName = $leaderdata["name"];
            $theLeaderRace = $leaderdata["race"];
            $theFaction = GetFaction($theLeaderRace);
            $guilds[] = array($theGuid, $theName, $theLeaderName, $theMembers, $theFaction);
        }
    }
	if($totalResults)
	{
		// Now output guild data //
		$orders = array("name", "leader", "members", "faction");
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
			if($orderBy == "name" || $orderBy == "leader" || $orderBy == "members" || $orderBy == "faction")
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
		$pages = ceil($totalResults / $config["results_per_page_guild"]);
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
</td><td width="35%"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=name&orderSort=",$orderOppositeSort["name"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-guildlist-getresults.php')"><?php echo $lang["guild"]," ",$orderSymbol["name"] ?></a></td>
<td width="15%" align="center"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=faction&orderSort=",$orderOppositeSort["faction"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-guildlist-getresults.php')"><?php echo $lang["faction"]," ",$orderSymbol["faction"] ?></a></td>
<td width="35%"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=leader&orderSort=",$orderOppositeSort["leader"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-guildlist-getresults.php')"><?php echo $lang["leader"]," ",$orderSymbol["leader"] ?></a></td>
<td width="15%" align="center"><a href="#" onclick="showResult('?searchQuery=<?php echo $SearchQuery,"&page=",$pageNo,"&orderBy=members&orderSort=",$orderOppositeSort["members"],"&realm=",addslashes(REALM_NAME) ?>','source/ajax/ajax-guildlist-getresults.php')"><?php echo $lang["members"]," ",$orderSymbol["members"] ?></a></td></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<?php
		// Any ordering of the array $guilds can occur here //
		if(!isset($orderSort))
		{
			$theSortId = 3;
			$theSortType = 1;
		}
		else
		{
			switch($orderBy)
			{
				case "name": $theSortId = 1; break;
				case "leader": $theSortId = 2; break;
				case "faction": $theSortId = 4; break;
				default: $theSortId = 3; // members
			}
			$theSortType = $orderSort == "DESC" ? 1 : 0;
		}
		$guilds = asort2d($guilds, $theSortId, $theSortType, 3);
		$chunks = array_chunk($guilds, $config["results_per_page_guild"], 1);
		$guilds = $chunks[($pageNo - 1)];
		foreach($guilds as $key => $data)
		{
?>
<tr>
<td>
<div>
<p></p>
</div>
</td><td class="<?php echo $orderClassSuffix["name"] ?>"><q><a href="index.php?searchType=guildinfo&guildid=<?php echo $data[0],"&realm=",REALM_NAME ?>"><?php echo $data[1] ?></a></q></td>
<td align="center" class="<?php echo $orderClassSuffix["faction"] ?>"><q><img src="images/icon-<?php echo $data[4] ?>.gif" height="20" onmouseover="showTip('<?php echo $lang[$data[4]] ?>')" onmouseout="hideTip()"></q></td>
<td class="<?php echo $orderClassSuffix["leader"] ?>"><q><a href="index.php?searchType=profile&character=<?php echo $data[2],"&realm=",REALM_NAME ?>" onmouseover="showTip('<?php echo $lang["char_link"] ?>')" onmouseout="hideTip()"><?php echo $data[2] ?></a></q></td>
<td align="center" class="<?php echo $orderClassSuffix["members"] ?>"><q><?php echo $data[3] ?></q></td><td align="right">
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
<span><span class=""><?php echo $lang["page"]?>&nbsp;</span><span class="bold"><?php echo $pageNo ?></span><span class="">&nbsp;<?php echo $lang["of"] ?>&nbsp;</span><span class=""><?php echo $pages ?></span></span>
</div>
<?php
		echo BuildPageButtons($pageNo, $pages, "?searchQuery=".$SearchQuery."&realm=".addslashes(REALM_NAME), "source/ajax/ajax-guildlist-getresults.php")
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
</td><td width="35%"><a class="noLink"><?php echo $lang["guild"] ?></a></td>
<td width="15%" align="center"><a class="noLink"><?php echo $lang["faction"] ?></a></td>
<td width="35%"><a class="noLink"><?php echo $lang["leader"] ?></a></td>
<td width="15%" align="center"><a class="noLink"><?php echo $lang["members"] ?></a></td><td align="right">
<div>
<b></b>
</div>
</td>
</tr>
<tr>
<td align="center" colspan="6"><?php echo $lang["no_results"] ?></td>
</tr>
</table></div>
<?php
	}
	print_exec_time_and_memory($script_start);
}
else
	echo "<span class=\"csearch-results-info\">Error, you either failed to provide a guild name or your search string was too short (&lt; ",$config["min_guild_search"]," characters) or you used invalid symbols (only alphabetic characters, digits and whitespace are allowed - whitespace can be used as any symbol)</span>";
?>