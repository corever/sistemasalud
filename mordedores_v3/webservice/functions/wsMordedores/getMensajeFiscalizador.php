<?php
	//Entrada
	$server->wsdl->addComplexType(
		'getMensajeFiscalizadorInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' 				=> array('rut'				, 'type' => 'xsd:string'),
			'password' 			=> array('password'			, 'type' => 'xsd:string'),
			'region' 			=> array('region'			, 'type' => 'xsd:string'),
			'token_dispositivo' => array('token_dispositivo', 'type' => 'xsd:string'),
			'appVersion'    	=> array('appVersion'		, 'type' => 'xsd:string'),
			'id_fiscalizador' 	=> array('id_fiscalizador'	, 'type' => 'xsd:int'),
		)
	);


	// Salida
	$server->wsdl->addComplexType(
	    'getMensajeFiscalizadorOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:boolean'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string'),
			'arr_mensajes' => array('arr_mensajes'	, 'type' => 'tns:arrMensajes', 'minOccurs' => 0 , 'maxOccurs' => 1),
	    )
	);

	$server->wsdl->addComplexType(
		'arrMensajes', 
		'complexType', 
		'struct', 
		'all', 
		'',
		array(
		    'gl_glosa' => array('gl_glosa', 'type'=> 'xsd:string'),
            'mensajes' => array('mensajes', 'type'=> 'xsd:string')
        )
	);


	$server->register(  'getMensajeFiscalizador',
						array('data'	=> 'tns:getMensajeFiscalizadorInput'),
						array('return'	=> 'tns:getMensajeFiscalizadorOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#getMensajeFiscalizador',
						"rpc", 
						"encoded", 
						''
	);


	function getMensajeFiscalizador($arrWs){
		$conn =  new MySQL();
		$daoUsuario = new DAOUsuario($conn);
		$daoMensajeWebservice = new DAOMensajeWebservice($conn);
		$daoMensajeUsuario = new DAOMensajeUsuario($conn);
		$daoErrorLog = new DAOErrorLog($conn);

		$service_name = "getMensajeFiscalizadorRequest";
		$service_name_response = "getMensajeFiscalizadorResponse";
		$bo_resultado = false;
		$gl_error = '<b>Error:</b> data Incorrecta';
		$cd_error = 'ERROR_DATA_INCORRECTA';

		$rut 				= null;
		$password 			= null;
		$token_dispositivo	= null;
		$appVersion 		= null;
		$id_fiscalizador 	= null;
		$arr_mensajes		= array();
		$respuesta 			= array();

		if(!empty($arrWs) && is_array($arrWs)){
			$rut 				= (!empty($arrWs['rut']))?$arrWs['rut']:null;
			$password 			= (!empty($arrWs['password']))?$arrWs['password']:null;
			$token_dispositivo	= (!empty($arrWs['token_dispositivo']))?$arrWs['token_dispositivo']:null;
			$appVersion			= (!empty($arrWs['appVersion']))?$arrWs['appVersion']:null;
			$id_fiscalizador	= (!empty($arrWs['id_fiscalizador']))?$arrWs['id_fiscalizador']:null;
			
			//$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 1, $service_name);
			
			if(trim($rut) == '' or trim($rut) == 0){
				$gl_error = '<b>Error:</b> rut';
				$cd_error = 'ERROR_RUT';
			}
			else if(is_null($id_fiscalizador)){
				$gl_error = '<b>Error:</b> Id de usuario requerido';
				$cd_error = 'ERROR_ID_FISCALIZADOR';
			}
			else if(is_null($appVersion)){
				$gl_error = '<b>Error:</b> Versión de la app requerida';
				$cd_error = 'ERROR_VERSION_APP';
			}
			else
			{	
				$usuario = $daoUsuario->getUsuarioByRut($rut);

				if(!empty($usuario) && $usuario['id_usuario'] == $id_fiscalizador)
		        {
                    $mensajes_pendientes = array();
                    $mensajesWebservice = $daoMensajeWebservice->getListaByVersion($appVersion);
                    
                    foreach ($mensajesWebservice as $mensaje) {
                    	$existe_mensaje = $daoMensajeUsuario->getExistMensajeUsuario($mensaje["id_mensaje"],$id_fiscalizador);
                    	
                    	if($existe_mensaje == 0){
                    		$datos_mensaje = array(
	                    			"id_mensaje" => $mensaje["id_mensaje"],
									"gl_rut" => $rut,
									"gl_token_tablet" => $token_dispositivo,
									"gl_version" => $appVersion,
									"id_usuario_crea" => $id_fiscalizador,
                    			);
							$daoMensajeUsuario->insert($datos_mensaje);
                    		$mensajes_pendientes[] = $mensaje["gl_mensaje"];
                    	}
                    }

                    $bo_resultado = true;
		            $gl_error = "Solicitud procesada con exito";
	                $cd_error = "SUCCESS";
	                $arr_mensajes['mensajes'] = json_encode($mensajes_pendientes);
		        }
		        else
		        {
		        	$gl_error = '<b>Error:</b> No se pudo encontrar al usuario.';
					$cd_error = 'ERROR_CREDENCIALES_INCORRECTAS';
		        }
		    }
		}
		else{
			//$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 0, $service_name);
		}
		$respuesta =   array(
		            		'resultado'		=> $bo_resultado,
			            	'gl_glosa'		=> $gl_error,
			            	'tipo_error'	=> $cd_error, 
			            	'version_app'	=> VERSION_APP, 
			            	'arr_mensajes' 	=> $arr_mensajes
		            	);

		//$daoErrorLog->setLogAuditoria($respuesta, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)$bo_resultado, $service_name_response);
		$conn->cerrar_conexion();

		return $respuesta;
    }

