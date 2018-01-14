-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 14 Janvier 2018 à 15:44
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dm_home`
--

--
-- Contenu de la table `evaluation`
--

INSERT INTO `evaluation` (`id`, `commentaire`, `note`, `user_id`, `product_id`) VALUES
(1, 'Très bon produit', 5, 1, 5),
(2, 'Moyen', 3, 1, 5),
(3, 'Pas bon', 1, 2, 6),
(8, 'J\'adore le php ', 5, 2, 8),
(9, 'Moyen', 3, 1, 5),
(10, 'Plutôt pas bon', 2, 2, 5),
(11, 'Bon', 4, 2, 7),
(12, 'Bon', 4, 1, 5),
(13, 'Bon', 4, 1, 4),
(14, 'Moyen', 4, 2, 4);

--
-- Contenu de la table `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'thomas', 'thomas', 'th@f.fr', 'th@f.fr', 1, NULL, '$2y$13$KKtUjzmJbf9DynhPzjid7ulI8RhiRXNfKc7K06sUEJmwc6cO5TAHO', '2018-01-11 16:17:15', NULL, NULL, 'a:0:{}'),
(2, 'Thomsath', 'thomsath', 'lol@lol.fr', 'lol@lol.fr', 1, NULL, '$2y$13$/4rbbx8J26NLdCeyb1ZZq.3eERD7d6YTDJJdivAVWpEhs70djl23a', '2018-01-11 16:17:43', NULL, NULL, 'a:0:{}');

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `code_barre`, `nb_consultations`, `date_derniere_vue`) VALUES
(4, 3029330003533, 92, '2018-01-14'),
(5, 3178530412697, 7, '2018-01-14'),
(6, 3560070519095, 10, '2018-01-14'),
(7, 3700088912116, 15, '2018-01-14'),
(8, 7610849763610, 60, '2018-01-14');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
