-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2013 a las 17:59:55
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sistema_concilio`
--
CREATE DATABASE IF NOT EXISTS `sistema_concilio` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `sistema_concilio`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `masters`
--

CREATE TABLE IF NOT EXISTS `masters` (
  `rut` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nick` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`rut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `masters`
--

INSERT INTO `masters` (`rut`, `nombre`, `nick`, `estado`) VALUES
('00000000k', 'dummy', 'dummy', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `value`) VALUES
(1, 'Bienvenidos a Concilio de Dragones XI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE IF NOT EXISTS `mesas` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `cupos` int(11) NOT NULL,
  `cupos_ocupados` int(11) NOT NULL DEFAULT '0',
  `jugadores` varchar(10000) COLLATE utf8_spanish_ci NOT NULL,
  `juego` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `dificultad` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `h_inicio` time DEFAULT NULL,
  `info_extra` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`num`),
  UNIQUE KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`num`, `cupos`, `cupos_ocupados`, `jugadores`, `juego`, `dificultad`, `descripcion`, `ubicacion`, `estado`, `fecha`, `h_inicio`, `info_extra`) VALUES
(1, 5, 0, '', 'Dummy Game', 4, 'Dummy Game for Dummies', 'Dummy Street', 1, '2013-10-13', '22:38:56', 'Mesa de prueba, por si no quedó claro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE IF NOT EXISTS `partidas` (
  `rut_master` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `num_mesa` int(11) NOT NULL,
  PRIMARY KEY (`rut_master`,`num_mesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `partidas`
--

INSERT INTO `partidas` (`rut_master`, `num_mesa`) VALUES
('00000000k', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
