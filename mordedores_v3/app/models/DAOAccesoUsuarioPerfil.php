<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 *
 * Descripcion       : Modelo para Tabla mor_acceso_usuario_perfil
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 08/05/2018
 *
 * @name             DAOAccesoUsuarioPerfil.php
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
class DAOAccesoUsuarioPerfil extends Model{

    protected $_tabla			= "mor_acceso_usuario_perfil";
    protected $_primaria		= "id_usuario_perfil";
    protected $_transaccional	= false;

    function __construct()
    {
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

    public function getDetalleById($id){
        $query	= "	SELECT
                        usuario_perfil.*,
                        perfil.bo_nacional,
                        perfil.bo_regional,
                        perfil.bo_oficina,
                        perfil.bo_comunal
                    FROM ".$this->_tabla." usuario_perfil
                    LEFT JOIN mor_acceso_perfil perfil ON usuario_perfil.id_perfil = perfil.id_perfil
					WHERE ".$this->_primaria." = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query,$param);

        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getPrincipalByUsuario($id_usuario){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE id_usuario = ? AND bo_activo = 1 AND bo_principal = 1";

		$param	= array($id_usuario);
        $result	= $this->db->getQuery($query,$param);

        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
    /**
	 * Descripción : obtiene por usuario
     * @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
     * @param   int   $id_usuario
	 */
    public function getByUsuario($id_usuario){
        $query	= "	SELECT
                        usuario_perfil.*,
                        perfil.gl_nombre_perfil,
                        perfil.bo_nacional,
                        perfil.bo_regional,
                        perfil.bo_oficina,
                        perfil.bo_comunal,
                        perfil.bo_establecimiento,
                        region.gl_nombre_region AS nombre_region,
                        oficina.gl_nombre_oficina AS nombre_oficina,
                        comuna.gl_nombre_comuna AS nombre_comuna,
                        establecimiento.gl_nombre_establecimiento AS nombre_establecimiento,
                        servicio.gl_nombre_servicio AS nombre_servicio
                    FROM ".$this->_tabla." usuario_perfil
                        LEFT JOIN mor_acceso_perfil perfil ON usuario_perfil.id_perfil = perfil.id_perfil
                        LEFT JOIN mor_direccion_region region ON usuario_perfil.id_region = region.id_region
                        LEFT JOIN mor_direccion_oficina oficina ON usuario_perfil.id_oficina = oficina.id_oficina
                        LEFT JOIN mor_direccion_comuna comuna ON usuario_perfil.id_comuna = comuna.id_comuna
                        LEFT JOIN mor_establecimiento_salud establecimiento ON usuario_perfil.id_establecimiento = establecimiento.id_establecimiento
                        LEFT JOIN mor_servicio_salud servicio ON usuario_perfil.id_servicio = servicio.id_servicio
					WHERE usuario_perfil.id_usuario = ? AND usuario_perfil.bo_activo = 1";

		$param	= array($id_usuario);
        $result	= $this->db->getQuery($query,$param);

        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    /**
	 * Descripción : obtiene perfil inactivo similar
     * @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
     * @param   array $params
	 */
    public function getSimilarInactivo($params){
        $query	= "	SELECT
                        *
                    FROM ".$this->_tabla."
					WHERE id_usuario = ? AND id_region = ? AND id_oficina = ? AND id_comuna = ?
                        AND id_establecimiento = ? AND id_servicio = ? AND id_perfil = ? AND bo_activo = ?";

        $result	= $this->db->getQuery($query,$params);

        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : obtiene perfil inactivo similar
     * @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
     * @param   array $params
	 */
    public function getByRegionAndUsuario($params){
        $query	= "	SELECT
                        *
                    FROM ".$this->_tabla."
					WHERE id_usuario = ? AND id_region = ?";

        $result	= $this->db->getQuery($query,$params);

        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : obtiene perfil inactivo similar
     * @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
     * @param   array $params
	 */
    public function getMaxCorrelativoByRegion($id_region){
        $query	= "	SELECT
                        MAX(nr_correlativo) as max_correlativo
                    FROM ".$this->_tabla."
					WHERE id_region = ?";

        $result	= $this->db->getQuery($query,array($id_region));

        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : SETEAR bo_activo en 1=ACTIVO o 0=DESACTIVO
     * @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
     * @param   int $id, boolean $bo_activo
	 */
    public function uptActivo($id,$bo_activo){
        $query	= "	UPDATE ".$this->_tabla."
                        SET bo_activo               = ".intval($bo_activo).",
                            id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
                            fc_actualiza			= now()
					WHERE id_usuario_perfil = ".$id."
                    ";
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
	 * Descripción : SETEAR bo_principal en 1 o 0
     * @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
     * @param   int $id, boolean $bo_activo
	 */
    public function uptPrincipal($id,$bo_principal){
        $query	= "	UPDATE ".$this->_tabla."
                        SET bo_principal            = ".intval($bo_principal).",
                            id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
                            fc_actualiza			= now()
					WHERE id_usuario_perfil = ".$id."
                    ";
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
	 * Descripción : SETEAR bo_principal todos los perfiles de usuario
     * @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
     * @param   int $id, boolean $bo_activo
	 */
    public function uptPrincipalTodos($id_usuario,$bo_principal){
        $query	= "	UPDATE ".$this->_tabla."
                        SET bo_principal            = ".intval($bo_principal).",
                            id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
                            fc_actualiza			= now()
					WHERE id_usuario = ".$id_usuario."
                    ";
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
	 * Descripción : Insertar Perfil Usuario
	 * @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
     * @param   array  $parametros
	 */
    public function insPerfilUsuario($parametros){
        $query	= "	INSERT INTO ".$this->_tabla." (
						id_usuario,
                        id_perfil,
                        id_region,
                        id_oficina,
                        id_comuna,
                        id_establecimiento,
                        id_servicio,
                        nr_correlativo,
                        bo_principal,
                        id_usuario_crea,
                        fc_crea
                    ) VALUES (
						".intval($parametros['id_usuario']).",
						".intval($parametros['id_perfil']).",
						".intval($parametros['id_region']).",
						".intval($parametros['id_oficina']).",
						".intval($parametros['id_comuna']).",
						".intval($parametros['id_establecimiento']).",
						".intval($parametros['id_servicio']).",
						".intval($parametros['nr_correlativo']).",
						".intval($parametros['bo_principal']).",
						".intval($_SESSION[SESSION_BASE]['id']).",
						now()
					)";

        if ($this->db->execQuery($query)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }


}

?>