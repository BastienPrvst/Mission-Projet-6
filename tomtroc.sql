-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 22 oct. 2024 à 18:31
-- Version du serveur : 8.0.30
-- Version de PHP : 8.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `statut` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `user_id`, `title`, `description`, `author`, `image`, `statut`) VALUES
(1, 1, '20 Milliards de lieux dans le ciel', 'Blabla', 'Jean Dujardin', NULL, 1),
(2, 1, 'Ou est Billy ?', '???', 'Big Ali', NULL, 0),
(3, 1, 'Wejdene', 'cqdsvdczqdvs', 'Wejdene aussi', NULL, 0),
(4, 1, 'Les simpsons', 'test', 'Test', NULL, 1),
(5, 20, 'Test', 'rzfrezggrebretgf', 'Billy', NULL, 0),
(6, 20, 'Test 2', 'erfg\"rreg', 'Billy le boss', NULL, 0),
(14, 22, 'Testo', 'testons', 'testa', 'default-book.png', 1),
(20, 22, 'tgg\'rteergv', 'rgfeergrge', 'regvregergv', '66f1850044356.png', 1),
(21, 22, 'zfezef', 'ezfzfezef', 'fzezeffez', 'default-book.png', 0),
(28, 22, 'erzerg', 'gzrgzre', 'grzeerg', 'default-book.png', 1),
(29, 22, 'erzerg', 'gzrgzre', 'Moi', 'default-book.png', 1),
(30, 22, 'erzerg', 'gzrgzre', 'Moi', '66fa68f159977.jpeg', 1),
(31, 22, 'Pouet', 'zrfeergfrgergze', 'pouet', 'default-book.png', 1),
(32, 23, 'fé\'ef\'éez', 'zrgzrg', 'zreg\'zrggzr', '66fa929ca65ff.jpeg', 0),
(33, 23, 'ezrgvertb', 'reherhgerh', 'rhegerhbher', '66fa92aabd548.jpeg', 1),
(35, 25, 'revrevrer', 'vrveerv', 'vervre', '66fa9b66b617e.jpeg', 1),
(38, 25, 'Test wtf', 'onriugfjvezbinuhjvrenhjikeravjnivrfaeznofjipvrfe', 'Bastieng', '6703b3aa1c1aa.png', 1);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `send_by` int NOT NULL,
  `received_by` int NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `send_by`, `received_by`, `text`, `date`, `seen`) VALUES
(12, 25, 23, 'Lorem ipsum dolor sit amet', '2024-10-22 17:17:01', 1),
(13, 25, 23, '    earum fuga harum illo impedit in minus molestiae placeat possimus quaerat ratione repellendus rerum unde veniam?', '2024-10-14 17:26:19', 1),
(14, 25, 23, 'CA MARCHE OUUUUUUUUUUUUIIIIIIIIIIIII', '2024-10-14 17:26:51', 1),
(15, 23, 25, 'Aliquam animi culpa dolorem eligendi enim et illum inventore natus nihil, officia placeat quas quasi sequi vero\n    voluptatem. A aliquid autem eius enim eos excepturi iure nemo repellat sequi velit?', '2024-10-21 10:20:44', 1),
(16, 18, 25, 'Lorem ipsum dolor sit amet', '2024-10-22 17:16:58', 1),
(17, 18, 25, '    earum fuga harum illo impedit in minus molestiae placeat possimus quaerat ratione repellendus rerum unde veniam?', '2024-10-21 15:09:34', 1),
(18, 25, 18, 'Asperiores consequuntur deleniti dicta dolor enim facere inventore ipsam labore nesciunt officiis, placeat\n    reiciendis, sunt voluptatibus! Cumque dolore, harum ipsa molestiae neque numquam odit quas quisquam sapiente\n    similique tempore vitae!', '2024-10-21 15:09:34', 1),
(19, 18, 23, 'Test normalement pas affiché', '2024-10-21 15:09:34', 0),
(20, 25, 15, 'Lorem ipsum dolor sit amet', '2024-10-22 17:16:57', 1),
(21, 25, 23, '    earum fuga harum illo impedit in minus molestiae placeat possimus quaerat ratione repellendus rerum unde veniam?', '2024-10-21 15:33:57', 1),
(22, 25, 23, 'Bonjour comment vas tu ?', '2024-10-22 14:26:18', 1),
(23, 25, 23, 'Accusamus corporis cum delectus distinctio est ipsum laborum provident unde veritatis vero? Accusamus accusantium\n    ad adipisci alias aliquam dignissimos dolorum eligendi, error esse, et illum ipsa maiores quam reiciendis\n    voluptatem!', '2024-10-22 14:27:24', 1),
(24, 25, 23, 'Accusamus corporis cum delectus distinctio est ipsum laborum provident unde veritatis vero? Accusamus accusantium\n    ad adipisci alias aliquam dignissimos dolorum eligendi, error esse, et illum ipsa maiores quam reiciendis\n    voluptatem!', '2024-10-22 14:27:51', 1),
(25, 25, 23, 'Aliquam animi culpa dolorem eligendi enim et illum inventore natus nihil, officia placeat quas quasi sequi vero\n    voluptatem. A aliquid autem eius enim eos excepturi iure nemo repellat sequi velit?', '2024-10-22 14:27:57', 1),
(26, 25, 23, 'Ad commodi itaque molestiae quis voluptate! Amet culpa dignissimos dolorem exercitationem fugiat harum magni quas\n    repellat sint suscipit. A amet assumenda consequatur eveniet impedit laborum officiis quo repellendus reprehenderit\n    tenetur?', '2024-10-22 14:29:47', 1),
(27, 25, 23, 'Asperiores consequuntur deleniti dicta dolor enim facere inventore ipsam labore nesciunt officiis, placeat\n    reiciendis, sunt voluptatibus! Cumque dolore, harum ipsa molestiae neque numquam odit quas quisquam sapiente\n    similique tempore vitae!', '2024-10-22 16:19:12', 1),
(28, 25, 23, 'Aliquam animi culpa dolorem eligendi enim et illum inventore natus nihil, officia placeat quas quasi sequi vero\n    voluptatem. A aliquid autem eius enim eos excepturi iure nemo repellat sequi velit?', '2024-10-22 16:27:24', 1),
(29, 25, 18, 'Asperiores consequuntur deleniti dicta dolor enim facere inventore ipsam labore nesciunt officiis, placeat\n    reiciendis, sunt voluptatibus! Cumque dolore, harum ipsa molestiae neque numquam odit quas quisquam sapiente\n    similique tempore vitae!', '2024-10-22 16:30:59', 1),
(30, 25, 18, 'Hello !', '2024-10-22 18:13:08', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(4096) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `creation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `avatar`, `creation_date`) VALUES
(1, 'Bastien', 'bastien@gmail.com', '0', 'default_user.png', '2024-10-07'),
(11, 'Tanguy', 'tanguy@gmail.com', '$2y$10$mB/lp6xrS62Xm7d4ZqAXIuXWq6eZ5igmUVEb0DWzUNycEf1JoDiy.', 'default_user.png', '2024-10-07'),
(12, 'bastien100', 'bastien100@gmail.com', '$2y$10$egXcOnqhX14330O/4fQYxOk5dWZeaIRd0VyBKZB5nOzrOSzpKII7a', 'default_user.png', '2024-10-07'),
(14, 'bloublou', 'pouet@pouet.fr', '$2y$10$5ukmUFMBZCPof0mGxJyYQOGfGf4tEvMsYV/jnYb/UOCZMpygayqne', 'default_user.png', '2024-10-07'),
(15, 'Bonjoure', 'test@test.fr', '$2y$10$iXcHIkF8lZiQC7Zehj6Em.HRu41x.ygFVMYI7YtMeEG3bBAE15UgS', 'default_user.png', '2024-10-07'),
(18, 'Bastoche', 'bastoche@gmail.com', '$2y$10$3TfSqBi5inKHxU3gz23vP.EHvK3aKD7FG6KL5nhPUpdRq5ZOjsMNG', 'user18.jpeg', '2024-10-07'),
(20, 'Billy', 'billy@gmail.com', '$2y$10$BNcuRRkvP12rLCwnUIjXaetRXgEmfG37c5eOO0eL/B3gmAsp3wa1m', 'user20.jpeg', '2024-10-07'),
(22, 'testtest', 'rohhh@gmail.com', '$2y$10$FP2pCVn0QO7bj5nrV8gxpOyczkKEtw0Hma7cGcKxlhTlYqh.AlCwu', 'user22.jpeg', '2024-10-07'),
(23, 'BastienAprem', 'bang@gmail.com', '$2y$10$p7RkGaAfACvzSIsgp/live77uREldNrdoSjghJbHRfPvTCzXlU8Cm', 'user23.png', '2024-10-07'),
(24, 'TestTestTest', 'test@test.com', '$2y$10$ye7ycQlw9OiVXLoUoB8Wj.FsX.Hi4loFX4fMUdBFMGyNb/B.I9H5O', 'default_user.png', '2024-10-07'),
(25, 'Soutenance', 'soutenance@gmail.com', '$2y$10$4LhnG1HDZtBqoReZrdLEEed9begq0tf6GwWlvHUBQ.i3K7ZUsP92S', 'user25.jpeg', '2024-10-07');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `received_by` (`received_by`),
  ADD KEY `send_by` (`send_by`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`send_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
