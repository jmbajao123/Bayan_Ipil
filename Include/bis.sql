-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 05:49 AM
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
-- Database: `bis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `username`, `password`, `date`) VALUES
(1, 'ipiladmin', 'qwerty123', '2025-03-17 15:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `b_list`
--

CREATE TABLE `b_list` (
  `b_list_id` int(11) NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `con_pass` varchar(255) NOT NULL,
  `b_code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `b_logo` varchar(255) NOT NULL,
  `a_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_type` varchar(255) NOT NULL DEFAULT 'Barangay Account'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `b_officials`
--

CREATE TABLE `b_officials` (
  `b_officials_id` int(11) NOT NULL,
  `b_list_id` int(11) NOT NULL,
  `b_positions_id` int(11) NOT NULL,
  `start_term` varchar(255) NOT NULL,
  `end_term` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix_name` varchar(255) NOT NULL,
  `date_birth` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `con_pass` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `official_id` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `m_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `r_officials` varchar(255) NOT NULL,
  `r_contact` varchar(255) NOT NULL,
  `r_email` varchar(255) NOT NULL,
  `r_profile` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active Officials',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `a_id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'Official Account'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `b_positions`
--

CREATE TABLE `b_positions` (
  `b_positions_id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `a_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `cert_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `b_list_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `household`
--

CREATE TABLE `household` (
  `h_id` int(11) NOT NULL,
  `ps_list_id` int(11) NOT NULL,
  `h_num` varchar(255) NOT NULL,
  `t_member` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `b_list_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ps_list`
--

CREATE TABLE `ps_list` (
  `ps_list_id` int(11) NOT NULL,
  `ps_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `u_id` int(11) NOT NULL,
  `b_list_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `req_cert`
--

CREATE TABLE `req_cert` (
  `rc_id` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `cert_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `b_list_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residence`
--

CREATE TABLE `residence` (
  `r_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix_name` varchar(255) NOT NULL,
  `date_birth` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `residence_id` varchar(255) NOT NULL,
  `ps_list_id` int(11) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `birthplace` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `con_pass` varchar(255) NOT NULL,
  `u_id` int(11) NOT NULL,
  `b_list_id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'Residence',
  `status` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `u_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `b_list_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `b_officials_id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `b_list`
--
ALTER TABLE `b_list`
  ADD PRIMARY KEY (`b_list_id`);

--
-- Indexes for table `b_officials`
--
ALTER TABLE `b_officials`
  ADD PRIMARY KEY (`b_officials_id`);

--
-- Indexes for table `b_positions`
--
ALTER TABLE `b_positions`
  ADD PRIMARY KEY (`b_positions_id`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`cert_id`);

--
-- Indexes for table `household`
--
ALTER TABLE `household`
  ADD PRIMARY KEY (`h_id`);

--
-- Indexes for table `ps_list`
--
ALTER TABLE `ps_list`
  ADD PRIMARY KEY (`ps_list_id`);

--
-- Indexes for table `req_cert`
--
ALTER TABLE `req_cert`
  ADD PRIMARY KEY (`rc_id`);

--
-- Indexes for table `residence`
--
ALTER TABLE `residence`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `b_list`
--
ALTER TABLE `b_list`
  MODIFY `b_list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `b_officials`
--
ALTER TABLE `b_officials`
  MODIFY `b_officials_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `b_positions`
--
ALTER TABLE `b_positions`
  MODIFY `b_positions_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `cert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `household`
--
ALTER TABLE `household`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ps_list`
--
ALTER TABLE `ps_list`
  MODIFY `ps_list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `req_cert`
--
ALTER TABLE `req_cert`
  MODIFY `rc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `residence`
--
ALTER TABLE `residence`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
