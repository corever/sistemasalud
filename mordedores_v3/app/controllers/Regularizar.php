<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripción       : Controller para regularizar fiscalizaciones
 *
 * Plataforma        : PHP
 * 
 * Creación          : 22/08/2018
 * 
 * @name             Regularizar.php
 * 
 * @version          1.0.0
 *
 * @author           Víctor Monsalve <victor.monsalve@cosof.cl>
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

class Regularizar extends Controller {

	protected $_Evento;
	protected $_DAORegion;
	protected $_DAOExpediente;
	protected $_DAOEstablecimientoSalud;
	protected $_DAOPacienteAlarma;
	protected $_DAOAccesoPerfil;
	protected $_DAOSintomasTipo;
	protected $_DAOAuditoriaWS;
	protected $_DAONacionalidad;
	protected $_DAOAnimalEspecie;
	protected $_DAOAnimalRaza;
	protected $_DAOAnimalTamano;
	protected $_DAOAnimalEstadoProductivo;
	protected $_DAOAnimalSexo;
	protected $_DAOVacunaLaboratorio;
	protected $_DAOVisitaTipoPerdida;
	protected $_DAOAuditoriaSincronizarWeb;

	function __construct() {
		parent::__construct();
		
		include_once("app/libs/nusoap/lib/nusoap.php");

		$this->load->lib('Fechas', false);
		$this->load->lib('Boton', false);
		$this->load->lib('Seguridad', false);
		$this->load->lib('Evento', false);
		$this->load->lib('formatoArchivo', false);
        $this->_formatoArchivo      = new formatoArchivo();

		$this->_Evento						= new Evento();
		$this->_DAONacionalidad				= $this->load->model("DAODireccionNacionalidad");
		$this->_DAOEstablecimientoSalud		= $this->load->model("DAOEstablecimientoSalud");
		$this->_DAOVacunaLaboratorio		= $this->load->model("DAOVacunaLaboratorio");
		$this->_DAODuracionInmunidad		= $this->load->model("DAODuracionInmunidad");
		$this->_DAOExpedienteEstado			= $this->load->model("DAOExpedienteEstado");
		$this->_DAORegion					= $this->load->model("DAODireccionRegion");
		$this->_DAOComuna					= $this->load->model("DAODireccionComuna");
		$this->_DAOAccesoUsuario			= $this->load->model("DAOAccesoUsuario");		
		$this->_DAOAccesoPerfil				= $this->load->model("DAOAccesoPerfil");
		$this->_DAOSintomasTipo				= $this->load->model("DAOSintomasTipo");
		$this->_DAOExpediente				= $this->load->model("DAOExpediente");
		$this->_DAOAnimalEspecie			= $this->load->model("DAOAnimalEspecie");
		$this->_DAOAnimalRaza				= $this->load->model("DAOAnimalRaza");
		$this->_DAOAnimalTamano				= $this->load->model("DAOAnimalTamano");
		$this->_DAOAnimalEstadoProductivo	= $this->load->model("DAOAnimalEstadoProductivo");	
		$this->_DAOAnimalSexo				= $this->load->model("DAOAnimalSexo");	
		$this->_DAOVacuna					= $this->load->model("DAOVacuna");		
		$this->_DAOAuditoriaWS				= $this->load->model("DAOAuditoriaWS");		
		$this->_DAOVisitaTipoPerdida		= $this->load->model("DAOVisitaTipoPerdida");
		$this->_DAOAuditoriaSincronizarWeb	= $this->load->model("DAOAuditoriaSincronizarWeb");
		
	}

	/**
	 * Formulario inicial (filtros para regularizar)
	 */
	public function index() {
		Acceso::redireccionUnlogged($this->smarty); // valida si está logueado
		$this->load->lib('Helpers/Validar', false);
		$mostrar            = 0;
		$bool_region        = 0;
		//$parametros         = $this->_request->getParams();		
		//$arrRegiones        = $this->_DAORegion->getLista();
		//$arrEstableSalud	= $this->_DAOEstablecimientoSalud->getListaOrdenada();
        
        
        //Variables a tpl
		/*$this->smarty->assign('bool_region', $bool_region);
		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign("arrEstableSalud", $arrEstableSalud);
		$this->smarty->assign('mostrar',$mostrar);
		$this->smarty->assign('origen', 'Buscar');
		$this->smarty->assign('sin_header', 1);*/

		$this->_display('regularizar/index.tpl');
        $this->load->javascript("https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=".API_KEY,1);
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		//$this->load->javascript(STATIC_FILES . "js/templates/paciente/nuevo_animal.js");
		$this->load->javascript(STATIC_FILES . "js/templates/regularizar/regularizar.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/jquery-labelauty.js");
    }
    
    /**
     * Carga datos de fiscalización (con datos de archivo respaldo)
     */
    public function datosRespaldo() {
		Acceso::redireccionUnlogged($this->smarty); // valida si está logueado
		
		$parametros					= $this->_request->getParams();
		$respaldo					= json_decode($parametros['data_from_file'],true);
		$datos_usuario				= $this->_DAOAccesoUsuario->getById($respaldo["id_usuario"]);
		$estado_expediente			= $this->_DAOExpediente->getById($respaldo["id_expediente"])->id_expediente_estado;
		$lista_estados_expediente	= $this->_DAOExpedienteEstado->getLista();

		$class_estado_web	= "";
		$nombre_estado_web	= "";
		foreach($lista_estados_expediente as $estado) {
			if($estado->id_expediente_estado == $estado_expediente) {
				$class_estado_web	= $estado->gl_class;
				$nombre_estado_web	= $estado->gl_nombre;
			}
		}        
        
        $arr[0]['id_expediente']        = $respaldo['id_expediente'];
        $arr[0]['gl_folio']             = $respaldo['gl_folio'];
        $arr[0]['cantidad_mordedores']  = count($respaldo["mordedores"]);
        $arr[0]['estado_web']           = $estado_expediente;
        $arr[0]['class_estado_web']     = $class_estado_web;
        $arr[0]['nombre_estado_web']    = $nombre_estado_web;
        $arr[0]['fiscalizador_nombre']  = $datos_usuario->gl_nombres.' '.$datos_usuario->gl_apellidos;
        $arr[0]['fiscalizador_rut']     = $datos_usuario->gl_rut;
        
		$this->smarty->assign("respaldo", "respaldo");
		$this->smarty->assign("arrFiscalizacion", $arr);

		$_SESSION[SESSION_BASE]['datos_respaldo'] = $respaldo;
		
		$error      = false;
		$grilla		= $this->smarty->fetch('regularizar/fiscalizacion_tabla.tpl');
		$correcto	= true;
		$salida		= array('error' => $error, 'correcto' => $correcto, 'grilla' => $grilla);
		$json		= json_encode($salida);

		echo $json;
	}
	
	/**
	* Llama a formulario y carga datos
	*/
	public function llenarFormulario() {
		Acceso::redireccionUnlogged($this->smarty);
		$parametros     = $this->_request->getParams();
		$origen         = $parametros['input_codigo'];
		$folio          = $parametros['folio'];
		$actividad_id   = $parametros['actividad_id'];

		$arrEstadoReproductivo  = $this->_DAOAnimalEstadoProductivo->getLista();
		$arrDuracionInmunidad   = $this->_DAODuracionInmunidad->getLista();
		$arrLaboratorios        = $this->_DAOVacunaLaboratorio->getLista();
		$arrAnimalEspecie       = $this->_DAOAnimalEspecie->getByEstado();
		$arrAnimalTamano        = $this->_DAOAnimalTamano->getLista();
		$arrNacionalidad        = $this->_DAONacionalidad->getLista();
		$arrSintomas            = $this->_DAOSintomasTipo->getLista();
		$arrRegiones            = $this->_DAORegion->getLista();
		$token_expediente		= $this->_DAOExpediente->getTokenByFolio($folio);
		$arrTipoPerdida			= $this->_DAOVisitaTipoPerdida->getListaEstado(1);
		
		$correcto				= false;
		$cantidad_mordedores	= 0;
		$arr_mordedores			= array();

		if($origen == "respaldo") {
			$cantidad_mordedores	= count($_SESSION[SESSION_BASE]['datos_respaldo']['mordedores']);
			$arr_mordedores			= $_SESSION[SESSION_BASE]['datos_respaldo']['mordedores'];
			$correcto				= true;
            
			unset($_SESSION[SESSION_BASE]['datos_respaldo']);
		} else {
			$respaldo   = $_SESSION[SESSION_BASE]['datos_respaldo'][$actividad_id];
			if(isset($respaldo['doc']['mordedores'])){
				$_SESSION[SESSION_BASE]['respaldo'] = $respaldo;

                foreach($respaldo['doc']['mordedores'] as $key=>$mordedor){
                    if(!empty($mordedor['adjuntos'])){
						
                        foreach($mordedor['adjuntos'] as $keyAdjunto=>$itemAdjunto){
							$this->smarty->assign("cont_mordedor", $key);
							$this->smarty->assign("arrAdjunto", $itemAdjunto);
							$grilla		= $this->smarty->fetch('regularizar/grilla_adjunto.tpl');

							$id_adjunto_tipo	= $itemAdjunto['id_adjunto_tipo'];
							$enviado			= $itemAdjunto['enviado'];
							$nombre_documento	= '';
							$gl_descripcion		= '';
                            if($id_adjunto_tipo == 3){
                                //Grilla Adjuntos Acta Eutanasia
								$nombre_documento	= 'acta_eutanasia.png';
								$gl_descripcion		= 'Acta Eutanasia';

                                $respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['imagen_eutanasia_mordedor'] = $itemAdjunto['imagen_eutanasia_mordedor'];
                                if(!empty($itemAdjunto['imagen_eutanasia_mordedor'])){
                                    $respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['grilla'] = $grilla;
                                }
                            }elseif($id_adjunto_tipo == 5){
                                //Grilla Adjuntos Microchip
								$nombre_documento	= 'microchip.png';
								$gl_descripcion		= 'Microchip';

                                $respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['imagen_microchip_mordedor'] = $itemAdjunto['imagen_microchip_mordedor'];
                                if(!empty($itemAdjunto['imagen_microchip_mordedor'])){
                                    $respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['grilla'] = $grilla;
                                }
                            }elseif($id_adjunto_tipo == 6){
                                //Grilla Adjuntos Documento Vacuna
								$nombre_documento	= 'documento_vacuna.png';
								$gl_descripcion		= 'Documento Vacuna';

                                $respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['imagen_certificado_vacuna_mordedor'] = $itemAdjunto['imagen_certificado_vacuna_mordedor'];
                                if(!empty($itemAdjunto['imagen_certificado_vacuna_mordedor'])){
                                    $respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['grilla'] = $grilla;
                                }
                            }

							$respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['id_adjunto_tipo']	= $id_adjunto_tipo;
							$respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['enviado']			= $enviado;
							$respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['nombre_documento']	= $nombre_documento;
							$respaldo['doc']['mordedores'][$key]['adjuntos'][$id_adjunto_tipo]['gl_descripcion']	= $gl_descripcion;

                            unset($respaldo['doc']['mordedores'][$key]['adjuntos'][$keyAdjunto]);
                        }
                    }
                    $_SESSION[SESSION_BASE]['adjuntos'][$key] = $respaldo['doc']['mordedores'][$key]['adjuntos'];
                }

				$bo_se_niega_visita	= (isset($respaldo['doc']['bo_se_niega_visita']))?$respaldo['doc']['bo_se_niega_visita']:null;
				$id_visita_estado	= (isset($respaldo['doc']['id_visita_estado']))?$respaldo['doc']['id_visita_estado']:null;
				$fecha_inspeccion	= (isset($respaldo['doc']['fecha_inspeccion']))?$respaldo['doc']['fecha_inspeccion']:null;

				/*$resultado_inspeccion = (isset($respaldo['doc']['resultado_inspeccion']))?$respaldo['doc']['resultado_inspeccion']:null;
				$this->smarty->assign("resultado_inspeccion", $resultado_inspeccion);*/

				$cantidad_mordedores	= count($respaldo['doc']['mordedores']);
				$arr_mordedores			= $respaldo['doc']['mordedores'];
            }
			
			$correcto				= true;
			unset($_SESSION[SESSION_BASE]['datos_respaldo']);
		}

		$this->smarty->assign("cantidad_mordedores", $cantidad_mordedores);
		$this->smarty->assign("mordedores", $arr_mordedores);
		$this->smarty->assign("bo_se_niega_visita", $bo_se_niega_visita);
		$this->smarty->assign("id_visita_estado", $id_visita_estado);
		$this->smarty->assign("fecha_inspeccion", $fecha_inspeccion);
		
		$this->smarty->assign("cont",0);
		$this->smarty->assign("folio_actividad", $folio);
		$this->smarty->assign("token_expediente",$token_expediente);
		$this->smarty->assign("arrLaboratorios", $arrLaboratorios);
		$this->smarty->assign("arrNacionalidad", $arrNacionalidad);
		$this->smarty->assign("arrEstadoReproductivo", $arrEstadoReproductivo);
		$this->smarty->assign("arrDuracionInmunidad", $arrDuracionInmunidad);
		$this->smarty->assign("arrAnimalEspecie", $arrAnimalEspecie);
		$this->smarty->assign("arrAnimalTamano", $arrAnimalTamano);
		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign("arrSintomas", $arrSintomas);
		$this->smarty->assign("arrTipoPerdida", $arrTipoPerdida);

		$formulario	= $this->smarty->fetch('regularizar/formulario_expediente.tpl');
		$salida	    = array('correcto' => $correcto, 'formulario' => $formulario);
		$json	    = json_encode($salida);

		echo $json;
	}

	/**
	* Descripción	: Carga medicamentos por Laboratorio
	*/
    public function cargarMedicamentosporLaboratorio() {
		$laboratorio   = $_POST['laboratorio'];
		$medicamentos  = $this->_DAOVacuna->getByIdLaboratorio($laboratorio);
		$json		   = array();
		$i			   = 0;
		$bo_otro	   = 0;

        if(!empty($medicamentos)){
            foreach($medicamentos as $raza) {
                $json[$i]['id_vacuna']          = $raza->id_vacuna;
                $json[$i]['gl_nombre_vacuna']   = $raza->gl_nombre_vacuna;
                $i++;
                
                if($raza->id_vacuna == 1){
                    $bo_otro = 1;
                }
            }
            if(!$bo_otro){
                $json[$i]['id_vacuna']          = 1;
                $json[$i]['gl_nombre_vacuna']   = "OTRO";
            }
        }
		echo json_encode($json);
    }
    
    /**
	* Llama a formulario y carga datos
	*/
	public function buscar() {
		Acceso::redireccionUnlogged($this->smarty); // valida si está logueado
		$parametros     = $this->_request->getParams();
		$codigo         = $parametros['codigo'];
		$arrWSBichito   = $this->_DAOAuditoriaWS->getByIdBichito($codigo);
		$mensaje 		= "Error. Ocurrió un problema inesperado";
		
		unset($_SESSION[SESSION_BASE]['datos_respaldo']);
		if(empty($arrWSBichito)){
			$correcto	= false;
			$mensaje 	= "Error. No se encontró el registro solicitado.";
		}else{
	        $respaldo       = json_decode($arrWSBichito->json_respuesta,TRUE);
	        $cont           = 0;
	        $arr            = array();
	        
	        if(!empty($respaldo)){
	            foreach($respaldo as $key => $item){
	                if(isset($respaldo[$key]["doc"]["mordedores"])){
	                    $datos_usuario  = $this->_DAOAccesoUsuario->getById($item["doc"]["id_usuario"]);

	                    $estado_expediente          = $this->_DAOExpediente->getById($item["doc"]["id_expediente"])->id_expediente_estado;
	                    $lista_estados_expediente   = $this->_DAOExpedienteEstado->getLista();

	                    $class_estado_web  = "";
	                    $nombre_estado_web = "";

	                    foreach($lista_estados_expediente as $estado) {
	                        if($estado->id_expediente_estado == $estado_expediente) {
	                            $class_estado_web  = $estado->gl_class;
	                            $nombre_estado_web = $estado->gl_nombre;
	                        }
	                    }

	                    $arr[$key]['id_expediente']       = $item["doc"]['id_expediente'];
	                    $arr[$key]['gl_folio']            = $item["doc"]['gl_folio'];
	                    $arr[$key]['cantidad_mordedores'] = count($item["doc"]["mordedores"]);
	                    $arr[$key]['estado_web']          = $estado_expediente;
	                    $arr[$key]['class_estado_web']    = $class_estado_web;
	                    $arr[$key]['nombre_estado_web']   = $nombre_estado_web;
	                    $arr[$key]['fiscalizador_nombre'] = $datos_usuario->gl_nombres.' '.$datos_usuario->gl_apellidos;
	                    $arr[$key]['fiscalizador_rut']    = $datos_usuario->gl_rut;

	                }
	            }
	        }else{
				$mensaje 	= "Error. Codigo ingresado no tiene datos para Regularizar.";
			}
	        
			$this->smarty->assign("arrFiscalizacion", $arr);
	        
			$_SESSION[SESSION_BASE]['datos_respaldo'] = $respaldo;

			if(count($arr)>0){
				$correcto	= true;
				$mensaje 	= "Carga exitosa.";
			}
			
		}
		
		$grilla	= $this->smarty->fetch('regularizar/fiscalizacion_tabla.tpl');
		$salida	= array('correcto' => $correcto, 'grilla' => $grilla, 'mensaje' => $mensaje);
		$json	= json_encode($salida);
		echo $json;
	}
    
    /**
	* Descripción	: Guardar BD Fiscalizacion
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param        array form
	*/
    public function guardarFiscalizacion() {
        Acceso::redireccionUnlogged($this->smarty);
        $params                 = $this->_request->getParams();
        $adjuntos               = $_SESSION[SESSION_BASE]['adjuntos'];
        $respaldo               = $_SESSION[SESSION_BASE]['respaldo']['doc']['mordedores'];
        $cantidad               = $params['cantidad_mordedores'];
        $fecha_caducidad_vacuna = "";
        $arr_region_propietario = array();
        $arr_comuna_propietario = array();
        $tipos_sintoma          = array();
        $total_adjuntos 		= 0;
		$correcto				= false;
		$mensaje				= 'Error';
		$mensaje_error			= 'Error Inesperado';
		$cd_error				= 0;
		$recargaTabla			= false;
		$array_log				= array();
		$gl_origen				= 'REGULARIZAR';

        if(isset($params['cantidad_mordedores'])){
            //Construyo los datos de cada mordedor que se enviaran por WS
            
			for($i=0;$i<=$cantidad-1;$i++){
                $arrEspecie         = $this->_DAOAnimalEspecie->getById($params['id_animal_especie'.$i]);
                $arrRaza            = $this->_DAOAnimalRaza->getById($params['id_animal_raza'.$i]);
                $arrTamano          = $this->_DAOAnimalTamano->getById($params['id_animal_tamano'.$i]);
                $arrRegionAnimal    = $this->_DAORegion->getById($params['id_region_animal'.$i]);
                $arrComunaAnimal    = $this->_DAOComuna->getById($params['id_comuna_animal'.$i]);
                $arrLaboratorio     = $this->_DAOVacunaLaboratorio->getById($params['id_laboratorio'.$i]);
                $arrNacionalidad    = $this->_DAONacionalidad->getById($params['nacionalidad'.$i]);
                
                if(intval($params['id_duracion_inmunidad'.$i])>0 && intval($params['id_duracion_inmunidad'.$i])<4){
                    $fecha                  = date ( 'Y-m-d' , strtotime(Fechas::formatearBaseDatosSinComilla($params['fc_vacunacion'.$i])) );
                    $fecha_caducidad_vacuna = strtotime ( '+'.$params['id_duracion_inmunidad'.$i].' year' , strtotime ( $fecha ) ) ;
                    $fecha_caducidad_vacuna = date ( 'd-m-Y' , $fecha_caducidad_vacuna );
                }
                
                $regionPropietario    = $this->_DAORegion->getById($params['region_propietario'.$i]);
                $comunaPropietario    = $this->_DAOComuna->getById($params['comuna_propietario'.$i]);
                
                if($regionPropietario){
                    $arr_region_propietario = array(
													'id'			=> $regionPropietario->id_region,
                                                    'nombre'		=> $regionPropietario->gl_nombre_region,
                                                    'nombre_corto'	=> $regionPropietario->gl_nombre_corto
													);
                }
                
                if($comunaPropietario){
                    $arr_comuna_propietario = array(
													'id'			=> $comunaPropietario->id_comuna,
                                                    'id_provincia'	=> $comunaPropietario->id_provincia,
                                                    'id_region'		=> $comunaPropietario->id_region,
                                                    'nombre'		=> $comunaPropietario->gl_nombre_comuna
													);
                }

                //Crear array
                if(!empty($params['chk-sintomas'.$i])){
                    foreach($params['chk-sintomas'.$i] as $sintoma){
                        $arrSintoma = $this->_DAOSintomasTipo->getById($sintoma);
                        $tipos_sintoma[] = array(
												'id'		=> $arrSintoma->id_tipo_sintoma,
												'nombre'	=> $arrSintoma->gl_nombre,
												'orden'		=> $arrSintoma->nr_orden,
												'$$hashKey'	=> ""
												);
                    }
                }

                //MORDEDOR
                $respaldo[$i]['id_animal_estado']           = $params['id_animal_estado'.$i];
                $respaldo[$i]['id_animal_especie']          = $params['id_animal_especie'.$i];
                $respaldo[$i]['gl_especie_animal']          = (!empty($arrEspecie))?$arrEspecie->gl_nombre:"";
                $respaldo[$i]['id_animal_raza']             = $params['id_animal_raza'.$i];
                $respaldo[$i]['gl_raza_animal']             = (!empty($arrRaza))?$arrRaza->gl_nombre:"";
                //$respaldo[$i]['nombre_animal']              = $params['nombre_mordedor'.$i];
                $respaldo[$i]['gl_nombre']             		= $params['nombre_mordedor'.$i];
                $respaldo[$i]['gl_color_animal']            = $params['gl_color_animal'.$i];
                $respaldo[$i]['id_animal_tamano']           = $params['id_animal_tamano'.$i];
                $respaldo[$i]['gl_tamano_animal']           = (!empty($arrTamano))?$arrTamano->gl_nombre:"";
                $respaldo[$i]['nr_edad']                    = $params['nr_edad'.$i];
                $respaldo[$i]['nr_edad_meses']              = $params['nr_edad_meses'.$i];
                $respaldo[$i]['nr_peso']                    = $params['nr_peso'.$i];
                $respaldo[$i]['gl_apariencia']              = $params['gl_apariencia'.$i];
                $respaldo[$i]['id_animal_sexo']             = $params['id_animal_sexo'.$i];
                $respaldo[$i]['id_estado_productivo']       = $params['id_estado_productivo'.$i];
                $respaldo[$i]['id_region_animal']           = $params['id_region_animal'.$i];
                $respaldo[$i]['gl_region']                  = (!empty($arrRegionAnimal))?$arrRegionAnimal->gl_nombre_region:"";
                $respaldo[$i]['id_comuna_animal']           = $params['id_comuna_animal'.$i];
                $respaldo[$i]['gl_comuna']                  = (!empty($arrComunaAnimal))?$arrComunaAnimal->gl_nombre_comuna:"";
                $respaldo[$i]['gl_direccion']               = $params['gl_direccion_mordedor'.$i];
                $respaldo[$i]['gl_referencias_animal']      = $params['gl_referencias_animal'.$i];
                $respaldo[$i]['gl_microchip']               = $params['gl_microchip'.$i];
                $respaldo[$i]['fc_microchip']               = $params['fc_microchip'.$i];
                $respaldo[$i]['tipos_sintoma']    			= $tipos_sintoma;
                $respaldo[$i]['bo_sintomas_rabia']          = $params['bo_sintomas_rabia'.$i];
                
                $respaldo[$i]['fc_eutanasia']								= $params['fc_eutanasia'.$i];
                $respaldo[$i]['gl_descripcion']								= $params['gl_descripcion'.$i];
                $respaldo[$i]['bo_antirrabica_vigente']						= $params['bo_antirrabica_vigente'.$i];
                $respaldo[$i]['fc_vacuna']									= $params['fc_vacunacion'.$i];
                $respaldo[$i]['fecha_proxima_vacunacion_mordedor']			= $params['fc_proxima_vacunacion'.$i];
                $respaldo[$i]['fc_vacuna_expira']							= $params['fc_proxima_vacunacion'.$i];
                $respaldo[$i]['id_duracion_inmunidad']                  	= $params['id_duracion_inmunidad'.$i];

                //VACUNAS
                $respaldo[$i]['vacunas'][0]['id_laboratorio']               = $params['id_laboratorio'.$i];
                $respaldo[$i]['vacunas'][0]['gl_laboratorio']               = (!empty($arrLaboratorio))?$arrLaboratorio->gl_nombre_laboratorio:"";
                $respaldo[$i]['vacunas'][0]['id_medicamento']               = $params['id_medicamento'.$i];
                $respaldo[$i]['vacunas'][0]['gl_medicamento']               = "";
                $respaldo[$i]['vacunas'][0]['gl_certificado_vacuna']        = $params['numero_certificado'.$i];
                $respaldo[$i]['vacunas'][0]['gl_numero_serie_vacuna']       = $params['gl_numero_serie_vacuna'.$i];
                $respaldo[$i]['vacunas'][0]['fc_caducidad_vacuna']          = $fecha_caducidad_vacuna;
                $respaldo[$i]['vacunas'][0]['gl_microchip']          		= $params['gl_microchip'.$i];

                //PROPIETARIO
                $respaldo[$i]['propietario']['bo_conocido']                 = (!empty($params['gl_nombre_propietario'.$i]))?1:0;
                $respaldo[$i]['propietario']['bo_extranjero']               = $params['bo_extranjero'.$i];
                $respaldo[$i]['propietario']['nacionalidad']                = $params['nacionalidad'.$i];
                $respaldo[$i]['propietario']['id_pais']                     = (!empty($arrNacionalidad))?$arrNacionalidad->id_pais:"";
                $respaldo[$i]['propietario']['bo_rut_emitido']              = (isset($params['emitidoChile'.$i]))?intval($params['emitidoChile'.$i]):0;
                $respaldo[$i]['propietario']['bo_rut_informado']            = (!empty($params['gl_rut'.$i]))?1:0;
                $respaldo[$i]['propietario']['gl_rut']                      = $params['gl_rut'.$i];
                $respaldo[$i]['propietario']['gl_pasaporte']                = $params['gl_pasaporte'.$i];
                $respaldo[$i]['propietario']['gl_nombre']                   = $params['gl_nombre_propietario'.$i];
                $respaldo[$i]['propietario']['gl_apellido_paterno']         = $params['apell_paterno_propietario'.$i];
                $respaldo[$i]['propietario']['gl_apellido_materno']         = $params['apell_materno_propietario'.$i];
                $respaldo[$i]['propietario']['gl_email']                    = $params['gl_email'.$i];
                $respaldo[$i]['propietario']['telefono_propietario']        = $params['telefono_propietario'.$i];
                $respaldo[$i]['propietario']['direccion_propietario']       = $params['direccion_propietario'.$i];
                $respaldo[$i]['propietario']['referencia_direccion']        = $params['referencias_direccion_propietario'.$i];
                $respaldo[$i]['propietario']['id_region']                   = $params['region_propietario'.$i];
                $respaldo[$i]['propietario']['id_comuna']                   = $params['comuna_propietario'.$i];
                $respaldo[$i]['propietario']['region']                      = $arr_region_propietario;
                $respaldo[$i]['propietario']['comuna']                      = $arr_comuna_propietario;

                //ADJUNTOS
                if(is_array($respaldo[$i]['adjuntos']) && !empty($respaldo[$i]['adjuntos'])){
                	foreach ($respaldo[$i]['adjuntos'] as $adjunto) {
                		$adjuntos[$i][$adjunto["id_adjunto_tipo"]] = $adjunto;
                	}
                	unset($adjunto);
                }
                $respaldo[$i]['adjuntos']   = array();
            }

            //Si hay adjuntos, limpio el array a utilizar
	        //Y cuento la cantidad de adjuntos
	        if(is_array($adjuntos) && !empty($adjuntos)){
	        	foreach ($adjuntos as &$adjuntos_mordedor) {
	        		foreach ($adjuntos_mordedor as &$adjunto) {
	        			if($adjunto["id_adjunto_tipo"] == 3 && isset($adjunto["imagen_eutanasia_mordedor"]) 
	        				&& !empty($adjunto["imagen_eutanasia_mordedor"])) {
	                        $total_adjuntos++;
	                    } else if($adjunto["id_adjunto_tipo"] == 5 && isset($adjunto["imagen_microchip_mordedor"]) 
	                    	&& !empty($adjunto["imagen_microchip_mordedor"])) {
	                        $total_adjuntos++;
	                    } else if($adjunto["id_adjunto_tipo"] == 6 && isset($adjunto["imagen_certificado_vacuna_mordedor"]) 
	                    	&& !empty($adjunto["imagen_certificado_vacuna_mordedor"])) {
	                        $total_adjuntos++;
	                    } else if($adjunto["id_adjunto_tipo"] == 8 && isset($adjunto["imagen_sumario"]) 
	                    	&& !empty($adjunto["imagen_sumario"])) {
	                        $total_adjuntos++;
	                    }
	        			unset($adjunto["grilla"]);	
	        		}
					unset($adjunto);
	        	}
	        	unset($adjuntos_mordedor);
	        }

	        //Construyo los datos de la inspección que se enviará por WS
            $_SESSION[SESSION_BASE]['respaldo']['doc']['mordedores']= $respaldo;
            $documento												= $_SESSION[SESSION_BASE]['respaldo']['doc'];
            $documento["json_expediente"]							= null;
            $documento["json_direccion_mordedura"]					= null;
            $documento["datos_generales_ficha"]						= null;
            $documento["datos_cabecera"]							= null;
            $documento["pacientes"]									= null;
            $documento["_token_fiscalizacion"]						= $_SESSION[SESSION_BASE]['respaldo']['doc']['_id'];

            //Datos para formularios incompletos
            /**************************************************************************************/
            if($params['ingresa_datos_visita'] == 1){
	            $documento["bo_se_niega_visita"]	= $params['bo_se_niega_visita'];
	            $documento["id_visita_estado"]		= $params['id_visita_estado'];
	            $documento["fecha_inspeccion"]		= $params['fecha_inspeccion'];
	            //$documento["resultado_inspeccion"]	= $params['ingresa_datos_visita'];
            }
            /*************************************************************************************/
            
            //Enviar Fiscalización
            $wsdl					= WSDL_MORDEDOR;//WSDL_MORDEDORES;
            $ws						= new nusoap_client($wsdl,'wsdl');
            $ws->soap_defencoding	= 'UTF-8';
            $ws->decode_utf8 		= false;
			
            if($ws->getError()){
				$error		= true;
				$correcto	= false;
				$msg		= 'Problemas con WebService';
			}else{
				$ws_data	= array(
									//'key_public'	=> '14Rk4Ikbr14Z7fqW3bayt2aHvu4ReYgdPvuNUV2QvAs8',
									'rut' 		 		=> $_SESSION[SESSION_BASE]['rut'],
									'password' 	 		=> '',
									'token_dispositivo'	=> $gl_origen,
									'datos_json'		=> json_encode($documento),
									'cantidad_adjuntos'	=> $total_adjuntos,
									'appVersion'        => '1.0.0',
								);
				$param		= array('data' => $ws_data);
				$result		= $ws->call('enviarFiscalizacionMordedores', $param);

				$gl_glosa	= $result['gl_glosa'];
				$cd_error 	= $result['tipo_error'];

				$array_log['enviarFiscalizacionMordedores']	= array(
																	'data'	=> $ws_data,
																	'result'=> $result,
																	);
				//Enviar Adjunto
	           	$ws_data	= array(
								'rut' 		 		=> $_SESSION[SESSION_BASE]['rut'],
								'password' 	 		=> '',
								'token_dispositivo'	=> $gl_origen,
								'datos_json'		=> '',
								'cantidad_adjuntos'	=> 0,
								'appVersion'        => '1.0.0',
							);	

	           	if(!empty($result['resultado']) && $cd_error == 'SUCCESS'){
					$correcto		= true;
					$mensaje		= 'Visita Sincronizada';
					$mensaje_error	= '';

				}else if(!empty($result['resultado']) && $cd_error == 'WARNING_REGISTRO_ESPERA_ADJUNTOS'){
					if(is_array($adjuntos)){
						$errores_adjuntos				= array();
		            	$envio_exitoso					= true;
			           	$ws_data['cantidad_adjuntos']	= $total_adjuntos;

						foreach ($adjuntos as $key => $adjuntos_mordedor) {
			           		$datos_json_mordedor = array();

			            	if(!empty($respaldo[$key]["id_mordedor"])){
			            		$datos_json_mordedor["id_mordedor"]	= $respaldo[$key]["id_mordedor"];
			            	}else{
								$datos_json_mordedor["id_interno"]	= $respaldo[$key]["id"];
			            	}

			            	$datos_json_mordedor["folio_mordedor"]		= $respaldo[$key]["gl_folio_mordedor"];
			            	$datos_json_mordedor["_token_fiscalizacion"]= $documento["_token_fiscalizacion"];

			            	if(is_array($adjuntos_mordedor)){
				            	foreach ($adjuntos_mordedor as $key => $adjunto_envio) {
				            		if($key == "adjuntos" || $adjuntos_mordedor[$key]["enviado"] === true){
					            		continue;
					            	}else if(!empty($adjunto_envio) && $adjuntos_mordedor[$key]["enviado"] !== true){
						                
				            			if(isset($adjunto_envio["id_adjunto_tipo"])){
						            		if($adjunto_envio["id_adjunto_tipo"] == 3) {
						                        $tipo_archivo	= "imagen_eutanasia_mordedor";
						                    } else if($adjunto_envio["id_adjunto_tipo"] == 5) {
						                        $tipo_archivo	= "imagen_microchip_mordedor";
						                    } else if($adjunto_envio["id_adjunto_tipo"] == 6) {
						                        $tipo_archivo	= "imagen_certificado_vacuna_mordedor";
						                    } else if($adjunto_envio["id_adjunto_tipo"] == 8) {
						                        $tipo_archivo	= "imagen_sumario";
						                    }

						                    $datos_json_mordedor["adjunto"]["archivo"]			= $adjunto_envio[$tipo_archivo];
						                    $datos_json_mordedor["adjunto"]["id_adjunto_tipo"]	= $adjunto_envio["id_adjunto_tipo"];
						                    $datos_json_mordedor["adjunto"]["gl_descripcion"]	= $adjunto_envio["gl_descripcion"];
						           			
						           			//si tiene una imagen ingresada, entonces se envia para sincronizar
						           			if(!empty($datos_json_mordedor["adjunto"]["archivo"])){
						           				//llamo al webservice
						           				$ws_data['datos_json']	= json_encode($datos_json_mordedor);
						           				$param					= array('data' => $ws_data);
												$result_adjunto			= $ws->call('enviarAdjuntoMordedores', $param);

												$array_log['enviarAdjuntoMordedores'][]	= array(
																								'data'	=> $ws_data,
																								'result'=> $result_adjunto,
																								);
												//valido respuesta del webservice
												if(isset($result_adjunto) && $result_adjunto["tipo_error"] === 'SUCCESS' || $result_adjunto["tipo_error"] === 'WARNING_ARCHIVO_EXISTENTE'){
													$adjuntos_mordedor[$key]["enviado"]	= true;
												}
												elseif(isset($result_adjunto) && $result_adjunto["resultado"] != true){
													$envio_exitoso		= false;
													$errores_adjuntos[]	= array("tipo_error" => $result_adjunto["tipo_error"], "gl_glosa" => $result_adjunto["gl_glosa"]);
												}else{
													$envio_exitoso		= false;
													$errores_adjuntos[]	= array("tipo_error" => $result_adjunto["tipo_error"], "gl_glosa" => "error desconocido: ".$result_adjunto["gl_glosa"]);
												}

												unset($datos_json_mordedor["adjunto"]["archivo"]);
												unset($datos_json_mordedor["adjunto"]["id_adjunto_tipo"]);
												unset($datos_json_mordedor["adjunto"]["gl_descripcion"]);
												$adjuntos_mordedor[$key]["enviado"] = true;
						           			}

				            			}else{
				            				$envio_exitoso		= false;
											$errores_adjuntos[]	= array("tipo_error" => "ERROR_DESCONOCIDO", "gl_glosa" => "error en adjunto");
				            			}
				            		}
				            	}
			            	}
			            }

			            if(!$envio_exitoso || !empty($errores_adjuntos)){
							$mensaje_error	= 'Error en envío de adjuntos:<br/>';

							foreach ($errores_adjuntos as $error) {
								$mensaje_error	.= '- '.$error['gl_glosa'].'<br/>';
								$cd_error		.= $error['tipo_error'].',';
							}

		            	}else{
		            		$ws_data	= array(
									//'key_public'	=> '14Rk4Ikbr14Z7fqW3bayt2aHvu4ReYgdPvuNUV2QvAs8',
									'rut' 		 			=> $_SESSION[SESSION_BASE]['rut'],
									'password' 	 			=> '',
									'token_dispositivo'		=> $gl_origen,
									'datos_json'			=> json_encode(array('_token_fiscalizacion' => $documento['_token_fiscalizacion'])),
									'cantidad_adjuntos'		=> $total_adjuntos,
									'cantidad_mordedores'	=> $params['cantidad_mordedores'],
									'appVersion'        	=> '1.0.0',
								);
							$param		= array('data' => $ws_data);
							$validacion	= $ws->call('validarEnvioFiscalizacionMordedores', $param);

							$array_log['validarEnvioFiscalizacionMordedores']	= array(
																						'data'	=> $ws_data,
																						'result'=> $result_adjunto,
																						);

							if($validacion["resultado"] == true){
			            		$correcto		= true;
								$mensaje		= $validacion['gl_glosa'].'<br/> Id Visita: '.$validacion['id_fiscalizacion'];
								$mensaje_error	= '';
								$cd_error		= $validacion['tipo_error'];

							}else{
								$mensaje_error	= $validacion['gl_glosa'];
								$cd_error		= $validacion['tipo_error'];
							}
		            	}

					}else{
						$mensaje_error	= 'adjuntos requeridos';
						$cd_error		= 'ERROR_ADJUNTO_REQUERIDO';
					}

				}else{
					$mensaje_error	= $gl_glosa;
					$cd_error		= $cd_error;
				}
			}
        }

		$this->_DAOAuditoriaSincronizarWeb->registro_log($gl_origen,$array_log);
        //$this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, $id_mordedor, $gl_descripcion);
		header('Content-type: application/json');

		$json	= array('correcto'=>$correcto, 'mensaje'=>$mensaje, 'mensaje_error'=>$mensaje_error, 'cd_error'=>$cd_error, 'recargaTabla'=>$recargaTabla);
        echo Zend_Json::encode($json);
	}
    
    /**
	* Descripción	: Cargar Adjunto
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function adjuntar(){
        $id_tipo_adjunto    = 0;
        $cont_mordedor       = 0;
        $params             = $this->_request->getParams();
        
        if(isset($params['id_tipo_adjunto'])){
            $id_tipo_adjunto    = $params['id_tipo_adjunto'];
            $cont_mordedor      = $params['cont_mordedor'];
        }
        
		$this->smarty->assign('id_tipo_adjunto',$id_tipo_adjunto);
		$this->smarty->assign('cont_mordedor',$cont_mordedor);
		$this->smarty->display('regularizar/cargar_adjunto.tpl');
	}
    
    
	/**
	* Descripción	: Permite guardar Adjunto
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @return JSON
	*/
	public function guardarNuevoAdjunto() {
		header('Content-type: application/json');
        $params             = $this->_request->getParams();
		$adjunto            = $_FILES['archivo'];
		$id_tipo_adjunto    = $params['id_tipo_adjunto'];
		$cont_mordedor      = $params['cont_mordedor'];
		$correcto           = false;
		$error              = false;
        $mensaje            = "";
        $grilla             = "";
        
        $ext_permitidas     = array('.jpeg', '.jpg', '.png', '.gif');
        $extension_adjunto  = explode(".",$adjunto['name']);
        $extension_adjunto  = strtolower(substr($adjunto['name'],strpos($adjunto['name'],".")));
        
        //Valida que Extensión de archivo corresponda a las permitidas
        if (!in_array($extension_adjunto, $ext_permitidas)) {
            $mensaje	.= "El Tipo de archivo que intenta subir no está permitido.<br><br>";
            $mensaje	.= "Favor subir un archivo con las siguientes extensiones: <br><b>". implode(" ",$ext_permitidas)."</b><br>";
        }

		if(intval($id_tipo_adjunto)<= 0) {
			$mensaje	.= "Tipo de Documento Adjunto no reconocido. <br>";
		}

        if($mensaje != ""){
            $error      = true;
        }else{
            $nombre_adjunto = $adjunto['name'];
            $nombre_adjunto = strtolower(trim($nombre_adjunto));
            $nombre_adjunto = str_replace(" ","_",$nombre_adjunto);
            $nombre_adjunto = trim($nombre_adjunto, ".");
            
            $file       = fopen($adjunto['tmp_name'], 'r+b');
            $contenido  = fread($file, filesize($adjunto['tmp_name']));
            fclose($file);

            $contenido	= base64_encode($contenido);
            
            $this->smarty->assign("cont_mordedor", $cont_mordedor);

            if($id_tipo_adjunto == 3){
				//Eutanasia
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['id_adjunto_tipo']            = $id_tipo_adjunto;
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['imagen_eutanasia_mordedor']  = $contenido;
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['nombre_documento']           = $adjunto['name'];
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['gl_descripcion']             = "Acta Eutanasia";
            
			}else if($id_tipo_adjunto == 5){
				//Microchip
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['id_adjunto_tipo']            = $id_tipo_adjunto;
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['imagen_microchip_mordedor']  = $contenido;
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['nombre_documento']           = $adjunto['name'];
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['gl_descripcion']             = "Microchip";
            
			}else if($id_tipo_adjunto == 6){
				//Vacuna
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['id_adjunto_tipo']                    = $id_tipo_adjunto;
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['imagen_certificado_vacuna_mordedor'] = $contenido;
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['nombre_documento']                   = $adjunto['name'];
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['gl_descripcion']                     = "Documento Vacuna";
            
			}else if($id_tipo_adjunto == 8){
				//Sumario
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['id_adjunto_tipo']                    = $id_tipo_adjunto;
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['imagen_certificado_sumario']		 	= $contenido;
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['nombre_documento']                   = $adjunto['name'];
                $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]['gl_descripcion']                     = "Documento Sumario";
            }
            
			//Grilla Adjuntos
			$this->smarty->assign("arrAdjunto", $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto]);
			$grilla		= $this->smarty->fetch('regularizar/grilla_adjunto.tpl');
            $correcto	= true;
        }

		$salida	= array('error' => $error, 'correcto' => $correcto, 'grilla' => $grilla, 'mensaje' => $mensaje);
		$json	= Zend_Json::encode($salida);
		echo $json;
	}
    
    /**
	* Descripción	: Ver Adjunto
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function verAdjunto() {
		$parametros         = $this->request->getParametros();
		$id_tipo_adjunto    = $parametros[0];
		$cont_mordedor      = $parametros[1];
        $adjunto            = $_SESSION[SESSION_BASE]['adjuntos'][$cont_mordedor][$id_tipo_adjunto];
        
		if (!empty($adjunto)) {
                
            if($id_tipo_adjunto == 3){
                $doc    = $adjunto['imagen_eutanasia_mordedor'];
                $name   = $adjunto['nombre_documento'];
            }
            if($id_tipo_adjunto == 5){
                $doc    = $adjunto['imagen_microchip_mordedor'];
                $name   = $adjunto['nombre_documento'];
            }
            if($id_tipo_adjunto == 6){
                $doc    = $adjunto['imagen_certificado_vacuna_mordedor'];
                $name   = $adjunto['nombre_documento'];
            }
                
            $extension  = $this->_formatoArchivo->mime_content_type($name);

			header("Content-Type: ".$extension);
			header("Content-Disposition: inline; filename=" . $name);
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			ob_end_clean();

			echo base64_decode($doc);
			exit();
		} else {
			echo "El adjunto no existe";
		}
	}

}