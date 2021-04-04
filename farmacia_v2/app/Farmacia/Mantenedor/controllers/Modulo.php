<?php
/**
 ******************************************************************************
 * Sistema           : HOPE OPS
 *
 * Descripción       : Controlador de Mantenedor:Modulo
 *
 * Plataforma        : PHP
 *
 * Creación          : 08/06/2020
 *
 * @name             Modulo.php
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
namespace App\Farmacia\Mantenedor;

use Pan\Utils\ValidatePan as validatePan;

class Modulo extends \pan\Kore\Controller{
    
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
	}

	public function index(){
        
        $arrPerfiles    = $this->_DAOPerfil->getLista();
        $this->view->set('arrPerfiles',$arrPerfiles);
        $this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_perfil']['filtros']);
        
        $this->view->addJS('mantenedorModulo.js');
		$this->view->set('contenido', $this->view->fetchIt('modulo/index'));
		$this->view->render();
	}

	/**
	* Descripción	: Desplegar Formulario para Agregar Perfil
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function agregarPerfil(){
		$opciones           = $this->_DAOOpcion->getAllOpcionesPadre(1);
        $subOpciones        = $this->_DAOOpcion->getAllOpcionesHijo(1);

		$this->view->set('arr_padre',$opciones);
		$this->view->set('arr_opcion',$subOpciones);
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
        
		$this->view->set('arr_padre',$opciones);
		$this->view->set('arr_opcion',$subOpciones);
		$this->view->set('opPerfil',$opPerfil);
		$this->view->set('arr',$arrPerfil);
		
		$this->view->render('perfil/agregar_perfil.php');
	}

	/**
	* Descripción	: Guardar Perfil en la Base de Datos
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $params con los datos a guardar
	*/
	public function editarPerfilBD(){
		$params             = $this->request->getParametros();
        $id_perfil          = $params['id_perfil'];
        $arr_opcion         = json_decode($params['arr_opcion'],true);
        $bo_activo          = 1;
        
		$data           = array($params['gl_nombre_perfil'],
                                $params['gl_descripcion_perfil'],
								$_SESSION[\Constantes::SESSION_BASE]['id']
                            );
        
		$boModificado   = $this->_DAOPerfil->modificar($id_perfil,$data);
        
		if($boModificado){
			$correcto	= true;
			$mensaje	= 'El perfil se ha editado exitosamente';

            //Deshabilito todos los perfiles para en foreach activar los correspondientes
			$this->_DAOPerfilOpcion->setAllActivoByPerfil($id_perfil,0);
            
            //activo los correspondientes que guardo y si no existe lo inserta
            foreach($arr_opcion as $opcion){
                $id_opcion  = $opcion['name'];
				$param      = array(
                                    $id_perfil,
                                    $id_opcion,
                                    $bo_activo,
                                    $_SESSION[\Constantes::SESSION_BASE]['id']
								);
                
                //busca si existe
                $arrPerfilOpcion = $this->_DAOPerfilOpcion->getByPerfilOpcion($id_perfil,$id_opcion);
                if(!empty($arrPerfilOpcion)){
                    //si no está activo -> activar ; si está activo -> no es necesario hacer nada
                    if($arrPerfilOpcion->bo_activo == 0){
                        $this->_DAOPerfilOpcion->setActivoByPerfilOpcion($id_perfil,$id_opcion,$bo_activo);
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
