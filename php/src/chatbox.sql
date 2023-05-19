-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.25 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.5045
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for ajaxdb
CREATE DATABASE IF NOT EXISTS `ajaxdb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ajaxdb`;

-- Dumping structure for table ajaxdb.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_person_name` varchar(100) NOT NULL,
  `chat_value` varchar(100) NOT NULL,
  `chat_time` time DEFAULT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ajaxdb.chat: ~0 rows (approximately)
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;

-- Dumping structure for table ajaxdb.country
CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(100) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table ajaxdb.country: ~3 rows (approximately)
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
REPLACE INTO `country` (`country_id`, `country_name`) VALUES
	(1, 'Aargau'),
	(2, 'Appenzell Innerrhoden'),
	(3, 'Appenzell Ausserrhoden'),
  (4, 'Bern'),
  (5, 'Basel-Landschaft'),
  (6, 'Basel-Stadt'),
  (7, 'Freibourg'),
  (8, 'Genf'),
  (9, 'Glarus'),
  (10, 'Graubünden'),
  (11, 'Jura'),
  (12, 'Luzern'),
  (13, 'Neuenburg'),
  (14, 'Nidwalden'),
  (15, 'Obwalden'),
  (16, 'St. Gallen'),
  (17, 'Schaffhausen'),
  (18, 'Solothurn'),
  (19, 'Schwyz'),
  (20, 'Thurgau'),
  (21, 'Tessin'),
  (22, 'Uri'),
  (23, 'Waadt'),
  (24, 'Wallis'),
  (25, 'Zug');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;

-- Dumping structure for table ajaxdb.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(300) NOT NULL,
  `user_country` varchar(100) NOT NULL,
  `user_status` varchar(100) NOT NULL DEFAULT '0',
  `user_color` varchar(100) NOT NULL DEFAULT '#00FF00',
  `active_chat` int(11) NULL DEFAULT NULL,
  `availabel_chats`TEXT NULL DEFAULT NULL,
  `requests` TEXT NULL DEFAULT NULL,
  `N_public`BIGINT NULL DEFAULT NULL,
  `pw_reset`TEXT NOT NULL,
  `verified` BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UX_Constraint` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ajaxdb.user: ~0 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
CREATE TABLE IF NOT EXISTS`tokens` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `provider` varchar(255) NOT NULL,
 `provider_value` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS`groupchats` (
  `groupchat_id` INT NOT NULL AUTO_INCREMENT, 
  `groupchat_name` VARCHAR(100) NOT NULL , 
  `groupchat_Npublic` TEXT DEFAULT NULL , 
  `groupchat_users` TEXT DEFAULT NULL , 
  `groupchat_creator` int(11) NOT NULL , 
  PRIMARY KEY (`groupchat_id`)
  ) ENGINE = InnoDB DEFAULT CHARSET=latin1; 
