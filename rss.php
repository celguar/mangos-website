<?php
// Use our own DATE format constant because the PHP one seems to be bugged in some PHP versions
define('DATE_RFC822_FIXED', 'D, d M Y H:i:s O');

// Load mangosweb and settings
include('core/class.mangosweb.php');
$MW = new mangosweb; // Super global.

// Load and connect the database
include('core/dbsimple/Generic.php');
$DB = dbsimple_Generic::connect("".$MW->getDbInfo['db_type']."://".$MW->getDbInfo['db_username'].":".$MW->getDbInfo['db_password']."@".$MW->getDbInfo['db_host'].":".$MW->getDbInfo['db_port']."/".$MW->getDbInfo['db_name']."");

// Get the last time someone added a post (used to determine wheter we should write a new xml or not)
$last_posted_time = $DB->selectCell("SELECT posted FROM `f_posts` ORDER BY posted DESC LIMIT 0,1");

// Switch for wanted xml document.
// We use $_GET['type']. Default type will ( none ) Will print news.xml.
$type = isset($_GET['type']) ? $_GET['type'] : '';
switch($type)
{
	default:
		$xml_path = "core/cache/rss/news.xml";
		$write_new_file = (!file_exists($xml_path)) || ($last_posted_time > filemtime($xml_path)) || (filesize($xml_path)==0);

		// IF we need to write a new xml, compose a new one
		if($write_new_file)
		{
	        $f_forums = $DB->selectRow("SELECT * FROM `f_forums` WHERE forum_id='".(int)$MW->getConfig->generic_values->forum->news_forum_id."'");
	        $f_topics = $DB->select("SELECT * FROM `f_topics` WHERE forum_id='".(int)$MW->getConfig->generic_values->forum->news_forum_id."'");

	        $write_file = array();
	        $write_file[] = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
	        $write_file[] = "<rss version=\"2.0\">";
	        $write_file[] = "    <channel>";
	        $write_file[] = "        <title>".htmlspecialchars($f_forums['forum_name'])."</title>";
	        $write_file[] = "        <link>http://".(str_replace('rss.php','index.php',($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])))."</link>";
	        $write_file[] = "        <description>".htmlspecialchars($f_forums['forum_desc'])."</description>";
	        $write_file[] = "        <lastBuildDate>".date(DATE_RFC822_FIXED)."</lastBuildDate>";
	        $write_file[] = "        <language>en-us</language>";

			foreach($f_topics as $topic)
			{
				$f_posts = $DB->select("SELECT * FROM `f_posts` WHERE topic_id='".$topic['topic_id']."' ORDER BY posted ASC LIMIT 1");
				foreach($f_posts as $f_post)
				{
	                $write_file[] = "        <item>";
	                $write_file[] = "            <title>".htmlspecialchars($topic['topic_name'])."</title>";
	                $write_file[] = "            <link>http://".(str_replace('rss.php','index.php',($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])))."?n=forum&amp;sub=viewtopic&amp;tid=".$topic['topic_id']."&amp;p=1#post".$f_post['post_id']."</link>";
	                $write_file[] = "            <guid>http://".(str_replace('rss.php','index.php',($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])))."?n=forum&amp;sub=viewtopic&amp;tid=".$topic['topic_id']."&amp;p=1#post".$f_post['post_id']."</guid>";
	                $write_file[] = "            <pubDate>".(date(DATE_RFC822_FIXED, $f_post['posted']))."</pubDate>";
	                $write_file[] = "            <description>Posted by ".htmlspecialchars($f_post['poster']).": \n".htmlspecialchars($f_post['message'])."</description>";
	                $write_file[] = "        </item>";
				}
			}
			$write_file[] = "    </channel>";
			$write_file[] = "</rss>";
		}
	break;
	case 'forum_posts':
		$xml_path = "core/cache/rss/forum_posts.xml";
		$write_new_file = (!file_exists($xml_path)) || ($last_posted_time > filemtime($xml_path)) || (filesize($xml_path)==0);

		// IF we need to write a new xml, compose a new one
		if($write_new_file)
		{
			$f_topics = $DB->select("SELECT t.* FROM f_topics t LEFT JOIN f_forums f ON t.forum_id=f.forum_id WHERE f.hidden=0");

			$write_file = array();
			$write_file[] = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$write_file[] = "<rss version=\"2.0\">";
			$write_file[] = "    <channel>";
			$write_file[] = "        <title>Forums</title>";
			$write_file[] = "        <description>Forum</description>";
			$write_file[] = "        <link>http://".(str_replace('rss.php?type=forum_posts','index.php',($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])))."</link>";
			$write_file[] = "        <lastBuildDate>".(date(DATE_RFC822_FIXED))."</lastBuildDate>";
			$write_file[] = "        <language>en-us</language>";
			foreach($f_topics as $topic)
			{
				$f_posts = $DB->select("SELECT * FROM `f_posts` WHERE topic_id='".$topic['topic_id']."' ORDER BY posted ASC");

				foreach($f_posts as $f_post)
				{
					$write_file[] = "        <item>";
					$write_file[] = "            <title>".htmlspecialchars($f_post['poster'])."</title>";
					$write_file[] = "            <link>http://".(str_replace('rss.php?type=forum_posts','index.php',($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])))."?n=forum&amp;sub=viewtopic&amp;tid=".$topic['topic_id']."&amp;p=1#post".$f_post['post_id']."</link>";
					$write_file[] = "            <guid>http://".(str_replace('rss.php?type=forum_posts','index.php',($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])))."?n=forum&amp;sub=viewtopic&amp;tid=".$topic['topic_id']."&amp;p=1#post".$f_post['post_id']."</guid>";
					$write_file[] = "            <pubDate>".(date(DATE_RFC822_FIXED, $f_post['posted']))."</pubDate>";
					$write_file[] = "            <description>".htmlspecialchars($f_post['message'])."</description>";
					$write_file[] = "        </item>";
				}
			}
			$write_file[] = "    </channel>";
			$write_file[] = "</rss>";
		}
	break;
}

// IF we need to write a new xml! Then do this! Else, just load the written xml cache file
if ($write_new_file)
{
    $output = implode("\n", $write_file);
    if (!$handle = fopen($xml_path, 'w'))
	{
        echo "Cannot open file ($xml_path)";
        exit;
    }
    fwrite($handle, $output);
    fclose($handle);
}
else
{
    $output = file_get_contents($xml_path);
}

// Make this document XML and send it to the browser
header("Content-Type: text/xml");
echo $output;
?>
