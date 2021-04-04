<?php
/**
 ******************************************************************************
 * Sistema           :	Farmacia v2
 * 
 * Descripcion       : Modelo para obtener local_horario
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 23/09/2020
 * 
 * @name             DAOLocalHorario.php
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
class DAOLocalHorario{

	protected $_tabla						=	TABLA_LOCAL_HORARIO;
	protected $_primaria					=	"id_horario";
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

	public function insert($parametros){
		$sql		=
		"	INSERT INTO ".$this->_tabla." (
				id_local,
				bo_continuado,
				bo_activo,
				json_lunes,
				json_martes,
				json_miercoles,
				json_jueves,
				json_viernes,
				json_sabado,
				json_domingo,
				json_festivos
			)	VALUES (
				".	validar($parametros["id_local"],		"numero")	.	",
				".	validar($parametros["bo_continuado"],	"boolean")	.	",
				1,
				'".	$parametros["json_lunes"]							.	"',
				'".	$parametros["json_martes"]							.	"',
				'".	$parametros["json_miercoles"]						.	"',
				'".	$parametros["json_jueves"]							.	"',
				'".	$parametros["json_viernes"]							.	"',
				'".	$parametros["json_sabado"]							.	"',
				'".	$parametros["json_domingo"]							.	"',
				'".	$parametros["json_festivos"]						.	"'
		)";
        
        $data		=	$this->_conn->consulta($sql);
        $visitaId	=	$this->_conn->getInsertId($data);
        return	$visitaId;
	}

	public function update($parametros, $id){
		$this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
	}

	public function inhabilitarAnteriores($id_local){
		$id_local		=	validar($id_local,"numero");
		if($id_local > 0){
			$sql	=
			"	UPDATE	".	$this->_tabla	."
				SET		bo_activo	=	0
				WHERE	id_local	=	$id_local
			";
			$this->_conn->consulta($sql);
		}
	}

	

}