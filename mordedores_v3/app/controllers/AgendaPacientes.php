<?php
/**
 ******************************************************************************
 * Sistema           : PREVENCION DE FEMICIDIOS
 * 
 * Descripción       : Controller para Agendar horas a Pacientes
 *
 * Plataforma        : PHP
 * 
 * Creación          : 25/05/2018
 * 
 * @name             AgendaPacientes.php
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
class AgendaPacientes extends Controller {
    
    protected $_DAOUsuario;
    protected $_DAOPacienteAgenda;
    protected $_DAOPacienteVacunaEstado;
    protected $_DAOEstablecimientoSalud;
    protected $_DAORegion;
    
    
	function __construct() {
		parent::__construct();
        $this->load->lib('Fechas', false);

        $this->_DAOUsuario				= $this->load->model("DAOAccesoUsuario");
        $this->_DAOPacienteAgenda       = $this->load->model("DAOPacienteAgenda");
        $this->_DAOPacienteVacunaEstado = $this->load->model("DAOPacienteVacunaEstado");
        $this->_DAOEstablecimientoSalud = $this->load->model("DAOEstablecimientoSalud");
        $this->_DAORegion               = $this->load->model("DAODireccionRegion");
	}

	
	/**
	* Descripción	: Ver Agenda de Exámenes de la Paciente
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	* @param int $id_paciente Id Paciente al cual mostrará la Agenda.
	*/
    public function index() {
		//Acceso::redireccionUnlogged($this->smarty);
        $arrAgenda          = "";
        $id_establecimiento = ($_SESSION[SESSION_BASE]['bo_establecimiento']==1)?$_SESSION[SESSION_BASE]['id_establecimiento']:0;
        $arrPacienteAgenda  = $this->_DAOPacienteAgenda->getByEstablecimiento($id_establecimiento);
        
        if(!is_null($arrPacienteAgenda)){
            foreach($arrPacienteAgenda as $item){
                if($item->id_agenda != 0){
                    $json           = json_decode($item->json_agenda);
                    $id_estado      = $json->id_estado;
                    $arrEstado      = $this->_DAOPacienteVacunaEstado->getById($id_estado);
                    //$estado         = ($arrEstado->gl_vacuna_estado == 2)?"Aplicada":"No Aplicada";
                    
                    $gl_rut         = (!empty($item->gl_rut_paciente))?' ('.$item->gl_rut_paciente.')':'';
                    $json_pasaporte = (!empty($item->json_pasaporte))?json_decode($item->json_pasaporte,TRUE):array();
                    $gl_pasaporte   = (!empty($json_pasaporte))?' ('.$json_pasaporte['gl_pasaporte'].')':'';
					$fecha			= $json->fc_vacuna;
                    $folio          = 'Folio: '.$item->gl_folio;
                    $descripcion	= $item->gl_nombre_paciente.$gl_rut.$gl_pasaporte;
                    $gl_estado     	= 'Estado: '.$arrEstado->gl_vacuna_estado;
					$descripcion_tp	= 'Folio: '.$item->gl_folio.'<br>'.$item->gl_nombre_paciente.$gl_rut.$gl_pasaporte
                                    . '<br>Estado: '.$arrEstado->gl_vacuna_estado
                                    . '<br>'.Fechas::formatearHtml($fecha,"-");
					$hora			= '';

                    if (!empty($json->gl_hora_vacuna)){
                        $hora		= $json->gl_hora_vacuna;                    
                    }

					$id_agenda      = $item->id_agenda;
                    $arrAgenda      = "$arrAgenda $folio,$fecha,$hora,$id_agenda,$id_estado,$descripcion_tp,$descripcion,$gl_estado;";
                }
			}
        }
        
        $this->smarty->assign('arrAgendaExamenes', $arrAgenda);
		$this->smarty->assign('origen', 'Agenda Pacientes');
		$this->_display('agenda_pacientes/index.tpl');
		$this->load->javascript(STATIC_FILES . "template/plugins/fullcalendar/fullcalendar.min.js");
		$this->load->javascript(STATIC_FILES . "template/plugins/fullcalendar/locale/es.js");
		$this->load->javascript(STATIC_FILES . "template/plugins/fullcalendar/lib/moment.min.js");
		$this->load->javascript(STATIC_FILES . "js/templates/agenda_pacientes/agenda_pacientes.js");
	}
    
    /**
	* Descripción	: Ver Detalle de Agenda de Exámenes de Paciente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param int $id_paciente Id Paciente al cual mostrará la Agenda.
	*/
    public function ver() {
		//Acceso::redireccionUnlogged($this->smarty);
        $arr                = array();
        $params             = $this->_request->getParams();
        $id_agenda          = $params['id_agenda'];
        $arrPacienteAgenda  = $this->_DAOPacienteAgenda->getById($id_agenda);
        
        if(!empty($arrPacienteAgenda)){
            $item = $arrPacienteAgenda;
            if($item->id_agenda != 0){
                $json               = json_decode($item->json_agenda);
                $arrEstado          = $this->_DAOPacienteVacunaEstado->getById($json->id_estado);
                
                $arr['id_agenda']           = $id_agenda;
                $arr['gl_folio']            = $item->gl_folio;
                $arr['gl_establecimiento']  = $item->gl_nombre_establecimiento;
                $arr['gl_nombre_paciente']  = $item->gl_nombre_paciente;
                $arr['id_estado']           = $json->id_estado;
                $arr['gl_vacuna']           = $arrEstado->gl_vacuna_estado;
                $arr['nr_vacuna']           = ($json->nr_vacuna)?$json->nr_vacuna:"";
                $arr['fc_vacuna']           = Fechas::formatearHtml($json->fc_vacuna,"-");
                $arr['fc_vacuna']           = (isset($json->gl_hora_vacuna))?$arr['fc_vacuna']." ".$json->gl_hora_vacuna:$arr['fc_vacuna'];
                
            }
        }
        
        $this->smarty->assign('id_agenda', $id_agenda);
        $this->smarty->assign('arr', $arr);
		$this->smarty->display('agenda_pacientes/ver.tpl');
	}
    
    /**
	* Descripción	: Vista aplicar vacuna a Paciente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param int $id_paciente Id Paciente al cual mostrará la Agenda.
	*/
    public function aplicarVacuna() {
		//Acceso::redireccionUnlogged($this->smarty);
        $arr                = array();
        $params             = $this->_request->getParams();
        $id_agenda          = $params['id_agenda'];
        $arrPacienteAgenda  = $this->_DAOPacienteAgenda->getById($id_agenda);
        
        if(!empty($arrPacienteAgenda)){
            
        }
        
        $this->smarty->assign('id_agenda', $id_agenda);
        $this->smarty->assign('arr', $arr);
		$this->smarty->display('agenda_pacientes/aplicar_vacuna.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/agenda_pacientes/aplicar_vacuna.js");
	}
    
    /**
	* Descripción	: Vista Derivar a otro Establecimiento Paciente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param int $id_paciente Id Paciente al cual mostrará la Agenda.
	*/
    public function derivar() {
		//Acceso::redireccionUnlogged($this->smarty);
        $arr                = array();
        $params             = $this->_request->getParams();
        $id_agenda          = $params['id_agenda'];
        $arrRegion          = $this->_DAORegion->getLista();
        $arrPacienteAgenda  = $this->_DAOPacienteAgenda->getById($id_agenda);
        
        if(!empty($arrPacienteAgenda)){
            
        }
        
        $this->smarty->assign('id_agenda', $id_agenda);
        $this->smarty->assign('arrRegion', $arrRegion);
		$this->smarty->display('agenda_pacientes/derivar.tpl');
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES . "js/templates/agenda_pacientes/derivar.js");
	}
    
    /**
	* Descripción	: Ver Bitacora de Calendario de Paciente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param int $id_paciente Id Paciente al cual mostrará la Agenda.
	*/
    public function bitacora() {
		//Acceso::redireccionUnlogged($this->smarty);
        $arr                = array();
        $params             = $this->_request->getParams();
        $id_agenda          = $params['id_agenda'];
        $arrPacienteAgenda  = $this->_DAOPacienteAgenda->getById($id_agenda);
        
        if(!empty($arrPacienteAgenda)){
            
        }
        
        $this->smarty->assign('id_agenda', $id_agenda);
        $this->smarty->assign('arr', $arr);
		$this->smarty->display('agenda_pacientes/bitacora.tpl');
	}

}