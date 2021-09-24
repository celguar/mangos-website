var http_request = false;
	if (!window.pinCharName) {
		pinCharName = "";		
		pinRealmName = "";		
		pinGuildName = "";		
		pinGuildUrl = "";		
		pinFactionId = "";		
		pinRace = "";		
		pinClassName = "";		
	
		pinTeam2Url = "";
		pinTeam3Url = "";
		pinTeam5Url = "";
	}

   function ajaxPinChar(url, parameters) {
	  
	  if (pinCharName != "") {
			setCharCookie(pinCharName, pinRealmName, pinGuildName, pinGuildUrl, pinFactionId, pinRace, pinClassName, pinTeam2Url, pinTeam3Url, pinTeam5Url);
	  } else {
		  http_request = false;
		  if (window.XMLHttpRequest) { // Mozilla, Safari,...
			 http_request = new XMLHttpRequest();
			 if (http_request.overrideMimeType) {
				http_request.overrideMimeType('text/xml');
			 }
		  } else if (window.ActiveXObject) { // IE
			 try {
				http_request = new ActiveXObject("Msxml2.XMLHTTP");
			 } catch (e) {
				try {
				   http_request = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			 }
		  }
		  if (!http_request) {
			 alert('Cannot create XMLHTTP instance');
			 return false;
		  }
		  http_request.onreadystatechange = setPinVars;
		  http_request.open('GET', url + parameters, true);
		  http_request.send(null);
	  }
   }





   function setPinVars() {
      if (http_request.readyState == 4) {
         if (http_request.status == 200) {
            var xmldoc = http_request.responseXML;
            var root = xmldoc.getElementsByTagName('character').item(0);

			pinCharName = root.getAttribute('name');		
			pinRealmName = root.getAttribute('realm');		
			pinGuildName = root.getAttribute('guildName');		
			pinGuildUrl = root.getAttribute('guildUrl');		
			pinFactionId = root.getAttribute('factionId');		
			pinRace = root.getAttribute('race');		
			pinClassName = root.getAttribute('class');		

            var teamNodes = xmldoc.getElementsByTagName('arenaTeam');

			var tnLength = teamNodes.length;
			for (i=0;i <tnLength;i++){
				if (teamNodes[i].getAttribute('size') == 2)
					pinTeam2Url = teamNodes[i].getAttribute('url');
				else if (teamNodes[i].getAttribute('size') == 3)
					pinTeam3Url = teamNodes[i].getAttribute('url');			
				else
					pinTeam5Url = teamNodes[i].getAttribute('url');													
			}			
			


			setCharCookie(pinCharName, pinRealmName, pinGuildName, pinGuildUrl, pinFactionId, pinRace, pinClassName, pinTeam2Url, pinTeam3Url, pinTeam5Url);

      	}
   	  }
   }
    
document.getElementById('replacePinButton').innerHTML = "<a href=\"javascript: ajaxPinChar('character-sheet.xml?', theCharUrl);\" onMouseOver = \"javascript: showTip(textClickPin);\" onMouseOut = 'hideTip();' class = 'unpin'></a>";
cookieTest = getcookie2('armory.cookieCharProfileUrl');
if(cookieTest == '0' || !cookieTest) {
	setPinThisChar();
}

jsLoaded=true;