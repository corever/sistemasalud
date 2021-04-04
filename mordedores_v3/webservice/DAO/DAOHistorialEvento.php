<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_historial_evento
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOHistorialEvento.php
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
class DAOHistorialEvento{
    const HISTORIAL_VISITA_REALIZADA = 12;
    const HISTORIAL_VISITA_PERDIDA = 13;

    protected $_tabla           = "mor_historial_evento";
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

    public function getEventoExpedienteDevuelto($id_expediente, $id_usuario, $fecha ){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE id_expediente = ".validar($id_expediente 	,'numero')."
                    AND id_usuario_crea = ".validar($id_usuario		,'numero')."
                    AND id_evento_tipo = 16 ";

        if(!empty($fecha)){
    		$fecha_devuelta	= formatearFechaHoraBD($fecha, $separador = "/");
    		$query .= " AND fc_crea = '".$fecha_devuelta."'";
    	}

        $result = $this->_conn->consultaArreglo($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    public function insertHistorialExpediente($datos_historial_evento){
    	if(!empty($datos_historial_evento['fc_crea'])){
    		$fecha_actual	= formatearFechaHoraBD($datos_historial_evento['fc_crea'], $separador = "/");
    	}else{
        	$fecha_actual = date("Y-m-d H:i:s");
    	}

        $sql = "INSERT INTO ".$this->_tabla." (
                        id_evento_tipo,
                        id_expediente,
                        gl_descripcion,
                        id_usuario_crea,
                        fc_crea
                    )
                    VALUES (
                         ".  validar($datos_historial_evento['id_evento_tipo']  ,"numero")    ." ,
                         ".  validar($datos_historial_evento['id_expediente']   ,"numero")    ." ,
                        '".  validar($datos_historial_evento['gl_descripcion']  ,"string")    ."',
                         ".  $datos_historial_evento['id_usuario']  ." ,
                        '".  $fecha_actual  							."'
                    )";
                    
        $data = $this->_conn->consulta($sql);
        $historialId = $this->_conn->getInsertId($data);
        return $historialId;
    }

    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

}

?>