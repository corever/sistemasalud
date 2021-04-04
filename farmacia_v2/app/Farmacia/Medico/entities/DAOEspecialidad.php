<?php
/**
 ******************************************************************************
 * Sistema           : FARMACIA
 *
 * Descripcion       : Modelo para especialidad de medico
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 08/09/2020
 *
 * @name             DAOEspecialidad.php
 *
 * @version          1.0
 *
 * @author           Camila Figueroa
 *
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				!cFecha		!cDescripcion
 * ---------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
namespace App\Farmacia\Medico\Entity;

class DAOEspecialidad extends \pan\Kore\Entity{

	const TOKEN_PERFIL_ADMINISTRADOR = "6e707064b948a2ab6ea7ab69513c0663ef70b3b9";
	const TOKEN_PERFIL_FISCALIZADOR = "ae5d153c8c746994b82710616b78a237f3294628";
	
	protected $tabla_medico			            	= TABLA_MEDICO;
	protected $tabla_especialidad			        = TABLA_ESPECIALIDAD;
	protected $tabla_usuario						= TABLA_ACCESO_USUARIO;
	protected $primary_key		            		= "mu_id";

	function __construct(){
		parent::__construct();
	}

	public function getLista(){

        $query	= "SELECT 
					especialidad_id     AS id_especialidad,
					especialidad_nombre AS gl_especialidad
				    FROM ".$this->tabla_especialidad."";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }
}


