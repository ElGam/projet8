-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  mer. 20 oct. 2021 à 15:49
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
-- Base de données :  `projet8_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `is_done` tinyint(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `created_at`, `title`, `content`, `is_done`, `user_id`) VALUES
(41, '2021-10-14 21:29:55', 'Task 0', 'Ma tâche n°0', 1, 1),
(42, '2021-10-14 21:29:55', 'Task 1', 'Ma tâche n°1', 1, 1),
(43, '2021-10-14 21:29:55', 'Task 2', 'Ma tâche n°2', 0, 1),
(44, '2021-10-14 21:29:55', 'Task 3', 'Ma tâche n°3', 0, 1),
(45, '2021-10-14 21:29:55', 'Task 4', 'Ma tâche n°4', 0, 1),
(46, '2021-10-14 21:29:55', 'Task 5', 'Ma tâche n°5', 1, 1),
(47, '2021-10-14 21:29:55', 'Task 6', 'Ma tâche n°6', 1, 1),
(48, '2021-10-14 21:29:55', 'Task 7', 'Ma tâche n°7', 1, 1),
(49, '2021-10-14 21:29:55', 'Task 8', 'Ma tâche n°8', 0, 1),
(50, '2021-10-14 21:29:55', 'Task 9', 'Ma tâche n°9', 1, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(42, 'user0@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test'),
(43, 'user1@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test'),
(44, 'user2@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test'),
(45, 'user3@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test'),
(46, 'user4@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test'),
(47, 'user5@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test'),
(48, 'user6@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test'),
(49, 'user7@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test'),
(50, 'user8@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test'),
(51, 'user9@functional-test.fr', '[\"ROLE_USER\"]', 'fixture_test');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
