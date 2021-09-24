//Create Tooltips
  if (arenaTeamArray[2]) {
	arenaTeamRank = arenaTeamArray[2][2];
	if (arenaTeamRank == 0)
		arenaTeamRank = textNotRanked;
	theTeamStats = "<span class = 'tooltipContentSpecial'>"+ textStandingColon +" <span class = 'myWhite'>"+ arenaTeamRank + "</span></span><span class = 'tooltipContentSpecial'>"+ textRatingColon +" <span class = 'myWhite'>" + arenaTeamArray[2][4] + "</span></span>";
	getArenaIconBorder(2, 'badgeBorder2v2team');
	tooltip2v2team = "<span class = 'tooltipTitle'>"+ text2v2Arena +"</span><span class = 'tooltipContentSpecial'>"+ textTeamNameColon +" <span class = 'myWhite'>"+ arenaTeamArray[2][0] + "</span></span>"+ theTeamStats;
  }


  if (arenaTeamArray[3]) {
	arenaTeamRank = arenaTeamArray[3][2];
	if (arenaTeamRank == 0)
		arenaTeamRank = textNotRanked;
	theTeamStats = "<span class = 'tooltipContentSpecial'>"+ textStandingColon +" <span class = 'myWhite'>"+ arenaTeamRank + "</span></span><span class = 'tooltipContentSpecial'>"+ textRatingColon +" <span class = 'myWhite'>" + arenaTeamArray[3][4] + "</span></span>";
	getArenaIconBorder(3, 'badgeBorder3v3team');
	tooltip3v3team = "<span class = 'tooltipTitle'>"+ text3v3Arena +"</span><span class = 'tooltipContentSpecial'>"+ textTeamNameColon +" <span class = 'myWhite'>"+ arenaTeamArray[3][0] + "</span></span>"+ theTeamStats;
  }

  if (arenaTeamArray[5]) {
	arenaTeamRank = arenaTeamArray[5][2];
	if (arenaTeamRank == 0)
		arenaTeamRank = textNotRanked;	
	theTeamStats = "<span class = 'tooltipContentSpecial'>"+ textStandingColon +" <span class = 'myWhite'>"+ arenaTeamRank + "</span></span><span class = 'tooltipContentSpecial'>"+ textRatingColon +" <span class = 'myWhite'>" + arenaTeamArray[5][4] + "</span></span>";
	getArenaIconBorder(5, 'badgeBorder5v5team');
	tooltip5v5team = "<span class = 'tooltipTitle'>"+ text5v5Arena +"</span><span class = 'tooltipContentSpecial'>"+ textTeamNameColon +" <span class = 'myWhite'>"+ arenaTeamArray[5][0] + "</span></span>"+ theTeamStats;
  }
//end create tooltips

  
 jsLoaded=true;