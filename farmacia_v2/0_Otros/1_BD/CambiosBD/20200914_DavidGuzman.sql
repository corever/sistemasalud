-- Alter tablas con id_region_midas
ALTER TABLE `bodega`
    ADD `id_region_midas` INT(11) NOT NULL AFTER `bodega_direccion`,
    ADD `id_comuna_midas` INT(11) NOT NULL AFTER `id_region_midas`;

ALTER TABLE `codfono_region`
    ADD `id_region_midas` INT(11) NOT NULL AFTER `codigo`;

ALTER TABLE `farmacia`
    ADD `id_region_midas` INT(11) NOT NULL AFTER `farmacia_direccion`,
    ADD `id_comuna_midas` INT(11) NOT NULL AFTER `id_region_midas`;

    
ALTER TABLE `localidad`
    ADD `id_comuna_midas` INT(11) NOT NULL AFTER `localidad_nombre`;

ALTER TABLE `local`
    ADD `id_region_midas` INT(11) NOT NULL AFTER `fk_localidad`,
    ADD `id_comuna_midas` INT(11) NOT NULL AFTER `id_region_midas`;

-- Regularizar tablas donde se agrega region y comuna midas
update `bodega`
LEFT JOIN comuna on bodega.fk_comuna = comuna.comuna_id
LEFT JOIN region on bodega.fk_region = region.region_id
SET bodega.`id_comuna_midas` = comuna.id_comuna_midas,
bodega.`id_region_midas` = region.id_region_midas;

update `codfono_region` 
LEFT JOIN region on codfono_region.fk_region = region.region_id
    set codfono_region.`id_region_midas` = region.id_region_midas;

update `farmacia`
LEFT JOIN comuna on farmacia.fk_comuna = comuna.comuna_id
LEFT JOIN region on farmacia.fk_region = region.region_id
    set farmacia.`id_comuna_midas` = comuna.id_comuna_midas,
    farmacia.`id_region_midas` = region.id_region_midas;

update `localidad`
LEFT JOIN comuna on localidad.fk_comuna = comuna.comuna_id
    set localidad.`id_comuna_midas` = comuna.id_comuna_midas;

update `local` 
LEFT JOIN comuna on local.fk_comuna = comuna.comuna_id
LEFT JOIN region on local.fk_region = region.region_id
    set local.`id_comuna_midas` = comuna.id_comuna_midas,
    local.`id_region_midas` = region.id_region_midas;