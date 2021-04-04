CREATE TABLE `local_horario` (
	`id_horario` int(11) NOT NULL,
	`id_local` int(11) DEFAULT NULL,
	`bo_continuado` tinyint(1) DEFAULT '1',
	`json_lunes` text,
	`json_martes` text,
	`json_miercoles` text,
	`json_jueves` text,
	`json_viernes` text,
	`json_sabado` text,
	`json_domingo` text,
	`json_festivos` text,
	`id_usuario_crea` int(11) DEFAULT NULL,
	`fc_crea` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	`id_usuario_actualiza` int(11) DEFAULT NULL,
	`fc_actualiza` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `local_horario`
	ADD PRIMARY KEY (`id_horario`),
	ADD KEY `bo_continuado` (`bo_continuado`);

ALTER TABLE `local_horario`
	MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;