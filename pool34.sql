-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 03 nov. 2026 à 09:05
-- Version du serveur : 10.11.16-MariaDB
-- Version de PHP : 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pool34`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `Pseudo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `follows`
--

CREATE TABLE `follows` (
  `Follower` varchar(30) NOT NULL,
  `Followed` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `followtag`
--

CREATE TABLE `followtag` (
  `Tag` varchar(30) NOT NULL,
  `Pseudo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `NomTag` varchar(30) NOT NULL,
  `IDMessage` decimal(5,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `touite`
--

CREATE TABLE `touite` (
  `IDMessage` decimal(5,0) NOT NULL,
  `Pseudo` varchar(30) DEFAULT NULL,
  `Image` varchar(50) DEFAULT NULL,
  `Likes` decimal(5,0) DEFAULT NULL,
  `Note` decimal(5,1) DEFAULT NULL,
  `DateMessage` date DEFAULT NULL,
  `Message` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `Pseudo` varchar(30) NOT NULL,
  `Photo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Pseudo`);

--
-- Index pour la table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`Follower`,`Followed`),
  ADD KEY `Followed` (`Followed`);

--
-- Index pour la table `followtag`
--
ALTER TABLE `followtag`
  ADD PRIMARY KEY (`Tag`,`Pseudo`),
  ADD KEY `Pseudo` (`Pseudo`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`NomTag`,`IDMessage`),
  ADD KEY `IDMessage` (`IDMessage`);

--
-- Index pour la table `touite`
--
ALTER TABLE `touite`
  ADD PRIMARY KEY (`IDMessage`),
  ADD KEY `Pseudo` (`Pseudo`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`Pseudo`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`Pseudo`) REFERENCES `utilisateur` (`Pseudo`);

--
-- Contraintes pour la table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`Follower`) REFERENCES `utilisateur` (`Pseudo`),
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`Followed`) REFERENCES `utilisateur` (`Pseudo`);

--
-- Contraintes pour la table `followtag`
--
ALTER TABLE `followtag`
  ADD CONSTRAINT `followtag_ibfk_1` FOREIGN KEY (`Tag`) REFERENCES `tags` (`NomTag`),
  ADD CONSTRAINT `followtag_ibfk_2` FOREIGN KEY (`Pseudo`) REFERENCES `utilisateur` (`Pseudo`);

--
-- Contraintes pour la table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`IDMessage`) REFERENCES `touite` (`IDMessage`);

--
-- Contraintes pour la table `touite`
--
ALTER TABLE `touite`
  ADD CONSTRAINT `touite_ibfk_1` FOREIGN KEY (`Pseudo`) REFERENCES `utilisateur` (`Pseudo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
