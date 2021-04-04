<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_expediente
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOExpediente.php
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
class DAODueno{

    protected $_tabla           = "mor_dueno";
    protected $_primaria		= "id_dueno";
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

    public function getByRut($rut){
        $query  = " SELECT * FROM ".$this->_tabla."
                    WHERE gl_rut = ?";

        $param  = array($rut);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    public function getDuenoMordedor($id){
        $query  = " SELECT 
                        mor_dueno.gl_nombre,
                        mor_dueno.gl_apellido_paterno,
                        mor_dueno.gl_apellido_materno,
                        mor_dueno.bo_rut_informado,
                        mor_dueno.gl_rut,
                        mor_dueno.bo_extranjero,
                        mor_dueno.gl_pasaporte,
                        mor_dueno.gl_email,
                        mor_dueno.json_contacto,
                        mor_dueno.json_direccion,
                        mor_dueno.departamento_dueno,
                        mor_dueno.domicilio_ref,
                        mor_direccion_region.id_region,
                        mor_direccion_comuna.id_comuna,
                        mor_direccion_region.gl_nombre_region AS nombre_region,
                        mor_direccion_comuna.gl_nombre_comuna AS nombre_comuna
                    FROM mor_dueno
                        LEFT JOIN mor_direccion_region ON mor_direccion_region.id_region = mor_dueno.id_region
                        LEFT JOIN mor_direccion_comuna ON mor_direccion_comuna.id_comuna = mor_dueno.id_comuna
                    WHERE ".$this->_primaria." = ?";

        $param  = array($id);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    public function insert($datos_dueno){

        $json_direccion = array(
            "direccion" => $datos_dueno['direccion'],
            "referencia_direccion" => $datos_dueno['referencia_direccion'],
            "departamento_direccion" => $datos_dueno['departamento_direccion']
            );

        $json_contacto = array('telefono_propietario' => $datos_dueno['telefono_propietario']);

        $fecha_actual = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO ".$this->_tabla." (
                        gl_nombre,
                        gl_token,
                        gl_apellido_paterno,
                        gl_apellido_materno,
                        bo_rut_informado,
                        bo_extranjero,
                        gl_rut,
                        gl_pasaporte,
                        id_region,
                        id_comuna,
                        gl_email,
                        json_contacto,
                        json_direccion,
                        fc_crea,
                        fc_actualiza,
                        id_usuario_crea,
                        id_usuario_actualiza
                    )
                    VALUES (
                        '".  validar($datos_dueno['gl_nombre'],"string")           ."',
                        '".  validar($datos_dueno['gl_token'],"string")            ."',
                        '".  validar($datos_dueno['gl_apellido_paterno'],"string") ."',
                        '".  validar($datos_dueno['gl_apellido_materno'],"string") ."',
                         ".  validar($datos_dueno['bo_rut_informado'],"numero")    ." ,
                         ".  validar($datos_dueno['bo_extranjero'],"numero")       ." ,
                        '".  validar($datos_dueno['gl_rut'],"string")              ."',
                        '".  validar($datos_dueno['gl_pasaporte'],"string")        ."',
                         ".  validar($datos_dueno['id_region'],"numero")           ." ,
                         ".  validar($datos_dueno['id_comuna'],"numero")           ." ,
                        '".  validar($datos_dueno['gl_email'],"string")            ."',
                        '".  json_encode($json_contacto, JSON_UNESCAPED_UNICODE)   ."',
                        '".  json_encode($json_direccion, JSON_UNESCAPED_UNICODE)  ."',
                        '".  $fecha_actual                          ."',
                        '".  $fecha_actual                          ."',
                         ".  $datos_dueno['id_usuario']             ." ,
                         ".  $datos_dueno['id_usuario']             ."
                    )";
        
        $data = $this->_conn->consulta($sql);
        $duenoId = $this->_conn->getInsertId($data);
        return $duenoId;
    }

    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

}

?>