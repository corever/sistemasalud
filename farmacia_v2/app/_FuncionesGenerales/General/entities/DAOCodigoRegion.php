<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOCodigoRegion extends \pan\Kore\Entity{

	protected $table		=	TABLA_CODIGO_REGION;
	protected $primary_key	=	"codfono_id";

	function __construct(){
		parent::__construct();
	}

	public function getById($id_evento, $retornaLista = FALSE){
		$query	= "
		SELECT *
		FROM ".$this->table."
		WHERE ".$this->primary_key." = ?";

		$param	= array($id_evento);
		$result	= $this->db->getQuery($query,$param)->runQuery();
		$rows   = $result->getRows();

		if (!empty($rows) && !$retornaLista) {
			return $rows[0];
		}else {
			return $rows;
		}
	}

	public function getLista(){

		$query	= "SELECT * FROM ".$this->table;

		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return $result->getRows();
		}else{
			return NULL;
		}
	}

	public function getByParams($params=array(),$bo_formato=TRUE){
		$bo_nacional		=	TRUE;
		$query				=
		"	SELECT		codigo.*,
						region.region_nombre
			FROM		".	$this->table			."		codigo
			LEFT JOIN	".	TABLA_DIRECCION_REGION	."	AS	region	ON	codigo.id_region_midas	=	region.id_region_midas
		";

		$arr_query			=	array();
		$where				=	"	WHERE	";
		if(isset($params["id_region"]) && !empty($params["id_region"])){
			$bo_nacional	=	FALSE;
			$id_region		=	$params["id_region"];
			$arr_query[]	=	"	codigo.id_region_midas	IN	(0,".$id_region.")";
		}

		if(!empty($arr_query)){
			$impld_query	=	$where.implode("	AND	",$arr_query);
			$query			=	$query.$impld_query;
		}

		$query				.=	"	ORDER BY	codigo.id_region_midas	";

		$result				=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()	>	0){
			$rows							=	$result->getRows();
			if($bo_formato){
				foreach ($rows as &$value) {
					$reg					=	"";
					$cod					=	"(".$value->codigo.")";
					$prov					=	(!empty($value->provincia))?" - ".(ucwords(mb_strtolower($value->provincia))):"";
					if($value->id_region_midas == 0){
						$reg				=	" Nacional";
					}elseif($bo_nacional){
						$reg				=	" ".(ucwords(mb_strtolower($value->region_nombre)));
					}

					$value->codigo_formato	=	$cod.$reg.$prov;
				}
			}
			return $rows;
		}else{
			return NULL;
		}
	}

	public function insertarEvento($params) {
		
		$id     = false;
		$query  = "
		INSERT INTO ".$this->table."
		(
			id_evento_tipo,
			bo_activo,
			gl_descripcion,
			id_usuario_crea,
			fc_creacion
		)
		VALUES
		(
			?,
			?,
			?,
			?,
			now()
		);";
			
		if($this->db->execQuery($query,$params)){
			$id = $this->db->getLastId();
		}
		
		return $id;
	}

}