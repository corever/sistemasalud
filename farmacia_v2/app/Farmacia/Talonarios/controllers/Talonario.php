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
 * @name             Talonario.php
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
 * Ricardo.Munoz			28/08/2020		merge de carpeta
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

use Pan\Utils\ValidatePan as validatePan;
use App\Farmacia\Talonarios\Entity as Entities;
use DateTimeZone;

class Talonario extends \pan\Kore\Controller
{

    /*Inicializando Variables*/
    protected $_DAOUsuario;
    private $_DAOTalonario;
    private $_DAOTalonariosCreados;
    private $_DAOTalonarioTipoDocumento;
    private $_DAOTalonarioTipoProveedor;
    private $_DAOAsignacionTalonario;
    private $_DAOMedicoAdjunto;
    private $_DAOMedico;
    private $_DAOVenta;
    private $_DAOTalonariosVendidos;

    const CANTIDAD_CHEQUES_POR_TALONARIO = 50;

    public function __construct()
    {

        parent::__construct();

        $this->_DAOUsuario                  = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario();
        $this->_DAOTalonario                 = new Entities\DAOTalonario;
        $this->_DAOTalonariosCreados         = new Entities\DAOTalonariosCreados;
        $this->_DAOTalonarioTipoDocumento     = new Entities\DAOTalonarioTipoDocumento;
        $this->_DAOTalonarioTipoProveedor     = new Entities\DAOTalonarioTipoProveedor;
        $this->_DAOAsignacionTalonario         = new Entities\DAOAsignacionTalonario;
        $this->_DAOMedicoAdjunto             = new \App\_FuncionesGenerales\General\Entity\DAOMedicoAdjunto;
        $this->_DAOMedico                     = new \App\Farmacia\Mantenedor\Entity\DAOMedico;
        $this->_DAOVenta                     = new \App\_FuncionesGenerales\General\Entity\DAOVenta;
        $this->_DAOTalonariosVendidos       = new Entities\DAOTalonariosVendidos;
    }

    public function index()
    {

        $this->view->addJS('talonario.js');
        $this->view->set('contenido', $this->view->fetchIt('index'));
        $this->view->render();
    }

    public function ventaTalonario()
    {
        $arrRoles        = $_SESSION[\Constantes::SESSION_BASE]['arrRoles'];
        $arrProfesional = $this->_DAOUsuario->getListaMedicos();

        if (!empty($arrRoles)) {
            foreach ($arrRoles as $rol) {
                //si es rol vendedor talonario busca id_bodega para buscar talonarios disponibles
                if ($rol->mur_fk_rol == 5) {
                    $id_bodega = $rol->fk_bodega;
                }
            }
        }

        $arrTalonario    = $this->_DAOAsignacionTalonario->getListaDisponibles($id_bodega);

        $this->view->addJS('adjunto.js', 'app/_FuncionesGenerales/Adjuntos/assets/js');
        $this->view->addJS('$(".labelauty").labelauty();');
        $this->view->addJS('$("#id_profesional_medico").select2({minimumInputLength:3});');
        $this->view->addJS('$("#id_talonarios_disponibles").select2();');
        $this->view->addJS('ventaTalonario.js');

        //Unset ventaTalonario para vista previa
        unset($_SESSION[\Constantes::SESSION_BASE]['ventaTalonario']);
        //Set parametros adjuntos
        unset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjPyme']);
        $this->view->set('boComentarioAdj', 0);
        $this->view->set('cantAdjuntos', 1);
        $this->view->set('idTipoAdjunto', 1);
        $this->view->set('extensionAdjunto', '');
        $this->view->set('idForm', 'adjPyme');
        //Fin parametros adjuntos

        $this->view->set('arrProfesional', $arrProfesional);
        $this->view->set('arrTalonario', $arrTalonario);
        $this->view->set('contenido', $this->view->fetchIt('ventaTalonario'));
        $this->view->render();
    }

    /* Hace un guardado parcial de la venta para mostrar la vista previa en realizaVentaTalonario() */
    public function guardarVenta()
    {

        $this->session->isValidate();
        $params     = $this->request->getParametros();
        $salida     = array("correcto" => false, "msgError" => "", "url" => "");

        // validar formulario formCrearTalonario
        $salida['msgError'] = $this->validarVentaTalonario($params);

        if ($salida['msgError'] == "") {

            //Guardar Venta Talonario en sesion temporal
            $_SESSION[\Constantes::SESSION_BASE]['ventaTalonario']                    = $params;
            $_SESSION[\Constantes::SESSION_BASE]['ventaTalonario']['arrMedico']     = $this->_DAOMedico->getByUsuario($params['id_profesional_medico']);
            $_SESSION[\Constantes::SESSION_BASE]['ventaTalonario']['arrTalonario']  = $this->_DAOAsignacionTalonario->getByIdIN(implode(",", $params['id_talonarios_disponibles']));

            $salida["correcto"] = true;
            $salida["url"]         = "Farmacia/Talonarios/Talonario/realizaVentaTalonario";
        }

        echo json_encode($salida);
    }

    public function validarVentaTalonario($params)
    {
        $msgError = '';

        if (isset($params['id_profesional_medico']) && $params['id_profesional_medico'] == "0") {
            $msgError .= "Profesional Médico es Obligatorio <br>";
        }
        if (isset($params['id_talonarios_disponibles']) && $params['id_talonarios_disponibles'] == "0") {
            $msgError .= "Talonarios es Obligatorio <br>";
        }
        if (!isset($params['chk_es_pyme'])) {
            $msgError .= "Seleccione ¿Es PYME? <br>";
        }

        return $msgError;
    }

    public function realizaVentaTalonario()
    {

        $params                = $_SESSION[\Constantes::SESSION_BASE]['ventaTalonario'];
        $arrMedico             = $params['arrMedico'];
        $arrTalonario         = $params['arrTalonario'];
        $arrUltimasCompras     = $this->_DAOVenta->getLastByMedico($params['id_profesional_medico'], 5);

        $this->view->addJS('ventaTalonario.js');
        $this->view->addJS('adjunto.js', 'app/_FuncionesGenerales/Adjuntos/assets/js');
        $this->view->addJS('Adjunto.cargarGrilla("adjPyme");$("#adjuntos").show();');

        $this->view->set('arrMedico', $arrMedico);
        $this->view->set('arrTalonario', $arrTalonario);
        $this->view->set('arrUltimasCompras', $arrUltimasCompras);
        $this->view->set('contenido', $this->view->fetchIt('realizaVentaTalonario'));
        $this->view->render();
    }

    public function realizaVentaTalonarioBD()
    {

        $this->session->isValidate();
        $params                 = $_SESSION[\Constantes::SESSION_BASE]['ventaTalonario'];
        $salida                 = array("correcto" => false, "msgError" => "");
        $id_usuario_crea        = $_SESSION[\Constantes::SESSION_BASE]['id'];
        $id_region_sesion       = $_SESSION[\Constantes::SESSION_BASE]['id_region'];
        $gl_bodega_vendedor     = 0;
        $gl_territorio_vendedor = 0;
        $gl_region_vendedor     = 0;
        $gl_comuna_vendedor     = 0;

        if (!empty($arrRoles)) {
            foreach ($arrRoles as $rol) {
                //si es rol vendedor talonario busca id_bodega para buscar talonarios disponibles
                if ($rol->mur_fk_rol == 5) {
                    $gl_bodega_vendedor         = $rol->gl_bodega;
                    $gl_territorio_vendedor     = $rol->gl_territorio;
                    $gl_region_vendedor         = $rol->gl_region;
                    $gl_comuna_vendedor         = $rol->gl_comuna;
                }
            }
        }

        if ($params) {

            $id_medico      = $params['id_profesional_medico'];
            $arrTalonario   = $params['arrTalonario'];
            $arrMedico         = $params['arrMedico'];
            $flag_venta        = 0;

            foreach ($arrTalonario as $talonario) {
                $verifica_vendido = $this->_DAOTalonariosVendidos->getByTalonario($talonario->fk_talonario);
                if (!empty($verifica_vendido)) :
                    $flag_venta = 1;
                    break;
                endif;
            }

            if ($flag_venta == 0) {
                //Guardar Venta y enviar a Trámites
                $talonariosASD  = "";
                $cantidad         = 0;

                foreach ($arrTalonario as $talonario) {
                    $talonariosASD .= $talonario->gl_talonario . ":";
                    $cantidad++;
                }

                //Guardar WS
                $clave      = sha1('fnet' . sha1($arrMedico->id_comuna . $cantidad . $arrMedico->gl_rut) . date('d') . date('m'));
                $arrData    = base64_encode(array(
                    "rut"               => $arrMedico->gl_rut,
                    "nombre_completo"   => $arrMedico->gl_nombres . " " . $arrMedico->gl_apellido_paterno . " " . $arrMedico->gl_apellido_materno,
                    "direccion"         => $arrMedico->gl_direccion,
                    "region"            => $arrMedico->id_region,
                    "comuna"            => $arrMedico->id_comuna,
                    "email"             => $arrMedico->gl_email,
                    "talonariosASD"     => $talonariosASD,
                    "cantidad"          => $cantidad,
                    "idv"               => 0,
                    "region_fap"        => $id_region_sesion,
                    "clave"             => $clave,
                ));

                $respuestaWS    = $this->guardaWSVentaTalonario($arrData);
                $datosASD       = $respuestaWS['datosASD'];
                $intentos       = $respuestaWS['intentos'];
                $estadoASD      = $respuestaWS['estadoASD'];
                //Si fallaron los 3 intentos devuelva error
                //cuando funcione el WS quitar el "false &&" del if y el $datosASD
                $datosASD = array("codigo" => "123213", "monto" => "1000");
                if (false && $estadoASD != 1) {

                    error_log('intentos: ' . $intentos);
                    error_log('datosASD: ' . print_r($datosASD, true));
                    $salida['correcto'] = false;
                    $salida['msgError'] = "La conexión con el sistema ASDigital ha fallado.<br>Favor volver a intentar o cont&aacute;ctese con la <b>Mesa de Ayuda</b> ";
                    echo json_encode($salida);
                    exit();
                } else {

                    $id_venta   = $this->_DAOVenta->insertar($id_medico, $id_usuario_crea, $id_region_sesion);

                    foreach ($arrTalonario as $talonario) {
                        $this->_DAOTalonariosVendidos->insertar($talonario->fk_talonario, $id_venta);
                        $this->_DAOAsignacionTalonario->setVenta($talonario->asignacion_id, 1);
                    }

                    $retorno    = $this->_DAOVenta->setDatosTramite($id_venta, $datosASD['codigo'], $datosASD['monto']);
                    $datosVenta = (array)$this->_DAOVenta->getDetalleById($id_venta);

                    $arrDataPdf = array(
                        "Codigo_ASD"                => $datosASD['codigo'],
                        "Fecha_Venta"               => $datosVenta['fc_compra'],
                        "Comuna_Nombre"             => $gl_comuna_vendedor,
                        "Seremi_Autoridad"          => $gl_region_vendedor,
                        "Seremi_Direccion"          => $gl_territorio_vendedor,
                        "Vendedor_Nombre"           => $datosVenta['gl_nombre_vendedor'],
                        "Vendedor_Apellido_Paterno" => $datosVenta['gl_apellidop_vendedor'],
                        "Vendedor_Apellido_Materno" => $datosVenta['gl_apellidom_vendedor'],
                        "Vendedor_RUT"              => $datosVenta['gl_rut_vendedor'],
                        "Nombre_bodega"             => $datosVenta['gl_local_venta'],
                        "Medico_Nombre"             => $datosVenta['gl_nombre_medico'],
                        "Medico_Apellido_Paterno"   => $datosVenta['gl_apellidop_medico'],
                        "Medico_Apellido_Materno"   => $datosVenta['gl_apellidom_medico'],
                        "Medico_RUT"                => $datosVenta['gl_rut_medico'],
                        "Especialidad"              => $datosVenta['gl_especialidad_medico'],
                        "Talonarios_Vendidos"       => count($arrTalonario)
                    );

                    //Guardar pdf Boleta Venta
                    $html        = $this->view->fetchIt('pdf/boletaVentaTalonario', $arrDataPdf, '_FuncionesGenerales/General');
                    $ruta         = DOCS_ROUTE . "documentos/";
                    $pdf_nombre    = $id_venta . '-DetalleVenta-' . date('Y-m-d') . '.pdf';
                    $filePdf    = \Pdf::GenerarPDF($html, $pdf_nombre, 'default', 'S');
                    $AdjBoleta    = \Adjunto::saveFile($ruta, $filePdf, $pdf_nombre);

                    $data['pdf_nombre']    = $pdf_nombre;
                    $data['ok']            = TRUE;
                    $this->_DAOVenta->setBoleta($id_venta, $pdf_nombre, $intentos);
                }

                //Si adjuntó archivo PYME se procede a guardado Lógico y Físico
                if (
                    isset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjPyme']) &&
                    isset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjPyme']['adjuntos'][0])
                ) {
                    //Obtengo adjunto de session para guardado Lógico y Físico
                    $adjunto    = $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjPyme']['adjuntos'][0];

                    //Guardo en Disco 
                    $ruta             = DOCS_ROUTE . "beneficio/pyme/" . date('Y') . "/" . $id_venta . "/";
                    $AdjGuardado    = \Adjunto::saveFile($ruta, base64_decode($adjunto['contenido']), $adjunto['gl_nombre']);
                    if (!$AdjGuardado) {
                        $salida['correcto'] = false;
                        $salida['msgError'] = "Error al guardar en disco ID : " . $id_medico . "";
                        echo json_encode($salida);
                        exit();
                    }

                    //Se guarda Archivo Adjunto Prorroga
                    $fileParams = array(
                        $id_medico,
                        DOCS_ROUTE . date('Y') . "/" . $id_medico . "/" . $adjunto['gl_nombre']
                    );

                    $archivoGuardado =  $this->_DAOMedicoAdjunto->insertar($fileParams);
                    if (!$archivoGuardado) {
                        //Se borra archivo si no fue ingresado en base de datos
                        $flag = false;
                        while (!$flag) {
                            if (unlink(DOCS_ROUTE . date('Y') . "/" . $id_medico . "/" . $adjunto['gl_nombre'])) {
                                $flag = true;
                            }
                        }
                        $salida['correcto'] = false;
                        $salida['msgError'] = "Estimado Usuario:<br>Ha ocurrido un error al guardar el registro de adjunto PYME.";
                        echo json_encode($salida);
                        exit();
                    }
                }

                $salida['correcto'] = true;

                if ($salida['correcto']) {
                    $salida['msgError'] = "El Talonario ha sido guardado correctamente.";
                    $_SESSION[\Constantes::SESSION_BASE]['ventaTalonario']['id_venta']  = $id_venta;
                }
            } else {
                $salida['correcto'] = false;
                $salida['msgError'] = 'Estos talonarios ya fueron vendidos, <strong>Evite</strong> refrescar(Apretar F5) la pantalla mientras se hace la venta';
            }
        }

        echo json_encode($salida);
    }

    public function guardaWSVentaTalonario($arrData)
    {
        $url            = "http://localhost/asdigital/tramites_testing/jsonp/farmanet_v2_talonario.php?arrData='" . $arrData . "'";
        $url            = str_replace(" ", "%20", $url);
        $datosASD        = array();
        $estadoASD        = 0;
        $intentos       = 0;

        //Intenta 3 veces hacer el file_get_contents
        while ($estadoASD == 0 && empty($datosASD) && $intentos < 3) :
            $intentos++;
            $nuevoIntento    = file_get_contents($url . "&tipo_llamada=fgc");
            $nuevoIntento    = utf8_encode($nuevoIntento);
            $datosASD        = json_decode($nuevoIntento, true);
            $estadoASD        = (isset($datosASD['estado'])) ? $datosASD['estado'] : 0;
        endwhile;

        return array("intentos" => $intentos, "datosASD" => $datosASD, "estadoASD" => $estadoASD);
    }

    public function ventaTalonarioRealizada()
    {

        $params                = $_SESSION[\Constantes::SESSION_BASE]['ventaTalonario'];
        $arrMedico             = $params['arrMedico'];
        $arrTalonario         = $params['arrTalonario'];
        $id_venta             = $params['id_venta'];
        $arrUltimasCompras     = $this->_DAOVenta->getLastByMedico($params['id_profesional_medico'], 5);

        $this->view->addJS('ventaTalonario.js');
        $this->view->addJS('adjunto.js', 'app/_FuncionesGenerales/Adjuntos/assets/js');
        $this->view->addJS('Adjunto.cargarGrilla("adjPyme");$("#adjuntos").show();');

        $this->view->set('id_venta', $id_venta);
        $this->view->set('arrMedico', $arrMedico);
        $this->view->set('arrTalonario', $arrTalonario);
        $this->view->set('arrUltimasCompras', $arrUltimasCompras);
        $this->view->set('contenido', $this->view->fetchIt('ventaTalonarioRealizada'));
        $this->view->render();
    }

    public function verBoleta($id_venta)
    {
        $arrVenta           = $this->_DAOVenta->getDetalleById($id_venta);
        $glNombre           = $arrVenta->archivo_boleta;
        $extensionPDF       = (strpos($glNombre, ".pdf") === false) ? ".pdf" : "";
        \Adjunto::openFile(DOCS_ROUTE . "documentos/" . $glNombre . $extensionPDF);
    }


    /**
     * @author cosof-ricardo-munoz 
     * @since 14-08-2020
     * 
     * guardar Talonario
     */
    public function ingresarTalonarios()
    {

        $this->session->isValidate();
        $arrTalonarioTipoDocumento  = $this->_DAOTalonarioTipoDocumento->all();
        $arrTalonarioTipoProveedor  = $this->_DAOTalonarioTipoProveedor->all();

        $this->view->addJS('validador.js', 'pub/js/');
        $this->view->addJS('talonario.js');

        $this->view->set('arrTalonarioTipoDocumento', $arrTalonarioTipoDocumento);
        $this->view->set('arrTalonarioTipoProveedor', $arrTalonarioTipoProveedor);
        $this->view->set('formulario_ingresar_talonario', $this->view->fetchIt('ingresar_talonario/formulario_ingresar_talonario'));
        $this->view->set('contenido', $this->view->fetchIt('ingresar_talonario/ingresar_talonario'));
        $this->view->render();
    }

    /**
     * @author cosof-ricardo-munoz 
     * @since 14-08-2020
     * 
     * guardar Talonario
     */
    public function guardarTalonario()
    {
        $this->session->isValidate();

        $params = $this->request->getParametros();
        $correcto = false;
        $error = false;
        $msgError = "";
        $idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 0;

        $idBodega = (isset($_SESSION[\Constantes::SESSION_BASE]['bodega'])) ? $_SESSION[\Constantes::SESSION_BASE]['bodega'] : 20; //CEN Valparaiso

        // validar formulario formCrearTalonario
        $msgError = $this->fn_validar_formulario($params);

        $correcto = true;

        if ($msgError == "") {

            $nr_folioInicial = trim($params['nr_folioInicial']);
            $nr_cantidadTalonario = trim($params['nr_cantidadTalonario']);

            /**
             * generar ciclo por la cantidad de talonarios
             * 
             * nr_cantidadTalonario int
             */
            $arrDatosTalonarioCreado = array(
                // 'tc_id' => NULL,
                'talonario_serie' => trim($params['gl_serie']),
                'talonario_folio_inicial' => $nr_folioInicial,
                'talonario_folio_final' => ($nr_cantidadTalonario * self::CANTIDAD_CHEQUES_POR_TALONARIO) + $nr_folioInicial - 1,
                'cantidad' => $nr_cantidadTalonario,
                'cheques' => self::CANTIDAD_CHEQUES_POR_TALONARIO,
                'documento' => trim($params['id_documento']),
                'nr_documento' => trim($params['nr_documento']),
                'fc_documento' => \Fechas::formatearBaseDatosSinComilla(trim($params['fc_documento'])),
                'proveedor' => trim($params['id_proveedor']),
                'bo_estado' => 2,
                'fk_usuario' => $idUsuario
            );

            $arrDatosTalonario = array(
                // 'talonario_id' => NULL,
                'talonario_serie' => trim($params['gl_serie']),
                // 'talonario_folio_inicial' => 0,
                // 'talonario_folio_final' => 0,
                'talonario_cantidad' => $nr_cantidadTalonario,
                'fk_usuario' => $idUsuario,
                'Ingreso_sistema' => \Fechas::fechaHoy()
                // 'fk_tc_id' => NULL
            );

            $arrDatosAsignacionTalonario = array(
                // 'asignacion_id' => NULL,
                // 'fk_talonario' => NULL, 
                // 'folio_inicial' => 0,
                'bodega_central' => $idBodega,
                'fecha_asig_bc' => \Fechas::fechaHoy(),
                'estado_talonario' => 2
            );

            $nr_FolioInicial_aux = $nr_folioInicial;
            $nr_folioFinal = $nr_folioInicial;

            $tc_id = $this->_DAOTalonariosCreados->create($arrDatosTalonarioCreado);

            if ($tc_id > 0) {
                $arrCorrecto[] = true;
            }

            for ($iCont = 1; $iCont <= $nr_cantidadTalonario; $iCont++) {
                $nr_folioFinal = $nr_folioInicial + self::CANTIDAD_CHEQUES_POR_TALONARIO;

                $arrDatosTalonarioCreado["talonario_folio_inicial"] = $nr_folioInicial;
                $arrDatosTalonarioCreado["talonario_folio_final"] = $nr_folioFinal - 1; // => 1 + 50 = 51 - 1 = 50

                // $tc_id = $this->_DAOTalonariosCreados->create($arrDatosTalonarioCreado);

                // if ($tc_id > 0) {
                //     $arrCorrecto[] = true;
                // }

                $arrDatosTalonario["fk_tc_id"] = $tc_id;
                $arrDatosTalonario["talonario_folio_inicial"] = $arrDatosTalonarioCreado["talonario_folio_inicial"];
                $arrDatosTalonario["talonario_folio_final"] = $arrDatosTalonarioCreado["talonario_folio_final"];
                $talonario_id = $this->_DAOTalonario->create($arrDatosTalonario);

                $arrDatosAsignacionTalonario["fk_talonario"] = $talonario_id;
                $arrDatosAsignacionTalonario["folio_inicial"] = $arrDatosTalonarioCreado["talonario_folio_inicial"];
                $this->_DAOAsignacionTalonario->create($arrDatosAsignacionTalonario);


                // if ((int)$tc_id === 0) {
                //     $correcto       = false;
                // break;
                // }

                $nr_folioInicial = $nr_folioInicial + self::CANTIDAD_CHEQUES_POR_TALONARIO;
            }
            if (in_array(false, $arrCorrecto)) {
                $correcto = false;
            } else {
                $msgError = "El Talonario ha sido guardado correctamente.";
            }
        }

        $json   = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);

        echo json_encode($json);
    }

    /**
     * @author cosof-ricardo-munoz 
     * @since 23-08-2020
     * 
     * validar Formulario
     */
    private function fn_validar_formulario($params)
    {
        $msgError = "";

        if (trim($params['gl_serie']) === "") {
            $msgError .= "- Por favor, ingrese una Serie.</br>";
        }
        if (trim($params['nr_folioInicial']) === "") {
            $msgError .= "- Por favor, ingrese un Folio inicial.</br>";
        }
        if (trim($params['nr_cantidadTalonario']) === "") {
            $msgError .= "- Por favor, ingrese la cantidad de Talonarios.</br>";
        }
        if ((int)$params['id_proveedor'] === 0) {
            $msgError .= "- Por favor, seleccione un Proveedor. </br>";
        }
        if ((int)$params['id_documento'] === 0) {
            $msgError .= "- Por favor, seleccione un Documento. </br>";
        }
        if (trim($params['nr_documento']) === "") {
            $msgError .= "- Por favor, ingrese el N&uacute;mero de Documento.</br>";
        }
        if (trim($params['fc_documento']) === "") {
            $msgError .= "- Por favor, seleccione la Fecha de Documento.</br>";
        }

        $arrValidaFolioExiste = $this->validarFolioExiste(false);

        if (true == $arrValidaFolioExiste["error"]) {
            $msgError .= "- " . $arrValidaFolioExiste["mensaje"] . "</br>";
        }

        return $msgError;
    }

    /**
     * @author cosof-ricardo-munoz 
     * @since 23-08-2020
     * 
     * validar Folio Existe en BD
     */
    public function validarFolioExiste($retornaJSON = true)
    {

        $this->session->isValidate();

        $params = $this->request->getParametros();
        $correcto = false;
        $error = false;
        $msgError = "";

        $respuesta = $this->_DAOTalonario->getValidarFolioExiste(
            $params["nr_folioInicial"],
            $params["nr_folioFinal"],
            $params["gl_serie"]
        );

        if ($respuesta) {
            $msgError = "No existe un folio en el sistema. Puede continuar.";
            $correcto = true;
        } else {
            $msgError = "Existe un folio en el sistema. Debe modificar la serie o el número de folio";
            $error = true;
        }

        $json = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);
        if ($retornaJSON) {
            echo json_encode($json);
            exit();
        } else {
            return $json;
        }
    }
}
