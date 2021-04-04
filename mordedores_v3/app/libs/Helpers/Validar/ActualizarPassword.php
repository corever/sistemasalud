<?php

require_once (APP_PATH . 'models/DAOAccesoUsuario.php');
require_once (__DIR__ . '/../Validar.php');

Class Validar_ActualizarPassword extends Validar{
    
    /**
     * Si es correcto o no
     * @return boolean
     */
    public function isValid(){
        $this->_validarVacio("password");
        $this->_validarVacio("password_repetido");
		$this->_validarVacio("password_ant");
		$this->_validarPassword();
        return $this->getCorrecto();
    }
	
	 /**
     * Valida el password
     */
    protected function _validarPassword(){
        $DAOUsuario = New DAOAccesoUsuario();
        $id = $this->_parametros["id"];
        $usuario = $DAOUsuario->getById($id);
        if(!is_null($usuario)){
            //$this->_validarSegPassword();
			$this->_validarContraseniaActual();
            $this->_validarPassIgualRetype();

		} else {
			$this->_correcto = false;
			$this->error['password'] = "la contraseña ingresada no es valida ...";
		}
    }
	
	protected function _validarPassIgualRetype(){
            
        if($this->_parametros["password"] != $this->_parametros["password_repetido"]){
            $this->_correcto = false;
            $this->_error["password_repetido"] = "El password no es igual";
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
	
	protected function _validarContraseniaActual(){
		$DAOUsuario = New DAOAccesoUsuario();
		$password = Seguridad::generar_sha512($this->_parametros["password_ant"]);
		$id =  $this->_parametros["id"];
		$usuario = $DAOUsuario->getById($id);
		$rut = $usuario->gl_rut;
        $usuario_registrado	= $DAOUsuario->getLogin($rut, $password);
		if (!$usuario_registrado) {
			$this->_correcto = false;
            $this->_error["password_ant"] = "Debe ingresar su contraseña actual.";
			return false;
        }
        return true;
    }
}

