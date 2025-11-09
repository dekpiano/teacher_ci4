-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 04:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skjacth_academic`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_club_attendance`
--

CREATE TABLE `tb_club_attendance` (
  `tcra_id` int(11) NOT NULL,
  `tcra_club_id` int(11) NOT NULL,
  `trca_schedule_id` int(11) NOT NULL,
  `tcra_teac_id` varchar(20) NOT NULL,
  `tcra_ma` text DEFAULT NULL COMMENT 'มา',
  `tcra_khad` text DEFAULT NULL COMMENT 'ขาด',
  `tcra_rapwy` text DEFAULT NULL COMMENT 'ลาป่วย',
  `tcra_rakic` text DEFAULT NULL COMMENT 'ลากิจ',
  `tcra_kickrrm` text DEFAULT NULL COMMENT 'กิจกรรม',
  `tcra_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_club_members`
--

CREATE TABLE `tb_club_members` (
  `club_member_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `student_id` varchar(17) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_club_onoff`
--

CREATE TABLE `tb_club_onoff` (
  `c_onoff_id` int(11) NOT NULL,
  `c_onoff_year` varchar(10) NOT NULL,
  `c_onoff_regisstart` date NOT NULL,
  `c_onoff_regisend` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_club_onoff`
--

INSERT INTO `tb_club_onoff` (`c_onoff_id`, `c_onoff_year`, `c_onoff_regisstart`, `c_onoff_regisend`) VALUES
(1, '2568/1', '2025-01-01', '2025-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `tb_clubs`
--

CREATE TABLE `tb_clubs` (
  `club_id` int(11) NOT NULL,
  `club_name` varchar(255) NOT NULL,
  `club_description` text DEFAULT NULL,
  `club_faculty_advisor` varchar(20) NOT NULL,
  `club_group` varchar(50) NOT NULL,
  `club_established_date` date DEFAULT NULL,
  `club_max_participants` int(11) DEFAULT 0,
  `club_status` varchar(20) DEFAULT 'open',
  `club_year` varchar(10) DEFAULT NULL,
  `club_trem` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_club_system_settings`
--

CREATE TABLE `tb_club_system_settings` (
  `setting_name` varchar(50) NOT NULL,
  `setting_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_club_system_settings`
--

INSERT INTO `tb_club_system_settings` (`setting_name`, `setting_value`) VALUES
('enable_club_creation', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_club_attendance`
--
ALTER TABLE `tb_club_attendance`
  ADD PRIMARY KEY (`tcra_id`),
  ADD KEY `tcra_club_id` (`tcra_club_id`);

--
-- Indexes for table `tb_club_members`
--
ALTER TABLE `tb_club_members`
  ADD PRIMARY KEY (`club_member_id`),
  ADD KEY `club_id` (`club_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tb_club_onoff`
--
ALTER TABLE `tb_club_onoff`
  ADD PRIMARY KEY (`c_onoff_id`);

--
-- Indexes for table `tb_clubs`
--
ALTER TABLE `tb_clubs`
  ADD PRIMARY KEY (`club_id`);

--
-- Indexes for table `tb_club_system_settings`
--
ALTER TABLE `tb_club_system_settings`
  ADD PRIMARY KEY (`setting_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_club_attendance`
--
ALTER TABLE `tb_club_attendance`
  MODIFY `tcra_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_club_members`
--
ALTER TABLE `tb_club_members`
  MODIFY `club_member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_club_onoff`
--
ALTER TABLE `tb_club_onoff`
  MODIFY `c_onoff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_clubs`
--
ALTER TABLE `tb_clubs`
  MODIFY `club_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
