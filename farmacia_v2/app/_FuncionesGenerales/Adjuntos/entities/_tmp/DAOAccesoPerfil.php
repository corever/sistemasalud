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
 * @name             DAOAccesoPerfil.php
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

class DAOAccesoPerfil extends \pan\Kore\Entity{

    protected $table = TABLA_ACCESO_PERFIL;
    protected $primary_key		= "id_perfil";


    const FISCALIZADOR = 2;
    const ADMINISTRADOR = 1;
    const ENCARGADO_REGIONAL = 4;
    const ENCARGADO_NACIONAL = 5;
    const ENCARGADO_OFICINA = 3;
    const SUPERVISOR_EAT = 6;
    

    function __construct(){
      parent::__construct();
    }


    public function getById($id_perfil, $retornaLista = FALSE){
      $query	= "SELECT *
                 FROM ".$this->table."
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

    public function getLista($bo_mostrar=0){

        $query	= "	SELECT * FROM ".$this->table;
        if($bo_mostrar==1){
            $query .= " WHERE bo_mostrar = 1 AND bo_estado = 1";
        }

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
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
         $query="SELECT gl_nombre_perfil
                 FROM ".$this->table."
                 WHERE id_perfil = ?";
         $param=array($id);
         $result	= $this->db->getQuery($query, $param)->runQuery();

         if($result->getNumRows()>0){
             return $result->getRows(0)->gl_nombre_perfil;
         }else{
             return NULL;
         }

     }
 }
