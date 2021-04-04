<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_tipo_duracion_inmunidad
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 15/05/2018
 * 
 * @name             DAODuracionInmunidad.php
 * 
 * @version          1.0
 *
 * @author           Pablo Jimenez <pablo.jimenez@cosof.cl>
 * 
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador                !cFecha     !cDescripcion 
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

class DAODuracionInmunidad extends Model{

    protected $_tabla           = "mor_tipo_duracion_inmunidad";
    protected $_primaria        = "id_duracion_inmunidad";
    protected $_transaccional   = false;

    function __construct($conn = null) {
        parent::__construct();
    }

    public function getLista(){
        $query  = " SELECT * FROM ".$this->_tabla;
        $result = $this->db->getQuery($query);
        
        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getById($id){
        $query  = " SELECT  *
                    FROM ".$this->_tabla."
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
                        id_duracion_inmunidad AS id, 
                        gl_descripcion AS descripcion
                    FROM ".$this->_tabla;
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