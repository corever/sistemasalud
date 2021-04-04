<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOPaciente.php
 * 
 * @version          1.0
 *
 * @author           Pablo Jimenez <pablo.jimenez@cosof.cl>
 * 
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador                !cFecha     !cDescripcion 
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
class DAOPaciente{

    protected $_tabla           = "mor_paciente";
    protected $_primaria        = "id_paciente";
    protected $_transaccional   = false;
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
        $query  = " SELECT * FROM ".$this->_tabla;
        $result = $this->_conn->consultaArreglo($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    public function getById($id){
        $query  = " SELECT  *
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

    /**
     * Descripción : Obtiene detalle de Paciente por Rut
     * @author  Pablo Jimenez <pablo.jimenez@cosof.cl> - 14/05/2018
     * @param   string $gl_rut 
     */
    public function getByRut($gl_rut) {
        $query = "  SELECT 
                        *
                    FROM mor_paciente
                    WHERE gl_rut = ?";

        $param      = array($gl_rut);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    public function getInformacionPaciente($id){
        //JSON_DATOS_CONTACTO = {domicilio, correo, celular, departamento_paciente}      
        
        $query  = " SELECT  
                        mor_paciente.id_paciente,
                        mor_paciente.gl_token AS token,
                        mor_paciente.gl_rut AS rut,
                        mor_paciente.gl_nombres AS nombres,
                        mor_paciente.gl_apellido_paterno AS apellido_paterno,
                        mor_paciente.gl_apellido_materno AS apellido_materno,
                        mor_paciente.id_paciente_estado,
                        mor_paciente.id_usuario_actualiza,
                        mor_paciente.id_usuario_crea,
                        mor_paciente.id_comuna,
                        mor_paciente.fc_crea AS fecha_crea,
                        mor_paciente.fc_actualiza AS fecha_actualiza,
                        mor_paciente.id_region,
                        mor_paciente.bo_rut_informado,
                        mor_paciente_datos.bo_extranjero,
                        mor_paciente_datos.id_nacionalidad,
                        mor_paciente_datos.id_pais_origen,
                        mor_paciente_datos.gl_nacionalidad AS nacionalidad,
                        mor_paciente_datos.json_pasaporte,
                        mor_paciente_datos.id_prevision,
                        mor_paciente_datos.id_tipo_sexo,
                        mor_paciente_datos.fc_nacimiento AS fecha_nacimiento,
                        mor_paciente_datos.nr_edad AS edad,
                        mor_paciente_datos.bo_paciente_datos_estado,
                        mor_expediente_paciente.bo_mordedor_misma_casa,
                        mor_expediente_paciente.id_expediente,
                        mor_expediente_paciente.bo_dueno_mordedor
                    FROM ".$this->_tabla."
                    LEFT JOIN mor_paciente_datos ON mor_paciente_datos.id_paciente = ".$this->_tabla.".".$this->_primaria."
                    LEFT JOIN mor_expediente_paciente ON mor_expediente_paciente.id_paciente = ".$this->_tabla.".".$this->_primaria."
                    WHERE ".$this->_primaria." = ?";

        $param  = array($id);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    public function getInformacionPacienteByIdExpediente($id){        
        $query  = " SELECT  
                        mor_paciente.id_paciente,
                        mor_paciente.gl_token AS token,
                        mor_paciente.gl_rut AS rut,
                        mor_paciente.gl_nombres AS nombres,
                        mor_paciente.gl_apellido_paterno AS apellido_paterno,
                        mor_paciente.gl_apellido_materno AS apellido_materno,
                        mor_paciente.id_paciente_estado,
                        mor_paciente.id_usuario_actualiza,
                        mor_paciente.id_usuario_crea,
                        mor_paciente.id_comuna,
                        comuna.gl_nombre_comuna AS comuna,
                        mor_paciente.fc_crea AS fecha_crea,
                        mor_paciente.fc_actualiza AS fecha_actualiza,
                        mor_paciente.id_region,
                        mor_paciente.bo_rut_informado,
                        mor_paciente_datos.bo_extranjero,
                        mor_paciente_datos.id_nacionalidad,
                        mor_paciente_datos.id_pais_origen,
                        pais_origen.gl_nombre_pais AS pais_origen,
                        mor_paciente_datos.gl_nacionalidad AS nacionalidad,
                        mor_paciente_datos.json_pasaporte,
                        mor_paciente_datos.id_prevision,
                        mor_paciente_datos.id_tipo_sexo,
                        mor_paciente_datos.fc_nacimiento AS fecha_nacimiento,
                        mor_paciente_datos.nr_edad AS edad,
                        mor_paciente_datos.bo_paciente_datos_estado,
                        mor_expediente_paciente.bo_mordedor_misma_casa,
                        mor_expediente_paciente.bo_dueno_mordedor
                    FROM ".$this->_tabla."
                    LEFT JOIN mor_paciente_datos ON mor_paciente_datos.id_paciente = ".$this->_tabla.".".$this->_primaria."
                    LEFT JOIN mor_expediente_paciente ON mor_expediente_paciente.id_paciente = ".$this->_tabla.".".$this->_primaria."
                    LEFT JOIN mor_direccion_pais pais_origen ON pais_origen.id_pais = mor_paciente_datos.id_pais_origen
                    LEFT JOIN mor_direccion_comuna comuna ON comuna.id_comuna = mor_paciente.id_comuna
                    WHERE id_expediente = ?";

        $param  = array($id);
        $result = $this->_conn->consultaArreglo($query,$param);

        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    public function getDatosContactoByIdPaciente($id){        
        $query  = " SELECT json_dato_contacto
                    FROM mor_paciente_contacto
                    WHERE id_paciente = ?";

        $param  = array($id);
        $result = $this->_conn->consultaArreglo($query,$param);

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