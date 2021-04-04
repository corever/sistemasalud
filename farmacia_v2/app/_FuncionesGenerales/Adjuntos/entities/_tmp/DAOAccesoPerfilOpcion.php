<?php

namespace App\General\Entity;

class DAOAccesoPerfilOpcion extends \pan\Kore\Entity{

  protected $table = TABLA_ACCESO_PERFIL_OPCION;
  protected $primary_key		= "id_usuario";

  function __construct(){
      parent::__construct();
  }
  /**
 * Descripción : Obtiene Opciones Raiz
 * @author     : <david.guzman@cosof.cl>      - 08/05/2018
 * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
   * @param   int $id_perfil
 */
  public function getOpcionesRaiz($id_perfil){
      $query = "  SELECT
          opcion.id_opcion AS id_opcion,
          opcion.id_opcion_padre,
          opcion.bo_tiene_hijo,
          opcion.gl_nombre_opcion,
          opcion.gl_icono,
          opcion.gl_url
        FROM ".$this->table." perfil_opcion
        LEFT JOIN ".TABLA_ACCESO_OPCION." opcion  ON perfil_opcion.id_opcion = opcion.id_opcion
        WHERE perfil_opcion.id_perfil = ? AND opcion.bo_activo = 1 AND opcion.id_opcion_padre = 0";

      $param	= array($id_perfil);
      $result	= $this->db->getQuery($query,$param)->runQuery();

      if($result->getNumRows()>0){
          return $result->getRows();
      }else{
          return NULL;
      }
  }

  /**
 * Descripción : Obtiene Sub-Opciones
 * @author     : <david.guzman@cosof.cl>      - 08/05/2018
 * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
   * @param   int $id_perfil
 */
  public function getSubOpciones($id_perfil){
      $query	= "	SELECT
          opcion.id_opcion AS id_opcion,
          opcion.id_opcion_padre,
          opcion.bo_tiene_hijo,
          opcion.gl_nombre_opcion,
          opcion.gl_icono,
          opcion.gl_url
        FROM ".$this->table." perfil_opcion
        LEFT JOIN ".TABLA_ACCESO_OPCION." opcion  ON perfil_opcion.id_opcion = opcion.id_opcion
        WHERE perfil_opcion.id_perfil = ? AND opcion.bo_activo = 1 AND opcion.id_opcion_padre != 0"
        ;

      $param	= array($id_perfil);
      $result	= $this->db->getQuery($query,$param)->runQuery();

      if($result->getNumRows()>0){
          return $result->getRows();
      }else{
          return null;
      }
  }
  /**
   * Descripción : Elimina Opciones del respectivo Perfil
   * @author     : <david.guzman@cosof.cl>        - 08/05/2018
   * @author	   : <sebastian.Carroza@cosof.cl> - 23/07/2019
   * @param   int $id_perfil
   */
   public function deleteByIdPerfil($id_perfil){

       $query = "  DELETE FROM ".$this->table."
                   WHERE id_perfil = ?
                ";

       $param	= array($id_perfil);

       $response = $this->db->execQuery($query, $param);

       if ($response) {
           return TRUE;
       }else {
           return NULL;
       }

   }
 }
