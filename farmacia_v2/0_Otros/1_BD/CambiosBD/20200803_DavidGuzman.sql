/*Agrego gl_url a maestro_vista*/
ALTER TABLE `maestro_vista` ADD `gl_url` VARCHAR(255) NULL DEFAULT NULL AFTER `img`;

/* update maestro_vista gl_url */
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Mantenedor/Usuario' WHERE `maestro_vista`.`m_v_id` = 44;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Mantenedor/Talonario' WHERE `maestro_vista`.`m_v_id` = 21;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turno/Turno' WHERE `maestro_vista`.`m_v_id` = 28;

/*gl token usuario*/
ALTER TABLE `maestro_usuario` ADD `gl_token` VARCHAR(255) NOT NULL AFTER `mu_id`;
