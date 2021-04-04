<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente_derivar
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 09/05/2018
 * 
 * @name             DAOPacienteDerivar.php
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
class DAOPacienteDerivar extends Model {

    protected $_tabla			= "mor_paciente_derivar";
    protected $_primaria		= "id_derivar";

    function __construct(){
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

	public function getById($id_direccion){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param	= array($id_direccion);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
	
	/**
	 * Descripción : Obtiene derivaciones de paciente
	 * @author  David Guzmán <david.guzman@cosof.cl> 09/05/2018
     * @param   int $id_paciente
	 */
	public function getByIdPaciente($id_paciente){
		$query	= "	SELECT * FROM ".$this->_tabla."
					WHERE id_paciente = ?
					AND bo_estado = 1";

		$param	= array($id_paciente);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
	}
    
}

?>