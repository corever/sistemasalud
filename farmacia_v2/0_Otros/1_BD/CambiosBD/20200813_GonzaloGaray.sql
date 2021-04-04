

##update maestro_vista gl_url
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Maestro/Maestro_empresa' WHERE `maestro_vista`.`m_v_id` = 46;
UPDATE `maestro_vista` SET `gl_url` = 'Farmacia/Maestro/Maestro_establecimiento' WHERE `maestro_vista`.`m_v_id` = 47;


##SE AÑADEN CAMPOS FALTANTES PARA AUDITORIA END TABLA FARMACIA
ALTER TABLE farmacia
ADD fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD fk_usuario_creacion INT NOT NULL DEFAULT 0,
ADD fk_usuario_actualizacion INT NOT NULL DEFAULT 0;


##SE AÑADEN CAMPOS FALTANTES PARA AUDITORIA END TABLA LOCAL
ALTER TABLE local
ADD fk_usuario_creacion INT NOT NULL DEFAULT 0,
ADD fk_usuario_actualizacion INT NOT NULL DEFAULT 0;

##SE AÑADEN CAMPOS FALTANTES PARA AUDITORIA END TABLA MAESTRO USUARIO
ALTER TABLE maestro_usuario
ADD fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD fk_usuario_creacion INT NOT NULL DEFAULT 0,
ADD fk_usuario_actualizacion INT NOT NULL DEFAULT 0;





