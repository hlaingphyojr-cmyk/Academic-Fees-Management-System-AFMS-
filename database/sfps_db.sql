-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2020 at 08:05 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfps_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `course` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `total_amount` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`, `description`,`total_amount`, `date_created`) VALUES
(1, 'Second Year', 'Academic Year(2023-2024)', 109000, '2024-02-12 11:01:15'),
(2, 'Third Year', 'Academic Year(2023-2024)', 115000, '2024-02-12 11:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `course_id`, `description`, `amount`) VALUES
(1, 1, 'Entrance Fees', 2000),
(2, 1, 'Academic Fees', 50000),
(3, 1, 'Hostel Fees', 50000),
(4, 1, 'Exam Fees', 3000),
(5, 1, 'Laboratary Fees', 3000),
(6, 1, 'Ka-Ma-Pa Fees', 1000),
(7, 2, 'Total Fees', 100000),
(8, 2, 'Extra Fees', 15000);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(30) NOT NULL,
  `ef_id` int(30) NOT NULL,
  `amount` float NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

-- INSERT INTO `payments` (`id`, `ef_id`, `amount`, `remarks`, `date_created`) VALUES
-- (1, 1, 109000, 'Completed!', '2024-02-12 14:25:00'),
-- (2, 2, 109000, 'Completed!', '2024-02-12 14:26:15'),
-- (3, 3, 109000, 'Completed!', '2024-02-12 14:27:39'),
-- (4, 4, 109000, 'Completed!', '2024-02-12 14:28:56');

-- --------------------------------------------------------

-- Transaction table 'transactions'

CREATE TABLE `transactions` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `amount` float DEFAULT 300000.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
INSERT INTO `transactions` (`id`, `student_id`) VALUES
(1,1),
(2,2),
(3,3),
(4,4),
(5,5),
(6,6);

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(30) NOT NULL,
  `id_no` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `id_no`, `name`, `contact`, `address`, `email`,`username`,`password`, `date_created`) VALUES
(1, 'mkpt-6982', 'Mg Kaung Htet Zaw', '+959794902239', 'Pyin Oo Lwin, Mandalay Region', 'kaunghtetzaw@ucsm.edu.mm','mkpt-6982','Kaunghz123!', '2024-02-12 11:24:11'),
(2, 'mkpt-6974', 'Mg Hlaing Phyo', '+959792837463', 'Taung Thar, Mandalay Region', 'hlaingphyo@ucsm.edu.mm','mkpt-6974','Hlaingphyojr123@', '2024-02-12 11:25:42'),
(3, 'mkpt-6993', 'Ma Khin Moe Ei San', '+959688009080', 'Mandalay, Mandalay Region', 'khinmoeeisan@ucsm.edu.mm','mkpt-6993','Khinmoe709#', '2024-02-10 11:26:00'),
(4, 'mkpt-6994', 'Ma Kyal Sin Shoon', '+959688988300', 'Mandalay, Mandalay Region', 'kyalsinshoon@ucsm.edu.mm','mkpt-6994','Kyalsinshoon777$', '2024-02-10 11:27:02'),
(5, 'mkpt-0001', 'Mg Mg', '+959987654321', 'Mandalay, Mandalay Region', 'mgmg@ucsm.edu.mm','mkpt-0001','mgmgfirst!@11A', '2024-02-10 11:29:02'),
(6, 'mkpt-0002', 'Mg Kaung', '+959987654321', 'Mandalay, Mandalay Region', 'mgkaung@ucsm.edu.mm','mkpt-0002','Mgkaung123!', '2024-02-10 11:39:02');

-- --------------------------------------------------------

--
-- Table structure for table `student_ef_list`
--

CREATE TABLE `student_ef_list` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `ef_no` varchar(200) NOT NULL,
  `course_id` int(30) NOT NULL,
  `total_fee` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_ef_list`
--

 INSERT INTO `student_ef_list` (`id`, `student_id`, `ef_no`, `course_id`, `total_fee`, `date_created`) VALUES
  (1, 1, 'mkpt-6982', 1, 109000, '2024-02-12 12:04:18'),
  (2, 2, 'mkpt-6974', 1, 109000, '2024-02-12 12:05:13'),
  (3, 3, 'mkpt-6993', 1, 109000, '2024-02-12 13:07:00'),
  (4, 4, 'mkpt-6994', 1, 109000, '2024-02-12 13:09:03'),
  (5, 5, 'mkpt-0001', 2, 115000, '2024-02-12 14:09:13'),
  (6, 6, 'mkpt-0002', 2, 115000, '2024-02-12 14:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

 INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
 (1, 'School Fees Payment System', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'kaunghz', 'Project_AFMS_Admin', 'd46c356796f889173d78ebbb57a1d4f7', 1),
(2, 'staff', 'Project_AFMS_Staff', 'de9bf5643eabf80f4a56fda3bbb84483', 2),
(3, 'secondstaff', 'Project_AFMS_Staff', 'f7a841964721c3bef72896d4591d405c', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_ef_list`
--
ALTER TABLE `student_ef_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
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
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `transactions`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_ef_list`
--
ALTER TABLE `student_ef_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
