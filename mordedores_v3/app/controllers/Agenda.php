<?php
/**
 ******************************************************************************
 * Sistema           : PREVENCION DE FEMICIDIOS
 * 
 * Descripción       : Asignar, reasignar y control de fiscalizaciones
 *
 * Plataforma        : PHP
 * 
 * Creación          : 25/05/2018
 * 
 * @name             Agenda.php
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
class Agenda extends Controller {
    
    protected $_Evento;
    protected $_DAOExpediente;
    protected $_DAOExpedienteMordedor;
    protected $_DAOPaciente;
    protected $_DAOUsuario;
    protected $_DAOPacienteContacto;
    protected $_DAOAnimalGrupo;

	function __construct() {
		parent::__construct();
        $this->load->lib('Fechas', false);
		$this->load->lib('Boton', false);
		$this->load->lib('Seguridad', false);
		$this->load->lib('Evento', false);

		$this->_Evento					= new Evento();
        $this->_DAOExpediente           = $this->load->model("DAOExpediente");
        $this->_DAOExpedienteMordedor   = $this->load->model("DAOExpedienteMordedor");
		$this->_DAOPaciente				= $this->load->model("DAOPaciente");
        $this->_DAOUsuario				= $this->load->model("DAOAccesoUsuario");
        $this->_DAOPacienteContacto     = $this->load->model("DAOPacienteContacto");
        $this->_DAOAnimalGrupo          = $this->load->model("DAOAnimalGrupo");
	}

    public function index() {
		Acceso::redireccionUnlogged($this->smarty);
	}
    
    /**
	* Descripción	: Recarga cabecera grilla mordedor
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        
	*/
    public function cabeceraGrillaMordedor() {
        $params             = $this->_request->getParams();
        $token_expediente   = $params['gl_token'];
        $bandeja            = $params['bandeja'];
        
        $arrExpediente      = $this->_DAOExpediente->getBitacoraByToken($token_expediente,1);
        $this->smarty->assign("arr", $arrExpediente);
        $this->smarty->assign("bo_opciones", 1);
        $this->smarty->assign("bandeja", $bandeja);
        $this->smarty->assign('id_perfil_usuario', intval($_SESSION[SESSION_BASE]['perfil']));
        $this->smarty->assign('id_region_usuario', intval($_SESSION[SESSION_BASE]['id_region']));
        $this->smarty->assign('id_usuario', intval($_SESSION[SESSION_BASE]['id']));
        
		echo $this->smarty->display('bitacora/cabecera_grilla_mordedor.tpl');
	}

	/**
	* Descripción	: Asignar o reasignar fiscalizador a expediente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente) y string $gl_token_fiscalizador
	*/
    public function asignar() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->request->getParametros();
        $token_expediente   = $params[0];
        $reasignar          = false;
        
        //CABECERA
        $arrExpediente	= $this->_DAOExpediente->getBitacoraByToken($token_expediente,1);
        $this->smarty->assign("arr", $arrExpediente);
        
        $this->smarty->assign('bo_opciones', 1);
        $this->smarty->assign('bandeja', 'asignar');
        $this->smarty->assign('id_perfil_usuario', intval($_SESSION[SESSION_BASE]['perfil']));
        $this->smarty->assign('id_region_usuario', intval($_SESSION[SESSION_BASE]['id_region']));
        $this->smarty->assign('id_usuario', intval($_SESSION[SESSION_BASE]['id']));

		$this->smarty->display('bitacora/cabecera_expediente.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/agenda/mapa.js");
	}

	/**
	* Descripción	: Asignar o reasignar fiscalizador a expediente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente) y string $gl_token_fiscalizador
	*/
    public function asignarFiscalizador() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->request->getParametros();
        $token_exp_mor      = $params[0];
        $region_mordedor    = $params[1];
        $comuna_mordedor    = (isset($params[2]))?$params[2]:0;
        $reasignar          = false;
        
        //CABECERA
        //$arrExpediente	= $this->_DAOExpediente->getBitacoraByToken($token_expediente,1);
        //$this->smarty->assign("arr", $arrExpediente);
        
        if(isset($params[3])){
            $reasignar          = true;
            $token_fiscalizador = $params[3];
            $this->smarty->assign('reasignar', $reasignar);
            $this->smarty->assign('tokenFiscalizador', $token_fiscalizador);
        }
        $arr_fiscalizadores = $this->_DAOUsuario->obtenerFiscalizadores($region_mordedor,$comuna_mordedor);
        
        //$this->smarty->assign('arrExpediente', $arr_expediente);
        $this->smarty->assign('bo_opciones', 1);
        $this->smarty->assign('bandeja', 'asignar');
        $this->smarty->assign('token_exp_mor', $token_exp_mor);
        $this->smarty->assign('arrFiscalizadores', $arr_fiscalizadores);

		$this->smarty->display('agenda/asignar.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/agenda/asignar.js");
	}

	/**
	* Descripción	: Guardar BD Asignar o reasignar fiscalizador a expediente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente) y string $gl_token_fiscalizador
	*/
    public function asignarFiscalizadorBD() {
        Acceso::redireccionUnlogged($this->smarty);
        $params			= $this->_request->getParams();
        $json			= array("correcto" => false,"recargaTabla" => false);
        $bo_reasignar	= (isset($params['bo_reasignar']))?$params['bo_reasignar']:0;
        
        if(isset($params['token_fiscalizador']) && isset($params['token_exp_mor'])){
            $fiscalizador       = $this->_DAOUsuario->getDetalleByToken($params['token_fiscalizador']);
            $arrMordedor        = $this->_DAOExpedienteMordedor->getByToken($params['token_exp_mor']);
            $arrExpediente      = $this->_DAOExpediente->getDetalleByToken($arrMordedor->token_expediente);
            $bo_asignado        = $this->_DAOExpedienteMordedor->asignarFiscalizador($fiscalizador->id_usuario,$params['token_exp_mor']);
            $json['correcto']   = $bo_asignado;
            $id_expediente      = $arrExpediente->id_expediente;
            $id_paciente        = $arrExpediente->id_paciente;
            $id_mordedor        = $arrMordedor->id_mordedor;

			// Cambiar Estado
			$arrPendiente		= $this->_DAOExpedienteMordedor->getByIdEstado($id_expediente,1);
			if(empty($arrPendiente)){
				$this->_DAOExpediente->cambiarEstado($id_expediente,6);
				 $json['recargaTabla']	= true;
			}else{
				$this->_DAOExpediente->cambiarEstado($id_expediente,2);
			}

            //Guardar Evento
            $id_evento_tipo = ($bo_reasignar==1)?9:8; //Se asigna/reasigna fiscalizador
            if($bo_reasignar==1){
                $gl_descripcion = "Se reasigna mordedor folio: ".$arrMordedor->gl_folio_mordedor." a Fiscalizador: ".$fiscalizador->gl_nombres." ".$fiscalizador->gl_apellidos;
            }else{
                $gl_descripcion = "Se asigna mordedor folio: ".$arrMordedor->gl_folio_mordedor." a Fiscalizador: ".$fiscalizador->gl_nombres." ".$fiscalizador->gl_apellidos;
            }
            $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, $id_mordedor, $gl_descripcion);
        }
        
        echo json_encode($json);
	}

	/**
	* Descripción	: Programar visita fiscalizador
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente)
	*/
    public function devolver() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->request->getParametros();
        $token_expediente   = $params[0];
        
        $arrExpediente      = $this->_DAOExpediente->getBitacoraByToken($token_expediente,1);
        $this->smarty->assign("arr", $arrExpediente);
        
        $this->smarty->assign('bo_opciones', 1);
        $this->smarty->assign('bandeja', 'devolver');
        $this->smarty->assign('id_perfil_usuario', intval($_SESSION[SESSION_BASE]['perfil']));
        $this->smarty->assign('id_region_usuario', intval($_SESSION[SESSION_BASE]['id_region']));
        $this->smarty->assign('id_usuario', intval($_SESSION[SESSION_BASE]['id']));
        
		$this->smarty->display('bitacora/cabecera_expediente.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/agenda/mapa.js");
		$this->load->javascript(STATIC_FILES . "js/templates/agenda/programar.js");
	}

	/**
	* Descripción	: Programar visita fiscalizador
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente)
	*/
    public function programarVisita() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->request->getParametros();
        $token_exp_mor      = $params[0];
        $bo_reprogramar     = (isset($params[1]))?$params[1]:0;
        
        $this->smarty->assign('token_exp_mor', $token_exp_mor);
        $this->smarty->assign('bo_reprogramar', $bo_reprogramar);
        $this->smarty->assign('bandeja', 'programar');
        
		$this->smarty->display('agenda/programar.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/agenda/programar.js");
	}

	/**
	* Descripción	: Guardar BD Programar Visita
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente)
	*/
    public function programarVisitaBD() {
        Acceso::redireccionUnlogged($this->smarty);
        $params         = $this->_request->getParams();
        $json           = array("correcto" => false);
        $bo_reprogramar = (isset($params['reprogramar']))?$params['reprogramar']:0;

        if(isset($params['token_exp_mor'])){
            $fc_programado      = Fechas::formatearBaseDatosSinComilla($params['fecha']);
            $fecha              = $fc_programado." ".$params['hora'].":00";
            $arrMordedor        = $this->_DAOExpedienteMordedor->getByToken($params['token_exp_mor']);
            $arrExpediente      = $this->_DAOExpediente->getDetalleByToken($arrMordedor->token_expediente);
            $id_estado          = ($arrMordedor->id_expediente_mordedor_estado == 13 || $arrMordedor->id_expediente_mordedor_estado == 14)?14:6;
            
            $json['correcto']      = $this->_DAOExpedienteMordedor->programarVisita($fecha,$params['token_exp_mor'],$id_estado);
            
            //Guardar Evento
            $id_expediente  = $arrExpediente->id_expediente;
            $id_paciente    = $arrExpediente->id_paciente;
            $id_mordedor    = $arrMordedor->id_mordedor;
            $id_evento_tipo = ($bo_reprogramar==1)?15:14;
            $texto_programa = ($bo_reprogramar==1)?"reprograma":"programa";
            $gl_descripcion = "Se $texto_programa visita para día ".$params['fecha']." a las ".$params['hora'];
            $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, $id_mordedor, $gl_descripcion);
            
            $json['mensaje']    = $gl_descripcion;
        }
        
        echo json_encode($json);
	}

	/**
	* Descripción	: Guardar BD devolver programacion
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente)
	*/
    public function devolverProgramacionBD() {
        Acceso::redireccionUnlogged($this->smarty);
        $params         = $this->_request->getParams();
        $json           = array("correcto" => false);
        
        if(isset($params['token_exp_mor'])){
            $arrMordedor        = $this->_DAOExpedienteMordedor->getByToken($params['token_exp_mor']);
            $arrExpediente      = $this->_DAOExpediente->getDetalleByToken($arrMordedor->token_expediente);
            
            $this->_DAOExpediente->devolverProgramacion($arrMordedor->token_expediente);
            $json['correcto']   = $this->_DAOExpedienteMordedor->devolverProgramacion($params['token_exp_mor']);
            
            //Guardar Evento
            $id_expediente  = $arrExpediente->id_expediente;
            $id_paciente    = $arrExpediente->id_paciente;
            $id_mordedor    = $arrMordedor->id_mordedor;
            $id_evento_tipo = 16;
            $gl_descripcion = "Se devuelve a Supervisor, motivo: ".$params['gl_motivo'];
            $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, $id_mordedor, $gl_descripcion);
            
        }
        
        echo json_encode($json);
	}

}