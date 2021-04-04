<?php

namespace App\Farmacia\Turnos;
use Pan\Utils\ValidatePan as validatePan;


/**
 ******************************************************************************
 * Sistema           : HOPE
 *
 * Descripción       : Controlador Login
 *
 * Plataforma        : PHP
 *
 * Creación          : 24/08/2020
 *
 * @name             AdminSeremi.php - Ejemplo para copiar y pegar
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

class AdminSeremi extends \pan\Kore\Controller{

	/*Inicializando Variables*/
	protected $_DAOUsuario;
	
	public function __construct(){

		parent::__construct();
		$this->session->isValidate();

		$this->_DAORegion				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOComuna				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAORol					=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol;
		$this->_DAOUsuario				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;
		$this->_DAOUsuarioRol			=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioRol;
		$this->_DAOUsuarioHistorial		=	new \App\Usuario\Entity\DAOUsuarioHistorial();
		$this->_DAOModulo				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoModulo;
		$this->_DAOUsuarioModulo		=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioModulo;
		$this->_DAOIdioma				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoIdioma;
		$this->_DAOOpcion				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoOpcion;
		$this->_DAOUsuarioOpcion		=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioOpcion;
		$this->_DAORolOpcion			=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoRolOpcion;
		$this->_DAOProfesion			=	new \App\_FuncionesGenerales\General\Entity\DAOProfesion;
		$this->_DAOCodigoRegion			=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;
		$this->_DAOTerritorio			=	new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOBodega				=	new \App\_FuncionesGenerales\General\Entity\DAOBodega;
		$this->_DAODirectorTecnico		=	new \App\_FuncionesGenerales\General\Entity\DAODirectorTecnico;
		$this->_DAOSeremi				=	new \App\Farmacia\Turnos\Entity\DAOSeremi();
		
		$this->_DAOLocal				=	new \App\Farmacias\Farmacia\Entities\DAOLocal;
		$this->_DAOFarmacia				=	new \App\Farmacias\Farmacia\Entities\DAOFarmacia;
        
	}

	public function index(){
		$arrRegion			=	NULL;

		$this->view->addJS('adminSeremi.js');		
		$this->view->addJS('validador.js', 'pub/js/');
		$this->view->addJS('utils.js', 'pub/js/');
		$this->view->set('arrRegion', $arrRegion);

		//$this->view->set('filtros',   $this->view->fetchIt('adminSeremi/filtrosSeremi'));
		$this->view->set('grilla',    $this->view->fetchIt('adminSeremi/grillaSeremi'));
		$this->view->set('contenido', $this->view->fetchIt('adminSeremi/menuSeremi'));
		
        $this->view->render();
        
	}


	/**
	* Descripción	: Construye la grilla en la vista de listado de Seremis
	* @author		: Camila Figueroa
	*/
    public function grillaSeremis(){

        $params     = $this->request->getParametros();
		$arrUsuario = $this->_DAOSeremi->getListaSeremis($params);
        $arrGrilla  = array('data'=>array());

        //Guardo Filtros en SESSION
		$_SESSION[\Constantes::SESSION_BASE]['seremi']['filtros']   = $params;
		$this->limpiarCacheFirma(2);
		if(!empty($arrUsuario)){
            foreach($arrUsuario as $item){
				$arr    = array();
			
                $arr['nombre']      = $item->gl_nombre_completo;
                $arr['email']       = $item->gl_email;
                $arr['telefono']    = $item->gl_telefono;

                $arr['opciones']    = ' <button type="button" class="btn btn-xs btn-primary"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Turnos/AdminSeremi/editarSeremi/'.$item->id_seremi.'\',\''. addslashes(\Traduce::texto("Editar Seremi")) .' <b>'.$item->gl_nombre_completo.'</b>\',\'90\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Editar Seremi").'"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs btn-warning" id="info_button"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Turnos/AdminSeremi/verInfoSeremi/'.$item->id_seremi.'\',\''.\Traduce::texto("Información de ").' <b>'.$item->gl_nombre_completo.'</b>\',\'lg\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Ver Información").'"><i class="fa fa-search"></i>
                                        </button>
                                        ';


                if($item->bo_activo == 1){
                    $arr['opciones']    .= ' <button type="button" class="btn btn-xs btn-danger"
                                                onclick="MantenedorSeremi.habilitarSeremi(\''.$item->id_seremi.'\',0);"
                                                data-toggle="tooltip" title="'.\Traduce::texto("Deshabilitar").'"><i class="fas fa-lock"></i>
                                            </button>
                                            ';
                }else{
                    $arr['opciones']    .= ' <button type="button" class="btn btn-xs btn-success"
                                                onclick="MantenedorSeremi.habilitarSeremi(\''.$item->id_seremi.'\',1);"
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
	 * Descripción	: Permite agregar un nuevo seremi
	 * @author		: Camila Figueroa
	 */
	public function agregarSeremi()
	{
		$this->session->isValidate();

		$arrTrato   		= $this->_DAOSeremi->getListaOrdenadaTrato();
        $arrRegion     		= $this->_DAORegion->getLista();
        $arrTerritorio      = $this->_DAOTerritorio->getLista();
		$arrCodRegion   	= $this->_DAOCodigoRegion->getLista();
		$arrTiposDeFirmante = $this->_DAOSeremi->getTiposDeFirmante();
		
		$this->view->addJS('$("#fc_nacimiento_seremi").datepicker({language:"es", format: "dd/mm/yyyy",startDate: "-99y", endDate: "-18y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});
		$("#fc_ds").datepicker({language:"es", format: "dd/mm/yyyy", startDate: "-50y",autoclose: true}).on("hide", function(e) { e.stopPropagation();});
		$("#fc_ds_delegado").datepicker({language:"es", format: "dd/mm/yyyy", startDate: "-50y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');

		$this->view->addJS('$(".labelauty").labelauty();');
		$this->view->addJS('adjunto.js', 'app/_FuncionesGenerales/Adjuntos/assets/js');		
		$this->view->addJS('adminSeremi.js');	
		$this->view->set('boComentarioAdj', 0);
		$this->view->set('cantAdjuntos', 1);
		$this->view->set('idTipoAdjunto', 0);
		$this->view->set('extensionAdjunto', 'imagen');
		$this->view->set('idForm', 'adjFirma');
		$this->view->set('arrTrato', $arrTrato);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrTerritorio', $arrTerritorio);
		$this->view->set('arrCodRegion', $arrCodRegion);
		$this->view->set('arrTiposDeFirmante', $arrTiposDeFirmante);
		$this->limpiarCacheFirma(2);
		$this->view->set('datosSeremi',   $this->view->fetchIt('adminSeremi/nuevoSeremi'));
		$this->view->render('adminSeremi/agregarSeremi.php');
		
	}

	/**
	* Descripción : Cambia estado de seremi por habilitado/inhabilitado según corresponda
	* @author Camila Figueroa 
	*/
	public function habilitarSeremi(){
		$json       = array("correcto" => false);
        $params     = $this->request->getParametros();
        $bo_update  = $this->_DAOSeremi->actualizaEstadoSeremi($params['id_seremi'],$params['bo_activo']);

        if($bo_update){
            $json	= array("correcto" => true);
        }

        echo json_encode($json);
	}



	/**
	* Descripción	: Desplegar Formulario para Editar Usuario
	* @author		: Camila Figueroa
	*/
	public function editarSeremi($id_seremi){

		$this->session->isValidate();
		$arrDatosSeremi 	= $this->_DAOSeremi->getSeremiById($id_seremi);
		$arrTrato   		= $this->_DAOSeremi->getListaOrdenadaTrato();
        $arrRegion      	= $this->_DAORegion->getLista();
        $arrTerritorio      = $this->_DAOTerritorio->getLista();
		$arrCodRegion   	= $this->_DAOCodigoRegion->getLista();
		$arrTiposDeFirmante = $this->_DAOSeremi->getTiposDeFirmante();
		$tipoFirmante 		= $this->_DAOSeremi->getTipoFirmanteById($id_seremi);
		$adjunto 			= $this->_DAOSeremi->buscarAdjuntoById($id_seremi);
		$fc_crea ="";

		$this->limpiarCacheFirma(2);
		if($adjunto->gl_firma!=""){
			if($adjunto->fc_ds>=$adjunto->fc_ds_delegado){
				$fc_crea = $adjunto->fc_ds;		
				$carpeta = substr(strval($fc_crea),6);
				
			}else{
				$fc_crea = $adjunto->fc_ds_delegado;				
				$carpeta = substr(strval($fc_crea),6);
			}
			
			$ruta_archivo = FIRMAS_ROUTE."/".$carpeta."/".$id_seremi."/".$adjunto->gl_firma;
			$imagen = base64_encode(file_get_contents($ruta_archivo));
			
			$arrayAdjunto	=   array(
									"gl_nombre" 		=>$adjunto->gl_firma,
									"gl_mime" 			=>"image/png",
									"id_tipo" 			=>2,
									"gl_tipo" 			=>"Firma Imagen",
									"fc_crea" 			=>$fc_crea,
									"id_usuario_crea" 	=>$id_seremi,
									"bo_temporal" 		=>1,
									"contenido" 		=>$imagen,
								)												   
			;
			$_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjFirma']['adjuntos'][0] = $arrayAdjunto;
			
		}	
		file_put_contents('php://stderr', PHP_EOL."sesion editar : ".print_r($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjFirma']['adjuntos'][0], TRUE). PHP_EOL, FILE_APPEND);
		$this->view->addJS('$("#fc_nacimiento_seremi").datepicker({language:"es", format: "dd/mm/yyyy",startDate: "-99y", endDate: "-18y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});
		$("#fc_ds").datepicker({language:"es", format: "dd/mm/yyyy", startDate: "-50y",autoclose: true}).on("hide", function(e) { e.stopPropagation();});
		$("#fc_ds_delegado").datepicker({language:"es", format: "dd/mm/yyyy", startDate: "-50y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$(".labelauty").labelauty();');
		
		$this->view->addJS('adjunto.js', 'app/_FuncionesGenerales/Adjuntos/assets/js');
		if($adjunto->gl_firma!=""){
			$this->view->addJS('Adjunto.cargarGrilla("adjFirma");if($("#tabla-adjuntos").length>=1){$("#btnAdjuntar").prop("disabled",true);};$("#adjuntos").show();');
		}
		$this->view->set('boComentarioAdj', 0);
		$this->view->set('cantAdjuntos', 1);
		$this->view->set('idTipoAdjunto', 0);
		$this->view->set('extensionAdjunto', 'imagen');
		$this->view->set('idForm', 'adjFirma');
		
		$this->view->set('arrTrato', $arrTrato);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrTerritorio', $arrTerritorio);
		$this->view->set('arrCodRegion', $arrCodRegion);
		$this->view->set('arrDatosSeremi', $arrDatosSeremi);
		$this->view->set('arrTiposDeFirmante', $arrTiposDeFirmante);
		$this->view->set('tipoFirmante', $tipoFirmante);

		$this->view->set('datosSeremi',   $this->view->fetchIt('adminSeremi/editarSeremi.php'));
		$this->view->render('adminSeremi/guardarCambiosSeremi.php');

	}


	/**
	* Descripción	: Visualizar informacion de seremi
	* @author		: Camila Figueroa
	*/
	public function verInfoSeremi($id_seremi){

		$this->session->isValidate();

		$arrTrato   		= $this->_DAOSeremi->getListaOrdenadaTrato();
        $arrRegion      	= $this->_DAORegion->getLista();
        $arrTerritorio      = $this->_DAOTerritorio->getLista();
		$arrCodRegion   	= $this->_DAOCodigoRegion->getLista();
		$arrDatosSeremi 	= $this->_DAOSeremi->getSeremiById($id_seremi);
		$tipoFirmante 		= $this->_DAOSeremi->getTipoFirmanteById($id_seremi);
		$arrTiposDeFirmante = $this->_DAOSeremi->getTiposDeFirmante();
		$adjunto 			= $this->_DAOSeremi->buscarAdjuntoById($id_seremi);
		$fc_crea ="";
		$this->limpiarCacheFirma(2);
		if($adjunto->gl_firma!=""){
			if($adjunto->fc_ds>=$adjunto->fc_ds_delegado){
				$fc_crea = $adjunto->fc_ds;			
				$carpeta = substr(strval(str_replace(".","/",$fc_crea)),6);
				
			}else{
				$fc_crea = $adjunto->fc_ds_delegado;
				$carpeta = substr(strval(str_replace(".","/",$fc_crea)),6);
			}
			
			$ruta_archivo = FIRMAS_ROUTE."/".$carpeta."/".$id_seremi."/".$adjunto->gl_firma;
			$imagen = base64_encode(file_get_contents($ruta_archivo));
			
			$arrayAdjunto	=   array(
									"gl_nombre" 		=>$adjunto->gl_firma,
									"gl_mime" 			=>"image/png",
									"id_tipo" 			=>2,
									"gl_tipo" 			=>"Firma Imagen",
									"fc_crea" 			=>$fc_crea,
									"id_usuario_crea" 	=>$id_seremi,
									"bo_temporal" 		=>1,
									"contenido" 		=>$imagen,
								)												   
			;
			$_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjFirma']['adjuntos'][0] = $arrayAdjunto;
			
			
		}
		file_put_contents('php://stderr', PHP_EOL."sesion : ".print_r($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'], TRUE). PHP_EOL, FILE_APPEND);
		$this->view->addJS('$("#fc_nacimiento_seremi").datepicker({language:"es", format: "dd/mm/yyyy",startDate: "-99y", endDate: "-18y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});
		$("#fc_ds").datepicker({language:"es", format: "dd/mm/yyyy", startDate: "-50y",autoclose: true}).on("hide", function(e) { e.stopPropagation();});
		$("#fc_ds_delegado").datepicker({language:"es", format: "dd/mm/yyyy", startDate: "-50y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		
		$this->view->addJS('$(".labelauty").labelauty();');
		$this->view->addJS('$("#btnAdjuntar").hide();');
		if($adjunto->gl_firma!=""){
			$this->view->addJS('Adjunto.cargarGrilla("adjFirma"); $("#adjuntos").show(); ');
		}
		
		//$this->view->addJS('adminSeremi.js');		
		
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrTerritorio', $arrTerritorio);
		$this->view->set('arrDatosSeremi', $arrDatosSeremi);
		$this->view->set('tipoFirmante', $tipoFirmante);
		$this->view->set('arrTiposDeFirmante', $arrTiposDeFirmante);
		$this->view->set('datosSeremi',   $this->view->fetchIt('adminSeremi/verInfoSeremi.php'));
		
		$this->view->render('adminSeremi/footerVerSeremi.php');
	}


	/**
	* Descripción : Guardar datos editados de SEREMI y USUARIO
	* @author Camila Figueroa
	*/
	public function editarSeremiBD(){

		$params         	= $this->request->getParametros();
		$crearUsuario       = "";
		$crearSeremi        = "";
		$error          	= false;
		
		$fc_nacimiento  	= date_format(date_create(trim($params['fc_nacimiento_seremi'])),'Y-m-d');
		$id_usuario      	= str_replace("/","",trim($params['id_usuario']));		
		$id_seremi      	= str_replace("/","",trim($params['id_seremi']));
		$gl_trato      		= trim($params['id_trato_seremi']);
		$gl_nombre 			= trim($params['gl_nombre_seremi']);
		$gl_paterno 		= trim($params['gl_apellido_paterno_seremi']);
		$gl_materno 		= trim($params['gl_apellido_materno_seremi']);
		$gl_email 			= trim($params['gl_email_seremi']);
		$id_firmante 		= trim($params['id_tipo_firmante']);
		$gl_genero 			= strtolower(($params['chk_genero_seremi']=="M")?"Masculino":"Femenino");
		$gl_ds 				= trim($params['gl_ds_decreto']);
		$fc_ds 				= str_replace("//","",trim($params['fc_ds']));
		$id_region 			= trim($params['id_region_seremi']);
		$id_territorio 		= trim($params['id_territorio_seremi']);
		$gl_direccion 		= trim($params['gl_direccion_seremi']);
		$cd_fono			= trim($params['id_codregion_seremi']);
		$gl_telefono 		= trim($params['gl_telefono_seremi']);
		$gl_ds_delegado     = trim($params['gl_ds_decreto_delegado']);
		$fc_ds_delegada 	= str_replace("//","",trim($params['fc_ds_delegado']));	
		$gl_firma 			= $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjFirma']['adjuntos'];	
		$nombre_archivo 	= (isset($gl_firma[count($gl_firma)-1]['gl_nombre']))?$gl_firma[count($gl_firma)-1]['gl_nombre']:"";
		$contenido  		= $gl_firma[count($gl_firma)-1]['contenido'];	
		
		$datosSeremi = array(
			"fc_nacimiento" 		=>$fc_nacimiento,
			"gl_email" 				=>$gl_email,
			"id_usuario"			=>$id_usuario,
			"id_seremi"				=>$id_seremi,
			"gl_trato"				=>$gl_trato,
			"gl_nombre" 			=>$gl_nombre,
			"gl_paterno" 			=>$gl_paterno,
			"gl_materno" 			=>$gl_materno,
			"id_firmante" 			=>$id_firmante,
			"gl_genero" 			=>$gl_genero,
			"gl_ds" 				=>$gl_ds,								
			"fecha_ds" 				=>$fc_ds,
			"gl_ds_delegado"		=>$gl_ds_delegado,
			"fc_ds_delegada"		=>$fc_ds_delegada,
			"id_region" 			=>$id_region,
			"id_territorio" 		=>$id_territorio,
			"gl_direccion" 			=>$gl_direccion,
			"gl_telefono" 			=>$gl_telefono,
			"cd_fono"				=>$cd_fono,
			"fecha_actualizacion" 	=>date("Y-m-d H:i:s"),
			"id_genero" 			=>$params['chk_genero_seremi'],
			"gl_firma" 				=>$nombre_archivo
		);
		
		//Guardo en Disco 
		$ruta           = FIRMAS_ROUTE ."/".date('Y')."/".$id_seremi."/";
		$AdjGuardado    = \Adjunto::saveFile($ruta, base64_decode($contenido), $nombre_archivo);

		file_put_contents('php://stderr', PHP_EOL."ruta : ".print_r($ruta, TRUE). PHP_EOL, FILE_APPEND);

		$crearUsuario       	= $this->_DAOSeremi->modificarUsuario($datosSeremi);
		$crearSeremi       		= $this->_DAOSeremi->modificarSeremi($datosSeremi);


		if($crearUsuario==="OK"&&$crearSeremi==="OK"){
			$error 		= false;
			$correcto 	= "OK";
		}else{
			$error 		= true;
			$correcto 	= null;
		}

		$json			= array("correcto" => $correcto, "error" => $error);
		unset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjFirma']);
        echo json_encode($json);
	}


	/**
	* Descripción : Crea datos de seremi y usuario
	*Importante: aun no existe validacion de si es que el usuario ya está creado , esta pendiente
	* @author Camila Figueroa
	*/
	public function agregarSeremiBD(){

		$params         	= $this->request->getParametros();
		$crearUsuario       = "";
		$crearSeremi        = "";
		$error          	= false;
		$id_nuevo_seremi 	= 0;
		$id_nuevo_usuario = "";
		
		$gl_rut				= trim($params['gl_rut_seremi']);
		
		$pass               = "123"; 
		$gl_password        = \Seguridad::generar_sha512($pass);
		$mu_pass            = \Seguridad::generar_sha1($pass);
		$gl_token           = \Seguridad::generaTokenUsuario($gl_rut);
        $idUsuario          = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;

		$fc_nacimiento  	= date("Y-m-d",(strtotime(str_replace("/","-",$params['fc_nacimiento_seremi']))));
		$id_seremi      	= trim($params['id_seremi']);
		$gl_trato      		= trim($params['id_trato_seremi']);
		$gl_nombre 			= trim($params['gl_nombre_seremi']);
		$gl_paterno 		= trim($params['gl_apellido_paterno_seremi']);
		$gl_materno 		= trim($params['gl_apellido_materno_seremi']);
		$gl_email 			= trim($params['gl_email_seremi']);
		$id_firmante 		= trim($params['id_tipo_firmante']);
		$gl_genero 			= ($params['chk_genero_seremi']=="M")?"Masculino":"Femenino";
		$gl_ds 				= trim($params['gl_ds_decreto']);
		$fc_ds 				= trim($params['fc_ds']);
		$id_region 			= trim($params['id_region_seremi']);
		$id_territorio 		= trim($params['id_territorio_seremi']);
		$gl_direccion 		= trim($params['gl_direccion_seremi']);
		$cd_fono			= trim($params['id_codregion_seremi']);
		$gl_telefono 		= trim($params['gl_telefono_seremi']);
		$gl_ds_delegado     = trim($params['gl_ds_decreto_delegado']);
		$fc_ds_delegada 	= trim($params['fc_ds_delegado']);		
		//adjunto de firma
		
		$gl_firma 			= $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjFirma']['adjuntos'];	
		$nombre_archivo 	= (isset($gl_firma[count($gl_firma)-1]['gl_nombre']))?$gl_firma[count($gl_firma)-1]['gl_nombre']:"";
		$contenido  		= $gl_firma[count($gl_firma)-1]['contenido'];	
		$IdUsuarioRut = "";

		$existeUsuario = $this->_DAOSeremi->existeUsuario($gl_rut);
		if($existeUsuario==0){
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
				1 //activo			
			);

			$crearNuevoUsuario = $this->_DAOUsuario->insertNuevo($datosUsuario);

			if($crearNuevoUsuario>0){
				switch($id_firmante){
					case 1: //Delegada
						$id_rol = 16;
					break;
					case 2: //Firmante
						$id_rol = 17;
					break;
					case 3: //Firmante(s)
						$id_rol = 20;
					break;
				}

				$datosSeremi = array(
					$crearNuevoUsuario,
					$id_region,
					"",
					$params['chk_genero_seremi'],
					$gl_trato,
					"SECRETARIO REGIONAL MINISTERIAL DE SALUD",
					$gl_nombre." ".$gl_paterno." ".$gl_materno,	
					$gl_nombre,
					$gl_paterno,
					$gl_materno,
					$gl_direccion,
					$cd_fono.$gl_telefono,
					"",
					$gl_email,
					$gl_ds,
					str_replace("//","",$fc_ds),
					1,
					1,
					$nombre_archivo, //url_firma
					$id_rol, 
					$id_firmante,		
					$gl_ds_delegado,
					str_replace("//","",$fc_ds_delegada),
					$id_territorio
				);
				$crearNuevoSeremi = $this->_DAOSeremi->insertaSeremi($datosSeremi);
				if($crearNuevoSeremi>0){
					//Guardo en Disco el adjunto					
					$ruta           = FIRMAS_ROUTE ."/".date('Y')."/".$crearNuevoSeremi."/";
					$AdjGuardado    = \Adjunto::saveFile($ruta, base64_decode($contenido), $nombre_archivo);					
					$error = false;
					$correcto = "OK";					
				}else{

					$correcto = "No se ha podido crear el SEREMI, favor intente mas tarde";
					$error = true;
				}
			}else{
				$correcto = "No se ha podido crear el USUARIO, favor intente mas tarde";
				$error = true;				
			}		
		}else{
			//en caso de que el rut ingresado ya exista pero que posea diferente region y territorio
			$id_usuario = $this->_DAOSeremi->getIdUsuarioByRut($gl_rut);
			$seremiValido = $this->_DAOSeremi->validaNuevoSeremi($id_usuario,$id_territorio,$id_region);			
			if($seremiValido==0){
				
				switch($id_firmante){
					case 1: //Delegada
						$id_rol = 16;
					break;
					case 2: //Firmante
						$id_rol = 17;
					break;
					case 3: //Firmante(s)
						$id_rol = 20;
					break;
				}
				$datosSeremi = array(
					$id_usuario,
					$id_region,
					"",
					$params['chk_genero_seremi'],
					$gl_trato,
					"SECRETARIO REGIONAL MINISTERIAL DE SALUD",
					$gl_nombre." ".$gl_paterno." ".$gl_materno,	
					$gl_nombre,
					$gl_paterno,
					$gl_materno,
					$gl_direccion,
					$cd_fono.$gl_telefono,
					"",
					$gl_email,
					$gl_ds,
					str_replace("//","",$fc_ds),
					1,
					1,
					$nombre_archivo, //url_firma
					$id_rol, 
					$id_firmante,		
					$gl_ds_delegado,
					str_replace("//","",$fc_ds_delegada),
					$id_territorio
				);
				//realizo un update del correo del usuario
				$actualizaUsuario = $this->_DAOSeremi->actualizaMailUsuario($id_usuario, $gl_email);	
				//crea el seremi 
				$crearNuevoSeremi = $this->_DAOSeremi->insertaSeremi($datosSeremi);
				
				if($crearNuevoSeremi>0){
					$error = false;
					$correcto = "OK";					
				}else{
					$correcto = "No se pudo crear el SEREMI Ingresado, favor intente mas tarde";
					$error = true;
				}
				
			}else{
				//en caso de que el rut exista pero que posea la misma region y territorio
				// se mostrara por pantalla un mensaje de error y el seremi no se creara
				$correcto = "Ya existe un seremi registrado para el mismo RUT, REGION y TERRITORIO";
				$error = true;
			}
			
		}
		
		$json= json_encode(array("correcto" => $correcto, "error" => $error));
		echo ($json);
		
	}
	
	/**
	 * Realiza limpieza de caché 
	 * @param $tipo , es 2 si es que se llama del mismo controlador, null si es que se llama de javascript
	 * 
	 */
	public function limpiarCacheFirma($tipo){
		if(isset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjFirma'])){
			unset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjFirma']);		
		}
		if($tipo!=2){ 
			echo json_encode(array("correcto" => "OK", "error" => false));
		}
	}


}

