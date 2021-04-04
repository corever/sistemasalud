<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOBodega extends \pan\Kore\Entity{

    protected $table       = TABLA_BODEGA;
    protected $primary_key = "bodega_id";

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

    public function getByTerritorio($id_territorio){

        $query	= " SELECT *
                    FROM ".$this->table."
                    WHERE fk_territorio = ".intval($id_territorio)."
                    AND fk_bodega_tipo = 3";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function getByRegion($id_region){

        $query	= " SELECT *
                    FROM ".$this->table."
                    WHERE id_region_midas = ".intval($id_region)."
                    AND fk_bodega_tipo = 3";

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

}
