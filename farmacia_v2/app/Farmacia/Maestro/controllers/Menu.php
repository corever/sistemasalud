<?php

/**
 ******************************************************************************
 * Sistema           : FARMACIA V2
 *
 * Descripción       : Controlador de Maestro Menú
 *
 * Plataforma        : PHP
 *
 * Creación          : 21/09/2020
 *
 * @name             Menu.php
 *
 * @version          1.0.0
 *
 * @author           David Guzmán <david.guzman@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador							Fecha		Descripción
 * ----------------------------------------------------------------------------
 *
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

namespace App\Farmacia\Maestro;

use Pan\Utils\ValidatePan as validatePan;

class Menu extends \pan\Kore\Controller{

	//Inicializando Variables//
	protected $_DAOOpcion;
	protected $_DAORol;
	protected $_DAOModulo;

	public function __construct(){
		parent::__construct();
		$this->session->isValidate();

		$this->_DAOOpcion   = new \App\_FuncionesGenerales\General\Entity\DAOAccesoOpcion;
		$this->_DAORol      = new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol;
		$this->_DAOModulo   = new \App\_FuncionesGenerales\General\Entity\DAOAccesoModulo;
	}

	/**
	* Descripción	: Mostrar Grilla Menú
	* @author		: <david.guzman@cosof.cl>    - 22/09/2020
	*/
	public function index(){

		$this->view->addJS('maestroMenu.js');
		$this->view->addJS('MaestroMenu.buscar()');

		//$arr_data	= $this->_DAOOpcion->getListaDetalle();
		$arrModulo	= $this->_DAOModulo->getLista(1);
		//$this->view->set('arr_data', $arr_data);
		$this->view->set('arrModulo', $arrModulo);
		$this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['maestro_menu']['filtros']);
		//$this->view->set('grilla', $this->view->fetchIt('menu/grilla'));
		$this->view->set('contenido', $this->view->fetchIt('menu/index'));
		$this->view->render();
	}

	/**
	* Descripción	: Mostrar Formulario para Agregar Menú Padre
	* @author		: <david.guzman@cosof.cl>    - 22/09/2020
	*/
	public function agregarMenu(){

        $arrModulo	= $this->_DAOModulo->getLista(1);
        $this->view->set('arrModulo', $arrModulo);
		$this->view->render('menu/agregar');

	}
	/**
	* Descripción	: Guardar Menu Padre en la Base de Datos
	* @author		: <david.guzman@cosof.cl>      - 22/09/2020
	* @param array $params con los datos a guardar
	*/
	public function agregarMenuBD(){

		$params 	= $this->request->getParametros();
		$id_opcion	= $this->_DAOOpcion->insertMenu($params);

		if($id_opcion){
			$correcto	= true;
			$mensaje	= 'La Opción se ha creado exitosamente';
		}else{
			$correcto	= false;
			$mensaje	= 'Hubo problemas al crear la opción nuevo.';
		}

		$salida	= array("correcto"	=> $correcto,
                        "mensaje"	=> $mensaje,
						);

		echo json_encode($salida, JSON_UNESCAPED_UNICODE);

	}
    
	/**
	* Descripción	: Mostrar Formulario para Editar Menú Opción
	* @author		: <david.guzman@cosof.cl>    - 22/09/2020
	* @param int $id_opcion ID del MenuOpcion
	*/
	public function editarMenu($id_opcion){

		$data		= $this->_DAOOpcion->getById($id_opcion);
		$arrModulo	= $this->_DAOModulo->getLista(1);
		$this->view->set('itm', $data);
		$this->view->set('arrModulo', $arrModulo);
		$this->view->render('menu/editar_opcion');

	}

	/**
	* Descripción	: Editar Opción en la Base de Datos
	* @author		: <david.guzman@cosof.cl>      - 22/09/2020
	* @param array $params con los datos a guardar
	*/
	public function editarMenuBD(){
		$params 	= $this->request->getParametros();
		$id_opcion	= $this->_DAOOpcion->editarOpcion($params);

		if($id_opcion){
			$correcto	= true;
			$mensaje	= 'La Opción se ha Editado exitosamente';
		}else{
			$correcto	= false;
			$mensaje	= 'Hubo problemas al Editar la opción.';
		}

		$salida	= array("correcto"	=> $correcto,
                        "mensaje"	=> $mensaje,
						);

		echo json_encode($salida, JSON_UNESCAPED_UNICODE);
	}
    
    /**
	* Descripción	: Grilla menu
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
    public function buscar(){

        $params         = $this->request->getParametros();
		$arr_data       = $this->_DAOOpcion->getListaBuscar($params);
        
        //guarda filtros en session
        $_SESSION[\Constantes::SESSION_BASE]['maestro_menu']['filtros'] = $params;
        
		$this->view->set('arr_data', $arr_data);
		$grilla = $this->view->fetchIt('menu/grilla');

        echo json_encode(array("grilla"=>$grilla));
	}

}
