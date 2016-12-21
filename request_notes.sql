-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2016 at 01:55 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maintenance_request`
--

-- --------------------------------------------------------

--
-- Table structure for table `request_notes`
--

CREATE TABLE `request_notes` (
  `requestID` int(11) NOT NULL,
  `dt` date NOT NULL,
  `tenant` varchar(60) NOT NULL,
  `apartmentNumber` int(3) NOT NULL,
  `maintenanceDay` tinyint(1) NOT NULL,
  `immediately` tinyint(1) NOT NULL,
  `whenever` tinyint(1) NOT NULL,
  `permission` tinyint(1) NOT NULL,
  `timeOfDay` varchar(60) NOT NULL,
  `phoneContact` tinyint(1) NOT NULL,
  `textContact` tinyint(1) NOT NULL,
  `phoneNumber` char(9) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `request_notes`
--
ALTER TABLE `request_notes`
  ADD PRIMARY KEY (`requestID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `request_notes`
--
ALTER TABLE `request_notes`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
