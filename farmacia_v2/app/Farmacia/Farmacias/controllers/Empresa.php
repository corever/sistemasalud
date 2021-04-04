<?php
namespace App\Farmacia\Farmacias;

use Pan\Utils\panSession;
use Pan\Utils\ValidatePan as validatePan;
use Utils;

class Empresa extends \pan\Kore\Controller {

	private	$_DAORegion;
	private	$_DAOComuna;
	private	$_DAOFarmacia;
	private	$_DAOLocal;
	private	$_DAOMaestroEmpresa;
	private	$_DAOFarmaciaCaracter;
	private	$_DAOCodigoRegion;

	public function __construct(){
		parent::__construct();
		$this->session->isValidate();

		$this->_DAORegion				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOComuna				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOCodigoRegion			=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;
		
		$this->_DAOFarmacia				=	new \App\Farmacias\Farmacia\Entities\DAOFarmacia;
		$this->_DAOFarmaciaCaracter		=	new \App\Farmacias\Farmacia\Entities\DAOFarmaciaCaracter;
		$this->_DAOLocal				=	new \App\Farmacias\Farmacia\Entities\DAOLocal;
		
		/*	_DAOMaestroEmpresa	-> Borrar.*/
		$this->_DAOMaestroEmpresa		=	new \App\Farmacia\Maestro\Entities\DAOMaestroEmpresa;
	}

	public function index(){
		$this->session->isValidate();
		$this->view->addJS('maestro_empresa.js');
		$this->view->set('contenido', $this->view->fetchIt('empresa/empresa'));
		$this->view->render();
	}

	public function cargarGrilla(){
		$this->session->isValidate();
		$params     = $this->request->getParametros();
		$arrEmpresas = $this->_DAOMaestroEmpresa->obtenerEmpresasFarmaceuticas($params);

		$this->view->set('arrEmpresas', $arrEmpresas);
		$html = $this->view->fetchIt('empresa/grilla');

		$estado = true;
		$mensaje = "probando dao";

		$json['estado']		= $estado;
		$json['html']		= $html;
		$json['mensaje']	= $mensaje;
		echo json_encode($json);
	}

	/**
	 * Vista en Modal
	 */
	public function crearEmpresa(){
		$arrRegion						=	$this->_DAORegion->getLista();
		$arrComuna						=	$this->_DAOComuna->getLista();
		$arrCodfono						=	$this->_DAOCodigoRegion->getByParams();
		$arr_caracter					=	$this->_DAOFarmaciaCaracter->getLista(TRUE);

		$this->view->set('arrRegion',		$arrRegion);
		$this->view->set('arrComuna',		$arrComuna);
		$this->view->set('arrCodfono',		$arrCodfono);
		$this->view->set('arr_caracter',	$arr_caracter);

		$this->view->addJS('regiones.js',	'pub/js/helpers');

		$this->view->render('empresa/formulario');
	}

	/**
	 * Vista desde el menú directamente
	 */
	public function creacionEmpresa(){
		$arrRegion						=	$this->_DAORegion->getLista();
		$arrComuna						=	$this->_DAOComuna->getLista();
		$arrCodfono						=	$this->_DAOCodigoRegion->getByParams();
		$arr_caracter					=	$this->_DAOFarmaciaCaracter->getLista(TRUE);

		$this->view->set('arrRegion',		$arrRegion);
		$this->view->set('arrComuna',		$arrComuna);
		$this->view->set('arrCodfono',		$arrCodfono);
		$this->view->set('arr_caracter',	$arr_caracter);
		$this->view->set('mostrar_ruta',	TRUE);

		$this->view->addJS('regiones.js',	'pub/js/helpers');

		$this->view->addJS('maestro_empresa.js');
        $this->view->set('contenido', $this->view->fetchIt('empresa/formulario'));
        $this->view->render();
	}

	public function editarEmpresa($gl_token){
		
		$arrRegion						=	$this->_DAORegion->getLista();
		$arrComuna						=	$this->_DAOComuna->getLista();
		$arrCodfono						=	$this->_DAOCodigoRegion->getByParams();
		$arr_caracter					=	$this->_DAOFarmaciaCaracter->getLista(TRUE);
		$empresa						=	$this->_DAOFarmacia->getByToken($gl_token);

		$this->view->set('arrRegion',		$arrRegion);
		$this->view->set('arrComuna',		$arrComuna);
		$this->view->set('arrCodfono',		$arrCodfono);
		$this->view->set('arr_caracter',	$arr_caracter);
		$this->view->set('empresa',			$empresa);
		$this->view->set('bo_editar',		TRUE);

		$this->view->addJS('regiones.js',	'pub/js/helpers');

		$this->view->render('empresa/formulario');
	}

	public function guardarEmpresa(){
		$this->session->isValidate();
		$mensaje				=	"Hubo un Problema Guardando los Datos, Intentelo nuevamente o comuniquese con la mesa de ayuda.";
		$params					=	$this->request->getParametros();
		$form_validacion		=	$this->validarFormularioEmpresa($params);
		$resultado				=	FALSE;
		$json					=	array(
			"correcto"		=>	FALSE,
		);

		if($form_validacion["correcto"]){
			$id_empresa				=	$this->crearEmpresaBD($params);

			if(!empty($id_empresa)){
				$json["correcto"]	=	TRUE;
				//	Agregar Historial
			}else{
				$json["msj_error"]	=	"Error al insertar Empresa.";		
			}
		}else{
			$json["mensaje"]		=	$form_validacion["mensaje"];
		}

		$json["resultado"]	=	$resultado;
		$json["mensaje"]	=	$mensaje;

		echo json_encode($json);
	}

	private function crearEmpresaBD($params){
		$id_farmacia			=	NULL;
		$codigoPais				=	'+56';
		
		if(!empty($params)){
			$farmacia_caracter				=	isset($params["farmacia_caracter"])				?	$params["farmacia_caracter"]			:	NULL;
			$rut							=	isset($params["gl_rut"])						?	$params["gl_rut"]						:	NULL;
			$razon_social					=	isset($params["gl_razon_social"])				?	$params["gl_razon_social"]				:	NULL;
			$gl_nombre_fantasia				=	isset($params["gl_nombre_fantasia"])			?	$params["gl_nombre_fantasia"]			:	NULL;
			$gl_rut_representante			=	isset($params["gl_rut_representante"])			?	$params["gl_rut_representante"]			:	NULL;
			$gl_nombres_representante		=	isset($params["gl_nombres_representante"])		?	$params["gl_nombres_representante"]		:	NULL;
			$gl_apellidos_representante		=	isset($params["gl_apellidos_representante"])	?	$params["gl_apellidos_representante"]	:	NULL;
			$id_region						=	isset($params["id_region"])						?	$params["id_region"]					:	NULL;
			$id_comuna						=	isset($params["id_comuna"])						?	$params["id_comuna"]					:	NULL;
			$gl_direccion					=	isset($params["gl_direccion"])					?	$params["gl_direccion"]					:	NULL;
			$codigo_localidad				=	isset($params["id_codigo_fono"])				?	$params["id_codigo_fono"]				:	"";
			$farmacia_fono					=	isset($params["gl_fono"])						?	$params["gl_fono"]						:	"";
			$gl_codigo_fono					=	NULL;
			$gl_caracter					=	NULL;

			if(!empty($codigo_localidad)){
				$gl_codigo_fono				=	$this->_DAOCodigoRegion->getByPK($codigo_localidad)->codigo;
			}
			if(!empty($farmacia_caracter)){
				$gl_caracter				=	$this->_DAOFarmaciaCaracter->getByPK($farmacia_caracter)->gl_nombre;
			}

			$arr_rut						=	explode("-",$rut);
			$arr_rut_representante			=	explode("-",$gl_rut_representante);
			$rut_formateado					=	NULL;
			$rut_representante_formateado	=	NULL;
			if(is_array($arr_rut) && count($arr_rut) == 2){
				$_rut						=	number_format($arr_rut[0],0,",",".");
				$rut_formateado				=	$_rut."-".$arr_rut[1];
			}
			if(is_array($arr_rut_representante) && count($arr_rut_representante) == 2){
				$_rut_rep						=	number_format($arr_rut_representante[0],0,",",".");
				$rut_representante_formateado	=	$_rut_rep."-".$arr_rut_representante[1];
			}

			$gl_token						=	\Seguridad::generaTokenEmpresa($rut,$razon_social);
			$fono							=	trim($codigo_localidad.$farmacia_fono);
			
			if(!empty($fono)){
				$fono						=	$codigoPais.$fono;
			}else{
				$fono						=	NULL;
			}

			$arr_create						=	array(
				"gl_token"								=>	$gl_token,
				"farmacia_estado"						=>	1,
				//	Averiguar TIPO
				"farmacia_tipo"							=>	"",
				"farmacia_rut"							=>	$rut_formateado,
				"farmacia_rut_midas"					=>	$rut,
				"farmacia_razon_social"					=>	$razon_social,
				"farmacia_nombre_fantasia"				=>	$gl_nombre_fantasia,
				
				"farmacia_direccion"					=>	$gl_direccion,
				"fk_comuna"								=>	$id_comuna,
				"fk_region"								=>	$id_region,
				
				"farmacia_caracter"						=>	$gl_caracter,
				"id_caracter"							=>	$farmacia_caracter,
				
				"farmacia_telefono"						=>	$codigoPais.$farmacia_fono,
				"farmacia_fono_codigo"					=>	$gl_codigo_fono,
				"farmacia_fono"							=>	$farmacia_fono,
				
				"farmacia_rut_representante"			=>	$rut_representante_formateado,
				"farmacia_rut_representante_midas"		=>	$gl_rut_representante,
				"farmacia_nombre_representante"			=>	trim($gl_nombres_representante." ".$gl_apellidos_representante),
				
				"farmacia_fecha_creacion"				=>	date("Y-m-d H:i:s"),
				"fk_usuario_creacion"					=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"],
				
			);

			$id_farmacia		=	$this->_DAOFarmacia->create($arr_create);
		}

		return	$id_farmacia;
	}

	public function edicionEmpresa(){
		$this->session->isValidate();
		$params								=	$this->request->getParametros();
		$gl_token							=	isset($params["gl_token"]) 						?		$params["gl_token"]						:	NULL;
		$farmacia_caracter					=	isset($params["farmacia_caracter"])				?		$params["farmacia_caracter"]			:	NULL;
		$gl_razon_social					=	isset($params["gl_razon_social"])				?		$params["gl_razon_social"]				:	NULL;
		$gl_nombre_fantasia					=	isset($params["gl_nombre_fantasia"])			?		$params["gl_nombre_fantasia"]			:	NULL;
		$gl_rut_representante				=	isset($params["gl_rut_representante"])			?		$params["gl_rut_representante"]			:	NULL;
		$gl_nombres_representante			=	isset($params["gl_nombres_representante"])		?		$params["gl_nombres_representante"]		:	NULL;
		$gl_apellidos_representante			=	isset($params["gl_apellidos_representante"])	?		$params["gl_apellidos_representante"]	:	NULL;
		$gl_direccion						=	isset($params["gl_direccion"])					?		$params["gl_direccion"]					:	NULL;
		$id_comuna							=	isset($params["id_comuna"])						?		$params["id_comuna"]					:	NULL;
		$id_codigo_fono						=	isset($params["id_codigo_fono"])				?		$params["id_codigo_fono"]				:	NULL;
		$gl_fono							=	isset($params["gl_fono"])						?		$params["gl_fono"]						:	NULL;
		$codigoPais							=	"+56";
		$gl_codigo_fono						=	NULL;
		$gl_caracter						=	NULL;

		if(!empty($farmacia_caracter)){
			$gl_caracter					=	$this->_DAOFarmaciaCaracter->getByPK($farmacia_caracter)->gl_nombre;
		}
		
		if(!empty($id_codigo_fono)){
			$gl_codigo_fono				=	$this->_DAOCodigoRegion->getByPK($id_codigo_fono)->codigo;
		}
		
		$respuesta							=	array(
			"correcto"	=>	FALSE,
		);

		if(!empty($gl_token)){
			$empresa						=	$this->_DAOFarmacia->getByToken($gl_token);
			if(!empty($empresa)){
				$id_farmacia				=	$empresa->farmacia_id;
				$msg_cambio					=	array();
				$arr_update					=	array();

				$nombre_representante		=	trim($gl_nombres_representante." ".$gl_apellidos_representante);
				if(!empty($gl_razon_social)	&& $empresa->farmacia_razon_social	!=	$gl_razon_social){
					$arr_update["farmacia_razon_social"]			=	$gl_razon_social;
				}
				if(!empty($gl_nombre_fantasia)	&& $empresa->farmacia_nombre_fantasia	!=	$gl_nombre_fantasia){
					$arr_update["farmacia_nombre_fantasia"]			=	$gl_nombre_fantasia;
				}
				if(!empty($nombre_representante)	&& $empresa->farmacia_nombre_representante	!=	$nombre_representante){
					$arr_update["farmacia_nombre_representante"]	=	$nombre_representante;
				}
				if(!empty($gl_rut_representante) && \Validar::validarRut($gl_rut_representante)	&& $empresa->farmacia_rut_representante_midas	!=	$gl_rut_representante){
					$arr_update["farmacia_rut_representante_midas"]	=	$gl_rut_representante;
					$arr_update["farmacia_rut_representante"]		=	\Utils::formatoRut($gl_rut_representante);
				}
				if(!empty($gl_direccion) && $empresa->farmacia_direccion	!=	$gl_direccion){
					$arr_update["farmacia_direccion"]				=	$gl_direccion;
				}
				if(!empty($id_comuna) && $empresa->fk_comuna	!=	$id_comuna){
					$arr_update["fk_comuna"]						=	$id_comuna;
				}
				if(!empty($gl_codigo_fono) && $empresa->farmacia_fono_codigo	!=	$gl_codigo_fono){
					$arr_update["farmacia_fono_codigo"]				=	$gl_codigo_fono;
				}
				if(!empty($gl_fono) && $empresa->farmacia_fono	!=	$gl_fono){
					$arr_update["farmacia_telefono"]				=	$codigoPais.$gl_codigo_fono.$gl_fono;
					$arr_update["farmacia_fono"]					=	$gl_fono;
				}
				if(!empty($gl_caracter) && $empresa->farmacia_caracter	!=	$gl_caracter){
					$arr_update["farmacia_caracter"]				=	$gl_caracter;
					$arr_update["id_caracter"]						=	$farmacia_caracter;
				}

				if(!empty($arr_update)){
					$arr_update["fecha_actualizacion"]				=	date("Y-m-d H:i:s");
					$arr_update["fk_usuario_actualizacion"]			=	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"];

					$bo_actualiza									=	$this->_DAOFarmacia->update($arr_update,$id_farmacia);
					if($bo_actualiza){
						//	Agregar Comentarios e Historial
						$respuesta["correcto"]						=	TRUE;
					}else{
						$respuesta["msj_error"]						=	"Error al Actualizar Empresa Farmaceutica.";
					}
				}else{
					$respuesta["msj_error"]							=	"Sin cambios.";
				}
			}else{
				$respuesta["msj_error"]								=	"Empresa no encontrada. TOKEN: ".$gl_token;
			}
		}else{
			$respuesta["msj_error"]									=	"Falta parámetro requerido: gl_token.";
		}


		echo json_encode($respuesta);
	}

	private function editarEmpresaBD($params){
		$bo_actualiza					=	FALSE;
		$id_farmacia					=	NULL;
		$codigoPais						=	'+56';
		
		if(!empty($params)){
			if(isset($params["gl_token"]) && !empty($params["gl_token"])){
				$gl_token				=	$params["gl_token"];
				$farmacia				=	$this->_DAOFarmacia->getByToken($gl_token);

				if(!empty($farmacia)){
					$id_farmacia		=	$farmacia->farmacia_id;
					$codigo_localidad	=	isset($params["farmacia_fono_codigo"])	?	$params["farmacia_fono_codigo"]		:	"";
					$farmacia_fono		=	isset($params["farmacia_fono"])			?	$params["farmacia_fono"]			:	"";
					$fono				=	trim($codigo_localidad.$farmacia_fono);
					if(!empty($fono)){
						$fono			=	$codigoPais.$fono;
					}else{
						$fono			=	NULL;
					}
		
					$arr_update			=	array(
						"farmacia_telefono"						=>	$fono,
						"farmacia_estado"						=>	1,
						"farmacia_tipo"							=>	NULL,
						"farmacia_rut"							=>	NULL,
						"farmacia_rut_representante"			=>	NULL,
						"farmacia_nombre_representante_ti"		=>	NULL,
						"farmacia_telefono_representante_ti"	=>	NULL,
						"farmacia_fono_codigo_ti"				=>	NULL,
						"farmacia_fono_ti"						=>	NULL,
						"farmacia_correo_representante_ti"		=>	NULL,
						"farmacia_motivo_deshabilitacion"		=>	NULL,
					);
		
					$bo_actualiza		=	$this->_DAOFarmacia->update($arr_update,$id_farmacia);
				}
			}
		}

		return	$bo_actualiza;
	}

	private function validarFormularioEmpresa($params){
		$resp				=	'';

		if($params['farmacia_caracter']			==	''){
			$resp .= '	-	Caracter es Obligatorio.<br>';
		}
		if($params['gl_rut']					==	''){
			$resp .= '	-	RUT es Obligatorio.<br>';
		}
		if($params['gl_razon_social']			==	''){
			$resp .= '	-	Raz&oacute;n Social es Obligatorio.<br>';
		}
		if($params['gl_nombre_fantasia']		==	''){
			$resp .= '	-	Nombre de Fantasia es Obligatorio.<br>';
		}
		if($params['gl_rut_representante']		==	''){
			$resp .= '	-	RUT de Representante es Obligatorio.<br>';
		}
		if($params['gl_nombres_representante']	==	''){
			$resp .= '	-	Nombre de Representante es Obligatorio.<br>';
		}
		if($params['id_region']					==	'0'){
			$resp .= '	-	Regi&oacute;n es Obligatorio.<br>';
		}
		if($params['id_comuna']					==	'0'){
			$resp .= '	-	Comuna es Obligatorio.<br>';
		}
		if($params['gl_direccion']				==	''){
			$resp .= '	-	Direcci&oacute;n es Obligatorio.<br>';
		}

		if(empty($resp)){
			$bo_correcto	=	TRUE;
		}

		$respuesta			=	array(
			"correcto"	=>	$bo_correcto,
			"mensaje"	=>	$resp,
		);

		return	$respuesta;
	}

	public function cambiarEstado(){
		$this->session->isValidate();
		
		$params									=	$this->request->getParametros();
		$gl_token								=	isset($params["gl_token"])	?	$params["gl_token"]		:	NULL;
		$bo_estado								=	isset($params["bo_estado"])	?	$params["bo_estado"]	:	NULL;
		$respuesta								=	array(
			"correcto"	=>	FALSE,
		);

		if(!empty($gl_token)){
			$farmacia							=	$this->_DAOFarmacia->getByToken($gl_token);
			if(!empty($farmacia)){
				$id_farmacia					=	$farmacia->farmacia_id;
				//	Deshabilita Empresa
				if($bo_estado){
					$arr_establecimientos		=	$this->_DAOLocal->getByEmpresa($id_farmacia,TRUE);
					if(empty($arr_establecimientos)){
						$arr_updt					=	array(
							"farmacia_estado"			=>	0,
							"fecha_actualizacion"		=>	date("Y-m-d H:i:s"),
							"fk_usuario_actualizacion"	=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"]
						);
						$bo_actualiza				=	$this->_DAOFarmacia->update($arr_updt,$id_farmacia);
						if($bo_actualiza){
							$respuesta["correcto"]	=	TRUE;
							$respuesta["mensaje"]	=	"Empresa <b>".$farmacia->farmacia_razon_social."</b> ha sido <b>Deshabilitada</b> Exitosamente.";
						}else{
							$respuesta["msj_error"]	=	"Error al actualizar Farmacia - Deshabilitar.";
						}
					}else{
						$respuesta["mensaje"]	=	"Empresa <b>".$farmacia->farmacia_razon_social."</b> no puede ser Deshabilitada, dado que existen Locales asociados a esta Empresa.";
					}
				}
				//	Habilita Empresa
				else{
					$arr_updt					=	array(
						"farmacia_estado"			=>	1,
						"fecha_actualizacion"		=>	date("Y-m-d H:i:s"),
						"fk_usuario_actualizacion"	=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"]
					);
					$bo_actualiza				=	$this->_DAOFarmacia->update($arr_updt,$id_farmacia);
					if($bo_actualiza){
						$respuesta["correcto"]	=	TRUE;
						$respuesta["mensaje"]	=	"Empresa <b>".$farmacia->farmacia_razon_social."</b> ha sido <b>Habilitada</b> Exitosamente.";
					}else{
						$respuesta["msj_error"]	=	"Error al actualizar Farmacia - Habilitar.";
					}
				}
			}else{
				$respuesta["msj_error"]			=	"Farmacia no encontrada. Token:	".$gl_token;
			}
		}else{
			$respuesta["msj_error"]				=	"Falta Parámetro requerido:	Token.";
		}

		echo	json_encode($respuesta);
	}

	/**
	 * Función para generar el token único por cada farmacia existente
	*/
	public function regularizarFarmacia(){

		$arr_farmacias			=	$this->_DAOFarmacia->getListadoRegularizacion();

		foreach ($arr_farmacias as $farmacia) {
			$rut				=	$farmacia->farmacia_rut_midas;
			$razon_social		=	$farmacia->farmacia_razon_social;
			$id_farmacia		=	$farmacia->farmacia_id;
			$gl_token			=	\Seguridad::generaTokenEmpresa($rut,$razon_social);
			
			$arr_update			=	array(
				"gl_token"	=>	$gl_token
			);
	
			$bo_actualiza		=	$this->_DAOFarmacia->update($arr_update,$id_farmacia);

			if($bo_actualiza){
				echo '<pre>' . var_export($rut."	->	Actualizada", true) . '</pre>';
			}else{
				echo '<pre>' . var_export($rut."	->	Error", true) . '</pre>';
			}
		}
	}

	/**
	 * Función para regularizar el id de Carácter Farmacia
	*/
	public function regularizarCaracterFarmacia(){

		$arr_farmacias				=	$this->_DAOFarmacia->getListadoRegularizacionCaracter();
		$arr_caracter				=	Utils::stdToArray($this->_DAOFarmaciaCaracter->getLista());

		foreach ($arr_caracter as &$value) {
			$value["gl_nombre"]		=	mb_strtolower($value["gl_nombre"]);
		}

		foreach ($arr_farmacias as $farmacia) {
			$id_caracter			=	NULL;
			$gl_caracter			=	$farmacia->farmacia_caracter;
			$id_farmacia			=	$farmacia->farmacia_id;
	
			if(!empty($gl_caracter)){
				$idxCaracter		=	array_search(mb_strtolower($gl_caracter), (array_column($arr_caracter,'gl_nombre')));
				if(is_int($idxCaracter)){
					$id_caracter	=	$arr_caracter[$idxCaracter]["id_caracter"];
				}
			}

			if(!empty($id_caracter)){
				$arr_update			=	array(
					"id_caracter"	=>	$id_caracter
				);
		
				$bo_actualiza		=	$this->_DAOFarmacia->update($arr_update,$id_farmacia);
	
				if($bo_actualiza){
					echo '<pre>' . var_export($id_farmacia."	->	Actualizada", true) . '</pre>';
				}else{
					echo '<pre>' . var_export($id_farmacia."	->	Error", true) . '</pre>';
				}
			}

		}
	}

	public function listaSelect2(){
		$params				=	$this->request->getParametrosSelect2();
		$busc				=	$params["q"];
		$result				=	array();
		$arr				=	array();
		if(isset($busc) && !empty($busc)){
			$result			=	$this->_DAOFarmacia->getListSelect($busc);
			if(count($result)	>	0){
				foreach ($result as $item) {
					$arr[]	=	$item;
				}
			}
			echo json_encode($arr);
		}
	}
}
