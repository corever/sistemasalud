<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAODireccionLocalidad extends \pan\Kore\Entity{

	protected $table		=	TABLA_DIRECCION_LOCALIDAD;
	protected $primary_key	=	'localidad_id';

	function __construct(){
		parent::__construct();
	}

	function getById($id){
		$query	=
		"	SELECT	*
			FROM	".	$this->table		."
			WHERE	".	$this->primary_key	."	=	?
		";

		$params	=	array(intval($id));
		$result	=	$this->db->getQuery($query,$params)->runQuery();

		if($result->getNumRows()>0){
			return	$result->getRows(0);
		}else{
			return	NULL;
		}
	}

	function getLista(){
		$query	=
		"	SELECT	*
			FROM	".	$this->table	."
		";

		$result	=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return	$result->getRows();
		}else{
			return	NULL;
		}
	}

	function getByComuna($id_comuna){
		$query	=
		"	SELECT	*
			FROM	".	$this->table	."
			WHERE	id_comuna_midas	=	?
		";

		$params	=	array(intval($id_comuna));
		$result	=	$this->db->getQuery($query,$params)->runQuery();

		if($result->getNumRows()>0){
			return	$result->getRows();
		}else{
			return	NULL;
		}
	}
}