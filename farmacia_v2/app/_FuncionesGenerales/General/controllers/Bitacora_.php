<?php

namespace App\_FuncionesGenerales\General;

/**
 * To do, revisar y adaptar al proyecto.
 */
class Bitacora extends \pan\Kore\Controller{

	public function __construct(){
		parent::__construct();
		$this->_ReCaptcha        		= new \ReCaptcha("6Lf1oDoUAAAAALAEk-scMFk0eem4sdE7rG7BbLA3");
		$this->_DAOExpediente       	= new \App\_FuncionesGenerales\General\Entity\DAOExpediente();
		$this->_DAOArchivos       		= new \App\_FuncionesGenerales\General\Entity\DAOArchivos();
		$this->_DAOExpedienteDetalle    = new \App\_FuncionesGenerales\General\Entity\DAOExpedienteDetalle();
		$this->_DAOUsuario          	= new \App\Usuario\Entity\DAOUsuario();
		$this->_DAOEvento       		= new \App\Expediente\Entity\DAOEvento();
		$this->_DAOComentario       	= new \App\Expediente\Entity\DAOComentario();
	}

	public function index($id = null){
		//$id = 23535;
		$expediente			=  $this->_DAOExpediente->getByIdExpediente($id);
		$expedienteEvento	=  $this->_DAOEvento->getEventosDeExpediente(["id_expediente" => $id,"id_tipo_evento" => 12]);

        $arrUsuarios = $this->_DAOUsuario->getUsuariosInteraccionExpediente($expediente->id);
        foreach ($arrUsuarios as $usuario) {
            $usuario->perfiles = '';
            $perfiles = $this->_DAOUsuario->getPerfilesUsuario($usuario->id_usuario_crea);

            for ($i = 0; $i < count($perfiles); $i++) {
                $usuario->perfiles .= $perfiles[$i]->nombre;
                if ($i < count($perfiles) - 1) {
                    $usuario->perfiles .= ', ';
                }
            }
        }

		$arrIds = array();
		$arrTipos = array();
		$arrRecep = array();
		$datosUsuarios = array();

		if(!empty($expedienteEvento)){
			foreach ($expedienteEvento as $key => $value) {
				$arrIds[] = $value->id_usuario_crea;
				$arrRecep[$value->id_usuario_crea]['texto'] = 'Recepcionador Descargos';
			}
		}
		if(isset($expediente->id_usuario_juridica)){
			$arrIds[] = $expediente->id_usuario_juridica;
		}
		if(isset($expediente->id_usuario_abogado_revisor_v4)){
			$arrIds[] = $expediente->id_usuario_abogado_revisor_v4;
		}
		if(isset($expediente->id_usuario_jefe_sumario_v4)){
			$arrIds[] = $expediente->id_usuario_jefe_sumario_v4;
		}
		if(isset($expediente->id_usuario_jefe_juridico_v4)){
			$arrIds[] = $expediente->id_usuario_jefe_juridico_v4;
		}

		if(!empty($arrIds)){
			$datosUsuarios		=  $this->_DAOUsuario->getUsuariosDeExpediente(implode(",",$arrIds));
			foreach ($datosUsuarios as $key => $value) {
				if($value->USUA_id == $expediente->id_usuario_juridica){
					$arrTipos[1]['texto'] = 'Abogado';
					$arrTipos[1]['nombre'] = $value->nombres.' '.$value->apellidos;
					$arrTipos[1]['rut'] = $value->rut;
					$arrTipos[1]['email'] = $value->email;
				}elseif($value->USUA_id == $expediente->id_usuario_abogado_revisor_v4){
					$arrTipos[2]['texto'] = 'Abogado Revisor';
					$arrTipos[2]['nombre'] = $value->nombres.' '.$value->apellidos;
					$arrTipos[2]['rut'] = $value->rut;
					$arrTipos[2]['email'] = $value->email;
				}elseif($value->USUA_id == $expediente->id_usuario_jefe_sumario_v4){
					$arrTipos[3]['texto'] = 'Jefe Sumario';
					$arrTipos[3]['nombre'] = $value->nombres.' '.$value->apellidos;
					$arrTipos[3]['rut'] = $value->rut;
					$arrTipos[3]['email'] = $value->email;
				}elseif($value->USUA_id == $expediente->id_usuario_jefe_juridico_v4){
					$arrTipos[4]['texto'] = 'Jefe Jurídico';
					$arrTipos[4]['nombre'] = $value->nombres.' '.$value->apellidos;
					$arrTipos[4]['rut'] = $value->rut;
					$arrTipos[4]['email'] = $value->email;
				}else{
					$arrRecep[$value->USUA_id]['nombre'] 	= $value->nombres.' '.$value->apellidos;
					$arrRecep[$value->USUA_id]['rut'] 		= $value->rut;
					$arrRecep[$value->USUA_id]['email'] 	= $value->email;
        
                }
			}
		}
		
        $arrResponsables	=  $this->_DAOExpedienteDetalle->getResponsables(['id_expediente' => $id,'bitacora' => TRUE]);

		$this->view->set('datosExpediente', $expediente);
		$this->view->set('arrTipos', $arrTipos);
        $this->view->set('arrRecep', $arrRecep);
        $this->view->set('arrUsuarios', $arrUsuarios);
		$this->view->set('arrResponsables', $arrResponsables);
		$this->view->addJS('bitacora.js');
		$this->view->addJS('descargos.js', 'app/Descargos/assets/js');
        $this->view->render('index');
		
	}


	public function grillaDocumentosOficiales(){
		
		$params        = $this->request->getParametros();

		$paramsDocs = array(
			'id_expediente' => $params["id_expediente"],
			'bo_acumulado_v4' => $params["bo_acumulado_v4"],
			'bo_acumulado_principal_v4' => $params["bo_acumulado_principal_v4"],
			//'id_archivo_tipo' => \App\General\Entity\DAOArchivos::TIPO_ARCHIVO_CARATULA,
		);
		
		//$paramsDocs['filterType'] = "2";
		//$paramsDocs['filterId']	  = $id;

		$arrDocumentosExp	=  $this->_DAOArchivos->getArchivosByExpedientes($paramsDocs);
		
		//$arrDocumentosExp	=  $this->_DAOArchivos->getDocumentosOficialesExpedientes($paramsDocs);
		$arrGrilla 		 = array('data' => array());
		
		
		if (!empty($arrDocumentosExp)) {

			foreach ($arrDocumentosExp as $item) {
				$arr  = array();
				$arr['nombre'] 					= $item->nombre;
				if ($item->id_archivo_tipo == 20) {
					$arr['tipo_nombre'] = 'Resolucion de tipo ' . mb_strtoupper($item->tipo_resolucion). ' Nº' . $item->gl_resolucion . ' para ' . $item->responsable_nombre;
				} else {
					$arr['tipo_nombre'] = $item->tipo;
				}
				
				$codigo = "'".$item->codigo."'";
				$arr['documento']  				= '<a class="btn btn-xs btn-success" target="_blank" onclick="Bitacora.descargarDocumento('.$codigo.')"><i class="fa fa-arrow-circle-down"></i></a>';
				//$arr['documento']  				= '<a class="btn btn-xs btn-success" target="_blank" href="'.BASE_URI.$item->ruta_relativa.'"><i class="fa fa-arrow-circle-down"></i></a>';
				$arr['fecha_c'] 				= date('d-m-Y H:i',strtotime($item->fc_creacion));

				
				$arrGrilla['data'][] = $arr;

			}

		}
		
		echo json_encode($arrGrilla);

	}

	public function grillaEventos(){
		$params        = $this->request->getParametros();
		$params_eventos = NULL;

		if(isset($params["id_expediente"])){
			$params_eventos = array(
				'id_expediente' => $params["id_expediente"],
				'bo_acumulado_v4' => $params["bo_acumulado_v4"],
				'bo_acumulado_principal_v4' => $params["bo_acumulado_principal_v4"],
				'id_archivo_tipo' => \App\_FuncionesGenerales\Entity\DAOArchivos::TIPO_ARCHIVO_CARATULA,
			);
		}
		

		$arrEventos			=  $this->_DAOEvento->getEventosDeExpediente($params_eventos);
		$arrGrilla 		 = array('data' => array());
		
		
		if (!empty($arrEventos)) {

			foreach ($arrEventos as $item) {
				$arr['expediente']		 			= $item->gl_codigo;
				$arr['fecha'] 					= date('d-m-Y H:i',strtotime($item->fc_creacion));
				$arr['nombre']		 			= $item->gl_nombre;
				$arr['creador']		 		= $item->creador;
				$arr['descripcion']		 		= '<span class="text-left">'.$item->gl_descripcion.'</span>';
				

				
				$arrGrilla['data'][] = $arr;

			}

		}
		
		echo json_encode($arrGrilla);

	}

	public function descargar($key = NULL){
		if($key != NULL){
			$data['codigo'] = $key;
			$archivo = $this->_DAOArchivos->getArchivosByCodigo($data);
			if(isset($archivo)){
				echo \Adjunto::openFile($archivo->ruta_relativa);
	        }
		}
		echo "Error al cargar archivo";

	}

	public function agregarDocumentoModal($id_expediente){
		$this->view->set('tiposArchivos', $this->_DAOArchivos->getArchivosTipo(64));
        $this->view->set('id_expediente', $id_expediente);
        $this->view->render('bitacora_datos_expediente_nuevo_documento.php');

	}

	public function agregarDocumento(){
		$params        = $this->request->getParametros();
		$documento = isset($_FILES['adjunto_documento'])?$_FILES['adjunto_documento']:"";

		if($params["tipo_documento"] == 0){
			$error = TRUE;
			$mensaje = 'Estimado Usuario:<br>Ha ocurrido un error al ingresar Documento, intente nuevamente';
			$json	= array('error' => $error, 'texto' => $mensaje);
			echo json_encode($json, JSON_UNESCAPED_UNICODE);
			exit();
		}

		if(\Adjunto::readFile($documento) == NULL){
			$error = TRUE;
			$mensaje = 'Estimado Usuario:<br>Ha ocurrido un error al ingresar Documento, intente nuevamente';
			$json	= array('error' => $error, 'texto' => $mensaje);
			echo json_encode($json, JSON_UNESCAPED_UNICODE);
			exit();
		}
		$adjunto['gl_nombre']			= $documento['name'];
		$adjunto['contenido']			= \Adjunto::readFile($documento);
		$adjunto['id_expediente']		= $params['id_expediente'];
		$adjunto['id_usuario']			= isset($_SESSION[SESSION_BASE]['id'])?$_SESSION[SESSION_BASE]['id']:'0';
		$adjunto['id_tipo']				= $params["tipo_documento"]; 
		$adjunto['tipo']				= isset($documento['type'])?$documento['type']:'';
		$adjunto['id_usuario_crea']	= isset($_SESSION[SESSION_BASE]['id'])?$_SESSION[SESSION_BASE]['id']:'0';
		$adjunto['tmp_name']			= "documentos/adjuntos/".date('Y')."/".$params['id_expediente']."/".'poder_simple_'.$poder['name'];

		$archivoPdf = \Pan\Kore\Loader::controller('General/ArchivoPdf');
		if(!$archivoPdf->guardarDocumentoData($params['id_expediente'],$adjunto)){
			$error = TRUE;
			$mensaje = 'Estimado Usuario:<br>Ha ocurrido un error al ingresar archivo: '.$adjunto['gl_nombre'];
			$json	= array('error' => $error, 'texto' => $mensaje);
			echo json_encode($json, JSON_UNESCAPED_UNICODE);
			exit();
		}

		\Evento::eventoExpediente(
			EVENTO_INGRESAR_DOCUMENTOS_BITACORA, 
			$params['id_expediente'], 
			$_SESSION[SESSION_BASE]['id'], 
			array(
				'[TAG_NOMBRE_TIPO_DOCUMENTO]',
				'[TAG_NOMBRE_CREADOR]'
			), 
			array(
				'<b>'.mb_strtoupper($this->_DAOArchivos->getArchivosTipo($params["tipo_documento"])[0]->nombre).'</b>',
				$_SESSION[SESSION_BASE]['gl_nombres'].' '.$_SESSION[SESSION_BASE]['gl_apellidos']
			)
		);

		$json	= array('error' => FALSE, 'texto' => 'Estimado Usuario:<br>El documento se ha ingresado con éxito');
		echo json_encode($json, JSON_UNESCAPED_UNICODE);

	}

}
