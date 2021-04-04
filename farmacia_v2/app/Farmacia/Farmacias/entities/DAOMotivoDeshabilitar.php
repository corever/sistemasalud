<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOMotivoDeshabilitar extends \pan\Kore\Entity{
	
	protected $table		=	TABLA_LOCAL_MOTIVO_DESHABILITAR;
	protected $primaria		=	"id_clasificacion";
	protected $primary_key	=	"id_clasificacion";
	
	public function __construct() {
		parent::__construct();
	}

	public function getLista(){
		$query		=	
		"	SELECT		*
			FROM		".$this->table."
			ORDER BY	orden
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