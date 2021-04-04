-- No se puede eliminar una Tabla que existe en Prod

-- Todas las columnas nuevas deben ser NULL por defecto
-- Se debe Cambiar medico_gen por maestro_usuario.mu_genero 
-- Se debe Cambiar medico_fecha_nacimiento por  maestro_usuario.mu_fecha_nacimiento 
-- Se debe Cambiar medico_correo por maestro_usuario.mu_correo 
-- Se debe Cambiar fono por maestro_usuario.fono 
-- Se debe Cambiar fono_codigo por maestro_usuario.fono_codigo 

/*
ALTER TABLE `medicos` ADD `medico_gen` ENUM('masculino','femenino') NULL DEFAULT NULL AFTER `medico_apellidomat`;
ALTER TABLE `medicos` ADD `medico_fecha_nacimiento` DATE NULL DEFAULT NULL AFTER `medico_gen`;
*/

ALTER TABLE `medicos` 
ADD `fecha_creacion` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER,
ADD `medico_estado` INT(1) NULL DEFAULT '1' AFTER, 
ADD `fecha_actualizacion` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP AFTER;

