<?php
if(!defined("Armory"))
{
	header("Location: ../error.php");
	exit();
}
$faction_ihl = array(
1118 => "classic",
469 => "alliance",
891 => "allianceforces",
1037 => "classic",
67 => "horde",
892 => "hordeforces",
1052 => "classic",
936 => "shattrathcity",
1117 => "classic",
169 => "steamwheedlecartel",
980 => "outland",
1097 => "classic",
0 => "zother"
);
$reputation_rank_length = array(36000, 3000, 3000, 3000, 6000, 12000, 21000, 999);
$reputation_cap    =  42999;
$reputation_bottom = -42000;
$MIN_REPUTATION_RANK = 0;
$MAX_REPUTATION_RANK = 8;
$temp_out = array();
foreach($faction_ihl as $key => $value)
{
    $section_name = GetNameFromDB($key, "dbc_faction");
	$temp_out[$key] = array("<div class=\"inner-cont\">
<table class=\"iht\">
<tr>
<td class=\"ihl\"><span class=\"faction-".$value."\">
<p>".($section_name ? $section_name : "Other")."</p>
</span></td><td class=\"ihrc\"></td>
</tr>
</table>
<table>
<tr>
<td class=\"il\"></td><td class=\"ibg\">
<div class=\"profile-wrapper\">", 0);
}
?>
<div class="parch-profile-banner" id="banner" style="position: absolute;margin-left: 450px!important;margin-top: -110px!important;">
<h1 style="padding-top: 12px!important;"><?php echo $lang["reputation"] ?></h1>
</div>
<?php
//switchConnection("characters", REALM_NAME);
$return_char_reputations = execute_query("char", "SELECT `faction`, `standing` FROM `character_reputation` WHERE `guid` =".$stat["guid"]." AND (`flags` & 1 = 1) AND faction NOT IN(".implode(", ", array_keys($faction_ihl)).")");
if ($return_char_reputations)
{
    foreach ($return_char_reputations as $factions)
    {
        $standing = $factions["standing"];
        //switchConnection("armory", REALM_NAME);
        $faction_info = execute_query("armory", "SELECT * FROM `dbc_faction` WHERE `id` =".$factions["faction"]." LIMIT 1", 1);
        // From base reputation
        for($i = 0; $i < 4; $i ++)
        {
            if($faction_info["base_ref_chrraces_".$i] & (1 << ($stat["race"]-1)))
            {
                $standing += $faction_info["base_modifier_".$i];
                break;
            }
        }
        $rep_rank = $MIN_REPUTATION_RANK;
        $rep = 0;
        $limit = $reputation_cap;
        for($i = $MAX_REPUTATION_RANK-1; $i >= $MIN_REPUTATION_RANK; --$i)
        {
            $limit -= $reputation_rank_length[$i];
            if($standing >= $limit)
            {
                $rep_rank = $i;
                $rep = $standing - $limit;
                break;
            }
        }
        $rep_rank_name = $reputation_rank[$rep_rank];
        $rep_cap = $reputation_rank_length[$rep_rank];
        $temp_out[$faction_info["ref_faction"]][0] .= "<div class=\"rep".$rep_rank."\">
<div class=\"rep-lbg\">
<div class=\"rep-lr\">
<div class=\"rep-ll\">
<ul>
<li class=\"faction-name\">
<a onMouseOut=\"hideTip();\" onMouseOver=\" showTip('".addslashes(str_replace("\"","'",$faction_info["description"]))."');\">".$faction_info["name"]."</a>
</li>
<li class=\"faction-bar\">
<a class=\"rep-data\">".$rep."/".$rep_cap."</a>
<div class=\"bar-color\" style=\" width: ".(100*$rep/$rep_cap)."%\"></div>
</li>
<li class=\"faction-level\">
<p class=\"rep-icon\">".$rep_rank_name."</p>
</li>
</ul>
</div>
</div>
</div>
</div>";
        $temp_out[$faction_info["ref_faction"]][1] = 1;
    }
}

foreach($temp_out as $out)
{
	if($out[1])
		echo $out[0],"</div>
</td><td class=\"ir\"></td>
</tr>
<tr>
<td class=\"ibl\"></td><td class=\"ib\"></td><td class=\"ibr\"></td>
</tr>
</table>
</div>";
}
?>
</div>
</div>
</div>
</div>
</div>