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
-- Dumping data for table `maestro_modulo`
--

INSERT INTO `maestro_modulo` (`m_m_id`, `nombre_modulo`, `link_modulo`, `img`) VALUES
(1, 'Farmacias', 'farmacias', 'img/icons/sidemenu/image.png'),
(2, 'Recetas', 'recetas', 'img/icons/sidemenu/file_edit.png'),
(3, 'Turnos', 'turnos', 'img/icons/sidemenu/calendar.png'),
(4, 'Local', 'link', 'imgaen'),
(5, 'Talonarios', 'bodegas', 'img/icons/sidemenu/copy.png'),
(6, 'Usuario', 'usuarios', 'img/icons/sidemenu/user.png'),
(7, 'Informes', 'informes', 'img/icons/sidemenu/file.png'),
(8, 'Maestro', 'maestro', 'img/icons/sidemenu/file.png'),
(9, 'Inventario', 'inventario', 'img/icons/sidemenu/inventario.png'),
(10, 'Medico', 'medico', 'img/icons/sidemenu/doctor.png'),
(11, 'Informe Gestión', 'info_gestion', 'img/icons/sidemenu/chart_bar.png'),
(12, 'Alarmas de Fiscalización', 'fiscalizacion', 'img/icons/sidemenu/error.png'),
(13, 'Ayuda', 'ayuda', 'img/icons/sidemenu/help.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
