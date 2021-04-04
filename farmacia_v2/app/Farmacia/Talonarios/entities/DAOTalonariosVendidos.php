<?php

namespace App\Farmacia\Talonarios\Entity;

class DAOTalonariosVendidos extends \pan\Kore\Entity
{

    protected $table       = TABLA_TALONARIO_VENDIDOS;
    protected $primary_key = "tc_id";

    function __construct()
    {
        parent::__construct();
    }

    public function getById($id_evento, $retornaLista = FALSE){

        $query	= "
        SELECT *
        FROM ".$this->table."
        WHERE ".$this->primary_key." = ?";

        $result	= $this->db->getQuery($query,array($id_evento))->runQuery();
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

    public function getByTalonario($id_talonario){

        $query	= " SELECT *
                    FROM ".$this->table."
                    WHERE fk_talonario = ?";

        $result	= $this->db->getQuery($query,array($id_talonario))->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows(0);
        }else{
            return NULL;
        }
    }

	/**
	 * Descripción   : Insertar Talonario Vendido
	 * @author       : David Guzmán <david.guzman@cosof.cl>
	 * @param        : $idTalonario, $idVenta
	 * @return       : int
	 */
	public function insertar($idTalonario,$idVenta)
	{

		$id     = false;
		$query  = "INSERT INTO " . $this->table . "
							(
								fk_talonario,
								fk_venta
							)
							VALUES
							(
								?,?
							)";

		if ($this->db->execQuery($query, array($idTalonario,$idVenta))) {
			$id = $this->db->getLastId();
		}

		return $id;
	}
}
