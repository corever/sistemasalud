<?php
	die("No disponible");
	include_once("DAO/DAODireccionLocalidad.php");
	$daoLocalidad	= new DAODireccionLocalidad();
	$id_comuna= (isset($_POST['id_comuna']))?$_POST['id_comuna']:false;
	$gl_nombre_localidad= (isset($_POST['gl_nombre_localidad']))?$_POST['gl_nombre_localidad']:false;

	if($retorno == 'application/json') {
		$params = array();
		if(!empty($id_comuna)){
			$params["id_comuna"] = $id_comuna;
		}
		elseif(!empty($gl_nombre_localidad)){
			$params["gl_nombre_localidad"] = $gl_nombre_localidad;
		}

		$arr_localidad= $daoLocalidad->getListaParaCombo($params);
		$daoLocalidad->cerrar_conexion();

		$status		= true;
		$cod_error	= '000';
		$msg		= 'OK';
		$apache_msg	= 'OK';
		$apache_cod	= 200;
		$cantidad	= count($arr_localidad);
		$resultado	= $arr_localidad;
		
	}else{
		header("HTTP/1.1 406 Not Acceptable");
		$cod_error	= '004';
		$msg		= 'Formato de Retorno No Implementado';
		$apache_msg	= 'Not Acceptable';
		$apache_cod	= 406;
	}