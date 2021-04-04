<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_adjunto
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOAdjunto.php
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
class DAOAdjunto{
    const PATH_DIRECTORIO       = '../archivos/';
    const PATH_SUB_DIRECTORIO   = 'documentos/';
    protected $_tabla           = "mor_adjunto";
    protected $_primaria		= "id_adjunto";
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

    public function insert($datos_adjunto){

        $fecha_actual = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO ".$this->_tabla." (
                        gl_token,
                        id_expediente,
                        id_visita,
                        id_paciente,
                        id_fiscalizador,
                        id_mordedor,
                        id_adjunto_tipo,
                        gl_nombre,
                        gl_path,
                        gl_glosa,
                        id_usuario_crea,
                        fc_crea
                    )
                    VALUES (            
                        '".  hash("sha512", $datos_adjunto["gl_token"])             ."',
                         ".  validar($datos_adjunto["id_expediente"], "numero")     ." ,
                         ".  validar($datos_adjunto["id_visita"], "numero")         ." ,
                         ".  validar($datos_adjunto["id_paciente"], "numero")       ." ,
                         ".  $datos_adjunto["id_usuario"]                           ." ,
                         ".  validar($datos_adjunto["id_mordedor"], "numero")       ." ,
                         ".  validar($datos_adjunto["id_adjunto_tipo"], "numero")   ." ,
                        '".  $datos_adjunto["gl_nombre"]                  ."',
                        '".  $datos_adjunto["gl_path"]                    ."',
                        '".  $datos_adjunto["gl_glosa"]                   ."',
                         ".  $datos_adjunto["id_usuario"]                 ." ,
                        '".  $fecha_actual  ."'
                    )";
        
        $data = $this->_conn->consulta($sql);
        $adjuntoId = $this->_conn->getInsertId($data);

        return $adjuntoId;
    }

    public function getCantidadAdjuntosByIdVisita($id){
        $query  = " SELECT count(*) AS total FROM ".$this->_tabla."
                    WHERE id_visita = ?";

        $param  = array($id);
        $result = $this->_conn->consulta($query,$param);
        $total = $this->_conn->fetch_assoc($result);

        return (int)$total["total"];
    }


    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }
}

?>