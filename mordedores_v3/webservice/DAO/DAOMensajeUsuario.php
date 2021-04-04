<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_webservice_mensaje_usuario
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 19/06/2018
 * 
 * @name             DAOMensajeUsuario.php
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
class DAOMensajeUsuario{
    protected $_tabla           = "mor_webservice_mensaje_usuario";
    protected $_primaria		= "id_mensaje_usuario";
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

    public function getExistMensajeUsuario($id_mensaje, $id_usuario){
        $query  = " SELECT EXISTS(SELECT ".$this->_primaria." FROM ".$this->_tabla."
                    WHERE id_mensaje = ? AND id_usuario_crea = ?) AS existe";

        $param  = array($id_mensaje, $id_usuario);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            $mensaje = $this->_conn->fetch_assoc($result);
            return $mensaje["existe"];
        }else{
            return false;
        }
    }

     public function insert($datos_mensaje){

        $fecha_actual = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO ".$this->_tabla." (
                        id_mensaje,
                        gl_rut,
                        gl_token_tablet,
                        gl_version,
                        id_usuario_crea,
                        fc_crea
                    )
                    VALUES (            
                         ".  validar($datos_mensaje["id_mensaje"], "numero")        ." ,
                        '".  validar($datos_mensaje["gl_rut"], "string")            ."',
                        '".  validar($datos_mensaje["gl_token_tablet"], "string")   ."',
                        '".  validar($datos_mensaje["gl_version"], "string")        ."',
                         ".  validar($datos_mensaje["id_usuario_crea"], "numero")   ." ,
                        '".  $fecha_actual                                          ."'
                    )";
        
        $data = $this->_conn->consulta($sql);
        $mensajeUsuarioId = $this->_conn->getInsertId($data);

        return $mensajeUsuarioId;
    }


    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }
}

?>