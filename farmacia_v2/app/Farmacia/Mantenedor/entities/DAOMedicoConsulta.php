<?php
/**
 ******************************************************************************
 * Sistema           : SUMARIOS V1
 *
 * Descripcion       : Modelo para Tabla medico_sucursal
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 26/08/2020
 *
 * @name             DAOMedicoConsulta.php
 *
 * @version          1.0
 *
 * @author           Felipe Bocaz <felipe.bocaz@cosof.cl>
 *
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				!cFecha		!cDescripcion
 * ---------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
namespace App\Farmacia\Mantenedor\Entity;

class DAOMedicoConsulta extends \pan\Kore\Entity{


	protected $table			            = TABLA_SUCURSAL_MEDICO;
	protected $primary_key		            = "id_sxm";

	function __construct(){
		parent::__construct();
	}

	public function insertSucursal($params) {

			$id     = false;
			$query  = "INSERT INTO ".$this->table."
							(
																	id_medico,
																	id_region,
																	id_comuna,
																	direccion_sucursal,
																	fono_codigo,
																	fono,
																	fc_creacion,
																	bo_estado
							)
							VALUES
							(
								?,?,?,?,?,?,now(),?
							)";

	if($this->db->execQuery($query,$params)){
					$id = $this->db->getLastId();
			}

			return $id;
	}

public function getListaSucursalMedico($gl_token){

	$query	= " SELECT

					sucursal.id_sxm AS id_sucursal,
					sucursal.id_medico AS id_token,
					region.nombre_region_corto AS gl_region,
					comuna.comuna_nombre AS gl_comuna,
					sucursal.direccion_sucursal AS gl_direccion,
					codfono.codigo AS id_codfono,
					sucursal.fono AS gl_telefono,
					sucursal.bo_estado AS bo_activo

					FROM    ".$this->table." sucursal
					LEFT JOIN ".TABLA_MEDICO." medico ON sucursal.id_medico = medico.id_medico
					LEFT JOIN ".TABLA_DIRECCION_REGION." region ON sucursal.id_region = region.region_id
					LEFT JOIN ".TABLA_DIRECCION_COMUNA." comuna ON sucursal.id_comuna = comuna.comuna_id
					LEFT JOIN ".TABLA_CODIGO_REGION." codfono ON sucursal.fono_codigo = codfono.codfono_id
					where medico.fk_usuario = '".$gl_token."'";

	$result	= $this->db->getQuery($query)->runQuery();

	if($result->getNumRows()>0){
					return $result->getRows();
	}else{
					return NULL;
	}
}

public function modificarSucursal($gl_token,$params){
	$query	= "	UPDATE ".$this->table."
					SET
						medico_nombre              	= ?,
						medico_apellidopat			   	= ?,
						medico_apellidomat		    	= ?,
						medico_gen		            	= ?,
						medico_fecha_nacimiento		 	= ?,
						medico_correo								= ?,
						id_region_midas         					= ?,
						id_comuna_midas					         	= ?,
						direccion_medico						= ?,
						fono_codigo									= ?,
						fono						            = ?
					WHERE fk_usuario = '$gl_token'";

	$resp	= $this->db->execQuery($query, $params);

	return $resp;
}

public function setActivoByTokenSucursal($gl_token,$bo_activo){
	$query	= "	UPDATE ".$this->table."
				SET bo_estado = ?
				WHERE id_sxm = ? ";
	$param	= array($bo_activo,$gl_token);
	$resp	= $this->db->execQuery($query, $param);

	return $resp;
}


}
