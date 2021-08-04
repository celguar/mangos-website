--
-- Add Ra information to realmlist table
-- Very important that this is in the end, along with ADD ALTERS. Because if
-- file gets applied again, it gets an error here.
--

ALTER TABLE `realmlist` 
ADD `ra_port` int(5) NOT NULL default '3443',
ADD `ra_user` VARCHAR( 355 ) NOT NULL default 'username',
ADD `ra_pass` VARCHAR( 355 ) NOT NULL default 'password';