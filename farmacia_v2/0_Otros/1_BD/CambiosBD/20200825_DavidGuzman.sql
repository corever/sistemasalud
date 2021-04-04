/*Modifico gl_icono = '' en maestro_vista*/
UPDATE `maestro_vista` SET gl_icono = '' WHERE `gl_icono` LIKE '%far fa-circle%'

/*Modifico gl_url de maestro_vista (opciones menu)*/
-- Modulo 1 = Farmacias
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/AdminEmpresa' WHERE `maestro_vista`.`m_v_id` = 1;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/AdminEstablecimiento' WHERE `maestro_vista`.`m_v_id` = 2;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/AdminProfesional' WHERE `maestro_vista`.`m_v_id` = 3;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/AdminEmpresa' WHERE `maestro_vista`.`m_v_id` = 4;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/AdminEstablecimiento' WHERE `maestro_vista`.`m_v_id` = 5;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/AdminProfesional' WHERE `maestro_vista`.`m_v_id` = 6;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/AdminEstablecimiento' WHERE `maestro_vista`.`m_v_id` = 39;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/AdminProfesional' WHERE `maestro_vista`.`m_v_id` = 40;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/Sumarios' WHERE `maestro_vista`.`m_v_id` = 41;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/Denuncias' WHERE `maestro_vista`.`m_v_id` = 65;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/AdminEstablecimiento' WHERE `maestro_vista`.`m_v_id` = 90;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Farmacias/Sumarios' WHERE `maestro_vista`.`m_v_id` = 92;

-- Modulo 2 = Recetas
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Recetas/AdminRecetas' WHERE `maestro_vista`.`m_v_id` = 7;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Recetas/AdminRecetas' WHERE `maestro_vista`.`m_v_id` = 9;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Recetas/AdminMedicamentos' WHERE `maestro_vista`.`m_v_id` = 12;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Recetas/AdminRecetas' WHERE `maestro_vista`.`m_v_id` = 13;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Recetas/AdminRecetas' WHERE `maestro_vista`.`m_v_id` = 55;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Recetas/AdminRecetas' WHERE `maestro_vista`.`m_v_id` = 56;

-- Modulo 3 = Turnos
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminTurnos' WHERE `maestro_vista`.`m_v_id` = 14;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminTurnos' WHERE `maestro_vista`.`m_v_id` = 15;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminTurnos' WHERE `maestro_vista`.`m_v_id` = 16;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminTurnos' WHERE `maestro_vista`.`m_v_id` = 17;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminResolucion' WHERE `maestro_vista`.`m_v_id` = 29;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminTurnos' WHERE `maestro_vista`.`m_v_id` = 42;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminResolucion' WHERE `maestro_vista`.`m_v_id` = 51;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminFirma' WHERE `maestro_vista`.`m_v_id` = 68;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminRecetas' WHERE `maestro_vista`.`m_v_id` = 69;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminFirma' WHERE `maestro_vista`.`m_v_id` = 71;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminFirma' WHERE `maestro_vista`.`m_v_id` = 88;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminFirma' WHERE `maestro_vista`.`m_v_id` = 94;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Turnos/AdminTurnos' WHERE `maestro_vista`.`m_v_id` = 98;

-- Modulo 5 = Talonarios
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/AdminBodega' WHERE `maestro_vista`.`m_v_id` = 18;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/AdminBodega' WHERE `maestro_vista`.`m_v_id` = 19;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/AdminBodega' WHERE `maestro_vista`.`m_v_id` = 20;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/Talonario' WHERE `maestro_vista`.`m_v_id` = 21;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/Talonario/ventaTalonario' WHERE `maestro_vista`.`m_v_id` = 22;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/Talonario' WHERE `maestro_vista`.`m_v_id` = 23;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/LocalVenta' WHERE `maestro_vista`.`m_v_id` = 38;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/AdminReceta' WHERE `maestro_vista`.`m_v_id` = 43;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/LocalVenta' WHERE `maestro_vista`.`m_v_id` = 86;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Talonarios/AdminReceta' WHERE `maestro_vista`.`m_v_id` = 89;

-- Modulo 6 = Usuario
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Usuario/AdminUsuario' WHERE `maestro_vista`.`m_v_id` = 24;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Usuario/AdminUsuario' WHERE `maestro_vista`.`m_v_id` = 25;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Usuario/AdminUsuario' WHERE `maestro_vista`.`m_v_id` = 26;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Usuario/AdminUsuario' WHERE `maestro_vista`.`m_v_id` = 27;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Usuario/AdminUsuario' WHERE `maestro_vista`.`m_v_id` = 93;

-- Modulo 7 = Informes
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 30;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 31;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 32;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 33;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 36;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 37;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 72;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 73;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 74;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 75;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 76;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 77;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 78;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 79;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 80;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 81;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 82;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 87;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Informes/Informe' WHERE `maestro_vista`.`m_v_id` = 97;

-- Modulo 8 = Maestro
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Maestro/Medicamento' WHERE `maestro_vista`.`m_v_id` = 45;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Maestro/Territorio' WHERE `maestro_vista`.`m_v_id` = 48;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Maestro/Localidad' WHERE `maestro_vista`.`m_v_id` = 49;

-- Modulo 11 = Informe Gestion
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/InformeGestion/Gestion' WHERE `maestro_vista`.`m_v_id` = 57;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/InformeGestion/Gestion' WHERE `maestro_vista`.`m_v_id` = 58;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/InformeGestion/Gestion' WHERE `maestro_vista`.`m_v_id` = 83;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/InformeGestion/Gestion' WHERE `maestro_vista`.`m_v_id` = 84;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/InformeGestion/Gestion' WHERE `maestro_vista`.`m_v_id` = 85;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/InformeGestion/Gestion' WHERE `maestro_vista`.`m_v_id` = 91;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/InformeGestion/Gestion' WHERE `maestro_vista`.`m_v_id` = 95;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/InformeGestion/Gestion' WHERE `maestro_vista`.`m_v_id` = 96;

-- Modulo 12 = Informe Gestion
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/AlarmasFiscalizacion/Alarma' WHERE `maestro_vista`.`m_v_id` = 59;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/AlarmasFiscalizacion/Alarma' WHERE `maestro_vista`.`m_v_id` = 60;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/AlarmasFiscalizacion/Alarma' WHERE `maestro_vista`.`m_v_id` = 61;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/AlarmasFiscalizacion/Alarma' WHERE `maestro_vista`.`m_v_id` = 62;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/AlarmasFiscalizacion/Alarma' WHERE `maestro_vista`.`m_v_id` = 63;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/AlarmasFiscalizacion/Alarma' WHERE `maestro_vista`.`m_v_id` = 64;