--
-- Table structure for table `account_pass`
--

DROP TABLE IF EXISTS `account_pass`;
CREATE TABLE `account_pass` (
  `id` bigint(20) unsigned NOT NULL auto_increment COMMENT 'Identifier',
  `username` varchar(16) NOT NULL default '',
  `password` varchar(28) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Account System';
