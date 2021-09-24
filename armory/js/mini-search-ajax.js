// requires:
//
// armory.js

var miniSearchPanelInstance = new MiniSearchPanel();
//alert('miniSearchPanelInstance created');

function MiniSearchPanel() {

    this.URL_LASTSEARCH_XML = "lastsearch.xml";
    this.URL_SEARCH_XML = "index.php";
    this.URL_DATA_XSL = "layout/mini-search-templates-ajax.xsl";
    this.HTML_CONTAINER_ELEMENT_ID = "miniSearchElement";


	// initialize variables
	this.pageLoad = function() {
        this.paramSearchType = "";
        this.paramSearchQuery = "";
        this.paramSelectedTab = "";
        this.paramSearchFilters = null;
        this.paramProfileName = "";
        this.paramProfileRealm = "";
        this.paramProfileItem = 0;
        this.paramSearchPageNumber = 0;

	    this.paramDefaultPageNumber = 0;
    }

    this.xsltProcessor;

    this.pageObject;
    this.canHighlightSearchSelection = false;


    this.getXsltProcessor = function() {
        if (!this.xsltProcessor) {
            this.xsltProcessor = new XSLTProcessor();
            //alert(this.URL_DATA_XSL);
            initXsltProcessor(this.xsltProcessor, this.URL_DATA_XSL);
        }
        return this.xsltProcessor;
    }

    this.fetchXmlData = function(xmlUrl) {
        if (IS_ENABLED_XSLT) {
            //addHistory(xmlUrl);
            fetchXmlData(xmlUrl, this.HTML_CONTAINER_ELEMENT_ID, this.getXsltProcessor());
        } else {
            window.location.replace(xmlUrl);
			showLoader();
        }
    }

    this.setParamDefaultPageNumber = function(page) {
        this.paramDefaultPageNumber = page;
    }

    this.getParamDefaultPageNumber = function() {
        return this.paramDefaultPageNumber;
    }

    this.setPageObject = function(page) {
        this.pageObject = page;
        //alert('miniSearchPanelInstance.setPageObject(): this.pageObject = ' + this.pageObject);
    }

    this.getPageObject = function() {
        return this.pageObject;
    }

    this.setCanHighlightSearchSelection = function(canHighlightSearchSelection) {
        this.canHighlightSearchSelection = canHighlightSearchSelection;
    }

    this.getCanHighlightSearchSelection = function() {
        return this.canHighlightSearchSelection;
    }

    this.revertToDefault = function() {
        this.fetchDefaultXmlData();
    }


    this.generateLastSearchXmlUrl = function() {
        // last search doesn't require parameters
        return this.URL_LASTSEARCH_XML;
    }

    this.generateSearchXmlUrl = function() {
        if (this.pageObject && this.pageObject.ms_generateSearchXmlUrl) {
            return this.pageObject.ms_generateSearchXmlUrl();
        }

        var url = this.URL_SEARCH_XML;
        var params = "";

        params = this.generateSearchXmlQueryString(params);

        if (params)
            url = url + "?" + params;
        //alert("MiniSearchPanel.generateSearchXmlUrl: " + url);
        return url;
    }

    this.generateSearchXmlQueryString = function(params) {
        if (IS_ENABLED_XSLT) {
            if (this.paramSearchType)
                params = appendUrlParam(params, "searchType", this.paramSearchType);
            if (this.paramSearchQuery)
                params = appendUrlParam(params, "searchQuery", this.paramSearchQuery);
            if (this.paramSelectedTab)
                params = appendUrlParam(params, "selectedTab", this.paramSelectedTab);
            if (this.paramSearchFilters) {
                var searchFilters = this.paramSearchFilters;
				var sfLength = searchFilters.length;
                for (var i = 0; i < sfLength; ++i) {
                    params = appendUrlMapParam(params, "fl", searchFilters[i][0], searchFilters[i][1]);
                }
            }
            if (this.paramProfileName)
                params = appendUrlParam(params, "pn", this.paramProfileName);
            if (this.paramProfileRealm)
                params = appendUrlParam(params, "pr", this.paramProfileRealm);
            if (this.paramProfileItem)
                params = appendUrlParam(params, "pi", this.paramProfileItem);
            if (this.paramSearchPageNumber >= 1)
                params = appendUrlParam(params, "p", this.paramSearchPageNumber);
        } else {
            if (this.paramSearchType)
                params = appendUrlParam(params, "msSearchType", this.paramSearchType);
            if (this.paramSearchQuery)
                params = appendUrlParam(params, "msSearchQuery", this.paramSearchQuery);
            if (this.paramSelectedTab)
                params = appendUrlParam(params, "msSelectedTab", this.paramSelectedTab);
            if (this.paramSearchFilters) {
                var searchFilters = this.paramSearchFilters;
				var sfLength = searchFilters.length;
                for (var i = 0; i < sfLength; ++i) {
                    params = appendUrlMapParam(params, "msFl", searchFilters[i][0], searchFilters[i][1]);
                }
            }
            if (this.paramProfileName)
                params = appendUrlParam(params, "msPn", this.paramProfileName);
            if (this.paramProfileRealm)
                params = appendUrlParam(params, "msPr", this.paramProfileRealm);
            if (this.paramProfileItem)
                params = appendUrlParam(params, "msPi", this.paramProfileItem);
            if (this.paramSearchPageNumber >= 1)
                params = appendUrlParam(params, "msP", this.paramSearchPageNumber);
        }
        return params;
    }

    this.fetchLastSearchXmlData = function() {
		//alert("side")
        this.fetchXmlData(this.generateLastSearchXmlUrl());
    }

    this.fetchSearchXmlData = function() {
        this.fetchXmlData(this.generateSearchXmlUrl());
    }

    this.fetchDefaultXmlData = function() {
        //alert('miniSearchPanelInstance.fetchDefaultXmlData(): this.pageObject = ' + this.pageObject);
        this.fetchXmlData(this.pageObject.ms_generateDefaultXmlUrl());
    }


    this.setSearchTypeParam = function(newSearchType) {
        if (this.paramSearchType != newSearchType) {
            this.paramSearchType = newSearchType;
            return true;
        }
        return false;
    }

    this.setSearchQueryParam = function(newSearchQuery) {
        if (this.paramSearchQuery != newSearchQuery) {
            this.paramSearchQuery = newSearchQuery;
            return true;
        }
        return false;
    }

    this.setSelectedTabParam = function(newSelectedTab) {
        if (this.paramSelectedTab != newSelectedTab) {
            this.paramSelectedTab = newSelectedTab;
            return true;
        }
        return false;
    }

    this.setSearchPageNumberParam = function(newSearchPageNumber) {
        if (this.paramSearchPageNumber != newSearchPageNumber) {
            this.paramSearchPageNumber = newSearchPageNumber;
            return true;
        }
        return false;
    }

    this.setSearchPageNumber = function(newPageNumber) {
        if (this.setSearchPageNumberParam(newPageNumber)) {
            this.fetchSearchXmlData();
        }
    }

    this.setProfileNameParam = function(newProfileName) {
        if (this.paramProfileName != newProfileName) {
            this.paramProfileName = newProfileName;
            return true;
        }
        return false;
    }

    this.setProfileRealmParam = function(newProfileRealm) {
        if (this.paramProfileRealm != newProfileRealm) {
            this.paramProfileRealm = newProfileRealm;
            return true;
        }
        return false;
    }

    this.setProfileItemParam = function(newProfileItem) {
        if (this.paramProfileItem != newProfileItem) {
            this.paramProfileItem = newProfileItem;
            return true;
        }
        return false;
    }

    this.setSearchFilterParam = function(key, value) {
        if (key && value) {
            if (!this.paramSearchFilters) {
                this.paramSearchFilters = new Array();
            }

            var found = false;
			var psfLength = this.paramSearchFilters.length;
            for (var i = 0; i < psfLength && !found; ++i) {
                if (this.paramSearchFilters[i][0] == key) {
                    this.paramSearchFilters[i][1] = value;
                    found = true;
                }
            }

            if (!found) {
                var len = this.paramSearchFilters.length;
                this.paramSearchFilters[len] = new Array(2);
                this.paramSearchFilters[len][0] = key;
                this.paramSearchFilters[len][1] = value;
            }

            return true;
        }
        return false;
    }


    this.setDefaultPageNumberParam = function(newDefaultPageNumber) {
        if (this.paramDefaultPageNumber != newDefaultPageNumber) {
            this.paramDefaultPageNumber = newDefaultPageNumber;
            return true;
        }
        return false;
    }

    this.setDefaultPageNumber = function(newPageNumber) {
        if (this.setDefaultPageNumberParam(newPageNumber)) {
			this.fetchDefaultXmlData();
        }
    }
}

jsLoaded=true;//needed for ajax script loading