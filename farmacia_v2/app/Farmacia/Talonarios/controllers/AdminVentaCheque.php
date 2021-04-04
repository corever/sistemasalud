<?php

namespace App\Farmacia\Talonarios;


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
 * @name             AdminVentaCheque.php - Ejemplo para copiar y pegar
 *
 * @version          1.0.0
 *
 * @author			<david.guzman@cosof.cl>
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
use Pan\Utils\ValidatePan as validatePan;
use App\Farmacia\Talonarios\Entity as Entities;

class AdminVentaCheque extends \pan\Kore\Controller{

	/*Inicializando Variables*/
	//protected 	$_DAOUsuario;
    private	$_DAOAsignacionTalonario;
    private	$_DAOTalonario;
    private	$_DAOBodega;
    private	$_DAOVenta;

	public function __construct(){

		parent::__construct();
        
        //$this->_DAOUsuario  				= new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;
        $this->_DAOAsignacionTalonario 		= new Entities\DAOAsignacionTalonario;
        $this->_DAOTalonario 				= new Entities\DAOTalonario;
        $this->_DAOBodega 					= new \App\Farmacia\Bodegas\Entity\DAOBodega;
        $this->_DAOVenta 					= new \App\_FuncionesGenerales\General\Entity\DAOVenta;
        
	}

	public function index(){

        //$this->view->addJS('$("#fc_venta_talonario").daterangepicker({locale:"es", format: "dd/mm/yyyy", autoclose: true, orientation: "top"}).on("hide", function(e) { e.stopPropagation();});');
        $this->view->addJS('adminVentaCheque.js');
        $this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['adminVentaCheque']['filtros']);
        $this->view->set('grilla', $this->view->fetchIt('adminVentaCheque/grilla'));
        $this->view->set('filtros', $this->view->fetchIt('adminVentaCheque/filtros'));
        $this->view->set('contenido', $this->view->fetchIt('adminVentaCheque/index'));
        $this->view->render();
        
	}

    /**
     * Descripción	: Grilla Talonarios Asignados
     * @author		: <david.guzman@cosof.cl> - 10/09/2020
     */
    public function grillaTalonariosAsignados()
    {

		$params 		= $this->request->getParametros();
		$id_bodega		= 0;
        $arrRoles		= $_SESSION[\Constantes::SESSION_BASE]['arrRoles'];
        
        //Guardo Filtros en SESSION
        // $_SESSION[\Constantes::SESSION_BASE]['mantenedor_asignarTalonario']['filtros']   = $params;

		if(!empty($arrRoles)){
			foreach($arrRoles as $rol){
				//si es rol vendedor talonario busca id_bodega para buscar talonarios disponibles
				if($rol->mur_fk_rol == 5){
                    $id_bodega = $rol->fk_bodega;
                    $params['id_bodega'] = $id_bodega;
				}
			}
		}

        $arrVentaTalonarios = $this->_DAOVenta->getListaDetalleByBodega($params);
        
        $arrGrilla  = array('data' => array());

        //Guardo Filtros en SESSION
        $_SESSION[\Constantes::SESSION_BASE]['adminVentaCheque']['filtros']   = $params;

        if (!empty($arrVentaTalonarios)) {
            foreach ($arrVentaTalonarios as $item) {
                $boCumpleAnularVenta    = (empty($item->gl_tramite) || empty($item->comprobante_pago))?1:0; //Revisa si cumple para que aparezca opcion de anular venta

                $arr    				= array();
                $arr['id'] 		        = $item->venta_id;
                $arr['fecha_venta']     = \Fechas::formatearHtml($item->fecha_transaccion,"-");
                $arr['medico'] 			= ($item->gl_nombre_medico != "")?$item->gl_nombre_medico." ".$item->gl_apellidop_medico." ".$item->gl_apellidom_medico:"Medico no encontrado en sistema";
                $arr['serie'] 			= $item->gl_serie;
                $arr['codigo'] 			= $item->comprobante_pago." ".\Fechas::formatearHtml($item->fecha_pago,"-");
                $arr['estado'] 			= ($item->estado_pago == 0)?"<b style=color:red>NULO<b>":"";
                $arr['acciones'] 		= '<button class="btn btn-success btn-xs" type="button" onclick="window.open(\' '. \Pan\Uri\Uri::getBaseUri() .'Farmacia/Talonarios/Talonario/verBoleta/'.$item->venta_id.'/\');" title="Descargar PDF"><i class="fa fa-file"></i> </button>';
                $arr['acciones']        .= ($boCumpleAnularVenta)?'&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="AdminVentaCheque.anularVenta('.$item->venta_id.');" title="Anular Venta"><i class="fa fa-times"></i> </button>':'';
                $arrGrilla['data'][]    = $arr;
            }
        }

        echo json_encode($arrGrilla);
    }

    /**
    * Descripción	: Anular Talonario
    * @author		: <david.guzman@cosof.cl> - 10/09/2020
    */
    public function anularTalonario(){
        $this->session->isValidate();
        $params 	            = $this->request->getParametros();
        $id_venta               = $params['id_venta'];
        $salida 	            = array("correcto"=>false,"msgError"=>"");

        if($id_venta > 0){
            $this->_DAOVenta->setEstadoVenta($id_venta,0);
            $salida['correcto'] = true;
        }else{
            $salida['msgError'] = "No se pudo anular, favor comuníquese con Mesa de Ayuda.";
        }

        echo json_encode($salida);
    }

}
