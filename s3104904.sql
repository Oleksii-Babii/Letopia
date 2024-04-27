-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 07, 2024 at 11:30 PM
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
-- Database: `s3104904`
--

-- --------------------------------------------------------

--
-- Table structure for table `appliance`
--

CREATE TABLE `appliance` (
  `applianceId` int(11) NOT NULL,
  `applianceType` varchar(40) DEFAULT NULL,
  `brand` varchar(40) DEFAULT NULL,
  `modelNumber` varchar(40) DEFAULT NULL,
  `serialNumber` varchar(40) DEFAULT NULL,
  `purchaseDate` date DEFAULT NULL,
  `warrantyExpirationDate` date DEFAULT NULL,
  `costOfAppliance` decimal(10,2) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appliance`
--

INSERT INTO `appliance` (`applianceId`, `applianceType`, `brand`, `modelNumber`, `serialNumber`, `purchaseDate`, `warrantyExpirationDate`, `costOfAppliance`, `userId`) VALUES
(1, 'Refrigerator', 'ASW', 'GH7452', 'F54R55', '2020-03-07', '2022-03-07', 350.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `mobile` varchar(13) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `eircode` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `firstName`, `lastName`, `address`, `mobile`, `email`, `eircode`) VALUES
(1, 'John', 'Smith', '123 Main Street Dublin 1 County Dublin Ireland', '+353853005047', 'john.smith@gmail.com', 'D08 Y14X');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appliance`
--
ALTER TABLE `appliance`
  ADD PRIMARY KEY (`applianceId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appliance`
--
ALTER TABLE `appliance`
  MODIFY `applianceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appliance`
--
ALTER TABLE `appliance`
  ADD CONSTRAINT `appliance_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
