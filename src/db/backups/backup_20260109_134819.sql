-- MySQL dump 10.13  Distrib 8.0.44, for Linux (aarch64)
--
-- Host: localhost    Database: mydatabase
-- ------------------------------------------------------
-- Server version	8.0.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `LibrarySetDefinitions`
--

DROP TABLE IF EXISTS `LibrarySetDefinitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `LibrarySetDefinitions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `source_language` varchar(50) NOT NULL,
  `target_language` varchar(50) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `description` text,
  `words_json` text NOT NULL,
  `status` enum('pending','processing','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_topic` (`topic`),
  KEY `idx_source_language` (`source_language`),
  KEY `idx_target_language` (`target_language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LibrarySetDefinitions`
--

LOCK TABLES `LibrarySetDefinitions` WRITE;
/*!40000 ALTER TABLE `LibrarySetDefinitions` DISABLE KEYS */;
/*!40000 ALTER TABLE `LibrarySetDefinitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LibrarySetWords`
--

DROP TABLE IF EXISTS `LibrarySetWords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `LibrarySetWords` (
  `id` int NOT NULL AUTO_INCREMENT,
  `library_set_id` int NOT NULL,
  `word` varchar(255) NOT NULL,
  `translation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_library_set_id` (`library_set_id`),
  CONSTRAINT `LibrarySetWords_ibfk_1` FOREIGN KEY (`library_set_id`) REFERENCES `LibrarySets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LibrarySetWords`
--

LOCK TABLES `LibrarySetWords` WRITE;
/*!40000 ALTER TABLE `LibrarySetWords` DISABLE KEYS */;
/*!40000 ALTER TABLE `LibrarySetWords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LibrarySets`
--

DROP TABLE IF EXISTS `LibrarySets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `LibrarySets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `source_language` varchar(50) NOT NULL,
  `target_language` varchar(50) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `description` text,
  `word_count` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_topic` (`topic`),
  KEY `idx_source_language` (`source_language`),
  KEY `idx_target_language` (`target_language`),
  KEY `idx_level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LibrarySets`
--

LOCK TABLES `LibrarySets` WRITE;
/*!40000 ALTER TABLE `LibrarySets` DISABLE KEYS */;
/*!40000 ALTER TABLE `LibrarySets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sets`
--

DROP TABLE IF EXISTS `Sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Sets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `set_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `word` varchar(255) DEFAULT NULL,
  `translation` varchar(255) DEFAULT NULL,
  `is_library` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_set_id` (`set_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_is_library` (`is_library`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sets`
--

LOCK TABLES `Sets` WRITE;
/*!40000 ALTER TABLE `Sets` DISABLE KEYS */;
INSERT INTO `Sets` VALUES (2,2,1,'sret2','as','dd',0),(4,4,1,'test2','a','b',0),(5,4,1,'test2','a','b',0),(6,4,1,'test2','a','b',0),(7,7,1,'test3','a','b',0),(8,7,1,'test3','c','d',0),(9,7,1,'test3','e','f',0),(10,7,1,'test3','b','n',0),(11,7,1,'test3','n','m',0),(12,7,1,'test3','w','e',0),(13,7,1,'test3','d','s',0),(14,7,1,'test3','q','w',0),(15,7,1,'test3','a','g',0),(18,18,11,'6','e','d',0),(19,19,12,'set1','a','b',0),(20,19,12,'set1','c','d',0),(21,21,13,'set1','a','g',0),(22,22,13,'Food - Beginner','Food','Comida',0),(23,22,13,'Food - Beginner','Fruit','Fruta',0),(24,22,13,'Food - Beginner','Vegetable','Verdura',0),(25,22,13,'Food - Beginner','Meat','Carnes',0),(26,22,13,'Food - Beginner','Bread','Pan',0),(27,22,13,'Food - Beginner','Drink','Bebida',0),(28,28,13,'Animals - Intermediate','Mammal','Säugetier',0),(29,28,13,'Animals - Intermediate','Species','Arten',0),(30,28,13,'Animals - Intermediate','Migration','Wanderung',0),(31,28,13,'Animals - Intermediate','Habitat','Lebensraum',0),(32,28,13,'Animals - Intermediate','Prey','Beute',0),(33,28,13,'Animals - Intermediate','Predator','Beutegreifer',0),(34,28,13,'Animals - Intermediate','Conservation','Schutz',0),(35,28,13,'Animals - Intermediate','Endangered','gefährdet',0),(36,28,13,'Animals - Intermediate','Hibernation','Hibernation',0),(37,28,13,'Animals - Intermediate','Biodiversity','Artenvielfalt',0),(38,38,13,'Tiere - Advanced','Fledermäuse','Фледермаусы',0),(39,38,13,'Tiere - Advanced','Tierarten','Терартения',0),(40,38,13,'Tiere - Advanced','Übergroß','Умерогрозай',0),(41,38,13,'Tiere - Advanced','Mammalia','Маммалии',0),(42,38,13,'Tiere - Advanced','Säugetiere','Саекоплацие',0),(43,38,13,'Tiere - Advanced','Tiersoziologie','Терсозиология',0),(44,38,13,'Tiere - Advanced','Verhaltensforschung','Подвигательная философия',0),(45,38,13,'Tiere - Advanced','Wildtiere','Вилдьние тиера',0),(46,38,13,'Tiere - Advanced','Tierschutz','Теразахиска',0),(47,38,13,'Tiere - Advanced','Zoopsychologie','Зоопсихологий',0),(48,48,13,'Food - Beginner','meat','Fleisch',0),(49,48,13,'Food - Beginner','fish','Fisch',0),(50,48,13,'Food - Beginner','vegetable','Kohl',0),(51,48,13,'Food - Beginner','fruit','Frucht',0),(52,48,13,'Food - Beginner','bread','Brot',0),(53,48,13,'Food - Beginner','salad','Salat',0),(54,48,13,'Food - Beginner','sugar','Zucker',0),(55,48,13,'Food - Beginner','rice','Reis',0),(56,48,13,'Food - Beginner','beef','Rindfleisch',0),(57,48,13,'Food - Beginner','milk','Milch',0),(58,58,13,'Food - Beginner','bread','Брюч',0),(59,58,13,'Food - Beginner','fruit','овост',0),(60,58,13,'Food - Beginner','meat','мясо',0),(61,58,13,'Food - Beginner','water','вода',0),(62,58,13,'Food - Beginner','juice','жизне',0),(63,58,13,'Food - Beginner','rice','равиол',0),(64,58,13,'Food - Beginner','vegetable','овостия',0),(65,58,13,'Food - Beginner','sugar','сазар',0),(66,58,13,'Food - Beginner','cake','дерман',0),(67,58,13,'Food - Beginner','milk','масло',0),(68,68,13,'Animals - Intermediate','Migratory','Animals that travel long distances to find food or suitable habitats.',0),(69,68,13,'Animals - Intermediate','Herbivore','An animal that eats and digests plant-based foods, such as fruits and grains.',0),(70,68,13,'Animals - Intermediate','Carnivore','An animal that primarily eats meat, including flesh and organs of other animals.',0),(71,68,13,'Animals - Intermediate','Habitat','The natural environment where an animal lives, including plants, climate, and other factors.',0),(72,68,13,'Animals - Intermediate','Predator','An animal that hunts and kills other animals for food or survival.',0),(73,68,13,'Animals - Intermediate','Prey','Animals that are hunted and killed by other animals for food or survival.',0),(74,68,13,'Animals - Intermediate','Territorial','An animal that defends its own territory from other animals.',0),(75,68,13,'Animals - Intermediate','Nocturnal','Animals that are active at night and rest during the day.',0),(76,68,13,'Animals - Intermediate','Migration','The movement of animals from one place to another at certain times of the year.',0),(77,68,13,'Animals - Intermediate','Hibernation','A state of inactivity and reduced body temperature in some animals during winter.',0),(78,68,13,'Animals - Intermediate','Omnivore','An animal that eats both plant-based foods and meat.',0),(79,68,13,'Animals - Intermediate','Species','A group of living organisms that share similar characteristics and can breed together.',0),(80,80,13,'Food - Intermediate','Savory','чабер (пряности)',0),(81,80,13,'Food - Intermediate','Garnish','Гарнир',0),(82,80,13,'Food - Intermediate','Bouillon','Буйон',0),(83,80,13,'Food - Intermediate','Baste','Басте',0),(84,80,13,'Food - Intermediate','Spatula','Лопатка',0),(85,80,13,'Food - Intermediate','Simmer','Кипятить на медленном огне',0),(86,80,13,'Food - Intermediate','Roux','Ру',0),(87,80,13,'Food - Intermediate','Whisk','Венчик',0),(88,80,13,'Food - Intermediate','Morsel','Пища',0),(89,80,13,'Food - Intermediate','Glaze','Глазурь',0),(100,90,13,'Travel - Intermediate','sightsee','sehenswürdigkeiten',0),(101,90,13,'Travel - Intermediate','destination','Reiseziel',0),(102,90,13,'Travel - Intermediate','passport','Reisepass',0),(103,90,13,'Travel - Intermediate','visa','Visum',0),(104,90,13,'Travel - Intermediate','accommodate','unterbringen',0),(105,90,13,'Travel - Intermediate','excursion','Exkursion',0),(106,90,13,'Travel - Intermediate','trekking','Wandern',0),(107,90,13,'Travel - Intermediate','backpacker','backpacker',0),(108,90,13,'Travel - Intermediate','currency','Währung',0),(118,109,13,'Food - Beginner','Fleisch','Мясо',0),(119,109,13,'Food - Beginner','Gemüse','Овощи',0),(120,109,13,'Food - Beginner','Kuchen','Пирог',0),(121,109,13,'Food - Beginner','Fisch','Рыба',0),(122,109,13,'Food - Beginner','Obst','Фрукты',0),(123,109,13,'Food - Beginner','Getränk','Напиток',0),(124,109,13,'Food - Beginner','Nudeln','Макароны',0),(125,109,13,'Food - Beginner','Brot','Хлеб',0),(126,126,13,'Food - Pre-Intermediate (B1)','Nourishment','Ernährung',0),(127,126,13,'Food - Pre-Intermediate (B1)','Ingredient','Inhaltsstoff',0),(128,126,13,'Food - Pre-Intermediate (B1)','Recipe','Rezept',0),(129,126,13,'Food - Pre-Intermediate (B1)','Garnish','Garnitur',0),(130,126,13,'Food - Pre-Intermediate (B1)','Cuisine','Küche',0),(136,131,13,'Numbers 1-5 - Beginner (A1)','eins','one',0),(137,131,13,'Numbers 1-5 - Beginner (A1)','zwei','two',0),(138,131,13,'Numbers 1-5 - Beginner (A1)','drei','three',0),(139,139,13,'test','1','2',0);
/*!40000 ALTER TABLE `Sets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (9,'Rin','r@gmail.com','$2y$10$Xxy7/md2DTx60Qvvv/Z1duMwPtTreiBLcKGifOUdOGs7wLR8NDq4y'),(10,'Rin','g@gmail.com','$2y$10$Zfv6vvsvcqIEkY6dKXGQMOkA4DWMh5viF1zWOWS8/6jZgDb9DKnee'),(11,'bro1','b@gmail.comm','$2y$10$K8Ec9Ki.KDxweLkh7B/Rj.jKEMxgO.y7RLCqNnnNE9M5vxzvYP08C'),(12,'bro2','l@gmail.com','$2y$10$gfqnKWmA4rcJ5ieV6ItZKOk1wUVVy.q8LuxK5GcbpZRtuh6DjNYJu'),(13,'ew','m@gmail.com','$2y$10$TpmplWg9NywMrXPtrzzgeOFnSoWxLv2a35rjrVtLHQjoL/R/A7HJG'),(14,'bro3','b3@gmail.com','$2y$10$pe2xiV5VbQC1CHQQ8bLwien4s.Q5Aj43dXLfQWShXJtZx8Ou/LhXC');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phinxlog`
--

DROP TABLE IF EXISTS `phinxlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phinxlog` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phinxlog`
--

LOCK TABLES `phinxlog` WRITE;
/*!40000 ALTER TABLE `phinxlog` DISABLE KEYS */;
INSERT INTO `phinxlog` VALUES (20240101000001,'InitialSchema','2026-01-09 12:25:46','2026-01-09 12:25:46',0);
/*!40000 ALTER TABLE `phinxlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'mydatabase'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-09 12:48:19
