<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOFarmaciaCaracter extends \pan\Kore\Entity{
	
	protected $table		=	TABLA_FARMACIA_CARACTER;
	protected $primaria		=	"id_caracter";
	protected $primary_key	=	"id_caracter";
	
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
}
?>