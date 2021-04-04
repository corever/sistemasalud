<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_animal_raza
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOAnimalVacunaLaboratorio.php
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
class DAOVacunaLaboratorio extends Model{

    protected $_tabla           = "mor_vacuna_laboratorio";
    protected $_primaria		= "id_vacuna_laboratorio";
    protected $_transaccional	= false;

    function __construct($conn = null) {
        parent::__construct();
    }

    public function getLista(){
        $query	= "	SELECT * FROM ".$this->_tabla;
        $result = $this->db->getQuery($query);
        
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
        $result = $this->db->getQuery($query,$param);

        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getListaParaCombo(){
        $query  = " SELECT 
                        id_vacuna_laboratorio AS id, 
                        id_tipo_laboratorio,
                        gl_nombre_laboratorio AS nombre
                    FROM ".$this->_tabla."
                    WHERE bo_estado = 1";
        $result = $this->db->getQuery($query);
        
        if($result->numRows>0){
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