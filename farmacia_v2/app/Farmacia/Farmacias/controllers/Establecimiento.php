<?php
namespace App\Farmacia\Farmacias;

use Seguridad;
use Utils;

class Establecimiento extends \pan\Kore\Controller {
	
	private	$_DAORegion;
	private	$_DAOComuna;
	private	$_DAOLocalidad;
	private	$_DAOCodigoRegion;
	private	$_DAOFarmacia;
	private	$_DAOFarmaciaCaracter;
	private	$_DAOLocal;
	private	$_DAOLocalClasificacion;
	private	$_DAOMaestroEstablecimiento;
	private	$_DAOLocalRecetarioTipo;
	private	$_DAOLocalRecetarioDetalle;
	private	$_DAOLocalHorario;
	private	$_DAOLocalTipo;
	private	$_DAOMotivoDeshabilitar;
	private	$_DAOLocalEstado;
	private	$_DAOLocalFuncionamiento;
	private	$_DAOLocalHistorial;
	private	$_DAOLocalHistorialTipo;
	private	$_DAOTurnoDetalle;
	private	$_DAOLocalEstadoTurno;

	public function __construct(){
		parent::__construct();
		$this->session->isValidate();

		$this->_DAORegion					=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOComuna					=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOLocalidad				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionLocalidad;
		
		$this->_DAOCodigoRegion				=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;

		$this->_DAOFarmacia					=	new \App\Farmacias\Farmacia\Entities\DAOFarmacia;
		$this->_DAOFarmaciaCaracter			=	new \App\Farmacias\Farmacia\Entities\DAOFarmaciaCaracter;
		$this->_DAOLocalClasificacion		=	new \App\Farmacias\Farmacia\Entities\DAOLocalClasificacion;
		$this->_DAOLocalRecetarioTipo		=	new \App\Farmacias\Farmacia\Entities\DAOLocalRecetarioTipo;
		$this->_DAOLocalRecetarioDetalle	=	new \App\Farmacias\Farmacia\Entities\DAOLocalRecetarioDetalle;
		$this->_DAOLocalHorario				=	new \App\Farmacias\Farmacia\Entities\DAOLocalHorario;
		
		$this->_DAOLocal					=	new \App\Farmacias\Farmacia\Entities\DAOLocal;
		$this->_DAOLocalEstado				=	new \App\Farmacias\Farmacia\Entities\DAOLocalEstado;
		$this->_DAOLocalTipo				=	new \App\Farmacias\Farmacia\Entities\DAOLocalTipo;
		$this->_DAOMotivoDeshabilitar		=	new \App\Farmacias\Farmacia\Entities\DAOMotivoDeshabilitar;
		$this->_DAOLocalFuncionamiento		=	new \App\Farmacias\Farmacia\Entities\DAOLocalFuncionamiento;
		$this->_DAOLocalHistorial			=	new \App\Farmacias\Farmacia\Entities\DAOLocalHistorial;
		$this->_DAOLocalHistorialTipo		=	new \App\Farmacias\Farmacia\Entities\DAOLocalHistorialTipo;
		$this->_DAOLocalEstadoTurno			=	new \App\Farmacias\Farmacia\Entities\DAOLocalEstadoTurno;
		
		$this->_DAOTurnoDetalle				=	new \App\Farmacia\Turnos\Entities\DAOTurnoDetalle;
		
		/*	Borrar	*/
		$this->_DAOMaestroEstablecimiento	=	new \App\Farmacia\Maestro\Entities\DAOMaestroEstablecimiento();

	}

	public function index(){
		$this->session->isValidate();
		\Permisos::validarRol(\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_ENCARGADO_REGIONAL);
		$arr_regiones_usuario				=	array();
		$roles								=	$_SESSION[\Constantes::SESSION_BASE]["arrRoles"];
		$bo_nacional						=	FALSE;
		$bo_rci								=	FALSE;
		$arr_roles_farmacia					=	array(
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_ENCARGADO_REGIONAL,
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_ENCARGADO_TERRITORIAL,
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_COORDINADOR_FARMACIA_NACIONAL,
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_COORDINADOR_FARMACIA_REGIONAL,
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_SECRETARIA_REGIONAL,
		);
		foreach ($roles as	$rol) {
			if(in_array($rol->mur_fk_rol,$arr_roles_farmacia)){
				$arr_regiones_usuario[]		=	$rol->id_region_midas;
			}
			if($rol->bo_nacional){
				$bo_nacional				=	TRUE;
			}elseif($rol->mur_fk_rol	==	\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_ENCARGADO_REGIONAL){
				$bo_rci						=	TRUE;
			}
		}
		// echo '<pre>' . var_export($_SESSION[\Constantes::SESSION_BASE], true) . '</pre>';die;

		if(!empty($arr_regiones_usuario) && !$bo_nacional){
			$arrRegion						=	$this->_DAORegion->getListaIn($arr_regiones_usuario);
		}else{
			$arrRegion						=	$this->_DAORegion->getLista();
		}


		$arrTipoEstablecimiento				=	$this->_DAOMaestroEstablecimiento->obtenerTiposEstablecimiento();
		$arrComuna							=	$this->_DAOComuna->getLista();

		$this->view->set('arrTipoEstablecimiento',	$arrTipoEstablecimiento);
		$this->view->set('bo_rci',					$bo_rci);
		$this->view->set('arrRegion',				$arrRegion);
		$this->view->set('arrComuna',				$arrComuna);
		$this->view->set('contenido',				$this->view->fetchIt('establecimiento/establecimiento'));
		
		$this->view->addJS('maestro_establecimiento.js');
		$this->view->addJS('establecimiento.js');
		$this->view->addJS('regiones.js',			'pub/js/helpers');
		$this->view->addJS('jq_scheduler.js',			'pub/js/helpers');

		$this->view->addJS('setTimeout(() => {$("#id_region").trigger("change")}, 1500);');
		$this->view->render();
	}

	public function editar($gl_token){
		
		$arrRegion						=	$this->_DAORegion->getLista();
		$arrComuna						=	$this->_DAOComuna->getLista();
		$arr_localidad					=	$this->_DAOLocalidad->getLista(1);
		$arrCodfono						=	$this->_DAOCodigoRegion->getByParams();
		$arr_clasificacion				=	$this->_DAOLocalClasificacion->getLista(1);
		$arr_recetario_tipo				=	$this->_DAOLocalRecetarioTipo->getLista(1);
		$arr_recetario_detalle			=	$this->_DAOLocalRecetarioDetalle->getLista(1);
		$arr_local_tipo					=	$this->_DAOLocalTipo->getLista(1);
		$arr_js							=	array(
			"bo_alopatica"		=>	FALSE,
			"bo_homeopatica"	=>	FALSE,
			"bo_movil"			=>	FALSE,
			"bo_urgencia"		=>	FALSE,
			"bo_receta_1A"		=>	FALSE,
			"bo_receta_1B"		=>	FALSE,
			"bo_receta_2A"		=>	FALSE,
			"bo_receta_2B"		=>	FALSE,
			"bo_receta_2C"		=>	FALSE,
			"bo_receta_3A"		=>	FALSE,
			"bo_receta_3B"		=>	FALSE,
			"bo_receta_3C"		=>	FALSE,
			"bo_receta_3D"		=>	FALSE,
			"bo_receta_4"		=>	FALSE,
			"bo_receta_5"		=>	FALSE,
		);
		$arr_horario					=	array(
			array(
				"gl_nombre"			=>	"Inicio Mañana",
				"id"				=>	"man_inicio",
			),
			array(
				"gl_nombre"			=>	"Fin Mañana",
				"id"				=>	"man_fin",
				"bo_no_continuado"	=>	TRUE,
			),
			array(
				"gl_nombre"			=>	"Inicio Tarde",
				"id"				=>	"tar_inicio",
				"bo_no_continuado"	=>	TRUE,
			),
			array(
				"gl_nombre"			=>	"Fin Tarde",
				"id"				=>	"tar_fin",
			),
		);

		if(!empty($gl_token)){
			$local							=	$this->_DAOLocal->getDetallesByToken($gl_token);
			if(!empty($local)){
				$arr_js["bo_continuado"]	=	$local->bo_continuado;
				$arr_js["bo_impide_turno"]	=	$local->local_impide_turnos;
				
				$arr_js["json_lunes"]		=	json_decode($local->json_lunes,TRUE);
				$arr_js["json_martes"]		=	json_decode($local->json_martes,TRUE);
				$arr_js["json_miercoles"]	=	json_decode($local->json_miercoles,TRUE);
				$arr_js["json_jueves"]		=	json_decode($local->json_jueves,TRUE);
				$arr_js["json_viernes"]		=	json_decode($local->json_viernes,TRUE);
				$arr_js["json_sabado"]		=	json_decode($local->json_sabado,TRUE);
				$arr_js["json_domingo"]		=	json_decode($local->json_domingo,TRUE);
				$arr_js["json_festivos"]	=	json_decode($local->json_festivos,TRUE);
				$arr_js["bo_alopatica"]		=	($local->local_tipo_alopatica	==	"1")	?	TRUE	:	FALSE;
				$arr_js["bo_homeopatica"]	=	($local->local_tipo_homeopatica	==	"1")	?	TRUE	:	FALSE;
				$arr_js["bo_movil"]			=	($local->local_tipo_movil		==	"1")	?	TRUE	:	FALSE;
				$arr_js["bo_urgencia"]		=	($local->local_tipo_urgencia	==	"1")	?	TRUE	:	FALSE;
				$rdet						=	!empty($local->local_recetario_fk_detalle)?explode(":",$local->local_recetario_fk_detalle):NULL;

				$arr_js["bo_receta_1A"]		=	isset($rdet[0])		?	$rdet[0]	:	FALSE;
				$arr_js["bo_receta_1B"]		=	isset($rdet[1])		?	$rdet[1]	:	FALSE;
				$arr_js["bo_receta_2A"]		=	isset($rdet[2])		?	$rdet[2]	:	FALSE;
				$arr_js["bo_receta_2B"]		=	isset($rdet[3])		?	$rdet[3]	:	FALSE;
				$arr_js["bo_receta_2C"]		=	isset($rdet[4])		?	$rdet[4]	:	FALSE;
				$arr_js["bo_receta_3A"]		=	isset($rdet[5])		?	$rdet[5]	:	FALSE;
				$arr_js["bo_receta_3B"]		=	isset($rdet[6])		?	$rdet[6]	:	FALSE;
				$arr_js["bo_receta_3C"]		=	isset($rdet[7])		?	$rdet[7]	:	FALSE;
				$arr_js["bo_receta_3D"]		=	isset($rdet[8])		?	$rdet[8]	:	FALSE;
				$arr_js["bo_receta_4"]		=	isset($rdet[9])		?	$rdet[9]	:	FALSE;
				$arr_js["bo_receta_5"]		=	isset($rdet[10])	?	$rdet[10]	:	FALSE;

				if($arr_js["bo_movil"]){
					$arr_js["recorrido"]	=	$local->json_recorrido;
				}

				$this->view->set('establecimiento',	$local);
			}
		}

		$this->cargarJsEditar($arr_js);
		
		$this->view->set('arrRegion',				$arrRegion);
		$this->view->set('arrComuna',				$arrComuna);
		$this->view->set('arr_localidad',			$arr_localidad);
		$this->view->set('arrCodfono',				$arrCodfono);
		$this->view->set('arr_clasificacion',		$arr_clasificacion);
		$this->view->set('arr_recetario_tipo',		$arr_recetario_tipo);
		$this->view->set('arr_recetario_detalle',	$arr_recetario_detalle);
		$this->view->set('arr_local_tipo',			$arr_local_tipo);
		$this->view->set('arr_horario',				$arr_horario);
		$this->view->set('bo_editar',				TRUE);
		
		$this->view->set('gl_latitud',				"-33.4569400");
		$this->view->set('gl_longitud',				"-70.6482700");
		
		$this->view->addJS('regiones.js',			'pub/js/helpers');
		$this->view->addJS('maestro_establecimiento.js');
		$this->view->addJS('setTimeout(() => {maestro_establecimiento.init();}, 500);');
		
		

		$this->view->set('contenido', $this->view->fetchIt('establecimiento/formulario'));
		$this->view->render();
	}

	public function cargarJsEditar($arr){
		/*	Clasificación	*/
		if($arr["bo_alopatica"]){
			$this->view->addJS('setTimeout(() => {$("#bo_alopatica").prop("checked",true)}, 1500);');
		}
		if($arr["bo_homeopatica"]){
			$this->view->addJS('setTimeout(() => {$("#bo_homeopatica").prop("checked",true)}, 1500);');
		}
		if($arr["bo_movil"]){
			$this->view->addJS('setTimeout(() => {$("#bo_movil").prop("checked",true).trigger("change")}, 1500);');
			if(isset($arr["recorrido"])){
				$this->view->addJS('setTimeout(() => {arr_recorrido	=	('.$arr["recorrido"].');setTimeout(() => {Recorrido.cargarGrilla();}, 500);}, 1500);');
			}
		}
		if($arr["bo_urgencia"]){
			$this->view->addJS('setTimeout(() => {$("#bo_urgencia").prop("checked",true)}, 1500);');
		}

		/*	Recetario	*/
		if($arr["bo_receta_1A"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_1A").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_1B"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_1B").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_2A"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_2A").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_2B"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_2B").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_2C"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_2C").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_3A"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_3A").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_3B"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_3B").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_3C"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_3C").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_3D"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_3D").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_4"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_4").prop("checked",true)}, 1500);');
		}
		if($arr["bo_receta_5"]){
			$this->view->addJS('setTimeout(() => {$("#bo_receta_5").prop("checked",true)}, 1500);');
		}

		/*	Horario	*/
		$js_horario			=	"";
		$js_cambio_horario	=	"";

		if($arr["bo_impide_turno"]){
			$this->view->addJS('setTimeout(() => {$("#bo_impide_turno").prop("checked",true)}, 1500);');
		}
		if(isset($arr["json_lunes"])){
			foreach ($arr["json_lunes"] as $idx => $lunes) {
				$js_horario	.=	'$("[name=\''.$idx.'\']").val("'.$lunes.'");';
			}
		}else{
			$js_horario	.=	'$("#btn_horario_lunes").trigger("click");';
		}

		if(isset($arr["json_martes"])){
			foreach ($arr["json_martes"] as $idx => $martes) {
				$js_horario	.=	'$("[name=\''.$idx.'\']").val("'.$martes.'");';
			}
		}else{
			$js_horario	.=	'$("#btn_horario_martes").trigger("click");';
		}

		if(isset($arr["json_miercoles"])){
			foreach ($arr["json_miercoles"] as $idx => $miercoles) {
				$js_horario	.=	'$("[name=\''.$idx.'\']").val("'.$miercoles.'");';
			}
		}else{
			$js_horario	.=	'$("#btn_horario_miercoles").trigger("click");';
		}

		if(isset($arr["json_jueves"])){
			foreach ($arr["json_jueves"] as $idx => $jueves) {
				$js_horario	.=	'$("[name=\''.$idx.'\']").val("'.$jueves.'");';
			}
		}else{
			$js_horario	.=	'$("#btn_horario_jueves").trigger("click");';
		}

		if(isset($arr["json_viernes"])){
			foreach ($arr["json_viernes"] as $idx => $viernes) {
				$js_horario	.=	'$("[name=\''.$idx.'\']").val("'.$viernes.'");';
			}
		}else{
			$js_horario	.=	'$("#btn_horario_viernes").trigger("click");';
		}

		if(isset($arr["json_sabado"])){
			foreach ($arr["json_sabado"] as $idx => $sabado) {
				$js_horario	.=	'$("[name=\''.$idx.'\']").val("'.$sabado.'");';
			}
		}else{
			$js_horario	.=	'$("#btn_horario_sabado").trigger("click");';
		}

		if(isset($arr["json_domingo"])){
			foreach ($arr["json_domingo"] as $idx => $domingo) {
				$js_horario	.=	'$("[name=\''.$idx.'\']").val("'.$domingo.'");';
			}
		}else{
			$js_horario	.=	'$("#btn_horario_domingo").trigger("click");';
		}

		if(isset($arr["json_festivos"])){
			foreach ($arr["json_festivos"] as $idx => $festivos) {
				$js_horario	.=	'$("[name=\''.$idx.'\']").val("'.$festivos.'");';
			}
		}else{
			$js_horario	.=	'$("#btn_horario_festivo").trigger("click");';
		}


		
		if(!$arr["bo_continuado"]){
			$js_cambio_horario		.=	'Horario.cambioHorario($("#btn_cambio_horario"));';
		}

		// echo '<pre>' . var_export($arr, true) . '</pre>';
		// echo '<pre>' . var_export($js_cambio_horario, true) . '</pre>';
		// echo '<pre>' . var_export($js_horario, true) . '</pre>';die;

		$this->view->addJS('setTimeout(() => {'.$js_cambio_horario.'setTimeout(() => {'.$js_horario.'}, 200);}, 1500);');
	}

	public function cargarGrilla(){
		$this->session->isValidate();
		$params					=	$this->request->getParametros();
		$respuesta				=	array(
			"correcto"	=>	TRUE
		);
		$establecimientos		=	$this->_DAOLocal->getListaByParams($params);

		if(!empty($establecimientos)){
			$this->view->set('establecimientos',	$establecimientos);
			$html				=	$this->view->fetchIt('establecimiento/grilla');
			$respuesta['html']	=	$html;
		}else{
			$respuesta["correcto"]	=	FALSE;
			$respuesta["mensaje"]	=	"Sin Resultados.";
		}

		echo json_encode($respuesta,	JSON_UNESCAPED_UNICODE);
	}

	/*	Creación - Edición	*/
	public function crearEstablecimiento(){
		$arrRegion						=	NULL;
		$arrComuna						=	$this->_DAOComuna->getLista();
		$arr_localidad					=	$this->_DAOLocalidad->getLista(1);
		$arrCodfono						=	$this->_DAOCodigoRegion->getByParams();
		$arr_clasificacion				=	$this->_DAOLocalClasificacion->getLista(1);
		$arr_recetario_tipo				=	$this->_DAOLocalRecetarioTipo->getLista(1);
		$arr_recetario_detalle			=	$this->_DAOLocalRecetarioDetalle->getLista(1);
		$arr_local_tipo					=	$this->_DAOLocalTipo->getLista(1);
		$arr_horario					=	array(
			array(
				"gl_nombre"			=>	"Inicio Mañana",
				"id"				=>	"man_inicio",
			),
			array(
				"gl_nombre"			=>	"Fin Mañana",
				"id"				=>	"man_fin",
				"bo_no_continuado"	=>	TRUE,
			),
			array(
				"gl_nombre"			=>	"Inicio Tarde",
				"id"				=>	"tar_inicio",
				"bo_no_continuado"	=>	TRUE,
			),
			array(
				"gl_nombre"			=>	"Fin Tarde",
				"id"				=>	"tar_fin",
			),
		);
		
		$arr_regiones_usuario				=	array();
		$roles								=	$_SESSION[\Constantes::SESSION_BASE]["arrRoles"];
		$bo_nacional						=	FALSE;
		$bo_rci								=	FALSE;
		$arr_roles_farmacia					=	array(
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_ENCARGADO_REGIONAL,
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_ENCARGADO_TERRITORIAL,
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_COORDINADOR_FARMACIA_NACIONAL,
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_COORDINADOR_FARMACIA_REGIONAL,
			\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_SECRETARIA_REGIONAL,
		);
		foreach ($roles as	$rol) {
			if(in_array($rol->mur_fk_rol,$arr_roles_farmacia)){
				$arr_regiones_usuario[]		=	$rol->id_region_midas;
			}
			if($rol->bo_nacional){
				$bo_nacional				=	TRUE;
			}elseif($rol->mur_fk_rol	==	\App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_ENCARGADO_REGIONAL){
				$bo_rci						=	TRUE;
			}
		}

		if(!empty($arr_regiones_usuario) && !$bo_nacional){
			$arrRegion						=	$this->_DAORegion->getListaIn($arr_regiones_usuario);
		}else{
			$arrRegion						=	$this->_DAORegion->getLista();
		}
		
		
		$this->view->set('bo_rci',					$bo_rci);
		$this->view->set('arrRegion',				$arrRegion);
		$this->view->set('arrComuna',				$arrComuna);
		$this->view->set('arr_localidad',			$arr_localidad);
		$this->view->set('arrCodfono',				$arrCodfono);
		$this->view->set('arr_clasificacion',		$arr_clasificacion);
		$this->view->set('arr_recetario_tipo',		$arr_recetario_tipo);
		$this->view->set('arr_recetario_detalle',	$arr_recetario_detalle);
		$this->view->set('arr_local_tipo',			$arr_local_tipo);
		$this->view->set('arr_horario',				$arr_horario);

		$this->view->set('gl_latitud',				"-33.4569400");
		$this->view->set('gl_longitud',				"-70.6482700");
		
		$this->view->addJS('regiones.js',			'pub/js/helpers');
		$this->view->addJS('maestro_establecimiento.js');
		$this->view->addJS('setTimeout(() => {maestro_establecimiento.init();}, 500);');
		

		$this->view->set('contenido', $this->view->fetchIt('establecimiento/formulario'));
		$this->view->render();
	}

	public function guardarNueva(){
		$this->session->isValidate();
		$params										=	$this->request->getParametros();
		$bo_edicion									=	FALSE;
		$gl_token									=	!empty($params["gl_token"])	?	$params["gl_token"]	:	NULL;
		$respuesta									=	array(
			"correcto"	=>	FALSE
		);
		
		if(!empty($gl_token)){
			$bo_edicion								=	TRUE;
		}

		$validacion									=	$this->validar($params,$bo_edicion);

		if($validacion["correcto"]){
			$id_local								=	NULL;
			$arr_local								=	$validacion["arr_local"];
			$gl_token								=	!empty($params["gl_token"])	?	$params["gl_token"]	:	NULL;
			if(!empty($gl_token)){
				$local								=	$this->_DAOLocal->getByToken($gl_token);
				if(!empty($local)){
					$id_local						=	$local->local_id;
					$bo_actualiza					=	$this->_DAOLocal->update($arr_local,$id_local);
					if(!$bo_actualiza){
						$respuesta["msj_error"]		=	"Error al Actualizar Local. Token: ".$gl_token;
					}
				}else{
					$respuesta["msj_error"]			=	"Local no encontrado con Token: ".$gl_token;
				}
			}else{
				$id_local							=	$this->_DAOLocal->create($arr_local);
			}

			if(($bo_edicion && !empty($id_local)) || (!$bo_edicion && !empty($id_local))){
				$id_horario							=	$this->guardarHorario($id_local,$params,$bo_edicion);
				if(!empty($id_horario)){
					$id_tipo_historial				=	\App\Farmacias\Farmacia\Entities\DAOLocalHistorialTipo::HISTORIAL_LOCAL_CREACION;
					$gl_descripcion_hist			=	"";
					
					if(!$bo_edicion){
						$arr_cod_midas				=	array(
							"gl_codigo_midas" 				=>	\Seguridad::establecimientoCodigo($id_local),
						);
						$this->_DAOLocal->update($arr_cod_midas,$id_local);

						$gl_descripcion_hist		=	"Se ha creado un Nuevo Establecimiento Farmacéutico de Empresa Farmacéutica <b>".$validacion["gl_farmacia"]."</b>.";
					}else{
						$id_tipo_historial			=	\App\Farmacias\Farmacia\Entities\DAOLocalHistorialTipo::HISTORIAL_LOCAL_EDICION;
						$gl_descripcion_hist		=	"El Establecimiento Farmacéutico RCI ".$params["nr_rci"]." ha sido editado.";
					}

					$arr_historial					=	array(
						"id_local"				=>	$id_local,
						"id_historial_tipo"		=>	$id_tipo_historial,
						"gl_descripcion"		=>	$gl_descripcion_hist,
						"id_usuario_crea"		=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"],
					);
					$this->_DAOLocalHistorial->create($arr_historial);

					$respuesta["cod_rci"]			=	$params["nr_rci"];
					$respuesta["bo_edicion"]		=	$bo_edicion;
					$respuesta["correcto"]			=	TRUE;
				}else{
					$respuesta["mensaje_error"]		=	"";
					$respuesta["msj_error"]			=	"Error al crear Horario";
				}
			}else{
				if($bo_edicion){
					$respuesta["msj_error"]			=	"Error al Editar Local. Params:<br/>"+json_encode($arr_local,JSON_PRETTY_PRINT);
				}else{
					$respuesta["msj_error"]			=	"Error al crear Local. Params:<br/>"+json_encode($arr_local,JSON_PRETTY_PRINT);
				}
			}

		}else{
			$respuesta["msj_error"]					=	$validacion["msj_error"];
			$respuesta["mensaje_error"]				=	$validacion["error"];
		}

		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

	public function validar($params,$bo_edita=FALSE){
		$error_interno							=	"Ha ocurrido un Error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.";
		$arr_error								=	array();
		$respuesta								=	array(
			"correcto"		=>	FALSE,
		);
		/*	variables insert	*/
		$id_farmacia							=	NULL;
		$farmacia								=	NULL;
		$gl_token								=	NULL;
		$local_recetario_tipo					=	(isset($params["id_recetario_tipo"]) && !empty($params["id_recetario_tipo"]))	?	$params["id_recetario_tipo"]	:	NULL;
		$gl_recetario							=	NULL;
		$ip_acceso								=	"0.0.0.0";

		if(!empty($local_recetario_tipo)){
			$gl_recetario						=	$this->_DAOLocalRecetarioTipo->getByPK($local_recetario_tipo)->gl_nombre;
		}

		if(!empty($params)){
			if(!empty($params["id_farmacia"])){
				$farmacia						=	$this->_DAOFarmacia->getByPK($params["id_farmacia"]);
				if(empty($farmacia)){
					$arr_error[]				=	"Empresa Farmacéutica";
				}else{
					$respuesta["gl_farmacia"]	=	$farmacia->farmacia_razon_social." (".$farmacia->farmacia_rut.")";
				}
			}else{
				$arr_error[]					=	"Empresa Farmacéutica";
			}
			if(empty($params["nr_rci"])){
				$arr_error[]					=	"Número RCI";
			}
			if(empty($params["factor_riesgo"])){
				$arr_error[]					=	"Factor de Riesgo";
			}
			if(empty($params["nr_resolucion_apertura"])){
				$arr_error[]					=	"Número Resolución de Apertura";
			}
			if(empty($params["fc_resolucion"])){
				$arr_error[]					=	"Fecha de Resolución";
			}
			if(empty($params["local_nombre"])){
				$arr_error[]					=	"Nombre del Establecimiento";
			}
			if(empty($params["local_numero"])){
				$arr_error[]					=	"Número del Establecimiento";
			}
			if(empty($params["id_tipo_establecimiento"])){
				$arr_error[]					=	"Tipo de Establecimiento";
			}
			if(empty($params["local_fono_codigo"]) && empty($params["local_fono"])){
				$arr_error[]					=	"Dirección";
			}else{
				$local_fono_codigo							=	$params["local_fono_codigo"];
				if(!empty($local_fono_codigo)){
					$params["gl_local_fono_codigo"]			=	$this->_DAOCodigoRegion->getByPK($local_fono_codigo)->codigo;
				}
			}

			if($params["bo_movil"] == "true"){
				if(empty($params["arr_recorrido"])){
					$arr_error[]				=	"Dirección Móvil";
				}else{
					$recorrido							=	json_decode($params["arr_recorrido"],TRUE);
					if(isset($recorrido[0])){
						$primer_recorrido					=	$recorrido[0];
						$params["id_region"]				=	isset($primer_recorrido["id_region"])		?	$primer_recorrido["id_region"]		:	NULL;
						$params["id_comuna"]				=	isset($primer_recorrido["id_comuna"])		?	$primer_recorrido["id_comuna"]		:	NULL;
						$params["id_localidad"]				=	isset($primer_recorrido["id_localidad"])	?	$primer_recorrido["id_localidad"]	:	NULL;
						$params["gl_direccion"]				=	isset($primer_recorrido["gl_direccion"])	?	$primer_recorrido["gl_direccion"]	:	NULL;
						$params["gl_latitud_direccion"]		=	isset($primer_recorrido["gl_latitud"])		?	$primer_recorrido["gl_latitud"]		:	NULL;
						$params["gl_longitud_direccion"]	=	isset($primer_recorrido["gl_longitud"])		?	$primer_recorrido["gl_longitud"]	:	NULL;
					}
				}
			}else{
				if(empty($params["id_region"])){
					$arr_error[]					=	"Región";
				}
				if(empty($params["id_comuna"])){
					$arr_error[]					=	"Comuna";
				}
				if(empty($params["id_localidad"])){
					$arr_error[]					=	"Localidad";
				}
				if(empty($params["gl_direccion"])){
					$arr_error[]					=	"Dirección";
				}
			}

			if(empty($arr_error)){
				$arr_recetario_detalle			=	array(
					($params["bo_receta_1A"]	== "true")	?	1	:	0,
					($params["bo_receta_1B"]	== "true")	?	1	:	0,
					($params["bo_receta_2A"]	== "true")	?	1	:	0,
					($params["bo_receta_2B"]	== "true")	?	1	:	0,
					($params["bo_receta_2C"]	== "true")	?	1	:	0,
					($params["bo_receta_3A"]	== "true")	?	1	:	0,
					($params["bo_receta_3B"]	== "true")	?	1	:	0,
					($params["bo_receta_3C"]	== "true")	?	1	:	0,
					($params["bo_receta_3D"]	== "true")	?	1	:	0,
					($params["bo_receta_4"]		== "true")	?	1	:	0,
					($params["bo_receta_5"]		== "true")	?	1	:	0,
				);

				$json_recetario_detalle			=	array(
					"bo_receta_1A"	=>	($params["bo_receta_1A"]	== "true")	?	1	:	0,
					"bo_receta_1B"	=>	($params["bo_receta_1B"]	== "true")	?	1	:	0,
					"bo_receta_2A"	=>	($params["bo_receta_2A"]	== "true")	?	1	:	0,
					"bo_receta_2B"	=>	($params["bo_receta_2B"]	== "true")	?	1	:	0,
					"bo_receta_2C"	=>	($params["bo_receta_2C"]	== "true")	?	1	:	0,
					"bo_receta_3A"	=>	($params["bo_receta_3A"]	== "true")	?	1	:	0,
					"bo_receta_3B"	=>	($params["bo_receta_3B"]	== "true")	?	1	:	0,
					"bo_receta_3C"	=>	($params["bo_receta_3C"]	== "true")	?	1	:	0,
					"bo_receta_3D"	=>	($params["bo_receta_3D"]	== "true")	?	1	:	0,
					"bo_receta_4"	=>	($params["bo_receta_4"]		== "true")	?	1	:	0,
					"bo_receta_5"	=>	($params["bo_receta_5"]		== "true")	?	1	:	0,
				);
				if(!$bo_edita){
					$gl_token						=	\Seguridad::generaTokenEstablecimiento($farmacia->framacia_id,$params["local_nombre"],$params["nr_rci"]);
				}else{
					$gl_token						=	$params["gl_token"];
				}

				$arr_local							=	array(
					"fk_farmacia"						=>	$params["id_farmacia"],
					"ordenamiento"						=>	NULL,
					"local_numero"						=>	$params["local_numero"],
					"local_nombre"						=>	$params["local_nombre"],
					"local_direccion"					=>	$params["gl_direccion"],
					"local_lat"							=>	$params["gl_latitud_direccion"],
					"local_lng"							=>	$params["gl_longitud_direccion"],
					"local_impide_turnos"				=>	($params["bo_impide_turno"]=="true")?1:0,
					"local_telefono"					=>	!empty($params["local_fono"]) ? "+56".trim($params["gl_local_fono_codigo"].$params["local_fono"]) : NULL,
					"local_fono_codigo"					=>	$params["gl_local_fono_codigo"],
					"local_fono"						=>	$params["local_fono"],
					"fk_localidad"						=>	$params["id_localidad"],
					"fk_region"							=>	$params["id_region"],
					"fk_comuna"							=>	$params["id_comuna"],
					"fk_local_tipo"						=>	$params["id_tipo_establecimiento"],
					"local_numero_resolucion"			=>	$params["nr_resolucion_apertura"],
					"local_fecha_resolucion"			=>	date("Y-m-d H:i:s",strtotime($params["fc_resolucion"])),
					"local_tipo_alopatica"				=>	($params["bo_alopatica"] == "true")?1:0,
					"local_tipo_homeopatica"			=>	($params["bo_homeopatica"] == "true")?1:0,
					"local_tipo_movil"					=>	($params["bo_movil"] == "true")?1:0,
					"local_tipo_urgencia"				=>	($params["bo_urgencia"] == "true")?1:0,
					"local_estado"						=>	1,
					"local_tipo_franquicia"				=>	($params["bo_franquicia"]=="true")?1:0,
					"local_recetario"					=>	!empty($gl_recetario)?1:0,
					"local_tiene_recetario"				=>	($params["bo_recetario_en_local"] == "true")?1:0,
					"local_recetario_tipo"				=>	(!empty($gl_recetario)	?	strtoupper($gl_recetario)	:	NULL),
					"id_recetario_tipo"					=>	$params["id_recetario_tipo"],
					"local_recetario_fk_detalle"		=>	implode(":",$arr_recetario_detalle),
					"json_recetario_detalle"			=>	json_encode($json_recetario_detalle, JSON_PRETTY_PRINT),
					"local_preparacion_solidos"			=>	0,
					"local_preparacion_liquidos"		=>	0,
					"local_preparacion_esteriles"		=>	0,
					"local_preparacion_cosmeticos"		=>	0,
					"local_preparacion_homeopaticos"	=>	0,

					/*	Adjuntar Resolucion	*/
					"resolucion_url"					=>	"",

					"id_region_midas"					=>	$params["id_region"],
					"id_comuna_midas"					=>	$params["id_comuna"],

					"json_recorrido"					=>	!empty($params["arr_recorrido"])?$params["arr_recorrido"]:NULL,
					"activa_mapa"						=>	($params["bo_ver_mapa"]=="true")?1:0,
					"factor_riesgo"						=>	$params["factor_riesgo"],
					"rakin_numero"						=>	$params["nr_rci"],
					"ip_cadena_acceso"					=>	$ip_acceso,
					"gl_token"							=>	$gl_token,

					/*	Crear CODIGO	*/
					// "gl_codigo_midas"					=>	$gl_codigo_midas,
				);
				
				if($bo_edita){
					$arr_local["fk_usuario_actualizacion"]	=	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"];
					$arr_local["local_fecha_edicion"]		=	date("Y-m-d H:i:s");
				}else{
					$arr_local["fk_usuario_creacion"]		=	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"];
					$arr_local["local_fecha_creacion"]		=	date("Y-m-d H:i:s");
				}

				$respuesta["correcto"]				=	TRUE;
				$respuesta["arr_local"]				=	$arr_local;
			}else{
				$html_error							=	"";
				foreach ($arr_error as $param) {
					$html_error						.=	"	- El campo <b>".$param."</b> es requerido.<br/>";
				}

				$respuesta["error"]					=	$html_error;
			}	
			

		}else{
			$respuesta["error"]					=	"Sin Parámetros";
			$respuesta["msj_error"]				=	$error_interno;
		}

		return	$respuesta;
	}

	public function guardarHorario($id_local,$params,$bo_edicion=FALSE){
		$bo_horario_continuado		=	isset($params["bo_horario_continuado"])	?	(($params["bo_horario_continuado"]=="1")?TRUE:FALSE)	:	FALSE;
		$dias						=	array("lunes","martes","miercoles","jueves","viernes","sabado","domingo","festivo");
		$arr						=	array();

		if($bo_edicion){
			$this->_DAOLocalHorario->deshabilitar($id_local);
		}

		foreach ($dias as	$dia) {
			if($params["bo_horario_".$dia]){
				$inicio_manana		=	$params[$dia."_man_inicio"];
				$fin_manana			=	(!$bo_horario_continuado)	?	$params[$dia."_man_fin"]	:	NULL;
				$inicio_tarde		=	(!$bo_horario_continuado)	?	$params[$dia."_tar_inicio"]	:	NULL;
				$fin_tarde			=	$params[$dia."_tar_fin"];
				$arr[$dia]			=	array(
					$dia."_man_inicio"	=>	$inicio_manana,
					$dia."_man_fin"		=>	$fin_manana,
					$dia."_tar_inicio"	=>	$inicio_tarde,
					$dia."_tar_fin"		=>	$fin_tarde,
				);

			}
		}
		
		$arr_insert					=	array(
			"id_local"			=>	$id_local,
			"bo_continuado"		=>	$bo_horario_continuado,
			"json_lunes"		=>	isset($arr["lunes"])		?	json_encode($arr["lunes"],		JSON_PRETTY_PRINT)	:	NULL,
			"json_martes"		=>	isset($arr["martes"])		?	json_encode($arr["martes"],		JSON_PRETTY_PRINT)	:	NULL,
			"json_miercoles"	=>	isset($arr["miercoles"])	?	json_encode($arr["miercoles"],	JSON_PRETTY_PRINT)	:	NULL,
			"json_jueves"		=>	isset($arr["jueves"])		?	json_encode($arr["jueves"],		JSON_PRETTY_PRINT)	:	NULL,
			"json_viernes"		=>	isset($arr["viernes"])		?	json_encode($arr["viernes"],	JSON_PRETTY_PRINT)	:	NULL,
			"json_sabado"		=>	isset($arr["sabado"])		?	json_encode($arr["sabado"],		JSON_PRETTY_PRINT)	:	NULL,
			"json_domingo"		=>	isset($arr["domingo"])		?	json_encode($arr["domingo"],	JSON_PRETTY_PRINT)	:	NULL,
			"json_festivos"		=>	isset($arr["festivo"])		?	json_encode($arr["festivo"],	JSON_PRETTY_PRINT)	:	NULL
		);

		$id_horario_local			=	$this->_DAOLocalHorario->create($arr_insert);
		return $id_horario_local;
	}

	public function ingresarRecorridoMapa(){
		$arrRegion					=	$this->_DAORegion->getLista();
		$this->view->set('arrRegion',	$arrRegion);
		$this->view->set('gl_latitud',	"-33.4569400");
		$this->view->set('gl_longitud',	"-70.6482700");


		$this->view->addJS('setTimeout(() => {iniciarMapa("mapa_recorrido","gl_latitud_recorrido","gl_longitud_recorrido","gl_direccion_recorrido");}, 1500);');

		$this->view->render('establecimiento/mapa/direccion');
	}

	/*	Estado	*/
	public function cambiar_estado($token){
		$vista								=	"";
		$arr_motivos						=	$this->_DAOMotivoDeshabilitar->getLista();

		if(!empty($token)){
			$local							=	$this->_DAOLocal->getDetallesByToken($token);
			$bo_habilitado					=	$local->local_estado;

			if(!$bo_habilitado){
				$vista						=	"habilitar";
				
				$this->view->set('local',		$local);
			}else{
				$vista						=	"inhabilitar";
				
				$this->view->set('arr_motivos',	$arr_motivos);
			}

			$this->view->set('token',			$token);
			$this->view->render('establecimiento/opciones/'	.	$vista);
		}else{
			echo "Ha ocurrido un error, si este persiste favor contactar con Mesa de Ayuda.";
			die;
		}
	}

	public function habilitar(){
		$params											=	$this->request->getParametros();
		$gl_token										=	isset($params["gl_token"])		?	$params["gl_token"]		:	NULL;
		$fc_habilita									=	isset($params["fc_habilita"])	?	$params["fc_habilita"]	:	NULL;
		$respuesta										=	array(
			"correcto"	=>	FALSE
		);
		if(!empty($gl_token)){
			if(!empty($fc_habilita)){
				$local									=	$this->_DAOLocal->getDetallesByToken($gl_token);
				if(!empty($local)){
					$id_local							=	$local->local_id;
					$fc_inicio							=	$local->fc_inicio_deshabilita_bd;
					$fc_termino							=	$local->fc_termino_deshabilita_bd;
					$bo_cron_habilita					=	FALSE;
					$_fc_habilita						=	date("d-m-Y",strtotime($fc_habilita));
					$arr_updt							=	array(
						"local_motivo_deshabilitacion"					=>	0,
						"fk_usuario_actualizacion"						=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"]
					);
					if($_fc_habilita	==	date("d-m-Y")){
						$arr_updt["local_estado"]						=	1;
						$arr_updt["fecha_cambio_estado"]				=	date("d-m-Y");
						$arr_updt["local_detalle_deshabilitacion"]		=	0;
					}else{
						$bo_cron_habilita				=	TRUE;
					}

					$bo_actualiza						=	$this->_DAOLocal->update($arr_updt,$id_local);

					if($bo_actualiza){
						$descr_historial				=	"Establecimiento ha sido Habilitado.";
						$msj_exito						=	"Establecimiento Habilitado exitosamente";
						$id_tipo_historial				=	\App\Farmacias\Farmacia\Entities\DAOLocalHistorialTipo::HISTORIAL_LOCAL_HABILITA;

						$this->_DAOLocalEstado->deshabilitarAnteriores($id_local);
						$arr_ins_estado					=	array(
							"fk_local"						=>	$id_local,
							"fc_inicio"						=>	$fc_inicio,
							"fc_termino"					=>	$_fc_habilita,
							"estado"						=>	1,
							"motivo"						=>	0,
							"detalle"						=>	NULL,
							"estado_cron_inhabilitar"		=>	0,
							"estado_cron_habilitar"			=>	$bo_cron_habilita,
							"fk_usuario"					=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"],
						);
						$id_local_estado				=	$this->_DAOLocalEstado->create($arr_ins_estado);
						if($id_local_estado > 0){
							if($bo_cron_habilita){
								$descr_historial		=	"Establecimiento se Habilitará el día "	.	$fc_habilita;
								$id_tipo_historial		=	\App\Farmacias\Farmacia\Entities\DAOLocalHistorialTipo::HISTORIAL_LOCAL_PROG_HABILITA;
								$msj_exito				=	"Establecimiento Programado para Habilitación exitosamente para el día "	.	$fc_habilita	.	".";
							}

							$arr_historial				=	array(
								"id_local"						=>	$id_local,
								"id_historial_tipo"				=>	$id_tipo_historial,
								"gl_descripcion"				=>	$descr_historial,
								"id_usuario_crea"				=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"],
							);
							$this->_DAOLocalHistorial->create($arr_historial);
	
							$respuesta["mensaje_exito"]	=	$msj_exito;
							$respuesta["correcto"]		=	TRUE;
						}else{
							$respuesta["msj_error"]		=	"Error al Actualizar Local";
						}
					}else{
						$respuesta["msj_error"]			=	"Error al Actualizar Local";
					}
				}else{
					$respuesta["msj_error"]				=	"Establecimiento no Encontrado. Token: "	.	$gl_token;
				}
			}else{
				$respuesta["msj_error"]					=	"Falta parámetro Fecha Habilita";
			}
		}else{
			$respuesta["msj_error"]						=	"Falta parámetro Token";
		}
		
		echo	json_encode($respuesta,	JSON_UNESCAPED_UNICODE);
	}

	public function deshabilitar(){
		$this->session->isValidate();
		$params			=	$this->request->getParametros();
		$gl_token		=	isset($params["gl_token"])		?	$params["gl_token"]		:	NULL;
		$id_motivo		=	isset($params["id_motivo"])		?	$params["id_motivo"]	:	NULL;
		$fc_inicio		=	isset($params["fc_inicio"])		?	$params["fc_inicio"]	:	NULL;
		$fc_termino		=	isset($params["fc_termino"])	?	$params["fc_termino"]	:	NULL;
		$gl_motivo		=	isset($params["gl_motivo"])		?	$params["gl_motivo"]	:	NULL;
		
		$respuesta		=	array(
			"correcto"		=>	FALSE,
		);

		if(!empty($gl_token)){
			$local											=	$this->_DAOLocal->getDetallesByToken($gl_token);
			if(!empty($local)){
				if(!empty($id_motivo)){
					$id_local								=	$local->local_id;
					$_fc_inicio								=	date("d-m-Y",strtotime($fc_inicio));
					$_fc_termino							=	!empty($fc_termino)	?	date("d-m-Y",strtotime($fc_termino))	:	NULL;
					$bo_cron_habilita						=	FALSE;
					$bo_cron_inhabilita						=	FALSE;

					$lst_existe_turnos						=	$this->_DAOTurnoDetalle->getTurnosLocal($id_local,$_fc_inicio);
					if(!empty($lst_existe_turnos)){
						$id_turno							=	$lst_existe_turnos->row_0->fk_turno;
						$exite_local_turno					=	 $this->_DAOLocalEstadoTurno->getLocalEstado($id_turno,0);

						if(!empty($exite_local_turno)){
							$respuesta["msj_error"]			=	"Establecimiento no puede ser deshabilitado mientras no se edite el turno.";
							$respuesta["mensaje"]			=	"Establecimiento no puede ser deshabilitado mientras no se edite el turno.";
							echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
							die;
						}else{
							$arr_ins_estado_turno			=	array(
								"fk_local"				=>	$id_local,
            					"fk_turno"				=>	$id_turno,
            					"estado"				=>	0,
            					"fecha_cambio_estado"	=>	$_fc_inicio,
							);
							$id_estado_turno				=	$this->_DAOLocalEstadoTurno->create($arr_ins_estado_turno);
							if(empty($id_estado_turno)){
								$respuesta["msj_error"]		=	"Error al guardar local estado turno.";
								$respuesta["mensaje"]		=	"Ha ocurrido un error, si este persiste favor contactar con Mesa de Ayuda.";
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die;
							}
						}
					}

					if(!empty($_fc_termino)){
						$bo_cron_habilita	= 1;
					}

					$arr_updt								=	array(
						"local_motivo_deshabilitacion"					=>	$id_motivo,
						"fk_usuario_actualizacion"						=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"]
					);
					if($_fc_inicio	==	date("d-m-Y")){
						$arr_updt["local_estado"]						=	0;
						$arr_updt["fecha_cambio_estado"]				=	date("d-m-Y");
						$arr_updt["local_detalle_deshabilitacion"]		=	$gl_motivo;
					}else{
						$bo_cron_inhabilita					=	TRUE;
					}

					$bo_actualiza							=	$this->_DAOLocal->update($arr_updt,$id_local);

					if($bo_actualiza){
						$descr_historial					=	"Establecimiento ha sido Deshabilitado.".(!empty($gl_motivo) ? (" Motivo : ".$gl_motivo)	:	"");
						$msj_exito							=	"Establecimiento Deshabilitado exitosamente";
						$id_tipo_historial					=	\App\Farmacias\Farmacia\Entities\DAOLocalHistorialTipo::HISTORIAL_LOCAL_DESHABILITA;

						$this->_DAOLocalEstado->deshabilitarAnteriores($id_local,TRUE);
						$arr_ins_estado						=	array(
							"fk_local"							=>	$id_local,
							"fc_inicio"							=>	$_fc_inicio,
							"fc_termino"						=>	$_fc_termino,
							"estado"							=>	0,
							"motivo"							=>	$id_motivo,
							"detalle"							=>	$gl_motivo,
							"estado_cron_inhabilitar"			=>	$bo_cron_habilita,
							"estado_cron_habilitar"				=>	$bo_cron_inhabilita,
							"fk_usuario"						=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"],
						);
						$id_local_estado					=	$this->_DAOLocalEstado->create($arr_ins_estado);
						if($id_local_estado > 0){
							if($bo_cron_inhabilita){
								$descr_historial			=	"Establecimiento se Deshabilitará el día "	.	$fc_inicio.(!empty($gl_motivo) ? (". Motivo : ".$gl_motivo)	:	".");;
								$msj_exito					=	"Establecimiento Programado para Deshabilitación para el día "	.	$fc_inicio	.	".";
								$id_tipo_historial			=	\App\Farmacias\Farmacia\Entities\DAOLocalHistorialTipo::HISTORIAL_LOCAL_PROG_DESHABILITA;
							}
							
							$arr_historial					=	array(
								"id_local"						=>	$id_local,
								"id_historial_tipo"				=>	$id_tipo_historial,
								"gl_descripcion"				=>	$descr_historial,
								"id_usuario_crea"				=>	$_SESSION[\Constantes::SESSION_BASE]["id_usuario"],
							);
							$this->_DAOLocalHistorial->create($arr_historial);
	
							$respuesta["mensaje_exito"]		=	$msj_exito;
							$respuesta["correcto"]			=	TRUE;
						}else{
							$respuesta["msj_error"]			=	"Falta parámetro requerido : id Motivo.";
						}
					}
				}else{
					$respuesta["msj_error"]					=	"Falta parámetro requerido : id Motivo.";
				}
			}else{
				$respuesta["msj_error"]						=	"Local no encontrado. Token : ". $gl_token;
			}
		}else{
			$respuesta["msj_error"]							=	"Falta parámetro requerido : Token.";
		}

		echo json_encode($respuesta);
	}

	//En desuso
	public function cambiarEstado(){
		$this->session->isValidate();
		$mensaje		=	"Hubo un Problema al intentar cambiar el estado, Intentelo nuevamente o comuniquese con la mesa de ayuda.";
		$params			=	$this->request->getParametros();
		$resultado		=	false;

		$resultado		=	$this->DAOMaestroEstablecimiento->cambiarEstado($params);
		// $resultado		=	true;

		if($resultado){
			//insert en las demas tablas del proceso
			$mensaje = "El estado se Modifico Correctamente";
		}else{
			$mensaje = "Ha ocurrido un error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.";
		}

		$json["resultado"]	=	$resultado;
		$json["mensaje"]	=	$mensaje;

		echo json_encode($json);
	}

	/*	Ver Establecimiento tipo Bitácora	*/
	public function ver($token){
		if(!empty($token)){
			$local							=	$this->_DAOLocal->getDetallesByToken($token);
			$arr_recorrido					=	NULL;
			$arr_historial					=	NULL;
			
			if(!empty($local)){
				$local->bo_impide_turno		=	$local->local_impide_turnos;
				
				/*	Horarios	*/
				$local->json_lunes			=	json_decode($local->json_lunes,TRUE);
				$local->json_martes			=	json_decode($local->json_martes,TRUE);
				$local->json_miercoles		=	json_decode($local->json_miercoles,TRUE);
				$local->json_jueves			=	json_decode($local->json_jueves,TRUE);
				$local->json_viernes		=	json_decode($local->json_viernes,TRUE);
				$local->json_sabado			=	json_decode($local->json_sabado,TRUE);
				$local->json_domingo		=	json_decode($local->json_domingo,TRUE);
				$local->json_festivos		=	json_decode($local->json_festivos,TRUE);
				
				/*	Clasificación	*/
				$arr_clasificacion			=	array();

				if($local->local_tipo_alopatica		==	"1"){
					$arr_clasificacion[]	=	"Alopática";
				}
				if($local->local_tipo_homeopatica	==	"1"){
					$arr_clasificacion[]	=	"Homeopatica";
				}
				if($local->local_tipo_movil			==	"1"){
					$arr_clasificacion[]	=	"Móvil";
					$arr_recorrido			=	$local->json_recorrido;
				}
				if($local->local_tipo_urgencia		==	"1"){
					$arr_clasificacion[]	=	"Urgencia";
				}

				$local->clasificaciones		=	implode(' - ',$arr_clasificacion);
				
				/*	Recetario	*/
				$rdet						=	!empty($local->local_recetario_fk_detalle)?explode(":",$local->local_recetario_fk_detalle):NULL;

				$arr_recetario				=	array();
				$local->bo_receta_1A		=	isset($rdet[0])		?	$rdet[0]	:	FALSE;
				$local->bo_receta_1B		=	isset($rdet[1])		?	$rdet[1]	:	FALSE;
				$local->bo_receta_2A		=	isset($rdet[2])		?	$rdet[2]	:	FALSE;
				$local->bo_receta_2B		=	isset($rdet[3])		?	$rdet[3]	:	FALSE;
				$local->bo_receta_2C		=	isset($rdet[4])		?	$rdet[4]	:	FALSE;
				$local->bo_receta_3A		=	isset($rdet[5])		?	$rdet[5]	:	FALSE;
				$local->bo_receta_3B		=	isset($rdet[6])		?	$rdet[6]	:	FALSE;
				$local->bo_receta_3C		=	isset($rdet[7])		?	$rdet[7]	:	FALSE;
				$local->bo_receta_3D		=	isset($rdet[8])		?	$rdet[8]	:	FALSE;
				$local->bo_receta_4			=	isset($rdet[9])		?	$rdet[9]	:	FALSE;
				$local->bo_receta_5			=	isset($rdet[10])	?	$rdet[10]	:	FALSE;

				if($local->bo_receta_1A){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Papelillos U Otros Envases De Polvo",
						"numero"	=>	"1A",
					);
				}
				if($local->bo_receta_1B){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Capsulas Duras",
						"numero"	=>	"1B",
					);
				}
				if($local->bo_receta_2A){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Jarabes, Soluciones Y Suspensiones",
						"numero"	=>	"2A",
					);
				}
				if($local->bo_receta_2B){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Ovulos, Supositorios",
						"numero"	=>	"2B",
					);
				}
				if($local->bo_receta_2C){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Cremas, Geles, Pastas",
						"numero"	=>	"2C",
					);
				}
				if($local->bo_receta_3A){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Preparados Esteriles No Inyectables",
						"numero"	=>	"3A",
					);
				}
				if($local->bo_receta_3B){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Esteriles Inyectables",
						"numero"	=>	"3B",
					);
				}
				if($local->bo_receta_3C){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Nutriciones Parenterales",
						"numero"	=>	"3C",
					);
				}
				if($local->bo_receta_3D){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Citostaticos",
						"numero"	=>	"3D",
					);
				}
				if($local->bo_receta_4){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Preparados Cosmeticos Magistrales (excepto Protectores Solares)",
						"numero"	=>	"4",
					);
				}
				if($local->bo_receta_5){
					$arr_recetario[]		=	array(
						"nombre"	=>	"Preparados Homeopaticos",
						"numero"	=>	"5",
					);
				}

				$local->arr_recetario		=	$arr_recetario;

				$arr_historial				=	$this->_DAOLocalHistorial->getByLocal($local->local_id);
			}

			$this->view->set('local',			$local);
			$this->view->set('arr_historial',	$arr_historial);
			$this->view->set('bitacora',		TRUE);

			$this->view->addJS('setTimeout(() => {$(".accion").hide();iniciarMapa();}, 1500);');

			if(!empty($arr_recorrido)){
				$this->view->addJS('setTimeout(() => {arr_recorrido	=	('.$arr_recorrido.');setTimeout(() => {Recorrido.cargarGrilla();$(".accion").hide();}, 500);}, 1500);');
			}

			// $this->view->addJS('setTimeout(() => {colapsarDivs("cabecera_general");colapsarDivs("cabecera-direccion");colapsarDivs("cabecera-recetario");}, 1500);');

			// echo '<pre>' . var_export($local, true) . '</pre>';die;
			
			$this->view->render('establecimiento/bitacora/ver');
		}else{
			echo '<pre>' . var_export("Ha ocurrido un Error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.", true) . '</pre>';
		}
	}

	/*	Horario	*/
	// function getAgendaQF($fk_local,$fk_usuario=0){
	// 	#$this->output->enable_profiler(true);
	//     $this->db->select('*');
	//     $this->db->join('local', 'rs.fk_local=local.local_id');
	//     $this->db->join('maestro_usuario', 'rs.fk_quimico=maestro_usuario.mu_id');
	//     $this->db->join('maestro_usuario_rol', 'mur_fk_usuario=maestro_usuario.mu_id');
	//     $this->db->where('rs.fk_local', $fk_local);
	// 	if($fk_usuario !=0){
	//     $this->db->where('rs.fk_quimico', $fk_usuario);
	// 	}
	//     $this->db->where('maestro_usuario_rol.fk_local', $fk_local);
	// 	$this->db->where('mur_estado_activado', 1);
	// 	$this->db->where('mur_fk_rol', 7);
	//     $this->db->where('rs.rotacion_hora_inicio !=', '00:00:00');
	//     $this->db->where('rs.rotacion_hora_termino !=', '00:00:00');
	//     $this->db->order_by('rs.rotacion_hora_inicio DESC');
	//     $this->db->order_by('ejercicio_id');
	//     $this->db->group_by('ejercicio_id');
	// 	$q = $this->db->get('rotacion_qf rs');
	//     $r = $q->result();

	//     return $r;
	// }
	

	public function verHorario($token){
		$msj_error							=	"Ha ocurrido un Error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.";


		if(!empty($token)){
			$local							=	$this->_DAOLocal->getDetallesByToken($token);
			if(!empty($local)){
				$horario					=	$this->_DAOLocalHorario->getByLocal($local->local_id);
				$arr_dias					=	["lunes","martes","miercoles","jueves","viernes","sabado","domingo","festivos"];
				if(!empty($horario)){
					$bo_continuado			=	$horario->bo_continuado;
					$horario				=	json_decode(json_encode($horario),TRUE);
					$arr_horario			=	array();

					foreach ($arr_dias as $idx => $dia) {
						$_arr							=	(!empty($horario["json_".$dia])) ? json_decode($horario["json_".$dia],TRUE) : NULL;
						if($dia == "festivos"){
							$dia						=	"festivo";
						}
						if(!empty($_arr)){
							$manana_inicio				=	$_arr[$dia."_man_inicio"];
							$manana_fin					=	$_arr[$dia."_man_fin"];
							$tarde_inicio				=	$_arr[$dia."_tar_inicio"];
							$tarde_fin					=	$_arr[$dia."_tar_fin"];
							if($bo_continuado){
								$arr_horario[$idx][]	=	array(
									"inicio"	=>	$manana_inicio,
									"fin"		=>	$tarde_fin,
								);
							}else{
								$arr_horario[$idx][]	=	array(
									"inicio"	=>	$manana_inicio,
									"fin"		=>	$manana_fin,
								);
								$arr_horario[$idx][]	=	array(
									"inicio"	=>	$tarde_inicio,
									"fin"		=>	$tarde_fin,
								);
							}
						}else{
							$arr_horario[$idx]		=	NULL;
						}
					}
					$this->view->addJS('setTimeout(() => {Horarios.test()}, 1000);');
					$json_horario			=	addslashes(json_encode($arr_horario,JSON_UNESCAPED_UNICODE));
					$this->view->addJS('setTimeout(() => {Horarios.cargar("'.$json_horario.'",1)}, 2000);');
				}

			}
		}



		$this->view->render('establecimiento/opciones/horario');
	}

	/*	Regularizaciones	*/
	public function regularizarHorario($limit = 2500){
		ini_set('max_execution_time', 0);
		// $limit						=	2500;
		$locales					=	$this->_DAOLocal->getLimit($limit);

		foreach ($locales as $local) {
			$id_local				=	$local->local_id;
			$dias					=	$this->_DAOLocalFuncionamiento->getByLocal($id_local);
			$arr					=	array();
			$bo_continuado			=	TRUE;

			foreach ($dias as $dia) {
				$_dia				=	$dia->funcionamiento_dia;
				if(!$dia->funcionamiento_continuado){
					$bo_continuado		=	FALSE;
				}
				$continuado			=	$dia->funcionamiento_continuado;
				$hora_apertura		=	$dia->funcionamiento_hora_apertura;
				$siesta_inicio		=	(!$continuado)	?	$dia->funcionamiento_siesta_inicio	:	NULL;
				$siesta_termino		=	(!$continuado)	?	$dia->funcionamiento_siesta_termino	:	NULL;
				$hora_cierre		=	$dia->funcionamiento_hora_cierre;
				// $orden				=	$dia->funcionamiento_orden;

				$arr[$_dia]			=	array(
					$_dia."_man_inicio"		=>	!empty($hora_apertura)	?	date("H:i",strtotime($hora_apertura))	:	NULL,
					$_dia."_man_fin"		=>	!empty($siesta_inicio)	?	date("H:i",strtotime($siesta_inicio))	:	NULL,
					$_dia."_tar_inicio"		=>	!empty($siesta_termino)	?	date("H:i",strtotime($siesta_termino))	:	NULL,
					$_dia."_tar_fin"		=>	!empty($hora_cierre)	?	date("H:i",strtotime($hora_cierre))		:	NULL,
				);
			}

			$arr_insert		=	array(
				"id_local"			=>	$id_local,
				"bo_continuado"		=>	$bo_continuado,
				"json_lunes"		=>	isset($arr["lunes"])		?	json_encode($arr["lunes"],		JSON_PRETTY_PRINT)	:	NULL,
				"json_martes"		=>	isset($arr["martes"])		?	json_encode($arr["martes"],		JSON_PRETTY_PRINT)	:	NULL,
				"json_miercoles"	=>	isset($arr["miercoles"])	?	json_encode($arr["miercoles"],	JSON_PRETTY_PRINT)	:	NULL,
				"json_jueves"		=>	isset($arr["jueves"])		?	json_encode($arr["jueves"],		JSON_PRETTY_PRINT)	:	NULL,
				"json_viernes"		=>	isset($arr["viernes"])		?	json_encode($arr["viernes"],	JSON_PRETTY_PRINT)	:	NULL,
				"json_sabado"		=>	isset($arr["sabado"])		?	json_encode($arr["sabado"],		JSON_PRETTY_PRINT)	:	NULL,
				"json_domingo"		=>	isset($arr["domingo"])		?	json_encode($arr["domingo"],	JSON_PRETTY_PRINT)	:	NULL,
				"json_festivos"		=>	isset($arr["festivo"])		?	json_encode($arr["festivo"],	JSON_PRETTY_PRINT)	:	NULL,
			);
	
			$id_horario		=	$this->_DAOLocalHorario->create($arr_insert);

			echo '<pre>' . var_export("id_local	=>	".$id_local." -  id_horario => ".$id_horario, true) . '</pre>';
		}
		
	}
}