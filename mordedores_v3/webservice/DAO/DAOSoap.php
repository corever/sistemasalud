<?php

class DAOSoap{

	function registro_ws($arrWs,$id_sistema,$id_soporte,$webservice,$respuesta)
	{
		$conn			= new MySQL();
		$id_usuario		= 0;
		$ip_publica		= '0.0.0';
		$ip_privada		= '0.0.0';
		$tipo 			= '';

		if(isset($_SESSION['ss_id_usuario'])){
			$id_usuario	= $_SESSION['ss_id_usuario'];
		}
		if(!empty($_SERVER['REMOTE_ADDR'])) {
			$ip_publica	= $_SERVER['REMOTE_ADDR'];
		}
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_privada	= $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		
		$sql			= "INSERT INTO registro_ws
							(
								id_usuario,
								id_sistema,
								id_soporte,
								webservice,
								key_public,
								data,
								json_respuesta,
								ip_publica,
								ip_privada
							)
							VALUES 	
							(	
								'$id_usuario',
								'$id_sistema',
								'$id_soporte',
								'$webservice',
								'".revisarString($arrWs['key_public'])."',
								'".addslashes(json_encode($arrWs))."',
								'".addslashes(json_encode($respuesta))."',
								'$ip_publica',
								'$ip_privada'
							)";

		$data			= $conn->consulta($sql);
		$id				= $conn->getInsertId();
		
		$conn->cerrar_conexion();
		return $id;
	}
		
	function getSistema_key_public($key_public)
	{
		$respuesta	= array();
		$conn		= new MySQL();

		$sql		= "	SELECT id_sistema, gl_nombre_sistema
						FROM maestro_sistemas
						WHERE key_public = '".revisarString($key_public)."' ";

		$data		= $conn->consulta($sql);		
		$respuesta	= $conn->fetch_assoc($data);

		$conn->dispose($data);
		$conn->cerrar_conexion();
		return $respuesta;
	}
	
	function insEvento($id_sistema, $id_registro, $gl_tipo, $gl_comentario, $json)
	{
		$conn		= new MySQL;

		$conn->evento($id_sistema, $id_registro, $gl_tipo, addslashes($gl_comentario), $json);
		$conn->cerrar_conexion();
		
		return true;		
	}
}