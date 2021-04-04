CREATE TABLE `dt_solicitud_registro` (
  `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `gl_rut` varchar(20) NULL,
  `gl_nombre` varchar(50) NULL,
  `gl_apellido_paterno` varchar(50) NULL,
  `gl_apellido_materno` varchar(50) NULL,
  `gl_email` varchar(100) NULL,
  `fc_nacimiento` timestamp,
  `id_profesion` int(11),
  `nr_certificado_titulo` varchar(40),
  `id_region_midas` int(11) NULL,
  `id_comuna_midas` int(11) NULL,
  `gl_direccion` varchar(250),
  `gl_telefono` varchar(20),
  `id_motivo_solicitud` int(11),
  `gl_observacion` text,
  `rut_farmacia` varchar(20),
  `id_region_farmacia` int(11) NULL,
  `json_farmacia` longtext,
  `json_documentos` longtext,
  `bo_solicitud` int(11),
  `bo_asume` int(1),
  `bo_cese` int(1),
  `json_asume` longtext,
  `json_cese` longtext,
  `fc_creacion` timestamp DEFAULT CURRENT_TIMESTAMP,
  `bo_declaracion` int(1),
  PRIMARY KEY (`id_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


/*
json_documentos debe guardar nombre y base64 del archivo
bo_solicitud que es?
id_motivo_solicitud que es?
*/