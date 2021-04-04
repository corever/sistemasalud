<?php
/**
 ******************************************************************************
 * Sistema           : PREVENCION DE FEMICIDIOS
 * 
 * Descripción       : Controller para trabajar con Json
 *
 * Plataforma        : PHP
 * 
 * Creación          : 14/02/2017
 * 
 * @name             Paciente.php
 * 
 * @version          1.0.0
 *
 * @author           David Guzmán <david.guzman@cosof.cl>
 * 
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha		Descripción 
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
class Json extends Controller{

	protected $_DAORegion;
	
	function __construct(){
		parent::__construct();
		$this->load->lib('Fechas', false);
		$this->_DAORegion = $this->load->model('DAORegion');
	}

	/**
	* Descripción	: Carga comunas por región
	* @author		:  David Guzmán <david.guzman@cosof.cl>
	*/
    public function cargarComunasPorRegion(){
		$region		= $_POST['region'];
		$comunas	= $this->_DAORegion->getDetalleByIdRegion($region);
		$json		= array();
		$i			= 0;

		foreach($comunas as $comuna){
			$json[$i]['id_comuna']			= $comuna->id_comuna;
			$json[$i]['nombre_comuna']		= $comuna->gl_nombre_comuna;
			$json[$i]['gl_latitud_comuna']	= $comuna->gl_latitud_comuna;
			$json[$i]['gl_longitud_comuna']	= $comuna->gl_longitud_comuna;
			$i++;
		}

		echo json_encode($json);
    }

}