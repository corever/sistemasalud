-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 01:00 PM
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
-- Dumping data for table `medicamento_forma_farmaceutica`
--

INSERT INTO `medicamento_forma_farmaceutica` (`m_formaf_id`, `m_formaf_nombre`, `m_formaf_nombre_corto`) VALUES
(1, 'CÁPS.C/MICROGRÁNULOS DE LIBERACIÓN PROLONGADA', 'CP'),
(2, 'CÁPSULAS', 'CP'),
(3, 'CÁPSULAS DE LIBERACIÓN REPETIDA', 'CP'),
(4, 'COMP. RECUBIETOS DE LIBERACIÓN PROLONGADA', 'CM'),
(5, 'COMP.DE LIBERACIÓN PROLONGADA', 'CM'),
(6, 'COMP.RECUB.DE LIBERACIÓN OSMÓTICA PROLONGADA', 'CM'),
(7, 'COMP.RECUB.DE LIBERACIÓN PROLONGADA', 'CM'),
(8, 'COMPRIMIDOS', 'CM'),
(9, 'COMPRIMIDOS DE LIBERACIÓN PROLONGADA', 'CM'),
(10, 'COMPRIMIDOS DISPERSABLES', 'CM'),
(11, 'COMPRIMIDOS LIBERACIÓN PROLONGADA', 'CM'),
(12, 'COMPRIMIDOS RECUBIERTOS', 'CM'),
(13, 'COMPRIMIDOS RECUBIERTOS DE LIBERACIÓN PROLONGADA', 'CM'),
(14, 'COMPRIMIDOS SUBLINGUALES', 'CM'),
(15, 'LIOFILIZADO P/SOLUCIÓN INYEC-     TABLE   FCO-AMPOLLAS', 'FA'),
(16, 'LIOFILIZADO P/SOLUCIÓN INYECTABLE - FCO-AMPOLLAS', 'FA'),
(17, 'SIST. TERAPÉUTICO TRANS-DÉRMICO 35MCG/HR - PARCHES', 'UD'),
(18, 'SIST.TERAPÉUT.TRANSDÉRMICO MATRICIAL 25 MCG/DOSIS - PARCHES', 'UD'),
(19, 'SIST.TERAPÉUT.TRANSDÉRMICO MATRICIAL 50 MCG/DOSIS - PARCHES', 'UD'),
(20, 'SOLUC. ORAL  P/GOTAS ', 'FC'),
(21, 'SOLUCIÓN INYECTABLE - AMPOLLA', 'AM'),
(22, 'SOLUCIÓN INYECTABLE - AMPOLLAS', 'AM'),
(23, 'SOLUCIÓN INYECTABLE - FCO-AMP.', 'FA'),
(24, 'SOLUCIÓN INYECTABLE -AMPOLLA', 'AM'),
(25, 'SOLUCIÓN INYECTABLE -AMPOLLAS', 'AM'),
(26, 'SOLUCIÓN INYECTABLE -FRASCO-AMPOLLA', 'FA'),
(27, 'SOLUCIÓN INYECTABLE-AMPOLLAS', 'AM'),
(28, 'SOLUCIÓN ORAL', 'FC'),
(29, 'SOLUCIÓN ORAL PARA GOTAS ', 'FC');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
