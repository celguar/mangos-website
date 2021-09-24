var textNone = "None";
var textLearnMore = "Registration"
var textLearnMoreHover = "If you want to register in the server, click here.";
var textInformation = "Information";
var textInformationHover = "Profile information";
var textCannotRegister = "Can't register";
var textCannotRegisterHover = "You cannot register in this server";

var textClickPin = "Click here to pin this profile.";
var tClickPinBreak = "Click here to<br />Pin this Profile";

var textSearchTheArmory = "Search the Armory";

var textArmory = "Armory";
var textSelectCategory = "--Select a Category--";
var textArenaTeams = "Arena Teams";
var textCharacters = "Characters";
var textGuilds = "Guilds";
var textItems = "Items";

var textEnterGuildName = "Enter Guild Name";
var textEnterCharacterName = "Enter Character Name";
var textEnterTeamName = "Enter Team Name";

var textVs2 = "2v2";
var textVs3 = "3v3";
var textVs5 = "5v5";

var textCurrentlyEquipped = "<span class = 'myGray'>Currently Equipped</span>";

var textPoor = "Poor";
var textFair = "Fair";
var textGood = "Good";
var textVeryGood = "Very Good";
var textExcellent = "Excellent";

var tStwoChar = "Search must be at least 2 characters long.";
var tScat = "Please select a category.";

	var textHideItemFilters = "Hide Item Filters";
	var textShowItemFilters = "Show Item Filters";
	
	var textHideAdvancedOptions = "Hide Advanced Options";
	var textShowAdvancedOptions = "Show Advanced Options";
	
	var textErrorLevel = "Min Level is greater than Max Level";
	var textErrorSkill = "Min Skill is greater than Max Skill";

var tPage = "Page";
var textOf = "of";

var tRelevance = "Relevance";
var tRelevanceKr = "";

var tGuildLeader = "Guild Leader";
var tGuildRank = "Rank";

var textrace = "";
var textclass = "";

var text1race = "Human";
var text2race = "Orc";
var text3race = "Dwarf";
var text4race = "Night Elf";
var text5race = "Undead";
var text6race = "Tauren";
var text7race = "Gnome";
var text8race = "Troll";
var text10race = "Blood Elf";
var text11race = "Draenei";

var text1class = "Warrior";
var text2class = "Paladin";
var text3class = "Hunter";
var text4class = "Rogue";
var text5class = "Priest";
var text6class = "Death Knight";
var text7class = "Shaman";
var text8class = "Mage";
var text9class = "Warlock";
var text11class = "Druid";

function printWeeks(numWeeks) {
	if (numWeeks == 1)
		return "1 week";
	else
		return numWeeks + " weeks";
}

var tCharName = "Character Name";
var tGRank = "Guild Rank";
var toBag = "Origin";
var tTType = "Action";
var tdBag = "Dest.";
var tItem = "Item"
var tDate = "Date & Time";

var tItemName = "Item";
var tItemBag = "Tab";
var tItemSlot = "Slot";
var tItemType = "Type";
var tItemSubtype = "Subtype";

var tenchT = "Enchantment";
var tenchP = "Enchantment";

var tLoading = "Loading";

function returnDateOrder(theMonth, theDay, theYear, theTime) {
	return theMonth + theDay + theYear + theTime; //organize the variables according to your region's custom
}

function returnDay(theDay) {
	
	switch (theDay) {
	case 0: return 'Sun&nbsp;';
	case 1: return 'Mon&nbsp;';
	case 2: return 'Tue&nbsp;&nbsp;';
	case 3: return 'Wed&nbsp;';
	case 4: return 'Thur';
	case 5: return 'Fri&nbsp;&nbsp;&nbsp;&nbsp;';
	case 6: return 'Sat&nbsp;';
	default: return '';
	}	
	
}

function formatDate(theDate) {

	var amPM;
	if (theDate.getHours() >= 12)
		amPM = "PM"
	else
		amPM = "AM"
		
	var theHour = theDate.getHours()%12;
	if (!theHour)
		theHour = 12;
		
	var theMinutes = theDate.getMinutes();
	if (!theMinutes)
		theMinutes = "00"
	if ((parseInt(theMinutes) <= 9) && (theMinutes != "00"))	
		theMinutes = "0" + theMinutes;
		
	var theSeconds = theDate.getSeconds();
	if (!theSeconds)
		theSeconds = "00"		
	if ((parseInt(theSeconds) <= 9) && (theSeconds != "00"))	
		theSeconds = "0" + theSeconds;		

	var theYear = theDate.getFullYear();

	var d = returnDay(theDate.getDay()) + " " + (theDate.getMonth() + 1) +"/"+ theDate.getDate() +"/"+ theYear +" "+ theHour +":"+ theMinutes +":"+ theSeconds +" "+ amPM;
	return d;
}

var gTruncItemNameContents = 70;
var gTruncItemName = 35;
var gTruncGuildRank = 18;

function printBag(bagId) {
	return tItemBag + " " + bagId;
}

jsLoaded=true;
