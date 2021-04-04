<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOLocalEstadoTurno extends \pan\Kore\Entity{

	protected $table		=	TABLA_LOCAL_ESTADO_TURNO;
	protected $primary_key	=	"id_local_estado";

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

	public function getLocalEstado($id_turno,$bo_activo=NULL){

		$query	=
		"	SELECT	*	
			FROM	".	$this->table	.	"
			WHERE	fk_turno	=	?

		";

		if(!is_null($bo_activo)){
			$query	.=	"	AND	estado	=	"	.	$bo_activo;
		}

		$params	=	array(
			$id_turno
		);

		$result	=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return $result->getRows();
		}else{
			return NULL;
		}
	}
}