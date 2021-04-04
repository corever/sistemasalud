<?php
/**
 ******************************************************************************
 * Sistema           : SUMARIOS V4
 *
 * Descripcion       : Modelo para Tabla sum_perfi_opcion
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 06/01/2020
 *
 * @name             DAOPerfilOpcion.php
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
namespace App\Home\Entity;

class DAOPerfilOpcion extends \pan\Kore\Entity{

    protected $_tabla           = TABLA_PERFIL_OPCION_V4;
    protected $_primaria		= "id_perfil";
    protected $_transaccional	= false;

    function __construct(){
        parent::__construct();
    }
  
    /**
     * Descripción : Obtiene Opciones Raiz
     * @author  David Guzmán - <david.guzman@cosof.cl> - 08/05/2018
     * @param   int $id_perfil
    */
    public function getOpcionesRaiz($id_perfil){
        $query = "  SELECT
                        opcion.id_opcion AS id_opcion,
                        opcion.id_opcion_padre,
                        opcion.bo_tiene_hijo,
                        opcion.gl_nombre_opcion,
                        opcion.gl_icono,
                        opcion.gl_url
                    FROM ".$this->_tabla." perfil_opcion
                    LEFT JOIN ".TABLA_OPCION_V4." opcion  ON perfil_opcion.id_opcion = opcion.id_opcion
                    WHERE perfil_opcion.id_perfil = ? AND opcion.bo_activo = 1 AND opcion.id_opcion_padre = 0";
        
        $param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene Sub-Opciones
     * @author  David Guzmán - <david.guzman@cosof.cl> - 08/05/2018
     * @param   int $id_perfil
    */
    public function getSubOpciones($id_perfil){
        $query	= "	SELECT
                        opcion.id_opcion AS id_opcion,
                        opcion.id_opcion_padre,
                        opcion.bo_tiene_hijo,
                        opcion.gl_nombre_opcion,
                        opcion.gl_icono,
                        opcion.gl_url
                    FROM ".$this->_tabla." perfil_opcion
                    LEFT JOIN ".TABLA_OPCION_V4." opcion  ON perfil_opcion.id_opcion = opcion.id_opcion
                    WHERE perfil_opcion.id_perfil = ? AND opcion.bo_activo = 1 AND opcion.id_opcion_padre != 0";

        $param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return null;
        }
    }

    /**
     * Descripción : Obtiene Opciones por Perfil
     * @author  David Guzmán - <david.guzman@cosof.cl> - 09/01/2020
     * @param   int $id_perfil
    */
    public function getOpcionesByPerfil($id_perfil){
        $query	= "	SELECT
                        GROUP_CONCAT(opcion.id_opcion SEPARATOR ',') AS opPerfil
                    FROM ".$this->_tabla." perfil_opcion
                    LEFT JOIN ".TABLA_OPCION_V4." opcion  ON perfil_opcion.id_opcion = opcion.id_opcion
                    WHERE perfil_opcion.id_perfil = ? AND opcion.bo_activo = 1 AND perfil_opcion.bo_activo = 1";

        $param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return null;
        }
    }

    /**
     * Descripción : Obtiene Opciones por Usuario
     * @author  David Guzmán - <david.guzman@cosof.cl> - 09/01/2020
     * @param   int $id_perfil
    */
    public function getOpcionesByUsuario($id_usuario){
        $query	= "	SELECT
                        GROUP_CONCAT(DISTINCT CONCAT(opcion.id_opcion,IF(perfil_opcion.id_opcion = usuario_opcion.id_opcion,'_1','')) SEPARATOR ',') AS opPerfil
                    FROM ".TABLA_OPCION_V4." opcion
                    LEFT JOIN ".$this->_tabla." perfil_opcion ON perfil_opcion.id_opcion = opcion.id_opcion
                    LEFT JOIN ".TABLA_USUARIO_OPCION_V4." usuario_opcion  ON (usuario_opcion.id_opcion = opcion.id_opcion AND usuario_opcion.bo_activo = 1)
                    LEFT JOIN ".TABLA_USUARIO_PERFIL." usuario_perfil  ON usuario_perfil.id_perfil = perfil_opcion.id_perfil
                    WHERE (usuario_perfil.id_usuario = ? OR usuario_opcion.id_usuario = ?) AND opcion.bo_activo = 1 AND perfil_opcion.bo_activo = 1";
        
        $param	= array($id_usuario,$id_usuario);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return null;
        }
    }

    /**
     * Descripción : Obtiene Opciones por Perfil y Opcion
     * @author  David Guzmán - <david.guzman@cosof.cl> - 10/01/2020
     * @param   int $id_perfil
    */
    public function getByPerfilOpcion($id_perfil,$id_opcion){
        $query	= "	SELECT
                        *
                    FROM ".$this->_tabla."
                    WHERE id_perfil = ? AND id_opcion = ?";

        $param	= array($id_perfil,$id_opcion);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return null;
        }
    }
    
    /**
    * Descripción   : Insertar nuevo perfil opcion.
    * @author       : <david.guzman@cosof.cl>
    * @param        : array
    * @return       : $params
    */
    public function insertar($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->_tabla."
								(
                                    id_perfil,
                                    id_opcion,
                                    bo_activo,
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
	* Descripción : Editar activo de perfil opcion
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   $id_perfil,$bo_activo
	*/
	public function setAllActivoByPerfil($id_perfil,$bo_activo){
		$query	= "	UPDATE ".$this->_tabla."
					SET
                        bo_activo               = ".intval($bo_activo).",
                        id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE id_perfil = $id_perfil";
        
		$resp	= $this->db->execQuery($query);

		return $resp;
	}

	/**
	* Descripción : Editar activo de perfil opcion
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/01/2020
	* @param   $id_perfil,$id_opcion,$bo_activo
	*/
	public function setActivoByPerfilOpcion($id_perfil,$id_opcion,$bo_activo){
		$query	= "	UPDATE ".$this->_tabla."
					SET
                        bo_activo               = ".intval($bo_activo).",
                        id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE id_perfil = $id_perfil AND id_opcion = $id_opcion";
        
		$resp	= $this->db->execQuery($query);

		return $resp;
	}
}
