	  var maxPerPage = 20;
	  var totalPages;
	  var currentPage = eval(getcookie2("cookieRightPage"));

	  if (!currentPage)
	  	currentPage = 1;


	totalPages = Math.ceil(rightArray.length/maxPerPage);
	
if (totalPages)
	  setRightPage(currentPage);

function filterRightArray(filterValue) {
	if (filterValue) {
		setFilterPage(1, filterValue);
	} else
		setRightPage(currentPage);
}

function setFilterPage(whichPage, filterValue) {
	filterPage = whichPage;
	filteredArray.length = 0;
	if (region == "TW" || region == "KR" || region == "CN")
		theTrunc = 9;
	else
		theTrunc = 14;

	flashVarsString="initScale=25&#38;overScale=75&#38;overModifierX=40&#38;overModifierY=0&#38;startPointX=3&#38;";    	

	var start = (whichPage - 1) * maxPerPage;
	var theTotal = 0;
	

	var blah = 0;

	  for (var i=0; i < rightArray.length; i++) {
		if (rightArray[i][1].toLowerCase().match(filterValue.toLowerCase())){
			filteredArray[blah] = rightArray[i];
			blah++;
		}
	  }

	totalFilterPages = Math.ceil(filteredArray.length/maxPerPage);

	var theString = '<table class="data-table">';
	  for (var i=start; i < start+maxPerPage; i++) {
		  if (i < filteredArray.length) {
			theString += returnMid2(i, theTrunc);
			theTotal++;
		  }
	  }
  theString += '</table>';
	  document.getElementById('divRight').innerHTML = theString;
	  
	    currentPage = whichPage;
		setcookie("cookieRightPage", whichPage);
	  setPreviousTop2();		
	  setForwardBot2();
	  setPagingBot2();

  if (window.isArenaTeamsRight) {
	var theHeight = theTotal%20;
	if (theHeight == 0)
		theHeight = 20;
	var heightCalc=(theHeight*28)+10;
	if(heightCalc < 100)heightCalc=100;
	printFlash('teamIconBoxresults2', 'http://www.wowarmory.com/images/icons/team/pvpemblems.swf', 'transparent', '', '#000000', '76', heightCalc, 'high', '', flashVarsString + '&#38;totalIcons='+theHeight, '');  
  }

}

function setRightPage(whichPage) {

	if (region == "TW" || region == "KR" || region == "CN")
		theTrunc = 9;
	else
		theTrunc = 14;

	flashVarsString="initScale=25&#38;overScale=75&#38;overModifierX=40&#38;overModifierY=0&#38;startPointX=3&#38;";    	

	var start = (whichPage - 1) * maxPerPage;
	var theTotal = 0;
	var theString = '<table class="data-table">';
	  for (var i=start; i < start+maxPerPage; i++) {
		  if (i < rightArray.length) {
			theString += returnMid(i, theTrunc);
			theTotal++;
		  }
	  }
  theString += '</table>';
	  document.getElementById('divRight').innerHTML = theString;
	  
	    currentPage = whichPage;
		setcookie("cookieRightPage", whichPage);
	  setPreviousTop();		
	  setForwardBot();
	  setPagingBot();

  if (window.isArenaTeamsRight) {
	var theHeight = theTotal%20;
	if (theHeight == 0)
		theHeight = 20;
	var heightCalc=(theHeight*28)+10;
	if(heightCalc < 100)heightCalc=100;
	printFlash('teamIconBoxresults2', 'http://www.wowarmory.com/images/icons/team/pvpemblems.swf', 'transparent', '', '#000000', '76', heightCalc, 'high', '', flashVarsString + '&#38;totalIcons='+theHeight, '');  
  }

}


	  function setPreviousTop() {
		  if (currentPage > 1)
			document.getElementById('divBackTop').innerHTML = '<a href="#" onClick="setRightPage(currentPage - 1); return false;" class="uptab"></a>'
		  else
			document.getElementById('divBackTop').innerHTML = '<a class="uptab-off"></a>';	  
	  }

	  function setPreviousTop2() {
		  if (filterPage > 1)
			document.getElementById('divBackTop').innerHTML = '<a href="#" onClick="setFilterPage(filterPage - 1, document.getElementById(&quot;inputFilter&quot;).value); return false;" class="uptab"></a>'
		  else
			document.getElementById('divBackTop').innerHTML = '<a class="uptab-off"></a>';	  
	  }

	  function setForwardBot() {
		  if (currentPage < totalPages)
			document.getElementById('divForwardBot').innerHTML = '<a href="#" onClick="setRightPage(currentPage + 1); return false;" class="downtab"></a>'
		  else
			document.getElementById('divForwardBot').innerHTML = '<a class="downtab-off"></a>';	  
	  }

	  function setForwardBot2() {
		  if (filterPage < totalFilterPages)
			document.getElementById('divForwardBot').innerHTML = '<a href="#" onClick="setFilterPage(filterPage + 1, document.getElementById(&quot;inputFilter&quot;).value); return false;" class="downtab"></a>'
		  else
			document.getElementById('divForwardBot').innerHTML = '<a class="downtab-off"></a>';	  
	  }

	function setPagingBot() {
		var theString = '<div class="mnav"><ul><li>';
		if (currentPage > 1)
			theString += '<a href="#" onClick="setRightPage(1); return false;" class="prev-first"><img src="/images/pixel.gif" width="1" height="1" /></a>';
		else
			theString += '<a class="prev-first-off"><img src="/images/pixel.gif" width="1" height="1" /></a>';		
		theString += '</li><li>';
		if (currentPage > 1)
			theString += '<a href="#" onClick="setRightPage(currentPage-1); return false;" class="prev"><img src="/images/pixel.gif" width="1" height="1" /></a>';
		else 
			theString += '<a class="prev-off"><img src="/images/pixel.gif" width="1" height="1" /></a>';				
		theString += '</li><li>';
		if (currentPage < totalPages)
			theString += '<a href="#" onClick="setRightPage(currentPage + 1); return false;" class="next"><img src="/images/pixel.gif" width="1" height="1" /></a>';
		else
			theString += '<a class="next-off"><img src="/images/pixel.gif" width="1" height="1" /></a>';		
		theString += '</li><li>';
		if (currentPage < totalPages)		
			theString += '<a href="#" onClick="setRightPage(totalPages); return false;" class="next-last"><img src="/images/pixel.gif" width="1" height="1" /></a>';
		else
			theString += '<a class="next-last-off"><img src="/images/pixel.gif" width="1" height="1" /></a>';		
		theString += '</li></ul></div>';

		document.getElementById('divPagingBot').innerHTML = theString;	  		
	}

	function setPagingBot2() {
		var theString = '<div class="mnav"><ul><li>';
		if (filterPage > 1)
			theString += '<a href="#" onClick="setFilterPage(1, document.getElementById(&quot;inputFilter&quot;).value); return false;" class="prev-first"><img src="/images/pixel.gif" width="1" height="1" /></a>';
		else
			theString += '<a class="prev-first-off"><img src="/images/pixel.gif" width="1" height="1" /></a>';		
		theString += '</li><li>';
		if (filterPage > 1)
			theString += '<a href="#" onClick="setFilterPage(filterPage-1, document.getElementById(&quot;inputFilter&quot;).value); return false;" class="prev"><img src="/images/pixel.gif" width="1" height="1" /></a>';
		else 
			theString += '<a class="prev-off"><img src="/images/pixel.gif" width="1" height="1" /></a>';				
		theString += '</li><li>';
		if (filterPage < totalFilterPages)
			theString += '<a href="#" onClick="setFilterPage(filterPage + 1, document.getElementById(&quot;inputFilter&quot;).value); return false;" class="next"><img src="/images/pixel.gif" width="1" height="1" /></a>';
		else
			theString += '<a class="next-off"><img src="/images/pixel.gif" width="1" height="1" /></a>';		
		theString += '</li><li>';
		if (filterPage < totalFilterPages)		
			theString += '<a href="#" onClick="setFilterPage(totalFilterPages, document.getElementById(&quot;inputFilter&quot;).value); return false;" class="next-last"><img src="/images/pixel.gif" width="1" height="1" /></a>';
		else
			theString += '<a class="next-last-off"><img src="/images/pixel.gif" width="1" height="1" /></a>';		
		theString += '</li></ul></div>';

		document.getElementById('divPagingBot').innerHTML = theString;	  		
	}

	
	