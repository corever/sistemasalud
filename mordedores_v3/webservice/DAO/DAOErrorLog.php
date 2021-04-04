<?php

class DAOErrorLog{
	protected $_conn            = null;

	function __construct($conn = null) {
        if($conn !== null){
            $this->_conn =  $conn;
        }else{
            $this->_conn =  new MySQL();
        }
    }

	function setLogAuditoria($json_servicio, $gl_rut, $gl_version_ws, $gl_version_app, $gl_token, $cd_codigo_resultado, $gl_funcion)
	{
		//$conn 			= new MySQL();
		$id_usuario		= 0;
		$ip_publica		= '0.0.0.0';
		$ip_privada		= '0.0.0.0';
		$id_expediente	= 0;
		$id_visita		= 0;
		
		if(isset($json_servicio["datos_json"])){
			if(!empty($json_servicio["datos_json"])){
				$datos_json = utf8_encode($json_servicio["datos_json"]);
				$datos_json = str_replace("'","",$datos_json);
				$json_servicio["datos_json"] = json_decode($datos_json,true);
				if(isset($json_servicio["datos_json"]["id_expediente"])){
					$id_expediente = $json_servicio["datos_json"]["id_expediente"];
				}
				if(isset($json_servicio["datos_json"]["id_visita"])){
					$id_visita = $json_servicio["datos_json"]["id_visita"];
				}
			}
			else{
				unset($json_servicio["datos_json"]);
			}
		}
		$json_respuesta = addslashes(json_encode($json_servicio));

		if(isset($json_cuerpo['id_fiscalizador'])){
			$id_usuario	= (int)$json_cuerpo['id_fiscalizador'];
		}
		if(!empty($_SERVER['REMOTE_ADDR'])) {
			$ip_publica	= $_SERVER['REMOTE_ADDR'];
		}
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_privada	= $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		if(!empty($gl_rut)){
			$daoUsuario = new DAOUsuario($this->_conn);
			$usuario = $daoUsuario->getUsuarioByRut($gl_rut);
			if(!empty($usuario)){
				$id_usuario = $usuario['id_usuario'];
			}
		}

		$sql = "INSERT INTO mor_auditoria_ws ( 
							id_usuario,
							id_expediente,
							id_visita,
							gl_rut,
							gl_origen,
							gl_token,
							gl_version_ws,
							gl_version_app,
							json_respuesta,
							nr_ws_success,
							ip_privada,
							ip_publica,
							id_usuario_crea
						)
				 VALUES (
							 ".	$id_usuario			 .",
							 ".	$id_expediente		 .",
							 ".	$id_visita			 .",
							'".	$gl_rut				 ."',
							'".	$gl_funcion			 ."',
							'".	$gl_token			 ."',
							'".	$gl_version_ws		 ."',
							'".	$gl_version_app		 ."',
							'".	$json_respuesta		 ."',
							 ".	$cd_codigo_resultado .",
							'".	$ip_privada			 ."',
							'".	$ip_publica			 ."',
							 ".	$id_usuario			 ."
				 			)";
		
		$data = $this->_conn->consulta($sql);
		$errorLogId = $this->_conn->getInsertId($data);
        return $errorLogId;
	}

	function setLogAuditoriaBichito($json_servicio, $id_usuario, $gl_rut, $tipo_log, $gl_version_ws, $gl_version_app, $gl_token, $nr_ws_success, $gl_origen)
	{
		$ip_publica		= '0.0.0.0';
		$ip_privada		= '0.0.0.0';
		
		$json_respuesta = addslashes(utf8_encode($json_servicio));

		if(!empty($_SERVER['REMOTE_ADDR'])) {
			$ip_publica	= $_SERVER['REMOTE_ADDR'];
		}
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_privada	= $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		$sql = "INSERT INTO mor_auditoria_ws_bichito ( 
							id_usuario,
							gl_rut,
							gl_origen,
							gl_tipo_log,
							gl_token,
							gl_version_ws,
							gl_version_app,
							json_respuesta,
							nr_ws_success,
							ip_privada,
							ip_publica,
							id_usuario_crea
						)
				 VALUES (
							 ".	$id_usuario			 .",
							'".	$gl_rut				 ."',
							'".	$gl_origen			 ."',
							'".	$gl_tipo_log		 ."',
							'".	$gl_token			 ."',
							'".	$gl_version_ws		 ."',
							'".	$gl_version_app		 ."',
							'".	$json_respuesta		 ."',
							 ".	$nr_ws_success 		 .",
							'".	$ip_privada			 ."',
							'".	$ip_publica			 ."',
							 ".	$id_usuario			 ."
				 			)";
		
		$data = $this->_conn->consulta($sql);
		$errorLogId = $this->_conn->getInsertId($data);
        return $errorLogId;
	}

	function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

}
