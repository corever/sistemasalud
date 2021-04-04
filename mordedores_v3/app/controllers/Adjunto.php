<?php
/**
 ******************************************************************************
 * Sistema           : PREVENCION DE FEMICIDIOS
 *
 * Descripción       : Controlador de archivos adjuntos
 *
 * Plataforma        : PHP
 *
 * Creación          : 13/02/2017
 *
 * @name             Adjunto.php
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
class Adjunto extends Controller{

    protected $_DAOAdjunto;
    protected $_formatoArchivo;

	function __construct() {
		parent::__construct();
        $this->load->lib('Boton', false);
		$this->load->lib('Fechas', false);
		$this->load->lib('formatoArchivo', false);
        $this->_formatoArchivo      = new formatoArchivo();
        $this->_DAOAdjunto			= $this->load->model("DAOAdjunto");
        $this->_DAOExpediente       = $this->load->model("DAOExpediente");
	}

	/**
	* Descripción	: Cargar Adjunto
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function cargarAdjunto(){
		$this->smarty->display('adjunto/cargar_adjunto.tpl');
        $this->load->javascript(STATIC_FILES . "js/templates/adjunto/adjunto.js");
	}

	/**
	* Descripción	: Guardar Adjunto
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
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
				$_SESSION[SESSION_BASE]['adjunto'][] = $arr_adjunto;
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
			echo "<script>Adjunto.cargarListadoAdjuntos('listado-adjuntos'); parent.xModal.close();</script>";
		}else{
			$this->view->assign('success',$success);
			$this->view->assign('mensaje',$mensaje);

			$this->view->assign('template',$this->view->fetch('Adjunto/cargar_adjunto.tpl'));
			$this->view->display('template_iframe.tpl');
		}
	}

	/**
	* Descripción	: Cargar Listado
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function cargarListado(){
		$adjuntos	= array();
		$template	= '';

		if(isset($_SESSION[SESSION_BASE]['adjunto'])){
			$template.= '<div class="col-xs-6 col-xs-offset-3" id="div_adjuntos" name="div_adjuntos">
							<table id="adjuntos" class="table table-hover table-condensed table-bordered" align=center>
								<thead>
									<tr>
										<th>Nombre Archivo</th>
										<th width="50px" nowrap>Descargar</th>
										<th width="50px" nowrap>Eliminar</th>
									</tr>
								</thead>
								<tbody>';
			$adjuntos	= $_SESSION[SESSION_BASE]['adjunto'];
			$i			= 0;

			foreach($adjuntos as $adjunto){
				$template.= '	<tr>
									<td>
										<strong>'.$adjunto['nombre_adjunto'].'</strong>
									</td>
									<td><a class="btn btn-xs btn-primary" href="javascript:void(0);" onclick="window.open(\''.BASE_URI.'/Adjunto/verAdjunto/'.$i.'\',\'_blank\');">
											<i class="fa fa-download fa-2x"></i>
										</a>
									</td>
									<td>
										<button class="btn btn-xs btn-danger" type="button" onclick="Adjunto.borrarAdjunto('.$i.')">
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
	* Descripción	: Borrar Adjunto
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function borrar(){
		$id_adjunto	= $_POST['adjunto'];
		$template	= '';
		unset($_SESSION[SESSION_BASE]['adjunto'][$id_adjunto]);

		if(count($_SESSION[SESSION_BASE]['adjunto']) > 0){
			$template.= '<div class="col-xs-6 col-xs-offset-3" id="div_adjuntos" name="div_adjuntos">
							<table id="adjuntos" class="table table-hover table-condensed table-bordered" align=center>
								<thead>
								<tr>
									<th>Nombre Archivo</th>
									<th width="50px" nowrap>Descargar</th>
									<th width="50px" nowrap>Eliminar</th>
								</tr>
								</thead>
								<tbody>';
			$adjuntos	= $_SESSION[SESSION_BASE]['adjunto'];
			$i			= 0;
			unset($_SESSION[SESSION_BASE]['adjunto']);

			foreach($adjuntos as $adjunto)
			{
				$_SESSION[SESSION_BASE]['adjunto'][] = $adjunto;
				$template.= '	<tr>
									<td>
										<strong>'.$adjunto['nombre_adjunto'].'</strong>
									</td>
									<td><a class="btn btn-xs btn-primary" href="javascript:void(0);" onclick="window.open(\''.BASE_URI.'/Adjunto/verAdjunto/'.$i.'\',\'_blank\');">
											<i class="fa fa-download fa-2x"></i>
										</a>
									</td>
									<td>
										<button class="btn btn-xs btn-danger" type="button" onclick="Adjunto.borrarAdjunto('.$i.')">
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
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
    public function ver(){
        $id_adjunto = Request::getParametros(0);

        if(isset($_SESSION[SESSION_BASE]['adjuntos'][$id_adjunto])){
            $adjunto = $_SESSION[SESSION_BASE]['adjuntos'][$id_adjunto];
            header("Content-Type: ".$adjunto['mime_adjunto']);
            header("Content-Disposition: inline; filename=".$adjunto['nombre_adjunto']);
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            ob_end_clean();
            echo base64_decode($adjunto['contenido']);
            exit();
        }elseif(isset($_SESSION[SESSION_BASE]['adjunto'][$id_adjunto])){
            $adjunto = $_SESSION[SESSION_BASE]['adjunto'][$id_adjunto];
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

	/**
	* Descripción	: Ver Doc Inicial by token expediente
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
    public function verDocInicialByTokenExpediente(){
        $params             = $this->_request->getParams();
        $token_expediente   = $params['token'];

        if($token_expediente){
            $expediente     = $this->_DAOExpediente->getByToken($token_expediente);
            $adjunto        = $this->_DAOAdjunto->getByExpedienteyTipo($expediente->id_expediente,7);

			if(!empty($adjunto)){
				$extension			= $this->_formatoArchivo->mime_content_type($adjunto->gl_nombre);
				//$adjunto->gl_path	= trim($adjunto->gl_path,'../');
				//$fp					= fopen(BASE_DIR."/".$adjunto->gl_path, 'rb');

				$fichero = BASE_DIR."/".$adjunto->gl_path;
				if (file_exists($fichero)) {
					header("Content-Type: ".$extension);
					header("filename=".$adjunto->gl_nombre);
					header("Content-Transfer-Encoding: binary");
					header('Accept-Ranges: bytes');
					header("Content-Disposition: ; filename=\"".$adjunto->gl_nombre."\"");
					//ob_end_clean();
					//fpassthru($fp);
					//readfile($fichero);

					$pdf = file_get_contents($fichero);
                    
                    if(base64_decode($pdf, true)===false){
                        $bo_base64 = FALSE; //ES BASE64
                    }else{
                        $bo_base64 = TRUE; //NO ES BASE64
                    }
                    
                    if($bo_base64){ //SI ES BASE64 HACE DECODE PARA MOSTRAR CONTENIDO
                        echo base64_decode($pdf);
                    }else{
                        echo $pdf;
                    }
                    
					exit;
				}else{
					echo 'archivo no encontrado';
				}
			}else{
				echo 'archivo no encontrado';
			}
        }else{
			echo 'archivo no encontrado.';
		}
    }

	/**
	* Descripción	: Ver Adjunto
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
    public function verByToken(){
        $params         = $this->_request->getParams();
        $token_adjunto  = $params['token'];

        if($token_adjunto){
            $adjunto    = $this->_DAOAdjunto->getByToken($token_adjunto);

			if(!empty($adjunto)){

				$extension  = $this->_formatoArchivo->mime_content_type($adjunto->gl_nombre);
				$fichero    = BASE_DIR."/".$adjunto->gl_path;

				if (file_exists($fichero)) {
                    $pdf = file_get_contents($fichero);

					header("Content-Type: ".$extension);
					header("filename=".$adjunto->gl_nombre);
					header("Content-Transfer-Encoding: binary");
					header('Accept-Ranges: bytes');
					header("Content-Disposition: ; filename=\"".$adjunto->gl_nombre."\"");
					ob_end_clean();

                    if(base64_decode($pdf, true)===false){
                        $bo_base64 = FALSE; //ES BASE64
                    }else{
                        $bo_base64 = TRUE; //NO ES BASE64
                    }
                    if($bo_base64){ //SI ES BASE64 HACE DECODE PARA MOSTRAR CONTENIDO
                        echo base64_decode($pdf);
                    }else{
                        echo $pdf;
                    }
					exit;
				}else{
					echo 'archivo no encontrado';
				}
			}else{
				echo 'archivo no encontrado';
			}
        }else{
			echo 'archivo no encontrado.';
		}
    }

    public function modificarAdjunto() {

        $params = $this->_request->getParams();
        $adjunto = $this->_DAOAdjunto->getByToken($params['token']);

        if(isset($params['token'])){
            $this->smarty->assign("gl_token", $params['token']);
        }
        if (!is_null($adjunto->gl_nombre)) {
            $this->smarty->assign("gl_nombre", $adjunto->gl_nombre);
        }

        $this->smarty->display('bitacora/modificarAdjunto.tpl');
    }


}