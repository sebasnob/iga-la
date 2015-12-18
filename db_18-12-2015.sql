-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 18-12-2015 a las 15:48:25
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
  `descripcion` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grilla`
--

INSERT INTO `grilla` (`id`, `img_url`, `thumb_url`, `prioridad`, `cod_curso`, `habilitado`, `idioma`, `id_pais`, `descripcion`) VALUES
(3, 'images/grilla/51eafcc15a_home-gastronomia-490x170.jpg', 'images/grilla/thumb/51eafcc15a_home-gastronomia-490x170.jpg', 2, 1, 1, 'es', '["1"]', 'Gastro y alta cocina brinda los conocimientos necesarios para alcanzar la excelencia como profesional de la gastronomía.'),
(6, 'images/grilla/d77f6cc47f_captura-de-pantalla-de-2015-12-18-15-10-55.png', 'images/grilla/thumb/d77f6cc47f_captura-de-pantalla-de-2015-12-18-15-10-55.png', 2, 102, 1, 'es', '["1"]', 'Gastro y alta cocina brinda los conocimientos necesarios para alcanzar la excelencia como profesional de la gastronomía.'),
(7, 'images/grilla/750d94c250_7019858-widescreen-wallpapers-3d.jpg', 'images/grilla/thumb/750d94c250_7019858-widescreen-wallpapers-3d.jpg', 3, 67, 1, 'es', '["1"]', 'Gastro y alta cocina brinda los conocimientos necesarios para alcanzar la excelencia como profesional de la gastronomía.'),
(8, 'images/grilla/46f65160d8_home-gastronomia-490x170.jpg', 'images/grilla/thumb/46f65160d8_home-gastronomia-490x170.jpg', 4, 67, 1, 'es', '["1"]', 'asd sad liasjdlk hjasldj aslkdjlkasjdlk a lkjaslk jd'),
(9, 'images/grilla/c0c475fef1_captura-de-pantalla-de-2015-12-18-15-10-55.png', 'images/grilla/thumb/c0c475fef1_captura-de-pantalla-de-2015-12-18-15-10-55.png', 3, 67, 1, 'es', '["1"]', 'asd sad liasjdlk hjasldj aslkdjlkasjdlk a lkjaslk jd');

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
