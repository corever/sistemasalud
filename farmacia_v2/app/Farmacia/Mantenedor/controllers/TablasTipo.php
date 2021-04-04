<?php

namespace App\Farmacia\Mantenedor;

use Pan\Utils\ValidatePan as validatePan;

class TablasTipo extends \pan\Kore\Controller{
	
	private $_DAOFormulariosTipo;

	public function __construct(){
		parent::__construct();
		$this->session->isValidate();

		$this->_DAOFormulariosTipo  = new \App\Formularios\Mantenedor\Entity\DAOFormulariosTipo;
	}

	#Tipos de Formulario
	public function TiposFormulario(){
        
		$this->view->addJS('mantenedorTablasTipo.js');
		$this->view->addJS('MantenedorTablasTipo.cargarGrillaTiposFormulario()');

		$this->view->set('contenido', $this->view->fetchIt('tablasTipo/TiposFormulario/index'));
		$this->view->render();
	}

	public function cargarGrillaTiposFormulario(){
    
		$params  = $this->request->getParametros();
		$getData = $this->_DAOFormulariosTipo->getLista($params);
	
		$this->view->set('arrDatos', ($getData != NULL ? $getData : array()));
		$this->view->render("tablasTipo/TiposFormulario/grilla");	
	}
	#Fin Tipos de Formulario


	#Bloque
	public function desplegarAgregarTipo($table, $field){

		#valida isset
		if(!isset($table) || !isset($field)){
			echo 'Error de parametros';
			die;
		}

		$this->view->set('dTable', $table);
		$this->view->set('dField', $field);
		$this->view->render("tablasTipo/agregarTipo");
	}

	public function procesarTipo(){
		
		$params             = $this->request->getParametros();
		$result['correcto'] = false;
		$result['mensaje']  = 'Estimado/a, ha ocurrido un error en el registro.';
		
		$data = array(
			$params['dField'] => $params['dVal'],
			"id_usuario_crea" => $_SESSION[\Constantes::SESSION_BASE]['id']
		);

		$resultInsert = $this->$params['dTable']->create($data);

		if(!is_null($resultInsert)){
			$result['correcto'] = true;
			$result['mensaje']  = 'Estimado/a, el registro se ha realizado con exito.';
		}
		
		echo json_encode($result);
	}

	public function setEstado(){

		$params  		    = $this->request->getParametros();
		
		$result['correcto'] = false;
		$result['mensaje']  = 'Estimado/a, ha ocurrido un error en el registro.';
		
		$data = array(
			"bo_activo" => $params['operacion'] == 'enable' ? 1 : 0
		); 

		$resultUpdate = $this->$params['dTable']->update($data, $params['id']);

		if(!is_null($resultUpdate)){
			$result['correcto'] = true;
			$result['mensaje']  = 'Estimado/a, el registro se ha realizado con exito.';
		}

		echo json_encode($result);
	  }
	  #Fin Bloque
}