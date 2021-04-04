<?php

/**
 * Gestiona las variables globales/constantes
 * correspondientes a base de datos.
 */

#BASE_TABLA
define('BASE_TABLA', '');

#TABLAS
define('TABLA_ACCESO_OPCION', BASE_TABLA . 'maestro_vista');
define('TABLA_ACCESO_MODULO', BASE_TABLA . 'maestro_modulo');
define('TABLA_ACCESO_ROL', BASE_TABLA . 'maestro_rol');
define('TABLA_ACCESO_ROL_OPCION', BASE_TABLA . 'rol_vista');
define('TABLA_ACCESO_SISTEMA_TOKEN', BASE_TABLA . 'acceso_sistemas_token');
define('TABLA_ACCESO_USUARIO', BASE_TABLA . 'maestro_usuario');
define('TABLA_ACCESO_USUARIO_OPCION', BASE_TABLA . 'acceso_usuario_opcion');
define('TABLA_ACCESO_USUARIO_ROL', BASE_TABLA . 'maestro_usuario_rol');

define('TABLA_DIRECCION_REGION',                BASE_TABLA  .   'region');
define('TABLA_DIRECCION_COMUNA',                BASE_TABLA  .   'comuna');
define('TABLA_DIRECCION_TERRITORIO',            BASE_TABLA  .   'territorio');
define('TABLA_DIRECCION_LOCALIDAD',             BASE_TABLA  .   'localidad');

/*	Farmacia - Local	*/
define('TABLA_FARMACIA',                        BASE_TABLA    .    'farmacia');
define('TABLA_FARMACIA_CARACTER',                BASE_TABLA    .    'farmacia_caracter');
define('TABLA_LOCAL',                            BASE_TABLA    .    'local');
define('TABLA_LOCAL_ESTADO',                    BASE_TABLA    .    'local_estado');
define('TABLA_LOCAL_ESTADO_TURNO',                BASE_TABLA    .    'local_estado_turno');
define('TABLA_LOCAL_TIPO',                        BASE_TABLA    .    'local_tipo');
define('TABLA_LOCAL_CLASIFICACION',                BASE_TABLA    .    'local_clasificacion');
define('TABLA_LOCAL_RECETARIO_TIPO',            BASE_TABLA    .    'local_recetario_tipo');
define('TABLA_LOCAL_RECETARIO_DETALLE',            BASE_TABLA    .    'local_recetario_detalle');
define('TABLA_LOCAL_HORARIO',                    BASE_TABLA    .    'local_horario');
define('TABLA_LOCAL_FUNCIONAMIENTO',            BASE_TABLA    .    'local_funcionamiento');
define('TABLA_LOCAL_MOTIVO_DESHABILITAR',        BASE_TABLA    .    'motivo_inhabilitacion');
define('TABLA_LOCAL_HISTORIAL',                    BASE_TABLA    .    'historial_local');
define('TABLA_LOCAL_HISTORIAL_TIPO',            BASE_TABLA    .    'historial_local_tipo');

/*	Turno	*/
define('TABLA_TURNO_TIPO_PERIODO',              BASE_TABLA      .   'turno_tipo_periodo');
define('TABLA_TURNO',                           BASE_TABLA      .   'turno');
define('TABLA_TURNO_DETALLE',                   BASE_TABLA      .   'turno_detalle');
define('TABLA_TURNO_RESOLUCION_DOC',            BASE_TABLA      .   'turno_resolucion_doc');
define('TABLA_TURNO_COD_RESOLUCION',            BASE_TABLA      .   'turno_cod_resolucion');
define('TABLA_TURNO_RESOLUCION',                BASE_TABLA      .   'turno_resolucion');


define('TABLA_VENTA',                            BASE_TABLA    .    'venta');

define('TABLA_DIRECTOR_TECNICO', BASE_TABLA . 'director_tecnico');
define('TABLA_ADJUNTO', BASE_TABLA . 'adjunto');
define('TABLA_TRADUCTOR', BASE_TABLA . 'far_traductor');
define('TABLA_ADJUNTO_TIPO', BASE_TABLA . 'adjunto_tipo');
define('TABLA_ACCESO_USUARIO_MODULO', BASE_TABLA . 'acceso_usuario_modulo');
define('TABLA_ASIGNACION', BASE_TABLA . 'asignacion');
define('TABLA_ASIGNACION_DEVOLVER', BASE_TABLA . 'asignacion_devolver');
define('TABLA_ASIGNACION_ESTADO', BASE_TABLA . 'asignacion_estado');
define('TABLA_ASIGNACION_USUARIO', BASE_TABLA . 'asignacion_usuario');
define('TABLA_DISPOSITIVO_USUARIO', BASE_TABLA . 'dispositivo_usuario');
define('TABLA_EVENTO', BASE_TABLA . 'evento');
define('TABLA_FORMULARIO_JSON', 'frm_formularios');
define('TABLA_HISTORIAL_EVENTO_ASIGNACION', BASE_TABLA . 'historial_evento_asignacion');
define('TABLA_MENSAJE_USUARIO', BASE_TABLA . 'mensaje_usuario');
define('TABLA_VISITA', BASE_TABLA . 'visita');
define('TABLA_VISITA_ESTADO', BASE_TABLA . 'visita_estado');
define('TABLA_VISITA_TIPO_PERDIDA', BASE_TABLA . 'visita_tipo_perdida');
define('TABLA_WS_ACCESO_SISTEMA', 'ws_acceso_sistemas');
define('TABLA_WS_CONFIGURACION_APP', 'ws_configuracion_app');
define('TABLA_WS_AUDITORIA', 'ws_auditoria');

/* Tabla para Medicos y Sucursales
 */
define('TABLA_MEDICO', BASE_TABLA . 'medicos');
define('TABLA_SUCURSAL_MEDICO', BASE_TABLA . 'medico_sucursal');
define('TABLA_MEDICO_ADJUNTO', BASE_TABLA . 'medico_adjunto');
/*
 */

define('TABLA_PROFESION', BASE_TABLA . 'profesion_detalle');
define('TABLA_ESPECIALIDAD', BASE_TABLA . 'medico_especialidad');
define('TABLA_PROFESION_USUARIO', BASE_TABLA . 'profesion_por_usuario');
define('TABLA_ESPECIALIDAD_MEDICO', BASE_TABLA . 'especialidad_por_medico');
define('TABLA_CODIGO_REGION', BASE_TABLA . 'codfono_region');

/**
 * INICIO Tablas para bodega
 */
define('TABLA_BODEGA', BASE_TABLA . 'bodega');
define('TABLA_BODEGA_TIPO', BASE_TABLA . 'bodega_tipo');
define('TABLA_TALONARIO', BASE_TABLA . 'talonario');
define('TABLA_TALONARIO_CREADOS', BASE_TABLA . 'talonarios_creados');
define('TABLA_TALONARIO_VENDIDOS', BASE_TABLA . 'talonarios_vendidos');
define('TABLA_TALONARIO_HISTORIAL', BASE_TABLA . 'talonario_precio_historial');
define('TABLA_TALONARIO_TIPO_DOCUMENTO', BASE_TABLA . 'talonario_tipo_documento');
define('TABLA_TALONARIO_TIPO_PROVEEDOR', BASE_TABLA . 'talonario_tipo_proveedor');
define('TABLA_ASIGNACION_TALONARIO', BASE_TABLA . 'asignacion_talonario');
define('TABLA_DESASIGNACION_TALONARIO', BASE_TABLA . 'desasignacion_talonario');
define('TABLA_TALONARIO_ESTADO', BASE_TABLA . 'talonario_estado');
define('TABLA_TALONARIO_TIPO_MOTIVO', BASE_TABLA . 'talonario_tipo_motivo');


/**
 * Tablas para Seremi
 * Se incorpora tabla de tipo_firmante
 */
define('TABLA_SEREMI', BASE_TABLA . 'seremi');
define('TABLA_FIRMANTE', BASE_TABLA . 'far_tipo_firmante');

/**
 * Tablas para registro de DT
 */
define('TABLA_REGISTRO_DT', BASE_TABLA . 'dt_solicitud_registro');
