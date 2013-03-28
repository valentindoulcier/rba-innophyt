USE `rba-innophyt`;
-- MySQL dump 10.13  Distrib 5.5.24, for osx10.5 (i386)
--
-- Host: localhost    Database: rba-innophyt
-- ------------------------------------------------------
-- Server version	5.5.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `TABLE_USER`
--

LOCK TABLES `TABLE_USER` WRITE;
/*!40000 ALTER TABLE `TABLE_USER` DISABLE KEYS */;
INSERT INTO `TABLE_USER` VALUES (1,'Moi',1,'moi@gmail.com','8f8ad28dd6debff410e630ae13436709','035a5968384c183e698a08332cd4b931',NULL,NULL),(2,'Toi',0,'toi@gmail.com','501446ac98afd1e291c2498bb817bbd8','055aee21f05edc1ff2f632d9ca7d8df4',NULL,NULL);
/*!40000 ALTER TABLE `TABLE_USER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `TABLE_CAMPAGNE`
--

LOCK TABLES `TABLE_CAMPAGNE` WRITE;
/*!40000 ALTER TABLE `TABLE_CAMPAGNE` DISABLE KEYS */;
INSERT INTO `TABLE_CAMPAGNE` VALUES (1,1,'2013','2013-03-19','2013-04-19',NULL,NULL,NULL,'Une nouvelle campagne de test'),(4,2,'2014','2013-03-26','2013-04-26',NULL,NULL,NULL,'');
/*!40000 ALTER TABLE `TABLE_CAMPAGNE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `TABLE_PARCELLE`
--

LOCK TABLES `TABLE_PARCELLE` WRITE;
/*!40000 ALTER TABLE `TABLE_PARCELLE` DISABLE KEYS */;
INSERT INTO `TABLE_PARCELLE` VALUES (1,1,'Ma premi&Atilde;&uml;re parcelle','2013-03-19','2013-04-19','Tours','','','test'),(5,4,'Test3','2013-03-26','2013-04-26','','','',''),(7,1,'Ma deuxi&Atilde;&uml;me parcelle','2013-03-27','2013-04-27','','','','');
/*!40000 ALTER TABLE `TABLE_PARCELLE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `TABLE_PIEGE`
--

LOCK TABLES `TABLE_PIEGE` WRITE;
/*!40000 ALTER TABLE `TABLE_PIEGE` DISABLE KEYS */;
INSERT INTO `TABLE_PIEGE` VALUES (7,1,'TM-IKEA2','2013-03-20','2013-04-20','IKEA','47.3764','0.7169',''),(10,5,'BJ-DFE','2013-03-26','2013-04-26','','','',''),(11,1,'B-TO','2013-03-27','2013-04-27','Ile Tours Ouest','47.38684443152042','0.6296539306640625',''),(12,1,'BJ-Leclerc','2013-03-27','2013-04-27','La Ville Aux Dame','47.39544419274029','0.7874107360839844',''),(13,1,'Undef-Vouvray','2013-03-27','2013-04-27','Vouvray Nord','47.41827323486739','0.8092117309570312',''),(14,7,'BJ-IKEA','2013-03-05','2013-03-06','Tours','47.3764','0.7169',''),(15,7,'B-Polytech','2013-03-01','2013-03-08','Tours','47.3646921','0.6847464999999602','&Atilde;‰cole'),(16,7,'TM-Gare','2013-03-13','2013-03-15','Tours','47.3898559','0.6935154000000239','La gare de Tours'),(17,7,'TM-Lapeyre','2013-03-27','2013-04-27','Tours','47.33779','0.70397','Test magasin'),(18,7,'Sans Type','2013-03-27','2013-04-27','','47.36382295','0.70082324999998',''),(19,7,'BJ-A10S','2013-03-27','2013-04-27','Autoroute Sud','47.302632193954125','0.6924819946289062','Entr&Atilde;&copy;e de l\\\'autoroute au Sud de Tours'),(20,7,'TM-T74','2013-03-27','2013-04-27','Tours - Tanneurs','47.39637381260364','0.6835556030273438','Bords de Loire'),(21,7,'BJ-PM','2013-03-27','2013-04-27','Par&Atilde;&sect;ay-Meslay','47.44016355242185','0.7408905029296875','Tr&Atilde;&uml;s au Nord'),(22,7,'TM-S','2013-03-27','2013-04-27','Sorigny','47.242881146090085','0.707244873046875','Plus au Sud'),(23,1,'TM-ML','2013-03-27','2013-04-27','Montlouis-Sur-loire','47.38905261221537','0.828094482421875',''),(24,1,'B-B','2013-03-27','2013-04-27','Bl&Atilde;&copy;r&Atilde;&copy;','47.327653995607086','0.99151611328125',''),(25,1,'BJ-Chenonceaux','2013-03-27','2013-04-27','Ch&Atilde;&cent;teau de Chenonceaux','47.32497781066931','1.0697078704833984',''),(26,1,'TM-T74','2013-03-27','2013-04-27','','47.32497781066931','1.0287078704833984','');
/*!40000 ALTER TABLE `TABLE_PIEGE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `TABLE_RECOLTE`
--

LOCK TABLES `TABLE_RECOLTE` WRITE;
/*!40000 ALTER TABLE `TABLE_RECOLTE` DISABLE KEYS */;
INSERT INTO `TABLE_RECOLTE` VALUES (83,7,'MEL1#26 Mar 2013 21:14:15','Auxiliaire pr&Atilde;&copy;dateur','Carnivore','Ces arthropodes sont des pr&Atilde;&copy;dateurs g&Atilde;&copy;n&Atilde;&copy;ralistes. Plus il y a de ravageurs, plus ils sont consomm&Atilde;&copy;s par ce groupe d\\\'individus.&lt;span&gt;&lt;/span&gt;',NULL,NULL,NULL,12,'2013-03-26',1),(84,15,'MEJ#27 Mar 2013 17:19:50','Ravageur','Herbivore','Les insectes de cette morpho-esp&Atilde;&uml;ce font partie des Dipt&Atilde;&uml;res (regroupant les insectes qui poss&Atilde;&uml;dent 2 ailes). Cette morpho-esp&Atilde;&uml;ce regroupe des individus majoritairement phytophages sous forme larvaire alors que les adultes consomment des liquides.&lt;span&gt;&lt;/span&gt;',NULL,NULL,NULL,12,'2013-03-27',1),(85,15,'MEJ#27 Mar 2013 17:20:04','Ravageur','Herbivore','Les insectes de cette morpho-esp&Atilde;&uml;ce font partie des Dipt&Atilde;&uml;res (regroupant les insectes qui poss&Atilde;&uml;dent 2 ailes). Cette morpho-esp&Atilde;&uml;ce regroupe des individus majoritairement phytophages sous forme larvaire alors que les adultes consomment des liquides.&lt;span&gt;&lt;/span&gt;',NULL,NULL,NULL,13,'2013-03-27',1),(86,15,'MEM#27 Mar 2013 17:20:14','Ravageur puis Pollinisateur','Herbivore et Nectarivore','Ces insectes font partie des L&Atilde;&copy;pidopt&Atilde;&uml;res, plus commun&Atilde;&copy;ment appel&Atilde;&copy;s Papillons. Ce groupe est constitu&Atilde;&copy; de plus de 100 000 esp&Atilde;&uml;ces connues. Leur larve, la chenille, consomme des v&Atilde;&copy;g&Atilde;&copy;taux et peut causer de nombreux d&Atilde;&copy;g&Atilde;&cent;ts. La forme adulte qui n\\\'a pas une dur&Atilde;&copy;e de vie longue, se nourrit de nectar et pollinise les fleurs. Pour son d&Atilde;&copy;veloppement, le papillon compte un stade oeuf, une stade chenille, un stade chrysalide et un stade adulte. La femelle peut pondre de 50 &Atilde;&nbsp; 1000 oeufs.&lt;span&gt;&lt;/span&gt;',NULL,NULL,NULL,40,'2013-03-27',1),(87,15,'MEA10#27 Mar 2013 17:20:27','Auxiliaire pr&Atilde;&copy;dateur','Carnivore','Les insectes qui composent cette morpho-esp&Atilde;&uml;ce font partie des Col&Atilde;&copy;opt&Atilde;&uml;res. Ils sont le plus souvent appel&Atilde;&copy;s Carabes. Voraces, ils peuvent consommer autant que leur masse corporelle. Cela fait de ces insectes un groupe d\\\'auxiliaires int&Atilde;&copy;ressant pour les cultures.&lt;span&gt;&lt;/span&gt;',NULL,NULL,NULL,20,'2013-03-27',1),(89,15,'MEF#27 Mar 2013 17:20:48','Auxiliaire pollinisateur','Nectarivore','Les insectes de cette morpho-esp&Atilde;&uml;ce font partie des Hym&Atilde;&copy;nopt&Atilde;&uml;res. Ils sont plus commun&Atilde;&copy;ment appel&Atilde;&copy;s abeilles ou encore bourdons ... Plus de 400 esp&Atilde;&uml;ces sont connues dont certaines sont sociales et d\\\'autres solitaires. Ces insectes se nourrissent de nectar et de pollen et alimentent leurs jeunes de la m&Atilde;&ordf;me mani&Atilde;&uml;re. Ils jouent un r&Atilde;&acute;le important dans la production de denr&Atilde;&copy;es alimentaires en pollinisant les fleurs qui donneront alors des fruits et des graines. Notons qu\\\'en moyenne, un insecte de ce groupe peut porter environ 20% de son poids en pollen.&lt;span&gt;&lt;/span&gt;',NULL,NULL,NULL,15,'2013-03-27',1);
/*!40000 ALTER TABLE `TABLE_RECOLTE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `android_metadata`
--

LOCK TABLES `android_metadata` WRITE;
/*!40000 ALTER TABLE `android_metadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `android_metadata` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;