-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 13, 2024 at 05:56 PM
-- Server version: 8.2.0
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
-- Table structure for table `failed_agent_upload`
--

DROP TABLE IF EXISTS `failed_agent_upload`;
CREATE TABLE IF NOT EXISTS `failed_agent_upload` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_number` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `failed_agent_upload`
--

INSERT INTO `failed_agent_upload` (`id`, `account_number`, `created_at`) VALUES
(1, '8036911219', '2024-02-13 17:16:22'),
(2, '9120948709', '2024-02-13 17:16:23'),
(3, '8036220094', '2024-02-13 17:16:37'),
(4, '7030509067', '2024-02-13 17:16:47'),
(5, '8027687500', '2024-02-13 17:17:11'),
(6, '9021110349', '2024-02-13 17:17:12'),
(7, '8036911219', '2024-02-13 17:20:48'),
(8, '9120948709', '2024-02-13 17:20:49'),
(9, '8036220094', '2024-02-13 17:21:02'),
(10, '7030509067', '2024-02-13 17:21:11'),
(11, '8027687500', '2024-02-13 17:21:33'),
(12, '9021110349', '2024-02-13 17:21:33');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
