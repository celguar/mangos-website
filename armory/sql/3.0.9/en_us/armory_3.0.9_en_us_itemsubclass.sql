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
-- Definition of table `dbc_itemsubclass`
--

DROP TABLE IF EXISTS `dbc_itemsubclass`;
CREATE TABLE `dbc_itemsubclass` (
  `ref_itemclass` bigint(20) NOT NULL,
  `id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY  (`ref_itemclass`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dbc_itemsubclass`
--

/*!40000 ALTER TABLE `dbc_itemsubclass` DISABLE KEYS */;
INSERT INTO `dbc_itemsubclass` (`ref_itemclass`,`id`,`name`) VALUES 
 (0,0,'Consumable'),
 (0,5,'Food & Drink'),
 (0,1,'Potion'),
 (0,2,'Elixir'),
 (0,3,'Flask'),
 (0,7,'Bandage'),
 (0,6,'Item Enhancement'),
 (0,4,'Scroll'),
 (0,8,'Other'),
 (1,0,'Bag'),
 (1,1,'Soul Bag'),
 (1,2,'Herb Bag'),
 (1,3,'Enchanting Bag'),
 (1,4,'Engineering Bag'),
 (1,5,'Gem Bag'),
 (1,6,'Mining Bag'),
 (1,7,'Leatherworking Bag'),
 (1,8,'Inscription Bag'),
 (2,0,'Axe'),
 (2,1,'Axe'),
 (2,2,'Bow'),
 (2,3,'Gun'),
 (2,4,'Mace'),
 (2,5,'Mace'),
 (2,6,'Polearm'),
 (2,7,'Sword'),
 (2,8,'Sword'),
 (2,9,'Obsolete'),
 (2,10,'Staff'),
 (2,11,'Exotic'),
 (2,12,'Exotic'),
 (2,13,'Fist Weapon'),
 (2,14,'Miscellaneous'),
 (2,15,'Dagger'),
 (2,16,'Thrown'),
 (2,17,'Spear'),
 (2,18,'Crossbow'),
 (2,19,'Wand'),
 (2,20,'Fishing Pole'),
 (3,0,'Red'),
 (3,1,'Blue'),
 (3,2,'Yellow'),
 (3,3,'Purple'),
 (3,4,'Green'),
 (3,5,'Orange'),
 (3,6,'Meta'),
 (3,7,'Simple'),
 (3,8,'Prismatic'),
 (4,0,'Miscellaneous'),
 (4,1,'Cloth'),
 (4,2,'Leather'),
 (4,3,'Mail'),
 (4,4,'Plate'),
 (4,5,'Buckler(OBSOLETE)'),
 (4,6,'Shield'),
 (4,7,'Libram'),
 (4,8,'Idol'),
 (4,9,'Totem'),
 (4,10,'Sigil'),
 (5,0,'Reagent'),
 (6,0,'Wand(OBSOLETE)'),
 (6,1,'Bolt(OBSOLETE)'),
 (6,2,'Arrow'),
 (6,3,'Bullet'),
 (6,4,'Thrown(OBSOLETE)'),
 (7,0,'Trade Goods'),
 (7,10,'Elemental'),
 (7,5,'Cloth'),
 (7,6,'Leather'),
 (7,7,'Metal & Stone'),
 (7,8,'Meat'),
 (7,9,'Herb'),
 (7,12,'Enchanting'),
 (7,4,'Jewelcrafting'),
 (7,1,'Parts'),
 (7,3,'Devices'),
 (7,2,'Explosives'),
 (7,13,'Materials'),
 (7,11,'Other'),
 (7,14,'Armor Enchantment'),
 (7,15,'Weapon Enchantment'),
 (8,0,'Generic(OBSOLETE)'),
 (9,0,'Book'),
 (9,1,'Leatherworking'),
 (9,2,'Tailoring'),
 (9,3,'Engineering'),
 (9,4,'Blacksmithing'),
 (9,5,'Cooking'),
 (9,6,'Alchemy'),
 (9,7,'First Aid'),
 (9,8,'Enchanting'),
 (9,9,'Fishing'),
 (9,10,'Jewelcrafting'),
 (10,0,'Money(OBSOLETE)'),
 (11,0,'Quiver(OBSOLETE)'),
 (11,1,'Quiver(OBSOLETE)'),
 (11,2,'Quiver'),
 (11,3,'Ammo Pouch'),
 (12,0,'Quest'),
 (13,0,'Key'),
 (13,1,'Lockpick'),
 (14,0,'Permanent'),
 (15,0,'Junk'),
 (15,1,'Reagent'),
 (15,2,'Pet'),
 (15,3,'Holiday'),
 (15,4,'Other'),
 (15,5,'Mount'),
 (16,1,'Warrior'),
 (16,2,'Paladin'),
 (16,3,'Hunter'),
 (16,4,'Rogue'),
 (16,5,'Priest'),
 (16,6,'Death Knight'),
 (16,7,'Shaman'),
 (16,8,'Mage'),
 (16,9,'Warlock'),
 (16,11,'Druid');
/*!40000 ALTER TABLE `dbc_itemsubclass` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
