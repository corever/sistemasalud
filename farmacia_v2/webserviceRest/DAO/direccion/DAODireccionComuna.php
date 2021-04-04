<?php
/**
 ******************************************************************************
 * Sistema           :	FARMACIA V2
 * 
 * Descripcion       : Modelo para Tabla direccion_comuna
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAODireccionComuna.php
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
class DAODireccionComuna{

	protected $_tabla			=	TABLA_DIRECCION_COMUNA;
	protected $_primaria		=	"id_comuna_midas";
	protected $_transaccional	=	false;
	protected $_conn			=	null;
	protected $_respuesta		=	array();

	function __construct($conn = null) {
		if($conn !== null){
			$this->_conn =  $conn;
		}else{
			$this->_conn =  new MySQL();
		}
	}

	public function getById($id){
		$query	= "	SELECT 
						id_comuna_midas		AS	id,
						comuna_nombre		AS	gl_nombre
					FROM ".$this->_tabla."
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
		$query  = " SELECT comuna_nombre FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param  = array((int)$id);
		$result = $this->_conn->consulta($query,$param);

		if($result->num_rows>0){
			$comuna = $this->_conn->fetch_assoc($result);
			return $comuna["comuna_nombre"];
		}else{
			return NULL;
		}
	}

	
	public function getLista(){
		$query		=
		"	SELECT	id_comuna_midas		AS	id_comuna,
					comuna_nombre		AS	gl_nombre_comuna
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