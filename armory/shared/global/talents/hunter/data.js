var i = 0;

var t = 0;

var className = "Hunter Talents";
var talentPath = "info/basics/talents/";

tree[i] = "Beast Mastery"; i++;
tree[i] = "Marksmanship"; i++;
tree[i] = "Survival"; i++;

i = 0;

talent[i] = [0, "Improved Aspect of the Hawk", 5, 2, 1]; i++;
talent[i] = [0, "Endurance Training", 5, 3, 1]; i++;
talent[i] = [0, "Focused Fire", 2, 1, 2]; i++;
talent[i] = [0, "Improved Aspect of the Monkey", 3, 2, 2]; i++; 
talent[i] = [0, "Thick Hide", 3, 3, 2]; i++;
talent[i] = [0, "Improved Revive Pet", 2, 4, 2]; i++;
talent[i] = [0, "Pathfinding", 2, 1, 3]; i++;
talent[i] = [0, "Bestial Swiftness", 1, 2, 3]; i++;
talent[i] = [0, "Unleashed Fury", 5, 3, 3]; i++;
talent[i] = [0, "Improved Mend Pet", 2, 2, 4]; i++;
talent[i] = [0, "Ferocity", 5, 3, 4]; i++;
talent[i] = [0, "Spirit Bond", 2, 1, 5]; i++;
talent[i] = [0, "Intimidation", 1, 2, 5]; i++;
talent[i] = [0, "Bestial Discipline", 2, 4, 5]; i++;
talent[i] = [0, "Animal Handler", 2, 1, 6]; i++;
talent[i] = [0, "Frenzy", 5, 3, 6, [getTalentID("Ferocity"),5]]; i++;
talent[i] = [0, "Ferocious Inspiration", 3, 1, 7]; i++;
talent[i] = [0, "Bestial Wrath", 1, 2, 7, [getTalentID("Intimidation"),1]]; i++;
talent[i] = [0, "Catlike Reflexes", 3, 3, 7]; i++;
talent[i] = [0, "Serpent's Swiftness", 5, 3, 8]; i++;
talent[i] = [0, "The Beast Within", 1, 2, 9, [getTalentID("Bestial Wrath"),1]]; i++;

treeStartStop[t] = i -1;
t++;

//marksmanship talents
talent[i] = [1, "Improved Concussive Shot", 5, 2, 1]; i++;
talent[i] = [1, "Lethal Shots", 5, 3, 1]; i++;
talent[i] = [1, "Improved Hunter's Mark", 5, 2, 2]; i++;
talent[i] = [1, "Efficiency", 5, 3, 2]; i++;
talent[i] = [1, "Go for the Throat", 2, 1, 3]; i++;
talent[i] = [1, "Improved Arcane Shot", 5, 2, 3]; i++;
talent[i] = [1, "Aimed Shot", 1, 3, 3]; i++;
talent[i] = [1, "Rapid Killing", 2, 4, 3]; i++;
talent[i] = [1, "Improved Stings", 5, 2, 4]; i++;
talent[i] = [1, "Mortal Shots", 5, 3, 4, [getTalentID("Aimed Shot"),1]]; i++;
talent[i] = [1, "Concussive Barrage", 3, 1, 5]; i++;
talent[i] = [1, "Scatter Shot", 1, 2, 5]; i++;
talent[i] = [1, "Barrage", 3, 3, 5]; i++;
talent[i] = [1, "Combat Experience", 2, 1, 6]; i++;
talent[i] = [1, "Ranged Weapon Specialization", 5, 4, 6]; i++;
talent[i] = [1, "Careful Aim", 3, 1, 7]; i++;
talent[i] = [1, "Trueshot Aura", 1, 2, 7, [getTalentID("Scatter Shot"),1]]; i++;
talent[i] = [1, "Improved Barrage", 3, 3, 7, [getTalentID("Barrage"),3]]; i++;
talent[i] = [1, "Master Marksman", 5, 2, 8]; i++;
talent[i] = [1, "Silencing Shot", 1, 2, 9, [getTalentID("Master Marksman"),5]]; i++;

treeStartStop[t] = i -1;
t++;

//survival talents
talent[i] = [2, "Monster Slaying", 3, 1, 1]; i++;
talent[i] = [2, "Humanoid Slaying", 3, 2, 1]; i++;
talent[i] = [2, "Hawk Eye", 3, 3, 1]; i++;
talent[i] = [2, "Savage Strikes", 2, 4, 1]; i++;
talent[i] = [2, "Entrapment", 3, 1, 2]; i++;
talent[i] = [2, "Deflection", 5, 2, 2]; i++;
talent[i] = [2, "Improved Wing Clip", 3, 3, 2]; i++;
talent[i] = [2, "Clever Traps", 2, 1, 3]; i++;
talent[i] = [2, "Survivalist", 5, 2, 3]; i++;
talent[i] = [2, "Deterrence", 1, 3, 3]; i++;
talent[i] = [2, "Trap Mastery", 2, 1, 4]; i++;
talent[i] = [2, "Surefooted", 3, 2, 4]; i++;
talent[i] = [2, "Improved Feign Death", 2, 4, 4]; i++;
talent[i] = [2, "Survival Instincts", 2, 1, 5]; i++;
talent[i] = [2, "Killer Instinct", 3, 2, 5]; i++;
talent[i] = [2, "Counterattack", 1, 3, 5, [getTalentID("Deterrence"),1]]; i++;
talent[i] = [2, "Resourcefulness", 3, 1, 6]; i++;
talent[i] = [2, "Lightning Reflexes", 5, 3, 6]; i++;
talent[i] = [2, "Thrill of the Hunt", 3, 1, 7]; i++;
talent[i] = [2, "Wyvern Sting", 1, 2, 7, [getTalentID("Killer Instinct"),3]]; i++;
talent[i] = [2, "Expose Weakness", 3, 3, 7, [getTalentID("Lightning Reflexes"),5]]; i++;
talent[i] = [2, "Master Tactician", 5, 2, 8]; i++;
talent[i] = [2, "Readiness", 1, 2, 9, [getTalentID("Master Tactician"),5]]; i++;

treeStartStop[t] = i -1;
t++;

i = 0;

//Beast Mastery Talents Begin

//Improved Aspect of the Hawk - Beast Mastery
rank[i] = [
"While Aspect of the Hawk is active, all normal ranged attacks have a 10% chance of increasing ranged attack speed by 3% for 12 sec.",
"While Aspect of the Hawk is active, all normal ranged attacks have a 10% chance of increasing ranged attack speed by 6% for 12 sec.",
"While Aspect of the Hawk is active, all normal ranged attacks have a 10% chance of increasing ranged attack speed by 9% for 12 sec.",
"While Aspect of the Hawk is active, all normal ranged attacks have a 10% chance of increasing ranged attack speed by 12% for 12 sec.",
"While Aspect of the Hawk is active, all normal ranged attacks have a 10% chance of increasing ranged attack speed by 15% for 12 sec."
		];
i++;		
		
//Endurance Training - Beast Mastery
rank[i] = [
"Increases the Health of your pets by 2% and your total health by 1%.",
"Increases the Health of your pets by 4% and your total health by 2%.",
"Increases the Health of your pets by 6% and your total health by 3%.",
"Increases the Health of your pets by 8% and your total health by 4%.",
"Increases the Health of your pets by 10% and your total health by 5%."
		];
i++;		

//Focused Fire - Beast Mastery
rank[i] = [
"All damage caused by you is increased by 1% while your pet is active and the critical strike chance of your Kill Command Ability is increased by 10%.",
"All damage caused by you is increased by 2% while your pet is active and the critical strike chance of your Kill Command Ability is increased by 20%."
		];
i++;		
		
//Improved Aspect of the Monkey - Beast Mastery
rank[i] = [
"Increases the Dodge bonus of your Aspect of the Monkey by 2%.",
"Increases the Dodge bonus of your Aspect of the Monkey by 4%.",
"Increases the Dodge bonus of your Aspect of the Monkey by 6%."
		];
i++;		

//Thick Hide - Beast Mastery
rank[i] = [
"Increases the armor rating of your pets by 7% and your armor contributions from items by 4%.",
"Increases the armor rating of your pets by 14% and your armor contributions from items by 7%.",
"Increases the armor rating of your pets by 20% and your armor contributions from items by 10%.",

		];
i++;		

//Improved Revive Pet - Beast Mastery
rank[i] = [
"Revive Pet's casting time is reduced by 3 sec, mana cost is reduced by 20%, and increases the health your pet returns with by an additional 15%.",
"Revive Pet's casting time is reduced by 6 sec, mana cost is reduced by 40%, and increases the health your pet returns with by an additional 30%."
		];
i++;		


//Pathfinding - Beast Mastery
rank[i] = [
"Increases the speed bonus of your Aspect of the Cheetah and Aspect of the Pack by 4%.",
"Increases the speed bonus of your Aspect of the Cheetah and Aspect of the Pack by 8%."
		];
i++;	

		
//Bestial Swiftness - Beast Mastery
rank[i] = [
"Increases the outdoor movement speed of your pets by 30%."
		];		
i++;		


//Unleashed Fury - Beast Mastery
rank[i] = [ 
"Increases the damage done by your pets by 4%.",
"Increases the damage done by your pets by 8%.",
"Increases the damage done by your pets by 12%.",
"Increases the damage done by your pets by 16%.",
"Increases the damage done by your pets by 20%."
		];
i++;		
	

//Improved Mend Pet - Beast Mastery
rank[i] = [ 
"Reduces the mana cost of your Mend Pet spell by 10% and gives the Mend Pet spell a 25% chance of cleansing 1 Curse, Disease, Magic or Poison effect from the pet each tick.",
"Reduces the mana cost of your Mend Pet spell by 20% and gives the Mend Pet spell a 50% chance of cleansing 1 Curse, Disease, Magic or Poison effect from the pet each tick."
		];
i++;	

//Ferocity - Beast Mastery
rank[i] = [
"Increases the critical strike chance of your pets by 2%.",
"Increases the critical strike chance of your pets by 4%.",
"Increases the critical strike chance of your pets by 6%.",
"Increases the critical strike chance of your pets by 8%.",
"Increases the critical strike chance of your pets by 10%."

		];
i++;		

//Spirit Bond - Beast Mastery 
rank[i] = [
"While your pet is active, you and your pet will regenerate 1% of total health every 10 sec.",
"While your pet is active, you and your pet will regenerate 2% of total health every 10 sec."
		];
i++;

//Intimidation - Beast Mastery
rank[i] = [
		"<span style=text-align:left;float:left;>202 Mana</span><span style=text-align:right;float:right;>100 yd range</span><br><span style=text-align:left;float:left;>Instant cast</span><span style=text-align:right;float:right;>1 min cooldown</span><br>Command your pet to intimidate the target on the next successful melee attack, causing a high amount of threat and stunning the target for 3 sec."
		];
i++;		

//Bestial Discipline - Beast Mastery
rank[i] = [
"Increases the Focus regeneration of your pets by 50%.",
"Increases the Focus regeneration of your pets by 100%."
		];
i++;		

//Animal Handler - Beast Mastery
rank[i] = [
"Increases your speed while mounted by 4% and your pet's chance to hit by 2%. The mounted movement speed increase does not stack with other effects.",
"Increases your speed while mounted by 8% and your pet's chance to hit by 4%. The mounted movement speed increase does not stack with other effects."
		];
i++;		

//Frenzy - Beast Mastery
rank[i] = [
"Gives your pet a 20% chance to gain a 30% attack speed increase for 8 sec after dealing a critical strike.",
"Gives your pet a 40% chance to gain a 30% attack speed increase for 8 sec after dealing a critical strike.",
"Gives your pet a 60% chance to gain a 30% attack speed increase for 8 sec after dealing a critical strike.",
"Gives your pet a 80% chance to gain a 30% attack speed increase for 8 sec after dealing a critical strike.",
"Gives your pet a 100% chance to gain a 30% attack speed increase for 8 sec after dealing a critical strike."

		];		
i++;		

//Ferocious Inspiration - Beast Mastery
rank[i] = [
"When your pet scores a critical hit, all party members have all damage increased by 1% for 10 sec.",
"When your pet scores a critical hit, all party members have all damage increased by 2% for 10 sec.",
"When your pet scores a critical hit, all party members have all damage increased by 3% for 10 sec."

		];		
i++;		

//Bestial Wrath - Beast Mastery			
rank[i] = [
		"<span style=text-align:left;float:left;>338 Mana</span><span style=text-align:right;float:right;>100 yd range</span><br><span style=text-align:left;float:left;>Instant cast</span><span style=text-align:right;float:right;>2 min cooldown</span><br>Send your pet into a rage causing 50% additional damage for 18 sec. While enraged, the beast cannot be stopped unless killed."
		];
i++;		

//Catlike Reflexes - Beast Mastery
rank[i] = [
"Increases your chance to dodge by 1% and your pet's chance to dodge by an additional 3%.",
"Increases your chance to dodge by 2% and your pet's chance to dodge by an additional 6%.",
"Increases your chance to dodge by 3% and your pet's chance to dodge by an additional 9%."
		];		
i++;

//Serpent's Swiftness - Beast Mastery
rank[i] = [
"Increases ranged combat attack speed by 4% and your pet's melee attack speed by 4%.",
"Increases ranged combat attack speed by 8% and your pet's melee attack speed by 8%.",
"Increases ranged combat attack speed by 12% and your pet's melee attack speed by 12%.",
"Increases ranged combat attack speed by 16% and your pet's melee attack speed by 16%.",
"Increases ranged combat attack speed by 20% and your pet's melee attack speed by 20%."
		];		
i++;

//The Beast Within - Beast Mastery
rank[i] = [
"When your pet is under the effects of Bestial Wrath, you also go into a rage causing 10% additional damage and reducing mana costs of all spells by 20% for 18 sec. While enraged, you do not feel pity or remorse or fear and you cannot be stopped unless killed."
		];		
i++;

//Improved Concussive Shot - Marksmanship
rank[i] = [
"Gives your Concussive Shot a 4% chance to stun the target for 3 sec.",
"Gives your Concussive Shot a 8% chance to stun the target for 3 sec.",
"Gives your Concussive Shot a 12% chance to stun the target for 3 sec.",
"Gives your Concussive Shot a 16% chance to stun the target for 3 sec.",
"Gives your Concussive Shot a 20% chance to stun the target for 3 sec."
		];
i++;		

//Lethal Shots - Marksmanship 
rank[i] = [
"Increases your critical strike chance with ranged weapons by 1%.",
"Increases your critical strike chance with ranged weapons by 2%.",
"Increases your critical strike chance with ranged weapons by 3%.",
"Increases your critical strike chance with ranged weapons by 4%.",
"Increases your critical strike chance with ranged weapons by 5%."
		];		
i++;		

//Improved Hunter's Mark - Marksmanship
rank[i] = [
"Causes 20% of your Hunter's Mark ability's base attack power to apply to melee attack power as well.",
"Causes 40% of your Hunter's Mark ability's base attack power to apply to melee attack power as well.",
"Causes 60% of your Hunter's Mark ability's base attack power to apply to melee attack power as well.",
"Causes 80% of your Hunter's Mark ability's base attack power to apply to melee attack power as well.",
"Causes 100% of your Hunter's Mark ability's base attack power to apply to melee attack power as well."
		];
i++;		

//Efficiency - Marksmanship
rank[i] = [
"Reduces the Mana cost of your Shots and Stings by 2%.",
"Reduces the Mana cost of your Shots and Stings by 4%.",
"Reduces the Mana cost of your Shots and Stings by 6%.",
"Reduces the Mana cost of your Shots and Stings by 8%.",
"Reduces the Mana cost of your Shots and Stings by 10%."
		];
i++;

//Go for the Throat - Marksmanship
rank[i] = [
"Your ranged critical hits cause your pet to generate 25 Focus.",
"Your ranged critical hits cause your pet to generate 50 Focus."
		];
i++;

//Improved Arcane Shot - Marksmanship
rank[i] = [
		"Reduces the cooldown of your Arcane Shot by 0.2 sec.",
		"Reduces the cooldown of your Arcane Shot by 0.4 sec.",
		"Reduces the cooldown of your Arcane Shot by 0.6 sec.",
		"Reduces the cooldown of your Arcane Shot by 0.8 sec.",
		"Reduces the cooldown of your Arcane Shot by 1 sec."
		];
i++;		

//Aimed Shot - Marksmanship 
rank[i] = [
		"<span style=text-align:left;float:left;>75 Mana</span><span style=text-align:right;float:right;>5-35 yd range</span><br><span style=text-align:left;float:left;>3 sec cast</span><BR><span style=text-align:left;float:left;>6 sec cooldown</span><br><br>Requires Ranged Weapon<br>An aimed shot that increases ranged damage by 870 and reduces healing done to that target by 50%. Lasts 10 sec.<br><br>\
		&nbsp;Trainable Ranks Listed Below:<br>\
		&nbsp;Rank 2: 115 Mana, 125 Damage<br>\
		&nbsp;Rank 3: 160 Mana, 200 Damage<br>\
		&nbsp;Rank 4: 210 Mana, 330 Damage<br>\
		&nbsp;Rank 5: 260 Mana, 460 Damage<br>\
		&nbsp;Rank 6: 310 Mana, 600 Damage<br>\
		&nbsp;Rank 7: 370 Mana, 870 Damage"
		];
i++;		

//Rapid Killing - Marksmanship
rank[i] = [
		"Reduces the cooldown of your Rapid Fire ability by 1 min.  In addition, after killing an opponent that yields experience or honor, your next Aimed Shot, Arcane Shot or Auto Shot causes 10% additional damage.  Lasts 20 sec.",
		"Reduces the cooldown of your Rapid Fire ability by 2 min.  In addition, after killing an opponent that yields experience or honor, your next Aimed Shot, Arcane Shot or Auto Shot causes 20% additional damage.  Lasts 20 sec." 
		];
i++;		

//Improved Stings - Marksmanship
rank[i] = [
"Increases the damage done by your Serpent Sting and Wyvern Sting by 6%, increases the mana drained by your Viper Sting by 6%, and reduces the chance Stings will be dispelled by 6%.",
"Increases the damage done by your Serpent Sting and Wyvern Sting by 12%, increases the mana drained by your Viper Sting by 12%, and reduces the chance Stings will be dispelled by 12%.",
"Increases the damage done by your Serpent Sting and Wyvern Sting by 18%, increases the mana drained by your Viper Sting by 18%, and reduces the chance Stings will be dispelled by 18%.",
"Increases the damage done by your Serpent Sting and Wyvern Sting by 24%, increases the mana drained by your Viper Sting by 24%, and reduces the chance Stings will be dispelled by 24%.",
"Increases the damage done by your Serpent Sting and Wyvern Sting by 30%, increases the mana drained by your Viper Sting by 30%, and reduces the chance Stings will be dispelled by 30%."
		];
i++;		

//Mortal Shots - Marksmanship
rank[i] = [
"Increases your ranged weapon critical strike damage bonus by 6%.",
"Increases your ranged weapon critical strike damage bonus by 12%.",
"Increases your ranged weapon critical strike damage bonus by 18%.",
"Increases your ranged weapon critical strike damage bonus by 24%.",
"Increases your ranged weapon critical strike damage bonus by 30%."
		];i++;		

//Concussive Barrage - Marksmanship

rank[i] = [
		"Your successful Auto Shot attacks have a 2% chance to Daze the target for 4 sec.",
		"Your successful Auto Shot attacks have a 4% chance to Daze the target for 4 sec.",
		"Your successful Auto Shot attacks have a 6% chance to Daze the target for 4 sec."		
			];
i++;		
		
//Scatter Shot - Marksmanship 
rank[i] = [
		"<span style=text-align:left;float:left;>202 Mana</span><span style=text-align:right;float:right;>15 yd range</span><br><span style=text-align:left;float:left;>Instant</span><span style=text-align:right;float:right;>30 sec cooldown</span><br>Requires Ranged Weapon<br>A short-range shot that deals 50% weapon damage and disorients the target for 4 sec. Any damage caused will remove the effect. Turns off your attack when used."
		];
i++;		

//Barrage - Marksmanship
rank[i] = [
"Increases the damage done by your Multi-Shot and Volley spells by 4%.",
"Increases the damage done by your Multi-Shot and Volley spells by 8%.",
"Increases the damage done by your Multi-Shot and Volley spells by 12%."
		];
i++;


//Combat Experience - Marksmanship
rank[i] = [
		"Increases your total Agility by 1% and your total Intellect by 3%.",
		"Increases your total Agility by 2% and your total Intellect by 6%."
			];
i++;	
		
//Ranged Weapon Specialization - Marksmanship 
rank[i]=[
"Increases the damage you deal with ranged weapons by 1%.",
"Increases the damage you deal with ranged weapons by 2%.",
"Increases the damage you deal with ranged weapons by 3%.",
"Increases the damage you deal with ranged weapons by 4%.",
"Increases the damage you deal with ranged weapons by 5%."
		];
i++;			

//Careful Aim - Marksmanship 
rank[i]=[
"Increases your ranged attack power by an amount equal to 15% of your total Intellect.",
"Increases your ranged attack power by an amount equal to 30% of your total Intellect.",
"Increases your ranged attack power by an amount equal to 45% of your total Intellect."
		];
i++;		

//Trueshot Aura - Marksmanship 
rank[i]=[
		"Instant cast<br>Increases the attack power of party members within 45 yards by 50. Lasts until cancelled.<br><br>\
		&nbsp;Trainable Ranks Listed Below:<br>\
		&nbsp;Rank 2: 425 Mana, 75 Attack Power<br>\
		&nbsp;Rank 3: 525 Mana, 100 Attack Power<br>\
		&nbsp;Rank 4: 620 Mana, 125 Attack Power"
		];
i++;		

//Improved Barrage - Marksmanship 
rank[i]=[
"Increases the critical strike chance of your Multi-Shot ability by 4% and gives you a 33% chance to avoid interruption caused by damage while channeling Volley.",
"Increases the critical strike chance of your Multi-Shot ability by 8% and gives you a 66% chance to avoid interruption caused by damage while channeling Volley.",
"Increases the critical strike chance of your Multi-Shot ability by 12% and gives you a 100% chance to avoid interruption caused by damage while channeling Volley."
		];
i++;		

//Master Marksman - Marksmanship 
rank[i]=[
"Increases your ranged attack power by 2%.",
"Increases your ranged attack power by 4%.",
"Increases your ranged attack power by 6%.",
"Increases your ranged attack power by 8%.",
"Increases your ranged attack power by 10%."
		];
i++;		

//Silencing Shot - Marksmanship 
rank[i]=[
		"<span style=text-align:left;float:left;>\
202 Mana</span><span style=text-align:right;float:right;>\
5-35 yd range</span><br><span style=text-align:left;float:left;>\
Instant Cast</span><span style=text-align:right;float:right;>\
20 sec cooldown</span><br>\
		A shot that deals 50% weapon damage and Silences the target for 3 sec."
		];
i++;		

//Monster Slaying - Survival
rank[i]=[
"Increases all damage caused against Beast, Giants and Dragonkin targets by 1% and increases critical damage caused against Beasts, Giants, and Dragonkin targets by an additional 1%.",
"Increases all damage caused against Beast, Giants and Dragonkin targets by 2% and increases critical damage caused against Beasts, Giants, and Dragonkin targets by an additional 2%.",
"Increases all damage caused against Beast, Giants and Dragonkin targets by 3% and increases critical damage caused against Beasts, Giants, and Dragonkin targets by an additional 3%."
		];
i++;		
		
//Humanoid Slaying - Survival
rank[i]=[
"Increases all damage caused against Humanoid targets by 1% and increases critical damage caused against Humanoid targets by an additional 1%.",
"Increases all damage caused against Humanoid targets by 2% and increases critical damage caused against Humanoid targets by an additional 2%.",
"Increases all damage caused against Humanoid targets by 3% and increases critical damage caused against Humanoid targets by an additional 3%."
		];
i++;

//Hawk Eye - Survival
rank[i]=[
"Increases the range of your ranged weapons by 2 yards.",
"Increases the range of your ranged weapons by 4 yards.",
"Increases the range of your ranged weapons by 6 yards."
		];
i++;

//Savage Strikes - Survival
rank[i]=[
"Increases the critical strike chance of Raptor Strike and Mongoose Bite by 10%.",
"Increases the critical strike chance of Raptor Strike and Mongoose Bite by 20%."
		];
i++;	

//Entrapment - Survival
rank[i]=[
"Gives your Immolation Trap, Frost Trap, Explosive Trap, and Snake Trap a 8% chance to entrap the target, preventing them from moving for 4 sec.",
"Gives your Immolation Trap, Frost Trap, Explosive Trap, and Snake Trap a 16% chance to entrap the target, preventing them from moving for 4 sec.",
"Gives your Immolation Trap, Frost Trap, Explosive Trap, and Snake Trap a 25% chance to entrap the target, preventing them from moving for 4 sec."
		];
i++;	

//Deflection - Survival
rank[i]=[
"Increases your Parry chance by 1%.",
"Increases your Parry chance by 2%.",
"Increases your Parry chance by 3%.",
"Increases your Parry chance by 4%.",
"Increases your Parry chance by 5%."
		];
i++;		
				
//Improved Wing Clip - Survival
rank[i]=[
"Gives your Wing Clip ability a 7% chance to immobilize the target for 5 sec.",
"Gives your Wing Clip ability a 14% chance to immobilize the target for 5 sec.",
"Gives your Wing Clip ability a 20% chance to immobilize the target for 5 sec."
		];
i++;		
				
//Clever Traps - Survival
rank[i]=[
"Increases the duration of Freezing and Frost trap effects by 15%, the damage of Immolation and Explosive trap effects by 15%, and the number of snakes summoned from Snake Traps by 15%.",
"Increases the duration of Freezing and Frost trap effects by 30%, the damage of Immolation and Explosive trap effects by 30%, and the number of snakes summoned from Snake Traps by 30%."
		];
i++;		
		
//Survivalist - Survival
rank[i]=[
"Increases total health by 2%.",
"Increases total health by 4%.",
"Increases total health by 6%.",
"Increases total health by 8%.",
"Increases total health by 10%."
		];
i++;		
		
//Deterrence - Survival
rank[i]=[
		"<span style=text-align:left;float:left;>Instant</span><span style=text-align:right;float:right;>5 min cooldown</span><br>When activated, increases your Dodge and Parry chance by 25% for 10 sec."
		];
i++;		
		
//Trap Mastery - Survival 
rank[i]=[
"Decreases the chance enemies will resist trap effects by 5%.",
"Decreases the chance enemies will resist trap effects by 10%."
		];
i++;	
		
//Surefooted - Survival 
rank[i]=[
"Increases hit chance by 1% and increases the chance movement impairing effects will be resisted by an additional 5%.",
"Increases hit chance by 2% and increases the chance movement impairing effects will be resisted by an additional 10%.",
"Increases hit chance by 3% and increases the chance movement impairing effects will be resisted by an additional 15%."
		];
i++;	


//Improved Feign Death - Survival
rank[i]=[
"Reduces the chance your Feign Death ability will be resisted by 2%.",
"Reduces the chance your Feign Death ability will be resisted by 4%."
		];
i++;	

//Survival Instincts - Survival
rank[i]=[
"Reduces all damage taken by 2% and increases attack power by 2%.",
"Reduces all damage taken by 4% and increases attack power by 4%."
		];
i++;

//Killer Instinct - Survival
rank[i]=[
"Increases your critical strike chance with all attacks by 1%.",
"Increases your critical strike chance with all attacks by 2%.",
"Increases your critical strike chance with all attacks by 3%."
		];
i++;	


//Counterattack - Survival
rank[i]=[
		"<span style=text-align:left;float:left;>45 Mana</span><span style=text-align:right;float:right;>Melee range</span><br><span style=text-align:left;float:left;>Instant cast</span><span style=text-align:right;float:right;>5 sec cooldown</span><br>A strike that becomes active after parrying an opponent's attack. This attack deals 40 damage and immobilizes the target for 5 sec. Counterattack cannot be blocked, dodged, or parried.<br><br>\
		&nbsp;Trainable Ranks Listed Below<br>\
		&nbsp;Rank 2: 65 Mana, 70 Damage<br>\
		&nbsp;Rank 3: 85 Mana, 110 Damage<br>\
		&nbsp;Rank 4: 110 Mana, 165 Damage"
		];
i++;	

//Resourcefulness - Survival
rank[i]=[
"Reduces the mana cost of all traps and melee abilities by 20% and reduces the cooldown of all traps by 2 sec.",
"Reduces the mana cost of all traps and melee abilities by 40% and reduces the cooldown of all traps by 4 sec.",
"Reduces the mana cost of all traps and melee abilities by 60% and reduces the cooldown of all traps by 6 sec."
		];
i++;	

//Lightning Reflexes - Survival
rank[i]=[
"Increases your Agility by 3%.",
"Increases your Agility by 6%.",
"Increases your Agility by 9%.",
"Increases your Agility by 12%.",
"Increases your Agility by 15%."
		];
i++;	

//Thrill of the Hunt - Survival
rank[i]=[
"Gives you a 33% chance to regain 40% of the mana cost of any shot when it critically hits.",
"Gives you a 66% chance to regain 40% of the mana cost of any shot when it critically hits.",
"Gives you a 100% chance to regain 40% of the mana cost of any shot when it critically hits."
		];
i++;

//Wyvern Sting - Survival
rank[i]=[
		"<span style=text-align:left;float:left;>115 Mana</span><span style=text-align:right;float:right;>8-35 yd range</span><br><span style=text-align:left;float:left;>Instant cast</span><span style=text-align:right;float:right;>2 min cooldown</span><br>A stinging shot that puts the target to sleep for 12 sec. Any damage will cancel the effect. When the target wakes up, the Sting causes 300 Nature damage over 12 sec. Only one Sting per Hunter can be active on the target at a time.<br><br>\
		&nbsp;Trainable Ranks Listed Below:<br>\
		&nbsp;Rank 2: 155 Mana, 420 Damage<br>\
		&nbsp;Rank 3: 205 Mana, 600 Damage"
		];
i++;	
	
//Expose Weakness - Survival
rank[i]=[
"Your ranged criticals have a 33% chance to apply an Expose Weakness effect to the target. Expose Weakness increases the Attack Power of all attackers against that target by 25% of your Agility for 7 sec.",
"Your ranged criticals have a 66% chance to apply an Expose Weakness effect to the target. Expose Weakness increases the Attack Power of all attackers against that target by 25% of your Agility for 7 sec.",
"Your ranged criticals have a 100% chance to apply an Expose Weakness effect to the target. Expose Weakness increases the Attack Power of all attackers against that target by 25% of your Agility for 7 sec."
		];
i++;	
	
//Master Tactician - Survival
rank[i]=[
"Your successful ranged attacks have a 6% chance to increase your critical strike chance with all attacks by 2% for 8 sec.",
"Your successful ranged attacks have a 6% chance to increase your critical strike chance with all attacks by 4% for 8 sec.",
"Your successful ranged attacks have a 6% chance to increase your critical strike chance with all attacks by 6% for 8 sec.",
"Your successful ranged attacks have a 6% chance to increase your critical strike chance with all attacks by 8% for 8 sec.",
"Your successful ranged attacks have a 6% chance to increase your critical strike chance with all attacks by 10% for 8 sec."
		];
i++;	
	
//Readiness - Survival
rank[i]=[
		"<span style=text-align:left;float:left;>Instant</span><span style=text-align:right;float:right;>5 min cooldown</span><br>When activated, this ability immediately finishes the cooldown on your other Hunter abilities."
		];
i++;	
		
//Survival Talents End^^

