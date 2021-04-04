UPDATE `maestro_vista` SET
`m_v_id` = '20',
`nombre_vista` = 'Administrar Bodegas',
`link_vista` = 'administrar_bodegas',
`img` = 'img',
`gl_url` = 'Farmacia/Bodegas/AdminBodega/administrarBodegas',
`gl_icono` = 'far fa-circle',
`fk_modulo` = '5'
WHERE `m_v_id` = '20';

ALTER TABLE	`bodega`
ADD			`gl_token`	VARCHAR(255) NULL DEFAULT NULL
AFTER		`bodega_id`;

ALTER TABLE	`bodega`
ADD	INDEX(`gl_token`);

UPDATE bodega 
SET gl_token = SHA1(CONCAT("bodega_token_",bodega.bodega_id));

ALTER TABLE `bodega_tipo`
ADD `bodega_tipo_sigla` varchar(5) COLLATE 'utf8_general_ci' NOT NULL AFTER `bodega_tipo_nombre`,
CHANGE `fc_creacion` `fc_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `bodega_tipo_sigla`;

UPDATE `bodega_tipo` SET 
`bodega_tipo_sigla` = 'CEN' 
WHERE `bodega_tipo_id` = '1';

UPDATE `bodega_tipo` SET 
`bodega_tipo_sigla` = 'INT' 
WHERE `bodega_tipo_id` = '2';

UPDATE `bodega_tipo` SET 
`bodega_tipo_sigla` = 'LV' 
WHERE `bodega_tipo_id` = '3';

