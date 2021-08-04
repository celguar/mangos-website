-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.45-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema characters_temp
--

CREATE DATABASE IF NOT EXISTS characters_temp;
USE characters_temp;

--
-- Definition of table `auctionhouse`
--

DROP TABLE IF EXISTS `auctionhouse`;
CREATE TABLE `auctionhouse` (
  `id` int(11) unsigned NOT NULL default '0',
  `auctioneerguid` int(11) unsigned NOT NULL default '0',
  `itemguid` int(11) unsigned NOT NULL default '0',
  `item_template` int(11) unsigned NOT NULL default '0' COMMENT 'Item Identifier',
  `itemowner` int(11) unsigned NOT NULL default '0',
  `buyoutprice` int(11) NOT NULL default '0',
  `time` bigint(40) NOT NULL default '0',
  `buyguid` int(11) unsigned NOT NULL default '0',
  `lastbid` int(11) NOT NULL default '0',
  `startbid` int(11) NOT NULL default '0',
  `deposit` int(11) NOT NULL default '0',
  `location` tinyint(3) unsigned NOT NULL default '3'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auctionhouse`
--

/*!40000 ALTER TABLE `auctionhouse` DISABLE KEYS */;
/*!40000 ALTER TABLE `auctionhouse` ENABLE KEYS */;



--
-- Definition of table `characters`
--

DROP TABLE IF EXISTS `characters`;
CREATE TABLE `characters` (
  `guid` int(11) unsigned NOT NULL default '0' COMMENT 'Global Unique Identifier',
  `account` int(11) unsigned NOT NULL default '0' COMMENT 'Account Identifier',
  `data` longtext,
  `name` varchar(12) NOT NULL default '',
  `race` tinyint(3) unsigned NOT NULL default '0',
  `class` tinyint(3) unsigned NOT NULL default '0',
  `position_x` float NOT NULL default '0',
  `position_y` float NOT NULL default '0',
  `position_z` float NOT NULL default '0',
  `map` int(11) unsigned NOT NULL default '0' COMMENT 'Map Identifier',
  `dungeon_difficulty` tinyint(1) unsigned NOT NULL default '0',
  `orientation` float NOT NULL default '0',
  `taximask` longtext,
  `online` tinyint(3) unsigned NOT NULL default '0',
  `cinematic` tinyint(3) unsigned NOT NULL default '0',
  `totaltime` int(11) unsigned NOT NULL default '0',
  `leveltime` int(11) unsigned NOT NULL default '0',
  `logout_time` bigint(20) unsigned NOT NULL default '0',
  `is_logout_resting` tinyint(3) unsigned NOT NULL default '0',
  `rest_bonus` float NOT NULL default '0',
  `resettalents_cost` int(11) unsigned NOT NULL default '0',
  `resettalents_time` bigint(20) unsigned NOT NULL default '0',
  `trans_x` float NOT NULL default '0',
  `trans_y` float NOT NULL default '0',
  `trans_z` float NOT NULL default '0',
  `trans_o` float NOT NULL default '0',
  `transguid` bigint(20) unsigned NOT NULL default '0',
  `extra_flags` int(11) unsigned NOT NULL default '0',
  `stable_slots` tinyint(1) unsigned NOT NULL default '0',
  `at_login` int(11) unsigned NOT NULL default '0',
  `zone` int(11) unsigned NOT NULL default '0',
  `death_expire_time` bigint(20) unsigned NOT NULL default '0',
  `taxi_path` text,
  `arena_pending_points` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Player System';

--
-- Dumping data for table `characters`
--

/*!40000 ALTER TABLE `characters` DISABLE KEYS */;
/*!40000 ALTER TABLE `characters` ENABLE KEYS */;



--
-- Definition of table `character_action`
--

DROP TABLE IF EXISTS `character_action`;
CREATE TABLE `character_action` (
  `guid` int(11) unsigned NOT NULL default '0' COMMENT 'Global Unique Identifier',
  `button` tinyint(3) unsigned NOT NULL default '0',
  `action` smallint(5) unsigned NOT NULL default '0',
  `type` tinyint(3) unsigned NOT NULL default '0',
  `misc` tinyint(3) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Player System';

--
-- Dumping data for table `character_action`
--

/*!40000 ALTER TABLE `character_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_action` ENABLE KEYS */;


--
-- Definition of table `character_gifts`
--

DROP TABLE IF EXISTS `character_gifts`;
CREATE TABLE `character_gifts` (
  `guid` int(20) unsigned NOT NULL default '0',
  `item_guid` int(11) unsigned NOT NULL default '0',
  `entry` int(20) unsigned NOT NULL default '0',
  `flags` int(20) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `character_gifts`
--

/*!40000 ALTER TABLE `character_gifts` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_gifts` ENABLE KEYS */;


--
-- Definition of table `character_homebind`
--

DROP TABLE IF EXISTS `character_homebind`;
CREATE TABLE `character_homebind` (
  `guid` int(11) unsigned NOT NULL default '0' COMMENT 'Global Unique Identifier',
  `map` int(11) unsigned NOT NULL default '0' COMMENT 'Map Identifier',
  `zone` int(11) unsigned NOT NULL default '0' COMMENT 'Zone Identifier',
  `position_x` float NOT NULL default '0',
  `position_y` float NOT NULL default '0',
  `position_z` float NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Player System';

--
-- Dumping data for table `character_homebind`
--

/*!40000 ALTER TABLE `character_homebind` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_homebind` ENABLE KEYS */;


--
-- Definition of table `character_inventory`
--

DROP TABLE IF EXISTS `character_inventory`;
CREATE TABLE `character_inventory` (
  `guid` int(11) unsigned NOT NULL default '0' COMMENT 'Global Unique Identifier',
  `bag` int(11) unsigned NOT NULL default '0',
  `slot` tinyint(3) unsigned NOT NULL default '0',
  `item` int(11) unsigned NOT NULL default '0' COMMENT 'Item Global Unique Identifier',
  `item_template` int(11) unsigned NOT NULL default '0' COMMENT 'Item Identifier'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Player System';

--
-- Dumping data for table `character_inventory`
--

/*!40000 ALTER TABLE `character_inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_inventory` ENABLE KEYS */;


--
-- Definition of table `character_pet`
--

DROP TABLE IF EXISTS `character_pet`;
CREATE TABLE `character_pet` (
  `id` int(11) unsigned NOT NULL default '0',
  `entry` int(11) unsigned NOT NULL default '0',
  `owner` int(11) unsigned NOT NULL default '0',
  `modelid` int(11) unsigned default '0',
  `CreatedBySpell` int(11) unsigned NOT NULL default '0',
  `PetType` tinyint(3) unsigned NOT NULL default '0',
  `level` int(11) unsigned NOT NULL default '1',
  `exp` int(11) unsigned NOT NULL default '0',
  `Reactstate` tinyint(1) unsigned NOT NULL default '0',
  `loyaltypoints` int(11) NOT NULL default '0',
  `loyalty` int(11) unsigned NOT NULL default '0',
  `trainpoint` int(11) NOT NULL default '0',
  `name` varchar(100) default 'Pet',
  `renamed` tinyint(1) unsigned NOT NULL default '0',
  `slot` int(11) unsigned NOT NULL default '0',
  `curhealth` int(11) unsigned NOT NULL default '1',
  `curmana` int(11) unsigned NOT NULL default '0',
  `curhappiness` int(11) unsigned NOT NULL default '0',
  `savetime` bigint(20) unsigned NOT NULL default '0',
  `resettalents_cost` int(11) unsigned NOT NULL default '0',
  `resettalents_time` bigint(20) unsigned NOT NULL default '0',
  `abdata` longtext,
  `teachspelldata` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Pet System';

--
-- Dumping data for table `character_pet`
--

/*!40000 ALTER TABLE `character_pet` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_pet` ENABLE KEYS */;


--
-- Definition of table `character_queststatus`
--

DROP TABLE IF EXISTS `character_queststatus`;
CREATE TABLE `character_queststatus` (
  `guid` int(11) unsigned NOT NULL default '0' COMMENT 'Global Unique Identifier',
  `quest` int(11) unsigned NOT NULL default '0' COMMENT 'Quest Identifier',
  `status` int(11) unsigned NOT NULL default '0',
  `rewarded` tinyint(1) unsigned NOT NULL default '0',
  `explored` tinyint(1) unsigned NOT NULL default '0',
  `timer` bigint(20) unsigned NOT NULL default '0',
  `mobcount1` int(11) unsigned NOT NULL default '0',
  `mobcount2` int(11) unsigned NOT NULL default '0',
  `mobcount3` int(11) unsigned NOT NULL default '0',
  `mobcount4` int(11) unsigned NOT NULL default '0',
  `itemcount1` int(11) unsigned NOT NULL default '0',
  `itemcount2` int(11) unsigned NOT NULL default '0',
  `itemcount3` int(11) unsigned NOT NULL default '0',
  `itemcount4` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Player System';

--
-- Dumping data for table `character_queststatus`
--

/*!40000 ALTER TABLE `character_queststatus` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_queststatus` ENABLE KEYS */;


--
-- Definition of table `character_reputation`
--

DROP TABLE IF EXISTS `character_reputation`;
CREATE TABLE `character_reputation` (
  `guid` int(11) unsigned NOT NULL default '0' COMMENT 'Global Unique Identifier',
  `faction` int(11) unsigned NOT NULL default '0',
  `standing` int(11) NOT NULL default '0',
  `flags` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Player System';

--
-- Dumping data for table `character_reputation`
--

/*!40000 ALTER TABLE `character_reputation` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_reputation` ENABLE KEYS */;


--
-- Definition of table `character_spell`
--

DROP TABLE IF EXISTS `character_spell`;
CREATE TABLE `character_spell` (
  `guid` int(11) unsigned NOT NULL default '0' COMMENT 'Global Unique Identifier',
  `spell` int(11) unsigned NOT NULL default '0' COMMENT 'Spell Identifier',
  `slot` int(11) unsigned NOT NULL default '0',
  `active` tinyint(3) unsigned NOT NULL default '1',
  `disabled` tinyint(3) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Player System';

--
-- Dumping data for table `character_spell`
--

/*!40000 ALTER TABLE `character_spell` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_spell` ENABLE KEYS */;

--
-- Definition of table `corpse`
--

DROP TABLE IF EXISTS `corpse`;
CREATE TABLE `corpse` (
  `guid` int(11) unsigned NOT NULL default '0' COMMENT 'Global Unique Identifier',
  `player` int(11) unsigned NOT NULL default '0' COMMENT 'Character Global Unique Identifier',
  `position_x` float NOT NULL default '0',
  `position_y` float NOT NULL default '0',
  `position_z` float NOT NULL default '0',
  `orientation` float NOT NULL default '0',
  `zone` int(11) unsigned NOT NULL default '38' COMMENT 'Zone Identifier',
  `map` int(11) unsigned NOT NULL default '0' COMMENT 'Map Identifier',
  `data` longtext,
  `time` bigint(20) unsigned NOT NULL default '0',
  `corpse_type` tinyint(3) unsigned NOT NULL default '0',
  `instance` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Death System';

--
-- Dumping data for table `corpse`
--

/*!40000 ALTER TABLE `corpse` DISABLE KEYS */;
/*!40000 ALTER TABLE `corpse` ENABLE KEYS */;


--
-- Definition of table `item_instance`
--

DROP TABLE IF EXISTS `item_instance`;
CREATE TABLE `item_instance` (
  `guid` int(11) unsigned NOT NULL default '0',
  `owner_guid` int(11) unsigned NOT NULL default '0',
  `data` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Item System';

--
-- Dumping data for table `item_instance`
--

/*!40000 ALTER TABLE `item_instance` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_instance` ENABLE KEYS */;


--
-- Definition of table `item_text`
--

DROP TABLE IF EXISTS `item_text`;
CREATE TABLE `item_text` (
  `id` int(11) unsigned NOT NULL default '0',
  `text` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='Item System';

--
-- Dumping data for table `item_text`
--

/*!40000 ALTER TABLE `item_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_text` ENABLE KEYS */;


--
-- Definition of table `mail`
--

DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail` (
  `id` int(11) unsigned NOT NULL default '0',
  `messageType` tinyint(3) unsigned NOT NULL default '0',
  `stationery` tinyint(3) NOT NULL default '41',
  `mailTemplateId` mediumint(8) unsigned NOT NULL default '0',
  `sender` int(11) unsigned NOT NULL default '0' COMMENT 'Character Global Unique Identifier',
  `receiver` int(11) unsigned NOT NULL default '0' COMMENT 'Character Global Unique Identifier',
  `subject` longtext,
  `itemTextId` int(11) unsigned NOT NULL default '0',
  `has_items` tinyint(3) unsigned NOT NULL default '0',
  `expire_time` bigint(40) NOT NULL default '0',
  `deliver_time` bigint(40) NOT NULL default '0',
  `money` int(11) unsigned NOT NULL default '0',
  `cod` int(11) unsigned NOT NULL default '0',
  `checked` tinyint(3) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Mail System';

--
-- Dumping data for table `mail`
--

/*!40000 ALTER TABLE `mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail` ENABLE KEYS */;


--
-- Definition of table `mail_items`
--

DROP TABLE IF EXISTS `mail_items`;
CREATE TABLE `mail_items` (
  `mail_id` int(11) NOT NULL default '0',
  `item_guid` int(11) NOT NULL default '0',
  `item_template` int(11) NOT NULL default '0',
  `receiver` int(11) unsigned NOT NULL default '0' COMMENT 'Character Global Unique Identifier'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mail_items`
--

/*!40000 ALTER TABLE `mail_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_items` ENABLE KEYS */;


--
-- Definition of table `pet_spell`
--

DROP TABLE IF EXISTS `pet_spell`;
CREATE TABLE `pet_spell` (
  `guid` int(11) unsigned NOT NULL default '0' COMMENT 'Global Unique Identifier',
  `spell` int(11) unsigned NOT NULL default '0' COMMENT 'Spell Identifier',
  `slot` int(11) unsigned NOT NULL default '0',
  `active` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Pet System';

--
-- Dumping data for table `pet_spell`
--

/*!40000 ALTER TABLE `pet_spell` DISABLE KEYS */;
/*!40000 ALTER TABLE `pet_spell` ENABLE KEYS */;


--
-- Definition of table `petition`
--

DROP TABLE IF EXISTS `petition`;
CREATE TABLE `petition` (
  `ownerguid` int(10) unsigned NOT NULL,
  `petitionguid` int(10) unsigned default '0',
  `name` varchar(255) NOT NULL default '',
  `type` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Guild System';

--
-- Dumping data for table `petition`
--

/*!40000 ALTER TABLE `petition` DISABLE KEYS */;
/*!40000 ALTER TABLE `petition` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
