<?php

class Permisos {

    public static function validarPermisos($accion,$id_rol=9){
        
        $_DAOUsuarioRol = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioRol;
        $json           = $_DAOUsuarioRol->getJsonPermisos($_SESSION[\Constantes::SESSION_BASE]['id'], $id_rol, $accion);
        $jsonPermisos   = json_decode($json);
        $bo_accion      = (!empty($jsonPermisos) && isset($jsonPermisos[$accion]))?$jsonPermisos[$accion]:0;
        return $bo_accion;
	}

	/*	Valida la accion o vista con el ROL que lo solicita	*/
	public static function validarRol($rol_permitido){
		$roles		=	$_SESSION[\Constantes::SESSION_BASE]["arrRoles"];
		$permitido	=	FALSE;

		foreach ($roles as	$rol) {
			if(is_array($rol_permitido)){
				if(in_array($rol->mur_fk_rol,$rol_permitido) || $rol->mur_fk_rol == \App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_ADMINISTRADOR){
					$permitido	=	TRUE;
				}
			}else{
				if($rol_permitido == $rol->mur_fk_rol || $rol->mur_fk_rol == \App\_FuncionesGenerales\General\Entity\DAOAccesoRol::ROL_ADMINISTRADOR){
					$permitido	=	TRUE;
				}
			}
		}

		if(!$permitido){
			header('Location: ' . \pan\uri\Uri::getHost()	.	'/Home/Dashboard/');			
			die();
		}
	}
}