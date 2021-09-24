<?php
// Set error reporting to only a few things.
ini_set('error_reporting', E_ERROR ^ E_NOTICE ^ E_WARNING);
error_reporting( E_ERROR | E_PARSE | E_WARNING ) ;
ini_set('log_errors',TRUE);
ini_set('html_errors',FALSE);
ini_set( 'display_errors', '0' ) ;
require "configuration/settings.php";
require "configuration/mysql.php";
require "configuration/functions.php";
require_once ( '../core/dbsimple/Generic.php' ) ;
session_start();
initialize_realm();
?>
<html>
<head>
<title></title>
<style type="text/css">
@import "css/<?php echo LANGUAGE ?>/language.css";
html {background:#000; text-align:center; color:#fff;}
a:link, a:visited, a:active {color:#ffc602; font:11px 'Trebuchet MS', Arial, Helvetica, sans-serif;}
a:hover {color:#fff; font:11px 'Trebuchet MS', Arial, Helvetica, sans-serif;}
.container {width:450px; margin:0 auto; padding:0;}
h1 {font:24px Georgia, "Times New Roman", Times, serif; margin:0; padding:0;}
ul {list-style:none; padding-left:125px; margin:1em 0; text-align:left;}
ul li {background:url(images/errorbullet.gif) 0 4px no-repeat; padding-left:20px; line-height:18px;}
</style>
</head>
<body class="errorpage">
<div class="container">
<h1>File not found.</h1>
<ul>
<li>
<a href="index.php">Return to the Armory</a>
</li>
</ul>
</div>
</body>
</html>