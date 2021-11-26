-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 26 nov. 2021 à 13:29
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

-- --------------------------------------------------------

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
(1, 'Bastions Bibliothèque Centrale', 'BCEN', '123', '123123', '123456', '1', '1', '2', '2', '3', '3');

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
  MODIFY `idespaceimage` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `locator`
--
ALTER TABLE `locator`
  MODIFY `idRange` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
