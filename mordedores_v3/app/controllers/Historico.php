<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripción       : Controller para Historico dentro del sistema
 *
 * Plataforma        : PHP
 * 
 * Creación          : 24/07/2018
 * 
 * @name             Historico.php
 * 
 * @version          1.0.0
 *
 * @author           Pablo Jimenez <pablo.jimenez@cosof.cl>
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
class Historico extends Controller {

	protected $_Evento;
	protected $_DAORegion;
	protected $_DAOExpediente;
	protected $_DAOEstablecimientoSalud;
	protected $_DAOPacienteAlarma;
	protected $_DAOAccesoPerfil;

	function __construct() {
		parent::__construct();
		$this->load->lib('Fechas', false);
		$this->load->lib('Boton', false);
		$this->load->lib('Seguridad', false);
		$this->load->lib('Evento', false);

		$this->_Evento					= new Evento();
		$this->_DAORegion				= $this->load->model("DAODireccionRegion");
		$this->_DAOExpediente           = $this->load->model("DAOExpediente");
		$this->_DAOEstablecimientoSalud = $this->load->model("DAOEstablecimientoSalud");
		$this->_DAOPacienteAlarma   	= $this->load->model("DAOPacienteAlarma");
		$this->_DAOAccesoPerfil			= $this->load->model("DAOAccesoPerfil");
	}


	/**
	* Descripción	: Buscar historico
	* @author		: Pablo Jimenez <pablo.jimenez@cosof.cl>
	*/
	public function index() {
		Acceso::redireccionUnlogged($this->smarty);
		$this->load->lib('Helpers/Validar', false);
		$mostrar            = 0;
		$bool_region        = 0;
		$parametros         = $this->_request->getParams();		
		$arrRegiones        = $this->_DAORegion->getLista();
		$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getListaOrdenada();
		$perfil 			= $this->_DAOAccesoPerfil->getById($_SESSION[SESSION_BASE]['perfil']);
		$id_perfil 			= $_SESSION[SESSION_BASE]['perfil'];
		$id_oficina 		= $_SESSION[SESSION_BASE]["id_oficina"];
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
		
		//if ($perfil->bo_establecimiento == 0){
		if ($_SESSION[SESSION_BASE]['bo_nacional'] == 0){
			$region			= $_SESSION[SESSION_BASE]['id_region'];
			if(!empty($region)){
				$bool_region	= 1;
				$jscode1		= "$(\"#region option[value='".$region."']\").attr('selected',true);";
				$jscode2		= "$('#region').attr('readonly',true);";
				$jscode3		= "setTimeout(function(){ $('#region').trigger('change'); },100);";
				$jscode4		= "$('#region option:not(:selected)').attr('disabled', true)";

				$this->smarty->assign('reg', $region);
				$this->_addJavascript($jscode1);
				$this->_addJavascript($jscode2);
				$this->_addJavascript($jscode3);
				$this->_addJavascript($jscode4);
			}
		}

		//if(($id_perfil == 6 || $id_perfil == 10) && !empty($id_oficina)){
		if($_SESSION[SESSION_BASE]['bo_oficina'] == 1 && !empty($id_oficina)){
			$jscode5		= "setTimeout(function(){ $(\"#id_oficina option[value='".$id_oficina."']\").attr('selected',true); $('#id_oficina option:not(:selected)').attr('disabled', true);},500);";
			$jscode6		= "setTimeout(function(){ $('#id_oficina').attr('readonly',true); },200);";
			$this->_addJavascript($jscode5);
			$this->_addJavascript($jscode6);
		}

		if($_SESSION[SESSION_BASE]['bo_establecimiento'] == 1 && !empty($id_establecimiento)){
			$jscode7		= "$(\"#establecimiento_salud option[value='".$id_establecimiento."']\").attr('selected',true);";
			$jscode8		= "setTimeout(function(){ $('.select2-container').prepend('<div class=\"disabled-select\"></div>'); },100);";
			$this->_addJavascript($jscode7);
			$this->_addJavascript($jscode8);
		}

		$this->smarty->assign('bool_region', $bool_region);
		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign("arrEstableSalud", $arrEstableSalud);
		$this->smarty->assign('mostrar',$mostrar);
		$this->smarty->assign('origen', 'Historico');
		$this->smarty->assign('sin_header', 1);
		$this->smarty->assign('fecha_desde', date("d/m/Y",strtotime("-1 month")));
		$this->smarty->assign('fecha_hasta', date("d/m/Y"));

		$this->_display('historico/paciente.tpl');
        $this->load->javascript("https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=".API_KEY,1);
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES . "js/templates/historico/historico.js");
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


	public function recargarGrillaHistorico(){
		$this->load->lib('Helpers/Validar', false);
		$parametros         = $this->_request->getParams();		
		$perfil 			= $this->_DAOAccesoPerfil->getById($_SESSION[SESSION_BASE]['perfil']);
		$id_establecimiento = $_SESSION[SESSION_BASE]['id_establecimiento'];
		$this->smarty->assign('sin_header', 1);
		
		if(!empty($parametros)){
			$rut = '';
			$pasaporte = '';
			$id_oficina 		= $parametros["id_oficina"];
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

			if($documento != '' || $folio_expediente != '' || $fecha_desde != '' ||
					  $fecha_hasta != '' || $region != 0 || $comuna != 0 || $folio_mordedor != '' || 
					  $estable_salud != '' || $microchip_mordedor != '' || $nombre_fiscalizador != '' || $id_oficina != ''){
				$mostrar	= 1;

				$id_perfil 			= $_SESSION[SESSION_BASE]['perfil'];
				if($id_perfil == 6 || $id_perfil == 14){
					$parametros["id_fiscalizador"] = $_SESSION[SESSION_BASE]['id'];
				}

				$arr		= $this->_DAOExpediente->buscarExpedientes($parametros);
		        foreach ((array)$arr as &$expediente) {
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
		        }

				$this->smarty->assign('arrResultado', $arr);
			}
		}
		$error      = false;
		$grilla		= $this->smarty->fetch('grilla/pacientes.tpl');
		$correcto	= true;
		$salida	= array('error' => $error, 'correcto' => $correcto, 'grilla' => $grilla);
		$json	= Zend_Json::encode($salida);
		echo $json;
	}



}