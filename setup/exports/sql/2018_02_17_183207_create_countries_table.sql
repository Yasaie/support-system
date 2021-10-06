-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2018 at 07:23 AM
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
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `short_name`, `name`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'Afghanistan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(2, 'AL', 'Albania', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(3, 'DZ', 'Algeria', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(4, 'DS', 'American Samoa', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(5, 'AD', 'Andorra', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(6, 'AO', 'Angola', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(7, 'AI', 'Anguilla', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(8, 'AQ', 'Antarctica', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(9, 'AG', 'Antigua and/or Barbuda', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(10, 'AR', 'Argentina', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(11, 'AM', 'Armenia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(12, 'AW', 'Aruba', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(13, 'AU', 'Australia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(14, 'AT', 'Austria', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(15, 'AZ', 'Azerbaijan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(16, 'BS', 'Bahamas', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(17, 'BH', 'Bahrain', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(18, 'BD', 'Bangladesh', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(19, 'BB', 'Barbados', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(20, 'BY', 'Belarus', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(21, 'BE', 'Belgium', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(22, 'BZ', 'Belize', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(23, 'BJ', 'Benin', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(24, 'BM', 'Bermuda', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(25, 'BT', 'Bhutan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(26, 'BO', 'Bolivia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(27, 'BA', 'Bosnia and Herzegovina', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(28, 'BW', 'Botswana', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(29, 'BV', 'Bouvet Island', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(30, 'BR', 'Brazil', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(31, 'IO', 'British lndian Ocean Territory', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(32, 'BN', 'Brunei Darussalam', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(33, 'BG', 'Bulgaria', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(34, 'BF', 'Burkina Faso', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(35, 'BI', 'Burundi', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(36, 'KH', 'Cambodia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(37, 'CM', 'Cameroon', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(38, 'CA', 'Canada', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(39, 'CV', 'Cape Verde', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(40, 'KY', 'Cayman Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(41, 'CF', 'Central African Republic', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(42, 'TD', 'Chad', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(43, 'CL', 'Chile', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(44, 'CN', 'China', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(45, 'CX', 'Christmas Island', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(46, 'CC', 'Cocos (Keeling) Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(47, 'CO', 'Colombia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(48, 'KM', 'Comoros', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(49, 'CG', 'Congo', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(50, 'CK', 'Cook Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(51, 'CR', 'Costa Rica', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(52, 'HR', 'Croatia (Hrvatska)', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(53, 'CU', 'Cuba', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(54, 'CY', 'Cyprus', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(55, 'CZ', 'Czech Republic', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(56, 'DK', 'Denmark', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(57, 'DJ', 'Djibouti', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(58, 'DM', 'Dominica', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(59, 'DO', 'Dominican Republic', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(60, 'TP', 'East Timor', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(61, 'EC', 'Ecuador', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(62, 'EG', 'Egypt', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(63, 'SV', 'El Salvador', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(64, 'GQ', 'Equatorial Guinea', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(65, 'ER', 'Eritrea', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(66, 'EE', 'Estonia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(67, 'ET', 'Ethiopia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(68, 'FK', 'Falkland Islands (Malvinas)', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(69, 'FO', 'Faroe Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(70, 'FJ', 'Fiji', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(71, 'FI', 'Finland', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(72, 'FR', 'France', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(73, 'FX', 'France, Metropolitan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(74, 'GF', 'French Guiana', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(75, 'PF', 'French Polynesia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(76, 'TF', 'French Southern Territories', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(77, 'GA', 'Gabon', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(78, 'GM', 'Gambia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(79, 'GE', 'Georgia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(80, 'DE', 'Germany', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(81, 'GH', 'Ghana', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(82, 'GI', 'Gibraltar', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(83, 'GR', 'Greece', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(84, 'GL', 'Greenland', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(85, 'GD', 'Grenada', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(86, 'GP', 'Guadeloupe', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(87, 'GU', 'Guam', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(88, 'GT', 'Guatemala', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(89, 'GN', 'Guinea', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(90, 'GW', 'Guinea-Bissau', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(91, 'GY', 'Guyana', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(92, 'HT', 'Haiti', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(93, 'HM', 'Heard and Mc Donald Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(94, 'HN', 'Honduras', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(95, 'HK', 'Hong Kong', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(96, 'HU', 'Hungary', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(97, 'IS', 'Iceland', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(98, 'IN', 'India', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(99, 'ID', 'Indonesia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(100, 'US', 'United state of America', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(101, 'IQ', 'Iraq', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(102, 'IR', 'جمهوری اسلامی ایران', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(103, 'IE', 'Ireland', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(104, 'IL', 'Israel', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(105, 'IT', 'Italy', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(106, 'CI', 'Ivory Coast', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(107, 'JM', 'Jamaica', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(108, 'JP', 'Japan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(109, 'JO', 'Jordan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(110, 'KZ', 'Kazakhstan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(111, 'KE', 'Kenya', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(112, 'KI', 'Kiribati', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(113, 'KP', 'Korea, Democratic People\'s Republic of', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(114, 'KR', 'Korea, Republic of', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(115, 'XK', 'Kosovo', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(116, 'KW', 'Kuwait', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(117, 'KG', 'Kyrgyzstan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(118, 'LA', 'Lao People\'s Democratic Republic', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(119, 'LV', 'Latvia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(120, 'LB', 'Lebanon', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(121, 'LS', 'Lesotho', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(122, 'LR', 'Liberia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(123, 'LY', 'Libyan Arab Jamahiriya', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(124, 'LI', 'Liechtenstein', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(125, 'LT', 'Lithuania', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(126, 'LU', 'Luxembourg', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(127, 'MO', 'Macau', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(128, 'MK', 'Macedonia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(129, 'MG', 'Madagascar', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(130, 'MW', 'Malawi', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(131, 'MY', 'Malaysia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(132, 'MV', 'Maldives', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(133, 'ML', 'Mali', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(134, 'MT', 'Malta', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(135, 'MH', 'Marshall Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(136, 'MQ', 'Martinique', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(137, 'MR', 'Mauritania', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(138, 'MU', 'Mauritius', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(139, 'TY', 'Mayotte', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(140, 'MX', 'Mexico', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(141, 'FM', 'Micronesia, Federated States of', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(142, 'MD', 'Moldova, Republic of', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(143, 'MC', 'Monaco', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(144, 'MN', 'Mongolia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(145, 'ME', 'Montenegro', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(146, 'MS', 'Montserrat', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(147, 'MA', 'Morocco', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(148, 'MZ', 'Mozambique', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(149, 'MM', 'Myanmar', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(150, 'NA', 'Namibia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(151, 'NR', 'Nauru', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(152, 'NP', 'Nepal', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(153, 'NL', 'Netherlands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(154, 'AN', 'Netherlands Antilles', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(155, 'NC', 'New Caledonia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(156, 'NZ', 'New Zealand', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(157, 'NI', 'Nicaragua', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(158, 'NE', 'Niger', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(159, 'NG', 'Nigeria', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(160, 'NU', 'Niue', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(161, 'NF', 'Norfork Island', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(162, 'MP', 'Northern Mariana Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(163, 'NO', 'Norway', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(164, 'OM', 'Oman', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(165, 'PK', 'Pakistan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(166, 'PW', 'Palau', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(167, 'PA', 'Panama', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(168, 'PG', 'Papua New Guinea', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(169, 'PY', 'Paraguay', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(170, 'PE', 'Peru', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(171, 'PH', 'Philippines', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(172, 'PN', 'Pitcairn', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(173, 'PL', 'Poland', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(174, 'PT', 'Portugal', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(175, 'PR', 'Puerto Rico', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(176, 'QA', 'Qatar', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(177, 'RE', 'Reunion', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(178, 'RO', 'Romania', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(179, 'RU', 'Russian Federation', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(180, 'RW', 'Rwanda', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(181, 'KN', 'Saint Kitts and Nevis', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(182, 'LC', 'Saint Lucia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(183, 'VC', 'Saint Vincent and the Grenadines', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(184, 'WS', 'Samoa', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(185, 'SM', 'San Marino', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(186, 'ST', 'Sao Tome and Principe', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(187, 'SA', 'Saudi Arabia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(188, 'SN', 'Senegal', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(189, 'RS', 'Serbia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(190, 'SC', 'Seychelles', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(191, 'SL', 'Sierra Leone', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(192, 'SG', 'Singapore', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(193, 'SK', 'Slovakia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(194, 'SI', 'Slovenia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(195, 'SB', 'Solomon Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(196, 'SO', 'Somalia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(197, 'ZA', 'South Africa', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(198, 'GS', 'South Georgia South Sandwich Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(199, 'ES', 'Spain', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(200, 'LK', 'Sri Lanka', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(201, 'SH', 'St. Helena', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(202, 'PM', 'St. Pierre and Miquelon', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(203, 'SD', 'Sudan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(204, 'SR', 'Suriname', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(205, 'SJ', 'Svalbarn and Jan Mayen Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(206, 'SZ', 'Swaziland', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(207, 'SE', 'Sweden', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(208, 'CH', 'Switzerland', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(209, 'SY', 'Syrian Arab Republic', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(210, 'TW', 'Taiwan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(211, 'TJ', 'Tajikistan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(212, 'TZ', 'Tanzania, United Republic of', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(213, 'TH', 'Thailand', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(214, 'TG', 'Togo', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(215, 'TK', 'Tokelau', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(216, 'TO', 'Tonga', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(217, 'TT', 'Trinidad and Tobago', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(218, 'TN', 'Tunisia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(219, 'TR', 'Turkey', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(220, 'TM', 'Turkmenistan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(221, 'TC', 'Turks and Caicos Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(222, 'TV', 'Tuvalu', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(223, 'UG', 'Uganda', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(224, 'UA', 'Ukraine', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(225, 'AE', 'United Arab Emirates', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(226, 'GB', 'United Kingdom', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(227, 'UM', 'United States minor outlying islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(228, 'UY', 'Uruguay', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(229, 'UZ', 'Uzbekistan', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(230, 'VU', 'Vanuatu', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(231, 'VA', 'Vatican City State', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(232, 'VE', 'Venezuela', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(233, 'VN', 'Vietnam', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(234, 'VG', 'Virgin Islands (British)', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(235, 'VI', 'Virgin Islands (U.S.)', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(236, 'WF', 'Wallis and Futuna Islands', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(237, 'EH', 'Western Sahara', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(238, 'YE', 'Yemen', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(239, 'YU', 'Yugoslavia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(240, 'ZR', 'Zaire', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(241, 'ZM', 'Zambia', '2018-05-10 00:44:04', '2018-05-10 00:44:04'),
(242, 'ZW', 'Zimbabwe', '2018-05-10 00:44:04', '2018-05-10 00:44:04')
ON DUPLICATE KEY UPDATE id=id;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_short_name_unique` (`short_name`),
  ADD UNIQUE KEY `countries_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
