-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 09:26 PM
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
-- Table structure for table `documents_submitted`
--

-- CREATE TABLE `documents_submitted` (
--   `id` mediumint(8) UNSIGNED NOT NULL,
--   `admission_id` mediumint(8) UNSIGNED NOT NULL,
--   `document_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`document_name`)),
--   `submitted` tinyint(1) NOT NULL DEFAULT 0,
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents_submitted`
--

INSERT INTO `documents_submitted` (`id`, `admission_id`, `document_name`, `submitted`, `created_at`, `updated_at`) VALUES
(1, 1, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:43:56', '2024-11-18 19:43:56'),
(2, 2, '\"[\\\"SCSR\\\",\\\"Medical Certificates\\\"]\"', 1, '2024-11-18 19:40:45', '2024-11-18 19:40:45'),
(3, 3, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:43:56', '2024-11-18 19:43:56'),
(4, 4, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:45:01', '2024-11-18 19:45:01'),
(5, 5, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:46:08', '2024-11-18 19:46:08'),
(6, 6, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:46:44', '2024-11-18 19:46:44'),
(7, 7, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:47:16', '2024-11-18 19:47:16'),
(8, 8, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:48:26', '2024-11-18 19:48:26'),
(9, 9, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:48:50', '2024-11-18 19:48:50'),
(10, 10, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:49:07', '2024-11-18 19:49:07'),
(11, 11, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:49:23', '2024-11-18 19:49:23'),
(12, 12, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:49:38', '2024-11-18 19:49:38'),
(13, 13, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:49:53', '2024-11-18 19:49:53'),
(14, 14, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:50:14', '2024-11-18 19:50:14'),
(15, 15, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:50:32', '2024-11-18 19:50:32'),
(16, 16, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:50:46', '2024-11-18 19:50:46'),
(17, 17, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:51:03', '2024-11-18 19:51:03'),
(18, 18, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:51:33', '2024-11-18 19:51:33'),
(19, 19, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:51:52', '2024-11-18 19:51:52'),
(20, 20, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:52:07', '2024-11-18 19:52:07'),
(21, 21, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:52:27', '2024-11-18 19:52:27'),
(22, 22, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:52:44', '2024-11-18 19:52:44'),
(23, 23, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:52:59', '2024-11-18 19:52:59'),
(24, 24, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:53:13', '2024-11-18 19:53:13'),
(25, 25, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:53:29', '2024-11-18 19:53:29'),
(26, 26, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:53:45', '2024-11-18 19:53:45'),
(27, 27, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:56:10', '2024-11-18 19:56:10'),
(28, 28, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:56:25', '2024-11-18 19:56:25'),
(29, 29, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:57:33', '2024-11-18 19:57:33'),
(30, 30, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:57:57', '2024-11-18 19:57:57'),
(31, 31, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:58:13', '2024-11-18 19:58:13'),
(32, 32, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:58:41', '2024-11-18 19:58:41'),
(33, 33, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:58:55', '2024-11-18 19:58:55'),
(34, 34, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:59:08', '2024-11-18 19:59:08'),
(35, 35, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:59:21', '2024-11-18 19:59:21'),
(36, 36, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:59:37', '2024-11-18 19:59:37'),
(37, 37, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 19:59:51', '2024-11-18 19:59:51'),
(38, 38, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:00:34', '2024-11-18 20:00:34'),
(39, 39, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:00:49', '2024-11-18 20:00:49'),
(40, 40, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:01:05', '2024-11-18 20:01:05'),
(41, 41, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:01:20', '2024-11-18 20:01:20'),
(42, 42, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:01:46', '2024-11-18 20:01:46'),
(43, 43, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:02:14', '2024-11-18 20:02:14'),
(44, 44, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:02:34', '2024-11-18 20:02:34'),
(45, 45, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:02:49', '2024-11-18 20:02:49'),
(46, 46, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:03:08', '2024-11-18 20:03:08'),
(47, 47, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:03:33', '2024-11-18 20:03:33'),
(48, 48, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:03:48', '2024-11-18 20:03:48'),
(49, 49, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:04:01', '2024-11-18 20:04:01'),
(50, 50, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:04:15', '2024-11-18 20:04:15'),
(51, 51, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:04:28', '2024-11-18 20:04:28'),
(52, 52, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:04:42', '2024-11-18 20:04:42'),
(53, 53, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:05:07', '2024-11-18 20:05:07'),
(54, 54, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:05:20', '2024-11-18 20:05:20'),
(55, 55, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:05:34', '2024-11-18 20:05:34'),
(56, 56, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:05:50', '2024-11-18 20:05:50'),
(57, 57, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:06:09', '2024-11-18 20:06:09'),
(58, 58, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:06:24', '2024-11-18 20:06:24'),
(59, 59, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:06:37', '2024-11-18 20:06:37'),
(60, 60, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:06:53', '2024-11-18 20:06:53'),
(61, 61, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:07:11', '2024-11-18 20:07:11'),
(62, 62, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:07:28', '2024-11-18 20:07:28'),
(63, 63, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:08:17', '2024-11-18 20:08:17'),
(64, 64, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:08:48', '2024-11-18 20:08:48'),
(65, 65, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:09:01', '2024-11-18 20:09:01'),
(66, 66, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:09:13', '2024-11-18 20:09:13'),
(67, 67, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:09:27', '2024-11-18 20:09:27'),
(68, 68, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:09:40', '2024-11-18 20:09:40'),
(69, 69, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:09:54', '2024-11-18 20:09:54'),
(70, 70, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:10:07', '2024-11-18 20:10:07'),
(71, 71, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:10:32', '2024-11-18 20:10:32'),
(72, 72, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:11:30', '2024-11-18 20:11:30'),
(73, 73, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:11:44', '2024-11-18 20:11:44'),
(74, 74, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:11:59', '2024-11-18 20:11:59'),
(75, 75, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:12:14', '2024-11-18 20:12:14'),
(76, 76, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:12:28', '2024-11-18 20:12:28'),
(77, 77, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:12:57', '2024-11-18 20:12:57'),
(78, 78, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:13:10', '2024-11-18 20:13:10'),
(79, 79, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:13:46', '2024-11-18 20:13:46'),
(80, 80, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:14:01', '2024-11-18 20:14:01'),
(81, 81, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:14:14', '2024-11-18 20:14:14'),
(82, 82, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:15:01', '2024-11-18 20:15:01'),
(83, 83, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:15:18', '2024-11-18 20:15:18'),
(84, 84, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:15:36', '2024-11-18 20:15:36'),
(85, 85, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:15:52', '2024-11-18 20:15:52'),
(86, 86, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:16:04', '2024-11-18 20:16:04'),
(87, 87, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:16:18', '2024-11-18 20:16:18'),
(88, 88, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:16:40', '2024-11-18 20:16:40'),
(89, 89, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:17:02', '2024-11-18 20:17:02'),
(90, 90, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:17:54', '2024-11-18 20:17:54'),
(91, 91, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:18:08', '2024-11-18 20:18:08'),
(92, 92, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:18:22', '2024-11-18 20:18:22'),
(93, 93, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:18:35', '2024-11-18 20:18:35'),
(94, 94, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:18:48', '2024-11-18 20:18:48'),
(95, 95, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:19:01', '2024-11-18 20:19:01'),
(96, 96, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:19:16', '2024-11-18 20:19:16'),
(97, 97, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:19:30', '2024-11-18 20:19:30'),
(98, 98, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:19:44', '2024-11-18 20:19:44'),
(99, 99, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:19:56', '2024-11-18 20:19:56'),
(100, 100, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:20:19', '2024-11-18 20:20:19'),
(101, 101, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:21:00', '2024-11-18 20:21:00'),
(102, 102, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:21:13', '2024-11-18 20:21:13'),
(103, 103, '\"[\\\"SCSR\\\"]\"', 1, '2024-11-18 20:21:25', '2024-11-18 20:21:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents_submitted`
--
-- ALTER TABLE `documents_submitted`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `documents_submitted_admission_id_foreign` (`admission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents_submitted`
--
ALTER TABLE `documents_submitted`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents_submitted`
--
-- ALTER TABLE `documents_submitted`
--   ADD CONSTRAINT `documents_submitted_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE;
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;