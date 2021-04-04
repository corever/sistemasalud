ALTER TABLE `mor_expediente` ADD nr_intenta_llamada int(1);

INSERT INTO `mor_acceso_opcion`
(id_opcion, id_opcion_padre, bo_tiene_hijo, gl_nombre_opcion, gl_icono, gl_url, bo_activo, id_usuario_actualiza, fc_actualiza, id_usuario_crea, fc_crea)
VALUES(9997, 0, 0, 'Editar Dirección', 'fa fa-edit fa-2x', '/EditarDireccion/index/', 1, NULL, NULL, 1, '2020-10-07 14:29:00.0');

INSERT INTO `mor_acceso_perfil_opcion`
(id_perfil, id_opcion, id_usuario_crea, fc_crea)
VALUES(1, 9997, 1, '2020-10-07 14:31:00.0');

INSERT INTO `mor_acceso_perfil_opcion`
(id_perfil, id_opcion, id_usuario_crea, fc_crea)
VALUES(12, 9997, 1, '2020-10-07 14:31:00.0');
