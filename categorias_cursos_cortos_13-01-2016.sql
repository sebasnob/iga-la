-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-01-2016 a las 14:34:24
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
-- Estructura de tabla para la tabla `categorias_cursos_cortos`
--

CREATE TABLE IF NOT EXISTS `categorias_cursos_cortos` (
  `id` int(11) NOT NULL,
  `nombre_ES` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre_IN` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre_POR` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias_cursos_cortos`
--

INSERT INTO `categorias_cursos_cortos` (`id`, `nombre_ES`, `nombre_IN`, `nombre_POR`) VALUES
(1, 'Bebidas', 'Drinks', 'bebidas'),
(2, 'Dulces', 'Candy', 'Doces'),
(3, 'Gourmet', 'Gourmet', 'Gourmet'),
(4, 'Internacional', 'International', 'Internacional'),
(5, 'Reposteria', 'Pastry & Bakery', 'Padaria e Confeitaria'),
(6, 'Saludable', 'Healthy', 'Saudável');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_cursos_cortos`
--
ALTER TABLE `categorias_cursos_cortos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias_cursos_cortos`
--
ALTER TABLE `categorias_cursos_cortos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
