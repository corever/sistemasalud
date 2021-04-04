<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOEvento extends \pan\Kore\Entity{

    protected $table       = TABLA_EVENTO;
    protected $primary_key = "id_evento";

    function __construct(){
        parent::__construct();
    }

    public function getById($id_evento, $retornaLista = FALSE){

        $query	= "
        SELECT *
        FROM ".$this->table."
        WHERE ".$this->primary_key." = ?";

        $param	= array($id_evento);
        $result	= $this->db->getQuery($query,$param)->runQuery();
        $rows   = $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        }else {
            return $rows;
        }
    }

    public function getLista($bo_mostrar = 0){

        $query	= "SELECT * FROM ".$this->table;

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
    
    public function insertarEvento($params) {
        
        $id     = false;
        $query  = "
        INSERT INTO ".$this->table."
        (
            id_evento_tipo,
            bo_activo,
            gl_descripcion,
            id_usuario_crea,
            fc_creacion
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            now()
        );";
          
		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }
        
        return $id;
    }

}
