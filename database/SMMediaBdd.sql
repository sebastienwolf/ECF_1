-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 27 avr. 2022 à 10:38
-- Version du serveur :  8.0.28-0ubuntu0.20.04.3
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `SMMediaBdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id_article` int NOT NULL,
  `titre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `auteur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `genre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `collection` varchar(145) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `edition` varchar(145) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_category` int NOT NULL,
  `file` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `emprunt` tinyint NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `date_emprunt` date DEFAULT NULL,
  `dateRetour` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `titre`, `auteur`, `genre`, `collection`, `edition`, `id_category`, `file`, `emprunt`, `description`, `date_emprunt`, `dateRetour`) VALUES
(2, 'Dans les brumes de Capelans', 'Olivier Norek', 'Horreur', ' Michel Lafon', ' Michel Lafon', 1, '626518a5723b96.82229510.jpg', 0, 'Lorem ipsum dolor sit amet. Aut beatae facere hic consectetur repellendus ut dolore neque vel modi debitis qui quae iste. Et temporibus repellat ab expedita voluptatibus ut quibusdam sequi.\r\n\r\nIn dolorem corrupti eos iure deserunt At internos totam et saepe laboriosam ea fugiat autem et rerum quia. Et itaque sunt qui totam blanditiis est doloribus voluptas et quibusdam labore.', '2022-04-21', '2022-04-28'),
(3, 'Le Seigneur des anneaux - Nouvelle traduction Tome 3', ' J.R.R. Tolkien', 'Aventure', ' Tolkien', ' Bourgois', 1, 'Le-retour-du-roi.jpg', 0, 'Lorem ipsum dolor sit amet. Aut beatae facere hic consectetur repellendus ut dolore neque vel modi debitis qui quae iste. Et temporibus repellat ab expedita voluptatibus ut quibusdam sequi.\r\n\r\nIn dolorem corrupti eos iure deserunt At internos totam et saepe laboriosam ea fugiat autem et rerum quia. Et itaque sunt qui totam blanditiis est doloribus voluptas et quibusdam labore.', '2022-04-21', '2022-04-28'),
(4, 'Catherine de Médicis ', 'J-F Solnon', 'histoire', ' Biographies', 'Puf', 1, 'catherine.jpg', 0, 'Lorem ipsum dolor sit amet. Aut beatae facere hic consectetur repellendus ut dolore neque vel modi debitis qui quae iste. Et temporibus repellat ab expedita voluptatibus ut quibusdam sequi.\r\n\r\nIn dolorem corrupti eos iure deserunt At internos totam et saepe laboriosam ea fugiat autem et rerum quia. Et itaque sunt qui totam blanditiis est doloribus voluptas et quibusdam labore.', '2022-04-24', '2022-05-01'),
(6, 'La chronique des Bridgerton', 'Une certaine personne', 'Romantique', 'chronique de Bridgerton', 'J\'ai Lu ', 1, '62646c0ccaef13.62032034.jpg', 1, 'ceci est un test', '2022-04-26', '2022-05-03'),
(7, 'The Adventures Of TinTin', 'Hergé', 'Aventure', 'Les aventures de Tintin', 'Casterman', 3, 'tintin.jpg', 0, 'Lorem ipsum dolor sit amet. Aut beatae facere hic consectetur repellendus ut dolore neque vel modi debitis qui quae iste. Et temporibus repellat ab expedita voluptatibus ut quibusdam sequi.\r\n\r\nIn dolorem corrupti eos iure deserunt At internos totam et saepe laboriosam ea fugiat autem et rerum quia. Et itaque sunt qui totam blanditiis est doloribus voluptas et quibusdam labore.', '2022-04-21', '2022-04-28'),
(8, 'Tintin et les Picaros', 'Hergé', 'Aventure', 'Les aventures de Tintin', 'Casterman', 3, 'Tintin-au-Tibet.jpg', 0, 'Lorem ipsum dolor sit amet. Aut beatae facere hic consectetur repellendus ut dolore neque vel modi debitis qui quae iste. Et temporibus repellat ab expedita voluptatibus ut quibusdam sequi.\r\n\r\nIn dolorem corrupti eos iure deserunt At internos totam et saepe laboriosam ea fugiat autem et rerum quia. Et itaque sunt qui totam blanditiis est doloribus voluptas et quibusdam labore.', '2022-04-24', '2022-05-01'),
(9, 'Tinin au Tibet', 'Hergé', 'Aventure', 'Les aventures de Tintin', 'Casterman', 3, 'Tintin-et-les-Picaros.jpg', 0, 'Lorem ipsum dolor sit amet. Aut beatae facere hic consectetur repellendus ut dolore neque vel modi debitis qui quae iste. Et temporibus repellat ab expedita voluptatibus ut quibusdam sequi.\r\n\r\nIn dolorem corrupti eos iure deserunt At internos totam et saepe laboriosam ea fugiat autem et rerum quia. Et itaque sunt qui totam blanditiis est doloribus voluptas et quibusdam labore.', '2022-04-24', '2022-05-01'),
(11, 'Vengeance glacée', 'Melinda Leigh', 'Policiers', 'Poche', 'Amazon Crossing', 1, '6265137ac3b7e4.95677092.jpg', 0, 'Le nouveau shérif Bree Taggert répond à un appel d\'urgence en provenance d’un camping fermé pour l\'hiver. C’est une fusillade. Pourtant, une fois arrivée sur place, la situation est déconcertante : pas de tireur, pas de victime, pas de sang. Bree est la seule à croire l\'unique témoin, Alyssa, qui dit avoir vu son amie se faire tirer dessus.\r\n\r\nElle fait appel à son ancien adjoint, Matt Flynn, et à son acolyte canin pour suivre la trace du tueur et secourir l\'amie d\'Alyssa. Tous deux découvrent alors le corps d\'un étudiant disparu sous la surface gelée de Grey Lake… mais ce n\'est pas la victime qu\'ils cherchaient.\r\n\r\nPeu après, deux autres étudiants disparaissent et les cadavres s\'accumulent. Bree doit à tout prix comprendre ce qui relie ces meurtres. Une seule chose est certaine : pour torturer ainsi ses victimes, le tueur doit être habité d’une rage intense. Lorsque Alyssa est kidnappée à son tour, Bree se lance dans une course contre la montre pour la retrouver avant qu\'il ne soit trop tard…', '2022-04-25', '2022-05-02'),
(12, 'Swan et Néo - tome 5', 'Swan et Néo', 'Activités', 'magazine officiel', ' Reworld Media Magazines', 2, '626513f2096833.92728214.jpg', 0, '4 posters collector de Swan et Néo1 poster calendrier 2021/2022 aux couleurs de Swan et Néo 1 jeu &quot;Ne Jamais sauter sur la mauvaise bouée&quot;\r\nUn magazine estival aux couleurs de Swan et Néo où nous proposons 40 pages de jeux, des pages shopping back to school, les backstages de leurs vidéos....', '2022-04-26', '2022-05-03'),
(13, 'La Télévision Pour les nuls', 'François Tron', 'Activités', 'Pour les Nuls', ' First', 2, '6265355bea0129.10295345.jpg', 0, 'Aussi captivant qu\'une série, aussi instructif qu\'un documentaire, aussi divertissant qu\'une émission de variétés, ce livre vous propose d\'entrer dans les coulisses de la télévision. Quand la télé est-elle arrivée dans les familles françaises ? Pourquoi le journal de 20 heures est-il toujours à 20 heures ? Que veut dire TNT ? Qu\'est-ce qu\'un &quot; pilote &quot; ? Quelle est la série la plus regardée au monde ? Comment se mesure l\'audience ? Pourquoi les pubs tombent-elles en même temps sur toutes les chaînes ? Combien d\'émissions...', NULL, NULL),
(14, 'test de couscous', 'tata', 'tata', 'tata', 'tata', 4, '6267e0715b8577.40183091.png', 0, 'la super tata de tous les temps', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int NOT NULL,
  `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `name`) VALUES
(1, 'Roman'),
(2, 'Magazine'),
(3, 'Bande dessinée'),
(4, 'Film'),
(5, 'Jeux de plateaux');

-- --------------------------------------------------------

--
-- Structure de la table `pret`
--

CREATE TABLE `pret` (
  `id_pret` int NOT NULL,
  `id_user` int NOT NULL,
  `id_article` int NOT NULL,
  `date_retour` date NOT NULL,
  `date_depart` date NOT NULL,
  `back` tinyint(1) NOT NULL DEFAULT '0',
  `rendu` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `pret`
--

INSERT INTO `pret` (`id_pret`, `id_user`, `id_article`, `date_retour`, `date_depart`, `back`, `rendu`) VALUES
(15, 1, 6, '2022-04-28', '2022-04-21', 1, '2022-04-26'),
(27, 1, 6, '2022-04-28', '2022-04-21', 1, '2022-04-26'),
(28, 1, 6, '2022-04-28', '2022-04-29', 1, '2022-04-26'),
(29, 1, 3, '2022-04-28', '2022-04-21', 1, '2022-04-21'),
(30, 1, 2, '2022-04-28', '2022-04-21', 1, '2022-04-22'),
(31, 1, 9, '2022-04-28', '2022-04-21', 1, '2022-04-24'),
(32, 1, 2, '2022-04-28', '2022-05-04', 1, '2022-04-22'),
(33, 1, 9, '2022-04-28', '2022-04-30', 1, '2022-04-24'),
(34, 1, 4, '2022-04-29', '2022-04-22', 1, '2022-04-24'),
(35, 1, 6, '2022-04-19', '2022-04-07', 1, '2022-04-26'),
(36, 1, 12, '2022-05-01', '2022-04-24', 1, '2022-04-26'),
(37, 1, 9, '2022-05-01', '2022-04-24', 1, '2022-04-24'),
(38, 1, 4, '2022-05-01', '2022-04-24', 1, '2022-04-24'),
(39, 1, 11, '2022-05-02', '2022-04-25', 1, '2022-04-25'),
(40, 11, 6, '2022-05-03', '2022-04-26', 0, NULL),
(41, 11, 12, '2022-05-03', '2022-04-26', 1, '2022-04-26');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `prenom` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mail` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pwd` varchar(275) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `adress` varchar(175) NOT NULL,
  `city` varchar(55) NOT NULL,
  `cp` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'utilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `prenom`, `nom`, `mail`, `pwd`, `adress`, `city`, `cp`, `type`) VALUES
(1, 'sebastien', 'mouret', 'seb@seb', '$2y$12$W5AWsBOkOFH7gPnmUrhPeuXPPeXDVal5w1.kh0AIJbsKMlssmx4YW', '114 imp du vent du souleu', 'salon', '13300', 'admin'),
(10, 'Shun', 'Choupette', 'shun@choupi.com', '$2y$12$ZbzaoSOgSD0PZO3VwthciOBv2pZTJh.mYtC1.trt492PT0BYYiePO', 'Avenue de la licorne', 'Salon de provence', '66666', 'utilisateur'),
(11, 'NAPOLIE', 'Julieeeee', 'juli@juli', '$2y$12$l7bgVj3BVuNSDAozVm4Tw.efF9pdcf5YTjhu/oWdIiH8hqCRxQ62W', '114 imp du vent du souleu', 'salon', '66666', 'utilisateur'),
(12, 'sqdsdq', 'dqsdqsdq', 'tata@tata', '$2y$12$o0v6KpHPgLl2D6a/D9o8FuYX6ExBMSdDFqgG0SV3owv7fX41RA0P6', 'tata', 'attata', '13300', 'utilisateur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Index pour la table `pret`
--
ALTER TABLE `pret`
  ADD PRIMARY KEY (`id_pret`),
  ADD UNIQUE KEY `idh_istorique_UNIQUE` (`id_pret`),
  ADD KEY `fk_3` (`id_user`),
  ADD KEY `fk_4` (`id_article`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_article` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `pret`
--
ALTER TABLE `pret`
  MODIFY `id_pret` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pret`
--
ALTER TABLE `pret`
  ADD CONSTRAINT `fk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_4` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id_article`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
