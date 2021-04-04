<?php
/**
 ******************************************************************************
 * Sistema           : PREVENCION DE FEMICIDIOS
 *
 * Descripción       : Controller para Dashboard
 *
 * Plataforma        : PHP
 *
 * Creación          : 14/02/2017
 *
 * @name             Home.php
 *
 * @version          1.0.0
 *
 * @author           ivan Almonacid <ivan@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha		Descripción
 * ----------------------------------------------------------------------------
 * <david.guzman@cosof.cl>      06-03-2017	modificacion nombres DAO y funciones
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
require_once(APP_PATH . "libs/Helpers/View/Grid.php");

class Home extends Controller{

    function __construct(){
        parent::__construct();
		$this->load->lib('Fechas', false);

        $this->smarty->addPluginsDir(APP_PATH . "views/templates/home/plugins/");
        $this->_DAOUsuario			= $this->load->model("DAOAccesoUsuario");
        $this->_DAOPaciente			= $this->load->model("DAOPaciente");
        $this->_DAOPacienteAlarma   = $this->load->model("DAOPacienteAlarma");
        $this->_DAOPacienteContacto = $this->load->model("DAOPacienteContacto");
        $this->_DAOPacienteEstado	= $this->load->model("DAOPacienteEstado");
        $this->_DAOExpediente       = $this->load->model("DAOExpediente");
        $this->_DAOExpedienteEstado	= $this->load->model("DAOExpedienteEstado");
        $this->_DAOExpedienteMordedor = $this->load->model("DAOExpedienteMordedor");
    }

    public function index(){
        Acceso::redireccionUnlogged($this->smarty);
    }

	/**
	* Descripción	: Dashboard de Usuario
	* @author		: ivan Almonacid <ivan@cosof.cl>
	*/
    public function dashboard(){
        Acceso::redireccionUnlogged($this->smarty);
		/*
        $jscode             = '';
        $perfil_nacional    = $_SESSION[SESSION_BASE]['bo_nacional'];
		$perfil_regional    = $_SESSION[SESSION_BASE]['bo_regional'];
        
        $arr_domicilios             = $this->_DAOExpedienteMordedor->getGraficoNotificaciones($params);
        $arr_visitas                = $this->_DAOExpedienteMordedor->getGraficoVisitasRealizadas($params);
        
        $arr_visitas_comuna1        = $this->_DAOExpedienteMordedor->getVisitasComunal($params);
        $arr_visitas_comuna2        = $this->_DAOExpedienteMordedor->getNotificacionesComunal($params);
        $arr_visitas_comuna         = array();
        
        $arr_visitas_region1        = $this->_DAOExpedienteMordedor->getVisitasRegional($params);
        $arr_visitas_region2        = $this->_DAOExpedienteMordedor->getNotificacionesRegional($params);
        $arr_visitas_region         = array();
        
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
        
        //GRILLA POR REGION
        if($arr_visitas_region1){
            foreach($arr_visitas_region1 as $visita){
                $arr = (array)$visita;
                $arr_visitas_region[$arr['id_region']]                  = $arr;
                $arr_visitas_region[$arr['id_region']]['conocido']      = 0;
                $arr_visitas_region[$arr['id_region']]['no_conocido']   = 0;
            }
        }
        if($arr_visitas_region2){
            foreach($arr_visitas_region2 as $visita){
                $arr = (array)$visita;
                $arr_visitas_region[$arr['id_region']]['numero_region'] = $arr['numero_region'];
                $arr_visitas_region[$arr['id_region']]['conocido']      = $arr['Conocido'];
                $arr_visitas_region[$arr['id_region']]['no_conocido']   = $arr['No Conocido'];
                if(!isset($arr_visitas_region[$arr['id_region']]['region'])){
                    $arr_visitas_region[$arr['id_region']]['region']            = $arr['region'];
                    $arr_visitas_region[$arr['id_region']]['Positivo']          = 0;
                    $arr_visitas_region[$arr['id_region']]['Negativo']          = 0;
                    $arr_visitas_region[$arr['id_region']]['No Sospechoso']     = 0;
                    $arr_visitas_region[$arr['id_region']]['Sospechoso']        = 0;
                    $arr_visitas_region[$arr['id_region']]['Visita Perdida']    = 0;
                    $arr_visitas_region[$arr['id_region']]['Se Niega a Visita'] = 0;
                    $arr_visitas_region[$arr['id_region']]['cant_total']        = 0;
                }
            }
        }

        $jscode2     = 'Home.graficoVisitasMordedores('.json_encode($arr_visitas).');';
        $jscode3     = 'Home.graficoDomicilios('.json_encode($arr_domicilios).');';

        $this->smarty->assign("arr_visitas_comuna", $arr_visitas_comuna);
        $this->smarty->assign("arr_visitas_region", $arr_visitas_region);
        $this->smarty->assign("perfil_nacional", $perfil_nacional);
        $this->smarty->assign("perfil_regional", $perfil_regional);
        $this->smarty->assign("class_col", $class_col);
        $this->smarty->assign("nombre_mes", "(".$arr_mes[$nr_mes].")");

        $template	= 'home/dashboard.tpl';
        $this->_display($template);

        $this->load->javascript(STATIC_FILES.'js/plugins/amcharts/amcharts.js');
        $this->load->javascript(STATIC_FILES.'js/plugins/amcharts/pie.js');
        $this->load->javascript(STATIC_FILES.'js/plugins/amcharts/serial.js');
        $this->load->javascript(STATIC_FILES.'js/plugins/amcharts/lang/es.js');
        $this->load->javascript(STATIC_FILES.'js/templates/home/home.js',0,1);
        $this->load->javascript(STATIC_FILES.'js/formulario.js',0,1);
        $this->load->javascript($jscode2);
        $this->load->javascript($jscode3);
		*/
        
        $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
		$id_region          = $_SESSION[SESSION_BASE]['id_region'];
		$id_oficina    		= $_SESSION[SESSION_BASE]['id_oficina'];
		$id_comuna    		= $_SESSION[SESSION_BASE]['id_comuna'];
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
		$id_usuario         = $_SESSION[SESSION_BASE]['id'];
        $arr_mes            = array("1"=>"Enero","2"=>"Febrero","3"=>"Marzo","4"=>"Abril","5"=>"Mayo","6"=>"Junio","7"=>"Julio",
                                    "8"=>"Agosto","9"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
        $nr_mes             = date("n");
        $params				= array();
        $class_col			= 'col-xs-12';

        if($id_perfil == 1 || $id_perfil == 7 || $id_perfil == 8){
			//NACIONAL O ADMIN
			$params    = array();
			$class_col	= 'col-md-12 col-lg-6';
		} else if($id_perfil == 3 || $id_perfil == 4){
			//ESTABLEC - RECEPTOR ESTABLEC
			$params		= array('id_establecimiento'=>$id_establecimiento);
		} else if($id_perfil == 12){
			// ADMINISTRATIVO = solo ve los de su oficina
            $params	= array('id_region'=>$id_region);
		} else if($id_perfil == 5){
			//REGIONAL SEREMI
            $params		= array('id_region'=>$id_region);
		} else if($id_perfil == 10){
			//SUPERVISOR
			if(!empty($id_oficina)){
				$params		= array('id_region'=>$id_region,'id_oficina'=>$id_oficina);
			}else{
				$params		= array('id_region'=>$id_region);
			}
		} else if($id_perfil == 6 || $id_perfil == 14){
			//FISCALIZADOR
			$params		= array('id_fiscalizador'=>$id_usuario,'id_region'=>$id_region,'id_oficina'=>$id_oficina);
		} else if($id_perfil == 13){
			//COMUNAL
			$params		= array('id_region'=>$id_region,'id_oficina'=>$id_oficina,'id_comuna'=>$id_comuna);
		} else{
			//TIC
            $params		= array('id_region'=>$id_region);
        }
        
        $params['fc_inicio']                = date('01/m/Y', strtotime('- 3 months'));
        $params['fc_termino']               = date('d/m/Y');
        $params['bo_domicilio_conocido']    = "";
        $arr_pendientes             = $this->_DAOExpedienteMordedor->getNumeroNotificaciones($params);
        
        $params['bo_mes_actual']    = true;
        $arr_ultimas_ingresadas     = $this->_DAOExpedienteMordedor->getNumeroNotificaciones($params);
        
        $this->smarty->assign("cant_pendientes", $arr_pendientes->cantidad);
        $this->smarty->assign("cant_ingresadas", $arr_ultimas_ingresadas->cantidad);
        $this->smarty->assign("nombre_mes", "(".$arr_mes[$nr_mes].")");
        
        $template	= 'home/dashboard.tpl';
        $this->_display($template);
    }

	/**
	* Descripción	: Mapa de Pacientes para el Dashboard
	* @author		: Ivan Almonacid <ivan@cosof.cl>
	*/
    public function pacientesMapaDashboard(){
        $daoPacientes = $this->load->model('DAOPaciente');
		$parametros		= $this->_request->getParams();
		//print_r($parametros['seguimiento']); die();
        $response = array();

        if($_SESSION[SESSION_BASE]['perfil'] == 5){
			$pacientes =  $daoPacientes->getLista();
		}else{
			$id_region = $_SESSION[SESSION_BASE]['id_region'];
			$pacientes = $daoPacientes->getLista(array('region' => $id_region));
        }

        if($pacientes){
            foreach($pacientes as $paciente){
                $response['pacientes'][] = array(
                    'id' => $paciente->id_paciente,
                    'latitud' => $paciente->gl_latitud,
                    'longitud' => $paciente->gl_longitud
                    );
            }
        }

        echo json_encode($response);
    }

}