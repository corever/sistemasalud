<?php
/**
 ******************************************************************************
 * Sistema           :	Farmacia v2
 * 
 * Descripcion       : Modelo para obtener local_recetario_tipo
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 21/09/2020
 * 
 * @name             DAOLocalRecetarioTipo.php
 * 
 * @version          1.0
 *
 * @author           Gabriel Díaz <gabriel.diaz@cosof.cl>
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
class DAOLocalRecetarioTipo{

	protected $_tabla						=	TABLA_LOCAL_RECETARIO_TIPO;
	protected $_primaria					=	"id_recetario";
	protected $_transaccional				=	FALSE;
	protected $_conn						=	NULL;
	protected $_respuesta					=	array();


	function __construct($conn = NULL) {
		if($conn !== NULL){
			$this->_conn =  $conn;
		}else{
			$this->_conn =  new MySQL();
		}
	}

	
	public function getById($id){
		$id				=	validar($id,'numero');
		$respuesta		=	NULL;

		if(!empty($id)){
			$query		=	"	SELECT * FROM ".$this->_tabla." WHERE ".$this->_primaria." = ".$id;
			$data		=	$this->_conn->consulta($query);
			$respuesta	=	$this->_conn->fetch_assoc($data);
			
			$this->_conn->dispose($data);
		}

		return	$respuesta;
	}
}