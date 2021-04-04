<?php

include_once("DAO/direccion/DAODireccionRegion.php");
include_once("DAO/direccion/DAODireccionComuna.php");
include_once("DAO/direccion/DAODireccionLocalidad.php");

$conn					=	new MySQL();
$daoRegion				=	new DAODireccionRegion($conn);
$daoComuna				=	new DAODireccionComuna($conn);
$daoLocalidad			=	new DAODireccionLocalidad($conn);

if($retorno == 'application/json') {
	/*	Región	*/
	$arr_regiones		=	$daoRegion->getLista();

	/*	Comuna	*/
	$arr_comunas		=	$daoComuna->getLista();

	/*	Localidad	*/
	$arr_localidad		=	$daoLocalidad->getLista();

	$conn->cerrar_conexion();

	$status				=	true;
	$cod_error			=	'000';
	$msg				=	'OK';
	$apache_msg			=	'OK';
	$apache_cod			=	200;
	$cantidad			=	array(
		"arr_regiones"		=>	count($arr_regiones),
		"arr_comunas"		=>	count($arr_comunas),
		"arr_localidad"		=>	count($arr_localidad),
	);
	$resultado			=	array(
		"arr_regiones"		=>	$arr_regiones,
		"arr_comunas"		=>	$arr_comunas,
		"arr_localidad"		=>	$arr_localidad,
	);
	
}else{
	header("HTTP/1.1 406 Not Acceptable");
	$cod_error		=	'004';
	$msg			=	'Formato de Retorno No Implementado';
	$apache_msg		=	'Not Acceptable';
	$apache_cod		=	406;
}