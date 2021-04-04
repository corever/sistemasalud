-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 12:32 PM
-- Server version: 5.1.73-log
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `farmanet`
--

--
-- Dumping data for table `maestro_rol`
--

INSERT INTO `maestro_rol` (`rol_id`, `rol_nombre`, `rol_nombre_header`, `rol_nombre_vista`, `tipo_rol_acceso`, `nr_orden`) VALUES
(1, 'Administrador', 'Administrador', 'Administrador', 0, 3),
(2, 'Encargado Regional', 'Encargado</br>Regional', 'Encargado Regional', 0, 7),
(3, 'Encargado Territorial', 'Encargado</br>Territorial', 'Encargado Territorial', 0, 8),
(4, 'Director Tecnico', 'Director</br>Tecnico', 'Director Técnico', 1, 13),
(5, 'Vendedor Talonario', 'Vendedor</br>Talonario', 'Vendedor Talonario', 0, 9),
(6, 'Quimico Recepcionante', 'Quimico</br>Recepcionante', 'Químico Recepcionante', 1, 14),
(7, 'Quimico trabajador', 'Quimico</br>trabajador', 'Químico trabajador', 1, 17),
(8, 'Administrativo', 'Administrativo', 'Administrativo', 0, 15),
(9, 'Administrador de Maestros', 'Administrador</br>de Maestros', 'Administrador de Maestros', 0, 1),
(10, 'Medico', 'Medico', 'Médico', 1, 16),
(11, 'Nacional', 'Encargado</br>Nacional', 'Encargado Nacional', 0, 2),
(12, 'Secretaria Regional', 'Secretaria</br>Regional', 'Secretaria Regional', 0, 10),
(13, 'Secretaria Territorial', 'Secretaria</br>Territorial', 'Secretaria Territorial', 0, 11),
(14, 'Coordinador Farmacia Nacional', 'Coordinador</br>Farmacia Nacional', 'Coordinador Farmacia Nacional', 1, 12),
(15, 'Coordinador Farmacia Regional', 'Coordinador</br>Farmacia Regional', 'Coordinador Farmacia Regional', 1, 12),
(16, 'Firmante', 'Firmante', 'Firmante', 0, 4),
(17, 'Firmante(s)', 'Firmante(s)', 'Firmante(s)', 0, 5),
(18, 'DT PILOTO', 'Director Tecnico Piloto', 'DT PILOTO', 1, 18),
(19, 'DEIS', 'DEIS', 'DEIS', 1, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
