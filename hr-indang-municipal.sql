-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2024 at 10:57 AM
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
-- Table structure for table `tbl_departments`
--

CREATE TABLE `tbl_departments` (
  `department_id` int(10) NOT NULL,
  `departmentName` varchar(255) NOT NULL,
  `departmentHead` varchar(255) NOT NULL,
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`department_id`, `departmentName`, `departmentHead`, `archive`) VALUES
(7, 'Department of Human Resources', '201910776', ''),
(9, 'Municipal Office', '201915197', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leaveappform`
--

CREATE TABLE `tbl_leaveappform` (
  `leaveappform_id` varchar(100) NOT NULL,
  `dateLastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_id` varchar(100) NOT NULL,
  `departmentName` varchar(150) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `middleName` varchar(100) NOT NULL,
  `dateFiling` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `salary` varchar(100) NOT NULL,
  `typeOfLeave` varchar(100) NOT NULL,
  `typeOfSpecifiedOtherLeave` varchar(255) NOT NULL,
  `typeOfVacationLeave` varchar(100) NOT NULL,
  `typeOfVacationLeaveWithin` varchar(255) NOT NULL,
  `typeOfVacationLeaveAbroad` varchar(255) NOT NULL,
  `typeOfSickLeave` varchar(100) NOT NULL,
  `typeOfSickLeaveInHospital` varchar(255) NOT NULL,
  `typeOfSickLeaveOutPatient` varchar(255) NOT NULL,
  `typeOfSpecialLeaveForWomen` varchar(255) NOT NULL,
  `typeOfStudyLeave` varchar(100) NOT NULL,
  `typeOfOtherLeave` varchar(100) NOT NULL,
  `workingDays` int(50) NOT NULL,
  `inclusiveDateStart` date NOT NULL,
  `inclusiveDateEnd` date NOT NULL,
  `commutation` varchar(100) NOT NULL,
  `asOfDate` date NOT NULL,
  `vacationLeaveTotalEarned` decimal(10,4) NOT NULL,
  `sickLeaveTotalEarned` decimal(10,4) NOT NULL,
  `vacationLeaveLess` decimal(10,4) NOT NULL,
  `sickLeaveLess` decimal(10,4) NOT NULL,
  `vacationLeaveBalance` decimal(10,4) NOT NULL,
  `sickLeaveBalance` decimal(10,4) NOT NULL,
  `recommendation` varchar(100) NOT NULL,
  `recommendMessage` varchar(255) NOT NULL,
  `dayWithPay` int(50) NOT NULL,
  `dayWithoutPay` int(50) NOT NULL,
  `otherDayPay` int(50) NOT NULL,
  `otherDaySpecify` varchar(255) NOT NULL,
  `disapprovedMessage` varchar(255) NOT NULL,
  `hrName` varchar(255) NOT NULL,
  `hrPosition` varchar(100) NOT NULL,
  `deptHeadName` varchar(255) NOT NULL,
  `mayorName` varchar(255) NOT NULL,
  `mayorPosition` varchar(100) NOT NULL,
  `hrmanager_id` varchar(100) NOT NULL,
  `depthead_id` varchar(100) NOT NULL,
  `mayor_id` varchar(100) NOT NULL,
  `status` varchar(80) NOT NULL,
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(290, 'PRO001', '', '2024-04-27 08:45:12', 'Initial Record', '2023-12-13', '2023-12-13', 'Initial Record', '', 0, 0, 0, 25.0000, 0.0000, 25.0000, 0.0000, 25.0000, 0.0000, 25.0000, 0.0000, '2024-04-27', '2024-04-27 08:45:12', '', ''),
(291, '201915197', '', '2024-04-27 08:45:58', 'Initial Record', '2023-11-24', '2024-03-27', 'Initial Record', '', 0, 0, 0, 7.0000, 0.0000, 7.0000, 0.0000, 11.0000, 0.0000, 11.0000, 0.0000, '2024-04-27', '2024-04-27 08:45:58', '', ''),
(292, '201910776', '', '2024-04-27 08:46:15', 'Initial Record', '2023-12-10', '2024-04-27', 'Initial Record', '', 0, 0, 0, 4.0000, 0.0000, 4.0000, 0.0000, 3.0000, 0.0000, 3.0000, 0.0000, '2024-04-27', '2024-04-27 08:46:15', '', ''),
(293, 'STAFF', '', '2024-04-27 08:52:14', 'Initial Record', '2024-04-27', '2024-04-27', 'Initial Record', '', 0, 0, 0, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, '2024-04-27', '2024-04-27 08:52:14', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `notification_id` int(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `empIdFrom` varchar(255) NOT NULL,
  `empIdTo` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `subjectKey` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_passwordreset_tokens`
--

CREATE TABLE `tbl_passwordreset_tokens` (
  `token_id` int(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `employee_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `resetTokenHash` varchar(255) NOT NULL,
  `resetTokenExpiration` datetime NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `dateStarted` date NOT NULL DEFAULT current_timestamp(),
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_useraccounts`
--

INSERT INTO `tbl_useraccounts` (`account_id`, `employee_id`, `role`, `email`, `password`, `photoURL`, `firstName`, `middleName`, `lastName`, `suffix`, `birthdate`, `sex`, `civilStatus`, `department`, `jobPosition`, `status`, `dateStarted`, `dateCreated`, `archive`) VALUES
(78, '201915197', 'Employee', 'reneantonio.dimabogte@cvsu.edu.ph', 'capacio2020', '', 'Rene Antonio', 'Capacio', 'Dimabogte', 'Jr.', '2021-01-01', 'Male', 'Single', '9', 'Grim Reaper', 'Active', '2023-11-24', '2023-11-24 01:56:11', ''),
(84, '201910776', 'Employee', 'maepayad000@gmail.com', 'password', '', 'Nina Mae', 'Lontoc', 'Payad', '', '2024-04-17', 'Female', 'Married', '7', 'Content Creator ', 'Active', '2023-12-10', '2023-12-10 08:05:08', ''),
(91, 'PRO001', 'Admin', 'admin@gmail.com', 'Password', '', 'Admin', '', 'Account', '', '2000-01-01', 'Prefer Not To Say', 'Single', '7', 'Administrator', 'Active', '2023-12-13', '2023-12-13 12:47:22', ''),
(105, 'STAFF', 'Employee', 'staff@gmail.com', 'Password', '', 'Staff', '', 'Account', '', '2024-04-27', 'Prefer Not To Say', 'Single', '7', 'Staff', 'Active', '2024-04-27', '2024-04-27 08:52:13', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `departmentName` (`departmentName`);

--
-- Indexes for table `tbl_leaveappform`
--
ALTER TABLE `tbl_leaveappform`
  ADD PRIMARY KEY (`leaveappform_id`);

--
-- Indexes for table `tbl_leavedataform`
--
ALTER TABLE `tbl_leavedataform`
  ADD PRIMARY KEY (`leavedataform_id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `tbl_passwordreset_tokens`
--
ALTER TABLE `tbl_passwordreset_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD UNIQUE KEY `resetTokenHash` (`resetTokenHash`);

--
-- Indexes for table `tbl_systemsettings`
--
ALTER TABLE `tbl_systemsettings`
  ADD PRIMARY KEY (`setting_id`);

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
-- AUTO_INCREMENT for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  MODIFY `department_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_leavedataform`
--
ALTER TABLE `tbl_leavedataform`
  MODIFY `leavedataform_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `notification_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `tbl_passwordreset_tokens`
--
ALTER TABLE `tbl_passwordreset_tokens`
  MODIFY `token_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_systemsettings`
--
ALTER TABLE `tbl_systemsettings`
  MODIFY `setting_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_useraccounts`
--
ALTER TABLE `tbl_useraccounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
