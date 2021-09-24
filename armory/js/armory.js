// armory.js
//
// This is the master include file for any armory-specific javascript files.
//
// requires:
//   sarissa.js
//   

//sets a default ? to the begining of the url

var right = 0;
//begin UTF8
var Utf8 = {
    // public method for url encoding
    encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
		var sLength = string.length;

        for (var n = 0; n < sLength; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                utftext += String.fromCharCode(c);
            } else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            } else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    // public method for url decoding
    decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;
		var textLength = utftext.length;
        while ( i <  textLength) {
            c = utftext.charCodeAt(i);
            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            } else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            } else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}
//end UTF8





var IS_ENABLED_XSLT=is_moz;


/*var pathnameParse=document.location.href.split(window.location.protocol + "/")[1].split("index.php")[1];
var hashParse=pathnameParse.split("#")[1];
pathnameParse=pathnameParse.split("#")[0];*/

//if a hash url is present but this is not an XSLT enabled browser, interpret the hash and send the browser to the correct page
/*if(!IS_ENABLED_XSLT && hashParse && hashParse.indexOf(".xml")>-1){
	document.location.hash="";
	document.location=hashParse;
}

if(IS_ENABLED_XSLT && is_ie){

	if(!pathnameParse && !hashParse){//if url path is blank
		setcookie("currentPage","index.php","session");
		setcookie("historyStorage","","session")
		document.location.href=document.location.href+'?';
	}

}*/


   function PageQuery(q) {
        // we want to store everything to the right of the ? in a key value pair array
        var qSplit = q.split("?");

        if (qSplit.length > 1)
            this.q = qSplit[qSplit.length - 1];    // use the right-most element since there may be ? chars in a hash
        else
            this.q = null;

        this.keyValuePairs = new Array();

        if(this.q) {
            for(var i=0; i < this.q.split("&").length; i++) {
                this.keyValuePairs[i] = this.q.split("&")[i];
            }
        }


        this.getKeyValuePairs = function() { return this.keyValuePairs; }

        this.getValue = function(s) {
            for(var j=0; j < this.keyValuePairs.length; j++) {
                if(this.keyValuePairs[j].split("=")[0] == s)
                    return this.keyValuePairs[j].split("=")[1];
            }
            return false;
        }

        this.getParameters = function() {
            var a = new Array(this.getLength());
            for(var j=0; j < this.keyValuePairs.length; j++) {
                a[j] = this.keyValuePairs[j].split("=")[0];
            }
            return a;
        }
        this.getLength = function() { return this.keyValuePairs.length; }
   }

    function queryString(key, defaultValue){
        // try extracting query params from a hash first
        //alert('window.location.hash = ' + window.location.hash);
		
		
		var theHash;
		var pageHash;
		var queryValueHash
		
		if(IS_ENABLED_XSLT && !window.location.search){
			if(is_ie6)
				theHash = window.location.href.split('#')[1];
			else
				theHash = window.location.hash;
				
			if(!theHash)
				theHash = window.historyStorage.getCurrentPage();
		
		
			pageHash = new PageQuery(theHash);
			queryValueHash = pageHash.getValue(key);

		}
		
        if (queryValueHash) {
            return (decodeURI(queryValueHash));
        } else {
            // there weren't any query params in the hash so try again without the hash
            var page = new PageQuery(window.location.search);
            var queryValue = page.getValue(key);
            //alert("window.location.search = " + window.location.search);
			//alert("failed to get value for hash key = " + key + ", non-hash value = " + queryValue);

            if (queryValue)
			    return (decodeURI(queryValue));
            else
                return defaultValue;
        }
    }

    function setSelectIndexToValue(selectObject, optionValue) {
        if ((selectObject != "") && (optionValue != "") && (selectObject.selectedIndex > -1) && (selectObject[selectObject.selectedIndex].value != optionValue)) {
            var newIndex = 0;
			var objectLength = selectObject.length;
            for (var i = 0; i < objectLength; i++) {
                if (selectObject[i].value == optionValue) {
                    newIndex = i;
                    break;
                }
            }
            selectObject.selectedIndex = newIndex;
        }
     }

    function appendUrlParam(source, paramName, paramValue) {
        var result = "";
        if (source != "")
            result = source + '&';
        result = result + paramName + "=" + encodeURI(paramValue);
        return result;
    }

    function appendUrlMapParam(source, mapName, paramName, paramValue) {
        var result = "";
        if (source != "")
            result = source + '&';
        result = result + mapName + "[" + paramName + "]=" + encodeURI(paramValue);
        return result;
    }

    function insertUrlParam(source, paramName, paramValue) {
        var tempUrl = "";
        var anchorArray = source.split("#");
        var queryArray = anchorArray[0].split("?");
        tempUrl = queryArray[0] + "?";
        if (queryArray.length > 1)
           tempUrl = tempUrl + queryArray[1] + "&";
        tempUrl = tempUrl + paramName + "=" + escape(paramValue);
        if (anchorArray.length > 1)
           tempUrl = tempUrl + "#" + anchorArray[1];
        return tempUrl;
    }


	
    var armoryJSLoaded=1;


//begin cookies section
function getexpirydate(nodays){
	var UTCstring;
	Today = new Date();
	nomilli=Date.parse(Today);
	Today.setTime(nomilli+nodays*24*60*60*1000);
	UTCstring = Today.toUTCString();
	return UTCstring;
}

function getcookie2(cookiename) {
	 var cookiestring=""+document.cookie;
	 var index1=cookiestring.indexOf(cookiename);
	 if (index1==-1 || cookiename=="") return ""; 
	 var index2=cookiestring.indexOf(';',index1);
	 if (index2==-1) index2=cookiestring.length; 
	 return unescape(cookiestring.substring(index1+cookiename.length+1,index2));
}
function setcookie(name,value,expire){
	var expireString="EXPIRES="+ getexpirydate(365)+";"
	if(expire=="session")
		expireString="";
	cookiestring=name+"="+escape(value)+";"+expireString+"PATH=/";
	document.cookie=cookiestring;
}

// this deletes the cookie when called
function deletecookie( name, path, domain ) {
if ( getcookie2( name ) ) document.cookie = name + "=" +
( ( path ) ? ";path=" + path : "") +
( ( domain ) ? ";domain=" + domain : "" ) +
";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}
//end cookies section




//begin functions section
var region="";
if(document.location.href.indexOf("www.wowarmory.com")!=-1){//change by akim (add KR)
    region="US";
} else if(document.location.href.indexOf("wow-europe.com")!=-1 || document.location.href.indexOf("80.239.186.40")!=-1 || document.location.href.indexOf("eu.")!=-1 || document.location.href.indexOf("preprod")!=-1 || document.location.href.indexOf("eu.wowarmory.com")!=-1) //Checking for Europe settings
    region="EU"
else if(document.location.href.indexOf("armory.worldofwarcraft.co.kr")!=-1 || document.location.href.indexOf("kr.wowarmory.com")!=-1){//change by akim (add KR)
    region="KR";
} else if(document.location.href.indexOf("armory.wowtaiwan.com.tw")!=-1 || document.location.href.indexOf("tw.wowarmory.com")!=-1){//change by akim (add KR)
    region="TW";
} else if(document.location.href.indexOf("armory.wowtaiwan.com.cn")!=-1 || document.location.href.indexOf("cn.wowarmory.com")!=-1){//change by akim (add KR)
    region="CN";
} else
    region="US"

function truncateString (theString, maxChars) {
	if (theString.length > maxChars && maxChars)
		return theString.substring(0, maxChars - 3) + "...";
	else
		return theString;
}

function sortNumberRightAs(a, b) {
a = a[0][0] + a[1];
b = b[0][0] + b[1];
return a == b ? 0 : (a < b ? -1 : 1)
}	

function selectLang(theDisplay, cookieValue) {
	document.getElementById("dropdownHiddenLang").style.display = "none";
	document.getElementById("displayLang").innerHTML = theDisplay;
	setcookie("cookieLangId", cookieValue);
	document.location.reload();
}

function selectRealm(theRealm) {
	document.getElementById("dropdownHiddenRealm").style.display = "none";
	document.getElementById("displayRealm").innerHTML = theRealm;
	document.formSearch.realm.value = theRealm;
}

 var Url = {  
   
     // public method for url encoding  
     encode : function (string) {  
         return escape(this._utf8_encode(string));  
     },  
   
     // public method for url decoding  
     decode : function (string) {  
         return this._utf8_decode(unescape(string));  
     },  
   
     // private method for UTF-8 encoding  
     _utf8_encode : function (string) {  
         string = string.replace(/\r\n/g,"\n");  
         var utftext = "";  
   
         for (var n = 0; n < string.length; n++) {  
   
             var c = string.charCodeAt(n);  
   
             if (c < 128) {  
                 utftext += String.fromCharCode(c);  
             }  
             else if((c > 127) && (c < 2048)) {  
                 utftext += String.fromCharCode((c >> 6) | 192);  
                 utftext += String.fromCharCode((c & 63) | 128);  
             }  
             else {  
                 utftext += String.fromCharCode((c >> 12) | 224);  
                 utftext += String.fromCharCode(((c >> 6) & 63) | 128);  
                 utftext += String.fromCharCode((c & 63) | 128);  
             }  
   
         }  
   
         return utftext;  
     },  
   
     // private method for UTF-8 decoding  
     _utf8_decode : function (utftext) {  
         var string = "";  
         var i = 0;  
         var c = c1 = c2 = 0;  
   
         while ( i < utftext.length ) {  
   
             c = utftext.charCodeAt(i);  
   
             if (c < 128) {  
                 string += String.fromCharCode(c);  
                 i++;  
             }  
             else if((c > 191) && (c < 224)) {  
                 c2 = utftext.charCodeAt(i+1);  
                 string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));  
                 i += 2;  
             }  
             else {  
                 c2 = utftext.charCodeAt(i+1);  
                 c3 = utftext.charCodeAt(i+2);  
                 string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));  
                 i += 3;  
             }  
   
         }  
   
         return string;  
     }  
   
 }

function getCopyUrl() {	
	if (is_ie && IS_ENABLED_XSLT) {
		theUrl = "http://";
		theUrl += window.location.hostname;
		theUrl += "./"+ window.historyStorage.getCurrentPage();
		theUrl = theUrl.replace("?#", "");
	} else {
		theUrl = location.href;
		theUrl = theUrl.replace("#", "");
	}
	document.formCopyUrl.inputCopyUrl.value = theUrl;
}

    function toggleCopyUrl() {
        if (document.getElementById("divCopyUrl").style.display == "block")
            document.getElementById("divCopyUrl").style.display = "none";
        else
            document.getElementById("divCopyUrl").style.display = "block";      
        getCopyUrl();
    }
    
function setDualTooltipCookie() {
    if (document.getElementById('checkboxDualTooltip').checked)
        setcookie("armory.cookieDualTooltip", 1);
    else
        setcookie("armory.cookieDualTooltip", 0);
}

function setCharCookie(charName, realm, guild, guildUrl, faction, race, clazz, team2, team3, team5) {
    setcookie("armory.cookieCharProfileUrl", "cmpn="+charName+"&cmpr="+realm);
    setcookie("armory.cookieCharProfileName", charName);
    setcookie("armory.cookieCharProfileRealm", realm);
    setcookie("armory.cookieCharProfileGuildName", guild);
    setcookie("armory.cookieCharProfileGuildUrl", guildUrl);    
    setcookie("armory.cookieCharProfileFaction", faction);
    setcookie("armory.cookieCharProfileTeam2", team2);
    setcookie("armory.cookieCharProfileTeam3", team3);
    setcookie("armory.cookieCharProfileTeam5", team5);
	if (!guild) {
    setcookie("armory.cookieCharProfileRace", race);
    setcookie("armory.cookieCharProfileClass", clazz);
	}
    showPin();
    document.getElementById('checkboxDualTooltip').checked = 1;
    setDualTooltipCookie();
}

function showPin() {
    document.getElementById('showHidePin').style.display = "block"; 
    
    var charName = getcookie2("armory.cookieCharProfileName")
    document.getElementById('replacePinCharName1').innerHTML = charName;
    document.getElementById('replacePinCharName2').innerHTML = "<a href = \"character-sheet.php@r="+ encodeURI(getcookie2("armory.cookieCharProfileRealm")) +"&n="+ encodeURI(getcookie2("armory.cookieCharProfileName")) +"\">"+ charName + "</a>";   

    var guildName = getcookie2("armory.cookieCharProfileGuildName");
    if (guildName != "" && guildName != ";") {
        document.getElementById('replacePinGuildName1').innerHTML = "&lt; "+ guildName +" &gt;";
        document.getElementById('replacePinGuildName2').innerHTML = "<a href = \"guild-info.php?"+ getcookie2("armory.cookieCharProfileGuildUrl") +"\">&lt; "+ guildName +" &gt;</a>";    
    } else {
		var cookieRace = getcookie2("armory.cookieCharProfileRace");
		var cookieClass = getcookie2("armory.cookieCharProfileClass");		
        document.getElementById('replacePinGuildName1').innerHTML = cookieRace +' '+ cookieClass;
        document.getElementById('replacePinGuildName2').innerHTML = '<span style = "color: #cecece">'+ cookieRace +' '+ cookieClass + '</span>';
	}

    if (getcookie2("armory.cookieCharProfileFaction") == "1")
        document.getElementById('changeClassFaction').className = "hord";
    else
        document.getElementById('changeClassFaction').className = "alli";

    var team2Url = getcookie2("armory.cookieCharProfileTeam2");
    if (team2Url != "" && team2Url != ";")
        document.getElementById('replaceTeam2').innerHTML = "<a class='at2' href=\"team-info.php?"+ team2Url +"\"></a>";
    else
        document.getElementById('replaceTeam2').innerHTML = "<span class='at20'></span>";
    
    var team3Url = getcookie2("armory.cookieCharProfileTeam3");
    if (team3Url != "" && team3Url != ";")
        document.getElementById('replaceTeam3').innerHTML = "<a class='at3' href=\"team-info.php?"+ team3Url +"\"></a>";
    else
        document.getElementById('replaceTeam3').innerHTML = "<span class='at30'></span>";

    var team5Url = getcookie2("armory.cookieCharProfileTeam5"); 
    if (team5Url != "" && team5Url != ";")
        document.getElementById('replaceTeam5').innerHTML = "<a class='at5' href=\"team-info.php?"+ team5Url +"\"></a>";
    else
        document.getElementById('replaceTeam5').innerHTML = "<span class='at50'></span>";   

	document.getElementById('idPinNavArrow').className = "pdown";

}

function showPin2(profileName) {

	document.getElementById('pinprofile').style.visibility = 'hidden';	
	document.getElementById('idPinNavArrow').className = "pdown0";
    document.getElementById('replaceTeam2').innerHTML = "<span class='at20'></span>";	
    document.getElementById('replaceTeam3').innerHTML = "<span class='at30'></span>";	
    document.getElementById('replaceTeam5').innerHTML = "<span class='at50'></span>";	

	document.getElementById('changeClassFaction').className = "non";
	document.getElementById('replacePinCharName1').innerHTML = profileName;
    document.getElementById('replacePinCharName2').innerHTML = "<a>"+ profileName +"</a>";   	
	
	document.getElementById('replacePinGuildName1').innerHTML = "&lt; "+ textInformation +" &gt;";
	document.getElementById('replacePinGuildName2').innerHTML = "<a href = 'index.php?searchType=login' onMouseOver = \"javascript: showTip(textInformationHover);\" onMouseOut = 'hideTip();'>&lt; "+ textInformation +" &gt;</a>";
	
}

function hidePin(showRegistration) {

	document.getElementById('pinprofile').style.visibility = 'hidden';	
	document.getElementById('idPinNavArrow').className = "pdown0";
    document.getElementById('replaceTeam2').innerHTML = "<span class='at20'></span>";	
    document.getElementById('replaceTeam3').innerHTML = "<span class='at30'></span>";	
    document.getElementById('replaceTeam5').innerHTML = "<span class='at50'></span>";		

    document.getElementById('changeClassFaction').className = "non";

    if (!window.theCharUrl) {
    	document.getElementById('replacePinCharName1').innerHTML = textNone;
    	document.getElementById('replacePinCharName2').innerHTML = "<a>"+ textNone +"</a>";   	
		if (showRegistration == 1){
			document.getElementById('replacePinGuildName1').innerHTML = "&lt; "+ textLearnMore +" &gt;";
			document.getElementById('replacePinGuildName2').innerHTML = "<a href = '"+ registrationLink +"' onMouseOver = \"javascript: showTip(textLearnMoreHover);\" onMouseOut = 'hideTip();'>&lt; "+ textLearnMore +" &gt;</a>";
		} else {
			document.getElementById('replacePinGuildName1').innerHTML = "&lt; "+ textCannotRegister +" &gt;";
			document.getElementById('replacePinGuildName2').innerHTML = "<a href = '#' onMouseOver = \"javascript: showTip(textCannotRegisterHover);\" onMouseOut = 'hideTip();'>&lt; "+ textCannotRegister +" &gt;</a>";
		}
	} else {
		setPinThisChar();
	}

}

function setPinThisChar() {
	
	if (is_moz) 
	   var thePosition = "1";
	else
	   var thePosition = "-1";	
	
	document.getElementById('replacePinCharName1').innerHTML = "";
    document.getElementById('replacePinCharName2').innerHTML = "";
	
	document.getElementById('replacePinGuildName1').innerHTML = "";
	document.getElementById('replacePinGuildName2').innerHTML = "<a href=\"javascript: ajaxPinChar('character-sheet.php?', theCharUrl);\" style = 'font-weight: bold; top: "+ thePosition +"px; position: relative;'>"+ tClickPinBreak +"</a>";
}


function hoverPinOption() {
	  if (getcookie2("armory.cookieCharProfileUrl") !=0) {
		  document.getElementById('pinprofile').style.visibility = 'visible';
	  }
}

function unsetCharCookie() {
    setcookie("armory.cookieCharProfileUrl", 0);
    setcookie("armory.cookieDualTooltip", 0);	
    hidePin();
}

function addEvent(obj, evType, fn) {
    
    if (obj.addEventListener) {

        obj.addEventListener(evType, fn, false);
        return true;
    } else if (obj.attachEvent) {

        var r = obj.attachEvent("on"+evType, fn);
        return r;
    } else {

        return false;
    }
}

function dropdownMenuToggle(whichOne){
    theStyle = document.getElementById(whichOne).style;

    if (theStyle.display == "none") {
        theStyle.display = "block"; 
    } else
        theStyle.display = "none";
}


//flash detection
var MM_contentVersion = 8;
var plugin = (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) ? navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin : 0;
if ( plugin ) {
        var words = navigator.plugins["Shockwave Flash"].description.split(" ");
		var wordsLength = words.length;
        for (var i = 0; i < wordsLength; ++i)
        {
        if (isNaN(parseInt(words[i])))
        continue;
        var MM_PluginVersion = words[i]; 
        }
    var MM_FlashCanPlay = MM_PluginVersion >= MM_contentVersion;
}
else if (navigator.userAgent && navigator.userAgent.indexOf("MSIE")>=0 
   && (navigator.appVersion.indexOf("Win") != -1)) {
    document.write('<SCR' + 'IPT LANGUAGE=VBScript\> \n'); //FS hide this from IE4.5 Mac by splitting the tag
    document.write('on error resume next \n');
    document.write('MM_FlashCanPlay = ( IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash." & MM_contentVersion)))\n');
    document.write('</SCR' + 'IPT\> \n');
}


function showNoflashMessage(){
    document.getElementById("noflash-message").style.display="block";
}
    
var flashString;
var tempObj;
var flashCount=1;
//printFlash uses innerHTML to render flash objs to get around the IE flash rendering issue
function printFlash(id, src, wmode, menu, bgcolor, width, height, quality, base, flashvars, noflash){
    
    if(MM_FlashCanPlay){
        
        flashString = '<object id= "' + id + 'Flash" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' + width + '" height="' + height + '"><param name="movie" value="' + src + '"></param><param name="quality" value="' + quality + '"></param>';
        if(base){
        flashString+='<param name="base" value="' + base + '"/>';
        }
        
        flashString+='<param name="flashvars" value="' + flashvars + '" ></param><param name="bgcolor" value="' + bgcolor + '" ></param><param name="menu" value="' + menu + '" ></param><param name="wmode" value="' + wmode + '" ></param><param name="salign" value="tl" ></param><embed name= "' + id + 'Flash" src="' + src + '" wmode="' + wmode + '" menu="' + menu + '" bgcolor="' + bgcolor + '" width="' + width + '" height="' + height + '" quality="' + quality + '" pluginspage="http://www.macromedia.com/go/getflas/new-hplayer" type="application/x-shockwave-flash" salign="tl" base="' + base + '" flashvars="' + flashvars + '" /></object>';
        
    }else{
    
        flashString=noflash;

    }
    
    if(id=="loader" && !is_moz)
        flashString=noflash;
    document.getElementById(id).innerHTML = flashString;
    document.getElementById(id).style.display="block";
        
}



//Begin Martin's Tooltip Code
mouseY = false;
windowWidth = false;
isShowing = false;
visibilityOverride = false;
var defaultWidth=300;

function showTip(toolTipContent,defaultWidthOverride) {

	windowHeight = elemDoc.clientHeight;
	windowWidth = elemDoc.clientWidth;
	
  elemtb1.innerHTML = toolTipContent;
  elemttc.style.display = "block";

	if(elemt1c.offsetWidth > 299) {
		elemt1c.style.width="300px";
	}
	//if(is_ie || _SARISSA_IS_SAFARI || window.opera) elemttc.style.width = "300px";

	if (!visibilityOverride) elemttc.style.visibility = "visible";
	//adjustTooltipPosition();
	isShowing = true;
}

function adjustTooltipPosition() {
	if(!mouseY) return false;
	else
	{
		var varYoffset = window.pageYOffset;
		var ttipOvershoot = (!is_safari) ? elemttc.offsetHeight + mouseY + 10 : elemttc.offsetHeight + mouseY + 10 - varYoffset;
		var ttipSideOvershoot = elemttc.offsetWidth + mouseX + 10;
		if(ttipOvershoot > windowHeight) {
			elemttc.style.top = (!is_safari) ? windowHeight - elemttc.offsetHeight + elemDoc.scrollTop + 2 + "px" : windowHeight - elemttc.offsetHeight + varYoffset + "px";
		} else {
			elemttc.style.top = (!is_safari) ? mouseY+10+elemDoc.scrollTop+"px" : mouseY+5+"px";
		}
		if(ttipSideOvershoot > windowWidth) {
			elemttc.style.left = windowWidth - elemttc.offsetWidth+"px";
		} else {
			elemttc.style.left = mouseX+10+"px";
		}
	}
}

function showTipTwo(toolTipContent) {
    elemtb2.innerHTML = textCurrentlyEquipped + toolTipContent;
    elemt2c.style.display = "block";
		if(elemt2c.offsetWidth > 299) {
			elemt2c.style.width="300px";
		}
}

function showTipThree(toolTipContent) {
    elemtb3.innerHTML = textCurrentlyEquipped + toolTipContent;
    elemt3c.style.display = "block";
		if(elemt3c.offsetWidth > 299) {
			elemt3c.style.width="300px";
		}
}

function emergencyPurge() {
	elemt1c.style.width = "auto";
	elemt2c.style.width = "auto";	
}

function hideTip() {
		isShowing = false;	
		elemttc.style.display = "none";
		elemt1c.style.width = "auto";
		elemt2c.style.display = "none";
		elemt3c.style.display = "none";
		elemttc.style.width = "auto";		
}

function tipPosition(callingEvent) {
	if (!callingEvent) callingEvent = window.event;
  mouseX = callingEvent.clientX;
  mouseY = callingEvent.clientY-1;
  
	if (isShowing) {
		var ttipSideOvershoot = elemttc.offsetWidth + mouseX + 10;
		var varYoffset = window.pageYOffset;
		var ttipOvershoot = (!is_safari) ? elemttc.offsetHeight + mouseY + 10 : elemttc.offsetHeight + mouseY + 10 - varYoffset;
		if(ttipOvershoot > windowHeight) {
				elemttc.style.top = (!is_safari && !is_chrome) ? windowHeight - elemttc.offsetHeight + elemDoc.scrollTop + 2 + "px" : windowHeight - elemttc.offsetHeight + varYoffset + "px";
		} else {
				elemttc.style.top = (!is_safari) ? mouseY+10+elemDoc.scrollTop+"px" : mouseY+5+"px";
				if(is_chrome) elemttc.style.top = varYoffset + mouseY + "px";
		}
		if(ttipSideOvershoot > windowWidth) {
				elemttc.style.left = mouseX-elemttc.offsetWidth-20+"px";
				//elemttc.style.left = windowWidth - elemttc.offsetWidth +"px";
		} else {
				elemttc.style.left = mouseX+20+"px";
		}
	}


}
document.onmousemove = tipPosition;

//End Martin's Tooltip Code


var resultsSideState="middle";

function resultsSideRight(){
    if(resultsSideState=="middle"){
        document.getElementById("results-side-switch").className = "results-side-collapsed";
        resultsSideState="right";
    }
}

function resultsSideLeft(redirectUrl){
    if(resultsSideState=="right"){
        document.getElementById("results-side-switch").className = "results-side-expanded";
        resultsSideState="middle";
    } else {
        if (redirectUrl) {
			window.location.href = redirectUrl;
        }
    }
}



function thisMovie(movieName) {
  // IE and Netscape refer to the movie object differently.
  // This function returns the appropriate syntax depending on the browser.
  if (navigator.appName.indexOf ("Microsoft") !=-1) {
    return window[movieName]
  } else {
    return document[movieName]
  }
}

function popIconLarge(movieName,mcName) {
    if(MM_FlashCanPlay){
        try {
            if(is_ie)
                try {thisMovie(movieName).TGotoFrame(mcName,1);}catch(e){throw e;}
            else if(!is_opera && thisMovie(movieName) && thisMovie(movieName).TGotoFrame) //exclude opera
                    thisMovie(movieName).TGotoFrame(mcName,1);
        }catch(e){
            throw e;
        }
    }  
}

function popIconSmall(movieName,mcName) {
    if(MM_FlashCanPlay){
        try {
            if(is_ie)
                try {thisMovie(movieName).TGotoFrame(mcName,2);}catch(e){throw e;}
            else
                if(!is_opera && thisMovie(movieName) && thisMovie(movieName).TGotoFrame) //exclude opera
                    thisMovie(movieName).TGotoFrame(mcName,2);
        }catch(e){
            throw e;
        }
    }
}

var prevRightSideImage;
var rightSideImage;
var rightSideImageReady=0;

function changeRightSideImage(theImage){
    if(rightSideImageReady){
        if(rightSideImage!=prevRightSideImage){
            document.getElementById('imageLeft').className = theImage+'-image';
            document.getElementById('imageRight').className = 'section-'+theImage;
        }
        prevRightSideImage=rightSideImage;
    }
}

var pageChangerXsltProcessor;

function initXsltProcessor(xsltProc, xslUrl) {
    var xslDoc = Sarissa.getDomDocument();
    xslDoc.async = true;
    if(is_ie)
        xslDoc.async = false;
    xslDoc.load(xslUrl);
    xsltProc.importStylesheet(xslDoc);
}


function xmlDataLoadSarissa(xmlSource, xslSource, container){

    pageChangerXsltProcessor = new XSLTProcessor();
    initXsltProcessor(pageChangerXsltProcessor, xslSource);
    
    //code added to apend the language of the xml request.  Use to fight rouge caching.
    if(xmlSource.indexOf('?')==-1)
        xmlSource+='?';
    
    xmlSource+="&lang="+getcookie2("cookieLangId");
    
    fetchXmlData(xmlSource, container, pageChangerXsltProcessor);
    //move the search box if it's the index
    var urlSplit = xmlSource.split('?');
    var xmlName = urlSplit[0].split('.')[0];    
    if(xmlName.indexOf("index")>-1 && !document.location.hash)
        document.getElementById('indexChange1').className="home";
    else
        document.getElementById('indexChange1').className="other";
}

var ajaxOverride=false;

function initialize() {
	/*
	dhtmlHistory.initialize();
   dhtmlHistory.addListener(historyChange);
	*/
/*
        // initialize the DHTML History      
        var urlObj=parseXMLurl(document.location.href);
        if(!pathnameParse || pathnameParse=="?"){
            dhtmlHistory.initialize();

            // subscribe to DHTML history change
            // events
            dhtmlHistory.addListener(historyChange);

            // if this is the first time we have
            // loaded the page...

            if(!dhtmlHistory.isFirstLoad()){
                //do nothing
            }else{ 
              // start adding history
                var initKey = document.location.href;
                if(initKey.lastIndexOf('/')!=initKey.length-1 && initKey.lastIndexOf('?')!=initKey.length-1){
                
                    initKey = initKey.substring(initKey.lastIndexOf('/'),initKey.length)
                    initKey = initKey.split('?')[0];
                }else
                    initKey = "index.xml";
				addHistory(initKey)
            }
        }else{
            ajaxOverride=true;
            window.historyStorage.setCurrentPage(urlObj.escapeUrl);
        }*/
      }
      /** Our callback to receive history change
          events. */
    var historyChangeBool=0;

    function historyChange(newLocation) {
		/*
	if (right == 0)
		window.location.href = "./" + newLocation;
		*/

        if((!historyChangeBool && window.historyStorage.getCurrentPage() == parseXMLurl(document.location.href).escapeUrl) || (!document.location.hash && historyChangeBool==1) || (window.historyStorage.getCurrentPage()=="index.php")){
            //DO NOTHING
        }else{     
            if(!newLocation)
                newLocation=window.historyStorage.getCurrentPage();
            var urlObj=parseXMLurl(newLocation);
            window.historyStorage.setCurrentPage(urlObj.url);
            xmlDataLoadSarissa(newLocation,urlObj.xsl,'dataElement')
        }
    }

function parseXMLurl(xmlUrl, xslUrl, escapeBool){

    if(xmlUrl.lastIndexOf('/')>=0)
        xmlUrl=xmlUrl.substring(xmlUrl.lastIndexOf('/')+1,xmlUrl.length)
    var urlSplit = xmlUrl.split('?');
    xmlUrl = urlSplit[0];
    xml=xmlUrl;

    if (xslUrl) {
        xsl = xslUrl;
    } else {
        xsl = 'layout/' + xml.split('.')[0] + '-ajax.xsl';
    }
    query = urlSplit[1];
    
    var pageObject = new Object();
    pageObject.xml = xml;
    pageObject.xsl = xsl;
    pageObject.query=query;
    pageObject.url = xml;
    if(query)pageObject.url+="?"+query;
    
    pageObject.escapeUrl=xml;
    pageObject.escapeQuery="";

    if (query){
        
            var queryConstructor = new PageQuery("?"+query);
            var queryParams = queryConstructor.getParameters();
        	var queryParamsLength = queryParams.length;
            for(i=0; i<queryParamsLength; i++){
				if(is_ie || escapeBool || is_opera)
					pageObject.escapeQuery +=  queryParams[i] + "=" + encodeURI(Utf8.decode(queryConstructor.getValue(queryParams[i])));
				else{
					pageObject.escapeQuery +=  queryParams[i] + "=" + encodeURI(queryConstructor.getValue(queryParams[i]));//alert(pageObject.escapeQuery);
				}
				/*
    			if(region == 'KR'){
					var krValue = queryConstructor.getValue(queryParams[i]);

					if(is_ie || escapeBool)
						pageObject.escapeQuery = pageObject.escapeQuery.replace(queryParams[i] + "=" + escape(krValue), queryParams[i] + "=" + escape(krValue));
					else
						pageObject.escapeQuery = pageObject.escapeQuery.replace(queryParams[i] + "=" + escape(Utf8.encode(krValue)), queryParams[i] + "=" + encodeURI(krValue));
				}
				*/
                if(i!=queryParams.length-1)
                    pageObject.escapeQuery += "&";
        
            }
			pageObject.escapeQuery = pageObject.escapeQuery.replace("'","%27");//escape single quote
			pageObject.escapeQuery = pageObject.escapeQuery.replace("%25","%");
            pageObject.escapeQuery = pageObject.escapeQuery.replace("%20","+");
        	pageObject.escapeUrl += "?" + pageObject.escapeQuery;
    }
    return pageObject;  
}

//initialize current page cookie and call DHTML init on page load
/*if(IS_ENABLED_XSLT){
    
	if(!hashParse){
		var urlObj=parseXMLurl(document.location.href);
		setcookie("currentPage",urlObj.escapeUrl,"session");
	}
	addEvent(window, 'load', initialize);
}*/

//function which takes xml, xsl, and query params and transforms them into a format the dhtml history library can understand    
function addHistory(url){
    
    dhtmlHistory.add(url,"a");
    window.historyStorage.setCurrentPage(url);
}

function ajaxLink(xmlUrl, xslUrl, appendRandomNumber){

	if (is_safari && region == "TW") {
		theUrl = xmlUrl;
		theUrl = encodeURI(theUrl);		
	    window.location.href = theUrl;				
	} else if (!is_moz && region == "TW") {
		theUrl = Url.decode(xmlUrl);
		theUrl = encodeURI(theUrl);
	    window.location.href = theUrl;				
	} else if (is_safari && region == "KR") {
		theUrl = xmlUrl;
		theUrl = encodeURI(theUrl);		
	    window.location.href = theUrl;				
	} else if (!is_moz && region == "KR") {
		theUrl = Url.decode(xmlUrl);
		theUrl = encodeURI(theUrl);
	    window.location.href = theUrl;				
		/*
	} else if (is_ie && region == "KR") {
		theUrl = Url.decode(xmlUrl);
		theUrl = encodeURI(theUrl);
	    window.location.href = theUrl;				
		*/
	} else
	    window.location.href = xmlUrl;			
}

var ajaxXmlUrl;
var ajaxDataElementName;
var ajaxXsltProcessor;

function fetchXmlData(xmlUrl, dataElementName, xsltProcessor) {
    historyChangeBool=1;
    ajaxXmlUrl = xmlUrl;
    ajaxDataElementName = dataElementName;
    ajaxXsltProcessor = xsltProcessor;
    showLoader();
    window.setTimeout("fetchXmlData2()",50);
}

function fetchXmlData2() {
//   window.location.replace(ajaxXmlUrl);
    if (!IS_ENABLED_XSLT) {
        window.location.replace(ajaxXmlUrl);
		showLoader();
        return;
    }
	isItems = 0;
	isArenaTeams = 0;
    updateDataContent(ajaxXmlUrl, document.getElementById(ajaxDataElementName), ajaxXsltProcessor);

}

function ieFix(){
    var tempDiv = document.createElement("div");
    tempDiv.style.position="absolute";
    tempDiv.style.top="-100px";
    document.body.appendChild(tempDiv);
}

var head;
var numHeadNodes=0;

function initHead(){
    head = document.getElementsByTagName("head");
    numHeadNodes = head[0].childNodes.length;
}
addEvent(window, 'load', initHead);

var jsLoaded=true;
var jsLoadCount=1;
var tempString;
var jsArrayLength;

function checkJSLoad(){
    while(jsLoadCount<jsArrayLength && jsLoaded){
        scriptString=tempArray[jsLoadCount].split('</SCRIPT>')[0];
        theSrc="";
        theScript="";
        srcStartLoc=scriptString.substring(0,6).indexOf(" src=");//look for a src attribute in the script tag within the first 7 characters
        scriptTagEndLoc=scriptString.indexOf(" type=text/javascript>");

        if(srcStartLoc!=-1)
            theSrc=scriptString.substring(srcStartLoc+6,scriptTagEndLoc-1)
    
        theScript=scriptString.substring(scriptTagEndLoc+22,scriptString.length);
        
        script = document.createElement("script");
        head[0].appendChild(script);
        
        if(theSrc)jsLoaded=false;
        
        script.type = "text/javascript";
        if(theSrc)script.src = theSrc;
        if(theScript)script.text = theScript;
        
        jsLoadCount++;
        
        if(theSrc)
            return false;
    
    }
                    
    if(jsLoadCount>=jsArrayLength){
        jsLoaded=true;
        jsLoadCount=1;
        hideLoader();
        rePosition(); //reposition menu after contents change           
        clearInterval(checkLoadInterval)
    }

}

var checkLoadInterval;

function updateDataContent(sFromUrl, oTargetElement, xsltproc) {
    try {
        if(!loadingObj || loadingObj.style.display=="none"){
            showLoader();
        }
        oTargetElement.style.cursor = "wait";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", sFromUrl, true);
        function sarissa_dhtml_loadHandler() {
            if (xmlhttp.readyState == 4) {
                oTargetElement.style.cursor = "auto";
                if (xmlhttp.responseXML != null) {
                    var procer = xsltproc;
                    if(is_ie){
                        //purge any scripts that have been loaded into Head via ajax
                        while(numHeadNodes!=head[0].childNodes.length)
                            head[0].removeChild(head[0].lastChild)
                    }                   
                    
                    var newFrag = procer.transformToFragment(xmlhttp.responseXML,window.document);
                    oTargetElement.innerHTML="";
                    oTargetElement.appendChild(newFrag);
                    if(is_ie){
                        //load any new embedded stylesheets into head
                        embeddedStyles=oTargetElement.getElementsByTagName("link");
						embeddedStylesLength = embeddedStyles.length;
                        for(count=0;count<embeddedStylesLength;count++){
                                embeddedStyle = document.createElement("link");
                                head[0].appendChild(embeddedStyle);
                                embeddedStyle.type = embeddedStyles[count].type
                                embeddedStyle.rel = embeddedStyles[count].rel;
                                embeddedStyle.href = embeddedStyles[count].href;
                                embeddedStyle.media = embeddedStyles[count].media;
                        }
                        
                        tempString=document.getElementById("dataElement").innerHTML;
                        tempArray=tempString.split('<SCRIPT');
                        jsArrayLength=tempArray.length;
                                        
                        window.setTimeout("ieFix()",100)
                        checkLoadInterval=window.setInterval("checkJSLoad()",100)
                    } else {
                    
                        hideLoader();
                        rePosition(); //reposition menu after contents change
                    }
                } else {
                    //xml load failed. May want to add code here to remove latest history change.
                    hideLoader();
                }
            }
        }
        xmlhttp.onreadystatechange = sarissa_dhtml_loadHandler;
        xmlhttp.send(null);
        oTargetElement.style.cursor = "auto";
    } catch(e) {
        oTargetElement.style.cursor = "auto";
        throw e;
    }
}

var loadingObj;
function showLoader() {
}

function hideLoader(){
    loadingObj.style.visibility="hidden";
    loadingObj.style.height="0px";
    var dataElementObj = document.getElementById("dataElement"); 
}

function arenaLadderLink(battlegroup, teamSize) {
    var URL_XML = "arena-ladder.xml";
    var URL_BATTLEGROUP_SELECT = "battlegroups.xml";
    var XSL_URL_BATTLEGROUP_SELECT = "layout/battlegroups-ajax.xsl";
    var URL_TEAMSIZE_SELECT = "select-team-type.xml";

    var selectedBG;
    if (battlegroup) {
        selectedBG = battlegroup;
        setcookie("armory.cookieBG", battlegroup);
    } else {
        selectedBG = getcookie2("armory.cookieBG");
    }

    var selectedTS;
    if (teamSize) {
        selectedTS = teamSize;
        setcookie("armory.cookieTS", teamSize);
    } else {
        selectedTS = getcookie2("armory.cookieTS");
    }

    if (!selectedBG) {
 		window.location.href = URL_BATTLEGROUP_SELECT;
        return;
    }
    if (!selectedTS) {
 		window.location.href = URL_TEAMSIZE_SELECT;
        return;
    }

    var arenaLadderUrl = URL_XML + "@b=" + escape(selectedBG) + "&ts=" + selectedTS;

    if(region == "KR"){//change by akim (encoding UTF-8)
		selectedBG = Url.encode(selectedBG);
        arenaLadderUrl = URL_XML + "@b=" + selectedBG + "&ts=" + selectedTS;			
    } else if (region == "TW") {
		selectedBG = Url.encode(selectedBG);
        arenaLadderUrl = URL_XML + "@b=" + selectedBG + "&ts=" + selectedTS;	
	}
	window.location.href = arenaLadderUrl;
}

//Icon validity testing
function IsImageOk(img) {
    // During the onload event, IE correctly identifies any images that
    // weren't downloaded as not complete. Others should too. Gecko-based
    // browsers act like NS4 in that they report this incorrectly.
    if(!is_safari){
        if (!img || !img.complete) {
            return false;
        }
        // However, they do have two very useful properties: naturalWidth and
        // naturalHeight. These give the true size of the image. If it failed
        // to load, either of these should be zero.
        if (typeof img.naturalWidth != "undefined" && img.naturalWidth == 0) {
            return false;
        }
    }
    // No other way of checking: assume it's ok.
    return true;
}
  
function checkImage(thisImage,iconSize){
  thisImage=document.getElementById(thisImage)
  fileType=".jpg";
  if(iconSize=="21x21" || iconSize=="43x43")
    fileType=".png";

  if(!IsImageOk(thisImage))
    thisImage.src="images/icons/"+iconSize+"/inv_misc_questionmark"+fileType;
}

function replaceLink(siteUrl){
    var replaceUrl="";

    if(IS_ENABLED_XSLT)
        replaceUrl=siteUrl+"/"+window.historyStorage.getCurrentPage();
    else
        replaceUrl=document.location.href;
        
    document.getElementById("reportLink").href=document.getElementById("reportLink").href.replace("REPLACEURL",replaceUrl.replace('&','%26')).replace("REPLACEBROWSER",agt+" - "+appVer)
}

function guildLink() {
   window.location.href = guildUrl;
}

function forumLink(forumName, lang){
    var forumsUrl="";
    if(region=="EU")
        forumsUrl="../forums.wow-europe.com/default.htm";
    else if (region == "US")
        forumsUrl="../forums.worldofwarcraft.com/default.htm";
	else if (region == "TW")
        forumsUrl="../forum.wowtaiwan.com.tw/default.htm";	

    window.open(forumsUrl+"board.html@forumName="+forumName)

}

function styleLoader(cssHref){
        newStyle = document.createElement("link");
        newStyle.type = "text/css";
        newStyle.rel = "stylesheet";
        newStyle.href = cssHref;
        newStyle.media = "screen, projection";
		document.getElementsByTagName("head")[0].appendChild(newStyle);
}

//end functions section

//start searchbox

	function menuSelect(textDisplay, menuKey) {
		document.getElementById('replaceSearchOption').innerHTML = textDisplay;
		document.getElementById('searchCat').style.display='none';
		setcookie('cookieMenu', menuKey);
		setcookie('cookieMenuText', textDisplay);
		document.formSearch.searchType.value = menuKey;	
	}

function checkClear() {
	if (document.formSearch.searchQuery.value == textSearchTheArmory) {
		document.formSearch.searchQuery.value = "";
	}
}

function checkBlur() {
	if (document.formSearch.searchQuery.value == "")
		document.formSearch.searchQuery.value = textSearchTheArmory;
}

function menuCheckLength(formReference) {

	/*if (formReference.searchType.value == "all" && globalSearch == "0") {
		document.getElementById('errorSearchType').innerHTML = '<div class="error-container2"><div class="error-message" style = "position: relative; left: -400px; top: -33px; white-space: nowrap;"><p></p>'+ tScat +'</div></div>';
		return false;
	} else
		document.getElementById('errorSearchType').innerHTML = "";	*/
	
	if ((formReference.searchQuery.value).length <= 1 || formReference.searchQuery.value == textSearchTheArmory || formReference.searchQuery.value == textEnterGuildName || formReference.searchQuery.value == textEnterCharacterName || formReference.searchQuery.value == textEnterTeamName) {
		document.getElementById(formReference.name + '_errorSearchLength').innerHTML = '<div class="error-container2"><div class="error-message" style = "position: relative; left: -245px; top: -33px; white-space: nowrap;"><p></p>'+ tStwoChar +'</div></div>';
		return false;
	}
	
	
	if(IS_ENABLED_XSLT){
		var theSearch=formReference.searchQuery.value;
		if(is_ie)//escape the entry
			theSearch=Utf8.encode(theSearch)

		// MFS HACK: appending a random number to search.xml in order to avoid grabbing a cached version of the
		// search page...this really needs to be fixed on the backend
		//ajaxLink("search.xml@searchQuery="+theSearch+"&searchType="+formReference.searchType.value, null, true);
		window.location.href = "index.php?searchQuery="+theSearch+"&searchType="+formReference.searchType.value+"&realm="+formReference.realm.value;
		document.getElementById(document.formSearch.name + '_errorSearchLength').style.visibility = "hidden"; //clear the error box if it is visible
		document.formSearch.searchQuery.value=formReference.searchQuery.value;//set the main search box value to the last search
		return false;
	}else{
		//formReference.searchQuery.value=theSearch=Utf8.encode(formReference.searchQuery.value);

		formReference.submit();
		showLoader();
	}
}
//end searchbox

function funcAjaxTalents(theXml, theXsl, nonAjaxXml, theDiv) {
/*
	var jsArray = new Array();
	jsArray[0] = 'shared/global/talents/includes/variables-live.js';
	jsArray[1] = 'shared/global/talents/includes/functions.js';
	jsArray[2] = 'shared/global/talents/priest/en/data.js';
	jsArray[3] = 'shared/global/talents/priest/donotlocalize.js';
	jsArray[4] = 'shared/global/talents/includes/en/localize.js';
	jsArray[5] = 'shared/global/talents/includes/arraysFill.js';
	jsArray[6] = 'shared/global/talents/includes/printOutTop.js';	
*/	
	funcAjax(theXml, theXsl, nonAjaxXml, theDiv);
/*	if (!is_moz) {		
		variableIsSite = 0;
		query = "234324";
		
		for(var i = 0; i < jsArray.length; i++) {
		
		   node=document.createElement("script")
		   node.setAttribute("type","text/javascript")
		   node.setAttribute("src", jsArray[i])
		//   document.getElementsByTagName("HEAD")[0].appendChild(node)
		   document.getElementById('containerJavascript').appendChild(node)
		}
		document.getElementById('containerJavascript').innerHTML = "";
	}	
*/

}

function funcAjax(theXml, theXsl, nonAjaxXml, theDiv) {
	right = 0;
	nonAjaxXml = "character-sheet.php@r=Tichondrius&n=Avin";
	if (!theDiv)
		theDiv = "replaceMain";
	if(!(_SARISSA_IS_SAFARI || window.opera)) {
			ttipXsltProcessor = new XSLTProcessor();
			var xslDoc = Sarissa.getDomDocument();
			xslDoc.async = false;
			xslDoc.load(theXsl);
			ttipXsltProcessor.importStylesheet(xslDoc);         
			ttipXslProcessorIsReady = true;			
	}
	var safariXmlRequest = new XMLHttpRequest;
	function safariReadystateHandler() {
		if(safariXmlRequest.readyState == 4) {
			if(_SARISSA_IS_SAFARI || window.opera) {
				document.getElementById(theDiv).innerHTML = safariXmlRequest.responseText;
			} else {
				var newItemHtml = ttipXsltProcessor.transformToFragment(safariXmlRequest.responseXML,window.document);
				elementDiv = document.getElementById(theDiv);
				elementDiv.innerHTML = "";
				elementDiv.appendChild(newItemHtml);
				
				if (is_ie) {
					elementHead = document.getElementById('containerJavascript');					
					theInner = elementDiv.innerHTML;
					while ((blah = theInner.search("<SCRIPT")) != -1) {
						theInner = theInner.substr(blah + 7);
						indexSrc = theInner.search("src");
						indexEndTag = theInner.search("type=text/javascript>");
						if (indexSrc > indexEndTag) {
							indexEndScript = theInner.search('</SCRIPT>');
						 	node=document.createElement("script")
						  	node.setAttribute("type","text/javascript")
						  	node.setAttribute("text", theInner.substr(indexEndTag+21, indexEndScript - indexEndTag - 1-21));
							elementHead.appendChild(node);
						} else {
							indexJs = theInner.search(".js");
						 	node=document.createElement("script")
						  	node.setAttribute("type","text/javascript")
						  	node.setAttribute("src", theInner.substr(indexSrc+5, indexJs - indexSrc - 2))							
							if(theInner.substr(indexSrc+5, indexJs - indexSrc - 2))
								elementHead.appendChild(node);
						}
						blah = theInner.search("<SCRIPT");
						theInner = theInner.substr(blah);
					}
				}


/*		   node=document.createElement("script")
		   node.setAttribute("type","text/javascript")
		   node.setAttribute("text", document.getElementById(theDiv).innerHTML)
		   alert(node);
		   document.getElementById('containerJavascript').appendChild(node)*/

			}


		}
	}
	
	safariXmlRequest.onreadystatechange = safariReadystateHandler;
	safariXmlRequest.open("GET", theXml, true);
	safariXmlRequest.send(null);
	if (theXml == 'index.xml')
		changeSearchLoc(1);
	else
		changeSearchLoc();
		
	if (is_ie)
		elementHead.innerHTML = "";
		   

// dhtmlHistory.add(nonAjaxXml);

/*
xmlUrl = "character-search.xml";
xslUrl = theXsl;
    var urlObj=parseXMLurl(xmlUrl, xslUrl);
    
    if (IS_ENABLED_XSLT && !ajaxOverride){
		addHistory(urlObj.escapeUrl);
		document.getElementById(document.formSearch.name + '_errorSearchLength').style.visibility = "hidden"; //clear the error box if it is visible
		showLoader();
		if (appendRandomNumber) {
			xmlDataLoadSarissa(urlObj.escapeUrl + "&amp;rid=" + Math.floor(Math.random()*2147483647), urlObj.xsl, 'dataElement');
		} else {
			xmlDataLoadSarissa(urlObj.escapeUrl, urlObj.xsl, 'dataElement');
		}
	} else if (IS_ENABLED_XSLT && ajaxOverride) {	
		var hashControl="#"
		if(is_ie)
			hashControl="?"+hashControl;
	
		window.location.hash=urlObj.escapeUrl;
		showLoader();
	
	}else{

		//alert(urlObj.escapeUrl + " - " + urlObj.url)
		window.location.href=urlObj.escapeUrl;
		showLoader();

    }
    
*/
}

function changeSearchLoc(theFlag) {
	if (theFlag) {
		document.getElementById('divChains').className="top-anchor";
		document.getElementById('indexChange1').className="home";			
	} else {
		document.getElementById('divChains').className="top-anchor-int";
		document.getElementById('indexChange1').className="other";		
	}	
}


// Guild Banks login window

function displayNone(whichBlock) {
	document.getElementById(whichBlock).style.display='none';
}

function changeBlock(whichBlock) {
	document.getElementById(whichBlock).style.display='block';
}

	function getArenaIconBorder(teamSize, whichBadge) {
			var theIcon;		
			var theRank;
			var theIconDivId;
		if (teamSize > 5) {
			theRank = teamSize;
			theIconDivId = "iconPropassteam";
		} else if (arenaTeamArray[teamSize]) {
			theRank = arenaTeamArray[teamSize][2];
			theIconDivId = "icon"+ teamSize +"v"+ teamSize +"team";						
		} else {
			return false;
		}

			if (!theRank || theRank > 1000) {
				theIcon = "parchment";
				theIconImage = "arena-6";
			} else if (theRank > 500) {
				theIcon = "bronze";
				theIconImage = "arena-5";
			} else if (theRank > 100) {
				theIcon = "bronze-large";
				theIconImage = "arena-4";
			} else if (theRank > 10) {
				theIcon = "silver"
				theIconImage = "arena-3";
			} else if (theRank > 1) {
				theIcon = "gold";		
				theIconImage = "arena-2";
			} else if (theRank == 1) {
				theIcon = "gold-large";
				theIconImage = "arena-1";
			} else {
				theIcon = "parchment";
				theIconImage = "arena-6";
			}

			document.getElementById(whichBadge).src = "images/badge-border-pvp-"+ theIcon +".gif";
			document.getElementById(theIconDivId).style.backgroundImage = "url('images/icons/badges/arena/"+ theIconImage +".jpg')"

	}
function getArenaIcon(theRank, teamType) {
	if (!theRank || theRank > 1000) {
		theIcon = "parchment";
		theIconImage = "arena-6";
	} else if (theRank > 500) {
		theIcon = "bronze";
		theIconImage = "arena-5";
	} else if (theRank > 100) {
		theIcon = "bronze-large";
		theIconImage = "arena-4";
	} else if (theRank > 10) {
		theIcon = "silver"
		theIconImage = "arena-3";
	} else if (theRank > 1) {
		theIcon = "gold";
		theIconImage = "arena-2";
	} else if (theRank == 1) {
		theIcon = "gold-large";
		theIconImage = "arena-1";
	} else {
		theIcon = "parchment";
		theIconImage = "arena-6";
	}
	
	document.getElementById('badgeBorder'+teamType+'v'+teamType+'team').src = "images/badge-border-arena-"+ theIcon +".gif";
	document.getElementById('icon'+teamType+'v'+teamType+'team').style.backgroundImage = "url('images/icons/badges/arena/"+ theIconImage +".jpg')";
}

function goToPropass() {
	if (getcookie2("armory.cookiePropassBG"))
		document.location.href = "arena-ladder.xml@b="+encodeURI(getcookie2("armory.cookiePropassBG")) + "&ts=3";
	else
		document.location.href = "battlegroups.xml#tournament";
}