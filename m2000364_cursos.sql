-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2015 a las 02:17:28
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
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE IF NOT EXISTS `cursos` (
`id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `color` varchar(8) NOT NULL,
  `fuente` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`, `color`, `fuente`) VALUES
(1, 'Gastronomia & Alta Cocina', '#00b900', '"Open Sans",sans-serif');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_filial`
--

CREATE TABLE IF NOT EXISTS `curso_filial` (
`id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_filial` int(11) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_idioma`
--

CREATE TABLE IF NOT EXISTS `curso_idioma` (
`id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `idioma` varchar(6) NOT NULL,
  `titulo` text NOT NULL,
  `img_cabecera` text NOT NULL,
  `descripcion` text NOT NULL,
  `img_materiales` text NOT NULL,
  `img_uniforme` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `curso_idioma`
--

INSERT INTO `curso_idioma` (`id`, `id_curso`, `idioma`, `titulo`, `img_cabecera`, `descripcion`, `img_materiales`, `img_uniforme`) VALUES
(1, 1, 'ES', 'Gastronomia y Alta cocina', 'images/slider/curso-1/ES/slider-curso-1.jpg', 'aaaaa', 'images/img-materiales/curso-1/ES/img_materiales.png', 'images/img-uniforme/curso-1/ES/img_uniforme.png'),
(2, 1, 'POR', 'Gastronomia y Alta cocina', 'images/slider/curso-1/POR/slider-curso-1.jpg', 'aaaaa', 'images/img-materiales/curso-1/POR/img_materiales.jpg', 'images/img-uniforme/curso-1/POR/img_uniforme.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_pais`
--

CREATE TABLE IF NOT EXISTS `curso_pais` (
`id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `cod_pais` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filiales`
--

CREATE TABLE IF NOT EXISTS `filiales` (
`id` int(11) NOT NULL,
  `filial` varchar(64) NOT NULL,
  `id_provincia` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `filiales`
--

INSERT INTO `filiales` (`id`, `filial`, `id_provincia`) VALUES
(1, 'Almirante Brown', 1),
(3, 'Avellaneda', 1),
(5, 'Bahia Blanca', 1),
(7, 'Rosario', 31),
(9, 'Funes', 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas`
--

CREATE TABLE IF NOT EXISTS `idiomas` (
`id` int(11) NOT NULL,
  `idioma` text NOT NULL,
  `cod_idioma` varchar(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `idiomas`
--

INSERT INTO `idiomas` (`id`, `idioma`, `cod_idioma`) VALUES
(1, 'Español', 'ES'),
(2, 'Ingles', 'IN'),
(3, 'Portuges', 'POR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
`id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members`
--

CREATE TABLE IF NOT EXISTS `members` (
`id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` char(128) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `members`
--

INSERT INTO `members` (`id`, `username`, `email`, `password`, `salt`) VALUES
(1, 'admin', 'admin@iga-la.com', '585120cb80965626c5188cea54302013c91804f0e814a128b020003db35746b95c63797c579bbcc425296163be2a08dedfd088ce734873f4b66441827a4050aa', 'ASJA887ASMNSLxXQW');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
`id` int(11) NOT NULL,
  `pais` varchar(64) NOT NULL,
  `cod_pais` varchar(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `pais`, `cod_pais`) VALUES
(1, 'Argentina', 'AR'),
(3, 'Brasil', 'BR'),
(5, 'Uruguay', 'UR'),
(7, 'Paraguay', 'PAR'),
(9, 'Bolivia', 'BOL'),
(11, 'Panama', 'PAN'),
(13, 'USA', 'US');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
`id` int(11) NOT NULL,
  `provincia` varchar(64) NOT NULL,
  `cod_pais` varchar(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `provincia`, `cod_pais`) VALUES
(1, 'Buenos Aires', 'AR'),
(3, 'Catamarca', 'AR'),
(5, 'Chaco', 'AR'),
(7, 'Chubut', 'AR'),
(9, 'Cordoba', 'AR'),
(11, 'Corrientes', 'AR'),
(13, 'Entre Rios', 'AR'),
(15, 'Formosa', 'AR'),
(17, 'Jujuy', 'AR'),
(19, 'Mendoza', 'AR'),
(21, 'Misiones', 'AR'),
(23, 'Neuquen', 'AR'),
(25, 'Salta', 'AR'),
(27, 'San Juan', 'AR'),
(29, 'San Luis', 'AR'),
(31, 'Santa Fe', 'AR'),
(33, 'Sgo del Stero', 'AR'),
(35, 'Tucuman', 'AR'),
(37, 'Escolha', 'BR'),
(39, 'Espirito Santo', 'BR'),
(41, 'Goias', 'BR'),
(43, 'Mato Grosso do Sul', 'BR'),
(45, 'Minas Gerais', 'BR'),
(47, 'Parana', 'BR'),
(49, 'Rio de Janeiro', 'BR'),
(51, 'Montevideo', 'UR'),
(53, 'Salto', 'UR');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `curso_filial`
--
ALTER TABLE `curso_filial`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `curso_idioma`
--
ALTER TABLE `curso_idioma`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `curso_pais`
--
ALTER TABLE `curso_pais`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `filiales`
--
ALTER TABLE `filiales`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `idiomas`
--
ALTER TABLE `idiomas`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `members`
--
ALTER TABLE `members`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `curso_filial`
--
ALTER TABLE `curso_filial`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `curso_idioma`
--
ALTER TABLE `curso_idioma`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `curso_pais`
--
ALTER TABLE `curso_pais`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `filiales`
--
ALTER TABLE `filiales`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `idiomas`
--
ALTER TABLE `idiomas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `members`
--
ALTER TABLE `members`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
