<html>
<head>
<title>Cached page</title>
<head>
<body bgcolor="#CCCCCC">
	<h1>Testing Cesar D. Rodas' gCache Class</h1>
	<hr>
	<h2>Example of how to cache a sections of a page</h2>
	<hr>
<?php
include("safeIO.php");
include("gCache.php");
$cache = new gCache;
$cache->folder = "./cache/";
$cache->contentId=46;
$cache->timeout = 1;

if ($cache->Valid()) {
	echo $cache->content;
} else {
$cache->capture();
?>
This part of the page will change every minute. Last change at <?php echo date("Y/m/d H:i:s");?>
<hr>
<?php
$cache->endcapture();
}

$cache->contentId=47;
$cache->timeout = 5;

if ($cache->Valid()) {
	echo $cache->content;
} else {
$cache->capture();
?>
This part of the page will change every 5 minute. Last change at <?php echo date("Y/m/d H:i:s");?>
<?php for($i=0; $i < 50; $i++) { echo $i."<br/>"; }?>
<hr>
<?php  
$cache->endcapture();
}
?>
</body>
</html>