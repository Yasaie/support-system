-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2018 at 07:42 AM
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
-- Database: `laravelticket-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE IF NOT EXISTS `provinces` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 102, 'آذربایجان شرقی', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(2, 102, 'آذربایجان غربی', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(3, 102, 'اردبیل', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(4, 102, 'اصفهان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(5, 102, 'البرز', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(6, 102, 'ایلام', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(7, 102, 'بوشهر', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(8, 102, 'تهران', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(9, 102, 'چهارمحال و بختیاری', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(10, 102, 'خراسان جنوبی', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(11, 102, 'خراسان رضوی', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(12, 102, 'خراسان شمالی', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(13, 102, 'خوزستان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(14, 102, 'زنجان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(15, 102, 'سمنان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(16, 102, 'سیستان و بلوچستان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(17, 102, 'فارس', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(18, 102, 'قزوین', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(19, 102, 'قم', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(20, 102, 'كردستان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(21, 102, 'كرمان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(22, 102, 'كرمانشاه', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(23, 102, 'کهگیلویه و بویراحمد', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(24, 102, 'گلستان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(25, 102, 'گیلان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(26, 102, 'لرستان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(27, 102, 'مازندران', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(28, 102, 'مركزی', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(29, 102, 'هرمزگان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(30, 102, 'همدان', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(31, 102, 'یزد', '2018-05-10 00:44:04', '2018-05-10 00:44:04')
ON DUPLICATE KEY UPDATE id=id;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provinces_country_id_foreign` (`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `provinces`
--
ALTER TABLE `provinces`
  ADD CONSTRAINT `provinces_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
