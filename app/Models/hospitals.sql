-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2026 at 02:14 PM
-- Server version: 11.3.1-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospitalmanagementsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL COMMENT 'e.g., General, Specialized, Clinic',
  `logo` varchar(255) DEFAULT NULL COMMENT 'Path to the logo image file',
  `slogan` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `country` text NOT NULL,
  `zone` varchar(255) NOT NULL,
  `woreda` varchar(255) NOT NULL,
  `kebele` varchar(255) NOT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `capacity_beds` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `name`, `registration_number`, `type`, `logo`, `slogan`, `email`, `phone_number`, `emergency_contact`, `country`, `zone`, `woreda`, `kebele`, `zip_code`, `capacity_beds`, `is_active`, `website`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Agew midr General Hospital', '121q1', 'General', 'uploads/hospitals/1771682339_SIMS.png', NULL, 'andualem1164@gmail.com', '0919344690', '3434', 'Ethiopia', 'Awi Zone', 'Guji', '02', NULL, 45, 1, 'https://etcodenet.com', '2026-02-21 10:58:59', '2026-02-21 10:58:59', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hospitals_email_unique` (`email`),
  ADD UNIQUE KEY `hospitals_registration_number_unique` (`registration_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
