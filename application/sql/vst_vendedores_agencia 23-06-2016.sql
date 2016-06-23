-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-06-2016 a las 16:25:47
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
-- Estructura para la vista `vst_vendedores_agencia`
--

CREATE VIEW `vst_vendedores_agencia` AS select `tbl_agencia`.`NOMBRE` AS `NOMBRE_AGENCIA`,`tbl_agencia`.`TELEFONO` AS `TELEFONO_AGENCIA`,`tbl_agencia`.`EMAIL` AS `EMAIL_AGENCIA`,`tbl_agencia`.`ABREVIACION` AS `ABREVIACION`,`tbl_vendedores`.`FECHA_ALTA` AS `FECHA_ALTA`,`tbl_vendedores`.`IDVENDEDOR` AS `IDVENDEDOR`,concat(`tbl_vendedores`.`NOMBRE`,' ',`tbl_vendedores`.`APEPAT`,' ',`tbl_vendedores`.`APEMAT`) AS `NOMBRE_V`,`tbl_vendedores`.`COMISION` AS `COMISION`,`tbl_vendedores`.`TELEFONO` AS `TELEFONO`,`tbl_vendedores`.`EMAIL` AS `EMAIL` from (`tbl_vendedores` left join `tbl_agencia` on((`tbl_vendedores`.`ID_AGENCIA` = `tbl_agencia`.`IDAGENCIA`))) order by `tbl_agencia`.`ABREVIACION`;

--
-- VIEW  `vst_vendedores_agencia`
-- Datos: Ninguna
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
