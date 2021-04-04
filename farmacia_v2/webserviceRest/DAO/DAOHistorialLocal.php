<?php
/**
 ******************************************************************************
 * Sistema			:	Farmacias v2
 * 
 * Descripcion		:	Modelo para Tabla historial_local
 *
 * Plataforma		:	!PHP
 * 
 * Creacion			:	21/09/2020
 * 
 * @name			DAOHistorialLocal.php
 * 
 * @version			1.0
 *
 * @author			Gabriel Díaz <gabriel.diaz@cosof.cl>
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
class DAOHistorialLocal{

	protected $_tabla							=	TABLA_LOCAL_HISTORIAL;
	protected $_primaria						=	"id_evento";
	protected $_transaccional					=	FALSE;
	protected $_conn							=	NULL;
	protected $_respuesta						=	array();
	
	const	HISTORIAL_LOCAL_CREACION			=	1;
	const	HISTORIAL_LOCAL_EDICION				=	2;
	const	HISTORIAL_LOCAL_HABILITA			=	3;
	const	HISTORIAL_LOCAL_PROG_HABILITA		=	4;
	const	HISTORIAL_LOCAL_DESHABILITA			=	5;
	const	HISTORIAL_LOCAL_PROG_DESHABILITA	=	6;
	const	HISTORIAL_LOCAL_CREACION_WS			=	7;
	const	HISTORIAL_LOCAL_EDICION_WS			=	8;

	function __construct($conn = null) {
		if($conn !== null){
			$this->_conn						=	$conn;
		}else{
			$this->_conn						=	new MySQL();
		}
	}

	public function insert($datos){
		$sql		=
		"	INSERT INTO ".$this->_tabla." (
				id_historial_tipo,
				id_local,
				gl_descripcion
			)VALUES (
				".	validar($datos["id_evento_tipo"],	"numero")	." ,
				".	validar($datos["id_local"],			"numero")	." ,
				'".	validar($datos["gl_descripcion"],	"string")	."'
		)";
		
		$data		=	$this->_conn->consulta($sql);
		$id			=	$this->_conn->getInsertId($data);
		return	$id;
	}

	function cerrar_conexion(){
		$this->_conn->cerrar_conexion();
	}

}
?>