<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_expediente_mordedor
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 16/05/2018
 * 
 * @name             DAOExpedienteMordedor.php
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
class DAOExpedienteMordedor extends Model{

    protected $_tabla           = "mor_expediente_mordedor";
    protected $_primaria		= "id_expediente_mordedor";
    protected $_transaccional	= false;

    function __construct()
    {
        parent::__construct();
    }

    public function getLista(){
        $query	= "	SELECT * FROM ".$this->_tabla;
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    public function getByFolio($gl_folio_mordedor){
        $query	= "	SELECT 
                        *
                    FROM ".$this->_tabla."
					WHERE gl_folio_mordedor = ?";

		$param	= array($gl_folio_mordedor);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getGraficoReportes($params = array()){
        
        $query  = " SELECT
                        sum(CASE WHEN em.bo_domicilio_conocido = 1 THEN 1 ELSE 0 END) as 'Conocido',
                        sum(CASE WHEN em.bo_domicilio_conocido = 0 THEN 1 ELSE 0 END) as 'No Conocido'
                    FROM mor_expediente_mordedor em
                        LEFT JOIN mor_expediente ex ON ex.id_expediente = em.id_expediente
                        LEFT JOIN mor_visita v ON (v.id_expediente = ex.id_expediente
                                                    AND v.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE mor_visita.id_expediente = ex.id_expediente))
                        LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = ex.id_establecimiento
                        LEFT JOIN mor_direccion_comuna com ON com.id_comuna = em.id_comuna_mordedor
                        #LEFT JOIN mor_direccion_oficina_comuna ofi_com ON ofi_com.id_comuna = com.id_comuna
                ";
        
        $arr_query  = $this->filtrosReportes($query,$params);        
        $query      = $arr_query[0];
        $param_list = $arr_query[1];
        $id_perfil	= $_SESSION[SESSION_BASE]['perfil'];
        
        $where  = (strpos($query,'WHERE') !== false)?" AND ":" WHERE ";
        
        $result     = $this->db->getQuery($query,$param_list);
        //print_r($this->db->getQueryString($query,$param_list));die;
        if($result->numRows>0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getGraficoNotificaciones($params = array()){
        
        $query  = " SELECT
                        sum(CASE WHEN em.bo_domicilio_conocido = 1 THEN 1 ELSE 0 END) as 'Conocido',
                        sum(CASE WHEN em.bo_domicilio_conocido = 0 THEN 1 ELSE 0 END) as 'No Conocido'
                    FROM mor_expediente_mordedor em
                        LEFT JOIN mor_expediente ex ON ex.id_expediente = em.id_expediente
                        LEFT JOIN mor_visita v ON (v.id_expediente = ex.id_expediente
                                                    AND v.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE mor_visita.id_expediente = ex.id_expediente))
                        LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = ex.id_establecimiento
                ";
        
        $arr_query  = $this->filtrosReportes($query,$params);        
        $query      = $arr_query[0];
        $param_list = $arr_query[1];
        $id_perfil	= $_SESSION[SESSION_BASE]['perfil'];
        
        $where  = (strpos($query,'WHERE') !== false)?" AND ":" WHERE ";
        
        if(isset($params['id_fiscalizador']) && $params['id_fiscalizador']>0){ // con FISCALIZADOR
            $query .= " $where ex.id_expediente_estado IN (6,7,14) ";
        }else{
            $query .= " $where ((DATEDIFF(CURDATE(),ex.fc_mordedura) >= 15 AND ex.id_expediente_estado IN (1,6,9,14))
                            OR (DATEDIFF(CURDATE(),ex.fc_mordedura) < 15 AND ex.id_expediente_estado IN (1,6,7,9,11)))";

            //Si es perfil Administrativo busca Sin Dirección
            if(isset($id_perfil) && $id_perfil == 12){
                $query .= " AND em.bo_domicilio_conocido = 0 AND ex.id_expediente_estado != 3";
            }elseif($id_perfil != 3){ //Muestra los Con Dirección (excepto para perfil Establecimiento de Salud = ve todos los de el)
                $query .= " AND em.bo_domicilio_conocido = 1 AND ex.id_expediente_estado != 3";
            }
        }
        
        $result     = $this->db->getQuery($query,$param_list);
        //print_r($this->db->getQueryString($query,$param_list));die;
        //print_r($result->rows->row_0);die;
        if($result->numRows>0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getNumeroNotificaciones($params = array()){
        
        $query  = " SELECT
                        count(distinct ex.id_expediente) as 'cantidad'
                    FROM mor_expediente_mordedor em
                        LEFT JOIN mor_expediente ex ON ex.id_expediente = em.id_expediente
                        LEFT JOIN mor_visita v ON (v.id_expediente = ex.id_expediente
                                                    AND v.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE mor_visita.id_expediente = ex.id_expediente))
                        LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = ex.id_establecimiento
                        #LEFT JOIN mor_direccion_oficina_comuna ofi_com ON ofi_com.id_comuna = ex.id_comuna_mordedura
                ";
        
        $arr_query  = $this->filtrosReportes($query,$params);        
        $query      = $arr_query[0];
        $param_list = $arr_query[1];
        $id_perfil	= $_SESSION[SESSION_BASE]['perfil'];
        
        $where  = (strpos($query,'WHERE') !== false)?" AND ":" WHERE ";
        
        if(isset($params['id_fiscalizador']) && $params['id_fiscalizador']>0){ // con FISCALIZADOR
            $query .= " $where ex.id_expediente_estado IN (6,7,14) ";
        }elseif($id_perfil == 3 || $id_perfil == 7){
            $query .= " $where (DATEDIFF(CURDATE(),ex.fc_mordedura) < 15 AND ex.id_expediente_estado IN (1,6,7,9,11))";
            
        }else{
            //Si es perfil Administrativo busca Sin Dirección
            $query_extra = "";
            if(isset($id_perfil) && $id_perfil == 12){
                $query_extra = " AND em.bo_domicilio_conocido = 0";
            }elseif($id_perfil != 3){ //Muestra los Con Dirección (excepto para perfil Establecimiento de Salud = ve todos los de el)
                $query_extra = " AND em.bo_domicilio_conocido = 1";
            }
            $query_extra2 = "";
            if($id_perfil == 1 || $id_perfil == 5 || $id_perfil == 10 || $id_perfil == 12 || $id_perfil == 13){
                $query_extra2 = " AND em.bo_domicilio_conocido = 1";
            }
            
            $query .= " $where ((DATEDIFF(CURDATE(),ex.fc_mordedura) >= 15 AND ex.id_expediente_estado IN (1,6,9,14) $query_extra2)
                            OR (DATEDIFF(CURDATE(),ex.fc_mordedura) < 15 AND ex.id_expediente_estado IN (1,6,7,9,11) $query_extra))";
            
            if($id_perfil == 1 || $id_perfil == 5 || $id_perfil == 10 || $id_perfil == 12){
                $query .= " AND id_animal_grupo = 3";
            }
            
        }
        
        $result     = $this->db->getQuery($query,$param_list);
        //print_r($this->db->getQueryString($query,$param_list));die;
        //print_r($result->rows->row_0);die;
        if($result->numRows>0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getNotificacionesComunal($params = array()){
        
        $query  = " SELECT
                        com.id_comuna AS id_comuna,
                        com.gl_nombre_comuna AS comuna,
                        sum(CASE WHEN em.bo_domicilio_conocido = 1 THEN 1 ELSE 0 END) as 'Conocido',
                        sum(CASE WHEN em.bo_domicilio_conocido = 0 THEN 1 ELSE 0 END) as 'No Conocido'
                    FROM mor_expediente_mordedor em
                        LEFT JOIN mor_expediente ex ON ex.id_expediente = em.id_expediente
                        LEFT JOIN mor_visita v ON (v.id_expediente = ex.id_expediente
                                                    AND v.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE mor_visita.id_expediente = ex.id_expediente))
                        LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = ex.id_establecimiento
                        LEFT JOIN mor_direccion_comuna com ON com.id_comuna = ex.id_comuna_mordedura
                        #LEFT JOIN mor_direccion_oficina_comuna ofi_com ON ofi_com.id_comuna = com.id_comuna
                ";
        
        $arr_query  = $this->filtrosReportes($query,$params);        
        $query      = $arr_query[0];
        $param_list = $arr_query[1];
        $id_perfil	= $_SESSION[SESSION_BASE]['perfil'];
        
        $where  = (strpos($query,'WHERE') !== false)?" AND ":" WHERE ";
        
        $query .= " GROUP BY com.id_comuna";
        
        $result     = $this->db->getQuery($query,$param_list);
        //print_r($this->db->getQueryString($query,$param_list));die;
        //print_r($result->rows->row_0);die;
        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getNotificacionesRegional($params = array()){
        
        $query  = " SELECT
                        reg.id_region AS id_region,
                        reg.nr_orden_territorial AS numero_region,
                        reg.gl_nombre_region AS region,
                        sum(CASE WHEN em.bo_domicilio_conocido = 1 THEN 1 ELSE 0 END) as 'Conocido',
                        sum(CASE WHEN em.bo_domicilio_conocido = 0 THEN 1 ELSE 0 END) as 'No Conocido'
                    FROM mor_expediente_mordedor em
                        LEFT JOIN mor_expediente ex ON ex.id_expediente = em.id_expediente
                        LEFT JOIN mor_visita v ON (v.id_expediente = ex.id_expediente
                                                    AND v.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE mor_visita.id_expediente = ex.id_expediente))
                        LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = ex.id_establecimiento
                        LEFT JOIN mor_direccion_region reg ON reg.id_region = ex.id_region_mordedura
                ";
        
        $arr_query  = $this->filtrosReportes($query,$params);        
        $query      = $arr_query[0];
        $param_list = $arr_query[1];
        $id_perfil	= $_SESSION[SESSION_BASE]['perfil'];
        
        $where  = (strpos($query,'WHERE') !== false)?" AND ":" WHERE ";
        
        if(isset($params['id_fiscalizador']) && $params['id_fiscalizador']>0){ // con FISCALIZADOR
            $query .= " $where ex.id_expediente_estado IN (6,7,14) ";
        }else{
            $query .= " $where ((DATEDIFF(CURDATE(),ex.fc_mordedura) >= 15 AND ex.id_expediente_estado IN (1,6,9,14))
                            OR (DATEDIFF(CURDATE(),ex.fc_mordedura) < 15 AND ex.id_expediente_estado IN (1,6,7,9,11)))";

            //Si es perfil Administrativo busca Sin Dirección
            if(isset($id_perfil) && $id_perfil == 12){
                $query .= " AND em.bo_domicilio_conocido = 0 AND ex.id_expediente_estado != 3";
            }elseif($id_perfil != 3){ //Muestra los Con Dirección (excepto para perfil Establecimiento de Salud = ve todos los de el)
                $query .= " AND em.bo_domicilio_conocido = 1 AND ex.id_expediente_estado != 3";
            }
        }
        
        $query .= " GROUP BY reg.id_region";
        $result = $this->db->getQuery($query,$param_list);
        
        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getGraficoVisitasRealizadas($params = array()){

        $query  = " SELECT
                        sum(CASE WHEN v.id_tipo_visita_resultado = 1 THEN 1 ELSE 0 END) as 'No Sospechoso',
                        sum(CASE WHEN v.id_tipo_visita_resultado = 2 THEN 1 ELSE 0 END) as 'Sospechoso',
                        sum(CASE WHEN (v.id_tipo_visita_perdida > 0 AND v.id_tipo_visita_perdida != 1)
                            OR (vam.id_tipo_visita_perdida > 0 AND em.id_mordedor = vam.id_mordedor AND vam.id_tipo_visita_perdida != 1) THEN 1 ELSE 0 END) as 'Visita Perdida',
                        sum(CASE WHEN v.id_tipo_visita_resultado = 5
                            OR (vam.id_tipo_visita_resultado = 5 AND em.id_mordedor = vam.id_mordedor) THEN 1 ELSE 0 END) as 'Se Niega a Visita',
                        sum(CASE WHEN em.bo_domicilio_conocido = 1 AND v.id_visita IS NULL THEN 1 ELSE 0 END) as 'No Realizadas'
                        #count(DISTINCT em.id_expediente) as cant_total
                    FROM mor_expediente_mordedor em
                        LEFT JOIN mor_expediente ex ON ex.id_expediente = em.id_expediente
                        LEFT JOIN mor_visita v ON (v.id_expediente = ex.id_expediente
                                                    AND v.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE mor_visita.id_expediente = ex.id_expediente))
                        LEFT JOIN mor_visita_animal_mordedor vam ON 
                                (v.id_visita = vam.id_visita AND vam.id_visita_mordedor = (SELECT MAX(id_visita_mordedor) FROM mor_visita_animal_mordedor WHERE id_visita = v.id_visita))
                        LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = ex.id_establecimiento
                        #LEFT JOIN mor_direccion_oficina_comuna ofi_com ON ofi_com.id_comuna = ex.id_comuna_mordedura
                ";
        
        $arr_query  = $this->filtrosReportes($query,$params);
        $query      = $arr_query[0];
        $param_list = $arr_query[1];
        
        $where  = (strpos($query,'WHERE') !== false)?" AND ":" WHERE ";
        //$query .= " $where v.id_visita IS NOT NULL AND ex.id_expediente_estado != 3";
        //$query .= " $where v.id_visita IS NOT NULL";
        
        $result = $this->db->getQuery($query,$param_list);
        
        if($result->numRows>0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getVisitasComunal($params = array()){

        $query  = " SELECT
                        com.id_comuna AS id_comuna,
                        com.gl_nombre_comuna AS comuna,
                        sum(CASE WHEN vam.id_tipo_resultado_isp = 1 AND em.id_mordedor = vam.id_mordedor THEN 1 ELSE 0 END) as 'Positivo',
                        sum(CASE WHEN vam.id_tipo_resultado_isp = 2 AND em.id_mordedor = vam.id_mordedor THEN 1 ELSE 0 END) as 'Negativo',
                        sum(CASE WHEN vam.id_tipo_visita_resultado = 1 AND em.id_mordedor = vam.id_mordedor THEN 1 ELSE 0 END) as 'No Sospechoso',
                        sum(CASE WHEN vam.id_tipo_visita_resultado = 2 AND em.id_mordedor = vam.id_mordedor THEN 1 ELSE 0 END) as 'Sospechoso',
                        sum(CASE WHEN (v.id_tipo_visita_perdida > 0 AND v.id_tipo_visita_perdida != 1)
                            OR (vam.id_tipo_visita_perdida > 0 AND em.id_mordedor = vam.id_mordedor AND vam.id_tipo_visita_perdida != 1) THEN 1 ELSE 0 END) as 'Visita Perdida',
                        sum(CASE WHEN v.id_tipo_visita_resultado = 5
                            OR (vam.id_tipo_visita_resultado = 5 AND em.id_mordedor = vam.id_mordedor) THEN 1 ELSE 0 END) as 'Se Niega a Visita',
                        count(DISTINCT em.id_expediente) as cant_total
                    FROM mor_expediente_mordedor em
                        LEFT JOIN mor_expediente ex ON ex.id_expediente = em.id_expediente
                        LEFT JOIN mor_visita v ON v.id_expediente = ex.id_expediente
                        LEFT JOIN mor_visita_animal_mordedor vam ON v.id_visita = vam.id_visita
                        LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = ex.id_establecimiento
                        LEFT JOIN mor_direccion_comuna com ON com.id_comuna = ex.id_comuna_mordedura
                        #LEFT JOIN mor_direccion_oficina_comuna ofi_com ON ofi_com.id_comuna = com.id_comuna
                ";
        
        $arr_query  = $this->filtrosReportes($query,$params);
        $query      = $arr_query[0];
        $param_list = $arr_query[1];
        
        $where  = (strpos($query,'WHERE') !== false)?" AND ":" WHERE ";
        //$query .= " $where v.id_visita IS NOT NULL AND ex.id_expediente_estado != 3";
        $query .= " $where v.id_visita IS NOT NULL";
        $query .= " GROUP BY com.id_comuna";
        
        $result     = $this->db->getQuery($query,$param_list);
        
        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    public function filtrosReportes($query,$params){
        $where = " WHERE ";
        $query_list = array();
        $param_list = array();
        $id_perfil  = $_SESSION[SESSION_BASE]['perfil'];
        $id_comuna  = $_SESSION[SESSION_BASE]['id_comuna'];
        if(!empty($params)){
            if(!empty($params['id_establecimiento'])){
                $query_list[] = "ex.id_establecimiento = ?";
                $param_list  = array_merge($param_list,array(intval($params['id_establecimiento'])));
            }

            if(!empty($params['id_region'])){
                $query_administrativo = "";
                if($id_perfil == 12 || $id_perfil == 13 || $id_perfil == 15){ //PERFIL ADMINISTRATIVO o COMUNAL o SERVICIO SALUD
                    $query_administrativo = "OR es.id_region = ".intval($params['id_region'])." ";
                }
                /*else{
                    $query_administrativo = "OR ".intval($params['id_region'])." = ex.id_region_mordedura";
                }*/
                $query_list[] = "(em.id_region_mordedor = ".intval($params['id_region'])." $query_administrativo)";
            }

            if(!empty($params['id_region_establecimiento'])){
                $query_list[] = "es.id_region = ?";
                $param_list  = array_merge($param_list,array(intval($params['id_region_establecimiento'])));
            }
            elseif(!empty($params['in_establecimiento'])){
                $query_list[] = "ex.id_establecimiento IN (".$params['in_establecimiento'].")";
            }
            if(!empty($params['id_servicio'])){
                $query_list[] = "(es.id_servicio = ?)";
                $param_list	= array_merge($param_list,array(intval($params['id_servicio'])));
            }

            if(!empty($params['id_comuna'])){
                $query_comunal  = "";
                if($id_perfil == 13 || $id_perfil == 15){ //PERFIL COMUNAL o SERVICIO SALUD
                    $query_list[] = "es.id_comuna = ".intval($params['id_comuna']);
                }else{
                    $query_list[] = "(#ex.id_comuna_mordedura = ".intval($params['id_comuna'])." OR
                                      #es.id_comuna = ".intval($params['id_comuna'])." OR
                                      ex.id_expediente IN (SELECT mor_expediente_mordedor.id_expediente
                                                            FROM mor_expediente_mordedor
                                                            LEFT JOIN mor_animal_mordedor ON mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                            WHERE mor_expediente_mordedor.id_expediente = ex.id_expediente
                                                            AND (mor_animal_mordedor.id_comuna = ".intval($params['id_comuna'])."
                                                            OR mor_expediente_mordedor.id_comuna_mordedor = ".intval($params['id_comuna']).")) $query_comunal)";
                }
            }

            if(!empty($params['id_fiscalizador'])){
                $query_list[] = "(em.id_fiscalizador = ".intval($params['id_fiscalizador'])." OR em.id_fiscalizador_microchip = ".intval($params['id_fiscalizador']).")";
            }

            if(!empty($params['id_estado'])){
                $query_list[] = "(ex.id_expediente_estado = ".intval($params['id_estado'])." OR em.id_expediente_mordedor_estado = ".intval($params['id_estado']).")";
            }
            
            if(isset($params['id_resultado_visita']) && !empty($params['id_resultado_visita'])){
                if($params['id_resultado_visita'] == 4){
                    $query_list[] = "v.id_tipo_visita_resultado = ".intval($params['id_resultado_visita'])
                                    . " AND 1 NOT IN (SELECT id_tipo_visita_perdida FROM mor_visita_animal_mordedor WHERE id_visita = v.id_visita)";
                }else{
                    $query_list[] = "v.id_tipo_visita_resultado = ".intval($params['id_resultado_visita']);
                }
            }

            if(!empty($params['id_oficina']) && ($params['bo_domicilio_conocido'] == "" || $params['bo_domicilio_conocido'] == 1)){
                $query_domicilio    = "";
                if($params['bo_domicilio_conocido'] == ""){ //Si es Todos (SI y NO domicilio conocido)
                    $query_domicilio = "OR ex.id_expediente IN (SELECT id_expediente FROM mor_expediente_mordedor
                                                            WHERE bo_domicilio_conocido = 0 AND ex.id_expediente = id_expediente)";
                }
                if($id_perfil == 13 || $id_perfil == 15){ //PERFIL COMUNAL o SERVICIO SALUD
                    $query_list[] = "(es.id_comuna = ".intval($params['id_comuna'])." $query_domicilio)";
                }else{
                    $query_list[] = "( ex.id_expediente IN (SELECT em3.id_expediente
                                                            FROM mor_animal_mordedor
                                                            LEFT JOIN mor_expediente_mordedor em3 ON em3.id_mordedor = mor_animal_mordedor.id_mordedor
                                                            LEFT JOIN mor_direccion_oficina_comuna oficina_comuna1 ON oficina_comuna1.id_comuna = mor_animal_mordedor.id_comuna
                                                                WHERE oficina_comuna1.id_oficina = ?) OR
                                        ex.id_expediente IN (SELECT em4.id_expediente
                                                            FROM mor_expediente_mordedor em4
                                                            LEFT JOIN mor_direccion_oficina_comuna oficina_comuna2 ON oficina_comuna2.id_comuna = em4.id_comuna_mordedor
                                                                WHERE oficina_comuna2.id_oficina = ?) $query_domicilio)";
                    $param_list	= array_merge($param_list,array(intval($params['id_oficina'])));
                    $param_list	= array_merge($param_list,array(intval($params['id_oficina'])));
                }
            }
            if(!empty($params['fc_inicio']) && !empty($params['fc_termino'])){
                $query_list[] .= " ex.fc_mordedura BETWEEN ".Fechas::formatearBaseDatos($params['fc_inicio'])." AND ".Fechas::formatearBaseDatos($params['fc_termino']);
            }
            else if(!empty($params['fc_inicio'])){
                $query_list[] .= " ex.fc_mordedura >= ".Fechas::formatearBaseDatos($params['fc_inicio']);
            }
            else if(!empty($params['fc_termino'])){
                $query_list[] .= " ex.fc_mordedura <= ".Fechas::formatearBaseDatos($params['fc_termino']);
            }
            if(isset($params['bo_domicilio_conocido']) && $params['bo_domicilio_conocido'] != ""){
                $query_list[]   = " ? = em.bo_domicilio_conocido";
                $param_list     = array_merge($param_list,array(intval($params['bo_domicilio_conocido'])));
            }
            if(isset($params['bo_mes_actual'])){
                $query_list[]   .= " MONTH(ex.fc_mordedura) = MONTH(CURDATE())";
            }
        }
        
        /*
        if(isset($_SESSION[SESSION_BASE]['id_servicio']) && $_SESSION[SESSION_BASE]['id_servicio'] > 0){
            $query_list[]   = "(es.id_servicio = ".$_SESSION[SESSION_BASE]['id_servicio']." AND es.bo_publica = 1)";
        }
        */
        
        if($id_perfil == 15){
            $query_list[]   = "(es.id_servicio = ".$_SESSION[SESSION_BASE]['id_servicio'].")";
        }
        
        if($id_perfil == 13){ //COMUNAL
            $query_list[]   = "(es.id_comuna = ".intval($id_comuna).")";
        }
        
        $query_list[]   = "ex.id_expediente_estado != 17";
        
        if(!empty($query_list)){
            $query .= $where . implode(" AND ", $query_list);
        }
        
        //$query .= " GROUP BY ex.id_expediente";
        return array($query,$param_list);
    }
    

    public function getReporteVisitas($params = array()){
    	//TODO: tengo 320 mordedores sin comuna
    	 $query  = " SELECT
                        reg.id_region AS id_region,
                        reg.nr_orden_territorial AS numero_region,
                        reg.gl_nombre_region AS region,
                        com.id_comuna AS id_comuna,
                        com.gl_nombre_comuna AS comuna,
                        ofi.id_oficina AS id_oficina,
                        ofi.gl_nombre_oficina AS oficina,
                        sum(IF(animal_mordedor.gl_microchip != '' AND animal_mordedor.gl_microchip IS NOT NULL,1,0)) AS nr_chipeados,
                        sum(CASE WHEN em.bo_domicilio_conocido = 1 THEN 1 ELSE 0 END) as conocido,
                        sum(CASE WHEN em.bo_domicilio_conocido = 0 THEN 1 ELSE 0 END) as no_conocido,
                        sum(CASE WHEN vam.id_tipo_resultado_isp = 1 AND em.id_mordedor = vam.id_mordedor THEN 1 ELSE 0 END) as 'Positivo',
                        sum(CASE WHEN vam.id_tipo_resultado_isp = 2 AND em.id_mordedor = vam.id_mordedor THEN 1 ELSE 0 END) as 'Negativo',
                        sum(CASE WHEN v.id_tipo_visita_resultado = 1 THEN 1 ELSE 0 END) as 'No Sospechoso',
                        sum(CASE WHEN v.id_tipo_visita_resultado = 2 THEN 1 ELSE 0 END) as 'Sospechoso',
                        sum(CASE WHEN (v.id_tipo_visita_perdida > 0 AND v.id_tipo_visita_perdida != 1)
                            OR (vam.id_tipo_visita_perdida > 0 AND em.id_mordedor = vam.id_mordedor AND vam.id_tipo_visita_perdida != 1) THEN 1 ELSE 0 END) as 'Visita Perdida',
                        sum(CASE WHEN v.id_tipo_visita_resultado = 5
                            OR (vam.id_tipo_visita_resultado = 5 AND em.id_mordedor = vam.id_mordedor) THEN 1 ELSE 0 END) as 'Se Niega a Visita',
                        count(1) as cant_total
                        #,count(DISTINCT em.id_expediente) as cant_total
                    FROM mor_expediente_mordedor em
                		LEFT JOIN mor_animal_mordedor animal_mordedor ON em.id_mordedor = animal_mordedor.id_mordedor
                        LEFT JOIN mor_expediente ex ON ex.id_expediente = em.id_expediente
                    	#LEFT JOIN mor_expediente_estado estado ON ex.id_expediente_estado = estado.id_expediente_estado
                        LEFT JOIN mor_visita v ON (v.id_expediente = ex.id_expediente
                                                    AND v.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE mor_visita.id_expediente = ex.id_expediente))
                        LEFT JOIN mor_visita_animal_mordedor vam ON 
                                (v.id_visita = vam.id_visita AND vam.id_visita_mordedor = (SELECT MAX(id_visita_mordedor) FROM mor_visita_animal_mordedor WHERE id_visita = v.id_visita))
                        LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = ex.id_establecimiento
                        #LEFT JOIN mor_direccion_region reg ON reg.id_region = ex.id_region_mordedura
                        LEFT JOIN mor_direccion_region reg ON reg.id_region = em.id_region_mordedor
                        LEFT JOIN mor_direccion_region reg_mor ON reg_mor.id_region = animal_mordedor.id_region
                        #LEFT JOIN mor_direccion_comuna com ON com.id_comuna = ex.id_comuna_mordedura
                        LEFT JOIN mor_direccion_comuna com ON com.id_comuna = em.id_comuna_mordedor
                        LEFT JOIN mor_direccion_comuna com_mor ON com_mor.id_comuna = animal_mordedor.id_comuna
                        LEFT JOIN mor_direccion_oficina_comuna ofi_com ON (ofi_com.id_comuna = com.id_comuna
                                AND ofi_com.id_oficina_comuna = (SELECT MAX(id_oficina_comuna) FROM mor_direccion_oficina_comuna WHERE id_comuna = com.id_comuna))
                        #LEFT JOIN mor_direccion_oficina_comuna ofi_com_mor ON ofi_com_mor.id_comuna = com_mor.id_comuna
                        LEFT JOIN mor_direccion_oficina ofi ON ofi.id_oficina = ofi_com.id_oficina
                ";

        $where = " WHERE ";
        $query_list = array();
        $id_perfil  = $_SESSION[SESSION_BASE]['perfil'];
        $id_comuna  = $_SESSION[SESSION_BASE]['id_comuna'];

        if(!empty($params)){
            if(isset($params['id_region']) && !empty($params['id_region'])){
            	//TODO: si agrupo por region, este filtro hace que no se agrupe por region exactamente
            	$query_administrativo = "";
                if($id_perfil == 12 || $id_perfil == 13 || $id_perfil == 15){ //PERFIL ADMINISTRATIVO o COMUNAL o SERVICIO SALUD
                    $query_administrativo = "OR es.id_region = ".intval($params['id_region'])." ";
                }
                /*else{
                    $query_administrativo = "OR ex.id_region_mordedura = ".intval($params['id_region']);
                }*/
                //$query_list[] = "(em.id_region_mordedor = ".intval($params['id_region'])." $query_administrativo)";
                $query_list[] = "(
                					(reg.id_region = ".intval($params['id_region'])." $query_administrativo) 
                					OR (reg_mor.id_region = ".intval($params['id_region']).")
                				)";
            }
            
            if(isset($params['id_comuna']) && !empty($params['id_comuna'])){
                if($id_perfil == 13 || $id_perfil == 15){ //PERFIL COMUNAL o SERVICIO SALUD
                    $query_list[] = "es.id_comuna = ".intval($params['id_comuna']);
                }else{
                    //$query_list[] = "em.id_comuna_mordedor = " . intval($params['id_comuna']);
                    $query_list[] = "(com.id_comuna = ".intval($params['id_comuna'])." 
                                      OR com_mor.id_comuna = ".intval($params['id_comuna']).")";
                }
            }

            if(isset($params['id_oficina']) && !empty($params['id_oficina']) && ($params['bo_domicilio_conocido'] == "" || $params['bo_domicilio_conocido'] == 1)){
                $query_domicilio    = "";
                if($params['bo_domicilio_conocido'] == ""){ //Si es Todos (SI y NO domicilio conocido)
                    $query_domicilio = "OR em.bo_domicilio_conocido = 0";
                }
                if($id_perfil == 13 || $id_perfil == 15){ //PERFIL COMUNAL o SERVICIO SALUD
                    $query_list[] = "(es.id_comuna = ".intval($params['id_comuna'])." $query_domicilio)";
                }else{
                    //$query_list[] = "ofi_com.id_oficina = " . $params['id_oficina'];
                    $query_list[] = "( ex.id_expediente IN (SELECT em3.id_expediente
                                                            FROM mor_animal_mordedor
                                                            LEFT JOIN mor_expediente_mordedor em3 ON em3.id_mordedor = mor_animal_mordedor.id_mordedor
                                                            LEFT JOIN mor_direccion_oficina_comuna oficina_comuna1 ON oficina_comuna1.id_comuna = mor_animal_mordedor.id_comuna
                                                                WHERE oficina_comuna1.id_oficina = ".intval($params['id_oficina'])." ) OR
                                        ex.id_expediente IN (SELECT em4.id_expediente
                                                            FROM mor_expediente_mordedor em4
                                                            LEFT JOIN mor_direccion_oficina_comuna oficina_comuna2 ON oficina_comuna2.id_comuna = em4.id_comuna_mordedor
                                                                WHERE oficina_comuna2.id_oficina = ".intval($params['id_oficina'])." ) $query_domicilio)";
                    /*$query_list[] = "(ofi_com.id_oficina = ".intval($params['id_oficina'])." 
                                      OR ofi_com_mor.id_oficina = ".intval($params['id_oficina'])." $query_domicilio $query_comunal)";*/
                }
            }

            if(isset($params['id_establecimiento']) && !empty($params['id_establecimiento'])){
				$query_list[] = "ex.id_establecimiento = " . $params['id_establecimiento'];
            }
            elseif(!empty($params['in_establecimiento'])){
                $query_list[] = "ex.id_establecimiento IN (".$params['in_establecimiento'].")";
            }
            
            if(!empty($params['id_servicio'])){
                $query_list[] = "(es.id_servicio = ".intval($params['id_servicio']).")";
            }
            
            if(!empty($params['id_region_establecimiento'])){
                $query_list[] = "es.id_region = ".intval($params['id_region_establecimiento']);
            }

            if(isset($params['id_estado']) && !empty($params['id_estado'])){
                $query_list[] = "em.id_expediente_mordedor_estado = ".intval($params['id_estado']).")";
            }

            if(isset($params['id_resultado_visita']) && !empty($params['id_resultado_visita'])){
                if($params['id_resultado_visita'] == 4){
                    $query_list[] = "v.id_tipo_visita_resultado = ".intval($params['id_resultado_visita'])
                                    . " AND 1 NOT IN (SELECT id_tipo_visita_perdida FROM mor_visita_animal_mordedor WHERE id_visita = v.id_visita)";
                }else{
                    $query_list[] = "v.id_tipo_visita_resultado = ".intval($params['id_resultado_visita']);
                }
            }

            if(!empty($params['id_fiscalizador'])){
                $query_list[] = "(em.id_fiscalizador = ".intval($params['id_fiscalizador'])." 
                				OR em.id_fiscalizador_microchip = ".intval($params['id_fiscalizador']).")";
            }

            if(!empty($params['fc_inicio']) && !empty($params['fc_termino'])){
                $query_list[] = "ex.fc_mordedura BETWEEN ".Fechas::formatearBaseDatos($params['fc_inicio'])." 
                				AND ".Fechas::formatearBaseDatos($params['fc_termino']);
            }
            else if(!empty($params['fc_inicio'])){
                $query_list[] = " ex.fc_mordedura >= ".Fechas::formatearBaseDatos($params['fc_inicio']);
            }
            else if(!empty($params['fc_termino'])){
                $query_list[] = " ex.fc_mordedura <= ".Fechas::formatearBaseDatos($params['fc_termino']);
            }

            if(isset($params['bo_domicilio_conocido']) && $params['bo_domicilio_conocido'] != ""){
                $query_list[]   = "em.bo_domicilio_conocido = ".intval($params['bo_domicilio_conocido']);
            }

            if(isset($params['bo_mes_actual'])){
                $query_list[]   = " MONTH(ex.fc_mordedura) = MONTH(CURDATE())";
            }
        }
        
        /*
        if(isset($_SESSION[SESSION_BASE]['id_servicio']) && $_SESSION[SESSION_BASE]['id_servicio'] > 0){
            $query_list[] = "(es.id_servicio = ".$_SESSION[SESSION_BASE]['id_servicio']." AND es.bo_publica = 1)";
        }
        */
        
        if($id_perfil == 15){
            $query_list[]   = "es.id_servicio = ".$_SESSION[SESSION_BASE]['id_servicio'];
        }
        
        if($id_perfil == 13){ //COMUNAL
            $query_list[]   = "(es.id_comuna = ".intval($id_comuna).")";
        }
        
        $query_list[]   = "ex.id_expediente_estado != 17";

        //$query_list[] = "v.id_visita IS NOT NULL";
        //$query_list[] = "com.id_comuna IS NOT NULL";

        if(!empty($query_list)){
            $query .= $where . implode(" AND ", $query_list);
        }
        
       	$query .= " GROUP BY com.id_comuna";
       
       	$result     = $this->db->getQuery($query);
       	//file_put_contents('php://stderr', PHP_EOL . print_r($query, TRUE). PHP_EOL, FILE_APPEND);
        //print_r($this->db->getQueryString($query));die;
        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
	
    public function getEstablecimientosNotifican($params=null) {
        $query	= " SELECT
                        salud.gl_nombre_establecimiento,
                        region_establecimiento.gl_nombre_region,
                        comuna_establecimiento.gl_nombre_comuna,
                        usuario.gl_nombres,
                        usuario.gl_apellidos,
                        COUNT(ex.id_expediente) AS cantidad_expediente
                    FROM mor_expediente ex
                    LEFT JOIN mor_acceso_usuario usuario ON ex.id_usuario_crea = usuario.id_usuario
                    LEFT JOIN mor_establecimiento_salud salud ON ex.id_establecimiento = salud.id_establecimiento
                    LEFT JOIN mor_direccion_region region_establecimiento ON salud.id_region = region_establecimiento.id_region
                    LEFT JOIN mor_direccion_comuna comuna_establecimiento ON salud.id_comuna = comuna_establecimiento.id_comuna
                    WHERE ex.id_usuario_crea = (SELECT id_usuario FROM mor_acceso_usuario_perfil
                                                WHERE id_usuario = ex.id_usuario_crea AND id_perfil = 3
                                                ORDER BY usuario.gl_nombres ASC LIMIT 1)
                    ";
        
        $where      = " AND ";
        $query_list = array();
        $id_perfil  = $_SESSION[SESSION_BASE]['perfil'];

        if(!empty($params)){
            if(isset($params['id_region']) && !empty($params['id_region'])){
                $query_list[] = "salud.id_region = ".intval($params['id_region']);
            }
            if(isset($params['id_comuna']) && !empty($params['id_comuna'])){
                $query_list[] = "salud.id_comuna = ".intval($params['id_comuna']);
            }
            if(isset($params['id_oficina']) && !empty($params['id_oficina']) && ($params['bo_domicilio_conocido'] == "" || $params['bo_domicilio_conocido'] == 1)){
                $query_domicilio    = "";
                if($params['bo_domicilio_conocido'] == ""){ //Si es Todos (SI y NO domicilio conocido)
                    $query_domicilio = "OR ex.id_expediente = (SELECT id_expediente FROM mor_expediente_mordedor
                                                                WHERE ex.id_expediente = id_expediente AND bo_domicilio_conocido = 0 LIMIT 1)";
                }
                $query_list[] = "((SELECT id_oficina FROM mor_direccion_oficina_comuna WHERE id_comuna = salud.id_comuna) = ".intval($params['id_oficina'])." $query_domicilio)";
            }
            if(isset($params['id_establecimiento']) && !empty($params['id_establecimiento'])){
				$query_list[] = "ex.id_establecimiento = " . $params['id_establecimiento'];
            }
            elseif(!empty($params['in_establecimiento'])){
                $query_list[] = "ex.id_establecimiento IN (".$params['in_establecimiento'].")";
            }
            if(!empty($params['id_servicio'])){
                $query_list[] = "(salud.id_servicio = ".intval($params['id_servicio']).")";
            }
            if(isset($params['id_estado']) && !empty($params['id_estado'])){
                $query_list[]   = "ex.id_expediente = (SELECT id_expediente FROM mor_expediente_mordedor
                                    WHERE ex.id_expediente = id_expediente AND id_expediente_mordedor_estado = ".intval($params['id_estado'])." LIMIT 1)";
            }
            if(!empty($params['fc_inicio']) && !empty($params['fc_termino'])){
                $query_list[] = "ex.fc_mordedura BETWEEN ".Fechas::formatearBaseDatos($params['fc_inicio'])." 
                				AND ".Fechas::formatearBaseDatos($params['fc_termino']);
            }
            else if(!empty($params['fc_inicio'])){
                $query_list[] = " ex.fc_mordedura >= ".Fechas::formatearBaseDatos($params['fc_inicio']);
            }
            else if(!empty($params['fc_termino'])){
                $query_list[] = " ex.fc_mordedura <= ".Fechas::formatearBaseDatos($params['fc_termino']);
            }

            if(isset($params['bo_domicilio_conocido']) && $params['bo_domicilio_conocido'] != ""){
                $query_list[]   = "ex.id_expediente = (SELECT id_expediente FROM mor_expediente_mordedor
                                    WHERE ex.id_expediente = id_expediente AND bo_domicilio_conocido = ".intval($params['bo_domicilio_conocido'])." LIMIT 1)";
            }

            if(isset($params['bo_mes_actual'])){
                $query_list[]   = " MONTH(ex.fc_mordedura) = MONTH(CURDATE())";
            }
        }
        
        if($id_perfil == 15){
            $query_list[]   = "(salud.id_servicio IN (SELECT id_servicio FROM mor_servicio_salud WHERE id_region = ".$_SESSION[SESSION_BASE]['id_region']."))";
        }
        
        if($id_perfil == 13){ //COMUNAL
            $query_list[]   = "(salud.id_comuna = ".intval($_SESSION[SESSION_BASE]['id_comuna']).")";
        }

        if(!empty($query_list)){
            $query .= $where . implode(" AND ", $query_list);
        }
            
        $query  .= " GROUP BY ex.id_usuario_crea ORDER BY usuario.gl_nombres";
        $result = $this->db->getQuery($query);
        //print_r($this->db->getQueryString($query));die;
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getById($id){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getByIdEstado($id_expediente, $id_estado){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE id_expediente = ?
					AND id_expediente_mordedor_estado = ?";

		$param	= array($id_expediente, $id_estado);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getByToken($gl_token){
        $query	= "	SELECT 
                        exp_mordedor.*,
                        expediente.gl_token AS token_expediente
                    FROM mor_expediente_mordedor exp_mordedor
                    LEFT JOIN mor_expediente expediente ON exp_mordedor.id_expediente = expediente.id_expediente
					WHERE exp_mordedor.gl_token = ?";

		$param	= array($gl_token);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
    
    /**
	 * Descripción : Inserta Nuevo Expediente Mordedor
	 * @author  David Guzmán <david.guzman@cosof.cl> - 04/06/2018
     * @param   array $params 
	 */
    public function insertarExpMordedor($params) {
        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            gl_token,
                            gl_folio_mordedor,
                            id_expediente,
                            id_paciente,
                            id_dueno,
                            id_expediente_mordedor_estado,
                            id_region_mordedor,
                            id_comuna_mordedor,
                            bo_domicilio_conocido,
                            bo_ubicable,
                            id_animal_grupo,
                            json_mordedor,
                            id_usuario_crea,
                            fc_crea
                        )
					VALUES 
                        (?,?,?,?,?,?,?,?,?,?,?,?,".intval($_SESSION[SESSION_BASE]['id']).",now())";

        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
    
    /**
	 * Descripción : Asignar Fiscalizador
     * @author  David Guzmán <david.guzman@cosof.cl> - 05/06/2018
     * @param   int $id_fiscalizador, string $gl_token
	 */
    public function asignarFiscalizador($id_fiscalizador,$gl_token){
        $query	= "	UPDATE ".$this->_tabla."
					SET 
						id_fiscalizador                 = ".intval($id_fiscalizador).",
                        id_supervisor                   = ".intval($_SESSION[SESSION_BASE]['id']).",
						id_expediente_mordedor_estado   = 6,
                        fc_asignado                     = now(),
                        fc_programado                   = now(),
                        id_usuario_actualiza            = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza                    = now()
					WHERE gl_token = '$gl_token'";

        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
	 * Descripción : Asignar Fiscalizador
     * @author  David Guzmán <david.guzman@cosof.cl> - 06/06/2018
     * @param   int $id_fiscalizador, string $gl_token
	 */
    public function asignarFiscalizadorMicrochip($id_fiscalizador,$gl_token){
        $query	= "	UPDATE ".$this->_tabla."
					SET 
						id_fiscalizador_microchip       = ".intval($id_fiscalizador).",
                        id_supervisor                   = ".intval($_SESSION[SESSION_BASE]['id']).",
						id_expediente_mordedor_estado   = 14,
                        fc_asignado                     = now(),
                        id_usuario_actualiza            = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza                    = now()
					WHERE gl_token = '$gl_token'";

        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
	 * Descripción : Asignar Fiscalizador
     * @author  David Guzmán <david.guzman@cosof.cl> - 05/06/2018
     * @param   int $id_fiscalizador, string $gl_token
	 */
    public function programarVisita($fc_programado,$gl_token,$id_estado){
        $query	= "	UPDATE ".$this->_tabla."
					SET 
						id_expediente_mordedor_estado   = $id_estado,
                        fc_programado                   = '$fc_programado',
                        id_usuario_actualiza            = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza                    = now()
					WHERE gl_token = '$gl_token'";

        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
	 * Descripción : Asignar Fiscalizador
     * @author  David Guzmán <david.guzman@cosof.cl> - 05/06/2018
     * @param   string $gl_token
	 */
    public function devolverProgramacion($gl_token){
        $query	= "	UPDATE ".$this->_tabla."
					SET 
						id_expediente_mordedor_estado   = 9,
                        id_fiscalizador                 = NULL,
                        id_fiscalizador_microchip       = NULL,
                        fc_asignado                     = NULL,
                        fc_programado                   = NULL,
                        id_usuario_actualiza            = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza                    = now()
					WHERE gl_token = '$gl_token'";

        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
	 * Descripción : Editar Dirección
     * @author  David Guzmán <david.guzman@cosof.cl> - 06/06/2018
     * @param   string $gl_token
	 */
    public function editaDireccion($gl_token,$json_mordedor,$id_comuna_mordedor){
        $query	= "	UPDATE ".$this->_tabla."
					SET 
						id_expediente_mordedor_estado   = 1,
						id_comuna_mordedor              = ".intval($id_comuna_mordedor).",
                        bo_domicilio_conocido           = 1,
                        bo_ubicable                     = 1,
                        json_mordedor                   = '".addslashes($json_mordedor)."',
                        id_usuario_actualiza            = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza                    = now()
					WHERE gl_token = '$gl_token'";

        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function getByExpediente($id_expediente) {
        $query	= " SELECT *
					FROM ".$this->_tabla."
					WHERE bo_activo = 1 
					AND id_expediente = ? ";

		$param	= array((int)$id_expediente);
        $result = $this->db->getQuery($query,$param);
        
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
	
    public function getByExpedienteFiscalizador($id_expediente,$id_usuario) {
        $query	= " SELECT *
					FROM ".$this->_tabla."
					WHERE bo_activo = 1 
						AND id_expediente = ? 
						AND mor_expediente_mordedor.id_expediente_mordedor_estado IN (SELECT id_expediente_estado FROM mor_expediente_estado WHERE bo_estado = 1 AND bo_visita = 1)
                        AND (mor_expediente_mordedor.id_fiscalizador = ". (int)$id_usuario." OR mor_expediente_mordedor.id_fiscalizador_microchip = ". (int)$id_usuario.")";

		$param	= array((int)$id_expediente);
        $result = $this->db->getQuery($query,$param);
        
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    /*Obtener especie de mordedores por expediente*/
    public function getEspecieByExpediente($id_expediente){
        if(ENVIROMENT == "DEV"){
            
            $query	= " SELECT GROUP_CONCAT(DISTINCT
                            IFNULL((SELECT esp.gl_nombre FROM mor_animal_mordedor ani_mor 
                                     LEFT JOIN mor_animal_especie esp ON ani_mor.id_animal_especie = esp.id_animal_especie 
                                     WHERE ani_mor.id_mordedor = exp_mor.id_mordedor),'') SEPARATOR ' y ') AS gl_especie
                        FROM ".$this->_tabla." exp_mor
                        WHERE exp_mor.id_expediente = ?";
            $param	= array(intval($id_expediente));
            $result = $this->db->getQuery($query,$param);
        
            if($result->numRows > 0){
                if(empty($result->rows->row_0->gl_especie)){
                    $query	= " SELECT json_mordedor FROM ".$this->_tabla." WHERE id_expediente = ?";
                    $param	= array(intval($id_expediente));
                    $result = $this->db->getQuery($query,$param);
                    if($result->numRows > 0){
                        if(!empty($result->rows->row_0->json_mordedor)){
                            $json = json_decode($result->rows->row_0->json_mordedor);
                            if(isset($json->id_animal_especie) && $json->id_animal_especie == 1){
                                return (object)array("gl_especie"=>"Canino");
                            }elseif(isset($json->id_animal_especie) && $json->id_animal_especie == 2){
                                return (object)array("gl_especie"=>"Felino");
                            }else{
                                return (object)array("gl_especie"=>"");
                            }
                        }
                    }
                }else{
                    return $result->rows->row_0;
                }
            }
            
        }else{
            $query	= " SELECT GROUP_CONCAT(DISTINCT IFNULL((SELECT esp.gl_nombre
                        FROM mor_visita_animal_mordedor vis_ani 
                        LEFT JOIN mor_animal_especie esp ON 
                            CONVERT(JSON_EXTRACT(vis_ani.json_mordedor,'$.id_animal_especie'),UNSIGNED INTEGER) = esp.id_animal_especie 
                        WHERE vis_ani.id_mordedor = exp_mor.id_mordedor LIMIT 1),
                            IFNULL((SELECT esp.gl_nombre FROM mor_animal_mordedor ani_mor 
                                     LEFT JOIN mor_animal_especie esp ON ani_mor.id_animal_especie = esp.id_animal_especie 
                                     WHERE ani_mor.id_mordedor = exp_mor.id_mordedor),
                            IFNULL((SELECT esp.gl_nombre
                                     FROM mor_animal_especie esp
                                     WHERE CONVERT(JSON_EXTRACT(exp_mor.json_mordedor,'$.id_animal_especie'),UNSIGNED INTEGER) = esp.id_animal_especie),
                                   ''))) SEPARATOR ' y ') AS gl_especie
                        FROM ".$this->_tabla." exp_mor
                        WHERE exp_mor.id_expediente = ?";
            
            $param	= array(intval($id_expediente));
            $result = $this->db->getQuery($query,$param);

            if($result->numRows > 0){
                return $result->rows->row_0;
            }else{
                return NULL;
            }
        }

		
    }

    public function getGrillaEstablecimientos($params = array()){

        $query  = " SELECT
                        es.gl_nombre_establecimiento AS gl_nombre_establecimiento,
                        count(em.id_expediente) as cant_total,
                        sum(CASE WHEN em.bo_domicilio_conocido = 1 THEN 1 ELSE 0 END) as con_domicilio,
                        sum(CASE WHEN em.bo_domicilio_conocido = 0 THEN 1 ELSE 0 END) as sin_domicilio,
                        sum(CASE WHEN ex.bo_crea_establecimiento = 0 THEN 1 ELSE 0 END) as informada_web,
                        sum(CASE WHEN ex.bo_crea_establecimiento = 1 THEN 1 ELSE 0 END) as informada_manual
                    FROM mor_expediente_mordedor em
                        LEFT JOIN mor_expediente ex ON ex.id_expediente = em.id_expediente
                        LEFT JOIN mor_visita v ON (v.id_expediente = ex.id_expediente
                                                    AND v.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE mor_visita.id_expediente = ex.id_expediente))
                        LEFT JOIN mor_visita_animal_mordedor vam ON 
                                (v.id_visita = vam.id_visita AND vam.id_visita_mordedor = (SELECT MAX(id_visita_mordedor) FROM mor_visita_animal_mordedor WHERE id_visita = v.id_visita))
                        LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = ex.id_establecimiento
                        #LEFT JOIN mor_direccion_oficina_comuna ofi_com ON ofi_com.id_comuna = ex.id_comuna_mordedura
                ";
        
        $arr_query  = $this->filtrosReportes($query,$params);
        $query      = $arr_query[0];
        $param_list = $arr_query[1];
        
        //$where  = (strpos($query,'WHERE') !== false)?" AND ":" WHERE ";
        $query .= " GROUP BY es.id_establecimiento";
        $result = $this->db->getQuery($query,$param_list);
        
        //echo $this->db->getQueryString($query,$params); die;
        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
}

?>