<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 *
 * Descripción       : Controller para el ingreso al Sistema.
 *
 * Plataforma        : PHP
 *
 * Creación          : 08/05/2018
 *
 * @name             Login.php
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
class Login extends Controller {

    protected $_DAOUsuario;
    protected $_DAOUsuarioPerfil;
    protected $_DAORegion;
    protected $_DAOComuna;
    protected $_DAOProvincia;
    protected $_DAOAuditoriaLogin;

    function __construct() {
        parent::__construct();
		include_once("app/libs/nusoap/lib/nusoap.php");

        $this->load->lib('Seguridad', false);
		$this->load->lib('Fechas', false);
		$this->load->lib('Evento', false);
        $this->_Evento              = new Evento();
        $this->_DAOUsuario          = $this->load->model("DAOAccesoUsuario");
        $this->_DAOUsuarioPerfil    = $this->load->model("DAOAccesoUsuarioPerfil");
        $this->_DAORegion			= $this->load->model("DAODireccionRegion");
        $this->_DAOComuna			= $this->load->model("DAODireccionComuna");
        $this->_DAOProvincia		= $this->load->model("DAODireccionProvincia");
        $this->_DAOAuditoriaLogin	= $this->load->model("DAOAuditoriaLogin");
        $this->_DAOCron				= $this->load->model("DAOCron");
    }

	/**
	* Descripción	: Mostrar login o dashboard, según esté o no logueado
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
    public function index() {
        if (isset($_SESSION[SESSION_BASE]['id'])) {
            $usuario = $this->_DAOUsuario->getById($_SESSION[SESSION_BASE]['id']);
            if (!is_null($usuario)) {
                header("location: index.php/Home/dashboard");
                die();
            }
        }
        $_SESSION[SESSION_BASE]['autenticado'] = FALSE;
        $this->smarty->assign("hidden", "hidden");
        $this->smarty->display('login/login.tpl');
    }

	/**
	* Descripción	: Procesa información ingresada para el Login
	* @author		: Víctor Retamal <victor.retamal@cosof.cl>
	* @param string $rut RUT del Usuario
	* @param string $password Clave del Usuario
	*/
    public function procesar() {
        $rut			= trim($this->_request->getParam("rut"));
        $password		= Seguridad::generar_sha512($this->_request->getParam("password"));
        //$recordar		= trim($this->_request->getParam("recordar"));
        $recordar		= 0;
		$primer_login	= FALSE;
		$usuario        = FALSE;

        //Validar Usuario que tenga perfil bo_principal = 1 y bo_activo = 1
        //Si no tiene bo_principal = 1 pero si uno bo_activo = 1 lo setea como principal
        $validado		= $this->_DAOUsuario->validarUsuario($rut);

	$usuario		= false;
        if($validado){
            $usuario		= $this->_DAOUsuario->getLogin($rut, $password);
        }

        if (empty($usuario->fc_ultimo_login)) {
			$primer_login = TRUE;
		}

        if ($usuario) {
			if($usuario->bo_activo == 1){
				$registro						= $this->_DAOAuditoriaLogin->registro_login($usuario->id_usuario, $rut, 'Login');

				$_SESSION[SESSION_BASE]['id']						= $usuario->id_usuario;
				$_SESSION[SESSION_BASE]['id_usuario_original']      = 0;
				$_SESSION[SESSION_BASE]['gl_token_original']        = 0;
				$_SESSION[SESSION_BASE]['perfil']					= $usuario->id_perfil;
                $_SESSION[SESSION_BASE]['id_usuario_perfil']        = $usuario->id_usuario_perfil;
				$_SESSION[SESSION_BASE]['gl_token']                 = $usuario->gl_token;
				$_SESSION[SESSION_BASE]['id_establecimiento']       = $usuario->id_establecimiento;
                $_SESSION[SESSION_BASE]['id_servicio']              = $usuario->id_servicio;
				$_SESSION[SESSION_BASE]['id_laboratorio']			= $usuario->id_laboratorio;
				$_SESSION[SESSION_BASE]['id_oficina']				= $usuario->id_oficina;
				$_SESSION[SESSION_BASE]['id_comuna']				= $usuario->id_comuna;
				$_SESSION[SESSION_BASE]['bo_establecimiento']		= $usuario->bo_establecimiento;
				$_SESSION[SESSION_BASE]['bo_nacional']				= $usuario->bo_nacional;
				$_SESSION[SESSION_BASE]['bo_regional']				= $usuario->bo_regional;
				$_SESSION[SESSION_BASE]['bo_oficina']				= $usuario->bo_oficina;
				$_SESSION[SESSION_BASE]['bo_comunal']				= $usuario->bo_comunal;
				$_SESSION[SESSION_BASE]['bo_seremi']				= $usuario->bo_seremi;
				$_SESSION[SESSION_BASE]['gl_nombres']				= $usuario->gl_nombres;
				$_SESSION[SESSION_BASE]['gl_apellidos']				= $usuario->gl_apellidos;
				$_SESSION[SESSION_BASE]['nombre']					= $usuario->gl_nombres . " " . $usuario->gl_apellidos;
				$_SESSION[SESSION_BASE]['rut']                      = $usuario->gl_rut;
				$_SESSION[SESSION_BASE]['mail']                     = $usuario->gl_email;
				$_SESSION[SESSION_BASE]['id_region']				= $usuario->id_region;
				$_SESSION[SESSION_BASE]['bo_cambio_usuario']        = $usuario->bo_cambio_usuario;
				$_SESSION[SESSION_BASE]['bo_informar_web']          = ($usuario->id_perfil == 14)?1:$usuario->bo_informar_web;
				$_SESSION[SESSION_BASE]['bo_cambio_usuario_real']   = 0;
				$_SESSION[SESSION_BASE]['primer_login']             = $primer_login;
				$_SESSION[SESSION_BASE]['autenticado']              = TRUE;

                //if (!$primer_login) {
					$datos  = array($_SESSION[SESSION_BASE]['id']);
					$upd    = $this->_DAOUsuario->setUltimoLogin($datos);
				//}

				if ($recordar == 1) {
					setcookie('datos_usuario_carpeta', $usuario->id_usuario, time() + 365 * 24 * 60 * 60);
				}
				/*
				if($primer_login) {
					header('Location: ' . BASE_URI . '/Login/actualizar');
				}else{
					header('Location: ' . BASE_URI . '/Home/dashboard');
				}
				*/
				header('Location: ' . BASE_URI . '/Home/dashboard');
			}else{
				$registro	= $this->_DAOAuditoriaLogin->registro_login(0, $rut, 'Login - Inhabilitado');
				$this->smarty->assign("hidden", "");
				$this->smarty->assign("texto_error", "Usuario se encuentra Inhabilitado.");
				$this->smarty->display('login/login.tpl');
			}
        }else{
			$registro	= $this->_DAOAuditoriaLogin->registro_login(0, $rut, 'Login - datos incorrecto');
            $this->smarty->assign("hidden", "");
            $this->smarty->assign("texto_error", "Los datos ingresados no son válidos.");
            $this->smarty->display('login/login.tpl');
        }
    }

	/**
	* Descripción	: Validar RUT usuario MIDAS
	* @author		: Víctor Retamal <victor.retamal@cosof.cl>
	* @param string $rut RUT del Usuario MIDAS
	*/
    public function validaRutMidas(){
		ini_set('error_reporting', 0);
		ini_set('display_errors', 0);

		$parametros	= $this->request->getParametros();
		$rut		= $parametros[0];
		$usuario	= array();
		$dataCron	= array();

		if( isset($rut) and trim($rut) != "" ){
			$usuario	= $this->_DAOUsuario->getLoginMidas(strtolower($rut));
            
            //Update de asignados microchip con mas de 90 dias
            $arrUpdate	= $this->_DAOCron->updateMicrochipDias(90);
            //Guardar Evento casos especiales 90 dias
            if(!empty($arrUpdate)){
                $gl_descripcion = "Se devuelve a Supervisor, motivo: Cambio Automático por pasar los 90 días.";
                foreach($arrUpdate as $exp){
                    $this->_Evento->guardar(16, $exp->id_expediente, 0, 0, $gl_descripcion);
                }
            }
            
            //Cron por día
            $existeCron	= $this->_DAOCron->getCronByDia();

			if(empty($existeCron)){
				$dataCron		= $this->_DAOCron->updateMicrochip();
				//$nr_cantidad	= $dataCron->row_0->nr_cantidad;
				$nr_cantidad	= count((array)$dataCron);
				$json_datos		= ($nr_cantidad>0) ? json_encode($dataCron,JSON_UNESCAPED_SLASHES):NULL;
				$this->_DAOCron->registroCron($nr_cantidad,$rut,$json_datos);
			}
		}

		if(!empty($usuario) AND $usuario->bo_activo == 1){
			echo json_encode(array('rut'=>$usuario->gl_rut));
		}else{
			echo json_encode(array('rut'=>''));
		}

	}

	/**
	* Descripción	: Login Remoto desde MIDAS v2
	* @author		: Víctor Retamal <victor.retamal@cosof.cl>
	* @param string $token Token del Usuario MIDAS
	*/
	/*
	public function loginRemotoMidas(){
        define('MIDAS_WS_AUTH_USER','Midas_Soap_User');
        define('MIDAS_WS_AUTH_PASS','BQT9U4Ni2yVZHhPQq3T2YpM8RsvwPCSNK0mQX33nBjmfIbvgQK3UeRsLJJxRELetXk8iL9Gj');

		$parametros		= $this->request->getParametros();
		$token			= $parametros[0];
        //$recordar		= trim($this->_request->getParam("recordar"));
        $recordar		= 0;
		$primer_login	= FALSE;

		$usuario		= array();
		//$ws_info		= $this->_daoWS_Sistema->getWS('MIDAS' ,ENVIROMENT);
		//$wsdl			= $ws_info->sistema_wsdl;

		$ws				= new nusoap_client('https://192.168.10.165/midas_prueba/ws/wsMIDAS.php?wsdl');
		$ws->setCredentials(MIDAS_WS_AUTH_USER, MIDAS_WS_AUTH_PASS, 'basic');
		$ws->soap_defencoding	= 'UTF-8';
		$ws->decode_utf8 		= false;
		$error					= $ws->getError();

		if($error){
            $this->smarty->assign("hidden", "");
            $this->smarty->assign("texto_error", "Usuario no está activo o hubo un problema con el WebService.");
            $this->smarty->display('login/login.tpl');
		}else{
			$ws_data    = array('token'	=> $token,);
			$param		= array('cabecera' => $ws_data);
			$arr		= $ws->call('validarToken', $param);

			if(isset($arr['rut']) and trim($arr['rut']) != "" ){
				$usuario	= $this->_DAOUsuario->getLoginMidas(strtolower($arr['rut']));
			}else{
				$this->smarty->assign("hidden", "");
				$this->smarty->assign("texto_error", $arr['error']['GlosaError']);
				$this->smarty->display('login/login.tpl');
			}

			if ($usuario) {
				if($usuario->bo_activo == 1){
					$registro						= $this->_DAOAuditoriaLogin->registro_login($usuario->id_usuario, $arr['rut'], 'loginMIDAS', $token);

					$_SESSION[SESSION_BASE]['id']						= $usuario->id_usuario;
					$_SESSION[SESSION_BASE]['id_usuario_original']      = 0;
					$_SESSION[SESSION_BASE]['gl_token_original']        = 0;
					$_SESSION[SESSION_BASE]['perfil']					= $usuario->id_perfil;
					$_SESSION[SESSION_BASE]['id_usuario_perfil']        = $usuario->id_usuario_perfil;
					$_SESSION[SESSION_BASE]['gl_token']                 = $usuario->gl_token;
					$_SESSION[SESSION_BASE]['id_establecimiento']       = $usuario->id_establecimiento;
					$_SESSION[SESSION_BASE]['id_laboratorio']			= $usuario->id_laboratorio;
					$_SESSION[SESSION_BASE]['id_oficina']				= $usuario->id_oficina;
					$_SESSION[SESSION_BASE]['bo_establecimiento']		= $usuario->bo_establecimiento;
					$_SESSION[SESSION_BASE]['bo_nacional']				= $usuario->bo_nacional;
					$_SESSION[SESSION_BASE]['bo_seremi']				= $usuario->bo_seremi;
					$_SESSION[SESSION_BASE]['gl_nombres']				= $usuario->gl_nombres;
					$_SESSION[SESSION_BASE]['gl_apellidos']				= $usuario->gl_apellidos;
					$_SESSION[SESSION_BASE]['nombre']					= $usuario->gl_nombres . " " . $usuario->gl_apellidos;
					$_SESSION[SESSION_BASE]['rut']                      = $usuario->gl_rut;
					$_SESSION[SESSION_BASE]['mail']                     = $usuario->gl_email;
					$_SESSION[SESSION_BASE]['id_region']				= $usuario->id_region;
					$_SESSION[SESSION_BASE]['bo_cambio_usuario']        = $usuario->bo_cambio_usuario;
					$_SESSION[SESSION_BASE]['bo_cambio_usuario_real']   = 0;
					$_SESSION[SESSION_BASE]['primer_login']             = $primer_login;
					$_SESSION[SESSION_BASE]['autenticado']              = TRUE;

                    //if (!$primer_login) {
						$datos						= array($_SESSION[SESSION_BASE]['id']);
						$upd						= $this->_DAOUsuario->setUltimoLogin($datos);
					//}

					if ($recordar == 1) {
						setcookie('datos_usuario_carpeta', $usuario->id_usuario, time() + 365 * 24 * 60 * 60);
					}
					if($primer_login) {
						header('Location: ' . BASE_URI . '/Login/actualizar');
					}else{
						header('Location: ' . BASE_URI . '/Home/dashboard');
					}
				}else{
					$registro	= $this->_DAOAuditoriaLogin->registro_login(0, $arr['rut'], 'loginMIDAS', $token);
					$this->smarty->assign("hidden", "");
					$this->smarty->assign("texto_error", "Usuario se encuentra Inhabilitado.");
					$this->smarty->display('login/login.tpl');
				}
			}else{
				$this->smarty->assign("hidden", "");
				$this->smarty->assign("texto_error", "Los datos ingresados no son válidos.");
				$this->smarty->display('login/login.tpl');
			}
		}
	}
	*/

	/**
	* Descripción	: Login Remoto desde MIDAS v1
	* @author		: Víctor Retamal <victor.retamal@cosof.cl>
	* @param string $rut RUT del Usuario MIDAS
	*/
	public function loginRemotoMidas(){
		$parametros		= $this->request->getParametros();
		$rut			= $parametros[0];
        $recordar		= 0;
		$primer_login	= FALSE;

        //Validar Usuario que tenga perfil bo_principal = 1 y bo_activo = 1
        //Si no tiene bo_principal = 1 pero si uno bo_activo = 1 lo setea como principal
        $validado		= $this->_DAOUsuario->validarUsuario($rut);

	$usuario		= false;
        if($validado){
            $usuario		= $this->_DAOUsuario->getLoginMidas($rut);
        }

        if ($usuario) {
			if($usuario->bo_activo == 1){
				$registro	= $this->_DAOAuditoriaLogin->registro_login($usuario->id_usuario, $rut, 'LoginMIDAS');

				$_SESSION[SESSION_BASE]['id']						= $usuario->id_usuario;
				$_SESSION[SESSION_BASE]['id_usuario_original']      = 0;
				$_SESSION[SESSION_BASE]['gl_token_original']        = 0;
				$_SESSION[SESSION_BASE]['perfil']					= $usuario->id_perfil;
                $_SESSION[SESSION_BASE]['id_usuario_perfil']        = $usuario->id_usuario_perfil;
				$_SESSION[SESSION_BASE]['gl_token']                 = $usuario->gl_token;
				$_SESSION[SESSION_BASE]['id_establecimiento']       = $usuario->id_establecimiento;
                $_SESSION[SESSION_BASE]['id_servicio']              = $usuario->id_servicio;
				$_SESSION[SESSION_BASE]['id_laboratorio']			= $usuario->id_laboratorio;
				$_SESSION[SESSION_BASE]['id_oficina']				= $usuario->id_oficina;
				$_SESSION[SESSION_BASE]['id_comuna']				= $usuario->id_comuna;
				$_SESSION[SESSION_BASE]['bo_establecimiento']		= $usuario->bo_establecimiento;
				$_SESSION[SESSION_BASE]['bo_nacional']				= $usuario->bo_nacional;
				$_SESSION[SESSION_BASE]['bo_regional']				= $usuario->bo_regional;
				$_SESSION[SESSION_BASE]['bo_oficina']				= $usuario->bo_oficina;
				$_SESSION[SESSION_BASE]['bo_comunal']				= $usuario->bo_comunal;
				$_SESSION[SESSION_BASE]['bo_seremi']				= $usuario->bo_seremi;
				$_SESSION[SESSION_BASE]['gl_nombres']				= $usuario->gl_nombres;
				$_SESSION[SESSION_BASE]['gl_apellidos']				= $usuario->gl_apellidos;
				$_SESSION[SESSION_BASE]['nombre']					= $usuario->gl_nombres . " " . $usuario->gl_apellidos;
				$_SESSION[SESSION_BASE]['rut']                      = $usuario->gl_rut;
				$_SESSION[SESSION_BASE]['mail']                     = $usuario->gl_email;
				$_SESSION[SESSION_BASE]['id_region']				= $usuario->id_region;
				$_SESSION[SESSION_BASE]['bo_cambio_usuario']        = $usuario->bo_cambio_usuario;
				$_SESSION[SESSION_BASE]['bo_informar_web']          = ($usuario->id_perfil == 14)?1:$usuario->bo_informar_web;
				$_SESSION[SESSION_BASE]['bo_cambio_usuario_real']   = 0;
				$_SESSION[SESSION_BASE]['primer_login']             = $primer_login;
				$_SESSION[SESSION_BASE]['autenticado']              = TRUE;

                //if (!$primer_login) {
					$datos  = array($_SESSION[SESSION_BASE]['id']);
					$upd    = $this->_DAOUsuario->setUltimoLogin($datos);
				//}

				if ($recordar == 1) {
					setcookie('datos_usuario_carpeta', $usuario->id_usuario, time() + 365 * 24 * 60 * 60);
				}
				if($primer_login) {
					header('Location: ' . BASE_URI . '/Login/actualizar');
				}else{
					header('Location: ' . BASE_URI . '/Home/dashboard');
				}
			}else{
				$registro	= $this->_DAOAuditoriaLogin->registro_login(0, $rut, 'LoginMIDAS - Inhabilitado');
				$this->smarty->assign("hidden", "");
				$this->smarty->assign("texto_error", "Usuario se encuentra Inhabilitado.");
				$this->smarty->display('login/login.tpl');
			}
        }else{
			$registro	= $this->_DAOAuditoriaLogin->registro_login(0, $rut, 'LoginMIDAS - datos incorrecto');
            $this->smarty->assign("hidden", "");
            $this->smarty->assign("texto_error", "Los datos ingresados no son válidos.");
            $this->smarty->display('login/login.tpl');
        }

	}

	/**
	* Descripción	: Obtener Cuenta de Usuario
	* @author		: Orlando Vazquez <orlando.vazquez@cosof.cl>
	*/
	// Buscar donde se utiliza
    public function obtener_cuenta(){
        $this->_addJavascript(STATIC_FILES . 'js/templates/login/obtener_cuenta.js');
        $this->_display('login/obtener_cuenta.tpl', false);
    }

	/**
	* Descripción	: Actualizar Password de Usuario
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
    public function actualizar(){
		$id_usuario	= (isset($_SESSION[SESSION_BASE]['id']))?$_SESSION[SESSION_BASE]['id']:0;
		$nombre		= (isset($_SESSION[SESSION_BASE]['nombre']))?$_SESSION[SESSION_BASE]['nombre']:'';
		$rut		= (isset($_SESSION[SESSION_BASE]['rut']))?$_SESSION[SESSION_BASE]['rut']:'';
		$mail		= (isset($_SESSION[SESSION_BASE]['mail']))?$_SESSION[SESSION_BASE]['mail']:'';
		$fono		= (isset($_SESSION[SESSION_BASE]['fono']))?$_SESSION[SESSION_BASE]['fono']:'';
		$celular	= (isset($_SESSION[SESSION_BASE]['celular']))?$_SESSION[SESSION_BASE]['celular']:'';
		$comuna		= (isset($_SESSION[SESSION_BASE]['comuna']))?$_SESSION[SESSION_BASE]['comuna']:0;
		$provincia	= (isset($_SESSION[SESSION_BASE]['provincia']))?$_SESSION[SESSION_BASE]['provincia']:0;
		$region		= (isset($_SESSION[SESSION_BASE]['region']))?$_SESSION[SESSION_BASE]['region']:0;
		$primer		= (isset($_SESSION[SESSION_BASE]['primer_login']))?$_SESSION[SESSION_BASE]['primer_login']:0;

		$this->smarty->assign("id_usuario",$id_usuario );
        $this->smarty->assign("nombre", $nombre);
        $this->smarty->assign("rut", $rut);
        $this->smarty->assign("mail", $mail);
        $this->smarty->assign("fono", $fono);
        $this->smarty->assign("celular", $celular);
        $this->smarty->assign("comuna", $comuna);
        $this->smarty->assign("provincia", $provincia);
        $this->smarty->assign("region", $region);
        $this->smarty->assign("primer_login", $primer);
        $this->smarty->assign("hidden", "hidden");

        $this->_addJavascript(STATIC_FILES . 'js/templates/login/actualizar_password.js');
        $this->_display('login/actualizar.tpl');
    }

	/**
	* Descripción	: Guardar Password Actualizada
	* @author		: Víctor Retamal <victor.retamal@cosof.cl>
	*/
    public function ajax_guardar_nuevo_password(){
        header('Content-type: application/json');

		$correcto	= false;
		$validar	= $this->load->lib("Helpers/Validar/ActualizarPassword", true, "Validar_ActualizarPassword", $this->_request->getParams());

        if ($validar->isValid()) {
            $password		= Seguridad::generar_sha512($this->_request->getParam("password"));
            $ultimo_login	= date('Y-m-d H:i:s');
            $datos			= array($password, $ultimo_login, $_SESSION[SESSION_BASE]['id']);

            $upd			= $this->_DAOUsuario->setPassword($datos);
            if($upd) {
                $_SESSION[SESSION_BASE]['primer_login']	= FALSE;
				$correcto                               = true;
            }
        }

        $salida = array('error' => $validar->getErrores(), 'correcto' => $correcto);
        $json	= Zend_Json::encode($salida);
        echo $json;
    }

	/**
	* Descripción	: Logout del Sistema
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
    public function logoutUsuario(){
        if (isset($_COOKIE['datos_usuario_carpeta'])) {
            unset($_COOKIE['datos_usuario_carpeta']);
            setcookie('datos_usuario_carpeta', '', time() - 1);
        }
        unset($_SESSION[SESSION_BASE]);

        //header('Location:https://midastest.minsal.cl/');
        header('Location:'.BASE_URI);
    }

	/**
	* Descripción	: Muestra Formulario para Recuperar Password
	* @author		: Víctor Retamal <victor.retamal@cosof.cl>
	*/
    public function recuperar_password() {
        $this->_addJavascript(STATIC_FILES . 'js/templates/login/recuperar_password.js');
        $this->_display('login/recuperar_password.tpl', false);
    }

	/**
	* Descripción	: Recuperar Password por RUT, envía un Email con nueva Password
	* @author		: Víctor Retamal <victor.retamal@cosof.cl>
	* @param string $rut RUT del Usuario
	*/
    public function recuperar_password_rut() {
        header('Content-type: application/json');

        $rut			= trim($this->_request->getParam("rut"));
        $correcto		= false;
        $error			= array();
        $destinatario	= '';

        if (trim($this->_request->getParam("rut")) != "") {
            $usuario	= $this->_DAOUsuario->getByRut($this->_request->getParam("rut"));

            if (!is_null($usuario)) {
                $this->load->lib('Email', false);
                $correcto		= true;
                $ultimo_login	= NULL;
                $cadena			= Seguridad::randomPass(6);
                $cadenahash		= Seguridad::generar_sha512($cadena);

                $this->_DAOUsuario->update(array('gl_password' => $cadenahash, 'fc_ultimo_login' => $ultimo_login), $usuario->id_usuario,'id_usuario');

                $this->smarty->assign('nombre', $usuario->gl_nombres . ' ' . $usuario->gl_apellidos);
                $this->smarty->assign('pass', $cadena);
                //$this->smarty->assign('url', BASE_URI . '/index.php/Usuario/modificar_password/' . $cadena);
                $this->smarty->assign('url', BASE_URI . '/index.php/');

                $remitente			= 'midas@minsal.cl';
                $nombre_remitente	= APP_NAME;
                $destinatario		= $usuario->gl_email;

                $asunto				= APP_NAME." - Recuperar Contraseña";
                $mensaje = "";
				if (ENVIROMENT != 'PROD') {
					$mensaje .= "<strong>MENSAJE DE PRUEBA</strong> </br></br>";
				}
				$mensaje .= $this->smarty->fetch("login/recuperar_password_rut.tpl");
                Email::sendEmail($destinatario, $remitente, $nombre_remitente, $asunto, $mensaje);
            } else {
                $correcto		= false;
                $error['rut']	= "";
            }
        }

        $salida	= array("rut" => $rut, "error" => $error, "correcto" => $correcto, "correo" => $destinatario);
        $json	= Zend_Json::encode($salida);

        echo $json;
    }

}