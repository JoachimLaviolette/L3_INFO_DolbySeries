-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1:3306
-- Généré le :  Sam 13 Mai 2017 à 17:14
-- Version du serveur :  5.6.34-log
-- Version de PHP :  7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `joadev`
--

-- --------------------------------------------------------

--
-- Structure de la table `creer`
--

CREATE TABLE IF NOT EXISTS `creer` (
  `ID_IND` int(4) NOT NULL DEFAULT '0',
  `ID_SERIE` int(4) NOT NULL DEFAULT '0',
  `DATE_CREATION` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `creer`
--

INSERT INTO `creer` (`ID_IND`, `ID_SERIE`, `DATE_CREATION`) VALUES
(0, 0, NULL),
(2, 0, NULL),
(8, 1, NULL),
(8, 8, NULL),
(22, 2, NULL),
(22, 19, NULL),
(23, 2, NULL),
(23, 14, NULL),
(23, 19, NULL),
(24, 2, NULL),
(24, 3, NULL),
(24, 14, NULL),
(24, 19, NULL),
(31, 3, NULL),
(32, 3, NULL),
(33, 3, NULL),
(40, 4, NULL),
(41, 4, NULL),
(48, 4, NULL),
(50, 5, NULL),
(51, 5, NULL),
(52, 5, NULL),
(59, 6, NULL),
(68, 7, NULL),
(82, 9, NULL),
(83, 9, NULL),
(88, 10, NULL),
(94, 11, NULL),
(100, 12, NULL),
(101, 12, NULL),
(112, 13, NULL),
(120, 14, NULL),
(128, 15, NULL),
(135, 16, NULL),
(141, 17, NULL),
(142, 17, NULL),
(147, 18, NULL),
(148, 18, NULL),
(159, 20, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `episodes`
--

CREATE TABLE IF NOT EXISTS `episodes` (
  `ID_EP` int(4) NOT NULL DEFAULT '0',
  `NOM_EP` varchar(50) DEFAULT NULL,
  `DUREE_EP` int(3) DEFAULT NULL,
  `DATE_EP` date DEFAULT NULL,
  `SUM_EP` varchar(1023) DEFAULT NULL,
  `SAISON_EP` int(4) NOT NULL DEFAULT '0',
  `ID_SERIE` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `episodes`
--

INSERT INTO `episodes` (`ID_EP`, `NOM_EP`, `DUREE_EP`, `DATE_EP`, `SUM_EP`, `SAISON_EP`, `ID_SERIE`) VALUES
(0, 'The Day Will Come When You Won''t Be', NULL, NULL, NULL, 7, 1),
(1, 'The Well', NULL, NULL, NULL, 7, 1),
(2, 'The Cell', NULL, NULL, NULL, 7, 1),
(3, 'Comme si c''était la première fois', NULL, NULL, NULL, 6, 1),
(4, 'Pas de sanctuaire', NULL, NULL, NULL, 5, 1),
(5, '30 jours sans accident', NULL, NULL, NULL, 4, 1),
(6, 'Graines', NULL, NULL, NULL, 3, 1),
(7, 'Ce qui nous attend', NULL, NULL, NULL, 2, 1),
(8, 'Passé décomposé', NULL, NULL, NULL, 1, 1),
(9, 'Echoes', NULL, NULL, NULL, 4, 0),
(10, 'Wanheda - Part One', NULL, NULL, NULL, 3, 0),
(11, '48', NULL, NULL, NULL, 2, 0),
(12, 'L''exil', NULL, NULL, NULL, 1, 0),
(13, 'Le retour du naufragé', NULL, NULL, NULL, 1, 2),
(14, 'Le combat continue', NULL, NULL, NULL, 2, 2),
(15, 'Je suis Oliver Queen', NULL, NULL, NULL, 3, 2),
(16, 'A la croisée des chemins', NULL, NULL, NULL, 4, 2),
(17, 'Lian Yu', NULL, NULL, NULL, 5, 2),
(18, 'Frappé par la foudre', NULL, NULL, NULL, 1, 3),
(19, 'L''homme qui a sauvé Central City', NULL, NULL, NULL, 2, 3),
(20, 'Flashpoint', NULL, NULL, NULL, 3, 3),
(21, 'Bienvenue à Brakebills', NULL, NULL, NULL, 1, 4),
(22, 'Le royaume de Fillory', NULL, NULL, NULL, 2, 4),
(23, 'Pilot', NULL, NULL, NULL, 3, 4),
(24, 'La disparition de Will Byers', NULL, NULL, NULL, 1, 5),
(25, 'Pilot', NULL, NULL, NULL, 2, 5),
(26, 'Pilot', NULL, NULL, NULL, 1, 6),
(27, 'Axis Mundi', NULL, NULL, NULL, 2, 6),
(28, 'Le livre de Kévin', NULL, NULL, NULL, 3, 6),
(29, 'Neige cède sous les pas', NULL, NULL, NULL, 1, 7),
(30, 'L''homme bon', NULL, NULL, NULL, 1, 8),
(31, 'La loi de la jungle', NULL, NULL, NULL, 2, 8),
(32, 'Pilot', NULL, NULL, NULL, 3, 8),
(33, 'The Original', NULL, NULL, NULL, 1, 9),
(34, 'Cassette 1 Face A', NULL, NULL, NULL, 1, 10),
(35, 'Il ne faut pas énerver le Dieu de la destruction', NULL, NULL, NULL, 1, 11),
(36, 'L''hiver vient', NULL, NULL, NULL, 1, 12),
(37, 'Le nord se souvient', NULL, NULL, NULL, 2, 12),
(38, 'Valar Dohaeris', NULL, NULL, NULL, 3, 12),
(39, 'Les deux épées', NULL, NULL, NULL, 4, 12),
(40, 'La guerre à venir', NULL, NULL, NULL, 5, 12),
(41, 'La femme rouge', NULL, NULL, NULL, 6, 12),
(42, 'Pilot', NULL, NULL, NULL, 7, 12),
(43, 'Alive in Tucson', NULL, NULL, NULL, 1, 13),
(44, 'Il y a quelqu''un ?', NULL, NULL, NULL, 2, 13),
(45, 'Peinture sur jean', NULL, NULL, NULL, 3, 13),
(46, 'Une nouvelle héroïne', NULL, NULL, NULL, 1, 14),
(47, 'Les aventures de Supergirl', NULL, NULL, NULL, 2, 14),
(48, 'Bruce Wayne', NULL, NULL, NULL, 1, 15),
(49, 'Le secret de Thomas Wayne', NULL, NULL, NULL, 2, 15),
(50, 'Better to Reign in Hell', NULL, NULL, NULL, 3, 15),
(51, 'Je n''étais pas prête', NULL, NULL, NULL, 1, 16),
(52, 'L''oiseau assoiffé', NULL, NULL, NULL, 2, 16),
(53, 'La fête des mères', NULL, NULL, NULL, 3, 16),
(54, 'Un ami encombrant', NULL, NULL, NULL, 4, 16),
(55, 'Sur le ring', NULL, NULL, NULL, 1, 17),
(56, 'Pan !', NULL, NULL, NULL, 2, 17),
(57, 'Eleven.Thirteen', NULL, NULL, NULL, 1, 18),
(58, 'Entrer dans la Légende', NULL, NULL, NULL, 1, 19),
(59, 'Hors du Temps', NULL, NULL, NULL, 2, 19),
(60, 'La morsure', NULL, NULL, NULL, 1, 20),
(61, 'L''Omega', NULL, NULL, NULL, 2, 20),
(62, 'Tatouage', NULL, NULL, NULL, 3, 20),
(63, 'La Lune sombre', NULL, NULL, NULL, 4, 20),
(64, 'Les créatures de la Nuit', NULL, NULL, NULL, 5, 20),
(65, 'Mémoire perdue', NULL, NULL, NULL, 6, 20),
(66, 'La Terre explose ?', NULL, NULL, NULL, 2, 11),
(67, 'Celui qui hérite du sang de Saiyen', NULL, NULL, NULL, 3, 11);

-- --------------------------------------------------------

--
-- Structure de la table `etre_du_genre`
--

CREATE TABLE IF NOT EXISTS `etre_du_genre` (
  `NOM_GENRE` varchar(25) NOT NULL DEFAULT '',
  `ID_SERIE` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `etre_du_genre`
--

INSERT INTO `etre_du_genre` (`NOM_GENRE`, `ID_SERIE`) VALUES
('Aventure', 0),
('Drame', 0),
('Science-fiction', 0),
('Drame', 1),
('Epouvante-horreur', 1),
('Action', 2),
('Aventure', 2),
('Drame', 2),
('Fantastique', 2),
('Super-heros', 2),
('Action', 3),
('Aventure', 3),
('Drame', 3),
('Fantastique', 3),
('Super-heros', 3),
('Aventure', 4),
('Drame', 4),
('Fantastique', 4),
('Action', 5),
('Drame', 5),
('Fantastique', 5),
('Science-fiction', 5),
('Drame', 6),
('Fantastique', 6),
('Action', 7),
('Aventure', 7),
('Drame', 7),
('Super-heros', 7),
('Action', 8),
('Drame', 8),
('Epouvante-horreur', 8),
('Drame', 9),
('Science-fiction', 9),
('Thriller', 9),
('Western', 9),
('Drame', 10),
('Action', 11),
('Animation', 11),
('Aventure', 11),
('Aventure', 12),
('Drame', 12),
('Fantastique', 12),
('Comique', 13),
('Drame', 13),
('Action', 14),
('Aventure', 14),
('Drame', 14),
('Fantastique', 14),
('Super-heros', 14),
('Action', 15),
('Aventure', 15),
('Drame', 15),
('Fantastique', 15),
('Super-heros', 15),
('Comique', 16),
('Drame', 16),
('Action', 17),
('Drame', 17),
('Super-heros', 17),
('Drame', 18),
('Science-fiction', 18),
('Action', 19),
('Fantastique', 19),
('Super-heros', 19),
('Action', 20),
('Aventure', 20),
('Drame', 20),
('Fantastique', 20);

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `NOM_GENRE` varchar(25) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `genres`
--

INSERT INTO `genres` (`NOM_GENRE`) VALUES
('Action'),
('Animation'),
('Aventure'),
('Comique'),
('Drame'),
('Epouvante-horreur'),
('Fantastique'),
('Science-fiction'),
('Super-heros'),
('Thriller'),
('Western');

-- --------------------------------------------------------

--
-- Structure de la table `individus`
--

CREATE TABLE IF NOT EXISTS `individus` (
  `ID_IND` int(4) NOT NULL DEFAULT '0',
  `NOM_IND` varchar(25) DEFAULT NULL,
  `PREN_IND` varchar(25) DEFAULT NULL,
  `CREATEUR` char(1) DEFAULT '0',
  `PRODUCTEUR` char(1) DEFAULT '-',
  `ACTEUR` char(1) DEFAULT '-',
  `REALISATEUR` char(1) DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `individus`
--

INSERT INTO `individus` (`ID_IND`, `NOM_IND`, `PREN_IND`, `CREATEUR`, `PRODUCTEUR`, `ACTEUR`, `REALISATEUR`) VALUES
(0, 'White', 'Dean', '0', '0', '0', '1'),
(1, 'Miller', 'Matt', '0', '1', '0', '0'),
(2, 'Rothenberg', 'Jason', '1', '0', '0', '0'),
(3, 'Taylor', 'Eliza', '0', '0', '1', '0'),
(4, 'Morley', 'Bob', '0', '0', '1', '0'),
(5, 'Turco', 'Paige', '0', '0', '1', '0'),
(6, 'Nicotero', 'Greg', '0', '0', '0', '1'),
(7, 'Darabont', 'Frank', '0', '1', '0', '0'),
(8, 'Kirkman', 'Robert', '1', '0', '0', '0'),
(9, 'Lincoln', 'Andrew', '0', '0', '1', '0'),
(10, 'Reedus', 'Norman', '0', '0', '1', '0'),
(11, 'Yeun', 'Steven', '0', '0', '1', '0'),
(12, 'Riggs', 'Chandler', '0', '0', '1', '0'),
(13, 'Cohan', 'Lauren', '0', '0', '1', '0'),
(14, 'Gurira', 'Danai', '0', '0', '1', '0'),
(15, 'McBride', 'Melissa', '0', '0', '1', '0'),
(16, 'Cudlitz', 'Michael', '0', '0', '1', '0'),
(17, 'James', 'Lennie', '0', '0', '1', '0'),
(18, 'Martin-Green', 'Sonequa', '0', '0', '1', '0'),
(19, 'McDermitt', 'Josh', '0', '0', '1', '0'),
(20, 'Seth', 'Gilliam', '0', '0', '1', '0'),
(21, 'Dean Morgan', 'Jeffrey', '0', '0', '1', '0'),
(22, 'Guggenheim', 'Marc', '1', '0', '0', '0'),
(23, 'Kreisberg', 'Andrew', '1', '0', '0', '0'),
(24, 'Berlanti', 'Greg', '1', '1', '0', '0'),
(25, 'Amell', 'Stephen', '0', '0', '1', '0'),
(26, 'Bett Rickards', 'Emily', '0', '0', '1', '0'),
(27, 'Cassidy', 'Katie', '0', '0', '1', '0'),
(28, 'Holland', 'Willa', '0', '0', '1', '0'),
(29, 'Haynes', 'Colton', '0', '0', '1', '0'),
(30, 'Smith', 'Gregory', '0', '0', '1', '0'),
(31, 'Johns', 'Marcus', '1', '0', '0', '0'),
(32, 'Garber', 'Victor', '1', '0', '1', '0'),
(33, 'Felton', 'Tom', '1', '0', '1', '0'),
(34, 'Gustin', 'Grant', '0', '0', '1', '0'),
(35, 'Panabaker', 'Danielle', '0', '0', '1', '0'),
(36, 'Patton', 'Candice', '0', '0', '1', '0'),
(37, 'Cavanagh', 'Tom', '0', '0', '1', '0'),
(38, 'Valdes', 'Carlos', '0', '0', '1', '0'),
(39, 'Hemecker', 'Ralph', '0', '0', '0', '1'),
(40, 'McNamara', 'John', '1', '0', '0', '0'),
(41, 'Gamble', 'Sera', '1', '1', '0', '0'),
(42, 'Ralph', 'Jason', '0', '0', '1', '0'),
(43, 'Taylor Dudley', 'Olivia', '0', '0', '1', '0'),
(44, 'Gupta', 'Arjun', '0', '0', '1', '0'),
(45, 'Appleman', 'Hale', '0', '0', '1', '0'),
(46, 'Maeve', 'Stella', '0', '0', '1', '0'),
(47, 'Tailor', 'Jade', '0', '0', '1', '0'),
(48, 'London', 'Michael', '0', '1', '0', '0'),
(49, 'Fisher', 'Chris', '0', '0', '0', '1'),
(50, 'Duffer', 'Matt', '1', '1', '0', '1'),
(51, 'Duffer', 'Ross', '1', '1', '0', '1'),
(52, 'Doble', 'Justin', '1', '0', '0', '0'),
(53, 'Bobby Brown', 'Millie', '0', '0', '1', '0'),
(54, 'Ryder', 'Winona', '0', '0', '1', '0'),
(55, 'Matarazzo', 'Gaten', '0', '0', '1', '0'),
(56, 'Wolfhard', 'Finn', '0', '0', '1', '0'),
(57, 'Dyer', 'Natalia', '0', '0', '1', '0'),
(58, 'McLaughlin', 'Caleb', '0', '0', '1', '0'),
(59, 'Lindelof', 'Damon', '1', '1', '0', '0'),
(60, 'Theroux', 'Justin', '1', '0', '1', '0'),
(61, 'Tyler', 'Liv', '0', '0', '1', '0'),
(62, 'Qualet', 'Margaret', '0', '0', '1', '0'),
(63, 'Coon', 'Carrie', '0', '0', '1', '0'),
(64, 'Brenneman', 'Amy', '0', '0', '0', '0'),
(65, 'Perrotta', 'Tom', '0', '1', '0', '0'),
(66, 'Berg', 'Peter', '0', '1', '0', '0'),
(67, 'Leder', 'Mimi', '0', '0', '0', '1'),
(68, 'Thomas', 'Roy', '1', '0', '0', '0'),
(69, 'Jones', 'Finn', '0', '0', '1', '0'),
(70, 'Henwick', 'Jessica', '0', '0', '1', '0'),
(71, 'Dawson', 'Rosario', '0', '0', '1', '0'),
(72, 'Stroup', 'Jessica', '0', '0', '1', '0'),
(73, 'Wenham', 'David', '0', '0', '1', '0'),
(74, 'Dahl', 'John', '0', '1', '0', '1'),
(75, 'Erickson', 'Dave', '1', '0', '0', '0'),
(76, 'Dickens', 'Kim', '0', '0', '1', '0'),
(77, 'Curtis', 'Cliff', '0', '0', '1', '0'),
(78, 'Dillane', 'Frank', '0', '0', '1', '0'),
(79, 'Debnam-Carrey', 'Alycia', '0', '0', '1', '0'),
(80, 'Blades', 'Rubén', '0', '0', '1', '0'),
(81, 'Davidson', 'Adam', '0', '0', '0', '1'),
(82, 'Nolan', 'Jonathan', '1', '1', '0', '1'),
(83, 'Joy', 'Lisa', '1', '0', '0', '0'),
(84, 'Wood', 'Evan-Rachel', '0', '0', '1', '0'),
(85, 'Hopkins', 'Anthony', '0', '0', '1', '0'),
(86, 'Newton', 'Thandie', '0', '0', '1', '0'),
(87, 'Abrams', 'J.J', '0', '1', '0', '0'),
(88, 'Yorkey', 'Brian', '1', '1', '0', '1'),
(89, 'Minnette', 'Dylan', '0', '0', '1', '0'),
(90, 'Langford', 'Katherine', '0', '0', '1', '0'),
(91, 'Walsh', 'Kate', '0', '0', '1', '0'),
(92, 'Heizer', 'Miles', '0', '0', '1', '0'),
(93, 'Butler', 'Ross', '0', '0', '1', '0'),
(94, 'Toriyama', 'Akira', '1', '0', '0', '0'),
(95, 'Nozawa', 'Masako', '0', '0', '1', '0'),
(96, 'Kusao', 'Takeshi', '0', '0', '1', '0'),
(97, 'Horikawa', 'Ryo', '0', '0', '1', '0'),
(98, 'Kido', 'Atsushi', '0', '1', '0', '0'),
(99, 'Chioka', 'Kimitoshi', '0', '0', '0', '1'),
(100, 'Benioff', 'David', '1', '1', '0', '0'),
(101, 'Weiss', 'D.B', '1', '1', '0', '0'),
(102, 'Doelger', 'Frank', '0', '1', '1', '0'),
(103, 'Huffam', 'Mark', '0', '1', '1', '0'),
(104, 'Clarke', 'Emilia', '0', '0', '1', '0'),
(105, 'Turner', 'Sophie', '0', '0', '1', '0'),
(106, 'Harington', 'Kit', '0', '0', '1', '0'),
(107, 'Williams', 'Maisie', '0', '0', '1', '0'),
(108, 'Headey', 'Lena', '0', '0', '1', '0'),
(109, 'Dormer', 'Natalie', '0', '0', '1', '0'),
(110, 'Dinklage', 'Peter', '0', '0', '1', '0'),
(111, 'Van Patten', 'Timothy', '0', '0', '0', '1'),
(112, 'Forte', 'Will', '1', '0', '1', '1'),
(113, 'Jones', 'January', '0', '0', '1', '0'),
(114, 'Schaal', 'Kristen', '0', '0', '1', '0'),
(115, 'Coleman', 'Cleopetra', '0', '0', '1', '0'),
(116, 'Rodriguez', 'Mel', '0', '0', '1', '0'),
(117, 'Steenburgen', 'Mary', '0', '0', '1', '0'),
(118, 'Lord', 'Phil', '0', '1', '0', '0'),
(119, 'Miller', 'Chris', '0', '1', '0', '0'),
(120, 'Adler', 'Alison', '1', '0', '0', '0'),
(121, 'Benoist', 'Melissa', '0', '0', '1', '0'),
(122, 'Leigh', 'Chyler', '0', '0', '1', '0'),
(123, 'Brooks', 'Mehcad', '0', '0', '1', '0'),
(124, 'Hoechin', 'Tyler', '0', '0', '1', '0'),
(125, 'Jordan', 'Jeremy', '0', '0', '1', '0'),
(126, 'Harewood', 'David', '0', '0', '1', '0'),
(127, 'Winter', 'Glen', '0', '0', '0', '1'),
(128, 'Heller', 'Bruno', '1', '1', '0', '0'),
(129, 'McKenzie', 'Benjamin', '0', '0', '1', '0'),
(130, 'Bicondova', 'Camren', '0', '0', '1', '0'),
(131, 'Taylor', 'Robin', '0', '0', '1', '0'),
(132, 'Mazouz', 'David', '0', '0', '1', '0'),
(133, 'Cannon', 'Danny', '0', '0', '0', '1'),
(134, 'Trim', 'Michael', '0', '0', '0', '1'),
(135, 'Kohan', 'Jenji', '1', '1', '0', '0'),
(136, 'Schilling', 'Taylor', '0', '0', '1', '0'),
(137, 'Prepon', 'Laura', '0', '0', '1', '0'),
(138, 'Cox', 'Laverne', '0', '0', '1', '0'),
(139, 'Biggs', 'Jason', '0', '0', '1', '0'),
(140, 'McCarty', 'Andrew', '0', '0', '0', '1'),
(141, 'Goddard', 'Drew', '1', '1', '0', '0'),
(142, 'S. DeKnight', 'Steven', '1', '1', '0', '0'),
(143, 'Cox', 'Charlie', '0', '0', '1', '1'),
(144, 'Ann Woll', 'Deborah', '0', '0', '1', '0'),
(145, 'Henson', 'Elden', '0', '0', '1', '1'),
(146, 'Bernthal', 'Jon', '0', '0', '1', '0'),
(147, 'Cuse', 'Carlton', '1', '1', '0', '0'),
(148, 'Condal', 'Ryan', '1', '1', '0', '0'),
(149, 'Holloway', 'Josh', '0', '0', '1', '0'),
(150, 'Wayne Callies', 'Sarah', '0', '0', '1', '0'),
(151, 'Righetti', 'Amanda', '0', '0', '1', '0'),
(152, 'Kittles', 'Tory', '0', '0', '1', '0'),
(153, 'Campanella', 'Juan-José', '0', '0', '0', '1'),
(154, 'Lotz', 'Caity', '0', '0', '1', '0'),
(155, 'Wentworth', 'Miller', '0', '0', '1', '0'),
(156, 'Routh', 'Brandon', '0', '0', '1', '0'),
(157, 'Darvill', 'Arthur', '0', '0', '1', '0'),
(158, 'Renée', 'Ciara', '0', '0', '1', '0'),
(159, 'Davis', 'Jeff', '1', '1', '0', '0'),
(160, 'O''Brien', 'Dylan', '0', '0', '1', '1'),
(161, 'Posey', 'Tyler', '0', '0', '1', '1'),
(162, 'Roden', 'Holland', '0', '0', '1', '0'),
(163, 'Reed', 'Crystal', '0', '0', '1', '0'),
(164, 'Hennig', 'Shelley', '0', '0', '1', '0'),
(165, 'Ashby', 'Linden', '0', '0', '1', '0'),
(166, 'Sprayberry', 'Dylan', '0', '0', '1', '0'),
(167, 'Bourne', 'JR', '0', '0', '1', '0');

-- --------------------------------------------------------

--
-- Structure de la table `jouer`
--

CREATE TABLE IF NOT EXISTS `jouer` (
  `ID_IND` int(4) NOT NULL DEFAULT '0',
  `ID_EP` int(4) NOT NULL DEFAULT '0',
  `SAISON_EP` int(4) NOT NULL DEFAULT '0',
  `ID_SERIE` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `jouer`
--

INSERT INTO `jouer` (`ID_IND`, `ID_EP`, `SAISON_EP`, `ID_SERIE`) VALUES
(3, 0, 7, 1),
(9, 0, 7, 1),
(10, 0, 7, 1),
(11, 0, 7, 1),
(12, 0, 7, 1),
(13, 0, 7, 1),
(14, 0, 7, 1),
(15, 0, 7, 1),
(16, 0, 7, 1),
(17, 0, 7, 1),
(18, 0, 7, 1),
(19, 0, 7, 1),
(20, 0, 7, 1),
(21, 0, 7, 1),
(9, 1, 7, 1),
(10, 1, 7, 1),
(11, 1, 7, 1),
(12, 1, 7, 1),
(13, 1, 7, 1),
(14, 1, 7, 1),
(15, 1, 7, 1),
(16, 1, 7, 1),
(17, 1, 7, 1),
(18, 1, 7, 1),
(19, 1, 7, 1),
(20, 1, 7, 1),
(21, 1, 7, 1),
(9, 2, 7, 1),
(10, 2, 7, 1),
(11, 2, 7, 1),
(12, 2, 7, 1),
(13, 2, 7, 1),
(14, 2, 7, 1),
(15, 2, 7, 1),
(16, 2, 7, 1),
(17, 2, 7, 1),
(18, 2, 7, 1),
(19, 2, 7, 1),
(20, 2, 7, 1),
(21, 2, 7, 1),
(9, 3, 6, 1),
(10, 3, 6, 1),
(11, 3, 6, 1),
(12, 3, 6, 1),
(13, 3, 6, 1),
(14, 3, 6, 1),
(15, 3, 6, 1),
(16, 3, 6, 1),
(17, 3, 6, 1),
(18, 3, 6, 1),
(19, 3, 6, 1),
(20, 3, 6, 1),
(9, 4, 5, 1),
(10, 4, 5, 1),
(11, 4, 5, 1),
(12, 4, 5, 1),
(13, 4, 5, 1),
(14, 4, 5, 1),
(15, 4, 5, 1),
(16, 4, 5, 1),
(17, 4, 5, 1),
(18, 4, 5, 1),
(19, 4, 5, 1),
(20, 4, 5, 1),
(9, 5, 4, 1),
(10, 5, 4, 1),
(11, 5, 4, 1),
(12, 5, 4, 1),
(13, 5, 4, 1),
(14, 5, 4, 1),
(15, 5, 4, 1),
(16, 5, 4, 1),
(17, 5, 4, 1),
(18, 5, 4, 1),
(19, 5, 4, 1),
(20, 5, 4, 1),
(9, 6, 3, 1),
(10, 6, 3, 1),
(11, 6, 3, 1),
(12, 6, 3, 1),
(13, 6, 3, 1),
(14, 6, 3, 1),
(15, 6, 3, 1),
(17, 6, 3, 1),
(18, 6, 3, 1),
(9, 7, 2, 1),
(10, 7, 2, 1),
(11, 7, 2, 1),
(12, 7, 2, 1),
(13, 7, 2, 1),
(15, 7, 2, 1),
(17, 7, 2, 1),
(9, 8, 1, 1),
(10, 8, 1, 1),
(11, 8, 1, 1),
(12, 8, 1, 1),
(15, 8, 1, 1),
(17, 8, 1, 1),
(146, 8, 1, 1),
(150, 8, 1, 1),
(3, 9, 4, 0),
(4, 9, 4, 0),
(5, 9, 4, 0),
(3, 10, 3, 0),
(4, 10, 3, 0),
(5, 10, 3, 0),
(3, 11, 2, 0),
(4, 11, 2, 0),
(5, 11, 2, 0),
(3, 12, 1, 0),
(4, 12, 1, 0),
(5, 12, 1, 0),
(25, 13, 1, 2),
(26, 13, 1, 2),
(27, 13, 1, 2),
(28, 13, 1, 2),
(29, 13, 1, 2),
(32, 18, 1, 3),
(33, 18, 1, 3),
(34, 18, 1, 3),
(35, 18, 1, 3),
(36, 18, 1, 3),
(37, 18, 1, 3),
(38, 18, 1, 3),
(42, 21, 1, 4),
(43, 21, 1, 4),
(44, 21, 1, 4),
(45, 21, 1, 4),
(46, 21, 1, 4),
(47, 21, 1, 4),
(53, 24, 1, 5),
(54, 24, 1, 5),
(55, 24, 1, 5),
(56, 24, 1, 5),
(57, 24, 1, 5),
(58, 24, 1, 5),
(60, 26, 1, 6),
(61, 26, 1, 6),
(62, 26, 1, 6),
(63, 26, 1, 6),
(69, 29, 1, 7),
(70, 29, 1, 7),
(71, 29, 1, 7),
(72, 29, 1, 7),
(73, 29, 1, 7),
(76, 30, 1, 8),
(77, 30, 1, 8),
(78, 30, 1, 8),
(79, 30, 1, 8),
(80, 30, 1, 8),
(84, 33, 1, 9),
(85, 33, 1, 9),
(86, 33, 1, 9),
(89, 34, 1, 10),
(90, 34, 1, 10),
(91, 34, 1, 10),
(92, 34, 1, 10),
(93, 34, 1, 10),
(95, 35, 1, 11),
(96, 35, 1, 11),
(97, 35, 1, 11),
(102, 36, 1, 12),
(103, 36, 1, 12),
(104, 36, 1, 12),
(105, 36, 1, 12),
(106, 36, 1, 12),
(107, 36, 1, 12),
(108, 36, 1, 12),
(109, 36, 1, 12),
(110, 36, 1, 12),
(112, 43, 1, 13),
(113, 43, 1, 13),
(114, 43, 1, 13),
(115, 43, 1, 13),
(116, 43, 1, 13),
(117, 43, 1, 13),
(121, 46, 1, 14),
(122, 46, 1, 14),
(123, 46, 1, 14),
(124, 46, 1, 14),
(125, 46, 1, 14),
(126, 46, 1, 14),
(129, 48, 1, 15),
(130, 48, 1, 15),
(131, 48, 1, 15),
(132, 48, 1, 15),
(136, 51, 1, 16),
(137, 51, 1, 16),
(138, 51, 1, 16),
(139, 51, 1, 16),
(71, 55, 1, 17),
(143, 55, 1, 17),
(144, 55, 1, 17),
(145, 55, 1, 17),
(146, 55, 1, 17),
(149, 57, 1, 18),
(150, 57, 1, 18),
(151, 57, 1, 18),
(152, 57, 1, 18),
(32, 58, 1, 19),
(154, 58, 1, 19),
(155, 58, 1, 19),
(156, 58, 1, 19),
(157, 58, 1, 19),
(158, 58, 1, 19),
(124, 60, 1, 20),
(160, 60, 1, 20),
(161, 60, 1, 20),
(162, 60, 1, 20),
(163, 60, 1, 20),
(164, 60, 1, 20),
(165, 60, 1, 20),
(166, 60, 1, 20),
(167, 60, 1, 20);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `ID_MSG` int(4) NOT NULL,
  `ID_FORUM` int(4) DEFAULT NULL,
  `PSEUDO` varchar(25) DEFAULT NULL,
  `ID_SERIE` int(4) DEFAULT NULL,
  `TITRE_MSG` varchar(50) DEFAULT NULL,
  `TXT_MSG` varchar(1024) DEFAULT NULL,
  `DATE_MSG` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `messages`
--

INSERT INTO `messages` (`ID_MSG`, `ID_FORUM`, `PSEUDO`, `ID_SERIE`, `TITRE_MSG`, `TXT_MSG`, `DATE_MSG`) VALUES
(1, 2, 'Joachim', 0, 'SAlut', 'Liste des affaires pour Wanheda', '2017-05-05 14:21:10'),
(2, 1, 'Joachim', NULL, 'Salut', 'Bellamy doit vraiment mourir', '2017-05-05 14:23:53'),
(4, 3, 'Joachim', NULL, 'Une jeune et vive pr&eacute;sentation de jeune hom', 'Je voulais juste introduire un nouveau sujet... C''est quand m&ecirc;me incroyable &ccedil;a !', '2017-05-06 23:28:26'),
(5, 3, 'Joachim', NULL, 'Une jeune et vive pr&eacute;sentation de jeune hom', 'Je voulais juste introduire un nouveau sujet... C''est quand m&ecirc;me incroyable &ccedil;a !', '2017-05-06 23:31:37'),
(6, 3, 'Joachim', NULL, 'Une jeune et vive pr&eacute;sentation de jeune hom', 'Je voulais juste introduire un nouveau sujet... C''est quand m&ecirc;me incroyable &ccedil;a !', '2017-05-06 23:34:47'),
(7, 3, 'Joachim', NULL, 'Une jeune et vive pr&eacute;sentation de jeune hom', 'Je voulais juste introduire un nouveau sujet... C''est quand m&ecirc;me incroyable &ccedil;a !', '2017-05-06 23:35:21'),
(8, 3, 'Joachim', NULL, 'Une jeune et vive pr&eacute;sentation de jeune hom', 'Je voulais juste introduire un nouveau sujet... C''est quand m&ecirc;me incroyable &ccedil;a !', '2017-05-06 23:35:43'),
(9, 3, 'Joachim', NULL, 'Une jeune et vive pr&eacute;sentation de jeune hom', 'Je voulais juste introduire un nouveau sujet... C''est quand m&ecirc;me incroyable &ccedil;a !', '2017-05-06 23:36:02'),
(10, 3, 'Joachim', NULL, 'Une jeune et vive pr&eacute;sentation de jeune hom', 'Je voulais juste introduire un nouveau sujet... C''est quand m&ecirc;me incroyable &ccedil;a !', '2017-05-06 23:36:18'),
(11, 1, 'Joachim', NULL, 'AUjourd''hui, bah y''a rien. BLEH !', 'TROLL mais tu kiffes.', '2017-05-07 00:31:10'),
(12, 1, 'Joachim', NULL, 'ddd', 'ddd', '2017-05-07 12:01:37'),
(13, 2, 'Elodie', 0, 'rrr', 'RRR', '2017-05-07 15:36:43'),
(14, 1, 'Joachim', NULL, 'Roland Garros', 'Vive Nadal !', '2017-05-08 13:13:31'),
(15, 1, 'Joachim', NULL, 'If faut &eacute;crire', 'Il faut &eacute;crire', '2017-05-09 21:28:09');

-- --------------------------------------------------------

--
-- Structure de la table `noter_episodes`
--

CREATE TABLE IF NOT EXISTS `noter_episodes` (
  `PSEUDO` varchar(25) NOT NULL DEFAULT '',
  `ID_EP` int(4) NOT NULL DEFAULT '0',
  `SAISON_EP` int(4) NOT NULL DEFAULT '0',
  `ID_SERIE` int(4) NOT NULL DEFAULT '0',
  `NOTE_NE` int(2) DEFAULT NULL,
  `CMT_NE` varchar(255) DEFAULT NULL,
  `DATE_NE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

-- --------------------------------------------------------

--
-- Structure de la table `noter_series`
--

CREATE TABLE IF NOT EXISTS `noter_series` (
  `PSEUDO` varchar(25) NOT NULL DEFAULT '',
  `ID_SERIE` int(4) NOT NULL DEFAULT '0',
  `NOTE_NS` int(2) DEFAULT NULL,
  `CMT_NS` varchar(1000) DEFAULT NULL,
  `DATE_NS` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `noter_series`
--

INSERT INTO `noter_series` (`PSEUDO`, `ID_SERIE`, `NOTE_NS`, `CMT_NS`, `DATE_NS`) VALUES
('Axelle', 0, 9, 'C''est krooo bien', '2017-05-03 11:33:51'),
('Cindy', 0, 9, 'Un excellent début de saison 3 prometteur ! On est heureux de raccrocher le wagon à nos personnages toujours aussi attachant (le petit groupe d''explorateur de O. Bellamy and co dans l''épisode 1 est follement excitant avec la musique et le côté "heureux/malheureux" de la troupe comme avec Jasper et Raven). Clarke est toujours aussi épuisante, mais heureusement elle ne soutient pas la série à elle seule. Sa mère nous épuise aussi mais Marcus est là pour élever le niveau ! Niveau intrigue... Bof, c', '2017-05-03 08:07:41'),
('Elodie', 1, 7, 'Intéressante, cette façon d''utiliser le virus Zombie comme prétexte pour analyser et décortiquer les relations humaines, et explorer les tréfonds de son âme. Deuxième saison plus lente et psychologique donc, mais pas moins intéressante pour autant. Seul le début laisse à désirer, entre les discussions démesurées et monotones et la traque qui s''éternise.', '2017-05-01 08:44:02'),
('Elodie', 2, 8, 'Impecc', '2017-05-10 16:42:56'),
('Elodie', 4, 2, 'Elle est vraiment naze...', '2017-05-07 16:37:32'),
('Joachim', 0, 9, 'NUL !', '0000-00-00 00:00:00'),
('Joachim', 1, 9, 'La s&eacute;rie est riche en rebondissements !', '2017-05-12 23:09:27'),
('Joachim', 2, 9, 'Cette s&eacute;rie est top !', '2017-05-08 22:49:20'),
('Joachim', 3, 10, 'INCROYABLE !', '2017-05-09 22:52:25'),
('Joachim', 4, 8, 'Trop fort !', '2017-05-07 16:01:19'),
('Joachim', 5, 8, 'Top !!!', '2017-05-06 19:06:38'),
('Joachim', 6, 5, 'NUL', '2017-05-11 09:14:14'),
('Joachim', 7, 8, 'YEAHH', '2017-05-11 17:12:53'),
('Joachim', 13, 9, 'Cette série est dingue !', '2017-05-08 21:38:18'),
('Joachim', 15, 1, 'Franchement... Voil&agrave;.', '2017-05-11 17:13:43'),
('Joachim', 20, 10, 'Impeccable', '2017-05-05 03:31:00'),
('Magilan', 1, 9, 'La reprise de cette cinquième saison est la reprise la plus tendu et la plus réussite de la série à ce jour. Le nouveau générique apporte vraiment un plus malgré qu''il change toute les deux saisons. On peut observer une grande différence entre le Carl des débuts et celui de cette fin de saison 5. Une évolution aussi est a noter auprès de Rick surtout au niveau de sa mentalité et de son physique. La deuxième partie de saison est pour moi la plus importante. Le final est une fois de plus une réuss', '2017-04-10 15:36:28');

-- --------------------------------------------------------

--
-- Structure de la table `photo_individu`
--

CREATE TABLE IF NOT EXISTS `photo_individu` (
  `ID_IND` int(4) NOT NULL DEFAULT '0',
  `URL` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `photo_individu`
--

INSERT INTO `photo_individu` (`ID_IND`, `URL`) VALUES
(0, 'https://www.pixenli.com/images/1493/1493465628048739400.jpg'),
(1, 'https://www.pixenli.com/images/1493/1493465624065202200.jpg'),
(2, 'https://www.pixenli.com/images/1493/1493465621019937300.jpg'),
(3, 'https://www.pixenli.com/images/1493/1493465602016146800.png'),
(4, 'https://www.pixenli.com/images/1493/1493465613092745000.jpg'),
(5, 'https://www.pixenli.com/images/1493/1493465617055037300.jpg'),
(6, 'https://www.pixenli.com/images/1493/1493499739016952400.jpg'),
(7, 'https://www.pixenli.com/images/1493/1493499647026217000.jpg'),
(8, 'https://www.pixenli.com/images/1493/1493499677003545800.jpg'),
(9, 'https://www.pixenli.com/images/1493/1493465981068925900.jpg'),
(10, 'https://www.pixenli.com/images/1493/1493499621059893000.jpg'),
(11, 'https://www.pixenli.com/images/1493/1493465988017175100.jpg'),
(12, 'https://www.pixenli.com/images/1493/1493466009088765600.jpg'),
(13, 'https://www.pixenli.com/images/1493/1493466016024630200.jpg'),
(14, 'https://www.pixenli.com/images/1493/1493499613042504400.jpg'),
(15, 'https://www.pixenli.com/images/1493/1493465993091761300.jpg'),
(16, 'https://www.pixenli.com/images/1493/1493466023008472900.jpg'),
(17, 'https://www.pixenli.com/images/1493/1493465990095229300.jpg'),
(18, 'https://www.pixenli.com/images/1493/1493466002063269800.jpg'),
(19, 'https://www.pixenli.com/images/1493/1493465996058109000.jpg'),
(20, 'https://www.pixenli.com/images/1493/1493466007035723300.jpg'),
(21, 'https://www.pixenli.com/images/1493/1493465999063102400.jpg'),
(22, 'http://vignette2.wikia.nocookie.net/arrow-france/images/a/ab/Guggenheim.jpg/revision/latest?cb=20141012095314&path-prefix=fr'),
(23, 'http://cdn.collider.com/wp-content/uploads/2015/10/andrew-kreisberg.jpg'),
(24, 'http://static.tvgcdn.net/mediabin/showcards/celebs/g-i/thumbs/greg-berlanti_187201_768x1024.png'),
(25, 'http://68.media.tumblr.com/f3f93b06664f8f5416ad3633c0013422/tumblr_noj22weJIy1s88ss5o1_1280.jpg'),
(26, 'http://static.tvtropes.org/pmwiki/pub/images/emily_bett_rickards.png'),
(27, 'https://heavyeditorial.files.wordpress.com/2015/03/katie9.jpg?quality=65&strip=all&w=739'),
(28, 'https://images-na.ssl-images-amazon.com/images/M/MV5BNzgwMDk1NTUxMF5BMl5BanBnXkFtZTcwMTQxODY4Mg@@._V1_UY317_CR2,0,214,317_AL_.jpg'),
(29, 'https://vignette1.wikia.nocookie.net/teenwolf/images/4/40/Colton_haynes.jpg/revision/latest?cb=20170121222618'),
(30, 'https://s-media-cache-ak0.pinimg.com/originals/43/22/77/432277d4ccef896196d3b0a225af7608.jpg'),
(31, 'http://www.aceshowbiz.com/images/wennpic/marcus-johns-z100-s-jngle-ball-2014-01.jpg'),
(32, 'https://images-na.ssl-images-amazon.com/images/M/MV5BNTQxODYxNzE3NV5BMl5BanBnXkFtZTcwOTM4MTMwMg@@._V1_UY317_CR20,0,214,317_AL_.jpg'),
(33, 'http://www.mdvstyle.com/wp-content/uploads/2015/07/tom-felton-net-worth.jpg'),
(34, 'http://68.media.tumblr.com/2c344d5e0c4c74e6575372ed0c05ed57/tumblr_o0s1kbuO011susnhzo1_1280.jpg'),
(35, 'https://s-media-cache-ak0.pinimg.com/736x/3c/a4/a3/3ca4a3ee1b3423995ca5a6018228e344.jpg'),
(36, 'http://cimg.tvgcdn.net/i/2014/02/04/d75db1c4-0cb2-4117-9bd4-ec291fc66543/71b445d6a4c385fb1672b974426f0b80/140203candice-patton1.jpg'),
(37, 'http://vignette1.wikia.nocookie.net/arrow/images/0/03/Tom_Cavanagh.png/revision/latest?cb=20140212063306'),
(38, 'http://vignette2.wikia.nocookie.net/arrow/images/2/2c/Carlos_Valdes.png/revision/latest?cb=20150828085841'),
(39, 'http://vignette3.wikia.nocookie.net/nikita2010/images/d/d1/Ralph_Hemecker.jpg/revision/latest?cb=20121023004705'),
(40, 'https://www.pixenli.com/images/1493/1493866056060822900.png'),
(41, 'https://upload.wikimedia.org/wikipedia/commons/b/bc/Sera_Gamble.jpg'),
(42, 'http://www1.pictures.zimbio.com/gi/2016+Winter+TCA+Tour+Day+10+w9GnjW9rOw8l.jpg'),
(43, 'https://s-media-cache-ak0.pinimg.com/originals/58/66/2b/58662bf6c7ee352fcefa33c64ee8abdc.jpg'),
(44, 'https://img.buzzfeed.com/buzzfeed-static/static/2015-10/13/11/enhanced/webdr09/grid-cell-7476-1444748677-3.jpg'),
(45, 'http://www3.pictures.zimbio.com/gi/Premiere+Roadside+Attractions+LD+Entertainment+ofw1_y0aKbVx.jpg'),
(46, 'https://s-media-cache-ak0.pinimg.com/originals/50/96/37/5096379f5fd420eca475d278ddb6087d.jpg'),
(47, 'http://hairstyles.thehairstyler.com/hairstyle_views/front_view_images/11267/original/Jade-Tailor.jpg'),
(48, 'http://cdn5.thr.com/sites/default/files/2013/10/michael_london.jpg'),
(49, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTgxMjUyMDkzMl5BMl5BanBnXkFtZTcwMjk0NTI1NQ@@._V1_UX214_CR0,0,214,317_AL_.jpg'),
(50, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTQ4OTk1MjI1N15BMl5BanBnXkFtZTgwODc3NTQ1OTE@._V1_UY317_CR12,0,214,317_AL_.jpg'),
(51, 'http://cache3.asset-cache.net/xr/546336344.jpg?v=1&c=IWSAsset&k=3&d=77BFBA49EF878921CC759DF4EBAC47D0F5DB4B4E0453C621FF72A3CBC2223784C507817835B0C346A55A1E4F32AD3138'),
(52, 'https://www.pixenli.com/images/1493/1493866633027868300.png'),
(53, 'http://www.hawtcelebs.com/wp-content/uploads/2016/10/millie-bobby-brown-at-late-show-with-stephen-colbert-in-new-york-09-13-2016_1.jpg'),
(54, 'http://www.salihughesbeauty.com/wp-content/uploads/2013/05/936full-winona-ryder.jpg'),
(55, 'http://s1.r29static.com//bin/entry/69b/x,80/1651383/image.jpg'),
(56, 'http://www.oystermag.com/sites/default/files/imagecache/slider-gallery-980x650/images/finn_wolfhard_oct_2016_0152.jpg'),
(57, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTczNTg5NTgwNF5BMl5BanBnXkFtZTgwMjQ4MTE2NDE@._V1_UY317_CR53,0,214,317_AL_.jpg'),
(58, 'http://www4.pictures.zimbio.com/gi/Caleb+McLaughlin+Premiere+Netflix+Stranger+9mUTToUdbZCl.jpg'),
(59, 'https://pmcdeadline2.files.wordpress.com/2012/06/damonlindelof__120602022231.jpg'),
(60, 'http://media.gq.com/photos/57432cceab47ce87602862ff/master/w_800/justin-theroux-hippie.jpg'),
(61, 'http://static.gofugyourself.com/uploads/2014/06/liv-tyler-451122424.jpg'),
(62, 'http://celebmafia.com/wp-content/uploads/2014/06/margaret-qualley-the-leftovers-premiere-in-new-york-city_1.jpg'),
(63, 'https://s-media-cache-ak0.pinimg.com/originals/bb/7d/f0/bb7df09865eebca8b86a88b794de344a.jpg'),
(64, 'http://www.crohnscolitisfoundation.org/assets/images/amy-brenneman.jpg'),
(65, 'http://www4.pictures.zimbio.com/gi/75th+Annual+Peabody+Awards+Ceremony+Arrivals+vdSIpDafYwIl.jpg'),
(66, 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Peter_Berg_by_Gage_Skidmore.jpg/220px-Peter_Berg_by_Gage_Skidmore.jpg'),
(67, 'http://www2.pictures.zimbio.com/gi/Mimi+Leder+75th+Annual+Peabody+Awards+Ceremony+5KVWxAgRImql.jpg'),
(68, 'https://cdn.bleedingcool.net/wp-content/uploads/2011/03/roy-thomas.jpg'),
(69, 'http://www.universdescomics.com/wp-content/uploads/2017/03/Finn-Jones.jpg'),
(70, 'https://vignette2.wikia.nocookie.net/starwars/images/2/22/JessicaHenwick.jpg/revision/latest?cb=20160116142444'),
(71, 'http://www.hollywoodtuna.com/images/bigimages/rosario_dawson_eagle_7_big.jpg'),
(72, 'https://www.picsofcelebrities.com/celebrity/jessica-stroup/pictures/large/pictures-of-jessica-stroup.jpg'),
(73, 'http://4.bp.blogspot.com/_bQ0SqifjNcg/TMc4nCEmiDI/AAAAAAAAekg/Ug84dvQpbhs/s1600/david-wenham.jpg'),
(74, 'http://static.cinemagia.ro/img/db/actor/00/26/00/john-dahl-829883l.jpg'),
(75, 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Dave_Erickson_by_Gage_Skidmore.jpg/1200px-Dave_Erickson_by_Gage_Skidmore.jpg'),
(76, 'https://images-production.global.ssl.fastly.net/uploads/posts/image/69033/kim-dickens-fear-the-walking-dead.jpg'),
(77, 'https://s-media-cache-ak0.pinimg.com/236x/a8/9b/fc/a89bfc93c788a9236761db23394fcae2.jpg'),
(78, 'http://vignette2.wikia.nocookie.net/walkingdead/images/b/b1/M120668.jpg/revision/latest?cb=20150618234002'),
(79, 'https://s-media-cache-ak0.pinimg.com/originals/1c/f4/0f/1cf40fd1619291ee7fcfa30f5715ab62.jpg'),
(80, 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/Ruben_Blades_by_Gage_Skidmore.jpg/1200px-Ruben_Blades_by_Gage_Skidmore.jpg'),
(81, 'https://www.pixenli.com/images/1493/1493868384052734000.png'),
(82, 'http://fr.web.img6.acsta.net/c_215_290/pictures/16/10/05/15/33/182716.jpg'),
(83, 'https://www.pixenli.com/images/1493/1493872905078325000.png'),
(84, 'http://p.fod4.com/p/channels/lmlhp/profile/qADyQ4Snu7pEGlvLIDQA_EvanRachelWood.jpg'),
(85, 'http://cdn2.thr.com/sites/default/files/2012/05/anthony_hopkins_a_p.jpg'),
(86, 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Thandie_Newton_2%2C_2010.jpg/250px-Thandie_Newton_2%2C_2010.jpg'),
(87, 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/J._J._Abrams_by_Gage_Skidmore.jpg/220px-J._J._Abrams_by_Gage_Skidmore.jpg'),
(88, 'https://vignette2.wikia.nocookie.net/13reasonswhy/images/8/8a/Brian_Yorkey.jpg/revision/latest?cb=20170414123612'),
(89, 'http://assets.teenvogue.com/photos/5601a80eb49250507d9f4489/master/pass/boys-next-door-03.jpg'),
(90, 'https://thelast-magazine.com/wp-content/uploads/2017/04/wTLM_KatherineL_3.jpg'),
(91, 'http://www.photofromtheworld.com/img/Photo/People/Celebrities/Woman%20Celebrities/Actress/Kate%20Walsh/Kate%20Walsh%2006.jpg'),
(92, 'http://static.tvgcdn.net/mediabin/showcards/celebs/m-o/thumbs/miles-heizer_sc_768x1024.png'),
(93, 'http://www.mochimag.com/wp-content/uploads/2015/08/Ross-Butler-004-682x1024.jpg'),
(94, 'http://www.nautiljon.com/images/people/00/57/akira_toriyama_1475.jpg?1337757154'),
(95, 'https://vignette2.wikia.nocookie.net/dragonball/images/3/3b/92938-_large.jpg/revision/latest?cb=20100316123627'),
(96, 'http://vignette1.wikia.nocookie.net/doblaje/images/8/85/Takeshi_Kusao.jpg/revision/latest?cb=20120508011320&path-prefix=es'),
(97, 'http://nerdreactor.com/wp-content/uploads/2012/05/horikawa-199x300.jpg'),
(98, 'https://www.db-z.com/wp-content/uploads/2015/07/Atsushi-Kido-Toei-Animation.jpg'),
(99, 'https://myanimelist.cdn-dena.com/images/voiceactors/1/46826.jpg'),
(100, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTAzNjQzMTEzMzJeQTJeQWpwZ15BbWU3MDkxNjA4NDc@._V1_UY317_CR0,0,214,317_AL_.jpg'),
(101, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTgxMjQzMTYxMF5BMl5BanBnXkFtZTcwOTA2MDg0Nw@@._V1_UY317_CR4,0,214,317_AL_.jpg'),
(102, 'http://media.hollywood.com/images/668x1000/7232596.jpg'),
(103, 'http://vignette1.wikia.nocookie.net/oscars/images/1/19/MarkHuffam.jpg/revision/latest?cb=20160128010257'),
(104, 'http://youqueen.com/wp-content/uploads/2016/05/shutterstock_264297002.jpg'),
(105, 'http://www.thevibes.fr/upload/external/thevibe5772364e5280e.jpg'),
(106, 'http://blog.sfgate.com/dailydish/files/2014/04/Kit-Harington.jpg'),
(107, 'https://www.celebritysizes.com/wp-content/uploads/2015/03/Maisie-Williams.jpg'),
(108, 'https://s-media-cache-ak0.pinimg.com/originals/c0/05/29/c00529732deecff0922743762f62320d.jpg'),
(109, 'https://images-na.ssl-images-amazon.com/images/M/MV5BNjM4NjQwMzE1Ml5BMl5BanBnXkFtZTgwNjg5MTM0NzE@._V1_UX214_CR0,0,214,317_AL_.jpg'),
(110, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTM1MTI5Mzc0MF5BMl5BanBnXkFtZTYwNzgzOTQz._V1_UY317_CR20,0,214,317_AL_.jpg'),
(111, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTk4MDM0NDg4NV5BMl5BanBnXkFtZTcwMzgwNTgxOA@@._V1_UY317_CR12,0,214,317_AL_.jpg'),
(112, 'http://m.aceshowbiz.com/webimages/wennpic/will-forte-2015-fox-winter-television-critics-association-01.jpg'),
(113, 'https://s-media-cache-ak0.pinimg.com/736x/75/90/33/759033f6a742732d97bdf59ac43fd49d.jpg'),
(114, 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/69/Kristen_Schaal_Wondercon_2016.jpg/1200px-Kristen_Schaal_Wondercon_2016.jpg'),
(115, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMjA0MDUwMTA2N15BMl5BanBnXkFtZTgwNDAwODYyOTE@._V1_.jpg'),
(116, 'http://vignette3.wikia.nocookie.net/breakingbad/images/f/f3/Mel_Rodriguez.jpg/revision/latest?cb=20150407055345'),
(117, 'http://images4.static-bluray.com/products/22/3113_2_large.jpg'),
(118, 'https://vignette1.wikia.nocookie.net/himym/images/3/31/Phil_Lord.jpg/revision/latest?cb=20120719043358'),
(119, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTg4MDQ3MjE3MV5BMl5BanBnXkFtZTcwOTc1MDY0Nw@@._V1_UX214_CR0,0,214,317_AL_.jpg'),
(120, 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cf/Allison_Adler_by_Gage_Skidmore.jpg/220px-Allison_Adler_by_Gage_Skidmore.jpg'),
(121, 'https://s-media-cache-ak0.pinimg.com/originals/6c/a0/48/6ca048f44f2b614c99deeca585fd0d73.jpg'),
(122, 'https://s-media-cache-ak0.pinimg.com/originals/81/4f/6c/814f6cc4d8959659d7fc7b6bcd15b4d0.jpg'),
(123, 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Mehcad_Brooks.jpg/220px-Mehcad_Brooks.jpg'),
(124, 'https://s-media-cache-ak0.pinimg.com/736x/1c/18/c2/1c18c244323abb3e66ad69e0b54978d4.jpg'),
(125, 'http://vignette3.wikia.nocookie.net/theflash/images/5/58/Jeremy_Jordan.jpg/revision/latest?cb=20170122223402'),
(126, 'http://static.tvgcdn.net/mediabin/showcards/celebs/d-f/thumbs/david-harewood_768x1024.png'),
(127, 'http://vignette1.wikia.nocookie.net/arrow/images/9/9e/Glen_Winter.png/revision/latest?cb=20120604022501'),
(128, 'http://www.hollywoodreporter.com/sites/default/files/2013/10/Bruno_Heller.jpg'),
(129, 'http://hbz.h-cdn.co/assets/cm/15/06/54d11c20b5dfd_-_hbz-mcm-ben-mckenzie-md.jpg'),
(130, 'http://vignette2.wikia.nocookie.net/gotham/images/8/8d/Carmen_Bicondova-1-.jpg/revision/latest?cb=20140705104215&path-prefix=fr'),
(131, 'http://images.mstarsnews.musictimes.com/data/images/full/33686/robin-taylor.jpg'),
(132, 'http://img1.wikia.nocookie.net/__cb20140924230805/batman/images/4/45/David_Mazouz.jpg'),
(133, 'https://upload.wikimedia.org/wikipedia/commons/4/46/Danny_Cannon_at_NY_PaleyFest_2014_for_Gotham.jpg'),
(134, 'http://www4.pictures.zimbio.com/gi/Michael+Trim+2010+Creative+Arts+Emmy+Awards+rI0wStIaenNl.jpg'),
(135, 'http://www2.pictures.zimbio.com/gi/Jenji+Kohan+Arrivals+AFI+Awards+8G_bpWooD0el.jpg'),
(136, 'http://vignette4.wikia.nocookie.net/orange-is-the-new-black/images/7/7e/Taylorschiling.jpg/revision/latest?cb=20160124003552'),
(137, 'http://www.fandomisinthedetails.com/uploads/1/9/2/0/19201953/9363960_orig.jpg?401'),
(138, 'http://cdn-img.instyle.com/sites/default/files/styles/684xflex/public/images/2015/06/061815-lavern-cox-ltl-lead.jpg?itok=AF31xiNG'),
(139, 'http://vignette4.wikia.nocookie.net/teenage-mutant-ninja-turtles-2012/images/5/56/Jason_Biggs.jpg/revision/latest?cb=20121114022046'),
(140, 'http://static.tvgcdn.net/mediabin/showcards/celebs/a-b/thumbs/andrew-mccarthy-139674_828x1104.png'),
(141, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTgxMjQ4Mjc2OF5BMl5BanBnXkFtZTYwMzk3NDQ1._V1_UX214_CR0,0,214,317_AL_.jpg'),
(142, 'https://images-na.ssl-images-amazon.com/images/M/MV5BNzIyMjI5MDMyMV5BMl5BanBnXkFtZTgwNDExNTU5NDE@._V1_UY317_CR20,0,214,317_AL_.jpg'),
(143, 'http://www.aceshowbiz.com/images/wennpic/charlie-cox-21st-annual-sag-awards-03.jpg'),
(144, 'http://vignette4.wikia.nocookie.net/thementalist/images/9/9e/Deborah-ann-woll-ew-s-comic-con-2014-celebration-in-san-diego_2.jpg/revision/latest?cb=20160619230143'),
(145, 'http://m.aceshowbiz.com/webimages/wennpic/elden-henson-premiere-avengers-age-of-ultron-01.jpg'),
(146, 'http://www1.pictures.zimbio.com/gi/Arrivals+Critics+Choice+Awards+Part+2+VKGPop0CwVXx.jpg'),
(147, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMjI5Mjk1OTg1Nl5BMl5BanBnXkFtZTcwMjYwODcwOA@@._V1_UY317_CR1,0,214,317_AL_.jpg'),
(148, 'https://pmcdeadline2.files.wordpress.com/2016/05/ryan-condal.jpg'),
(149, 'https://www.pixenli.com/images/1493/1493872269023675900.png'),
(150, 'http://www.aceshowbiz.com/images/wennpic/sarah-wayne-callies-68th-annual-golden-globes-after-party-01.jpg'),
(151, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMjI4MzAzMDE3MV5BMl5BanBnXkFtZTgwOTk4NTM0NTE@._V1_UY317_CR0,0,214,317_AL_.jpg'),
(152, 'http://www1.pictures.zimbio.com/gi/tv+Celebrates+New+Series+Braxton+Family+Values+-v77NyZkB3ol.jpg'),
(153, 'http://www.hollywoodreporter.com/sites/default/files/2014/03/juan_jose_campanella.jpg'),
(154, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMjIyMjQ3ODg0N15BMl5BanBnXkFtZTgwMjUwNjM2NzE@._V1_UY317_CR130,0,214,317_AL_.jpg'),
(155, 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/15/Wentworth_Miller_by_Gage_Skidmore.jpg/1200px-Wentworth_Miller_by_Gage_Skidmore.jpg'),
(156, 'https://www.pixenli.com/images/1493/1493872326014321700.png'),
(157, 'http://vignette2.wikia.nocookie.net/arrow-france/images/8/8a/Arthur-Darvill.jpg/revision/latest?cb=20151129112934&path-prefix=fr'),
(158, 'http://vignette2.wikia.nocookie.net/arrow-france/images/0/0c/10009-ciara-renee-attends-ctv-upfront-2015-500x0-2.jpg/revision/latest?cb=20151129111146&path-prefix=fr'),
(159, 'http://vignette2.wikia.nocookie.net/criminalminds/images/c/ca/Jeff_Davis.jpg/revision/latest?cb=20150722162707'),
(160, 'http://vignette1.wikia.nocookie.net/teenwolf/images/8/89/Dylan.jpg/revision/latest?cb=20160318123917&path-prefix=fr'),
(161, 'http://vignette1.wikia.nocookie.net/teenwolf/images/e/e9/Teen_Wolf_Season_3_Tyler_Posey_2013_SDCC.png/revision/latest?cb=20130719234050'),
(162, 'https://s-media-cache-ak0.pinimg.com/originals/2f/0b/20/2f0b2034e9f01ad03753cdbb8bfe9822.jpg'),
(163, 'http://www.vokrug.tv/pic/person/f/e/c/c/fecc9f00857c23e93cd1fdb52b92721e.jpeg'),
(164, 'http://cdn-img.instyle.com/sites/default/files/styles/684xflex/public/images/2014/WRN/062314-shelley-hennig-594.jpg?itok=69-Le2RX'),
(165, 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTExODQ3OTI1MzZeQTJeQWpwZ15BbWU2MDAxMTk5NA@@._V1_UY317_CR24,0,214,317_AL_.jpg'),
(166, 'https://vignette1.wikia.nocookie.net/glee/images/3/37/Dylansprayberry-infobox.jpg/revision/latest?cb=20160512132938'),
(167, 'https://vignette2.wikia.nocookie.net/teenwolf/images/1/1d/JR.jpg/revision/latest?cb=20120320014035');

-- --------------------------------------------------------

--
-- Structure de la table `photo_serie`
--

CREATE TABLE IF NOT EXISTS `photo_serie` (
  `ID_SERIE` int(4) NOT NULL DEFAULT '0',
  `URL` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `photo_serie`
--

INSERT INTO `photo_serie` (`ID_SERIE`, `URL`) VALUES
(0, '/medias/series/backgrounds/the_100_bg.jpg'),
(0, '/medias/series/covers/the_100_cover.jpg'),
(0, '/medias/series/posters/the_100_poster.png'),
(1, '/medias/series/backgrounds/the_walking_dead_bg.jpg'),
(1, '/medias/series/covers/the_walking_dead_cover.jpg'),
(1, '/medias/series/posters/the_walking_dead_poster.png'),
(2, '/medias/series/backgrounds/arrow_bg.jpg'),
(2, '/medias/series/covers/arrow_cover.jpg'),
(2, '/medias/series/posters/arrow_poster.png'),
(3, '/medias/series/backgrounds/the_flash_bg.jpg'),
(3, '/medias/series/covers/the_flash_cover.jpg'),
(3, '/medias/series/posters/the_flash_poster.png'),
(4, '/medias/series/backgrounds/the_magicians_bg.jpg'),
(4, '/medias/series/covers/the_magicians_cover.jpg'),
(4, '/medias/series/posters/the_magicians_poster.png'),
(5, '/medias/series/backgrounds/stranger_things_bg.jpg'),
(5, '/medias/series/covers/stranger_things_cover.jpg'),
(5, '/medias/series/posters/stranger_things_poster.png'),
(6, '/medias/series/backgrounds/the_leftlovers_bg.jpg'),
(6, '/medias/series/covers/the_leftlovers_cover.jpg'),
(6, '/medias/series/posters/the_leftlovers_poster.png'),
(7, '/medias/series/backgrounds/iron_fist_bg.jpg'),
(7, '/medias/series/covers/iron_fist_cover.jpg'),
(7, '/medias/series/posters/iron_fist_poster.png'),
(8, '/medias/series/backgrounds/fear_the_walking_dead_bg.jpg'),
(8, '/medias/series/covers/fear_the_walking_dead_cover.jpg'),
(8, '/medias/series/posters/fear_the_walking_dead_poster.png'),
(9, '/medias/series/backgrounds/westworld_bg.jpg'),
(9, '/medias/series/covers/westworld_cover.jpg'),
(9, '/medias/series/posters/westworld_poster.png'),
(10, '/medias/series/backgrounds/13_reasons_why_bg.jpg'),
(10, '/medias/series/covers/13_reasons_why_cover.jpg'),
(10, '/medias/series/posters/13_reasons_why_poster.png'),
(11, '/medias/series/backgrounds/dragon_ball_super_bg.jpg'),
(11, '/medias/series/covers/dragon_ball_super_cover.jpg'),
(11, '/medias/series/posters/dragon_ball_super_poster.png'),
(12, '/medias/series/backgrounds/game_of_thrones_bg.jpg'),
(12, '/medias/series/covers/game_of_thrones_cover.jpg'),
(12, '/medias/series/posters/game_of_thrones_poster.png'),
(13, '/medias/series/backgrounds/the_lasy_man_on_earth_bg.jpg'),
(13, '/medias/series/covers/the_last_man_on_earth_cover.jpg'),
(13, '/medias/series/posters/the_last_man_on_earth_poster.png'),
(14, '/medias/series/backgrounds/supergirl_bg.jpg'),
(14, '/medias/series/covers/supergirl_cover.jpg'),
(14, '/medias/series/posters/supergirl_poster.png'),
(15, '/medias/series/backgrounds/gotham_bg.jpg'),
(15, '/medias/series/covers/gotham_cover.jpg'),
(15, '/medias/series/posters/gotham_poster.png'),
(16, '/medias/series/backgrounds/orange_is_the_new_black_bg.jpg'),
(16, '/medias/series/covers/orange_is_the_new_black_cover.jpg'),
(16, '/medias/series/posters/orange_is_the_new_black_poster.png'),
(17, '/medias/series/backgrounds/daredevil_bg.jpg'),
(17, '/medias/series/covers/daredevil_cover.jpg'),
(17, '/medias/series/posters/daredevil_poster.png'),
(18, '/medias/series/backgrounds/colony_bg.jpg'),
(18, '/medias/series/covers/colony_cover.jpg'),
(18, '/medias/series/posters/colony_poster.png'),
(19, '/medias/series/backgrounds/dc_legends_of_tomorrow_bg.jpg'),
(19, '/medias/series/covers/dc_legends_of_tomorrow_cover.jpg'),
(19, '/medias/series/posters/dc_legends_of_tomorrow_poster.png'),
(20, '/medias/series/backgrounds/teen_wolf_bg.jpg'),
(20, '/medias/series/covers/teen_wolf_cover.jpg'),
(20, '/medias/series/posters/teen_wolf_poster.png');

-- --------------------------------------------------------

--
-- Structure de la table `produire`
--

CREATE TABLE IF NOT EXISTS `produire` (
  `ID_IND` int(4) NOT NULL DEFAULT '0',
  `ID_SERIE` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `produire`
--

INSERT INTO `produire` (`ID_IND`, `ID_SERIE`) VALUES
(1, 0),
(7, 1),
(24, 2),
(24, 3),
(48, 4),
(50, 5),
(51, 5),
(59, 6),
(65, 6),
(66, 6),
(74, 7),
(8, 8),
(82, 9),
(87, 9),
(88, 10),
(98, 11),
(100, 12),
(101, 12),
(102, 12),
(103, 12),
(112, 13),
(118, 13),
(119, 13),
(24, 14),
(128, 15),
(135, 16),
(141, 17),
(142, 17),
(147, 18),
(148, 18),
(22, 19),
(23, 19),
(24, 19),
(159, 20);

-- --------------------------------------------------------

--
-- Structure de la table `realiser`
--

CREATE TABLE IF NOT EXISTS `realiser` (
  `ID_IND` int(4) NOT NULL DEFAULT '0',
  `ID_EP` int(4) NOT NULL DEFAULT '0',
  `SAISON_EP` int(4) NOT NULL DEFAULT '0',
  `ID_SERIE` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `realiser`
--

INSERT INTO `realiser` (`ID_IND`, `ID_EP`, `SAISON_EP`, `ID_SERIE`) VALUES
(6, 0, 7, 1),
(6, 1, 7, 1),
(6, 2, 7, 1),
(6, 3, 6, 1),
(6, 4, 5, 1),
(6, 5, 4, 1),
(6, 6, 3, 1),
(6, 7, 2, 1),
(6, 8, 1, 1),
(0, 9, 4, 0),
(0, 10, 3, 0),
(0, 11, 2, 0),
(0, 12, 1, 0),
(30, 13, 1, 2),
(30, 18, 1, 3),
(49, 21, 1, 4),
(50, 24, 1, 5),
(51, 24, 1, 5),
(67, 26, 1, 6),
(74, 29, 1, 7),
(81, 30, 1, 8),
(82, 33, 1, 9),
(88, 34, 1, 10),
(99, 35, 1, 11),
(111, 36, 1, 12),
(112, 43, 1, 13),
(30, 46, 1, 14),
(133, 48, 1, 15),
(134, 51, 1, 16),
(140, 51, 1, 16),
(143, 55, 1, 17),
(145, 55, 1, 17),
(153, 57, 1, 18),
(30, 58, 1, 19),
(160, 60, 1, 20),
(161, 60, 1, 20);

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

CREATE TABLE IF NOT EXISTS `reponses` (
  `ID_RPS` int(4) NOT NULL DEFAULT '0',
  `ID_FORUM` int(4) DEFAULT NULL,
  `PSEUDO` varchar(25) DEFAULT NULL,
  `ID_MSG` int(4) DEFAULT NULL,
  `TXT_RPS` varchar(1024) DEFAULT NULL,
  `DATE_RPS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `reponses`
--

INSERT INTO `reponses` (`ID_RPS`, `ID_FORUM`, `PSEUDO`, `ID_MSG`, `TXT_RPS`, `DATE_RPS`) VALUES
(0, 2, 'Joachim', 1, 'fff', '2017-05-05 14:25:10');

-- --------------------------------------------------------

--
-- Structure de la table `series`
--

CREATE TABLE IF NOT EXISTS `series` (
  `ID_SERIE` int(4) NOT NULL DEFAULT '0',
  `TITRE_SERIE` varchar(25) DEFAULT NULL,
  `ANNEE_SERIE` int(11) DEFAULT NULL,
  `PAYS_SERIE` varchar(25) DEFAULT NULL,
  `SUM_SERIE` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `series`
--

INSERT INTO `series` (`ID_SERIE`, `TITRE_SERIE`, `ANNEE_SERIE`, `PAYS_SERIE`, `SUM_SERIE`) VALUES
(0, 'The 100', 2014, 'Etats-Unis', 'Après une apocalypse nucléaire causée par l''Homme lors d''une troisième Guerre Mondiale, les 318 survivants recensés se réfugient dans des stations spatiales et parviennent à y vivre et à se reproduire, atteignant le nombre de 4000. Mais 97 ans plus tard, le vaisseau mère, l''Arche, est en piteux état. Une centaine de jeunes délinquants emprisonnés au fil des années pour des crimes ou des trahisons sont choisis comme cobayes par les autorités pour redescendre sur Terre et tester les chances de survie. Dès leur arrivée, ils découvrent un nouveau monde dangereux mais fascinant...'),
(1, 'The Walking Dead', 2010, 'Etats-Unis', 'Après une apocalypse ayant transformé la quasi-totalité de la population en zombies, un groupe d''hommes et de femmes mené par l''officier Rick Grimes tente de survivre... Ensemble, ils vont devoir tant bien que mal faire face à ce nouveau monde devenu méconnaissable, à travers leur périple dans le Sud profond des États-Unis.'),
(2, 'Arrow', 2012, 'Etats-Unis', 'Les nouvelles aventures de Green Arrow/Oliver Queen, combattant ultra efficace issu de l''univers de DC Comics et surtout archer au talent fou, qui appartient notamment à la Justice League. Disparu en mer avec son père et sa petite amie, il est retrouvé vivant 5 ans plus tard sur une île près des côtes Chinoises. Mais il a changé : il est fort, courageux et déterminé à débarrasser Starling City de ses malfrats...'),
(3, 'The Flash', 2014, 'Etats-Unis', 'Barry Allen est un jeune scientifique qui travaille pour la police de Central City. Enfant, il est témoin du meurtre de sa mère par une entité mystérieuse, il croit aux phénomènes paranormaux, il voit deux éclairs rouge et jaune et cherche le moyen de le prouver pour faire innocenter son père emprisonné.\r\n\r\nPuis, un jour, touché par un éclair provoqué par l''explosion de l''accélérateur de particules dans les laboratoires de Harrison Wells, Barry va sombrer dans le coma pendant neuf mois. À son réveil, il découvre qu''il peut courir à une vitesse surhumaine et peut guérir de façon accélérée. Il va réaliser par la suite qu''il n''est pas le seul à avoir obtenu des facultés surhumaines.'),
(4, 'The Magicians', 2015, 'Etats-Unis', 'Quentin Coldwater, jeune adulte en marge du monde, est depuis son enfance attiré par la magie. Il se réfugie dans la lecture de ses romans préférés Fillory et effectue des séjours en hôpital psychiatrique. Il découvre qu''il est un magicien. Invité à passer des tests d''admission en compagnie de son amie Julia, il est admis à Brakebills, une université protégée du reste du monde qui forme en secret de futurs magiciens.\r\nQuentin va, avec l''aide de ses nouveaux amis Alice, Penny, Margo et Elliot, entrer dans une histoire qui le dépasse. Des forces maléfiques vont s''abattre sur eux. Il pourra sortir de certaines situations grâce à sa connaissance des romans de son enfance. Pendant ce temps, Julia, la meilleure amie de Quentin, qui a échoué aux tests d''admission de Brakebills, retrouve la mémoire qui lui avait été effacée. Elle n''aura de cesse de vouloir apprendre la magie en suivant son propre chemin. Un chemin obscur et dangereux qui pourrait la mener à sa perte...'),
(5, 'Stranger Things', 2016, 'Etats-Unis', 'Un soir de novembre 1983 à Hawkins, dans l''Indiana, le jeune Will Byers, 12 ans, disparaît brusquement sans laisser de traces. Plusieurs personnages vont alors tenter de le retrouver : sa mère Joyce, ses amis menés par Mike Wheeler et guidés par la mystérieuse Eleven, ainsi que le chef de la police Jim Hopper. Parallèlement, la ville est le théâtre de phénomènes surnaturels liés au Laboratoire national d''Hawkins, géré par le département de l''Énergie (DoE) et dont les expériences dans le cadre du projet MKULTRA ne semblent pas étrangères à la disparition de Will.'),
(6, 'The Leftlovers', 2014, 'Etats-Unis', '2 % des êtres humains ont disparu de la surface de la Terre sans la moindre explication, dans une sorte de ravissement. Les habitants de la petite ville de Mapleton vont être confrontés à cette question lorsque nombre de leurs voisins, amis et amants s''évanouissent dans la nature le même jour d''automne.\r\n\r\nTrois ans plus tard, la vie a repris son cours dans la bourgade dépeuplée, mais rien n''est plus comme avant. Personne n''a oublié ce qu''il s''est passé ni ceux qui ont disparu. À l''approche des cérémonies de commémoration, le shérif Kevin Garvey est en état d''alerte maximale : des affrontements dangereux se préparent entre la population et un groupuscule aux revendications mystérieuses, comparable à une secte.'),
(7, 'Iron Fist', 2017, 'Etats-Unis', 'Le milliardaire disparu, Danny Rand, est de retour à New York, après quinze ans d''absence, pour reprendre l''entreprise familiale. Mais pour y parvenir, il devra affronter la corruption et le crime qui gangrène ses proches. Pour cela, il pourra compter sur sa connaissance des arts martiaux et sa capacité à utiliser le Poing d''acier, une technique étudiée auprès des moines de K''un L''un. Il aura dans son combat de précieuses alliées telles que Colleen Wing et Claire Temple.'),
(8, 'Fear The Walking Dead', 2015, 'Etats-Unis', 'L''histoire se déroule au tout début de l''épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta.\r\n\r\nMadison est conseillère d’orientation dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue. Ils n’acceptent pas vraiment le nouveau compagnon de leur mère, Travis, professeur dans le même lycée et père divorcé d’un jeune adolescent, Chris. Autour de cette famille recomposée qui a du mal à recoller les morceaux, d’étranges comportements font leur apparition et une épidémie arrive.'),
(9, 'Westworld', 2016, 'Etats-Unis', 'A Westworld, un parc d''attractions dernier cri, les visiteurs paient des fortunes pour revivre le frisson de la conquête de l''Ouest. Dolores, Teddy et bien d''autres sont des androïdes à apparence humaine créés pour donner l''illusion et offrir du dépaysement aux clients. Pour ces derniers, Westworld est l''occasion de laisser libre-cours à leurs fantasmes. Cet univers bien huilé est mis en péril lorsqu''à la suite d''une mise à jour, quelques robots comment à adopter des comportements imprévisibles, voire erratiques. En coulisses, l''équipe, qui tire les ficelles de ce monde alternatif, s''inquiète de ces incidents de plus en plus nombreux. Les enjeux du programme Westworld étant énormes, la Direction ne peut se permettre une mauvaise publicité qui ferait fuir ses clients. Que se passe-t-il réellement avec les androïdes ré-encodés ?'),
(10, '13 Reasons Why', 2017, 'Etats-Unis', 'Clay Jensen, un adolescent de dix-sept ans, reçoit une boîte contenant sept cassettes de la part d''une de ses amies, Hannah Baker, qui a mis fin à ses jours quelques semaines plus tôt.\r\n\r\nCes sept cassettes, composées de deux faces à écouter, contiennent chacune des raisons qui ont poussé Hannah a prendre cette décision. Chaque face correspond également à une personne qu''elle considère comme responsable de son acte. Perturbé par la réception de ces cassettes, Clay va vite découvrir au fur et à mesure des révélations d''Hannah que ses camarades ne sont pas vraiment ce qu''ils laissent paraître.'),
(11, 'Dragon Ball Super', 2015, 'Japon', 'Au lendemain de son féroce combat avec Majin Buu, Goku tente de maintenir la paix sur Terre. L''arrivée de nombreux extra-terrestres l''oblige à se surpasser une nouvelle fois et s''engager dans une terrible bataille qui va l''amener dans une nouvelle dimension, au-delà des possibilités de l’imaginaire !'),
(12, 'Game of Thrones', 2011, 'Etats-Unis', 'Sur le continent de Westeros, le roi Robert Baratheon gouverne le Royaume des Sept Couronnes depuis plus de dix-sept ans, à la suite de la rébellion qu''il a menée contre le « roi fou » Aerys II Targaryen. Jon Arryn, époux de la sœur de Lady Catelyn Stark, Lady Arryn, son guide et principal conseiller, vient de décéder, et le roi part alors dans le nord du royaume demander à son vieil ami Eddard « Ned » Stark de remplacer leur regretté mentor au poste de Main du roi. Ned, seigneur suzerain du nord depuis Winterfell et de la maison Stark, est peu désireux de quitter ses terres. Mais il accepte à contre-cœur de partir pour la capitale Port-Réal avec ses deux filles, Sansa et Arya. Juste avant leur départ pour le sud, Bran, l''un des jeunes fils d''Eddard, est poussé de l''une des tours de Winterfell après avoir été témoin de la liaison incestueuse de la reine Cersei Baratheon et son frère jumeau, Jaime Lannister. Leur frère, Tyrion Lannister, surnommé « le gnome », est alors accusé du crime par Lady Catelyn Stark.\n'),
(13, 'The Last Man on Earth', 2015, 'Etats-Unis', 'Après avoir parcouru les États-Unis pour trouver des survivants au virus qui a décimé la Terre, Phil Miller rentre à Tucson en pensant qu''il est le dernier humain vivant sur Terre. Après plusieurs mois d''une vie chaotique passée à boire et à s''occuper comme il peut, Phil décide de se suicider. Il tombe alors sur Carol Pilbasian, la dernière femme sur Terre. Seul problème, les deux derniers survivants ont des styles de vie post-apocalyptique très différents et l''entente entre ces deux derniers humains est compliquée.'),
(14, 'Supergirl', 2015, 'Etats-Unis', 'Kara Zor-El, cousine de Kal-El, est arrivée sur Terre, mais avec 24 ans de retard. Elle avait pour mission de protéger son cousin, mais celui-ci est devenu entre temps un super héros respecté de tous. La jeune fille est donc recueillie par une famille d''adoption, la famille Danvers. Elle change donc son nom pour Kara Danvers. Grâce à sa famille adoptive, la jeune fille apprend à maîtriser ses super-pouvoirs, mais surtout à les cacher du grand public.\r\n\r\nUne fois adulte, âgée de 24 ans, elle travaille comme assistante pour Cat Grant au sein du groupe de média CatCo, dans la ville de National City, située sur la côte Ouest des États-Unis. Une catastrophe inattendue va l''obliger à se montrer telle qu''elle est vraiment aux yeux de tous. Très vite, les habitants de la ville ayant vu ses incroyables capacités la surnomment Supergirl.'),
(15, 'Gotham', 2014, 'Etats-Unis', 'Tout le monde connaît le Commissaire Gordon, valeureux adversaire des plus dangereux criminels, un homme dont la réputation rime avec "loi" et "ordre". Mais que sait-on de son histoire ? De son ascension dans une institution corrompue, qui gangrène une ville comme Gotham, terrain fertile des méchants les plus emblématiques ? Comment sont nées ces figures du crime, ces personnages hors du commun que sont Catwoman, le Pingouin, l''Homme-mystère, Double-Face et le Joker ?'),
(16, 'Orange is The New Black', 2013, 'Etats-Unis', 'Entre les murs de la prison pour femmes de Litchfield, la vie n’est pas rose tous les jours. Rattrapées par le passé, des détenues venues d’horizons divers cohabitent dans cette société en vase clos. Si coups bas et tensions sont monnaie courante, l’amour, la solidarité mais surtout l’humour subsistent dans le quotidien des inoubliables prisonnières.'),
(17, 'Daredevil', 2015, 'Etats-Unis', 'Aveugle depuis ses neuf ans à la suite d''un accident, Matt Murdock possède des sens qui bénéficient d''une acuité extraordinaire. Avocat le jour, il devient le Super-heros Daredevil lorsque la nuit tombe, afin de lutter contre l’injustice à New York, plus particulièrement dans le quartier de Hell''s Kitchen, corrompu par la criminalité depuis sa reconstruction après l''attaque des Chitauris lors des événements du film Avengers.'),
(18, 'Colony', 2016, 'Etats-Unis', 'Dans un futur proche, les extraterrestes ont colonisé la Terre. Et pourtant, la plupart des humains ne savent pas à quoi ces aliens ressemblent, les personnes chargées de faire régner l''ordre étant des collaborateurs. A Los Angeles, les Bowman vivent comme beaucoup d''autres sous une menace constante. Lorsque le passé de Will, le père de la tribu, remonte à la surface, le gouverneur du secteur offre à cet ancien du FBI de mettre ses compétences à profit pour étouffer la progression de la résistance. Alléchés par la possibilité de retrouver leur fils cadet disparu depuis le jour de l''occupation, Will et son épouse Katie vont devoir prendre la plus difficile décision de leur existence. Choisiront-ils de collaborer... ou de résister ?'),
(19, 'DC''s Legends of Tomorrow', 2016, 'Etats-Unis', 'Rip Hunter, un agent faisant anciennement partie de la confédération des maîtres du temps désobéit à cette dernière en volant un vaisseau (nommé Waverider) pouvant voyager à travers le temps dans le but de recruter un groupe de Super-heros et de super-vilains capable d''affronter une menace planétaire : le criminel Vandal Savage et son armée de super soldats ayant conquis et soumis le futur. Ils ont pris le contrôle de toutes les infrastructures et ont fait des humains des esclaves. Ce groupe est initialement composé de Captain Cold, Heat Wave, Atom, Hawkgirl, Hawkman, White Canary et Firestorm.'),
(20, 'Teen Wolf', 2011, 'Etats-Unis', 'Une nuit, Scott McCall, un jeune lycéen joueur de lacrosse au lycée de Beacon Hills en Californie, se promène dans les bois à la recherche d''un cadavre avec son meilleur ami Stiles et se fait attaquer par une énorme bête sauvage. Il s''en sort avec une morsure à l''abdomen, mais il découvre bientôt qu''il est devenu un loup-garou. Dès lors, il doit trouver un équilibre entre sa nouvelle identité et les nombreux dangers qu''elle présente pour sa vie d''adolescent. Tout au long des saisons, il s''efforce de protéger ses proches ainsi que d''en apprendre davantage sur sa condition de loup-garou et des mystères qui l''entourent.');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `PSEUDO` varchar(25) NOT NULL DEFAULT '',
  `PWD` varchar(100) DEFAULT NULL,
  `DATE_INSC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SEXE` char(1) DEFAULT NULL,
  `ADR_MAIL` varchar(200) NOT NULL,
  `DATE_ANNIV` date DEFAULT NULL,
  `AVATAR_ID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`PSEUDO`, `PWD`, `DATE_INSC`, `SEXE`, `ADR_MAIL`, `DATE_ANNIV`, `AVATAR_ID`) VALUES
('Axelle', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2017-05-03 00:28:29', 'F', 'axelle@gmail.com', '0000-00-00', '6eaa4ea12a622a2bf747bd687e1c2bd8092655c7'),
('Caroline', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2017-05-10 15:36:40', 'F', 'caro@gmail.com', '0000-00-00', '798bc14e94987b3ae311240dcfe1ecebce63ac13'),
('Cindy', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '0000-00-00 00:00:00', 'F', 'cindy@gmail.com', '2017-05-10', '6ac07aa166b6ec33b2cdcdcc362839997dde1b79'),
('Elodie', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '0000-00-00 00:00:00', 'F', 'elodie@gmail.com', '0000-00-00', '011bdec6a21aac05dd31ad961c8e1d1d18e2c444'),
('Ema', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2017-05-10 15:33:17', 'F', 'ema@gmail.com', '0000-00-00', '798bc14e94987b3ae311240dcfe1ecebce63ac13'),
('Joachim', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2017-04-21 06:40:20', 'M', 'joachim.laviolette@gmail.com', '1996-04-07', '88074f9257b269d655fa1c5fcd2a7122ff4cb490'),
('Jordan', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2017-05-10 15:35:29', 'M', 'jordan@gmail.com', '0000-00-00', '798bc14e94987b3ae311240dcfe1ecebce63ac13'),
('Julien', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2017-05-10 15:29:21', 'M', 'julien@gmail.com', '0000-00-00', '798bc14e94987b3ae311240dcfe1ecebce63ac13'),
('Kevin', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '0000-00-00 00:00:00', 'M', 'kevin@gmail.com', '0000-00-00', 'e043899daa0c7add37bc99792b2c045d6abbc6dc'),
('Magilan', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '0000-00-00 00:00:00', 'M', 'magilan@gmail.com', '0000-00-00', 'c9e08dbee6f29667d4eb6a0446d75792d72b9caa'),
('Tyler', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2017-05-10 15:34:19', 'M', 'tyler@gmail.com', '0000-00-00', '798bc14e94987b3ae311240dcfe1ecebce63ac13'),
('Ulysse', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2017-05-10 15:21:28', 'M', 'ulysse@gmail.com', '0000-00-00', '798bc14e94987b3ae311240dcfe1ecebce63ac13'),
('Vincent', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '0000-00-00 00:00:00', 'M', 'vincent@gmail.com', '0000-00-00', ''),
('Yannick', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2017-05-05 05:29:14', 'M', 'yannick@gmail.com', '2017-05-07', '9c8b5aa1eb750d6df8081250d665496c37834715');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `creer`
--
ALTER TABLE `creer`
  ADD PRIMARY KEY (`ID_IND`,`ID_SERIE`),
  ADD KEY `FK_CREER_SERIES` (`ID_SERIE`);

--
-- Index pour la table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`ID_EP`,`SAISON_EP`,`ID_SERIE`),
  ADD KEY `FK_EPISODE_SERIES` (`ID_SERIE`);


--
-- Index pour la table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`NOM_GENRE`);

--
-- Index pour la table `etre_du_genre`
--
ALTER TABLE `etre_du_genre`
  ADD PRIMARY KEY (`NOM_GENRE`,`ID_SERIE`),
    ADD KEY `FK_EDG_GENRES` (`NOM_GENRE`),
  ADD KEY `FK_EDG_SERIES` (`ID_SERIE`);

--
-- Index pour la table `individus`
--
ALTER TABLE `individus`
  ADD PRIMARY KEY (`ID_IND`);

--
-- Index pour la table `jouer`
--
ALTER TABLE `jouer`
  ADD PRIMARY KEY (`ID_IND`,`ID_EP`,`SAISON_EP`,`ID_SERIE`),
  ADD KEY `FK_JOUER_EPISODE` (`ID_EP`,`SAISON_EP`,`ID_SERIE`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`ID_MSG`),
  ADD KEY `FK_MSG_UTILI` (`PSEUDO`),
  ADD KEY `FK_MSG_SERIE` (`ID_SERIE`);

--
-- Index pour la table `noter_episodes`
--
ALTER TABLE `noter_episodes`
  ADD PRIMARY KEY (`PSEUDO`,`ID_EP`,`SAISON_EP`,`ID_SERIE`),
  ADD KEY `FK_NE_EP` (`ID_EP`,`SAISON_EP`,`ID_SERIE`);

--
-- Index pour la table `noter_series`
--
ALTER TABLE `noter_series`
  ADD PRIMARY KEY (`PSEUDO`,`ID_SERIE`),
  ADD KEY `FK_NS_SERIE` (`ID_SERIE`);

--
-- Index pour la table `photo_individu`
--
ALTER TABLE `photo_individu`
  ADD PRIMARY KEY (`ID_IND`,`URL`);

--
-- Index pour la table `photo_serie`
--
ALTER TABLE `photo_serie`
  ADD PRIMARY KEY (`ID_SERIE`,`URL`);

--
-- Index pour la table `produire`
--
ALTER TABLE `produire`
  ADD PRIMARY KEY (`ID_IND`,`ID_SERIE`),
  ADD KEY `FK_PRODUIRE_SERIES` (`ID_SERIE`);

--
-- Index pour la table `realiser`
--
ALTER TABLE `realiser`
  ADD PRIMARY KEY (`ID_IND`,`ID_EP`,`SAISON_EP`,`ID_SERIE`),
  ADD KEY `FK_REALISER_EPISODE` (`ID_EP`,`SAISON_EP`,`ID_SERIE`);

--
-- Index pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`ID_RPS`),
  ADD KEY `FK_RPS_UTILI` (`PSEUDO`),
  ADD KEY `FK_RPS_SERIE` (`ID_MSG`);

--
-- Index pour la table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`ID_SERIE`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`PSEUDO`),
  ADD UNIQUE KEY `UNIQUE_MAIL` (`ADR_MAIL`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `ID_MSG` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `creer`
--
ALTER TABLE `creer`
  ADD CONSTRAINT `FK_CREER_INDIVIDUS` FOREIGN KEY (`ID_IND`) REFERENCES `individus` (`ID_IND`),
  ADD CONSTRAINT `FK_CREER_SERIES` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID_SERIE`);

--
-- Contraintes pour la table `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `FK_EPISODE_SERIES` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID_SERIE`);

--
-- Contraintes pour la table `etre_du_genre`
--
ALTER TABLE `etre_du_genre`
  ADD CONSTRAINT `FK_EDG_GENRES` FOREIGN KEY (`NOM_GENRE`) REFERENCES `genres` (`NOM_GENRE`),
  ADD CONSTRAINT `FK_EDG_SERIES` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID_SERIE`);

--
-- Contraintes pour la table `jouer`
--
ALTER TABLE `jouer`
  ADD CONSTRAINT `FK_JOUER_EPISODE` FOREIGN KEY (`ID_EP`, `SAISON_EP`, `ID_SERIE`) REFERENCES `episodes` (`ID_EP`, `SAISON_EP`, `ID_SERIE`),
  ADD CONSTRAINT `FK_JOUER_INDIVIDUS` FOREIGN KEY (`ID_IND`) REFERENCES `individus` (`ID_IND`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_MSG_SERIE` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID_SERIE`),
  ADD CONSTRAINT `FK_MSG_UTILI` FOREIGN KEY (`PSEUDO`) REFERENCES `utilisateurs` (`PSEUDO`);

--
-- Contraintes pour la table `noter_episodes`
--
ALTER TABLE `noter_episodes`
  ADD CONSTRAINT `FK_NE_EP` FOREIGN KEY (`ID_EP`, `SAISON_EP`, `ID_SERIE`) REFERENCES `episodes` (`ID_EP`, `SAISON_EP`, `ID_SERIE`),
  ADD CONSTRAINT `FK_NE_UTILI` FOREIGN KEY (`PSEUDO`) REFERENCES `utilisateurs` (`PSEUDO`);

--
-- Contraintes pour la table `noter_series`
--
ALTER TABLE `noter_series`
  ADD CONSTRAINT `FK_NS_SERIE` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID_SERIE`),
  ADD CONSTRAINT `FK_NS_UTILI` FOREIGN KEY (`PSEUDO`) REFERENCES `utilisateurs` (`PSEUDO`);

--
-- Contraintes pour la table `photo_individu`
--
ALTER TABLE `photo_individu`
  ADD CONSTRAINT `FK_PHOTO_INDIVIDU` FOREIGN KEY (`ID_IND`) REFERENCES `individus` (`ID_IND`);

--
-- Contraintes pour la table `photo_serie`
--
ALTER TABLE `photo_serie`
  ADD CONSTRAINT `FK_PHOTO_SERIE` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID_SERIE`);

--
-- Contraintes pour la table `produire`
--
ALTER TABLE `produire`
  ADD CONSTRAINT `FK_PRODUIRE_INDIVIDUS` FOREIGN KEY (`ID_IND`) REFERENCES `individus` (`ID_IND`),
  ADD CONSTRAINT `FK_PRODUIRE_SERIES` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID_SERIE`);

--
-- Contraintes pour la table `realiser`
--
ALTER TABLE `realiser`
  ADD CONSTRAINT `FK_REALISER_EPISODE` FOREIGN KEY (`ID_EP`, `SAISON_EP`, `ID_SERIE`) REFERENCES `episodes` (`ID_EP`, `SAISON_EP`, `ID_SERIE`),
  ADD CONSTRAINT `FK_REALISER_INDIVIDUS` FOREIGN KEY (`ID_IND`) REFERENCES `individus` (`ID_IND`);

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `FK_RPS_SERIE` FOREIGN KEY (`ID_MSG`) REFERENCES `messages` (`ID_MSG`),
  ADD CONSTRAINT `FK_RPS_UTILI` FOREIGN KEY (`PSEUDO`) REFERENCES `utilisateurs` (`PSEUDO`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
