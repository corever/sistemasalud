<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOLocalHistorialTipo extends \pan\Kore\Entity{

	protected	$table							=	TABLA_LOCAL_HISTORIAL_TIPO;
	protected	$primary_key					=	"id_tipo";

	const	HISTORIAL_LOCAL_CREACION			=	1;
	const	HISTORIAL_LOCAL_EDICION				=	2;
	const	HISTORIAL_LOCAL_HABILITA			=	3;
	const	HISTORIAL_LOCAL_PROG_HABILITA		=	4;
	const	HISTORIAL_LOCAL_DESHABILITA			=	5;
	const	HISTORIAL_LOCAL_PROG_DESHABILITA	=	6;

	function __construct(){
		parent::__construct();
	}

	public function getById($id){
		$query	=
		"	SELECT	*
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
}