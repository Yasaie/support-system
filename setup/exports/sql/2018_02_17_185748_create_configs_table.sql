-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2018 at 08:54 PM
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
-- Table structure for table `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'patronic', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(2, 'site_logo_src', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(3, 'site_logo_alt', 'patronic', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(4, 'main_address', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(5, 'site_address', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(6, 'site_description', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(7, 'site_keywords', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(8, 'site_rules', 'ثبت نام شما صرفا جهت استفاده از سیستم تیکت (پشتیبانی) میباشد و تمامی فعالیت های شما ثبت و ضبط خواهد شد , در صورت سوء استفاده از سیستم و بی احترامی به افراد, این اطلاعات جهت پیگیری به سازمان دارای صلاحیت ارجاع داده خواهد شد.', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(9, 'site_landing_page_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(10, 'site_guest_ticket_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(11, 'site_registration_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(12, 'site_main_email', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(13, 'site_activities_email', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(14, 'site_smtp_server', 'localhost', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(15, 'site_smtp_port', '487', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(16, 'site_smtp_username', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(17, 'site_smtp_password', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(18, 'site_sms_username', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(19, 'site_sms_password', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(20, 'site_sms_number', NULL, '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(21, 'ticket_remove_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(22, 'ticket_attachment_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(23, 'ticket_attachment_file_formats', 'jpg|jpeg|png|txt|pdf|doc|gif|tif|webp', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(24, 'ticket_attachment_file_size', '5', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(25, 'ticket_attachment_file_count', '2', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(26, 'ticket_department_substitution_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(27, 'ticket_rating_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(28, 'user_close_ticket_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(29, 'user_remove_ticket_status', '0', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(30, 'staff_close_ticket_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(31, 'staff_remove_ticket_status', '1', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(32, 'core_version', '1.5.0 beta', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(33, 'email_verification_status', '0', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(34, 'mobile_verification_status', '0', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(35, 'email_notification_status', '0', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(36, 'sms_notification_status', '0', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(37, 'widget1_title', 'پشتیبانی چه روزهایی انجام میشود', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(38, 'widget1_content', 'شنبه تا چهارشنبه', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(39, 'widget2_title', 'در چه ساعاتی پشتیبانی ارائه میشود', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(40, 'widget2_content', '8 تا 18', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(41, 'widget3_title', 'شماره های تماس واحد پشتیبانی', '2018-06-16 13:51:22', '2018-06-16 13:51:22'),
(42, 'widget3_content', '021-23549863', '2018-06-16 13:51:22', '2018-06-16 13:51:22')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`),`value`=VALUES(`value`);

--
-- Update core version
--

UPDATE `configs` SET `value`='1.5.0 beta' WHERE `name`='core_version';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `configs_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
