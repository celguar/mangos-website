<br>
<?php builddiv_start(1, "Teamspeak") ?>
<style type="text/css">
#teamspeakdisplay  img {
    border: 0px;
}
#teamspeakdisplay span {
    font: 9pt arial, verdana,helvetica;
    padding: 0px;
    white-space: nowrap;
    vertical-align: top;
}
#teamspeakdisplay span.teamspeakserver {
    padding-left: 3px;
    font-weight: bold;
}
#teamspeakdisplay span.teamspeakchannel {
    padding-left: 3px;
}
#teamspeakdisplay span.teamspeaksubchannel {
    padding-left: 3px;
}
#teamspeakdisplay span.teamspeakplayer {
    padding-left: 3px;
}
#teamspeakdisplay a.teamspeakserver {
    font: 9pt arial, verdana,helvetica;
    font-weight: bold;
    text-decoration: none;
    color: #000000;
}
#teamspeakdisplay a.teamspeakserver:hover {
    color: #000066;
}
#teamspeakdisplay a.teamspeakchannel {
    font: 9pt arial, verdana,helvetica;
    font-weight: bold;
    text-decoration: none;
    color: #000000;
}
#teamspeakdisplay a.teamspeakchannel:hover {
    color: #000066;
}
#teamspeakdisplay a.teamspeaksubchannel {
    font: 9pt arial, verdana,helvetica;
    font-weight: bold;
    text-decoration: none;
    color: #000000;
}
#teamspeakdisplay a.teamspeaksubchannel:hover {
    color: #000066;
}
</style>
<?php echo $display ?>
<?php builddiv_end() ?>