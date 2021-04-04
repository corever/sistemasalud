<?php

namespace App\Farmacia\Farmacias;


/**
 ******************************************************************************
 * Sistema           : Farmacia V2
 *
 * Descripción       : Controlador AdminSolicitudesDT
 *
 * Plataforma        : PHP
 *
 * Creación          : 14/09/2019
 *
 * @name             AdminSolicitudesDT.php
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

class AdminSolicitudesDT extends \pan\Kore\Controller{

	protected $_DAOAuditoriaLogin;	
	protected $_DAOPerfil;	

	public function __construct(){
		parent::__construct();
        				     
        $this->_DAOTraductor    	= 	new \App\_FuncionesGenerales\General\Entity\DAOTraductor();       
		$this->_DAORegion			=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOComuna			=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOTerritorio		=	new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOCodigoRegion		=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;		
		$this->_DAOProfesion		=	new \App\_FuncionesGenerales\General\Entity\DAOProfesion;
		$this->_DAOSolicitudes		=	new \App\Farmacia\Farmacias\Entity\DAOSolicitudesDT();
	}								

	public function index(){									
		$this->view->addJS('adminSolicitudesDT.js');
		$this->view->set('filtros',   $this->view->fetchIt('solicitudesDT/filtros'));
		$this->view->set('grilla',    $this->view->fetchIt('solicitudesDT/grilla'));
		$this->view->set('contenido', $this->view->fetchIt('solicitudesDT/index'));
        $this->view->render();		
	}


	/**
	* Descripción	: Grilla usuarios
	*/
    public function grillaSolicitudes(){

		$params     = $this->request->getParametros();
		file_put_contents('php://stderr', PHP_EOL . "arrUsuario ".print_r($params,TRUE).PHP_EOL, FILE_APPEND);
		$arrSolicitudes = $this->_DAOSolicitudes->getListaSolicitudes($params);
        $arrGrilla  = array('data'=>array());        
        //Guardo Filtros en SESSION
        //$_SESSION[\Constantes::SESSION_BASE]['mantenedor_solicitudes']['filtros']   = $params;


		if(!empty($arrSolicitudes)){
            foreach($arrSolicitudes as $item){
				$arr                    = array();
                $arr['solicitud']       = $item->id_solicitud;
                $arr['fecha']           = $item->fc_creacion;

                if($item->bo_asume==1){
                    $arr['tipo']        = "ASUME DIRECCION";
                }else{
                    $arr['tipo']        = "CESE DIRECCION";
                }
				
				switch($item->bo_declaracion){
					case 0:
						$arr['estado']      = "PENDIENTE";
					break;
					case 1:
						$arr['estado']      = "APROBADA";
					break;
					case 2: 
						$arr['estado']      = "RECHAZADA";
					break;
					default:
						$arr['estado']      = "NO DEFINIDO";
					break;
				}
              
                $arr['opciones']    = ' <button type="button" class="btn btn-xs btn-warning"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Farmacias/AdminSolicitudesDT/verHistorial/'.$item->gl_token.'\',\''. addslashes(\Traduce::texto("Editar Usuario")) .' <b>'.$item->gl_nombre_completo.'</b>\',\'90\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Ver Historial").'"><i class="fa fa-history"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs btn-danger"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Farmacias/AdminSolicitudesDT/revisarSolicitud/'.$item->gl_token.'\',\''.'Revisar solicitud N° '.' <b>'.$item->id_solicitud.'</b>\',\'90\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Revisar solicitud").'"><i class="fa fa-eye"></i>
                                        </button>
                                        ';

                $arrGrilla['data'][] = $arr;
            }
        }

        echo json_encode($arrGrilla);
	}

	/**
	* Descripción	: Desplegar Formulario para revisar solicitud
	*/
	public function revisarSolicitud($id_solicitud){

		$this->session->isValidate();
		
        $arrRegion      = $this->_DAORegion->getLista();
        $arrComuna      = $this->_DAOTerritorio->getLista();
		$arrCodRegion   = $this->_DAOCodigoRegion->getLista();

		$this->view->addJS('$("#fc_nacimiento_dt").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$("#fc_dns").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$(".labelauty").labelauty();');		
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrCodRegion', $arrCodRegion);
		$this->view->set('datosSolicitud',   $this->view->fetchIt('solicitudesDT/revisarSolicitud'));
		$this->view->render('solicitudesDT/footerRevisarSolicitud');
	}


	/**
	* Descripción	: Desplegar Formulario ver historial de solicitud	
	*/
	public function verHistorial($id_solicitud){

		$this->session->isValidate();
		
        $arrRegion      = $this->_DAORegion->getLista();
        $arrComuna      = $this->_DAOTerritorio->getLista();
		$arrCodRegion   = $this->_DAOCodigoRegion->getLista();

		$this->view->addJS('$("#fc_nacimiento_dt").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$("#fc_dns").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$(".labelauty").labelauty();');		
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrCodRegion', $arrCodRegion);
		$this->view->set('datosSolicitud',   $this->view->fetchIt('solicitudesDT/historialSolicitudes'));
		$this->view->render('solicitudesDT/footerHistorialSolicitudes');


	}

}
