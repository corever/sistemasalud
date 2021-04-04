<?php

	include_once("DAO/DAOUsuario.php");
	include_once("DAO/DAOErrorLog.php");
	include_once("DAO/DAOHistorial.php");
	include_once("DAO/DAOHistorialLocal.php");
	include_once("DAO/DAOLocal.php");
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
	$daoLocalHorario			=	new DAOLocalHorario($conn);
	$daoHistorialLocal			=	new DAOHistorialLocal($conn);
	$daoLocalRecetarioTipo		=	new DAOLocalRecetarioTipo($conn);
	$daoFarmacia				=	new DAOFarmacia($conn);
	$daoCodigoRegion			=	new DAOCodigoRegion($conn);

	$daoComuna					=	new DAODireccionComuna($conn);
	$daoRegion					=	new DAODireccionRegion($conn);
	$daoLocalidad				=	new DAODireccionLocalidad($conn);
	
	$service_name				=	"registrarEstablecimientoRequest";
	$service_name_response		=	"registrarEstablecimientoResponse";

	// $rut						=	NULL;
	// $password					=	NULL;
	// $region_usuario				=	NULL;
	$appVersion					=	NULL;
	$version_menor				=	NULL;
	$version_micro				=	NULL;
	$version_mayor				=	NULL;

	$datos						=	NULL;
	$id_establecimiento			=	NULL;
	$gl_codigo_midas			=	NULL;
	$id_evento_tipo				=	DAOHistorial::TIPO_EVENTO_VISITA_SIN_ESTADO;
	$historial_descripcion		=	"Hubo un problema al recuperar el tipo de evento.";
	$aux_cod_error				=	'999';
	$aux_msg					=	'Error desconocido';

	// $rut						=	(!empty($_REQUEST['gl_rut']))				?	$_REQUEST['gl_rut']					:	NULL;
	// $password					=	(!empty($_REQUEST['gl_clave']))				?	$_REQUEST['gl_clave']				:	NULL;
	// $region_usuario				=	(!empty($_REQUEST['region']))				?	$_REQUEST['region']					:	NULL;
	$appVersion					=	(isset($_REQUEST['appVersion']))			?	$_REQUEST['appVersion']			:	NULL;
	$datos						=	(isset($_REQUEST["datos"]))					?	$_REQUEST["datos"]				:	NULL;

	/*
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
	else
	*/
	if(empty($appVersion)){
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
			$params						=	array();
			$params["rut"]				=	NULL;//$rut;//'24995712-7';
			//$params["password"]		=	$password;
			$params["region_usuario"]	=	NULL;//$region_usuario;
			$params["rol"]				=	30;
			$usuario					=	NULL;//$daoUsuario->getLogin($params);

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

				if(!empty($datos)){

					$_conexion										=	$conn->conexion;
					//se desactiva autocommit
					mysqli_autocommit($_conexion, FALSE);
					//mysqli_begin_transaction($_conexion);
					$_conexion->begin_transaction();

					try{
						$resp_parametros							=	validar_datos($datos, $daoLocalRecetarioTipo, $daoFarmacia, $daoCodigoRegion, $daoRegion, $daoComuna, $daoLocalidad);
						if($resp_parametros["correcto"]){
							$arr_local								=	$resp_parametros["arr_local"];
							
							$id_establecimiento						=	$daoLocal->insert($arr_local);
							
							if(!empty($id_establecimiento)){

								$gl_codigo_midas					=	establecimientoCodigo($id_establecimiento);
								$updt_cod_midas						=	$daoLocal->update(array("gl_codigo_midas"=>$gl_codigo_midas),$id_establecimiento);

								$arr_horario						=	isset($resp_parametros["arr_horario"])	?	$resp_parametros["arr_horario"]	:	NULL;
								if(!empty($arr_horario)){
									$arr_horario["id_local"]		=	$id_establecimiento;
									$id_horario						=	$daoLocalHorario->insert($arr_horario);
								}

								$arr_historial						=	array(
									"id_evento_tipo"	=>	DAOHistorialLocal::HISTORIAL_LOCAL_CREACION_WS,
									"id_local"			=>	$id_establecimiento,
									"gl_descripcion"	=>	"Se ha creado un Nuevo Establecimiento Farmacéutico de Empresa Farmacéutica <b>".$resp_parametros["gl_farmacia"]."</b> a través de WebService.",
								);

								$daoHistorialLocal->insert($arr_historial);
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

						if($lastCallError == 0 && !empty($gl_codigo_midas) && $id_establecimiento > 0){
							$status				=	TRUE;
							$cod_error			=	'000';
							$msg				=	'OK';
							$apache_msg			=	'OK';
							$apache_cod			=	200;
							$cantidad			=	1;
							$resultado			=	array("gl_codigo_midas" => $gl_codigo_midas);

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


			// }else{
			// 	header("HTTP/1.1 401 Unauthorized");
			// 	$cod_error	= '006';
			// 	$msg		= 'Credencial Incorrecta';
			// 	$apache_msg	= 'Unauthorized';
			// 	$apache_cod	= 401;
			// }
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





function validar_datos($params, $daoLocalRecetarioTipo, $daoFarmacia, $daoCodigoRegion, $daoRegion, $daoComuna, $daoLocalidad){
	
	$arr_error										=	array();
	$respuesta										=	array(
		"correcto"		=>	FALSE,
	);
	/*	variables insert	*/
	$id_farmacia									=	NULL;
	$farmacia										=	NULL;
	$gl_token										=	NULL;
	$local_recetario_tipo							=	(isset($params["id_recetario_tipo"]) && !empty($params["id_recetario_tipo"]))	?	$params["id_recetario_tipo"]	:	NULL;
	$gl_recetario									=	NULL;
	$ip_acceso										=	"0.0.0.0";

	if(!empty($local_recetario_tipo)){
		$gl_recetario								=	$daoLocalRecetarioTipo->getById($local_recetario_tipo)["gl_nombre"];
	}

	if(!empty($params)){
		if(!empty($params["gl_rut_farmacia"])){
			$farmacia								=	$daoFarmacia->getByRut($params["gl_rut_farmacia"]);
			if(empty($farmacia)){
				$arr_error[]						=	"Empresa Farmacéutica";
			}else{
				$id_farmacia						=	$farmacia["farmacia_id"];
				$respuesta["gl_farmacia"]			=	$farmacia["farmacia_razon_social"]." (".$farmacia["farmacia_rut"].")";
			}
		}else{
			$arr_error[]							=	"Empresa Farmacéutica";
		}
		if(empty($params["gl_factor_riesgo"])){
			$arr_error[]							=	"Factor de Riesgo";
		}
		if(empty($params["nr_resolucion_apertura"])){
			$arr_error[]							=	"Número Resolución de Apertura";
		}
		if(empty($params["fc_resolucion"])){
			$arr_error[]							=	"Fecha de Resolución";
		}
		if(empty($params["gl_nombre_establecimiento"])){
			$arr_error[]							=	"Nombre del Establecimiento";
		}
		if(empty($params["nr_numero_establecimiento"])){
			$arr_error[]							=	"Número del Establecimiento";
		}
		if(empty($params["id_tipo_establecimiento"])){
			$arr_error[]							=	"Tipo de Establecimiento";
		}
		if(empty($params["gl_fono_codigo"]) && empty($params["local_fono"])){
			// $arr_error[]							=	"Dirección";
		}

		if($params["bo_clasificacion_movil"]){
			if(empty($params["arr_recorrido"])){
				$arr_error[]						=	"Dirección Móvil";
			}else{
				$recorrido							=	&$params["arr_recorrido"];
				if(isset($recorrido[0])){
					$primer_recorrido					=	$recorrido[0];
					$params["id_region"]				=	isset($primer_recorrido["id_region"])		?	$primer_recorrido["id_region"]		:	NULL;
					$params["id_comuna"]				=	isset($primer_recorrido["id_comuna"])		?	$primer_recorrido["id_comuna"]		:	NULL;
					$params["id_localidad"]				=	isset($primer_recorrido["id_localidad"])	?	$primer_recorrido["id_localidad"]	:	NULL;
					$params["gl_direccion"]				=	isset($primer_recorrido["gl_direccion"])	?	$primer_recorrido["gl_direccion"]	:	NULL;
					$params["gl_latitud_direccion"]		=	isset($primer_recorrido["gl_latitud"])		?	$primer_recorrido["gl_latitud"]		:	NULL;
					$params["gl_longitud_direccion"]	=	isset($primer_recorrido["gl_longitud"])		?	$primer_recorrido["gl_longitud"]	:	NULL;
				}

				foreach ($recorrido	as	&$rec) {
					$rec["gl_region"]					=	$daoRegion->getById($rec["id_region"])["gl_nombre"];
					$rec["gl_comuna"]					=	$daoComuna->getById($rec["id_comuna"])["gl_nombre"];
					$rec["gl_localidad"]				=	$daoLocalidad->getById($rec["id_localidad"])["gl_nombre"];
					$rec["hash"]						=	base64_encode(json_encode($rec,JSON_UNESCAPED_UNICODE));
				}
			}
		}else{
			if(empty($params["id_region"])){
				$arr_error[]						=	"Región";
			}
			if(empty($params["id_comuna"])){
				$arr_error[]						=	"Comuna";
			}
			if(empty($params["id_localidad"])){
				$arr_error[]						=	"Localidad";
			}
			if(empty($params["gl_direccion"])){
				$arr_error[]						=	"Dirección";
			}
		}
		
		if($params["id_region"] == 5 && empty($params["nr_rci"])){
			$arr_error[]							=	"Número RCI";
		}

		if(empty($arr_error)){
			$arr_recetario_detalle			=	array(
				($params["bo_receta_1A"]	== "true")	?	1	:	0,
				($params["bo_receta_1B"]	== "true")	?	1	:	0,
				($params["bo_receta_2A"]	== "true")	?	1	:	0,
				($params["bo_receta_2B"]	== "true")	?	1	:	0,
				($params["bo_receta_2C"]	== "true")	?	1	:	0,
				($params["bo_receta_3A"]	== "true")	?	1	:	0,
				($params["bo_receta_3B"]	== "true")	?	1	:	0,
				($params["bo_receta_3C"]	== "true")	?	1	:	0,
				($params["bo_receta_3D"]	== "true")	?	1	:	0,
				($params["bo_receta_4"]		== "true")	?	1	:	0,
				($params["bo_receta_5"]		== "true")	?	1	:	0,
			);

			$json_recetario_detalle			=	array(
				"bo_receta_1A"	=>	($params["bo_receta_1A"]	== "true")	?	1	:	0,
				"bo_receta_1B"	=>	($params["bo_receta_1B"]	== "true")	?	1	:	0,
				"bo_receta_2A"	=>	($params["bo_receta_2A"]	== "true")	?	1	:	0,
				"bo_receta_2B"	=>	($params["bo_receta_2B"]	== "true")	?	1	:	0,
				"bo_receta_2C"	=>	($params["bo_receta_2C"]	== "true")	?	1	:	0,
				"bo_receta_3A"	=>	($params["bo_receta_3A"]	== "true")	?	1	:	0,
				"bo_receta_3B"	=>	($params["bo_receta_3B"]	== "true")	?	1	:	0,
				"bo_receta_3C"	=>	($params["bo_receta_3C"]	== "true")	?	1	:	0,
				"bo_receta_3D"	=>	($params["bo_receta_3D"]	== "true")	?	1	:	0,
				"bo_receta_4"	=>	($params["bo_receta_4"]		== "true")	?	1	:	0,
				"bo_receta_5"	=>	($params["bo_receta_5"]		== "true")	?	1	:	0,
			);

			$gl_token								=	generaTokenEstablecimiento($id_farmacia,$params["gl_nombre_establecimiento"],$params["nr_resolucion_apertura"]);

			$fc_resolucion							=	checkDateFormat($params["fc_resolucion"]);

			$arr_local								=	array(
				"fk_farmacia"							=>	$id_farmacia,
				"ordenamiento"							=>	NULL,
				"local_nombre"							=>	$params["gl_nombre_establecimiento"],
				"local_numero"							=>	$params["nr_numero_establecimiento"],
				"local_direccion"						=>	$params["gl_direccion"],
				"local_lat"								=>	$params["gl_latitud_direccion"],
				"local_lng"								=>	$params["gl_longitud_direccion"],
				"local_impide_turnos"					=>	$params["bo_ubicacion_impide_turno"],
				"local_telefono"						=>	!empty($params["gl_fono"]) ? "+56".trim($params["gl_fono_codigo"].$params["gl_fono"]) : NULL,
				"local_fono_codigo"						=>	$params["gl_fono_codigo"],
				"local_fono"							=>	$params["gl_fono"],
				"fk_localidad"							=>	$params["id_localidad"],
				"fk_region"								=>	$params["id_region"],
				"fk_comuna"								=>	$params["id_comuna"],
				"fk_local_tipo"							=>	$params["id_tipo_establecimiento"],
				"local_numero_resolucion"				=>	$params["nr_resolucion_apertura"],
				"local_fecha_resolucion"				=>	$fc_resolucion,
				"local_tipo_alopatica"					=>	$params["bo_clasificacion_alopatica"],
				"local_tipo_homeopatica"				=>	$params["bo_clasificacion_homeopatica"],
				"local_tipo_movil"						=>	$params["bo_clasificacion_movil"],
				"local_tipo_urgencia"					=>	$params["bo_clasificacion_urgencia"],
				"local_estado"							=>	1,
				"local_tipo_franquicia"					=>	($params["bo_franquicia"]=="true")?1:0,
				"local_recetario"						=>	!empty($gl_recetario)?1:0,
				"local_tiene_recetario"					=>	$params["bo_recetario_en_local"],
				"local_recetario_tipo"					=>	(!empty($gl_recetario)	?	strtoupper($gl_recetario)	:	NULL),
				"id_recetario_tipo"						=>	$params["id_recetario_tipo"],
				"local_recetario_fk_detalle"			=>	implode(":",$arr_recetario_detalle),
				"json_recetario_detalle"				=>	json_encode($json_recetario_detalle, JSON_PRETTY_PRINT),
				"local_preparacion_solidos"				=>	0,
				"local_preparacion_liquidos"			=>	0,
				"local_preparacion_esteriles"			=>	0,
				"local_preparacion_cosmeticos"			=>	0,
				"local_preparacion_homeopaticos"		=>	0,

				"resolucion_url"						=>	"",

				"id_region_midas"						=>	$params["id_region"],
				"id_comuna_midas"						=>	$params["id_comuna"],

				"json_recorrido"						=>	!empty($params["arr_recorrido"])	?	json_encode($params["arr_recorrido"],JSON_UNESCAPED_UNICODE)	:	NULL,
				"activa_mapa"							=>	($params["id_tipo_establecimiento"] == 4) ? $params["bo_ver_ubicacion_en_mapa"]	:	FALSE,
				"factor_riesgo"							=>	$params["gl_factor_riesgo"],
				"rakin_numero"							=>	$params["nr_rci"],
				"ip_cadena_acceso"						=>	$ip_acceso,
				"gl_token"								=>	$gl_token,

				/*	Crear CODIGO	*/
				// "gl_codigo_midas"					=>	$gl_codigo_midas,
			);
			
			$arr_local["fk_usuario_creacion"]			=	0;
			$arr_local["local_fecha_creacion"]			=	date("Y-m-d H:i:s");

			$respuesta["correcto"]						=	TRUE;
			$respuesta["arr_local"]						=	$arr_local;
			$respuesta["arr_horario"]					=	getDatosHorario($params);
		}else{
			$html_error									=	"";
			foreach ($arr_error as $param) {
				$html_error								.=	"	- El campo <b>".$param."</b> es requerido.<br/>";
			}

			$respuesta["error_html"]					=	$html_error;
			$respuesta["arr_error"]						=	$arr_error;
		}	
		

	}else{
		$respuesta["error_html"]						=	"Sin Parámetros";
	}

	return	$respuesta;
}

function getDatosHorario($params){
	$arr_dias		=	["lunes",
	"martes","miercoles","jueves","viernes","sabado","domingo","festivos"];
	$horario		=	isset($params["arr_horario"])			?	$params["arr_horario"]				:	NULL;
	$bo_continuado	=	isset($params["bo_horario_continuado"])	?	$params["bo_horario_continuado"]	:	FALSE;
	$arr			=	array(
		"bo_continuado"		=>	$bo_continuado,
		"json_lunes"		=>	NULL,
		"json_martes"		=>	NULL,
		"json_miercoles"	=>	NULL,
		"json_jueves"		=>	NULL,
		"json_viernes"		=>	NULL,
		"json_sabado"		=>	NULL,
		"json_domingo"		=>	NULL,
		"json_festivos"		=>	NULL,
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
	}

	return	$arr;
}