-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 14 déc. 2020 à 14:34
-- Version du serveur :  10.4.15-MariaDB
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u415726231_faceme`
--

-- --------------------------------------------------------

--
-- Structure de la table `aime`
--

CREATE TABLE `aime` (
  `id` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `idPost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `aime`
--

INSERT INTO `aime` (`id`, `idUtilisateur`, `idPost`) VALUES
(4, 1, 41),
(5, 13, 50),
(6, 13, 53),
(8, 10, 75);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `contenu` text COLLATE utf8_bin DEFAULT NULL,
  `dateCom` datetime NOT NULL,
  `imageCom` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `idAuteur` int(11) NOT NULL,
  `idPost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `ecrit`
--

CREATE TABLE `ecrit` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `dateEcrit` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `idAuteur` int(11) NOT NULL,
  `idAmi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ecrit`
--

INSERT INTO `ecrit` (`id`, `titre`, `contenu`, `dateEcrit`, `image`, `likes`, `idAuteur`, `idAmi`) VALUES
(50, NULL, 'yo', '2020-12-14 08:44:22', NULL, NULL, 13, 13),
(51, NULL, NULL, '2020-12-14 08:44:39', NULL, NULL, 13, 13),
(52, NULL, '', '2020-12-14 08:45:03', 'uploads/post/fb87582825f9d28a8d42c5e5e5e8b23d.png', NULL, 13, 13),
(53, NULL, '', '2020-12-14 08:46:10', 'uploads/post/1fb87582825f9d28a8d42c5e5e5e8b23d.png', NULL, 13, 13),
(54, NULL, '', '2020-12-14 08:53:43', 'uploads/post/44270113_1182508351907329_5904549308568436736_o.jpg', NULL, 13, 13),
(55, NULL, '', '2020-12-14 08:54:01', 'uploads/post/a40039d16016face7aade4f7661c0d16.jpg', NULL, 13, 13),
(56, NULL, '', '2020-12-14 08:54:13', 'uploads/post/EMWLuC7VAAAPv3M.jpg', NULL, 13, 13),
(57, NULL, '', '2020-12-14 08:54:25', 'uploads/post/619461.jpg', NULL, 13, 13),
(76, NULL, 'Tout ce brouillard dans Paris !!', '2020-12-14 14:06:24', 'uploads/post/1Assassin\'s Creed® Unity2019-1-8-0-50-32.jpg', NULL, 14, 14),
(77, NULL, 'Bonjour, bienvenue à tous sur notre réseau social 100% MMI ! ', '2020-12-14 14:06:53', NULL, NULL, 14, 14);

-- --------------------------------------------------------

--
-- Structure de la table `lien`
--

CREATE TABLE `lien` (
  `id` int(11) NOT NULL,
  `idUtilisateur1` int(11) NOT NULL,
  `idUtilisateur2` int(11) NOT NULL,
  `etat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `picture` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `dateImage` datetime NOT NULL,
  `idAuteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `pictures`
--

INSERT INTO `pictures` (`id`, `picture`, `dateImage`, `idAuteur`) VALUES
(8, 'uploads/pictures/fb87582825f9d28a8d42c5e5e5e8b23d.png', '2020-12-13 11:47:32', 12),
(9, 'uploads/post/fb87582825f9d28a8d42c5e5e5e8b23d.png', '2020-12-14 08:45:03', 13),
(10, 'uploads/post/1fb87582825f9d28a8d42c5e5e5e8b23d.png', '2020-12-14 08:46:10', 13),
(11, 'uploads/post/44270113_1182508351907329_5904549308568436736_o.jpg', '2020-12-14 08:53:43', 13),
(12, 'uploads/post/a40039d16016face7aade4f7661c0d16.jpg', '2020-12-14 08:54:01', 13),
(13, 'uploads/post/EMWLuC7VAAAPv3M.jpg', '2020-12-14 08:54:13', 13),
(14, 'uploads/post/619461.jpg', '2020-12-14 08:54:25', 13),
(16, 'uploads/post/1Assassin\'s Creed® Unity2019-1-8-0-50-32.jpg', '2020-12-14 14:06:24', 14);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `remember` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `background` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `mdp`, `email`, `remember`, `avatar`, `background`, `bio`) VALUES
(13, 'Léo Hilaire', '*D7A0A1E5D3C136A67B81FEF39A571921F3E76394', 'leohilaire.contact@gmail.com', NULL, 'uploads/pictures/avatars/4dr.gif', 'uploads/pictures/backgrounds/5fb87582825f9d28a8d42c5e5e5e8b23d.png', 'Bonjour, je suis Léo H'),
(14, 'Edouard Bucamp', '*CF51CBD3096B3D780AF99C821164A2AD876577A0', 'edouard@gmail.com', NULL, 'uploads/pictures/avatars/1.jpg', 'uploads/pictures/backgrounds/3.jpg', 'Edouard Bucamp, co-fondateur de FaceMe'),
(15, 'Valentine Ghesquiere', '*FDDC16626942ACFA0784CB3CD465CCCD835D075F', 'valentine.ghesquiere@gmail.com', NULL, 'uploads/pictures/avatars/20191227_122711.jpg', 'uploads/pictures/backgrounds/1578581164-2331-jaquette-avant.jpg', 'Bonjour, je suis Valentine Ghesquiere');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `aime`
--
ALTER TABLE `aime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `ecrit`
--
ALTER TABLE `ecrit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `ecrit_user` (`idAuteur`);

--
-- Index pour la table `lien`
--
ALTER TABLE `lien`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `aime`
--
ALTER TABLE `aime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `ecrit`
--
ALTER TABLE `ecrit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT pour la table `lien`
--
ALTER TABLE `lien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ecrit`
--
ALTER TABLE `ecrit`
  ADD CONSTRAINT `ecrit_user` FOREIGN KEY (`idAuteur`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
