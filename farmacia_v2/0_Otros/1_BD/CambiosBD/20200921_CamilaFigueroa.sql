ALTER TABLE `comuna` ADD id_region_midas int(11);

UPDATE `comuna` 
LEFT JOIN region on comuna.fk_region = region.region_id
SET comuna.`id_region_midas` = region.id_region_midas;