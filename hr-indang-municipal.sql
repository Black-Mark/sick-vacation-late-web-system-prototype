-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 06:50 AM
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
  `departmentHead` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`department_id`, `departmentName`, `departmentHead`) VALUES
(2, 'Department of Human Resources', 'PRO001'),
(4, 'Department of Death', '201915197');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leaveappform`
--

CREATE TABLE `tbl_leaveappform` (
  `leaveappform_id` int(255) NOT NULL,
  `dateLastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_id` varchar(255) NOT NULL,
  `departmentName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `middleName` varchar(255) NOT NULL,
  `dateFiling` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `salary` varchar(255) NOT NULL,
  `typeOfLeave` varchar(255) NOT NULL,
  `typeOfSpecifiedOtherLeave` varchar(255) NOT NULL,
  `typeOfVacationLeave` varchar(255) NOT NULL,
  `typeOfVacationLeaveWithin` varchar(255) NOT NULL,
  `typeOfVacationLeaveAbroad` varchar(255) NOT NULL,
  `typeOfSickLeave` varchar(255) NOT NULL,
  `typeOfSickLeaveInHospital` varchar(255) NOT NULL,
  `typeOfSickLeaveOutPatient` varchar(255) NOT NULL,
  `typeOfSpecialLeaveForWomen` varchar(255) NOT NULL,
  `typeOfStudyLeave` varchar(255) NOT NULL,
  `typeOfOtherLeave` varchar(255) NOT NULL,
  `workingDays` int(10) NOT NULL,
  `inclusiveDates` varchar(255) NOT NULL,
  `commutation` varchar(255) NOT NULL,
  `asOfDate` date NOT NULL,
  `vacationLeaveTotalEarned` decimal(10,4) NOT NULL,
  `sickLeaveTotalEarned` decimal(10,4) NOT NULL,
  `vacationLeaveLess` decimal(10,4) NOT NULL,
  `sickLeaveLess` decimal(10,4) NOT NULL,
  `vacationLeaveBalance` decimal(10,4) NOT NULL,
  `sickLeaveBalance` decimal(10,4) NOT NULL,
  `recommendation` varchar(255) NOT NULL,
  `recommendMessage` varchar(255) NOT NULL,
  `dayWithPay` int(255) NOT NULL,
  `dayWithoutPay` int(255) NOT NULL,
  `otherDayPay` int(255) NOT NULL,
  `otherDaySpecify` varchar(255) NOT NULL,
  `disapprovedMessage` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_leaveappform`
--

INSERT INTO `tbl_leaveappform` (`leaveappform_id`, `dateLastModified`, `dateCreated`, `employee_id`, `departmentName`, `lastName`, `firstName`, `middleName`, `dateFiling`, `position`, `salary`, `typeOfLeave`, `typeOfSpecifiedOtherLeave`, `typeOfVacationLeave`, `typeOfVacationLeaveWithin`, `typeOfVacationLeaveAbroad`, `typeOfSickLeave`, `typeOfSickLeaveInHospital`, `typeOfSickLeaveOutPatient`, `typeOfSpecialLeaveForWomen`, `typeOfStudyLeave`, `typeOfOtherLeave`, `workingDays`, `inclusiveDates`, `commutation`, `asOfDate`, `vacationLeaveTotalEarned`, `sickLeaveTotalEarned`, `vacationLeaveLess`, `sickLeaveLess`, `vacationLeaveBalance`, `sickLeaveBalance`, `recommendation`, `recommendMessage`, `dayWithPay`, `dayWithoutPay`, `otherDayPay`, `otherDaySpecify`, `disapprovedMessage`, `status`) VALUES
(1, '2023-12-02 03:31:34', '2023-11-29 09:40:44', 'TEMP001', 'Pending', 'Bay', 'Jeshua Mark', 'Sarmiento', 'July, 2022', 'Hello', '350', 'Sick Leave', 'Hello', 'Within the Philippines', 'jnhjj', 'nmkjnjk', 'Out Patient', 'nbjbj', 'jnjkn', 'jnjnnjnkn', 'Completion of Master Degree', 'Terminal Leave', 2, 'jnknjnjnj', 'Requested', '2023-11-18', 78.0000, 78.0000, 78.0000, 878.0000, 878.0000, 878.0000, 'For Approval', '898u8u', 56, 56, 56, 'ughbvbn', 'jhbjhjbjhjbmhbb', 'Submitted'),
(7, '2023-12-04 12:42:36', '2023-12-04 12:42:36', 'TEMP001', 'Pending', '', '', '', '', '', '', 'Forced Leave', '', '', '', '', '', '', '', '', '', '', 0, '', '', '2023-11-18', 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0, 0, 0, '', '', 'Submitted'),
(8, '2023-12-04 14:17:43', '2023-12-04 14:17:43', 'TEMP001', 'Pending', '', '', '', '', '', '', 'Vacation Leave', '', 'Within the Philippines', '', '', '', '', '', '', '', '', 0, '', '', '2023-11-18', 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0, 0, 0, '', '', 'Submitted'),
(9, '2023-12-04 14:23:13', '2023-12-04 14:23:13', 'TEMP001', 'Pending', '', '', '', '', '', '', 'Paternity Leave', '', '', '', '', '', '', '', '', '', '', 0, '', '', '2023-11-18', 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0, 0, 0, '', '', 'Submitted');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leavedataform`
--

CREATE TABLE `tbl_leavedataform` (
  `leavedataform_id` int(255) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `dateLastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_leavedataform`
--

INSERT INTO `tbl_leavedataform` (`leavedataform_id`, `employee_id`, `dateCreated`, `period`, `periodEnd`, `particular`, `particularLabel`, `days`, `hours`, `minutes`, `vacationLeaveEarned`, `vacationLeaveAbsUndWP`, `vacationLeaveBalance`, `vacationLeaveAbsUndWOP`, `sickLeaveEarned`, `sickLeaveAbsUndWP`, `sickLeaveBalance`, `sickLeaveAbsUndWOP`, `dateOfAction`, `dateLastModified`) VALUES
(136, 'PRO001', '2023-11-26 02:00:02', '2023-11-26', '2023-11-26', 'Sick Leave', '', 1, 0, 0, 1.2500, 0.0000, 1.2500, 0.0000, 0.0000, 0.0000, 0.0000, 1.7500, '2023-11-26', '2023-11-26 02:03:29'),
(139, '201915197', '2023-11-30 06:30:43', '2023-11-30', '2023-11-30', 'Sick Leave', '', 1, 0, 0, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 1.0000, 0.2500, 0.0000, '2023-11-30', '2023-11-30 06:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `notification_id` int(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `empIdFrom` varchar(255) NOT NULL,
  `empIdTo` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `seen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`notification_id`, `dateCreated`, `empIdFrom`, `empIdTo`, `subject`, `message`, `link`, `seen`) VALUES
(1, '2023-12-05 04:31:43', 'TEMP001', '@Admin', 'Employee Submission of Leave Form', 'Dummy Account is Applying For Forced Leave', '/www.indang-municipal-hr.com.ph/admin/leave-app-form', 'seen'),
(2, '2023-12-05 04:31:43', 'TEMP001', '@Admin', 'Employee Submission of Leave Form', 'Dummy Account is Applying For Vacation Leave', '/www.indang-municipal-hr.com.ph/admin/leave-app-form', 'seen'),
(3, '2023-12-05 04:31:43', 'TEMP001', '@Admin', 'Employee Submission of Leave Form', 'Dummy Account is Applying For Paternity Leave', '/www.indang-municipal-hr.com.ph/admin/leave-app-form', 'seen');

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
  `age` int(4) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `civilStatus` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `jobPosition` varchar(255) NOT NULL,
  `dateStarted` date NOT NULL DEFAULT current_timestamp(),
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_useraccounts`
--

INSERT INTO `tbl_useraccounts` (`account_id`, `employee_id`, `role`, `email`, `password`, `photoURL`, `firstName`, `middleName`, `lastName`, `age`, `sex`, `civilStatus`, `department`, `jobPosition`, `dateStarted`, `dateCreated`) VALUES
(1, 'PRO001', 'Admin', 'jeshuabay@gmail.com', 'Password', '', 'Jeshua Mark', 'Sarmiento', 'Bay', 2, 'Male', 'Single', '2', 'Tiktokerist ', '2022-01-01', '2023-11-14 15:40:55'),
(77, 'TEMP001', 'Employee', 'dummy@gmail.com', 'Password', '', 'Dummy', '', 'Account', 20, 'Female', 'Widowed', 'Pending', 'Content Creator ', '2023-11-18', '2023-11-18 10:40:13'),
(78, '201915197', 'Employee', 'reneantonio.dimabogte@cvsu.edu.ph', 'capacio2020', '', 'Rene Antonio', 'Capacio', 'Dimabogte Jr.', 24, 'Male', 'Single', '4', 'Grim Reaper', '2023-11-24', '2023-11-24 01:56:11');

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
  MODIFY `department_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_leaveappform`
--
ALTER TABLE `tbl_leaveappform`
  MODIFY `leaveappform_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_leavedataform`
--
ALTER TABLE `tbl_leavedataform`
  MODIFY `leavedataform_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `notification_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_useraccounts`
--
ALTER TABLE `tbl_useraccounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
