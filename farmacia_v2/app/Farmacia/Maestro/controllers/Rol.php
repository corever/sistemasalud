<?php

/**
 ******************************************************************************
 * Sistema           : FARMACIA V2
 *
 * Descripción       : Controlador de Maestro Rol
 *
 * Plataforma        : PHP
 *
 * Creación          : 21/09/2019
 *
 * @name             Rol.php
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
use Seguridad;

class Rol extends \pan\Kore\Controller{
    
    private $_DAORol;
    private $_DAOOpcion;
    private $_DAORolOpcion;
    private $_DAOModulo;

	public function __construct(){
		parent::__construct();
		$this->session->isValidate();

		$this->_DAORol 		    = new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol;
		$this->_DAOOpcion 	    = new \App\_FuncionesGenerales\General\Entity\DAOAccesoOpcion;
		$this->_DAORolOpcion    = new \App\_FuncionesGenerales\General\Entity\DAOAccesoRolOpcion;
		$this->_DAOUsuarioRol   = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioRol;
		$this->_DAOModulo       = new \App\_FuncionesGenerales\General\Entity\DAOAccesoModulo;
	}

	public function index(){
        
        //$arrRoles    = $this->_DAORol->getLista();
        //$this->view->set('arrRoles',$arrRoles);
        $this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['maestro_rol']['filtros']);
        
		$this->view->addJS('maestroRol.js');
		$this->view->addJS('MaestroRol.buscar()');
		$this->view->set('contenido', $this->view->fetchIt('rol/index'));
		$this->view->render();
	}

	/**
	* Descripción	: Desplegar Formulario para Agregar Rol
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function agregarRol(){
		$opciones           = $this->_DAOModulo->getLista(1);
		$subOpciones        = $this->_DAOOpcion->getLista(1);

		$this->view->set('arr_padre',$opciones);
		$this->view->set('arr_opcion',$subOpciones);
		$this->view->set('opRol',array());
		$this->view->set('boAgregar',true);
		
		$this->view->render('rol/agregar_rol.php');
	}

	/**
	* Descripción	: Guardar Rol en la Base de Datos
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $params con los datos a guardar
	*/
	public function agregarRolBD(){
        
		$params         = $this->request->getParametros();
        $arr_opcion     = json_decode($params['arr_opcion'],true);
        $bo_nacional    = ($params['gl_territorialidad']=='bo_territorialidad_nacional')?1:0;
        $bo_regional    = ($params['gl_territorialidad']=='bo_territorialidad_regional')?1:0;
        
		$data           = array(    $params['gl_nombre_rol'],
                                    $params['gl_nombre_vista_rol'],
                                    \Seguridad::generar_sha1($params['gl_nombre_rol']),
                                    $bo_nacional,
                                    $bo_regional,
                                    $_SESSION[\Constantes::SESSION_BASE]['id']
                        );

		$id_rol		= $this->_DAORol->insertarNuevo($data);
        
		if($id_rol){
			$correcto	= true;
			$mensaje	= 'Estimado Usuario:<br>El rol se ha creado exitosamente';
			$bo_activo          = 1;

			foreach($arr_opcion as $opcion){
				$param	= array(
                                    $id_rol,
                                    $opcion['name'],
                                    $bo_activo,
                                    $_SESSION[\Constantes::SESSION_BASE]['id']
								);
				$this->_DAORolOpcion->insertar($param);
			}
		}else{
			$correcto	= false;
			$mensaje	= 'Estimado Usuario:<br>Hubo problemas al crear el rol nuevo.';
		}

		$json	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        
        echo json_encode($json);
	}

	/**
	* Descripción	: Desplegar Formulario para Editar Rol
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function editarRol($gl_token){

		$opciones           = $this->_DAOModulo->getLista(1);
		$subOpciones        = $this->_DAOOpcion->getLista(1);
        $arrRol             = $this->_DAORol->getByToken($gl_token);
        $opcionesRol        = $this->_DAORolOpcion->getOpcionesByRol($arrRol->rol_id);
        $opRol              = explode(',',$opcionesRol->opRol);
        $opRolPadre         = explode(',',$opcionesRol->opRolPadre);
        /*
        $arrModulo          = $this->_DAOModulo->getLista();
		$arrOpcionesRol 	= $this->_DAORolOpcion->getByRol($arrRol->rol_id);
		$arrPermisoOpcion	= array();

		foreach($arrOpcionesRol as $opcion){
			$permisoOpRol    = array("1"=>$opcion->bo_agregar,"2"=>$opcion->bo_modificar,"3"=>$opcion->bo_eliminar);
			$arrPermisoOpcion[$opcion->id_opcion] = $permisoOpRol;
        }
        */
        
		$this->view->set('arr_padre',$opciones);
		$this->view->set('arr_opcion',$subOpciones);
		$this->view->set('opRol',$opRol);
		$this->view->set('opRolPadre',$opRolPadre);
		$this->view->set('arr',$arrRol);
		//$this->view->set('arrModulo',$arrModulo);
		//$this->view->set('arrPermisoOpcion',$arrPermisoOpcion);
		
		$this->view->render('rol/agregar_rol.php');
	}

	/**
	* Descripción	: Guardar Rol en la Base de Datos
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $params con los datos a guardar
	*/
	public function editarRolBD(){
		$params       	= $this->request->getParametros();
        $id_rol    	    = $params['id_rol'];
        $arr_opcion  	= json_decode($params['arr_opcion'],true);
        $bo_nacional    = ($params['gl_territorialidad']=='bo_territorialidad_nacional')?1:0;
        $bo_regional    = ($params['gl_territorialidad']=='bo_territorialidad_regional')?1:0;
        $bo_activo   	= 1;
        
		$data_rol = array(	
			"rol_nombre"		    => Seguridad::validar($params['gl_nombre_rol'], 'string'),
			"rol_nombre_vista"      => Seguridad::validar($params['gl_nombre_vista_rol'], 'string'),
            "bo_nacional"           => $bo_nacional,
            "bo_regional"           => $bo_regional,
            "id_usuario_actualiza"	=> $this->session->getSession('id')
		);

		$boModificado	= $this->_DAORol->update($data_rol,$id_rol);
        
		if($boModificado){
			$correcto	= true;
			$mensaje	= 'El rol se ha editado exitosamente';

            //Deshabilito todos los roles para en foreach activar los correspondientes
			$this->_DAORolOpcion->setAllActivoByRol($id_rol,0);
            
            //activo los correspondientes que guardo y si no existe lo inserta
            foreach($arr_opcion as $itemOpcion){
				foreach($itemOpcion as $idOpcion => $item){
                    $id_opcion 		= $idOpcion;
                    /*
					$bo_agregar 	= intval($item['1']);
					$bo_modificar 	= intval($item['2']);
                    $bo_eliminar 	= intval($item['3']);
                    */
				}
				
				$param      	= array(
										$id_rol,
										$id_opcion,
										$bo_activo,
										$_SESSION[\Constantes::SESSION_BASE]['id']
								);
                
                //busca si existe
                $arrRolOpcion = $this->_DAORolOpcion->getByRolOpcion($id_rol,$id_opcion);

                if(!empty($arrRolOpcion)){
                    //si no está activo -> activar ; si está activo -> no es necesario hacer nada
                    if($arrRolOpcion->bo_activo == 0){
						$datos = array("bo_activo"=>$bo_activo);
						$this->_DAORolOpcion->modificar($id_rol,$id_opcion,$datos);
                    }
                }else{
                    //si no existe se inserta
                    $this->_DAORolOpcion->insertar($param);
                }
			}
		}else{
			$correcto	= false;
			$mensaje	= 'Estimado Usuario:<br>Hubo problemas al editar el rol.';
		}

		$json	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        
        echo json_encode($json);
	}
    
    /**
	* Descripción	: Grilla rol
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
    public function buscar(){

        $params     = $this->request->getParametros();
		$arrRoles   = $this->_DAORol->getListaBuscar($params);
        $grilla     = "";
        
        $_SESSION[\Constantes::SESSION_BASE]['maestro_rol']['filtros'] = $params;
        
        $this->view->set('arrRoles',$arrRoles);
        $grilla     = $this->view->fetchIt('rol/grilla');

        echo json_encode(array("grilla"=>$grilla));
	}
    
    /**
	* Descripción	: set bo_activo de rol
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
    public function setActivo(){

        $respuesta  = array("correcto"=>false,"mensaje"=>"Hubo Problemas para Actualizar.");
        $params     = $this->request->getParametros();
        $gl_token   = $params['gl_token'];
        $bo_activo  = $params['bo_activo'];
        $update     = $this->_DAORol->setActivo($gl_token,$bo_activo);
        
        if($update){
            $respuesta['correcto']  = true;
            $respuesta['mensaje']   = "";
        }

        echo json_encode($respuesta);
	}

}