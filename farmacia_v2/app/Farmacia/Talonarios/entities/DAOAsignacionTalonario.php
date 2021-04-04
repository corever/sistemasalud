<?php

namespace App\Farmacia\Talonarios\Entity;

class DAOAsignacionTalonario extends \pan\Kore\Entity
{

    protected $table       = TABLA_ASIGNACION_TALONARIO;
    protected $primary_key = "asignacion_id";

    function __construct()
    {
        parent::__construct();
    }

	public function getById($id_asignacion){
		$query	= "	SELECT
						*
					FROM ".$this->table."WHERE ".$this->primary_key." = ?";

		$result	= $this->db->getQuery($query,array($id_asignacion))->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
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

	/*
	* Descripción : Obtener listado de Talonarios disponibles
	* @author  David Guzmán <david.guzman@cosof.cl> - 27/08/2020
	* @return  object  Listado de talonarios
	*/
	public function getListaDisponibles($id_bodega=0){
		$query	= "	SELECT
						*,
						CONCAT(talonario.talonario_serie,'-',talonario.talonario_folio_inicial,' al ',talonario.talonario_folio_final) AS gl_talonario
					FROM ".$this->table." asignacion_talonario
					LEFT JOIN ".TABLA_TALONARIO." talonario ON asignacion_talonario.fk_talonario = talonario.talonario_id
					WHERE asignacion_talonario.local_ven = ? AND asignacion_talonario.Venta = 0
					AND talonario.talonario_serie != '' AND talonario.talonario_serie IS NOT NULL
					ORDER BY talonario_folio_inicial ASC";
		$result	= $this->db->getQuery($query,array($id_bodega))->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

	public function getByIdIN($id_asignacion){
		$query	= "	SELECT
						*,
						CONCAT(talonario.talonario_serie,'-',talonario.talonario_folio_inicial,' al ',talonario.talonario_folio_inicial) AS gl_talonario,
						bodega.bodega_nombre AS gl_bodega
					FROM ".$this->table."
					LEFT JOIN ".TABLA_TALONARIO." talonario ON asignacion_talonario.fk_talonario = talonario.talonario_id
					LEFT JOIN ".TABLA_BODEGA." bodega ON asignacion_talonario.local_ven = bodega.bodega_id
					WHERE ".$this->primary_key." IN (".$id_asignacion.")";

		$result	= $this->db->getQuery($query)->runQuery();
		
		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

	/**
	 * Descripción : Editar Venta de Asignacion Talonario
	 * @author  David Guzmán <david.guzman@cosof.cl> - 02/09/2020
	 * @param   int   $id_asignacion, $bo_venta
	 */
	public function setVenta($id_asignacion, $bo_venta)
	{
		$query	= "	UPDATE " . $this->table . "
					SET
						Venta	= ?
					WHERE asignacion_id = ?";

		$resp	= $this->db->execQuery($query, array($bo_venta,$id_asignacion));

		return $resp;
	}

}
