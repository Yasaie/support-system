-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2018 at 05:16 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravelticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'city', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(2, 'config.general', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(3, 'config.email', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(4, 'config.ticket', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(5, 'config.sms', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(6, 'config.template', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(7, 'country', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(8, 'department', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(9, 'faq', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(10, 'media', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(11, 'news', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(12, 'notification', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(13, 'permission', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(14, 'province', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(15, 'role', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(16, 'ticket', '2018-06-13 10:43:32', '2018-06-13 10:43:32'),
(17, 'user', '2018-06-13 10:43:32', '2018-06-13 10:43:32')
ON DUPLICATE KEY UPDATE name=name;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
