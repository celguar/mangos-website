SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `acc_creation_captcha`
-- ----------------------------
DROP TABLE IF EXISTS `acc_creation_captcha`;
CREATE TABLE `acc_creation_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(200) NOT NULL DEFAULT '',
  `key` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of donations_template
-- ----------------------------

-- ----------------------------
-- Table structure for `f_attachs`
-- ----------------------------
DROP TABLE IF EXISTS `f_attachs`;
CREATE TABLE `f_attachs` (
  `attach_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attach_file` varchar(255) CHARACTER SET cp1251 NOT NULL,
  `attach_location` varchar(255) CHARACTER SET cp1251 NOT NULL,
  `attach_hits` int(10) NOT NULL DEFAULT '0',
  `attach_date` int(10) NOT NULL,
  `attach_tid` int(10) unsigned NOT NULL DEFAULT '0',
  `attach_member_id` int(8) unsigned NOT NULL,
  `attach_filesize` int(10) unsigned NOT NULL,
  PRIMARY KEY (`attach_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of f_attachs
-- ----------------------------

-- ----------------------------
-- Table structure for `f_categories`
-- ----------------------------
DROP TABLE IF EXISTS `f_categories`;
CREATE TABLE `f_categories` (
  `cat_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL DEFAULT 'New Category',
  `cat_disp_position` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of f_categories
-- ----------------------------

-- ----------------------------
-- Table structure for `f_forums`
-- ----------------------------
DROP TABLE IF EXISTS `f_forums`;
CREATE TABLE `f_forums` (
  `forum_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `forum_name` varchar(255) NOT NULL DEFAULT 'New forum',
  `forum_desc` varchar(255) DEFAULT NULL,
  `redirect_url` varchar(200) DEFAULT NULL,
  `moderators` varchar(255) DEFAULT NULL,
  `num_topics` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `num_posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `last_topic_id` int(10) unsigned DEFAULT NULL,
  `disp_position` smallint(6) NOT NULL DEFAULT '0',
  `quick_reply` tinyint(1) NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of f_forums
-- ----------------------------

-- ----------------------------
-- Table structure for `f_markread`
-- ----------------------------
DROP TABLE IF EXISTS `f_markread`;
CREATE TABLE `f_markread` (
  `marker_member_id` int(8) unsigned NOT NULL DEFAULT '0',
  `marker_forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  `marker_last_update` int(10) unsigned NOT NULL DEFAULT '0',
  `marker_unread` smallint(5) NOT NULL DEFAULT '0',
  `marker_topics_read` text NOT NULL,
  `marker_last_cleared` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `marker_forum_id` (`marker_forum_id`,`marker_member_id`),
  KEY `marker_member_id` (`marker_member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of f_markread
-- ----------------------------

-- ----------------------------
-- Table structure for `f_posts`
-- ----------------------------
DROP TABLE IF EXISTS `f_posts`;
CREATE TABLE `f_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poster` varchar(12) NOT NULL,
  `poster_id` int(8) unsigned NOT NULL DEFAULT '0',
  `poster_ip` varchar(15) DEFAULT NULL,
  `poster_character_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `posted` int(10) unsigned NOT NULL DEFAULT '0',
  `edited` int(10) unsigned DEFAULT NULL,
  `edited_by` varchar(30) DEFAULT NULL,
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of f_posts
-- ----------------------------

-- ----------------------------
-- Table structure for `f_topics`
-- ----------------------------
DROP TABLE IF EXISTS `f_topics`;
CREATE TABLE `f_topics` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_poster` varchar(12) NOT NULL,
  `topic_poster_id` int(8) unsigned NOT NULL,
  `topic_name` varchar(255) NOT NULL,
  `topic_posted` int(10) unsigned NOT NULL DEFAULT '0',
  `last_post` int(10) unsigned NOT NULL DEFAULT '0',
  `last_post_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_poster` varchar(200) DEFAULT NULL,
  `num_views` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `num_replies` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `sticky` tinyint(1) NOT NULL DEFAULT '0',
  `redirect_url` varchar(200) DEFAULT NULL,
  `forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of f_topics
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

-- ----------------------------
-- Records of voting_points
-- ----------------------------

-- ----------------------------
-- Table structure for `voting_rewards`
-- ----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of voting_rewards
-- ----------------------------

-- ----------------------------
-- Table structure for `voting_sites`
-- ----------------------------
DROP TABLE IF EXISTS `voting_sites`;
CREATE TABLE `voting_sites` (
  `id` int(11) unsigned NOT NULL DEFAULT '0',
  `hostname` varchar(255) NOT NULL,
  `votelink` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `points` decimal(10,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of voting_sites
-- ----------------------------


-- ----------------------------
-- Table structure for `world_entrys`
-- ----------------------------
DROP TABLE IF EXISTS `world_entrys`;
CREATE TABLE `world_entrys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `last_inc` int(20) NOT NULL,
  `last_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Records of world_entrys
-- ----------------------------
INSERT INTO `world_entrys` VALUES ('1', 'character', '0', '0');
INSERT INTO `world_entrys` VALUES ('2', 'item_instance', '0', '0');
INSERT INTO `world_entrys` VALUES ('3', 'mail', '0', '0');

-- ----------------------------
-- Insert account data from "account" table
-- ----------------------------
INSERT INTO `account_extend` (`account_id`) SELECT account.id FROM account;

--
-- Add dbinfo to realmlist table
-- Very important that this is in the end, along with ADD ALTERS. Because if
-- file gets applied again, it gets an error here.
--

ALTER TABLE `realmlist` 
ADD `dbinfo` VARCHAR( 355 ) NOT NULL default 'username;password;3306;127.0.0.1;DBWorld;DBCharacter' COMMENT 'Database info to THIS row',
ADD `ra_address` VARCHAR( 25 ) NOT NULL default '127.0.0.1',
ADD `ra_port` int(5) NOT NULL default '3443',
ADD `ra_user` VARCHAR( 355 ) NOT NULL default 'username',
ADD `ra_pass` VARCHAR( 355 ) NOT NULL default 'password';

