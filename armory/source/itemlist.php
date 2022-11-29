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
<b class="iitems">
<h4>
<a href="index.php?searchType=items"><?php echo $lang["item_lookup"] ?></a>
</h4>
<h3><?php echo $lang["item_search"] ?></h3>
</b>
</blockquote>
<div class="generic-wrapper">
<div class="generic-right">
<div class="genericHeader">
<p class="items-icon"></p>
<div class="item-title"></div>
<form action="index.php" id="formItem" method="get" name="formItem" onSubmit="javascript: return menuCheckLength(document.formSearchItem);">
<div class="detail-search">
<div class="detail-search-top">
<div id="parentItemName"></div>
<div class="filter-left">
<div id="parentSource"></div>
<div id="parentSourceSub1"></div>
</div>
<div class="filter-right">
<div id="parentItemType"></div>
<div id="parentSingle"></div>
</div>
<div class="multi-filter">
<div id="parentMultiple"></div>
<div id="parentComplex"></div>
</div>
</div>
</div>
<div class="detail-search-bot"></div>
<div class="button-row">
<a class="button-red" href="javascript: submitForm();">
<p><?php echo $lang["search"] ?></p><?php echo $lang["search"] ?></a><a class="button-red" href="javascript: resetForms();">
<p><?php echo $lang["reset_form"] ?></p><?php echo $lang["reset_form"] ?></a><span class="shrb"></span>
</div>
<div class="item-errors" id="showHideError" style="display:none; ">
<div class="insert-error">
<em></em><span id="replaceError"></span>
</div>
</div>
<div class="item-errors" id="showHideError2" style="display:none; ">
<div class="insert-error">
<em></em><span id="replaceError2"></span>
</div>
</div>
<input name="searchType" type="hidden" value="items">
<input name="realm" type="hidden" value= "<?php echo DefaultRealmName ?>">
</form>
<form id="formPhantom" style="display: none; ">
<div id="divDelete"></div>
<div class="showFilter" id="divMultiple">
<span class="shr"></span>
</div>
<div class="filter-container" id="childItemName">
<div class="option-cont"><?php echo $lang["item_name"] ?>:</div>
<div class="input-cont" id="divSearchQuery">
<input id="searchQuery" name="searchQuery" type="text">
</div>
<!--<div class="see-also" id="divSeeAlso" style="display: none;">
<em class="a"></em><em class="b"></em><em class="c"></em><em class="d"></em>
<h2>See Also</h2>
<div id="replaceSeeAlso"></div>
</div>-->
</div>
<?php
//require "advitemsearch.html";
?>
</form>
<script src="js/items/functions.js" type="text/javascript"></script><script type="text/javascript">


  theCurrentForm = "default";

  cloneDelete('childItemName', 'parentItemName');
  cloneDelete('childItemType', 'parentItemType');
  cloneDelete('childSource', 'parentSource');

var currentAdvOpt = "";
var theCounter = 0;

  document.getElementById('parentAdvancedFilters').appendChild(document.getElementById('childAdvOptionsWeapon'));

  /* prepopulate the form */

  changetype('all');



  var advOptArray = new Array;




	for (y = 0; y < advOptArray.length; y++) {
		theString = advOptArray[y];
		theString = theString.split("_");
		addPredefinedAdvOpt(theString[0], theString);
	}

theCounter = 0;
searchText="black"
document.getElementById('searchQuery').value = "";

</script>
</div>
</div>
</div>
</div>
<?php
	endcontenttable();
}
else
{
?>
<script type="text/javascript">
	rightSideImage = "item";
	changeRightSideImage(rightSideImage);

	setcookie("cookieMenuText", "<?php echo $lang["items"] ?>");
	document.getElementById('replaceSearchOption').innerHTML = "<?php echo $lang["items"] ?>";
</script>
<?php
	startcontenttable();
?>
<div class="profile-wrapper">
<blockquote>
    <?php if ($_GET["searchType"] == "items") { ?>
<b class="iitems">
<?php }
if ($_GET["searchType"] == "upgrades") { ?>
<b class="iupgrade">
<?php } ?>
<h4>
<a href="index.php"><?php echo $lang["armory_search"] ?></a>
</h4>
    <?php
if ($_GET["searchType"] == "upgrades") { ?>
<h3><?php echo $lang["upgrades"] ?></h3>
<?php } ?>
    <?php if ($_GET["searchType"] == "items") { ?>
<h3><?php echo $lang["items"] ?></h3>
    <?php } ?>
</b>
</blockquote>
<body onLoad="showResult('?searchQuery=<?php echo urlencode($_GET["searchQuery"]); echo "&searchType=".urlencode($_GET["searchType"]); if (isset($_GET["specId"])) {echo "&specId=".urlencode($_GET["specId"]);} if (isset($_GET["level"])) {echo "&level=".urlencode($_GET["level"]);}?>&realm=<?php echo urlencode(REALM_NAME) ?>', 'source/ajax/ajax-items-getresults.php')">
<div id="ajaxResult">
<span class="csearch-results-info"><?php echo $lang["search_result"] ?></span>
</div>
<?php
	endcontenttable();
}
?>