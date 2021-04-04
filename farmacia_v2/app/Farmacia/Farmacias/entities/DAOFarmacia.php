<?php

namespace App\Farmacias\Farmacia\Entities;

class DAOFarmacia extends \pan\Kore\Entity{

	protected $table		=	TABLA_FARMACIA;
	protected $primary_key	=	"farmacia_id";

	function __construct(){
		parent::__construct();
	}

    public function getById($id){
		$query	=
		"	SELECT	*
			FROM	".	$this->table		."
			WHERE	".	$this->primary_key	."	=	?
		";

        $param	=	array($id);
        $result	=	$this->db->getQuery($query,$param)->runQuery();

        if ($result->getNumRows() > 0){
            return	$result->getRows(0);
        }else {
            return	NULL;
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

	public function getListSelect($string){

		$query	=
		"	SELECT	farmacia_id					AS	id,
					farmacia_razon_social		AS	text
			FROM	".	$this->table	." 
			WHERE	(farmacia_razon_social
				LIKE	'%".	\Validar::validador($string,'string')	."%'
			OR		farmacia_rut_midas
				LIKE	'%".	\Validar::validador($string,'string')	."%')
		";

		file_put_contents('php://stderr', PHP_EOL . print_r($query, TRUE). PHP_EOL, FILE_APPEND);

		$result	=	$this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return	$result->getRows();
		}else{
			return	NULL;
		}
	}


    public function getListaOrdenadaBy($ordenBy="farmacia_razon_social"){

        $query	= "SELECT * FROM ".$this->table." ORDER BY ".$ordenBy." ASC";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function getByRegion($id_region){

        $query	= "
                    SELECT *
                    FROM ".$this->table."
                    WHERE id_region_midas = ?
                    ORDER BY farmacia_razon_social ASC";

        $param	= array($id_region);
        $result	= $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

	

	public function getListadoRegularizacion(){
		$query	=
		"	SELECT	farmacia_id,
					farmacia_rut_midas,
					farmacia_razon_social
			FROM	".$this->table."
			WHERE   gl_token    IS NULL
		";

		$result	=	$this->db->getQuery($query)->runQuery();
		
		
		if($result->getNumRows()>0){
			return	$result->getRows();
		}else{
			return	NULL;
		}
	}

	public function getListadoRegularizacionCaracter(){
		$query	=
		"	SELECT		farma.farmacia_id,
						farma.farmacia_caracter
			FROM		".	$this->table	."	farma
			WHERE   	farma.id_caracter   	 IS NULL
		";

		$result	=	$this->db->getQuery($query)->runQuery();
		
		
		if($result->getNumRows()>0){
			return	$result->getRows();
		}else{
			return	NULL;
		}
	}

	public function getByToken($gl_token){
		$query	= 
		"	SELECT	*
			FROM	".$this->table."
			WHERE	gl_token		=	?
		";

		$params	=	array(
			$gl_token
		);
		
		$result	=	$this->db->getQuery($query,$params)->runQuery();

		if($result->getNumRows()>0){
			return $result->getRows(0);
		}else{
			return NULL;
		}
	}
}