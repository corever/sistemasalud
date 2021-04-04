<?php
/**
 ******************************************************************************
 * Sistema           : MIS FISCALIZACIONES
 *
 * Descripcion       : Modelo para Tabla hope_acceso_modulo
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 18/07/2018
 *
 * @name             DAOAccesoPerfil.php
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

class DAOAccesoUsuarioModulo extends \pan\Kore\Entity{

    protected $_table       = TABLA_ACCESO_USUARIO_MODULO;
    protected $_primary_key = "id_usuario_modulo";
    
    function __construct(){
        parent::__construct();
    }

    public function getById($id_perfil, $retornaLista = FALSE) {
        $query = "  SELECT *
                    FROM " . $this->_table . "
                    WHERE " . $this->_primary_key . " = ?";

        $param = array($id_perfil);
        $result = $this->db->getQuery($query, $param)->runQuery();

        $rows = $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        } else {
            return $rows;
        }
    }

    public function getLista($bo_mostrar=0){

        $query	= "	SELECT * FROM ".$this->_table;
        if($bo_mostrar==1){
            $query .= " WHERE bo_mostrar = 1 AND bo_estado = 1";
        }

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }
    
    public function getListaUsuario($idUsuario = 0){

        $query	=   "SELECT DISTINCT
                        modulo.*
                    FROM ".$this->_table." usuario_modulo
                        LEFT JOIN ".TABLA_ACCESO_MODULO." modulo ON modulo.id_modulo = usuario_modulo.id_modulo
                    WHERE usuario_modulo.bo_activo = 1 AND modulo.bo_estado = 1 AND modulo.bo_mostrar = 1
                    ";
        if($idUsuario > 0){
            $query .= " AND id_usuario = ".intval($idUsuario);
        }
        
        $query .= " ORDER BY modulo.nr_orden";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function getByModuloAndUsuario($id_modulo, $id_usuario) {
        $query = "  SELECT *
                    FROM " . $this->_table . "
                    WHERE id_modulo = ? AND id_usuario = ?";

        $param = array($id_modulo,$id_usuario);
        $result = $this->db->getQuery($query, $param)->runQuery();

        $rows = $result->getRows();

        if (!empty($rows)) {
            return $rows[0];
        }

    }
    
    /**
	* Descripción : Cambiar bo_activo de usuario modulo
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/06/2020
	* @param   int   $id_modulo, $id_usuario, $bo_activo
	*/
	public function setActivo($id_modulo, $id_usuario, $bo_activo){
		$query	= "	UPDATE ".$this->_table."
					SET
                        bo_activo               = ?,
                        id_usuario_actualiza    = ".intval($_SESSION[\Constantes::SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE id_modulo     = ? AND id_usuario = ?";
        
        $params = array($bo_activo,$id_modulo,$id_usuario);
		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}

    /**
    * Descripción   : Insertar nuevo usuario modulo.
    * @author       : <david.guzman@cosof.cl> - 08/06/2020
    * @param        : array
    * @return       : int
    */
    public function insertar($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->_table."
								(
                                    id_modulo,
                                    id_usuario,
                                    id_usuario_crea,
                                    fc_crea
								)
								VALUES
								(
									?,?,".intval($_SESSION[\Constantes::SESSION_BASE]['id']).",now()
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }
        
        return $id;
    }
    
 }
