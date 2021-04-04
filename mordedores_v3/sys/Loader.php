<?php

class Loader{

	private $ext;
    public $loader;
	function __construct(){
		$this->ext = '';
	}


	public function model($_model,$_instance=true,$nameClass=null)
    {

        if(!preg_match('/\.php/i',$_model)){
            $this->ext = '.php';
        }
        $pathModel = APP_PATH . 'models' . DS . $_model . $this->ext;
        global $modelo;
        $modelo = $_model;
        if (is_readable($pathModel)) {
            require_once $pathModel;
            if($_instance){
                if($nameClass){
                    $_model = new $nameClass();
                }else{
                    $_model = new $_model();
                }

                return $_model;
                
            }
        } else {
            print_r($pathModel);
            throw new Exception('<br>Error al cargar el modelo.');
            Error::errorLog($e->getMessage(),Error::SYSTEM_ERROR);
        }
    }


    public function lib($_library,$_instance=true,$nameClass=null,$parameters=null)
    {

        if(!preg_match('/\.php/i',$_library)){
            $this->ext = '.php';
        }
        $pathLibrary = APP_PATH . 'libs' . DS . $_library . $this->ext;

        if (is_readable($pathLibrary)) {
            require_once $pathLibrary;
            if($_instance){
                if($nameClass){
                    $_library =  new $nameClass($parameters);
                }else{
                    $_library = new $_library($parameters);
                }

                return $_library;
            }

        } else {
            print_r($pathLibrary);
            throw new Exception('<br>Error al cargar libreria');
            Error::errorLog($e->getMessage(),Error::SYSTEM_ERROR);
        }
    }


    public function core($_library,$_instance=true,$nameClass=null)
    {

        if(!preg_match('/\.php/i',$_library)){
            $this->ext = '.php';
        }
        $pathLibrary = 'core' . DS . $_library . $this->ext;

        if (is_readable($pathLibrary)) {
            require_once $pathLibrary;
            if($_instance){
                if($nameClass){
                    $_library =  new $nameClass();
                }else{
                    $_library = new $_library();
                }

                return $_library;
            }

        } else {
            print_r($pathLibrary);
            throw new Exception('<br>Error al cargar libreria');
            Error::errorLog($e->getMessage(),Error::SYSTEM_ERROR);
        }
    }



    public function serializeToArray($_serialize){
        $arr = array();
        if(is_array($_serialize)){
            foreach($_serialize as $a){
                $arr[$a['name']] = $a['value'] ;
            }
        }else{
            parse_str($_serialize,$arr);/*
            $arr_tmp = explode("&",$_serialize);
            foreach($arr_tmp as $a){
                $a = explode('=',$a);
                $arr[$a[0]] = $a[1] ;
            }
            */
        }

        return $arr;
    }

    //Cambio David 08-10-18 / Agrego parametro $bo_src para agregar js googlemap desde controlador
    public function javascript($js,$bo_src = 0, $add_uniqid=0){
        
        if(strpos($js,".js") !== false || $bo_src == 1){
            $uniqid = ($add_uniqid) ? '?'.uniqid() : ''; 
			
            echo '<script src="'.$js.$uniqid.'" type="text/javascript"></script>';    
        }else{
            echo '<script type="text/javascript">'.$js.'</script>';
        }
        
    }
	
    public function css($css){
        
        if(strpos($css,".css") !== false){
            echo '<link href="'.$css.'" rel="stylesheet" type="text/css" />';    
        }else{
            echo '<style type="text/css">'.$css.'</style>';
        }
        
    }


}
