<?php

// parche para funciones de semaforo en windows
if ( !function_exists('sem_get') ) { 
    function sem_get($key,$sw) { return fopen(BASE_DIR . "/tmp/sem.".$key, 'w+'); } 
    function sem_acquire($sem_id) { return flock($sem_id, LOCK_EX); } 
    function sem_release($sem_id) { return flock($sem_id, LOCK_UN); } 
}

class Bootstrap
{
    public static function run(Request $_request)
    {
        $controller = $_request->getControlador();

        $pathController = APP_PATH . 'controllers' . DS . $controller . '.php';
        
        $method = $_request->getMetodo();
        $parameters = $_request->getParametros();
        if(is_file($pathController)){

            require_once $pathController;

            $controller = new $controller;

            if(is_callable(array($controller, $method))){
                $method = $_request->getMetodo();
            } else {
                //$method = 'index';
                if(defined(PATH_404) && is_file(PATH_404)){
                    require_once PATH_404;
                }else{
                    throw new Exception('<h2>'.APP_NAME.'</h2><h3>Error!!! Peticion no encontrada</h3>');
                }
            }

            if(!empty($parameters)){
                call_user_func_array(array($controller, $method), $parameters);
            } else {
                call_user_func(array($controller, $method));
            }
        } else {
            if(defined(PATH_404) && is_file(PATH_404)){
                require_once PATH_404;
            }else{
                throw new Exception('<h2>'.APP_NAME.'</h2><h3>Error!!! Peticion no encontrada</h3>');
            }
        }
    }
}
