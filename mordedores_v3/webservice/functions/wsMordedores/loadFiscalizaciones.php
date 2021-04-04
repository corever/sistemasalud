<?php
	//Entrada
	$server->wsdl->addComplexType(
		'loadFiscalizacionesInput',
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
	    'loadFiscalizacionesOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:boolean'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string'),
			'arr_fiscalizaciones' => array('arr_fiscalizaciones'	, 'type' => 'tns:arrFiscalizaciones', 'minOccurs' => 0 , 'maxOccurs' => 1),
	    )
	);

	$server->wsdl->addComplexType(
		'arrFiscalizaciones', 
		'complexType', 
		'struct', 
		'all', 
		'',
		array(
		    'gl_glosa' => array('gl_glosa', 'type'=> 'xsd:string'),
            'fiscalizaciones' => array('fiscalizaciones', 'type'=> 'xsd:string')
        )
	);


	$server->register(  'loadFiscalizaciones',
						array('data'	=> 'tns:loadFiscalizacionesInput'),
						array('return'	=> 'tns:loadFiscalizacionesOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#loadFiscalizaciones',
						"rpc", 
						"encoded", 
						''
	);


	function loadFiscalizaciones($arrWs){
		$conn =  new MySQL();
		$daoUsuario = new DAOUsuario($conn);
		$daoExpediente = new DAOExpediente($conn);
		$daoErrorLog = new DAOErrorLog($conn);

		$service_name = "loadFiscalizacionesRequest";
		$service_name_response = "loadFiscalizacionesResponse";
		$bo_resultado = false;
		$gl_error = '<b>Error:</b> data Incorrecta';
		$cd_error = 'ERROR_DATA_INCORRECTA';

		$rut 				= null;
		$password 			= null;
		$token_dispositivo	= null;
		$appVersion 		= null;
		$id_fiscalizador 	= null;
		$arr_fiscalizaciones= array();
		$respuesta 			= array();
		try{
		if(!empty($arrWs) && is_array($arrWs)){
			$rut 				= (!empty($arrWs['rut']))?$arrWs['rut']:null;
			$password 			= (!empty($arrWs['password']))?$arrWs['password']:null;
			$token_dispositivo 	= (!empty($arrWs['token_dispositivo']))?$arrWs['token_dispositivo']:null;
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
			else
			{	
				$usuario = $daoUsuario->getUsuarioByRut($rut);

				if(!empty($usuario) && $usuario['id_usuario'] == $id_fiscalizador)
		        {
                    $fiscalizaciones = $daoExpediente->getFiscalizacionesMordedores($id_fiscalizador);
                    if($fiscalizaciones !== false){
                    	$bo_resultado = true;
			            $gl_error = "Solicitud procesada con exito";
		                $cd_error = "SUCCESS";
		                $arr_fiscalizaciones['fiscalizaciones'] = json_encode($fiscalizaciones);
                    }else{
                    	$error_sql = array("error_sql"=>$conn->mensaje_error,"query"=>$conn->query_error);
                    	file_put_contents('php://stderr', PHP_EOL . print_r($error_sql, TRUE). PHP_EOL, FILE_APPEND);
				        $daoErrorLog->setLogAuditoria($error_sql, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)false, $service_name_response);
                    	$gl_error = '<b>Error:</b> Ocurrio un error al obtener las fiscalizaciones.';
						$cd_error = 'ERROR_DATA_INCORRECTA';
                    }
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
			            	'arr_fiscalizaciones' => $arr_fiscalizaciones
		            	);
		
		//$daoErrorLog->setLogAuditoria($respuesta, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)$bo_resultado, $service_name_response);
		}
		catch(Exception $e){
			error_log(print_r($e,1));
		}
		$conn->cerrar_conexion();

		return $respuesta;
    }

