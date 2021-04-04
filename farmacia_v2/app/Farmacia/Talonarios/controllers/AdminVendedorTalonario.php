<?php

namespace App\Farmacia\Talonarios;

/**
 ******************************************************************************
 * Sistema           : Farmacia
 *
 * Descripción       : Controlador de AdminVendedorTalonario
 *
 * Plataforma        : PHP
 *
 * Creación          : 07/09/2020
 *
 * @name             AdminVendedorTalonario.php
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

class AdminVendedorTalonario extends \pan\Kore\Controller
{
    private $_DAOAccesoUsuarioRol;
    private $_DAOBodega;
    private $_DAODireccionComuna;
    private $_DAOTerritorio;
    private $_DAODireccionLocalidad;
    private $_DAODireccionRegion;
    private $_DAOAccesoUsuario;

    const ROL_VENDEDOR = 5;

    public function __construct()
    {
        parent::__construct();
        $this->session->isValidate();

        $this->_DAOAccesoUsuarioRol = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioRol;
        $this->_DAOBodega = new \App\Farmacia\Bodegas\Entity\DAOBodega;
        $this->_DAODireccionComuna = new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
        $this->_DAOTerritorio = new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
        $this->_DAODireccionLocalidad = new \App\_FuncionesGenerales\General\Entity\DAODireccionLocalidad;
        $this->_DAODireccionRegion = new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
        $this->_DAOAccesoUsuario = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;
    }

    public function index()
    {
        $this->view->set('contenido', $this->view->fetchIt('index'));
        $this->view->render();
    }

    /**
     * Descripción	: lista Vendedores Talonario
     * @author		: <ricardo.munoz@cosof.cl> - 07/09/2020
     */
    public function listaVendedorTalonario()
    {
        $this->view->addJS('adminVendedorTalonario.js');

        $this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_adminVendedorTalonario']['filtros']);

        // buscar DAOs
        // $this->view->set('arrComuna', $arrComuna);
        // $this->view->set('arrRegion', $arrRegion);

        // $this->view->set('filtros', $this->view->fetchIt('adminVendedorTalonario/adminVendedorTalonario_filtros'));
        $this->view->set('grilla', $this->view->fetchIt('adminVendedorTalonario/adminVendedorTalonario_grilla'));
        $this->view->set('contenido', $this->view->fetchIt('adminVendedorTalonario/adminVendedorTalonario_index'));
        $this->view->render();
    }

    /**
     * Descripción	: Grilla Vendedores Talonario
     * @author		: <ricardo.munoz@cosof.cl> - 07/09/2020
     */
    public function grillaVendedoresTalonario()
    {

        $arrVendedores = $this->getVendedores();

        $arrGrilla  = array('data' => array());

        if (!empty($arrVendedores)) {
            foreach ($arrVendedores as $key => $Vendedor) {

                $arr = array();

                // $Bodega = $this->_DAOBodega->getByPK($Vendedor->bodega_central);
                $Usuario = $this->_DAOAccesoUsuario->getByPK($Vendedor->mur_fk_usuario);
                // var_dump($Usuario);

                $Comuna = $this->_DAODireccionComuna->getByPK($Vendedor->mur_fk_comuna);
                // var_dump($Comuna);

                $Region = $this->_DAODireccionRegion->getByPK($Vendedor->mur_fk_region);
                // var_dump($Region);

                $arr['token'] = $Vendedor->gl_token;
                $arr['rut_vendedor'] = $Usuario->mu_rut;
                $arr['vendedor'] = $Usuario->mu_nombre . " " . $Usuario->mu_apellido_paterno . " " . $Usuario->mu_apellido_materno;
                // $arr['localidad'] = $Vendedor->mur_fk_localidad;
                $arr['comuna'] = $Comuna->comuna_nombre;
                // $arr['territorio'] = $Vendedor->mur_fk_territorio;
                $arr['region'] = $Region->region_nombre;
                // $arr['farmacia'] = $Vendedor->fk_farmacia;
                // $arr['local'] = $Vendedor->fk_local;
                // $arr['bodega'] = $Vendedor->fk_bodega;
                // $arr['estado'] = $Vendedor->mur_estado_activado;
                $arr['bo_crear_medico'] = 0;
                $arr['bo_inhabilitar_medico'] = 0;
                $arr['bo_editar_medico'] = 0;
                $arr['bo_asignarse_talonarios'] = 0;
                // $arr['opciones']    = '';

                // permisos
                // $arrPermisosVendedor = array(
                //     'bo_crear_medico' => "",
                //     'bo_inhabilitar_medico' => "",
                //     'bo_editar_medico' => "",
                //     'bo_asignarse_talonarios' => ""
                // );

                $json_permisos = json_decode($Vendedor->json_permisos);

                foreach ($json_permisos as $key => $permiso) {
                    // $arr[$key] = $permiso;
                    $arr[$key] = (1 === (int) $permiso ? "<i class=\"text-success fa fa-check\"></i>" : "<i class=\"text-danger fa fa-times\"></i>");
                }

                // var_dump($arr);
                // $arr['opciones']    = '
                //     <div class="form-check">
                //         <input class="form-check-input bo_crear_medico" type="checkbox" 
                //         ' . $arrPermisosVendedor["bo_crear_medico"] . '
                //         value="' . $Vendedor->gl_token . '"  id="bo_crear_medico-' . $Vendedor->gl_token . '">
                //         <label class="form-check-label" for="bo_crear_medico-' . $Vendedor->gl_token . '">
                //             Crear Médico
                //         </label>
                //     </div>
                //     <div class="form-check">
                //         <input class="form-check-input bo_inhabilitar_medico" type="checkbox" 
                //         ' . $arrPermisosVendedor["bo_inhabilitar_medico"] . '
                //         value="' . $Vendedor->gl_token . '" id="bo_inhabilitar_medico-' . $Vendedor->gl_token . '">
                //         <label class="form-check-label" for="bo_inhabilitar_medico-' . $Vendedor->gl_token . '">
                //             Inhabilitar Médico
                //         </label>
                //     </div>
                //     <div class="form-check">
                //         <input class="form-check-input bo_editar_medico" type="checkbox" 
                //         ' . $arrPermisosVendedor["bo_editar_medico"] . '
                //         value="' . $Vendedor->gl_token . '" id="bo_editar_medico-' . $Vendedor->gl_token . '">
                //         <label class="form-check-label" for="bo_editar_medico-' . $Vendedor->gl_token . '">
                //             Inhabilitar Médico
                //         </label>
                //     </div>
                //     <div class="form-check">
                //         <input class="form-check-input bo_asignarse_talonarios" type="checkbox" 
                //         ' . $arrPermisosVendedor["bo_asignarse_talonarios"] . '
                //         value="' . $Vendedor->gl_token . '" id="bo_asignarse_talonarios-' . $Vendedor->gl_token . '">
                //         <label class="form-check-label" for="bo_asignarse_talonarios-' . $Vendedor->gl_token . '">
                //             Asignarse Talonarios
                //         </label>
                //     </div>
                // ';

                $arr['opciones']    = '
                <button type="button" class="btn btn-sm btnModificarPermisos" data-toggle="tooltip" title="Modificar Permisos">
                    <i class="fa fa-edit"></i>
                </button> ';

                $arrGrilla['data'][] = $arr;
            }
        }

        echo json_encode($arrGrilla);
    }

    /**
     * Descripción	: obtiene Vendedores Talonario
     * @author		: <ricardo.munoz@cosof.cl> - 07/09/2020
     */
    public function getVendedores()
    {
        $arrFiltros["mur_fk_rol"] = self::ROL_VENDEDOR;
        return $this->_DAOAccesoUsuarioRol->where($arrFiltros, "")->runQuery()->getRows();
    }

    /**
     * Descripción	: Vista Formulario Editar Permisos Vendedores
     * @author		: <ricardo.munoz@cosof.cl> - 09/09/2020
     */
    public function formEditarPermisosVendedor($gl_token)
    {
        $this->session->isValidate();

        // $Bodega = $this->_DAOBodega->getByPK($bodega_id);

        $arrFiltros["mur_fk_rol"] = self::ROL_VENDEDOR;
        $arrFiltros["gl_token"] = $gl_token;
        $Vendedor =  $this->_DAOAccesoUsuarioRol->where($arrFiltros, "")->runQuery()->getRows()[0];

        // var_dump($Vendedor);

        $Usuario = $this->_DAOAccesoUsuario->getByPK($Vendedor->mur_fk_usuario);

        $Comuna = $this->_DAODireccionComuna->getByPK($Vendedor->mur_fk_comuna);

        $Region = $this->_DAODireccionRegion->getByPK($Vendedor->mur_fk_region);

        $Vendedor->vendedor = $Usuario->mu_nombre . " " . $Usuario->mu_apellido_paterno . " " . $Usuario->mu_apellido_materno;


        $json_permisos = json_decode($Vendedor->json_permisos);

        foreach ($json_permisos as $key => $permiso) {
            $Vendedor->$key =  $permiso;
        }


        // $BodegaTipo = $this->_DAOBodegaTipo->getByPK($Bodega->fk_bodega_tipo);

        // $Region = $this->_DAODireccionRegion->getByPK($Bodega->fk_region);

        // $Territorio = $this->_DAOTerritorio->getByPK($Bodega->fk_territorio);

        // $Comuna = $this->_DAODireccionComuna->getByPK($Bodega->fk_comuna);

        // $arrRegion = $this->_DAORegion->all();

        // $this->view->addJS('validador.js', 'pub/js/');
        // $this->view->addJS('adminBodega.js');

        $this->view->set('Vendedor', $Vendedor);

        $this->view->render('adminVendedorTalonario/editarPermisosVendedor');
    }

    function saveEditarPermisosVendedor()
    {
        $this->session->isValidate();

        $correcto = false;
        $error = false;
        $mensaje = "";
        $params = $this->request->getParametros();

        // var_dump($params);

        $arrFiltros["gl_token"] = $params["token"];
        $Vendedor =  $this->_DAOAccesoUsuarioRol->where($arrFiltros, "")->runQuery()->getRows()[0];
        // var_dump($Vendedor);

        $Usuario = $this->_DAOAccesoUsuario->getByPK($Vendedor->mur_fk_usuario);
        $Vendedor->vendedor = $Usuario->mu_nombre . " " . $Usuario->mu_apellido_paterno . " " . $Usuario->mu_apellido_materno;
        // var_dump($Vendedor);

        $idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 1;

        $arrActualizacion = array(
            "id_usuario_actualizacion" => $idUsuario,
            "fc_actualizacion" => \Fechas::fechaHoy()
        );

        $arrPermisos['bo_crear_medico'] = 0;
        $arrPermisos['bo_inhabilitar_medico'] = 0;
        $arrPermisos['bo_editar_medico'] = 0;
        $arrPermisos['bo_asignarse_talonarios'] = 0;

        foreach ($params["form"] as $key => $value) {
            if (!empty($value["value"])) {
                $arrPermisos[$value["name"]] = (int)$value["value"];
            }
        }

        $arrActualizacion["json_permisos"] = json_encode($arrPermisos);

        if ($mensaje == "") {

            $responseUpdate = $this->_DAOAccesoUsuarioRol->update($arrActualizacion, $Vendedor->mur_id);

            if (1 === (int)$responseUpdate) {
                $correcto = true;
                $mensaje = "Se han modificado los Permisos para " . $Vendedor->vendedor . " correctamente.";
            } else {
                $mensaje = "Hubo un problema, por favor contáctese con el administrador.";
            }
        }

        $json   = array("correcto" => $correcto, "error" => $error, "mensaje" => $mensaje);

        echo json_encode($json);
    }
}
