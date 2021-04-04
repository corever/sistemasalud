<?php
/**
 ******************************************************************************
 * Sistema           : FARMACIA V2
 *
 * Descripcion       : Modelo para Tabla dt_solicitud_registro
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 08/05/2018
 *
 * @name             DAORegistroDT.php
 *
 * @version          1.0
 *
 * @author           Camila Figueroa
 *
 */
namespace App\Farmacias\Entity;

class DAORegistroDT extends \pan\Kore\Entity{

	protected $tabla_solicitud	 = TABLA_REGISTRO_DT;
	
	function __construct(){
		parent::__construct();
	}

	public function insertarSolicitudDT($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->tabla_solicitud."
								(
                                    gl_rut,
                                    gl_nombre,
                                    gl_apellido_paterno,
                                    gl_apellido_materno,
                                    gl_email,
                                    fc_nacimiento,
                                    id_profesion,
                                    nr_certificado_titulo,
                                    id_region_midas,
                                    id_comuna_midas,
                                    gl_direccion,
                                    gl_telefono,
                                    id_motivo_solicitud,
									gl_observacion,
									rut_farmacia,
									id_region_farmacia,
									json_farmacia,
									json_documentos,
									bo_solicitud,
									bo_asume,
									bo_cese,
									json_asume,
									json_cese,
									bo_declaracion

								)
								VALUES
								(
									?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }
        
        return $id;
    }

	
}
