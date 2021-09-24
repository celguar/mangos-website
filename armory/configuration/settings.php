<?php
// for all options bellow: 1 - enable, 0 - disable
$config = array(
// MBA title
"Title" => "World of Warcraft Armory",
// Items Locale (0 = English, 1 = Korean, 2 = French, 3 = German, 4 = Chinese, 5 = Taiwanese, 6 = Spanish, 7 = Latin America, 8 = Russian) 
"locales" => 0,
// Top blue ruler
"Site_Name" => "World of Warcraft",
"Site_Link" => "../index.php",
"Forum_Link" => "../forum",
// Use login page
"Login" => 0,
// Use registration page
"Registration" => 1,
// External registration page link - if you don't set any, the armory will use its own registration page
"ExternalRegistrationPage" => "../index.php?n=account&sub=register",
// Number of account registrations per IP, 0 - no limits
"LockReg" => 0,
// Lock accout to IP after registration
"LockAcc" => 0,
// The gmlevel which new accounts have
"GmLevel" => 0,
// Show source information for items
"ShowSource" => 1,
// Show Random Enchantments for items
"ShowRandomEnch" => 1,
// Show Disenchant information for items
"ShowDisenchant" => 1,
// Show error messages for items
"ShowError" => 1,
// Results number for Honor Ranking page
"PvPTop" => 50,
// Results number for Arena Ranking page
"ArenaTop" => 50,
// Results number for Team Ranking page
"TeamTop" => 50,
// Exclude GMs (GM mode on) from results and top lists
"ExcludeGMs" => 0,
// Min number of characters used in search (this is not related to new javascript limitation to 2 chars)
"min_guild_search" => 2,
"min_arenateam_search" => 2,
"min_char_search" => 2,
"min_items_search" => 2,
// Results number per page
"results_per_page_guild" => 20,
"results_per_page_arenateam" => 20,
"results_per_page_char" => 20,
"results_per_page_items" => 15,
);
// Latest News showing on the main page
$news = array(
array("Latest News:","This is news one! Change in settings.php!"),
array("Latest News:","This is news two! Change in settings.php!"),
array("Latest News:","This is news three! Change in settings.php!")
);
?>