--
-- Estructura de tabla para la tabla `talonario_tipo_documento`
--

CREATE TABLE `talonario_tipo_documento` (
  `id_talonario_tipo_documento` int(11) NOT NULL AUTO_INCREMENT,
  `gl_talonario_tipo_documento` varchar(255) NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_talonario_tipo_documento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `talonario_tipo_documento` (`id_talonario_tipo_documento`, `gl_talonario_tipo_documento`, `id_usuario_crea`, `fc_creacion` ) VALUES
(1, 'Factura', 1, now()),
(2, 'Guía', 1, now());


--
-- Estructura de tabla para la tabla `talonario_tipo_proveedor`
--
CREATE TABLE `talonario_tipo_proveedor` (
  `id_talonario_tipo_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `gl_talonario_tipo_proveedor` varchar(255) NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_talonario_tipo_proveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `talonario_tipo_proveedor` (`id_talonario_tipo_proveedor`, `gl_talonario_tipo_proveedor`, `id_usuario_crea`, `fc_creacion`) VALUES
(1, 'Casa de moneda', 1, now()),
(2, 'Central de abastecimiento', 1, now());



--
-- Estructura de tabla para la tabla `talonario_estado`
--
CREATE TABLE `talonario_estado` (
  `id_talonario_estado` int(11) NOT NULL AUTO_INCREMENT,
  `gl_talonario_estado` varchar(255) NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fc_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_talonario_estado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `talonario_estado` (`id_talonario_estado`, `gl_talonario_estado`, `id_usuario_crea`, `fc_creacion`) VALUES
(1, 'Inactivo', 1, now()),
(2, 'Activo', 1, now());



-- SE AÑADEN CAMPOS FALTANTES PARA AUDITORIA END TABLA ASIGNACION TALONARIO
ALTER TABLE asignacion_talonario
ADD fc_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD fc_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD id_usuario_creacion INT NOT NULL DEFAULT 0,
ADD id_usuario_actualizacion INT NOT NULL DEFAULT 0;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega_tipo_documento`
--

-- CREATE TABLE `bodega_tipo_bodega` (
  -- `id_bodega_tipo_bodega` int(11) NOT NULL AUTO_INCREMENT,
  -- `gl_bodega_tipo_bodega` varchar(255) NOT NULL,
  -- `id_usuario_crea` int(11) NOT NULL,
  -- `fc_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  -- PRIMARY KEY (`id_bodega_tipo_bodega`)
-- ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bodega_tipo_bodega`
--

-- INSERT INTO `bodega_tipo_bodega` (`id_bodega_tipo_bodega`, `gl_bodega_tipo_bodega`, `id_usuario_crea`, `fc_creacion` ) VALUES
-- (1, 'Factura', 1, now()),
-- (2, 'Guía', 1, now());


--SE AÑADEN CAMPOS FALTANTES PARA AUDITORIA END TABLA BODEGA TIPO
ALTER TABLE bodega_tipo
ADD fc_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD id_usuario_creacion INT NOT NULL DEFAULT 0;


