<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_visita_animal_vacuna
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 15/05/2018
 * 
 * @name             DAOVisitaAnimalVacuna.php
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
class DAOVisitaAnimalVacuna{

    protected $_tabla           = "mor_visita_animal_vacuna";
    protected $_primaria		= "id_visita_animal_vacuna";
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

    public function insert($datos_vacuna,$id_usuario,$id_visita, $id_mordedor){

        $fecha_actual = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO ".$this->_tabla." (
                        id_animal_vacuna,
                        id_visita,
                        id_mordedor,
                        id_tipo_vacuna,
                        gl_microchip,
                        gl_certificado_vacuna,
                        gl_numero_serie_vacuna,
                        id_laboratorio,
                        gl_laboratorio,
                        fc_vacunacion,
                        fc_caducidad_vacuna,
                        id_duracion_inmunidad,
                        gl_medicamento,
                        json_otros_datos,
                        fc_crea,
                        fc_actualiza,
                        id_usuario_crea,
                        id_usuario_actualiza
                    )
                    VALUES (
                        null, 
                         ".  validar($id_visita,"numero")    ." ,
                         ".  validar($id_mordedor,"numero")  ." ,
                         ".  validar($datos_vacuna["id_tipo_vacuna"],"numero")          .",
                        '".  validar($datos_vacuna["gl_microchip"],"string")            ."',
                        '".  validar($datos_vacuna["gl_certificado_vacuna"],"string")   ."',
                        '".  validar($datos_vacuna["gl_numero_serie_vacuna"],"string")  ."',
                         ".  validar($datos_vacuna["id_laboratorio"],"numero")          .",
                        '".  validar($datos_vacuna["gl_laboratorio"],"string")          ."',
                        '".  validar($datos_vacuna["fc_vacunacion"],"date")             ."',
                        '".  validar($datos_vacuna["fc_caducidad_vacuna"],"date")       ."',
                         ".  validar($datos_vacuna["id_duracion_inmunidad"],"numero")   ." ,
                        '".  validar($datos_vacuna["gl_medicamento"],"string")          ."',
                        '".  json_encode($datos_vacuna["json_otros_datos"])             ."',
                        '".  $fecha_actual                          ."',
                        '".  $fecha_actual                          ."',
                         ".  $id_usuario                            ." ,
                         ".  $id_usuario                            ."
                    )";
        $data = $this->_conn->consulta($sql);
        $vacunaId = $this->_conn->getInsertId($data);

        return $vacunaId;
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

}

?>