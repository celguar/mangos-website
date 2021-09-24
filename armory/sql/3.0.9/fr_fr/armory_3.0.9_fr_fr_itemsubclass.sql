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
 (0,0,'Consommables'),
 (0,5,'Nourriture & boissons'),
 (0,1,'Potion'),
 (0,2,'Élixir'),
 (0,3,'Flacon'),
 (0,7,'Bandage'),
 (0,6,'Amélioration d\'objet'),
 (0,4,'Parchemin'),
 (0,8,'Autre'),
 (1,0,'Sac'),
 (1,1,'Sac d\'âme'),
 (1,2,'Sac d\'herbes'),
 (1,3,'Sac d\'enchanteur'),
 (1,4,'Sac d\'ingénieur'),
 (1,5,'Sac de gemmes'),
 (1,6,'Sac de mineur'),
 (1,7,'Sac de travail du cuir'),
 (1,8,'Sac de calligraphie'),
 (2,0,'Hache'),
 (2,1,'Hache'),
 (2,2,'Arc'),
 (2,3,'Arme à feu'),
 (2,4,'Masse'),
 (2,5,'Masse'),
 (2,6,'Arme d\'hast'),
 (2,7,'Epée'),
 (2,8,'Epée'),
 (2,9,'Obsolète'),
 (2,10,'Bâton'),
 (2,11,'Spéciale'),
 (2,12,'Spéciale'),
 (2,13,'Arme de pugilat'),
 (2,14,'Divers'),
 (2,15,'Dague'),
 (2,16,'Armes de jet'),
 (2,17,'Lance'),
 (2,18,'Arbalète'),
 (2,19,'Baguette'),
 (2,20,'Canne à pêche'),
 (3,0,'Rouge'),
 (3,1,'Bleue'),
 (3,2,'Jaune'),
 (3,3,'Violette'),
 (3,4,'Verte'),
 (3,5,'Orange'),
 (3,6,'Méta'),
 (3,7,'Simple'),
 (3,8,'Prismatique'),
 (4,0,'Divers'),
 (4,1,'Tissu'),
 (4,2,'Cuir'),
 (4,3,'Mailles'),
 (4,4,'Plaques'),
 (4,5,'Targe(OBSOLETE)'),
 (4,6,'Bouclier'),
 (4,7,'Libram'),
 (4,8,'Idole'),
 (4,9,'Totem'),
 (4,10,'Cachet'),
 (5,0,'Réactif'),
 (6,0,'Baguette(OBSOLETE)'),
 (6,1,'Carreau(OBSOLETE)'),
 (6,2,'Flèche'),
 (6,3,'Balle'),
 (6,4,'Arme de jet(OBSOLETE)'),
 (7,0,'Artisanat'),
 (7,10,'Élémentaire'),
 (7,5,'Tissu'),
 (7,6,'Cuir'),
 (7,7,'Métal & pierre'),
 (7,8,'Viande'),
 (7,9,'Herbes'),
 (7,12,'Enchantement'),
 (7,4,'Joaillerie'),
 (7,1,'Eléments'),
 (7,3,'Appareils'),
 (7,2,'Explosifs'),
 (7,13,'Matériaux'),
 (7,11,'Autre'),
 (7,14,'Enchantement d\'armure'),
 (7,15,'Enchantement d\'arme'),
 (8,0,'Générique(OBSOLETE)'),
 (9,0,'Livre'),
 (9,1,'Travail du cuir'),
 (9,2,'Couture'),
 (9,3,'Ingénierie'),
 (9,4,'Forge'),
 (9,5,'Cuisine'),
 (9,6,'Alchimie'),
 (9,7,'Secourisme'),
 (9,8,'Enchantement'),
 (9,9,'Pêche'),
 (9,10,'Joaillerie'),
 (10,0,'Argent(OBSOLETE)'),
 (11,0,'Carquois(OBSOLETE)'),
 (11,1,'Carquois(OBSOLETE)'),
 (11,2,'Carquois'),
 (11,3,'Giberne'),
 (12,0,'Quête'),
 (13,0,'Clé'),
 (13,1,'Crochetage'),
 (14,0,'Permanent'),
 (15,0,'Camelote'),
 (15,1,'Réactif'),
 (15,2,'Familier'),
 (15,3,'Fête'),
 (15,4,'Autre'),
 (15,5,'Monture'),
 (16,1,'Guerrier'),
 (16,2,'Paladin'),
 (16,3,'Chasseur'),
 (16,4,'Voleur'),
 (16,5,'Prêtre'),
 (16,6,'Ch. de la mort'),
 (16,7,'Chaman'),
 (16,8,'Mage'),
 (16,9,'Démoniste'),
 (16,11,'Druide');
/*!40000 ALTER TABLE `dbc_itemsubclass` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
