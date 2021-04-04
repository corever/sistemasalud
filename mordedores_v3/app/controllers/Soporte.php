<?php
/**
 ******************************************************************************
 * Sistema           : PREVENCION DE FEMICIDIOS
 * 
 * Descripción       : Controller para Registro de Soporte
 *
 * Plataforma        : PHP
 * 
 * Creación          : 20/02/2017
 * 
 * @name             Soporte.php
 * 
 * @version          1.0.0
 *
 * @author           Domingo Cortez <domingo.cortez@cosof.cl>
 * 
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha		Descripción 
 * ----------------------------------------------------------------------------
 * <victor.retamal@cosof.cl>	25-02-2017	Enviar RUT del usuario
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
class Soporte extends Controller{

    protected $_wsdl;

    function __construct(){
        parent::__construct();
		$this->load->lib('Fechas', false);

		require_once("app/libs/nusoap/lib/nusoap.php");
        $this->smarty->addPluginsDir(APP_PATH . "views/templates/soporte/plugins/");
    }

	/**
	* Descripción	: Guardar Soporte
	* @author		: Domingo Cortez <domingo.cortez@cosof.cl>
	*/
    public function index(){
		unset($_SESSION[SESSION_BASE]['adjunto_mensaje']);
        $this->_addJavascript(STATIC_FILES.'js/templates/soporte/form.js');
        $this->_addJavascript(STATIC_FILES.'js/templates/soporte/xmodal.js');
        
		$soportes	= null;

		$wsdl					= WSDL_SOPORTE;
		$ws						= new nusoap_client($wsdl,'wsdl');
        $ws->soap_defencoding	= 'UTF-8';
		$ws->decode_utf8 		= false;

		if($ws->getError()){
			$error		= true;
			$correcto	= false;
			$msg		= 'Problemas con WebService';
		}else{
			$ws_data	= array(
								'key_public'	=> '14Rk4Ikbr14Z7fqW3bayt2aHvu4ReYgdPvuNUV2QvAs8',
								'rut_usuario'	=> $_SESSION[SESSION_BASE]['rut'],
							);
			$param		= array('data' => $ws_data);
			$result		= $ws->call('obtenerSoportesUsuario', $param);
			$estado		= $result['estado'];
			$gl_glosa	= $result['gl_glosa'];
			
			if($estado == 1){
				$error			= false;
				$correcto		= true;
				$msg			= $gl_glosa;

				if (isset($result['arr_soportes'])) {
					if(isset($result['arr_soportes'][0])){
						$soportes	= $result['arr_soportes'];
					}else{
						$soportes[] = $result['arr_soportes'];
					}
				}
			}else{
				$error			= true;
				$correcto		= false;
				$msg			= $gl_glosa;
			}
		}

		$this->smarty->assign("email", $_SESSION[SESSION_BASE]['mail']);
        $this->smarty->assign("rut", $_SESSION[SESSION_BASE]['rut']);
		$this->smarty->assign('soportes',$soportes);
        $this->_display('soporte/index.tpl');
    }

	/**
	* Descripción	: Guardar Soporte
	* @author		: Domingo Cortez <domingo.cortez@cosof.cl>
	*/
	public function guardar(){
		$data					= $this->_request->getParams();
		$error					= true;
		$correcto				= false;
		$msg					= '::';
		$adjuntos				= array();

		$wsdl					= WSDL_SOPORTE;
		$ws						= new nusoap_client($wsdl,'wsdl');
        $ws->soap_defencoding	= 'UTF-8';
		$ws->decode_utf8 		= false;

		if(isset($_SESSION[SESSION_BASE]['adjunto_mensaje'])){
			foreach($_SESSION[SESSION_BASE]['adjunto_mensaje'] as $k=>$adj){
				$adjuntos[$k]['nombre_adjunto']	= $adj['nombre_adjunto'];
				$adjuntos[$k]['base64_adjunto']	= $adj['contenido'];
			}
		}
		
		if($ws->getError()){
			$error		= true;
			$correcto	= false;
			$msg		= 'Problemas con WebService';
		}else{
			$ws_data			= array(
										'key_public'				=> '14Rk4Ikbr14Z7fqW3bayt2aHvu4ReYgdPvuNUV2QvAs8',
										'asunto_soporte'			=> $data['asunto'],
										'cuerpo_soporte'			=> $data['mensaje'],
										'id_region'					=> 0,
										'gl_codigo_sistema'			=> '1',
										'gl_tramite'				=> 0,
										'rut_usuario_creador'		=> $_SESSION[SESSION_BASE]['rut'],
										'id_region_creador'			=> 0,
										'nombre_usuario_creador'	=> '',
										'email_usuario_creador'		=> $data['email'],
										'telefono_usuario_creador'	=> $data['telefono'],
										'adjuntos'					=> $adjuntos,
										);
			$param				= array('data' => $ws_data);
			$result				= $ws->call('crearSoporte', $param);
			$estado				= $result['estado'];
			$gl_glosa			= $result['gl_glosa'];
			$gl_codigo			= $result['gl_codigo'];
			
			if($estado == 1){
				$error			= false;
				$correcto		= true;
				$msg			= $gl_codigo;
				unset($_SESSION[SESSION_BASE]['adjunto_mensaje']);
			}else{
				$error			= true;
				$correcto		= false;
				$msg			= 'Error al Guardar';
			}
		}

		header('Content-type: application/json');
        $salida	= array("error"		=> $error,
                        "correcto"	=> $correcto,
                        "msg"		=> $msg,
						);
        $json	= Zend_Json::encode($salida);
        echo $json;
    }

	/**
	* Descripción	: Ver Detalle Soporte
	* @author		: Domingo Cortez <domingo.cortez@cosof.cl>
	*/
	public function verDetalleSoporte(){
		$parametros				= $this->request->getParametros();		
		$gl_rut_usuario			= $_SESSION[SESSION_BASE]['rut'];
		$id_soporte				= $parametros[0];
		$detalle				= array();
		$historial				= array();
		$adjuntos_usu			= array();
		$adjuntos_fap			= array();

		$wsdl					= WSDL_SOPORTE;
		$ws						= new nusoap_client($wsdl,'wsdl');
        $ws->soap_defencoding	= 'UTF-8';
		$ws->decode_utf8 		= false;

		if($ws->getError()){
			$this->smarty->assign('errorWS',true);
		}else{

			$ws_data					= array(
												'key_public'		=> '14Rk4Ikbr14Z7fqW3bayt2aHvu4ReYgdPvuNUV2QvAs8',
												'id_soporte'		=> $id_soporte,
												'gl_rut_usuario'	=> $gl_rut_usuario,
												);
			$param						= array('data' => $ws_data);
			$result						= $ws->call('obtenerSoportesDetalle', $param);

			if(empty($result['arr_detalle'])){
				$this->smarty->assign('errorWS',$result['gl_glosa']);
			}else{
				$detalle				= $result['arr_detalle'];
				if(isset($detalle['arr_historial'])){
					if(isset($detalle['arr_historial'][0])){
						$historial		= $detalle['arr_historial'];
					}else{
						$historial[]	= $detalle['arr_historial'];
					}
				}
				if(isset($detalle['arr_adjuntos_usuario'])){
					if(isset($detalle['arr_adjuntos_usuario'][0])){
						$adjuntos_usu	= $detalle['arr_adjuntos_usuario'];
					}else{
						$adjuntos_usu[]	= $detalle['arr_adjuntos_usuario'];
					}
				}
				if(isset($detalle['arr_adjuntos_fap'])){
					if(isset($detalle['arr_adjuntos_fap'][0])){
						$adjuntos_fap	= $detalle['arr_adjuntos_fap'];
					}else{
						$adjuntos_fap[]	= $detalle['arr_adjuntos_fap'];
					}
				}
			}
		}

		$this->smarty->assign('gl_rut_usuario',$gl_rut_usuario);
		$this->smarty->assign('soporte',$detalle);
		$this->smarty->assign('historial',$historial);
		$this->smarty->assign('adjuntos_usu',$adjuntos_usu);
		$this->smarty->assign('adjuntos_fap',$adjuntos_fap);
		$this->smarty->display('soporte/detalle_soporte.tpl');
	}

	/**
	* Descripción	: Imprimir
	* @author		: Domingo Cortez <domingo.cortez@cosof.cl>
	*/
	public function imprimir(){
		$parametros				= $this->request->getParametros();		
		$id_soporte				= $parametros[0];
		$gl_codigo_soporte		= $parametros[1];
		$gl_rut_usuario			= $_SESSION[SESSION_BASE]['rut'];
		$nombre					= 'SOPORTE #'.$gl_codigo_soporte.'.pdf';

		$wsdl					= WSDL_SOPORTE;
		$ws						= new nusoap_client($wsdl,'wsdl');
        $ws->soap_defencoding	= 'UTF-8';
		$ws->decode_utf8 		= false;

		if($ws->getError()) {
			echo '<b>Hubo un problema.</b><br> Favor intentar nuevamente o contactarse con el Administrador';
		}else{

			$ws_data			= array(
										'key_public'		=> '14Rk4Ikbr14Z7fqW3bayt2aHvu4ReYgdPvuNUV2QvAs8',
										'id_soporte'		=> $id_soporte,
										'gl_rut_usuario'	=> $gl_rut_usuario,
										);
			$param				= array('data' => $ws_data);
			$result				= $ws->call('imprimirSoporte', $param);			
			$estado				= $result['estado'];
			$gl_glosa			= $result['gl_glosa'];
			$pdf				= $result['pdf'];

			if($estado==1){
				header("Content-Type: application/pdf");
				header("filename=$nombre"); 
				header("Content-Disposition: ; filename=\"$nombre\"");

				echo base64_decode($pdf);
			}else{
				echo "<b>Hubo un problema.</b><br> $gl_glosa<br> Favor intentar nuevamente o contactarse con el Administrador.";
			}
		}
	}

	/**
	* Descripción	: Guardar Soporte
	* @author		: Domingo Cortez <domingo.cortez@cosof.cl>
	*/
	public function cargarAdjunto(){
		$this->smarty->display('soporte/cargar_adjunto.tpl');
	}
	
	/**
	* Descripción	: Guardar Adjunto
	* @author		: Domingo Cortez <domingo.cortez@cosof.cl>
	*/
	public function guardarAdjunto(){
		$adjunto	= $_FILES['adjunto'];

		if($adjunto['tmp_name'] != ""){
			$file		= fopen($adjunto['tmp_name'],'r+b');
			$contenido	= fread($file,filesize($adjunto['tmp_name']));
			fclose($file);

			if(!empty($contenido)){
				$arr_adjunto	= array(
									'id_adjunto'	=> 1,
									'id_mensaje'	=> 1,
									'nombre_adjunto'=> $adjunto['name'],
									'mime_adjunto'	=> $adjunto['type'],
									'contenido'		=> base64_encode($contenido)
								);
				$_SESSION[SESSION_BASE]['adjunto_mensaje'][] = $arr_adjunto;	
				$success	= 1;
				$mensaje	= "El archivo <strong>".$adjunto['name']."</strong > ha sido Adjuntado";
			}else{
				$success	= 0;
				$mensaje	= "No se ha podido leer el archivo adjunto. Intente nuevamente";		
			}			
		}else{
			$success	= 0;
			$mensaje	= "Error al cargar el Adjunto. Intente nuevamente";	
		}

		if($success == 1){
			echo "<script>parent.cargarListadoAdjuntos('listado-adjuntos'); parent.xModal.close();</script>";
		}else{
			$this->view->assign('success',$success);
			$this->view->assign('mensaje',$mensaje);

			$this->view->assign('template',$this->view->fetch('soporte/cargar_adjunto.tpl'));
			$this->view->display('template_iframe.tpl');
		}
	}
	
	/**
	* Descripción	: Cargar Listado Adjuntos
	* @author		: Domingo Cortez <domingo.cortez@cosof.cl>
	*/
	public function cargarListadoAdjuntos(){
		$adjuntos	= array();
		$template	= '';

		if(isset($_SESSION[SESSION_BASE]['adjunto_mensaje'])) {
			$template	.= '<div class="col-xs-6 col-xs-offset-3" id="div_adjuntos" name="div_adjuntos">
							<table id="adjuntos" class="table table-hover table-condensed table-bordered" align=center>
								<thead>
								<tr>
									<th>Nombre Archivo</th>
									<th width="50px" nowrap>Descargar</th>
									<th width="50px" nowrap>Eliminar</th>
								</tr>
								</thead>
								<tbody>';
			$adjuntos	= $_SESSION[SESSION_BASE]['adjunto_mensaje'];
			$i			= 0;

			foreach($adjuntos as $adjunto){
				$template.= '		<tr>
										<td>
											<strong>'.$adjunto['nombre_adjunto'].'</strong>
										</td>
										<td align="center"><a class="btn btn-xs btn-primary" href="javascript:void(0);" onclick="window.open(\''.BASE_URI.'/Soporte/verAdjunto/'.$i.'\',\'_blank\');">
												<i class="fa fa-download"></i>
											</a>
										</td>
										<td align="center">
											<button class="btn btn-xs btn-danger" type="button" onclick="borrarAdjunto('.$i.')">
												<i class="fa fa-trash-o"></i>
											</button>
										</td>
									</tr>';
				$i++;
			}

			$template	.= '	</tbody>
							</table>
						</div>';
		}

		echo $template;
	}

	/**
	* Descripción	: Borrar Adjunto
	* @author		: Domingo Cortez <domingo.cortez@cosof.cl>
	*/
	public function borrarAdjunto(){
		$parametros		= $this->request->getParametros();
		$id_adjunto		= $parametros[0];		
		$template		= '';
		
		unset($_SESSION[SESSION_BASE]['adjunto_mensaje'][$id_adjunto]);

		if(count($_SESSION[SESSION_BASE]['adjunto_mensaje']) > 0){
			$template	.= '<div class="col-xs-6 col-xs-offset-3" id="div_adjuntos" name="div_adjuntos">
							<table id="adjuntos" class="table table-hover table-condensed table-bordered" align=center>
								<thead>
								<tr>
									<th>Nombre Archivo</th>
									<th width="50px" nowrap>Descargar</th>
									<th width="50px" nowrap>Eliminar</th>
								</tr>
								</thead>
								<tbody>';
			$adjuntos	= $_SESSION[SESSION_BASE]['adjunto_mensaje'];
			$i			= 0;
			unset($_SESSION[SESSION_BASE]['adjunto_mensaje']);

			foreach($adjuntos as $adjunto){
				$_SESSION[SESSION_BASE]['adjunto_mensaje'][] = $adjunto;
				$template.= '		<tr>
										<td>										
											<strong>'.$adjunto['nombre_adjunto'].'</strong>
										</td>
										<td><a class="btn btn-xs btn-primary" href="javascript:void(0);" onclick="window.open(\''.BASE_URI.'/Soporte/verAdjunto/'.$i.'\',\'_blank\');">
												<i class="fa fa-download fa-2x"></i>
											</a>
										</td>										
										<td>										
											<button class="btn btn-xs btn-danger" type="button" onclick="borrarAdjunto('.$i.')">
												<i class="fa fa-trash-o fa-2x"></i>
											</button>
										</td>
									</tr>';
				$i++;
			}
			
			$template.= '		</tbody>
							</table>
						</div>';
		}

		echo $template;
	}

	/**
	* Descripción	: Ver Adjunto
	* @author		: Domingo Cortez <domingo.cortez@cosof.cl>
	*/
    public function verAdjunto(){
		$parametros		= $this->request->getParametros();
		$id_adjunto		= $parametros[0];

        if(isset($_SESSION[SESSION_BASE]['adjunto_mensaje'][$id_adjunto])){
            $adjunto	= $_SESSION[SESSION_BASE]['adjunto_mensaje'][$id_adjunto];
            header("Content-Type: ".$adjunto['mime_adjunto']);
            header("Content-Disposition: inline; filename=".$adjunto['nombre_adjunto']);
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            ob_end_clean();

			echo base64_decode($adjunto['contenido']);
            exit();
        }else{
            echo "El adjunto no existe";
        }
    }
}