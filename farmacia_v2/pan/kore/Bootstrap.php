<?php
namespace Pan\Kore;

use Pan\Kore\Request as Request;
use Pan\Utils\ErrorPan as ErrorPan;

class Bootstrap
{

    public static function run()
    {
        $_request = new Request;
        $module = $_request->getModulo();
        
        if (!empty($module)) {
            if(!is_dir('app' . DIRECTORY_SEPARATOR . $module)){
                throw new \Exception('Module '. $module .' not found');
            }
        }

        $submodule = $_request->getSubModulo();
        
        if(empty($submodule) or !is_dir('app' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $submodule)){
            $msg_notFound = 'SubModule '.$_request->getSubModulo().' not found in Module ' . $_request->getModulo();
            
            throw new \Exception($msg_notFound);
        }

        $controller = $_request->getControlador();

        $pathController = 'app' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $submodule . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $controller . '.php';

        $method = $_request->getMetodo();
        $parameters = $_request->_getParameters();

        if(is_file($pathController)){

            require $pathController;

            $_class = '\\app\\' . $_request->getModulo() . '\\'. $_request->getSubModulo() . '\\' . $controller;
            /* $_class = '\\app\\' . $_request->getModulo() . '\\' . $controller;
            if (!empty($_request->getGrupo())) {
                $_class = '\\app\\' . $_request->getGrupo() . '\\'. $_request->getModulo() . '\\' . $controller;
            } */

            
            $controller = new $_class;

            if(is_callable(array($controller, $method))){
                $method = $_request->getMetodo();
            } else {
                ErrorPan::_showErrorAndDie('Action '.$method.' not found');
                /*if(is_file(App::getPath404())){
                    require_once App::getPath404();
                }else{
                    errorPan::_showErrorAndDie('Action '.$method.' not found');

                }*/
            }

            if(!empty($parameters)){
                call_user_func_array(array($controller, $method), $parameters);
            } else {
                call_user_func(array($controller, $method));
            }
        } else {
            ErrorPan::_showErrorAndDie('Controller '.$controller.' not found in module ' . $_request->getModulo());
            /*if(is_file(App::getPath404())){
                require_once App::getPath404();
            }else{
                \pan\errorPan::_showErrorAndDie('Controller '.$controller.' not found');
            }*/
        }
    }
}


