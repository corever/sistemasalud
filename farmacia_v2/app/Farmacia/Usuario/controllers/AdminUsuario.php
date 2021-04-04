<?php

namespace App\Farmacia\Usuario;

/**
 ******************************************************************************
 * Sistema           : Farmacia v2
 *
 * Descripción       : Controlador Login
 *
 * Plataforma        : PHP
 *
 * Creación          : 14/09/2020
 *
 * @name             AdminUsuario.php
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

class AdminUsuario extends \pan\Kore\Controller
{

	/*Inicializando Variables*/
	protected $_DAOUsuario;
	private $_DAODireccionRegion;
	private $_DAOProfesion;
	private $_DAOAccesoRol;
	private $_DAOUsuarioEstado;
	private $_DAOInformacionUsuario;

	const BASE_TOKEN_SEGURIDAD = "usuario_token_";

	public function __construct()
	{

		parent::__construct();

		$this->_DAOUsuario  = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario();
		$this->_DAODireccionRegion = new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOProfesion = new \App\_FuncionesGenerales\General\Entity\DAOProfesion;
		$this->_DAOAccesoRol = new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol;
		$this->_DAOUsuarioEstado = new \App\_FuncionesGenerales\General\Entity\DAOUsuarioEstado;
		$this->_DAOInformacionUsuario = new \App\Usuario\Entity\DAOInformacionUsuario;
	}

	public function index()
	{

		$this->view->addJS('adminUsuario.js');
		$this->view->set('contenido', $this->view->fetchIt('adminUsuario/index'));
		$this->view->render();
	}

	public function infoUsuario()
	{

		$this->view->addJS('adminUsuario.js');

		// where order by nr_orden
		// $arrRoles = $this->_DAOAccesoRol->all();
		$arrRoles = $this->_DAOAccesoRol->getLista();
		$arrRegion = $this->_DAODireccionRegion->all();
		$arrProfesiones = $this->_DAOProfesion->all();
		$arrUsuarioEstado = $this->_DAOUsuarioEstado->all();

		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrRoles', $arrRoles);
		$this->view->set('arrProfesiones', $arrProfesiones);
		$this->view->set('arrUsuarioEstado', $arrUsuarioEstado);

		$this->view->set('filtros', $this->view->fetchIt('informacionUsuario/buscador_filtros'));
		$this->view->set('resultado', $this->view->fetchIt('informacionUsuario/buscador_resultado'));
		$this->view->set('grilla', $this->view->fetchIt('informacionUsuario/buscador_resultado_grilla'));
		$this->view->set('contenido', $this->view->fetchIt('informacionUsuario/buscador_index'));
		$this->view->render();
	}

	private function fn_validar_formulario_infoUsuario($params)
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
		return $msgError;
	}

	public function grillaInformacionUsuario()
	{

		$params     = $this->request->getParametros();

		$arrGrilla  = array('data' => array());

		if (1 === (int)$params["bo_buscar"]) {


			// var_dump($params);

			//Guardo Filtros en SESSION
			$_SESSION[\Constantes::SESSION_BASE]['informacion_usuario']['filtros']   = $params;

			// $arrBodegas = $this->_DAOUsuario->all($params);
			// if (!empty($params["bodega_nombre"])) {
			//     $arrFiltros["bodega_nombre"] = "%".$params["bodega_nombre"]."%";
			// }
			// if (!empty($params["bodega_direccion"])) {
			//     $arrFiltros["bodega_direccion"] = $params["bodega_direccion"];
			// }
			// if (!empty($params["fk_bodega_tipo"]) && 0 !== (int)$params["fk_bodega_tipo"]) {
			// 	$arrFiltros["fk_bodega_tipo"] = (int)$params["fk_bodega_tipo"];
			// }
			// if (!empty($params["fk_region"]) && 0 !== (int)$params["fk_region"]) {
			// 	$arrFiltros["fk_region"] = $params["fk_region"];
			// }
			// $arrFiltros["bodega_estado"] = 1;

			// var_dump($arrFiltros);

			// $arrBodegas = $this->_DAOBodega->where($arrFiltros, "")->runQuery()->getRows();


			// var_dump($query, $param);
			$result = $this->_DAOInformacionUsuario->getGrillaInformacionUsuario($params);

			if (!empty($result)) {
				foreach ($result as $item) {
					$arr    = array();

					$arr['token'] = \Seguridad::hashBaseClave(self::BASE_TOKEN_SEGURIDAD, $item->bodega_id);
					$arr['rut'] = $item->mu_rut_midas;
					$arr['usuario'] = $item->mu_nombre . " " .  $item->mu_apellido_paterno . " " .  $item->mu_apellido_materno;
					$arr['region_nombre'] = $item->region_nombre;
					$arr['fk_region'] = $item->region_id;
					$arr['estado_id'] = $item->mu_estado_sistema;
					$arr['estado'] = $item->nombre_estado;
					$arr['rol_id'] = $item->rol_id;
					$arr['rol'] = $item->rol_nombre;
					$arr['profesion_id'] = $item->id_profesion;
					$arr['profesion'] = $item->nombre_profesion;
					$arr['opciones']    = '';

					$arrGrilla['data'][] = $arr;

					break;
					// $arr['opciones']    = '

					//                         <button type="button" class="btn btn-xs verBodega "
					// 							data-toggle="tooltip" title="' . \Traduce::texto("Ver Bodega") . '"><i class="fa fa-eye"></i>
					//                         </button> 
					// 						<button type="button" class="btn btn-xs "
					// 							onclick="document.forms.formAsignarTalonario_' . $item->bodega_id . '.submit();">
					// 							<i class="fa fa-star"></i>
					// 						</button> 
					//                         <button type="button" class="btn btn-xs editarBodega"
					//                             data-toggle="tooltip" title="' . \Traduce::texto("Editar Bodega") . '"><i class="fa fa-edit"></i>
					// 						</button>';
					// if (1 === (int) $item->bodega_estado) {
					// 	$arr['opciones']    .= '
					//                         <button type="button" class="btn btn-xs inhabilitarBodega "
					//                             data-toggle="tooltip" title="' . \Traduce::texto("Inhabilitar Bodega") . '"><i class="fa fa-times"></i>
					// 						</button> ';
					// }
					// if (0 === (int) $item->bodega_estado) {
					// 	$arr['opciones']    .= '
					//                         <button type="button" class="btn btn-xs habilitarBodega "
					//                             data-toggle="tooltip" title="' . \Traduce::texto("Habilitar Bodega") . '"><i class="fa fa-check"></i>
					// 						</button> ';
					// }
					// $arr['opciones']    .= '
					//                         <form name="formAsignarTalonario_' . $item->bodega_id . '" method="POST" action="' . \pan\uri\Uri::getHost() . 'Farmacia/Talonarios/AsignarTalonario/' . '">
					//                             <input type="hidden" name="bodega_id" value="' . $item->bodega_id . '"/>
					//                         </form>
					//                         ';

				}
			}
		}


		echo json_encode($arrGrilla);
	}
}
