<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOMedicoAdjunto extends \pan\Kore\Entity{

    protected $table       = TABLA_MEDICO_ADJUNTO;
    protected $primary_key = "bodega_id"; // bodega_id?

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

    /**
    * Descripción   : Insertar adjunto.
    * @author       : <david.guzman@cosof.cl> - 30/08/2020
    * @param        : array
    * @return       : int
    */
    public function insertar($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->table."
								(
                                    id_medico,
                                    gl_url,
                                    fc_crea,
                                    id_usuario_crea
								)
								VALUES
								(
									?,?,now(),".intval($_SESSION[\Constantes::SESSION_BASE]['id'])."
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }
        
        return $id;
    }

}
