-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2026 at 05:02 PM
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
-- Table structure for table `academictranscriptinfo`
--

CREATE TABLE `academictranscriptinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academictranscriptinfo`
--

INSERT INTO `academictranscriptinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`) VALUES
(1, 'Academic Transcript Verification', 'Verification of educational records and grades.', '1. Student ID, 2. Transcript Proof', '2 Days', 3000, 'RWF', 'MINEDUC', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `administrativeinfo`
--

CREATE TABLE `administrativeinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicationacademictranscript`
--

CREATE TABLE `applicationacademictranscript` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `school_name` varchar(255) DEFAULT NULL,
  `grad_year` int(11) DEFAULT NULL,
  `ai_verdict` varchar(255) DEFAULT 'Pending',
  `ai_forgery_score` double DEFAULT 0,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationacademictranscript`
--

INSERT INTO `applicationacademictranscript` (`id`, `full_name`, `national_id`, `service_name`, `attachment`, `status`, `admin_reason`, `application_date`, `school_name`, `grad_year`, `ai_verdict`, `ai_forgery_score`, `email`, `phone`, `expected_feedback_date`) VALUES
(1, 'UWASE ISHIMWE 196', '12026800000960', 'Equivalence of Foreign Academic Quals', 'adminsection/academictranscript/1773954832_transcript.jpg', 'Pending', NULL, '2026-03-19 20:13:52', 'fawe girls', 2022, 'Pending AI Scan', 0, 'kezjoana7@gmail.com', '+250789418569', '2026-03-29 22:13:52'),
(2, 'UWASE ISHIMWE 196', '12026800000960', 'Equivalence of Foreign Academic Quals', 'adminsection/academictranscript/1773954874_transcript.jpg', 'Pending', NULL, '2026-03-19 20:14:34', 'fawe girls', 2022, 'Pending AI Scan', 0, 'kezjoana7@gmail.com', '+250789418569', '2026-03-29 22:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `applicationadministrative`
--

CREATE TABLE `applicationadministrative` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ai_verdict` varchar(255) DEFAULT 'Pending',
  `ai_forgery_score` double DEFAULT 0,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicationbankstatement`
--

CREATE TABLE `applicationbankstatement` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `ai_forgery_score` float DEFAULT NULL,
  `ai_verdict` varchar(50) DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicationbusinesslicense`
--

CREATE TABLE `applicationbusinesslicense` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ai_verdict` varchar(255) DEFAULT 'Pending',
  `ai_forgery_score` double DEFAULT 0,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL,
  `tin_number` varchar(100) DEFAULT NULL,
  `business_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicationcommercialbuilding`
--

CREATE TABLE `applicationcommercialbuilding` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ai_verdict` varchar(255) DEFAULT 'Pending',
  `ai_forgery_score` double DEFAULT 0,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicationcourtjudgment`
--

CREATE TABLE `applicationcourtjudgment` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `case_number` varchar(100) DEFAULT NULL,
  `ruling_year` int(11) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `ai_forgery_score` float DEFAULT NULL,
  `ai_verdict` varchar(50) DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(11, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Work', '1772814422_Birth Certificate_Certificate (3).png', 'Criminal Record Certificate', 3, '10000', 'RNP', '2026-03-06 17:27:02', '2026-03-09 17:27:02', 'Pending', '2026-03-06 16:27:02', NULL),
(12, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'work permit', '1773241369_Birth Certificate_Certificate.png', 'Criminal Record Certificate', 3, '10000', 'RNP', '2026-03-11 16:02:49', '2026-03-14 16:02:49', 'Pending', '2026-03-11 15:02:49', NULL);

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
(2, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '12003701862001610', '120030', 'Driving License Replacement', 'Application for Definitive Driving License', 14, 50000.00, 'RWF', '1772639798_license.png', '', '2026-03-04 16:56:38', '2026-03-18 16:56:38', 'Rejected', 'not the right document'),
(3, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', '120030', 'Driving License Replacement', 'Application for Definitive Driving License', 14, 50000.00, 'RWF', '1773241559_license.jpg', '', '2026-03-11 16:05:59', '2026-03-25 16:05:59', 'Pending', NULL),
(4, 'David Inkotanyi', 'd.inkotanyi@gmail.com', '0793277395', '1200480186800162', '120048018', 'Driving License Replacement', 'Application for Definitive Driving License', 14, 50000.00, 'RWF', '1773954681_license.jpg', '', '2026-03-19 22:11:21', '2026-04-02 22:11:21', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationemploymentcontract`
--

CREATE TABLE `applicationemploymentcontract` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ai_verdict` varchar(255) DEFAULT 'Pending',
  `ai_forgery_score` double DEFAULT 0,
  `employer_id` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationemploymentcontract`
--

INSERT INTO `applicationemploymentcontract` (`id`, `full_name`, `national_id`, `service_name`, `attachment`, `status`, `admin_reason`, `application_date`, `ai_verdict`, `ai_forgery_score`, `employer_id`, `job_title`, `email`, `phone`, `expected_feedback_date`) VALUES
(1, 'GAKWAYA UWASE101', '12026800000010', 'Employment Contract Certification', '../adminsection/contract/1773662030_12026800000010.jpg', 'Pending', NULL, '2026-03-09 10:53:50', 'Authentic', 0, '1202680', 'Admin Assistant', 'kezjoana7@gmail.com', '+250789418569', '2026-03-16 12:53:50'),
(2, 'KAREKEZI KEZA 110', '12026800000100', 'Employment Contract Certification', '../adminsection/contract/1773663305_12026800000100.jpg', 'Pending', NULL, '2026-03-16 11:15:05', 'Authentic', 0, '1202680', 'web developer intern', 'kezjoana7@gmail.com', '+250789418569', '2026-03-23 13:15:05'),
(3, 'KAREKEZI KAREKEZI 100', '12026800000000', 'Employment Contract Certification', '../adminsection/contract/1773955171_12026800000000.jpg', 'Pending', NULL, '2026-03-19 20:19:31', 'Authentic', 0, '2562', 'engineer', 'kezjoana7@gmail.com', '+250789418569', '2026-03-26 22:19:31');

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
(4, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Certificate of Good Conduct', 7, 'free', '2026-03-06 16:56:18', '2026-03-13 16:56:18', '1772812578_criminal record.jpg', 'Approved', 'it has been approved'),
(5, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Certificate of Good Conduct', 7, 'free', '2026-03-06 17:28:50', '2026-03-13 17:28:50', '1772814530_Birth Certificate_Certificate (3).png', 'Pending', NULL),
(6, 'Joan', 'kezjoana7@gmail.com', '0789418569', '1199770187300132', 'Certificate of Good Conduct', 7, 'free', '2026-03-19 22:33:23', '2026-03-26 22:33:23', '1773956003_criminal_record_clearance_12026800000020_618.jpg', 'Pending', NULL),
(7, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Certificate of Good Conduct', 7, 'free', '2026-03-20 14:41:38', '2026-03-27 14:41:38', '1774014098_Good Conduct_Certificate (1).jpg', 'Pending', NULL);

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
(2, 'kambanda jackson', 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1230080186200162', '1230070186200162', 'Marriage Certificate', 1, 1000.00, 'RWF', '2026-03-04 18:56:13', '2026-03-05 18:56:13', 'Pending', NULL),
(3, 'David Inkotanyi', 'sonia Umwali', 'soniaumwali@gmail.com', '0789418569', '1200480186800162', '1200570186220165', 'Marriage Certificate', 1, 1000.00, 'RWF', '2026-03-19 22:28:23', '2026-03-20 22:28:23', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationmedicalreport`
--

CREATE TABLE `applicationmedicalreport` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ai_verdict` varchar(255) DEFAULT 'Pending',
  `ai_forgery_score` double DEFAULT 0,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL,
  `hospital_name` varchar(255) DEFAULT NULL,
  `report_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Lost ID Replacement', 'Application for National ID', 30, 500.00, 'RWF', '1772639729_old.png', '', '2026-03-04 16:55:29', '2026-04-03 16:55:29', 'Cancelled', NULL),
(4, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '120037018620016210', 'Lost ID Replacement', 'Application for National ID', 30, 500.00, 'RWF', '1772639969_old.png', '', '2026-03-04 16:59:29', '2026-04-03 16:59:29', 'Pending', NULL),
(5, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Lost ID Replacement', 'Application for National ID', 30, 500.00, 'RWF', '1773051100_old.png', '', '2026-03-09 11:11:40', '2026-04-08 11:11:40', 'Cancelled', NULL),
(6, 'KEZA Joanah', 'kezjoana7@gmail.com', '0789418569', '1200370186200166', 'Lost ID Replacement', 'Application for National ID', 30, 500.00, 'RWF', '1773051168_old.jpg', '', '2026-03-09 11:12:48', '2026-04-08 11:12:48', 'Approved', 'approved'),
(7, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'Lost ID Replacement', 'Application for National ID', 30, 500.00, 'RWF', '1773241480_old.jpg', '', '2026-03-11 16:04:40', '2026-04-10 16:04:40', 'Pending', NULL),
(8, 'Diana Ruzindana', 'rdiana8@gmail.com', '0788830437', '1200270185200154', 'Lost ID Replacement', 'Application for National ID', 30, 500.00, 'RWF', '1773954444_old.jpg', '', '2026-03-19 22:07:24', '2026-04-18 22:07:24', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicationnotarialact`
--

CREATE TABLE `applicationnotarialact` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `act_type` varchar(100) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `ai_forgery_score` float DEFAULT NULL,
  `ai_verdict` varchar(50) DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationnotarialact`
--

INSERT INTO `applicationnotarialact` (`id`, `full_name`, `national_id`, `act_type`, `attachment`, `service_name`, `status`, `admin_reason`, `ai_forgery_score`, `ai_verdict`, `application_date`, `email`, `phone`, `expected_feedback_date`) VALUES
(1, 'Joan', '1200480186800162', 'Certified Copy of Original', '../adminsection/notarialact/1773955553_1200480186800162.jpg', 'Notarial Act Authentication', 'Pending', NULL, 0.01, 'Authentic', '2026-03-19 20:25:53', 'kezjoana7@gmail.com', '+250789418569', '2026-03-22 22:25:53');

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
(3, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'e-Passport Application', 'e-Passport Application', 4, '100000', '2026-03-04 17:04:45', '2026-03-08 17:04:45', 'Pending', NULL),
(4, 'Joan Keza', 'kezjoana7@gmail.com', '0789418569', '1200370186200162', 'e-Passport Application', 'e-Passport Application', 4, '100000', '2026-03-09 16:50:32', '2026-03-13 16:50:32', 'Pending', NULL);

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
-- Table structure for table `applicationpowerofattorney`
--

CREATE TABLE `applicationpowerofattorney` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `appointee_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `ai_forgery_score` float DEFAULT NULL,
  `ai_verdict` varchar(50) DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `appointee_id` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicationpropertyownership`
--

CREATE TABLE `applicationpropertyownership` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ai_verdict` varchar(255) DEFAULT 'Pending',
  `ai_forgery_score` double DEFAULT 0,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL,
  `upi_number` varchar(100) DEFAULT NULL,
  `property_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `applicationsalarycertificate`
--

CREATE TABLE `applicationsalarycertificate` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `employer_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(512) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `admin_reason` text DEFAULT NULL,
  `ai_forgery_score` float DEFAULT NULL,
  `ai_verdict` varchar(50) DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monthly_net` int(11) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expected_feedback_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicationsalarycertificate`
--

INSERT INTO `applicationsalarycertificate` (`id`, `full_name`, `national_id`, `employer_name`, `attachment`, `service_name`, `status`, `admin_reason`, `ai_forgery_score`, `ai_verdict`, `application_date`, `monthly_net`, `email`, `phone`, `expected_feedback_date`) VALUES
(1, 'GAKWAYA UWASE101', '12026800000010', 'GAKWAYA UWASE101', 'adminsection/salaryslip/1773656255_salary.jpg', 'Salary Certificate Verification', 'Pending', NULL, 0, 'Pending AI Scan', '2026-03-16 09:17:34', 500000, '', '', '2026-03-23 11:17:34'),
(2, 'KAREKEZI KAREKEZI 100', '12026800000000', 'KAREKEZI KAREKEZI 100', 'adminsection/salaryslip/1773952700_salary.jpg', 'Salary Certificate Verification', 'Pending', NULL, 0, 'Pending AI Scan', '2026-03-19 19:38:20', 500000, 'kezjoana7@gmail.com', '+250789418569', '2026-03-26 21:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `application_appeals`
--

CREATE TABLE `application_appeals` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `application_type` varchar(100) NOT NULL,
  `citizen_email` varchar(150) NOT NULL,
  `citizen_phone` varchar(20) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('Pending','Received','Resolved') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application_appeals`
--

INSERT INTO `application_appeals` (`id`, `application_id`, `application_type`, `citizen_email`, `citizen_phone`, `message`, `status`, `created_at`) VALUES
(1, 2, 'National ID', 'kezjoana7@gmail.com', '+250789418569', 'it has been delayed', 'Pending', '2026-03-11 17:18:02'),
(2, 3, 'Criminal Record', 'kezjoana7@gmail.com', '+250789418569', 'delayed', 'Pending', '2026-03-11 17:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `bankstatementinfo`
--

CREATE TABLE `bankstatementinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bankstatementinfo`
--

INSERT INTO `bankstatementinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`) VALUES
(1, 'Bank Statement Authentication', 'Authentication of financial records for legal or travel purposes.', '1. Bank ID, 2. Statement PDF', '1 Day', 2000, 'RWF', 'BNR', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `businesslicenseinfo`
--

CREATE TABLE `businesslicenseinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `celibacyinfo`
--

CREATE TABLE `celibacyinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `celibacyinfo`
--

INSERT INTO `celibacyinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`) VALUES
(1, 'Certificate of Celibacy', 'Official proof of single marital status.', '1. ID Copy, 2. Witness Details', '2 Days', 2500, 'RWF', 'MINALOC', 'Active');

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
(16, 'Boris', 'Gisagara', 'Male', '2001-02-05', '1200180185202164', NULL, NULL, NULL, NULL, 'Nyarugenge', '0787568892', 'borisgisagara57@gmail.com', '', 'Single', '', '', '2026-03-06 10:17:06', '2026-03-06 10:17:06'),
(17, 'prosper', 'nkomezi', 'Male', '1994-02-16', '1199480185200154', NULL, NULL, NULL, NULL, NULL, '+250788353538', 'prospernkomezi23@gmail.com', NULL, 'Single', NULL, NULL, '2026-03-10 20:01:57', '2026-03-10 20:01:57'),
(18, 'annet', 'ruhumuriza', 'Female', '1997-11-12', '1199770187300132', NULL, NULL, NULL, NULL, NULL, '+250790773296', 'annetruhumuriza@gmail.com', NULL, 'Single', NULL, NULL, '2026-03-10 20:14:29', '2026-03-10 20:14:29'),
(19, 'KAREKEZI', 'KAREKEZI 100', 'Male', '1996-06-27', '12026800000000', NULL, NULL, NULL, NULL, 'Huye', NULL, 'karekezi0@example.com', NULL, 'Single', 'MUGISHA Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(20, 'GAKWAYA', 'UWASE 101', 'Female', '2003-02-23', '12026800000010', NULL, NULL, NULL, NULL, 'Huye', NULL, 'gakwaya1@example.com', NULL, 'Single', 'MUGISHA Senior', 'MUHIZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(21, 'MUGISHA', 'GAKWAYA 102', 'Male', '1995-04-09', '12026800000020', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'mugisha2@example.com', NULL, 'Single', 'UWASE Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(22, 'KEZA', 'UWASE 103', 'Female', '1995-03-18', '12026800000030', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'keza3@example.com', NULL, 'Single', 'MUTONI Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(23, 'GAKWAYA', 'UWASE 104', 'Female', '1999-01-10', '12026800000040', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'gakwaya4@example.com', NULL, 'Single', 'GAKWAYA Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(24, 'GAKWAYA', 'GAKWAYA 105', 'Female', '1994-07-05', '12026800000050', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'gakwaya5@example.com', NULL, 'Single', 'MUTONI Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(25, 'GAKWAYA', 'KEZA 106', 'Female', '1982-07-02', '12026800000060', NULL, NULL, NULL, NULL, 'Huye', NULL, 'gakwaya6@example.com', NULL, 'Single', 'KEZA Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(26, 'GAKWAYA', 'GAKWAYA 107', 'Female', '2005-06-08', '12026800000070', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'gakwaya7@example.com', NULL, 'Single', 'ISHIMWE Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(27, 'MUHIZI', 'ISHIMWE 108', 'Male', '1992-05-21', '12026800000080', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'muhizi8@example.com', NULL, 'Single', 'GAKWAYA Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(28, 'ISHIMWE', 'KAREKEZI 109', 'Male', '1996-02-17', '12026800000090', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'ishimwe9@example.com', NULL, 'Single', 'ISHIMWE Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(29, 'KAREKEZI', 'KEZA 110', 'Male', '1970-08-19', '12026800000100', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'karekezi10@example.com', NULL, 'Single', 'MUGISHA Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(30, 'KAREKEZI', 'UWASE 111', 'Male', '1971-02-11', '12026800000110', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'karekezi11@example.com', NULL, 'Single', 'MUGISHA Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(31, 'KAREKEZI', 'KEZA 112', 'Female', '1973-09-22', '12026800000120', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'karekezi12@example.com', NULL, 'Single', 'ISHIMWE Senior', 'MUHIZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(32, 'ISHIMWE', 'KEZA 113', 'Male', '2000-01-22', '12026800000130', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'ishimwe13@example.com', NULL, 'Single', 'KEZA Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(33, 'MUGISHA', 'KEZA 114', 'Female', '1995-12-03', '12026800000140', NULL, NULL, NULL, NULL, 'Huye', NULL, 'mugisha14@example.com', NULL, 'Single', 'ISHIMWE Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(34, 'MUHIZI', 'MUGISHA 115', 'Female', '1990-08-26', '12026800000150', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'muhizi15@example.com', NULL, 'Single', 'MUTONI Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(35, 'MUGISHA', 'UWASE 116', 'Male', '1979-07-22', '12026800000160', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'mugisha16@example.com', NULL, 'Single', 'KAREKEZI Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(36, 'MUHIZI', 'GAKWAYA 117', 'Male', '1982-05-03', '12026800000170', NULL, NULL, NULL, NULL, 'Huye', NULL, 'muhizi17@example.com', NULL, 'Single', 'KAREKEZI Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(37, 'MUHIZI', 'MUTONI 118', 'Male', '1984-10-22', '12026800000180', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'muhizi18@example.com', NULL, 'Single', 'KEZA Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(38, 'KAREKEZI', 'MUHIZI 119', 'Male', '1973-12-24', '12026800000190', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'karekezi19@example.com', NULL, 'Single', 'ISHIMWE Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(39, 'ISHIMWE', 'ISHIMWE 120', 'Male', '2004-03-16', '12026800000200', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'ishimwe20@example.com', NULL, 'Single', 'KEZA Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(40, 'KEZA', 'KEZA 121', 'Male', '1980-11-04', '12026800000210', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'keza21@example.com', NULL, 'Single', 'KAREKEZI Senior', 'MUHIZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(41, 'ISHIMWE', 'MUGISHA 122', 'Female', '1991-12-28', '12026800000220', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'ishimwe22@example.com', NULL, 'Single', 'MUGISHA Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(42, 'GAKWAYA', 'KEZA 123', 'Male', '1988-09-05', '12026800000230', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'gakwaya23@example.com', NULL, 'Single', 'MUHIZI Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(43, 'UWASE', 'MUGISHA 124', 'Female', '1973-01-12', '12026800000240', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'uwase24@example.com', NULL, 'Single', 'KEZA Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(44, 'MUGISHA', 'MUHIZI 125', 'Female', '1985-10-09', '12026800000250', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'mugisha25@example.com', NULL, 'Single', 'MUGISHA Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(45, 'MUGISHA', 'UWASE 126', 'Female', '1992-08-18', '12026800000260', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'mugisha26@example.com', NULL, 'Single', 'MUGISHA Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(46, 'MUGISHA', 'ISHIMWE 127', 'Male', '1995-12-27', '12026800000270', NULL, NULL, NULL, NULL, 'Huye', NULL, 'mugisha27@example.com', NULL, 'Single', 'MUHIZI Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(47, 'KEZA', 'UWASE 128', 'Male', '1986-12-04', '12026800000280', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'keza28@example.com', NULL, 'Single', 'UWASE Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(48, 'UWASE', 'MUHIZI 129', 'Male', '1984-02-10', '12026800000290', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'uwase29@example.com', NULL, 'Single', 'KEZA Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(49, 'MUGISHA', 'GAKWAYA 130', 'Female', '2005-03-06', '12026800000300', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'mugisha30@example.com', NULL, 'Single', 'ISHIMWE Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(50, 'MUHIZI', 'ISHIMWE 131', 'Male', '1987-04-15', '12026800000310', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'muhizi31@example.com', NULL, 'Single', 'UWASE Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(51, 'UWASE', 'MUHIZI 132', 'Female', '1993-10-03', '12026800000320', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'uwase32@example.com', NULL, 'Single', 'UWASE Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(52, 'GAKWAYA', 'KAREKEZI 133', 'Female', '2000-02-20', '12026800000330', NULL, NULL, NULL, NULL, 'Huye', NULL, 'gakwaya33@example.com', NULL, 'Single', 'MUGISHA Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(53, 'UWASE', 'MUHIZI 134', 'Male', '2001-08-20', '12026800000340', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'uwase34@example.com', NULL, 'Single', 'MUTONI Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(54, 'KAREKEZI', 'KEZA 135', 'Female', '1999-12-15', '12026800000350', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'karekezi35@example.com', NULL, 'Single', 'KEZA Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(55, 'MUHIZI', 'MUTONI 136', 'Female', '1995-04-19', '12026800000360', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'muhizi36@example.com', NULL, 'Single', 'GAKWAYA Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(56, 'MUHIZI', 'ISHIMWE 137', 'Male', '1974-02-02', '12026800000370', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'muhizi37@example.com', NULL, 'Single', 'MUGISHA Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(57, 'GAKWAYA', 'GAKWAYA 138', 'Female', '1996-07-22', '12026800000380', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'gakwaya38@example.com', NULL, 'Single', 'KAREKEZI Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(58, 'ISHIMWE', 'KEZA 139', 'Male', '1983-05-02', '12026800000390', NULL, NULL, NULL, NULL, 'Huye', NULL, 'ishimwe39@example.com', NULL, 'Single', 'KAREKEZI Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(59, 'GAKWAYA', 'UWASE 140', 'Female', '1989-02-22', '12026800000400', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'gakwaya40@example.com', NULL, 'Single', 'ISHIMWE Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(60, 'UWASE', 'MUHIZI 141', 'Female', '1987-07-06', '12026800000410', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'uwase41@example.com', NULL, 'Single', 'MUTONI Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(61, 'MUTONI', 'MUGISHA 142', 'Male', '1975-06-14', '12026800000420', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'mutoni42@example.com', NULL, 'Single', 'UWASE Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(62, 'GAKWAYA', 'MUHIZI 143', 'Female', '1978-10-26', '12026800000430', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'gakwaya43@example.com', NULL, 'Single', 'UWASE Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(63, 'UWASE', 'KEZA 144', 'Male', '1981-04-12', '12026800000440', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'uwase44@example.com', NULL, 'Single', 'MUTONI Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(64, 'KEZA', 'MUHIZI 145', 'Male', '1975-01-18', '12026800000450', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'keza45@example.com', NULL, 'Single', 'UWASE Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(65, 'KEZA', 'MUHIZI 146', 'Female', '1978-04-11', '12026800000460', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'keza46@example.com', NULL, 'Single', 'KEZA Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(66, 'GAKWAYA', 'KEZA 147', 'Male', '1972-06-10', '12026800000470', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'gakwaya47@example.com', NULL, 'Single', 'UWASE Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(67, 'UWASE', 'MUHIZI 148', 'Female', '1978-02-05', '12026800000480', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'uwase48@example.com', NULL, 'Single', 'UWASE Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(68, 'MUHIZI', 'ISHIMWE 149', 'Female', '1997-08-16', '12026800000490', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'muhizi49@example.com', NULL, 'Single', 'KEZA Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(69, 'KEZA', 'KEZA 150', 'Female', '2003-11-23', '12026800000500', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'keza50@example.com', NULL, 'Single', 'MUGISHA Senior', 'MUHIZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(70, 'GAKWAYA', 'GAKWAYA 151', 'Female', '1985-08-16', '12026800000510', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'gakwaya51@example.com', NULL, 'Single', 'KEZA Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(71, 'ISHIMWE', 'UWASE 152', 'Female', '1984-10-12', '12026800000520', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'ishimwe52@example.com', NULL, 'Single', 'KAREKEZI Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(72, 'GAKWAYA', 'UWASE 153', 'Female', '1979-03-17', '12026800000530', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'gakwaya53@example.com', NULL, 'Single', 'GAKWAYA Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(73, 'MUHIZI', 'MUHIZI 154', 'Female', '1984-01-02', '12026800000540', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'muhizi54@example.com', NULL, 'Single', 'UWASE Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(74, 'MUGISHA', 'MUHIZI 155', 'Female', '1972-03-21', '12026800000550', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'mugisha55@example.com', NULL, 'Single', 'MUHIZI Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(75, 'GAKWAYA', 'MUTONI 156', 'Female', '1997-01-09', '12026800000560', NULL, NULL, NULL, NULL, 'Huye', NULL, 'gakwaya56@example.com', NULL, 'Single', 'UWASE Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(76, 'MUTONI', 'KEZA 157', 'Male', '1985-07-03', '12026800000570', NULL, NULL, NULL, NULL, 'Huye', NULL, 'mutoni57@example.com', NULL, 'Single', 'KEZA Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(77, 'GAKWAYA', 'KAREKEZI 158', 'Male', '2003-10-13', '12026800000580', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'gakwaya58@example.com', NULL, 'Single', 'MUGISHA Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(78, 'KEZA', 'GAKWAYA 159', 'Female', '1981-07-10', '12026800000590', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'keza59@example.com', NULL, 'Single', 'KAREKEZI Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(79, 'GAKWAYA', 'ISHIMWE 160', 'Female', '1975-03-14', '12026800000600', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'gakwaya60@example.com', NULL, 'Single', 'UWASE Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(80, 'ISHIMWE', 'UWASE 161', 'Female', '1986-05-08', '12026800000610', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'ishimwe61@example.com', NULL, 'Single', 'KEZA Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(81, 'MUTONI', 'ISHIMWE 162', 'Male', '1999-08-01', '12026800000620', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'mutoni62@example.com', NULL, 'Single', 'UWASE Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(82, 'MUGISHA', 'GAKWAYA 163', 'Male', '1978-01-06', '12026800000630', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'mugisha63@example.com', NULL, 'Single', 'KAREKEZI Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(83, 'MUHIZI', 'MUTONI 164', 'Male', '1991-03-15', '12026800000640', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'muhizi64@example.com', NULL, 'Single', 'UWASE Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(84, 'MUHIZI', 'UWASE 165', 'Female', '1977-08-21', '12026800000650', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'muhizi65@example.com', NULL, 'Single', 'KEZA Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(85, 'MUHIZI', 'UWASE 166', 'Male', '1989-06-24', '12026800000660', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'muhizi66@example.com', NULL, 'Single', 'KAREKEZI Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(86, 'MUGISHA', 'UWASE 167', 'Male', '1985-05-27', '12026800000670', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'mugisha67@example.com', NULL, 'Single', 'KEZA Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(87, 'UWASE', 'MUTONI 168', 'Male', '1973-09-22', '12026800000680', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'uwase68@example.com', NULL, 'Single', 'KAREKEZI Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(88, 'KAREKEZI', 'ISHIMWE 169', 'Male', '1991-08-20', '12026800000690', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'karekezi69@example.com', NULL, 'Single', 'UWASE Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(89, 'UWASE', 'ISHIMWE 170', 'Female', '1978-03-13', '12026800000700', NULL, NULL, NULL, NULL, 'Huye', NULL, 'uwase70@example.com', NULL, 'Single', 'ISHIMWE Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(90, 'GAKWAYA', 'ISHIMWE 171', 'Male', '2004-07-09', '12026800000710', NULL, NULL, NULL, NULL, 'Huye', NULL, 'gakwaya71@example.com', NULL, 'Single', 'UWASE Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(91, 'KEZA', 'GAKWAYA 172', 'Female', '1991-11-26', '12026800000720', NULL, NULL, NULL, NULL, 'Huye', NULL, 'keza72@example.com', NULL, 'Single', 'KAREKEZI Senior', 'MUHIZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(92, 'KAREKEZI', 'KAREKEZI 173', 'Female', '1979-12-27', '12026800000730', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'karekezi73@example.com', NULL, 'Single', 'KEZA Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(93, 'MUGISHA', 'ISHIMWE 174', 'Male', '1977-09-09', '12026800000740', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'mugisha74@example.com', NULL, 'Single', 'MUHIZI Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(94, 'KEZA', 'ISHIMWE 175', 'Female', '2000-11-03', '12026800000750', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'keza75@example.com', NULL, 'Single', 'MUTONI Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(95, 'GAKWAYA', 'KAREKEZI 176', 'Female', '1974-04-15', '12026800000760', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'gakwaya76@example.com', NULL, 'Single', 'MUGISHA Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(96, 'MUTONI', 'MUGISHA 177', 'Female', '2001-01-04', '12026800000770', NULL, NULL, NULL, NULL, 'Huye', NULL, 'mutoni77@example.com', NULL, 'Single', 'GAKWAYA Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(97, 'UWASE', 'KEZA 178', 'Female', '1970-10-01', '12026800000780', NULL, NULL, NULL, NULL, 'Huye', NULL, 'uwase78@example.com', NULL, 'Single', 'MUHIZI Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(98, 'ISHIMWE', 'UWASE 179', 'Female', '1970-10-06', '12026800000790', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'ishimwe79@example.com', NULL, 'Single', 'KEZA Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(99, 'GAKWAYA', 'UWASE 180', 'Male', '2002-02-09', '12026800000800', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'gakwaya80@example.com', NULL, 'Single', 'MUGISHA Senior', 'UWASE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(100, 'MUHIZI', 'KEZA 181', 'Female', '2005-06-09', '12026800000810', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'muhizi81@example.com', NULL, 'Single', 'MUGISHA Senior', 'MUHIZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(101, 'MUGISHA', 'GAKWAYA 182', 'Female', '2000-12-06', '12026800000820', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'mugisha82@example.com', NULL, 'Single', 'GAKWAYA Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(102, 'MUGISHA', 'KEZA 183', 'Male', '1970-10-28', '12026800000830', NULL, NULL, NULL, NULL, 'Huye', NULL, 'mugisha83@example.com', NULL, 'Single', 'KAREKEZI Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(103, 'ISHIMWE', 'ISHIMWE 184', 'Female', '1971-01-02', '12026800000840', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'ishimwe84@example.com', NULL, 'Single', 'KEZA Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(104, 'MUHIZI', 'KAREKEZI 185', 'Male', '1990-10-24', '12026800000850', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'muhizi85@example.com', NULL, 'Single', 'MUTONI Senior', 'MUHIZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(105, 'ISHIMWE', 'ISHIMWE 186', 'Male', '1990-02-02', '12026800000860', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'ishimwe86@example.com', NULL, 'Single', 'KEZA Senior', 'MUHIZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(106, 'KEZA', 'KEZA 187', 'Male', '1998-06-22', '12026800000870', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'keza87@example.com', NULL, 'Single', 'KEZA Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(107, 'MUGISHA', 'MUGISHA 188', 'Female', '1976-01-10', '12026800000880', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'mugisha88@example.com', NULL, 'Single', 'KEZA Senior', 'MUHIZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(108, 'MUGISHA', 'GAKWAYA 189', 'Male', '1992-06-18', '12026800000890', NULL, NULL, NULL, NULL, 'Rubavu', NULL, 'mugisha89@example.com', NULL, 'Single', 'ISHIMWE Senior', 'KEZA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(109, 'GAKWAYA', 'MUTONI 190', 'Male', '1975-01-19', '12026800000900', NULL, NULL, NULL, NULL, 'Musanze', NULL, 'gakwaya90@example.com', NULL, 'Single', 'GAKWAYA Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(110, 'MUTONI', 'KAREKEZI 191', 'Male', '1991-01-15', '12026800000910', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'mutoni91@example.com', NULL, 'Single', 'KAREKEZI Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(111, 'ISHIMWE', 'MUHIZI 192', 'Female', '1987-07-22', '12026800000920', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'ishimwe92@example.com', NULL, 'Single', 'UWASE Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(112, 'ISHIMWE', 'ISHIMWE 193', 'Male', '2005-04-18', '12026800000930', NULL, NULL, NULL, NULL, 'Huye', NULL, 'ishimwe93@example.com', NULL, 'Single', 'UWASE Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(113, 'UWASE', 'KAREKEZI 194', 'Female', '1980-03-28', '12026800000940', NULL, NULL, NULL, NULL, 'Huye', NULL, 'uwase94@example.com', NULL, 'Single', 'MUGISHA Senior', 'ISHIMWE Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(114, 'GAKWAYA', 'MUTONI 195', 'Female', '1991-04-23', '12026800000950', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'gakwaya95@example.com', NULL, 'Single', 'KEZA Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(115, 'UWASE', 'ISHIMWE 196', 'Male', '1975-07-19', '12026800000960', NULL, NULL, NULL, NULL, 'Kigali', NULL, 'uwase96@example.com', NULL, 'Single', 'ISHIMWE Senior', 'MUGISHA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(116, 'GAKWAYA', 'ISHIMWE 197', 'Male', '1980-08-23', '12026800000970', NULL, NULL, NULL, NULL, 'Huye', NULL, 'gakwaya97@example.com', NULL, 'Single', 'MUGISHA Senior', 'GAKWAYA Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(117, 'MUGISHA', 'GAKWAYA 198', 'Female', '2003-04-28', '12026800000980', NULL, NULL, NULL, NULL, 'Rwamagana', NULL, 'mugisha98@example.com', NULL, 'Single', 'MUHIZI Senior', 'MUTONI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16'),
(118, 'GAKWAYA', 'GAKWAYA 199', 'Male', '2001-03-05', '12026800000990', NULL, NULL, NULL, NULL, 'Huye', NULL, 'gakwaya99@example.com', NULL, 'Single', 'UWASE Senior', 'KAREKEZI Senior', '2026-03-13 12:38:16', '2026-03-13 12:38:16');

-- --------------------------------------------------------

--
-- Table structure for table `commercialbuildinginfo`
--

CREATE TABLE `commercialbuildinginfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractinfo`
--

CREATE TABLE `contractinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractinfo`
--

INSERT INTO `contractinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`) VALUES
(1, 'Employment Contract Authentication', 'Verification and authentication of labor agreements.', '1. Employer ID, 2. signed contract', '1 Day', 5000, 'RWF', 'MINALOC', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `courtjudgmentinfo`
--

CREATE TABLE `courtjudgmentinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courtjudgmentinfo`
--

INSERT INTO `courtjudgmentinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`) VALUES
(1, 'Court Judgment Copy', 'Certified copy of a formal court ruling or decision.', '1. Case Number, 2. ID Copy', '3 Days', 5000, 'RWF', 'MINIJUST', 'Active');

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
-- Table structure for table `employmentcontractinfo`
--

CREATE TABLE `employmentcontractinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `medicalreportinfo`
--

CREATE TABLE `medicalreportinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `notarialactinfo`
--

CREATE TABLE `notarialactinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notarialactinfo`
--

INSERT INTO `notarialactinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`) VALUES
(1, 'Notarial Act Authentication', 'Legal certification of documents by a public notary.', '1. Original Document, 2. ID Copy', '1 Day', 5000, 'RWF', 'MINIJUST', 'Active');

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
-- Table structure for table `poainfo`
--

CREATE TABLE `poainfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poainfo`
--

INSERT INTO `poainfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`) VALUES
(1, 'Power of Attorney', 'Legal authorization to act on behalf of another person.', '1. Grantor ID, 2. Proxy Details', '2 Days', 10000, 'RWF', 'MINIJUST', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `powerofattorneyinfo`
--

CREATE TABLE `powerofattorneyinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `propertyownershipinfo`
--

CREATE TABLE `propertyownershipinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `salarycertificateinfo`
--

CREATE TABLE `salarycertificateinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'RWF',
  `provided_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salaryslipinfo`
--

CREATE TABLE `salaryslipinfo` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `processing_time` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salaryslipinfo`
--

INSERT INTO `salaryslipinfo` (`id`, `service_name`, `description`, `requirements`, `processing_time`, `price`, `currency`, `provided_by`, `status`) VALUES
(1, 'Salary Certificate', 'Verification of employment and income from an employer.', '1. Employer ID, 2. Financial records', '1 Day', 1500, 'RWF', 'MINALOC', 'Active');

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
  `full_name` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `national_id` varchar(30) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `full_name`, `gender`, `dob`, `national_id`, `phone`, `email`, `password`, `account_type`, `status`, `created_at`, `updated_at`) VALUES
(2, NULL, NULL, NULL, NULL, '+250787936791', 'jetaimetech@gmail.com', '$2y$10$W5/7vpqYW80kMV4t5lnrLexl9XP0rRavLv6X0aYdy57OAnTAU.9au', '', 'Active', '2026-02-26 10:57:42', '2026-02-27 09:44:01'),
(3, 'Kez Joana', NULL, '2003-10-10', '1199880011223344', '+250789418569', 'kezjoana7@gmail.com', '$2y$10$WTsoDn7BxdCRgprHExn8..O67FpwRxvYDWJ0NE2mRh16IicYZPDJe', '', 'Active', '2026-03-02 19:11:28', '2026-03-10 19:48:16'),
(6, 'kevine uwimana', NULL, NULL, NULL, '+250780828384', 'joankeza023@gmail.com', '$2y$10$DhnFH4GXFqfUMVMOBHwnOuCGxKnGkVD1RLkvdG46aoRg95MpQtlkS', '', 'Active', '2026-03-10 17:29:38', '2026-03-10 17:29:38'),
(7, 'nasrah signoritha', NULL, '2000-05-05', '1200080186700163', '+250788834572', 'nasrahsignoritha2@gmail.com', '$2y$10$kKMjUaM.smMGO1vEotqnSO8cBYocFMKZFNgARYMv/Q0q9qeFpjwH2', '', 'Active', '2026-03-10 19:46:16', '2026-03-10 19:46:16'),
(8, 'prosper nkomezi', NULL, '1994-02-16', '1199480185200154', '+250788353538', 'prospernkomezi23@gmail.com', '$2y$10$pVExcZk5LbbWuygqaqmUduEtgMJnwo1i.Ol.VFjUuevMa21k5Mbg6', '', 'Active', '2026-03-10 20:01:57', '2026-03-10 20:01:57'),
(9, 'annet ruhumuriza', NULL, '1997-11-12', '1199770187300132', '+250790773296', 'annetruhumuriza@gmail.com', '$2y$10$M2KiLRnkYOVMV.2Dh8ElHu4WNYxoen9gm.tTJo/Acht4qwOwSIuPG', '', 'Active', '2026-03-10 20:14:29', '2026-03-10 20:14:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academictranscriptinfo`
--
ALTER TABLE `academictranscriptinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrativeinfo`
--
ALTER TABLE `administrativeinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationacademictranscript`
--
ALTER TABLE `applicationacademictranscript`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationadministrative`
--
ALTER TABLE `applicationadministrative`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationbankstatement`
--
ALTER TABLE `applicationbankstatement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationbusinesslicense`
--
ALTER TABLE `applicationbusinesslicense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationcommercialbuilding`
--
ALTER TABLE `applicationcommercialbuilding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationcourtjudgment`
--
ALTER TABLE `applicationcourtjudgment`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `applicationemploymentcontract`
--
ALTER TABLE `applicationemploymentcontract`
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
-- Indexes for table `applicationmedicalreport`
--
ALTER TABLE `applicationmedicalreport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationnationalid`
--
ALTER TABLE `applicationnationalid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationnotarialact`
--
ALTER TABLE `applicationnotarialact`
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
-- Indexes for table `applicationpowerofattorney`
--
ALTER TABLE `applicationpowerofattorney`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationpropertyownership`
--
ALTER TABLE `applicationpropertyownership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationprovisionallicense`
--
ALTER TABLE `applicationprovisionallicense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationsalarycertificate`
--
ALTER TABLE `applicationsalarycertificate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_appeals`
--
ALTER TABLE `application_appeals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankstatementinfo`
--
ALTER TABLE `bankstatementinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `businesslicenseinfo`
--
ALTER TABLE `businesslicenseinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `celibacyinfo`
--
ALTER TABLE `celibacyinfo`
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
-- Indexes for table `commercialbuildinginfo`
--
ALTER TABLE `commercialbuildinginfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contractinfo`
--
ALTER TABLE `contractinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courtjudgmentinfo`
--
ALTER TABLE `courtjudgmentinfo`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `employmentcontractinfo`
--
ALTER TABLE `employmentcontractinfo`
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
-- Indexes for table `medicalreportinfo`
--
ALTER TABLE `medicalreportinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationalidinfo`
--
ALTER TABLE `nationalidinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notarialactinfo`
--
ALTER TABLE `notarialactinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passportinfo`
--
ALTER TABLE `passportinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poainfo`
--
ALTER TABLE `poainfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `powerofattorneyinfo`
--
ALTER TABLE `powerofattorneyinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `propertyownershipinfo`
--
ALTER TABLE `propertyownershipinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provisionaldrivinginfo`
--
ALTER TABLE `provisionaldrivinginfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salarycertificateinfo`
--
ALTER TABLE `salarycertificateinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salaryslipinfo`
--
ALTER TABLE `salaryslipinfo`
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
-- AUTO_INCREMENT for table `academictranscriptinfo`
--
ALTER TABLE `academictranscriptinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `administrativeinfo`
--
ALTER TABLE `administrativeinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationacademictranscript`
--
ALTER TABLE `applicationacademictranscript`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applicationadministrative`
--
ALTER TABLE `applicationadministrative`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationbankstatement`
--
ALTER TABLE `applicationbankstatement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationbusinesslicense`
--
ALTER TABLE `applicationbusinesslicense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationcommercialbuilding`
--
ALTER TABLE `applicationcommercialbuilding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationcourtjudgment`
--
ALTER TABLE `applicationcourtjudgment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationcriminalrecord`
--
ALTER TABLE `applicationcriminalrecord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `applicationdrivinglicense`
--
ALTER TABLE `applicationdrivinglicense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `applicationdrivingreplacement`
--
ALTER TABLE `applicationdrivingreplacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `applicationemploymentcontract`
--
ALTER TABLE `applicationemploymentcontract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `applicationgoodconduct`
--
ALTER TABLE `applicationgoodconduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `applicationmarriagecertificate`
--
ALTER TABLE `applicationmarriagecertificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `applicationmedicalreport`
--
ALTER TABLE `applicationmedicalreport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationnationalid`
--
ALTER TABLE `applicationnationalid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `applicationnotarialact`
--
ALTER TABLE `applicationnotarialact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicationpassport`
--
ALTER TABLE `applicationpassport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `applicationpassportreplacement`
--
ALTER TABLE `applicationpassportreplacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applicationpowerofattorney`
--
ALTER TABLE `applicationpowerofattorney`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationpropertyownership`
--
ALTER TABLE `applicationpropertyownership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationprovisionallicense`
--
ALTER TABLE `applicationprovisionallicense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `applicationsalarycertificate`
--
ALTER TABLE `applicationsalarycertificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `application_appeals`
--
ALTER TABLE `application_appeals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bankstatementinfo`
--
ALTER TABLE `bankstatementinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `businesslicenseinfo`
--
ALTER TABLE `businesslicenseinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `celibacyinfo`
--
ALTER TABLE `celibacyinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `citizensregistry`
--
ALTER TABLE `citizensregistry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `commercialbuildinginfo`
--
ALTER TABLE `commercialbuildinginfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractinfo`
--
ALTER TABLE `contractinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courtjudgmentinfo`
--
ALTER TABLE `courtjudgmentinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `employmentcontractinfo`
--
ALTER TABLE `employmentcontractinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `medicalreportinfo`
--
ALTER TABLE `medicalreportinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nationalidinfo`
--
ALTER TABLE `nationalidinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notarialactinfo`
--
ALTER TABLE `notarialactinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `passportinfo`
--
ALTER TABLE `passportinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `poainfo`
--
ALTER TABLE `poainfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `powerofattorneyinfo`
--
ALTER TABLE `powerofattorneyinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `propertyownershipinfo`
--
ALTER TABLE `propertyownershipinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provisionaldrivinginfo`
--
ALTER TABLE `provisionaldrivinginfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salarycertificateinfo`
--
ALTER TABLE `salarycertificateinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salaryslipinfo`
--
ALTER TABLE `salaryslipinfo`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
