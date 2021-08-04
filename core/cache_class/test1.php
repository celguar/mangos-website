<?php
include("safeIO.php");
include("gCache.php");
$cache = new gCache;
$cache->folder = "./cache/";
$cache->contentId="var45";
$cache->timeout = 1;

if ($cache->Valid()) {
	echo $cache->content;
} else {
$cache->capture();
?>
<html>
<head>
<title>Cached page</title>
<head>
<body bgcolor="#CCCCCC">
	<h1>Testing Cesar D. Rodas' gCache Class</h1>
	<hr>
	<h2>Example of how to cache a hole page</h2>
	<hr>
<p>Basicaly what the gCache do, is to store a web-page or a portion of it into 
  a<em> <em>cache file</em>. </em>The <em><em>cache file</em></em> has a $timeout 
  in second of cache vitality, after that the cache will be re-created.</p>
<p>Also this class provides and locking system which is not depending of POSIX 
  or other OS, this feature becomes to this class very portable.</p>
<hr>
<font size="1">This cache page was generated at 
<?php echo date("Y/m/d H:i:s")?>
</font><font size="1"> by <a href="http://cesars.users.phpclasses.org/gcache">gCache</a> 
</font>
</body>
</html>
<?php
$cache->endcapture();
}
?>