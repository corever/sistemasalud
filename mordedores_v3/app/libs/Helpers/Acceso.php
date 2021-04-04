<?php

//require_once (APP_PATH . 'models/DAOPerfil.php');
require_once (APP_PATH . 'models/DAOAccesoUsuario.php');
require_once (APP_PATH . 'models/DAOAccesoOpcion.php');
require_once (APP_PATH . 'models/DAOAccesoPerfilOpcion.php');

Class Acceso{
    
    /**
     *
     * @var DAOAccesoUsuario 
     */
    protected $_DAOAccesoUsuario;
    protected $_DAOAccesoOpcion;
    protected $_DAOAccesoPerfilOpcion;
    
    /**
     * Establece el control para acceder a un recurso
     * @param string $nombre_tipo_usuario
     */
    static public function set($nombre_tipo_usuario){
        
        $acceso = New Acceso();
        
        //valida el logeo
        if($nombre_tipo_usuario == "ALL"){
            $acceso->validarLogeo();
        }
        
        if($nombre_tipo_usuario == "ADMINISTRADOR"){
            //$acceso->validarTipo(DAOPerfil::ADMINSTRADOR);
        }
    }
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_DAOAccesoUsuario        = New DAOAccesoUsuario();
        $this->_DAOAccesoOpcion         = New DAOAccesoOpcion();
        $this->_DAOAccesoPerfilOpcion   = New DAOAccesoPerfilOpcion();
    }
    
    /**
     * 
     * @param type $id_usuario_tipo
     */
    public function validarTipo($id_usuario_tipo){
       $usuario = $this->_getUsuario();
       if(!is_null($usuario)){
           if($usuario->id_perfil != $id_usuario_tipo){
               $this->_banear();
           }
       } else {
           $this->_banear();
       }
    }
    
    /**
     * 
     */
    public function validarLogeo(){
        $usuario = $this->_getUsuario();
        if(is_null($usuario)){
            $this->_banear();
        }
    }
    
    /**
     * Expulsar usuario
     */
    protected function _banear(){
        session_destroy();
        header("location: " .HOST. "index.php/Login/");
        die();
    }
    
    /**
     * 
     * @return array
     */
    protected function _getUsuario(){
        $id_user = $_SESSION[SESSION_BASE]['id'];
        //echo $id_user;
        return $this->_DAOAccesoUsuario->getById($id_user);
    }
    
    public static function redireccionUnlogged($smarty) {
        //COMPRUEBA QUE EL USUARIO ESTA AUTENTICADO
        if (!isset($_SESSION[SESSION_BASE]['autenticado'])) {
            $_SESSION[SESSION_BASE]["autenticado"] = FALSE;
        }
        if (!$_SESSION[SESSION_BASE]['autenticado']) {
            //si no exihttp://localhost/prevencion/index.php/Login/actualizarste, va a la página de autenticacion
            $smarty->assign("texto_error", "Debes iniciar sesión para ver esta página");
            $smarty->display('login/login.tpl');        //salimos de este script
            exit();
        }else{
            //VALIDA QUE PERFIL NO INGRESE A URL NO PERMITIDO Y SI ES ASÍ = LO REDIRIGE A GRILLA
            $url                = $_SERVER['PATH_INFO'];
            $gl_url             = substr($url, 0, -1);
            $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
            $DAOPerfilOpcion    = New DAOAccesoPerfilOpcion();
            $DAOOpcion          = New DAOAccesoOpcion();
            $url_permitido      = $DAOPerfilOpcion->getByPerfilAndURL($id_perfil,$gl_url);
            $url_existe         = $DAOOpcion->getByURL($gl_url);
            
            if(!empty($url_existe)){ //SI URL ESTÁ EN TABLA mor_acceso_opcion
                if(is_null($url_permitido)){ //SI NO ESTÁ PERMITIDO REDIRIGE A GRILLA
                    header("location: " .HOST . BASE_URI. "/Paciente/index");
                    die();
                }
            }
        }
    }
}

