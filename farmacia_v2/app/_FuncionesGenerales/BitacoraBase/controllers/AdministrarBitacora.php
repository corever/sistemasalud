<?php

namespace App\_FuncionesGenerales\BitacoraBase;

class AdministrarBitacora extends \pan\Kore\Controller{

	public function __construct(){
		parent::__construct();
	}

	public function cargarBase($params){
		
		$setParams = $this->validParams($params);
	
		/**
		 * To do, bitacora base realiza la carga de los
		 * elementos genericos eventos, documentos adjuntos, etc.
		 */

		$this->view->addJS('bitacora.js');
		$this->view->addJS('$(".modal-header").css({"background-color":"#007bff"});');
		$this->view->addJS('$(".modal-title").css({"color":"#ffffff"});');
		$this->view->addJS('$(".close").css({"color":"#ffffff"});');
		$this->view->addJS('$(".text-left").html("<i class=\'fas fa-file-signature\' ></i>&nbsp;BITÁCORA")');

		/**
		 * To do, Bitacora.loadBitacoraModulo.. realiza la
		 * carga de elementos especificas del modulo
		 */
		if(isset($setParams['modulo'])){
			$this->view->addJS('Bitacora.loadBitacoraModulo('.json_encode($setParams).');');
		}

		$this->view->render('cargarBitacoraBase');
	}

	private function validParams($params){
		/**
		 * To do, agregar mas validaciones
		 * no debe fallar bitacoraBase en la carga
		 * default
		 */

		if(!isset($params) ||
		   strpos($params, 'id=') === false){
			echo 'Error en la definición de los parametros.';
			exit();
		}

		if(strpos($params, '&') !== false){
			
			$arrParams = explode('&', $params);

			foreach($arrParams as $val){
				$arrVal = explode('=', $val);
				$setParams[$arrVal[0]] = $arrVal[1];
			}

		}else{
			$arrParams = explode('=', $params);
			$setParams[$arrParams[0]] = $arrParams[1];
		}

		if(is_null($setParams['id']) || 
		   $setParams['id'] == '' ){
			echo 'Error id';
			exit;
		}

		return $setParams;
	}

	#Region Grillas

	public function grillaDocumentosOficiales(){

	}

	public function grillaEventos(){
	
	}
	#Fin Region Grillas

}
