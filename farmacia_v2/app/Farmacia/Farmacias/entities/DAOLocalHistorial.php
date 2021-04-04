<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOLocalHistorial extends \pan\Kore\Entity{

	protected $table       = TABLA_LOCAL_HISTORIAL;
	protected $primary_key = "id_historial";

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

	public function getLista($bo_activo=NULL){

		$query	=	"	SELECT	*	FROM	".	$this->table;

		if(is_bool($bo_activo)){
			$query	.=	"	WHERE	bo_activo	=	"	.	$bo_activo;
		}

		$result	=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return $result->getRows();
		}else{
			return NULL;
		}
	}

	
	public function getByLocal($id_local){

		$query	=
		"	SELECT		hist.gl_descripcion																	AS	gl_historial,
						DATE_FORMAT(hist.fc_crea,'%d/%m/%Y')												AS	fc_crea_format,
						DATE_FORMAT(hist.fc_crea,'%H:%i')													AS	hr_crea_format,
						tipo.gl_nombre																		AS	gl_tipo_historial,
						usua.mu_nombre																		AS	crea_nombre,
						usua.mu_apellido_paterno															AS	crea_apellido_paterno,
						usua.mu_apellido_materno															AS	crea_apellido_materno,
						usua.mu_rut_midas																	AS	gl_rut_usuario,
						CONCAT_WS(' ',usua.mu_nombre,usua.mu_apellido_paterno,usua.mu_apellido_materno)		AS	crea_nombe_completo
			FROM		".	$this->table				."	hist
			LEFT JOIN	".	TABLA_LOCAL_HISTORIAL_TIPO	."	tipo	ON	tipo.id_tipo	=	hist.id_historial_tipo
			LEFT JOIN	".	TABLA_ACCESO_USUARIO		."	usua	ON	usua.mu_id		=	hist.id_usuario_crea
			WHERE		hist.bo_activo				=	1
			AND			hist.id_local				=	?
			ORDER BY	hist.id_historial	DESC
		";

		$params	=	array(
			$id_local
		);

		$result	=	$this->db->getQuery($query,$params)->runQuery();

		if($result->getNumRows()>0){
			return	$result->getRows();
		}else{
			return	NULL;
		}
	}
}