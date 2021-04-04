<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOLocal extends \pan\Kore\Entity
{

	protected $table       = TABLA_LOCAL;
	protected $primary_key = "local_id";

	function __construct()
	{
		parent::__construct();
	}

	public function getById($id_evento, $retornaLista = FALSE)
	{

		$query	= "
		SELECT *, comuna.fk_territorio
		FROM " . $this->table . "
		LEFT JOIN comuna ON local.id_comuna_midas = comuna.id_comuna_midas
		WHERE " . $this->primary_key . " = ?";

		$param	= array($id_evento);
		$result	= $this->db->getQuery($query, $param)->runQuery();
		$rows   = $result->getRows();

		if (!empty($rows) && !$retornaLista) {
			return $rows[0];
		} else {
			return $rows;
		}
	}

	public function getByToken($gl_token)
	{

		$query	=
			"	SELECT	*
			FROM	" . $this->table . "
			WHERE	gl_token		=	?";

		$param	=	array(
			$gl_token
		);
		$result	=	$this->db->getQuery($query, $param)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows(0);
		} else {
			return NULL;
		}
	}

	public function getDetallesByToken($gl_token)
	{

		$query	=
			"	SELECT		estab.*,
						horario.bo_continuado,
						horario.json_lunes,
						horario.json_martes,
						horario.json_miercoles,
						horario.json_jueves,
						horario.json_viernes,
						horario.json_sabado,
						horario.json_domingo,
						horario.json_festivos,
						empresa.farmacia_rut_midas								AS	gl_farmacia_rut,
						empresa.farmacia_razon_social							AS	gl_farmacia_nombre,
						region.region_nombre									AS	gl_nombre_region,
						comuna.comuna_nombre									AS	gl_nombre_comuna,
						localidad.localidad_nombre								AS	gl_localidad,
						motivo_deshab.motivo_inhabilitacion_nombre				AS	gl_motivo_inhabilitacion,
						DATE_FORMAT(local_estado.fc_inicio,'%d/%m/%Y')			AS	fc_inicio_deshabilita,
						DATE_FORMAT(local_estado.fc_termino,'%d/%m/%Y')			AS	fc_termino_deshabilita,
						local_estado.fc_inicio									AS	fc_inicio_deshabilita_bd,
						local_estado.fc_termino									AS	fc_termino_deshabilita_bd,
						recetario.gl_nombre										AS	gl_nombre_tipo_recetario

			FROM		" .	$this->table					. "	estab
			LEFT JOIN	" .	TABLA_LOCAL_HORARIO				. "	horario			ON	horario.id_local						=	estab.local_id
			LEFT JOIN	" .	TABLA_FARMACIA					. "	empresa			ON	empresa.farmacia_id						=	estab.fk_farmacia
			LEFT JOIN	" .	TABLA_LOCAL_RECETARIO_TIPO		. "	recetario		ON	recetario.id_recetario					=	estab.id_recetario_tipo
			LEFT JOIN	" .	TABLA_DIRECCION_REGION			. "	region			ON	region.region_id						=	estab.id_region_midas
			LEFT JOIN	" .	TABLA_DIRECCION_COMUNA			. "	comuna			ON	comuna.id_comuna_midas					=	estab.id_comuna_midas
			LEFT JOIN	" .	TABLA_DIRECCION_LOCALIDAD		. "	localidad		ON	localidad.localidad_id					=	estab.fk_localidad
			LEFT JOIN	" .	TABLA_LOCAL_MOTIVO_DESHABILITAR	. "	motivo_deshab	ON	motivo_deshab.motivo_inhabilitacion_id	=	estab.local_motivo_deshabilitacion
			LEFT JOIN	" .	TABLA_LOCAL_ESTADO				. "	local_estado	ON	local_estado.fk_local					=	estab.local_id
			
			WHERE		estab.gl_token			=	?
			AND			horario.bo_activo		=	1
		";
		// local_recetario_tipo
		$param	=	array(
			$gl_token
		);
		$result	=	$this->db->getQuery($query, $param)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows(0);
		} else {
			return NULL;
		}
	}

	public function getByEmpresa($id_farmacia, $estado = NULL)
	{
		$query	=
			"	SELECT		loc.*,
						comuna.fk_territorio
			FROM		" .	$this->table			. "	loc
			LEFT JOIN	" .	TABLA_DIRECCION_COMUNA	. "	comuna	ON	loc.id_comuna_midas	=	comuna.id_comuna_midas
			WHERE		loc.fk_farmacia		=	?
			
		";

		$params	=	array(
			$id_farmacia
		);

		if (!is_null($estado) && is_bool($estado)) {
			$query		.=	"	AND			loc.local_estado	=	?	";
			$params[]	=	$estado;
		}

		$result	=	$this->db->getQuery($query, $params)->runQuery();

		if ($result->getNumRows() > 0) {
			return	$result->getRows();
		} else {
			return	NULL;
		}
	}


	public function getLista()
	{

		$query	= "SELECT * FROM " . $this->table;

		$result	= $this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}

	public function getByProfesion($id_profesion)
	{

		$id = 0;

		if ($id_profesion == 6) :
			$id = "6";
		elseif ($id_profesion == 5) :
			$id = "5";
		elseif ($id_profesion == 4 || $id_profesion == 3 || $id_profesion == 2) :
			$id = "4,5";
		else :
			$id = "6";
		endif;

		$query	= " SELECT *
					FROM " . $this->table . "
					WHERE fk_local_tipo IN (" . $id . ")";

		$result	= $this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}

	public function getByLocal()
	{

		$query	= "SELECT * FROM " . $this->table . " ORDER BY nombre_profesion ASC";

		$result	= $this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}

	public function getListaByParams($params = [])
	{

		$query					=
			"	SELECT		estab.*,
						empresa.farmacia_rut_midas			AS	gl_farmacia_rut,
						empresa.farmacia_razon_social		AS	gl_farmacia_nombre,
						comuna.comuna_nombre				AS	gl_nombre_comuna,
						localidad.localidad_nombre			AS	gl_localidad
			FROM		" .	$this->table				. "	estab
			LEFT JOIN	" .	TABLA_FARMACIA				. "	empresa		ON	empresa.farmacia_id		=	estab.fk_farmacia
			LEFT JOIN	" .	TABLA_DIRECCION_COMUNA		. "	comuna		ON	comuna.id_comuna_midas	=	estab.id_comuna_midas
			LEFT JOIN	" .	TABLA_DIRECCION_LOCALIDAD	. "	localidad	ON	localidad.localidad_id	=	estab.fk_localidad
			LEFT JOIN	" .	TABLA_DIRECTOR_TECNICO		. "	dt			ON	dt.fk_local				=	estab.local_id
			LEFT JOIN	" .	TABLA_LOCAL_ESTADO_TURNO	. "	turno_est	ON	( turno_est.fk_local	=	estab.local_id AND turno_est.estado		=	1 )
			
		";

		$where					=	"	WHERE	";
		$arr_query				=	array();
		if (!empty($params)) {
			if (!empty($params["id_local_tipo"])) {
				$arr_query[]	=	"	estab.fk_local_tipo			=	" .	$params["id_local_tipo"]	. "	";
			}
			if (!empty($params["id_region"])) {
				$arr_query[]	=	"	estab.id_region_midas		=	" .	$params["id_region"]		. "	";
			}
			if (!empty($params["id_comuna"])) {
				$arr_query[]	=	"	estab.id_comuna_midas		=	" .	$params["id_comuna"]		. "	";
			}
			if (!empty($params["id_localidad"])) {
				$arr_query[]	=	"	estab.fk_localidad			=	" .	$params["id_localidad"]		. "	";
			}
			if ($params["local_estado"] == "0" || $params["local_estado"] == "1") {
				$arr_query[]	=	"	estab.local_estado			=	" .	$params["local_estado"]		. "	";
			}
			if ($params["id_movil"] == "0" || $params["id_movil"] == "1") {
				$arr_query[]	=	"	estab.local_tipo_movil		=	" .	$params["id_movil"]		. "	";
			}
			if ($params["id_popular"] == "0"){
				$arr_query[]	=	"	estab.fk_local_tipo			<>	7	";
			}elseif($params["id_popular"] == "1"){
				$arr_query[]	=	"	estab.fk_local_tipo			=	7	";
			}
			if($params["dt_asignado"] == "1"){
				$arr_query[]	=	"	dt.DT_id					IS NOT NULL	";
			}elseif($params["dt_asignado"] == "0"){
				$arr_query[]	=	"	dt.DT_id					IS NULL	";
			}
			if($params["sel_turno"] == "1"){
				$arr_query[]	=	"	turno_est.id_local_estado	IS NOT NULL	";
			}elseif($params["sel_turno"] == "0"){
				$arr_query[]	=	"	turno_est.id_local_estado	IS NULL	";
			}

		}



		if (!empty($arr_query)) {
			$query				.=	$where	.	implode("	AND	", $arr_query);
		}

		$result					=	$this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return	$result->getRows();
		} else {
			return	NULL;
		}
	}

	public function getLimit($limit)
	{

		$query	=
			"	SELECT		est.*
			FROM		" .	$this->table		. "	est
			LEFT JOIN	" .	TABLA_LOCAL_HORARIO	. "	horario	ON	horario.id_local = est.local_id
			WHERE		horario.id_horario			IS NULL
			LIMIT		" . $limit;

		$result	=	$this->db->getQuery($query)->runQuery();

		if ($result->getNumRows() > 0) {
			return $result->getRows();
		} else {
			return NULL;
		}
	}

	/**
	 * ricardo.munoz 25-09-2020
	 * obtiene los establecimientos de urgencia
	 * @var 
	 * @return array
	 */
	public function getEstablecimientoUrgencia()
	{
		$arrQuery = array(
			"local_tipo_urgencia" => "1"
		);

		$result	= $this->where($arrQuery, "")->runQuery()->getRows();
		return $result;
	}

	/**
	 * ricardo.munoz 25-09-2020
	 * obtiene los establecimientos de urgencia
	 * @var 
	 * @return array
	 */
	public function getListaEstablecimientoUrgenciaActivo()
	{
		$arrQuery = array(
			"local_estado" => "1",
			"local_tipo_urgencia" => "1"
		);

		$result	= $this->where($arrQuery, "")->runQuery()->getRows();
		return $result;
	}

	/**
	 * ricardo.munoz 25-09-2020
	 * obtiene los establecimientos de urgencia por Region
	 * @var $region_id
	 * @return array
	 */
	public function getEstablecimientoUrgenciaByRegion($region_id)
	{
		$arrQuery = array(
			"local_tipo_urgencia" => "1",
			"local_estado" => "1",
			"id_region_midas" => $region_id
		);

		$result	= $this->where($arrQuery, "")->runQuery()->getRows();
		return $result;
	}

	/**
	 * ricardo.munoz 25-09-2020
	 * obtiene un arreglo con los establecimientos de urgencia por Comuna Activos
	 * @var $comuna_id
	 * @return array
	 */
	public function getListaEstablecimientoUrgenciaByComunaActivo($comuna_id)
	{
		$arrQuery = array(
			"local_tipo_urgencia" => "1",
			"local_estado" => "1",
			"id_comuna_midas" => $comuna_id
		);
		$arrParams = array(
			'local_id',
			'local_nombre',
			'local_direccion',
			'local_telefono',
			'gl_token'
		);

		$result	= $this->where($arrQuery, $arrParams)->runQuery()->getRows();

		return $result;
	}
}
