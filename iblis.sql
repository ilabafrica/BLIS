-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2016 at 09:08 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iblis`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_roles`
--

CREATE TABLE `assigned_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `assigned_roles`
--

INSERT INTO `assigned_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `barcode_settings`
--

CREATE TABLE `barcode_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `encoding_format` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `barcode_width` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `barcode_height` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `text_size` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `barcode_settings`
--

INSERT INTO `barcode_settings` (`id`, `encoding_format`, `barcode_width`, `barcode_height`, `text_size`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'code39', '2', '30', '11', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `controls`
--

CREATE TABLE `controls` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instrument_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `controls`
--

INSERT INTO `controls` (`id`, `name`, `description`, `instrument_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Humatrol P', 'HUMATROL P control serum has been designed to provide a suitable basis for the quality control (imprecision, inaccuracy) in the clinical chemical laboratory.', 1, '2016-06-09 08:20:44', '2016-06-09 08:20:44', NULL),
(2, 'Full Blood Count', 'Né pas touchér', 1, '2016-06-09 08:20:44', '2016-06-09 08:20:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `control_measures`
--

CREATE TABLE `control_measures` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `control_id` int(10) UNSIGNED NOT NULL,
  `control_measure_type_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `control_measures`
--

INSERT INTO `control_measures` (`id`, `name`, `unit`, `control_id`, `control_measure_type_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'ca', 'mmol', 1, 1, NULL, '2016-06-09 08:20:44', '2016-06-09 08:20:44'),
(2, 'pi', 'mmol', 1, 1, NULL, '2016-06-09 08:20:44', '2016-06-09 08:20:44'),
(3, 'mg', 'mmol', 1, 1, NULL, '2016-06-09 08:20:44', '2016-06-09 08:20:44'),
(4, 'na', 'mmol', 1, 1, NULL, '2016-06-09 08:20:44', '2016-06-09 08:20:44'),
(5, 'K', 'mmol', 1, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(6, 'WBC', 'x 103/uL', 2, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(7, 'RBC', 'x 106/uL', 2, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(8, 'HGB', 'g/dl', 2, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(9, 'HCT', '%', 2, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(10, 'MCV', 'fl', 2, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(11, 'MCH', 'pg', 2, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(12, 'MCHC', 'g/dl', 2, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(13, 'PLT', 'x 103/uL', 2, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `control_measure_ranges`
--

CREATE TABLE `control_measure_ranges` (
  `id` int(10) UNSIGNED NOT NULL,
  `upper_range` decimal(6,2) DEFAULT NULL,
  `lower_range` decimal(6,2) DEFAULT NULL,
  `alphanumeric` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `control_measure_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `control_measure_ranges`
--

INSERT INTO `control_measure_ranges` (`id`, `upper_range`, `lower_range`, `alphanumeric`, `control_measure_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '2.63', '7.19', NULL, 1, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(2, '11.65', '15.43', NULL, 2, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(3, '12.13', '19.11', NULL, 3, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(4, '15.73', '25.01', NULL, 4, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(5, '17.63', '20.12', NULL, 5, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(6, '6.50', '7.50', NULL, 6, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(7, '4.36', '5.78', NULL, 7, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(8, '13.80', '17.30', NULL, 8, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(9, '81.00', '95.00', NULL, 9, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(10, '1.99', '2.63', NULL, 10, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(11, '27.60', '33.00', NULL, 11, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(12, '32.80', '36.40', NULL, 12, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45'),
(13, '141.00', '320.00', NULL, 13, NULL, '2016-06-09 08:20:45', '2016-06-09 08:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `control_results`
--

CREATE TABLE `control_results` (
  `id` int(10) UNSIGNED NOT NULL,
  `results` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `control_measure_id` int(10) UNSIGNED NOT NULL,
  `control_test_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `control_results`
--

INSERT INTO `control_results` (`id`, `results`, `control_measure_id`, `control_test_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '2.78', 1, 1, 1, '2016-05-29 21:00:00', '2016-06-09 08:20:46'),
(2, '13.56', 2, 1, 1, '2016-05-29 21:00:00', '2016-06-09 08:20:46'),
(3, '14.77', 3, 1, 1, '2016-05-29 21:00:00', '2016-06-09 08:20:46'),
(4, '25.92', 4, 1, 1, '2016-05-29 21:00:00', '2016-06-09 08:20:46'),
(5, '18.87', 5, 1, 1, '2016-05-29 21:00:00', '2016-06-09 08:20:46'),
(6, '6.78', 1, 2, 1, '2016-05-30 21:00:00', '2016-06-09 08:20:46'),
(7, '15.56', 2, 2, 1, '2016-05-30 21:00:00', '2016-06-09 08:20:46'),
(8, '18.77', 3, 2, 1, '2016-05-30 21:00:00', '2016-06-09 08:20:46'),
(9, '30.92', 4, 2, 1, '2016-05-30 21:00:00', '2016-06-09 08:20:46'),
(10, '17.87', 5, 2, 1, '2016-05-30 21:00:00', '2016-06-09 08:20:46'),
(11, '8.78', 1, 3, 1, '2016-05-31 21:00:00', '2016-06-09 08:20:46'),
(12, '17.56', 2, 3, 1, '2016-05-31 21:00:00', '2016-06-09 08:20:46'),
(13, '21.77', 3, 3, 1, '2016-05-31 21:00:00', '2016-06-09 08:20:46'),
(14, '27.92', 4, 3, 1, '2016-05-31 21:00:00', '2016-06-09 08:20:46'),
(15, '22.87', 5, 3, 1, '2016-05-31 21:00:00', '2016-06-09 08:20:46'),
(16, '6.78', 1, 4, 1, '2016-06-01 21:00:00', '2016-06-09 08:20:46'),
(17, '18.56', 2, 4, 1, '2016-06-01 21:00:00', '2016-06-09 08:20:46'),
(18, '19.77', 3, 4, 1, '2016-06-01 21:00:00', '2016-06-09 08:20:46'),
(19, '12.92', 4, 4, 1, '2016-06-01 21:00:00', '2016-06-09 08:20:46'),
(20, '22.87', 5, 4, 1, '2016-06-01 21:00:00', '2016-06-09 08:20:46'),
(21, '3.78', 1, 5, 1, '2016-06-02 21:00:00', '2016-06-09 08:20:46'),
(22, '16.56', 2, 5, 1, '2016-06-02 21:00:00', '2016-06-09 08:20:46'),
(23, '17.77', 3, 5, 1, '2016-06-02 21:00:00', '2016-06-09 08:20:46'),
(24, '28.92', 4, 5, 1, '2016-06-02 21:00:00', '2016-06-09 08:20:46'),
(25, '19.87', 5, 5, 1, '2016-06-02 21:00:00', '2016-06-09 08:20:46'),
(26, '5.78', 1, 6, 1, '2016-06-03 21:00:00', '2016-06-09 08:20:46'),
(27, '15.56', 2, 6, 1, '2016-06-03 21:00:00', '2016-06-09 08:20:46'),
(28, '11.77', 3, 6, 1, '2016-06-03 21:00:00', '2016-06-09 08:20:46'),
(29, '29.92', 4, 6, 1, '2016-06-03 21:00:00', '2016-06-09 08:20:46'),
(30, '14.87', 5, 6, 1, '2016-06-03 21:00:00', '2016-06-09 08:20:46'),
(31, '9.78', 1, 7, 1, '2016-06-04 21:00:00', '2016-06-09 08:20:47'),
(32, '11.56', 2, 7, 1, '2016-06-04 21:00:00', '2016-06-09 08:20:47'),
(33, '19.77', 3, 7, 1, '2016-06-04 21:00:00', '2016-06-09 08:20:47'),
(34, '32.92', 4, 7, 1, '2016-06-04 21:00:00', '2016-06-09 08:20:47'),
(35, '29.87', 5, 7, 1, '2016-06-04 21:00:00', '2016-06-09 08:20:47'),
(36, '5.45', 6, 8, 1, '2016-06-05 21:00:00', '2016-06-09 08:20:47'),
(37, '5.01', 7, 8, 1, '2016-06-05 21:00:00', '2016-06-09 08:20:47'),
(38, '12.3', 8, 8, 1, '2016-06-05 21:00:00', '2016-06-09 08:20:47'),
(39, '89.7', 9, 8, 1, '2016-06-05 21:00:00', '2016-06-09 08:20:47'),
(40, '2.15', 10, 8, 1, '2016-06-05 21:00:00', '2016-06-09 08:20:47'),
(41, '34.0', 11, 8, 1, '2016-06-05 21:00:00', '2016-06-09 08:20:47'),
(42, '37.2', 12, 8, 1, '2016-06-05 21:00:00', '2016-06-09 08:20:47'),
(43, '141.5', 13, 8, 1, '2016-06-05 21:00:00', '2016-06-09 08:20:47'),
(44, '7.45', 6, 9, 1, '2016-06-06 21:00:00', '2016-06-09 08:20:47'),
(45, '9.01', 7, 9, 1, '2016-06-06 21:00:00', '2016-06-09 08:20:47'),
(46, '9.3', 8, 9, 1, '2016-06-06 21:00:00', '2016-06-09 08:20:47'),
(47, '94.7', 9, 9, 1, '2016-06-06 21:00:00', '2016-06-09 08:20:47'),
(48, '12.15', 10, 9, 1, '2016-06-06 21:00:00', '2016-06-09 08:20:47'),
(49, '37.0', 11, 9, 1, '2016-06-06 21:00:00', '2016-06-09 08:20:47'),
(50, '30.2', 12, 9, 1, '2016-06-06 21:00:00', '2016-06-09 08:20:47'),
(51, '121.5', 13, 9, 1, '2016-06-06 21:00:00', '2016-06-09 08:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `control_tests`
--

CREATE TABLE `control_tests` (
  `id` int(10) UNSIGNED NOT NULL,
  `control_id` int(10) UNSIGNED NOT NULL,
  `lot_id` int(10) UNSIGNED NOT NULL,
  `performed_by` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `control_tests`
--

INSERT INTO `control_tests` (`id`, `control_id`, `lot_id`, `performed_by`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Msiska', 1, '2016-05-29 21:00:00', '2016-06-09 08:20:45'),
(2, 1, 1, 'Katayi', 1, '2016-05-30 21:00:00', '2016-06-09 08:20:45'),
(3, 1, 1, 'Msiska', 1, '2016-05-31 21:00:00', '2016-06-09 08:20:45'),
(4, 1, 1, 'Kweyu', 1, '2016-06-01 21:00:00', '2016-06-09 08:20:45'),
(5, 1, 1, 'Kweyu', 1, '2016-06-02 21:00:00', '2016-06-09 08:20:45'),
(6, 1, 1, 'Tiwonge', 1, '2016-06-03 21:00:00', '2016-06-09 08:20:45'),
(7, 1, 1, 'Mukulu', 1, '2016-06-04 21:00:00', '2016-06-09 08:20:45'),
(8, 1, 1, 'Tiwonge', 1, '2016-06-05 21:00:00', '2016-06-09 08:20:45'),
(9, 1, 1, 'Tiwonge', 1, '2016-06-06 21:00:00', '2016-06-09 08:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `culture_worksheet`
--

CREATE TABLE `culture_worksheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `test_id` int(10) UNSIGNED NOT NULL,
  `observation` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

CREATE TABLE `diseases` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `diseases`
--

INSERT INTO `diseases` (`id`, `name`) VALUES
(1, 'Malaria'),
(2, 'Typhoid'),
(3, 'Shigella Dysentry');

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE `drugs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drug_susceptibility`
--

CREATE TABLE `drug_susceptibility` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `test_id` int(10) UNSIGNED NOT NULL,
  `organism_id` int(10) UNSIGNED NOT NULL,
  `drug_id` int(10) UNSIGNED NOT NULL,
  `zone` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `interpretation` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equip_config`
--

CREATE TABLE `equip_config` (
  `id` int(10) UNSIGNED NOT NULL,
  `equip_id` int(10) UNSIGNED NOT NULL,
  `prop_id` int(10) UNSIGNED NOT NULL,
  `prop_value` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `equip_config`
--

INSERT INTO `equip_config` (`id`, `equip_id`, `prop_id`, `prop_value`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '5150', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(2, 1, 2, 'client', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(3, 1, 3, 'chameleon', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(4, 1, 4, 'yes', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(5, 3, 5, '10', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(6, 3, 6, '9600', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(7, 3, 7, 'None', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(8, 3, 8, '1', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(9, 3, 9, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(10, 3, 10, '8', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(11, 3, 11, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(12, 2, 12, 'create ODBC datasource to the equipment db and put', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(13, 2, 13, '0', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(14, 4, 5, '10', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(15, 4, 6, '9600', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(16, 4, 7, 'None', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(17, 4, 8, '1', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(18, 4, 9, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(19, 4, 10, '8', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(20, 4, 11, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(21, 5, 1, '5150', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(22, 5, 2, 'server', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(23, 5, 3, 'no', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(24, 5, 4, 'set the Analyzer PC IP address here', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(25, 6, 14, '', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(26, 6, 15, '', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(27, 6, 16, '', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(28, 6, 17, '', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(29, 6, 18, '', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(30, 6, 19, '', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(31, 7, 5, '10', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(32, 7, 6, '9600', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(33, 7, 7, 'None', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(34, 7, 8, '1', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(35, 7, 9, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(36, 7, 10, '8', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(37, 7, 11, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(38, 8, 5, '10', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(39, 8, 6, '9600', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(40, 8, 7, 'None', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(41, 8, 8, '1', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(42, 8, 9, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(43, 8, 10, '8', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(44, 8, 11, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(45, 9, 1, '5150', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(46, 9, 2, 'server', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(47, 9, 3, 'no', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(48, 9, 4, 'set the Analyzer PC IP address here', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(49, 10, 5, '10', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(50, 10, 6, '9600', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(51, 10, 7, 'None', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(52, 10, 8, '1', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(53, 10, 9, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(54, 10, 10, '8', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(55, 10, 11, 'No', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(56, 11, 1, '5150', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(57, 11, 2, 'server', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(58, 11, 3, 'no', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(59, 11, 4, 'set the Analyzer PC IP address here', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(60, 12, 1, '5150', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(61, 12, 2, 'server', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(62, 12, 3, 'no', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(63, 12, 4, 'set the Analyzer PC IP address here', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `external_dump`
--

CREATE TABLE `external_dump` (
  `id` int(10) UNSIGNED NOT NULL,
  `lab_no` int(11) NOT NULL,
  `parent_lab_no` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `requesting_clinician` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `investigation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provisional_diagnosis` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request_date` timestamp NULL DEFAULT NULL,
  `order_stage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `result` text COLLATE utf8_unicode_ci,
  `result_returned` int(11) DEFAULT NULL,
  `patient_visit_number` int(11) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cost` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receipt_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receipt_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `waiver_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `system_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `external_dump`
--

INSERT INTO `external_dump` (`id`, `lab_no`, `parent_lab_no`, `test_id`, `requesting_clinician`, `investigation`, `provisional_diagnosis`, `request_date`, `order_stage`, `result`, `result_returned`, `patient_visit_number`, `patient_id`, `full_name`, `dob`, `gender`, `address`, `postal_code`, `phone_number`, `city`, `cost`, `receipt_number`, `receipt_type`, `waiver_no`, `system_id`, `created_at`, `updated_at`) VALUES
(1, 596699, 0, 16, 'frankenstein Dr', 'Urinalysis', '', '2014-10-14 07:20:35', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:38', '2016-06-09 08:20:38'),
(2, 596700, 596699, NULL, 'frankenstein Dr', 'Urine microscopy', '', '2014-10-14 07:20:35', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:38', '2016-06-09 08:20:38'),
(3, 596701, 596700, NULL, 'frankenstein Dr', 'Pus cells', '', '2014-10-14 07:20:35', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:38', '2016-06-09 08:20:38'),
(4, 596702, 596700, NULL, 'frankenstein Dr', 'S. haematobium', '', '2014-10-14 07:20:35', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(5, 596703, 596700, NULL, 'frankenstein Dr', 'T. vaginalis', '', '2014-10-14 07:20:35', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(6, 596704, 596700, NULL, 'frankenstein Dr', 'Yeast cells', '', '2014-10-14 07:20:35', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(7, 596705, 596700, NULL, 'frankenstein Dr', 'Red blood cells', '', '2014-10-14 07:20:35', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(8, 596706, 596700, NULL, 'frankenstein Dr', 'Bacteria', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(9, 596707, 596700, NULL, 'frankenstein Dr', 'Spermatozoa', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(10, 596708, 596700, NULL, 'frankenstein Dr', 'Epithelial cells', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(11, 596709, 596700, NULL, 'frankenstein Dr', 'ph', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(12, 596710, 596699, NULL, 'frankenstein Dr', 'Urine chemistry', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(13, 596711, 596710, NULL, 'frankenstein Dr', 'Glucose', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(14, 596712, 596710, NULL, 'frankenstein Dr', 'Ketones', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(15, 596713, 596710, NULL, 'frankenstein Dr', 'Proteins', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(16, 596714, 596710, NULL, 'frankenstein Dr', 'Blood', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(17, 596715, 596710, NULL, 'frankenstein Dr', 'Bilirubin', '', '2014-10-14 07:20:36', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(18, 596716, 596710, NULL, 'frankenstein Dr', 'Urobilinogen Phenlpyruvic acid', '', '2014-10-14 07:20:37', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(19, 596717, 596710, NULL, 'frankenstein Dr', 'pH', '', '2014-10-14 07:20:37', 'ip', NULL, NULL, 643660, 326983, 'Macau Macau', '1996-10-09 00:00:00', 'Female', NULL, '', '', NULL, NULL, NULL, NULL, '', 'sanitas', '2016-06-09 08:20:39', '2016-06-09 08:20:39');

-- --------------------------------------------------------

--
-- Table structure for table `external_users`
--

CREATE TABLE `external_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `internal_user_id` int(10) UNSIGNED NOT NULL,
  `external_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'WALTER REED', '2016-06-09 08:20:43', '2016-06-09 08:20:43'),
(2, 'AGA KHAN UNIVERSITY HOSPITAL', '2016-06-09 08:20:43', '2016-06-09 08:20:43'),
(3, 'TEL AVIV GENERAL HOSPITAL', '2016-06-09 08:20:43', '2016-06-09 08:20:43'),
(4, 'GK PRISON DISPENSARY', '2016-06-09 08:20:43', '2016-06-09 08:20:43'),
(5, 'KEMRI ALUPE', '2016-06-09 08:20:43', '2016-06-09 08:20:43'),
(6, 'AMPATH', '2016-06-09 08:20:43', '2016-06-09 08:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `ii_quickcodes`
--

CREATE TABLE `ii_quickcodes` (
  `id` int(10) UNSIGNED NOT NULL,
  `feed_source` tinyint(4) NOT NULL,
  `config_prop` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ii_quickcodes`
--

INSERT INTO `ii_quickcodes` (`id`, `feed_source`, `config_prop`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'PORT', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(2, 1, 'MODE', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(3, 1, 'CLIENT_RECONNECT', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(4, 1, 'EQUIPMENT_IP', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(5, 0, 'COMPORT', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(6, 0, 'BAUD_RATE', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(7, 0, 'PARITY', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(8, 0, 'STOP_BITS', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(9, 0, 'APPEND_NEWLINE', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(10, 0, 'DATA_BITS', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(11, 0, 'APPEND_CARRIAGE_RETURN', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(12, 2, 'DATASOURCE', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(13, 2, 'DAYS', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(14, 4, 'BASE_DIRECTORY', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(15, 4, 'USE_SUB_DIRECTORIES', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(16, 4, 'SUB_DIRECTORY_FORMAT', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(17, 4, 'FILE_NAME_FORMAT', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(18, 4, 'FILE_EXTENSION', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47'),
(19, 4, 'FILE_SEPERATOR', NULL, '2016-06-09 08:20:47', '2016-06-09 08:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `instruments`
--

CREATE TABLE `instruments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hostname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `instruments`
--

INSERT INTO `instruments` (`id`, `name`, `ip`, `hostname`, `description`, `driver_name`, `created_at`, `updated_at`) VALUES
(1, 'Celltac F Mek 8222', '192.168.1.12', 'HEMASERVER', 'Automatic analyzer with 22 parameters and WBC 5 part diff Hematology Analyzer', 'KBLIS\\Plugins\\CelltacFMachine', '2016-06-09 08:20:38', '2016-06-09 08:20:38'),
(2, 'Cellitac F Mek 8222', NULL, NULL, '', NULL, '2016-11-15 07:48:24', '2016-11-15 07:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `instrument_testtypes`
--

CREATE TABLE `instrument_testtypes` (
  `instrument_id` int(10) UNSIGNED NOT NULL,
  `test_type_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `instrument_testtypes`
--

INSERT INTO `instrument_testtypes` (`instrument_id`, `test_type_id`) VALUES
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `interfaced_equipment`
--

CREATE TABLE `interfaced_equipment` (
  `id` int(10) UNSIGNED NOT NULL,
  `equipment_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `comm_type` tinyint(4) NOT NULL,
  `equipment_version` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lab_section` int(10) UNSIGNED NOT NULL,
  `feed_source` tinyint(4) NOT NULL,
  `config_file` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `interfaced_equipment`
--

INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `equipment_version`, `lab_section`, `feed_source`, `config_file`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Mindray BS-200E', 2, '01.00.07', 1, 1, '\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000pluschameleon.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(2, 'ABX Pentra 60 C+', 2, '', 1, 2, '\\BLISInterfaceClient\\configs\\pentra\\pentra60cplus.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(3, 'ABX MACROS 60', 1, '', 1, 0, '\\BLISInterfaceClient\\configs\\micros60\\abxmicros60.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(4, 'BT 3000 Plus', 1, '', 1, 0, '\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000plus.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(5, 'Sysmex SX 500i', 1, '', 1, 1, '\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXS500i.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(6, 'BD FACSCalibur', 1, '', 1, 4, '\\BLISInterfaceClient\\configs\\BDFACSCalibur\\bdfacscalibur.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(7, 'Mindray BC 3600', 1, '', 1, 0, '\\BLISInterfaceClient\\configs\\mindray\\mindraybc3600.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(8, 'Selectra Junior', 1, '', 1, 0, '\\BLISInterfaceClient\\configs\\selectrajunior\\selectrajunior.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(9, 'GeneXpert', 2, '', 1, 1, '\\BLISInterfaceClient\\configs\\geneXpert\\genexpert.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(10, 'ABX Pentra 80', 2, '', 1, 0, '\\BLISInterfaceClient\\configs\\pentra80\\abxpentra80.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(11, 'Sysmex XT 2000i', 1, '', 1, 1, '\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXT2000i.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48'),
(12, 'Vitalex Flexor', 1, '', 1, 1, '\\BLISInterfaceClient\\configs\\flexorE\\flexore.xml', NULL, '2016-06-09 08:20:48', '2016-06-09 08:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `inv_items`
--

CREATE TABLE `inv_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `min_level` decimal(8,2) NOT NULL,
  `max_level` decimal(8,2) DEFAULT NULL,
  `storage_req` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_supply`
--

CREATE TABLE `inv_supply` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `lot` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `batch_no` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiry_date` datetime NOT NULL,
  `manufacturer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `quantity_ordered` int(11) NOT NULL DEFAULT '0',
  `quantity_supplied` int(11) NOT NULL DEFAULT '0',
  `cost_per_unit` decimal(5,2) DEFAULT NULL,
  `date_of_order` date DEFAULT NULL,
  `date_of_supply` date DEFAULT NULL,
  `date_of_reception` date NOT NULL,
  `remarks` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_usage`
--

CREATE TABLE `inv_usage` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `quantity_used` int(11) NOT NULL DEFAULT '0',
  `date_of_usage` date NOT NULL,
  `issued_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `received_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

CREATE TABLE `lots` (
  `id` int(10) UNSIGNED NOT NULL,
  `lot_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`id`, `lot_no`, `description`, `expiry`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '0001', 'First lot', '2016-12-09', NULL, '2016-06-09 08:20:44', '2016-06-09 08:20:44'),
(2, '0002', 'Second lot', '2017-01-09', NULL, '2016-06-09 08:20:44', '2016-06-09 08:20:44');

-- --------------------------------------------------------

--
-- Table structure for table `measures`
--

CREATE TABLE `measures` (
  `id` int(10) UNSIGNED NOT NULL,
  `measure_type_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `measures`
--

INSERT INTO `measures` (`id`, `measure_type_id`, `name`, `unit`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'BS for mps', '', NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29', NULL),
(2, 2, 'Grams stain', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(3, 2, 'SERUM AMYLASE', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(4, 2, 'calcium', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(5, 2, 'SGOT', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(6, 2, 'Indirect COOMBS test', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(7, 2, 'Direct COOMBS test', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(8, 2, 'Du test', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(9, 1, 'URIC ACID', 'mg/dl', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(10, 4, 'CSF for biochemistry', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(11, 4, 'PSA', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(12, 1, 'Total', 'mg/dl', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(13, 1, 'Alkaline Phosphate', 'u/l', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(14, 1, 'Direct', 'mg/dl', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(15, 1, 'Total Proteins', '', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(16, 4, 'LFTS', 'NULL', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(17, 1, 'Chloride', 'mmol/l', NULL, '2016-06-09 08:20:30', '2016-06-09 08:20:30', NULL),
(18, 1, 'Potassium', 'mmol/l', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(19, 1, 'Sodium', 'mmol/l', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(20, 4, 'Electrolytes', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(21, 1, 'Creatinine', 'mg/dl', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(22, 1, 'Urea', 'mg/dl', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(23, 4, 'RFTS', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(24, 4, 'TFT', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(25, 4, 'GXM', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(26, 2, 'Blood Grouping', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(27, 1, 'HB', 'g/dL', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(28, 4, 'Urine microscopy', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(29, 4, 'Pus cells', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(30, 4, 'S. haematobium', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(31, 4, 'T. vaginalis', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(32, 4, 'Yeast cells', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(33, 4, 'Red blood cells', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(34, 4, 'Bacteria', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(35, 4, 'Spermatozoa', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(36, 4, 'Epithelial cells', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(37, 4, 'ph', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(38, 4, 'Urine chemistry', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(39, 4, 'Glucose', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(40, 4, 'Ketones', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(41, 4, 'Proteins', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(42, 4, 'Blood', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(43, 4, 'Bilirubin', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(44, 4, 'Urobilinogen Phenlpyruvic acid', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(45, 4, 'pH', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(46, 1, 'WBC', 'x10³/µL', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(47, 1, 'Lym', 'L', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(48, 1, 'Mon', '*', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(49, 1, 'Neu', '*', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(50, 1, 'Eos', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(51, 1, 'Baso', '', NULL, '2016-06-09 08:20:31', '2016-06-09 08:20:31', NULL),
(52, 2, 'Salmonella Antigen Test', '', NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40', NULL),
(53, 2, 'Direct COOMBS Test', '', NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40', NULL),
(54, 2, 'Du Test', '', NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40', NULL),
(55, 2, 'Sickling Test', '', NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40', NULL),
(56, 2, 'Borrelia', '', NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40', NULL),
(57, 2, 'VDRL', '', NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40', NULL),
(58, 2, 'Pregnancy Test', '', NULL, '2016-06-09 08:20:41', '2016-06-09 08:20:41', NULL),
(59, 2, 'Brucella', '', NULL, '2016-06-09 08:20:41', '2016-06-09 08:20:41', NULL),
(60, 2, 'H. Pylori', '', NULL, '2016-06-09 08:20:41', '2016-06-09 08:20:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `measure_ranges`
--

CREATE TABLE `measure_ranges` (
  `id` int(10) UNSIGNED NOT NULL,
  `measure_id` int(10) UNSIGNED NOT NULL,
  `age_min` int(10) UNSIGNED DEFAULT NULL,
  `age_max` int(10) UNSIGNED DEFAULT NULL,
  `gender` tinyint(3) UNSIGNED DEFAULT NULL,
  `range_lower` decimal(7,3) DEFAULT NULL,
  `range_upper` decimal(7,3) DEFAULT NULL,
  `alphanumeric` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interpretation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `measure_ranges`
--

INSERT INTO `measure_ranges` (`id`, `measure_id`, `age_min`, `age_max`, `gender`, `range_lower`, `range_upper`, `alphanumeric`, `interpretation`, `deleted_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, 'No mps seen', 'Negative', NULL),
(2, 1, NULL, NULL, NULL, NULL, NULL, '+', 'Positive', NULL),
(3, 1, NULL, NULL, NULL, NULL, NULL, '++', 'Positive', NULL),
(4, 1, NULL, NULL, NULL, NULL, NULL, '+++', 'Positive', NULL),
(5, 2, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(6, 2, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(7, 3, NULL, NULL, NULL, NULL, NULL, 'Low', NULL, NULL),
(8, 3, NULL, NULL, NULL, NULL, NULL, 'High', NULL, NULL),
(9, 3, NULL, NULL, NULL, NULL, NULL, 'Normal', NULL, NULL),
(10, 4, NULL, NULL, NULL, NULL, NULL, 'High', NULL, NULL),
(11, 4, NULL, NULL, NULL, NULL, NULL, 'Low', NULL, NULL),
(12, 4, NULL, NULL, NULL, NULL, NULL, 'Normal', NULL, NULL),
(13, 5, NULL, NULL, NULL, NULL, NULL, 'High', NULL, NULL),
(14, 5, NULL, NULL, NULL, NULL, NULL, 'Low', NULL, NULL),
(15, 5, NULL, NULL, NULL, NULL, NULL, 'Normal', NULL, NULL),
(16, 6, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(17, 6, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(18, 7, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(19, 7, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(20, 8, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(21, 8, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(22, 26, NULL, NULL, NULL, NULL, NULL, 'O-', NULL, NULL),
(23, 26, NULL, NULL, NULL, NULL, NULL, 'O+', NULL, NULL),
(24, 26, NULL, NULL, NULL, NULL, NULL, 'A-', NULL, NULL),
(25, 26, NULL, NULL, NULL, NULL, NULL, 'A+', NULL, NULL),
(26, 26, NULL, NULL, NULL, NULL, NULL, 'B-', NULL, NULL),
(27, 26, NULL, NULL, NULL, NULL, NULL, 'B+', NULL, NULL),
(28, 26, NULL, NULL, NULL, NULL, NULL, 'AB-', NULL, NULL),
(29, 26, NULL, NULL, NULL, NULL, NULL, 'AB+', NULL, NULL),
(30, 46, 0, 100, 2, '4.000', '11.000', NULL, NULL, NULL),
(31, 47, 0, 100, 2, '1.500', '4.000', NULL, NULL, NULL),
(32, 48, 0, 100, 2, '0.100', '9.000', NULL, NULL, NULL),
(33, 49, 0, 100, 2, '2.500', '7.000', NULL, NULL, NULL),
(34, 50, 0, 100, 2, '0.000', '6.000', NULL, NULL, NULL),
(35, 51, 0, 100, 2, '0.000', '2.000', NULL, NULL, NULL),
(36, 52, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(37, 52, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(38, 53, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(39, 53, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(40, 54, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(41, 54, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(42, 55, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(43, 55, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(44, 56, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(45, 56, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(46, 57, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(47, 57, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(48, 58, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(49, 58, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(50, 59, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(51, 59, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL),
(52, 60, NULL, NULL, NULL, NULL, NULL, 'Positive', NULL, NULL),
(53, 60, NULL, NULL, NULL, NULL, NULL, 'Negative', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `measure_types`
--

CREATE TABLE `measure_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `measure_types`
--

INSERT INTO `measure_types` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Numeric Range', NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(2, 'Alphanumeric Values', NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(3, 'Autocomplete', NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(4, 'Free Text', NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29');

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
('2014_07_24_082711_CreatekBLIStables', 1),
('2014_09_02_114206_entrust_setup_tables', 1),
('2014_10_09_162222_externaldumptable', 1),
('2015_02_04_004704_add_index_to_parentlabno', 1),
('2015_02_11_112608_remove_unique_constraint_on_patient_number', 1),
('2015_02_17_104134_qc_tables', 1),
('2015_02_23_112018_create_microbiology_tables', 1),
('2015_03_16_155558_create_surveillance', 1),
('2015_06_24_145526_update_test_types_table', 1),
('2015_06_24_154426_FreeTestsColumn', 1),
('2016_03_30_145749_lab_config_settings', 1),
('2016_04_05_093952_create_require_verifications_table', 1),
('2016_04_12_093617_update_inventory_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `organisms`
--

CREATE TABLE `organisms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organism_drugs`
--

CREATE TABLE `organism_drugs` (
  `id` int(10) UNSIGNED NOT NULL,
  `organism_id` int(10) UNSIGNED NOT NULL,
  `drug_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_patient_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_number`, `name`, `dob`, `gender`, `email`, `address`, `phone_number`, `external_patient_number`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '1002', 'Jam Felicia', '2000-01-01', 1, 'fj@x.com', NULL, NULL, NULL, 2, NULL, '2016-06-09 08:20:33', '2016-06-09 08:20:33'),
(2, '1003', 'Emma Wallace', '1990-03-01', 1, 'emma@snd.com', NULL, NULL, NULL, 2, NULL, '2016-06-09 08:20:33', '2016-06-09 08:20:33'),
(3, '1004', 'Jack Tee', '1999-12-18', 0, 'info@jt.co.ke', NULL, NULL, NULL, 1, NULL, '2016-06-09 08:20:33', '2016-06-09 08:20:33'),
(4, '1005', 'Hu Jintao', '1956-10-28', 0, 'hu@.un.org', NULL, NULL, NULL, 2, NULL, '2016-06-09 08:20:33', '2016-06-09 08:20:33'),
(5, '2150', 'Lance Opiyo', '2012-01-01', 0, 'lance@x.com', NULL, NULL, NULL, 1, NULL, '2016-06-09 08:20:34', '2016-06-09 08:20:34');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'view_names', 'Can view patient names', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(2, 'manage_patients', 'Can add patients', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(3, 'receive_external_test', 'Can receive test requests', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(4, 'request_test', 'Can request new test', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(5, 'accept_test_specimen', 'Can accept test specimen', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(6, 'reject_test_specimen', 'Can reject test specimen', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(7, 'change_test_specimen', 'Can change test specimen', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(8, 'start_test', 'Can start tests', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(9, 'enter_test_results', 'Can enter tests results', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(10, 'edit_test_results', 'Can edit test results', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(11, 'verify_test_results', 'Can verify test results', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(12, 'send_results_to_external_system', 'Can send test results to external systems', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(13, 'refer_specimens', 'Can refer specimens', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(14, 'manage_users', 'Can manage users', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(15, 'manage_test_catalog', 'Can manage test catalog', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(16, 'manage_lab_configurations', 'Can manage lab configurations', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(17, 'view_reports', 'Can view reports', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(18, 'manage_inventory', 'Can manage inventory', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(19, 'request_topup', 'Can request top-up', '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(20, 'manage_qc', 'Can manage Quality Control', '2016-06-09 08:20:37', '2016-06-09 08:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1),
(20, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `facility_id` int(10) UNSIGNED NOT NULL,
  `person` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `contacts` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rejection_reasons`
--

CREATE TABLE `rejection_reasons` (
  `id` int(10) UNSIGNED NOT NULL,
  `reason` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rejection_reasons`
--

INSERT INTO `rejection_reasons` (`id`, `reason`) VALUES
(1, 'Poorly labelled'),
(2, 'Over saturation'),
(3, 'Insufficient Sample'),
(4, 'Scattered'),
(5, 'Clotted Blood'),
(6, 'Two layered spots'),
(7, 'Serum rings'),
(8, 'Scratched'),
(9, 'Haemolysis'),
(10, 'Spots that cannot elute'),
(11, 'Leaking'),
(12, 'Broken Sample Container'),
(13, 'Mismatched sample and form labelling'),
(14, 'Missing Labels on container and tracking form'),
(15, 'Empty Container'),
(16, 'Samples without tracking forms'),
(17, 'Poor transport'),
(18, 'Lipaemic'),
(19, 'Wrong container/Anticoagulant'),
(20, 'Request form without samples'),
(21, 'Missing collection date on specimen / request form.'),
(22, 'Name and signature of requester missing'),
(23, 'Mismatched information on request form and specimen container.'),
(24, 'Request form contaminated with specimen'),
(25, 'Duplicate specimen received'),
(26, 'Delay between specimen collection and arrival in the laboratory'),
(27, 'Inappropriate specimen packing'),
(28, 'Inappropriate specimen for the test'),
(29, 'Inappropriate test for the clinical condition'),
(30, 'No Label'),
(31, 'Leaking'),
(32, 'No Sample in the Container'),
(33, 'No Request Form'),
(34, 'Missing Information Required');

-- --------------------------------------------------------

--
-- Table structure for table `report_diseases`
--

CREATE TABLE `report_diseases` (
  `id` int(10) UNSIGNED NOT NULL,
  `test_type_id` int(10) UNSIGNED NOT NULL,
  `disease_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `report_diseases`
--

INSERT INTO `report_diseases` (`id`, `test_type_id`, `disease_id`) VALUES
(1, 1, 1),
(3, 2, 3),
(2, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `quantity_remaining` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test_category_id` int(10) UNSIGNED NOT NULL,
  `quantity_ordered` int(11) NOT NULL,
  `tests_done` int(11) NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  `remarks` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `require_verifications`
--

CREATE TABLE `require_verifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `verification_required` tinyint(4) NOT NULL DEFAULT '0',
  `verification_required_from` time NOT NULL DEFAULT '00:00:00',
  `verification_required_to` time NOT NULL DEFAULT '00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `require_verifications`
--

INSERT INTO `require_verifications` (`id`, `verification_required`, `verification_required_from`, `verification_required_to`) VALUES
(1, 0, '06:00:00', '06:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', NULL, '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(2, 'Technologist', NULL, '2016-06-09 08:20:37', '2016-06-09 08:20:37'),
(3, 'Receptionist', NULL, '2016-06-09 08:20:37', '2016-06-09 08:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `specimens`
--

CREATE TABLE `specimens` (
  `id` int(10) UNSIGNED NOT NULL,
  `specimen_type_id` int(10) UNSIGNED NOT NULL,
  `specimen_status_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `accepted_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `rejected_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `rejection_reason_id` int(10) UNSIGNED DEFAULT NULL,
  `reject_explained_to` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_id` int(10) UNSIGNED DEFAULT NULL,
  `time_accepted` timestamp NULL DEFAULT NULL,
  `time_rejected` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specimens`
--

INSERT INTO `specimens` (`id`, `specimen_type_id`, `specimen_status_id`, `accepted_by`, `rejected_by`, `rejection_reason_id`, `reject_explained_to`, `referral_id`, `time_accepted`, `time_rejected`) VALUES
(1, 23, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(2, 23, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(3, 23, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(4, 23, 2, 4, 0, NULL, NULL, NULL, '2016-06-09 08:20:35', NULL),
(5, 23, 2, 4, 0, NULL, NULL, NULL, '2016-06-09 08:20:36', NULL),
(6, 23, 2, 2, 0, NULL, NULL, NULL, '2016-06-09 08:20:36', NULL),
(7, 23, 2, 3, 0, NULL, NULL, NULL, '2016-06-09 08:20:36', NULL),
(8, 23, 2, 2, 0, NULL, NULL, NULL, '2016-06-09 08:20:36', NULL),
(9, 23, 2, 4, 0, NULL, NULL, NULL, '2016-06-09 08:20:36', NULL),
(10, 23, 3, 0, 1, 20, NULL, NULL, NULL, '2016-06-09 08:20:36'),
(11, 23, 2, 4, 0, NULL, NULL, NULL, '2016-06-09 08:20:36', NULL),
(12, 23, 3, 0, 1, 32, NULL, NULL, NULL, '2016-06-09 08:20:36'),
(13, 23, 3, 0, 1, 28, NULL, NULL, NULL, '2016-06-09 08:20:36'),
(14, 23, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(15, 23, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(16, 23, 2, 3, 0, NULL, NULL, NULL, '2016-06-09 08:20:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `specimen_statuses`
--

CREATE TABLE `specimen_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specimen_statuses`
--

INSERT INTO `specimen_statuses` (`id`, `name`) VALUES
(1, 'specimen-not-collected'),
(2, 'specimen-accepted'),
(3, 'specimen-rejected');

-- --------------------------------------------------------

--
-- Table structure for table `specimen_types`
--

CREATE TABLE `specimen_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specimen_types`
--

INSERT INTO `specimen_types` (`id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Ascitic Tap', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(2, 'Aspirate', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(3, 'CSF', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(4, 'Dried Blood Spot', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(5, 'High Vaginal Swab', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(6, 'Nasal Swab', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(7, 'Plasma', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(8, 'Plasma EDTA', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(9, 'Pleural Tap', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(10, 'Pus Swab', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(11, 'Rectal Swab', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(12, 'Semen', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(13, 'Serum', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(14, 'Skin', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(15, 'Sputum', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(16, 'Stool', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(17, 'Synovial Fluid', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(18, 'Throat Swab', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(19, 'Urethral Smear', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(20, 'Urine', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(21, 'Vaginal Smear', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(22, 'Water', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(23, 'Whole Blood', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `email`, `address`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'CHEM-LABS LTD', '+254 722 822 595', 'info@chem-labs.com', 'Human House, Ngara West Rd, Off Museum Hill. 23,\r\nP.o. Box 38779 – 00600,\r\nNairobi, Kenya.', 1, NULL, '2016-06-09 08:20:43', '2016-06-09 08:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(10) UNSIGNED NOT NULL,
  `visit_id` bigint(20) UNSIGNED NOT NULL,
  `test_type_id` int(10) UNSIGNED NOT NULL,
  `specimen_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `interpretation` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `test_status_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `tested_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `verified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `requested_by` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_started` timestamp NULL DEFAULT NULL,
  `time_completed` timestamp NULL DEFAULT NULL,
  `time_verified` timestamp NULL DEFAULT NULL,
  `time_sent` timestamp NULL DEFAULT NULL,
  `external_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `visit_id`, `test_type_id`, `specimen_id`, `interpretation`, `test_status_id`, `created_by`, `tested_by`, `verified_by`, `requested_by`, `time_created`, `time_started`, `time_completed`, `time_verified`, `time_sent`, `external_id`) VALUES
(1, 7, 1, 1, '', 1, 2, 0, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:35', NULL, NULL, NULL, NULL, NULL),
(2, 6, 4, 2, '', 2, 4, 0, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:35', NULL, NULL, NULL, NULL, NULL),
(3, 2, 3, 3, '', 2, 4, 0, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:35', NULL, NULL, NULL, NULL, NULL),
(4, 3, 1, 4, '', 2, 2, 0, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:35', NULL, NULL, NULL, NULL, NULL),
(5, 7, 3, 5, 'Perfect match.', 4, 3, 3, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:36', '2016-06-09 08:20:35', '2016-06-09 08:32:43', NULL, NULL, NULL),
(6, 4, 4, 6, 'Do nothing!', 4, 4, 1, 0, 'Genghiz Khan', '2016-06-09 08:20:36', '2016-06-09 08:32:43', '2016-06-09 08:38:06', NULL, NULL, NULL),
(7, 1, 3, 7, '', 3, 3, 0, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:36', '2016-06-09 08:38:06', NULL, NULL, NULL, NULL),
(8, 1, 1, 8, 'Positive', 4, 1, 4, 0, 'Ariel Smith', '2016-06-09 08:20:36', '2016-06-09 08:38:06', '2016-06-09 08:45:40', NULL, NULL, NULL),
(9, 4, 1, 9, 'Very high concentration of parasites.', 5, 4, 3, 2, 'Genghiz Khan', '2016-06-09 08:20:36', '2016-06-09 10:43:30', '2016-06-09 08:50:57', '2016-06-09 10:43:30', NULL, NULL),
(10, 4, 1, 10, '', 2, 2, 0, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:36', '2016-06-09 10:43:30', NULL, NULL, NULL, NULL),
(11, 2, 6, 11, '', 2, 1, 0, 0, 'Fred Astaire', '2016-06-09 08:20:36', NULL, NULL, NULL, NULL, NULL),
(12, 3, 1, 12, '', 3, 4, 0, 0, 'Bony Em', '2016-06-09 08:20:36', '2016-06-09 10:43:30', NULL, NULL, NULL, NULL),
(13, 5, 1, 13, 'Budda Boss', 4, 3, 4, 0, 'Ed Buttler', '2016-06-09 08:20:36', '2016-06-09 10:43:30', '2016-06-09 11:13:34', NULL, NULL, NULL),
(14, 3, 5, 14, '', 2, 4, 0, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:36', NULL, NULL, NULL, NULL, NULL),
(15, 5, 6, 15, '', 2, 3, 0, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:36', NULL, NULL, NULL, NULL, NULL),
(16, 3, 5, 16, 'Whats this !!!! ###%%% ^ *() /', 4, 3, 3, 0, 'Dr. Abou Meyang', '2016-06-09 08:20:36', '2016-06-09 11:13:34', '2016-06-09 11:25:42', NULL, NULL, 596699),
(17, 1, 7, 4, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-07-23 12:16:15', '2014-07-23 13:07:15', '2014-07-23 13:17:19', NULL, NULL, NULL),
(18, 2, 8, 3, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-07-26 07:16:15', '2014-07-26 10:27:15', '2014-07-26 10:57:01', NULL, NULL, NULL),
(19, 3, 9, 2, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-08-13 06:16:15', '2014-08-13 07:07:15', '2014-08-13 07:18:11', NULL, NULL, NULL),
(20, 4, 10, 1, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-08-16 06:06:53', '2014-08-16 06:09:15', '2014-08-16 06:23:37', NULL, NULL, NULL),
(21, 5, 11, 1, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-08-23 07:16:15', '2014-08-23 08:54:39', '2014-08-23 09:07:18', NULL, NULL, NULL),
(22, 6, 12, 2, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-09-07 04:23:15', '2014-09-07 05:07:20', '2014-09-07 05:41:13', NULL, NULL, NULL),
(23, 7, 13, 3, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-10-03 08:52:15', '2014-10-03 09:31:04', '2014-10-03 09:45:18', NULL, NULL, NULL),
(24, 1, 14, 4, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-10-15 14:01:15', '2014-10-15 14:05:24', '2014-10-15 15:07:15', NULL, NULL, NULL),
(25, 2, 15, 4, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-10-23 13:06:15', '2014-10-23 13:07:15', '2014-10-23 13:39:02', NULL, NULL, NULL),
(26, 4, 7, 3, 'Budda Boss', 4, 2, 3, 0, 'Ariel Smith', '2014-10-21 16:16:15', '2014-10-21 16:17:15', '2014-10-21 16:52:40', NULL, NULL, NULL),
(27, 3, 8, 2, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-07-21 16:16:15', '2014-07-21 16:17:15', '2014-07-21 16:52:40', '2014-07-21 16:53:48', NULL, NULL),
(28, 2, 9, 1, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-08-21 16:16:15', '2014-08-21 16:17:15', '2014-08-21 16:52:40', '2014-08-21 16:53:48', NULL, NULL),
(29, 3, 10, 4, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-08-26 16:16:15', '2014-08-26 16:17:15', '2014-08-26 16:52:40', '2014-08-26 16:53:48', NULL, NULL),
(30, 4, 11, 2, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-09-21 16:16:15', '2014-09-21 16:17:15', '2014-09-21 16:52:40', '2014-09-21 16:53:48', NULL, NULL),
(31, 1, 12, 3, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-09-22 16:16:15', '2014-09-22 16:17:15', '2014-09-22 16:52:40', '2014-09-22 16:53:48', NULL, NULL),
(32, 1, 13, 4, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-09-23 16:16:15', '2014-09-23 16:17:15', '2014-09-23 16:52:40', '2014-09-23 16:53:48', NULL, NULL),
(33, 1, 14, 2, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-09-27 16:16:15', '2014-09-27 16:17:15', '2014-09-27 16:52:40', '2014-09-27 16:53:48', NULL, NULL),
(34, 3, 15, 4, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-10-22 16:16:15', '2014-10-22 16:17:15', '2014-10-22 16:52:40', '2014-10-22 16:53:48', NULL, NULL),
(35, 4, 13, 3, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-10-17 16:16:15', '2014-10-17 16:17:15', '2014-10-17 16:52:40', '2014-10-17 16:53:48', NULL, NULL),
(36, 2, 13, 1, 'Budda Boss', 5, 3, 2, 3, 'Genghiz Khan', '2014-10-02 16:16:15', '2014-10-02 16:17:15', '2014-10-02 16:52:40', '2014-10-02 16:53:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testtype_measures`
--

CREATE TABLE `testtype_measures` (
  `id` int(10) UNSIGNED NOT NULL,
  `test_type_id` int(10) UNSIGNED NOT NULL,
  `measure_id` int(10) UNSIGNED NOT NULL,
  `ordering` tinyint(4) DEFAULT NULL,
  `nesting` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `testtype_measures`
--

INSERT INTO `testtype_measures` (`id`, `test_type_id`, `measure_id`, `ordering`, `nesting`) VALUES
(1, 1, 1, NULL, NULL),
(2, 3, 25, NULL, NULL),
(3, 3, 26, NULL, NULL),
(4, 4, 27, NULL, NULL),
(5, 5, 28, NULL, NULL),
(6, 5, 29, NULL, NULL),
(7, 5, 30, NULL, NULL),
(8, 5, 31, NULL, NULL),
(9, 5, 32, NULL, NULL),
(10, 5, 33, NULL, NULL),
(11, 5, 34, NULL, NULL),
(12, 5, 35, NULL, NULL),
(13, 5, 36, NULL, NULL),
(14, 5, 37, NULL, NULL),
(15, 5, 38, NULL, NULL),
(16, 5, 39, NULL, NULL),
(17, 5, 40, NULL, NULL),
(18, 5, 41, NULL, NULL),
(19, 5, 42, NULL, NULL),
(20, 5, 43, NULL, NULL),
(21, 5, 44, NULL, NULL),
(22, 5, 45, NULL, NULL),
(23, 6, 46, NULL, NULL),
(24, 6, 47, NULL, NULL),
(25, 6, 48, NULL, NULL),
(26, 6, 49, NULL, NULL),
(27, 6, 50, NULL, NULL),
(28, 6, 51, NULL, NULL),
(29, 7, 52, NULL, NULL),
(30, 8, 53, NULL, NULL),
(31, 9, 54, NULL, NULL),
(32, 10, 55, NULL, NULL),
(33, 11, 56, NULL, NULL),
(34, 12, 57, NULL, NULL),
(35, 13, 58, NULL, NULL),
(36, 14, 59, NULL, NULL),
(37, 15, 60, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testtype_organisms`
--

CREATE TABLE `testtype_organisms` (
  `id` int(10) UNSIGNED NOT NULL,
  `test_type_id` int(10) UNSIGNED NOT NULL,
  `organism_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testtype_specimentypes`
--

CREATE TABLE `testtype_specimentypes` (
  `id` int(10) UNSIGNED NOT NULL,
  `test_type_id` int(10) UNSIGNED NOT NULL,
  `specimen_type_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `testtype_specimentypes`
--

INSERT INTO `testtype_specimentypes` (`id`, `test_type_id`, `specimen_type_id`) VALUES
(1, 1, 23),
(19, 2, 16),
(2, 3, 23),
(4, 4, 7),
(5, 4, 8),
(6, 4, 13),
(3, 4, 23),
(7, 5, 20),
(8, 5, 21),
(9, 6, 23),
(10, 7, 13),
(11, 8, 23),
(12, 9, 23),
(13, 10, 23),
(14, 11, 23),
(15, 12, 13),
(16, 13, 20),
(17, 14, 13),
(18, 15, 13);

-- --------------------------------------------------------

--
-- Table structure for table `test_categories`
--

CREATE TABLE `test_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `test_categories`
--

INSERT INTO `test_categories` (`id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'PARASITOLOGY', '', NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(2, 'MICROBIOLOGY', '', NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(3, 'HEMATOLOGY', '', NULL, '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(4, 'SEROLOGY', '', NULL, '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(5, 'BLOOD TRANSFUSION', '', NULL, '2016-06-09 08:20:39', '2016-06-09 08:20:39');

-- --------------------------------------------------------

--
-- Table structure for table `test_phases`
--

CREATE TABLE `test_phases` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `test_phases`
--

INSERT INTO `test_phases` (`id`, `name`) VALUES
(1, 'Pre-Analytical'),
(2, 'Analytical'),
(3, 'Post-Analytical');

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` int(10) UNSIGNED NOT NULL,
  `measure_id` int(10) UNSIGNED NOT NULL,
  `result` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`id`, `test_id`, `measure_id`, `result`, `time_entered`) VALUES
(1, 9, 1, '+++', '2016-06-09 08:20:36'),
(2, 8, 1, '++', '2016-06-09 08:20:36'),
(3, 5, 25, 'COMPATIBLE WITH 061832914 B/G A POS.EXPIRY19/8/14', '2016-06-09 08:20:36'),
(4, 5, 26, 'A+', '2016-06-09 08:20:36'),
(5, 6, 27, '13.7', '2016-06-09 08:20:36'),
(6, 13, 1, 'No mps seen', '2016-06-09 08:20:36'),
(7, 16, 28, '050', '2016-06-09 08:20:36'),
(8, 16, 29, '150', '2016-06-09 08:20:36'),
(9, 16, 30, '250', '2016-06-09 08:20:36'),
(10, 16, 31, '350', '2016-06-09 08:20:36'),
(11, 16, 32, '450', '2016-06-09 08:20:36'),
(12, 16, 33, '550', '2016-06-09 08:20:36'),
(13, 16, 34, '650', '2016-06-09 08:20:36'),
(14, 16, 35, '750', '2016-06-09 08:20:36'),
(15, 16, 36, '850', '2016-06-09 08:20:36'),
(16, 16, 37, '950', '2016-06-09 08:20:36'),
(17, 16, 38, '1050', '2016-06-09 08:20:37'),
(18, 16, 39, '1150', '2016-06-09 08:20:37'),
(19, 16, 40, '1250', '2016-06-09 08:20:37'),
(20, 16, 41, '1350', '2016-06-09 08:20:37'),
(21, 16, 42, '1450', '2016-06-09 08:20:37'),
(22, 16, 43, '1550', '2016-06-09 08:20:37'),
(23, 16, 44, '1650', '2016-06-09 08:20:37'),
(24, 16, 45, '1750', '2016-06-09 08:20:37'),
(25, 17, 52, 'Positive', '2016-06-09 08:20:43'),
(26, 18, 53, 'Positive', '2016-06-09 08:20:43'),
(27, 19, 54, 'Positive', '2016-06-09 08:20:43'),
(28, 20, 55, 'Positive', '2016-06-09 08:20:43'),
(29, 21, 56, 'Positive', '2016-06-09 08:20:43'),
(30, 22, 57, 'Positive', '2016-06-09 08:20:43'),
(31, 23, 58, 'Positive', '2016-06-09 08:20:43'),
(32, 24, 59, 'Positive', '2016-06-09 08:20:43'),
(33, 25, 60, 'Positive', '2016-06-09 08:20:43'),
(34, 26, 52, 'Positive', '2016-06-09 08:20:43'),
(35, 27, 53, 'Negative', '2016-06-09 08:20:43'),
(36, 28, 54, 'Positive', '2016-06-09 08:20:43'),
(37, 29, 55, 'Positive', '2016-06-09 08:20:43'),
(38, 30, 56, 'Negative', '2016-06-09 08:20:43'),
(39, 31, 57, 'Negative', '2016-06-09 08:20:43'),
(40, 32, 58, 'Negative', '2016-06-09 08:20:43'),
(41, 33, 59, 'Positive', '2016-06-09 08:20:43'),
(42, 34, 60, 'Positive', '2016-06-09 08:20:43'),
(43, 35, 58, 'Negative', '2016-06-09 08:20:43'),
(44, 36, 58, 'Positive', '2016-06-09 08:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `test_statuses`
--

CREATE TABLE `test_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `test_phase_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `test_statuses`
--

INSERT INTO `test_statuses` (`id`, `name`, `test_phase_id`) VALUES
(1, 'not-received', 1),
(2, 'pending', 1),
(3, 'started', 2),
(4, 'completed', 3),
(5, 'verified', 3);

-- --------------------------------------------------------

--
-- Table structure for table `test_types`
--

CREATE TABLE `test_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `test_category_id` int(10) UNSIGNED NOT NULL,
  `targetTAT` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orderable_test` int(11) DEFAULT NULL,
  `prevalence_threshold` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accredited` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `test_types`
--

INSERT INTO `test_types` (`id`, `name`, `description`, `test_category_id`, `targetTAT`, `orderable_test`, `prevalence_threshold`, `accredited`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'BS for mps', NULL, 1, NULL, 1, NULL, NULL, NULL, '2016-06-09 08:20:32', '2016-06-09 08:20:32'),
(2, 'Stool for C/S', NULL, 2, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:32', '2016-06-09 08:20:32'),
(3, 'GXM', NULL, 1, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:32', '2016-06-09 08:20:32'),
(4, 'HB', NULL, 1, NULL, 1, NULL, NULL, NULL, '2016-06-09 08:20:32', '2016-06-09 08:20:32'),
(5, 'Urinalysis', NULL, 1, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:32', '2016-06-09 08:20:32'),
(6, 'WBC', NULL, 1, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:32', '2016-06-09 08:20:32'),
(7, 'Salmonella Antigen Test', NULL, 1, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(8, 'Direct COOMBS Test', NULL, 5, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(9, 'DU Test', NULL, 5, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:39', '2016-06-09 08:20:39'),
(10, 'Sickling Test', NULL, 3, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40'),
(11, 'Borrelia', NULL, 1, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40'),
(12, 'VDRL', NULL, 4, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40'),
(13, 'Pregnancy Test', NULL, 4, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40'),
(14, 'Brucella', NULL, 4, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40'),
(15, 'H. Pylori', NULL, 4, NULL, NULL, NULL, NULL, NULL, '2016-06-09 08:20:40', '2016-06-09 08:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `designation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `gender`, `designation`, `image`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'administrator', '$2y$10$ymo38xvze04KC9pQZe/zfOZ1mc7LBYMpVRjoRPpSNZLcckOXjmcA2', 'admin@kblis.org', 'kBLIS Administrator', 0, 'Programmer', NULL, '7ZHiKvi4wqPxxkdD61Tx59gl2ctULJLph6Z1rtLvCvWb8uNR6aWyrlVH0nF0', NULL, '2016-06-09 08:20:29', '2016-11-15 07:39:42'),
(2, 'external', '$2y$10$.ujCl6dP5Ppm54ziewW7e.2LdxbGNzBXJin7r1zUDgtWueWkxLUti', 'admin@kblis.org', 'External System User', 0, 'Administrator', '/i/users/user-2.jpg', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(3, 'lmorena', '$2y$10$iPBLJ0M.cLzB7uN/onTPteO61xBCIPeUoiwp1K72splJyVB.ftm2O', 'lmorena@kblis.org', 'L. Morena', 0, 'Lab Technologist', '/i/users/user-3.png', NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29'),
(4, 'abumeyang', '$2y$10$USAPc7ziyE17tI4MJLWkRudOg//1QSsfbbmORjoql0uRRE5/9Bdi6', 'abumeyang@kblis.org', 'A. Abumeyang', 0, 'Doctor', NULL, NULL, NULL, '2016-06-09 08:20:29', '2016-06-09 08:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `visit_type` varchar(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Out-patient',
  `visit_number` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `patient_id`, `visit_type`, `visit_number`, `created_at`, `updated_at`) VALUES
(1, 5, 'Out-patient', NULL, '2016-06-09 08:20:34', '2016-06-09 08:20:34'),
(2, 4, 'Out-patient', NULL, '2016-06-09 08:20:34', '2016-06-09 08:20:34'),
(3, 3, 'Out-patient', NULL, '2016-06-09 08:20:34', '2016-06-09 08:20:34'),
(4, 4, 'Out-patient', NULL, '2016-06-09 08:20:34', '2016-06-09 08:20:34'),
(5, 5, 'Out-patient', NULL, '2016-06-09 08:20:34', '2016-06-09 08:20:34'),
(6, 5, 'Out-patient', NULL, '2016-06-09 08:20:34', '2016-06-09 08:20:34'),
(7, 2, 'Out-patient', NULL, '2016-06-09 08:20:34', '2016-06-09 08:20:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_roles_user_id_foreign` (`user_id`),
  ADD KEY `assigned_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `barcode_settings`
--
ALTER TABLE `barcode_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `controls`
--
ALTER TABLE `controls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `controls_name_unique` (`name`),
  ADD KEY `controls_instrument_id_foreign` (`instrument_id`);

--
-- Indexes for table `control_measures`
--
ALTER TABLE `control_measures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `control_measures_control_measure_type_id_foreign` (`control_measure_type_id`),
  ADD KEY `control_measures_control_id_foreign` (`control_id`);

--
-- Indexes for table `control_measure_ranges`
--
ALTER TABLE `control_measure_ranges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `control_measure_ranges_control_measure_id_foreign` (`control_measure_id`);

--
-- Indexes for table `control_results`
--
ALTER TABLE `control_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `control_results_control_test_id_foreign` (`control_test_id`),
  ADD KEY `control_results_control_measure_id_foreign` (`control_measure_id`),
  ADD KEY `control_results_user_id_foreign` (`user_id`);

--
-- Indexes for table `control_tests`
--
ALTER TABLE `control_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `control_tests_control_id_foreign` (`control_id`),
  ADD KEY `control_tests_lot_id_foreign` (`lot_id`),
  ADD KEY `control_tests_user_id_foreign` (`user_id`);

--
-- Indexes for table `culture_worksheet`
--
ALTER TABLE `culture_worksheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `culture_worksheet_user_id_foreign` (`user_id`),
  ADD KEY `culture_worksheet_test_id_foreign` (`test_id`);

--
-- Indexes for table `diseases`
--
ALTER TABLE `diseases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drugs`
--
ALTER TABLE `drugs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `drugs_name_unique` (`name`);

--
-- Indexes for table `drug_susceptibility`
--
ALTER TABLE `drug_susceptibility`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drug_susceptibility_user_id_foreign` (`user_id`),
  ADD KEY `drug_susceptibility_test_id_foreign` (`test_id`),
  ADD KEY `drug_susceptibility_organism_id_foreign` (`organism_id`),
  ADD KEY `drug_susceptibility_drug_id_foreign` (`drug_id`);

--
-- Indexes for table `equip_config`
--
ALTER TABLE `equip_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equip_config_equip_id_foreign` (`equip_id`),
  ADD KEY `equip_config_prop_id_foreign` (`prop_id`);

--
-- Indexes for table `external_dump`
--
ALTER TABLE `external_dump`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `external_dump_lab_no_unique` (`lab_no`),
  ADD KEY `external_dump_parent_lab_no_index` (`parent_lab_no`);

--
-- Indexes for table `external_users`
--
ALTER TABLE `external_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `external_users_internal_user_id_unique` (`internal_user_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ii_quickcodes`
--
ALTER TABLE `ii_quickcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instruments`
--
ALTER TABLE `instruments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instrument_testtypes`
--
ALTER TABLE `instrument_testtypes`
  ADD UNIQUE KEY `instrument_testtypes_instrument_id_test_type_id_unique` (`instrument_id`,`test_type_id`),
  ADD KEY `instrument_testtypes_test_type_id_foreign` (`test_type_id`);

--
-- Indexes for table `interfaced_equipment`
--
ALTER TABLE `interfaced_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interfaced_equipment_lab_section_foreign` (`lab_section`);

--
-- Indexes for table `inv_items`
--
ALTER TABLE `inv_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_items_name_unique` (`name`),
  ADD KEY `inv_items_user_id_foreign` (`user_id`);

--
-- Indexes for table `inv_supply`
--
ALTER TABLE `inv_supply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_supply_user_id_foreign` (`user_id`),
  ADD KEY `inv_supply_item_id_foreign` (`item_id`),
  ADD KEY `inv_supply_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `inv_usage`
--
ALTER TABLE `inv_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_usage_user_id_foreign` (`user_id`),
  ADD KEY `inv_usage_stock_id_foreign` (`stock_id`),
  ADD KEY `inv_usage_request_id_foreign` (`request_id`);

--
-- Indexes for table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lots_lot_no_unique` (`lot_no`);

--
-- Indexes for table `measures`
--
ALTER TABLE `measures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `measures_measure_type_id_foreign` (`measure_type_id`);

--
-- Indexes for table `measure_ranges`
--
ALTER TABLE `measure_ranges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `measure_ranges_alphanumeric_index` (`alphanumeric`),
  ADD KEY `measure_ranges_measure_id_foreign` (`measure_id`);

--
-- Indexes for table `measure_types`
--
ALTER TABLE `measure_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `measure_types_name_unique` (`name`);

--
-- Indexes for table `organisms`
--
ALTER TABLE `organisms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organisms_name_unique` (`name`);

--
-- Indexes for table `organism_drugs`
--
ALTER TABLE `organism_drugs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organism_drugs_organism_id_drug_id_unique` (`organism_id`,`drug_id`),
  ADD KEY `organism_drugs_drug_id_foreign` (`drug_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_external_patient_number_index` (`external_patient_number`),
  ADD KEY `patients_created_by_index` (`created_by`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referrals_user_id_foreign` (`user_id`),
  ADD KEY `referrals_facility_id_foreign` (`facility_id`);

--
-- Indexes for table `rejection_reasons`
--
ALTER TABLE `rejection_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_diseases`
--
ALTER TABLE `report_diseases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_diseases_test_type_id_disease_id_unique` (`test_type_id`,`disease_id`),
  ADD KEY `report_diseases_disease_id_foreign` (`disease_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requests_test_category_id_foreign` (`test_category_id`),
  ADD KEY `requests_item_id_foreign` (`item_id`),
  ADD KEY `requests_user_id_foreign` (`user_id`);

--
-- Indexes for table `require_verifications`
--
ALTER TABLE `require_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `specimens`
--
ALTER TABLE `specimens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specimens_accepted_by_index` (`accepted_by`),
  ADD KEY `specimens_rejected_by_index` (`rejected_by`),
  ADD KEY `specimens_specimen_type_id_foreign` (`specimen_type_id`),
  ADD KEY `specimens_specimen_status_id_foreign` (`specimen_status_id`),
  ADD KEY `specimens_rejection_reason_id_foreign` (`rejection_reason_id`),
  ADD KEY `specimens_referral_id_foreign` (`referral_id`);

--
-- Indexes for table `specimen_statuses`
--
ALTER TABLE `specimen_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specimen_types`
--
ALTER TABLE `specimen_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_user_id_foreign` (`user_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_created_by_index` (`created_by`),
  ADD KEY `tests_tested_by_index` (`tested_by`),
  ADD KEY `tests_verified_by_index` (`verified_by`),
  ADD KEY `tests_visit_id_foreign` (`visit_id`),
  ADD KEY `tests_test_type_id_foreign` (`test_type_id`),
  ADD KEY `tests_specimen_id_foreign` (`specimen_id`),
  ADD KEY `tests_test_status_id_foreign` (`test_status_id`);

--
-- Indexes for table `testtype_measures`
--
ALTER TABLE `testtype_measures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `testtype_measures_test_type_id_measure_id_unique` (`test_type_id`,`measure_id`),
  ADD KEY `testtype_measures_measure_id_foreign` (`measure_id`);

--
-- Indexes for table `testtype_organisms`
--
ALTER TABLE `testtype_organisms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `testtype_organisms_test_type_id_organism_id_unique` (`test_type_id`,`organism_id`),
  ADD KEY `testtype_organisms_organism_id_foreign` (`organism_id`);

--
-- Indexes for table `testtype_specimentypes`
--
ALTER TABLE `testtype_specimentypes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `testtype_specimentypes_test_type_id_specimen_type_id_unique` (`test_type_id`,`specimen_type_id`),
  ADD KEY `testtype_specimentypes_specimen_type_id_foreign` (`specimen_type_id`);

--
-- Indexes for table `test_categories`
--
ALTER TABLE `test_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_categories_name_unique` (`name`);

--
-- Indexes for table `test_phases`
--
ALTER TABLE `test_phases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_results_test_id_measure_id_unique` (`test_id`,`measure_id`),
  ADD KEY `test_results_measure_id_foreign` (`measure_id`);

--
-- Indexes for table `test_statuses`
--
ALTER TABLE `test_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_statuses_test_phase_id_foreign` (`test_phase_id`);

--
-- Indexes for table `test_types`
--
ALTER TABLE `test_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_types_test_category_id_foreign` (`test_category_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD KEY `tokens_email_index` (`email`),
  ADD KEY `tokens_token_index` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visits_visit_number_index` (`visit_number`),
  ADD KEY `visits_patient_id_foreign` (`patient_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `barcode_settings`
--
ALTER TABLE `barcode_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `controls`
--
ALTER TABLE `controls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `control_measures`
--
ALTER TABLE `control_measures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `control_measure_ranges`
--
ALTER TABLE `control_measure_ranges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `control_results`
--
ALTER TABLE `control_results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `control_tests`
--
ALTER TABLE `control_tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `culture_worksheet`
--
ALTER TABLE `culture_worksheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `diseases`
--
ALTER TABLE `diseases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `drugs`
--
ALTER TABLE `drugs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `drug_susceptibility`
--
ALTER TABLE `drug_susceptibility`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `equip_config`
--
ALTER TABLE `equip_config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `external_dump`
--
ALTER TABLE `external_dump`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `external_users`
--
ALTER TABLE `external_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ii_quickcodes`
--
ALTER TABLE `ii_quickcodes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `instruments`
--
ALTER TABLE `instruments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `interfaced_equipment`
--
ALTER TABLE `interfaced_equipment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `inv_items`
--
ALTER TABLE `inv_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inv_supply`
--
ALTER TABLE `inv_supply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inv_usage`
--
ALTER TABLE `inv_usage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `measures`
--
ALTER TABLE `measures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `measure_ranges`
--
ALTER TABLE `measure_ranges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `organisms`
--
ALTER TABLE `organisms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `organism_drugs`
--
ALTER TABLE `organism_drugs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rejection_reasons`
--
ALTER TABLE `rejection_reasons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `report_diseases`
--
ALTER TABLE `report_diseases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `require_verifications`
--
ALTER TABLE `require_verifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `specimens`
--
ALTER TABLE `specimens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `specimen_types`
--
ALTER TABLE `specimen_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `testtype_measures`
--
ALTER TABLE `testtype_measures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `testtype_organisms`
--
ALTER TABLE `testtype_organisms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `testtype_specimentypes`
--
ALTER TABLE `testtype_specimentypes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `test_categories`
--
ALTER TABLE `test_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `test_types`
--
ALTER TABLE `test_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `assigned_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `controls`
--
ALTER TABLE `controls`
  ADD CONSTRAINT `controls_instrument_id_foreign` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`);

--
-- Constraints for table `control_measures`
--
ALTER TABLE `control_measures`
  ADD CONSTRAINT `control_measures_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `controls` (`id`),
  ADD CONSTRAINT `control_measures_control_measure_type_id_foreign` FOREIGN KEY (`control_measure_type_id`) REFERENCES `measure_types` (`id`);

--
-- Constraints for table `control_measure_ranges`
--
ALTER TABLE `control_measure_ranges`
  ADD CONSTRAINT `control_measure_ranges_control_measure_id_foreign` FOREIGN KEY (`control_measure_id`) REFERENCES `control_measures` (`id`);

--
-- Constraints for table `control_results`
--
ALTER TABLE `control_results`
  ADD CONSTRAINT `control_results_control_measure_id_foreign` FOREIGN KEY (`control_measure_id`) REFERENCES `control_measures` (`id`),
  ADD CONSTRAINT `control_results_control_test_id_foreign` FOREIGN KEY (`control_test_id`) REFERENCES `control_tests` (`id`),
  ADD CONSTRAINT `control_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `control_tests`
--
ALTER TABLE `control_tests`
  ADD CONSTRAINT `control_tests_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `controls` (`id`),
  ADD CONSTRAINT `control_tests_lot_id_foreign` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`),
  ADD CONSTRAINT `control_tests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `culture_worksheet`
--
ALTER TABLE `culture_worksheet`
  ADD CONSTRAINT `culture_worksheet_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`),
  ADD CONSTRAINT `culture_worksheet_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `drug_susceptibility`
--
ALTER TABLE `drug_susceptibility`
  ADD CONSTRAINT `drug_susceptibility_drug_id_foreign` FOREIGN KEY (`drug_id`) REFERENCES `drugs` (`id`),
  ADD CONSTRAINT `drug_susceptibility_organism_id_foreign` FOREIGN KEY (`organism_id`) REFERENCES `organisms` (`id`),
  ADD CONSTRAINT `drug_susceptibility_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`),
  ADD CONSTRAINT `drug_susceptibility_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `equip_config`
--
ALTER TABLE `equip_config`
  ADD CONSTRAINT `equip_config_equip_id_foreign` FOREIGN KEY (`equip_id`) REFERENCES `interfaced_equipment` (`id`),
  ADD CONSTRAINT `equip_config_prop_id_foreign` FOREIGN KEY (`prop_id`) REFERENCES `ii_quickcodes` (`id`);

--
-- Constraints for table `external_users`
--
ALTER TABLE `external_users`
  ADD CONSTRAINT `external_users_internal_user_id_foreign` FOREIGN KEY (`internal_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `instrument_testtypes`
--
ALTER TABLE `instrument_testtypes`
  ADD CONSTRAINT `instrument_testtypes_instrument_id_foreign` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`),
  ADD CONSTRAINT `instrument_testtypes_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`);

--
-- Constraints for table `interfaced_equipment`
--
ALTER TABLE `interfaced_equipment`
  ADD CONSTRAINT `interfaced_equipment_lab_section_foreign` FOREIGN KEY (`lab_section`) REFERENCES `test_categories` (`id`);

--
-- Constraints for table `inv_items`
--
ALTER TABLE `inv_items`
  ADD CONSTRAINT `inv_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `inv_supply`
--
ALTER TABLE `inv_supply`
  ADD CONSTRAINT `inv_supply_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inv_items` (`id`),
  ADD CONSTRAINT `inv_supply_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `inv_supply_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `inv_usage`
--
ALTER TABLE `inv_usage`
  ADD CONSTRAINT `inv_usage_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`),
  ADD CONSTRAINT `inv_usage_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `inv_supply` (`id`),
  ADD CONSTRAINT `inv_usage_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `measures`
--
ALTER TABLE `measures`
  ADD CONSTRAINT `measures_measure_type_id_foreign` FOREIGN KEY (`measure_type_id`) REFERENCES `measure_types` (`id`);

--
-- Constraints for table `measure_ranges`
--
ALTER TABLE `measure_ranges`
  ADD CONSTRAINT `measure_ranges_measure_id_foreign` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`);

--
-- Constraints for table `organism_drugs`
--
ALTER TABLE `organism_drugs`
  ADD CONSTRAINT `organism_drugs_drug_id_foreign` FOREIGN KEY (`drug_id`) REFERENCES `drugs` (`id`),
  ADD CONSTRAINT `organism_drugs_organism_id_foreign` FOREIGN KEY (`organism_id`) REFERENCES `organisms` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `referrals`
--
ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`),
  ADD CONSTRAINT `referrals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `report_diseases`
--
ALTER TABLE `report_diseases`
  ADD CONSTRAINT `report_diseases_disease_id_foreign` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`id`),
  ADD CONSTRAINT `report_diseases_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inv_items` (`id`),
  ADD CONSTRAINT `requests_test_category_id_foreign` FOREIGN KEY (`test_category_id`) REFERENCES `test_categories` (`id`),
  ADD CONSTRAINT `requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `specimens`
--
ALTER TABLE `specimens`
  ADD CONSTRAINT `specimens_referral_id_foreign` FOREIGN KEY (`referral_id`) REFERENCES `referrals` (`id`),
  ADD CONSTRAINT `specimens_rejection_reason_id_foreign` FOREIGN KEY (`rejection_reason_id`) REFERENCES `rejection_reasons` (`id`),
  ADD CONSTRAINT `specimens_specimen_status_id_foreign` FOREIGN KEY (`specimen_status_id`) REFERENCES `specimen_statuses` (`id`),
  ADD CONSTRAINT `specimens_specimen_type_id_foreign` FOREIGN KEY (`specimen_type_id`) REFERENCES `specimen_types` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_specimen_id_foreign` FOREIGN KEY (`specimen_id`) REFERENCES `specimens` (`id`),
  ADD CONSTRAINT `tests_test_status_id_foreign` FOREIGN KEY (`test_status_id`) REFERENCES `test_statuses` (`id`),
  ADD CONSTRAINT `tests_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`),
  ADD CONSTRAINT `tests_visit_id_foreign` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`);

--
-- Constraints for table `testtype_measures`
--
ALTER TABLE `testtype_measures`
  ADD CONSTRAINT `testtype_measures_measure_id_foreign` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`),
  ADD CONSTRAINT `testtype_measures_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`);

--
-- Constraints for table `testtype_organisms`
--
ALTER TABLE `testtype_organisms`
  ADD CONSTRAINT `testtype_organisms_organism_id_foreign` FOREIGN KEY (`organism_id`) REFERENCES `organisms` (`id`),
  ADD CONSTRAINT `testtype_organisms_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`);

--
-- Constraints for table `testtype_specimentypes`
--
ALTER TABLE `testtype_specimentypes`
  ADD CONSTRAINT `testtype_specimentypes_specimen_type_id_foreign` FOREIGN KEY (`specimen_type_id`) REFERENCES `specimen_types` (`id`),
  ADD CONSTRAINT `testtype_specimentypes_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`);

--
-- Constraints for table `test_results`
--
ALTER TABLE `test_results`
  ADD CONSTRAINT `test_results_measure_id_foreign` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`),
  ADD CONSTRAINT `test_results_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`);

--
-- Constraints for table `test_statuses`
--
ALTER TABLE `test_statuses`
  ADD CONSTRAINT `test_statuses_test_phase_id_foreign` FOREIGN KEY (`test_phase_id`) REFERENCES `test_phases` (`id`);

--
-- Constraints for table `test_types`
--
ALTER TABLE `test_types`
  ADD CONSTRAINT `test_types_test_category_id_foreign` FOREIGN KEY (`test_category_id`) REFERENCES `test_categories` (`id`);

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
