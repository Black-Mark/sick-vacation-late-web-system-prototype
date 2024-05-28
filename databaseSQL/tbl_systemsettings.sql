-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 02:30 AM
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
-- Table structure for table `tbl_systemsettings`
--

CREATE TABLE `tbl_systemsettings` (
  `setting_id` int(255) NOT NULL,
  `settingType` varchar(255) NOT NULL,
  `settingSubject` varchar(255) NOT NULL,
  `settingKey` varchar(255) NOT NULL,
  `settingInCharge` varchar(255) NOT NULL,
  `dateModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_systemsettings`
--

INSERT INTO `tbl_systemsettings` (`setting_id`, `settingType`, `settingSubject`, `settingKey`, `settingInCharge`, `dateModified`) VALUES
(1, 'Authorized User', 'Human Resources Manager', '201910776', '', '2024-04-03 01:44:33'),
(2, 'Authorized User', 'Municipal Mayor', '201915197', '', '2023-12-12 11:52:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_systemsettings`
--
ALTER TABLE `tbl_systemsettings`
  ADD PRIMARY KEY (`setting_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_systemsettings`
--
ALTER TABLE `tbl_systemsettings`
  MODIFY `setting_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
