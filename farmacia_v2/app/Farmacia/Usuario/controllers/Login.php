<?php

namespace App\Farmacia\Usuario;


/**
 ******************************************************************************
 * Sistema           : HOPE
 *
 * Descripción       : Controlador Login
 *
 * Plataforma        : PHP
 *
 * Creación          : 08/07/2019
 *
 * @name             Login.php
 *
 * @version          1.0.0
 *
 * @author			<victor.retamal@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha			Descripción
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

class Login extends \pan\Kore\Controller{

	//Inicializando Variables//
	protected $_DAOUsuario;
	protected $_DAOUsuarioRol;
	protected $_DAOAuditoriaLogin;
	//protected $_DAOPerfilOpcion;
	protected $_DAOPerfil;
	protected $_DAOOpcion;
	//protected $_ReCaptcha;

	public function __construct(){
		parent::__construct();
        
		$this->_DAOUsuario       	= new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario();
		$this->_DAOUsuarioRol 	    = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioRol();
		//$this->_DAOPerfilOpcion    	= new \App\Home\Entity\DAOPerfilOpcion();
		$this->_DAORol       	    = new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol();
		$this->_DAOAuditoriaLogin   = new \App\_FuncionesGenerales\General\Entity\DAOAuditoriaLogin();
        //$this->_ReCaptcha        	= new \ReCaptcha("6Lf1oDoUAAAAALAEk-scMFk0eem4sdE7rG7BbLA3");
        $this->_DAOTraductor        = new \App\_FuncionesGenerales\General\Entity\DAOTraductor();
        $this->_DAOOpcion           = new \App\_FuncionesGenerales\General\Entity\DAOAccesoOpcion();
	}

	public function index(){
		//error_log("Login ". $this->session->isValidate());
		
		//echo 'Location: '.\pan\uri\Uri::getBaseUri();
		//die("OK");
		/*
		if(isset($_SESSION[SESSION_BASE]) && !empty($_SESSION[SESSION_BASE])){
			header('Location: '.\pan\uri\Uri::getBaseUri().'index.php/Farmacia/Home/Dashboard/');
		}
		*/
		$this->view->addJS('login.js');
		$this->view->render('login');
	}

	/**
	* Descripción	: Procesa datos de usuario y redirige según corresponda.
	* @author		: <sebastian.carroza@cosof.cl>
	* @param		string $rut: rut de usuario
	* @param		string $password: contraseña de usuario
	* @param		string $captcha: input captcha
	* @return      	JSON
	*/
	public function procesar() {

		$params			= $this->request->getParametros();
		$rut			= trim($params['rut']);
        $password_v2    = \Seguridad::generar_sha512(trim($params['password']));
        $password		= \Seguridad::generar_sha1(trim($params['password']));
        //sha1 pass 123 = 40BD001563085FC35165329EA1FF5C5ECBDBBEEF
        //password 123  = 450de37b8bcfeb6f48ff272a1ec640abb93510cffc74e622a6fcc8be0057b9ec840ce53bef20d7456653c1a93e1cbc8fdfcda9bc8832bc11da6d7a3915810f58
		$recaptcha      = (isset($params['captcha']))?$params['captcha']:"";
		$primer_login	= FALSE;
		$error          = FALSE;
		$mensaje_error  = '';
        $url			= '';
        
		//$response       = $this->_ReCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$recaptcha);

		// if($response->errorCodes === "missing-input"){
		// 	$error = true;
		// 	$mensaje_error  = "Por favor, debe marcar casilla de ReCaptcha.";
		// }

		//Funcion Regularizar PASS a SHA512 */
		//$regularizar	= $this->_DAOUsuario->regularizarPass();

		if(!$error){

            $error          = TRUE;
            //Primero revisa con la password v2 sha512 y si no la tiene revisa con la otra
			$usuario        = $this->_DAOUsuario->getLoginV2($rut, $password_v2);
            
            if(empty($usuario)){
                $usuario		= $this->_DAOUsuario->getLogin($rut, $password);
            }
			//$primer_login	= (empty($usuario->ultimo_ingreso)) ? TRUE : FALSE;

			if ($usuario) {

				if($usuario->mu_estado_sistema == 1){
                    //$registro           = $this->_DAOAuditoriaLogin->registroLogin($usuario->id_usuario, $rut, 'Login');
                    
                    //Si password v2 no está actualizada -> se actualiza
                    if(empty($usuario->gl_password_v2)){
                        $this->_DAOUsuario->setPass($usuario->mu_id,\Seguridad::generar_sha512(trim($params['password'])));
                    }
                    
                    $arrMenu        = $this->_DAOOpcion->getMenu($usuario->mu_id);
                    $arrRoles       = $this->_DAOUsuarioRol->obtRolesUsuario($usuario->mu_id);
                    $bo_nacional    = 0;
                    $bo_regional    = 0;
                    
                    if($arrRoles){
                        foreach($arrRoles as $rol){
                            if(isset($rol->bo_nacional) && $rol->bo_regional == 1){
                                $bo_nacional = 1;
                            }
                            if(isset($rol->bo_regional) && $rol->bo_regional == 1){
                                $bo_regional = 1;
                            }
                        }
                    }

                    $_SESSION[\Constantes::SESSION_BASE]['id']                      = $usuario->mu_id;
                    $_SESSION[\Constantes::SESSION_BASE]['id_usuario']              = $usuario->mu_id;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_token']                = $usuario->gl_token;
                    $_SESSION[\Constantes::SESSION_BASE]['id_region']               = $usuario->mu_dir_region;
                    $_SESSION[\Constantes::SESSION_BASE]['id_comuna']               = $usuario->mu_dir_comuna;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_region']               = $usuario->region_nombre;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_region_corto']         = $usuario->region_nombre_corto;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_comuna']               = $usuario->comuna_nombre;
                    $_SESSION[\Constantes::SESSION_BASE]['id_usuario_original']     = 0;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_token_original']       = 0;
                    $_SESSION[\Constantes::SESSION_BASE]['arrRoles']                = $arrRoles;
                    $_SESSION[\Constantes::SESSION_BASE]['bo_nacional']             = $bo_nacional;
                    $_SESSION[\Constantes::SESSION_BASE]['bo_regional']             = $bo_regional;
                    $_SESSION[\Constantes::SESSION_BASE]['nr_roles']                = count($arrRoles);
                    $_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario']       = $usuario->bo_cambio_usuario;
                    $_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario_real']  = 0;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_nombres']              = $usuario->mu_nombre;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_apellidos']            = $usuario->mu_apellido_paterno . " " . $usuario->mu_apellido_materno;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_nombre_completo']      = $usuario->gl_nombres . " " . $usuario->mu_apellido_paterno . " " . $usuario->mu_apellido_materno;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_rut']                  = $usuario->mu_rut;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_rut_midas']            = $usuario->mu_rut_midas;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_mail']                 = $usuario->mu_correo;
                    $_SESSION[\Constantes::SESSION_BASE]['nr_telefono']             = $usuario->mu_telefono;
                    $_SESSION[\Constantes::SESSION_BASE]['nr_fono']                 = $usuario->mu_fono;
                    $_SESSION[\Constantes::SESSION_BASE]['gl_direccion']            = $usuario->mu_direccion;
                    $_SESSION[\Constantes::SESSION_BASE]['fc_nacimiento']           = \Fechas::formatearHtml($usuario->mu_fecha_nacimiento);
                    $_SESSION[\Constantes::SESSION_BASE]['gl_genero']               = $usuario->mu_genero;
                    $_SESSION[\Constantes::SESSION_BASE]['id_contrato_trabajo']     = $usuario->mu_contrato_trabajo;
                    $_SESSION[\Constantes::SESSION_BASE]['url_avatar']              = $usuario->url_avatar;
                    $_SESSION[\Constantes::SESSION_BASE]['primer_login']            = $primer_login;
                    $_SESSION[\Constantes::SESSION_BASE]['autenticado']             = TRUE;
                    $_SESSION[\Constantes::SESSION_BASE]['arrMenu']                 = $arrMenu;

                    $url	    = 'Farmacia/Home/Dashboard/';                    
					//$upd      = $this->_DAOUsuario->setUltimoLogin($usuario->id_usuario);
					$error	    = FALSE;

				}else{
					$registro	= $this->_DAOAuditoriaLogin->registroLogin(0, $rut, 'Login - Inhabilitado');
					$mensaje_error	= "Usuario ingresado se encuentra Inhabilitado.";
				}
			}else{
				//$registro	= $this->_DAOAuditoriaLogin->registroLogin(0, $rut, 'Login - datos incorrecto');
				$mensaje_error	= "Usuario ingresado no es válido.";
			}
		}

		$json	= array('error' => $error, 'texto_error' => $mensaje_error, 'redirect' => $url );

		echo json_encode($json, JSON_UNESCAPED_UNICODE);
	}

    /**
    * Descripción	: Logout del Sistema
    * @author		: David Guzmán <david.guzman@cosof.cl>
    */
    public function logoutUsuario(){

        $this->session->sessionKill();
		//die("Ok");
        header("Location:".\pan\uri\Uri::getBaseUri());
		
		
    }

    /**
    * Descripción	: Actualizar Password de Usuario
    * @author		: David Guzmán <david.guzman@cosof.cl>
    */
    public function actualizar(){

        $this->view->set('contenido', $this->view->fetchIt('actualizar'));
        $this->view->render();

        // $id_usuario	= (isset($_SESSION[SESSION_BASE]['id']))?$_SESSION[SESSION_BASE]['id']:0;
        // $nombre		= (isset($_SESSION[SESSION_BASE]['nombre']))?$_SESSION[SESSION_BASE]['nombre']:'';
        // $rut		= (isset($_SESSION[SESSION_BASE]['rut']))?$_SESSION[SESSION_BASE]['rut']:'';
        // $mail		= (isset($_SESSION[SESSION_BASE]['mail']))?$_SESSION[SESSION_BASE]['mail']:'';
        // $fono		= (isset($_SESSION[SESSION_BASE]['fono']))?$_SESSION[SESSION_BASE]['fono']:'';
        // $celular	= (isset($_SESSION[SESSION_BASE]['celular']))?$_SESSION[SESSION_BASE]['celular']:'';
        // $comuna		= (isset($_SESSION[SESSION_BASE]['comuna']))?$_SESSION[SESSION_BASE]['comuna']:0;
        // $provincia	= (isset($_SESSION[SESSION_BASE]['provincia']))?$_SESSION[SESSION_BASE]['provincia']:0;
        // $region		= (isset($_SESSION[SESSION_BASE]['region']))?$_SESSION[SESSION_BASE]['region']:0;
        // $primer		= (isset($_SESSION[SESSION_BASE]['primer_login']))?$_SESSION[SESSION_BASE]['primer_login']:0;
        //
        // $this->view->set("id_usuario",$id_usuario );
        // $this->view->set("nombre", $nombre);
        // $this->view->set("rut", $rut);
        // $this->view->set("mail", $mail);
        // $this->view->set("fono", $fono);
        // $this->view->set("celular", $celular);
        // $this->view->set("comuna", $comuna);
        // $this->view->set("provincia", $provincia);
        // $this->view->set("region", $region);
        // $this->view->set("primer_login", $primer);
        // $this->view->set("hidden", "hidden");
        //
        // $this->_addJavascript(STATIC_FILES . 'js/templates/login/actualizar_password.js');
        // $this->_display('login/actualizar.tpl');
    }

    /**
	* Descripción	: Validar RUT usuario MIDAS
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param string $rut RUT del Usuario MIDAS
	*/
    public function validaRutMidas($rut){
		ini_set('error_reporting', 0);
		ini_set('display_errors', 0);
        
		$usuario	= array();

		if( isset($rut) and trim($rut) != "" ){
			$usuario	= $this->_DAOUsuario->getUsuarioLoginSoloEmail(strtolower($rut));
		}

		if(!empty($usuario) AND $usuario->bo_activo == 1){
			echo json_encode(array('rut'=>$usuario->rut));
		}else{
			echo json_encode(array('rut'=>''));
		}

	}
    
    /**
	* Descripción	: Login Remoto desde MIDAS v1
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param string $rut RUT del Usuario MIDAS
	*/
	public function loginMidas($rut){
        $recordar		= 0;
		$primer_login	= FALSE;
		$usuario        = FALSE;
        
        if($rut != "" && !empty($rut)){
            $usuario        = $this->_DAOUsuario->getUsuarioLoginSoloEmail($rut);
            $primer_login	= (empty($usuario->ultimo_ingreso)) ? TRUE : FALSE;
        }
        
        if ($usuario) {
			if($usuario->activo == 1){
                $cantPerfiles		= $this->_DAOUsuarioPerfil->countPerfiles($usuario->id_usuario);
				$registro           = $this->_DAOAuditoriaLogin->registroLogin($usuario->id_usuario, $rut, 'LoginMIDAS');
                    
                $arrPerfiles        = $this->_DAOUsuarioPerfil->obtRolesUsuario($usuario->id_usuario);
                $arrSoloPerfiles    = $this->_DAOUsuarioPerfil->obtSoloColumnaUsuario($usuario->id_usuario,'id_perfil');
                $arrSoloRegiones    = $this->_DAOUsuarioPerfil->obtSoloColumnaUsuario($usuario->id_usuario,'id_region');
                $arrSoloOficinas    = $this->_DAOUsuarioPerfil->obtSoloColumnaUsuario($usuario->id_usuario,'id_oficina');
                $arrSoloAmbitos     = $this->_DAOUsuarioPerfil->obtSoloColumnaUsuario($usuario->id_usuario,'id_ambito');
                $perfiles           = $this->_DAOPerfil->getByIN(implode(",",$arrSoloPerfiles));
                $perfil             = $this->_DAOUsuarioPerfil->obtPerfilDefectoUsuario($usuario->id_usuario);
                
                $bo_nacional    = 0;
                $bo_jefe        = 0;

                if(!empty($arrPerfiles)){
                    foreach($arrPerfiles as $item_p){
                        if($item_p->bo_nacional == 1){
                            $bo_nacional    = 1;
                        }
                        if($item_p->bo_jefe == 1){
                            $bo_jefe        = 1;
                        }
                    }
                }
                    
				$url				= "/Login/actualizar/";
                    
                $_SESSION[\Constantes::SESSION_BASE]['id']                       = $usuario->id_usuario;
                $_SESSION[\Constantes::SESSION_BASE]['id_usuario']				= $usuario->id_usuario;
                $_SESSION[\Constantes::SESSION_BASE]['gl_token']                 = $usuario->gl_token;
                $_SESSION[\Constantes::SESSION_BASE]['id_usuario_original']      = 0;
                $_SESSION[\Constantes::SESSION_BASE]['gl_token_original']        = 0;
                $_SESSION[\Constantes::SESSION_BASE]['arrPerfiles']              = $arrPerfiles;
                $_SESSION[\Constantes::SESSION_BASE]['arrSoloPerfiles']          = $arrSoloPerfiles;
                $_SESSION[\Constantes::SESSION_BASE]['bo_cambio_perfil']         = $usuario->bo_cambio_perfil;
                $_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario']        = $usuario->bo_cambio_usuario;
                $_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario_real']   = 0;
                $_SESSION[\Constantes::SESSION_BASE]['id_usuario_perfil']        = $perfil->id;
                $_SESSION[\Constantes::SESSION_BASE]['id_perfil_defecto']        = $perfil->id_perfil;
                $_SESSION[\Constantes::SESSION_BASE]['id_region_defecto']        = $perfil->id_region;
                $_SESSION[\Constantes::SESSION_BASE]['id_oficina_defecto']       = $perfil->id_oficina;
                $_SESSION[\Constantes::SESSION_BASE]['id_ambito_defecto']        = $perfil->id_ambito;
                $_SESSION[\Constantes::SESSION_BASE]['gl_perfil_defecto']        = $perfil->gl_perfil;
                $_SESSION[\Constantes::SESSION_BASE]['gl_perfil']                = $perfiles->nombre;
                $_SESSION[\Constantes::SESSION_BASE]['arrSoloRegiones']          = $arrSoloRegiones;
                $_SESSION[\Constantes::SESSION_BASE]['arrSoloOficinas']          = $arrSoloOficinas;
                $_SESSION[\Constantes::SESSION_BASE]['arrSoloAmbitos']           = $arrSoloAmbitos;
                $_SESSION[\Constantes::SESSION_BASE]['nr_perfiles']              = $cantPerfiles;
                $_SESSION[\Constantes::SESSION_BASE]['bo_nacional']              = $bo_nacional;
                $_SESSION[\Constantes::SESSION_BASE]['bo_jefe']                  = $bo_jefe;
                $_SESSION[\Constantes::SESSION_BASE]['id_region']                = $usuario->id_region;
                $_SESSION[\Constantes::SESSION_BASE]['gl_nombres']               = $usuario->nombres;
                $_SESSION[\Constantes::SESSION_BASE]['gl_apellidos']             = $usuario->apellidos;
                $_SESSION[\Constantes::SESSION_BASE]['gl_nombre_completo']       = $usuario->nombres . " " . $usuario->apellidos;
                $_SESSION[\Constantes::SESSION_BASE]['gl_rut']                   = $usuario->rut;
                $_SESSION[\Constantes::SESSION_BASE]['gl_mail']                  = $usuario->email;
                $_SESSION[\Constantes::SESSION_BASE]['gl_direccion']             = $usuario->direccion;
                $_SESSION[\Constantes::SESSION_BASE]['nr_celular']               = $usuario->celular;
                $_SESSION[\Constantes::SESSION_BASE]['nr_telefono']              = $usuario->telefono;
                $_SESSION[\Constantes::SESSION_BASE]['img_firma_nombre']         = $usuario->img_firma_nombre;
                $_SESSION[\Constantes::SESSION_BASE]['img_firma_ruta']           = $usuario->img_firma_ruta_relativa;
                $_SESSION[\Constantes::SESSION_BASE]['bo_jefe']                  = $usuario->jefe;
                $_SESSION[\Constantes::SESSION_BASE]['bo_subrogante']            = $usuario->bo_subrogante;
                $_SESSION[\Constantes::SESSION_BASE]['bo_juridico_visado']       = $usuario->bo_juridico_visado;
                $_SESSION[\Constantes::SESSION_BASE]['bo_firmador']              = $usuario->bo_firmador;
                $_SESSION[\Constantes::SESSION_BASE]['bo_mensaje_jo']            = $usuario->bo_mensaje_jo;
                $_SESSION[\Constantes::SESSION_BASE]['primer_login']             = $primer_login;
                $_SESSION[\Constantes::SESSION_BASE]['autenticado']              = TRUE;
                //$_SESSION[SESSION_BASE]['menu']                   = $menu;
                    
                if (!$primer_login) {
                    $upd    = $this->_DAOUsuario->setUltimoLogin($usuario->id_usuario);
                    $url	= '/Home/Dashboard/';
                    $error	= FALSE;
                }

				/*
                if ($recordar == 1) {
					setcookie('datos_usuario_carpeta', $usuario->id_usuario, time() + 365 * 24 * 60 * 60);
				}
                */
                
                header('Location:'.\pan\uri\Uri::getBaseUri().$url);
                
			}else{
				$registro	= $this->_DAOAuditoriaLogin->registroLogin(0, $rut, 'LoginMIDAS - Inhabilitado');
				$this->view->set("hidden", "");
				$this->view->set("texto_error", "Usuario se encuentra Inhabilitado.");
                $this->view->render('login');
			}
        }else{
			$registro	= $this->_DAOAuditoriaLogin->registroLogin(0, $rut, 'LoginMIDAS - datos incorrecto');
            $this->view->set("hidden", "");
            $this->view->set("texto_error", "Los datos ingresados no son válidos.");
            $this->view->render('login');
        }
        
	}

	/**
	* Descripción	: Volver al Usuario Original
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param int $id_usuario_original ID del Usuario
	*/
	public function volverUsuario(){
		$correcto				= false;
		$mensaje				= '';
		$gl_token               = $_SESSION[\Constantes::SESSION_BASE]['gl_token'];
		$gl_token_original      = $_SESSION[\Constantes::SESSION_BASE]['gl_token_original'];
		
		$usuario_anterior   	= $this->_DAOUsuario->getByToken($gl_token);
		$usuario_original   	= $this->_DAOUsuario->getByToken($gl_token_original);
        $usuario                = $this->_DAOUsuario->getLoginSoloRut($usuario_original->gl_rut);
        $primer_login           = false;
        
		if ($usuario) {

            if($usuario->mu_estado_sistema == 1){
                //$registro           = $this->_DAOAuditoriaLogin->registroLogin($usuario->id_usuario, $rut, 'Login');
                
                //Si password v2 no está actualizada -> se actualiza
                //if(empty($usuario->gl_password_v2)){
                    //$this->_DAOUsuario->setPass($usuario->mu_id,\Seguridad::generar_sha512(trim($params['password'])));
                //}
                
                $arrRoles       = $this->_DAOUsuarioRol->obtRolesUsuario($usuario->mu_id);
                $arrMenu        = $this->_DAOOpcion->getMenu($usuario->mu_id);
                $bo_nacional    = 0;
                $bo_regional    = 0;
                
                if($arrRoles){
                    foreach($arrRoles as $rol){
                        if(isset($rol->bo_nacional) && $rol->bo_regional == 1){
                            $bo_nacional = 1;
                        }
                        if(isset($rol->bo_regional) && $rol->bo_regional == 1){
                            $bo_regional = 1;
                        }
                    }
                }
                
                $_SESSION[\Constantes::SESSION_BASE]['id']                      = $usuario->mu_id;
                $_SESSION[\Constantes::SESSION_BASE]['id_usuario']              = $usuario->mu_id;
                $_SESSION[\Constantes::SESSION_BASE]['gl_token']                = $usuario->gl_token;
                $_SESSION[\Constantes::SESSION_BASE]['id_region']               = $usuario->mu_dir_region;
                $_SESSION[\Constantes::SESSION_BASE]['id_comuna']               = $usuario->mu_dir_comuna;
                $_SESSION[\Constantes::SESSION_BASE]['gl_region']               = $usuario->region_nombre;
                $_SESSION[\Constantes::SESSION_BASE]['gl_region_corto']         = $usuario->region_nombre_corto;
                $_SESSION[\Constantes::SESSION_BASE]['gl_comuna']               = $usuario->comuna_nombre;
                $_SESSION[\Constantes::SESSION_BASE]['id_usuario_original']     = 0;
                $_SESSION[\Constantes::SESSION_BASE]['gl_token_original']       = '';
                $_SESSION[\Constantes::SESSION_BASE]['arrRoles']                = $arrRoles;
                $_SESSION[\Constantes::SESSION_BASE]['bo_nacional']             = $bo_nacional;
                $_SESSION[\Constantes::SESSION_BASE]['bo_regional']             = $bo_regional;
                $_SESSION[\Constantes::SESSION_BASE]['nr_roles']                = count($arrRoles);
                $_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario']       = $usuario->bo_cambio_usuario;
                $_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario_real']  = 0;
                $_SESSION[\Constantes::SESSION_BASE]['gl_nombres']              = $usuario->mu_nombre;
                $_SESSION[\Constantes::SESSION_BASE]['gl_apellidos']            = $usuario->mu_apellido_paterno . " " . $usuario->mu_apellido_materno;
                $_SESSION[\Constantes::SESSION_BASE]['gl_nombre_completo']      = $usuario->gl_nombres . " " . $usuario->mu_apellido_paterno . " " . $usuario->mu_apellido_materno;
                $_SESSION[\Constantes::SESSION_BASE]['gl_rut']                  = $usuario->mu_rut;
                $_SESSION[\Constantes::SESSION_BASE]['gl_rut_midas']            = $usuario->mu_rut_midas;
                $_SESSION[\Constantes::SESSION_BASE]['gl_mail']                 = $usuario->mu_correo;
                $_SESSION[\Constantes::SESSION_BASE]['nr_telefono']             = $usuario->mu_telefono;
                $_SESSION[\Constantes::SESSION_BASE]['nr_fono']                 = $usuario->mu_fono;
                $_SESSION[\Constantes::SESSION_BASE]['gl_direccion']            = $usuario->mu_direccion;
                $_SESSION[\Constantes::SESSION_BASE]['fc_nacimiento']           = \Fechas::formatearHtml($usuario->mu_fecha_nacimiento);
                $_SESSION[\Constantes::SESSION_BASE]['gl_genero']               = $usuario->mu_genero;
                $_SESSION[\Constantes::SESSION_BASE]['id_contrato_trabajo']     = $usuario->mu_contrato_trabajo;
                $_SESSION[\Constantes::SESSION_BASE]['url_avatar']              = $usuario->url_avatar;
                $_SESSION[\Constantes::SESSION_BASE]['primer_login']            = $primer_login;
                $_SESSION[\Constantes::SESSION_BASE]['autenticado']             = TRUE;
                $_SESSION[\Constantes::SESSION_BASE]['arrMenu']                 = $arrMenu;

                $url	    = 'Farmacia/Home/Dashboard/';                    
                //$upd      = $this->_DAOUsuario->setUltimoLogin($usuario->id_usuario);
                $correcto   = TRUE;
                header('Location:'.\pan\uri\Uri::getBaseUri().$url);

            }else{
                //$registro	= $this->_DAOAuditoriaLogin->registroLogin(0, $usuario_nuevo->gl_rut, 'Login - Inhabilitado');
                $mensaje_error	= "Usuario ingresado se encuentra Inhabilitado.";
            }
        }else{
			$mensaje	= 'Hubo un problema.</b><br>Favor intentar nuevamente o contactarse con Soporte.';
		}

		$json	= array("correcto" => $correcto, "mensaje" => $mensaje);
        
        echo json_encode($json);
	}
    
    /**
	* Descripción	: Validar Email usuario
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param string $gl_valida_email
	*/
    public function validarEmail($gl_valida_email="",$bo_solicitar_completar=0){
        
        $boValidado = false;
        
		if(trim($gl_valida_email) != ""){
            $arrUsuario = $this->_DAOUsuario->getByValidaEmail($gl_valida_email);
            
            if(!empty($arrUsuario)){
                
                if($arrUsuario->bo_valida_email == 0){
                    $boValidado = $this->_DAOUsuario->validarEmail($gl_valida_email);
                    
                    if($boValidado){
                        $glMensaje = "Se ha Validado su Email";
                        $glMensaje .= ($bo_solicitar_completar==1)?"<br>Se envió Solicitud para completar sus datos.<br>Será informado por Email cuando pueda ingresar.":"";
                    }else{
                        $glMensaje = "Ha ocurrido algo inesperado<br>Favor comunicarse con Mesa de ayuda.";
                    }
                    
                }else{
                    $glMensaje = "Ya se encuentra<br>Validado su Email";
                }
                
            }
            
        }
        
        $this->view->set("glMensaje",$glMensaje);
        $this->view->render('validarEmail');

	}
    
    /**
	* Descripción	: Validar Email usuario
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param string $gl_hash
	*/
    public function crearCuenta(){
        
        $gl_email   = $_POST['gl_email'];
        
        if($gl_email != ""){
            
            $arrUsuario = $this->_DAOUsuario->getUsuarioLoginSoloEmail($gl_email);
            
            if(!empty($arrUsuario)){
                $this->view->addJS('xModal.info("Estimado Usuario<br>Este Email está asociado a una cuenta existente.",function(){$("#gl_email").val("").focus();});');
                $this->view->set("boCrearCuenta",1);
                $this->view->render('crearCuenta');
            }else{
                
                $pass               = \Seguridad::generar_base() . "123"; //mb_substr($gl_email, 0, 4);
                $gl_password        = \Seguridad::generar_sha512($pass);
                $gl_token           = \Seguridad::generaTokenUsuario($gl_email);
                $gl_valida_email    = \Seguridad::generar_sha1($gl_email);
                
                $datosUsuario   = array(
                                    $gl_token,
                                    $gl_email,
                                    "",
                                    "",
                                    "",
                                    0,
                                    "0000-00-00",
                                    "",
                                    "",
                                    0,
                                    $gl_valida_email,
                                    $gl_password,
                                    0, //bo_activo
                                    0 //id_usuario creador - no tiene
                );
                
                $idUsuario = $this->_DAOUsuario->insertNuevo($datosUsuario);
                
                $this->_DAOUsuarioPerfil->insertar(array($idUsuario,18,0)); //Inserto perfil usuario externo
                
                //Envio de Email para confirmar creacion de usuario
                $arrInfo            = array(
                                        "gl_nombre"     => "",
                                        "gl_apellido"   => "",
                                        "gl_url"        => \pan\uri\Uri::getHost()."Farmacia/Usuario/Login/validarEmail/".$gl_valida_email."/1",
                                        "gl_hash"       => $gl_valida_email,
                                        "fecha"         => \Fechas::fechaHoyVista(),
                );
                $asunto             = "Confirmar Email - HOPE OPS WEB";
                $html_email         = $this->view->fetchIt('email/validar_creacion_usuario', $arrInfo, '_FuncionesGenerales');
                $respuestaEmail     = \Email::sendEmail($gl_email, $asunto, $html_email);
                
                if($respuestaEmail['correcto']){
                    $this->_DAOUsuario->marcarEmailEnviado($idUsuario);
                    
                    $this->view->set("glMensaje","Email Enviado!<br>Por favor, revisar para completar su registro.");
                    $this->view->render('validarEmail');
                }else{
                    $this->view->set("glMensaje","Algo inesperado ha ocurrido!<br>Por favor, re-intente mas tarde.");
                    $this->view->render('validarEmail');
                }
                
            }
            
        }else{
            
            $this->view->set("boCrearCuenta",1);
            
        }
        
        $this->view->render('crearCuenta');

	}
    
    /**
	* Descripción	: Encargado del seguimiento de apertura de correo electronico. (Cambiar nombre)
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function marcarVisto($gl_valida_email) {

		//Aqui se debe crear los metodos para guardar el evento, de cuando el email fue leido/abierto.

		$usuario = $this->_DAOUsuario->getByValidaEmail($gl_valida_email);
        
		if (!empty($usuario)) {

            if($usuario->bo_valida_email_visto != 1){
                $this->_DAOUsuario->marcarEmailVisto($usuario->id_usuario);
            }
            
            $graphic_http   = \pan\uri\Uri::getHost() . "pub/img/ops.jpg";
            $filesize       = filesize( "pub/img/ops.jpg" );
    
            header( 'Pragma: public' );
            header( 'Expires: 0' );
            header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
            header( 'Cache-Control: private', false );
            header( 'Content-Disposition: attachment; filename="ops.jpg"' );
            header( 'Content-Transfer-Encoding: binary' );
            header( 'Content-Length: ' . $filesize );
            readfile( $graphic_http );
            exit;

		}

    }

    /**
	* Descripción	: Cambio de Usuario
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function cambioUsuario(){
        $correcto           = false;
		$mensaje            = '';
        $params             = $this->request->getParametros();
        $primer_login	    = FALSE;
        $bo_url             = false;
        
		if(isset($params['gl_token'])){
            $usuario_nuevo  = $this->_DAOUsuario->getByToken($params['gl_token']);
		}else{
			$params         = $_REQUEST;
            $usuario_nuevo  = $this->_DAOUsuario->getByToken($params['gl_token']);
            $bo_url         = true;
		}

		$usuario_original   = $this->_DAOUsuario->getByToken($_SESSION[\Constantes::SESSION_BASE]['gl_token']);
        $usuario            = $this->_DAOUsuario->getLoginSoloRut($usuario_nuevo->gl_rut);
        
		if ($usuario) {

            if($usuario->mu_estado_sistema == 1){
                //$registro           = $this->_DAOAuditoriaLogin->registroLogin($usuario->id_usuario, $rut, 'Login');
                
                //Si password v2 no está actualizada -> se actualiza
                if(empty($usuario->gl_password_v2)){
                    $this->_DAOUsuario->setPass($usuario->mu_id,\Seguridad::generar_sha512(trim($params['password'])));
                }
                
                $arrRoles       = $this->_DAOUsuarioRol->obtRolesUsuario($usuario->mu_id);
                $arrMenu        = $this->_DAOOpcion->getMenu($usuario->mu_id);
                $bo_nacional    = 0;
                $bo_regional    = 0;
                
                if($arrRoles){
                    foreach($arrRoles as $rol){
                        if(isset($rol->bo_nacional) && $rol->bo_regional == 1){
                            $bo_nacional = 1;
                        }
                        if(isset($rol->bo_regional) && $rol->bo_regional == 1){
                            $bo_regional = 1;
                        }
                    }
                }
                
                $_SESSION[\Constantes::SESSION_BASE]['id']                      = $usuario->mu_id;
                $_SESSION[\Constantes::SESSION_BASE]['id_usuario']              = $usuario->mu_id;
                $_SESSION[\Constantes::SESSION_BASE]['gl_token']                = $usuario->gl_token;
                $_SESSION[\Constantes::SESSION_BASE]['id_region']               = $usuario->mu_dir_region;
                $_SESSION[\Constantes::SESSION_BASE]['id_comuna']               = $usuario->mu_dir_comuna;
                $_SESSION[\Constantes::SESSION_BASE]['gl_region']               = $usuario->region_nombre;
                $_SESSION[\Constantes::SESSION_BASE]['gl_region_corto']         = $usuario->region_nombre_corto;
                $_SESSION[\Constantes::SESSION_BASE]['gl_comuna']               = $usuario->comuna_nombre;
                $_SESSION[\Constantes::SESSION_BASE]['id_usuario_original']     = $usuario_original->id_usuario;
                $_SESSION[\Constantes::SESSION_BASE]['gl_token_original']       = $usuario_original->gl_token;
                $_SESSION[\Constantes::SESSION_BASE]['arrRoles']                = $arrRoles;
                $_SESSION[\Constantes::SESSION_BASE]['bo_nacional']             = $bo_nacional;
                $_SESSION[\Constantes::SESSION_BASE]['bo_regional']             = $bo_regional;
                $_SESSION[\Constantes::SESSION_BASE]['nr_roles']                = count($arrRoles);
                $_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario']       = $usuario->bo_cambio_usuario;
                $_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario_real']  = $usuario_original->bo_cambio_usuario;
                $_SESSION[\Constantes::SESSION_BASE]['gl_nombres']              = $usuario->mu_nombre;
                $_SESSION[\Constantes::SESSION_BASE]['gl_apellidos']            = $usuario->mu_apellido_paterno . " " . $usuario->mu_apellido_materno;
                $_SESSION[\Constantes::SESSION_BASE]['gl_nombre_completo']      = $usuario->gl_nombres . " " . $usuario->mu_apellido_paterno . " " . $usuario->mu_apellido_materno;
                $_SESSION[\Constantes::SESSION_BASE]['gl_rut']                  = $usuario->mu_rut;
                $_SESSION[\Constantes::SESSION_BASE]['gl_rut_midas']            = $usuario->mu_rut_midas;
                $_SESSION[\Constantes::SESSION_BASE]['gl_mail']                 = $usuario->mu_correo;
                $_SESSION[\Constantes::SESSION_BASE]['nr_telefono']             = $usuario->mu_telefono;
                $_SESSION[\Constantes::SESSION_BASE]['nr_fono']                 = $usuario->mu_fono;
                $_SESSION[\Constantes::SESSION_BASE]['gl_direccion']            = $usuario->mu_direccion;
                $_SESSION[\Constantes::SESSION_BASE]['fc_nacimiento']           = \Fechas::formatearHtml($usuario->mu_fecha_nacimiento);
                $_SESSION[\Constantes::SESSION_BASE]['gl_genero']               = $usuario->mu_genero;
                $_SESSION[\Constantes::SESSION_BASE]['id_contrato_trabajo']     = $usuario->mu_contrato_trabajo;
                $_SESSION[\Constantes::SESSION_BASE]['url_avatar']              = $usuario->url_avatar;
                $_SESSION[\Constantes::SESSION_BASE]['primer_login']            = $primer_login;
                $_SESSION[\Constantes::SESSION_BASE]['autenticado']             = TRUE;
                $_SESSION[\Constantes::SESSION_BASE]['arrMenu']                 = $arrMenu;

                $url	    = 'Farmacia/Home/Dashboard/';                    
                //$upd      = $this->_DAOUsuario->setUltimoLogin($usuario->id_usuario);
                $correcto   = TRUE;
                
                if($params['bo_url']){
                    header('Location:'.\pan\uri\Uri::getBaseUri().$url);
                    exit();
                }

            }else{
                //$registro	= $this->_DAOAuditoriaLogin->registroLogin(0, $usuario_nuevo->gl_rut, 'Login - Inhabilitado');
                $mensaje_error	= "Usuario ingresado se encuentra Inhabilitado.";
            }
        }else{
			$mensaje	= 'Hubo un problema.</b><br>Favor intentar nuevamente o contactarse con Soporte.';
		}
        
		$json	= array("correcto" => $correcto, "mensaje" => $mensaje);
        echo json_encode($json);
    }
    
    /**
	* Descripción	: Vista Cambio de Usuario
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function vistaCambioUsuario(){
        $id_usuario = $_SESSION[\Constantes::SESSION_BASE]['id'];
        $arrUsuario = $this->_DAOUsuario->getLista();
        $this->view->addJS('$("#gl_token").select2({minimumInputLength:3});');
        $this->view->set("boOcultarMenu",1);
        $this->view->set("arrUsuario",$arrUsuario);
		$this->view->render('cambioUsuario');
	}
    
    /**
	* Descripción	: Cambio de Rol
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	/*public function cambioRol(){
        $id_usuario = $_SESSION[\Constantes::SESSION_BASE]['id'];
        $arrRoles   = $this->_DAOUsuarioRol->obtRolesUsuario($id_usuario);
        $this->view->set("boOcultarMenu",1);
        $this->view->set("arrRoles",$arrRoles);
        $this->view->set('contenido', $this->view->fetchIt('cambioRol'));
		$this->view->render();
	}*/
    
    /**
	* Descripción	: Procesar Cambio de Rol
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	/*public function cambioRolConfirmado(){
        $id_rol     = $_REQUEST['id_rol_usuario'];
        $id_usuario = $_SESSION[\Constantes::SESSION_BASE]['id'];
        $arrRol     = $this->_DAOUsuarioRol->obtRolUsuario($id_usuario);

        $_SESSION[\Constantes::SESSION_BASE]['id_rol_usuario']      = $arrRol->mur_id;
        $_SESSION[\Constantes::SESSION_BASE]['id_rol']              = $arrRol->mur_fk_rol;
        $_SESSION[\Constantes::SESSION_BASE]['id_farmacia']         = $arrRol->fk_farmacia;
        $_SESSION[\Constantes::SESSION_BASE]['id_local']            = $arrRol->fk_local;
        $_SESSION[\Constantes::SESSION_BASE]['id_bodega']           = $arrRol->fk_bodega;
        $_SESSION[\Constantes::SESSION_BASE]['id_region']           = $arrRol->mur_fk_region;
        $_SESSION[\Constantes::SESSION_BASE]['id_territorio']       = $arrRol->mur_fk_territorio;
        $_SESSION[\Constantes::SESSION_BASE]['id_comuna']           = $arrRol->mur_fk_comuna;
        $_SESSION[\Constantes::SESSION_BASE]['id_localidad']        = $arrRol->mur_fk_localidad;
        $_SESSION[\Constantes::SESSION_BASE]['gl_rol']              = $arrRol->gl_rol;
        $_SESSION[\Constantes::SESSION_BASE]['gl_farmacia_rut']     = $arrRol->gl_farmacia_rut;
        $_SESSION[\Constantes::SESSION_BASE]['gl_farmacia_rs']      = $arrRol->gl_farmacia_razon_social;
        $_SESSION[\Constantes::SESSION_BASE]['nr_local']            = $arrRol->nr_local;
        $_SESSION[\Constantes::SESSION_BASE]['gl_local']            = $arrRol->gl_local;
        $_SESSION[\Constantes::SESSION_BASE]['gl_bodega']           = $arrRol->gl_bodega;
        $_SESSION[\Constantes::SESSION_BASE]['gl_region']           = $arrRol->gl_region;
        $_SESSION[\Constantes::SESSION_BASE]['gl_territorio']       = $arrRol->gl_territorio;
        $_SESSION[\Constantes::SESSION_BASE]['gl_comuna']           = $arrRol->gl_comuna;

        $this->view->set('contenido', $this->view->fetchIt('cambioRol'));
		$this->view->render();
	}*/

}
