<?php
if(!defined("Armory")/* || !CLIENT*/)
{
	header("Location: ../error.php");
	exit();
}
function category_frame($category)
{
	return "<h2>".$category."</h2><table style=\"width: 100%;\">
<tr><th colspan=\"5\" align=\"left\" style=\"font-size:14px; color:black; background-color: #f6b620;\">".$category."</th></tr>";
}
function subcategory_frame($subcategory)
{
	return "<table style=\"width: 100%;\">
<tr><th colspan=\"5\" align=\"left\" style=\"font-size:11px; color:white; background-color: #222b3a;\">".$subcategory."</th></tr>";
}
if (CLIENT < 2)
    $getcategory = execute_query("world", "SELECT `ID` as `id`, `Name_Lang_enUS` as `name` FROM `achievement_category_dbc` WHERE `Parent` = -1");
else
    $getcategory = execute_query("armory", "SELECT `id`, `name` FROM `dbc_achievement_category` WHERE `ref_achievement_category` = -1");

foreach ($getcategory as $category)
{
    $temp_out[$category["id"]] = array(category_frame($category["name"]), 0);
    if (CLIENT < 2)
        $getsubcategory = execute_query("world", "SELECT `ID` as `id`, `Name_Lang_enUS` as `name` FROM `achievement_category_dbc` WHERE `Parent` = ".$category["id"]);
    else
        $getsubcategory = execute_query("armory", "SELECT `id`, `name` FROM `dbc_achievement_category` WHERE `ref_achievement_category` = ".$category["id"]);

    foreach ($getsubcategory as $subcategory)
        $temp_out[$subcategory["id"]] = array(subcategory_frame($subcategory["name"]), 0);
}
if (CLIENT < 2)
    $getcharachi = execute_query("char","SELECT `achievement`, `date` FROM `character_achievement` WHERE `guid` = ".$stat["guid"]);
else
    $getcharachi = execute_query("char","SELECT `achievement`, `date` FROM `character_achievement` WHERE `guid` = ".$stat["guid"]);

foreach ($getcharachi as $char_achi)
{
    if (CLIENT < 2)
        $achi = execute_query("world", "SELECT * FROM `achievement_dbc` WHERE `id` = ".$char_achi["achievement"]." LIMIT 1", 1);
    else
        $achi = execute_query("armory", "SELECT * FROM `dbc_achievement` WHERE `id` = ".$char_achi["achievement"]." LIMIT 1", 1);

    ?>
    <div class="parch-profile-banner" id="banner" style="position: absolute;margin-left: 450px!important;margin-top: -110px!important;">
        <h1 style="padding-top: 12px!important;"><?php echo $lang["achievements"] ?></h1>
    </div>
    <?php
    if (CLIENT >= 2)
    {
        $achi["icon"] = GetIcon("spell", $achi["ref_spellicon"]);
        $temp_out[$achi["ref_achievement_category"]][0] .="<tr>
<td width=\"10%\" height=\"58\" align=\"center\" style=\"border-bottom:1px solid #222b3a;\"><div style=\"background:url('".$achi["icon"]."') center no-repeat;\"><img src=\"images/achievements/fst_iconframe.png\" border=\"0\" /></div></td>
<td align=\"left\" style=\"border-bottom:1px solid #222b3a;font-size:14px;\">".$achi["name"]."<br /><span style=\"font-size:12px\">".$achi["description"]."</span></td>
<td width=\"10%\" align=\"center\" style=\"border-bottom:1px solid #222b3a;\">".date("d/m/Y", $char_achi["date"])."</td>
<td width=\"10%\" align=\"center\" style=\"background:url('images/achievements/point_shield.png') center no-repeat; border-bottom:1px solid #222b3a\">".$achi["points"]."</td>
</tr>";
        $temp_out[$achi["ref_achievement_category"]][1] = 1;
    }
    else
    {
        $achi["icon"] = GetIcon("spell", $achi["IconID"]);
        $temp_out[$achi["Category"]][0] .="<tr>
<td width=\"10%\" height=\"58\" align=\"center\" style=\"border-bottom:1px solid #222b3a;\"><div style=\"background:url('".$achi["icon"]."') center no-repeat;\"><img src=\"images/achievements/fst_iconframe.png\" border=\"0\" /></div></td>
<td align=\"left\" style=\"border-bottom:1px solid #222b3a;font-size:14px;\">".$achi["Title_Lang_enUS"]."<br /><span style=\"font-size:12px\">".$achi["Description_Lang_enUS"]."</span></td>
<td width=\"10%\" align=\"center\" style=\"border-bottom:1px solid #222b3a;\">".date("d/m/Y", $char_achi["date"])."</td>
<td width=\"10%\" align=\"center\" style=\"background:url('images/achievements/point_shield.png') center no-repeat; border-bottom:1px solid #222b3a\">".$achi["Points"]."</td>
</tr>";
        $temp_out[$achi["Category"]][1] = 1;
    }
}
?>
<br />
<br />
<?php
foreach($temp_out as $cat_data)
{
	if($cat_data[1])
		echo $cat_data[0],"</table>";
}
?>