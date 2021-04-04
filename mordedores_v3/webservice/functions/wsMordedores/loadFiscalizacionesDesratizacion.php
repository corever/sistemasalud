<?php
	//Entrada
	$server->wsdl->addComplexType(
		'loadFiscalizacionesDesratizacionInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' => array( 'rut', 'type' => 'xsd:string'),
			'password' => array( 'password', 'type' => 'xsd:string'),
			'region' => array( 'region', 'type' => 'xsd:string'),
			'token_dispositivo' => array( 'token_dispositivo', 'type' => 'xsd:string')
		)
	);


	// Salida
	$server->wsdl->addComplexType(
	    'loadFiscalizacionesDesratizacionOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:boolean'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string'),
			'arr_fiscalizaciones' 	=> array('arr_fiscalizaciones'	, 'type' => 'tns:filaFiscalizacion', 'minOccurs' => 0 , 'maxOccurs' => 99),
	    )
	);

	
	$server->wsdl->addComplexType(
	    'filaFiscalizacion',
        'complexType',
		'struct',
		'secuence',
		'',
		array(
		    'json'				=> array('json'			, 'type' => 'xsd:string'),
	    )
	);	


	$server->register(  'loadFiscalizacionesDesratizacion',
						array('data'	=> 'tns:loadFiscalizacionesDesratizacionInput'),
						array('return'	=> 'tns:loadFiscalizacionesDesratizacionOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#loadFiscalizacionesDesratizacion',
						"rpc", 
						"encoded", 
						''
	);


	function loadFiscalizacionesDesratizacion($arrWs){
		$daoDesratizacion = new DAODesratizacion();

		$service_name = "loadFiscalizacionesRequest";
		$bo_resultado = false;
		$gl_glosa = '<b>Error:</b> data Incorrecta';
		$cd_error = 'ERROR_DATA_INCORRECTA';
		$arr_fiscalizaciones = array();
		$respuesta = array();

		if(is_array($arrWs)){
			$rut 		= (!empty($arrWs['rut']))		?   $arrWs['rut']		:null;
			$password 	= (!empty($arrWs['password']))	?   $arrWs['password']	:null;
			$token_dispositivo 	= (!empty($arrWs['token_dispositivo']))		?   $arrWs['token_dispositivo']		:null;
			//$rut =  "11724261-7";
			
			if(trim($rut) == '' or trim($rut) == 0){
				$gl_glosa = '<b>Error:</b> rut';
				$cd_error = 'ERROR_RUT';
			}
			else
			{
				
				$fiscalizaciones = $daoDesratizacion->getDesratizaciones($rut);
		            
				$arrTramites = array();
				foreach($fiscalizaciones as $item){
					//Quito la conclusión visita perdida
					foreach($item["desarrollo"]["conclusiones_visita"] as $key => $conclusion){
						if($conclusion["codigo"] == 5){
							unset($item["desarrollo"]["conclusiones_visita"][$key]);
							//reindexo el array
							$item["desarrollo"]["conclusiones_visita"] = array_values($item["desarrollo"]["conclusiones_visita"]);
						}
					}
					$arrTramites[] = $item;
				}


				$arr_fiscalizaciones = array('json' => json_encode($arrTramites));
				/*
				$arr_fiscalizaciones = array('json' => json_encode(array()));
				*/
				$bo_resultado = true;
	            $gl_glosa = "Solicitud procesada con exito";
                $cd_error = "SUCCESS";
		    }
		}

		$respuesta = array(
			'resultado'				=> $bo_resultado,
			'gl_glosa'				=> $gl_glosa, 
			'tipo_error'			=> $cd_error, 
			'version_app' 			=> VERSION_APP, 
			'arr_fiscalizaciones' 	=> $arr_fiscalizaciones
		);

		return $respuesta;
    }

?>