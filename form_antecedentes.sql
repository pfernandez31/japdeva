-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-09-2018 a las 01:46:03
-- Versión del servidor: 5.7.21
-- Versión de PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `form_antecedentes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedentes`
--

DROP TABLE IF EXISTS `antecedentes`;
CREATE TABLE IF NOT EXISTS `antecedentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `responsableId` int(10) NOT NULL,
  `finca` varchar(7) COLLATE utf8_spanish_ci NOT NULL,
  `d` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `derecho` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `identificador_predial` varchar(14) COLLATE utf8_spanish_ci NOT NULL,
  `plano` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `area` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `distritoId` int(10) NOT NULL,
  `cantonId` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `tomo` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `folio` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `asiento` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `razonId` int(10) NOT NULL,
  `razon` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `otorgamiento_hora` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `otorgamiento_fecha` date NOT NULL,
  `presentacion_hora` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `presentacion_fecha` date NOT NULL,
  `plazo_de_convalidacion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `hora_ejecutoria` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_ejecutoria` date NOT NULL,
  `notario` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `juzgado` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `expediente_numero` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `propietario_original` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `propietario_actual` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `traslape` blob NOT NULL,
  `finca_inscrita_derecho` tinyint(1) NOT NULL,
  `analisis_juridico_del_caso` blob NOT NULL,
  `recomendacion_legal` blob NOT NULL,
  `asesor_responsable_historial` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `asesor_responsable_analisis` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canton`
--

DROP TABLE IF EXISTS `canton`;
CREATE TABLE IF NOT EXISTS `canton` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `provicia` int(10) NOT NULL,
  `canton` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `canton`
--

INSERT INTO `canton` (`id`, `provicia`, `canton`) VALUES
(1, 7, 'Limón'),
(2, 7, 'Pococi'),
(3, 7, 'Siquirres'),
(4, 7, 'Talamanca'),
(5, 7, 'Matina'),
(6, 7, 'Guacimo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

DROP TABLE IF EXISTS `distrito`;
CREATE TABLE IF NOT EXISTS `distrito` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `canton` int(10) NOT NULL,
  `distrito` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `distrito`
--

INSERT INTO `distrito` (`id`, `canton`, `distrito`) VALUES
(1, 1, 'Limón'),
(2, 1, 'Valle la Estrella'),
(3, 1, 'Rio Blanco'),
(4, 1, 'Matama'),
(5, 2, 'Guapiles'),
(6, 2, 'Jimenez'),
(7, 2, 'Rita'),
(8, 2, 'Roxana'),
(9, 2, 'Cariari'),
(10, 2, 'Colorado'),
(11, 3, 'Siquirres'),
(12, 3, 'Pacuarito'),
(13, 3, 'Florida'),
(14, 3, 'Germania'),
(15, 3, 'Cairo'),
(16, 3, 'Alegría'),
(17, 4, 'Bratsi'),
(18, 4, 'Sixaola'),
(19, 4, 'Cahuita'),
(20, 5, 'Matina'),
(21, 5, 'Batan'),
(22, 5, 'Carrandi'),
(23, 6, 'Guacimo'),
(24, 6, 'Mercedes'),
(25, 6, 'Pocora'),
(26, 6, 'Rio Jimenez'),
(27, 6, 'Duacari');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL,
  `accion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `registro` text COLLATE utf8_spanish_ci NOT NULL,
  `navegador` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`id`, `usuario`, `fecha`, `accion`, `registro`, `navegador`, `ip`) VALUES
(6, 'admin', '2018-09-04 19:37:35', 'auth', 'inicio de session', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', '::1'),
(7, 'admin', '2018-09-05 01:44:39', 'auth', 'inicio de session', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

DROP TABLE IF EXISTS `movimientos`;
CREATE TABLE IF NOT EXISTS `movimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `finca` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `movimiento` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametro_inscripcion`
--

DROP TABLE IF EXISTS `parametro_inscripcion`;
CREATE TABLE IF NOT EXISTS `parametro_inscripcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parametro` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `parametro_inscripcion`
--

INSERT INTO `parametro_inscripcion` (`id`, `parametro`) VALUES
(1, '10  años antes de la Ley JAPDEVA'),
(2, 'Posterior a la Ley JAPDEVA '),
(3, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

DROP TABLE IF EXISTS `provincia`;
CREATE TABLE IF NOT EXISTS `provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provincia` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`id`, `provincia`) VALUES
(1, 'San José'),
(2, 'Alajuela'),
(3, 'Cartago'),
(4, 'Heredia'),
(5, 'Guanacaste'),
(6, 'Puntarenas'),
(7, 'Limón');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razon`
--

DROP TABLE IF EXISTS `razon`;
CREATE TABLE IF NOT EXISTS `razon` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `razon` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `razon`
--

INSERT INTO `razon` (`id`, `razon`) VALUES
(1, 'Compraventa'),
(2, 'Informacion posesoria'),
(3, 'Titulación de vivienda campesina'),
(4, 'Segregación de Finca'),
(5, 'Reunión de Fincas'),
(6, 'División material de fincas'),
(7, 'Adjudicación extrajudicional de finca'),
(8, 'Donación'),
(9, 'Bien demanial'),
(11, 'Expropiación'),
(12, 'Otra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `role` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'administrador'),
(2, 'digitador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `password` varbinary(100) NOT NULL,
  `idrole` int(2) NOT NULL,
  PRIMARY KEY (`usuario`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `idrole`) VALUES
(1, 'Japdeva Admin', 'admin', 0x1f8a86e85366b1e834eded3f25d8db50, 1),
(1, 'Juan Perez', 'test', 0x1f8a86e85366b1e834eded3f25d8db50, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
