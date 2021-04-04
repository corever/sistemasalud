
-- actualizacion id_comuna_midas  id_region_midas seremi-----------------------
UPDATE `seremi` 
LEFT JOIN comuna on seremi.fk_comuna = comuna.comuna_id
SET seremi.`id_comuna_midas` = comuna.id_comuna_midas;

UPDATE `seremi` 
LEFT JOIN region on seremi.fk_region = region.region_id
SET seremi.`id_region_midas` = region.id_region_midas;

-- actualizacion id_comuna_midas  id_region_midas medicos----------------------

 alter table `medicos` ADD  `id_comuna_midas` int(11);
 alter table `medicos` ADD  `id_region_midas` int(11);

UPDATE `medicos` 
LEFT JOIN comuna on medicos.fk_comuna = comuna.comuna_id
SET medicos.`id_comuna_midas` = comuna.id_comuna_midas;


UPDATE `medicos` 
LEFT JOIN region on medicos.fk_region = region.region_id
SET medicos.`id_region_midas` = region.id_region_midas;

-- actualizacion id_comuna_midas  id_region_midas medico_sucursal---------------


UPDATE `medico_sucursal` 
LEFT JOIN comuna on medico_sucursal.fk_comuna = comuna.comuna_id
SET medico_sucursal.`id_comuna_midas` = comuna.id_comuna_midas;


UPDATE `medico_sucursal` 
LEFT JOIN region on medico_sucursal.fk_region = region.region_id
SET medico_sucursal.`id_region_midas` = region.id_region_midas;
