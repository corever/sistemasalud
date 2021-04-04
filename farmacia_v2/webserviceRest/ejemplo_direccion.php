<?php
	date_default_timezone_set('America/Santiago');
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	function getHash($base,$public_key,$private_key,$token_ws){
		$token	= hash('sha1',$token_ws.$public_key);
		$string	= $base.$token;

		return hash_hmac('sha512',$string,$private_key);
	}

	$url_ws			=	'http://localhost/farmacia_v2/webserviceRest/apiExterno.php';
	$base			=	'wsEstablecimientos';
	$public_key		=	'bd7d390d1a3527051c2109e983065d3968745297f2086d30ef4d8edee4d93b25';
	$private_key	=	'733e63ca4faf683e9e814aa492ce7819573216f3e586f6bef1c1d37500cdc2ee05c193af4e5978cb3a93c5da68c0b33e8287bb660389d6b7d854a0900d2a35a3';
	$pass			=	'19a201e8e7f6ff6ee5cda534c3a7260ef980695da10f6f1b87b8cf101f0a83284b4fb04872b8cf6a7cb7fe0dcbf39beb85bf3c31f1eab390b5bab3428447eb94';
	$token_ws		=	'';
	$hash			=	getHash($base,$public_key,$private_key,$token_ws);
	$authorization	=	"Authorization: Basic ".base64_encode($base.':'.$pass);

	/* WS Negociar */
	$data			=	array(
		'public_key'	=> $public_key,
		'hash'			=> $hash,
		'version_ws'	=> '1.0',
		'metodo'		=> 'negociar',
		'Accept'		=> 'application/json',
	);

	$post_data	= http_build_query($data);
	$post		= $post_data;
	$url		= $url_ws;
	$ch			= curl_init($url);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
	curl_setopt($ch, CURLOPT_TIMEOUT, 180);

	$respuesta	= curl_exec($ch);
	if($respuesta === false)
	{
		echo 'Curl error: ' . curl_error($ch);die;
	}
	curl_close($ch);
	
	$arr_respuesta		=	json_decode($respuesta);
	
	if($arr_respuesta->bo_estado){
		$token_ws		=	$arr_respuesta->arr_resultado->token_ws;
		$hash			=	getHash($base,$public_key,$private_key,$token_ws);
		$authorization	=	"Authorization: Bearer ".$token_ws;

		/* WS Metodo */
		$data	= array(
			'public_key'	=> $public_key,
			'hash'			=> $hash,
			'version_ws'	=> '1.0',
			'Accept'		=> 'application/json',
			'appVersion'	=> '1.0.0',
			'metodo'		=> 'getDatosTiposDireccion',
		);

		$post_data		=	http_build_query($data);
		$post			=	$post_data;
		$url			=	$url_ws;
		$ch				=	curl_init($url);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
		curl_setopt($ch, CURLOPT_TIMEOUT, 180);

		$respuesta	= curl_exec($ch);
		if($respuesta === false)
		{
			echo 'Curl error: ' . curl_error($ch);die;
		}

		curl_close($ch);
		echo $respuesta;
	}else{
		echo 'Error al negociar';
	}
