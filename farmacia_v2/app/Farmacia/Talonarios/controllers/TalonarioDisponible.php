<?php

/**
 ******************************************************************************
 * Sistema           : Farmacia
 *
 * Descripción       : Controlador de Talonario Disponible
 *
 * Plataforma        : PHP
 *
 * Creación          : 25/08/2020
 *
 * @name             TalonarioDisponible.php
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

namespace App\Farmacia\Talonarios;

use Pan\Utils\ValidatePan as validatePan;
use App\Farmacia\Talonarios\Entity as Entities;
use DateTime;
use DateTimeZone;

class TalonarioDisponible extends \pan\Kore\Controller
{

    private $_DAOTalonario;
    private $_DAOTalonariosCreados;
    private $_DAOTalonarioEstado;
    private $_DAOTalonarioTipoMotivo;
    private $_DAOAsignacionTalonario;
    // private $_DAOBodega;
    // private $_DAOBodegaTipo;
    // private $_DAORegion;
    // private $_DAOUsuario;


    public function __construct()
    {
        parent::__construct();
        $this->session->isValidate();

        $this->_DAOTalonario = new Entities\DAOTalonario;
        $this->_DAOTalonariosCreados = new Entities\DAOTalonariosCreados;
        $this->_DAOTalonarioEstado = new Entities\DAOTalonarioEstado;
        $this->_DAOAsignacionTalonario = new Entities\DAOAsignacionTalonario;
        $this->_DAOTalonarioTipoMotivo = new Entities\DAOTalonarioTipoMotivo;
    }

    public function index()
    {
        $params = $this->request->getParametros();
        // var_dump($params);
        $this->session->isValidate();

        $TalonariosCreados = $this->_DAOTalonariosCreados->getByPK($params["tc_id"]);
        $arrTalonarioTipoMotivo = $this->_DAOTalonarioTipoMotivo->all();
        // var_dump($TalonariosCreados);

        // $this->view->addJS('validador.js', 'pub/js/');
        $this->view->addCSS('http://localhost/farmacia_v2/pub/js/plugins/DataTables/extensions/Select/css/select.bootstrap4.min.css');
        $this->view->addJS('dataTables.select.js', 'pub/js/plugins/DataTables/extensions/Select/js');
        $this->view->addJS('talonarioDisponible.js');

        $this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_talonarioDisponible']['filtros']);
        $this->view->set('arrTalonarioTipoMotivo', $arrTalonarioTipoMotivo);
        $this->view->set('TalonariosCreados', $TalonariosCreados);

        $this->view->set('talonarioDisponible_filtros', $this->view->fetchIt('talonarioDisponible/talonarioDisponible_filtros'));
        $this->view->set('talonarioDisponible_grilla', $this->view->fetchIt('talonarioDisponible/talonarioDisponible_grilla'));
        $this->view->set('contenido', $this->view->fetchIt('talonarioDisponible/talonarioDisponible_index'));
        $this->view->render();
    }

    /**
     * Descripción	: Grilla AsignarTalonarioDisponible
     * @author		: <ricardo.munoz@cosof.cl> - 20/08/2020
     */
    public function grillaTalonarioDisponible()
    {

        $params = $this->request->getParametros();

        //Guardo Filtros en SESSION
        // $_SESSION[\Constantes::SESSION_BASE]['mantenedor_talonarioDisponible']['filtros']   = $params;

        $TalonariosCreados = $this->_DAOTalonariosCreados->getByPK($params["tc_id"]);

        $arrTalonario = $this->_DAOTalonario
            ->where(
                array("fk_tc_id" => $params["tc_id"])
            )->runQuery()->getRows();

        $arrGrilla  = array('data' => array());

        if (!empty($arrTalonario)) {
            foreach ($arrTalonario as $item) {

                $AsignacionTalonario = $this->_DAOAsignacionTalonario
                    ->where(
                        array(
                            "fk_talonario" => $item->talonario_id,
                            "estado_talonario" => 2 // Activo
                        )
                    )->runQuery()->getRows()[0];

                if (0 === (int)$AsignacionTalonario->asignacion_id) {
                    continue;
                
                }
                // $Bodega = $this->_DAOBodega->getByPK($item->bodega_central);
                // var_dump($AsignacionTalonario);
                $TalonarioEstado = $this->_DAOTalonarioEstado->getByPK($TalonariosCreados->bo_estado);
                // var_dump($TalonarioEstado);
                $arr = array();

                $arr['asignacion_id'] = (int)$AsignacionTalonario->asignacion_id;
                $arr['talonario_id'] = $item->talonario_id;
                $arr['talonario_serie'] = $item->talonario_serie;
                $arr['talonario_folio_inicial'] = $item->talonario_folio_inicial;
                $arr['talonario_folio_final'] = $item->talonario_folio_final;
                $arr['local_venta'] = (0 === (int)$AsignacionTalonario->local_ven ? "Sin asignar" : "Buscar Local de venta");
                // $arr['fecha_creacion_talonario'] = \Fechas::fechaHoyVista();
                $arr["fecha_creacion_talonario"] = (new \DateTime($item->Ingreso_sistema,  new \DateTimeZone('America/Santiago')))->format("d/m/Y");
                $arr['talonario_estado'] = $TalonarioEstado->gl_talonario_estado;
                // $arr['opciones']    = '';
                $arr['opciones']    = '
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="' . $item->talonario_id . '" id="defaultCheck' . $item->talonario_id . '" name="talonarioSeleccionado[]">
                        <label class="form-check-label" for="defaultCheck' . $item->talonario_id . '">
                            Seleccione
                        </label>
                    </div>
                ';

                $arrGrilla['data'][] = $arr;
            }
        }

        echo json_encode($arrGrilla);
    }

    /**
     * @author		: <ricardo.munoz@cosof.cl> - 26/08/2020
     * Descripción	: Transferir Talonario Seleccionados
     * talonario_estado = 7
     * bodega_central = 0
     * bo_transferido = 1 
     */
    public function transferirTalonario()
    {
        $this->session->isValidate();

        $params = $this->request->getParametros();
        $correcto = false;
        $error = false;
        $msgError = "";
        // var_dump($params);

        // validar formulario formCrearTalonario
        $msgError = $this->fn_validar_talonarios_seleccionados($params);
        if ($msgError == "") {

            $arrTalonarios = $params["arrTalonarios"];
            $id_motivo = $params["id_motivo"];
            $gl_observacion = $params["gl_observacion"];
            unset($params);

            $idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 999;
            $params["id_usuario_actualizacion"] = $idUsuario;
            $params["fc_actualizacion"] = (new \DateTime("now", new \DateTimeZone('UTC')))->format("Y-m-d H:i:s");
            $params["fk_motivo"] = $id_motivo;
            $params["gl_observacion"] = $gl_observacion;
            $params["bodega_central"] = 0;
            $params["bodega_int"] = 0;
            $params["local_ven"] = 0;
            $params["fecha_asig_bc"] = null;
            $params["fecha_asig_bi"] = null;
            $params["fecha_asig_lv"] = null;
            $params["estado_talonario"] = 7; // Transferido
            $params["estado_talonario_bi"] = 0;
            $params["estado_talonario_lv"] = 0;
            $params["bo_transferido"] = 1;

            foreach ($arrTalonarios as $asignacion_id) {
                $this->_DAOAsignacionTalonario->update($params, $asignacion_id);
                // break;
            }
            $correcto = true;
            $msgError = " <i class=\"fa fa-exchange-alt\"></i> Se han transferido los talonarios seleccionados";
        }

        $json = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);

        echo json_encode($json);
    }

    /**
     * @author		: <ricardo.munoz@cosof.cl> - 26/08/2020
     * Descripción	: Eliminar Talonario Seleccionados
     * Se cambia el talonario_estado = 8
     */
    public function eliminarTalonario()
    {
        $this->session->isValidate();

        $params = $this->request->getParametros();
        $correcto = false;
        $error = false;
        $msgError = "";
        // var_dump($params);

        // validar formulario formCrearTalonario
        $msgError = $this->fn_validar_talonarios_seleccionados($params);
        if ($msgError == "") {

            $arrTalonarios = $params["arrTalonarios"];
            $id_motivo = $params["id_motivo"];
            $gl_observacion = $params["gl_observacion"];
            unset($params);

            $idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 999;
            $params["id_usuario_actualizacion"] = $idUsuario;
            $params["fc_actualizacion"] = (new \DateTime("now", new \DateTimeZone('UTC')))->format("Y-m-d H:i:s");
            $params["fk_motivo"] = $id_motivo;
            $params["gl_observacion"] = $gl_observacion;
            $params["estado_talonario"] = 8; // Eliminar

            foreach ($arrTalonarios as $asignacion_id) {
                $this->_DAOAsignacionTalonario->update($params, $asignacion_id);
                // break;
            }
            $correcto = true;
            $msgError = " <i class=\"fa fa-times\"></i> Se han eliminado los talonarios seleccionados";
        }

        $json = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);

        echo json_encode($json);
    }

    /**
     * @author		: <ricardo.munoz@cosof.cl> - 26/08/2020
     * Descripción	: Merma Talonario Seleccionados
     * Se cambia el talonario_estado = 9
     */
    public function mermaTalonario()
    {
        $this->session->isValidate();

        $params = $this->request->getParametros();
        $correcto = false;
        $error = false;
        $msgError = "";
        // var_dump($params);

        // validar formulario formCrearTalonario
        $msgError = $this->fn_validar_talonarios_seleccionados($params);
        if ($msgError == "") {

            $arrTalonarios = $params["arrTalonarios"];
            $id_motivo = $params["id_motivo"];
            $gl_observacion = $params["gl_observacion"];
            unset($params);

            $idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 999;
            $params["id_usuario_actualizacion"] = $idUsuario;
            $params["fc_actualizacion"] = (new \DateTime("now", new \DateTimeZone('UTC')))->format("Y-m-d H:i:s");
            $params["fk_motivo"] = $id_motivo;
            $params["gl_observacion"] = $gl_observacion;
            $params["estado_talonario"] = 9;  // Merma

            foreach ($arrTalonarios as $asignacion_id) {
                $this->_DAOAsignacionTalonario->update($params, $asignacion_id);
                // break;
            }
            $correcto = true;
            $msgError = " <i class=\"fa fa-trash\"></i> Se han mermado los talonarios seleccionados";
        }

        $json = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);

        echo json_encode($json);
    }


    /**
     * Descripción	: asignar Talonarios Seleccionados
     * @author		: <ricardo.munoz@cosof.cl> - 25/08/2020
     */
    public function fn_validar_talonarios_seleccionados($params)
    {
        $msgError = "";
        if (!is_array($params["arrTalonarios"])) {
            $msgError .= "- Por favor, debe seleccionar un registro.</br>";
        }
        return $msgError;
    }
}
