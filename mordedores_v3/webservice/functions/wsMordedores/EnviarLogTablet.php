<?php
	//Entrada
	$server->wsdl->addComplexType(
		'enviarLogTabletInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'tipo_error'		 		=> array( 'tipo_error' 				, 'type' => 'xsd:string'),
            'datos_json'		 		=> array( 'datos_json' 				, 'type' => 'xsd:string'),
            'id_fiscalizador'           => array( 'id_fiscalizador'         , 'type' => 'xsd:string'),
            'rut' 		 				=> array('rut' 					, 'type' => 'xsd:string'),
			'token'		 				=> array( 'token'	 				, 'type' => 'xsd:string'),
			'appVersion'              	=> array( 'appVersion'				, 'type' => 'xsd:string'),
		)
	);

	// Salida
	$server->wsdl->addComplexType(
	    'enviarLogTabletOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:boolean'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
            'id_log'			    => array('id_log'			, 'type' => 'xsd:string'),
	    )
	);

	$server->register(  'enviarLogTablet',
						array('data'	=> 'tns:enviarLogTabletInput'),
						array('return'	=> 'tns:enviarLogTabletOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#enviarLogTablet',
						"rpc", 
						"encoded", 
						''
	);


	function enviarLogTablet($arrWs){
		$daoErrorLog = new DAOErrorLog();

		$service_name = "enviarLogTabletRequest";
		$service_name_response = "enviarLogTabletResponse";
		$gl_error = '<b>Error:</b> data Incorrecta';
		$cd_error = 'ERROR_DATA_INCORRECTA';
		$respuesta = array('resultado'=>false,'gl_glosa'=>$gl_error, 'tipo_error'=>$cd_error, 'version_app' => VERSION_APP);
		
		if(is_array($arrWs)){
            $id_usuario 	= (!empty($arrWs['id_fiscalizador']))?$arrWs['id_fiscalizador']:0;
            $rut 			= (!empty($arrWs['rut']))?$arrWs['rut']:0;
            $token 			= (!empty($arrWs['token']))?$arrWs['token']:null;
			$appVersion		= (!empty($arrWs['appVersion']))?$arrWs['appVersion']:null;
			$tipo_log 		= (!empty($arrWs['tipo_log']))?$arrWs['tipo_log']:null;

			try{
            	$id = $daoErrorLog->setLogAuditoriaBichito($arrWs['datos_json'], $id_usuario, $rut, $tipo_log, VERSION_WS, $appVersion, $token, 1, $service_name);
	            $gl_error = 'Solicitud procesada con exito';
	            $cd_error = 'SUCCESS';
			}
	        catch(Exception $e)
	        {
	            file_put_contents('php://stderr', PHP_EOL . print_r("ERROR INESPERADO - EJECUTANDO ROLLBACK", TRUE). PHP_EOL, FILE_APPEND);
	            file_put_contents('php://stderr', PHP_EOL . print_r($e->getMessage(), TRUE). PHP_EOL, FILE_APPEND);

	            $error_sql = array("error_sql"=>$conn->mensaje_error,"query"=>$conn->query_error);
	            $daoErrorLog->setLogAuditoria($error_sql, $rut, VERSION_WS, $appVersion, $token, (int)false, $service_name_response);
	        }

            $respuesta = array('resultado' => true, 'gl_glosa'=>$gl_error, 'tipo_error'=>$cd_error, 'id_log' => $id, 'version_app' => VERSION_APP);
		}

		return $respuesta;
    }

?>