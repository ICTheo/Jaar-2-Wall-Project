-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for wall
CREATE DATABASE IF NOT EXISTS `wall` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `wall`;


-- Dumping structure for table wall.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `datum` varchar(50) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `gebruiker_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- Dumping data for table wall.comment: ~35 rows (approximately)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` (`id`, `content`, `datum`, `post_id`, `gebruiker_id`, `parent_id`, `status`) VALUES
	(3, 'IT HAD TO BE DONE', '1415406329', 1, 1, NULL, '1'),
	(4, 'BUT ALL MY POSTS...!!', '1415406440', 1, 2, NULL, '1'),
	(5, 'IT WAS WORTH THE SACRIFICE', '1415406634', 1, 1, NULL, '1'),
	(6, 'FUCK THEM ID NUMBERS WE ARE WHO WE ARE!!!', '1415406776', 1, 2, NULL, '1'),
	(7, 'BUT BUT... IT WAS A MESS', '1415407052', 1, 1, NULL, '1'),
	(8, 'IT IS SUPPOSED TO BE MESSY!!', '1415407417', 1, 2, NULL, '1'),
	(9, 'MAYBE YOURS IS SUPPOSED TO BE MESSY!!!!!', '1415407540', 1, 1, NULL, '1'),
	(10, 'Waii!!!', '1415408122', 2, 2, NULL, '0'),
	(11, 'WHYNAUT??', '1415408381', 2, 1, NULL, '1'),
	(12, 'Because?', '1415409530', 2, 2, NULL, '1'),
	(13, 'I AM MESSY!!!', '1415409975', 1, 2, NULL, '1'),
	(14, 'THEN CLEAN YOUR STUFF UP!!!!', '1415411084', 1, 1, NULL, '1'),
	(15, 'Becaauuuuuuse... because. :3', '1415411102', 2, 1, NULL, '1'),
	(16, 'but.. but..', '1415411267', 2, 2, NULL, '1'),
	(17, 'No buts. >:l', '1415412538', 2, 1, NULL, '1'),
	(26, 'Halloooo!', '1415571785', 7, 2, NULL, '1'),
	(27, 'HELLO', NULL, NULL, 1, 26, '1'),
	(30, 'Hii', '1416162066', NULL, 1, NULL, '1'),
	(31, 'Hiii', '1416162124', NULL, 1, NULL, '1'),
	(32, 'Hiii', '1416162139', NULL, 1, 0, '1'),
	(33, 'Hii', '1416162145', NULL, 1, 0, '1'),
	(34, 'Hiiiii\r\n', '1416162180', NULL, 1, 26, '1'),
	(35, 'Derp', '1416162307', NULL, 2, 26, '1'),
	(36, 'Waar moet ik typen om een normale comment te plaatsen!!!????', '1416162857', 1, 2, NULL, '1'),
	(37, 'Ohhhh nvm al gevonden.', '1416162875', NULL, 2, 36, '1'),
	(38, 'jxf\r\n\r\n\r\n\r\n\r\n', '1416823364', 9, 1, NULL, '1'),
	(39, NULL, '1416825487', NULL, 1, 10, '1'),
	(40, NULL, '1416828185', NULL, 1, 38, '1'),
	(41, 'Hellow', '1416828249', NULL, 1, 38, '1'),
	(42, 'Hii', NULL, NULL, 1, NULL, NULL),
	(43, 'Hiii', NULL, NULL, 1, NULL, NULL),
	(44, '3q2f32wf', NULL, NULL, 1, NULL, NULL),
	(45, 'Nou heb ff lekker gegeten Marv Marv', '1416853363', 10, 1, NULL, '1'),
	(46, 'Nou nou!!!', '1416856633', 10, 2, NULL, '1'),
	(47, 'Jaa!', '1416862657', NULL, 1, 46, '1');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;


-- Dumping structure for table wall.gebruiker
CREATE TABLE IF NOT EXISTS `gebruiker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `paswoord` varchar(15) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `groep_id` int(11) DEFAULT NULL,
  `persoon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table wall.gebruiker: ~2 rows (approximately)
/*!40000 ALTER TABLE `gebruiker` DISABLE KEYS */;
INSERT INTO `gebruiker` (`id`, `email`, `paswoord`, `status`, `groep_id`, `persoon_id`) VALUES
	(1, 'The@the.the', 'pii', '1', 1, 1),
	(2, 'derp', '1234', '1', 2, 2);
/*!40000 ALTER TABLE `gebruiker` ENABLE KEYS */;


-- Dumping structure for table wall.groep
CREATE TABLE IF NOT EXISTS `groep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table wall.groep: ~2 rows (approximately)
/*!40000 ALTER TABLE `groep` DISABLE KEYS */;
INSERT INTO `groep` (`id`, `type`) VALUES
	(1, 'admin'),
	(2, 'user');
/*!40000 ALTER TABLE `groep` ENABLE KEYS */;


-- Dumping structure for table wall.like
CREATE TABLE IF NOT EXISTS `like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gebruiker_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `datum` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- Dumping data for table wall.like: ~12 rows (approximately)
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
INSERT INTO `like` (`id`, `gebruiker_id`, `type_id`, `type`, `datum`, `status`) VALUES
	(36, 1, 7, 'post', 1416237440, '0'),
	(37, 1, 26, 'comment', 1416237734, '0'),
	(38, 1, 27, 'comment', 1416237868, '1'),
	(39, 1, 35, 'comment', 1416237885, '1'),
	(40, 1, 2, 'post', 1416799833, '0'),
	(41, 1, 10, 'comment', 1416800778, '1'),
	(42, 1, 9, 'post', 1416823342, '1'),
	(43, 1, 38, 'comment', 1416850450, '1'),
	(44, 1, 3, 'comment', 1416852464, '1'),
	(45, 1, 37, 'comment', 1416854400, '1'),
	(46, 1, 45, 'comment', 1416868392, '1'),
	(47, 1, 40, 'comment', 1416868400, '1');
/*!40000 ALTER TABLE `like` ENABLE KEYS */;


-- Dumping structure for table wall.persoon
CREATE TABLE IF NOT EXISTS `persoon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(35) DEFAULT NULL,
  `achternaam` varchar(35) DEFAULT NULL,
  `geslacht` varchar(50) DEFAULT NULL,
  `geboortedatum` int(11) DEFAULT NULL,
  `adres` varchar(500) DEFAULT NULL,
  `postcode` varchar(8) DEFAULT NULL,
  `woonplaats` varchar(50) DEFAULT NULL,
  `telefoon` varchar(12) DEFAULT NULL,
  `mobiel` varchar(12) DEFAULT NULL,
  `avatar` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table wall.persoon: ~2 rows (approximately)
/*!40000 ALTER TABLE `persoon` DISABLE KEYS */;
INSERT INTO `persoon` (`id`, `voornaam`, `achternaam`, `geslacht`, `geboortedatum`, `adres`, `postcode`, `woonplaats`, `telefoon`, `mobiel`, `avatar`) VALUES
	(1, 'Theo', 'Krommenhoek', 'Man', 787539600, 'Hoefsel 2', '4454DD', 'Hendrik Ido Ambacht', '078-68213442', '06291338927', 'Dark_Pit_Icon.jpg'),
	(2, 'Marv`', ' ', 'Man', 683043720, 'Hell', '6666 ty', 'Â¬_Â¬', '666', '666', 'Marv2.gif');
/*!40000 ALTER TABLE `persoon` ENABLE KEYS */;


-- Dumping structure for table wall.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(1000) NOT NULL,
  `datum` int(11) NOT NULL,
  `gebruiker_id` int(11) NOT NULL DEFAULT '0',
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table wall.post: ~6 rows (approximately)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`id`, `content`, `datum`, `gebruiker_id`, `status`) VALUES
	(1, 'WAIII!!!', 1415406241, 2, '1'),
	(2, 'Pink... pink everywhere', 1415407576, 1, '1'),
	(7, 'Hii', 1415571525, 1, '1'),
	(8, 'Halp', 1416823294, 1, '1'),
	(9, 'boe', 1416823339, 1, '1'),
	(10, 'DOEI!!!! GA ETEN!!!', 1416850710, 2, '1');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
