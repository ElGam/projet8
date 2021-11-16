-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  mer. 20 oct. 2021 à 15:48
-- Version du serveur :  5.7.28
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet8`
--

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `created_at`, `title`, `content`, `is_done`, `user_id`) VALUES
(1, '2021-09-30 07:07:00', 'Ranger la maison', 'Faire la vaisselle\nNettoyer la salle de bain\nPasser la serpillère', 0, 1),
(2, '2021-09-30 07:07:00', 'Amour <3', 'Organiser un restaurant\nÊtre attentif\nLui dire plus souvent que je l\'aime\nLui offrir une fleur <3', 0, 1),
(3, '2021-09-30 07:07:00', 'Ranger la maison', 'Faire la vaisselle\nNettoyer la salle de bain\nPasser la serpillère', 0, 1),
(4, NULL, 'Test', 'jdfzs TEST\nSaut de ligne', 0, 1),
(5, NULL, 'MyNew Task 2', 'Hello\nJe fais\nTout ca\nEt même ca', 0, 1),
(6, NULL, 'Résilier Netflix', 'Passer sur Amazon Prime\nFinir Squid Game avant ^^', 0, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(0, 'Anonyme', '[]', '$2y$13$0VMscZiSd.z/C5/jFsu/n.7ObfET3b/ObPOT36M.txkLvt6qowPhy'),
(1, 'mederick.delos@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$0VMscZiSd.z/C5/jFsu/n.7ObfET3b/ObPOT36M.txkLvt6qowPhy'),
(2, 'user.test@gmail.com', '[]', '$2y$13$js8EvxOGhL4NFK.Lk5lLOeZokgAdRL.ncXpESH4iiktjw9iOaeYBC'),
(3, 'test.test@gmail.com', '[]', '$2y$13$EJedWDsAZ2aAtgtngKvBJu1m2qvR0EipoP7FqZY1SwNFc27j59Qi6'),
(4, 'john.doe@gmail.com', '[]', '$2y$13$U0Y0j0SfnzCVX3Wh6WeY8uMH6mv9/LE4WPU47FpBJtMd.3qui.1Jm'),
(24, 'john.doe@gmail.comm', '[\"ROLE_ADMIN\"]', '$2y$13$0jpRd134ZK..q7sv0H9EzeSSzIT2u7dIDW/yQ3FuwIEOQNeNX8F3.'),
(25, 'john.doe@gmail.commm', '[\"ROLE_USER\"]', '$2y$13$pnOBr0tt.sZIJ1wKIek0MuLNnGz2HT6..vTFAUqzkXl4pMDPFRi6i');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
