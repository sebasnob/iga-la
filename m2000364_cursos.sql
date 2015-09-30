-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-09-2015 a las 00:12:16
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
(1, 'Gastronomia & Alta Cocina', '#00b300', '"Open Sans",sans-serif');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_datos`
--

CREATE TABLE IF NOT EXISTS `curso_datos` (
`id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `img_cabecera` text NOT NULL,
  `descripcion` text NOT NULL,
  `img_materiales` text NOT NULL,
  `img_uniforme` text NOT NULL,
  `id_curso_idioma` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `curso_datos`
--

INSERT INTO `curso_datos` (`id`, `titulo`, `img_cabecera`, `descripcion`, `img_materiales`, `img_uniforme`, `id_curso_idioma`) VALUES
(1, 'Gastronomia y Alta cocina', '../images/slider/1/ES/slider-1.jpg', 'gastronomiaaa', '../images/materiales/1/ES/materiales.jpg', '../images/uniformes/1/ES/uniforme.jpg', 1),
(2, 'Gastronomia e Alta Cozinha', '../images/slider/1/POR/slider-1.jpg', 'gastronomiaaa', '../images/materiales/1/POR/materiales.png', '../images/uniformes/1/POR/uniforme.jpg', 2);

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
  `idioma` varchar(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `curso_idioma`
--

INSERT INTO `curso_idioma` (`id`, `id_curso`, `idioma`) VALUES
(1, 1, 'ES'),
(2, 1, 'POR'),
(3, 1, 'IN');

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
-- Estructura de tabla para la tabla `grilla`
--

CREATE TABLE IF NOT EXISTS `grilla` (
  `id` int(11) NOT NULL,
  `rows` int(11) NOT NULL,
  `cols` int(11) NOT NULL,
  `img_url` text NOT NULL,
  `thumb_url` text NOT NULL,
  `prioridad` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL COMMENT 'deberia ser clave foranea de cursos',
  `habilitado` int(11) NOT NULL DEFAULT '1',
  `idioma` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grilla`
--

INSERT INTO `grilla` (`id`, `rows`, `cols`, `img_url`, `thumb_url`, `prioridad`, `id_curso`, `habilitado`, `idioma`) VALUES
(9, 1, 6, 'images/grilla/7.jpg', 'images/grilla/thumb/7.jpg', 1, 1, 1, 'es'),
(10, 1, 3, 'images/grilla/5.jpg', 'images/grilla/thumb/5.jpg', 2, 1, 1, 'es'),
(0, 1, 3, 'images/grilla/2.jpg', 'images/grilla/thumb/2.jpg', 3, 1, 1, 'es'),
(0, 1, 3, 'images/grilla/6.jpg', 'images/grilla/thumb/6.jpg', 4, 1, 1, 'es'),
(0, 1, 6, 'images/grilla/7 - copia.jpg', 'images/grilla/thumb/7 - copia.jpg', 5, 1, 1, 'es'),
(0, 1, 3, 'images/grilla/2 - copia.jpg', 'images/grilla/thumb/2 - copia.jpg', 6, 1, 1, 'es');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `home`
--

CREATE TABLE IF NOT EXISTS `home` (
`id` int(11) NOT NULL,
  `url_video` text NOT NULL,
  `titulo_es` text NOT NULL,
  `titulo_in` text NOT NULL,
  `titulo_por` text NOT NULL,
  `subtitulo_es` text NOT NULL,
  `subtitulo_por` text NOT NULL,
  `subtitulo_in` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `home`
--

INSERT INTO `home` (`id`, `url_video`, `titulo_es`, `titulo_in`, `titulo_por`, `subtitulo_es`, `subtitulo_por`, `subtitulo_in`) VALUES
(1, 'https://www.youtube.com/embed/JApGTCxZztg?rel=0&controls=0&showinfo=0&autoplay=1&autoplay=1&loop=0&playlist=Rk6_hdRtJOE&enablejsapi=1&version=3', '<p>Bienvenidos a <span style="color:#0033cc">IGA</span></p>\r\n', 'Welcome to IGA', '<p>Bem-vindo ao IGA</p>\r\n', '<p><em>INSTITUTO </em>GASTRONOMICO DE LAS AMERICAS</p>\r\n', '<p>INSTITUTO GASTRONOMICO DAS AMERICAS</p>\r\n', 'THE MOST IMPOARTANT GASTRONOMIC TRAINING NETWORK');

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
  `cod_pais` varchar(3) NOT NULL,
  `flag` text NOT NULL,
  `idioma` varchar(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `pais`, `cod_pais`, `flag`, `idioma`) VALUES
(1, 'Argentina', 'AR', 'images/flags/ar.png', 'ES'),
(3, 'Brasil', 'BR', 'images/flags/br.png', 'POR'),
(5, 'Uruguay', 'UR', 'images/flags/ur.png', 'ES'),
(7, 'Paraguay', 'PAR', 'images/flags/par.png', 'ES'),
(9, 'Bolivia', 'BOL', 'images/flags/bo.png', 'ES'),
(11, 'Panama', 'PAN', 'images/flags/pan.png', 'ES'),
(13, 'USA', 'US', 'images/flags/us.png', 'IN');

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
-- Indices de la tabla `curso_datos`
--
ALTER TABLE `curso_datos`
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
-- Indices de la tabla `home`
--
ALTER TABLE `home`
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
-- AUTO_INCREMENT de la tabla `curso_datos`
--
ALTER TABLE `curso_datos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `curso_filial`
--
ALTER TABLE `curso_filial`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `curso_idioma`
--
ALTER TABLE `curso_idioma`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
-- AUTO_INCREMENT de la tabla `home`
--
ALTER TABLE `home`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
