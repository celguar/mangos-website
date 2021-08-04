 /////////////-----------------------------\\\\\\\\\\\\\
/|-||-||||||---Mangos Web V3 Module System---|||||||-||-\
\|-||-||||||------------by: Nafe-------------|||||||-||-/
 \\\\\\\\\\\\\-----------------------------/////////////

//////////////////////\\\\\\\\\\\\\\\\\\\\\\\
\\\\\\\\\\\\\\\\\\\\\\///////////////////////

To install a pre-packaged module, simply copy the folder to /components/modules
Then delete your /core/cache/modules/[name].php

*These files must be deleted each time you add a module or edit menu or language entries.

//////////////////////\\\\\\\\\\\\\\\\\\\\\\\
\\\\\\\\\\\\\\\\\\\\\\///////////////////////

To develop one, place in a unique folder in /components/modules:
  [foldername].php       <-- this is the main functional file
  template.php           (template file loaded in the "main" section of the website layout)
  menuconfig.php         <-- see example
  config/config.xml      <-- any config values that you would like to set
                             these will be modifiable on the admin panel, provided that you also have language references
                                with keynames
In /components/modules/[foldername]/lang:
  .lang files            <-- contain any new language entries that you may have
                         *NOTE* these need to be set up as below to see the module in the menu.
                            Update: the module framework now sets a default name "[modulename] Module" if the language is not found.

/-------------------------------------------/
//////////To set up the lang files://////////
/-------------------------------------------/
If you plan to link to your addon somewhere, at least en.English.lang is required, with this first line:

|=|module_EXTNAME :=: MENUTEXT

    where EXTNAME is the [foldername], the extension's 'shortname'
      and MENUTEXT is the text to be displayed on the sidebar or context menu, the extension's "long name"

Each language file entry will follow the general format:
|=|LANGUAGEKEY :=: LANGUAGETEXT

It is recommended to chose a LANGUAGEKEY with something like MODULENAME_KEY.
Example:
|=|mailsystem_mailcontents :=: Mail Contents

/-------------------------------------------/
//////////To set up menuconfig.php://////////
/-------------------------------------------/
In menuconfig.php, place the following array.

$module_menu = array(
    'view'        => '', // g_ option require for view               [0]
    'sidebarmenu' => '', // main menu name/id ('' - not show)        [1]
    'contextmenu' => 0,  // show in context menu (1-yes,0-no)        [2]
);

'sidebarmenu' choices:
  '1-menuNews'
  '2-menuAccount'
  '3-menuGameGuide'
  '4-menuInteractive'
  '5-menuMedia'
  '6-menuForums'
  '7-menuCommunity'
  '8-menuSupport'
