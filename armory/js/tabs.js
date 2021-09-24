
function changeTab(whichTab) {
	
		for(var x=1; x<=tabsCount; x++) {
			document.getElementById('whichTab'+x).className = "select0";		
		}
		changeTabClassname(whichTab);	
		return false;
	}
	
	function changeTabClassname(tabsPosition) {
		tabElement = document.getElementById('whichTab'+tabsPosition);
		if (tabElement)
			tabElement.className = "select1";
	}	

	function printOutTab(theTabName, theTabType, theTabCount, theTabNumber, adjustWidth) {
			//This code prints out the individual tabs
			var theString;
			theString = '<table style = "float:left;"><tr><td>';
			theString += '<div class="select0" id="whichTab'+ theTabNumber +'">';
			  theString += '<ul>';
				theString += '<li class="tab-left" />';
				  theString += '<li class="tab-content"'
				  if (adjustWidth)
					  theString += ' style = "width: '+ adjustWidth +'px"'				  	
				  theString += '><span>';
				    theString += '<a href="javascript:searchPageInstance.setSelectedTab(\''+ theTabType +'\');" class="active">';
				      theString += theTabName + ' ('+ theTabCount +')';
				    theString += '</a></span>';
				  theString += '</li>';
				theString += '<li class="tab-right" />';
			  theString += '</ul>';
			theString += '</div>';
			theString += '</td></tr></table>';	
			return theString;
	}


	function printOutTabTemplate(theTabName, theTabType, theTabNumber, theTabClass, theTabLink, theTabTooltip, adjustWidth) {
			//This code prints out the individual tabs
			
			var theString;
			theString = '<table style = "float:left;"><tr><td>';
			theString += '<div class="'+ theTabClass +'" id="whichTab'+ theTabNumber +'"';
			  if (theTabTooltip != '')
				  theString += ' onMouseOut="hideTip();" onMouseOver="showTip(&quot;'+theTabTooltip+'&quot;);"';
			  theString += '><ul>';
				theString += '<li class="tab-left" />';
				  theString += '<li class="tab-content"'
				  if (adjustWidth)
					  theString += ' style = "width: '+ adjustWidth +'px"'				  	
				  theString += '><span>';
				    theString += '<a href="'+ theTabLink +'" class="active">';
				      theString += theTabName;
				    theString += '</a></span>';
				  theString += '</li>';
				theString += '<li class="tab-right" />';
			  theString += '</ul>';
			theString += '</div>';
			theString += '</td></tr></table>';	
			return theString;
	}

	function rulerTest(){

		 //find out the width of all the tabs together	 
		 var k = 1;
		 var widthFull = 0;
		 var adjustArray = new Array;
		 for (k=1; k <= tabsCount; ++k) {
			widthFull += document.getElementById("whichTab"+k).offsetWidth;
			adjustArray[k-1] = 0;
		 }	 

		 //if all the divs put together is longer than the page
		
		if (widthFull > 849) {

		 //find out where to break the tabs into two rows
		 k = 1;
		 for (var incrementWidth = 0; incrementWidth < (widthFull/2 - 50); ++k) {
			incrementWidth += document.getElementById("whichTab"+k).offsetWidth;
		 }
 
 		//width of the two rows
		rowOneLength = incrementWidth;
		rowTwoLength = widthFull - incrementWidth;

		//set variables
		if (rowOneLength < rowTwoLength) {
			adjustTabStart = 1;
			adjustTabEnd = k-1;
			longerRow = rowTwoLength;
			shorterRow = rowOneLength;
		} else {
			adjustTabStart = k;
			adjustTabEnd = tabsCount;
			longerRow = rowOneLength;
			shorterRow = rowTwoLength;		
		}
	
		//get the difference between the two rows
		theDifference = longerRow - shorterRow;
		
		numberOfRows = adjustTabEnd - adjustTabStart + 1;
		averageAdjustLength = Math.ceil(longerRow/numberOfRows)
	
		//see how many tabs need to be adjusted
		adjustTabsCount = 0;
		for (c = adjustTabStart; c <= adjustTabEnd; ++c){
			if (averageAdjustLength > document.getElementById("whichTab"+c).offsetWidth) {
				adjustArray[c-1] = 1;
				adjustTabsCount++;
			}
		}
	
		actualAdjustmentLength = Math.ceil(theDifference/adjustTabsCount);

		//set the adjustment lengths in an array
		for (c = adjustTabStart; c <= adjustTabEnd; ++c){
			if (adjustArray[c-1]) {
				adjustArray[c-1] = document.getElementById("whichTab"+c).offsetWidth + actualAdjustmentLength - 36;
			}
		}

		//make the adjustment length for the selected tab longer
		if (adjustSelected = adjustArray[tabsPosition-1])
			adjustArray[tabsPosition-1] = adjustSelected + 20;
		else
			adjustArray[tabsPosition-1] = document.getElementById("whichTab"+tabsPosition).offsetWidth + actualAdjustmentLength - 36 + 20;

		var row2Start = k; //which tab starts the second row
		if (tabsPosition < row2Start-1) {
			tabsStartTop = row2Start;
			tabsEndTop = tabsCount;
			tabsStartBottom = 1;
			tabsEndBottom = row2Start-1;	
		} else {
			tabsStartTop = 1;
			tabsEndTop = row2Start-1;
			tabsStartBottom = row2Start;
			tabsEndBottom = tabsCount;
		}
	

		//print out top row
		var replaceWithThis = '<div class="tabs top">';
		for (tabsStartTop; tabsStartTop <= tabsEndTop; tabsStartTop++) {
			replaceWithThis += printOutTab(tabsArray[tabsStartTop-1][1], tabsArray[tabsStartTop-1][0], tabsArray[tabsStartTop-1][2], tabsStartTop, adjustArray[tabsStartTop-1]);
		}
		replaceWithThis +='</div>';
		
		//print out bottom row
		replaceWithThis +='<div class="tabs">';
		for (tabsStartBottom; tabsStartBottom <= tabsEndBottom; tabsStartBottom++) {
			replaceWithThis += printOutTab(tabsArray[tabsStartBottom-1][1], tabsArray[tabsStartBottom-1][0], tabsArray[tabsStartTop-1][2], tabsStartBottom, adjustArray[tabsStartBottom-1]);
		}
		replaceWithThis +='</div>';
			
		document.getElementById("replaceMe").innerHTML = replaceWithThis;		
		changeTabClassname(tabsPosition);
		}
	}
jsLoaded=true;//needed for ajax script loading