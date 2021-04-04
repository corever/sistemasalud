<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOEventoTipo extends \pan\Kore\Entity{

    protected $table       = TABLA_EVENTO_TIPO;
    protected $primary_key = "id_evento_tipo";

    function __construct(){
        parent::__construct();
    }

    public function getById($id_perfil, $retornaLista = FALSE){

        $query  = "
        SELECT *
        FROM ".$this->table."
        WHERE ".$this->primary_key." = ?";

        $param  = array($id_perfil);
        $result = $this->db->getQuery($query,$param)->runQuery();
        $rows   = $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        }else {
            return $rows;
        }
    }

    public function getLista($bo_mostrar=0){

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


    public function getEventoTipoById($id_evento_tipo){

		$query	= " 
        SELECT *
        FROM  ".$this->table."
        WHERE id_evento_tipo = ?";

		$result	= $this->db->getQuery($query,array($id_evento_tipo))->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}

 }
