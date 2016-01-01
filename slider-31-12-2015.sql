-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 31-12-2015 a las 20:18:36
-- Versión del servidor: 5.6.27-0ubuntu1
-- Versión de PHP: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `iga`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL,
  `alt` text COLLATE utf8_spanish_ci NOT NULL,
  `url` text COLLATE utf8_spanish_ci NOT NULL,
  `url_thumb` text COLLATE utf8_spanish_ci NOT NULL,
  `link` text COLLATE utf8_spanish_ci NOT NULL,
  `id_pais` text COLLATE utf8_spanish_ci NOT NULL,
  `cod_idioma` text COLLATE utf8_spanish_ci NOT NULL,
  `background` varchar(7) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `slider`
--

INSERT INTO `slider` (`id`, `alt`, `url`, `url_thumb`, `link`, `id_pais`, `cod_idioma`, `background`) VALUES
(1, '', 'images/slider/e2e8e24bbb_426080.jpg', 'images/slider/thumb/e2e8e24bbb_426080.jpg', '', '["3"]', '["ES"]', 'red'),
(2, '', 'images/slider/431d1a66fe_home-gastronomia-490x170.jpg', 'images/slider/thumb/431d1a66fe_home-gastronomia-490x170.jpg', '', '["1"]', '["ES"]', 'red'),
(3, 'kjahsdkjahskdj', 'images/slider/bobafett-hd.jpg', 'images/slider/thumb/bobafett-hd.jpg', 'asjkhdaskj', '["2"]', '["POR"]', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
