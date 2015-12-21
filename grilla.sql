-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-12-2015 a las 18:05:38
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

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
-- Estructura de tabla para la tabla `grilla`
--

CREATE TABLE IF NOT EXISTS `grilla` (
  `id` int(11) NOT NULL,
  `img_url` text NOT NULL,
  `thumb_url` text NOT NULL,
  `prioridad` int(11) NOT NULL,
  `cod_curso` int(11) NOT NULL COMMENT 'deberia ser clave foranea de cursos',
  `habilitado` int(11) NOT NULL DEFAULT '1',
  `idioma` varchar(3) NOT NULL,
  `id_pais` text NOT NULL,
  `descripcion` text NOT NULL,
  `titulo` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grilla`
--

INSERT INTO `grilla` (`id`, `img_url`, `thumb_url`, `prioridad`, `cod_curso`, `habilitado`, `idioma`, `id_pais`, `descripcion`, `titulo`) VALUES
(3, 'images/grilla/a71e6de1b2_chrysanthemum.jpg', 'images/grilla/thumb/a71e6de1b2_chrysanthemum.jpg', 2, 1, 1, 'es', '["1"]', 'Gastro y alta cocina brinda los conocimientos necesarios para alcanzar la excelencia como profesional de la gastronomía.', 'Gastro'),
(6, 'images/grilla/16527663f6_desert.jpg', 'images/grilla/thumb/16527663f6_desert.jpg', 2, 102, 1, 'es', '["1"]', 'Gastro y alta cocina brinda los conocimientos necesarios para alcanzar la excelencia como profesional de la gastronomía.', ''),
(7, 'images/grilla/e22924bd4f_jellyfish.jpg', 'images/grilla/thumb/e22924bd4f_jellyfish.jpg', 3, 81, 1, 'es', '["1"]', 'Gastro y alta cocina brinda los conocimientos necesarios para alcanzar la excelencia como profesional de la gastronomía.', ''),
(8, 'images/grilla/ca3d43df0a_koala.jpg', 'images/grilla/thumb/ca3d43df0a_koala.jpg', 4, 29, 1, 'es', '["1"]', 'asd sad liasjdlk hjasldj aslkdjlkasjdlk a lkjaslk jd', ''),
(9, 'images/grilla/efd4d811c4_lighthouse.jpg', 'images/grilla/thumb/efd4d811c4_lighthouse.jpg', 3, 17, 1, 'es', '["1"]', 'asd sad liasjdlk hjasldj aslkdjlkasjdlk a lkjaslk jd', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `grilla`
--
ALTER TABLE `grilla`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grilla`
--
ALTER TABLE `grilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
