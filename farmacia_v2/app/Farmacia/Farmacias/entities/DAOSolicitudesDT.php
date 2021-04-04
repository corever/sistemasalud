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


namespace App\Farmacia\Farmacias\Entity;

class DAOSolicitudesDT extends \pan\Kore\Entity{

	protected $tabla_solicitudes	 = TABLA_REGISTRO_DT;
	
	function __construct(){
		parent::__construct();
	}


	    /**
	* Descripción : Obtener Lista de Solicitudes
	* @author  Camila Figueroa
	* @return  array  Información de solicitudes
	*/
	public function getListaSolicitudes($params){
        $param  = array();
        $where  = " WHERE ";
		$query	= " SELECT						
						*	
					FROM  ".$this->tabla_solicitudes."  solicitudes
                    ";

        if (!empty($params)) {
            if (isset($params['id_estado']) && intval($params['id_estado']) > 0) {
                $query      .= "$where solicitudes.bo_declaracion = ?";
                $param[]    = intval($params['id_estado']);
				$where      = " AND ";				
			}
			
			if (isset($params['gl_tipo']) && ($params['gl_tipo']) == "ASUME") {
                $query      .= "$where solicitudes.bo_asume = 1";                
				$where      = " AND ";				
            }

			if (isset($params['gl_tipo']) && ($params['gl_tipo']) == "CESE") {
                $query      .= "$where solicitudes.bo_cese = 1";                
				$where      = " AND ";				
			}
			
        }

		$result	= $this->db->getQuery($query,$param)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}
	
}
