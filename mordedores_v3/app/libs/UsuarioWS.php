<?php
/**
 ******************************************************************************
 * Sistema           : ASD
 *
 * Descripción       : Helper para conexion a webservice
 *
 * Plataforma        : PHP
 *
 * Creación          : 17/04/2019
 *
 * @name             UsuarioWS.php
 *
 * @version          1.0.0
 *
 * @author           Luis Estay <luis.estay@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha		Descripción
 * ----------------------------------------------------------------------------
 *<luis.estay@cosof.cl>     17/04/2019  init
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

class UsuarioWS {

    private static $urlRut = 'http://midas.minsal.cl/apiMidas/getRut.midas.service.php';

    public function __construct() {

    }

    /**
	* Descripción	: Cargar datos de persona por webservice midas.
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param          string
	* @return         object
	* @return         array
	*/
    public static function cargarPersona($rut = '', $returnArray = FALSE){

    	$data = NULL;

    	if (!empty($rut)) {

    		$rut = explode('-',$rut);

    		if (isset($rut[0]) AND isset($rut[1])) {

    			// $data = file_get_contents( URL_WS_RUT . '?rut='.$rut[0].'&dv='.$rut[1]);
    			$data = file_get_contents(self::$urlRut . '?rut='.$rut[0].'&dv='.$rut[1]);
    			$data = json_decode($data, $returnArray);
    		}
    	}

    	return $data;
    }
}


?>
