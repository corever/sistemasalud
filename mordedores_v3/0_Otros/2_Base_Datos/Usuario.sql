/*
	Usuario	: 11111111-1
	Clave	: 123
*/

INSERT INTO `mor_acceso_usuario` (`id_usuario`, `gl_token`, `gl_rut`, `gl_email`, `gl_password`, `gl_nombres`, `gl_apellidos`, `id_tipo_genero`, `bo_cambio_usuario`, `bo_activo`, `bo_informar_web`, `fc_ultimo_login`, `id_usuario_actualiza`, `fc_actualiza`, `id_usuario_crea`, `fc_crea`) VALUES
(1, 'TC128244D80DF1B832D8A9E72EBB7AD4FD141406E97B5CDDC996726C3FC61C68EBB6BBF1CWA8E0D18B09DCECC21ECEEB1C0BA91DF21214892C0151669D3FBF76', '11111111-1', 'victor.retamal@cosof.cl', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', 'Administrador', '', NULL, 1, 1, 1, '2020-09-30 12:14:23', 1, '2020-09-30 15:14:23', 1, '2017-02-09 13:30:00');

INSERT INTO `mor_acceso_usuario_perfil` (`id_usuario_perfil`, `id_usuario`, `id_perfil`, `id_region`, `id_oficina`, `id_comuna`, `id_establecimiento`, `id_servicio`, `id_laboratorio`, `nr_correlativo`, `bo_activo`, `bo_principal`, `id_usuario_actualiza`, `fc_actualiza`, `id_usuario_crea`, `fc_crea`) VALUES
(1, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 2, '2018-10-01 18:42:09', 1, '2018-05-09 22:34:25');
