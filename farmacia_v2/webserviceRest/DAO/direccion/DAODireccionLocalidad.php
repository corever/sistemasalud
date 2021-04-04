<?php
/**
 ******************************************************************************
 * Sistema           :	FARMACIA V2
 * 
 * Descripcion       : Modelo para Tabla direccion_localidad
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAODireccionLocalidad.php
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
class DAODireccionLocalidad{

	protected $_tabla			=   TABLA_DIRECCION_LOCALIDAD;
	protected $_primaria		=   "localidad_id";
	protected $_transaccional	=   false;
	protected $_conn			=   null;
	protected $_respuesta		=   array();

	function __construct($conn = null) {
		if($conn !== null){
			$this->_conn =  $conn;
		}else{
			$this->_conn =  new MySQL();
		}
	}

	public function getById($id){
		$query	= "	SELECT *, localidad_nombre AS gl_nombre FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param	= array($id);
		$result = $this->_conn->consulta($query,$param);
		
		if($result->num_rows>0){
			return $this->_conn->fetch_assoc($result);
		}else{
			return NULL;
		}
	}

	public function getNombreById($id){
		$query  = " SELECT localidad_nombre FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param  = array((int)$id);
		$result = $this->_conn->consulta($query,$param);

		if($result->num_rows>0){
			$comuna = $this->_conn->fetch_assoc($result);
			return $comuna["gl_nombre_localidad"];
		}else{
			return NULL;
		}
	}

	public function getLista(){
		$query		=
		"	SELECT	localidad_id		AS	id_localidad,
					localidad_nombre	AS	gl_nombre_localidad
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