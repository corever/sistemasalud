-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 21, 2020 at 02:46 AM
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
-- Dumping data for table `denuncia_farmacia_riesgo`
--

INSERT INTO `denuncia_farmacia_riesgo` (`id`, `gl_riesgo`, `orden`, `fc_creacion`) VALUES
(1, 'No Procede', 0, '2015-07-07 19:49:19'),
(2, 'Bajo', 1, '2015-07-07 19:49:33'),
(3, 'Medio', 2, '2015-07-07 19:49:42'),
(4, 'Alto', 3, '2015-07-07 19:49:54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
