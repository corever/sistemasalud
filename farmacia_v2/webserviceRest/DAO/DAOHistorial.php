<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla historial_evento
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 12/03/2019
 * 
 * @name             DAOHistorial.php
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
class DAOHistorial{

    const TIPO_EVENTO_REGISTRO_ASIGNACION		=	1;	//Registro de Asignación
	const TIPO_EVENTO_CREACION_MENSAJE			=	2;	//Se Crea Mensaje Usuario
	const TIPO_EVENTO_MENSAJE_VISUALIZADO		=	3;	//Mensaje Usuario Visualizado
	const TIPO_EVENTO_LOGIN_APP					=	4;	//Login en App
	const TIPO_EVENTO_RESPALDO_LOG				=	5;	//Se respalda Log
	const TIPO_EVENTO_ASIGNA_FISCALIZADOR		=	6;	//Se asigna Fiscalizador
	const TIPO_EVENTO_REASIGNA_FISCALIZADOR		=	7;	//Se reasigna Fiscalizador
	const TIPO_EVENTO_RESPALDO_ADJUNTO			=	8;	//Se respalda Adjunto
	const TIPO_EVENTO_RESPALDO_VISITA			=	9;	//Se respalda Visita
	const TIPO_EVENTO_GUARDADO_ADJUNTO			=	10;	//Se guarda Adjunto
	const TIPO_EVENTO_VISITA_REALIZADA			=	11;	//Visita Realizada
	const TIPO_EVENTO_VISITA_PERDIDA			=	12;	//Visita Perdida
	const TIPO_EVENTO_VISITA_SIN_ESTADO			=	13;	//Visita Sin Estado
	const TIPO_EVENTO_ASIGNACION_DEVUELTO		=	14;	//Asignación Devuelta
	const TIPO_EVENTO_CERRAR_VISITA				=	15;	//Se cierra visita
	const TIPO_EVENTO_ESPERA_CONFIRMACION		=	16;	//Espera de Confirmación desde Mis Fiscalizaciones
	const TIPO_EVENTO_VISITA_CONFIRMADA			=	17;	//Fiscalización Confirmada desde Mis Fiscalizaciones

    protected $_tabla           = PREFIJO_BD    .   "historial_evento_asignacion";
    protected $_primaria		= "id_evento";
    protected $_transaccional	= false;
    protected $_conn            = null;
    protected $_respuesta       = array();

    function __construct($conn = null) {
        if($conn !== null){
            $this->_conn =  $conn;
        }else{
            $this->_conn =  new MySQL();
        }
        /***/
        $this->fecha_actual = date("Y-m-d H:i:s");
        /***/
    }
    
    public function insert($datos){
        $fc_actual	=	date("Y-m-d H:i:s");
		$sql		=
		"	INSERT INTO ".$this->_tabla." (
				id_evento_tipo,
				id_asignacion,
				gl_descripcion,
				id_usuario_crea
			)VALUES (
				".	validar($datos["id_evento_tipo"],	"numero")	." ,
				".	validar($datos["id_asignacion"],	"numero")	." ,
				'".	validar($datos["gl_descripcion"],	"string")	."',
				".	validar($datos["id_usuario_crea"],	"numero")	." 
		)";
        
        $data		=	$this->_conn->consulta($sql);
        $visitaId	=	$this->_conn->getInsertId($data);
        return	$visitaId;
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

}
?>