-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 25 jan. 2020 à 10:59
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `resto_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `seatCount` int(11) NOT NULL,
  `bookingDate` date NOT NULL,
  `shift` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ibfc_booking_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `seatCount`, `bookingDate`, `shift`) VALUES
(1, 5, 5, '2019-12-19', 'midi'),
(2, 2, 8, '2019-12-19', 'midi'),
(3, 5, 12, '2019-12-19', 'midi');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `commentaire` text COLLATE utf8_unicode_ci NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ibfc_commentaire_1` (`user_id`),
  KEY `ibfc_commentaire_2` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dish`
--

DROP TABLE IF EXISTS `dish`;
CREATE TABLE IF NOT EXISTS `dish` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `dish`
--

INSERT INTO `dish` (`id`, `title`, `description`, `image`, `price`, `category`) VALUES
(21, 'Cachupa', 'Le Cachupa est un plat typique du Cap Vert. Il existe deux types principaux, le Cachupa Rica, qui est composé de différents types de viande et le Cachupa Pobre, fabriqué uniquement à partir de poisson. La distinction entre les types de cachupa est liée au fait que le Rica (riche) contient de la viande, ce qui rend le plat plus cher et accessible uniquement aux aisé, tandis que le Pobre (pauvre) est plus accessible à tous.\r\n\r\nLa recette traditionnelle, qui occupe une place de choix dans la Cuisin, e Cap-Verdienne, est considérée par beaucoup comme le vrai délice, la reine ou l’étoile principale. La préparation peut être un rituel authentique, commençant la veille avec la mise du maïs et des haricots dans de l’eau froide. Le manioc, la viande et les saucisses, le chou vert et les patates douces sont d’autres ingrédients qui donnent vie à cette recette.', 'dish_21.png', 25.5, 'Plat'),
(22, 'Feijoada', 'Le nom vient de feijão vient du portugais pour “haricots”. Les ingrédients de base de la feijoada sont des haricots avec du porc ou du bœuf frais. Au Brésil, il est généralement préparé avec des haricots noirs (feijoada à brasileira). Le ragoût est traditionnellement préparé à feu doux dans une cocote en argile. Il est généralement servi avec du riz et un assortiment de saucisses, telles que le chouriço, la morcela, la farinheira, et d’autres, qui peuvent ou non être cuites dans le ragoût.\r\n\r\nLa tradition des ragoûts de viande aux légumes qui ont donné naissance à la feijoada de la province du Minho au nord du Portugal est une tradition méditerranéenne millénaire qui remonte à la période où les Romains ont colonisé l’Ibérie. Les soldats romains ont apporté cette tradition avec eux dans toutes les colonies latines, et ce patrimoine est la source de nombreux plats nationaux et régionaux européens d’aujourd’hui, comme le cassoulet français, la cassoeula milanaise, le fasole cu cârnaţi roumain, ou encore la fabada asturiana du nord-ouest de l’Espagne.\r\n\r\nLa feijoada est l’une des plus grandes exportations du Portugal – on retrouve ce plat savoureux de haricots avec du bœuf et du porc à Macao, en Angola, au Cap-Vert, au Mozambique, à Goa et au Brésil. Cependant, la recette diffère légèrement d’un pays à l’autre.', 'dish_22.jpg', 19.99, 'Plat'),
(23, 'Cuscuz', 'Les autres plats traditionnels capverdiens (le xerem, le cuscus, le djagacida) sont réservés aux repas de fête et ne sont pas servis dans les restaurants. Les autres plats traditionnels capverdiens (le xerem, le cuscus, le djagacida) sont réservés aux repas de fête et ne sont pas servis dans les restaurants. Les autres plats traditionnels capverdiens (le xerem, le cuscus, le djagacida) sont réservés aux repas de fête et ne sont pas servis dans les restaurants. Les autres plats traditionnels capverdiens (le xerem, le cuscus, le djagacida) sont réservés aux repas de fête et ne sont pas servis dans les restaurants. Les autres plats traditionnels capverdiens (le xerem, le cuscus, le djagacida) sont réservés aux repas de fête et ne sont pas servis dans les restaurants. Les autres plats traditionnels capverdiens (le xerem, le cuscus, le djagacida) sont réservés aux repas de fête et ne sont pas servis dans les restaurants. Les autres plats traditionnels capverdiens (le xerem, le cuscus, le djagacida) sont réservés aux repas de fête et ne sont pas servis dans les restaurants. Les autres plats traditionnels capverdiens (le xerem, le cuscus, le djagacida) sont réservés aux repas de fête et ne sont pas servis dans les restaurants.', 'dish_23.png', 7.49, 'Dessert'),
(24, 'Salade Corézienne', 'Foi gras, lardons, fromage, et bien sûr quand (un peu) de salade. Le french paradox dans ton bide. Si t\'en meurs pas, c\'est pas de notre faute. \r\nTaux de cholestérol = ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++', 'dish_24.jpg', 19.1, 'Entrée'),
(25, 'Daurade brasier', 'Sa livrée est gris argent, corps ovale avec une bande dorée sur le front (d\'où son surnom de « Belle aux sourcils d\'or ») et sur les joues.\r\n\r\nEn plus de ce bandeau doré, elle comporte également une tache noire sur le haut de l\'opercule, ainsi qu\'une tache orangeâtre sur le bas de l\'opercule, ce qui permet une identification aisée. Suivant son habitat, la livrée de la dorade royale varie. Sur une plage peu profonde, ses flancs sont argentés voire tirent sur le jaune paille, alors qu\'en eau plus profonde, sur des fonds sombres, comme dans les ports, ses flancs seront nettement bleus.\r\n\r\nLa daurade est comestible, et sa chair est très appréciée.\r\n\r\nSurnoms\r\nCouramment appelée Daurade ou dorade royale, ce sparidé possède en vérité plusieurs surnoms, attribués la plupart du temps par les pêcheurs en fonction de la région. Le nom de « Belle au sourcil d\'or » revient fréquemment grâce à son véritable sourcil doré, caractéristique de cette espèce. Dans le sud de la France, les petits individus sont couramment appelés « Blanquette » ou « Socanelle », elle est appelée \"gueule pavée\" en Bretagne, en raison de sa forte dentition. Plus généralement, les poissons de petites tailles peuvent être qualifiés de « médaillons ».', 'dish_25.jpg', 21.4, 'Plat'),
(26, 'Pizza', 'Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!! Pizza pizza piiiizzaaaaaa!!', 'dish_26.jpeg', 19, 'Other');

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `forcedPrice` float DEFAULT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id`, `title`, `description`, `forcedPrice`, `image`) VALUES
(2, 'Menu hiver', 'Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon. Du gras, du frais, du bon.', 0, 'menu_2.jpg'),
(3, 'Festin de Noêl', 'Plus t\'as faim, plus c\'est bien !\r\nNoël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël Noël', 0, 'menu_3.jpg'),
(5, 'Menu leg', 'Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!Menu pour les personnes qui n\'ont pas faim mais qui doivent se nourrir...\r\nBon appétit!!', 0, 'menu_5.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `menu_dish`
--

DROP TABLE IF EXISTS `menu_dish`;
CREATE TABLE IF NOT EXISTS `menu_dish` (
  `menu_id` int(10) UNSIGNED NOT NULL,
  `dish_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  UNIQUE KEY `menu_dish_unicity` (`menu_id`,`dish_id`),
  KEY `ibfc_menu_dish_1` (`menu_id`),
  KEY `ibfc_menu_dish_2` (`dish_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `menu_dish`
--

INSERT INTO `menu_dish` (`menu_id`, `dish_id`, `quantity`) VALUES
(2, 21, 3),
(2, 23, 5),
(2, 25, 4),
(3, 23, 2),
(3, 24, 1),
(5, 24, 1),
(5, 25, 1);

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `orderDate` datetime DEFAULT NULL,
  `deliveryDate` datetime DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ibfc_order_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `user_id`, `orderDate`, `deliveryDate`, `status`) VALUES
(6, 5, NULL, NULL, 'basket'),
(8, 7, '2019-12-20 15:07:23', NULL, 'pending'),
(9, 7, '2019-12-20 15:08:35', NULL, 'pending'),
(11, 7, NULL, NULL, 'basket');

-- --------------------------------------------------------

--
-- Structure de la table `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
CREATE TABLE IF NOT EXISTS `orderdetails` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) NOT NULL,
  `priceEach` float NOT NULL,
  UNIQUE KEY `basket_unicity` (`menu_id`,`order_id`),
  KEY `ibfc_orderDetails_1` (`order_id`),
  KEY `ibfc_orderDetails_2` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `orderdetails`
--

INSERT INTO `orderdetails` (`order_id`, `menu_id`, `quantity`, `priceEach`) VALUES
(9, 2, 1, 199.55),
(11, 2, 1, 199.55),
(8, 3, 1, 34.08),
(9, 3, 1, 34.08);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `forname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `adress` text COLLATE utf8_unicode_ci NOT NULL,
  `numTel` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `pwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `signInDate` datetime NOT NULL,
  `lastLoginDate` datetime DEFAULT NULL,
  `image` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `forname`, `lastname`, `adress`, `numTel`, `email`, `isAdmin`, `pwd`, `signInDate`, `lastLoginDate`, `image`) VALUES
(2, 'Warren', 'Neves', '16 rue du templier 75016 paris', '0123456789', 'wawa77@hotmail.fr', 0, '$2y$10$3B97GCa7GGiAVMzV6kEHq.wTdV.d3Zb9.zotiTK8DVjVaQgHymdOq', '2019-12-16 12:44:53', NULL, 'user_2.jpg'),
(5, 'Tom', 'Verdier', '12 de la corniche, 75025 Montréal Cédex 22', '0123456789', 'tom@tom.com', 1, '$2y$10$zN5RfVlc0x7wC0OVd07FbObZIy7qX5PL9W2Ylbp2lr62vZO0kYslK', '2019-12-16 15:28:54', NULL, NULL),
(7, 'Warren', 'Neves', '12 rue de la Corbie', '0123456789', 'fake@hotmail.fr', 0, '$2y$10$5PVy/rpsc9YumMolNVmoJOrZ.ND7Q.ULfa2wIs3/3MUIghU8jM13y', '2019-12-18 17:17:58', NULL, 'user_7.jpg');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `ibfc_booking_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `ibfc_commentaire_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ibfc_commentaire_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `menu_dish`
--
ALTER TABLE `menu_dish`
  ADD CONSTRAINT `ibfc_menu_dish_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ibfc_menu_dish_2` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `ibfc_order_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `ibfc_orderDetails_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ibfc_orderDetails_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
