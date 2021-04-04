<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOAccesoUsuarioOpcion extends \pan\Kore\Entity{

  protected $table              = TABLA_ACCESO_USUARIO_OPCION;
  protected $primary_key		= "id_usuario";

  function __construct(){
      parent::__construct();
  }
  /**
 * Descripción : Obtiene Opciones Raiz
 * @author     : <david.guzman@cosof.cl>      - 08/05/2018
 * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
   * @param   int $id_usuario
 */
  public function getOpcionesRaiz($id_usuario){
      $query = "  SELECT
          opcion.id_opcion AS id_opcion,
          opcion.id_opcion_padre,
          opcion.bo_tiene_hijo,
          opcion.gl_nombre_opcion,
          opcion.gl_icono,
          opcion.gl_url
        FROM ".$this->table." usuario_opcion
        LEFT JOIN ".TABLA_ACCESO_OPCION." opcion  ON usuario_opcion.id_opcion = opcion.id_opcion
        WHERE usuario_opcion.id_usuario = ? AND opcion.bo_activo = 1 AND opcion.id_opcion_padre = 0";

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
 * @author     : <david.guzman@cosof.cl>      - 08/05/2018
 * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
   * @param   int $id_usuario
 */
  public function getSubOpciones($id_usuario){
      $query	= "	SELECT
          opcion.id_opcion AS id_opcion,
          opcion.id_opcion_padre,
          opcion.bo_tiene_hijo,
          opcion.gl_nombre_opcion,
          opcion.gl_icono,
          opcion.gl_url
        FROM ".$this->table." usuario_opcion
        LEFT JOIN ".TABLA_ACCESO_OPCION." opcion  ON usuario_opcion.id_opcion = opcion.id_opcion
        WHERE usuario_opcion.id_usuario = ? AND opcion.bo_activo = 1 AND opcion.id_opcion_padre != 0"
        ;

      $param	= array($id_usuario);
      $result	= $this->db->getQuery($query,$param)->runQuery();

      if($result->getNumRows()>0){
          return $result->getRows();
      }else{
          return null;
      }
  }
  /**
   * Descripción : Elimina Opciones del respectivo usuario
   * @author     : <david.guzman@cosof.cl>        - 08/05/2018
   * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
   * @param   int $id_usuario
   */
   public function deleteByIdUsuario($id_usuario){

       $query = "  DELETE FROM ".$this->table."
                   WHERE id_usuario = ?
                ";

       $param	= array($id_usuario);

       $response = $this->db->execQuery($query, $param);

       if ($response) {
           return TRUE;
       }else {
           return NULL;
       }

   }
   
   /**
    * Descripción   : Insertar nuevo usuario opcion.
    * @author       : <david.guzman@cosof.cl>
    * @param        : array
    * @return       : $params
    */
    public function insertar($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->table."
								(
                                    id_usuario,
                                    id_opcion,
                                    bo_agregar,
                                    bo_modificar,
                                    bo_eliminar,
                                    bo_activo,
                                    id_usuario_crea,
                                    fc_crea
								)
								VALUES
								(
									?,?,?,?,?,?,?,now()
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }
        
        return $id;
    }
    
    /**
     * Descripción : Obtiene Opciones por usuario
     * @author  David Guzmán - <david.guzman@cosof.cl> - 09/01/2020
     * @param   int $id_usuario
    */
    public function getOpcionesByUsuario($id_usuario){
        $query	= "	SELECT
                        GROUP_CONCAT(opcion.id_opcion SEPARATOR ',') AS opUsuario
                    FROM ".$this->table." usuario_opcion
                    LEFT JOIN ".TABLA_ACCESO_OPCION." opcion  ON usuario_opcion.id_opcion = opcion.id_opcion
                    WHERE usuario_opcion.id_usuario = ? AND opcion.bo_activo = 1 AND usuario_opcion.bo_activo = 1";

        $param	= array($id_usuario);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return null;
        }
    }
    
    /**
     * Descripción : Obtiene Opciones por usuario
     * @author  David Guzmán - <david.guzman@cosof.cl> - 09/01/2020
     * @param   int $id_usuario
    */
    public function getPermisosByUsuario($id_usuario){
        $arr = array("1"=>array(),"2"=>array(),"3"=>array(),"4"=>array(),"5"=>array(),"6"=>array());
        $query	= "	SELECT
                        usuario_opcion.*,
                        opcion.id_modulo
                    FROM ".$this->table." usuario_opcion
                    LEFT JOIN ".TABLA_ACCESO_OPCION." opcion  ON usuario_opcion.id_opcion = opcion.id_opcion
                    WHERE usuario_opcion.id_usuario = ? AND opcion.bo_activo = 1 AND usuario_opcion.bo_activo = 1";

        $param	= array($id_usuario);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            
            foreach($result->getRows() as $item){
                $arr[$item->id_modulo][$item->id_opcion] = array("1"=>$item->bo_agregar,"2"=>$item->bo_modificar,"3"=>$item->bo_eliminar);
            }
            
        }

        return $arr;
    }
    
    /**
     * Descripción : Obtiene Opciones por usuario y Opcion
     * @author  David Guzmán - <david.guzman@cosof.cl> - 10/01/2020
     * @param   int $id_usuario
    */
    public function getByUsuarioOpcion($id_usuario,$id_opcion){
        $query	= "	SELECT
                        *
                    FROM ".$this->table."
                    WHERE id_usuario = ? AND id_opcion = ?";

        $param	= array($id_usuario,$id_opcion);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return null;
        }
    }
    
    /**
	* Descripción : Editar activo de usuario opcion
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   $id_usuario,$id_opcion,$bo_activo
	*/
	public function setActivoByUsuarioOpcion($id_usuario,$id_opcion,$bo_activo){
		$query	= "	UPDATE ".$this->table."
					SET
                        bo_activo               = ".intval($bo_activo).",
                        id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE id_usuario = $id_usuario AND id_opcion = $id_opcion";
        
		$resp	= $this->db->execQuery($query);

		return $resp;
	}
    
    /**
	* Descripción : Editar activo de usuario opcion
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   $id_usuario,$bo_activo
	*/
	public function setAllActivoByUsuario($id_usuario,$bo_activo,$id_modulo=0){
        $query	= "	UPDATE ".$this->table." usu_opcion
                    LEFT JOIN ".TABLA_ACCESO_OPCION." opcion ON usu_opcion.id_opcion = opcion.id_opcion
					SET
                        usu_opcion.bo_activo               = ".intval($bo_activo).",
                        usu_opcion.id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
                        usu_opcion.fc_actualiza            = now()
                    WHERE usu_opcion.id_usuario = $id_usuario";
                    
        if($id_modulo != 0){
            $query .= " AND opcion.id_modulo = ".intval($id_modulo);
        }
        
		$resp	= $this->db->execQuery($query);

		return $resp;
    }

    public function validarPermisos($id_usuario, $id_opcion, $accion){
        $query	= "
        SELECT ".$accion."      
        FROM   ".$this->table."
        WHERE id_usuario = ? 
        AND   id_opcion  = ?";

        $param	= array($id_usuario,$id_opcion);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0)->$accion;
        }else{
            return null;
        }
    }
    
    /**
	* Descripción : Editar activo de usuario opcion
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   $id_usuario,$bo_activo
	*/
	public function modificar($id_usuario,$id_opcion,$params){
		$query	= "	UPDATE ".$this->table."
					SET
                        bo_activo               = ".intval($params['bo_activo']).",
                        bo_agregar              = ".intval($params['bo_agregar']).",
                        bo_modificar            = ".intval($params['bo_modificar']).",
                        bo_eliminar             = ".intval($params['bo_eliminar']).",
                        id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE id_usuario = ".intval($id_usuario)." AND id_opcion = ".intval($id_opcion);
        
		$resp	= $this->db->execQuery($query);

		return $resp;
    }

    
 }
