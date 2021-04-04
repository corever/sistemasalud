<?php
/**
 ******************************************************************************
 * Sistema           : SUMARIOS V4
 *
 * Descripcion       : Modelo para Tabla sum_v4_perfil
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 06/01/2020
 *
 * @name             DAOPerfil.php
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

class DAOPerfil extends \pan\Kore\Entity{

    protected $_tabla = TABLA_PERFIL_V4;
    protected $_primaria		= "id";
    protected $_transaccional	= false;


    function __construct(){
        parent::__construct();
    }

    public function getLista(){
        $query	= "	SELECT * FROM ".$this->_tabla." WHERE bo_activo = 1";
        $result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
    }

    public function getById($id_perfil, $retornaLista = FALSE){
        $query	= "SELECT *
                   FROM ".$this->_tabla."
                   WHERE ".$this->_primaria." = ?";

        $param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        $rows   = $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        }else {
            return $rows;
        }
    }

    public function getByIN($in_perfil){
        $query	= "SELECT GROUP_CONCAT(nombre SEPARATOR ', ') AS nombre
                   FROM ".$this->_tabla."
                   WHERE ".$this->_primaria." IN ($in_perfil)";

        $result	= $this->db->getQuery($query)->runQuery();

        $rows   = $result->getRows();

        if (!empty($rows)) {
            return $rows[0];
        }
    }

    public function getLastId(){
        $query	= "SELECT MAX(id)+1 AS id
                   FROM ".$this->_tabla;
        $result	= $this->db->getQuery($query)->runQuery();
        $row   = $result->getRows(0);
        return $row->id;
    }

    /**
    * Descripción   : Insertar nuevo perfil.
    * @author       : <david.guzman@cosof.cl>
    * @param        : array
    * @return       : $params
    */
    public function insertarNuevo($params) {

        $id     = $this->getLastId();
        $query  = "INSERT INTO ".$this->_tabla."
								(
                                    id,
                                    nombre,
                                    descripcion,
                                    soporte,
                                    id_usuario_crea,
                                    fc_creacion
								)
								VALUES
								(
									$id,?,?,?,?,now()
								)";

		if($this->db->execQuery($query,$params)){
            return $id;
        }else{
            return false;
        }
        
        
    }

	/**
	* Descripción : Editar perfil
	* @author  David Guzmán <david.guzman@cosof.cl> - 09/01/2020
	* @param   array   $gl_token, $params
	*/
	public function modificar($id_perfil,$params){
		$query	= "	UPDATE ".$this->_tabla."
					SET
                        nombre                  = ?,
                        descripcion             = ?,
                        soporte                 = ?,
                        id_usuario_actualiza    = ?,
                        fc_actualiza            = now()
					WHERE id = $id_perfil";
        
		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}

}
