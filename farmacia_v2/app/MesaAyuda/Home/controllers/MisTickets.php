<?php
namespace App\MesaAyuda\Home;

class MisTickets extends \pan\Kore\Controller {

    const WSDL_KEY_PUBLIC = '2R4bg63rkHI7v5aKd5ugRrSx3d3Mbu5by75xQyHoh1fYf';
    const WSDL_SOPORTE    = 'http://midastest.minsal.cl/soporte/ws/wsSoporte.php?wsdl';
    
    public function __construct()
    {
        parent::__construct();
        $this->session->isValidate();
        new \NuSoap();
    }

    public function index(){

        $params       = $_GET;
        $gl_asunto    = "";
        $gl_telefono  = "";
        $gl_email     = "";
        
        if(!empty($params)){
            $gl_asunto    = $params['gl_asunto'];
            $gl_telefono  = $params['gl_telefono'];
            $gl_email     = $params['gl_email'];
            $gl_mensaje   = $params['gl_mensaje'];
            $this->view->addJS('$("#registroTicket").show(200);');
        }

        $this->view->addJS('mesaAyuda.js');
        $this->view->addJS('MesaAyuda.cargarGrilla()');
        $this->view->addJS('adjunto.js', 'app/_FuncionesGenerales/Adjuntos/assets/js');

        //Set parametros adjuntos
        unset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjTicket']);
        $this->view->set('boComentarioAdj', 0);
        $this->view->set('cantAdjuntos', 1);
        $this->view->set('idTipoAdjunto', 3);
        $this->view->set('extensionAdjunto','');
        $this->view->set('idForm','adjTicket');
        //Fin parametros adjuntos
        
        $this->view->set('gl_asunto', $gl_asunto);
        $this->view->set('gl_telefono', $gl_telefono);
        $this->view->set('gl_email', $gl_email);
        $this->view->set('gl_mensaje', $gl_mensaje);

        $this->view->set('arrDatos', array());
        $this->view->set('grilla', $this->view->fetchIt('grilla'));
        $this->view->set('contenido', $this->view->fetchIt('index'));
        $this->view->render();
    }

    public function cargarGrilla(){

        $soportes 			      = array();
        $ws    				        = new \nusoap_client(self::WSDL_SOPORTE,'wsdl');
        $ws->soap_defencoding = 'UTF-8';
        $ws->decode_utf8 		  = false;

        if(!$ws->getError()){

          $ws_data	= array(
            'key_public'	=> self::WSDL_KEY_PUBLIC,
            'rut_usuario'	=> $_SESSION['hope']['gl_rut']
          );

          //file_put_contents('php://stderr', PHP_EOL . print_r($ws_data, TRUE). PHP_EOL, FILE_APPEND);
          $param		= array('data' => $ws_data);
          $result		= $ws->call('obtenerSoportesUsuario', $param);
        
          //file_put_contents('php://stderr', PHP_EOL . print_r("-------------------", TRUE). PHP_EOL, FILE_APPEND);
          //file_put_contents('php://stderr', PHP_EOL . print_r($result, TRUE). PHP_EOL, FILE_APPEND);
          $estado		= @$result['estado'];
          
          //$gl_glosa	= @$result['gl_glosa'];

          if($estado == 1){
            
            if (isset($result['arr_soportes'])) {
              if(isset($result['arr_soportes'][0])){
                $soportes	= $result['arr_soportes'];
              }else{
                $soportes[] = $result['arr_soportes'];
              }
            }
          }
      }

      $this->view->set('arrDatos',  $soportes);
      $this->view->render("grilla");	
    }
    
    //TO DO, REVISAR..

    /*
    public function index(){
    
      //Limpiar adjuntos de session
      $_SESSION['misfiscalizaciones']['Soporte']['adjuntos'] = array();
      $this->view->addJS('mesadeayuda.js');

      $soportes 			  = NULL;
      $ws    				  = new \nusoap_client(WSDL_SOPORTE,'wsdl');
      $ws->soap_defencoding = 'UTF-8';
      $ws->decode_utf8 		= false;
      if($ws->getError()){
        $error		= true;
        $correcto	= false;
        $msg		= 'Problemas con WebService';
      }else{
        $ws_data	= array(
                  'key_public'	=> WSDL_KEY_PUBLIC,
                  'rut_usuario'	=> $this->session->getSession('gl_rut'),
                );
        //file_put_contents('php://stderr', PHP_EOL . print_r($ws_data, TRUE). PHP_EOL, FILE_APPEND);
        $param		= array('data' => $ws_data);
        $result		= $ws->call('obtenerSoportesUsuario', $param);
        //file_put_contents('php://stderr', PHP_EOL . print_r("-------------------", TRUE). PHP_EOL, FILE_APPEND);
        //file_put_contents('php://stderr', PHP_EOL . print_r($result, TRUE). PHP_EOL, FILE_APPEND);
        $estado		= @$result['estado'];
        $gl_glosa	= @$result['gl_glosa'];

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



      $this->view->set('email', $this->session->getSession('gl_mail'));
      $this->view->set('rut', $this->session->getSession('gl_rut'));
      $this->view->set('soportes', $soportes);

      $this->view->set('grillaAdjuntos', '');
      //$this->view->set('adjuntos', $this->view->fetchIt('adjuntos'));
      $this->view->set('grilla', $this->view->fetchIt('grilla_'));
      $this->view->set('contenido', $this->view->fetchIt('mesadeayuda'));
      $this->view->render();
    } */
    
    
    /*
    public function cantidadSoporte(){
      
      //Limpiar adjuntos de session

      $soportesNoVistos 	  = 0;
      $soportes 			  = NULL;
      $ws    				  = new \nusoap_client(WSDL_SOPORTE,'wsdl');
      $ws->soap_defencoding = 'UTF-8';
      $ws->decode_utf8 		= false;
      if($ws->getError()){
        $json	= array('cantidad' => '-');
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        exit();
      }else{
        $ws_data	= array(
                  'key_public'	=> WSDL_KEY_PUBLIC,
                  'rut_usuario'	=> $this->session->getSession('gl_rut'),
                );
        //file_put_contents('php://stderr', PHP_EOL . print_r($ws_data, TRUE). PHP_EOL, FILE_APPEND);
        $param		= array('data' => $ws_data);
        $result		= $ws->call('obtenerSoportesUsuario', $param);
        //file_put_contents('php://stderr', PHP_EOL . print_r("-------------------", TRUE). PHP_EOL, FILE_APPEND);
        //file_put_contents('php://stderr', PHP_EOL . print_r($result, TRUE). PHP_EOL, FILE_APPEND);
        $estado		= @$result['estado'];
        $gl_glosa	= @$result['gl_glosa'];

        if($estado == 1){
          $error			= false;
          $msg			= $gl_glosa;

          if (isset($result['arr_soportes'])) {
            if(isset($result['arr_soportes'][0])){
              $soportes	= $result['arr_soportes'];
            }else{
              $soportes[] = $result['arr_soportes'];
            }
          }
          foreach ($soportes as $key => $item) {
            if($item['usuario_vio_respuesta'] == 0){
              $soportesNoVistos += 1;
            }
          }
        }else{
          $json	= array('cantidad' => '-');
          echo json_encode($json, JSON_UNESCAPED_UNICODE);
          exit();
        }



      }


      $json	= array('cantidad' => $soportesNoVistos);
      echo json_encode($json, JSON_UNESCAPED_UNICODE);

    }
    */
    
    
    /**
    * Descripción	: Guardar Soporte
    * @author		: Domingo Cortez <domingo.cortez@cosof.cl>
    */
    public function guardar(){

      $data		  = $this->request->getParametros();
      $error	  = true;
      $correcto = false;
      $msg			= '::';
      $adjuntos	= array();

      $ws						        = new \nusoap_client(self::WSDL_SOPORTE,'wsdl');
      
      $ws->soap_defencoding	= 'UTF-8';
      $ws->decode_utf8 		  = false;

      // if(isset($_SESSION[SESSION_BASE]['adjunto_mensaje'])){
      // 	foreach($_SESSION[SESSION_BASE]['adjunto_mensaje'] as $k=>$adj){
      // 		$adjuntos[$k]['nombre_adjunto']	= $adj['nombre_adjunto'];
      // 		$adjuntos[$k]['base64_adjunto']	= $adj['contenido'];
      // 	}
      // }
      /*
      if(isset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjTicket'])){
        foreach($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjTicket'] as $key => $adj){
          $adjuntos[$key]['nombre_adjunto']	= $adj['gl_nombre'];
          $adjuntos[$key]['base64_adjunto']	= $adj['contenido'];

        }
      }*/
    
      if($ws->getError()){
        $error		= true;
        $correcto	= false;
        $msg		= 'Problemas con WebService';
      }else{
        
        try {
          // TODO: Mejora:
          // Validar tipos de datos de arreglo $ws_data ->
          // Revisar parametros y adaptar a ops
          $ws_data			= array(
            'key_public'				         => self::WSDL_KEY_PUBLIC,
            //'asunto_soporte'	         => (validar($data['asunto'],'string')),
            //'cuerpo_soporte'	         => (validar($data['mensaje'],'string')),
            'asunto_soporte'			       => $data['asunto'],
            'cuerpo_soporte'			       => $data['mensaje'],
            'id_region'					         => 0,
            'gl_codigo_sistema'		       => '1',
            'gl_tramite'				         => 0,
            //'rut_usuario_creador'	     => (isset($_SESSION[SESSION_BASE]['rut']) ? $_SESSION[SESSION_BASE]['rut'] : (validar($data['run'],'string'))),
            //'nombre_usuario_creador'   => (isset($data['nombre']) ? (validar($data['nombre'],'string')) : ''),
            //'rut_usuario_creador'		   => (isset($_SESSION[SESSION_BASE]['rut']) ? $_SESSION[SESSION_BASE]['rut'] : $data['rut'] ),
            'rut_usuario_creador'        => $_SESSION['hope']['gl_rut'],//To do, revisar.
            'nombre_usuario_creador'	   => $_SESSION['hope']['gl_nombre_completo'],
            //'email_usuario_creador'	   => (validar($data['email'],'string')),
            //'telefono_usuario_creador' => (validar($data['telefono'],'string')),
            'email_usuario_creador'		   => $data['email'],
            'telefono_usuario_creador'	 => $data['telefono'],
            //'id_region_creador'			   => (isset($data['region_soporte']) ? (validar($data['region_soporte'],'string')) : 0),
            //'id_region_creador'			   => (isset($data['region_soporte']) ? $data['region_soporte'] : 0),
            'id_region_creador'			     => 0,
            'adjuntos'					         => $adjuntos,
          );
          

          $param	    = array('data' => $ws_data);

          $result		  = $ws->call('crearSoporte', $param);
          $estado		  = $result['estado'];
          $gl_glosa	  = $result['gl_glosa'];
          $gl_codigo  = $result['gl_codigo'];

          if($estado == 1){
            $error		= false;
            $correcto	= true;
            $msg			= $gl_codigo;
            //$this->enviarEmail($ws_data);
            //unset($_SESSION[SESSION_BASE]['adjunto_mensaje']);
            //unset($_SESSION['misfiscalizaciones']['Soporte']['adjuntos']);
          }else{
            $error		= true;
            $correcto	= false;
            $msg			= 'Error al Guardar';

          }
        } catch (\Throwable $th) {
          file_put_contents('php://stderr', PHP_EOL . print_r('ERROR:'.$th, TRUE). PHP_EOL, FILE_APPEND);
        }
      }

      $salida	= array(
        "error"		 => $error,
        "correcto" => $correcto,
        "msg"		   => $msg,
      );

      echo json_encode($salida, JSON_UNESCAPED_UNICODE);
    }
    
    /*
    public function verDetalleSoporte($id_soporte){
      //echo $id_soporte;

      $gl_rut_usuario	        = $this->session->getSession('rut');
      $detalle				= array();
      $historial				= array();
      $adjuntos_usu			= array();
      $adjuntos_fap			= array();

      $ws						= new \nusoap_client(WSDL_SOPORTE,'wsdl');
          $ws->soap_defencoding	= 'UTF-8';
      $ws->decode_utf8 		= false;

      if($ws->getError()){
        $this->view->set('errorWS', true);
      }else{

        $ws_data			= array(
                        'key_public'		=> WSDL_KEY_PUBLIC,
                        'id_soporte'		=> $id_soporte,
                        'gl_rut_usuario'	=> $gl_rut_usuario,
                        );
        $param				= array('data' => $ws_data);
        $result				= $ws->call('obtenerSoportesDetalle', $param);

        if(empty($result['arr_detalle'])){
          //$this->smarty->assign('errorWS',$result['gl_glosa']);
          $this->view->set('errorWS', $result['gl_glosa']);
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
      file_put_contents('php://stderr', PHP_EOL . print_r("=====<gl_rut_usuario>=====", TRUE). PHP_EOL, FILE_APPEND);
      file_put_contents('php://stderr', PHP_EOL . print_r($gl_rut_usuario, TRUE). PHP_EOL, FILE_APPEND);
      file_put_contents('php://stderr', PHP_EOL . print_r("=====<detalle>=====", TRUE). PHP_EOL, FILE_APPEND);
      file_put_contents('php://stderr', PHP_EOL . print_r($detalle, TRUE). PHP_EOL, FILE_APPEND);
      file_put_contents('php://stderr', PHP_EOL . print_r("=====<historial>=====", TRUE). PHP_EOL, FILE_APPEND);
      file_put_contents('php://stderr', PHP_EOL . print_r($historial, TRUE). PHP_EOL, FILE_APPEND);
      file_put_contents('php://stderr', PHP_EOL . print_r("=====<adjuntos_usu>=====", TRUE). PHP_EOL, FILE_APPEND);
      file_put_contents('php://stderr', PHP_EOL . print_r($adjuntos_usu, TRUE). PHP_EOL, FILE_APPEND);
      file_put_contents('php://stderr', PHP_EOL . print_r("=====<adjuntos_fap>=====", TRUE). PHP_EOL, FILE_APPEND);
      file_put_contents('php://stderr', PHP_EOL . print_r($adjuntos_fap, TRUE). PHP_EOL, FILE_APPEND);
      //$this->smarty->assign('gl_rut_usuario',$gl_rut_usuario);
      $this->view->set('gl_rut_usuario', $gl_rut_usuario);
      //$this->smarty->assign('soporte',$detalle);
      $this->view->set('soporte', $detalle);
      //$this->smarty->assign('historial',$historial);
      $this->view->set('historial', $historial);
      //$this->smarty->assign('adjuntos_usu',$adjuntos_usu);
      $this->view->set('adjuntos_usu', $adjuntos_usu);
      //$this->smarty->assign('adjuntos_fap',$adjuntos_fap);
      $this->view->set('adjuntos_fap', $adjuntos_fap);

      $this->view->render('detalleSoporte');

    }

    */

    /*
    public function imprimir($id_soporte, $gl_codigo_soporte){
      // error_log($id_soporte);
      // error_log($gl_codigo_soporte);
      $gl_rut_usuario	        = $this->session->getSession('rut');
      $nombre					= 'SOPORTE #'.$gl_codigo_soporte.'.pdf';

      $ws						= new \nusoap_client(WSDL_SOPORTE,'wsdl');
          $ws->soap_defencoding	= 'UTF-8';
      $ws->decode_utf8 		= false;


      if($ws->getError()) {
        echo '<b>Hubo un problema.</b><br> Favor intentar nuevamente o contactarse con el Administrador';
      }else{

        $ws_data			= array(
                        'key_public'		=> WSDL_KEY_PUBLIC,
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
    */

}
