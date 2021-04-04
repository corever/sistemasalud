-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 11:58 AM
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
CREATE DATABASE IF NOT EXISTS `farmanet` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `farmanet`;

-- --------------------------------------------------------

--
-- Table structure for table `acceso_restringido`
--

CREATE TABLE IF NOT EXISTS `acceso_restringido` (
  `ar_id` int(11) NOT NULL AUTO_INCREMENT,
  `ar_fk_usuario` int(11) NOT NULL,
  `ar_fk_rol` int(11) NOT NULL,
  `ar_url` varchar(255) NOT NULL,
  `ar_fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ar_id`),
  KEY `ar_fk_usuario` (`ar_fk_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1379 ;

-- --------------------------------------------------------

--
-- Table structure for table `acceso_restringido_mapa`
--

CREATE TABLE IF NOT EXISTS `acceso_restringido_mapa` (
  `id_acceso` int(11) NOT NULL AUTO_INCREMENT,
  `gl_evento` varchar(250) NOT NULL,
  `user_agent` varchar(500) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `last_activity` varchar(255) NOT NULL,
  `ip_privada` varchar(50) NOT NULL,
  `ip_publica` varchar(50) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_acceso`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4200 ;

-- --------------------------------------------------------

--
-- Table structure for table `analytic_turnosdefarmacia`
--

CREATE TABLE IF NOT EXISTS `analytic_turnosdefarmacia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(1) NOT NULL DEFAULT '1' COMMENT '1=Todos, 2= Unicos, 3=Region',
  `fk_region` int(11) NOT NULL DEFAULT '0',
  `ingresos` int(11) NOT NULL,
  `fc_data` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_region` (`fk_region`),
  KEY `fc_data` (`fc_data`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6468 ;

-- --------------------------------------------------------

--
-- Table structure for table `asignacion_medicamento_receta`
--

CREATE TABLE IF NOT EXISTS `asignacion_medicamento_receta` (
  `medicamento_receta_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_id_medicamento` int(11) NOT NULL,
  `fk_id_receta` int(11) NOT NULL,
  PRIMARY KEY (`medicamento_receta_id`),
  KEY `fk_id_medicamento` (`fk_id_medicamento`),
  KEY `fk_id_receta` (`fk_id_receta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Asignacion_talonario`
--

CREATE TABLE IF NOT EXISTS `Asignacion_talonario` (
  `asignacion_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_talonario` int(11) DEFAULT NULL,
  `folio_inicial` varchar(200) NOT NULL,
  `bodega_central` int(11) DEFAULT '0',
  `bodega_int` int(11) DEFAULT '0',
  `local_ven` int(11) DEFAULT '0',
  `fecha_asig_bc` date DEFAULT NULL,
  `fecha_asig_bi` date DEFAULT NULL,
  `fecha_asig_lv` date DEFAULT NULL,
  `estado_talonario` int(11) NOT NULL DEFAULT '0',
  `estado_talonario_bi` int(11) NOT NULL DEFAULT '0',
  `estado_talonario_lv` int(11) NOT NULL DEFAULT '0',
  `Venta` int(11) NOT NULL DEFAULT '0' COMMENT 'vendido o no',
  PRIMARY KEY (`asignacion_id`),
  KEY `fk_talonario` (`fk_talonario`),
  KEY `bodega_central` (`bodega_central`),
  KEY `bodega_int` (`bodega_int`),
  KEY `local_ven` (`local_ven`),
  KEY `folio_inicial` (`folio_inicial`),
  KEY `Venta` (`Venta`),
  KEY `fecha_asig_bc` (`fecha_asig_bc`),
  KEY `fecha_asig_bi` (`fecha_asig_bi`),
  KEY `fecha_asig_lv` (`fecha_asig_lv`),
  KEY `estado_talonario` (`estado_talonario`),
  KEY `estado_talonario_bi` (`estado_talonario_bi`),
  KEY `estado_talonario_lv` (`estado_talonario_lv`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=177428 ;

-- --------------------------------------------------------

--
-- Table structure for table `auditoria`
--

CREATE TABLE IF NOT EXISTS `auditoria` (
  `id_auditoria` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `gl_query` longtext NOT NULL,
  `gl_tipo` varchar(255) NOT NULL,
  `ip_privada` varchar(50) NOT NULL,
  `ip_publica` varchar(50) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_auditoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bodega`
--

CREATE TABLE IF NOT EXISTS `bodega` (
  `bodega_id` int(11) NOT NULL AUTO_INCREMENT,
  `bodega_nombre` varchar(255) NOT NULL,
  `bodega_direccion` varchar(255) NOT NULL,
  `fk_region` int(11) NOT NULL,
  `fk_territorio` int(11) NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `fk_localidad` int(11) DEFAULT NULL,
  `bodega_id_usuario` int(30) NOT NULL,
  `bodega_telefono` varchar(12) DEFAULT NULL,
  `bodega_fono` varchar(50) NOT NULL,
  `bodega_fono_codigo` varchar(11) NOT NULL,
  `bodega_estado` tinyint(1) NOT NULL,
  `fk_bodega_tipo` int(1) NOT NULL,
  PRIMARY KEY (`bodega_id`),
  KEY `fk_region` (`fk_region`),
  KEY `fk_localidad` (`fk_localidad`),
  KEY `bodega_id_usuario` (`bodega_id_usuario`),
  KEY `fk_bodega_tipo` (`fk_bodega_tipo`),
  KEY `fk_comuna` (`fk_comuna`),
  KEY `fk_territorio` (`fk_territorio`),
  KEY `bodega_estado` (`bodega_estado`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Table structure for table `bodega_local_stock`
--

CREATE TABLE IF NOT EXISTS `bodega_local_stock` (
  `stock_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_local` int(11) NOT NULL,
  PRIMARY KEY (`stock_id`),
  KEY `fk_local` (`fk_local`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5938 ;

-- --------------------------------------------------------

--
-- Table structure for table `bodega_tipo`
--

CREATE TABLE IF NOT EXISTS `bodega_tipo` (
  `bodega_tipo_id` int(11) NOT NULL AUTO_INCREMENT,
  `bodega_tipo_nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`bodega_tipo_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `codfono_region`
--

CREATE TABLE IF NOT EXISTS `codfono_region` (
  `codfono_id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(11) NOT NULL COMMENT 'codigo area telefonico',
  `fk_region` int(11) NOT NULL COMMENT 'region corresponde',
  `provincia` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codfono_id`),
  KEY `fk_region` (`fk_region`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `comuna`
--

CREATE TABLE IF NOT EXISTS `comuna` (
  `comuna_id` int(11) NOT NULL AUTO_INCREMENT,
  `comuna_nombre` varchar(80) NOT NULL,
  `fk_territorio` int(11) DEFAULT NULL COMMENT 'enlace te',
  `fk_region` int(11) NOT NULL,
  `fk_region_midas` int(11) NOT NULL,
  `id_comuna_midas` int(11) NOT NULL,
  `id_comuna_emergencia` int(11) DEFAULT NULL,
  `cod_minsal` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`comuna_id`),
  KEY `fk_territorio` (`fk_territorio`),
  KEY `fk_region` (`fk_region`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=350 ;

-- --------------------------------------------------------

--
-- Table structure for table `denuncia_farmacia`
--

CREATE TABLE IF NOT EXISTS `denuncia_farmacia` (
  `oirs_id` int(11) NOT NULL AUTO_INCREMENT,
  `oirs_motivo` int(10) NOT NULL,
  `denunciante_nombre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `denunciante_apellido_p` varchar(100) CHARACTER SET utf8 NOT NULL,
  `denunciante_apellido_m` varchar(100) NOT NULL,
  `denunciante_rut` varchar(20) CHARACTER SET utf8 NOT NULL,
  `denunciante_rut_midas` varchar(20) NOT NULL,
  `denunciante_nacimiento` date NOT NULL,
  `denunciante_correo` varchar(100) CHARACTER SET utf8 NOT NULL,
  `oirs_region` int(10) NOT NULL,
  `oirs_comuna` int(10) NOT NULL,
  `oirs_local` int(11) NOT NULL,
  `oirs_comentario` varchar(1000) NOT NULL,
  `fecha_denuncia` date NOT NULL,
  `denuncia_resuelta` int(11) NOT NULL DEFAULT '0',
  `fk_responsable_respuesta` int(11) DEFAULT NULL,
  `comentario_respuesta` varchar(1000) DEFAULT NULL,
  `fecha_registro_respuesta` datetime DEFAULT NULL,
  `origen_denuncia` int(1) NOT NULL DEFAULT '0' COMMENT '0=Farmanet; 1=OIRS',
  `fk_riesgo` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`oirs_id`),
  KEY `oirs_motivo` (`oirs_motivo`),
  KEY `denunciante_rut_midas` (`denunciante_rut_midas`),
  KEY `oirs_region` (`oirs_region`),
  KEY `oirs_comuna` (`oirs_comuna`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1625 ;

-- --------------------------------------------------------

--
-- Table structure for table `denuncia_farmacia_estados`
--

CREATE TABLE IF NOT EXISTS `denuncia_farmacia_estados` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado_denuncia` varchar(100) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `denuncia_farmacia_obs`
--

CREATE TABLE IF NOT EXISTS `denuncia_farmacia_obs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_responsable` int(11) NOT NULL,
  `fk_denuncia` int(11) NOT NULL,
  `fk_estado` int(11) DEFAULT NULL,
  `observacion` varchar(1000) NOT NULL,
  `adjunto` varchar(120) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_responsable` (`fk_responsable`),
  KEY `fk_denuncia` (`fk_denuncia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Table structure for table `denuncia_farmacia_reclamo`
--

CREATE TABLE IF NOT EXISTS `denuncia_farmacia_reclamo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_oirs` int(11) NOT NULL,
  `tipo_motivo` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` varchar(100) DEFAULT NULL,
  `medicamento` varchar(300) NOT NULL,
  `iffarmacia` tinyint(1) NOT NULL COMMENT 'flag si fue a otra farmacia',
  `local_vecino` int(11) DEFAULT NULL COMMENT 'si fue a otra farmacia, indica cual de su misma localidad',
  PRIMARY KEY (`id`,`fk_oirs`),
  KEY `fk_oirs` (`fk_oirs`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1005 ;

-- --------------------------------------------------------

--
-- Table structure for table `denuncia_farmacia_riesgo`
--

CREATE TABLE IF NOT EXISTS `denuncia_farmacia_riesgo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gl_riesgo` varchar(100) NOT NULL,
  `orden` int(1) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `Desasignacion_talonario`
--

CREATE TABLE IF NOT EXISTS `Desasignacion_talonario` (
  `desasignacion_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_talonario` int(11) DEFAULT NULL,
  `bodega_central` int(11) DEFAULT NULL,
  `bodega_int` int(11) DEFAULT NULL,
  `local_ven` int(11) DEFAULT NULL,
  `fecha_devo_bc` date DEFAULT NULL,
  `fecha_devo_bi` date DEFAULT NULL,
  `fecha_devo_lv` date DEFAULT NULL,
  `estado_talonario` int(11) NOT NULL DEFAULT '0',
  `estado_talonario_bi` int(11) NOT NULL DEFAULT '0',
  `estado_talonario_lv` int(11) NOT NULL DEFAULT '0',
  `Venta` int(11) NOT NULL DEFAULT '0' COMMENT 'vendido o no',
  PRIMARY KEY (`desasignacion_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=177378 ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_hoja_libro`
--

CREATE TABLE IF NOT EXISTS `detalle_hoja_libro` (
  `id_registro_hoja` int(100) NOT NULL AUTO_INCREMENT,
  `fecha_receta` date NOT NULL DEFAULT '0000-00-00',
  `fecha_ingreso_receta` date NOT NULL DEFAULT '0000-00-00',
  `cantidad_receta` int(100) NOT NULL DEFAULT '0',
  `medicamento` int(100) NOT NULL DEFAULT '0',
  `tipo_medicamento` int(100) NOT NULL DEFAULT '0',
  `serie` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `folio` int(100) NOT NULL DEFAULT '0',
  `fk_medico` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `rut_paciente` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `rut_paciente_midas` varchar(20) NOT NULL,
  `nombre_paciente` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `domicilio_paciente` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `rut_adquiriente` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `rut_adquiriente_midas` varchar(20) NOT NULL,
  `nombre_adquiriente` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `numero_factura` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `fecha_factura` date NOT NULL DEFAULT '0000-00-00',
  `fecha_ingreso_f` date NOT NULL DEFAULT '0000-00-00',
  `proveedor_factura` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `razon_factura` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `cantidad_factura` int(100) NOT NULL DEFAULT '0',
  `fk_folio_libro` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `tipo_receta` int(11) NOT NULL DEFAULT '0',
  `tipo_registro` enum('egreso','ingreso') NOT NULL,
  `cantidad_mbodega` int(100) NOT NULL,
  PRIMARY KEY (`id_registro_hoja`),
  KEY `fecha_receta` (`fecha_receta`),
  KEY `medicamento` (`medicamento`),
  KEY `folio` (`folio`),
  KEY `serie` (`serie`),
  KEY `fk_medico` (`fk_medico`),
  KEY `rut_paciente_midas` (`rut_paciente_midas`),
  KEY `rut_adquiriente_midas` (`rut_adquiriente_midas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_local_stock`
--

CREATE TABLE IF NOT EXISTS `detalle_local_stock` (
  `stock_d_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_stock` int(11) NOT NULL,
  `stock_d_medicamento` int(11) NOT NULL,
  `stock_d_cantidad` int(11) NOT NULL,
  `stock_d_unidad` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `stock_d_tipo` int(11) NOT NULL,
  PRIMARY KEY (`stock_d_id`),
  KEY `fk_stock` (`fk_stock`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_receta_sd`
--

CREATE TABLE IF NOT EXISTS `detalle_receta_sd` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `fk_receta` int(11) NOT NULL,
  `fk_medicamento` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `fk_receta` (`fk_receta`),
  KEY `fk_medicamento` (`fk_medicamento`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

--
-- Table structure for table `director_tecnico`
--

CREATE TABLE IF NOT EXISTS `director_tecnico` (
  `DT_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_local` int(11) NOT NULL,
  `fk_usuario` int(11) NOT NULL,
  `direccion_fecha_inicio` date NOT NULL,
  `direccion_fecha_termino` date NOT NULL,
  `estado` int(1) NOT NULL,
  `dt_fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`DT_id`),
  KEY `fk_local` (`fk_local`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `direccion_fecha_inicio` (`direccion_fecha_inicio`),
  KEY `estado` (`estado`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9131 ;

-- --------------------------------------------------------

--
-- Table structure for table `director_tecnico_activar`
--

CREATE TABLE IF NOT EXISTS `director_tecnico_activar` (
  `dta_id` int(11) NOT NULL AUTO_INCREMENT,
  `dta_fk_local` int(11) NOT NULL,
  `dta_fk_usuario` int(11) NOT NULL,
  `dta_fk_dt` int(11) NOT NULL,
  `dta_fk_mur_id` int(11) NOT NULL,
  `dta_fc_cambio_estado` date NOT NULL,
  `dta_estado` int(1) NOT NULL DEFAULT '0' COMMENT '0=Inactivar 1=Activar',
  `dta_fk_cron` int(11) NOT NULL DEFAULT '0',
  `dta_fk_usuario_creador` int(11) NOT NULL,
  `dta_fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dta_id`),
  KEY `dta_fk_local` (`dta_fk_local`),
  KEY `dta_fk_usuario` (`dta_fk_usuario`),
  KEY `dta_fk_cron` (`dta_fk_cron`),
  KEY `dta_fk_usuario_creador` (`dta_fk_usuario_creador`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=243 ;

-- --------------------------------------------------------

--
-- Table structure for table `director_tecnico_cron`
--

CREATE TABLE IF NOT EXISTS `director_tecnico_cron` (
  `dtc_id` int(11) NOT NULL AUTO_INCREMENT,
  `dtc_fk_usuario` int(11) NOT NULL COMMENT 'Usuario que activa el cron',
  `dtc_cant_dt_activar` int(11) NOT NULL COMMENT 'Cantidad de DT activados de esta forma',
  `dtc_cant_dt_desactivar` int(11) NOT NULL,
  `dtc_fc_cambio_estado` date NOT NULL,
  `dtc_fc_activacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dtc_id`),
  KEY `dtc_fk_usuario` (`dtc_fk_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1776 ;

-- --------------------------------------------------------

--
-- Table structure for table `documento_tipo`
--

CREATE TABLE IF NOT EXISTS `documento_tipo` (
  `documento_tipo_id` int(5) NOT NULL AUTO_INCREMENT,
  `documento_tipo_nombre` varchar(80) NOT NULL,
  `documento_tipo_contenido` text NOT NULL,
  `documento_tipo_descripcion` varchar(120) DEFAULT NULL,
  `documento_tipo_version` int(3) DEFAULT NULL,
  `fk_usuario_creador` int(11) DEFAULT NULL,
  `documento_tipo_fecha_creacion` datetime NOT NULL,
  `documento_tipo_fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`documento_tipo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `documento_tipo_historial`
--

CREATE TABLE IF NOT EXISTS `documento_tipo_historial` (
  `documento_tipo_historial_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_documento_tipo` enum('Trimestre','Especifica','Urgencia') DEFAULT NULL,
  `documento_tipo_historial_contenido` text,
  `documento_tipo_historial_fecha_ini` datetime DEFAULT NULL,
  `documento_tipo_historial_fecha_ter` datetime DEFAULT NULL,
  `fk_local` int(11) NOT NULL,
  `fk_region` int(11) DEFAULT NULL,
  `fk_comuna` int(11) DEFAULT NULL,
  `fk_localidad` int(11) DEFAULT NULL,
  `documento_tipo_historial_fecha_emision` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `texto_horario` text,
  `fk_usuario_ingreso` int(11) NOT NULL,
  PRIMARY KEY (`documento_tipo_historial_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=219 ;

-- --------------------------------------------------------

--
-- Table structure for table `documento_tipo_temporal`
--

CREATE TABLE IF NOT EXISTS `documento_tipo_temporal` (
  `dte_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_local` int(11) NOT NULL,
  `fk_localidad` int(11) NOT NULL,
  `dte_fecha_ini` date NOT NULL,
  `dte_fecha_ter` date NOT NULL,
  `texto_horario` varchar(500) NOT NULL,
  `documento_tipo` varchar(30) NOT NULL DEFAULT 'ESPECIFICO',
  PRIMARY KEY (`dte_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

--
-- Table structure for table `ejercicio_quimico`
--

CREATE TABLE IF NOT EXISTS `ejercicio_quimico` (
  `ejercicio_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_local` int(11) NOT NULL,
  `fk_quimico` int(11) NOT NULL,
  `ejercicio_reemplazo` tinyint(1) NOT NULL,
  `ejercicio_dia` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') NOT NULL,
  `ejercicio_hora_inicio` time NOT NULL,
  `ejercicio_hora_termino` time NOT NULL,
  `ejercicio_fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ejercicio_id`),
  KEY `fk_local` (`fk_local`),
  KEY `fk_quimico` (`fk_quimico`),
  KEY `ejercicio_hora_inicio` (`ejercicio_hora_inicio`),
  KEY `ejercicio_hora_termino` (`ejercicio_hora_termino`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1360 ;

-- --------------------------------------------------------

--
-- Table structure for table `estados_mesa_ayuda`
--

CREATE TABLE IF NOT EXISTS `estados_mesa_ayuda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_estado` int(11) NOT NULL,
  `nombre_estado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`cod_estado`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `farmacia`
--

CREATE TABLE IF NOT EXISTS `farmacia` (
  `farmacia_id` int(11) NOT NULL AUTO_INCREMENT,
  `farmacia_rut` varchar(20) NOT NULL,
  `farmacia_rut_midas` varchar(20) NOT NULL,
  `farmacia_razon_social` varchar(1000) NOT NULL,
  `farmacia_nombre_fantasia` varchar(1000) DEFAULT NULL,
  `farmacia_nombre_representante` varchar(100) NOT NULL,
  `farmacia_rut_representante` varchar(20) NOT NULL,
  `farmacia_rut_representante_midas` varchar(20) NOT NULL,
  `farmacia_nombre_representante_ti` varchar(100) DEFAULT NULL,
  `farmacia_telefono_representante_ti` varchar(60) DEFAULT NULL,
  `farmacia_fono_codigo_ti` varchar(11) NOT NULL,
  `farmacia_fono_ti` varchar(50) NOT NULL,
  `farmacia_correo_representante_ti` varchar(50) DEFAULT NULL,
  `farmacia_direccion` text NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `fk_region` int(11) NOT NULL,
  `farmacia_telefono` varchar(60) DEFAULT NULL,
  `farmacia_fono_codigo` varchar(11) NOT NULL,
  `farmacia_fono` varchar(50) NOT NULL,
  `farmacia_caracter` enum('nacional','regional','independiente','inter-regional') NOT NULL,
  `farmacia_tipo` enum('farmacia_privada','farmacia_asistencial_publica','farmacia_asistencial_privada','botiquin_publico','botiquin_privado') NOT NULL,
  `farmacia_estado` tinyint(1) NOT NULL,
  `farmacia_motivo_deshabilitacion` varchar(256) NOT NULL,
  `farmacia_fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_cadena_acceso` varchar(100) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`farmacia_id`),
  KEY `fk_region` (`fk_region`),
  KEY `fk_comuna` (`fk_comuna`),
  KEY `farmacia_rut_midas` (`farmacia_rut_midas`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2959 ;

-- --------------------------------------------------------

--
-- Table structure for table `feriado`
--

CREATE TABLE IF NOT EXISTS `feriado` (
  `feriado_id` int(11) NOT NULL AUTO_INCREMENT,
  `feriado_dia` date NOT NULL,
  `Irrenunciable` int(1) NOT NULL DEFAULT '0' COMMENT '0=NO; 1=SI',
  `fk_usuario` int(11) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`feriado_id`),
  KEY `feriado_dia` (`feriado_dia`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

-- --------------------------------------------------------

--
-- Table structure for table `historial_cron_dt`
--

CREATE TABLE IF NOT EXISTS `historial_cron_dt` (
  `id_cron` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id_cron`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `libro_medicamento`
--

CREATE TABLE IF NOT EXISTS `libro_medicamento` (
  `libro_id` int(100) NOT NULL AUTO_INCREMENT,
  `fecha_insert_hoja` date NOT NULL,
  `fk_bodega_local` int(100) NOT NULL,
  `medicamento` int(100) NOT NULL,
  `tipo_medicamento` int(100) NOT NULL,
  `numero_hoja` int(100) NOT NULL,
  `cantidad_hoja` int(100) NOT NULL,
  `codigo_folio` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`libro_id`),
  KEY `fecha_insert_hoja` (`fecha_insert_hoja`),
  KEY `fk_bodega_local` (`fk_bodega_local`),
  KEY `medicamento` (`medicamento`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `lista_negra`
--

CREATE TABLE IF NOT EXISTS `lista_negra` (
  `lista_negra_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_talonario` int(11) DEFAULT NULL,
  `fk_medico` int(11) NOT NULL COMMENT 'id Usuario Medico',
  `lista_negra_serie` varchar(10) NOT NULL,
  `lista_negra_numero` int(11) NOT NULL,
  `lista_negra_tipo_ingreso` text NOT NULL,
  `lista_negra_motivo` text NOT NULL,
  `denuncia_valida` tinyint(1) NOT NULL,
  `fk_usuario_valida` int(11) NOT NULL,
  `denuncia_fecha` date NOT NULL,
  `denuncia_region` int(11) NOT NULL,
  `denuncia_usuario` int(11) NOT NULL,
  `fecha_actividad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`lista_negra_id`),
  KEY `fk_talonario` (`fk_talonario`),
  KEY `denuncia_region` (`denuncia_region`),
  KEY `fk_medico` (`fk_medico`),
  KEY `fk_usuario_valida` (`fk_usuario_valida`),
  KEY `denuncia_usuario` (`denuncia_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `local`
--

CREATE TABLE IF NOT EXISTS `local` (
  `local_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_farmacia` int(11) NOT NULL,
  `ordenamiento` int(255) DEFAULT NULL,
  `local_numero` varchar(10) NOT NULL,
  `local_nombre` varchar(150) NOT NULL,
  `local_direccion` text NOT NULL,
  `local_lat` varchar(32) NOT NULL,
  `local_lng` varchar(32) NOT NULL,
  `local_impide_turnos` tinyint(1) DEFAULT NULL,
  `local_telefono` varchar(60) DEFAULT NULL,
  `local_fono_codigo` varchar(11) NOT NULL,
  `local_fono` varchar(50) NOT NULL,
  `fk_localidad` int(11) NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `fk_region` int(11) NOT NULL,
  `fk_local_tipo` int(11) NOT NULL,
  `local_numero_resolucion` int(11) NOT NULL,
  `local_fecha_resolucion` date NOT NULL,
  `local_tipo_alopatica` tinyint(1) DEFAULT '0',
  `local_tipo_homeopatica` tinyint(1) DEFAULT '0',
  `local_tipo_movil` tinyint(1) DEFAULT '0',
  `local_tipo_urgencia` tinyint(1) DEFAULT '0',
  `local_estado` tinyint(1) NOT NULL,
  `fecha_cambio_estado` date DEFAULT NULL,
  `local_motivo_deshabilitacion` int(11) NOT NULL DEFAULT '0',
  `local_tipo_franquicia` tinyint(4) DEFAULT NULL,
  `local_detalle_deshabilitacion` varchar(300) NOT NULL,
  `local_recetario` tinyint(1) NOT NULL,
  `local_tiene_recetario` int(1) NOT NULL DEFAULT '0' COMMENT '1=si',
  `local_recetario_tipo` enum('NOSELECCIONADO','CENTRALIZADO','INDEPENDIENTE','CONVENIO') NOT NULL,
  `local_recetario_fk_detalle` varchar(100) NOT NULL DEFAULT '0:0:0:0:0:0:0:0:0:0:0',
  `local_preparacion_solidos` tinyint(1) NOT NULL,
  `local_preparacion_liquidos` tinyint(1) NOT NULL,
  `local_preparacion_esteriles` tinyint(1) NOT NULL,
  `local_preparacion_cosmeticos` tinyint(1) NOT NULL,
  `local_preparacion_homeopaticos` tinyint(1) NOT NULL,
  `local_fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `local_fecha_edicion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `resolucion_url` varchar(200) NOT NULL,
  `activa_mapa` int(1) NOT NULL,
  `factor_riesgo` enum('Alto','Mediano','Bajo') NOT NULL,
  `rakin_numero` varchar(100) NOT NULL,
  `ip_cadena_acceso` varchar(100) NOT NULL DEFAULT '0.0.0.0',
  `key_local` varchar(200) NOT NULL,
  `gl_codigo_midas` varchar(200) NOT NULL,
  PRIMARY KEY (`local_id`),
  KEY `fk_local_tipo` (`fk_local_tipo`),
  KEY `fk_farmacia` (`fk_farmacia`),
  KEY `fk_localidad` (`fk_localidad`),
  KEY `fk_region` (`fk_region`),
  KEY `fk_comuna` (`fk_comuna`),
  KEY `local_tipo_urgencia` (`local_tipo_urgencia`),
  KEY `activa_mapa` (`activa_mapa`),
  KEY `ip_cadena_acceso` (`ip_cadena_acceso`),
  KEY `local_estado` (`local_estado`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6403 ;

-- --------------------------------------------------------

--
-- Table structure for table `local2`
--

CREATE TABLE IF NOT EXISTS `local2` (
  `local_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_farmacia` int(11) NOT NULL,
  `ordenamiento` int(255) DEFAULT NULL,
  `local_numero` varchar(10) NOT NULL,
  `local_nombre` varchar(150) NOT NULL,
  `local_direccion` text NOT NULL,
  `local_lat` varchar(32) NOT NULL,
  `local_lng` varchar(32) NOT NULL,
  `local_impide_turnos` tinyint(1) DEFAULT NULL,
  `local_telefono` varchar(60) DEFAULT NULL,
  `local_fono_codigo` varchar(11) NOT NULL,
  `local_fono` varchar(50) NOT NULL,
  `fk_localidad` int(11) NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `fk_region` int(11) NOT NULL,
  `fk_local_tipo` int(11) NOT NULL,
  `local_numero_resolucion` int(11) NOT NULL,
  `local_fecha_resolucion` date NOT NULL,
  `local_tipo_alopatica` tinyint(1) DEFAULT '0',
  `local_tipo_homeopatica` tinyint(1) DEFAULT '0',
  `local_tipo_movil` tinyint(1) DEFAULT '0',
  `local_tipo_urgencia` tinyint(1) DEFAULT '0',
  `local_estado` tinyint(1) NOT NULL,
  `fecha_cambio_estado` date DEFAULT NULL,
  `local_motivo_deshabilitacion` int(11) NOT NULL DEFAULT '0',
  `local_tipo_franquicia` tinyint(4) DEFAULT NULL,
  `local_detalle_deshabilitacion` varchar(300) NOT NULL,
  `local_recetario` tinyint(1) NOT NULL,
  `local_tiene_recetario` int(1) NOT NULL DEFAULT '0' COMMENT '1=si',
  `local_recetario_tipo` enum('NOSELECCIONADO','CENTRALIZADO','INDEPENDIENTE','CONVENIO') NOT NULL,
  `local_recetario_fk_detalle` varchar(100) NOT NULL DEFAULT '0:0:0:0:0:0:0:0:0:0:0',
  `local_preparacion_solidos` tinyint(1) NOT NULL,
  `local_preparacion_liquidos` tinyint(1) NOT NULL,
  `local_preparacion_esteriles` tinyint(1) NOT NULL,
  `local_preparacion_cosmeticos` tinyint(1) NOT NULL,
  `local_preparacion_homeopaticos` tinyint(1) NOT NULL,
  `local_fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `local_fecha_edicion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `resolucion_url` varchar(200) NOT NULL,
  `activa_mapa` int(1) NOT NULL,
  `factor_riesgo` enum('Alto','Mediano','Bajo') NOT NULL,
  `rakin_numero` varchar(100) NOT NULL,
  `ip_cadena_acceso` varchar(100) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`local_id`),
  KEY `fk_local_tipo` (`fk_local_tipo`),
  KEY `fk_farmacia` (`fk_farmacia`),
  KEY `fk_localidad` (`fk_localidad`),
  KEY `fk_region` (`fk_region`),
  KEY `fk_comuna` (`fk_comuna`),
  KEY `local_tipo_urgencia` (`local_tipo_urgencia`),
  KEY `activa_mapa` (`activa_mapa`),
  KEY `ip_cadena_acceso` (`ip_cadena_acceso`),
  KEY `local_estado` (`local_estado`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4626 ;

-- --------------------------------------------------------

--
-- Table structure for table `localidad`
--

CREATE TABLE IF NOT EXISTS `localidad` (
  `localidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `localidad_nombre` varchar(80) NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `estado_activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`localidad_id`),
  KEY `fk_comuna` (`fk_comuna`),
  KEY `estado_activo` (`estado_activo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=515 ;

-- --------------------------------------------------------

--
-- Table structure for table `local_cron`
--

CREATE TABLE IF NOT EXISTS `local_cron` (
  `local_cron_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_usuario` int(11) NOT NULL,
  `cant_habilitar` int(11) NOT NULL,
  `cant_inhabilitar` int(11) NOT NULL,
  `fc_cambio_estado` date NOT NULL,
  `fc_activacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`local_cron_id`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1658 ;

-- --------------------------------------------------------

--
-- Table structure for table `local_estado`
--

CREATE TABLE IF NOT EXISTS `local_estado` (
  `local_estado_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_local` int(11) NOT NULL,
  `fc_inicio` date NOT NULL COMMENT 'Fecha Inhabilitacion',
  `fc_termino` date NOT NULL COMMENT 'Fecha Habilitacion',
  `estado` int(11) NOT NULL COMMENT '0=Inhabilitado; 1=Habilitado',
  `motivo` int(11) NOT NULL,
  `detalle` varchar(255) NOT NULL,
  `estado_cron_inhabilitar` int(1) NOT NULL DEFAULT '0' COMMENT '0= sin CRON; 1= para CRON; 2=Trabajado por CRON; 3=Reemplazado',
  `fk_cron_inhabilitar` int(11) NOT NULL,
  `estado_cron_habilitar` int(1) NOT NULL DEFAULT '0' COMMENT '0= sin CRON; 1= para CRON; 2=Trabajado por CRON; 3=Reemplazado',
  `fk_cron_habilitar` int(11) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_usuario` int(11) NOT NULL COMMENT 'Usuario Creador',
  PRIMARY KEY (`local_estado_id`),
  KEY `fk_local` (`fk_local`),
  KEY `estado` (`estado`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1455 ;

-- --------------------------------------------------------

--
-- Table structure for table `local_estado_turno`
--

CREATE TABLE IF NOT EXISTS `local_estado_turno` (
  `id_local_estado` int(11) NOT NULL AUTO_INCREMENT,
  `fk_local` int(11) NOT NULL,
  `fk_turno` int(11) NOT NULL,
  `estado` int(1) NOT NULL COMMENT '0=Inhabilitado ; 1=habilitado',
  `fecha_cambio_estado` date NOT NULL,
  PRIMARY KEY (`id_local_estado`),
  KEY `fk_local` (`fk_local`),
  KEY `fk_turno` (`fk_turno`),
  KEY `estado` (`estado`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Estado del local para entrar en algoritmo' AUTO_INCREMENT=413 ;

-- --------------------------------------------------------

--
-- Table structure for table `local_funcionamiento`
--

CREATE TABLE IF NOT EXISTS `local_funcionamiento` (
  `fk_local` int(11) NOT NULL,
  `funcionamiento_dia` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo','festivo') NOT NULL,
  `funcionamiento_continuado` tinyint(1) NOT NULL DEFAULT '1',
  `funcionamiento_hora_apertura` time NOT NULL,
  `funcionamiento_siesta_inicio` time NOT NULL DEFAULT '00:00:00',
  `funcionamiento_siesta_termino` time NOT NULL DEFAULT '00:00:00',
  `funcionamiento_hora_cierre` time NOT NULL,
  `funcionamiento_orden` int(11) NOT NULL,
  PRIMARY KEY (`fk_local`,`funcionamiento_dia`),
  KEY `fk_local` (`fk_local`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `local_recetario_detalle`
--

CREATE TABLE IF NOT EXISTS `local_recetario_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gl_nombre_tipo` varchar(255) NOT NULL,
  `gl_nombre_tipoa` varchar(255) NOT NULL COMMENT 'Acentos',
  `gl_vista` varchar(255) NOT NULL,
  `gl_letra_tipo` varchar(5) NOT NULL,
  `orden_tipo` int(11) NOT NULL,
  `fc_creacion_tipo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `local_tipo`
--

CREATE TABLE IF NOT EXISTS `local_tipo` (
  `local_tipo_id` int(11) NOT NULL AUTO_INCREMENT,
  `local_tipo_nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`local_tipo_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `maestro_modulo`
--

CREATE TABLE IF NOT EXISTS `maestro_modulo` (
  `m_m_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_modulo` varchar(100) NOT NULL,
  `link_modulo` varchar(200) NOT NULL,
  `img` varchar(200) NOT NULL,
  PRIMARY KEY (`m_m_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `maestro_rol`
--

CREATE TABLE IF NOT EXISTS `maestro_rol` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_nombre` varchar(200) NOT NULL,
  `rol_nombre_header` varchar(200) NOT NULL,
  `rol_nombre_vista` varchar(200) NOT NULL,
  `tipo_rol_acceso` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'tipo de rol',
  `nr_orden` int(11) DEFAULT '0',
  PRIMARY KEY (`rol_id`),
  KEY `tipo_rol_acceso` (`tipo_rol_acceso`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `maestro_sistemas`
--

CREATE TABLE IF NOT EXISTS `maestro_sistemas` (
  `id_sistema` int(11) NOT NULL AUTO_INCREMENT,
  `gl_nombre_sistema` varchar(255) NOT NULL,
  `key_public` varchar(45) NOT NULL,
  `key_private` varchar(250) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sistema`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `maestro_usuario`
--

CREATE TABLE IF NOT EXISTS `maestro_usuario` (
  `mu_id` int(11) NOT NULL AUTO_INCREMENT,
  `mu_rut` varchar(20) NOT NULL,
  `mu_rut_midas` varchar(20) NOT NULL,
  `mu_pass` varchar(60) NOT NULL,
  `mu_nombre` varchar(50) NOT NULL,
  `mu_apellido_paterno` varchar(50) NOT NULL,
  `mu_apellido_materno` varchar(50) NOT NULL,
  `mu_correo` varchar(100) NOT NULL,
  `mu_direccion` varchar(200) NOT NULL,
  `mu_telefono_codigo` varchar(5) NOT NULL,
  `mu_telefono` varchar(15) NOT NULL,
  `mu_fono` varchar(50) NOT NULL,
  `mu_fono_codigo` varchar(11) NOT NULL,
  `mu_dir_region` int(11) NOT NULL,
  `mu_dir_comuna` int(11) NOT NULL,
  `mu_fecha_nacimiento` date NOT NULL,
  `mu_genero` enum('masculino','femenino') NOT NULL,
  `mu_contrato_trabajo` varchar(200) NOT NULL,
  `mu_detalle_certificado` varchar(200) NOT NULL,
  `mu_tipo_certificado` enum('url','archivo') NOT NULL,
  `mu_estado_sistema` int(11) NOT NULL,
  `carga_masiva` int(11) NOT NULL,
  `usuario_fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pass_hab` tinyint(1) NOT NULL DEFAULT '0',
  `url_avatar` varchar(100) NOT NULL DEFAULT '/profile_big.jpg',
  PRIMARY KEY (`mu_id`),
  UNIQUE KEY `mu_rut` (`mu_rut`),
  KEY `mu_rut_midas` (`mu_rut_midas`),
  KEY `mu_dir_region` (`mu_dir_region`),
  KEY `mu_dir_comuna` (`mu_dir_comuna`),
  KEY `mu_estado_sistema` (`mu_estado_sistema`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16379 ;

-- --------------------------------------------------------

--
-- Table structure for table `maestro_usuario_rol`
--

CREATE TABLE IF NOT EXISTS `maestro_usuario_rol` (
  `mur_id` int(11) NOT NULL AUTO_INCREMENT,
  `mur_fk_usuario` int(11) NOT NULL,
  `mur_fk_rol` int(11) NOT NULL,
  `mur_estado_activado` int(11) NOT NULL DEFAULT '1',
  `fk_farmacia` int(11) NOT NULL DEFAULT '0',
  `fk_local` int(11) NOT NULL DEFAULT '0',
  `fk_bodega` int(11) NOT NULL DEFAULT '0',
  `mur_fk_region` int(11) NOT NULL DEFAULT '0',
  `mur_fk_territorio` int(11) NOT NULL DEFAULT '0',
  `mur_fk_comuna` int(11) NOT NULL DEFAULT '0',
  `mur_fk_localidad` int(11) NOT NULL DEFAULT '0',
  `rol_fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rol_creador` int(11) NOT NULL DEFAULT '0' COMMENT 'Id creador',
  PRIMARY KEY (`mur_id`),
  KEY `mur_fk_usuario` (`mur_fk_usuario`),
  KEY `mur_fk_rol` (`mur_fk_rol`),
  KEY `fk_local` (`fk_local`),
  KEY `mur_fk_region` (`mur_fk_region`),
  KEY `fk_farmacia` (`fk_farmacia`),
  KEY `mur_fk_comuna` (`mur_fk_comuna`),
  KEY `mur_fk_localidad` (`mur_fk_localidad`),
  KEY `mur_estado_activado` (`mur_estado_activado`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27651 ;

-- --------------------------------------------------------

--
-- Table structure for table `maestro_valores`
--

CREATE TABLE IF NOT EXISTS `maestro_valores` (
  `mv_id` int(11) NOT NULL AUTO_INCREMENT,
  `mv_grupo` int(11) NOT NULL,
  `mv_key` int(11) NOT NULL,
  `mv_value` varchar(255) NOT NULL,
  PRIMARY KEY (`mv_id`),
  KEY `mv_key` (`mv_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `maestro_vista`
--

CREATE TABLE IF NOT EXISTS `maestro_vista` (
  `m_v_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_vista` varchar(100) NOT NULL,
  `link_vista` varchar(200) NOT NULL,
  `img` varchar(200) NOT NULL,
  `fk_modulo` int(11) NOT NULL,
  PRIMARY KEY (`m_v_id`),
  KEY `fk_modulo` (`fk_modulo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asunto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `cuerpo` text COLLATE utf8_unicode_ci NOT NULL,
  `adjunto` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `region` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT '0',
  `respuesta` text COLLATE utf8_unicode_ci,
  `adjunto_respuesta` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_respuesta` datetime DEFAULT NULL,
  `id_usuario_respuesta` int(11) DEFAULT NULL,
  `telefono` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tiene_obs_soporte` tinyint(1) DEFAULT '0',
  `ibex_or_ssrv` tinyint(1) DEFAULT NULL COMMENT 'ibex = 0 ; ssrv = 1',
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2130 ;

-- --------------------------------------------------------

--
-- Table structure for table `mail_observacion`
--

CREATE TABLE IF NOT EXISTS `mail_observacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_id` int(11) NOT NULL,
  `responsable_id` int(11) NOT NULL,
  `obs` varchar(500) NOT NULL,
  `adjunto` varchar(120) DEFAULT NULL,
  `fecha_obs` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mail_id` (`mail_id`),
  KEY `responsable_id` (`responsable_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicamento`
--

CREATE TABLE IF NOT EXISTS `medicamento` (
  `medicamento_id` int(11) NOT NULL AUTO_INCREMENT,
  `medicamento_principio_activo` int(10) NOT NULL,
  `gl_pa` varchar(255) NOT NULL,
  `medicamento_establecimiento` int(10) NOT NULL,
  `medicamento_codigo` varchar(25) NOT NULL,
  `medicamento_codigo_valor` varchar(10) NOT NULL COMMENT 'Valor numerico del codigo',
  `medicamento_codigo_año` varchar(4) NOT NULL COMMENT 'Año de creacion',
  `medicamento_especialidad_farmaceutica` varchar(50) NOT NULL,
  `medicamento_forma_farmaceutica` int(10) NOT NULL,
  `medicamento_dosis` varchar(15) NOT NULL,
  `medicamento_presentacion_envase` varchar(50) NOT NULL,
  `medicamento_producto` varchar(50) NOT NULL,
  `presentacion_envase_caja` varchar(100) NOT NULL,
  `presentacion_envase_cantidad` int(11) NOT NULL,
  `no_farmacia_privada` tinyint(1) NOT NULL DEFAULT '0',
  `medicamento_unidad_despacho` varchar(60) NOT NULL,
  `fk_tipo_receta` int(11) NOT NULL COMMENT '1=Cheque; 2=Retenida; 3=Retenida S/D ',
  `medicamento_fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha Creacion',
  `medicamento_estado` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'estado activo en sistema',
  PRIMARY KEY (`medicamento_id`),
  KEY `fk_medicamento_receta` (`fk_tipo_receta`),
  KEY `medicamento_principio_activo` (`medicamento_principio_activo`),
  KEY `medicamento_establecimiento` (`medicamento_establecimiento`),
  KEY `medicamento_codigo` (`medicamento_codigo`),
  KEY `fk_tipo_receta` (`fk_tipo_receta`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=413 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicamentos_magistrales`
--

CREATE TABLE IF NOT EXISTS `medicamentos_magistrales` (
  `id_mg` int(11) NOT NULL AUTO_INCREMENT,
  `principio_activo` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `unidad_despacho` varchar(50) NOT NULL,
  `tipo_droga` varchar(50) NOT NULL,
  `tipo_receta` int(11) NOT NULL COMMENT '1=Cheque; 2=Retenida; 3=Retenida S/D ',
  `magistral_fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha Creacion',
  `magistral_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_mg`),
  KEY `principio_activo` (`principio_activo`),
  KEY `codigo` (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicamento_establecimiento`
--

CREATE TABLE IF NOT EXISTS `medicamento_establecimiento` (
  `m_estable_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_estable_nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`m_estable_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicamento_forma_farmaceutica`
--

CREATE TABLE IF NOT EXISTS `medicamento_forma_farmaceutica` (
  `m_formaf_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_formaf_nombre` varchar(100) NOT NULL,
  `m_formaf_nombre_corto` varchar(10) NOT NULL,
  PRIMARY KEY (`m_formaf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicamento_principio_activo`
--

CREATE TABLE IF NOT EXISTS `medicamento_principio_activo` (
  `pa_id` int(11) NOT NULL AUTO_INCREMENT,
  `pa_nombre` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'nombre principio activo',
  PRIMARY KEY (`pa_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicos`
--

CREATE TABLE IF NOT EXISTS `medicos` (
  `id_medico` int(11) NOT NULL AUTO_INCREMENT,
  `fk_usuario` int(11) NOT NULL,
  `medico_rut` varchar(20) NOT NULL,
  `medico_nombre` varchar(50) NOT NULL,
  `medico_apellidopat` varchar(50) NOT NULL,
  `medico_apellidomat` varchar(50) NOT NULL,
  `codigo_medico` varchar(100) NOT NULL,
  `fk_region` int(11) DEFAULT NULL,
  `fk_comuna` int(11) DEFAULT NULL,
  `direccion_consulta` varchar(200) NOT NULL,
  `telefono_consulta` varchar(30) NOT NULL,
  `fono` varchar(50) NOT NULL,
  `fono_codigo` varchar(11) NOT NULL,
  `correo_medico` varchar(100) NOT NULL,
  `fk_esp` int(11) NOT NULL DEFAULT '0',
  `consulta_estado` tinyint(1) NOT NULL DEFAULT '1',
  `consulta_motivo_deshabilitacion` varchar(256) NOT NULL,
  PRIMARY KEY (`id_medico`),
  KEY `id_medico` (`id_medico`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `medico_rut` (`medico_rut`),
  KEY `fk_region` (`fk_region`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10421 ;

-- --------------------------------------------------------

--
-- Table structure for table `medico_denuncia`
--

CREATE TABLE IF NOT EXISTS `medico_denuncia` (
  `id_medico_denuncia` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_denuncia` varchar(20) NOT NULL,
  `fk_usuario` int(11) NOT NULL COMMENT 'fk_medico',
  `link_receta_denuncia` varchar(255) NOT NULL,
  `link_receta_original` varchar(255) NOT NULL,
  `tipo_receta` enum('RECETA RETENIDA','RECETA ESTÁNDAR') NOT NULL,
  `tipo_denuncia` enum('ROBADA','EXTRAVIADA','FALSIFICADA') NOT NULL,
  `fecha_denuncia` date NOT NULL,
  `region_denuncia` int(11) NOT NULL,
  `comuna_denuncia` int(11) NOT NULL,
  `direccion_denuncia` varchar(255) NOT NULL,
  `observacion_denuncia` text,
  `estado_denuncia` int(1) NOT NULL COMMENT '0= No aprobado; 1= Aprobado',
  `id_usuario_valida` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Guarda la fecha y hora en que fue ingresado al sistema',
  `tipo_receta_id` int(11) NOT NULL,
  PRIMARY KEY (`id_medico_denuncia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medico_especialidad`
--

CREATE TABLE IF NOT EXISTS `medico_especialidad` (
  `especialidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `especialidad_nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`especialidad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `medico_limite_venta`
--

CREATE TABLE IF NOT EXISTS `medico_limite_venta` (
  `mlv_id` int(100) NOT NULL AUTO_INCREMENT,
  `mlv_fk_usuario` int(100) NOT NULL,
  `mlv_fk_region` int(10) NOT NULL,
  `mlv_limite` int(100) NOT NULL,
  PRIMARY KEY (`mlv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `motivo_inhabilitacion`
--

CREATE TABLE IF NOT EXISTS `motivo_inhabilitacion` (
  `motivo_inhabilitacion_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `motivo_inhabilitacion_nombre` varchar(50) NOT NULL DEFAULT '',
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`motivo_inhabilitacion_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `oc_detalle`
--

CREATE TABLE IF NOT EXISTS `oc_detalle` (
  `ocd_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_oc` int(11) NOT NULL,
  `ocd_medicamento` int(11) NOT NULL,
  `ocd_cantidad` int(11) NOT NULL,
  `ocd_unidad` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ocd_tipo` int(11) NOT NULL,
  `lote` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fc_vence` date NOT NULL,
  PRIMARY KEY (`ocd_id`),
  KEY `fk_oc` (`fk_oc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `oc_medicamento`
--

CREATE TABLE IF NOT EXISTS `oc_medicamento` (
  `oc_id` int(11) NOT NULL AUTO_INCREMENT,
  `oc_num` bigint(255) NOT NULL,
  `oc_rut_empresa` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `oc_razon_social` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `oc_tipo_doc` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Guia',
  `fk_usuario` int(11) NOT NULL COMMENT 'Usuario Creador',
  `lote` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fc_vence` date NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `oc_fecha` date NOT NULL,
  `fecha_ingreso_bg` date NOT NULL,
  `fk_local` int(100) NOT NULL,
  PRIMARY KEY (`oc_id`),
  KEY `oc_rut_empresa` (`oc_rut_empresa`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `profesion_detalle`
--

CREATE TABLE IF NOT EXISTS `profesion_detalle` (
  `id_profesion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_profesion` varchar(50) NOT NULL,
  PRIMARY KEY (`id_profesion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `profesion_por_usuario`
--

CREATE TABLE IF NOT EXISTS `profesion_por_usuario` (
  `id_pxu` int(11) NOT NULL AUTO_INCREMENT,
  `fk_usuario` int(11) NOT NULL,
  `fk_profesion` int(11) NOT NULL,
  `profesion_fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha Creacion',
  PRIMARY KEY (`id_pxu`),
  KEY `id_pxu` (`id_pxu`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15857 ;

-- --------------------------------------------------------

--
-- Table structure for table `receta_cheque`
--

CREATE TABLE IF NOT EXISTS `receta_cheque` (
  `receta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receta_serie` varchar(20) NOT NULL,
  `receta_numero` int(11) NOT NULL,
  `talonario_en_sistema` int(1) NOT NULL COMMENT '1=SI',
  `fk_tipo_receta` int(11) NOT NULL,
  `fk_local_id` int(11) DEFAULT NULL,
  `fk_id_medico` int(11) DEFAULT NULL,
  `rut_medico` varchar(20) NOT NULL,
  `rut_medico_midas` varchar(20) NOT NULL,
  `rut_paciente` varchar(20) NOT NULL,
  `rut_paciente_midas` varchar(20) NOT NULL,
  `nombre_paciente` varchar(200) NOT NULL,
  `apellidop_adquiriente` varchar(200) NOT NULL,
  `apellidom_adquiriente` varchar(200) NOT NULL,
  `direccion_paciente` varchar(200) NOT NULL,
  `region_paciente` int(11) NOT NULL,
  `comuna_paciente` int(11) NOT NULL,
  `rut_adquiriente` varchar(20) NOT NULL,
  `rut_adquiriente_midas` varchar(20) NOT NULL,
  `nombre_adquiriente` varchar(200) NOT NULL,
  `apellidop_paciente` varchar(200) NOT NULL,
  `apellidom_paciente` varchar(200) NOT NULL,
  `direccion_adquiriente` varchar(200) NOT NULL,
  `region_adquiriente` int(11) NOT NULL,
  `comuna_adquiriente` int(11) NOT NULL,
  `fk_medicamento` int(11) NOT NULL,
  `fk_tipo_medicamento` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL COMMENT 'Cantidad Medicamento',
  `fc_recepcion_receta` date NOT NULL,
  `fk_quim_recepciona` int(11) NOT NULL,
  `fc_ingreso_receta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fe_de_errata` varchar(1200) NOT NULL,
  `validacion_errata` int(1) NOT NULL COMMENT 'validacion errat',
  PRIMARY KEY (`receta_id`),
  UNIQUE KEY `fk_medicamento` (`fk_medicamento`),
  KEY `fk_receta_tipo` (`fk_tipo_receta`),
  KEY `rut_paciente_midas` (`rut_paciente_midas`),
  KEY `rut_adquiriente_midas` (`rut_adquiriente_midas`),
  KEY `fk_local_id` (`fk_local_id`),
  KEY `fk_id_medico` (`fk_id_medico`),
  KEY `rut_medico_midas` (`rut_medico_midas`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receta_medicamentos`
--

CREATE TABLE IF NOT EXISTS `receta_medicamentos` (
  `fk_receta` int(11) NOT NULL,
  `fk_medicamento` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `receta_retenida`
--

CREATE TABLE IF NOT EXISTS `receta_retenida` (
  `receta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `talonario_en_sistema` int(1) NOT NULL DEFAULT '-1' COMMENT '0=no 1=SI',
  `fk_tipo_receta` int(11) NOT NULL DEFAULT '1',
  `fk_local_id` int(11) DEFAULT NULL,
  `fk_id_medico` int(11) DEFAULT NULL,
  `rut_medico` varchar(30) DEFAULT NULL,
  `rut_medico_midas` varchar(20) NOT NULL,
  `rut_adquiriente` varchar(20) NOT NULL,
  `rut_adquiriente_midas` varchar(20) NOT NULL,
  `nombre_adquiriente` varchar(200) NOT NULL,
  `apellidop_adquiriente` varchar(200) NOT NULL,
  `apellidom_adquiriente` varchar(200) NOT NULL,
  `direccion_adquiriente` varchar(250) NOT NULL,
  `region_adquiriente` int(11) NOT NULL,
  `comuna_adquiriente` int(11) NOT NULL,
  `rut_paciente` varchar(20) NOT NULL,
  `rut_paciente_midas` varchar(20) NOT NULL,
  `nombre_paciente` varchar(200) NOT NULL,
  `apellidop_paciente` varchar(200) NOT NULL,
  `apellidom_paciente` varchar(200) NOT NULL,
  `direccion_paciente` varchar(200) NOT NULL,
  `region_paciente` int(11) NOT NULL,
  `comuna_paciente` int(11) NOT NULL,
  `fk_medicamento` int(11) NOT NULL,
  `fk_tipo_medicamento` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL COMMENT 'Cantidad Medicamento',
  `fc_recepcion_receta` date NOT NULL,
  `fk_quim_recepciona` int(11) NOT NULL,
  `fc_ingreso_receta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fe_de_errata` varchar(300) NOT NULL,
  `validacion_errata` int(1) NOT NULL,
  PRIMARY KEY (`receta_id`),
  KEY `rut_adquiriente_midas` (`rut_adquiriente_midas`),
  KEY `rut_paciente_midas` (`rut_paciente_midas`),
  KEY `fk_local_id` (`fk_local_id`),
  KEY `fk_id_medico` (`fk_id_medico`),
  KEY `rut_medico_midas` (`rut_medico_midas`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receta_sd`
--

CREATE TABLE IF NOT EXISTS `receta_sd` (
  `receta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_tipo_receta` int(11) NOT NULL,
  `fk_local_id` int(11) DEFAULT NULL,
  `fecha_receta_sd` date NOT NULL,
  `fecha_despacho_receta_sd` date NOT NULL,
  PRIMARY KEY (`receta_id`),
  KEY `fk_receta_tipo` (`fk_tipo_receta`),
  KEY `fk_local_id` (`fk_local_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

--
-- Table structure for table `recovery_key`
--

CREATE TABLE IF NOT EXISTS `recovery_key` (
  `id_recovery` int(11) NOT NULL AUTO_INCREMENT,
  `recovery_email` varchar(256) NOT NULL,
  `recovery_hash` varchar(32) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_recovery`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1503 ;

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `region_numero` varchar(4) NOT NULL,
  `numero_region` varchar(2) NOT NULL,
  `region_nombre` varchar(80) NOT NULL,
  `nombre_region_corto` varchar(100) NOT NULL,
  `id_region_midas` int(11) NOT NULL,
  `cod_minsal` varchar(10) DEFAULT NULL,
  `orden_territorial` int(11) DEFAULT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_actividad`
--

CREATE TABLE IF NOT EXISTS `registro_actividad` (
  `registro_id` int(11) NOT NULL AUTO_INCREMENT,
  `registro_tipo` int(2) NOT NULL COMMENT '1=Crear, 2=Editar, 3=Inhabilitar, 4=Habilitar',
  `registro_procedencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre Tabla Procedencia',
  `fk_id_procedencia` int(11) NOT NULL COMMENT 'id que buscara de la Tabla Procedencia',
  `fk_usuario` int(11) NOT NULL COMMENT 'Usuario que realizo la accion',
  `registro_fecha_actividad` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de la accion',
  `observacion` text,
  `json` text,
  PRIMARY KEY (`registro_id`),
  KEY `registro_id` (`registro_id`),
  KEY `fk_id_procedencia` (`fk_id_procedencia`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44974 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_actividad_turno`
--

CREATE TABLE IF NOT EXISTS `registro_actividad_turno` (
  `registro_id` int(11) NOT NULL AUTO_INCREMENT,
  `registro_tipo` int(2) NOT NULL COMMENT '1=Crear, 2=Editar, 3=Inhabilitar, 4=Habilitar',
  `registro_procedencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre Tabla Procedencia',
  `fk_id_procedencia` int(11) NOT NULL COMMENT 'id que buscara de la Tabla Procedencia',
  `fk_usuario` int(11) NOT NULL COMMENT 'Usuario que realizo la accion',
  `registro_fecha_actividad` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de la accion',
  `json_turno` text,
  `json_turno_detalle` text,
  PRIMARY KEY (`registro_id`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8764 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_evento_ws_farmanet`
--

CREATE TABLE IF NOT EXISTS `registro_evento_ws_farmanet` (
  `id_evento` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_sistema` int(11) NOT NULL,
  `id_registro` varchar(255) NOT NULL,
  `gl_tipo` varchar(255) NOT NULL,
  `gl_comentario` longtext NOT NULL,
  `json` longtext NOT NULL,
  `ip_publica` varchar(50) NOT NULL,
  `ip_privada` varchar(50) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_evento`),
  KEY `id_sistema` (`id_sistema`),
  KEY `id_registro_login` (`id_registro`),
  KEY `id_usuario` (`id_usuario`),
  KEY `gl_tipo` (`gl_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_institucional`
--

CREATE TABLE IF NOT EXISTS `registro_institucional` (
  `registro_id` int(11) NOT NULL AUTO_INCREMENT,
  `registro_tipo` int(2) NOT NULL COMMENT '1=Crear, 2=Editar, 3=Inhabilitar, 4=Habilitar',
  `registro_procedencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre Tabla Procedencia',
  `fk_id_procedencia` int(11) NOT NULL COMMENT 'id que buscara de la Tabla Procedencia',
  `fk_usuario` int(11) NOT NULL COMMENT 'Usuario que realizo la accion',
  `registro_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de la accion',
  `observacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`registro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_login`
--

CREATE TABLE IF NOT EXISTS `registro_login` (
  `registro_login_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_usuario` int(11) DEFAULT NULL,
  `fk_rol` int(11) DEFAULT NULL,
  `fk_region` int(11) DEFAULT NULL,
  `fc_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_privada` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `ip_publica` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `session_id` varchar(255) NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`registro_login_id`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `fk_region` (`fk_region`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=126129 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_login_ws`
--

CREATE TABLE IF NOT EXISTS `registro_login_ws` (
  `login_ws_id` int(11) NOT NULL AUTO_INCREMENT,
  `rut_usuario` varchar(20) DEFAULT NULL,
  `rut_usuario_midas` varchar(20) NOT NULL,
  `fc_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_privada` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `ip_publica` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `session_id` varchar(255) NOT NULL,
  PRIMARY KEY (`login_ws_id`),
  KEY `rut_usuario_midas` (`rut_usuario_midas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24575 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_logout`
--

CREATE TABLE IF NOT EXISTS `registro_logout` (
  `registro_logout_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_usuario` int(11) DEFAULT NULL,
  `fc_logout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_logout` varchar(100) NOT NULL DEFAULT '',
  `ip_privada` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `ip_publica` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `session_id` varchar(255) NOT NULL,
  PRIMARY KEY (`registro_logout_id`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66872 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_no_institucional`
--

CREATE TABLE IF NOT EXISTS `registro_no_institucional` (
  `registro_id` int(11) NOT NULL AUTO_INCREMENT,
  `registro_tipo` int(2) NOT NULL COMMENT '1=Crear, 2=Editar, 3=Inhabilitar, 4=Habilitar',
  `registro_procedencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre Tabla Procedencia',
  `fk_id_procedencia` int(11) NOT NULL COMMENT 'id que buscara de la Tabla Procedencia',
  `fk_usuario` int(11) NOT NULL COMMENT 'Usuario que realizo la accion',
  `registro_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de la accion',
  `observacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`registro_id`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_query`
--

CREATE TABLE IF NOT EXISTS `registro_query` (
  `registro_query_id` int(11) NOT NULL AUTO_INCREMENT,
  `query` longtext NOT NULL,
  `fk_usuario` int(11) NOT NULL,
  `origen` mediumtext NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`registro_query_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47691 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_ver_resolucion`
--

CREATE TABLE IF NOT EXISTS `registro_ver_resolucion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cod_resolucion` varchar(50) NOT NULL,
  `fk_localidad` int(11) NOT NULL,
  `turno_fecha_inicio` date NOT NULL,
  `ip_privada` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `ip_publica` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`id`),
  KEY `cod_resolucion` (`cod_resolucion`),
  KEY `fk_localidad` (`fk_localidad`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33410 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_ws_comparador`
--

CREATE TABLE IF NOT EXISTS `registro_ws_comparador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ws_nombre` varchar(50) DEFAULT NULL,
  `gl_login` varchar(255) NOT NULL,
  `gl_password` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `key_public` varchar(255) DEFAULT NULL,
  `autorizado` int(11) NOT NULL,
  `ip_privada` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `ip_publica` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`id`),
  KEY `fk_region` (`gl_login`),
  KEY `ws_nombre` (`ws_nombre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=188 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_ws_farmanet`
--

CREATE TABLE IF NOT EXISTS `registro_ws_farmanet` (
  `id_registro_ws` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_sistema` int(11) NOT NULL,
  `webservice` varchar(255) NOT NULL,
  `key_public` varchar(45) NOT NULL,
  `data` longtext NOT NULL,
  `json_respuesta` longtext NOT NULL,
  `ip_privada` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `ip_publica` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_registro_ws`),
  KEY `id_sistema` (`id_sistema`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `registro_ws_turnos`
--

CREATE TABLE IF NOT EXISTS `registro_ws_turnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ws_nombre` varchar(50) DEFAULT NULL,
  `fk_region` int(11) NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `key_public` varchar(255) DEFAULT NULL,
  `autorizado` int(11) NOT NULL,
  `ip_privada` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `ip_publica` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`id`),
  KEY `fk_region` (`fk_region`),
  KEY `ws_nombre` (`ws_nombre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=850 ;

-- --------------------------------------------------------

--
-- Table structure for table `rol_vista`
--

CREATE TABLE IF NOT EXISTS `rol_vista` (
  `rol_vista_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_rol` int(11) NOT NULL,
  `fk_vista` int(11) NOT NULL,
  `permiso` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rol_vista_id`),
  KEY `fk_rol` (`fk_rol`),
  KEY `fk_vista` (`fk_vista`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=418 ;

-- --------------------------------------------------------

--
-- Table structure for table `rotacion_qf`
--

CREATE TABLE IF NOT EXISTS `rotacion_qf` (
  `ejercicio_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_local` bigint(20) NOT NULL,
  `fk_quimico` bigint(20) NOT NULL,
  `rotacion_dia` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') NOT NULL,
  `rotacion_hora_inicio` time NOT NULL DEFAULT '00:00:00',
  `rotacion_siesta_inicio` time NOT NULL DEFAULT '00:00:00',
  `rotacion_siesta_termino` time NOT NULL DEFAULT '00:00:00',
  `rotacion_hora_termino` time NOT NULL DEFAULT '00:00:00',
  `fecha` date NOT NULL,
  `fc_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ejercicio_id`),
  KEY `ejercicio_id` (`ejercicio_id`),
  KEY `fk_quimico` (`fk_quimico`),
  KEY `fk_local` (`fk_local`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3396 ;

-- --------------------------------------------------------

--
-- Table structure for table `rotacion_qf_historico`
--

CREATE TABLE IF NOT EXISTS `rotacion_qf_historico` (
  `ejercicio_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_local` bigint(20) NOT NULL,
  `fk_quimico` bigint(20) NOT NULL,
  `rotacion_dia` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') NOT NULL,
  `rotacion_hora_inicio` time NOT NULL DEFAULT '00:00:00',
  `rotacion_siesta_inicio` time NOT NULL DEFAULT '00:00:00',
  `rotacion_siesta_termino` time NOT NULL DEFAULT '00:00:00',
  `rotacion_hora_termino` time NOT NULL DEFAULT '00:00:00',
  `fecha` date NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ejercicio_id`),
  KEY `ejercicio_id` (`ejercicio_id`),
  KEY `fk_quimico` (`fk_quimico`),
  KEY `fk_local` (`fk_local`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40986 ;

-- --------------------------------------------------------

--
-- Table structure for table `rotacion_semanal_local`
--

CREATE TABLE IF NOT EXISTS `rotacion_semanal_local` (
  `id_rsl` bigint(255) NOT NULL AUTO_INCREMENT,
  `fk_local` bigint(255) NOT NULL,
  `r_lunes` int(1) NOT NULL DEFAULT '0',
  `r_martes` int(1) NOT NULL DEFAULT '0',
  `r_miercoles` int(1) NOT NULL DEFAULT '0',
  `r_jueves` int(1) NOT NULL DEFAULT '0',
  `r_viernes` int(1) NOT NULL DEFAULT '0',
  `r_sabado` int(1) NOT NULL DEFAULT '0',
  `r_domingo` int(1) NOT NULL DEFAULT '0',
  `fecha_inicio_semana` date NOT NULL DEFAULT '1985-01-01',
  `fecha_termino_semana` date NOT NULL DEFAULT '1985-01-07',
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rsl`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=249 ;

-- --------------------------------------------------------

--
-- Table structure for table `rotacion_semanal_qf`
--

CREATE TABLE IF NOT EXISTS `rotacion_semanal_qf` (
  `ejercicio_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_local` bigint(20) NOT NULL,
  `fk_quimico` bigint(20) NOT NULL,
  `rotacion_dia` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') NOT NULL,
  `rotacion_hora_inicio` time NOT NULL,
  `rotacion_siesta_inicio` time NOT NULL DEFAULT '00:00:00',
  `rotacion_siesta_termino` time NOT NULL DEFAULT '00:00:00',
  `rotacion_hora_termino` time NOT NULL,
  `fecha_rotacion` date NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `funcionamiento_orden` int(11) NOT NULL,
  PRIMARY KEY (`ejercicio_id`),
  KEY `ejercicio_id` (`ejercicio_id`),
  KEY `fk_quimico` (`fk_quimico`),
  KEY `fk_local` (`fk_local`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14486 ;

-- --------------------------------------------------------

--
-- Table structure for table `seremi`
--

CREATE TABLE IF NOT EXISTS `seremi` (
  `id_seremi` int(11) NOT NULL AUTO_INCREMENT,
  `fk_usuario` int(11) NOT NULL,
  `fk_region` int(11) NOT NULL COMMENT 'Region Mandato',
  `fk_comuna` int(11) NOT NULL,
  `genero_seremi` enum('F','M') NOT NULL,
  `seremi_trato` enum('MV.','QF.','DR.','SR.','ING.','Mg.','MG.','DRA.','SRA.','SRTA.','DON','DOÑA','OTRO','KLGO.') NOT NULL DEFAULT 'OTRO' COMMENT 'Sigla Tratamiento Cortesia',
  `seremi_cargo` varchar(255) NOT NULL,
  `seremi_autoridad` varchar(600) NOT NULL COMMENT 'Nombre completo "DR o DRA nombre"',
  `seremi_nombre` varchar(200) NOT NULL,
  `seremi_apellido_paterno` varchar(200) NOT NULL,
  `seremi_apellido_materno` varchar(200) NOT NULL,
  `seremi_direccion` varchar(100) NOT NULL COMMENT 'Direccion',
  `seremi_telefono` varchar(200) NOT NULL COMMENT 'Telefono Central',
  `seremi_fax` int(11) NOT NULL COMMENT 'Fono Fax',
  `seremi_email` varchar(100) NOT NULL COMMENT 'correo para resoluciones',
  `seremi_decreto` varchar(10) NOT NULL,
  `seremi_decreto_fecha` varchar(10) NOT NULL,
  `seremi` int(1) NOT NULL DEFAULT '0' COMMENT 'Seremi=1 Subrogante=0',
  `seremi_fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `seremi_estado` int(1) NOT NULL DEFAULT '1',
  `url_firma` varchar(1000) NOT NULL,
  `fk_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_seremi`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `fk_region` (`fk_region`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Table structure for table `talonario`
--

CREATE TABLE IF NOT EXISTS `talonario` (
  `talonario_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `talonario_serie` varchar(1000) NOT NULL,
  `talonario_folio_inicial` bigint(20) NOT NULL,
  `talonario_folio_final` bigint(20) NOT NULL,
  `talonario_cantidad` int(11) NOT NULL,
  `fk_usuario` int(11) NOT NULL COMMENT 'Creador',
  `Ingreso_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_tc_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`talonario_id`),
  KEY `talonario_id` (`talonario_id`),
  KEY `talonario_folio_inicial` (`talonario_folio_inicial`),
  KEY `talonario_folio_final` (`talonario_folio_final`),
  KEY `talonario_serie` (`talonario_serie`(333)),
  KEY `talonario_cantidad` (`talonario_cantidad`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `Ingreso_sistema` (`Ingreso_sistema`),
  KEY `fk_tc_id` (`fk_tc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=177418 ;

-- --------------------------------------------------------

--
-- Table structure for table `talonarios_creados`
--

CREATE TABLE IF NOT EXISTS `talonarios_creados` (
  `tc_id` int(11) NOT NULL AUTO_INCREMENT,
  `talonario_serie` varchar(10) NOT NULL DEFAULT 'Z',
  `talonario_folio_inicial` int(11) NOT NULL,
  `talonario_folio_final` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cheques` int(11) NOT NULL DEFAULT '50',
  `documento` varchar(100) NOT NULL COMMENT 'Guia o Factura',
  `nr_documento` int(11) NOT NULL,
  `fc_documento` date NOT NULL,
  `proveedor` varchar(100) NOT NULL DEFAULT 'Casa de Moneda',
  `bo_estado` int(1) DEFAULT '1',
  `fk_usuario` int(11) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tc_id`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `talonario_folio_inicial` (`talonario_folio_inicial`),
  KEY `talonario_folio_final` (`talonario_folio_final`),
  KEY `nr_documento` (`nr_documento`),
  KEY `talonario_serie` (`talonario_serie`),
  KEY `cantidad` (`cantidad`),
  KEY `cheques` (`cheques`),
  KEY `documento` (`documento`),
  KEY `proveedor` (`proveedor`),
  KEY `bo_estado` (`bo_estado`),
  KEY `fc_creacion` (`fc_creacion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5039 ;

-- --------------------------------------------------------

--
-- Table structure for table `talonarios_vendidos`
--

CREATE TABLE IF NOT EXISTS `talonarios_vendidos` (
  `t_vendido_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_talonario` int(11) NOT NULL,
  `fk_venta` int(11) NOT NULL,
  PRIMARY KEY (`t_vendido_id`),
  KEY `t_vendido_id` (`t_vendido_id`),
  KEY `fk_talonario` (`fk_talonario`),
  KEY `fk_venta` (`fk_venta`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=147308 ;

-- --------------------------------------------------------

--
-- Table structure for table `talonario_precio_historial`
--

CREATE TABLE IF NOT EXISTS `talonario_precio_historial` (
  `tph_id` int(11) NOT NULL AUTO_INCREMENT,
  `tph_precio` int(11) NOT NULL,
  `tph_fk_region` int(5) NOT NULL,
  `tph_usuario` bigint(11) NOT NULL,
  `fc_inicio` datetime NOT NULL,
  `fc_termino` datetime NOT NULL,
  `tph_fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tph_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Table structure for table `talonario_precio_region`
--

CREATE TABLE IF NOT EXISTS `talonario_precio_region` (
  `tpr_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `tpr_precio` int(11) NOT NULL DEFAULT '0',
  `tpr_fk_region` int(11) NOT NULL,
  UNIQUE KEY `tpr_id` (`tpr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `territorio`
--

CREATE TABLE IF NOT EXISTS `territorio` (
  `territorio_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'llave primaria',
  `nombre_territorio` varchar(25) NOT NULL COMMENT 'nombre clave territorio',
  `fk_region` int(11) NOT NULL COMMENT 'enlace region correspondiente',
  `fk_region_midas` int(11) NOT NULL,
  PRIMARY KEY (`territorio_id`),
  KEY `fk_region` (`fk_region`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_receta`
--

CREATE TABLE IF NOT EXISTS `tipo_receta` (
  `tipo_receta_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_receta_nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`tipo_receta_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno`
--

CREATE TABLE IF NOT EXISTS `turno` (
  `turno_id` int(11) NOT NULL AUTO_INCREMENT,
  `turno_fecha_inicio` date NOT NULL,
  `turno_fecha_termino` date NOT NULL,
  `fk_region` int(11) NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `fk_localidad` int(11) NOT NULL,
  `turno_tipo` enum('URGENCIA','PARCIAL1','PARCIAL2','PARCIAL3','PARCIAL4','PARCIAL5','PARCIAL6','PARCIAL7','DIARIO','DIARIO2','DIARIO3','DIARIO4','DIARIO5','SEMANAL1','SEMANAL2','SEMANAL3','SEMANAL4','SEMANAL5','SEMANAL6','SEMANAL7','SEMANAL8','SEMANAL9','ESPECIFICA') NOT NULL,
  `turno_hora_inicio` time NOT NULL,
  `turno_hora_termino` time NOT NULL,
  `turno_rotacion` enum('DIARIA','SEMANAL','MENSUAL','SEMESTRAL') NOT NULL,
  `turno_periodo` enum('Primer','Segundo','Tercer','Cuarto') DEFAULT NULL,
  `cod_resolucion` varchar(20) NOT NULL COMMENT 'Numero de esta resolucion',
  `num_resolucion` varchar(20) NOT NULL DEFAULT '0' COMMENT 'Numero resolución a modificar',
  `fecha_resolucion` date NOT NULL COMMENT 'Fecha resolución a modificar',
  `eliminar` int(11) NOT NULL DEFAULT '0' COMMENT '0=No se elimina; 1=Se elimina. Es para cuando un turno anterior es modificado',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_creador` int(11) NOT NULL,
  `cantidad_locales` int(11) NOT NULL DEFAULT '0',
  `turno_firmado` tinyint(4) NOT NULL DEFAULT '0',
  `fk_seremi_firmador` int(11) NOT NULL,
  `fecha_firma` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nombre_archivo_firmado` varchar(1000) NOT NULL,
  `fk_usuario_visador` int(11) NOT NULL,
  `turno_visado` int(11) NOT NULL DEFAULT '0',
  `html_turno_visado` longtext NOT NULL,
  `turno_visado_fecha` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `horario` varchar(2000) NOT NULL,
  `estado_turno` int(1) NOT NULL DEFAULT '1' COMMENT '1=activo',
  `gob_fecha_notifica` date NOT NULL,
  `gob_nombre_notificador` varchar(250) NOT NULL,
  `gob_forma_notifica` varchar(200) NOT NULL,
  `gob_descripcion` varchar(1000) NOT NULL,
  `gob_fk_usuario` int(11) NOT NULL COMMENT 'Usuario que ingresa datos',
  `gob_fc_creacion` date NOT NULL,
  `gob_estado` varchar(200) NOT NULL DEFAULT 'ingresado',
  PRIMARY KEY (`turno_id`),
  UNIQUE KEY `turno_id` (`turno_id`),
  KEY `fk_region` (`fk_region`),
  KEY `fk_localidad` (`fk_localidad`),
  KEY `cod_resolucion` (`cod_resolucion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7339 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_cod_resolucion`
--

CREATE TABLE IF NOT EXISTS `turno_cod_resolucion` (
  `tcr_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_region` int(11) NOT NULL,
  `tcr_correlativo` int(11) NOT NULL,
  `año` varchar(4) NOT NULL DEFAULT '2020',
  `tcr_cod_resolucion` varchar(20) NOT NULL COMMENT 'Codigo de Resolucion Completo',
  `tcr_usado` int(1) NOT NULL DEFAULT '0' COMMENT '0=NO 1=SI',
  `tcr_fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tcr_id`),
  UNIQUE KEY `tcr_cod_resolucion` (`tcr_cod_resolucion`),
  KEY `tcr_id` (`tcr_id`),
  KEY `fk_region` (`fk_region`),
  KEY `tcr_cod_resolucion_2` (`tcr_cod_resolucion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1002 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_cod_resolucion_2016`
--

CREATE TABLE IF NOT EXISTS `turno_cod_resolucion_2016` (
  `tcr_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_region` int(11) NOT NULL,
  `tcr_correlativo` int(11) NOT NULL,
  `año` varchar(4) NOT NULL DEFAULT '2016',
  `tcr_cod_resolucion` varchar(20) NOT NULL COMMENT 'Codigo de Resolucion Completo',
  `tcr_usado` int(1) NOT NULL DEFAULT '0' COMMENT '0=NO 1=SI',
  `tcr_fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tcr_id`),
  UNIQUE KEY `tcr_cod_resolucion` (`tcr_cod_resolucion`),
  KEY `tcr_id` (`tcr_id`),
  KEY `fk_region` (`fk_region`),
  KEY `tcr_cod_resolucion_2` (`tcr_cod_resolucion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1214 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_cod_resolucion_2017`
--

CREATE TABLE IF NOT EXISTS `turno_cod_resolucion_2017` (
  `tcr_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_region` int(11) NOT NULL,
  `tcr_correlativo` int(11) NOT NULL,
  `año` varchar(4) NOT NULL DEFAULT '2017',
  `tcr_cod_resolucion` varchar(20) NOT NULL COMMENT 'Codigo de Resolucion Completo',
  `tcr_usado` int(1) NOT NULL DEFAULT '0' COMMENT '0=NO 1=SI',
  `tcr_fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tcr_id`),
  UNIQUE KEY `tcr_cod_resolucion` (`tcr_cod_resolucion`),
  KEY `tcr_id` (`tcr_id`),
  KEY `fk_region` (`fk_region`),
  KEY `tcr_cod_resolucion_2` (`tcr_cod_resolucion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=667 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_cod_resolucion_2019`
--

CREATE TABLE IF NOT EXISTS `turno_cod_resolucion_2019` (
  `tcr_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_region` int(11) NOT NULL,
  `tcr_correlativo` int(11) NOT NULL,
  `año` varchar(4) NOT NULL DEFAULT '2018',
  `tcr_cod_resolucion` varchar(20) NOT NULL COMMENT 'Codigo de Resolucion Completo',
  `tcr_usado` int(1) NOT NULL DEFAULT '0' COMMENT '0=NO 1=SI',
  `tcr_fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tcr_id`),
  UNIQUE KEY `tcr_cod_resolucion` (`tcr_cod_resolucion`),
  KEY `tcr_id` (`tcr_id`),
  KEY `fk_region` (`fk_region`),
  KEY `tcr_cod_resolucion_2` (`tcr_cod_resolucion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1434 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_cod_resolucion_old`
--

CREATE TABLE IF NOT EXISTS `turno_cod_resolucion_old` (
  `tcr_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_region` int(11) NOT NULL,
  `tcr_correlativo` int(11) NOT NULL,
  `año` varchar(4) NOT NULL DEFAULT '2015',
  `tcr_cod_resolucion` varchar(20) NOT NULL COMMENT 'Codigo de Resolucion Completo',
  `tcr_usado` int(1) NOT NULL DEFAULT '0' COMMENT '0=NO 1=SI',
  `tcr_fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tcr_id`),
  UNIQUE KEY `tcr_cod_resolucion` (`tcr_cod_resolucion`),
  KEY `tcr_id` (`tcr_id`),
  KEY `fk_region` (`fk_region`),
  KEY `tcr_cod_resolucion_2` (`tcr_cod_resolucion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=654 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_complemento`
--

CREATE TABLE IF NOT EXISTS `turno_complemento` (
  `id_complemento` int(11) NOT NULL AUTO_INCREMENT,
  `dia_complemento` date NOT NULL,
  `dia_termino_complemento` date NOT NULL,
  `fk_local_complemento` bigint(20) NOT NULL,
  `fk_turno` int(11) NOT NULL,
  `turno_hora_inicio` time NOT NULL DEFAULT '00:00:00',
  `turno_hora_termino` time NOT NULL DEFAULT '00:00:00',
  `complemento_confirmado` int(1) NOT NULL,
  `fecha_creacion_complemento` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_complemento`),
  KEY `id_complemento` (`id_complemento`),
  KEY `fk_turno` (`fk_turno`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2517 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_copia`
--

CREATE TABLE IF NOT EXISTS `turno_copia` (
  `turno_id` int(11) NOT NULL AUTO_INCREMENT,
  `turno_fecha_inicio` date NOT NULL,
  `turno_fecha_termino` date NOT NULL,
  `fk_region` int(11) NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `fk_localidad` int(11) NOT NULL,
  `turno_tipo` enum('URGENCIA','PARCIAL1','PARCIAL2','PARCIAL3','PARCIAL4','PARCIAL5','DIARIO','DIARIO2','DIARIO3','DIARIO4','DIARIO5','SEMANAL1','SEMANAL2','SEMANAL3','SEMANAL4','SEMANAL5','SEMANAL6','SEMANAL7','ESPECIFICA') NOT NULL,
  `turno_hora_inicio` time NOT NULL,
  `turno_hora_termino` time NOT NULL,
  `turno_rotacion` enum('DIARIA','SEMANAL','MENSUAL','SEMESTRAL') NOT NULL,
  `turno_periodo` enum('Primer','Segundo','Tercer','Cuarto') DEFAULT NULL,
  `cod_resolucion` varchar(20) NOT NULL COMMENT 'Numero de esta resolucion',
  `num_resolucion` varchar(20) NOT NULL DEFAULT '0' COMMENT 'Numero resolución a modificar',
  `fecha_resolucion` date NOT NULL COMMENT 'Fecha resolución a modificar',
  `eliminar` int(11) NOT NULL DEFAULT '0' COMMENT '0=No se elimina; 1=Se elimina. Es para cuando un turno anterior es modificado',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cantidad_locales` int(11) NOT NULL DEFAULT '0',
  `turno_firmado` tinyint(4) NOT NULL DEFAULT '0',
  `fk_seremi_firmador` int(11) NOT NULL,
  `fecha_firma` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nombre_archivo_firmado` varchar(1000) NOT NULL,
  `fk_usuario_visador` int(11) NOT NULL,
  `turno_visado` int(11) NOT NULL DEFAULT '0',
  `html_turno_visado` longtext NOT NULL,
  `turno_visado_fecha` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `horario` varchar(2000) NOT NULL,
  `estado_turno` int(1) NOT NULL DEFAULT '1' COMMENT '1=activo',
  PRIMARY KEY (`turno_id`),
  UNIQUE KEY `turno_id` (`turno_id`),
  KEY `turno_id_2` (`turno_id`),
  KEY `fk_region` (`fk_region`),
  KEY `fk_localidad` (`fk_localidad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1517 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_detalle`
--

CREATE TABLE IF NOT EXISTS `turno_detalle` (
  `turno_detalle_id` int(11) NOT NULL AUTO_INCREMENT,
  `turno_dia` date NOT NULL,
  `turno_dia_termino` date DEFAULT NULL,
  `fk_turno_excepcion` int(11) DEFAULT '0',
  `fk_turno` int(11) NOT NULL,
  `fk_local` int(11) NOT NULL,
  `fk_local_original` int(11) NOT NULL COMMENT 'Local Original que Debio Hacer Turno',
  `continuado` int(1) NOT NULL DEFAULT '1' COMMENT '1=SI; 0=NO',
  `detalle_hora_inicio` time NOT NULL,
  `detalle_siesta_inicio` time NOT NULL DEFAULT '00:00:00',
  `detalle_siesta_termino` time NOT NULL DEFAULT '00:00:00',
  `detalle_hora_termino` time NOT NULL,
  `cerrado` int(11) NOT NULL DEFAULT '0' COMMENT '1= SI; 0=NO',
  `fk_turno_detalle_quimico` int(11) DEFAULT NULL COMMENT 'Es quien cubre el turno',
  `turno_detalle_confirmado` tinyint(1) NOT NULL,
  PRIMARY KEY (`turno_detalle_id`),
  KEY `turno_detalle_id` (`turno_detalle_id`),
  KEY `fk_turno` (`fk_turno`),
  KEY `fk_local` (`fk_local`),
  KEY `turno_dia` (`turno_dia`),
  KEY `fk_local_original` (`fk_local_original`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=667669 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_detalle_copia`
--

CREATE TABLE IF NOT EXISTS `turno_detalle_copia` (
  `turno_detalle_id` int(11) NOT NULL AUTO_INCREMENT,
  `turno_dia` date NOT NULL,
  `turno_dia_termino` date DEFAULT NULL,
  `fk_turno_excepcion` int(11) DEFAULT '0',
  `fk_turno` int(11) NOT NULL,
  `fk_local` int(11) NOT NULL,
  `fk_local_original` int(11) NOT NULL COMMENT 'Local Original que Debio Hacer Turno',
  `continuado` int(1) NOT NULL DEFAULT '0' COMMENT '1=SI; 0=NO',
  `detalle_hora_inicio` time NOT NULL,
  `detalle_siesta_inicio` time NOT NULL DEFAULT '00:00:00',
  `detalle_siesta_termino` time NOT NULL DEFAULT '00:00:00',
  `detalle_hora_termino` time NOT NULL,
  `cerrado` int(11) NOT NULL DEFAULT '0' COMMENT '1= SI; 0=NO',
  `fk_turno_detalle_quimico` int(11) DEFAULT NULL COMMENT 'Es quien cubre el turno',
  `turno_detalle_confirmado` tinyint(1) NOT NULL,
  PRIMARY KEY (`turno_detalle_id`),
  KEY `turno_detalle_id` (`turno_detalle_id`),
  KEY `fk_turno` (`fk_turno`),
  KEY `fk_local` (`fk_local`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=143579 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_detalle_esp`
--

CREATE TABLE IF NOT EXISTS `turno_detalle_esp` (
  `turno_detalle_id` int(11) NOT NULL AUTO_INCREMENT,
  `turno_dia` date NOT NULL,
  `turno_dia_termino` date DEFAULT NULL,
  `fk_turno_excepcion` int(11) DEFAULT '0',
  `fk_turno` int(11) NOT NULL,
  `fk_local` int(11) NOT NULL,
  `fk_local_original` int(11) NOT NULL COMMENT 'Local Original que Debio Hacer Turno',
  `continuado` int(1) NOT NULL DEFAULT '0' COMMENT '1=SI; 0=NO',
  `detalle_hora_inicio` time NOT NULL,
  `detalle_siesta_inicio` time NOT NULL DEFAULT '00:00:00',
  `detalle_siesta_termino` time NOT NULL DEFAULT '00:00:00',
  `detalle_hora_termino` time NOT NULL,
  `cerrado` int(1) NOT NULL DEFAULT '0' COMMENT '1= SI; 0=NO',
  `fk_turno_detalle_quimico` int(11) DEFAULT NULL COMMENT 'Es quien cubre el turno',
  `turno_detalle_confirmado` tinyint(1) NOT NULL,
  PRIMARY KEY (`turno_detalle_id`),
  KEY `turno_detalle_id` (`turno_detalle_id`),
  KEY `fk_turno` (`fk_turno`),
  KEY `fk_local` (`fk_local`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_detalle_quimico`
--

CREATE TABLE IF NOT EXISTS `turno_detalle_quimico` (
  `turno_detalle_quimico_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_turno_detalle` int(11) NOT NULL,
  `fk_quimico` int(11) NOT NULL,
  PRIMARY KEY (`turno_detalle_quimico_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7857 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_esp`
--

CREATE TABLE IF NOT EXISTS `turno_esp` (
  `turno_id` int(11) NOT NULL AUTO_INCREMENT,
  `turno_fecha_inicio` date NOT NULL,
  `turno_fecha_termino` date NOT NULL,
  `fk_region` int(11) NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `fk_localidad` int(11) NOT NULL,
  `turno_tipo` enum('URGENCIA','PARCIAL1','PARCIAL2','PARCIAL3','PARCIAL4','PARCIAL5','DIARIO','DIARIO2','DIARIO3','DIARIO4','DIARIO5','SEMANAL1','SEMANAL2','SEMANAL3','SEMANAL4','SEMANAL5','SEMANAL6','ESPECIFICA') NOT NULL,
  `turno_hora_inicio` time NOT NULL,
  `turno_hora_termino` time NOT NULL,
  `turno_rotacion` enum('DIARIA','SEMANAL','MENSUAL','SEMESTRAL') NOT NULL,
  `turno_periodo` enum('Primer','Segundo','Tercer','Cuarto') DEFAULT NULL,
  `cod_resolucion` varchar(20) NOT NULL COMMENT 'Numero de esta resolucion',
  `num_resolucion` varchar(20) NOT NULL DEFAULT '0' COMMENT 'Numero resolución a modificar',
  `fecha_resolucion` date NOT NULL COMMENT 'Fecha resolución a modificar',
  `eliminar` int(11) NOT NULL DEFAULT '0' COMMENT '0=No se elimina; 1=Se elimina. Es para cuando un turno anterior es modificado',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cantidad_locales` int(11) NOT NULL DEFAULT '0',
  `turno_firmado` tinyint(4) NOT NULL DEFAULT '0',
  `fk_seremi_firmador` int(11) NOT NULL,
  `fecha_firma` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nombre_archivo_firmado` varchar(1000) NOT NULL,
  `fk_usuario_visador` int(11) NOT NULL,
  `turno_visado` int(11) NOT NULL DEFAULT '0',
  `html_turno_visado` longtext NOT NULL,
  `turno_visado_fecha` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`turno_id`),
  UNIQUE KEY `turno_id` (`turno_id`),
  KEY `turno_id_2` (`turno_id`),
  KEY `fk_region` (`fk_region`),
  KEY `fk_localidad` (`fk_localidad`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_especifica_urgencia`
--

CREATE TABLE IF NOT EXISTS `turno_especifica_urgencia` (
  `esp_urg_id` int(11) NOT NULL AUTO_INCREMENT,
  `esp_urg_tipo_resolucion` enum('Urgencia','Especifica') NOT NULL,
  `esp_urg_fecha_inicio` date NOT NULL,
  `esp_urg_fecha_termino` date NOT NULL,
  `esp_urg_fk_region` int(11) NOT NULL,
  `esp_urg_fk_comuna` int(11) NOT NULL,
  `esp_urg_fk_localidad` int(11) NOT NULL,
  `esp_urg_horario` varchar(1000) NOT NULL,
  `esp_urg_visado` int(1) NOT NULL,
  `esp_urg_fecha_visado` date NOT NULL,
  `esp_urg_fk_visador` int(11) NOT NULL,
  `esp_urg_firmado` int(1) NOT NULL,
  `esp_urg_fecha_firma` date NOT NULL,
  `esp_urg_fk_firmador` int(11) NOT NULL,
  `esp_urg_pdf` text NOT NULL,
  `esp_urg_archivo_firmado` varchar(200) NOT NULL,
  `esp_urg_fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `esp_urg_eliminar` int(1) NOT NULL,
  PRIMARY KEY (`esp_urg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_esp_urg_singed`
--

CREATE TABLE IF NOT EXISTS `turno_esp_urg_singed` (
  `teu_id` int(11) NOT NULL AUTO_INCREMENT,
  `teu_fk_region` int(11) DEFAULT NULL,
  `teu_fk_localidad` int(11) DEFAULT NULL,
  `teu_tipo_turno` varchar(10) DEFAULT NULL,
  `teu_archivo` varchar(200) DEFAULT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `teu_id` (`teu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_excepcion`
--

CREATE TABLE IF NOT EXISTS `turno_excepcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `excepcion_nombre` varchar(20) NOT NULL,
  `excepcion_descripcion` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_notifica`
--

CREATE TABLE IF NOT EXISTS `turno_notifica` (
  `tn_id` int(11) NOT NULL AUTO_INCREMENT,
  `cabecera` mediumtext NOT NULL,
  `datos` longtext NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_region` int(11) NOT NULL,
  `fk_usuario` int(11) NOT NULL COMMENT 'Usuario Creador',
  PRIMARY KEY (`tn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_resolucion`
--

CREATE TABLE IF NOT EXISTS `turno_resolucion` (
  `tr_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_turno_id` int(11) NOT NULL,
  `cod_resolucion` varchar(20) NOT NULL DEFAULT '0' COMMENT 'Numero de esta resolucion',
  `tr_firmado` int(1) NOT NULL DEFAULT '0',
  `fk_seremi_firmador` int(11) NOT NULL,
  `tr_fecha_firma` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nombre_archivo_firmado` varchar(1000) NOT NULL,
  `fk_usuario_visador` int(11) NOT NULL,
  `tr_visado` int(1) NOT NULL DEFAULT '0',
  `modificado` int(1) NOT NULL DEFAULT '0' COMMENT '1=Modificado',
  `html_turno_visado` longtext NOT NULL,
  `tr_visado_fecha` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tr_estado` int(1) NOT NULL DEFAULT '1' COMMENT '1=Activo',
  `tr_fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tr_id`),
  KEY `fk_turno_id` (`fk_turno_id`),
  KEY `cod_resolucion` (`cod_resolucion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5925 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_resolucion_doc`
--

CREATE TABLE IF NOT EXISTS `turno_resolucion_doc` (
  `tr_doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tr_doc_tipo` enum('TURNO','ESPECIFICA','URGENCIA') DEFAULT NULL,
  `tr_doc_nombre` varchar(200) NOT NULL,
  `tr_doc_contenido` longtext NOT NULL,
  `tr_doc_estado` int(1) DEFAULT '1' COMMENT '1=Vigente',
  `fk_region` int(11) DEFAULT NULL COMMENT '0=Todas',
  `tr_doc_principal` int(1) NOT NULL,
  `fk_usuario_creador` int(11) DEFAULT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_usuario_edicion` int(11) NOT NULL,
  `fc_edicion` datetime DEFAULT NULL,
  PRIMARY KEY (`tr_doc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `turno_tipo_resolucion`
--

CREATE TABLE IF NOT EXISTS `turno_tipo_resolucion` (
  `turno_tipo_id` int(11) NOT NULL AUTO_INCREMENT,
  `turno_tipo_fk_region` int(11) NOT NULL,
  `turno_tipo_principal` int(1) NOT NULL,
  `turno_tipo_nombre` varchar(255) NOT NULL,
  `turno_tipo_forma` enum('TURNO','URGENCIA','ESPECIFICA') NOT NULL,
  `turno_tipo_fc_edicion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`turno_tipo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
  `venta_id` int(11) NOT NULL AUTO_INCREMENT,
  `venta_id_medico` varchar(12) NOT NULL,
  `id_vendedor` varchar(100) NOT NULL,
  `fk_region` int(11) NOT NULL,
  `fecha_transaccion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `archivo_boleta` varchar(100) DEFAULT NULL COMMENT 'archivo boleta',
  `fecha_pago` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gl_tramite` varchar(255) NOT NULL COMMENT 'Tramite ASDigital',
  `monto` int(11) NOT NULL DEFAULT '0',
  `precio_unitario` int(11) NOT NULL DEFAULT '0',
  `comprobante_pago` varchar(100) NOT NULL,
  `estado_pago` int(1) NOT NULL DEFAULT '1' COMMENT '0=Nulo;2=Pago Caja;3=Pago Web',
  `fecha_estado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha Cambio Estado',
  `estado_venta` int(1) NOT NULL DEFAULT '1' COMMENT '0=Inactivo; 1=Activo; 2=Regularizado',
  `nr_intentos` int(11) DEFAULT '1',
  PRIMARY KEY (`venta_id`),
  KEY `venta_id` (`venta_id`),
  KEY `id_vendedor` (`id_vendedor`),
  KEY `venta_id_medico` (`venta_id_medico`),
  KEY `fk_region` (`fk_region`),
  KEY `archivo_boleta` (`archivo_boleta`),
  KEY `comprobante_pago` (`comprobante_pago`),
  KEY `fecha_pago` (`fecha_pago`),
  KEY `fecha_transaccion` (`fecha_transaccion`),
  KEY `gl_tramite` (`gl_tramite`),
  KEY `estado_pago` (`estado_pago`),
  KEY `fecha_estado` (`fecha_estado`),
  KEY `estado_venta` (`estado_venta`),
  KEY `nr_intentos` (`nr_intentos`),
  KEY `nr_intentos_2` (`nr_intentos`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=87221 ;

-- --------------------------------------------------------

--
-- Table structure for table `ws_acceso_sistemas`
--

CREATE TABLE IF NOT EXISTS `ws_acceso_sistemas` (
  `id_sistema` int(11) NOT NULL AUTO_INCREMENT,
  `gl_nombre_sistema` varchar(250) DEFAULT NULL,
  `gl_base` varchar(250) DEFAULT NULL,
  `gl_ambiente` varchar(100) DEFAULT NULL,
  `json_permisos` longtext,
  `gl_key_public` varchar(128) DEFAULT NULL,
  `gl_key_private` varchar(256) DEFAULT NULL,
  `gl_url_sistema` longtext,
  `gl_url_exito` longtext,
  `gl_url_error` longtext,
  `bo_estado` int(1) DEFAULT '1',
  `id_usuario_crea` int(11) DEFAULT '0',
  `fc_crea` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sistema`),
  KEY `gl_key_public` (`gl_key_public`),
  KEY `bo_estado` (`bo_estado`),
  KEY `gl_nombre_sistema` (`gl_nombre_sistema`),
  KEY `id_usuario_crea` (`id_usuario_crea`),
  KEY `gl_base` (`gl_base`),
  KEY `gl_ambiente` (`gl_ambiente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ws_acceso_sistemas_historial`
--

CREATE TABLE IF NOT EXISTS `ws_acceso_sistemas_historial` (
  `id_auditoria_ws` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT '0',
  `id_sistema` int(11) DEFAULT '0',
  `gl_rut` varchar(255) DEFAULT NULL,
  `gl_origen` varchar(100) DEFAULT NULL,
  `gl_public_key` varchar(255) DEFAULT NULL,
  `gl_hash` varchar(255) DEFAULT NULL,
  `gl_ws_version` varchar(50) DEFAULT NULL,
  `gl_ws_metodo` varchar(50) DEFAULT NULL,
  `bo_ws_success` int(1) DEFAULT '0',
  `gl_ws_ejecucion_time` varchar(50) DEFAULT NULL,
  `json_auditoria` longtext,
  `json_respuesta` longtext,
  `id_usuario_crea` int(11) DEFAULT NULL,
  `fc_crea` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_auditoria_ws`),
  KEY `IDX_id_usuario` (`id_usuario`),
  KEY `IDX_gl_rut` (`gl_rut`),
  KEY `IDX_gl_origen` (`gl_origen`),
  KEY `id_sistema` (`id_sistema`),
  KEY `gl_public_key` (`gl_public_key`),
  KEY `gl_ws_version` (`gl_ws_version`),
  KEY `gl_ws_metodo` (`gl_ws_metodo`),
  KEY `bo_ws_success` (`bo_ws_success`),
  KEY `fc_crea` (`fc_crea`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5206 ;

-- --------------------------------------------------------

--
-- Table structure for table `ws_acceso_sistemas_token`
--

CREATE TABLE IF NOT EXISTS `ws_acceso_sistemas_token` (
  `id_webservice_token` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gl_rut` varchar(20) DEFAULT NULL,
  `gl_token` varchar(255) DEFAULT NULL,
  `gl_ambiente` varchar(200) DEFAULT 'TEST',
  `gl_public_key` varchar(255) DEFAULT NULL,
  `json_respuesta` longtext,
  `bo_utilizado` int(1) DEFAULT '0' COMMENT '1=SI',
  `id_usuario_actualiza` int(11) DEFAULT NULL,
  `fc_actualiza` timestamp NULL DEFAULT NULL,
  `id_usuario_crea` int(11) DEFAULT '0',
  `fc_crea` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_webservice_token`),
  KEY `gl_rut` (`gl_rut`),
  KEY `gl_ambiente` (`gl_ambiente`),
  KEY `bo_utilizado` (`bo_utilizado`),
  KEY `gl_hash` (`gl_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=888 ;

-- --------------------------------------------------------

--
-- Table structure for table `ws_key`
--

CREATE TABLE IF NOT EXISTS `ws_key` (
  `id_ws_key` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `key_public` varchar(45) NOT NULL,
  `key_private` varchar(45) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ws_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
