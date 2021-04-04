 <?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAOPaciente.php
 * 
 * @version          1.0
 *
 * @author           Victor Retamal <victor.retamal@cosof.cl>
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
class DAOPaciente extends Model{

    protected $_tabla			= "mor_paciente";
    protected $_primaria		= "id_paciente";
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

    public function getById($id){
		$id	= intval($id);

		if($id > 0){
			$query	= "	SELECT	*
						FROM ".$this->_tabla."
						WHERE ".$this->_primaria." = ?";

			$param	= array($id);
			$result	= $this->db->getQuery($query,$param);
			
			if($result->numRows > 0){
				return $result->rows->row_0;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }
    
    /**
	 * Descripción : Obtener Paciente por token
     * @author  David Guzmán <david.guzman@cosof.cl> - 15/05/2018
     * @param   string   $gl_token
	 */
    public function getByToken($gl_token) {
        
        $query	= "	SELECT 
						p.*,
						r.gl_nombre_region,
						c.gl_nombre_comuna
					FROM ".$this->_tabla." p
						LEFT JOIN mor_direccion_region r ON p.id_region = r.id_region
						LEFT JOIN mor_direccion_comuna c ON p.id_comuna = c.id_comuna
                    WHERE p.gl_token = ?";

        $param	= array($gl_token);
        $result	= $this->db->getQuery($query,$param);
        if ($result->numRows > 0) {
            return $result->rows->row_0;
        } else {
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene detalle de Paciente por Rut
	 * @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
     * @param   string $gl_rut 
	 */
    public function getByRut($gl_rut) {
        $query = "  SELECT 
						mor_paciente.*,
                        datos.*,
                        DATE_FORMAT(datos.fc_nacimiento,'%d/%m/%Y') AS fc_nacimiento
					FROM mor_paciente
                    LEFT JOIN mor_paciente_datos datos ON mor_paciente.id_paciente = datos.id_paciente
					WHERE mor_paciente.gl_rut = ? ORDER BY mor_paciente.id_paciente DESC";

        $param		= array($gl_rut);
        $result	= $this->db->getQuery($query, $param);

        if ($result->numRows > 0) {
            return $result->rows->row_0;
        } else {
            return null;
        }
    }

    /**
	 * Descripción : Inserta Nuevo Paciente
	 * @author  David Guzmán <david.guzman@cosof.cl> - 14/05/2018
     * @param   array $params 
	 */
    public function insertarPaciente($params) {
        $query = "  INSERT INTO mor_paciente
                        (
                            gl_token,
                            gl_rut,
                            bo_rut_informado,
                            id_region,
                            id_comuna,
                            id_pais_origen,
                            id_nacionalidad,
                            id_tipo_sexo,
                            id_prevision,
                            gl_nombres,
                            gl_apellido_paterno,
                            gl_apellido_materno,
                            id_paciente_estado,
                            fc_nacimiento,
                            nr_edad,
                            id_usuario_crea
                        )
					VALUES
                        (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,".intval($_SESSION[SESSION_BASE]['id']).")";

        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
    
    /**
	 * Descripción : Obtener Listado Paciente para mostrar en Grilla
	 * @author  David Guzmán <david.guzman@cosof.cl> - 16/05/2018
     * @param   array $params 
	 */
    public function getListaDetalle(){
        $query	= "	SELECT 
                        p.*
                    FROM ".$this->_tabla." p
                    WHERE 1
                ";
        
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
	/**
	 * Descripción : UPDATE paciente
	 * @author  David Guzmán <david.guzman@cosof.cl> - 29/05/2018
     * @param   array   $params
	 */
	public function updatePaciente($params,$id_paciente){
        $query	= "	UPDATE ".$this->_tabla."
					SET id_region           = ".$params['id_region'].",
                        id_comuna           = ".$params['id_comuna'].",
                        gl_nombres          = '".$params['nombres']."',
                        gl_apellido_paterno = '".$params['apellido_paterno']."',
                        gl_apellido_materno = '".$params['apellido_materno']."'
                            
					WHERE id_paciente = $id_paciente";
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>