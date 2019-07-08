-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: apymsatepremia.c6elyyqegxd1.us-east-1.rds.amazonaws.com:3306
-- Generation Time: Jun 10, 2019 at 10:07 PM
-- Server version: 5.7.22-log
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adboxadm_apymsa`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad3xp_core_user_info`
--

CREATE TABLE IF NOT EXISTS `#__core_user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `branch_office` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cellphone` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `street` varchar(200) NOT NULL,
  `int_number` varchar(11) NOT NULL,
  `ext_number` varchar(11) NOT NULL,
  `reference` text NOT NULL,
  `zip_code` varchar(5) NOT NULL,
  `location` varchar(200) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `rfc` varchar(12) NOT NULL,
  `nss` varchar(12) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `gmid` varchar(50) NOT NULL,
  `distributor` int(11) NOT NULL,
  `complete_data` int(11) NOT NULL,
  `complete_data_at` timestamp NOT NULL,
  `user_category_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_joomla` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


