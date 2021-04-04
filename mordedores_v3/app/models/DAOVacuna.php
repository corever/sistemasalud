<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_vacuna
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 28/08/2018
 * 
 * @name             DAOAnimalVacuna.php
 * 
 * @version          1.0
 *
 * @author           Pablo Jimenez <pablo.jimenez@cosof.cl>
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
class DAOVacuna extends Model{

    protected $_tabla           = "mor_vacuna";
    protected $_primaria		= "id_vacuna";
    protected $_transaccional	= false;

    function __construct($conn = null) {
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

		$param  = array($id);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getListaParaCombo(){
        $query  = " SELECT 
                        id_vacuna AS id, 
                        id_vacuna_laboratorio,
                        gl_nombre_vacuna AS nombre
                    FROM ".$this->_tabla."
                    WHERE bo_estado = 1";
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
            return $result;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene por id laboratorio
     * @param   int $id_vacuna_laboratorio
	 */
    public function getByIdLaboratorio($id_vacuna_laboratorio){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE id_vacuna_laboratorio = ?
                    ORDER BY gl_nombre_vacuna";

		$param	= array($id_vacuna_laboratorio);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    function cerrar_conexion(){
        $this->db->cerrar_conexion();
    }
}

?>