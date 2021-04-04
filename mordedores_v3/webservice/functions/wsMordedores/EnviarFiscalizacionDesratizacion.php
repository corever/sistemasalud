<?php
	//Entrada
	$server->wsdl->addComplexType(
		'enviarFiscalizacionDesratizacionInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' 		 				=> array( 'rut' 					, 'type' => 'xsd:string'),
			'password' 	 				=> array( 'password' 				, 'type' => 'xsd:string'),
			'token_dispositivo'		 	=> array( 'token_dispositivo'		, 'type' => 'xsd:string'),
			'datos_json'		 		=> array( 'datos_json'	 			, 'type' => 'xsd:string'),
			'appVersion'              	=> array( 'appVersion'				, 'type' => 'xsd:string'),
		)
	);

	// Salida
	$server->wsdl->addComplexType(
	    'enviarFiscalizacionDesratizacionOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:int'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string')
	    )
	);

	$server->register(  'enviarFiscalizacionDesratizacion',
						array('data'	=> 'tns:enviarFiscalizacionDesratizacionInput'),
						array('return'	=> 'tns:enviarFiscalizacionDesratizacionOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#validarEnvioFiscalizacionPerdida',
						"rpc", 
						"encoded", 
						''
	);


	function enviarFiscalizacionDesratizacion($arrWs){
		$conn =  new MySQL();
		$daoUsuario = new DAOUsuario($conn);
		$daoErrorLog = new DAOErrorLog($conn);
		$daoDesratizacion = new DAODesratizacion($conn);
		
		$service_name = "enviarFiscalizacionDesratizacionRequest";
		$service_name_response = "enviarFiscalizacionDesratizacionResponse";
		$gl_error = '<b>Error:</b> data Incorrecta';
		$cd_error = 'ERROR_DATA_INCORRECTA';
		$bo_resultado = false;

		$rut		= null;
		$password	= null;
		$token_dispositivo	= null;
		$appVersion	= null;
		$datos_json	= null;

		if(!empty($arrWs) && is_array($arrWs)){
			$rut 				  = (!empty($arrWs['rut']))?$arrWs['rut']:null;
			$password 			  = (!empty($arrWs['password']))?$arrWs['password']:null;
			$token_dispositivo	  = (!empty($arrWs['token_dispositivo']))?$arrWs['token_dispositivo']:null;
			$appVersion			  = (!empty($arrWs['appVersion']))?$arrWs['appVersion']:null;
			$datos_json			  = json_decode(str_replace("'","",utf8_encode($arrWs["datos_json"])));

			$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 1, $service_name);

			$usuario = $daoUsuario->getUsuarioByRut($rut);
/* Revisar */
			if(is_null($usuario)){
				$usuario = $daoUsuario->getUsuarioByRutMIDAS($rut);
			}

			if(!is_null($usuario))
	        {
	        	$id_desratizacion = $daoDesratizacion->insert($datos_json,$usuario["id_usuario"]);
				if(!empty($id_desratizacion)){
					$fecha = strtotime($datos_json->fecha) ;
		            $fecha = date ( 'Y-m-d H:i:s' , $fecha );

		            $detalles_inspeccion = array(
		                'id_tramite'           	 => $datos_json->id_tramite,
		                'rut_fiscalizador'       => $datos_json->rut_fiscalizador,
		                'desarrollo'    		 => $datos_json->desarrollo,
		                'comentarios_inspeccion' => $datos_json->comentarios_inspeccion,
		                'motivo_no_inspeccion'   => $datos_json->motivo_no_inspeccion,
		                'resultado_inspeccion'   => $datos_json->resultado_inspeccion,
		                'fecha'    				 => $fecha,
		                'fecha_text'         	 => $datos_json->fecha_text,
		                'fc_visita' 		 	 => $datos_json->fc_visita.' '.$datos_json->hr_visita,
		                'fc_fin_visita' 	 	 => $datos_json->fc_fin_visita.' '.$datos_json->hr_fin_visita,
		            );

		            if($datos_json->resultado_inspeccion == 2){
		            	$detalles_inspeccion["desarrollo"]->conclusiones_visita[] = array("codigo" => 5, "descripcion" => "Visita Perdida", "valor" => true);
		            }

					$resp = $daoDesratizacion->enviarDocs(json_encode($detalles_inspeccion));
					if(!$resp || $resp->response == "ERR" || $resp->response != "OK"){
						if($resp){
							$err = $resp->msg;
						}else{
							//$err = "error en envío de tramite a MIDAS";
							$err = $resp->msg;
						}
						$cd_error = 'ERROR_SINCRONIZACION';
						$gl_error = $err;
					}else{
						$cd_error = 'SUCCESS';
						$gl_error = 'Solicitud procesada con exito';
						$bo_resultado = true;
					}
				}else{
					$cd_error = 'ERROR_SINCRONIZACION';
					$gl_error = '<b>Error:</b> data Incorrecta';
				}
	        }
	        else
	        {
	        	$gl_error = '<b>Error:</b> El Rut es incorrecto.';
				$cd_error = 'ERROR_CREDENCIALES_INCORRECTAS';
	        }	               			
		}else{
			$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 0, $service_name);
		}
		
		$respuesta = array(
					'resultado' => (int)$bo_resultado, 
					'gl_glosa'=>$gl_error, 
					'tipo_error'=>$cd_error, 
					'version_app' => VERSION_APP
				);
		$daoErrorLog->setLogAuditoria($respuesta, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)$bo_resultado, $service_name_response);
		$conn->cerrar_conexion();
		
		return $respuesta;
    }

?>