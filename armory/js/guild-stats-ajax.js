// requires:
//
// armory.js
// mini-search-ajax.js

var guildStatsPageInstance = new GuildStatsPage();
guildStatsPageInstance.pageLoad();

function GuildStatsPage() {

    this.URL_XML = "guild-info.xml";
    this.MS_URL_DEFAULT_XML = "guild-info.xml";


    // initialize variables
    this.pageLoad = function() {
        this.ms_paramGuild = queryString("n","");
        this.ms_paramRealm = queryString("r","");

        miniSearchPanelInstance.pageLoad();
        miniSearchPanelInstance.setPageObject(this);
    }


    this.ms_generateDefaultXmlUrl = function() {
        var url = "";
        var params = "";

        var paramDefaultPageNumber = miniSearchPanelInstance.getParamDefaultPageNumber();

        if (IS_ENABLED_XSLT) {
            url = this.MS_URL_DEFAULT_XML;

            if (this.ms_paramRealm)
                params = appendUrlParam(params, "r", this.ms_paramRealm);
            if (this.ms_paramGuild)
                params = appendUrlParam(params, "n", this.ms_paramGuild);
            if (paramDefaultPageNumber >= 1)
                params = appendUrlParam(params, "p", paramDefaultPageNumber);
        } else {
            url = this.URL_XML;

            if (this.ms_paramRealm)
                params = appendUrlParam(params, "r", this.ms_paramRealm);
            if (this.ms_paramGuild)
                params = appendUrlParam(params, "n", this.ms_paramGuild);
            // go ahead and reuse the search page param
            if (paramDefaultPageNumber >= 1) {
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
                if (this.ms_paramGuild)
                    params = appendUrlParam(params, "n", this.ms_paramGuild);
                if (this.ms_paramRealm)
                    params = appendUrlParam(params, "r", this.ms_paramRealm);
            }
        } else {
            url = this.URL_XML;

            if (this.ms_paramGuild)
                params = appendUrlParam(params, "n", this.ms_paramGuild);
            if (this.ms_paramRealm)
                params = appendUrlParam(params, "r", this.ms_paramRealm);

            params = miniSearchPanelInstance.generateSearchXmlQueryString(params);
        }

        if (params)
            url = url + "?" + params;
        //alert(url);
        return url;
    }
}
jsLoaded=true;//needed for ajax script loading
