-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 09:09 AM
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
  `b_location` varchar(255) NOT NULL,
  `a_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_type` varchar(255) NOT NULL DEFAULT 'Barangay Account'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `b_list`
--

INSERT INTO `b_list` (`b_list_id`, `barangay_name`, `email`, `password`, `con_pass`, `b_code`, `status`, `b_logo`, `b_location`, `a_id`, `date`, `user_type`) VALUES
(1, 'Ipil Heights', 'ipilheights@email.com', '$2y$10$2vg1/lX23pGqaU.GIqZTJO/72cIpd52kN8lq9Skx9rEymyKXB3T2S', 'qwerty123', '886017', 'Active', '1746186003_6814af1339115.png', 'https://maps.app.goo.gl/uiMiHpEtE9GxGcA68', 1, '2025-05-02 11:40:03', 'Barangay Account'),
(2, 'Lumbia', 'lumbia@email.com', '$2y$10$xzsISCOIAW5b2wvt0WQ9H.ohJ8tFAx47IKtrldkOL53Iuhr8DIxSG', 'qwerty123', '684239', 'Active', '1746186020_6814af24223f8.png', 'https://maps.app.goo.gl/u8LhqTQvxWuCBnmv6', 1, '2025-05-02 11:40:20', 'Barangay Account');

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

--
-- Dumping data for table `b_officials`
--

INSERT INTO `b_officials` (`b_officials_id`, `b_list_id`, `b_positions_id`, `start_term`, `end_term`, `first_name`, `middle_name`, `last_name`, `suffix_name`, `date_birth`, `age`, `gender`, `civil_status`, `contact`, `email`, `password`, `con_pass`, `profile`, `official_id`, `f_name`, `m_name`, `l_name`, `s_name`, `r_officials`, `r_contact`, `r_email`, `r_profile`, `province`, `municipality`, `barangay`, `street`, `status`, `date`, `a_id`, `user_type`) VALUES
(1, 1, 1, '2023-05-12', '2028-05-12', 'Iric', 'M.', 'Alibutdan', 'None', '', '', '', '', '09606657499', 'iricalibutdan@gmail.com', '$2y$10$itt2kD5uelFnbYSua58lwOEizB1CPL73poKlsI50EJBRegE6WWT2S', '', '6814afda56d75.jpg', '869613', '', '', '', '', '', '', '', '', '', '', '', '', 'Active Officials', '2025-05-02 05:43:22', 1, 'Official Account'),
(2, 1, 2, '2023-05-12', '2028-05-12', 'Ian Christopher', 'A.', 'Albrecht', 'None', '', '', '', '', '09460855990', 'Ianchristopher@gmail.com', '$2y$10$DYteK8mVAfli8k2xqYY/B..e7CkrzETsWJSv8QeewojzbJ5640zgC', '', '6814b22402bc9.jpg', '992850', '', '', '', '', '', '', '', '', '', '', '', '', 'Active Officials', '2025-05-02 05:53:07', 1, 'Official Account'),
(3, 1, 3, '2023-05-12', '2028-05-12', 'Avelino', 'A.', 'Agustin', 'None', '', '', '', '', '09606657499', 'avelinoagustin@gmail.com', '$2y$10$m/tJ55b/HQBgqhMkBfPvTO6wUNHB4Zgk9aqfTePXeK7Qj6Bt.hNmu', '', '6814b2c495be2.jpg', '372682', '', '', '', '', '', '', '', '', '', '', '', '', 'Active Officials', '2025-05-02 05:55:48', 1, 'Official Account'),
(4, 1, 4, '2023-05-12', '2028-05-12', 'Charlito', 'A.', 'Aripal', 'None', '', '', '', '', '09070206827', 'charlitoaripal@gmail.com', '$2y$10$gznUPTgi0lblC0kjP2iz8ONHo8wQGuXEFy4KazN8ed17hNm0rDi1K', '', '6814b2f6a7e6a.jpg', '684442', '', '', '', '', '', '', '', '', '', '', '', '', 'Active Officials', '2025-05-02 05:56:38', 1, 'Official Account'),
(5, 1, 5, '2023-05-12', '2028-05-12', 'Raul', 'E.', 'Eguia', 'None', '', '', '', '', '09765436876', 'rauleguia@gmail.com', '$2y$10$K9iQegZFLj4CrEx0fy4OMu4QM793rBdFhGQFkZ4qYeSJ9Klbqphqu', '', '6814b31b6399e.jpg', '338094', '', '', '', '', '', '', '', '', '', '', '', '', 'Active Officials', '2025-05-02 05:57:15', 1, 'Official Account'),
(6, 1, 6, '2023-05-12', '2028-05-12', 'Roderick', 'E.', 'Epanto', 'None', '', '', '', '', '09460855990', 'roderickepanto@gmail.com', '$2y$10$6RLL7lseto3pEfouhOB9Lupscu9eYGAVlmGM/BvMkbs04GpQ0/2ri', '', '6814b34a78a2f.jpg', '329433', '', '', '', '', '', '', '', '', '', '', '', '', 'Active Officials', '2025-05-02 05:58:02', 1, 'Official Account'),
(7, 1, 7, '2023-05-12', '2028-05-12', 'Ariel', 'D.', 'Dapar', 'None', '', '', '', '', '09460855990', 'arieldapar@gmail.com', '$2y$10$b45Lg4gVkXR7tBLI/P1sD.KFwWRGmzOvF7hsZ5ewSbdvV2CmHdZS2', '', '6814b3749dbba.jpg', '273271', '', '', '', '', '', '', '', '', '', '', '', '', 'Active Officials', '2025-05-02 05:58:44', 1, 'Official Account'),
(8, 1, 8, '2023-05-12', '2028-05-12', 'Junmel', 'S.', 'Solis', 'None', '', '', '', '', '09606657499', 'junmelsolis@gmail.com', '$2y$10$W/y5.yW29QqG4TqBth2DBOYVy6RYyxgxVGYFzYuvEIxkJhhXU0wi2', '', '6814b9015b7f6.jpg', '236563', '', '', '', '', '', '', '', '', '', '', '', '', 'Active Officials', '2025-05-02 06:22:25', 1, 'Official Account'),
(9, 1, 9, '2023-05-12', '2028-05-12', 'Inolita', 'F.', 'Flores', 'None', '', '', '', '', '09460855990', 'inolitaflores@gmail.com', '$2y$10$OVqhLb4DETcxyqtat.66C.zG9fd4uBPdXMrf1cYmRDjJr0TnKoyzW', '', '6814b92267989.jpg', '865148', '', '', '', '', '', '', '', '', '', '', '', '', 'Active Officials', '2025-05-02 06:22:58', 1, 'Official Account');

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

--
-- Dumping data for table `b_positions`
--

INSERT INTO `b_positions` (`b_positions_id`, `position_name`, `status`, `a_id`, `date`) VALUES
(1, 'Punong Barangay', 'Available', 1, '2025-04-29 03:28:34'),
(2, 'Barangay Kagawad (Ordinance)', 'Available', 1, '2025-05-02 11:51:09'),
(3, 'Barangay Kagawad (Public Safety)', 'Available', 1, '2025-05-02 11:51:21'),
(4, 'Barangay Kagawad (Tourism)', 'Available', 1, '2025-05-02 11:51:28'),
(5, 'Barangay Kagawad (Budget & Finance)', 'Available', 1, '2025-05-02 11:51:35'),
(6, 'Barangay Kagawad (Agriculture)', 'Available', 1, '2025-05-02 11:51:44'),
(7, 'Barangay Kagawad (Education)', 'Available', 1, '2025-05-02 11:51:55'),
(8, 'Barangay Secretary', 'Available', 1, '2025-05-02 12:21:41'),
(9, 'Barangay Treasurer', 'Available', 1, '2025-05-02 12:21:49');

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

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`cert_id`, `c_name`, `b_list_id`, `u_id`, `status`, `date`) VALUES
(1, 'Barangay of Clearance', 1, 1, 'Available', '2025-05-15 03:11:43'),
(2, 'Certificate of Indigency', 1, 1, 'Available', '2025-04-13 16:00:00'),
(3, 'Business Permit', 1, 1, 'Available', '2025-04-13 16:00:00');

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

--
-- Dumping data for table `household`
--

INSERT INTO `household` (`h_id`, `ps_list_id`, `h_num`, `t_member`, `status`, `date`, `b_list_id`, `u_id`, `r_id`) VALUES
(1, 1, '555423', '5', 'Active Household', '2025-04-29 03:23:56', 1, 1, 1);

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

--
-- Dumping data for table `ps_list`
--

INSERT INTO `ps_list` (`ps_list_id`, `ps_name`, `status`, `u_id`, `b_list_id`, `date`) VALUES
(1, 'Purok 1', 'Active', 1, 1, '2025-04-28 16:00:00'),
(2, 'Purok 2', 'Active', 1, 1, '2025-04-28 16:00:00'),
(3, 'Purok 3', 'Active', 1, 1, '2025-04-28 16:00:00'),
(4, 'Purok 4', 'Active', 1, 1, '2025-04-28 16:00:00');

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

--
-- Dumping data for table `req_cert`
--

INSERT INTO `req_cert` (`rc_id`, `purpose`, `cert_id`, `u_id`, `b_list_id`, `r_id`, `status`, `date`) VALUES
(1, 'Applying for a Job', 1, 49, 1, 1, 'Approved', '2025-05-15 03:12:47'),
(2, 'School', 2, 69, 1, 2, 'Approved', '2025-05-16 07:05:51'),
(3, 'Grocery Store', 3, 71, 1, 4, 'Approved', '2025-05-29 07:24:36');

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

--
-- Dumping data for table `residence`
--

INSERT INTO `residence` (`r_id`, `first_name`, `middle_name`, `last_name`, `suffix_name`, `date_birth`, `age`, `gender`, `civil_status`, `contact`, `profile`, `residence_id`, `ps_list_id`, `nationality`, `birthplace`, `email`, `password`, `con_pass`, `u_id`, `b_list_id`, `user_type`, `status`, `date`) VALUES
(1, 'Roderick', 'Timtim', 'Alingco', 'None', '2001-06-13', '23', 'Male', 'Single', '0946', 'eb9fcd4b-d478-4d9a-a44d-c6ee09c35957.jpg', '766276', 1, 'Filipino', 'Zamboanga Sibugay Ipil', 'roderickalingco@gmail.com', '$2y$10$H5jlsMKMemL2/TzHU4RG8.LWg7ne/pgG772a7Kh.7xYStF7mlIJt2', 'qwerty123', 1, 1, 'Residence Account', 'Active Residence', '2025-04-29 03:23:40'),
(2, 'Jherick', 'Santos ', 'Esmeralda', 'None', '1996-02-13', '29', 'Male', 'Single', '09460855990', 'a2fcb723-1d4c-4276-9ea4-a421af181d8d.jpg', '663003', 2, 'Filipino', 'Ipil, Zamboanga Sibugay', 'jherickesmeralda@gmail.com', '$2y$10$pc.UC1NmMUhXzKXev0CGo.QZ7.AagQ5.BIIjX6eqcgnj.J31w94n.', 'qwerty123', 1, 1, 'Residence Account', 'Active Residence', '2025-05-16 07:04:51'),
(4, 'Jennifer', 'Rivero', 'Santos', 'None', '2001-05-13', '24', 'Female', 'Single', '09460855990', '1ebd9369-3f98-45ec-b807-b76e3910f49d.jpg', '308961', 1, 'Filipino', 'Ipil', 'jennifersantos123@gmail.com', '$2y$10$yJy.CUPHSMLMnPUc1wWO8eRU3SgiFvQErHsGcHXGqStLJpf/4zPJO', 'qwerty123', 1, 1, 'Residence Account', 'Active Residence', '2025-05-29 07:23:23');

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
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`u_id`, `email`, `password`, `b_list_id`, `r_id`, `b_officials_id`, `user_type`, `status`, `date`) VALUES
(1, 'ipilheights@email.com', '$2y$10$axeY1UqXhhYvx3d71YL61.x0U.YQxjxVgYB1DbVFh9UCWkjEPEgyq', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-13 16:00:00'),
(2, 'bacalan@email.com', '$2y$10$LAG3pH92BO9zcR71l/M7COIGceOEIrcQS2HBzlCmGG/fR61u4Yoo6', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(3, 'bangkerohan@email.com', '$2y$10$xdSLEEO4MipU2D9CEUpxhu48wF0Ad3sG7vGnGsCQQ7guS.0410gh6', 2, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(4, 'bulu-an@email.com', '$2y$10$QUAv83A69c7jvKsSd5qC2O656uqggemX9AkPKfQUE.8WYf8dtbH4q', 3, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(5, 'bulu-an@email.com', '$2y$10$x4OsvaU19VyrXAj7WTXLwuYDLC31m5EhggOmA5u0StM4njZoyshEm', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(6, 'bulu-an@email.com', '$2y$10$CA7m8ypWb5JdzJzUjX3oJ.SBbhrgNBWsAEoPAVMxsy5Yi.vln/UtG', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(7, 'caparan@email.com', '$2y$10$jKAzCfzfT69lugas.720U.azf4VDsk0Q04kCh2e23VqJ6NwDcV4.a', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(8, 'domandan@email.com', '$2y$10$RxqCikOQK3YZr9V/JWfX1.nPNOirdnqVANF1X4kvEzTxP8xXdre2i', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(9, 'donandres@email.com', '$2y$10$8pLE1L1iIgbzlxTMm2P2uers0QNkGg88mhZhYoTZ6BaqFiApty4Mi', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(10, 'ipilheights@email.com', '$2y$10$H7eHAR3ULuZTx2KX9WQAvOF3EhS.ITm6Z4R6vQO1KrXYqVrkvjRnK', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(11, 'lumbia@email.com', '$2y$10$5zLoVo99Mnkjm37opLO38O6ckwQXNqw8vj1WCKcG.geN9Q2JEIDpK', 2, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(12, 'veteransvillage@email.com', '$2y$10$2YJx1jMhimOF2hiT2S8HrOpR6CctSKEIXGpYiZ.LX1yjL2jUIPAiq', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(13, 'bacalan@email.com', '$2y$10$q9g7lZx2c3EZC4oQ25aClecY4vb2v7zyjpmh51oRz/g0UIhUvf/Cm', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(14, 'ipilheights@email.com', '$2y$10$mjhoSJ/ZPDR9VvYTHgXTiuBgGoHEDLUnvPIvBw6Y3pHvoxvdvbah6', 2, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(15, 'lumbia@email.com', '$2y$10$jr3tQToldZy/OU6q283U9ebyA2vofbhPrsfosppEHGsnmAxjdRaMe', 3, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(16, 'veteransvillage@email.com', '$2y$10$cx15VlEW6XTr.Hb0r/8YpugA0p6Wq2Z82LY8MMaWBeqZiBXSE.5j6', 4, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(17, 'ipilheights@email.com', '$2y$10$BbgNToJceqCZ/uUcLbhF5OvCzPPgOzhQ7lSVdofzCFYcQ8H0boFxK', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(18, 'veteransvillage@email.com', '$2y$10$dxq1XSdPe8TyhQ.03xPBwO6wz/u5G3cuLt/WvuivXQvLa/bDH0b6C', 2, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(19, 'bacalan@email.com', '$2y$10$/TiGrvwi9cZ8W7JBIVoUbuxBtDVGL/LNckmJhyN/Dgt5JuzSLdrDe', 3, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(20, 'lumbia@email.com', '$2y$10$AdFp20PzDjN/i7vMacjoW.2BMiMYJD/NdfCeGU/RQvYP2lL9enoC.', 4, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(21, 'iricalibutdan@gmail.com', '$2y$10$lk67vXLWsJ3cThEDmUAbjeZJUwSsSMaqB1aEBtuOFOiQeQmD4DkES', 1, 0, 1, 'Official Account', 'Active', '2025-04-15 05:02:17'),
(22, 'ipilheights@email.com', '$2y$10$U.APlXMJfwt1mYF7cBwnIulqkivBw9TV/0hba52HyOFUaxlVLxKiu', 1, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(23, 'lumbia@email.com', '$2y$10$84NVnGH7iV49i2PxQR.wyOTuyR6N2zB47R1BLdlkzqPn/me.OcGLS', 2, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(24, 'veteransvillage@email.com', '$2y$10$DPG/jo.XEz4pDmDx8KuMGusqVdaACxZQzDtWslNHCLOX5ZlQywfqa', 3, 0, 0, 'Barangay Account', 'Active', '2025-04-14 16:00:00'),
(25, 'iricalibutdan@gmail.com', '$2y$10$lmjiXYBLHSX/PRlpWQZdBO0MGaqeOFJSNjbtVwrgxwq/6fURGN03e', 1, 0, 1, 'Official Account', 'Active', '2025-04-16 02:00:05'),
(26, 'Ianchristopher@gmail.com', '$2y$10$Msvha1VwEloiYFlCW3lb.etUMS0C4AF7jIPbGW/tsC7Fqfh1V2D/y', 1, 0, 2, 'Official Account', 'Active', '2025-04-16 02:01:36'),
(27, 'avelinoagustin@gmail.com', '$2y$10$hMXs1gDInUnDxDnWnnEZYOeJwpfvekWCO8an7g7GFUFwDckvXIrfa', 1, 0, 3, 'Official Account', 'Active', '2025-04-16 02:02:40'),
(28, 'charlitoaripal@gmail.com', '$2y$10$DeUhxIqQ4kQhV1g9EORd9e8aMj0KmF3Q2ijBX1D0jIocIfevjPtty', 1, 0, 4, 'Official Account', 'Active', '2025-04-16 02:03:33'),
(29, 'rauleguia@gmail.com', '$2y$10$uvXvJfF0Rk1Nk2gXipz4huqrhXce5eg62SVrKgu66JUSD24tG8EbC', 1, 0, 5, 'Official Account', 'Active', '2025-04-16 02:04:36'),
(30, 'iricalibutdan@gmail.com', '$2y$10$ngHRS5hz/zqziIiVVoTOVuK6BhAiNDCerKkrMbK9xu7L1GWO4SmAm', 1, 0, 1, 'Official Account', 'Active', '2025-04-16 02:07:21'),
(31, 'Ianchristopher@gmail.com', '$2y$10$uFpFhGvRYHWHTtKFw99mb.rVmOzT5sHq7qZOIs8KVYdd6o88iqXJW', 1, 0, 2, 'Official Account', 'Active', '2025-04-16 02:08:14'),
(32, 'avelinoagustin@gmail.com', '$2y$10$4rLYC0NsCI2.RlW3GqsaQOT.bPnDRu/5bkShfc1WFzpu0CHcRuUNC', 1, 0, 3, 'Official Account', 'Active', '2025-04-16 02:08:58'),
(33, 'charlitoaripal@gmail.com', '$2y$10$vaDMjL95hnWLKELomwv36u5xHAeGQzH86hkIpOsU/GXOb/8xXWTru', 1, 0, 4, 'Official Account', 'Active', '2025-04-16 02:10:43'),
(34, 'rauleguia@gmail.com', '$2y$10$aa1jFgJG9vIxlThhF/ejJ.s5zWcf21lXrJoX.u0CAfbhApGa3.Zqq', 1, 0, 5, 'Official Account', 'Active', '2025-04-16 02:14:05'),
(35, 'roderickepanto@gmail.com', '$2y$10$NOoB0wQRjnIodyfeDvNaVOLh15hTRjhb6kVZ/GCdTBwScOBDgFOT6', 1, 0, 6, 'Official Account', 'Active', '2025-04-16 02:15:21'),
(36, 'arieldapar@gmail.com', '$2y$10$01qapRyYPR3XEWmXya75LePovIjxsL7tKoe3BmLTcAELhlAoU9h8a', 1, 0, 7, 'Official Account', 'Active', '2025-04-16 02:16:04'),
(37, 'lilibethcanillo@gmail.com', '$2y$10$jPLm1mtay/j8ZnIOmLOwlu.FlWByg2INhlpGmA1Z98fHufHwKIJ6i', 1, 0, 8, 'Official Account', 'Active', '2025-04-16 02:17:28'),
(38, 'markkylesumalpong@gmail.com', '$2y$10$rX8bbQUaykZG22/hIvnF9ewQ/uNBgqJDmVQVQYBjtdrRiDQNAJ34G', 1, 0, 9, 'Official Account', 'Active', '2025-04-16 02:19:27'),
(39, 'junmelsolis@gmail.com', '$2y$10$cud/0sbledma9rHa13E4EuXrK14Yz0RRRgZmHcJVk5QVNXnGKxC22', 1, 0, 10, 'Official Account', 'Active', '2025-04-16 02:20:24'),
(40, 'inolitaflores@gmail.com', '$2y$10$uUAGCZqaBFpWhbkd8WABmeyuj/q2Equ6oBNnI2P7Qrzxbep1B/6ky', 1, 0, 11, 'Official Account', 'Active', '2025-04-16 02:21:17'),
(41, 'marianodemorca@gmail.com', '$2y$10$KJshrIHZoSh7ztai.oMZHuS6K9RwubLo5XCNMmgS4fkZ3o3vVBqnq', 2, 0, 12, 'Official Account', 'Active', '2025-04-16 02:23:41'),
(42, 'rickycabalida@gmail.com', '$2y$10$yDeZliRBtk/259iitQnP0.P9.f4KOYwxw5lDHcRH/d7FCJtDEoNf6', 2, 0, 13, 'Official Account', 'Active', '2025-04-16 02:24:56'),
(43, 'peroniovidal@gmail.com', '$2y$10$oL.hDpU1tDG/m4kS.yyvy.qlbsg1qe2Rt28eRsVJRDnayGiNL.fH6', 2, 0, 14, 'Official Account', 'Active', '2025-04-16 02:26:11'),
(44, 'larryboygabihan@gmai.com', '$2y$10$VvOxr8ie5TV15Mj2q3xcVedypdFeLPZBKAh43ofyRE06/jZ6lvGJe', 2, 0, 15, 'Official Account', 'Active', '2025-04-16 02:27:06'),
(45, 'sherryanndaligdig@gmail.com', '$2y$10$m.C9Mqv3kEB5ankkVJqm3.7/KHErO3xCmjzczlhsvjy/og5oPNelm', 2, 0, 16, 'Official Account', 'Active', '2025-04-16 02:29:13'),
(46, 'oscarugdamina@gmail.com', '$2y$10$p0kyJZHa9NATQEMGOhdZu.ZeZXlUnjldOQim6A.S44zPGj31Y3l5G', 2, 0, 17, 'Official Account', 'Active', '2025-04-16 02:30:01'),
(47, 'edgardelapeña@gmail.com', '$2y$10$PHfD2QY8adyKYxi0j1kLferKQFgtSjz6Fboy1MT8sRg3GL3IpugK.', 2, 0, 18, 'Official Account', 'Active', '2025-04-16 02:30:58'),
(48, 'hezzelberdaligdig', '$2y$10$L4mJevFszowu3EWRmPxQf.aAj2HX8MsF8bsUfAaUuCC0HsI7EaX4u', 2, 0, 19, 'Official Account', 'Active', '2025-04-16 02:32:26'),
(49, 'roderickalingco@gmail.com', '$2y$10$H5jlsMKMemL2/TzHU4RG8.LWg7ne/pgG772a7Kh.7xYStF7mlIJt2', 1, 1, 0, 'Residence Account', 'Active', '2025-04-29 03:23:40'),
(50, 'gerempantenio@gmail.com', '$2y$10$LnkGkOnrB7mjfiCWBS4G3umgzusRbdAccXMNdp4.CCXpx/x5m9CYK', 3, 0, 1, 'Official Account', 'Active', '2025-04-29 03:32:27'),
(51, 'veteransvillage@email.com', '$2y$10$BTZQqr4KKfohN3Bof0zNz./y5vXqSfWv7oGg/UpcbGvE3cf7jAjZa', 4, 0, 0, 'Barangay Account', 'Active', '2025-05-01 16:00:00'),
(52, 'ipilheights@email.com', '$2y$10$LuH/gaHswAqhB4XJejWSn.yOMcLNf3GwGk5CLUFnF45qgJVv2d4H.', 1, 0, 0, 'Barangay Account', 'Active', '2025-05-01 16:00:00'),
(53, 'veteransvillage@email.com', '$2y$10$fXDbptzOcQePg/G/vIG4YOVFUrUbPYTHQwIdpCUJOmXGzqQfiFrbm', 2, 0, 0, 'Barangay Account', 'Active', '2025-05-01 16:00:00'),
(54, 'veteransvillage@email.com', '$2y$10$ya6.quyA.wlg8R5KhU6QeOOCYULCl4YkolAXz4IaBQHEQDxvS/m9e', 1, 0, 0, 'Barangay Account', 'Active', '2025-05-01 16:00:00'),
(55, 'ipilheights@email.com', '$2y$10$GzJuw1zfV.sB6BA5z3uDa.m9aO3d/gsdobTraO0D.x9Zz8OkuP8RK', 2, 0, 0, 'Barangay Account', 'Active', '2025-05-01 16:00:00'),
(56, 'ipilheights@email.com', '$2y$10$fsV9vPzRTjgSLTzneEMd1uaiXMCNVkuBypkyrIpjw2bTDN8a7e4eW', 1, 0, 0, 'Barangay Account', 'Active', '2025-05-01 16:00:00'),
(57, 'veteransvillage@email.com', '$2y$10$/pkyQY6Oq/aM2wKf4gN6J.qWBlE0OcwWA5T4Z8CpHIJfBh4qCClfu', 2, 0, 0, 'Barangay Account', 'Active', '2025-05-01 16:00:00'),
(58, 'ipilheights@email.com', '$2y$10$2vg1/lX23pGqaU.GIqZTJO/72cIpd52kN8lq9Skx9rEymyKXB3T2S', 1, 0, 0, 'Barangay Account', 'Active', '2025-05-01 16:00:00'),
(59, 'lumbia@email.com', '$2y$10$xzsISCOIAW5b2wvt0WQ9H.ohJ8tFAx47IKtrldkOL53Iuhr8DIxSG', 2, 0, 0, 'Barangay Account', 'Active', '2025-05-01 16:00:00'),
(60, 'iricalibutdan@gmail.com', '$2y$10$itt2kD5uelFnbYSua58lwOEizB1CPL73poKlsI50EJBRegE6WWT2S', 1, 0, 1, 'Official Account', 'Active', '2025-05-02 11:43:22'),
(61, 'Ianchristopher@gmail.com', '$2y$10$DYteK8mVAfli8k2xqYY/B..e7CkrzETsWJSv8QeewojzbJ5640zgC', 1, 0, 2, 'Official Account', 'Active', '2025-05-02 11:53:08'),
(62, 'avelinoagustin@gmail.com', '$2y$10$m/tJ55b/HQBgqhMkBfPvTO6wUNHB4Zgk9aqfTePXeK7Qj6Bt.hNmu', 1, 0, 3, 'Official Account', 'Active', '2025-05-02 11:55:48'),
(63, 'charlitoaripal@gmail.com', '$2y$10$gznUPTgi0lblC0kjP2iz8ONHo8wQGuXEFy4KazN8ed17hNm0rDi1K', 1, 0, 4, 'Official Account', 'Active', '2025-05-02 11:56:38'),
(64, 'rauleguia@gmail.com', '$2y$10$K9iQegZFLj4CrEx0fy4OMu4QM793rBdFhGQFkZ4qYeSJ9Klbqphqu', 1, 0, 5, 'Official Account', 'Active', '2025-05-02 11:57:15'),
(65, 'roderickepanto@gmail.com', '$2y$10$6RLL7lseto3pEfouhOB9Lupscu9eYGAVlmGM/BvMkbs04GpQ0/2ri', 1, 0, 6, 'Official Account', 'Active', '2025-05-02 11:58:02'),
(66, 'arieldapar@gmail.com', '$2y$10$b45Lg4gVkXR7tBLI/P1sD.KFwWRGmzOvF7hsZ5ewSbdvV2CmHdZS2', 1, 0, 7, 'Official Account', 'Active', '2025-05-02 11:58:44'),
(67, 'junmelsolis@gmail.com', '$2y$10$W/y5.yW29QqG4TqBth2DBOYVy6RYyxgxVGYFzYuvEIxkJhhXU0wi2', 1, 0, 8, 'Official Account', 'Active', '2025-05-02 12:22:25'),
(68, 'inolitaflores@gmail.com', '$2y$10$OVqhLb4DETcxyqtat.66C.zG9fd4uBPdXMrf1cYmRDjJr0TnKoyzW', 1, 0, 9, 'Official Account', 'Active', '2025-05-02 12:22:58'),
(69, 'jherickesmeralda@gmail.com', '$2y$10$pc.UC1NmMUhXzKXev0CGo.QZ7.AagQ5.BIIjX6eqcgnj.J31w94n.', 1, 2, 0, 'Residence Account', 'Active', '2025-05-16 07:04:51'),
(71, 'jennifersantos123@gmail.com', '$2y$10$yJy.CUPHSMLMnPUc1wWO8eRU3SgiFvQErHsGcHXGqStLJpf/4zPJO', 1, 4, 0, 'Residence Account', 'Active', '2025-05-29 07:23:23');

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
  MODIFY `b_list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `b_officials`
--
ALTER TABLE `b_officials`
  MODIFY `b_officials_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `b_positions`
--
ALTER TABLE `b_positions`
  MODIFY `b_positions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `cert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `household`
--
ALTER TABLE `household`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ps_list`
--
ALTER TABLE `ps_list`
  MODIFY `ps_list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `req_cert`
--
ALTER TABLE `req_cert`
  MODIFY `rc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `residence`
--
ALTER TABLE `residence`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
