-- --------------------------------------------------------
-- Hôte:                         164.132.231.86
-- Version du serveur:           10.11.6-MariaDB-0+deb12u1 - Debian 12
-- SE du serveur:                debian-linux-gnu
-- HeidiSQL Version:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour pcs_all_bdd
CREATE DATABASE IF NOT EXISTS `pcs_all_bdd` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `pcs_all_bdd`;

-- Listage de la structure de table pcs_all_bdd. booking
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `price` double NOT NULL,
  `amount_people` int(11) NOT NULL DEFAULT 1,
  `housing_id` int(11) DEFAULT NULL,
  `performance_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT curtime(),
  `review` varchar(255) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `booking_housing_id_fk` (`housing_id`),
  KEY `booking_performances_id_fk` (`performance_id`),
  CONSTRAINT `booking_housing_id_fk` FOREIGN KEY (`housing_id`) REFERENCES `housing` (`id`),
  CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `booking_performances_id_fk` FOREIGN KEY (`performance_id`) REFERENCES `performances` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.booking : ~32 rows (environ)
INSERT INTO `booking` (`id`, `user_id`, `start_date`, `end_date`, `price`, `amount_people`, `housing_id`, `performance_id`, `title`, `timestamp`, `review`, `rate`) VALUES
	(49, 37, '2024-06-26 00:00:00', '2024-06-27 00:00:00', 75, 23, 12, NULL, 'Appartement au bord du vieux Port', '2024-06-10 12:25:59', 'sgze', 5),
	(55, 37, '2024-07-03 00:00:00', '2024-07-04 00:00:00', 75, 2, 12, NULL, 'Appartement au bord du vieux Port', '2024-06-17 15:33:25', NULL, NULL),
	(56, 37, '2024-06-03 00:00:00', '2024-06-04 00:00:00', 75, 2, 12, NULL, 'Appartement au bord du vieux Port', '2024-06-17 15:35:16', NULL, NULL),
	(57, 37, '2024-06-03 00:00:00', '2024-06-04 00:00:00', 75, 2, NULL, 2, 'Appartement au bord du vieux Port', '2024-06-17 15:35:16', NULL, NULL),
	(58, 37, '2024-07-03 00:00:00', '2024-07-04 00:00:00', 75, 2, NULL, 2, 'Appartement au bord du vieux Port', '2024-06-17 15:33:25', NULL, NULL),
	(59, 37, '2024-06-26 00:00:00', '2024-06-27 00:00:00', 75, 23, NULL, 2, 'Appartement au bord du vieux Port', '2024-06-10 12:25:59', 'sgze', 5),
	(71, 23, '2024-07-08 15:00:00', '2024-07-08 16:00:00', 11.5, 1, NULL, 2, 'ménage sur paname', '2024-07-03 04:18:10', NULL, NULL),
	(86, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:38:52', NULL, NULL),
	(87, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:39:14', NULL, NULL),
	(88, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:39:31', NULL, NULL),
	(89, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:40:46', NULL, NULL),
	(90, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:41:01', NULL, NULL),
	(91, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:46:10', NULL, NULL),
	(92, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:46:42', NULL, NULL),
	(93, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:47:15', NULL, NULL),
	(94, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:48:12', NULL, NULL),
	(95, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:49:43', NULL, NULL),
	(96, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:50:48', NULL, NULL),
	(97, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:52:48', NULL, NULL),
	(98, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:58:49', NULL, NULL),
	(99, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 04:59:58', NULL, NULL),
	(100, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 05:00:40', NULL, NULL),
	(101, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 05:01:46', NULL, NULL),
	(102, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 05:04:48', NULL, NULL),
	(103, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 05:06:16', NULL, NULL),
	(104, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 05:06:50', NULL, NULL),
	(105, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 05:08:27', NULL, NULL),
	(106, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 05:08:47', NULL, NULL),
	(107, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 13:31:02', NULL, NULL),
	(108, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 13:31:48', NULL, NULL),
	(109, 23, '2024-07-08 09:00:00', '2024-07-08 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 13:32:25', NULL, NULL),
	(110, 23, '2024-10-22 11:00:00', '2024-10-22 15:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 13:32:55', NULL, NULL),
	(111, 23, '2024-07-10 11:11:00', '2024-07-10 11:22:00', 0, 1, NULL, 4, 'test', '2024-07-03 15:58:56', NULL, NULL),
	(112, 23, '2024-07-10 12:00:00', '2024-07-10 13:00:00', 0, 1, NULL, 4, 'test', '2024-07-03 16:01:08', NULL, NULL),
	(113, 23, '2024-10-22 09:00:00', '2024-10-22 10:00:00', 15, 1, NULL, 2, 'salut ça va ?', '2024-07-03 20:59:54', NULL, NULL);

-- Listage de la structure de table pcs_all_bdd. chatbot
CREATE TABLE IF NOT EXISTS `chatbot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` text NOT NULL,
  `chatbotresponse` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.chatbot : ~62 rows (environ)
INSERT INTO `chatbot` (`id`, `keyword`, `chatbotresponse`) VALUES
	(1, 'unfound', 'Désolé, je n\'ai pas compris votre question.\r\nJe vous invite à contacter un conseiller.'),
	(2, 'mot de passe', 'Pour changer ou obtenir des informations sur votre mot de passe, vous avez 3 solutions:\r\n- Vous rendre sur votre profil, onglet "mot de passe"\r\n- Changer de mot de passe via l\'onglet de connexion, en cliquant sur "mot de passe oublié"\r\n-Contacter, en dernier recours, un administrateur via la création d\'un ticket.\r\nAvez-vous une autre question?'),
	(9, 'inscription', 'Pour vous inscrire, cliquez sur le bouton "Inscription" en haut à droite de la page d\'accueil et remplissez le formulaire.'),
	(10, 'connexion', 'Pour vous connecter, entrez votre nom d\'utilisateur et votre mot de passe dans le formulaire de connexion.'),
	(11, 'déconnexion', 'Pour vous déconnecter, cliquez sur votre nom d\'utilisateur en haut à droite, puis sur "Déconnexion".'),
	(12, 'profil', 'Pour accéder à votre profil, cliquez sur votre nom d\'utilisateur en haut à droite, puis sur "Profil".'),
	(13, 'modifier profil', 'Pour modifier votre profil, accédez à votre profil et cliquez sur "Modifier le profil".'),
	(14, 'supprimer compte', 'Pour supprimer votre compte, veuillez contacter un administrateur via la création d\'un ticket.'),
	(15, 'mot de passe oublié', 'Si vous avez oublié votre mot de passe, cliquez sur "Mot de passe oublié" sur la page de connexion et suivez les instructions.'),
	(16, 'contact', 'Pour nous contacter, envoyez un message via la page de contact.'),
	(17, 'support', 'Pour toute assistance, veuillez visiter la page de support ou envoyer un ticket.'),
	(18, 'facture', 'Pour consulter vos factures, allez dans votre profil et cliquez sur "Factures".'),
	(19, 'paiement', 'Pour effectuer un paiement, allez dans la section "Paiements" de votre profil.'),
	(20, 'problème technique', 'Pour signaler un problème technique, veuillez créer un ticket dans la section support.'),
	(21, 'mise à jour', 'Pour mettre à jour votre application, allez dans les paramètres et cliquez sur "Mise à jour".'),
	(22, 'notifications', 'Pour gérer vos notifications, allez dans les paramètres de votre profil.'),
	(23, 'paramètres', 'Pour accéder aux paramètres, cliquez sur votre nom d\'utilisateur en haut à droite, puis sur "Paramètres".'),
	(24, 'sécurité', 'Pour des conseils sur la sécurité, consultez notre page de sécurité.'),
	(25, 'confidentialité', 'Pour en savoir plus sur notre politique de confidentialité, consultez notre page de confidentialité.'),
	(26, 'conditions', 'Pour consulter nos conditions d\'utilisation, veuillez visiter la page des conditions générales.'),
	(27, 'abonnement', 'Pour gérer votre abonnement, allez dans la section "Abonnements" de votre profil.'),
	(28, 'notifications email', 'Pour gérer vos notifications par email, allez dans les paramètres de votre profil.'),
	(29, 'support technique', 'Pour toute assistance technique, veuillez créer un ticket dans la section support.'),
	(30, 'fermer compte', 'Pour fermer votre compte, veuillez contacter un administrateur via la création d\'un ticket.'),
	(31, 'changer email', 'Pour changer votre adresse email, allez dans votre profil et cliquez sur "Modifier l\'email".'),
	(32, 'changer numéro', 'Pour changer votre numéro de téléphone, allez dans votre profil et cliquez sur "Modifier le numéro de téléphone".'),
	(34, 'partenaires', 'Pour en savoir plus sur nos partenaires, consultez la page "Partenaires".'),
	(35, 'services', 'Pour en savoir plus sur nos services, consultez la page "Services".'),
	(36, 'tarifs', 'Pour en savoir plus sur nos tarifs, consultez la page "Tarifs".'),
	(37, 'aide', 'Pour toute assistance, veuillez visiter la page d\'aide ou envoyer un ticket.'),
	(38, 'recherche', 'Utilisez la barre de recherche en haut de la page pour trouver des informations.'),
	(39, 'inscription', 'Pour vous inscrire, cliquez sur le bouton "Inscription" en haut à droite de la page d\'accueil et remplissez le formulaire.'),
	(40, 'connexion', 'Pour vous connecter, entrez votre nom d\'utilisateur et votre mot de passe dans le formulaire de connexion.'),
	(41, 'déconnexion', 'Pour vous déconnecter, cliquez sur votre nom d\'utilisateur en haut à droite, puis sur "Déconnexion".'),
	(42, 'profil', 'Pour accéder à votre profil, cliquez sur votre nom d\'utilisateur en haut à droite, puis sur "Profil".'),
	(43, 'modifier profil', 'Pour modifier votre profil, accédez à votre profil et cliquez sur "Modifier le profil".'),
	(44, 'supprimer compte', 'Pour supprimer votre compte, veuillez contacter un administrateur via la création d\'un ticket.'),
	(45, 'mot de passe oublié', 'Si vous avez oublié votre mot de passe, cliquez sur "Mot de passe oublié" sur la page de connexion et suivez les instructions.'),
	(46, 'contact', 'Pour nous contacter, envoyez un message via la page de contact.'),
	(47, 'support', 'Pour toute assistance, veuillez visiter la page de support ou envoyer un ticket.'),
	(48, 'facture', 'Pour consulter vos factures, allez dans votre profil et cliquez sur "Factures".'),
	(49, 'paiement', 'Pour effectuer un paiement, allez dans la section "Paiements" de votre profil.'),
	(50, 'problème technique', 'Pour signaler un problème technique, veuillez créer un ticket dans la section support.'),
	(51, 'mise à jour', 'Pour mettre à jour votre application, allez dans les paramètres et cliquez sur "Mise à jour".'),
	(52, 'notifications', 'Pour gérer vos notifications, allez dans les paramètres de votre profil.'),
	(53, 'paramètres', 'Pour accéder aux paramètres, cliquez sur votre nom d\'utilisateur en haut à droite, puis sur "Paramètres".'),
	(54, 'sécurité', 'Pour des conseils sur la sécurité, consultez notre page de sécurité.'),
	(55, 'confidentialité', 'Pour en savoir plus sur notre politique de confidentialité, consultez notre page de confidentialité.'),
	(56, 'conditions', 'Pour consulter nos conditions d\'utilisation, veuillez visiter la page des conditions générales.'),
	(57, 'abonnement', 'Pour gérer votre abonnement, allez dans la section "Abonnements" de votre profil.'),
	(58, 'notifications email', 'Pour gérer vos notifications par email, allez dans les paramètres de votre profil.'),
	(59, 'support technique', 'Pour toute assistance technique, veuillez créer un ticket dans la section support.'),
	(60, 'fermer compte', 'Pour fermer votre compte, veuillez contacter un administrateur via la création d\'un ticket.'),
	(61, 'changer email', 'Pour changer votre adresse email, allez dans votre profil et cliquez sur "Modifier l\'email".'),
	(62, 'changer numéro', 'Pour changer votre numéro de téléphone, allez dans votre profil et cliquez sur "Modifier le numéro de téléphone".'),
	(63, 'historique', 'Pour consulter votre historique d\'activités, allez dans votre profil et cliquez sur "Historique".'),
	(64, 'partenaires', 'Pour en savoir plus sur nos partenaires, consultez la page "Partenaires".'),
	(65, 'services', 'Pour en savoir plus sur nos services, consultez la page "Services".'),
	(67, 'aide', 'Pour toute assistance, veuillez visiter la page d\'aide ou envoyer un ticket.'),
	(68, 'recherche', 'Utilisez la barre de recherche en haut de la page pour trouver des informations.');

-- Listage de la structure de table pcs_all_bdd. disponibility
CREATE TABLE IF NOT EXISTS `disponibility` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_housing` int(11) DEFAULT NULL,
  `id_performance` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `hour_start` datetime DEFAULT NULL,
  `hour_end` datetime DEFAULT NULL,
  `is_booked` varchar(255) NOT NULL DEFAULT '0',
  `hour_duration` varchar(255) DEFAULT NULL,
  `original_dispo` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_housing` (`id_housing`),
  KEY `id_performance` (`id_performance`),
  CONSTRAINT `disponibility_ibfk_1` FOREIGN KEY (`id_housing`) REFERENCES `housing` (`id`),
  CONSTRAINT `disponibility_ibfk_2` FOREIGN KEY (`id_performance`) REFERENCES `performances` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=596 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.disponibility : ~62 rows (environ)
INSERT INTO `disponibility` (`ID`, `id_housing`, `id_performance`, `date`, `hour_start`, `hour_end`, `is_booked`, `hour_duration`, `original_dispo`) VALUES
	(36, 12, NULL, '2024-05-01', NULL, NULL, '0', NULL, NULL),
	(37, 12, NULL, '2024-05-08', NULL, NULL, '0', NULL, NULL),
	(38, 12, NULL, '2024-05-15', NULL, NULL, '0', NULL, NULL),
	(39, 12, NULL, '2024-07-04', NULL, NULL, '0', NULL, NULL),
	(40, 12, NULL, '2024-07-11', NULL, NULL, '0', NULL, NULL),
	(41, 12, NULL, '2024-07-18', NULL, NULL, '0', NULL, NULL),
	(42, 12, NULL, '2024-07-10', NULL, NULL, '0', NULL, NULL),
	(43, 12, NULL, '2024-07-03', NULL, NULL, '0', NULL, NULL),
	(44, 12, NULL, '2024-07-17', NULL, NULL, '0', NULL, NULL),
	(45, 12, NULL, '2024-06-26', NULL, NULL, '1', NULL, NULL),
	(46, 12, NULL, '2024-06-27', NULL, NULL, '1', NULL, NULL),
	(53, 12, NULL, '2024-05-27', NULL, NULL, '0', NULL, NULL),
	(54, 12, NULL, '2024-06-11', NULL, NULL, '0', NULL, NULL),
	(55, 12, NULL, '2024-06-03', NULL, NULL, '1', NULL, NULL),
	(56, 12, NULL, '2024-06-04', NULL, NULL, '1', NULL, NULL),
	(72, NULL, 1, '2024-05-01', NULL, NULL, '0', NULL, NULL),
	(73, NULL, 1, '2024-05-08', NULL, NULL, '0', NULL, NULL),
	(74, NULL, 1, '2024-05-15', NULL, NULL, '0', NULL, NULL),
	(75, NULL, 1, '2024-07-04', NULL, NULL, '0', NULL, NULL),
	(81, NULL, 1, '2024-06-26', NULL, NULL, '0', NULL, NULL),
	(82, NULL, 1, '2024-06-25', NULL, NULL, '0', NULL, NULL),
	(83, NULL, 1, '2024-06-27', NULL, NULL, '0', NULL, NULL),
	(84, NULL, 1, '2024-06-28', NULL, NULL, '0', NULL, NULL),
	(85, NULL, 2, '2024-06-03', NULL, NULL, '0', NULL, NULL),
	(86, NULL, 2, '2024-06-04', NULL, NULL, '0', NULL, NULL),
	(87, 11, NULL, '2024-07-04', NULL, NULL, '0', NULL, NULL),
	(88, 11, NULL, '2024-07-03', NULL, NULL, '0', NULL, NULL),
	(91, 11, NULL, '2024-07-05', NULL, NULL, '0', NULL, NULL),
	(92, 11, NULL, '2024-07-12', NULL, NULL, '0', NULL, NULL),
	(95, NULL, 1, '2024-07-12', NULL, NULL, '0', NULL, NULL),
	(96, NULL, 1, '2024-07-05', NULL, NULL, '0', NULL, NULL),
	(97, 12, NULL, '2024-07-05', NULL, NULL, '0', NULL, NULL),
	(98, 12, NULL, '2024-07-12', NULL, NULL, '0', NULL, NULL),
	(99, 12, NULL, '2024-07-19', NULL, NULL, '0', NULL, NULL),
	(100, 12, NULL, '2024-07-13', NULL, NULL, '0', NULL, NULL),
	(101, 12, NULL, '2024-07-06', NULL, NULL, '0', NULL, NULL),
	(102, 12, NULL, '2024-07-20', NULL, NULL, '0', NULL, NULL),
	(104, 12, NULL, '2024-07-16', NULL, NULL, '0', NULL, NULL),
	(105, 12, NULL, '2024-07-09', NULL, NULL, '0', NULL, NULL),
	(106, 12, NULL, '2024-07-15', NULL, NULL, '0', NULL, NULL),
	(107, 12, NULL, '2024-07-07', NULL, NULL, '0', NULL, NULL),
	(108, 12, NULL, '2024-07-14', NULL, NULL, '0', NULL, NULL),
	(109, 12, NULL, '2024-07-21', NULL, NULL, '0', NULL, NULL),
	(110, 12, NULL, '2024-07-28', NULL, NULL, '0', NULL, NULL),
	(111, 12, NULL, '2024-07-29', NULL, NULL, '0', NULL, NULL),
	(113, 12, NULL, '2024-07-30', NULL, NULL, '0', NULL, NULL),
	(114, 12, NULL, '2024-07-23', NULL, NULL, '0', NULL, NULL),
	(115, 12, NULL, '2024-07-24', NULL, NULL, '0', NULL, NULL),
	(116, 12, NULL, '2024-07-31', NULL, NULL, '0', NULL, NULL),
	(117, 12, NULL, '2024-07-25', NULL, NULL, '0', NULL, NULL),
	(118, 12, NULL, '2024-07-26', NULL, NULL, '0', NULL, NULL),
	(119, 12, NULL, '2024-07-27', NULL, NULL, '0', NULL, NULL),
	(122, NULL, 2, '2024-07-08', '2024-07-08 10:00:00', '2024-07-08 18:00:00', '0', '1', 1),
	(125, 12, NULL, '2024-07-08', NULL, NULL, '0', NULL, NULL),
	(129, 12, NULL, '2024-11-22', NULL, NULL, '0', NULL, NULL),
	(133, 12, NULL, '2024-12-22', NULL, NULL, '0', NULL, NULL),
	(134, 12, NULL, '2024-10-22', NULL, NULL, '0', NULL, NULL),
	(591, NULL, 4, '2024-07-10', '2024-07-10 10:00:00', '2024-07-10 11:00:00', '0', '1', 1),
	(592, NULL, 4, '2024-07-10', '2024-07-10 11:00:00', '2024-07-10 12:00:00', '0', '1', 1),
	(593, NULL, 4, '2024-07-10', '2024-07-10 12:00:00', '2024-07-10 13:00:00', '1', '1', 1),
	(594, NULL, 4, '2024-07-10', '2024-07-10 13:00:00', '2024-07-10 14:00:00', '0', '1', 1),
	(595, NULL, 4, '2024-07-10', '2024-07-10 14:00:00', '2024-07-10 15:00:00', '0', '1', 1);

-- Listage de la structure de table pcs_all_bdd. housing
CREATE TABLE IF NOT EXISTS `housing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postal_code` int(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type_house` varchar(255) DEFAULT NULL,
  `type_location` varchar(255) NOT NULL,
  `amount_room` int(11) DEFAULT NULL,
  `guest_capacity` int(11) NOT NULL,
  `property_area` int(11) DEFAULT NULL,
  `disponibility` datetime DEFAULT NULL,
  `contact_phone` varchar(10) DEFAULT NULL,
  `rate` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `is_validated` tinyint(1) DEFAULT 0,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `management_type` varchar(255) NOT NULL,
  `contact_time` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `wifi` int(11) NOT NULL DEFAULT 0,
  `parking` int(11) NOT NULL DEFAULT 0,
  `pool` int(11) NOT NULL DEFAULT 0,
  `tele` int(11) NOT NULL DEFAULT 0,
  `oven` int(11) NOT NULL DEFAULT 0,
  `air_conditionning` int(11) NOT NULL DEFAULT 0,
  `wash_machine` int(11) NOT NULL,
  `gym` int(11) NOT NULL DEFAULT 0,
  `kitchen` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `housing_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.housing : ~9 rows (environ)
INSERT INTO `housing` (`id`, `id_user`, `address`, `city`, `country`, `postal_code`, `title`, `type_house`, `type_location`, `amount_room`, `guest_capacity`, `property_area`, `disponibility`, `contact_phone`, `rate`, `price`, `fee`, `is_validated`, `creation_date`, `is_deleted`, `management_type`, `contact_time`, `description`, `wifi`, `parking`, `pool`, `tele`, `oven`, `air_conditionning`, `wash_machine`, `gym`, `kitchen`) VALUES
	(11, 23, '3 place des balmettes', 'Annecy', 'France', 74010, 'Petite maison dans le sud de Annecy', 'Maison', 'Logement complet', 3, 6, 65, NULL, '0645553073', NULL, 75.00, NULL, 1, '2024-05-13 16:31:09', 0, 'Yield Management', 'avant 13h', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(12, 23, '3 rue du vieux Port', 'Marseille', 'France', 13001, 'Appartement au bord du vieux Port', 'Appartement', 'Logement complet', 3, 6, 65, NULL, '0645553073', NULL, 75.00, NULL, 1, '2024-05-13 16:31:09', 0, 'Yield Management', 'avant 13h', 'Découvrez ce charmant appartement situé en plein cœur de Marseille, au bord du célèbre Vieux Port. Idéal pour des séjours en famille ou entre amis, cet appartement offre tout le confort nécessaire pour un séjour mémorable dans la cité phocéenne.', 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(15, 37, '4 rue de la saucisse', 'Strasbourg', 'France', 67482, 'Maison traditionelle prête à vous accueillir vous et vos compagnons pour des nuits endiablées', 'Maison', 'Gîte', 5, 8, 90, NULL, '0645553073', NULL, 75.00, NULL, 1, '2024-05-13 16:34:09', 0, 'Yield Management', 'avant 13h', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(16, 37, '9 rue de l\'allemagne de l\'ouest', 'Strasbourg', 'France', 67482, 'Appartement au centre de Strasbourg', 'Appartement', 'Logement complet', 2, 4, 65, NULL, '0645553073', NULL, 75.00, NULL, 1, '2024-05-13 16:36:09', 0, 'Yield Management', 'avant 13h', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(17, 37, '9 allée de la dune du Pila', 'Bordeaux', 'France', 33063, 'On vous accueille Chez NOUS à Bordeaux !', 'Maison', 'Chambre d\'hôtes', 8, 12, 120, NULL, '0645553073', NULL, 75.00, NULL, 1, '2024-05-13 16:37:09', 0, 'Yield Management', 'avant 13h', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(18, 37, '126 avenue du Général Pétain', 'Paris', 'France', 75013, 'Appartement placé dans le quartier chinois', 'Appartement', 'Logement complet', 2, 4, 35, NULL, '0645553073', NULL, 75.00, NULL, 1, '2024-05-13 16:38:09', 0, 'Yield Management', 'avant 13h', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(19, 37, '3 place des castagnettes', 'Marseille', 'France', 13005, 'Fan de foot, ce logement est fait pour vous !', 'Appartement', 'Logement complet', 2, 3, 40, NULL, '0645553073', NULL, 75.00, NULL, 1, '2024-05-13 16:38:09', 0, 'Yield Management', 'avant 13h', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(20, 37, '246 Rue Faubourg Saint antoine', 'Paris', 'France', 75012, 'Appartement miteux proche de l\'ESGI', 'Appartement', 'Logement complet', 1, 1, 15, NULL, '0645553073', NULL, 45.00, NULL, 1, '2024-05-13 16:40:09', 0, 'Yield Management', 'avant 13h', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(21, 37, '3 avenue du lac', 'Annecy', 'France', 74010, 'Petite chambre privée dans un appartement au bord du lac d\'Annecy', 'Appartement', 'Chambre privée', 1, 2, 55, NULL, '0645553073', NULL, 75.00, NULL, 0, '2024-05-13 16:42:09', 0, 'Yield Management', 'avant 13h', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- Listage de la structure de table pcs_all_bdd. likes
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_performance` int(11) DEFAULT NULL,
  `id_housing` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_housing` (`id_housing`),
  KEY `id_performance` (`id_performance`),
  CONSTRAINT `id_housing` FOREIGN KEY (`id_housing`) REFERENCES `housing` (`id`),
  CONSTRAINT `id_performance` FOREIGN KEY (`id_performance`) REFERENCES `performances` (`id`),
  CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.likes : ~6 rows (environ)
INSERT INTO `likes` (`id`, `id_user`, `id_performance`, `id_housing`) VALUES
	(7, 34, 2, NULL),
	(8, 34, 4, NULL),
	(10, 34, NULL, 11),
	(11, 34, NULL, 12),
	(21, 37, 2, NULL),
	(26, 37, NULL, 11),
	(30, 23, NULL, 12);

-- Listage de la structure de table pcs_all_bdd. newsletter
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.newsletter : ~0 rows (environ)

-- Listage de la structure de table pcs_all_bdd. payment_method
CREATE TABLE IF NOT EXISTS `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `content` char(16) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `payment_method_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.payment_method : ~0 rows (environ)

-- Listage de la structure de table pcs_all_bdd. performances
CREATE TABLE IF NOT EXISTS `performances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `performance_type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price_type` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `zip_appointment` char(5) NOT NULL,
  `address_appointment` varchar(255) NOT NULL,
  `city_appointment` varchar(255) NOT NULL,
  `country_appointment` varchar(255) NOT NULL,
  `is_validated` tinyint(1) NOT NULL DEFAULT 0,
  `id_user` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `rate` int(11) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `radius` decimal(11,8) DEFAULT NULL,
  `creation_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`id_user`),
  CONSTRAINT `user_id` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.performances : ~7 rows (environ)
INSERT INTO `performances` (`id`, `performance_type`, `title`, `description`, `price_type`, `price`, `fee`, `zip_appointment`, `address_appointment`, `city_appointment`, `country_appointment`, `is_validated`, `id_user`, `is_deleted`, `rate`, `place`, `radius`, `creation_date`) VALUES
	(1, 'taxi', 'taxi sur paname ', 'je vous emmène de tel a tel endroit sur paname', 'km', 3.00, 0.25, '75000', '0', 'paris', 'france', 1, 37, 0, NULL, NULL, 8.00000000, '2024-05-11 00:00:00'),
	(2, 'ménage', 'ménage sur paname', 'je nettoies vos logements sheesh', 'heure', 11.50, 0.50, '75000', '0', 'paris', 'france', 1, 23, 0, NULL, NULL, 1.00000000, '2024-05-11 00:00:00'),
	(4, 'taxi', 'test', 'test', 'km', 2.00, 0.40, '77515', '2 rue de meaux', 'Pommeuse', 'France', 1, 23, 0, NULL, NULL, 6.00000000, '2024-05-11 00:00:00'),
	(13, 'taxi', '222', '2222', 'heure', 2.00, 0.40, '77515', '2 rue de meaux', 'Pommeuse', 'France', 1, 37, 0, NULL, 'Pommeuse, France', 13.00000000, '2024-05-11 00:00:00'),
	(14, 'taxi', 'test', '22', 'km', 2.00, 0.40, '77515', '2 rue de meaux', 'Pommeuse', 'France', 1, 37, 0, NULL, 'Rua da Beneficência 241, Lisbonne, Portugal', 1.00000000, '2024-05-11 00:00:00'),
	(17, 'chauffagiste', 'test', 'test', 'heure', 2.00, 0.40, '93160', '3 ALLEE DES CAMELIAS', 'NOISY LE GRAND', 'France', 1, 37, 0, NULL, '22', 6.00000000, '2024-05-11 00:00:00'),
	(22, 'menuisier', 'ertterertertert', 'terterertterterertertertertterertterrtrteer', 'prestation', 22.00, 4.40, '93160', '3 allée des camélias', 'Noisy le grand', 'France', 0, 23, 0, NULL, 'terterertterterertertertertterertterrtrteer', 13.00000000, '2024-07-02 20:53:58');

-- Listage de la structure de table pcs_all_bdd. private_message
CREATE TABLE IF NOT EXISTS `private_message` (
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `content` text DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `message_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_by_user` tinyint(1) DEFAULT 0,
  `housing_id` int(11) DEFAULT NULL,
  `performance_id` int(11) DEFAULT NULL,
  `id_conv` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `housing_id` (`housing_id`),
  KEY `private_message_performances_id_fk` (`performance_id`),
  KEY `from_user_id` (`from_user_id`),
  KEY `to_user_id` (`to_user_id`),
  CONSTRAINT `housing_id` FOREIGN KEY (`housing_id`) REFERENCES `housing` (`id`),
  CONSTRAINT `private_message_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `private_message_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `private_message_performances_id_fk` FOREIGN KEY (`performance_id`) REFERENCES `performances` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=318 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.private_message : ~9 rows (environ)
INSERT INTO `private_message` (`id`, `content`, `from_user_id`, `to_user_id`, `message_date`, `read_by_user`, `housing_id`, `performance_id`, `id_conv`) VALUES
	(265, 'TESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTEST', 23, 37, '2024-06-26 16:09:29', 0, 12, NULL, '109b6cede0269f20b1baf98239f7e27ee55cbbcf1d9e2b7e97a4f051bf424a74'),
	(266, NULL, 23, 37, '2024-06-26 16:11:56', 0, 15, NULL, 'a5e3209c41af4cfa8c06713ad79b994aa20de0561be3bde47926bd74acbf31c9'),
	(267, NULL, NULL, 37, '2024-06-27 05:23:10', 0, 12, NULL, 'f6ef9f05f9cf50b12d5ac56e485ce5c9d4169cd7fcd72f15e9e6437dcae37f80'),
	(311, 'Bonjour, je suis intéressé par votre annonce test, pouvez-vous me donner plus d\'informations ?', 23, 37, '2024-07-02 22:02:29', 0, NULL, 4, '723e8a37ede3603606ca1218234aebef900026030c16736b67b2b867ecb079f5'),
	(312, 'Bonjour, je suis intéressé par votre annonce test, pouvez-vous me donner plus d\'informations ?', 23, 37, '2024-07-02 22:02:36', 0, NULL, 4, '723e8a37ede3603606ca1218234aebef900026030c16736b67b2b867ecb079f5'),
	(313, 'Bonjour, je suis intéressé par votre annonce test, pouvez-vous me donner plus d\'informations ?', 23, 37, '2024-07-02 22:06:07', 0, NULL, 4, '723e8a37ede3603606ca1218234aebef900026030c16736b67b2b867ecb079f5'),
	(314, 'Bonjour, je suis intéressé par votre annonce Appartement au bord du vieux Port, pouvez-vous me donner plus d\'informations ?', NULL, 23, '2024-07-02 22:25:21', 0, 12, NULL, '98516956020635d00571e8e03d40f39fe25539b479d3ab2905ce794942963ab2'),
	(315, 'Bonjour, je suis intéressé par votre annonce ménage sur paname, pouvez-vous me donner plus d\'informations ?', NULL, 23, '2024-07-03 14:47:01', 0, NULL, 2, '12ffb50496341f5d6e859695b3b37443e04565e6e2b4e10cea9049d0761f369b'),
	(316, 'Bonjour, je suis intéressé par votre annonce Appartement au bord du vieux Port, pouvez-vous me donner plus d\'informations ?', NULL, 23, '2024-07-03 16:46:58', 0, 12, NULL, 'b455ccaab2264e2b9595964f1865c42cfbdddae2b5f334945ecce24f89a20beb'),
	(317, 'Bonjour, je suis intéressé par votre annonce ménage sur paname, pouvez-vous me donner plus d\'informations ?', NULL, 23, '2024-07-04 15:11:06', 0, NULL, 2, '7316114ce93bc8ae3326c3feaa790667247beb1694f9a09c45b41d5f4e00d8b6');

-- Listage de la structure de table pcs_all_bdd. ticket
CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL,
  `content` text NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  `subject` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `tech_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `ticket_user_id_fk` (`tech_id`),
  CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `ticket_user_id_fk` FOREIGN KEY (`tech_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.ticket : ~76 rows (environ)
INSERT INTO `ticket` (`id`, `id_user`, `type`, `content`, `creation_date`, `status`, `subject`, `answer_id`, `tech_id`) VALUES
	(1, 37, 0, 'ss', '2024-05-09 00:00:00', 1, 1, NULL, NULL),
	(2, 34, 0, 'ffff fff fff fff ff fff fff fff fffff fff fff fff ff fff fff fff fffff fff fff fff ff fff fff fff fffff fff fff fff ff fff fff fff fffff fff fff fff ff fff fff fff fffff fff fff fff ff fff fff fff fffff fff fff fff ff fff fff fff fffff fff fff fff ff fff fff fff f', '2024-05-09 00:00:00', 2, 1, 1, NULL),
	(3, 23, 1, 'f', '2024-05-09 00:00:00', 0, 1, 1, NULL),
	(4, 23, 0, 'dd', '2024-05-09 00:00:00', 1, 1, NULL, NULL),
	(5, 34, 0, 'test', '2024-05-09 00:00:00', 1, 1, NULL, 37),
	(6, 34, 1, 'Coucou', '2024-05-10 00:00:00', 1, 1, 2, 37),
	(7, 34, 1, 'dd', '2024-05-10 00:00:00', 0, 1, 2, NULL),
	(8, 34, 1, 'nh\r\n', '2024-05-10 00:00:00', 0, 1, 1, NULL),
	(9, 23, 0, 'olkjhgcfcvbh,k:mù', '2024-05-10 00:00:00', 2, 4, NULL, NULL),
	(10, 23, 1, 'prout', '2024-05-10 00:00:00', 0, 4, 9, NULL),
	(11, 34, 1, 'COUCOU', '2024-05-12 00:00:00', 0, 1, 5, NULL),
	(12, 34, 0, 'ticket\r\n', '2024-05-16 00:00:00', 2, 1, NULL, 37),
	(13, 37, 0, 'test', '2024-06-05 00:00:00', 2, 1, NULL, NULL),
	(14, 37, 1, 'cc\r\n', '2024-06-05 00:00:00', 0, 1, 13, NULL),
	(15, 37, 0, 'oui', '2024-06-05 00:00:00', 2, 1, NULL, NULL),
	(16, 23, 0, 'test', '2024-06-05 00:00:00', 2, 2, NULL, NULL),
	(17, NULL, 0, 'dzd', '2024-06-05 00:00:00', 2, 1, NULL, NULL),
	(18, NULL, 0, '223', '2024-06-05 00:00:00', 2, 1, NULL, NULL),
	(19, NULL, 0, 'coucou\r\n', '2024-06-05 00:00:00', 1, 1, NULL, NULL),
	(20, 37, 0, 'ceci est un ticlet de tst', '2024-06-05 00:00:00', 2, 1, NULL, NULL),
	(21, 37, 1, 'rh', '2024-06-05 00:00:00', 0, 10, 20, NULL),
	(22, 37, 1, 'rh', '2024-06-05 00:00:00', 0, 10, 20, NULL),
	(23, 37, 1, 'koukou', '2024-06-05 00:00:00', 0, 10, 20, NULL),
	(24, NULL, 0, 'test', '2024-06-06 00:00:00', 2, 3, NULL, NULL),
	(25, NULL, 0, 'Coucou', '2024-06-06 00:00:00', 2, 1, NULL, NULL),
	(26, NULL, 0, 'Jeieiek', '2024-06-06 00:00:00', 2, 1, NULL, NULL),
	(27, NULL, 0, 'ée', '2024-06-06 00:00:00', 0, 1, NULL, NULL),
	(28, NULL, 0, '2', '2024-06-06 00:00:00', 0, 1, NULL, NULL),
	(29, NULL, 0, 'fdf', '2024-06-06 00:00:00', 0, 1, NULL, NULL),
	(30, 23, 0, 'fdf', '2024-06-06 00:00:00', 0, 1, NULL, NULL),
	(31, 37, 0, 'gg\r\n', '2024-06-08 00:00:00', 2, 1, NULL, NULL),
	(32, 37, 1, 'test', '2024-06-08 00:00:00', 0, 10, 31, NULL),
	(33, 37, 1, 'test', '2024-06-15 19:42:54', 0, 10, 1, NULL),
	(34, 37, 1, 'test', '2024-06-15 19:43:49', 0, 10, 4, NULL),
	(35, 37, 1, 'ceciii est un test', '2024-06-15 19:44:27', 0, 10, 5, NULL),
	(36, 37, 1, 'hh', '2024-06-16 16:05:06', 0, 10, 4, NULL),
	(37, 37, 1, 'qsf', '2024-06-16 16:06:41', 0, 10, 4, NULL),
	(38, 37, 1, 'l', '2024-06-16 16:07:38', 0, 10, 1, NULL),
	(39, 37, 1, 'dsqfv', '2024-06-16 16:08:19', 0, 10, 4, NULL),
	(40, 37, 1, 'qzefzef', '2024-06-16 16:10:05', 0, 10, 4, NULL),
	(41, 37, 1, 'une réponse', '2024-06-16 16:26:23', 0, 10, 16, NULL),
	(42, 37, 1, 'bonjour allez manger de l\'herbe', '2024-06-16 18:26:52', 0, 10, 19, NULL),
	(43, 37, 1, 'fsfdvs', '2024-06-16 18:28:22', 0, 10, 1, NULL),
	(44, 37, 1, 'fsfdvs', '2024-06-16 18:28:23', 0, 10, 1, NULL),
	(45, 37, 1, 'fsfdvs', '2024-06-16 18:28:24', 0, 10, 1, NULL),
	(46, 37, 1, 'fsfdvs', '2024-06-16 18:28:25', 0, 10, 1, NULL),
	(47, 37, 1, 'v', '2024-06-16 18:28:26', 0, 10, 1, NULL),
	(48, 37, 1, 'fsfdvs', '2024-06-16 18:28:26', 0, 10, 1, NULL),
	(49, 37, 1, 'fsfdvs', '2024-06-16 18:28:27', 0, 10, 1, NULL),
	(50, 37, 1, 'fsfdvsSQDvVVvszfefge', '2024-06-16 18:28:36', 0, 10, 1, NULL),
	(51, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:38', 0, 10, 1, NULL),
	(52, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:39', 0, 10, 1, NULL),
	(53, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:40', 0, 10, 1, NULL),
	(54, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:40', 0, 10, 1, NULL),
	(55, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:42', 0, 10, 1, NULL),
	(56, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:43', 0, 10, 1, NULL),
	(57, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:45', 0, 10, 1, NULL),
	(58, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:49', 0, 10, 1, NULL),
	(59, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:50', 0, 10, 1, NULL),
	(60, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:51', 0, 10, 1, NULL),
	(61, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:52', 0, 10, 1, NULL),
	(62, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:52', 0, 10, 1, NULL),
	(63, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:53', 0, 10, 1, NULL),
	(64, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:53', 0, 10, 1, NULL),
	(65, 37, 1, 'fsfdvsSQDvVVvszfefg', '2024-06-16 18:28:54', 0, 10, 1, NULL),
	(66, 37, 1, 'oui c\'est moi', '2024-06-16 18:29:32', 0, 10, 16, NULL),
	(67, 23, 1, 'SALUT', '2024-06-16 18:29:43', 0, 10, 16, NULL),
	(68, 37, 1, 'oui', '2024-06-16 18:29:58', 0, 10, 16, NULL),
	(69, 23, 1, 'test', '2024-06-16 18:30:02', 0, 10, 16, NULL),
	(70, 37, 1, 'ok', '2024-06-16 18:30:03', 0, 10, 16, NULL),
	(71, 37, 1, 'gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', '2024-06-17 10:28:41', 0, 10, 1, NULL),
	(72, 37, 1, 'ggggggggggggggggggggggggggggggggggggggggggggggggggggggggg   ggggggggggggggggggggggggggggggggggggggggggggggggggggggggg   ggggggggggggggggggggggggggggggggggggggggggggggggggggggggg   ggggggggggggggggggggggggggggggggggggggggggggggggggggggggg   ggggggggggggggggggggggggggggggggggggggggggggggggggggggggg   ggggggggggggggggggggggggggggggggggggggggggggggggggggggggg   ggggggggggggggggggggggggggggggggggggggggggggggggggggggggg   ggggggggggggggggggggggggggggggggggggggggggggggggggggggggg   ggggggggggggggggggggggggggggggggggggggggggggggggggggggggg   ', '2024-06-17 13:25:07', 0, 10, 1, NULL),
	(73, 37, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat vehicula est, sit amet consectetur leo pharetra ac. Maecenas scelerisque, nulla a aliquet fermentum, nisi erat dictum nulla, nec posuere arcu erat vel dui. Nulla facilisi. Phasellus ut leo lorem. Vivamus id ante non ipsum aliquet tempus nec ac purus. Proin non bibendum odio. Vivamus convallis volutpat augue in aliquet. Nulla facilisi.\n\nSuspendisse potenti. Ut et elit at erat luctus lacinia. Donec finibus vestibulum magna, vel ultricies elit tempor et. Integer euismod purus at felis dictum, quis aliquet sem varius. Nullam ut facilisis nunc. Sed vulputate libero vel metus sodales, nec bibendum felis fringilla. Nam a lorem nec lectus efficitur pharetra. Nam vitae lectus a enim dignissim varius. Sed dapibus tortor a convallis iaculis. Nullam auctor consectetur velit nec tristique.\n\nPellentesque nec dignissim lectus. In eleifend purus eu justo varius, a malesuada sapien convallis. Mauris malesuada, nulla nec bibendum tristique, eros orci tincidunt metus, eget dapibus nunc risus id purus. Quisque ac venenatis sapien, sit amet accumsan lorem. Integer malesuada arcu sapien, et laoreet magna molestie sit amet. Fusce auctor sapien vitae cursus blandit. Donec aliquet sit amet justo ac ultricies. Proin et neque mauris.\n\nNam laoreet, sapien ac finibus sollicitudin, nunc mauris ullamcorper nulla, eu congue orci lacus non nisl. Curabitur sit amet libero eget nunc varius sollicitudin. Aliquam erat volutpat. Ut vulputate sapien id augue scelerisque posuere. Etiam sed eros non mauris porttitor suscipit. In hac habitasse platea dictumst. Etiam venenatis erat vel fringilla volutpat. Nullam interdum est et scelerisque scelerisque.\n\nAliquam erat volutpat. Duis id nisi nisi. Pellentesque et nunc in velit gravida suscipit. Maecenas congue, quam ut consequat ultrices, leo nunc suscipit ligula, nec varius ligula felis non risus. Duis lobortis augue at libero dictum, a interdum ligula egestas. Quisque in accumsan enim. Etiam sollicitudin ipsum eu arcu posuere, ut suscipit purus facilisis. Nulla facilisi. In tincidunt fringilla felis nec placerat.\n\nMauris nec ligula quam. Suspendisse et bibendum risus, non varius nisl. Cras vitae congue lectus. Fusce ut metus leo. Curabitur ut sem non nisi cursus tincidunt. In sagittis, justo at feugiat vestibulum, risus elit gravida elit, non faucibus mi libero a dui. Integer sit amet ex sed libero malesuada auctor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer a est dolor.\n\nPraesent non posuere velit. Proin et dignissim arcu. Nulla facilisi. Aenean ac metus arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Duis consectetur tristique erat, et viverra felis dictum et. Sed nec varius felis. Vestibulum ultricies dolor a libero sollicitudin, ut faucibus elit ullamcorper. Proin luctus condimentum eros, a dapibus metus tristique sit amet. Integer eget odio odio. Praesent tincidunt mauris id dolor suscipit, et sollicitudin purus dignissim. Proin accumsan, elit in porttitor lacinia, felis ipsum vehicula purus, id ultricies justo dui a libero.\n\nVestibulum cursus risus sed eros feugiat, ut efficitur nunc vestibulum. Vivamus aliquam interdum enim a volutpat. Cras in ante sed odio iaculis faucibus. Quisque malesuada nibh in eros hendrerit, eu dictum ligula hendrerit. Suspendisse potenti. Nulla facilisi. Donec euismod, libero id hendrerit pretium, magna lacus tempor magna, eu tincidunt nisl nisi eu mauris. Duis pretium sapien eget massa cursus, a convallis magna ultricies. Phasellus consectetur massa risus, non auctor ex venenatis vel.\n\nVivamus et cursus arcu. Vivamus tincidunt tincidunt nisi, id venenatis justo sollicitudin ac. Donec sit amet fringilla dolor. Aenean convallis ex vel velit scelerisque, ac tempor ligula fermentum. Fusce consequat posuere risus, id vestibulum nisi malesuada in. Ut eu tincidunt elit. Integer rutrum consectetur erat, nec auctor arcu vulputate ut. Donec mollis orci sit amet sagittis dictum. Aenean interdum pretium enim, id iaculis nunc hendrerit in. Aliquam erat volutpat.\n\n', '2024-06-17 13:27:34', 0, 10, 1, NULL),
	(74, 37, 1, 'bonjour c\'est mua', '2024-06-20 08:53:06', 0, 10, 25, NULL),
	(75, 32, 0, '(e', '2024-06-24 12:02:04', 0, 1, NULL, NULL),
	(76, 32, 1, 'kk', '2024-06-24 12:06:52', 0, 10, 75, NULL);

-- Listage de la structure de table pcs_all_bdd. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(25) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `extension` varchar(4) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `country` varchar(2) DEFAULT NULL,
  `grade` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(5) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT curdate(),
  `update_date` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `vip_status` tinyint(1) NOT NULL DEFAULT 0,
  `delete_date` datetime DEFAULT NULL,
  `vip_date` datetime DEFAULT NULL,
  `is_validated` tinyint(4) NOT NULL DEFAULT 0,
  `token` varchar(64) DEFAULT NULL,
  `admin_comments` text DEFAULT NULL,
  `pwd_token` varchar(64) DEFAULT NULL,
  `sub_id` varchar(255) DEFAULT NULL,
  `vip_type` int(11) DEFAULT NULL,
  `free_perf` int(11) NOT NULL DEFAULT 0,
  `free_perf_end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table pcs_all_bdd.user : ~11 rows (environ)
INSERT INTO `user` (`id`, `pseudo`, `firstname`, `lastname`, `email`, `phone_number`, `extension`, `password`, `country`, `grade`, `address`, `city`, `postal_code`, `creation_date`, `update_date`, `is_deleted`, `is_admin`, `vip_status`, `delete_date`, `vip_date`, `is_validated`, `token`, `admin_comments`, `pwd_token`, `sub_id`, `vip_type`, `free_perf`, `free_perf_end_date`) VALUES
	(23, 'Kyksleouf', 'LEFEVRE', 'Kyllian', 'kyllian.lefevre@icloud.com', '0645553073', '+33', '$2y$10$WCBh9tfC7LDQz0mkjiQD0O6sIClIOcp2RRHqNcYaopwKtxnD.88By', 'FR', 5, '3 allée des camélias', 'Noisy-le-Grand', '93160', '2024-04-30 00:00:00', NULL, 0, 1, 0, NULL, NULL, 1, '25cf91175c2ac817e86bde8f0ceaa5bcbc659973805640c0e541894cff584225', NULL, '11438b2a697403c05a8e9da8f4bc09cd31f90357ce1b16a713cd7fc75204', '', NULL, 1, '2025-07-03'),
	(25, 'mike', 'Mike', 'Asfez', 'asfez.mike@outlook.fr', '0769654762', '', '$2y$10$L89vAKBw/WHVGYikzR1WYeEfVce0gh2rsMHYp1hu/aDK727Cvp5au', 'FR', 5, '117 Rue des Guillaumes', 'Noisy-le-Sec', '93130', '2024-04-30 00:00:00', NULL, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, '', NULL, 0, NULL),
	(26, 'mikee', 'Mike', 'Asfez', 'asfez.mike@outlook.com', '0769654762', '+33', '$2y$10$yLcxrUHTCqxNjkgY2yRku.LpCok8XJJmhizVO2JtpYS8QzZzl3mVy', 'FR', 5, '117 Rue des Guillaumes', 'Noisy-le-Sec', '93130', '2024-05-01 00:00:00', NULL, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL),
	(30, 'kakakakak', 'kaka', 'kakakaka', 'l@l.xom', NULL, NULL, '$2y$10$Ebytthc7vBe4sJ7om82lt.JLfz7JTfUVMyTwCnwGq4RZR5JBc9Vu6', NULL, 6, NULL, NULL, NULL, '2024-05-05 00:00:00', NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL),
	(32, 'Angel', 'angel', 'admin', 'angelique.lopes.fr@gmail.com', NULL, NULL, '$2y$10$wJMxFAmYU.yohK4rOVZpZOit475yfQnKmtGU5d/18vxrpn3Tw0o5i', NULL, 1, NULL, NULL, NULL, '2024-05-05 00:00:00', NULL, 0, 1, 0, NULL, NULL, 1, 'ad6728bfab600ab9eb6a3a43972b2c77ba6fcaa833f721628b006788b625f2cf', NULL, NULL, NULL, NULL, 0, NULL),
	(34, 'cemua', 'Angel', 'Angel', 'angelique.lopes.f@gmail.com', '768594620', '+33', '$2y$10$SX3JfsvXItT3Qb1BrO5HiuBUxh9jNBzXU0KqUtb.koauo1uxIemWu', 'FR', 1, '5', '3', '3', '2024-05-09 00:00:00', NULL, 0, 0, 0, NULL, NULL, 1, '4f25ecca8724334ca5bdf35b1a2edf73914f4aadc62e4c04e231611fe52ccf0b', NULL, '44f1c233e0feccec3a526f', NULL, NULL, 0, NULL),
	(37, 'coucou', 'Angélique', 'Lopes', 'angelique.lopes.f+1@gmail.com', '0123456789', '+33', '$2y$10$dpqeQvdel6NvBKBZhGYSIOPf8KhRKGEYRLUWJcy17.e7hYTCU8Qum', 'FR', 6, '3 ALLEE DES CAMELIAS', 'NOISY LE GRAND', '93160', '2024-06-02 00:00:00', NULL, 0, 1, 0, NULL, NULL, 1, '4336a7738837d5908f4e3aee7a6fb7b1284e7c7a106d32d1fb091c6544044b2c', NULL, NULL, NULL, NULL, 0, NULL),
	(47, 'kykyleouf', 'kyllian', 'kyllian', 'kyllian.lefevre+1@icloud.com', '0645553073', '+33', '$2y$10$t6x32C/oDN6iVbNldxDDL.wxnxqif4JbryvbwEbDRZN04lAxAb.2C', 'FR', 1, '3 allée des camélias', 'Noisy le grand', '93160', '2024-06-02 00:00:00', NULL, 0, 0, 0, NULL, NULL, 0, '3d984b3daee709c9c8a54420d08edefe5f125f98ca3cc6b391425f49ffda512c', NULL, '9de2f40743bd83b42b62620aa7ec9076a8415ded00be869d283fdda233e3', NULL, NULL, 0, NULL),
	(50, 'Jojo93', 'Jojo', 'Lolo', 'jose.lopes@neuf.fr', '0123456789', '+33', '$2y$10$HPmo2yf5kJDh0cV9x/8uU.U5ddMqnAfdxozyr/4IuUTz1HQTGWcvO', 'US', 1, '65 rue de la retraite ', 'Maison de retraite ', '75000', '2024-06-08 00:00:00', NULL, 0, 0, 0, NULL, NULL, 0, '4bfd1794c447b964b26f999c06717ebaa73f7e0363527114e8bc1ef3fee32ca0', NULL, NULL, NULL, NULL, 0, NULL),
	(51, 'fdsfsdf', 'Lefevre', 'kyllian', 'n8lik@icloud.com', '0645553073', '+33', '$2y$10$VKhoGz.kyGPrlPDMfGzaF.YTZp/ePGf/3imamT0Ef4MPNRq7z2fPi', 'FR', 6, '3 allée des camélias', 'Noisy le grand', '93160', '2024-06-24 00:00:00', NULL, 0, 1, 0, NULL, NULL, 1, 'e4e2786be41fe4a8e0e4467efb7006d540b8d48ee57c490fa985dcb751f1fc1b', NULL, NULL, NULL, NULL, 0, NULL),
	(52, 'N9lik', 'kykyk', 'kykyky', 'kykyky@gmail.com', '0645553073', '+33', '$2y$10$9EmE08KPPu4FT2n3GAQrUeamIabSlL.MiP5pVlkwleO6uBViCmI8a', 'FR', 1, '3 rue fhdujz', 'pommEUSE', '88842', '2024-07-03 00:00:00', NULL, 0, 0, 0, NULL, NULL, 0, '71674e30c67fae65984b6fff39adf94105a541acc5939d52a17d08f5352732d9', NULL, NULL, NULL, NULL, 0, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
