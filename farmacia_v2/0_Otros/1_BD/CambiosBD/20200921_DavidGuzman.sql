-- ADD nr_orden
ALTER TABLE `maestro_vista` ADD `nr_orden` INT(11) NULL DEFAULT NULL AFTER `fk_modulo`, ADD INDEX (`nr_orden`);

-- Alter maestro_vista para opcion de maestro menu y rol
INSERT INTO `maestro_vista` (`m_v_id`, `nombre_vista`, `link_vista`, `img`, `gl_url`, `gl_icono`, `fk_modulo`, `nr_orden`) VALUES (NULL, 'Maestro Menú', 'maestro_menu', 'img', 'Farmacia/Maestro/Menu', '', '8', '105');
INSERT INTO `maestro_vista` (`m_v_id`, `nombre_vista`, `link_vista`, `img`, `gl_url`, `gl_icono`, `fk_modulo`, `nr_orden`) VALUES (NULL, 'Maestro Rol', 'maestro_rol', 'img', 'Farmacia/Maestro/Rol', '', '8', '106');
INSERT INTO `rol_vista` (`rol_vista_id`, `fk_rol`, `fk_vista`, `permiso`) VALUES (NULL, '9', '105', '1');
INSERT INTO `rol_vista` (`rol_vista_id`, `fk_rol`, `fk_vista`, `permiso`) VALUES (NULL, '9', '106', '1');

INSERT INTO `rol_vista` (`rol_vista_id`, `fk_rol`, `fk_vista`, `permiso`) VALUES (NULL, '1', '105', '1');
INSERT INTO `rol_vista` (`rol_vista_id`, `fk_rol`, `fk_vista`, `permiso`) VALUES (NULL, '1', '106', '1');

-- ADD bo_regional & bo_nacional
ALTER TABLE `maestro_rol` ADD `bo_regional` INT(1) NULL DEFAULT NULL AFTER `nr_orden`;
ALTER TABLE `maestro_rol` ADD `bo_nacional` INT(1) NULL DEFAULT NULL AFTER `bo_regional`;

-- Alter maestro_rol
ALTER TABLE `maestro_rol`
    ADD `bo_activo` INT(1) NOT NULL DEFAULT '1' AFTER `bo_regional`,
    ADD `id_usuario_actualiza` INT(11) NOT NULL AFTER `bo_activo`,
    ADD `fc_actualiza` DATE NOT NULL AFTER `id_usuario_actualiza`,
    ADD `fc_crea` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `fc_actualiza`,
    ADD `id_usuario_crea` INT(11) NOT NULL DEFAULT '1' AFTER `fc_crea`;

ALTER TABLE `maestro_rol` ADD `gl_token` VARCHAR(255) NOT NULL AFTER `rol_id` COMMENT 'sha1';

UPDATE `maestro_rol` SET `gl_token` = SHA1(rol_id);

