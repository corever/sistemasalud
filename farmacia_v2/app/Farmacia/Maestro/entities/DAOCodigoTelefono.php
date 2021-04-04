<?php

namespace App\Farmacia\Maestro\Entities;

class DAOCodigoTelefono extends \pan\Kore\Entity{
    protected $table;
    protected $primaria;

    public function __construct() {
        parent::__construct();

        $this->table    = "codfono_region";
        $this->primaria = "codfono_id";
    }

    public function obtenerCodigosTelefonicos(){
        $query  = "SELECT 
                    codigo.*,
                    concat('(', codigo.codigo, ') ',ifnull(region.region_nombre,'NACIONAL'), ' - ', ifnull(codigo.provincia,'')) AS 'codigoText'
                    FROM ".$this->table." AS codigo
                    LEFT JOIN ".TABLA_DIRECCION_REGION." AS region ON codigo.id_region_midas = region.id_region_midas";
      
        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

}

?>
