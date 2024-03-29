﻿if(IS_ENABLED_XSLT){
	/** 
	   Copyright (c) 2005, Brad Neuberg, bkn3@columbia.edu
	   http://codinginparadise.org
	   
	   Permission is hereby granted, free of charge, to any person obtaining 
	   a copy of this software and associated documentation files (the "Software"), 
	   to deal in the Software without restriction, including without limitation 
	   the rights to use, copy, modify, merge, publish, distribute, sublicense, 
	   and/or sell copies of the Software, and to permit persons to whom the 
	   Software is furnished to do so, subject to the following conditions:
	   
	   The above copyright notice and this permission notice shall be 
	   included in all copies or substantial portions of the Software.
	   
	   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, 
	   EXPResS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIes 
	   OF MERCHANTABILITY, FITNesS FOR A PARTICULAR PURPOSE AND NONINfrINGEMENT. 
	   IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY 
	   CLAIM, DAMAGes OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT 
	   OR OTHERWISE, ARISING frOM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR 
	   THE usE OR OTHER DEALINGS IN THE SOFTWARE.
	   
	   The JSON class near the end of this file is
	   Copyright 2005, JSON.org
	*/
	
	/** An object that provides DHTML history, history data, and bookmarking 
	    for AJAX applications. */
	window.dhtmlHistory = {
	   /** Initializes our DHTML history. You should
	       call this after the page is finished loading. */
	   /** public */ initialize: function() {
	      // only Internet Explorer needs to be explicitly initialized;
	      // other browsers don't have its particular behaviors.
	      // Basicly, IE doesn't autofill form data until the page
	      // is finished loading, which means historyStorage won't
	      // work until onload has been fired.
	      if (this.isInternetExplorer() == false) {
	         return;
	      }
	         
	      // if this is the first time this page has loaded...
		  //alert("DhtmlHistory_pageLoaded = " + historyStorage.hasKey("DhtmlHistory_pageLoaded") + " hash = " + document.location.hash + " document.location.search - " + document.location.search + " document.location.search.indexOf('#') - " + document.location.search.indexOf("#"))
	      if ((historyStorage.hasKey("DhtmlHistory_pageLoaded") == false && document.location.hash=="") || (document.location.search && document.location.search.indexOf("#")>-1)) {
	         //alert("firstLoad")
			 this.fireOnNewListener = false;
			 //alert("fireOnNewListener - " + this.fireOnNewListener)
	         this.firstLoad = true;
	         historyStorage.put("DhtmlHistory_pageLoaded", true);
	      }
	      // else if this is a fake onload event
	      else {
	         
			 this.fireOnNewListener = true;
			 //alert("fireOnNewListener - " + this.fireOnNewListener)
	         this.firstLoad = false;   
	      }
		  /*
		  alert(document.location.hash)
		  //alert(document.getElementById("historyStorageField").value)
			if(!queryHashEqual()){
			   alert("hide")
			   document.getElementById("dataElement").style.visibility="hidden";	  
		  	}
		  */
	   },
	             
	   /** Adds a history change listener. Note that
	       only one listener is supported at this
	       time. */
	   /** public */ addListener: function(callback) {
	      this.listener = callback;
	      
	      // if the page was just loaded and we
	      // should not ignore it, fire an event
	      // to our new listener now
		  //alert("fireOnNewListener - " + this.fireOnNewListener);
	      if (this.fireOnNewListener == true) {
		  	 
	         //code added by Mike to account for IE6 case where currentLocation is NULL
			 if(!this.currentLocation)this.currentLocation=window.historyStorage.getCurrentPage()
			 
			 //alert("addlistener fireHistoryEvent - " + this.currentLocation);
			 
			 this.fireHistoryEvent(this.currentLocation);
	         this.fireOnNewListener = false;
	      }
	   },
	   
	   /** public */ add: function(newLocation, historyData) {
	      // most browsers require that we wait a certain amount of time before changing the
	      // location, such as 200 milliseconds; rather than forcing external callers to use
	      // window.setTimeout to account for this to prevent bugs, we internally handle this
	      // detail by using a 'currentWaitTime' variable and have requests wait in line
	      //alert("add - "+newLocation)
		  var self = this;
	      var addImpl = function() {
	         // indicate that the current wait time is now less
	
			 if (self.currentWaitTime > 0)
	            self.currentWaitTime = self.currentWaitTime - self.WAIT_TIME;
	            
			 //alert("1 - " + self.removeHash(newLocation))
			 newLocation=self.removeHash(newLocation);
			 //var urlObj=parseXMLurl(newLocation);
			 //alert("2 - " + urlObj.url)
			 
	         // remove any leading hash symbols on newLocation
			 //alert("newLocation - " + newLocation)
	         //alert("2 - " + newLocation)
	         // IE has a strange bug; if the newLocation
	         // is the same as _any_ preexisting id in the
	         // document, then the history action gets recorded
	         // twice; throw a programmer exception if there is
	         // an element with this ID
	         var idCheck = document.getElementById(newLocation);
			 
	         if (idCheck != undefined || idCheck != null) {
	            var message = 
	               "Exception: History locations can not have "
	               + "the same value as _any_ id's "
	               + "that might be in the document, "
	               + "due to a bug in Internet "
	               + "Explorer; please ask the "
	               + "developer to choose a history "
	               + "location that does not match "
	               + "any HTML id's in this "
	               + "document. The following ID "
	               + "is already taken and can not "
	               + "be a location: " 
	               + newLocation;
	               
	            throw message; 
	         }
	
	         // store the history data into history storage
			 //alert("put - " + newLocation + " - " + historyData)
	         historyStorage.put(newLocation, historyData);
			 //alert("past put - "+newLocation)
	         // indicate to the browser to ignore this upcomming 
	         // location change
	
	         self.ignoreLocationChange = true;
			 //alert("self.ignoreLocationChange - " + newLocation)
	 
	         // indicate to IE that this is an atomic location change
	         // block
	         this.ieAtomicLocationChange = true;
	                 
	         // save this as our current location
	         self.currentLocation = newLocation;
	         
	         // change the browser locationÐefiant Beta Testers
			 //newLocation=newLocation.replace("%D0","D")
			 
			 /*
			 if(newLocation.indexOf("%D0")>-1){
			 	//alert("replace")
				window.location.hash="guild-info.xml@r=Test+Server+%28PVE%29&n=_25D0efiant+Beta+Testers&p=1";
				//window.location.hash+="efiant+Beta+Testers&p=1"
				//newLocation="guild-info.xml@r=Test+Server+%28PVE%29&n=_25D0";
			 }else
				window.location.hash = newLocation;
			 */
			 //alert("before hash change - " + newLocation)
	
	
	         window.location.hash = newLocation;
	         //alert("after hash change - " + window.location.hash)
			 
			 //window.location.hash = escape(newLocation);
			 
			 
	         // change the hidden iframe's location if on IE
	         if (self.isInternetExplorer())
	            self.iframe.src = "blank.htm?" + newLocation;
	            
	         // end of atomic location change block
	         // for IE
	         this.ieAtomicLocationChange = false;
	      };
	
	      // now execute this add request after waiting a certain amount of time, so as to
	      // queue up requests
	      window.setTimeout(addImpl, this.currentWaitTime);
	   
	      // indicate that the next request will have to wait for awhile
	      this.currentWaitTime = this.currentWaitTime + this.WAIT_TIME;
	   },
	   
	   /** public */ isFirstLoad: function() {
	      if (this.firstLoad == true) {
	         return true;
	      }
	      else {
	         return false;
	      }
	   },
	   
	   /** public */ isInternational: function() {
	      return false;
	   },
	   
	   /** public */ getVersion: function() {
	      return "0.03";
	   },
	   
	   /** Gets the current hash value that is in the browser's
	       location bar, removing leading # symbols if they are present. */
	   /** public */ getCurrentLocation: function() {
	      //var currentLocation = this.removeHash(window.location.hash);
		  
		  if(window.location.href.indexOf('#')>-1)
		  	currentLocation = Utf8.decode(window.location.href.split('#')[1]);
		  else if (window.historyStorage.getCurrentPage()){
		  	currentLocation = Utf8.decode(window.historyStorage.getCurrentPage());
		  }else
		  	currentLocation = null;
	
		  //alert("getCurrentLocation = " + currentLocation)
		  return currentLocation;
	   },
	   
	   
	   /** Our current hash location, without the "#" symbol. */
	   /** private */ currentLocation: null,
	   
	   /** Our history change listener. */
	   /** private */ listener: null,
	   
	   /** A hidden IFrame we use in Internet Explorer to detect history
	       changes. */
	   /** private */ iframe: null,
	   
	   /** Indicates to the browser whether to ignore location changes. */
	   /** private */ ignoreLocationChange: null,
	 
	   /** The amount of time in milliseconds that we should wait between add requests. 
	       Firefox is okay with 200 ms, but Internet Explorer needs 400. */
	   /** private */ WAIT_TIME: 200,
	
	   /** The amount of time in milliseconds an add request has to wait in line before being
	       run on a window.setTimeout. */
	   /** private */ currentWaitTime: 0,
	   
	   /** A flag that indicates that we should fire a history change event
	       when we are ready, i.e. after we are initialized and
	       we have a history change listener. This is needed due to 
	       an edge case in browsers other than Internet Explorer; if
	       you leave a page entirely then return, we must fire this
	       as a history change event. Unfortunately, we have lost
	       all references to listeners from earlier, because JavaScript
	       clears out. */
	   /** private */ fireOnNewListener: null,
	   
	   /** A variable that indicates whether this is the first time
	       this page has been loaded. If you go to a web page, leave
	       it for another one, and then return, the page's onload
	       listener fires again. We need a way to differentiate
	       between the first page load and subsequent ones.
	       This variable works hand in hand with the pageLoaded
	       variable we store into historyStorage.*/
	   /** private */ firstLoad: null,
	   
	   /** A variable to handle an important edge case in Internet
	       Explorer. In IE, if a user manually types an address into
	       their browser's location bar, we must intercept this by
	       continiously checking the location bar with an timer 
	       interval. However, if we manually change the location
	       bar ourselves programmatically, when using our hidden
	       iframe, we need to ignore these changes. Unfortunately,
	       these changes are not atomic, so we surround them with
	       the variable 'ieAtomicLocationChange', that if true,
	       means we are programmatically setting the location and
	       should ignore this atomic chunked change. */
	   /** private */ ieAtomicLocationChange: null,          
	   
	   /** Creates the DHTML history infrastructure. */
	   /** private */ create: function() {
	      // get our initial location
	      var initialHash = this.getCurrentLocation();
	      
	      // save this as our current location
	      this.currentLocation = initialHash;
	      
	      // write out a hidden iframe for IE and
	      // set the amount of time to wait between add() requests
	      if (this.isInternetExplorer()) {
	         document.write("<iframe style='border: 0px; width: 1px; "
	                               + "height: 1px; position: absolute; bottom: 0px; "
	                               + "right: 0px; visibility: visible;' "
	                               + "name='DhtmlHistoryFrame' id='DhtmlHistoryFrame' "
	                               + "src='blank.htm?" + initialHash + "'>"
	                               + "</iframe>");
	         // wait 400 milliseconds between history
	         // updates on IE, versus 200 on Firefox
	         this.WAIT_TIME = 400;
	      }
	      
	      // add an unload listener for the page; this is
	      // needed for Firefox 1.5+ because this browser caches all
	      // dynamic updates to the page, which can break some of our 
	      // logic related to testing whether this is the first instance
	      // a page has loaded or whether it is being pulled from the cache
	      var self = this;
	      window.onunload = function() {
	         self.firstLoad = null;
	      };
	      
	      // determine if this is our first page load;
	      // for Internet Explorer, we do this in 
	      // this.iframeLoaded(), which is fired on
	      // page load. We do it there because
	      // we have no historyStorage at this point
	      // in IE, which only exists after the page
	      // is finished loading for that browser
	      if (this.isInternetExplorer() == false) {
	         if (historyStorage.hasKey("DhtmlHistory_pageLoaded") == false && document.location.hash=="" || (document.location.href && !document.location.hash)) {
	            
				this.ignoreLocationChange = true;
	            this.firstLoad = true;
	            historyStorage.put("DhtmlHistory_pageLoaded", true);
	         }
	         else {
	            // indicate that we want to pay attention
	            // to this location change
	            this.ignoreLocationChange = false;
	            // For browser's other than IE, fire
	            // a history change event; on IE,
	            // the event will be thrown automatically
	            // when it's hidden iframe reloads
	            // on page load.
	            // Unfortunately, we don't have any
	            // listeners yet; indicate that we want
	            // to fire an event when a listener
	            // is added.
	            this.fireOnNewListener = true;
	
	         }
	      }
	      else { // Internet Explorer
	         // the iframe will get loaded on page
	         // load, and we want to ignore this fact
	         this.ignoreLocationChange = true;
	      }
	
		//Added by Mike - Hides the initial contents of the page on reload if the hash page is different the query page
		
		//if(!queryHashEqual() && document.location.hash)
		   //document.getElementById("dataElement").style.visibility="hidden";
	      
	      if (this.isInternetExplorer()) {
	            this.iframe = document.getElementById("DhtmlHistoryFrame");
	      }                                                              
	
	      // other browsers can use a location handler that checks
	      // at regular intervals as their primary mechanism;
	      // we use it for Internet Explorer as well to handle
	      // an important edge case; see checkLocation() for
	      // details
	      var self = this;
	      var locationHandler = function() {
	         self.checkLocation();
	      };
	      //alert("startCheckLocation")
		  setInterval(locationHandler, 100);
	   },
	   
	   /** Notify the listener of new history changes. */
	   /** private */ fireHistoryEvent: function(newHash) {
	      // extract the value from our history storage for
	      // this hash
		  //alert("fireHistoryEvent - " + newHash)
	      var historyData = historyStorage.get(newHash);
	
		  //alert("fireHistoryEvent")
	      // call our listener      
	      this.listener.call(null, newHash, historyData);
	   },
	   
	   /** Sees if the browsers has changed location.  This is the primary history mechanism
	       for Firefox. For Internet Explorer, we use this to handle an important edge case:
	       if a user manually types in a new hash value into their Internet Explorer location
	       bar and press enter, we want to intercept this and notify any history listener. */
	   /** private */ checkLocation: function() {
	      // ignore any location changes that we made ourselves
	      // for browsers other than Internet Explorer
	      //alert("this.ignoreLocationChange = " + this.ignoreLocationChange)
		  if (this.isInternetExplorer() == false
	         && this.ignoreLocationChange == true) {
			 //alert("this.ignoreLocationChange = " + this.ignoreLocationChange)
	         this.ignoreLocationChange = false;
	         return;
	      }
	      
	      // if we are dealing with Internet Explorer
	      // and we are in the middle of making a location
	      // change from an iframe, ignore it
	      if (this.isInternetExplorer() == false
	          && this.ieAtomicLocationChange == true) {
	         return;
	      }
	      
	      // get hash location
	      var hash = this.getCurrentLocation();
	      
	      // see if there has been a change
		  
		  //alert(hash + " == " + this.currentLocation)
	      if (hash == this.currentLocation)
	         return;
			 
		  //alert("this.currentLocation = " + unescape(hash) + " - " + unescape(this.currentLocation) )
		  //alert("checkLocation - hash = " + hash + " this.currentLocation = " + this.currentLocation)   
	      // on Internet Explorer, we need to intercept users manually
	      // entering locations into the browser; we do this by comparing
	      // the browsers location against the iframes location; if they
	      // differ, we are dealing with a manual event and need to
	      // place it inside our history, otherwise we can return
	      this.ieAtomicLocationChange = true;
	      
		  
	      if (this.isInternetExplorer()
	          && this.getIFrameHash() != hash) {
			 //alert("checklocation hash = " + hash + " - iframe hash = " + this.getIFrameHash())
	         this.iframe.src = "blank.htm?" + hash;
	      }
	      else if (this.isInternetExplorer()) {
	         // the iframe is unchanged
	         return;
	      }
	         
	      // save this new location
	      this.currentLocation = hash;
	      
	      this.ieAtomicLocationChange = false;
	      
	      // notify listeners of the change
		  //alert("checklocation fireHistoryEvent");
	      this.fireHistoryEvent(hash);
	   },  
	
	   /** Gets the current location of the hidden IFrames
	       that is stored as history. For Internet Explorer. */
	   /** private */ getIFrameHash: function() {
	      // get the new location
	      var historyFrame = document.getElementById("DhtmlHistoryFrame");
	      var doc = historyFrame.contentWindow.document;
	      var hash = new String(doc.location.search);
	
	      if (hash.length == 1 && hash.charAt(0) == "?")
	         hash = "";
	      else if (hash.length >= 2 && hash.charAt(0) == "?")
	         hash = hash.substring(1); 
	    
	    
	      return hash;
	   },          
	   
	   /** Removes any leading hash that might be on a location. */
	   /** private */ removeHash: function(hashValue) {
	      if (hashValue == null || hashValue == undefined)
	         return null;
	      else if (hashValue == "")
	         return "";
	      else if (hashValue.length == 1 && hashValue.charAt(0) == "#")
	         return "";
	      else if (hashValue.length > 1 && hashValue.charAt(0) == "#")
	         return hashValue.substring(1);
	      else
	         return hashValue;     
	   },          
	   
	   /** For IE, says when the hidden iframe has finished loading. */
	   /** private */ iframeLoaded: function(newLocation) {
	      // ignore any location changes that we made ourselves
	      if (this.ignoreLocationChange == true) {
	         this.ignoreLocationChange = false;
	         return;
	      }
	      
	      // get the new location
	      var hash = new String(newLocation.search);
	      if (hash.length == 1 && hash.charAt(0) == "?")
	         hash = "";
	      else if (hash.length >= 2 && hash.charAt(0) == "?")
	         hash = hash.substring(1);
	      
	      // move to this location in the browser location bar
	      // if we are not dealing with a page load event
	      if (this.pageLoadEvent != true) {
	         window.location.hash = hash;
	      }
	
	      // notify listeners of the change
		  //alert("iframeloaded fireHistoryEvent")
	      this.fireHistoryEvent(hash);
	   },
	   
	   /** Determines if this is Internet Explorer. */
	   /** private */ isInternetExplorer: function() {
	      var userAgent = navigator.userAgent.toLowerCase();
	      if (document.all && userAgent.indexOf('msie')!=-1) {
	         return true;
	      }
	      else {
	         return false;
	      }
	   }
	};
	
	
	/** An object that uses a hidden form to store history state 
	    across page loads. The chief mechanism for doing so is using
	    the fact that browser's save the text in form data for the
	    life of the browser and cache, which means the text is still
	    there when the user navigates back to the page. See
	    http://codinginparadise.org/weblog/2005/08/ajax-tutorial-saving-session-across.html
	    for full details. */
	window.historyStorage = {
	   /** If true, we are debugging and show the storage textfield. */
	   /** public */ debugging: false,
	   
	   /** Our hash of key name/values. */
	   /** private */ storageHash: new Object(),
	   
	   /** If true, we have loaded our hash table out of the storage form. */
	   /** private */ hashLoaded: false, 
	   
	   /** public */ put: function(key, value) {
	       //alert("assert put - " + key)
		   this.assertValidKey(key);
	       
	       // if we already have a value for this,
	       // remove the value before adding the
	       // new one
		   //alert("after assertValid")
	       if (this.hasKey(key)) {
	         this.remove(key);
	       }
	       
	       // store this new key
	       this.storageHash[key] = value;
	       //alert("put - "+this.storageHash[key])
	       // save and serialize the hashtable into the form
	       this.saveHashTable(); 
	   },
	   
	   /** public */ get: function(key) {
	      //alert("assert get - " + Utf8.encodeCommonChars(escape(key)))
	      
		  var urlObj=parseXMLurl(key,false,true);
		  
		  this.assertValidKey(urlObj.escapeUrl);
	      
	      // make sure the hash table has been loaded
	      // from the form
	      this.loadHashTable();
	      
	      var value = this.storageHash[key];
	
		  if(value == 'a')	  
		     return key;
	      if (value == undefined)
	         return null;
	      else
	         return value; 
	   },
	   
	   /** public */ remove: function(key) {
	      //alert("assert remove - "+key);
		  this.assertValidKey(key);
	      
	      // make sure the hash table has been loaded
	      // from the form
	      this.loadHashTable();
	      
	      // delete the value
	      delete this.storageHash[key];
	      
	      // serialize and save the hash table into the 
	      // form
	      this.saveHashTable();
	   },
	   
	   /** Clears out all saved data. */
	   /** public */ reset: function() {
	      this.storageField.value = "";
		  setcookie("historyStorage","","session");
	      this.storageHash = new Object();
	   },
	   
	   /** public */ hasKey: function(key) {
	   	  //alert("assert haskey - " + key)
	      this.assertValidKey(key);
	      
	      // make sure the hash table has been loaded
	      // from the form
	      this.loadHashTable();
	      //alert("hasKey - " + this.storageHash[key])
	      if (typeof this.storageHash[key] == "undefined")
	         return false;
	      else
	         return true;
	   },
	   
	   /** Determines whether the key given is valid;
	       keys can only have letters, numbers, the dash,
	       underscore, spaces, or one of the 
	       following characters:
	       !@#$%^&*()+=:;,./?|\~{}[] */
	   /** public */ isValidKey: function(key) {
	      if (typeof key != "string")
	         key = key.toString();
	      //alert("isValid - " + key)
	      //var matcher = /^[a-zA-Z0-9_ \!\@\#\$\%\^\&\*\(\)\+\=\:\;\,\.\/\?\|\\\~\{\}\[\]]*$/;
	      //alert("isValid - " + matcher.test(key))          
	      //return true;
		  //return matcher.test(key);
		  //alert("characterCheck - " + characterCheck(key))
		  return characterCheck(key)
		  
	   },
	   
	   
	   
	   
	   /** A reference to our textarea field. */
	   /** private */ storageField: null,
	   
	   /** private */ init: function() {
	      // write a hidden form into the page
	      var styleValue = "position: absolute; top: -1000px; left: -1000px;";
	      if (this.debugging == true) {
	         styleValue = "width: 30em; height: 30em;";
	      }   
	      
	      var newContent =
	         "<form id='historyStorageForm' " 
	               + "method='GET' "
	               + "style='" + styleValue + "'>"
	            + "<textarea id='historyStorageField' "
	                      + "style='" + styleValue + "'"
	                              + "left: -1000px;' "
	                      + "name='historyStorageField'></textarea>"
	         + "</form>";
	      //document.getElementById("offscreenBuffer").innerHTML=newContent;
	      
	      this.storageField = document.getElementById("historyStorageField");
		  this.storageField.value = getcookie2("historyStorage");
		  //alert("storage - " + this.storageField.value)
	   },
	   
	   /** Asserts that a key is valid, throwing
	       an exception if it is not. */
	   /** private */ assertValidKey: function(key) {
		//alert("storageField - " + this.storageField.value)
		//alert("assertValidKey - " + key)
	      if (this.isValidKey(key) == false) {
	         throw "Please provide a valid key for "
	               + "window.historyStorage, key= "
	               + key;
	       }
	   },
	   
	   /** Loads the hash table up from the form. */
	   /** private */ loadHashTable: function() {
	      if (this.hashLoaded == false) {
	         // get the hash table as a serialized
	         // string
	         var serializedHashTable = this.storageField.value;
	         
	         if (serializedHashTable != "" && serializedHashTable != null && serializedHashTable != ';') {
	            // destringify the content back into a 
	            // real JavaScript object
	            this.storageHash = eval('(' + serializedHashTable + ')'); 
	
				 
	         }
	         //alert("serializedHashTable - " + serializedHashTable)
	         this.hashLoaded = true;
	      }
	   },
	   
	   /** Saves the hash table into the form. */
	   /** private */ saveHashTable: function() {
	      this.loadHashTable();
	      
	//Mike's Code puts a cap on the history stored in a cookie
	
			var extraKeys=0;
			var maxKeys=4;
			var totalKeys=0;
			var keyIndex=0;
	
			for (var i in this.storageHash)
			{
			  totalKeys++
			}
	
	
			if(totalKeys>maxKeys){
			
				extraKeys=totalKeys-maxKeys
					for (var i in this.storageHash)
					{
					  
					  if(keyIndex<extraKeys && keyIndex>0){
					  		//alert("save - "+i)
							this.remove(i); 
					  }
					  keyIndex++;
			
					}
				//this.loadHashTable();
			
			}
	
		 
		 
		  // serialized the hash table
	      var serializedHashTable = JSON.stringify(this.storageHash);
	      
	     	  
		  // save this value
	      this.storageField.value = serializedHashTable;
		  
		  
		  
		  //alert("cookie - " + getcookie2("historyStorage"))
		  setcookie("historyStorage",serializedHashTable,"session")
	   }, 
	   
	   /** Added by MikeH - function saves current location in a cookie. */
	   /** private */ setCurrentPage: function(url) {
	
	   		//alert("setCurrentPage = " + url)
			setcookie("currentPage",url,"session");
	   
	   },   
	   
	   /** Added by MikeH - function saves current location in a cookie. */
	   /** private */ getCurrentPage: function() {
	   		return getcookie2("currentPage");
	   
	   }   
	   
	   
	};
	
	
	
	
	
	
	
	
	
	
	/** The JSON class is copyright 2005 JSON.org. */
	Array.prototype.______array = '______array';
	
	var JSON = {
	    org: '../www.json.org/default.htm',
	    copyright: '(c)2005 JSON.org',
	    license: '../www.crockford.com/JSON/license.html',
	
	    stringify: function (arg) {
	        var c, i, l, s = '', v;
	
	        switch (typeof arg) {
	        case 'object':
	            if (arg) {
	                if (arg.______array == '______array') {
						var argLength = arg.length;
	                    for (i = 0; i < argLength; ++i) {
	                        v = this.stringify(arg[i]);
	                        if (s) {
	                            s += ',';
	                        }
	                        s += v;
	                    }
	                    return '[' + s + ']';
	                } else if (typeof arg.toString != 'undefined') {
	                    for (i in arg) {
	                        v = arg[i];
	                        if (typeof v != 'undefined' && typeof v != 'function') {
	                            v = this.stringify(v);
	                            if (s) {
	                                s += ',';
	                            }
	                            s += this.stringify(i) + ':' + v;
	                        }
	                    }
	                    return '{' + s + '}';
	                }
	            }
	            return 'null';
	        case 'number':
	            return isFinite(arg) ? String(arg) : 'null';
	        case 'string':
	            l = arg.length;
	            s = '"';
	            for (i = 0; i < l; i += 1) {
	                c = arg.charAt(i);
	                if (c >= ' ') {
	                    if (c == '\\' || c == '"') {
	                        s += '\\';
	                    }
	                    s += c;
	                } else {
	                    switch (c) {
	                        case '\b':
	                            s += '\\b';
	                            break;
	                        case '\f':
	                            s += '\\f';
	                            break;
	                        case '\n':
	                            s += '\\n';
	                            break;
	                        case '\r':
	                            s += '\\r';
	                            break;
	                        case '\t':
	                            s += '\\t';
	                            break;
	                        default:
	                            c = c.charCodeAt();
	                            s += '\\u00' + Math.floor(c / 16).toString(16) +
	                                (c % 16).toString(16);
	                    }
	                }
	            }
	            return s + '"';
	        case 'boolean':
	            return String(arg);
	        default:
	            return 'null';
	        }
	    },
	    parse: function (text) {
	        var at = 0;
	        var ch = ' ';
	
	        function error(m) {
	            throw {
	                name: 'JSONError',
	                message: m,
	                at: at - 1,
	                text: text
	            };
	        }
	
	        function next() {
	            ch = text.charAt(at);
	            at += 1;
	            return ch;
	        }
	
	        function white() {
	            while (ch != '' && ch <= ' ') {
	                next();
	            }
	        }
	
	        function str() {
	            var i, s = '', t, u;
	
	            if (ch == '"') {
	outer:          while (next()) {
	                    if (ch == '"') {
	                        next();
	                        return s;
	                    } else if (ch == '\\') {
	                        switch (next()) {
	                        case 'b':
	                            s += '\b';
	                            break;
	                        case 'f':
	                            s += '\f';
	                            break;
	                        case 'n':
	                            s += '\n';
	                            break;
	                        case 'r':
	                            s += '\r';
	                            break;
	                        case 't':
	                            s += '\t';
	                            break;
	                        case 'u':
	                            u = 0;
	                            for (i = 0; i < 4; i += 1) {
	                                t = parseInt(next(), 16);
	                                if (!isFinite(t)) {
	                                    break outer;
	                                }
	                                u = u * 16 + t;
	                            }
	                            s += String.fromCharCode(u);
	                            break;
	                        default:
	                            s += ch;
	                        }
	                    } else {
	                        s += ch;
	                    }
	                }
	            }
	            error("Bad string");
	        }
	
	        function arr() {
	            var a = [];
	
	            if (ch == '[') {
	                next();
	                white();
	                if (ch == ']') {
	                    next();
	                    return a;
	                }
	                while (ch) {
	                    a.push(val());
	                    white();
	                    if (ch == ']') {
	                        next();
	                        return a;
	                    } else if (ch != ',') {
	                        break;
	                    }
	                    next();
	                    white();
	                }
	            }
	            error("Bad array");
	        }
	
	        function obj() {
	            var k, o = {};
	
	            if (ch == '{') {
	                next();
	                white();
	                if (ch == '}') {
	                    next();
	                    return o;
	                }
	                while (ch) {
	                    k = str();
	                    white();
	                    if (ch != ':') {
	                        break;
	                    }
	                    next();
	                    o[k] = val();
	                    white();
	                    if (ch == '}') {
	                        next();
	                        return o;
	                    } else if (ch != ',') {
	                        break;
	                    }
	                    next();
	                    white();
	                }
	            }
	            error("Bad object");
	        }
	
	        function num() {
	            var n = '', v;
	            if (ch == '-') {
	                n = '-';
	                next();
	            }
	            while (ch >= '0' && ch <= '9') {
	                n += ch;
	                next();
	            }
	            if (ch == '.') {
	                n += '.';
	                while (next() && ch >= '0' && ch <= '9') {
	                    n += ch;
	                }
	            }
	            if (ch == 'e' || ch == 'E') {
	                n += 'e';
	                next();
	                if (ch == '-' || ch == '+') {
	                    n += ch;
	                    next();
	                }
	                while (ch >= '0' && ch <= '9') {
	                    n += ch;
	                    next();
	                }
	            }
	            v = +n;
	            if (!isFinite(v)) {
	                error("Bad number");
	            } else {
	                return v;
	            }
	        }
	
	        function word() {
	            switch (ch) {
	                case 't':
	                    if (next() == 'r' && next() == 'u' && next() == 'e') {
	                        next();
	                        return true;
	                    }
	                    break;
	                case 'f':
	                    if (next() == 'a' && next() == 'l' && next() == 's' &&
	                            next() == 'e') {
	                        next();
	                        return false;
	                    }
	                    break;
	                case 'n':
	                    if (next() == 'u' && next() == 'l' && next() == 'l') {
	                        next();
	                        return null;
	                    }
	                    break;
	            }
	            error("Syntax error");
	        }
	
	        function val() {
	            white();
	            switch (ch) {
	                case '{':
	                    return obj();
	                case '[':
	                    return arr();
	                case '"':
	                    return str();
	                case '-':
	                    return num();
	                default:
	                    return ch >= '0' && ch <= '9' ? num() : word();
	            }
	        }
	
	        return val();
	    }
	};
	
	//function written by MikeH to determine if the Hash is equal to the Query String
	function queryHashEqual(){
	
		if(document.location.hash.substring(1,document.location.hash.length)==document.location.search.substring(1,document.location.search.length))
			return true;
		else
			return false
	
	}
	
	//function written by Mike to check for valid character in history key.
	   /** Determines whether the key given is valid;
	       keys can only have letters, numbers, the dash,
	       underscore, spaces, or one of the 
	       following characters:
	       !@#$%^&*()+=:;,./?|\~{}[] 
		   
		   */
	function characterCheck(checkString){
						
		//alert(checkString=Utf8.encode(checkString))
		var checkStringLength = checkString.length;
		for(var count=0; count<checkStringLength; count++){
			
			currentChar = checkString.substring(count,count+1);
			//alert(currentChar)
			currentCharValue = ascii_value(currentChar);
			
			if(currentCharValue>126 || currentCharValue<32 || currentCharValue==34 || currentCharValue==39 || currentCharValue==60 || currentCharValue==62 || currentCharValue==96){
				//alert("oh shit - " + currentCharValue)
				//alert("Your text entry contains at least one non-English character (examples: Ã€, Ã¥, Ã¦).  Our system currently does not accept orders containing non-English characters.  Please re-enter your information using standard English characters only.")
				return false;
			}
	
		}
		return true;
	}
				
	function ascii_value (c)
	{
		// restrict input to a single character
		c = c . charAt (0);
	
		// loop through all possible ASCII values
		var i;
		for (i = 0; i < 256; ++ i)
		{
			// convert i into a 2-digit hex string
			var h = i . toString (16);
			if (h . length == 1)
				h = "0" + h;
	
			// insert a % character into the string
			h = "%" + h;
	
			// determine the character represented by the escape code
			h = unescape (h);
	
			// if the characters match, we've found the ASCII value
			if (h == c)
				break;
		}
		return i;
	}
	
	/** Initialize all of our objects now. */
	window.historyStorage.init();
	window.dhtmlHistory.create();


}
