<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente_contacto_tipo
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOTipoContacto.php
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

class DAOTipoContacto{
    const TIPO_CONTACTO_TELEFONO_FIJO = 1;
    const TIPO_CONTACTO_TELEFONO_MOVIL = 2;
    const TIPO_CONTACTO_DIRECCION = 3;
    const TIPO_CONTACTO_EMAIL = 4;
    const TIPO_CONTACTO_CASILLA_POSTAL = 5;

    protected $_tabla           = "mor_tipo_contacto";
    protected $_primaria        = "id_tipo_contacto";
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

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

}
?>