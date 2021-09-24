	var talentsTreeOne = talentsTreeArray[0];
	var talentsTreeTwo = talentsTreeArray[1];
	var talentsTreeThree = talentsTreeArray[2];
	var talentSpecText = "";

	function sortArray(a, b){
		result = b[1] - a[1];
		return result;
	}

	talentsTreeArray = talentsTreeArray.sort(sortArray);
	
	if (talentsTreeArray[0][1] == 0) {
		highest = -1;
	} else {	
		highest = talentsTreeArray[0][0];
		if ((3 * (talentsTreeArray[1][1] - talentsTreeArray[2][1])) >= (2 * (talentsTreeArray[0][1] - talentsTreeArray[2][1])))
			highest = 0;
	}

	if (highest == 1 || highest == 2 || highest == 3)
		talentSpecText = talentsTreeArray[0][2];
	else if (highest == 0)
		talentSpecText = textHybrid; 
	else
		talentSpecText = textUntalented;

	document.getElementById('replaceTalentSpecText').innerHTML = talentSpecText;

	if (highest > 0)
		document.getElementById('talentSpecImage').src = "images/icons/class/"+ theClassId +"/talents/"+ highest +".png";
	else if (highest == 0)
		document.getElementById('talentSpecImage').src = "images/icons/class/talents/hybrid.gif";
	else
		document.getElementById('talentSpecImage').src = "images/icons/class/talents/untalented.gif";
		

function resistancesTextObject() {
	this.arcane = new resistArcaneTextObject();
	this.fire = new resistFireTextObject();
	this.nature = new resistNatureTextObject();
	this.frost = new resistFrostTextObject();
	this.shadow = new resistShadowTextObject();			
}
function textObject() {
	this.resistances = new resistancesTextObject();
	this.baseStats = new baseStatsTextObject();
	this.melee = new meleeTextObject();
	this.ranged = new rangedTextObject();
	this.spell = new spellTextObject();
	this.defenses = new defensesTextObject();
}

function resistArcaneTextObject() {
	this.tooltip = arcaneTooltip;
	var petBonus = theCharacter.resistances.arcane.petBonus;
	if (petBonus != -1)
		this.tooltip += arcanePetBonus;
}

function resistFireTextObject() {
	this.tooltip = fireTooltip;
	var petBonus = theCharacter.resistances.fire.petBonus;
	if (petBonus != -1)
		this.tooltip += firePetBonus;		
}

function resistNatureTextObject() {
	this.tooltip = natureTooltip;
	var petBonus = theCharacter.resistances.nature.petBonus;
	if (petBonus != -1)
		this.tooltip += naturePetBonus;		
}

function resistFrostTextObject() {

	this.tooltip = frostTooltip;
	var petBonus = theCharacter.resistances.frost.petBonus;
	if (petBonus != -1)
		this.tooltip += frostPetBonus;		
}

function resistShadowTextObject() {

	this.tooltip = shadowTooltip;
	var petBonus = theCharacter.resistances.shadow.petBonus;
	if (petBonus != -1)
		this.tooltip += shadowPetBonus;		
}

function strengthTextObject() {

	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.baseStats.strength.base, theCharacter.baseStats.strength.diff);

	var title = "&lt;span class='tooltipTitle'&gt;"+ baseStatsStrengthTitle + theCharacter.baseStats.strength.effective + titleAppend[0] +"&lt;/span&gt;";
	var attack = spanYellow + baseStatsStrengthAttack + spanYellowEnd;
	var block = (isApplicable(theCharacter.baseStats.strength.block))? spanYellow + baseStatsStrengthBlock + spanYellowEnd : '';	

	this.value = theCharacter.baseStats.strength.effective;
	this.effectiveColor = titleAppend[1];
	this.display = baseStatsStrengthDisplay;	
	this.mouseover = title + attack + block;
	
}

function agilityTextObject() {

	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.baseStats.agility.base, theCharacter.baseStats.agility.diff);
	
	var title = "&lt;span class='tooltipTitle'&gt;"+ baseStatsAgilityTitle + theCharacter.baseStats.agility.effective + titleAppend[0] +"&lt;/span&gt;";
	var attack = (isApplicable(theCharacter.baseStats.agility.attack))? spanYellow + baseStatsAgilityAttack + spanYellowEnd : '';
	var critHitPercent = spanYellow + baseStatsAgilityCritHitPercent + spanYellowEnd;
	var armor = (isApplicable(theCharacter.baseStats.agility.armor))? spanYellow + baseStatsAgilityArmor + spanYellowEnd : '';

	this.value = theCharacter.baseStats.agility.effective;
	this.effectiveColor = titleAppend[1];
	this.display = baseStatsAgilityDisplay;	
	this.mouseover = title + attack  + critHitPercent + armor;
	
}

function staminaTextObject() {

	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.baseStats.stamina.base, theCharacter.baseStats.stamina.diff);

	var title = "&lt;span class='tooltipTitle'&gt;"+ baseStatsStaminaTitle + theCharacter.baseStats.stamina.effective + titleAppend[0] +"&lt;/span&gt;";
	var health = (isApplicable(theCharacter.baseStats.stamina.health))? spanYellow + baseStatsStaminaHealth + spanYellowEnd : '';
	var petBonus = (isApplicable(theCharacter.baseStats.stamina.petBonus))? spanYellow + baseStatsStaminaPetBonus + spanYellowEnd : '';

	this.value = theCharacter.baseStats.stamina.effective;
	this.effectiveColor = titleAppend[1];
	this.display = baseStatsStaminaDisplay;	
	this.mouseover = title + health + petBonus;

}

function intellectTextObject() {

	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.baseStats.intellect.base, theCharacter.baseStats.intellect.diff);

	var title = "&lt;span class='tooltipTitle'&gt;"+ baseStatsIntellectTitle + theCharacter.baseStats.intellect.effective + titleAppend[0] + "&lt;/span&gt;";
	var mana = (isApplicable(theCharacter.baseStats.intellect.mana))? spanYellow + baseStatsIntellectMana + spanYellowEnd : '';
	var critHitPercent = (isApplicable(theCharacter.baseStats.intellect.critHitPercent))? spanYellow + baseStatsIntellectCritHitPercent + spanYellowEnd : '';
	var petBonus = (isApplicable(theCharacter.baseStats.intellect.petBonus))? spanYellow + baseStatsIntellectPetBonus + spanYellowEnd : '';	
	
	this.value = theCharacter.baseStats.intellect.effective;
	this.effectiveColor = titleAppend[1];
	this.display = baseStatsIntellectDisplay;	
	this.mouseover = title + mana + critHitPercent + petBonus;
	
}

function spiritTextObject() {

	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.baseStats.spirit.base, theCharacter.baseStats.spirit.diff);

	var title = "&lt;span class='tooltipTitle'&gt;"+ baseStatsSpiritTitle + theCharacter.baseStats.spirit.effective + titleAppend[0] + "&lt;/span&gt;";
	var healthRegen = (isApplicable(theCharacter.baseStats.spirit.healthRegen))? spanYellow + baseStatsSpiritHealthRegen + spanYellowEnd : '';	
	var manaRegen = (isApplicable(theCharacter.baseStats.spirit.manaRegen))? spanYellow + baseStatsSpiritManaRegen + spanYellowEnd : '';	
	
	this.value = theCharacter.baseStats.spirit.effective;
	this.effectiveColor = titleAppend[1];
	this.display = baseStatsSpiritDisplay;	
	this.mouseover = title + healthRegen + manaRegen;
	
}

function armorTextObject() {

	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.baseStats.armor.base, theCharacter.baseStats.armor.diff);

	var title = "&lt;span class='tooltipTitle'&gt;"+ baseStatsArmorTitle + theCharacter.baseStats.armor.effective + titleAppend[0] +"&lt;/span&gt;";
	var reductionPercent = (isApplicable(theCharacter.baseStats.armor.reductionPercent))? spanYellow + baseStatsArmorReductionPercent + spanYellowEnd : '';	
	var petBonus = (isApplicable(theCharacter.baseStats.armor.petBonus))? spanYellow + baseStatsArmorPetBonus + spanYellowEnd : '';	
	
	this.value = theCharacter.baseStats.armor.effective;
	this.effectiveColor = titleAppend[1];
	this.display = baseStatsArmorDisplay;	
	this.mouseover = title + reductionPercent + petBonus;
}

function baseStatsTextObject() {
	this.display = baseStatsDisplay;
	this.strength = new strengthTextObject();
	this.agility = new agilityTextObject();
	this.stamina = new staminaTextObject();
	this.intellect = new intellectTextObject();
	this.spirit = new spiritTextObject();
	this.armor = new armorTextObject();
}

function meleeTextObject() {
	this.display = meleeDisplay;
	this.weaponSkill = new meleeWeaponSkillTextObject();
	this.damage = new meleeDamageTextObject();
	this.speed = new meleeSpeedTextObject();
	this.power = new meleePowerTextObject();
	this.hitRating = new meleeHitRatingTextObject();
	this.critChance = new meleeCritChanceTextObject();
}

function meleeWeaponSkillTextObject() {

	var titleAppend = new Array;

	var mainHandTitle = "&lt;span class='tooltipTitle'&gt;"+ meleeExpertiseTitle +"&lt;/span&gt;";
	var mainHandWeaponSkill = spanYellow + meleeMainHandWeaponSkill + spanYellowEnd;
	var mainHandWeaponRating = spanYellow + meleeMainHandWeaponRating + spanYellowEnd;

/*	var offHandTitle = "";
	var offHandWeaponSkill = "";
	var offHandWeaponRating = "";
	
	if (theClassId == rogueId || theClassId == warriorId || theClassId == hunterId ) {
		if (theCharacter.melee.weaponSkill.offHandWeaponSkill.value != 0 && theCharacter.melee.speed.offHandSpeed.value != 1) {
			if (isApplicable(theCharacter.melee.weaponSkill.offHandWeaponSkill.value)) {
				offHandTitle = "&lt;br/&gt;&lt;span class='tooltipTitle'&gt;"+ meleeOffHandTitle +"&lt;/span&gt;";
				offHandWeaponSkill = spanYellow + meleeOffHandWeaponSkill + spanYellowEnd;
				offHandWeaponRating = spanYellow + meleeOffHandWeaponRating + spanYellowEnd;
			}
		}
	}*/
	
	this.value = theCharacter.melee.weaponSkill.mainHandWeaponSkill.value;
	this.display = meleeWeaponSkillDisplay;
	this.mouseover = mainHandTitle + mainHandWeaponSkill + mainHandWeaponRating /*+ offHandTitle + offHandWeaponSkill + offHandWeaponRating*/;
	
}

function meleeDamageTextObject() {

	var titleAppend = new Array;

	var mainHandTitle = "&lt;span class='tooltipTitle'&gt;"+ meleeMainHandTitle +"&lt;/span&gt;";
	var mainHandAttackSpeed = spanYellow + meleeDamageMainHandAttackSpeed;
	var mainHandDamage = meleeDamageMainHandDamage;
	var mainHandDamagePercent = (theCharacter.melee.damage.mainHandDamage.percent != "0")? meleeDamageMainHandPercent + "&lt;/span&gt;"+ meleeDamageDisplay +"&lt;br/&gt;" : "&lt;/span&gt;"+ meleeDamageDisplay +"&lt;br/&gt;";
	var mainHandDps = meleeDamageMainHandDps + spanYellowEnd;

	var offHandTitle = "";
	var offHandAttackSpeed = "";
	var offHandDamage = "";
	var offHandDamagePercent = "";
	var offHandDps = "";	

	if (theClassId == rogueId || theClassId == warriorId || theClassId == hunterId ) {
		if (theCharacter.melee.weaponSkill.offHandWeaponSkill.value != 0 && theCharacter.melee.speed.offHandSpeed.value != 1) {
			if (theCharacter.melee.damage.offHandDamage.max > 0) {
				offHandTitle = "&lt;br/&gt;&lt;span class='tooltipTitle'&gt;"+ meleeOffHandTitle +"&lt;/span&gt;";
				offHandAttackSpeed = spanYellow + meleeDamageOffHandAttackSpeed;
				offHandDamage = meleeDamageOffHandDamage;
				offHandDamagePercent = (theCharacter.melee.damage.offHandDamage.percent != "0")? meleeDamageOffHandPercent +"&lt;/span&gt;"+ meleeDamageDisplay +"&lt;br/&gt;" : "&lt;/span&gt;"+ meleeDamageDisplay +"&lt;br/&gt;";
				offHandDps =  meleeDamageOffHandDps + spanYellowEnd;
			}
		}
	}

	this.value = theCharacter.melee.damage.mainHandDamage.min +" - "+ theCharacter.melee.damage.mainHandDamage.max;	
	this.display = meleeDamageDisplay;
	this.mouseover = "&lt;div class='meleeDamageWidth'&gt;" + mainHandTitle + mainHandAttackSpeed + mainHandDamage + mainHandDamagePercent + mainHandDps + offHandTitle + offHandAttackSpeed + offHandDamage + offHandDamagePercent + offHandDps + "&lt;/div&gt;";
}

function meleeSpeedTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;" + meleeSpeedTitle + theCharacter.melee.speed.mainHandSpeed.value;
	var titleAppend = "";
	var haste = spanYellow + meleeSpeedHaste + spanYellowEnd;
	
	this.offHand = "";
	if (theClassId == rogueId || theClassId == warriorId || theClassId == hunterId ) {
		if (theCharacter.melee.weaponSkill.offHandWeaponSkill.value != 0 && theCharacter.melee.speed.offHandSpeed.value != 1) {
			titleAppend = (isApplicable(theCharacter.melee.speed.offHandSpeed.value))? " / "+ theCharacter.melee.speed.offHandSpeed.value +"&lt;/span&gt;": "&lt;/span&gt;";
			this.offHand = (isApplicable(theCharacter.melee.speed.offHandSpeed.value))? " / "+ theCharacter.melee.speed.offHandSpeed.value : "";
		}
	}
	
	this.value = theCharacter.melee.speed.mainHandSpeed.value + this.offHand;
	this.display = meleeSpeedDisplay;	
	this.mouseover = title + titleAppend + haste;

}

function meleePowerTextObject() {

	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.melee.power.base, theCharacter.melee.power.diff);

	var title = "&lt;span class='tooltipTitle'&gt;"+ meleePowerTitle + theCharacter.melee.power.effective + titleAppend[0] +"&lt;/span&gt;";
	var increasedDps = spanYellow + meleePowerIncreasedDps + spanYellowEnd;
	
	this.value = theCharacter.melee.power.effective;	
	this.effectiveColor = titleAppend[1];
	this.display = meleePowerDisplay;	
	this.mouseover = title + increasedDps;

}

function meleeHitRatingTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ meleeHitRatingTitle + theCharacter.melee.hitRating.value +"&lt;/span&gt;";
	var increasedHitPercent = spanYellow + meleeHitRatingIncreasedHitPercent + spanYellowEnd;
	
	this.value = theCharacter.melee.hitRating.value;
	this.display = meleeHitRatingDisplay;	
	this.mouseover = title + increasedHitPercent;

}

function meleeCritChanceTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ meleeCritChanceTitle + theCharacter.melee.critChance.percent +"% &lt;/span&gt;";
	var rating = spanYellow + meleeCritChanceRating + spanYellowEnd;
	
	this.value = theCharacter.melee.critChance.percent;	
	this.display = meleeCritChanceDisplay;	
	this.mouseover = title + rating;

}

function rangedTextObject() {
	this.display = rangedDisplay;
	this.weaponSkill = new rangedWeaponSkillTextObject();
	this.damage = new rangedDamageTextObject();
	this.speed = new rangedSpeedTextObject();
	this.power = new rangedPowerTextObject();
	this.hitRating = new rangedHitRatingTextObject();
	this.critChance = new rangedCritChanceTextObject();
}

function rangedWeaponSkillTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ rangedWeaponSkillTitle + theCharacter.ranged.weaponSkill.value +"&lt;/span&gt;";
	var rating = spanYellow + rangedWeaponSkillRating + spanYellowEnd;

	if (theCharacter.classId == shamanId || theCharacter.classId == paladinId || theCharacter.classId == druidId) {
		this.value = textNA;
		this.mouseover = textNotApplicable;
	} else {
		this.value = theCharacter.ranged.weaponSkill.value;
		this.mouseover = title + rating;
	}

	this.display = rangedWeaponSkillDisplay;

}

function rangedDamageTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ rangedDamageTitle +"&lt;/span&gt;&lt;br/&gt;";
	var speed = rangedDamageSpeed;
	var damage = rangedDamageDamage;

	var damagePercent = (theCharacter.ranged.damage.percent)? rangedDamageDamagePercent +"&lt;/span&gt;"+ rangedDamageDisplay +"&lt;br/&gt;" : "&lt;/span&gt;"+ rangedDamageDisplay +"&lt;br/&gt;";
	var dps = rangedDamageDps;

	if (theCharacter.classId == shamanId || theCharacter.classId == paladinId || theCharacter.classId == druidId) {
		this.value = textNA;
		this.mouseover = textNotApplicable;
	} else {
		this.value = theCharacter.ranged.damage.min +" - "+ theCharacter.ranged.damage.max ;	
		this.mouseover = "&lt;div class='meleeDamageWidth'&gt;" + title + spanYellow + speed + damage + damagePercent + dps + spanYellowEnd + "&lt;/div&gt;";
	}

	this.display = rangedDamageDisplay;
	
}

function rangedSpeedTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ rangedSpeedTitle +"&lt;/span&gt;";
	var haste = spanYellow + rangedSpeedHaste + spanYellowEnd;

	if (theCharacter.classId == shamanId || theCharacter.classId == paladinId || theCharacter.classId == druidId) {
		this.value = textNA;
		this.mouseover = textNotApplicable;
	} else {	
		this.value = theCharacter.ranged.speed.value;	
		this.mouseover = title + haste;
	}

	this.display = rangedSpeedDisplay;	

}

function rangedPowerTextObject() {

	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.ranged.power.base, theCharacter.ranged.power.diff);

	var title = "&lt;span class='tooltipTitle'&gt;"+ rangedPowerTitle + theCharacter.ranged.power.effective + titleAppend[0] +"&lt;/span&gt;";
	var increasedDps = spanYellow + rangedPowerIncreasedDps + spanYellowEnd;
	
	var petAttack = (isApplicable(theCharacter.ranged.power.petAttack)) ? spanYellow + rangedPowerPetAttack + spanYellowEnd : "";
	var petSpell = (isApplicable(theCharacter.ranged.power.petSpell)) ? spanYellow + rangedPowerPetSpell + spanYellowEnd : "";

	this.value = theCharacter.ranged.power.effective;	
	this.effectiveColor = titleAppend[1];
	this.display = rangedPowerDisplay;	
	this.mouseover = title + increasedDps + petAttack + petSpell;

}

function rangedHitRatingTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ rangedHitRatingTitle +theCharacter.ranged.hitRating.value +"&lt;/span&gt;";
	var increasedHitPercent = spanYellow + rangedHitRatingIncreasedPercent + spanYellowEnd;

	this.value = theCharacter.ranged.hitRating.value;		
	this.display = rangedHitRatingDisplay;	
	this.mouseover = title + increasedHitPercent;

}

function rangedCritChanceTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ rangedCritChanceTitle + theCharacter.ranged.critChance.percent +"%&lt;/span&gt;";
	var rating = spanYellow + rangedCritChanceRating + spanYellowEnd;
	
	this.value = theCharacter.ranged.critChance.percent;		
	this.display = rangedCritChanceDisplay;	
	this.mouseover = title + rating;

}

function spellTextObject() {
	this.display = spellDisplay;
	this.bonusDamage = new spellBonusDamageTextObject();
	this.bonusHealing = new spellBonusHealingTextObject();
	this.hitRating = new spellHitRatingTextObject();
	this.critChance = new spellCritChanceTextObject();
	this.hasteRating = new spellHasteRatingTextObject();
	this.manaRegen = new spellManaRegenTextObject();
}

function spellBonusDamageTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ spellBonusDamageTitle +theCharacter.spell.bonusDamage.value +"&lt;/span&gt;&lt;br/&gt;";
	var holy = "&lt;span class='floatRight'&gt;"+theCharacter.spell.bonusDamage.holy +"&lt;/span&gt;&lt;span class = 'icon-holy'&gt;"+ textHoly +"&lt;/span&gt;&lt;br/&gt;";
	var fire = "&lt;span class='floatRight'&gt;"+theCharacter.spell.bonusDamage.fire +"&lt;/span&gt;&lt;span class = 'icon-fire'&gt;"+ textFire +"&lt;/span&gt;&lt;br/&gt;";
	var nature = "&lt;span class='floatRight'&gt;"+theCharacter.spell.bonusDamage.nature +"&lt;/span&gt;&lt;span class = 'icon-nature'&gt;"+ textNature +"&lt;/span&gt;&lt;br/&gt;";
	var frost = "&lt;span class='floatRight'&gt;"+theCharacter.spell.bonusDamage.frost +"&lt;/span&gt;&lt;span class = 'icon-frost'&gt;"+ textFrost +"&lt;/span&gt;&lt;br/&gt;";
	var shadow = "&lt;span class='floatRight'&gt;"+theCharacter.spell.bonusDamage.shadow +"&lt;/span&gt;&lt;span class = 'icon-shadow'&gt;"+ textShadow +"&lt;/span&gt;&lt;br/&gt;";
	var arcane = "&lt;span class='floatRight'&gt;"+theCharacter.spell.bonusDamage.arcane +"&lt;/span&gt;&lt;span class = 'icon-arcane'&gt;"+ textArcane +"&lt;/span&gt;&lt;br/&gt;";
	var fromType = theCharacter.spell.bonusDamage.petBonusFromType;
	
	if (fromType == "fire")
		var petBonus = (isApplicable(theCharacter.spell.bonusDamage.petBonusAttack))? spellBonusDamagePetBonusFire : '';
	else
		var petBonus = (isApplicable(theCharacter.spell.bonusDamage.petBonusAttack))? spellBonusDamagePetBonusShadow : '';

	this.value = theCharacter.spell.bonusDamage.value;
	this.display = spellBonusDamageDisplay;
	this.mouseover = title + spanYellow + holy + fire + nature + frost + shadow + arcane + petBonus + spanYellowEnd;
	
}

function spellBonusHealingTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ spellBonusHealingTitle +"&lt;/span&gt;";
	var bonusHealing = spanYellow + spellBonusHealingValue + spanYellowEnd;

	this.value = theCharacter.spell.bonusHealing.value;
	this.display = spellBonusHealingDisplay;
	this.mouseover = title + bonusHealing;
	
}

function spellHitRatingTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ spellHitRatingTitle +theCharacter.spell.hitRating.value +"&lt;/span&gt;";
	var increasedHitPercent = spanYellow + spellHitRatingIncreasedPercent + spanYellowEnd;

	this.value = theCharacter.spell.hitRating.value;
	this.display = spellHitRatingDisplay;
	this.mouseover = title + increasedHitPercent;
	
}

function spellCritChanceTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;" + spellCritChanceTitle +theCharacter.spell.critChance.rating +"&lt;/span&gt;&lt;br/&gt;";
	var holy = "&lt;span class='floatRight'&gt;"+theCharacter.spell.critChance.holy +"%&lt;/span&gt;&lt;span class = 'icon-holy'&gt;"+ textHoly +"&lt;/span&gt;&lt;br/&gt;";
	var fire = "&lt;span class='floatRight'&gt;"+theCharacter.spell.critChance.fire +"%&lt;/span&gt;&lt;span class = 'icon-fire'&gt;"+ textFire +"&lt;/span&gt;&lt;br/&gt;";
	var nature = "&lt;span class='floatRight'&gt;"+theCharacter.spell.critChance.nature +"%&lt;/span&gt;&lt;span class = 'icon-nature'&gt;"+ textNature +"&lt;/span&gt;&lt;br/&gt;";
	var frost = "&lt;span class='floatRight'&gt;"+theCharacter.spell.critChance.frost +"%&lt;/span&gt;&lt;span class = 'icon-frost'&gt;"+ textFrost +"&lt;/span&gt;&lt;br/&gt;";
	var shadow = "&lt;span class='floatRight'&gt;"+theCharacter.spell.critChance.shadow +"%&lt;/span&gt;&lt;span class = 'icon-shadow'&gt;"+ textShadow +"&lt;/span&gt;&lt;br/&gt;";
	var arcane = "&lt;span class='floatRight'&gt;"+theCharacter.spell.critChance.arcane +"%&lt;/span&gt;&lt;span class = 'icon-arcane'&gt;"+ textArcane +"&lt;/span&gt;&lt;br/&gt;";			

	this.value = theCharacter.spell.critChance.percent;
	this.display = spellCritChanceDisplay;
	this.mouseover = "&lt;div class='spellCritWidth'&gt;" + title + spanYellow + holy + fire + nature + frost + shadow + arcane + spanYellowEnd + "&lt;/div&gt;";
	
}

function spellHasteRatingTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ spellHasteRatingTitle +"&lt;/span&gt;";
	var tooltip = spanYellow + spellHasteRatingTooltip + spanYellowEnd;

	this.value = theCharacter.spell.hasteRating.value;
	this.display = spellHasteRatingDisplay;
	this.mouseover = title + tooltip;

}

function spellManaRegenTextObject() {

	var title = "&lt;span class='tooltipTitle'&gt;"+ spellManaRegenTitle +"&lt;/span&gt;";
	var notCasting = spanYellow + spellManaRegenNotCasting + spanYellowEnd;
	var casting = spanYellow + spellManaRegenCasting + spanYellowEnd;

	if (theCharacter.classId == rogueId || theCharacter.classId == warriorId || theCharacter.classId == deathknightId) {
		this.value = textNA;
		this.mouseover = textNotApplicable;
	} else {
		this.value = theCharacter.spell.manaRegen.notCasting;	
		this.mouseover = title + notCasting + casting;
	}

	this.display = spellManaRegenDisplay;

}

function defensesTextObject() {
	this.display = defensesDisplay;
	this.armor = new defensesArmorTextObject();
	this.defense = new defensesDefenseTextObject();
	this.dodge = new defensesDodgeTextObject();
	this.parry = new defensesParryTextObject();
	this.block = new defensesBlockTextObject();
	this.resilience = new defensesResilienceTextObject(); 
}

function defensesArmorTextObject() {

	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.baseStats.armor.base, theCharacter.baseStats.armor.diff);

	var title = "&lt;span class='tooltipTitle'&gt;"+ baseStatsArmorTitle + theCharacter.baseStats.armor.effective + titleAppend[0] +"&lt;/span&gt;";
	var reductionPercent = (isApplicable(theCharacter.baseStats.armor.reductionPercent))? spanYellow + baseStatsArmorReductionPercent + spanYellowEnd : '';	
	var petBonus = (isApplicable(theCharacter.baseStats.armor.petBonus))? spanYellow + baseStatsArmorPetBonus + spanYellowEnd : '';	
	
	this.value = theCharacter.baseStats.armor.effective;
	this.effectiveColor = titleAppend[1];
	this.display = baseStatsArmorDisplay;	
	this.mouseover = title + reductionPercent + petBonus;
}

function defensesDefenseTextObject() {
	var titleAppend = new Array;
	titleAppend = getBaseStatsTitleAppend(theCharacter.defenses.defense.value, theCharacter.defenses.defense.plusDefense);
	var title = "&lt;span class='tooltipTitle'&gt;"+ defensesDefenseTitle +theCharacter.defenses.defense.value  +"&lt;/span&gt;";
	var rating = spanYellow + defensesDefenseRating + spanYellowEnd;
	var increasePercent = spanYellow + defensesDefenseIncreasePercent + spanYellowEnd;
	var decreasePercent = spanYellow + defensesDefenseDecreasePercent + spanYellowEnd;

	this.value = theCharacter.defenses.defense.value;
	this.effectiveColor = titleAppend[1];
	this.display = defensesDefenseDisplay;
	this.mouseover = title + rating + increasePercent + decreasePercent;
}

function defensesDodgeTextObject() {
	var title = "&lt;span class='tooltipTitle'&gt;"+ defensesDodgeTitle +theCharacter.defenses.dodge.rating +"&lt;/span&gt;";
	var percent = spanYellow + defensesDodgePercent + spanYellowEnd;

	this.value = theCharacter.defenses.dodge.percent;
	this.display = defensesDodgeDisplay;
	this.mouseover = title + percent;
}

function defensesParryTextObject() {
	var title = "&lt;span class='tooltipTitle'&gt;"+ defensesParryTitle +theCharacter.defenses.parry.rating +"&lt;/span&gt;";
	var percent = spanYellow + defensesParryPercent + spanYellowEnd;

	this.value = theCharacter.defenses.parry.percent;
	this.display = defensesParryDisplay;
	this.mouseover = title + percent;
}

function defensesBlockTextObject() {
	var title = "&lt;span class='tooltipTitle'&gt;"+ defensesBlockTitle +theCharacter.defenses.block.rating +"&lt;/span&gt;";
	var percent = spanYellow + defensesBlockPercent + "&lt;/span&gt;" + spanYellowEnd;

	this.value = theCharacter.defenses.block.percent;
	this.display = defensesBlockDisplay;
	this.mouseover = title + percent;
}

function defensesResilienceTextObject() {
	var title = "&lt;span class='tooltipTitle'&gt;"+ defensesResilienceTitle +theCharacter.defenses.resilience.value +"&lt;/span&gt;";
	var hitPercent = spanYellow + defensesResilienceHitPercent + spanYellowEnd;
	var damagePercent = spanYellow + defensesResilienceDamagePercent + spanYellowEnd;

	this.value = theCharacter.defenses.resilience.value;
	this.display = defensesResilienceDisplay;
	this.mouseover = title + hitPercent + damagePercent;
}

var theText = new textObject();

var replaceStringBaseStats = '<ul>';
replaceStringBaseStats += '<li onMouseover="javascript: showTip(\&quot;'+ theText.baseStats.strength.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.baseStats.strength.display +'</span><i '+ theText.baseStats.strength.effectiveColor +'>'+ theText.baseStats.strength.value +'</i></li>';
replaceStringBaseStats += '<li onMouseover="javascript: showTip(\&quot;'+ theText.baseStats.agility.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.baseStats.agility.display +'</span><i '+ theText.baseStats.agility.effectiveColor +'>'+ theText.baseStats.agility.value +'</i></li>';
replaceStringBaseStats += '<li onMouseover="javascript: showTip(\&quot;'+ theText.baseStats.stamina.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.baseStats.stamina.display +'</span><i '+ theText.baseStats.stamina.effectiveColor +'>'+ theText.baseStats.stamina.value +'</i></li>';
replaceStringBaseStats += '<li onMouseover="javascript: showTip(\&quot;'+ theText.baseStats.intellect.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.baseStats.intellect.display +'</span><i '+ theText.baseStats.intellect.effectiveColor +'>'+ theText.baseStats.intellect.value +'</i></li>';
replaceStringBaseStats += '<li onMouseover="javascript: showTip(\&quot;'+ theText.baseStats.spirit.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.baseStats.spirit.display +'</span><i '+ theText.baseStats.spirit.effectiveColor +'>'+ theText.baseStats.spirit.value +'</i></li>';
replaceStringBaseStats += '<li onMouseover="javascript: showTip(\&quot;'+ theText.baseStats.armor.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.baseStats.armor.display +'</span><i '+ theText.baseStats.armor.effectiveColor +'>'+ theText.baseStats.armor.value +'</i></li>';
replaceStringBaseStats += "</ul>";


var replaceStringMelee = '<ul>';
replaceStringMelee += '<li onMouseover="javascript: showTip(\&quot;'+ theText.melee.damage.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.melee.damage.display +'</span><i '+ theText.melee.damage.effectiveColor +'>'+ theText.melee.damage.value +'</i></li>';
replaceStringMelee += '<li onMouseover="javascript: showTip(\&quot;'+ theText.melee.speed.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.melee.speed.display +'</span><i '+ theText.melee.speed.effectiveColor +'>'+ theText.melee.speed.value +'</i></li>';
replaceStringMelee += '<li onMouseover="javascript: showTip(\&quot;'+ theText.melee.power.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.melee.power.display +'</span><i '+ theText.melee.power.effectiveColor +'>'+ theText.melee.power.value +'</i></li>';
replaceStringMelee += '<li onMouseover="javascript: showTip(\&quot;'+ theText.melee.hitRating.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.melee.hitRating.display +'</span><i '+ theText.melee.hitRating.effectiveColor +'>'+ theText.melee.hitRating.value +'</i></li>';
replaceStringMelee += '<li onMouseover="javascript: showTip(\&quot;'+ theText.melee.critChance.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.melee.critChance.display +'</span><i '+ theText.melee.critChance.effectiveColor +'>'+ theText.melee.critChance.value +'%</i></li>';
replaceStringMelee += '<li onMouseover="javascript: showTip(\&quot;'+ theText.melee.weaponSkill.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.melee.weaponSkill.display +'</span><i '+ theText.melee.weaponSkill.effectiveColor +'>'+ theText.melee.weaponSkill.value +'</i></li>'; //expertise
replaceStringMelee += "</ul>";

var replaceStringRanged = '<ul>';
replaceStringRanged += '<li onMouseover="javascript: showTip(\&quot;'+ theText.ranged.damage.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.ranged.damage.display +'</span><i '+ theText.ranged.damage.effectiveColor +'>'+ theText.ranged.damage.value +'</i></li>';
replaceStringRanged += '<li onMouseover="javascript: showTip(\&quot;'+ theText.ranged.speed.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.ranged.speed.display +'</span><i '+ theText.ranged.speed.effectiveColor +'>'+ theText.ranged.speed.value + '</i></li>';
replaceStringRanged += '<li onMouseover="javascript: showTip(\&quot;'+ theText.ranged.power.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.ranged.power.display +'</span><i '+ theText.ranged.power.effectiveColor +'>'+ theText.ranged.power.value +'</i></li>';
replaceStringRanged += '<li onMouseover="javascript: showTip(\&quot;'+ theText.ranged.hitRating.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.ranged.hitRating.display +'</span><i '+ theText.ranged.hitRating.effectiveColor +'>'+ theText.ranged.hitRating.value +'</i></li>';
replaceStringRanged += '<li onMouseover="javascript: showTip(\&quot;'+ theText.ranged.critChance.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.ranged.critChance.display +'</span><i '+ theText.ranged.critChance.effectiveColor +'>'+ theText.ranged.critChance.value +'%</i></li>';
replaceStringRanged += "</ul>";

var replaceStringSpell = '<ul>';
replaceStringSpell += '<li onMouseover="javascript: showTip(\&quot;'+ theText.spell.bonusDamage.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.spell.bonusDamage.display +'</span><i '+ theText.spell.bonusDamage.effectiveColor +'>'+ theText.spell.bonusDamage.value +'</i></li>';
replaceStringSpell += '<li onMouseover="javascript: showTip(\&quot;'+ theText.spell.bonusHealing.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.spell.bonusHealing.display +'</span><i '+ theText.spell.bonusHealing.effectiveColor +'>'+ theText.spell.bonusHealing.value +'</i></li>';
replaceStringSpell += '<li onMouseover="javascript: showTip(\&quot;'+ theText.spell.hitRating.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.spell.hitRating.display +'</span><i '+ theText.spell.hitRating.effectiveColor +'>'+ theText.spell.hitRating.value +'</i></li>';
replaceStringSpell += '<li onMouseover="javascript: showTip(\&quot;'+ theText.spell.critChance.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.spell.critChance.display +'</span><i '+ theText.spell.critChance.effectiveColor +'>'+ theText.spell.critChance.value +'%</i></li>';
replaceStringSpell += '<li onMouseover="javascript: showTip(\&quot;'+ theText.spell.hasteRating.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.spell.hasteRating.display +'</span><i '+ theText.spell.hasteRating.effectiveColor +'>'+ theText.spell.hasteRating.value +'</i></li>';
replaceStringSpell += '<li onMouseover="javascript: showTip(\&quot;'+ theText.spell.manaRegen.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.spell.manaRegen.display +'</span><i '+ theText.spell.manaRegen.effectiveColor +'>'+ theText.spell.manaRegen.value +'</i></li>';
replaceStringSpell += "</ul>";

var replaceStringDefenses = '<ul>';
replaceStringDefenses += '<li onMouseover="javascript: showTip(\&quot;'+ theText.defenses.armor.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.defenses.armor.display +'</span><i '+ theText.defenses.armor.effectiveColor +'>'+ theText.defenses.armor.value +'</i></li>';
replaceStringDefenses += '<li onMouseover="javascript: showTip(\&quot;'+ theText.defenses.defense.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.defenses.defense.display +'</span><i '+ theText.defenses.defense.effectiveColor +'>'+ theText.defenses.defense.value +'</i></li>';
replaceStringDefenses += '<li onMouseover="javascript: showTip(\&quot;'+ theText.defenses.dodge.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.defenses.dodge.display +'</span><i '+ theText.defenses.dodge.effectiveColor +'>'+ theText.defenses.dodge.value +'%</i></li>';
replaceStringDefenses += '<li onMouseover="javascript: showTip(\&quot;'+ theText.defenses.parry.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.defenses.parry.display +'</span><i '+ theText.defenses.parry.effectiveColor +'>'+ theText.defenses.parry.value +'%</i></li>';
replaceStringDefenses += '<li onMouseover="javascript: showTip(\&quot;'+ theText.defenses.block.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.defenses.block.display +'</span><i '+ theText.defenses.block.effectiveColor +'>'+ theText.defenses.block.value +'%</i></li>';
replaceStringDefenses += '<li onMouseover="javascript: showTip(\&quot;'+ theText.defenses.resilience.mouseover +'\&quot;);" onMouseOut="javascript: hideTip();"><span>'+  theText.defenses.resilience.display +'</span><i '+ theText.defenses.resilience.effectiveColor +'>'+ theText.defenses.resilience.value +'</i></li>';
replaceStringDefenses += "</ul>";

document.getElementById('replaceStatsLeft').innerHTML = replaceStringBaseStats;

if (theClassId == 1 || theClassId == 4 || theClassId == 2 || theClassId == 6)
	changeStats('Right', replaceStringMelee, 'Melee', meleeDisplay);
else if (theClassId == 3)
	changeStats('Right', replaceStringRanged, 'Ranged', rangedDisplay);
else
	changeStats('Right', replaceStringSpell, 'Spell', spellDisplay);
	
	if (theCharacter.resistances.arcane.diff)
		document.getElementById('spanResistArcane').className = "mod";
	if (theCharacter.resistances.fire.diff)
		document.getElementById('spanResistFire').className = "mod";
	if (theCharacter.resistances.nature.diff)
		document.getElementById('spanResistNature').className = "mod";
	if (theCharacter.resistances.frost.diff)
		document.getElementById('spanResistFrost').className = "mod";
	if (theCharacter.resistances.shadow.diff)
		document.getElementById('spanResistShadow').className = "mod";	


jsLoaded=true;