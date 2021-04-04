
INSERT INTO `maestro_vista` (`m_v_id`,`nombre_vista`, `link_vista`, `img`, `gl_url`, `gl_icono`, `fk_modulo`)
VALUES(99, 'Lista Talonario', 'lista_talonario', 'img', 'Farmacia/Talonarios/ListaTalonario', '', '5');


 
 INSERT INTO `rol_vista` (`fk_rol`, `fk_vista`, `permiso`) VALUES ('1', '99', '1');
 INSERT INTO `rol_vista` (`fk_rol`, `fk_vista`, `permiso`) VALUES ('2', '99', '1');
 INSERT INTO `rol_vista` (`fk_rol`, `fk_vista`, `permiso`) VALUES ('3', '99', '1');

