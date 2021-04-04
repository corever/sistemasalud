

INSERT INTO `talonario_estado` (`id_talonario_estado`, `gl_talonario_estado`, `id_usuario_crea`, `fc_creacion`)
VALUES ('3', 'Inhabilitado por usuario', '1', now());

ALTER TABLE `talonarios_creados`
ADD `gl_token` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT 'token' AFTER `tc_id`;

UPDATE talonarios_creados 
SET gl_token = SHA1(CONCAT("talonarios_creados_token_",talonarios_creados.tc_id));

ALTER TABLE `talonario`
CHANGE `Ingreso_sistema` `Ingreso_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `fk_usuario`,
ADD `id_usuario_actualizacion` int(11) NULL,
ADD `fc_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP AFTER `id_usuario_actualizacion`;
-- Cambiar Ingreso_sistema por fc_crea
-- No usar mayuscula

ALTER TABLE `talonarios_creados`
ADD `id_usuario_actualizacion` int(11) NULL,
ADD `fc_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP AFTER `id_usuario_actualizacion`

