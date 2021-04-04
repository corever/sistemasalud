CREATE TABLE `farmacia_caracter` (
	`id_caracter` int(11) NOT NULL,
	`gl_nombre` varchar(100) DEFAULT NULL,
	`bo_activo` tinyint(1) DEFAULT '1',
	`fc_crea` datetime DEFAULT CURRENT_TIMESTAMP,
	`id_usuario_crea` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `farmacia_caracter` (`id_caracter`, `gl_nombre`, `bo_activo`, `fc_crea`, `id_usuario_crea`) VALUES
(1, 'Nacional', 1, '2020-08-27 10:14:51', 1),
(2, 'Regional', 1, '2020-08-27 10:14:56', 1),
(3, 'Independiente', 1, '2020-08-27 10:14:56', 1),
(4, 'Inter-Regional', 1, '2020-08-27 10:14:56', 1);

ALTER TABLE `farmacia_caracter`
	ADD PRIMARY KEY (`id_caracter`);
ALTER TABLE `farmacia_caracter`
	MODIFY `id_caracter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `farmacia`
ADD `id_caracter` INT(11) NULL DEFAULT NULL AFTER `farmacia_caracter`;
