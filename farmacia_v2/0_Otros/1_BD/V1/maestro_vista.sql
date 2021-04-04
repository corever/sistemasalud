-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 12:56 PM
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
-- Dumping data for table `maestro_vista`
--

INSERT INTO `maestro_vista` (`m_v_id`, `nombre_vista`, `link_vista`, `img`, `fk_modulo`) VALUES
(1, 'Crear Emp. Farmacéutica', 'crear_farmacia', 'img', 1),
(2, 'Crear Est. Farmacéutico', 'crear_local', 'img', 1),
(3, 'Registrar Profesional de la Salud', 'registrar_quimico', 'img', 1),
(4, 'Administrar Empresas', 'administrar_farmacias', 'img', 1),
(5, 'Administrar Establecimientos', 'administrar_locales', 'img', 1),
(6, 'Administrar Profesional de la Salud', 'administrar_quimicos', 'img', 1),
(7, 'Despacho Recetas Cheque', 'recetacheque', 'img', 2),
(9, 'Despacho Recetas Retenida', 'recetaretenida', 'img', 2),
(12, 'Registrar Medicamentos', 'recetaSinCodigo', 'img', 2),
(13, 'Administrar Recetas', 'administrar', 'img', 2),
(14, 'Programar Turno', 'programar_turno', 'img', 3),
(15, 'Administrar Turnos', 'administrar', 'img', 3),
(16, 'Turnos Confirmados', 'administrar_confirmados', 'img', 3),
(17, 'Ver Turnos', 'ver_turnos', 'img', 3),
(18, 'Mi Bodega', 'mi_bodega', 'img', 5),
(19, 'Crear Bodega', 'crear_bodega', 'img', 5),
(20, 'Administrar Bodegas', 'administrar_bodegas', 'img', 5),
(21, 'Ingresar Talonarios', 'crear_talonario', 'img', 5),
(22, 'Venta de Talonarios', 'venta_talonario', 'img', 5),
(23, 'Reportar Talonario', 'reportar_unitario', 'img', 5),
(24, 'Crear Usuario', 'registrar_usuario', 'img', 6),
(25, 'Administrar usuario', 'administrar_usuario', 'img', 6),
(26, 'Administrar DT', 'administrar_dt', 'img', 6),
(27, 'Registrar Vendedor', 'registrar_vendedor_talo', 'img', 6),
(28, 'Informe Horarios Turno', 'informe_horario_turno', 'img', 7),
(29, 'Resoluciones Urgencia', 'resolucion_urgencia', 'img', 3),
(30, 'Informe Talonario Bodega', 'informe_talonario_bodega', 'img', 7),
(31, 'Informe Cheques Denunciados', 'informe_cheque_denuncia', 'img', 7),
(32, 'Informe Recetas Ingresadas', 'informe_recetas_en_sistema', 'img', 7),
(33, 'Informe Establecimiento Farmaceutico', 'informe_establecimientos_f', 'img', 7),
(36, 'Informe Empresas Farmaceuticas', 'informe_empresas_f', 'img', 7),
(37, 'Informe Venta Talonario', 'informe_venta_talonario', 'img', 7),
(38, 'Crear Local Venta', 'crear_bodega', 'img', 5),
(39, 'Detalle Local', 'ver_establecimiento', 'img', 1),
(40, 'Administración Químico Farmacéutico', 'administrar_quimicos', 'img', 1),
(41, 'Horario Funcionamiento', 'rotacion_semanal', 'img', 1),
(42, 'Asignar Turno', 'asignar', 'img', 3),
(43, 'Reportar Receta', 'reportar_unitario', 'img', 5),
(51, 'Resoluciones  Especifica', 'resolucion_especifica', 'img', 3),
(44, 'Maestro Usuario', 'maestro_usuario', 'img', 8),
(45, 'Maestro Medicamento', 'maestro_medicamento', 'img', 8),
(46, 'Maestro Empresa Farmacéutica', 'maestro_empresa', 'img', 8),
(47, 'Maestro Establecimiento Farmacéutico', 'maestro_establecimiento', 'img', 8),
(48, 'Maestro Territorio', 'maestro_territorio', 'img', 8),
(49, 'Maestro Localidad', 'maestro_localidad', 'img', 8),
(50, 'Ingresar', 'ingreso_oc', 'img', 9),
(52, 'Denuncia Receta', 'subir_receta', 'img', 10),
(53, 'Bodega Medicamento', 'detalle_bodega_local', 'img', 9),
(54, 'Libro Movimiento', 'libro_medicamento', 'img', 9),
(55, 'Administrar Recetas Denunciadas', 'ver_denuncias_receta', 'img', 2),
(56, 'Ver Recetas Denunciadas', 'ver_receta_denunciada', 'img', 2),
(57, 'Top Ten Denuncias', 'IG_denuncia_farmacia', 'img', 11),
(58, 'Top Ten Medicamento', 'IG_medicamento_mas_vendido', 'img', 11),
(59, 'Alarmas', 'tablero', 'img', 12),
(60, 'Farmacia sin Confirmación Turno', 'turno_sin_confirmar', 'img', 12),
(61, 'Farmacia con Horario no Cubierto', 'horario_no_cubierto', 'img', 12),
(62, 'Farmacia sin DT Activo', 'sin_dt', 'img', 12),
(63, 'Roles de Usuario Cruzados', 'roles_cruzados', 'img', 12),
(64, 'Doble Dirección Técnica', 'doble_dt', 'img', 12),
(65, 'Administrar Denuncias Local', 'administrar_denuncia_local', 'img', 1),
(66, 'Administrar Medicos Cirujanos', 'administrar_medicos', 'img', 10),
(67, 'Crear Medico Cirujano', 'registrar_medico', 'img', 10),
(68, 'Administrar Firmante', 'administrar_seremi', '', 3),
(69, 'Editar Ordenamiento', 'editar_ordenamiento', '', 3),
(71, 'Ver Turnos Firmados', 'administrar_resoluciones_turno_nacional', 'img', 3),
(72, 'Informe Recetas Ingresadas', 'informe_recetas_en_sistema', 'img', 7),
(73, 'Informe Personal Farmaceutico', 'informe_personal_farmacia', 'img', 7),
(74, 'Informe Medicamento en Local', 'informe_medicamento_local', 'img', 7),
(75, 'Informe Denuncias Establecimiento (mapa)', 'informe_denuncias_mapa', 'img', 7),
(76, 'Informe Recetas Denunciadas', 'informe_recetas_denunciadas', 'img', 7),
(77, 'Informe Consulta Usuarios', 'informe_consulta_usuario', 'img', 7),
(78, 'Informe Detalle Recetas', 'informe_detalle_receta', 'img', 7),
(79, 'INFORME CLASIFICACION ESTABLECIMIENTOS', 'informe_conteo_est_farma', 'img', 7),
(80, 'SITUACION FARMACEUTICA', 'informe_situacion_farmacia', 'img', 7),
(81, 'INDICADORES FARMACEUTICOS', 'informe_ind_farma', 'img', 7),
(82, 'INFORME CLASIFICACION ESTABLECIMIENTO', 'informe_clasificacion_est', 'IMG', 7),
(83, 'Mayor Prescripción Recetas ', 'IG_pres_recetas', 'img', 11),
(84, 'Top Ten Locales De Venta', 'IG_top_locales_venta', 'img', 11),
(85, 'Top Ten Médicos Talonarios', 'IG_top_medicos_talonario', 'img', 11),
(86, 'Administrar Ventas Cheque', 'administrar_ventas_talonario', 'img', 5),
(87, 'Informe Ingreso Talonario Bodega', 'informe_ingreso_talonario_bodega', 'img', 7),
(88, 'Ver Turnos Firmados', 'ver_turnos_firmados', 'img', 3),
(89, 'Denuncia Receta', 'denuncia_receta', 'img', 5),
(90, 'IP Cadena Farmaceutica', 'ver_ip_establecimiento', 'img', 1),
(91, 'Visitas turnosdefarmacia.cl', 'IG_turnosdefarmacia', 'img', 11),
(92, 'Ver Sumarios', 'ver_sumario', '', 1),
(93, 'Informacion Usuarios', 'informacion_usuario', 'img', 6),
(94, 'Gobierno Transparente', 'gobierno_transparente', 'img', 3),
(95, 'Reclamos turnosdefarmacia.cl', 'IG_reclamos_farmacia', 'img', 11),
(96, 'Historial Farmanet', 'IG_historial', 'img', 11),
(97, 'Informe Talonarios (RAKIN)', 'informe_rakin', 'img', 7),
(98, 'Ver QF Turno', 'ver_asignacion_turno', 'img', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
