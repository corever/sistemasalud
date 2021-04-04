<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 *
 * Descripción       : Controller para Buscar Notificaciones dentro del sistema
 *
 * Plataforma        : PHP
 *
 * Creación          : 07/10/2020
 *
 * @name             EditarDireccion.php
 *
 * @version          1.0.0
 *
 * @author           Camila Figueroa
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
class EditarDireccion extends Controller {

	
	protected $_Evento;
	protected $_formatoArchivo;
	protected $_Expediente;
	protected $_DAOUsuario;
	protected $_DAORegion;
	protected $_DAOComuna;
	protected $_DAOOficina;
	protected $_DAOPaciente;
	protected $_DAOPrevision;
	protected $_DAOPacienteDatos;
	protected $_DAOEvento;
	protected $_DAOEventoTipo;
	protected $_DAOAdjunto;
	protected $_DAOAdjuntoTipo;
	protected $_DAOExpediente;
	protected $_DAOExpedientePaciente;
	protected $_DAOExpedienteMordedor;
	protected $_DAOEstablecimientoSalud;
	protected $_DAOPacienteAgenda;
	protected $_DAOPacienteContacto;
	protected $_DAOPais;
	protected $_DAONacionalidad;
	protected $_DAOEstadoCivil;
	protected $_DAOAnimalEspecie;
	protected $_DAOAnimalEstado;
	protected $_DAOAnimalRaza;
	protected $_DAOAnimalTamano;
	protected $_DAOAnimalMordedor;
	protected $_DAOAnimalGrupo;
	protected $_DAOTipoContacto;
	protected $_DAODueno;
	protected $_DAOCorrelativoFolio;
	protected $_DAOCorrelativoFolioMordedor;
	protected $_DAOGeneralIniciaVacuna;
	protected $_DAOLugarMordedura;
	protected $_DAOPacienteAlarma;
	protected $_DAOTipoSintoma;
	protected $_DAOPerfilDocumento;


	function __construct() {
		parent::__construct();
		$this->load->lib('Fechas', false);
		$this->load->lib('Boton', false);
		$this->load->lib('Seguridad', false);
		$this->load->lib('Evento', false);
		$this->load->lib('formatoArchivo', false);
		$this->load->lib('UsuarioWS', false);

		$this->_Evento                      = new Evento();
		$this->_formatoArchivo              = new formatoArchivo();
		$this->_DAOExpediente               = $this->load->model("DAOExpediente");
		$this->_DAOUsuario                  = $this->load->model("DAOAccesoUsuario");
		$this->_DAORegion                   = $this->load->model("DAODireccionRegion");
		$this->_DAOComuna                   = $this->load->model("DAODireccionComuna");
		$this->_DAOOficina                  = $this->load->model("DAODireccionOficina");
		$this->_DAOPaciente                 = $this->load->model("DAOPaciente");
		$this->_DAOPrevision                = $this->load->model("DAOGeneralPrevision");
		$this->_DAOPacienteDatos            = $this->load->model("DAOPacienteDatos");
		$this->_DAOEvento                   = $this->load->model("DAOHistorialEvento");
		$this->_DAOEventoTipo               = $this->load->model("DAOHistorialEventoTipo");
		$this->_DAOAdjunto                  = $this->load->model("DAOAdjunto");
		$this->_DAOAdjuntoTipo              = $this->load->model("DAOAdjuntoTipo");
		$this->_DAOExpediente               = $this->load->model("DAOExpediente");
		$this->_DAOExpedientePaciente       = $this->load->model("DAOExpedientePaciente");
		$this->_DAOExpedienteMordedor       = $this->load->model("DAOExpedienteMordedor");
		$this->_DAOEstablecimientoSalud     = $this->load->model("DAOEstablecimientoSalud");
		$this->_DAOPacienteAgenda           = $this->load->model("DAOPacienteAgenda");
		$this->_DAOPacienteContacto         = $this->load->model("DAOPacienteContacto");
		$this->_DAOPais                     = $this->load->model("DAODireccionPais");
		$this->_DAONacionalidad             = $this->load->model("DAODireccionNacionalidad");
		$this->_DAOEstadoCivil              = $this->load->model("DAOTipoEstadoCivil");
		$this->_DAOTipoSexo                 = $this->load->model("DAOTipoSexo");
		$this->_DAOAnimalEspecie            = $this->load->model("DAOAnimalEspecie");
		$this->_DAOAnimalEstado             = $this->load->model("DAOAnimalEstado");
		$this->_DAOAnimalMordedor           = $this->load->model("DAOAnimalMordedor");
		$this->_DAOAnimalGrupo              = $this->load->model("DAOAnimalGrupo");
		$this->_DAOTipoContacto             = $this->load->model("DAOTipoContacto");
		$this->_DAOAnimalRaza               = $this->load->model("DAOAnimalRaza");
		$this->_DAOAnimalTamano             = $this->load->model("DAOAnimalTamano");
		$this->_DAODueno                    = $this->load->model("DAODueno");
		$this->_DAOCorrelativoFolio         = $this->load->model("DAOCorrelativoFolio");
		$this->_DAOCorrelativoFolioMordedor = $this->load->model("DAOCorrelativoFolioMordedor");
		$this->_DAOGeneralIniciaVacuna      = $this->load->model("DAOGeneralIniciaVacuna");
		$this->_DAOLugarMordedura           = $this->load->model("DAOGeneralLugarMordedura");
		$this->_DAOPacienteAlarma           = $this->load->model("DAOPacienteAlarma");
		$this->_DAOTipoSintoma              = $this->load->model("DAOTipoSintoma");
		$this->_DAOPerfilDocumento          = $this->load->model("DAOPerfilDocumento");
	}

	/**
    * Descripción	: Grilla Listado de notificaciones para editar direccion
    * Cuando recién se carga la página, no mostrará listado , hasta que el usuario ingrese filtros
	* @author		: Camila Figueroa
	*/
	public function index() {
        ini_set("memory_limit",-1);
		Acceso::redireccionUnlogged($this->smarty);
		$id_perfil          = $_SESSION[SESSION_BASE]['perfil'];				    
        $arr				= array();
        $where				= array("no_cerrada"=>TRUE);
		$bo_agrega			= 0;
		$bandeja			= 'editar_direccion';
        $bo_filtros         = true;
        $bo_fiscalizador    = false;
        $bo_establecimiento = false;          
        $arrEstableSalud    = array();
        $arrComuna          = array();
        $arrOficina         = array();
        $arrRegiones        = $this->_DAORegion->getLista();
        $arrFiscalizador    = array(); 
        $arrAlarmas         = array();

        $this->smarty->assign('arrRegiones', $arrRegiones);
        $this->smarty->assign('arrFiscalizador', $arrFiscalizador);
        $this->smarty->assign('arrEstableSalud', $arrEstableSalud);
        $this->smarty->assign('arrOficina', $arrOficina);
        $this->smarty->assign('arrComuna', $arrComuna);
        $this->smarty->assign('arrAlarmas', $arrAlarmas);
        $this->smarty->assign('bo_filtros', $bo_filtros);
        $this->smarty->assign('origen', 'Editar Dirección');
        $this->smarty->assign('arrResultado', $arr);        
		$this->smarty->assign('id_perfil', $id_perfil);
		$this->smarty->assign('bo_agrega', $bo_agrega);
		$this->smarty->assign('bandeja', $bandeja);
		$this->smarty->assign('smart', $this->smarty);
		$this->_display('grilla/pacientes_editar_direccion.tpl');
        $this->load->javascript("https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=".API_KEY,1);
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES . "js/templates/paciente/editarDireccion.js");
	}

    /**
	* Descripción	: Permite listar las notificaciones luego de filtrar 
	* @author		: Camila Figueroa
	*/
	public function buscarGrilla() {
        ini_set("memory_limit",-1);
        $params             = $this->_request->getParams();
		$this->load->lib('Helpers/Validar', false);
        $bandeja                            = $params['bandeja'];
        $where['id_region']                 = $params['region'];
        $where['folio_expediente']          = $params['folio_expediente'];
        $where['folio_mordedor']            = $params['folio_mordedor'];
        $where['microchip_mordedor']        = $params['microchip_mordedor'];
        $where['id_establecimiento']        = $params['establecimiento_salud'];
        $where['id_oficina']                = $params['id_oficina'];
        $where['comuna']                    = $params['comuna'];
        $where['id_fiscalizador']           = $params['id_fiscalizador'];
        $where["documento"]                 = $params['documento'];
        $where["editar_direccion"]          = 1;                
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
        
        $this->smarty->assign('arrResultado', $arr);
		$this->smarty->assign('bandeja', $bandeja);

		if ($bandeja == "establecimiento" || $bandeja == "admin" || $bandeja == "nacional"){
            $vista_tpl = 'grilla/grilla_pacientes_supervisor.tpl';
        }else if ($bandeja == "seremi" || $bandeja == "otro"){
            $vista_tpl = 'grilla/grilla_pacientes_seremi.tpl';
        }else if($bandeja =="editar_direccion"){
            $vista_tpl = 'grilla/grilla_pacientes_editar_direccion.tpl';
        }else{
            $vista_tpl = 'grilla/grilla_pacientes.tpl';
        }

        echo $this->smarty->display($vista_tpl);
	}

	/**
	* Descripción	: Grilla Registro
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function grillaRegistros() {
		$id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
		$id_region          = $_SESSION[SESSION_BASE]['id_region'];
		$id_oficina			= $_SESSION[SESSION_BASE]['id_oficina'];
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
		$id_usuario         = $_SESSION[SESSION_BASE]['id'];
        $arr				= array();
        $where				= array();
		$bo_agrega			= 0;
		$bandeja			= 'seremi';

		if($id_perfil == 1 || $id_perfil == 7 || $id_perfil == 8){
			//NACIONAL
            $bo_agrega  = ($id_perfil == 1)?1:0;
            $bandeja    = ($id_perfil == 1)?'admin':'nacional';
		} else if($id_perfil == 3 || $id_perfil == 4){
			//ESTABLECIMIENTO
			$where		= array('id_establecimiento'=>$id_establecimiento);
            $bo_agrega  = 1;
            $bandeja    = 'establecimiento';
		} else if($id_perfil == 12){
			// ADMINISTRATIVO = solo ve los de su oficina
			if(!empty($id_oficina)){
				$where	= array('id_oficina'=>$id_oficina);
			}else{
				$where	= array('id_region_establecimiento'=>$id_region);
			}
            $bo_agrega  = 1;
            $bandeja    = 'administrativo';
		} else if($id_perfil == 5){
			//REGIONAL
            $where		= array('id_region'=>$id_region);
            $bo_agrega  = 1;
		} else if($id_perfil == 10){
			//SUPERVISOR
            $bo_agrega  = 1;
			if(!empty($id_oficina)){
				$where	= array('id_oficina'=>$id_oficina);
			}else{
				$where	= array('id_region'=>$id_region);
			}
		} else if($id_perfil == 6 || $id_perfil == 14){
			//FISCALIZADOR
			$where		= array('id_fiscalizador'=>$id_usuario);
            $bandeja    = 'fiscalizador';
		} else{
			//TIC SEREMI
            $where		= array('id_region'=>$id_region);
            $bandeja    = 'otro';
        }

        $arr		= $this->_DAOExpediente->getListaDetalle($where);

        $this->smarty->assign('origen', 'Registros');
		$this->smarty->assign('arrResultado', $arr);
		$this->smarty->assign('id_perfil', $id_perfil);
		$this->smarty->assign('bo_agrega', $bo_agrega);
		$this->smarty->assign('bandeja', $bandeja);
		$this->smarty->assign('smart', $this->smarty);
  
        
        if ($bandeja == "establecimiento" || $bandeja == "admin" || $bandeja == "nacional"){
            $vista_tpl = 'grilla/grilla_pacientes_supervisor.tpl';
        }else if ($bandeja == "seremi" || $bandeja == "otro"){
            $vista_tpl = 'grilla/grilla_pacientes_seremi.tpl';
        }else if ($bandeja == "administrativo"){
            $vista_tpl = 'grilla/grilla_pacientes_administrativo.tpl';
        }else{
            $vista_tpl = 'grilla/grilla_pacientes.tpl';
        }

		echo $this->smarty->display($vista_tpl);
	}

	/**
	* Descripción	: Nuevo Registro de Paciente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function nuevo() {
		Acceso::redireccionUnlogged($this->smarty);
		unset($_SESSION[SESSION_BASE]['adjuntos']);
		unset($_SESSION[SESSION_BASE]['contacto_paciente']);
		unset($_SESSION[SESSION_BASE]['animal_mordedor']);
		unset($_SESSION[SESSION_BASE]['img_map']);

		$region_usuario		= '';
		$arrComunas			= array();
		$arrRegiones		= array();
		$arrEstableSaludReg = array();
		$arrEstableSaludOfi = array();
		$es_admin			= FALSE;
        $id_region          = $_SESSION[SESSION_BASE]['id_region'];
        $id_oficina         = $_SESSION[SESSION_BASE]['id_oficina'];
        $bo_estado          = 1;
		$arrPrevision		= $this->_DAOPrevision->getLista();
		$arrPais			= $this->_DAOPais->getLista();
		$arrNacionalidad	= $this->_DAONacionalidad->getLista();
		$arrTipoSexo    	= $this->_DAOTipoSexo->getLista();
		$arrEstableSalud  	= $this->_DAOEstablecimientoSalud->getByUsuario($_SESSION[SESSION_BASE]['id'],$id_region,$bo_estado); //Para establecimiento salud
		$arrAnimalGrupo  	= $this->_DAOAnimalGrupo->getLista();
		$arrIniciaVacuna  	= $this->_DAOGeneralIniciaVacuna->getLista();
		$arrLugarMordedura	= $this->_DAOLugarMordedura->getLista();
        $arrRegiones        = $this->_DAORegion->getLista();

		if($_SESSION[SESSION_BASE]['perfil'] == '1' || $_SESSION[SESSION_BASE]['perfil'] == '7' || $_SESSION[SESSION_BASE]['perfil'] == '8'){
			$arrRegiones	= $this->_DAORegion->getLista();
			$es_admin		= TRUE;
			$arrEstableSalud = $this->_DAOEstablecimientoSalud->getNacional($bo_estado);
		}else{
			$region_usuario	= $this->_DAORegion->getById($id_region);
			$arrComunas		= $this->_DAOComuna->getByIdRegion($id_region);
            if($_SESSION[SESSION_BASE]['perfil'] == '12' || $_SESSION[SESSION_BASE]['perfil'] == '10' || $_SESSION[SESSION_BASE]['perfil'] == '4'){
                //ADMINISTRATIVO-	SUPERVISOR
                $arrEstableSaludOfi = $this->_DAOEstablecimientoSalud->getByIdOficina($id_oficina,$bo_estado);
                if(!empty($arrEstableSaludOfi)){
                    $arrEstableSalud = $arrEstableSaludOfi;
                }else{
					$arrEstableSaludReg = $this->_DAOEstablecimientoSalud->getByIdRegion($id_region,$bo_estado);
					if(!empty($arrEstableSaludReg)){
						$arrEstableSalud = $arrEstableSaludReg;
					}
				}
            }
            if($_SESSION[SESSION_BASE]['perfil'] == '5'){
                //ENCARGADO REGIONAL
                $arrEstableSaludReg = $this->_DAOEstablecimientoSalud->getByIdRegion($id_region,$bo_estado);
                if(!empty($arrEstableSaludReg)){
                    $arrEstableSalud = $arrEstableSaludReg;
                }
            }
		}

		$this->smarty->assign("bo_acepta_programa_0", "checked");
		$this->smarty->assign("arrPais", $arrPais);
		$this->smarty->assign("arrNacionalidad", $arrNacionalidad);
		$this->smarty->assign("arrTipoSexo", $arrTipoSexo);
		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign("arrComunas", $arrComunas);
		$this->smarty->assign("region_usuario",$region_usuario);
		$this->smarty->assign("es_admin", $es_admin);
		$this->smarty->assign("arrPrevision", $arrPrevision);
		$this->smarty->assign("arrEstableSalud", $arrEstableSalud);
		$this->smarty->assign("arrAnimalGrupo", $arrAnimalGrupo);
		$this->smarty->assign("arrIniciaVacuna", $arrIniciaVacuna);
		$this->smarty->assign("arrLugarMordedura", $arrLugarMordedura);
		$this->smarty->assign("id_establecimiento_sesion", $_SESSION[SESSION_BASE]['id_establecimiento']);
		$this->smarty->assign("id_region_sesion", $id_region);
		$this->smarty->assign("botonAyudaInfoMordedura", Boton::botonAyuda('Importante: Considerar que, para descartar rabia en un animal, la evidencia científica establece un plazo de observación de aproximadamente 10 días desde la mordedura.', '', 'pull-right'));
		$this->smarty->assign("botonAyudaPaciente", Boton::botonAyuda('Ingrese Datos del Paciente.', '', 'pull-right'));

		$this->_display('paciente/nuevo.tpl');
        $this->load->javascript("https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=".API_KEY,1);
		$this->load->javascript('setTimeout(function(){$("#region_paciente").trigger("change");},300);');
		$this->load->javascript('setTimeout(function(){$("#region").trigger("change");},300);');
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES . "js/imagen_mapa.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/html2canvas.min.js");
		$this->load->javascript(STATIC_FILES . "js/templates/paciente/nuevo.js");
        $this->load->javascript(STATIC_FILES . "js/contacto_paciente.js");
		$this->load->javascript(STATIC_FILES . "js/lib/validador.js");
	}

    /**
	* Descripción : Carga formulario Contacto Paciente
	* @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
    public function cargaNuevoContacto(){
        $params = $this->_request->getParams();
        $arrTipoContacto    = $this->_DAOTipoContacto->getLista();
        $arrRegiones        = $this->_DAORegion->getLista();

        if(isset($params['gl_token'])){
            $this->smarty->assign("gl_token",$params['gl_token']);
        }else{
            $this->smarty->assign("temporal",1);
        }

        $this->smarty->assign("arrTipoContacto",$arrTipoContacto);
        $this->smarty->assign("arrRegiones",$arrRegiones);
        //$this->smarty->assign("id_region_sesion", $_SESSION[SESSION_BASE]['id_region']);
        $this->load->javascript(STATIC_FILES . "js/mapa_contacto_paciente.js");
		$this->load->javascript('setTimeout(function(){$("#region_contacto").val($("#region_sesion").val());},100);');
		$this->load->javascript('setTimeout(function(){$("#region_contacto").trigger("change");},300);');
		//$this->load->javascript('setTimeout(function(){$("#comuna_contacto").val($("#comuna_paciente").val());},500);');
		//$this->load->javascript('setTimeout(function(){$("#comuna_contacto").trigger("change");},600);');
        if(isset($params['bo_direccion']) && $params['bo_direccion'] == 1){
            $this->load->javascript('setTimeout(function(){$("#tipo_contacto").val(3).trigger("change").prop("disabled",true);$("#tipo_contacto_0").hide();},500);');
            //$this->load->javascript('setTimeout(function(){$("#comuna_contacto").trigger("change");},600);');
        }

        $this->smarty->display('paciente/nuevo_contacto.tpl');
    }

    /**
	* Descripción : Guarda Contacto Paciente
	* @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
    public function guardaContactoPaciente(){
        $params             = $this->_request->getParams();
        $tipo_contacto      = (isset($params['tipo_contacto']))?$params['tipo_contacto']:3;
        $gl_token           = $params['gl_token'];
        $arr_tipo_contacto  = $this->_DAOTipoContacto->getById($tipo_contacto);
        $json               = array("correcto"=>false,"mensaje"=>"");

        if($tipo_contacto == 1){
            if(empty($params['telefono_fijo'])){
                $json["mensaje"]   = "Debe ingresar un telefono";
            }
            $arr_contacto = array("telefono_fijo"       =>$params['telefono_fijo']);
        }elseif($tipo_contacto == 2){
            if(empty($params['telefono_movil'])){
                $json["mensaje"]   = "Debe ingresar un telefono";
            }
            $arr_contacto = array("telefono_movil"      =>$params['telefono_movil']);
        }elseif($tipo_contacto == 3){
            /*
            if(empty($params['region_contacto']) || empty($params['comuna_contacto']) || empty($params['gl_direccion'])){
                $json["mensaje"]   = "Falta ingresar datos de dirección";
            }else{
            */
            $id_region_contacto = (isset($params['region_contacto']))?intval($params['region_contacto']):0;
            $id_comuna_contacto = (isset($params['comuna_contacto']))?intval($params['comuna_contacto']):0;
            
            $region = $this->_DAORegion->getById($id_region_contacto);
            $comuna = $this->_DAOComuna->getById($id_comuna_contacto);
            $arr_contacto = array(  "region_contacto"       => $id_region_contacto,
                                    "comuna_contacto"       => $id_comuna_contacto,
                                    "gl_direccion"          => (isset($params['gl_direccion']))?$params['gl_direccion']:"",
                                    "gl_datos_referencia"   => (isset($params['gl_datos_referencia']))?$params['gl_datos_referencia']:"",
                                    "gl_latitud"            => (isset($params['gl_latitud_contacto']))?$params['gl_latitud_contacto']:"",
                                    "gl_longitud"           => (isset($params['gl_longitud_contacto']))?$params['gl_longitud_contacto']:"",
                                    "gl_region"             => (isset($region->gl_nombre_region))?$region->gl_nombre_region:"",
                                    "gl_comuna"             => (isset($comuna->gl_nombre_comuna))?$comuna->gl_nombre_comuna:"",
                                    "chkNoInforma"          => (isset($params['chkNoInforma']))?$params['chkNoInforma']:0);
            //}
        }elseif($tipo_contacto == 4){
            if(empty($params['gl_email'])){
                $json["mensaje"]   = "Debe ingresar un Email";
            }
            $arr_contacto = array("gl_email"            =>$params['gl_email']);
        }elseif($tipo_contacto == 5){
            if(empty($params['gl_casilla_postal'])){
                $json["mensaje"]   = "Debe ingresar una Casilla Postal";
            }
            $arr_contacto = array("gl_casilla_postal"   =>$params['gl_casilla_postal']);
        }

        if(!empty($arr_contacto) && $json["mensaje"] == ""){
            if(!empty($gl_token)){
                $paciente = $this->_DAOPaciente->getByToken($gl_token);
                $arr_datos = array( $paciente->id_paciente,
                                    $tipo_contacto,
                                    json_encode($arr_contacto));
                $this->_DAOPacienteContacto->insertaContacto($arr_datos);
            }else{
                $arr_contacto['id_tipo_contacto']   = $tipo_contacto;
                $arr_contacto['gl_tipo_contacto']   = $arr_tipo_contacto->gl_nombre_contacto;
                if($tipo_contacto == 3){
                    $arr_contacto['gl_region']      = (isset($region->gl_nombre_region))?$region->gl_nombre_region:"";
                    $arr_contacto['gl_comuna']      = (isset($comuna->gl_nombre_comuna))?$comuna->gl_nombre_comuna:"";
                }
                if(isset($params['bo_editar']) && $params['bo_editar'] == 1){
                    unset($_SESSION[SESSION_BASE]['img_map']['mapContacto'][$params['id_contacto']]);
                    $_SESSION[SESSION_BASE]['contacto_paciente'][$params['id_contacto']]    = $arr_contacto;
                }else{
                    $_SESSION[SESSION_BASE]['contacto_paciente'][]    = $arr_contacto;
                }

            }

            $json = array("correcto"=>true,"gl_token"=>"");
        }

        echo json_encode($json);
    }

    /**
	* Descripción : Cargar Grilla Contactos de Paciente
	* @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
	public function grillaContactoPaciente(){
        $params                 = $this->_request->getParams();
        $arrContactoPaciente    = array();
        if($params['gl_token']!=""){
            $paciente = $this->_DAOPaciente->getByToken($params['gl_token']);
            $arr_contactos = $this->_DAOPacienteContacto->getByPaciente($paciente->id_paciente);
            foreach($arr_contactos AS $key=>$item){
                if($item->id_tipo_contacto == 3){ //Mostrar solo dirección
                    $json_datos                     = json_decode($item->json_dato_contacto);
                    $arr_tipo_contacto              = $this->_DAOTipoContacto->getById($item->id_tipo_contacto);
                    $json_datos['id_tipo_contacto'] = $item->id_tipo_contacto;
                    $json_datos['gl_tipo_contacto'] = $arr_tipo_contacto->gl_nombre_contacto;
                    $arrContactoPaciente[$key]      = array($json_datos);
                }
            }
            $arr = $arrContactoPaciente;
        }else{
            $arr = $_SESSION[SESSION_BASE]['contacto_paciente'];
        }
        
        $this->smarty->assign('arrContactoPaciente',$arr);
        $this->smarty->assign('gl_token',$params['gl_token']);

        if(count($arr)>0){
            echo $this->smarty->display('paciente/grilla_contacto_paciente.tpl');
        }else{
            echo '';
        }
	}

    /**
	* Descripción : ver contacto paciente de grilla
	* @author David Guzmán <david.guzman@cosof.cl> 18/05/2018
	*/
    public function verContactoPaciente(){
        $params             = $this->_request->getParams();
        $id_contacto        = $params['id_contacto'];
        $bo_ver             = (isset($params['bo_editar']))?0:1;//(Si está seteado bo_editar entonces bo_ver = 0 o sino bo_ver = 1)
        $bo_editar          = (isset($params['bo_editar']))?1:0;//(Si está seteado bo_editar entonces bo_ver = 0 o sino bo_ver = 1)
        $arr                = $_SESSION[SESSION_BASE]['contacto_paciente'][$id_contacto];
        $arrTipoContacto    = $this->_DAOTipoContacto->getLista();
        $arrRegiones        = $this->_DAORegion->getLista();

        if(isset($params['gl_token'])){
            $this->smarty->assign("gl_token",$params['gl_token']);
        }else{
            $this->smarty->assign("temporal",1);
        }

        $this->smarty->assign("bo_ver",$bo_ver);
        $this->smarty->assign("bo_editar",$bo_editar);
        $this->smarty->assign("id_contacto",$id_contacto);
        $this->smarty->assign("arr",$arr);
        $this->smarty->assign("arrTipoContacto",$arrTipoContacto);
        $this->smarty->assign("arrRegiones",$arrRegiones);
        $this->load->javascript(STATIC_FILES . "js/mapa_contacto_paciente.js");
        $this->smarty->display('paciente/nuevo_contacto.tpl');
		$this->load->javascript('$("#tipo_contacto").trigger("change");');
		$this->load->javascript('$("#chkNoInforma").trigger("change");');
        if($bo_ver == 1){
            $this->load->javascript('$("#div_body_contacto").find("input, textarea, button, select").attr("disabled","disabled");');
        }
		//$this->load->javascript('setTimeout(function(){$("#gl_latitud_animal").val();},500);');
    }

    /**
	* Descripción : Elimina de Grilla Contactos de Paciente
	* @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
	public function eliminaContactoPacienteGrilla(){
        $params         = $this->_request->getParams();
        $json           = array("correcto"=>false);
        $id_contacto    = $params['id_contacto'];
        $gl_token       = (isset($params['gl_token']))?$params['gl_token']:"";

        if($gl_token != ""){
            $this->_DAOPacienteContacto->deshabilitaById($id_contacto);
        }else{
            unset($_SESSION[SESSION_BASE]['contacto_paciente'][$id_contacto]);
            unset($_SESSION[SESSION_BASE]['img_map']['mapContacto'][$id_contacto]);
        }

        $json   = array("correcto"=>true,"gl_token"=>$gl_token);

		echo json_encode($json);
	}

    /**
	* Descripción	: Carga razas por especie Animal
	* @author		:  David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
    public function cargarRazasporEspecie(){
		$especie    = $_POST['especie'];
		$razas      = $this->_DAOAnimalRaza->getByIdEspecie($especie);
		$json		= array();
		$i			= 0;

        if(!empty($razas)){
            foreach($razas as $raza){
                $json[$i]['id_animal_raza'] = $raza->id_animal_raza;
                $json[$i]['gl_nombre']      = $raza->gl_nombre;
                $i++;
            }
        }
		echo json_encode($json);
    }

    /**
	* Descripción : Carga formulario Animal Mordedor
	* @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
    public function cargaNuevoMordedor(){

        $correcto           = false;

		$arrAnimalEspecie  	= $this->_DAOAnimalEspecie->getByEstado();
		$arrAnimalTamano  	= $this->_DAOAnimalTamano->getLista();
        $arrRegiones        = $this->_DAORegion->getLista();

		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign("arrAnimalEspecie", $arrAnimalEspecie);
		$this->smarty->assign("arrAnimalTamano", $arrAnimalTamano);
        $this->smarty->assign("id_region_sesion", $_SESSION[SESSION_BASE]['id_region']);

        $this->smarty->display('animal/nuevo_mordedor.tpl');

        /*
	if(isset($_SESSION[SESSION_BASE]['animal_mordedor']) && count($_SESSION[SESSION_BASE]['animal_mordedor'])>0){
            foreach($_SESSION[SESSION_BASE]['animal_mordedor'] AS $item){
                if(!empty($item['id_region_animal'])){
                    $correcto   = true;
                    $region     = $item['id_region_animal'];
                    $comuna     = $item['id_comuna_animal'];
                    $direccion  = $item['gl_direccion'];
                    $referencia = $item['gl_referencias_animal'];
                    $latitud    = $item['gl_latitud_animal'];
                    $longitud   = $item['gl_longitud_animal'];
                }
            }
        }elseif(isset($_SESSION[SESSION_BASE]['contacto_paciente']) && count($_SESSION[SESSION_BASE]['contacto_paciente'])>0){
            foreach($_SESSION[SESSION_BASE]['contacto_paciente'] AS $item){
                if(isset($item['region_contacto'])){
                    $correcto   = true;
                    $region     = $item['region_contacto'];
                    $comuna     = $item['comuna_contacto'];
                    $direccion  = $item['gl_direccion'];
                    $referencia = $item['gl_datos_referencia'];
                    $latitud    = $item['gl_latitud'];
                    $longitud   = $item['gl_longitud'];
                }
            }
        }

        if($correcto){
            $code_js = '$("#id_region_animal").val('.$region.');
                        $("#id_region_animal").trigger("change");
                        $("#gl_direccion").val("'.$direccion.'");
                        $("#gl_referencias_animal").val("'.$referencia.'");
                        $("#gl_latitud_animal").val("'.$latitud.'");
                        $("#gl_longitud_animal").val("'.$longitud.'");
                        setTimeout(function(){$("#id_comuna_animal").val('.$comuna.');},500);';
            $this->load->javascript($code_js);
        }else{
       
       
        }
	*/
	$this->load->javascript('setTimeout(function(){$("#id_region_animal").trigger("change");},200);');
		$this->load->javascript(STATIC_FILES . "js/templates/paciente/nuevo_animal.js");
    }

    /**
	* Descripción : Copiar direccion de paciente a la de mordedor
	* @author David Guzmán <david.guzman@cosof.cl> 18/05/2018
	*/
    public function mordedorViveConPaciente(){

        $correcto   = false;
        $region     = 0;
        $comuna     = 0;
        $direccion  = "";
        $referencia = "";
        $latitud    = "";
        $longitud   = "";

        if(isset($_SESSION[SESSION_BASE]['contacto_paciente']) && !empty($_SESSION[SESSION_BASE]['contacto_paciente'])){
            foreach($_SESSION[SESSION_BASE]['contacto_paciente'] AS $item){
                if(isset($item['region_contacto'])){
                    $correcto   = true;
                    $region     = $item['region_contacto'];
                    $comuna     = $item['comuna_contacto'];
                    $direccion  = $item['gl_direccion'];
                    $referencia = $item['gl_datos_referencia'];
                    $latitud    = $item['gl_latitud'];
                    $longitud   = $item['gl_longitud'];
                }
            }
            
            $json = array(  "correcto"=>$correcto,"region"=>$region,"comuna"=>$comuna,"direccion"=>$direccion,
                            "referencia"=>$referencia,"latitud"=>$latitud,"longitud"=>$longitud);
        }else{
            $json = array("correcto"=>false,"mensaje"=>"No ha ingresado Dirección de Paciente");
        }

        

        echo json_encode($json);
    }

    /**
	* Descripción : Guarda Animal Mordedor en SESSION
	* @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
    public function guardaAnimalMordedor(){
        $params     = $this->_request->getParams();
        $mensaje    = "";
        $json       = array("correcto"=>false,"mensaje"=>"Error, no se pudo guardar");

        if(!isset($params['bo_domicilio_conocido'])){
			$params['bo_domicilio_conocido'] = 0;
		}
		if(!isset($params['bo_vive_con_paciente'])){
			$params['bo_vive_con_paciente'] = 0;
		}
		if(!isset($params['bo_paciente_dueno'])){
			$params['bo_paciente_dueno'] = 0;
		}

		if($params['bo_vive_con_paciente'] == 1){
			$params['bo_domicilio_conocido'] = 1;
		}
		if(!isset($params['bo_ubicable'])){
			$params['bo_ubicable'] = 0;
		}
        if(isset($params['id_animal_especie']) && $params['id_animal_especie'] == 0){
            $mensaje .= "Por favor ingresar especie Animal Mordedor<br>";
        }
        if(isset($params['bo_domicilio_conocido']) && $params['bo_domicilio_conocido'] == 1){
			if($params['id_region_animal'] == 0 || $params['id_comuna_animal'] == 0 || empty($params['gl_direccion'])){
				$mensaje .= "Por favor ingresar direccion de Animal Mordedor<br>";
			}
        }
        if(isset($params['bo_ubicable']) && $params['bo_ubicable'] == 1){
			if($params['id_region_animal'] == 0){
				$mensaje .= "Por favor, si seleccionó Es Ubicable, ingresar región<br>";
			}
        }

        if($mensaje == ""){
            $arrAnimalEspecie  				= $this->_DAOAnimalEspecie->getById($params['id_animal_especie']);
            $arrAnimalRaza  				= $this->_DAOAnimalRaza->getById($params['id_animal_raza']);
            $arrAnimalTamano  				= $this->_DAOAnimalTamano->getById($params['id_animal_tamano']);
            $region             			= $this->_DAORegion->getById($params['id_region_animal']);
            $comuna             			= $this->_DAOComuna->getById($params['id_comuna_animal']);
            $params['gl_especie_animal']    = (!empty($arrAnimalEspecie))?$arrAnimalEspecie->gl_nombre:'';
            $params['gl_raza_animal']       = (!empty($arrAnimalRaza))?$arrAnimalRaza->gl_nombre:'';
            $params['gl_tamano_animal']     = (!empty($arrAnimalTamano))?$arrAnimalTamano->gl_nombre:'';
            $params['gl_region']            = (!empty($region))?$region->gl_nombre_region:'';
            $params['gl_comuna']            = (!empty($comuna))?$comuna->gl_nombre_comuna:'';
            $params['bo_ubicable']          = (!empty($comuna))?1:0;
            $obs_animal                     = $params['obs_animal'];
            $json							= array("correcto"=>true,"mensaje"=>"");

			$_SESSION[SESSION_BASE]['animal_mordedor'][]  = $params;
        }else{
            $json['mensaje'] = $mensaje;
        }

        echo json_encode($json);
    }

    /**
	* Descripción : Cargar Grilla Animales Mordedores
	* @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
	public function grillaAnimalMordedor(){
        $params     = $this->_request->getParams();

        $this->smarty->assign("arrAnimalMordedor", $_SESSION[SESSION_BASE]['animal_mordedor']);

        if(count($_SESSION[SESSION_BASE]['animal_mordedor']) > 0){
            echo $this->smarty->display('animal/grilla_animal_mordedor.tpl');
        }else{
            echo "";
        }
	}

    /**
	* Descripción : Elimina de Grilla Contactos de Paciente
	* @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
	public function eliminarAnimalGrilla(){
        $params     = $this->_request->getParams();
        $id_animal  = $params['id_animal'];

        unset($_SESSION[SESSION_BASE]['animal_mordedor'][$id_animal]);
        unset($_SESSION[SESSION_BASE]['img_map']['mapAnimal'][$id_animal]);

		echo json_encode(array("correcto"=>true));
	}

    /**
	* Descripción : Carga formulario Animal Mordedor
	* @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
	*/
    public function verAnimal(){
        $params     = $this->_request->getParams();
        $id_animal  = $params['id_animal'];
        $arr        = $_SESSION[SESSION_BASE]['animal_mordedor'][$id_animal];

		$arrAnimalEspecie  	= $this->_DAOAnimalEspecie->getLista();
		$arrAnimalEstado  	= $this->_DAOAnimalEstado->getLista();
		$arrAnimalTamano  	= $this->_DAOAnimalTamano->getLista();
        $arrRegiones        = $this->_DAORegion->getLista();
        $arrRaza            = $this->_DAOAnimalRaza->getById($arr['id_animal_raza']);
        $arrComuna          = $this->_DAOComuna->getById($arr['id_comuna_animal']);

        if(!empty($arrRaza)){
            $arr['gl_nombre_raza']  = $arrRaza->gl_nombre;
        }
        if(!empty($arrComuna)){
            $arr['gl_comuna_animal'] = $arrComuna->gl_nombre_comuna;
        }

		$this->smarty->assign("arr", $arr);
		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign("arrAnimalEspecie", $arrAnimalEspecie);
		$this->smarty->assign("arrAnimalEstado", $arrAnimalEstado);
		$this->smarty->assign("arrAnimalTamano", $arrAnimalTamano);
		$this->smarty->assign("bo_ver", 1);

        $this->smarty->display('animal/nuevo_mordedor.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/paciente/nuevo_animal.js");
        $this->load->javascript('$("#div_body_animal").find("input, textarea, button, select").attr("disabled","disabled");');
		//$this->load->javascript('setTimeout(function(){$("#gl_latitud_animal").val();},500);');
    }
	/**
	* Descripción	: Guardar Registro
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function GuardarRegistro() {
		header('Content-type: application/json');
		$params                 = $this->_request->getParams();
		$correcto               = false;
		$error                  = false;
		$id_paciente            = false;
		$viene_adjunto_fonasa   = false;
        $json_pasaporte         = array();
		$mensaje_error          = '';
		$gl_token_expediente    = '';
		$gl_descripcion			= '';
		$params['horaingreso']	= date("H:i:s", strtotime($params['horaingreso']));
        $id_animal_grupo        = $params['id_animal_grupo'];
        $arrGrupoAnimal         = $this->_DAOAnimalGrupo->getById($id_animal_grupo);
        $gl_grupo_animal        = $arrGrupoAnimal->gl_nombre;
        $estSalud               = $this->_DAOEstablecimientoSalud->getDetalleById($params['establecimientosalud']);
        $img_mapas              = $_SESSION[SESSION_BASE]['img_map'];
        $id_usuario             = $_SESSION[SESSION_BASE]['id'];
		$bo_paciente_observa	= $params['bo_paciente_observa'];
        $id_perfil              = $_SESSION[SESSION_BASE]['perfil'];
        
        if($id_animal_grupo==3){
            if(!isset($_SESSION[SESSION_BASE]['animal_mordedor']) || count($_SESSION[SESSION_BASE]['animal_mordedor'])==0){
                $mensaje_error = "Debe ingresar al menos un Animal Mordedor.";
            }
        }else {
			$bo_paciente_observa = 0;
		}
        
        if($params['bo_paciente_observa'] == 1 && empty(trim($params['telefono_paciente']))){
            $mensaje_error = "<br>- Debe ingresar <b>Teléfono de Paciente</b> si selecciona <b>SI</b> en 'observación del animal la realizará el Paciente'.";
        }

		/*
		if ($params['chkextranjero'] == "1"){
			if ($params['gl_codigo_fonasa'] != ""){
                //$adjuntos = (!empty($_SESSION['adjuntos']))?$_SESSION['adjuntos']:"";
                $json_pasaporte = json_encode(array("gl_pasaporte"=>$params['inputextranjero'],"gl_codigo_fonasa"=>$params['gl_codigo_fonasa']));
                if (!empty($_SESSION[SESSION_BASE]['adjuntos'])) {
                    foreach ($_SESSION[SESSION_BASE]['adjuntos'] as $adjunto){
                        if (($adjunto['tipo_adjunto'] == 3)){
                            $viene_adjunto_fonasa = TRUE;
                        }
                    }
                }
            }
		}
		*/

        /*
        if(!isset($_SESSION[SESSION_BASE]['contacto_paciente']) || count($_SESSION[SESSION_BASE]['contacto_paciente'])==0){
            $mensaje_error = "Debe ingresar la dirección de Paciente.";
        }
        
        if(isset($_SESSION[SESSION_BASE]['contacto_paciente'])){
            $bo_tiene_telefono  = false;
            $bo_tiene_direccion = false;
            foreach($_SESSION[SESSION_BASE]['contacto_paciente'] AS $item_contacto){
                if($item_contacto['id_tipo_contacto'] == 3){
                    $bo_tiene_direccion = true;
                }
            }
            if(!$bo_tiene_direccion){
                $mensaje_error = "Debe ingresar una dirección en contacto de Paciente.";
            }
        }
        */

		if($mensaje_error == ''){
            $gl_token_expediente    = Seguridad::generaTokenExpediente($params['establecimientosalud'],$params['fechaingreso'],$params['horaingreso']);

            $gl_rut_paciente        = $params['rut'];
            $token_paciente         = $params['token_paciente'];
            if($token_paciente != "" && $token_paciente != 0){
                //update Paciente
                $data_usuario           = array("id_region"         =>$params['region'],
                                                "id_comuna"         =>$params['comuna'],
                                                "nombres"           =>$params['nombres'],
                                                "apellido_paterno"  =>(!empty($params['apellido_paterno']))?$params['apellido_paterno']:"",
                                                "apellido_materno"  =>(!empty($params['apellido_materno']))?$params['apellido_materno']:"");

                $pac            = $this->_DAOPaciente->getByRut($gl_rut_paciente);
                $id_paciente    = $pac->id_paciente;
                $this->_DAOPaciente->updatePaciente($data_usuario,$id_paciente);
            }else{
                $gl_token_paciente      = Seguridad::generaTokenUsuario($gl_rut_paciente);
                $id_paciente_estado     = 1; //Ingresado

                //Ingreso Paciente
                $data_usuario           = array($gl_token_paciente,
                                                $gl_rut_paciente,
                                                ($params['chk_no_informado']!=1)?1:0,
                                                $params['region'],
                                                $params['comuna'],
                                                $params['id_pais_origen'],
                                                $params['id_nacionalidad'],
                                                $params['id_tipo_sexo'],
                                                $params['prevision'],
                                                $params['nombres'],
                                                (!empty($params['apellido_paterno']))?$params['apellido_paterno']:"",
                                                (!empty($params['apellido_materno']))?$params['apellido_materno']:"",
                                                $id_paciente_estado,
                                                Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento']),
                                                intval($params['edad']));

                $id_paciente        =	$this->_DAOPaciente->insertarPaciente($data_usuario);
            }

            $id_expediente_estado   = 1; //Ingresado
            $arrIniciaVacuna        =	$this->_DAOGeneralIniciaVacuna->getById($params['id_inicia_vacuna']);
            $arrLugarMordedura      =	$this->_DAOLugarMordedura->getById($params['id_lugar_mordedura']);

            $json_direccion         = array("gl_direccion"          => $params['direccion'],
                                            "gl_datos_referencia"   => (!empty($params['gl_datos_referencia']))?$params['gl_datos_referencia']:"",
                                            "gl_latitud"            => $params['gl_latitud'],
                                            "gl_longitud"           => $params['gl_longitud'],
                                            "img_direccion"         => addslashes($img_mapas['map']));

            if(!empty($params['email_paciente'])){
                $arr_tipo_contacto  = $this->_DAOTipoContacto->getById(4);
                $arr_contacto['id_tipo_contacto']   = $arr_tipo_contacto->id_tipo_contacto;
                $arr_contacto['gl_tipo_contacto']   = $arr_tipo_contacto->gl_nombre_contacto;
                $arr_contacto['gl_email']           = $params['email_paciente'];
                $_SESSION[SESSION_BASE]['contacto_paciente'][]  = $arr_contacto;
            }
            if(!empty($params['telefono_paciente'])){

                if(isset($arr_contacto['gl_email'])){
                    unset($arr_contacto['gl_email']);
                }

                $arr_tipo_contacto  = $this->_DAOTipoContacto->getById(2);
                $arr_contacto['id_tipo_contacto']   = $arr_tipo_contacto->id_tipo_contacto;
                $arr_contacto['gl_tipo_contacto']   = $arr_tipo_contacto->gl_nombre_contacto;
                $arr_contacto['telefono_movil']     = $params['telefono_paciente'];
                $_SESSION[SESSION_BASE]['contacto_paciente'][]  = $arr_contacto;
            }

            $json_paciente          = array("id_paciente"       => $id_paciente,
                                            "bo_extranjero"     => $params['chkextranjero'],
                                            "id_nacionalidad"   => $params['id_nacionalidad'],
                                            "id_pais_origen"    => $params['id_pais_origen'],
                                            "json_pasaporte"    => (!empty($json_pasaporte))?$json_pasaporte:"",
                                            "id_prevision"      => $params['prevision'],
                                            "fc_nacimiento"     => Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento']),
                                            "nr_edad"           => $params['edad'],
                                            "id_tipo_sexo"      => $params['id_tipo_sexo'],
                                            "contacto_paciente" => $_SESSION[SESSION_BASE]['contacto_paciente']);

            $json_expediente        = array("id_inicia_vacuna"          => $params['id_inicia_vacuna'],
                                            "gl_inicia_vacuna"          => $arrIniciaVacuna->gl_nombre,
                                            "id_lugar_mordedura"        => $params['id_lugar_mordedura'],
                                            "gl_lugar_mordedura"        => $arrLugarMordedura->gl_nombre,
                                            "gl_otro_lugar_mordedura"   => $params['gl_otro_lugar_mordedura'],
                                            "id_lugar_mordedura"        => $params['id_lugar_mordedura'],
                                            "gl_tipo_mordedura"         => ($params['tipo_mordedura']==0)?"Única":"Múltiple",
                                            "id_tipo_mordedura"         => $params['tipo_mordedura'],
                                            "gl_latitud"                => $params['gl_latitud'],
                                            "gl_longitud"               => $params['gl_longitud']);

            $arrAnimal              = array();

            if(isset($_SESSION[SESSION_BASE]['animal_mordedor'])){
                foreach($_SESSION[SESSION_BASE]['animal_mordedor'] as $key=>$animal){
                    $arrAnimal[$key]                                = $animal;
                    $arrAnimal[$key]['id_animal_grupo']             = $id_animal_grupo;
                    $arrAnimal[$key]['gl_grupo_animal']             = $gl_grupo_animal;
                    $arrAnimal[$key]['gl_observaciones_mordedor']   = $params['gl_observaciones_mordedor'];

                    if(!isset($animal['bo_domicilio_conocido'])){
                        $bo_domicilio_conocido                      = ($animal['bo_vive_con_paciente']==1)?1:0;
                        $arrAnimal[$key]['bo_domicilio_conocido']   = $bo_domicilio_conocido;

						$_SESSION[SESSION_BASE]['animal_mordedor'][$key]['bo_domicilio_conocido']	= $bo_domicilio_conocido;
                    }
					if ($id_animal_grupo != 3 || $arrAnimal[$key]['bo_domicilio_conocido'] != 1) {
						$bo_paciente_observa = 0;
					}
                }
            }elseif($id_animal_grupo!=3){
                $arrAnimal[1]['id_region_animal']           = $estSalud->id_region; //Region de establecimiento a animal sin direccion
                $arrAnimal[1]['id_animal_grupo']            = $id_animal_grupo;
                $arrAnimal[1]['gl_grupo_animal']            = $gl_grupo_animal;
                $arrAnimal[1]['gl_observaciones_mordedor']  = $params['gl_observaciones_mordedor'];
                $arrAnimal[1]['bo_domicilio_conocido']      = 0;
                $arrAnimal[1]['bo_paciente_dueno']          = 0;
                $arrAnimal[1]['bo_vive_con_paciente']       = 0;
                $arrAnimal[1]['id_animal_especie']          = 0;
                $arrAnimal[1]['id_animal_raza']             = 0;
                $arrAnimal[1]['id_animal_tamano']           = 0;
                $arrAnimal[1]['id_comuna_animal']           = 0;
                $arrAnimal[1]['gl_especie_animal']          = '';
                $arrAnimal[1]['gl_raza_animal']             = '';
                $arrAnimal[1]['gl_tamano_animal']           = '';
                $arrAnimal[1]['gl_region']                  = '';
                $arrAnimal[1]['gl_comuna']                  = '';
                $arrAnimal[1]['bo_ubicable']                = 0;
            }

            //Ingreso Expediente
            $id_establecimiento     = $params['establecimientosalud'];
            $establecimiento        = $this->_DAOEstablecimientoSalud->getDetalleById($id_establecimiento);
            $region_establecimiento = $establecimiento->id_region;
            $year                   = date("Y");
            $cero                   = (strlen($region_establecimiento)==1)?"0":"";
            $id_correlativo         = $this->_DAOCorrelativoFolio->insertarCorrelativo(array($year,$region_establecimiento));
            $gl_folio               = substr($year,-2).$cero.$region_establecimiento.$id_correlativo;
            $fecha_ingreso          = Fechas::formatearBaseDatosSinComilla($params['fechaingreso']);
            $bo_crea_establecimiento= ($id_perfil == 3 || $id_perfil == 4)?1:0;

            //Guarda fechas calendario vacunacion
            if($params['id_inicia_vacuna']==1){
                $fechas['dia'][0] = date("j",strtotime($fecha_ingreso));
                $fechas['mes'][0] = date("n",strtotime($fecha_ingreso));
                $fechas['ano'][0] = date("Y",strtotime($fecha_ingreso));
                $fechas['dia'][1] = date("j",strtotime($fecha_ingreso."+ 3 days"));
                $fechas['mes'][1] = date("n",strtotime($fecha_ingreso."+ 3 days"));
                $fechas['ano'][1] = date("Y",strtotime($fecha_ingreso."+ 3 days"));
                $fechas['dia'][2] = date("j",strtotime($fecha_ingreso."+ 7 days"));
                $fechas['mes'][2] = date("n",strtotime($fecha_ingreso."+ 7 days"));
                $fechas['ano'][2] = date("Y",strtotime($fecha_ingreso."+ 7 days"));
                $fechas['dia'][3] = date("j",strtotime($fecha_ingreso."+ 14 days"));
                $fechas['mes'][3] = date("n",strtotime($fecha_ingreso."+ 14 days"));
                $fechas['ano'][3] = date("Y",strtotime($fecha_ingreso."+ 14 days"));
                $fechas['dia'][4] = date("j",strtotime($fecha_ingreso."+ 28 days"));
                $fechas['mes'][4] = date("n",strtotime($fecha_ingreso."+ 28 days"));
                $fechas['ano'][4] = date("Y",strtotime($fecha_ingreso."+ 28 days"));
                $json_expediente['fechas_vacunacion'] = $fechas;
            }

            $data_expediente        = array($gl_token_expediente,
                                            $gl_folio,
                                            $id_expediente_estado,
                                            $params['establecimientosalud'],
                                            $fecha_ingreso,
                                            $params['horaingreso'],
                                            Fechas::formatearBaseDatosSinComilla($params['fechanotificacion']),
                                            $params['gl_observaciones'],
                                            Fechas::formatearBaseDatosSinComilla($params['fc_mordedura']),
                                            $params['region'],
                                            $params['comuna'],
                                            json_encode($json_direccion),
                                            json_encode($json_paciente),
                                            json_encode($json_expediente),
											$bo_paciente_observa, // new
											$bo_crea_establecimiento,
                                            $id_paciente,
                                            $params['id_inicia_vacuna']);
            $id_expediente          = $this->_DAOExpediente->insertarExpediente($data_expediente);
                    
            $this->_DAOCorrelativoFolio->actualizoIdExpediente($id_expediente,$id_correlativo);

            if($params['id_inicia_vacuna']==1){
                $nr_vacuna = 1;
                foreach($fechas['dia'] AS $key_fecha => $item_fecha){
                    $fc_mes_vacuna  = ($fechas['mes'][$key_fecha]<10)?"0".$fechas['mes'][$key_fecha]:$fechas['mes'][$key_fecha];
                    $fc_dia_vacuna  = ($fechas['dia'][$key_fecha]<10)?"0".$fechas['dia'][$key_fecha]:$fechas['dia'][$key_fecha];
                    $fc_vacuna      = $fechas['ano'][$key_fecha]."-".$fc_mes_vacuna."-".$fc_dia_vacuna;

                    $json_agenda    = array(
                                            "fc_vacuna"             => $fc_vacuna,
                                            "fc_vacuna_aplicada"    => ($key_fecha == 0)?$fc_vacuna:"",
                                            "gl_hora_vacuna"        => ($key_fecha == 0)?$params['horaingreso']:"",
                                            "id_estado"             => ($key_fecha == 0)?2:1,
                                            "nr_vacuna"             => $nr_vacuna,
                                            "bo_aplicada"           => ($key_fecha == 0)?1:0,
                                            "id_establecimiento"    => $id_establecimiento,
                                            "id_usuario_registra"   => $id_usuario,
                                            "fc_registra"           => date("Y-m-d")
                    );

                    $data_agenda    = array(
                                            "id_expediente"         => $id_expediente,
                                            "id_paciente"           => $id_paciente,
                                            "id_establecimiento"    => $id_establecimiento,
                                            "json_agenda"           => json_encode($json_agenda),
                                            "gl_observacion"        => ($key_fecha == 0)?"Se Inicia Vacunación":""
                    );

                    $this->_DAOPacienteAgenda->insertarAgenda($data_agenda);

                    if($key_fecha == 0){
                        $this->_Evento->guardar(28, $id_expediente, $id_paciente, 0, "Se aplica Vacuna 1");
                    }

                    $nr_vacuna++;
                }
            }


            //Ingreso Mordedor/es
            if($arrAnimal && count($arrAnimal) > 0){
                $i_animal = 0;
                foreach($arrAnimal as $key_mor=>$item){
                    $gl_folio_mordedor = '';
                    if ($id_animal_grupo == 3) {
                        if(!($item['id_region_animal']>0)){
                            $item['id_region_animal'] = $estSalud->id_region; //Si no tiene región ingresada, toma la de Establecimiento
                        }
                        $year                   = date("Y");
                        $cero                   = (strlen($item['id_region_animal'])==1)?"0":"";
                        $id_correlativo_mor     = $this->_DAOCorrelativoFolioMordedor->insertarCorrelativo(array($year,$item['id_region_animal']));
                        $gl_folio_mordedor      = substr($year,-2).$cero.$item['id_region_animal'].$id_correlativo_mor;
                    }
                    $gl_token_mordedor  = Seguridad::generaTokenExpedienteMordedor($key_mor,$params['fechaingreso']);

                    $json_mordedor                      = $item;
                    $json_mordedor['gl_folio_mordedor'] = $gl_folio_mordedor;
                    if(isset($img_mapas['mapAnimal'][$i_animal])){
                        $json_mordedor['img_direccion']     = addslashes($img_mapas['mapAnimal'][$i_animal]);
                    }
                    $i_animal++;

                    $id_dueno       = ($json_mordedor['bo_paciente_dueno']==1)?$id_paciente:0;

                    //Ingreso Mordedor
                    $data_mordedor  = array($gl_token_mordedor,
                                            $gl_folio_mordedor,
                                            $id_expediente,
                                            $id_paciente,
                                            $id_dueno,
                                            1, //estado = ingresado
                                            intval($item['id_region_animal']),
                                            intval($item['id_comuna_animal']),
                                            intval($item['bo_domicilio_conocido']),
                                            intval($item['bo_ubicable']),
                                            intval($item['id_animal_grupo']),
                                            json_encode($json_mordedor),
                    );

                    $id_expediente_mordedor = $this->_DAOExpedienteMordedor->insertarExpMordedor($data_mordedor);
                    
                    $this->_DAOCorrelativoFolioMordedor->actualizoIdExpedienteMordedor($id_expediente_mordedor,$id_correlativo_mor);
                }
            }
		}

		if($id_paciente && $id_expediente) {
			$correcto		= true;
			$rut			= $params['rut'];
			$codigo_fonasa	= $params['gl_codigo_fonasa'];

			if(!empty($rut)){
				$identificador	= $rut;
			}else{
				$identificador	= $codigo_fonasa;
			}

			/*GUARDADO ADJUNTOS - COMENTADO POR EL MOMENTO
             * if (!empty($_SESSION[SESSION_BASE]['adjuntos'])) {
				foreach ($_SESSION[SESSION_BASE]['adjuntos'] as $adjunto){

					$nombre_adjunto		= $adjunto['nombre_adjunto'];
					$arr_extension		= array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'bmp', 'pdf', 'txt', 'csv', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'eml');
					$nombre_adjunto		= strtolower(trim($nombre_adjunto));
					$nombre_adjunto		= trim($nombre_adjunto, ".");
					$extension			= substr(strrchr($nombre_adjunto, "."), 1);

					if ($adjunto['tipo_adjunto'] == 1){
						$gl_nombre_archivo	= 'Consentimiento_' . $identificador . '.' . $extension;
						$directorio			= "archivos/$id_paciente/";
						$gl_path			= $directorio . $gl_nombre_archivo;
						$ins_adjunto		= array('id_paciente'		=> $id_paciente,
												'id_adjunto_tipo'	=> 1,
												'gl_nombre'			=> $gl_nombre_archivo,
												'gl_path'			=> $gl_path,
												'gl_glosa'			=> 'Consentimiento Firmado',
												'sha256'			=> Seguridad::generar_sha256($gl_path),
												'fc_crea'			=> date('Y-m-d h:m:s'),
												'id_usuario_crea'	=> $_SESSION[SESSION_BASE]['id'],
											);
						$id_adjunto			= $this->_DAOAdjunto->insert($ins_adjunto);

					}else if($adjunto['tipo_adjunto'] == 3){
						$gl_nombre_archivo	= 'Archivo_Fonasa_' . $identificador . '.' . $extension;
						$directorio			= "archivos/$id_paciente/";
						$gl_path			= $directorio . $gl_nombre_archivo;
						$ins_adjunto		= array('id_paciente'		=> $id_paciente,
												'id_adjunto_tipo'	=> 3,
												'gl_nombre'			=> $gl_nombre_archivo,
												'gl_path'			=> $gl_path,
												'gl_glosa'			=> 'Archivo Fonasa',
												'sha256'			=> Seguridad::generar_sha256($gl_path),
												'fc_crea'			=> date('Y-m-d h:m:s'),
												'id_usuario_crea'	=> $_SESSION[SESSION_BASE]['id'],
											);
						$id_adjunto			= $this->_DAOAdjunto->insert($ins_adjunto);
					}

					if ($id_adjunto) {
						if (!is_dir($directorio)) {
							mkdir($directorio, 0775, true);
							chmod($directorio, 0775);

							$out = fopen($directorio . '/index.html', "w");
							fwrite($out, "<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>");
							fclose($out);
							chmod($directorio . '/index.html', 0664);
						}
						$out = fopen($gl_path, "w");
						fwrite($out, base64_decode($adjunto['contenido']));
						fclose($out);
						chmod($gl_path, 0664);
					}
				}
			}*/

            //Ingreso Datos Paciente
            $json_otros_datos = json_encode(array(  "contacto_paciente" => $_SESSION[SESSION_BASE]['contacto_paciente'],
                                                    "cantidad_contactos"=> count($_SESSION[SESSION_BASE]['contacto_paciente'])));
            $arrDatosPaciente = $this->_DAOPacienteDatos->getByIdPaciente($id_paciente);

            if($token_paciente != "" && !empty($arrDatosPaciente)){
                $datos_paciente = array("chkextranjero"     => $params['chkextranjero'],
                                        "id_nacionalidad"   => $params['id_nacionalidad'],
                                        "id_pais_origen"    => $params['id_pais_origen'],
                                        "json_pasaporte"    => (!empty($json_pasaporte))?$json_pasaporte:"",
                                        "id_prevision"      => $params['prevision'],
                                        "fc_nacimiento"     => Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento']),
                                        "edad"              => $params['edad'],
                                        "id_tipo_sexo"      => $params['id_tipo_sexo'],
                                        "json_otros_datos"  => $json_otros_datos);
                $this->_DAOPacienteDatos->updateDatos($datos_paciente,$id_paciente);
            }else{
               $datos_paciente = array($id_paciente,
                                        $params['chkextranjero'],
                                        $params['id_nacionalidad'],
                                        $params['id_pais_origen'],
                                        (!empty($json_pasaporte))?$json_pasaporte:"",
                                        $params['prevision'],
                                        Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento']),
                                        $params['edad'],
                                        $params['id_tipo_sexo'],
                                        $json_otros_datos);

                $this->_DAOPacienteDatos->insertarDatos($datos_paciente);

            }
            
            //Ingreso Contactos Paciente
            if($_SESSION[SESSION_BASE]['contacto_paciente']){
                $this->_DAOPacienteContacto->cambiaEstadoByIdPaciente($id_paciente);
                $i_contacto = 0;
                foreach($_SESSION[SESSION_BASE]['contacto_paciente'] AS $item_contacto){
                    $json_contacto_paciente = $item_contacto;
                    if(isset($img_mapas['mapContacto'][$i_contacto])){
                        $json_contacto_paciente['img_direccion'] = addslashes($img_mapas['mapContacto'][$i_contacto]);
                    }
                    $i_contacto++;
                    $arr_datos = array( $id_paciente,
                                        $item_contacto['id_tipo_contacto'],
                                        json_encode($json_contacto_paciente));
                    $this->_DAOPacienteContacto->insertaContacto($arr_datos);
                }
            }

            //Ingreso Expediente Paciente
            $bo_dueno_mordedor      = (isset($params['bo_dueno_mordedor']) && $params['bo_dueno_mordedor'] == 1)?1:0;

            $data_exp_paciente      = array($id_expediente,
                                            $id_paciente,
                                            json_encode($json_paciente));

            $id_expediente_paciente = $this->_DAOExpedientePaciente->insertarExpPaciente($data_exp_paciente);

            $expediente             = $this->_DAOExpediente->getById($id_expediente);
            $pdf                    = $this->generarPdfExpediente($expediente->gl_token);

            //Guarda historial Evento
            $id_evento_tipo = 1; //Se registra paciente
            $gl_descripcion = "Se Registra nuevo caso con Folio: ".$expediente->gl_folio;
			$this->_Evento->guardar($id_evento_tipo,$id_expediente,$id_paciente,0,$gl_descripcion);
            
            $boton_doc_inicial  = Boton::getBotonDescargaDocInicial($expediente->gl_token,"Documento Inicial","btn-primary");
            $gl_descripcion     = $gl_descripcion."<br><br>".$boton_doc_inicial;

		} else {
			$error	= true;
			if($mensaje_error == ''){
				$mensaje_error = 'Error al Guardar los datos. Favor comuníquese con Mesa de Ayuda.';
			}
		}
		$salida = array("error" => $error, "correcto" => $correcto, "mensaje_error" => $mensaje_error, "token_expediente" => $gl_token_expediente, "mensaje" => $gl_descripcion);

		$json = Zend_Json::encode($salida);
		echo $json;
	}

	/**
	* Descripción	: Ver Información de Registro
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function ver() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->request->getParametros();
        $token_expediente   = $params[0];

        //CABECERA
        $arrExpediente	= $this->_DAOExpediente->getBitacoraByToken($token_expediente,1);
        $this->smarty->assign("arr", $arrExpediente);
        $this->smarty->assign("grilla_visita",1);

		$where = array(
                "id_expediente" => $arrExpediente->id_expediente
            );
        $arrAlarmas    = $this->_DAOPacienteAlarma->getListaDetalle($where);
        if(!empty($arrAlarmas)){
        	$alarma = $arrAlarmas->row_0;
        	$gl_descripcion = "Usuario visualiza Alarma";
        	$id_evento_tipo = 20;//Se visualiza Alarma
        	$this->_Evento->guardar($id_evento_tipo, $arrExpediente->id_expediente, 0, 0, $gl_descripcion);
        	if($alarma->id_alarma_estado == 1){
        		$id_estado_alarma = 2; //Alarma visualizada
        		$this->_DAOPacienteAlarma->cambiarEstadoAlarma($alarma->id_alarma, $id_estado_alarma);
        	}
        	//$id_evento_tipo = 21;//Se Resuelve Alarma
        	//$id_estado_alarma = 4; //Alarma Resuelta
        }


        $this->smarty->display('paciente/ver.tpl');
		//$this->load->javascript(STATIC_FILES . "js/templates/paciente/ver.js");
		$this->load->javascript(STATIC_FILES . "js/templates/bitacora/mapa.js");
	}

	/**
	* Descripción	: Carga comunas por región
	* @author		: S/N
	*/
	// Buscar donde se utiliza
	public function cargarComunasPorRegion() {
		$region	= $_POST['region'];
		$comunas= $this->_DAORegion->getDetalleByIdRegion($region)->rows;
		$json	= array();
		$i		= 0;

		foreach ($comunas as $comuna) {
			$json[$i]['id_comuna']		= $comuna->id_comuna;
			$json[$i]['nombre_comuna']	= $comuna->gl_nombre_comuna;
			$i++;
		}

		echo json_encode($json);
	}

	/**
	* Descripción: Carga establecimientos de salud por comuna
	* @author: S/N
	*/
	public function cargarEstablecimientoSaludporComuna() {
		$json	= array();

		if (!empty($_POST['comuna'])) {
			$comuna             = $_POST['comuna'];
			$id_region          = $_SESSION[SESSION_BASE]['id_region'];
			$id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
            
            if($id_perfil == 13){ //ENCARGADO COMUNAL
                $estableSalud    = $this->_DAOEstablecimientoSalud->getByEncargadoComunal($comuna);
            }else{
                $estableSalud    = $this->_DAOEstablecimientoSalud->getByIdComuna($comuna);
            }

			if(empty($estableSalud)){
				$estableSalud	= $this->_DAOEstablecimientoSalud->getByIdRegion($id_region);
			}

			if(!empty($estableSalud)){
				$i = 0;
				foreach ($estableSalud as $eSalud) {
					$json[$i]['id_establecimiento']			= $eSalud->id_establecimiento;
					$json[$i]['gl_nombre_establecimiento']	= $eSalud->gl_nombre_establecimiento;
					$i++;
				}
			}
		}

		echo json_encode($json);
	}

	/**
	* Descripción	: Revisar si Existe Paciente
	* @author		: David Gusmán <david.guzman@cosof.cl>
	*/
	public function revisarExistePaciente() {
		header('Content-type: application/json');
		$json               = array();
        $params             = $this->_request->getParams();
		$rut                = $params['rut'];
        $json['correcto']   = FALSE;
        $registro           = FALSE;
        
        $json['gl_nombres']				= "";
        $json['gl_apellido_paterno']    = "";
        $json['gl_apellido_materno']    = "";

		if(!is_null($rut) && ($rut !== "")) {
			$registro	= $this->_DAOPaciente->getByRut($rut);
		}
        //SI EXISTE
		if($registro) {
            
            $arrContactos = $this->_DAOPacienteContacto->getByIdPaciente($registro->id_paciente);
            if($arrContactos){
                foreach($arrContactos as $contacto){
                    $tipo_contacto      = $contacto->id_tipo_contacto;
                    $arr_tipo_contacto  = $this->_DAOTipoContacto->getById($tipo_contacto);
                    $id                 = $contacto->id_paciente_contacto;
                    $json_contacto      = json_decode($contacto->json_dato_contacto,TRUE);
                    if($tipo_contacto == 1){
                        $json['telefono_paciente'] = $json_contacto['telefono_fijo'];
                    }elseif($tipo_contacto == 2){
                        $json['telefono_paciente'] = $json_contacto['telefono_movil'];
                    }elseif($tipo_contacto == 3){
                        $arr_contacto[$id] = array("region_contacto"    => $json_contacto['region_contacto'],
                                                "comuna_contacto"       => $json_contacto['comuna_contacto'],
                                                "gl_direccion"          => $json_contacto['gl_direccion'],
                                                "gl_datos_referencia"   => $json_contacto['gl_datos_referencia'],
                                                "gl_latitud"            => $json_contacto['gl_latitud'],
                                                "gl_longitud"           => $json_contacto['gl_longitud'],
                                                "gl_region"             => $json_contacto['gl_region'],
                                                "gl_comuna"             => $json_contacto['gl_comuna']);
                        $arr_contacto[$id]['id_tipo_contacto']   = $tipo_contacto;
                        $arr_contacto[$id]['gl_tipo_contacto']   = $arr_tipo_contacto->gl_nombre_contacto;
                    }elseif($tipo_contacto == 4){
                        $json['email_paciente'] = $json_contacto['gl_email'];
                    }
                }
                
                $_SESSION[SESSION_BASE]['contacto_paciente']    = $arr_contacto;
            }
            
			$json['gl_token']               = $registro->gl_token;
			$json['gl_nombres']				= $registro->gl_nombres;
			$json['gl_apellido_paterno']    = $registro->gl_apellido_paterno;
			$json['gl_apellido_materno']    = $registro->gl_apellido_materno;
			$json['fc_nacimiento']			= $registro->fc_nacimiento;
			$json['id_prevision']			= $registro->id_prevision;
			$json['id_pais_origen']			= $registro->id_pais_origen;
			$json['id_nacionalidad']		= $registro->id_nacionalidad;
			$json['id_tipo_sexo']           = $registro->id_tipo_sexo;
            
            $arrExpediente  = $this->_DAOExpediente->getByPaciente($registro->id_paciente);
            if(!empty($arrExpediente)){
                $json['correcto']   = TRUE;
            }
            
		}
        
        //SI EXISTE EN WS PONE LOS NOMBRES CORRESPONDIENTES Y FECHA NACIMIENTO Y SEXO
        $persona_ws = UsuarioWS::cargarPersona($rut);
            
        if(!empty($persona_ws)){
            $json['gl_nombres']				= $persona_ws->nombresPersona;
            $json['gl_apellido_paterno']    = $persona_ws->primerApellidoPersona;
            $json['gl_apellido_materno']    = $persona_ws->segundoApellidoPersona;
            $json['fc_nacimiento']          = $persona_ws->fechaNacimiento;
            $json['id_sexo']                = intval($persona_ws->codSexo);
        }
        
		echo json_encode($json);
	}

	/**
	* Descripción	: Carga información de la Paciente
	* @author		: David Gusmán <david.guzman@cosof.cl>
	*/
	public function revisarPaciente() {
		header('Content-type: application/json');
		$json		= array();
        $params             = $this->request->getParametros();
		$rut		= $params[0];
		$grilla		= "";

		if(!is_null($rut) && ($rut !== "")) {
			$registro	= $this->_DAOPaciente->getByRut($rut);
		}

        //SI EXISTE
		if($registro) {
            
            $arrExpediente  = $this->_DAOExpediente->getByPaciente($registro->id_paciente);
            
            if(!empty($arrExpediente)){
                
                $this->smarty->assign("rut", $rut);
                $this->smarty->assign("arrResultado", $arrExpediente);
                $grilla             = $this->smarty->fetch("paciente/grilla_pacientes.tpl");
                
                $json['grilla']     = $grilla;
                $json['correcto']   = TRUE;
            }
            
		} else {
			$json['correcto']   = FALSE;
		}

		echo $grilla;
	}

	/**
	* Descripción	: notificar Repetida
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function notificacionRepetida() {
		header('Content-type: application/json');
		$json		= array();
        $params     = $this->_request->getParams();
		$token		= $params['token_expediente'];
		$grilla		= "";
        $bo_evento  = 0;
        
        $arrExpediente      = $this->_DAOExpediente->getByToken($token);
        
        if($arrExpediente){
            $id_expediente      = $arrExpediente->id_expediente;
            $id_paciente        = $arrExpediente->id_paciente;
            $id_establecimiento = $arrExpediente->id_establecimiento;
            $arrEstablecimiento = $this->_DAOEstablecimientoSalud->getById($id_establecimiento);
            $gl_establecimiento = $arrEstablecimiento->gl_nombre_establecimiento;
            $gl_descripcion     = "Se Repite notificación en Establecimiento de Salud: ".$gl_establecimiento;
            
            $bo_evento = $this->_Evento->guardar(31, $id_expediente, $id_paciente, 0, $gl_descripcion);
        }
        
        if($bo_evento){
            $json['correcto']   = TRUE;
		} else {
			$json['correcto']   = FALSE;
		}

		echo json_encode($json);
	}

	/**
	* Descripción	: Carga Adjunto
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function cargarAdjunto() {
		$session				= New Zend_Session_Namespace("adj"); // Revisar si utiliza este o el que está dentro del adjunto
		$session->tipo_adjunto	= 1;
		$this->smarty->display('paciente/cargar_adjunto.tpl');
	}

	/**
	* Descripción	: Carga Adjunto Fonasa
	* @author		: orlando vazquez <orlando.vazquez@cosof.cl>
	*/
	public function cargarAdjuntoFonasa() {
		$session				= New Zend_Session_Namespace("adj");
		$session->tipo_adjunto	= 3;
		$this->smarty->display('paciente/cargar_adjunto.tpl');
	}

	/**
	* Descripción	: Guarda adjunto
	* @author		: Víctor Retamal <victor.retamal@cosof.cl>
	*/
	public function guardarAdjunto() {
		$adjunto		= $_FILES['adjunto'];
		$parametros		= $this->request->getParametros();
		$tipo_adjunto	= $parametros[0];

		if ($adjunto['tmp_name'] != "") {
			$file		= fopen($adjunto['tmp_name'], 'r+b');
			$contenido	= fread($file, filesize($adjunto['tmp_name']));
			fclose($file);

			if (!empty($contenido)) {
				$arr_adjunto			= array(
												'id_adjunto'		=> 1,
												'id_mensaje'		=> 1,
												'nombre_adjunto'	=> $adjunto['name'],
												'mime_adjunto'		=> $adjunto['type'],
												'contenido'			=> base64_encode($contenido),
												'tipo_adjunto'		=> $tipo_adjunto
											);
				$_SESSION[SESSION_BASE]['adjuntos'][]	= $arr_adjunto;
				$success				= 1;
				$mensaje				= "El archivo <strong>" . $adjunto['name'] . "</strong > ha sido Adjuntado";
			} else {
				$success				= 0;
				$mensaje				= "No se ha podido leer el archivo adjunto. Intente nuevamente";
			}
		}else{
			$success	= 0;
			$mensaje	= "Error al cargar el Adjunto. Intente nuevamente";
		}

		if ($success == 1) {
			if ($tipo_adjunto == 3){
				echo "<script>parent.cargarListadoAdjuntos('listado-adjuntos-fonasa'); parent.xModal.close();</script>";
			} else {
				echo "<script>parent.cargarListadoAdjuntos('listado-adjuntos'); parent.xModal.close();</script>";
			}
		}else{
			$this->view->assign('success', $success);
			$this->view->assign('mensaje', $mensaje);

			$this->view->assign('template', $this->view->fetch('paciente/cargar_adjunto.tpl')); // revisar ya que es forma de otro sistema de asignar
			$this->view->display('template_iframe.tpl');
		}
	}

	/**
	* Descripción	: Carga listado de Adjuntos
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function cargarListadoAdjuntos() {
		$parametros		= $this->request->getParametros();
		$tipo_adjunto	= $parametros[0];
		$adjuntos		= array();
		$template		= '';

		if (isset($_SESSION[SESSION_BASE]['adjuntos'])) {
			$template	.= '	<div class="col-xs-6 col-xs-offset-3" id="div_adjuntos" name="div_adjuntos">
									<table id="adjuntos" class="table table-hover table-condensed table-bordered" align=center>
										<thead>
											<tr>
												<th>Nombre Archivo</th>
												<th width="50px" nowrap>Descargar</th>
												<th width="50px" nowrap>Eliminar</th>
											</tr>
										</thead>
										<tbody>';
			$adjuntos	= $_SESSION[SESSION_BASE]['adjuntos'];
			$i			= 0;

			foreach ($adjuntos as $adjunto) {
				if($tipo_adjunto == $adjunto['tipo_adjunto']){
					$template	.= '			<tr>
													<td><strong>' . $adjunto['nombre_adjunto'] . '</strong></td>
													<td align="center">
														<a class="btn btn-xs btn-primary" href="javascript:void(0);" onclick="window.open(\'' . BASE_URI . '/Paciente/verAdjunto/' . $i . '\',\'_blank\');">
															<i class="fa fa-download"></i>
														</a>
													</td>
													<td align="center">
														<button class="btn btn-xs btn-danger" type="button" onclick="borrarAdjunto(' . $i . ')">
															<i class="fa fa-trash-o"></i>
														</button>
													</td>
												</tr>';
				}
				$i++;
			}

			$template	.= '			</tbody>
									</table>
								</div>';
		}

		echo $template;
	}

	/**
	* Descripción	: Borrar Adjunto
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function borrarAdjunto() {
		$parametros	= $this->request->getParametros();
		$id_adjunto = $parametros[0];
		$template	= '';

		unset($_SESSION[SESSION_BASE]['adjuntos'][$id_adjunto]);

		if (count($_SESSION[SESSION_BASE]['adjuntos']) > 0) {
			$template	.= '	<div class="col-xs-6 col-xs-offset-3" id="div_adjuntos" name="div_adjuntos">
									<table id="adjuntos" class="table table-hover table-condensed table-bordered" align=center>
										<thead>
											<tr>
												<th>Nombre Archivo</th>
												<th width="50px" nowrap>Descargar</th>
												<th width="50px" nowrap>Eliminar</th>
											</tr>
										</thead>
										<tbody>';
			$adjuntos	= $_SESSION[SESSION_BASE]['adjuntos'];
			$i			= 0;
			unset($_SESSION[SESSION_BASE]['adjuntos']);

			foreach ($adjuntos as $adjunto) {
				$_SESSION[SESSION_BASE]['adjuntos'][]	= $adjunto;
				$template				.= '<tr>
												<td><strong>' . $adjunto['nombre_adjunto'] . '</strong></td>
												<td align="center">
													<a class="btn btn-xs btn-primary" href="javascript:void(0);" onclick="window.open(\'' . BASE_URI . '/Paciente/verAdjunto/' . $i . '\',\'_blank\');">
														<i class="fa fa-download"></i>
													</a>
												</td>
												<td align="center">
													<button class="btn btn-xs btn-danger" type="button" onclick="borrarAdjunto(' . $i . ')">
														<i class="fa fa-trash-o"></i>
													</button>
												</td>
											</tr>';
				$i++;
			}

			$template	.= '				</tbody>
										</table>
									</div>';
		}else{
			echo "<script> $('#btnUploadUno').prop('disabled', false);</script>";
		}

		echo $template;
	}

	/**
	* Descripción	: Ver Adjunto
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function verAdjunto() {
		$parametros	= $this->request->getParametros();
		$id_adjunto	= $parametros[0];

		if (isset($_SESSION[SESSION_BASE]['adjuntos'][$id_adjunto])) {
			$adjunto	= $_SESSION[SESSION_BASE]['adjuntos'][$id_adjunto];

			header("Content-Type: " . $adjunto['mime_adjunto']);
			header("Content-Disposition: inline; filename=" . $adjunto['nombre_adjunto']);
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			ob_end_clean();

			echo base64_decode($adjunto['contenido']);
			exit();
		} else {
			echo "El adjunto no existe";
		}
	}

    /**
	* Descripción	: Generar PDF de Expediente con los Datos de ingreso paciente
	* @author		: David Guzmán <david.guzman@cosof.cl> 18/05/18
	* @param int $gl_token
	* @return PDF
	*/
	public function generarPdfExpediente($gl_token,$js=0) {
		$this->load->lib('Mpdf', false);

		$correcto               = false;
		$base64                 = '';
        $arr_expediente         = $this->_DAOExpediente->getDetalleByToken($gl_token);
        $arr_contacto           = $this->_DAOPacienteContacto->getByIdPaciente($arr_expediente->id_paciente);
        $adjuntos_exp           = $this->_DAOAdjunto->getByIdExpediente($arr_expediente->id_expediente);
        $correlativo            = (count((array)$adjuntos_exp))+1;
        $filename               = 'Documento_Inicial_'.$arr_expediente->gl_folio.'_'.$correlativo.'.pdf';
        $json_expediente        = json_decode($arr_expediente->json_expediente,TRUE);
        $json_mordedor          = $this->_DAOExpediente->getJsonMordedor($arr_expediente->id_expediente,0,5,true);
        $animal_grupo           = $this->_DAOAnimalGrupo->getById($json_mordedor[0]['json_mordedor']['id_animal_grupo']);
        $arr_contacto_paciente  = array();
        $gl_folio               = $arr_expediente->gl_folio;

        if(!empty($arr_contacto)){
            foreach($arr_contacto AS $key => $contacto_paciente){
                $arr_contacto_paciente[$key]['id_paciente_contacto'] = $contacto_paciente->id_paciente_contacto;
                $arr_contacto_paciente[$key]['id_tipo_contacto'] = $contacto_paciente->id_tipo_contacto;
                $arr_contacto_paciente[$key]['json_datos'] = json_decode($contacto_paciente->json_dato_contacto,TRUE);
            }
        }

		$this->smarty->assign('arr', $arr_expediente);
		$this->smarty->assign('arr_contacto_paciente', $arr_contacto_paciente);
		$this->smarty->assign('arr_pasaporte', json_decode($arr_expediente->json_pasaporte,TRUE));
		$this->smarty->assign('arr_dir_mordedura', json_decode($arr_expediente->json_direccion_mordedura,TRUE));
		$this->smarty->assign('arr_mordedor', $json_mordedor);
		$this->smarty->assign('arr_expediente', $json_expediente);
		$this->smarty->assign('gl_animal_grupo', (!empty($animal_grupo))?$animal_grupo->gl_nombre:"");

        $fecha_ingreso  = $arr_expediente->fc_ingreso;
        $fechas         = $json_expediente['fechas_vacunacion'];
        //Si Inicia vacunacion en visita (=1) muestra calendario con proximas visitas
        if(!empty($fechas) && $json_expediente['id_inicia_vacuna'] == 1){
            $calendario     = $this->creaCalendario($fecha_ingreso,$fechas);
            $mes_siguiente  = date("n",strtotime($fecha_ingreso."+ 1 month"));

            $fechas2    = array();
            $i          = 1;

            foreach($fechas['mes'] as $key => $item){
                if($mes_siguiente == $item){
                    $fechas2['dia'][$i] = $fechas['dia'][$key];
                    $fechas2['mes'][$i] = $fechas['mes'][$key];
                    $fechas2['ano'][$i] = $fechas['ano'][$key];
                    $i++;
                }
            }

            if(!empty($fechas2)){
                $fecha_ingreso = date("d-m-Y",strtotime($fechas2['dia'][1]."-".$fechas2['mes'][1]."-".$fechas2['ano'][1]));
                $nr_dosis_inicia = (count($fechas['dia'])-count($fechas2['dia']))+1;
                $calendario .= "<br>";
                $calendario .= $this->creaCalendario($fecha_ingreso,$fechas2,$nr_dosis_inicia);
            }

            $this->smarty->assign('calendario',$calendario);
        }

		$html   = $this->smarty->fetch('pdf/expediente.tpl');

        if($js == 1){
            $base64			= crear_mpdf($html, $filename, true, 'S',$gl_folio);

            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=" . $filename);
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            ob_end_clean();

            echo $base64;
        }else{
            //Guardado Fisico
            $this->comprobarDirectorio("archivos/");
            $this->comprobarDirectorio("archivos/documentos/");

            $directorio     = "archivos/documentos/expediente_".$arr_expediente->id_expediente."/";
            // comprobarDirectorio
            $this->comprobarDirectorio($directorio);

            $pdf = crear_mpdf($html, $filename, true, 'S',$gl_folio);
            $this->saveFile($directorio,$filename,$pdf);

            //Guardado Lógico
            $gl_token_adjunto = Seguridad::generaTokenAdjunto($directorio.$filename);
            $arr_data = array(  $gl_token_adjunto,
                                $arr_expediente->id_expediente,
                                0,
                                0,
                                0,
                                7, //Tipo Documento Inicial
                                $filename,
                                $directorio.$filename,
                                "",
                                0
            );
            $id_adjunto = $this->_DAOAdjunto->insertarAdjunto($arr_data);
        }
	}

    /*Crea Calendario para pdf mostrando fechas de vacunacion*/
    function creaCalendario($fecha_ingreso,$fechas,$nr_dosis_inicia=1){
        # definimos los valores iniciales para nuestro calendario

        $j = 0;
        foreach($fechas['mes'] as $key => $item){
            if($j==0){
                $diaActual      = $fechas['dia'][$key];
                $mes_actual     = $fechas['mes'][$key];
                $year           = $fechas['ano'][$key];
                $mes_siguiente  = date("n",strtotime($fecha_ingreso."+ 1 month"));
            }
            if($mes_siguiente == $item){
                unset($fechas['dia'][$key]);
                unset($fechas['mes'][$key]);
                unset($fechas['ano'][$key]);
            }
            $j++;
        }

        # Obtenemos el dia de la semana del primer dia
        # Devuelve 0 para domingo, 6 para sabado
        $diaSemana      = date("w",mktime(0,0,0,$mes_actual,1,$year))+7;
        # Obtenemos el ultimo dia del mes
        $ultimoDiaMes   = date("d",(mktime(0,0,0,$mes_actual+1,1,$year)-1));
        $last_cell      = $diaSemana + $ultimoDiaMes;

        $meses          = array(1=> "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                                    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $calendario = " <table id='calendar' width='100%' border='1' style='page-break-inside:avoid'>
                            <caption> ".$meses[$mes_actual]." ".$year." </caption>
                            <tr>
                                <th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>
                                <th>Vie</th><th>Sab</th><th>Dom</th>
                            </tr>
                            <tr bgcolor='silver'>";
        $cont       = $nr_dosis_inicia;
        for($i=1;$i<=42;$i++){
            if($i==$diaSemana){
                $day = 1;
            }
            if($i < $diaSemana || $i >= $last_cell){
                $calendario .= "<td>&nbsp;</td>";
            }else{
                if(in_array($day,$fechas['dia'])){
                    //$texto      = ($fechas['dia'][0]==$day)?"- Inicia":"- Vacuna";
                    $texto      = " (".$cont."° Dosis)";
                    $calendario .= "<td class='hoy'>$day $texto</td>";
                    $cont++;
                }else{
                    $calendario .= "<td>$day</td>";
                }
                $day++;
            }
            if($i%7==0){
                $calendario .= "</tr><tr>\n";
            }
        }

        $calendario .= "</tr></table>";

        return $calendario;
    }

    /**
	* Descripción	: ver PDF de Expediente
	* @author		: David Guzmán <david.guzman@cosof.cl> 22/05/18
	* @param string $gl_token de adjunto
	* @return PDF
	*/
	public function verPdfExpediente($gl_token_adjunto) {
		$this->load->lib('Mpdf', false);
        $adjunto = $this->_DAOAdjunto->getByToken($gl_token_adjunto);

        $fp = fopen(BASE_DIR."/".$adjunto->gl_path, 'rb');
        header("Content-Type: application/pdf");
        header("filename=".$adjunto->gl_nombre);
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: ; filename=\"".$adjunto->gl_nombre."\"");
        ob_end_clean();
        fpassthru($fp);
        exit;
	}

    public function comprobarDirectorio($directorio){
      if(!is_dir($directorio)) {
            mkdir($directorio,0775,true);
            chmod($directorio,0775);
			$this->writeFile($directorio . '/index.html',"<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>");
        }
    }

    public function saveFile($path,$filename,$data){
		$gl_path = $path.$filename;
		$this->writeFile($gl_path,$data);

		if(file_exists($gl_path)) {
			if(filesize($gl_path) > 0){
				$gl_glosa = 'Archivo Guardado';
			}else{
				$gl_glosa = 'Archivo pesa 0 KB.';
			}
		}else{
			$gl_glosa = 'Archivo no Guardado.';
		}
    }

    public function writeFile($gl_path,$data){
		$out = fopen($gl_path, "w");
		fwrite($out, $data);
		fclose($out);
		chmod($gl_path, 0664);
    }

    /**
	* Descripción	: Generar PDF de Acta Visita
	* @author		: David Guzmán <david.guzman@cosof.cl> 13/06/18
	* @param int $gl_token
	* @return PDF
	*/
	public function generarPdfActa($gl_token,$js=0) {
        ini_set("memory_limit",-1);
        ini_set('max_execution_time', 300);
		$this->load->lib('Mpdf', false);

		$correcto               = false;
		$base64                 = '';
        $arrTipoSintoma         = $this->_DAOTipoSintoma->getLista();
        $arr_expediente         = $this->_DAOExpediente->getDetalleByToken($gl_token);
        $arr_contacto           = $this->_DAOPacienteContacto->getByIdPaciente($arr_expediente->id_paciente);
        $adjuntos_exp           = $this->_DAOAdjunto->getByIdExpedienteIdFiscalizador($arr_expediente->id_expediente,$_SESSION[SESSION_BASE]['id']);
        $arrAdjunto             = array();
        $bo_existe              = false;

        if($adjuntos_exp){
            foreach($adjuntos_exp as $key => $adj){
                if($adj->id_adjunto_tipo == 2){
                    $bo_existe  = true;
                    $arrAdjunto = $adj;
                    break;
                }
            }
        }

        if($bo_existe){
            $filename           = $arrAdjunto->gl_nombre;
            $extension			= $this->_formatoArchivo->mime_content_type($filename);

            $fichero = BASE_DIR."/".$arrAdjunto->gl_path;
            if (file_exists($fichero)) {
                header("Content-Type: ".$extension);
                header("filename=".$filename);
                header("Content-Transfer-Encoding: binary");
                header('Accept-Ranges: bytes');
                header("Content-Disposition: ; filename=\"".$filename."\"");

                $pdf = file_get_contents($fichero);
                echo base64_decode($pdf);
                exit;
            }else{
                echo 'archivo no encontrado';
            }
        }else{
            $correlativo        = (count((array)$adjuntos_exp))+1;
            $filename           = 'Acta_Visita_'.$arr_expediente->gl_folio.'_'.$correlativo.'.pdf';

            $json_expediente        = json_decode($arr_expediente->json_expediente,TRUE);
            $json_mordedor          = $this->_DAOExpediente->getJsonMordedor($arr_expediente->id_expediente,$_SESSION[SESSION_BASE]['id'],5,true);
            $animal_grupo           = $this->_DAOAnimalGrupo->getById($json_mordedor[0]['json_mordedor']['id_animal_grupo']);
            $arr_dir_mordedura      = json_decode($arr_expediente->json_direccion_mordedura,TRUE);
            $arr_contacto_paciente  = array();
            $gl_folio               = $arr_expediente->gl_folio;
            $fc_mordedura           = $arr_expediente->fc_mordedura;

            if(!empty($arr_contacto)){
                foreach($arr_contacto AS $key => $contacto_paciente){
                    $arr_contacto_paciente[$key]['id_paciente_contacto'] = $contacto_paciente->id_paciente_contacto;
                    $arr_contacto_paciente[$key]['id_tipo_contacto'] = $contacto_paciente->id_tipo_contacto;
                    $arr_contacto_paciente[$key]['json_datos'] = json_decode($contacto_paciente->json_dato_contacto,TRUE);
                }
            }

            //$img_mordedura  = "<img src='".$arr_dir_mordedura['img_direccion']."'>";

            //$i = "<img src='".$i."'>";
            $this->smarty->assign('arrTipoSintoma', $arrTipoSintoma);
            $this->smarty->assign('arr', $arr_expediente);
            //$this->smarty->assign('img_mordedura', stripslashes($arr_dir_mordedura['img_direccion']));
            $this->smarty->assign('arr_contacto_paciente', $arr_contacto_paciente);
            $this->smarty->assign('arr_pasaporte', json_decode($arr_expediente->json_pasaporte,TRUE));
            $this->smarty->assign('arr_dir_mordedura', $arr_dir_mordedura);
            $this->smarty->assign('arr_mordedor', $json_mordedor);
            $this->smarty->assign('arr_expediente', $json_expediente);
            $this->smarty->assign('gl_animal_grupo', (!empty($animal_grupo))?$animal_grupo->gl_nombre:"");

            $html   = $this->smarty->fetch('pdf/acta_visita.tpl');
            //echo $html;die;

            if($js == 1){
                $base64			= crear_mpdf($html, $filename, true, 'S',$gl_folio,$fc_mordedura);

                header("Content-Type: application/pdf");
                header("Content-Disposition: inline; filename=" . $filename);
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                ob_end_clean();

                echo $base64;
            }else{
                //Guardado Fisico
                $this->comprobarDirectorio("archivos/");
                $this->comprobarDirectorio("archivos/documentos/");

                $directorio     = "archivos/documentos/expediente_".$arr_expediente->id_expediente."/";
                // comprobarDirectorio
                $this->comprobarDirectorio($directorio);

                $pdf			= base64_encode(crear_mpdf($html, $filename, true, 'S',$gl_folio,$fc_mordedura));

                $this->saveFile($directorio,$filename,$pdf);

                //Guardado Lógico
                $gl_token_adjunto = Seguridad::generaTokenAdjunto($directorio.$filename);
                $arr_data = array(  $gl_token_adjunto,
                                    $arr_expediente->id_expediente,
                                    0,
                                    0,
                                    0,
                                    2, //Tipo Acta
                                    $filename,
                                    $directorio.$filename,
                                    "",
                                    $_SESSION[SESSION_BASE]['id']
                );
                $id_adjunto = $this->_DAOAdjunto->insertarAdjunto($arr_data);

                header("Content-Type: application/pdf");
                header("Content-Disposition: inline; filename=" . $filename);
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                ob_end_clean();

                echo base64_decode($pdf);
            }
        }
	}

    public function creaImagenMapa(){
        $params     = $this->_request->getParams();
        $mensaje    = "";
        $json       = array("correcto"=>false,"mensaje"=>"Error, no se pudo guardar");

        if($params['imagen'] != ""){
            if($params['id_mapa'] == 'map'){
                $_SESSION[SESSION_BASE]['img_map'][$params['id_mapa']] = $params['imagen'];
            }else{
                $_SESSION[SESSION_BASE]['img_map'][$params['id_mapa']][] = $params['imagen'];
            }
            $json['correcto'] = true;
            $json['mensaje'] = '';
        }

        echo json_encode($json);
    }

    /**
    * Descripción : Carga formulario Contacto Paciente
    * @author David Guzmán <david.guzman@cosof.cl> 15/05/2018
    */
    public function registroAccionAlarma(){
        $params	= $this->_request->getParams();

        if(!empty($params["token_expediente"])){
            $token_expediente   = $params["token_expediente"];
            $this->smarty->assign("gl_token",$params["token_expediente"]);
        }else{
            $token_expediente	= 1;
            $this->smarty->assign("temporal",1);
        }

        $arrExpediente  = $this->_DAOExpediente->getBitacoraByToken($token_expediente);
        $where			= array("id_expediente" => $arrExpediente->id_expediente);
        $alarma			= $this->_DAOPacienteAlarma->getListaDetalle($where);
        
        $this->smarty->assign("arr", $arrExpediente);
        $this->smarty->assign("arrTipoContacto",null);
        $this->smarty->assign("id_alarma",$alarma->row_0->id_alarma);
        $this->smarty->assign("arrRegiones",null);
        $this->load->javascript(STATIC_FILES . "js/templates/alarma/alarma.js");
        //$this->load->javascript(STATIC_FILES . "js/templates/bitacora/mapa.js");

		$this->smarty->display('alarma/registro_accion_alarma.tpl');
    }

    /**
    * Descripción   : Marcar Alarma como vista
    * @author       : Pablo Jimenez <pablo.jimenez@cosof.cl>
    */
    public function cambiarEstadoAlarma(){
        $parametros = $this->_request->getParams();

        $id_alarma  = $parametros["alarma"];
        $id_estado  = $parametros["estado"];
        $fechacontacto  = (!empty($parametros["fechacontacto"]))?$parametros["fechacontacto"]:null;
        $horacontacto   = (!empty($parametros["horacontacto"]))?$parametros["horacontacto"]:null;
        $chkcontacto    = (!empty($parametros["chkcontacto"]))?(bool)$parametros["chkcontacto"]:null;
        $gl_observaciones_alarma = (!empty($parametros["gl_observaciones_alarma"]))?$parametros["gl_observaciones_alarma"]:null;
        $json_otros_datos = array();

        $response = array();

        $alarma = $this->_DAOPacienteAlarma->getById($id_alarma);

        if(!empty($alarma->json_otros_datos) || $id_estado == 2){
            $result = $this->_DAOPacienteAlarma->cambiarEstadoAlarma($id_alarma, $id_estado);
            
            //Guarda historial Evento
            $id_evento_tipo = 20; //Se Visualiza alarma
            $id_paciente    = $alarma->id_paciente;
            $id_expediente  = $alarma->id_expediente;
            $gl_descripcion = "Se marca Alarma como Visto";
			$this->_Evento->guardar($id_evento_tipo,$id_expediente,$id_paciente,0,$gl_descripcion);
        }else{
            if($chkcontacto == true){
                $json_otros_datos["bo_contacto_paciente"] = true;
                $json_otros_datos["fc_contacto_paciente"] = $fechacontacto;
                $json_otros_datos["hr_contacto_paciente"] = $horacontacto;
            }else{
                $json_otros_datos["bo_contacto_paciente"] = false;
            }
            $json_otros_datos["gl_observaciones_alarma"] = $gl_observaciones_alarma;

            $result = $this->_DAOPacienteAlarma->cambiarEstadoAlarma($id_alarma, $id_estado, $json_otros_datos);
            
            //Guarda historial Evento
            $id_evento_tipo = 21; //Se Resuelve alarma
            $id_paciente    = $alarma->id_paciente;
            $id_expediente  = $alarma->id_expediente;
            $gl_descripcion = "Se contacta a Paciente (Alarma Dejar de Vacunar)";
			$this->_Evento->guardar($id_evento_tipo,$id_expediente,$id_paciente,0,$gl_descripcion);
        }

        if($result == true){
            $response["correcto"] = true;
            $response["mensaje"]  = "Estado actualizado correctamente.";
        }
        else{
            $response["correcto"] = false;
            $response["mensaje"]  = "Ocurrió un error inesperado. Si el error persiste, contactese con Mesa de Ayuda.";
        }
        echo json_encode($response);
    }

	public function descargarDocumento($token) {
		Acceso::redireccionUnlogged($this->smarty);

		$documento			= $this->_DAOPerfilDocumento->getByToken($token);
		$token_documento	= $documento->gl_token;

		if (!empty($documento)) {
			$nombre_doc	= $documento->gl_nombre;
			$ruta_doc	= $documento->gl_path;
			$fp			= fopen($ruta_doc, 'rb');
			header("Content-Type: application/pdf");
			header("filename=".$nombre_doc);
			header("Content-Transfer-Encoding: binary");
			header("Content-Disposition: attachment; filename=\"".$nombre_doc.".pdf\"");
			ob_end_clean();
			fpassthru($fp);
		}
	}
    
    /**
	* Descripción	: Formulario de llamado cuando paciente observa a mordedor
	* @author		: David Guzmán <david.guzman@cosof.cl> - 02/04/19
	* @param        string $gl_token (expediente)
	*/
    public function llamadoPacienteObserva() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->_request->getParams();
        $token_expediente   = $params['token_expediente'];
        $arr                = $this->_DAOExpediente->getBitacoraByToken($token_expediente);
        
        $this->smarty->assign('token_expediente', $token_expediente);
        $this->smarty->assign('arr', $arr);

		$this->smarty->display('paciente/llamado_paciente_observa.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/paciente/llamado_paciente_observa.js");
	}

	/**
	* Descripción	: Guardar BD llamado de paciente observa
	* @author		: David Guzmán <david.guzman@cosof.cl> - 02/04/19
	* @param        string $gl_token (expediente) y $params
	*/
    public function llamadoPacienteObservaBD() {
        Acceso::redireccionUnlogged($this->smarty);
        $params     = $this->_request->getParams();
        $json       = array("correcto" => false,"mensaje"=>"");
        
        if(!isset($params['id_quien_llama'])){
            $json['mensaje']   = "Debe seleccionar Quién llama";
        }elseif(isset($params['id_quien_llama']) && $params['id_quien_llama'] == 2 && !isset($params['bo_paciente_contesta'])){
            $json['mensaje']   = "Debe seleccionar si paciente contesta";
        }elseif((isset($params['id_quien_llama']) && $params['id_quien_llama'] == 1
                || isset($params['bo_paciente_contesta']) && $params['bo_paciente_contesta'] == 1) && !isset($params['bo_sintomas_rabia'])){
            $json['mensaje']   = "Debe seleccionar si presenta síntomas de rabia";
        }elseif(isset($params['token_expediente']) && isset($params['token_expediente'])){
            $arrExpediente  = $this->_DAOExpediente->getDetalleByToken($params['token_expediente']);
            $id_expediente  = $arrExpediente->id_expediente;
            $id_paciente    = $arrExpediente->id_paciente;
			
            //Guardar Evento
            if(isset($params['bo_paciente_contesta']) && $params['bo_paciente_contesta'] == 0){
                $id_evento_tipo = 32; //Paciente no contesta llamado
                $gl_descripcion = "Paciente que observa no contesta llamado";
            }elseif(isset($params['bo_sintomas_rabia']) && $params['bo_sintomas_rabia'] == 1){
                $id_evento_tipo = 33; //Mordedor presenta síntomas de rabia
                $gl_descripcion = "Paciente informa que Mordedor presenta síntomas de rabia";
            }elseif(isset($params['bo_sintomas_rabia']) && $params['bo_sintomas_rabia'] == 0){
                $id_evento_tipo = 34; //Mordedor NO presenta síntomas de rabia
                $gl_descripcion = "Paciente informa que Mordedor NO presenta síntomas de rabia";
            }
            $gl_descripcion .= ($params['gl_observaciones'])?".<br> Observaciones: ".$params['gl_observaciones']:"";
            $id_evento = $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, 0, $gl_descripcion);
            
            $json['correcto']   = ($id_evento>0)?true:false;
        }
        
        echo json_encode($json);
	}

}