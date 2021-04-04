<?php

/*	ENVIROMENT	*/
define('ENVIROMENT','DEV');

if(ENVIROMENT == 'DEV'){
	define('DB_HOST',	'127.0.0.1');
	define('DB_USER',	'root');
	define('DB_PASS',	'');
	define('DB_NAME',	'farmanet');
	define('DB_PORT',	'3306');
}elseif(ENVIROMENT == 'TEST'){
	define('DB_HOST',	'');
	define('DB_USER',	'');
	define('DB_PASS',	'');
	define('DB_NAME',	'');
	define('DB_PORT',	'');
}elseif(ENVIROMENT == 'PROD'){
	define('DB_HOST',	'');
	define('DB_USER',	'');
	define('DB_PASS',	'');
	define('DB_NAME',	'');
	define('DB_PORT',	'');
}

define('PREFIJO_BD',	'');
define('PREFIJO_WS',	'ws_');


/*	Acceso	*/
define('TABLA_ACCESO_MODULO',									PREFIJO_BD	.	'maestro_modulo');
define('TABLA_ACCESO_ROL',										PREFIJO_BD	.	'maestro_rol');
define('TABLA_ACCESO_USUARIO',									PREFIJO_BD	.	'maestro_usuario');
define('TABLA_ACCESO_USUARIO_ROL',								PREFIJO_BD	.	'maestro_usuario_rol');

/*	Webservice	*/
define('TABLA_AUDITORIA',						PREFIJO_WS	.	PREFIJO_BD	.	'auditoria');
define('TABLA_ACCESO_SISTEMA_TOKEN',			PREFIJO_WS	.	PREFIJO_BD	.	'acceso_sistemas_token');
define('TABLA_ACCESO_SISTEMA_HISTORIAL',		PREFIJO_WS	.	PREFIJO_BD	.	'acceso_sistemas_historial');

/*	Dirección	*/
define('TABLA_DIRECCION_REGION',                				PREFIJO_BD  .   'region');
define('TABLA_DIRECCION_COMUNA',                				PREFIJO_BD  .   'comuna');
define('TABLA_DIRECCION_TERRITORIO',            				PREFIJO_BD  .   'territorio');
define('TABLA_DIRECCION_LOCALIDAD',             				PREFIJO_BD  .   'localidad');


/*	Farmacia - Local	*/
define('TABLA_FARMACIA',										PREFIJO_BD	.	'farmacia');
define('TABLA_FARMACIA_CARACTER',								PREFIJO_BD	.	'farmacia_caracter');
define('TABLA_LOCAL',											PREFIJO_BD	.	'local');
define('TABLA_LOCAL_ESTADO',									PREFIJO_BD	.	'local_estado');
define('TABLA_LOCAL_ESTADO_TURNO',								PREFIJO_BD	.	'local_estado_turno');
define('TABLA_LOCAL_TIPO',										PREFIJO_BD	.	'local_tipo');
define('TABLA_LOCAL_CLASIFICACION',								PREFIJO_BD	.	'local_clasificacion');
define('TABLA_LOCAL_RECETARIO_TIPO',							PREFIJO_BD	.	'local_recetario_tipo');
define('TABLA_LOCAL_RECETARIO_DETALLE',							PREFIJO_BD	.	'local_recetario_detalle');
define('TABLA_LOCAL_HORARIO',									PREFIJO_BD	.	'local_horario');
define('TABLA_LOCAL_FUNCIONAMIENTO',							PREFIJO_BD	.	'local_funcionamiento');
define('TABLA_LOCAL_MOTIVO_DESHABILITAR',						PREFIJO_BD	.	'motivo_inhabilitacion');
define('TABLA_LOCAL_HISTORIAL',									PREFIJO_BD	.	'historial_local');
define('TABLA_LOCAL_HISTORIAL_TIPO',							PREFIJO_BD	.	'historial_local_tipo');

define('TABLA_CODIGO_REGION',									PREFIJO_BD	.	'codfono_region');
