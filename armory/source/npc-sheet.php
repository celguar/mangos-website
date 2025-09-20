<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
// Profile banner
/*<div class="parch-profile-banner" id="banner" style="margin-top: -2px!important;">
<h1 style="padding-top: 12px!important;"><?php echo $lang["profile"] ?></h1>
</div>*/
if (!$data["title"]) {
    ?>
    <div class="parch-profile-banner" id="banner"
         style="position: absolute;margin-left: 450px!important;margin-top: -110px!important;">
        <h1 style="padding-top: 12px!important;"><?php echo $lang["profile"] ?></h1>
    </div>

    <?php
}
?>
</ul>
</div>

<?php
echo "</br></br></br>";

// Equipment
for ($k = 1; $k < 4; $k++) {
    if ($stat["equip".$k])
    {
        $itemid = $stat["equip".$k];
        if ($k == 1)
            echo "<br/><h1><b>Main Hand Weapon: ".$itemid."</b></h1>";
        if ($k == 2)
            echo "<br/><h1><b>Off Hand Weapon: ".$itemid."</b></h1>";
        if ($k == 3)
            echo "<br/><h1><b>Ranged Weapon: ".$itemid."</b></h1>";
        $doquery_pls_gm = execute_query("armory", "SELECT * FROM `cache_item_search` WHERE `item_id` =".$itemid." AND `mangosdbkey` = ".$realms[REALM_NAME][2]);
        $TotalCachedItems = ($doquery_pls_gm ? count($doquery_pls_gm) : 0);
        $item_search_cache = array();
        $isUpgrades = false;
        if ($TotalCachedItems)
        {
            foreach ($doquery_pls_gm as $result_pls_gm)
            {
                $item_search_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
                $Items[] = array($result_pls_gm["item_id"], $result_pls_gm["item_name"], $result_pls_gm["item_level"], $result_pls_gm["item_source"], ($isUpgrades ? $itemScores[$result_pls_gm["item_id"]] : $result_pls_gm["item_relevance"]));
            }
        }
        if($config["locales"])
            $ItemsQuery = execute_query("world", "SELECT `entry` FROM `locales_item` WHERE `entry` = ".$itemid."");
        else
            $ItemsQuery = execute_query("world", "SELECT `entry` FROM `item_template` WHERE `entry` = ".$itemid."");

        $TotalItems = ($ItemsQuery ? count($ItemsQuery) : 0);
        if($TotalItems > $TotalCachedItems)
        {
            foreach ($ItemsQuery as $ItemInfo)
            {
                if(!isset($item_search_cache[$ItemInfo["entry"]]))
                {
                    $item_search_cache[$ItemInfo["entry"]] = cache_item_search($ItemInfo["entry"]);
                    $Items[] = array($ItemInfo["entry"], $item_search_cache[$ItemInfo["entry"]]["item_name"], $item_search_cache[$ItemInfo["entry"]]["item_level"], $item_search_cache[$ItemInfo["entry"]]["item_source"], ($isUpgrades ? $itemScores[$ItemInfo["entry"]] : $item_search_cache[$ItemInfo["entry"]]["item_relevance"]));
                }
            }
            //while($ItemInfo = mysql_fetch_assoc($ItemsQuery))
            //{
            //	if(!isset($item_search_cache[$ItemInfo["entry"]]))
            //	{
            //		$item_search_cache[$ItemInfo["entry"]] = cache_item_search($ItemInfo["entry"]);
            //		$Items[] = array($ItemInfo["entry"], $item_search_cache[$ItemInfo["entry"]]["item_name"], $item_search_cache[$ItemInfo["entry"]]["item_level"], $item_search_cache[$ItemInfo["entry"]]["item_source"], $item_search_cache[$ItemInfo["entry"]]["item_relevance"]);
            //	}
            //}
        }
        unset($item_search_cache);
        if($TotalItems)
        {
            $visible_item_ids = "";
            foreach($Items as $Key => $Data)
                $visible_item_ids .= $Data[0].",";
            $visible_item_ids .= "0";

            $doquery_pls_gm = execute_query("armory", "SELECT * FROM `cache_item` WHERE `item_id` IN (".$visible_item_ids.") AND `mangosdbkey` = ".$realms[REALM_NAME][2]);
            $item_cache = array();
            foreach ($doquery_pls_gm as $result_pls_gm)
                $item_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
            foreach ($item_cache as $item)
                $item["item_relevance"] = $itemScores[$item["item_id"]];
            //while($result_pls_gm = mysql_fetch_assoc($doquery_pls_gm))
            //	$item_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
            //switchConnection("armory", REALM_NAME);
            $doquery_pls_gm = execute_query("armory", "SELECT `item_id` FROM `cache_item_tooltip` WHERE `item_id` IN (".$visible_item_ids.") AND `mangosdbkey` = ".$realms[REALM_NAME][2]);
            $item_tooltip_cache = array();
            foreach ($doquery_pls_gm as $result_pls_gm)
                $item_tooltip_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
            //while($result_pls_gm = mysql_fetch_assoc($doquery_pls_gm))
            //	$item_tooltip_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
            echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
            foreach($Items as $Key => $Data)
            {
                if(!isset($item_cache[$Data[0]]))
                    $item_cache[$Data[0]] = cache_item($Data[0]);
                $item_icon = $item_cache[$Data[0]]["item_icon"];
                $item_quality = $item_cache[$Data[0]]["item_quality"];
                if(!isset($item_tooltip_cache[$Data[0]]))
                    cache_item_tooltip($Data[0]);

                ?>
                <!--<img style="height: 70px;position:absolute; padding-top: <?php /*echo $k * 2*/?>px; padding-left: 250px;" src="https://classicdb.ch/itemmodels/item_<?php /*echo $stat["equip".$k."_display"]*/?>.jpg"></img>-->
                &nbsp &nbsp <img style="height: 100px;position:absolute; padding-top: <?php echo $k * 2?>px; padding-left: 250px;" src="https://wow.zamimg.com/modelviewer/tbc/webthumbs/item/<?php echo ($stat["equip".$k."_display"] & 255)?>/<?php echo $stat["equip".$k."_display"]?>.webp"></img>
                </br>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <span><img class="ci" height="50" onMouseOut="hideTip();" onmouseover="showTip('<?php echo $lang["loading"] ?>'); showTooltip(<?php echo $Data[0],",",$realms[REALM_NAME][2] ?>)" src="<?php echo $item_icon ?>"> <a class="rarity<?php echo $item_quality ?>" href="index.php?searchType=iteminfo&item=<?php echo $Data[0],"&realm=",REALM_NAME ?>" onMouseOut="hideTip();" onmouseover="showTip('<?php echo $lang["loading"] ?>'); showTooltip(<?php echo $Data[0],",",$realms[REALM_NAME][2] ?>)"><?php echo $Data[1] ?></a></q></span>
                </br>
                <?php
            }
        }
        unset($Items);
    }
}
for ($j = 1; $j < 5; $j++) {
    if ($stat["model".$j] == 0)
        continue;

    echo "<br></br><div style='border: 2px solid #000000;'></div><h1><b>Model</b> #$j (".$stat["model".$j]."):</h1>";
    ?>
    <img style="height: 230px;position:absolute; padding-top: <?php echo $j * 20?>px; padding-left: 590px;" src="https://classicdb.ch/models/<?php echo $stat["model1"]?>.gif"></img>
    <?php
for($i = 1; $i < 11; $i++) {
    echo "</br> <h2>&nbsp &nbsp Slot #".$i.": ";
    //echo GetCreatureItemSlotName($i);
  $displayId = $stat["model".$j."_info"]["item".$i];
  $item_icon = $stat["model".$j."_info"]["icon".$i];
  if ($displayId == 0)
      $item_icon = "images/icons/64x64/inv_misc_questionmark.png";
    ?>
    <!--<img style="height: 70px;position:absolute; padding-top: <?php /*echo $j * 2*/?>px; padding-left: 190px;" src="https://classicdb.ch/itemmodels/item_<?php /*echo $displayId*/?>.jpg"></img>-->
    &nbsp &nbsp <img style="height: 100px;position:absolute; padding-top: <?php echo $k * 2?>px; padding-left: 250px;" src="https://wow.zamimg.com/modelviewer/tbc/webthumbs/item/<?php echo ($displayId & 255)?>/<?php echo $displayId?>.webp"></img>
    <?php
  ?>
<span><img class="ci" height="50" onMouseOut="hideTip();" onmouseover="showTip('<?php echo ($displayId != 0) ? $displayId : 'No Item' ?>')" src="<?php echo $item_icon ?>"> <a href="" onMouseOut="hideTip();" onmouseover="showTip('<?php echo $lang["loading"] ?>'); showTooltip(<?php echo $feed["data"],",",$realms[REALM_NAME][2] ?>)"><?php echo $item_cache[$feed["data"]]["item_name"]; ?></a></q></span>
<?php
    if ($displayId != 0)
        echo $displayId;
    echo " - ";
    echo GetCreatureItemSlotName($i)."</h2>";
    if (isset($stat["model".$j."_info"]["same_display_ids"][$i]))
    {
        echo "</br></br> &nbsp &nbsp &nbsp &nbsp <b>Display IDs with same Textures:</b> </br>";
        foreach($stat["model".$j."_info"]["same_display_ids"][$i] as $same_display_id)
        {
            ?>
            <!--<img style="height: 70px;position:absolute; padding-top: <?php /*echo $j * 2*/?>px; padding-left: 190px;" src="https://classicdb.ch/itemmodels/item_<?php /*echo $same_display_id*/?>.jpg"></img>-->
            &nbsp &nbsp <img style="height: 100px;position:absolute; padding-top: <?php echo $k * 2?>px; padding-left: 250px;" src="https://wow.zamimg.com/modelviewer/tbc/webthumbs/item/<?php echo ($same_display_id & 255)?>/<?php echo $same_display_id?>.webp"></img>
            <?php
            $icon = GetIcon("item", $same_display_id);
            echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
            ?>
            <span><img style="top:10px;" class="ci" height="50" onMouseOut="hideTip();" onmouseover="showTip('<?php echo ($same_display_id != 0) ? $same_display_id : 'No Item' ?>')" src="<?php echo $icon ?>"> <a href="" onMouseOut="hideTip();" onmouseover="showTip('<?php echo $lang["loading"] ?>'); showTooltip(<?php echo $feed["data"],",",$realms[REALM_NAME][2] ?>)"><?php echo $item_cache[$feed["data"]]["item_name"]; ?></a></q></span>
            <?php
            echo $same_display_id."</br></br></br>";
        }
    }
    if (isset($stat["model".$j."_info"]["items_with_display"][$i]))
    {
        if (sizeof($stat["model".$j."_info"]["items_with_display"][$i]) != 0)
            echo "</br></br> &nbsp &nbsp &nbsp &nbsp <b>Items with Display ID #".$displayId.":</b> </br>";
        foreach ($stat["model".$j."_info"]["items_with_display"][$i] as $itemid)
        {
            $doquery_pls_gm = execute_query("armory", "SELECT * FROM `cache_item_search` WHERE `item_id` =".$itemid." AND `mangosdbkey` = ".$realms[REALM_NAME][2]);
            $TotalCachedItems = ($doquery_pls_gm ? count($doquery_pls_gm) : 0);
            $item_search_cache = array();
            $isUpgrades = false;
            if ($TotalCachedItems)
            {
                foreach ($doquery_pls_gm as $result_pls_gm)
                {
                    $item_search_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
                    $Items[] = array($result_pls_gm["item_id"], $result_pls_gm["item_name"], $result_pls_gm["item_level"], $result_pls_gm["item_source"], ($isUpgrades ? $itemScores[$result_pls_gm["item_id"]] : $result_pls_gm["item_relevance"]));
                }
            }
            if($config["locales"])
                $ItemsQuery = execute_query("world", "SELECT `entry` FROM `locales_item` WHERE `entry` = ".$itemid."");
            else
                $ItemsQuery = execute_query("world", "SELECT `entry` FROM `item_template` WHERE `entry` = ".$itemid."");

            $TotalItems = ($ItemsQuery ? count($ItemsQuery) : 0);
            if($TotalItems > $TotalCachedItems)
            {
                foreach ($ItemsQuery as $ItemInfo)
                {
                    if(!isset($item_search_cache[$ItemInfo["entry"]]))
                    {
                        $item_search_cache[$ItemInfo["entry"]] = cache_item_search($ItemInfo["entry"]);
                        $Items[] = array($ItemInfo["entry"], $item_search_cache[$ItemInfo["entry"]]["item_name"], $item_search_cache[$ItemInfo["entry"]]["item_level"], $item_search_cache[$ItemInfo["entry"]]["item_source"], ($isUpgrades ? $itemScores[$ItemInfo["entry"]] : $item_search_cache[$ItemInfo["entry"]]["item_relevance"]));
                    }
                }
                //while($ItemInfo = mysql_fetch_assoc($ItemsQuery))
                //{
                //	if(!isset($item_search_cache[$ItemInfo["entry"]]))
                //	{
                //		$item_search_cache[$ItemInfo["entry"]] = cache_item_search($ItemInfo["entry"]);
                //		$Items[] = array($ItemInfo["entry"], $item_search_cache[$ItemInfo["entry"]]["item_name"], $item_search_cache[$ItemInfo["entry"]]["item_level"], $item_search_cache[$ItemInfo["entry"]]["item_source"], $item_search_cache[$ItemInfo["entry"]]["item_relevance"]);
                //	}
                //}
            }
            unset($item_search_cache);
            if($TotalItems)
            {
                $visible_item_ids = "";
                foreach($Items as $Key => $Data)
                    $visible_item_ids .= $Data[0].",";
                $visible_item_ids .= "0";

                $doquery_pls_gm = execute_query("armory", "SELECT * FROM `cache_item` WHERE `item_id` IN (".$visible_item_ids.") AND `mangosdbkey` = ".$realms[REALM_NAME][2]);
                $item_cache = array();
                foreach ($doquery_pls_gm as $result_pls_gm)
                    $item_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
                foreach ($item_cache as $item)
                    $item["item_relevance"] = $itemScores[$item["item_id"]];
                //while($result_pls_gm = mysql_fetch_assoc($doquery_pls_gm))
                //	$item_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
                //switchConnection("armory", REALM_NAME);
                $doquery_pls_gm = execute_query("armory", "SELECT `item_id` FROM `cache_item_tooltip` WHERE `item_id` IN (".$visible_item_ids.") AND `mangosdbkey` = ".$realms[REALM_NAME][2]);
                $item_tooltip_cache = array();
                foreach ($doquery_pls_gm as $result_pls_gm)
                    $item_tooltip_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
                //while($result_pls_gm = mysql_fetch_assoc($doquery_pls_gm))
                //	$item_tooltip_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
                echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
                foreach($Items as $Key => $Data)
                {
                    if(!isset($item_cache[$Data[0]]))
                        $item_cache[$Data[0]] = cache_item($Data[0]);
                    $item_icon = $item_cache[$Data[0]]["item_icon"];
                    $item_quality = $item_cache[$Data[0]]["item_quality"];
                    if(!isset($item_tooltip_cache[$Data[0]]))
                        cache_item_tooltip($Data[0]);

                    echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
                    ?>
                    </br>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<span><img class="ci" height="21" onMouseOut="hideTip();" onmouseover="showTip('<?php echo $lang["loading"] ?>'); showTooltip(<?php echo $Data[0],",",$realms[REALM_NAME][2] ?>)" src="<?php echo $item_icon ?>"> <a class="rarity<?php echo $item_quality ?>" href="index.php?searchType=iteminfo&item=<?php echo $Data[0],"&realm=",REALM_NAME ?>" onMouseOut="hideTip();" onmouseover="showTip('<?php echo $lang["loading"] ?>'); showTooltip(<?php echo $Data[0],",",$realms[REALM_NAME][2] ?>)"><?php echo $Data[1] ?></a></q></span>
                    <?php
                }
            }
            unset($Items);
        }
    }
    //echo "<div style='border: 1px solid #276874;'></div>";

    echo "</br></br>";
}
}
?>
<div style="clear:both;"></div>
</div>
</div>
</div>
</td><td class="s-right">
<div class="shim stable"></div>
</td>
</tr>
<tr>
<td class="s-bot-left"></td><td class="s-bot"></td><td class="s-bot-right"></td>
</tr>
<!--</table>
</td><td class="sr"><b><em class="star"></em></b></td>
</tr>
</tbody>
<tfoot>
<tr>
<td class="sl"></td><td align="center" class="ct sb"><b><em class="foot"></em></b></td><td class="sr"></td>
</tr>
</tfoot>
</table>-->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>