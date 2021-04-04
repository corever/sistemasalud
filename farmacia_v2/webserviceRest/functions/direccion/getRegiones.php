<?php

	include_once("DAO/DAODireccionRegion.php");
	$daoRegion	= new DAODireccionRegion();
	$id_region= (isset($_POST['id_region']))?$_POST['id_region']:false;
	$gl_nombre_region= (isset($_POST['gl_nombre_region']))?$_POST['gl_nombre_region']:false;

	if($retorno == 'application/json') {
		$params = array();
		if(!empty($id_region)){
			$params["id_region"] = $id_region;
		}
		elseif(!empty($gl_nombre_region)){
			$params["gl_nombre_region"] = $gl_nombre_region;
		}

		$arr_regiones= $daoRegion->getListaParaCombo($params);
		$daoRegion->cerrar_conexion();

		$status		= true;
		$cod_error	= '000';
		$msg		= 'OK';
		$apache_msg	= 'OK';
		$apache_cod	= 200;
		$cantidad	= count($arr_regiones);
		$resultado	= $arr_regiones;
		
	}else{
		header("HTTP/1.1 406 Not Acceptable");
		$cod_error	= '004';
		$msg		= 'Formato de Retorno No Implementado';
		$apache_msg	= 'Not Acceptable';
		$apache_cod	= 406;
	}