-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 21, 2020 at 03:02 AM
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
-- Dumping data for table `motivo_inhabilitacion`
--

INSERT INTO `motivo_inhabilitacion` (`motivo_inhabilitacion_id`, `motivo_inhabilitacion_nombre`, `orden`) VALUES
(1, 'Cierre Definitivo', 1),
(2, 'Cierre Temporal', 2),
(3, 'Clausurado', 3),
(5, 'Otro', 5),
(0, '', 0),
(7, 'Prohibición de Funcionamiento', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
