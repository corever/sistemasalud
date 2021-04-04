<?php

namespace App\Farmacia\Talonarios;

/**
 ******************************************************************************
 * Sistema           : Farmacia
 *
 * Descripción       : Controlador de ListaTalonario
 *
 * Plataforma        : PHP
 *
 * Creación          : 19/08/2020
 *
 * @name             ListaTalonario.php
 *
 * @version          1.0.0
 *
 * @author           Ricardo Muñoz <ricardo.munoz@cosof.cl>
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

use Pan\Utils\ValidatePan as validatePan;
use DateTimeZone;

class ListaTalonario extends \pan\Kore\Controller
{

    private $_DAOTalonario;
    private $_DAOTalonariosCreados;
    private $_DAOTalonarioTipoDocumento;
    private $_DAOTalonarioTipoProveedor;
    private $_DAOAsignacionTalonario;
    private $_DAOTalonarioTipoMotivo;

    public function __construct()
    {
        parent::__construct();
        $this->session->isValidate();

        $this->_DAOTalonario = new \App\Farmacia\Talonarios\Entity\DAOTalonario;
        $this->_DAOAsignacionTalonario = new \App\Farmacia\Talonarios\Entity\DAOAsignacionTalonario;
        $this->_DAOTalonariosCreados = new \App\Farmacia\Talonarios\Entity\DAOTalonariosCreados;
        $this->_DAOTalonarioTipoDocumento = new \App\Farmacia\Talonarios\Entity\DAOTalonarioTipoDocumento;
        $this->_DAOTalonarioTipoProveedor = new \App\Farmacia\Talonarios\Entity\DAOTalonarioTipoProveedor;
        $this->_DAOTalonarioTipoMotivo = new \App\Farmacia\Talonarios\Entity\DAOTalonarioTipoMotivo;
    }

    public function index()
    {

        $this->session->isValidate();

        // $this->view->addJS('validador.js', 'pub/js/');
        $this->view->addJS('listaTalonario.js');

        $this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_listaTalonarios']['filtros']);

        $this->view->set('listaTalonario_filtros', $this->view->fetchIt('listaTalonario/listaTalonario_filtros'));
        $this->view->set('listaTalonario_grilla', $this->view->fetchIt('listaTalonario/listaTalonario_grilla'));
        $this->view->set('contenido', $this->view->fetchIt('listaTalonario/listaTalonario_index'));
        $this->view->render();
    }

    /**
     * Descripción	: Grilla Talonarios Creados
     * @author		: <ricardo.munoz@cosof.cl> - 25/08/2020
     */
    public function grillaTalonariosCreados()
    {

        $params     = $this->request->getParametros();

        //Guardo Filtros en SESSION
        $_SESSION[\Constantes::SESSION_BASE]['mantenedor_listaTalonarios']['filtros']   = $params;

        // // $arrBodegas = $this->_DAOBodega->all($params);
        // $arrFiltros["bodega_estado"] = 1;
        // // if (!empty($params["bodega_nombre"])) {
        // //     $arrFiltros["bodega_nombre"] = "%".$params["bodega_nombre"]."%";
        // // }
        // // if (!empty($params["bodega_direccion"])) {
        // //     $arrFiltros["bodega_direccion"] = $params["bodega_direccion"];
        // // }
        // if (!empty($params["fk_bodega_tipo"]) && 0 !== (int)$params["fk_bodega_tipo"]) {
        //     $arrFiltros["fk_bodega_tipo"] = (int)$params["fk_bodega_tipo"];
        // }
        // if (!empty($params["fk_region"]) && 0 !== (int)$params["fk_region"]) {
        //     $arrFiltros["fk_region"] = $params["fk_region"];
        // }

        // // var_dump($arrFiltros);

        $arrFiltros["bo_estado"] = 2;
        $arrTalonariosCreados = $this->_DAOTalonariosCreados->where($arrFiltros, "")->runQuery()->getRows();

        $arrGrilla  = array('data' => array());

        if (!empty($arrTalonariosCreados)) {
            foreach ($arrTalonariosCreados as $item) {
                $arr    = array();

                $TalonarioTipoProveedor  = $this->_DAOTalonarioTipoProveedor->getByPK($item->proveedor);
                $TalonarioTipoDocumento  = $this->_DAOTalonarioTipoDocumento->getByPK($item->documento);

                $arr['tc_id'] = $item->tc_id;
                $arr['gl_token'] = $item->gl_token;
                $arr['serie'] = $item->talonario_serie;
                $arr['folio_inicial'] = $item->talonario_folio_inicial;
                $arr['folio_final'] = $item->talonario_folio_final;
                $arr['cantidad'] = $item->cantidad;
                $arr['cheques'] = $item->cheques;
                $arr['proveedor'] = $TalonarioTipoProveedor->gl_talonario_tipo_proveedor;
                $arr['documento'] = $TalonarioTipoDocumento->gl_talonario_tipo_documento;
                $arr['nr_documento'] = $item->nr_documento;
                $arr['fc_documento'] = $item->fc_documento;

                $arr['opciones']    = '
                    <button type="button" class="btn btn-xs " title="' . \Traduce::texto("Ver") . '"
                        onclick="document.forms.formTalonarioDisponible_' . $item->tc_id . '.submit();">
                        <i class="fa fa-eye"></i>
                    </button> 
                    <button type="button" class="btn btn-xs inhabilitarLoteTalonarios "
                        data-toggle="tooltip" title="' . \Traduce::texto("Eliminar Talonarios") . '"><i class="fa fa-times"></i>
                    </button> 
                    <form name="formTalonarioDisponible_' . $item->tc_id . '" method="POST" action="' . \pan\uri\Uri::getHost() . 'Farmacia/Talonarios/TalonarioDisponible/' . '">
                        <input type="hidden" name="tc_id" value="' . $item->tc_id . '"/>
                    </form>
                    ';

                $arrGrilla['data'][] = $arr;
            }
        }

        echo json_encode($arrGrilla);
    }

    /**
     * Descripción	: Inhabilitar Talonarios Creados en Lote
     * @author		: <ricardo.munoz@cosof.cl> - 07/09/2020
     */
    public function formInhabilitarLoteTalonarios($gl_token)
    {
        $this->session->isValidate();

        $arrFiltros["gl_token"] = $gl_token;

        $TalonariosCreados = $this->_DAOTalonariosCreados->where($arrFiltros, "")->runQuery()->getRows()[0];

        $arrTalonarioTipoMotivo = $this->_DAOTalonarioTipoMotivo->all();

        $this->view->set('arrTalonarioTipoMotivo', $arrTalonarioTipoMotivo);
        $this->view->set('TalonariosCreados', $TalonariosCreados);

        $this->view->render('listaTalonario/inhabilitar_lote_talonarios');
    }

    /**
     * Descripción	: Inhabilitar Talonarios Creados en Lote
     * @author		: <ricardo.munoz@cosof.cl> - 07/09/2020
     */
    public function inhabilitarLoteTalonarios()
    {
        $correcto = false;
        $error = false;
        $mensaje = "";

        $params = $this->request->getParametros();

        $gl_token = "null";
        $id_motivo = 0;
        $gl_observacion = "";

        extract($params);
        unset($params);

        if (!isset($gl_token)) {
            $error = true;
            $mensaje .= "- Error. Favor comuniquese con soporte.</br>";
        }

        /**
         * validar que token exista
         */
        $arrFiltros["gl_token"] = $gl_token;
        // $arrFiltros["gl_token"] = "gl_token";
        $TalonariosCreados = $this->_DAOTalonariosCreados->where($arrFiltros, "")->runQuery()->getRows()[0];
        // var_dump($TalonariosCreados);
        if (!$TalonariosCreados->gl_token) {
            $error = true;
            $mensaje .= "- El talonario no existe.</br>";
        }

        /**
         * validar motivo y observacion
         */
        if (0 === (int)$id_motivo) {
            $error = true;
            $mensaje .= "- Por favor, seleccione un Motivo.</br>";
        }
        if ("" == trim($gl_observacion)) {
            $error = true;
            $mensaje .= "- Por favor, ingrese una Observación.</br>";
        }

        if (!$error) {

            $arrFiltrosTalonarios["fk_tc_id"] = $TalonariosCreados->tc_id;
            $arrTalonarios = $this->_DAOTalonario->where($arrFiltrosTalonarios)->runQuery()->getRows();

            $bo_ExisteUnTalonarioVendido = false;
            foreach ($arrTalonarios as $key => $Talonario) {
                // busca si está vendido en asignacion_talonario
                $arrFiltrosAsignacionTalonario["fk_talonario"] = $Talonario->talonario_id;
                $AsignacionTalonario = $this->_DAOAsignacionTalonario->where($arrFiltrosAsignacionTalonario)->runQuery()->getRows()[0];

                if (1 === (int)$AsignacionTalonario->Venta) {
                    $bo_ExisteUnTalonarioVendido = true;
                }
            }

            if ($bo_ExisteUnTalonarioVendido) {
                $error = true;
                $mensaje .= "- No se puede realizar esta acción en lote, ya que existe un talonario vendido.</br>";
            } else {

                $correcto = true;

                foreach ($arrTalonarios as $key => $Talonario) {
                    // actualizar talonarios en lote
                    $idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 999;
                    $params["id_usuario_actualizacion"] = $idUsuario;
                    $params["fc_actualizacion"] = (new \DateTime("now",  new \DateTimeZone('UTC')))->format("Y-m-d H:i:s");
                    $this->_DAOTalonario->update($params,  $Talonario->talonario_id);

                    $arrFiltrosAsignacionTalonario["fk_talonario"] = $Talonario->talonario_id;
                    $AsignacionTalonario = $this->_DAOAsignacionTalonario->where($arrFiltrosAsignacionTalonario)->runQuery()->getRows()[0];

                    // Estado 3 = Inhabilitado por usuario	
                    $params["estado_talonario"] = 3;
                    $params["estado_talonario_bi"] = 3;
                    $params["estado_talonario_lv"] = 3;

                    $this->_DAOAsignacionTalonario->update($params,  $AsignacionTalonario->talonario_id);

                    unset($params["estado_talonario"], $params["estado_talonario_bi"], $params["estado_talonario_lv"]);
                }

                // actualizar talonarios_creados Inhabilita
                // $params["tc_id"] = $TalonariosCreados->tc_id;
                $params["bo_estado"] = 0;
                $TalonariosCreados = $this->_DAOTalonariosCreados->update($params, $TalonariosCreados->tc_id);

                $mensaje .= "- Se ha Inhabilitado el Lote de Talonarios.</br>";
            }
        }
        $json   = array("correcto" => $correcto, "error" => $error, "mensaje" => $mensaje);

        echo json_encode($json);
    }
}
