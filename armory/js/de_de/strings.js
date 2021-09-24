var textNone = "Kein Profil gewählt";
var textLearnMore = "Registrieren"
var textLearnMoreHover = "Hier klicken wenn du dir ein Account auf diesem Server machen willst.";
var textInformation = "Information";
var textInformationHover = "Profile information";
var textCannotRegister = "Registrieren fehlgeschlagen";
var textCannotRegisterHover = "Du kannst dich auf diesem Server nicht registrieren";

var textClickPin = "Hier klicken, um dieses Profil zu merken.";
var tClickPinBreak = "Hier klicken, um<br />dieses Profil zu merken";

var textSearchTheArmory = "Suche im Arsenal";

var textArmory = "Arsenal";
var textSelectCategory = "--Kategorie wählen--";
var textArenaTeams = "Arena-Teams";
var textCharacters = "Charaktere";
var textGuilds = "Gilden";
var textItems = "Gegenstände";

var textEnterGuildName = "Gildennamen eingeben";
var textEnterCharacterName = "Charakternamen eingeben";
var textEnterTeamName = "Teamnamen eingeben";

var textVs2 = "2v2";
var textVs3 = "3v3";
var textVs5 = "5v5";

var textCurrentlyEquipped = "<span class = 'myGray'>Zurzeit angelegt</span>";

var textPoor = "Schlecht";
var textFair = "Mäßig";
var textGood = "Gut";
var textVeryGood = "Sehr gut";
var textExcellent = "Ausgezeichnet";

var tStwoChar = "Ein Suchbegriff muss mindestens zwei Zeichen lang sein.";
var tScat = "Bitte Kategorie auswählen.";

	var textHideItemFilters = "Filter verbergen";
	var textShowItemFilters = "Filter anzeigen";
	
	var textHideAdvancedOptions = "Erweiterte Optionen aus";
	var textShowAdvancedOptions = "Erweiterte Optionen ein";
	
	var textErrorLevel = "Min. Stufe ist größer als max. Stufe";
	var textErrorSkill = "Min. Fertigkeitswert ist größer als max. Fertigkeitswert";

var tPage = "Seite";
var textOf = "von";

var tRelevance = "Relevanz";
var tRelevanceKr = "";

var tGuildLeader = "Gildenoberhaupt";
var tGuildRank = "Rang";

var textrace = "";
var textclass = "";

var text1race = "Mensch";
var text2race = "Orc";
var text3race = "Zwerg";
var text4race = "Nachtelf";
var text5race = "Untoter";
var text6race = "Tauren";
var text7race = "Gnom";
var text8race = "Troll";
var text10race = "Blutelf";
var text11race = "Draenei";

var text1class = "Krieger";
var text2class = "Paladin";
var text3class = "Jäger";
var text4class = "Schurke";
var text5class = "Priester";
var text6class = "Todesritter";
var text7class = "Schamane";
var text8class = "Magier";
var text9class = "Hexenmeister";
var text11class = "Druide";

function printWeeks(numWeeks) {
	if (numWeeks == 1)
		return "1 Woche";
	else
		return numWeeks + " Wochen";
}

var tCharName = "Charaktername";
var tGRank = "Gildenrang";
var toBag = "Herkunft";
var tTType = "Aktion";
var tdBag = "Ziel";
var tItem = "Gegenstand"
var tDate = "Zeit & Datum";

var tItemName = "Gegenstand";
var tItemBag = "Fach";
var tItemSlot = "Platz";
var tItemType = "Kategorie";
var tItemSubtype = "Unterkategorie";

var tenchT = "Verzauberung";
var tenchP = "Verzauberung";

var tLoading = "Lädt";

function returnDateOrder(theMonth, theDay, theYear, theTime) {
	return theMonth + theDay + theYear + theTime; //organize the variables according to your region's custom
}

function returnDay(theDay) {
	
	switch (theDay) {
	case 0: return 'So&nbsp;';
	case 1: return 'Mo&nbsp;';
	case 2: return 'Di&nbsp;&nbsp;';
	case 3: return 'Mi&nbsp;';
	case 4: return 'Do';
	case 5: return 'Fr&nbsp;&nbsp;&nbsp;&nbsp;';
	case 6: return 'Sa&nbsp;';
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
