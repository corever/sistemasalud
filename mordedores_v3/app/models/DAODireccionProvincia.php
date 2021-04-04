<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_direccion_provincia
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAODireccionProvincia.php
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
class DAODireccionProvincia extends Model {

    protected $_tabla			= "mor_direccion_provincia";
    protected $_primaria		= "id_provincia";
    protected $_transaccional	= false;

    function __construct() {
        parent::__construct();
    }

    public function getLista(){
        $query		= "	SELECT * FROM ".$this->_tabla;
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
	 * Descripción : Obtiene Provincias por Id de Region
	 * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
     * @param   int $id_region
	 */
    public function getByIdRegion($id_region) {
        $query		= "	SELECT * 
						FROM mor_direccion_provincia
						WHERE id_region = ?";

		$param		= array($id_region);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows > 0) {
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
}

?>