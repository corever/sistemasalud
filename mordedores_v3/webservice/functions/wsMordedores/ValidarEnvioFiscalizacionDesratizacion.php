<?php
	//Entrada
	$server->wsdl->addComplexType(
		'validarEnvioFiscalizacionDesratizacionInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' 		 				=> array( 'rut' 					, 'type' => 'xsd:string'),
			'password' 	 				=> array( 'password' 				, 'type' => 'xsd:string'),
			'token'		 				=> array( 'token'	 				, 'type' => 'xsd:string'),
			'datos_json'		 		=> array( 'datos_json'	 			, 'type' => 'xsd:string'),
			'appVersion'              	=> array( 'appVersion'				, 'type' => 'xsd:string'),
		)
	);

	// Salida
	$server->wsdl->addComplexType(
	    'validarEnvioFiscalizacionDesratizacionOutput',
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

	$server->register(  'validarEnvioFiscalizacionDesratizacion',
						array('data'	=> 'tns:validarEnvioFiscalizacionDesratizacionInput'),
						array('return'	=> 'tns:validarEnvioFiscalizacionDesratizacionOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#validarEnvioFiscalizacionPerdida',
						"rpc", 
						"encoded", 
						''
	);


	function validarEnvioFiscalizacionDesratizacion($arrWs){
		//$conn =  new MySQL();
		//$daoUsuario = new DAOUsuario($conn);
		//$daoErrorLog = new DAOErrorLog($conn);
		//$daoDesratizacion = new DAODesratizacion();
		
		$service_name = "validarEnvioFiscalizacionDesratizacionRequest";
		$service_name_response = "validarEnvioFiscalizacionDesratizacionResponse";
		$gl_error = '<b>Error:</b> data Incorrecta';
		$cd_error = 'ERROR_DATA_INCORRECTA';
		$bo_resultado = false;

		$rut		= null;
		$password	= null;
		$token		= null;
		$appVersion	= null;
		$datos_json	= null;

		/****************************/
		$cd_error = 'SUCCESS';
		$gl_error = 'Solicitud procesada con exito';
		$bo_resultado = true;
		/****************************/
		
		$respuesta = array(
					'resultado' => $bo_resultado, 
					'gl_glosa'=>$gl_error, 
					'tipo_error'=>$cd_error, 
					'version_app' => VERSION_APP
				);
		//$daoErrorLog->setLogAuditoria($respuesta, $rut, VERSION_WS, $appVersion, $token, (int)$bo_resultado, $service_name_response);
		//$conn->cerrar_conexion();

		return $respuesta;
    }

?>