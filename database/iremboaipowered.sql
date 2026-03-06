-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2026 at 05:36 PM
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
-- Database: `iremboaipowered`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicationcriminalrecord`
--

CREATE TABLE `applicationcriminalrecord` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `purpose` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `service_name` varchar(150) DEFAULT NULL,
  `processing_days` int(11) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `application_date` datetime DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationcriminalrecord`
--

INSERT INTO `applicationcriminalrecord` (`id`, `full_name`, `email`, `phone`, `national_id`, `purpose`, `attachment`, `service_name`, `processing_days`, `price`, `provided_by`, `application_date`, `expected_feedback_date`, `status`, `created_at`, `admin_reason`) VALUES
(3, 'KEZA Joanah', 'kezjoana7@gmail.com', '+250789418569', '1200370186200162', 'for my work permit', '1772635825_Birth Certificate_Certificate (4).png', 'Certificate of Good Conduct', 7, 'free', 'RIB', '2026-02-22 15:50:25', '2026-02-25 05:50:25', 'Pending', '2026-03-04 14:50:25', NULL),
(4, 'KEZA Joanah', 'kezjoana7@gmail.com', '+250789418569', '1200370186200162', 'yes', '1772636753_WhatsApp Image 2026-03-01 at 8.16.34 PM (1).jpeg', 'Certificate of Good Conduct', 7, 'free', 'RIB', '2026-02-25 16:05:53', '2026-03-11 16:05:53', 'Pending', '2026-03-04 15:05:53', NULL),
(6, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'i need ', '1772640123_Marriage Certificate_Certificate.png', 'Certificate of Good Conduct', 7, 'free', 'RIB', '2026-03-04 17:02:03', '2026-03-11 17:02:03', 'Pending', '2026-03-04 16:02:03', NULL),
(7, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'work', '1772647016_Marriage Certificate_Certificate.png', 'Certificate of Good Conduct', 7, 'free', 'RIB', '2026-03-04 18:56:56', '2026-03-11 18:56:56', 'Pending', '2026-03-04 17:56:56', NULL),
(8, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'yes', '1772650394_Birth Certificate_Certificate (1).png', 'Criminal Record Certificate', 3, '10000', 'RNP', '2026-03-04 19:53:14', '2026-03-07 19:53:14', 'Pending', '2026-03-04 18:53:14', NULL),
(9, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'for my work', '1772811795_provisional driving license.jpg', 'Criminal Record Certificate', 3, '10000', 'RNP', '2026-03-06 16:43:15', '2026-03-09 16:43:15', 'Pending', '2026-03-06 15:43:15', NULL),
(10, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'work related', '1772814223_marriageeee.jpg', 'Criminal Record Certificate', 3, '10000', 'RNP', '2026-03-06 17:23:43', '2026-03-09 17:23:43', 'Pending', '2026-03-06 16:23:43', NULL),
(11, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Work', '1772814422_Birth Certificate_Certificate (3).png', 'Criminal Record Certificate', 3, '10000', 'RNP', '2026-03-06 17:27:02', '2026-03-09 17:27:02', 'Pending', '2026-03-06 16:27:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationdrivinglicense`
--

CREATE TABLE `applicationdrivinglicense` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `national_id` varchar(30) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `processing_time` int(11) NOT NULL COMMENT 'Number of days',
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `application_date` datetime DEFAULT current_timestamp(),
  `expected_feedback_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationdrivinglicense`
--

INSERT INTO `applicationdrivinglicense` (`id`, `full_name`, `email`, `phone`, `national_id`, `service_name`, `processing_time`, `price`, `currency`, `application_date`, `expected_feedback_date`, `status`, `admin_reason`) VALUES
(6, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200166', 'Application for Definitive Driving License', 14, 50000.00, 'RWF', '2026-03-04 20:25:49', '2026-03-18 20:25:49', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationdrivingreplacement`
--

CREATE TABLE `applicationdrivingreplacement` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `national_id` varchar(30) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `reason` varchar(100) DEFAULT 'Driving License Replacement',
  `service_name` varchar(200) DEFAULT NULL,
  `processing_time` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `old_license_image` varchar(255) DEFAULT NULL,
  `police_document` varchar(255) DEFAULT NULL,
  `application_date` datetime DEFAULT current_timestamp(),
  `expected_feedback_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationdrivingreplacement`
--

INSERT INTO `applicationdrivingreplacement` (`id`, `full_name`, `email`, `phone`, `national_id`, `license_number`, `reason`, `service_name`, `processing_time`, `price`, `currency`, `old_license_image`, `police_document`, `application_date`, `expected_feedback_date`, `status`, `admin_reason`) VALUES
(2, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '12003701862001610', '120030', 'Driving License Replacement', 'Application for Definitive Driving License', 14, 50000.00, 'RWF', '1772639798_license.png', '', '2026-03-04 16:56:38', '2026-03-18 16:56:38', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationgoodconduct`
--

CREATE TABLE `applicationgoodconduct` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `national_id` varchar(30) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `processing_time` int(11) NOT NULL,
  `price` varchar(50) DEFAULT NULL,
  `application_date` datetime DEFAULT current_timestamp(),
  `expected_feedback_date` datetime DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationgoodconduct`
--

INSERT INTO `applicationgoodconduct` (`id`, `full_name`, `email`, `phone`, `national_id`, `service_name`, `processing_time`, `price`, `application_date`, `expected_feedback_date`, `attachment`, `status`, `admin_reason`) VALUES
(2, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Certificate of Good Conduct', 7, 'free', '2026-03-04 17:02:31', '2026-03-11 17:02:31', '1772640151_Passport_Certificate.png', 'Pending', NULL),
(3, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200166', 'Certificate of Good Conduct', 7, 'free', '2026-03-04 18:57:53', '2026-03-11 18:57:53', '1772647073_Passport_Certificate.png', 'Pending', NULL),
(4, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Certificate of Good Conduct', 7, 'free', '2026-03-06 16:56:18', '2026-03-13 16:56:18', '1772812578_criminal record.jpg', 'Pending', NULL),
(5, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Certificate of Good Conduct', 7, 'free', '2026-03-06 17:28:50', '2026-03-13 17:28:50', '1772814530_Birth Certificate_Certificate (3).png', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationmarriagecertificate`
--

CREATE TABLE `applicationmarriagecertificate` (
  `id` int(11) NOT NULL,
  `husband_full_name` varchar(150) NOT NULL,
  `wife_full_name` varchar(150) NOT NULL,
  `applicant_email` varchar(150) NOT NULL,
  `applicant_phone` varchar(20) NOT NULL,
  `husband_national_id` varchar(30) NOT NULL,
  `wife_national_id` varchar(30) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `processing_time` int(11) NOT NULL COMMENT 'Number of days',
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `application_date` datetime DEFAULT current_timestamp(),
  `expected_feedback_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationmarriagecertificate`
--

INSERT INTO `applicationmarriagecertificate` (`id`, `husband_full_name`, `wife_full_name`, `applicant_email`, `applicant_phone`, `husband_national_id`, `wife_national_id`, `service_name`, `processing_time`, `price`, `currency`, `application_date`, `expected_feedback_date`, `status`, `admin_reason`) VALUES
(2, 'kambanda jackson', 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1230080186200162', '1230070186200162', 'Marriage Certificate', 1, 1000.00, 'RWF', '2026-03-04 18:56:13', '2026-03-05 18:56:13', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationnationalid`
--

CREATE TABLE `applicationnationalid` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `national_id` varchar(30) NOT NULL,
  `reason` varchar(255) DEFAULT 'Lost ID Replacement',
  `service_name` varchar(200) NOT NULL,
  `processing_time` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `old_id_image` varchar(255) DEFAULT NULL,
  `police_document` varchar(255) DEFAULT NULL,
  `application_date` datetime DEFAULT current_timestamp(),
  `expected_feedback_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationnationalid`
--

INSERT INTO `applicationnationalid` (`id`, `full_name`, `email`, `phone`, `national_id`, `reason`, `service_name`, `processing_time`, `price`, `currency`, `old_id_image`, `police_document`, `application_date`, `expected_feedback_date`, `status`, `admin_reason`) VALUES
(2, 'KEZA Joanah', 'kezjoana7@gmail.com', '+250789418569', '1200370186200162', 'Lost ID Replacement', 'Application for National ID', 30, 500.00, 'RWF', '1772623054_old.png', '', '2026-02-22 12:17:34', '2026-02-26 12:17:34', 'Pending', NULL),
(3, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Lost ID Replacement', 'Application for National ID', 30, 500.00, 'RWF', '1772639729_old.png', '', '2026-03-04 16:55:29', '2026-04-03 16:55:29', 'Pending', NULL),
(4, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '120037018620016210', 'Lost ID Replacement', 'Application for National ID', 30, 500.00, 'RWF', '1772639969_old.png', '', '2026-03-04 16:59:29', '2026-04-03 16:59:29', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationpassport`
--

CREATE TABLE `applicationpassport` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `national_id` varchar(30) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `request_type` varchar(200) DEFAULT NULL,
  `processing_time` int(11) NOT NULL COMMENT 'Number of days',
  `fee` varchar(100) DEFAULT NULL,
  `application_date` datetime DEFAULT current_timestamp(),
  `expected_feedback_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationpassport`
--

INSERT INTO `applicationpassport` (`id`, `full_name`, `email`, `phone`, `national_id`, `service_name`, `request_type`, `processing_time`, `fee`, `application_date`, `expected_feedback_date`, `status`, `admin_reason`) VALUES
(3, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'e-Passport Application', 'e-Passport Application', 4, '100000', '2026-03-04 17:04:45', '2026-03-08 17:04:45', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationpassportreplacement`
--

CREATE TABLE `applicationpassportreplacement` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `passport_number` varchar(20) NOT NULL,
  `reason` text NOT NULL,
  `service_name` varchar(150) DEFAULT NULL,
  `processing_days` int(11) DEFAULT NULL,
  `fee` varchar(50) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `application_date` datetime DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationpassportreplacement`
--

INSERT INTO `applicationpassportreplacement` (`id`, `full_name`, `email`, `phone`, `national_id`, `passport_number`, `reason`, `service_name`, `processing_days`, `fee`, `provided_by`, `application_date`, `expected_feedback_date`, `status`, `created_at`, `admin_reason`) VALUES
(2, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', '1200370186200165', 'i need it', 'e-Passport Application', 4, '100000', 'DGIW', '2026-03-04 17:00:21', '2026-03-08 17:00:21', 'Pending', '2026-03-04 16:00:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationprovisionallicense`
--

CREATE TABLE `applicationprovisionallicense` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `national_id` varchar(30) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `processing_time` int(11) NOT NULL COMMENT 'Number of days',
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `application_date` datetime DEFAULT current_timestamp(),
  `expected_feedback_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationprovisionallicense`
--

INSERT INTO `applicationprovisionallicense` (`id`, `full_name`, `email`, `phone`, `national_id`, `service_name`, `processing_time`, `price`, `currency`, `application_date`, `expected_feedback_date`, `status`, `admin_reason`) VALUES
(3, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Application for e-Provisional Driving License', 1, 10000.00, 'RWF', '2026-03-04 17:03:06', '2026-03-05 17:03:06', 'Pending', NULL),
(4, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Application for e-Provisional Driving License', 1, 10000.00, 'RWF', '2026-03-04 17:03:50', '2026-03-05 17:03:50', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `citizensregistry`
--

CREATE TABLE `citizensregistry` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `date_of_birth` date NOT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `passport_number` varchar(20) DEFAULT NULL,
  `provisional_driving_number` varchar(20) DEFAULT NULL,
  `driving_license_number` varchar(20) DEFAULT NULL,
  `passport_image` varchar(255) DEFAULT NULL,
  `place_of_birth` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `marital_status` enum('Single','Married','Widowed','Divorced','Other') DEFAULT 'Single',
  `father_name` varchar(150) DEFAULT NULL,
  `mother_name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizensregistry`
--

INSERT INTO `citizensregistry` (`id`, `first_name`, `last_name`, `gender`, `date_of_birth`, `national_id`, `passport_number`, `provisional_driving_number`, `driving_license_number`, `passport_image`, `place_of_birth`, `phone`, `email`, `address`, `marital_status`, `father_name`, `mother_name`, `created_at`, `updated_at`) VALUES
(2, 'Joan ', 'keza', 'Female', '2006-03-20', '1200370186200162', NULL, NULL, NULL, NULL, 'kigali', '+250789418569', 'kezjoana7@gmail.com', 'Kigali', 'Single', 'Rusatira', 'Jane', '2026-03-04 08:39:22', '2026-03-04 08:39:22'),
(3, 'David', 'Inkotanyi', 'Male', '2004-10-14', '1200480186800162', '', '', '', '', 'musanze', '0780898283', 'idavid@gmail.com', '', 'Married', '', '', '2026-03-04 10:29:37', '2026-03-05 10:49:55'),
(11, 'Diana', 'Ruzindana', 'Female', '2002-11-27', '1200270185200154', NULL, NULL, NULL, NULL, 'Muhanga', '0782969354', 'dianaruzindana@gmail.com', '', 'Single', '', '', '2026-03-05 11:53:00', '2026-03-05 11:53:00'),
(12, 'ibrahim', 'Makura', 'Male', '1999-11-30', '11999980186700163', NULL, NULL, NULL, NULL, 'nyamasheke', '0788903471', 'ibramakura4@gmail.com', '', 'Single', '', '', '2026-03-05 12:16:48', '2026-03-05 12:16:48'),
(13, 'Jovia', 'uwiduhaye', 'Female', '2001-06-11', '1200180186700163', NULL, NULL, NULL, NULL, 'kicukiro', '0786270039', 'joviauwidahaye7@gmail.com', '', 'Single', '', '', '2026-03-05 12:39:04', '2026-03-05 12:39:04'),
(14, 'sonia', 'Umwali', 'Female', '2005-12-12', '1200570186220165', NULL, NULL, NULL, NULL, 'rusizi', '0787519393', 'soniaumwali12@gmail.com', '', 'Single', '', '', '2026-03-05 12:42:04', '2026-03-05 12:42:04'),
(15, 'norman', 'Kanyambo', 'Male', '1987-08-21', '118780162801642', NULL, NULL, NULL, NULL, 'Rubavu', '0784299068', 'k.norman@gmail.com', '', 'Married', '', '', '2026-03-06 10:09:26', '2026-03-06 10:09:26'),
(16, 'Boris', 'Gisagara', 'Male', '2001-02-05', '1200180185202164', NULL, NULL, NULL, NULL, 'Nyarugenge', '0787568892', 'borisgisagara57@gmail.com', '', 'Single', '', '', '2026-03-06 10:17:06', '2026-03-06 10:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `criminalrecordinfo`
--

CREATE TABLE `criminalrecordinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `currency` varchar(20) DEFAULT 'RWF',
  `provided_by` varchar(150) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criminalrecordinfo`
--

INSERT INTO `criminalrecordinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Criminal Record Certificate', 'This service allows Rwandans and foreigners living/who have lived in Rwanda to apply for a Criminal Record Certificate. This certificate has a validity of 6 months.', 'Prerequisites: \r\n\r\n1.Applicants should have an Irembo account or visit the nearest Irembo agent for assistance. \r\n\r\n2.Rwandan applicants should have a national ID number, or Citizen Application Number.\r\n\r\n3.Foreigners should have a foreigner’s ID.  \r\n\r\n4.Refugee applicants should have a refugee national ID number.\r\n\r\n5.Minors with a Citizen Application Number should be 14 years of age or older.\r\n\r\n6.Conditional attachments include:\r\n\r\nA. Passport Photos for minors, Refugees, and foreigners\r\n\r\nB. Proof of registration for refugees\r\n\r\nC. Passport copy (when you were/are in Rwanda)\r\n\r\nD. Copy of Visa (when you were/are in Rwanda)\r\n\r\nE. Passport copy for Rwandans living abroad, foreigners, and refugees\r\n\r\nF. A copy of Visa for foreigners\r\n\r\nG. Applicants should have a valid phone number, email address, or both.', '3', '10000', 'RWF', 'RNP', 'Active', '2026-02-25 15:27:15', '2026-03-04 10:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `drivinglicenseinfo`
--

CREATE TABLE `drivinglicenseinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(150) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivinglicenseinfo`
--

INSERT INTO `drivinglicenseinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Application for Definitive Driving License', 'This service allows Rwanda citizens who passed the definitive driving test to request their definitive driving license.                ', 'Prerequisites: \r\n\r\n1. Applicants with or without an account can apply for this service.\r\n\r\n2.Applicants should have passed the definitive driving test and given a registration code.\r\n\r\n3.Applicants should have a valid phone number, email address, or both.', '14', 50000.00, 'RWF', 'RNP', 'Active', '2026-02-24 09:24:59', '2026-03-04 09:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `goodconductinfo`
--

CREATE TABLE `goodconductinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `required_attachments` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `provided_by` varchar(150) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `goodconductinfo`
--

INSERT INTO `goodconductinfo` (`id`, `service_name`, `description`, `required_attachments`, `processing_time`, `price`, `provided_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Certificate of Good Conduct', 'The certificate is issued to individuals living or who have previously lived in Rwanda to ascertain that they exhibit good community conduct.                   ', '1. Recommendation letter from village leader\r\n\r\n2. Recommendation letter from cell leader\r\n\r\n3. Passport photo\r\n\r\n4. A passport copy (required if a passport ID is used)', '7', 'free', 'RIB', 'Active', '2026-02-23 17:06:17', '2026-03-04 10:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `marriageinfo`
--

CREATE TABLE `marriageinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(150) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marriageinfo`
--

INSERT INTO `marriageinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Marriage Certificate', 'The marriage Certificate is the official document that identifies that a couple is legally married. The application will be submitted to local government authorities at the sector level for processing where the marriage has been celebrated.                                ', 'Prerequisites: \r\n\r\n1.This service is available to Rwandan citizens only.\r\n\r\n2.Applicants should have an Irembo account or visit the nearest Irembo agent for assistance.  \r\n \r\n\r\n3.Every Rwandan citizen applying for this service should have a national ID number.\r\n\r\nApplicants should have a valid phone number and/or email address.\r\n\r\n', '1', 1000.00, 'RWF', 'MINALOC', 'Active', '2026-02-23 15:10:10', '2026-03-04 09:59:33');

-- --------------------------------------------------------

--
-- Table structure for table `nationalidinfo`
--

CREATE TABLE `nationalidinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(150) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nationalidinfo`
--

INSERT INTO `nationalidinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Application for National ID', 'This service enables Rwanda citizens to apply for a national ID. The applicant must have an application number in NIDA offices. A citizen who does not have the application number should carry any Identification and reach out the nearest sector office to request it from the Civil Registration officer (CRO) before applying for the National ID. For any more information, visit: info@nida.gov.rw', 'Prerequisites:\r\n\r\n1. Applicants with or without an account can apply for this service.\r\n\r\n\r\n2. Applicants should have a citizen application number (Child ID).  \r\n\r\n3. Applicants should be 16 years and above.\r\n\r\nNote that if you don\'t have a child ID, you can acquire it in one of these 3 different ways:\r\n\r\n1. For citizens born before the launch of CRVS, it is acquired from the sector.\r\n\r\n2. For Rwandans living in Rwanda, a child born after the launch of Civil Registration and Vital Statistics (CRVS) gets the Child ID from the hospital.\r\n\r\n3. For a child born in the diaspora and living abroad, you can contact NIDA at info@nida.gov.rw for assistance.\r\n\r\n4. For a child born in the diaspora and living in Rwanda, you reach out to the sector for assistance.', '30', 500.00, 'RWF', 'NIDA', 'Active', '2026-02-22 13:26:17', '2026-03-04 15:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `passportinfo`
--

CREATE TABLE `passportinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `request_type` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `fee` varchar(255) DEFAULT NULL,
  `provided_by` varchar(150) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passportinfo`
--

INSERT INTO `passportinfo` (`id`, `service_name`, `request_type`, `description`, `requirements`, `processing_time`, `fee`, `provided_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'e-Passport Application', 'e-Passport Application', 'This service allows Rwandans to apply for the most recent Rwanda East Africa electronic passport issued by DGIE from 28 June 2019. The Directorate General of Immigration and Emigration issues three types of passports: ordinary, service, and diplomatic passports. You are eligible to apply for this service if: 1. You will be a first-time holder of a Rwandan passport. or 2. You are replacing or renewing a passport, and the type of passport that you are replacing is the discontinued, dark blue passport, issued by DGIE before 28 June 2019.\r\n\r\n                                                ', 'Applicant: Below 18 years\r\nPassport Type: Service\r\nPassport Validity: 5 years \r\nFees (Rwf):15,000\r\nAttachments: \r\n1.Citizen application number (child ID) for a minor below 16 years old.\r\n2.Copy of National ID\r\n3.Passport Photo \r\n4.Signature (Write the names of the child)\r\n5.A recommendation letter issued by a government institution\r\n6.Other attachments, depending on the selected \"Minor Category,\" \r\n\r\nApplicant: 16 and 17 years\r\nPassport Type: Ordinary\r\nPassport Validity: 5 years \r\nFees (Rwf):25,000\r\nAttachments: \r\n1.Copy of the National Id of both parents\r\n2.Application letter signed by the parents\r\n3.Marriage Certificate\r\n4.Signature (Write names of the child)\r\n5.Child passport photo\r\n6.Birth Certificate\r\n\r\nApplicant: 16 and 17 years\r\nPassport Type: Diplomatic\r\nPassport Validity: 5 years \r\nFees (Rwf):50,000\r\nAttachments: \r\n1.Copy of National ID\r\n2.Passport Photo \r\n3.Signature (Write the names of the child)\r\n4.A recommendation letter issued by the Ministry of Foreign Affairs or the Cabinet Resolutions\r\n5.Appointment letter of the parent\r\n6.Other attachments, depending on the selected \"Minor Category,\"\r\n\r\nApplicant: 18 and above\r\nPassport Type: Service\r\nPassport Validity: 5 years \r\nFees (Rwf):15,000\r\nAttachments: \r\n1.Copy of National ID \r\n2.Passport Photo \r\n3.Signature\r\n4.A recommendation letter issued by a government institution\r\n\r\nPassport Type: Ordinary \r\nPassport Validity: 10 years \r\nFees (Rwf):100,000\r\nAttachments: \r\n1.Copy of National ID\r\n2.Passport Photo\r\n3.Signature\r\n\r\nPassport Type: Diplomatic\r\nPassport Validity: 5 years \r\nFees (Rwf):50,000\r\nAttachments: \r\n1.Copy of National ID\r\n2.Passport Photo\r\n3.Signature\r\n4.A recommendation letter issued by MOFA or Cabinet Resolutions\r\n5.Appointment letter of the applicant.                ', '4', '100000', 'DGIW', 'Active', '2026-02-23 13:46:09', '2026-03-04 09:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `provisionaldrivinginfo`
--

CREATE TABLE `provisionaldrivinginfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(150) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provisionaldrivinginfo`
--

INSERT INTO `provisionaldrivinginfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Application for e-Provisional Driving License', 'The e-provisional license is an e-document issued on IremboGov certifying that a citizen has passed their provisional driving test. This service allows Rwandan citizens of age or a foreigner with a resident ID who passed the provisional driving test to request, pay, and have their e-provisional license generated.                                ', '1.A valid registration code is provided in the notification received from Irembo during your registration for the provisional driving license exam.\r\n\r\n2.A valid mobile phone number or email (optional) to receive updates and track your application \r\n\r\n3.You must apply within 2 years of passing your provisional driving license exam.                ', '1', 10000.00, 'RWF', 'RNP', 'Active', '2026-02-24 18:54:18', '2026-03-04 10:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `systeminfo`
--

CREATE TABLE `systeminfo` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `termsofuse` longtext DEFAULT NULL,
  `privacypolicy` longtext DEFAULT NULL,
  `aboutsystem` longtext DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `nationalid` varchar(255) DEFAULT NULL,
  `drivinglicense` varchar(255) DEFAULT NULL,
  `passport` varchar(255) DEFAULT NULL,
  `marriagecertificate` varchar(255) DEFAULT NULL,
  `goodconduct` varchar(255) DEFAULT NULL,
  `provisionaldriving` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `systeminfo`
--

INSERT INTO `systeminfo` (`id`, `name`, `termsofuse`, `privacypolicy`, `aboutsystem`, `icon`, `logo`, `nationalid`, `drivinglicense`, `passport`, `marriagecertificate`, `goodconduct`, `provisionaldriving`, `created_at`) VALUES
(1, 'IremboGov', 'WELCOME. Thank you for visiting Irembo e-gov portal (the \"Portal\"). As is true for many other Web sites, this Portal has rules that apply to your use and any services available through this Portal. Those rules, referred to as \"terms of use\", are set forth in this Terms of Use Agreement. By using this Portal, you are agreeing to comply with and be bound by the following terms of use. Please review them carefully. If you do not agree with any of these terms of use, please do not use this Portal.\r\n\r\nWho owns this portal and how it operates\r\n\r\nThis Portal functions as a real time electronic processing system for services application process between Government Authorities and End-Users and such transactional interface is designed and maintained by the Irembo Ltd., a private company under a concession agreement of 25 year with the Government of Rwanda.\r\n\r\nIt is under the sole responsibility of the Government and each participating Government Authority to develop and maintain the information web pages, backends and supply Irembo with any initial and updated information required during the provision of the services to the End-Users.\r\n\r\nTrademarks\r\n\r\nIrembo and its logo are trademarked by Irembo Ltd. and shall be transferred to the Government at the end of the Agreement.\r\n\r\nRegistration\r\n\r\nYou may be required to register on Irembo Portal account to access some of the online services. However, it is not a requirement when using our USSD *909#.\r\n\r\nUser responsibility\r\n\r\nYou must use www.irembo.gov.rw and your account only for lawful purposes and in a manner that does not infringe the rights of or restrict or inhibit the use and enjoyment of the website by any third party.\r\n\r\nRight to make changes\r\n\r\nIrembo may revise this Privacy Policy from time to time and when such a change is made; we will post a revised version on this Website. Please note that changes are effective when they are posted and it is your responsibility to read the Privacy Policy from time to time in order that you are aware of any such change. In our sole discretion, and if you are a registered user, we may notify you via email associated with your account or by SMS.\r\n\r\nBy continuing to access or use the platform after those changes become effective, you agree to be bound by the revised Privacy Policy.\r\n\r\nCompliance to the regulations\r\n\r\nIrembo regularly reviews compliance with its Privacy Policy. It also adheres to several self-regulatory frameworks. It works with the appropriate regulatory authorities to resolve any complaints on personal data that it cannot resolve with our users directly.', 'This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Platform and tells You about Your privacy rights and how the law protects You.\r\n\r\nWe use Your Personal data to provide You with the Service You apply for and/or those applied on your behalf. By using the Platform, You agree to the collection and use of information in accordance with this Privacy Policy.\r\n\r\nInterpretation and Definitions\r\nInterpretation\r\nThe words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or plural.\r\n\r\nDefinitions\r\nFor the purposes of this Privacy Policy:\r\n\r\nAccount means a unique account created for You to access our Service or parts of our Service.\r\nCompany (referred to as either \"the Company\", \"We\", \"Us\", or \"Our\" in this Agreement) refers to Irembo Ltd, Irembo Campus KG 9 Ave, Nyarutarama, Kigali, Rwanda.\r\nCookies are small files that are placed on Your computer, mobile device or any other device by a website, containing the details of Your browsing history on that website among its many uses.\r\nCountry refers to Rwanda.\r\nDevice means any device that can access the Platform and Services, such as a computer, a cellphone or a digital tablet.\r\nPersonal Data is any information that relates to an identified or identifiable individual.\r\nPlatform refers to the Website.\r\nService means the Company services available on the Website.\r\nService Provider means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service, or to assist the Company in analysing how the Service is used.\r\nUsage Data refers to data collected automatically, either generated by the use of the Platform or from the Platform infrastructure itself (for example, the duration of a page visit).\r\nWebsite refers to IremboGov, accessible from https://irembo.gov.rw\r\nYou means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.\r\nAgent refers to an authorized person who has the right to act on behalf of someone else.\r\nCollecting and Using Your Personal Data\r\nTypes of Data Collected\r\nIrembo collects personal data and sensitive personal data. This data may include, but is not limited to:\r\n\r\nEmail address\r\nOther names and Name\r\nPhone number\r\nNational Identity Numbers\r\nPassport Numbers\r\nAddress, State, Province, City\r\nUsage Data\r\nHow do we collect your data?\r\nYou directly provide Irembo with most of the data through online forms. We collect data and process data when you:\r\n\r\nCreate an account.\r\nWhen you apply for a Service.\r\nWhen you contact our customer support.\r\nWe also collect your data indirectly from other Government bodies only when one component of the data is provided.\r\nWhy do we collect your data?\r\nThe Company may use Personal Data for the following purposes:\r\n\r\nTo provide and maintain our Service, including monitoring the usage of our Service.\r\nTo manage Your Account: to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.\r\nFor the performance of a contract: the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.\r\nTo contact You: To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.\r\nTo manage Your requests: To attend to and manage Your requests to Us.\r\nFor other purposes: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and evaluating and improving our Platform, products, services, marketing and your experience.\r\nWe may share Your personal information in the following situations:\r\n\r\nWith Service Providers: We may share Your personal information with Service Providers to monitor and analyse the use of our Service, to contact You.\r\nWith Affiliates: We may share Your information with Our affiliates, in which case we will require those affiliates to honour this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.\r\nWith business partners: We may share Your information with Our business partners to offer You certain products, services or promotions.\r\nWith other users: when You share personal information or otherwise interact in public areas with other users, such information may be viewed by all users and may be publicly distributed outside.\r\nWith Your consent: We may disclose Your personal information for any other purpose with Your consent.\r\nRetention of Your Personal Data\r\nThe Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations, resolve disputes, and enforce our legal agreements and policies.\r\n\r\nThe Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.\r\n\r\nTransfer of Your Personal Data\r\nYour information, including Personal Data, is processed at the Company\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.\r\n\r\nYour consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.\r\n\r\nThe Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.\r\n\r\nCookies\r\nCookies are text files placed on your computer to collect standard Internet log information and visitor behavior information when using Our Platform.\r\n\r\nWhen you visit Our Platform, we may collect information from you automatically through cookies such as Google analytics, Mixpanel and Fresh Desk to:\r\n\r\nGive us an understanding of how your interact with our platform.\r\nGive us a visibility on Which country Our Platform Users are based.\r\nFetch Our Platform uptime status.\r\nActivate a chat session for feedback collection.\r\nDisclosure of Your Personal Data\r\nLaw enforcement\r\nUnder certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).\r\n\r\nOther legal requirements\r\nThe Company may disclose Your Personal Data in the good faith that such action is necessary to:\r\n\r\nComply with a legal obligation.\r\nProtect and defend the rights or property of the Company.\r\nPrevent or investigate possible wrongdoing in connection with the Service.\r\nProtect the personal safety of Users of the Service or the public.\r\nProtect against legal liability.\r\nSecurity of Your Personal Data\r\nThe security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.\r\n\r\nWhat are your data protection rights?\r\nAs written in the law No 058/21021 of 13/10/2021, every user is entitled to the following:\r\n\r\nThe right to personal data: The data belongs to You.\r\nRight to object: You have the right to request us to stop processing your personal data.\r\nRight to personal data portability: You have the right to request Us to send Your personal data to a different organization where technically feasible or directly to you.\r\nRight not to be subject to a decision based on automated data processing: You have the right not to be subject to a decision based solely on automated personal data processing under certain conditions.\r\nRight to restriction of processing of personal data: You have the right to restrict the data controller from processing your personal data under certain conditions. You can exercise this right by not submitting an application or by not making payment.\r\nRight to erasure of personal data: You have the right to request us to erase your data under certain conditions.\r\nRight to rectification: You have the right to complete incomplete data and to rectify information that may be inaccurate, under certain conditions.\r\nRight to designate an heir to personal data: You have the right to select an heir, under certain conditions.\r\nRight to representation: You have the right to be represented, under certain conditions. Agents must comply to the following while representing You:\r\nAccount Login: Agents should not ask for You for your Irembo account credentials (username, password). The agent should use their own account to apply for the user.\r\nConsent: You should be informed and voluntarily consent before Your information is collected, processed, or shared. Agents must also enter Your phone number and email so the You can track their application. Agents must agree and comply to this note before applying on your behalf.\r\nPurpose Limitation: Agents should only use the information provided for the specific application for which it was requested, to prevent the data from being used for other purposes.\r\nData Minimization: Agents should collect only the information needed for the application and only inquire about information that is relevant to the process.\r\nTransparency: Users have the right to know how their information is collected, processed, and used. Agents should notify and display the information entered by the user before applying. Agents will ensure that they have a notice displayed in the shop informing You about this before hand.\r\nData Sharing: Agents should only share needed information during the escalation process with the appropriate channel (Irembo support team or Territory Coordinators). Agents are reminded that Your information is confidential.\r\nInformation Collection and Deletion: Agents should delete the information and the scanned documents from their computers and phones, immediately after using them in an application.\r\nPayment: When You decide to pay for Irembo services using the various payment methods, Agents should not request Your sensitive information which includes but is not limited to Card information, and mobile money passwords.\r\n\r\nIf you would like to exercise any of these rights, please reach out to Us at our email, dpo@irembo.com, and we’ll respond in not more than 30 days.\r\n\r\nChildren\'s Privacy\r\nTo provide services to a child under the age of sixteen (16) years, consent from anyone who has parental or legal guardians responsibilities over the child in accordance to with the relevant Law is needed.\r\n\r\nLinks to Other Websites\r\nOur Platform may contain links to other websites that we do not operate. If You click on a third-party link, You will be directed to that third-party\'s site. We strongly advise You to review the Privacy Policy of every site You visit.\r\n\r\nWe have no control over and assume no responsibility for any third-party sites or services\' content, privacy policies, or practices.\r\n\r\nChanges to this Privacy Policy\r\nWe may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.\r\n\r\nWe will let You know via email and/or a prominent notice on Our Platform, prior to the change becoming effective, and update the \"Last updated\" date at the top of this Privacy Policy.\r\n\r\nYou are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.', 'Irembo Ltd operates the IremboGov platform, a secure digital gateway that enables citizens, residents, and businesses to access government services online. The system is designed to simplify service delivery by reducing paperwork, minimizing physical visits to offices, and improving efficiency through technology. Users can apply for various public services, make payments electronically, and track application progress in real time. The platform is built with a strong focus on accessibility, transparency, data protection, and user convenience, supporting Rwanda’s vision of digital transformation and improved public service delivery.', '', 'system_69aafff71197f.png', 'system_699d69026faa0.jpg', 'system_699d690270516.jpg', 'system_699d6955a5fe7.jpg', 'system_69aafff7199a8.jpg', 'system_69aafff71c69a.jpg', 'system_69aafff724771.jpg', '2026-02-23 12:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `account_type` enum('Phone','Email') NOT NULL,
  `status` enum('Active','Inactive','Blocked') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `phone`, `email`, `password`, `account_type`, `status`, `created_at`, `updated_at`) VALUES
(2, '+250787936791', 'jetaimetech@gmail.com', '$2y$10$W5/7vpqYW80kMV4t5lnrLexl9XP0rRavLv6X0aYdy57OAnTAU.9au', '', 'Active', '2026-02-26 10:57:42', '2026-02-27 09:44:01'),
(3, '+250789418569', 'kezjoana7@gmail.com', '$2y$10$WTsoDn7BxdCRgprHExn8..O67FpwRxvYDWJ0NE2mRh16IicYZPDJe', '', 'Active', '2026-03-02 19:11:28', '2026-03-04 19:20:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicationcriminalrecord`
--
ALTER TABLE `applicationcriminalrecord`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationdrivinglicense`
--
ALTER TABLE `applicationdrivinglicense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationdrivingreplacement`
--
ALTER TABLE `applicationdrivingreplacement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationgoodconduct`
--
ALTER TABLE `applicationgoodconduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationmarriagecertificate`
--
ALTER TABLE `applicationmarriagecertificate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationnationalid`
--
ALTER TABLE `applicationnationalid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationpassport`
--
ALTER TABLE `applicationpassport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationpassportreplacement`
--
ALTER TABLE `applicationpassportreplacement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationprovisionallicense`
--
ALTER TABLE `applicationprovisionallicense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `citizensregistry`
--
ALTER TABLE `citizensregistry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `national_id` (`national_id`),
  ADD UNIQUE KEY `passport_number` (`passport_number`),
  ADD UNIQUE KEY `provisional_driving_number` (`provisional_driving_number`),
  ADD UNIQUE KEY `driving_license_number` (`driving_license_number`);

--
-- Indexes for table `criminalrecordinfo`
--
ALTER TABLE `criminalrecordinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivinglicenseinfo`
--
ALTER TABLE `drivinglicenseinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goodconductinfo`
--
ALTER TABLE `goodconductinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marriageinfo`
--
ALTER TABLE `marriageinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationalidinfo`
--
ALTER TABLE `nationalidinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passportinfo`
--
ALTER TABLE `passportinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provisionaldrivinginfo`
--
ALTER TABLE `provisionaldrivinginfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `systeminfo`
--
ALTER TABLE `systeminfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_2` (`phone`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicationcriminalrecord`
--
ALTER TABLE `applicationcriminalrecord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `applicationdrivinglicense`
--
ALTER TABLE `applicationdrivinglicense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `applicationdrivingreplacement`
--
ALTER TABLE `applicationdrivingreplacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applicationgoodconduct`
--
ALTER TABLE `applicationgoodconduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `applicationmarriagecertificate`
--
ALTER TABLE `applicationmarriagecertificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applicationnationalid`
--
ALTER TABLE `applicationnationalid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `applicationpassport`
--
ALTER TABLE `applicationpassport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `applicationpassportreplacement`
--
ALTER TABLE `applicationpassportreplacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applicationprovisionallicense`
--
ALTER TABLE `applicationprovisionallicense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `citizensregistry`
--
ALTER TABLE `citizensregistry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `criminalrecordinfo`
--
ALTER TABLE `criminalrecordinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drivinglicenseinfo`
--
ALTER TABLE `drivinglicenseinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `goodconductinfo`
--
ALTER TABLE `goodconductinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marriageinfo`
--
ALTER TABLE `marriageinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nationalidinfo`
--
ALTER TABLE `nationalidinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `passportinfo`
--
ALTER TABLE `passportinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `provisionaldrivinginfo`
--
ALTER TABLE `provisionaldrivinginfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `systeminfo`
--
ALTER TABLE `systeminfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
