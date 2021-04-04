INSERT INTO farmanet.maestro_vista
(nombre_vista, link_vista, img, gl_url, gl_icono, fk_modulo, bo_activo, fc_actualiza, id_usuario_actualiza, fc_crea, id_usuario_crea, nr_orden)
values
('Administrar Solicitudes DT', 'administrar_solicitudes_dt', 'img', 'Farmacia/Farmacias/AdminSolicitudesDT', 'far fa-circle', 1, 1, now(), 0, '2020-10-01 15:22:59.0', 0, 100);


INSERT INTO farmanet.rol_vista
(fk_rol, fk_vista, permiso, fc_actualiza, id_usuario_actualiza, fc_crea, id_usuario_crea)
VALUES(2, 108, 1, now(), 0, now() , 0);
