-- Creacion de columnas

ALTER TABLE `comuna` ADD `id_region_midas` int(11);
ALTER TABLE `comuna` ADD `id_comuna_midas` int(11);

ALTER TABLE `maestro_usuario` ADD `id_region_midas` int(11);
ALTER TABLE `maestro_usuario` ADD `id_comuna_midas` int(11);

ALTER TABLE `seremi` ADD `id_region_midas` int(11);
ALTER TABLE `seremi` ADD `id_comuna_midas` int(11);

ALTER TABLE `medico_sucursal` ADD `id_region_midas` int(11);
ALTER TABLE `medico_sucursal` ADD `id_comuna_midas` int(11);

ALTER TABLE `medicos` ADD `id_region_midas` int(11);
ALTER TABLE `medicos` ADD `id_comuna_midas` int(11);



--Incorporacion de datos

UPDATE `comuna` 
SET comuna.`id_comuna_midas` = comuna.id_comuna_midas;

UPDATE `comuna` 
LEFT JOIN region on comuna.fk_region_midas = region.region_id
SET comuna.`id_region_midas` = region.id_region_midas;

UPDATE `maestro_usuario` 
LEFT JOIN comuna on maestro_usuario.mu_dir_comuna = comuna.comuna_id
SET maestro_usuario.`id_comuna_midas` = comuna.id_comuna_midas;


UPDATE `maestro_usuario` 
LEFT JOIN region on maestro_usuario.mu_dir_region = region.region_id
SET maestro_usuario.`id_region_midas` = region.id_region_midas;


UPDATE `seremi` 
LEFT JOIN comuna on seremi.fk_comuna = comuna.comuna_id
SET seremi.`id_comuna_midas` = comuna.id_comuna_midas;

UPDATE `seremi` 
LEFT JOIN region on seremi.fk_region = region.region_id
SET seremi.`id_region_midas` = region.id_region_midas;


UPDATE `medico_sucursal` 
LEFT JOIN comuna on medico_sucursal.fk_comuna = comuna.comuna_id
SET medico_sucursal.`id_comuna_midas` = comuna.id_comuna_midas;


UPDATE `medico_sucursal` 
LEFT JOIN region on medico_sucursal.fk_region = region.region_id
SET medico_sucursal.`id_region_midas` = region.id_region_midas;

-- id_comuna_midas medicos es columna nueva asi que su valor se graba al agregar uno nuevo

UPDATE `medicos` 
LEFT JOIN region on medicos.fk_region = region.region_id
SET medicos.`id_region_midas` = region.id_region_midas;



