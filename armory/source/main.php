<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
?>
<script type="text/javascript">
	document.getElementById('divChains').className="top-anchor";
</script>
<div class="index">
<p class="dragon"></p>
<p class="stars2"></p>
<div class="armory-bg">
<script type="text/javascript">
	document.getElementById('indexChange1').className="home";
</script>
</div>
<?php
if($news)
{
?>
<div class="armory-news">
<div id="rDivNews"></div>
</div>
<script type="text/javascript">
var blah = new Array(); var i = 0;
<?php
	foreach($news as $value)
		echo "	blah[i] = \"<h1>",$value[0],"</h1> ",$value[1],"\"; i++;\n";
?>
	i = Math.round(Math.random()*100)%i;
	document.getElementById('rDivNews').innerHTML = blah[i];
</script>
<?php
}
?>
<script type="text/javascript">
	rightSideImage = "general";
	changeRightSideImage(rightSideImage);

function setArmorySearchFocus() {
document.formSearch.armorySearch.focus();
}

window.onload = setArmorySearchFocus;
</script>