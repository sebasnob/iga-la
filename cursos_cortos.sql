-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 26-11-2015 a las 08:17:51
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
  `nombre_POR` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cursos_cortos`
--

INSERT INTO `cursos_cortos` (`cod_curso`, `nombre_ES`, `categoria`, `nombre_IN`, `nombre_POR`) VALUES
(29, 'Bartender', '1', 'Bartender', 'Bartender'),
(13, 'Sommelier', '1', 'Sommelier', 'Sommelier'),
(15, 'Chocolateria', '2', 'Chocolateria', 'Chocolateria');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
