<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_direccion_comuna
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAODireccionComuna.php
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
class DAODireccionComuna extends Model {

    protected $_tabla			= "mor_direccion_comuna";
    protected $_primaria		= "id_comuna";
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
	 * Descripción : Obtiene Comunas por Id de Provincia
	 * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
     * @param   int $id_provincia
	 */
    public function getByIdProvincia($id_provincia) {
        $query		= "	SELECT * 
						FROM mor_direccion_comuna
						WHERE id_provincia = ?";

		$param		= array($id_provincia);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows > 0) {
            return $result->rows;
        }else{
            return NULL;
        }
    }
    /**
	 * Descripción : Obtiene Comunas por Id de Región
	 * @author  David Guzmán - <david.guzman@cosof.cl> 08/05/2018
     * @param   int $id_region
	 */
    public function getByIdRegion($id_region) {
        $query		= "	SELECT * 
						FROM mor_direccion_comuna
						WHERE id_region = ?";

		$param		= array($id_region);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows > 0) {
            return $result->rows;
        }else{
            return NULL;
        }
    }
    /**
	 * Descripción : Obtiene Comunas por Id de oficina
	 * @author  David Guzmán - <david.guzman@cosof.cl> 04/06/2018
     * @param   int $id_oficina
	 */
    public function getByIdOficina($id_oficina) {
        $query		= "	SELECT comuna.* 
						FROM mor_direccion_comuna comuna
                        LEFT JOIN mor_direccion_oficina_comuna ofco ON comuna.id_comuna = ofco.id_comuna
						WHERE ofco.id_oficina = ?";

		$param		= array(intval($id_oficina));
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows > 0) {
            return $result->rows;
        }else{
            return NULL;
        }
    }

    
}

?>