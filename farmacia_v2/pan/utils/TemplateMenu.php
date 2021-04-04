<?php
namespace Pan\Utils;

use Pan\Kore\App as App;

/**
 ******************************************************************************
 * Sistema           : Mis Fiscalizaciones
 *
 * Descripción       : Lib para generar contenido en template
 *
 * Plataforma        : PHP
 *
 * Creación          : 08/07/2019
 *
 * @name             TemplateMenu.php
 *
 * @version          1.0.0
 *
 * @author           <sebastian.carroza@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha		   Descripción
 * ----------------------------------------------------------------------------
 *<luis.estay@cosof.cl>     17/07/2019     Se mejora obtención de datos Usuario.
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

class TemplateMenu {

    /**
	* Descripción	: Obtener vista menú de usuario
	* @author		:
	* @param
	* @return      html
	*/
    public static function getBoxUsr(){

		$boCambio           = $_SESSION[\Constantes::SESSION_BASE]["bo_cambio_usuario"];
        $boCambioReal       = $_SESSION[\Constantes::SESSION_BASE]["bo_cambio_usuario_real"];
        $nombreUsuario      = $_SESSION[\Constantes::SESSION_BASE]["gl_nombres"];
        $cantRoles       = $_SESSION[\Constantes::SESSION_BASE]["nr_roles"];

        if (!$nombreUsuario OR !$cantRoles) {

            error_log("Sin datos de Usuario en sesión. Obteniendo...");

            $DAOUsuario         = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario();
            $DAORol          = new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol();
            $DAOUsuarioRol   = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioRol();

            $id_usuario         = $_SESSION[\Constantes::SESSION_BASE]["id"];
            $usuario            = $DAOUsuario->getById($id_usuario);
            $cantRoles       = $DAOUsuarioRol->countRoles($id_usuario);

            $nombreUsuario      = $usuario->gl_nombres . " " . $usuario->gl_apellidos;
        }

        \Pan\kore\View::set('usuario', $nombreUsuario);
        \Pan\kore\View::set('bo_cambio_usuario', $boCambio);
        \Pan\kore\View::set('bo_cambio_usuario_real', $boCambioReal);
        \Pan\kore\View::set('count', $cantRoles);

        $view = \Pan\kore\View::fetchIt('menu/boxUsuario', NULL, '_FuncionesGenerales/General');
        return $view;
    }

    /**
	* Descripción	: Obtener vista menú barra lateral
	* @author		:
	* @param
	* @return      html
	*/
    public static function getSideBar($boSuperior=0){

        $daoOpcion  = new \App\_FuncionesGenerales\General\Entity\DAOAccesoOpcion();
        //$daoURol    = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioRol();
        $idUsuario  = $_SESSION[\Constantes::SESSION_BASE]["id"];
        //$idModulo   = $_SESSION[\Constantes::SESSION_BASE]["idModuloSelecionado"];
        $getLoc     = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        //$arrURol    = $daoURol->obtRolUsuario($idUsuario,99,$idModulo);
        //Si 
        $getData    = (isset($_SESSION[\Constantes::SESSION_BASE]['arrMenu']) && !empty($_SESSION[\Constantes::SESSION_BASE]['arrMenu']))?$_SESSION[\Constantes::SESSION_BASE]['arrMenu']:$daoOpcion->getMenu($idUsuario);
        $setMenu    = array();
        
        /*if (empty($idModulo) && $_SERVER['PATH_INFO'] != '/Farmacia/Home/Dashboard/') {
            header('Location: ' . \pan\uri\Uri::getHost().'Farmacia/Home/Dashboard/');         
            die();
        }*/
        foreach($getData as $val){
            
            $bo_active = ($getLoc == \pan\Uri\Uri::getBaseUri().$val->gl_url) ? 1 : 0;
            /*
            if(is_null($val->id_opcion_padre) || $val->id_opcion_padre == 0){
                $setMenu[$val->id_opcion]              = (array)$val;
                $setMenu[$val->id_opcion]['bo_active'] = $bo_active;
            }else{
            */
            $arrPadre = array(  "gl_icono_padre"    => $val->gl_icono_padre,
                                "gl_nombre_opcion"  => $val->gl_opcion_padre,
                                "gl_url"            => $val->link_opcion_padre
                            );
            if(!isset($setMenu[$val->id_opcion_padre])){
                $setMenu[$val->id_opcion_padre]              = (array)$arrPadre;
                $setMenu[$val->id_opcion_padre]['bo_active'] = $bo_active;
            }            
            $setMenu[$val->id_opcion_padre]['subMenu'][$val->id_opcion]              = (array)$val;
            $setMenu[$val->id_opcion_padre]['subMenu'][$val->id_opcion]['bo_active'] = $bo_active;
            
            #Activa al menu padre.
            $flag = 0;
            if($bo_active == 1 && $flag == 0){
                $setMenu[$val->id_opcion_padre]['bo_active'] = $bo_active;
                $flag++;
            }
            //}
        }
        
        \Pan\kore\View::set('sideBar', $setMenu);

        if($boSuperior == 1){
            $view = \Pan\kore\View::fetchIt('menu/menuBarSuperior', NULL, '_FuncionesGenerales/General');
        }else{
            $view = \Pan\kore\View::fetchIt('menu/menuBar', NULL, '_FuncionesGenerales/General');
        }
        return $view;
    }

    /**
	* Descripción	: Obtener vista menú barra lateral
	* @author		:
	* @param
    * @return      html
    * To do, eliminar.
	*/
    public static function getSideBar_(){

        $menu   = $_SESSION[\Constantes::SESSION_BASE]["menu"];

        if (!$menu) {

            error_log("Sin datos de Menú en sesión. Obteniendo...");

            $daoOpcion          = new \App\_FuncionesGenerales\General\Entity\DAOAccesoOpcion();
            $idUsuario          = $_SESSION[\Constantes::SESSION_BASE]["id"];
            $opciones           = $daoOpcion->getOpcionesRaiz($idUsuario);
            $subOpciones        = $daoOpcion->getSubOpciones($idUsuario);
            $menu				= array("opciones" => $opciones, "subopciones" => $subOpciones);
        }

        \Pan\kore\View::set('opciones', $menu["opciones"]);
        \Pan\kore\View::set('subOpciones', $menu["subopciones"]);

        $view = \Pan\kore\View::fetchIt('menu/menuBar', NULL, '_FuncionesGenerales/General');
        return $view;
    }

    /**
	* Descripción	: Obtener vista barra superior idioma
	* @author		:
	* @param
    * @return      html
    * To do, eliminar.
	*/
    public static function getBarIdioma(){

        $daoIdioma          = new \App\_FuncionesGenerales\General\Entity\DAOAccesoIdioma();
        $arrIdioma          = $daoIdioma->getLista();

        foreach($arrIdioma as $item){
            if($item->id_idioma == $_SESSION[\Constantes::SESSION_BASE]['idIdiomaPreferencia']){
                $arrIdiomaSeleccionado = $item;
                break;
            }
        }
        
        \Pan\kore\View::set('arrIdioma',$arrIdioma);
        \Pan\kore\View::set('arrIdiomaSeleccionado',$arrIdiomaSeleccionado);
        $view = \Pan\kore\View::fetchIt('menu/menuIdioma', NULL, '_FuncionesGenerales/General');
        return $view;
    }
}
