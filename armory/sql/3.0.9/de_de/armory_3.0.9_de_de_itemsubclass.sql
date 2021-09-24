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
 (0,0,'Verbrauchbar'),
 (0,5,'Essen & Trinken'),
 (0,1,'Trank'),
 (0,2,'Elixier'),
 (0,3,'Fläschchen'),
 (0,7,'Verband'),
 (0,6,'Gegenstandsverbesserung'),
 (0,4,'Rolle'),
 (0,8,'Sonstige'),
 (1,0,'Behälter'),
 (1,1,'Seelentasche'),
 (1,2,'Kräutertasche'),
 (1,3,'Verzauberertasche'),
 (1,4,'Ingenieurstasche'),
 (1,5,'Edelsteintasche'),
 (1,6,'Bergbautasche'),
 (1,7,'Lederertasche'),
 (1,8,'Schreibertasche'),
 (2,0,'Axt'),
 (2,1,'Axt'),
 (2,2,'Bogen'),
 (2,3,'Schusswaffe'),
 (2,4,'Streitkolben'),
 (2,5,'Streitkolben'),
 (2,6,'Stangenwaffe'),
 (2,7,'Schwert'),
 (2,8,'Schwert'),
 (2,9,'Überflüssig'),
 (2,10,'Stab'),
 (2,11,'Exotika'),
 (2,12,'Exotika'),
 (2,13,'Faustwaffe'),
 (2,14,'Verschiedenes'),
 (2,15,'Dolch'),
 (2,16,'Wurfwaffe'),
 (2,17,'Speer'),
 (2,18,'Armbrust'),
 (2,19,'Zauberstab'),
 (2,20,'Angelrute'),
 (3,0,'Rot'),
 (3,1,'Blau'),
 (3,2,'Gelb'),
 (3,3,'Violett'),
 (3,4,'Grün'),
 (3,5,'Orange'),
 (3,6,'Meta'),
 (3,7,'Einfach'),
 (3,8,'Prismatisch'),
 (4,0,'Verschiedenes'),
 (4,1,'Stoff'),
 (4,2,'Leder'),
 (4,3,'Schwere Rüstung'),
 (4,4,'Platte'),
 (4,5,'Rundschild(OBSOLETE)'),
 (4,6,'Schild'),
 (4,7,'Buchbände'),
 (4,8,'Götze'),
 (4,9,'Totems'),
 (4,10,'Siegel'),
 (5,0,'Reagenz'),
 (6,0,'Zauberstab(OBSOLETE)'),
 (6,1,'Bolzen(OBSOLETE)'),
 (6,2,'Pfeil'),
 (6,3,'Kugel'),
 (6,4,'Wurfwaffen (ÜBERFLÜSSIG)'),
 (7,0,'Handwerkswaren'),
 (7,10,'Elementar'),
 (7,5,'Stoff'),
 (7,6,'Leder'),
 (7,7,'Metall & Stein'),
 (7,8,'Fleisch'),
 (7,9,'Kräuter'),
 (7,12,'Verzauberkunst'),
 (7,4,'Juwelenschleifen'),
 (7,1,'Teile'),
 (7,3,'Geräte'),
 (7,2,'Sprengstoff'),
 (7,13,'Materialien'),
 (7,11,'Sonstige'),
 (7,14,'Rüstungsverzauberung'),
 (7,15,'Waffenverzauberung'),
 (8,0,'Generic(OBSOLETE)'),
 (9,0,'Buch'),
 (9,1,'Lederverarbeitung'),
 (9,2,'Schneiderei'),
 (9,3,'Ingenieurskunst'),
 (9,4,'Schmiedekunst'),
 (9,5,'Kochkunst'),
 (9,6,'Alchemie'),
 (9,7,'Erste Hilfe'),
 (9,8,'Verzauberkunst'),
 (9,9,'Angeln'),
 (9,10,'Juwelenschleifen'),
 (10,0,'Money(OBSOLETE)'),
 (11,0,'Quiver(OBSOLETE)'),
 (11,1,'Quiver(OBSOLETE)'),
 (11,2,'Köcher'),
 (11,3,'Munitionsbeutel'),
 (12,0,'Quest'),
 (13,0,'Schlüssel'),
 (13,1,'Nachschlüssel'),
 (14,0,'Dauerhaft'),
 (15,0,'Plunder'),
 (15,1,'Reagenz'),
 (15,2,'Haustier'),
 (15,3,'Festtag'),
 (15,4,'Sonstige'),
 (15,5,'Reittier'),
 (16,1,'Krieger'),
 (16,2,'Paladin'),
 (16,3,'Jäger'),
 (16,4,'Schurke'),
 (16,5,'Priester'),
 (16,6,'Todesritter'),
 (16,7,'Schamane'),
 (16,8,'Magier'),
 (16,9,'Hexenmeister'),
 (16,11,'Druide');
/*!40000 ALTER TABLE `dbc_itemsubclass` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
