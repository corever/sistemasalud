<?php
/**
 ******************************************************************************
 * Sistema           : MIS FISCALIZACIONES
 *
 * Descripcion       : Modelo para Tabla mfis_acceso_perfil
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 25/07/2019
 *
 * @name             DAODireccionComuna.php
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


class DAODireccionComuna extends \pan\Kore\Entity{

    protected $table            = TABLA_DIRECCION_COMUNA;
    protected $primary_key		= "id_comuna";

    function __construct() {
        parent::__construct();
    }

    /**
     * Descripción : Obtiene Comunas por Id de Región
     * @author     :<david.guzman@cosof.cl>       - 08/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 25/07/2019
     * @param   int $id_region
     */
    public function getByIdRegion($id_region) {

        $session_id = SESSION_BASE;

        if(isset($_SESSION[$session_id]['query']['DAODireccionComuna']['getByIdRegion'][$id_region])){
            return $_SESSION[$session_id]['query']['DAODireccionComuna']['getByIdRegion'][$id_region];
        }

        $query	= "	SELECT *
                    FROM ".$this->table."
                    WHERE id_region = ?";

        $param	= array($id_region);
        $result	= $this->db->getQuery($query, $param)->runQuery();

        if($result->getNumRows()>0) {
            $_SESSION[$session_id]['query']['DAODireccionComuna']['getByIdRegion'][$id_region] =  $result->getRows();
            return  $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene Comunas por Id de oficina
	 * @author     :<david.guzman@cosof.cl>       -  04/06/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 25/07/2019
     * @param   int $id_oficina
	 */
    public function getByIdOficina($id_oficina) {
        $query	= "	SELECT
						comuna.*
					FROM ".$this->table." comuna
					LEFT JOIN ".TABLA_DIRECCION_OFICINA_COMUNA." oficina_comuna ON comuna.id_comuna = oficina_comuna.id_comuna
					WHERE oficina_comuna.id_oficina = ?";

		$param	= array(intval($id_oficina));
        $result	= $this->db->getQuery($query, $param)->runQuery();

        if($result->getNumRows()>0) {
            return  $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene Nombre por Id de Comuna
     * @author	   : <sebastian.Carroza@cosof.cl> - 05/08/2019
     * @param   int $id_comuna
     */
     public function getNombreById($id){
         $query	= "	SELECT gl_nombre_comuna
                    FROM ".$this->table."
                   WHERE ".$this->primary_key." = ?";

       $param	= array($id);
         $result	= $this->db->getQuery($query,$param)->runQuery();

         if($result->getNumRows()>0){
             return $result->getRows(0)->gl_nombre_comuna;
         }else{
             return NULL;
         }
     }

    /**
     * Obtener info de comuna
     *
     * @param integer $id_comuna
     * @return boolean
     */
    public function getComuna ($id_comuna) {
        if (is_null($id_comuna)) {
            return null;
        }

        $query = 'select com.id_comuna, com.gl_nombre_comuna, reg.gl_nombre_region from ' . $this->table . ' com
        left join mfis_direccion_region reg on reg.id_region = com.id_region 
        where com.' .$this->primary_key. ' = ? limit 1';

        $result = $this->db->getQuery($query, $id_comuna)->runQuery();
        if ($result->getNumRows() > 0) {
            return $result->getRows(0);
        } else {
            return null;
        }

    }

	public function getByNombre($gl_nombre){
		$query	=
		"	SELECT	id_comuna
			FROM	".$this->table."
			WHERE	gl_nombre_comuna		LIKE	'%"	.	$gl_nombre	."%'";

		$result	=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return	$result->getRows(0)->id_comuna;
		}else{
			return	NULL;
		}
	}

 }
