
-- json con permisos del usuario para el rol especifico en tabla maestro_usuario_rol

ALTER TABLE `maestro_usuario_rol`
ADD `json_permisos` TEXT COLLATE 'utf8' NULL DEFAULT '[]' AFTER `gl_token`;
-- json siempre debe ser TEXT o LONGTEXT