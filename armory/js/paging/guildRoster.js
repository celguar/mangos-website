var arrayCol = new Array();
arrayCol[0] = ["textMembers"];
arrayCol[1] = ["textLevel", "center"];
arrayCol[2] = ["textRace", "right"];
arrayCol[3] = ["textClass", "center"];
arrayCol[4] = ["textGuildRank", "center"];

//Specific
function printMid(subArray) {	
	var theString = '<tr';
	if (subArray[5][0] == 0)
		theString += ' class = "data3"';
	theString += '><td><div><p></p></div></td>';
	theString += '><td><div><p><img src="images/pixel.gif" width="1" height="1" /></p></div></td>';
	theString += '<td width="65%"><q'+ globalColSelected[1] +'><a href="index.php?searchType=profile'+ subArray[0][0] +'"><strong>'+ subArray[1] +'</strong></a></q>';
	theString += '</td><td align="center" width="60"><q'+ globalColSelected[2] +'>'+ subArray[2] +'</q></td>';
	theString += '<td align="right" width="60" style="padding-right: 3px;"><img onmouseover = "showTip(&quot;'+ subArray[3][2] +'&quot;)" onmouseout="hideTip()" class="ci" src="images/icons/race/'+ subArray[3][0] +'-'+ subArray[3][1] +'.gif" /></td>';
	theString += '<td align="left" width="60" style="padding-left: 3px;"><img onmouseover = "showTip(&quot;'+ subArray[4][1] +'&quot;)" onmouseout="hideTip()" class="ci" src="images/icons/class/'+ subArray[4][0] +'.gif" /></td>';
	theString += '<td align="center" width="35%">';
	if (subArray[5][0] == 0)
		// Guild Leader theString += '<q><strong class="gm">'+ tGuildLeader +'</strong>';
		// Guild Master rank name
		theString += '<q><strong class="gm">'+ subArray[5][1] +'</strong>';
	else
		theString += '<q '+ globalColSelected[5] +'>'/*+ tGuildRank +' '*/+ subArray[5][1];
	theString += '</q></td>';
	theString += '<td align="right"><div><b><img src="images/pixel.gif" width="1" height="1" /></b></div></td></tr>';
	
	
	return theString;	
}