-- phpMyAdmin SQL Dump
-- version 4.9.5deb2~bpo10+1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 26 nov. 2021 à 14:18
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `locator`
--

-- --------------------------------------------------------

--
-- Structure de la table `locator`
--

CREATE TABLE `locator` (
  `idRange` int NOT NULL,
  `idBatiment` int NOT NULL,
  `etage` int NOT NULL,
  `secteur` varchar(255) DEFAULT NULL,
  `salle` varchar(255) DEFAULT NULL,
  `racineDeweyDebut` varchar(255) NOT NULL,
  `racineDeweyFin` varchar(255) NOT NULL,
  `indiceDebut` varchar(255) NOT NULL,
  `indiceFin` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `estAccessible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `locator`
--

INSERT INTO `locator` (`idRange`, `idBatiment`, `etage`, `secteur`, `salle`, `racineDeweyDebut`, `racineDeweyFin`, `indiceDebut`, `indiceFin`, `longitude`, `latitude`, `estAccessible`) VALUES
(5, 1, 2, 'espace audiovisuel', 'fictions', '791.43', '791.43', 'AAA', 'ZZZ', '6.14037', '46.19520', 1),
(6, 1, 2, 'espace audiovisuel', 'documentaires', '001', '999', 'AAA', 'ZZZ', '6.14046', '46.19517', 0),
(7, 1, 1, 'espace presse', 'presse', '', '', '', '', '6.13977', '46.19534', 0),
(8, 1, 1, 'espace presse', 'BD', 'BD', 'BD', 'AAA', 'ZZZ', '6.13988', '46.19537', 0),
(9, 1, 1, 'Droit ', 'droit suisse', 'CA/CH', 'CA/CH', '', '', '6.13936', '46.19496', 0),
(10, 1, 1, 'Droit ', 'droit généralités', 'A', 'A', '', '', '6.13960', '46.19496', 0),
(11, 1, 2, 'traduction', '', '001', '999', 'AAA', 'ZZZ', '6.14057', '46.19496', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `locator`
--
ALTER TABLE `locator`
  ADD PRIMARY KEY (`idRange`),
  ADD KEY `idBatiment` (`idBatiment`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `locator`
--
ALTER TABLE `locator`
  MODIFY `idRange` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `locator`
--
ALTER TABLE `locator`
  ADD CONSTRAINT `locator_ibfk_1` FOREIGN KEY (`idBatiment`) REFERENCES `espaces` (`idBatiment`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
