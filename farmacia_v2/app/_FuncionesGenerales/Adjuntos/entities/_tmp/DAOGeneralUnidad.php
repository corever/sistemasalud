<?php

/**
 ******************************************************************************
 * Sistema			: MIS FISCALIZACIONES
 *
 * Descripcion		: Modelo para Tabla mfis_general_unidades
 *
 * Plataforma		: !PHP
 *
 * Creacion			: 09/10/2019
 *
 * @name			DAOGeneralUnidad.php
 *
 * @version			1.0
 *
 * @author			Gabriel Díaz <gabriel.diaz@cosof.cl>
 *
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				!cFecha		!cDescripcion
 * ----------------------------------------------------------------------------
 *
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

namespace App\General\Entity;

use Pan\Utils\ValidatePan;

class DAOGeneralUnidad extends \pan\Kore\Entity
{
	protected	$table			=	TABLA_GENERAL_UNIDAD;
	protected	$primary_key	=	"id_unidad";
	const		CRONOLOGICO		=	1;
	const		BOOLEANO		=	2;
	const		SATISFACCIÓN	=	3;
	const		CALIFICACIÓN	=	4;

	function __construct()
	{
		parent::__construct();
	}

	public function getLista(){
		$query		= "SELECT *
					   FROM ".$this->table;

		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return  $result->getRows();
		}else{
			return NULL;
		}
	}

	public function getByGrupo($id_grupo){
		if(isset($id_grupo) && in_array($id_grupo,array(self::CRONOLOGICO,self::BOOLEANO,self::SATISFACCIÓN,self::CALIFICACIÓN))){
			$query	=
			"	SELECT		u.*
				FROM		".	$this->table	."	u
				WHERE		u.id_unidad_grupo		=	".	(isset($id_grupo)	?	$id_grupo	:	"0")	."
			";
	
			$result	=	$this->db->getQuery($query)->runQuery();
	
			if($result->getNumRows()>0){
				return 	$result->getRows();
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}

	public function getNombreById($id){
		$query	=
		"	SELECT		u.gl_nombre
			FROM		".	$this->table	."	u
			WHERE		u.id_unidad_grupo		=	".	$id;

		$result	=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return 	$result->getRows(0)->gl_nombre;
		}else{
			return NULL;
		}
	}
}
