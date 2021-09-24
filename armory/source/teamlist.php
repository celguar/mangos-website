<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
if(!isset($_GET["searchQuery"]))
{
	startcontenttable();
?>
<div class="profile-wrapper">
<blockquote>
<b class="iarenateams">
<h4>
<a href="index.php?searchType=arenateams"><?php echo $lang["arena_team_profiles"] ?></a>
</h4>
<h3><?php echo $lang["arena_team_search"] ?></h3>
</b>
</blockquote>
<ul class="heading">
<img class="ieimg" src="images/pixel.gif"><li class="hleft"></li>
<li class="hcont">
<div class="generic-title">
<h1><?php echo $lang["search_for_teams"] ?>:</h1>
</div>
</li>
<li class="hright"></li>
</ul>
<form action="index.php" method="get" name="formSearchArenaTeams" onsubmit="javascript: return menuCheckLength(document.formSearchArenaTeams);">
<div id="formSearchArenaTeams_errorSearchLength" style="position: relative; left: 150px; top: 150px; white-space: nowrap;"></div>
<p class="scroll-padding"></p>
<div class="scroll">
<div class="scroll-top">
<div class="scroll-bot">
<div class="scroll-right">
<div class="scroll-left">
<div class="scroll-bot-right">
<div class="scroll-bot-left">
<div class="scroll-top-right">
<div class="scroll-top-left">
<div class="header-tp">
<span><?php echo $lang["arena_team_profiles"] ?></span>
</div>
<table class="scroll-content">
<tr>
<td><a class="title-tn"><span></span></a></td><td><input maxlength="72" name="searchQuery" onblur="if (this.value=='') this.value=textEnterTeamName" onfocus="this.value=''" size="16" type="text" value=""></td><td class="srch"><a class="scroll-search" onClick="javascript: return menuCheckLength(document.formSearchArenaTeams);"><span>Search</span></a></td>
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
<input name="searchType" type="hidden" value="arenateams">
<input name="realm" type="hidden" value= "<?php echo DefaultRealmName ?>">
</form>
<script type="text/javascript">
document.forms['formSearchArenaTeams'].searchQuery.value = textEnterTeamName;
</script>
</div>
<?php
	endcontenttable();
}
else
{
?>
<script type="text/javascript">
	rightSideImage = "arena";
	changeRightSideImage(rightSideImage);

	setcookie("cookieMenuText", "<?php echo $lang["arena_teams"] ?>");
	document.getElementById('replaceSearchOption').innerHTML = "<?php echo $lang["arena_teams"] ?>";
</script>
<?php
	startcontenttable();
?>
<div class="profile-wrapper">
<blockquote>
<b class="iarenateams">
<h4>
<a href="index.php"><?php echo $lang["armory_search"] ?></a>
</h4>
<h3><?php echo $lang["arena_teams"] ?></h3>
</b>
</blockquote>
<body onLoad="showResult('?searchQuery=<?php echo urlencode($_GET["searchQuery"]) ?>&realm=<?php echo urlencode(REALM_NAME) ?>','source/ajax/ajax-teamlist-getresults.php')">
<div id="ajaxResult">
<span class="csearch-results-info"><?php echo $lang["search_result"] ?></span>
</div>
<?php
	endcontenttable();
}
?>