-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 09:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

-- CREATE TABLE `admissions` (
--   `id` mediumint(8) UNSIGNED NOT NULL,
--   `client_id` mediumint(8) UNSIGNED NOT NULL,
--   `committing_court` varchar(50) NOT NULL,
--   `crim_case_number` varchar(25) NOT NULL,
--   `offense_committed` varchar(100) NOT NULL,
--   `date_admitted` date NOT NULL,
--   `days_in_jail` int(11) NOT NULL,
--   `days_in_detention_center` int(11) NOT NULL,
--   `action_taken` text NOT NULL,
--   `general_impression` text NOT NULL,
--   `case_status` varchar(25) NOT NULL,
--   `referring_party_name` varchar(50) DEFAULT NULL,
--   `admitting_officer` varchar(50) DEFAULT NULL,
--   `designation_id_contact` varchar(50) DEFAULT NULL,
--   `designation` varchar(50) DEFAULT NULL,
--   `office_address` varchar(50) DEFAULT NULL,
--   `date_time` datetime DEFAULT NULL,
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`id`, `client_id`, `committing_court`, `crim_case_number`, `offense_committed`, `date_admitted`, `days_in_jail`, `days_in_detention_center`, `action_taken`, `general_impression`, `case_status`, `referring_party_name`, `admitting_officer`, `designation_id_contact`, `designation`, `office_address`, `date_time`, `created_at`, `updated_at`) VALUES
(1, 1, 'RTC-Br, 61, Digos City', 'dasfdsf', 'Murder', '2024-11-20', 33, 33, 'asdfsdf', 'afsfa', 'Acquitted/Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-20 03:40:00', '2024-11-18 19:40:45', '2024-11-18 19:40:45'),
(2, 2, 'RTC-Br, 61, Digos City', 'dasfdsf', 'Murder', '2024-11-20', 33, 33, 'asdfsdf', 'afsfa', 'Acquitted/Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-20 03:40:00', '2024-11-18 19:40:45', '2024-11-18 19:40:45'),
(3, 3, 'RTC-Br, 7, Sta. Cruz', 'dasfdsf', 'Murder', '2024-11-20', 33, 33, 'asdfsdf', 'afsfa', 'Provisionally Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:43:56', '2024-11-18 19:43:56'),
(4, 4, 'RTC-Br, 7, Sta. Cruz', 'dasfdsf', 'Homicide', '2024-11-20', 33, 33, 'asdfsdf', 'afsfa', 'Provisionally Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:45:01', '2024-11-18 19:45:01'),
(5, 5, 'RTC-Br, 5, Digos City', 'dasfdsf', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:46:08', '2024-11-18 19:46:08'),
(6, 6, 'RTC-Br, 5, Digos City', 'dasfdsf', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:46:44', '2024-11-18 19:46:44'),
(7, 7, 'RTC-Br, 5, Digos City', 'dasfdsf', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:47:16', '2024-11-18 19:47:16'),
(8, 8, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:48:26', '2024-11-18 19:48:26'),
(9, 9, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:48:50', '2024-11-18 19:48:50'),
(10, 10, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:49:07', '2024-11-18 19:49:07'),
(11, 11, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:49:23', '2024-11-18 19:49:23'),
(12, 12, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:49:38', '2024-11-18 19:49:38'),
(13, 13, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:49:53', '2024-11-18 19:49:53'),
(14, 14, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:50:14', '2024-11-18 19:50:14'),
(15, 15, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:50:32', '2024-11-18 19:50:32'),
(16, 16, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:50:46', '2024-11-18 19:50:46'),
(17, 17, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:51:03', '2024-11-18 19:51:03'),
(18, 18, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:51:33', '2024-11-18 19:51:33'),
(19, 19, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:51:52', '2024-11-18 19:51:52'),
(20, 20, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:52:07', '2024-11-18 19:52:07'),
(21, 21, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:52:27', '2024-11-18 19:52:27'),
(22, 22, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:52:44', '2024-11-18 19:52:44'),
(23, 23, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:52:59', '2024-11-18 19:52:59'),
(24, 24, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:53:13', '2024-11-18 19:53:13'),
(25, 25, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:53:29', '2024-11-18 19:53:29'),
(26, 26, 'RTC-Br, 5, Digos City', 'RA0502', 'Theft', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:53:45', '2024-11-18 19:53:45'),
(27, 27, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:56:10', '2024-11-18 19:56:10'),
(28, 28, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:56:25', '2024-11-18 19:56:25'),
(29, 29, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:57:33', '2024-11-18 19:57:33'),
(30, 30, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:57:57', '2024-11-18 19:57:57'),
(31, 31, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:58:13', '2024-11-18 19:58:13'),
(32, 32, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:58:41', '2024-11-18 19:58:41'),
(33, 33, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:58:55', '2024-11-18 19:58:55'),
(34, 34, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:59:08', '2024-11-18 19:59:08'),
(35, 35, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:59:21', '2024-11-18 19:59:21'),
(36, 36, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:59:37', '2024-11-18 19:59:37'),
(37, 37, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 19:59:51', '2024-11-18 19:59:51'),
(38, 38, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:00:34', '2024-11-18 20:00:34'),
(39, 39, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:00:49', '2024-11-18 20:00:49'),
(40, 40, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:01:05', '2024-11-18 20:01:05'),
(41, 41, 'RTC-Br, 5, Digos City', 'RA0502', 'Slight Physical Injury', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:01:20', '2024-11-18 20:01:20'),
(42, 42, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery Against Person', '2024-01-11', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:01:46', '2024-11-18 20:01:46'),
(43, 43, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery Against Person', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:02:14', '2024-11-18 20:02:14'),
(44, 44, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery Against Person', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:02:34', '2024-11-18 20:02:34'),
(45, 45, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery Against Person', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:02:49', '2024-11-18 20:02:49'),
(46, 46, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery Against Person', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:03:08', '2024-11-18 20:03:08'),
(47, 47, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:03:33', '2024-11-18 20:03:33'),
(48, 48, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:03:48', '2024-11-18 20:03:48'),
(49, 49, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:04:01', '2024-11-18 20:04:01'),
(50, 50, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:04:15', '2024-11-18 20:04:15'),
(51, 51, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:04:28', '2024-11-18 20:04:28'),
(52, 52, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:04:42', '2024-11-18 20:04:42'),
(53, 53, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:05:07', '2024-11-18 20:05:07'),
(54, 54, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:05:20', '2024-11-18 20:05:20'),
(55, 55, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:05:34', '2024-11-18 20:05:34'),
(56, 56, 'RTC-Br, 5, Digos City', 'RA0502', 'Sexual Assault', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:05:50', '2024-11-18 20:05:50'),
(57, 57, 'RTC-Br, 5, Digos City', 'RA0502', 'Frustrated Homicide', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:06:09', '2024-11-18 20:06:09'),
(58, 58, 'RTC-Br, 5, Digos City', 'RA0502', 'Frustrated Homicide', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:06:24', '2024-11-18 20:06:24'),
(59, 59, 'RTC-Br, 5, Digos City', 'RA0502', 'Frustrated Homicide', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:06:37', '2024-11-18 20:06:37'),
(60, 60, 'RTC-Br, 5, Digos City', 'RA0502', 'Frustrated Homicide', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:06:53', '2024-11-18 20:06:53'),
(61, 61, 'RTC-Br, 5, Digos City', 'RA0502', 'Frustrated Homicide', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:07:11', '2024-11-18 20:07:11'),
(62, 62, 'RTC-Br, 5, Digos City', 'RA0502', 'Frustrated Homicide', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:07:28', '2024-11-18 20:07:28'),
(63, 63, 'RTC-Br, 5, Digos City', 'RA0502', 'Frustrated Homicide', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:08:17', '2024-11-18 20:08:17'),
(64, 64, 'RTC-Br, 5, Digos City', 'RA0502', 'Acts of Lasciviousness', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:08:48', '2024-11-18 20:08:48'),
(65, 65, 'RTC-Br, 5, Digos City', 'RA0502', 'Acts of Lasciviousness', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:09:01', '2024-11-18 20:09:01'),
(66, 66, 'RTC-Br, 5, Digos City', 'RA0502', 'Acts of Lasciviousness', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:09:13', '2024-11-18 20:09:13'),
(67, 67, 'RTC-Br, 5, Digos City', 'RA0502', 'Acts of Lasciviousness', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:09:27', '2024-11-18 20:09:27'),
(68, 68, 'RTC-Br, 5, Digos City', 'RA0502', 'Acts of Lasciviousness', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:09:40', '2024-11-18 20:09:40'),
(69, 69, 'RTC-Br, 5, Digos City', 'RA0502', 'Acts of Lasciviousness', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:09:54', '2024-11-18 20:09:54'),
(70, 70, 'RTC-Br, 5, Digos City', 'RA0502', 'Acts of Lasciviousness', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:10:07', '2024-11-18 20:10:07'),
(71, 71, 'RTC-Br, 5, Digos City', 'RA0502', 'Acts of Lasciviousness', '2023-10-21', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:10:32', '2024-11-18 20:10:32'),
(72, 72, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:11:30', '2024-11-18 20:11:30'),
(73, 73, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:11:44', '2024-11-18 20:11:44'),
(74, 74, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:11:59', '2024-11-18 20:11:59'),
(75, 75, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:12:14', '2024-11-18 20:12:14'),
(76, 76, 'RTC-Br, 5, Digos City', 'RA0502', 'Robbery', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:12:28', '2024-11-18 20:12:28'),
(77, 77, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Acquitted/Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:12:56', '2024-11-18 20:12:56'),
(78, 78, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Acquitted/Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:13:10', '2024-11-18 20:13:10'),
(79, 79, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Acquitted/Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:13:46', '2024-11-18 20:13:46'),
(80, 80, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Acquitted/Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:14:01', '2024-11-18 20:14:01'),
(81, 81, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Acquitted/Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:14:14', '2024-11-18 20:14:14'),
(82, 82, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Acquitted/Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:15:01', '2024-11-18 20:15:01'),
(83, 83, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Acquitted/Dismissed', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:15:18', '2024-11-18 20:15:18'),
(84, 84, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:15:36', '2024-11-18 20:15:36'),
(85, 85, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:15:52', '2024-11-18 20:15:52'),
(86, 86, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:16:04', '2024-11-18 20:16:04'),
(87, 87, 'RTC-Br, 5, Digos City', 'RA0502', 'Malicious Mischief', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:16:18', '2024-11-18 20:16:18'),
(88, 88, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 8485 - Animal Welfare Act of 1998', '2022-06-15', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:16:40', '2024-11-18 20:16:40'),
(89, 89, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 8485 - Animal Welfare Act of 1998', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:17:02', '2024-11-18 20:17:02'),
(90, 90, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:17:54', '2024-11-18 20:17:54'),
(91, 91, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:18:08', '2024-11-18 20:18:08'),
(92, 92, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:18:22', '2024-11-18 20:18:22'),
(93, 93, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:18:35', '2024-11-18 20:18:35'),
(94, 94, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:18:48', '2024-11-18 20:18:48'),
(95, 95, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:19:01', '2024-11-18 20:19:01'),
(96, 96, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:19:16', '2024-11-18 20:19:16'),
(97, 97, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:19:30', '2024-11-18 20:19:30'),
(98, 98, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:19:44', '2024-11-18 20:19:44'),
(99, 99, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'Rehabilitation', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:19:56', '2024-11-18 20:19:56'),
(100, 100, 'RTC-Br, 5, Digos City', 'RA0502', 'RA 9165 - Comprehensive Dangerous Drug Act of 2002', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:20:19', '2024-11-18 20:20:19'),
(101, 101, 'RTC-Br, 5, Digos City', 'RA0502', 'Illegal possession of explosives', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:21:00', '2024-11-18 20:21:00'),
(102, 102, 'RTC-Br, 5, Digos City', 'RA0502', 'Illegal possession of explosives', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:21:13', '2024-11-18 20:21:13'),
(103, 103, 'RTC-Br, 5, Digos City', 'RA0502', 'Illegal possession of explosives', '2021-10-12', 33, 33, 'asdfsdf', 'afsfa', 'On trial', 'asdfsdf', 'asdfsdf', 'asdfsdf', 'asdf', 'asdfasdf', '2024-11-18 03:42:00', '2024-11-18 20:21:25', '2024-11-18 20:21:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admissions`
--
-- ALTER TABLE `admissions`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `admissions_client_id_foreign` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admissions`
--
-- ALTER TABLE `admissions`
--   ADD CONSTRAINT `admissions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
