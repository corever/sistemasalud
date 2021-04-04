-- UPDATE vista y modulo
ALTER TABLE `maestro_vista` ADD `bo_activo` INT(1) NOT NULL DEFAULT '1' AFTER `fk_modulo`;
ALTER TABLE `maestro_modulo` ADD `bo_activo` INT(1) NOT NULL DEFAULT '1' AFTER `gl_icono`;

ALTER TABLE `maestro_modulo` ADD `fc_actualiza` DATE NOT NULL AFTER `bo_activo`, ADD `id_usuario_actualiza` INT(11) NOT NULL AFTER `fc_actualiza`, ADD `fc_crea` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `id_usuario_actualiza`, ADD `id_usuario_crea` INT(11) NOT NULL AFTER `fc_crea`;
ALTER TABLE `maestro_vista` ADD `fc_actualiza` DATE NOT NULL AFTER `bo_activo`, ADD `id_usuario_actualiza` INT(11) NOT NULL AFTER `fc_actualiza`, ADD `fc_crea` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `id_usuario_actualiza`, ADD `id_usuario_crea` INT(11) NOT NULL AFTER `fc_crea`;

ALTER TABLE `rol_vista` ADD `fc_actualiza` DATE NOT NULL AFTER `permiso`, ADD `id_usuario_actualiza` INT(11) NOT NULL AFTER `fc_actualiza`, ADD `fc_crea` TIMESTAMP NOT NULL AFTER `id_usuario_actualiza`, ADD `id_usuario_crea` INT(11) NOT NULL AFTER `fc_crea`;
