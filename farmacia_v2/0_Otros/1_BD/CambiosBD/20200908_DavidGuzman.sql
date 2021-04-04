/*flag cambio de usuario en tabla maestro_usuario*/

ALTER TABLE `maestro_usuario` ADD `bo_cambio_usuario` INT(1) NULL DEFAULT '0' AFTER `bo_ws_validado`;

