<?php

namespace App\_FuncionesGenerales\General\Entity;

use App\Farmacia\Talonarios\LocalVenta;
use App\Farmacias\Farmacia\Entities\DAOLocal as EntitiesDAOLocal;
use DAOLocal;

class DAODireccionComuna extends \pan\Kore\Entity
{

	protected $table		=	TABLA_DIRECCION_COMUNA;
	protected $primary_key	=	'id_comuna_midas';

	function __construct()
	{
		parent::__construct();
	}

	function getById($id)
	{
		$query	= " SELECT *
                    FROM " . $this->table . "
                    WHERE " . $this->primary_key . " = ?";
		$params = array(intval($id));
		$result	= $this->db->getQuery($query, $params)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows(0);
		} else {
			return NULL;
		}
	}

	function getLista()
	{
		$query	= "SELECT * FROM " . $this->table;
		$result	= $this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}

	function getListaExterna()
	{
		$query	= "SELECT *, LOWER(gl_nombre_comuna) AS gl_nombre_comuna  FROM comuna_ext";
		$result	= $this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}



	function getListaPaisForCombo()
	{
		$query	= "SELECT " . $this->primary_key . " as id,
						  gl_nombre_pais as nombre,
						  gl_nombre_nacionalidad as nacionalidad,
						  codigo_alpha_2,
						  gl_latitud,
						  gl_longitud
				   FROM " . $this->table . " 
				   WHERE bo_activo = 1
				   ORDER BY gl_nombre_pais";
		$result	= $this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}

	function getListaNacionalidadForCombo()
	{
		$query	= "SELECT " . $this->primary_key . " as id,
						  gl_nombre_nacionalidad as nombre,
						  gl_nombre_pais as nombre_pais,
						  codigo_alpha_2,
						  gl_latitud,
						  gl_longitud
				   FROM " . $this->table . " 
				   WHERE bo_activo = 1
				   ORDER BY gl_nombre_nacionalidad";
		$result	= $this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}

	function getByRegion($id_region)
	{
		$query	= " SELECT *
                    FROM " . $this->table . "
                    WHERE fk_region_midas = ?";
		$params = array(intval($id_region));
		$result	= $this->db->getQuery($query, $params)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}

	/**
	 * Descripción	: Carga comunas con Establecimiento Urgencia por región
	 * @author		: <ricardo.munoz@cosof.cl> - 27/09/2020
	 */
	function getWithEstablecimientoUrgenciaByRegion($id_region)
	{

		$query_in	= "SELECT 
						GROUP_CONCAT(DISTINCT id_comuna_midas SEPARATOR ',') AS in_comunas
						FROM local 
						WHERE local_tipo_urgencia = 1 AND id_region_midas =  " . $id_region . ";";

		$result_query_in	= $this->db->getQuery($query_in, "")->runQuery()->getRows()[0];

		$in_comunas = $result_query_in->in_comunas;
		/**
		 * control cuando la region no tenga comunas con Establecimientos de urgencia
		 */
		if (!is_null($in_comunas)) {

			$query	= " SELECT *
					FROM " . $this->table . "
					WHERE id_comuna_midas IN (" . $in_comunas . ")";

			$result	= $this->db->getQuery($query, "")->runQuery();

			if ($result->getNumRows() > 0) {
				return $result->getRows();
			} else {
				return NULL;
			}
		}
		return NULL;
		// return 0;
	}
}
