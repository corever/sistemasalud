 <?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente_datos
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
class DAOPacienteDatos extends Model{

    protected $_tabla			= "mor_paciente_datos";
    protected $_primaria		= "id_paciente_datos";
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
    
    public function getByIdPaciente($id_paciente){
        $query	= "	SELECT	*
					FROM ".$this->_tabla."
					WHERE id_paciente = ?";

		$param	= array($id_paciente);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Inserta Nuevo Paciente datos
	 * @author  David Guzmán <david.guzman@cosof.cl> - 14/05/2018
     * @param   array $params 
	 */
    public function insertarDatos($params) {
        $query = "  INSERT INTO mor_paciente_datos
                        (
                            id_paciente,
                            bo_extranjero,
                            id_nacionalidad,
                            id_pais_origen,
                            json_pasaporte,
                            id_prevision,
                            fc_nacimiento,
                            nr_edad,
                            id_tipo_sexo,
                            json_otros_datos,
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
    
    /**
	 * Descripción : UPDATE paciente datos
	 * @author  David Guzmán <david.guzman@cosof.cl> - 29/05/2018
     * @param   array   $params
	 */
	public function updateDatos($params,$id_paciente){
        
        $json_pasaporte     = (isset($params['json_pasaporte']))?$params['json_pasaporte']:'';
        $json_otros_datos   = (isset($params['json_otros_datos']))?$params['json_otros_datos']:'';
        
        if(intval($id_paciente) > 0){
            $query	= "	UPDATE ".$this->_tabla."
                        SET bo_extranjero       = ".intval($params['chkextranjero']).",
                            id_nacionalidad     = ".intval($params['id_nacionalidad']).",
                            id_pais_origen      = ".intval($params['id_pais_origen']).",
                            json_pasaporte      = '".$json_pasaporte."',
                            id_prevision        = ".intval($params['id_prevision']).",
                            fc_nacimiento       = '".$params['fc_nacimiento']."',
                            nr_edad             = ".intval($params['edad']).",
                            id_tipo_sexo        = ".intval($params['id_tipo_sexo']).",
                            json_otros_datos    = '".$json_otros_datos."'
                        WHERE id_paciente = $id_paciente";
            if ($this->db->execQuery($query)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
}

?>