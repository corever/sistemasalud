<?php
	//Entrada
	$server->wsdl->addComplexType(
		'enviarAdjuntoMordedoresInput',
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
	    'enviarAdjuntoMordedoresOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:string'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'nr_pendientes'			=> array('nr_pendientes'		, 'type' => 'xsd:int'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string')
	    )
	);

	$server->register(  'enviarAdjuntoMordedores',
						array('data'	=> 'tns:enviarAdjuntoMordedoresInput'),
						array('return'	=> 'tns:enviarAdjuntoMordedoresOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#enviarAdjuntoMordedores',
						"rpc", 
						"encoded", 
						''
	);

	function enviarAdjuntoMordedores($arrWs){
		$conn						=  new MySQL();
		$daoAdjunto					= new DAOAdjunto($conn);
		$daoAdjuntoTipo				= new DAOAdjuntoTipo($conn);
		$daoVisita					= new DAOVisita($conn);
		$daoVisitaAnimalMordedor	= new DAOVisitaAnimalMordedor($conn);
		//$daoExpedientePaciente	= new DAOExpedientePaciente($conn);
		$daoUsuario					= new DAOUsuario($conn);
		$daoErrorLog				= new DAOErrorLog($conn);	

		$service_name				= "enviarAdjuntoMordedoresRequest";
		$service_name_response		= "enviarAdjuntoMordedoresResponse";
		$bo_resultado				= false;
		$gl_error					= '<b>Error:</b> data Incorrecta';
		$cd_error					= 'ERROR_DATA_INCORRECTA';

		$rut						= null;
		$password					= null;
		$token_dispositivo			= null;
		$appVersion					= null;
		$_token_fiscalizacion		= null;
		$nr_pendientes				= null;
		$respuesta					= array();

		if(!empty($arrWs) && is_array($arrWs)){
			$rut 				  = (!empty($arrWs['rut']))?$arrWs['rut']:null;
			$password 			  = (!empty($arrWs['password']))?$arrWs['password']:null;
			$token_dispositivo 	  = (!empty($arrWs['token_dispositivo']))?$arrWs['token_dispositivo']:null;
			$appVersion			  = (!empty($arrWs['appVersion']))?$arrWs['appVersion']:null;
			$cantidad_adjuntos    = (!empty($arrWs['cantidad_adjuntos']))?$arrWs['cantidad_adjuntos']:0;
			$datos_json			  = json_decode(str_replace("'","",utf8_encode($arrWs["datos_json"])));
			$_token_fiscalizacion = (!empty($datos_json->_token_fiscalizacion))?$datos_json->_token_fiscalizacion:null;

			$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token, 1, $service_name);

            if(trim($rut) == '' or trim($rut) == 0){
				$gl_error = '<b>Error:</b> El campo Rut es obligatorio.';
				$cd_error = 'ERROR_RUT';
			}
			else if(!isset($datos_json->adjunto) || !isset($datos_json->adjunto->archivo) || empty($datos_json->adjunto->archivo)){
				file_put_contents('php://stderr', PHP_EOL . print_r($datos_json, TRUE). PHP_EOL, FILE_APPEND);
				$gl_error = '<b>Error:</b> El adjunto está vacío.';
				$cd_error = 'ERROR_ADJUNTO_REQUERIDO';
			}
			else{

				$usuario = $daoUsuario->getUsuarioByRut($rut);

				if(!is_null($usuario))
		        {
	            	$visita  = $daoVisita->getByTokenFiscalizacion($_token_fiscalizacion);
	            	$total_adjuntos = $daoAdjunto->getCantidadAdjuntosByIdVisita($visita["id_visita"]);
	            	//$paciente = $daoExpedientePaciente->getByIdExpediente($visita["id_expediente"]);
	            	//COMO CONSEGUIR EL ID DEL MORDEDOR CUANDO LA TABLET NO LO SABE?
	            	$tipo_adjunto_sumario = 8;
		            if(!empty($visita)){
		            	$id_mordedor = null;
		            	if($datos_json->adjunto->id_adjunto_tipo != $tipo_adjunto_sumario){
		            		if(isset($datos_json->id_mordedor) && !empty($datos_json->id_mordedor)){
		            			$id_mordedor = $datos_json->id_mordedor;
			            	}else{
								$visitasAnimalMordedor = $daoVisitaAnimalMordedor->getByIdVisita($visita["id_visita"]);
								if(is_array($visitasAnimalMordedor)){
									foreach ($visitasAnimalMordedor as $visitaMordedor) {
										$json_mordedor = json_decode($visitaMordedor["json_mordedor"]);
										if(isset($json_mordedor->id_mordedor_interno) && $json_mordedor->id_mordedor_interno == $datos_json->id_interno){
											$id_mordedor = $json_mordedor->id_mordedor;
										}
									}
									if(empty($id_mordedor) && count($visitasAnimalMordedor) == 1){
										$id_mordedor = $visitasAnimalMordedor[0]["id_mordedor"];
									}
								}
			            	}
		            	}
		            	
		                /*********************************/
		                $raiz = $daoAdjunto::PATH_DIRECTORIO.$daoAdjunto::PATH_SUB_DIRECTORIO;
		                $directorio_expediente = $raiz.'expediente_'.$visita["id_expediente"];
		                $directorio_visita = $directorio_expediente .'/visita_'.$visita["id_visita"].'/';

		                $directorio_existe = false;
		                if(!is_dir($daoAdjunto::PATH_DIRECTORIO)){
		                	if(!mkdir($daoAdjunto::PATH_DIRECTORIO, 0777, true)){
		                		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR: " .$daoAdjunto::PATH_DIRECTORIO. PHP_EOL, FILE_APPEND);
		                		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
		                	}
		                }
		                if(!is_dir($raiz)){
		                	if(!mkdir($raiz, 0777, true)){
		                		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR: " .$raiz. PHP_EOL, FILE_APPEND);
		                		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
		                	}
		                }
		                if(!is_dir($directorio_expediente)){
		                	if(!mkdir($directorio_expediente, 0777, true)){
		                		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR: " .$directorio_expediente. PHP_EOL, FILE_APPEND);
		                		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
		                	}
		                }
		                if(!is_dir($directorio_visita)){
				            if(!mkdir($directorio_visita, 0777, true)) {
				            	file_put_contents('php://stderr', PHP_EOL . $directorio_visita . PHP_EOL, FILE_APPEND);
				                $gl_error = '<b>Error:</b> No se pudo procesar la solicitud';
	                			$cd_error = 'ERROR_CREACION_ADJUNTO';
				            }else{
				            	$directorio_existe = true;	
				            }
				        }else{
				        	$directorio_existe = true;
				        	file_put_contents('php://stderr', PHP_EOL . "El directorio ya existe...". PHP_EOL, FILE_APPEND);
				        }
				        
				        if($directorio_existe){
				        	$adjuntoTipo = $daoAdjuntoTipo->getById($datos_json->adjunto->id_adjunto_tipo);
				        	//if($datos_json->adjunto->id_adjunto_tipo == $tipo_adjunto_sumario){
				        	//	$nombre_archivo = $adjuntoTipo["gl_nombre_tipo_adjunto"]."_".$visita["id_visita"];
				        	//}else{
				        		$nombre_archivo = $datos_json->folio_mordedor."_".$adjuntoTipo["gl_nombre_tipo_adjunto"]."_".$visita["id_visita"];
				        	//}
				        	
				        	$gl_tipo_archivo = ".jpeg";
				        	if(isset($datos_json->adjunto->gl_tipo_archivo) && !empty($datos_json->adjunto->gl_tipo_archivo)){
				        		$gl_tipo_archivo = $datos_json->adjunto->gl_tipo_archivo;
				        	}
				        	$nombre_archivo .= "_".$datos_json->adjunto->gl_descripcion.$gl_tipo_archivo;
				        	$nombre_archivo = str_replace(" ","_",$nombre_archivo);
				        	
					        $path_adjunto = $directorio_visita . $nombre_archivo;

					        if (!file_exists($path_adjunto)) {
					            $ifp = fopen( $path_adjunto, 'wb' );
					            fwrite( $ifp, base64_decode( $datos_json->adjunto->archivo ) );
					            fclose( $ifp );

					            if (is_file($path_adjunto)) {
					            	if(filesize($path_adjunto) > 0){
					            		$parametros_adjunto = array(
						                	"gl_token"			=> $nombre_archivo,
											"id_expediente"		=> $visita["id_expediente"],
											"id_visita"			=> $visita["id_visita"],
											//"id_paciente"		=> $paciente["id_paciente"],
											"id_mordedor"		=> $id_mordedor,
											"id_adjunto_tipo"	=> $datos_json->adjunto->id_adjunto_tipo,
											"gl_nombre"			=> $nombre_archivo,
											"gl_path"			=> ltrim($path_adjunto,"\.\./"),
											"gl_glosa"			=> $datos_json->adjunto->gl_descripcion,
											"id_usuario"		=> $usuario["id_usuario"]
					                	);
						                $id_adjunto = $daoAdjunto->insert($parametros_adjunto);
						                if(!empty($id_adjunto) && is_numeric($id_adjunto)){
						                	$nr_pendientes = (int)$cantidad_adjuntos - (int)$total_adjuntos - 1;
						                	$bo_resultado = true;
						                	$gl_error = 'Solicitud procesada con exito';
					                		$cd_error = 'SUCCESS';
						                }else{
						                	unlink($path_adjunto);
						                	$gl_error = '<b>Error:</b> No se pudo procesar la solicitud';
			                				$cd_error = 'ERROR_DATA_INCORRECTA';
						                }
					            	}else{
					            		unlink($path_adjunto);
					            		$gl_error = '<b>Error:</b> el adjunto pesa 0KB';
		                				$cd_error = 'ERROR_CREACION_ADJUNTO';
					            	}
					            }else{
					                $gl_error = '<b>Error:</b> Ocurrio un error al intentar crear el adjunto';
		                			$cd_error = 'ERROR_CREACION_ADJUNTO';
					            }
					        }
					        else{
					        	$nr_pendientes = (int)$cantidad_adjuntos - (int)$total_adjuntos;
				                $bo_resultado = true;
			                	$gl_error = 'El adjunto ya existe.';
		                		$cd_error = 'WARNING_ARCHIVO_EXISTENTE';
					        }
				        }
				        else{
				            	$gl_error = '<b>Error:</b> No se pudo procesar la solicitud';
	                			$cd_error = 'ERROR_CREACION_ADJUNTO';
				            }
				        /*********************************************/
		            }
		            else
		            {
		            	$gl_error = '<b>Error:</b> No se pudo encontrar la visita';
	                	$cd_error = 'ERROR_REGISTRO_NO_ENCONTRADO';
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
					'gl_glosa'		=> $gl_error, 
					'tipo_error'	=> $cd_error, 
					'nr_pendientes' => $nr_pendientes,
					'version_app' 	=> VERSION_APP
				);
		$daoErrorLog->setLogAuditoria($respuesta, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)$bo_resultado, $service_name_response);
		$conn->cerrar_conexion();

		return $respuesta;
    }

