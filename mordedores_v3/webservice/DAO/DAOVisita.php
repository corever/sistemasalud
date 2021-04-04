<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_visita
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOVisita.php
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
class DAOVisita{

    const ESTADO_VISITA_PERDIDA		= 1;
    const ESTADO_VISITA_REALIZADA	= 2;
    const ESTADO_VISITA_SE_NIEGA	= 3;
    const ESTADO_VISITA_PENDIENTE	= 7;
    const ESTADO_VISITA_DEVUELTA	= 9;
    const ESTADO_VISITA_INFORMADA	= 11;

    const MOTIVO_SE_NIEGA				= 1;
    const MOTIVO_SIN_MORADORES			= 2;
    const MOTIVO_DIRECCION_INEXISTENTE	= 3;
    const MOTIVO_OTRO					= 4;
    const MOTIVO_NO_ENCONTRADO			= 5;
    
    const RESULTADO_NO_PRESENTA_SINTOMAS_RABIA	= 1;
    const RESULTADO_PRESENTA_SINTOMAS_RABIA		= 2;
    const RESULTADO_SIN_DATOS					= 3;
    const RESULTADO_VISITA_PERDIDA				= 4;
    const RESULTADO_VISITA_SE_NIEGA				= 5;

    const VOLVER_VISITAR_SI				= 1;
    const VOLVER_VISITAR_NO				= 2;
    /***************************************/

    private $id = NULL; //ID FISCALIZACION
    private $usuario; //OBJ JSON USUARIO

    private $estado_visita					= NULL;
    private $fecha_efectiva_visita			= NULL;
    private $motivo_perdida_visita_id		= NULL;
    private $observacion_resultado_visita	= NULL;
    private $otro_visita					= NULL;
    private $fecha_actual					= NULL;

    /***************************************/
    protected $_tabla           = "mor_visita";
    protected $_primaria		= "id_visita";
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

    public function getByTokenFiscalizacion($token_fiscalizacion){
        $query  = " SELECT * FROM ".$this->_tabla."
                    WHERE gl_token_fiscalizacion = '".$token_fiscalizacion."'";

        $param  = array();
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene cantidad de visitas a un mordedor para un expediente
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 15/06/2018
     * @param   int $id_expediente
     * @param   int $id_mordedor
     */
    public function getCantidadVisitasByExpediente($id_expediente, $id_mordedor) {
        $query      = " SELECT COUNT(*) AS cantidad
                        FROM mor_visita_animal_mordedor visita_animal
                        LEFT JOIN mor_visita visita ON visita.id_visita = visita_animal.id_visita AND visita.id_expediente = ".(int)$id_expediente."
                        WHERE visita_animal.id_mordedor = ".(int)$id_mordedor;
        $result = $this->_conn->consulta($query);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene la ultima visita a un mordedor para este expediente
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 15/06/2018
     * @param   int $id_expediente
     * @param   int $id_mordedor
     */
    public function getUltimaVisitaMordedor($id_expediente, $id_mordedor) {
        $query      = " SELECT visita.id_visita_estado
                        FROM mor_visita_animal_mordedor visita_animal
                        LEFT JOIN mor_visita visita ON visita.id_visita = visita_animal.id_visita AND visita.id_expediente = ".(int)$id_expediente."
                        WHERE visita_animal.id_mordedor = ".(int)$id_mordedor."
                        ORDER BY visita.fc_visita DESC
                        LIMIT 1";
        $result = $this->_conn->consulta($query);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene la ultima visita a un mordedor para este expediente
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 15/06/2018
     * @param   int $id_expediente
     * @param   int $id_mordedor
     */
    public function calcularEstadoVisita($id_visita) {
        $query      = " SELECT visita_animal.id_tipo_visita_resultado as id_tipo_visita_resultado
                        FROM mor_visita_animal_mordedor visita_animal
                        WHERE visita_animal.id_visita = ".(int)$id_visita;
        $result = $this->_conn->consultaArreglo($query);

        $arr_estados_visitas_mordedores = array();
        foreach ((array)$result as $mordedor) {
            $arr_estados_visitas_mordedores[] = $mordedor["id_tipo_visita_resultado"];
        }

        
        if(in_array(self::RESULTADO_PRESENTA_SINTOMAS_RABIA, $arr_estados_visitas_mordedores)){
            return self::RESULTADO_PRESENTA_SINTOMAS_RABIA;
        }
        elseif(in_array(self::RESULTADO_VISITA_SE_NIEGA, $arr_estados_visitas_mordedores)){
            return self::RESULTADO_VISITA_SE_NIEGA;
        }
        elseif(in_array(self::RESULTADO_SIN_DATOS, $arr_estados_visitas_mordedores)){
            return self::RESULTADO_SIN_DATOS;
        }
        elseif(in_array(self::RESULTADO_NO_PRESENTA_SINTOMAS_RABIA, $arr_estados_visitas_mordedores)){
            return self::RESULTADO_NO_PRESENTA_SINTOMAS_RABIA;
        }
        else{//(in_array(self::RESULTADO_VISITA_PERDIDA, $arr_estados_visitas_mordedores))
            return self::RESULTADO_VISITA_PERDIDA;
        }
    }

    public function insert($datos_visita, $datos_json, $id_usuario){
        $fecha_actual = date("Y-m-d H:i:s");

        $json_visita = array();
        $json_visita["datos_visita"] = $datos_json;
        $json_visita["otro_visita"] = $datos_visita["otro_visita"];

        $sql = "INSERT INTO ".$this->_tabla." (
                        id_expediente,
                        id_fiscalizador,           
                        gl_token_fiscalizacion,
                        id_visita_estado,
                        id_tipo_visita_perdida,
                        bo_volver_a_visitar,
                        gl_observacion_visita,
                        bo_sintoma_rabia,
                        bo_sumario,
                        fc_visita,
                        gl_app_version,
                        json_visita,
                        gl_token_dispositivo,
                        gl_origen,
                        bo_exito_sincronizar,
                        fc_inicio_sincronizacion,
                        fc_crea,
                        fc_actualiza,
                        id_usuario_crea,
                        id_usuario_actualiza
                    )
                    VALUES (
                         ".  validar($datos_visita["id_expediente"], "numero")          ." ,
                         ".  validar($datos_visita["id_fiscalizador"], "numero")        ." ,
                        '".  validar($datos_visita["gl_token_fiscalizacion"], "string") ."',
                         ".  validar($datos_visita["id_visita_estado"],"numero")        ." ,
                         ".  validar($datos_visita["id_tipo_visita_perdida"],"numero")  ." ,
                         ".  validar($datos_visita["bo_volver_a_visitar"],"numero")  	." ,
                        '".  validar($datos_visita["gl_observacion_visita"],"string")   ."',
                         ".  validar($datos_visita["bo_sintoma_rabia"],"numero")        ." ,
                         ".  validar($datos_visita["bo_sumario"],"numero")              ." ,
                        '".  validar($datos_visita["fc_visita"],"date")                 ."',
                        '".  validar($datos_visita["gl_app_version"],"string")          ."',
                        '".  addslashes(json_encode($json_visita))                      ."',
                        '".  validar($datos_visita["gl_token_dispositivo"], "string") 	."',
                        '".  validar($datos_visita["gl_origen"], "string") 				."',
                        0,
                        '".  $fecha_actual  ."',
                        '".  $fecha_actual  ."',
                        '".  $fecha_actual  ."',
                         ".  $id_usuario    ." ,
                         ".  $id_usuario    ."
                    )";
        
        $data = $this->_conn->consulta($sql);
        $visitaId = $this->_conn->getInsertId($data);
        return $visitaId;
    }


    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

}

?>