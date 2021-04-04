<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripción       : Controller para las funciones del ROL SUPERVISOR ESTABLECIMIENTO y RECEPTOR ESTABLECIMIENTO
 *
 * Plataforma        : PHP
 * 
 * Creación          : 01/06/2018
 * 
 * @name             Reportes.php
 * 
 * @version          1.0.0
 *
 * @author           Victor Retamal <victor.retamal@cosof.cl>
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
class Reportes extends Controller {
		
	//protected $_Evento;
    protected $_DAOExpediente;
    protected $_DAOExpedienteEstado;
    protected $_DAOExpedienteMordedor;
    protected $_DAOUsuario;
    protected $_DAORegion;
    protected $_DAOOficina;
    protected $_DAOComuna;
    protected $_DAOVisita;
    protected $_DAOInforme;
    protected $_DAOVisitaTipoResultado;
    protected $_DAOEstablecimientoSalud;
    protected $_DAOAccesoPerfil;
    protected $_DAOVisitaAnimalMordedor;
    protected $_DAOTipoSexo;
    protected $_DAOServicioSalud;

	function __construct() {
		parent::__construct();
		$this->load->lib('Fechas', false);

		//$this->_Evento							= new Evento();
		$this->_DAOExpediente           = $this->load->model("DAOExpediente");
		$this->_DAOExpedienteMordedor   = $this->load->model("DAOExpedienteMordedor");
		$this->_DAOExpedienteEstado     = $this->load->model("DAOExpedienteEstado");
		$this->_DAOUsuario              = $this->load->model("DAOAccesoUsuario");
		$this->_DAORegion               = $this->load->model("DAODireccionRegion");
		$this->_DAOComuna               = $this->load->model("DAODireccionComuna");
		$this->_DAOOficina              = $this->load->model("DAODireccionOficina");
		$this->_DAOVisita               = $this->load->model("DAOVisita");
		$this->_DAOVisitaTipoResultado  = $this->load->model("DAOVisitaTipoResultado");
		$this->_DAOInforme              = $this->load->model("DAOInforme");
		$this->_DAOEstablecimientoSalud = $this->load->model("DAOEstablecimientoSalud");
		$this->_DAOAccesoPerfil			= $this->load->model("DAOAccesoPerfil");
		$this->_DAOVisitaAnimalMordedor = $this->load->model("DAOVisitaAnimalMordedor");
		$this->_DAOTipoSexo             = $this->load->model("DAOTipoSexo");
		$this->_DAOServicioSalud        = $this->load->model("DAOServicioSalud");
	}

	/**
	* Descripción	: Cargar Grilla Pacientes de Tratamiento
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function index() {
		Acceso::redireccionUnlogged($this->smarty);
	}
	
	public function graficos() {
        Acceso::redireccionUnlogged($this->smarty);        
        $arrRegiones        = $this->_DAORegion->getLista();
        $arrEstados         = $this->_DAOExpedienteEstado->getLista();
        $arrResulVisita     = $this->_DAOVisitaTipoResultado->getLista();
        $id_region          = $_SESSION[SESSION_BASE]["id_region"];
        $id_oficina         = $_SESSION[SESSION_BASE]["id_oficina"];
        $id_comuna          = $_SESSION[SESSION_BASE]["id_comuna"];
        $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
        $bo_nacional        = $_SESSION[SESSION_BASE]['bo_nacional'];
        $bo_oficina         = isset($_SESSION[SESSION_BASE]['bo_oficina'])?$_SESSION[SESSION_BASE]['bo_oficina']:0;
        $bo_comunal         = $_SESSION[SESSION_BASE]['bo_comunal'];
        $id_servicio        = $_SESSION[SESSION_BASE]['id_servicio'];
		$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getListaOrdenada();
		$perfil 			= $this->_DAOAccesoPerfil->getById($_SESSION[SESSION_BASE]['perfil']);
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
        $id_usuario         = $_SESSION[SESSION_BASE]['id'];
        
        $arrComuna          = array();
        $arrOficina         = array();
        $arrServicio        = array();
        $bo_fiscalizador    = ($id_perfil == 6 || $id_perfil == 14)?true:false;
        $bo_establecimiento = ($id_perfil == 3 || $id_perfil == 4)?true:false;
        $arrFiscalizador    = array();

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
            if($id_perfil == 13){
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
        
        if($id_perfil == 15){
            $arrRegiones        = array();
            $arrRegiones[]      = $this->_DAORegion->getById($id_region);
            //$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getByIdServicio($id_servicio);
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByIdRegionAndServicio($id_region,$id_servicio);
            if($arrServicio){
                foreach($arrServicio as $key=>$ser){
                    if($ser->id_servicio != $id_servicio)
                        unset($arrServicio->$key);
                }
            }
        }
        
		$this->smarty->assign('arrRegiones', $arrRegiones);
        $this->smarty->assign('arrOficina', $arrOficina);
        $this->smarty->assign('arrComuna', $arrComuna);
        $this->smarty->assign('arrServicio', $arrServicio);
		$this->smarty->assign('arrEstableSalud', $arrEstableSalud);
		$this->smarty->assign('arrEstados', $arrEstados);
		$this->smarty->assign('id_servicio',$id_servicio);
		$this->smarty->assign('arrResulVisita', $arrResulVisita);
		$this->smarty->assign('origen', 'Graficos');
		$this->smarty->assign('id_perfil', $id_perfil);


		/**********************************************************/
        //$arr_estados_visitas        = $this->_DAOExpedienteMordedor->getListaEstadoVisitas();
        $arr_visitas    = array(
                array("total" => 0, "nombre" => "No Sospechoso"),
                array("total" => 0, "nombre" => "Sospechoso"),
                array("total" => 0, "nombre" => "Visita Perdida"),
                array("total" => 0, "nombre" => "Se Niega a Visita"),
            );
        $arr_docimicilios = array(
                array("total" => 0, "nombre" => "No Conocido"),
                array("total" => 0, "nombre" => "Conocido"),
            );
        
        /*************************************************************/

		$this->_display('reportes/graficos.tpl');
        
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES . "js/templates/reportes/graficos.js");
		$this->load->javascript(STATIC_FILES.'js/plugins/amcharts/amcharts.js');
        $this->load->javascript(STATIC_FILES.'js/plugins/amcharts/pie.js');
        $this->load->javascript(STATIC_FILES.'js/plugins/amcharts/serial.js');
        $this->load->javascript(STATIC_FILES.'js/plugins/amcharts/themes/light.js');
        $this->load->javascript(STATIC_FILES.'js/plugins/amcharts/lang/es.js');

        $jscode1     = 'Reportes.graficarVisitasMordedores('.json_encode($arr_visitas).');'; 
        $jscode2     = 'Reportes.graficarDomicilios('.json_encode($arr_docimicilios).');';
        $this->load->javascript($jscode1);
        $this->load->javascript($jscode2);

    }
    
	public function graficar() {
        $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
        $id_comuna          = $_SESSION[SESSION_BASE]['id_comuna'];
        $params             = $this->_request->getParams();
        
        if($id_perfil == 13 && empty($params['id_establecimiento'])){
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByEncargadoComunal($id_comuna);
            foreach($arrEstableSalud as $item){
                $arr_establecimiento[] = $item->id_establecimiento;
            }
            $params['in_establecimiento']   = implode(",",$arr_establecimiento);
        }
        
        $arr_domicilios         = $this->_DAOExpedienteMordedor->getGraficoReportes($params);
        $arr_visitas            = $this->_DAOExpedienteMordedor->getGraficoVisitasRealizadas($params);
        $arr_establecimientos   = $this->_DAOExpedienteMordedor->getGrillaEstablecimientos($params);
        
        $this->smarty->assign('arrEstablecimientos', $arr_establecimientos);
		$grillaEstablecimientos = $this->smarty->fetch('reportes/grillaEstablecimientos.tpl');
        
        $json = array(
                    "arrVisitasMordedores"      => $arr_visitas,
                    "arrDomicilios"             => $arr_domicilios,
                    "grillaEstablecimientos"    => $grillaEstablecimientos
        		);
        
		echo json_encode($json);
	}
	
	public function informes() {
        Acceso::redireccionUnlogged($this->smarty);
        $arrRegiones        = $this->_DAORegion->getLista();
        $arrEstados         = $this->_DAOExpedienteEstado->getLista();
        $arrResulVisita     = $this->_DAOVisitaTipoResultado->getLista();
        $id_region          = $_SESSION[SESSION_BASE]["id_region"];
        $id_oficina         = $_SESSION[SESSION_BASE]["id_oficina"];
        $id_comuna          = $_SESSION[SESSION_BASE]["id_comuna"];
        $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
        $bo_nacional        = $_SESSION[SESSION_BASE]['bo_nacional'];
        $bo_oficina         = isset($_SESSION[SESSION_BASE]['bo_oficina'])?$_SESSION[SESSION_BASE]['bo_oficina']:0;
        $bo_comunal         = $_SESSION[SESSION_BASE]['bo_comunal'];
        $id_servicio        = $_SESSION[SESSION_BASE]['id_servicio'];
		$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getListaOrdenada();
		$perfil 			= $this->_DAOAccesoPerfil->getById($_SESSION[SESSION_BASE]['perfil']);
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
        $id_usuario         = $_SESSION[SESSION_BASE]['id'];
        
        $arrComuna          = array();
        $arrOficina         = array();
        $arrServicio        = array();
        $bo_fiscalizador    = ($id_perfil == 6 || $id_perfil == 14)?true:false;
        $bo_establecimiento = ($id_perfil == 3 || $id_perfil == 4)?true:false;
        $arrFiscalizador    = array();

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
            if($id_perfil == 13){
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
        
        if($id_perfil == 15){
            $arrRegiones        = array();
            $arrRegiones[]      = $this->_DAORegion->getById($id_region);
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByIdRegionAndServicio($id_region,$id_servicio);
            if($arrServicio){
                foreach($arrServicio as $key=>$ser){
                    if($ser->id_servicio != $id_servicio)
                        unset($arrServicio->$key);
                }
            }
        }
        
		$this->smarty->assign('arrRegiones', $arrRegiones);
        $this->smarty->assign('arrOficina', $arrOficina);
        $this->smarty->assign('arrComuna', $arrComuna);
        $this->smarty->assign('arrServicio', $arrServicio);
		$this->smarty->assign('arrEstados', $arrEstados);
		$this->smarty->assign('arrEstableSalud', $arrEstableSalud);
		$this->smarty->assign('arrResulVisita', $arrResulVisita);
		$this->smarty->assign('id_servicio',$id_servicio);
		$this->smarty->assign('origen', 'Informes');
		$this->smarty->assign('id_perfil', $id_perfil);

		$this->_display('reportes/informes.tpl');
        
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES . "js/templates/reportes/informes.js");
	}
	
	public function muestraInformes_OLD() {
		$params                 = $this->_request->getParams();        
        $params['fc_inicio']    = Fechas::formatearBaseDatosSinComilla($params['fc_inicio']);
        $params['fc_termino']   = Fechas::formatearBaseDatosSinComilla($params['fc_termino']);
        $bo_regional            = (isset($_SESSION[SESSION_BASE]['bo_regional']))?$_SESSION[SESSION_BASE]['bo_regional']:0;
        $bo_oficina             = (isset($_SESSION[SESSION_BASE]['bo_oficina']))?$_SESSION[SESSION_BASE]['bo_oficina']:0;
        $id_region              = (isset($_SESSION[SESSION_BASE]['id_region']))?$_SESSION[SESSION_BASE]['id_region']:0;
        
        $arrInforme         = $this->_DAOInforme->getInforme($params);

        $arrRegiones        = $this->_DAORegion->getLista();
        $arr = array();
        foreach($arrRegiones AS $region){
            //Si es regional = muestra su region y si NO es regional = muestra todas
            if((($bo_regional || $bo_oficina) && $id_region == $region->id_region) || (!$bo_regional && !$bo_oficina)){
                $arr[$region->id_region] = (object)array(   "id_region"         =>$region->id_region,
                                                            "gl_region"         =>$region->gl_nombre_region,
                                                            "nr_observables"    =>0,
                                                            "total_mordedores"  =>0
                );
                if(!empty($arrInforme)){
                    foreach($arrInforme AS $informe){
                        if($region->id_region == $informe->id_region){
                            $arr[$region->id_region]->nr_domicilio_conocido     = $informe->nr_domicilio_conocido;
                            $arr[$region->id_region]->nr_domicilio_desconocido  = $informe->nr_domicilio_desconocido;
                            $arr[$region->id_region]->nr_chipeados              = $informe->nr_chipeados;
                            $arr[$region->id_region]->total_mordedores          = $informe->total_mordedores;
                        }
                    }
                }
            }
        }
        
        $this->smarty->assign('arrInforme', $arr);
		echo $this->smarty->display('reportes/grilla_informe.tpl');
	}

	public function muestraInformes() {
        $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
        $id_comuna          = $_SESSION[SESSION_BASE]['id_comuna'];
        $params             = $this->_request->getParams();
        
        if($id_perfil == 13 && empty($params['id_establecimiento'])){
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByEncargadoComunal($id_comuna);
            foreach($arrEstableSalud as $item){
                $arr_establecimiento[] = $item->id_establecimiento;
            }
            $params['in_establecimiento']   = implode(",",$arr_establecimiento);
        }      
        //$bo_regional            = (isset($_SESSION[SESSION_BASE]['bo_regional']))?$_SESSION[SESSION_BASE]['bo_regional']:0;
        //$bo_oficina             = (isset($_SESSION[SESSION_BASE]['bo_oficina']))?$_SESSION[SESSION_BASE]['bo_oficina']:0;
        //$id_region              = (isset($_SESSION[SESSION_BASE]['id_region']))?$_SESSION[SESSION_BASE]['id_region']:0;
        
        //$arr_visitas    		= $this->_DAOExpedienteMordedor->getReporteVisitas($params);
        $arrRegiones        	= $this->_DAORegion->getLista();
        $id_region              = $params["id_region"];
        
        $arr = array();
        foreach($arrRegiones AS $region){
            $params['id_region']    = $id_region;
            //Si es regional = muestra su region y si NO es regional = muestra todas
            //if((($bo_regional || $bo_oficina) && $id_region == $region->id_region) || (!$bo_regional && !$bo_oficina)){
            if($params["id_region"] == $region->id_region || empty($params["id_region"])){
                
                $arr[$region->id_region] = (object)array(   "id_region"                 => $region->id_region,
                                                            "gl_region"                 => $region->gl_nombre_region,
                                                            "nr_domicilio_conocido"     => 0,
                                                            "nr_domicilio_desconocido"  => 0,
                                                            "nr_chipeados"              => 0,
                                                            "total_mordedores"          => 0
                );
                
                $params["id_region"]    = $region->id_region;
                $arr_visitas            = $this->_DAOExpedienteMordedor->getReporteVisitas($params);
                
                if(!empty($arr_visitas)){
                    foreach($arr_visitas AS $visita){
                        $arr_visita = (array)$visita;
                        if($region->id_region == $arr_visita["id_region"]){
                            $arr[$region->id_region]->nr_domicilio_conocido     = $arr[$region->id_region]->nr_domicilio_conocido + $arr_visita["conocido"];
                            $arr[$region->id_region]->nr_domicilio_desconocido  = $arr[$region->id_region]->nr_domicilio_desconocido + $arr_visita["no_conocido"];
                            $arr[$region->id_region]->nr_chipeados              = $arr[$region->id_region]->nr_chipeados + $arr_visita["nr_chipeados"];
                            $arr[$region->id_region]->total_mordedores          = $arr[$region->id_region]->total_mordedores + $arr_visita["cant_total"];
                        }
                    }
                }
            }            
        }
        
        $this->smarty->assign('arrInforme', $arr);
		echo $this->smarty->display('reportes/grilla_informe.tpl');
	}

	public function establecimientosNotifican() {
        $params     = $this->_request->getParams();        
        $arr        = $this->_DAOExpedienteMordedor->getEstablecimientosNotifican($params);
        
        $this->smarty->assign('arrEstablecimientosNotifican', $arr);
		echo $this->smarty->display('reportes/establecimientosNotifican.tpl');
	}

	public function reporteVisitas_OLD() {
		$params                 = $this->_request->getParams();
        $arr_visitas_comuna1    = $this->_DAOExpedienteMordedor->getVisitasComunal($params);
        $arr_visitas_comuna2    = $this->_DAOExpedienteMordedor->getNotificacionesComunal($params);
        $arr_visitas_comuna     = array();
        $arr_visitas_comuna     = array();
        
            
        //GRILLA POR COMUNA
        if($arr_visitas_comuna1){
            foreach($arr_visitas_comuna1 as $visita){
                $arr = (array)$visita;
                $arr_visitas_comuna[$arr['id_comuna']]                  = $arr;
                $arr_visitas_comuna[$arr['id_comuna']]['conocido']      = 0;
                $arr_visitas_comuna[$arr['id_comuna']]['no_conocido']   = 0;
            }
        }
        if($arr_visitas_comuna2){
            foreach($arr_visitas_comuna2 as $visita){
                $arr = (array)$visita;
                $arr_visitas_comuna[$arr['id_comuna']]['conocido']      = $arr['Conocido'];
                $arr_visitas_comuna[$arr['id_comuna']]['no_conocido']   = $arr['No Conocido'];
                if(!isset($arr_visitas_comuna[$arr['id_comuna']]['comuna'])){
                    $arr_visitas_comuna[$arr['id_comuna']]['comuna']            = $arr['comuna'];
                    $arr_visitas_comuna[$arr['id_comuna']]['Positivo']          = 0;
                    $arr_visitas_comuna[$arr['id_comuna']]['Negativo']          = 0;
                    $arr_visitas_comuna[$arr['id_comuna']]['No Sospechoso']     = 0;
                    $arr_visitas_comuna[$arr['id_comuna']]['Sospechoso']        = 0;
                    $arr_visitas_comuna[$arr['id_comuna']]['Visita Perdida']    = 0;
                    $arr_visitas_comuna[$arr['id_comuna']]['Se Niega a Visita'] = 0;
                    $arr_visitas_comuna[$arr['id_comuna']]['cant_total']        = 0;
                }
            }
        }

        $this->smarty->assign('arr_visitas_comuna', $arr_visitas_comuna);
		echo $this->smarty->display('home/grillaVisitas.tpl');
	}

	public function reporteVisitas() {
        $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
        $id_comuna          = $_SESSION[SESSION_BASE]['id_comuna'];
        $params             = $this->_request->getParams();
        
        if($id_perfil == 13 && empty($params['id_establecimiento'])){
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByEncargadoComunal($id_comuna);
            foreach($arrEstableSalud as $item){
                $arr_establecimiento[] = $item->id_establecimiento;
            }
            $params['in_establecimiento']   = implode(",",$arr_establecimiento);
        }
        $arr_visitas    		= $this->_DAOExpedienteMordedor->getReporteVisitas($params);
        $arr_visitas_comuna     = array();
        
        //GRILLA POR COMUNA
        if($arr_visitas){
            foreach($arr_visitas as $visita){
                $arr = (array)$visita;
                $arr_visitas_comuna[$arr['id_comuna']]['conocido']      = $arr['conocido'];
                $arr_visitas_comuna[$arr['id_comuna']]['no_conocido']   = $arr['no_conocido'];
                if(!isset($arr_visitas_comuna[$arr['id_comuna']]['comuna'])){
                	/*if(empty($arr['comuna']) && $arr["conocido"]>0){
                		file_put_contents('php://stderr', PHP_EOL . print_r($arr, TRUE). PHP_EOL, FILE_APPEND);
                	}*/
                    $arr_visitas_comuna[$arr['id_comuna']]['comuna']            = $arr['comuna'];
                    $arr_visitas_comuna[$arr['id_comuna']]['Positivo']          = $arr['Positivo'];
                    $arr_visitas_comuna[$arr['id_comuna']]['Negativo']          = $arr['Negativo'];
                    $arr_visitas_comuna[$arr['id_comuna']]['No Sospechoso']     = $arr['No Sospechoso'];
                    $arr_visitas_comuna[$arr['id_comuna']]['Sospechoso']        = $arr['Sospechoso'];
                    $arr_visitas_comuna[$arr['id_comuna']]['Visita Perdida']    = $arr['Visita Perdida'];
                    $arr_visitas_comuna[$arr['id_comuna']]['Se Niega a Visita'] = $arr['Se Niega a Visita'];
                    $arr_visitas_comuna[$arr['id_comuna']]['cant_total']        = $arr['cant_total'];
                }
            }
        }

        $this->smarty->assign('arr_visitas_comuna', $arr_visitas_comuna);
		echo $this->smarty->display('home/grillaVisitas.tpl');
	}

	public function reporteVisitasOficinas() {
		$id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
        $id_comuna          = $_SESSION[SESSION_BASE]['id_comuna'];
        $params             = $this->_request->getParams();
        
        if($id_perfil == 13 && empty($params['id_establecimiento'])){
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByEncargadoComunal($id_comuna);
            foreach($arrEstableSalud as $item){
                $arr_establecimiento[] = $item->id_establecimiento;
            }
            $params['in_establecimiento']   = implode(",",$arr_establecimiento);
        }
        
		if($id_perfil == 1 || $id_perfil == 7 || $id_perfil == 8){ //NACIONAL O ADMIN
            $bandeja    = ($id_perfil == 1)?'admin':'nacional';
		} else if($id_perfil == 3 || $id_perfil == 4 || $id_perfil == 12){ //SUPERVISOR ESTABLEC - RECEPTOR ESTABLEC - ADMINISTRATIVO
            $bandeja    = 'establecimiento';
		} else if($id_perfil == 5 || $id_perfil == 10){ //REGIONAL SEREMI O SUPERVISOR SEREMI
            $bandeja    = 'seremi';
		} else if($id_perfil == 6 || $id_perfil == 14){ //FISCALIZADOR
            $bandeja    = 'fiscalizador';
		} else{ //TIC SEREMI
            $bandeja    = 'otro';
        }
        
        //$arr_visitas    = $this->_DAOExpedienteMordedor->getVisitasOficinal($params);
        $arr_visitas    = $this->_DAOExpedienteMordedor->getReporteVisitas($params);
        $arr_visitas_oficina     = array();
            
        //GRILLA POR oficina
        if($arr_visitas){
            foreach($arr_visitas as $visita){
                $arr = (array)$visita;
                $arr_visitas_oficina[$arr['region']][$arr['oficina']][$arr['comuna']]['conocido']      = $arr['conocido'];
                $arr_visitas_oficina[$arr['region']][$arr['oficina']][$arr['comuna']]['no_conocido']   = $arr['no_conocido'];
            }
        }

        $this->smarty->assign('arr_visitas_oficinas', $arr_visitas_oficina);
        
        $this->smarty->assign('bandeja', $bandeja);
		echo $this->smarty->display('reportes/grillaVisitasOficinas.tpl');
	}

	public function reporteVisitasOficinas_old() {
        
		$params                 = $this->_request->getParams();

		$id_perfil          = $_SESSION[SESSION_BASE]['perfil'];

        $bo_establecimiento     =  $_SESSION[SESSION_BASE]["bo_establecimiento"];
        $bo_nacional            =  $_SESSION[SESSION_BASE]["bo_nacional"];
        $bo_regional            =  $_SESSION[SESSION_BASE]["bo_regional"];
        $bo_oficina             =  $_SESSION[SESSION_BASE]["bo_oficina"];
        $bo_seremi              =  $_SESSION[SESSION_BASE]["bo_seremi"];

		if($id_perfil == 1 || $id_perfil == 7 || $id_perfil == 8){ //NACIONAL O ADMIN
            $bandeja    = ($id_perfil == 1)?'admin':'nacional';
		} else if($id_perfil == 3 || $id_perfil == 4 || $id_perfil == 12){ //SUPERVISOR ESTABLEC - RECEPTOR ESTABLEC - ADMINISTRATIVO
            $bandeja    = 'establecimiento';
		} else if($id_perfil == 5 || $id_perfil == 10){ //REGIONAL SEREMI O SUPERVISOR SEREMI
            $bandeja    = 'seremi';
		} else if($id_perfil == 6 || $id_perfil == 14){ //FISCALIZADOR
            $bandeja    = 'fiscalizador';
		} else{ //TIC SEREMI
            $bandeja    = 'otro';
        }

        $arr_estados_visitas        = $this->_DAOExpedienteMordedor->getVisitasOficinal($params);
        $arr_visitas_oficinas = array();
        if($arr_estados_visitas){
        	foreach($arr_estados_visitas as $visita){
        		$arr_visitas_oficinas[$visita->nombre_oficina]["id_oficina"] = $visita->id_oficina;
        		$arr_visitas_oficinas[$visita->nombre_oficina]["region"] = $visita->region;
        		$arr_visitas_oficinas[$visita->nombre_oficina]["con_domicilio"] = 0;
        		$arr_visitas_oficinas[$visita->nombre_oficina]["sin_domicilio"] = 0;
        		$arr_visitas_oficinas[$visita->nombre_oficina]["total"] = 0;
        		$arr_visitas_oficinas[$visita->nombre_oficina][$visita->comuna] = array(
                    "con_domicilio" => 0,
                    "sin_domicilio" => 0,
                    "total" => 0
                );
            }
            foreach($arr_estados_visitas as $visita){
                $arr_visitas_oficinas[$visita->nombre_oficina]['total'] += 1; 

                if($visita->estado_visita != "No Realizada"){
                    if($visita->bo_domicilio_conocido == 0){
                        $arr_visitas_oficinas[$visita->nombre_oficina][$visita->comuna]['sin_domicilio'] += 1; 
                        $arr_visitas_oficinas[$visita->nombre_oficina]['sin_domicilio'] += 1; 
                    }else{
                        $arr_visitas_oficinas[$visita->nombre_oficina][$visita->comuna]['con_domicilio'] += 1; 
                        $arr_visitas_oficinas[$visita->nombre_oficina]['con_domicilio'] += 1; 
                    }
                }
            }
        }
        $this->smarty->assign("arr_visitas_oficinas", $arr_visitas_oficinas);
        $this->smarty->assign('bandeja', $bandeja);
		echo $this->smarty->display('reportes/grillaVisitasOficinas.tpl');
	}
	
	public function exportar() {
		//ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 3600);
		set_time_limit(3600); //SI ES MUY GRANDE EL EXCEL
		
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		
		Acceso::redireccionUnlogged($this->smarty);
		$this->load->lib('Helpers/Validar', false);
		$mostrar            = 0;
		$bool_region        = 0;
		$parametros         = $this->_request->getParams();
		$id_region          = $_SESSION[SESSION_BASE]["id_region"];
        $id_oficina         = $_SESSION[SESSION_BASE]["id_oficina"];
        $id_comuna          = $_SESSION[SESSION_BASE]["id_comuna"];
        $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
        $bo_nacional        = $_SESSION[SESSION_BASE]['bo_nacional'];
        $bo_oficina         = isset($_SESSION[SESSION_BASE]['bo_oficina'])?$_SESSION[SESSION_BASE]['bo_oficina']:0;
        $bo_comunal         = $_SESSION[SESSION_BASE]['bo_comunal'];
        $id_servicio        = $_SESSION[SESSION_BASE]['id_servicio'];
		$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getListaOrdenada();
		$perfil 			= $this->_DAOAccesoPerfil->getById($_SESSION[SESSION_BASE]['perfil']);
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
        $id_usuario         = $_SESSION[SESSION_BASE]['id'];
        $arrRegiones        = $this->_DAORegion->getLista();
        
        $arrComuna          = array();
        $arrOficina         = array();
        $arrServicio        = array();
        $bo_fiscalizador    = ($id_perfil == 6 || $id_perfil == 14)?true:false;
        $bo_establecimiento = ($id_perfil == 3 || $id_perfil == 4)?true:false;
        $arrFiscalizador    = array();

        if($id_region > 0 && !$bo_nacional && !$bo_establecimiento){
            $bool_region        = 1;
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
            if($id_perfil == 13){
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
        
        if($id_perfil == 15){
            $arrRegiones        = array();
            $arrRegiones[]      = $this->_DAORegion->getById($id_region);
            //$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getByIdServicio($id_servicio);
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByIdRegionAndServicio($id_region,$id_servicio);
            if($arrServicio){
                foreach($arrServicio as $key=>$ser){
                    if($ser->id_servicio != $id_servicio)
                        unset($arrServicio->$key);
                }
            }
        }
        
        $this->smarty->assign('id_servicio', $id_servicio);
		$this->smarty->assign('reg', $id_region);
		$this->smarty->assign('bool_region', $bool_region);
		$this->smarty->assign('arrRegiones', $arrRegiones);
        $this->smarty->assign('arrOficina', $arrOficina);
        $this->smarty->assign('arrComuna', $arrComuna);
        $this->smarty->assign('arrServicio', $arrServicio);
		$this->smarty->assign('arrEstableSalud', $arrEstableSalud);
		$this->smarty->assign('mostrar',$mostrar);
		$this->smarty->assign('origen', 'Exportar');
		$this->smarty->assign('sin_header', 1);

		$this->_display('reportes/exportar.tpl');
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES . "js/templates/reportes/exportar.js");
	}

	public function exportarexcelAction(){
        ini_set('display_errors', 0);
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');

        $id_perfil      = $_SESSION[SESSION_BASE]['perfil'];
        $id_comuna      = $_SESSION[SESSION_BASE]['id_comuna'];
		$correcto       = false;
        $json			= Array("correcto"=>$correcto,"nombre"=>"","excel"=>"");
        $params			= $this->_request->getParams();
        $nombreArchivo	= "Reportes_Mordedores_" . date('d_m_Y') . ".xls";
        
        if($id_perfil == 13 && empty($params['id_establecimiento'])){
            $arrEstableSalud    = $this->_DAOEstablecimientoSalud->getByEncargadoComunal($id_comuna);
            foreach($arrEstableSalud as $item){
                $arr_establecimiento[] = $item->id_establecimiento;
            }
            $params['in_establecimiento']   = implode(",",$arr_establecimiento);
        }
        
        $excel			= $this->crearExcel($params); //EN ESTA FUNCIÓN CREO EL HTML

        if(!empty($excel)){
            $correcto = true;
        }

        $json   = Array("correcto"=>$correcto,"nombre"=>$nombreArchivo,"excel"=> $excel);
        echo json_encode($json);
    }

    public function crearExcel($parametros){
		ini_set('memory_limit', '8000M');
        ini_set('max_execution_time', 3600);
		set_time_limit(3600); //SI ES MUY GRANDE EL EXCEL

        /*********************************************************/
    	$rut 			= '';
		$pasaporte 		= '';
		$documento 		= $parametros["documento"];
		$folio_expediente = $parametros["folio_expediente"];
		$fecha_desde 	= $parametros["fecha_desde"];
		$fecha_hasta 	= $parametros["fecha_hasta"];
		$region 		= $parametros["region"];
		$comuna 		= $parametros["comuna"];
		$folio_mordedor = $parametros["folio_mordedor"];
		$estable_salud 	= $parametros["establecimiento_salud"];
		$microchip_mordedor 	= $parametros["microchip_mordedor"];
		$nombre_fiscalizador 	= $parametros["nombre_fiscalizador"];

		if($documento != ''){
			if(Validar::validarRut($documento)){
				$parametros["rut"] = $documento;
			}else{
				$parametros["pasaporte"] = $documento;
			}
		}

		if($rut != '' || $pasaporte != '' || $folio_expediente != '' || $fecha_desde != '' ||
				  $fecha_hasta != '' || $region != 0 || $comuna != 0 || $folio_mordedor != '' || 
				  $estable_salud != '' || $microchip_mordedor != '' || $nombre_fiscalizador != ''){
			$mostrar	= 1;
			$arr		= $this->_DAOExpediente->buscarExpedientes($parametros);
		}
        
        /********************************************************/
        if($arr){
            foreach($arr as $key=>$item){
                $json_paciente  = json_decode($item->json_paciente,true);
                $arrSexo        = (isset($json_paciente['id_tipo_sexo']))?$this->_DAOTipoSexo->getById($json_paciente['id_tipo_sexo']):array();
                $arr->$key->gl_sexo_paciente = (!empty($arrSexo))?$arrSexo->gl_tipo_sexo:"";
                
                $arrVisitas = $this->_DAOVisitaAnimalMordedor->getByIdExpediente($item->id_expediente);
                if(!empty($arrVisitas)){
                    $arr->$key->arrVisitas = $arrVisitas;
                }
                $especie	= $this->_DAOExpedienteMordedor->getEspecieByExpediente($item->id_expediente);
                
                if(!empty($especie)){
                    $arr->$key->gl_especie_animal = $especie->gl_especie;
                }else{
                    $arr->$key->gl_especie_animal = "";
                }
            }
        }
        $this->smarty->assign("arrResultado", $arr);
        return $this->smarty->fetch('reportes/grilla_exportar.tpl');
    }
	
}