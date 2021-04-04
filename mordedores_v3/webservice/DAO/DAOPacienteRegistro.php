<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente_registro
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOPacienteRegistro.php
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
class DAOPacienteRegistro{

    protected $_tabla		= "mor_paciente_registro";
    protected $_primaria	= "id_registro";
    protected $_transaccional	= false;
    protected $_conn            = null;
    protected $_respuesta       = array();

    function __construct($conn = null) {
        if($conn !== null){
            $this->_conn =  $conn;
        }else{
            $this->_conn =  new MySQL();
        }
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
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param  = array($id);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene detalle de consultas por Id de Paciente
     * @author  Pablo Jimenez <pablo.jimenez@cosof.cl> 14/05/2018
     * @param   int $id_paciente
	 */
    public function getByIdPaciente($id_paciente) {
        $query = "  SELECT 
                        registro.id_registro,
                        registro.id_paciente,
                        registro.id_institucion,
                        date_format(registro.fc_ingreso, '%d-%m-%Y') AS fc_ingreso,
                        registro.gl_hora_ingreso, 
                        registro.gl_motivo_consulta,
                        date_format(registro.fc_crea,'%d-%m-%Y') AS fc_crea,
                        registro.id_usuario_crea AS id_usuario_crea,
                        usu.gl_nombres,
                        usu.gl_apellidos,
                        usu.gl_rut AS rut,
                        es.gl_nombre_establecimiento AS nombre_establecimiento_salud,
                        es.gl_direccion_establecimiento AS direccion_establecimiento_salud,
                        es.gl_telefono AS telefono_establecimiento_salud
                    FROM mor_paciente_registro registro
                    LEFT JOIN mor_acceso_usuario usu ON usu.id_usuario = registro.id_usuario_crea
                    LEFT JOIN mor_establecimiento_salud es ON es.id_establecimiento = registro.id_institucion
                    WHERE id_paciente = ?
                    ORDER BY registro.id_registro DESC";

        $param  = array($id);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }
    
    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }
}

?>