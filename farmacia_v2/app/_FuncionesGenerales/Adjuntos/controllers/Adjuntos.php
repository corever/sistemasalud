<?php

namespace App\_FuncionesGenerales\Adjuntos;

use Seguridad;
use Adjunto;
use Pan\Utils\JsonPan;

/**
 * To do, revisar y adaptar al proyecto.
 */
class Adjuntos extends \pan\Kore\Controller {

	protected $daoTipoAdjunto;
	protected $daoUsuario;
	protected $daoAdjunto;

	const PATH_BASE 		= 'store/documentos/';
	const DEFAULT_ID_FORM 	= 'adjuntos';

	public function __construct(){
		parent::__construct();
		$this->daoTipoAdjunto   = new \App\_FuncionesGenerales\Adjuntos\Entity\DAOAdjuntoTipo();
		$this->daoAdjunto       = new \App\_FuncionesGenerales\Adjuntos\Entity\DAOAdjunto();
		$this->daoUsuario       = new \App\Hope\Usuario\Entity\DAOUsuario();
	}

	/**
	* Descripción	: Cargar tipo de adjuntos por id o todos
	* @author		: Alexis Visser <alexis.visser@cosof.cl>
	* @param 		array
	* @return       JSON
	*/
	public function nuevoAdjunto(){
		$params		     	= $this->request->getParametros();
		$id_tipo_adjunto 	= Seguridad::validar($params["idTipo"], "numero");
		$bo_comentario		= Seguridad::validar($params["bo_comentario"], "numero");
		$extAdjunto			= Seguridad::validar($params["ext"], "string");
		$idForm	 			= (!empty($params['idForm']))?Seguridad::validar($params['idForm'], 'string'):$this::DEFAULT_ID_FORM;	
		$idGrillaAdjunto	= Seguridad::validar($params["idGrillaAdjunto"], "string");	
		$arrTipoAdjuntos	= Adjunto::obtTipoAdjunto($id_tipo_adjunto);

		$this->view->set('arrTipoAdjuntos', $arrTipoAdjuntos);
		$this->view->set('bo_comentario', $bo_comentario);
		$this->view->set('idForm', $idForm);
		$this->view->set('extAdjunto', $extAdjunto);
		$this->view->set('idGrillaAdjunto', $idGrillaAdjunto);

		echo $this->view->fetchIt('adjunto/cargarAdjunto.php');
	}

	/**
	* Descripción	: Guardar adjunto temporalmente (sesión)
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param 		array (AJAX)
	* @return       JSON
	*/
	public function guardarTemporal() {
        $respuesta       	= array("correcto" => FALSE, "mensaje" => MSJ_ERROR);
		$params          	= $this->request->getParametros(); 
		$adjunto	     	= $_FILES['adjunto'];
		$bo_comentario   	= Seguridad::validar($params['bo_comentario'], 'numero');
		$id_tipo_adjunto 	= Seguridad::validar($params['id_tipo_adjunto'], 'numero');
		$extAdjunto 		= Seguridad::validar($params['extAdjunto'], 'string');
		$nombreGrilla		= Seguridad::validar($params["nombreGrilla"], "string");
		$gl_comentario 	 	= "";
		$idAdjunto       	= NULL;
		$id_formulario	 	= (isset($params['idForm']))?Seguridad::validar($params['idForm'], 'string'):$this::DEFAULT_ID_FORM;

		if($bo_comentario){
			$gl_comentario = Seguridad::validar($params['comentario_adjunto'], 'string');
		}

		$mensaje = Adjunto::validate($adjunto,$extAdjunto);

		if(isset($params['idx_adjunto'])){
			$idAdjunto = Seguridad::validar($params['idx_adjunto'], 'numero');
		}

		//$arrAdjuntos = Adjunto::getAdjuntosFormulario($id_formulario);
		//$arrAdjuntos = &$_SESSION[][$idSession]['arrForm']['ADJUNTOS'];
		
        if(empty($mensaje)){

			$contenido = Adjunto::readFile($adjunto);

			if(!empty($contenido)) {
				$glTipoAdjunto	= Adjunto::getNombreTipo($id_tipo_adjunto);
				$id_usuario		= $_SESSION[\Constantes::SESSION_BASE]['id'];
				
				$datos_adjunto = array(
					'gl_nombre'			=> $adjunto['name'],
					'gl_mime'			=> $adjunto['type'],
					'id_tipo'	    	=> $id_tipo_adjunto,
					'gl_tipo'	    	=> $glTipoAdjunto,
					'fc_crea'			=> date('d/m/Y'),
					'id_usuario_crea'   => $id_usuario,
					'bo_temporal'		=> 1,
					'contenido'			=> base64_encode($contenido),
				);

				$index = Adjunto::setAdjuntoFormulario($datos_adjunto, $id_formulario);
				$respuesta["mensaje"] = "El archivo <strong>".$adjunto['name']."</strong> ha sido adjuntado correctamente.";
				$respuesta["correcto"] = TRUE;

				$arrAdjuntos = Adjunto::getAdjuntosFormulario($id_formulario);
				$this->view->set('idForm',$id_formulario);
				$this->view->set('nombreGrilla',$nombreGrilla);
				$respuesta["tabla"] = $this->view->fetchIt('grillaAdjuntos.php',["arrAdjuntos" => $arrAdjuntos]);

				$respuesta["cantAdjuntados"]	= count($arrAdjuntos);
				/*
				$respuesta["nombre"] = $datos_adjunto["gl_nombre"];
				$respuesta["tipo"] = $datos_adjunto["gl_tipo"];
				$respuesta["index"] = $index;
				*/

				/*if(is_null($idAdjunto)){
					//$arrAdjuntos[]	= $datos_adjunto;
					Adjunto::setAdjuntoFormulario($datos_adjunto, $id_formulario);
					$respuesta["mensaje"] = "El archivo <strong>".$adjunto['name']."</strong> ha sido Adjuntado";
				} else {
					if(isset($arrAdjuntos[$idAdjunto]['id_adjunto'])){
						$datos_adjunto['id_adjunto'] = $arrAdjuntos[$idAdjunto]['id_adjunto'];
						$datos_adjunto['nombre_anterior'] = $arrAdjuntos[$idAdjunto]['gl_nombre'];
					}
					$nombre_anterior = $arrAdjuntos[$idAdjunto]['gl_nombre'];
					$arrAdjuntos[$idAdjunto] = $datos_adjunto;
					$mensaje = "El archivo <strong>$nombre_anterior</strong> ha sido reemplazado por adjunto <strong>".$adjunto['name']."</strong >";
				}
				$correcto		= TRUE;
				*/
			}
        }
        else{
        	$respuesta["mensaje"] = $mensaje;
        }

        echo JsonPan::enc_json($respuesta);
	}


	/**
	* Descripción	: Eliminar adjunto de grilla
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param 		array (AJAX)
	* @return 		JSON
	*/
	public function eliminarTemporal() {
		$params          = $this->request->getParametros(); 
		$keyAdjunto      = 0;
		$id_formulario	 = (!empty($params['idForm']))?Seguridad::validar($params['idForm'], 'string'):$this::DEFAULT_ID_FORM;
        $respuesta 		 = array("correcto" => FALSE,"mensaje"=>MSJ_ERROR);

		if(isset($params['key'])){
			$keyAdjunto = Seguridad::validar($params['key'], 'numero');
		}

		if(Adjunto::deleteAdjuntosFormulario($keyAdjunto, $id_formulario)){
			$respuesta["correcto"] 	= TRUE;
			$respuesta["mensaje"] 	= "Adjunto eliminado correctamente";

			$arrAdjuntos = Adjunto::getAdjuntosFormulario($id_formulario);
			$this->view->set('idForm',$id_formulario);
			$respuesta["tabla"] = $this->view->fetchIt('grillaAdjuntos.php',["arrAdjuntos" => $arrAdjuntos]);
			$respuesta['cantAdjuntados'] = count($arrAdjuntos);
		}
		

		echo JsonPan::enc_json($respuesta);
	}


	/**
	* Descripción	: Ver adjunto guardado en sesión
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param 		array (AJAX)
	* @return 		JSON
	*/
	public function verTemporal($idForm = 'adjuntos', $key = 0) {
		$key = Seguridad::validar($key, 'numero');

		if(!empty($idForm)){
			$id_formulario = Seguridad::validar($idForm, 'string');
		}
		
		$arrAdjuntos = Adjunto::getAdjuntosFormulario($id_formulario);

        if(isset($arrAdjuntos[$key])){

            $adjunto = $arrAdjuntos[$key];
            header("Content-Type: ".$adjunto['gl_mime']);
            header("Content-Disposition: inline; filename=".$adjunto['gl_nombre']);
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            ob_end_clean();
            echo base64_decode($adjunto['contenido']);
        }
		else {

            echo "Error al cargar archivo";
        }
    }

    /**
	* Descripción	: Ver adjunto en disco
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param 		String
	* @return 		
	*/
	public function verAdjuntoDisco($gl_token){
		$gl_token 	 = Seguridad::validar($gl_token, 'string');
        $daoAdjunto  = new \App\_FuncionesGenerales\Adjuntos\Entity\DAOAdjunto();
        $adjunto     = (array)$daoAdjunto->getByToken($gl_token);
		$mensaje     = "Error al cargar el archivo";

        if(!empty($adjunto)){
			$gl_dir	= substr($adjunto['gl_path'],0,strripos($adjunto['gl_path'],'/')+1);					
				        
			if(Adjunto::checkDir($gl_dir) && Adjunto::checkFile($adjunto['gl_path'])){
	        	$json_otros_datos		= json_decode($adjunto['json_otros_datos'], true);
				//$gl_mime  = mime_content_type($adjunto['gl_path']);

				$f = fopen($adjunto['gl_path'],"rb");
				header("Content-Type: $json_otros_datos[gl_mime]");
				header("Content-Disposition: inline; filename=$adjunto[gl_nombre]");
				header("Content-Transfer-Encoding: binary");			
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				ob_end_clean();
				fpassthru($f);
	   		}else{
	   			echo $mensaje;
	   		}
        }
        else{
        	echo $mensaje;
        }
    }


	/**
	 * [guardarAdjuntos Guardar adjuntos del formulario en disco y BD.]
	 * @param  array  $arrIdsRegistro   [array clave-valor]
	 *                La clave representa la columna de la tabla adjuntos que indica 
	 *                el origen del adjunto (Ej: id_expediente, id_visita, id_establecimiento,etc.)
	 *                El valor indica el id correspondiente a dicha columna.
	 *                Puede recibir multiples ids
	 * @param  array  &$arrAdjuntos [El listado de adjuntos que se guardarán]
	 * @return [type]               [description]
	 */
	public static function guardarAdjuntos($arrIdsRegistro = [], &$arrAdjuntos = []) {
		$respuesta = array("correcto" => FALSE,"mensaje" => MSJ_ERROR);
		$errores = '';

		/*$arrIdsRegistro:
		id_establecimiento
		id_expediente
		id_visita
		id_fiscalizador
		id_resolucion
		id_inhabilitado
		 */
		if (!empty($arrAdjuntos) && !empty($arrIdsRegistro)) {
			//$daoAdjunto		= \pan\Loader::entity('_FuncionesGenerales/DAOAdjunto');
			$daoAdjunto       = new \App\_FuncionesGenerales\Adjuntos\Entity\DAOAdjunto();

			foreach ($arrAdjuntos as $key => &$adjunto) {
				/**
				 * Primero, creo un registro en BD para el adjunto que guardaré
				 * el registro creado tendrá los ids de origen del adjunto 
				 * Ej: (Ej: id_expediente, id_visita, id_establecimiento,etc.)
				 *
				 * Además, añado el campo json_otros_datos para, en caso de fallar el guardado,
				 * sea más sencillo identificar qué adjunto falló. 
				 * 
				 * Creo que registro al inicio dado que el id que obtengo lo usaré
				 * para el nombre del archivo que se registra en Disco
				 */
				
				$json_otros_datos = $adjunto;
				unset($json_otros_datos['contenido']);
				$arrIdsRegistro["json_otros_datos"] = json_encode($json_otros_datos, JSON_UNESCAPED_UNICODE);

				$idAdjunto = $daoAdjunto->create($arrIdsRegistro);
				
				//Formateo el nombre para asegurar que solo tenga caracteres válidos
				$adjunto['gl_nombre']	= Adjunto::formatName($adjunto['gl_nombre']);

				if ($idAdjunto) {
					$nuevoNombre	=  $idAdjunto . "-" . $adjunto['gl_nombre'];
					$rutaArchivo	= Adjuntos::PATH_BASE.$nuevoNombre;

					$adjunto_params = array(
						"gl_token"			=> Seguridad::generaTokenAdjunto($rutaArchivo),
						"id_adjunto_tipo"	=> $adjunto["id_tipo"],
						"gl_nombre"			=> $nuevoNombre,
						"gl_path"			=> $rutaArchivo,
						"gl_glosa"			=> $adjunto["gl_tipo"],
						"id_usuario_crea"	=> \pan\utils\SessionPan::getSession('id'),
					);

					if ($daoAdjunto->update($adjunto_params, $idAdjunto)) {
						$AdjGuardado	= Adjunto::saveFile(Adjuntos::PATH_BASE, base64_decode($adjunto['contenido']), $nuevoNombre);

						if(!$AdjGuardado){
							$errores .= '  - El adjunto '.$nuevoNombre.' presentaba errores y no pudo ser guardado.<br/>';
						}
					}
					else{
						$errores .= '  - El adjunto '.$nuevoNombre.' presentaba errores y no pudo ser guardado.<br/>';
					}
				}
			}
		}

		if(!empty($errores)){
			$respuesta["mensaje"] = $errores;
			$respuesta["mensaje"] .= "Para más información, contáctese con Soporte.";
		}else{
			$respuesta["correcto"] = TRUE;
		}

		return $respuesta;
	}

	/**
	 * [cargarAdjuntos busca los adjuntos en la tabla de adjuntos según los ids enviados]
	 * @param  array  $arrIdsRegistro [description]
	 * @param  array  &$arrAdjuntos   [description]
	 * @return [type]                 [description]
	 */
	public static function cargarAdjuntos($arrIdsRegistro = []) {
		$respuesta = array("correcto" => FALSE,"mensaje" => MSJ_ERROR);
		$errores = '';

		if (!empty($arrIdsRegistro)) {
			/*$arrIdsRegistro:
			id_adjunto
			gl_token
			id_establecimiento
			id_expediente
			id_visita
			id_fiscalizador
			id_resolucion
			id_inhabilitado
			 */
			//$daoAdjunto		= \pan\Loader::entity('_FuncionesGenerales/DAOAdjunto');
			$daoAdjunto       = new \App\_FuncionesGenerales\Adjuntos\Entity\DAOAdjunto();

			$arrAdjuntos = $daoAdjunto->getLista($arrIdsRegistro);
			$respuesta["arrAdjuntos"] = $arrAdjuntos;
			$respuesta["correcto"] = TRUE;
			$respuesta["mensaje"] = "Adjuntos cargados correctamente";
		}else{
			$respuesta["mensaje"] = "Debe indicar los parametros de búsqueda.";
			$respuesta["mensaje"] .= "Para más información, contáctese con Soporte.";
		}

		return $respuesta;
	}

	/**
	* Descripción	: Cargar grilla adjuntos
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param 		array (AJAX)
	* @return       HTML
	*/
	public function cargarGrilla() {

		$params		 = $this->request->getParametros();
		$arrAdjuntos = array();

		if (isset($params['idForm'])) {

			$id_formulario	= Seguridad::validar($params['idForm'], 'string');
			$bo_editar	= Seguridad::validar($params['bo_editar'], 'numero');
			$this->view->set('bo_editar', $bo_editar);
			$this->view->set('idForm', $params['idForm']);
			$arrAdjuntos = Adjunto::getAdjuntosFormulario($id_formulario);
		}
		
		echo $this->view->fetchIt('grillaAdjuntos.php',["arrAdjuntos" => $arrAdjuntos]);
	}

    /**
	* Descripción	: Guardar un adjunto en disco directamente por AJAX
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param 		array (AJAX)
	* @return 		JSON
	*/
    public function guardarAdjuntoEnDiscoPorAjax(){

        header('Content-type: application/json');

    	$params         = $this->request->getParametros();
    	$adjunto        = $_FILES["adjunto"];
    	$id_tipo        = $params["id_tipo_adjunto"];
    	$tramite        = $this->daoTramite->getTramiteByHash($params["gl_hash_tramite"]);
    	$mensaje        = Adjunto::validate($adjunto);
    	$error          = true;
    	$gl_ruta        = Adjuntos::PATH_BASE;
    	$tipo_adjunto   = $this->daoTipoAdjunto->obtenerPorId($tramite->id_tramite,true);


        if(empty($mensaje) && Adjunto::checkDir($gl_ruta)){

            $id_adjunto = $this->daoAdjunto->insertar($tramite->id_tramite);

            if($id_adjunto){

                $nuevo_nombre =  $tramite->id_tramite . "-" . $adjunto['name'];
                $correcto     = Adjunto::saveFile($gl_ruta, $adjunto, $nuevo_nombre);

                if($correcto) {

                	$error   = false;
                	$gl_ruta = substr($gl_ruta,3,strlen($gl_ruta));
                    $this->daoAdjunto->updateAdjunto($id_adjunto, $nuevo_nombre, $gl_ruta . $nuevo_nombre, $id_tipo);

                    //Guardar Evento
                    $this->daoTramite->evento($tramite->id_tramite,46,"Se Guarda Adjunto: ".$tipo_adjunto[0]->nombre_tipo_documento);

                }

            }

        }

		$salida	= array('error' => $error, 'mensaje' => $mensaje);
		$json	= json_encode($salida);

		echo $json;

    }

    /**
	* Descripción	: Guardar un documento PDF oficial en disco directamente por AJAX
	* @author		: Alexis Visser <alexis.visser@cosof.cl>
	* @param 		array (AJAX)
	* @return 		JSON
	*/
	/*
    public function guardarDocumentoEnDiscoPorAJAX(){

		header('Content-type: application/json');

    	$params         	= $this->request->getParametros();
    	$adjunto        	= $_FILES["adjunto"];
    	$id_tipo        	= (isset($params["id_tipo_adjunto"]))   ? $params["id_tipo_adjunto"]   : "";
    	$gl_tipo        	= (isset($params["gl_documento_tipo"])) ? $params["gl_documento_tipo"] : "";
    	$tramite        	= $this->daoTramite->getTramiteByHash($params["gl_hash_tramite"]);
    	$mensaje        	= Adjunto::validate($adjunto);
    	$error          	= true;
    	$gl_ruta        	= Adjuntos::PATH_BASE."/pdf/$tramite->id_tramite/";
    	$gl_hash_doc    	= \pan\panHash::generaTokenDocumento($adjunto['name'],$tramite->id_tramite,$tramite->fc_creacion);
    	$arr_tipo_documento = $this->daoTipoAdjunto->obtenerPorId($id_tipo);

    	if(empty($mensaje) && Adjunto::checkDir($gl_ruta)){

			$id_documento = $this->daoAdjuntoDocumento->insertar($tramite->id_tramite,$gl_hash_doc);

			if($id_documento){					

				if($id_tipo == '17'){					

					$adjunto["name"] = "DECLARACION_CUMPLIMIENTO_FIRMADA_".date("d_m_Y_H_i_s").".pdf";
				
				}

				$correcto = Adjunto::saveFile($gl_ruta,$adjunto,$adjunto["name"]);

				if($correcto){

					$error     = false;
					$gl_ruta   = substr($gl_ruta,3,strlen($gl_ruta));

					$this->daoAdjuntoDocumento->update($id_documento, $adjunto["name"], $gl_ruta . $adjunto["name"], $id_tipo);

					//Guardar Evento
	                $this->daoTramite->evento($tramite->id_tramite,46,"Se Guarda Adjunto: ".$arr_tipo_documento->nombre_tipo_documento);
	                
			// REVISAR Y COMENTAR
	                switch($tramite->id_tramite_tipo){
	                	case 104 : //Agua
					break;	                			                		
	                	case 105 : //Exencion
	                		$this->daoTramite->updTramiteEstado($tramite->id_tramite,8);
	                		break;
	                	default:
	                		//Pagado en TEST
	                        if($tramite->id_tramite_tipo == 102){ //ELEAM
	                            $this->daoTramite->updTramiteEstado($tramite->id_tramite,3);
	                        }else{
	                            $this->daoTramite->updTramiteEstado($tramite->id_tramite,1);
	                        }         

		                    //Genera comprobante para pago
							$this->ctrlPDF->generarPDFDisco($tramite->id_tramite_tipo."cpp",$tramite->id_tramite);
		                    $exento = $this->daoTramite->exentoDePago($tramite->id_tramite,$tramite->nr_monto_pago);

							if($exento){

								//Genera comprobante de pago
								$this->ctrlPDF->generarPDFDisco($tramite->id_tramite_tipo."cdp",$tramite->id_tramite);
								$this->daoTramite->evento($tramite->id_tramite,32,"--");
								$gl_estado = $this->daoTramite->obtenerEstado($tramite->id_tramite);

							}

	                }                
	                
	            }
		        
			}

            $gl_estado  = $this->daoTramite->obtenerEstado($tramite->id_tramite);


    	}

    	$salida = array("error" => $error,"mensaje" => $mensaje,"gl_estado" => $gl_estado);
    	$json      = json_encode($salida);

    	echo $json;

	}
	*/

	/**
	* Descripción	: [AJAX] Validar si existe adjunto en sesión.
	* @author		: <luis.estay@cosof.cl> 25-06-2019
	* @param 		Array
	* @return 		String | JSON
	*/
	public function validarExiste() {

		$params		= $this->request->getParametros();
		$idSession	= $params["idForm"];
		$idTipo		= $params["idTipo"];
		$msg		= "";

		$msg		= self::validarExisteTemporal($idSession, $idTipo);
		$resp		= array("mensaje" => $msg);
		$resp		= json_encode($resp, JSON_UNESCAPED_UNICODE);

		echo $resp;
	}

	/**
	* Descripción	: Valida si existe en sesión un adjunto según su tipo.
	* @author		: <luis.estay@cosof.cl> 24-06-2019
	* @param		int : id de sesión actual
	* @param		int : tipo de documento
	* @return 		string
	*/
	public static function validarExisteTemporal($idSession, $idTipo = NULL) {

		$session_form_adj = (isset($_SESSION['sesion_formulario'][$idSession]['arrForm']["ADJUNTOS"])) ? $_SESSION['sesion_formulario'][$idSession]['arrForm']["ADJUNTOS"] : array();
		$session_fisc_adj = (isset($_SESSION['fiscalizador'][$idSession]['arrForm']["ADJUNTOS"])) ? $_SESSION['fiscalizador'][$idSession]['arrForm']["ADJUNTOS"] : array();

		if(count($session_form_adj) > 0){

			$arrAdjuntos = $session_form_adj;

		}else if(count($session_fisc_adj) > 0){

			$arrAdjuntos = $session_fisc_adj;

		}

		$daoTipoAdj		= \pan\Loader::entity('_FuncionesGenerales/DAOTipoAdjunto');
		$glTipoAdj		= $daoTipoAdj->obtenerPorId($idTipo)->nombre_tipo_documento;
		$msg			= "Debe adjuntar <b>\"".mb_convert_case($glTipoAdj, MB_CASE_TITLE, "UTF-8")."\"</b><br>";

		if ($arrAdjuntos AND $idTipo) {

			foreach ($arrAdjuntos as $key => $adjunto) {

				if ($adjunto["id_tipo"] == $idTipo) {

					$existe = TRUE;
					$msg	= "";
					break;
				}
			}
		}

		return $msg;
	}

	/**
	* Descripción	: Verifica que exista el adjunto, pero no entrega mensaje sólo un booleano a través de JSON
	* @author		: Alexis Visser<alexis.visser@cosof.cl> 18-11-2019
	* @param		int : id de sesión actual
	* @param		int : tipo de documento
	* @return 		boolean
	*/
	public function tieneAdjunto(){

		$params			= $this->request->getParametros();
		$idSession		= $params["idForm"];
		$idTipo			= $params["idTipo"];
		$msg			= "";
		$arrSession		= $_SESSION['sesion_formulario'][$idSession]['arrForm'];
		$arrAdjuntos	= (isset($arrSession["ADJUNTOS"])) ? $arrSession["ADJUNTOS"] : NULL;
		$tiene          = FALSE;

		if ($arrAdjuntos AND $idTipo) {

			foreach ($arrAdjuntos as $key => $adjunto) {

				if ($adjunto["id_tipo"] == $idTipo) {

					$tiene = TRUE;					
					break;

				}
			}

		}

		$salida		= array("bo_tiene" => $tiene);
		$json		= json_encode($salida);

		echo $json;

	}

	/**
	 * Descripción	: Reemplazo de archivo adjunto
	 * @author		: David Arancibia <david.arancibia@cosof.cl>
	 * @return		: HTML
	 */
	public function reemplazarAdjunto(){
		$params = $this->request->getParametros();
		$idSession         = isset($params[0]) ? $params[0] : null;
        $key             = isset($params[1]) ? $params[1] : null;
        $arrAdjuntos = $_SESSION['sesion_formulario'][$idSession]['arrForm']['ADJUNTOS'];
		$gl_nombre_adjunto = "";
		$gl_tipo_adjunto = "";
		$id_tipo_adjunto = "";
        if (isset($arrAdjuntos[$key])) {
			$gl_nombre_adjunto = $arrAdjuntos[$key]['gl_nombre'];
			$gl_tipo_adjunto = $arrAdjuntos[$key]['gl_tipo'];
			$id_tipo_adjunto = $arrAdjuntos[$key]['id_tipo'];
		}
		error_log(serialize($id_tipo_adjunto));
        $this->view->set('idx', $key);
		$this->view->set('gl_nombre_adjunto', $gl_nombre_adjunto);
		$this->view->set('gl_tipo_adjunto', $gl_tipo_adjunto);
		$this->view->set('id_tipo_adjunto', $id_tipo_adjunto);
        $this->view->render('solicitudInicial/acciones/adjuntoReemplazar.php');
	}
}
