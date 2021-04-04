-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 12:04 PM
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
-- Dumping data for table `codfono_region`
--

INSERT INTO `codfono_region` (`codfono_id`, `codigo`, `fk_region`, `provincia`) VALUES
(1, '58', 1, 'ARICA Y PARINACOTA'),
(2, '57', 2, 'IQUIQUE Y TAMARUGAL'),
(3, '55', 3, 'ANTOFAGASTA, EL LOA Y TOCOPILLA'),
(4, '52', 4, 'CHAÑARAL Y COPIAPO'),
(5, '51', 5, 'ELQUI'),
(6, '53', 5, 'CHOAPA Y LIMARI'),
(7, '34', 6, 'LOS ANDES Y SAN FELIPE DE ACONCAGUA'),
(8, '33', 6, 'PETORCA Y QUILLOTA'),
(9, '35', 6, 'SAN ANTONIO'),
(10, '02', 7, NULL),
(11, '72', 8, NULL),
(12, '75', 9, 'CURICO'),
(13, '71', 9, 'TALCA'),
(14, '73', 9, 'CAUQUENES Y LINARES'),
(15, '42', 16, 'ÑUBLE'),
(16, '43', 10, 'BIOBIO'),
(17, '45', 11, 'CAUTIN Y MALLECO'),
(18, '63', 12, 'RANCO Y VALDIVIA'),
(19, '64', 13, 'OSORNO'),
(20, '65', 13, 'CHILOE, LLANQUIHUE Y PALENA'),
(30, '67', 14, NULL),
(31, '61', 15, NULL),
(32, '51', 4, 'HUASCO'),
(33, '32', 6, 'PASCUA Y VALPARAISO'),
(34, '39', 6, 'ISLA DE PASCUA'),
(35, '41', 10, 'ARAUCO CONCEPCION'),
(43, '44', 0, 'Telefonía sobre IP'),
(39, '9', 0, 'CELULAR'),
(40, '800', 0, 'CALL CENTER');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
