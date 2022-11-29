<?php
function tooltip_addsinglerow($text, $classname = "item-text-standard")
{
	return "<tr><td class=\"".$classname."\" colspan=\"2\">".$text."</td></tr>";
}
function tooltip_adddoublerow($text1, $text2, $classname1 = "item-text-standard", $classname2 = "item-text-standard")
{
	return "<tr><td class=\"".$classname1."\" width=\"50%\">".$text1."</td><td class=\"".$classname2." item-righttext\" width=\"50%\">".$text2."</td></tr>";
}
//Spell data
function spell_parsedata($spellinfo, $buff = 0)
{
	if($buff)
	{
		$spellText = $spellinfo["description_buff"];
		$spellText = str_replace("\n", "<br />", $spellText);
		$spellText = str_replace("\r", "", $spellText);
	}
	else
		$spellText = $spellinfo["description"];
	//Chance
	if($spellinfo["proc_chance"])
		$spellText = str_replace("\$h", $spellinfo["proc_chance"], $spellText);
	//Charges
	if($spellinfo["proc_charges"])
		$spellText = str_replace("\$n", $spellinfo["proc_charges"], $spellText);
	//switchConnection("armory", REALM_NAME);
	//Duration
	if($spellinfo["ref_spellduration"])
	{
		$thisDuration = execute_query("armory", "SELECT `durationValue` FROM `dbc_spellduration` WHERE `id` = ".$spellinfo["ref_spellduration"]." LIMIT 1", 2) / 1000;
		if($thisDuration > 60)
			$thisDurationText = ($thisDuration/60)." min";
		else
			$thisDurationText = $thisDuration." sec";
		$spellText = str_replace("\$d", $thisDurationText, $spellText);
	}
	//Radius
	if($spellinfo["ref_spellradius_1"])
	{
        $radius = execute_query("armory", "SELECT `yards_base` FROM `dbc_spellradius` WHERE `id` = ".$spellinfo["ref_spellradius_1"]." LIMIT 1", 2);
        $spellText = str_replace("\$a1", $radius, $spellText);
	}
	for($i = 1; $i <= 3; $i ++)
	{
		//Targets
		if($spellinfo["effect_chaintarget_".$i])
			$spellText = str_replace("\$x".$i, $spellinfo["effect_chaintarget_".$i], $spellText);
		//Amplitude
		if($spellinfo["effect_amplitude_".$i])
		{
			$spellText = str_replace("\$t", $spellinfo["effect_amplitude_".$i]/1000, $spellText);
			if($spellinfo["ref_spellduration"])
				$spellText = str_replace("\$o".$i, ($thisDuration/($spellinfo["effect_amplitude_".$i]/1000))*abs($spellinfo["effect_basepoints_".$i] + 1), $spellText);
		}
		//Base Points
		$effectBasePoints = abs($spellinfo["effect_basepoints_".$i] + 1);
		if((CLIENT && $effectBasePoints > 1) || (!CLIENT && $effectBasePoints > 0))
		{
			//With divisor
			$switches = array(
			'/\${\$m'.$i.'\/-*(?P<divisor>\d+)}/',
			'/\$\/(?P<divisor>\d+);s'.$i.'/i',
			);
			foreach($switches as $search)
				if(preg_match($search, $spellText, $matches))
					$spellText = preg_replace($search, $effectBasePoints/$matches["divisor"], $spellText);
			//Plain
			$switches = array(
			'/\$s'.$i.'/i',
			'/\$m'.$i.'/i',
			);
			foreach($switches as $search)
				$spellText = preg_replace($search, $effectBasePoints, $spellText);
		}
		//Triggered spell
		if(preg_match('/\$/', $spellText))
		{
			$switches = array(
				'/\$(?P<spellid>\d+)s'.$i.'/' => "effect_basepoints_".$i,
				'/\$\/10;(?P<spellid>\d+)s'.$i.'/' => "effect_basepoints_".$i,
				'/\${\$(?P<spellid>\d+)m'.$i.'\/10}/' => "effect_basepoints_".$i,
				'/\$(?P<spellid>\d+)t'.$i.'/' => "effect_".$i,
				'/\$(?P<spellid>\d+)d/' => "ref_spellduration",
			);
			foreach($switches as $search => $table_column)
			{
				if(preg_match($search, $spellText, $matches))
				{
					$triggerdata = execute_query("armory", "SELECT `".$table_column."` FROM `dbc_spell` WHERE `id` = ".$matches["spellid"]." LIMIT 1", 2);
					switch($search)
					{
						case '/\$(?P<spellid>\d+)s'.$i.'/':
							$spellText = str_replace("\$".$matches["spellid"]."s".$i, abs($triggerdata + 1), $spellText);
							break;
						case '/\$(?P<spellid>\d+)t'.$i.'/':
							$spellText = str_replace("\$".$matches["spellid"]."t".$i, $triggerdata + 1, $spellText);
							break;
						case '/\$\/10;(?P<spellid>\d+)s'.$i.'/':
							$spellText = str_replace("\$/10;".$matches["spellid"]."s".$i, abs($triggerdata + 1)/10, $spellText);
							break;
						case '/\${\$(?P<spellid>\d+)m'.$i.'\/10}/':
							$spellText = str_replace("\${\$".$matches["spellid"]."m".$i."/10}", abs($triggerdata + 1)/10, $spellText);
							break;
						case '/\$(?P<spellid>\d+)d/':
							$thisTriggeredDuration = execute_query("armory", "SELECT `durationValue` FROM `dbc_spellduration` WHERE `id` = ".$triggerdata." LIMIT 1", 2) / 1000;
							if($thisTriggeredDuration > 60)
								$thisTriggeredDuration = ($thisTriggeredDuration/60)." min";
							else
								$thisTriggeredDuration .= " sec";
							$spellText = str_replace("\$".$matches["spellid"]."d", $thisTriggeredDuration, $spellText);
							break;
					}
				}
			}
		}
	}
	return $spellText;
}
function getStatType($statType, $statVal)
{
	global $stattype_description, $lang;
	if($statType >= 0 && $statType <= 7 && $statType != 2)
	{
		if($statType == 0 || $statType == 1)
			$isGreenStat = 1;
		else
			$isGreenStat = 0;
		$statName = $stattype_description[$statType];
	}
	else
	{
		$isGreenStat = 1;
		if(isset($stattype_description[$statType]))
			$statName = $stattype_description[$statType]." ".$statVal.".";
		else
			$statName = $lang["unk_state_type"].": ".$statType."/".$lang["value"].": ".$statVal;
	}
	if($isGreenStat)
		return "[GREEN]".$statName;
	else if($statVal < 0)
		return $statVal." ".$statName;
	else
		return "+".$statVal." ".$statName;
}
function ShowAllowable($Allowable, $table)
{
	$AllowableString = "";
	//switchConnection("armory", REALM_NAME);
	$Query = execute_query("armory", "SELECT `id`, `name` FROM `".$table."`");
	foreach ($Query as $Result)
    {
        if($Allowable & pow(2, ($Result["id"]-1)))
        {
            if($AllowableString)
                $AllowableString .= ",";
            $AllowableString .= "&nbsp;".$Result["name"];
        }
    }
	/*while($Result = mysql_fetch_assoc($Query))
	{
		if($Allowable & pow(2, ($Result["id"]-1)))
		{
			if($AllowableString)
				$AllowableString .= ",";
			$AllowableString .= "&nbsp;".$Result["name"];
		}
	}*/
	return $AllowableString;
}
function GetChance($Chance)
{
	global $lang;
	if($Chance >= 100)
		return $lang["guaranteed"]." (".$Chance."%)";
	else if($Chance >= 51 && $Chance < 100)
		return $lang["high"]." (".$Chance."%)";
	else if($Chance >= 25 && $Chance < 51)
		return $lang["medium"]." (".$Chance."%)";
	else if($Chance >= 15 && $Chance < 25)
		return $lang["low"]." (".$Chance."%)";
	else if($Chance >= 3 && $Chance < 15)
		return $lang["very_low"]." (".$Chance."%)";
	else
		return $lang["extrem_low"]." (".$Chance."%)";
}
function GenerateEnchSuffixFactor($item_level, $inventory_type, $item_quality)
{
	switch($inventory_type)
	{
		// Select column index
		case 1: case 4: case 5: case 7: case 17: case 20: $columnindex = 1; break;
		case 3: case 6: case 8: case 10: case 12: $columnindex = 2; break;
		case 2: case 9: case 11: case 14: case 16: case 23: $columnindex = 3; break;
		case 13: case 21: case 22: $columnindex = 4; break;
		case 15: case 25: case 26: $columnindex = 5; break;
	}
	// Select rare/epic modifier
	switch ($item_quality)
	{
		case 2: $column = "uncommon_".$columnindex; break;
		case 3: $column = "rare_".$columnindex; break;
		case 4: $column = "epic_".$columnindex; break;
	}
	//switchConnection("armory", REALM_NAME);
	return execute_query("armory", "SELECT `".$column."` FROM `dbc_randproppoints` WHERE `item_level` = ".$item_level." LIMIT 1", 2);
}
/* ---- Generate a full item tooltip based on $itemid ---- */
/* ---- Returns the item HTML in one line ---- */
function outputTooltip($itemid, $itemguid = 0, $itemlist = array())
{
	global $inventorytype, $ItemFlags, $config, $defines, $lang;
	/* Item Tooltip Output Function */
	/* Get Item Info */
	//switchConnection("mangos", REALM_NAME);
	$tooltipText = "";
	$itemtable = "";
	if($config["locales"])
	{
		$itemdata = execute_query("world", "SELECT * FROM `item_template` LEFT JOIN `locales_item` ON `item_template`.`entry` = `locales_item`.`entry` where `item_template`.`entry` = ".$itemid." LIMIT 1", 1);
		$nameloc="name_loc".$config["locales"];
		$descriptionloc = "description_loc".$config["locales"];
		if($itemdata[$nameloc])
			$itemdata["name"] = $itemdata[$nameloc];
		if($itemdata[$descriptionloc])
			$itemdata["description"] = $itemdata[$descriptionloc];
	}
	else
		$itemdata = execute_query("world", "SELECT * FROM `item_template` WHERE `entry` = ".$itemid." LIMIT 1", 1);
	$tooltipText .= "<table class=\"item-tooltip-table\" cellpadding=\"0\">";
	$itemtable .= "<div class=\"myTable\">";
	/* get character item specific information */
	if($itemguid)
	{
		//switchConnection("characters", REALM_NAME);
        $enchantmentsDataRaw = execute_query("char", "SELECT `enchantments`, `randomPropertyId`, `durability` FROM `item_instance` WHERE `guid` = ".$itemguid." LIMIT 1", 1);
		$enchantmentsData = explode(" ", $enchantmentsDataRaw['enchantments']);
		$randomPropertyId = $enchantmentsDataRaw['randomPropertyId'];
		$item_durability = $enchantmentsDataRaw['durability'];
	}
	/* Random Enchantment PART 1*/
	$ItemRandomName = "";
	if($itemguid && ($itemdata["RandomProperty"] || (CLIENT && $itemdata["RandomSuffix"])))
	{
		$FirstEnchant = $defines["RANDOM_1"][CLIENT];
		if($itemdata["RandomProperty"])
		{
			$FirstEnchant += 6;
			$RandomEnchantTable = "dbc_itemrandomproperties";
		}
		else// if($itemdata["RandomSuffix"])
			$RandomEnchantTable = "dbc_itemrandomsuffix";
		//switchConnection("armory", REALM_NAME);
        // test random ehchant bugs
        //print_r($enchantmentsData);
        //echo $FirstEnchant;
		$ItemRandomData = execute_query("armory", "SELECT * FROM `".$RandomEnchantTable."`
			WHERE `ref_spellitemenchantment_1` = ".$enchantmentsData[$FirstEnchant]." AND `ref_spellitemenchantment_2` = ".$enchantmentsData[$FirstEnchant+3]." AND `ref_spellitemenchantment_3` = ".$enchantmentsData[$FirstEnchant+6]." LIMIT 1", 1);
		$ItemRandomName = $ItemRandomData["name"];
	}
	/* Item Quality */
	switch($itemdata["Quality"])
	{
		case 0: $itemQuality = "gray"; break;
		case 1: $itemQuality = "white"; break;
		case 2: $itemQuality = "green"; break;
		case 3: $itemQuality = "blue"; break;
		case 4: $itemQuality = "purple"; break;
		case 5: $itemQuality = "orange"; break;
		case 6: $itemQuality = "gold"; break;
		/* 7 */default: $itemQuality = "red";
	}
	$tooltipText .= tooltip_addsinglerow("<span class=\"item-quality-".$itemQuality."\">".$itemdata["name"]." ".$ItemRandomName."</span>", "item-text-name");
	$itemtable .= "<span class=\"my".ucfirst($itemQuality)." myBold myItemName\"><span class=\"\">".$itemdata["name"]."</span><span class=\"\"> </span></span>";
	/* Item Level */
    if (CLIENT > 1)
    {
        $tooltipText .= tooltip_addsinglerow($lang["item_level"] . " " . $itemdata["ItemLevel"],"item-set-name");
        $itemtable .= "<br /><span class=\"myYellow\">".$lang["item_level"] . " " . $itemdata["ItemLevel"] . "</span>";
    }
	/* Item Binding */
	switch($itemdata["bonding"])
	{
		case 1: $itemBinding = $lang["binds_when_pickup"]; break;
		case 2: $itemBinding = $lang["binds_when_equipped"]; break;
		case 3: $itemBinding = $lang["binds_when_used"]; break;
		case 4: $itemBinding = $lang["quest_item"]; break;
		default: $itemBinding = "";
	}
	if($itemBinding)
	{
		$tooltipText .= tooltip_addsinglerow($itemBinding);
		$itemtable .= "<br />".$itemBinding;
	}
	/* Unique Status */
	if($itemdata["Flags"])
	{
		$count = 0;
		$UniqueString = "";
		foreach($ItemFlags as $key => $value)
		{
			if($itemdata["Flags"] & $key)
			{
				$count = 1;
				if($value)
					$UniqueString = $value;
			}
		}
		if($UniqueString && $count)
		{
			$tooltipText .= tooltip_addsinglerow($UniqueString);
			$itemtable .= "<br />".$UniqueString;
		}
		else if($config["ShowError"] && !$count)
		{
			$tooltipText .= tooltip_addsinglerow("<span class=\"error\">".$lang["error"].": ".$lang["unknown"]." Flags ".$itemdata["Flags"].", ".$lang["report_to_gm"]."</span>");
			$itemtable .= "<br /><span class=\"error\">".$lang["error"].": ".$lang["unknown"]." Flags ".$itemdata["Flags"].", ".$lang["report_to_gm"]."</span>";
		}
	}
	$greenStats = array();
	/* Item Type */
	if($itemdata["InventoryType"])
	{
		//switchConnection("armory", REALM_NAME);
		$itemClassRight = execute_query("armory", "SELECT `name` FROM `dbc_itemsubclass` WHERE `ref_itemclass` = ".$itemdata["class"]." AND `id` = ".$itemdata["subclass"], 2);
		if($itemdata["InventoryType"] == 18) // Bag
		{
			$itemClassLeft = $itemdata["ContainerSlots"]." ".$lang["slot"]." ".$itemClassRight;
			$tooltipText .= tooltip_addsinglerow($itemClassLeft);
			$itemtable .= "<br />".$itemClassLeft;
		}
		else
		{
			$itemClassLeft = $inventorytype[$itemdata["InventoryType"]];
			$tooltipText .= tooltip_adddoublerow($itemClassLeft,$itemClassRight);
			$itemtable .= "<br /><span class=\"tooltipRight\">".$itemClassRight."</span>".$itemClassLeft;
		}
		/* Damage */
		$itemIsWeapon = 0;
		$minDamage = 0;
		$totalMinDamage = 0;
		$maxDamage = 0;
		$totalMaxDamage = 0;
		/* Loop through item data to check if any of the dmg_min and dmg_max fields are set and handle output as such */
		$dmg_max_index = CLIENT >= 2 ? 2 : 5;
		for($i = 1; $i <= $dmg_max_index; $i ++)
		{
			if($itemdata["dmg_min".$i])
			{
				$itemIsWeapon = 1;
				$thisDelay = round($itemdata["delay"]/1000, 2);
				$minDamage = $itemdata["dmg_min".$i];
				$totalMinDamage += $minDamage;
				$maxDamage = $itemdata["dmg_max".$i];
				$totalMaxDamage += $maxDamage;
				$itemDamageType = "&nbsp;";
				switch($itemdata["dmg_type".$i])
				{
					case 0: $itemDamageType = ""; break;
					case 1: $itemDamageType .= $lang["holy"]; break;
					case 2: $itemDamageType .= $lang["fire"]; break;
					case 3: $itemDamageType .= $lang["nature"]; break;
					case 4: $itemDamageType .= $lang["frost"]; break;
					case 5: $itemDamageType .= $lang["shadow"]; break;
					case 6: $itemDamageType .= $lang["arcane"]; break;
					default: $itemDamageType .= $lang["unknown"].": ".$itemdata["dmg_type".$i];
				}
				$itemDamageType .= "&nbsp;";
				if($i == 1)
				{
					$tooltipText .= tooltip_addsinglerow($minDamage."-".$maxDamage.$itemDamageType.$lang["dmg"]);
					$itemtable .= "<br /><span class=\"\">".$minDamage."-".$maxDamage."</span><span class=\"\">".$itemDamageType."</span><span class=\"\">".$lang["dmg"]."</span>";
				}
				else
				{
					$tooltipText .= tooltip_addsinglerow("+".$minDamage."-".$maxDamage.$itemDamageType.$lang["damage"]);
					$itemtable .= "<br /><span class=\"\">+".$minDamage."-".$maxDamage."</span><span class=\"\">".$itemDamageType."</span><span class=\"\">".$lang["damage"]."</span>";
				}
			}
		}
		if($itemIsWeapon)
		{
			/* Convert delay to string to get .0 if it's not there */
			$thisDelayString = explode(".", $thisDelay);
			if(count($thisDelayString) == 1)
				$thisDelay = $thisDelayString[0].".00";
			else if(count($thisDelayString) == 2 and strlen($thisDelayString[1]) == 1)
				$thisDelay."0";
			/* Calculate DPS */
			$itemAverageDamage = ($totalMinDamage + $totalMaxDamage)/2;
			$itemDamagePerSecond = round($itemAverageDamage/$thisDelay, 1);
			/* Convert to string to get .0 if it's not there */
			$itemDPSString = explode(".", $itemDamagePerSecond);
			if(count($itemDPSString) == 1)
				$itemDamagePerSecond .= ".0";
			$tooltipText .= tooltip_adddoublerow("(".$itemDamagePerSecond." ".$lang["damage_per_sec"].")", $lang["speed"]." ".$thisDelay);
			$itemtable .= "<br /><span class=\"tooltipRight\">".$lang["speed"]." ".$thisDelay."</span>(<span class=\"\">".$itemDamagePerSecond."&nbsp;</span><span class=\"\">".$lang["damage_per_sec"]."</span>)";
		}
		/* Armor Value */
		if($itemdata["armor"])
		{
			$tooltipText .= tooltip_addsinglerow($itemdata["armor"]." ".$lang["armor"]);
			$itemtable .= "<br /><span class=\"\"><span class=\"\">".$itemdata["armor"]."</span><span class=\"\"> ".$lang["armor"]."</span></span>";
		}
		/* Shield Block */
		if($itemdata["block"])
		{
			$tooltipText .= tooltip_addsinglerow($itemdata["block"]." ".$lang["block"]);
			$itemtable .= "<br /><span class=\"\"><span class=\"\">".$itemdata["block"]."</span><span class=\"\"> ".$lang["block"]."</span></span>";
		}
		/* Statistics */
		$isGreenStat = 0;
		for($i = 1; $i <= 10; $i ++)
		{
			if($itemdata["stat_type".$i])
			{
				/* Confirmed stat */
				$statType = $itemdata["stat_type".$i];
				$statVal = $itemdata["stat_value".$i];
				$isGreenStat = 0;
				$statInfo = getStatType($statType, $statVal);
				if(strstr($statInfo, "[GREEN]"))
				{
					$isGreenStat = 1;
					$greenStats[] = str_replace("[GREEN]", "", $statInfo);
				}
				else
				{
					$tooltipText .= tooltip_addsinglerow($statInfo);
					$itemtable .= "<br /><span class=\"\"><span class=\"\">".$statInfo."&nbsp;</span></span>";
				}
			}
			else
				break;
		}
		/* More on $greenStats after Required Level line */
		/* Resistances */
		$resistances = array("arcane", "fire", "nature", "frost", "shadow");
		foreach($resistances as $resistance)
		{
			if($itemdata[$resistance."_res"])
			{
				$tooltipText .= tooltip_addsinglerow("+".$itemdata[$resistance."_res"]." ".ucfirst($resistance)." ".$lang["resistance"]);
				$itemtable .= "<br /><span class=\"\"><span class=\"\">+".$itemdata[$resistance."_res"]." ".ucfirst($resistance)." ".$lang["resistance"]."</span></span>";
			}
		}
		/* Enchantment */
		if($itemguid)
		{
			if($enchantmentsData[$defines["PERMANENT"][CLIENT]])
				$tooltipText .= tooltip_addsinglerow("<span class=\"item-greenstat\">".GetNameFromDB($enchantmentsData[$defines["PERMANENT"][CLIENT]], "dbc_spellitemenchantment")."</span>");
		}
		/* Random Enchantment PART 2 */
		if($itemdata["RandomProperty"] || (CLIENT && $itemdata["RandomSuffix"]))
		{
			if($itemguid)
			{
				$RandomEnchantment = "";
				$enchvalueindex = 0;
				for($i = $FirstEnchant; $i <= $FirstEnchant+2*3; $i += 3)
				{
					$enchvalueindex ++;
					if($enchantmentsData[$i])
					{
						$RandomEnchantment = GetNameFromDB($enchantmentsData[$i], "dbc_spellitemenchantment");
						if(CLIENT && $itemdata["RandomSuffix"])
						{
							$suffixFactor = GenerateEnchSuffixFactor($itemdata["ItemLevel"], $itemdata["InventoryType"], $itemdata["Quality"]);
							$enchantvalue = round($suffixFactor*($ItemRandomData["enchvalue_".$enchvalueindex]/10000));
							$RandomEnchantment = str_replace("\$i", $enchantvalue, $RandomEnchantment);
						}
						$tooltipText .= tooltip_addsinglerow($RandomEnchantment);
					}
				}
			}
			else
				$tooltipText .= tooltip_addsinglerow("<span class=\"item-greenstat\">&lt;".$lang["random_enchantment"]."&gt;</span>");
			$itemtable .= "<br /><span class=\"bonusGreen\">&lt;".$lang["random_enchantment"]."&gt;</span>";
		}
        if (CLIENT) // sockets - tbc/wotlk
        {
            /* Sockets */
            $prismatic_already = 0;
            for($i = 1; $i <= 3; $i ++)
            {
                $socketexist = 0;
                if($itemdata["socketColor_".$i])
                {
                    switch($itemdata["socketColor_".$i])
                    {
                        case 1: $sockcol = "Meta"; $sockname = $lang["meta"]; break;
                        case 2: $sockcol = "Red"; $sockname = $lang["red"]; break;
                        case 4: $sockcol = "Yellow"; $sockname = $lang["yellow"]; break;
                        case 8: $sockcol = "Blue"; $sockname = $lang["blue"]; break;
                        default: $sockcol = "Unk"; $sockname = $lang["unk"];
                    }
                    $socketexist = 1;
                }
                else if(!$prismatic_already && $itemguid && CLIENT && $enchantmentsData[$defines["PRISMATIC_SOCKET"][CLIENT]])
                {
                    //prismatic socket
                    $sockcol = "Prismatic";
                    $sockname = $lang["prismatic"];
                    $prismatic_already = 1;
                    $socketexist = 1;
                }
                if($socketexist)
                {
                    $socketName = $sockname." ".$lang["socket"];
                    $socketIcon = "shared/global/tooltip/images/icons/Socket_".$sockcol.".png";
                    $socketColor = "setItemGray";
                    if($itemguid)
                    {
                        $socket_offset = $defines["SOCKET_1"][CLIENT]+($i-1)*3;
                        if($enchantmentsData[$socket_offset])
                        {
                            //switchConnection("armory", REALM_NAME);
                            $GemInfo = execute_query("armory","SELECT `name`, `gemid` FROM `dbc_spellitemenchantment` WHERE `id` = ".$enchantmentsData[$socket_offset], 1);
                            $socketName = $GemInfo["name"];
                            //switchConnection("mangos", REALM_NAME);
                            $socketIcon = GetIcon("item", execute_query("world", "SELECT `displayid` FROM `item_template` WHERE `entry` = ".$GemInfo["gemid"], 2));
                            $socketColor = "setItemYellow";
                        }
                    }
                    $tooltipText .= tooltip_addsinglerow("<img class=\"socketImg\" src=\"".$socketIcon."\">".$socketName, $socketColor);
                    $itemtable .= "<br /><span class=\"".$socketColor."\"><img class=\"socketImg\" src=\"".$socketIcon."\">".$socketName."</span>";
                }
            }
            //socket Bonus
            if($itemdata["socketBonus"])
            {
                if(!($SocketBonus = GetNameFromDB($itemdata["socketBonus"], "dbc_spellitemenchantment")) && $config["ShowError"])
                {
                    $tooltipText .= tooltip_addsinglerow("<span class=\"error\">".$lang["error"].": ".$lang["unknown"]." socketBonus ".$itemdata["socketBonus"].", ".$lang["report_to_gm"]."</span>");
                    $itemtable .= "<br /><span class=\"error\">".$lang["error"].": ".$lang["unknown"]." socketBonus ".$itemdata["socketBonus"].", ".$lang["report_to_gm"]."</span>";
                }
                else
                {
                    $socketBonusColor = "setItemGray";
                    if($itemguid)
                    {
                        if($enchantmentsData[$defines["SOCKET_BONUS"][CLIENT]])
                            $socketBonusColor = "setItemYellow";
                    }
                    $tooltipText .= tooltip_addsinglerow($lang["socket_bonus"].":&nbsp;".$SocketBonus, $socketBonusColor);
                    $itemtable .= "<br /><span class=\"".$socketBonusColor."\">".$lang["socket_bonus"].":&nbsp;".$SocketBonus."</span>";
                }
            }
        }

		/* Durability */
		if($itemdata["MaxDurability"])
		{
			if($itemguid)
				$tooltipText .= tooltip_addsinglerow($lang["durability"].":&nbsp;".$item_durability."&nbsp;/&nbsp;".$itemdata["MaxDurability"]);
			else
				$tooltipText .= tooltip_addsinglerow($lang["durability"].":&nbsp;".$itemdata["MaxDurability"]."&nbsp;/&nbsp;".$itemdata["MaxDurability"]);
			$itemtable .= "<br />".$lang["durability"].":&nbsp;".$itemdata["MaxDurability"]."&nbsp;/&nbsp;".$itemdata["MaxDurability"];
		}
	}
	//Requires Class
	$allowclass=$itemdata["AllowableClass"];
	if($allowclass <> -1 && ($allowclass & 1535) <> 1535)
	{
		$ClassesString = ShowAllowable($allowclass, "dbc_chrclasses");
		if($ClassesString)
		{
			$tooltipText .= tooltip_addsinglerow($lang["classes"].":".$ClassesString);
			$itemtable .= "<br />".$lang["classes"].":".$ClassesString;
		}
		else if($config["ShowError"])
		{
			$tooltipText .= tooltip_addsinglerow("<span class=\"error\">".$lang["error"].": ".$lang["unknown"]." AllowableClass ".$itemdata["AllowableClass"].", ".$lang["report_to_gm"]."</span>");
			$itemtable .= "<br /><span class=\"error\">".$lang["error"].": ".$lang["unknown"]." AllowableClass ".$itemdata["AllowableClass"].", ".$lang["report_to_gm"]."</span>";
		}
	}
	//Requires Race
	$allowrace=$itemdata["AllowableRace"];
	if($allowrace <> -1 && ($allowrace & 1791) <> 1791)
	{
		$RacesString = ShowAllowable($allowrace, "dbc_chrraces");
		if($RacesString)
		{
			$tooltipText .= tooltip_addsinglerow($lang["races"].":".$RacesString);
			$itemtable .= "<br />".$lang["races"].":".$RacesString;
		}
		else if($config["ShowError"])
		{
			$tooltipText .= tooltip_addsinglerow("<span class=\"error\">>".$lang["error"].": ".$lang["unknown"]." AllowableRace ".$itemdata["AllowableRace"].", ".$lang["report_to_gm"]."</span>");
			$itemtable .= "<br /><span class=\"error\">>".$lang["error"].": ".$lang["unknown"]." AllowableRace ".$itemdata["AllowableRace"].", ".$lang["report_to_gm"]."</span>";
		}
	}
	// Requires Level
	if($itemdata["RequiredLevel"])
	{
		$tooltipText .= tooltip_addsinglerow($lang["requires_level"]."&nbsp;".$itemdata["RequiredLevel"]);
		$itemtable .= "<br />".$lang["requires_level"]."&nbsp;".$itemdata["RequiredLevel"];
	}
	/* Required Skill (riding, blacksmithing..) */
	if($itemdata["RequiredSkill"])
	{
		$requiredSkill = GetNameFromDB($itemdata["RequiredSkill"], "dbc_skillline");
		if($requiredSkill)
		{
			$tooltipText .= tooltip_addsinglerow($lang["requires"]."&nbsp;".$requiredSkill." ".$itemdata["RequiredSkillRank"]);
			$itemtable .= "<br /><span class=\"\">".$lang["requires"]."&nbsp;</span><span class=\"\">".$requiredSkill."&nbsp;</span><span class=\"\"></span><span class=\"\">".$itemdata["RequiredSkillRank"]."</span><span class=\"\"></span>";
		}
		else if($config["ShowError"])
		{
			$tooltipText .= tooltip_addsinglerow("<span class=\"error\">".$lang["error"].": ".$lang["unknown"]." RequiredSkill ".$itemdata["RequiredSkill"].", ".$lang["report_to_gm"]."</span>");
			$itemtable .= "<br /><span class=\"error\">".$lang["error"].": ".$lang["unknown"]." RequiredSkill ".$itemdata["RequiredSkill"].", ".$lang["report_to_gm"]."</span>";
		}
	}
	// Required Spell
	if($itemdata["requiredspell"])
	{
		$requiredSpell = GetNameFromDB($itemdata["requiredspell"],"dbc_spell");
		if($requiredSpell)
		{
			$tooltipText .= tooltip_addsinglerow($lang["requires"]."&nbsp;".$requiredSpell);
			$itemtable .= "<br /><span class=\"\">".$lang["requires"]."&nbsp;</span><span class=\"\">".$requiredSpell."</span><span class=\"\"></span>";
		}
		else if($config["ShowError"])
		{
			$tooltipText .= tooltip_addsinglerow("<span class=\"error\">".$lang["error"].": ".$lang["unknown"]." requiredspell ".$itemdata["requiredspell"].", ".$lang["report_to_gm"]."</span>");
			$itemtable .= "<br /><span class=\"error\">".$lang["error"].": ".$lang["unknown"]." requiredspell ".$itemdata["requiredspell"].", ".$lang["report_to_gm"]."</span>";
		}
	}
	// Green Statistics
	if(count($greenStats))
	{
		foreach($greenStats as $key => $val)
		{
			$tooltipText .= tooltip_addsinglerow("<span class=\"item-greenstat\">".$val."</span>");
			$itemtable .= "<br /><span class=\"bonusGreen\">".$val."</span>";
		}
	}
	// Spell Data
	$showspelldata = 1;
	for($i = 1; $i <= 5; $i ++)
	{
		if($itemdata["spelltrigger_".$i] == 6)
			$showspelldata = 0;
	}
	if($showspelldata)
	{
		for($i = 1; $i <= 5; $i ++)
		{
			if($itemdata["spellid_".$i])
			{
				switch($itemdata["spelltrigger_".$i])
				{
					case 0: $spellTrigger = $lang["use"]; break;
					case 1: $spellTrigger = $lang["equip"]; break;
					case 2: $spellTrigger = $lang["hit_chance"]; break;
					default: $spellTrigger = $lang["unknown_trigger"]." ".$itemdata["spelltrigger_".$i];
				}
				//switchConnection("armory", REALM_NAME);
				$spellDescription = spell_parsedata(execute_query("armory", "SELECT * FROM `dbc_spell` WHERE `id` = ".$itemdata["spellid_".$i]." LIMIT 1", 1));
				if($spellDescription)
				{
					$tooltipText .= tooltip_addsinglerow("<span class=\"item-greenstat\">".$spellTrigger.": ".$spellDescription."</span>");
					$itemtable .= "<br /><span class=\"bonusGreen\">".$spellTrigger.": ".$spellDescription."</span>";
				}
			}
		}
	}
	/* Item Set Data */
	if($itemdata["itemset"])
	{
		/* Get Set Name */
		//switchConnection("armory", REALM_NAME);
		$setData = execute_query("armory", "SELECT * FROM `dbc_itemset` WHERE `id` = ".$itemdata["itemset"]." LIMIT 1", 1);
		$setName = $setData["name"];
		for($i = 1; $i <= 8; $i ++)
			$setItemsIds[] = $setData["item_".$i];
		/* Get Items in set */
		//switchConnection("mangos", REALM_NAME);
		$setItemsQuery = "SELECT `entry`, `name` FROM `item_template` WHERE ";
		$nameloc="name_loc".$config["locales"];
		if($config["locales"])
			$setItemsQuery = "SELECT item_template.`entry`, `name`, `".$nameloc."` FROM `item_template` LEFT JOIN `locales_item` ON `item_template`.`entry` = `locales_item`.`entry` WHERE ";
		else
			$setItemsQuery = "SELECT `entry`, `name` FROM `item_template` WHERE ";
		if(in_array($itemid, $setItemsIds))
		{
			$setItemsQuery .= "`item_template`.`entry` IN (";
			foreach($setItemsIds as $value)
				$setItemsQuery .= $value.",";
			$setItemsQuery .= "0)";
		}
		else // Hack for gladiator sets
			$setItemsQuery .= "`itemset` = ".$itemdata["itemset"]." AND `ItemLevel` = ".$itemdata["ItemLevel"]." AND `Quality` = ".$itemdata["Quality"];
		$setItemsQueryexecute = execute_query("world", $setItemsQuery);
		$owned_count = 0;
		foreach ($setItemsQueryexecute as $setItemData)
        {
            if(!empty($setItemData[$nameloc]))
                $setItemData["name"] = $setItemData[$nameloc];
            $setItems[$setItemData["entry"]] = $setItemData["name"];
            if(in_array($setItemData["entry"], $itemlist))
                $owned_count ++;
        }
		/*while($setItemData = mysql_fetch_assoc($setItemsQueryexecute))
		{
			if(!empty($setItemData[$nameloc]))
				$setItemData["name"] = $setItemData[$nameloc];
			$setItems[$setItemData["entry"]] = $setItemData["name"];
			if(in_array($setItemData["entry"], $itemlist))
				$owned_count ++;
		}*/
		$tooltipText .= tooltip_addsinglerow("<br />".$setName." (".$owned_count."/".count($setItems).")", "item-set-name");
		$itemtable .= "<br /><br /><span class=\"setNameYellow\">".$setName." (".$owned_count."/".count($setItems).")</span><div class=\"setItemIndent\">";
		/* Output items in set */
		foreach($setItems as $itemID => $itemName)
		{
			if(in_array($itemID, $itemlist))
				$tooltipText .= tooltip_addsinglerow($itemName, "item-set-item-acquired"); // Player has this item
			else
				$tooltipText .= tooltip_addsinglerow($itemName, "item-set-item-unacquired"); // Player does not have this item
			$itemtable .= "<br /><span class=\"setItemGray\">".$itemName."</span>";
		}
		$tooltipText .= tooltip_addsinglerow("<br />");
		$itemtable .= "</div><br />";
		for($i = 1; $i <= 8; $i ++)
		{
			if($setData["bonus_".$i])
			{
				//How many pieces do we need?
				$requiredSetPieces = $setData["pieces_".$i];
				//SET BONUSES
				//switchConnection("armory", REALM_NAME);
				$setBonus = spell_parsedata(execute_query("armory", "SELECT * FROM `dbc_spell` WHERE `id` = ".$setData["bonus_".$i]." LIMIT 1", 1));
				if($owned_count >= $requiredSetPieces)
					$tooltipText .= tooltip_addsinglerow("(".$requiredSetPieces.") ".$lang["set"].": ".$setBonus, "item-set-item-acquired");
				else
					$tooltipText .= tooltip_addsinglerow("(".$requiredSetPieces.") ".$lang["set"].": ".$setBonus, "item-set-item-unacquired");
				$itemtable .= "<br /><span class=\"setItemGray\">(".$requiredSetPieces.") ".$lang["set"].": ".$setBonus."</span>";
			}
		}
	}
	/* Flavour Text */
	if($itemdata["description"] != NULL)
	{
		$tooltipText .= tooltip_addsinglerow("<span class=\"myYellow\">&quot;".$itemdata["description"]."&quot;</span>");
		$itemtable .= "<br /><span class=\"myYellow\">&quot;".$itemdata["description"]."&quot;</span>";
	}
	/* Item Source */
	if($config["ShowSource"])
	{
		//switchConnection("armory", REALM_NAME);
		$SourceQuery = execute_query("armory", "SELECT `item_source` FROM `cache_item_search` WHERE `item_id` = ".$itemid." LIMIT 1", 1);
		if($SourceQuery)
			$ItemSource = $SourceQuery["item_source"];
		else
		{
			$item_search_cache = cache_item_search($itemid);
			$ItemSource = $item_search_cache["item_source"];
		}
		$tooltipText .= "<tr><td colspan=\"2\"><br /><span class=\"myYellow\">".$lang["source"].":&nbsp;</span><span class=\"\">".$ItemSource."</span></td></tr>";
		$itemtable .= "<br /><br /><span class=\"myYellow\">".$lang["source"].":&nbsp;</span><span class=\"\">".$ItemSource."</span>";
	}
	$tooltipText .= "</table>";
	$itemtable .= "</div>";
	return $itemguid ? $tooltipText : array($tooltipText, $itemtable);
}
?>