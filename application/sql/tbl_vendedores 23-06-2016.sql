-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-06-2016 a las 16:27:24
-- Versión del servidor: 5.5.49-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `trasladosgdl`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_vendedores`
--

CREATE TABLE IF NOT EXISTS `tbl_vendedores` (
  `IDVENDEDOR` int(11) NOT NULL AUTO_INCREMENT,
  `ID_AGENCIA` int(11) DEFAULT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `APEPAT` varchar(50) NOT NULL,
  `APEMAT` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `TELEFONO` varchar(10) NOT NULL,
  `COMISION` int(11) NOT NULL,
  `FECHA_ALTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`IDVENDEDOR`),
  KEY `ID_AGENCIA` (`ID_AGENCIA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_vendedores`
--
ALTER TABLE `tbl_vendedores`
  ADD CONSTRAINT `tbl_fork_agencia_1` FOREIGN KEY (`ID_AGENCIA`) REFERENCES `tbl_agencia` (`IDAGENCIA`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
