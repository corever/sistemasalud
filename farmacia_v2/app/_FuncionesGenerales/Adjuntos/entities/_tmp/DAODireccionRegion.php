<?php
/**
 ******************************************************************************
 * Sistema           : NOTIFICACION ACCIDENTES SINAISO
 *
 * Descripcion       : Modelo para Tabla mfis_direccion_region
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 24/05/2018
 *
 * @name             DAODireccionRegion.php
 *
 * @version          1.0
 *
 * @author           Sebastian Carroza <sebastian.Carroza@cosof.cl>
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

class DAODireccionRegion extends \pan\Kore\Entity{

    protected $table            = TABLA_DIRECCION_REGION;
    protected $primary_key      = "id_region";

    function __construct() {
        parent::__construct();
    }

    public function getLista($id=NULL){

        $session_id = SESSION_BASE;

        if(isset($_SESSION[$session_id]['query']['DAODireccionRegion']['getLista'][intval($id)])){
			return $_SESSION[$session_id]['query']['DAODireccionRegion']['getLista'][intval($id)];
		}

        $param      = null;
        $query		= "	SELECT      id_region,
                                    gl_codigo_region,
                                    gl_nombre_region,
                                    gl_nombre_corto,
                                    gl_geozone,
                                    gl_latitud,
                                    gl_longitud,
                                    nr_orden_territorial,
                                    id_usuario_crea,
                                    fc_crea
                        FROM    ".$this->table;
        $result	    = $this->db->getQuery($query)->runQuery();
        if($id != null && $id != 0){
            $param	= array($id);
            $query .= " WHERE ".$this->primary_key." = ?";
        }
        $query .=" ORDER BY nr_orden_territorial";

        if($result->getNumRows()>0){
			$_SESSION[$session_id]['query']['DAODireccionRegion']['getLista'][intval($id)] = $result->getRows();
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene Nombre por Id de Región
     * @author	   : <sebastian.Carroza@cosof.cl> - 05/08/2019
     * @param   int $id_region
     */

     public function getNombreById($id){
         $query	= "	SELECT gl_nombre_region
                    FROM ".$this->table."
 					WHERE ".$this->primary_key." = ?";

 		$param	= array($id);
         $result	= $this->db->getQuery($query,$param)->runQuery();

         if($result->getNumRows()>0){
             return $result->getRows(0)->gl_nombre_region;
         }else{
             return NULL;
         }
     }

 }
