ALTER TABLE `bodega`
ADD `id_usuario_creacion` int(11) NOT NULL DEFAULT '1' AFTER `fk_bodega_tipo`,
ADD `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `id_usuario_creacion`,
ADD `id_usuario_modificacion` int(11) NULL AFTER `fc_creacion`,
ADD `fc_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP AFTER `id_usuario_modificacion`;