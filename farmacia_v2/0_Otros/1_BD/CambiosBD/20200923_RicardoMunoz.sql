/*
UPDATE `bodega` 
SET bodega.fk_comuna = 1 
WHERE bodega.fk_comuna = 0 ;
*/

UPDATE `bodega` 
LEFT JOIN region on bodega.fk_region = region.region_id
SET bodega.`id_region_midas` = region.id_region_midas;

UPDATE `bodega` 
LEFT JOIN comuna on bodega.fk_comuna = comuna.comuna_id
SET bodega.`id_comuna_midas` = comuna.id_comuna_midas
WHERE bodega.fk_comuna <> 0 ;


/* no borrar
INSERT INTO `maestro_usuario_rol` (`mur_fk_usuario`, `mur_fk_rol`, `gl_token`, `json_permisos`, `mur_estado_activado`, `fk_farmacia`, `fk_local`, `fk_bodega`, `id_region_midas`, `id_comuna_midas`, `mur_fk_region`, `mur_fk_territorio`, `mur_fk_comuna`, `mur_fk_localidad`, `rol_fecha_creacion`, `rol_creador`, `id_usuario_actualizacion`, `fc_actualizacion`)
SELECT '321', '3', '78d3ebb16dfbdff70a82f7650c1c692c6fe0859d', '[]', '1', '0', '0', '0', '5', '0', '6', '1', '0', '0', '2013-11-15 13:53:14', '0', NULL, '2020-09-08 01:15:24'
FROM `maestro_usuario_rol`
WHERE ((`mur_id` = '159'));
*/

INSERT INTO `maestro_vista` (`m_v_id`, `nombre_vista`, `link_vista`, `img`, `gl_url`, `gl_icono`, `fk_modulo`, `bo_activo`, `fc_actualiza`, `id_usuario_actualiza`, `fc_crea`, `id_usuario_crea`, `nr_orden`)
VALUES ( '107', 'Asignar Talonarios', 'lista_talonario', 'img', 'Farmacia/Talonarios/AsignarTalonario', 'far fa-circle', '5', '1', '0000-00-00', '0', '2020-09-23 02:10:41', '0', '99');

INSERT INTO `rol_vista` (`fk_rol`, `fk_vista`, `permiso`)
VALUES ( '1', '107', '1'),
VALUES ( '5', '107', '1');



 