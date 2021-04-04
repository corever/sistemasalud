<?php

namespace App\Usuario\Entity;

class DAOInformacionUsuario extends \pan\Kore\Entity
{

	function __construct()
	{
		parent::__construct();
	}

	public function getGrillaInformacionUsuario($params)
	{

		$query	= "	SELECT "
			. " " . TABLA_ACCESO_USUARIO . ".mu_rut_midas, "
			. " " . TABLA_ACCESO_USUARIO . ".mu_nombre, "
			. " " . TABLA_ACCESO_USUARIO . ".mu_apellido_paterno, "
			. " " . TABLA_ACCESO_USUARIO . ".mu_apellido_materno, "
			. " " . TABLA_ACCESO_USUARIO . ".mu_correo, "
			. " " . TABLA_ACCESO_USUARIO . ".mu_direccion, "
			. " " . TABLA_ACCESO_USUARIO . ".mu_telefono_codigo, "
			. " " . TABLA_ACCESO_USUARIO . ".mu_telefono, "
			. " " . TABLA_ACCESO_USUARIO . ".mu_estado_sistema, "
			. " CASE    "
			. " WHEN " . TABLA_ACCESO_USUARIO . ".mu_estado_sistema = 1 THEN 'Activo'   "
			. " ELSE 'Inactivo'   "
			. " END as estado_nombre , "


			. " " . TABLA_DIRECCION_REGION . ".region_id, "
			. " " . TABLA_DIRECCION_REGION . ".region_nombre, "
			. " " . TABLA_DIRECCION_REGION . ".nombre_region_corto, "
			. " " . TABLA_PROFESION . ".id_profesion, "
			. " " . TABLA_PROFESION . ".nombre_profesion, "
			. " " . TABLA_ACCESO_ROL . ".rol_id, "
			. " " . TABLA_ACCESO_ROL . ".rol_nombre "
			. " FROM " . TABLA_ACCESO_USUARIO . " "
			. " LEFT JOIN " . TABLA_DIRECCION_REGION . " ON " . TABLA_ACCESO_USUARIO . ".id_region_midas = " . TABLA_DIRECCION_REGION . ".region_id "
			. " LEFT JOIN " . TABLA_PROFESION_USUARIO . " ON " . TABLA_ACCESO_USUARIO . ".mu_id = " . TABLA_PROFESION_USUARIO . ".fk_usuario "
			. " LEFT JOIN " . TABLA_PROFESION . " ON " . TABLA_PROFESION_USUARIO . ".fk_profesion = " . TABLA_PROFESION . ".id_profesion "
			. " LEFT JOIN " . TABLA_ACCESO_USUARIO_ROL . " ON " . TABLA_ACCESO_USUARIO . ".mu_id = " . TABLA_ACCESO_USUARIO_ROL . ".mur_fk_usuario "
			. " LEFT JOIN " . TABLA_ACCESO_ROL . " ON " . TABLA_ACCESO_USUARIO_ROL . ".mur_fk_rol = " . TABLA_ACCESO_ROL . ".rol_id "
			. " WHERE 1 = 1 ";
		// . " WHERE       usuario.mu_rut_midas	= ? "
		// . " AND usuario.mu_nombre  LIKE '%gilda%' "

		if (!empty($params['gl_rut_usuario'])) {
			$query	.=  " AND " . TABLA_ACCESO_USUARIO . ".mu_rut_midas = '" . $params['gl_rut_usuario'] . "' ";
		}
		if (!empty($params['gl_nombres_apellidos'])) {
			$query	.=  " AND CONCAT(" . TABLA_ACCESO_USUARIO . ".mu_nombre, " . TABLA_ACCESO_USUARIO . ".mu_apellido_paterno, " . TABLA_ACCESO_USUARIO . ".mu_apellido_materno) LIKE '%" . $params['gl_nombres_apellidos'] . "%' ";
		}
		if (!empty($params['fk_region'])) {
			$query	.=  " AND " . TABLA_DIRECCION_REGION . ".id_region_midas = " . (int)$params['fk_region'] . " ";
		}
		if (!empty($params['fk_estado'])) {
			$query	.=  " AND " . TABLA_ACCESO_USUARIO . ".mu_estado_sistema = " . (int)$params['fk_estado'] . " ";
		}
		/**
		 * que es esto? de donde lo saco, como lo uso
		 */
		// if (!empty($params['bo_institucional'])) {
		// 	$query	.=  " AND mu_estado_sistema = " . (int)$params['fk_estado'] . " ";
		// }
		if (!empty($params['fk_roles'])) {
			$query	.=  " AND " . TABLA_ACCESO_USUARIO_ROL . ".mur_fk_rol IN ( " . implode(",", $params['fk_roles']) . " ) ";
		}
		if (!empty($params['fk_profesiones'])) {
			$query	.=  " AND " . TABLA_PROFESION_USUARIO . ".fk_profesion  IN ( " . implode(",", $params['fk_profesiones']) . " ) ";
		};

		$param	= array();

		// var_dump($query);
		// var_dump($param);

		$result	= $this->db->getQuery($query, $param)->runQuery();

		return $result->getRows();
	}
	/**
	 * Descripción : Obtener perfil usuario por id_usuario e id_perfil
	 * @author  David Guzmán <david.guzman@cosof.cl> - 20/01/2020
	 * @param   int   $id_usuario, $id_perfil
	 */
	public function obtPerfilUsuario($id_usuario, $id_perfil, $id_region, $id_oficina, $id_ambito)
	{
		$query	= "	SELECT
                        usuario_perfil.*,
                        perfil.nombre AS gl_perfil,
                        (SELECT sum_oficina.nombre FROM sum_oficina WHERE id = usuario_perfil.id_oficina) AS gl_oficina,
                        (SELECT sum_region.nombre FROM sum_region WHERE id = usuario.id_region) AS gl_region
					FROM " . $this->_tabla . " usuario_perfil
                        LEFT JOIN sum_v4_perfil perfil ON usuario_perfil.id_perfil = perfil.id
                        LEFT JOIN sum_usuario usuario ON usuario_perfil.id_usuario = usuario.USUA_id
					WHERE usuario_perfil.id_usuario = ? AND usuario_perfil.id_perfil = ? AND usuario_perfil.id_region = ?
                     AND usuario_perfil.id_oficina = ? AND usuario_perfil.id_ambito = ?";

		$param	= array($id_usuario, $id_perfil, $id_region, $id_oficina, $id_ambito);
		$result	= $this->db->getQuery($query, $param)->runQuery();

		$rows	= $result->getRows(0);

		if (!empty($rows)) {
			return $rows;
		}
	}
}
