
ALTER TABLE `maestro_usuario_rol`
ADD `gl_token` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT 'token' AFTER `mur_fk_rol`,
ADD `id_usuario_actualizacion` int(11) NULL,
ADD `fc_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP AFTER `id_usuario_actualizacion`;

UPDATE maestro_usuario_rol 
SET gl_token = SHA1(CONCAT("maestro_usuario_rol_token_",maestro_usuario_rol.mur_id,"_",maestro_usuario_rol.mur_fk_usuario,"_",maestro_usuario_rol.mur_fk_rol));
 


INSERT INTO `maestro_vista` (`m_v_id`,`nombre_vista`, `link_vista`, `img`, `gl_url`, `gl_icono`, `fk_modulo`)
VALUES(104, 'Lista Vendedor Talonario', 'venta__vendedor_talonario', 'img', 'Farmacia/Talonarios/AdminVendedorTalonario/listaVendedorTalonario', 'far fa-circle', '5');

INSERT INTO `rol_vista` (`fk_rol`, `fk_vista`, `permiso`) VALUES ('1', '104', '1'); 
INSERT INTO `rol_vista` (`fk_rol`, `fk_vista`, `permiso`) VALUES ('2', '104', '1'); 
INSERT INTO `rol_vista` (`fk_rol`, `fk_vista`, `permiso`) VALUES ('3', '104', '1'); 

