<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_establecimiento_salud
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAOEstablecimientoSalud.php
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
class DAOEstablecimientoSalud extends Model{

    protected $_tabla           = "mor_establecimiento_salud";
    protected $_primaria		= "id_establecimiento";
    protected $_transaccional	= false;

    function __construct()
    {
        parent::__construct();
    }

    public function getLista(){
        $query	= "SELECT * FROM ".$this->_tabla;
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getById($id){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene establecimiento de salud por Id
	 * @author  David Guzmán - david.guzman@cosof.cl - 23/05/2018
     * @param   int $id_servicio_salud
	 */
    public function getByIdServicio($id_servicio_salud){
        $query = "  SELECT * 
					FROM ".$this->_tabla."
					WHERE id_servicio = ?";
						
		$param	= array($id_servicio_salud);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene establecimiento de salud por Región
	 * @author  David Guzmán - david.guzman@cosof.cl - 23/05/2018
     * @param   int $id_region
	 */
    public function getByIdRegion($id_region,$bo_estado=null) {
        $query = "  SELECT 
                        es.gl_nombre_establecimiento, 
                        es.id_establecimiento,
                        es.id_region
					FROM mor_establecimiento_salud es
                    LEFT JOIN mor_direccion_comuna com ON es.id_comuna = com.id_comuna
					WHERE com.id_region = ?";
        
        if(!is_null($bo_estado)){
            $query .= " AND es.bo_estado = ".intval($bo_estado);
        }

		$param	= array($id_region);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene establecimiento de salud por Región
	 * @author  David Guzmán - <david.guzman@cosof.cl> - 08/07/2019
     * @param   int $id_region
	 */
    public function getByIdRegionAndServicio($id_region,$id_servicio) {
        $query = "  SELECT 
                        es.gl_nombre_establecimiento, 
                        es.id_establecimiento,
                        es.id_region
					FROM mor_establecimiento_salud es
                    LEFT JOIN mor_direccion_comuna com ON es.id_comuna = com.id_comuna
					WHERE   es.bo_estado = 1 AND
                            es.id_servicio = ? AND es.id_region = ?";

		$param	= array($id_servicio,$id_region);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene establecimiento de salud por Comuna y Servicio
	 * @author  David Guzmán - <david.guzman@cosof.cl> - 08/07/2019
     * @param   int $id_region
	 */
    public function getByIdComunaAndServicio($id_servicio,$id_comuna) {
        $query = "  SELECT 
                        es.gl_nombre_establecimiento, 
                        es.id_establecimiento,
                        es.id_region
					FROM mor_establecimiento_salud es
                    LEFT JOIN mor_direccion_comuna com ON es.id_comuna = com.id_comuna
					WHERE   es.bo_estado = 1 AND
                            es.id_servicio = ? AND es.id_comuna = ?";

		$param	= array($id_servicio,$id_comuna);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
	
    public function getNacional($bo_estado=null) {
        $query = "  SELECT 
                        es.gl_nombre_establecimiento, 
                        es.id_establecimiento,
                        es.id_region
					FROM mor_establecimiento_salud es";
        
        if(!is_null($bo_estado)){
            $query .= " WHERE es.bo_estado = ".intval($bo_estado);
        }

        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene establecimiento de salud por Región
	 * @author  David Guzmán - david.guzman@cosof.cl - 23/05/2018
     * @param   int $id_oficina
	 */
    public function getByIdOficina($id_oficina,$bo_estado=null) {
        $query = "  SELECT 
                        es.gl_nombre_establecimiento, 
                        es.id_establecimiento,
                        es.id_region
					FROM mor_establecimiento_salud es
                    LEFT JOIN mor_direccion_oficina_comuna ofcom ON es.id_comuna = ofcom.id_comuna
					WHERE ofcom.id_oficina = ?";
        
        if(!is_null($bo_estado)){
            $query .= " AND es.bo_estado = ".intval($bo_estado);
        }

		$param	= array(intval($id_oficina));
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene establecimiento de salud por Comuna
	 * @author  David Guzmán - david.guzman@cosof.cl - 23/05/2018
     * @param   int $id_comuna
	 */
    public function getByIdComuna($id_comuna) {
        $query = "  SELECT 
                        gl_nombre_establecimiento, 
                        id_establecimiento 
                    FROM mor_establecimiento_salud 
                    WHERE id_comuna = ?";

		$param	= array($id_comuna);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene establecimiento de salud por Comuna y tipo Municipal
	 * @author  David Guzmán - <david.guzman@cosof.cl> - 12/04/2019
     * @param   int $id_comuna
	 */
    public function getByEncargadoComunal($id_comuna) {
        $query = "  SELECT 
                        gl_nombre_establecimiento, 
                        id_establecimiento 
                    FROM mor_establecimiento_salud 
                    WHERE id_comuna = ? AND id_tipo_dependencia = 1";

		$param	= array($id_comuna);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene establecimientos de salud Ordenados por Nombre
	 * @author  David Guzmán - david.guzman@cosof.cl - 23/05/2018
	 */
	public function getListaOrdenada(){
        $query = "  SELECT *
					FROM mor_establecimiento_salud
					ORDER BY gl_nombre_establecimiento ASC";
        
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

        /**
     * Descripción : Obtiene establecimientos de salud Por Region Ordenados por Nombre
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 20/06/2018
     */
    public function getListaOrdenadaByRegion($id_region){
        $query = "  SELECT *
                    FROM mor_establecimiento_salud es
                    LEFT JOIN mor_direccion_comuna com ON es.id_comuna = com.id_comuna
                     WHERE com.id_region = ".(int)$id_region."
                    ORDER BY es.gl_nombre_establecimiento ASC";
        
        $result = $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    /**
	 * Descripción : Obtiene establecimiento de salud por Usuario
	 * @author  David Guzmán - david.guzman@cosof.cl - 23/05/2018
     * @param   int $id_usuario int $id_region
	 */
    public function getByUsuario($id_usuario,$id_region=0,$bo_estado=null) {
        //Si usuario tiene region que busque solo las de su región
        $and_region  = (intval($id_region)>0)?" AND perfil.id_region = ".$id_region:"";
        
        $query  = " SELECT 
                        gl_nombre_establecimiento, 
                        id_establecimiento,
                        id_region
                    FROM mor_establecimiento_salud 
                        WHERE id_establecimiento IN (  SELECT perfil.id_establecimiento 
                                                    FROM mor_acceso_usuario_perfil perfil
                                                    WHERE perfil.id_usuario = ? AND perfil.bo_activo = 1 $and_region)";

        if(!is_null($bo_estado)){
            $query .= " AND mor_establecimiento_salud.bo_estado = ".intval($bo_estado);
        }
        
		$param	= array($id_usuario);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    /**
	 * Descripción : Obtiene establecimiento de salud por Usuario
	 * @author  David Guzmán - <david.guzman@cosof.cl> - 04/06/2018
     * @param   int $id
	 */
    public function getDetalleById($id){
        $query	= "	SELECT 
                        establecimiento.*,
                        comuna.gl_nombre_comuna,
                        region.id_region,
                        region.gl_nombre_region
                    FROM mor_establecimiento_salud establecimiento
                    LEFT JOIN mor_direccion_comuna comuna ON establecimiento.id_comuna = comuna.id_comuna
                    LEFT JOIN mor_direccion_region region ON comuna.id_region = region.id_region
					WHERE id_establecimiento = ?";

		$param	= array(intval($id));
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
    
    /**
	 * Descripción : Obtiene establecimiento de salud por Token
	 * @author  David Guzmán - <david.guzman@cosof.cl> - 10/07/2018
     * @param   string $token
	 */
    public function getByToken($token){
        $query	= "	SELECT 
                        establecimiento.*,
                        comuna.gl_nombre_comuna,
                        region.id_region,
                        region.gl_nombre_region
                    FROM mor_establecimiento_salud establecimiento
                    LEFT JOIN mor_direccion_comuna comuna ON establecimiento.id_comuna = comuna.id_comuna
                    LEFT JOIN mor_direccion_region region ON comuna.id_region = region.id_region
					WHERE gl_token = ?";

		$param	= array($token);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getListaSinKey(){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE gl_private_key is null";

        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

	public function updateKey($id_establecimiento,$gl_key){
        $query	= "	UPDATE ".$this->_tabla."
					SET gl_private_key = '".$gl_key."'                          
					WHERE id_establecimiento = ".intval($id_establecimiento);
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

	public function uptEstablecimiento($id_establecimiento,$arr){
        
        $query	= '	UPDATE '.$this->_tabla.'
					SET gl_nombre_establecimiento       = "'.$arr['gl_nombre_establecimiento'].'",
                        id_establecimiento_tipo         = '.intval($arr['id_establecimiento_tipo']).',
                        id_servicio                     = '.intval($arr['id_servicio']).',
                        id_region                       = '.intval($arr['id_region']).',
                        id_comuna                       = '.intval($arr['id_comuna']).',
                        gl_direccion_establecimiento    = "'.$arr['gl_direccion_establecimiento'].'",
                        gl_telefono                     = "'.$arr['gl_telefono'].'",
                        id_usuario_actualiza            = '.intval($_SESSION[SESSION_BASE]['id']).',
                        fc_actualiza                    = now()
					WHERE id_establecimiento = '.intval($id_establecimiento);
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
	 * Descripción : Insertar Nuevo Establecimiento
	 * @author  David Guzmán <david.guzman@cosof.cl> - 10/07/2018
     * @param   array  $params
	 */
    public function insertNuevo($params){
        //print_r($params);die;
        $query	= "	INSERT INTO mor_establecimiento_salud (
						gl_token,
						gl_nombre_establecimiento,
						id_establecimiento_tipo,
						id_servicio,
						id_region,
                        id_comuna,
                        gl_direccion_establecimiento,
                        gl_telefono,
						id_usuario_crea,
						fc_crea
                    ) VALUES (?,?,?,?,?,?,?,?,".intval($_SESSION[SESSION_BASE]['id']).",now())";
        
        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
    
    public function getListaParams($params){
        $query	= " SELECT *
                    FROM ".$this->_tabla;
        
        if(!empty($params)){
            $and = " WHERE ";
            if(isset($params['region'])){
                if(intval($params['region']) > 0){
                    $query .= $and . "id_region = ". intval($params['region']);
                    $and = " AND ";
                }
            }
            if(isset($params['comuna'])){
                if(intval($params['comuna']) > 0){
                    $query .= $and . "id_comuna = ". intval($params['comuna']);
                    $and = " AND ";
                }
            }
        }
        
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

}
?>