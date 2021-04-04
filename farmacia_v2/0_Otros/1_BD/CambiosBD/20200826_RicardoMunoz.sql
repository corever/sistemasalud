
--
-- Estructura de tabla para la tabla `talonario_tipo_motivo`
--

CREATE TABLE `talonario_tipo_motivo` (
  `id_talonario_tipo_motivo` int(11) NOT NULL AUTO_INCREMENT,
  `gl_talonario_tipo_motivo` varchar(255) NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_talonario_tipo_motivo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `talonario_tipo_motivo` (`id_talonario_tipo_motivo`, `gl_talonario_tipo_motivo`, `id_usuario_crea`, `fc_creacion` ) VALUES
(1, 'Transferido', 1, now()),
(2, 'Mal Ingresado', 1, now()),
(3, 'Dañado', 1, now()),
(4, 'Perdido', 1, now()),
(5, 'Robado', 1, now()),
(6, 'Otro', 1, now());


--
-- Volcado de datos para la tabla `talonario_estado`
--

INSERT INTO `talonario_estado` (`id_talonario_estado`, `gl_talonario_estado`, `id_usuario_crea`, `fc_creacion`) VALUES
(7, 'Transferir', 1, now()),
(8, 'Eliminar', 1, now()),
(9, 'Merma', 1, now());



-- SE AÑADEN CAMPOS PARA BITACORA EN TABLA ASIGNACION TALONARIO
ALTER TABLE asignacion_talonario
ADD bo_transferido INT(1) NULL DEFAULT '0',
ADD fk_motivo INT(11) NULL DEFAULT '0',
ADD gl_otro_motivo varchar(255),
ADD gl_observacion varchar(255);
 
