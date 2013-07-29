-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: assign_seat
-- ------------------------------------------------------
-- Server version	5.5.29-0ubuntu0.12.04.1-log

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
-- Current Database: `assign_seat`
--

/*!40000 DROP DATABASE IF EXISTS `assign_seat`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `assign_seat` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `assign_seat`;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'THIS WILL BE AUTO GENERATED UNIQUE ID',
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Name of Employee',
  `designation` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Designation of Employee',
  `department` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Department of Employee',
  `details` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'DESCRIPTION OF Employee',
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT 'status 1:Active,0:Deleted',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time of login creation ',
  `updated_on` datetime DEFAULT NULL COMMENT 'Time of updation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1,'emp1','designation1','testing','hfghdhfet dfg','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'emp2','designation2','sugarcrm','hfghdhf ddgf','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'emp3','designation3','Zend','hfghdhf t hf','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'emp4','designation4','drupal','hfghdhf hgh j','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'emp5','designation1','testing','hfghdhfet dfg','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'emp6','designation2','sugarcrm','hfghdhf ddgf','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'emp7','designation3','Zend','hfghdhf t hf','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,'emp8','designation4','drupal','hfghdhf hgh j','','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'THIS WILL BE AUTO GENERATED UNIQUE ID',
  `username` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'USERNAME',
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'PASSWORD',
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT 'status 1:Active,0:Deleted',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time of login creation ',
  `updated_on` datetime DEFAULT NULL COMMENT 'Time of updation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'admin','81dc9bdb52d04dc20036dbd8313ed055','1','2013-07-29 10:13:16','0000-00-00 00:00:00'),(2,'user1','81dc9bdb52d04dc20036dbd8313ed055','1','2013-07-29 10:13:16','0000-00-00 00:00:00'),(3,'user2','81dc9bdb52d04dc20036dbd8313ed055','1','2013-07-29 10:13:16','0000-00-00 00:00:00'),(4,'user3','81dc9bdb52d04dc20036dbd8313ed055','1','2013-07-29 10:13:17','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'THIS WILL BE AUTO GENERATED UNIQUE ID',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Name of Employee',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'status 1:Active,0:Deleted',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time of login creation ',
  `updated_on` datetime DEFAULT NULL COMMENT 'Time of updation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (1,'googol','1','0000-00-00 00:00:00',NULL),(2,'Lab-1','1','0000-00-00 00:00:00',NULL),(3,'cabin-1','1','0000-00-00 00:00:00',NULL),(4,'cabin-2','1','0000-00-00 00:00:00',NULL),(5,'cabin-3','1','0000-00-00 00:00:00',NULL),(6,'cabin-4','1','0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_row`
--

DROP TABLE IF EXISTS `room_row`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_row` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'THIS WILL BE AUTO GENERATED UNIQUE ID',
  `room_id` int(2) unsigned DEFAULT NULL COMMENT 'Name of Employee',
  `row_number` int(2) unsigned DEFAULT NULL COMMENT 'THIS WILL BE AUTO GENERATED UNIQUE ID',
  `computer` int(2) unsigned DEFAULT NULL COMMENT 'THIS WILL BE AUTO GENERATED UNIQUE ID',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'status 1:Active,0:Deleted',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time of login creation ',
  `updated_on` datetime DEFAULT NULL COMMENT 'Time of updation',
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `room_row_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_row`
--

LOCK TABLES `room_row` WRITE;
/*!40000 ALTER TABLE `room_row` DISABLE KEYS */;
INSERT INTO `room_row` VALUES (1,2,1,9,'1','0000-00-00 00:00:00',NULL),(2,2,2,9,'1','0000-00-00 00:00:00',NULL),(3,2,3,9,'1','0000-00-00 00:00:00',NULL),(4,2,4,9,'1','0000-00-00 00:00:00',NULL),(5,2,5,9,'1','0000-00-00 00:00:00',NULL),(6,2,6,9,'1','0000-00-00 00:00:00',NULL),(7,2,7,9,'1','0000-00-00 00:00:00',NULL),(8,2,8,9,'1','0000-00-00 00:00:00',NULL),(9,2,9,9,'1','0000-00-00 00:00:00',NULL),(10,2,10,9,'1','0000-00-00 00:00:00',NULL),(11,2,11,9,'1','0000-00-00 00:00:00',NULL),(12,2,12,9,'1','0000-00-00 00:00:00',NULL),(13,2,13,9,'1','0000-00-00 00:00:00',NULL),(14,2,14,9,'1','0000-00-00 00:00:00',NULL),(15,2,15,9,'1','0000-00-00 00:00:00',NULL),(16,2,16,9,'1','0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `room_row` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seat_employee`
--

DROP TABLE IF EXISTS `seat_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seat_employee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'THIS WILL BE AUTO GENERATED UNIQUE ID',
  `eid` int(5) unsigned DEFAULT NULL COMMENT 'THIS WILL BE ID Of employee',
  `sid` int(5) unsigned DEFAULT NULL COMMENT 'THIS WILL BE ID Of seat',
  `computer_id` int(2) unsigned DEFAULT NULL COMMENT 'THIS WILL BE ID Of computer allocated to user',
  `asignee` int(5) unsigned DEFAULT NULL COMMENT 'THIS WILL BE ID Of asignee',
  `details` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'DESCRIPTION OF Employee',
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT 'status 1:Active,0:Deleted',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time of login creation ',
  `updated_on` datetime DEFAULT NULL COMMENT 'Time of updation',
  PRIMARY KEY (`id`),
  KEY `eid` (`eid`),
  KEY `asignee` (`asignee`),
  KEY `sid` (`sid`),
  CONSTRAINT `seat_employee_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `employee` (`id`),
  CONSTRAINT `seat_employee_ibfk_2` FOREIGN KEY (`asignee`) REFERENCES `login` (`id`),
  CONSTRAINT `seat_employee_ibfk_3` FOREIGN KEY (`sid`) REFERENCES `room_row` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seat_employee`
--

LOCK TABLES `seat_employee` WRITE;
/*!40000 ALTER TABLE `seat_employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `seat_employee` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-07-29 15:43:30
