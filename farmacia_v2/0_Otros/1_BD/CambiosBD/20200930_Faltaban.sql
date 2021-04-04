-- Falta
ALTER TABLE `maestro_usuario_rol` 
ADD `id_comuna_midas` INT(11) NULL DEFAULT NULL AFTER `fc_actualizacion`, 
ADD `id_region_midas` INT(11) NULL DEFAULT NULL AFTER `id_comuna_midas`;

UPDATE `maestro_usuario_rol` 
LEFT JOIN region on maestro_usuario_rol.mur_fk_region = region.region_id
SET maestro_usuario_rol.`id_region_midas` = region.id_region_midas;

UPDATE `maestro_usuario_rol` 
LEFT JOIN comuna on maestro_usuario_rol.mur_fk_comuna = comuna.comuna_id
SET maestro_usuario_rol.`id_comuna_midas` = comuna.id_comuna_midas;


UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/Empresa/creacionEmpresa' WHERE `maestro_vista`.`m_v_id` = 1;

-- Mayuscula
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/Establecimiento' WHERE `maestro_vista`.`m_v_id` = 5;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/Establecimiento' WHERE `maestro_vista`.`m_v_id` = 90;


-- Quitar Circulo
UPDATE `maestro_vista` SET `gl_icono` = NULL WHERE `maestro_vista`.`m_v_id` = 15;
UPDATE `maestro_vista` SET `gl_icono` = NULL WHERE `maestro_vista`.`m_v_id` = 19;
UPDATE `maestro_vista` SET `gl_icono` = NULL WHERE `maestro_vista`.`m_v_id` = 29;
UPDATE `maestro_vista` SET `gl_icono` = NULL WHERE `maestro_vista`.`m_v_id` = 107;