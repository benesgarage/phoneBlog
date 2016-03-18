-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-03-2016 a las 16:21:36
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kitmaker_posts`
--
CREATE DATABASE IF NOT EXISTS `kitmaker_posts` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kitmaker_posts`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission`
--

CREATE TABLE `permission` (
  `id_permission` int(11) NOT NULL,
  `permission_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `body` varchar(5000) NOT NULL,
  `datetime` datetime NOT NULL,
  `slug` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `device` varchar(45) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id_post`, `title`, `body`, `datetime`, `slug`, `id_user`, `device`, `hide`) VALUES
(4, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rutrum tempor elit et feugiat. Duis pretium mauris et scelerisque luctus. Nam dictum pulvinar metus, non bibendum erat aliquet id. Integer accumsan et tortor sed fringilla. Mauris semper aliquam erat ac egestas. Aenean velit enim, viverra lobortis sapien ac, ullamcorper ultrices tellus. Proin consectetur sapien neque, id pharetra turpis tincidunt commodo.\r\n', '2016-03-18 16:13:28', 'lorem-ipsum', 1, 'Chrome ', 0),
(5, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rutrum tempor elit et feugiat. Duis pretium mauris et scelerisque luctus. Nam dictum pulvinar metus, non bibendum erat aliquet id. Integer accumsan et tortor sed fringilla. Mauris semper aliquam erat ac egestas. Aenean velit enim, viverra lobortis sapien ac, ullamcorper ultrices tellus. Proin consectetur sapien neque, id pharetra turpis tincidunt commodo.\r\n', '2016-03-18 16:13:47', 'lorem-ipsum', 1, 'Chrome ', 0),
(6, 'Notice', 'Even having the same title and user whom input the post, we can see that our first two posts redirect differently, since we are using the posts unique ID from the database to reference it.', '2016-03-18 16:14:53', 'notice', 1, 'Chrome ', 0),
(7, 'Mobile phone', 'We can also see that our application is inserting information related to the device that was used to create the post in question. Here we have a Google Nexus 5.', '2016-03-18 16:16:49', 'mobile-phone', 1, 'Google Nexus 5', 0),
(8, 'Users', 'We can also register users so that the posts created have an author, all we have to do is register and log in. I''ve just created this post via the user benes.', '2016-03-18 16:17:59', 'users', 7, 'Google Nexus 5', 0),
(9, 'Administrator implementation', 'As we can see here, the admin can hide our posts, so only he can see them. If we log out and look at the main page anonymously, we will not see this post.', '2016-03-18 16:19:26', 'administrator-implementation', 8, 'Google Nexus 5', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `role_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id_role`, `role_name`) VALUES
(1, 'Administrator'),
(2, 'Anonymous'),
(3, 'Standard');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permission`
--

CREATE TABLE `role_has_permission` (
  `id_role` int(11) NOT NULL,
  `id_permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `user_password` varchar(45) NOT NULL,
  `user_email` varchar(70) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `user_name`, `user_password`, `user_email`, `id_role`) VALUES
(1, 'Anonymous', 'anonymous', 'anon@anon', 2),
(7, 'benes', 'benes', 'kkarl@kitmaker.com', 3),
(8, 'admin', 'admin', 'admin@admin.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_has_permission`
--

CREATE TABLE `user_has_permission` (
  `id_user` int(11) NOT NULL,
  `id_permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id_permission`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `fk_post_user1_idx` (`id_user`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD PRIMARY KEY (`id_role`,`id_permission`),
  ADD KEY `fk_role_has_permission_permission1_idx` (`id_permission`),
  ADD KEY `fk_role_has_permission_role_idx` (`id_role`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_user_role1_idx` (`id_role`);

--
-- Indices de la tabla `user_has_permission`
--
ALTER TABLE `user_has_permission`
  ADD PRIMARY KEY (`id_user`,`id_permission`),
  ADD KEY `fk_user_has_permission_permission1_idx` (`id_permission`),
  ADD KEY `fk_user_has_permission_user1_idx` (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permission`
--
ALTER TABLE `permission`
  MODIFY `id_permission` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD CONSTRAINT `fk_role_has_permission_permission1` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id_permission`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role_has_permission_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user_has_permission`
--
ALTER TABLE `user_has_permission`
  ADD CONSTRAINT `fk_user_has_permission_permission1` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id_permission`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_permission_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
