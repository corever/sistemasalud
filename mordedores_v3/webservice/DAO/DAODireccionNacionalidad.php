<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_direccion_nacionalidad
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAODireccionNacionalidad.php
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
class DAODireccionNacionalidad{

    protected $_tabla			= "mor_direccion_nacionalidad";
    protected $_primaria		= "id_nacionalidad";
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

    /**
	 * Descripción : Obtiene Nacionalidades por Id de Pais
	 * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 14/05/2018
     * @param   int $id_pais
	 */
    public function getByIdPais($id_pais) {
        $query		= "	SELECT * 
						FROM mor_direccion_nacionalidad
						WHERE id_pais = ?";

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