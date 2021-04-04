<?php
	//Entrada
	$server->wsdl->addComplexType(
		'devolverFiscalizacionMordedoresInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' 		 				=> array('rut' 					, 'type' => 'xsd:string'),
			'password' 	 				=> array('password' 			, 'type' => 'xsd:string'),
			'token_dispositivo'		 	=> array('token_dispositivo'	, 'type' => 'xsd:string'),
			'token'		 				=> array('token'	 			, 'type' => 'xsd:string'),//usuario
			'cantidad_adjuntos'			=> array('cantidad_adjuntos'	, 'type' => 'xsd:string'),
			'cantidad_mordedores'		=> array('cantidad_mordedores'	, 'type' => 'xsd:string'),
			'datos_json'		 		=> array('datos_json'	 		, 'type' => 'xsd:string'),
			'appVersion'              	=> array('appVersion'			, 'type' => 'xsd:string'),
		)
	);

	// Salida
	$server->wsdl->addComplexType(
	    'devolverFiscalizacionMordedoresOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:string'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string')
	    )
	);

	$server->register(  'devolverFiscalizacionMordedores',
						array('data'	=> 'tns:devolverFiscalizacionMordedoresInput'),
						array('return'	=> 'tns:devolverFiscalizacionMordedoresOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#devolverFiscalizacionMordedores',
						"rpc", 
						"encoded", 
						''
	);


	function devolverFiscalizacionMordedores($arrWs){
		$conn			= new MySQL();
		$daoVisita		= new DAOVisita($conn);
		$daoUsuario		= new DAOUsuario($conn);
		$daoErrorLog	= new DAOErrorLog();	
		
		$service_name			= "devolverFiscalizacionMordedoresRequest";
		$service_name_response	= "devolverFiscalizacionMordedoresResponse";
		$bo_resultado			= false;
		$id_fiscalizacion		= null;
		$gl_error				= '<b>Error:</b> data Incorrecta';
		$cd_error				= 'ERROR_DATA_INCORRECTA';
		
		$rut					= null;
		$password				= null;
		$token_dispositivo		= null;
		$appVersion				= null;
		$_token_fiscalizacion	= null;
		$respuesta				= array();

		if(!empty($arrWs) && is_array($arrWs)){
			$datos_json			  = json_decode(str_replace("'","",utf8_encode($arrWs["datos_json"])));
			$rut 				  = (!empty($arrWs['rut']))						? $arrWs['rut']:null;
			$password 			  = (!empty($arrWs['password']))				? $arrWs['password']:null;
			$token_dispositivo	  = (!empty($arrWs['token_dispositivo']))		? $arrWs['token_dispositivo']:null;
			$appVersion			  = (!empty($arrWs['appVersion']))				? $arrWs['appVersion']:null;
			$_token_fiscalizacion = (!empty($datos_json->_token_fiscalizacion))	? $datos_json->_token_fiscalizacion:null;

			$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 1, $service_name);

            if(trim($rut) == '' or trim($rut) == 0){
				$gl_error	= '<b>Error:</b> El campo Rut es obligatorio.';
				$cd_error	= 'ERROR_RUT';
			
			}elseif(empty($datos_json)){
				$gl_error		= '<b>Error:</b> los datos del expediente son obligatorios.';
				$cd_error		= 'ERROR_DATA_INCORRECTA';
				$bo_resultado	= false;
			
			}else{
				$usuario	= $daoUsuario->getUsuarioByRut($rut);

				if(!is_null($usuario)) {	               
		        	//$visita	= $daoVisita->getByTokenFiscalizacion($_token_fiscalizacion);
	            	$guardado_datos_exitosoado_inspeccion	= validar($datos_json->id_visita_estado,"numero"); 

            		if($guardado_datos_exitosoado_inspeccion == $daoVisita::ESTADO_VISITA_PERDIDA || filter_var($datos_json->bo_devuelta, FILTER_VALIDATE_BOOLEAN) ){
		            	/***********INICIANDO VARIABLES*************/
				        $id_tipo_visita_resultado	= $daoVisita::RESULTADO_SIN_DATOS;
				        $id_visita		= null;
		            	$id_usuario		= $usuario["id_usuario"];
				        $_conexion		= $conn->conexion;
				        //se desactiva autocommit
				        mysqli_autocommit($_conexion, FALSE);
				        //mysqli_begin_transaction($_conexion);
				        $_conexion->begin_transaction();
					    /*********** FIN INICIADO VARIABLES *************/   
					    
						try{
			            	/*
			            	$gl_origen = "APP";
			            	if($token_dispositivo == 'WEB' ){
			            		$gl_origen = 'Informada Web';
			            	}
			            	elseif($token_dispositivo == 'REGULARIZAR' ){
			            		$gl_origen = 'Regularizada';
			            	}
			            	*/

        					$daoExpediente			= new DAOExpediente($conn);
        					$daoExpedienteMordedor	= new DAOExpedienteMordedor($conn);
		            		$daoHistorialEvento	= new DAOHistorialEvento($conn);
        					
        					$daoExpediente->devolverProgramacion($datos_json->id_expediente, $id_usuario);

		            		$datos_historial_evento = array(
								"id_expediente"		=> $datos_json->id_expediente,
								"gl_descripcion"	=> "Se devuelve a Supervisor, motivo: ".$datos_json->gl_motivo_devuelta,
								"id_usuario"		=> $id_usuario,
								"fc_crea"           => $datos_json->moment_inspeccion
							);
							
        					$mordedores_expediente	= $daoExpedienteMordedor->getByFiscalizador($datos_json->id_expediente, $id_usuario, true);
        					if(is_array($mordedores_expediente)){
			            		foreach ($mordedores_expediente as $expediente_mordedor) {
	    							//Devolver
	    							$daoExpedienteMordedor->devolverProgramacion($expediente_mordedor["id_expediente_mordedor"], $id_usuario);

									//Guardar Evento
			            			$datos_historial_evento["id_mordedor"] = (!empty($expediente_mordedor["id_mordedor"]))?$expediente_mordedor["id_mordedor"]:$expediente_mordedor["id_expediente_mordedor"];
			            			$datos_historial_evento["id_evento_tipo"] = 16; //DEVUELTO
			            			$daoHistorialEvento->insertHistorialExpediente($datos_historial_evento);
			            		}

			                    $bo_resultado	= true;
								$gl_error	= 'Solicitud procesada con exito';
								$cd_error	= 'SUCCESS';
        					}else{
        						$bo_resultado	= true;
								$gl_error	= 'Solicitud procesada con exito';
								$cd_error	= 'SUCCESS';
        					}

        					//COMITEO TODAS LAS QUERYS PROCESADAS
			            	mysqli_commit($_conexion);
			            	//ACTIVO NUEVAMENTE EL AUTOCOMMIT
				            mysqli_autocommit($_conexion, true);	            			
						}catch(Exception $e){
				            file_put_contents('php://stderr', PHP_EOL . print_r("ERROR INESPERADO - EJECUTANDO ROLLBACK", TRUE). PHP_EOL, FILE_APPEND);
				            file_put_contents('php://stderr', PHP_EOL . print_r($e->getMessage(), TRUE). PHP_EOL, FILE_APPEND);

				            $error_sql	= array("error_sql"=>$conn->mensaje_error,"query"=>$conn->query_error);
				            $daoErrorLog->setLogAuditoria($error_sql, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)false, $service_name_response);

				            //Revertir
				            mysqli_rollback($_conexion);
				            //mysqli_commit($_conexion);
				            mysqli_autocommit($_conexion, true);

				            $gl_error	= 'Error al intentar guardar en fiscalización';
							$cd_error	= 'ERROR_DATA_INCORRECTA';
				        }

            		}else{
            			$gl_error = '<b>Error:</b> El Estado Visita es incorrecto.';
						$cd_error = 'ERROR_ESTADO_VISITA_INCORRECTO';
            		}
		        }
		        else
		        {
		        	$gl_error = '<b>Error:</b> El Rut es incorrecto.';
					$cd_error = 'ERROR_CREDENCIALES_INCORRECTAS';
		        }

			}
		}else{
			$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 0, $service_name);
		}

		$respuesta = array(
					'resultado' 	=> $bo_resultado, 
					'gl_glosa'		=> $gl_error, 
					'tipo_error'	=> $cd_error, 
					'version_app' 	=> VERSION_APP
				);
        
        //ACTIVO NUEVAMENTE EL AUTOCOMMIT
        mysqli_autocommit($_conexion, true);
		$daoErrorLog->setLogAuditoria($respuesta, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)$bo_resultado, $service_name_response);
		$conn->cerrar_conexion();

		return $respuesta;
    }

