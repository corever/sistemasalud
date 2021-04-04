 <?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente_contacto
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 11/05/2018
 * 
 * @name             DAOPacienteContacto.php
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
class DAOPacienteContacto extends Model{

    protected $_tabla			= "mor_paciente_contacto";
    protected $_primaria		= "id_paciente_contacto";
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
    }

    /**
	 * Descripción : Inserta Nuevo Contacto Paciente
	 * @author  David Guzmán <david.guzman@cosof.cl> - 15/05/2018
     * @param   array $params 
	 */
    public function insertaContacto($params) {
        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            id_paciente,
                            id_tipo_contacto,
                            json_dato_contacto,
                            id_usuario_crea
                        )
					VALUES 
                        (?,?,?,".intval($_SESSION[SESSION_BASE]['id']).")";

        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
    
    /**
	 * Descripción : Obtener por id paciente
	 * @author  David Guzmán <david.guzman@cosof.cl> - 22/05/2018
     * @param   int $id_paciente 
	 */
    public function getByIdPaciente($id_paciente){
        $query	= "	SELECT	*
					FROM ".$this->_tabla."
					WHERE id_paciente = ? AND bo_estado = 1";

		$param	= array($id_paciente);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
	/**
	 * Descripción : UPDATE bo_estado
	 * @author  David Guzmán <david.guzman@cosof.cl> - 29/05/2018
     * @param   id   $id
	 */
	public function deshabilitaById($id){
        $query	= "	UPDATE ".$this->_tabla."
					SET bo_estado = 0
					WHERE id_paciente_contacto = $id";
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
	/**
	 * Descripción : UPDATE bo_estado
	 * @author  David Guzmán <david.guzman@cosof.cl> - 29/05/2018
     * @param   int   $id_paciente
	 */
	public function cambiaEstadoByIdPaciente($id_paciente,$bo_estado=0){
        $query	= "	UPDATE ".$this->_tabla."
					SET bo_estado = $bo_estado
					WHERE id_paciente = $id_paciente";
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

?>