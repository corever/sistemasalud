<?php

require_once(APP_PATH . "libs/Smarty/Smarty.class.php");

/**
 * Grilla
 */
Class View_Grid{
    
    /**
     *
     * @var Smarty 
     */
    protected $_view;
    
    /**
     *
     * @var string 
     */
    protected $_nombre_tabla;
    
        /**
     * Querybuilder
     * @var querybuilder
     */
    protected $_queryBuilder;

    /**
     * Modelo
     * @var type
     */
    protected $_model;

    /**
     * Configuracion de columna
     * @var array
     */
    protected $_columns;

    /**
     * Ruta a helpers
     * @var array
     */
    protected $_helpers;

    /**
     * Agrega vistas
     * @var array
     */
    protected $_base_views;
    
    /**
     * Constructor
     */
    public function __construct($nombre_tabla) {
        $this->_nombre_tabla = $nombre_tabla;
        $this->_view = New Smarty();
        $this->_view->template_dir = __DIR__ . "/Grid/View";
        $this->_view->compile_dir  = APP_PATH . "views/templates_c";
        $this->_view->cache_dir    = APP_PATH . "views/cache";
        $this->_view->config_dir   = APP_PATH . "views/configs";
        $this->_view->plugins_dir  = array(__DIR__ . "/Grid/Plugins");
        $this->_view->assign('base_url', BASE_URI);
    }
    
    public function limpiarSesion($tabla){
        $sesion = New Zend_Session_Namespace("tablas");
        $tabla = $sesion->tablas;
        unset($tabla[$tabla]);
        $sesion->tablas = $tabla;
    }
    
    /**
     * Setea la consulta
     * @param type $query
     */
    public function setQuery($query, $params = array(), $fixed = array()){
        $this->_queryBuilder = array("method" => $query,
                                     "params" => $params,
                                     "fixed"  => $fixed);
    }
    
    /**
     * Setea el modelo
     * @param string $model
     */
    public function setModel($model){
        $this->_model = $model;
    }
    
     /**
     *
     * @param array $columns array(
     *                              array("column_name" => "",
     *                                    "column_table" => "",
     *                                    "width" => "")
     *                              )
     */
    public function setColumns($columns){
        $this->_columns = $columns;
    }

    /**
     * Devuelve el HTML de la grilla
     */
    public function getGrid(){
        $html = "";
        
        $columns = "";
        foreach($this->_columns as $key => $value){
            $columns .= "{";
            if(isset($value['sortable']) and $value['sortable']["active"]){
                $columns .= "\"orderable\": true,";
            } else {
                $columns .= "\"orderable\": false, ";
            }
            
            
            if(isset($value['column_align'])){
                switch ($value['column_align']) {
                    case "right":
                        $columns .= " className: \"text-right\",";
                        break;
                    case "center":
                        $columns .= " className: \"text-center\",";
                        break;
                    default:
                        $columns .= " className: \"text-left\",";
                        break;
                }
                
            }
            
            $columns .= "},";
        }
        $columns .= "";

        $this->_view->assign("title", $this->_nombre_tabla);
        $this->_view->assign("columns", $columns);
        $this->_view->assign("params", $this->_getParams());
        

        if(Zend_Registry::isRegistered("js")){
           $js = Zend_Registry::get("js");
        } else {
           $js = array();
        }
        
        $js[] = "<script>" . $this->_view->fetch("grid-js.tpl") . "</script>";
        
        Zend_Registry::set("js", $js);
        
        $this->_view->assign("columns", $this->_columns);
        $html .= $this->_view->fetch("grid.tpl");

        $data = array("title" => $this->_title,
                      "columns" => $this->_columns,
                      "helpers" => $this->_helpers,
                      "views" => $this->_base_views,
                      "model" => $this->_model,
                      "query" => $this->_queryBuilder,
                     );
        $sesion = New Zend_Session_Namespace("tablas");
        $tabla = $sesion->tablas;
        $tabla[$this->_nombre_tabla] = $data;
        $sesion->tablas = $tabla;
        return $html;
    }

    /**
     * Setea los helpers
     * @param type $ruta
     * @param type $namespace
     */
    public function addHelperPath($ruta, $namespace){
        $this->_helpers[] = array("ruta" => $ruta,
                                  "namespace" => $namespace);
    }

    /**
     * Agrega una vista base
     * @param type $ruta
     */
    public function addViewBasePath($ruta){
        $this->_base_views[] = $ruta;
    }

    /**
     * @return string
     */
    protected function _getParams(){
        $params = "";
        foreach($this->_queryBuilder['params'] as $key => $value){
            $params .= "d." . $value . " = $('#" . $value . "').val();\n";
        }
        /*foreach($this->_queryBuilder['fixed'] as $key => $value){
            $params .= "d." . $key . " = ".$value.";\n";
        }*/
        return $params;
    }


}

