<?php
function get_forum_byid($id){
  global $DB;
  $result = $DB->selectRow("SELECT * FROM f_forums WHERE forum_id=?d",$id);
  return $result;
}
function get_topic_byid($id){
  global $DB;
  $result = $DB->selectRow("SELECT * FROM f_topics WHERE topic_id=?d",$id);
  return $result;
}
function get_post_byid($id){
  global $DB;
  $result = $DB->selectRow("SELECT * FROM f_posts WHERE post_id=?d",$id);
  return $result;
}
function get_last_forum_topic($id){
  global $DB;
  $result = $DB->selectRow("SELECT * FROM f_topics WHERE forum_id=?d ORDER BY last_post DESC LIMIT 1",$id);
  return $result;
}
function get_last_topic_post($id){
  global $DB;
  $result = $DB->selectRow("SELECT * FROM f_posts WHERE topic_id=?d ORDER BY posted DESC LIMIT 1",$id);
  return $result;
}
function get_post_pos($tid,$pid){
  global $DB;
  $result = $DB->selectCell("SELECT count(*) FROM f_posts WHERE topic_id=?d AND post_id<?d ORDER BY posted",$tid,$pid);
    /*
  foreach($result as $result_id){
    $post_c++;
        if($result_id==$pid)return $post_c;
  }
    */
  return $result;
}

function declension($int, $expressions)
{
    /*
     * Choost russion word declension based on numeric.
     */ 
    if (count($expressions) < 3) $expressions[2] = $expressions[1];
    settype($int, "integer");
    $count = $int % 100;
    if ($count >= 5 && $count <= 20) {
        $result = $expressions['2'];
    } else {
        $count = $count % 10;
        if ($count == 1) {
            $result = $expressions['0'];
        } elseif ($count >= 2 && $count <= 4) {
            $result = $expressions['1'];
        } else {
            $result = $expressions['2'];
        }
    }
    return $result;
}

function isValidChar($user)
{
    if(!isset($user['character_id']) || empty($user['character_id']) ||
       !isset($user['character_name']) || empty($user['character_name']))
    {
        return false;
    }
    return ($GLOBALS['CHDB']->selectCell('SELECT COUNT(1) AS cnt FROM `characters` WHERE `guid`=?d AND name=? AND account=?d',
                                         $user['character_id'], $user['character_name'], $user['id']) == 1);
}

$yesterday_ts = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
?>