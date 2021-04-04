<?php
	$token_ws	= '';
	if($retorno == 'application/json') {
		$token_ws	= getHashUnico($base,$public_key,$private_key);

		$status		= true;
		$cod_error	= '000';
		$msg		= 'OK';
		$apache_msg	= 'OK';
		$apache_cod	= 200;
		$cantidad	= count($token_ws);
		$resultado	= array('token_ws'=>$token_ws);
		
	}else{
		header("HTTP/1.1 406 Not Acceptable");
		$cod_error	= '004';
		$msg		= 'Formato de Retorno No Implementado';
		$apache_msg	= 'Not Acceptable';
		$apache_cod	= 406;
	}

	// Guardar $token_ws en BD
	$daoWSToken->insertarRegistro($token_ws,$gl_ambiente,$public_key,array($apache_msg),'');