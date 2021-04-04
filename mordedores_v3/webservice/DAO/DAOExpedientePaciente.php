<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_expediente_paciente
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOExpedientePaciente.php
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
class DAOExpedientePaciente{

    protected $_tabla           = "mor_expediente_paciente";
    protected $_primaria		= "id_expediente_paciente";
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

    /**
     * Descripción : Obtiene ExpedientePaciente por Id de un Expediente
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 14/05/2018
     * @param   int $id_provincia
     */
    public function getByIdExpediente($id) {
        $query      = " SELECT * 
                        FROM ".$this->_tabla."
                        WHERE id_expediente = ?";

        $param  = array($id);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene ExpedientePaciente por Id de un Paciente
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 14/05/2018
     * @param   int $id_provincia
     */
    public function getByIdPaciente($id) {
        $query      = " SELECT * 
                        FROM ".$this->_tabla."
                        WHERE id_paciente = ?";

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