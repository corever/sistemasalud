<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_direccion_oficina
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAODireccionOficina.php
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
class DAODireccionOficina extends Model {

    protected $_tabla			= "mor_direccion_oficina";
    protected $_primaria		= "id_oficina";
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
	 * Descripción : Obtiene Oficinas por Id de Región
	 * @author  David Guzmán - <david.guzman@cosof.cl> 10/05/2018
     * @param   int $id_region
	 */
    public function getByIdRegion($id_region) {
        $query		= "	SELECT DISTINCT o.* 
						FROM mor_direccion_oficina o
                        LEFT JOIN mor_direccion_oficina_comuna oc ON o.id_oficina = oc.id_oficina
                        LEFT JOIN mor_direccion_comuna c ON oc.id_comuna = c.id_comuna
						WHERE c.id_region = ? AND o.bo_estado = 1 AND bo_mostrar = 1";

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