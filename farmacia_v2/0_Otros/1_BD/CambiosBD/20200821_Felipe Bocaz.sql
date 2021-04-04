-- Tabla mal creada, se debe utilizar medicos.fk_esp

/*
DROP TABLE IF EXISTS `especialidad_por_medico`;
CREATE TABLE `especialidad_por_medico` (
  `id_pxu` int(11) NOT NULL,
  `fk_medico` int(11) NOT NULL,
  `fk_especialidad` int(11) NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha Creacion'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `especialidad_por_medico`
  ADD PRIMARY KEY (`id_pxu`),
  ADD KEY `id_pxu` (`id_pxu`),
  ADD KEY `fk_usuario` (`fk_medico`);

ALTER TABLE `especialidad_por_medico`
  MODIFY `id_pxu` int(11) NOT NULL AUTO_INCREMENT;
*/