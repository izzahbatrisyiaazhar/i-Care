-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2023 at 08:40 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `i-care_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` text DEFAULT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `firstname`, `lastname`, `email`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Fakhrul', 'Azri', 'fakhrul@admin.com', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-1.png?v=1644472635', NULL, 1, '2021-01-20 14:02:37', '2023-01-11 12:16:41');

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `admin_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `admin_id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 1, 'Power bank', 'A portable charger designed to recharge electrnic devices when someone is on the move.', 1, 0, '2022-02-09 11:09:36', NULL),
(2, 1, 'Blankets and Comforters', 'To be used as sleeping pads for victims at the evacuation centre.', 1, 0, '2022-02-09 11:09:45', '2023-03-29 18:58:03'),
(3, 1, 'Diapers', 'To be used by babies aged 0 to 3 years old.', 1, 0, '2022-02-09 11:10:19', NULL),
(4, 1, 'Other', 'Other category than listed', 1, 0, '2023-05-23 02:01:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donated_goods`
--

CREATE TABLE `donated_goods` (
  `id` int(30) NOT NULL,
  `donation_id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `image_path` text NOT NULL,
  `quantity` int(255) NOT NULL,
  `description` text NOT NULL,
  `goods_condition` tinyint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donated_goods`
--

INSERT INTO `donated_goods` (`id`, `donation_id`, `category_id`, `name`, `image_path`, `quantity`, `description`, `goods_condition`) VALUES
(1, 1, 1, 'Mini Power Bank', 'uploads/program/1.png?v=1679602434', 10, ' Battery Power: 35.2Wh/36Wh 9800mAh / 10000mAh\r\n\r\n- Charging Time: 2.7 hours\r\n\r\n- Input Port: 1 x USB Type-C\r\n\r\n- Output Port: 1 x USB Type-C and 1 x USB Type-A', 1),
(2, 1, 2, 'Big blanket', '', 30, 'length: 140 cm', 0),
(3, 1, 1, 'Big Powerbank ', '', 50, '35 g', 0),
(4, 1, 3, 'Huggies', '', 10, 'size L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `id` int(30) NOT NULL,
  `program_id` int(30) NOT NULL,
  `donor_id` int(30) NOT NULL,
  `date_donated` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `total_goods` int(200) NOT NULL,
  `code` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`id`, `program_id`, `donor_id`, `date_donated`, `date_updated`, `total_goods`, `code`, `status`) VALUES
(1, 1, 4, '2023-03-28 00:49:16', '2023-04-03 02:55:47', 10, '', 1),
(2, 1, 3, '2023-03-28 02:37:42', '2023-03-27 20:37:21', 20, '', 0),
(9, 1, 4, '2023-05-23 01:51:02', NULL, 0, '202305-00001', 0),
(10, 1, 4, '2023-05-23 02:05:58', NULL, 0, '202305-00002', 0);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`id`, `code`, `firstname`, `lastname`, `contact`, `email`, `password`, `avatar`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, '202202-00001', 'John', 'Smith', '09123456789', 'jsmith@gmail.com', '1254737c076cf867dc53d60a0364f38e', 'uploads/clients/1.png?v=1644386016', 1, 0, '2022-02-09 13:53:36', '2022-02-10 13:42:53'),
(2, '202301-00001', 'Izzah', 'Batrisyia', '0189841700', 'izzah@gmail.com', '8de37172b68fadfc466b7c9ec51fba36', 'uploads/clients/3.png?v=1673412928', 1, 0, '2023-01-11 12:55:28', '2023-01-11 12:55:28'),
(3, '202301-00002', 'Khairah', 'Izzati', '0137440433', 'khairah@gmail.com', '9357c8ce48a222e27ab04fc7ed4d9ad4', 'uploads/clients/4.png?v=1673413324', 1, 0, '2023-01-11 13:02:04', '2023-01-11 13:02:04'),
(4, '202303-00001', 'Hapidah', 'Sidek', '0137568411', 'hapidah@gmail.com', 'b960d28ffa3b94a0b687672620bd3553', 'uploads/clients/4.png?v=1679762340', 1, 0, '2023-03-26 00:39:00', '2023-03-26 00:39:00'),
(5, '202303-00002', 'Ali', 'Abu', '0189383948489', 'ali@gmail.com', '984d8144fa08bfc637d2825463e184fa', 'uploads/clients/5.png?v=1679936541', 1, 0, '2023-03-28 01:02:21', '2023-03-28 01:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` int(30) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `image_path` text NOT NULL,
  `date` date NOT NULL,
  `time` text NOT NULL,
  `location` text NOT NULL,
  `description` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`id`, `admin_id`, `name`, `image_path`, `date`, `time`, `location`, `description`, `date_created`, `date_updated`) VALUES
(1, 1, 'Cakna Banjir Kelantan ', 'uploads/program/1.png?v=1679602434', '2023-03-24', '2:00 p.m - 5:00 p.m.', 'SMK Kota Bharu, Kompleks Sekolah-Sekolah, Wakaf Mek Zainab, Kelantan,15300, Kota Bharu', '&lt;p&gt;The organization is on the scene in Kelantan helping flood victims and we need all the help we can get. Do your part to help those affected by the floods by donating useful goods. You can drop off your goods at the following locations during the specified time and date.&lt;/p&gt;&lt;p&gt;Urgent donations are needed for:&nbsp;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;Blankets (100 pcs)&lt;/li&gt;&lt;li&gt;Disposable Diapers (200 pcs)&lt;/li&gt;&lt;li&gt;Sanitary Napkins (80 pcs)&lt;/li&gt;&lt;li&gt;Baby Bottles (50 pcs)&lt;br&gt;&lt;/li&gt;&lt;/ul&gt;', '2023-03-24 02:30:35', '2023-03-24 04:13:54'),
(2, 1, 'Cakna Banjir Johor', 'uploads/program/2.png?v=1683688874', '2023-04-03', '2:00 p.m - 5:00 p.m.', '&lt;&lt;sample&gt;&gt;', '&lt;p&gt;&amp;lt;&amp;lt;sample&amp;gt;&lt;sample&gt;&amp;gt;&lt;/sample&gt;&lt;/p&gt;', '2023-04-11 04:23:55', '2023-05-10 11:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'i-Care: Online Goods Donation Management System'),
(6, 'short_name', 'i-Care'),
(11, 'logo', 'uploads/logo-1673390790.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1673390790.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `donated_goods`
--
ALTER TABLE `donated_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `donation_id` (`donation_id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donated_goods`
--
ALTER TABLE `donated_goods`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
