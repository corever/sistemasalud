<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_expediente_mordedor
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOExpedienteMordedor.php
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
class DAOExpedienteMordedor{

    protected $_tabla           = "mor_expediente_mordedor";
    protected $_primaria		= "id_expediente_mordedor";
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
        $query  = " SELECT * FROM ".$this->_tabla."
                    WHERE ".$this->_primaria." = ?";

        $param  = array($id);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    public function getByFolio($gl_folio_mordedor){
        $query  = " SELECT * FROM ".$this->_tabla."
                    WHERE gl_folio_mordedor = ?";

        $param  = array($gl_folio_mordedor);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    public function getByIdMordedor($id_mordedor, $id_expediente){
        $query  = " SELECT * FROM ".$this->_tabla."
                    WHERE id_mordedor = ?
                    AND id_expediente = ?";

        $param  = array($id_mordedor, $id_expediente);
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
     * @param   int $id_expediente
     * @param   int $id_fiscalizador
     */
    public function getByFiscalizador($id_expediente, $id_fiscalizador, $bo_devuelto = false) {
        $query      = " SELECT *
                        FROM ".$this->_tabla."
                        WHERE bo_activo = 1 
                        AND id_expediente = ".(int)$id_expediente."
                        AND (id_fiscalizador = ".(int)$id_fiscalizador." OR id_fiscalizador_microchip = ".(int)$id_fiscalizador.")";
	
	if(!$bo_devuelto){
		$query .=" AND id_expediente_mordedor_estado IN (SELECT id_expediente_estado
                                                                FROM mor_expediente_estado 
                                                                WHERE bo_estado = 1
                                                                AND bo_visita = 1)";
	}
        $result = $this->_conn->consultaArreglo($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene ExpedientePaciente por Id de un Expediente
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 14/05/2018
     * @param   int $id_expediente
     */
    public function getByExpediente($id_expediente) {
        $query      = " SELECT *
                        FROM ".$this->_tabla."
                        WHERE bo_activo = 1 
                        AND id_expediente = ".(int)$id_expediente;

        $result = $this->_conn->consultaArreglo($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }


    /**
	 * Descripción : Asignar Fiscalizador
     * @author  David Guzmán <david.guzman@cosof.cl> - 05/06/2018
     * @param   string $gl_token
	 */
    public function devolverProgramacion($id_expediente_mordedor, $id_usuario){
        $query	= "	UPDATE ".$this->_tabla."
					SET 
						id_expediente_mordedor_estado   = 9,
                        id_fiscalizador                 = NULL,
                        id_fiscalizador_microchip       = NULL,
                        fc_asignado                     = NULL,
                        fc_programado                   = NULL,
                        id_usuario_actualiza            = ".intval($id_usuario).",
                        fc_actualiza                    = now()
					WHERE id_expediente_mordedor = '$id_expediente_mordedor'";
	    $result = $this->_conn->consulta($query);

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