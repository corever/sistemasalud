<?php
	//Entrada
	$server->wsdl->addComplexType(
		'enviarFiscalizacionMordedoresInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' 		 				=> array('rut' 					, 'type' => 'xsd:string'),
			'password' 	 				=> array('password' 			, 'type' => 'xsd:string'),
			'token_dispositivo'		 	=> array('token_dispositivo'	, 'type' => 'xsd:string'),
			'datos_json'		 		=> array('datos_json'	 		, 'type' => 'xsd:string'),
			'cantidad_adjuntos'			=> array('cantidad_adjuntos'	, 'type' => 'xsd:int'),
			'appVersion'              	=> array('appVersion'			, 'type' => 'xsd:string'),
		)
	);

	// Salida
	$server->wsdl->addComplexType(
	    'enviarFiscalizacionMordedoresOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:string'),
		    'id_fiscalizacion'		=> array('id_fiscalizacion'		, 'type' => 'xsd:string'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string')
	    )
	);

	$server->register(  'enviarFiscalizacionMordedores',
						array('data'	=> 'tns:enviarFiscalizacionMordedoresInput'),
						array('return'	=> 'tns:enviarFiscalizacionMordedoresOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#enviarFiscalizacionMordedores',
						"rpc", 
						"encoded", 
						''
	);


	function enviarFiscalizacionMordedores($arrWs){
		$conn			= new MySQL();
		$daoVisita		= new DAOVisita($conn);
		$daoUsuario		= new DAOUsuario($conn);
		$daoErrorLog	= new DAOErrorLog();	
		
		$service_name			= "enviarFiscalizacionMordedoresRequest";
		$service_name_response	= "enviarFiscalizacionMordedoresResponse";
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
			$cantidad_adjuntos    = (!empty($arrWs['cantidad_adjuntos']))		? $arrWs['cantidad_adjuntos']:0;
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
		        	$visita	= $daoVisita->getByTokenFiscalizacion($_token_fiscalizacion);

	            	if(empty($visita)) {
	            		$guardado_datos_exitosoado_inspeccion	= validar($datos_json->id_visita_estado,"numero"); 

	            		if($guardado_datos_exitosoado_inspeccion == $daoVisita::ESTADO_VISITA_REALIZADA || $guardado_datos_exitosoado_inspeccion == $daoVisita::ESTADO_VISITA_PERDIDA){
			            	/***********INICIANDO VARIABLES*************/
					        $id_tipo_visita_resultado	= $daoVisita::RESULTADO_SIN_DATOS;
					        $id_visita		= null;
			            	$id_usuario		= $usuario["id_usuario"];
					        $fecha_actual	= date("Y-m-d H:i:s");
					        $_conexion		= $conn->conexion;
					        //se desactiva autocommit
					        mysqli_autocommit($_conexion, FALSE);
					        //mysqli_begin_transaction($_conexion);
					        $_conexion->begin_transaction();
						    /*********** FIN INICIADO VARIABLES *************/   
						    
							try{
				            	// CREO UNA NUEVA VISITA
				            	$gl_origen = "APP";
				            	if($token_dispositivo == 'WEB' ){
				            		$gl_origen = 'Informada Web';
				            	}
				            	elseif($token_dispositivo == 'REGULARIZAR' ){
				            		$gl_origen = 'Regularizada';
				            	}

				            	 
		            			$parametros_visita = array(
				            		"id_expediente"			=> $datos_json->id_expediente,
						            "id_fiscalizador"		=> $usuario["id_usuario"],
									"id_visita_estado"		=> $guardado_datos_exitosoado_inspeccion,
									"gl_observacion_visita"	=> $datos_json->comentarios_inspeccion,
									"fc_visita"				=> $datos_json->fecha_inspeccion,
									"gl_app_version" 		=> $appVersion, 
									"gl_token_fiscalizacion"=> $_token_fiscalizacion,
									"gl_token_dispositivo"	=> $token_dispositivo,
									"gl_origen"				=> $gl_origen
			            		);
				            	if(isset($datos_json->bo_volver_a_visitar) && $datos_json->bo_volver_a_visitar == true){
				            		$parametros_visita["bo_volver_a_visitar"] = $daoVisita::VOLVER_VISITAR_SI;
				            	}else{
				                	$parametros_visita["bo_volver_a_visitar"] = $daoVisita::VOLVER_VISITAR_NO;
				            	}
			            		$id_visita = $daoVisita->insert($parametros_visita, $datos_json, $usuario["id_usuario"]);
							
								//SI LA VISITA SE CREO CORRECTAMENTE INSERTO LOS OTROS DATOS
				            	if(!empty($id_visita) && is_numeric($id_visita)){
				            		$parametros_visita = array();
					            	
							        /**********************VISITA REALIZADA*********************/
						        	if($guardado_datos_exitosoado_inspeccion == $daoVisita::ESTADO_VISITA_REALIZADA){
						        		$daoAnimalMordedor	= new DAOAnimalMordedor($conn);
						        		
						        		/**********************VISITA CON MORDEDORES Y NO SE NIEGA*********************/
					                	if($datos_json->bo_se_niega_visita == 0 && isset($datos_json->mordedores) && is_array($datos_json->mordedores)){
							                foreach ($datos_json->mordedores as $mordedor) {
							                	/**************MORDEDOR NO ENCONTRADO****************/
							                	if($mordedor->id_animal_estado == $daoAnimalMordedor::ESTADO_ANIMAL_NO_ENCONTRADO || $mordedor->bo_se_niega_visita == 1)
							                	{
							                		$datos_mordedor	= array(
							                            "id_animal_estado"          => $mordedor->id_animal_estado,
							                            "id_animal_grupo"         	=> $daoAnimalMordedor::GRUPO_ANIMAL_PERRO_GATO,
							                            "id_animal_especie"         => $mordedor->id_animal_especie,
							                            "id_animal_raza"            => $mordedor->id_animal_raza,
							                            "id_animal_tamano"          => $mordedor->id_animal_tamano,
							                            "id_comuna"                 => $mordedor->id_comuna_animal,
							                            "id_region"                 => $mordedor->id_region_animal,
							                            "bo_vive_con_dueno"         => $mordedor->bo_vive_con_dueno,
							                            "gl_direccion"              => $mordedor->gl_direccion,
							                            "gl_direccion_coordenadas"  => $mordedor->gl_direccion_coordenadas,
							                            "gl_direccion_detalles"     => $mordedor->gl_direccion_detalles,
							                            "gl_nombre"                 => $mordedor->gl_nombre,
							                            "gl_apariencia"             => $mordedor->gl_apariencia,
								                        "gl_color_animal"           => $mordedor->gl_color_animal,
								                        "bo_microchipInstalado"			=> $mordedor->bo_microchipInstalado,//indica si el microchip estaba instalado antes de la visita. 1:sí 2:NO
														"instalador_microchip"			=> $mordedor->instalador_microchip,//quién instaló el microchip dato : { id: , nombre: ''}
														"gl_otro_instalador_microchip"	=> $mordedor->gl_otro_instalador_microchip,//si escoge la opción (otro) se especifica
														"gl_otro_vigencia"	=> $mordedor->gl_otro_vigencia,//bo_antirrabica_vigente = "Otros" (id=4) => gl_otro_vigencia.
							                        );

							                        
							                        $datos_mordedor["id_usuario"]	= $id_usuario;
							                        $id_mordedor					= $daoAnimalMordedor->insert($datos_mordedor);

							                        $daoExpedienteMordedor	= new DAOExpedienteMordedor($conn);
								                    $folio_mordedor			= $daoExpedienteMordedor->getByFolio($mordedor->gl_folio_mordedor);
								                    //$id_expediente_mordedor_estado = ($mordedor->id_animal_estado == $daoAnimalMordedor::ESTADO_ANIMAL_NO_ENCONTRADO)?$daoVisita::ESTADO_VISITA_INFORMADA:$daoVisita::ESTADO_VISITA_PERDIDA;
								                    $id_expediente_mordedor_estado = $daoVisita::ESTADO_VISITA_INFORMADA;
								                    if(!empty($folio_mordedor)){
								                    	$datos_folio_mordedor	= array(
								                    			"id_mordedor"					=>  $id_mordedor,
								                    			"id_expediente_mordedor_estado"	=> $id_expediente_mordedor_estado,
								                    			"id_usuario_actualiza"			=> $id_usuario,
						                        				"fc_actualiza"					=> $fecha_actual
								                    		);
								                    	$daoExpedienteMordedor->update($datos_folio_mordedor, $folio_mordedor["id_expediente_mordedor"]);
								                    }

								                    $daoVisitaAnimalMordedor= new DAOVisitaAnimalMordedor($conn);
								                    $json_mordedor			= $datos_mordedor;
								                    $json_mordedor["id_mordedor_interno"]	= $mordedor->id;
								                    $motivo_perdida			= ($mordedor->bo_se_niega_visita == 1)? 0 : $daoVisita::MOTIVO_NO_ENCONTRADO;
								                    $gl_observacion_visita	= ($mordedor->bo_se_niega_visita == 1)? $mordedor->gl_observaciones_niega_visita : $mordedor->gl_justificacion_animal_no_encontrado;
								                    
								                    $datos_visita_mordedor	= array(
								                            "id_visita"                 => $id_visita,
								                            "id_mordedor"               => $id_mordedor,
								                            "id_animal_estado"          => $mordedor->id_animal_estado,
								                            "bo_vive_con_dueno"         => $mordedor->bo_vive_con_dueno,
								                            "json_mordedor"             => $json_mordedor,
								                            "json_dueno"                => $mordedor->propietario,
								                            "gl_observacion_visita"     => $gl_observacion_visita,
								                            "id_region_mordedor"        => $mordedor->id_region_animal,
								                            "id_visita_estado"          => ($mordedor->bo_se_niega_visita == 1)? $daoVisita::ESTADO_VISITA_REALIZADA : $daoVisita::ESTADO_VISITA_PERDIDA,
															"id_tipo_visita_perdida"    => $motivo_perdida,
															"id_tipo_visita_resultado"  => ($mordedor->bo_se_niega_visita == 1)? $daoVisita::RESULTADO_VISITA_SE_NIEGA : 0,
								                        );

								                    //SE NIEGA VISITA
								                    if($mordedor->bo_se_niega_visita == 1 && $mordedor->bo_inicia_sumario == 1){
									            		$datos_visita_mordedor["bo_sumario"]	= $mordedor->bo_inicia_sumario;
									            		$datos_visita_mordedor["fc_descargos"]	= $mordedor->fc_descargos;
								                    }
								                    
								                    $daoVisitaAnimalMordedor->insert($datos_visita_mordedor,$id_usuario);
							                	}
							                	else{
							                		/**************MORDEDOR ENCONTRADO****************/
							                		if($mordedor->bo_sintomas_rabia == 1){
			                							$parametros_visita["bo_sintoma_rabia"] = 1;
			                						}

								                    /**********************DUEÑO*********************/
								                    $id_dueno = null;
								                    if(isset($mordedor->propietario) && !empty($mordedor->propietario) || $mordedor->bo_conocido == 1){
								                        $daoDueno	= new DAODueno($conn);
								                        if(isset($mordedor->propietario->gl_rut) && !empty($mordedor->propietario->gl_rut)){
								                        	$dueno	= $daoDueno->getByRut($mordedor->propietario->gl_rut);
								                        }
								                        $json_direccion	= array(
												            "direccion"					=> $datos_dueno['direccion'],
												            "referencia_direccion"		=> $datos_dueno['referencia_direccion'],
												            "departamento_direccion"	=> $datos_dueno['departamento_direccion']
												            );

												        $json_contacto	= array('telefono_propietario' => $datos_dueno['telefono_propietario']);
								                        if(!empty($mordedor->propietario->id_propietario) || !empty($dueno)){
								                        	$datos_dueno = array(
								                                'gl_nombre'				=> validar($mordedor->propietario->gl_nombre, "string"),
								                                'gl_apellido_paterno'	=> validar($mordedor->propietario->gl_apellido_paterno, "string"),
								                                'gl_apellido_materno'	=> validar($mordedor->propietario->gl_apellido_materno, "string"),
								                                'bo_rut_informado'		=> validar($mordedor->propietario->bo_rut_informado, "string"),
								                                'bo_extranjero'			=> validar($mordedor->propietario->bo_extranjero, "numero"),
								                                'gl_rut'				=> validar($mordedor->propietario->gl_rut, "string"),
								                                'gl_pasaporte'			=> validar($mordedor->propietario->gl_pasaporte, "string"),
								                                'id_region'				=> validar($mordedor->propietario->id_region, "numero"),
								                                'id_comuna'				=> validar($mordedor->propietario->id_comuna, "numero"),
								                                'gl_email'				=> validar($mordedor->propietario->gl_email, "string"),
								                                'json_contacto'			=> addslashes(json_encode($json_contacto, JSON_UNESCAPED_UNICODE)),
																'json_direccion'		=> addslashes(json_encode($json_direccion, JSON_UNESCAPED_UNICODE)),
								                                'id_usuario_actualiza'	=> $id_usuario,
								                                'fc_actualiza'			=> $fecha_actual
								                            );
								                            if(!empty($mordedor->propietario->id_propietario)){
								                            	$id_dueno	= $mordedor->propietario->id_propietario;
								                            }
								                            else{
								                            	$id_dueno								= $dueno["id_dueno"];
								                            	$mordedor->propietario->id_propietario	= $dueno["id_dueno"];
								                            }
								                            $datos_dueno["fc_actualiza"]			= $fecha_actual;
								                            $datos_dueno["id_usuario_actualiza"]	= $id_usuario;        
								                            $daoDueno->update($datos_dueno, $id_dueno);
								                        }else{
								                        	$datos_dueno	= array(
								                                'gl_nombre'              => $mordedor->propietario->gl_nombre,
								                                'gl_apellido_paterno'    => $mordedor->propietario->gl_apellido_paterno,
								                                'gl_apellido_materno'    => $mordedor->propietario->gl_apellido_materno,
								                                'bo_rut_informado'       => $mordedor->propietario->bo_rut_informado,
								                                'bo_extranjero'          => $mordedor->propietario->bo_extranjero,
								                                'gl_rut'                 => $mordedor->propietario->gl_rut,
								                                'gl_pasaporte'           => $mordedor->propietario->gl_pasaporte,
								                                'id_region'              => $mordedor->propietario->id_region,
								                                'id_comuna'              => $mordedor->propietario->id_comuna,
								                                'gl_email'               => $mordedor->propietario->gl_email,
								                                'telefono_propietario'   => $mordedor->propietario->telefono_propietario,
								                                'direccion'              => $mordedor->propietario->direccion,
								                                'referencia_direccion'   => $mordedor->propietario->referencia_direccion,
								                                'departamento_direccion' => $mordedor->propietario->departamento_direccion,
								                                'id_usuario'             => $id_usuario
								                            );
								                            if(!empty($mordedor->propietario->gl_rut)){
								                            	$datos_dueno['gl_token'] = generaTokenUsuario($mordedor->propietario->gl_rut);
								                            }
								                            $id_dueno = $daoDueno->insert($datos_dueno);
								                            $mordedor->propietario->id_propietario = $id_dueno;
								                        }
								                    }

								                    /*********************MORDEDOR*********************/ 
								                    $mordedor_microchip = null;
								                    if(!empty(trim($mordedor->gl_microchip))){
								                    	$mordedor_microchip	= $daoAnimalMordedor->getByMicrochip(validar($mordedor->gl_microchip, "string"));
								                    }
								                    if((isset($mordedor->id_mordedor) && !empty($mordedor->id_mordedor)) ||
								                       (!empty($mordedor_microchip) && isset($mordedor_microchip["id_mordedor"]))){
								                    	$json_otros_datos	= array(
											                "nr_edad"			=> $mordedor->nr_edad,
											                "nr_edad_meses"		=> $mordedor->nr_edad_meses,
											                "nr_peso"			=> $mordedor->nr_peso,
											                "gl_apariencia"		=> $mordedor->gl_apariencia,
											                "gl_color_animal"	=> $mordedor->gl_color_animal,
											                "gl_motivo_muerte"	=> $mordedor->gl_motivo_muerte,
											                "gl_motivo_otro"	=> $mordedor->gl_motivo_otro,
											                //indica si el microchip estaba instalado antes de la visita. 1:sí 2:NO
											                "bo_microchipInstalado"			=> $mordedor->bo_microchipInstalado,
											                //quién instaló el microchip dato : { id: , nombre: ''}
															"instalador_microchip"			=> $mordedor->instalador_microchip,
															//si escoge la opción (otro) se especifica
															"gl_otro_instalador_microchip"	=> $mordedor->gl_otro_instalador_microchip,
															"gl_otro_vigencia"	=> $mordedor->gl_otro_vigencia,//bo_antirrabica_vigente = "Otros" (id=4) => gl_otro_vigencia.
											            );

											        	$json_direccion	= array(
											                "gl_direccion"				=> $mordedor->gl_direccion,
											                "gl_direccion_coordenadas"	=> $mordedor->gl_direccion_coordenadas,
											                "gl_direccion_detalles"		=> $mordedor->gl_direccion_detalles
											            );

											            /**
												         * [bo_antirrabica_vigente No es Boolean, es un ID]
												         * @TODO: agregar gl_otro_vigente
												         */
								                    	$datos_mordedor = array(
								                            "id_animal_estado"          => validar($mordedor->id_animal_estado, "numero"),
								                            "bo_antirrabica_vigente"	=> validar($mordedor->bo_antirrabica_vigente, "numero"),
								                            "bo_necesita_vacuna"        => validar($mordedor->bo_necesita_vacuna, "numero"),
								                            "id_animal_grupo"         	=> $daoAnimalMordedor::GRUPO_ANIMAL_PERRO_GATO,
								                            "id_animal_especie"         => validar($mordedor->id_animal_especie, "numero"),
								                            "id_animal_raza"            => validar($mordedor->id_animal_raza, "numero"),
								                            "id_animal_sexo"            => validar($mordedor->id_animal_sexo, "numero"),
								                            "id_animal_tamano"          => validar($mordedor->id_animal_tamano, "numero"),
								                            "id_comuna"                 => validar($mordedor->id_comuna_animal, "numero"),
								                            "id_region"                 => validar($mordedor->id_region_animal, "numero"),
								                            "bo_vive_con_dueno"         => validar($mordedor->bo_vive_con_dueno, "numero"),
								                            "bo_callejero"         		=> validar($mordedor->bo_callejero, "numero"),
								                            "gl_nombre"                 => validar($mordedor->gl_nombre, "string"),
								                            "fc_vacuna"                 => validar($mordedor->fc_vacuna, "date"),
								                            "fc_vacuna_expira"          => validar($mordedor->fc_vacuna_expira, "date"),
								                            "bo_eutanasiado"            => validar($mordedor->bo_eutanasiado, "numero"),
								                            "fc_eutanasia"              => validar($mordedor->fc_muerte, "date"),
								                            "bo_rabia"                  => validar($mordedor->bo_sintomas_rabia, "numero"),
								                            "bo_mordedor_habitual"      => validar($mordedor->bo_mordedor_habitual, "numero"),
								                            "fc_desparacitado"          => validar($mordedor->fc_desparacitado, "date"),
								                            "fc_microchip"              => validar($mordedor->fc_microchip, "date"),
								                            "gl_otra_especie"           => validar($mordedor->gl_otra_especie, "string"),
								                            "id_estado_productivo"      => validar($mordedor->id_estado_productivo, "numero"),
								                            "gl_otra_raza"              => validar($mordedor->gl_otra_raza, "string"),
								                            "id_duracion_inmunidad"		=> validar($mordedor->id_duracion_inmunidad, "numero"),
								                            "json_vacuna"               => json_encode($mordedor->vacunas, JSON_UNESCAPED_UNICODE),
								                            "json_otros_datos"			=> json_encode($json_otros_datos, JSON_UNESCAPED_UNICODE),
															"json_direccion"			=> json_encode($json_direccion, JSON_UNESCAPED_UNICODE),
								                        );
								                        if($mordedor->id_animal_estado == $daoAnimalMordedor::ESTADO_ANIMAL_MUERTO){
								                        	$datos_mordedor["fc_muerte"] = validar($mordedor->fc_muerte, "date");
								                        }
								                        $id_mordedor							= (!empty($mordedor->id_mordedor)) ? $mordedor->id_mordedor : $mordedor_microchip["id_mordedor"];
								                        $datos_mordedor["fc_actualiza"]			= $fecha_actual;
								                        $datos_mordedor["id_usuario_actualiza"]	= $id_usuario;  
								                        $datos_mordedor["nr_cantidad_casos"]	= ((int)$mordedor->nr_cantidad_casos)+1;  
								                        $datos_mordedor["id_dueno"]				= $id_dueno;
								                        $daoAnimalMordedor->update($datos_mordedor, $id_mordedor);
								                    }
								                    else{
								                    	/** este json se arma en el insert */
								                    	/*$json_otros_datos	= array(
											                "nr_edad"			=> $mordedor->nr_edad,
											                "nr_edad_meses"		=> $mordedor->nr_edad_meses,
											                "nr_peso"			=> $mordedor->nr_peso,
											                "gl_apariencia"		=> $mordedor->gl_apariencia,
											                "gl_color_animal"	=> $mordedor->gl_color_animal,
											                "gl_motivo_muerte"	=> $mordedor->gl_motivo_muerte,
											                "gl_motivo_otro"	=> $mordedor->gl_motivo_otro,
											                //indica si el microchip estaba instalado antes de la visita. 1:sí 2:NO
											                "bo_microchipInstalado"			=> $mordedor->bo_microchipInstalado,
											                //quién instaló el microchip dato : { id: , nombre: ''}
															"instalador_microchip"			=> json_decode(json_encode($mordedor->instalador_microchip, JSON_UNESCAPED_UNICODE),true),
															//si escoge la opción (otro) se especifica
															"gl_otro_instalador_microchip"	=> $mordedor->gl_otro_instalador_microchip,
															"gl_otro_vigencia"	=> $mordedor->gl_otro_vigencia,//bo_antirrabica_vigente = "Otros" (id=4) => gl_otro_vigencia.
											            );*/

								                    	/**
												         * [bo_antirrabica_vigente No es Boolean, es un ID]
												         * * @TODO: agregar gl_otro_vigente
												         */
								                    	$datos_mordedor = array(
								                    		//Parametros para json_otros_atos
								                    		"nr_edad"			=> $mordedor->nr_edad,
											                "nr_edad_meses"		=> $mordedor->nr_edad_meses,
											                "nr_peso"			=> $mordedor->nr_peso,
											                "gl_apariencia"		=> $mordedor->gl_apariencia,
											                "gl_color_animal"	=> $mordedor->gl_color_animal,
											                "gl_motivo_muerte"	=> $mordedor->gl_motivo_muerte,
											                "gl_motivo_otro"	=> $mordedor->gl_motivo_otro,
											                //indica si el microchip estaba instalado antes de la visita. 1:sí 2:NO
											                "bo_microchipInstalado"			=> $mordedor->bo_microchipInstalado,
											                //quién instaló el microchip dato : { id: , nombre: ''}
															"instalador_microchip"			=> json_decode(json_encode($mordedor->instalador_microchip, JSON_UNESCAPED_UNICODE),true),
															//si escoge la opción (otro) se especifica
															"gl_otro_instalador_microchip"	=> $mordedor->gl_otro_instalador_microchip,
															"gl_otro_vigencia"	=> $mordedor->gl_otro_vigencia,//bo_antirrabica_vigente = "Otros" (id=4) => gl_otro_vigencia.
															//Parametros para insert
								                            "id_animal_estado"          => $mordedor->id_animal_estado,
								                            "bo_antirrabica_vigente"    => $mordedor->bo_antirrabica_vigente,
								                            "bo_necesita_vacuna"        => $mordedor->bo_necesita_vacuna,
								                            "id_animal_grupo"         	=> $daoAnimalMordedor::GRUPO_ANIMAL_PERRO_GATO,
								                            "id_animal_especie"         => $mordedor->id_animal_especie,
								                            "id_animal_raza"            => $mordedor->id_animal_raza,
								                            "id_animal_sexo"            => $mordedor->id_animal_sexo,
								                            "id_animal_tamano"          => $mordedor->id_animal_tamano,
								                            "id_comuna"                 => $mordedor->id_comuna_animal,
								                            "id_region"                 => $mordedor->id_region_animal,
								                            "bo_vive_con_dueno"         => $mordedor->bo_vive_con_dueno,
								                            "bo_callejero"         		=> $mordedor->bo_callejero,
								                            "gl_nombre"                 => $mordedor->gl_nombre,
								                            "gl_microchip"              => $mordedor->gl_microchip,
								                            "id_estado_microchip"		=> $mordedor->id_estado_microchip,
								                            "fc_vacuna"                 => $mordedor->fc_vacuna,
								                            "fc_vacuna_expira"          => $mordedor->fc_vacuna_expira,
								                            "bo_eutanasiado"            => $mordedor->bo_eutanasiado,
								                            "fc_eutanasia"              => $mordedor->fc_muerte,
								                            "bo_rabia"                  => $mordedor->bo_sintomas_rabia,
								                            "bo_mordedor_habitual"      => $mordedor->bo_mordedor_habitual,
								                            "fc_desparacitado"          => $mordedor->fc_desparacitado,
								                            "fc_microchip"              => $mordedor->fc_microchip,
								                            "gl_otra_especie"           => $mordedor->gl_otra_especie,
								                            "id_estado_productivo"      => $mordedor->id_estado_productivo,
								                            "gl_otra_raza"              => $mordedor->gl_otra_raza,
								                            "nr_edad"                   => $mordedor->nr_edad,
								                            "nr_edad_meses" 			=> $mordedor->nr_edad_meses,
								                            "nr_peso"                   => $mordedor->nr_peso,
								                            "gl_apariencia"             => $mordedor->gl_apariencia,
								                            "gl_color_animal"           => $mordedor->gl_color_animal,
								                            "gl_direccion"              => $mordedor->gl_direccion,
								                            "gl_direccion_coordenadas"  => $mordedor->gl_direccion_coordenadas,
								                            "gl_direccion_detalles"     => $mordedor->gl_direccion_detalles,
								                            "id_duracion_inmunidad"     => $mordedor->id_duracion_inmunidad,
								                            "json_vacuna"               => json_encode($mordedor->vacunas, JSON_UNESCAPED_UNICODE),
								                            "gl_motivo_muerte" 		=> $mordedor->gl_motivo_muerte,
								                            "gl_motivo_otro" 		=> $mordedor->gl_motivo_otro,
								                            "json_otros_datos"		=> json_encode($json_otros_datos, JSON_UNESCAPED_UNICODE)
								                        );
								                        if($mordedor->id_animal_estado == $daoAnimalMordedor::ESTADO_ANIMAL_MUERTO){
								                        	$datos_mordedor["fc_muerte"] = $mordedor->fc_muerte;
								                        }
								                        $datos_mordedor["id_dueno"]		= $id_dueno;
								                        $datos_mordedor["id_usuario"]	= $id_usuario;

								                        $id_mordedor = $daoAnimalMordedor->insert($datos_mordedor);
								                    }

								                    /***************EXPEDIENTE MORDEDOR******************/ 
								                    $daoExpedienteMordedor	= new DAOExpedienteMordedor($conn);
								                    $folio_mordedor			= $daoExpedienteMordedor->getByFolio($mordedor->gl_folio_mordedor);
								                    if(!empty($folio_mordedor)){
								                    	$datos_folio_mordedor	= array(
								                    			"id_mordedor"					=> $id_mordedor,
								                    			"id_expediente_mordedor_estado"	=> $daoVisita::ESTADO_VISITA_INFORMADA,
								                    			"id_usuario_actualiza"			=> $id_usuario,
						                        				"fc_actualiza"					=> $fecha_actual
								                    		);
								                    	$daoExpedienteMordedor->update($datos_folio_mordedor, $folio_mordedor["id_expediente_mordedor"]);
								                    }

								                    /***************VISITA MORDEDOR****************/
								                    $daoVisitaAnimalMordedor		= new DAOVisitaAnimalMordedor($conn);
								                    $json_mordedor = $datos_mordedor;
								                    $json_mordedor["id_mordedor_interno"]	= $mordedor->id;
								                    $json_mordedor["id_mordedor"]	= $id_mordedor;
								                    $json_mordedor["json_vacuna"]	= $mordedor->vacunas;
								                    $id_tipo_visita_resultado		= ($mordedor->bo_sintomas_rabia == 1) ? $daoVisita::RESULTADO_PRESENTA_SINTOMAS_RABIA : $daoVisita::RESULTADO_NO_PRESENTA_SINTOMAS_RABIA;

								                    /**
											         * [bo_antirrabica_vigente No es Boolean, es un ID]
											         * * @TODO: agregar gl_otro_vigente
											         */
                                                    //Por json encode dentro de query y addslashes
                                                    $json_mordedor['json_otros_datos'] = json_decode($json_mordedor['json_otros_datos']);
                                                    
								                    $datos_visita_mordedor			= array(
								                            "id_visita"                 =>  $id_visita,
								                            "id_mordedor"               =>  $id_mordedor,
								                            "id_dueno"                  =>  $id_dueno,
								                            "id_animal_estado"          =>  $mordedor->id_animal_estado,
								                            "gl_microchip"              =>  $mordedor->gl_microchip,
								                            "id_estado_microchip"       =>  $mordedor->id_estado_microchip,
								                            "bo_vive_con_dueno"         =>  $mordedor->bo_vive_con_dueno,
								                            "bo_callejero"         		=>  $mordedor->bo_callejero,
								                            "id_estado_productivo"      =>  $mordedor->id_estado_productivo,
								                            "bo_antirrabica_vigente"    =>  $mordedor->bo_antirrabica_vigente,
								                            "json_mordedor"             =>  $json_mordedor,
								                            "json_dueno"                =>  $mordedor->propietario,
								                            "json_tipo_sintoma"         =>  $mordedor->tipos_sintoma,
								                            "gl_descripcion"            =>  $mordedor->gl_descripcion,
								                            "fc_eutanasia"              =>  $mordedor->fc_muerte,
								                            "id_tipo_visita_resultado"  =>  $id_tipo_visita_resultado,
								                            "id_region_mordedor"        =>  $mordedor->id_region_animal,
								                            "id_visita_estado"			=>	$daoVisita::ESTADO_VISITA_REALIZADA,
								                        );
								                    $daoVisitaAnimalMordedor->insert($datos_visita_mordedor,$id_usuario);

								                    /******************VACUNAS MORDEDOR*****************/  
								                    if(($mordedor->id_animal_estado == $daoAnimalMordedor::ESTADO_ANIMAL_VIVO && $mordedor->bo_sintomas_rabia == 0)){
								                        if(!empty($mordedor->vacunas) && is_array($mordedor->vacunas)){
								                            $daoVisitaAnimalVacuna	= new DAOVisitaAnimalVacuna($conn);
								                            foreach ($mordedor->vacunas as $vacuna) {
								                                $datos_vacuna	= array(
								                                    'id_tipo_vacuna'            => $vacuna->id_tipo_vacuna,
								                                    'gl_microchip'              => $vacuna->gl_microchip,
								                                    'gl_certificado_vacuna'     => $vacuna->gl_certificado_vacuna,
								                                    'gl_numero_serie_vacuna'	=> $vacuna->gl_numero_serie_vacuna,
								                                    'id_laboratorio'            => $vacuna->id_laboratorio,
								                                    'gl_laboratorio'            => $vacuna->gl_laboratorio,
								                                    'gl_medicamento'            => $vacuna->gl_medicamento,
								                                    'fc_vacunacion'             => $mordedor->fc_vacuna,
								                                    'fc_caducidad_vacuna'       => $vacuna->fc_caducidad_vacuna,
								                                    'id_duracion_inmunidad'     => $mordedor->id_duracion_inmunidad,
								                                    'json_otros_datos'          => array()
								                                );
								                                
								                                $vacunaAntirrabicaId = $daoVisitaAnimalVacuna->insert($datos_vacuna,$id_usuario,$id_visita, $id_mordedor); 
								                            }    
								                        }
								                    }
							                	}

							                }
							            }
							            else{
							            /**********************VISITA SIN MORDEDORES O SE NIEGA*********************/
							            	$parametros_visita["bo_sumario"]	= validar($datos_json->bo_inicia_sumario,"numero");
							            	if($datos_json->bo_inicia_sumario == 1){
							            		$fc_descargos							= validar($datos_json->fc_descargos,"date");
							            		$parametros_visita["json_otros_datos"]	= addslashes(json_encode(array("fc_descargos"=>$fc_descargos)));
							            	}

							            	foreach ($datos_json->mordedores as $mordedor) {
						                		$datos_mordedor	= array(
						                            "id_animal_estado"          =>  $mordedor->id_animal_estado,
						                            "id_animal_grupo"         	=>  $daoAnimalMordedor::GRUPO_ANIMAL_PERRO_GATO,
						                            "id_animal_especie"         =>  $mordedor->id_animal_especie,
						                            "id_animal_raza"            =>  $mordedor->id_animal_raza,
						                            "id_animal_tamano"          =>  $mordedor->id_animal_tamano,
						                            "id_comuna"                 =>  $mordedor->id_comuna_animal,
						                            "id_region"                 =>  $mordedor->id_region_animal,
						                            "bo_vive_con_dueno"         =>  $mordedor->bo_vive_con_dueno,
						                            "gl_direccion"              =>  $mordedor->gl_direccion,
						                            "gl_direccion_coordenadas"  =>  $mordedor->gl_direccion_coordenadas,
						                            "gl_direccion_detalles"     =>  $mordedor->gl_direccion_detalles,
						                            "gl_nombre"                 =>  $mordedor->gl_nombre,
						                            "gl_apariencia"             =>  $mordedor->gl_apariencia,
							                        "gl_color_animal"           =>  $mordedor->gl_color_animal,
						                        );
						                        
						                        $datos_mordedor["id_usuario"]	= $id_usuario;
						                        $id_mordedor					= $daoAnimalMordedor->insert($datos_mordedor);

						                        $daoExpedienteMordedor	= new DAOExpedienteMordedor($conn);
							                    $folio_mordedor			= $daoExpedienteMordedor->getByFolio($mordedor->gl_folio_mordedor);
							                    if(!empty($folio_mordedor)){
							                    	$datos_folio_mordedor	= array(
							                    			"id_mordedor"					=> $id_mordedor,
							                    			"id_expediente_mordedor_estado"	=> DAOExpediente::ESTADO_VISITA_INFORMADA,//$daoVisita::ESTADO_VISITA_PERDIDA,
							                    			"id_usuario_actualiza"			=> $id_usuario,
					                        				"fc_actualiza"					=> $fecha_actual
							                    		);
							                    	$daoExpedienteMordedor->update($datos_folio_mordedor, $folio_mordedor["id_expediente_mordedor"]);
							                    }

							                    $daoVisitaAnimalMordedor				= new DAOVisitaAnimalMordedor($conn);
							                    $json_mordedor							= $datos_mordedor;
							                    $json_mordedor["id_mordedor_interno"]	= $mordedor->id;
							                    $datos_visita_mordedor	= array(
							                            "id_visita"                 =>  $id_visita,
							                            "id_mordedor"               =>  $id_mordedor,
							                            "id_animal_estado"          =>  $mordedor->id_animal_estado,
							                            "bo_vive_con_dueno"         =>  $mordedor->bo_vive_con_dueno,
							                            "json_mordedor"             =>  $json_mordedor,
							                            "json_dueno"                =>  $mordedor->propietario,
							                            "gl_observacion_visita"     =>  $mordedor->gl_justificacion_animal_no_encontrado,
							                            "id_region_mordedor"        =>  $mordedor->id_region_animal,
							                            "id_visita_estado"			=>	$daoVisita::ESTADO_VISITA_SE_NIEGA,
														"id_tipo_visita_perdida"	=>	null,//$daoVisita::MOTIVO_SE_NIEGA,
														"id_tipo_visita_resultado"	=>	$daoVisita::RESULTADO_VISITA_SE_NIEGA,
							                        );

							                    $id_tipo_visita_resultado = $daoVisita::RESULTADO_VISITA_SE_NIEGA;

							                    if($datos_json->bo_inicia_sumario == 1){
								            		$datos_visita_mordedor["bo_sumario"]	= $datos_json->bo_inicia_sumario;
								            		$datos_visita_mordedor["fc_descargos"]	= $datos_json->fc_descargos;
								            	}
							                    
							                    $daoVisitaAnimalMordedor->insert($datos_visita_mordedor,$id_usuario);
							            	}
							            }
							            
							            /**************EXPEDIENTE*************/
							            $daoExpediente		= new DAOExpediente($conn);
							            $datos_expediente	= array(
							                    "fc_actualiza"	=> $fecha_actual,
							                    "id_usuario"	=> $id_usuario
							                );
							            $daoExpediente->updateEstadoExpediente($datos_expediente, $datos_json->id_expediente);
							            $expediente	= $daoExpediente->getById($datos_json->id_expediente);

							            /****************ALARMA***************/
							            $daoHistorialEvento	= new DAOHistorialEvento($conn);
							            $daoPacienteAlarma	= new DAOPacienteAlarma($conn);
							            $alarma = $daoPacienteAlarma->getByIdExpediente($datos_json->id_expediente);
							            
							            $datos_historial_evento = array(
												"id_expediente"		=> $datos_json->id_expediente,
												"gl_descripcion"	=> "CAMBIO ESTADO ALARMA",
												"id_usuario"		=> $id_usuario,
											);
							            
						            	if($expediente["id_inicia_vacuna"] == 2)//NO INICIA VACUNA
						            	{//SI NO INICIARON VACUNA Y TIENE SINTOMAS, INICIAR VACUNA
						            		if(isset($parametros_visita["bo_sintoma_rabia"]) && $parametros_visita["bo_sintoma_rabia"] == 1){
						            			//YA NO SE CREA LA ALARMA PARA VACUNAR, YA QUE DEBE ESPERARSE AL RESULTADO DEL ISP
						            			
						            			/*$datos_alarma = array(
						            				"id_tipo_alarma" => 2,//VACUNAR
						            				"id_alarma_estado" => 1,
						            				"id_expediente" => $datos_json->id_expediente,
						            				"id_paciente" => $expediente["id_paciente"],
						            			);
						            			if(!empty($alarma)){
						            				$datos_alarma["fc_actualiza"] = $fecha_actual;
						                    		$datos_alarma["id_usuario_actualiza"] = $id_usuario;
						            				$daoPacienteAlarma->update($datos_alarma, (int)$alarma["id_alarma"]);
						            			}else{
						            				$datos_alarma["fc_actualiza"] = $fecha_actual;
						                    		$datos_alarma["id_usuario"] = $id_usuario;
						                    		$datos_alarma["id_perfil"] = 3;
						            				$daoPacienteAlarma->insert($datos_alarma);
						            			}
						            			$datos_historial_evento["id_evento_tipo"] = 23; //VACUNAR
						            			$daoHistorialEvento->insertHistorialExpediente($datos_historial_evento);*/
							            	}
						            	}
						            	else if($expediente["id_inicia_vacuna"] == 1)//INICIA VACUNA
						            	{//SI NO TIENE SINTOMAS, DEJAR DE VACUNAR
						            		$mordedores_expediente	= $daoAnimalMordedor->getByIdExpedienteWS($datos_json->id_expediente);
						            		$bo_dejar_de_vacunar	= false;
						            		foreach ((array)$mordedores_expediente as $mordedor) {
						            			if($mordedor["bo_sintomas_rabia"] != 1){
						            				$bo_dejar_de_vacunar = true;
						            			}
						            		}
						            		if($bo_dejar_de_vacunar){
						            			$datos_alarma	= array(
						            				"id_tipo_alarma"	=> 1,//DEJAR DE VACUNAR
						            				"id_alarma_estado"	=> 1,
						            				"id_expediente"		=> $datos_json->id_expediente,
						            				"id_paciente"		=> $expediente["id_paciente"],
						            			);
						            			if(!empty($alarma)){
						            				$datos_alarma["fc_actualiza"]			= $fecha_actual;
						                    		$datos_alarma["id_usuario_actualiza"]	= $id_usuario;
							            			$daoPacienteAlarma->update($datos_alarma, (int)$alarma["id_alarma"]);
						            			}else{
						            				$datos_alarma["fc_actualiza"]	= $fecha_actual;
						                    		$datos_alarma["id_usuario"]		= $id_usuario;
						                    		$datos_alarma["id_perfil"]		= 3;
							            			$daoPacienteAlarma->insert($datos_alarma);
						            			}
						            			$datos_historial_evento["id_evento_tipo"] = 22; //DEJAR DE VACUNAR
						            			$daoHistorialEvento->insertHistorialExpediente($datos_historial_evento);
							            	}
							            }
					            	}
					            	else{
					            		/**********************VISITA PERDIDA*********************/
					            		$id_tipo_visita_resultado		= $daoVisita::RESULTADO_VISITA_PERDIDA; // visita perdida
					            		$daoExpediente					= new DAOExpediente($conn);
						                $parametros_expediente_mordedor	= array(
						                        "id_usuario_actualiza"	=> $id_usuario,
						                        "fc_actualiza"			=> $fecha_actual,
						                    );
							            if ($datos_json->id_tipo_visita_perdida == $daoVisita::MOTIVO_SE_NIEGA || 
							                $datos_json->id_tipo_visita_perdida == $daoVisita::MOTIVO_DIRECCION_INEXISTENTE){

							                $parametros_expediente_mordedor["id_expediente_mordedor_estado"] = $daoExpediente::ESTADO_VISITA_INFORMADA;
							            }
							            else{
							            	/**
							            	 * $datos_json->id_tipo_visita_perdida == $daoVisita::MOTIVO_SIN_MORADORES ||
							            	 * $datos_json->id_tipo_visita_perdida == $daoVisita::MOTIVO_NO_ENCONTRADO || 
							            	 * $datos_json->id_tipo_visita_perdida == $daoVisita::MOTIVO_OTRO || 
							            	 */
							                if(isset($datos_json->bo_volver_a_visitar) && $datos_json->bo_volver_a_visitar == true){
							                	$parametros_expediente_mordedor["id_expediente_mordedor_estado"] = $daoExpediente::ESTADO_PENDIENTE;
							            	}else{
							            		$parametros_expediente_mordedor["id_expediente_mordedor_estado"] = $daoExpediente::ESTADO_VISITA_INFORMADA;
                                                
                                                $daoHistorialEvento	= new DAOHistorialEvento($conn);
                                                $daoPacienteAlarma	= new DAOPacienteAlarma($conn);
                                                $alarma             = $daoPacienteAlarma->getByIdExpediente($datos_json->id_expediente);
                                                $expediente         = $daoExpediente->getById($datos_json->id_expediente);
                                                
                                                $datos_historial_evento = array(
                                                    "id_expediente"		=> $datos_json->id_expediente,
                                                    "gl_descripcion"	=> "CAMBIO ESTADO ALARMA",
                                                    "id_usuario"		=> $id_usuario,
                                                );
                                                
                                                //SI NO INICIO VACUNA SE PRENDE ALARMA PARA VACUNAR
                                                if($expediente["id_inicia_vacuna"] == 2)//NO INICIA VACUNA
                                                {
                                                    $datos_alarma = array(
                                                        "id_tipo_alarma"    => 2,//VACUNAR
                                                        "id_alarma_estado"  => 1,
                                                        "id_expediente"     => $datos_json->id_expediente,
                                                        "id_paciente"       => $expediente["id_paciente"],
                                                    );
                                                    if(!empty($alarma)){
                                                        $datos_alarma["fc_actualiza"]           = $fecha_actual;
                                                        $datos_alarma["id_usuario_actualiza"]   = $id_usuario;
                                                        $daoPacienteAlarma->update($datos_alarma, (int)$alarma["id_alarma"]);
                                                    }else{
                                                        $datos_alarma["fc_actualiza"]   = $fecha_actual;
                                                        $datos_alarma["id_usuario"]     = $id_usuario;
                                                        $datos_alarma["id_perfil"]      = 3;
                                                        $daoPacienteAlarma->insert($datos_alarma);
                                                    }
                                                    $datos_historial_evento["id_evento_tipo"] = 23; //VACUNAR
                                                    $daoHistorialEvento->insertHistorialExpediente($datos_historial_evento);
                                                }
                                                
							            	}
							            }
					            		$parametros_visita["id_tipo_visita_perdida"] =  validar($datos_json->id_tipo_visita_perdida,"numero");

					            		$daoExpedienteMordedor	= new DAOExpedienteMordedor($conn);
					            		$mordedores_expediente	= $daoExpedienteMordedor->getByFiscalizador($datos_json->id_expediente, $id_usuario);
					            		foreach ($mordedores_expediente as $expediente_mordedor) {
					                    	$daoExpedienteMordedor->update($parametros_expediente_mordedor, $expediente_mordedor["id_expediente_mordedor"]);
					            		}
					            		$parametros_expediente = array(
					                        "id_usuario"	=> $id_usuario,
					                        "fc_actualiza"	=> $fecha_actual,
					                    );
					            		$daoExpediente->updateEstadoExpediente($parametros_expediente, $datos_json->id_expediente);
					            	}

					            	/**************************************************************************************/
					            	/**************************************************************************************/
				            		//ACTUALIZO LOS DATOS DE LA VISITA SEGÚN CORRESPONDA
				            		///// SUMARIO INICIADO, MORDEDORES CON SINTOMAS, TIPO DE PERTIDA, ETC.
									$parametros_visita["fc_actualiza"]				= $fecha_actual;
									$parametros_visita["id_usuario_actualiza"]		= $id_usuario;
									//$parametros_visita["id_tipo_visita_resultado"]  =  $id_tipo_visita_resultado;
									$parametros_visita["id_tipo_visita_resultado"]	=  $daoVisita->calcularEstadoVisita($id_visita);

			            			$daoVisita->update($parametros_visita, $id_visita);

			            			//COMITEO TODAS LAS QUERYS PROCESADAS
					            	mysqli_commit($_conexion);
					            	//ACTIVO NUEVAMENTE EL AUTOCOMMIT
						            mysqli_autocommit($_conexion, true);

				                    $id_fiscalizacion	= $id_visita;
				                    $bo_resultado		= true;
									if($cantidad_adjuntos>0){
										$gl_error	= 'El registro espera adjuntos.';
										$cd_error	= 'WARNING_REGISTRO_ESPERA_ADJUNTOS';
									}else{
										$gl_error	= 'Solicitud procesada con exito';
										$cd_error	= 'SUCCESS';
					                }
				            	}else{
				            		$gl_error	= 'Error al intentar guardar en visita';
									$cd_error	= 'ERROR_DATA_INCORRECTA';
				            	}
			            	
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
	            	}else{
	            		if($visita['bo_exito_sincronizar'] == 1){
	            			$bo_resultado = true;
							$gl_error = 'El registro ya se encuentra sincronizado.';
							$cd_error = 'WARNING_REGISTRO_SINCRONIZADO';
						}else{
							if($cantidad_adjuntos>0){
								$bo_resultado = true;
								$gl_error = 'El registro espera adjuntos.';
								$cd_error = 'WARNING_REGISTRO_ESPERA_ADJUNTOS';
							}else{
								$bo_resultado = true;
								$gl_error = 'El registro espera validación.';
								$cd_error = 'WARNING_REGISTRO_ESPERA_VALIDACION';
							}
						}
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
					'id_fiscalizacion' => $id_fiscalizacion,
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

