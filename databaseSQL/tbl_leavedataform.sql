-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 05:59 AM
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
-- Database: `hr-indang-municipal`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leavedataform`
--

CREATE TABLE `tbl_leavedataform` (
  `leavedataform_id` int(255) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `foreignKeyId` varchar(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `recordType` varchar(255) NOT NULL,
  `period` date NOT NULL,
  `periodEnd` date NOT NULL,
  `particular` varchar(255) NOT NULL,
  `particularLabel` varchar(255) NOT NULL,
  `days` int(255) NOT NULL,
  `hours` int(255) NOT NULL,
  `minutes` int(255) NOT NULL,
  `vacationLeaveEarned` decimal(10,4) NOT NULL,
  `vacationLeaveAbsUndWP` decimal(10,4) NOT NULL,
  `vacationLeaveBalance` decimal(10,4) NOT NULL,
  `vacationLeaveAbsUndWOP` decimal(10,4) NOT NULL,
  `sickLeaveEarned` decimal(10,4) NOT NULL,
  `sickLeaveAbsUndWP` decimal(10,4) NOT NULL,
  `sickLeaveBalance` decimal(10,4) NOT NULL,
  `sickLeaveAbsUndWOP` decimal(10,4) NOT NULL,
  `dateOfAction` date NOT NULL,
  `dateLastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `leaveform_connectionId` varchar(100) NOT NULL,
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_leavedataform`
--

INSERT INTO `tbl_leavedataform` (`leavedataform_id`, `employee_id`, `foreignKeyId`, `dateCreated`, `recordType`, `period`, `periodEnd`, `particular`, `particularLabel`, `days`, `hours`, `minutes`, `vacationLeaveEarned`, `vacationLeaveAbsUndWP`, `vacationLeaveBalance`, `vacationLeaveAbsUndWOP`, `sickLeaveEarned`, `sickLeaveAbsUndWP`, `sickLeaveBalance`, `sickLeaveAbsUndWOP`, `dateOfAction`, `dateLastModified`, `leaveform_connectionId`, `archive`) VALUES
(1, 'e67abedc', '', '2024-05-28 02:00:31', 'Initial Record', '2024-05-28', '2024-05-28', 'Initial Record', '', 0, 0, 0, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, '2024-05-28', '2024-05-28 02:00:31', '', ''),
(2, 'STAFF', '', '2024-05-28 02:39:38', 'Initial Record', '2023-03-17', '2024-05-28', 'Initial Record', '', 0, 0, 0, 9.0000, 0.0000, 9.0000, 0.0000, 13.5000, 0.0000, 13.5000, 0.0000, '2024-05-28', '2024-05-28 02:39:38', '', ''),
(3, 'PRO001', '', '2024-05-28 03:30:45', 'Initial Record', '2023-12-13', '2024-05-28', 'Initial Record', '', 0, 0, 0, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, '2024-05-28', '2024-05-28 03:30:45', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_leavedataform`
--
ALTER TABLE `tbl_leavedataform`
  ADD PRIMARY KEY (`leavedataform_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_leavedataform`
--
ALTER TABLE `tbl_leavedataform`
  MODIFY `leavedataform_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
