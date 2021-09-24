// requires:
//
// armory.js
// mini-search-ajax.js

var itemInfoPageInstance = new ItemInfoPage();
itemInfoPageInstance.pageLoad();

function ItemInfoPage() {

    this.URL_XML = "item-info.xml";


	// initialize variables
	this.pageLoad = function() {
        this.ms_paramItemId = queryString("i","");

        miniSearchPanelInstance.pageLoad();
        miniSearchPanelInstance.setPageObject(this);
    }

    this.ms_generateSearchXmlUrl = function() {
        var url = "";
        var params = "";

        if (IS_ENABLED_XSLT) {
            url = miniSearchPanelInstance.URL_SEARCH_XML;

            params = miniSearchPanelInstance.generateSearchXmlQueryString(params);

            if (miniSearchPanelInstance.getCanHighlightSearchSelection()) {
                if (this.ms_paramItemId)
                    params = appendUrlParam(params, "i", this.ms_paramItemId);
            }
        } else {
            url = this.URL_XML;

            if (this.ms_paramItemId)
                params = appendUrlParam(params, "i", this.ms_paramItemId);

            params = miniSearchPanelInstance.generateSearchXmlQueryString(params);
        }

        if (params)
            url = url + "?" + params;
        //alert("ItemInfoPage.generateSearchXmlUrl: " + url);
        return url;
    }
}

jsLoaded=true;//needed for ajax script loading
