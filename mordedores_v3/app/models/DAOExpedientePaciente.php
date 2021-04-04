<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_expediente_paciente
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 16/05/2018
 * 
 * @name             DAOExpedientePaciente.php
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
class DAOExpedientePaciente extends Model{

    protected $_tabla           = "mor_expediente_paciente";
    protected $_primaria		= "id_expediente_paciente";
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
    
    /**
	 * Descripción : Inserta Nuevo Expediente Paciente
	 * @author  David Guzmán <david.guzman@cosof.cl> - 16/05/2018
     * @param   array $params 
	 */
    public function insertarExpPaciente($params) {
        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            id_expediente,
                            id_paciente,
                            json_paciente,
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

}

?>