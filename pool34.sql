-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: pool34
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `cheminFichier` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`cheminFichier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `liker`
--

DROP TABLE IF EXISTS `liker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liker` (
  `email` varchar(255) NOT NULL,
  `idMessage` int(11) NOT NULL,
  PRIMARY KEY (`email`,`idMessage`),
  KEY `idMessage` (`idMessage`),
  CONSTRAINT `liker_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateur` (`email`) ON DELETE CASCADE,
  CONSTRAINT `liker_ibfk_2` FOREIGN KEY (`idMessage`) REFERENCES `touite` (`idMessage`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `noter`
--

DROP TABLE IF EXISTS `noter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noter` (
  `email` varchar(255) NOT NULL,
  `idMessage` int(11) NOT NULL,
  `note` tinyint(4) NOT NULL CHECK (`note` between 1 and 5),
  PRIMARY KEY (`email`,`idMessage`),
  KEY `idMessage` (`idMessage`),
  CONSTRAINT `noter_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateur` (`email`) ON DELETE CASCADE,
  CONSTRAINT `noter_ibfk_2` FOREIGN KEY (`idMessage`) REFERENCES `touite` (`idMessage`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `suivre`
--

DROP TABLE IF EXISTS `suivre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suivre` (
  `email_suiveur` varchar(255) NOT NULL,
  `email_suivi` varchar(255) NOT NULL,
  PRIMARY KEY (`email_suiveur`,`email_suivi`),
  KEY `email_suivi` (`email_suivi`),
  CONSTRAINT `suivre_ibfk_1` FOREIGN KEY (`email_suiveur`) REFERENCES `utilisateur` (`email`),
  CONSTRAINT `suivre_ibfk_2` FOREIGN KEY (`email_suivi`) REFERENCES `utilisateur` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `idTag` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`idTag`),
  UNIQUE KEY `libelle` (`libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `touite`
--

DROP TABLE IF EXISTS `touite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `touite` (
  `idMessage` int(11) NOT NULL AUTO_INCREMENT,
  `texte` varchar(235) NOT NULL,
  `date_publication` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `cheminFichier` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idMessage`),
  KEY `email` (`email`),
  KEY `cheminFichier` (`cheminFichier`),
  CONSTRAINT `touite_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateur` (`email`) ON DELETE CASCADE,
  CONSTRAINT `touite_ibfk_2` FOREIGN KEY (`cheminFichier`) REFERENCES `image` (`cheminFichier`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `touite_tag`
--

DROP TABLE IF EXISTS `touite_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `touite_tag` (
  `idMessage` int(11) NOT NULL,
  `idTag` int(11) NOT NULL,
  PRIMARY KEY (`idMessage`,`idTag`),
  KEY `idTag` (`idTag`),
  CONSTRAINT `touite_tag_ibfk_1` FOREIGN KEY (`idMessage`) REFERENCES `touite` (`idMessage`) ON DELETE CASCADE,
  CONSTRAINT `touite_tag_ibfk_2` FOREIGN KEY (`idTag`) REFERENCES `tag` (`idTag`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `email` varchar(255) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nombre_touites` int(11) DEFAULT 0,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `utilisateur_tag`
--

DROP TABLE IF EXISTS `utilisateur_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur_tag` (
  `email` varchar(255) NOT NULL,
  `idTag` int(11) NOT NULL,
  PRIMARY KEY (`email`,`idTag`),
  KEY `idTag` (`idTag`),
  CONSTRAINT `utilisateur_tag_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateur` (`email`),
  CONSTRAINT `utilisateur_tag_ibfk_2` FOREIGN KEY (`idTag`) REFERENCES `tag` (`idTag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
