<?php
/**
 ******************************************************************************
 * Sistema           :	FARMACIA V2
 * 
 * Descripcion       : Modelo para Tabla direccion_region
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAODireccionRegion.php
 * 
 * @version          1.0
 *
 * @author           Pablo Jimenez <pablo.jimenez@cosof.cl>
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
class DAODireccionRegion{

	protected $_tabla				=	TABLA_DIRECCION_REGION;
	protected $_primaria			=	"id_region_midas";
	protected $_transaccional		=	false;
	protected $_conn				=	null;
	protected $_respuesta			=	array();

	function __construct($conn = null) {
		if($conn !== null){
			$this->_conn =  $conn;
		}else{
			$this->_conn =  new MySQL();
		}
	}

	public function getById($id){
		$query	= "	SELECT 
						id_region_midas		AS	id, 
						region_nombre		AS	gl_nombre
					FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param  = array($id);
		$result = $this->_conn->consulta($query,$param);

		if($result->num_rows>0){
			return $this->_conn->fetch_assoc($result);
		}else{
			return NULL;
		}
	}

	public function getNombreById($id){
		$query  = " SELECT region_nombre FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param  = array((int)$id);
		$result = $this->_conn->consulta($query,$param);

		if($result->num_rows>0){
			$region = $this->_conn->fetch_assoc($result);
			return $region["region_nombre"];
		}else{
			return NULL;
		}
	}

	public function getLista(){
		$query		=
		"	SELECT	id_region_midas		AS	id_region,
					region_nombre		AS	gl_nombre_region
			FROM ".$this->_tabla;
		
		$result = $this->_conn->consultaArreglo($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

	function cerrar_conexion(){
		$this->_conn->cerrar_conexion();
	}
	
}

?>