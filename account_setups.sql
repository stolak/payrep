-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 12, 2024 at 03:54 PM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payrep`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_setups`
--

DROP TABLE IF EXISTS `account_setups`;
CREATE TABLE IF NOT EXISTS `account_setups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `particular` varchar(100) NOT NULL,
  `account_id` int DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_setups`
--

INSERT INTO `account_setups` (`id`, `particular`, `account_id`, `status`) VALUES
(1, 'Loan Interest', 5, 0),
(2, 'Registration Income', 13, 0),
(3, 'Processing fees', 14, 0),
(4, 'Defaulter', 15, 0),
(5, '9psb', 11, 1),
(6, 'Agent commission', 1, 1),
(7, 'Bonus', 6, 1),
(8, 'Aggregator commission', 5, 1),
(9, 'Aggregator referral', 12, 1),
(10, 'Company commission', 80, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
