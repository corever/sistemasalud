-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 12:53 PM
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
-- Dumping data for table `maestro_valores`
--

INSERT INTO `maestro_valores` (`mv_id`, `mv_grupo`, `mv_key`, `mv_value`) VALUES
(1, 0, 1, 'LUNES'),
(2, 0, 2, 'MARTES'),
(3, 0, 3, 'MIERCOLES'),
(4, 0, 4, 'JUEVES'),
(5, 0, 5, 'VIERNES'),
(6, 0, 6, 'SABADO'),
(7, 0, 0, 'DOMINGO'),
(8, 1, 1, 'ENERO'),
(9, 1, 2, 'FEBRERO'),
(10, 1, 3, 'MARZO'),
(11, 1, 4, 'ABRIL'),
(12, 1, 5, 'MAYO'),
(13, 1, 6, 'JUNIO'),
(14, 1, 7, 'JULIO'),
(15, 1, 8, 'AGOSTO'),
(16, 1, 9, 'SEPTIEMBRE'),
(17, 1, 10, 'OCTUBRE'),
(18, 1, 11, 'NOVIEMBRE'),
(19, 1, 12, 'DICIEMBRE');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
