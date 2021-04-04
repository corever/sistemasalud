<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOLocalEstado extends \pan\Kore\Entity{

	protected $table       = TABLA_LOCAL_ESTADO;
	protected $primary_key = "local_estado_id";

	function __construct(){
		parent::__construct();
	}

	public function getById($id){
		$query	=
		"	SELECT	*
            FROM	".	$this->table        ."
			WHERE   ".	$this->primary_key	."	=	?
		";

		$param	=	array($id);
		$result	=	$this->db->getQuery($query,$param)->runQuery();

		if ($result->getNumRows() > 0) {
			return	$result->getRows(0);
		}else {
			return	NULL;
		}
	}

	public function getLista($bo_activo=NULL){

		$query	=	"	SELECT	*	FROM	".	$this->table;

		if(is_bool($bo_activo)){
			$query	.=	"	WHERE	estado	=	"	.	$bo_activo;
		}

		$result	=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return $result->getRows();
		}else{
			return NULL;
		}
	}

	public function deshabilitarAnteriores($id_local,$bo_inhabilitar=FALSE){
		$result					=	NULL;
		$set_inhabilitar		=	"";
		if($bo_inhabilitar){
			$set_inhabilitar	=	", estado_cron_inhabilitar	=	3	";
		}
		if(!empty($id_local)){
			$query	=
			"	UPDATE	".	$this->table	."
				SET		estado_cron_habilitar	=	3	".	$set_inhabilitar	."
				WHERE	fk_local				=	$id_local
			";

			if($bo_inhabilitar){
				$query			.=	"	AND		estado_cron_inhabilitar	=	1	";
			}else{
				$query			.=	"	AND		estado_cron_habilitar	=	1	";
			}
				
			$result	=	$this->db->execQuery($query);
		}

		return $result;
	}
	
}