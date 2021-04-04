-- cosof-ricardo-munoz 30-09-2020

ALTER TABLE `turno_tipo_periodo`
CHANGE `gl_turno_tipo_dia_mes_inicio` `gl_turno_tipo_dia_mes_inicio` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `gl_turno_tipo_periodo`,
ADD `fc_turno_tipo_dia_mes_inicio` date NULL ON UPDATE CURRENT_TIMESTAMP AFTER `gl_turno_tipo_dia_mes_inicio`,
CHANGE `gl_turno_tipo_dia_mes_termino` `gl_turno_tipo_dia_mes_termino` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `fc_turno_tipo_dia_mes_inicio`,
ADD `fc_turno_tipo_dia_mes_termino` date NULL ON UPDATE CURRENT_TIMESTAMP AFTER `gl_turno_tipo_dia_mes_termino`;

UPDATE `turno_tipo_periodo` SET 
`gl_turno_tipo_dia_mes_inicio` = '01 de Enero',
`fc_turno_tipo_dia_mes_inicio` = '2020-01-01',
`gl_turno_tipo_dia_mes_termino` = '31 de Marzo',
`fc_turno_tipo_dia_mes_termino` = '2020-03-31', 
WHERE `id_turno_tipo_periodo` = '1';

UPDATE `turno_tipo_periodo` SET 
`gl_turno_tipo_dia_mes_inicio` = '01 de Abril',
`fc_turno_tipo_dia_mes_inicio` = '2020-04-01',
`gl_turno_tipo_dia_mes_termino` = '30 de Junio',
`fc_turno_tipo_dia_mes_termino` = '2020-06-30', 
WHERE `id_turno_tipo_periodo` = '2';

UPDATE `turno_tipo_periodo` SET 
`gl_turno_tipo_dia_mes_inicio` = '01 de Julio',
`fc_turno_tipo_dia_mes_inicio` = '2020-07-01',
`gl_turno_tipo_dia_mes_termino` = '30 de Septiembre',
`fc_turno_tipo_dia_mes_termino` = '2020-09-30', 
WHERE `id_turno_tipo_periodo` = '3'; 

UPDATE `turno_tipo_periodo` SET
`gl_turno_tipo_dia_mes_inicio` = '01 de Octubre',
`fc_turno_tipo_dia_mes_inicio` = '2020-10-01',
`gl_turno_tipo_dia_mes_termino` = '31 de Diciembre',
`fc_turno_tipo_dia_mes_termino_` = '2020-12-31' 
WHERE `id_turno_tipo_periodo` = '4'; 



--
-- Estructura de tabla para la tabla `turno_tipo_documento`
--

CREATE TABLE `turno_tipo_documento` (
  `id_turno_tipo_documento` int(11) NOT NULL AUTO_INCREMENT,
  `gl_turno_tipo_documento` varchar(255) NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_turno_tipo_documento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `turno_tipo_documento` (`id_turno_tipo_documento`, `gl_turno_tipo_documento`, `id_usuario_crea`, `fc_creacion` ) VALUES
(1, 'TURNO', 1, now()),
(2, 'ESPECIFICA', 1, now()),
(3, 'URGENCIA', 1, now()); 


ALTER TABLE `turno_resolucion_doc`
ADD `fk_turno_documento_tipo` int(11) NULL COMMENT 'normaliza tr_doc_tipo' AFTER `tr_doc_tipo`;

UPDATE turno_resolucion_doc
SET fk_turno_documento_tipo = 1 
WHERE tr_doc_tipo = 'TURNO';

UPDATE turno_resolucion_doc
SET fk_turno_documento_tipo = 2
WHERE tr_doc_tipo = 'ESPECIFICA';

UPDATE turno_resolucion_doc
SET fk_turno_documento_tipo = 3
WHERE tr_doc_tipo = 'URGENCIA';

ALTER TABLE `turno_resolucion_doc`
CHANGE `tr_doc_tipo` `tr_doc_tipo` enum('TURNO','ESPECIFICA','URGENCIA') COLLATE 'utf8_unicode_ci' NULL AFTER `tr_doc_id`,
CHANGE `tr_doc_nombre` `tr_doc_nombre` varchar(200) COLLATE 'utf8_unicode_ci' NOT NULL AFTER `fk_turno_documento_tipo`,
CHANGE `tr_doc_contenido` `tr_doc_contenido` longtext COLLATE 'utf8_unicode_ci' NOT NULL AFTER `tr_doc_nombre`,
COLLATE 'utf8_unicode_ci';

ALTER TABLE `turno_resolucion_doc`
ADD INDEX `fk_turno_documento_tipo` (`fk_turno_documento_tipo`);

ALTER TABLE `turno_cod_resolucion`
CHANGE `tcr_fc_creacion` `tcr_fc_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP AFTER `tcr_usado`,
ADD `id_usuario_creacion` int(11) NULL;