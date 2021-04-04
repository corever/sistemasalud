<?php
/**
 ******************************************************************************
 * Sistema           : HOPE
 *
 * Descripcion       : Modelo para Tabla hope_traductor
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 10/06/2020
 *
 * @name             DAOTraductor.php
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

class DAOTraductor extends \pan\Kore\Entity{

    protected $_table       = TABLA_TRADUCTOR;
    protected $primary_key = "id_idioma";
    
    function __construct(){
        parent::__construct();
    }

    public function getById($id_idioma){
        $query	= " SELECT *
                    FROM ".$this->_table."
                    WHERE id_idioma = ?";

        $param	    = array($id_idioma);
        $result	    = $this->db->getQuery($query,$param)->runQuery();
        $rows       = $result->getRows();

        if (!empty($rows)) {
            return $rows[0];
        }else {
            return null;
        }
    }

    public function getLista(){

        $query	= "	SELECT * FROM ".$this->_table." WHERE bo_mostrar = 1 AND bo_estado = 1";
        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }
    
    /**
	* Descripción : Editar JSON BD
	* @author  David Guzmán <david.guzman@cosof.cl> - 20/05/2020
	* @param   array   $id_traductor, $json_base
	*/
	public function updateById($id_traductor,$json_base){
		$query	= "	UPDATE ".$this->_table."
					SET
                        json_base               = ?,
                        id_usuario_actualiza    = ".intval($_SESSION[\Constantes::SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE id_traductor = $id_traductor";
        
		$resp	= $this->db->execQuery($query, array($json_base));

		return $resp;
	}
    
 }
