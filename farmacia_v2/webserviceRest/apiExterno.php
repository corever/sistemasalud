<?php
	header('Access-Control-Allow-Origin: *');

	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Expose-Headers: Authorization");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Custom-header");
	header("Authorization: some data");

	date_default_timezone_set('America/Santiago');
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	// error_reporting(0);
	// ini_set('display_errors',			0);

	ini_set('post_max_size',			'256M');
	ini_set('upload_max_filesize',		'256M');
	ini_set('execution_time',			3600);
	ini_set('max_execution_time',		3600);
	ini_set('memory_limit',				-1);

	define('FUNCTION_FOLDER',			'functions');
	define('noti_PATH',					'apiExterno.php');
	define('SESSION_BASE',				'wsEstablecimientos');
	define('VERSION_ACTUAL_WS',			'1.0');
	define('VERSION_MAYOR_APP',			1);
	define('VERSION_WS',				'1.0.0');

	include_once('config.php');
	include_once('request.php');
	include_once('MySqli.php');
	include_once('include.php');
	include_once("DAO/DAOAcceso.php");
	include_once("DAO/DAOAccesoSistemaHistorial.php");
	include_once("DAO/DAOWebserviceToken.php");

	session_name("54f6241fc58e63db2d4356c754d2adb6616ef158");
	session_start();
	unset($_SESSION[SESSION_BASE]);

	//file_put_contents('php://stderr', PHP_EOL . print_r(apache_request_headers(), TRUE). PHP_EOL, FILE_APPEND);
	//die;
	
	$daoAcceso						=	new DAOAcceso();
	$daoAccesoSistemaHistorial		=	new DAOAccesoSistemaHistorial();
	$daoWSToken						=	new DAOWebserviceToken();
	$start_time 					=	microtime(true);
	$directorio 					=	opendir(FUNCTION_FOLDER);
	$status							=	false;
	$cod_error						=	1;
	$msg							=	'Solicitud sin los datos requeridos';
	$apache_msg						=	'Bad Request';
	$apache_cod						=	400;
	$cantidad						=	0;
	$resultado						=	array();
	$arr_permiso					=	array();
	$gl_ambiente					=	(ENVIROMENT == 'PROD')	?	'PROD'				:	'TEST';
	$gl_base						=	(!empty(SESSION_BASE))	?	SESSION_BASE 		:	'FiscalizadoresExterno';

	$request						=	new Request();
	$controlador					=	$request->getControlador();
	$methodo						=	$request->getMetodo();
	$parametros						=	$request->getParametros();
	$headers						=	apache_request_headers();
	$method							=	@$_SERVER['REQUEST_METHOD'];
	$authorization					=	'';
	$authorization_tipo				=	'';
	$authorization_data				=	'';
	$user							=	'';
	$pass							=	'';
	$hash							=	'';
	$token_ws						=	'';
	$data_json						=	json_decode(file_get_contents("php://input"));
	$bo_usuario_autorizado	= false;

	if(isset($headers['Authorization'])) {
		$authorization				=	trim($headers["Authorization"]);
		$matches					=	explode(' ', $authorization);
		$authorization_tipo			=	$matches[0];
		$authorization_data			=	$matches[1];

		if($authorization_tipo == 'Basic'){
			$b64_user_pass			=	base64_decode($authorization_data);
			$matches				=	explode(':', $b64_user_pass);
			$user					=	$matches[0];
			$pass					=	$matches[1];

			$noti_pass = $daoAcceso->getPassNegociar($gl_base, $gl_ambiente);

			if($user != $gl_base || ($user == $gl_base && $pass != $noti_pass)){
				header('HTTP/1.1 401 Unauthorized');
				$cod_error			=	'006';
				$msg				=	'Debe tener un convenio para poder utilizar el WebService. Para solicitar acceso, contacte con Mesa de Ayuda MINSAL';
				$apache_msg			=	'Unauthorized';
				$apache_cod			=	401;
			}else{
				$bo_usuario_autorizado	=	true;
			}
		}else if($authorization_tipo == 'Bearer'){
			$token_ws				=	$authorization_data;
			$bo_usuario_autorizado	=	true;
		}
	}


	$_SESSION[SESSION_BASE]['session_name']			=	session_name();
	$_SESSION[SESSION_BASE]['gl_ambiente']			=	$gl_ambiente;
	$_SESSION[SESSION_BASE]['id_usuario']			=	0;
	$_SESSION[SESSION_BASE]['user']					=	$user;
	// $_SESSION[SESSION_BASE]['pass']					=	$pass;
	$_SESSION[SESSION_BASE]['gl_rut']				=	0;
	$_SESSION[SESSION_BASE]['id_sistema']			=	0;
	$_SESSION[SESSION_BASE]['gl_origen']			=	'';
	$_SESSION[SESSION_BASE]['authorization']		=	$authorization;
	$_SESSION[SESSION_BASE]['authorization_tipo']	=	$authorization_tipo;
	$_SESSION[SESSION_BASE]['authorization_data']	=	$authorization_data;
	$_SESSION[SESSION_BASE]['headers']				=	$headers;
	$_SESSION[SESSION_BASE]['method']				=	$method;
	$_SESSION[SESSION_BASE]['POST']					=	$_POST;
	$_SESSION[SESSION_BASE]['GET']					=	$_GET;
	$_SESSION[SESSION_BASE]['REQUEST']				=	$_REQUEST;
	$_SESSION[SESSION_BASE]['respuesta']			=	NULL;
	$_SESSION[SESSION_BASE]['server_date']			=	date('d/m/Y');
	$_SESSION[SESSION_BASE]['server_time']			=	date('H:m');
	$_SESSION[SESSION_BASE]['start_time']			=	$start_time;
	$_SESSION[SESSION_BASE]['end_time']				=	0;
	$_SESSION[SESSION_BASE]['ejecucion_time']		=	0;
	$_SESSION[SESSION_BASE]['HTTP_CLIENT_IP']		=	(isset($_SERVER['HTTP_CLIENT_IP']))?$_SERVER['HTTP_CLIENT_IP']:NULL;
	$_SESSION[SESSION_BASE]['HTTP_X_FORWARDED']		=	(isset($_SERVER['HTTP_X_FORWARDED_FOR']))?$_SERVER['HTTP_X_FORWARDED_FOR']:NULL;
	$_SESSION[SESSION_BASE]['REMOTE_ADDR']			=	(isset($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:NULL;
	$_SESSION[SESSION_BASE]['url']['REQUEST_SCHEME']=	(isset($_SERVER['REQUEST_SCHEME']))?$_SERVER['REQUEST_SCHEME']:NULL;
	$_SESSION[SESSION_BASE]['url']['SERVER_NAME']	=	(isset($_SERVER['SERVER_NAME']))?$_SERVER['SERVER_NAME']:NULL;
	$_SESSION[SESSION_BASE]['url']['REQUEST_URI']	=	(isset($_SERVER['REQUEST_URI']))?$_SERVER['REQUEST_URI']:NULL;
	$_SESSION[SESSION_BASE]['url']['controlador']	=	$controlador;
	$_SESSION[SESSION_BASE]['url']['metodo']		=	$methodo;
	$_SESSION[SESSION_BASE]['url']['parametros']	=	$parametros;
	$_SESSION[SESSION_BASE]['data_json']			=	$data_json;
	$_SESSION[SESSION_BASE]['arrToken']				=	'';

	if($bo_usuario_autorizado){
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
		    header('HTTP/1.1 200 OK');
			$status		= true;
			$cod_error	= '000';
			$msg		= 'OK';
			$apache_msg	= 'OK';
			$apache_cod	= 200;
			$cantidad	= 0;
			$resultado	= array();
		}
		else if(!empty($_POST)){
			$public_key	=	(isset($_POST['public_key']))		?	$_POST['public_key']	:	FALSE;
			$metodo		=	(isset($_POST['metodo']))			?	$_POST['metodo']		:	FALSE;
			$postHash	=	(isset($_POST['hash']))				?	$_POST['hash']			:	FALSE;
			$content	=	(isset($_POST['Content-Type']))		?	$_POST['Content-Type']	:	'application/x-www-form-urlencoded';
			$retorno	=	(isset($_POST['Accept']))			?	$_POST['Accept']		:	'application/json';
			$version_ws	=	(isset($_POST['version_ws']))		?	$_POST['version_ws']	:	VERSION_ACTUAL_WS;
			
			if(!empty($public_key)){
				$arr_acceso	= $daoAcceso->getCredencialByPublickey($public_key, $gl_ambiente);

				if(!empty($arr_acceso)){
					$base			=	$arr_acceso['gl_base'];
					$private_key	=	$arr_acceso['gl_key_private'];
					$json_permisos	=	json_decode($arr_acceso['json_permisos'],true);

					foreach($json_permisos as $key=>$valor){
						if($metodo == $valor['metodo']){
							$arr_permiso	=	$valor;
						}
					}
					
					$bo_hash_valido		=	true;
					$bo_token_caducado	=	false;

					if($metodo != 'negociar'){
						$arrToken		=	$daoWSToken->getByToken($token_ws);
						if(!empty($arrToken)){
							$_SESSION[SESSION_BASE]['arrToken']	= $arrToken['gl_token'];
							if($arrToken['bo_utilizado'] == 1){
								$bo_token_caducado	=	true;
							}else{
								$bo_utilizado		=	true;
								$daoWSToken->updateEstado($token_ws,$bo_utilizado);
							}
						}else{
							$bo_hash_valido = false;
						}
					}else{
						$bo_hash_valido = true;
					}

					$hash									=	getHash($base,$public_key,$private_key,$token_ws);

					$_SESSION[SESSION_BASE]['id_sistema']	=	$arr_acceso['id_sistema'];
					$_SESSION[SESSION_BASE]['gl_origen']	=	$base;

					if(!$bo_hash_valido){
						header('HTTP/1.1 401 Unauthorized');
						$cod_error		=	'003';
						$msg			=	'Hash no es valido';
						$apache_msg		=	'Unauthorized';
						$apache_cod		=	401;
					}
					elseif($bo_token_caducado){
						header('HTTP/1.1 401 Unauthorized');
						$cod_error		=	'007';
						$msg			=	'Credencial Caducada';
						$apache_msg		=	'Unauthorized';
						$apache_cod		=	401;
					}
					elseif(hash_equals($postHash,$hash)){

						if(!empty($arr_permiso)) {

							$existe_metodo	=	false;
							while($archivo	=	readdir($directorio)){
								$ruta = FUNCTION_FOLDER."/".$archivo;
								if (is_file($ruta) AND $metodo.'.php' == $archivo){
									$existe_metodo	=	true;
									$php_metodo		=	$ruta;
								}
							}

							if($existe_metodo){
								$cantidad_llamadas_mes	=	$daoAccesoSistemaHistorial->llamadasMetodoPorMes($metodo,$arr_acceso['id_sistema']);//$hash);
								$cantidad_llamadas_dia	=	$daoAccesoSistemaHistorial->llamadasMetodoPorDia($metodo,$arr_acceso['id_sistema']);//$hash);
								$cantidad_llamadas_hora	=	$daoAccesoSistemaHistorial->llamadasMetodoPorHora($metodo,$arr_acceso['id_sistema']);//$hash);

								$bo_fecha_correcta = validarFechaCorrecta($arr_permiso["fc_vigencia"]);
								if($bo_fecha_correcta){
									$date_unix	=	strtotime(validar($arr_permiso["fc_vigencia"]." 23:59:59", 'date'));
								}else{
									$date_unix	=	0;
								}

								if(!empty($arr_permiso) && isset($arr_permiso["estado"]) &&
									$arr_permiso["estado"] != 1) {
									header("HTTP/1.1 403 Forbidden");
									$cod_error	= '012';
									$msg		= 'Método No Vigente';
									$apache_msg	= 'Forbidden';
									$apache_cod	= 403;
								}
								elseif(!empty($arr_permiso) && !empty($arr_permiso["fc_vigencia"]) &&
									$bo_fecha_correcta && ($date_unix < time()) ) {
									header("HTTP/1.1 403 Forbidden");
									$cod_error	= '012';
									$msg		= 'Método No Vigente';
									$apache_msg	= 'Forbidden';
									$apache_cod	= 403;
								}
								elseif(!empty($arr_permiso) && !empty($arr_permiso["limite_mes"]) &&
									$arr_permiso["limite_mes"] > 0 &&
									$cantidad_llamadas_dia>=$arr_permiso["limite_mes"]) {
									header("HTTP/1.1 429 Too Many Requests");
									$cod_error	= '016';
									$msg		= 'Se sobrepaso el limite mensual de solicitudes';
									$apache_msg	= 'Too Many Requests';
									$apache_cod	= 429;
								}
								elseif(!empty($arr_permiso) && !empty($arr_permiso["limite_dia"]) &&
									$arr_permiso["limite_dia"] > 0 &&
									$cantidad_llamadas_dia>=$arr_permiso["limite_dia"]) {
									header("HTTP/1.1 429 Too Many Requests");
									$cod_error	= '014';
									$msg		= 'Se sobrepaso el limite diario de solicitudes';
									$apache_msg	= 'Too Many Requests';
									$apache_cod	= 429;
								}
								elseif(!empty($arr_permiso) && !empty($arr_permiso["limite_hora"]) &&
									$arr_permiso["limite_hora"] > 0 &&
									$cantidad_llamadas_hora>=$arr_permiso["limite_hora"]) {
									header("HTTP/1.1 429 Too Many Requests");
									$cod_error	= '015';
									$msg		= 'Se sobrepaso el limite por hora de solicitudes';
									$apache_msg	= 'Too Many Requests';
									$apache_cod	= 429;
								}
								else{
									include_once($php_metodo);
								}
							}else{
								header("HTTP/1.1 404 Not Found");
								$cod_error	= '005';
								$msg		= 'Método  solicitado No disponible';
								$apache_msg	= 'Not Found';
								$apache_cod	= 404;
							}

						}else{
							header("HTTP/1.1 404 Not Found");
							$cod_error	= '013';
							$msg		= 'No tiene Permisos para el Método solicitado';
							$apache_msg	= 'Unauthorized';
							$apache_cod	= 401;
						}
					}else{
						header('HTTP/1.1 401 Unauthorized');
						$cod_error	= '003';
						$msg		= 'Hash no es valido';
						$apache_msg	= 'Unauthorized';
						$apache_cod	= 401;
					}
				}else{
					header('HTTP/1.1 401 Unauthorized');
					$cod_error	= '006';
					$msg		= 'Credencial incorrecta. Favor revise que está utilizando las correctas para el Ambiente '.$gl_ambiente;
					$apache_msg	= 'Unauthorized';
					$apache_cod	= 401;
				}
			}else{
				header('HTTP/1.1 401 Unauthorized');
				$cod_error	= '006';
				$msg		= 'Debe tener un convenio para poder utilizar el WebService. Para solicitar acceso, contacte con Mesa de Ayuda MINSAL';
				$apache_msg	= 'Unauthorized';
				$apache_cod	= 401;
			}
		}else{
			header('HTTP/1.1 400 Bad Request');
		}
	}

	header('Content-type: application/json; charset=utf-8');
	//$resultado	= $hash;
	$respuesta	= array(
					'bo_estado'			=> $status,
					'gl_mensaje'		=> $msg,
					'gl_codigo_error'	=> $cod_error,
					'gl_http_mensaje'	=> $apache_msg,
					'nr_http_codigo'	=> $apache_cod,
					'nr_cantidad'		=> $cantidad,
					'arr_resultado'		=> $resultado,
				);
	$response	= $respuesta;
	//unset($response['arr_resultado']);

	$_SESSION[SESSION_BASE]['end_time']			= microtime(true);
	$_SESSION[SESSION_BASE]['ejecucion_time']	= microtime(true) - $start_time;
	$_SESSION[SESSION_BASE]['respuesta']		= $response;

	$daoAccesoSistemaHistorial->insAccesoHistorial($_SESSION[SESSION_BASE]);

	$daoAcceso->cerrar_conexion();
	$daoAccesoSistemaHistorial->cerrar_conexion();
	
	//echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	echo json_encode($respuesta);
?>