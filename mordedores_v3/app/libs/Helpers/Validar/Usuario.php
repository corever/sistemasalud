<?php

require_once (APP_PATH . 'models/DAOUsuario.php');
require_once (__DIR__ . '/../Validar.php');

/**
 * Validar formulario de ingreso de usuario
 */
Class Validar_Usuario extends Validar{
    
    /**
     * Si es correcto o no
     * @return boolean
     */
    public function isValid(){
        $this->_validarVacio("nombre");
        $this->_validarVacio("apellido");          
        $this->_validarVacio("rut");
        $this->_validarVacio("perfil");
        $this->_validarVacio("celular");
        $this->_validarVacio("telefono");
        $this->_validarVacio("email");
        $this->_validarVacio("direccion");
        $this->_validarVacio("referencia");
        $this->_validarVacio("comuna");
        $this->_validarVacio("nom_org");
        
        $this->_validarSoloNumeros("rut");
        $this->_validarSoloNumeros("celular");
        $this->_validarSoloNumeros("telefono");   
        $this->_validarSoloNumeros("comuna");
        $this->_validarSoloNumeros("nom_org");
        
        $this->_validarSoloEspaciosYLetras("nombre");
        $this->_validarSoloEspaciosYLetras("apellido");
        
        $this->_validarSoloEspaciosLetrasYNumeros("direccion");
        $this->_validarSoloEspaciosLetrasYNumeros("referencia");

        
        $this->_validarPassword();
        
        $this->_validarEmail("email");
        
        $this->_validarRut("rut", 2);
        
        //$this->_validarVacio("region");
        
        $this->_verSiYaExiste();
        
        return $this->getCorrecto();
    }
    
    /**
     * Valida el password
     */
    protected function _validarPassword(){
        $DAOUsuario = New DAOUsuario();
        $id = $this->_parametros["id"];
        $usuario = $DAOUsuario->getById($id);
        if(is_null($usuario)){
            $this->_validarSegPassword();
            $this->_validarVacio("password");
            $this->_validarVacio("retype");
            $this->_validarPassIgualRetype();

        }
    }
    
    protected function _validarPassIgualRetype(){
            
        if($this->_parametros["password"] != $this->_parametros["retype"]){
            $this->_correcto = false;
            $this->_error["retype"] = "El password no es igual";
        }
    }
    protected function _validarSegPassword(){
        $regexp="/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/";
        if (!preg_match($regexp, $this->_parametros["password"])) {
            $this->_correcto = false;
            $this->_error["password"] = "La contraseña debe ser al menos de 8 caracteres, contener una minúscula, una mayúscula y un dígito";
            return false;
        }
        return true;
    }


    /**
     * Ve que no se repita el rut
     */
    protected function _verSiYaExiste(){
        $DAOUsuario = New DAOUsuario();
        
        $id = $this->_parametros["id"];
        $usuario = $DAOUsuario->getById($id);
        if(!is_null($usuario)){
            $not_in = array($id);
        } else {
            $not_in = array();
        }
        
        $existe = $DAOUsuario->getByMail($this->_parametros["email"], $not_in);
        if(!is_null($existe)){
            $this->_correcto = false;
            $this->_error["email"] = "El email ya pertenece a un usuario registrado";
            return false;
        } else {
            return true;
        }
    }
}

