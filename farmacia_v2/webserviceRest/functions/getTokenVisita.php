<?php
	include_once("DAO/DAOSeguridad.php");

	if($retorno == 'application/json') {
		$uuid = DAOSeguridad::generarTokenVisita();

		$status		= true;
		$cod_error	= '000';
		$msg		= 'OK';
		$apache_msg	= 'OK';
		$apache_cod	= 200;
		$cantidad	= count($uuid);
		$resultado	= array("token_visita" => $uuid);
		
	}else{
		header("HTTP/1.1 406 Not Acceptable");
		$cod_error	= '004';
		$msg		= 'Formato de Retorno No Implementado';
		$apache_msg	= 'Not Acceptable';
		$apache_cod	= 406;
	}