<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_tipo_sintoma (copia de model ws DAOVisitaAnimalSintomaTipo.php)
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 28/08/2018
 * 
 * @name             DAOVisitaAnimalSintomaTipo.php
 * 
 * @version          1.0
 *
 * @author           Víctor Monsalve <victor.monsalve@cosof.cl>
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
class DAOSintomasTipo extends Model{

    protected $_tabla           = "mor_tipo_sintoma";
    protected $_primaria		= "id_tipo_sintoma";
    protected $_transaccional	= false;

    function __construct() {
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

        if($result->numRows>0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getListaParaCombo(){
        $query  = " SELECT 
                        id_tipo_sintoma AS id, 
                        gl_nombre AS nombre,
                        nr_orden AS orden
                    FROM ".$this->_tabla."
                    WHERE bo_estado = 1";
        $result = $this->db->getQuery($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    function cerrar_conexion(){
        $this->db->cerrar_conexion();
    }

}

?>