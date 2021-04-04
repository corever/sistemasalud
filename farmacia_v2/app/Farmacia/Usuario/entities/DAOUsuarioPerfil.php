<?php

namespace App\Usuario\Entity;

class DAOUsuarioPerfil extends \pan\Kore\Entity{

	protected $_tabla			= TABLA_USUARIO_PERFIL_V4;
	protected $_primaria		= "id";
	protected $_transaccional	= false;

	function __construct(){
		parent::__construct();
	}

	public function getById($id, $retornaLista = FALSE){
		$query	= "	SELECT ".$this->_tabla.".*,
                            perfil.nombre AS gl_perfil
					FROM ".$this->_tabla."
                        LEFT JOIN sum_v4_perfil perfil  ON ".$this->_tabla.".id_perfil     = perfil.id
					WHERE ".$this->_tabla.".".$this->_primaria." = ?";

		$param	= array($id);
		$result	= $this->db->getQuery($query,$param)->runQuery();

		$rows	= $result->getRows();

		if (!empty($rows) && !$retornaLista) {
			return $rows[0];
		}else {
			return $rows;
		}
	}

	/**
	* Descripción : Cuenta la cantidad de perfiles que tiene un usuario
	* @author  Sebastián Carroza <sebastian.carroza@cosof.cl> - 10/08/2019
	* @param   int   $id_usuario
	*/
	public function countPerfiles($id_usuario){
		$query	= " SELECT
						id_usuario
					FROM ".$this->_tabla."
					WHERE  id_usuario= ".$id_usuario;
		$param	= array($id_usuario);
		$result = $this->db->getQuery($query,$param)->runQuery();

		return $result->getNumRows();
	}

	/**
	* Descripción : Cuenta la cantidad de perfiles que tiene un usuario
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   int   $id_usuario
	*/
	public function obtPerfilesUsuario($id_usuario){
		$query	= "	SELECT
                        usuario_perfil.*,
                        perfil.nombre AS gl_perfil,
                        IFNULL(oficina.nombre,'') AS gl_oficina,
                        IFNULL(region.nombre,'') AS gl_region,
                        IFNULL(ambito.nombre,'') AS gl_ambito
                        
					FROM ".$this->_tabla." usuario_perfil                        
                        LEFT JOIN sum_v4_perfil perfil  ON usuario_perfil.id_perfil     = perfil.id
                        LEFT JOIN sum_usuario   usuario ON usuario_perfil.id_usuario    = usuario.USUA_id
                        LEFT JOIN sum_region    region  ON usuario_perfil.id_region     = region.id
                        LEFT JOIN sum_ambito    ambito  ON usuario_perfil.id_ambito     = ambito.id
                        LEFT JOIN sum_oficina   oficina ON usuario_perfil.id_oficina    = oficina.id
                        
					WHERE   usuario_perfil.id_usuario   = ?
                        AND usuario_perfil.bo_activo    = 1";

		$param	= array($id_usuario);
		$result	= $this->db->getQuery($query,$param)->runQuery();

		$rows	= $result->getRows();

		if (!empty($rows)) {
			return $rows;
		}
	}

	/**
	* Descripción : Cuenta la cantidad de perfiles que tiene un usuario
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   int   $id_usuario
	*/
	public function obtPerfilDefectoUsuario($id_usuario){
		$query	= "	SELECT
                        usuario_perfil.*,
                        perfil.nombre AS gl_perfil,
                        IFNULL(oficina.nombre,'') AS gl_oficina,
                        IFNULL(region.nombre,'') AS gl_region,
                        IFNULL(ambito.nombre,'') AS gl_ambito
                        
					FROM ".$this->_tabla." usuario_perfil                        
                        LEFT JOIN sum_v4_perfil perfil  ON usuario_perfil.id_perfil     = perfil.id
                        LEFT JOIN sum_usuario   usuario ON usuario_perfil.id_usuario    = usuario.USUA_id
                        LEFT JOIN sum_region    region  ON usuario_perfil.id_region     = region.id
                        LEFT JOIN sum_ambito    ambito  ON usuario_perfil.id_ambito     = ambito.id
                        LEFT JOIN sum_oficina   oficina ON usuario_perfil.id_oficina    = oficina.id
                        
					WHERE   usuario_perfil.id_usuario   = ?
                        AND usuario_perfil.bo_activo    = 1
                        AND usuario_perfil.defecto = 1";

		$param	= array($id_usuario);
		$result	= $this->db->getQuery($query,$param)->runQuery();

		$row	= $result->getRows(0);

		if (!empty($row)) {
			return $row;
		}
	}

	/**
	* Descripción : Obtiene un array de la columna que se necesita por id usuario
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   int   $id_usuario
	*/
	public function obtSoloColumnaUsuario($id_usuario,$gl_columna){
        $arr    = array();
		$query	= "	SELECT
                        DISTINCT $gl_columna
					FROM ".$this->_tabla."                        
					WHERE   id_usuario   = ? AND bo_activo = 1
                    AND $gl_columna IS NOT NULL AND $gl_columna != '' AND $gl_columna != 0";

		$param	= array($id_usuario);
		$result	= $this->db->getQuery($query,$param)->runQuery();

		$rows	= $result->getRows();

		if (!empty($rows)) {
            foreach($rows as $row){
                $arr[]  = $row->$gl_columna;
            }
            
			return $arr;
		}
	}

	/**
	* Descripción : Obtener perfil usuario por id_usuario e id_perfil
	* @author  David Guzmán <david.guzman@cosof.cl> - 20/01/2020
	* @param   int   $id_usuario, $id_perfil
	*/
	public function obtPerfilUsuario($id_usuario,$id_perfil,$id_region,$id_oficina,$id_ambito){
		$query	= "	SELECT
                        usuario_perfil.*,
                        perfil.nombre AS gl_perfil,
                        (SELECT sum_oficina.nombre FROM sum_oficina WHERE id = usuario_perfil.id_oficina) AS gl_oficina,
                        (SELECT sum_region.nombre FROM sum_region WHERE id = usuario.id_region) AS gl_region
					FROM ".$this->_tabla." usuario_perfil
                        LEFT JOIN sum_v4_perfil perfil ON usuario_perfil.id_perfil = perfil.id
                        LEFT JOIN sum_usuario usuario ON usuario_perfil.id_usuario = usuario.USUA_id
					WHERE usuario_perfil.id_usuario = ? AND usuario_perfil.id_perfil = ? AND usuario_perfil.id_region = ?
                     AND usuario_perfil.id_oficina = ? AND usuario_perfil.id_ambito = ?";

		$param	= array($id_usuario,$id_perfil,$id_region,$id_oficina,$id_ambito);
		$result	= $this->db->getQuery($query,$param)->runQuery();

		$rows	= $result->getRows(0);

		if (!empty($rows)) {
			return $rows;
		}
	}
    
	/**
	* Descripción : Editar perfil
	* @author  David Guzmán <david.guzman@cosof.cl> - 20/01/2020
	* @param   int   $id, $bo_activo
	*/
	public function setActivo($id,$bo_activo){
		$query	= "	UPDATE ".$this->_tabla."
					SET
                        bo_activo               = ?,
                        id_usuario_actualiza    = ".$_SESSION[SESSION_BASE]['id'].",
                        fc_actualiza            = now()
					WHERE id = $id";
        
        $params = array($bo_activo);
		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}
    
	/**
	* Descripción : Editar perfil
	* @author  David Guzmán <david.guzman@cosof.cl> - 20/01/2020
	* @param   int   $id, $bo_activo
	*/
	public function setDefecto($id,$bo_defecto){
		$query	= "	UPDATE ".$this->_tabla."
					SET
                        defecto               = ?,
                        id_usuario_actualiza    = ".$_SESSION[SESSION_BASE]['id'].",
                        fc_actualiza            = now()
					WHERE id = $id";
        
        $params = array($bo_defecto);
		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}

    /**
    * Descripción   : Insertar nuevo usuario perfil.
    * @author       : <david.guzman@cosof.cl> - 20/01/2020
    * @param        : array
    * @return       : int
    */
    public function insertar($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->_tabla."
								(
                                    id_usuario,
                                    id_perfil,
                                    id_region,
                                    id_oficina,
                                    id_ambito,
                                    bo_nacional,
                                    bo_jefe,
                                    defecto,
                                    id_usuario_crea,
                                    fc_creacion
								)
								VALUES
								(
									?,?,?,?,?,?,?,?,".$_SESSION[SESSION_BASE]['id'].",now()
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }
        
        return $id;
    }

	/**
	* Descripción : Editar Usuario
	* @author  David Guzmán <david.guzman@cosof.cl> - 20/01/2020
	* @param   array   $gl_token, $params
	*/
	public function modificar($id,$params){
		$query	= "	UPDATE ".$this->_tabla."
					SET
                        id_usuario              = ?,
                        id_perfil               = ?,
                        id_region               = ?,
                        id_oficina              = ?,
                        id_ambito               = ?,
                        bo_nacional             = ?,
                        bo_jefe                 = ?,
                        defecto                 = ?,
                        id_usuario_actualiza    = ".$_SESSION[SESSION_BASE]['id'].",
                        fc_actualiza            = now()
					WHERE id = $id";
        
		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}
    
}