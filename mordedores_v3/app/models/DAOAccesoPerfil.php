<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_acceso_perfil
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAOAccesoPerfil.php
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
class DAOAccesoPerfil extends Model {

    protected $_tabla			= "mor_acceso_perfil";
    protected $_primaria		= "id_perfil";
    protected $_transaccional	= false;

    function __construct(){
        parent::__construct();       
    }

	public function getLista($bo_mostrar=0){
        $query	= "	SELECT * FROM ".$this->_tabla;
        if($bo_mostrar==1){
            $query .= " WHERE bo_mostrar = 1 AND bo_estado = 1";
        }
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
	
    public function getById($id_perfil){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return null;
        }
    }
    
	/**
	 * Descripción : Obtiene por Token
	 * @author  David Guzmán - <david.guzman@cosof.cl> - 11/05/2018
	 */
    public function getByToken($gl_token){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE gl_token = ?";

        $result	= $this->db->getQuery($query,array($gl_token));
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return null;
        }
    }

}

?>