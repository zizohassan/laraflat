-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2017 at 10:47 AM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MyToyota`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `details` text COLLATE utf8_unicode_ci,
  `price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accessory_type_id` int(10) UNSIGNED NOT NULL,
  `title_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci,
  `details_ar` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `title`, `image`, `description`, `details`, `price`, `accessory_type_id`, `title_ar`, `description_ar`, `details_ar`) VALUES
(1, 'What is Lorem Ipsum?', 'uploads/accessoryType1.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', '3000', 1, 'ما فائدته ؟', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.'),
(2, 'What is Lorem Ipsum?', 'uploads/accessoryType2.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', '35000', 1, 'ما فائدته ؟', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. ', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. '),
(3, 'What is Lorem Ipsum?', 'uploads/accessoryType1.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', '1234567', 2, 'ما فائدته ؟', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. ', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. ');

-- --------------------------------------------------------

--
-- Table structure for table `accessories_types`
--

CREATE TABLE `accessories_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_id` int(10) UNSIGNED NOT NULL,
  `type_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accessories_types`
--

INSERT INTO `accessories_types` (`id`, `type`, `car_id`, `type_ar`) VALUES
(1, 'test', 1, 'تيست'),
(2, 'test2', 1, 'تيست2');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `governorates_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `lng`, `lat`, `governorates_id`) VALUES
(1, 'Kasr El Aini Teaching Hospital', '31.22921705', '30.03157558', 1),
(2, 'Al Sayyeda Zainab Mosque', '31.24183416', '30.03131551', 1),
(3, 'Al Sayeda Nafeesah Mosque', '31.25247717', '30.02239813', 1),
(4, 'Prince Mohamed Ali Palace', '31.22895956', '30.02745141', 1),
(5, 'Giza Zoo', '31.21374607', '30.02250961', 2),
(6, 'Universität Kairo', '31.20687962', '30.02236098', 2),
(7, 'Shooting Club', '31.20181561', '30.04539589', 2),
(8, 'Stanly', '31.23215675', '30.04324124', 3),
(9, 'maimy', '31.23215675', '30.04324124', 3);

-- --------------------------------------------------------

--
-- Table structure for table `area_id`
--

CREATE TABLE `area_id` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `working_from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `working_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area_id` int(10) UNSIGNED NOT NULL,
  `image` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `area_id`
--

INSERT INTO `area_id` (`id`, `name`, `address`, `working_from`, `working_to`, `phone`, `lng`, `lat`, `name_ar`, `address_ar`, `area_id`, `image`) VALUES
(1, 'test', 'test', '10', '10', '0123456789', '31.22921705', '30.03157558', NULL, NULL, 1, NULL),
(2, 'trest2', 'test2', '10', '10', '0123456789', '31.24183416', '30.03131551', NULL, NULL, 1, NULL),
(3, 'test3', 'test3', '10', '10', '0123456789', '31.21374607', '30.02250961', NULL, NULL, 6, NULL),
(4, 'test3', 'test3', 'test3', 'test3', 'test3', 'test3', 'test3', NULL, NULL, 8, NULL),
(5, 'test4', 'test4', 'test4', 'test4', 'test4', 'test4', 'test4', 'test4', 'test4', 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `available_colors`
--

CREATE TABLE `available_colors` (
  `id` int(10) UNSIGNED NOT NULL,
  `car_id` int(10) UNSIGNED NOT NULL,
  `color_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color_name_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `built_cars`
--

CREATE TABLE `built_cars` (
  `id` int(10) UNSIGNED NOT NULL,
  `car_model_id` int(10) UNSIGNED NOT NULL,
  `color_id` int(10) UNSIGNED NOT NULL,
  `receipt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_fee` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_cost` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `built_cars_accessories`
--

CREATE TABLE `built_cars_accessories` (
  `id` int(10) UNSIGNED NOT NULL,
  `built_car_id` int(10) UNSIGNED NOT NULL,
  `accessory_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(10) UNSIGNED NOT NULL,
  `cat_id` int(10) UNSIGNED NOT NULL,
  `car_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `starting_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_name_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year_start` int(11) DEFAULT NULL,
  `year_end` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `cat_id`, `car_name`, `starting_price`, `image`, `car_name_ar`, `year_start`, `year_end`) VALUES
(1, 1, 'test', '1000000', NULL, NULL, 1996, 'TillNow');

-- --------------------------------------------------------

--
-- Table structure for table `car_models`
--

CREATE TABLE `car_models` (
  `id` int(10) UNSIGNED NOT NULL,
  `model_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `starting_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_business` tinyint(1) NOT NULL,
  `car_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_name_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manual` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `manual_ar` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `car_models`
--

INSERT INTO `car_models` (`id`, `model_name`, `starting_price`, `is_business`, `car_id`, `image`, `model_name_ar`, `manual`, `manual_ar`) VALUES
(1, 'test corolla', '1000000', 0, 1, NULL, NULL, 'uploads/HelpFile.pdf', 'uploads/HelpFile.pdf'),
(2, 'test1', '123', 1, 1, '', NULL, 'uploads/HelpFile.pdf', 'uploads/HelpFile.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `car_packages`
--

CREATE TABLE `car_packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `starting_price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8_unicode_ci,
  `price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_model_id` int(10) UNSIGNED DEFAULT NULL,
  `title_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci,
  `details_ar` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_three_sixty_images`
--

CREATE TABLE `car_three_sixty_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_id` int(10) UNSIGNED DEFAULT NULL,
  `image_order` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_years`
--

CREATE TABLE `car_years` (
  `id` int(10) UNSIGNED NOT NULL,
  `car_id` int(10) UNSIGNED NOT NULL,
  `year_id` int(10) UNSIGNED NOT NULL,
  `end` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `car_years`
--

INSERT INTO `car_years` (`id`, `car_id`, `year_id`, `end`) VALUES
(1, 1, 1, 'tillnow');

-- --------------------------------------------------------

--
-- Table structure for table `categoris`
--

CREATE TABLE `categoris` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categoris`
--

INSERT INTO `categoris` (`id`, `category_name`, `created_at`, `updated_at`, `image`) VALUES
(1, 'testasda', NULL, NULL, NULL),
(2, 'test2', NULL, NULL, ' ');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(10) UNSIGNED NOT NULL,
  `available_color_id` int(10) UNSIGNED NOT NULL,
  `color_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comparison_elements`
--

CREATE TABLE `comparison_elements` (
  `id` int(10) UNSIGNED NOT NULL,
  `comparison_element` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comparison_section_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comparison_elements_values`
--

CREATE TABLE `comparison_elements_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `element_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comparison_element_id` int(10) UNSIGNED DEFAULT NULL,
  `car_model_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comparison_sections`
--

CREATE TABLE `comparison_sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configuration_plans`
--

CREATE TABLE `configuration_plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8_unicode_ci,
  `price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_model_id` int(10) UNSIGNED DEFAULT NULL,
  `title_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci,
  `details_ar` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `terms_confirmed` tinyint(1) NOT NULL,
  `api_token` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_feature` tinyint(1) NOT NULL,
  `account_type` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `reset_password_status` char(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `email`, `password`, `phone`, `device_token`, `terms_confirmed`, `api_token`, `email_feature`, `account_type`, `reset_password_status`, `full_name`) VALUES
(36, 'karim.abdelhameed@bluecrunch.com', '$2y$10$IEnrK7euF15SOBT0LWHQWetTBHWVR7Q0fhfBEEj9PER3MbLvd7GnO', '0108048823', NULL, 1, '8Sho46IWku4hCsBKPoyTfwdgIPOda5AFHfkWaWTr', 0, 'fleet', '', 'Abdel Aziz'),
(37, 'nora@sayed.com', '$2y$10$0O5ZsIdzQWdLPAk7WyKrWufISN6HcGwkJ65bpVG/lCgqkNPgw44I2', '0108048823', NULL, 1, '7xiMvpue9uQXHo6DwR445qxKUMVUwUgskwsgJZbA', 0, '', NULL, 'Abdel Aziz Hassan'),
(39, 'test@mail.com', '$2y$10$OuBDbLz7XN0a5ihOOzhLl.EK7167Z7GPOcVOvHzvC.3ryOMhiGeRe', NULL, NULL, 1, '0vycblmdPsNi3ZX8Nt6IBsSnVmBidhTxz7pPOo1k', 1, 'fleet', NULL, NULL),
(40, 'sh.harbr@gmail.com', '$2y$10$KjrgZKg3S4V82HAWA/7/sulqKxkXBKs7VX98KrwnxpKV21.q.UYRC', NULL, NULL, 1, 'NjZpnEOG0NDHCMyNj8Mkea0wojVKI0KCm5G9D6Ke', 1, 'personal', '', NULL),
(41, 'testuser@mail.com', '$2y$10$MJOuxgS/.5DEJHh7ZKMf0eVph2hb5/xYVCYDVi1.0fOFSfDkSNgyG', NULL, NULL, 1, 'FB0pKMClzdwYAeu13nHBwNSCqorJLa9upD4Iupl9', 1, '', NULL, NULL),
(42, 'amr.ahmed@bluecrunch.com', '$2y$10$gzqbcELh3Yt.lo4IcpPtyOafteZOapxl1lTUrfo.6PAr.9PxQS29a', '01111619647', NULL, 1, 'Yqb6Ul7qOWX8qDrPTuHWyqnwzzF7uMYsPHIVbFZy', 1, 'fleet', '1490021535', 'amr ahmed'),
(43, 'hueny@bluecrunch.com', '$2y$10$oE8LC.b50/B7W.zo/qMZzOF1qdRGQKzhuYUjrvka.mZnBM.RpgCsi', NULL, NULL, 1, 'ljdzZlA9MDf8EKUJl8sy92cAVCdYWm78sAc65k3X', 1, 'fleet', NULL, NULL),
(44, 'nora.sayed@bluecrunch.com', '$2y$10$wIIhaKDHNpcjUFPE1tHD5e6F/gGuby4eYgePTt9r7lv3Id./4AznG', NULL, NULL, 0, 'VkNrLhXV5xuBzo0CwwPZuP3Bms24NvOtKVDuXiLm', 1, 'personal', '1488801310', NULL),
(45, 'sh.sharbr@gmail.com', '$2y$10$Vb8Mj4j1ck2tLmYSjwCiNuhFCwW5yf8rf6KIh1JvEo.KFnoPPhQ3e', NULL, NULL, 0, 'ZDGenkwGReH17s5ZZLOREyzyUfGumbVxhWsK7rrS', 1, '', NULL, NULL),
(46, 'huney@bluecrunch.com', '$2y$10$ysAMVDRayAoquWv.bpQdlunFULKxyjtLwn2Y6DvlsMqPj0wDrXqG6', NULL, NULL, 0, 'Worw4tCdXCRinMqzqd5t10zfM8abNQWpTnEM3qZs', 1, 'fleet', NULL, NULL),
(47, 'sh.sharbrd@gmail.com', '$2y$10$ykcyAZS2wCGgtES6C0CB0eqcZ5bXHz6Bi.jWVCAKi0eM9mqDrX07K', NULL, NULL, 0, '5JXKieMVQvw8ttINbHqN3rlFI5KFONIfRU1xXKCM', 1, '', NULL, NULL),
(48, 'test2@mail.com', '$2y$10$VeHlsUPK8JtVAJIeAaLqne7vDWEzTRAbJOkdIJFpZ1.JzMz2XL0DO', NULL, NULL, 1, 'sh5u1Dsku1IVZjmzW4O88Pr5nJYEgCM1l6t2EeJa', 1, 'personal', NULL, NULL),
(49, 'test3@mail.com', '$2y$10$FCYyu2WlESLbQRS6l9nwuezIJ265uvwZpESiQdVwiajB1cN2F2aTK', NULL, NULL, 1, 'R8klXRecJi2zqgORddmPQfi8khiniI1e0iTt2gxb', 1, 'personal', NULL, NULL),
(50, 'test4@mail.com', '$2y$10$VGn433iHbPjD5gjqhkFrvuSu8nys3bXH3vBEC4PH3kbXoRTVR/mBG', NULL, NULL, 1, 'ormrC9Mpj9Zl5KHT3YgLASOFwqFSvkMnc4RsbTfb', 1, 'personal', NULL, NULL),
(51, 'test7@mail.com', '$2y$10$Yk3S7RztLLjI0qMJLk1bMO23WBziC.ve2yAhTD1nfV7i.NwuNxBgy', NULL, NULL, 1, 'lQH4z1XjygJ665plzyW1pXxvzL1nFlM87UjQHD9D', 1, 'fleet', NULL, NULL),
(52, 'test999@mail.com', '$2y$10$.5hLASpK8nVWpMd5y8loXu18JCPAPB3qlTYdqo4iaZu/QJTM8WExa', NULL, NULL, 1, 'PXi1DbN0U3ZYXgkHXjhXlDacIEKlfzubID7Rg3hI', 1, 'personal', NULL, NULL),
(53, 'test100@mail.com', '$2y$10$HWACX77lljon7Srp4Jyr5upg7g7/9RiKnytLVjZzokSlmSccxmJPu', NULL, NULL, 1, 'ok4vgq0wocn4QCoIATBf7NTMshW514PNm9Fr6qyz', 1, 'personal', NULL, NULL),
(54, 'ytyt@mail.com', '$2y$10$5AGzExP3TLtFgjUZfudo/uYKlK5Qr7njCBGblZbUaMhYnwt7hvJGG', NULL, NULL, 1, 'E7Jy3ZipXBOCjLPGM4XWsU6FvKgBkCoiHjyCnZuB', 1, 'fleet', NULL, NULL),
(55, 'dina.elshare@gmail.com', NULL, NULL, NULL, 0, 'Eot3Hc6ahqeXKnYct5SlryvBfP9m49bRv8X0bQ4q', 0, 'fleet', NULL, NULL),
(56, 'test@test.com', '$2y$10$U1I1Y2fH/gWcFPzwysuWA.CX4RRmw0PX6Uxw6bSGK6l3Yk4/yX5HG', '+201023434567', NULL, 1, 'szdiBEkCvyz605mQNskacBtywVyhtcq8332j7Alb', 0, 'fleet', '1490625929', 'Nora '),
(57, 'dina@bluecrunch.com', '$2y$10$mDQ8YiZFpARrMcgUnJlpsOOSJFoMsHHXDGnBN2JozDFzOwieNXmIi', NULL, NULL, 1, '7vxa6R74YkNOjJDdjIb9QPDiy4poLCBeiKy31lAs', 1, 'fleet', '1490021547', NULL),
(60, 'huney_saber@hotmail.com', NULL, NULL, NULL, 0, '8RHDtf9W7CsVUQc80m4zTxNBruM27nKG7fSmtfK3', 0, 'fleet', NULL, NULL),
(61, 'm_nezamy@hotmail.com', NULL, NULL, NULL, 0, 'qKMQ7Ermu5qyIdJRqPbbsxpKn9qCaQVUe0t8zjYk', 0, 'fleet', NULL, NULL),
(62, 'developer.mario.nassef@gmail.com', NULL, NULL, NULL, 0, 'H4COBTPPMhZlIOlUHj1B2qBADF0onGEGnpFtkCmi', 0, 'fleet', NULL, NULL),
(64, 'karim_karim785@yahoo.com', NULL, NULL, NULL, 0, 'X0O1BjE9VQJCLxWdUHA5UMLYls6YVflv0DAj2tbU', 0, 'fleet', NULL, 'KarimAbd Elhameed'),
(65, 'sh.harasdabr@gmail.com', '$2y$10$ZVURUTjj8557/gzuKfS34.dwVSNSCJX5FgQwOm2tD6oq84wc9K.YK', NULL, NULL, 1, 'UlOc5Vyq1Aebok2Wk9vGagLVVfWYcI5TZGMqgQlB', 1, '', NULL, '3mrAhmed'),
(66, 'bc@test.com', '$2y$10$.3y0YjwkD0HPYX4qiBpRnuUi07rq7wonvmXTOaHOWixeKled6t42q', NULL, NULL, 1, 'IcfpZmAaaxEoeVtAfYe22kslEhzEkM8mlySlA9ri', 1, 'personal', NULL, 'bl'),
(67, 'test_test@test.com', '$2y$10$A/c32ZxvMQeVrNCj.F2SueAryCd5FUlBZYOP5PnIa8V8Svx934C5i', NULL, NULL, 1, 'kuOFfmaHHHdfJvivzDylBIqZkx57BzRlpK05sXJ1', 1, 'personal', NULL, 'bluecrunch'),
(68, 'dinaso@bluecrunch.com', '$2y$10$qdYr7P7zpdrQsphirDnt0uenS/jtydShKPf7hSvuXmpwRBGTJ5kYu', NULL, NULL, 1, 'wNr4NsrNOVSyUjVEE0p9yptDvAxiG52rb3FgOnxH', 0, 'fleet', NULL, 'dina'),
(69, 'test_er@test.com', '$2y$10$ASv8TiKdXuLpi3.1KU90COAS0TIpo39szOZDPD9ATxv.E3I4v9XXS', NULL, NULL, 1, 'RiwVoILRYrOpYQFjXMfsqY3mYkf7P0w2SNFiNr49', 1, 'fleet', NULL, 'dina..bl@test.com'),
(70, 'mary.gaied@toyotaegypt.com.eg', '$2y$10$FhOnokY1gXuQWvVHaM4QLevHQH5grr1c63cgqdPfXMh9WDXVHJCHi', NULL, NULL, 1, 'UDaL4dg64AOUUiuAB3VYdJ1nXzZQBIrdDtdaHTQh', 1, 'personal', NULL, 'Mary Gaied'),
(71, 'do@bluecrunch.com', '$2y$10$WVNgimlTvzOKdpkMWSJPzuKtLXfUIb5huSYe2/pAhzDWjq8rFw236', NULL, NULL, 1, 'hYOqfVMtosd26IfplFkOTYaKm7KOI6BdI5Af8bFl', 0, 'personal', NULL, 'do'),
(72, 'mario.nasef@gmail.com', '$2y$10$6zR3uBF86N7xuKuHHyesHOcYT/mWd8PrtopikHE2qAQKX1eDkXzpO', NULL, NULL, 1, 'JsqzkD0eae6Rphcu4H1yHdZhw8e7NbhIxQfcxhza', 1, 'personal', NULL, 'dina'),
(73, 'dodi@gmail.com', '$2y$10$2U4iAXHCtLJ.l/0FCLto/O/WEiksvStjs97ZKKSknln/v48aDb1iK', NULL, NULL, 1, 'mkEuVNDh2OIBodQbBKZm5Zk2htBY008mWE3UJNhk', 0, 'fleet', NULL, 'schb'),
(74, 'dfhj@ghhj.com', '$2y$10$m.T2zWWYJju476DQmFQSH.tZk45RyK03lHgFXbppjDLVOJ/bAzg76', NULL, NULL, 0, 'jU4K5jaXOPvn3Gmj82fnzt65GZPQtUp2qYI00w9N', 0, 'fleet', NULL, 'diggjj'),
(75, 'nora@test.com', '$2y$10$L7bfgDHCrg.58KylYRwez.QtGMfXUs4NcJi8FrLlwcsFntrExNYh6', NULL, NULL, 0, 'YyBGGbIElfT6bv3qGaG0bukfb4gz0jWx1pseE7bC', 0, 'personal', NULL, 'nora'),
(76, 'testtest@gmail.com', '$2y$10$0zPj493Fc7ew59eGwa3xLujvmeeFgS/v6mlIz4e/xdcHnErKYqcRe', NULL, NULL, 1, 'aXPBiEhtTkADSHSAzZl6GHwLPjcMHOQFFNFX6aTG', 1, 'personal', NULL, 'test'),
(77, 'testtesttest@gmail.com', '$2y$10$gGme.gCbR8dsBNIGqYppsOZdRozBmTcltGZ3RWbQkEK.95DMU/kV.', NULL, NULL, 0, 'MzxKgASklnofxTjaoazXsXoq3vr4UzVuUrngGWzV', 1, 'personal', NULL, 'test'),
(78, 'testregister@gmail.com', '$2y$10$xIgx4OK6YFdfRdwu2ylV0ujWRUXLiWrDF9X9h6yEXRz0WJQOzf.Me', NULL, NULL, 0, 'QsN8D6btKjxDEaWrw6aPP5FiQCIorW3WXCTwYFzW', 1, 'personal', NULL, 'test register'),
(79, 'dinarrty@bluecrunch.com', '$2y$10$8cpKh58b.h2X7K7rMuTpqePwVY7l3RubrR5SMvwmgRjOcb7ktWZDS', NULL, NULL, 0, 'ev9JpNvWmkun5lZr8iVAHETk3LsTMdfoW2MpOCt5', 0, 'fleet', NULL, 'dina'),
(80, 'testtest@test.com', '$2y$10$B.9rkI/iprVTbA0cEI8/cOp0M6K1YDJizpmn9eyyNF1Tr7ApY99qW', NULL, NULL, 0, 'AFGTIBm6Ju5cwTyXBrVyhnfpwNbg2CrwrMQkIw77', 0, 'fleet', NULL, 'norasayed'),
(81, 'gshsjs@bdjsjs.com', '$2y$10$vrAurbJjNrgBUUPE5Q.VNuWuT9mjaF1sdaC.R8jviY8YBt6r3YgxK', NULL, NULL, 0, 'dzPLphoGfUmRzr5WsTbHOJNuraA0E0QNXzuYdxcK', 0, 'personal', NULL, 'ghzjs'),
(82, 'testtestt@test.com', '$2y$10$PjRHSxDyXmn2Nald5cH0v.osMwx94QII.mY0nx7TJsubteMvciEtG', NULL, NULL, 0, '3Iq3BWeVbUZ9CeU005mS2l80xrBHG7GWMowW49ZG', 0, 'fleet', NULL, 'testtest'),
(83, 'cghhj@fgghh.v', '$2y$10$g8JH2KNsGxtmLDKqiZqEbudS7JSGbYsYvQiPxUP2qlTFatPiJuemq', NULL, NULL, 0, 'QB85IJw8NDwuNw0KkXq1VmsY6g6FmA8LoM6W9ldo', 1, 'fleet', NULL, 'xghbb'),
(84, 'mytest@test.com', '$2y$10$OBTB7nwVHAze3Rzd7jWCyOj9oqMtTlnEO21mgMEhYVBbNgUdF3qdS', NULL, NULL, 0, '4YIrKiZ1Kr0OotchnVIED5uZkBugN7j9WfT9uQhD', 0, 'fleet', NULL, 'testtest'),
(85, 'newtest@test.com', '$2y$10$H563RtHgL68mwQ9uzxXnGuirQbqamf.A.RupoItGHrxZtjv101Z8e', NULL, NULL, 0, 'PjvvzOT7Eui9NWIPrb1oWDQ47Xh1G6ViFQj9K1Ki', 0, 'fleet', NULL, 'testtesttest'),
(86, 'bssn@hdjs.com', '$2y$10$3qXjGp6C1wuZ945N82U67eNZEIEvjSZn2D65PZNUpPuQFiSAa6tWG', NULL, NULL, 0, 'oR3e8NHvoKKy0122IGjSRtXm1MpvI2hObeCKMWRd', 0, 'personal', NULL, 'bsnzn'),
(87, 'test@mail2.com', '$2y$10$SsHialgbD7v2sRhajTFBLOkT7MrOJWgZi0EX/gLhQER9NAa1AIx/m', NULL, NULL, 0, 'IgPNmTNu7n3U4Tq2oc2XZ1y31IfPGNvW2m4am0h2', 1, 'personal', NULL, 'test'),
(88, 'user@mail.com', '$2y$10$.lG.7WTO77hyytZDJr/PQOT2wBiTh7UEO4qcOeNZ7yy0KQ3qjHTzC', NULL, NULL, 0, 'Hb7pInadkRvuQ26nwVbkCmd7r3IuvtYdEpw8Ywd8', 1, 'fleet', NULL, 'user'),
(89, 'sayed_hakam@yahoo.com', '$2y$10$t79RNMnlnedymCBFFJ/ZIetrgUDay0tp55OBsXVLXLBZBCfKvJC5q', NULL, NULL, 0, 'ECN7AHgl0yN1Hd4LSljmvoxz3BT0K7MV6fQbf1pG', 1, 'personal', NULL, 'sayed hakan'),
(90, 'test@mail3.com', '$2y$10$diQw1uQUYq7QsxMZ9FXWte3.qTvr2OHFdEIdboVbfaIhsr8k5IdQC', NULL, NULL, 0, 'FWqE91DnKLSRgmGZ1EayZVKAqNn58cwiARqfKNaN', 1, 'fleet', NULL, 'test'),
(91, 'test4@gmail.com', '$2y$10$.EGZe.4glm2Qy5pR6ugQGO8i9LKTyWJLOqjXektQtoDS8culhgb.2', '12345678912', NULL, 1, 'iljfS8pcrfRU3SKg0IhfDimAUD330JWtKW9RIxxk', 1, '', NULL, 'amr'),
(92, 'test5@mail.com', '$2y$10$DcrjAfHIGUvg8q6IqVRC9OMqncBo3uQON5Ur5kDz6TtxxwIhfKAKu', '0', NULL, 127, 'dOzs0ip4JGTSBPXtnD27To8MAUN8hsAKEmKbl8mS', 1, 'personal', NULL, 'amr'),
(93, 'testtestthentest@test.com', '$2y$10$9JSExWuB6UkBodNFP8v5DOuC5F9Ql4i6UewECBdyLbTcyTWZmqV4O', '01234563456', NULL, 0, 'JMK578gTEotRKApYVbRSBvzvdrW4I47tZ8Z7PHZw', 0, 'fleet', NULL, 'nora sayed ramadan'),
(94, 'huney@mail.com', '$2y$10$dRBDXiEZVqrj.vswnbB57Oc1qdKyaYPtvPekN0bcmIUh1rHCiFcQm', '0', NULL, 127, 'vDCAgzbF8A2dgg8oba1ihFyHpxfzrXidyLUcX8jK', 1, 'fleet', NULL, 'huney'),
(95, 'personal@test.com', '$2y$10$Y65glccpUMUVoe/OEZD.qO0/cfD6jBd6Ibo3X/1tIWgWtV3imn2b2', '01012345434', NULL, 0, 'gztSCUexfK7Cc9ZS5jTtLHncSIxy2P88hwOlUcJD', 0, 'personal', NULL, 'personal'),
(96, 'maaelward@yahoo.com', NULL, NULL, NULL, 0, 'IE558e4lOgy4Gqepz7p2kmStgAOrSvTyoV2YLfYJ', 0, 'fleet', NULL, 'NoraSayed'),
(97, 'georgenaiem1@gmail.com', NULL, NULL, NULL, 0, 'T3qIgtAfE5rVIJa1kYQ9uwt9Twwod8mbAoBISz39', 0, '', NULL, 'GeorgeNaiem');

-- --------------------------------------------------------

--
-- Table structure for table `customer_accessories`
--

CREATE TABLE `customer_accessories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `details` text COLLATE utf8_unicode_ci,
  `customer_vehicle_id` int(10) UNSIGNED DEFAULT NULL,
  `title_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci,
  `details_ar` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_vehicle`
--

CREATE TABLE `customer_vehicle` (
  `id` int(10) UNSIGNED NOT NULL,
  `vin_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `platte` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `kilometer` int(10) UNSIGNED DEFAULT NULL,
  `drive_license_image` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_license_image` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_license_number` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `drive_license_number` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer_vehicle`
--

INSERT INTO `customer_vehicle` (`id`, `vin_number`, `car_type`, `platte`, `image`, `model_year`, `customer_id`, `kilometer`, `drive_license_image`, `car_license_image`, `car_license_number`, `drive_license_number`) VALUES
(10, '123', 'asddfghjklaasd', 'asdasdasdasda', NULL, '12312', 40, 123, 'uploads/1.jpg', 'uploads/5.jpg', NULL, NULL),
(11, '123', 'asddfghjklaasd', 'asdasdasdasda', NULL, '12312', 40, 123, 'uploads/2.jpg', 'uploads/3.jpg', NULL, NULL),
(16, '9799', 'test1', 'dbbbx', 'uploads/Yj2Q0AnCRJZsdtxdHnB10.62945400 1489496510.jpg', '1993', 42, 50000, 'uploads/Yj2Q0AnCRJZsdtxdHnB10.62945400 1489496510.jpg', 'uploads/Yj2Q0AnCRJZsdtxdHnB10.62945400 1489496510.jpg', NULL, NULL),
(17, '123', 'asddfghjklaasd', 'asdasdasdasda', NULL, '12312', 40, 123, 'uploads/1.jpg', 'uploads/5.jpg', NULL, NULL),
(18, '123', 'asddfghjklaasd', 'asdasdasdasda', NULL, '12312', 40, 123, 'uploads/5.jpg', 'uploads/1.jpg', NULL, NULL),
(19, '123', 'asddfghjklaasd', 'asdasdasdasda', NULL, '12312', 40, 123, 'uploads/4.jpg', 'uploads/2.jpg', NULL, NULL),
(20, '75576', 'test1', 'Zhang', NULL, '1994', 42, 75, 'uploads/I4SvsiW0C00.jpg', 'uploads/oIlGTgF1UN8.jpg', NULL, NULL),
(21, '252525', 'test1', 'gig', NULL, '2015', 42, 20, 'uploads/gIKGlHiDJX10.jpg', 'uploads/6.jpg', NULL, NULL),
(86, 'zxfaefdasd', 'asddfghjklaasd', 'asdasdasdasda', NULL, '12312', 40, 123, 'uploads/bTDuZWAet9kab6D79lQU0.65448200 1489494334.jpg', 'uploads/9VYi5wDHAuUlPxpzCqGD0.65474700 1489494334.jpg', NULL, NULL),
(87, 'zxfaefdasd', 'asddfghjklaasd', 'asdasdasdasda', NULL, '12312', 40, 123, 'uploads/p802ddIJ4X63VNSezz3E0.05014700 1489494405.jpg', 'uploads/eKpIaTVb3mmg4ZoSpLhd0.05053300 1489494405.jpg', NULL, NULL),
(89, '5', 'test corolla', 'fhhj', NULL, '2011', 55, 5, 'uploads/bhM04meCFv2.jpg', 'uploads/xscWewUHEW2.jpg', NULL, NULL),
(90, '5', 'test1', 'hjjkk', NULL, '2014', 55, 2, 'uploads/zOT5B7YvrJ8.jpg', 'uploads/PB2cpeYxOr10.jpg', NULL, NULL),
(91, '2222', 'test1', 'ded233', NULL, '2012', 56, 122355888, 'uploads/fKqZ5O5Ap20.jpg', 'uploads/czOwvVJzqw2.jpg', NULL, NULL),
(92, '2525', 'test corolla', 'karim123', NULL, '2017', 64, 5252, 'uploads/8136sEWoTC6.jpg', 'uploads/2SXpEomOeH10.jpg', NULL, NULL),
(93, '45', 'test corolla', 'ags', NULL, '2017', 42, 45, 'uploads/YVqLSlArl25.jpg', 'uploads/0XbUMQrfgr6.jpg', NULL, NULL),
(94, '45', 'test1', 'asg', NULL, '2017', 42, 75, 'uploads/UIeXrTK9lw8.jpg', 'uploads/pizRCQr7Av2.jpg', NULL, NULL),
(95, '46', 'test corolla', 'ahah', NULL, '2017', 42, 56, 'uploads/gZLCsJ6h1S6.jpg', 'uploads/GCaaglNkqp7.jpg', NULL, NULL),
(96, '888', 'test corolla', 'ghj', NULL, '2013', 56, 555, 'uploads/rkW5SpyqAS7.jpg', 'uploads/CJgMgWbW5l5.jpg', NULL, NULL),
(97, '123456', 'test corolla', 'ccccc', NULL, '2015', 56, 10000, 'uploads/t3xgXR5Cj17.jpg', 'uploads/8nCG5yAx6x9.jpg', NULL, NULL),
(98, '55566', 'test corolla', 'ghhjjj', NULL, '2014', 55, 2800, 'uploads/TkWjipI9369.jpg', 'uploads/eht4D6MZuh1.jpg', NULL, NULL),
(99, '123345', 'test1', 'nknknl', NULL, '2012', 56, 1223, 'uploads/7NB7lbEV0H5.jpg', 'uploads/u66sZsFhEd2.jpg', NULL, NULL),
(100, '24343', 'test corolla', 'fhfjfj', NULL, '2014', 56, 5657, 'uploads/LnjZXqWSWG4.jpg', 'uploads/ParMKJDT6U5.jpg', NULL, NULL),
(101, '5589', 'test corolla', 'fdggg', NULL, '2014', 55, 7888, 'uploads/fcWMPz5zqT3.jpg', 'uploads/26LOmCPvg11.jpg', NULL, NULL),
(102, '8556', 'test1', 'rdgh', NULL, '2015', 60, 2586, 'uploads/rSTEm7dlas8.jpg', 'uploads/7T59D09DNe3.jpg', NULL, NULL),
(103, '222', 'test corolla', 'yuu', NULL, '2014', 60, 22, 'uploads/3rwwS6m1RP3.jpg', 'uploads/JKjFOdupXR1.jpg', NULL, NULL),
(104, '5454545464664646', 'test corolla', 'bxjjsj', NULL, '2014', 82, 878778, 'uploads/1fBGbxT0te10.jpg', 'uploads/tgFiWByn1E6.jpg', NULL, NULL),
(105, '515', 'test1', 'hdjjj', NULL, '2014', 84, 515, 'uploads/Oi6OMAojlR7.jpg', 'uploads/U9dQyFMP930.jpg', NULL, NULL),
(106, '5455', 'test corolla', 'ushd', NULL, '2014', 85, 245, 'uploads/dxyXHjvTEO8.jpg', 'uploads/wExZlQy1sj0.jpg', NULL, NULL),
(107, '84644664', 'test corolla', 'bzjzjz', NULL, '2013', 86, 87884, 'uploads/wgUCGoopGy4.jpg', 'uploads/aofMUxM7kz2.jpg', NULL, NULL),
(108, '464667', 'test corolla', 'sgshjs', NULL, '2016', 87, 56, 'uploads/rHjNbLxgoa2.jpg', 'uploads/AymTD6D3IZ10.jpg', NULL, NULL),
(109, '669', 'test1', 'hhj', NULL, '2017', 87, 80, 'uploads/2s5cWO1KnV2.jpg', 'uploads/9jVny8zLSd4.jpg', NULL, NULL),
(110, '963', 'test1', 'huuy', NULL, '2017', 88, 99, 'uploads/3DqtHeFPft10.jpg', 'uploads/pWn9BNIDah8.jpg', NULL, NULL),
(111, '566', 'test1', 'ggb', NULL, '2017', 90, 866, 'uploads/d6s2A0VzzZ6.jpg', 'uploads/1DaM3hrUQ010.jpg', NULL, NULL),
(112, '494646', 'test1', 'shshzh', NULL, '2017', 92, 45, 'uploads/cS548YZSyt10.jpg', 'uploads/y7yllgGInf4.jpg', NULL, NULL),
(113, '23445223', 'test1', 'mlfemlfml', NULL, '2013', 93, 123445, 'uploads/zugxibnZxH5.jpg', 'uploads/a1RJzN6aMb10.jpg', NULL, NULL),
(114, '564', 'test corolla', 'dgs', NULL, '2017', 94, 944, 'uploads/Nr1XwdT7Kv1.jpg', 'uploads/A5RMgWcHmw5.jpg', NULL, NULL),
(115, '33444', 'test1', 'cfvfvvv', NULL, '2012', 95, 23455, 'uploads/9qsPoUaClU3.jpg', 'uploads/3aKc84NraQ7.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE `dashboard` (
  `id` int(10) UNSIGNED NOT NULL,
  `title_ar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title_en` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(400) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dashboard`
--

INSERT INTO `dashboard` (`id`, `title_ar`, `title_en`, `description_ar`, `description_en`, `image`) VALUES
(2, 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean ', 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.\nإذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.\nومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.\nهذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,\n', '58e25bc033df1.jpg'),
(3, 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean ', 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.\nإذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.\nومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.\nهذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,\n', '58e25bc033df1.jpg'),
(4, 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean ', 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.\nإذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.\nومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.\nهذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,\n', '58e25bc033df1.jpg'),
(5, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(6, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(7, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(8, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(9, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(10, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(11, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(12, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(13, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(14, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(15, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(16, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg'),
(17, 'asdasd', 'asdasd', 'asdaasdasdasdasdasdasd', 'asdasdasd', '58e25bc033df1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `dealers`
--

CREATE TABLE `dealers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `working_hours_from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `working_hours_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `governorate_id` int(10) UNSIGNED NOT NULL,
  `working_days_to` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `working_days_from` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dealers`
--

INSERT INTO `dealers` (`id`, `name`, `address`, `working_hours_from`, `working_hours_to`, `phone`, `lng`, `lat`, `name_ar`, `address_ar`, `governorate_id`, `working_days_to`, `working_days_from`, `image`) VALUES
(1, 'test', 'test', 'test', 'test', 'test', '31.22921705', '30.03157558', 'test', 'test', 1, NULL, NULL, 'uploads/3M7YGFiXOGOdpakXHfAk.jpg'),
(2, 'test1', 'test1', 'test1', 'test1', 'test1', '31.24183416', '30.03131551', 'test1', 'test1', 1, NULL, NULL, 'uploads/6aecefe54d331d0fd1619ac9151c2112.jpg'),
(3, 'test2', 'test2', 'test2', 'test2', 'test2', '31.21374607', '30.02250961', 'test2', 'test2', 2, NULL, NULL, ''),
(4, 'test3', 'test3', 'test3', 'test3', 'test3', '31.20687962', '30.02236098', 'test3', 'test3', 2, NULL, NULL, ''),
(5, 'test4', 'test4', 'test4', 'test4', 'test4', '31.23215675', '30.04324124', 'test4', 'test4', 3, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `exterior_photos`
--

CREATE TABLE `exterior_photos` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geniue_parts`
--

CREATE TABLE `geniue_parts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8_unicode_ci,
  `details_ar` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `geniue_parts`
--

INSERT INTO `geniue_parts` (`id`, `title`, `title_ar`, `details`, `details_ar`) VALUES
(1, 'Where does it come from?', 'ما فائدته ؟', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.');

-- --------------------------------------------------------

--
-- Table structure for table `governorates`
--

CREATE TABLE `governorates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `governorates`
--

INSERT INTO `governorates` (`id`, `name`, `lng`, `lat`, `name_ar`) VALUES
(1, 'Cairo ', '31.23215675', '30.04324124', NULL),
(2, 'Giza', '31.20846748', '30.01024692', NULL),
(3, 'Alex', '31.23215675', '30.04324124', NULL),
(4, 'Estren', '30.0375279', '31.2344924', NULL),
(5, 'aswan', '31.2344924', '31.2344924', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `highlights`
--

CREATE TABLE `highlights` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `car_id` int(10) UNSIGNED DEFAULT NULL,
  `title_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `highlights_images`
--

CREATE TABLE `highlights_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `highlight_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(10) UNSIGNED NOT NULL,
  `start_year` int(11) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `start_year`, `end_year`) VALUES
(1, 1950, 1960),
(2, 1960, 1970),
(3, 1970, 1980),
(4, 1980, 1990),
(5, 1990, 2000),
(6, 2000, 2010),
(7, 2010, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `history_details`
--

CREATE TABLE `history_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `history_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history_details`
--

INSERT INTO `history_details` (`id`, `description`, `description_ar`, `image`, `year`, `history_id`) VALUES
(1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy ', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/History1.jpg', 1952, 1),
(2, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/history2.jpg', 1953, 1),
(3, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/history2.jpg', 1955, 1),
(4, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/history3.jpg', 1958, 1),
(5, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/History1.jpg', 1959, 1),
(6, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/history3.jpg', 1961, 2),
(7, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/history2.jpg', 1965, 2),
(8, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/history3.jpg', 1968, 2),
(9, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/history3.jpg', 1973, 3),
(10, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.', 'uploads/History1.jpg', 1977, 3),
(11, 'It is a long established fact that a reader will be distracted by the readable content of a page ', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. ', 'uploads/history2.jpg', 1983, 4),
(12, 'It is a long established fact that a reader will be distracted by the readable content of a page ', 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. ', 'uploads/history3.jpg', 1988, 4);

-- --------------------------------------------------------

--
-- Table structure for table `interior_photos`
--

CREATE TABLE `interior_photos` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintainance_types`
--

CREATE TABLE `maintainance_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kilometers` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `service_type_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `maintainance_types`
--

INSERT INTO `maintainance_types` (`id`, `service_type`, `kilometers`, `price`, `service_type_ar`) VALUES
(1, 'Test', '60', '3000', NULL),
(2, 'Test1', '70', '5000', NULL),
(3, 'Test2', '90', '4000', NULL),
(4, 'test7', '1000000', '100000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_07_21_095117_create_initial_tables', 1),
('2017_02_13_154143_modify_inital_tables', 1),
('2017_02_20_155323_create_comparison_elements_values_table', 1),
('2017_02_22_134839_add_email_feature_to_customers', 2),
('2017_02_26_120925_drop_milage_count_from_customers', 3),
('2017_02_26_134615_add_account_type_to_customers', 4),
('2017_02_26_141247_drop_customer_id_from_customers_accessories', 5),
('2017_02_26_142949_rename_customer_id_in_customers_accessories', 6),
('2017_02_21_165213_modify_360_images_table', 7),
('2017_02_22_174227_create_maintainance_table', 7),
('2017_02_26_152616_modify_test_drive_booking', 8),
('2017_02_26_153720_modify_customer_accessories', 9),
('2017_02_26_164339_modify_car_years', 10),
('2017_03_02_143540_add_lang_every_table_', 11),
('2017_03_05_130842_modify_year_to_integer', 12),
('2017_03_05_171059_modify_cars_years', 13),
('2017_03_05_182231_modify_dealers', 14),
('2017_03_07_122417_edit_database_structure_part3', 15),
('2017_03_07_155634_add_image_dealers', 16),
('2017_03_08_162735_modify_area_id_in_dealers', 17),
('2017_03_08_165145_modify_dealers_area_id', 18),
('2017_03_08_172315_add_ar_name_in_governorates', 19),
('2017_03_09_154315_modify_dealers_working_hours_days', 20),
('2017_03_09_164923_modify_dealers_add_image', 21),
('2017_03_13_160352_modify_database_structure_part4', 22),
('2017_03_14_121849_add_image_ar_in_dashboard', 23),
('2017_03_14_124159_add_image_ar_in_car', 24),
('2017_03_14_134008_remove_manual_from_cars', 25),
('2017_03_19_174517_change_first_last_name_in_customers', 26),
('2017_03_22_122908_create_genuine_spareparts', 27),
('2017_03_29_123702_edit_promotion_spareparts', 28);

-- --------------------------------------------------------

--
-- Table structure for table `offers_types`
--

CREATE TABLE `offers_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_type_details`
--

CREATE TABLE `offer_type_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `offer_type_id` int(10) UNSIGNED DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`id`, `image`, `image_ar`, `status`, `title`, `title_ar`, `description`, `description_ar`) VALUES
(1, 'uploads/vCTNsjspdd1fhKWuPtlE.jpg', 'uploads/vCTNsjspdd1fhKWuPtlE.jpg', '1', 'title', 'ما فائدته ؟', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.'),
(2, 'uploads/vMvuikCUwgO2c43U4Ix4.jpg', 'uploads/vMvuikCUwgO2c43U4Ix4.jpg', '1', 'title', 'ما فائدته ؟', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.'),
(3, 'uploads/vrFL8Q5Y5AshFCULeDfG.jpg', 'uploads/vrFL8Q5Y5AshFCULeDfG.jpg', '0', 'title', 'ما فائدته ؟', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.'),
(4, 'uploads/ZZG8MKsJ3Wkc8u4kLlFi.jpg', 'uploads/ZZG8MKsJ3Wkc8u4kLlFi.jpg', '1', 'title', 'ما فائدته ؟', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.'),
(5, 'uploads/x5feaUPCDolJyw0sbcxQ.jpg', 'uploads/x5feaUPCDolJyw0sbcxQ.jpg', '0', 'title', 'ما فائدته ؟', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.'),
(6, 'uploads/X6RX6h8iPKt2GsvFCILa.jpg', 'uploads/X6RX6h8iPKt2GsvFCILa.jpg', '1', 'title', 'ما فائدته ؟', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.');

-- --------------------------------------------------------

--
-- Table structure for table `quotes_requests`
--

CREATE TABLE `quotes_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` text COLLATE utf8_unicode_ci,
  `car_model_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spare_parts`
--

CREATE TABLE `spare_parts` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `details` text COLLATE utf8_unicode_ci,
  `price` int(11) DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci,
  `title_ar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details_ar` text COLLATE utf8_unicode_ci,
  `average_life_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `spare_parts`
--

INSERT INTO `spare_parts` (`id`, `image`, `title`, `description`, `details`, `price`, `description_ar`, `title_ar`, `details_ar`, `average_life_time`) VALUES
(1, 'uploads/1.jpg', 'Where does it come from?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 1000, NULL, NULL, NULL, 'two monthes'),
(2, 'uploads/2.jpg', 'Where does it come from?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)', 3000, NULL, NULL, NULL, 'two monthes'),
(3, 'uploads/3.jpg', 'Where does it come from?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 2000, NULL, NULL, NULL, '1 year'),
(4, 'uploads/4.jpg', 'Where does it come from?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 1500, NULL, NULL, NULL, '1 year'),
(5, 'uploads/5.jpg', 'Where does it come from?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', 1600, NULL, NULL, NULL, '1 year');

-- --------------------------------------------------------

--
-- Table structure for table `spare_parts_type`
--

CREATE TABLE `spare_parts_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_ar` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specs`
--

CREATE TABLE `specs` (
  `id` int(10) UNSIGNED NOT NULL,
  `spec_section` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specs_elements`
--

CREATE TABLE `specs_elements` (
  `id` int(10) UNSIGNED NOT NULL,
  `spec_element` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `specs_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_drive_booking`
--

CREATE TABLE `test_drive_booking` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `current_car_maker` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `current_car_model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `prefered_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `service_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_model_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `maintainance_types_id` int(10) UNSIGNED NOT NULL,
  `dealer_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `test_drive_booking`
--

INSERT INTO `test_drive_booking` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `current_car_maker`, `current_car_model`, `date`, `prefered_time`, `service_type`, `car_model_id`, `customer_id`, `maintainance_types_id`, `dealer_id`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 'morning', NULL, 1, 42, 1, 1),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-01', 'morning', NULL, 1, 42, 1, 1),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-01', 'morning', NULL, 1, 42, 1, 1),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-16', 'Morning', NULL, 1, 42, 1, 1),
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-16', 'Morning', NULL, 1, 42, 1, 1),
(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Morning', NULL, 1, 42, 1, 1),
(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-01', 'morning', NULL, 1, 42, 1, 1),
(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-22', 'Evening', NULL, 1, 56, 1, 1),
(11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-23', 'Evening', NULL, 1, 56, 3, 5),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-27', 'Evening', NULL, 1, 56, 1, 2),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-29', 'Evening', NULL, 1, 56, 1, 2),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-15', 'Morning', NULL, 1, 56, 1, 1),
(15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-22', 'Evening', NULL, 1, 56, 1, 5),
(16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-22', 'Evening', NULL, 1, 56, 1, 5),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-08', 'Evening', NULL, 1, 56, 1, 1),
(18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-08', 'Evening', NULL, 1, 56, 1, 1),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Morning', NULL, 1, 42, 1, 3),
(20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-23', 'Evening', NULL, 1, 56, 1, 2),
(21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-21', 'Evening', NULL, 1, 56, 1, 2),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-15', 'Evening', NULL, 1, 56, 1, 2),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-15', 'Evening', NULL, 1, 56, 1, 2),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-01', 'morning', 'arrgent', 1, 42, 2, 1),
(25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Afternon', 'Emergency', 1, 42, 2, 1),
(26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-19', 'Morning', 'Emergency', 1, 42, 2, 1),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Morning', 'Emergency', 1, 42, 2, 4),
(28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Morning', 'Regular', 1, 42, 2, 1),
(29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-08-16', 'Morning', 'Regular', 1, 56, 1, 1),
(30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'asd', 'asdadw', 1, 42, 3, 1),
(31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-21', 'Morning', 'Emergency', 1, 42, 3, 1),
(32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Afternon', 'Emergency', 1, 42, 1, 4),
(33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Evening', 'Emergency', 1, 42, 2, 1),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Morning', 'Regular', 1, 42, 1, 3),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Morning', 'Emergency', 1, 42, 1, 3),
(36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Morning', 'Emergency', 1, 42, 1, 4),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-23', 'Evening', 'Emergency', 1, 60, 3, 4),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01', 'Morning', 'Emergency', 1, 42, 1, 3),
(41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-22', 'Morning', 'Emergency', 1, 42, 1, 4),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-24', 'Morning', 'Regular', 1, 42, 1, 4),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-25', 'Afternon', 'Regular', 1, 42, 1, 2),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-25', 'Morning', 'Regular', 1, 56, 1, 4),
(45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-30', 'Afternon', 'Regular', 1, 70, 1, 4),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-04-13', 'Morning', 'Regular', 1, 56, 1, 4),
(47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-04-06', 'Morning', 'Emergency', 1, 56, 1, 2),
(48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-04-13', 'Morning', 'Regular', 1, 42, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Emad', 'admin@mail.com', '$2y$10$VkeZGdvgAE8iXNxoOh10v.Tex7T5YhsTciEQIAaqsGrVBnKO/m0T6', 'kbW6l8xBjIA30UjKtfFvnlwjppSmkg1qfa3uzTokJiorNWmqKK2Zc2MKs8c9', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warranty_descriptions`
--

CREATE TABLE `warranty_descriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `warranty_file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `element_id` int(10) UNSIGNED DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warranty_elements`
--

CREATE TABLE `warranty_elements` (
  `id` int(10) UNSIGNED NOT NULL,
  `element` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` int(10) UNSIGNED NOT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `year`) VALUES
(1, 1990),
(2, 1991),
(3, 1992);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accessories_accessory_type_id_foreign` (`accessory_type_id`);

--
-- Indexes for table `accessories_types`
--
ALTER TABLE `accessories_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accessories_types_car_id_foreign` (`car_id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_governorates_id_foreign` (`governorates_id`);

--
-- Indexes for table `area_id`
--
ALTER TABLE `area_id`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dealers_area_id_foreign` (`area_id`);

--
-- Indexes for table `available_colors`
--
ALTER TABLE `available_colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `available_colors_car_id_foreign` (`car_id`);

--
-- Indexes for table `built_cars`
--
ALTER TABLE `built_cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `built_cars_car_model_id_foreign` (`car_model_id`),
  ADD KEY `built_cars_color_id_foreign` (`color_id`);

--
-- Indexes for table `built_cars_accessories`
--
ALTER TABLE `built_cars_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `built_cars_accessories_built_car_id_foreign` (`built_car_id`),
  ADD KEY `built_cars_accessories_accessory_id_foreign` (`accessory_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cars_cat_id_foreign` (`cat_id`);

--
-- Indexes for table `car_models`
--
ALTER TABLE `car_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_models_car_id_foreign` (`car_id`);

--
-- Indexes for table `car_packages`
--
ALTER TABLE `car_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_packages_car_model_id_foreign` (`car_model_id`);

--
-- Indexes for table `car_three_sixty_images`
--
ALTER TABLE `car_three_sixty_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_three_sixty_images_car_id_foreign` (`car_id`);

--
-- Indexes for table `car_years`
--
ALTER TABLE `car_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_years_car_id_foreign` (`car_id`),
  ADD KEY `car_years_year_id_foreign` (`year_id`);

--
-- Indexes for table `categoris`
--
ALTER TABLE `categoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `colors_available_color_id_foreign` (`available_color_id`);

--
-- Indexes for table `comparison_elements`
--
ALTER TABLE `comparison_elements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comparison_elements_comparison_section_id_foreign` (`comparison_section_id`);

--
-- Indexes for table `comparison_elements_values`
--
ALTER TABLE `comparison_elements_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comparison_elements_values_comparison_element_id_foreign` (`comparison_element_id`),
  ADD KEY `comparison_elements_values_car_model_id_foreign` (`car_model_id`);

--
-- Indexes for table `comparison_sections`
--
ALTER TABLE `comparison_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configuration_plans`
--
ALTER TABLE `configuration_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `configuration_plans_car_model_id_foreign` (`car_model_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_api_token_unique` (`api_token`);

--
-- Indexes for table `customer_accessories`
--
ALTER TABLE `customer_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_accessories_customer_vehicle_id_foreign` (`customer_vehicle_id`);

--
-- Indexes for table `customer_vehicle`
--
ALTER TABLE `customer_vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_vehicle_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dealers`
--
ALTER TABLE `dealers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dealers_governorates_id_foreign` (`governorate_id`);

--
-- Indexes for table `exterior_photos`
--
ALTER TABLE `exterior_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exterior_photos_car_id_foreign` (`car_id`);

--
-- Indexes for table `geniue_parts`
--
ALTER TABLE `geniue_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `governorates`
--
ALTER TABLE `governorates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `governorates_name_unique` (`name`);

--
-- Indexes for table `highlights`
--
ALTER TABLE `highlights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `highlights_car_id_foreign` (`car_id`);

--
-- Indexes for table `highlights_images`
--
ALTER TABLE `highlights_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `highlights_images_highlight_id_foreign` (`highlight_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_details`
--
ALTER TABLE `history_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_details_history_id_foreign` (`history_id`);

--
-- Indexes for table `interior_photos`
--
ALTER TABLE `interior_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interior_photos_car_id_foreign` (`car_id`);

--
-- Indexes for table `maintainance_types`
--
ALTER TABLE `maintainance_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers_types`
--
ALTER TABLE `offers_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_type_details`
--
ALTER TABLE `offer_type_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offer_type_details_offer_type_id_foreign` (`offer_type_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes_requests`
--
ALTER TABLE `quotes_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotes_requests_car_model_id_foreign` (`car_model_id`);

--
-- Indexes for table `spare_parts`
--
ALTER TABLE `spare_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spare_parts_type`
--
ALTER TABLE `spare_parts_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spare_parts_type_car_id_foreign` (`car_id`);

--
-- Indexes for table `specs`
--
ALTER TABLE `specs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specs_car_id_foreign` (`car_id`);

--
-- Indexes for table `specs_elements`
--
ALTER TABLE `specs_elements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specs_elements_specs_id_foreign` (`specs_id`);

--
-- Indexes for table `test_drive_booking`
--
ALTER TABLE `test_drive_booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_drive_booking_car_model_id_foreign` (`car_model_id`),
  ADD KEY `test_drive_booking_customer_id_foreign` (`customer_id`),
  ADD KEY `dealer_id` (`dealer_id`),
  ADD KEY `maintainance_types_id` (`maintainance_types_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_car_id_foreign` (`car_id`);

--
-- Indexes for table `warranty_descriptions`
--
ALTER TABLE `warranty_descriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warranty_descriptions_element_id_foreign` (`element_id`);

--
-- Indexes for table `warranty_elements`
--
ALTER TABLE `warranty_elements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `accessories_types`
--
ALTER TABLE `accessories_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `area_id`
--
ALTER TABLE `area_id`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `available_colors`
--
ALTER TABLE `available_colors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `built_cars`
--
ALTER TABLE `built_cars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `built_cars_accessories`
--
ALTER TABLE `built_cars_accessories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `car_models`
--
ALTER TABLE `car_models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `car_packages`
--
ALTER TABLE `car_packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `car_three_sixty_images`
--
ALTER TABLE `car_three_sixty_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `car_years`
--
ALTER TABLE `car_years`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `categoris`
--
ALTER TABLE `categoris`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comparison_elements`
--
ALTER TABLE `comparison_elements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comparison_elements_values`
--
ALTER TABLE `comparison_elements_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comparison_sections`
--
ALTER TABLE `comparison_sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `configuration_plans`
--
ALTER TABLE `configuration_plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `customer_accessories`
--
ALTER TABLE `customer_accessories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_vehicle`
--
ALTER TABLE `customer_vehicle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `dealers`
--
ALTER TABLE `dealers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `exterior_photos`
--
ALTER TABLE `exterior_photos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `geniue_parts`
--
ALTER TABLE `geniue_parts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `governorates`
--
ALTER TABLE `governorates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `highlights`
--
ALTER TABLE `highlights`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `highlights_images`
--
ALTER TABLE `highlights_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `history_details`
--
ALTER TABLE `history_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `interior_photos`
--
ALTER TABLE `interior_photos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `maintainance_types`
--
ALTER TABLE `maintainance_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `offers_types`
--
ALTER TABLE `offers_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offer_type_details`
--
ALTER TABLE `offer_type_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `quotes_requests`
--
ALTER TABLE `quotes_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `spare_parts`
--
ALTER TABLE `spare_parts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `spare_parts_type`
--
ALTER TABLE `spare_parts_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `specs`
--
ALTER TABLE `specs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `specs_elements`
--
ALTER TABLE `specs_elements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `test_drive_booking`
--
ALTER TABLE `test_drive_booking`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `warranty_descriptions`
--
ALTER TABLE `warranty_descriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `warranty_elements`
--
ALTER TABLE `warranty_elements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessories`
--
ALTER TABLE `accessories`
  ADD CONSTRAINT `accessories_accessory_type_id_foreign` FOREIGN KEY (`accessory_type_id`) REFERENCES `accessories_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `accessories_types`
--
ALTER TABLE `accessories_types`
  ADD CONSTRAINT `accessories_types_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_governorates_id_foreign` FOREIGN KEY (`governorates_id`) REFERENCES `governorates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `available_colors`
--
ALTER TABLE `available_colors`
  ADD CONSTRAINT `available_colors_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `built_cars`
--
ALTER TABLE `built_cars`
  ADD CONSTRAINT `built_cars_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `built_cars_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `built_cars_accessories`
--
ALTER TABLE `built_cars_accessories`
  ADD CONSTRAINT `built_cars_accessories_accessory_id_foreign` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `built_cars_accessories_built_car_id_foreign` FOREIGN KEY (`built_car_id`) REFERENCES `built_cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `categoris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `car_models`
--
ALTER TABLE `car_models`
  ADD CONSTRAINT `car_models_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `car_packages`
--
ALTER TABLE `car_packages`
  ADD CONSTRAINT `car_packages_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `car_three_sixty_images`
--
ALTER TABLE `car_three_sixty_images`
  ADD CONSTRAINT `car_three_sixty_images_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `car_years`
--
ALTER TABLE `car_years`
  ADD CONSTRAINT `car_years_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `car_years_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `colors`
--
ALTER TABLE `colors`
  ADD CONSTRAINT `colors_available_color_id_foreign` FOREIGN KEY (`available_color_id`) REFERENCES `available_colors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comparison_elements`
--
ALTER TABLE `comparison_elements`
  ADD CONSTRAINT `comparison_elements_comparison_section_id_foreign` FOREIGN KEY (`comparison_section_id`) REFERENCES `comparison_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comparison_elements_values`
--
ALTER TABLE `comparison_elements_values`
  ADD CONSTRAINT `comparison_elements_values_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comparison_elements_values_comparison_element_id_foreign` FOREIGN KEY (`comparison_element_id`) REFERENCES `comparison_elements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `configuration_plans`
--
ALTER TABLE `configuration_plans`
  ADD CONSTRAINT `configuration_plans_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_accessories`
--
ALTER TABLE `customer_accessories`
  ADD CONSTRAINT `customer_accessories_customer_vehicle_id_foreign` FOREIGN KEY (`customer_vehicle_id`) REFERENCES `customer_vehicle` (`id`);

--
-- Constraints for table `customer_vehicle`
--
ALTER TABLE `customer_vehicle`
  ADD CONSTRAINT `customer_vehicle_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dealers`
--
ALTER TABLE `dealers`
  ADD CONSTRAINT `dealers_governorates_id_foreign` FOREIGN KEY (`governorate_id`) REFERENCES `governorates` (`id`);

--
-- Constraints for table `exterior_photos`
--
ALTER TABLE `exterior_photos`
  ADD CONSTRAINT `exterior_photos_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `highlights`
--
ALTER TABLE `highlights`
  ADD CONSTRAINT `highlights_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `highlights_images`
--
ALTER TABLE `highlights_images`
  ADD CONSTRAINT `highlights_images_highlight_id_foreign` FOREIGN KEY (`highlight_id`) REFERENCES `highlights` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `history_details`
--
ALTER TABLE `history_details`
  ADD CONSTRAINT `history_details_history_id_foreign` FOREIGN KEY (`history_id`) REFERENCES `history` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interior_photos`
--
ALTER TABLE `interior_photos`
  ADD CONSTRAINT `interior_photos_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offer_type_details`
--
ALTER TABLE `offer_type_details`
  ADD CONSTRAINT `offer_type_details_offer_type_id_foreign` FOREIGN KEY (`offer_type_id`) REFERENCES `offers_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotes_requests`
--
ALTER TABLE `quotes_requests`
  ADD CONSTRAINT `quotes_requests_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `spare_parts_type`
--
ALTER TABLE `spare_parts_type`
  ADD CONSTRAINT `spare_parts_type_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `specs`
--
ALTER TABLE `specs`
  ADD CONSTRAINT `specs_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `specs_elements`
--
ALTER TABLE `specs_elements`
  ADD CONSTRAINT `specs_elements_specs_id_foreign` FOREIGN KEY (`specs_id`) REFERENCES `specs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `test_drive_booking`
--
ALTER TABLE `test_drive_booking`
  ADD CONSTRAINT `test_drive_booking_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_drive_booking_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `test_drive_booking_ibfk_1` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `test_drive_booking_ibfk_2` FOREIGN KEY (`maintainance_types_id`) REFERENCES `maintainance_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warranty_descriptions`
--
ALTER TABLE `warranty_descriptions`
  ADD CONSTRAINT `warranty_descriptions_element_id_foreign` FOREIGN KEY (`element_id`) REFERENCES `warranty_elements` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
