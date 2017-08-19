CREATE DATABASE  IF NOT EXISTS `convinientdb` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `convinientdb`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: convinientdb
-- ------------------------------------------------------
-- Server version	5.7.13-log

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
-- Table structure for table `assignment`
--

DROP TABLE IF EXISTS `assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignment` (
  `AID` int(11) NOT NULL AUTO_INCREMENT,
  `AType` int(11) DEFAULT NULL,
  `AEID` int(11) DEFAULT NULL,
  `ATID` int(11) DEFAULT NULL,
  PRIMARY KEY (`AID`),
  KEY `AEID_idx` (`AEID`),
  KEY `ATID_idx` (`ATID`),
  CONSTRAINT `AEID` FOREIGN KEY (`AEID`) REFERENCES `employees` (`EID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ATID` FOREIGN KEY (`ATID`) REFERENCES `transactions` (`TID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignment`
--

LOCK TABLES `assignment` WRITE;
/*!40000 ALTER TABLE `assignment` DISABLE KEYS */;
INSERT INTO `assignment` VALUES (62,1,6,74),(63,1,7,75),(64,1,9,76),(65,2,11,75),(74,1,8,88),(75,2,13,88),(76,1,8,89),(77,2,13,89),(78,1,6,90),(79,1,6,91),(80,2,14,91),(86,2,13,75),(87,2,13,75),(95,1,6,104),(96,1,6,105),(97,2,11,105),(98,2,11,104);
/*!40000 ALTER TABLE `assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `CID` int(11) NOT NULL AUTO_INCREMENT,
  `FN` varchar(45) DEFAULT NULL,
  `MN` varchar(45) DEFAULT NULL,
  `LN` varchar(45) DEFAULT NULL,
  `Address` varchar(45) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `Contact` int(25) DEFAULT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'Laura','Tan','Tuggle','718 Arron Smith Drive',1,808477),(2,'Barbara','Ren','Jamison','2566 Cody Ridge Road',1,58049783),(3,'Peter','Sole','Clark','4494 Maple Avenue',1,209271761),(4,'Sonia','Didi','Johnson','2474 Columbia Mine Road',1,304539051),(6,'Suzanne','Leni','Garrison','1414 Michael Street',1,713770048),(11,'DODONG','LAB','LABORIKI','DAVAO',1,123123123);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `EID` int(11) NOT NULL AUTO_INCREMENT,
  `FN` varchar(45) DEFAULT NULL,
  `MN` varchar(45) DEFAULT NULL,
  `LN` varchar(45) DEFAULT NULL,
  `BDay` varchar(45) DEFAULT NULL,
  `CivilStat` int(11) DEFAULT NULL,
  `StaffDesc` int(11) DEFAULT NULL,
  `Username` varchar(45) DEFAULT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  PRIMARY KEY (`EID`),
  UNIQUE KEY `Username_UNIQUE` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Jeremy','Ron','Rogers','8/25/1985',1,1,'admin','admin',1),(4,'Susan','Mays','Stein','10/20/1994',2,1,'admin3','admin3',1),(6,'Marcy','Kelly','Shepherd','10/20/1994',2,2,'post','post',1),(7,'Regan','Many','Carrasquillo','3/14/1961',1,2,'post1','post1',1),(8,'Donna','Kalan','Reynolds','5/20/1949',1,2,'post2','post2',1),(9,'Gladys','Maymay','Morais','1/19/1942',2,2,'post3','post3',1),(10,'Garland','Go','Cordes','8/23/1983',1,2,'post4','post4',2),(11,'Richard','Regodon','Connors','2/9/1979',1,3,'run','run',1),(12,'Greg','Pinoy','Dietz','6/20/1977',2,3,'run1','run1',1),(13,'Edward','Suka','Scott','6/17/1970',2,3,'run2','run2',1),(14,'Georgia','Rice','Extra','7/18/1990',1,3,'run3','run3',1),(15,'Ben','Talong','Chin','10/20/1994',1,3,'run4','run4',2),(16,'Stefani','Joanne','Perry','6/5/1951',1,1,'admin2','admin2',1);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderline`
--

DROP TABLE IF EXISTS `orderline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderline` (
  `OID` int(11) NOT NULL AUTO_INCREMENT,
  `OTID` int(11) DEFAULT NULL,
  `OPID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`OID`),
  KEY `Products_idx` (`OPID`),
  KEY `Transaction_idx` (`OTID`),
  CONSTRAINT `Products` FOREIGN KEY (`OPID`) REFERENCES `products` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Transaction` FOREIGN KEY (`OTID`) REFERENCES `transactions` (`TID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderline`
--

LOCK TABLES `orderline` WRITE;
/*!40000 ALTER TABLE `orderline` DISABLE KEYS */;
INSERT INTO `orderline` VALUES (90,74,9,56),(91,74,22,76),(92,75,8,45),(93,75,22,45),(94,76,10,100),(95,76,5,800),(97,88,14,300),(98,89,16,300),(99,90,12,34),(100,90,16,100),(101,91,22,5),(102,91,39,100),(104,104,14,999),(105,104,5,999),(106,104,16,999),(107,105,52,10),(108,105,3,10),(109,104,52,80);
/*!40000 ALTER TABLE `orderline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `PID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `Price` double DEFAULT NULL,
  `ProdType` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  PRIMARY KEY (`PID`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Pilot Frixion',72.85,1,1),(3,'Chicken Burger',30.75,3,1),(4,'Victory Yellow Pad',30.75,1,1),(5,'Paper One Bond Paper',500.54,2,1),(6,'Nestle Red Iced Tea',15.32,4,1),(8,'Caramel Macchiato Latte',29.99,4,1),(9,'Hot Chocolate',23.54,4,1),(10,'French Vanilla Cappuccino',15.25,4,1),(11,'Skinny French Vanilla Cappuccino',56.81,4,2),(12,'Monterry Jack Taquito',56.41,3,1),(13,'Nacho Cheese Taquito',81.24,3,2),(14,'Cheeseburger Bite',45.62,3,1),(15,'Chicken Dippers',42.32,3,2),(16,'Canon Ink Cartridge',1050.25,2,1),(17,'Eagle Cash Box 8878',849.99,2,1),(18,'Eagle Hanging Folder',32.33,2,1),(20,'Carpet Seam Binders',867.45,5,1),(21,'Eye Pulleys and Snaps',78.21,5,1),(22,'Grommets',456.35,5,1),(23,'Leveling Mounts',45.54,5,1),(24,'Hydraulic Lift Kits',453.55,5,2),(25,'Pizza Maker Oven',109.95,6,1),(26,'Polder Dish Rack',55.95,6,1),(27,'Nel Lusso Wood',49.95,6,1),(28,'Global Knife Block',399.95,6,1),(29,'Davis Serving Paddle',24.95,6,2),(30,'Spring Rain Body Wash',92.16,7,1),(31,'Spring Rain Body Wash',92.11,7,1),(32,'Dove Moisturizing Body Wash',82.22,7,1),(33,'Sweet Pea Honey Suckle',98.09,7,1),(34,'Cucumber Bubble Bath',83.06,7,1),(35,'Herculiner Truck Bed Liner (HCL0B8)',74.99,8,1),(36,'303 Products 16oz High Tech',26.99,8,1),(37,'Herculiner® Brush-On Bed',26.99,8,1),(38,'Lifter 1® Upholstery Stain Remover',6.99,9,1),(39,'Smartwax® Smartleather® 16oz',14.99,8,1),(40,'Joncryl Primer Brilliant White',41.16,9,1),(41,'Universal Wood Primer - 5 Ltr',38.22,9,1),(42,'Everline Marking Paint Spray- 700ml',8.19,8,1),(43,'Turpentine Substitute - 2 Litre',5.44,9,1),(44,'Turpentine Substitute - 1 Litre',2.99,9,1),(45,'Elmers Washable Glue',9.86,1,1),(46,'Economy Round Ring',2.54,1,1),(47,'Avery Durable Ring View',5.15,1,2),(50,'Epson Ink Cartridge',299.99,2,1),(52,'DELL MONITORING MONITOR',2500,2,1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `TID` int(11) NOT NULL AUTO_INCREMENT,
  `DateEntry` varchar(45) DEFAULT NULL,
  `TCID` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  PRIMARY KEY (`TID`),
  KEY `TCID_idx` (`TCID`),
  CONSTRAINT `TCID` FOREIGN KEY (`TCID`) REFERENCES `customer` (`CID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (74,'2/16/2017',1,4),(75,'2/16/2017',2,2),(76,'2/16/2017',3,1),(88,'2/16/2017',1,3),(89,'2/16/2017',4,7),(90,'2/16/2017',2,5),(91,'2/16/2017',4,6),(104,'2/22/2017',6,7),(105,'2/22/2017',11,7);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-20  1:03:48
