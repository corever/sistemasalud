-- --------------------------------------------------------
-- Incorporacion de nuevo campo en tabla SEREMI 
-- --------------------------------------------------------

ALTER TABLE `seremi` 
ADD COLUMN `id_tipo_firmante` int(11);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `far_tipo_firmante`
-- --------------------------------------------------------

CREATE TABLE `seremi_tipo_firmante` ( 
	`id_firmante` int(11) NOT null PRIMARY KEY AUTO_INCREMENT, 
	`gl_tipo_firmante` varchar(250) NOT NULL 
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Inserción de datos para tabla 'far_tipo_firmante'
-- --------------------------------------------------------

INSERT INTO `seremi_tipo_firmante` (`gl_tipo_firmante`) VALUES
('Firma Delegada'),
('Firmante'),
('Firmante(S)');