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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (1,'googol','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'Lab-1','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'cabin-1','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'cabin-2','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'cabin-3','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'cabin-4','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'sirijan 2','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(8,'Aer','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(9,'aqua','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(10,'conference','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(11,'Egnis','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(12,'jugraj singh bedi','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(13,'sachin khurana','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(14,'terra','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(15,'Pranabdas','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(16,'arinder singh suri','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(17,'sonali minocha','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(18,'sourabh','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(19,'accounts','1','2013-07-30 06:04:08','0000-00-00 00:00:00'),(20,'sirijan 3','1','2013-07-30 06:04:09','0000-00-00 00:00:00'),(21,'cabin-5','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(22,'cabin-6','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(23,'cabin-7','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(24,'cabin-8','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(25,'cabin-9','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(26,'cabin-10','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(27,'cabin-11','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(28,'cabin-12','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(29,'cabin-13','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(30,'cabin-14','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(31,'cabin-15','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(32,'cabin-16','1','2013-07-31 04:07:13','0000-00-00 00:00:00'),(33,'cabin-17','1','2013-07-31 04:07:15','0000-00-00 00:00:00'),(34,'room-1','1','2013-07-31 04:40:11','0000-00-00 00:00:00'),(35,'room-2','1','2013-07-31 04:40:11','0000-00-00 00:00:00'),(36,'sirijan-3','1','2013-07-31 04:40:13','0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_row`
--

LOCK TABLES `room_row` WRITE;
/*!40000 ALTER TABLE `room_row` DISABLE KEYS */;
INSERT INTO `room_row` VALUES (1,2,1,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,2,2,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,2,3,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,2,4,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,2,5,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,2,6,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,2,7,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,2,8,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,2,9,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(10,2,10,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,2,11,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,2,12,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,2,13,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,2,14,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,2,15,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(16,2,16,9,'1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(17,15,1,1,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(18,16,1,1,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(19,17,1,3,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(20,18,1,1,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(21,19,1,3,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(22,11,1,4,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(23,12,1,1,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(24,13,1,1,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(25,14,1,4,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(26,10,1,4,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(27,8,1,2,'1','2013-07-30 06:15:43','0000-00-00 00:00:00'),(28,9,1,2,'1','2013-07-30 06:15:44','0000-00-00 00:00:00'),(29,3,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(30,4,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(31,5,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(32,6,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(33,21,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(34,22,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(35,23,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(36,24,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(37,25,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(38,26,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(39,27,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(40,28,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(41,29,1,1,'1','2013-07-31 04:09:58','0000-00-00 00:00:00'),(42,30,1,1,'1','2013-07-31 04:09:59','0000-00-00 00:00:00'),(43,31,1,1,'1','2013-07-31 04:38:34','0000-00-00 00:00:00'),(44,32,1,1,'1','2013-07-31 04:38:34','0000-00-00 00:00:00'),(45,33,1,1,'1','2013-07-31 04:38:35','0000-00-00 00:00:00'),(46,34,1,6,'1','2013-07-31 04:41:45','0000-00-00 00:00:00'),(47,35,1,5,'1','2013-07-31 04:41:46','0000-00-00 00:00:00'),(48,36,1,9,'1','2013-07-31 04:41:46','0000-00-00 00:00:00'),(49,7,1,4,'1','2013-07-31 04:45:43','0000-00-00 00:00:00'),(50,7,2,4,'1','2013-07-31 04:45:43','0000-00-00 00:00:00'),(51,7,3,4,'1','2013-07-31 04:45:43','0000-00-00 00:00:00'),(52,7,4,3,'1','2013-07-31 04:45:43','0000-00-00 00:00:00'),(53,7,5,3,'1','2013-07-31 04:45:43','0000-00-00 00:00:00'),(54,7,6,3,'1','2013-07-31 04:45:43','0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seat_employee`
--

LOCK TABLES `seat_employee` WRITE;
/*!40000 ALTER TABLE `seat_employee` DISABLE KEYS */;
INSERT INTO `seat_employee` VALUES (1,1,1,3,1,'dsfkjhdskjfghkdslj dfkjsghjkdfhgkldsfh','1','2013-07-31 04:36:50','0000-00-00 00:00:00'),(2,2,2,1,1,'dsfkjhdskjfghkdslj dfkjsghjkdfhgkldsfh','1','2013-07-31 04:36:59','0000-00-00 00:00:00'),(3,3,2,4,1,'dsfkjhdskjfghkdslj dfkjsghjkdfhgkldsfh','1','2013-07-31 04:37:17','0000-00-00 00:00:00'),(4,4,1,1,1,'dsfkjhdskjfghkdslj dfkjsghjkdfhgkldsfh','1','2013-07-31 04:37:52','0000-00-00 00:00:00'),(5,5,3,3,1,'dsfkjhdskjfghkdslj dfkjsghjkdfhgkldsfh','1','2013-07-31 04:47:41','0000-00-00 00:00:00'),(6,6,3,1,1,'dsfkjhdskjfghkdslj dfkjsghjkdfhgkldsfh','1','2013-07-31 04:48:10','0000-00-00 00:00:00');
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

-- Dump completed on 2013-07-31 10:23:07