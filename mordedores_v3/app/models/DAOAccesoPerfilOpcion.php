<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_acceso_perfil_opcion
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAOAccesoPerfilOpcion.php
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
class DAOAccesoPerfilOpcion extends Model {

    protected $_tabla			= "mor_acceso_perfil_opcion";
    protected $_primaria_1		= "id_perfil";
	protected $_primaria_2		= "id_opcion";
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
	
	public function getById($id_perfil){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE ".$this->_primaria_1." = ?";

		$param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }
	
    /**
	 * Descripción : Obtiene Opciones Raiz
     * @author  David Guzmán - <david.guzman@cosof.cl> - 08/05/2018
     * @param   int $id_perfil
	 */
	public function getOpcionesRaiz($id_perfil){
        $query = "  SELECT 
						o.id_opcion AS id_opcion, 
						id_opcion_padre, 
						bo_tiene_hijo, 
						gl_nombre_opcion, 
						gl_icono, 
						gl_url
					FROM mor_acceso_perfil_opcion po
					LEFT JOIN mor_acceso_opcion o  ON po.id_opcion = o.id_opcion
					WHERE id_perfil = ? AND bo_activo = 1 AND id_opcion_padre = 0";

		$param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }
    
    /**
	 * Descripción : Obtiene Sub-Opciones
     * @author  David Guzmán - <david.guzman@cosof.cl> - 08/05/2018
     * @param   int $id_perfil
	 */
	public function getSubOpciones($id_perfil){
        $query	= "	SELECT 
						o.id_opcion AS id_opcion, 
						id_opcion_padre, 
						bo_tiene_hijo, 
						gl_nombre_opcion, 
						gl_icono, 
						gl_url
					FROM mor_acceso_perfil_opcion po
					LEFT JOIN mor_acceso_opcion o  ON po.id_opcion = o.id_opcion
					WHERE id_perfil = ? AND bo_activo = 1 AND id_opcion_padre != 0"
					;

		$param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }

    /**
	 * Descripción : Obtiene Menú-Perfil por Id
     * @author  David Guzmán - <david.guzman@cosof.cl> - 08/05/2018
     * @param   int $id_perfil
	 */
	public function getAllMenuPerfilPorID($id_perfil){
        $query	= "	SELECT 
						o.id_opcion AS id_opcion, 
						id_opcion_padre, 
						bo_tiene_hijo, 
						gl_nombre_opcion, 
						gl_icono, 
						gl_url
					FROM mor_acceso_perfil_opcion po
					LEFT JOIN mor_acceso_opcion o  ON po.id_opcion = o.id_opcion
					WHERE id_perfil = ? AND bo_activo = 1"
					;

		$param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }
	
	/**
	 * Descripción : Elimina Opciones del respectivo Perfil
	 * @author  David Guzmán <david.guzman@cosof.cl>
     * @param   int $id_perfil
	 */
	public function deleteByIdPerfil($id_perfil){
        $query = "  DELETE FROM mor_acceso_perfil_opcion
					WHERE id_perfil = ".$id_perfil."
                 ";

        if ($this->db->execQuery($query)) {
			return TRUE;
        } else {
            return NULL;
        }
    }
    
    /* Descripción : Busca por perfil y url
     * @author  David Guzmán <david.guzman@cosof.cl>
     * @param   int $id_perfil string $gl_url
     */
    public function getByPerfilAndURL($id_perfil,$gl_url){
        $id_perfil = intval($id_perfil);
        
        if($id_perfil > 0 && !empty($gl_url)){
            $query	= "	SELECT 
                            po.*
                        FROM mor_acceso_perfil_opcion po
                        LEFT JOIN mor_acceso_opcion o  ON po.id_opcion = o.id_opcion
                        WHERE po.id_perfil = $id_perfil AND o.gl_url LIKE '%$gl_url%' AND o.bo_activo = 1"
                        ;

            $result	= $this->db->getQuery($query);
            if($result->numRows > 0){
                return $result->rows->row_0;
            }else{
                return null;
            }
        }else{
            return null;
        }
		
        
    }
	
}

?>