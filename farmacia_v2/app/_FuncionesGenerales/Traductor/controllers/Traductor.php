<?php

namespace App\_FuncionesGenerales\Traductor;

/**
 * To do, revisar y adaptar al proyecto.
 */
class Traductor extends \pan\Kore\Controller{

	private $_DAOTraductor;

	public function __construct(){

		parent::__construct();

		$this->_DAOTraductor    = new \App\_FuncionesGenerales\General\Entity\DAOTraductor();

	}

	public function traducir(){

		$params 	= $this->request->getParametros();

		$_SESSION[\Constantes::SESSION_BASE]['idIdiomaPreferencia'] = $params['id_idioma'];
		$jsonTraduccion = $this->_DAOTraductor->getById($params['id_idioma']);

		if(!empty($jsonTraduccion)){
			$_SESSION[\Constantes::SESSION_BASE]['jsonTraductor'] = json_decode($jsonTraduccion->json_base);
		}

		echo json_encode(array("correcto"=>true,"jsonTraductor" => $jsonTraduccion->json_base));

	}

	/*
		ACTUALIZAR JSON PARA TRADUCCION EN BD
		URL: http://localhost/ops_hope_web/_FuncionesGenerales/General/Traductor/Traductor/actualizarJsonBD
	*/
	public function actualizarJsonBD(){

		$json1 = file_get_contents('app/_FuncionesGenerales/General/views/json/json_espanol.json');
		$json2 = file_get_contents('app/_FuncionesGenerales/General/views/json/json_ingles.json');
		$json3 = file_get_contents('app/_FuncionesGenerales/General/views/json/json_frances.json');
		$json4 = file_get_contents('app/_FuncionesGenerales/General/views/json/json_portugues.json');
		
		$this->_DAOTraductor->updateById(1,$json1);
		$this->_DAOTraductor->updateById(2,$json2);
		$this->_DAOTraductor->updateById(3,$json3);
		$this->_DAOTraductor->updateById(4,$json4);

		echo "Actualizado!";

	}
}
