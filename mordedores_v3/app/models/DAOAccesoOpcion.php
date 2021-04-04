<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_acceso_opcion
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAOAccesoOpcion.php
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
class DAOAccesoOpcion extends Model {

    protected $_tabla			= "mor_acceso_opcion";
    protected $_primaria		= "id_opcion";
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
	
    public function getById($id_opcion){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param	= array($id_opcion);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return null;
        }
    }
	
    public function getByURL($gl_url){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE gl_url LIKE '%$gl_url%'";
        
        $result	= $this->db->getQuery($query);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return null;
        }
    }
	
    /**
	 * Descripción : Obtiene Opción Padre
	 * @author David Guzmán - <david.guzman@cosof.cl> - 08/05/2018
	 */
	public function getAllOpcionPadre(){
        $query = "  SELECT *
					FROM mor_acceso_opcion
					WHERE bo_activo = 1 AND id_opcion_padre = 0";
		
        $result = $this->db->getQuery($query);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }
	
	/**
	 * Descripción : Obtiene Opción Padre Marcando Perfil
	 * @author David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	 * @param $id_perfil
	 */
	public function getAllOpcionPadreByIdPerfil($id_perfil){
        $query = "  SELECT 	o.*,
							(   SELECT IFNULL(po.id_perfil,0) FROM mor_acceso_perfil_opcion po 
                                WHERE po.id_perfil = ".$id_perfil." AND po.id_opcion = o.id_opcion  ) AS bo_perfil_activo
					FROM mor_acceso_opcion o
					WHERE o.bo_activo = 1 AND o.id_opcion_padre = 0";
		
        $result = $this->db->getQuery($query);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }
	
    /**
	 * Descripción : Obtiene Opción Hijo
	 * @author David Guzmán - <david.guzman@cosof.cl> - 08/05/2018
	 */
	public function getAllOpcionHijo(){
        $query = "  SELECT *
					FROM mor_acceso_opcion
					WHERE bo_activo = 1 AND id_opcion_padre != 0";

        $result	= $this->db->getQuery($query);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }
	
	/**
	 * Descripción : Obtiene Opción Hijo Marcando Perfil
	 * @author David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	 * @param $id_perfil
	 */
	public function getAllOpcionHijoByIdPerfil($id_perfil){
        $query = "  SELECT 	o.*,
							(   SELECT IFNULL(po.id_perfil,0) FROM mor_acceso_perfil_opcion po
                                WHERE po.id_perfil = ".$id_perfil." AND po.id_opcion = o.id_opcion  ) AS bo_perfil_activo
					FROM mor_acceso_opcion o
					WHERE o.bo_activo = 1 AND o.id_opcion_padre != 0";

        $result	= $this->db->getQuery($query);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }
	
	/**
	 * Descripción : Obtiene Lista Opciones con Detalle
	 * @author David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	 */
	public function getListaDetalle(){
        $query = "  SELECT 	ao1.*,
							IF(ao1.id_opcion_padre=0,'',
                                (SELECT ao.gl_nombre_opcion FROM mor_acceso_opcion ao WHERE ao.id_opcion = ao1.id_opcion_padre)
                            ) AS gl_nombre_padre
					FROM mor_acceso_opcion ao1
					";

        $result	= $this->db->getQuery($query);
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }
	
	/**
	 * Descripción : Obtiene Lista Opciones con Detalle
	 * @author David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	 */
	public function getAllMenuPadre(){
        $query = "  SELECT 	*
					FROM mor_acceso_opcion
					WHERE id_opcion_padre = 0
					";

        $result	= $this->db->getQuery($query);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return null;
        }
    }
	
	/**
	 * Descripción : Insertar Menu Padre
	 * @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
     * @param   array  $parametros
	 */
    public function insertMenuPadre($parametros){
        $query	= "	INSERT INTO mor_acceso_opcion (
						id_opcion,
						id_opcion_padre,
						bo_tiene_hijo,
						gl_nombre_opcion,
						gl_icono,
						gl_url,
						id_usuario_crea,
						fc_crea
                    ) VALUES (
						(SELECT o.id_opcion+1 FROM mor_acceso_opcion o WHERE o.id_opcion < 8000 ORDER BY o.id_opcion DESC LIMIT 1),
						0,
						1,
						'".$parametros['gl_nombre']."',
						'".$parametros['gl_icono']."',
						'".$parametros['gl_url']."',
						".intval($_SESSION[SESSION_BASE]['id']).",
						now()
					)";
        
        if ($this->db->execQuery($query)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
	
	/**
	 * Descripción : Insertar Menu Opción
	 * @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
     * @param   array  $parametros
	 */
    public function insertMenuOpcion($parametros){
        $query	= "	INSERT INTO mor_acceso_opcion (
						id_opcion,
						id_opcion_padre,
						bo_tiene_hijo,
						gl_nombre_opcion,
						gl_icono,
						gl_url,
						id_usuario_crea,
						fc_crea
                    ) VALUES (
						(SELECT o.id_opcion+1 FROM mor_acceso_opcion o WHERE o.id_opcion < 8000 ORDER BY o.id_opcion DESC LIMIT 1),
						".$parametros['id_padre'].",
						0,
						'".$parametros['gl_nombre_opcion']."',
						'".$parametros['gl_icono']."',
						'".$parametros['gl_url']."',
						".intval($_SESSION[SESSION_BASE]['id']).",
						now()
					)";
        
        if ($this->db->execQuery($query)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
	
	/**
	 * Descripción : UPDATE Opción Padre
	 * @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
     * @param   id   $id_padre
	 */
	public function updatePadreById($id_padre){
        $query	= "	UPDATE mor_acceso_opcion
					SET
						bo_tiene_hijo			= 1,
						id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
						fc_actualiza			= now()
					WHERE
						id_opcion		= ".$id_padre."
                    ";
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	/**
	 * Descripción : UPDATE editar Opción
	 * @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
     * @param   array   $parametros
	 */
	public function editarOpcion($parametros){
        $query	= "	UPDATE mor_acceso_opcion 
					SET
						id_opcion_padre			= ".$parametros['id_padre'].",
						gl_nombre_opcion		= '".$parametros['gl_nombre_opcion']."',
						gl_icono				= '".$parametros['gl_icono']."',
						gl_url					= '".$parametros['gl_url']."',
						bo_activo				= ".$parametros['bo_activo'].",
						id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
						fc_actualiza			= now()
					WHERE
						id_opcion				= ".$parametros['id_opcion']."
                    ";
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
}

?>