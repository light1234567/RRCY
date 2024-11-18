-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 09:23 PM
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
-- Table structure for table `clients`
--

-- CREATE TABLE `clients` (
--   `id` mediumint(8) UNSIGNED NOT NULL,
--   `first_name` varchar(20) NOT NULL,
--   `middle_name` varchar(15) DEFAULT NULL,
--   `last_name` varchar(15) NOT NULL,
--   `suffix` varchar(3) DEFAULT NULL,
--   `sex` varchar(20) NOT NULL,
--   `date_of_birth` date NOT NULL,
--   `place_of_birth` varchar(50) NOT NULL,
--   `province` varchar(20) NOT NULL,
--   `city` varchar(30) NOT NULL,
--   `barangay` varchar(30) NOT NULL,
--   `street` varchar(60) DEFAULT NULL,
--   `religion` varchar(20) DEFAULT NULL,
--   `child_status` varchar(35) DEFAULT NULL,
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `middle_name`, `last_name`, `suffix`, `sex`, `date_of_birth`, `place_of_birth`, `province`, `city`, `barangay`, `street`, `religion`, `child_status`, `created_at`, `updated_at`) VALUES
(1, 'Khael', '', 'Dela Cruz', '', 'Male', '2014-11-12', 'Davao', 'DAVAO DEL NORTE', 'NEW CORELLA', 'Del Monte', 'San Isidro, CARMEN, DAVAO DEL NORTE', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:40:45', '2024-11-18 19:40:45'),
(2, 'Juan', '', 'Dela Cruz', '', 'Male', '2014-11-12', 'Davao', 'DAVAO DEL NORTE', 'NEW CORELLA', 'Del Monte', 'San Isidro, CARMEN, DAVAO DEL NORTE', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:40:45', '2024-11-18 19:40:45'),
(3, 'Jose', '', 'Rizal', 'Jr.', 'Male', '2013-02-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Alambre', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:43:56', '2024-11-18 19:43:56'),
(4, 'Carlos', '', 'Santos', '', 'Male', '2012-06-14', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Alambre', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:45:01', '2024-11-18 19:45:01'),
(5, 'Miguel', '', 'Lopez', '', 'Male', '2012-06-14', 'Davao', 'DAVAO DEL SUR', 'BANSALAN', 'Libertad', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:46:08', '2024-11-18 19:46:08'),
(6, 'Andres', '', 'Villanueva', '', 'Male', '2012-07-19', 'Davao', 'DAVAO DEL SUR', 'BANSALAN', 'Libertad', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:46:44', '2024-11-18 19:46:44'),
(7, 'Daniel', '', 'Ramos', '', 'Male', '2012-07-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:47:16', '2024-11-18 19:47:16'),
(8, 'Emmanuel', '', 'Garcia', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:48:26', '2024-11-18 19:48:26'),
(9, 'Gabriel', '', 'Moreno', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:48:50', '2024-11-18 19:48:50'),
(10, 'Elijah', '', 'Cruz', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:49:07', '2024-11-18 19:49:07'),
(11, 'Nathaniel', '', 'Reyes', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:49:23', '2024-11-18 19:49:23'),
(12, 'Christian', '', 'Bautista', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:49:38', '2024-11-18 19:49:38'),
(13, 'Michael', '', 'Navarro', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:49:53', '2024-11-18 19:49:53'),
(14, 'John Paul', '', 'Velasco', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:50:14', '2024-11-18 19:50:14'),
(15, 'Jerome', '', 'Mendoza', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:50:32', '2024-11-18 19:50:32'),
(16, 'Victor', '', 'Alonzo', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:50:45', '2024-11-18 19:50:45'),
(17, 'Marc Anthony', '', 'Perez', '', 'Male', '2010-01-19', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:51:03', '2024-11-18 19:51:03'),
(18, 'Dominic', '', 'Rivera', '', 'Male', '2009-06-09', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:51:33', '2024-11-18 19:51:33'),
(19, 'Edwin', '', 'Santiago', '', 'Male', '2009-06-09', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:51:52', '2024-11-18 19:51:52'),
(20, 'Felix', '', 'Torres', '', 'Male', '2009-06-09', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:52:07', '2024-11-18 19:52:07'),
(21, 'Jacob', '', 'De Guzman', '', 'Male', '2009-06-09', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:52:27', '2024-11-18 19:52:27'),
(22, 'Xander', '', 'Lim', '', 'Male', '2009-06-09', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:52:44', '2024-11-18 19:52:44'),
(23, 'Samuel', '', 'Chavez', '', 'Male', '2009-06-09', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:52:59', '2024-11-18 19:52:59'),
(24, 'Julius', '', 'Salvador', '', 'Male', '2009-06-09', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:53:13', '2024-11-18 19:53:13'),
(25, 'Rafael', '', 'Fernandez', '', 'Male', '2009-06-09', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:53:29', '2024-11-18 19:53:29'),
(26, 'Adrian', '', 'Gonzales', '', 'Male', '2009-06-09', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bago Oshiro', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:53:45', '2024-11-18 19:53:45'),
(27, 'Ezekiel', '', 'Castro', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:56:10', '2024-11-18 19:56:10'),
(28, 'Francis', '', 'Espinoza', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:56:25', '2024-11-18 19:56:25'),
(29, 'Joel', '', 'Pineda', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:57:33', '2024-11-18 19:57:33'),
(30, 'Mark Andrew', '', 'Tolentino', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:57:57', '2024-11-18 19:57:57'),
(31, 'Sebastian', '', 'Delgado', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:58:13', '2024-11-18 19:58:13'),
(32, 'Ismael', '', 'Carreon', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:58:41', '2024-11-18 19:58:41'),
(33, 'Matthew', '', 'Tamayo', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:58:55', '2024-11-18 19:58:55'),
(34, 'Arthur', '', 'Villafuerte', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:59:08', '2024-11-18 19:59:08'),
(35, 'Henry', '', 'Lucero', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:59:21', '2024-11-18 19:59:21'),
(36, 'Paul David', '', 'Mangubat', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:59:37', '2024-11-18 19:59:37'),
(37, 'Cyrus', '', 'Marquez', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 19:59:51', '2024-11-18 19:59:51'),
(38, 'Lorenzo', '', 'Aquino', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:00:34', '2024-11-18 20:00:34'),
(39, 'Noah', '', 'Valencia', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:00:49', '2024-11-18 20:00:49'),
(40, 'Ian', '', 'Delos Reyes', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:01:05', '2024-11-18 20:01:05'),
(41, 'Timothy', '', 'Palma', '', 'Male', '2008-06-17', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:01:20', '2024-11-18 20:01:20'),
(42, 'Dennis', '', 'Olivares', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:01:46', '2024-11-18 20:01:46'),
(43, 'Jayson', '', 'Capistrano', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:02:14', '2024-11-18 20:02:14'),
(44, 'Patrick', '', 'Malabanan', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:02:34', '2024-11-18 20:02:34'),
(45, 'Ethan', '', 'Magbanua', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:02:49', '2024-11-18 20:02:49'),
(46, 'Kevin', '', 'Alcaraz', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:03:08', '2024-11-18 20:03:08'),
(47, 'Rico', '', 'Javier', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:03:33', '2024-11-18 20:03:33'),
(48, 'Arnold', '', 'Yambao', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:03:48', '2024-11-18 20:03:48'),
(49, 'Bryan', '', 'Montemayor', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:04:01', '2024-11-18 20:04:01'),
(50, 'Zachary', '', 'Bautista', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:04:15', '2024-11-18 20:04:15'),
(51, 'Ronald', '', 'Fajardo', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:04:28', '2024-11-18 20:04:28'),
(52, 'Leonard', '', 'Sevilla', '', 'Male', '2007-06-05', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:04:42', '2024-11-18 20:04:42'),
(53, 'Daryl', '', 'Ignacio', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:05:07', '2024-11-18 20:05:07'),
(54, 'Hector', '', 'Rosal', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:05:20', '2024-11-18 20:05:20'),
(55, 'Jericho', '', 'Dimaunahan', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:05:34', '2024-11-18 20:05:34'),
(56, 'Romeo', '', 'Pacheco', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:05:50', '2024-11-18 20:05:50'),
(57, 'Angelo', '', 'Padilla', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:06:09', '2024-11-18 20:06:09'),
(58, 'Philip', '', 'Sison', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:06:24', '2024-11-18 20:06:24'),
(59, 'Eric', '', 'Solis', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:06:37', '2024-11-18 20:06:37'),
(60, 'Tristan', '', 'Barrios', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:06:53', '2024-11-18 20:06:53'),
(61, 'Diego', '', 'Manalo', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:07:11', '2024-11-18 20:07:11'),
(62, 'Enrico', '', 'De Castro', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:07:28', '2024-11-18 20:07:28'),
(63, 'Ian', '', 'Villamor', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:08:17', '2024-11-18 20:08:17'),
(64, 'Joshua', '', 'Mercado', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:08:48', '2024-11-18 20:08:48'),
(65, 'Allen', '', 'Daguman', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:09:01', '2024-11-18 20:09:01'),
(66, 'Clifford', '', 'Bagaoisan', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:09:13', '2024-11-18 20:09:13'),
(67, 'Ferdinand', '', 'Quinto', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:09:27', '2024-11-18 20:09:27'),
(68, 'Harold', '', 'Gozon', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:09:40', '2024-11-18 20:09:40'),
(69, 'Keith', '', 'Flores', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:09:54', '2024-11-18 20:09:54'),
(70, 'Leo', '', 'Villarosa', '', 'Male', '2006-06-12', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:10:07', '2024-11-18 20:10:07'),
(71, 'Martin', '', 'Gaviola', '', 'Male', '2005-06-08', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:10:32', '2024-11-18 20:10:32'),
(72, 'Oscar', '', 'Cabahug', '', 'Male', '2005-06-08', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:11:30', '2024-11-18 20:11:30'),
(73, 'Ruben', '', 'Lejano', '', 'Male', '2005-06-08', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:11:44', '2024-11-18 20:11:44'),
(74, 'Stephen', '', 'Guzman', '', 'Male', '2005-06-08', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:11:59', '2024-11-18 20:11:59'),
(75, 'Vicente', '', 'Almanza', '', 'Male', '2005-06-08', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:12:14', '2024-11-18 20:12:14'),
(76, 'Zion', '', 'Labrador', '', 'Male', '2005-06-08', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:12:28', '2024-11-18 20:12:28'),
(77, 'Antonio', '', 'Ventura', '', 'Male', '2005-06-08', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:12:56', '2024-11-18 20:12:56'),
(78, 'Raymond', '', 'Del Mundo', '', 'Male', '2005-06-08', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:13:10', '2024-11-18 20:13:10'),
(79, 'William', '', 'De Leon', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:13:46', '2024-11-18 20:13:46'),
(80, 'Cesar', '', 'Salonga', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:14:01', '2024-11-18 20:14:01'),
(81, 'Chris', '', 'De Guzman', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:14:14', '2024-11-18 20:14:14'),
(82, 'Darryl', '', 'Vergara', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:15:01', '2024-11-18 20:15:01'),
(83, 'Frederick', '', 'Ong', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:15:18', '2024-11-18 20:15:18'),
(84, 'Glenn', '', 'Matias', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:15:36', '2024-11-18 20:15:36'),
(85, 'Ivan', '', 'Vergara', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:15:52', '2024-11-18 20:15:52'),
(86, 'Jonas', '', 'Rosales', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:16:04', '2024-11-18 20:16:04'),
(87, 'Kevin', '', 'Salcedo', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:16:18', '2024-11-18 20:16:18'),
(88, 'Leandro', '', 'Pineda', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:16:40', '2024-11-18 20:16:40'),
(89, 'Maximo', '', 'Cabrera', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:17:02', '2024-11-18 20:17:02'),
(90, 'Neil', '', 'Robles', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:17:54', '2024-11-18 20:17:54'),
(91, 'Oliver', '', 'Mendoza', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:18:08', '2024-11-18 20:18:08'),
(92, 'Paolo', '', 'Francisco', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:18:22', '2024-11-18 20:18:22'),
(93, 'Quintin', '', 'Cruz', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:18:35', '2024-11-18 20:18:35'),
(94, 'Reynaldo', '', 'Medina', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:18:48', '2024-11-18 20:18:48'),
(95, 'Simeon', '', 'Beltran', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:19:01', '2024-11-18 20:19:01'),
(96, 'Troy', '', 'Pascual', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:19:16', '2024-11-18 20:19:16'),
(97, 'Ulrich', '', 'De Vera', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:19:30', '2024-11-18 20:19:30'),
(98, 'Vince', '', 'Cordero', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:19:44', '2024-11-18 20:19:44'),
(99, 'Wilfred', '', 'Tabayoyong', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Discharge', '2024-11-18 20:19:56', '2024-11-18 20:19:56'),
(100, 'Xavier', '', 'Buenaventura', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Leave without Permission (LWOP)', '2024-11-18 20:20:19', '2024-11-18 20:20:19'),
(101, 'Alfredo', '', 'Lagman', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:21:00', '2024-11-18 20:21:00'),
(102, 'Jeremiah', '', 'Soriano', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:21:13', '2024-11-18 20:21:13'),
(103, 'Nelson', '', 'Villareal', '', 'Male', '2004-06-10', 'Davao', 'DAVAO DEL SUR', 'CITY OF DAVAO', 'Bayabas', 'st. 23, prk-2', 'Christianity', 'Still at the Center (SATC)', '2024-11-18 20:21:25', '2024-11-18 20:21:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
-- ALTER TABLE `clients`
--   ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
