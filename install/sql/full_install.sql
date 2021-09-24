SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `acc_creation_captcha`
-- ----------------------------
DROP TABLE IF EXISTS `acc_creation_captcha`;
CREATE TABLE `acc_creation_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(200) NOT NULL DEFAULT '',
  `filekey` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acc_creation_captcha
-- ----------------------------

-- ----------------------------
-- Table structure for `account_extend`
-- ----------------------------
DROP TABLE IF EXISTS `account_extend`;
CREATE TABLE `account_extend` (
  `account_id` int(11) unsigned NOT NULL,
  `character_id` int(11) unsigned DEFAULT NULL,
  `character_name` varchar(12) DEFAULT NULL,
  `g_id` smallint(5) unsigned NOT NULL DEFAULT '2',
  `avatar` varchar(60) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `homepage` varchar(100) DEFAULT NULL,
  `icq` varchar(12) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `signature` text,
  `hideemail` tinyint(1) NOT NULL DEFAULT '1',
  `hideprofile` tinyint(1) NOT NULL DEFAULT '0',
  `theme` smallint(5) unsigned NOT NULL DEFAULT '0',
  `forum_posts` int(10) unsigned NOT NULL DEFAULT '0',
  `registration_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `activation_code` varchar(40) DEFAULT NULL,
  `msn` varchar(255) DEFAULT NULL,
  `secretq1` varchar(300) NOT NULL DEFAULT '0',
  `secreta1` varchar(300) NOT NULL DEFAULT '0',
  `secretq2` varchar(300) NOT NULL DEFAULT '0',
  `secreta2` varchar(300) NOT NULL DEFAULT '0',
  `vip` int(1) NOT NULL DEFAULT '0',
  `donator` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_extend
-- ----------------------------

-- ----------------------------
-- Table structure for `account_groups`
-- ----------------------------
DROP TABLE IF EXISTS `account_groups`;
CREATE TABLE `account_groups` (
  `g_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `g_title` varchar(32) NOT NULL,
  `g_prefix` char(6) DEFAULT NULL,
  `g_is_admin` tinyint(1) DEFAULT '0',
  `g_is_supadmin` tinyint(1) DEFAULT '0',
  `g_use_search` tinyint(1) DEFAULT '0',
  `g_view_profile` tinyint(1) DEFAULT '0',
  `g_post_new_topics` tinyint(1) DEFAULT '0',
  `g_reply_other_topics` tinyint(1) DEFAULT '0',
  `g_use_attach` tinyint(1) DEFAULT '0',
  `g_edit_own_posts` tinyint(1) DEFAULT '0',
  `g_delete_own_posts` tinyint(1) DEFAULT '0',
  `g_delete_own_topics` tinyint(1) DEFAULT '0',
  `g_forum_moderate` tinyint(1) NOT NULL DEFAULT '0',
  `g_use_pm` tinyint(1) DEFAULT '0',
  `g_gal_view` tinyint(1) NOT NULL DEFAULT '0',
  `g_gal_upload` tinyint(1) DEFAULT '0',
  `g_gal_download` tinyint(1) DEFAULT '0',
  `g_gal_moderate` tinyint(1) DEFAULT '0',
  `g_gal_balanceon` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`g_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_groups
-- ----------------------------
INSERT INTO `account_groups` VALUES ('1', 'Guests', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0');
INSERT INTO `account_groups` VALUES ('2', 'Members', null, '0', '0', '1', '1', '1', '1', '1', '1', '1', '0', '0', '1', '1', '1', '1', '0', '1');
INSERT INTO `account_groups` VALUES ('3', 'Administrators', '+', '1', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0');
INSERT INTO `account_groups` VALUES ('4', 'Root Admins', '&#165;', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0');
INSERT INTO `account_groups` VALUES ('5', 'Banned', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `account_keys`
-- ----------------------------
DROP TABLE IF EXISTS `account_keys`;
CREATE TABLE `account_keys` (
  `id` int(11) unsigned NOT NULL,
  `key` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `assign_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_keys
-- ----------------------------

-- ----------------------------
-- Table structure for `donations_template`
-- ----------------------------
DROP TABLE IF EXISTS `donations_template`;
CREATE TABLE `donations_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `donation` varchar(255) NOT NULL,
  `items` varchar(4000) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `description` varchar(255) NOT NULL,
  `itemset` varchar(1000) NOT NULL,
  `realm` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of donations_template
-- ----------------------------

-- ----------------------------
-- Table structure for `gallery`
-- ----------------------------
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE `gallery` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `img` text NOT NULL,
  `comment` text NOT NULL,
  `autor` text NOT NULL,
  `date` date NOT NULL,
  `cat` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gallery
-- ----------------------------
INSERT INTO `gallery` VALUES ('1', 'Mangosweb_wall.jpg', 'Test Wallpaper', 'MangosWeb', '0000-00-00', 'wallpaper');
INSERT INTO `gallery` VALUES ('2', 'Mangosweb_scr.jpg', 'Test Screenshot', 'MangosWeb', '0000-00-00', 'screenshot');

-- ----------------------------
-- Table structure for `gallery_ssotd`
-- ----------------------------
DROP TABLE IF EXISTS `gallery_ssotd`;
CREATE TABLE `gallery_ssotd` (
  `image` varchar(50) NOT NULL,
  `date` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gallery_ssotd
-- ----------------------------
INSERT INTO `gallery_ssotd` VALUES ('asdf', 'asdf');

-- ----------------------------
-- Table structure for `online`
-- ----------------------------
DROP TABLE IF EXISTS `online`;
CREATE TABLE `online` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_name` varchar(200) NOT NULL DEFAULT 'Guest',
  `user_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `logged` int(10) NOT NULL DEFAULT '0',
  `currenturl` varchar(255) NOT NULL DEFAULT './',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of online
-- ----------------------------

-- ----------------------------
-- Table structure for `paypal_cart_info`
-- ----------------------------
DROP TABLE IF EXISTS `paypal_cart_info`;
CREATE TABLE `paypal_cart_info` (
  `txnid` varchar(30) NOT NULL DEFAULT '',
  `itemname` varchar(255) NOT NULL DEFAULT '',
  `itemnumber` varchar(50) DEFAULT NULL,
  `os0` varchar(20) DEFAULT NULL,
  `on0` varchar(50) DEFAULT NULL,
  `os1` varchar(20) DEFAULT NULL,
  `on1` varchar(50) DEFAULT NULL,
  `quantity` char(3) NOT NULL DEFAULT '',
  `invoice` varchar(255) NOT NULL DEFAULT '',
  `custom` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paypal_cart_info
-- ----------------------------

-- ----------------------------
-- Table structure for `paypal_payment_info`
-- ----------------------------
DROP TABLE IF EXISTS `paypal_payment_info`;
CREATE TABLE `paypal_payment_info` (
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `buyer_email` varchar(100) NOT NULL DEFAULT '',
  `street` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `state` char(3) NOT NULL DEFAULT '',
  `zipcode` varchar(11) NOT NULL DEFAULT '',
  `memo` varchar(255) DEFAULT NULL,
  `itemname` varchar(255) DEFAULT NULL,
  `itemnumber` varchar(50) DEFAULT NULL,
  `os0` varchar(20) DEFAULT NULL,
  `on0` varchar(50) DEFAULT NULL,
  `os1` varchar(20) DEFAULT NULL,
  `on1` varchar(50) DEFAULT NULL,
  `quantity` char(3) DEFAULT NULL,
  `paymentdate` varchar(50) NOT NULL DEFAULT '',
  `paymenttype` varchar(10) NOT NULL DEFAULT '',
  `txnid` varchar(30) NOT NULL DEFAULT '',
  `mc_gross` varchar(6) NOT NULL DEFAULT '',
  `mc_fee` varchar(5) NOT NULL DEFAULT '',
  `paymentstatus` varchar(15) NOT NULL DEFAULT '',
  `pendingreason` varchar(10) DEFAULT NULL,
  `txntype` varchar(10) NOT NULL DEFAULT '',
  `tax` varchar(10) DEFAULT NULL,
  `mc_currency` varchar(5) NOT NULL DEFAULT '',
  `reasoncode` varchar(20) NOT NULL DEFAULT '',
  `custom` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(20) NOT NULL DEFAULT '',
  `datecreation` date NOT NULL DEFAULT '0000-00-00',
  `item_given` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paypal_payment_info
-- ----------------------------

-- ----------------------------
-- Table structure for `paypal_subscription_info`
-- ----------------------------
DROP TABLE IF EXISTS `paypal_subscription_info`;
CREATE TABLE `paypal_subscription_info` (
  `subscr_id` varchar(255) NOT NULL DEFAULT '',
  `sub_event` varchar(50) NOT NULL DEFAULT '',
  `subscr_date` varchar(255) NOT NULL DEFAULT '',
  `subscr_effective` varchar(255) NOT NULL DEFAULT '',
  `period1` varchar(255) NOT NULL DEFAULT '',
  `period2` varchar(255) NOT NULL DEFAULT '',
  `period3` varchar(255) NOT NULL DEFAULT '',
  `amount1` varchar(255) NOT NULL DEFAULT '',
  `amount2` varchar(255) NOT NULL DEFAULT '',
  `amount3` varchar(255) NOT NULL DEFAULT '',
  `mc_amount1` varchar(255) NOT NULL DEFAULT '',
  `mc_amount2` varchar(255) NOT NULL DEFAULT '',
  `mc_amount3` varchar(255) NOT NULL DEFAULT '',
  `recurring` varchar(255) NOT NULL DEFAULT '',
  `reattempt` varchar(255) NOT NULL DEFAULT '',
  `retry_at` varchar(255) NOT NULL DEFAULT '',
  `recur_times` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) DEFAULT NULL,
  `payment_txn_id` varchar(50) NOT NULL DEFAULT '',
  `subscriber_emailaddress` varchar(255) NOT NULL DEFAULT '',
  `datecreation` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paypal_subscription_info
-- ----------------------------

-- ----------------------------
-- Table structure for `pms`
-- ----------------------------
DROP TABLE IF EXISTS `pms`;
CREATE TABLE `pms` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(8) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `message` text,
  `sender_id` int(8) unsigned NOT NULL DEFAULT '0',
  `posted` int(10) unsigned NOT NULL DEFAULT '0',
  `sender_ip` varchar(15) DEFAULT '0.0.0.0',
  `showed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pms
-- ----------------------------

-- ----------------------------
-- Table structure for `site_regkeys`
-- ----------------------------
DROP TABLE IF EXISTS `site_regkeys`;
CREATE TABLE `site_regkeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `used` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_regkeys
-- ----------------------------

-- ----------------------------
-- Table structure for `voting`
-- ----------------------------
DROP TABLE IF EXISTS `voting`;
CREATE TABLE `voting` (
  `user_ip` varchar(30) NOT NULL,
  `sites` int(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of voting
-- ----------------------------

-- ----------------------------
-- Table structure for `voting_points`
-- ----------------------------
DROP TABLE IF EXISTS `voting_points`;
CREATE TABLE `voting_points` (
  `id` bigint(20) unsigned NOT NULL,
  `points` smallint(5) unsigned NOT NULL DEFAULT '0',
  `date` varchar(8) NOT NULL DEFAULT '20081214',
  `date_points` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `times_voted` smallint(5) NOT NULL DEFAULT '0',
  `points_earned` bigint(20) NOT NULL DEFAULT '0',
  `points_spent` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `voting_rewards`;
CREATE TABLE `voting_rewards` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `item_id` decimal(10,0) NOT NULL,
  `quanity` decimal(10,0) NOT NULL,
  `cost` decimal(10,0) NOT NULL,
  `quality` decimal(10,0) NOT NULL,
  `reward_text` varchar(255) NOT NULL,
  `realmid` decimal(10,0) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `voting_sites`;
CREATE TABLE `voting_sites` (
  `id` int(11) unsigned NOT NULL DEFAULT '0',
  `hostname` varchar(255) NOT NULL,
  `votelink` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `points` decimal(10,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `world_entries`;
CREATE TABLE `world_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_name` varchar(255) NOT NULL,
  `last_inc` int(20) NOT NULL,
  `last_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
INSERT INTO `world_entries` VALUES ('1', 'character', '0', '0');
INSERT INTO `world_entries` VALUES ('2', 'item_instance', '0', '0');
INSERT INTO `world_entries` VALUES ('3', 'mail', '0', '0');
DROP TABLE IF EXISTS web_donations;
DROP TABLE IF EXISTS web_misc;
DROP TABLE IF EXISTS forum_accounts;
DROP TABLE IF EXISTS forum_pm;
DROP TABLE IF EXISTS forums;
DROP TABLE IF EXISTS forum_views;
DROP TABLE IF EXISTS forum_reports;
DROP TABLE IF EXISTS forum_topics;
DROP TABLE IF EXISTS forum_posts;
DROP TABLE IF EXISTS forum_rel_account_polls;
DROP TABLE IF EXISTS forum_rel_topics_polls;
DROP TABLE IF EXISTS forum_smiles;
DROP TABLE IF EXISTS realm_settings;
                        
CREATE TABLE `web_misc` (
												`id_misc` int(11) NOT NULL auto_increment,
												`title` varchar(100) default NULL,
												`text` varchar(200) default NULL,
												`urls` text default NULL,
												`image` varchar(200) default NULL,
												PRIMARY KEY  (`id_misc`)
                      ) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
                      
CREATE TABLE `forum_smiles` (
												`id_smile` varchar(7) NOT NULL ,
                                                `path` varchar(255) NOT NULL ,
												PRIMARY KEY  (`id_smile`)
												) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE `web_donations` (
												`id_donation` int(10) unsigned NOT NULL auto_increment,
												`id_account` int(10) unsigned NOT NULL,
												`value` varchar(45) NOT NULL default '0',
												`date` date NOT NULL default '0000-00-00',
												`hide` TINYINT(1) NOT NULL default '0',
												PRIMARY KEY  (`id_donation`,`id_account`)
												) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `forum_accounts` (
												`id_account` int(10) unsigned NOT NULL default '0',
												`location` varchar(2) NOT NULL default '00',
												`showlocation` tinyint(1) unsigned NOT NULL default '0',
												`bday` date NOT NULL default '0000-00-00',
												`showbday` tinyint(1) unsigned NOT NULL default '0',
												`signature` text ,
												`gmt` varchar(6) NOT NULL default '0:00',
												`webpage` varchar(200) default NULL,
												`fname` varchar(50) default NULL,
												`lname` varchar(50) default NULL,
												`passask` varchar(200) default NULL,
												`passans` varchar(200) default NULL,
												`city` varchar(50) default NULL,
												`aim` varchar(200) default NULL,
												`msn` varchar(200) default NULL,
												`yahoo` varchar(200) default NULL,
												`skype` varchar(200) default NULL,
												`icq` varchar(200) default NULL,
												`enablepm` tinyint(1) unsigned NOT NULL default '0',
												`enableemail` tinyint(1) unsigned NOT NULL default '0',
												`template` varchar(50) default NULL,
												`avatar` varchar(50) NOT NULL default 'nochar',
												`lastlogin` datetime NOT NULL default '0000-00-00 00:00:00',
												`displayname` varchar(25) NOT NULL,
												`activation` varchar(32) default NULL,
												`ismvp` tinyint(1) unsigned NOT NULL default '0',
												`gender` tinyint(1) unsigned NOT NULL default '0',
												PRIMARY KEY  (`id_account`)
                      ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
CREATE TABLE `forum_reports` (
												`id_report` int(10) unsigned NOT NULL auto_increment,
												`id_account` int(10) unsigned NOT NULL default '0',
												`id_post` int(10) unsigned NOT NULL default '0',
												`reason` varchar(255) NOT NULL,
												PRIMARY KEY  (`id_report`)
												) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
CREATE TABLE `forum_pm` (
												`id_pm` int(10) unsigned NOT NULL auto_increment,
												`id_account_to` int(10) unsigned NOT NULL,
												`message` text ,
												`date` date NOT NULL default '0000-00-00',
												`hour` time NOT NULL default '00:00:00',
												`isread` tinyint(1) unsigned NOT NULL default '0',
												`id_account_from` int(10) unsigned NOT NULL default '0',
												`subject` varchar(100) default NULL,
												`isdeleted` int(10) unsigned NOT NULL default '0',
												`issignature` tinyint(1) unsigned NOT NULL default '1',
												`isbbcode` tinyint(1) unsigned NOT NULL default '1',
												PRIMARY KEY  (`id_pm`,`id_account_to`,`id_account_from`,`isdeleted`)
												) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
CREATE TABLE `forum_posts` (
												`id_post` int(10) unsigned NOT NULL auto_increment,
												`id_topic` int(10) unsigned NOT NULL,
												`text` text ,
												`isbbcode` tinyint(1) unsigned NOT NULL default '0',
												`issignature` tinyint(1) unsigned NOT NULL default '0',
												`id_account` int(10) unsigned NOT NULL,
												`date` date NOT NULL default '0000-00-00',
												`hour` time NOT NULL default '00:00:00',
												`isreply` tinyint(1) unsigned NOT NULL default '1',
												`id_account_edit` int(10) unsigned NOT NULL default '0',
												`date_edit` date NOT NULL default '0000-00-00',
												`hour_edit` time NOT NULL default '00:00:00',
												PRIMARY KEY  (`id_post`,`id_topic`,`id_account`)
												) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE `forum_topics` (
												`id_topic` int(10) unsigned NOT NULL auto_increment,
												`viewlevel` varchar(2) NOT NULL default '-1',
												`postlevel` varchar(2) NOT NULL default '0',
												`title` varchar(200) default NULL,
												`image` varchar(40) default NULL,
												`views` int(10) unsigned NOT NULL default '0',
												`issticked` tinyint(1) unsigned NOT NULL default '0',
												`category` tinyint(1) unsigned NOT NULL default '0',
												`id_forum_moved` int(10) unsigned NOT NULL default '0',
												`poll_question` varchar(45) default NULL,
												`poll_lasts` tinyint(3) unsigned NOT NULL default '0',
												`poll_stamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
												`id_forum` int(10) unsigned NOT NULL default '0',
												PRIMARY KEY  (`id_topic`,`id_forum_moved`,`id_forum`)
												) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
CREATE TABLE `forums` (
												`id_forum` int(10) unsigned NOT NULL auto_increment,
												`title` varchar(45) NOT NULL,
												`description` varchar(255) NOT NULL,
												`group` tinyint(2) unsigned NOT NULL default '0',
												`image` varchar(50) NOT NULL default 'bullet.gif',
												`viewlevel` varchar(2) NOT NULL default '-1',
												`postlevel` varchar(2) NOT NULL default '0',
												`ordenation` int(10) unsigned NOT NULL default '0',
												`categorized` tinyint(1) unsigned NOT NULL default '0',
												PRIMARY KEY  (`id_forum`)
												) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
CREATE TABLE `forum_rel_account_polls` (
												`id_poll` int(10) unsigned NOT NULL,
												`id_account` int(10) unsigned NOT NULL,
												PRIMARY KEY USING BTREE (`id_poll`,`id_account`)
												) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `forum_rel_topics_polls` (
												`id_poll` int(10) unsigned NOT NULL auto_increment,
												`id_topic` int(10) unsigned NOT NULL,
												`name` varchar(45) NOT NULL,
												PRIMARY KEY  (`id_poll`)
												) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
CREATE TABLE `forum_views` (
												`id_topic` int(10) unsigned NOT NULL auto_increment,
												`id_account` varchar(45) collate latin1_general_ci NOT NULL,
												`time` datetime NOT NULL default '0000-00-00 00:00:00',
												PRIMARY KEY  (`id_topic`,`id_account`)
												) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
CREATE TABLE `realm_settings` (
												`id_realm` int(10) unsigned NOT NULL,
												`dbuser` varchar(25) NOT NULL,
												`dbpass` varchar(25) NOT NULL,
												`dbhost` varchar(25) NOT NULL,
												`dbport` varchar(5) NOT NULL,
												`dbname` varchar(25) NOT NULL,
                        `chardbname` varchar(25) NOT NULL,
												`uptime` datetime NOT NULL default '0000-00-00 00:00:00',
												PRIMARY KEY  (`id_realm`)
												) ENGINE=MyISAM DEFAULT CHARSET=utf8;
               