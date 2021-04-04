/*Agrego gl_icono a modulo y vista*/

ALTER TABLE `maestro_modulo` ADD `gl_icono` VARCHAR(50) NULL DEFAULT 'fa fa-globe' AFTER `img`;
ALTER TABLE `maestro_vista` ADD `gl_icono` VARCHAR(50) NULL DEFAULT 'far fa-circle' AFTER `img`;

/* activar usuarios */
UPDATE `maestro_usuario` SET `mu_estado_sistema` = '1' WHERE `maestro_usuario`.`mu_id` = 1;
UPDATE `maestro_usuario` SET `mu_estado_sistema` = '1' WHERE `maestro_usuario`.`mu_id` = 233;

/* iconos menu */
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-image' WHERE `maestro_modulo`.`m_m_id` = 1;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-edit' WHERE `maestro_modulo`.`m_m_id` = 2;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-calendar' WHERE `maestro_modulo`.`m_m_id` = 3;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-image' WHERE `maestro_modulo`.`m_m_id` = 4;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-copy' WHERE `maestro_modulo`.`m_m_id` = 5;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-user' WHERE `maestro_modulo`.`m_m_id` = 6;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-file' WHERE `maestro_modulo`.`m_m_id` = 7;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-file' WHERE `maestro_modulo`.`m_m_id` = 8;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-database' WHERE `maestro_modulo`.`m_m_id` = 9;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-user-secret' WHERE `maestro_modulo`.`m_m_id` = 10;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-chart-bar' WHERE `maestro_modulo`.`m_m_id` = 11;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-exclamation-circle' WHERE `maestro_modulo`.`m_m_id` = 12;
UPDATE `maestro_modulo` SET `gl_icono` = 'fa fa-envelope' WHERE `maestro_modulo`.`m_m_id` = 13;
