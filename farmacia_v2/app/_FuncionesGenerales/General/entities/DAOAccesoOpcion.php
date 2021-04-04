<?php
/**
 ******************************************************************************
 * Sistema           : SUMARIOS V4
 *
 * Descripcion       : Modelo para Tabla hope_acceso_opcion
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 07/01/2020
 *
 * @name             DAOOpcion.php
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
namespace App\_FuncionesGenerales\General\Entity;

class DAOAccesoOpcion extends \pan\Kore\Entity{

    

    protected $table           = TABLA_ACCESO_OPCION;
    protected $primary_key	   = "m_v_id";
    protected $_transaccional  = false;


    function __construct(){
        parent::__construct();
    }

    public function getListaDetalle(){
        $query	= "	SELECT 	ao1.*,
							IF(ao1.id_opcion_padre>0,
                                (SELECT ao.gl_nombre_opcion FROM ".$this->table." ao WHERE ao.id_opcion = ao1.id_opcion_padre),''
                            ) AS gl_nombre_padre,
                            modulo.gl_nombre as gl_modulo
					FROM ".$this->table." ao1
                    LEFT JOIN ".TABLA_ACCESO_MODULO." modulo ON modulo.id_modulo = ao1.id_modulo";
        $result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
    }

    public function getLista(){
        $query	= "	SELECT * FROM ".$this->table." WHERE bo_activo = 1";
        $result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
    }

    public function getById($id_opcion, $retornaLista = FALSE){
        $query	= "SELECT *
                   FROM ".$this->table."
                   WHERE ".$this->primary_key." = ?";

        $param	= array($id_opcion);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        $rows   = $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        }else {
            return $rows;
        }
    }

    public function getByUri($uri){
        $query	= "SELECT *
                   FROM ".$this->table."
                   WHERE gl_url = ?";

        $param	= array($uri);
        $result	= $this->db->getQuery($query,$param)->runQuery();
        $rows   = $result->getRows();

        if (!empty($rows)) {
            return $rows[0];
        }else {
            return false;
        }
    }

    /**
     * Descripción : Obtiene Opciones Raiz
     * @author  David Guzmán - <david.guzman@cosof.cl> - 07/01/2020
     * @param   int $id_usuario
    */
    public function getMenu($id_usuario,$id_modulo=0,$boSuperior=0){
        
        $query = "  
        SELECT DISTINCT
            vista.m_v_id AS id_opcion,
            vista.nombre_vista AS gl_nombre_opcion,
            vista.gl_url AS gl_url,
            vista.gl_icono AS gl_icono,
            modulo.gl_icono AS gl_icono_padre,
            modulo.m_m_id AS id_opcion_padre,
            modulo.nombre_modulo AS gl_opcion_padre,
            modulo.link_modulo AS link_opcion_padre
        FROM ".$this->table." vista
            INNER JOIN ".TABLA_ACCESO_ROL_OPCION." rol_vista  ON (vista.m_v_id = rol_vista.fk_vista)
            INNER JOIN ".TABLA_ACCESO_MODULO." modulo  ON (vista.fk_modulo = modulo.m_m_id)
        WHERE rol_vista.permiso = 1
            AND rol_vista.fk_rol IN (SELECT DISTINCT mur_fk_rol FROM ".TABLA_ACCESO_USUARIO_ROL." WHERE mur_fk_usuario = ?)
        ORDER BY modulo.m_m_id ASC, vista.nr_orden ASC";
        
        $param	= array($id_usuario);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }
    
    /**
     * Descripción : Obtiene Opciones Raiz
     * @author  David Guzmán - <david.guzman@cosof.cl> - 07/01/2020
     * @param   int $id_usuario
    */
    public function getOpcionesRaiz($id_usuario){
        
        $query = "  SELECT DISTINCT
                        vista.id_opcion AS id_opcion,
                        vista.id_opcion_padre,
                        vista.bo_tiene_hijo,
                        vista.gl_nombre_opcion,
                        vista.gl_icono,
                        vista.gl_url
                    FROM ".$this->table." opcion
                    LEFT JOIN ".TABLA_ACCESO_PERFIL_OPCION." rol_vista  ON rol_vista.id_opcion = vista.id_opcion
                    WHERE vista.bo_activo = 1 AND vista.id_opcion_padre = 0 AND rol_vista.bo_activo = 1
                    AND rol_vista.id_perfil IN (SELECT DISTINCT id_perfil FROM ".TABLA_ACCESO_USUARIO_PERFIL." WHERE id_usuario = ?)
                    ORDER BY nr_orden ASC";
        
        $param	= array($id_usuario);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene Sub-Opciones
     * @author  David Guzmán - <david.guzman@cosof.cl> - 07/01/2020
     * @param   int $id_perfil
    */
    public function getSubOpciones($id_usuario){
        
        $query	= "	SELECT DISTINCT
                        vista.m_v_id AS id_opcion,
                        vista.nombre_vista AS gl_nombre_opcion,
                        vista.gl_url AS gl_url,
                        vista.gl_icono AS gl_icono,
                        modulo.gl_icono AS gl_icono_padre,
                        modulo.m_m_id AS id_opcion_padre,
                        modulo.nombre_modulo AS gl_opcion_padre,
                        modulo.link_modulo AS link_opcion_padre
                    FROM ".$this->table." opcion
                    LEFT JOIN ".TABLA_ACCESO_ROL_OPCION." rol_vista  ON rol_vista.id_opcion = vista.id_opcion
                    LEFT JOIN ".TABLA_ACCESO_MODULO." modulo  ON modulo.m_m_id = vista.fk_modulo
                    WHERE vista.bo_activo = 1 AND modulo.m_m_id != 0 AND rol_vista.bo_activo = 1
                    AND rol_vista.id_perfil IN (SELECT DISTINCT id_perfil FROM ".TABLA_ACCESO_USUARIO_ROL." WHERE id_usuario = ?)
                    ORDER BY nr_orden ASC";

        $param	= array($id_usuario);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return null;
        }
    }
    
    /**
     * Descripción : Obtiene Opciones Padre para Mantenedor Perfil
     * @author  David Guzmán - <david.guzman@cosof.cl> - 08/01/2020
     * @param   int $id_perfil
    */
    public function getAllOpcionesPadre($bo_activo = 0){
        
        $txt_activo = ($bo_activo != null)?" AND vista.bo_activo = ".intval($bo_activo):"";
        
        $query = "  SELECT
                        vista.m_v_id AS id_opcion,
                        vista.nombre_vista AS gl_nombre_opcion,
                        vista.gl_url AS gl_url,
                        vista.gl_icono AS gl_icono,
                        modulo.gl_icono AS gl_icono_padre,
                        modulo.m_m_id AS id_opcion_padre,
                        modulo.nombre_modulo AS gl_opcion_padre,
                        modulo.link_modulo AS link_opcion_padre
                    FROM ".$this->table." vista
                    WHERE (vista.m_m_id = 0 OR vista.m_m_id IS NULL) $txt_activo
                    ORDER BY vista.nr_orden ASC";
        
        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene Opciones Hijo para Mantenedor Perfil
     * @author  David Guzmán - <david.guzman@cosof.cl> - 08/01/2020
     * @param   int $id_perfil
    */
    public function getAllOpcionesHijo($bo_activo = 0){
        
        $txt_activo = ($bo_activo != null)?" AND vista.bo_activo = ".intval($bo_activo):"";
        
        $query	= "	SELECT
                        vista.id_opcion AS id_opcion,
                        vista.id_opcion_padre,
                        vista.gl_nombre_opcion,
                        vista.gl_icono,
                        vista.gl_url,
                        vista.bo_activo,
                        vista.id_modulo
                    FROM ".$this->table." opcion
                    WHERE vista.id_opcion_padre != 0 $txt_activo
                    ORDER BY vista.nr_orden ASC";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return null;
        }
    }
	
	/**
	 * Descripción : Insertar Menu Padre
	 * @author  David Guzmán <david.guzman@cosof.cl> - 21/01/2020
     * @param   array  $params
	 */
    public function insertMenu($params){
        $query	= "	INSERT INTO ".$this->table." (
                        nombre_vista,
						gl_url,
						fk_modulo,
						id_usuario_crea,
						fc_crea
                    ) VALUES (
						?,
						?,
						?,
						".intval($_SESSION[SESSION_BASE]['id']).",
						now()
					)";
        
        if ($this->db->execQuery($query,array($params['gl_nombre_opcion'],$params['gl_url_opcion'],$params['id_modulo_opcion']))) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
	
	/**
	 * Descripción : Obtiene Lista Opciones con Detalle
	 * @author David Guzmán <david.guzman@cosof.cl> - 21/01/2020
	 */
	public function getAllMenuPadre(){
        $query = "  SELECT 	*
					FROM ".$this->table."
					WHERE id_opcion_padre = 0 OR id_opcion_padre IS NULL
					";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return null;
        }
    }
	
	/**
	 * Descripción : Insertar Menu Opción
	 * @author  David Guzmán <david.guzman@cosof.cl> - 21/01/2020
     * @param   array  $params
	 */
    public function insertMenuOpcion($params){
        $query	= "	INSERT INTO ".$this->table." (
						id_opcion,
						nr_orden,
						id_opcion_padre,
						bo_tiene_hijo,
						gl_nombre_opcion,
						gl_icono,
						gl_url,
						id_usuario_crea,
						fc_crea
                    ) VALUES (
						(SELECT o.id_opcion+1 FROM ".$this->table." o WHERE o.id_opcion < 100 ORDER BY o.id_opcion DESC LIMIT 1),
						(SELECT MAX(o2.nr_orden)+1 FROM ".$this->table." o2 WHERE o2.id_opcion < 100),
						".$params['id_padre'].",
						0,
						'".$params['gl_nombre_opcion']."',
						'".$params['gl_icono']."',
						'".$params['gl_url']."',
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
	 * Descripción : UPDATE editar Opción
	 * @author  David Guzmán <david.guzman@cosof.cl> - 21/01/2020
     * @param   array   $params
	 */
	public function editarOpcion($params){
        $query	= "	UPDATE ".$this->table." 
					SET
                        fk_modulo			    = ?,
						nombre_vista            = ?,
						gl_url					= ?,
						bo_activo				= ?,
						id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
						fc_actualiza			= now()
					WHERE
						m_v_id  = ".$params['id_opcion']."
                    ";
        if ($this->db->execQuery($query,array($params['id_modulo_opcion'],$params['gl_nombre_opcion'],$params['gl_url_opcion'],$params['bo_activo']))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getListaBuscar($params){
        $where  = " WHERE ";
        $query	= "	SELECT 
                        vista.*,
                        modulo.nombre_modulo AS gl_modulo
                    FROM ".$this->table." vista
                    LEFT JOIN ".TABLA_ACCESO_MODULO." modulo ON modulo.m_m_id = vista.fk_modulo ";
        
        if(!empty($params)){
            if(isset($params['gl_nombre']) && $params['gl_nombre'] != ""){
                $query .= $where." vista.nombre_vista LIKE '%".$params['gl_nombre']."%' ";
                $where  = " AND ";
            }
            if(isset($params['gl_url']) && $params['gl_url'] != ""){
                $query .= $where." vista.gl_url LIKE '%".$params['gl_url']."%'";
                $where  = " AND ";
            }
            if(isset($params['id_modulo']) && $params['id_modulo'] != "0"){
                $query .= $where." vista.fk_modulo = ".intval($params['id_modulo']);
            }
        }

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene Opciones Raiz
     * @author  David Guzmán - <david.guzman@cosof.cl> - 07/01/2020
     * @param   int $id_usuario
    */
    public function getMenuUsuario($id_usuario,$id_modulo=0){
        
        $query = "  
        SELECT DISTINCT
        vista.id_opcion,
        vista.id_opcion_padre,
        vista.nr_orden,
        vista.gl_nombre_opcion,
        vista.gl_icono,
        vista.gl_url,
        usuario_vista.bo_agregar,
        usuario_vista.bo_modificar,
        usuario_vista.bo_eliminar
        FROM ".$this->table." opcion
        INNER JOIN ".TABLA_ACCESO_USUARIO_OPCION." usuario_opcion  ON (vista.id_opcion = usuario_vista.id_opcion)
        WHERE vista.bo_activo      = 1 
        AND usuario_vista.bo_activo = 1
        AND usuario_vista.id_usuario = ?
        AND vista.id_modulo = ?
        ORDER BY vista.nr_orden ASC, vista.id_opcion_padre ASC";
        
        $param	= array($id_usuario,$id_modulo);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

}
