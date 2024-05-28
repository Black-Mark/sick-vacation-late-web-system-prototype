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
-- Table structure for table `tbl_designations`
--

CREATE TABLE `tbl_designations` (
  `designation_id` int(255) NOT NULL,
  `designationName` varchar(150) NOT NULL,
  `designationDescription` varchar(255) NOT NULL,
  `dateLastModified` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateCreated` date NOT NULL,
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_designations`
--

INSERT INTO `tbl_designations` (`designation_id`, `designationName`, `designationDescription`, `dateLastModified`, `dateCreated`, `archive`) VALUES
(1, 'HR Staff', 'HR staff oversee all aspects of personnel management, from recruitment to employee relations, ensuring a positive work environment.', '2024-05-27 11:35:05', '2024-05-27', ''),
(2, 'Clerk', 'A clerk manages administrative tasks like record-keeping and office organization, providing essential support for smooth operations.', '2024-05-28 02:36:38', '2024-05-28', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_designations`
--
ALTER TABLE `tbl_designations`
  ADD PRIMARY KEY (`designation_id`),
  ADD UNIQUE KEY `designationName` (`designationName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_designations`
--
ALTER TABLE `tbl_designations`
  MODIFY `designation_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
