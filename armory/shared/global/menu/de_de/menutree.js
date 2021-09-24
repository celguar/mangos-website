// Menu tree:
// MenuX=new Array("ItemText","Link","background image",number of sub elements,height,width,"bgcolor","bghighcolor",
//  "fontcolor","fonthighcolor","bordercolor","fontfamily",fontsize,fontbold,fontitalic,"textalign","statustext");
// Color and font variables defined in the menu tree take precedence over the global variables
// Fontsize, fontbold and fontitalic are ignored when set to -1.
// For rollover images ItemText or background image format is:  "rollover?"+BaseHref+"Image1.jpg?"+BaseHref+"Image2.jpg"


/*
Ra = function (v0,v1,v2,v3,v4,v5,v6,v7,v8,v9,v10,v11,v12,v13,v14,v15,v16) {
    //default Array values
    dv0="",dv1="",dv2="reg",dv3=0,dv4=20,dv5=140,dv6="",dv7="",dv8="",dv9="",dv10="",dv11="",dv12=-1,dv13=-1,dv14=-1,dv15="",dv16="";
    if(v1.charAt(0)=='default.htm')v1="www.worldofwarcraft.com/default.htm"+v1;
    for(i=0;i<17;i++) if(eval("v"+i))eval("this["+i+"]=v"+i);else eval("this["+i+"]=dv"+i);
    return true;
};
*/

dv0="",dv1="",dv2="reg",dv3=0,dv4=20,dv5=140,dv6="",dv7="",dv8="",dv9="",dv10="",dv11="",dv12=-1,dv13=-1,dv14=-1,dv15="",dv16="";


Menu1=new Array("WoW Site","default.htm","reg",8,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);

/*News Menu_*/
Menu1_1=new Array("News","default.htm","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);


/*Account Menu_*/
Menu1_2=new Array("Account","account/default.htm","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);


/*Game Guide Menu_*/
Menu1_3=new Array("Game Guide","info/default.htm","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);

/*Workshop Menu1_*/
Menu1_4=new Array("Workshop","","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
Menu1_4_1=new Array("Armory","index.php","reg",7,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
    Menu1_4_1_1=new Array("Charakterprofile","index.php?searchType=characters","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
    Menu1_4_1_2=new Array("Gildenprofile","index.php?searchType=guilds","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
	Menu1_4_1_3=new Array("Teamprofile","index.php?searchType=arenateams","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
	Menu1_4_1_4=new Array("Ehrerangliste","index.php?searchType=honor","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
    Menu1_4_1_5=new Array("Arenarangliste","index.php?searchType=arena","reg",3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);        
        Menu1_4_1_5_1=new Array("2v2 Arenarangliste","index.php?searchType=arena&type=2","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
		Menu1_4_1_5_2=new Array("3v3 Arenarangliste","index.php?searchType=arena&type=3","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
		Menu1_4_1_5_3=new Array("5v5 Arenarangliste","index.php?searchType=arena&type=5","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
	Menu1_4_1_6=new Array("Teamrangliste","index.php?searchType=team","reg",3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
		Menu1_4_1_6_1=new Array("2v2 Teamrangliste","index.php?searchType=team&type=2","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
		Menu1_4_1_6_2=new Array("3v3 Teamrangliste","index.php?searchType=team&type=3","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
		Menu1_4_1_6_3=new Array("5v5 Teamrangliste","index.php?searchType=team&type=5","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
    Menu1_4_1_7=new Array("Gegenst&auml;nde","index.php?searchType=items","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);


/*Media Menu1_*/
Menu1_5=new Array("Media","downloads/default.htm","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);

  
  
/*Forums Menu1_*/
Menu1_6=new Array("Forums","forums.worldofwarcraft.com/default.htm","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
  

/*Community Menu1_*/
Menu1_7=new Array("Community","community/default.htm","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);



/*Support Menu1_*/
Menu1_8=new Array("Support","www.blizzard.com/support/wowindex/default.htm","reg",dv3,dv4,dv5,dv6,dv7,dv8,dv9,dv10,dv11,dv12,dv13,dv14,dv15,dv16);
  
