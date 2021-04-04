<?php

namespace App\Farmacia\Turnos;

use Permisos;
use Seguridad;

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
 * @name             AdminResolucion.php - Ejemplo para copiar y pegar
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
 * ricardo.munoz			25/09/2020		Agrega Turno Urgencia
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

class AdminResolucion extends \pan\Kore\Controller
{

	/*Inicializando Variables*/
	protected $_DAOUsuario;
	private $_DAODireccionRegion;
	private $_DAODireccionComuna;
	private $_DAOTerritorio;
	private $_DAOAnyo;
	private $_DAOTurnoTipoPeriodo;
	private $_DAOLocal;
	private $_DAOTurno;
	private $_DAOTurnoResolucionDoc;
	private $_DAOTurnoCodResolucion;
	private $_DAOTurnoResolucion;
	private $_DAOTurnoDetalle;

	const TURNO_URGENCIA = 3;

	public function __construct()
	{

		parent::__construct();

		// date_default_timezone_set('America/Santiago');
		// setlocale(LC_ALL, 'es_CL');
		$this->_DAOUsuario = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;
		$this->_DAODireccionRegion = new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAODireccionComuna = new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOTerritorio = new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOAnyo = new \App\_FuncionesGenerales\General\Entity\DAOAnyo;
		$this->_DAOTurnoTipoPeriodo = new \App\Farmacia\Turnos\Entities\DAOTurnoTipoPeriodo;
		$this->_DAOLocal = new \App\Farmacias\Farmacia\Entities\DAOLocal;
		$this->_DAOTurno = new \App\Farmacia\Turnos\Entities\DAOTurno;
		$this->_DAOTurnoResolucionDoc = new \App\Farmacia\Turnos\Entities\DAOTurnoResolucionDoc;
		$this->_DAOTurnoCodResolucion = new \App\Farmacia\Turnos\Entities\DAOTurnoCodResolucion;
		$this->_DAOTurnoResolucion = new \App\Farmacia\Turnos\Entities\DAOTurnoResolucion;
		$this->_DAOTurnoDetalle = new \App\Farmacia\Turnos\Entities\DAOTurnoDetalle;
	}

	public function index()
	{

		$this->view->addJS('adminResolucion.js');
		$this->view->set('contenido', $this->view->fetchIt('index'));
		$this->view->render();
	}

	/**
	 * cosof-ricardo-munoz
	 * 25-09-2020
	 */
	public function resolucionUrgencia()
	{
		$this->session->isValidate();

		// Si es Usuario Admin / Nacional muestra todas las regiones
		$arrRegion = $this->_DAODireccionRegion->all();
		// $arrComuna = $this->_DAODireccionComuna->all();
		$arrComuna = array();
		// $arrEstablecimientoUrgencia = $this->_DAOLocal->getEstablecimientoUrgencia();
		$arrEstablecimientoUrgencia = array();

		// Si es Usuario Regional 
		// $arrRegion = $this->_DAODireccionRegion->getByPK();
		// $arrComuna = $this->_DAODireccionComuna->getByRegion();
		// $arrEstablecimientoUrgencia = $this->_DAOLocal->getByComuna();

		$arrPeriodo = $this->_DAOTurnoTipoPeriodo->all();
		$arrAnyo = $this->_DAOAnyo->all();

		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrEstablecimientoUrgencia', $arrEstablecimientoUrgencia);
		$this->view->set('arrPeriodo', $arrPeriodo);
		$this->view->set('arrAnyo', $arrAnyo);

		$this->view->addJS('validador.js', 'pub/js/');
		$this->view->addJS('regiones.js', 'pub/js/helpers');
		$this->view->addJS('ingresarResolucionUrgencia.js');

		$this->view->set('formulario', $this->view->fetchIt('resoluciones_urgencia/formulario'));
		$this->view->set('contenido', $this->view->fetchIt('resoluciones_urgencia/ingresar'));
		$this->view->render();
	}

	/**
	 * cosof-ricardo-munoz
	 * 25-09-2020
	 */
	public function guardarResolucionUrgencia()
	{
		$this->session->isValidate();
		$correcto = false;
		$error = false;
		$mensaje = "";

		$params     = $this->request->getParametros();

		parse_str($params["formData"], $params);

		$validarGuardarResolucionUrgencia = $this->validarGuardarResolucionUrgencia($params);

		if (true === $validarGuardarResolucionUrgencia) {
			// guardar Turno

			// obtiene informacion del Periodo Seleccionado
			$oPeriodo = $this->_DAOTurnoTipoPeriodo->getByPK($params["id_periodo"]);

			// actualiza la fecha de turno, inicio y termino, de acuerdo al año seleccionado
			$params["turno_fecha_inicio"] =  $params["id_anyo"] . "" . substr($oPeriodo->fc_turno_tipo_dia_mes_inicio, 4);
			$params["turno_fecha_termino"] =  $params["id_anyo"] . "" . substr($oPeriodo->fc_turno_tipo_dia_mes_termino, 4);

			// obtiene codigo turno resolucion desde tabla turno_cod_resolucion
			$params["nrCodigoTurnoCodResolucion"] = $this->_DAOTurnoCodResolucion->getTurnoCodResolucionByRegionAndAnyo($params["id_region"], $params["id_anyo"]);;

			// obtiene el texto de Resolucion
			$params["glFormatoResolucion"] = $this->_DAOTurnoResolucionDoc->getContenidoDocumento($params["id_region"], self::TURNO_URGENCIA);


			// guarda el registro
			$params["nrCodigoTurno"] = $this->guardarTurno($params);

			// PENDIENTE cambia las variables del formato de la resolucion
			$arrDataPdf = $this->_DAOTurnoResolucionDoc->patchContenidoDocumentoUrgencia($params);

			// ob_start();
			// echo $params["glFormatoResolucion"];
			// $glFormatoResolucion = ob_end_flush();

			//debe ser full ruta
			// app tiene una constante?
			$rutaTemp = 'app/_FuncionesGenerales/General/views/resolucion/';
			$nombreTemp = "resolucion"; // . date("Y-m-d");
			$nombreFile = $nombreTemp . ".php";

			$bo_FormatoResolucion = \Adjunto::saveFile($rutaTemp,  $params["glFormatoResolucion"], $nombreFile);
			// echo __LINE__;
			// var_dump($rutaTemp . $nombreFile);
			// var_dump($bo_FormatoResolucion);
			// die(__METHOD__);
			// echo __LINE__;
			//Guardar pdf 
			$html = $this->view->fetchIt("resolucion/" . $nombreTemp, $arrDataPdf, '_FuncionesGenerales/General');
			$ruta = DOCS_ROUTE . "documentos/";
			$pdf_nombre = $params["nrCodigoTurno"] . '-Resolucion-' . date('Y-m-d') . '.pdf';
			$filePdf = \Pdf::GenerarPDF($html, $pdf_nombre, 'default', 'S');
			$ResolucionFisico = \Adjunto::saveFile($ruta, $filePdf, $pdf_nombre);
			$params["nombre_archivo_firmado"] = $pdf_nombre;
			// var_dump($html);
			// var_dump($ruta);
			// var_dump($pdf_nombre);
			// die(__METHOD__);

			// guarda turno_resolucion
			$this->guardarTurnoResolucion($params);

			// guarda turno_detalle
			$this->guardarTurnoDetalle($params);

			$correcto = true;
			$mensaje = "Se ha Ingresado una nueva Resolución Urgencia.";
		} else {
			$error = true;
			$mensaje = $validarGuardarResolucionUrgencia;
		}

		$json = array("correcto" => $correcto, "error" => $error, "mensaje" => $mensaje);

		echo json_encode($json);
	}

	/**
	 * cosof-ricardo-munoz
	 * 29-09-2020
	 * retorna codigo TurnoCodResolucion
	 */
	private function guardarTurnoDetalle($params)
	{
		return $this->_DAOTurnoDetalle->create(
			array(
				"turno_dia" => $params["turno_fecha_inicio"],
				"fk_turno" => $params["nrCodigoTurno"],
				"fk_local" =>  $params["id_establecimiento_urgencia"],
				"fk_local_original" =>  $params["id_establecimiento_urgencia"],
				"detalle_hora_inicio" => "00:00",
				"detalle_hora_termino" => "23:59",
				"turno_detalle_confirmado" => 1
				// ,
				// "fk_usuario_creacion" => 1,
				// "fc_creacion" => 1
			)
		);
	}

	/**
	 * cosof-ricardo-munoz
	 * 29-09-2020
	 * retorna codigo TurnoCodResolucion
	 */
	private function guardarTurnoResolucion($params)
	{
		return $this->_DAOTurnoResolucion->create(
			array(
				"fk_turno_id" => $params["nrCodigoTurno"],
				"fk_seremi_firmador" => 0,
				"tr_fecha_firma" => \Fechas::fechaHoy(),
				"nombre_archivo_firmado" => $params["nombre_archivo_firmado"],
				"fk_usuario_visador" => 0,
				"html_turno_visado" => $params["glFormatoResolucion"],
				"tr_fecha_creacion" => \Fechas::fechaHoy()
			)
		);
	}


	/**
	 * cosof-ricardo-munoz
	 * 29-09-2020
	 */
	private function getFormatoResolucion($params)
	{
		$arrWhere = array();
		$arrParams = "tr_doc_contenido";

		$arrWhere["fk_region"] = $params["id_region"];
		$arrWhere["fk_turno_documento_tipo"] = self::TURNO_URGENCIA;

		$oTurnoResolucionDoc = $this->_DAOTurnoResolucionDoc
			->where($arrWhere, $arrParams)->runQuery()->getRows()[0];

		// si no encuentra un registro por la region especifica, busca el "nacional" region = 0
		if (is_null($oTurnoResolucionDoc)) {
			$arrWhere["fk_region"] = 0;
			$arrWhere["fk_turno_documento_tipo"] = self::TURNO_URGENCIA;

			$oTurnoResolucionDoc = $this->_DAOTurnoResolucionDoc
				->where($arrWhere, $arrParams)->runQuery()->getRows()[0];
		}

		return $oTurnoResolucionDoc->tr_doc_contenido;
	}

	/**
	 * cosof-ricardo-munoz
	 * 25-09-2020
	 */
	private function guardarTurno($params)
	{
		$arrData["fk_region"] = $params["id_region"];
		$arrData["fk_comuna"] = $params["id_comuna"];

		$arrData["turno_fecha_inicio"] = $params["turno_fecha_inicio"];
		$arrData["turno_fecha_termino"] = $params["turno_fecha_termino"];

		$arrData["turno_tipo"] = 'URGENCIA'; // $arrData["turno_tipo"] = 3;
		$arrData["html_turno_visado"] = $params["glFormatoResolucion"];
		// $arrData["gl_punto2"] = $params["gl_punto2"];
		$arrData["estado_turno"] = 1;
		$arrData["fecha_creacion"] = \Fechas::fechaHoy();
		$arrData["fk_creador"] = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 0;
		//Default Values
		$arrData["turno_hora_inicio"] = "00:00";
		$arrData["turno_hora_termino"] = "23:59";
		$arrData["cod_resolucion"] = 0;
		$arrData["fecha_resolucion"] = date("Y-m-d");
		$arrData["fk_seremi_firmador"] = 0;
		$arrData["nombre_archivo_firmado"] = "";
		$arrData["fk_usuario_visador"] = 0;
		$arrData["horario"] = "";
		$arrData["gob_fecha_notifica"] = date("Y-m-d");
		$arrData["gob_nombre_notificador"] = "";
		$arrData["gob_forma_notifica"] = "";
		$arrData["gob_descripcion"] = "";
		$arrData["gob_fk_usuario"] = 0;
		$arrData["gob_fc_creacion"] = date("Y-m-d");
		$arrData["gob_estado"] = "";

		// $return  = $this->_DAOTurno->create($arrData);
		// var_dump($return);
		// exit();
		return $this->_DAOTurno->create($arrData);
	}

	/**
	 * cosof-ricardo-munoz
	 * 25-09-2020
	 */
	private function validarGuardarResolucionUrgencia($params)
	{

		$mensaje = "";

		if ($params["id_region"] == 0) {
			$mensaje .= "- " + \Traduce::texto("Por favor, seleccione una Región") + ". <br>";
		}
		if ($params["id_comuna"] == 0) {
			$mensaje .= "- " + \Traduce::texto("Por favor, seleccione una Comuna") + ". <br>";
		}
		if ($params["id_establecimiento_urgencia"] == 0) {
			$mensaje .= "- " + \Traduce::texto("Por favor, seleccione un Establecimiento Urgencia") + ". <br>";
		}
		if ($params["id_periodo"] == 0) {
			$mensaje .= "- " + \Traduce::texto("Por favor, seleccione un Período") + ". <br>";
		}
		if ($params["id_anyo"] == 0) {
			$mensaje .= "- " + \Traduce::texto("Por favor, seleccione un Año") + ". <br>";
		}
		if ($params["gl_punto2"] == "") {
			$mensaje .= "- " + \Traduce::texto("Por favor, ingrese un texto para el segundo punto de la resolución") + ". <br>";
		}

		return empty($mensaje) ? true : $mensaje;
	}
}
