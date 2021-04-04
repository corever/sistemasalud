<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_dueno
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 16/05/2018
 * 
 * @name             DAODueno.php
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
class DAODueno extends Model {

    protected $_tabla			= "mor_dueno";
    protected $_primaria		= "id_dueno";
    protected $_transaccional	= false;

    function __construct() {
        parent::__construct();
    }

    public function getLista(){
        $query		= "	SELECT * FROM ".$this->_tabla;
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getById($id){
        $query	= "	SELECT 
                        dueno.*,
                        region.gl_nombre_region,
                        comuna.gl_nombre_comuna
                    FROM ".$this->_tabla." dueno
                    LEFT JOIN mor_direccion_region region ON dueno.id_region = region.id_region
                    LEFT JOIN mor_direccion_comuna comuna ON dueno.id_comuna = comuna.id_comuna
					WHERE ".$this->_primaria." = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getByToken($gl_token){
        $query	= "	SELECT 
                        dueno.*,
                        region.gl_nombre_region,
                        comuna.gl_nombre_comuna
                    FROM ".$this->_tabla." dueno
                    LEFT JOIN mor_direccion_region region ON dueno.id_region = region.id_region
                    LEFT JOIN mor_direccion_comuna comuna ON dueno.id_comuna = comuna.id_comuna
					WHERE dueno.gl_token = ?";

		$param	= array($gl_token);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Inserta Nuevo Dueno
	 * @author  David Guzmán <david.guzman@cosof.cl> - 16/05/2018
     * @param   array $params 
	 */
    public function insertarDueno($params) {
        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            gl_nombre,
                            gl_apellido_paterno,
                            gl_apellido_materno,
                            bo_rut_informado,
                            gl_rut,
                            bo_extranjero,
                            gl_pasaporte,
                            id_region,
                            id_comuna,
                            json_direccion,
                            id_usuario_crea
                        )
					VALUES 
                        (?,?,?,?,?,?,?,?,?,?,".intval($_SESSION[SESSION_BASE]['id']).")";

        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
    
}

?>