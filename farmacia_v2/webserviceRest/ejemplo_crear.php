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

	//echo $hash.'<br/>';die;
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
	// echo $respuesta; die;
	
	$arr_respuesta	= json_decode($respuesta);
	//echo print_r($respuesta, true);
	//echo "<br/>";
	
	if($arr_respuesta->bo_estado){
		$token_ws		= $arr_respuesta->arr_resultado->token_ws;
		$hash			= getHash($base,$public_key,$private_key,$token_ws);
		$authorization = "Authorization: Bearer ".$token_ws;


		/*
		$data	= array(
					'public_key'	=> $public_key,
					'hash'			=> $hash,
					'version_ws'	=> '1.0',
					'appVersion'	=> '1.0'
					'token_dispositivo' => '0000',
					'metodo'		=> 'getTodas', // getTodas - getTurno - getDT
					'fc_turno'		=> '05/05/2016', //date('d/m/Y'), // Opcional para getTurno, sino se setea sera siempre HOY
					'con_horario'	=> false, // Opcional para getTodas, sino se setea no devuelve el Horario de Funcionamiento
					'gl_rut'		=> '16664632-4',
					'gl_clave'		=> '8cb2237d0679ca88db6464eac60da96345513964', //'12345',
					//'Content-Type'	=> 'application/x-www-form-urlencoded', // application/json
					'Accept'		=> 'application/json',
				);
		*/
		/* Metodos: 
			getDatosTiposDireccion
			getDatosTiposBase
			getNotificacionAccidente
			login
		*/

		$arr_datos				=	array(
			"gl_rut_farmacia"						=>	"13722334-1",
			"nr_rci"								=>	"MN2911",
			"gl_factor_riesgo"						=>	"Alto",
			"nr_resolucion_apertura"				=>	"6769425",
			"fc_resolucion"							=>	"22/09/2020",
			"gl_nombre_establecimiento"				=>	"FARMACIAS GABRIELLO'S 2",
			"nr_numero_establecimiento"				=>	"6879",
			"id_tipo_establecimiento"				=>	"3",
			"gl_fono_codigo"						=>	"34",
			"gl_fono"								=>	"3444561",
			"bo_clasificacion_alopatica"			=>	FALSE,
			"bo_clasificacion_homeopatica"			=>	FALSE,
			"bo_clasificacion_movil"				=>	TRUE,
			"bo_clasificacion_urgencia"				=>	TRUE,
			"bo_franquicia"							=>	TRUE,
			"bo_ver_ubicacion_en_mapa"				=>	TRUE,
			"arr_recorrido"							=>	NULL,
			// array(
			// 	array(
			// 		"id_region"						=>	"5",
			// 		"id_comuna"						=>	"78",
			// 		"id_localidad"					=>	"29",
			// 		"gl_direccion"					=>	"Pacífico 344",
			// 		"gl_latitud_direccion"			=>	NULL,
			// 		"gl_longitud_direccion"			=>	NULL,
			// 	),
			// 	array(
			// 		"id_region"						=>	"5",
			// 		"id_comuna"						=>	"78",
			// 		"id_localidad"					=>	"29",
			// 		"gl_direccion"					=>	"Av Playa Ancha 144",
			// 		"gl_latitud_direccion"			=>	NULL,
			// 		"gl_longitud_direccion"			=>	NULL,
			// 	),
			// 	array(
			// 		"id_region"						=>	"5",
			// 		"id_comuna"						=>	"78",
			// 		"id_localidad"					=>	"29",
			// 		"gl_direccion"					=>	"Río Frío 1802",
			// 		"gl_latitud_direccion"			=>	NULL,
			// 		"gl_longitud_direccion"			=>	NULL,
			// 	),
			// ),
			"id_region"								=>	5,
			"id_comuna"								=>	60,
			"id_localidad"							=>	4,
			"gl_direccion"							=>	"Cabildott 123",
			"gl_latitud_direccion"					=>	"-32.4258064",
			"gl_longitud_direccion"					=>	"-71.06616209999999",
			"bo_recetario_en_local"					=>	TRUE,
			"id_recetario_tipo"						=>	2,
			"bo_receta_1A"							=>	FALSE,
			"bo_receta_1B"							=>	TRUE,
			"bo_receta_2A"							=>	FALSE,
			"bo_receta_2B"							=>	TRUE,
			"bo_receta_2C"							=>	FALSE,
			"bo_receta_3A"							=>	TRUE,
			"bo_receta_3B"							=>	FALSE,
			"bo_receta_3C"							=>	TRUE,
			"bo_receta_3D"							=>	FALSE,
			"bo_receta_4"							=>	TRUE,
			"bo_receta_5"							=>	FALSE,
			"bo_horario_continuado"					=>	FALSE,
			"bo_ubicacion_impide_turno"				=>	TRUE,
			"arr_horario"							=>	//NULL,
			array(
				"lunes"			=>	array(
					"manana_inicio"		=>	"08:30",
					"manana_fin"		=>	"13:00",
					"tarde_inicio"		=>	"14:00",
					"tarde_fin"			=>	"18:00",
				),
				"martes"		=>	array(
					"manana_inicio"		=>	"08:30",
					"manana_fin"		=>	"13:00",
					"tarde_inicio"		=>	"14:00",
					"tarde_fin"			=>	"18:00",
				),
				"miercoles"		=>	array(
					"manana_inicio"		=>	"09:00",
					"manana_fin"		=>	"13:00",
					"tarde_inicio"		=>	"14:00",
					"tarde_fin"			=>	"18:00",
				),
				"jueves"		=>	array(
					"manana_inicio"		=>	"09:00",
					"manana_fin"		=>	"13:00",
					"tarde_inicio"		=>	"14:00",
					"tarde_fin"			=>	"18:00",
				),
				"viernes"		=>	array(
					"manana_inicio"		=>	"09:00",
					"manana_fin"		=>	"13:00",
					"tarde_inicio"		=>	"14:00",
					"tarde_fin"			=>	"18:00",
				),
				"sabado"		=>	array(
					"manana_inicio"		=>	"08:30",
					"manana_fin"		=>	"13:00",
					"tarde_inicio"		=>	"14:00",
					"tarde_fin"			=>	"16:00",
				),
				"domingo"		=>	array(
					"manana_inicio"		=>	"08:30",
					"manana_fin"		=>	"13:00",
					"tarde_inicio"		=>	"14:00",
					"tarde_fin"			=>	"16:00",
				),
				"festivos"		=>	array(
					"manana_inicio"		=>	"09:00",
					"manana_fin"		=>	"13:00",
					"tarde_inicio"		=>	"14:00",
					"tarde_fin"			=>	"16:00",
				),
			),
		);
		
		/* WS Metodo */
		$data	= array(
					'public_key'	=> $public_key,
					'hash'			=> $hash,
					'version_ws'	=> '1.0',
					'metodo'		=> 'registrarEstablecimiento',
					'Accept'		=> 'application/json',
					'appVersion'	=> '1.0.0',

					'datos'					=> json_encode($arr_datos),
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
		echo $respuesta;
	}else{
		echo 'Error al negociar';
	}
