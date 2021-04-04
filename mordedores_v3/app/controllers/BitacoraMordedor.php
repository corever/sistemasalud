<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripción       : Controller para Bitácora de Mordedor
 *
 * Plataforma        : PHP
 * 
 * Creación          : 07/06/2018
 * 
 * @name             BitacoraMordedor.php
 * 
 * @version          1.0.0
 *
 * @author           Pablo Jimenez <pablo.jimenez@cosof.cl>
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
class BitacoraMordedor extends Controller {

	protected $_Evento;
	protected $_DAOAnimalMordedor;
	protected $_DAOAdjunto;

	function __construct() {
		parent::__construct();
		$this->load->lib('Fechas', false);
		$this->load->lib('Seguridad', false);
		$this->load->lib('Evento', false);
        
		$this->_Evento                  = new Evento();
		$this->_DAOAnimalMordedor       = $this->load->model("DAOAnimalMordedor");
		$this->_DAOAdjunto              = $this->load->model("DAOAdjunto");
	}

	public function index() {
		Acceso::redireccionUnlogged($this->smarty);
	}

	/**
	* Descripción	: Bitácora de Mordedor
	* @author		: Pablo Jimenez <pablo.jimenez@cosof.cl>
	* @param int $codigo_microchip Microchip mordedor del que se mostrará la Bitácora.
	*/
	public function ver() {
        Acceso::redireccionUnlogged($this->smarty);
        
		$params             = $this->request->getParametros();
		$codigo_microchip   = $params[0];
        
        //Funcion que trae toda la info de bitacora
        $arrMordedor	= $this->_DAOAnimalMordedor->getBitacoraByToken($codigo_microchip);
        $arrMordedor->arrAdjuntos   = $this->_DAOAdjunto->getByMordedor($arrMordedor->id_mordedor);
        $this->smarty->assign("arr", $arrMordedor);

        $this->smarty->display('bitacora_mordedor/ver.tpl');
        $this->load->javascript(STATIC_FILES . 'js/templates/bitacora_mordedor/ver.js');
        $this->load->javascript(STATIC_FILES . "js/templates/bitacora_mordedor/mapa.js");
        
	}

}