<?php
/**
 ******************************************************************************
 * Sistema           : Mis Fiscalizaciones
 *
 * Descripcion       : Modelo para Tabla mfis_acceso_opcion
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 17/07/2019
 *
 * @name             DAOAccesoOpcion.php
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

class DAOAccesoOpcion extends \pan\Kore\Entity{

    protected $table            = TABLA_ACCESO_OPCION;
    protected $primary_key      = "id_opcion";


    function __construct(){
        parent::__construct();
    }


    /**
 	* Descripción	: Obtiene Lista Opciones con Detalle
 	* @author		: <victor.retamal@cosof.cl>    - 17/10/2018
    * @author		: <luis.estay@cosof.cl>        - 17/07/2019
    * @author		: <sebastian.Carroza@cosof.cl> - 18/07/2019
 	* @return      	array
 	*/
	public function getListaDetalle(){
        $query	= "	SELECT
						opcion.*,
						IF(opcion.id_opcion_padre=0,'',
							(SELECT ao.gl_nombre_opcion FROM ".$this->table." ao WHERE ao.id_opcion = opcion.id_opcion_padre)
						) AS gl_nombre_padre
					FROM ".$this->table." opcion";

        $result     = $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Insertar Menu Padre
	 * @author     : <david.guzman@cosof.cl>      - 08/05/2018
     * @author     : <sebastian.Carroza@cosof.cl> - 18/07/2019
     * @param   array  $parametros
	 */
    public function insertMenuPadre($parametros){

        $id = \pan\utils\SessionPan::getSession('id');

        $param = array($parametros['gl_nombre'],$parametros['gl_icono'],$parametros['gl_url']);
        $query	= "	INSERT INTO ".$this->table." (
						id_opcion,
						id_opcion_padre,
						bo_tiene_hijo,
						gl_nombre_opcion,
						gl_icono,
						gl_url,
						id_usuario_crea,
						fc_crea
                    ) VALUES (
						(SELECT opcion.id_opcion+1 FROM mfis_acceso_opcion opcion WHERE opcion.id_opcion < 8000 ORDER BY opcion.id_opcion DESC LIMIT 1),
						0,
						1,
						?,
						?,
						?,
						".intval($id).",
						now()
					)";
        $response = $this->db->execQuery($query, $param);
        if ($response) {
            return $this->db->getLastId();
        }else {
            return NULL;
        }

    }

    /**
     * Descripción : Obtiene Lista Opciones con Detalle
     * @author     : Guzmán <david.guzman@cosof.cl> - 08/05/2018
     * @author     : <sebastian.Carroza@cosof.cl>   - 18/07/2019
     * @param   int $bo_activo
     */
    public function getAllMenuPadre($bo_activo=0){
        $query = "  SELECT 	*
                    FROM ".$this->table."
                    WHERE id_opcion_padre = 0
                    ";
        if($bo_activo==1){
            $query .= " AND bo_activo = 1";
        }
        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Insertar Menu Opción
     * @author     : <david.guzman@cosof.cl>      - 08/05/2018
     * @author     : <sebastian.Carroza@cosof.cl> - 18/07/2019
     * @param   array  $parametros
     *Array(
     *       [id_padre] => var
     *       [gl_nombre_opcion] => var
     *       [gl_url] => var
     *       [gl_icono] => var
     *     )
     */
    public function insertMenuOpcion($parametros){

        $id = \pan\utils\SessionPan::getSession('id');

        $param = array($parametros['id_padre'],$parametros['gl_nombre_opcion'],$parametros['gl_icono'],$parametros['gl_url']);

        $query	= "	INSERT INTO ".$this->table." (
						id_opcion,
						id_opcion_padre,
						bo_tiene_hijo,
						gl_nombre_opcion,
						gl_icono,
						gl_url,
						id_usuario_crea,
						fc_crea
                    ) VALUES (
						(SELECT opcion.id_opcion+1 FROM mfis_acceso_opcion opcion WHERE opcion.id_opcion < 8000 ORDER BY opcion.id_opcion DESC LIMIT 1),
						?,
						0,
						?,
						?,
						?,
						".intval($id).",
						now()
					)";
        $response = $this->db->execQuery($query, $param);
        if ($response) {
            return $this->db->getLastId();
        }else {
            return NULL;
        }
    }

    /**
     * Descripción : UPDATE Opción Padre
     * @author     : <david.guzman@cosof.cl>      - 08/05/2018
     * @author     : <sebastian.Carroza@cosof.cl> - 18/07/2019
     * @param   id   $id_padre
     */
    public function updatePadreById($id_padre){

        $id = \pan\utils\SessionPan::getSession('id');

        $param = array($id_padre);

        $query	= "	UPDATE ".$this->table."
					SET
						bo_tiene_hijo			= 1,
						id_usuario_actualiza	= ".intval($id).",
						fc_actualiza			= now()
					WHERE
						id_opcion		= ?
                    ";
        $response = $this->db->execQuery($query, $param);

        return $response;
    }

    public function getById($id_opcion){
        $query	= "	SELECT * FROM ".$this->table."
					WHERE ".$this->primary_key." = ?";

		$param	= array($id_opcion);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return NULL;
        }
    }
    /**
	 * Descripción : UPDATE editar Opción
	 * @author     : <david.guzman@cosof.cl>      - 08/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 19/07/2019
     * @param   array   $parametros
	 */
    public function editarOpcion($parametros){

        $id = \pan\utils\SessionPan::getSession('id');

        $param = array($parametros['id_padre'],
                           $parametros['gl_nombre_opcion'],
                           $parametros['gl_icono'],
                           $parametros['gl_url'],
                           $parametros['bo_activo'],
                           $parametros['id_opcion']);

        $query	= "	UPDATE ".$this->table."
					SET
						id_opcion_padre			= ?,
						gl_nombre_opcion		= ?,
						gl_icono				= ?,
						gl_url					= ?,
						bo_activo				= ?,
						id_usuario_actualiza	= ".intval($id).",
						fc_actualiza			= now()
					WHERE
						id_opcion				= ?
                    ";
        $response = $this->db->execQuery($query,$param);

        return $response;
    }

    /**
	 * Descripción : Obtiene Opción Hijo
	 * @author     : <david.guzman@cosof.cl>      - 08/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 19/07/2019
     * @param   int $bo_activo
	 */
    public function getAllMenuHijo($bo_activo=0) {
        $query = "  SELECT 	*
                    FROM ".$this->table."
                    WHERE id_opcion_padre != 0
                    ";
        if($bo_activo==1){
            $query .= " AND bo_activo = 1";
        }
        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }

    }

    /**
     * Descripción : Obtiene Opción Padre Marcando Perfil
     * @author     : <david.guzman@cosof.cl>      - 08/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
     * @param $id_perfil
     */
     public function getAllOpcionPadreByIdPerfil($id_perfil){
        $query = "SELECT 	opcion.*,
 							(   SELECT IFNULL(perfil_opcion.id_perfil,0)
                                FROM mfis_acceso_perfil_opcion perfil_opcion
                                WHERE perfil_opcion.id_perfil = ?
                                  AND perfil_opcion.id_opcion = opcion.id_opcion  ) AS bo_perfil_activo
 					FROM ".$this->table." opcion
 					WHERE opcion.bo_activo = 1 AND opcion.id_opcion_padre = 0";

        $param	= array($id_perfil);

        $result = $this->db->getQuery($query, $param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
     }
     /**
 	 * Descripción : Obtiene Opción Hijo Marcando Perfil
     * @author     : <david.guzman@cosof.cl>      - 08/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
 	 * @param $id_perfil
 	 */
     public function getAllOpcionHijoByIdPerfil($id_perfil){
        $query = "  SELECT 	opcion.*,
 							(   SELECT IFNULL(perfil_opcion.id_perfil,0)
                                FROM mfis_acceso_perfil_opcion perfil_opcion
                                WHERE perfil_opcion.id_perfil = ?
                                AND perfil_opcion.id_opcion = opcion.id_opcion  ) AS bo_perfil_activo
 					FROM ".$this->table." opcion
 					WHERE opcion.bo_activo = 1 AND opcion.id_opcion_padre != 0";

        $param	= array($id_perfil);

        $result = $this->db->getQuery($query, $param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
     }


}
