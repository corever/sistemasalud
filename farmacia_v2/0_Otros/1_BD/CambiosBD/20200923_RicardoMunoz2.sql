
/*
DELETE FROM `rol_vista`
WHERE `fk_rol` = '2' AND `fk_vista` = '18' AND ((`rol_vista_id` = '47'));
*/

-- Por qué se quita?
-- Encargado Regional no tiene su propia "Mi Bodega"
-- `fk_rol` = '2' = Encargado Regional
-- `fk_vista` = '2' = Mi Bodega
UPDATE `rol_vista` SET `permiso` = '0' WHERE `rol_vista`.`rol_vista_id` = 47;

UPDATE `maestro_vista` SET
`m_v_id` = '19',
`nombre_vista` = 'Crear Bodega',
`link_vista` = 'crear_bodega',
`img` = 'img',
`gl_url` = 'Farmacia/Bodegas/AdminBodega/crearBodega',
`gl_icono` = 'far fa-circle',
`fk_modulo` = '5',
`bo_activo` = '1',
`fc_actualiza` = '0000-00-00',
`id_usuario_actualiza` = '0',
`fc_crea` = '2020-09-23 02:10:41',
`id_usuario_crea` = '0',
`nr_orden` = '19'
WHERE `m_v_id` = '19';

/*
no borrar
SQL para validarExisteFolio
retorna 0
SELECT count(1) as existeFolio FROM talonario WHERE talonario_folio_inicial < 100 AND talonario_folio_final > 1 AND talonario_serie = 'HOLA'
cambiar serie, folios para encontrar otros resultados
*/


UPDATE `maestro_vista` SET
`m_v_id` = '29',
`nombre_vista` = 'Resoluciones Urgencia',
`link_vista` = 'resolucion_urgencia',
`img` = 'img',
`gl_url` = 'Farmacia/Turnos/AdminResolucion/resolucionUrgencia',
`gl_icono` = 'far fa-circle',
`fk_modulo` = '3',
`bo_activo` = '1',
`fc_actualiza` = '0000-00-00',
`id_usuario_actualiza` = '0',
`fc_crea` = '2020-09-23 02:10:41',
`id_usuario_crea` = '0',
`nr_orden` = '29'
WHERE `m_v_id` = '29';

UPDATE `maestro_vista` SET
`m_v_id` = '15',
`nombre_vista` = 'Administrar Turnos',
`link_vista` = 'administrar',
`img` = 'img',
`gl_url` = 'Farmacia/Turnos/AdminTurnos/administrarTurnos',
`gl_icono` = 'far fa-circle',
`fk_modulo` = '3',
`bo_activo` = '1',
`fc_actualiza` = '0000-00-00',
`id_usuario_actualiza` = '0',
`fc_crea` = '2020-09-23 02:10:41',
`id_usuario_crea` = '0',
`nr_orden` = '15'
WHERE `m_v_id` = '15';

ALTER TABLE `turno`
CHANGE `fk_localidad` `fk_localidad` int(11) NULL AFTER `fk_comuna`,
CHANGE `turno_rotacion` `turno_rotacion` enum('DIARIA','SEMANAL','MENSUAL','TRIMESTRAL','SEMESTRAL') COLLATE 'utf8_general_ci' NOT NULL AFTER `turno_hora_termino`;


--
-- Estructura de tabla para la tabla `turno_tipo_periodo`
--

CREATE TABLE `turno_tipo_periodo` (
  `id_turno_tipo_periodo` int(11) NOT NULL AUTO_INCREMENT,
  `gl_turno_tipo_periodo` varchar(255) NOT NULL,
  `gl_turno_tipo_dia_mes_inicio` varchar(255) NOT NULL,
  `gl_turno_tipo_dia_mes_termino` varchar(255) NOT NULL,
  `id_usuario_creacion` int(11) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario_actualizacion` int(11) NULL,
  `fc_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_turno_tipo_periodo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `turno_tipo_periodo` (`id_turno_tipo_periodo`, `gl_turno_tipo_periodo`, `gl_turno_tipo_dia_mes_inicio`, `gl_turno_tipo_dia_mes_termino`, `id_usuario_creacion`, `fc_creacion` ) VALUES
(1, 'Primer Trimestre', '01 de Enero', '31 de Marzo', 1, now());

INSERT INTO `turno_tipo_periodo` (`id_turno_tipo_periodo`, `gl_turno_tipo_periodo`, `gl_turno_tipo_dia_mes_inicio`, `gl_turno_tipo_dia_mes_termino`, `id_usuario_creacion`, `fc_creacion` ) VALUES
(2, 'Segundo Trimestre', '01 de Abril', '30 de Junio', 1, now());

INSERT INTO `turno_tipo_periodo` (`id_turno_tipo_periodo`, `gl_turno_tipo_periodo`, `gl_turno_tipo_dia_mes_inicio`, `gl_turno_tipo_dia_mes_termino`, `id_usuario_creacion`, `fc_creacion` ) VALUES
(3, 'Tercer Trimestre', '01 de Julio', '30 de Septiembre', 1, now());

INSERT INTO `turno_tipo_periodo` (`id_turno_tipo_periodo`, `gl_turno_tipo_periodo`, `gl_turno_tipo_dia_mes_inicio`, `gl_turno_tipo_dia_mes_termino`, `id_usuario_creacion`, `fc_creacion` ) VALUES
(4, 'Cuarto Trimestre', '01 de Octubre', '31 de Diciembre', 1, now());