ALTER TABLE	`maestro_rol`
ADD `bo_nacional` TINYINT(1) NULL DEFAULT '0' AFTER `nr_orden`,
ADD `bo_regional` TINYINT(1) NULL DEFAULT '0' AFTER `bo_nacional`;

UPDATE `maestro_rol` SET `bo_nacional`= 1 WHERE `rol_id`	IN	(1,11,14);
UPDATE `maestro_rol` SET `bo_regional`= 1 WHERE `rol_id`	IN	(2,12,15);

ALTER TABLE `local_estado` CHANGE `detalle` `detalle` VARCHAR(255) NULL DEFAULT NULL;

INSERT INTO `historial_local_tipo`	(`id_tipo`, `gl_nombe`, `id_usuario_crea`, `fc_crea`)
VALUES
('3', 'Habilita Establecimiento', '1', CURRENT_TIMESTAMP),
('4', 'Programa Habilitación de Establecimiento', '1', CURRENT_TIMESTAMP),
('5', 'Deshabilita Establecimiento', '1', CURRENT_TIMESTAMP),
('6', 'Programa Deshabilitación de Establecimiento', '1', CURRENT_TIMESTAMP);