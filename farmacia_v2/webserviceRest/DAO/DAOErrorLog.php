<?php

class DAOErrorLog{
	const TYPE_APP_LOG 			= "app_log";
	const TYPE_RESPALDO_VISITA 	= "respaldo_visita";
	const TYPE_RESPALDO_ADJUNTO = "respaldo_adjunto";
	protected $_conn            = null;

	function __construct($conn = null) {
        if($conn !== null){
            $this->_conn =  $conn;
        }else{
            $this->_conn =  new MySQL();
        }
    }

    /**
     * [setLogAuditoria Crea un registro en la base de datos para dejar auditoria de los procesos/errores que ocurren durante el proceso de sincronización]
     * @param [type] $json_servicio       [description]
     * @param [type] $gl_rut              [description]
     * @param [type] $id_usuario          [description]
     * @param [type] $gl_version_ws       [description]
     * @param [type] $gl_version_app      [description]
     * @param [type] $gl_token            [description]
     * @param [type] $cd_codigo_resultado [description]
     * @param [type] $gl_funcion          [description]
     */
	function setLogAuditoria($log_params)
	{
		$ip_publica		= '0.0.0.0';
		$ip_privada		= '0.0.0.0';
		
		if(!empty($_SERVER['REMOTE_ADDR'])) {
			$ip_publica	= $_SERVER['REMOTE_ADDR'];
		}
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_privada	= $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		if(!empty($log_params["id_usuario"])){
			$id_usuario = $log_params["id_usuario"];
		}
		else if(empty($id_usuario) && !empty($gl_rut)){
			$daoUsuario = new DAOUsuario($this->_conn);
			$usuario = $daoUsuario->getByRut($gl_rut);
			if(!empty($usuario)){
				$id_usuario = $usuario['id_usuario'];
			}
		}
		else if(empty($id_usuario) && empty($gl_rut)){
			$id_usuario		= 0;
		}

		if(isset($log_params["json_datos"])){
			//$json_datos = json_encode($log_params["json_datos"]));
			$json_datos = addslashes(utf8_encode(json_encode($log_params["json_datos"])));
		}
		else{
			$json_datos = '{}';
		}

		$id_asignacion = isset($log_params["id_asignacion"])?$log_params["id_asignacion"]:0;
		$id_visita = isset($log_params["id_visita"])?$log_params["id_visita"]:0;
		$gl_rut = isset($log_params["gl_rut"])?$log_params["gl_rut"]:'';
		$gl_service_name = isset($log_params["gl_service_name"])?$log_params["gl_service_name"]:'';
		$gl_token_dispositivo = isset($log_params["gl_token_dispositivo"])?$log_params["gl_token_dispositivo"]:'';
		$gl_version_ws = isset($log_params["gl_version_ws"])?$log_params["gl_version_ws"]:'';
		$gl_version_app = isset($log_params["gl_version_app"])?$log_params["gl_version_app"]:'';
		$bo_ws_success = isset($log_params["bo_ws_success"])?$log_params["bo_ws_success"]:false;

		$sql = "INSERT INTO ".TABLA_AUDITORIA." ( 
							id_usuario,
							id_asignacion,
							id_visita,
							gl_rut,
							gl_service_name,
							gl_token_dispositivo,
							gl_version_ws,
							gl_version_app,
							json_datos,
							bo_ws_success,
							ip_privada,
							ip_publica,
							id_usuario_crea
						)
				 VALUES (
							 ". validar($id_usuario, "numero") 				." ,
							 ". validar($id_asignacion, "numero") 			." ,
							 ". validar($id_visita, "numero") 				." ,
							'". validar($gl_rut, "string") 					."',
							'". validar($gl_service_name, "string") 		."',
							'". validar($gl_token_dispositivo, "string") 	."',
							'". validar($gl_version_ws, "string") 			."',
							'". validar($gl_version_app, "string") 			."',
							'". validar($json_datos, "json") 				."',
							 ". validar($bo_ws_success, "numero") 			." ,
							'". validar($ip_privada, "string")			 	."',
							'". validar($ip_publica, "string")			 	."',
							 ". validar($id_usuario, "numero") 				."
				 		)";
		
		$data = $this->_conn->consulta($sql);
		$errorLogId = $this->_conn->getInsertId($data);
        return $errorLogId;
	}

	function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

    /**
     * [setLogApp Crea un archivo de respaldo con el log que registra la aplicación.]
     */
    function setLogApp($token_dispositivo, $id_usuario, $log){
    	$file_name = self::TYPE_APP_LOG."_us".$id_usuario."_dis".$token_dispositivo."_".date("d_m_Y_His");

    	if(!is_dir("error_log")){
        	if(!mkdir("error_log", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: error_log". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }
        if(!is_dir("error_log/error_app")){
        	if(!mkdir("error_log/error_app", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: error_log/error_app". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }

		$logfile=fopen("error_log/error_app/".$file_name.".json","a"); 
		if(fputs($logfile,$log)){
			return $file_name;
		}
		else{
			return false;
		}
    }

    /**
     * [setRespaldoVisita Crea un archivo de respaldo con el log que registra la aplicación.]
     * @todo customisar parametros necesarios
     */
    function setRespaldoVisita($token_dispositivo, $id_usuario, $datos){
    	$file_name = self::TYPE_RESPALDO_VISITA."_us".$id_usuario."_dis".$token_dispositivo."_".date("d_m_Y_His");

    	if(!is_dir("archivos")){
        	if(!mkdir("archivos", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: archivos". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }
        if(!is_dir("archivos/respaldos")){
        	if(!mkdir("archivos/respaldos", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: archivos/respaldos". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }
        if(!is_dir("archivos/respaldos/visitas")){
        	if(!mkdir("archivos/respaldos/visitas", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: archivos/respaldos/visitas". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }

		$logfile=fopen("archivos/respaldos/visitas/".$file_name.".json","a"); 
		if(fputs($logfile,$datos)){
			return $file_name;
		}
		else{
			return false;
		}
    }

    /**
     * [setRespaldoAdjuntos Crea un archivo de respaldo con el log que registra la aplicación.]
     * @todo customisar parametros necesarios
     */
    function setRespaldoAdjuntos($token_dispositivo, $id_usuario, $datos){
    	$file_name = self::TYPE_RESPALDO_ADJUNTO."_us".$id_usuario."_dis".$token_dispositivo."_".date("d_m_Y_His");

    	if(!is_dir("archivos")){
        	if(!mkdir("archivos", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: archivos". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }
        if(!is_dir("archivos/respaldos")){
        	if(!mkdir("archivos/respaldos", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: archivos/respaldos". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }
        if(!is_dir("archivos/respaldos/adjuntos")){
        	if(!mkdir("archivos/respaldos/adjuntos", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: archivos/respaldos/adjuntos". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }

		$logfile=fopen("archivos/respaldos/adjuntos/".$file_name.".json","a"); 
		if(fputs($logfile,$datos)){
			return $file_name;
		}
		else{
			return false;
		}
    }


    /**
     * [setErrorLog Registra los errores que ocurren en el sistema en un archivo de log]
     * @param [type] $token_dispositivo [description]
     * @param [type] $id_usuario        [description]
     * @param [type] $log               [description]
     */
    function setErrorLog($token_dispositivo, $id_usuario, $log){	
    	$file_name = "log_".$id_usuario."_".$token_dispositivo."_".date("d_m_Y");

    	if(!is_dir("error_log")){
        	if(!mkdir("error_log", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: error_log". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }

        if(!is_dir("error_log/error_service")){
        	if(!mkdir("error_log/error_service", 0777, true)){
        		file_put_contents('php://stderr', PHP_EOL . "ERROR EN CREAR DIRECTORIO: error_log/error_service". PHP_EOL, FILE_APPEND);
        		file_put_contents('php://stderr', PHP_EOL . print_r(error_get_last(), true) . PHP_EOL, FILE_APPEND);
        		return false;
        	}
        }

		$logfile=fopen("error_log/error_service/".$file_name.".json","a"); 

		return fputs($logfile,date("d-m-Y H:i:s").";".($log)."\n");
    }

}
