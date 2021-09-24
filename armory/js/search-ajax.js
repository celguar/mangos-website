// requires:
//
// armory.js

var searchPageInstance = new SearchPage();
searchPageInstance.pageLoad();

function SearchPage() {

    this.URL_XML = "index.php";
    this.URL_DATA_XSL = "layout/search-ajax.xsl";
    this.URL_INDEX = "index.xml";
    this.HTML_CONTAINER_ELEMENT_ID = "dataElement";


	// initialize variables
	this.pageLoad = function() {
        this.paramSearchType = queryString("searchType","");
        this.paramSearchQuery = queryString("searchQuery","");
        this.paramSelectedTab = queryString("selectedTab","");
        // HACK: there are problems with paging in ajax when the user hits the reload button
        if (IS_ENABLED_XSLT) {
            this.paramPageNumber = 0;
        } else {
            this.paramPageNumber = queryString("p",1);
        }
        this.paramSearchMessage = queryString("searchMessage","");
        this.paramTeamName = queryString("t","");
        this.paramSortField = queryString("sf","relevance");
        this.paramSortDir = queryString("sd","a");
//        this.paramFilterField = queryString("ff","");
//        this.paramFilterValue = queryString("fv","");
    }

    this.xsltProcessor;


    this.checkForRedirect = function() {
		if (this.paramSearchType == "" || this.paramSearchQuery == "") {
            window.location.replace(this.URL_INDEX);
		}
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
			if(region == "KR"){//change by akim (not used escapeUrl)
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
        if (this.paramSearchType)
            params = appendUrlParam(params, "searchType", this.paramSearchType);
		if (this.paramSearchQuery)
            params = appendUrlParam(params, "searchQuery", this.paramSearchQuery);
		if (this.paramSelectedTab)
            params = appendUrlParam(params, "selectedTab", this.paramSelectedTab);
        if (this.paramPageNumber >= 1)
            params = appendUrlParam(params, "p", this.paramPageNumber);
        if ((this.paramSortField) || (this.paramSortDir == "d")) {
            params = appendUrlParam(params, "sf", this.paramSortField);
            params = appendUrlParam(params, "sd", this.paramSortDir);
        }
//        if  ((this.paramFilterField) && (this.paramFilterValue)) {
//            params = appendUrlParam(params, "ff", this.paramFilterField);
//            params = appendUrlParam(params, "fv", this.paramFilterValue);
//        }
        if (this.paramSearchFilters) {
            params = params + '&' + this.paramSearchFilters;
        }
        if (params)
            url = url + "?" + params;
        //alert("SearchPageInstance.generateXmlUrl: " + url);
        return url;
    }

    this.setSearchTypeParam = function(newSearchType) {
        if (this.paramSearchType != newSearchType) {
            this.paramSearchType = newSearchType;
            return true;
        }
        return false;
    }

    this.setSearchType = function(newSearchType) {
        if (this.setSearchTypeParam(newSearchType)) {
            this.fetchXmlData();
        }
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

    this.setSelectedTab = function(newSelectedTab) {
        if (this.setSelectedTabParam(newSelectedTab)) {
			deletecookie("cookieLeftSort");
			deletecookie("cookieLeftSortUD");
			deletecookie("cookieLeftPage");			
            this.paramPageNumber = 1;
            this.fetchXmlData();
        }
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
        var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
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

    this.setSearchFilterParams = function(filters) {
   	    if (this.paramSearchFilters != filters) {
	        this.paramSearchFilters = filters;
	        return true;
        }
        return false;
    }
/*
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
*/
}
jsLoaded=true;//needed for ajax script loading
