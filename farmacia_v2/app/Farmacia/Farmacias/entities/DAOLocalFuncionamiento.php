<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOLocalFuncionamiento extends \pan\Kore\Entity{
	
	protected $table		=	TABLA_LOCAL_FUNCIONAMIENTO;
	protected $primaria		=	"fk_local";
	protected $primary_key	=	"fk_local";
	
	public function __construct() {
		parent::__construct();
	}

	public function getByLocal($fk_local=NULL){
		$query		=	
		"	SELECT	*
			FROM	".$this->table."
			WHERE	fk_local		=	".$fk_local."
		";

		$result		=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return	$result->getRows();
		}else{
			return	NULL;
		}
	}  
}
?>