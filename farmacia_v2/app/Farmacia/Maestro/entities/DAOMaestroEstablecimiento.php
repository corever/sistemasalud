<?php
namespace App\Farmacia\Maestro\Entities;
class DAOMaestroEstablecimiento extends \pan\Kore\Entity{
    protected $table;
    protected $primaria;

    public function __construct() {
        parent::__construct();

        $this->table    = "local";
        $this->primaria = "local_id";
    }

    public function obtenerTiposEstablecimiento(){
        $query = "SELECT * FROM local_tipo";
        
        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function obtenerEstablecimientosFarmaceuticos($params){
        $queryParam   = array();
        $where = ' WHERE';
        $query  = "SELECT establecimiento.*, farmacia.farmacia_nombre_fantasia 
        FROM ".$this->table. " AS establecimiento
         JOIN farmacia ON establecimiento.fk_farmacia = farmacia.farmacia_id";

        foreach($params as $key => $value){
            if(isset($params[$key]) && $value != ''){
                $query .=$where." establecimiento.".$key." = ?";
                $where = ' AND';
                $queryParam[] = intval($value);
            }
        }

        $result	= $this->db->getQuery($query,$queryParam)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function obtenerEstablecimientoPorId($id){
        $query = "SELECT *
        FROM ".$this->table."
        WHERE ".$this->primaria." = ?;";

        $result	= $this->db->getQuery($query,$id)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows(0);
        }else{
            return NULL;
        }
    }

    public function guardarEstablecimiento($params){
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
        //datos que no se ingresan, pero no pueden ir null
        $query .= "farmacia_telefono,farmacia_estado,farmacia_tipo,farmacia_rut_midas,farmacia_rut_representante_midas,farmacia_nombre_representante_ti,farmacia_telefono_representante_ti,farmacia_fono_codigo_ti,farmacia_fono_ti,farmacia_correo_representante_ti,farmacia_motivo_deshabilitacion)";
        $queryValues .= "'".$codigoPais.$params["farmacia_fono_codigo"].$params["farmacia_fono"]."',1,'','','','','','','','','');";
        $query .= $queryValues;

        $result	= $this->db->execQuery($query,$queryParam);

        return $result;
    }

    public function editarEstablecimiento($params){
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

    //
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
        " SET local_estado = ?
        WHERE ".$this->primaria." = ?;";

        $result	= $this->db->execQuery($query,$queryParam);

        return $result;
    }

    public function obtenerMotivosInhabilitacion(){
        $query = "SELECT * FROM motivo_inhabilitacion WHERE motivo_inhabilitacion_id != 0;";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }
}

?>
