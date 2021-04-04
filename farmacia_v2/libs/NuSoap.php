<?php  //if(!\Constantes::BASE_PATH) exit('No se permite acceder a este script');
/**
*****************************************************************************
* Sistema		:
* Descripcion	: class para crear archivos PDF
* Plataforma	: !PHP
* Creacion		: 08/05/2018
* @name			NuSoap.php
* @version		1.0
* @author		Victor Retamal <victor.retamal@cosof.cl>
*=============================================================================
*!ControlCambio
*--------------
*!cProgramador				!cFecha		!cDescripcion
*-----------------------------------------------------------------------------
*
*-----------------------------------------------------------------------------
*****************************************************************************
*/


	/**
	* Crear PDF a partir de un HTML
	*
	* @author Victor Retamal <victor.retamal@cosof.cl>
	*
	* @param  string 	$wsdl			URL WebService
	* @param  string 	$metodo			Metodo Utilizado
	* @param  string 	$param			Parametros Enviados
	* @param  string 	$credenciales	Usuario/Password
	*
	* @return pdf	Devuelve un archivo PDF, según $tipo_return
	*/
	include('nusoap/lib/nusoap.php');

	class NuSoap{
		public function __construct() {

		}
		public function nusoap($wsdl,$metodo,$param,$credenciales=array())	{
			$ws						= new nusoap_client($wsdl,'wsdl');
			if(!empty($credenciales)){
				$ws->setCredentials($credenciales[0], $credenciales[1], 'basic');
			}
	        $ws->soap_defencoding	= 'UTF-8';
	        $ws->decode_utf8		= false;

			if($ws->getError()){
				$result				= array();
				$estado				= 0;
			}else{
				$result				= $ws->call($metodo, $param);
				$estado				= 1;
			}

			$respuesta['estado']	= $estado;
			$respuesta['result']	= $result;

	    	return $respuesta;
		}

	}

?>
