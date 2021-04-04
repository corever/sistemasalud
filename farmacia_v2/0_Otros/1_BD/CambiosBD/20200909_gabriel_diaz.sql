ALTER TABLE	local_horario	
ADD			bo_activo	TINYINT(1) NULL DEFAULT '1'
AFTER	json_festivos;

CREATE TABLE	`historial_local`	(
	`id_historial`		INT(11)		NOT NULL	AUTO_INCREMENT ,
	`id_historial_tipo`	INT(11)		NULL		DEFAULT	NULL ,
	`id_local`			INT(11)		NULL		DEFAULT	NULL ,
	`gl_descripcion`	TEXT		NULL		DEFAULT	NULL ,
	`bo_activo`			TINYINT(1)	NULL		DEFAULT	'1' ,
	`id_usuario_crea`	INT(11)		NULL		DEFAULT	NULL ,
	`fc_crea`			DATETIME	NULL		DEFAULT	CURRENT_TIMESTAMP ,
	PRIMARY KEY (`id_historial`),
	INDEX (`id_local`),
	INDEX (`bo_activo`)
) ENGINE = InnoDB;

CREATE TABLE	`historial_local_tipo`  (
	`id_tipo`			INT(11)			NOT NULL	AUTO_INCREMENT,
	`gl_nombe`			VARCHAR(255)	NULL		DEFAULT	NULL ,
	`id_usuario_crea`	INT(11)			NULL		DEFAULT	NULL ,
	`fc_crea`			DATETIME		NULL		DEFAULT	CURRENT_TIMESTAMP ,
	PRIMARY KEY (`id_tipo`)
) ENGINE = InnoDB;

INSERT INTO		`historial_local_tipo`	(
	`id_tipo`, `gl_nombe`, `id_usuario_crea`, `fc_crea`
)
	VALUES	
('1', 'Creación Establecimiento', '1', CURRENT_TIMESTAMP),
('2', 'Edición Establecimiento', '1', CURRENT_TIMESTAMP);