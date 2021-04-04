-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 12:49 PM
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
-- Dumping data for table `maestro_usuario_rol`
--

INSERT INTO `maestro_usuario_rol` (`mur_id`, `mur_fk_usuario`, `mur_fk_rol`, `mur_estado_activado`, `fk_farmacia`, `fk_local`, `fk_bodega`, `mur_fk_region`, `mur_fk_territorio`, `mur_fk_comuna`, `mur_fk_localidad`, `rol_fecha_creacion`, `rol_creador`) VALUES
(10409, 233, 9, 1, 0, 0, 0, 6, 1, 78, 422, '2015-01-16 14:30:47', 0),
(10410, 233, 2, 1, 0, 0, 0, 6, 0, 0, 0, '2015-01-16 14:31:28', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
