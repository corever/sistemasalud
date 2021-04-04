<?php

	//Entrada
	$server->wsdl->addComplexType(
		'loadComboValuesInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' 			=> array('rut'			, 'type' => 'xsd:string'),
			'password' 		=> array('password'		, 'type' => 'xsd:string'),
			'token_dispositivo' => array('token_dispositivo' , 'type' => 'xsd:string'),
			'appVersion'    => array('appVersion'	, 'type' => 'xsd:string'),
		)
	);

	// Salida
	$server->wsdl->addComplexType(
	    'loadComboValuesOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:boolean'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string'),
			'arr_comboValues'		=> array('arr_comboValues'		, 'type' => 'tns:arrComboValues', 'minOccurs' => 0 , 'maxOccurs' => 1),
	    )
	);

	$server->wsdl->addComplexType(
		'arrComboValues', 
		'complexType', 
		'struct', 
		'all', 
		'',
		array(
		    'paises' 			 => array('paises'				, 'type' => 'xsd:string'),
		    'regiones' 			 => array('regiones'			, 'type' => 'xsd:string'),
		    'provincias' 		 => array('provincias'			, 'type' => 'xsd:string'),
            'comunas' 			 => array('comunas'				, 'type' => 'xsd:string'),
            'razas' 			 => array('razas'				, 'type' => 'xsd:string'),
			'especies' 			 => array('especies'			, 'type' => 'xsd:string'),
			'estadoAnimal' 		 => array('estadoAnimal'		, 'type' => 'xsd:string'),
			'estadoReproductivo' => array('estadoReproductivo'	, 'type' => 'xsd:string'),
			'duracionInmunidad'  => array('duracionInmunidad'	, 'type' => 'xsd:string'),
			'visitaPerdidaTipo'  => array('visitaPerdidaTipo'	, 'type' => 'xsd:string'),
			'visitaEstado'		 => array('visitaEstado'		, 'type' => 'xsd:string'),
			'animalSintomaTipo'  => array('animalSintomaTipo'	, 'type' => 'xsd:string'),
			'tipoLaboratorio'	 => array('tipoLaboratorio'		, 'type' => 'xsd:string'),
			'animalTamano'	 	 => array('animalTamano'		, 'type' => 'xsd:string'),
			'animalTipoSexo'	 => array('animalTipoSexo'		, 'type' => 'xsd:string'),
			'animalTipoVacuna'	 => array('animalTipoVacuna'	, 'type' => 'xsd:string'),
			'adjuntoTipo'	 	 => array('adjuntoTipo'			, 'type' => 'xsd:string'),
			'animalVacuna'	 	 => array('animalVacuna'		, 'type' => 'xsd:string'),
			'regionUsuario' 	 => array('regionUsuario'		, 'type' => 'xsd:string'),
			'animalVacunaLaboratorios'  => array('animalVacunaLaboratorios'	, 'type' => 'xsd:string')

        )
	);


	$server->register(  'loadComboValues',
						array('data'	=> 'tns:loadComboValuesInput'),
						array('return'	=> 'tns:loadComboValuesOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#loadComboValues',
						"rpc", 
						"encoded", 
						''
	);


	function loadComboValues($arrWs){
        $conn =  new MySQL();
		$daoErrorLog = new DAOErrorLog($conn);
		$daoUsuario = new DAOUsuario($conn);

		$service_name = "loadComboValuesRequest";
		$gl_error = '<b>Error:</b> data Incorrecta';
		$cd_error = 'ERROR_DATA_INCORRECTA';
		$respuesta = array('resultado'=>false,'gl_glosa'=>$gl_error, 'tipo_error'=>$cd_error, 'version_app' => VERSION_APP, 'arr_comboValues'=>array());

		//$daoErrorLog->setLog($arrWs, array(), $service_name);
		if(!empty($arrWs) && is_array($arrWs)){
			$rut 		= (!empty($arrWs['rut']))?$arrWs['rut']:null;
			$password 	= (!empty($arrWs['password']))?$arrWs['password']:null;
			$token_dispositivo = (!empty($arrWs['token_dispositivo']))?$arrWs['token_dispositivo']:null;
			$appVersion	= (!empty($arrWs['appVersion']))?$arrWs['appVersion']:null;
			
			if(trim($rut) == '' or trim($rut) == 0){
				$gl_error = '<b>Error:</b> rut de usuario requerido.';
				$cd_error = 'ERROR_RUT';
				$respuesta = array('resultado'=>false,'gl_glosa'=>$gl_error, 'tipo_error'=>$cd_error, 'version_app' => VERSION_APP, 'arr_comboValues'=>array());
			}
			else
			{
				try{
					$daoDireccionPais = new DAODireccionPais($conn);
					$paises = $daoDireccionPais->getListaParaCombo();

					$daoDireccionRegion = new DAODireccionRegion($conn);
					$regiones = $daoDireccionRegion->getListaParaCombo();
					
					$daoDireccionProvincia = new DAODireccionProvincia($conn);
					$provincias = $daoDireccionProvincia->getListaParaCombo();

					$daoDireccionComuna = new DAODireccionComuna($conn);
					$comunas = $daoDireccionComuna->getListaParaCombo();

					$daoAnimalRaza = new DAOAnimalRaza($conn);
					$razas = $daoAnimalRaza->getListaParaCombo();

					$daoAnimalEspecie = new DAOAnimalEspecie($conn);
					$especies = $daoAnimalEspecie->getListaParaCombo();

					$daoAnimalEstado = new DAOAnimalEstado($conn);
					$estadoAnimal = $daoAnimalEstado->getListaParaCombo();

					$daoAnimalEstadoProductivo = new DAOAnimalEstadoProductivo($conn);
					$estadoReproductivo = $daoAnimalEstadoProductivo->getListaParaCombo();

					$daoTipoDuracionInmunidad = new DAOTipoDuracionInmunidad($conn);
					$duracionInmunidad = $daoTipoDuracionInmunidad->getListaParaCombo();

					$daoVisitaPerdidaTipo = new DAOVisitaPerdidaTipo($conn);
					$visitaPerdidaTipo = $daoVisitaPerdidaTipo->getListaParaCombo();

					$daoVisitaEstado = new DAOVisitaEstado($conn);
					$visitaEstado = $daoVisitaEstado->getListaParaCombo();

					$daoAnimalSintomaTipo = new DAOVisitaAnimalSintomaTipo($conn);
					$animalSintomaTipo = $daoAnimalSintomaTipo->getListaParaCombo();

					$daoAnimalVacunaLaboratorio = new DAOAnimalVacunaLaboratorio($conn);
					$animalVacunaLaboratorios = $daoAnimalVacunaLaboratorio->getListaParaCombo();

					$daoAnimalVacuna = new DAOAnimalVacuna($conn);
					$animalVacuna = $daoAnimalVacuna->getListaParaCombo();

					$daoTipoLaboratorio = new DAOTipoLaboratorio($conn);
					$tipoLaboratorio = $daoTipoLaboratorio->getListaParaCombo();

					$daoAnimalSexo = new DAOAnimalSexo($conn);
					$animalTipoSexo = $daoAnimalSexo->getListaParaCombo();

					$daoTipoVacuna = new DAOTipoVacuna($conn);
					$animalTipoVacuna = $daoTipoVacuna->getListaParaCombo();

					$daoAdjuntoTipo = new DAOAdjuntoTipo($conn);
					$adjuntoTipo = $daoAdjuntoTipo->getListaParaCombo();

					$daoAnimalTamano = new DAOAnimalTamano($conn);
					$animalTamano = $daoAnimalTamano->getListaParaCombo();

					$usuario = $daoUsuario->getUsuarioLogin($rut,$password);
					if(!is_null($usuario) && $daoUsuario->validarFiscalizador($usuario['id_usuario']))
					{	               
						$regiones_usuario = $daoUsuario->getRegionesUsuario($usuario["id_usuario"]);
						$reg =	$regiones_usuario[0]["id_region"];
					}else{
						$reg = "0";
					}

		            $respuesta = array(
		            		'resultado'=>true,
			            	'gl_glosa'=>'Solicitud procesada con exito.',
			            	'version_app' => VERSION_APP,
			            	'arr_comboValues'=> array(
			            		'paises' 				=> json_encode((array)$paises),
			            		'regiones' 				=> json_encode((array)$regiones),
			            		'provincias'			=> json_encode((array)$provincias),
	                            'comunas' 				=> json_encode((array)$comunas),
	                            'razas' 				=> json_encode((array)$razas),
								'especies' 				=> json_encode((array)$especies),
								'estadoAnimal' 			=> json_encode((array)$estadoAnimal),
								'estadoReproductivo' 	=> json_encode((array)$estadoReproductivo),
								'duracionInmunidad' 	=> json_encode((array)$duracionInmunidad),
								'visitaEstado' 			=> json_encode((array)$visitaEstado),
								'visitaPerdidaTipo' 	=> json_encode((array)$visitaPerdidaTipo),
								'animalSintomaTipo' 	=> json_encode((array)$animalSintomaTipo),
								'tipoLaboratorio'		=> json_encode((array)$tipoLaboratorio),
								'animalTamano'			=> json_encode((array)$animalTamano),
								'animalTipoSexo'		=> json_encode((array)$animalTipoSexo),
								'animalTipoVacuna'		=> json_encode((array)$animalTipoVacuna),
								'adjuntoTipo'			=> json_encode((array)$adjuntoTipo),
								'animalVacuna'		 	=> json_encode((array)$animalVacuna),
								'regionUsuario'		 	=> $reg,
								'animalVacunaLaboratorios' 	=> json_encode((array)$animalVacunaLaboratorios),
				            )
		            	);
		        } catch (Exception $e){
		            file_put_contents('php://stderr', PHP_EOL . print_r($e->getMessage(), TRUE). PHP_EOL, FILE_APPEND);
		            $error_sql = array("error_sql"=>$conn->mensaje_error,"query"=>$conn->query_error);
		            $daoErrorLog->setLogAuditoria($error_sql, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)false, $service_name_response);
		            $gl_error = '<b>Error:</b> No se lograron obtener los datos de los combos.';
					$cd_error = 'ERROR_DATA_INCORRECTAS';
					$respuesta = array(
							'resultado'=>false,
							'gl_glosa'=>$gl_error, 
							'tipo_error'=>$cd_error, 
							'version_app' => VERSION_APP,
							'arr_comboValues'=>array()
						);
		        }
		    }
		}

		//$daoErrorLog->setLog($arrWs, $respuesta, $service_name);
		$conn->cerrar_conexion();

		return $respuesta;
    }

