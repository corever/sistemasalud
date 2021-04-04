<?php

	include_once("DAO/DAOUsuario.php");
	include_once("DAO/DAOErrorLog.php");
	include_once("DAO/DAOHistorial.php");
	include_once("DAO/DAOVisita.php");
	include_once("DAO/DAOAsignacionOAL.php");
	include_once("DAO/DAOOALProgramacion.php");
	include_once("DAO/DAOHistorialProgramacion.php");


	$conn 						=	new MySQL();
	$daoUsuario 				=	new DAOUsuario($conn);
	$daoErrorLog 				=	new DAOErrorLog($conn);
	$daoHistorial 				=	new DAOHistorial($conn);
	$daoVisita		 			=	new DAOVisita($conn);
	$daoAsignacion	 			=	new DAOAsignacionOAL($conn);
	$daoOalProgramacion 		=	new DAOOALProgramacion($conn);
	$daoHistorialProgamacion	=	new DAOHistorialProgramacion();
	
	$service_name				=	"registrarVisitaValidadaRequest";
	$service_name_response		=	"registrarVisitaValidadaResponse";

	$rut						=	NULL;
	$password					=	NULL;
	$region_usuario				=	NULL;
	$token_visita				=	NULL;
	$token_dispositivo			=	NULL;
	$appVersion					=	NULL;
	$version_menor				=	NULL;
	$version_micro				=	NULL;
	$version_mayor				=	NULL;

	$datos						=	NULL;
	$id_visita					=	NULL;
	$id_evento_tipo				=	DAOHistorial::TIPO_EVENTO_VISITA_SIN_ESTADO;
	$historial_descripcion		=	"Hubo un problema al recuperar el tipo de evento.";
	$aux_cod_error				=	'999';
	$aux_msg					=	'Error desconocido';

	$rut						=	(!empty($_REQUEST['gl_rut']))				?	$_REQUEST['gl_rut']					:	NULL;
	$password					=	(!empty($_REQUEST['gl_clave']))				?	$_REQUEST['gl_clave']				:	NULL;
	$region_usuario				=	(!empty($_REQUEST['region']))				?	$_REQUEST['region']					:	NULL;
	$appVersion					=	(isset($_REQUEST["datos"]['appVersion']))	?	$_REQUEST["datos"]['appVersion']	:	NULL;
	$token_visita				=	(!empty($_REQUEST['token_visita']))			?	$_REQUEST['token_visita']			:	NULL;
	$token_dispositivo			=	(!empty($_REQUEST['token_dispositivo']))	?	$_REQUEST['token_dispositivo']		:	NULL;
	$datos_visita				=	(isset($_REQUEST["datos"]['datos_investigacion']))	?	$_REQUEST["datos"]['datos_investigacion']	:	NULL;

	if(empty($rut)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error				=	'100';
		$msg					=	'Falta parámetro requerido: RUT';
		$apache_msg				=	'Bad Request';
		$apache_cod				=	400;	
	}
	elseif(!validaRut($rut)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error				=	'101';
		$msg					=	'Formato RUT incorrecto';
		$apache_msg				=	'Bad Request';
		$apache_cod				=	400;
	}
	elseif(empty($appVersion)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error				=	'010';
		$msg					=	'Falta parámetro requerido: appVersion';
		$apache_msg				=	'Bad Request';
		$apache_cod				=	400;
	}
	elseif(empty($token_visita)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error				=	'010';
		$msg					=	'Falta parámetro requerido: token_visita';
		$apache_msg				=	'Bad Request';
		$apache_cod				=	400;
	}
	// elseif(empty($token_dispositivo)){
	// 	header("HTTP/1.1 400 Bad Request");
	// 	$cod_error				=	'010';
	// 	$msg					=	'Falta parámetro requerido: token_dispositivo';
	// 	$apache_msg				=	'Bad Request';
	// 	$apache_cod				=	400;
	// }
	elseif($retorno == 'application/json') {
		list($version_mayor, $version_menor, $version_micro) = explode('.', $appVersion);
		
		if (($version_mayor<VERSION_MAYOR_APP)) {
				header("HTTP/1.1 404 Not Found");
				$cod_error		=	'901';
				$msg			=	'Versión del Servicio obsoleta';
				$apache_msg		=	'Not Found';
				$apache_cod		=	404;
        }
		else
		{			
			$params						=	array();
			$params["rut"]				=	$rut;//'24995712-7';
			//$params["password"]		=	$password;
			$params["region_usuario"]	=	$region_usuario;
			$params["rol"]				=	30;
			$usuario					=	$daoUsuario->getLogin($params);

			//formateo los datos de la visita
			$datos						=	json_decode(json_decode($datos_visita,TRUE),TRUE);

			//REGISTRAR LOG DE AUDITORIA (PARA RESPALDAR INFORMACIÓN ENTRANTE)
			$log_params = array(
					'json_datos'	 		=>	$datos, 
					'id_asignacion'			=>	(!empty($datos))?$datos['id_asignacion']:'',
					'id_visita'				=>	$id_visita,
					'gl_rut' 				=>	$rut, 
					'id_usuario' 			=>	(!empty($usuario))?$usuario["id"]:'', 
					'gl_version_ws' 		=>	VERSION_WS, 
					'gl_version_app' 		=>	$appVersion, 
					'gl_token_dispositivo' 	=>	$token_dispositivo,
					'bo_ws_success' 		=>	true, 
					'gl_service_name' 		=>	$service_name
				);
			$daoErrorLog->setLogAuditoria($log_params);
			
			if(!empty($usuario)){
				if(isset($datos["id_asignacion"]) && !empty($datos["id_asignacion"])){

					$_conexion							=	$conn->conexion;
					//se desactiva autocommit
					mysqli_autocommit($_conexion, FALSE);
					//mysqli_begin_transaction($_conexion);
					$_conexion->begin_transaction();

					try{
						$id_asignacion					=	$datos["id_asignacion"];
						
						if($id_asignacion){

							$visita						=	$daoVisita->getByIdAsignacion($id_asignacion);

							if($visita){
								$id_visita				=	$visita["id_visita"];
								$marca_disponible		=	$daoAsignacion->marcarDisponible($id_asignacion);
								$actualiza_asignacion	=	$daoAsignacion->cambiarEstadoById($id_asignacion,	DAOAsignacionOAL::ESTADO_ASIGNACION_VISITA_INFORMADA);
								
								$id_evento_tipo			=	DAOHistorial::TIPO_EVENTO_VISITA_CONFIRMADA;
								$historial_descripcion	=	"Visita Confirmada desde Mis Fiscalizaciones";
							}else{
								header("HTTP/1.1 400 Bad Request");
								$cod_error				=	'100';
								$msg					=	'Visita no encontrada';
								$apache_msg				=	'Bad Request';
								$apache_cod				=	400;
							}

						}
						
						//COMITEO TODAS LAS QUERYS PROCESADAS
						mysqli_commit($_conexion);
						//ACTIVO NUEVAMENTE EL AUTOCOMMIT
						mysqli_autocommit($_conexion, TRUE);
						
						/**
						 * Verifico si existió alguna query con error durante la ejecución.
						 * También valido que exista el id que registró los parametros de la visita (o devolución)
						 */
						$lastCallError = $conn->lastCallError();

						if($lastCallError == 0 && isset($id_visita) && $id_visita > 0){
							$status				=	TRUE;
							$cod_error			=	'000';
							$msg				=	'OK';
							$apache_msg			=	'OK';
							$apache_cod			=	200;
							$cantidad			=	1;
							$resultado			=	array("id_visita" => $id_visita);

							$datos_historial	=	array(
								"id_asignacion" 	=>	$datos['id_asignacion'],
								"id_evento_tipo" 	=>	$id_evento_tipo,
								"gl_descripcion" 	=>	$historial_descripcion,
								"id_usuario_crea" 	=>	$usuario["id"],
							);
							$resp				=	$daoHistorial->insert($datos_historial);
							actualizarEstadoProgramacion($daoHistorialProgamacion,$daoOalProgramacion,$daoAsignacion,$datos['id_asignacion'],$usuario);

							/*	Guardar PDF Resumen Investigacion	*/
							// if($id_evento_tipo	==	DAOHistorial::TIPO_EVENTO_VISITA_REALIZADA){
								// generarPdfFiscalizacion($token_visita);
							// }
							
						}else{
							if($lastCallError == MySQL::ERROR_SYNTAX){
								$cod_error	= '802';
								$msg		= 'Error en procesamiento de datos - 1064';
							}else{
								$cod_error	= '999';
								$msg		= 'Error desconocido - '.$lastCallError;
							}
							throw new Exception(MySQL::MYSQL_EXCEPTION);
						}
						
					}catch(Exception $e){
						file_put_contents('php://stderr', PHP_EOL . print_r("ERROR INESPERADO - EJECUTANDO ROLLBACK", TRUE). PHP_EOL, FILE_APPEND);
						file_put_contents('php://stderr', PHP_EOL . print_r($e->getMessage(), TRUE). PHP_EOL, FILE_APPEND);

						//Revertir
						mysqli_rollback($_conexion);
						
						//Reactivar autocommit
						mysqli_autocommit($_conexion, true);

						//Guardar Auditoria de mensaje de error
						$log_params = array(
								'json_datos'	 		=> $e->getMessage(), 
								'id_asignacion'			=> (!empty($datos))?$datos['id_asignacion']:'',
								'id_visita'				=> $id_visita,
								'gl_rut' 				=> $rut, 
								'id_usuario' 			=> $usuario["id"], 
								'gl_version_ws' 		=> VERSION_WS, 
								'gl_version_app' 		=> $appVersion, 
								'gl_token_dispositivo' 	=> $token_dispositivo,
								'bo_ws_success' 		=> false, 
								'gl_service_name' 		=> $service_name_response
							);
						$daoErrorLog->setLogAuditoria($log_params);

						header("HTTP/1.1 500 Internal Server Error");
						if($e->getMessage() != MySQL::MYSQL_EXCEPTION){
							$cod_error	= '999';
							$msg		= 'Error desconocido';
						}
						$apache_msg	= 'Internal Server Error';
						$apache_cod	= 500;
					}

					$datos_response = array(
							"status" 	 => $status,
							"cod_error"  => $cod_error,
							"msg" 		 => $msg,
							"apache_msg" => $apache_msg,
							"apache_cod" => $apache_cod,
							"cantidad" 	 => $cantidad,
							"resultado"  => $resultado,
						);

					//Guardo auditoría de respuesta enviada a la tablet:
					$log_params = array(
							'json_datos'	 		=> $datos_response, 
							'id_asignacion'			=> (!empty($datos))?$datos['id_asignacion']:'',
							'id_visita'				=> $id_visita,
							'gl_rut' 				=> $rut, 
							'id_usuario' 			=> $usuario["id"], 
							'gl_version_ws' 		=> VERSION_WS, 
							'gl_version_app' 		=> $appVersion, 
							'gl_token_dispositivo' 	=> $token_dispositivo,
							'bo_ws_success' 		=> (int)$status, 
							'gl_service_name' 		=> $service_name_response
						);
					$daoErrorLog->setLogAuditoria($log_params);
				}else{
					header("HTTP/1.1 400 Bad Request");
					$cod_error				=	'100';
					$msg					=	'Falta parámetro requerido: ID Asignacion';
					$apache_msg				=	'Bad Request';
					$apache_cod				=	400;
				}
			}else{
				header("HTTP/1.1 401 Unauthorized");
				$cod_error	= '006';
				$msg		= 'Credencial Incorrecta';
				$apache_msg	= 'Unauthorized';
				$apache_cod	= 401;
			}
		}
		
	}else{
		header("HTTP/1.1 406 Not Acceptable");
		$cod_error	= '004';
		$msg		= 'Formato de Retorno No Implementado';
		$apache_msg	= 'Not Acceptable';
		$apache_cod	= 406;
	}

	/**
	 * Si ocurrió un error, registro la auditoría que no se ha registrado hasta el momento.
	 */
	if($apache_cod != 200){
		$error_params = array(
				"cod_error" => $cod_error,
				"msg" => $msg,
				"apache_msg" => $apache_msg,
				"apache_cod" => $apache_cod,
			);

		//Imprimo por consola de apache los errores para hacerlo facilmente visible.
		file_put_contents('php://stderr', PHP_EOL . print_r($error_params, TRUE). PHP_EOL, FILE_APPEND);
		$log_params = array(
				'json_datos'	 		=> $error_params, 
				'id_asignacion'			=> (!empty($datos))?$datos['id_asignacion']:'',
				'id_visita'				=> $id_visita,
				'gl_rut' 				=> $rut, 
				'id_usuario' 			=> $usuario["id"], 
				'gl_version_ws' 		=> VERSION_WS, 
				'gl_version_app' 		=> $appVersion, 
				'gl_token_dispositivo' 	=> $token_dispositivo,
				'bo_ws_success' 		=> false, 
				'gl_service_name' 		=> $service_name_response
			);
		$daoErrorLog->setLogAuditoria($log_params);
	}
	$conn->cerrar_conexion();

function actualizarEstadoProgramacion($daoHistorialProgamacion,$daoOalProgramacion,$daoAsignacion,$id_asignacion,$usuario){

	$asignacion									=	$daoAsignacion->getById($id_asignacion);
	$id_evento_tipo								=	0;
	$historial_descripcion						=	"";

	if(!empty($asignacion)){
		$id_programacion						=	$asignacion['id_programacion'];
		if(!is_null($id_programacion)){
			$conteo								=	$daoAsignacion->getConteo($id_programacion);
			if(!empty($conteo)){
				$sin_asignar					=	$conteo['sin_asignar'];
				$asignadas						=	$conteo['asignadas'];
				$finalizadas					=	$conteo['finalizadas'];
				$total							=	$conteo['total'];
				if($sin_asignar == 0 && $asignadas == 0 && $finalizadas == $total){
					$resp						=	$daoOalProgramacion->cambiarEstado($id_programacion, DAOOALProgramacion::ESTADO_PROGRAMACION_CERRADA);
					$id_evento_tipo				=	DAOHistorialProgramacion::TIPO_EVENTO_PROGRAMACION_CERRADA;
					if($total > 1){
						$historial_descripcion	=	"Programación Completada (".$total." Fiscalizaciones realizadas).";
					}else{
						$historial_descripcion	=	"Programación Completada (".$total." Fiscalización realizada).";
					}
				}elseif($finalizadas < $total && $conteo['id_estado'] != DAOOALProgramacion::ESTADO_PROGRAMACION_ESPERA_FISCALIZACIONES){
					$resp						=	$daoOalProgramacion->cambiarEstado($id_programacion, DAOOALProgramacion::ESTADO_PROGRAMACION_ESPERA_FISCALIZACIONES);
					$id_evento_tipo				=	DAOHistorialProgramacion::TIPO_EVENTO_PROGRAMACION_ESPERA_FISCALIZACIONES;
					$historial_descripcion		=	"Programación En Espera de Fiscalizaciones a ser realizadas.";
				}
				if($resp && $id_evento_tipo > 0){
					$datos_historial			=	array(
						"id_programacion" 	=>	$id_programacion,
						"id_evento_tipo" 	=>	$id_evento_tipo,
						"gl_descripcion" 	=>	$historial_descripcion,
						"id_usuario_crea" 	=>	$usuario["id"],
					);
					
					$hist	=	$daoHistorialProgamacion->insertarNuevo($datos_historial);
				}
			}
		}
	}
}