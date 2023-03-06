-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 06 mars 2023 à 08:40
-- Version du serveur : 5.7.39
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique_konexio`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `etat` enum('en cours','validé','expédié','livré') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_membre`, `montant`, `date_enregistrement`, `etat`) VALUES
(1, 5, 59, '2023-02-27 10:39:45', 'livré'),
(2, 1, 50, '2023-02-27 10:49:34', 'livré'),
(13, 1, 26, '2023-02-28 11:06:11', 'en cours'),
(14, 1, 26, '2023-02-28 12:06:51', 'en cours');

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE `details_commande` (
  `id` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `details_commande`
--

INSERT INTO `details_commande` (`id`, `id_commande`, `id_produit`, `quantite`, `prix`) VALUES
(10, 1, 1, 1, 26),
(17, 2, 2, 1, 50),
(18, 13, 1, 1, 26),
(19, 14, 1, 1, 26);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(11) NOT NULL DEFAULT '0',
  `adresse` varchar(255) NOT NULL,
  `code_postal` int(5) UNSIGNED ZEROFILL NOT NULL,
  `ville` varchar(100) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `statut`, `adresse`, `code_postal`, `ville`, `pays`, `create_at`) VALUES
(1, 'Sinbad75', '$2y$12$pdUBele2neoV9YFIgDOEC.Z8EapbkWW6xeWjaG1WZGHty1LIQDjpi', 'EEER AALLA', 'Riad', 'sinbad75@gmail.com', 'm', 1, '01 rue des Chandeliers', 75001, 'Paris', 'France', '2023-02-20 11:50:21'),
(2, 'AlexCouscous', '$2y$12$VuVzNyoyUfxMQc5y4FIZGu8eqcpSB4bhE5MZZ/C..uUWKgEQXVGxe', 'ROBERT', 'Alexandre', 'alexcouscous@gmail.com', 'm', 1, '20 rue de la Couscousière', 75001, 'Paris', 'France', '2023-02-20 11:53:02'),
(4, 'AugustinLaFumette', '$2y$12$Q.I1qgqUmfimsEELMnob6uumrOn7xWRjdG9GGmj3Cd9bTOfH1Av4S', 'Fumette', 'Augustin', 'auguslafume@gmail.com', 'm', 0, '5 rue de la fumette', 75001, 'Paris', 'France', '2023-02-20 11:54:55');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `categorie` varchar(100) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `couleur` varchar(100) NOT NULL,
  `taille` varchar(100) NOT NULL,
  `public` enum('m','f','mixte','enfant') NOT NULL,
  `photo` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES
(1, '0526/407', 'T-SHIRT', 'T-SHIRT LOGO X RHUIGI', 'T-shirt ample à col rond et manches courtes. Imprimé avec logo en contraste sur le devant.', 'Autre', 'M', 'm', 'https://static.zara.net/photos///2023/V/0/1/p/0526/407/707/2/w/750/0526407707_1_1_1.jpg?ts=1676544351388', 26, 0),
(2, '928323', 'PANTALON', 'PANTALON CARGO TIE DYE', 'Pantalon à taille élastique réglable par cordon. Poches avant et poches arrière. Application de poches plaquées sur les jambes. Ourlet ajustable avec élastique sur les côtés.', 'Vert', 'M', 'm', 'https://static.zara.net/photos///2023/V/0/2/p/2553/431/707/2/w/750/2553431707_1_1_1.jpg?ts=1675340206311', 50, 6),
(8, '5388/405', 'VESTES', 'BLOUSON EN CUIR VINTAGE X RHUIGI ÉDITION LIMITÉE', 'Blouson confectionné en cuir. Col à revers et manches longues. Poches à double passepoil aux hanches et poche intérieure. Application de pièces sur le devant et au dos bimatière avec broderies ton sur ton. Effet délavé. Finitions côtelées. Fermeture par boutons-pression sur le devant.', 'Noir', 'L', 'm', 'https://static.zara.net/photos///2023/V/0/2/p/5388/405/800/2/w/750/5388405800_2_4_1.jpg?ts=1676368469271', 199, 10),
(9, '4736/024', 'BIJOUX', 'BOUCLES D\'OREILLES À PERLES ET STRASS', 'Boucles d\'oreilles longues avec application perles et strass. Fermoir clou.', 'Autre', 'Autre', 'f', 'https://static.zara.net/photos///2023/V/0/1/p/4736/024/810/2/w/750/4736024810_1_1_1.jpg?ts=1676544480805', 13, 20),
(10, '4341/826', 'VESTES', 'BLOUSON EN MATIÈRE SYNTHÉTIQUE', 'Blouson avec col à rabat et manches longues. Poches avant avec zip en métal. Passants aux épaules. Application ceinture de même tissu avec boucle. Fermeture zip en métal sur le devant.', 'Autre', 'M', 'f', 'https://static.zara.net/photos///2023/V/0/1/p/4341/826/822/13/w/750/4341826822_1_1_1.jpg?ts=1674061077708', 60, 10);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `details_commande`
--
ALTER TABLE `details_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `details_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `details_commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
