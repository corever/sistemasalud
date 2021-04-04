<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOAccesoUsuarioRol extends \pan\Kore\Entity{

	protected $table			= TABLA_ACCESO_USUARIO_ROL;
	protected $primary_key		= "mur_id";
	protected $_transaccional	= false;

	function __construct(){
		parent::__construct();
	}

	public function getById($id, $retornaLista = FALSE){
		$query	= "	SELECT ".$this->table.".*,
                            rol.nombre AS gl_rol
					FROM ".$this->table."
                        LEFT JOIN hope_v4_rol rol  ON ".$this->_table.".id_rol     = rol.id
					WHERE ".$this->table.".".$this->primary_key." = ?";

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
	* Descripción : Cuenta la cantidad de roles que tiene un usuario
	* @author  Sebastián Carroza <sebastian.carroza@cosof.cl> - 10/08/2019
	* @param   int   $id_usuario
	*/
	public function countRoles($id_usuario){
		$query	= " SELECT
						id_usuario
					FROM ".$this->table."
					WHERE  id_usuario = ".$id_usuario;
		$param	= array($id_usuario);
		$result = $this->db->getQuery($query,$param)->runQuery();

		return $result->getNumRows();
	}

	/**
	* Descripción : Cuenta la cantidad de roles que tiene un usuario
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   int   $id_usuario
	*/
	public function obtRolesUsuario($id_usuario){
		$query	= "	SELECT
                        usuario_rol.*,
                        rol.rol_nombre AS gl_rol,
						rol.bo_nacional,
						rol.bo_regional,
						IFNULL(region.nombre_region_corto,'') AS gl_region,
						IFNULL(comuna.comuna_nombre,'') AS gl_comuna,
						IFNULL(territorio.nombre_territorio,'') AS gl_territorio,
						IFNULL(local.local_numero,'') AS nr_local,
						IFNULL(local.local_nombre,'') AS gl_local,
						IFNULL(bodega.bodega_nombre,'') AS gl_bodega,
						IFNULL(farmacia.farmacia_rut,'') AS gl_farmacia_rut,
						IFNULL(farmacia.farmacia_razon_social,'') AS gl_farmacia_razon_social
					FROM ".$this->table." usuario_rol                        
                        LEFT JOIN ".TABLA_ACCESO_ROL."    	rol  	ON usuario_rol.mur_fk_rol		= rol.rol_id
						LEFT JOIN ".TABLA_ACCESO_USUARIO."	usuario ON usuario_rol.mur_fk_usuario	= usuario.mu_id
						LEFT JOIN ".TABLA_DIRECCION_REGION." region ON usuario_rol.id_region_midas 	= region.id_region_midas
						LEFT JOIN ".TABLA_DIRECCION_TERRITORIO." territorio ON usuario_rol.mur_fk_territorio 	= territorio.territorio_id
						LEFT JOIN ".TABLA_LOCAL." ON usuario_rol.fk_local 	= local.local_id
						LEFT JOIN ".TABLA_FARMACIA." ON usuario_rol.fk_farmacia 	= farmacia.farmacia_id
						LEFT JOIN ".TABLA_BODEGA." ON usuario_rol.fk_bodega 	= bodega.bodega_id
						LEFT JOIN ".TABLA_DIRECCION_COMUNA." comuna ON bodega.id_comuna_midas	= comuna.id_comuna_midas
					WHERE usuario_rol.mur_fk_usuario = ? AND usuario_rol.mur_estado_activado = 1";

		$param	= array($id_usuario);
		$result	= $this->db->getQuery($query,$param)->runQuery();

		$rows	= $result->getRows();

		if (!empty($rows)) {
			return $rows;
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
					FROM ".$this->table."                        
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
	* Descripción : Obtener rol usuario por id_usuario e id_rol
	* @author  David Guzmán <david.guzman@cosof.cl> - 20/01/2020
	* @param   int   $id_usuario, $id_rol
	*/
	public function obtRolUsuario($id_usuario,$id_rol){

		$query	= "	SELECT
                        usuario_rol.*,
						rol.rol_nombre AS gl_rol,
						IFNULL(region.nombre_region_corto,'') AS gl_region,
						IFNULL(comuna.comuna_nombre,'') AS gl_comuna,
						IFNULL(territorio.nombre_territorio,'') AS gl_territorio,
						IFNULL(local.local_numero,'') AS nr_local,
						IFNULL(local.local_nombre,'') AS gl_local,
						IFNULL(bodega.bodega_nombre,'') AS gl_bodega,
						IFNULL(farmacia.farmacia_rut,'') AS gl_farmacia_rut,
						IFNULL(farmacia.farmacia_razon_social,'') AS gl_farmacia_razon_social
					FROM ".$this->table." usuario_rol
                        LEFT JOIN ".TABLA_ACCESO_ROL." rol ON usuario_rol.mur_fk_rol = rol.rol_id
                        LEFT JOIN ".TABLA_ACCESO_USUARIO." usuario ON usuario_rol.mur_fk_usuario = usuario.mu_id
						LEFT JOIN ".TABLA_DIRECCION_REGION." region ON usuario_rol.id_region_midas 	= region.id_region_midas
						LEFT JOIN ".TABLA_DIRECCION_COMUNA." comuna ON usuario_rol.id_comuna_midas 	= comuna.id_comuna_midas
						LEFT JOIN ".TABLA_DIRECCION_TERRITORIO." territorio ON usuario_rol.mur_fk_territorio 	= territorio.territorio_id
						LEFT JOIN ".TABLA_LOCAL." ON usuario_rol.fk_local 	= local.local_id
						LEFT JOIN ".TABLA_FARMACIA." ON usuario_rol.fk_farmacia 	= farmacia.farmacia_id
						LEFT JOIN ".TABLA_BODEGA." ON usuario_rol.fk_bodega 	= bodega.bodega_id
					WHERE usuario_rol.mur_fk_usuario = ? AND usuario_rol.mur_fk_rol = ?
					 ";

		$param	= array($id_usuario,$id_rol);
		$result	= $this->db->getQuery($query,$param)->runQuery();
		$rows	= $result->getRows(0);

		if (!empty($rows)) {
			return $rows;
		}
	}
    
	/**
	* Descripción : Editar rol
	* @author  David Guzmán <david.guzman@cosof.cl> - 20/01/2020
	* @param   int   $id, $bo_activo
	*/
	public function setActivo($id,$bo_activo){
		$query	= "	UPDATE ".$this->table."
					SET
						mur_estado_activado  	= ?
                        #id_usuario_actualiza    = ".$_SESSION[\Constantes::SESSION_BASE]['id'].",
                        #fc_actualiza            = now()
					WHERE mur_id	= $id";
        
        $params = array($bo_activo);
		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}

    /**
    * Descripción   : Insertar nuevo usuario rol.
    * @author       : <david.guzman@cosof.cl> - 20/01/2020
    * @param        : array
    * @return       : int
    */
    public function insertar($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->table."
								(
                                    mur_fk_usuario,
                                    mur_fk_rol,
                                    mur_estado_activado,
                                    fk_farmacia,
									fk_local,
									fk_bodega,
									id_region_midas,
									mur_fk_territorio,
									id_comuna_midas,
									mur_fk_localidad,
                                    rol_fecha_creacion,
                                    rol_creador
								)
								VALUES
								(
									?,?,?,?,?,?,?,?,?,?,now(),".intval($_SESSION[\Constantes::SESSION_BASE]['id'])."
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
		$query	= "	UPDATE ".$this->table."
					SET
						mur_fk_usuario      	= ?,
						mur_fk_rol           	= ?,
						mur_estado_activado		= ?,
                        fk_farmacia            	= ?,
                        fk_local              	= ?,
						fk_bodega             	= ?,
						id_region_midas			= ?,
						mur_fk_territorio		= ?,
						id_comuna_midas			= ?,
						mur_fk_localidad		= ?
					WHERE mur_id = ".intval($id);
        
		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}

	/**
	* Descripción : Editar Usuario
	* @author  David Guzmán <david.guzman@cosof.cl> - 20/01/2020
	* @param   array   $gl_token, $params
	*/
	public function setActivoByLocalUsuarioRol($id_local,$id_usuario,$id_rol,$bo_activo=0){
		$query	= "	UPDATE ".$this->table."
					SET
                        bo_activo              	= ".intval($bo_activo)."
					WHERE fk_local = ?
					AND mur_fk_usuario = ?
					AND mur_fk_rol = ?";
        
		$resp	= $this->db->execQuery($query,array($id_local,$id_usuario,$id_rol));

		return $resp;
	}

	/* Devuelve json permisos */
    public function getJsonPermisos($id_usuario, $id_rol){
        $query	= "
        SELECT json_permisos     
        FROM   ".$this->table."
        WHERE id_usuario 	= ? 
        AND   id_rol  		= ?";

        $param	= array($id_usuario,$id_rol);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return null;
        }
    }
    
}