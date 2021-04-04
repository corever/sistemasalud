
UPDATE `maestro_vista` SET
`gl_url` = 'Farmacia/Usuario/AdminUsuario/InfoUsuario'
WHERE `m_v_id` = '93';



UPDATE `maestro_vista` SET
`fk_modulo` = '5'
WHERE `m_v_id` = '99';


-- previo al alter 0_Otros\1_BD\CambiosBD\20200916_CamilaFigueroa.sql
ALTER TABLE `seremi`
CHANGE `seremi_trato` `seremi_trato` enum('MV.','QF.','DR.','SR.','ING.','MG.','DRA.','SRA.','SRTA.','DON','DOÑA','OTRO','KLGO.') COLLATE 'utf8_general_ci' NOT NULL DEFAULT 'OTRO' COMMENT 'Sigla Tratamiento Cortesia' AFTER `genero_seremi`;

alter table `seremi` ADD  `id_comuna_midas` int(11);
alter table `seremi` ADD  `id_region_midas` int(11);