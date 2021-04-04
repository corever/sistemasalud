<?php
	//Entrada
	$server->wsdl->addComplexType(
		'loginInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' => array( 'rut', 'type' => 'xsd:string'),
			'password' => array( 'password', 'type' => 'xsd:string'),
			'region' => array( 'region', 'type' => 'xsd:string'),
			'token' => array( 'token', 'type' => 'xsd:string'),
			'token_dispositivo' => array( 'token_dispositivo', 'type' => 'xsd:string'),
        	'appVersion' => array('appVersion', 'type' => 'xsd:string')
		)
	);


	// Salida
	$server->wsdl->addComplexType(
	    'loginOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'resultado'				=> array('resultado'			, 'type' => 'xsd:boolean'),
		    'gl_glosa'				=> array('gl_glosa'				, 'type' => 'xsd:string'),
		    'tipo_error'			=> array('tipo_error'			, 'type' => 'xsd:string'),
		    'version_app' 			=> array('version_app'			, 'type' => 'xsd:string'),
			'arr_login'				=> array('arr_login'			, 'type' => 'tns:arrLogin', 'minOccurs' => 0 , 'maxOccurs' => 1),
	    )
	);

	$server->wsdl->addComplexType(
		'arrLogin', 
		'complexType', 
		'struct', 
		'all', 
		'',
		array(
			'id_user' 		=> array('id_user'	, 'type' => 'xsd:int'),
		    'gl_glosa' 		=> array('gl_glosa'	, 'type' => 'xsd:string'),
            'nombre' 		=> array('nombre'	, 'type' => 'xsd:string'),
            'email' 		=> array('email'	, 'type' => 'xsd:string'),
            'region' 		=> array('region'	, 'type' => 'xsd:string')
        )
	);


	$server->register(  'login',
						array('data'	=> 'tns:loginInput'),
						array('return'	=> 'tns:loginOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#login',
						"rpc", 
						"encoded", 
						''
	);


	function login($arrWs){
		$conn =  new MySQL();
		$daoUsuario = new DAOUsuario($conn);
		$daoErrorLog = new DAOErrorLog($conn);

		$service_name = "loginRequest";
		$service_name_response = "loginResponse";
		$bo_resultado = false;
		$arr_login = array();
		$gl_error = '<b>Error:</b> data Incorrecta';
		$cd_error = 'ERROR_DATA_INCORRECTA';


		$rut 			   = null;
		$password 		   = null;
		$region_usuario    = null;
		$token 			   = null;
		$token_dispositivo = null;
		$appVersion		   = null;
		$respuesta 		   = array();

		if(is_array($arrWs)){
			$rut 			   = (!empty($arrWs['rut']))? $arrWs['rut']		: null;
			$password 		   = (!empty($arrWs['password']))? $arrWs['password']	: null;
			$region_usuario	   = (!empty($arrWs['region']))? $arrWs['region']		: null;
			$appVersion		   = (!empty($arrWs['appVersion'])) ? $arrWs['appVersion'] : null;
			$token             = (!empty($arrWs['token']))	? $arrWs['token']	: null;
			$token_dispositivo = (!empty($arrWs['token_dispositivo']))	? $arrWs['token_dispositivo']	: null;

			$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 1, $service_name);

			list($version_mayor, $version_menor, $version_micro) = explode('.', $appVersion);
			
			if(trim($rut) == '' or trim($rut) == 0){
				$gl_error = '<b>Error:</b> rut';
				$cd_error = 'ERROR_RUT';
			}
			elseif (($version_mayor<VERSION_MAYOR_APP)) {
	            $gl_error = '<b>Error:</b> La versión de la aplicación ha sido deprecada. Por favor, actualice su aplicación a la ultima versión';
	            $cd_error = 'ERROR_VERSION_DEPRECADA';
	        }
			else
			{
				
				$usuario = $daoUsuario->getUsuarioLogin($rut,$password);
				
				if(!is_null($usuario) && $daoUsuario->validarFiscalizador($usuario['id_usuario']))
		        {	               
		        	$regiones_usuario = $daoUsuario->getRegionesUsuario($usuario["id_usuario"]);
					$arr_login = array(
				                'id_user'	=> $usuario['id_usuario'],
				                'nombre'	=> $usuario['gl_nombres'].' '.$usuario['gl_apellidos'],
				                'email'		=> $usuario['gl_email'],
				                'region'	=> $regiones_usuario[0]["id_region"]
				            );

		            $bo_resultado = true;
		            $gl_error = "Solicitud procesada con exito";
	                $cd_error = "SUCCESS";
	                
		        }
		        else
		        {
		        	try{
			        	$usuario = $daoUsuario->getUsuarioLoginMIDAS($rut,$password);
			        	if(!is_null($usuario)){
							$arr_login = array(
						                'id_user'	=> $usuario['id'],
						                'nombre'	=> $usuario['nombres'].' '.$usuario['apellidos'],
						                'email'		=> $usuario['email'],
						                'region'	=> $usuario["id_region"]
						            );

				            $bo_resultado = true;
				            $gl_error = "Solicitud procesada con exito";
			                $cd_error = "SUCCESS";
			        	}else{
				        	$gl_error = '<b>Error:</b> usuario o password incorrectas.';
							$cd_error = 'ERROR_CREDENCIALES_INCORRECTAS';
			        	}
		        	}catch (Exception $e){
		        		$gl_error = '<b>Error:</b> usuario o password incorrectas.';
						$cd_error = 'ERROR_CREDENCIALES_INCORRECTAS';
		        	}
		            
		        }
		    }
		}
		else{
			$daoErrorLog->setLogAuditoria($arrWs, $rut, VERSION_WS, $appVersion, $token_dispositivo, 0, $service_name);
		}
		$respuesta =   array(
		            		'resultado'		=> $bo_resultado,
			            	'gl_glosa'		=> $gl_error,
			            	'tipo_error'	=> $cd_error, 
			            	'version_app' 	=> VERSION_APP, 
			            	'arr_login'		=> $arr_login
		            	);
		$daoErrorLog->setLogAuditoria($respuesta, $rut, VERSION_WS, $appVersion, $token_dispositivo, (int)$bo_resultado, $service_name_response);
		$conn->cerrar_conexion();
		
		return $respuesta;
    }

