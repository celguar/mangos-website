<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
?>
<script src="js/guild-roster-ajax.js" type="text/javascript"></script><script src="js/guild-stats-ajax.js" type="text/javascript"></script>
<script type="text/javascript">
	rightSideImage = "guild";
	changeRightSideImage(rightSideImage);
</script>
<?php
if(!isset($_GET["guildid"]))
{
	showerror("If you are seeing this error message,", "you must have followed a bad link to this page.");
	$do_query = 0;
}
else
{
	//switchConnection("characters", REALM_NAME);
	// The guild ID was set.. Now, get information on the guild //
	$guildId = (int) $_GET["guildid"];
    $guild = execute_query("char", "SELECT * FROM `guild` WHERE `guildid` = ".$guildId." LIMIT 1", 1);
	// If there were no results, the guild did not exist //
	if(!$guild)
	{
		showerror("Guild does not exist", "The guild with ID &quot;".$guildId."&quot; does not exist.");
		$do_query = 0;
	}
	else
	{
		// The guild exists //
		// Basic Information on Guild //
		// Get the guild leader if it exists //
		if(!$guild["leaderguid"])
		{
			// Guild has no master? err //
			showerror("&lt;Guild has no leader&gt;", "The guild with the ID &quot;".$guildId."&quot; has no leader.");
			$do_query = 0;
		}
		else
			$do_query = 1;
	}
}
if($do_query)
{
	// Return the leader of the guild //
    $gmdata = execute_query("char", "SELECT `name`, `race`, `class`, `level`, `gender` FROM `characters` WHERE `guid` = ".$guild["leaderguid"]." LIMIT 1", 1);
	$mlquery = execute_query("char", "SELECT * FROM `characters`, `guild_member` WHERE `characters`.`guid`=`guild_member`.`guid` and `guildid` = ".$guild["guildid"].exclude_GMs()." ORDER BY `rank` ASC");
	// Get number of members in guild //
	$guild_members = $mlquery ? count($mlquery) : 0;
	// Faction Info //
	// Member Data //
	$faction = GetFaction($gmdata["race"]);
?>
<div class="sub-head">
<div id="divCharTabs">
<div class="tabs">
<div class="hide">
<div class="select1">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" href="index.php?searchType=guildinfo&guildid=<?php echo $guildId,"&realm=",REALM_NAME ?>"><?php echo $lang["guild_roster"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<div class="select0">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" <?php //echo "href=\"#\"" ?>><?php echo $lang["guild_statistics"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
<div class="select0">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<div>
<a class="active" href="#">
<div style="display: block; float: left; vertical-align: baseline; margin-top: -3px;  width: 21px; height: 21px; background: url('images/tab-key-2.gif') no-repeat top left; margin-right: 4px;"></div><?php echo $lang["bank_contents"] ?></a>
</div>
</li>
<li class="tab-right"></li>
</ul>
</div>
<div class="select0">
<ul>
<li class="tab-left"></li>
<li class="tab-content">
<a class="active" href="#">
<div style="display: block; float: left; vertical-align: baseline; margin-top: -3px;  width: 21px; height: 21px; background: url('images/tab-key-2.gif') no-repeat top left; margin-right: 4px;"></div><?php echo $lang["bank_log"] ?></a>
</li>
<li class="tab-right"></li>
</ul>
</div>
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
<div>
<div class="generic-wrapper">
<div class="generic-right">
<div class="genericHeader">
<div style="margin-top: 10px;">
<div class="profile">
<div class="guildbanks-faction-<?php echo $faction ?>">
<div class="profile-left">
<div class="profile-right">
<div style="height: 140px; width: 100%;">
<div class="reldiv">
<div class="guildheadertext">
<div class="guild-details">
<div class="guild-shadow">
<table>
<tr>
<td>
<h1><?php echo $lang["guild"] ?>:&nbsp;<?php echo $guild["name"] ?></h1>
<h2><?php echo $guild_members ?>&nbsp;<?php echo $lang["members"] ?></h2>
<h1><?php echo $lang["master"] ?>:&nbsp;<?php echo $gmdata["name"] ?></h1>
<h2><?php echo $lang["faction"] ?>:&nbsp;<?php echo $lang[$faction] ?></h2>
</td>
</tr>
</table>
</div>
<div class="guild-white">
<table>
<tr>
<td>
<h1><?php echo $lang["guild"] ?>:&nbsp;<?php echo $guild["name"] ?></h1>
<h2><?php echo $guild_members ?>&nbsp;<?php echo $lang["members"] ?></h2>
<h1><?php echo $lang["master"] ?>:&nbsp;<?php echo $gmdata["name"] ?></h1>
<h2><?php echo $lang["faction"] ?>:&nbsp;<?php echo $lang[$faction] ?></h2>
</td>
</tr>
</table>
</div>
</div>
</div>
<div style="position: absolute; margin: 15px 0 0 0px; z-index: 10000;">
<a href="index.php?searchType=profile&character=<?php echo $gmdata["name"],"&realm=",REALM_NAME ?>"><img width="72" height="72" src="images/portraits/<?php echo GetCharacterPortrait($gmdata["level"], $gmdata["gender"], $gmdata["race"], $gmdata["class"]) ?>" class="profile-header-portrait-img-<?php echo $faction ?>" onmouseover="showTip('<?php echo $gmdata["name"],": ",$lang["level"]," ",$gmdata["level"]," ",GetNameFromDB($gmdata["race"], "dbc_chrraces")," ",GetNameFromDB($gmdata["class"], "dbc_chrclasses") ?>')" onmouseout="hideTip()"></a>
</div>
<div style="position: absolute; margin: 116px 0 0 0px;">
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
</div>
</div>
</div>
<div class="parch-profile-banner" id="banner" style="position: absolute;margin-left: 450px!important;margin-top: -110px!important;">
<h1 style="padding-top: 12px!important;"><?php echo $lang["guild_roster"] ?></h1>
</div>
</div>
<div class="filtercrest">
<a class="bluebutton" href="javascript: resetFilters();" id="loginreloadbutton" style="float: right;">
<div class="bluebutton-a"></div>
<div class="bluebutton-b">
<div class="reldiv">
<div class="bluebutton-color"><?php echo $lang["reset_filters"] ?></div>
</div><?php echo $lang["reset_filters"] ?></div>
<div class="bluebutton-reload"></div>
<div class="bluebutton-c"></div>
</a>
<div class="filtertitle" style="float: left;">
<img src="images/guildbank-arrow-light.gif"><?php echo $lang["guild_roster_filter"] ?></div>
</div>
<div class="arena-list">
<div class="filtercontainer">
<div class="clearfilterboxsm"></div>
<div class="bankcontentsfiltercontainer" style="width: 19%; float: left;">
<div class="bankcontentsfilter"><?php echo $lang["name"] ?>:<br />
<span><input class="guildbankitemname" id="inputName" onClick="javascript:this.select()" onKeyUp="javascript: gFname = this.value; filterArray();" size="12" style="width: 90px;" type="text"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 14%; float: left;">
<div class="bankcontentsfilter"><?php echo $lang["level"] ?>:<br />
<span><input class="guildbankitemname" id="inputMinlvl" onClick="javascript:this.select()" onKeyUp="javascript: gFminlvl = this.value; filterArray();" size="2" style="width: 16px; padding-left: 2px;" type="text" value="1"> - <input class="guildbankitemname" id="inputMaxlvl" onClick="javascript:this.select()" onKeyUp="javascript: gFmaxlvl = this.value; filterArray();" size="2" style="width: 16px; padding-left: 2px;" type="text" value="80"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 17%; float: left;">
<div class="bankcontentsfilter"><?php echo $lang["race"] ?>:<br />
<span id="divReplaceOptionRace"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 19%; float: right;">
<div class="bankcontentsfilter"><?php echo $lang["rank"] ?>:<br />
<span id="replaceOptionRank"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 15%;  float: right;">
<div class="bankcontentsfilter"><?php echo $lang["class"] ?>:<br />
<span id="divReplaceOptionClass"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 15%;  float: right;">
<div class="bankcontentsfilter"><?php echo $lang["gender"] ?>:<br />
<select class="bankselect" id="selectGender" onChange="gFgender = this.value; filterArray();" style="width: 70px;"><option value="-1"><?php echo $lang["both"] ?></option><option value="0"><?php echo $lang["male"] ?></option><option value="1"><?php echo $lang["female"] ?></option></select>
</div>
</div>
<div class="clearfilterboxsm"></div>
</div>
</div>
</div>
</div>
<div class="bottomshadow"></div>
</div>
</div>
<div style="padding: 0 0 20px 10px; clear:both; ">
<div class="filtertitle" style="font-size: 16px; letter-spacing: -1px; padding: 0;"><?php echo $lang["total_results"] ?>:&nbsp;<span id="replaceTotal"><?php echo $guild_members ?></span>
</div>
</div>
<center>
<div class="armory-news" id="showTooMany" style="display: none; ">
<div id="rDivNews">
<h1>
<p></p><?php echo $lang["note"] ?></h1>
</div>
</div>
</center>
<div class="paging">
<div id="replacePagesTop"></div>
</div>
<div>
<b><img height="1" src="images/pixel.gif" width="1"></b>
</div>
<div class="data" style="margin-top: 4px;">
<div id="replaceSearchTable"></div>
<script src="js/data.js" type="text/javascript"></script><script type="text/javascript">
	if ((is_opera || is_mac) && <?php echo $guild_members ?> > 600)
		document.getElementById('showTooMany').style.display = "block";
	var globalResultsPerPage = <?php echo $config["results_per_page_guild"] ?>;
</script><script src="js/paging/functions.js" type="text/javascript"></script><script type="text/javascript">	thisRaceArray = <?php echo $faction ?>RaceArray;
	replaceString = "";
	replaceString = '<select  class="bankselect" style="width: 80px;" id = "selectRace" onChange = "gFrace = this.value; filterArray();" name = "optionRace">';
	replaceString += '<option value = "-1"><?php echo $lang["all"] ?></option>';
	var raceArrayLength = thisRaceArray.length;
	for (d = 0; d < raceArrayLength; d++){
		replaceString += '<option value = "'+ thisRaceArray[d][1] +'">'+ thisRaceArray[d][0] +'</option>';
	}
	replaceString += '</select>';
	document.getElementById('divReplaceOptionRace').innerHTML = replaceString;
	replaceString = "";
	replaceString = '<select id = "selectClass"  class="bankselect" style="width: 70px;" onChange = "gFclass = this.value; filterArray();" name = "optionClass"><option value = "-1"><?php echo $lang["all"] ?></option>';
	for (d = 0; d < classStringArray.length; d++){
	replaceString +='<option value = "'+ classStringArray[d][1] +'">'+ classStringArray[d][0] +'</option>';
	}
	replaceString += '</select>';
	document.getElementById('divReplaceOptionClass').innerHTML = replaceString;
	var textMembers = "<?php echo $lang["member_name"] ?>";
	var textLevel = "<?php echo $lang["level"] ?>";
	var textRace = "<?php echo $lang["race"] ?>";
	var textClass = "<?php echo $lang["class"] ?>";
	var textGuildRank = "<?php echo $lang["guild_rank"] ?>";
	var theArray = new Array();
<?php
	$i = 0;
	foreach($mlquery as $cdata)
	{
        //$_char_data = explode(" ",$cdata["data"]);
        //$cdata["level"] = $_char_data[$defines["LEVEL"][CLIENT]];
        //$_char_gender = dechex($_char_data[$defines["GENDER"][CLIENT]]);
        //unset($_char_data);
        //$_char_gender = str_pad($_char_gender,8, 0, STR_PAD_LEFT);
        //$cdata["gender"] = $_char_gender{3};
        $grank = execute_query("char", "SELECT `rname` FROM `guild_rank` WHERE `guildid` = ".$guild["guildid"]." AND `rid`=".$cdata['rank'], 2);
        if ($grank)
            $cdata['rank_name'] = $grank;
        $i = $i + 1;
        echo "theArray[",$i," - 1] = [[\"&character=",$cdata["name"],"&realm=",REALM_NAME,"\"], [\"",$cdata["name"],"\"], [",$cdata["level"],"], [\"",$cdata["race"],"\", \"",$cdata["gender"],"\", \"",GetNameFromDB($cdata["race"], "dbc_chrraces"),"\"], [\"",$cdata["class"],"\", \"",GetNameFromDB($cdata["class"], "dbc_chrclasses"),"\"], [\"",$cdata["rank"],"\", \"",$cdata['rank_name'],"\"]]; \n";
    }
?>
	var gHighestRank = 0;
	for (var x = 0; x < theArray.length; x++) {
		if (gHighestRank < theArray[x][5][0])
			gHighestRank = theArray[x][5][0];
	}
	replaceString = '<select  class="bankselect" style="width: 100px;" id = "selectRank" onChange = "gFrank = this.value; filterArray();" name = "optionRank"><option value = "-1"><?php echo $lang["all_ranks"] ?></option>';
	replaceString += '<option value = "0"><?php echo $lang["guild_master"] ?></option>';
	for (d = 1; d <= gHighestRank; d++){
		replaceString +='<option value = "'+ d +'"><?php echo $lang["rank"] ?>  '+ d +'</option>';
	}
	replaceString += '</select>';
	document.getElementById('replaceOptionRank').innerHTML = replaceString;
	var globalResultsTotal = theArray.length;
	var globalPages = Math.ceil(globalResultsTotal/globalResultsPerPage);
	var savedArray = theArray.slice();
	var gFname = "";
	var gFminlvl = 1;
	var gFmaxlvl = 80;
	var gFrace = -1;
	var gFgender = -1;
	var gFclass = -1;
	var gFrank = -1;

	function resetFilters() {
		gFname = "";
		gFminlvl = 1;
		gFmaxlvl = 80;
		gFrace = -1;
		gFgender = -1;
		gFclass = -1;
		gFrank = -1;
		document.getElementById('inputName').value = "";
		document.getElementById('inputMinlvl').value = gFminlvl;
		document.getElementById('inputMaxlvl').value = gFmaxlvl;
		document.getElementById('selectRace').selectedIndex = 0;
		document.getElementById('selectClass').selectedIndex = 0;
		document.getElementById('selectGender').selectedIndex = 0;
		document.getElementById('selectRank').selectedIndex = 0;
		globalSort[0] = arrayCol.length;
		globalSort[1] = 'd';
		filterArray();
	}

	function filterArray() {
		if (gFminlvl > gFmaxlvl)
			return false;
		var counter = 0;
		for (var i = 0; i < savedArray.length; i++) {
			if (filterName(i) &&
				filterClass(i) &&
				filterRace(i) &&
				filterGender(i) &&
				filterRank(i) &&
				filterLevel(i)
			) {
				theArray[counter] = savedArray[i];
				counter++
			}
		}
		theArray.length = counter;
		globalPages = Math.ceil(counter/globalResultsPerPage);
		if (counter)
			setResultsPage(1);
		else
			elemRST.innerHTML = printSearchCol(arrayCol, globalSort[0], globalSort[1]) + "</table>\
			No Results Found";
		document.getElementById('replaceTotal').innerHTML = counter;
	}

	function filterName(whichOne) {
		if (gFname == "" || (savedArray[whichOne][1][0].toLowerCase()).match((gFname.toLowerCase())))
			return true;
		else
			return false;
	}

	function filterClass(whichOne) {
		if (gFclass == -1 || savedArray[whichOne][4][0] == gFclass)
			return true;
		else
			return false;
	}

	function filterRace(whichOne) {
		if (gFrace == -1 || savedArray[whichOne][3][0] == gFrace)
			return true;
		else
			return false;
	}

	function filterGender(whichOne) {
		if (gFgender == -1 || savedArray[whichOne][3][1] == gFgender)
			return true;
		else
			return false;
	}

	function filterLevel(whichOne) {
		if (gFminlvl <= savedArray[whichOne][2][0] && gFmaxlvl >= savedArray[whichOne][2][0])
			return true;
		else
			return false;
	}

	function filterRank(whichOne) {
		if (gFrank == -1 || savedArray[whichOne][5][0] == gFrank)
			return true;
		else
			return false;
	}

</script><script src="js/paging/guildRoster.js" type="text/javascript"></script><script type="text/javascript">
//
	setcookie("cookieRightPage", 1);
	var globalSort = [arrayCol.length, 'd'];
	var globalColSelected = new Array();
	clearColSelected();
	setColSelected(arrayCol.length);
	var replaceStringGuildBot = '</table>';
	setResultsPage(1, arrayCol.length, 'd');
//
</script>
</div>
<div class="paging" style="margin-top: 8px;">
<div id="replacePagesBot"></div>
</div>
<div>
<b><img height="1" src="images/pixel.gif" width="1"></b>
</div>
<script type="text/javascript">
	var elemRPB = document.getElementById('replacePagesBot');
	elemRPB.innerHTML = printPage(1);
	filterArray();
</script>
<?php
	endcontenttable();
?>
<div id="miniSearchElement">
<script type="text/javascript">
	//
	function value(a,b) {
		a = a[globalSort[0]] + a[0][0];
		b = b[globalSort[0]] + b[0][0];
		return a == b ? 0 : (a < b ? -1 : 1)
	}

	function valueAs(a,b) {
		a = a[globalSort[0]] + a[0][0];
		b = b[globalSort[0]] + b[0][0];
		return a == b ? 0 : (a < b ? 1 : -1)
	}

	function sortNumber(a, b) {
		return b[globalSort[0]][0] - a[globalSort[0]][0];
	}

	function sortNumberAs(a, b) {
		return a[globalSort[0]][0] - b[globalSort[0]][0];
	}

	var globalSort = new Array;

	function sortSearch2(whichElement) {
		if (whichElement < 0)
			whichElement = 0 - whichElement;
		globalSort[0] = whichElement;
		globalSort[1] = getcookie2("cookieLeftSortUD");
		if ((typeof rightArray[0][whichElement][0]) == 'string') {
			sortAs = valueAs;
			sortDe = value;
		} else {
			sortAs = sortNumberAs;
			sortDe = sortNumber;
		}
		if (globalSort[1] == 'u')
			rightArray.sort(eval(sortAs));
		else
			rightArray.sort(eval(sortDe));
	}
	//
</script>
</div>
<div class="rinfo">
</div>
<?php
}
?>