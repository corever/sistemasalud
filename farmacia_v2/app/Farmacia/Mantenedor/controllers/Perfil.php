<?php
/**
 ******************************************************************************
 * Sistema           : Mis Fiscalizaciones
 *
 * Descripción       : Controlador de Mantenedor:Perfil
 *
 * Plataforma        : PHP
 *
 * Creación          : 19/07/2019
 *
 * @name             Perfil.php
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

use Pan\Utils\ValidatePan as validatePan;

class Perfil extends \pan\Kore\Controller{
    
    private $_DAOPerfil;
    private $_DAOOpcion;
    private $_DAOPerfilOpcion;
    private $_DAOUsuarioPerfil;

	public function __construct(){
		parent::__construct();
		$this->session->isValidate();

		$this->_DAOPerfil 		 = new \App\_FuncionesGenerales\Entity\DAOAccesoPerfil;
		$this->_DAOOpcion 		 = new \App\_FuncionesGenerales\Entity\DAOAccesoOpcion;
		$this->_DAOPerfilOpcion  = new \App\_FuncionesGenerales\Entity\DAOAccesoPerfilOpcion;
		$this->_DAOUsuarioPerfil = new \App\_FuncionesGenerales\Entity\DAOAccesoUsuarioPerfil;
		$this->_DAOModulo      	 = new \App\_FuncionesGenerales\Entity\DAOAccesoModulo;
	}

	public function index(){
        
        $arrPerfiles    = $this->_DAOPerfil->getLista();
        $this->view->set('arrPerfiles',$arrPerfiles);
        $this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_perfil']['filtros']);
        
        $this->view->addJS('mantenedorPerfil.js');
		$this->view->set('contenido', $this->view->fetchIt('perfil/index'));
		$this->view->render();
	}

	/**
	* Descripción	: Desplegar Formulario para Agregar Perfil
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function agregarPerfil(){
		$opciones           = $this->_DAOOpcion->getAllOpcionesPadre(1);
		$subOpciones        = $this->_DAOOpcion->getAllOpcionesHijo(1);
		$arrModulo          = $this->_DAOModulo->getLista();

		$this->view->set('arr_padre',$opciones);
		$this->view->set('arr_opcion',$subOpciones);
		$this->view->set('arrModulo',$arrModulo);
		$this->view->set('opPerfil',array());
		
		$this->view->render('perfil/agregar_perfil.php');
	}

	/**
	* Descripción	: Guardar Perfil en la Base de Datos
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $params con los datos a guardar
	*/
	public function agregarPerfilBD(){
        
		$params         = $this->request->getParametros();
        $arr_opcion     = json_decode($params['arr_opcion'],true);
        
		$data           = array(    $params['gl_nombre_perfil'],
                                    $params['gl_descripcion_perfil'],
                                    $_SESSION[\Constantes::SESSION_BASE]['id']
                        );

		$id_perfil		= $this->_DAOPerfil->insertarNuevo($data);
        
		if($id_perfil){
			$correcto	= true;
			$mensaje	= 'Estimado Usuario:<br>El perfil se ha creado exitosamente';
			$bo_activo          = 1;

			foreach($arr_opcion as $opcion){
				$param	= array(
                                    $id_perfil,
                                    $opcion['name'],
                                    $bo_activo,
                                    $_SESSION[\Constantes::SESSION_BASE]['id']
								);
				$this->_DAOPerfilOpcion->insertar($param);
			}
		}else{
			$correcto	= false;
			$mensaje	= 'Estimado Usuario:<br>Hubo problemas al crear el perfil nuevo.';
		}

		$json	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        
        echo json_encode($json);
	}

	/**
	* Descripción	: Desplegar Formulario para Editar Perfil
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function editarPerfil($gl_token){
		$opciones           = $this->_DAOOpcion->getAllOpcionesPadre(1);
        $subOpciones        = $this->_DAOOpcion->getAllOpcionesHijo(1);
        $arrPerfil          = $this->_DAOPerfil->getByToken($gl_token);
        $opcionesPerfil     = $this->_DAOPerfilOpcion->getOpcionesByPerfil($arrPerfil->id_perfil);
        $opPerfil           = explode(',',$opcionesPerfil->opPerfil);
		$arrModulo          = $this->_DAOModulo->getLista();
		$arrOpcionesPerfil 	= $this->_DAOPerfilOpcion->getByPerfil($arrPerfil->id_perfil);
		$arrPermisoOpcion	= array();

		foreach($arrOpcionesPerfil as $opcion){
			$permisoOpPerfil    = array("1"=>$opcion->bo_agregar,"2"=>$opcion->bo_modificar,"3"=>$opcion->bo_eliminar);
			$arrPermisoOpcion[$opcion->id_opcion] = $permisoOpPerfil;
		}
        
		$this->view->set('arr_padre',$opciones);
		$this->view->set('arr_opcion',$subOpciones);
		$this->view->set('opPerfil',$opPerfil);
		$this->view->set('arr',$arrPerfil);
		$this->view->set('arrModulo',$arrModulo);
		$this->view->set('arrPermisoOpcion',$arrPermisoOpcion);
		
		$this->view->render('perfil/agregar_perfil.php');
	}

	/**
	* Descripción	: Guardar Perfil en la Base de Datos
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $params con los datos a guardar
	*/
	public function editarPerfilBD(){
		$params       	= $this->request->getParametros();
        $id_perfil    	= $params['id_perfil'];
        $arr_opcion  	= json_decode($params['arr_opcion'],true);
        $bo_activo   	= 1;
		$data       	= array($params['gl_nombre_perfil'],
									$params['gl_descripcion_perfil'],
									$_SESSION[\Constantes::SESSION_BASE]['id']
                            );
		$boModificado	= $this->_DAOPerfil->modificar($id_perfil,$data);
        
		if($boModificado){
			$correcto	= true;
			$mensaje	= 'El perfil se ha editado exitosamente';

            //Deshabilito todos los perfiles para en foreach activar los correspondientes
			$this->_DAOPerfilOpcion->setAllActivoByPerfil($id_perfil,0);
            
            //activo los correspondientes que guardo y si no existe lo inserta
            foreach($arr_opcion as $itemOpcion){
				foreach($itemOpcion as $idOpcion => $item){
					$id_opcion 		= $idOpcion;
					$bo_agregar 	= intval($item['1']);
					$bo_modificar 	= intval($item['2']);
					$bo_eliminar 	= intval($item['3']);
				}
				
				$param      	= array(
										$id_perfil,
										$id_opcion,
										$bo_agregar,
										$bo_modificar,
										$bo_eliminar,
										$bo_activo,
										$_SESSION[\Constantes::SESSION_BASE]['id']
								);
                
                //busca si existe
                $arrPerfilOpcion = $this->_DAOPerfilOpcion->getByPerfilOpcion($id_perfil,$id_opcion);
                if(!empty($arrPerfilOpcion)){
                    //si no está activo -> activar ; si está activo -> no es necesario hacer nada
                    if($arrPerfilOpcion->bo_activo == 0){
						$datos = array("bo_activo"=>$bo_activo,"bo_agregar"=>$bo_agregar,"bo_modificar"=>$bo_modificar,"bo_eliminar"=>$bo_eliminar);
						$this->_DAOPerfilOpcion->modificar($id_perfil,$id_opcion,$datos);
                    }
                }else{
                    //si no existe se inserta
                    $this->_DAOPerfilOpcion->insertar($param);
                }
			}
		}else{
			$correcto	= false;
			$mensaje	= 'Estimado Usuario:<br>Hubo problemas al editar el perfil.';
		}

		$json	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        
        echo json_encode($json);
	}
    
    /**
	* Descripción	: Grilla perfil
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
    public function buscar(){

        $params         = $this->request->getParametros();
		$arrPerfiles    = $this->_DAOPerfil->getListaBuscar($params);
        $grilla         = "";
        
        $_SESSION[\Constantes::SESSION_BASE]['mantenedor_perfil']['filtros'] = $params;
        
        $this->view->set('arrPerfiles',$arrPerfiles);
        $grilla     = $this->view->fetchIt('perfil/grilla');

        echo json_encode(array("grilla"=>$grilla));
	}

}
