function setColSelected(whichCol) {
    globalColSelected[whichCol] = ' class = "rating"';
}

function clearColSelected() {
  for (var i = 0; i <= arrayCol.length; i++) {
    globalColSelected[i] = "";
  }
}


var elemRST = document.getElementById('replaceSearchTable');
var elemRPT = document.getElementById('replacePagesTop');


function setResultsPage(whichPage) {
     flashVarsString="initScale=35&#38;overScale=100&#38;overModifierX=0&#38;overModifierY=0&#38;startPointX=43&#38;";	  
  if ((typeof eval(whichPage)) != 'number' || whichPage > globalPages || whichPage <= 0)
    return false;

  globalWhichPage = whichPage;

  whichCol = globalSort[0];
  upDown = globalSort[1];

  replaceSearchTop = printSearchCol(arrayCol, whichCol, upDown);

  replaceSearchMid = "";
  theStart = (whichPage - 1) * globalResultsPerPage;

  for (var x = 0; x < globalResultsPerPage && theArray[theStart]; x++) {
	replaceSearchMid += printMid(theArray[theStart], x);
	theStart++;
  }

  elemRST.innerHTML = replaceSearchTop + replaceSearchMid +replaceStringGuildBot;
  
  var stringPrintPage = printPage(whichPage);
  
  elemRPT.innerHTML = stringPrintPage;
  if (window.elemRPB)
	  elemRPB.innerHTML = stringPrintPage;
  setcookie("cookieLeftPage", whichPage);
  setcookie("cookieRightPage", whichPage);
  
  if (window.isArenaTeams) {
    var theHeight = theStart%20;
    if (theHeight == 0)
  	  theHeight = 20;	  
	var heightCalc=(theHeight*28)+10;
	if(heightCalc < 100)heightCalc=100;
	printFlash('teamIconBox', 'images/icons/team/pvpemblems.swf', 'transparent', '', '#000000', '76', heightCalc, 'high', '', flashVarsString + '&#38;totalIcons='+theHeight, '');  
  }
  
}

function value(a,b) {
if (is_moz) {
	a = a[globalSort[0]] + "zz" + a[0][0];
	b = b[globalSort[0]] + "zz" + b[0][0];
} else {
	a = a[globalSort[0]];
	b = b[globalSort[0]];	
}
return a == b ? 0 : (a < b ? -1 : 1)
}

function valueAs(a,b) {
if (is_moz) {
a = a[globalSort[0]] + "zz" + a[0][0];
b = b[globalSort[0]] + "zz" + b[0][0];
} else {
a = a[globalSort[0]];
b = b[globalSort[0]];	
}
return a == b ? 0 : (a < b ? 1 : -1)
}

function sortNumber(a, b) {
	var theValue = b[globalSort[0]][0] - a[globalSort[0]][0];
	if (theValue)
		return b[globalSort[0]][0] - a[globalSort[0]][0];
	else {
		a = a[0][0];
		b = b[0][0];
		return a == b ? 0 : (a < b ? -1 : 1)		
	}
}

function sortNumberAs(a, b) {


	var theValue = b[globalSort[0]][0] - a[globalSort[0]][0];
	if (theValue)
		return a[globalSort[0]][0] - b[globalSort[0]][0];
	else {
		a = a[0][0];
		b = b[0][0];
		return a == b ? 0 : (a < b ? 1 : -1);
	}

}

function sortSearch(whichElement, useCookie) {

  var lengthArrayCol = arrayCol.length;
  if (whichElement > lengthArrayCol)
	  whichElement = lengthArrayCol;
	  
  clearColSelected();
  setColSelected(whichElement);
  
  if (theArray[0] && (typeof theArray[0][whichElement][0]) == 'string') {
    sortAs = valueAs;
	sortDe = value;
  } else {
    sortAs = sortNumberAs;
	sortDe = sortNumber;
  }

  if (useCookie) {
	if (getcookie2("cookieLeftSortUD") == 'u')
	  globalSort[1] = 'd';
	else
	  globalSort[1] = 'u';	
  }

  if (whichElement == globalSort[0] && globalSort[1] == 'd') {
    theArray.sort(eval(sortAs));
	globalSort[1] = 'u';
  } else {
    globalSort[0] = whichElement;  
    theArray.sort(eval(sortDe));
	globalSort[1] = 'd';	
  }

  setResultsPage(globalWhichPage);
  if (whichElement == lengthArrayCol)
  	whichElement = 0 - lengthArrayCol;
	
  setcookie("cookieLeftSort", whichElement);
  setcookie("cookieLeftSortUD", globalSort[1]);
}

function printSearchCol(inputArray, whichCol, upDown) {

	var truncateVar = 0;

	if (inputArray.length > 6);
		truncateVar = 6;

	var theString = '<table class="data-table"><tr class="masthead"><td><div><p><img src="images/pixel.gif" width="1" height="1" /></p></div></td>';
	
	if (window.isItems)
		theString += '<td width = "1"><div><p><img src="images/pixel.gif" width="1" height="1" /></p></div></td>';
	
	if (upDown == 'u')
	  theArrow = "up";
	else
	  theArrow = "down";	
	
	for (var i = 0; i < inputArray.length; i++) {
	  var theBool;
	  if (window.isItems && i > 3 && i != inputArray.length -1)
	  	theBool = 1;
	  else
	    theBool = 0;
	  theString += '<td';
	  if (window.isItems && i == 0)
	  	theString += ' width = "1%"';
	  if (inputArray[i][3] && !window.isItems)
	    theString += ' width = "'+ inputArray[i][3] +'"';
	  if (inputArray[i][1])
	  	theString += ' align = "'+ inputArray[i][1] +'"';
	  if (inputArray[i][2])
		  theString += ' class = "'+ inputArray[i][2] +'"';
	  theString += '><a';
	  if (i == (whichCol - 1))
	    theString += ' class = "mastSort"';
	  if (theBool && inputArray[i][0].length > truncateVar) {
	    theString += ' onMouseOver = "javascript: showTip('+ inputArray[i][0] +');" onMouseOut = "javascript: hideTip();"';
	  }
	  theString += ' href = "#" onClick = "sortSearch('+ eval(i + 1) +'); return false;">';
	  if (theBool)
		  theString += truncateString(eval(inputArray[i][0]), truncateVar);
	  else
		  theString += eval(inputArray[i][0]);
	  if (i == (whichCol - 1))
	    theString += '<span class="sort '+ theArrow +'"></span>';
	  theString += '</a>';
	  if (window.isArenaTeams && i == 0)
		theString += '<div id="teamIconBoxContainer" style = "height: 0px;"><div id="teamIconBox" style = "height: 0px;"></div></div>';
	  theString += '</td>';	
	}
	theString += '<td align="right"><div><b><img src="images/pixel.gif" width="1" height="1" /></b></div></td></tr>';
	
	return theString;
}



function printPage(currentPage) {
		
  var lowerLimit = eval(currentPage) - 2;
  var upperLimit = eval(currentPage) + 2;

  var totalPages = globalPages;
  var arrowsFirst = "";
  var arrowsLast = "";
  var arrowsFirstLink = "";
  var arrowsPrevLink = "";  
  
  var arrowsLastLink = "";
  var arrowsNextLink = "";    
  
  if (currentPage == 1)
    arrowsFirst = "-off";
  else {
    arrowsFirstLink = ' href = "#" onClick="setResultsPage(1); return false;"';
    arrowsPrevLink = ' href = "#" onClick="setResultsPage('+ eval(currentPage - 1) +'); return false;"';
  }

  if (currentPage == totalPages)
    arrowsLast = "-off";
  else {
    arrowsLastLink = ' href = "#" onClick="setResultsPage('+ totalPages +'); return false;"';
    arrowsNextLink = ' href = "#" onClick="setResultsPage('+ eval(currentPage + 1) +'); return false;"';
  }	
	
	
	if(theLang != "ko_kr") {
	  var theString = '<div class="returned"><span>'+ tPage +' <input type="text" value="'+ currentPage +'" onkeyup="setResultsPage(this.value)" size="3" class="pagesInput" onfocus="this.value=\'\'" onblur="if (this.value==\'\') this.value=\''+ currentPage +'\'"/> '+ textOf +' '+ totalPages +'</span></div><div class = "pnav"><ul><li><a class="prev-first'+ arrowsFirst +'"'+ arrowsFirstLink +'><img src="images/pixel.gif" height="1" width="1" /></a></li>';
	  theString += '<li><a class="prev'+ arrowsFirst +'"'+ arrowsPrevLink +'><img src="images/pixel.gif" height="1" width="1" /></a></li>';
	} else {
	  var theString = '<div class="returned"><span>'+ totalPages +' '+ textOf +' <input type="text" value="'+ currentPage +'" onkeyup="setResultsPage(this.value)" size="3" class="pagesInput" onfocus="this.value=\'\'" onblur="if (this.value==\'\') this.value=\''+ currentPage +'\'"/> '+ tPage +'</span></div><div class = "pnav"><ul><li><a class="prev-first'+ arrowsFirst +'"'+ arrowsFirstLink +'><img src="images/pixel.gif" height="1" width="1" /></a></li>';
	  theString += '<li><a class="prev'+ arrowsFirst +'"'+ arrowsPrevLink +'><img src="images/pixel.gif" height="1" width="1" /></a></li>';		
	}
	


  for (var i=1; i <= totalPages; i++) {
    if (i == 1 || i == totalPages || (lowerLimit <= i && i <= upperLimit)) {
      if (i == currentPage)
	    theString += '<li><a class="sel">'+ i +'</a></li>';
	  else
        theString += '<li><a class="p" href="#" onClick="setResultsPage('+ i +'); return false;">'+ i +'</a></li>';
	}
  }
  
  theString += '<li><a class="next'+ arrowsLast +'"'+ arrowsNextLink +'><img src="images/pixel.gif" height="1" width="1" /></a></li><li>';
  theString += '<a class="next-last'+ arrowsLast +'"'+ arrowsLastLink +'><img src="images/pixel.gif" height="1" width="1" /></a></li></ul></div>';
  
  return theString;
}