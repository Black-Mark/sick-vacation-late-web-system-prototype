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
-- Table structure for table `tbl_useraccounts`
--

CREATE TABLE `tbl_useraccounts` (
  `account_id` int(11) NOT NULL,
  `employee_id` varchar(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photoURL` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `middleName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(255) NOT NULL,
  `civilStatus` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `jobPosition` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `dateStarted` date NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_useraccounts`
--

INSERT INTO `tbl_useraccounts` (`account_id`, `employee_id`, `role`, `email`, `password`, `photoURL`, `firstName`, `middleName`, `lastName`, `suffix`, `birthdate`, `sex`, `civilStatus`, `department`, `jobPosition`, `status`, `dateStarted`, `dateCreated`, `archive`) VALUES
(1, 'PRO001', 'Admin', 'admin@gmail.com', 'Password', '', 'Admin', '', 'Account', '', '2000-01-01', 'Male', 'Single', '1', '1', 'Active', '2023-12-13', '2023-12-13 12:47:22', ''),
(2, 'e67abedc', 'Employee', 'deletedaccount@gmail.com', 'Password', '', 'Deleted', '', 'Account', '', '2001-07-02', 'Male', 'Single', '2', '2', 'Active', '2024-05-28', '2024-05-28 02:00:31', ''),
(3, 'STAFF', 'Staff', 'staff@gmail.com', 'Password', '', 'Staff', '', 'Account', '', '2000-01-01', 'Male', 'Single', '1', '1', 'Active', '2023-03-17', '2024-05-28 02:39:37', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_useraccounts`
--
ALTER TABLE `tbl_useraccounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_useraccounts`
--
ALTER TABLE `tbl_useraccounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
