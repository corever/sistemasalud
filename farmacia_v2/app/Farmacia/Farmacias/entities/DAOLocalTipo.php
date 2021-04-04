<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOLocalTipo extends \pan\Kore\Entity{

    protected $table       = TABLA_LOCAL_TIPO;
    protected $primary_key = "local_tipo_id";

    function __construct(){
        parent::__construct();
    }

    public function getById($id){

		$query	=
		"	SELECT	*
            FROM	".	$this->table        ."
			WHERE   ".	$this->primary_key	."	=	?
		";

		$param	=	array($id);
		$result	=	$this->db->getQuery($query,$param)->runQuery();

		if ($result->getNumRows() > 0) {
			return	$result->getRows(0);
		}else {
			return	NULL;
		}
	}

    public function getLista($bo_activo=NULL){

        $query	=	"	SELECT	*	FROM	".	$this->table;

        if(is_bool($bo_activo)){
			$query	.=	"	WHERE	bo_activo	=	"	.	$bo_activo;
		}

        $result	=	$this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }
}