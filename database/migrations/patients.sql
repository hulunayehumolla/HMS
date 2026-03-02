-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2026 at 02:03 PM
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
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `age` int(11) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `region` varchar(255) NOT NULL,
  `zone` varchar(255) DEFAULT NULL,
  `woreda` varchar(255) DEFAULT NULL,
  `kebele` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `is_referred` tinyint(1) NOT NULL DEFAULT 0,
  `is_insurance_user` tinyint(1) NOT NULL DEFAULT 0,
  `referred_from` varchar(255) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_id`, `first_name`, `middle_name`, `last_name`, `gender`, `age`, `date_of_birth`, `phone`, `email`, `country`, `region`, `zone`, `woreda`, `kebele`, `blood_type`, `is_referred`, `is_insurance_user`, `referred_from`, `emergency_contact_name`, `emergency_contact_phone`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PT-20260221-7116', 'Andualem', 'wert', 'Muche', 'male', 0, '2026-02-02', '911344760', 'andualem1164@gmail.com', 'Ethiopia', '', 'Awi Zone', 'Guji', '02', 'A', 0, 1, 'ffg', 'fgfg', 'fgfg', '2026-02-21 11:44:40', '2026-02-21 11:44:40', NULL),
(2, 'PT-20260223-6062', 'Andualem', 'wert', 'Muche', 'male', 4, '2021-12-27', '911344760', 'andualem1164@gmail.com', 'Ethiopia', 'Amhara', 'North Gondar', 'Adi Arkay', '01', 'O+', 1, 1, 'sdsdsd', 'Andualem Muche', 'fgfg', '2026-02-23 05:07:29', '2026-02-23 05:07:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_patient_id_unique` (`patient_id`),
  ADD KEY `patients_gender_index` (`gender`),
  ADD KEY `patients_phone_index` (`phone`),
  ADD KEY `patients_email_index` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
