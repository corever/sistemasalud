<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_visita_animal_mordedor
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOVisitaAnimalMordedor.php
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
class DAOVisitaAnimalMordedor{
    protected $_tabla           = "mor_visita_animal_mordedor";
    protected $_primaria		= "id_visita_mordedor";
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

    public function getByIdVisita($id){
        $query  = "SELECT * FROM ".$this->_tabla."
                    WHERE id_visita = ".$id;
        $result = $this->_conn->consultaArreglo($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    public function getTotalByIdVisita($id){
        $query  = " SELECT count(*) AS total FROM ".$this->_tabla."
                    WHERE id_visita = ?";

        $param  = array($id);
        $result = $this->_conn->consulta($query,$param);
        $total = $this->_conn->fetch_assoc($result);
        //file_put_contents('php://stderr', PHP_EOL . print_r($total, TRUE). PHP_EOL, FILE_APPEND);
        return (int)$total["total"];
    }

    public function insert($datos_visita_mordedor,$id_usuario){

        $fecha_actual = date("Y-m-d H:i:s");
        
        /**
         * [bo_antirrabica_vigente No es Boolean, es un ID]
         */
        $sql = "INSERT INTO ".$this->_tabla." (
                        id_visita,
                        id_mordedor,
                        id_dueno,
                        id_animal_estado,
                        gl_microchip,
                        id_estado_microchip,
                        bo_vive_con_dueno,
                        bo_callejero,
                        id_estado_productivo,
                        bo_antirrabica_vigente,
                        json_mordedor,
                        json_dueno,
                        json_tipo_sintoma,
                        gl_descripcion,
                        fc_eutanasia,
                        id_tipo_visita_resultado,
                        id_region_mordedor,
                        gl_observacion_visita,
                        id_visita_estado,
                        id_tipo_visita_perdida,
                        bo_sumario,
                        fc_descargos,
                        fc_crea,
                        fc_actualiza,
                        id_usuario_crea,
                        id_usuario_actualiza
                    )
                    VALUES (
                         ".  validar($datos_visita_mordedor["id_visita"]     ,"numero")  ." ,
                         ".  validar($datos_visita_mordedor["id_mordedor"]   ,"numero")  ." ,
                         ".  validar($datos_visita_mordedor["id_dueno"]      ,"numero")  ." ,
                        
                        '".  validar($datos_visita_mordedor["id_animal_estado"]        , "numero") ."',
                        '".  validar($datos_visita_mordedor["gl_microchip"]            , "string") ."',
                         ".  validar($datos_visita_mordedor["id_estado_microchip"]     , "numero") ." ,
                        '".  validar($datos_visita_mordedor["bo_vive_con_dueno"]       , "numero") ."',
                        '".  validar($datos_visita_mordedor["bo_callejero"]            , "numero") ."',
                        '".  validar($datos_visita_mordedor["id_estado_productivo"]    , "numero") ."',
                        '".  validar($datos_visita_mordedor["bo_antirrabica_vigente"]  , "numero") ."',

                        '".  addslashes(json_encode($datos_visita_mordedor["json_mordedor"]))          ."',
                        '".  addslashes(json_encode($datos_visita_mordedor["json_dueno"]))             ."',
                        '".  addslashes(json_encode($datos_visita_mordedor["json_tipo_sintoma"]))      ."',

                        '".  validar($datos_visita_mordedor["gl_descripcion"], "string")   ."',
                        '".  validar($datos_visita_mordedor["fc_eutanasia"]  , "date")     ."',
                        '".  validar($datos_visita_mordedor["id_tipo_visita_resultado"]  , "numero") ."',
                        '".  validar($datos_visita_mordedor["id_region_mordedor"], "numero") ."',

                        '".  validar($datos_visita_mordedor["gl_observacion_visita"], "string") ."',
                        '".  validar($datos_visita_mordedor["id_visita_estado"], "numero") ."',
                        '".  validar($datos_visita_mordedor["id_tipo_visita_perdida"], "numero") ."',
                        '".  validar($datos_visita_mordedor["bo_sumario"], "numero") ."',
                        '".  validar($datos_visita_mordedor["fc_descargos"], "date") ."',

                        '".  $fecha_actual                          ."',
                        '".  $fecha_actual                          ."',
                         ".  $id_usuario                            ." ,
                         ".  $id_usuario                            ."
                    )";
        $data = $this->_conn->consulta($sql);
        $id_visita_mordedor = $this->_conn->getInsertId($data);

        return $id_visita_mordedor;
    }

    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

}

?>