/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: hoomy
-- ------------------------------------------------------
-- Server version	11.7.2-MariaDB-ubu2404

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `data_type`
--

DROP TABLE IF EXISTS `data_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_type` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_type`
--

LOCK TABLES `data_type` WRITE;
/*!40000 ALTER TABLE `data_type` DISABLE KEYS */;
INSERT INTO `data_type` VALUES
(1,'°C'),
(2,'W'),
(3,'RGB'),
(4,'%'),
(5,'dB');
/*!40000 ALTER TABLE `data_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) DEFAULT NULL,
  `label` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_92FB68E54177093` (`room_id`),
  CONSTRAINT `FK_92FB68E54177093` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device`
--

LOCK TABLES `device` WRITE;
/*!40000 ALTER TABLE `device` DISABLE KEYS */;
INSERT INTO `device` VALUES
(1,1,'Lampe de salon','Lampe',1,'lamp00123','Philips'),
(2,2,'Haut-parleur Bluetooth','Haut-parleur',0,'spk98765','JBL'),
(3,3,'Lampe de chevet','Lampe',1,'lamp00456','IKEA'),
(4,1,'Prise connectée cuisine','Prise connectée',0,'plug11223','TP-Link'),
(5,2,'Haut-parleur salon','Haut-parleur',1,'spk22334','Sony'),
(6,3,'Prise connectée chambre','Prise connectée',1,'plug33445','Meross');
/*!40000 ALTER TABLE `device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES
('DoctrineMigrations\\Version20250415124144','2025-04-15 13:03:56',121);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vibe_id` int(11) NOT NULL,
  `label` varchar(25) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3BAE0AA74B255BC3` (`vibe_id`),
  CONSTRAINT `FK_3BAE0AA74B255BC3` FOREIGN KEY (`vibe_id`) REFERENCES `vibe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES
(1,1,'repas','2025-10-01 10:00:00','2025-10-01 12:00:00'),
(2,2,'anniversaire','2025-10-02 14:00:00','2025-10-02 16:00:00');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_room`
--

DROP TABLE IF EXISTS `event_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_room` (
  `event_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  PRIMARY KEY (`event_id`,`room_id`),
  KEY `IDX_6D541D3071F7E88B` (`event_id`),
  KEY `IDX_6D541D3054177093` (`room_id`),
  CONSTRAINT `FK_6D541D3054177093` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_6D541D3071F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_room`
--

LOCK TABLES `event_room` WRITE;
/*!40000 ALTER TABLE `event_room` DISABLE KEYS */;
INSERT INTO `event_room` VALUES
(1,1),
(1,3),
(2,1),
(2,2);
/*!40000 ALTER TABLE `event_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES
(1,'Fiesta.png',2),
(2,'Lamp.png',2),
(3,'Duo.png',2),
(4,'Chambre.jpg',3),
(5,'Cuisine.jpg',3),
(6,'Salon.jpg',3),
(7,'avatar1.jpg',1),
(8,'avatar2.jpg',1),
(9,'avatar3.jpg',1),
(10,'avatar4.jpg',1),
(11,'avatar5.jpg',1),
(12,'avatar6.jpg',1),
(13,'avatar7.jpg',1),
(14,'avatar8.jpg',1),
(15,'avatar9.jpg',1),
(16,'avatar10.jpg',1),
(17,'avatar11.jpg',1),
(18,'avatar12.jpg',1),
(19,'avatar13.jpg',1),
(20,'avatar14.jpg',1),
(21,'avatar15.png',1),
(22,'61140-3840x2160-spiderman-logo-wallpaper-desktop-4k.jpg',1);
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `pin_code` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8157AA0F3DA5256D` (`image_id`),
  CONSTRAINT `FK_8157AA0F3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES
(1,22,'Tom',1234),
(2,21,'Mayer',1234),
(3,7,'user3',1234),
(4,8,'user4',1234);
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `label` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_729F519B3DA5256D` (`image_id`),
  CONSTRAINT `FK_729F519B3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES
(1,6,'Salon'),
(2,4,'Chambre'),
(3,5,'Cuisine');
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_vibe`
--

DROP TABLE IF EXISTS `room_vibe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_vibe` (
  `room_id` int(11) NOT NULL,
  `vibe_id` int(11) NOT NULL,
  PRIMARY KEY (`room_id`,`vibe_id`),
  KEY `IDX_2101A66554177093` (`room_id`),
  KEY `IDX_2101A6654B255BC3` (`vibe_id`),
  CONSTRAINT `FK_2101A6654B255BC3` FOREIGN KEY (`vibe_id`) REFERENCES `vibe` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_2101A66554177093` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_vibe`
--

LOCK TABLES `room_vibe` WRITE;
/*!40000 ALTER TABLE `room_vibe` DISABLE KEYS */;
INSERT INTO `room_vibe` VALUES
(1,1),
(1,2),
(2,2),
(2,3),
(3,1),
(3,3);
/*!40000 ALTER TABLE `room_vibe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_data`
--

DROP TABLE IF EXISTS `setting_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_type_id` int(11) NOT NULL,
  `vibe_id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `data` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6C47DF8594A4C7D4` (`device_id`),
  KEY `IDX_6C47DF859D1E3C7B` (`setting_type_id`),
  KEY `IDX_6C47DF854B255BC3` (`vibe_id`),
  CONSTRAINT `FK_6C47DF854B255BC3` FOREIGN KEY (`vibe_id`) REFERENCES `vibe` (`id`),
  CONSTRAINT `FK_6C47DF8594A4C7D4` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`),
  CONSTRAINT `FK_6C47DF859D1E3C7B` FOREIGN KEY (`setting_type_id`) REFERENCES `setting_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_data`
--

LOCK TABLES `setting_data` WRITE;
/*!40000 ALTER TABLE `setting_data` DISABLE KEYS */;
INSERT INTO `setting_data` VALUES
(1,1,1,1,'25'),
(2,2,2,2,'50'),
(3,3,3,3,'#FF0000'),
(4,4,1,4,'75'),
(5,5,2,5,'80');
/*!40000 ALTER TABLE `setting_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_type`
--

DROP TABLE IF EXISTS `setting_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_type_id` int(11) NOT NULL,
  `label_key` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4D6A7BCFA147DA62` (`data_type_id`),
  CONSTRAINT `FK_4D6A7BCFA147DA62` FOREIGN KEY (`data_type_id`) REFERENCES `data_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_type`
--

LOCK TABLES `setting_type` WRITE;
/*!40000 ALTER TABLE `setting_type` DISABLE KEYS */;
INSERT INTO `setting_type` VALUES
(1,1,'température'),
(2,2,'puissance'),
(3,3,'couleur'),
(4,4,'luminosité'),
(5,5,'volume');
/*!40000 ALTER TABLE `setting_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_type_device`
--

DROP TABLE IF EXISTS `setting_type_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_type_device` (
  `setting_type_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  PRIMARY KEY (`setting_type_id`,`device_id`),
  KEY `IDX_1150AC619D1E3C7B` (`setting_type_id`),
  KEY `IDX_1150AC6194A4C7D4` (`device_id`),
  CONSTRAINT `FK_1150AC6194A4C7D4` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_1150AC619D1E3C7B` FOREIGN KEY (`setting_type_id`) REFERENCES `setting_type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_type_device`
--

LOCK TABLES `setting_type_device` WRITE;
/*!40000 ALTER TABLE `setting_type_device` DISABLE KEYS */;
INSERT INTO `setting_type_device` VALUES
(1,1),
(1,4),
(2,2),
(2,4),
(3,1),
(3,3),
(4,1),
(4,3),
(5,2),
(5,5);
/*!40000 ALTER TABLE `setting_type_device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `standard`
--

DROP TABLE IF EXISTS `standard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `standard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `security` int(11) NOT NULL,
  `energy` int(11) NOT NULL,
  `emotion` int(11) NOT NULL,
  `consciousness` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `standard`
--

LOCK TABLES `standard` WRITE;
/*!40000 ALTER TABLE `standard` DISABLE KEYS */;
INSERT INTO `standard` VALUES
(1,50,75,100,100),
(2,25,50,75,75),
(3,0,25,50,50),
(4,100,0,100,25);
/*!40000 ALTER TABLE `standard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_NAME` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES
(1,'admin','[\"ROLE_ADMIN\"]','$2y$13$v2moE9dBq7Vy4W7GUqxs8.5ERZMECTKnYqhwZeKpGrimKL2sFTzBW');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vibe`
--

DROP TABLE IF EXISTS `vibe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `vibe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `standard_id` int(11) NOT NULL,
  `label` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_42054C016F9BFC42` (`standard_id`),
  KEY `IDX_42054C01CCFA12B8` (`profile_id`),
  KEY `IDX_42054C013DA5256D` (`image_id`),
  CONSTRAINT `FK_42054C013DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`),
  CONSTRAINT `FK_42054C016F9BFC42` FOREIGN KEY (`standard_id`) REFERENCES `standard` (`id`),
  CONSTRAINT `FK_42054C01CCFA12B8` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vibe`
--

LOCK TABLES `vibe` WRITE;
/*!40000 ALTER TABLE `vibe` DISABLE KEYS */;
INSERT INTO `vibe` VALUES
(1,1,1,1,'Chill'),
(2,1,2,2,'Cozy'),
(3,1,3,3,'Sad');
/*!40000 ALTER TABLE `vibe` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-04-16  7:58:52
