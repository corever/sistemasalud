<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_animal_raza
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 11/05/2018
 * 
 * @name             DAOAnimalRaza.php
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
class DAOAnimalRaza extends Model{

    protected $_tabla           = "mor_animal_raza";
    protected $_primaria		= "id_animal_raza";
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
	 * Descripción : Obtiene por id especie
	 * @author  David Guzmán - david.guzman@cosof.cl - 15/05/2018
     * @param   int $id_especie
	 */
    public function getByIdEspecie($id_especie){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE id_animal_especie = ?
                    ORDER BY gl_nombre";

		$param	= array($id_especie);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
}

?>