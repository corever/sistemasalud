-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: 10.8.139.4
-- Generation Time: Jul 20, 2020 at 12:03 PM
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
-- Dumping data for table `bodega`
--

INSERT INTO `bodega` (`bodega_id`, `bodega_nombre`, `bodega_direccion`, `fk_region`, `fk_territorio`, `fk_comuna`, `fk_localidad`, `bodega_id_usuario`, `bodega_telefono`, `bodega_fono`, `bodega_fono_codigo`, `bodega_estado`, `fk_bodega_tipo`) VALUES
(20, 'CEN_VALPARAISO', 'ERRAZURIZ 1744', 6, 0, 0, 0, 320, '2571578', '', '', 1, 1),
(21, 'INT_TERRITORIAL VALPARAISO', 'YUNGAY 1725', 6, 1, 0, NULL, 321, '2575463', '', '', 1, 2),
(26, 'LV_VIÑA DEL MAR', 'QUINTA 236', 6, 2, 80, NULL, 360, '+5632234234', '', '', 1, 3),
(23, 'INT_TERRITORIAL VIÑA DEL MAR', 'QUINTA 231', 6, 2, 0, NULL, 322, '+56322572724', '', '', 1, 2),
(24, 'INT_PROVINCIAL QUILLOTA', 'FREIRE 317', 6, 3, 0, NULL, 325, '+56332573694', '', '', 1, 2),
(25, 'INT_PROVINCIAL ACONCAGUA', 'SALINAS 352', 6, 4, 0, NULL, 324, '+56324493143', '', '', 1, 2),
(27, 'LV_VALPARAISO', 'YUNGAY 1725', 6, 1, 78, NULL, 695, '+56335646546', '', '', 1, 3),
(30, 'CEN_ARICA', 'PSDJE CANCURA 162-A', 1, 0, 0, NULL, 320, '+56323243242', '', '', 1, 1),
(32, 'LV_SSRV', 'PASAJE EN LA ESQUINA DE CANCURA', 6, 1, 0, NULL, 233, '+563212338', '', '', 1, 3),
(34, 'INT_TERRITORIAL MARGA-MARGA', 'THOMPSON 1282', 6, 5, 0, NULL, 323, '+56322578738', '', '', 1, 2),
(35, 'LV_QUILLOTA', 'FREIRE Nº 317 QUILLOTA', 6, 3, 69, NULL, 325, '+56332293691', '', '', 1, 3),
(36, 'LV_SAN FELIPE', 'SALINAS 352', 6, 4, 75, NULL, 340, '2493131', '', '', 1, 3),
(37, 'CEN_METROPOLITANA', 'SANTIAGO #1234', 7, 0, 0, NULL, 233, '+56022555555', '', '', 1, 1),
(48, 'INT_TERRITORIAL_PUERTO_MONTT', 'ANTONIO VARAS 216', 13, 28, 0, NULL, 1182, '+56652326014', '', '', 1, 2),
(40, 'INT_TERRITORIAL CONCEPCION', 'O´HIGGINS 241 OF 406-407, CONCEPCIÓN', 10, 8, 0, NULL, 708, '6115', '', '', 1, 2),
(41, 'CEN_BIO_BIO', '.', 10, 0, 0, 0, 708, '+5641555555', '', '', 1, 1),
(84, 'LV_CONCEPCION', 'O´HIGGINS 241 OF 406-407', 10, 8, 210, NULL, 712, '+56412726115', '', '', 1, 3),
(43, 'INT_TERRITORIAL ÑUBLE', 'BULNES N°620', 16, 9, 0, NULL, 252, '2585288', '', '', 1, 2),
(44, 'INT_TERRITORIAL BIO-BIO', 'RICARDO VICUÑA N° 371, LOS ÁNGELES', 10, 7, 0, NULL, 252, '2555555', '', '', 1, 2),
(45, 'LV_LOS ANGELES', 'AV. RICARDO VICUÑA 371', 10, 7, 220, NULL, 711, '+56432332874', '', '', 1, 3),
(46, 'LV_CHILLAN', 'BULNES N°620', 16, 9, 205, NULL, 710, '2585288', '', '', 1, 3),
(47, 'LV_QUILPUE', 'THOMPSON 1282', 6, 5, 70, NULL, 340, '2578720', '', '', 1, 3),
(49, 'INT_TERRITORIAL ARICA', 'MAIPU 410', 1, 16, 0, NULL, 718, '+56582204021', '', '', 1, 2),
(50, 'LV_ARICA', 'ARICA, 123', 1, 16, 1, NULL, 233, '+5658123456', '', '', 1, 3),
(53, 'INT_TERRITORIAL CENTRO', 'DIECIOCHO 120', 7, 14, 0, NULL, 9116, '25689957', '', '', 1, 2),
(54, 'LV_SANTIAGO', 'DIECIOCHO 120', 7, 14, 130, NULL, 9116, '25689957', '', '', 1, 3),
(55, 'CEN_MAGALLANES', 'MAGALLANES 1234', 15, 0, 0, NULL, 233, '+5661123456', '', '', 1, 1),
(56, 'INT_TERRITORIAL MAGALLANES', 'AV. BULNES Nº 0136', 15, 27, 0, NULL, 1213, '+56612291377', '', '', 1, 2),
(57, 'LV_PUNTA ARENAS', 'AV. BULNES Nº 0136', 15, 27, 339, NULL, 1213, '+56612291377', '', '', 1, 3),
(58, 'INT_TERRITORIAL OHIGGINS', 'BUERAS 555', 8, 21, 0, NULL, 1206, '2335332', '', '', 1, 2),
(59, 'CEN_TARAPACA', 'TARAPACA 123', 2, 0, 0, NULL, 233, '+565712345', '', '', 1, 1),
(60, 'CEN_ANTOFAGASTA', 'ANTOFAGASTA 123', 3, 0, 0, NULL, 233, '+56551234', '', '', 1, 1),
(61, 'CEN_ATACAMA', 'ATACAMA 1234', 4, 0, 0, NULL, 233, '+565112345', '', '', 1, 1),
(62, 'CEN_COQUIMBO', 'COQUIMBO 1234', 5, 0, 0, NULL, 233, '+56511234', '', '', 1, 1),
(63, 'CEN_MAULE', 'MAULE 1234', 9, 0, 0, NULL, 233, '+56751234', '', '', 1, 1),
(64, 'CEN_OHIGGINS', 'LIBERTADOR 12345', 8, 0, 0, NULL, 233, '+56721234', '', '', 1, 1),
(65, 'CEN_ARAUCANIA', 'ARAUCANIA 1234', 11, 0, 0, NULL, 233, '+56451234', '', '', 1, 1),
(66, 'CEN_LOS RIOS', 'RIOS 1234', 12, 0, 0, NULL, 233, '+56631234', '', '', 1, 1),
(67, 'CEN_AYSEN', 'AYSEN 1234', 14, 0, 0, NULL, 233, '+56671234', '', '', 1, 1),
(68, 'CEN_LOS LAGOS', 'LOS LAGOS 1234', 13, 0, 0, NULL, 233, '+5664123456', '', '', 1, 1),
(69, 'INT_TERRITORIAL DE LOS RIOS', 'GARCÍA REYES Nº 270 B, VALDIVIA', 12, 24, 0, NULL, 9841, '+56632265557', '', '', 1, 2),
(81, 'LV_PUERTO MONTT', 'ANTONIO VARAS 216 PISO 6 PUERTO MONTT', 13, 28, 311, NULL, 3575, '+56652326014', '', '', 1, 3),
(72, 'LV_OSORNO', 'M.RODRIGUEZ Nº759. OSORNO', 13, 25, 309, NULL, 3575, '+56645665233', '', '', 1, 3),
(85, 'INT_TERRITORIAL TARAPACA', 'BOLIVAR 472', 2, 17, 0, NULL, 1203, '+56572409876', '', '', 1, 2),
(75, 'LV_RANCAGUA', 'CAMPOS 423, PISO 6', 8, 21, 162, NULL, 1206, '+56722335332', '', '', 1, 3),
(76, 'INT_TERRITORIAL COQUIMBO', 'SAN JOAQUIN 1801', 5, 20, 0, NULL, 6029, '+56532663442', '', '', 1, 2),
(77, 'INT_TERRITORIAL COPIAPO', 'CHACABUCO N° 681', 4, 19, 0, NULL, 1211, '2465101', '', '', 1, 2),
(78, 'INT_TERRITORIAL_OSORNO', 'MANUEL RODRIGUEZ 759', 13, 25, 0, NULL, 1182, '6523260', '', '', 1, 2),
(79, 'INT_TERRITORIAL_CHILOE', 'O HIGGINS 762 CASTRO', 13, 29, 0, NULL, 1182, '+56656523262', '', '', 1, 2),
(80, 'LV_CASTRO', 'O', 13, 29, 296, NULL, 3575, '+56652326214', '', '', 1, 3),
(82, 'INT_TERRITORIAL AYSEN', 'CARRERA 290, COYHAIQUE', 14, 26, 0, NULL, 1212, '+56672261106', '', '', 1, 2),
(83, 'LV_AYSEN', 'CARRERA 290, COYHAIQUE', 14, 26, 324, NULL, 1212, '+56672261106', '', '', 1, 3),
(86, 'LV_IQUIQUE', 'BOLIVAR 472', 2, 17, 9, NULL, 1203, '+56572409876', '', '', 1, 3),
(87, 'LV_VALDIVIA', 'CHACABUCO Nº 700, VALDIVIA', 12, 24, 290, NULL, 1209, '+56632265557', '', '', 1, 3),
(88, 'INT_TERRITORIAL ANTOFAGASTA', 'M. A. MATTA Nª 1999, 3ª PISO', 3, 18, 0, NULL, 1204, '+56552655064', '', '', 1, 2),
(89, 'LV_ANTOFAGASTA', 'M. A. MATTA Nª 1999, 3ª PISO', 3, 18, 12, NULL, 6145, '2655064', '', '', 1, 3),
(90, 'LV_LA SERENA', 'AVENIDA FRANCISCO DE AGUIRRE N°477, LA SERENA', 5, 20, 36, NULL, 6029, '26', '', '', 1, 3),
(91, 'LV_COPIAPO', 'CHACABUCO N°635', 4, 19, 24, NULL, 1211, '+56522465101', '', '', 1, 3),
(95, 'INT_TERRITORIAL ARAUCANIA', 'MANUEL RODRIGUEZ 1070,OF. 210, TEMUCO', 11, 23, 0, NULL, 1208, '+56452551219', '', '', 1, 2),
(93, 'INT_TERRITORIAL MAULE', 'MAULE', 9, 22, 0, NULL, 252, '67', '', '', 1, 2),
(94, 'LV_MAULE', 'DIRECCION', 9, 22, 180, NULL, 252, '123456', '', '', 1, 3),
(96, 'LV_ISLA DE PASCUA', 'PRUEBA', 6, 1, 54, NULL, 252, '+5632321588', '', '', 1, 3),
(97, 'LV_TEMUCO', 'RODRIGUEZ 1070', 11, 23, 275, NULL, 8078, '+56452451210', '', '', 1, 3),
(98, 'INT_TERRITORIAL OVALLE', 'ANTONIO TIRADO 287', 5, 30, 0, NULL, 6029, '+56532663445', '', '', 1, 2),
(99, 'LV_OVALLE', 'ANTONIO TIRADO 287', 5, 30, 39, NULL, 6029, '+56532663445', '', '', 1, 3),
(100, 'INT_TERRITORIAL VALLENAR', 'PRAT N°1699', 4, 31, 0, NULL, 1211, '22331011', '', '', 1, 2),
(101, 'LV_VALLENAR', 'PRATT N° 1699', 4, 31, 29, NULL, 252, '+56512331017', '', '', 1, 3),
(102, 'INT_TERRITORIAL ILLAPEL', 'SALVADOR ALLENDE N°678, ILLAPEL', 5, 32, 0, NULL, 6029, '+56532663944', '', '', 1, 2),
(103, 'LV_ILLAPEL', 'SALVADOR ALLENDE N°678, ILLAPEL', 5, 32, 34, NULL, 6029, '+56532663944', '', '', 1, 3),
(105, 'CEN_ÑUBLE', 'VEGA DE SALDIAS 468', 16, 0, 0, 0, 710, '+5642123123', '', '', 1, 1),
(106, 'BODEGA_TALONARIOS_INUTILIZADOS', '', 0, 0, 0, NULL, 10794, '321581', '', '', 1, 1),
(107, 'INT_TERRITORIAL ARAUCO', 'LOS DURAZNOS N° 329, ARAUCO', 10, 6, 0, NULL, 708, '+56412688911', '', '', 1, 2),
(108, 'LV_ARAUCO', 'LOS DURAZNOS N° 329', 10, 6, 200, NULL, 15027, '+56412688911', '', '', 1, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
