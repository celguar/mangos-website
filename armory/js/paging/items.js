isItems = 1;

var textDecSpecial = "<span class = 'tooltipContentSpecial' style = 'float: left;' >";
var textDecSpecialEnd = "</span>";

var textDungeon = textDecSpecial + textDungeon + "&nbsp;" + textDecSpecialEnd;
var textBoss = textDecSpecial + textBoss + "&nbsp;" + textDecSpecialEnd;
var textDropRate = textDecSpecial + textDropRate + "&nbsp;" + textDecSpecialEnd;

function printDropRate (value) {
	switch (value) {
		case 0:
			return textDR0;
		case 1:
			return textDR1;
		case 2:
			return textDR2;
		case 3:
			return textDR3;
		case 4:
			return textDR4;
		case 5:
			return textDR5;
		case 6:
			return textDR6;
		default:
			return "";
	}
}

function printMid(subArray) {

	var recMouse = "";
	var truncateVars = 0;
	if (arrayCol.length > 6)
		truncateVars = Math.ceil(20/8 * -arrayCol.length) + constantTruncate;

	if (isRec && arrayCol[arrayCol.length-2][3]) {
		recMouse = ' onMouseOver = "javascript: showTip(&quot;';
		var t = arrayCol.length - 2;
		for (var p = 2; p <= t; p++) {
			var currentValue = arrayCol[p][3];
			if (currentValue) {
			  var adjustedValue2 = Math.round(((subArray[p+1][0] - currentValue) * 10))/10;
			  if (adjustedValue2 > 0) {
			    adjustedValue = "<span";
				if (arrayCol[p][0] != "speed")
					adjustedValue += " class = 'hover-upgrade'";
				adjustedValue += ">+"+ adjustedValue2;
			  } else if (adjustedValue2 < 0) {
			    adjustedValue = "<span";
				if (arrayCol[p][0] != "speed")
					adjustedValue += " class = 'hover-downgrade'";
				adjustedValue += ">"+ adjustedValue2;
			  } else {
			    adjustedValue = "<span class = 'hover-gray'>"+ adjustedValue2;
			  }
			  recMouse += adjustedValue + " "+ eval(arrayCol[p][0]) +"</span><br />";
			}
		}
		recMouse += '&quot;);" onMouseOut = "javascript: hideTip();"';		
	}

	var theString = '<tr';
	if (isRec && currentItem == subArray[0][1])
		theString += ' class = "data2"';
	theString += '><td><div><p><img src="images/pixel.gif" width="1" height="1" /></p></div></td></td>';
	theString += '<td align = "center"><a onMouseOut = "javascript: hideTip();" onMouseOver="javascript: loadTooltip(textLoading, '+ subArray[0][1] +')" href="item-info.xml?'+ subArray[0][2] +'"><img src="images/icons/43x43/'+ subArray[0][0] +'.png" class="p43" border = "0" /></a></td>';	
	theString += '<td><q'+ globalColSelected[1] +'><strong><a onMouseOut = "javascript: hideTip();" onMouseOver="javascript: loadTooltip(textLoading, '+ subArray[0][1] +')" href = "item-info.xml?'+ subArray[0][2] +'" class = "rarity'+ subArray[0][3] +'">';
	theString += truncateString(subArray[1][0], truncateVars);
	theString +='</a></strong></q></td>';
	
	
	for (var i=2; i<subArray.length - 1; i++) {
	 	theString += '<td align = "center"><q'+ globalColSelected[i];
		if (isRec && arrayCol[i-1][3])
			theString += recMouse;
		theString += '>';
		theValue = subArray[i][0];
		if (theValue == sourceType.creatureDrop && subArray[i][3])
			theString += "<a href = 'index.php@fl%5Bsource%5D=dungeon&fl%5Bdungeon%5D="+ subArray[i][2] +"&fl%5Bboss%5D=all&fl%5Bdifficulty%5D=all&fl%5Btype%5D=all&searchType=items' onMouseOver = \"javascript: showTip(&quot;" + textDungeon + subArray[i][1] +"<br />"+ textBoss + subArray[i][4] +"<br />"+ textDropRate + printDropRate(subArray[i][6]) +"&quot;);\" onMouseOut = hideTip();>"+ truncateString(subArray[i][1], 11) +"</a>";
		else {
			if (isRec && arrayCol[i-1][3] && arrayCol[i-1][0] != "speed") {
				if (theValue > arrayCol[i-1][3])
					theString += '<span class="color-upgrade" style="font-weight: bold; font-size: 13px;">' + theValue + '</span>';
				else if (theValue < arrayCol[i-1][3]) {
					if (theValue == 0)
						theString += '<span class="color-downgrade" style="font-weight: bold; font-size: 13px;">-</span>';
					else
						theString += '<span class="color-downgrade" style="font-weight: bold; font-size: 13px;">' + theValue + '</span>';
				} else {
					if (theValue == 0)
						theString += '<span class="" style="font-weight: bold; font-size: 13px;">-</span>';
					else
						theString += '<span class="" style="font-weight: bold; font-size: 13px;">' + theValue + '</span>';
				}
			} else
				theString += theValue;
		}
		theString += '</q></td>';
	}
	theString += '<td class="relevance" align="center"><q'+ globalColSelected[subArray.length - 1] +' onMouseOver = "showTip(\''+ tRelevanceKr + ' '+ subArray[subArray.length - 1] +'% '+ tRelevance +'\')" onMouseOut = "hideTip();"><del class="rel-container"><a><em style = "width: '+ subArray[subArray.length - 1] +'%"></em></a></del></q></td>';
	theString += '<td align="right"><div><b><img src="images/pixel.gif" width="1" height="1" /></b></div></td></tr>';  
	return theString;
}