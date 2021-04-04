<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOAccesoRolOpcion extends \pan\Kore\Entity{

    protected $table        = TABLA_ACCESO_ROL_OPCION;
    protected $primary_key  = "id_usuario";

    function __construct(){
        parent::__construct();
    }

    /**
     * Descripción : Obtiene Opciones Raiz
     * @author     : <david.guzman@cosof.cl>      - 08/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
     * @param   int $id_rol
    */
    public function getOpcionesRaiz($id_rol){
        $query = "  SELECT
            opcion.fk_vista AS fk_vista,
            opcion.fk_vista_padre,
            opcion.bo_tiene_hijo,
            opcion.gl_nombre_opcion,
            opcion.gl_icono,
            opcion.gl_url
            FROM ".$this->table." rol_opcion
            LEFT JOIN ".TABLA_ACCESO_OPCION." opcion  ON rol_opcion.fk_vista = opcion.fk_vista
            WHERE rol_opcion.id_rol = ? AND opcion.bo_activo = 1 AND opcion.fk_vista_padre = 0";

        $param	= array($id_rol);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene Sub-Opciones
     * @author     : <david.guzman@cosof.cl>      - 08/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
     * @param   int $id_rol
    */
    public function getSubOpciones($id_rol){
        $query	= "	SELECT
            opcion.fk_vista AS fk_vista,
            opcion.fk_vista_padre,
            opcion.bo_tiene_hijo,
            opcion.gl_nombre_opcion,
            opcion.gl_icono,
            opcion.gl_url
            FROM ".$this->table." rol_opcion
            LEFT JOIN ".TABLA_ACCESO_OPCION." opcion  ON rol_opcion.fk_vista = opcion.fk_vista
            WHERE rol_opcion.id_rol = ? AND opcion.bo_activo = 1 AND opcion.fk_vista_padre != 0"
            ;

        $param	= array($id_rol);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return null;
        }
    }
    
    /**
     * Descripción : Elimina Opciones del respectivo Rol
     * @author     : <david.guzman@cosof.cl>        - 08/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
     * @param   int $id_rol
    */
    public function deleteByIdRol($id_rol){

        $query = "  DELETE FROM ".$this->table."
                    WHERE id_rol = ?
                    ";

        $param	= array($id_rol);

        $response = $this->db->execQuery($query, $param);

        if ($response) {
            return TRUE;
        }else {
            return NULL;
        }

    }
   
   /**
    * Descripción   : Insertar nuevo rol opcion.
    * @author       : <david.guzman@cosof.cl>
    * @param        : array
    * @return       : $params
    */
    public function insertar($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->table."
								(
                                    fk_rol,
                                    fk_vista,
                                    permiso,
                                    id_usuario_crea,
                                    fc_crea
								)
								VALUES
								(
									?,?,?,?,now()
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }
        
        return $id;
    }
    
    /**
     * Descripción : Obtiene Opciones por Rol
     * @author  David Guzmán - <david.guzman@cosof.cl> - 09/01/2020
     * @param   int $id_rol
    */
    public function getOpcionesByRol($id_rol){
        $query	= "	SELECT
                        GROUP_CONCAT(opcion.m_v_id SEPARATOR ',') AS opRol,
                        GROUP_CONCAT(opcion.fk_modulo SEPARATOR ',') AS opRolPadre
                    FROM ".$this->table." rol_opcion
                    LEFT JOIN ".TABLA_ACCESO_OPCION." opcion  ON rol_opcion.fk_vista = opcion.m_v_id
                    WHERE rol_opcion.fk_rol = ? AND opcion.bo_activo = 1 AND rol_opcion.permiso = 1";

        $param	= array($id_rol);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return null;
        }
    }
    
    /**
     * Descripción : Obtiene Opciones por Rol y Opcion
     * @author  David Guzmán - <david.guzman@cosof.cl> - 10/01/2020
     * @param   int $id_rol
    */
    public function getByRolOpcion($id_rol,$fk_vista){
        $query	= "	SELECT
                        *
                    FROM ".$this->table."
                    WHERE fk_rol = ? AND fk_vista = ?";

        $param	= array($id_rol,$fk_vista);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return null;
        }
    }
    
    /**
     * Descripción : Obtiene Opciones por Rol
     * @author  David Guzmán - <david.guzman@cosof.cl> - 10/01/2020
     * @param   int $id_rol
    */
    public function getByRol($id_rol){
        $query	= "	SELECT
                        rol_opcion.*,
                        opcion.id_modulo
                    FROM ".$this->table." rol_opcion
                    LEFT JOIN ".TABLA_ACCESO_OPCION." opcion ON opcion.fk_vista = rol_opcion.fk_vista
                    WHERE id_rol = ?
                    AND rol_opcion.bo_activo = 1 AND opcion.bo_activo";

        $param	= array($id_rol);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return null;
        }
    }

    /**
	* Descripción : Editar activo de rol opcion
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   $id_rol,$fk_vista,$bo_activo
	*/
	public function setActivoByRolOpcion($id_rol,$fk_vista,$bo_activo){
		$query	= "	UPDATE ".$this->table."
					SET
                        bo_activo               = ".intval($bo_activo).",
                        id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE id_rol = $id_rol AND fk_vista = $fk_vista";
        
		$resp	= $this->db->execQuery($query);

		return $resp;
	}
    
    /**
	* Descripción : Editar activo de rol opcion
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   $id_rol,$bo_activo
	*/
	public function setAllActivoByRol($id_rol,$bo_activo){
		$query	= "	UPDATE ".$this->table."
					SET
                        permiso                 = ".intval($bo_activo).",
                        id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE fk_rol = $id_rol";
        
		$resp	= $this->db->execQuery($query);

		return $resp;
	}
    
    /**
	* Descripción : Editar datos registro
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   $id_usuario,$bo_activo
	*/
	public function modificar($id_rol,$fk_vista,$params){
		$query	= "	UPDATE ".$this->table."
					SET
                        permiso                 = ".intval($params['bo_activo']).",
                        id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE fk_rol = ".intval($id_rol)." AND fk_vista = ".intval($fk_vista);
        
		$resp	= $this->db->execQuery($query);

		return $resp;
    }
    
 }
