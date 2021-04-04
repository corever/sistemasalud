<?php
	//Entrada
	$server->wsdl->addComplexType(
		'validarEnvioFiscalizacionMordedoresInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' 		 				=> array('rut' 					, 'type' => 'xsd:string'),
			'password' 	 				=> array('password' 			, 'type' => 'xsd:string'),
			'token_dispositivo'		 	=> array('token_dispositivo'	, 'type' => 'xsd:string'),
			'datos_json'                => array('datos_json'           , 'type' => 'xsd:string'),
			'appVersion'              	=> array('appVersion'			, 'type' => 'xsd:string'),
			'cantidad_mordedores'		=> array('cantidad_mordedores'	, 'type' => 'xsd:int'),
			'cantidad_adjuntos'			=> array('cantidad_adjuntos'	, 'type' => 'xsd:int'),
			'origen'					=> array('origen'				, 'type' => 'xsd:int'),
		)
	);

	// Salida
	$server->wsdl->addComplexType(
	    'validarEnvioFiscalizacionMordedoresOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:string'),
		    'id_fiscalizacion'		=> array('id_fiscalizacion'		, 'type' => 'xsd:string'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
	    )
	);

	$server->register(  'validarEnvioFiscalizacionMordedores',
						array('data'	=> 'tns:validarEnvioFiscalizacionMordedoresInput'),
						array('return'	=> 'tns:validarEnvioFiscalizacionMordedoresOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#validarEnvioFiscalizacionMordedores',
						"rpc", 
						"encoded", 
						''
	);


	function validarEnvioFiscalizacionMordedores($arrWs){
		$conn					= new MySQL();
		$daoUsuario				= new DAOUsuario($conn);
		$daoAdjunto				= new DAOAdjunto($conn);
		$daoVisita				= new DAOVisita($conn);
		$daoErrorLog			= new DAOErrorLog($conn);
		$daoHistorialEvento		= new DAOHistorialEvento($conn);
		$daoVisitaAnimalMordedor= new DAOVisitaAnimalMordedor($conn);

		$service_name			= "validarEnvioFiscalizacionMordedoresRequest";
		$service_name_response	= "validarEnvioFiscalizacionMordedoresResponse";
		$gl_error				= '<b>Error:</b> data Incorrecta';
		$cd_error				= 'ERROR_DATA_INCORRECTA';
		$bo_resultado			= false;
		$id_fiscalizacion		= null;

		$rut					= null;
		$password				= null;
		$token_dispositivo		= null;
		$appVersion				= null;
		$id_fiscalizacion		= null;
		$cantidad_mordedores	= null;
		$_token_fiscalizacion	= null;
		$token_json				= null;
		$respuesta 			  	= array();

		if(!empty($arrWs) && is_array($arrWs)){
			$datos_json			  	= json_decode(str_replace("'","",utf8_encode($arrWs["datos_json"])));
			$rut 					= (!empty($arrWs['rut']))						? $arrWs['rut'] :null;
			$password 				= (!empty($arrWs['password']))					? $arrWs['password'] :null;
			$token_dispositivo 		= (!empty($arrWs['token_dispositivo']))			? $arrWs['token_dispositivo'] :null;
			$appVersion				= (!empty($arrWs['appVersion']))				? $arrWs['appVersion'] :null;
			$cantidad_mordedores  	= (!empty($arrWs['cantidad_mordedores']))		? $arrWs['cantidad_mordedores'] :0;
			$cantidad_adjuntos  	= (!empty($arrWs['cantidad_adjuntos']))			? $arrWs['cantidad_adjuntos'] :0;
			$_token_fiscalizacion 	= (!empty($datos_json->_token_fiscalizacion))	? $datos_json->_token_fiscalizacion :null;
			$usuario				= $daoUsuario->getUsuarioByRut($rut);

			$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 1, $service_name);

			if(empty($_token_fiscalizacion)){
				$gl_error	= '<b>Error:</b> El token de fiscalización es un parametro obligatorio.';
        		$cd_error	= 'ERROR_DATA_INCORRECTA';
			}
			else if(!empty($usuario) && (int)$usuario['id_usuario'] > 0){
	            $visita	= $daoVisita->getByTokenFiscalizacion($_token_fiscalizacion);

	            if(!empty($visita)){

	            	if($visita['bo_exito_sincronizar'] == 1){
            			$bo_resultado	= true;
	                	$gl_error		= 'Solicitud procesada con exito';
                		$cd_error		= 'SUCCESS';
					}else{
		                $total_adjuntos = $daoAdjunto->getCantidadAdjuntosByIdVisita($visita["id_visita"]);

						if($visita['id_visita_estado'] == $daoVisita::ESTADO_VISITA_PERDIDA){
		                	if((int)$total_adjuntos === (int)$cantidad_adjuntos){
		            			$bo_resultado	= true;
		                		$id_evento_tipo	= $daoHistorialEvento::HISTORIAL_VISITA_PERDIDA;
							}else{
			                	$gl_error	= 'El registro aun espera adjuntos para sincronizar. ('.(int)$total_adjuntos.' de '.(int)$cantidad_adjuntos.')';
		                		$cd_error	= 'ERROR_ADJUNTOS_SIN_SINCRONIZAR';
			                }

						}else{
							if($visita['bo_sumario'] == 1){
								/// verifico si el registro está sincronizado y todas sus muestras fueron enviadas
				                if((int)$total_adjuntos === (int)$cantidad_adjuntos){
				                	$bo_resultado	= true;
				                	$id_evento_tipo	= $daoHistorialEvento::HISTORIAL_VISITA_REALIZADA;
				                }else{
				                	$gl_error	= 'El registro aun espera adjuntos para sincronizar. ('.(int)$total_adjuntos.' de '.(int)$cantidad_adjuntos.')';
			                		$cd_error	= 'ERROR_ADJUNTOS_SIN_SINCRONIZAR';
				                }

							}else{
								/// verifico si el registro está sincronizado y todas sus muestras fueron enviadas
				                 $total_mordedores = $daoVisitaAnimalMordedor->getTotalByIdVisita($visita["id_visita"]);
						if((int)$total_mordedores === (int)$cantidad_mordedores){
				                	$total_adjuntos	= $daoAdjunto->getCantidadAdjuntosByIdVisita($visita["id_visita"]);

									if((int)$total_adjuntos === (int)$cantidad_adjuntos){
					                	$bo_resultado	= true;
					                	$id_evento_tipo	= $daoHistorialEvento::HISTORIAL_VISITA_REALIZADA;
					                }else{
					                	$gl_error	= 'El registro aun espera adjuntos para sincronizar. ('.(int)$total_adjuntos.' de '.(int)$cantidad_adjuntos.')';
				                		$cd_error	= 'ERROR_ADJUNTOS_SIN_SINCRONIZAR';
					                }

								}else{
				                	$gl_error	= 'El registro aun espera mordedores para sincronizar. ('.(int)$total_mordedores.' de '.(int)$cantidad_mordedores.')';
			                		$cd_error	= 'ERROR_REGISTRO_SIN_SINCRONIZAR';
				                }
							}
						}

						if($bo_resultado == true){
							$id_fiscalizacion	= $visita["id_visita"];
							$gl_error			= 'Solicitud procesada con exito';
	                		$cd_error			= 'SUCCESS';

							$fecha_actual		= date("Y-m-d H:i:s");
							$parametros_visita	= array(
														"bo_exito_sincronizar"	=> 1,
														"fc_fin_sincronizacion"	=> $fecha_actual,
														"id_usuario_actualiza"	=> $usuario["id_usuario"],
														"fc_actualiza"			=> $fecha_actual
													);
		                    $daoVisita->update($parametros_visita, $visita["id_visita"]);

							$datos_historial_evento	= array(
															"id_evento_tipo"	=> $id_evento_tipo,
															"id_expediente"		=> $visita["id_expediente"],
															"gl_descripcion"	=> "VISITA SINCRONIZADA DESDE LA APP",
															"id_usuario"		=> $usuario["id_usuario"],
														);
		                    $daoHistorialEvento->insertHistorialExpediente($datos_historial_evento);
						}
					}
	            
				}else{
					if(filter_var($datos_json->bo_devuelta, FILTER_VALIDATE_BOOLEAN)){
						$eventos = $daoHistorialEvento->getEventoExpedienteDevuelto($datos_json->id_expediente, $usuario['id_usuario'], $datos_json->moment_inspeccion);

						if(!empty($eventos) && is_array($eventos)){
							$bo_resultado	= true;
							$gl_error	= 'Solicitud procesada con exito';
	                		$cd_error	= 'SUCCESS';
						}else{
	            			$gl_error	= '<b>Error:</b> No se pudo encontrar una visita registrada.';
		                	$cd_error	= 'ERROR_REGISTRO_NO_ENCONTRADO';
		                	$bo_resultado	= false;
						}


					}else{
		            	$gl_error	= '<b>Error:</b> No se pudo encontrar una visita registrada.';
	                	$cd_error	= 'ERROR_REGISTRO_NO_ENCONTRADO';
					}
	            }
	        
			}else{
	        	$gl_error	= '<b>Error:</b> El rut del fiscalizador es un parametros obligatorio.';
                $cd_error	= 'ERROR_CREDENCIALES_INCORRECTAS';
	        }

		}else{
			$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 0, $service_name);
		}

		$respuesta	= array(
							'resultado'			=> $bo_resultado, 
							'id_fiscalizacion'	=> $id_fiscalizacion,
							'gl_glosa'			=> $gl_error, 
							'tipo_error'		=> $cd_error, 
							'version_app'		=> VERSION_APP
						);

		$daoErrorLog->setLogAuditoria($respuesta, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)$bo_resultado, $service_name_response);
		$conn->cerrar_conexion();

		return $respuesta;
    }