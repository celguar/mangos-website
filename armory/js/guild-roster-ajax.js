// requires:
//
// armory.js
// mini-search-ajax.js

var guildRosterPageInstance = new GuildRosterPage();
guildRosterPageInstance.pageLoad();

function GuildRosterPage() {

    this.URL_XML = "guild-info.xml";
    this.URL_DATA_XSL = "layout/guild-info-ajax.xsl";
    this.HTML_CONTAINER_ELEMENT_ID = "dataElement";

    this.xsltProcessor;


	// initialize variables
	this.pageLoad = function() {
        this.paramGuild = queryString("n","");
        this.paramRealm = queryString("r","");
        // MFS HACK: for some reason the js include for this file must exist in both the
        // guild-info.xsl and guild-info-ajax.xsl pages, which means that this object gets
        // recreated on every ajax load...this causes a problem with paging in ajax in that
        // you will never be able to get back to the first page you go to after you leave it
        if (IS_ENABLED_XSLT) {
            this.paramPageNumber = 0;
        } else {
            this.paramPageNumber = queryString("p",1);
        }
        this.paramSortField = queryString("sf","level");
        this.paramSortDir = queryString("sd","a");
        this.paramFilterField = queryString("ff","");
        this.paramFilterValue = queryString("fv","");

        miniSearchPanelInstance.pageLoad();
        miniSearchPanelInstance.setPageObject(this);
    }

    this.getXsltProcessor = function() {
        if (!this.xsltProcessor) {
            this.xsltProcessor = new XSLTProcessor();
            initXsltProcessor(this.xsltProcessor, this.URL_DATA_XSL);
        }
        return this.xsltProcessor;
    }

    this.fetchXmlData = function(xmlUrl) {
        var xmlUrl = this.generateXmlUrl();

        if (IS_ENABLED_XSLT) {
			if(region == "KR"){//change by akim (encoding UTF-8)
				addHistory(xmlUrl);
			}
			else{
				addHistory(parseXMLurl(xmlUrl).escapeUrl);
			}
            fetchXmlData(xmlUrl, this.HTML_CONTAINER_ELEMENT_ID, this.getXsltProcessor());
        } else {
            window.location.replace(xmlUrl);
			showLoader();
        }
    }

    this.generateXmlUrl = function() {
        var url = this.URL_XML;
        var params = "";
        if (this.paramGuild)
            params = appendUrlParam(params, "n", this.paramGuild);
        if (this.paramRealm)
            params = appendUrlParam(params, "r", this.paramRealm);
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
        //alert(url);
        return url;
    }

    this.setPageNumberParam = function(newPageNumber) {
        //alert("page number: " + this.paramPageNumber + "\nnew page number: " + newPageNumber);
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

            // clamp page number to a min of 1 to avoid users entering 0 to get to the
            // guild stats page...because that's not intuitive
            if (newPage < 1) {
                newPage = 1;
            }
            this.setPageNumber(newPage);
        }
        else
            return true;
    }

    this.setGuild = function(newGuild) {
        if (this.setGuildParam(newGuild)) {
            this.setPageNumberParam(1);
            this.fetchXmlData();
        }
    }

    this.setGuildParam = function(newGuild) {
        if (newGuild != this.paramGuild) {
            this.paramGuild = newGuild;
            return true;
        }
        return false;
    }

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


    this.ms_generateSearchXmlUrl = function() {
        var url = "";
        var params = "";

        if (IS_ENABLED_XSLT) {
            url = miniSearchPanelInstance.URL_SEARCH_XML;

            params = miniSearchPanelInstance.generateSearchXmlQueryString(params);

            if (miniSearchPanelInstance.getCanHighlightSearchSelection()) {
                if (this.paramGuild)
                    params = appendUrlParam(params, "n", this.paramGuild);
                if (this.paramRealm)
                    params = appendUrlParam(params, "r", this.paramRealm);
            }
        } else {
            url = this.URL_XML;

            if (this.paramGuild)
                params = appendUrlParam(params, "n", this.paramGuild);
            if (this.paramRealm)
                params = appendUrlParam(params, "r", this.paramRealm);

            params = miniSearchPanelInstance.generateSearchXmlQueryString(params);
        }

        if (params)
            url = url + "?" + params;
        //alert(url);
        return url;
    }

}
jsLoaded=true;//needed for ajax script loading
