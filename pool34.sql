-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : lun. 16 nov. 2026 à 17:35
-- Version du serveur : 12.3.3-MariaDB-ubu2404
-- Version de PHP : 8.3.33

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

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`cheminFichier`, `description`) VALUES
('', ''),
('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_v14F_BxoZxKcN7enD-Tid_yW60-pWZDUcekfCkvYruBs__AL4GWOQak&s=10', NULL),
('https://gifdb.com/images/thumbnail/girl-saying-random-kid-qq81zg3550kc9hjl.gif', 'random kid'),
('https://klipy.com/gifs/sunna-zzz-3', 'random kid'),
('https://m.media-amazon.com/images/I/51kgT7eWF-L._AC_UF1000,1000_QL80_.jpg', ''),
('https://marketplace.canva.com/MABE1WFIKi8/1/thumbnail_large-1/canva-funny-dog-MABE1WFIKi8.jpg', ''),
('https://media.tenor.com/2vyfLyAtdWsAAAAM/jean-dylan-dylan.gif', '');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `email` varchar(255) NOT NULL,
  `IdMessage` int(11) NOT NULL,
  `Validation` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notation`
--

CREATE TABLE `notation` (
  `email` varchar(255) NOT NULL,
  `IdMessage` int(11) NOT NULL,
  `Note` int(11) DEFAULT NULL CHECK (`Note` > 0 and `Note` <= 6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivre`
--

CREATE TABLE `suivre` (
  `email_suiveur` varchar(255) NOT NULL,
  `email_suivi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `suivre`
--

INSERT INTO `suivre` (`email_suiveur`, `email_suivi`) VALUES
('Guenego@etu.univ-lorraine.fr', 'benjamin.cordonnier9@etu.univ-lorraine.fr'),
('benjamin.cordonnier9@etu.univ-lorraine.fr', 'Guenego@etu.univ-lorraine.fr'),
('benjamin.cordonnier9@etu.univ-lorraine.fr', 'test@test.fr');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `idTag` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`idTag`, `libelle`, `description`) VALUES
(1, 'testlibelle', NULL),
(2, 'donnezvospoubelles', NULL),
(3, 'bite', ''),
(4, 'tag', '');

-- --------------------------------------------------------

--
-- Structure de la table `touite`
--

CREATE TABLE `touite` (
  `idMessage` int(11) NOT NULL,
  `texte` varchar(235) NOT NULL,
  `date_publication` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `cheminFichier` varchar(255) DEFAULT NULL,
  `Likes` int(11) NOT NULL DEFAULT 0,
  `Note` decimal(2,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `touite`
--

INSERT INTO `touite` (`idMessage`, `texte`, `date_publication`, `email`, `cheminFichier`, `Likes`, `Note`) VALUES
(1, 'bite', '2026-11-05 10:29:01', 'test@test.fr', NULL, 0, NULL),
(2, 'bite', '2026-11-05 10:31:03', 'test@test.fr', NULL, 0, NULL),
(3, 'bite', '2026-11-05 18:26:29', 'test@test.fr', NULL, 0, NULL),
(4, 'bite', '2026-11-10 08:28:17', 'test@test.fr', NULL, 0, NULL),
(5, 'Bonjour', '2026-11-10 10:56:34', 'benjamin.cordonnier9@etu.univ-lorraine.fr', NULL, 0, NULL),
(6, 'bite #bite', '2026-11-10 13:28:00', 'benjamin.cordonnier9@etu.univ-lorraine.fr', NULL, 0, NULL),
(7, 'bite #bite', '2026-11-10 13:28:06', 'benjamin.cordonnier9@etu.univ-lorraine.fr', NULL, 0, NULL),
(8, 'test Image', '2026-11-10 13:56:53', 'benjamin.cordonnier9@etu.univ-lorraine.fr', 'https://m.media-amazon.com/images/I/51kgT7eWF-L._AC_UF1000,1000_QL80_.jpg', 0, NULL),
(9, 'bit e teste im', '2026-11-10 14:15:50', 'benjamin.cordonnier9@etu.univ-lorraine.fr', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_v14F_BxoZxKcN7enD-Tid_yW60-pWZDUcekfCkvYruBs__AL4GWOQak&s=10', 0, NULL),
(10, 'random kid spotted', '2026-11-10 14:25:51', 'benjamin.cordonnier9@etu.univ-lorraine.fr', 'https://klipy.com/gifs/sunna-zzz-3', 0, NULL),
(11, 'random kid spotted', '2026-11-10 14:29:19', 'benjamin.cordonnier9@etu.univ-lorraine.fr', 'https://gifdb.com/images/thumbnail/girl-saying-random-kid-qq81zg3550kc9hjl.gif', 0, NULL),
(12, 'salut c moi tchoupi', '2026-11-13 19:03:18', 'Guenego@etu.univ-lorraine.fr', '', 0, NULL),
(13, 'Hello World !', '2026-11-13 19:47:51', 'admin@touiteur.fr', '', 0, NULL),
(14, 'bite #bite', '2026-11-14 15:13:53', 'benjamin.cordonnier9@etu.univ-lorraine.fr', '', 0, NULL),
(15, 'image dorle', '2026-11-14 15:34:43', 'benjamin.cordonnier9@etu.univ-lorraine.fr', 'https://marketplace.canva.com/MABE1WFIKi8/1/thumbnail_large-1/canva-funny-dog-MABE1WFIKi8.jpg', 0, NULL),
(16, 'Bonjour ceci est un teste de #tag', '2026-11-15 18:53:55', 'benjamin.cordonnier9@etu.univ-lorraine.fr', NULL, 0, NULL),
(17, 'bite', '2026-11-16 14:41:29', 'benjamin.cordonnier9@etu.univ-lorraine.fr', 'https://media.tenor.com/2vyfLyAtdWsAAAAM/jean-dylan-dylan.gif', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `touite_tag`
--

CREATE TABLE `touite_tag` (
  `idMessage` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `touite_tag`
--

INSERT INTO `touite_tag` (`idMessage`, `idTag`) VALUES
(1, 2),
(5, 3),
(6, 3),
(13, 3),
(16, 4);

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

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`email`, `nom`, `prenom`, `nombre_touites`) VALUES
('admin@touiteur.fr', 'admin', 'Supreme Leader', 0),
('benjamin.cordonnier9@etu.univ-lorraine.fr', 'Doom', 'Slayer', 0),
('Guenego@etu.univ-lorraine.fr', 'Ganego', 'Pior', 0),
('test@test.fr', 'testN', 'testP', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_tag`
--

CREATE TABLE `utilisateur_tag` (
  `email` varchar(255) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur_tag`
--

INSERT INTO `utilisateur_tag` (`email`, `idTag`) VALUES
('benjamin.cordonnier9@etu.univ-lorraine.fr', 3),
('Guenego@etu.univ-lorraine.fr', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`cheminFichier`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`email`,`IdMessage`),
  ADD KEY `IdMessage` (`IdMessage`);

--
-- Index pour la table `notation`
--
ALTER TABLE `notation`
  ADD PRIMARY KEY (`email`,`IdMessage`),
  ADD KEY `IdMessage` (`IdMessage`);

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
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `idTag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `touite`
--
ALTER TABLE `touite`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateur` (`email`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`IdMessage`) REFERENCES `touite` (`idMessage`);

--
-- Contraintes pour la table `notation`
--
ALTER TABLE `notation`
  ADD CONSTRAINT `notation_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateur` (`email`),
  ADD CONSTRAINT `notation_ibfk_2` FOREIGN KEY (`IdMessage`) REFERENCES `touite` (`idMessage`);

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
