-- enable manual donations granting
ALTER TABLE `account_extend` DROP `donator`;
ALTER TABLE `account_extend` ADD `donator` INT( 1 ) NOT NULL DEFAULT '0';