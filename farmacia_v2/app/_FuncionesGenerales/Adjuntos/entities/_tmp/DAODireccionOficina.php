<?php
/**
 ******************************************************************************
 * Sistema           : MIS FISCALIZACIONES
 *
 * Descripcion       : Modelo para Tabla mfis_direccion_oficina
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 25/07/2019
 *
 * @name             DAODireccionOficina.php
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
namespace App\General\Entity;

class DAODireccionOficina extends \pan\Kore\Entity{

    protected $table            = TABLA_DIRECCION_OFICINA;
    protected $primary_key		= "id_oficina";

    function __construct() {
        parent::__construct();
    }

    public function getLista(){
        $query		= "SELECT *
                       FROM ".$this->table;

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return  $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene Oficinas por Id de Región
	 * @author     : <david.guzman@cosof.cl>      - 10/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 26/07/2019
     * @param   int $id_region
	 */
    public function getByIdRegion($id_region) {
        $query		= "	SELECT DISTINCT o.*
						FROM ".TABLA_DIRECCION_OFICINA." o
                        LEFT JOIN ".TABLA_DIRECCION_OFICINA_COMUNA." oc ON o.id_oficina = oc.id_oficina
                        LEFT JOIN ".TABLA_DIRECCION_COMUNA." c ON oc.id_comuna = c.id_comuna
						WHERE c.id_region = ? AND o.bo_estado = 1 AND bo_mostrar = 1";

		$param		= array($id_region);
        $result	= $this->db->getQuery($query, $param)->runQuery();

        if($result->getNumRows()>0) {
            return  $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene Nombre por Id de oficina
     * @author	   : <sebastian.Carroza@cosof.cl> - 05/08/2019
     * @param   int $id_oficina
     */
     public function getNombreById($id){
         $query	= "	SELECT gl_nombre_oficina
                    FROM ".$this->table."
                   WHERE ".$this->primary_key." = ?";

       $param	= array($id);
         $result	= $this->db->getQuery($query,$param)->runQuery();

         if($result->getNumRows()>0){
             return $result->getRows(0)->gl_nombre_oficina;
         }else{
             return NULL;
         }

     }

 }
