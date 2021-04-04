<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente_alarma
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 13/06/2018
 * 
 * @name             DAOPacienteAlarma.php
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
class DAOPacienteAlarma{
    protected $_tabla           = "mor_paciente_alarma";
    protected $_primaria		= "id_alarma";
    protected $_conn            = null;

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

    public function getByIdExpediente($id){
        $query  = " SELECT * FROM ".$this->_tabla."
                    WHERE id_expediente = ?";

        $param  = array($id);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }


    public function insert($datos_alarma){
        $sql = "INSERT INTO ".$this->_tabla." (
                        id_expediente,
                        id_paciente,
                        id_tipo_alarma,
                        id_perfil,
                        id_alarma_estado,
                        id_usuario_crea
                    )
                    VALUES (            
                         ".  validar($datos_alarma["id_expediente"]     , "numero") ." ,
                         ".  validar($datos_alarma["id_paciente"]       , "numero") ." ,
                         ".  validar($datos_alarma["id_tipo_alarma"]    , "numero") ." ,
                         ".  validar($datos_alarma["id_perfil"]         , "numero") ." ,
                         ".  validar($datos_alarma["id_alarma_estado"]  , "numero") ." ,
                         ".  $datos_alarma["id_usuario"]    ."
                    )";
        
        $data = $this->_conn->consulta($sql);
        $pacienteAlarmaId = $this->_conn->getInsertId($data);

        return $pacienteAlarmaId;
    }


    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }
}

?>