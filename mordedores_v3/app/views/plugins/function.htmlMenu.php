<?php

include_once(APP_PATH . "models/DAOAccesoUsuario.php");
include_once(APP_PATH . "models/DAOAccesoUsuarioPerfil.php");
include_once(APP_PATH . "models/DAOAccesoPerfilOpcion.php");
include_once(APP_PATH . "models/DAOAccesoOpcion.php");

/**
 * @param array $params
 * @param Smarty $smarty
 * @return string html
 */
function smarty_function_htmlMenu($params, $smarty) {
	$DAOPerfilOpcion	= New DAOAccesoPerfilOpcion();

    $id_perfil          = intval($_SESSION[SESSION_BASE]['perfil']);
	$opciones			= $DAOPerfilOpcion->getOpcionesRaiz($id_perfil);
	$subOpciones		= $DAOPerfilOpcion->getSubOpciones($id_perfil);

	$smarty->assign("id_perfil", $id_perfil);
	$smarty->assign("opciones", $opciones);
	$smarty->assign("subOpciones", $subOpciones);
	if($id_perfil > 0){
        return $smarty->fetch("plugins/view/menu.tpl");
    }
}