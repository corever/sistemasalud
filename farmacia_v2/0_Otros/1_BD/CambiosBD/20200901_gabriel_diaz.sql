CREATE TABLE `local_recetario_tipo`(
	`id_recetario` INT(11) NOT NULL AUTO_INCREMENT ,
	`gl_nombre` VARCHAR(255) NULL DEFAULT NULL ,
	`bo_activo` TINYINT(1) NULL DEFAULT '1' ,
	`id_usuario_crea` INT(11) NULL DEFAULT NULL ,
	`fc_crea` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
	PRIMARY KEY (`id_recetario`),
	INDEX (`bo_activo`)
) ENGINE = InnoDB;

INSERT INTO `local_recetario_tipo` (`id_recetario`, `gl_nombre`, `bo_activo`, `id_usuario_crea`, `fc_crea`) VALUES 
	(1, 'Centralizado', '1', '1', CURRENT_TIMESTAMP),
	(2, 'Independiente', '1', '1', CURRENT_TIMESTAMP),
	(3, 'Con Convenio', '1', '1', CURRENT_TIMESTAMP);