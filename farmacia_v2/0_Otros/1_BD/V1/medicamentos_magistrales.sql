-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 12:59 PM
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
-- Dumping data for table `medicamentos_magistrales`
--

INSERT INTO `medicamentos_magistrales` (`id_mg`, `principio_activo`, `codigo`, `unidad_despacho`, `tipo_droga`, `tipo_receta`, `magistral_fecha_creacion`, `magistral_estado`) VALUES
(1, 13, '670004', '1 MG', 'ESTUPEFACIENTE', 1, '2015-01-09 03:00:00', 1),
(2, 39, '670003', '1 MG', 'ESTUPEFACIENTE', 1, '2015-01-09 03:00:00', 1),
(3, 29, '670002', '1 MG', 'ESTUPEFACIENTE', 1, '2015-01-09 03:00:00', 1),
(4, 40, '650023', '1 MG', 'PSICOTROPICO', 1, '2015-01-09 03:00:00', 1),
(6, 41, '650059', '1 MG', 'PSICOTROPICO', 1, '2015-01-09 03:00:00', 1),
(21, 17, '650029', '1 MG', 'PSICOTROPICO', 1, '2014-01-09 03:00:00', 1),
(22, 2, '000000', '1 MG', 'PSICOTROPICO', 2, '2014-01-09 03:00:00', 1),
(23, 4, '000000', '1 MG', 'PSICOTROPICO', 2, '2014-01-09 03:00:00', 1),
(24, 14, '000000', '1 MG', 'PSICOTROPICO', 2, '2014-01-09 03:00:00', 1),
(25, 10, '000000', '1 MG', 'PSICOTROPICO', 2, '2014-01-09 03:00:00', 1),
(7, 13, '670004', '1 MG', 'ESTUPEFACIENTE', 2, '2015-01-09 03:00:00', 1),
(8, 39, '670003', '1 MG', 'ESTUPEFACIENTE', 2, '2015-01-09 03:00:00', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
