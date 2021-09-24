// requires:
//
// armory.js
// cookies.js
//
// MFS NOTE: this file is DEPRECATED -- look in battlegroups-data.xsl for js calls

var selectBattlegroupPageInstance = new SelectBattlegroupPage();
//selectBattlegroupPageInstance.pageLoad();

function SelectBattlegroupPage() {

    this.URL_BATTLEGROUP_SELECT = "battlegroups.xml";
    this.URL_TEAMSIZE_SELECT = "select-team-type.xml";
    this.URL_ARENA_LADDER = "arena-ladder.xml";


	// initialize variables
    this.paramBattlegroup = queryString("b","");
    this.paramTeamSize = queryString("ts","");


    this.checkForRedirect = function() {
		if (this.paramTeamSize != "") {
			setcookie("armory.cookieTS", this.paramTeamSize);
		} else if (cookieTSValue = getcookie2("armory.cookieTS")) {
			this.setTeamSizeParam(cookieTSValue);
		}

		if (cookieBGValue = getcookie2("armory.cookieBG")) {
			this.setBattlegroupParam(cookieBGValue);
//			this.goToNextPage();
		}
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
        }
    }

    this.setBattlegroup = function(newBattlegroup) {
        if (setBattlegroupParam(newBattlegroup)) {
			setcookie("armory.cookieBG", newBattlegroup)	//change by akim newTeamSize->newBattlegroup
            this.goToNextPage();
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
