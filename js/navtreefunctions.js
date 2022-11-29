

function tree(pageId) {

	var treeArray = new Array();
	treeArray = pageId.split('_');
	var treeString = "";
	NoOffFirstLineMenus = treeArray.length;

	for (i = 0; i < treeArray.length; i++ ) {

		treeString = treeString + treeArray[i];

		if (i != 0)
			copyBranch(treeString,'_');
		
		treeString = treeString + "_";
	
	}
	
	if (eval('Menu' + pageId + '[3]') == 0) {
		NoOffFirstLineMenus = treeArray.length + 1;
		eval('Menu' + NoOffFirstLineMenus + '=new Array("<div style = position:absolute><img src = shared/wow-com/images/subnav/dot.gif></div>","#","shared/wow-com/images/subnav/button_bg.gif",0,15,13,"","","","","","",-1,-1,-1,"","");');
	}


}



var menuNum;
var result;

function copyBranch(startPoint, init) {
	var branchLength = eval('Menu' + startPoint + '[3]');
	var sourcePoint = new Array();
	sourcePoint = startPoint.split('_');
	var middle = init;

	if (middle == '_') {
		
		menuNum = sourcePoint.length;
		eval("Menu" + menuNum + "=Menu" + startPoint);
		eval("Menu" + menuNum + "[2]='shared/wow-com/images/subnav/button_bg.gif'");
		
		if (is_ie && eval("Menu" + menuNum + "[0].indexOf('<img')!=-1")){
			var stripArray = eval("Menu" + menuNum + "[0].split('<img src=new-hp/images/menu/mainmenu/bullet-trans-dot-blue.gif align=left />')")
			var stripArray = stripArray[1].split('<img src=new-hp/images/menu/mainmenu/bullet-trans-line-blue.gif />')	
			var stripString	= stripArray[0];
			eval("Menu" + menuNum + "[0]='" + stripString +"'");	
		}
		
		
	}

	for (var i=1; i <= branchLength; i++) {
		
		
		destString = menuNum + middle + i;
		

		eval("Menu" + destString + "=Menu" + startPoint + "_" + i);

		
		
		if (eval('Menu' + startPoint + "_" + i + '[3]') != 0)
			copyBranch(startPoint + "_" + i,middle + i + '_');

	}

}

var urlString = document.location.href;
var forumsBool=0;
if ((urlString.indexOf("?n=forums") != -1) || (urlString.indexOf("?n=forums") != -1))
	forumsBool=1;


var urlStringMax = urlString.length;
	
urlString = urlString.substring(urlString.indexOf("//")+2, urlStringMax);
urlString = urlString.substring(urlString.indexOf("/"), urlStringMax);

if (urlString.indexOf("index.") != -1)
	urlStringMax = urlString.indexOf("index.");
else if (urlString.indexOf(".") != -1)
	urlStringMax = urlString.indexOf(".");
else
	urlStringMax = urlString.length;

urlString = urlString.substring(0, urlStringMax);

function findNode(startPoint, init, searchString) {

	var branchLength = eval('Menu' + startPoint + '[3]');
	var sourcePoint = new Array();
	sourcePoint = startPoint.split('_');
	var middle = init;
	var nodeUrl;
	
	if (searchString.indexOf(pageId) != -1) {
		result = "1";
		return;
	}
	
	
	
	if (middle == '_') {
		menuNum = sourcePoint.length;
	}

	for (var i=1; i <= branchLength; i++) {	
		
		destString = menuNum + middle + i;
		
		nodeUrl = eval("Menu" + startPoint + "_" + i + "[1]");
		
		
		
		if (nodeUrl.indexOf("index.") != -1)
			urlStringMax = nodeUrl.indexOf("index.");
		else if (nodeUrl.indexOf(".") != -1)
			urlStringMax = nodeUrl.indexOf(".");
		else
			urlStringMax = nodeUrl.length;
			
		nodeUrl = nodeUrl.substring(0, urlStringMax);
		
		
		if ((urlString.indexOf("/account/") != -1) || forumsBool || (urlString.indexOf("/contests/") != -1) || (urlString.indexOf("/loginsupport/") != -1))
			nodeUrl = urlString;
		
		//alert(eval("Menu" + startPoint + "_" + i + "[0]") + "\n" + searchString);
		
		if((eval("Menu" + startPoint + "_" + i + "[0]") == searchString) && (nodeUrl == urlString)) {
			result = startPoint + "_" + i;
			return;
		}
	

		
		if (eval('Menu' + startPoint + "_" + i + '[3]') != 0)
			findNode(startPoint + "_" + i,middle + i + '_',searchString);

	}

}

if(is_ie)
	pageId='<img src=new-hp/images/menu/mainmenu/bullet-trans-dot-blue.gif align=left />'+pageId+'<img src=new-hp/images/menu/mainmenu/bullet-trans-line-blue.gif />'
findNode('1','_',pageId);

function printSubNav(treeId, mode)
{
	var navLength;
	eval("navLength=Menu" + treeId + "[3]");
	if(mode == 1)
	{
		for (i=1; i <= navLength; i++)
		{
			var stripString=stripId(eval("Menu" + treeId + "_" + i + "[0]"));
			document.write("<a href = '" + eval("Menu" + treeId + "_" + i + "[1]") + "' class = 'nav'>" + stripString + "</a>");
			if (i < navLength)
			{
				document.write(" | ");
			}
		}
	}
	if(mode == 2)
	{
		if (navLength>0)
		{
			document.write("<a href = '" + eval("Menu" + treeId + "[1]") + "'>" + stripId(eval("Menu" + treeId + "[0]")) + "</a> > ");
			for (i=1; i <= navLength; i++)
			{
				var stripString=stripId(eval("Menu" + treeId + "_" + i + "[0]"));
				if (stripString != stripId(pageId))
				{
					document.write("<a href = '" + eval("Menu" + treeId + "_" + i + "[1]") + "'><nobr>" + stripString + "</nobr></a>");
					if (i < navLength) document.write(" | ");
				}
			}
			document.write("<p>");
		}
	}
	if(mode == 3)
	{
		if (navLength>0)
		{
			if (stripId(eval("Menu" + treeId + "[0]")) != pageId)
			{
				document.write("<a href = '" + eval("Menu" + treeId + "[1]") + "' class = 'nav'>" + eval("Menu" + treeId + "[0]") + "</a> > ");
			}
			else
			{
				document.write("<span style = 'font-family:verdana, arial, sans-serif; font-size:10px; font-weight:bold; color:white;'>" + eval("Menu" + treeId + "[0]") + "</span> > ");
			}
			for (i=1; i <= navLength; i++)
			{
				var stripString=stripId(eval("Menu" + treeId + "_" + i + "[0]"));
				if (stripString != stripId(pageId))
				{
					document.write("<a href = '" + eval("Menu" + treeId + "_" + i + "[1]") + "' class = 'nav'><nobr>" + stripString + "</nobr></a>");
					if (i < navLength)
					{
						document.write(" | ");
					}
				}
				else
				{
					document.write("<span style = 'font-family:verdana, arial, sans-serif; font-size:10px; font-weight:bold; color:white;'><nobr>" + stripString + "</nobr></span>");
					if (i < navLength) document.write(" | ");
				}
			}
		}
	}
}

function printSubNavXML(treeId, mode)
{
	var navLength;
	var xmlSubNavString = "";
	eval("navLength=Menu" + treeId + "[3]");
	if(mode == 1)
	{
		for (i=1; i <= navLength; i++)
		{
			var stripString=stripId(eval("Menu" + treeId + "_" + i + "[0]"));
			document.write("<a href = '" + eval("Menu" + treeId + "_" + i + "[1]") + "' class = 'nav'>" + stripString + "</a>");
			if (i < navLength)
			{
				document.write(" | ");
			}
		}
	}
	if(mode == 2)
	{
		if (navLength>0)
		{
			document.write("<a href = '" + eval("Menu" + treeId + "[1]") + "'>" + stripId(eval("Menu" + treeId + "[0]")) + "</a> > ");
			for (i=1; i <= navLength; i++)
			{
				var stripString=stripId(eval("Menu" + treeId + "_" + i + "[0]"));
				if (stripString != stripId(pageId))
				{
					document.write("<a href = '" + eval("Menu" + treeId + "_" + i + "[1]") + "'><nobr>" + stripString + "</nobr></a>");
					if (i < navLength) document.write(" | ");
				}
			}
			document.write("<p>");
		}
	}
	if(mode == 3)
	{
		if (navLength>0)
		{
			if (stripId(eval("Menu" + treeId + "[0]")) != pageId)
			{
				xmlSubNavString += "<a href = '" + eval("Menu" + treeId + "[1]") + "' class = 'nav'>" + eval("Menu" + treeId + "[0]") + "</a> > ";
			}
			else
			{
				xmlSubNavString += "<span style = 'font-family:verdana, arial, sans-serif; font-size:10px; font-weight:bold; color:white;'>" + eval("Menu" + treeId + "[0]") + "</span> > ";
			}
			for (i=1; i <= navLength; i++)
			{
				var stripString=stripId(eval("Menu" + treeId + "_" + i + "[0]"));
				if (stripString != stripId(pageId))
				{
					xmlSubNavString += "<a href = '" + eval("Menu" + treeId + "_" + i + "[1]") + "' class = 'nav'><nobr>" + stripString + "</nobr></a>";
					if (i < navLength)
					{
						xmlSubNavString += " | ";
					}
				}
				else
				{
					xmlSubNavString += "<span style = 'font-family:verdana, arial, sans-serif; font-size:10px; font-weight:bold; color:white;'><nobr>" + stripString + "</nobr></span>";
					if (i < navLength)
					{
						xmlSubNavString += " | ";
					}
				}
			}
		}
	}
	document.getElementById("subNavTwoContainer").innerHTML = xmlSubNavString;
}

function stripId(idString){

			if(is_ie && idString.indexOf('<img')!=-1){
			
				var stripArray = idString.split('<img src=new-hp/images/menu/mainmenu/bullet-trans-dot-blue.gif align=left />');
				var stripArray = stripArray[1].split('<img src=new-hp/images/menu/mainmenu/bullet-trans-line-blue.gif />')	
				var stripString	= stripArray[0];
				return stripString;
				
			}else{
				return idString;
			}		

}

function printRelatedLinks(treeId) {
	
	
	var treeArray = new Array();
	treeArray = treeId.split('_');
	var treeString = "";
	
	for (i = 0; i < treeArray.length-1; i++ ) {

		treeString = treeString + treeArray[i];

		if (i != treeArray.length-2)
			treeString = treeString + "_";
	
	}	
	
	printSubNav(treeString,2);

}



function printSubNav2(treeId)
{
	var treeArray = new Array();
	treeArray = treeId.split('_');
	var treeString = "";
	for (i = 0; i < treeArray.length-1; i++ )
	{
		treeString = treeString + treeArray[i];
		if (i != treeArray.length-2) treeString = treeString + "_";	
	}	
	if(window.location.href.indexOf(".xml") == -1)
	{
		if (eval("Menu" + treeId + "[3]") == 0) printSubNav(treeString,3);
		else printSubNav(result,3);
	}
	else
	{
		if (eval("Menu" + treeId + "[3]") == 0) printSubNavXML(treeString,3);
		else printSubNavXML(result,3);
	}
}

tree(result);