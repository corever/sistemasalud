<?php
/**
 ******************************************************************************
 * Sistema           : SUMARIOS V4
 *
 * Descripcion       : Modelo para Tabla hope_usuario_historial
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 23/01/2020
 *
 * @name             DAOUsuarioHistorial.php
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
namespace App\Usuario\Entity;

class DAOUsuarioHistorial extends \pan\Kore\Entity{

	protected $_tabla			= "hope_usuario_historial";
	protected $_primaria		= "id_historial";
	protected $_transaccional	= false;

	function __construct(){
		parent::__construct();
	}

	public function getLista(){
		$query	= "SELECT * FROM ".$this->_tabla;
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

	public function getHistorialTipoById($id_historial_tipo){
		$query	= " SELECT *
                    FROM hope_usuario_historial_tipo
                    WHERE id_historial_tipo = ?";
		$result	= $this->db->getQuery($query,array($id_historial_tipo))->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}

	public function getByToken($gl_token){
		$query	= " SELECT
                        tipo.gl_nombre AS gl_tipo_historial,
                        historial.gl_descripcion AS gl_descripcion,
                        IF(usuario_crea.gl_nombres IS NOT NULL,CONCAT(COALESCE(usuario_crea.gl_nombres,''),' ',COALESCE(usuario_crea.gl_apellidos,'')),'--') AS gl_usuario_accion,
                        DATE_FORMAT(historial.fc_crea, '%d-%m-%Y') AS fc_creacion
                    FROM ".$this->_tabla." historial
                        LEFT JOIN hope_usuario_historial_tipo tipo ON tipo.id_historial_tipo = historial.id_historial_tipo
                        LEFT JOIN hope_acceso_usuario usuario ON usuario.id_usuario = historial.id_usuario
                        LEFT JOIN hope_acceso_usuario usuario_crea ON usuario_crea.id_usuario = historial.id_usuario_crea
                    WHERE usuario.gl_token = '".$gl_token."'
                    ORDER BY DATE_FORMAT(historial.fc_crea, '%Y-%m-%d') ASC";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

    /**
    * Descripción   : Insertar nuevo evento de usuario.
    * @author      : David Guzmán <david.guzman@cosof.cl>
    * @param       : array
    * @return      : int
    */
    public function insertarEvento($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->_tabla."
								(
                                    id_usuario,
                                    id_historial_tipo,
                                    gl_descripcion,
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
}
