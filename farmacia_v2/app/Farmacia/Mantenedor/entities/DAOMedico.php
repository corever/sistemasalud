<?php

/**
 ******************************************************************************
 * Sistema           : SUMARIOS V1
 *
 * Descripcion       : Modelo para Tabla medicos
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 13/08/2020
 *
 * @name             DAOMedico.php
 *
 * @version          1.0
 *
 * @author           Felipe Bocaz <felipe.bocaz@cosof.cl>
 *
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				!cFecha		!cDescripcion
 * ---------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

namespace App\Farmacia\Mantenedor\Entity;

class DAOMedico extends \pan\Kore\Entity
{


	protected $table			            = TABLA_MEDICO;
	protected $primary_key		            = "id_medico";

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Descripción   : Insertar nuevo medico.
	 * @author       : <felipe.bocaz@cosof.cl>
	 * @param        : array
	 * @return       : int
	 */
	public function insertMedico($params)
	{

		$id     = false;
		$query  = "INSERT INTO " . $this->table . "
							(
								fk_usuario,
								medico_rut,
								medico_rut_midas,
								medico_nombre,
								medico_apellidopat,
								medico_apellidomat,
								medico_gen,
								medico_fecha_nacimiento,
								medico_correo,
								fk_region,
								fk_comuna,
								direccion_medico,
								fono,
								fono_codigo,
								bo_estado
							)
							VALUES
							(
								?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
							)";

		if ($this->db->execQuery($query, $params)) {
			$id = $this->db->getLastId();
		}

		return $id;
	}


	/**
	 * Descripción : Obtener Lista Mantenedor Medico
	 * @author  Felipe Bocaz <felipe.bocaz@cosof.cl> - 17/08/2020
	 */
	public function getListaMantenedorMedico($params)
	{
		$param  = array();
		$where  = " WHERE ";
		$query	= " SELECT
					medico_rut AS gl_rut,
					fk_usuario AS gl_token,
					CONCAT(COALESCE(medico_nombre,''),' ',COALESCE(medico_apellidopat,''),' ',COALESCE(medico_apellidomat,'')) AS gl_nombre_completo,
					medico_correo AS gl_email,
					direccion_medico AS gl_direccion,
					fono AS gl_telefono,
					bo_estado AS bo_activo,
					UPPER(SUBSTRING(medico_gen,1,1)) AS gl_genero
					FROM    " . $this->table . "";

		if (!empty($params)) {
			if (isset($params['id_region']) && intval($params['id_region']) > 0) {
				$query      .= "$where usuario.fk_region = ?";
				$param[]    = intval($params['id_region']);
				$where      = " AND ";
			}
			if (isset($params['id_comuna']) && intval($params['id_comuna']) > 0) {
				$query      .= "$where usuario.fk_comuna = ?";
				$param[]    = intval($params['id_comuna']);
				$where      = " AND ";
			}
			if (isset($params['bo_activo']) && ($params['bo_activo'] == "1" || $params['bo_activo'] == "0")) {
				$query      .= "$where usuario.bo_estado = ?";
				$param[]    = intval($params['bo_activo']);
				$where      = " AND ";
			}
			if (isset($params['gl_nombre']) && trim($params['gl_nombre']) != "") {
				$query .= "$where (usuario.medico_nombre LIKE '%" . mb_strtoupper($params['gl_nombre']) . "%'";
				$query .= "OR usuario.medico_apellidopat LIKE '%" . mb_strtoupper($params['gl_nombre']) . "%'";
				$query .= "OR usuario.medico_apellidomat LIKE '%" . mb_strtoupper($params['gl_nombre']) . "%'";
				$query .= "OR CONCAT(usuario.medico_nombre,' ',usuario.medico_apellidopat,' ',usuario.medico_apellidomat) LIKE '%" . mb_strtoupper($params['gl_nombre']) . "%')";
				$where  = " AND ";
			}
			if (isset($params['gl_email']) && trim($params['gl_email']) != "") {
				//if(\Email::validar_email($params['gl_email'])){
				$query .= "$where usuario.medico_correo LIKE '%" . $params['gl_email'] . "%'";
				$where  = " AND ";
				//}
			}
			if (isset($params['gl_rut']) && trim($params['gl_rut']) != "") {
				$query .= "$where (usuario.medico_rut LIKE '%" . $params['gl_rut'] . "%' OR usuario.medico_rut_midas LIKE '%" . $params['gl_rut'] . "%')";
				$where  = " AND ";
			}
		}

		$result	= $this->db->getQuery($query, $param)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}

	public function getByUsuario($id_usuario)
	{
		$query	= "	SELECT
					medico.id_medico AS id_medico,
					medico.fk_usuario AS id_usuario,
					medico.fk_usuario AS gl_token,
					COALESCE(usuario.mu_rut,medico.medico_rut) AS gl_rut,
					COALESCE(usuario.mu_nombre,medico.medico_nombre) AS gl_nombres,
					COALESCE(usuario.mu_apellido_paterno,medico.medico_apellidopat) AS gl_apellido_paterno,
					COALESCE(usuario.mu_apellido_materno,medico.medico_apellidomat) AS gl_apellido_materno,
					2 AS id_profesion,
					especialidad.especialidad_id AS id_especialidad,
					especialidad.especialidad_nombre AS gl_especialidad,
					medico.fk_region AS id_region,
					medico.fk_comuna AS id_comuna,
					COALESCE(usuario.mu_correo,medico.correo_medico) AS gl_email,
					COALESCE(usuario.mu_direccion,medico.direccion_consulta) AS gl_direccion
				FROM " . $this->table . " medico
				LEFT JOIN " . TABLA_ESPECIALIDAD . " especialidad ON medico.fk_esp = especialidad.especialidad_id
				LEFT JOIN ".TABLA_ACCESO_USUARIO." usuario ON medico.fk_usuario = usuario.mu_id
				WHERE medico.fk_usuario = '" . $id_usuario . "'";
		$result	= $this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows(0);
		} else {
			return NULL;
		}
	}

	/**
	 * Descripción : Editar Usuario
	 * @author  David Guzmán <david.guzman@cosof.cl> - 07/01/2020
	 * @param   array   $gl_token, $params
	 */
	public function modificarMedico($gl_token, $params)
	{
		$query	= "	UPDATE " . $this->table . "
					SET
						medico_nombre              	= ?,
						medico_apellidopat			   	= ?,
						medico_apellidomat		    	= ?,
						medico_gen		            	= ?,
						medico_fecha_nacimiento		 	= ?,
						medico_correo								= ?,
						fk_region         					= ?,
						fk_comuna					         	= ?,
						direccion_medico						= ?,
						fono_codigo									= ?,
						fono						            = ?
					WHERE fk_usuario = '$gl_token'";

		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}

	/**
	 * Descripción : Setea activo (habilita/deshabilita medico)
	 * @author Felipe Bocaz <felipe.bocaz@cosof.cl> - 19/08/2020
	 * @param   array   $id
	 */
	public function setActivoByTokenMedico($gl_token, $bo_activo)
	{
		$query	= "	UPDATE " . $this->table . "
				SET bo_estado = ?
				WHERE fk_usuario = ? ";
		$param	= array($bo_activo, $gl_token);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}
}
