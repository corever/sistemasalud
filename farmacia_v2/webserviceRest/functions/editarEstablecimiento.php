<?php

	include_once("DAO/DAOUsuario.php");
	include_once("DAO/DAOErrorLog.php");
	include_once("DAO/DAOHistorial.php");
	include_once("DAO/DAOHistorialLocal.php");
	include_once("DAO/DAOLocal.php");
	include_once("DAO/DAOLocalTipo.php");
	include_once("DAO/DAOLocalHorario.php");
	include_once("DAO/DAOLocalRecetarioTipo.php");
	include_once("DAO/DAOFarmacia.php");
	include_once("DAO/DAOCodigoRegion.php");
	
	include_once("DAO/direccion/DAODireccionComuna.php");
	include_once("DAO/direccion/DAODireccionRegion.php");
	include_once("DAO/direccion/DAODireccionLocalidad.php");

	$conn 						=	new MySQL();
	$daoUsuario 				=	new DAOUsuario($conn);
	$daoErrorLog 				=	new DAOErrorLog($conn);
	$daoHistorial 				=	new DAOHistorial($conn);

	$daoLocal					=	new DAOLocal($conn);
	$daoLocalTipo				=	new DAOLocalTipo($conn);
	$daoLocalHorario			=	new DAOLocalHorario($conn);
	$daoHistorialLocal			=	new DAOHistorialLocal($conn);
	$daoLocalRecetarioTipo		=	new DAOLocalRecetarioTipo($conn);
	$daoFarmacia				=	new DAOFarmacia($conn);
	$daoCodigoRegion			=	new DAOCodigoRegion($conn);

	$daoComuna					=	new DAODireccionComuna($conn);
	$daoRegion					=	new DAODireccionRegion($conn);
	$daoLocalidad				=	new DAODireccionLocalidad($conn);
	
	$service_name				=	"editarEstablecimientoRequest";
	$service_name_response		=	"editarEstablecimientoResponse";

	// $rut						=	NULL;
	// $password					=	NULL;
	// $region_usuario				=	NULL;
	$appVersion					=	NULL;
	$version_menor				=	NULL;
	$version_micro				=	NULL;
	$version_mayor				=	NULL;

	$datos						=	NULL;
	$id_establecimiento			=	NULL;
	$id_evento_tipo				=	DAOHistorial::TIPO_EVENTO_VISITA_SIN_ESTADO;
	$historial_descripcion		=	"Hubo un problema al recuperar el tipo de evento.";
	$aux_cod_error				=	'999';
	$aux_msg					=	'Error desconocido';
	$_gl_mensaje				=	"";

	// $rut						=	(!empty($_REQUEST['gl_rut']))				?	$_REQUEST['gl_rut']					:	NULL;
	// $password					=	(!empty($_REQUEST['gl_clave']))				?	$_REQUEST['gl_clave']				:	NULL;
	// $region_usuario				=	(!empty($_REQUEST['region']))				?	$_REQUEST['region']					:	NULL;
	$appVersion					=	(isset($_REQUEST['appVersion']))			?	$_REQUEST['appVersion']			:	NULL;
	$datos						=	(isset($_REQUEST["datos"]))					?	$_REQUEST["datos"]				:	NULL;
	$gl_codigo					=	(isset($_REQUEST["gl_codigo"]))				?	$_REQUEST["gl_codigo"]			:	NULL;

	if(empty($gl_codigo)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error				=	'100';
		$msg					=	'Falta parámetro requerido: Codigo (Establecimiento).';
		$apache_msg				=	'Bad Request';
		$apache_cod				=	400;	
	}
	/*
	elseif(!validaRut($rut)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error				=	'101';
		$msg					=	'Formato RUT incorrecto';
		$apache_msg				=	'Bad Request';
		$apache_cod				=	400;
	}
	*/
	elseif(empty($appVersion)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error				=	'010';
		$msg					=	'Falta parámetro requerido: appVersion';
		$apache_msg				=	'Bad Request';
		$apache_cod				=	400;
	}
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
			
			$establecimento				=	$daoLocal->getByCodigo($gl_codigo);
			//formateo los datos de la visita
			$datos						=	json_decode($datos,TRUE);

			//REGISTRAR LOG DE AUDITORIA (PARA RESPALDAR INFORMACIÓN ENTRANTE)
			$log_params = array(
					'json_datos'	 		=>	$datos, 
					'gl_rut' 				=>	NULL,//$rut, 
					'id_usuario' 			=>	NULL,//(!empty($usuario))?$usuario["id"]:'', 
					'gl_version_ws' 		=>	VERSION_WS, 
					'gl_version_app' 		=>	$appVersion, 
					'gl_token_dispositivo' 	=>	NULL,//$token_dispositivo,
					'bo_ws_success' 		=>	true, 
					'gl_service_name' 		=>	$service_name
				);
			$daoErrorLog->setLogAuditoria($log_params);
			
			// if(!empty($usuario)){
			if(!empty($establecimento)){
				if(!empty($datos)){
					$_conexion										=	$conn->conexion;
					//se desactiva autocommit
					mysqli_autocommit($_conexion, FALSE);
					//mysqli_begin_transaction($_conexion);
					$_conexion->begin_transaction();

					try{
						$id_establecimiento							=	$establecimento["local_id"];
						$resp_parametros							=	validar_datos($datos, $establecimento, $daoLocalRecetarioTipo, $daoFarmacia, $daoCodigoRegion, $daoRegion, $daoComuna, $daoLocalidad, $daoLocalTipo);

						if($resp_parametros["correcto"]){
							$arr_update								=	$resp_parametros["arr_cambios"];
							$arr_limpiar							=	$resp_parametros["arr_limpiar"];
							$arr_gl_cambios							=	$resp_parametros["arr_gl_cambios"];
							$arr_horario							=	isset($resp_parametros["arr_horario"])	?	$resp_parametros["arr_horario"]	:	NULL;

							if(!empty($arr_update)){
								$bo_actualiza						=	$daoLocal->update($arr_update,$id_establecimiento);
								if($bo_actualiza){
									// if(!empty($arr_limpiar)){
									// 	$daoLocal->update($arr_limpiar,$id_establecimiento);
									// }
									// if(!empty($arr_horario)){
									// 	$arr_horario["id_local"]	=	$id_establecimiento;
									// 	$daoLocalHorario->inhabilitarAnteriores($id_establecimiento);
									// 	$id_horario					=	$daoLocalHorario->insert($arr_horario);
									// }
									$_gl_mensaje					=	"Establecimiento ".$gl_codigo." Editado Correctamente.";
								}
							}
							if(!empty($arr_horario)){
								$arr_horario["id_local"]			=	$id_establecimiento;
								$daoLocalHorario->inhabilitarAnteriores($id_establecimiento);
								$id_horario							=	$daoLocalHorario->insert($arr_horario);
								$_gl_mensaje						=	"Establecimiento ".$gl_codigo." Editado Correctamente.";
							}
							if(!empty($arr_limpiar)){
								$daoLocal->update($arr_limpiar,$id_establecimiento);
								$_gl_mensaje						=	"Establecimiento ".$gl_codigo." Editado Correctamente.";

							}

							file_put_contents('php://stderr', PHP_EOL . print_r($resp_parametros, TRUE). PHP_EOL, FILE_APPEND);

							if(!empty($arr_gl_cambios)){
								$gl_detalles_historial						=	"";
								if(!empty($arr_gl_cambios)){
									$gl_detalles_historial					.=	"<br/>";
									foreach ($arr_gl_cambios as $gl_cambio) {
										$gl_detalles_historial				.=	" - ".$gl_cambio.".<br/>";
									}
								}
	
								$arr_historial							=	array(
									"id_evento_tipo"	=>	DAOHistorialLocal::HISTORIAL_LOCAL_EDICION_WS,
									"id_local"			=>	$id_establecimiento,
									"gl_descripcion"	=>	"Se ha Editado Establecimiento Farmacéutico de Empresa Farmacéutica <b>".$resp_parametros["gl_farmacia"]."</b> a través de WebService.".$gl_detalles_historial,
								);
	
								$daoHistorialLocal->insert($arr_historial);
							}else{
								$_gl_mensaje						=	"Establecimiento ".$gl_codigo." Sin cambios detectados.";
							}
						}else{
							header("HTTP/1.1 400 Bad Request");
							$cod_error				=	'010';
							$msg					=	'Faltan parámetros requeridos: '	.	implode(", ",$resp_parametros["arr_error"]);
							$apache_msg				=	'Bad Request';
							$apache_cod				=	400;
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

						if($lastCallError == 0 && !empty($gl_codigo) && $id_establecimiento > 0){
							$status				=	TRUE;
							$cod_error			=	'000';
							$msg				=	'OK';
							$apache_msg			=	'OK';
							$apache_cod			=	200;
							$cantidad			=	1;
							$resultado			=	array("gl_codigo" => $gl_codigo,"gl_mensaje"=>$_gl_mensaje);

							// $datos_historial	=	array(
							// 	"id_asignacion"		=>	$datos['id_asignacion'],
							// 	"id_evento_tipo"	=>	$id_evento_tipo,
							// 	"gl_descripcion"	=>	$historial_descripcion,
							// 	"id_usuario_crea"	=>	$usuario["id"],
							// );
							// $resp				=	$daoHistorial->insert($datos_historial);
							
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
								'id_establecimiento'	=> $id_establecimiento,
								'gl_rut' 				=> NULL,//$rut, 
								'id_usuario' 			=> NULL,//$usuario["id"], 
								'gl_version_ws' 		=> VERSION_WS, 
								'gl_version_app' 		=> $appVersion, 
								'gl_token_dispositivo' 	=> NULL,//$token_dispositivo,
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
							'json_datos'	 		=> NULL,//$datos_response, 
							'id_establecimiento'	=> $id_establecimiento,
							'gl_rut' 				=> NULL,//$rut, 
							'id_usuario' 			=> NULL,//$usuario["id"], 
							'gl_version_ws' 		=> VERSION_WS, 
							'gl_version_app' 		=> $appVersion, 
							'gl_token_dispositivo' 	=> NULL,//$token_dispositivo,
							'bo_ws_success' 		=> (int)$status, 
							'gl_service_name' 		=> $service_name_response
						);
					$daoErrorLog->setLogAuditoria($log_params);
				}else{
					header("HTTP/1.1 400 Bad Request");
					$cod_error				=	'001';
					$msg					=	'Solicitud sin los datos requeridos';
					$apache_msg				=	'Bad Request';
					$apache_cod				=	400;
				}
			}else{
				header("HTTP/1.1 404 Not Found");
				$cod_error			=	'107';
				$msg				=	'Registro no encontrado';
				$apache_msg			=	'Not Found';
				$apache_cod			=	404;
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
		$error_params	=	array(
				"cod_error"		=>	$cod_error,
				"msg"			=>	$msg,
				"apache_msg"	=>	$apache_msg,
				"apache_cod"	=>	$apache_cod,
			);

		//Imprimo por consola de apache los errores para hacerlo facilmente visible.
		file_put_contents('php://stderr', PHP_EOL . print_r($error_params, TRUE). PHP_EOL, FILE_APPEND);
		$log_params = array(
				'json_datos'	 		=> $error_params, 
				'id_asignacion'			=> NULL,//(!empty($datos))?$datos['id_asignacion']:'',
				'id_visita'				=> NULL,//$id_establecimiento,
				'gl_rut' 				=> NULL,//$rut, 
				'id_usuario' 			=> NULL,//$usuario["id"], 
				'gl_version_ws' 		=> VERSION_WS, 
				'gl_version_app' 		=> $appVersion, 
				'gl_token_dispositivo' 	=> NULL,//$token_dispositivo,
				'bo_ws_success' 		=> false, 
				'gl_service_name' 		=> $service_name_response
			);
		$daoErrorLog->setLogAuditoria($log_params);
	}
	
	$conn->cerrar_conexion();





function validar_datos($params,$local, $daoLocalRecetarioTipo, $daoFarmacia, $daoCodigoRegion, $daoRegion, $daoComuna, $daoLocalidad,$daoLocalTipo){
	
	$arr_error										=	array();
	$arr_cambios									=	array();
	$arr_gl_cambios									=	array();
	$arr_limpiar									=	array();

	$id_farmacia									=	NULL;
	$farmacia										=	NULL;

	$gl_token										=	$local["gl_token"];
	$local_recetario_tipo							=	(isset($params["id_recetario_tipo"]) && !empty($params["id_recetario_tipo"]))	?	$params["id_recetario_tipo"]	:	NULL;
	$gl_recetario									=	NULL;
	$ip_acceso										=	"0.0.0.0";
	$bo_movil										=	FALSE;

	$respuesta										=	array(
		"correcto"		=>	FALSE,
	);

	if(!empty($params)){
		if(!empty($params["gl_rut_farmacia"])){
			$farmacia								=	$daoFarmacia->getByRut($params["gl_rut_farmacia"]);
			if(empty($farmacia)){
				$arr_error[]						=	"Empresa Farmacéutica";
			}else{
				$id_farmacia						=	$farmacia["farmacia_id"];
				$respuesta["gl_farmacia"]			=	$farmacia["farmacia_razon_social"]." (".$farmacia["farmacia_rut"].")";
				if($farmacia["farmacia_id"]	!=	$local["fk_farmacia"]){
					$farmacia_old					=	$daoFarmacia->getById($local["fk_farmacia"]);
					$arr_cambios["fk_farmacia"]		=	$farmacia["farmacia_id"];
					$arr_gl_cambios[]				=	"Empresa Farmacéutica : de ".$farmacia_old["farmacia_razon_social"]." (".$farmacia_old["farmacia_rut"].") a ".$farmacia["farmacia_razon_social"]." (".$farmacia["farmacia_rut"].")";
				}
			}
		}
		
		if(!empty($local_recetario_tipo) && $local["id_recetario_tipo"] != $local_recetario_tipo){
			$gl_recetario_old							=	$daoLocalRecetarioTipo->getById($local["id_recetario_tipo"])["gl_nombre"];
			$gl_recetario								=	$daoLocalRecetarioTipo->getById($local_recetario_tipo)["gl_nombre"];
			$arr_cambios["id_recetario_tipo"]			=	$local_recetario_tipo;
			$arr_cambios["local_recetario_tipo"]		=	$gl_recetario;
			$arr_cambios["local_recetario"]				=	TRUE;
			$arr_gl_cambios[]							=	"Recetario : ".$gl_recetario_old." a ".$gl_recetario;
		}

		if(!empty($params["gl_factor_riesgo"]) && strtolower(trim($params["gl_factor_riesgo"])) != strtolower($local["factor_riesgo"])){
			$_factor_riesgo								=	ucwords(strtolower(trim($params["gl_factor_riesgo"])));
			$_factor_riesgo_old							=	strtolower($local["factor_riesgo"]);
			$arr_cambios["factor_riesgo"]				=	$_factor_riesgo;
			$arr_gl_cambios[]							=	"Factor de Riesgo : ".$_factor_riesgo_old." a ".$_factor_riesgo;

		}

		if(!empty($params["nr_resolucion_apertura"]) && $local["local_numero_resolucion"] != $params["nr_resolucion_apertura"]){
			$arr_cambios["local_numero_resolucion"]		=	$params["nr_resolucion_apertura"];
			$arr_gl_cambios[]							=	"Número de Resolución : ".$local["local_numero_resolucion"]." a ".$params["nr_resolucion_apertura"];
		}

		if(!empty($params["fc_resolucion"]) && date("d/m/Y",strtotime($local["local_fecha_resolucion"])) != $params["fc_resolucion"]){
			$arr_cambios["local_fecha_resolucion"]		=	formatearBaseDatosSinComilla(checkDateFormat($params["fc_resolucion"]));
			$arr_gl_cambios[]							=	"Fecha de Resolución : ".$local["local_fecha_resolucion"]." a ".$params["fc_resolucion"];
		}

		if(!empty($params["gl_nombre_establecimiento"]) && $local["local_nombre"] != validar(trim($params["gl_nombre_establecimiento"]),"string")){
			$arr_cambios["local_nombre"]				=	validar(trim($params["gl_nombre_establecimiento"]),"string");
			$arr_gl_cambios[]							=	"Nombre de Establecimiento : ".$local["local_nombre"]." a ".$params["gl_nombre_establecimiento"];

		}

		if(!empty($params["nr_numero_establecimiento"]) && $local["local_numero"] != $params["nr_numero_establecimiento"]){
			$arr_cambios["local_numero"]				=	$params["nr_numero_establecimiento"];
			$arr_gl_cambios[]							=	"Número de Establecimiento : ".$local["local_numero"]." a ".$params["nr_numero_establecimiento"];

		}

		if(!empty($params["id_tipo_establecimiento"])  && $local["fk_local_tipo"] != $params["id_tipo_establecimiento"]){
			$gl_tipo_est_old							=	$daoLocalTipo->getById($local["fk_local_tipo"])["gl_nombre"];
			$gl_tipo_est								=	$daoLocalTipo->getById($params["id_tipo_establecimiento"])["gl_nombre"];
			$arr_cambios["fk_local_tipo"]				=	$params["id_tipo_establecimiento"];
			$arr_gl_cambios[]							=	"Tipo de Establecimiento : ".$gl_tipo_est_old." a ".$gl_tipo_est;
		}
		
		if(($params["id_tipo_establecimiento"] == 4 || $local["fk_local_tipo"] == 4) && isset($params["bo_ver_ubicacion_en_mapa"]) && $params["bo_ver_ubicacion_en_mapa"] != $local["activa_mapa"]){
			$arr_cambios["activa_mapa"]					=	$params["bo_ver_ubicacion_en_mapa"];
		}elseif($local["activa_mapa"]){
			$arr_limpiar["activa_mapa"]					=	NULL;
		}

		$local_fono			 							=	$local["local_fono"];
		$local_fono_cod									=	$local["local_fono_codigo"];

		if(!empty($params["gl_fono_codigo"]) && $params["gl_fono_codigo"] != $local["local_fono_codigo"]){
			$arr_cambios["local_fono_codigo"]			=	$params["gl_fono_codigo"];
		}
		if(!empty($params["gl_fono"]) && $params["gl_fono"] != $local["local_fono"]){
			$arr_cambios["local_fono"]				=	$params["gl_fono"];
		}

		if(isset($arr_cambios["local_fono_codigo"]) || isset($arr_cambios["local_fono"])){
			$local_fono									=	isset($arr_cambios["local_fono"])			?	$arr_cambios["local_fono"]			:	$local["local_fono"];
			$local_fono_cod								=	isset($arr_cambios["local_fono_codigo"])	?	$arr_cambios["local_fono_codigo"]	:	$local["local_fono_codigo"];
			$arr_cambios["local_telefono"]				=	"+56".$local_fono_cod.$local_fono;
			$arr_gl_cambios[]							=	"Teléfono : "."+56".$local_fono_cod.$local_fono;

		}
		
		/*	Dirección (Fija y Recorrido)	*/
		if(isset($params["bo_clasificacion_movil"]) && $params["bo_clasificacion_movil"]){
			if(!empty($params["arr_recorrido"])){
				$recorrido									=	&$params["arr_recorrido"];
				$bo_movil									=	TRUE;

				foreach ($recorrido	as	&$rec) {
					$rec["gl_region"]						=	$daoRegion->getById($rec["id_region"])["gl_nombre"];
					$rec["gl_comuna"]						=	$daoComuna->getById($rec["id_comuna"])["gl_nombre"];
					$rec["gl_localidad"]					=	$daoLocalidad->getById($rec["id_localidad"])["gl_nombre"];
					$rec["hash"]							=	base64_encode(json_encode($rec,JSON_UNESCAPED_UNICODE));
				}

				$recorr_nuevo								=	base64_encode(json_encode($recorrido,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
				$recorr_local								=	!empty($local["json_recorrido"])	?	base64_encode($local["json_recorrido"])	:	NULL;

				if($recorr_nuevo != $recorr_local){
					if(isset($recorrido[0])){
						$primer_recorrido					=	$recorrido[0];
						$arr_cambios["id_region_midas"]		=	isset($primer_recorrido["id_region"])		?	$primer_recorrido["id_region"]		:	NULL;
						$arr_cambios["fk_region"]			=	isset($primer_recorrido["id_region"])		?	$primer_recorrido["id_region"]		:	NULL;
						$arr_cambios["id_comuna_midas"]		=	isset($primer_recorrido["id_comuna"])		?	$primer_recorrido["id_comuna"]		:	NULL;
						$arr_cambios["fk_comuna"]			=	isset($primer_recorrido["id_comuna"])		?	$primer_recorrido["id_comuna"]		:	NULL;
						$arr_cambios["fk_localidad"]		=	isset($primer_recorrido["id_localidad"])	?	$primer_recorrido["id_localidad"]	:	NULL;
						$arr_cambios["local_direccion"]		=	isset($primer_recorrido["gl_direccion"])	?	$primer_recorrido["gl_direccion"]	:	NULL;
						$arr_cambios["local_lng"]			=	isset($primer_recorrido["gl_longitud"])		?	$primer_recorrido["gl_longitud"]	:	NULL;
						$arr_cambios["local_lat"]			=	isset($primer_recorrido["gl_latitud"])		?	$primer_recorrido["gl_latitud"]		:	NULL;
					}
					$arr_cambios["json_recorrido"]			=	json_encode($recorrido,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
					$arr_gl_cambios[]						=	"Dirección Recorrido";
				}
			}
		}else{
			if(!empty($params["id_region"]) && $params["id_region"] != $local["id_region_midas"]){
				$_reg_old									=	$daoRegion->getById($local["id_region_midas"])["gl_nombre"];
				$_reg										=	$daoRegion->getById($params["id_region"])["gl_nombre"];
				$arr_cambios["id_region_midas"]				=	$params["id_region"];
				$arr_cambios["fk_region"]					=	$params["id_region"];
				$arr_gl_cambios[]							=	"Dirección - Región : ".$_reg_old." a ".$_reg;
			}
			if(!empty($params["id_comuna"]) && $params["id_comuna"] != $local["id_comuna_midas"]){
				$_com_old									=	$daoComuna->getById($local["id_comuna_midas"])["gl_nombre"];
				$_com										=	$daoComuna->getById($params["id_comuna"])["gl_nombre"];
				$arr_cambios["id_comuna_midas"]				=	$params["id_comuna"];
				$arr_cambios["fk_comuna"]					=	$params["id_comuna"];
				$arr_gl_cambios[]							=	"Dirección - Comuna : ".$_com_old." a ".$_com;

			}
			if(!empty($params["id_localidad"]) && $params["id_localidad"] != $local["fk_localidad"]){
				$_loc_old									=	$daoLocalidad->getById($local["fk_localidad"])["gl_nombre"];
				$_loc										=	$daoLocalidad->getById($params["id_localidad"])["gl_nombre"];
				$arr_cambios["fk_localidad"]				=	$params["id_localidad"];
				$arr_gl_cambios[]							=	"Dirección - Localidad : ".$_loc_old." a ".$_loc;
			}
			if(!empty($params["gl_direccion"]) && $params["gl_direccion"] != $local["local_direccion"]){
				$arr_cambios["local_direccion"]				=	$params["gl_direccion"];
				$arr_gl_cambios[]							=	"Dirección : ".$local["local_direccion"]." a ".$params["gl_direccion"];
			}
			if(!empty($params["gl_longitud_direccion"]) && $params["gl_longitud_direccion"] != $local["local_lng"]){
				$arr_cambios["local_lng"]					=	$params["gl_longitud_direccion"];
				$arr_gl_cambios[]							=	"Dirección - Longitud : ".$local["local_lng"]." a ".$params["gl_longitud_direccion"];
			}
			if(!empty($params["gl_latitud_direccion"]) && $params["gl_latitud_direccion"] != $local["local_lat"]){
				$arr_cambios["local_lat"]					=	$params["gl_latitud_direccion"];
				$arr_gl_cambios[]							=	"Dirección - Latitud : ".$local["local_lat"]." a ".$params["gl_latitud_direccion"];
			}
			
			$arr_limpiar["json_recorrido"]					=	NULL;
		}
		
		
		if((isset($params["id_region"]) && $params["id_region"] == 5 || !isset($params["id_region"]) && $local["id_region_midas"] == 5)
			&& (!empty($params["nr_rci"]) && $params["nr_rci"] != $local["rakin_numero"])){
			$arr_cambios["rakin_numero"]					=	$params["nr_rci"];
			$arr_gl_cambios[]								=	"Número RCI : ".$local["rakin_numero"]." a ".$params["nr_rci"];

		}elseif(isset($params["id_region"]) && $params["id_region"] != 5 && !empty($local["rakin_numero"])){
			$arr_limpiar["rakin_numero"]						=	NULL;
		}

		if(isset($params["bo_receta_1A"])||isset($params["bo_receta_1B"])||isset($params["bo_receta_2A"])||isset($params["bo_receta_2B"])||isset($params["bo_receta_2C"])||isset($params["bo_receta_3A"])||isset($params["bo_receta_3B"])||isset($params["bo_receta_3C"])||isset($params["bo_receta_3D"])||isset($params["bo_receta_4"])||isset($params["bo_receta_5"])){
			$bos_rec			=	!empty($local["local_recetario_fk_detalle"]) ? explode(":",$local["local_recetario_fk_detalle"]) : NULL;
			$bo_receta_1A		=	isset($bos_rec[0])	?	$bos_rec[0]		:	FALSE;
			$bo_receta_1B		=	isset($bos_rec[1])	?	$bos_rec[1]		:	FALSE;
			$bo_receta_2A		=	isset($bos_rec[2])	?	$bos_rec[2]		:	FALSE;
			$bo_receta_2B		=	isset($bos_rec[3])	?	$bos_rec[3]		:	FALSE;
			$bo_receta_2C		=	isset($bos_rec[4])	?	$bos_rec[4]		:	FALSE;
			$bo_receta_3A		=	isset($bos_rec[5])	?	$bos_rec[5]		:	FALSE;
			$bo_receta_3B		=	isset($bos_rec[6])	?	$bos_rec[6]		:	FALSE;
			$bo_receta_3C		=	isset($bos_rec[7])	?	$bos_rec[7]		:	FALSE;
			$bo_receta_3D		=	isset($bos_rec[8])	?	$bos_rec[8]		:	FALSE;
			$bo_receta_4		=	isset($bos_rec[9])	?	$bos_rec[9]		:	FALSE;
			$bo_receta_5		=	isset($bos_rec[10])	?	$bos_rec[10]	:	FALSE;

			$arr_recetario_detalle					=	array(
				isset($params["bo_receta_1A"])	?	(($params["bo_receta_1A"])?"1":"0")	:	(($bo_receta_1A)?"1":"0"),
				isset($params["bo_receta_1B"])	?	(($params["bo_receta_1B"])?"1":"0")	:	(($bo_receta_1B)?"1":"0"),
				isset($params["bo_receta_2A"])	?	(($params["bo_receta_2A"])?"1":"0")	:	(($bo_receta_2A)?"1":"0"),
				isset($params["bo_receta_2B"])	?	(($params["bo_receta_2B"])?"1":"0")	:	(($bo_receta_2B)?"1":"0"),
				isset($params["bo_receta_2C"])	?	(($params["bo_receta_2C"])?"1":"0")	:	(($bo_receta_2C)?"1":"0"),
				isset($params["bo_receta_3A"])	?	(($params["bo_receta_3A"])?"1":"0")	:	(($bo_receta_3A)?"1":"0"),
				isset($params["bo_receta_3B"])	?	(($params["bo_receta_3B"])?"1":"0")	:	(($bo_receta_3B)?"1":"0"),
				isset($params["bo_receta_3C"])	?	(($params["bo_receta_3C"])?"1":"0")	:	(($bo_receta_3C)?"1":"0"),
				isset($params["bo_receta_3D"])	?	(($params["bo_receta_3D"])?"1":"0")	:	(($bo_receta_3D)?"1":"0"),
				isset($params["bo_receta_4"])	?	(($params["bo_receta_4"])?"1":"0")	:	(($bo_receta_4)?"1":"0"),
				isset($params["bo_receta_5"])	?	(($params["bo_receta_5"])?"1":"0")	:	(($bo_receta_5)?"1":"0"),
			);

			$json_recetario_detalle					=	array(
				"bo_receta_1A"	=>	isset($params["bo_receta_1A"])	?	$params["bo_receta_1A"]	:	$bo_receta_1A,
				"bo_receta_1B"	=>	isset($params["bo_receta_1B"])	?	$params["bo_receta_1B"]	:	$bo_receta_1B,
				"bo_receta_2A"	=>	isset($params["bo_receta_2A"])	?	$params["bo_receta_2A"]	:	$bo_receta_2A,
				"bo_receta_2B"	=>	isset($params["bo_receta_2B"])	?	$params["bo_receta_2B"]	:	$bo_receta_2B,
				"bo_receta_2C"	=>	isset($params["bo_receta_2C"])	?	$params["bo_receta_2C"]	:	$bo_receta_2C,
				"bo_receta_3A"	=>	isset($params["bo_receta_3A"])	?	$params["bo_receta_3A"]	:	$bo_receta_3A,
				"bo_receta_3B"	=>	isset($params["bo_receta_3B"])	?	$params["bo_receta_3B"]	:	$bo_receta_3B,
				"bo_receta_3C"	=>	isset($params["bo_receta_3C"])	?	$params["bo_receta_3C"]	:	$bo_receta_3C,
				"bo_receta_3D"	=>	isset($params["bo_receta_3D"])	?	$params["bo_receta_3D"]	:	$bo_receta_3D,
				"bo_receta_4"	=>	isset($params["bo_receta_4"])	?	$params["bo_receta_4"]	:	$bo_receta_4,
				"bo_receta_5"	=>	isset($params["bo_receta_5"])	?	$params["bo_receta_5"]	:	$bo_receta_5,
			);

			$impld_recetario_detalle				=	implode(":",$arr_recetario_detalle);

			if($impld_recetario_detalle	!= $local["local_recetario_fk_detalle"]){
				$arr_cambios["json_recetario_detalle"]		=	json_encode($json_recetario_detalle,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
				$arr_cambios["local_recetario_fk_detalle"]	=	$impld_recetario_detalle;
				
				$json_old									=	!empty($local["json_recetario_detalle"]) ? json_decode($local["json_recetario_detalle"],TRUE) : NULL;
				
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_1A"]	!=	$json_old["bo_receta_1A"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_1A"])?"Agregada":"Quitada").":	1A -   Papelillos U Otros Envases De Polvo";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_1B"]	!=	$json_old["bo_receta_1B"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_1B"])?"Agregada":"Quitada").":	1B -   Capsulas Duras";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_2A"]	!=	$json_old["bo_receta_2A"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_2A"])?"Agregada":"Quitada").":	2A -   Jarabes, Soluciones Y Suspensiones";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_2B"]	!=	$json_old["bo_receta_2B"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_2B"])?"Agregada":"Quitada").":	2B -   Ovulos, Supositorios";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_2C"]	!=	$json_old["bo_receta_2C"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_2C"])?"Agregada":"Quitada").":	2C -   Cremas, Geles, Pastas";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_3A"]	!=	$json_old["bo_receta_3A"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_3A"])?"Agregada":"Quitada").":	3A -   Preparados Esteriles No Inyectables";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_3B"]	!=	$json_old["bo_receta_3B"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_3B"])?"Agregada":"Quitada").":	3B -   Esteriles Inyectables";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_3C"]	!=	$json_old["bo_receta_3C"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_3C"])?"Agregada":"Quitada").":	3C -   Nutriciones Parenterales";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_3D"]	!=	$json_old["bo_receta_3D"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_3D"])?"Agregada":"Quitada").":	3D -   Citostaticos";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_4"]	!=	$json_old["bo_receta_4"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_4"])?"Agregada":"Quitada").":	4   -   Preparados Cosmeticos Magistrales (excepto Protectores Solares)";
				}
				if(empty($json_old)	|| $json_recetario_detalle["bo_receta_5"]	!=	$json_old["bo_receta_5"]){
					$arr_gl_cambios[]						=	"Tipo Recetario - ".(($json_recetario_detalle["bo_receta_5"])?"Agregada":"Quitada").":	5   -   Preparados Homeopaticos";
				}
			}

		}

		if(isset($params["bo_ubicacion_impide_turno"]) && $params["bo_ubicacion_impide_turno"] != $local["local_impide_turnos"]){
			$_imp_turno										=	$params["bo_ubicacion_impide_turno"]	?	"Impide Turno"		:	"No Impide Turno";
			$arr_cambios["local_impide_turnos"]				=	($params["bo_ubicacion_impide_turno"])?1:0;
			$arr_gl_cambios[]								=	"¿Local Impide Turno? - ".$_imp_turno;

		}

		if(isset($params["bo_clasificacion_alopatica"]) && $local["local_tipo_alopatica"] != $params["bo_clasificacion_alopatica"]){
			$_bo_alo										=	($params["bo_clasificacion_alopatica"])	?	"Agregada"	:	"Quitada";
			$arr_cambios["local_tipo_alopatica"]			=	($params["bo_clasificacion_alopatica"])?1:0;
			$arr_gl_cambios[]								=	$_bo_alo." Clasificación Alopática";

		}
		if(isset($params["bo_clasificacion_homeopatica"]) && $local["local_tipo_homeopatica"] != $params["bo_clasificacion_homeopatica"]){
			$_bo_alo										=	($params["bo_clasificacion_homeopatica"])	?	"Agregada"	:	"Quitada";
			$arr_cambios["local_tipo_homeopatica"]			=	($params["bo_clasificacion_homeopatica"])?1:0;
			$arr_gl_cambios[]								=	$_bo_alo." Clasificación Homeopática";
		}
		if(isset($params["bo_clasificacion_movil"]) && $local["local_tipo_movil"] != $params["bo_clasificacion_movil"]){
			$_bo_alo										=	($params["bo_clasificacion_movil"])	?	"Agregada"	:	"Quitada";
			$arr_cambios["local_tipo_movil"]				=	($params["bo_clasificacion_movil"])?1:0;
			$arr_gl_cambios[]								=	$_bo_alo." Clasificación Móvil";
		}
		if(isset($params["bo_clasificacion_urgencia"]) && $local["local_tipo_urgencia"] != $params["bo_clasificacion_urgencia"]){
			$_bo_alo										=	($params["bo_clasificacion_urgencia"])	?	"Agregada"	:	"Quitada";
			$arr_cambios["local_tipo_urgencia"]				=	($params["bo_clasificacion_urgencia"])?1:0;
			$arr_gl_cambios[]								=	$_bo_alo." Clasificación Urgencia";
		}

		if(isset($params["bo_franquicia"]) && $local["local_tipo_franquicia"] != $params["bo_franquicia"]){
			$_bo											=	($params["bo_franquicia"])	?	"Es"	:	"No Es";
			$arr_cambios["local_tipo_franquicia"]			=	($params["bo_franquicia"])?1:0;
			$arr_gl_cambios[]								=	"Local ".$_bo." Franquicia";
		}
		
		if(isset($params["bo_recetario_en_local"]) && $local["local_tiene_recetario"] != $params["bo_recetario_en_local"]){
			$_bo											=	($params["bo_recetario_en_local"])	?	"Agrega"	:	"Sin";
			$arr_cambios["local_tiene_recetario"]			=	($params["bo_recetario_en_local"])?1:0;
			$arr_gl_cambios[]								=	"Local ".$_bo." Recetario";
		}

		if(!empty($arr_cambios)){
			$arr_cambios["local_fecha_edicion"]				=	date("Y-m-d H:i:s");
		}

		$respuesta["correcto"]								=	TRUE;
		$respuesta["bo_movil"]								=	$bo_movil;
		$respuesta["arr_cambios"]							=	$arr_cambios;
		$respuesta["arr_gl_cambios"]						=	$arr_gl_cambios;
		$respuesta["arr_limpiar"]							=	$arr_limpiar;
		$respuesta["arr_horario"]							=	getDatosHorario($params,$local,$arr_gl_cambios);

	}else{
		$respuesta["error_html"]							=	"Sin Parámetros";
	}



	return	$respuesta;
}

function getDatosHorario($params,$local,&$arr_gl_cambios){
	$arr_dias				=	["lunes","martes","miercoles","jueves","viernes","sabado","domingo","festivos"];
	$arr_horario_local		=	$local;
	$horario				=	isset($params["arr_horario"])			?	$params["arr_horario"]				:	NULL;
	$bo_continuado			=	isset($params["bo_horario_continuado"])	?	$params["bo_horario_continuado"]	:	FALSE;
	$arr					=	array(
		"bo_continuado"			=>	$bo_continuado,
		"json_lunes"			=>	NULL,
		"json_martes"			=>	NULL,
		"json_miercoles"		=>	NULL,
		"json_jueves"			=>	NULL,
		"json_viernes"			=>	NULL,
		"json_sabado"			=>	NULL,
		"json_domingo"			=>	NULL,
		"json_festivos"			=>	NULL,
	);
	if(!empty($horario)){
		foreach ($arr_dias	as	$dia) {
			if(isset($horario[$dia]) && !empty($horario[$dia])){
				$_dia				=	$dia;
				if($dia == "festivos"){
					$_dia			=	"festivo";
				}
				$_arr				=	array(
					$_dia."_man_inicio"		=>	$horario[$dia]["manana_inicio"],
					$_dia."_man_fin"		=>	($bo_continuado)	?	NULL	:	$horario[$dia]["manana_fin"],
					$_dia."_tar_inicio"		=>	($bo_continuado)	?	NULL	:	$horario[$dia]["tarde_inicio"],
					$_dia."_tar_fin"		=>	$horario[$dia]["tarde_fin"],
				);

				$arr["json_".$dia]	=	json_encode($_arr,JSON_PRETTY_PRINT);
			}else{
				$arr["json_".$dia]	=	NULL;
			}
		}

		$arr_gl_cambios[]			=	"Horarios";
	}

	return	$arr;
}