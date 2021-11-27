-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 27 nov. 2021 à 13:26
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `librarybooklocator`
--



--
-- Structure de la table `espaces`
--

CREATE TABLE `espaces` (
  `idBatiment` int(11) NOT NULL,
  `nomLong` varchar(255) NOT NULL,
  `nomCourt` varchar(255) NOT NULL,
  `codeUnige` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `p1Latitude` varchar(255) NOT NULL,
  `p1Longitude` varchar(255) NOT NULL,
  `p2Latitude` varchar(255) NOT NULL,
  `p2Longitude` varchar(255) NOT NULL,
  `p3Latitude` varchar(255) NOT NULL,
  `p3Longitude` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `espaces`
--

INSERT INTO `espaces` (`idBatiment`, `nomLong`, `nomCourt`, `codeUnige`, `longitude`, `latitude`, `p1Latitude`, `p1Longitude`, `p2Latitude`, `p2Longitude`, `p3Latitude`, `p3Longitude`) VALUES
(1, 'Université Mail', 'Mail', 'Mail', '6.139895360858279', '46.194927185965064', '46.19485999832131', '6.138750314712524', '46.19580687978871', '6.1397695541381845', '46.194210168266004', '6.140005588531495');

-- --------------------------------------------------------

--
-- Structure de la table `espacesimages`
--

CREATE TABLE `espacesimages` (
  `idespaceimage` int(11) NOT NULL,
  `etage` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `idBatiment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `espacesimages`
--

INSERT INTO `espacesimages` (`idespaceimage`, `etage`, `url`, `idBatiment`) VALUES
(1, 1, 'http://10.20.18.116/Leaflet/plan-1-01_App%20copie_page-0001.jpg', 1),
(2, 2, 'http://10.20.18.116/Leaflet/plan-2-01_App%20copie_page-0001.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `locator`
--

CREATE TABLE `locator` (
  `idRange` int(11) NOT NULL,
  `idBatiment` int(11) NOT NULL,
  `etage` int(11) NOT NULL,
  `secteur` varchar(255) DEFAULT NULL,
  `salle` varchar(255) DEFAULT NULL,
  `racineDeweyDebut` varchar(255) NOT NULL,
  `racineDeweyFin` varchar(255) NOT NULL,
  `indiceDebut` varchar(255) NOT NULL,
  `indiceFin` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `estAccessible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Index pour la table `espaces`
--
ALTER TABLE `espaces`
  ADD PRIMARY KEY (`idBatiment`);

--
-- Index pour la table `espacesimages`
--
ALTER TABLE `espacesimages`
  ADD PRIMARY KEY (`idespaceimage`),
  ADD KEY `idBatiment` (`idBatiment`);

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
-- AUTO_INCREMENT pour la table `espaces`
--
ALTER TABLE `espaces`
  MODIFY `idBatiment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `espacesimages`
--
ALTER TABLE `espacesimages`
  MODIFY `idespaceimage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `locator`
--
ALTER TABLE `locator`
  MODIFY `idRange` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `espacesimages`
--
ALTER TABLE `espacesimages`
  ADD CONSTRAINT `espacesimages_ibfk_1` FOREIGN KEY (`idBatiment`) REFERENCES `espaces` (`idBatiment`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `locator`
--
ALTER TABLE `locator`
  ADD CONSTRAINT `locator_ibfk_1` FOREIGN KEY (`idBatiment`) REFERENCES `espaces` (`idBatiment`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
