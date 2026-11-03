-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 03 nov. 2026 à 12:35
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
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `cheminFichier` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivre`
--

CREATE TABLE `suivre` (
  `email_suiveur` varchar(255) NOT NULL,
  `email_suivi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `idTag` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `touite`
--

CREATE TABLE `touite` (
  `idMessage` int(11) NOT NULL,
  `texte` varchar(235) NOT NULL,
  `date_publication` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `cheminFichier` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `touite_tag`
--

CREATE TABLE `touite_tag` (
  `idMessage` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `email` varchar(255) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nombre_touites` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_tag`
--

CREATE TABLE `utilisateur_tag` (
  `email` varchar(255) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`cheminFichier`);

--
-- Index pour la table `suivre`
--
ALTER TABLE `suivre`
  ADD PRIMARY KEY (`email_suiveur`,`email_suivi`),
  ADD KEY `email_suivi` (`email_suivi`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`idTag`),
  ADD UNIQUE KEY `libelle` (`libelle`);

--
-- Index pour la table `touite`
--
ALTER TABLE `touite`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `email` (`email`),
  ADD KEY `cheminFichier` (`cheminFichier`);

--
-- Index pour la table `touite_tag`
--
ALTER TABLE `touite_tag`
  ADD PRIMARY KEY (`idMessage`,`idTag`),
  ADD KEY `idTag` (`idTag`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `utilisateur_tag`
--
ALTER TABLE `utilisateur_tag`
  ADD PRIMARY KEY (`email`,`idTag`),
  ADD KEY `idTag` (`idTag`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `suivre`
--
ALTER TABLE `suivre`
  ADD CONSTRAINT `suivre_ibfk_1` FOREIGN KEY (`email_suiveur`) REFERENCES `utilisateur` (`email`),
  ADD CONSTRAINT `suivre_ibfk_2` FOREIGN KEY (`email_suivi`) REFERENCES `utilisateur` (`email`);

--
-- Contraintes pour la table `touite`
--
ALTER TABLE `touite`
  ADD CONSTRAINT `touite_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateur` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `touite_ibfk_2` FOREIGN KEY (`cheminFichier`) REFERENCES `image` (`cheminFichier`) ON DELETE SET NULL;

--
-- Contraintes pour la table `touite_tag`
--
ALTER TABLE `touite_tag`
  ADD CONSTRAINT `touite_tag_ibfk_1` FOREIGN KEY (`idMessage`) REFERENCES `touite` (`idMessage`) ON DELETE CASCADE,
  ADD CONSTRAINT `touite_tag_ibfk_2` FOREIGN KEY (`idTag`) REFERENCES `tag` (`idTag`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateur_tag`
--
ALTER TABLE `utilisateur_tag`
  ADD CONSTRAINT `utilisateur_tag_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateur` (`email`),
  ADD CONSTRAINT `utilisateur_tag_ibfk_2` FOREIGN KEY (`idTag`) REFERENCES `tag` (`idTag`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
