<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_tipo_ocupacion_categoria
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 09/05/2018
 * 
 * @name             DAOTipoOcupacionCategoria.php
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
class DAOTipoOcupacionCategoria extends Model{

    protected $_tabla			= "mor_tipo_ocupacion_categoria";
    protected $_primaria		= "id_ocupacion_categoria";
    protected $_transaccional	= false;

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

}

?>