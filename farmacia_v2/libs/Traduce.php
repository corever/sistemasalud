<?php

class Traduce {

    public static function actualizaJson($id_idioma){

		$id_idioma			= ($id_idioma > 0)?$id_idioma:1;
		$_DAOTraductor    	= new \App\_FuncionesGenerales\General\Entity\DAOTraductor();
		$jsonTraduccion 	= $_DAOTraductor->getById($id_idioma);
		$_SESSION[\Constantes::SESSION_BASE]['jsonTraductor']	= json_decode($jsonTraduccion->json_base);


		return $jsonTraduccion->json_base;
	}

    public static function texto($texto){

		$jsonEspanol 	= json_decode(file_get_contents("app/_FuncionesGenerales/General/views/json/json_espanol.json"));
		$retorno 		= (isset($jsonEspanol->$texto))?$jsonEspanol->$texto:$texto;

		if(isset($_SESSION[\Constantes::SESSION_BASE]['jsonTraductor']->$texto)){
			$retorno = $_SESSION[\Constantes::SESSION_BASE]['jsonTraductor']->$texto;
		}

		return $retorno;
		
	}

	public static function getJsonEspanol(){
		$jsonEspanol 	= file_get_contents("app/_FuncionesGenerales/General/views/json/json_espanol.json");
		return $jsonEspanol;
	}
    
}