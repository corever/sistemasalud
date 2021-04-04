<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 *
 * Descripción       : Controller para Bitácora
 *
 * Plataforma        : PHP
 *
 * Creación          : 24/05/2018
 *
 * @name             Bitacora.php
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
class Bitacora extends Controller {

	protected $_Evento;
	protected $_DAOExpediente;
	protected $_DAODueno;
	protected $_DAOAdjunto;
	protected $_DAOAdjuntoTipo;
	protected $_DAOPacienteContacto;
	protected $_DAOAnimalGrupo;
	protected $_DAOHistorialEvento;
	protected $_DAOVisita;
	protected $_DAOVisitaTipoResultado;
	protected $_DAOVisitaAnimalMordedor;
	protected $_DAOVisitaTipoPerdida;
	protected $_DAOVacunaLaboratorio;
	protected $_DAOAccesoPerfil;
	protected $_DAOTipoSintoma;
	protected $_DAORegion;
	protected $_DAOComuna;
	protected $_DAOVacunaVigencia;


	function __construct() {
		parent::__construct();
		$this->load->lib('Fechas', false);
		$this->load->lib('Seguridad', false);
		$this->load->lib('Evento', false);

		$this->_Evento                      = new Evento();
		$this->_DAOPaciente                 = $this->load->model("DAOPaciente");
		$this->_DAODueno                    = $this->load->model("DAODueno");
		$this->_DAOExpediente               = $this->load->model("DAOExpediente");
		$this->_DAOAdjunto                  = $this->load->model("DAOAdjunto");
		$this->_DAOAdjuntoTipo              = $this->load->model("DAOAdjuntoTipo");
		$this->_DAOPacienteContacto         = $this->load->model("DAOPacienteContacto");
		$this->_DAOAnimalGrupo              = $this->load->model("DAOAnimalGrupo");
		$this->_DAOHistorialEvento          = $this->load->model("DAOHistorialEvento");
		$this->_DAOVisita                   = $this->load->model("DAOVisita");
		$this->_DAOVisitaTipoResultado      = $this->load->model("DAOVisitaTipoResultado");
		$this->_DAOVisitaAnimalMordedor     = $this->load->model("DAOVisitaAnimalMordedor");
		$this->_DAOVisitaTipoPerdida        = $this->load->model("DAOVisitaTipoPerdida");
		$this->_DAOAccesoPerfil             = $this->load->model("DAOAccesoPerfil");
		$this->_DAOTipoSintoma              = $this->load->model("DAOTipoSintoma");
        $this->_DAOAnimalGrupo              = $this->load->model("DAOAnimalGrupo");
        $this->_DAOAnimalEspecie            = $this->load->model("DAOAnimalEspecie");
        $this->_DAOAnimalRaza               = $this->load->model("DAOAnimalRaza");
        $this->_DAOAnimalTamano             = $this->load->model("DAOAnimalTamano");
        $this->_DAOAnimalEstado             = $this->load->model("DAOAnimalEstado");
        $this->_DAOAnimalEstadoProductivo   = $this->load->model("DAOAnimalEstadoProductivo");
        $this->_DAOAnimalSexo               = $this->load->model("DAOAnimalSexo"    );
        $this->_DAORegion                   = $this->load->model("DAODireccionRegion");
        $this->_DAOComuna                   = $this->load->model("DAODireccionComuna");
        $this->_DAOVacunaLaboratorio        = $this->load->model("DAOVacunaLaboratorio");
        $this->_DAOVacunaVigencia           = $this->load->model("DAOVacunaVigencia");
	}

	public function index() {
		Acceso::redireccionUnlogged($this->smarty);
	}

	/**
	* Descripción	: Bitácora de Expediente Mordedura
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param int $gl_token Token expediente del que se mostrará la Bitácora.
	*/
	public function ver() {
        Acceso::redireccionUnlogged($this->smarty);

		$params             = $this->request->getParametros();
		$token_expediente   = $params[0];
		$id_perfil 			= $_SESSION[SESSION_BASE]['perfil'];

        //Funcion que trae toda la info de bitacora
        $arrExpediente	= $this->_DAOExpediente->getBitacoraByToken($token_expediente);


        $ver_mordedores = false;
        foreach((array)$arrExpediente->arrVisitas as $visita){
        	if($visita->id_visita_estado == 2){//al menos una visita exitosa
        		$ver_mordedores = true;
        	}
        }
        foreach((array)$arrExpediente->arrMordedores as $morde){
        	if(!empty($morde->gl_microchip)){//al menos un mordedor con microchip
        		$ver_mordedores = true;
        	}
        }
        foreach((array)$arrExpediente->arrContactoPac as $key=>$paciente){
        	if(!empty($paciente['json_datos'])){
        		$json = $paciente['json_datos'];
                if($paciente['id_tipo_contacto'] == 3 && empty($json['gl_region'])){
                    $region         = $this->_DAORegion->getById($json['region_contacto']);
                    $comuna         = $this->_DAOComuna->getById($json['comuna_contacto']);
                    $arrExpediente->arrContactoPac[$key]['json_datos']['gl_region'] = (!empty($region))?$region->gl_nombre_region:'';
                    $arrExpediente->arrContactoPac[$key]['json_datos']['gl_comuna'] = (!empty($comuna))?$comuna->gl_nombre_comuna:'';
                }
        	}
        }

		$this->smarty->assign("id_perfil", $id_perfil);
        $this->smarty->assign("arr", $arrExpediente);
        $this->smarty->assign("ver_mordedores", $ver_mordedores);
        $this->smarty->display('bitacora/ver.tpl');
        $this->load->javascript(STATIC_FILES . 'js/templates/bitacora/ver.js');
        $this->load->javascript(STATIC_FILES . "js/templates/bitacora/mapa.js");

	}

	/**
	* Descripción	: Permite guardar Adjunto desde Bitácora
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @return JSON
	*/
	public function guardarNuevoAdjunto() {
		header('Content-type: application/json');

		$adjunto            = $_FILES['archivo'];
		$token_expediente   = $_POST['tkexp'];
		$tipo_doc           = $_POST['tipodoc'];
		$tipo_txt           = $_POST['tipotxt'];
		$glosa              = $_POST['comentario'];
		$glosa              = trim($glosa);
		$correcto           = false;
		$error              = false;
        $arrExpediente      = $this->_DAOExpediente->getDetalleByToken($token_expediente);
        $id_expediente      = $arrExpediente->id_expediente;
        $id_paciente        = $arrExpediente->id_paciente;
        $adjuntos_exp       = $this->_DAOAdjunto->getByIdExpediente($id_expediente);
        $correlativo        = (count((array)$adjuntos_exp))+1;
        $mensaje            = "";
        $grilla             = "";

        $ext_permitidas     = array('.jpeg', '.jpg', '.png', '.gif', '.tiff', '.bmp', '.pdf', '.txt',
                                    '.csv', '.doc', '.docx', '.ppt', '.pptx', '.xls', '.xlsx');

        $extension_adjunto  = explode(".",$adjunto['name']);
        $extension_adjunto  = substr($adjunto['name'],strpos($adjunto['name'],"."));

        //Valida que Extensión de archivo corresponda a las permitidas
        if (!in_array($extension_adjunto, $ext_permitidas)) {
            $mensaje    = "El Tipo de archivo que intenta subir no está permitido.<br><br>";
            $mensaje    .= "Favor elija un archivo con las siguientes extensiones: <br>";
            $mensaje    .= implode(" ",$ext_permitidas)."<br>";
        }

        if($mensaje != ""){
            $error      = true;
        }else{

            if ($glosa == '') {
                $glosa		= 'Adjunta Documento por Bitácora';
            }

            $nombre_adjunto = $adjunto['name'];

            $nombre_adjunto = strtolower(trim($nombre_adjunto));
            $nombre_adjunto = str_replace(" ","_",$nombre_adjunto);
            $nombre_adjunto = trim($nombre_adjunto, ".");

            /*$date           = new DateTime();
            $result         = $date->format('H-i');
            $krr            = explode('-', $result);
            $result         = implode("", $krr);*/

            $gl_nombre		= $correlativo . '_' . $nombre_adjunto;

            $directorio     = "archivos/documentos/expediente_$id_expediente/";
            $gl_path        = $directorio . $gl_nombre;

            $gl_token_adjunto = Seguridad::generaTokenAdjunto($directorio.$gl_nombre);
            $arr_data = array(  $gl_token_adjunto,
                                $id_expediente,
                                0,
                                $id_paciente,
                                0,
                                $tipo_doc,
                                $gl_nombre,
                                $directorio.$gl_nombre,
                                $glosa,
                                0
            );
            $id_adjunto = $this->_DAOAdjunto->insertarAdjunto($arr_data);

            if($id_adjunto) {
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0775, true);
                    chmod($directorio, 0775);

                    $out	= fopen($directorio . '/index.html', "w");
                    fwrite($out, "<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>");
                    fclose($out);
                    chmod($directorio . '/index.html', 0664);
                }

                //Revisar codigo
                $file       = fopen($adjunto['tmp_name'], 'r+b');
                $contenido  = fread($file, filesize($adjunto['tmp_name']));
                fclose($file);

                $out        = fopen($gl_path, "w");
                fwrite($out, $contenido);
                fclose($out);
                chmod($gl_path, 0664);

                //Grilla Adjuntos
                $arrAdjuntos        = $this->_DAOAdjunto->getByIdExpediente($id_expediente);
                $arr                = (object)array("arrAdjuntos"=>$arrAdjuntos);
				$this->smarty->assign("id_perfil", $_SESSION[SESSION_BASE]['perfil']);
                $this->smarty->assign("arr", $arr);

                $grilla		= $this->smarty->fetch('bitacora/grillaAdjuntos.tpl');
                $correcto	= true;

                //Guardar Evento
                $id_evento_tipo = 11; //Se guarda nuevo adjunto en bitacora
                $gl_descripcion = "Se guarda Adjunto tipo: ".$tipo_txt." por Bitacora";
                $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, 0, $gl_descripcion);

            }else{
                $error		= true;
            }
        }

		$salida	= array('error' => $error, 'correcto' => $correcto, 'grilla' => $grilla, 'mensaje' => $mensaje);
		$json	= Zend_Json::encode($salida);
		echo $json;
	}

	/**
	* Descripción	: Permite guardar Adjunto desde Bitácora
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @return JSON
	*/
	public function guardarNuevoComentario() {
		header('Content-type: application/json');

		$token_expediente           = $_POST['tkexp'];
		$gl_descripcion             = trim($_POST['comentario']);
		$id_tipo_comentario         = $_POST['tipoComent'];
		$gl_otro_tipo_comentario    = $_POST['otroTipoComent'];
		$correcto                   = false;
		$error                      = true;
        $arrExpediente              = $this->_DAOExpediente->getDetalleByToken($token_expediente);
        $id_expediente              = $arrExpediente->id_expediente;
        $id_paciente                = $arrExpediente->id_paciente;
        $perfil                     = $this->_DAOAccesoPerfil->getById($_SESSION[SESSION_BASE]['perfil']);

        //Guardar Evento
        if ($perfil->bo_establecimiento == 1 && $perfil->id_perfil == 3){
        	$id_evento_tipo = 25; //Comentario Expediente (Establecimiento)
        }else if($perfil->bo_seremi == 1){
        	$id_evento_tipo = 26; //Comentario Expediente (SEREMI)
        }else{
        	$id_evento_tipo = 24; //Comentario Expediente
        }
        $this->_Evento->guardar($id_evento_tipo, $id_expediente, $id_paciente, 0, $gl_descripcion, $id_tipo_comentario,1,$gl_otro_tipo_comentario);

		//Grilla Historial
        $arr                = (object)array("arrEventos"=>$this->_DAOExpediente->getHistorialByExpediente($id_expediente));
        $this->smarty->assign("arr", $arr);

		$grilla		= $this->smarty->fetch('bitacora/grillaHistorial.tpl');
		$correcto	= true;

		$salida	= array('error' => $error, 'correcto' => $correcto, 'grilla' => $grilla);
		$json	= Zend_Json::encode($salida);
		echo $json;
	}

    /**
	* Descripción	: Ver Dueño por Token - Bitacora (grilla Mordedores)
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param string $gl_token Token de dueño
	*/
	public function verDueno() {
        Acceso::redireccionUnlogged($this->smarty);

		$params         = $this->_request->getParams();
		$token_dueno    = $params['token_dueno'];

        //Funcion que trae toda la info de bitacora
        $arrDueno	= $this->_DAODueno->getById($token_dueno);
        $this->smarty->assign("arr", $arrDueno);

        $this->smarty->display('bitacora/verDueno.tpl');

	}

    /**
	* Descripción	: Ver Detalle Visita por Token - Bitacora (grilla visitas)
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param string $gl_token Token de visita
	*/
	public function detalleVisita() {
        Acceso::redireccionUnlogged($this->smarty);

		$params                 = $this->_request->getParams();
		$token_fiscalizacion    = $params['token'];

        $arrVisita          = $this->_DAOVisita->getByToken($token_fiscalizacion);
        $arrExpediente      = $this->_DAOExpediente->getBitacoraByToken($arrVisita->gl_token_expediente);
        $arrTipoResultados	= $this->_DAOVisitaTipoResultado->getLista();
        $arrTipoPerdida     = $this->_DAOVisitaTipoPerdida->getLista();
        $arrMordedores      = $this->_DAOVisitaAnimalMordedor->getByIdVisita($arrVisita->id_visita);
        $arrSintomas        = $this->_DAOTipoSintoma->getLista();

        if($arrMordedores){
            foreach($arrMordedores as $key=>$item){
                $arrMordedores->$key->arrAdjuntos   = $this->_DAOAdjunto->getByVisitaAndMordedor($arrVisita->id_visita,$item->id_mordedor);
                $mor_visita                         = json_decode($item->json_mordedor_visita,true);
                $arrAnimalEspecie                   = (isset($mor_visita['id_animal_especie']))?$this->_DAOAnimalEspecie->getById($mor_visita['id_animal_especie']):array();
                $arrAnimalRaza                      = (isset($mor_visita['id_animal_raza']))?$this->_DAOAnimalRaza->getById($mor_visita['id_animal_raza']):array();
                $arrAnimalTamano                    = (isset($mor_visita['id_animal_tamano']))?$this->_DAOAnimalTamano->getById($mor_visita['id_animal_tamano']):array();
                $arrAnimalEstado                    = (isset($mor_visita['id_animal_estado']))?$this->_DAOAnimalEstado->getById($mor_visita['id_animal_estado']):array();
                $arrAnimalEstadoProductivo          = (isset($mor_visita['id_estado_productivo']))?$this->_DAOAnimalEstadoProductivo->getById($mor_visita['id_estado_productivo']):array();
                $arrAnimalSexo                      = (isset($mor_visita['id_animal_sexo']))?$this->_DAOAnimalSexo->getById($mor_visita['id_animal_sexo']):array();
                $region                             = (isset($mor_visita['id_region']))?$this->_DAORegion->getById($mor_visita['id_region']):array();
                $comuna                             = (isset($mor_visita['id_comuna']))?$this->_DAOComuna->getById($mor_visita['id_comuna']):array();
                $arrMordedor                        = $mor_visita;
                $arrMordedor['gl_animal_especie']   = (!empty($arrAnimalEspecie))?$arrAnimalEspecie->gl_nombre:'';
                $arrMordedor['gl_animal_raza']      = (!empty($arrAnimalRaza))?$arrAnimalRaza->gl_nombre:'';
                $arrMordedor['gl_animal_tamano']    = (!empty($arrAnimalTamano))?$arrAnimalTamano->gl_nombre:'';
                $arrMordedor['gl_animal_estado']    = (!empty($arrAnimalEstado))?$arrAnimalEstado->gl_nombre:'';
                $arrMordedor['gl_estado_productivo']= (!empty($arrAnimalEstadoProductivo))?$arrAnimalEstadoProductivo->gl_nombre:'';
                $arrMordedor['gl_animal_sexo']      = (!empty($arrAnimalSexo))?$arrAnimalSexo->gl_nombre:'';
                $arrMordedor['gl_region']           = (!empty($region))?$region->gl_nombre_region:'';
                $arrMordedor['gl_comuna']           = (!empty($comuna))?$comuna->gl_nombre_comuna:'';
                $arrMordedor['json_vacuna']         = (isset($mor_visita['json_vacuna'][0]))?$mor_visita['json_vacuna'][0]:array();
                $id_laboratorio                     = (isset($arrMordedor['json_vacuna']['id_laboratorio']))?$arrMordedor['json_vacuna']['id_laboratorio']:0;
                $arrLaboratorio                     = $this->_DAOVacunaLaboratorio->getById($id_laboratorio);
                $arrVigenciaVacuna                  = $this->_DAOVacunaVigencia->getByIdTablet($mor_visita['bo_antirrabica_vigente']);
                $arrMordedor['gl_laboratorio']      = (isset($arrLaboratorio->gl_nombre_laboratorio))?$arrLaboratorio->gl_nombre_laboratorio:"-";
                $arrMordedor['gl_vacuna_vigencia']  = (isset($arrVigenciaVacuna->gl_nombre))?$arrVigenciaVacuna->gl_nombre:"-";
                $json_otros_datos                   = (isset($mor_visita['json_otros_datos']))?json_decode($mor_visita['json_otros_datos']):array();
                $arrMordedores->$key->json_otros_datos = (is_null($json_otros_datos))?json_encode($mor_visita['json_otros_datos']):$json_otros_datos;
                $arrMordedores->$key->arrMordedor   = json_encode($arrMordedor);
            }
        }

        $this->smarty->assign("arr", $arrVisita);
        $this->smarty->assign("arrExpediente", $arrExpediente);
        $this->smarty->assign("arrPasaporte", json_decode($arrExpediente->json_pasaporte,TRUE));
        $this->smarty->assign("arrTipoResultados",$arrTipoResultados);
        $this->smarty->assign("arrTipoPerdida",$arrTipoPerdida);
        $this->smarty->assign("arrMordedores",$arrMordedores);
        $this->smarty->assign("arrSintomas",$arrSintomas);

        $this->smarty->display('bitacora/detalleVisita.tpl');

	}

	public function modificarAdjunto () {

		header('Content-type: application/json');

		$this->load->lib('File', FALSE);
		// File::setDebugMode();

		$adjunto            = $_FILES['archivo_adj'];
		$glosa              = $_POST['comentario'];
		$glosa              = trim($glosa);
		$token  			= $_POST['token_adjunto'];
		$estado           	= 0;
		$error 				= TRUE;
		$correcto			= FALSE;
		$grilla				= "";

		$mensaje 			= File::validate($adjunto);

		if ($mensaje === "") {

			$adjuntoOld			= $this->_DAOAdjunto->getByToken($token);
			$existeArchivo		= File::checkFile($adjuntoOld->gl_path);

			$mensaje			= "Ha ocurrido un error al reemplazar archivo";
			$adjuntos_exp       = $this->_DAOAdjunto->getByIdExpediente($adjuntoOld->id_expediente);
			$correlativo        = (count((array)$adjuntos_exp)); //+1
			$nombre_nuevo		= $adjuntoOld->gl_nombre;
			$extension_nuevo  	= File::getFileExtension($nombre_nuevo);
			$sufijo_adj			= '_old_' . $correlativo . $extension_nuevo;
			$nombre_adjunto		= $nombre_nuevo;
			$nombre_nuevo		= str_replace($extension_nuevo, $sufijo_adj, $nombre_adjunto);
			$directorio			= $adjuntoOld->gl_path;
			$directorio			= str_replace($nombre_adjunto, "", $directorio);
			$gl_path			= $directorio . $nombre_adjunto;
			$path_nuevo			= $directorio . $nombre_nuevo;

			if ($existeArchivo) {

				$archivo_renombrado = rename($gl_path, $path_nuevo);

				if ($archivo_renombrado) {

					$respuesta = $this->_DAOAdjunto->updateAdjunto($adjuntoOld->id_adjunto, $nombre_nuevo, $estado, $path_nuevo, $adjuntoOld->gl_glosa);

					if ($respuesta) {
						$id_evento_tipo	= 11;
						$gl_descripcion = "Se modifica Adjunto tipo: ".$adjuntoOld->id_adjunto_tipo." por Bitacora";
						$this->_Evento->guardar($id_evento_tipo, $adjuntoOld->id_expediente, $adjuntoOld->id_paciente, 0, $gl_descripcion);
					}
				}
			}

			$extension_adjunto	= File::getFileExtension($adjunto["name"]);
			$nombre_adjunto		= str_replace($extension_nuevo, $extension_adjunto, $nombre_adjunto);
			$gl_path			= $directorio . $nombre_adjunto;
			$guardado 			= File::saveFile($directorio, $adjunto, $nombre_adjunto);

			if ($guardado) {

				$gl_token_adjunto	= Seguridad::generaTokenAdjunto($gl_path);
				$arr_data 			= array(
					$gl_token_adjunto,
					$adjuntoOld->id_expediente,
					0,
					$adjuntoOld->id_paciente,
					0,
					$adjuntoOld->id_adjunto_tipo,
					$nombre_adjunto,
					$gl_path,
					$glosa, //$adjuntoOld->gl_glosa,
					0
				);
				$id_adjunto 		= $this->_DAOAdjunto->insertarAdjunto($arr_data);

				if ($id_adjunto) {

					$id_evento_tipo 	= 11;
					$gl_descripcion 	= "Se guarda Adjunto tipo: ".$adjuntoOld->id_adjunto_tipo." por Bitacora";
					$this->_Evento->guardar($id_evento_tipo, $adjuntoOld->id_expediente, $adjuntoOld->id_paciente, 0, $gl_descripcion);

					$correcto 			= TRUE;
					$arrAdjuntos        = $this->_DAOAdjunto->getByIdExpediente($adjuntoOld->id_expediente);
					$arr                = (object)array("arrAdjuntos"=>$arrAdjuntos);
					$this->smarty->assign("id_perfil", $_SESSION[SESSION_BASE]['perfil']);
					$this->smarty->assign("arr", $arr);
					$grilla				= $this->smarty->fetch('bitacora/grillaAdjuntos.tpl');
				}
			}

		}

		$salida	= array('error' => $error, 'correcto' => $correcto, 'grilla' => $grilla, 'mensaje' => $mensaje);
		$json	= json_encode($salida);
		echo $json;
	}

}