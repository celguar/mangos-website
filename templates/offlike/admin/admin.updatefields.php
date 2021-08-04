<br>
<?php builddiv_start(0, "Update Server Data Fields") ?>
This tool allows you to Sync all the datafields stored in the website, With the current database. Doing this will fix issues caused by updates to 
the character database, that modify any and all data fields.
<br />
<br />
Make sure you replace the "./core/mangos_scripts/scripts/updatefields.h" with you servers new updafields.h "./your downloaded trinity-mangos server 
folder/src/game/updatefields.h" before using this tool.
<br />
<br />
<a href="<?php (string) $MW->getConfig->temp->base_href; ?>core/mangos_scripts/updatefields_parser.php">Click Here To UpdateFields</a>
<?php builddiv_end() ?>