ALTER TABLE	`local`
ADD	`json_recetario_detalle` TEXT NULL	DEFAULT	NULL
AFTER `local_recetario_fk_detalle`;

ALTER TABLE `local_tipo`
ADD `bo_activo` TINYINT(1) NULL DEFAULT '1' AFTER `local_tipo_nombre`,
ADD `id_usuario_crea` INT(11) NULL DEFAULT NULL AFTER `bo_activo`,
ADD `fc_crea` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `id_usuario_crea`,
ADD INDEX (`bo_activo`);

ALTER TABLE `local`
ADD `id_recetario_tipo` INT(11) NULL DEFAULT NULL AFTER `local_recetario_tipo`;