-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2021 at 12:38 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idcard_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `front_file` varchar(200) NOT NULL,
  `back_file` varchar(200) NOT NULL,
  `width` varchar(10) NOT NULL,
  `height` varchar(10) NOT NULL,
  `fields_styles` text NOT NULL,
  `data_table` varchar(100) NOT NULL,
  `show_field_label` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `name`, `company_id`, `front_file`, `back_file`, `width`, `height`, `fields_styles`, `data_table`, `show_field_label`) VALUES
(26, 'card 1', 10, 'card_img/605f13f96b27a_id-card-template-corporate-id-1-e1526258858905.jpg', '', '', '', '', '', 0),
(27, 'card 2', 10, 'card_img/605f145cbc085_id-card-template-corporate-id-1-e1526258858905.jpg', 'card_img/605f145cbc219_id-card-template-corporate-id-1-e1526258858905 - Copy.jpg', '297px', '192px', '[{\"id\":\"17\",\"imageFlag\":\"0\",\"reservedFlag\":\"1\",\"fieldName\":\"name\",\"fontSize\":\"11px\",\"fontColor\":\"#000000\",\"width\":\"80%\",\"textAlign\":\"left\",\"left\":\"42%\",\"top\":\"21%\",\"imageWidth\":\"20mm\",\"imageHeight\":\"30mm\"},{\"id\":\"22\",\"imageFlag\":\"0\",\"reservedFlag\":\"1\",\"fieldName\":\"mobile\",\"fontSize\":\"7px\",\"fontColor\":\"#000000\",\"width\":\"20%\",\"textAlign\":\"left\",\"left\":\"43%\",\"top\":\"28%\",\"imageWidth\":\"20mm\",\"imageHeight\":\"30mm\"},{\"id\":\"27\",\"imageFlag\":\"0\",\"reservedFlag\":\"1\",\"fieldName\":\"emp_id\",\"fontSize\":\"7px\",\"fontColor\":\"#000000\",\"width\":\"20%\",\"textAlign\":\"left\",\"left\":\"43%\",\"top\":\"34%\",\"imageWidth\":\"20mm\",\"imageHeight\":\"30mm\"},{\"id\":\"32\",\"imageFlag\":\"0\",\"reservedFlag\":\"1\",\"fieldName\":\"date_of_birth\",\"fontSize\":\"7px\",\"fontColor\":\"#000000\",\"width\":\"20%\",\"textAlign\":\"left\",\"left\":\"43%\",\"top\":\"39.7%\",\"imageWidth\":\"20mm\",\"imageHeight\":\"30mm\"},{\"id\":\"34\",\"imageFlag\":\"0\",\"reservedFlag\":\"1\",\"fieldName\":\"date_of_expiry\",\"fontSize\":\"7px\",\"fontColor\":\"#000000\",\"width\":\"20%\",\"textAlign\":\"left\",\"left\":\"82%\",\"top\":\"37.5%\",\"imageWidth\":\"20mm\",\"imageHeight\":\"30mm\"}]', 'data_my_company', 0);

-- --------------------------------------------------------

--
-- Table structure for table `card_status`
--

CREATE TABLE `card_status` (
  `status_id` bigint(20) NOT NULL,
  `printed` tinyint(4) NOT NULL DEFAULT 0,
  `emp_data_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `qr_generated` tinyint(4) NOT NULL DEFAULT 0,
  `approved` tinyint(4) NOT NULL DEFAULT 0,
  `printed_date` varchar(20) DEFAULT NULL,
  `reason_for_duplicate` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `card_status`
--

INSERT INTO `card_status` (`status_id`, `printed`, `emp_data_id`, `company_id`, `qr_generated`, `approved`, `printed_date`, `reason_for_duplicate`) VALUES
(441, 0, 1, 10, 0, 0, '27-3-2021 17:5:39', '');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `data_table` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `data_table`) VALUES
(4, 'super_admin', 'super_admin'),
(10, 'My Company', 'data_my_company');

-- --------------------------------------------------------

--
-- Table structure for table `data_my_company`
--

CREATE TABLE `data_my_company` (
  `id` bigint(20) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `date_of_birth` varchar(20) DEFAULT NULL,
  `emp_id` bigint(20) DEFAULT NULL,
  `date_of_expiry` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_my_company`
--

INSERT INTO `data_my_company` (`id`, `name`, `mobile`, `date_of_birth`, `emp_id`, `date_of_expiry`) VALUES
(1, 'Arijit Dey', '1231231231', '1997-12-22', 43, '2022-04-22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `password`, `contact`, `created_by`, `company_id`) VALUES
(1, 'super_admin', 'super_admin', 'c98703aed69284552ffffea25a1706d9', '1231231231', 1, 4),
(9, 'admin', 'admin', '1b2de2499e5f93e00a5a90e79a9da4b1', '1231231231', 1, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card_status`
--
ALTER TABLE `card_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_my_company`
--
ALTER TABLE `data_my_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `card_status`
--
ALTER TABLE `card_status`
  MODIFY `status_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=442;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_my_company`
--
ALTER TABLE `data_my_company`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
