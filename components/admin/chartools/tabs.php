<?php
//tables connected with character
$tab_characters = Array(
    Array("auctionhouse","itemowner"),
    Array("character_action","guid"),
    Array("character_gifts","guid"),
    Array("character_homebind","guid"),
    Array("character_inventory","guid"),
    Array("character_pet","owner"),
    Array("character_queststatus","guid"),
    Array("character_reputation","guid"),
    Array("character_spell","guid"),
    Array("corpse","player"),
    Array("item_instance","owner_guid"),
    Array("mail","receiver"),
    Array("mail_items","receiver"),
    Array("petition","ownerguid"),
    Array("characters","guid")
);

//tables connected with item_instance
$tab_items = Array(
	Array("auctionhouse","itemguid"),
	Array("character_gifts","item_guid"),
    Array("character_inventory","item"),
	Array("character_inventory","bag"),
	Array("mail_items","item_guid"),
	Array("petition","petitionguid")
);

//tables connected with character_pet
$tab_pets = Array(
    Array("pet_spell","guid")
);

//tables connected with mail
$tab_mails = Array(
    Array("mail_items","mail_id")
);

//tables connected with item_text
$tab_mail_texts = Array(
    Array("mail","itemTextId")
);

//main for change of guid
$tab_guid_change = Array(
    Array("characters","guid",$tab_characters),
    Array("item_instance","guid",$tab_items),
    Array("character_pet","id",$tab_pets),
    Array("mail","id",$tab_mails),
    Array("item_text","id",$tab_mail_texts)
);
?>