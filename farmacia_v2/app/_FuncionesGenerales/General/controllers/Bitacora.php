<?php

namespace App\_FuncionesGenerales\General;

/**
 * To do, revisar y adaptar al proyecto.
 */
class Bitacora extends \pan\Kore\Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index($id = null){

		//$this->view->addJS('descargos.js', 'app/Descargos/assets/js');
        $this->view->render('bitacora/cargarBitacora');
	}

	#Region Grillas

	public function grillaDocumentosOficiales(){

	}

	public function grillaEventos(){
	
	}
	#Fin Region Grillas

}
