// requires:
//
// armory.js

var selectTeamTypePageInstance = new SelectTeamTypePage();
selectTeamTypePageInstance.pageLoad();

function SelectTeamTypePage() {
    this.URL_BATTLEGROUP_SELECT = "battlegroups.xml";
    this.URL_TEAMSIZE_SELECT = "select-team-type.xml";
    this.URL_ARENA_LADDER = "arena-ladder.xml";


	// initialize variables
	this.pageLoad = function() {
        this.paramBattlegroup = queryString("b","");
        this.paramTeamSize = queryString("ts","");
        this.paramTeamFilterField = queryString("ff","");
        this.paramTeamFilterValue = queryString("fv","");
    }


    this.checkForRedirect = function() {
		if (this.paramBattlegroup != "") {
			setcookie("armory.cookieBG", this.paramBattlegroup)
		} else if (cookieBGValue = getcookie2("armory.cookieBG")) {
			this.setBattlegroupParam(cookieBGValue);
		} else {
            //ajaxLink(this.URL_BATTLEGROUP_SELECT);
			window.location.href = this.URL_BATTLEGROUP_SELECT;
        }

		if (cookieTSValue = getcookie2("armory.cookieTS")) {
			this.setTeamSizeParam(cookieTSValue);
			this.goToNextPage();
		}
    }


    this.goToNextPage = function(teamSize) {
        var url = this.URL_ARENA_LADDER;
        var params = "";

        if (this.paramBattlegroup){
				params = appendUrlParam(params, "b", this.paramBattlegroup);
		}

        setcookie("armory.cookieTS", teamSize);
        params = appendUrlParam(params, "ts", teamSize);

        if (this.paramTeamFilterField)
            params = appendUrlParam(params, "ff", this.paramTeamFilterField);
        if (this.paramTeamFilterValue){
			params = appendUrlParam(params, "fv", this.paramTeamFilterValue);
		}

		if (params)
            url = url + "?" + params;

        window.location = url;
    }

    this.setTeamSizeParam = function(newTeamSize) {
        if (this.paramTeamSize != newTeamSize) {
            this.paramTeamSize = newTeamSize;
            return true;
        }
        return false;
    }

    this.setTeamSize = function(newTeamSize) {
        if (this.setTeamSizeParam(newTeamSize)) {
			setcookie("armory.cookieTS", newTeamSize)
            this.goToNextPage();
        }
    }

    this.setBattlegroup = function(newBattlegroup) {
        if (this.setBattlegroupParam(newBattlegroup)) {
			setcookie("armory.cookieBG", newBattlegroup)
        }
    }

    this.setBattlegroupParam = function(newBattlegroup) {
        if (newBattlegroup != this.paramBattlegroup) {
            this.paramBattlegroup = newBattlegroup;
            return true;
        }
        return false;
    }
}
jsLoaded=true;//needed for ajax script loading
