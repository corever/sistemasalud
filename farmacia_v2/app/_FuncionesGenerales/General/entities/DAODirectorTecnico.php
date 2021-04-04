<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAODirectorTecnico extends \pan\Kore\Entity{

    protected $table       = TABLA_DIRECTOR_TECNICO;
    protected $primary_key = "DT_id";

    function __construct(){
        parent::__construct();
    }

    public function getById($id_evento, $retornaLista = FALSE){

        $query	= " SELECT *
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

    public function getByLocalUsuario($id_local, $id_usuario,$bo_estado){

        $query	= " SELECT *
                    FROM ".$this->table."
                    WHERE fk_local = ? AND fk_usuario = ? AND estado = ?";

        $param	= array($id_local,$id_usuario,$bo_estado);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else {
            return array();
        }
    }

	public function setDTFechaTerminoyEstado($id_dt, $fc_termino, $bo_estado){
		$query	= "	UPDATE ".$this->table."
                    SET direccion_fecha_termino  = ?,
                        estado = ?
					WHERE ".$this->primary_key." = ? ";
		$param	= array($fc_termino,$bo_estado,$id_dt);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}

    /**
    * Descripción   : Insertar nuevo DT.
    * @author       : <david.guzman@cosof.cl> - 20/08/2020
    * @param        : array
    * @return       : int
    */
    public function insertar($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->table."
								(
                                    fk_local,
                                    fk_usuario,
                                    direccion_fecha_inicio,
                                    direccion_fecha_termino,
									estado,
									fk_bodega,
									dt_fecha_creacion
								)
								VALUES
								(
									?,?,?,?,?,?,now()
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }
        
        return $id;
    }

}
