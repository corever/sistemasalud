<?php


	include_once("DAO/DAOUsuario.php");
	include_once("DAO/DAOAsignacionOAL.php");

	$conn 						=	new MySQL();
	$daoUsuario					=	new DAOUsuario($conn);
	$daoAsignacionOal			=	new DAOAsignacionOAL($conn);
	
	$datos						=	NULL;
	$rut						=	NULL;

	$datos						=	(isset($_REQUEST['datos'])	&& !empty($_REQUEST['datos']))	?	$_REQUEST['datos']	:	NULL;
	$rut						=	(isset($datos['gl_rut'])	&& !empty($datos['gl_rut']))	?	$datos['gl_rut']	:	NULL;
	$arr_resultados				=	array();
	$json_columnas				=	array();
	$json_datos					=	array();
	
	if(empty($rut)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error				=	'100';
		$msg					=	'Falta parámetro requerido: RUT';
		$apache_msg				=	'Bad Request';
		$apache_cod				=	400;	
	}
	elseif(!validaRut($rut)){
		header("HTTP/1.1 400 Bad Request");
		$cod_error				=	'101';
		$msg					=	'Formato RUT incorrecto';
		$apache_msg				=	'Bad Request';
		$apache_cod				=	400;
	}
	else{
		$usuario				=	$daoUsuario->getLogin(array('rut'	=>	$rut,	'rol'	=> 30));
		if(!empty($usuario) && isset($usuario['id'])){
			$fiscalizaciones	=	$daoAsignacionOal->getActividades($usuario['id']);

			// file_put_contents('php://stderr', PHP_EOL . print_r($fiscalizaciones, TRUE). PHP_EOL, FILE_APPEND);

			$json_columnas[]	=	'Folio';
			$json_columnas[]	=	'Estado';
			$json_columnas[]	=	'Resultado';
			$json_columnas[]	=	'Codigo';
			$json_columnas[]	=	'Razon Social ';
			$json_columnas[]	=	'Agente Programado';
			$json_columnas[]	=	'Fichas Aplicadas';
			$json_columnas[]	=	'Region ';
			$json_columnas[]	=	'Comuna';
			$json_columnas[]	=	'Direccion';
			$json_columnas[]	=	'Fecha Inspeccion';
			$json_columnas[]	=	'Version APP';

			if(is_array($fiscalizaciones)){
				// foreach ($fiscalizaciones as &$value) {
				// 	$detalles						=	$daoAsignacionOal->getDetalleByToken($value["gl_token_asignacion"]);
				// 	$value["arr_detalles"]			=	$detalles;
				// }

				$arr_resultados['json_datos']		=	json_encode($fiscalizaciones,JSON_UNESCAPED_UNICODE);
				$arr_resultados['json_columnas']	=	json_encode($json_columnas,JSON_UNESCAPED_UNICODE);	
			}

			// file_put_contents('php://stderr', PHP_EOL . print_r($arr_resultados, TRUE). PHP_EOL, FILE_APPEND);

			$status		= true;
			$cod_error	= '000';
			$msg		= 'OK';
			$apache_msg	= 'OK';
			$apache_cod	= 200;
			$cantidad	= count($fiscalizaciones);
			$resultado	= $arr_resultados;

		}else{
			header("HTTP/1.1 401 Unauthorized");
			$cod_error	= '105';
			$msg		= 'RUN sin registros de Fiscalizador';
			$apache_msg	= 'Token de Registro incorrecto';
			$apache_cod	= 400;
		}
	}

	function etiqueta($param,$tipo){
		$val			=	'';
		switch ($tipo) {
			case 'bo':
				$val	=	$param	?	'<span class="lbl-s">Si</span>' : '<span class="lbl-df">No</span>';
				break;
			default:
				$val	=	$param;
				break;
		}

		return $val;
	}