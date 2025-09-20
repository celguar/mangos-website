var uagent    = navigator.userAgent.toLowerCase();
var is_safari = ( (uagent.indexOf('safari') != -1) || (navigator.vendor == "Apple Computer, Inc.") );
var is_opera  = (uagent.indexOf('opera') != -1);
var is_webtv  = (uagent.indexOf('webtv') != -1);
var is_ie     = ( (uagent.indexOf('msie') != -1) && (!is_opera) && (!is_safari) && (!is_webtv) );
var is_ie4    = ( (is_ie) && (uagent.indexOf("msie 4.") != -1) );
var is_moz    = ( (navigator.product == 'Gecko')  && (!is_opera) && (!is_webtv) && (!is_safari) );
var is_ns     = ( (uagent.indexOf('compatible') == -1) && (uagent.indexOf('mozilla') != -1) && (!is_opera) && (!is_webtv) && (!is_safari) );
var is_ns4    = ( (is_ns) && (parseInt(navigator.appVersion) == 4) );
var is_kon    = (uagent.indexOf('konqueror') != -1);

var is_win    =  ( (uagent.indexOf("win") != -1) || (uagent.indexOf("16bit") !=- 1) );
var is_mac    = ( (uagent.indexOf("mac") != -1) || (navigator.vendor == "Apple Computer, Inc.") );
var ua_vers   = parseInt(navigator.appVersion);

// IE bug fix
var ie_range_cache = '';
var imgres;

function myshow(el)
{
	obj = document.getElementById(el);
	obj.style.visibility='visible';
	obj.style.display = '';
}
function myhide(el)
{
	obj = document.getElementById(el);
	obj.style.visibility='hidden';
	obj.style.display = 'none';
	
}
function myhide_timed(el){
    setTimeout("myhide(\""+el+"\")",1000)
}
function mytoggleview(el)
{
	obj = document.getElementById(el);
	if (obj.style.visibility == 'hidden')
	{
		obj.style.visibility = 'visible';
		obj.style.display = '';
	}
	else
	{
		obj.style.visibility = 'hidden';
		obj.style.display = 'none';
	}
}

function popup_ask(mess){
	return confirm(mess);
}
function clear_innerHTML(el)
{
	document.getElementById(el).innerHTML = '';
}
function addlink(el)
{
	url = prompt('Insert link:', 'http://');
	if ( (ua_vers >= 4) && is_ie && is_win )
	{
		sel = document.selection;
		rng = ie_range_cache ? ie_range_cache : sel.createRange();
		rng.colapse;
		if(rng.text.length < 1){
		name = prompt('Enter link name:', '');
		  if(!name){name = url;}
		}else{
		name = '';
		}
	}else{
		if(document.getElementById(el).selectionEnd-document.getElementById(el).selectionStart<1){
		name = prompt('Insert link name:', '');
		  if(!name){name = url;}
		}else{
		name = '';
		}
	}
	if(url){
	wrap_tags('[url='+url+']'+name+'','[/url]',el);
	}
}
function addemail(el)
{
	url = prompt('Insert email', '');
	if ( (ua_vers >= 4) && is_ie && is_win )
	{
		sel = document.selection;
		rng = ie_range_cache ? ie_range_cache : sel.createRange();
		rng.colapse;
		if(rng.text.length < 1){
		name = prompt('Insert addressee:', '');
		  if(!name){name = url;}
		}else{
		name = '';
		}
	}else{
		if(document.getElementById(el).selectionEnd-document.getElementById(el).selectionStart<1){
		name = prompt('Insert addressee:', '');
		  if(!name){name = url;}
		}else{
		name = '';
		}
	}
	if(url){
	wrap_tags('[url=mailto:'+url+']'+name+'','[/url]',el);
	}
}
function addimage(el)
{
	url = prompt('Insert image url:', 'http://');
	wrap_tags('[img]'+url,'[/img]',el);
}

function wrap_tags(opentext, closetext, tofield, issingle)
{
	postfieldobj = document.getElementById(tofield);
	var has_closed = false;
	
	if ( ! issingle )
	{
		issingle = false;
	}
	
	//----------------------------------------
	// It's IE!
	//----------------------------------------
	
	if ( (ua_vers >= 4) && is_ie && is_win )
	{
		if ( postfieldobj.isTextEdit )
		{
			//postfieldobj.focus();
			
			var sel = document.selection;
			
			var rng = ie_range_cache ? ie_range_cache : sel.createRange();
			rng.colapse;
			
			if ( (sel.type == "Text" || sel.type == "None") && rng != null && rng.text )
			{
				if (closetext != "" && rng.text.length > 0)
				{ 
					opentext += rng.text + closetext;
				}
				else if ( issingle )
				{
					has_closed = true;
				}
				rng.text = opentext;
			}
			else
			{
				postfieldobj.value += opentext + closetext;
				has_closed = true;
			}
		}
		else
		{
			postfieldobj.value += opentext + closetext;
			has_closed = true;
		}

		ie_range_cache = null;
		rng.select();

	}
	
	//----------------------------------------
	// It's MOZZY!
	//----------------------------------------
	
	else if ( postfieldobj.selectionEnd )
	{
		var ss = postfieldobj.selectionStart;
		var st = postfieldobj.scrollTop;
		var es = postfieldobj.selectionEnd;
		
		if (es <= 0)
		{
			es = postfieldobj.textLength;
		}
		
		var start  = (postfieldobj.value).substring(0, ss);
		var middle = (postfieldobj.value).substring(ss, es);
		var end    = (postfieldobj.value).substring(es, postfieldobj.textLength);
		
		//-----------------------------------
		// text range?
		//-----------------------------------
		
		if ( postfieldobj.selectionEnd - postfieldobj.selectionStart > 0 )
		{
			middle = opentext + middle + closetext;
		}
		else
		{
			middle = ' ' + opentext + middle + closetext + ' ';
			
			if ( issingle )
			{
				has_closed = true;
			}
		}
		
		postfieldobj.value = start + middle + end;
		
		var cpos = ss + (middle.length);
		
		postfieldobj.selectionStart = cpos;
		postfieldobj.selectionEnd   = cpos;
		postfieldobj.scrollTop      = st;
	}
	
	//----------------------------------------
	// It's CRAPPY!
	//----------------------------------------
	
	else
	{ 
		if ( issingle )
		{
			has_closed = false;
		}
			
		postfieldobj.value += opentext + ' ' + closetext;
	}
	
	postfieldobj.focus();

	return has_closed;
}

function setColor(color,tofield)
{
	var parentCommand = parent.command;
	
	if ( parentCommand == "hilitecolor" )
	{
		if ( wrap_tags("[background=" +color+ "]", "[/background]", 'textarea', true ) )
		{
			//toggle_button( "background" );
			//pushstack(bbtags, "background");
		}
	}
	else
	{
		if ( wrap_tags("[color=" +color+ "]", "[/color]", tofield, true ) )
		{
			//toggle_button( "color" );
			//pushstack(bbtags, "color");
		}
	}

	document.getElementById('cp').style.visibility = "hidden";
	document.getElementById('cp').style.display    = "none";
}

function RemoveParameterFromUrl(url, parameter) {
	return url
		.replace(new RegExp('[?&]' + parameter + '=[^&#]*(#.*)?$'), '$1')
		.replace(new RegExp('([?&])' + parameter + '=[^&]*&'), '$1');
}

function askrace() {
	let text;
	let race = prompt("Choose races to show:\n Human - 1\n Orc - 2\n Dwarf - 3\n Night Elf - 4\n Undead - 5\n Tauren - 6\n Gnome - 7\n Troll - 8", "1,2,3,4,5,6,7,8");
	if (race == null || race === "") {
		text = "User cancelled the prompt.";
	} else {
		text = "Hello " + race + "! How are you today?";
		let url = document.getElementById("sort_race").href;
		url = RemoveParameterFromUrl(url, "race");
		url += "&race=";
		url += race;
		document.getElementById("sort_race").href = url;
	}
}

function askclass() {
	let text;
	let _class = prompt("Choose classes to show:\n Warrior - 1\n Paladin - 2\n Hunter - 3\n Rogue - 4\n Priest - 5\n Shaman - 7\n Mage - 8\n Warlock - 9\n Druid - 11", "1,2,3,4,5,7,8,9,11");
	if (_class == null || _class === "") {
		text = "User cancelled the prompt.";
	} else {
		text = "Hello " + _class + "! How are you today?";
		let url = document.getElementById("sort_class").href;
		url = RemoveParameterFromUrl(url, "class");
		url += "&class=";
		url += _class;
		document.getElementById("sort_class").href = url;
	}
}

function askname() {
	let text;
	let name = prompt("Choose name or part of name", "");
	if (name == null || name === "") {
		text = "User cancelled the prompt.";
	} else {
		text = "Hello " + name + "! How are you today?";
		let url = document.getElementById("sort_name").href;
		url = RemoveParameterFromUrl(url, "char");
		url += "&char=";
		url += name;
		document.getElementById("sort_name").href = url;
	}
}

function askrafname() {
	let text;
	let name = prompt("Please enter the name of the friend you recruited", "");
	if (name == null || name === "") {
		text = "Name not entered!";
	} else {
		text = "Hello " + name + "! How are you today?";
		let url = document.getElementById("raflink").href;
		url = RemoveParameterFromUrl(url, "raf");
		url += "&rafname=";
		url += name;
		document.getElementById("raflink").href = url;
		document.getElementById("raflink").click();
	}
}

function asklevel() {
	let text;
	let level = prompt("Choose level or level range, e.g. 10-20", "1-80");
	if (level == null || level === "") {
		text = "User cancelled the prompt.";
	} else {
		text = "Hello " + level + "! How are you today?";
		let url = document.getElementById("sort_level").href;
		let lvlsort = level.split('-');

		// rane given
		if (lvlsort[1] !== undefined)
		{
			let minlvl = lvlsort[0];
			let maxlvl = lvlsort[1];
			url = RemoveParameterFromUrl(url, "lvl");
			url = RemoveParameterFromUrl(url, "minlvl");
			url = RemoveParameterFromUrl(url, "maxlvl");
			url += "&minlvl=";
			url += minlvl;
			url += "&maxlvl=";
			url += maxlvl;
		}
		else
		{
			if (lvlsort[0] !== undefined)
			{
				url = RemoveParameterFromUrl(url, "lvl");
				url = RemoveParameterFromUrl(url, "minlvl");
				url = RemoveParameterFromUrl(url, "maxlvl");
				url += "&lvl=";
				url += lvlsort[0];
			}
		}
		document.getElementById("sort_level").href = url;
	}
}
