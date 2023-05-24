-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2023 at 01:25 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hiredhand`
--
CREATE DATABASE IF NOT EXISTS `hiredhand` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hiredhand`;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `initiated_by` varchar(50) NOT NULL,
  `project_title` varchar(200) NOT NULL,
  `project_description` longtext NOT NULL,
  `project_category` varchar(50) NOT NULL,
  `project_id` int(11) NOT NULL,
  `community_members` longtext DEFAULT NULL,
  `requested_users` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`initiated_by`, `project_title`, `project_description`, `project_category`, `project_id`, `community_members`, `requested_users`) VALUES
('kujwal147@gmail.com', 'quickfill', 'Proejct to create a project for quickfiling of data and documetns in different platforms', 'Development', 1, NULL, ''),
('kujwal147@gmail.com', 'hiredhand', 'description of hiredhand', 'Development', 2, NULL, ''),
('kujwal147@gmail.com', 'web development', 'designing', 'Development', 3, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `sessionids`
--

CREATE TABLE `sessionids` (
  `sno` int(11) NOT NULL,
  `sessionid` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `projectid` varchar(50) DEFAULT NULL,
  `applied` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessionids`
--

INSERT INTO `sessionids` (`sno`, `sessionid`, `email`, `projectid`, `applied`) VALUES
(21, '$2y$10$z/zkP8i92EgQkpbQDzBV8eArsaS55x6deiHRoXMyRVdmeuSnkgiQi', 'kujwal147@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `full_name` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(500) NOT NULL,
  `verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`full_name`, `phone`, `email`, `pass`, `verified`) VALUES
('UJWAL KUMAR MAHATO', '1212121', 'kujwal147@gmail.com', '123', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `sessionids`
--
ALTER TABLE `sessionids`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sessionids`
--
ALTER TABLE `sessionids`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
