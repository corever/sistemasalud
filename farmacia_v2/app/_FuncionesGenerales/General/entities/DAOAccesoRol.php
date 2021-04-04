<?php
/**
 ******************************************************************************
 * Sistema           : FARMACIA V2
 *
 * Descripcion       : Modelo para Tabla maestro_rol
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 21/09/2020
 *
 * @name             DAOAccesoRol.php
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

class DAOAccesoRol extends \pan\Kore\Entity{

	protected	$table			=	TABLA_ACCESO_ROL;
	protected	$primary_key	=	"rol_id";

	const	ROL_ADMINISTRADOR							=	1;
	const	ROL_ENCARGADO_REGIONAL						=	2;
	const	ROL_ENCARGADO_TERRITORIAL					=	3;
	const	ROL_DIRECTOR_TECNICO						=	4;
	const	ROL_VENDEDOR_TALONARIO						=	5;
	const	ROL_QUIMICO_RECEPCIONANTE					=	6;
	const	ROL_QUIMICO_TRABAJADOR						=	7;
	const	ROL_ADMINISTRATIVO							=	8;
	const	ROL_ADMINISTRADOR_DE_MAESTROS				=	9;
	const	ROL_MEDICO									=	10;
	const	ROL_NACIONAL								=	11;
	const	ROL_SECRETARIA_REGIONAL						=	12;
	const	ROL_SECRETARIA_TERRITORIAL					=	13;
	const	ROL_COORDINADOR_FARMACIA_NACIONAL			=	14;
	const	ROL_COORDINADOR_FARMACIA_REGIONAL			=	15;
	const	ROL_FIRMANTE								=	16;
	const	ROL_FIRMANTE_FIRMANTES						=	17;
	const	ROL_DT_PILOTO								=	18;
	const	ROL_DEIS									=	19;
	const	ROL_FIRMANTE_DELEGADO						=	20;




    function __construct(){
      parent::__construct();
    }


    public function getById($id_rol, $retornaLista = FALSE){
      $query	= "SELECT *
                 FROM ".$this->table."
                 WHERE ".$this->primary_key." = ?";

      $param	= array($id_rol);
      $result	= $this->db->getQuery($query,$param)->runQuery();

      $rows       = $result->getRows();

      if (!empty($rows) && !$retornaLista) {
          return $rows[0];
      }else {
          return $rows;
      }
    }

    public function getLista($bo_mostrar=0){

        $query	= "	SELECT * FROM ".$this->table;
        if($bo_mostrar==1){
            //$query .= " WHERE bo_mostrar = 1 AND bo_estado = 1";
        }
        $query .= " ORDER BY nr_orden ASC";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function getListaBuscar($params){

        $query	= "	SELECT * FROM ".$this->table;
        
        if(!empty($params)){
            if(isset($params['gl_nombre']) && $params['gl_nombre'] != ""){
                $query .= " WHERE rol_nombre_vista LIKE '%".$params['gl_nombre']."%'";
            }
        }

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }
    
    public function getByIN($in_rol){
        $query	= "SELECT *
                   FROM ".$this->table."
                   WHERE ".$this->primary_key." IN ($in_rol)";
        
        $query  .= " ORDER BY nr_orden ASC";
        $result	= $this->db->getQuery($query)->runQuery();
        $rows   = $result->getRows();

        if (!empty($rows)) {
            return $rows;
        }
    }

    /**
     * Descripción : Obtiene por Token
     * @author     : <david.guzman@cosof.cl>      - 11/05/2018
     * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
     */
     public function getByToken($gl_token){
         $query 	= "SELECT *
                       FROM ".$this->table."
 					   WHERE gl_token = ?";
         $param     = array($gl_token);
         $result	= $this->db->getQuery($query, $param)->runQuery();

         if($result->getNumRows()>0){
             return $result->getRows(0);
         }else{
             return NULL;
         }
     }

     public function getNombreById($id){
         $query="SELECT gl_nombre_rol
                 FROM ".$this->table."
                 WHERE id_rol = ?";
         $param=array($id);
         $result	= $this->db->getQuery($query, $param)->runQuery();

         if($result->getNumRows()>0){
             return $result->getRows(0)->gl_nombre_rol;
         }else{
             return NULL;
         }

     }
     
     public function getLastId(){
        $query	= "SELECT MAX(rol_id)+1 AS id
                   FROM ".$this->table;
        $result	= $this->db->getQuery($query)->runQuery();
        $row   = $result->getRows(0);
        return $row->id;
    }
     
     /**
    * Descripción   : Insertar nuevo rol.
    * @author       : <david.guzman@cosof.cl>
    * @param        : array
    * @return       : $params
    */
    public function insertarNuevo($params) {

        $id     = $this->getLastId();
        $query  = "INSERT INTO ".$this->table."
								(
                                    rol_id,
                                    rol_nombre,
                                    rol_nombre_vista,
                                    gl_token,
                                    bo_nacional,
                                    bo_regional,
                                    id_usuario_crea,
                                    fc_crea
								)
								VALUES
								(
									$id,?,?,?,?,?,?,now()
								)";

		if($this->db->execQuery($query,$params)){
            return $id;
        }else{
            return false;
        }
    }
    
    /**
	* Descripción : Editar rol
	* @author  David Guzmán <david.guzman@cosof.cl> - 20/05/2020
	* @param   array   $gl_token, $params
	*/
	public function modificar($id_rol,$params){
		$query	= "	UPDATE ".$this->table."
					SET
                        gl_nombre_rol        = ?,
                        gl_descripcion          = ?,
                        id_usuario_actualiza    = ?,
                        fc_actualiza            = now()
					WHERE id_rol = $id_rol";
        
		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}
    
    /**
	* Descripción : Editar bo_activo
	* @author  David Guzmán <david.guzman@cosof.cl> - 22/09/2020
	* @param   array   $gl_token, $bo_activo
	*/
	public function setActivo($gl_token,$bo_activo){
		$query	= "	UPDATE ".$this->table."
					SET
                        bo_activo               = ?,
                        id_usuario_actualiza    = ?,
                        fc_actualiza            = now()
					WHERE gl_token = ?";
        
		$resp	= $this->db->execQuery($query, array($bo_activo,$_SESSION[\Constantes::SESSION_BASE]['id'],$gl_token));

		return $resp;
	}
    
 }
