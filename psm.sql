-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2023 at 08:24 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psm`
--

-- --------------------------------------------------------

--
-- Table structure for table `chief`
--

CREATE TABLE `chief` (
  `chiefID` int(20) NOT NULL,
  `chiefName` varchar(50) NOT NULL,
  `chiefPhoneNo` varchar(20) NOT NULL,
  `chiefEmail` varchar(50) NOT NULL,
  `chiefPassword` varchar(50) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chief`
--

INSERT INTO `chief` (`chiefID`, `chiefName`, `chiefPhoneNo`, `chiefEmail`, `chiefPassword`, `user_type`) VALUES
(4000, 'Hana', '0123356014', 'hana@yahoo.com', 'hana123', 'chief');

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `jobID` int(20) NOT NULL,
  `jobDescription` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`jobID`, `jobDescription`) VALUES
(2000, 'Zone A ( Gold Citizen)'),
(2001, 'Zone B ( Mother and Child Care)'),
(2002, 'Zone C (Vaccine)');

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplication`
--

CREATE TABLE `leaveapplication` (
  `leaveID` int(11) NOT NULL,
  `nursesID` int(11) DEFAULT NULL,
  `jobID` int(20) NOT NULL,
  `dateLeave` date DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leaveapplication`
--

INSERT INTO `leaveapplication` (`leaveID`, `nursesID`, `jobID`, `dateLeave`, `reason`, `status`) VALUES
(2, 1717, 2000, '2023-06-01', 'ww', 'Approved'),
(9, 1718, 2001, '2023-06-01', 'emergency', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `nurses`
--

CREATE TABLE `nurses` (
  `nursesID` int(20) NOT NULL,
  `nursesName` varchar(50) NOT NULL,
  `nursesPhoneNo` varchar(20) NOT NULL,
  `nursesEmail` varchar(50) NOT NULL,
  `nursesPassword` varchar(50) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `jobID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nurses`
--

INSERT INTO `nurses` (`nursesID`, `nursesName`, `nursesPhoneNo`, `nursesEmail`, `nursesPassword`, `user_type`, `jobID`) VALUES
(1717, 'Intan', '0153387401', 'intan@gmail.com', 'intan123', 'nurse', 2000),
(1718, 'Ahmad Keanu', '01430117894', 'keanu@gmail.com', 'ahmad1234', 'nurse', 2001),
(1719, 'Lisa Rose ', '0119635858', 'rose@yahoo.com', 'lisa123', 'nurse', 2002),
(1720, 'Jasmine Suraya', '0192530176', 'suraya@gmail.com', 'suraya123', 'nurse', 2000),
(1721, 'Sabrina Cheswell', '0161147586', 'sabrina@yahoo.com', 'sabrina123', 'nurse', 2001),
(1722, 'Raju A/L Sam', '0181118888', 'raju@yahoo.com', 'raju123', 'nurse', 2002);

-- --------------------------------------------------------

--
-- Table structure for table `replacement`
--

CREATE TABLE `replacement` (
  `replacementID` int(11) NOT NULL,
  `leaveID` int(11) DEFAULT NULL,
  `jobID` int(11) DEFAULT NULL,
  `replacement_staff_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleID` int(20) NOT NULL,
  `date` date NOT NULL,
  `nursesID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleID`, `date`, `nursesID`) VALUES
(3000, '2023-06-01', 1720),
(3001, '2023-06-01', 1721),
(3002, '2023-06-01', 1719),
(3003, '2023-06-02', 1720),
(3004, '2023-06-02', 1721),
(3005, '2023-06-02', 1722),
(3006, '2023-07-01', 1717);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chief`
--
ALTER TABLE `chief`
  ADD PRIMARY KEY (`chiefID`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`jobID`),
  ADD UNIQUE KEY `jobDescription` (`jobDescription`);

--
-- Indexes for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD PRIMARY KEY (`leaveID`),
  ADD KEY `nursesID` (`nursesID`),
  ADD KEY `jobID` (`jobID`);

--
-- Indexes for table `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`nursesID`),
  ADD KEY `jobID` (`jobID`);

--
-- Indexes for table `replacement`
--
ALTER TABLE `replacement`
  ADD PRIMARY KEY (`replacementID`),
  ADD KEY `leaveID` (`leaveID`),
  ADD KEY `jobID` (`jobID`),
  ADD KEY `replacement_staff_id` (`replacement_staff_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleID`),
  ADD KEY `staffID` (`nursesID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chief`
--
ALTER TABLE `chief`
  MODIFY `chiefID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4001;

--
-- AUTO_INCREMENT for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  MODIFY `leaveID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nurses`
--
ALTER TABLE `nurses`
  MODIFY `nursesID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1723;

--
-- AUTO_INCREMENT for table `replacement`
--
ALTER TABLE `replacement`
  MODIFY `replacementID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3007;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD CONSTRAINT `leaveapplication_ibfk_1` FOREIGN KEY (`nursesID`) REFERENCES `nurses` (`nursesID`),
  ADD CONSTRAINT `leaveapplication_ibfk_2` FOREIGN KEY (`jobID`) REFERENCES `job` (`jobID`);

--
-- Constraints for table `nurses`
--
ALTER TABLE `nurses`
  ADD CONSTRAINT `nurses_ibfk_1` FOREIGN KEY (`jobID`) REFERENCES `job` (`jobID`);

--
-- Constraints for table `replacement`
--
ALTER TABLE `replacement`
  ADD CONSTRAINT `replacement_ibfk_1` FOREIGN KEY (`leaveID`) REFERENCES `leaveapplication` (`leaveID`),
  ADD CONSTRAINT `replacement_ibfk_2` FOREIGN KEY (`jobID`) REFERENCES `job` (`jobID`),
  ADD CONSTRAINT `replacement_ibfk_3` FOREIGN KEY (`replacement_staff_id`) REFERENCES `nurses` (`nursesID`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`nursesID`) REFERENCES `nurses` (`nursesID`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`nursesID`) REFERENCES `nurses` (`nursesID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
