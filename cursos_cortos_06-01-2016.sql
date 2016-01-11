-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-01-2016 a las 23:50:08
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
-- Estructura de tabla para la tabla `cursos_cortos`
--

CREATE TABLE IF NOT EXISTS `cursos_cortos` (
  `cod_curso` int(8) NOT NULL,
  `nombre_ES` text COLLATE utf8_spanish_ci NOT NULL,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre_IN` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre_POR` text COLLATE utf8_spanish_ci NOT NULL,
  `pais` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cursos_cortos`
--

INSERT INTO `cursos_cortos` (`cod_curso`, `nombre_ES`, `categoria`, `nombre_IN`, `nombre_POR`, `pais`) VALUES
(29, 'Bartender', '1', 'Bartender', 'Bartender', '[1]'),
(13, 'Sommelier', '1', 'Sommelier', 'Sommelier', '[1]'),
(15, 'Chocolateria', '2', 'Chocolateria', 'Chocolateria', '[1]'),
(40, 'Cocina para eventos', '3', 'Cocina para eventos', 'Cocina para eventos', '[1]'),
(3, 'Chef express', '3', 'Chef express', 'Chef express', '[1]'),
(89, 'Cocina española e italiana', '4', 'Cocina española e italiana', 'Cocina española e italiana', '[1]'),
(96, 'Cocina japonesa y sushi', '4', 'Cocina japonesa y sushi', 'Cocina japonesa y sushi ', '[1]'),
(23, 'Chef express II', '4', 'Chef express II', 'Chef express II', '[1]'),
(14, 'Sushi', '4', 'Sushi', 'Sushi', '[1]'),
(38, 'Decoración de tortas', '5', 'Decoración de tortas', 'Decoración de tortas', '[1]'),
(8, 'Panadería y pastelería', '5', 'Panadería y pastelería', 'Panadería y pastelería', '[1]'),
(25, 'Pastelería para eventos', '5', 'Pastelería para eventos', 'Pastelería para eventos', '[1]'),
(6, 'Cocina diet', '6', 'Cocina diet', 'Cocina diet', '[1]');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
