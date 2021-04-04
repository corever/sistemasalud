<?php

Class Validar {

    /**
     *
     * @var array 
     */
    protected $_error = array();

    /**
     * Si la validacion esta correcta
     * @var boolean 
     */
    protected $_correcto = true;

    /**
     * array
     * @var array 
     */
    protected $_parametros = array();

    /**
     * 
     * @param array $parametros
     */
    public function __construct($parametros) {
        foreach ($parametros as $key => $value) {
            if (!is_array($value)) {
                $this->_parametros[$key] = TRIM($value);
            } else {
                $this->_parametros[$key] = $value;
            }
            $this->_error[$key] = "";
        }
    }

    /**
     * 
     * @param string $input
     */
    protected function _validarFecha($input) {
        $fecha = DateTime::createFromFormat("d/m/Y", $this->_parametros[$input]);
        if (!($fecha instanceof DateTime)) {
            $this->_correcto = false;
            $this->_error[$input] = "La fecha no es correcta";
        }
    }

    /**
     * 
     * @param array $parametros
     * @param string $input
     */
    protected function _validarVacio($input) {
        if (empty($this->_parametros[$input])) {
            $this->_correcto = false;
            $this->_error[$input] = "Este campo no puede estar vacío";
            return false;
        }
        return true;
    }

    /**
     * Valida que la entrada solo contenga espacios y letras
     * @param string $input
     */
    protected function _validarSoloEspaciosYLetras($input) {
        if (!preg_match("/^[a-zA-Z äëïöüÄËÏÖÜÿŸáéíóúÁÉÍÓÚñÑàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛ]*$/", $this->_parametros[$input])) {
            $this->_correcto = false;
            $this->_error[$input] = "Debe usar solo espacios y letras en este campo";
            return false;
        }
        return true;
    }
    
    protected function _validarSoloEspaciosLetrasYNumeros($input) {
        if (!preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜÿŸáéíóúÁÉÍÓÚñÑàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛ .,]*$/", $this->_parametros[$input])) {
            $this->_correcto = false;
            $this->_error[$input] = "Debe usar solo espacios, letras y/o números en este campo";
            return false;
        }
        return true;
    }
        /**
     * Valida que la entrada solo contenga numeros, puntos o guiones
     * @param string $input
     */
    protected function _validarSoloNumeros($input) {
        $regexp="/^[0-9.-]*$/";
        if (!preg_match($regexp, $this->_parametros[$input])) {
            $this->_correcto = false;
            $this->_error[$input] = "Debe usar solo números, puntos o guiones en este espacio";
            return false;
        }
        return true;
    }
    /**
     * Valida que el email sea correcto
     * @param string $input_email
     */
    public function _validarEmail($input_email) {
        $validador = New Zend_Validate_EmailAddress();
        if (!$validador->isValid($this->_parametros[$input_email])) {
            $this->_correcto = false;
            $this->_error[$input_email] = "Debe ingresar un e-mail válido";
        }
    }

    /**
     * Valida Rut perteneciente a empresa
     * @param string $rut
     * @return boolean
     */
    protected function validarRutEmpresa($rut) {
        if ($this->validarRut($rut)) {
            $separado = explode("-", $rut);
            if (((int) $separado[0]) > 50000000) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Valida Rut perteneciente a persona
     * @param string $rut
     * @return boolean
     */
    protected function validarRutPersona($rut) {
        if ($this->validarRut($rut)) {
            $separado = explode("-", $rut);
            if (((int) $separado[0]) < 50000000) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 
     */
    public static function validarRut($rut) {
        $rut = preg_replace('/[^k0-9]/i', '', $rut);
        $dv = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut) - 1);
        $i = 2;
        $suma = 0;
        foreach (array_reverse(str_split($numero)) as $v) {
            if ($i == 8)
                $i = 2;

            $suma += $v * $i;
            ++$i;
        }

        $dvr = 11 - ($suma % 11);

        if ($dvr == 11)
            $dvr = 0;
        if ($dvr == 10)
            $dvr = 'K';

        if ($dvr == strtoupper($dv)){
            return true;
        }else {
            return false;
        }
    }

    /**
     * Valida que el rut sea correcto
     * @param string $rut
     * @param int $id_tipo si es persona (2) o entidad juridica (1)
     * @return boolean
     */
    protected function _validarRut($input_rut, $id_tipo = 1) {
        if ($id_tipo == 1) {
            $resultado = $this->validarRutEmpresa($this->_parametros[$input_rut]);
        } else {
            $resultado = $this->validarRutPersona($this->_parametros[$input_rut]);
        }

        if ($resultado)
            return true;
        else {
            $this->_correcto = false;
            $this->_error[$input_rut] = "El rut no es válido";
            return false;
        }
    }

    /**
     * 
     * @return boolean
     */
    public function getCorrecto() {
        return $this->_correcto;
    }

    /**
     * 
     * @return array
     */
    public function getErrores() {
        return $this->_error;
    }

}
