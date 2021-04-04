<?php

namespace App\Farmacia\Turnos\Entities;

class DAOTurnoDetalle extends \pan\Kore\Entity{

	protected $table		=	TABLA_TURNO_DETALLE;
	protected $primary_key	=	"turno_detalle_id";

	function __construct(){
		parent::__construct();
	}

	public function getById($id){

		$query	=
		"	SELECT	*
			FROM	".	$this->table		."
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

	public function getLista(){

		$query	=	"	SELECT	*	FROM	".	$this->table;

		$result	=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return $result->getRows();
		}else{
			return NULL;
		}
	}

	public function getTurnosLocal($id_local, $fecha	=	NULL){
		
		$query		=
		"	SELECT		td.*
			FROM		".	$this->table				." td
			LEFT JOIN	".	TABLA_TURNO					."	t	ON	td.fk_turno		=	t.turno_id
			LEFT JOIN	".	TABLA_DIRECCION_LOCALIDAD	."	l	ON	l.localidad_id	=	t.fk_localidad
			WHERE		td.fk_local		=	?		
		";

		if(!empty($fecha)){
			$query	.=	"	AND	td.turno_dia	>	"	.	 $fecha;
		}

		$query		.=	"	GROUP BY	turno_fecha_inicio	";

		$param		=	array($id_local);
		$result		=	$this->db->getQuery($query,$param)->runQuery();

		if ($result->getNumRows() > 0) {
			return	$result->getRows();
		}else {
			return	NULL;
		}
	}
}