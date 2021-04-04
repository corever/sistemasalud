ALTER TABLE `historial_local_tipo`
CHANGE `gl_nombe` `gl_nombre` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `ws_acceso_sistemas`
ADD `gl_pass` VARCHAR(256) NULL DEFAULT NULL AFTER `gl_key_private`;

CREATE TABLE `ws_auditoria` (
  `id_auditoria_ws` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT '0',
  `id_asignacion` int(11) DEFAULT NULL,
  `id_expediente` int(11) DEFAULT NULL,
  `id_visita` int(11) DEFAULT NULL,
  `gl_rut` varchar(255) DEFAULT NULL,
  `json_datos` longtext,
  `json_respuesta` longtext,
  `gl_service_name` varchar(100) DEFAULT NULL COMMENT 'WebService',
  `gl_token_dispositivo` varchar(255) DEFAULT NULL,
  `gl_version_ws` varchar(50) DEFAULT NULL,
  `gl_version_app` varchar(50) DEFAULT NULL,
  `bo_ws_success` tinyint(3) DEFAULT '1' COMMENT '1=OK',
  `ip_privada` varchar(50) DEFAULT '0.0.0.0',
  `ip_publica` varchar(50) DEFAULT '0.0.0.0',
  `id_usuario_crea` int(11) DEFAULT NULL,
  `fc_crea` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ws_auditoria`
  ADD PRIMARY KEY (`id_auditoria_ws`),
  ADD KEY `IDX_id_usuario` (`id_usuario`),
  ADD KEY `IDX_gl_rut` (`gl_rut`),
  ADD KEY `IDX_ip_privada` (`ip_privada`),
  ADD KEY `IDX_ip_publica` (`ip_publica`),
  ADD KEY `IDX_gl_origen` (`gl_service_name`),
  ADD KEY `gl_version_app` (`gl_version_app`),
  ADD KEY `gl_version_ws` (`gl_version_ws`);

CREATE TABLE `ws_historial_evento` (
  `id_evento` int(11) NOT NULL,
  `id_expediente` int(11) DEFAULT NULL,
  `id_evento_tipo` int(11) DEFAULT NULL,
  `id_asignacion` int(11) DEFAULT NULL,
  `gl_descripcion` text COLLATE utf8_spanish_ci,
  `bo_estado` int(1) DEFAULT '1',
  `id_usuario_crea` int(11) DEFAULT NULL,
  `fc_crea` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `ws_historial_evento`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `IDX_id_evento_tipo` (`id_evento_tipo`),
  ADD KEY `IDX_id_usuario_crea` (`id_usuario_crea`),
  ADD KEY `IDX_bo_estado` (`bo_estado`),
  ADD KEY `id_expediente` (`id_asignacion`);

ALTER TABLE `ws_historial_evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `ws_historial_evento_tipo` (
  `id_evento_tipo` int(11) NOT NULL,
  `gl_nombre_evento_tipo` varchar(150) DEFAULT NULL,
  `id_usuario_crea` int(11) DEFAULT NULL,
  `fc_crea` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ws_historial_evento_tipo`
  ADD PRIMARY KEY (`id_evento_tipo`),
  ADD KEY `IDX_id_usuario_crea` (`id_usuario_crea`);


INSERT INTO `ws_historial_evento_tipo` (`id_evento_tipo`, `gl_nombre_evento_tipo`, `id_usuario_crea`, `fc_crea`) VALUES
(1, 'Registro de Asignación', 1, '2018-05-09 03:53:32'),
(2, 'Se Crea Mensaje Usuario', 1, '2018-05-09 03:53:32'),
(3, 'Mensaje Usuario Visualizado', 1, '2018-05-09 03:53:32'),
(4, 'Login en App', 1, '2018-05-09 03:53:32'),
(5, 'Se respalda Log', 1, '2018-05-19 08:20:05'),
(6, 'Se asigna Fiscalizador', 1, '2018-05-25 01:22:49'),
(7, 'Se reasigna Fiscalizador', 1, '2018-05-25 01:32:53'),
(8, 'Se respalda Adjunto', 1, '2018-05-26 02:35:10'),
(9, 'Se respalda Visita', 1, '2018-05-19 08:20:05'),
(10, 'Se guarda Adjunto', 1, '2018-05-26 01:52:27'),
(11, 'Visita Realizada', 1, '2018-05-26 03:44:56'),
(12, 'Visita Perdida', 1, '2018-05-26 03:45:03'),
(13, 'Visita Sin Estado', 1, '2018-05-30 06:47:04'),
(14, 'Asignación Devuelta', 1, '2018-05-30 09:52:25'),
(15, 'Se cierra visita', 1, '2019-06-28 00:10:21');


INSERT INTO `ws_acceso_sistemas` (`id_sistema`, `gl_nombre_sistema`, `gl_base`, `gl_ambiente`, `json_permisos`, `gl_key_public`, `gl_key_private`, `gl_pass`, `gl_url_sistema`, `gl_url_exito`, `gl_url_error`, `bo_estado`, `id_usuario_crea`, `fc_crea`) VALUES
(1, 'Externo', 'wsEstablecimientos', 'TEST', '[\r\n	{\r\n	  \"metodo\": \"negociar\",\r\n	  \"limite_dia\": 5000,\r\n	  \"limite_hora\": 1000,\r\n	  \"estado\": 1,\r\n	  \"fc_vigencia\": null\r\n	}\r\n]', 'bd7d390d1a3527051c2109e983065d3968745297f2086d30ef4d8edee4d93b25', '733e63ca4faf683e9e814aa492ce7819573216f3e586f6bef1c1d37500cdc2ee05c193af4e5978cb3a93c5da68c0b33e8287bb660389d6b7d854a0900d2a35a3', '19a201e8e7f6ff6ee5cda534c3a7260ef980695da10f6f1b87b8cf101f0a83284b4fb04872b8cf6a7cb7fe0dcbf39beb85bf3c31f1eab390b5bab3428447eb94', '', NULL, NULL, 1, 0, '2020-09-21');

INSERT INTO `historial_local_tipo`
  (`id_tipo`, `gl_nombre`, `id_usuario_crea`, `fc_crea`)
VALUES
  ('7', 'Creación Establecimiento WebService', '1', CURRENT_TIMESTAMP),
  ('8', 'Edición Establecimiento WebService', '1', CURRENT_TIMESTAMP)