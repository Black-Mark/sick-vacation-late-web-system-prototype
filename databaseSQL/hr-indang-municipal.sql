-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2024 at 06:15 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`department_id`, `departmentName`, `departmentDescription`, `departmentHead`, `archive`) VALUES
(1, 'Department of Human Resources Office', 'The Department of Human Resources Office serves as the administrative hub for managing personnel-related matters within an organization. It oversees recruitment, hiring, training, benefits administration, employee relations, and compliance with labor laws and regulations. Additionally, it plays a crucial role in promoting a positive work environment, fostering professional development, and ensuring fair and equitable treatment of all employees.', 'PRO001', ''),
(2, 'Municipal Office', ' A municipal office is the administrative hub of local government, responsible for managing public services, issuing permits, overseeing infrastructure projects, and fostering community engagement within a specific municipality.', 'PRO001', ''),
(3, 'Agricultural Office', '', '', ''),
(4, 'Assesors Office', '', '', ''),
(5, 'Municipal Budget Office', '', '', ''),
(6, 'Office of Sanguniang Bayan', '', '', ''),
(7, 'Civil Registrar Office', '', '', ''),
(8, 'Municipal Engineer Office', '', '', ''),
(9, 'Municipal Environment and Natural Resources Office', '', '', ''),
(10, 'Rural Health Unit', '', '', ''),
(11, 'Market Services', '', '', ''),
(12, 'Local Economic Development and Investment Promotions', '', '', ''),
(13, 'Public Employment and Services Office', '', '', ''),
(14, 'Municipal Planning and Development Office', '', '', ''),
(15, 'Social Welfare and Development Office', '', '', ''),
(16, 'Treasury Services', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designations`
--

CREATE TABLE `tbl_designations` (
  `designation_id` int(255) NOT NULL,
  `designationName` varchar(150) NOT NULL,
  `designationDescription` varchar(255) NOT NULL,
  `dateLastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dateCreated` date NOT NULL,
  `archive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_designations`
--

INSERT INTO `tbl_designations` (`designation_id`, `designationName`, `designationDescription`, `dateLastModified`, `dateCreated`, `archive`) VALUES
(1, 'HR Staff', 'HR staff oversee all aspects of personnel management, from recruitment to employee relations, ensuring a positive work environment.', '2024-05-27 11:35:05', '2024-05-27', ''),
(2, 'Clerk', 'A clerk manages administrative tasks like record-keeping and office organization, providing essential support for smooth operations.', '2024-05-28 02:36:38', '2024-05-28', ''),
(102, 'City Manager', '', '2024-06-02 15:09:39', '0000-00-00', ''),
(103, 'Finance Director', '', '2024-06-02 15:10:07', '0000-00-00', ''),
(104, 'Treasurer', '', '2024-06-02 15:11:05', '0000-00-00', ''),
(105, 'Planning Director', '', '2024-06-02 15:11:26', '0000-00-00', ''),
(106, 'Police Chief', '', '2024-06-02 15:11:36', '0000-00-00', ''),
(107, 'Public Health Director', '', '2024-06-02 15:11:49', '0000-00-00', ''),
(108, 'Community Services Coordinator', '', '2024-06-02 15:12:06', '0000-00-00', ''),
(109, 'HR Director', '', '2024-06-02 15:13:31', '0000-00-00', 'deleted'),
(110, 'Benefits Coordinator', '', '2024-06-02 15:13:46', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_educational_background`
--

CREATE TABLE `tbl_educational_background` (
  `education_id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `graduateStudies` varchar(100) NOT NULL,
  `elemschoolName` varchar(100) NOT NULL,
  `elembasicEducation` varchar(100) NOT NULL,
  `elemhighestLevel` varchar(100) NOT NULL,
  `elemYGraduated` int(11) NOT NULL,
  `elemScholarship` varchar(100) NOT NULL,
  `elemPeriod` varchar(255) NOT NULL,
  `elemperiodEnd` varchar(255) NOT NULL,
  `secondschoolName` varchar(100) NOT NULL,
  `secondbasicEducation` varchar(100) NOT NULL,
  `secondhighestLevel` varchar(100) NOT NULL,
  `secondYGraduated` int(11) NOT NULL,
  `secondScholarship` varchar(100) NOT NULL,
  `secondPeriod` varchar(255) NOT NULL,
  `secondperiodEnd` varchar(255) NOT NULL,
  `vocationalschoolName` varchar(100) NOT NULL,
  `vocationalbasicEducation` varchar(100) NOT NULL,
  `vocationalhighestLevel` varchar(100) NOT NULL,
  `vocationalYGraduated` int(11) NOT NULL,
  `vocationalScholarship` varchar(100) NOT NULL,
  `vocationalPeriod` varchar(255) NOT NULL,
  `vocationalperiodEnd` varchar(255) NOT NULL,
  `collegeschoolName` varchar(100) NOT NULL,
  `collegebasicEducation` varchar(100) NOT NULL,
  `collegehighestLevel` varchar(100) NOT NULL,
  `collegeYGraduated` int(11) NOT NULL,
  `collegeScholarship` varchar(100) NOT NULL,
  `collegePeriod` varchar(255) NOT NULL,
  `collegeperiodEnd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_family_background`
--

CREATE TABLE `tbl_family_background` (
  `family_id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `spousesurname` varchar(100) NOT NULL,
  `spousename` varchar(100) NOT NULL,
  `spousemiddlename` varchar(100) NOT NULL,
  `spousenameExtension` varchar(100) NOT NULL,
  `spouseOccupation` varchar(100) NOT NULL,
  `spouseEmployer` varchar(100) NOT NULL,
  `spouseBusinessAddress` varchar(100) NOT NULL,
  `spouseTelephone` int(50) NOT NULL,
  `nameOfChildren` varchar(255) NOT NULL,
  `fathersSurname` varchar(100) NOT NULL,
  `fathersFirstname` varchar(100) NOT NULL,
  `fathersMiddlename` varchar(100) NOT NULL,
  `fathersnameExtension` varchar(100) NOT NULL,
  `MSurname` varchar(100) NOT NULL,
  `MName` varchar(100) NOT NULL,
  `MMName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_laterecordfile`
--

CREATE TABLE `tbl_laterecordfile` (
  `laterecordfile_id` int(255) NOT NULL,
  `monthYearOfRecord` varchar(255) NOT NULL,
  `fileOfRecord` varchar(255) NOT NULL,
  `lastDateModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `inclusiveDateOne` date NOT NULL,
  `inclusiveDateTwo` date NOT NULL,
  `inclusiveDateThree` date NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_leaveappform`
--

INSERT INTO `tbl_leaveappform` (`leaveappform_id`, `dateLastModified`, `dateCreated`, `employee_id`, `departmentName`, `lastName`, `firstName`, `middleName`, `dateFiling`, `position`, `salary`, `typeOfLeave`, `typeOfSpecifiedOtherLeave`, `typeOfVacationLeave`, `typeOfVacationLeaveWithin`, `typeOfVacationLeaveAbroad`, `typeOfSickLeave`, `typeOfSickLeaveInHospital`, `typeOfSickLeaveOutPatient`, `typeOfSpecialLeaveForWomen`, `typeOfStudyLeave`, `typeOfOtherLeave`, `workingDays`, `inclusiveDateStart`, `inclusiveDateEnd`, `inclusiveDateOne`, `inclusiveDateTwo`, `inclusiveDateThree`, `commutation`, `asOfDate`, `vacationLeaveTotalEarned`, `sickLeaveTotalEarned`, `vacationLeaveLess`, `sickLeaveLess`, `vacationLeaveBalance`, `sickLeaveBalance`, `recommendation`, `recommendMessage`, `dayWithPay`, `dayWithoutPay`, `otherDayPay`, `otherDaySpecify`, `disapprovedMessage`, `hrName`, `hrPosition`, `deptHeadName`, `mayorName`, `mayorPosition`, `hrmanager_id`, `depthead_id`, `mayor_id`, `status`, `archive`) VALUES
('27e6bf21c9d08289f314300b408b3ffda6b2a85d8ca87c9859', '2024-06-02 15:57:26', '2024-06-02 15:57:26', 'Julieann', 'Assesors Office', 'Ariza', 'Julieann', '', '2024-06-02', 'Clerk', '', 'Vacation Leave', '', 'Abroad', '', 'Korea', '', '', ' ', ' ', '', '0', 4, '2024-07-02', '2024-07-05', '2024-06-02', '2024-06-02', '2024-06-02', 'Requested', '2023-03-07', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('52322eea43b35fb8106ef3d2bbaf8fabddff164100a8663c10', '2024-06-02 15:54:54', '2024-06-02 15:54:54', 'Lyca', 'Assesors Office', 'Avilla', 'Lyca Joy', '', '2024-06-02', 'Clerk', '', 'Study Leave', '', '', '', '', '', '', ' ', ' ', 'Completion of Master Degree', '0', 5, '2024-06-11', '2024-06-15', '2024-06-02', '2024-06-02', '2024-06-02', 'Requested', '2024-02-15', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('a4042b407f020dddd63d43c44592097326a6e462abb0906566', '2024-06-02 15:55:47', '2024-06-02 15:55:47', 'Rhina', 'Municipal Office', 'Gerpacio', 'Rhina', '', '2024-06-02', 'Clerk', '', 'Special Leave Benefits for Women', '', '', '', '', '', '', ' ', ' ', '', '0', 4, '2024-07-07', '2024-07-10', '2024-06-02', '2024-06-02', '2024-06-02', 'Requested', '2024-02-02', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('a5d15af85d55314ebb65aee0157cbed3f87d2584fed4366f06', '2024-06-02 15:48:21', '2024-06-02 15:48:21', 'Payad', 'Department of Human Resources Office', 'Payad', 'Nina', 'Lontoc', '2024-06-02', 'Clerk', '', 'Vacation Leave', '', 'Within the Philippines', 'Bataan', '', '', '', ' ', ' ', '', '0', 2, '2024-06-07', '2024-06-08', '2024-06-02', '2024-06-02', '2024-06-02', 'Requested', '2024-01-02', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('b46905de46f0b69d18be87744d7c41dc517e18e2a86b8a5cc4', '2024-06-02 15:50:04', '2024-06-02 15:50:04', 'Bay', 'Agricultural Office', 'Bay', 'Jeshua Mark', 'Sarmiento', '2024-06-02', 'Clerk', '', 'Forced Leave', '', '', '', '', '', '', ' ', ' ', '', '0', 2, '2024-06-07', '2024-06-08', '2024-06-02', '2024-06-02', '2024-06-02', 'Not Requested', '2023-12-02', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('e313256d1d56f8ad0f0fe1ff379185ae673a87493baa2bf087', '2024-06-02 15:53:08', '2024-06-02 15:53:08', 'Jimmy', 'Treasury Services', 'Banting', 'Jimmy', '', '2024-06-02', 'Treasurer', '', 'Paternity Leave', '', '', '', '', '', '', ' ', ' ', '', '0', 7, '2024-06-07', '2024-06-14', '2024-06-02', '2024-06-02', '2024-06-02', 'Requested', '2023-05-10', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', ''),
('ee213dbfc09e956b3f725038571796254815c844dd35f1ae48', '2024-06-02 15:49:11', '2024-06-02 15:49:11', 'Capacio', 'Agricultural Office', 'Capacio', 'Ren', '', '2024-06-02', 'Clerk', '', 'Sick Leave', '', '', '', '', 'In Hospital', 'Dengue', ' ', ' ', '', '0', 3, '2024-05-18', '2024-05-20', '2024-06-02', '2024-06-02', '2024-06-02', 'Not Requested', '2024-02-02', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 'Submitted', '');

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
  `periodOne` date NOT NULL,
  `periodTwo` date NOT NULL,
  `periodThree` date NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_leavedataform`
--

INSERT INTO `tbl_leavedataform` (`leavedataform_id`, `employee_id`, `foreignKeyId`, `dateCreated`, `recordType`, `period`, `periodEnd`, `periodOne`, `periodTwo`, `periodThree`, `particular`, `particularLabel`, `days`, `hours`, `minutes`, `vacationLeaveEarned`, `vacationLeaveAbsUndWP`, `vacationLeaveBalance`, `vacationLeaveAbsUndWOP`, `sickLeaveEarned`, `sickLeaveAbsUndWP`, `sickLeaveBalance`, `sickLeaveAbsUndWOP`, `dateOfAction`, `dateLastModified`, `leaveform_connectionId`, `archive`) VALUES
(41, 'PRO001', '', '2024-06-02 07:26:43', 'Initial Record', '2020-01-01', '2024-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '1.2500', '0.0000', '1.2500', '0.0000', '1.2500', '0.0000', '1.2500', '0.0000', '2024-06-01', '2024-06-02 07:26:43', '', ''),
(42, 'FEMALE', '', '2024-06-02 08:44:28', 'Initial Record', '2024-06-01', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '1.2500', '0.0000', '1.2500', '0.0000', '1.2500', '0.0000', '1.2500', '0.0000', '2024-06-02', '2024-06-02 08:44:28', '', ''),
(43, 'MALE', '', '2024-06-02 08:47:12', 'Initial Record', '2024-06-01', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '1.2500', '0.0000', '1.2500', '0.0000', '1.2500', '0.0000', '1.2500', '0.0000', '2024-06-02', '2024-06-02 08:47:12', '', ''),
(44, 'STAFF', '', '2024-06-02 08:49:19', 'Initial Record', '2024-06-01', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '1.2500', '0.0000', '1.2500', '0.0000', '1.2500', '0.0000', '1.2500', '0.0000', '2024-06-02', '2024-06-02 08:49:19', '', ''),
(45, 'Payad', '', '2024-06-02 14:46:23', 'Initial Record', '2024-01-02', '2024-04-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '3.5000', '0.0000', '3.5000', '0.0000', '2.2500', '0.0000', '2.2500', '0.0000', '2024-06-02', '2024-06-02 14:47:04', '', ''),
(46, 'Capacio', '', '2024-06-02 14:50:33', 'Initial Record', '2024-02-02', '2024-03-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '4.2500', '0.0000', '4.2500', '0.0000', '5.2000', '0.0000', '5.2000', '0.0000', '2024-06-02', '2024-06-02 16:00:50', '', ''),
(47, 'Bay', '', '2024-06-02 14:53:01', 'Initial Record', '2023-12-02', '2024-02-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '7.1000', '0.0000', '7.1000', '0.0000', '8.1000', '0.0000', '8.1000', '0.0000', '2024-06-02', '2024-06-02 16:00:16', '', ''),
(48, 'Rhina', '', '2024-06-02 14:54:10', 'Initial Record', '2024-02-02', '2024-04-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '3.5000', '0.0000', '3.5000', '0.0000', '2.1000', '0.0000', '2.1000', '0.0000', '2024-06-02', '2024-06-02 16:09:28', '', ''),
(49, 'Lyca', '', '2024-06-02 14:56:23', 'Initial Record', '2024-02-15', '2024-03-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '3.5000', '0.0000', '3.5000', '0.0000', '1.2500', '0.0000', '1.2500', '0.0000', '2024-06-02', '2024-06-02 16:08:37', '', ''),
(50, 'Julieann', '', '2024-06-02 15:05:34', 'Initial Record', '2023-03-07', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '10.1500', '0.0000', '10.1500', '0.0000', '9.2500', '0.0000', '9.2500', '0.0000', '2024-06-02', '2024-06-02 15:05:34', '', ''),
(51, 'Joseph', '', '2024-06-02 15:07:22', 'Initial Record', '2023-12-11', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '9.3000', '0.0000', '9.3000', '0.0000', '2.5000', '0.0000', '2.5000', '0.0000', '2024-06-02', '2024-06-02 15:07:22', '', ''),
(52, 'Jimmy', '', '2024-06-02 15:15:39', 'Initial Record', '2023-05-10', '2024-04-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '10.1200', '0.0000', '10.1200', '0.0000', '2.5000', '0.0000', '2.5000', '0.0000', '2024-06-02', '2024-06-02 15:51:28', '', ''),
(53, 'James', '', '2024-06-02 15:16:51', 'Initial Record', '2024-01-20', '2024-03-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '4.2000', '0.0000', '4.2000', '0.0000', '4.1100', '0.0000', '4.1100', '0.0000', '2024-06-02', '2024-06-02 15:59:41', '', ''),
(54, 'John', '', '2024-06-02 15:17:54', 'Initial Record', '2023-03-02', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '11.5000', '0.0000', '11.5000', '0.0000', '12.1000', '0.0000', '12.1000', '0.0000', '2024-06-02', '2024-06-02 15:17:54', '', ''),
(55, 'Susan', '', '2024-06-02 15:18:55', 'Initial Record', '2023-11-20', '2024-03-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '10.1200', '0.0000', '10.1200', '0.0000', '9.5000', '0.0000', '9.5000', '0.0000', '2024-06-02', '2024-06-02 16:10:44', '', ''),
(56, 'Jordan', '', '2024-06-02 15:20:05', 'Initial Record', '2023-11-11', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '8.5000', '0.0000', '8.5000', '0.0000', '2.3000', '0.0000', '2.3000', '0.0000', '2024-06-02', '2024-06-02 15:20:05', '', ''),
(57, 'Mary', '', '2024-06-02 15:21:10', 'Initial Record', '2023-10-02', '2024-01-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '10.0000', '0.0000', '10.0000', '0.0000', '8.5000', '0.0000', '8.5000', '0.0000', '2024-06-02', '2024-06-02 15:59:06', '', ''),
(58, 'Jessica', '', '2024-06-02 15:22:24', 'Initial Record', '2023-08-29', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '9.5000', '0.0000', '9.5000', '0.0000', '5.2500', '0.0000', '5.2500', '0.0000', '2024-06-02', '2024-06-02 15:22:24', '', ''),
(59, 'Sarah', '', '2024-06-02 15:23:26', 'Initial Record', '2024-01-02', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '3.5000', '0.0000', '3.5000', '0.0000', '2.7500', '0.0000', '2.7500', '0.0000', '2024-06-02', '2024-06-02 15:23:26', '', ''),
(60, 'Gloria', '', '2024-06-02 15:24:26', 'Initial Record', '2023-12-22', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '9.5000', '0.0000', '9.5000', '0.0000', '5.5000', '0.0000', '5.5000', '0.0000', '2024-06-02', '2024-06-02 15:24:26', '', ''),
(61, 'Pedro', '', '2024-06-02 15:25:23', 'Initial Record', '2024-06-02', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '6.5000', '0.0000', '6.5000', '0.0000', '8.1000', '0.0000', '8.1000', '0.0000', '2024-06-02', '2024-06-02 15:25:23', '', ''),
(62, 'Carlo', '', '2024-06-02 15:26:35', 'Initial Record', '2023-09-02', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '10.5000', '0.0000', '10.5000', '0.0000', '12.2500', '0.0000', '12.2500', '0.0000', '2024-06-02', '2024-06-02 15:26:35', '', ''),
(63, 'Juan', '', '2024-06-02 15:27:24', 'Initial Record', '2024-01-02', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '4.5000', '0.0000', '4.5000', '0.0000', '3.2500', '0.0000', '3.2500', '0.0000', '2024-06-02', '2024-06-02 15:27:24', '', ''),
(64, 'Elena', '', '2024-06-02 15:28:37', 'Initial Record', '2024-02-02', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '4.5000', '0.0000', '4.5000', '0.0000', '5.7500', '0.0000', '5.7500', '0.0000', '2024-06-02', '2024-06-02 15:28:37', '', ''),
(65, 'Luz', '', '2024-06-02 15:31:33', 'Initial Record', '2020-06-02', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '10.2500', '0.0000', '10.2500', '0.0000', '9.2500', '0.0000', '9.2500', '0.0000', '2024-06-02', '2024-06-02 15:31:33', '', ''),
(66, 'victoria', '', '2024-06-02 15:34:09', 'Initial Record', '2015-12-02', '2024-01-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '0', 0, 0, 0, '12.2500', '0.0000', '12.2500', '0.0000', '5.2500', '0.0000', '5.2500', '0.0000', '2024-06-02', '2024-06-02 16:06:14', '', ''),
(67, 'ramon', '', '2024-06-02 15:36:18', 'Initial Record', '2020-06-02', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '4.2500', '0.0000', '4.2500', '0.0000', '3.2500', '0.0000', '3.2500', '0.0000', '2024-06-02', '2024-06-02 15:36:18', '', ''),
(68, 'antonio', '', '2024-06-02 15:38:12', 'Initial Record', '2022-06-21', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '5.2500', '0.0000', '5.2500', '0.0000', '4.2500', '0.0000', '4.2500', '0.0000', '2024-06-02', '2024-06-02 15:38:12', '', ''),
(69, 'rosario', '', '2024-06-02 15:40:16', 'Initial Record', '2020-06-02', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '6.2500', '0.0000', '6.2500', '0.0000', '4.2500', '0.0000', '4.2500', '0.0000', '2024-06-02', '2024-06-02 15:40:16', '', ''),
(70, 'jessie', '', '2024-06-02 15:44:17', 'Initial Record', '2019-02-27', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '5.2500', '0.0000', '5.2500', '0.0000', '4.2500', '0.0000', '4.2500', '0.0000', '2024-06-02', '2024-06-02 15:44:17', '', ''),
(71, 'isabel', '', '2024-06-02 15:46:46', 'Initial Record', '2018-06-04', '2024-06-02', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '6.2500', '0.0000', '6.2500', '0.0000', '5.2500', '0.0000', '5.2500', '0.0000', '2024-06-02', '2024-06-02 15:46:46', '', ''),
(72, 'Jericho', '', '2024-06-02 16:03:54', 'Initial Record', '2024-02-03', '2024-06-03', '0000-00-00', '0000-00-00', '0000-00-00', 'Initial Record', '', 0, 0, 0, '10.2500', '0.0000', '10.2500', '0.0000', '3.2500', '0.0000', '3.2500', '0.0000', '2024-06-03', '2024-06-02 16:03:54', '', ''),
(73, 'Jericho', '', '2024-06-02 16:03:54', 'Break Monthly Record', '2024-06-03', '2024-06-03', '0000-00-00', '0000-00-00', '0000-00-00', 'Break Monthly Record', '', 0, 0, 0, '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '2024-06-03', '2024-06-02 16:03:54', '', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`notification_id`, `dateCreated`, `empIdFrom`, `empIdTo`, `subject`, `message`, `subjectKey`, `link`, `status`, `archive`) VALUES
(38, '2024-06-02 15:48:21', 'Payad', '@Admin', 'Payad Nina Leave Form Request', 'Applying For Vacation Leave from 06-07-2024 to 06-08-2024', 'a5d15af85d55314ebb65aee0157cbed3f87d2584fed4366f06', '', 'unseen', ''),
(39, '2024-06-02 15:49:11', 'Capacio', '@Admin', 'Capacio Ren Leave Form Request', 'Applying For Sick Leave from 05-18-2024 to 05-20-2024', 'ee213dbfc09e956b3f725038571796254815c844dd35f1ae48', '', 'read', ''),
(40, '2024-06-02 15:50:04', 'Bay', '@Admin', 'Bay Jeshua Mark Leave Form Request', 'Applying For Forced Leave from 06-07-2024 to 06-08-2024', 'b46905de46f0b69d18be87744d7c41dc517e18e2a86b8a5cc4', '', 'unseen', ''),
(41, '2024-06-02 15:53:08', 'Jimmy', '@Admin', 'Banting Jimmy Leave Form Request', 'Applying For Paternity Leave from 06-07-2024 to 06-14-2024', 'e313256d1d56f8ad0f0fe1ff379185ae673a87493baa2bf087', '', 'unseen', ''),
(42, '2024-06-02 15:54:55', 'Lyca', '@Admin', 'Avilla Lyca Joy Leave Form Request', 'Applying For Study Leave from 06-11-2024 to 06-15-2024', '52322eea43b35fb8106ef3d2bbaf8fabddff164100a8663c10', '', 'unseen', ''),
(43, '2024-06-02 15:55:47', 'Rhina', '@Admin', 'Gerpacio Rhina Leave Form Request', 'Applying For Special Leave Benefits for Women from 07-07-2024 to 07-10-2024', 'a4042b407f020dddd63d43c44592097326a6e462abb0906566', '', 'unseen', ''),
(44, '2024-06-02 15:57:26', 'Julieann', '@Admin', 'Ariza Julieann Leave Form Request', 'Applying For Vacation Leave from 07-02-2024 to 07-05-2024', '27e6bf21c9d08289f314300b408b3ffda6b2a85d8ca87c9859', '', 'unseen', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_personal_info`
--

CREATE TABLE `tbl_personal_info` (
  `info_id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `bloodtype` varchar(50) NOT NULL,
  `gsis` int(50) NOT NULL,
  `pagibig` int(50) NOT NULL,
  `philhealth` int(50) NOT NULL,
  `sss` int(50) NOT NULL,
  `tin` int(50) NOT NULL,
  `agency` int(50) NOT NULL,
  `citizenship` varchar(100) NOT NULL,
  `houseNo` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `subdivision` varchar(100) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `zipCode` int(11) NOT NULL,
  `telephone` int(50) NOT NULL,
  `mobile` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_useraccounts`
--

INSERT INTO `tbl_useraccounts` (`account_id`, `employee_id`, `role`, `email`, `password`, `photoURL`, `firstName`, `middleName`, `lastName`, `suffix`, `birthdate`, `sex`, `civilStatus`, `department`, `jobPosition`, `status`, `dateStarted`, `dateCreated`, `reasonForStatus`, `archive`) VALUES
(1, 'PRO001', 'Admin', 'admin@gmail.com', 'Password', '', 'Admin', '', 'Account', '', '2000-01-01', 'Male', 'Single', '1', '1', 'Active', '2020-01-01', '2024-05-30 09:07:02', '', ''),
(10, 'FEMALE', 'Employee', 'femaie@gmail.com', 'Password', '', 'Female', '', 'Account', '', '2005-05-20', 'Female', 'Single', '1', '2', 'Active', '2024-06-01', '2024-06-02 08:44:28', '', ''),
(11, 'MALE', 'Employee', 'male@gmail.com', 'Password', '', 'Male', '', 'Account', '', '2001-01-01', 'Male', 'Single', '2', '110', 'Active', '2024-06-01', '2024-06-02 08:47:12', '', ''),
(12, 'STAFF', 'Staff', 'staff@gmail.com', 'Password', '', 'Staff', '', 'Account', '', '2001-01-01', 'Female', 'Single', '1', '1', 'Active', '2024-06-01', '2024-06-02 08:49:19', '', ''),
(13, 'Payad', 'Employee', 'maepayad000@gmail.com', 'Passwords', '', 'Nina', 'Lontoc', 'Payad', '', '2002-12-29', 'Female', 'Single', '1', '2', 'Active', '2024-01-02', '2024-06-02 14:46:22', '', ''),
(14, 'Capacio', 'Employee', 'capaciorenren@gmail.com', 'Passwords', '', 'Ren', '', 'Capacio', '', '1998-09-28', 'Male', 'Single', '3', '2', 'Active', '2024-02-02', '2024-06-02 14:50:32', '', ''),
(15, 'Bay', 'Employee', 'jeshuabay@gmail.com', 'Passwords', '', 'Jeshua Mark', 'Sarmiento', 'Bay', '', '2002-07-02', 'Male', 'Single', '3', '2', 'Active', '2023-12-02', '2024-06-02 14:53:01', '', ''),
(16, 'Rhina', 'Employee', 'rhinagerpacio@gmail.com', 'Password', '', 'Rhina', '', 'Gerpacio', '', '2000-12-22', 'Female', 'Single', '2', '2', 'Active', '2024-02-02', '2024-06-02 14:54:10', '', ''),
(17, 'Lyca', 'Employee', 'lycaavilla@gmail.com', 'Password', '', 'Lyca Joy', '', 'Avilla', '', '2001-02-09', 'Male', 'Single', '4', '2', 'Active', '2024-02-15', '2024-06-02 14:56:23', '', ''),
(18, 'Julieann', 'Employee', 'julieannariza@gmail.com', 'Password', '', 'Julieann', '', 'Ariza', '', '2001-02-06', 'Male', 'Single', '4', '2', 'Active', '2023-03-07', '2024-06-02 15:05:34', '', ''),
(19, 'Joseph', 'Employee', 'markjoseph@gmail.com', 'Password', '', 'Mark Joseph', '', 'Sta.Cruz', '', '1999-01-22', 'Male', 'Single', '5', '2', 'Active', '2023-12-11', '2024-06-02 15:07:22', '', ''),
(20, 'Jimmy', 'Employee', 'jimmyboy@gmail.com', 'Password', '', 'Jimmy', '', 'Banting', '', '1998-12-22', 'Male', 'Single', '16', '104', 'Active', '2023-05-10', '2024-06-02 15:15:39', '', ''),
(21, 'James', 'Employee', 'jameanderson@gmail.com', 'Password', '', 'James', '', 'Anderson', '', '1990-12-22', 'Male', 'Married', '15', '105', 'Active', '2024-01-20', '2024-06-02 15:16:51', '', ''),
(22, 'John', 'Employee', 'jonfoster@gmail.com', 'Password', '', 'John', '', 'Foster', '', '1992-10-02', 'Male', 'Single', '14', '103', 'Active', '2023-03-02', '2024-06-02 15:17:54', '', ''),
(23, 'Susan', 'Employee', 'susanhill@gmail.com', 'Password', '', 'Susan', '', 'Hill', '', '1998-12-20', 'Female', 'Single', '13', '108', 'Active', '2023-11-20', '2024-06-02 15:18:55', '', ''),
(24, 'Jordan', 'Employee', 'jordantaylor@gmail.co', 'Password', '', 'Jordan', '', 'Taylor', '', '2000-12-22', 'Male', 'Single', '12', '106', 'Active', '2023-11-11', '2024-06-02 15:20:05', '', ''),
(25, 'Mary', 'Employee', 'maryadams@gmail.com', 'Password', '', 'Mary', '', 'Adams', '', '1999-12-10', 'Female', 'Married', '11', '107', 'Active', '2023-10-02', '2024-06-02 15:21:10', '', ''),
(26, 'Jessica', 'Employee', 'jessicamiller@gmail.com', 'Password', '', 'Jessica', '', 'Miller', '', '1997-01-22', 'Female', 'Single', '10', '107', 'Active', '2023-08-29', '2024-06-02 15:22:24', '', ''),
(27, 'Sarah', 'Employee', 'sarahnelson@gmail.com', 'Password', '', 'Sarah', '', 'Nelson', '', '1996-10-21', 'Female', 'Single', '9', '110', 'Active', '2024-01-02', '2024-06-02 15:23:26', '', ''),
(28, 'Gloria', 'Employee', 'gloriasalazar@gmail.com', 'Password', '', 'Gloria', '', 'Salazar', '', '1999-10-10', 'Female', 'Single', '8', '108', 'Active', '2023-12-22', '2024-06-02 15:24:26', '', ''),
(29, 'Pedro', 'Employee', 'pedrolopez@gmail.com', 'Password', '', 'Pedro', '', 'Lopez', '', '2000-09-11', 'Male', 'Single', '7', '108', 'Active', '2024-06-02', '2024-06-02 15:25:23', '', ''),
(30, 'Carlo', 'Employee', 'carlofernandez@gmail.com', 'Password', '', 'Carlo', '', 'Fernandez', 'Jr.', '1998-05-22', 'Male', 'Single', '6', '103', 'Active', '2023-09-02', '2024-06-02 15:26:34', '', ''),
(31, 'Juan', 'Employee', 'juancruz@gmail.com', 'Password', '', 'Juan', '', 'Cruz', '', '1997-10-12', 'Male', 'Single', '5', '108', 'Active', '2024-01-02', '2024-06-02 15:27:24', '', ''),
(32, 'Elena', 'Employee', 'elenamorales@gmail.com', 'Password', '', 'Elena', '', 'Morales', '', '1998-10-15', 'Female', 'Single', '3', '106', 'Active', '2024-02-02', '2024-06-02 15:28:37', '', ''),
(33, 'Luz', 'Employee', 'luzramirez@gmail.com', 'Password', '', 'Luz', '', 'Ramirez', '', '1998-02-14', 'Female', 'Single', '3', '105', 'Active', '2020-06-02', '2024-06-02 15:31:33', '', ''),
(34, 'victoria', 'Employee', 'victoriacastillo@gmail.com', 'Password', '', 'Victoria', '', 'Castillo', '', '1996-03-22', 'Female', 'Married', '14', '105', 'Active', '2015-12-02', '2024-06-02 15:34:09', '', ''),
(35, 'ramon', 'Employee', 'ramonmendoza@gmail.com', 'password', '', 'Ramon', '', 'Mendoza', 'Jr.', '1999-05-25', 'Male', 'Single', '16', '104', 'Active', '2020-06-02', '2024-06-02 15:36:18', '', ''),
(36, 'antonio', 'Employee', 'antoniogarcia@gmail.com', 'password', '', 'Antonio', '', 'Garcia', '', '1997-12-25', 'Male', 'Divorced', '5', '103', 'Active', '2022-06-21', '2024-06-02 15:38:12', '', ''),
(37, 'rosario', 'Employee', 'rosariovillanueva@gmail.com', 'password', '', 'Rosario', '', 'Villanueva', '', '2000-06-30', 'Female', 'Single', '8', '102', 'Active', '2020-06-02', '2024-06-02 15:40:16', '', ''),
(38, 'jessie', 'Employee', 'jessieramos@gmail.com', 'password', '', 'Jessie', '', 'Ramos', '', '1995-02-24', 'Female', 'Single', '9', '108', 'Active', '2019-02-27', '2024-06-02 15:44:16', '', ''),
(39, 'isabel', 'Employee', 'isabelmarquez@gmail.com', 'password', '', 'Isabel', '', 'Marquez', '', '1998-12-29', 'Female', 'Married', '16', '103', 'Active', '2018-06-04', '2024-06-02 15:46:46', '', ''),
(40, 'Jericho', 'Employee', 'jerichopulido@gmail.com', 'Password', '', 'Jericho', '', 'Pulido', '', '1998-05-20', 'Male', 'Divorced', '7', '103', 'Inactive', '2024-02-03', '2024-06-02 16:03:54', 'Resigned', 'deleted');

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
-- Indexes for table `tbl_educational_background`
--
ALTER TABLE `tbl_educational_background`
  ADD PRIMARY KEY (`education_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `tbl_family_background`
--
ALTER TABLE `tbl_family_background`
  ADD PRIMARY KEY (`family_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

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
-- Indexes for table `tbl_personal_info`
--
ALTER TABLE `tbl_personal_info`
  ADD PRIMARY KEY (`info_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

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
  MODIFY `department_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_designations`
--
ALTER TABLE `tbl_designations`
  MODIFY `designation_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `tbl_educational_background`
--
ALTER TABLE `tbl_educational_background`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_family_background`
--
ALTER TABLE `tbl_family_background`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_laterecordfile`
--
ALTER TABLE `tbl_laterecordfile`
  MODIFY `laterecordfile_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_leavedataform`
--
ALTER TABLE `tbl_leavedataform`
  MODIFY `leavedataform_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tbl_leaves`
--
ALTER TABLE `tbl_leaves`
  MODIFY `leave_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `notification_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_passwordreset_tokens`
--
ALTER TABLE `tbl_passwordreset_tokens`
  MODIFY `token_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_personal_info`
--
ALTER TABLE `tbl_personal_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_systemsettings`
--
ALTER TABLE `tbl_systemsettings`
  MODIFY `setting_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_useraccounts`
--
ALTER TABLE `tbl_useraccounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
