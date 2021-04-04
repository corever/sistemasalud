<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOProfesion extends \pan\Kore\Entity{

    protected $table       = TABLA_PROFESION;
    protected $primary_key = "id_profesion";

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

    public function getLista(){

        $query	= "SELECT * FROM ".$this->table;

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function getListaOrdenada(){

        $query	= "SELECT * FROM ".$this->table." ORDER BY nombre_profesion ASC";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function getListaOrdenadaMedic($id){

        $query	= "SELECT * FROM ".$this->table."
                    WHERE ".$this->primary_key." = ?";

        $param	= array(intval($id));

        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function insertar($params) {

        $id     = false;
        $query  = "
        INSERT INTO ".TABLA_PROFESION_USUARIO."
        (
            fk_usuario,
            fk_profesion,
            profesion_fecha_creacion
        )
        VALUES
        (
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
