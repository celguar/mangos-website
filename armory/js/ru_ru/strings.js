﻿var textNone = "Нет профиля";
var textLearnMore = "Registration"
var textLearnMoreHover = "If you want to register in the server, click here.";
var textInformation = "Information";
var textInformationHover = "Profile information";
var textCannotRegister = "Can't register";
var textCannotRegisterHover = "You cannot register in this server";

var textClickPin = "Щелкните здась, чтобы закрепить окно профиля.";
var tClickPinBreak = "Щелкните здесь, чтобы<br />закрепить окно профиля";
var textViewProfile = "Просмотреть профиль";

var textSearchTheArmory = "Поиск по Оружейной";

var textArmory = "Оружейная";
var textSelectCategory = "--Выберите категорию--";
var textArenaTeams = "Команды Арены";
var textCharacters = "Персонажи";
var textGuilds = "Гильдии";
var textItems = "Предметы";

var textEnterGuildName = "Введите название гильдии";
var textEnterCharacterName = "Введите имя персонажа";
var textEnterTeamName = "Введите название команды";

var textVs2 = "2v2";
var textVs3 = "3v3";
var textVs5 = "5v5";

var textCurrentlyEquipped = "<span class = 'myGray'>Текущая экипировка</span>";

var beforeDiminishingReturns = "<span class = 'myGray'>(Перед уменьшением возвращается)</span>";

var textPoor = "Плохая";
var textFair = "Удовлетворительная";
var textGood = "Хорошая";
var textVeryGood = "Отличная";
var textExcellent = "Превосходная";

var tStwoChar = "Ключевое слово должно быть не короче двух символов.";
var tScat = "Выберите категорию.";
var tSearchAll = "Искать везде ";

	var textHideItemFilters = "Скрыть фильтры";
	var textShowItemFilters = "Показать фильтры";
	
	var textHideAdvancedOptions = "Скрыть доп. опции";
	var textShowAdvancedOptions = "Показать доп. опции";
	
	var textErrorLevel = "Мин. уровень больше макс. урвоня";
	var textErrorSkill = "Мин. навык профессии больше макс. навыка профессии";

var tPage = "Страница";
var textOf = "из";

var tRelevance = "Соответствие";
var tRelevanceKr = "";

var tGuildLeader = "Глава гильдии";
var tGuildRank = "Ранг";

var textrace = "";
var textclass = "";

var text1race = "Человек";
var text2race = "Орк";
var text3race = "Дворф";
var text4race = "Ночной эльф";
var text5race = "Нежить";
var text6race = "Таурен";
var text7race = "Гном";
var text8race = "Тролль";
var text10race = "Эльф крови";
var text11race = "Дреней";

var text1class = "Воин";
var text2class = "Паладин";
var text3class = "Охотник";
var text4class = "Разбойник";
var text5class = "Жрец";
var text6class = "Рыцарь смерти";
var text7class = "Шаман";
var text8class = "Маг";
var text9class = "Чернокнижник";
var text11class = "Друид";

function printWeeks(numWeeks) {
	if (numWeeks == 1)
		return "1 неделя";
	else
		return numWeeks + " нед.";
}

var tCharName = "Имя персонажа";
var tGRank = "Ранг в гильдии";
var toBag = "Origin";
var tTType = "Действие";
var tdBag = "Dest.";
var tItem = "Предмет"
var tDate = "Дата и время";

var tItemName = "Предмет";
var tItemBag = "Вкладка";
var tItemSlot = "Ячейка";
var tItemType = "Тип";
var tItemSubtype = "Подтип";

var tenchT = "Зачаровывание";
var tenchP = "Зачаровывание";

var tLoading = "Загрузка";
var errorLoadingToolTip = "Ошибка загрузки подсказок.";

function returnDateOrder(theMonth, theDay, theYear, theTime) {
	return theDay + theMonth + theYear + theTime; //organize the variables according to your region's custom
}

function returnDay(theDay, nospace) {
	
	if (nospace) {
		switch (theDay) {
		case 0: return 'Воскресенье';
		case 1: return 'Понедельник';
		case 2: return 'Вторник';
		case 3: return 'Среда';
		case 4: return 'Четверг';
		case 5: return 'Пятница';
		case 6: return 'Суббота';
		default: return '';
		}		
	} else {
		switch (theDay) {
		case 0: return 'Вс&nbsp;';
		case 1: return 'Пн&nbsp;';
		case 2: return 'Вт&nbsp';
		case 3: return 'Ср&nbsp;';
		case 4: return 'Чт&nbsp;';
		case 5: return 'Пт&nbsp';
		case 6: return 'Сб&nbsp;';
		default: return '';
		}
	}
}

function formatDate(theDate, isSimple) {

	//var amPM;
	//if (theDate.getHours() >= 12)
	//	amPM = "PM"
	//else
	//	amPM = "AM"
		
	var theHour = theDate.getHours();
	//if (!theHour)
	//	theHour = 12;
		
	var theMinutes = theDate.getMinutes();
	if (!theMinutes)
		theMinutes = "00"
	if ((parseInt(theMinutes) <= 9) && (theMinutes != "00"))	
		theMinutes = "0" + theMinutes;
		
	var theYear = theDate.getFullYear();

	if (isSimple)
		var d = theDate.getDate() +"/"+ (theDate.getMonth() + 1) +"/"+ theYear;
	else
		var d = returnDay(theDate.getDay()) + " " + theDate.getDate() +"/"+ (theDate.getMonth() + 1) +"/"+ theYear +" "+ theHour +":"+ theMinutes;	
	return d;
}

function formatDateGraph(theDate) {
	
	var monthArray = new Array();
	monthArray[0] = "Янв";
	monthArray[1] = "Фев";
	monthArray[2] = "Март";
	monthArray[3] = "Апр";
	monthArray[4] = "Май";
	monthArray[5] = "Июнь";
	monthArray[6] = "Июль";
	monthArray[7] = "Авг";
	monthArray[8] = "Сен";
	monthArray[9] = "Окт";
	monthArray[10] = "Ноя";
	monthArray[11] = "Дек";
	

	//var amPM;
	//if (theDate.getHours() >= 12)
	//	amPM = "PM"
	//else
	//	amPM = "AM"
		
	var theHour = theDate.getHours();
	//if (!theHour)
	//	theHour = 12;

	var theYear = theDate.getFullYear();

	var theMinutes = theDate.getMinutes();
	if (!theMinutes)
		theMinutes = "00"
	if ((parseInt(theMinutes) <= 9) && (theMinutes != "00"))	
		theMinutes = "0" + theMinutes;
		
	var d = new Array();
	d = [theDate.getDate() +". "+ monthArray[theDate.getMonth()] +" "+ theYear, theHour +":"+ theMinutes];
	return d;
}

function returnDateFormat() {
	return ['day', 'month', 'year'];
}

var gTruncItemNameContents = 70;
var gTruncItemName = 35;
var gTruncGuildRank = 18;

function printBag(bagId) {
	return tItemBag + " " + bagId;
}

var textTeam = "Команда";

var textOpponent = "Название команды противника";
var textResult = "Результат";
var textDate = "Дата и время";
var textNewRating = "Новый рейтинг";
var textRatingChange = "Смена рейтинга";

var textOverallRatingChange = "Кол-во смен рейтинга";
var textW = "Пб";
var textWins = "Победы";
var textL = "Пр";
var textLosses = "Поражения";
var textMP = "МС";
var textMatchesPlayed = "Матчей сыграно";
var textWinPercent = "Победы %&nbsp;&nbsp;";
var textAvgChange = "Ср. кол-во смен за матч";

var textCharName = "Имя персонажа";
var textKillingBlows = "Убийства&nbsp;";
var textDamageDone = "Урона нанесено&nbsp;";
var textDamageTaken = "Урона получено&nbsp;";
var textHealingDone = "Ед. лечения&nbsp;";
var textHealingTaken = "Излечено&nbsp;&nbsp;";
var tRace = "Раса&nbsp;";
var tClass = "Класс";
var textFindGraph = "найти на гарфике";
var textEmpty = "";

var textRealm = "Игровой мир";
var textTeamDeleted = "Эта команда распалась";
var textOHistory = "Просмотреть интерактивный обзор всех матчей с этой командой.";

function formatNumber(number)
{
	number = number.toString();
	if (number.length > 3) {
	var mod = number.length % 3;
	var output = (mod > 0 ? (number.substring(0,mod)) : '');
	for (i=0 ; i < Math.floor(number.length / 3); i++) {
		if ((mod == 0) && (i == 0))
			output += number.substring(mod+ 3 * i, mod + 3 * i + 3);
		else
			output+= ',' + number.substring(mod + 3 * i, mod + 3 * i + 3);
	}
	return (output);
	}
	else return number;
}

jsLoaded=true;