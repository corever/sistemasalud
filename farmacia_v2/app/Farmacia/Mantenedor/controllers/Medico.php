<?php

/**
 ******************************************************************************
 * Sistema           : Farmacia
 *
 * Descripción       : Controlador de Mantenedor:Medico
 *
 * Plataforma        : PHP
 *
 * Creación          : 14/08/2019
 *
 * @name             Medico.php
 *
 * @version          1.0.0
 *
 * @author           Felipe Bocaz <felipe.bocaz@cosof.cl>
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

namespace App\Farmacia\Mantenedor;

use Pan\Utils\ValidatePan as validatePan;

class Medico extends \pan\Kore\Controller
{
	private $_DAORegion;
	private $_DAOComuna;
	private $_DAOUsuario;
	private $_DAOUsuarioHistorial;
	private $_DAOModulo;
	private $_DAOUsuarioModulo;
	private $_DAOIdioma;
	private $_DAOOpcion;
	private $_DAOUsuarioOpcion;
	private $_DAOProfesion;
	private $_DAOEspecialidad;
	private $_DAOCodigoRegion;
	private $_DAOTerritorio;
	private $_DAOBodega;
	private $_DAOLocal;
	private $_DAOMedico;
	private $_DAOMedicoConsulta;

	public function __construct()
	{
		parent::__construct();
		$this->session->isValidate();

		$this->_DAORegion				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOComuna				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOUsuario				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;
		$this->_DAOUsuarioHistorial		=	new \App\Usuario\Entity\DAOUsuarioHistorial();
		$this->_DAOModulo				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoModulo;
		$this->_DAOUsuarioModulo		=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioModulo;
		$this->_DAOIdioma				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoIdioma;
		$this->_DAOOpcion				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoOpcion;
		$this->_DAOUsuarioOpcion		=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioOpcion;
		$this->_DAOProfesion			=	new \App\_FuncionesGenerales\General\Entity\DAOProfesion;
		$this->_DAOEspecialidad			=	new \App\Establecimiento\Home\Entity\DAOEspecialidad();
		$this->_DAOCodigoRegion			=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;
		$this->_DAOTerritorio			=	new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOBodega				=	new \App\_FuncionesGenerales\General\Entity\DAOBodega;
		$this->_DAOMedico				=	new \App\Farmacia\Mantenedor\Entity\DAOMedico();
		$this->_DAOMedicoConsulta		=	new \App\Farmacia\Mantenedor\Entity\DAOMedicoConsulta();
		
		$this->_DAOLocal				=	new \App\Farmacias\Farmacia\Entities\DAOLocal;
		
		//$this->$_DAOMedico					= new \App\Mantenedor\Entity\DAOAccesoMedico;

	}

	public function index(){

			//$this->session->isValidate();
	$arrRegion  = $this->_DAORegion->getLista();
	$arrComuna  = $this->_DAOComuna->getLista();


	$this->view->set('arrRegion', $arrRegion);
	$this->view->set('arrComuna', $arrComuna);
	$this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_medico']['filtros']);

	$this->view->addJS('regiones.js','pub/js/helpers');
	$this->view->addJS('mantenedorMedico.js');

	$this->view->set('filtros',   $this->view->fetchIt('medico/filtros'));
	$this->view->set('grilla',    $this->view->fetchIt('medico/grilla'));
	$this->view->set('contenido', $this->view->fetchIt('medico/index'));
	$this->view->render();
}

public function grillaMedico(){

		$params     = $this->request->getParametros();
		$arrMedico	= $this->_DAOMedico->getListaMantenedorMedico($params);
		$arrGrilla  = array('data'=>array());

		//Guardo Filtros en SESSION
		$_SESSION[\Constantes::SESSION_BASE]['mantenedor_medico']['filtros']   = $params;

if(!empty($arrMedico)){
				foreach($arrMedico as $item){
						$arr    = array();

						$arr['rut']         = $item->gl_rut;
						$arr['nombre']      = $item->gl_nombre_completo;
						$arr['email']       = $item->gl_email;
						$arr['telefono']    = $item->gl_telefono;
						$arr['genero']      = $item->gl_genero;
						$arr['direccion']   = $item->gl_direccion;
						$arr['opciones']    = ' <button type="button" class="btn btn-xs btn-success"
																				onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Mantenedor/Medico/editarMedico/'.$item->gl_token.'\',\''. addslashes(\Traduce::texto("Editar Medico")) .' <b>'.$item->gl_nombre_completo.'</b>\',\'90\');"
																				data-toggle="tooltip" title="'.\Traduce::texto("Editar Medico").'"><i class="fa fa-edit"></i>
																		</button>
																		<button type="button" class="btn btn-xs btn-warning"
																				onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Mantenedor/Medico/mostrarMedico/'.$item->gl_token.'\',\''.\Traduce::texto("Datos de").' <b>'.$item->gl_nombre_completo.'</b>\',\'lg\');"
																				data-toggle="tooltip" title="'.\Traduce::texto("Datos de Medico").'"><i class="fa fa-list-ul"></i>
																		</button>
																		<button type="button" class="btn btn-xs bg-purple"
																				onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Mantenedor/Medico/grillaSucursalMedico/'.$item->gl_token.'\',\''.\Traduce::texto("Sucursal(es) de").' <b>'.$item->gl_nombre_completo.'</b>\',\'90\');"
																				data-toggle="tooltip" title="'.\Traduce::texto("Editar Sucursales").'"><i class="fa fa-table"></i>
																		</button>
																		';

						if($item->bo_activo == 1){
								$arr['opciones']    .= ' <button type="button" class="btn btn-xs btn-danger"
																						onclick="MantenedorMedico.habilitarMedico(\''.$item->id_medico.'\',0);"
																						data-toggle="tooltip" title="'.\Traduce::texto("Deshabilitar").'"><i class="fas fa-ban"></i>
																				</button>
																				';
						}else{
								$arr['opciones']    .= ' <button type="button" class="btn btn-xs btn-success"
																						onclick="MantenedorMedico.habilitarMedico(\''.$item->id_medico.'\',1);"
																						data-toggle="tooltip" title="'.\Traduce::texto("Habilitar").'"><i class="fas fa-check"></i>
																				</button>
																				';
						}

						$arrGrilla['data'][] = $arr;
				}
		}

		echo json_encode($arrGrilla);
}


/**
 * Descripción	: Cargar vista agregar Medico
 * @author		: <felipe.bocaz@cosof.cl>        - 14/08/2020
 */
public function agregarMedico()
{
	$this->session->isValidate();

	$arrProfesion   = $this->_DAOProfesion->getListaOrdenadaMedic(2);
	$arrEspecialidad = $this->_DAOEspecialidad->getListaOrdenada();
			$arrRegion      = $this->_DAORegion->getLista();
			$arrComuna      = $this->_DAOComuna->getLista();
			$arrCodRegion   = $this->_DAOCodigoRegion->getLista();

			$this->view->addJS('$("#fc_nacimiento_medico").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
	$this->view->addJS('$(".labelauty").labelauty();');
	$this->view->set('arrProfesion', $arrProfesion);
	$this->view->set('arrEspecialidad', $arrEspecialidad);
	$this->view->set('arrRegion', $arrRegion);
	$this->view->set('arrComuna', $arrComuna);
	$this->view->set('arrCodRegion', $arrCodRegion);

	$this->view->set('datosMedico',   $this->view->fetchIt('medico/datos_medico'));
	$this->view->render('medico/agregar_medico.php');
}

/**
 * Descripción : Guardar Nuevo Medico
 * @author     : <felipe.bocaz@cosof.cl>    - 14/08/2020
 */
public function agregarMedicoBD()
{
	$this->session->isValidate();
			$params 	        = $this->request->getParametros();
			$correcto           = false;
			$error              = false;
			$gl_rut_medico             = trim($params['gl_rut_medico']);
			$gl_email_medico           = trim($params['gl_email_medico']);
			$gl_token           = \Seguridad::generaTokenUsuario($gl_rut_medico);
			$idUsuario          = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;
			$msgError           = "";
			$gl_rut_medico_2           = \DataValidator::formatearRut($gl_rut_medico); //(con puntos y guion)

			if ($gl_rut_medico == "") {
					$msgError .= "- Rut es Obligatorio. <br>";
			}
			if (!\Validar::validarRutPersona($gl_rut_medico)) {
					$msgError .= "- Rut es Incorrecto. <br>";
			}
			if ($gl_email_medico == "") {
					$msgError .= "- Email es Obligatorio. <br>";
			}
			if (!\Email::validar_email($gl_email_medico)) {
					$msgError .= "- Email es Incorrecto. <br>";
			}
			if (trim($params['gl_nombre_medico']) == "") {
					$msgError .= "- Nombre es Obligatorio. <br>";
			}
			if (trim($params['gl_apellido_paterno_medico']) == "") {
					$msgError .= "- Apellido Paterno es Obligatorio. <br>";
			}
			if (trim($params['gl_apellido_materno_medico']) == "") {
					$msgError .= "- Apellido Materno es Obligatorio. <br>";
			}
			if ($params['id_profesion_medico'] == 0) {

			}
			if ($params['id_especialidad_medico'] == 0) {

			}
			if (!isset($params['chk_genero_medico'])) {
					$msgError .= "- Género es Obligatorio. <br>";
			}
			if (trim($params['fc_nacimiento_medico']) == "") {
					$msgError .= "- Fecha Nacimiento es Obligatorio. <br>";
			}
			if ($params['id_region_medico'] == 0) {
					$msgError .= "- Región es Obligatorio. <br>";
			}
			if ($params['id_comuna_medico'] == 0) {
					$msgError .= "- Comuna es Obligatorio. <br>";
			}
			if (trim($params['gl_direccion_medico']) == "") {
					$msgError .= "- Dirección es Obligatorio. <br>";
			}
			if (trim($params['id_codregion_medico']) == "") {
					$msgError .= "- Codigo de Teléfono es Obligatorio. <br>";
			}
			if (trim($params['gl_telefono_medico']) == "") {
					$msgError .= "- Teléfono es Obligatorio. <br>";
			}
			if (trim($params['id_region_consulta']) == "") {
					$msgError .= "-  Region Consulta es Obligatorio. <br>";
			}
			if (trim($params['id_comuna_consulta']) == "") {
					$msgError .= "- Comuna Consulta es Obligatorio. <br>";
			}
			if (trim($params['gl_direccion_consulta']) == "") {
					$msgError .= "- Direccion de Consulta es Obligatorio. <br>";
			}
			if (trim($params['id_codregion_consulta']) == "") {
					$msgError .= "- Codigo de Teléfono Consulta es Obligatorio. <br>";
			}
			if (trim($params['gl_telefono_consulta']) == "") {
					$msgError .= "- Teléfono de Consulta es Obligatorio. <br>";
			}


			if ($msgError == "") {

					$datosMedico   = array(
																	$gl_token,
																	$gl_rut_medico_2,
																	$gl_rut_medico,
																	trim($params['gl_nombre_medico']),
																	trim($params['gl_apellido_paterno_medico']),
																	trim($params['gl_apellido_materno_medico']),
																	($params['chk_genero_medico']=="M")?"Masculino":"Femenino",
																	(!empty($params['fc_nacimiento_medico']))?\Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento_medico']):"0000-00-00 00:00:00",
																	$gl_email_medico,
																	$params['id_region_medico'],
																	$params['id_comuna_medico'],
																	trim($params['gl_direccion_medico']),
																	$params['gl_telefono_medico'],
																	$params['id_codregion_medico'],
																	1 //activo
															);


					$id_medico     = $this->_DAOMedico->insertMedico($datosMedico);

					if($id_medico > 0){
							$correcto       = true;

							$datosSucursalMedico   = array(
																			$id_medico,
																			$params['id_region_consulta'],
																			$params['id_comuna_consulta'],
																			trim($params['gl_direccion_consulta']),
																			$params['id_codregion_consulta'],
																			$params['gl_telefono_consulta'],
																			1 //activo
																	);
							$this->_DAOMedicoConsulta->insertSucursal($datosSucursalMedico);

							//Guardar profesion de medico
							if($params['id_profesion_medico'] > 0){
										$this->_DAOProfesion->insertar(array($id_medico,$params['id_profesion_medico']));
							}
							//Guardar especialidad
							if($params['id_especialidad_medico'] > 0){
										$this->_DAOEspecialidad->insertar(array($id_medico,$params['id_especialidad_medico']));
								}
					}else{
							$error      = true;
							$msgError   = "Hubo un problema al guardar. Favor Comunicarse con Mesa de Ayuda.";
					}
			}

	$json   = array("correcto" => $correcto, "error" => $error, "msgError" => $msgError);

			echo json_encode($json);
}

	/**
* Descripción	: Desplegar Formulario para Editar Medico
* @author		: Felipe Bocaz <felipe.bocazn@cosof.cl> - 18/08/2020
*/
public function editarMedico($gl_token){

			$arrUsuario     = $this->_DAOMedico->getByUsuario($gl_token);
			$arrProfesion   = $this->_DAOProfesion->getListaOrdenada();
			$arrEspecialidad = $this->_DAOEspecialidad->getListaOrdenada();
			$arrRegion      = $this->_DAORegion->getLista();
			$arrComuna      = $this->_DAOComuna->getLista();
			$arrCodRegion   = $this->_DAOCodigoRegion->getLista();

	$this->view->addJS('$("#fc_nacimiento_medico").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
	$this->view->addJS('$(".labelauty").labelauty();');
	$this->view->set('arrProfesion', $arrProfesion);
	$this->view->set('arrEspecialidad', $arrEspecialidad);
	$this->view->set('arrRegion', $arrRegion);
	$this->view->set('arrComuna', $arrComuna);
	$this->view->set('arrCodRegion', $arrCodRegion);
	$this->view->set('arr', $arrUsuario);
	$this->view->set('boEditar', 1);
	$this->view->set('gl_token', 1);

	$this->view->set('datosMedico',   $this->view->fetchIt('medico/actualizar_medico'));
			$this->view->render('medico/agregar_medico.php');

}

/**
* Descripción : Guardar Datos Editados de Medico
* @author Felipe Bocaz <felipe.bocaz@cosof.cl> - 05/08/2020
*/
public function editarMedicoBD(){

	$params         = $this->request->getParametros();
	$correcto       = false;
	$error          = false;
			$gl_rut         = trim($params['gl_rut_medico']);
			$gl_email       = trim($params['gl_email_medico']);
			$idMedico      = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;
			$msgError       = "";
			$arrMedico     = $this->_DAOMedico->getByUsuario($params['gl_token_medico']);

			if ($gl_rut == "") {
					$msgError .= "- Rut es Obligatorio. <br>";
			}
			if (!\Validar::validarRutPersona($gl_rut)) {
					$msgError .= "- Rut es Incorrecto. <br>";
			}
			if ($gl_email == "") {
					$msgError .= "- Email es Obligatorio. <br>";
			}
			if (!\Email::validar_email($gl_email)) {
					$msgError .= "- Email es Incorrecto. <br>";
			}
			if (trim($params['gl_nombre_medico']) == "") {
					$msgError .= "- Nombre es Obligatorio. <br>";
			}
			if (trim($params['gl_apellido_paterno_medico']) == "") {
					$msgError .= "- Apellido Paterno es Obligatorio. <br>";
			}
			if (trim($params['gl_apellido_materno_medico']) == "") {
					$msgError .= "- Apellido Materno es Obligatorio. <br>";
			}
			if ($params['id_profesion_medico'] == 0) {
					//$msgError .= "- Profesión es Obligatorio. <br>";
			}
			if ($params['id_especialidad_medico'] == 0) {
					//$msgError .= "- Profesión es Obligatorio. <br>";
			}
			if (!isset($params['chk_genero_medico'])) {
					$msgError .= "- Género es Obligatorio. <br>";
			}
			if (trim($params['fc_nacimiento_medico']) == "") {
					$msgError .= "- Fecha Nacimiento es Obligatorio. <br>";
			}
			if ($params['id_region_medico'] == 0) {
					$msgError .= "- Región es Obligatorio. <br>";
			}
			if ($params['id_comuna_medico'] == 0) {
					$msgError .= "- Comuna es Obligatorio. <br>";
			}
			if (trim($params['gl_direccion_medico']) == "") {
					$msgError .= "- Dirección es Obligatorio. <br>";
			}

			if ($msgError == "") {

					$datosMedico   = array(
																	trim($params['gl_nombre_medico']),
																	trim($params['gl_apellido_paterno_medico']),
																	trim($params['gl_apellido_materno_medico']),
																	//intval($params['id_profesion_usuario']),
																	($params['chk_genero_medico']=="M")?"Masculino":"Femenino",
																	(!empty($params['fc_nacimiento_medico']))?\Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento_medico']):"0000-00-00 00:00:00",
																	$gl_email,
																	$params['id_region_medico'],
																	$params['id_comuna_medico'],
																	$params['gl_direccion_medico'],
																	$params['id_codregion_medico'],
																	$params['gl_telefono_medico']
					);

					$correcto       = $this->_DAOMedico->modificarMedico($params['gl_token_medico'],$datosMedico);

					if($correcto){
							$arr_tag        = array("[TAG_NOMBRE_CREADOR]");
							$arr_replace    = array($_SESSION[\Constantes::SESSION_BASE]['gl_nombre_completo']);
					}
			}else{
					$error      = true;
					$msgError   = "Hubo un problema al guardar. Favor Comunicarse con Mesa de Ayuda.";
			}

	$json			= array("correcto" => $correcto, "error" => $error);

			echo json_encode($json);
}


/**
* Descripción : Habilitar Medico
* @author Felipe Bocaz <felipe.bocaz@cosof.cl> - 19/08/2020
*/
public function habilitarMedico(){
	$json       = array("correcto" => false);
			$params     = $this->request->getParametros();

			$bo_update  = $this->_DAOMedico->setActivoByTokenMedico($params['gl_token'],$params['bo_activo']);

			if($bo_update){
					$json	= array("correcto" => true);
			}

			echo json_encode($json);
}

public function habilitarSucursal(){
	$json       = array("correcto" => false);
			$params     = $this->request->getParametros();

			$bo_update  = $this->_DAOMedicoConsulta->setActivoByTokenSucursal($params['gl_token'],$params['bo_activo']);

			if($bo_update){
					$json	= array("correcto" => true);
			}

			echo json_encode($json);
}

	/*
			* Carga datos de rut persona por medio de WS
			* Creador: <david.guzman@cosof.cl> 07-08-2020
	*/
	function cargarPersonaWS(){

			$params         = $this->request->getParametros();
			$rut_dv         = $params['rut'];
			$data           = array();

			if (!is_null($rut_dv)) {

					$rut = explode('-',$rut_dv);
					if ($rut[0] && $rut[1]){
							$data = file_get_contents(URL_WS_RUT . '?rut='.$rut[0].'&dv='.$rut[1]);
					}
			}

			return json_encode($data);
	}

	public function mostrarMedico($gl_token){

		$arrUsuario     = $this->_DAOMedico->getByUsuario($gl_token);
		$profesion 			= $arrUsuario->id_profesion;
		$especialidad 	= $arrUsuario->id_especialidad;
		$region					= $arrUsuario->id_region;
		$comuna 				= $arrUsuario->id_comuna;
		$arrProfesion   = $this->_DAOProfesion->getName($profesion);
		$arrEspecialidad = $this->_DAOEspecialidad->getName($especialidad);
		$arrRegion      = $this->_DAORegion->getById($region);
		$arrComuna      = $this->_DAOComuna->getById($comuna);
		$arrCodRegion   = $this->_DAOCodigoRegion->getLista();

		$this->view->set('arrProfesion', $arrProfesion);
		$this->view->set('arrEspecialidad', $arrEspecialidad);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrCodRegion', $arrCodRegion);

		$this->view->set('arr', $arrUsuario);

		$this->view->render('medico/verdatos_medico.php');

	}

	public function grillaSucursalMedico($gl_token){

		$arrSucursal = $this->_DAOMedicoConsulta->getListaSucursalMedico($gl_token);

			$id_medico = $this->_DAOMedico->getByUsuario($gl_token);

			$this->view->set('medico', $id_medico);
			$this->view->set('arr', $arrSucursal);
			$this->view->render('medico/grilla_sucursal.php');


	}

	public function agregarSucursal($id_medico)
	{
		$this->session->isValidate();

				$arrRegion      = $this->_DAORegion->getLista();
				$arrComuna      = $this->_DAOComuna->getLista();
				$arrCodRegion   = $this->_DAOCodigoRegion->getLista();

				$this->view->set('medico', $id_medico);
				$this->view->set('arrRegion', $arrRegion);
				$this->view->set('arrComuna', $arrComuna);
				$this->view->set('arrCodRegion', $arrCodRegion);

				$this->view->set('datosSucursal',   $this->view->fetchIt('medico/sucursal_medico'));
				$this->view->render('medico/agregar_sucursal.php');
	}

	/**
	 * Descripción : Guardar Nuevo Medico
	 * @author     : <felipe.bocaz@cosof.cl>    - 14/08/2020
	 */
	public function agregarSucursalBD()
	{
		$this->session->isValidate();
				$params 	        = $this->request->getParametros();
				$correcto           = false;
				$error              = false;
				$idUsuario          = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;
				$msgError           = "";


				if (trim($params['id_region_consulta']) == "") {
						$msgError .= "-  Region Consulta es Obligatorio. <br>";
				}
				if (trim($params['id_comuna_consulta']) == "") {
						$msgError .= "- Comuna Consulta es Obligatorio. <br>";
				}
				if (trim($params['gl_direccion_consulta']) == "") {
						$msgError .= "- Direccion de Consulta es Obligatorio. <br>";
				}
				if (trim($params['id_codregion_consulta']) == "") {
						$msgError .= "- Codigo de Teléfono Consulta es Obligatorio. <br>";
				}
				if (trim($params['gl_telefono_consulta']) == "") {
						$msgError .= "- Teléfono de Consulta es Obligatorio. <br>";
				}


				if ($msgError == "") {

					$datosSucursalMedico   = array(
																	$params['gl_token_medico'],
																	$params['id_region_consulta'],
																	$params['id_comuna_consulta'],
																	trim($params['gl_direccion_consulta']),
																	$params['id_codregion_consulta'],
																	$params['gl_telefono_consulta'],
																	1 //activo
															);

						$id_medico     = $this->_DAOMedicoConsulta->insertSucursal($datosSucursalMedico);

						if($id_medico > 0){
								$correcto       = true;

						}else{
								$error      = true;
								$msgError   = "Hubo un problema al guardar. Favor Comunicarse con Mesa de Ayuda.";
						}
				}

		$json   = array("correcto" => $correcto, "error" => $error, "msgError" => $msgError);

				echo json_encode($json);
	}
	public function editarSucursal($gl_token){

				$arrSucursal     = $this->_DAOMedico->getByTokenSucursal($gl_token);
				$arrRegion      = $this->_DAORegion->getLista();
				$arrComuna      = $this->_DAOComuna->getLista();
				$arrCodRegion   = $this->_DAOCodigoRegion->getLista();

				$this->view->set('arrRegion', $arrRegion);
				$this->view->set('arrComuna', $arrComuna);
				$this->view->set('arrCodRegion', $arrCodRegion);
				$this->view->set('arr', $arrSucursal);
				$this->view->set('boEditar', 1);

				$this->view->set('datosSucursal',   $this->view->fetchIt('medico/sucursal_medico'));
				$this->view->render('medico/agregar_sucursal.php');

	}

	/**
	* Descripción : Guardar Datos Editados de Medico
	* @author Felipe Bocaz <felipe.bocaz@cosof.cl> - 05/08/2020
	*/
	public function editarSucursalBD(){

		$params         = $this->request->getParametros();
		$correcto       = false;
		$error          = false;
				$gl_rut         = trim($params['gl_rut_medico']);
				$gl_email       = trim($params['gl_email_medico']);
				$idMedico      = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;
				$msgError       = "";
				$arrMedico     = $this->_DAOMedico->getByUsuario($params['gl_token_medico']);

				if ($gl_rut == "") {
						$msgError .= "- Rut es Obligatorio. <br>";
				}
				if (!\Validar::validarRutPersona($gl_rut)) {
						$msgError .= "- Rut es Incorrecto. <br>";
				}
				if ($gl_email == "") {
						$msgError .= "- Email es Obligatorio. <br>";
				}
				if (!\Email::validar_email($gl_email)) {
						$msgError .= "- Email es Incorrecto. <br>";
				}
				if (trim($params['gl_nombre_medico']) == "") {
						$msgError .= "- Nombre es Obligatorio. <br>";
				}
				if (trim($params['gl_apellido_paterno_medico']) == "") {
						$msgError .= "- Apellido Paterno es Obligatorio. <br>";
				}
				if (trim($params['gl_apellido_materno_medico']) == "") {
						$msgError .= "- Apellido Materno es Obligatorio. <br>";
				}
				if ($params['id_profesion_medico'] == 0) {
						//$msgError .= "- Profesión es Obligatorio. <br>";
				}
				if ($params['id_especialidad_medico'] == 0) {
						//$msgError .= "- Profesión es Obligatorio. <br>";
				}
				if (!isset($params['chk_genero_medico'])) {
						$msgError .= "- Género es Obligatorio. <br>";
				}
				if (trim($params['fc_nacimiento_medico']) == "") {
						$msgError .= "- Fecha Nacimiento es Obligatorio. <br>";
				}
				if ($params['id_region_medico'] == 0) {
						$msgError .= "- Región es Obligatorio. <br>";
				}
				if ($params['id_comuna_medico'] == 0) {
						$msgError .= "- Comuna es Obligatorio. <br>";
				}
				if (trim($params['gl_direccion_medico']) == "") {
						$msgError .= "- Dirección es Obligatorio. <br>";
				}

				if ($msgError == "") {

						$datosMedico   = array(
																		trim($params['gl_nombre_medico']),
																		trim($params['gl_apellido_paterno_medico']),
																		trim($params['gl_apellido_materno_medico']),
																		//intval($params['id_profesion_usuario']),
																		($params['chk_genero_medico']=="M")?"Masculino":"Femenino",
																		(!empty($params['fc_nacimiento_medico']))?\Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento_medico']):"0000-00-00 00:00:00",
																		$gl_email,
																		$params['id_region_medico'],
																		$params['id_comuna_medico'],
																		$params['gl_direccion_medico'],
																		$params['id_codregion_medico'],
																		$params['gl_telefono_medico']
						);

						$correcto       = $this->_DAOMedico->modificarMedico($params['gl_token_medico'],$datosMedico);

						if($correcto){
								$arr_tag        = array("[TAG_NOMBRE_CREADOR]");
								$arr_replace    = array($_SESSION[\Constantes::SESSION_BASE]['gl_nombre_completo']);
						}
				}else{
						$error      = true;
						$msgError   = "Hubo un problema al guardar. Favor Comunicarse con Mesa de Ayuda.";
				}

		$json			= array("correcto" => $correcto, "error" => $error);

				echo json_encode($json);
	}


}
