<?php
/**
 ******************************************************************************
 * Sistema           :	FARMACIA V2
 * 
 * Descripcion       : Modelo para Tabla territorio
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 21/09/2020
 * 
 * @name             DAODireccionTerritorio.php
 * 
 * @version          1.0
 *
 * @author           Gabriel Díaz <gabriel.diaz@cosof.cl>
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
class DAODireccionTerritorio{

    protected $_tabla				=	TABLA_DIRECCION_TERRITORIO;
    protected $_primaria			=	"territorio_id";
    protected $_transaccional		=	false;
    protected $_conn				=	null;
    protected $_respuesta			=	array();

    function __construct($conn = null) {
        if($conn !== null){
            $this->_conn =  $conn;
        }else{
            $this->_conn =  new MySQL();
        }
    }

    public function getLista(){
        $query		= "	SELECT * FROM ".$this->_tabla;
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

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }
    
}

?>