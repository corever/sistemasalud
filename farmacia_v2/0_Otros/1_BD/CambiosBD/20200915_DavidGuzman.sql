-- Alter tablas con id_region_midas
ALTER TABLE `maestro_usuario_rol`
    ADD `id_region_midas` INT(11) NOT NULL AFTER `fk_bodega`,
    ADD `id_comuna_midas` INT(11) NOT NULL AFTER `id_region_midas`;

ALTER TABLE `venta`
    ADD `id_region_midas` INT(11) NOT NULL AFTER `id_vendedor`;
-- Regularizar tablas donde se agrega region y comuna midas
update `maestro_usuario_rol`
LEFT JOIN comuna on maestro_usuario_rol.mur_fk_comuna = comuna.comuna_id
LEFT JOIN region on maestro_usuario_rol.mur_fk_region = region.region_id
SET maestro_usuario_rol.`id_comuna_midas` = comuna.id_comuna_midas,
maestro_usuario_rol.`id_region_midas` = region.id_region_midas;

update `venta`
LEFT JOIN region on venta.fk_region = region.region_id
SET venta.`id_region_midas` = region.id_region_midas;

-- maestro_vista menu maestro usuario
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Maestro/Usuario' WHERE `maestro_vista`.`m_v_id` = 44;

-- maestro_vista agrego nr_orden
ALTER TABLE `maestro_vista` ADD `nr_orden` INT(11) NOT NULL DEFAULT '0' AFTER `fk_modulo`;
UPDATE maestro_vista SET nr_orden = m_v_id;