<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Reportes
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 13/06/2018
 * 
 * @name             DAOInforme.php
 * 
 * @version          1.0
 *
 * @author           David Guzmán <david.guzman@cosof.cl>
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
class DAOInforme extends Model{

    protected $_tabla			= "mor_visita";
    protected $_primaria		= "id_visita";
    protected $_transaccional	= false;

    function __construct(){
        parent::__construct();
    }
    
/*=======================================================================================================================================================*/
/*==============================================================G R Á F I C O S==========================================================================*/
/*=======================================================================================================================================================*/
    
    /**
	 * Descripción : Obtener visitas para grafico estado
	 * @author  David Guzmán <david.guzman@cosof.cl> - 04/06/2018
     * @param   array $params 
	 */
    public function getGraficoEstado($params){
        $query	= "	SELECT 
                        sum(CASE visita.id_visita_estado 
							WHEN 1 THEN 1
							ELSE  0 END) AS estado_perdida,
                        sum(CASE visita.id_visita_estado 
							WHEN 2 THEN 1
							ELSE  0 END) AS estado_realizada,
                        sum(CASE visita.id_tipo_visita_resultado 
							WHEN 1 THEN 1
							ELSE  0 END) AS no_sospechoso,
                        sum(CASE visita.id_tipo_visita_resultado 
							WHEN 2 THEN 1
							ELSE  0 END) AS sospechoso,
                        sum(CASE visita.id_tipo_visita_resultado 
							WHEN 3 THEN 1
							ELSE  0 END) AS sin_datos,
                        sum(CASE visita.id_tipo_visita_resultado 
							WHEN 4 THEN 1
							ELSE  0 END) AS visita_perdida
                    FROM mor_visita visita
                    LEFT JOIN mor_expediente expediente ON visita.id_expediente = expediente.id_expediente
                    LEFT JOIN mor_establecimiento_salud establecimiento ON expediente.id_establecimiento = establecimiento.id_establecimiento
                    LEFT JOIN mor_direccion_comuna comuna_est ON establecimiento.id_comuna = comuna_est.id_comuna
                    #LEFT JOIN mor_visita_tipo_resultado resultado ON visita.id_tipo_visita_resultado = resultado.id_tipo_visita_resultado
					";

        if(!empty($params)){
            $and = " WHERE "; $join = ""; $where = "";
            if(isset($params['id_region'])){
                if($params['id_region'] > 0){
                    $where .= $and . "comuna_est.id_region = " . $params['id_region'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_oficina'])){
                if($params['id_oficina'] > 0){
                    $where .= $and . "(SELECT id_oficina FROM mor_direccion_oficina_comuna WHERE id_comuna = comuna_est.id_comuna LIMIT 1) = " . $params['id_oficina'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_comuna'])){
                if($params['id_comuna'] > 0){
                    $where .= $and . "comuna_est.id_comuna = " . $params['id_comuna'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_establecimiento'])){
                if(!empty($params['id_establecimiento'])){
                    $where .= $and . "establecimiento.id_establecimiento = " . $params['id_establecimiento'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_estado'])){
                if($params['id_estado'] > 0){
                    $where .= $and . "visita.id_visita_estado = " . $params['id_estado'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_resultado_visita'])){
                if($params['id_resultado_visita'] > 0){
                    $where .= $and . "visita.id_tipo_visita_resultado = " . $params['id_resultado_visita'];
                    $and = " AND ";
                }
            }
            if(isset($params['fc_inicio']) && isset($params['fc_termino'])){
                if(!empty($params['fc_inicio']) && !empty($params['fc_termino'])){
                    $where .= $and . "visita.fc_visita BETWEEN '" . $params['fc_inicio'] . "' AND '" . $params['fc_termino'] ."'";
                    $and = " AND ";
                }
            }
            //Add where a query
            $query .= $where;
        }
        
        $result	= $this->db->getQuery($query);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
    
    
/*=======================================================================================================================================================*/
/*==============================================================I N F O R M E S==========================================================================*/
/*=======================================================================================================================================================*/
    
    /**
	 * Descripción : Obtener visitas para informe
	 * @author  David Guzmán <david.guzman@cosof.cl> - 06/06/2018
     * @param   array $params 
	 */
    public function getInforme($params){
        $query	= "	SELECT 
                        COUNT(*) AS total_mordedores,
                        region_mordedor.id_region AS id_region,
                        region_mordedor.gl_nombre_region AS gl_region,
                        sum(CASE WHEN exp_mordedor.bo_domicilio_conocido = 1 THEN 1 ELSE 0 END) as nr_domicilio_conocido,
                        sum(CASE WHEN exp_mordedor.bo_domicilio_conocido = 0 THEN 1 ELSE 0 END) as nr_domicilio_desconocido,
                        sum(IF(animal_mordedor.gl_microchip != '' AND animal_mordedor.gl_microchip IS NOT NULL,1,0)) AS nr_chipeados
                    FROM mor_expediente_mordedor exp_mordedor
                    LEFT JOIN mor_direccion_region region_mordedor ON exp_mordedor.id_region_mordedor = region_mordedor.id_region
                    LEFT JOIN mor_animal_mordedor animal_mordedor ON exp_mordedor.id_mordedor = animal_mordedor.id_mordedor
                    LEFT JOIN mor_expediente expediente ON exp_mordedor.id_expediente = expediente.id_expediente
                    LEFT JOIN mor_direccion_comuna com ON com.id_comuna = expediente.id_comuna_mordedura
                    LEFT JOIN mor_direccion_oficina_comuna ofi_com ON ofi_com.id_comuna = com.id_comuna
                    LEFT JOIN mor_establecimiento_salud establecimiento ON expediente.id_establecimiento = establecimiento.id_establecimiento
					";

        if(!empty($params)){
            $and = " WHERE "; $where = "";
            if(isset($params['id_region'])){
                if($params['id_region'] > 0){
                    $where .= $and . "region_mordedor.id_region = " . $params['id_region'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_oficina'])){
                if($params['id_oficina'] > 0){
                    //$where .= $and . "(SELECT id_oficina FROM mor_direccion_oficina_comuna WHERE id_comuna = animal_mordedor.id_comuna LIMIT 1) = " . $params['id_oficina'];
                    $where .= $and . "ofi_com.id_oficina = " . $params['id_oficina'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_comuna'])){
                if($params['id_comuna'] > 0){
                    $where .= $and . "animal_mordedor.id_comuna = " . $params['id_comuna'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_establecimiento'])){
                if(!empty($params['id_establecimiento'])){
                    $where .= $and . "expediente.id_establecimiento = " . $params['id_establecimiento'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_estado'])){
                if($params['id_estado'] > 0){
                    $where .= $and . "exp_mordedor.id_expediente_mordedor_estado = " . $params['id_estado'];
                    $and = " AND ";
                }
            }
            if(isset($params['id_resultado_visita'])){
                if($params['id_resultado_visita'] > 0){
                    $where .= $and . "visita.id_tipo_visita_resultado = " . $params['id_resultado_visita'];
                    $and = " AND ";
                }
            }
            if(isset($params['fc_inicio']) && isset($params['fc_termino'])){
                if(!empty($params['fc_inicio']) && !empty($params['fc_termino'])){
                    $where .= $and . "expediente.fc_mordedura BETWEEN '" . $params['fc_inicio'] . "' AND '" . $params['fc_termino'] ."'";
                    $and = " AND ";
                }
            }
            
            //Add where a query
            $query .= $where;
        }
        
        if(isset($_SESSION[SESSION_BASE]['id_servicio']) && $_SESSION[SESSION_BASE]['id_servicio'] > 0){
            $query .= " $and (establecimiento.id_servicio = ".$_SESSION[SESSION_BASE]['id_servicio']." AND establecimiento.bo_publica = 1)";
        }
        
        $query .= " GROUP BY exp_mordedor.id_region_mordedor 
                    ORDER BY exp_mordedor.id_region_mordedor";
        
        $result	= $this->db->getQuery($query);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

}

?>