/*Agrego bo_ws_validado a maestro_usuario*/
ALTER TABLE `maestro_usuario` ADD `bo_ws_validado` INT(1) NULL DEFAULT '0' AFTER `url_avatar`;

