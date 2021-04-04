<?php

namespace App\Farmacia\Bodegas;


/**
 ******************************************************************************
 * Sistema           : HOPE
 *
 * Descripción       : Controlador BOdega
 *
 * Plataforma        : PHP
 *
 * Creación          : 02/09/2020
 *
 * @name             AdminBodega.php
 *
 * @version          1.0.0
 *
 * @author			<ricardo.munoz@cosof.cl>
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
use DateTimeZone;

class AdminBodega extends \pan\Kore\Controller
{

	/*Inicializando Variables*/
	protected $_DAOUsuario;
	private $_DAOBodega;
	private $_DAOBodegaTipo;
	private $_DAODireccionRegion;
	private $_DAODireccionComuna;
	private $_DAOTerritorio;
	const BASE_TOKEN_SEGURIDAD = "bodega_token_";

	public function __construct()
	{

		parent::__construct();

		$this->_DAOUsuario				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;
		$this->_DAODireccionRegion		=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAODireccionComuna		=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOTerritorio			=	new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOBodega				=	new \App\Farmacia\Bodegas\Entity\DAOBodega;
		$this->_DAOBodegaTipo			=	new \App\Farmacia\Bodegas\Entity\DAOBodegaTipo;
	}

	/**
	 * buscar la bodega que le corresponde al Usuario
	 * y con el token enviar a "Ver Bodega"
	 */
	public function index()
	{

		$this->session->isValidate();

		$id_bodega = $this->getMiBodega($_SESSION[\Constantes::SESSION_BASE]['arrRoles']);

		if (!$id_bodega) {
			return false;
		} else {
			$Bodega = $this->_DAOBodega->getByPK($id_bodega);
		}

		$BodegaTipo = $this->_DAOBodegaTipo->getByPK($Bodega->fk_bodega_tipo);

		$Region = $this->_DAODireccionRegion->getByPK($Bodega->fk_region);

		$Territorio = $this->_DAOTerritorio->getByPK($Bodega->fk_territorio);

		$Comuna = $this->_DAODireccionComuna->getByPK($Bodega->fk_comuna);

		$this->view->set('Bodega', $Bodega);
		$this->view->set('BodegaTipo', $BodegaTipo);
		$this->view->set('Region', $Region);
		$this->view->set('Territorio', $Territorio);
		$this->view->set('Comuna', $Comuna);

		$this->view->set('vista', $this->view->fetchIt('admin_bodega/ver_bodega'));
		$this->view->set('contenido', $this->view->fetchIt('admin_bodega/admin_ver_mi_bodega'));
		$this->view->render();
	}

	/**
	 * Descripción	: admin Bodegas
	 * @author		: <ricardo.munoz@cosof.cl> - 19/08/2020
	 */
	public function administrarBodegas()
	{

		// var_dump($_SESSION);
		//Guardo Filtros en SESSION
		// $_SESSION[\Constantes::SESSION_BASE]['mantenedor_bodegas']['filtros']   = $params;

		$this->session->isValidate();

		$arrBodegaTipo = $this->_DAOBodegaTipo->all();

		$arrRegion = $this->_DAODireccionRegion->all();

		// $this->view->addJS('validador.js', 'pub/js/');
		$this->view->addJS('regiones.js',	'pub/js/helpers');
		$this->view->addJS('adminBodega.js');

		$this->view->set('arrBodegaTipo', $arrBodegaTipo);
		$this->view->set('arrRegion', $arrRegion);

		$this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_bodegas']['filtros']);

		$this->view->set('bodega_filtros', $this->view->fetchIt('admin_bodega/admin_bodega_filtros'));
		$this->view->set('bodega_grilla', $this->view->fetchIt('admin_bodega/admin_bodega_grilla'));
		$this->view->set('contenido', $this->view->fetchIt('admin_bodega/admin_bodega'));
		$this->view->render();
	}

	/**
	 * Descripción	: Grilla Bodegas
	 * @author		: <ricardo.munoz@cosof.cl> - 19/08/2020
	 */
	public function grillaBodega()
	{

		$params     = $this->request->getParametros();

		// var_dump($params);
		//Guardo Filtros en SESSION
		$_SESSION[\Constantes::SESSION_BASE]['mantenedor_bodegas']['filtros']   = $params;

		$arrRolTipoBodega = $this->getRolTipoBodega($_SESSION[\Constantes::SESSION_BASE]['arrRoles']);

		// if (!empty($params["bodega_nombre"])) {
		//     $arrFiltros["bodega_nombre"] = "%".$params["bodega_nombre"]."%";
		// }
		// if (!empty($params["bodega_direccion"])) {
		//     $arrFiltros["bodega_direccion"] = $params["bodega_direccion"];
		// }
		if (!empty($params["fk_bodega_tipo"]) && 0 !== (int)$params["fk_bodega_tipo"]) {
			$arrFiltros["fk_bodega_tipo"] = (int)$params["fk_bodega_tipo"];
		}
		if (!empty($params["fk_region"]) && 0 !== (int)$params["fk_region"]) {
			$arrFiltros["fk_region"] = $params["fk_region"];
		}

		// $arrFiltros["bodega_estado"] = 1; 

		$arrBodegas = $this->_DAOBodega->where($arrFiltros, "")->runQuery()->getRows();

		$arrGrilla  = array('data' => array());


		if (!empty($arrBodegas)) {
			foreach ($arrBodegas as $item) {

				if (!in_array($item->fk_bodega_tipo, $arrRolTipoBodega)) {
					continue;
				}

				$arr    = array();

				$arr['gl_token'] = \Seguridad::hashBaseClave(self::BASE_TOKEN_SEGURIDAD, $item->bodega_id);
				$arr['bodega_nombre'] = $item->bodega_nombre;
				$arr['bodega_direccion'] = $item->bodega_direccion;
				$arr['bodega_tipo_nombre'] =  $this->_DAOBodegaTipo->getByPK($item->fk_bodega_tipo)->bodega_tipo_nombre;
				$arr['fk_bodega_tipo'] = $item->fk_bodega_tipo;
				$arr['region_nombre'] =  $this->_DAODireccionRegion->getByPK($item->fk_region)->region_nombre;
				$arr['fk_region'] = $item->id_region_midas;
				$arr['opciones']    = '
                
                                        <button type="button" class="btn btn-xs verBodega "
											data-toggle="tooltip" title="' . \Traduce::texto("Ver Bodega") . '"><i class="fa fa-eye"></i>
                                        </button> 
										<button type="button" class="btn btn-xs "
											onclick="document.forms.formAsignarTalonario_' . $item->bodega_id . '.submit();">
											<i class="fa fa-star"></i>
										</button> 
                                        <button type="button" class="btn btn-xs editarBodega"
                                            data-toggle="tooltip" title="' . \Traduce::texto("Editar Bodega") . '"><i class="fa fa-edit"></i>
										</button>';
				if (1 === (int) $item->bodega_estado) {
					$arr['opciones']    .= '
                                        <button type="button" class="btn btn-xs inhabilitarBodega "
                                            data-toggle="tooltip" title="' . \Traduce::texto("Inhabilitar Bodega") . '"><i class="fa fa-times"></i>
										</button> ';
				}
				if (0 === (int) $item->bodega_estado) {
					$arr['opciones']    .= '
                                        <button type="button" class="btn btn-xs habilitarBodega "
                                            data-toggle="tooltip" title="' . \Traduce::texto("Habilitar Bodega") . '"><i class="fa fa-check"></i>
										</button> ';
				}
				$arr['opciones']    .= '
                                        <form name="formAsignarTalonario_' . $item->bodega_id . '" method="POST" action="' . \pan\uri\Uri::getHost() . 'Farmacia/Talonarios/AsignarTalonario/' . '">
                                            <input type="hidden" name="bodega_id" value="' . $item->bodega_id . '"/>
                                        </form>
                                        ';

				$arrGrilla['data'][] = $arr;
			}
		}

		echo json_encode($arrGrilla);
	}

	/**
	 * Descripción	: Ver Bodega
	 * @author		: <ricardo.munoz@cosof.cl> - 31/08/2020
	 */
	public function verBodega($gl_token)
	{

		$this->session->isValidate();

		$arrFiltros["gl_token"] = $gl_token;
		$Bodega = $this->_DAOBodega->where($arrFiltros, "")->runQuery()->getRows()[0];

		$BodegaTipo = $this->_DAOBodegaTipo->getByPK($Bodega->fk_bodega_tipo);

		$Region = $this->_DAODireccionRegion->getByPK($Bodega->fk_region);

		$Territorio = $this->_DAOTerritorio->getByPK($Bodega->fk_territorio);

		$Comuna = $this->_DAODireccionComuna->getByPK($Bodega->fk_comuna);

		// $arrRegion = $this->_DAORegion->all();

		// $this->view->addJS('validador.js', 'pub/js/');
		// $this->view->addJS('adminBodega.js');

		$this->view->set('Bodega', $Bodega);
		$this->view->set('BodegaTipo', $BodegaTipo);
		$this->view->set('Region', $Region);
		$this->view->set('Territorio', $Territorio);
		$this->view->set('Comuna', $Comuna);

		$this->view->render('admin_bodega/ver_bodega');
	}

	/**
	 * Descripción	: Editar Bodega
	 * @author		: <ricardo.munoz@cosof.cl> - 31/08/2020
	 */
	public function editarBodega($gl_token)
	{

		$this->session->isValidate();

		// $Bodega = $this->_DAOBodega->getByPK($bodega_id);

		$arrFiltros["gl_token"] = $gl_token;
		$Bodega = $this->_DAOBodega->where($arrFiltros, "")->runQuery()->getRows()[0];

		$BodegaTipo = $this->_DAOBodegaTipo->getByPK($Bodega->fk_bodega_tipo);

		$Region = $this->_DAODireccionRegion->getByPK($Bodega->fk_region);

		$Territorio = $this->_DAOTerritorio->getByPK($Bodega->fk_territorio);

		$Comuna = $this->_DAODireccionComuna->getByPK($Bodega->fk_comuna);

		// $arrRegion = $this->_DAORegion->all();

		// $this->view->addJS('validador.js', 'pub/js/');
		// $this->view->addJS('adminBodega.js');

		$this->view->set('Bodega', $Bodega);
		$this->view->set('BodegaTipo', $BodegaTipo);
		$this->view->set('Region', $Region);
		$this->view->set('Territorio', $Territorio);
		$this->view->set('Comuna', $Comuna);

		$this->view->render('admin_bodega/editar_bodega');
	}

	/**
	 * Descripción	: Editar Bodega
	 * @author		: <ricardo.munoz@cosof.cl> - 31/08/2020
	 */
	public function agregarBodega()
	{

		$this->session->isValidate();

		// $Bodega = $this->_DAOBodega->getByPK($bodega_id);

		$arrBodegaTipo = $this->_DAOBodegaTipo->all();

		$arrRegion = $this->_DAODireccionRegion->all();

		$arrTerritorio = $this->_DAOTerritorio->all();

		$arrComuna = $this->_DAODireccionComuna->all();

		// $arrRegion = $this->_DAORegion->all();

		// $this->view->addJS('validador.js', 'pub/js/');
		// $this->view->addJS('adminBodega.js');

		// $this->view->set('arrBodega', $arrBodega);
		$this->view->set('arrBodegaTipo', $arrBodegaTipo);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrTerritorio', $arrTerritorio);
		$this->view->set('arrComuna', $arrComuna);

		$this->view->render('admin_bodega/agregar_bodega');
	}

	/**
	 * Descripción	: Inhabilitar Bodega
	 * @author		: <ricardo.munoz@cosof.cl> - 31/08/2020
	 */
	public function inhabilitarBodega()
	{

		$this->session->isValidate();

		$params     = $this->request->getParametros();

		$arrFiltros["gl_token"] = $params["gl_token"];
		$Bodega = $this->_DAOBodega->where($arrFiltros, "")->runQuery()->getRows()[0];

		$correcto = false;
		$error = false;
		$msgError = "";
		$idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 0;

		if ($msgError == "") {
			$arrUpdate = array(
				"bodega_estado" => 0,
				"id_usuario_modificacion" => $idUsuario,
				"fc_modificacion" => \Fechas::fechaHoy()
			);
			$responseUpdate = $this->_DAOBodega->update($arrUpdate, $Bodega->bodega_id);

			if (true === $responseUpdate) {

				$correcto = true;
				$msgError = "La bodega " . $Bodega->bodega_nombre . " se ha inhabilitado.";
			} else {
				$msgError = "Hubo un problema, por favor contáctese con el administrador.";
			}
		}

		$json   = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);

		echo json_encode($json);
	}

	/**
	 * Descripción	: Habilitar Bodega
	 * @author		: <ricardo.munoz@cosof.cl> - 31/08/2020
	 */
	public function habilitarBodega()
	{

		$this->session->isValidate();

		$params     = $this->request->getParametros();

		$arrFiltros["gl_token"] = $params["gl_token"];
		$Bodega = $this->_DAOBodega->where($arrFiltros, "")->runQuery()->getRows()[0];

		$correcto = false;
		$error = false;
		$msgError = "";
		$idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 1;

		if ($msgError == "") {
			$arrUpdate = array(
				"bodega_estado" => 1,
				"id_usuario_modificacion" => $idUsuario,
				"fc_modificacion" => \Fechas::fechaHoy()
			);
			$responseUpdate = $this->_DAOBodega->update($arrUpdate, $Bodega->bodega_id);

			if (true === $responseUpdate) {
				$correcto = true;
				$msgError = "La bodega " . $Bodega->bodega_nombre . " se ha habilitado.";
			} else {
				$msgError = "Hubo un problema, por favor contáctese con el administrador.";
			}
		}

		$json   = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);

		echo json_encode($json);
	}

	/**
	 * Descripción	: Guardar Bodega
	 * @author		: <ricardo.munoz@cosof.cl> - 31/08/2020
	 */
	public function saveBodega()
	{

		$this->session->isValidate();

		$params     = $this->request->getParametros();

		$idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 1;
		$arrUpdate = array(
			// "bodega_estado" => 1,
			"id_usuario_modificacion" => $idUsuario,
			"fc_modificacion" => \Fechas::fechaHoy()
		);
		foreach ($params["form"] as $key => $value) {
			$arrUpdate[$value["name"]] = $value["value"];
		}
		// ANTES
		// $Bodega = $this->_DAOBodega->getByPK($params["bodega_id"]);

		$arrFiltros["gl_token"] = $params["gl_token"];
		$Bodega = $this->_DAOBodega->where($arrFiltros, "")->runQuery()->getRows()[0];

		$correcto = false;
		$error = false;
		$msgError = "";
		if ($msgError == "") {

			$responseUpdate = $this->_DAOBodega->update($arrUpdate, $Bodega->bodega_id);

			if (true === $responseUpdate) {
				// DESPUES
				$Bodega = $this->_DAOBodega->getByPK($Bodega->bodega_id);

				$correcto = true;
				$msgError = "Se ha editado la bodega: " . $Bodega->bodega_nombre . " correctamente.";
			} else {
				$msgError = "Hubo un problema, por favor contáctese con el administrador.";
			}
		}

		$json   = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);

		echo json_encode($json);
	}

	/**
	 * Descripción	: Agregar Bodega
	 * @author		: <ricardo.munoz@cosof.cl> - 31/08/2020
	 */
	public function createBodega()
	{

		$this->session->isValidate();

		$correcto = false;
		$error = false;
		$msgError = "";

		$params     = $this->request->getParametros();
		// var_dump($params);

		$idUsuario = (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 1;
		$arrCreate = array(
			"fk_territorio" => 0,
			"fk_comuna" => 0,
			"bodega_id_usuario" => 1,
			"bodega_fono" => 1,
			"bodega_fono_codigo" => 1,
			"bodega_estado" => 1,
			"id_usuario_creacion" => $idUsuario,
			"fc_creacion" => \Fechas::fechaHoy()
		);

		foreach ($params["form"] as $key => $value) {
			if (!empty($value["value"])) {
				$arrCreate[$value["name"]] = $value["value"];
			}
		}

		if ((int)$params['fk_bodega_tipo'] === 0) {
			$msgError .= "- Por favor, seleccione un Tipo.</br>";
		}
		if ((int)$params['fk_region'] === 0) {
			$msgError .= "- Por favor, seleccione un Región.</br>";
		}
		if (trim($params['bodega_direccion']) === "") {
			$msgError .= "- Por favor, ingrese una Dirección.</br>";
		}
		if (trim($params['bodega_telefono']) === "") {
			$msgError .= "- Por favor, ingrese un Teléfono.</br>";
		}
		if ($msgError == "") {



			/**
			 * crear nombre de bodega desde la bd
			 * BodegaTipo -> getByPk
			 * -> recuperar bodega_tipo_sigla
			 * si comuna esta seteado buscar comuna_nombre
			 * si territorio esta seteado buscar territorio_nombre
			 * si region esta seteado buscar nombre_region_corto
			 */

			$arrCreate["nombre_bodega"] = "";
			$BodegaTipo = $this->_DAOBodegaTipo->getByPK($params['fk_bodega_tipo']);
			$arrCreate["nombre_bodega"] = $BodegaTipo->bodega_tipo_sigla;
			$arrCreate["nombre_bodega"] .= "_";
			if ((int)$params['fk_comuna'] === 0) {
				$Comuna = $this->_DAODireccionComuna->getByPK($params['fk_comuna']);
				$arrCreate["nombre_bodega"] .= $Comuna->comuna_nombre;
			}
			if ((int)$params['fk_territorio'] === 0) {
				$Territorio = $this->_DAOTerritorio->getByPK($params['fk_territorio']);
				$arrCreate["nombre_bodega"] .= $Territorio->nombre_territorio;
			}
			if ((int)$params['fk_region'] === 0) {
				$Region = $this->_DAODireccionRegion->getByPK($params['fk_region']);
				$arrCreate["nombre_bodega"] .= $Region->nombre_region_corto;
			}

			$responseCreate = $this->_DAOBodega->create($arrCreate);

			if (is_numeric($responseCreate)) {
				// DESPUES
				$Bodega = $this->_DAOBodega->getByPK($responseCreate);

				$correcto = true;
				$msgError = "Se ha agregado la bodega: " . $Bodega->bodega_nombre . ", correctamente.";
			} else {
				$msgError = "Hubo un problema, por favor contáctese con el administrador.";
			}
		}

		$json   = array("correcto" => $correcto, "error" => $error, "mensaje" => $msgError);

		echo json_encode($json);
	}

	/**
	 * 
	 */
	function getRolTipoBodega($arrRoles)
	{
		if (!empty($arrRoles)) {
			foreach ($arrRoles as $key => $rol) {

				/** Rol 1 => Administrador */
				if (in_array($rol->mur_fk_rol, array(1))) {
					return array(1, 2, 3);
				}
				/** Rol 2 => Encargado Regional */
				if (in_array($rol->mur_fk_rol, array(2))) {
					return array(2, 3);
				}
				/** Rol 3 => Encargado Territorial */
				if (in_array($rol->mur_fk_rol, array(3))) {
					return array(3);
				}
				/** Rol 5 => Vendedor */
				if (in_array($rol->mur_fk_rol, array(5))) {
					return array(3);
				}
			}
		}
		/** Los demás perfiles */
		return array();
	}

	function getMiBodega($arrRoles)
	{

		if (!empty($arrRoles)) {
			foreach ($arrRoles as $key => $rol) {
				/** Rol 5 => Vendedor */
				if (in_array($rol->mur_fk_rol, array(5))) {
					return $rol->fk_bodega;
				}
			}
		}
	}



	/**
	 * Descripción	: Crear Nueva Bodega
	 * @author		: <ricardo.munoz@cosof.cl> - 31/08/2020
	 */
	public function crearBodega()
	{

		$this->session->isValidate();

		// $Bodega = $this->_DAOBodega->getByPK($bodega_id);

		$arrBodegaTipo = $this->_DAOBodegaTipo->all();

		$arrRegion = $this->_DAODireccionRegion->all();

		$arrTerritorio = $this->_DAOTerritorio->all();

		$arrComuna = $this->_DAODireccionComuna->all();

		// $arrRegion = $this->_DAORegion->all();

		$this->view->addJS('regiones.js', 'pub/js/helpers');
		$this->view->addJS('adminBodega.js');

		// $this->view->set('arrBodega', $arrBodega);
		$this->view->set('arrBodegaTipo', $arrBodegaTipo);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrTerritorio', $arrTerritorio);
		$this->view->set('arrComuna', $arrComuna);

		$this->view->set('vista', $this->view->fetchIt('admin_bodega/agregar_bodega'));
		$this->view->set('contenido', $this->view->fetchIt('admin_bodega/admin_crear_bodega'));
		$this->view->render();
	}
}
