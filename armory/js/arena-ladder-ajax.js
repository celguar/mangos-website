// requires:
//
// armory.js

var arenaLadderPageInstance = new ArenaLadderPage();
arenaLadderPageInstance.pageLoad();

//alert('window.location.hash = ' + window.location.hash);
function ArenaLadderPage() {

    this.URL_XML = "arena-ladder.xml";
    this.URL_DATA_XSL = "layout/arena-ladder-ajax.xsl";
    this.URL_BATTLEGROUP_SELECT = "battlegroups.xml";
    this.XSL_URL_BATTLEGROUP_SELECT = "layout/battlegroups-ajax.xsl";
    this.URL_TEAMSIZE_SELECT = "select-team-type.xml";
    this.HTML_CONTAINER_ELEMENT_ID = "dataElement";


    this.xsltProcessor;


    // initialize variables
    this.pageLoad = function() {
        this.paramBattlegroup = queryString("b","");
        this.paramTeamSize = queryString("ts","");
        this.paramPageNumber = queryString("p",0);
        this.paramTeamName = queryString("t","");
//        this.paramFaction = queryString("faction","");
//        this.paramRealm = queryString("realm","");
        this.paramSortField = queryString("sf","rank");
        this.paramSortDir = queryString("sd","a");
        this.paramFilterField = queryString("ff","");
        this.paramFilterValue = queryString("fv","");

        this.checkForRedirect();
    }

    this.checkForRedirect = function() {
        //alert('bg param = ' + this.paramBattlegroup);
        //alert('bg cookie = ' + getcookie2("armory.cookieBG"));

        var cookieBGValue = getcookie2(theBGcookie);

        if (this.paramBattlegroup) {
            if (this.paramBattlegroup != cookieBGValue) {
                setcookie(theBGcookie, this.paramBattlegroup);
            }
        } else if (cookieBGValue) {
            this.paramBattlegroup = cookieBGValue;
        } else {
            //ajaxLink(this.URL_BATTLEGROUP_SELECT, this.XSL_URL_BATTLEGROUP_SELECT);
			window.location.href = this.URL_BATTLEGROUP_SELECT;
            return false;
        }

        var cookieTSValue = getcookie2("armory.cookieTS");
        if (this.paramTeamSize == 2 || this.paramTeamSize == 3 || this.paramTeamSize == 5) {
            if (this.paramTeamSize != cookieTSValue) {
                setcookie("armory.cookieTS", this.paramTeamSize);
            }
        } else if (cookieTSValue == 2 || cookieTSValue == 3 || cookieTSValue == 5) {
            this.paramTeamSize = cookieTSValue;
        } else {
            //ajaxLink(this.URL_TEAMSIZE_SELECT);
			window.location.href = this.URL_TEAMSIZE_SELECT;
            return false;
        }
    }

    this.getXsltProcessor = function() {
        if (!this.xsltProcessor) {
            this.xsltProcessor = new XSLTProcessor();
            initXsltProcessor(this.xsltProcessor, this.URL_DATA_XSL);
        }
        return this.xsltProcessor;
    }

    this.fetchXmlData = function() {
        var xmlUrl = this.generateXmlUrl();

        window.location.replace(xmlUrl);
		showLoader();
    }

    this.generateXmlUrl = function() {
        var url =this.URL_XML;
        var params = "";
        if(url.indexOf('?')<0){
            if (this.paramBattlegroup)
                params = appendUrlParam(params, "b", this.paramBattlegroup);
            if (this.paramTeamSize)
                params = appendUrlParam(params, "ts", this.paramTeamSize);
            if (this.paramTeamName && this.paramPageNumber == 0)
                params = appendUrlParam(params, "t", this.paramTeamName);
    //        if (this.paramRealm)
    //            params = appendUrlParam(params, "r", this.paramRealm);
    //        if (this.paramFaction)
    //            params = appendUrlParam(params, "faction", this.paramFaction);
            if (this.paramPageNumber >= 1)
                params = appendUrlParam(params, "p", this.paramPageNumber);
            if ((this.paramSortField) || (this.paramSortDir == "d")) {
                params = appendUrlParam(params, "sf", this.paramSortField);
                params = appendUrlParam(params, "sd", this.paramSortDir);
            }
            if  ((this.paramFilterField) && (this.paramFilterValue)) {
                params = appendUrlParam(params, "ff", this.paramFilterField);
                params = appendUrlParam(params, "fv", this.paramFilterValue);
            }
            if (params)
                url = url + "?" + params;
        }
        //alert(url);
        url = url;
        return url;
    }


    this.setPageNumberParam = function(newPageNumber) {
        if (this.paramPageNumber != newPageNumber) {
            this.paramPageNumber = newPageNumber;
            return true;
        }
        return false;
    }
    
    this.setPageNumber = function(newPageNumber) {
        if (this.setPageNumberParam(newPageNumber)) {
            this.fetchXmlData();
        }
    }

    this.pageSearchOnKeyPress = function(evt){
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13 || charCode == 3) {
            var newPage = "";
            if (evt.srcElement)
                newPage = evt.srcElement.value;
            else if (evt.target)
                newPage = evt.target.value;
            else
                newPage = document.getElementById('pageSearch').value;
            this.setPageNumber(newPage);
        }
        else
            return true;
    }

    this.setTeamSizeParam = function(newTeamSize) {
        if (this.paramTeamSize != newTeamSize) {
            this.paramTeamSize = newTeamSize;
            return true;
        }
        return true;
    }

    this.setTeamSize = function(newTeamSize) {
        if (this.setTeamSizeParam(newTeamSize)) {
            this.paramPageNumber = 1;
            setcookie("armory.cookieTS", newTeamSize)

			if(!getcookie2("armory.cookieBG"))
				document.location.href = "battlegroups.xml#regular";
			else {
				this.paramBattlegroup = getcookie2("armory.cookieBG");
	            this.fetchXmlData();				
			}

        }
    }

    this.setSort = function(newSortField) {
        var newSortDir = "a";
        // reverse sort if we are already sorting by this field
        if ((newSortField == this.paramSortField) && (this.paramSortDir != "d"))
            newSortDir = "d";

        if (this.setSortParams(newSortField, newSortDir)) {
            this.setPageNumberParam(1);
            this.fetchXmlData();
        }
    }

    this.setSortParams = function(newSortField, newSortDir) {
        if ((newSortField != this.paramSortField) || (newSortDir != this.paramSortDir)) {
            this.paramSortField = newSortField;
            this.paramSortDir = newSortDir;
            return true;
        }
        return false;
    }

    this.updateSortHeader = function(newSortField, newSortDir) {
        var selectObj = document.getElementById('sort');
        setSelectIndexToValue(selectObj, newSortField);
    }

    this.setBattlegroup = function(newBattlegroup) {
        if (this.setBattlegroupParam(newBattlegroup)) {
            //alert('setting battlegroup to ' + newBattlegroup);
            this.paramPageNumber = 1;
            this.paramFilterField = "";
            this.paramFilterValue = "";
            setcookie(theBGcookie, newBattlegroup)
            this.fetchXmlData();
        }
    }

    this.setBattlegroupParam = function(newBattlegroup) {
        if (newBattlegroup != this.paramBattlegroup) {
            this.paramBattlegroup = newBattlegroup;
            return true;
        }
        return false;
    }

    this.updateBattlegroupHeader = function(newBattlegroup) {
        var selectObj = document.getElementById('battlegroupName');
        setSelectIndexToValue(selectObj, newBattlegroup);
    }

/*
    this.setRealm = function(newRealm) {
        if (this.setRealmParam(newRealm)) {
            this.setPageNumberParam(1);
            this.fetchXmlData();
        }
    }

    this.setRealmParam = function(newRealm) {
        if (newRealm != this.paramRealm) {
            this.paramRealm = newRealm;
            return true;
        }
        return false;
    }

    this.updateRealmHeader = function(newRealm) {
        var selectObj = document.getElementById('realmName');
        setSelectIndexToValue(selectObj, newRealm);
    }

    this.setFaction = function(newFaction) {
        if (this.setFactionParam(newFaction)) {
            this.setPageNumberParam(1);
            this.fetchXmlData();
        }
    }

    this.setFactionParam = function(newFaction) {
        if (this.paramFaction != newFaction) {
            this.paramFaction = newFaction;
            return true;
        }
        return false;
    }

    this.updateFactionHeader = function(newFaction) {
        var selectObj = document.getElementById('faction');
        setSelectIndexToValue(selectObj, newFaction);
    }
*/

    this.setFilter = function(newFilterField, newFilterValue) {
        if (this.setFilterParams(newFilterField, newFilterValue)) {
            this.setPageNumberParam(1);
            this.fetchXmlData();
        }
    }

    this.setFilterParams = function(newFilterField, newFilterValue) {
        if ((newFilterField != this.paramFilterField) || (newFilterValue != this.paramFilterValue)) {
            this.paramFilterField = newFilterField;
            this.paramFilterValue = newFilterValue;
            return true;
        }
        return false;
    }

    this.updateFilterHeader = function(newFilterField, newFilterValue) {
        var selectObj = document.getElementById('filter');
        var optionValue = "NOFILTER";
        if ((newFilterField) && (newFilterValue))
            optionValue = newFilterField + "." + newFilterValue;
        setSelectIndexToValue(selectObj, optionValue);
    }

    this.setComboFilter = function(filterString) {
       if (filterString) {
           if (filterString == "NOFILTER") {
               this.setFilter("", "");
           } else {
               var filter_params = filterString.split(".");
               this.setFilter(filter_params[0], filter_params[1]);
           }
       }
    }

    this.followLink = function(link) {
        window.location.href = link;
        return false;
    }
}

jsLoaded=true;//needed for ajax script loading
