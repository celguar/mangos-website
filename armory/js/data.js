//must go after strings.js

	var allianceRaceArray = new Array;
	allianceRaceArray[0] = [text1race, 1];
	allianceRaceArray[1] = [text3race, 3];
	allianceRaceArray[2] = [text4race, 4];
	allianceRaceArray[3] = [text7race, 7];
	allianceRaceArray[4] = [text11race, 11];
	
	var hordeRaceArray = new Array;
	hordeRaceArray[0] = [text2race, 2];
	hordeRaceArray[1] = [text5race, 5];
	hordeRaceArray[2] = [text6race, 6];
	hordeRaceArray[3] = [text8race, 8];
	hordeRaceArray[4] = [text10race, 10];
	
	var classStringArray = new Array;
	classStringArray[0] = [text1class, 1];
	classStringArray[1] = [text2class, 2];
	classStringArray[2] = [text3class, 3];
	classStringArray[3] = [text4class, 4];
	classStringArray[4] = [text5class, 5];
	classStringArray[5] = [text6class, 6];
	classStringArray[6] = [text7class, 7];
	classStringArray[7] = [text8class, 8];
	classStringArray[8] = [text9class, 9];
	classStringArray[9] = [text11class, 11];
	
	//sort arrays
	classStringArray.sort();
	hordeRaceArray.sort();	
	allianceRaceArray.sort();
	
var availableArray = new Array;
availableArray[1] = [0, 1, 1, 0, 1, 1, 0, 0, 1, 1, 0, 0];
availableArray[2] = [0, 1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 0];
availableArray[3] = [0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0];
availableArray[4] = [0, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1];
availableArray[5] = [0, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0];
availableArray[6] = [0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1];
availableArray[7] = [0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0];
availableArray[8] = [0, 1, 0, 1, 1, 1, 0, 1, 1, 0, 0, 0];
availableArray[10] = [0, 0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 0];
availableArray[11] = [0, 1, 1, 1, 0, 1, 0, 1, 1, 0, 0, 0];