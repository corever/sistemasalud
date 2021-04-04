<?php

class View
{
    private $controller;
    private $data;
    private $script;

    public function __construct(Request $_request)
    {
        $this->controller = $_request->getControlador();
        $this->data = array();
    }


    /**
     * Renderiza el template pasado como parametros, junto a la vista pasada tambien como parametro
     * @param  string $template     Nombre (ruta) del template
     * @param  string $view         Nombre de la vista o seccion a renderizar dentro del template
     * @return void
     */
    public function render($template,$view=null)
    {
        // Obtenemos la ruta de la vista a cargar
        $rutaView = ROOT . 'views' . DS . $this->controller . DS . $view;

        // Comprobamos que exista, en caso contrario creamos una Exception
        if(is_readable($template)){
            if($this->data){
                extract($this->data);
            }
            require_once $template;
            echo $this->script;
        } else {
            if(is_readable(PATH_404)){
                require_once PATH_404;
            }else{
                throw new Exception('Error de vista');
            }
        }
    }


    /**
     * Almacenamiento de datos para la vista a renderizada
     * @param  string   $var   Nombre del dato
     * @param  any      $value Valor del dato (integer, string, array)
     * @return void
     */
    public function data($var,$value)
    {
        $this->data[$var] = $value;
    }


    /**
     * Obtener los datos enviados al template
     * @return array arreglo con datos enviados al template
     */
    public function getData()
    {
        return $this->data;
    }


    /**
     * Insertar un script (javascript u otro) a la vista
     * @param  string $script  ruta del script
     * @param  string $type    tipo de script(opcional)
     * @param  string $charset codificacion del script(opcional)
     * @return void
     */
    public function script($script,$type="text/javascript",$charset="utf-8"){
        $this->script = '<script scr="'.$script.'" type="'.$type.'" charset="'.$charset.'"></script>';
    }


}

