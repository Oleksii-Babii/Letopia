-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 01:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `appliances`
--

CREATE TABLE `appliances` (
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
-- Dumping data for table `appliances`
--

INSERT INTO `appliances` (`applianceId`, `applianceType`, `brand`, `modelNumber`, `serialNumber`, `purchaseDate`, `warrantyExpirationDate`, `costOfAppliance`, `userId`) VALUES
(28, 'Washing Machine', 'LG', 'WMX-5000', 'F91R457', '2020-02-10', '2024-02-10', 400.50, 52),
(29, 'Refrigerator', 'Samsung', 'RF28R7351SR', 'RF/28HFEDBSR-AA', '2021-04-25', '2024-04-25', 499.99, 15),
(30, 'Refrigerator', 'Electrolux', 'EI23BC82SS', 'EF123456789', '2018-02-13', '2020-02-13', 249.99, 15),
(31, 'Freezer', 'Whirlpool', 'WRS325SDHZ', '901SDF', '2020-11-25', '2022-11-25', 250.00, 15),
(32, 'Washing Machine', 'Bosch', 'B36CT80SNS', '9876543210', '2023-05-01', '2025-01-01', 299.99, 57),
(33, 'Toaster', 'KitchenAid', 'DA750', 'KMT2204OB', '2024-04-05', '2027-04-05', 89.50, 1),
(34, 'Washing Machine', 'Samsung', 'F45EAF450', 'WA52J8700AP', '2016-07-15', '2021-01-01', 222.22, 3),
(35, 'Dishwasher', 'Bosch', 'SHXM98W75N', 'XYZ987654321', '2019-04-28', '2024-01-01', 250.00, 6);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_ID` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `postcode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_ID`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `state`, `postcode`) VALUES
(0, 'Oleksii', 'Babii', 'babiy.olexiy@ukr.net', '3806858639', 'Apartment 105 Block 1A Griffith Hall', 'Uman', '', 'D08Y17X');

-- --------------------------------------------------------

--
-- Table structure for table `feature_box`
--

CREATE TABLE `feature_box` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `detail` varchar(400) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `propertyId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feature_boxes`
--

CREATE TABLE `feature_boxes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feature_boxes`
--

INSERT INTO `feature_boxes` (`id`, `title`, `description`, `image`) VALUES
(1, 'Initial Title 1', 'Initial Description 1', 'images/feature_box_1.jpg'),
(2, 'Initial Title 2', 'Initial Description 2', 'images/feature_box_2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `room` varchar(30) DEFAULT NULL,
  `itemDescription` varchar(80) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `itemCondition` varchar(30) DEFAULT NULL,
  `propertyId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `landlord_account`
--

CREATE TABLE `landlord_account` (
  `landlordId` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `rentalIncome` decimal(9,2) DEFAULT NULL,
  `commission` decimal(7,2) DEFAULT NULL,
  `managementFee` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `eircode` varchar(8) NOT NULL,
  `rentalPrice` decimal(8,2) DEFAULT NULL,
  `numOfBedrooms` int(11) DEFAULT NULL,
  `lengthOfTenancy` int(11) DEFAULT NULL,
  `landlordId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_photo`
--

CREATE TABLE `property_photo` (
  `propertyId` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenancy_agreement`
--

CREATE TABLE `tenancy_agreement` (
  `agreementNumber` int(11) NOT NULL,
  `rentalPrice` decimal(8,2) DEFAULT NULL,
  `lengthOfTenancy` int(11) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `amountPaid` decimal(9,2) DEFAULT NULL,
  `amountOwed` decimal(9,2) DEFAULT NULL,
  `propertyId` int(11) DEFAULT NULL,
  `landlordId` int(11) DEFAULT NULL,
  `tenantId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL,
  `isApproved` tinyint(1) DEFAULT 0,
  `serviceName` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `comment` varchar(255) NOT NULL,
  `authorId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `role` enum('landlord','tenant','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `id` int(11) NOT NULL,
  `name` varchar(75) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`id`, `name`, `password`, `email`, `role`) VALUES
(1, 'Admin User', '$2y$10$yF4qff5LgFx680nDHzM05uQm2Mn.dvv9.MgibZAtG6FMc.I.Phbae', 'admin@example.com', 'admin'),
(2, 'Admin User', '$2y$10$fiiQ802j5DFWcqwUd1vesutHZiTxEvNWj6s9cDCQ0EFQ0CtURVFua', 'admin@example.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `mobile` varchar(13) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `eircode` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `firstName`, `lastName`, `address`, `mobile`, `email`, `eircode`) VALUES
(1, 'John', 'Smith', '123 Main Street Dublin 1 County Dublin Ireland                                                      ', '+353853005047', 'liam.neill@gmail.com', 'D11 Y14X'),
(3, 'Emily', 'Johnson', '246 Maple Street Dublin 8 County Dublin \r\nIreland                                                   ', '+353855457599', 'emily.johnson@gmail.com', 'D08 Y15X'),
(6, 'Jane', 'Doe', '456 Side Street, Dublin 2, County Dublin, Ireland', '+353874075010', 'jane.doe@gmail.com', 'D04 X18Y'),
(7, 'Alice', 'Murphy', '789 Off Road, Dublin 3, County Dublin, Ireland					            ', '+353855005049', 'alice.murphy@gmail.com', 'D06 R23F'),
(15, 'Michael', 'Johnson', '789 Oak Avenue, Galway City, Ireland					            ', '+353899876543', 'michael.johnson@gmail.com', 'H91 H2X3'),
(46, 'Emily', 'Brown', '321 Maple Road Limerick City Limerick Ireland				            					            					            					', '+353861234567', 'emily.brown@gmail.com', 'V94 E3X9'),
(47, 'David', 'Wilson', '567 Pine Street Belfast City Belfast Ireland					            					            ', '+353861234567', 'david.wilson@gmail.com', 'A92 X3Y7'),
(48, 'Sarah', 'Taylor', '890 Cedar Road Waterford City Waterford Ireland			            ', '+353871234567', 'sarah.taylor@gmail.com', 'X91 YH2Z'),
(49, 'Daniel', 'Martinez', '234 Birch Avenue Drogheda County Louth Ireland		            					            ', '+353899876543', 'daniel.martinez@gamil.com', 'A92 X3Y7'),
(50, 'Sophia', 'Davis', '321 Maple Road Limerick City Limerick Ireland				            ', '+353861234567', 'sophia.davis@gmail.com', 'V94 E3X9'),
(52, 'Liam', 'O’Neill', '123 Main Street Dublin 1 County Dublin Ireland			            ', '353853005047', 'liam.neill@gmail.com', 'D08 Y14X'),
(57, 'Olivia', 'Garcia', '123 Willow Street Cork City Cork Ireland				            ', '+353851234567', 'olivia.garcia@gmail.com', 'T12 Y14D'),
(59, 'Emily', 'O&#039;Connor', '12 Beach Street, Dublin, County Dublin, Irelan', '+380685863974', 'babii.oleksiii@gmail.com', 'D08Y14D'),
(61, 'Ryan', 'Garcia', '135 Oakwood Avenue \r\nGalway City\r\n Galway Ireland					            					            					            ', '+353873210987', 'ryan.garcia@gmail.com', 'T12 K3D1'),
(62, 'John', 'Smitd', 'APARTMENT 105, BLOCK 1A\r\nGRIFFITH HALL, GRIFFITH COLLEGE\r\nSOUTH CIRCULAR ROAD					            ', '+353852004904', 'babiy.olexiy@ukr.net', 'F93 YH72'),
(63, 'Oleksii', 'Smith', 'APARTMENT 105, BLOCK 1A\r\nGRIFFITH HALL, GRIFFITH COLLEGE\r\nSOUTH CIRCULAR ROAD', '+353852004904', 'babiy.olexiy@ukr.net', 'D10 Y14X');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appliances`
--
ALTER TABLE `appliances`
  ADD PRIMARY KEY (`applianceId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feature_box`
--
ALTER TABLE `feature_box`
  ADD PRIMARY KEY (`id`),
  ADD KEY `propertyId` (`propertyId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `propertyId` (`propertyId`);

--
-- Indexes for table `landlord_account`
--
ALTER TABLE `landlord_account`
  ADD PRIMARY KEY (`landlordId`,`propertyId`),
  ADD KEY `propertyId` (`propertyId`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `landlordId` (`landlordId`);

--
-- Indexes for table `property_photo`
--
ALTER TABLE `property_photo`
  ADD PRIMARY KEY (`propertyId`,`photo`);

--
-- Indexes for table `tenancy_agreement`
--
ALTER TABLE `tenancy_agreement`
  ADD PRIMARY KEY (`agreementNumber`),
  ADD KEY `propertyId` (`propertyId`),
  ADD KEY `landlordId` (`landlordId`),
  ADD KEY `tenantId` (`tenantId`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authorId` (`authorId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appliances`
--
ALTER TABLE `appliances`
  MODIFY `applianceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feature_box`
--
ALTER TABLE `feature_box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userlogin`
--
ALTER TABLE `userlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appliances`
--
ALTER TABLE `appliances`
  ADD CONSTRAINT `appliances_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feature_box`
--
ALTER TABLE `feature_box`
  ADD CONSTRAINT `feature_box_ibfk_1` FOREIGN KEY (`propertyId`) REFERENCES `property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`propertyId`) REFERENCES `property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `landlord_account`
--
ALTER TABLE `landlord_account`
  ADD CONSTRAINT `landlord_account_ibfk_1` FOREIGN KEY (`landlordId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `landlord_account_ibfk_2` FOREIGN KEY (`propertyId`) REFERENCES `property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`landlordId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `property_photo`
--
ALTER TABLE `property_photo`
  ADD CONSTRAINT `property_photo_ibfk_1` FOREIGN KEY (`propertyId`) REFERENCES `property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tenancy_agreement`
--
ALTER TABLE `tenancy_agreement`
  ADD CONSTRAINT `tenancy_agreement_ibfk_1` FOREIGN KEY (`propertyId`) REFERENCES `property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tenancy_agreement_ibfk_2` FOREIGN KEY (`landlordId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tenancy_agreement_ibfk_3` FOREIGN KEY (`tenantId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD CONSTRAINT `testimonial_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
