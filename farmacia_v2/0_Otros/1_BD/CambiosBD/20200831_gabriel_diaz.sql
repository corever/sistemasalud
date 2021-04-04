CREATE TABLE	`local_clasificacion`(
	`id_clasificacion` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`gl_nombre` varchar(255) DEFAULT NULL,
	`bo_activo` tinyint(1) DEFAULT '1',
	`id_usuario_crea` int(11) DEFAULT NULL,
	`fc_crea` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `local_clasificacion`	(`id_clasificacion`, `gl_nombre`, `bo_activo`, `id_usuario_crea`, `fc_crea`)
VALUES
(1,	'Alopática',	1,	1,	'2020-08-31 16:16:04'),
(2,	'Homeopatica',	1,	1,	'2020-08-31 16:16:16'),
(3,	'Móvil',	1,	1,	'2020-08-31 16:16:23'),
(4,	'Urgencia',	1,	1,	'2020-08-31 16:16:30');

ALTER TABLE `local_clasificacion`
  ADD KEY `bo_activo` (`bo_activo`);