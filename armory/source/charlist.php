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
<b class="icharacters">
<h4>
<a href="index.php?searchType=characters"><?php echo $lang["char_profiles"] ?></a>
</h4>
<h3><?php echo $lang["char_search"] ?></h3>
</b>
</blockquote>
<ul class="heading">
<img class="ieimg" src="images/pixel.gif"><li class="hleft"></li>
<li class="hcont">
<div class="generic-title">
<h1><?php echo $lang["search_for_profiles"] ?>:</h1>
</div>
</li>
<li class="hright"></li>
</ul>
<form action="index.php" method="get" name="formSearchCharacter" onsubmit="javascript: return menuCheckLength(document.formSearchCharacter);">
<div id="formSearchCharacter_errorSearchLength" style="position: relative; left: 150px; top: 150px; white-space: nowrap;"></div>
<input name="searchType" type="hidden" value="characters">
<input name="realm" type="hidden" value= "<?php echo DefaultRealmName ?>">
<p class="scroll-padding"></p>
<div class="scroll">
<div class="scroll-bot">
<div class="scroll-top">
<div class="scroll-right">
<div class="scroll-left">
<div class="scroll-bot-right">
<div class="scroll-bot-left">
<div class="scroll-top-right">
<div class="scroll-top-left">
<div class="header-cp">
<span><?php echo $lang["char_profiles"] ?></span>
</div>
<table class="scroll-content">
<tr>
<td><a class="title-cn"><span>Character Name</span></a></td><td><input maxlength="72" name="searchQuery" onblur="if (this.value=='') this.value=textEnterCharacterName" onfocus="this.value=''" size="16" type="text" value=""></td><td class="srch"><a class="scroll-search" onClick="javascript: return menuCheckLength(document.formSearchCharacter);"><span>Search</span></a></td>
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
</form>
<script type="text/javascript">
document.forms['formSearchCharacter'].searchQuery.value = textEnterCharacterName;
</script>
</div>
<?php
	endcontenttable();
}
else
{
?>
<script type="text/javascript">
	rightSideImage = "character";
	changeRightSideImage(rightSideImage);

	setcookie("cookieMenuText", "<?php echo $lang["characters"] ?>");
	document.getElementById('replaceSearchOption').innerHTML = "<?php echo $lang["characters"] ?>";
</script>
<?php
	startcontenttable();
?>
<div class="profile-wrapper">
<blockquote>
<b class="icharacters">
<h4>
<a href="index.php"><?php echo $lang["armory_search"] ?></a>
</h4>
<h3><?php echo $lang["char_profiles"] ?></h3>
</b>
</blockquote>
<?php
	// urlencode for IE Cyrillic compatibility
?>
<body onLoad="showResult('?searchQuery=<?php echo urlencode($_GET["searchQuery"]) ?>&realm=<?php echo urlencode(REALM_NAME) ?>','source/ajax/ajax-search-getresults.php')">
<div id="ajaxResult">
<span class="csearch-results-info"><?php echo $lang["search_result"] ?></span>
</div>
<?php
	endcontenttable();
}
?>