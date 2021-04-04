<?php

	include_once("DAO/DAODireccionComuna.php");
	$daoComuna	= new DAODireccionComuna();
	$id_region= (isset($_POST['id_region']))?$_POST['id_region']:false;
	$id_provincia= (isset($_POST['id_provincia']))?$_POST['id_provincia']:false;
	$gl_nombre_comuna= (isset($_POST['gl_nombre_comuna']))?$_POST['gl_nombre_comuna']:false;

	if($retorno == 'application/json') {
		$params = array();
		if(!empty($id_region)){
			$params["id_region"] = $id_region;
		}
		elseif(!empty($id_provincia)){
			$params["id_provincia"] = $id_provincia;
		}
		elseif(!empty($gl_nombre_comuna)){
			$params["gl_nombre_comuna"] = $gl_nombre_comuna;
		}

		$arr_comunas= $daoComuna->getListaParaCombo($params);
		$daoComuna->cerrar_conexion();

		$status		= true;
		$cod_error	= '000';
		$msg		= 'OK';
		$apache_msg	= 'OK';
		$apache_cod	= 200;
		$cantidad	= count($arr_comunas);
		$resultado	= $arr_comunas;
		
	}else{
		header("HTTP/1.1 406 Not Acceptable");
		$cod_error	= '004';
		$msg		= 'Formato de Retorno No Implementado';
		$apache_msg	= 'Not Acceptable';
		$apache_cod	= 406;
	}