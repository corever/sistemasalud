<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 *
 * Descripción       : Controller para Buscar dentro del sistema
 *
 * Plataforma        : PHP
 *
 * Creación          : 27/03/2017
 *
 * @name             Buscar.php
 *
 * @version          1.0.0
 *
 * @author           David Guzmán <david.guzman@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha		Descripción
 * ----------------------------------------------------------------------------
 *
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
class Buscar extends Controller {

	protected $_Evento;
	protected $_DAORegion;
	protected $_DAOExpediente;
	protected $_DAOEstablecimientoSalud;
	protected $_DAOPacienteAlarma;
	protected $_DAOAccesoPerfil;
	protected $_DAOUsuario;
	protected $_DAOComuna;
	protected $_DAOOficina;
	protected $_DAOExpedienteMordedor;
	protected $_DAOServicioSalud;

	function __construct() {
		parent::__construct();
		$this->load->lib('Fechas', false);
		$this->load->lib('Boton', false);
		$this->load->lib('Seguridad', false);
		$this->load->lib('Evento', false);

		$this->_Evento					= new Evento();
		$this->_Boton					= new Boton();
		$this->_DAORegion				= $this->load->model("DAODireccionRegion");
		$this->_DAOExpediente           = $this->load->model("DAOExpediente");
		$this->_DAOEstablecimientoSalud = $this->load->model("DAOEstablecimientoSalud");
		$this->_DAOPacienteAlarma   	= $this->load->model("DAOPacienteAlarma");
		$this->_DAOAccesoPerfil			= $this->load->model("DAOAccesoPerfil");
		$this->_DAOUsuario              = $this->load->model("DAOAccesoUsuario");
		$this->_DAOComuna               = $this->load->model("DAODireccionComuna");
		$this->_DAOOficina              = $this->load->model("DAODireccionOficina");
		$this->_DAOExpedienteMordedor   = $this->load->model("DAOExpedienteMordedor");
		$this->_DAOServicioSalud        = $this->load->model("DAOServicioSalud");
	}

	/*
	public function index() {
		Acceso::redireccionUnlogged($this->smarty);
	}
	*/

	/**
	* Descripción	: Buscar Paciente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $parametros Para Buscar por RUT.
	*/
	public function index() {
		Acceso::redireccionUnlogged($this->smarty);
		$this->load->lib('Helpers/Validar', false);
		$folio_expediente   = "";
		$mostrar            = 0;
		$bool_region        = 0;
		$parametros         = $this->_request->getParams();
		$arrRegiones        = $this->_DAORegion->getLista();
		$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getListaOrdenada();
		$perfil 			= $this->_DAOAccesoPerfil->getById($_SESSION[SESSION_BASE]['perfil']);
		$id_perfil 			= $_SESSION[SESSION_BASE]['perfil'];
		$id_oficina 		= $_SESSION[SESSION_BASE]["id_oficina"];
		$id_comuna          = $_SESSION[SESSION_BASE]["id_comuna"];
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
		$id_servicio        = $_SESSION[SESSION_BASE]['id_servicio'];
        $id_region          = $_SESSION[SESSION_BASE]['id_region'];
        $id_usuario         = $_SESSION[SESSION_BASE]['id'];
        
        $arrEstableSalud    = array();
        $arrComuna          = array();
        $arrOficina         = array();
        $arrServicio        = array();
        $bo_nacional        = isset($_SESSION[SESSION_BASE]['bo_nacional'])?$_SESSION[SESSION_BASE]['bo_nacional']:0;
        $bo_oficina         = isset($_SESSION[SESSION_BASE]['bo_oficina'])?$_SESSION[SESSION_BASE]['bo_oficina']:0;
        $bo_comunal         = isset($_SESSION[SESSION_BASE]['bo_comunal'])?$_SESSION[SESSION_BASE]['bo_comunal']:0;
        $bo_fiscalizador    = ($id_perfil == 6 || $id_perfil == 14)?true:false;
        $bo_establecimiento = ($id_perfil == 3 || $id_perfil == 4)?true:false;
        
		$arrRegiones        = $this->_DAORegion->getLista();
        $arrFiscalizador    = array(); //$this->_DAOUsuario->obtenerFiscalizadores();

        if($id_region > 0 && !$bo_nacional && !$bo_establecimiento){
            $arrFiscalizador    = $this->_DAOUsuario->obtenerFiscalizadores($id_region);
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByIdRegion($id_region);
            $arrComuna          = $this->_DAOComuna->getByIdRegion($id_region);
            $arrOficina         = $this->_DAOOficina->getByIdRegion($id_region);
            $arrServicio        = $this->_DAOServicioSalud->getByRegion($id_region);
            foreach($arrRegiones as $key=>$region){
                if($region->id_region != $id_region)
                    unset($arrRegiones->$key);
            }
        }

        if($id_oficina > 0 && $bo_oficina){
            if($arrOficina){
                foreach($arrOficina as $key=>$oficina){
                    if($oficina->id_oficina != $id_oficina)
                        unset($arrOficina->$key);
                }
            }
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByIdOficina($id_oficina);
            $arrComuna          = $this->_DAOComuna->getByIdOficina($id_oficina);
        }

        if($id_comuna > 0 && $bo_comunal){
            if($arrOficina){
                foreach($arrOficina as $key=>$oficina){
                    if($oficina->id_oficina != $id_oficina)
                        unset($arrOficina->$key);
                }
            }
            if($arrComuna){
                foreach($arrComuna as $key=>$comuna){
                    if($comuna->id_comuna != $id_comuna)
                        unset($arrComuna->$key);
                }
            }
            if($id_perfil == 13){ //ENCARGADO COMUNAL
                $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByEncargadoComunal($id_comuna);
            }else{
                $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByIdComuna($id_comuna);
            }
        }

        if($id_usuario > 0 && $bo_fiscalizador){
            if($arrFiscalizador){
                foreach($arrFiscalizador as $key=>$fiscalizador){
                    if($fiscalizador->id_usuario != $id_usuario)
                        unset($arrFiscalizador->$key);
                }
            }
        }

        if($id_establecimiento > 0 && $bo_establecimiento){
            if($arrEstableSalud){
                foreach($arrEstableSalud as $key=>$est){
                    if($est->id_establecimiento != $id_establecimiento)
                        unset($arrEstableSalud->$key);
                }
            }
        }
        
        if($id_perfil == 15){ //ENCARGADO SERVICIO SALUD
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByIdRegionAndServicio($id_region,$id_servicio);
            if($arrServicio){
                foreach($arrServicio as $key=>$ser){
                    if($ser->id_servicio != $id_servicio)
                        unset($arrServicio->$key);
                }
            }
        }
        
        if(isset($parametros['token_expediente']) && $parametros['token_expediente']){
            $_SESSION[SESSION_BASE]['token_expediente'] = $parametros['token_expediente'];
            $arrExpediente      = $this->_DAOExpediente->getByToken($parametros['token_expediente']);
            $folio_expediente   = (!empty($arrExpediente))?$arrExpediente->gl_folio:"";
            $this->_addJavascript('setTimeout(function(){$("#buscar").trigger("click");},500);');
        }

		$this->smarty->assign('folio_expediente', $folio_expediente);
        $this->smarty->assign('id_perfil', $id_perfil);
        $this->smarty->assign('arrRegiones', $arrRegiones);
        $this->smarty->assign('arrFiscalizador', $arrFiscalizador);
        $this->smarty->assign('arrOficina', $arrOficina);
        $this->smarty->assign('arrComuna', $arrComuna);
        $this->smarty->assign('arrServicio', $arrServicio);
        
		$this->smarty->assign('id_servicio',$id_servicio);
		$this->smarty->assign('bool_region', $bool_region);
		$this->smarty->assign("arrEstableSalud", $arrEstableSalud);
		$this->smarty->assign('mostrar',$mostrar);
		$this->smarty->assign('origen', 'Buscar');
		$this->smarty->assign('sin_header', 1);

        if($id_perfil == 13){ //Perfil Comunal
            $this->_display('buscar/vista_perfil_comunal.tpl');
        }elseif($id_perfil == 15){ //Perfil Servicio Salud
            $this->_display('buscar/vista_perfil_servicio_salud.tpl');
        }else{
            $this->_display('buscar/paciente.tpl');
        }
        
        $this->load->javascript("https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=".API_KEY,1);
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES . "js/templates/buscar/buscar.js",0,1);
	}

	public function listarEstablecimientos(){
		$parametros         = $this->_request->getParams();
		$region 			= $parametros["region"];
		if(!empty($region)){
			$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getListaOrdenadaByRegion($region);
		}else{
			$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getListaOrdenada();
		}

		$listaEstablecimiento = array();
		$listaEstablecimiento[] = array(
					"id" => '',
					"text" => "Seleccione un Establecimiento Salud"
				);
		foreach ($arrEstableSalud as $establecimiento) {
			$listaEstablecimiento[] = array(
					"id" => $establecimiento->id_establecimiento,
					"text" => $establecimiento->gl_nombre_establecimiento
				);
		}
		echo json_encode($listaEstablecimiento);
	}

	public function recargarGrillaBuscar(){
        ini_set("memory_limit",-1);
		$this->load->lib('Helpers/Validar', false);
		$parametros         = $this->_request->getParams();
        $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
		$perfil 			= $this->_DAOAccesoPerfil->getById($id_perfil);
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
		$id_comuna          = $_SESSION[SESSION_BASE]["id_comuna"];
        $arrGrilla          = array("data"=>array());
        
        if($id_perfil == 12){
            $bandeja = "buscarAdministrativo";
        }elseif($id_perfil == 6 || $id_perfil == 14){
            $bandeja = "fiscalizador";
        }elseif($id_perfil == 3){
            $bandeja = "establecimiento";
        }elseif($id_perfil == 5 || $id_perfil == 10 || $id_perfil == 1){
            //Supervisor o Encargado Regional
            $bandeja = "buscarSeremi";
        }else{
            $bandeja = "";
        }
        
        //Parametro por URL busca por token expediente
        if(isset($_SESSION[SESSION_BASE]['token_expediente'])){
            $parametros['token_expediente'] = $_SESSION[SESSION_BASE]['token_expediente'];
            unset($_SESSION[SESSION_BASE]['token_expediente']);
        }

		if(!empty($parametros)){
			$rut = '';
			$pasaporte = '';
			//$rut                  = $parametros["rut"];
			//$pasaporte            = $parametros["pasaporte"];
			$id_oficina             = (isset($parametros["id_oficina"]))?$parametros["id_oficina"]:0;
			$documento              = $parametros["documento"];
			$folio_expediente       = $parametros["folio_expediente"];
			$region                 = (isset($parametros["region"]))?$parametros["region"]:0;
			$comuna                 = (isset($parametros["comuna"]))?$parametros["comuna"]:0;
			$folio_mordedor         = $parametros["folio_mordedor"];
			$estable_salud          = (isset($parametros["establecimiento_salud"]))?$parametros["establecimiento_salud"]:"";
			$microchip_mordedor     = (isset($parametros["microchip_mordedor"]))?$parametros["microchip_mordedor"]:"";
			$id_fiscalizador        = (isset($parametros["id_fiscalizador"]))?$parametros["id_fiscalizador"]:0;
            $fecha_desde            = $parametros["fecha_desde"];
			$fecha_hasta            = $parametros["fecha_hasta"];
            
			if($documento != ''){
				if(Validar::validarRut($documento)){
					$parametros["rut"] = $documento;
				}else{
					$parametros["pasaporte"] = $documento;
				}
			}

			/*if ($rut != '' && $pasaporte != ''){
				$jscode		= "xModal.danger('Error: No se puede buscar por Rut y Pasaporte a la vez');";
				$this->_addJavascript($jscode);
			} else */
			if($documento != '' || $folio_expediente != '' || $fecha_desde != '' ||
					  $fecha_hasta != '' || $region != 0 || $comuna != 0 || $folio_mordedor != '' ||
					  $estable_salud != '' || $microchip_mordedor != '' || $id_fiscalizador != 0 || $id_oficina != ''){
                
                $parametros['in_establecimiento'] = $estable_salud;
                if($id_perfil == 13 && empty($estable_salud)){
                    $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByEncargadoComunal($id_comuna);
                    foreach($arrEstableSalud as $item){
                        $arr_establecimiento[] = $item->id_establecimiento;
                    }
                    $parametros['in_establecimiento']   = implode(",",$arr_establecimiento);
                }
                
				$mostrar	= 1;
				$arr		= $this->_DAOExpediente->buscarExpedientes($parametros);
                if(!empty($arr)){
                    foreach ((array)$arr as &$expediente) {
                        $especie	= $this->_DAOExpedienteMordedor->getEspecieByExpediente($expediente->id_expediente);
                        
                        if(!empty($especie)){
                            $especie_mordedor = $especie->gl_especie;
                        }else{
                            $especie_mordedor = $expediente->gl_grupo_animal;
                        }
                        
                        $where = array(
                            "id_perfil" => $_SESSION[SESSION_BASE]['perfil'],
                            "id_establecimiento" => $id_establecimiento,
                            "id_expediente" => $expediente->id_expediente,
                        );
                        $alarma    = $this->_DAOPacienteAlarma->getListaDetalle($where);

                        if(!empty($alarma) && isset($alarma->row_0)){
                            $expediente->id_alarma = $alarma->row_0->id_alarma;
                            $expediente->nombre_tipo_alarma = $alarma->row_0->nombre_tipo_alarma;
                            $expediente->id_tipo_alarma = $alarma->row_0->id_tipo_alarma;
                            $expediente->nombre_alarma_estado = $alarma->row_0->nombre_alarma_estado;
                            $expediente->id_alarma_estado = $alarma->row_0->id_alarma_estado;
                            $expediente->bo_apagar_alarma = $alarma->row_0->bo_apagar;
                        }

                        /*Armo Grilla*/

                        $item    = array();
                        $item['resultado_lab'] = '-';
                        
                        if($expediente->id_tipo_visita_resultado_mor == 2 || $expediente->id_tipo_visita_resultado == 2){
                            $item['resultado_obs']  = '<span class="label label-danger">Sospechoso</span>';

                            if($expediente->id_resultado_isp_1 == 1){
                                $item['resultado_lab']  = '<span class="label label-danger">Positivo</span>';
                            }elseif($expediente->nr_visitas_mordedor > 0 && $expediente->id_resultado_isp_2 == 2){
                                $item['resultado_lab']  = '<span class="label label-success">Negativo</span>';
                            }

                        }elseif($expediente->nr_visitas_mordedor > 0 && $expediente->id_expediente_estado == 11 && $expediente->id_ultimo_visita_resultado != 5){
                            $item['resultado_obs']  = '<span class="label label-success">No Sospechoso</span>';
                        }elseif($expediente->id_ultimo_visita_estado == 1){
                            $item['resultado_obs']  = '<span class="label label-danger">Perdida</span>';
                        }elseif($expediente->id_ultimo_visita_resultado == 5){
                            $item['resultado_obs']  = '<span class="label label-danger">Se Niegan a Visita</span>';
                        }else{
                            $item['resultado_obs']  = '-';
                        }

                        if(!empty($expediente->gl_nombre_fiscalizador)){
                            $item['fiscalizador']   = $expediente->gl_nombre_fiscalizador;
                            $grupo_fiscalizador     = $expediente->grupo_fiscalizador;
                        }elseif(!empty($expediente->gl_nombre_fiscalizador_microchip)){
                            $item['fiscalizador']   = $expediente->gl_nombre_fiscalizador_microchip;
                            $grupo_fiscalizador     = $expediente->grupo_fiscalizador_microchip;
                        }else{
                            $item['fiscalizador']   = 'No Asignado';
                            $grupo_fiscalizador     = "";
                        }

                        if($expediente->id_animal_grupo == 1){
                            $item['grupo_mordedor']  = '<span class="label label-warning">'.$expediente->gl_grupo_animal.'</span>';
                        }elseif($expediente->id_animal_grupo == 2){
                            $item['grupo_mordedor']  = '<span class="label label-info">'.$expediente->gl_grupo_animal.'</span>';
                        }else{
                            $item['grupo_mordedor']  = '<span class="label label-success">'.$especie_mordedor.'</span>';
                        }

						if($expediente->bo_paciente_observa == 1) {
							$item['bo_paciente_observa'] = '<span class="label label-info">Sí</span>';
						}else {
							$item['bo_paciente_observa'] = '<span class="label label-warning">No</span>';
						}

						if($expediente->sin_direccion > 0) {
							$item['sin_dir'] = '<span class="label label-warning">SIN</span>';
						}else {
							$item['sin_dir'] = '<span class="label label-success">CON</span>';
						}

                        $item['folio']                  = $expediente->gl_folio;
                        $item['fc_ingreso']             = $expediente->fc_ingreso;
                        $item['establecimiento']        = $expediente->gl_establecimiento;
                        $item['gl_region_mordedor']     = $expediente->gl_region_mordedor;
                        $item['gl_comuna_mordedor']     = $expediente->gl_comuna_mordedor;
                        $item['gl_comuna_est']          = $expediente->gl_comuna_est;
                        $item['fc_mordedura']           = $expediente->fc_mordedura;
                        $item['dias_mordedura']         = $expediente->dias_mordedura;
                        $item['dias_bandeja']           = $expediente->dias_bandeja;
                        $item['estado']                 = '<span class="'.$expediente->gl_class_estado.'">'.$expediente->gl_nombre_estado.'</span>';
						// $item['bo_paciente_observa']	= $expediente->bo_paciente_observa;
                        
                        $item['opciones']               = $this->_Boton->botonGrilla(   $bandeja,
                                                                                        $expediente->gl_token,
                                                                                        '',
                                                                                        $expediente->grupo_expediente_mordedor_estado,
                                                                                        $expediente->id_animal_grupo,
                                                                                        ($item['dias_mordedura']>=15)?1:0,  //Microchip
                                                                                        $expediente->gl_folio,
                                                                                        $expediente->nr_visitas,
                                                                                        $expediente->id_expediente_estado,
                                                                                        $expediente->bo_domicilio_conocido,
                                                                                        $expediente->id_tipo_visita_resultado,
                                                                                        $expediente->id_tipo_visita_resultado_mor,
                                                                                        $expediente->id_resultado_isp_1,
                                                                                        $expediente->id_resultado_isp_2,
                                                                                        $expediente->bo_all_domicilio_conocido,
                                                                                        $grupo_fiscalizador,
                                                                                        $expediente->bo_paciente_observa,
                                                                                        $expediente->boton_llamado_observa,
                                                                                        $expediente->grupo_resultado_isp,
                                                                                        $expediente->id_ultimo_visita_estado,
                                                                                        $expediente->id_ultimo_tipo_visita_perdida,
                                                                                        $expediente->bo_ultimo_volver_visitar
                                                                                    );

                        $arrGrilla['data'][] = $item;

                    }
                }

				//$this->smarty->assign('arrResultado', $arr);
			}
		}
		/*$error      = false;
		$grilla		= $this->smarty->fetch('grilla/pacientes.tpl');
		$correcto	= true;
		$salida	= array('error' => $error, 'correcto' => $correcto, 'grilla' => $grilla);
		$json	= Zend_Json::encode($salida);*/
		echo json_encode($arrGrilla);
	}
}