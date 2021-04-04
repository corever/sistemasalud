
 INSERT INTO `maestro_rol` (`rol_id`, `rol_nombre`, `rol_nombre_header`,`rol_nombre_vista`,`tipo_rol_acceso`,`nr_orden`) 
 VALUES (20, 'Firmante Delegado', 'Firmante Delegado','Firmante Delegado',0,19);

UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminSeremi' WHERE `maestro_vista`.`m_v_id` = 68;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminSeremi' WHERE `maestro_vista`.`m_v_id` = 71;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminSeremi' WHERE `maestro_vista`.`m_v_id` = 88;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminSeremi' WHERE `maestro_vista`.`m_v_id` = 94;