-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 12:35 PM
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
-- Dumping data for table `maestro_usuario`
--

INSERT INTO `maestro_usuario` (`mu_id`, `mu_rut`, `mu_rut_midas`, `mu_pass`, `mu_nombre`, `mu_apellido_paterno`, `mu_apellido_materno`, `mu_correo`, `mu_direccion`, `mu_telefono_codigo`, `mu_telefono`, `mu_fono`, `mu_fono_codigo`, `mu_dir_region`, `mu_dir_comuna`, `mu_fecha_nacimiento`, `mu_genero`, `mu_contrato_trabajo`, `mu_detalle_certificado`, `mu_tipo_certificado`, `mu_estado_sistema`, `carga_masiva`, `usuario_fecha_creacion`, `pass_hab`, `url_avatar`) VALUES
(233, '12.121.121-1', '12121121-1', 'c27d95183ef69345bbf9a80aea66135fd4bc1a90', 'Administrador', 'Farmanet', ' ', 'victor.retamales@redsalud.gob.cl', 'ANTONIO BELLET 77', '', '1346798', '', '', 6, 45, '1985-04-03', 'masculino', '417', '0', '', 0, 0, '2014-07-15 04:00:00', 0, '/profile_big.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
