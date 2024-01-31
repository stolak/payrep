-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 09, 2022 at 08:54 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loan`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_charts`
--

DROP TABLE IF EXISTS `account_charts`;
CREATE TABLE IF NOT EXISTS `account_charts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `headid` int(11) NOT NULL,
  `subheadid` int(11) NOT NULL,
  `accountno` varchar(50) NOT NULL,
  `accountdescription` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `rank` double NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_charts`
--

INSERT INTO `account_charts` (`id`, `groupid`, `headid`, `subheadid`, `accountno`, `accountdescription`, `status`, `rank`) VALUES
(1, 1, 1, 3, '0', 'Access Bank', 1, 0),
(11, 1, 1, 2, '0', 'Usman Ahmed', 1, 0),
(5, 5, 7, 4, '0', 'Loan Interest', 1, 0),
(6, 4, 6, 5, '0', 'Office Expense', 1, 0),
(7, 1, 1, 3, '0', 'First Bank', 1, 0),
(10, 1, 1, 2, '0', 'Olawole Akinbobola', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_groups`
--

DROP TABLE IF EXISTS `account_groups`;
CREATE TABLE IF NOT EXISTS `account_groups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `accountgroup` varchar(50) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_groups`
--

INSERT INTO `account_groups` (`id`, `accountgroup`) VALUES
(1, 'Asset'),
(2, 'Liabilty'),
(3, 'Equity'),
(4, 'Expense'),
(5, 'Income');

-- --------------------------------------------------------

--
-- Table structure for table `account_heads`
--

DROP TABLE IF EXISTS `account_heads`;
CREATE TABLE IF NOT EXISTS `account_heads` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `accoundheadcode` varchar(20) NOT NULL,
  `accounthead` varchar(100) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_heads`
--

INSERT INTO `account_heads` (`id`, `groupid`, `accoundheadcode`, `accounthead`) VALUES
(1, 1, '11', 'Current Asset'),
(2, 1, '12', 'Fixed Asset'),
(3, 2, '21', 'Current Liability'),
(4, 2, '22', 'Long Term Liability'),
(5, 3, '31', 'Capital'),
(6, 4, '41', 'Expense'),
(7, 5, '51', 'Income');

-- --------------------------------------------------------

--
-- Table structure for table `account_setups`
--

DROP TABLE IF EXISTS `account_setups`;
CREATE TABLE IF NOT EXISTS `account_setups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `particular` varchar(100) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_setups`
--

INSERT INTO `account_setups` (`id`, `particular`, `account_id`) VALUES
(1, 'Loan Interest', 5),
(2, 'Registration Income', 5),
(3, 'Processing fees', 5);

-- --------------------------------------------------------

--
-- Table structure for table `account_subheads`
--

DROP TABLE IF EXISTS `account_subheads`;
CREATE TABLE IF NOT EXISTS `account_subheads` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `headid` int(11) NOT NULL,
  `subheadcode` varchar(50) NOT NULL,
  `subhead` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `rank` double NOT NULL DEFAULT '0',
  `afs` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_subheads`
--

INSERT INTO `account_subheads` (`id`, `groupid`, `headid`, `subheadcode`, `subhead`, `status`, `rank`, `afs`) VALUES
(1, 1, 1, '0', 'Cash', 1, 0, 0),
(2, 1, 1, '0', 'Customer Receivable', 1, 0, 0),
(3, 1, 1, '0', 'Banks', 1, 0, 0),
(4, 5, 7, '0', 'Loan Interest', 1, 0, 0),
(5, 4, 6, '0', 'Office Expense', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_transactions`
--

DROP TABLE IF EXISTS `account_transactions`;
CREATE TABLE IF NOT EXISTS `account_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `headid` int(11) NOT NULL,
  `subheadid` int(11) NOT NULL,
  `accountid` int(11) NOT NULL,
  `accountcode` varchar(200) NOT NULL,
  `debit` varchar(200) NOT NULL DEFAULT '0',
  `credit` varchar(200) NOT NULL DEFAULT '0',
  `remarks` text NOT NULL,
  `ref` varchar(200) NOT NULL,
  `manual_ref` varchar(200) DEFAULT NULL,
  `transdate` varchar(200) NOT NULL,
  `postby` varchar(100) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_trial` tinyint(4) NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_transactions`
--

INSERT INTO `account_transactions` (`id`, `groupid`, `headid`, `subheadid`, `accountid`, `accountcode`, `debit`, `credit`, `remarks`, `ref`, `manual_ref`, `transdate`, `postby`, `createdat`, `is_trial`) VALUES
(1, 1, 1, 2, 10, '0', '50000000', '0', 'Loan disbursement Olawole', 'ref', 'manual_ref', '2022-12-01', '12', '2022-12-08 14:03:27', 1),
(2, 1, 1, 3, 1, '0', '0', '50000000', 'Loan disbursement Olawole', 'ref', 'manual_ref', '2022-12-01', '12', '2022-12-08 14:03:27', 1),
(3, 1, 1, 2, 10, '0', '5000000', '0', 'Loan disbursement Olawole', 'ref', 'manual_ref', '2022-11-01', '12', '2022-12-08 14:11:13', 1),
(4, 1, 1, 3, 1, '0', '0', '5000000', 'Loan disbursement Olawole', 'ref', 'manual_ref', '2022-11-01', '12', '2022-12-08 14:11:13', 1),
(5, 1, 1, 2, 10, '0', '500000', '0', 'Interest charge: Olawole', '1670505087023596', '1670505087023596', '2022-12-01', '12', '2022-12-08 14:11:27', 1),
(6, 5, 7, 4, 5, '0', '0', '500000', 'Interest charge: Olawole', '1670505087023596', '1670505087023596', '2022-12-01', '12', '2022-12-08 14:11:27', 1),
(7, 1, 1, 2, 10, '0', '0', '550000', 'Loan repayment: Test payment', 'ref', 'manual_ref', '2022-12-01', '12', '2022-12-08 14:15:39', 1),
(8, 1, 1, 3, 1, '0', '550000', '0', 'Loan repayment: Test payment', 'ref', 'manual_ref', '2022-12-01', '12', '2022-12-08 14:15:39', 1),
(9, 1, 1, 2, 10, '0', '0', '783333', 'Loan repayment: gugug', 'ref', 'manual_ref', '2022-12-02', '12', '2022-12-08 14:28:45', 1),
(10, 1, 1, 3, 1, '0', '783333', '0', 'Loan repayment: gugug', 'ref', 'manual_ref', '2022-12-02', '12', '2022-12-08 14:28:45', 1),
(11, 1, 1, 3, 1, '0', '0', '60000', 'Car maintenance', '1670506461194529', 'jv009', '2022-12-01', '12', '2022-12-08 14:34:21', 1),
(12, 4, 6, 5, 6, '0', '60000', '0', 'Car maintenance', '1670506461194529', 'jv009', '2022-12-01', '12', '2022-12-08 14:34:21', 1),
(13, 1, 1, 2, 10, '0', '5000000', '0', 'Interest charge: Olawole', '1670518667751744', '1670518667751744', '2023-01-02', '12', '2022-12-08 17:57:47', 1),
(14, 5, 7, 4, 5, '0', '0', '5000000', 'Interest charge: Olawole', '1670518667751744', '1670518667751744', '2023-01-02', '12', '2022-12-08 17:57:47', 1),
(15, 1, 1, 2, 10, '0', '550000', '0', 'Interest charge: Olawole', '1670518667203368', '1670518667203368', '2023-01-01', '12', '2022-12-08 17:57:47', 1),
(16, 5, 7, 4, 5, '0', '0', '550000', 'Interest charge: Olawole', '1670518667203368', '1670518667203368', '2023-01-01', '12', '2022-12-08 17:57:47', 1),
(17, 1, 1, 2, 10, '0', '0', '2716666.67', 'Loan repayment: ', 'ref', 'manual_ref', '2023-01-09', '12', '2022-12-08 18:01:48', 1),
(18, 1, 1, 3, 1, '0', '2716666.67', '0', 'Loan repayment: ', 'ref', 'manual_ref', '2023-01-09', '12', '2022-12-08 18:01:48', 1),
(19, 1, 1, 2, 10, '0', '5500000', '0', 'Interest charge: Olawole', '1670519417406927', '1670519417406927', '2023-02-02', '12', '2022-12-08 18:10:17', 1),
(20, 5, 7, 4, 5, '0', '0', '5500000', 'Interest charge: Olawole', '1670519417406927', '1670519417406927', '2023-02-02', '12', '2022-12-08 18:10:17', 1),
(21, 1, 1, 2, 10, '0', '333333.333', '0', 'Interest charge: Olawole', '1670519417203894', '1670519417203894', '2023-02-01', '12', '2022-12-08 18:10:17', 1),
(22, 5, 7, 4, 5, '0', '0', '333333.333', 'Interest charge: Olawole', '1670519417203894', '1670519417203894', '2023-02-01', '12', '2022-12-08 18:10:17', 1),
(23, 1, 1, 2, 10, '0', '0', '3666666.66', 'Loan repayment: ', 'ref', 'manual_ref', '2023-02-16', '12', '2022-12-08 18:32:36', 1),
(24, 1, 1, 3, 1, '0', '3666666.66', '0', 'Loan repayment: ', 'ref', 'manual_ref', '2023-02-16', '12', '2022-12-08 18:32:36', 1),
(25, 1, 1, 2, 10, '0', '0', '27166666.67', 'Loan repayment: ', 'ref', 'manual_ref', '2022-12-08', '12', '2022-12-08 18:46:07', 1),
(26, 1, 1, 3, 1, '0', '27166666.67', '0', 'Loan repayment: ', 'ref', 'manual_ref', '2022-12-08', '12', '2022-12-08 18:46:07', 1),
(27, 1, 1, 2, 10, '0', '0', '33333333.33', 'Loan repayment: ', 'ref', 'manual_ref', '2022-12-08', '12', '2022-12-08 18:49:50', 1),
(28, 1, 1, 3, 1, '0', '33333333.33', '0', 'Loan repayment: ', 'ref', 'manual_ref', '2022-12-08', '12', '2022-12-08 18:49:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `assign_role_modules`
--

DROP TABLE IF EXISTS `assign_role_modules`;
CREATE TABLE IF NOT EXISTS `assign_role_modules` (
  `roleid` int(11) NOT NULL,
  `submoduleid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign_role_modules`
--

INSERT INTO `assign_role_modules` (`roleid`, `submoduleid`) VALUES
(5, 1),
(3, 17),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(3, 16),
(3, 15),
(3, 14),
(3, 13),
(3, 12),
(3, 11),
(3, 10),
(3, 9),
(3, 8),
(3, 7),
(3, 6),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(4, 2),
(4, 5),
(4, 7),
(4, 8),
(4, 10),
(4, 11),
(3, 5),
(3, 4),
(3, 3),
(3, 2),
(3, 1),
(3, 18);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titleID` int(11) DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bvn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nin` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marketerID` int(11) DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_h_address_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_o_address_verified` tinyint(1) NOT NULL DEFAULT '0',
  `registerdBy` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `guarrantor_full_name` longtext COLLATE utf8mb4_unicode_ci,
  `guarrantor_phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guarrantor_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guarrantor_o_address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `guarrantor_h_address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` longtext COLLATE utf8mb4_unicode_ci,
  `registered_amount` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `titleID`, `first_name`, `middle_name`, `last_name`, `phone`, `email`, `bvn`, `nin`, `marketerID`, `address`, `office_address`, `is_h_address_verified`, `is_o_address_verified`, `registerdBy`, `account_id`, `user_id`, `status`, `guarrantor_full_name`, `guarrantor_phone`, `guarrantor_email`, `guarrantor_o_address`, `guarrantor_h_address`, `remarks`, `registered_amount`, `created_at`, `updated_at`) VALUES
(1, 1, '999', 'Stephen', 'Akinbobola', '0904554344', 'stephen@yahoo.com', '44556566', '5666', 8, 'AKURE', 'Ondo', 0, 0, 12, 10, 27, 1, 'Mr Badmus', '0907888', 'EE@rr.com', 'Akure', 'yygyg', NULL, NULL, NULL, '2022-12-09 19:49:33'),
(2, NULL, 'Usman', NULL, 'Ahmed', '0908878989', 'ahmed@yahoo.com', '44556566', '5666', 8, 'Kaduna', 'Ondo', 0, 1, 12, 11, 28, 1, 'Mr Badmus', '0907888', 'EE@rr.com', 'Akure', NULL, NULL, NULL, NULL, '2022-12-09 19:38:44');

-- --------------------------------------------------------

--
-- Table structure for table `customers2`
--

DROP TABLE IF EXISTS `customers2`;
CREATE TABLE IF NOT EXISTS `customers2` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titleID` int(11) DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marketerID` int(11) DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `registerdBy` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers2`
--

INSERT INTO `customers2` (`id`, `titleID`, `first_name`, `middle_name`, `last_name`, `phone`, `email`, `marketerID`, `address`, `registerdBy`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 1, 'Olawole', 'Akinbobola', 'Stephen', '08032196222', 'st@yahoo.com', 8, 'Abuja', 12, '2022-11-17 06:59:11', '2022-11-21 13:40:34', NULL),
(5, 1, 'Evelyn', NULL, 'Godwin', '080321962212', 'stolaksoftech@gmail.com', 12, 'Abuja', 14, '2022-11-24 10:17:04', '2022-11-24 10:17:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_notes`
--

DROP TABLE IF EXISTS `customer_notes`;
CREATE TABLE IF NOT EXISTS `customer_notes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_notes`
--

INSERT INTO `customer_notes` (`id`, `customer_id`, `loan_id`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Approvedbedh hdhdfhdxdcdbefchefj', 12, '2022-12-08 11:50:25', '2022-12-08 11:50:25'),
(2, 1, 1, 'Paid as approved', 12, '2022-12-08 12:03:27', '2022-12-08 12:03:27'),
(3, 1, 2, 'Approved', 12, '2022-12-08 12:10:29', '2022-12-08 12:10:29'),
(4, 1, 2, 'Paid as approved', 12, '2022-12-08 12:11:13', '2022-12-08 12:11:13'),
(5, 1, 2, 'Test payment', 12, '2022-12-08 12:15:39', '2022-12-08 12:15:39'),
(6, 1, 2, 'gugug', 12, '2022-12-08 12:28:45', '2022-12-08 12:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_charges`
--

DROP TABLE IF EXISTS `fee_charges`;
CREATE TABLE IF NOT EXISTS `fee_charges` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `particular` text NOT NULL,
  `amount` double NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fee_charges`
--

INSERT INTO `fee_charges` (`id`, `particular`, `amount`) VALUES
(1, 'Registration', 5000),
(2, 'Processing Fees', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

DROP TABLE IF EXISTS `loans`;
CREATE TABLE IF NOT EXISTS `loans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `loan_type_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL DEFAULT '0.00',
  `amount_marketer` double(20,2) NOT NULL DEFAULT '0.00',
  `amount_accountant` double(20,2) NOT NULL DEFAULT '0.00',
  `amount_approved` double(20,2) NOT NULL DEFAULT '0.00',
  `marketer_id` int(11) DEFAULT NULL,
  `accountant_id` int(11) DEFAULT NULL,
  `approver_id` int(11) DEFAULT NULL,
  `period` int(11) NOT NULL,
  `percentage` double(11,2) DEFAULT NULL,
  `approval_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disbursed_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_interest` double(20,2) NOT NULL DEFAULT '0.00',
  `monthly_repayment` double(20,2) NOT NULL DEFAULT '0.00',
  `total_repayment` double(20,2) NOT NULL DEFAULT '0.00',
  `amount_outstanding` double(20,2) DEFAULT '0.00',
  `first_due_date` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_due_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stage` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `loan_type_id`, `amount`, `amount_marketer`, `amount_accountant`, `amount_approved`, `marketer_id`, `accountant_id`, `approver_id`, `period`, `percentage`, `approval_date`, `disbursed_date`, `total_interest`, `monthly_repayment`, `total_repayment`, `amount_outstanding`, `first_due_date`, `next_due_date`, `remarks`, `stage`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 50000000.00, 50000000.00, 50000000.00, 50000000.00, 8, NULL, 12, 6, 10.00, '2022-12-08', '2022-12-01', 17500000.00, 11250000.00, 67500000.00, -33333333.33, '2022-12-02', '2023-03-02', 'Car Loan', 6, 3, '2022-12-08 11:49:00', '2022-12-08 16:49:50'),
(2, 1, 1, 5000000.00, 5000000.00, 5000000.00, 5000000.00, 8, NULL, 12, 6, 10.00, '2022-12-08', '2022-11-01', 1750000.00, 1125000.00, 6750000.00, -2500000.00, '2022-11-01', '2023-03-01', 'Car Loan', 6, 2, '2022-12-08 12:10:08', '2022-12-08 16:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `loan_statuses`
--

DROP TABLE IF EXISTS `loan_statuses`;
CREATE TABLE IF NOT EXISTS `loan_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_statuses`
--

INSERT INTO `loan_statuses` (`id`, `code`, `status`, `rank`) VALUES
(1, 0, 'Application', 1),
(2, 1, 'Approved', 3),
(3, 2, 'Active', 4),
(4, 3, 'Expired', 5),
(5, 9, 'Declined', 2);

-- --------------------------------------------------------

--
-- Table structure for table `loan_transactions`
--

DROP TABLE IF EXISTS `loan_transactions`;
CREATE TABLE IF NOT EXISTS `loan_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `debit` double NOT NULL DEFAULT '0',
  `credit` double NOT NULL DEFAULT '0',
  `transaction_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_type` int(11) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_transactions`
--

INSERT INTO `loan_transactions` (`id`, `customer_id`, `loan_id`, `debit`, `credit`, `transaction_date`, `transaction_type`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 50000000, 0, '2022-12-01', 1, 'Loan disbursement', '2022-12-08 12:03:27', '2022-12-08 12:03:27'),
(2, 1, 2, 5000000, 0, '2022-11-01', 1, 'Loan disbursement', '2022-12-08 12:11:13', '2022-12-08 12:11:13'),
(3, 1, 2, 500000, 0, '2022-12-01', 1, 'Interest charge', '2022-12-08 12:11:27', '2022-12-08 12:11:27'),
(7, 1, 2, 550000, 0, '2023-01-01', 1, 'Interest charge', '2022-12-08 15:57:47', '2022-12-08 15:57:47'),
(6, 1, 1, 5000000, 0, '2023-01-02', 1, 'Interest charge', '2022-12-08 15:57:47', '2022-12-08 15:57:47'),
(8, 1, 2, 0, 2716666.67, '2023-01-09', 2, 'Loan repayment with ref to balance', '2022-12-08 16:01:48', '2022-12-08 16:01:48'),
(9, 1, 1, 5500000, 0, '2023-02-02', 1, 'Interest charge', '2022-12-08 16:10:17', '2022-12-08 16:10:17'),
(10, 1, 2, 333333.333, 0, '2023-02-01', 1, 'Interest charge', '2022-12-08 16:10:17', '2022-12-08 16:10:17'),
(11, 1, 2, 0, 3666666.66, '2023-02-16', 2, 'Loan repayment with ref to Liquidating', '2022-12-08 16:32:36', '2022-12-08 16:32:36'),
(12, 1, 1, 0, 27166666.67, '2022-12-08', 2, 'Loan repayment with ref to yh', '2022-12-08 16:46:07', '2022-12-08 16:46:07'),
(13, 1, 1, 0, 33333333.33, '2022-12-08', 2, 'Loan repayment with ref to liuii', '2022-12-08 16:49:50', '2022-12-08 16:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `loan_types`
--

DROP TABLE IF EXISTS `loan_types`;
CREATE TABLE IF NOT EXISTS `loan_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `particular` varchar(50) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_types`
--

INSERT INTO `loan_types` (`id`, `particular`) VALUES
(1, 'Reducing Balance'),
(2, 'Straight Line');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2022_11_14_111137_create_loans_table', 1),
(13, '2022_11_14_111311_create_customers_table', 4),
(6, '2022_11_14_123603_create_loan_transactions_table', 1),
(7, '2022_11_14_124155_create_repayment_logs_table', 1),
(8, '2022_11_14_124920_create_customer_notes_table', 1),
(9, '2022_11_15_083737_create_titles_table', 1),
(11, '2022_11_19_100521_create_loan_statuses_table', 2),
(12, '2022_11_20_145229_create_rates_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `module` varchar(200) NOT NULL,
  `module_rank` int(11) NOT NULL DEFAULT '0',
  `created_at` varchar(200) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module`, `module_rank`, `created_at`) VALUES
(1, 'Registration', 1, NULL),
(2, 'Loan', 2, NULL),
(3, 'Reports', 3, NULL),
(4, 'Payment', 3, NULL),
(5, 'Setting', 5, NULL),
(6, 'Account Setup', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ohara.elian@example.org', '$2y$04$GW6euMOviCoep1uS1A/v2e0qHMfj1DDJXp6MvxnVqTlsdLwS2V2J6', '2022-11-16 20:55:36'),
('magdalena.hessel@example.org', '$2y$04$.TKWAq72C6FRaOqJ.ig2M.HffdjTx/nxWIcotQfwozOFXeJvegqPO', '2022-11-16 20:55:36');

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

DROP TABLE IF EXISTS `rates`;
CREATE TABLE IF NOT EXISTS `rates` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rate` double(4,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `rate`, `created_at`, `updated_at`) VALUES
(1, 10.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `repayment_logs`
--

DROP TABLE IF EXISTS `repayment_logs`;
CREATE TABLE IF NOT EXISTS `repayment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_approved` int(11) NOT NULL DEFAULT '0',
  `approved_by` int(11) DEFAULT NULL,
  `details` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repayment_logs`
--

INSERT INTO `repayment_logs` (`id`, `customer_id`, `loan_id`, `amount`, `created_by`, `is_approved`, `approved_by`, `details`, `payment_date`, `created_at`, `updated_at`) VALUES
(4, 1, 2, 3666666.66, 12, 1, 12, 'Liquidating', '2023-02-16', '2022-12-08 16:32:22', '2022-12-08 16:32:36'),
(3, 1, 2, 2716666.67, 12, 1, 12, 'balance', '2023-01-09', '2022-12-08 16:01:24', '2022-12-08 16:01:48'),
(5, 1, 1, 27166666.67, 12, 1, 12, 'yh', '2022-12-08', '2022-12-08 16:45:30', '2022-12-08 16:46:07'),
(6, 1, 1, 33333333.33, 12, 1, 12, 'liuii', '2022-12-08', '2022-12-08 16:49:40', '2022-12-08 16:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `setup_subheads`
--

DROP TABLE IF EXISTS `setup_subheads`;
CREATE TABLE IF NOT EXISTS `setup_subheads` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `particular` varchar(100) NOT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setup_subheads`
--

INSERT INTO `setup_subheads` (`id`, `particular`, `subhead_id`) VALUES
(1, 'Customer Setup', 2),
(2, 'Payment Drawal', 3);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(100) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `status`) VALUES
(0, 'Inactive'),
(1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `submodules`
--

DROP TABLE IF EXISTS `submodules`;
CREATE TABLE IF NOT EXISTS `submodules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `moduleid` int(11) NOT NULL,
  `submodule` varchar(100) NOT NULL,
  `links` varchar(200) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submodules`
--

INSERT INTO `submodules` (`id`, `moduleid`, `submodule`, `links`, `rank`, `status`) VALUES
(1, 1, 'Customer', 'new-client', 1, 1),
(2, 1, 'User', 'create-user', 1, 1),
(3, 2, 'Request Form', 'loan-request', 1, 1),
(4, 2, 'Account Officer', 'loan-marketer-review', 2, 1),
(5, 2, 'Financial Officer', 'loan-accountant-review', 3, 1),
(6, 2, 'Approval', 'loan-final-review', 4, 1),
(7, 2, 'Disbursement', 'loan-disbursement', 5, 1),
(8, 4, 'Lodgement', 'loan-repayment', 1, 1),
(9, 4, 'Lodgement Approval', 'loan-repayment-approval', 2, 1),
(10, 3, 'Loans', 'loan-report', 1, 1),
(11, 3, 'Loan Details', 'loan-details', 2, 1),
(12, 5, 'Role Management', 'assign-module/create', 1, 1),
(13, 6, 'Subaccount', 'sub-account', 1, 1),
(14, 6, 'Account Ledger', 'account', 2, 1),
(15, 6, 'Journal Transfer', 'journal', 3, 1),
(16, 3, 'Trial Balance', 'trialbalance', 4, 1),
(17, 3, 'Profit & Loss', 'pl', 4, 1),
(18, 3, 'Statement of Account', 'balance-sheet', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbldaterange`
--

DROP TABLE IF EXISTS `tbldaterange`;
CREATE TABLE IF NOT EXISTS `tbldaterange` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_from` varchar(100) DEFAULT NULL,
  `date_to` varchar(100) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbldaterange`
--

INSERT INTO `tbldaterange` (`id`, `date_from`, `date_to`) VALUES
(1, '2022-07-01', '2022-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `tblstatus`
--

DROP TABLE IF EXISTS `tblstatus`;
CREATE TABLE IF NOT EXISTS `tblstatus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(100) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblstatus`
--

INSERT INTO `tblstatus` (`id`, `status`) VALUES
(0, 'Inactive'),
(1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbltemp_journal_transfer`
--

DROP TABLE IF EXISTS `tbltemp_journal_transfer`;
CREATE TABLE IF NOT EXISTS `tbltemp_journal_transfer` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transtype` varchar(100) NOT NULL,
  `accountid` int(11) NOT NULL,
  `debit` double NOT NULL DEFAULT '0',
  `credit` double NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `batch_status` int(11) NOT NULL DEFAULT '1',
  `ref` varchar(200) DEFAULT NULL,
  `manual_ref` varchar(200) DEFAULT NULL,
  `transdate` varchar(200) DEFAULT NULL,
  `post_at` varchar(100) DEFAULT NULL,
  `postby` int(11) DEFAULT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `f_post_at` varchar(200) DEFAULT NULL,
  `final_post_by` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltemp_journal_transfer`
--

INSERT INTO `tbltemp_journal_transfer` (`id`, `transtype`, `accountid`, `debit`, `credit`, `status`, `batch_status`, `ref`, `manual_ref`, `transdate`, `post_at`, `postby`, `remarks`, `created_at`, `f_post_at`, `final_post_by`) VALUES
(1, 'Credit', 1, 0, 60000, 1, 1, '1670506461194529', 'jv009', '2022-12-01', NULL, 12, 'Car maintenance', '2022-12-08 14:33:41', NULL, 0),
(2, 'Debit', 6, 60000, 0, 1, 1, '1670506461194529', 'jv009', '2022-12-01', NULL, 12, 'Car maintenance', '2022-12-08 14:33:51', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbltranstype`
--

DROP TABLE IF EXISTS `tbltranstype`;
CREATE TABLE IF NOT EXISTS `tbltranstype` (
  `transtype` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltranstype`
--

INSERT INTO `tbltranstype` (`transtype`) VALUES
('Debit'),
('Credit');

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

DROP TABLE IF EXISTS `titles`;
CREATE TABLE IF NOT EXISTS `titles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'MR', NULL, NULL),
(2, 'Mrs', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userrole` int(11) NOT NULL DEFAULT '0',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `userrole`, `email`, `email_verified_at`, `password`, `usertype`, `status`, `remember_token`, `createdby`, `created_at`, `updated_at`) VALUES
(1, 'Adalberto Maggio V', 'Adalberto', 2, 'davon67@example.net', '2022-11-16 20:55:34', '$2y$10$PswI1Y5BKUQ238Pa.JT7weNneUiUNpthG7giNzaUFJKKdH4Vipddu', 0, 1, 'G9y7C7FnLX', 0, '2022-11-16 20:55:34', '2022-11-16 20:55:34'),
(2, 'Hassie Altenwerth', '', 0, 'sam.auer@example.net', '2022-11-16 20:55:35', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, '07Mc0L76Kj', 0, '2022-11-16 20:55:35', '2022-11-16 20:55:35'),
(3, 'Rahsaan Marvin', '', 0, 'jschumm@example.org', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, 'gP0KRsBB4f', 0, '2022-11-16 20:55:35', '2022-11-16 20:55:35'),
(4, 'Dino Corkery', '', 0, 'tina.collins@example.com', '2022-11-16 20:55:35', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, 'IT4fn2meqr', 0, '2022-11-16 20:55:35', '2022-11-16 20:55:35'),
(5, 'Ellis Wolff', '', 0, 'jackson.koch@example.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, '4S7x4n64Vc', 0, '2022-11-16 20:55:35', '2022-11-16 20:55:35'),
(6, 'Mr. Carter Schmidt', '', 0, 'myah37@example.net', '2022-11-16 20:55:36', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, 'I2MeaGTpum', 0, '2022-11-16 20:55:36', '2022-11-16 20:55:36'),
(7, 'Rasheed Reichel', '', 0, 'crona.garret@example.org', '2022-11-16 20:55:36', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, 'c0esepRAVr', 0, '2022-11-16 20:55:36', '2022-11-16 20:55:36'),
(8, 'Mackenzie Lehner', '', 3, 'grace.abernathy@example.org', '2022-11-16 20:55:36', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, 'BAKaJOgZyw', 0, '2022-11-16 20:55:36', '2022-11-16 20:55:36'),
(9, 'Fay Greenfelder', '', 0, 'ohara.elian@example.org', '2022-11-16 20:55:36', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, 'VrPpNAshnl', 0, '2022-11-16 20:55:36', '2022-11-16 20:55:36'),
(10, 'Prof. Missouri Lemke V', '', 0, 'magdalena.hessel@example.org', '2022-11-16 20:55:36', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, '6kn8dGePRA', 0, '2022-11-16 20:55:36', '2022-11-16 20:55:36'),
(11, 'Mrs. Beryl Marks MD', '', 3, 'henry54@example.net', '2022-11-16 20:55:37', '$2y$04$0n6gwqBZ4lVH1XFpKJRp4OQQfRxb3hN6.lvW2OVPPuNnjOil.gOtO', 0, 1, 'C79vp5iH9qrmG4sWnG6LgRyDtQs2aPQjE2Yy3cUrXpRb0PRPVmZKlwYir5KO', 0, '2022-11-16 20:55:37', '2022-11-16 20:55:37'),
(12, 'Test User', '', 3, 'test@example.com', NULL, '$2y$04$nbqQ3ZVluU1yj5E3Fa9h1uvM2h6Whu7V6xW4cVSRjO4BWkCzAZ2s.', 1, 1, NULL, 0, '2022-11-16 20:55:37', '2022-11-16 20:55:37'),
(13, 'stephen', 'admin@admin.com', 2, 'st@yahoo.com', NULL, '$2y$10$7EsQXyipVT/.3k/Z2ZuJCulHLmXL5ua/mjnKcwr5jLZ6SfNC94CAe', 2, 1, NULL, 12, NULL, NULL),
(14, 'New user', 'user', 4, 'user@gmail.com', NULL, '$2y$10$Ls/J/T1gb1Mxv71703OJFe5u7LeXG0dqRnsGqOMb7UWGbsYUG.xDW', 2, 1, NULL, 12, NULL, NULL),
(15, 'Evelyn Godwin', '080321962212', 5, 'stolaksoftech@gmail.com', NULL, '$2y$10$o1oPSnfM/Is.rer82Q/ZruMO.LTALUTRj/o3cz1v14jZCZBEf3FaS', 3, 1, NULL, 14, NULL, NULL),
(28, 'Usman Ahmed', '0908878989', 5, 'ahmed@yahoo.com', NULL, '$2y$10$bM5uIDAL3e/9GMJK6iPfvObuk.10CEn3w2YwR19oVp6nUHA2R7tNu', 3, 1, NULL, 12, NULL, NULL),
(27, 'Olawole Akinbobola', '0904554344', 5, 'stephen@yahoo.com', NULL, '$2y$10$8ISIrclURRfELh6KQW9C8uRe8F4uVXnDcWG6wpVdopxMIv.NcS.Ne', 3, 1, NULL, 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `editable` tinyint(4) NOT NULL DEFAULT '1',
  `assignabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `rolename`, `status`, `editable`, `assignabled`) VALUES
(1, 'Super-Adminstrator', 1, 0, 0),
(2, 'Adminstrator', 1, 0, 1),
(3, 'Marketer', 1, 0, 1),
(4, 'Accountant', 1, 0, 1),
(5, 'Client', 1, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
