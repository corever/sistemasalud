<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAODireccionRegion extends \pan\Kore\Entity{

 	protected $table		=	TABLA_DIRECCION_REGION;
	protected $primary_key	=	'id_region_midas';

	function __construct(){
		parent::__construct();
	}

	function getById($id){
		$query	= " SELECT *
                    FROM ".$this->table."
                    WHERE ".$this->primary_key." = ?";
        $params = array(intval($id));
		$result	= $this->db->getQuery($query,$params)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}
	
	function getLista(){
		$query	= "SELECT * FROM ".$this->table." ORDER BY orden_territorial ASC";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

	function getListaIn($arr){
		$result		=	NULL;

		if(!empty($arr)){
			$impld	=	implode(",",$arr);

			$query	=
				"	SELECT		*
					FROM		".	$this->table	."
					WHERE		id_region_midas		IN	(".	$impld	.")
					ORDER BY	orden_territorial	ASC";
			$result	=	$this->db->getQuery($query)->runQuery();
		}

		if($result->getNumRows()>0){
            return	$result->getRows();
		}else{
            return	NULL;
		}
	}

	function getListaPaisForCombo(){
		$query	= "SELECT ".$this->primary_key." as id,
						  gl_nombre_pais as nombre,
						  gl_nombre_nacionalidad as nacionalidad,
						  codigo_alpha_2,
						  gl_latitud,
						  gl_longitud
				   FROM ".$this->table." 
				   WHERE bo_activo = 1
				   ORDER BY gl_nombre_pais";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

	function getListaNacionalidadForCombo(){
		$query	= "SELECT ".$this->primary_key." as id,
						  gl_nombre_nacionalidad as nombre,
						  gl_nombre_pais as nombre_pais,
						  codigo_alpha_2,
						  gl_latitud,
						  gl_longitud
				   FROM ".$this->table." 
				   WHERE bo_activo = 1
				   ORDER BY gl_nombre_nacionalidad";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}    
}