<?php
/**
 ******************************************************************************
 * Sistema           : WSBase
 * 
 * Descripcion       : Modelo para obtener Credenciales de Acceso al WS
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 01/08/2018
 * 
 * @name             DAOAcceso.php
 * 
 * @version          1.0
 *
 * @author           Victor Retamal <victor.retamal@cosof.cl>
 * 
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				!cFecha		!cDescripcion 
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
class DAOAcceso{

    protected $_tabla			= "ws_acceso_sistemas";
    protected $_primaria		= "id_sistema";
    protected $_transaccional	= false;
    protected $_conn            = null;
    protected $_respuesta       = array();

    function __construct($conn = null) {
		/*
        if($conn !== null){
            $this->_conn =  $conn;
        }else{
            $this->_conn =  new MySQL();
        }
		*/
		$this->_conn =  new MySQL();
    }

    public function getLista(){
        $query	= "	SELECT * FROM ".$this->_tabla;
        $result = $this->_conn->consultaArreglo($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    public function getById($id){
        $query	= "	SELECT * FROM ".$this->_tabla." WHERE ".$this->_primaria."=".$id;
        $result = $this->_conn->consultaArreglo($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    public function getPassNegociar($gl_base, $gl_ambiente, $bo_estado=1){
        $gl_base	= validar($gl_base,'string');
        $gl_ambiente= validar($gl_ambiente,'string');

    	if(!empty($gl_base)){
	    	$query	= "	SELECT gl_pass
							FROM ".$this->_tabla."
							WHERE bo_estado=$bo_estado
								AND gl_base = '$gl_base'
								AND gl_ambiente = '$gl_ambiente'
							LIMIT 1";
	        $result = $this->_conn->consulta($query);
			
	        if($result->num_rows>0){
				$acceso = $this->_conn->fetch_assoc($result);
	            return $acceso["gl_pass"];
	        }else{
	            return NULL;
	        }
    	}else{
    		return NULL;
    	}
	}
	
	public function getCredencialByPublickey($key_public, $gl_ambiente, $bo_estado=1){
		$arr		= array();
        $key_public	= validar($key_public,'string');
        $gl_ambiente= validar($gl_ambiente,'string');

		if(!empty($key_public)){
			$query	= "	SELECT 
							*
						FROM ".$this->_tabla."
						WHERE bo_estado=$bo_estado
							AND gl_key_public = '$key_public'
							AND gl_ambiente = '$gl_ambiente'
						LIMIT 1";

			$conn	= new MySQL;
			$result	= $conn->consulta($query);
			while($row	= $conn->fetch_assoc($result)){
				$arr	= $row;
			}
			$conn->dispose($result);
			$conn->cerrar_conexion();
		}

		return $arr;
	}

	public function getCredencialByBase($gl_base, $bo_estado=1){
		$arr			= array();
        $gl_base	= validar($gl_base,'string');

		if(!empty($gl_base)){
			$query	= "	SELECT	*
						FROM 	".$this->_tabla."
						WHERE 	bo_estado		=	$bo_estado
						AND 	gl_base 	= 	'$gl_base'
						LIMIT 1";

			$conn		= new MySQL;
			$result		= $conn->consulta($query);

			while($row	= $conn->fetch_assoc($result)){
				$arr	= $row;
			}
			$conn->dispose($result);
			$conn->cerrar_conexion();
		}

		return $arr;
	}
    
    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }
}