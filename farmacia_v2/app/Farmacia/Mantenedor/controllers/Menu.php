<?php
/**
 ******************************************************************************
 * Sistema           : Mis Fiscalizaciones
 *
 * Descripción       : Controlador de Mantenedor:Menu
 *
 * Plataforma        : PHP
 *
 * Creación          : 18/07/2019
 *
 * @name             Menu.php
 *
 * @version          1.0.0
 *
 * @author           Sebastian Carroza <sebastian.Carroza@cosof.cl>
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
namespace App\Farmacia\Mantenedor;

class Menu extends \pan\Kore\Controller{

	//Inicializando Variables//
	protected $_DAOOpcion;
	protected $_DAOPerfil;

	public function __construct(){
		parent::__construct();
		$this->session->isValidate();

		$this->_DAOOpcion = new \App\_FuncionesGenerales\General\Entity\DAOAccesoOpcion;
		$this->_DAOPerfil = new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol;
		$this->_DAOModulo = new \App\_FuncionesGenerales\General\Entity\DAOAccesoModulo;
	}

	/**
	* Descripción	: Mostrar Grilla Menú
	* @author		: <victor.retamal@cosof.cl>    - 08/05/2018
	* @author		: <sebastian.Carroza@cosof.cl> - 18/07/2019
	*/
	public function index(){

		$this->view->addJS('mantenedorMenu.js');
		$arr_data	= $this->_DAOOpcion->getListaDetalle();
		$arrModulo	= $this->_DAOModulo->getLista();
		$this->view->set('arr_data', $arr_data);
		$this->view->set('arrModulo', $arrModulo);
		$this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_menu']['filtros']);
		$this->view->set('grilla', $this->view->fetchIt('menu/grilla'));
		$this->view->set('contenido', $this->view->fetchIt('menu/index'));
		$this->view->render();
	}

	/**
	* Descripción	: Mostrar Formulario para Agregar Menú Padre
	* @author		: <victor.retamal@cosof.cl>    - 08/05/2018
	* @author		: <sebastian.Carroza@cosof.cl> - 18/07/2019
	*/
	public function agregarMenu(){

        $arr_padre  = $this->_DAOOpcion->getAllMenuPadre();
        $arrModulo	= $this->_DAOModulo->getLista();
        
        $this->view->set('arr_padre', $arr_padre);
        $this->view->set('arrModulo', $arrModulo);
		$this->view->render('menu/agregar');

	}
	/**
	* Descripción	: Guardar Menu Padre en la Base de Datos
	* @author		: <david.guzman@cosof.cl>      - 08/05/2018
	* @author		: <sebastian.Carroza@cosof.cl> - 18/07/2019
	* @param array $parametros con los datos a guardar
	*/
	public function agregarMenuBD(){

		$parametros 	= $this->request->getParametros();
		$id_opcion		= $this->_DAOOpcion->insertMenu($parametros);

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
	* @author		: <victor.retamal@cosof.cl>    - 08/05/2018
	* @author		: <sebastian.Carroza@cosof.cl> - 19/07/2019
	* @param int $id_opcion ID del MenuOpcion
	*/
	public function editarMenu($id_opcion){

		$data		= $this->_DAOOpcion->getById($id_opcion);
		$arr_padre	= $this->_DAOOpcion->getAllMenuPadre();
		$arrModulo	= $this->_DAOModulo->getLista();

		$this->view->set('itm', $data);
		$this->view->set('arr_padre', $arr_padre);
		$this->view->set('arrModulo', $arrModulo);

		$this->view->render('menu/editar_opcion');

	}

	/**
	* Descripción	: Editar Opción en la Base de Datos
	* @author		: <david.guzman@cosof.cl>      - 08/05/2018
	* @author		: <sebastian.Carroza@cosof.cl> - 19/07/2019
	* @param array $parametros con los datos a guardar
	*/
	public function editarMenuBD(){
		$parametros 	= $this->request->getParametros();

		$id_opcion		= $this->_DAOOpcion->editarOpcion($parametros);

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
        $_SESSION[\Constantes::SESSION_BASE]['mantenedor_menu']['filtros'] = $params;
        
		$this->view->set('arr_data', $arr_data);
		$grilla = $this->view->fetchIt('menu/grilla');

        echo json_encode(array("grilla"=>$grilla));
	}

}
