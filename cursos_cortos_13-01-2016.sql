-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-01-2016 a las 14:33:49
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
(29, 'Bartender', '1', 'Bartender', 'Bartender', '[1,2,3,4,6,9,10]'),
(13, 'Sommelier', '1', 'Sommelier', 'Sommelier', '[1]'),
(15, 'Chocolateria', '2', 'Chocolateria', 'Chocolateria', '[1,2]'),
(40, 'Cocina para eventos', '3', 'Cocina para eventos', 'Cocina para eventos', '[1]'),
(3, 'Chef express', '3', 'Express Chef', 'Chef express', '[1,2,3,4,6,9,10]'),
(89, 'Cocina española e italiana', '4', 'Cocina española e italiana', 'Cozinha Espanhola e Italiana', '[1,2]'),
(96, 'Cocina japonesa y sushi', '4', 'Japanese Food', 'Sushi e cozinha japonesa', '[1,2,3,4,6,9,10]'),
(23, 'Chef express II', '4', 'Chef express II', 'Chef express II', '[1,2]'),
(14, 'Sushi', '4', 'Sushi', 'Sushi', '[1]'),
(38, 'Decoración de tortas', '5', 'Decoración de tortas', 'Decoração de Bolos', '[1,2]'),
(8, 'Panadería y pastelería', '5', 'Bakery and Pastry', 'Panificação e Confeitaria', '[1,2,3,4,6,9,10]'),
(25, 'Pastelería para eventos', '5', 'Pastry for Events', 'Pastelería para eventos', '[1,2,3,4,6,9,10]'),
(6, 'Cocina diet', '6', 'Cocina diet', 'Cozinha diet', '[1,2]');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
