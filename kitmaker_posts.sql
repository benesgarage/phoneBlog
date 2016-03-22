-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2016 at 04:26 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kitmaker_posts`
--
CREATE DATABASE IF NOT EXISTS `kitmaker_posts` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kitmaker_posts`;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id_permission` int(11) NOT NULL,
  `permission_name` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id_permission`, `permission_name`) VALUES
(1, 'Access Site'),
(2, 'Access Admin System'),
(3, 'Publish Posts'),
(5, 'CRUD Users'),
(6, 'CRUD Roles'),
(7, 'CRUD Permissions'),
(8, 'CRUD Posts');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `body` varchar(300) NOT NULL,
  `datetime` datetime NOT NULL,
  `slug` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `device` varchar(45) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id_post`, `title`, `body`, `datetime`, `slug`, `id_user`, `device`, `hide`) VALUES
(1, 'fgfshrtshrts', 'retretert', '2016-03-22 16:07:21', 'fgfshrtshrts', 8, 'Chrome ', 0),
(2, 'fdabboai', 'qeewiuhewrfiu\r\n', '2016-03-22 16:12:09', 'fdabboai', 1, 'Chrome ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `role_name` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `role_name`) VALUES
(2, 'Administrator'),
(1, 'Anonymous'),
(3, 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permission`
--

CREATE TABLE `role_has_permission` (
  `id_roleperm` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_permission` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_has_permission`
--

INSERT INTO `role_has_permission` (`id_roleperm`, `id_role`, `id_permission`, `value`, `add_date`) VALUES
(1, 1, 1, 0, '2016-03-22 08:42:02'),
(2, 1, 2, 0, '2016-03-22 08:42:02'),
(3, 1, 3, 1, '2016-03-22 08:42:02'),
(4, 2, 1, 1, '2016-03-22 08:42:02'),
(5, 2, 2, 1, '2016-03-22 08:42:02'),
(6, 2, 3, 1, '2016-03-22 08:42:02'),
(7, 3, 1, 1, '2016-03-22 08:43:01'),
(8, 3, 2, 0, '2016-03-22 08:43:01'),
(9, 3, 3, 1, '2016-03-22 08:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_email` varchar(70) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `user_name`, `user_password`, `user_email`, `id_role`) VALUES
(1, 'Anonymous', 'anonymous', 'anon@anon', 1),
(7, 'boss', '$2y$12$yz.Ah7TynhWtF6QRJSTeHO.zdOSxYCY/JXNWzynCSiXD99X57LeeO', 'boss@boss.com', 3),
(8, 'admin', '$2y$12$TAvCKj4pXO1RPK4H8lkj0udgCXnXyKfkcGphyLsbz51DzbrqtWkBW', 'admin@admin.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_permission`
--

CREATE TABLE `user_has_permission` (
  `id_userperm` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_permission` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id_permission`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `fk_post_user1_idx` (`id_user`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `role_name_UNIQUE` (`role_name`);

--
-- Indexes for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD PRIMARY KEY (`id_roleperm`),
  ADD KEY `fk_role_has_permission_permission1_idx` (`id_permission`),
  ADD KEY `fk_role_has_permission_role_idx` (`id_role`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_user_role1_idx` (`id_role`);

--
-- Indexes for table `user_has_permission`
--
ALTER TABLE `user_has_permission`
  ADD PRIMARY KEY (`id_userperm`),
  ADD KEY `fk_user_has_permission_permission1_idx` (`id_permission`),
  ADD KEY `fk_user_has_permission_user1_idx` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id_permission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  MODIFY `id_roleperm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_has_permission`
--
ALTER TABLE `user_has_permission`
  MODIFY `id_userperm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD CONSTRAINT `fk_role_has_permission_permission1` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id_permission`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role_has_permission_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_has_permission`
--
ALTER TABLE `user_has_permission`
  ADD CONSTRAINT `fk_user_has_permission_permission1` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id_permission`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_permission_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
