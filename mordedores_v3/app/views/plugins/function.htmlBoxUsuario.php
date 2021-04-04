<?php

include_once(APP_PATH . "models/DAOAccesoUsuario.php");
include_once(APP_PATH . "models/DAOAccesoPerfil.php");
include_once(APP_PATH . "models/DAOAccesoUsuarioPerfil.php");

/**
 * @param array $params
 * @param Smarty $smarty
 * @return string html
 */
function smarty_function_htmlBoxUsuario($params, &$smarty) {
    
    $DAOUsuario         = New DAOAccesoUsuario();
    $DAOPerfil          = New DAOAccesoPerfil();
    $DAOUsuarioPerfil	= New DAOAccesoUsuarioPerfil();
    
    $id_usuario	= $_SESSION[SESSION_BASE]['id'];    
    $id_perfil	= $_SESSION[SESSION_BASE]['perfil'];    
    $usuario	= $DAOUsuario->getById($id_usuario);
    $perfil		= $DAOPerfil->getById($id_perfil);
    $perfiles	= $DAOUsuarioPerfil->getByUsuario($id_usuario);
    $count      = count((array)$perfiles);
    
    if(!is_null($usuario)){
        $smarty->assign("count", $count);
        $smarty->assign("rut", $usuario->gl_rut);
        $smarty->assign("id_usuario", $usuario->id_usuario);
        $smarty->assign("id_usuario_original", $_SESSION[SESSION_BASE]['id_usuario_original']);
        $smarty->assign("usuario", $usuario->gl_nombres . " " . $usuario->gl_apellidos);
        $smarty->assign("gl_nombre_perfil", $perfil->gl_nombre_perfil);
        $smarty->assign("id_perfil", $perfil->id_perfil);
        $smarty->assign("bo_cambio_usuario", $_SESSION[SESSION_BASE]['bo_cambio_usuario']);
        $smarty->assign("bo_cambio_usuario_real", $_SESSION[SESSION_BASE]['bo_cambio_usuario_real']);
        return $smarty->fetch("plugins/view/box_usuario.tpl");
    }

}