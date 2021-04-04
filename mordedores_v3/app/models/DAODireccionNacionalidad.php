<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_direccion_nacionalidad
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAODireccionNacionalidad.php
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
class DAODireccionNacionalidad extends Model {

    protected $_tabla			= "mor_direccion_nacionalidad";
    protected $_primaria		= "id_nacionalidad";
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
	 * Descripción : Obtiene Nacionalidades por Id de Pais
	 * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
     * @param   int $id_pais
	 */
    public function getByIdPais($id_pais) {
        $query		= "	SELECT * 
						FROM mor_direccion_nacionalidad
						WHERE id_pais = ?";

		$param		= array($id_pais);
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows > 0) {
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
}

?>