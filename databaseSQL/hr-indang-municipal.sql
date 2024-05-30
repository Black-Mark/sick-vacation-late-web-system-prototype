-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 03:25 AM
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
  `departmentDescription` varchar(500) NOT NULL,
  `departmentHead` varchar(255) NOT NULL,
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`department_id`, `departmentName`, `departmentDescription`, `departmentHead`, `archive`) VALUES
(1, 'Department of Human Resources Office', 'The Department of Human Resources Office serves as the administrative hub for managing personnel-related matters within an organization. It oversees recruitment, hiring, training, benefits administration, employee relations, and compliance with labor laws and regulations. Additionally, it plays a crucial role in promoting a positive work environment, fostering professional development, and ensuring fair and equitable treatment of all employees.', 'PRO001', ''),
(2, 'Municipal Office', ' A municipal office is the administrative hub of local government, responsible for managing public services, issuing permits, overseeing infrastructure projects, and fostering community engagement within a specific municipality.', 'PRO001', ''),
(3, 'Agricultural Office', '', '', '');

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_laterecordfile`
--

CREATE TABLE `tbl_laterecordfile` (
  `laterecordfile_id` int(255) NOT NULL,
  `monthYearOfRecord` varchar(255) NOT NULL,
  `fileOfRecord` varchar(255) NOT NULL,
  `lastDateModified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_laterecordfile`
--

INSERT INTO `tbl_laterecordfile` (`laterecordfile_id`, `monthYearOfRecord`, `fileOfRecord`, `lastDateModified`) VALUES
(1, 'January 2024', '/uploads/laterecords/january 2024.csv', '2024-05-30 01:23:39');

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

--
-- Dumping data for table `tbl_leaveappform`
--

INSERT INTO `tbl_leaveappform` (`leaveappform_id`, `dateLastModified`, `dateCreated`, `employee_id`, `departmentName`, `lastName`, `firstName`, `middleName`, `dateFiling`, `position`, `salary`, `typeOfLeave`, `typeOfSpecifiedOtherLeave`, `typeOfVacationLeave`, `typeOfVacationLeaveWithin`, `typeOfVacationLeaveAbroad`, `typeOfSickLeave`, `typeOfSickLeaveInHospital`, `typeOfSickLeaveOutPatient`, `typeOfSpecialLeaveForWomen`, `typeOfStudyLeave`, `typeOfOtherLeave`, `workingDays`, `inclusiveDateStart`, `inclusiveDateEnd`, `commutation`, `asOfDate`, `vacationLeaveTotalEarned`, `sickLeaveTotalEarned`, `vacationLeaveLess`, `sickLeaveLess`, `vacationLeaveBalance`, `sickLeaveBalance`, `recommendation`, `recommendMessage`, `dayWithPay`, `dayWithoutPay`, `otherDayPay`, `otherDaySpecify`, `disapprovedMessage`, `hrName`, `hrPosition`, `deptHeadName`, `mayorName`, `mayorPosition`, `hrmanager_id`, `depthead_id`, `mayor_id`, `status`, `archive`) VALUES
('2b58763db9fe50220e1574a7db75e0aa92dc2555eca728dd25', '2024-05-29 00:08:28', '2024-05-29 00:03:47', 'Regular', 'Municipal Office', 'Account', 'Regular', '', '2024-05-29', 'Clerk', '', 'Vacation Leave', '', 'Within the Philippines', '', '', '', '', '', '', '', '', 1, '2024-05-29', '2024-05-29', 'Requested', '2024-03-28', 6.0000, 5.0000, 0.0000, 0.0000, 6.0000, 5.0000, 'For Disapproved Due to', '', 0, 0, 0, '', '', 'Admin Account', 'Authorized Officer', 'Admin Account', 'Admin Account', 'Authorized Official', '0', '0', '0', 'Disapproved', 'deleted'),
('47b557e18a25d2aaa11cee220f5269d87932f63074515c92f1', '2024-05-28 14:07:41', '2024-05-28 14:07:41', 'Regular', 'Municipal Office', 'Account', 'Regular', '', '2024-05-28', 'Clerk', '', 'Sick Leave', '', '', '', '', 'In Hospital', '', ' ', ' ', '', '0', 2, '2024-05-29', '2024-05-30', 'Not Requested', '2024-03-28', 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('633f41b58b203445552c2c158314652d3c3a1bbc46adf3efa7', '2024-05-29 00:17:53', '2024-05-29 00:17:53', 'Regular', 'Municipal Office', 'Account', 'Regular', '', '2024-05-29', 'Clerk', '', 'Sick Leave', '', '', '', '', '', '', ' ', ' ', '', '0', 1, '2024-05-29', '2024-05-29', 'Not Requested', '2024-03-28', 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('811017957eefb5f9ea5535cc1515981ddf033c1ef3aa90bc1e', '2024-05-29 00:43:08', '2024-05-29 00:43:08', 'Staff', 'Department of Human Resources Office', 'Account', 'Staff', '', '2024-05-29', 'HR Staff', '', 'Vacation Leave', '', 'Within the Philippines', '', '', '', '', ' ', ' ', '', '0', 1, '2024-05-29', '2024-05-29', 'Requested', '2023-03-17', 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('8fb122995efece80c8400dcaf02fdec8a87a2b9645fbe32a1e', '2024-05-29 00:13:56', '2024-05-29 00:13:56', 'Regular', 'Municipal Office', 'Account', 'Regular', '', '2024-05-29', 'Clerk', '', 'Maternity Leave', '', '', '', '', '', '', ' ', ' ', '', '0', 1, '2024-05-29', '2024-05-29', 'Requested', '2024-03-28', 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('e3abd9b9dfc34281743104d7194f69405e2bc7917392d16130', '2024-05-28 06:52:28', '2024-05-28 06:50:47', 'Regular', 'Municipal Office', 'Account', 'Regular', '', '2024-05-28', 'Clerk', '', 'Vacation Leave', '', 'Within the Philippines', '', '', '', '', '', '', '', '', 1, '2024-05-28', '2024-05-28', 'Requested', '2024-03-28', 7.0000, 5.0000, 1.0000, 0.0000, 6.0000, 5.0000, 'For Approval', '', 1, 0, 0, '', '', 'Admin Account', 'Authorized Officer', 'Admin Account', 'Admin Account', 'Authorized Official', '0', '0', '0', 'Approved', '');

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
(1, 'e67abedc', '', '2024-05-28 02:00:31', 'Initial Record', '2024-05-28', '2024-05-28', 'Initial Record', '0', 0, 0, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-05-28', '2024-05-28 15:08:36', '', ''),
(2, 'STAFF', '', '2024-05-28 02:39:38', 'Initial Record', '2023-03-17', '2024-05-28', 'Initial Record', '', 0, 0, 0, 9.0000, 0.0000, 9.0000, 0.0000, 13.5000, 0.0000, 13.5000, 0.0000, '2024-05-28', '2024-05-28 02:39:38', '', ''),
(3, 'PRO001', '', '2024-05-28 03:30:45', 'Initial Record', '2023-12-13', '2024-05-28', 'Initial Record', '0', 0, 0, 0, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, '2024-05-28', '2024-05-29 01:49:10', '', ''),
(4, 'Regular', '', '2024-05-28 06:40:42', 'Initial Record', '2024-03-28', '2024-05-28', 'Initial Record', '', 0, 0, 0, 7.0000, 0.0000, 7.0000, 0.0000, 5.0000, 0.0000, 5.0000, 0.0000, '2024-05-28', '2024-05-28 06:40:42', '', ''),
(5, 'Regular', 'e3abd9b9dfc34281743104d7194f69405e2bc7917392d16130', '2024-05-28 06:52:28', 'Deduction Type', '2024-05-28', '2024-05-28', 'Vacation Leave', '', 1, 0, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-05-28', '2024-05-28 06:52:28', '', ''),
(6, 'PRO001', '', '2024-05-28 09:33:14', 'Deduction Type', '2024-05-28', '2024-06-30', 'Late', '', 34, 24, 30, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-06-30', '2024-05-29 08:05:49', '', ''),
(7, 'PRO001', '', '2024-05-28 09:42:58', 'Deduction Type', '2024-05-28', '2024-05-28', 'Late', '', 0, 1, 45, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-05-28', '2024-05-29 08:05:51', '', ''),
(8, 'PRO001', '', '2024-05-29 01:34:32', 'Deduction Type', '2024-06-02', '2024-06-04', 'Sick Leave', '', 3, 0, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-05-28', '2024-05-29 01:34:32', '', ''),
(12, '20240529094', '', '2024-05-29 09:03:54', 'Initial Record', '2024-05-29', '2024-05-29', 'Initial Record', '0', 0, 0, 0, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, '2024-05-29', '2024-05-29 09:29:09', '', ''),
(13, '20240529094', '', '2024-05-29 09:27:39', 'Inactive', '2024-05-29', '2024-05-29', 'Break Monthly Record', '', 0, 0, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-05-29', '2024-05-29 10:09:46', '', ''),
(14, 'e67abedc', '', '2024-05-29 10:24:08', 'Break Monthly Record', '2024-05-29', '2024-05-29', 'Break Monthly Record', '', 0, 0, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-05-29', '2024-05-29 10:28:10', '', ''),
(15, 'Regular', '', '2024-05-29 10:25:48', 'Break Monthly Record', '2024-05-29', '2024-05-29', 'Break Monthly Record', 'Break Monthly Record', 0, 0, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-05-29', '2024-05-29 10:25:48', '', ''),
(16, 'STAFF', '', '2024-05-29 10:28:58', 'Break Monthly Record', '2024-05-29', '2024-05-29', 'Break Monthly Record', '', 0, 0, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-05-29', '2024-05-29 10:28:58', '', ''),
(17, '20240529122858', '', '2024-05-29 10:29:50', 'Initial Record', '2024-05-29', '2024-05-29', 'Initial Record', '', 0, 0, 0, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, 1.2500, 0.0000, '2024-05-29', '2024-05-29 10:29:50', '', ''),
(18, '20240529122858', '', '2024-05-29 10:29:50', 'Break Monthly Record', '2024-05-29', '2024-05-29', 'Break Monthly Record', '', 0, 0, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2024-05-29', '2024-05-29 10:29:50', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leaves`
--

CREATE TABLE `tbl_leaves` (
  `leave_id` int(255) NOT NULL,
  `leaveName` varchar(255) NOT NULL,
  `leaveDescription` varchar(255) NOT NULL,
  `leaveClass` varchar(255) NOT NULL,
  `leaveTotalAmount` decimal(10,4) NOT NULL,
  `leaveReset` varchar(25) NOT NULL,
  `dateLastModified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`notification_id`, `dateCreated`, `empIdFrom`, `empIdTo`, `subject`, `message`, `subjectKey`, `link`, `status`, `archive`) VALUES
(1, '2024-05-28 06:50:47', 'Regular', '@Admin', 'Employee Leave Form Request', 'Account Regular is Applying For Vacation Leave', 'e3abd9b9dfc34281743104d7194f69405e2bc7917392d16130', '', 'read', ''),
(2, '2024-05-28 06:52:28', '@Admin', 'Regular', 'Validation of Leave Form', 'Your Leave Application Form has been Approved', 'e3abd9b9dfc34281743104d7194f69405e2bc7917392d16130', '', 'read', ''),
(3, '2024-05-28 14:07:41', 'Regular', '@Admin', 'Employee Leave Form Request', 'Account Regular is Applying For Sick Leave', '47b557e18a25d2aaa11cee220f5269d87932f63074515c92f1', '', 'read', ''),
(4, '2024-05-29 00:03:47', 'Regular', '@Admin', 'Employee Leave Form Request', 'Account Regular is Applying For Maternity Leave', '2b58763db9fe50220e1574a7db75e0aa92dc2555eca728dd25', '', 'read', ''),
(5, '2024-05-29 00:08:20', '@Admin', 'Regular', 'Validation of Leave Form', 'Your Leave Application Form has been Disapproved', '2b58763db9fe50220e1574a7db75e0aa92dc2555eca728dd25', '', 'unread', ''),
(6, '2024-05-29 00:13:56', 'Regular', '@Admin', 'Employee Leave Form Request', 'Account Regular is Applying For Maternity Leave', '8fb122995efece80c8400dcaf02fdec8a87a2b9645fbe32a1e', '', 'unseen', ''),
(7, '2024-05-29 00:17:53', 'Regular', '@Admin', 'Employee Leave Form Request', 'Account Regular is Applying For Sick Leave', '633f41b58b203445552c2c158314652d3c3a1bbc46adf3efa7', '', 'unseen', ''),
(8, '2024-05-29 00:43:08', 'Staff', '@Admin', 'Staff Leave Form Request', 'Account Staff is Applying For Vacation Leave', '811017957eefb5f9ea5535cc1515981ddf033c1ef3aa90bc1e', '', 'read', '');

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
  `employee_id` varchar(255) NOT NULL,
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
  `reasonForStatus` varchar(255) NOT NULL,
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_useraccounts`
--

INSERT INTO `tbl_useraccounts` (`account_id`, `employee_id`, `role`, `email`, `password`, `photoURL`, `firstName`, `middleName`, `lastName`, `suffix`, `birthdate`, `sex`, `civilStatus`, `department`, `jobPosition`, `status`, `dateStarted`, `dateCreated`, `reasonForStatus`, `archive`) VALUES
(1, 'PRO001', 'Admin', 'admin@gmail.com', 'Password', '', 'Admin', '', 'Account', '', '2000-01-01', 'Male', 'Single', '1', '1', 'Active', '2023-12-13', '2023-12-13 12:47:22', '', ''),
(2, 'e67abedc', 'Employee', 'deletedaccount@gmail.com', 'Password', '', 'Deleted', '', 'Account', '', '2001-07-02', 'Male', 'Single', '2', '2', 'Active', '2024-05-28', '2024-05-28 02:00:31', '', ''),
(3, 'STAFF', 'Staff', 'staff@gmail.com', 'Password', '', 'Staff', '', 'Account', '', '2000-01-01', 'Male', 'Single', '1', '1', 'Active', '2023-03-17', '2024-05-28 02:39:37', '', ''),
(4, 'Regular', 'Employee', 'regular@gmail.com', 'Password', '', 'Regular', '', 'Account', '', '2001-06-01', 'Male', 'Single', '2', '2', 'Active', '2024-03-28', '2024-05-28 06:40:42', '', ''),
(5, '20240529094', 'Employee', 'special@gmail.com', 'Password', '', 'Special', '', 'Account', '', '2004-05-13', 'Female', 'Married', '2', '2', 'Active', '2024-05-29', '2024-05-29 07:49:55', '', ''),
(6, '20240529122858', 'Employee', 'banned@gmail.com', 'Password', '', 'Banned', '', 'Account', '', '2001-01-01', 'Female', 'Married', '2', '2', 'Active', '2024-05-29', '2024-05-29 10:29:50', '', '');

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
-- Indexes for table `tbl_designations`
--
ALTER TABLE `tbl_designations`
  ADD PRIMARY KEY (`designation_id`),
  ADD UNIQUE KEY `designationName` (`designationName`);

--
-- Indexes for table `tbl_laterecordfile`
--
ALTER TABLE `tbl_laterecordfile`
  ADD PRIMARY KEY (`laterecordfile_id`),
  ADD UNIQUE KEY `monthYearOfRecord` (`monthYearOfRecord`);

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
-- Indexes for table `tbl_leaves`
--
ALTER TABLE `tbl_leaves`
  ADD PRIMARY KEY (`leave_id`);

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
  MODIFY `department_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_designations`
--
ALTER TABLE `tbl_designations`
  MODIFY `designation_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_laterecordfile`
--
ALTER TABLE `tbl_laterecordfile`
  MODIFY `laterecordfile_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_leavedataform`
--
ALTER TABLE `tbl_leavedataform`
  MODIFY `leavedataform_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_leaves`
--
ALTER TABLE `tbl_leaves`
  MODIFY `leave_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `notification_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_passwordreset_tokens`
--
ALTER TABLE `tbl_passwordreset_tokens`
  MODIFY `token_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_systemsettings`
--
ALTER TABLE `tbl_systemsettings`
  MODIFY `setting_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_useraccounts`
--
ALTER TABLE `tbl_useraccounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
