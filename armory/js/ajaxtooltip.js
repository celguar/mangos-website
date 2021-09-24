firstPass = true;
ttipXslProcessorIsReady = false;
tranformInProgress=false;
toolVault = new Object();

function findNode(thisNode,hayStack)
{
	var foundNodes = new Array();
	var errorArray = new Array();
	var nodeIndex = 0;
	var hayLength = hayStack.childNodes.length;
	for(nodeFinder=0; nodeFinder < hayLength; nodeFinder++)
	{
		if(hayStack.childNodes[nodeFinder].nodeName == thisNode)
		{
			foundNodes[nodeIndex++] = hayStack.childNodes[nodeFinder];
		}
	}
	if(foundNodes[0]) return foundNodes;
	else return false;
}

function adjustToolTipsWidth() {
	if(t1Elem.offsetWidth > 299) {
		t1Elem.style.width="300px";
	}
	if(t2Elem.offsetWidth > 299) {
		t2Elem.style.width="300px";
	}
	if(t3Elem.offsetWidth > 299) {
		t3Elem.style.width="300px";
	}
}

function loadTooltip(loadingText, itemRef,charUrl) {	
	if (!loadingText)
		return;
	var compareWithChar = getcookie2("armory.cookieDualTooltip");
	var compareCharUrl = encodeURI(getcookie2("armory.cookieCharProfileUrl"));
	var keyAppendage = (charUrl) ? '&'+charUrl : "";
	if (compareWithChar == 1 && compareCharUrl)
		keyAppendage = keyAppendage + '&' + compareCharUrl;
	itemId = (itemRef.mouseover) ? itemRef.id : itemRef;
	showTip(loadingText);	
	if(itemId) {
		var bufferId = itemId + keyAppendage;
		if(toolVault[bufferId]) {
			showTip(toolVault[bufferId][0]);
			if(toolVault[bufferId][1]) { elemttc.style.width = "650px"; showTipTwo(toolVault[bufferId][1]); }
			if(toolVault[bufferId][2]) { elemttc.style.width = "1000px"; showTipThree(toolVault[bufferId][2]); }
		} else
			toolTipTest('item-tooltip.xml@i='+ bufferId,bufferId);
	} else {
		showTip(itemRef.mouseover);
	}
	if (!is_moz)
		tipPosition();
}

function toolTipTest(thisUrl,thisBufferId)
{
	if(!(_SARISSA_IS_SAFARI || window.opera)) {
		if(firstPass) {
			firstPass = false;
			ttipXsltProcessor = new XSLTProcessor();
			var xslDoc = Sarissa.getDomDocument();
			//needs to be async for all browsers, otherwise unformatted responsetext will appear in Firefox for the first item that's moused over
			xslDoc.async = false;
			xslDoc.load("layout/item-tooltip.xsl");
			ttipXsltProcessor.importStylesheet(xslDoc);         
			ttipXslProcessorIsReady = true;
		}
	}
	var safariXmlRequest = new XMLHttpRequest;
	function safariReadystateHandler() {
		if(safariXmlRequest.readyState == 4) {
			var preBufferedItemContainer = document.createElement("div");
			if(_SARISSA_IS_SAFARI || window.opera) {
				preBufferedItemContainer.innerHTML = safariXmlRequest.responseText;
			} else {
				var newItemHtml = ttipXsltProcessor.transformToFragment(safariXmlRequest.responseXML,window.document);
				preBufferedItemContainer.innerHTML = "";
				preBufferedItemContainer.appendChild(newItemHtml);
			}
			/* begin vivisection */
			var nonAjaxTable = findNode("TABLE",preBufferedItemContainer)[0];
			var nonAjaxTbody = findNode("TBODY",nonAjaxTable)[0];
			var nonAjaxTr = findNode("TR",nonAjaxTbody)[0];
			var nonAjaxTooltips = findNode("TD",nonAjaxTr);
			/* end vivisection */
			elemttc.style.width = "300px";
			showTip(nonAjaxTooltips[0].innerHTML);
			toolVault[thisBufferId] = new Array();
			toolVault[thisBufferId][0] = nonAjaxTooltips[0].innerHTML;
			if(nonAjaxTooltips[1]) {
				elemttc.style.width = "650px";
				showTipTwo(nonAjaxTooltips[1].innerHTML);
				toolVault[thisBufferId][1] = nonAjaxTooltips[1].innerHTML;
			}
			if(nonAjaxTooltips[2]) {
				elemttc.style.width = "1000px";
				showTipThree(nonAjaxTooltips[2].innerHTML);
				toolVault[thisBufferId][2] = nonAjaxTooltips[2].innerHTML;
			}
			if(safariXmlRequest.responseText == "") {
				elemtb1.innerHTML = "Data not available";
			}
		}
	}
	safariXmlRequest.onreadystatechange = safariReadystateHandler;
	safariXmlRequest.open("GET", thisUrl, true);
	safariXmlRequest.send(null);
}

jsLoaded=true;//needed for ajax script loading