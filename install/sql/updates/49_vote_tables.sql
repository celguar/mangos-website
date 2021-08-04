SET FOREIGN_KEY_CHECKS=0;
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
