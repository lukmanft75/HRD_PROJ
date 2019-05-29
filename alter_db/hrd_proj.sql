-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2019 at 02:13 PM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `backoffice_menu`
--

DROP TABLE IF EXISTS `backoffice_menu`;
CREATE TABLE `backoffice_menu` (
  `id` int(11) NOT NULL,
  `seqno` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `access` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backoffice_menu`
--

INSERT INTO `backoffice_menu` (`id`, `seqno`, `parent_id`, `name`, `url`, `access`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `xtimestamp`) VALUES
(1, 1, 0, 'Master', '#', 0, NULL, '', NULL, NULL, '', NULL, '2019-05-20 02:30:00'),
(6, 1, 1, 'Users', 'user_list.php', 0, NULL, '', NULL, NULL, '', NULL, '2019-05-20 02:30:00'),
(7, 2, 1, 'Groups', 'group_list.php', 0, NULL, '', NULL, NULL, '', NULL, '2019-05-20 02:40:08');

-- --------------------------------------------------------

--
-- Table structure for table `backoffice_menu_privileges`
--

DROP TABLE IF EXISTS `backoffice_menu_privileges`;
CREATE TABLE `backoffice_menu_privileges` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `backoffice_menu_id` int(11) NOT NULL,
  `privilege` smallint(6) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `xtimestamp`) VALUES
(1, 'Administrator', '0000-00-00 00:00:00', '', NULL, '2019-05-23 10:51:08', 'super@user.com', '127.0.0.1', '2019-05-23 03:51:08'),
(2, 'Project Manager', '0000-00-00 00:00:00', '', NULL, '2019-05-23 14:04:52', 'super@user.com', '127.0.0.1', '2019-05-23 07:04:52'),
(3, 'Zone Manager', '0000-00-00 00:00:00', '', NULL, '2019-05-23 14:05:03', 'super@user.com', '127.0.0.1', '2019-05-23 07:05:03'),
(5, 'Cordinator', '2019-05-23 14:05:15', 'super@user.com', '127.0.0.1', '2019-05-23 14:05:15', 'super@user.com', '127.0.0.1', '2019-05-23 07:05:15'),
(6, 'Team Leader', '2019-05-23 14:05:25', 'super@user.com', '127.0.0.1', '2019-05-23 14:05:25', 'super@user.com', '127.0.0.1', '2019-05-23 07:05:25'),
(7, 'Team Member', '2019-05-23 14:05:58', 'super@user.com', '127.0.0.1', '2019-05-23 14:05:58', 'super@user.com', '127.0.0.1', '2019-05-23 07:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `log_histories`
--

DROP TABLE IF EXISTS `log_histories`;
CREATE TABLE `log_histories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `x_mode` smallint(6) NOT NULL,
  `log_at` datetime DEFAULT NULL,
  `log_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_histories`
--

INSERT INTO `log_histories` (`id`, `user_id`, `email`, `x_mode`, `log_at`, `log_ip`, `xtimestamp`) VALUES
(1, 1, 'super@user.com', 2, '2019-05-20 09:31:07', '127.0.0.1', '2019-05-20 02:31:07'),
(2, 1, 'super@user.com', 1, '2019-05-20 09:31:17', '127.0.0.1', '2019-05-20 02:31:17'),
(3, 1, 'super@user.com', 1, '2019-05-20 11:03:45', '127.0.0.1', '2019-05-20 04:03:45'),
(4, 1, 'super@user.com', 1, '2019-05-20 11:23:07', '127.0.0.1', '2019-05-20 04:23:07'),
(5, 1, 'super@user.com', 1, '2019-05-20 13:10:09', '127.0.0.1', '2019-05-20 06:10:09'),
(6, 17, 'erna@corphr.com', 2, '2019-05-20 14:37:51', '127.0.0.1', '2019-05-20 07:37:51'),
(7, 1, 'super@user.com', 1, '2019-05-20 14:38:06', '127.0.0.1', '2019-05-20 07:38:06'),
(8, 1, 'super@user.com', 1, '2019-05-21 10:27:15', '127.0.0.1', '2019-05-21 03:27:15'),
(9, 184, 'lukman@corphr-nokia.com', 2, '2019-05-21 10:27:47', '127.0.0.1', '2019-05-21 03:27:47'),
(10, 1, 'super@user.com', 1, '2019-05-21 10:27:52', '127.0.0.1', '2019-05-21 03:27:52'),
(11, 1, 'super@user.com', 1, '2019-05-21 11:01:38', '127.0.0.1', '2019-05-21 04:01:38'),
(12, 1, 'super@user.com', 1, '2019-05-21 11:15:11', '127.0.0.1', '2019-05-21 04:15:11'),
(13, 1, 'super@user.com', 1, '2019-05-21 13:17:55', '127.0.0.1', '2019-05-21 06:17:55'),
(14, 1, 'superuser', 2, '2019-05-21 13:42:15', '127.0.0.1', '2019-05-21 06:42:15'),
(15, 1, 'super@user.com', 1, '2019-05-21 13:42:28', '127.0.0.1', '2019-05-21 06:42:28'),
(16, 1, 'super@user.com', 1, '2019-05-21 15:59:43', '127.0.0.1', '2019-05-21 08:59:43'),
(17, 1, 'super@user.com', 1, '2019-05-22 08:05:37', '127.0.0.1', '2019-05-22 01:05:37'),
(18, 1, 'super@user.com', 1, '2019-05-22 08:18:11', '127.0.0.1', '2019-05-22 01:18:11'),
(19, 1, 'super@user.com', 2, '2019-05-22 10:24:47', '127.0.0.1', '2019-05-22 03:24:48'),
(20, 1, 'super@user.com', 1, '2019-05-22 10:24:58', '127.0.0.1', '2019-05-22 03:24:58'),
(21, 1, 'super@user.com', 2, '2019-05-22 10:36:30', '127.0.0.1', '2019-05-22 03:36:30'),
(22, 2, 'kepsek@user.com', 1, '2019-05-22 10:42:11', '127.0.0.1', '2019-05-22 03:42:11'),
(23, 2, 'kepsek@user.com', 2, '2019-05-22 10:42:15', '127.0.0.1', '2019-05-22 03:42:15'),
(24, 1, 'super@user.com', 1, '2019-05-22 10:42:26', '127.0.0.1', '2019-05-22 03:42:26'),
(25, 1, 'super@user.com', 1, '2019-05-22 11:45:00', '127.0.0.1', '2019-05-22 04:45:00'),
(26, 1, 'super@user.com', 1, '2019-05-22 13:10:59', '127.0.0.1', '2019-05-22 06:10:59'),
(27, 1, 'super@user.com', 1, '2019-05-23 10:49:14', '127.0.0.1', '2019-05-23 03:49:14'),
(28, 1, 'super@user.com', 1, '2019-05-23 12:59:21', '127.0.0.1', '2019-05-23 05:59:21'),
(29, 1, 'super@user.com', 2, '2019-05-23 13:22:31', '127.0.0.1', '2019-05-23 06:22:31'),
(30, 2, 'kepsek@user.com', 1, '2019-05-23 13:22:37', '127.0.0.1', '2019-05-23 06:22:37'),
(31, 2, 'kepsek@user.com', 2, '2019-05-23 13:22:44', '127.0.0.1', '2019-05-23 06:22:44'),
(32, 1, 'super@user.com', 1, '2019-05-23 13:22:57', '127.0.0.1', '2019-05-23 06:22:57'),
(33, 87, 'harum.fauziyyah@indottech.corphr.com', 2, '2019-05-23 14:04:06', '127.0.0.1', '2019-05-23 07:04:06'),
(34, 1, 'super@user.com', 1, '2019-05-23 14:04:16', '127.0.0.1', '2019-05-23 07:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_division` varchar(100) NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL,
  `sign_in_count` int(11) NOT NULL,
  `current_sign_in_at` datetime DEFAULT NULL,
  `last_sign_in_at` datetime DEFAULT NULL,
  `current_sign_in_ip` varchar(20) DEFAULT NULL,
  `last_sign_in_ip` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `setting_clicked` tinyint(4) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `email`, `password`, `name`, `job_title`, `job_division`, `hidden`, `token`, `sign_in_count`, `current_sign_in_at`, `last_sign_in_at`, `current_sign_in_ip`, `last_sign_in_ip`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `setting_clicked`, `xtimestamp`) VALUES
(1, 0, 'super@user.com', 'c3VwZXJ1c2Vy', 'Superuser', 'Administrator', 'Administrator', 0, '', 22, '2019-05-23 14:04:16', '2019-05-23 13:22:57', '127.0.0.1', '127.0.0.1', '0000-00-00 00:00:00', '', NULL, '2019-05-23 14:04:16', 'super@user.com', '127.0.0.1', 0, '2019-05-23 07:04:16'),
(9, 7, 'cornelia.verdiana@corphr-nokia.com', 'MTIzNDU2', 'Cornel', 'Member', '', 0, '', 0, NULL, NULL, NULL, NULL, '2019-05-23 14:07:15', 'super@user.com', '127.0.0.1', '2019-05-23 14:07:15', 'super@user.com', '127.0.0.1', 0, '2019-05-23 07:07:15'),
(10, 6, 'nur.aprilia@indottech.corphr.com', 'MTIzNDU2', 'Namira', 'Team Leader', '', 0, '', 0, NULL, NULL, NULL, NULL, '2019-05-23 14:07:38', 'super@user.com', '127.0.0.1', '2019-05-23 14:07:38', 'super@user.com', '127.0.0.1', 0, '2019-05-23 07:07:38'),
(11, 5, 'aidilwaris21@gmail.com', 'MTIzNDU2', 'Aidil', 'Cordinator', '', 0, '', 0, NULL, NULL, NULL, NULL, '2019-05-23 14:08:02', 'super@user.com', '127.0.0.1', '2019-05-23 14:08:02', 'super@user.com', '127.0.0.1', 0, '2019-05-23 07:08:02'),
(12, 3, 'ismi@corphr.com', 'MTIzNDU2', 'Ismi', 'Zone Manager', '', 0, '', 0, NULL, NULL, NULL, NULL, '2019-05-23 14:09:21', 'super@user.com', '127.0.0.1', '2019-05-23 14:09:21', 'super@user.com', '127.0.0.1', 0, '2019-05-23 07:09:21'),
(13, 2, 'florensia.basuki@corphr-nokia.com', 'SnVub1NlaGF0OTI3', 'Flo', 'Project Manager', '', 0, '', 0, NULL, NULL, NULL, NULL, '2019-05-23 14:09:59', 'super@user.com', '127.0.0.1', '2019-05-23 14:10:09', 'super@user.com', '127.0.0.1', 0, '2019-05-23 07:10:09');

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

DROP TABLE IF EXISTS `version`;
CREATE TABLE `version` (
  `id` int(11) NOT NULL,
  `version` varchar(20) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `version`
--

INSERT INTO `version` (`id`, `version`, `xtimestamp`) VALUES
(1, '10', '2019-03-14 18:46:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backoffice_menu`
--
ALTER TABLE `backoffice_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `backoffice_menu_privileges`
--
ALTER TABLE `backoffice_menu_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_histories`
--
ALTER TABLE `log_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backoffice_menu`
--
ALTER TABLE `backoffice_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `backoffice_menu_privileges`
--
ALTER TABLE `backoffice_menu_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `log_histories`
--
ALTER TABLE `log_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `version`
--
ALTER TABLE `version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
