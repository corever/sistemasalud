
CREATE TABLE `medico_adjunto` (
  `id_adjunto_medico` int(11) NOT NULL,
  `id_medico` int(11) DEFAULT NULL,
  `gl_url` varchar(250) DEFAULT NULL,
  `fc_crea` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario_crea` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `medico_adjunto`
  ADD PRIMARY KEY (`id_adjunto_medico`);

ALTER TABLE `medico_adjunto`
  MODIFY `id_adjunto_medico` int(11) NOT NULL AUTO_INCREMENT;


/*Agrego gl_nombre a medico_adjunto*/
-- Corresponde este cambio?
-- No encontre SQL de la tabla en GIT
ALTER TABLE `medico_adjunto` ADD `gl_nombre` VARCHAR(250) NULL DEFAULT NULL AFTER `id_medico`;
