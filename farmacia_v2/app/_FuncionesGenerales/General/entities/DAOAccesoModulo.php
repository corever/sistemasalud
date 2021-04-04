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
 * @name             DAOAccesoModulo.php
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

class DAOAccesoModulo extends \pan\Kore\Entity{

    protected $_table       = TABLA_ACCESO_MODULO;
    protected $_primary_key = "m_m_id";
    
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
            $query .= " WHERE bo_activo = 1";
        }

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }
    
 }
