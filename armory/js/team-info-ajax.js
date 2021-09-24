// requires:
//
// armory.js
// mini-search-ajax.js

var teamInfoPageInstance = new TeamInfoPage();
teamInfoPageInstance.pageLoad();

function TeamInfoPage() {

    this.URL_XML = "http://www.wowarmory.com/team-info.xml";
    this.MS_URL_DEFAULT_XML = "arena-ladder.html";


	// initialize variables
	this.pageLoad = function() {
        this.ms_paramBattlegroup = queryString("b","");
        this.ms_paramTeamName = queryString("t","");
        this.ms_paramTeamSize = queryString("ts","");
        
        miniSearchPanelInstance.pageLoad();
        miniSearchPanelInstance.setPageObject(this);
    }


    this.ms_generateDefaultXmlUrl = function() {
        var url = "";
        var params = "";

        var paramDefaultPageNumber = miniSearchPanelInstance.getParamDefaultPageNumber();

        if (IS_ENABLED_XSLT) {
            url = this.MS_URL_DEFAULT_XML;

            if (this.ms_paramBattlegroup)
                params = appendUrlParam(params, "b", this.ms_paramBattlegroup);
            if (this.ms_paramTeamSize)
                params = appendUrlParam(params, "ts", this.ms_paramTeamSize);
            if (this.ms_paramTeamName)
                params = appendUrlParam(params, "select", this.ms_paramTeamName);
            if (paramDefaultPageNumber >= 1)
                params = appendUrlParam(params, "p", paramDefaultPageNumber);
        } else {
            url = this.URL_XML;

            if (this.ms_paramBattlegroup)
                params = appendUrlParam(params, "b", this.ms_paramBattlegroup);
            if (this.ms_paramTeamSize)
                params = appendUrlParam(params, "ts", this.ms_paramTeamSize);
            if (this.ms_paramTeamName)
                params = appendUrlParam(params, "t", this.ms_paramTeamName);
            // go ahead and reuse the search page param
            if (paramDefaultPageNumber >= 1)
                params = appendUrlParam(params, "msP", paramDefaultPageNumber);
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
                if (this.ms_paramBattlegroup)
                    params = appendUrlParam(params, "b", this.ms_paramBattlegroup);
                if (this.ms_paramTeamSize)
                    params = appendUrlParam(params, "ts", this.ms_paramTeamSize);
                if (this.ms_paramTeamName)
                    params = appendUrlParam(params, "t", this.ms_paramTeamName);
            }
        } else {
            url = this.URL_XML;

            if (this.ms_paramBattlegroup)
                params = appendUrlParam(params, "b", this.ms_paramBattlegroup);
            if (this.ms_paramTeamSize)
                params = appendUrlParam(params, "ts", this.ms_paramTeamSize);
            if (this.ms_paramTeamName)
                params = appendUrlParam(params, "t", this.ms_paramTeamName);

            params = miniSearchPanelInstance.generateSearchXmlQueryString(params);
        }

        if (params)
            url = url + "?" + params;
        //alert(url);
        return url;
    }
}

jsLoaded=true;//needed for ajax script loading
