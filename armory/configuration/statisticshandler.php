<?php
function assign_stats($data)
{
	global $defines;
	global $CHDB;
	$statistic_data = explode(" ",$data["data"]);
	switchConnection("mangos", REALM_NAME);
	$stat = array();
	$results = $CHDB->select("SELECT `str`, `agi`, `sta`, `inte`, `spi` FROM `player_levelstats` WHERE `race` = ".$data["race"]." AND `class` = ".$data["class"]." AND `level` = ".$statistic_data[$defines["LEVEL"][CLIENT]]." LIMIT 1");
	$gender = dechex($statistic_data[$defines["GENDER"][CLIENT]]);
	$gender = str_pad($gender, 8, 0, STR_PAD_LEFT);
	$stat["strength_eff"] = $statistic_data[$defines["STRENGTH"][CLIENT]];
	$stat["strength_base"] = $results["str"];
	$stat["agility_eff"] = $statistic_data[$defines["AGILITY"][CLIENT]];
	$stat["agility_base"] = $results["agi"];
	$stat["stamina_eff"] = $statistic_data[$defines["STAMINA"][CLIENT]];
	$stat["stamina_base"] = $results["sta"];
	$stat["intellect_eff"] = $statistic_data[$defines["INTELLECT"][CLIENT]];
	$stat["intellect_base"] = $results["inte"];
	$stat["spirit_eff"] = $statistic_data[$defines["SPIRIT"][CLIENT]];
	$stat["spirit_base"] = $results["spi"];
	$stat["hp"] = $statistic_data[$defines["HP"][CLIENT]];
	$stat["hero_mana"] = $statistic_data[$defines["MANA"][CLIENT]];
	$stat["rage"] = $statistic_data[$defines["RAGE"][CLIENT]]/10;
	$stat["energy"] = $statistic_data[$defines["ENERGY"][CLIENT]];
	$stat["armor_eff"] = $statistic_data[$defines["ARMOR"][CLIENT]];
	//$stat["holy_res"] = $statistic_data[$defines["HOLY_RES"][CLIENT]];
	$stat["fire_res"] = $statistic_data[$defines["FIRE_RES"][CLIENT]];
	$stat["nature_res"] = $statistic_data[$defines["NATURE_RES"][CLIENT]];
	$stat["frost_res"] = $statistic_data[$defines["FROST_RES"][CLIENT]];
	$stat["shadow_res"] = $statistic_data[$defines["SHADOW_RES"][CLIENT]];
	$stat["arcane_res"] = $statistic_data[$defines["ARCANE_RES"][CLIENT]];
	$stat["level"] = $statistic_data[$defines["LEVEL"][CLIENT]];
	//$stat["guild"] = $statistic_data[$defines["GUILD"][CLIENT]];
	//$stat["guildrank"] = $statistic_data[$defines["GUILD_RANK"][CLIENT]];
	$stat["kills"] = $statistic_data[$defines["KILLS"][CLIENT]];
	$stat["honor"] = $statistic_data[$defines["HONOR"][CLIENT]];
	$stat["arenapoints"] = $statistic_data[$defines["ARENAPOINTS"][CLIENT]];
	$stat["gender"] = $gender{3};
	$stat["race"] = $data["race"];
	$stat["class"] = $data["class"];
	$stat["name"] = $data["name"];
	$stat["guid"] = $data["guid"];
	$stat["melee_ap_base"] = $statistic_data[$defines["MELEE_AP_BASE"][CLIENT]];
	$stat["melee_ap_bonus"] = $statistic_data[$defines["MELEE_AP_BONUS"][CLIENT]];
	$stat["melee_ap"] = $stat["melee_ap_base"] + $stat["melee_ap_bonus"];
	$stat["ranged_ap_base"] = $statistic_data[$defines["RANGED_AP_BASE"][CLIENT]];
	$stat["ranged_ap_bonus"] = $statistic_data[$defines["RANGED_AP_BONUS"][CLIENT]];
	$stat["ranged_ap"] = $stat["ranged_ap_base"] + $stat["ranged_ap_bonus"];
	$stat["block_percent"] = unpack("f", pack("L", $statistic_data[$defines["BLOCK_PERCENTAGE"][CLIENT]]));
	$stat["dodge_percent"] = unpack("f", pack("L", $statistic_data[$defines["DODGE_PERCENTAGE"][CLIENT]]));
	$stat["parry_percent"] = unpack("f", pack("L", $statistic_data[$defines["PARRY_PERCENTAGE"][CLIENT]]));
	$stat["crit_percent"] = unpack("f", pack("L", $statistic_data[$defines["CRIT_PERCENTAGE"][CLIENT]]));
	$stat["ranged_crit_percent"] = unpack("f", pack("L", $statistic_data[$defines["RANGED_CRIT_PERCENTAGE"][CLIENT]]));
	for($i = 1; $i < 7; $i ++)
		$stat["spell_crit_percent_".$i] = unpack("f", pack("L", $statistic_data[$defines["SPELL_CRIT_PERCENTAGE"][CLIENT]+$i]));
	for($i = 1; $i < 7; $i ++)
		$stat["spell_damage_".$i] = $statistic_data[$defines["SPELL_DAMAGE"][CLIENT]+$i];
	$stat["spell_healing"] = $statistic_data[$defines["SPELL_HEALING"][CLIENT]];
	$stat["expertise"] = $statistic_data[$defines["EXPERTISE"][CLIENT]];
	$stat["defense_rating"] = $statistic_data[$defines["DEFENSE_RATING"][CLIENT]];
	$stat["dodge_rating"] = $statistic_data[$defines["DODGE_RATING"][CLIENT]];
	$stat["parry_rating"] = $statistic_data[$defines["PARRY_RATING"][CLIENT]];
	$stat["block_rating"] = $statistic_data[$defines["BLOCK_RATING"][CLIENT]];
	$stat["melee_hit_rating"] = $statistic_data[$defines["MELEE_HIT_RATING"][CLIENT]];
	$stat["ranged_hit_rating"] = $statistic_data[$defines["RANGED_HIT_RATING"][CLIENT]];
	$stat["spell_hit_rating"] = $statistic_data[$defines["SPELL_HIT_RATING"][CLIENT]];
	$stat["melee_crit_rating"] = $statistic_data[$defines["MELEE_CRIT_RATING"][CLIENT]];
	$stat["ranged_crit_rating"] = $statistic_data[$defines["RANGED_CRIT_RATING"][CLIENT]];
	$stat["spell_crit_rating"] = $statistic_data[$defines["SPELL_CRIT_RATING"][CLIENT]];
	$stat["resilience_rating"] = $statistic_data[$defines["RESILIENCE_RATING"][CLIENT]];
	$stat["melee_haste_rating"] = $statistic_data[$defines["MELEE_HASTE_RATING"][CLIENT]];
	$stat["ranged_haste_rating"] = $statistic_data[$defines["RANGED_HASTE_RATING"][CLIENT]];
	$stat["spell_haste_rating"] = $statistic_data[$defines["SPELL_HASTE_RATING"][CLIENT]];
	$stat["expertise_rating"] = $statistic_data[$defines["EXPERTISE_RATING"][CLIENT]];
	$stat["meele_main_hand_min_dmg"] = unpack("f", pack("L", $statistic_data[$defines["MEELE_MAIN_HAND_MIN_DAMAGE"][CLIENT]]));
	$stat["meele_main_hand_max_dmg"] = unpack("f", pack("L", $statistic_data[$defines["MEELE_MAIN_HAND_MAX_DAMAGE"][CLIENT]]));
	$stat["meele_main_hand_attack_time"] = unpack("f", pack("L", $statistic_data[$defines["MEELE_MAIN_HAND_ATTACK_TIME"][CLIENT]]));
	$stat["meele_off_hand_min_dmg"] = unpack("f", pack("L", $statistic_data[$defines["MEELE_OFF_HAND_MIN_DAMAGE"][CLIENT]]));
	$stat["meele_off_hand_max_dmg"] = unpack("f", pack("L", $statistic_data[$defines["MEELE_OFF_HAND_MAX_DAMAGE"][CLIENT]]));
	$stat["meele_off_hand_attack_time"] = unpack("f", pack("L", $statistic_data[$defines["MEELE_OFF_HAND_ATTACK_TIME"][CLIENT]]));
	$stat["ranged_attack_time"] = unpack("f", pack("L", $statistic_data[$defines["RANGED_ATTACK_TIME"][CLIENT]]));
	$stat["ranged_min_dmg"] = unpack("f", pack("L", $statistic_data[$defines["RANGED_MIN_DAMAGE"][CLIENT]]));
	$stat["ranged_max_dmg"] = unpack("f", pack("L", $statistic_data[$defines["RANGED_MAX_DAMAGE"][CLIENT]]));
	$stat["mana_regen"] = unpack("f", pack("L", $statistic_data[$defines["MANA_REGEN"][CLIENT]]));
	$stat["mana_regen_interrupt"] = unpack("f", pack("L", $statistic_data[$defines["MANA_REGEN_INTERRUPT"][CLIENT]]));
	return $stat;
}
function attack_power_base($str, $agi,  $level, $class, $ranged = false)
{
    if ($ranged)
    {
        if ($class == 3)
        {
            $ap_base = $level * 2 + $agi * 2 - 10;
        }
        elseif ($class == 4)
        {
            $ap_base = $level + $agi - 10;
        }
        elseif ($class == 1)
        {
            $ap_base = $level + $agi - 10;
        }
        elseif ($class == 11)
        {
            $ap_base = $agi - 10;
        }
        else
        {
            $ap_base = $agi - 10;
        }
    }
    else
    {
        if ($class == 1)
        {
            $ap_base = $level * 3 + $str * 2 - 20;
        }
        elseif ($class == 2)
        {
            $ap_base = $level * 3 + $str * 2 - 20;
        }
        elseif ($class == 4)
        {
            $ap_base = $level * 2 + $str + $agi - 20;
        }
        elseif ($class == 3)
        {
            $ap_base = $level * 2 + $str + $agi - 20;
        }
        elseif ($class == 7)
        {
            $ap_base = $level * 2 + $str * 2 - 20;
        }
        elseif ($class == 11)
        {
            $ap_base = $str * 2 - 20;
        }
        else
        {
            $ap_base = $str - 10;
        }
    }
    return $ap_base ? $ap_base : 0;
}
function stathandler_getratingformula($Type, $Stat, $CharacterLevel, $RoundPoints = 2)
{
    if (!CLIENT)
        return $Stat;
	global $RatingBases;
	$Base = $RatingBases[$Type];
	if($CharacterLevel <= 34 && ($Type == "dodge" || $Type == "block" || $Type == "parry" || $Type == "defense"))
		$RequiredPercent = $Base/2;
	else if($CharacterLevel <= 10)
		$RequiredPercent = $Base/26;
	else if($CharacterLevel <= 60)
		$RequiredPercent = $Base*($CharacterLevel-8)/52;
	else if($CharacterLevel >= 61 && $CharacterLevel <= 70)
		$RequiredPercent = $Base*82/(262-3*$CharacterLevel);
	else
		$RequiredPercent = ($Base*82/52)*pow(131/63, ($CharacterLevel-70)/10);
	return round($Stat/$RequiredPercent, $RoundPoints);
}
// Damage Reduction from Armor //
function stathandler_getdamagereduction($cLevel, $cArmor)
{
	// From WoWWiki: Level 1-60 %Reduction = (Armor/(Armor+400+85*Enemy_Level))*100 //
	// From WoWWiki: 60+ %Reduction = (Armor/(Armor-22167.5+467.5*Enemy_Level))*100 //
	if($cLevel <= 60)
		return round(($cArmor/($cArmor+400+85*$cLevel))*100, 2);
	else
		return round(($cArmor/($cArmor-22167.5+467.5*$cLevel))*100, 2);
}
function assign_stats_new($data)
{
    global $defines;
    //$statistic_data = explode(" ",$data["data"]);
    //switchConnection("mangos", REALM_NAME);
    $stat = array();
    $stat["saved_stats"] = false;
    $base_stats = execute_query("world", "SELECT `str`, `agi`, `sta`, `inte`, `spi` FROM `player_levelstats` WHERE `race` = ".$data["race"]." AND `class` = ".$data["class"]." AND `level` = ".$data["level"], 1);
    $real_stats = execute_query("char", "SELECT * FROM `character_stats` WHERE `guid`=".$data['guid'], 1);
    if ($real_stats)
        $stat["saved_stats"] = true;
    if (!CLIENT && !$data['totalKills'])
        $data['totalKills'] = execute_query("char", "SELECT COUNT(*) FROM `character_honor_cp` WHERE `guid`=".$data["guid"]." AND `victim_type` > '0' AND `type` = '1'", 2);
    if (!$data['totalKills'])
        $data['totalKills'] = 0;
    $stat["strength_eff"] = $real_stats['strength'];
    $stat["strength_base"] = $base_stats["str"];
    $stat["agility_eff"] = $real_stats['agility'];
    $stat["agility_base"] = $base_stats["agi"];
    $stat["stamina_eff"] = $real_stats['stamina'];
    $stat["stamina_base"] = $base_stats["sta"];
    $stat["intellect_eff"] = $real_stats['intellect'];
    $stat["intellect_base"] = $base_stats["inte"];
    $stat["spirit_eff"] = $real_stats['spirit'];
    $stat["spirit_base"] = $base_stats["spi"];
    // Human Spirit
    if ($data["race"] == 1)
        $stat["spirit_base"] = floor($stat["spirit_base"] * 1.05);
    $stat["hp"] = $real_stats['maxhealth'] ? $real_stats['maxhealth'] : $data["health"];
    $stat["hero_mana"] = $real_stats['maxpower1'] ? $real_stats['maxpower1'] : $data['power1'];
    $stat["rage"] = $real_stats['maxpower2'] ? $real_stats['maxpower2'] : $data['power2'];
    $stat["energy"] = $real_stats['maxpower4'] ? $real_stats['maxpower4'] : $data['power4'];
    $stat["armor_eff"] = $real_stats['armor'];
    //$stat["holy_res"] = $statistic_data[$defines["HOLY_RES"][CLIENT]];
    $stat["fire_res"] = $real_stats['resFire'];
    $stat["nature_res"] = $real_stats['resNature'];
    $stat["frost_res"] = $real_stats['resFrost'];
    $stat["shadow_res"] = $real_stats['resShadow'];
    $stat["arcane_res"] = $real_stats['resArcane'];
    $stat["level"] = $data['level'];
    //$stat["guild"] = $statistic_data[$defines["GUILD"][CLIENT]];
    //$stat["guildrank"] = $statistic_data[$defines["GUILD_RANK"][CLIENT]];
    $stat["kills"] = $data['totalKills'];
    $stat["honor"] = $data['totalHonor'];
    $stat["rank"] = $data['rank'] ? ($data['rank'] - 4) : 0;
    if ($stat["rank"])
    {
        $loctemp = LANGUAGE;
        if ($loctemp == "en_us")
            $loctemp = "en_gb";

        if (isAlliance($data["race"]))
            $stat["rank_name"] = execute_query("armory", "SELECT title_M_".$loctemp." FROM `armory_titles` WHERE `id` = ".$stat["rank"], 2);
        else
            $stat["rank_name"] = execute_query("armory", "SELECT title_F_".$loctemp." FROM `armory_titles` WHERE `id` = (".$stat["rank"]." + 14)", 2);

    }
    //$stat["arenapoints"] = $statistic_data[$defines["ARENAPOINTS"][CLIENT]];
    $stat["arenapoints"] = $data['aremaPoints'];
    $stat["gender"] = $data["gender"];
    $stat["race"] = $data["race"];
    $stat["class"] = $data["class"];
    $stat["name"] = $data["name"];
    $stat["guid"] = $data["guid"];
    $stat["melee_ap_base"] = attack_power_base($real_stats['strength'], $real_stats['agility'], $data['level'], $data["class"], false);
    $stat["melee_ap"] = $real_stats['attackPower'] + $real_stats['attackPowerMod'];
    $stat["melee_ap_bonus"] = $stat["melee_ap"] - $stat["melee_ap_base"];
    $stat["ranged_ap_base"] = attack_power_base($base_stats["str"], $base_stats["agi"], $data['level'], $data["class"], true);
    $stat["ranged_ap"] = $real_stats['rangedAttackPower'] + $real_stats['rangedAttackPowerMod'];
    $stat["ranged_ap_bonus"] = $stat["ranged_ap"] - $stat["ranged_ap_base"];
    $stat["block_percent"] = $real_stats['blockPct'];
    $stat["dodge_percent"] = $real_stats['dodgePct'];
    $stat["parry_percent"] = $real_stats['parryPct'];
    $stat["crit_percent"] = $real_stats['critPct'];
    $stat["ranged_crit_percent"] = $real_stats['rangedCritPct'];
    $stat["spell_crit_percent_1"] = $real_stats['holyCritPct'];
    $stat["spell_crit_percent_2"] = $real_stats['fireCritPct'];
    $stat["spell_crit_percent_3"] = $real_stats['natureCritPct'];
    $stat["spell_crit_percent_4"] = $real_stats['frostCritPct'];
    $stat["spell_crit_percent_5"] = $real_stats['shadowCritPct'];
    $stat["spell_crit_percent_6"] = $real_stats['arcaneCritPct'];
    $stat["spell_damage_1"] = $real_stats['holyDamage'];
    $stat["spell_damage_2"] = $real_stats['fireDamage'];
    $stat["spell_damage_3"] = $real_stats['natureDamage'];
    $stat["spell_damage_4"] = $real_stats['frostDamage'];
    $stat["spell_damage_5"] = $real_stats['shadowDamage'];
    $stat["spell_damage_6"] = $real_stats['arcaneDamage'];
    $stat["spell_healing"] = $real_stats['healBonus'];
    $stat["expertise"] = $real_stats['expertise'];
    $stat["defense_rating"] = $real_stats['defenseRating'];
    $stat["dodge_rating"] = $real_stats['dodgeRating'];
    $stat["parry_rating"] = $real_stats['parryRating'];
    $stat["block_rating"] = $real_stats['blockRating'];
    $stat["melee_hit_rating"] = $real_stats['meleeHitRating'];
    $stat["ranged_hit_rating"] = $real_stats['rangedHitRating'];
    $stat["spell_hit_rating"] = $real_stats['spellHitRating'];
    $stat["melee_crit_rating"] = $real_stats['meleeCritRating'];
    $stat["ranged_crit_rating"] = $real_stats['rangedCritRating'];
    $stat["spell_crit_rating"] = $real_stats['spellCritRating'];
    $stat["resilience_rating"] = $real_stats['resilience'];
    $stat["melee_haste_rating"] = $real_stats['meleeHasteRating'];
    $stat["ranged_haste_rating"] = $real_stats['rangedHasteRating'];
    $stat["spell_haste_rating"] = $real_stats['spellHasteRating'];
    $stat["expertise_rating"] = $real_stats['expertiseRating'];
    $stat["meele_main_hand_min_dmg"] = $real_stats['mainHandDamageMin']; // unpack("f", pack("L", $statistic_data[$defines["MEELE_MAIN_HAND_MIN_DAMAGE"][CLIENT]]));
    $stat["meele_main_hand_max_dmg"] = $real_stats['mainHandDamageMax']; // unpack("f", pack("L", $statistic_data[$defines["MEELE_MAIN_HAND_MAX_DAMAGE"][CLIENT]]));
    $stat["meele_main_hand_attack_time"] = $real_stats['mainHandSpeed']; // unpack("f", pack("L", $statistic_data[$defines["MEELE_MAIN_HAND_ATTACK_TIME"][CLIENT]]));
    $stat["meele_off_hand_min_dmg"] = $real_stats['offHandDamageMin']; // unpack("f", pack("L", $statistic_data[$defines["MEELE_OFF_HAND_MIN_DAMAGE"][CLIENT]]));
    $stat["meele_off_hand_max_dmg"] = $real_stats['offHandDamageMax']; // unpack("f", pack("L", $statistic_data[$defines["MEELE_OFF_HAND_MAX_DAMAGE"][CLIENT]]));
    $stat["meele_off_hand_attack_time"] = $real_stats['offHandSpeed']; // unpack("f", pack("L", $statistic_data[$defines["MEELE_OFF_HAND_ATTACK_TIME"][CLIENT]]));
    $stat["ranged_attack_time"] = $real_stats['rangedSpeed']; // unpack("f", pack("L", $statistic_data[$defines["RANGED_ATTACK_TIME"][CLIENT]]));
    $stat["ranged_min_dmg"] = $real_stats['rangedDamageMin']; // unpack("f", pack("L", $statistic_data[$defines["RANGED_MIN_DAMAGE"][CLIENT]]));
    $stat["ranged_max_dmg"] = $real_stats['rangedDamageMax']; // unpack("f", pack("L", $statistic_data[$defines["RANGED_MAX_DAMAGE"][CLIENT]]));
    $stat["mana_regen"] = $real_stats['manaRegen'];
    $stat["mana_regen_interrupt"] = $real_stats['manaInterrupt'];
    if (!$stat["saved_stats"])
    {
        foreach ($stat as $key => $value)
        {
            if (!$value && $key != "saved_stats")
                $stat[$key] = 0;
        }
    }
    return $stat;
}
//talent counting
function talentCounting($guid, $tab)
{
	$pt = 0;
	if (CLIENT < 2)
    {
        $resSpell = execute_query("char", "SELECT `spell` FROM `character_spell` WHERE `guid` = ".$guid." AND `disabled` = 0");
        if($resSpell)
        {
            foreach ($resSpell as $getSpell)
                $spells[] = $getSpell["spell"];
            //while($getSpell = mysql_fetch_assoc($resSpell))
            //	$spells[] = $getSpell["spell"];
            //switchConnection("armory", REALM_NAME);
            $resTal = execute_query("armory", "SELECT `rank1`, `rank2`, `rank3`, `rank4`, `rank5` FROM `dbc_talent` WHERE `ref_talenttab` = ".$tab);
            foreach ($resTal as $row)
                $ranks[] = $row;
            //while($row = mysql_fetch_assoc($resTal))
            //	$ranks[] = $row;
            foreach($ranks as $key => $val)
            {
                foreach($spells as $k => $v)
                {
                    if(in_array($v, $val))
                    {
                        switch(array_search($v, $val))
                        {
                            case "rank1": $pt += 1; break;
                            case "rank2": $pt += 2; break;
                            case "rank3": $pt += 3; break;
                            case "rank4": $pt += 4; break;
                            case "rank5": $pt += 5; break;
                        }
                    }
                }
            }
        }
    }
	else
    {
        $char_talents = execute_query("char", "SELECT `talent_id`, `current_rank` FROM `character_talent` WHERE `guid` = ".$guid);
        if ($char_talents)
        {
            $talents = array();
            foreach ($char_talents as $talent)
                $talents[$talent["talent_id"]] = $talent["current_rank"] + 1;

            $resTal = execute_query("armory", "SELECT `id` FROM `dbc_talent` WHERE `ref_talenttab` = ".$tab);
            foreach ($resTal as $row)
                $talentTab[$row["id"]] = $tab;

            foreach ($talents as $id => $rank)
            {
                if ($talentTab[$id] == $tab)
                    $pt += $rank;
            }
        }
    }

	return $pt;
}
//get a tab from TalentTab
function getTabOrBuild($class, $type, $tabnum)
{
	if($type == "tab")
		$field = "id";
	else //$type == "build"
		$field = "name";
	//switchConnection("armory", REALM_NAME);
	return execute_query("armory", "SELECT `".$field."` FROM `dbc_talenttab` WHERE `refmask_chrclasses` = ".pow(2,($class-1))." AND `tab_number` = ".$tabnum." LIMIT 1", 2);
}
function HPRegenFromSpirit($level, $class, $spirit_eff, $spirit_base)
{
	if($level > 100)
		$level = 100;
	$ratio_index = (($class-1)*100 + $level-1) + 1;
	//switchConnection("armory", REALM_NAME);
	$baseRatio = execute_query("armory", "SELECT `ratio` FROM `dbc_gtoctregenhp` WHERE `id` = ".$ratio_index." LIMIT 1", 2);
	$moreRatio = execute_query("armory", "SELECT `ratio` FROM `dbc_gtregenhpperspt` WHERE `id` = ".$ratio_index." LIMIT 1", 2);
	if($spirit_base > 50)
		$spirit_base = 50;
	$moreSpirit = $spirit_eff - $spirit_base;
	return floor($spirit_base * $baseRatio + $moreSpirit * $moreRatio);
}
function MPRegenFromSpirit($level, $class, $spirit_eff, $intelect)
{
	if($level > 100)
		$level = 100;
	$ratio_index = (($class-1)*100 + $level-1) + 1;
	//switchConnection("armory", REALM_NAME);
	$moreRatio = execute_query("armory", "SELECT `ratio` FROM `dbc_gtregenmpperspt` WHERE `id` = ".$ratio_index." LIMIT 1", 2);
	return floor(5 * sqrt($intelect) * $spirit_eff * $moreRatio);
}
function get_prof_max($skill_points)
{
	return ($skill_points < 76?75:($skill_points < 151?150:($skill_points < 226?225:($skill_points < 301?300:($skill_points < 376?375:($skill_points < 451?450:460))))));
}
?>