<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripción       : Controller para perfil Administrativo
 *
 * Plataforma        : PHP
 * 
 * Creación          : 06/06/2018
 * 
 * @name             Administrativo.php
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
class Administrativo extends Controller {
    
    protected $_Evento;
    protected $_DAOExpediente;
    protected $_DAOExpedienteMordedor;
    protected $_DAOPaciente;
    protected $_DAOUsuario;
    protected $_DAOPacienteContacto;
    protected $_DAOAnimalGrupo;
    protected $_DAORegion;
    protected $_DAOCorrelativoFolioMordedor;
    protected $_DAOPacienteAlarma;
    protected $_DAOVisitaTipoResultado;
    protected $_DAOVisitaAnimalMordedor;
    protected $_DAOVisita;

	function __construct() {
		parent::__construct();
        $this->load->lib('Fechas', false);
		$this->load->lib('Boton', false);
		$this->load->lib('Seguridad', false);
		$this->load->lib('Evento', false);

		$this->_Evento                      = new Evento();
        $this->_DAOExpediente               = $this->load->model("DAOExpediente");
        $this->_DAOExpedienteMordedor       = $this->load->model("DAOExpedienteMordedor");
		$this->_DAOPaciente                 = $this->load->model("DAOPaciente");
        $this->_DAOUsuario                  = $this->load->model("DAOAccesoUsuario");
        $this->_DAOPacienteContacto         = $this->load->model("DAOPacienteContacto");
        $this->_DAOAnimalGrupo              = $this->load->model("DAOAnimalGrupo");
        $this->_DAORegion                   = $this->load->model("DAODireccionRegion");
        $this->_DAOComuna                   = $this->load->model("DAODireccionComuna");
        $this->_DAOCorrelativoFolioMordedor = $this->load->model("DAOCorrelativoFolioMordedor");
        $this->_DAOPacienteAlarma           = $this->load->model("DAOPacienteAlarma");
        $this->_DAOVisitaTipoResultado      = $this->load->model("DAOVisitaTipoResultado");
        $this->_DAOVisitaAnimalMordedor     = $this->load->model("DAOVisitaAnimalMordedor");
        $this->_DAOVisita                   = $this->load->model("DAOVisita");
	}

	/**
	* Descripción	: Asignar o reasignar fiscalizador a expediente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente) y string $gl_token_fiscalizador
	*/
    public function editar() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->request->getParametros();
        $token_expediente   = $params[0];
        $reasignar          = false;
        
        //CABECERA
        $arrExpediente	= $this->_DAOExpediente->getBitacoraByToken($token_expediente,1);
        $this->smarty->assign("arr", $arrExpediente);
        
        $this->smarty->assign('bo_opciones', 1);
        $this->smarty->assign('bandeja', 'administrativo');
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
    public function editarDireccion() {
        Acceso::redireccionUnlogged($this->smarty);
        $params         = $this->request->getParametros();
        $token_exp_mor  = $params[0];
        $id_region      = (isset($_SESSION[SESSION_BASE]['id_region']))?$_SESSION[SESSION_BASE]['id_region']:0;
        $arrRegiones    = $this->_DAORegion->getLista();
        
		$this->smarty->assign("arrRegiones", $arrRegiones);
        $this->smarty->assign('token_exp_mor', $token_exp_mor);
        $this->smarty->assign('id_region', $id_region);
        $this->smarty->assign('bandeja', 'administrativo');
		$this->smarty->display('administrativo/editar_direccion.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/administrativo/editar_direccion.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript('$("#id_region_animal").trigger("change");');
	}

	/**
	* Descripción	: Guardar BD Asignar o reasignar fiscalizador a expediente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        string $gl_token (expediente) y string $gl_token_fiscalizador
	*/
    public function editarDireccionBD() {
        Acceso::redireccionUnlogged($this->smarty);
        $params = $this->_request->getParams();
        $json   = array("correcto" => false);
        
        if(isset($params['token_exp_mor'])){
            $arrMordedor        = $this->_DAOExpedienteMordedor->getByToken($params['token_exp_mor']);
            $arrExpediente      = $this->_DAOExpediente->getDetalleByToken($arrMordedor->token_expediente);
            $id_expediente      = $arrExpediente->id_expediente;
            $id_paciente        = $arrExpediente->id_paciente;
            $id_mordedor        = $arrMordedor->id_mordedor;
            
            $region             = $this->_DAORegion->getById($params['id_region_animal']);
            $comuna             = $this->_DAOComuna->getById($params['id_comuna_animal']);
            
            if($arrMordedor->json_mordedor){
                $json_mordedor = json_decode($arrMordedor->json_mordedor,TRUE);
                
                $year                   = date("Y");
                $cero                   = (strlen($region->id_region)==1)?"0":"";
                //$id_correlativo_mor     = $this->_DAOCorrelativoFolioMordedor->insertarCorrelativo(array($year,$region->id_region));
                //$gl_folio_mordedor      = substr($year,-2).$cero.$params['id_region_animal'].$id_correlativo_mor;
                
                $json_mordedor['id_region_animal']      = $region->id_region;
                $json_mordedor['gl_region']             = $region->gl_nombre_region;
                $json_mordedor['id_comuna_animal']      = $comuna->id_comuna;
                $json_mordedor['gl_comuna']             = $comuna->gl_nombre_comuna;
                $json_mordedor['gl_direccion']          = $params['gl_direccion'];
                $json_mordedor['gl_referencias_animal'] = $params['gl_referencias_animal'];
                $json_mordedor['gl_latitud_animal']     = $params['gl_latitud_animal'];
                $json_mordedor['gl_longitud_animal']    = $params['gl_longitud_animal'];
                $json_mordedor['bo_domicilio_conocido'] = 1;
                $json_mordedor['bo_ubicable']           = 1;
                
                $bo_edita        = $this->_DAOExpedienteMordedor->editaDireccion($params['token_exp_mor'],json_encode($json_mordedor),$comuna->id_comuna);
                
                $json['correcto'] = true;
            }

            //Guardar Evento
            $id_evento_tipo = 19; //Se edita direccion mordedor
            $gl_descripcion = "Se edita direccion mordedor folio: ".$arrMordedor->gl_folio_mordedor;
            $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, $id_mordedor, $gl_descripcion);
        }
        
        echo json_encode($json);
	}
    
    /**
	* Descripción	: Guarda resultado ISP primero ve cabecera y grilla si es mas de uno
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        : string token_expediente
	*/
    public function resultadoISP() {
        Acceso::redireccionUnlogged($this->smarty);
        $params             = $this->_request->getParams();
        $token_expediente   = $params['token_expediente'];
		
        //CABECERA
        $arrExpediente      = $this->_DAOExpediente->getBitacoraByToken($token_expediente,1);
        
        $this->smarty->assign("arr", $arrExpediente);
        $this->smarty->assign("bo_opciones",1);
        $this->smarty->assign("resultado_isp",1);
        $this->smarty->display('bitacora/cabecera_grilla_mordedor.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/administrativo/resultado_isp.js");
	}
    
    /**
	* Descripción	: Guarda resultado ISP
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        : string token_fiscalizacion
	*/
    public function guardarResultadoISP() {
        Acceso::redireccionUnlogged($this->smarty);
        $params         = $this->request->getParametros();
        $folio_mordedor = $params[0];
		
        $this->smarty->assign("folio_mordedor", $folio_mordedor);
        
        $arrResultadoTipo	= $this->_DAOVisitaTipoResultado->getListaISP();
        $this->smarty->assign("arrResultadoTipo", $arrResultadoTipo);
        
        $this->smarty->display('administrativo/resultado_isp.tpl');
		$this->load->javascript(STATIC_FILES . "js/templates/administrativo/resultado_isp.js");
	}
    
    public function editarResultadoVisitaBD(){
        $params                 = $this->_request->getParams();
        $json                   = array("correcto" => false);
        $folio_mordedor         = $params['folio_mordedor'];
        $id_resultado_isp       = $params['id_tipo_visita_resultado'];
        $gl_observaciones_isp   = $params['gl_observaciones_resultado_visita'];
        
        $arrExpMordedor         = $this->_DAOExpedienteMordedor->getByFolio($folio_mordedor);
        $id_mordedor            = $arrExpMordedor->id_mordedor;
        $id_expediente          = $arrExpMordedor->id_expediente;
        $id_paciente            = $arrExpMordedor->id_paciente;
        
        //Actualizar visita mordedor (json_resultado_isp e id_tipo_resultado_isp)
        $json_isp       = array("id_tipo_resultado_isp" => $id_resultado_isp,
                                "gl_observaciones_isp"  => $gl_observaciones_isp,
                                "fc_resultado_isp"      => date("d-m-Y"));
        
        $bo_resultado = $this->_DAOVisitaAnimalMordedor->editarISP($id_mordedor,$id_resultado_isp,$json_isp);
        
        if($bo_resultado){
            $json['correcto'] = true;
            
            //Guardar Evento
            $id_evento_tipo = 27; //Se actualiza isp
            $gl_descripcion = "Se Actualiza Resultado ISP de mordedor folio: ".$folio_mordedor;
            $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, $id_mordedor, $gl_descripcion);
        }
        
        echo json_encode($json);
    }

}