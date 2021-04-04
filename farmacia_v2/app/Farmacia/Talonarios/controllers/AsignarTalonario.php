<?php

namespace App\Farmacia\Talonarios;

/**
 ******************************************************************************
 * Sistema           : Farmacia
 *
 * Descripción       : Controlador de Asignar Talonario
 *
 * Plataforma        : PHP
 *
 * Creación          : 19/08/2020
 *
 * @name             Talonario.php
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
use DateTime;
use DateTimeZone;

class AsignarTalonario extends \pan\Kore\Controller
{

    private $_DAOTalonario;
    private $_DAOTalonariosCreados;
    private $_DAOTalonarioTipoDocumento;
    private $_DAOTalonarioTipoProveedor;
    private $_DAOAsignacionTalonario;
    private $_DAOBodega;
    private $_DAOBodegaTipo;
    private $_DAORegion;
    private $_DAOUsuario;


    public function __construct()
    {
        parent::__construct();
        $this->session->isValidate();

        $this->_DAOBodega = new \App\Farmacia\Bodegas\Entity\DAOBodega;
        $this->_DAOBodegaTipo = new \App\Farmacia\Bodegas\Entity\DAOBodegaTipo;
        $this->_DAOTalonario = new \App\Farmacia\Talonarios\Entity\DAOTalonario;
        // $this->_DAOTalonariosCreados = new \App\Farmacia\Talonarios\Entity\DAOTalonariosCreados;
        $this->_DAOAsignacionTalonario = new \App\Farmacia\Talonarios\Entity\DAOAsignacionTalonario;
        $this->_DAORegion = new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
        $this->_DAOUsuario = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;
    }

    public function index()
    {

        $this->session->isValidate();

        $params = $this->request->getParametros();
 
        if (!isset($params["bodega_id"])) {
            /**
             * si Rol = vendedor (5)
             * y tiene permiso bo_asignarse_talonarios = 1
             */

            if ($this->esVendedor($_SESSION[\Constantes::SESSION_BASE]['arrRoles'])) {
                echo $vendedorPuedeAsignarseTalonarios = $this->vendedorPuedeAsignarseTalonarios($_SESSION[\Constantes::SESSION_BASE]['arrRoles']);
            }
            if (0 === $vendedorPuedeAsignarseTalonarios) {
                $this->view->set('contenido', $this->view->fetchIt('asignarTalonario/asignarTalonario_error_vendedor'));
                $this->view->render();
            } else {
                $params["bodega_id"] = $vendedorPuedeAsignarseTalonarios;
            }
        }

        $Bodega = $this->_DAOBodega->getByPK($params["bodega_id"]);

        $BodegaTipo = $this->_DAOBodegaTipo->getByPK($Bodega->fk_bodega_tipo);

        $Region = $this->_DAORegion->getByPK($Bodega->fk_region);

        $Usuario = $this->_DAOUsuario->getByPK(1); // todo eliminar linea al liberar
        // $Usuario = $this->_DAOUsuario->getNombreCompletoById($Bodega->bodega_id_usuario); // todo descomentar linea al liberar


        // $arrTalonarioTipoDocumento  = $this->_DAOTalonarioTipoDocumento->all();
        // $arrTalonarioTipoProveedor  = $this->_DAOTalonarioTipoProveedor->all();

        // $this->view->addJS('validador.js', 'pub/js/');
        $this->view->addCSS('http://localhost/farmacia_v2/pub/js/plugins/DataTables/extensions/Select/css/select.bootstrap4.min.css');
        $this->view->addJS('dataTables.select.js', 'pub/js/plugins/DataTables/extensions/Select/js');
        $this->view->addJS('asignarTalonario.js');

        $this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_asignarTalonario']['filtros']);
        $this->view->set('Bodega', $Bodega);
        $this->view->set('BodegaTipo', $BodegaTipo);
        $this->view->set('Region', $Region);
        $this->view->set('Usuario', $Usuario);

        // $this->view->set('asignarTalonario_filtros', $this->view->fetchIt('asignarTalonario/asignarTalonario_filtros'));
        $this->view->set('asignarTalonario_grilla', $this->view->fetchIt('asignarTalonario/asignarTalonario_grilla'));
        $this->view->set('asignarTalonario_informacionBodega', $this->view->fetchIt('asignarTalonario/asignarTalonario_informacionBodega'));
        $this->view->set('contenido', $this->view->fetchIt('asignarTalonario/asignarTalonario_index'));
        $this->view->render();
    }

    /**
     * Descripción	: Grilla AsignarTalonarioDisponible
     * @author		: <ricardo.munoz@cosof.cl> - 20/08/2020
     */
    public function grillaAsignarTalonarioDisponible()
    {

        $params = $this->request->getParametros();

        //Guardo Filtros en SESSION
        // $_SESSION[\Constantes::SESSION_BASE]['mantenedor_asignarTalonario']['filtros']   = $params;

        $arrTalonariosDisponibles = $this->_DAOAsignacionTalonario
            ->where(
                "bodega_int = 0"
                    . " and local_ven = 0"
                    . " and estado_talonario = 2" // Activo
                    // . " and estado_talonario_bi = 0"
                    // . " and estado_talonario_lv = 0"
                    . " and Venta = 0"
            )->runQuery()->getRows();

        // var_dump($arrTalonariosDisponibles);

        $arrGrilla  = array('data' => array());

        if (!empty($arrTalonariosDisponibles)) {
            foreach ($arrTalonariosDisponibles as $item) {
                $arr    = array();

                $Bodega = $this->_DAOBodega->getByPK($item->bodega_central);
                $Talonario = $this->_DAOTalonario->getByPK($item->fk_talonario);

                $arr['asignacion_id'] = $Talonario->talonario_id;
                $arr['talonario_serie'] = $Talonario->talonario_serie;
                $arr['talonario_folio_inicial'] = $Talonario->talonario_folio_inicial;
                $arr['talonario_folio_final'] = $Talonario->talonario_folio_final;
                $arr['cantidad_cheque_por_talonario'] = 50;
                $arr['bodega_nombre'] = $Bodega->bodega_nombre;
                // $arr['opciones']    = '';
                $arr['opciones']    = '
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="' . $item->asignacion_id . '" id="defaultCheck' . $item->asignacion_id . '" name="talonarioSeleccionado[]">
                        <label class="form-check-label" for="defaultCheck' . $item->asignacion_id . '">
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
     * Descripción	: asignar Talonarios Seleccionados
     * @author		: <ricardo.munoz@cosof.cl> - 25/08/2020
     */
    public function asignarTalonariosSeleccionados()
    {
        $this->session->isValidate();

        $params = $this->request->getParametros();
        $correcto = false;
        $error = false;
        $msgError = "";
        $idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 0;

        // validar formulario formCrearTalonario
        $msgError = $this->fn_validar_talonarios_seleccionados($params);
        if ($msgError == "") {
            $bodega_id = trim($params['bodega_id']);

            $Bodega = $this->_DAOBodega->getByPK($bodega_id);


            // var_dump($Bodega);
            switch ($Bodega->fk_bodega_tipo) {
                case 2:
                    /**
                     * Guarda bodega_int
                     */
                    $this->fn_update_asignacion_talonarios_bodega_int($Bodega->bodega_id, $params["talonarioSeleccionado"]);
                    break;
                case 3:
                    /**
                     * Guarda local_ven
                     */
                    $this->fn_update_asignacion_talonarios_local_ven($Bodega->bodega_id, $params["talonarioSeleccionado"]);

                    $BodegaINT = $this->_DAOBodega->where(
                        "bodega_estado = 1"
                            . "fk_bodega_tipo = 2"
                            . "fk_territorio = " . $Bodega->fk_territorio . ""
                    );
                    $this->fn_update_asignacion_talonarios_bodega_int($BodegaINT->bodega_id, $params["talonarioSeleccionado"]);
                    break;
                default;
            }

            $correcto = true;
            $msgError = "Se han asignados los talonarios seleccionados a la bodega: " . $Bodega->bodega_nombre . "";
        }

        $json   = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);

        echo json_encode($json);
    }


    /**
     * Descripción	: asignar Talonarios Seleccionados
     * @author		: <ricardo.munoz@cosof.cl> - 25/08/2020
     */
    public function fn_validar_talonarios_seleccionados($params)
    {
        $msgError = "";
        if (!is_array($params["talonarioSeleccionado"])) {
            $msgError .= "- Por favor, debe seleccionar un registro.</br>";
        }
        return $msgError;
    }

    /**
     * Descripción	: update asignacion Talonarios Bodega Int
     * @author		: <ricardo.munoz@cosof.cl> - 25/08/2020
     */
    public function fn_update_asignacion_talonarios_bodega_int($bodega_id, $arrTalonariosSeleccionados)
    {
        $params = array(
            "bodega_int" => $bodega_id, "estado_talonario_bi" => 2 // 2 = activo
        );
        $this->fn_update_asignacion_talonarios($params, $arrTalonariosSeleccionados);
    }

    /**
     * Descripción	: update asignacion Talonarios Local ven
     * @author		: <ricardo.munoz@cosof.cl> - 25/08/2020
     */
    public function fn_update_asignacion_talonarios_local_ven($bodega_id, $arrTalonariosSeleccionados)
    {
        $params = array(
            "local_ven" => $bodega_id, "estado_talonario_lv" => 2 // 2 = activo
        );
        $this->fn_update_asignacion_talonarios($params, $arrTalonariosSeleccionados);
    }

    /**
     * Descripción	: update asignacion Talonarios
     * @author		: <ricardo.munoz@cosof.cl> - 25/08/2020
     */
    public function fn_update_asignacion_talonarios($params, $arrTalonariosSeleccionados)
    {
        $idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 999;
        $params["id_usuario_actualizacion"] = $idUsuario;
        $params["fc_actualizacion"] = (new \DateTime("now",  new \DateTimeZone('UTC')))->format("Y-m-d H:i:s");
        // $params["fc_actualizacion"] = \Fechas::fechaHoy(); // no incluye la hora minutos ni segundos

        /**
         * los talonarios deben cambiar de 
         * talonario_estado = 1 -> Inactivo
         * talonario_estado = 2 -> Activo
         * si es CEN estado_talonario
         * si es INT estado_talonario_bi
         * si es LV estado_talonario_lv
         */
        $params["estado_talonario"] = 1; //Inactivo

        foreach ($arrTalonariosSeleccionados as $asignacion_id) {
            $this->_DAOAsignacionTalonario->update($params,  $asignacion_id);
        }
    }

    /**
     * @author cosof-ricardo-munoz 
     */
    private function esVendedor($arrRoles)
    {

        if (!empty($arrRoles)) {
            foreach ($arrRoles as $key => $rol) {
                /** Rol 5 => Vendedor */
                if (in_array($rol->mur_fk_rol, array(5))) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @author cosof-ricardo-munoz 
     */
    private function vendedorPuedeAsignarseTalonarios($arrRoles)
    {
        if (!empty($arrRoles)) {
            foreach ($arrRoles as $key => $rol) {
                $arrjson_permisos = json_decode($rol->json_permisos);
                if (1 === (int)$arrjson_permisos->bo_asignarse_talonarios) {
                    return $rol->fk_bodega;
                }
            }
        }
        return 0;
    }
}
// 