<?php

namespace App\Farmacia\Medico;
use Pan\Utils\ValidatePan as validatePan;

/**
 ******************************************************************************
 * Sistema           : HOPE
 *
 * Descripción       : Controlador Login
 *
 * Plataforma        : PHP
 *
 * Creación          : 04/09/2020
 *
 * @name             AdminMedico.php 
 *
 * @version          1.0.0
 *
 * @author			Camila Figueroa
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha			Descripción
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

class AdminMedico extends \pan\Kore\Controller{

	public function __construct(){

		parent::__construct();
        
		$this->_DAORegion				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOComuna				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOUsuario				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;				
		$this->_DAOProfesion			=	new \App\_FuncionesGenerales\General\Entity\DAOProfesion;
		$this->_DAOCodigoRegion			=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;
		$this->_DAOTerritorio			=	new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOMedico				=	new \App\Farmacia\Medico\Entity\DAOMedico();
		$this->_DAOEspecialidad			=	new \App\Farmacia\Medico\Entity\DAOEspecialidad();
        
	}

	public function index(){

		$this->view->addJS('adminMedico.js');
		$this->view->addJS('validador.js', 'pub/js/');
		$this->view->addJS('utils.js', 'pub/js/');
		$this->view->set('grilla',    $this->view->fetchIt('adminMedico/grillaMedico'));
		$this->view->set('contenido', $this->view->fetchIt('adminMedico/menuMedico'));
        $this->view->render();
        
	}


	/**
	* Descripción	: Construye la grilla en la vista de listado de Medicos
	* @author		: Camila Figueroa
	*/
    public function grillaMedicos(){

        $params     = $this->request->getParametros();
		$arrMedicos = $this->_DAOMedico->getListaMedicos($params);
        $arrGrilla  = array('data'=>array());

		if(!empty($arrMedicos)){
            foreach($arrMedicos as $item){
				$arr    = array();
			
                $arr['nombre']      = $item->gl_nombre_completo;
                $arr['email']       = $item->gl_email;
                $arr['rut']    = $item->gl_rut;

                $arr['opciones']    = ' <button type="button" class="btn btn-xs btn-primary"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Medico/AdminMedico/editarMedico/'.$item->id_medico.'\',\''. addslashes(\Traduce::texto("Editar Medico")) .' <b>'.$item->gl_nombre_completo.'</b>\',\'90\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Editar Medico").'"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs btn-warning" id="info_button"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Medico/AdminMedico/verInfoMedico/'.$item->id_medico.'\',\''.\Traduce::texto("DETALLE MEDICO CIRUJANO").'\',\'lg\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Ver Información").'"><i class="fa fa-search"></i>
                                        </button>
                                        ';


                if($item->bo_activo == 1){
                    $arr['opciones']    .= ' <button type="button" class="btn btn-xs btn-danger"
                                                onclick="MantenedorMedico.habilitarMedico(\''.$item->id_medico.'\',0);"												
                                                data-toggle="tooltip" title="'.\Traduce::texto("Deshabilitar").'"><i class="fas fa-lock"></i>
                                            </button>
                                            ';
                }else{
                    $arr['opciones']    .= ' <button type="button" class="btn btn-xs btn-success"
                                                onclick="MantenedorMedico.habilitarMedico(\''.$item->id_medico.'\',1);"
                                                data-toggle="tooltip" title="'.\Traduce::texto("Habilitar").'"><i class="fas fa-unlock"></i>
                                            </button>
                                            ';
                }

                $arrGrilla['data'][] = $arr;
            }
        }
		
		echo json_encode($arrGrilla);
		
	}

		/**
	* Descripción : Cambia estado de medico por habilitado/inhabilitado según corresponda
	* @author Camila Figueroa 
	*/
	public function habilitarMedico(){
		$json       = array("correcto" => false);
        $params     = $this->request->getParametros();
        $bo_update  = $this->_DAOMedico->actualizaEstadoMedico($params['id_medico'],$params['bo_activo']);
        if($bo_update){
            $json	= array("correcto" => true);
        }		
        echo json_encode($json);
	}

	

		/**
	* Descripción	: Visualizar informacion de medico
	* @author		: Camila Figueroa
	*/
	public function verInfoMedico($id_medico){
		$this->session->isValidate();
		$arrDatosMedico 	= $this->_DAOMedico->getMedicoById($id_medico);
		$arrRegion      	= $this->_DAORegion->getLista();
		$arrComuna      	= $this->_DAOComuna->getLista();
		$arrConsultas      	= $this->_DAOMedico->getConsultasMedicoById($id_medico);
		$arrEspecialidad	= $this->_DAOEspecialidad->getLista();
		$gl_nombre_completo = $arrDatosMedico->gl_nombre." ".$arrDatosMedico->gl_paterno." ".$arrDatosMedico->gl_materno;
		$this->view->set('nombreCompleto', $gl_nombre_completo);
		$this->view->set('arrDatosMedico', $arrDatosMedico);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrEspecialidad', $arrEspecialidad);
		$this->view->set('arrConsultas', $arrConsultas);
		$this->view->set('datosMedico',  $this->view->fetchIt('adminMedico/verInfoMedico.php'));
		
		$this->view->render('adminMedico/footerVerMedico.php');
	}


	/**
	* Descripción	: Visualizar informacion de medico
	* @author		: Camila Figueroa
	*/
	public function editarMedico($id_medico){

		$this->session->isValidate();
		$arrDatosMedico 	= $this->_DAOMedico->getMedicoById($id_medico);
		$arrEspecialidad	= $this->_DAOEspecialidad->getLista();
		$arrProfesion		= $this->_DAOProfesion->getLista();
		$arrConsultas      	= $this->_DAOMedico->getConsultasMedicoById($id_medico);
		$arrRegion      	= $this->_DAORegion->getLista();
		$arrComuna      	= $this->_DAOComuna->getLista();		
		$this->view->addJS('$(".labelauty").labelauty();');	
		$this->view->set('arrDatosMedico', $arrDatosMedico);
		$this->view->set('arrEspecialidad', $arrEspecialidad);
		$this->view->set('arrProfesion', $arrProfesion);
		$this->view->set('arrConsultas', $arrConsultas);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('idMedico', $id_medico);
		$this->view->set('datosMedico',  $this->view->fetchIt('adminMedico/editarMedico.php'));
		
		$this->view->render('adminMedico/guardarCambiosMedico.php');
	}

	/**
	 * Descripción	: Permite llamar a vista para creacion de nuevo medico
	 * @author		: Camila Figueroa
	 */
	public function agregarMedico()
	{
		$this->session->isValidate();
		
        $arrRegion     		= $this->_DAORegion->getLista();
        $arrTerritorio      = $this->_DAOTerritorio->getLista();
		$arrCodRegion   	= $this->_DAOCodigoRegion->getLista();
		$arrComuna 			= $this->_DAOComuna->getLista();
		$arrEspecialidad	= $this->_DAOEspecialidad->getLista();
		$arrProfesion		= $this->_DAOProfesion->getLista();
		
		$this->view->addJS('$("#fc_nacimiento_medico").datepicker({language:"es", format: "dd/mm/yyyy",startDate: "-99y", endDate: "-18y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$(".labelauty").labelauty();');	
		$this->view->addJS('adminMedico.js');			
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrTerritorio', $arrTerritorio);
		$this->view->set('arrCodRegion', $arrCodRegion);		
		$this->view->set('arrEspecialidad', $arrEspecialidad);		
		$this->view->set('arrProfesion', $arrProfesion);		
		$this->view->set('datosMedico',   $this->view->fetchIt('adminMedico/nuevoMedico'));
		$this->view->render('adminMedico/agregarMedico.php');
		
	}


	/**
	* Descripción : Crea en base de datos - médico / usuario / consultas según corresponda
	* @param : 
	*   $params['form'][1]['value'] => RUT
    *	$params['form'][2]['value'] => EMAIL
    *	$params['form'][3]['value'] => FECHA NACIMIENTO
    *	$params['form'][4]['value'] => ID PROFESION    	
    *	$params['form'][5]['value'] => ID ESPECIALIDAD
    *	$params['form'][6]['value'] => NOMBRE
    *	$params['form'][7]['value'] => APELLIDO PATERNO
	*	$params['form'][8]['value'] => APELLIDO MATERNO
    *	$params['form'][9]['value'] => GENERO MEDICO
	* @author Camila Figueroa
	*/
	public function crearMedicoBD(){

		$params         	= $this->request->getParametros();
		$gl_genero 			= ($params['form'][9]['value']=="M")?"Masculino":"Femenino";
		$fc_nacimiento  	= date("Y-m-d",(strtotime(str_replace("/","-",$params['form'][3]['value']))));
		$gl_rut				= trim($params['form'][1]['value']);
		$gl_nombre			= trim($params['form'][6]['value']);
		$gl_paterno			= trim($params['form'][7]['value']);
		$gl_materno			= trim($params['form'][8]['value']);
		$gl_email			= trim($params['form'][2]['value']);
		$id_especialidad    = trim($params['form'][5]['value']);
		$id_region			= "";
		$id_comuna          = "";
		$gl_direccion 		= "consultas";
		$cd_fono 			= "";
		$gl_telefono 		= "";
		$pass               = "123"; 
		$gl_password        = \Seguridad::generar_sha512($pass);
		$mu_pass            = \Seguridad::generar_sha1($pass);
		$gl_token           = \Seguridad::generaTokenUsuario($gl_rut);
		$idUsuario          = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;		
		$existeUsuario = $this->_DAOMedico->existeUsuario($gl_rut);
		$existeRutMedico = $this->_DAOMedico->existeMedico($gl_rut);
		if($existeRutMedico==0){
			if($existeUsuario==0){// si es que el usuario NO existe 
				$datosUsuario = array(			
					$gl_token,
					$gl_rut,
					$gl_rut,
					$gl_nombre,
					$gl_paterno,
					$gl_materno,
					strtolower($gl_genero),
					$fc_nacimiento,	
					$gl_email,
					$id_region,
					"",
					$gl_direccion,
					$cd_fono,
					$gl_telefono,		
					"",
					$mu_pass,
					1 	
				);
				$crearNuevoUsuario = $this->_DAOUsuario->insertNuevo($datosUsuario);			
				$id_usuario = $crearNuevoUsuario;
				$datosMedico = array(
					$id_usuario, //usuario recientemente creado
					$gl_rut,
					$gl_rut,
					$gl_nombre,
					$gl_paterno,
					$gl_materno,
					strtolower($gl_genero),
					$fc_nacimiento,
					$gl_email,
					$id_region,
					$id_comuna,
					"",
					"",
					"",
					1,
					$id_especialidad
				);
				$crearNuevoMedico = $this->_DAOMedico->insertaMedico($datosMedico);
				$id_medico = $crearNuevoMedico;

			}else{ // si es que el usuario existe
				$id_usuario = $this->_DAOMedico->getIdUsuarioByRut($gl_rut);	
				$actualizaUsuario = $this->_DAOMedico->actualizaMailUsuario($id_usuario, $gl_email);		
				$datosMedico = array(
					$id_usuario, //usuario recientemente creado
					$gl_rut,
					$gl_rut,
					$gl_nombre,
					$gl_paterno,
					$gl_materno,
					strtolower($gl_genero),
					$fc_nacimiento,
					$gl_email,
					$id_region,
					$id_comuna,
					"",
					"",
					"",
					1,
					$id_especialidad
				);
				$crearNuevoMedico = $this->_DAOMedico->insertaMedico($datosMedico);
				$id_medico = $crearNuevoMedico;

			}

			for($i=0;$i<sizeof($params["consultas"]);$i++){
				$id_region				= trim($params["consultas"][$i][0]);
				$id_comuna				= trim($params["consultas"][$i][1]);
				$gl_direccion			= trim($params["consultas"][$i][2]);
				$gl_telefono			= trim($params["consultas"][$i][3]);
				$id_medico				= $id_medico; 
				$gl_cod					= "56";
				$fc_creacion			= "";
				$fc_actualizacion		= "";
				$bo_estado				= 1;

				$datosConsulta = array(
					$id_medico,
					$id_region,
					$id_comuna,
					$gl_direccion,
					$gl_cod,
					$gl_telefono
				);
				$ingresoConsulta = $this->_DAOMedico->insertaConsulta($datosConsulta);
				//file_put_contents('php://stderr', PHP_EOL."insertaConsulta resultado : ".print_r($ingresoConsulta, TRUE). PHP_EOL, FILE_APPEND);
			}

			if($ingresoConsulta>0){
				$correcto = "OK";
				$error = false;
			}else{
				$correcto = null;
				$error = true;
			}

		}else{
			$correcto = "RUT";
			$error = true;	
		}
		$json= json_encode(array("correcto" => $correcto, "error" => $error));
		echo ($json);
		
	}

	/**
	* Descripción : Edita en base de datos - médico / usuario / consultas según corresponda
	* @param : 
	*   $params['form'][1]['value'] => RUT
    *	$params['form'][2]['value'] => EMAIL
    *	$params['form'][3]['value'] => FECHA NACIMIENTO
    *	$params['form'][4]['value'] => ID PROFESION    	
    *	$params['form'][5]['value'] => ID ESPECIALIDAD
    *	$params['form'][6]['value'] => NOMBRE
    *	$params['form'][7]['value'] => APELLIDO PATERNO
	*	$params['form'][8]['value'] => APELLIDO MATERNO
    *	$params['form'][9]['value'] => GENERO MEDICO
	* @author Camila Figueroa
	*/
	public function editarMedicoBD(){

		$params         	= $this->request->getParametros();		
		$gl_genero 			= ($params['form'][9]['value']=="M")?"Masculino":"Femenino";
		$fc_nacimiento  	= date("Y-m-d",(strtotime(str_replace("/","-",$params['form'][3]['value']))));
		$gl_rut				= trim($params['form'][1]['value']);
		$gl_nombre			= trim($params['form'][6]['value']);
		$gl_paterno			= trim($params['form'][7]['value']);
		$gl_materno			= trim($params['form'][8]['value']);
		$gl_email			= trim($params['form'][2]['value']);
		$id_especialidad    = trim($params['form'][5]['value']);
		//--------------vacios porque medico posee sucursales-----------//
		$id_region			= "";
		$id_comuna          = "";
		$gl_direccion 		= ""; 
		$cd_fono 			= "";
		$gl_telefono 		= "";
		//--------------------------------------------------------------//
		$pass               = "123"; 
		$gl_password        = \Seguridad::generar_sha512($pass);
		$mu_pass            = \Seguridad::generar_sha1($pass);
		$gl_token           = \Seguridad::generaTokenUsuario($gl_rut);
		$idUsuario          = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;
		$id_medico 			= trim($params['id_medico']);		
		$id_usuario = $this->_DAOMedico->getIdUsuarioByRut($gl_rut);
		$error_creacion_usuario = 0;
		$actualizaMedico = 1;

			if($id_usuario>0){	//valido que exista el usuario en BD
				$actualizaUsuario = $this->_DAOMedico->actualizaMailUsuario($id_usuario, $gl_email);		
				$datosMedico = array(
					strtolower($gl_genero),
					$id_usuario,
					$gl_email,
					$id_especialidad,
					$id_medico
				);
				$actualizaMedico = $this->_DAOMedico->actualizaMedico($datosMedico); //falta validar que se actualizo correctamente			
			}else{ //en caso de que no exista usuario registrado
				// creo el usuario 
				$datosUsuario = array(			
					$gl_token,
					$gl_rut,
					$gl_rut,
					$gl_nombre,
					$gl_paterno,
					$gl_materno,
					strtolower($gl_genero),
					$fc_nacimiento,	
					$gl_email,
					$id_region,
					"",
					$gl_direccion,
					$cd_fono,
					$gl_telefono,		
					"",
					$mu_pass,
					1 			
				);
				$crearNuevoUsuario = $this->_DAOUsuario->insertNuevo($datosUsuario);
				if($crearNuevoUsuario>0){
					$id_usuario = $crearNuevoUsuario;			
					$datosMedico = array(
						strtolower($gl_genero),
						$id_usuario,
						$gl_email,
						$id_especialidad,
						$id_medico
					);
					// actualizo los datos del medico
					$actualizaMedico = $this->_DAOMedico->actualizaMedico($datosMedico); 
				}else{
					$error_creacion_usuario = 1;
				}
			}
			
			if($error_creacion_usuario==0 && $actualizaMedico>0){ //valido el caso en que se haya tenido que crear un usuario nuevo ,con error y la actualizacion de medico
				// se borran las consultas anteriores y se insertan las nuevas
				$borraConsultas = $this->_DAOMedico->borrarConsultasMedico($id_medico); //new			
				for($i=0;$i<sizeof($params["consultas"]);$i++){
					$id_region				= trim($params["consultas"][$i][0]);
					$id_comuna				= trim($params["consultas"][$i][1]);
					$gl_direccion			= trim($params["consultas"][$i][2]);
					$gl_telefono			= trim($params["consultas"][$i][3]);
					$id_medico				= $id_medico; 
					$gl_cod					= "";
					$fc_creacion			= "";
					$fc_actualizacion		= "";
					$bo_estado				= 1;

					$datosConsulta = array(
						$id_medico,
						$id_region,
						$id_comuna,
						$gl_direccion,
						$gl_cod,
						$gl_telefono
					);				
					$ingresoConsulta = $this->_DAOMedico->insertaConsulta($datosConsulta);				
				}
			}
			//valido que se haya actualizado el medico y creado las consultas 
			if(isset($actualizaMedico)&&($actualizaMedico>0)){ 
				if($ingresoConsulta>0){
					if($error_creacion_usuario==0){
						$correcto = "OK";
						$error = false;
					}else{
						$correcto = null;
						$error = true;
					}				
				}else{
					$correcto = null;
					$error = true;
				}
			}else{
					$correcto = null;
					$error = true;
			}

		$json= json_encode(array("correcto" => $correcto, "error" => $error));
		echo ($json);
	
	}
}
