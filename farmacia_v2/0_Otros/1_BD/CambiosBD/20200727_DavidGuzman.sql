/*Agrego gl_password_v2 a tabla de usuario para usar password sha512 - mayor seguridad*/

ALTER TABLE `maestro_usuario` ADD `gl_password_v2` VARCHAR(255) NULL DEFAULT NULL AFTER `mu_pass`;