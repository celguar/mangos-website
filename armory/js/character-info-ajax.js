// requires:
//
// armory.js
// mini-search-ajax.js

var characterInfoPageInstance = new CharacterInfoPage();
characterInfoPageInstance.pageLoad();

function CharacterInfoPage() {

    this.MS_URL_DEFAULT_XML = "guild-info.xml";


	// initialize variables
	this.pageLoad = function() {
        this.ms_paramCharName = queryString("n","");
        this.ms_paramRealm = queryString("r","");
        this.ms_paramGuildName = "";

        this.xmlUrl = "character-sheet.xml";

        miniSearchPanelInstance.pageLoad();
        miniSearchPanelInstance.setPageObject(this);
    }

    this.setXmlUrl = function(xmlUrl) {
        this.xmlUrl = xmlUrl;
    }

    this.ms_generateDefaultXmlUrl = function() {
        var url = "";
        var params = "";

        var paramDefaultPageNumber = miniSearchPanelInstance.getParamDefaultPageNumber();

        if (IS_ENABLED_XSLT) {
            url = this.MS_URL_DEFAULT_XML;

            if (this.ms_paramRealm)
                params = appendUrlParam(params, "r", this.ms_paramRealm);
            if (this.ms_paramGuildName)
                params = appendUrlParam(params, "n", this.ms_paramGuildName);
            if (this.ms_paramCharName)
                params = appendUrlParam(params, "select", this.ms_paramCharName);
            if (paramDefaultPageNumber >= 1)
                params = appendUrlParam(params, "p", paramDefaultPageNumber);
        } else {
            url = this.xmlUrl;

            if (this.ms_paramRealm)
                params = appendUrlParam(params, "r", this.ms_paramRealm);
            if (this.ms_paramCharName)
                params = appendUrlParam(params, "n", this.ms_paramCharName);
            // go ahead and reuse the search page param
            if (paramDefaultPageNumber >= 1) {
                //alert(paramDefaultPageNumber);
                params = appendUrlParam(params, "msP", paramDefaultPageNumber);
            }
        }

        if (params)
            url = url + "?" + params;
        //alert(url);
        return url;
    }

    this.ms_generateSearchXmlUrl = function() {
        var url = "";
        var params = "";

        if (IS_ENABLED_XSLT) {
            url = miniSearchPanelInstance.URL_SEARCH_XML;

            params = miniSearchPanelInstance.generateSearchXmlQueryString(params);

            if (miniSearchPanelInstance.getCanHighlightSearchSelection()) {
                if (this.ms_paramRealm)
                    params = appendUrlParam(params, "r", this.ms_paramRealm);
                if (this.ms_paramCharName)
                    params = appendUrlParam(params, "n", this.ms_paramCharName);
            }
        } else {
            url = this.xmlUrl;

            if (this.ms_paramRealm)
                params = appendUrlParam(params, "r", this.ms_paramRealm);
            if (this.ms_paramCharName)
                params = appendUrlParam(params, "n", this.ms_paramCharName);

            params = miniSearchPanelInstance.generateSearchXmlQueryString(params);
        }

        if (params)
            url = url + "?" + params;
        //alert(url);
        return url;
    }

    this.ms_setGuildNameParam = function(newGuildName) {
        if (this.ms_paramGuildName != newGuildName) {
            this.ms_paramGuildName = newGuildName;
            return true;
        }
        return false;
    }
}

jsLoaded=true;//needed for ajax script loading
