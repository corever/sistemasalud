<?php

class Request
{
    private $_controlador;
    private $_metodo;
    private $_parametros;

    public function __construct() {

        if(strpos($_SERVER['REQUEST_URI'], noti_PATH) !== false){
			$url				= explode(noti_PATH,$_SERVER['REQUEST_URI']);
			$url				= trim($url[count($url)-1],"/");
			$url				= explode("/",$url);

			$this->_controlador	= array_shift($url);
			$this->_metodo		= array_shift($url);
			$this->_parametros	= $url;
		}else{
			$url				= trim($_SERVER['REQUEST_URI'],"/");
			$url				= explode("/",$url);

			$url				= array_filter($url);
			$base				= array_shift($url);
			$this->_controlador	= null;
			$this->_metodo		= null;
		}

        if(!$this->_controlador){
            $this->_controlador = null;
        }

        if(!$this->_metodo){
            $this->_metodo = null;
        }

        if(!isset($this->_parametros)){
            $this->_parametros = null;
        }
    }

    public function getControlador()
    {
        return $this->_controlador;
    }

    public function getMetodo()
    {
        return $this->_metodo;
    }

    public function getParametros($parametro=null)
    { 
        return $this->_parametros;
    }

    public function setParametro($nombre, $valor){
        $this->_parametros[$nombre] = $valor;
    }
}
