-- Se debe Regularizar Data
DROP TABLE IF EXISTS `medico_sucursal`;
CREATE TABLE `medico_sucursal` (
  `id_sxm` int(11) NOT NULL,
  `fk_medico` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fk_region` int(11) NOT NULL,
  `fk_comuna` int(11) NOT NULL,
  `direccion_sucursal` varchar(200) CHARACTER SET utf8 NOT NULL,
  `fono_codigo` varchar(11) CHARACTER SET utf8 NOT NULL,
  `fono` varchar(50) CHARACTER SET utf8 NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `consulta_estado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `medico_sucursal`
  ADD PRIMARY KEY (`id_sxm`);

ALTER TABLE `medico_sucursal`
  MODIFY `id_sxm` int(11) NOT NULL AUTO_INCREMENT;
