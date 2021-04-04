<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOLocalHorario extends \pan\Kore\Entity{
	
	protected $table		=	TABLA_LOCAL_HORARIO;
	protected $primaria		=	"id_horario";
	protected $primary_key	=	"id_horario";
	
	public function __construct() {
		parent::__construct();
	}

	public function getLista($bo_activo=NULL){
		$query		=	
		"	SELECT	*
			FROM	".$this->table."
		";

		if(is_bool($bo_activo)){
			$query	.=	"	WHERE	bo_activo	=	"	.	$bo_activo;
		}

		$result		=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return	$result->getRows();
		}else{
			return	NULL;
		}
	}

	
	public function deshabilitar($id_local){
		$result		=	NULL;
		if(!empty($id_local)){
			$query	=
			"	UPDATE	".	$this->table	."
				SET		bo_activo	=	0
				WHERE	id_local	=	$id_local
			";
	
			$result	=	$this->db->execQuery($query);
		}

		return $result;
	}

	

	public function getByLocal($id_local){
		$query		=	
		"	SELECT		*
			FROM		".	$this->table	."
			WHERE		id_local	=	?
			AND			bo_activo	=	1
		";

		$param		=	array($id_local);
		$result		=	$this->db->getQuery($query,$param)->runQuery();

		if ($result->getNumRows() > 0) {
			return	$result->getRows(0);
		}else {
			return	NULL;
		}
	}
}
?>