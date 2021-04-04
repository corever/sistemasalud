-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 192.168.170.14
-- Tiempo de generación: 01-10-2020 a las 15:23:58
-- Versión del servidor: 5.6.44
-- Versión de PHP: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `test_farmacias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno_resolucion`
--

CREATE TABLE `turno_resolucion` (
  `tr_id` int(11) NOT NULL,
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
  `tr_fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `turno_resolucion`
--

INSERT INTO `turno_resolucion` (`tr_id`, `fk_turno_id`, `cod_resolucion`, `tr_firmado`, `fk_seremi_firmador`, `tr_fecha_firma`, `nombre_archivo_firmado`, `fk_usuario_visador`, `tr_visado`, `modificado`, `html_turno_visado`, `tr_visado_fecha`, `tr_estado`, `tr_fecha_creacion`) VALUES
(90, 5848, '0', 0, 0, '0000-00-00 00:00:00', '', 9778, 1, 0, '<html>\r\n							<head>\r\n								<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />\r\n								<style type=\'text/css\'>\r\n									.txt-header-calibri{font-size:7px;margin:0;padding:0;font-weight:bold; font-family:\'calibri\';}\r\n									p,span {margin:0;padding:0}\r\n									.sup1 {padding-top:0px;padding-bottom:0px;margin:0;border: 1px solid #c4d3dd; }\r\n								</style>\r\n							</head>\r\n							<body><br><div style=\'page-break-inside:avoid\'>\r\n\r\n	<table style=\'height: 220px; width: 600px;\'>\r\n		<tbody>\r\n			<tr>\r\n				<td style=\'text-align: center; width: 200px; \'>\r\n					<table border=\'0\' align=\'left\' valign=\'top\'>\r\n						<tbody>\r\n							<tr>\r\n								<td><img style=\'height: 136px; width: 150px; float: left; padding-left:0px;  padding-top:10px;\' src=\'http://farmanet.minsal.cl/img/pdf/logo_minsal.png\' alt=\'\' /></td>\r\n							</tr>\r\n							<tr>\r\n								<td style=\'text-align: left; font-family: arial, helvetica, sans-serif; font-size: 11px;\'></td>\r\n							</tr>\r\n						</tbody>\r\n					</table>\r\n				</td>\r\n				<td style=\'text-align: right;\'>\r\n					<table style=\'height: 200px; width: 500px; padding-left:60px;\' border=\'0\' align=\'right\'>\r\n						<tbody>\r\n							<tr>\r\n								<td style=\'text-align: justify; font-family: arial, helvetica, sans-serif; font-size: 12px;\'></td>\r\n							</tr>\r\n							<tr>\r\n								<td>\r\n								<p style=\'text-align: left;\'><strong><span style=\'font-family: arial, helvetica, sans-serif; font-size: 18px;\'>RESOLUCI&Oacute;N EXENTA N&deg; [Numero_Res]</span></strong></p>\r\n								<p style=\'text-align: left;\'>&nbsp;</p>\r\n								<p style=\'text-align: left;\'><span style=\'font-family: arial, helvetica, sans-serif; font-size: 16px;\'><strong>VALPARAISO, [Fecha_Res]</strong></span></p>\r\n								</td>\r\n							</tr>\r\n							<tr>\r\n								<td style=\'text-align: justify; font-family: arial, helvetica, sans-serif; font-size: 12px;\'></td>\r\n							</tr>\r\n						</tbody>\r\n					</table>\r\n				</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n	<br>\r\n	\r\n	\r\n	<p>\r\n		<div style=\'text-align: right; font-family: arial, helvetica, sans-serif; font-size: 14px;\'><strong>VISTOS</strong> estos antecedentes: Lo informado por la Unidad</div>\r\n		<div style=\'text-align: justify; font-family: arial, helvetica, sans-serif; font-size: 14px;\'>de Pol&iacute;ticas Farmac&eacute;uticas de la Secretar&iacute;a Regional Ministerial de Salud REGION DE VALPARAISO, relacionados con los turnos de farmacias de <strong> VIÑA DEL MAR. TENIENDO PRESENTE:</strong> Art. 5&deg; &nbsp;del D.F.L. N&deg; 725/1968 C&oacute;digo Sanitario, D.L. N&deg; 2763/79 Modificado por la Ley N&deg; 19.937 sobre Autoridad Sanitaria; Ley Nº 20.724 sobre F&aacute;rmacos; D.S. N&deg; 136/2004 Aprueba Reglamento del Ministerio de Salud, P&aacute;rrafo V T&iacute;tulo II del D.S. 466/84 que aprob&oacute; el Reglamento de Farmacias, Droguer&iacute;as, Almacenes Farmac&eacute;uticos, Botiquines y Dep&oacute;sitos Autorizados, Circular N&ordm; 17 del 29.04.2009 del Minsal; &nbsp;y las facultades conferidas por el D.S. N&deg; [Numero_Decreto] [Fecha_Decreto] del Ministerio de Salud dicto la siguiente:</div>\r\n	</p>\r\n	<br>\r\n	<br>\r\n	<p style=\'text-align: center;\'><strong><span style=\'font-family: arial, helvetica, sans-serif; font-size: 16px;\'>R &nbsp; &nbsp;E &nbsp; S &nbsp; O &nbsp; L &nbsp; U &nbsp; C &nbsp; I &nbsp; &Oacute; &nbsp; N</span></strong></p>\r\n	<p>&nbsp;</p>\r\n	<p>&nbsp;</p>									\r\n</div>\r\n	\r\n	\r\n	<div style=\'page-break-inside:avoid;text-align:justify;font-family: arial, helvetica, sans-serif; font-size: 14px;\'>\r\n		<span>1. <strong>ESTABL&Eacute;CESE</strong> los turnos de farmacia de urgencia para la comuna de VIÑA DEL MAR, para el per&iacute;odo comprendido entre el <strong> 01 de Julio de 2020 y 30 de Septiembre de 2020,</strong> desde el d&iacute;a 20 de Julio del presente año, la Farmacia Ahumada, Local 499 de Av. Liberta N&deg; 1191 realizará Cierre Definitivo y la Farmacia Ahumada 145 ubicada en Libertad N&deg; 335 asume el turno desde el d&iacute;a 20 de Julio de presente año, en los cuales se dispondrá:\r\n			<br><br> 	<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\r\n									<tbody>\r\n										<tr>\r\n											<td><br/><p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12px;\"><b>&nbsp;&nbsp;CRUZ VERDE</span></p><br/></td>\r\n											<td><br/><p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12px;\">	 &nbsp;&nbsp;AV. VALPARAISO N° 404</span></p><br/></td>\r\n										</tr>\r\n									</tbody>\r\n								</table>\r\n		</span>\r\n	</div>\r\n	<br>\r\n		\r\n	<div style=\'page-break-inside:avoid;text-align:justify;font-size:14px;\'>\r\n		<span style=\'font-family: arial, helvetica, sans-serif; font-size: 14px;\'>2. <strong>La farmacia de urgencia atender&aacute; p&uacute;blico en forma permanente los 365 d&iacute;as del a&ntilde;o y durante las 24 horas del d&iacute;a.</strong></span>\r\n	</div>\r\n	<br>\r\n\r\n	<div style=\'text-align: justify;\'>										\r\n		<span style=\'font-family: arial, helvetica, sans-serif; font-size: 14px;\'>3. Las farmacias deber&aacute;n indicar su turno mediante un cartel que se colocar&aacute; en un lugar exterior del establecimiento, f&aacute;cilmente visible del p&uacute;blico. Si no correspondiere turno, deber&aacute; se&ntilde;alar en igual forma, el nombre y ubicaci&oacute;n de las farmacias m&aacute;s inmediata a las que les corresponda turno. Adem&aacute;s de se&ntilde;alar la siguiente leyenda: \'En caso de sugerencia contactarse con la Secretaria Regional Ministerial de Salud, al fono:+56322571571 o al correo electr&oacute;nico:turno.valparaiso@redsalud.gov.cl \'Contigo mejor Salud\' \'Ministerio de Salud\'.</span>\r\n	</div>\r\n	<br>\r\n\r\n	<div style=\'text-align: justify;\'>										\r\n		<span style=\'font-family: arial, helvetica, sans-serif; font-size: 14px;\'>4. En caso de requerir informaci&oacute;n acerca de alguna farmacia de la regi&oacute;n o del pa&iacute;s est&aacute; disponible la p&aacute;gina web <a href=\"http://turnosdefarmacia.cl/\" target=\"_blank\" style=\"text-decoration: none;color: #000000; \">www.turnosdefarmacia.cl</a>.</span>\r\n	</div>\r\n	<br>\r\n\r\n	<div style=\'page-break-inside:avoid;text-align:justify;font-family: arial, helvetica, sans-serif;font-size:14px;\'>\r\n		<span>5. Ninguna farmacia podr&aacute; eximirse de los turnos fijados por la Secretar&iacute;a Regional Ministerial de Salud REGION DE VALPARAISO.</span>\r\n	</div>\r\n	<br>\r\n\r\n	<div style=\'text-align:justify;page-break-inside:avoid;font-family:arial,helvetica,sans-serif;font-size:14px;\'>\r\n		<span>6. D&eacute;jese establecido que la responsabilidad t&eacute;cnica de la ejecuci&oacute;n del turno, as&iacute; como de proporcionar una adecuada atenci&oacute;n farmac&eacute;utica a la poblaci&oacute;n durante el horario del turno ser&aacute; del Director T&eacute;cnico o del qu&iacute;mico - farmac&eacute;utico asignado para &eacute;sta funci&oacute;n.</span>\r\n	</div>\r\n	<br>\r\n\r\n	<div style=\'page-break-inside:avoid;text-align:justify;font-family:arial,helvetica,sans-serif;font-size:14px;\'>\r\n		<span>7. En caso de producirse el cierre temporal o definitivo de alguna de las farmacias del calendario de turno deber&aacute; avisar, con 10 (diez) días h&aacute;biles de anticipaci&oacute;n al cierre, a la Seremi de Salud REGION DE VALPARAISO, ubicada en Melgarejo 669 6ª piso Valparaíso y por correo electr&oacute;nico a: turno.valparaiso@redsalud.gov.cl.</span>\r\n	</div>\r\n	<br>\r\n\r\n	<div style=\'page-break-inside:avoid;text-align:justify;font-family:arial,helvetica,sans-serif;font-size:14px;\'><span>8. D&eacute;jese sin efecto Resoluci&oacute;n N° 2005F219 con fecha 30 de Mayo de 2020.</span></div><br>\r\n	\r\n	<div style=\'page-break-inside:avoid;text-align:justify;font-family:arial,helvetica,sans-serif;font-size:14px;\'>\r\n		<span>9. Notif&iacute;quese al Director T&eacute;cnico y Representante Legal del establecimiento de la presente resoluci&oacute;n.</span>\r\n	</div>\r\n	<br>\r\n\r\n<div style=\'page-break-inside:avoid;\'>\r\n	<div style=\'text-align:justify;font-family:arial,helvetica,sans-serif;font-size:14px;\'>\r\n		<span>10. Rem&iacute;tase una copia de la presente resoluci&oacute;n a la unidad de Carabineros de Chile existente en la comuna y a los peri&oacute;dicos locales.</span>\r\n	</div>\r\n	<br>\r\n	\r\n	\r\n	<br>\r\n\r\n	<div style=\'text-align: right;\'>\r\n		<div style=\'float:center;font-family: arial, helvetica, sans-serif; font-size: 18px;\' border=\'0\'>\r\n			<p style=\'text-align: center;\'>\r\n				<span><strong><br>REG&Iacute;STRESE Y COMUN&Iacute;QUESE</strong></span>\r\n			</p> \r\n\r\n			<p style=\'text-align: center;\'>\r\n				<span style=\'font-family: arial, helvetica, sans-serif; font-size: 18px;\'>\r\n					<img src=\'http://farmanet.minsal.cl/files/firma_imagen/firma_imagen.jpg\'  style=\'height: 250px;\'>\r\n				</span>\r\n			</p> \r\n\r\n			<p style=\'text-align: center;\'>\r\n				<span style=\'font-family: arial, helvetica, sans-serif; font-size: 20px;\'><strong>[Nombre_Firmante]</strong></span>\r\n				<br>													\r\n				<span style=\'font-family: arial, helvetica, sans-serif; font-size: 18px;\'><strong>[Cargo_Firmante]</strong><br><strong>REGION DE VALPARAISO</strong></span>													\r\n			</p>\r\n		</div>\r\n	</div>\r\n	<br>\r\n	<br>\r\n\r\n	<div  style=\'clear:both;\'>&nbsp;</div>\r\n	<br>\r\n	\r\n	<p>\r\n		<span style=\'font-family: arial, helvetica, sans-serif; font-size: 14px;\'>\r\n			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> Distribuci&oacute;n</b>\r\n			<br> - Farmacias comuna de VIÑA DEL MAR.\r\n			<br> - Oficina de Partes Seremi.\r\n			<br> - Oficinas Seremi.\r\n			<br> - Carabineros, Hospital, Municipalidad y Diarios.\r\n			<br> - Archivo Unidad de Pol&iacute;ticas Farmac&eacute;uticas.\r\n		</span>\r\n	</p>\r\n</div> </body>\r\n						</html>', '0000-00-00 00:00:00', 1, '2020-07-17 19:25:47');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `turno_resolucion`
--
ALTER TABLE `turno_resolucion`
  ADD PRIMARY KEY (`tr_id`),
  ADD KEY `fk_turno_id` (`fk_turno_id`),
  ADD KEY `cod_resolucion` (`cod_resolucion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `turno_resolucion`
--
ALTER TABLE `turno_resolucion`
  MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
