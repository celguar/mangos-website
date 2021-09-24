--
-- Definition of table `cache_item`
--

DROP TABLE IF EXISTS `cache_item`;
CREATE TABLE `cache_item` (
  `item_id` int(10) unsigned NOT NULL default '0',
  `mangosdbkey` int(10) unsigned NOT NULL default '0',
  `item_name` varchar(255) NOT NULL,
  `item_quality` int(1) unsigned NOT NULL default '0',
  `item_icon` varchar(255) NOT NULL,
  PRIMARY KEY  (`item_id`,`mangosdbkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cache table for general item information';

--
-- Definition of table `cache_item_char`
--

DROP TABLE IF EXISTS `cache_item_char`;
CREATE TABLE `cache_item_char` (
  `item_guid` int(10) unsigned NOT NULL default '0',
  `chardbkey` int(10) unsigned NOT NULL default '0',
  `item_owner` int(10) unsigned NOT NULL default '0',
  `item_slot` int(10) unsigned NOT NULL default '0',
  `item_html` text NOT NULL,
  PRIMARY KEY  (`item_guid`,`chardbkey`,`item_owner`),
  KEY `chardbkey` (`chardbkey`,`item_owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cache table for character item information';

--
-- Definition of table `cache_item_search`
--

DROP TABLE IF EXISTS `cache_item_search`;
CREATE TABLE `cache_item_search` (
  `item_id` int(10) unsigned NOT NULL default '0',
  `mangosdbkey` int(10) unsigned NOT NULL default '0',
  `item_name` varchar(255) NOT NULL,
  `item_level` int(10) unsigned NOT NULL default '0',
  `item_source` varchar(255) NOT NULL,
  `item_relevance` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`item_id`,`mangosdbkey`),
  KEY `mangosdbkey` (`mangosdbkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cache table for item search information';

--
-- Definition of table `cache_item_tooltip`
--

DROP TABLE IF EXISTS `cache_item_tooltip`;
CREATE TABLE `cache_item_tooltip` (
  `item_id` int(10) unsigned NOT NULL default '0',
  `mangosdbkey` int(10) unsigned NOT NULL default '0',
  `item_html` text NOT NULL,
  `item_info_html` text NOT NULL,
  PRIMARY KEY  (`item_id`,`mangosdbkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cache table for item tooltip information';
