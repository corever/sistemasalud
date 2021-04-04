<?php
/**
 ******************************************************************************
 * Sistema           : MIS FISCALIZACIONES
 *
 * Descripcion       : Modelo para Tabla mfis_acceso_perfil
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 18/07/2018
 *
 * @name             DAOAccesoIdioma.php
 *
 * @version          1.0
 *
 * @author           Sebastián Carroza <sebastian.carroza@cosof.cl>
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

class DAOAccesoIdioma extends \pan\Kore\Entity{

    protected $_table       = TABLA_ACCESO_IDIOMA;
    protected $primary_key = "id_idioma";
    
    function __construct(){
        parent::__construct();
    }

    public function getById($id_perfil, $retornaLista = FALSE){
        $query	= "SELECT *
                    FROM ".$this->_table."
                    WHERE ".$this->primary_key." = ?";

        $param	= array($id_perfil);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        $rows       = $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        }else {
            return $rows;
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
    
 }
