<?php
	//Entrada
	$server->wsdl->addComplexType(
		'getMordedoresRegionInput',
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
	    'getMordedoresRegionOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:boolean'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string'),
			'arr_mordedores'		=> array('arr_mordedores'		, 'type' => 'tns:arrMordedores', 'minOccurs' => 0 , 'maxOccurs' => 1),
	    )
	);

	$server->wsdl->addComplexType(
		'arrMordedores', 
		'complexType', 
		'struct', 
		'all', 
		'',
		array(
		    'mordedoresRegion' => array('mordedoresRegion' , 'type' => 'xsd:string')
        )
	);


	$server->register(  'getMordedoresRegion',
						array('data'	=> 'tns:getMordedoresRegionInput'),
						array('return'	=> 'tns:getMordedoresRegionOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#getMordedoresRegion',
						"rpc", 
						"encoded", 
						''
	);


	function getMordedoresRegion($arrWs){
		$conn =  new MySQL();
        $daoAnimalMordedor = new DAOAnimalMordedor($conn);
        $daoDueno = new DAODueno($conn);
        $daoUsuario = new DAOUsuario($conn);
		$daoErrorLog = new DAOErrorLog($conn);

		$service_name = "getMordedoresRegionRequest";
		$gl_error = '<b>Error:</b> data Incorrecta';
		$cd_error = 'ERROR_DATA_INCORRECTA';
		$respuesta = array('resultado'=>false,'gl_glosa'=>$gl_error, 'tipo_error'=>$cd_error, 'version_app' => VERSION_APP, 'arr_mordedores'=>array());

		if(!empty($arrWs) && is_array($arrWs)){
			$rut 		= (!empty($arrWs['rut']))		? $arrWs['rut']			:null;
			$password 	= (!empty($arrWs['password']))	? $arrWs['password']	:null;
			$appVersion	= (!empty($arrWs['appVersion']))? $arrWs['appVersion']	:null;
			$token_dispositivo 	= (!empty($arrWs['token_dispositivo']))	? $arrWs['token_dispositivo'] :null;
			//$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 1, $service_name);
			
			if(trim($rut) == '' or trim($rut) == 0){
				$gl_error = '<b>Error:</b> rut de usuario requerido.';
				$cd_error = 'ERROR_RUT';
				$respuesta = array('resultado'=>false,'gl_glosa'=>$gl_error, 'tipo_error'=>$cd_error, 'version_app' => VERSION_APP, 'arr_mordedores'=>array());
			}
			else
			{
				$usuario = $daoUsuario->getUsuarioByRut($rut);
				$regiones_usuario = $daoUsuario->getRegionesUsuario($usuario["id_usuario"]);
				$lista_regiones = array();
				foreach ((array)$regiones_usuario as $region) {
					$lista_regiones[] = $region["id_region"];
				}
                $listadoMordedores  = $daoAnimalMordedor->getMordedoresRegion(implode(",", $lista_regiones));

                if(!empty($listadoMordedores)){
	                foreach ($listadoMordedores as &$mordedor) {
	                	$mordedor["id_estado_microchip"] = $daoAnimalMordedor::ESTADO_MICROCHIP_REGISTRADO;
	                	$json_direccion = json_decode($mordedor["json_direccion"]);
	                    $mordedor["gl_direccion"] = $json_direccion->gl_direccion;
	                    $mordedor["gl_direccion_coordenadas"] = $json_direccion->gl_direccion_coordenadas;
	                    $mordedor["gl_direccion_detalles"] = $json_direccion->gl_direccion_detalles;
	                    unset($mordedor["json_direccion"]);

	                    $json_otros_datos = json_decode($mordedor["json_otros_datos"]);
	                    $mordedor["nr_edad"] = $json_otros_datos->nr_edad;
	                    $mordedor["nr_peso"] = $json_otros_datos->nr_peso;
	                    $mordedor["gl_apariencia"] = $json_otros_datos->gl_apariencia;
	                    $mordedor["gl_color_animal"] = $json_otros_datos->gl_color_animal;
	                    unset($mordedor["json_otros_datos"]);

	                    $mordedor["vacunas"] = $mordedor["json_vacuna"];
	                    unset($mordedor["json_vacuna"]);

	                    if(!empty($mordedor["id_dueno"])){
	                    	$dueno_mordedor = $daoDueno->getDuenoMordedor($mordedor["id_dueno"]);
	                    	if(isset($dueno_mordedor)){
	                            $json_contacto = json_decode($dueno_mordedor["json_contacto"], true);
	                            foreach ($json_contacto as $nombre => $valor) {
	                                $dueno_mordedor[$nombre] = $valor;
	                            }
	                            unset($dueno_mordedor["json_contacto"]);
	                            $json_contacto = json_decode($dueno_mordedor["json_direccion"], true);
	                            foreach ($json_contacto as $nombre => $valor) {
	                                $dueno_mordedor[$nombre] = $valor;
	                            }
	                            unset($dueno_mordedor["json_direccion"]);
	                        }
	                    	$mordedor["propietario"] = $dueno_mordedor;
	                    }
	                }
                }

	            $respuesta =   array(
	            		'resultado'=>true,
		            	'gl_glosa'=>'Solicitud procesada con exito.',
		            	'version_app' => VERSION_APP,
		            	'arr_mordedores'=>array(
                            'mordedoresRegion' 	=> json_encode((array)$listadoMordedores)
			            )
	            	);
	            
	            
		        
		    }
		}
		//$daoErrorLog->setLogAuditoria($respuesta, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)$bo_resultado, $service_name_response);
		$conn->cerrar_conexion();

		return $respuesta;
    }

