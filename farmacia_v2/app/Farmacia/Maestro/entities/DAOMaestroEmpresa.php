<?php
namespace App\Farmacia\Maestro\Entities;
class DAOMaestroEmpresa extends \pan\Kore\Entity{
    protected $table;
    protected $primaria;

    public function __construct() {
        parent::__construct();

        $this->table    = "farmacia";
        $this->primaria = "farmacia_id";
    }

    public function obtenerEmpresasFarmaceuticas($params){
        $queryParam   = array();
        $query  = "SELECT farmacia.*, region.region_nombre FROM ".$this->table.
        " LEFT JOIN region ON farmacia.id_region_midas = region.id_region_midas";
        if(isset($params['farmacia_estado']) && $params['farmacia_estado'] != ''){
            $query .=" WHERE farmacia.farmacia_estado = ?";
            $queryParam[] = intval($params['farmacia_estado']);
        }
        $result	= $this->db->getQuery($query,$queryParam)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function obtenerEmpresaPorId($id){
        $query = "SELECT *
        FROM farmacia
        WHERE farmacia_id = ?;";

        $result	= $this->db->getQuery($query,$id)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows(0);
        }else{
            return NULL;
        }
    }

	public function guardarEmpresa($params){
		$queryParam   = array();
		$codigoPais = '+56';
		$query = "INSERT INTO ".$this->table."(";
		$queryValues = "VALUES (";
		foreach($params as $key => $value){
			if($key != 'farmacia_id'){
				$query .= $key.",";
				$queryValues .= "?,";
				$queryParam[] = $value;
			}
		}
		//telefono, estado + datos que no se ingresan, pero no pueden ir null
		$query .= "farmacia_telefono,farmacia_estado,farmacia_tipo,farmacia_rut,farmacia_rut_representante,farmacia_nombre_representante_ti,farmacia_telefono_representante_ti,farmacia_fono_codigo_ti,farmacia_fono_ti,farmacia_correo_representante_ti,farmacia_motivo_deshabilitacion)";
		$queryValues .= "'".$codigoPais.$params["farmacia_fono_codigo"].$params["farmacia_fono"]."',1,'','','','','','','','','');";
		$query .= $queryValues;

		$result	= $this->db->execQuery($query,$queryParam);

		return $result;
	}

    public function editarEmpresa($params){
        $queryParam   = array();
        $codigoPais = '+56';
        $query = "UPDATE ".$this->table." SET ";
        foreach($params as $key => $value){
            if($key != 'farmacia_id'){
                $query .= $key." = ?,";
                $queryParam[] = $value;
            }
        }
        $query .= " farmacia_telefono = ? WHERE ".$this->primaria." = ?;";
        $queryParam[] = $codigoPais.$params["farmacia_fono_codigo"].$params["farmacia_fono"];
        $queryParam[] = $params['farmacia_id'];
        $result	= $this->db->execQuery($query,$queryParam);

        return $result;
    }

    public function revisarEstablecimientos($id){

        $query = "SELECT * FROM local WHERE local_estado = 1 AND fk_farmacia = ?";
        $result	= $this->db->getQuery($query,$id)->runQuery();

        if($result->getNumRows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function cambiarEstado($params){
        $queryParam   = array($params['estado'], $params['id']);
        $query  = "UPDATE " .$this->table.
        " SET farmacia_estado = ?
        WHERE ".$this->primaria." = ?;";

        $result	= $this->db->execQuery($query,$queryParam);

        return $result;
    }
}

?>
