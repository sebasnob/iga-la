-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-12-2015 a las 17:31:35
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `m2000364_cursos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades_categorias`
--

CREATE TABLE IF NOT EXISTS `novedades_categorias` (
`id` int(11) NOT NULL,
  `nombre_ES` text COLLATE utf8_spanish2_ci NOT NULL,
  `nombre_IN` text COLLATE utf8_spanish2_ci NOT NULL,
  `nombre_POR` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `novedades_categorias`
--

INSERT INTO `novedades_categorias` (`id`, `nombre_ES`, `nombre_IN`, `nombre_POR`) VALUES
(1, 'Actualidad', '', 0),
(2, 'Eventos', '', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `novedades_categorias`
--
ALTER TABLE `novedades_categorias`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `novedades_categorias`
--
ALTER TABLE `novedades_categorias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
