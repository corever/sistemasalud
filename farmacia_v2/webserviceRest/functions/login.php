<?php

	include_once("DAO/DAOUsuario.php");
	include_once("DAO/DAOErrorLog.php");
	include_once("DAO/DAOMensajeUsuario.php");

	$conn =  new MySQL();
	$daoUsuario = new DAOUsuario($conn);
	$daoErrorLog = new DAOErrorLog($conn);

	$service_name = "loginRequest";
	$service_name_response = "loginResponse";


	$rut 			   = null;
	$password 		   = null;
	$region_usuario    = null;
	$token_dispositivo = null;
	$appVersion		   = null;
	$bo_usuario_midas  = false;

	$rut 			   = (!empty($_REQUEST['gl_rut']))		? $_REQUEST['gl_rut']		: null;
	$password 		   = (!empty($_REQUEST['gl_clave']))	? $_REQUEST['gl_clave']		: null;
	$region_usuario	   = (!empty($_REQUEST['region']))		? $_REQUEST['region']		: null;
	$appVersion		   = (!empty($_REQUEST['appVersion']))  ? $_REQUEST['appVersion'] 	: null;
	$token_dispositivo = (!empty($_REQUEST['token_dispositivo']))	? $_REQUEST['token_dispositivo']	: null;

	if(empty($rut)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error	= '100';
		$msg		= 'Falta parámetro requerido: RUT';
		$apache_msg	= 'Bad Request';
		$apache_cod	= 400;	
	}
	elseif(!validaRut($rut)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error	= '101';
		$msg		= 'Formato RUT incorrecto';
		$apache_msg	= 'Bad Request';
		$apache_cod	= 400;
	}
	elseif(empty($password)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error	= '010';
		$msg		= 'Falta parámetro requerido: gl_clave';
		$apache_msg	= 'Bad Request';
		$apache_cod	= 400;
	}
	/*elseif(empty($region_usuario)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error	= '010';
		$msg		= 'Falta parámetro requerido: region';
		$apache_msg	= 'Bad Request';
		$apache_cod	= 400;
	}*/
	elseif(empty($appVersion)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error	= '010';
		$msg		= 'Falta parámetro requerido: appVersion';
		$apache_msg	= 'Bad Request';
		$apache_cod	= 400;
	}
	elseif(empty($token_dispositivo)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error	= '010';
		$msg		= 'Falta parámetro requerido: token_dispositivo';
		$apache_msg	= 'Bad Request';
		$apache_cod	= 400;
	}
	elseif($retorno == 'application/json') {
		//$daoErrorLog->setLogAuditoria($_REQUEST, $rut, VERSION_WS, $appVersion, $token_dispositivo, 1, $service_name);
		
		list($version_mayor, $version_menor, $version_micro) = explode('.', $appVersion);
		
		if (($version_mayor<VERSION_MAYOR_APP)) {
				header("HTTP/1.1 404 Not Found");
				$cod_error	= '901';
				$msg		= 'Versión del Servicio obsoleta';
				$apache_msg	= 'Not Found';
				$apache_cod	= 404;
        }
		else
		{
			/**
			 * @todo hacer funcion que valide si la versión está proxima a ser actualizada.
			 * en tal caso, crear un nuevo mensaje al usuario:
			 * $daoMensajeUsuario = new DAOMensajeUsuario($conn);
			 */
			
			$params = array();
			$params["rut"] = $rut;//'24995712-7';
			$params["password"] = $password;//'3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2';
			$params["region_usuario"] = $region_usuario;

			$usuario = $daoUsuario->getLogin($params);

			if(!empty($usuario) && $daoUsuario->validarFiscalizador($usuario['id_usuario'])){
				//file_put_contents('php://stderr', PHP_EOL . print_r($usuario, TRUE). PHP_EOL, FILE_APPEND);
				//file_put_contents('php://stderr', PHP_EOL . print_r($usuario["gl_password"], TRUE). PHP_EOL, FILE_APPEND);
				//file_put_contents('php://stderr', PHP_EOL . print_r($params["password"], TRUE). PHP_EOL, FILE_APPEND);
				if($usuario["gl_password"] == $params["password"]){
					$status		= true;
					$cod_error	= '000';
					$msg		= 'OK';
					$apache_msg	= 'OK';
					$apache_cod	= 200;
					$cantidad	= 1;//count($arr_comunas);
					$resultado	= array(
									"token_usuario" => $usuario["gl_token"],
									"gl_email" => $usuario["gl_email"],
									"gl_nombres" => $usuario["gl_nombres"],
									"gl_apellidos" => $usuario["gl_apellidos"]
								);
				}else{
					header("HTTP/1.1 401 Unauthorized");
					$cod_error	= '006';
					$msg		= 'Credencial Incorrecta';
					$apache_msg	= 'Unauthorized';
					$apache_cod	= 401;
				}
			}
			else{
				try{
					/**
					 * @todo Un usuario que está registrado en MIDAS podría logear, pero nada más.
					 * ya que no se puede validar si es fiscalizador, ni encontrar las asignaciones
					 * asociadas a ese usuario.
					 */
		        	$usuario = $daoUsuario->getUsuarioLoginMIDAS($rut,$password);
		        	$bo_usuario_midas = true;
		        	if(!is_null($usuario)){
						if($usuario["gl_password"] == $params["password"]){
							$status		= true;
							$cod_error	= '000';
							$msg		= 'OK';
							$apache_msg	= 'OK';
							$apache_cod	= 200;
							$cantidad	= 1;//count($arr_comunas);
							$resultado	= array(
											"token_usuario" => $usuario["token"],
											"gl_email" => $usuario["email"],
											"gl_nombres" => $usuario['nombres'],
											"gl_apellidos" => $usuario['apellidos'],
										);
						}else{
							header("HTTP/1.1 401 Unauthorized");
							$cod_error	= '006';
							$msg		= 'Credencial Incorrecta';
							$apache_msg	= 'Unauthorized';
							$apache_cod	= 401;
						}
		        	}else{
			        	header("HTTP/1.1 401 Unauthorized");
						$cod_error	= '006';
						$msg		= 'Credencial Incorrecta';
						$apache_msg	= 'Unauthorized';
						$apache_cod	= 401;
		        	}
	        	}catch (Exception $e){
	        		header("HTTP/1.1 401 Unauthorized");
					$cod_error	= '006';
					$msg		= 'Credencial Incorrecta';
					$apache_msg	= 'Unauthorized';
					$apache_cod	= 401;
	        	}
			}

			if(!empty($usuario)){
				$daoUsuario->validarDispositivo($usuario['id_usuario'], $token_dispositivo, $appVersion, $rut, $bo_usuario_midas);
			}

		}
		
	}else{
		header("HTTP/1.1 406 Not Acceptable");
		$cod_error	= '004';
		$msg		= 'Formato de Retorno No Implementado';
		$apache_msg	= 'Not Acceptable';
		$apache_cod	= 406;
	}

	if($apache_cod != 200){
		$error_params = array(
				"cod_error" => $cod_error,
				"msg" => $msg,
				"apache_msg" => $apache_msg,
				"apache_cod" => $apache_cod,
			);
		file_put_contents('php://stderr', PHP_EOL . print_r($error_params, TRUE). PHP_EOL, FILE_APPEND);
		//$daoErrorLog->setLogAuditoria($error_params, $rut, VERSION_WS, $appVersion, $token_dispositivo, 0, $service_name_response);
	}
	$conn->cerrar_conexion();