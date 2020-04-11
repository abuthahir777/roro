-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2020 at 05:32 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roro`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessrights`
--

CREATE TABLE `accessrights` (
  `rightsId` int(11) NOT NULL,
  `roleId` int(20) NOT NULL,
  `moduleId` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accessrights`
--

INSERT INTO `accessrights` (`rightsId`, `roleId`, `moduleId`) VALUES
(48, 1, 1),
(49, 1, 6),
(50, 1, 7),
(51, 1, 8),
(52, 1, 9),
(53, 1, 46),
(54, 1, 47),
(55, 1, 48),
(56, 1, 49),
(57, 1, 50),
(58, 1, 51),
(59, 1, 52),
(60, 1, 53),
(61, 1, 54),
(62, 1, 55),
(63, 1, 56),
(64, 1, 57),
(65, 1, 58),
(66, 1, 59),
(67, 1, 60);

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE `airport` (
  `airportId` int(11) NOT NULL,
  `airportCode` varchar(30) NOT NULL,
  `airportName` varchar(50) NOT NULL,
  `countryId` int(11) NOT NULL,
  `stateId` int(11) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airport`
--

INSERT INTO `airport` (`airportId`, `airportCode`, `airportName`, `countryId`, `stateId`, `active_status`, `delete_status`) VALUES
(1, 'CIAL', 'Cochin Airport', 1, 1, 0, 0),
(2, 'KON', 'Kannur', 2, 3, 0, 0),
(3, 'HAI', 'Ahi', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `businesstype`
--

CREATE TABLE `businesstype` (
  `businessId` int(11) NOT NULL,
  `businessName` varchar(50) NOT NULL,
  `active_status` int(10) NOT NULL,
  `delete_status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `businesstype`
--

INSERT INTO `businesstype` (`businessId`, `businessName`, `active_status`, `delete_status`) VALUES
(1, 'Port To Port', 0, 0),
(2, 'Test Test', 0, 0),
(3, 'Test', 0, 0),
(4, 'Airport To Airport ', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `cityId` int(11) NOT NULL,
  `cityCode` varchar(30) NOT NULL,
  `cityName` varchar(50) NOT NULL,
  `stateId` int(11) NOT NULL,
  `countryId` int(11) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`cityId`, `cityCode`, `cityName`, `stateId`, `countryId`, `active_status`, `delete_status`) VALUES
(1, 'EKM', 'Ernakulam', 1, 1, 0, 0),
(2, 'TVM', 'TRIVANDRUM', 1, 1, 0, 0),
(3, 'TEST', 'TEST', 1, 1, 1, 1),
(4, 'AD', 'Wdwdwdw', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `countryId` int(11) NOT NULL,
  `countryCode` varchar(30) NOT NULL,
  `countryName` varchar(50) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`countryId`, `countryCode`, `countryName`, `active_status`, `delete_status`) VALUES
(1, 'IND', 'India', 0, 0),
(2, 'AUS', 'Australia', 0, 0),
(3, 'USA', 'America', 1, 0),
(4, 'CODE', 'Wqdwqd Test', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currencyId` int(11) NOT NULL,
  `currencyCode` varchar(30) NOT NULL,
  `currencyName` varchar(30) NOT NULL,
  `countryId` int(11) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currencyId`, `currencyCode`, `currencyName`, `countryId`, `active_status`, `delete_status`) VALUES
(1, 'Rs', 'Rupees', 1, 1, 0),
(2, 'TEST', 'Test', 1, 0, 0),
(3, 'WDW ', 'Wdwd', 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerId` int(11) NOT NULL,
  `customerFname` varchar(50) NOT NULL,
  `customerLname` varchar(50) NOT NULL,
  `customerEmail` varchar(60) NOT NULL,
  `customerMobile` varchar(50) NOT NULL,
  `customerPassword` varchar(300) NOT NULL,
  `customerCity` int(100) NOT NULL,
  `customerState` int(100) NOT NULL,
  `customerCountry` int(100) NOT NULL,
  `customerCompany` varchar(100) NOT NULL,
  `customerAddress` varchar(300) NOT NULL,
  `customerBusinessType` varchar(100) NOT NULL,
  `customerShipmentFrequency` varchar(100) NOT NULL,
  `customerIDName` varchar(250) NOT NULL,
  `active_status` int(10) NOT NULL,
  `delete_status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `customerFname`, `customerLname`, `customerEmail`, `customerMobile`, `customerPassword`, `customerCity`, `customerState`, `customerCountry`, `customerCompany`, `customerAddress`, `customerBusinessType`, `customerShipmentFrequency`, `customerIDName`, `active_status`, `delete_status`) VALUES
(1, 'Updated', 'Updated', 'roroupdated@gmail.com', '6546546544444', '34d71b97c471931334f385b4e7b7379c', 0, 0, 2, 'Updated', 'Updatedupdatedupdatedupdatedupdatedupdatedupdatedupdated', '2', '2', 'aqwfaq_wfwf_aqwfwe.jpg', 0, 1),
(2, 'Abu', 'Abu', 't4thahir@gmail.com', '9645143007', '34d71b97c471931334f385b4e7b7379c', 1, 1, 1, 'Abu', 'Abu', '2', '2', 'abu_abu_abu.jpg', 0, 0),
(3, 'Abu', 'Thahir', 't4thahir@gmail.com', '9645143007', '34d71b97c471931334f385b4e7b7379c', 1, 1, 1, 'Serville Tech Nologies', 'Manath Thoppil Biuldinbg, Near Sunrise Hospital, Kakkanad', '4', '2', 'abu_thahir_serville_tech_nologies.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `deliverytype`
--

CREATE TABLE `deliverytype` (
  `deliveryTypeId` int(11) NOT NULL,
  `deliveryTypeName` varchar(50) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deliverytype`
--

INSERT INTO `deliverytype` (`deliveryTypeId`, `deliveryTypeName`, `active_status`, `delete_status`) VALUES
(1, 'Port to Port', 0, 0),
(2, 'Airport to Airport', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `moduleId` int(11) NOT NULL,
  `moduleName` varchar(60) NOT NULL,
  `tableId` int(11) NOT NULL,
  `operationId` int(11) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`moduleId`, `moduleName`, `tableId`, `operationId`, `active_status`, `delete_status`) VALUES
(1, 'Country - View', 1, 1, 0, 0),
(6, 'Country - Create', 1, 2, 0, 0),
(7, 'Country - Update', 1, 3, 0, 0),
(8, 'Country - Delete', 1, 4, 0, 0),
(9, 'Country - Status', 1, 5, 0, 0),
(10, 'Airport - Create', 4, 2, 0, 0),
(11, 'Airport - Update', 4, 3, 0, 0),
(12, 'Airport - Delete', 4, 4, 0, 0),
(13, 'Airport - Status', 4, 5, 0, 0),
(35, 'Airport - View', 4, 1, 0, 0),
(36, 'State -View', 2, 1, 0, 0),
(37, 'State - Create', 2, 2, 0, 0),
(38, 'State - Update', 2, 3, 0, 0),
(39, 'State - Delete', 2, 4, 0, 0),
(40, 'State - Status', 2, 5, 0, 0),
(41, 'City - View', 3, 1, 0, 0),
(42, 'City - Create', 3, 2, 0, 0),
(43, 'City - Update', 3, 3, 0, 0),
(44, 'City - Delete', 3, 4, 0, 0),
(45, 'City - Status', 3, 5, 0, 0),
(46, 'Module - View', 8, 1, 0, 0),
(47, 'Module - Create', 8, 2, 0, 0),
(48, 'Module -Update', 8, 3, 0, 0),
(49, 'Module - Delete', 8, 4, 0, 0),
(50, 'Module -Status', 8, 5, 0, 0),
(51, 'Role - View', 9, 1, 0, 0),
(52, 'Role - Create', 9, 2, 0, 0),
(53, 'Role - Update', 9, 3, 0, 0),
(54, 'Role - Delete', 9, 4, 0, 0),
(55, 'Role -Status', 9, 5, 0, 0),
(56, 'User - View', 10, 1, 0, 0),
(57, 'User - Create', 10, 2, 0, 0),
(58, 'User - Update', 10, 3, 0, 0),
(59, 'User - Delete', 10, 4, 0, 0),
(60, 'User - Status', 10, 5, 0, 0),
(61, 'Currency - Update', 6, 3, 0, 0),
(62, 'Port - View', 5, 1, 0, 0),
(63, 'Port - Create', 5, 2, 0, 0),
(64, 'Port - Update', 5, 3, 0, 0),
(65, 'Port - Status', 5, 5, 0, 0),
(66, 'Port - Delete', 5, 4, 0, 0),
(67, 'Business Type - View', 12, 1, 0, 0),
(68, 'Business Type - Create', 12, 2, 0, 0),
(69, 'Business Type - Update', 12, 3, 0, 0),
(70, 'Business Type - Delete', 12, 4, 0, 0),
(71, 'Business Type - Status', 12, 5, 0, 0),
(72, 'Shipment Frequency - View', 14, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `operations`
--

CREATE TABLE `operations` (
  `operationId` int(11) NOT NULL,
  `operationName` varchar(60) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `operations`
--

INSERT INTO `operations` (`operationId`, `operationName`, `active_status`, `delete_status`) VALUES
(1, 'View', 0, 0),
(2, 'Create', 0, 0),
(3, 'Update', 0, 0),
(4, 'Delete', 0, 0),
(5, 'Status', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `port`
--

CREATE TABLE `port` (
  `portId` int(11) NOT NULL,
  `portCode` varchar(20) NOT NULL,
  `portName` varchar(50) NOT NULL,
  `countryId` int(11) NOT NULL,
  `stateId` int(11) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `port`
--

INSERT INTO `port` (`portId`, `portCode`, `portName`, `countryId`, `stateId`, `active_status`, `delete_status`) VALUES
(1, 'TEST', 'Test', 1, 1, 0, 0),
(2, 'TEST1', 'Test1 ', 1, 1, 1, 0),
(3, '', '', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `roleId` int(11) NOT NULL,
  `roleName` varchar(50) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleId`, `roleName`, `active_status`, `delete_status`) VALUES
(1, 'Admin', 0, 0),
(2, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shipmentfrequency`
--

CREATE TABLE `shipmentfrequency` (
  `freqShipmentId` int(11) NOT NULL,
  `freqShipmentName` varchar(50) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipmentfrequency`
--

INSERT INTO `shipmentfrequency` (`freqShipmentId`, `freqShipmentName`, `active_status`, `delete_status`) VALUES
(1, 'Monthly', 0, 0),
(2, 'Daily', 0, 0),
(3, 'Hai', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `stateId` int(11) NOT NULL,
  `stateCode` varchar(30) NOT NULL,
  `stateName` varchar(50) NOT NULL,
  `countryId` int(11) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`stateId`, `stateCode`, `stateName`, `countryId`, `active_status`, `delete_status`) VALUES
(1, 'KL', 'Kerala', 1, 0, 0),
(2, 'TN ', 'Tamilnadu', 1, 0, 0),
(3, 'TEST', 'Test', 2, 0, 0),
(4, 'TEST', 'Test', 1, 1, 0),
(5, 'TEST1', 'Test1', 1, 0, 0),
(6, 'TTGAGGAGA', 'Gagagaga', 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `tableId` int(11) NOT NULL,
  `tableName` varchar(50) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tableId`, `tableName`, `active_status`, `delete_status`) VALUES
(1, 'Country', 0, 0),
(2, 'State', 0, 0),
(3, 'City', 0, 0),
(4, 'Airport', 0, 0),
(5, 'Port', 0, 0),
(6, 'Currency', 0, 0),
(7, 'Delivery Type', 0, 0),
(8, 'Module', 0, 0),
(9, 'Role', 0, 0),
(10, 'User', 0, 0),
(11, 'Customer', 0, 0),
(12, 'Business Type', 0, 0),
(13, 'Shipment Frequency', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `userCode` varchar(50) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPassword` varchar(400) NOT NULL,
  `userMobile` varchar(50) NOT NULL,
  `roleId` int(11) NOT NULL,
  `active_status` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `firstName`, `lastName`, `userCode`, `userEmail`, `userPassword`, `userMobile`, `roleId`, `active_status`, `delete_status`) VALUES
(1, 'Chartering', 'Roro', 'RORO', 'roro@gmail.com', '54b1d109dc7156ef46816a9527a861bc', '9645964596', 1, 0, 1),
(8, 'Test', 'Test', 'TEST', 'roro@gmail.com', '098f6bcd4621d373cade4e832627b4f6', '9645143307', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessrights`
--
ALTER TABLE `accessrights`
  ADD PRIMARY KEY (`rightsId`);

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`airportId`);

--
-- Indexes for table `businesstype`
--
ALTER TABLE `businesstype`
  ADD PRIMARY KEY (`businessId`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`cityId`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`countryId`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currencyId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`);

--
-- Indexes for table `deliverytype`
--
ALTER TABLE `deliverytype`
  ADD PRIMARY KEY (`deliveryTypeId`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`moduleId`);

--
-- Indexes for table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`operationId`);

--
-- Indexes for table `port`
--
ALTER TABLE `port`
  ADD PRIMARY KEY (`portId`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `shipmentfrequency`
--
ALTER TABLE `shipmentfrequency`
  ADD PRIMARY KEY (`freqShipmentId`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`stateId`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`tableId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessrights`
--
ALTER TABLE `accessrights`
  MODIFY `rightsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `airport`
--
ALTER TABLE `airport`
  MODIFY `airportId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `businesstype`
--
ALTER TABLE `businesstype`
  MODIFY `businessId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `cityId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `countryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currencyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deliverytype`
--
ALTER TABLE `deliverytype`
  MODIFY `deliveryTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `moduleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `operations`
--
ALTER TABLE `operations`
  MODIFY `operationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `port`
--
ALTER TABLE `port`
  MODIFY `portId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `roleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shipmentfrequency`
--
ALTER TABLE `shipmentfrequency`
  MODIFY `freqShipmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `stateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `tableId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
