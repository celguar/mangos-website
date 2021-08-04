<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>'Bugtracker','link'=>'');

$items_per_page = 20;
if((int)$MW->getConfig->generic_values->forum->bugs_forum_id == 0)output_message('alert','Please define forum id for bugtracker (in config/config.xml)');

$alltopics = $DB->select("
    SELECT f_topics.*,f_posts.* 
    FROM f_topics,f_posts 
    WHERE f_topics.forum_id=?d AND f_topics.topic_id=f_posts.topic_id AND f_topics.closed!=1 AND f_topics.sticky!=1
    GROUP BY f_topics.topic_id 
    ORDER BY topic_posted DESC,f_posts.posted 
    LIMIT ?d,?d",$bugs_forum_id,0,$items_per_page);

?>
