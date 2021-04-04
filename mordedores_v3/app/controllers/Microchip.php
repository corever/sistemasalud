<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripción       : Controller para las funciones de microchip
 *
 * Plataforma        : PHP
 * 
 * Creación          : 06/06/2018
 * 
 * @name             Microchip.php
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
class Microchip extends Controller {

	protected $_Evento;
	protected $_DAOPaciente;
	protected $_DAOExpediente;
	protected $_DAOUsuario;
	protected $_DAOExpedienteMordedor;
	protected $_DAORegion;
	protected $_DAOComuna;
	protected $_DAOOficina;
	protected $_DAOEstablecimientoSalud;

	function __construct() {
		parent::__construct();
		$this->load->lib('Fechas', false);
		$this->load->lib('Boton', false);
		$this->load->lib('Seguridad', false);
		$this->load->lib('Evento', false);

		$this->_Evento							= new Evento();
		$this->_DAOPaciente						= $this->load->model("DAOPaciente");
		$this->_DAOExpediente                   = $this->load->model("DAOExpediente");
		$this->_DAORegion                       = $this->load->model("DAODireccionRegion");
		$this->_DAOComuna                       = $this->load->model("DAODireccionComuna");
		$this->_DAOOficina                      = $this->load->model("DAODireccionOficina");
		$this->_DAOEstablecimientoSalud         = $this->load->model("DAOEstablecimientoSalud");
		$this->_DAOUsuario                      = $this->load->model("DAOAccesoUsuario");
		$this->_DAOExpedienteMordedor           = $this->load->model("DAOExpedienteMordedor");
	}

	/**
	* Descripción	: Grilla Microchip
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function index() {
        ini_set("memory_limit",-1);
		Acceso::redireccionUnlogged($this->smarty);
		$id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
		$id_region          = $_SESSION[SESSION_BASE]['id_region'];
		$id_oficina         = $_SESSION[SESSION_BASE]['id_oficina'];
		$id_comuna          = $_SESSION[SESSION_BASE]['id_comuna'];
		$id_usuario         = $_SESSION[SESSION_BASE]['id'];
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
        $bo_nacional        = isset($_SESSION[SESSION_BASE]['bo_nacional'])?$_SESSION[SESSION_BASE]['bo_nacional']:0;
        $bo_regional        = isset($_SESSION[SESSION_BASE]['bo_regional'])?$_SESSION[SESSION_BASE]['bo_regional']:0;
        $bo_oficina         = isset($_SESSION[SESSION_BASE]['bo_oficina'])?$_SESSION[SESSION_BASE]['bo_oficina']:0;       
        $bo_comunal         = isset($_SESSION[SESSION_BASE]['bo_comunal'])?$_SESSION[SESSION_BASE]['bo_comunal']:0;       
        $bo_establecimiento = isset($_SESSION[SESSION_BASE]['bo_establecimiento'])?$_SESSION[SESSION_BASE]['bo_establecimiento']:0;
        $arr                = array();
        $bo_agrega          = 0;
        $bandeja            = '';
        $js_code            = '';
        $arrEstableSalud    = array();
        $arrComuna          = array();
        $arrOficina         = array();

        //ADMINISTRADOR, REGIONAL, SUPERVISOR O ADMINISTRATIVO
		if($id_perfil == 1 || $id_perfil == 5 || $id_perfil == 10 || $id_perfil == 12 || $id_perfil == 13){
            
            //$where                  = array('bo_dias'=>15, 'id_expediente_estado'=>1,"id_animal_grupo"=>3);
            $fecha_desde            = date('d/m/Y', strtotime('- 60 days'));
            $where                  = array('no_cerrada'=>TRUE,'bo_dias'=>15,"id_animal_grupo"=>3,'fecha_desde'=>$fecha_desde,'fecha_hasta'=>date('d/m/Y'));
            $where['id_oficina']    = ($id_oficina > 0)?$id_oficina:0;
            $where['comuna']        = ($id_comuna > 0 && $bo_comunal)?$id_comuna:0;
            
            if($id_region > 0 && !$bo_nacional){
                $this->smarty->assign('id_region', $id_region);
                 $where['id_region']    = $id_region;
            }
			
			$arr                    = $this->_DAOExpediente->getListaDetalle($where);
            
            if($arr){
                foreach($arr as $key => $expediente){
                    $especie	= $this->_DAOExpedienteMordedor->getEspecieByExpediente($expediente->id_expediente);

                    if(!empty($especie)){
                        $arr->$key->gl_especie = $especie->gl_especie;
                    }else{
                        $arr->$key->gl_especie = $expediente->gl_grupo_animal;
                    }
                }
            }
            
            $bandeja                = ($id_perfil == 12)?'administrativo':'seremi';
            
            if($id_region > 0 && $id_oficina == 0){
                $js_code = "setTimeout(function(){ $('#region').trigger('change'); },500);";
                $this->_addJavascript($js_code);
            }
		}
        
        //DATOS PARA FILTROS
        $arrRegiones        = $this->_DAORegion->getLista();
        $arrFiscalizador    = $this->_DAOUsuario->obtenerFiscalizadores();
        
        if($id_region > 0 && !$bo_nacional){
            $arrFiscalizador    = $this->_DAOUsuario->obtenerFiscalizadores($id_region);
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByIdRegion($id_region);
            $arrComuna          = $this->_DAOComuna->getByIdRegion($id_region);
            $arrOficina         = $this->_DAOOficina->getByIdRegion($id_region);
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
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByIdComuna($id_oficina);
        }
        
        if($id_usuario > 0 && ($id_perfil == 6 || $id_perfil == 14)){
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
        
        $this->smarty->assign('arrRegiones', $arrRegiones);
        $this->smarty->assign('arrFiscalizador', $arrFiscalizador);
        $this->smarty->assign('arrEstableSalud', $arrEstableSalud);
        $this->smarty->assign('arrOficina', $arrOficina);
        $this->smarty->assign('arrComuna', $arrComuna);
        $this->smarty->assign('bo_filtros', true);
        $this->smarty->assign('bo_microchip', 1);

		$this->smarty->assign('arrResultado', $arr);
		$this->smarty->assign('id_perfil', $id_perfil);
		$this->smarty->assign('bo_agrega', $bo_agrega);
		$this->smarty->assign('bo_nacional', $bo_nacional);
		$this->smarty->assign('bandeja', $bandeja);
		$this->smarty->assign('origen', "Microchip");
		$this->smarty->assign('microchip', 1);
		$this->smarty->assign('smart', $this->smarty);

		$this->_display('grilla/pacientes.tpl');
        $this->load->javascript("https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=".API_KEY,1);
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES . "js/templates/paciente/index.js");
	}
    
    /**
	* Descripción	: Buscar Grilla Microchip
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function buscarGrilla() {
        ini_set("memory_limit",-1);
		$this->load->lib('Helpers/Validar', false);
        $params             = $this->_request->getParams();
		$id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
        $arr                = array();
        $bandeja            = $params['bandeja'];

        //ADMINISTRADOR, REGIONAL, SUPERVISOR O ADMINISTRATIVO
		if($id_perfil == 1 || $id_perfil == 5 || $id_perfil == 10 || $id_perfil == 12){ 
			//$where                              = array('id_region'=>$id_region,'bo_dias'=>15, 'id_expediente_estado'=>1,"id_animal_grupo"=>3);
			$where                              = array('no_cerrada'=>TRUE,'bo_dias'=>15,"id_animal_grupo"=>3);
            
            $where['id_region']                 = $params['region'];
            $where['folio_expediente']          = $params['folio_expediente'];
            $where['folio_mordedor']            = $params['folio_mordedor'];
            $where['microchip_mordedor']        = $params['microchip_mordedor'];
            $where['id_establecimiento']        = $params['establecimiento_salud'];
            $where['id_oficina']                = $params['id_oficina'];
            $where['comuna']                    = $params['comuna'];
            $where['id_fiscalizador']           = $params['id_fiscalizador'];
            $where["documento"]                 = $params['documento'];
            
            /*YA NO SE MUESTRA FILTRO FECHA EN MICROCHIP - MICROCHIP MUESTRA SOLO ULTIMOS 60 DIAS (17/07/2019)*/
            $fecha_desde                        = date('d/m/Y', strtotime('- 60 days'));
            $fecha_hasta                        = date('d/m/Y');            
            $where["fecha_desde"]               = $fecha_desde;//$params['fecha_desde'];
            $where["fecha_hasta"]               = $fecha_hasta;//$params['fecha_hasta'];
            
            $where["microchip"]                 = true;
            
			$arr		= $this->_DAOExpediente->getListaDetalle($where);
            
            if($arr){
                foreach($arr as $key => $expediente){
                    $especie	= $this->_DAOExpedienteMordedor->getEspecieByExpediente($expediente->id_expediente);

                    if(!empty($especie)){
                        $arr->$key->gl_especie = $especie->gl_especie;
                    }else{
                        $arr->$key->gl_especie = $expediente->gl_grupo_animal;
                    }
                }
            }
		}
        
		$this->smarty->assign('arrResultado', $arr);
		$this->smarty->assign('bandeja', $bandeja);
		$this->smarty->assign('id_perfil', $id_perfil);
        $this->smarty->assign('microchip', 1);

		if ($bandeja == "establecimiento" || $bandeja == "admin" || $bandeja == "nacional"){
            $vista_tpl = 'grilla/grilla_pacientes_supervisor.tpl';
        }else if ($bandeja == "seremi" || $bandeja == "otro"){
            $vista_tpl = 'grilla/grilla_pacientes_seremi.tpl';
        }else{
            $vista_tpl = 'grilla/grilla_pacientes.tpl';
        }
        
        echo $this->smarty->display($vista_tpl);
	}
    
    /**
	* Descripción	: Asignar microchip
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente)
	*/
    public function asignar() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->request->getParametros();
        $token_expediente   = $params[0];
        
        //CABECERA
        $arrExpediente	= $this->_DAOExpediente->getBitacoraByToken($token_expediente,1);
        $this->smarty->assign("arr", $arrExpediente);
        
        $this->smarty->assign('bo_opciones', 1);
        $this->smarty->assign('bandeja', 'asignar_microchip');
        $this->smarty->assign('id_perfil_usuario', intval($_SESSION[SESSION_BASE]['perfil']));
        $this->smarty->assign('id_region_usuario', intval($_SESSION[SESSION_BASE]['id_region']));
        $this->smarty->assign('id_usuario', intval($_SESSION[SESSION_BASE]['id']));

		$this->smarty->display('bitacora/cabecera_expediente.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/agenda/mapa.js");
	}
    
    /**
	* Descripción	: Asignar o reasignar fiscalizador a expediente Microchip
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente) y string $gl_token_fiscalizador
	*/
    public function asignarFiscalizador() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->request->getParametros();
        $token_exp_mor      = $params[0];
        $region_mordedor    = $params[1];
        $comuna_mordedor    = $params[2];
        $reasignar          = false;
        
        if(isset($params[3])){
            $reasignar          = true;
            $token_fiscalizador = $params[3];
            $this->smarty->assign('reasignar', $reasignar);
            $this->smarty->assign('tokenFiscalizador', $token_fiscalizador);
        }
        $arr_fiscalizadores = $this->_DAOUsuario->obtenerFiscalizadores($region_mordedor,$comuna_mordedor);
        
        //$this->smarty->assign('arrExpediente', $arr_expediente);
        $this->smarty->assign('bo_opciones', 1);
        $this->smarty->assign('bandeja', 'asignar_microchip');
        $this->smarty->assign('token_exp_mor', $token_exp_mor);
        $this->smarty->assign('arrFiscalizadores', $arr_fiscalizadores);

		$this->smarty->display('agenda/asignar.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/microchip/asignar.js");
	}

	/**
	* Descripción	: Guardar BD Asignar o reasignar fiscalizador a expediente Microchip
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente) y string $gl_token_fiscalizador
	*/
    public function asignarFiscalizadorBD() {
        Acceso::redireccionUnlogged($this->smarty);
        $params = $this->_request->getParams();
        $json   = array("correcto" => false);
        $bo_reasignar = (isset($params['bo_reasignar']))?$params['bo_reasignar']:0;
        
        if(isset($params['token_fiscalizador']) && isset($params['token_exp_mor'])){
            $fiscalizador       = $this->_DAOUsuario->getDetalleByToken($params['token_fiscalizador']);
            $arrMordedor        = $this->_DAOExpedienteMordedor->getByToken($params['token_exp_mor']);
            $arrExpediente      = $this->_DAOExpediente->getDetalleByToken($arrMordedor->token_expediente);
            $bo_asignado        = $this->_DAOExpedienteMordedor->asignarFiscalizadorMicrochip($fiscalizador->id_usuario,$params['token_exp_mor']);
            $json['correcto']   = $bo_asignado;
            $id_expediente      = $arrExpediente->id_expediente;
            $id_paciente        = $arrExpediente->id_paciente;
            $id_mordedor        = $arrMordedor->id_mordedor;

			// Cambiar Estado
			$arrPendiente		= $this->_DAOExpedienteMordedor->getByIdEstado($id_expediente,1);
			if(empty($arrPendiente)){
				$this->_DAOExpediente->cambiarEstado($id_expediente,14);
				$json['recargaTabla']	= true;
			}else{
				$this->_DAOExpediente->cambiarEstado($id_expediente,13);
			}
			
            //Guardar Evento
            $id_evento_tipo = ($bo_reasignar==1)?18:17; //Se asigna/reasigna fiscalizador
            if($bo_reasignar==1){
                $gl_descripcion = "Se reasigna mordedor folio: ".$arrMordedor->gl_folio_mordedor." (bandeja Microchip) a Fiscalizador: ".$fiscalizador->gl_nombres." ".$fiscalizador->gl_apellidos;
            }else{
                $gl_descripcion = "Se asigna mordedor folio: ".$arrMordedor->gl_folio_mordedor." (bandeja Microchip) a Fiscalizador: ".$fiscalizador->gl_nombres." ".$fiscalizador->gl_apellidos;
            }
            $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, $id_mordedor, $gl_descripcion);
        }
        
        echo json_encode($json);
	}
    
    public function cerrarNotificacion(){
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->_request->getParams();
        $token_expediente   = $params['token_expediente'];
                
        $this->smarty->assign('token_expediente', $token_expediente);

		$this->smarty->display('agenda/cerrarNotificacion.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/microchip/cerrarNotificacion.js");
    }
    
    public function cerrarNotificacionBD(){
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->_request->getParams();
        $json               = array("correcto" => false);
        $token_expediente   = (isset($params['token_expediente']))?$params['token_expediente']:"";
        $txt_motivo_cerrado = (isset($params['txt_motivo_cerrado']))?$params['txt_motivo_cerrado']:"";
        
        if($txt_motivo_cerrado != "" && $token_expediente != ""){
            $arrExpediente  = $this->_DAOExpediente->getDetalleByToken($token_expediente);
            $id_expediente  = $arrExpediente->id_expediente;
            $id_paciente    = $arrExpediente->id_paciente;
            
            $bo_guardado    = $this->_DAOExpediente->cambiarEstado($id_expediente,3); //Cambio Estado = Cerrada
			
            if($bo_guardado){
                //Guardar Evento
                $id_evento_tipo = 30; //Se Cierra Notificación
                $gl_descripcion = "Se cambia Estado de Notificación a Cerrado con el siguiente motivo: <br>".$txt_motivo_cerrado;
                $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, 0, $gl_descripcion);
                $json['correcto'] = true;
            }
        }
        
        echo json_encode($json);
    }
}