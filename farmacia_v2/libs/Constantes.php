<?php

class Constantes{

	/**
	 * Integra constantes principales/base a nivel de todo el proyecto
	 * Solo se genera la mantención y modificaciones en libs/Constantes.php.
	 * 
	 * To do, evaluar hacer un merge de constantes base y constantes 
	 * particulares en los controladores particulares de cada modulo.
	 */

	const _CONSTANTE       = "Test 1";
	const _CONSTANTE2      = 2;

	const SESSION_BASE     = 'farmacia_v2';
	const SEGURIDAD_BASE   = 'FARMACIA_V2';

	/* base url*/
	const URL_LINK			= 'http://localhost/farmacia_v2';
	const BASE_PATH			= 'http://localhost/';

	#Modulo Formularios
	const ID_TIPO_EDAN     = 1;
	const ID_TIPO_ENCUESTA = 2;
	#Fin Modulo Formularios


	/**
	 * To do, por evaluar con constantes particulares
	 * de cada modulo.
	 */
	public static function merge(){
		return null;
	}
	
	/**
	 * Retorna array con todas las constantes
	 * definidas en la clase.
	 */
	public static function getAll(){
		$reflected = new ReflectionClass(get_class($this));
		return $reflected->getConstants();
	}

}